<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Utilities\Constant;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Voucher;
use App\Service\Order\OrderServiceInterface;
use App\Service\OrderDetail\OrderDetailServiceInterface;
use App\Utilities\VNPay;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CheckOutController extends Controller
{
    private $orderService;
    private $orderDetailService;

    public function __construct(OrderServiceInterface $orderService, OrderDetailServiceInterface $orderDetailService)
    {
        $this->orderService = $orderService;
        $this->orderDetailService = $orderDetailService;
    }

    public function index ()
    {
        if (!Auth::check()) {     
            return redirect('/account/login')->with('error', 'Vui lòng đăng nhập để tiến hành thanh toán.');
        }

        $user = Auth::user();

        $requiredFields = ['name', 'email', 'phone', 'street_address', 'town_city', 'district'];
        $isShippingInfoComplete = true;

        foreach ($requiredFields as $field) {       
            if (empty($user->$field)) {
                $isShippingInfoComplete = false;
                break;
            }
        }
        if (!$isShippingInfoComplete) {
            return redirect('./account/profile-info')
                ->with('error', 'Vui lòng cập nhật đầy đủ thông tin nhận hàng để tiến hành thanh toán.');
        }

        $carts = Cart::content();
        $total = Cart::priceTotal(0, '', '');
        $subtotal = Cart::subtotal(0, '', '');

        return view('front.checkout.index', compact('carts', 'total', 'subtotal'));
    }

    public function applyVoucher(Request $request)
    {
        try {
            $code = strtoupper(trim($request->input('code')));
                   
            $subtotal = floatval($request->input('subtotal')); 
            $shippingFee = floatval($request->input('shipping_fee', 0));
            
                       
            // 1. Kiểm tra voucher có tồn tại không
            $voucher = Voucher::where('code', $code)->first();
            
            if (!$voucher) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mã khuyến mãi không tồn tại!'
                ]);
            }

            // 2. Kiểm tra thời gian áp dụng
            $now = Carbon::now();
            $startDate = Carbon::parse($voucher->start_date)->startOfDay();
            $endDate = Carbon::parse($voucher->end_date)->endOfDay();

            if ($now->lt($startDate)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mã khuyến mãi chưa đến thời gian áp dụng!'
                ]);
            }

            if ($now->gt($endDate)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mã khuyến mãi đã hết hạn!'
                ]);
            }

            // 3. Kiểm tra số lượng
            if ($voucher->qty <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mã khuyến mãi đã hết lượt sử dụng!'
                ]);
            }

            // 4. Kiểm tra giá trị đơn hàng tối thiểu
    
            if ($voucher->min_total_value && $voucher->min_total_value > 0) {
                $minValueInRealMoney = $voucher->min_total_value; 
                
                if ($subtotal < $minValueInRealMoney) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Đơn hàng tối thiểu phải đạt ' . number_format($minValueInRealMoney, 0, ',', '.') . 'đ để áp dụng mã này!'
                    ]);
                }
            }

            // 5. Tính toán giảm giá
            $discountAmount = 0;

            if ($voucher->type == 1) {
                // Giảm theo phần trăm
                $discountAmount = ($subtotal * $voucher->reduce) / 100;
                
                // Kiểm tra giảm tối đa (nếu có)
                if ($voucher->max_discount && $voucher->max_discount > 0) {
                    if ($discountAmount > $voucher->max_discount) {
                        $discountAmount = $voucher->max_discount;
                    }
                }
            } else {
         
                $discountAmount = $voucher->reduce;
        
                if ($discountAmount > $subtotal) {
                    $discountAmount = $subtotal;
                }
            }

            // 6. Tính tổng tiền sau giảm
            $finalTotal = $subtotal - $discountAmount + $shippingFee;
            
            // 7. Lưu voucher vào session (để sử dụng khi đặt hàng)
            session(['applied_voucher' => [
                'id' => $voucher->id,
                'code' => $voucher->code,
                'discount' => $discountAmount,
                'type' => $voucher->type,
                'reduce' => $voucher->reduce
            ]]);

            return response()->json([
                'success' => true,
                'message' => 'Áp dụng mã giảm giá thành công!',
                'data' => [
                    'voucher_id' => $voucher->id,
                    'code' => $voucher->code,
                    'discount_amount' => $discountAmount,
                    'final_total' => $finalTotal,
                    'type' => $voucher->type,
                    'reduce_value' => $voucher->reduce
                ]
            ]);

        } catch (\Exception $e) {           
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    public function addOrder(Request $request)
    {
        $shippingFee = $request->input('shipping_fee', 0);
        $orderData = $request->except('shipping_fee');
        
        // Lấy thông tin voucher từ session (nếu có)
        $appliedVoucher = session('applied_voucher');
        $voucherId = $appliedVoucher['id'] ?? null;
        $discountAmount = $appliedVoucher['discount'] ?? 0;

        if ($orderData['payment_type'] == 'COD') {
            DB::beginTransaction();
            try {
                $orderData['status'] = Constant::order_status_Unconfirmed;
                $orderData['user_id'] = auth()->id();
                
                $order = $this->orderService->create($orderData);

                $carts = Cart::content();
                
                // TÍNH DISCOUNT CHO TỪNG SẢN PHẨM (PHÂN BỔ ĐỀU)
                $totalItems = $carts->sum('qty');
                $discountPerItem = $totalItems > 0 ? $discountAmount / $totalItems : 0;

                foreach ($carts as $cart) {
                    // Tính discount cho sản phẩm này
                    $itemDiscount = $discountPerItem * $cart->qty;
                    
                    // Tính total SAU KHI TRỪ DISCOUNT
                    $itemTotal = ($cart->qty * $cart->price * 1000) - $itemDiscount;
                    
                    $data = [
                        'order_id' => $order->id,
                        'product_id' => $cart->id,
                        'user_id' => auth()->id(),
                        'color' => $cart->options->color ?? null,  
                        'size' => $cart->options->size ?? null, 
                        'qty' => $cart->qty,                 
                        'amount' => $cart->price * 1000, // ĐÃ NHÂN 1000
                        'shipping_fee' => $shippingFee,              
                        'total' => $itemTotal, // ĐÃ TRỪ DISCOUNT
                        'voucher_id' => $voucherId,
                        'discount_amount' => $itemDiscount, // Lưu discount của item này
                    ];
                    $this->orderDetailService->create($data);
                }

                // Trừ số lượng voucher nếu có
                if ($voucherId) {
                    $voucher = Voucher::find($voucherId);
                    if ($voucher && $voucher->qty > 0) {
                        $voucher->decrement('qty');
                    }
                    // Xóa voucher khỏi session
                    session()->forget('applied_voucher');
                }
                
                DB::commit();
                
                session(['last_order_id' => $order->id]);
                Cart::destroy();
                
                return redirect('checkout/result')
                    ->with('notification', 'Vui lòng thanh toán khi nhận hàng. Mã đơn hàng: ' . $order->id);

            } catch (\Exception $e) {
                DB::rollBack();
                return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
            }

        } elseif ($orderData['payment_type'] == "ONLINE"){
            $cartContent = Cart::content();
            $orderData = $request->all();
            $subtotal = Cart::priceTotal(0, '', '') * 1000;
            
            // Tính tổng tiền sau khi áp voucher
            $totalAmount = $subtotal - $discountAmount + $shippingFee;
            
            session([
                'temp_order_data' => $orderData,
                'temp_cart_content' => $cartContent,
                'temp_shipping_fee' => $shippingFee,
                'temp_voucher' => $appliedVoucher
            ]);

            $vnp_TxnRef_temp = time();

            $data_url = VNPay::vnpay_create_payment([
                'vnp_TxnRef' => $vnp_TxnRef_temp, 
                'vnp_OrderInfo' => 'Thanh toan don hang tam thoi: ' . $vnp_TxnRef_temp,
                'vnp_Amount' => $totalAmount,
            ]);
            
            return redirect()->to($data_url);
        }
    }

    public function vnPayCheck(Request $request)
    {
        $vnp_SecureHash = $request->get('vnp_SecureHash');
        $inputData = $request->except(['vnp_SecureHashType', 'vnp_SecureHash']);
        
        ksort($inputData);
        $hashData = http_build_query($inputData);
        $secureHash = hash_hmac('sha512', $hashData, VNPay::$vnp_HashSecret);

        if ($secureHash == $vnp_SecureHash) {
            $vnp_ResponseCode = $request->get('vnp_ResponseCode');
            
            if ($vnp_ResponseCode == '00') {
                $orderData = session('temp_order_data');
                $cartContent = session('temp_cart_content');
                $shippingFee = session('temp_shipping_fee', 0);
                $appliedVoucher = session('temp_voucher');
                $voucherId = $appliedVoucher['id'] ?? null;
                $discountAmount = $appliedVoucher['discount'] ?? 0;
                
                if ($orderData && $cartContent) {
                    DB::beginTransaction();
                    try {
                        if (isset($orderData['shipping_fee'])) {
                            unset($orderData['shipping_fee']);
                        }
                        
                        $orderData['payment_type'] = 'ONLINE';                              
                        $orderData['status'] = Constant::order_status_Paid;
                        $orderData['user_id'] = auth()->id();
                        
                        $order = $this->orderService->create($orderData);
                        
                        // TÍNH DISCOUNT CHO TỪNG SẢN PHẨM
                        $totalItems = $cartContent->sum('qty');
                        $discountPerItem = $totalItems > 0 ? $discountAmount / $totalItems : 0;
                        
                        foreach ($cartContent as $cart) {
                            $itemDiscount = $discountPerItem * $cart->qty;
                            $itemTotal = ($cart->qty * $cart->price * 1000) - $itemDiscount;
                            
                            $data = [
                                'order_id' => $order->id,
                                'product_id' => $cart->id,
                                'user_id' => auth()->id(),
                                'color' => $cart->options->color ?? null,  
                                'size' => $cart->options->size ?? null,
                                'qty' => $cart->qty,
                                'amount' => $cart->price * 1000,
                                'shipping_fee' => $shippingFee,                               
                                'total' => $itemTotal, // ĐÃ TRỪ DISCOUNT
                                'voucher_id' => $voucherId,
                                'discount_amount' => $itemDiscount,
                            ];
                            $this->orderDetailService->create($data);
                        }

                        // Trừ số lượng voucher nếu có
                        if ($appliedVoucher) {
                            $voucher = Voucher::find($appliedVoucher['id']);
                            if ($voucher && $voucher->qty > 0) {
                                $voucher->decrement('qty');
                            }
                        }
                        
                        DB::commit();
                        
                        session(['last_order_id' => $order->id]);
                        Cart::destroy();
                        session()->forget(['temp_order_data', 'temp_cart_content', 'temp_voucher', 'applied_voucher']);
                        
                        return redirect('checkout/result')
                            ->with('notification', 'Thanh toán VNPAY thành công. Mã đơn hàng: ' . $order->id);

                    } catch (\Exception $e) {
                        DB::rollBack();
                        session()->forget(['temp_order_data', 'temp_cart_content', 'temp_voucher']);
                        return redirect('checkout/result')
                            ->with('notification', 'Thanh toán thành công nhưng lưu đơn hàng thất bại: ' . $e->getMessage());
                    }
                } else {
                    session()->forget(['temp_order_data', 'temp_cart_content', 'temp_voucher']);
                    return redirect('checkout/result')
                        ->with('notification', 'Thanh toán thành công nhưng không tìm thấy thông tin đơn hàng.');
                }
                
            } else {
                session()->forget(['temp_order_data', 'temp_cart_content', 'temp_voucher']);
                return redirect('checkout/result')->with('notification', 'Thanh toán VNPAY thất bại. Mã lỗi: ' . $vnp_ResponseCode);
            }

        } else {
            session()->forget(['temp_order_data', 'temp_cart_content', 'temp_voucher']);
            return redirect('checkout/result')->with('notification', 'Lỗi bảo mật: Sai chữ ký VNPAY');
        }
    }

    public function result ()
    {
        $notification = session('notification') ?? session('nontification'); 
        $order_id = session('last_order_id');
        $order = null;

        if ($order_id) {
            $order = Order::with('orderDetails')->find($order_id); 
            session()->forget('last_order_id');
        }
              
        return view ('front.checkout.result', compact('notification', 'order'));
    }
}