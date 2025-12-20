<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ProductDetail;
use App\Service\Order\OrderServiceInterface;
use App\Utilities\Constant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    private $orderService;
    public function __construct(OrderServiceInterface $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(Request $request)
    {
        $orders = $this->orderService->searchAndPaginate('name', $request->get('search'));
        return view('admin.order.index', compact('orders'));
    }

    public function show($id)
    {
        $order = $this->orderService->find($id);
        return view('admin.order.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $order = Order::with('orderDetails')->findOrFail($id);
            
            $request->validate([
                'status' => 'required|integer|min:1|max:8'
            ]);
            
            $oldStatus = $order->status;
            $newStatus = $request->status;
            
            DB::beginTransaction();
            
            // Kiểm tra nếu chuyển sang trạng thái Hoàn thành
            if ($newStatus == Constant::order_status_Finished && $oldStatus != Constant::order_status_Finished) {
                // Trừ số lượng sản phẩm
                foreach ($order->orderDetails as $detail) {
                    $productDetail = ProductDetail::where('product_id', $detail->product_id)->first();
                    
                    if ($productDetail) {
                        // Kiểm tra số lượng có đủ không
                        if ($productDetail->qty < $detail->qty) {
                            DB::rollBack();
                            return response()->json([
                                'success' => false,
                                'message' => 'Sản phẩm không đủ số lượng trong kho'
                            ], 400);
                        }
                        
                        // Trừ số lượng
                        $productDetail->qty -= $detail->qty;
                        $productDetail->save();
                    }
                }
            }
            
            // Kiểm tra nếu từ Hoàn thành chuyển sang trạng thái khác (hoàn trả số lượng)
            if ($oldStatus == Constant::order_status_Finished && $newStatus != Constant::order_status_Finished) {
                foreach ($order->orderDetails as $detail) {
                    $productDetail = ProductDetail::where('product_id', $detail->product_id)->first();
                    
                    if ($productDetail) {
                        // Hoàn trả số lượng
                        $productDetail->qty += $detail->qty;
                        $productDetail->save();
                    }
                }
            }
            
            $order->status = $newStatus;
            $order->save();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật trạng thái thành công',
                'order' => $order
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        //
    }
}