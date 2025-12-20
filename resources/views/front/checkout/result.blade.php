@extends('front.layout.master')

@section('title', 'Result')

@section('body')

    <!-- Breadcrumb Session Begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="/"><i class="fa fa-home"></i>Thanh toán</a>
                        <span>Hóa đơn</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Session End -->
    
    <!-- ResultOrder Session Begin -->
    <section class="checkout-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    
                    {{-- 1. HIỂN THỊ TRẠNG THÁI CHUNG --}}
                    <h4 class="mb-5">
                        {{ $notification }}
                    </h4>

                    @if ($order)
                        {{-- TÍNH TỔNG TIỀN TỪ ORDER DETAILS --}}
                        @php
                            $subtotalBeforeDiscount = 0; // Tổng chưa giảm
                            $totalDiscount = 0;          // Tổng giảm giá
                            $totalAfterDiscount = 0;     // Tổng sau giảm
                            $shippingFee = 0;
                            
                            foreach ($order->orderDetails as $item) {
                                // Tính tạm tính (chưa giảm)
                                $subtotalBeforeDiscount += ($item->qty * $item->amount);
                                
                                // Tổng giảm giá
                                $totalDiscount += $item->discount_amount ?? 0;
                                
                                // Tổng sau giảm (total đã trừ discount rồi)
                                $totalAfterDiscount += $item->total;
                                
                                // Phí ship (chỉ lấy 1 lần)
                                if ($shippingFee == 0 && isset($item->shipping_fee)) {
                                    $shippingFee = $item->shipping_fee;
                                }
                            }
                            
                            $finalTotal = $totalAfterDiscount + $shippingFee;
                        @endphp

                        {{-- 2. HIỂN THỊ THÔNG TIN ĐƠN HÀNG --}}
                        <div class="order-details-box p-4 border rounded shadow-sm mx-auto" style="max-width: 600px; text-align: left;">
                            <h5 class="mb-4 text-primary">Thông tin Đơn hàng của bạn</h5>
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th style="width: 40%;">Mã Đơn hàng:</th>
                                        <td><strong>#{{ $order->id }}</strong></td>
                                    </tr>
                                    <tr>
                                        <th>Trạng thái:</th>
                                        <td><span class="badge {{ $order->status_badge_class }} text-white">
                                                {{ $order->status_text }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Phương thức thanh toán:</th>
                                        <td>{{ $order->payment_type ?? 'COD' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tạm tính:</th>
                                        <td>{{ number_format($subtotalBeforeDiscount, 0, ',', '.') }}đ</td>
                                    </tr>
                                    
                                    @if($totalDiscount > 0)
                                    <tr>
                                        <th>Giảm giá:</th>
                                        <td class="text-success">-{{ number_format($totalDiscount, 0, ',', '.') }}đ</td>
                                    </tr>
                                    @endif
                                    
                                    <tr>
                                        <th>Phí vận chuyển:</th>
                                        <td>{{ number_format($shippingFee, 0, ',', '.') }}đ</td>
                                    </tr>
                                    
                                    <tr class="border-top">
                                        <th>Tổng tiền:</th>
                                        <td><strong class="text-danger">{{ number_format($finalTotal, 0, ',', '.') }}đ</strong></td>
                                    </tr>
                                </tbody>
                            </table>

                            <h6 class="mt-4 mb-3">Chi tiết Sản phẩm:</h6>
                            <ul class="list-group mb-4">
                                @foreach ($order->orderDetails as $item)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $item->product->name ?? 'Sản phẩm ID ' . $item->product_id }}</strong>
                                            <br>
                                            <small class="text-muted">
                                                Số lượng: {{ $item->qty }} x {{ number_format($item->amount, 0, ',', '.') }}đ
                                                @if($item->color)
                                                    | Màu: {{ $item->color }}
                                                @endif
                                                @if($item->size)
                                                    | Size: {{ $item->size }}
                                                @endif
                                                {{-- @if($item->discount_amount > 0)
                                                    <br>
                                                    <span class="text-success">(Giảm {{ number_format($item->discount_amount, 0, ',', '.') }}đ)</span>
                                                @endif --}}
                                            </small>
                                        </div>
                                        <span>{{ number_format($item->total, 0, ',', '.') }}đ</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        {{-- Trường hợp đơn hàng không tìm thấy --}}
                        <p class="mt-4 text-muted">Không tìm thấy chi tiết đơn hàng. Vui lòng kiểm tra email xác nhận.</p>
                    @endif
                    
                    <a href="{{ route('user.orders') }}" class="primary-btn mt-5">Xem đơn hàng</a>
                </div>
            </div> 
        </div>
    </section>
    <!-- ResultOrder Session End -->

@endsection