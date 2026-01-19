@extends('front.layout.master')

@section('title', 'Đơn hàng của tôi')

@section('body')
    @php
        use App\Utilities\Constant;
    @endphp
    <!-- Breadcrumb Session Begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="/"><i class="fa fa-home"></i> Trang chủ</a>
                        <span>Đơn hàng của tôi</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Session End -->

    <!-- Order Section Begin -->
    <section class="shopping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="mb-4">Đơn hàng của tôi</h4>
                    
                    @if($orders->count() > 0)
                        <div class="cart-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th style="width: 10%;">Mã ĐH</th>
                                        <th style="width: 30%;">Sản phẩm</th>
                                        <th style="width: 12%;">Ngày đặt</th>
                                        <th style="width: 15%;">Tổng tiền</th>
                                        <th style="width: 13%;">Thanh toán</th>
                                        <th style="width: 15%;">Trạng thái</th>
                                        <th style="width: 5%;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td class="first-row">
                                                <strong>#{{ $order->id }}</strong>
                                            </td>
                                            <td class="first-row">
                                                @php
                                                    $productCount = $order->orderDetails->count();
                                                    $firstProduct = $order->orderDetails->first();
                                                @endphp
                                                
                                                @if($firstProduct && $firstProduct->product)
                                                    @php
                                                        // Lấy hình ảnh theo màu
                                                        $imageToShow = null;
                                                        
                                                        if($firstProduct->color) {
                                                            $productDetail = \App\Models\ProductDetail::where('product_id', $firstProduct->product_id)
                                                                ->where('color', $firstProduct->color)
                                                                ->first();
                                                            
                                                            if($productDetail && $productDetail->productImages) {
                                                                $imageToShow = $productDetail->productImages;
                                                            }
                                                        }
                                                        
                                                        // Nếu không có, lấy hình đầu tiên
                                                        if(!$imageToShow && $firstProduct->product->productImages->count() > 0) {
                                                            $imageToShow = $firstProduct->product->productImages[0];
                                                        }
                                                    @endphp
                                                    
                                                    <div style="display: flex; align-items: center;">
                                                        @if($imageToShow)
                                                            @if(is_object($imageToShow) && isset($imageToShow->path))
                                                                <img src="{{ asset('upload/front/img/products/' . $imageToShow->path) }}" 
                                                                    alt="{{ $firstProduct->product->name }}" 
                                                                    style="width: 60px; height: 60px; object-fit: cover; margin-right: 10px;">
                                                            @elseif(is_array($imageToShow) && isset($imageToShow['path']))
                                                                <img src="{{ asset('upload/front/img/products/' . $imageToShow['path']) }}" 
                                                                    alt="{{ $firstProduct->product->name }}" 
                                                                    style="width: 60px; height: 60px; object-fit: cover; margin-right: 10px;">
                                                            @endif
                                                        @else
                                                            <img src="{{ asset('upload/front/img/products/no-image.jpg') }}" 
                                                                alt="No image" 
                                                                style="width: 60px; height: 60px; object-fit: cover; margin-right: 10px;">
                                                        @endif
                                                        
                                                        <div>
                                                            <strong>{{ $firstProduct->product->name }}</strong>
                                                            <br>
                                                            <small>x{{ $firstProduct->qty }}</small>
                                                            
                                                            @php
                                                                $colorMap = config('convertColor.colors');
                                                                $rawColor = $firstProduct->color ?? null;
                                                                $productSize = $firstProduct->size ?? null;
                                                                $displayColor = $colorMap[$rawColor] ?? $rawColor;
                                                            @endphp
                                                            
                                                            @if ($rawColor || $productSize)
                                                                <br>
                                                                <small style="color: #888;">
                                                                    @if ($rawColor)
                                                                        {{ $displayColor }}
                                                                    @endif
                                                                    @if ($productSize)
                                                                        @if ($rawColor) / @endif {{ $productSize }}
                                                                    @endif
                                                                </small>
                                                            @endif
                                                            
                                                            @if($productCount > 1)
                                                                <br>
                                                                <small style="color: #888;">và {{ $productCount - 1 }} sản phẩm khác</small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @else
                                                    <span>{{ $productCount }} sản phẩm</span>
                                                @endif
                                            </td>
                                            <td class="first-row">
                                                {{ $order->created_at->format('d/m/Y') }}
                                                <br>
                                                <small style="color: #888;">{{ $order->created_at->format('H:i') }}</small>
                                            </td>
                                            <td class="first-row">
                                                @php
                                                    $subtotal = 0;
                                                    $shippingFee = 0;
                                                    
                                                    // Tính tổng tiền sản phẩm và phí ship
                                                    foreach ($order->orderDetails as $item) {
                                                        $subtotal += $item->total;
                                                        if ($shippingFee == 0 && isset($item->shipping_fee)) {
                                                            $shippingFee = $item->shipping_fee;
                                                        }
                                                    }
                                                    
                                                    // Tính voucher discount
                                                    $voucherDiscount = 0;
                                                    if ($order->voucher) {
                                                        $voucher = $order->voucher;
                                                        if ($voucher->type == 1) {
                                                            // Giảm theo phần trăm
                                                            $cal = intval(round($subtotal * ($voucher->reduce / 100)));
                                                            // Áp dụng giảm tối đa nếu có
                                                            if (!empty($voucher->max_discount) && $voucher->max_discount > 0) {
                                                                $cal = min($cal, $voucher->max_discount);
                                                            }
                                                            $voucherDiscount = min($cal, $subtotal);
                                                        } else {
                                                            // Giảm cố định
                                                            $cal = $voucher->reduce ?? 0;
                                                            $voucherDiscount = min($cal, $subtotal);
                                                        }
                                                    }
                                                    
                                                    // Tổng tiền cuối cùng
                                                    $finalTotal = $subtotal + $shippingFee - $voucherDiscount;
                                                @endphp
                                                
                                                <div>
                                                    <strong style="color: #e7ab3c; font-size: 16px;">
                                                        {{ number_format($finalTotal, 0, ',', '.') }}đ
                                                    </strong>                                                                      
                                                </div>
                                            </td>
                                            <td class="first-row">
                                                @if($order->payment_type == 'COD')
                                                    <span class="badge badge-warning" style="background-color: #f39c12; color: white; padding: 5px 10px; border-radius: 3px;">COD</span>
                                                @else
                                                    <span class="badge badge-success" style="background-color: #28a745; color: white; padding: 5px 10px; border-radius: 3px;">Online</span>
                                                @endif
                                            </td>
                                            <td class="first-row">
                                                @php                                               
                                                    $statusText = Constant::$order_status[$order->status] ?? 'Không xác định';
                                                    $statusColor = '';
                                                    
                                                    switch ($order->status) {
                                                        case Constant::order_status_ReceivedOrders:
                                                        case Constant::order_status_Unconfirmed:
                                                            $statusColor = '#f39c12'; // Vàng
                                                            break;
                                                        case Constant::order_status_Confirmed:
                                                            $statusColor = '#3498db'; // Xanh dương
                                                            break;
                                                        case Constant::order_status_Processing:
                                                            $statusColor = '#9b59b6'; // Tím
                                                            break;
                                                        case Constant::order_status_Shipping:
                                                            $statusColor = '#e67e22'; // Cam
                                                            break;
                                                        case Constant::order_status_Finished:
                                                            $statusColor = '#27ae60'; // Xanh lá
                                                            break;
                                                        case Constant::order_status_Paid:
                                                            $statusColor = '#28a745'; // Xanh lá đậm
                                                            break;
                                                        case Constant::order_status_Canceled:
                                                            $statusColor = '#e74c3c'; // Đỏ
                                                            break;
                                                        default:
                                                            $statusColor = '#95a5a6'; // Xám
                                                            break;
                                                    }
                                                @endphp
                                                <span style="background-color: {{ $statusColor }}; color: white; padding: 5px 10px; border-radius: 3px; font-size: 12px; display: inline-block;">
                                                    {{ $statusText }}
                                                </span>
                                            </td>
                                            <td class="first-row">
                                                <a href="{{ route('user.order.detail', $order->id) }}" 
                                                   class="btn btn-sm btn-primary" 
                                                   style="background-color: #ca1515; border: none; padding: 5px 10px; color: white; text-decoration: none; border-radius: 3px;">
                                                    Chi tiết
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info text-center" style="padding: 30px;">
                            <h5>Bạn chưa có đơn hàng nào</h5>
                            <p>Hãy khám phá các sản phẩm của chúng tôi và đặt hàng ngay!</p>
                            <a href="/shop" class="primary-btn" style="margin-top: 15px;">Mua sắm ngay</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- Order Section End -->

@endsection

@section('styles')
<style>
    .cart-table table tbody tr td {
        vertical-align: middle;
    }
    
    .badge {
        font-weight: 500;
        font-size: 13px;
    }
    
    .btn-primary:hover {
        opacity: 0.8;
    }
</style>
@endsection