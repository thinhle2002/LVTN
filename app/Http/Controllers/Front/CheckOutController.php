<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Service\Order\OrderServiceInterface;
use App\Service\OrderDetail\OrderDetailServiceInterface;
use App\Utilities\VNPay;
use Gloudemans\Shoppingcart\Facades\Cart;


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
        $carts = Cart::content();
        $total = Cart::priceTotal(0, '', '');
        $subtotal = Cart::subtotal(0, '', '');

        return view('front.checkout.index', compact('carts', 'total', 'subtotal'));
    }
    public function addOrder(Request $request)
    {
        if ($request->payment_type == 'COD') {
            $order = $this->orderService->create($request->all());

            $carts = Cart::content();

            foreach ($carts as $cart) {
                $data = [
                    'order_id' => $order->id,
                    'product_id' => $cart->id,
                    'qty' => $cart->qty,                 
                    'amount' => $cart->price,
                    'total' => $cart->qty * $cart->price,
                ];
                $this->orderDetailService->create($data);
            }
            
            Cart::destroy();

            return redirect('checkout/result')
                ->with('nontification','Đặt hàng thành công. Kiểm tra đơn hàng qua email của bạn!');

        } elseif ($request->payment_type == "ONLINE"){
            
            
            $cartContent = Cart::content();
            $orderData = $request->all();
            $totalAmount = Cart::priceTotal(0, '', '') * 1000; 
            
            session([
                'temp_order_data' => $orderData,
                'temp_cart_content' => $cartContent,
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
            $vnp_TxnRef = $request->get('vnp_TxnRef');
            
            if ($vnp_ResponseCode == '00') {
                
                $orderData = session('temp_order_data');
                $cartContent = session('temp_cart_content');
                
                if ($orderData && $cartContent) {
                    
                    try {
                        // 1. Cập nhật dữ liệu và TẠO ĐƠN HÀNG
                        $orderData['payment_type'] = 'ONLINE'; 
                        $orderData['status'] = 'Đã thanh toán';
                        $order = $this->orderService->create($orderData);
                        
                        // 2. TẠO CHI TIẾT ĐƠN HÀNG
                        foreach ($cartContent as $cart) {
                            $data = [
                                'order_id' => $order->id,
                                'product_id' => $cart->id,
                                'qty' => $cart->qty,
                                'amount' => $cart->price,
                                'total' => $cart->qty * $cart->price,
                            ];
                            $this->orderDetailService->create($data);
                        }
                        session(['last_order_id' => $order->id]);
                        // 3. XÓA GIỎ HÀNG VÀ SESSION TẠM THỜI
                        Cart::destroy();
                        session()->forget(['temp_order_data', 'temp_cart_content']);
                        
                        return redirect('checkout/result')
                            ->with('notification', 'Thanh toán VNPAY thành công. Mã đơn hàng: ' . $order->id);

                    } catch (\Exception $e) {
                        // Xử lý nếu việc lưu DB bị lỗi
                        session()->forget(['temp_order_data', 'temp_cart_content']);
                        dd('LỖI KHI LƯU DB:', $e->getMessage(), $orderData, $cartContent);
                        // return redirect('checkout/result')
                        //     ->with('notification', 'Thanh toán thành công nhưng lưu đơn hàng thất bại. Vui lòng liên hệ hỗ trợ!');
                    }

                } else {
                    session()->forget(['temp_order_data', 'temp_cart_content']);
                    return redirect('checkout/result')
                        ->with('notification', 'Thanh toán thành công nhưng không tìm thấy thông tin đơn hàng tạm thời.');
                }
                
            } else {
                // Thanh toán thất bại
                // GIỮ LẠI GIỎ HÀNG và chỉ xóa session tạm
                session()->forget(['temp_order_data', 'temp_cart_content']);
                
                return redirect('checkout/result')->with('notification', 'Thanh toán VNPAY thất bại. Mã lỗi: ' . $vnp_ResponseCode);
            }

        } else {
            // Lỗi bảo mật
            session()->forget(['temp_order_data', 'temp_cart_content']);
            
            return redirect('checkout/result')->with('notification', 'Lỗi bảo mật: Sai chữ ký VNPAY (Dữ liệu bị giả mạo!)');
        }
    }
    public function result ()
    {
        
        $notification = session('notification') ?? session('nontification'); 
        
        $order_id = session('last_order_id');
        $order = null;

        if ($order_id) {
           
            $order = Order::with('orderDetails')->find($order_id); 
            
            // Xóa ID khỏi session sau khi lấy
            session()->forget('last_order_id');
        }
        
        // Truyền cả notification và order sang View
        return view ('front.checkout.result', compact('notification', 'order'));
    }
}
