@extends('front.layout.master')

@section('title', 'Result')

@section('body')


    <!-- ResultOrder Session Begin -->
    <section class="checkout-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                
                {{-- 1. HIỂN THỊ TRẠNG THÁI CHUNG --}}
                <h4 class="mb-5">
                    {{$notification}}
                </h4>

                @if ($order)
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
                                    <td><span class="badge bg-success text-white">{{ $order->status }}</span></td>
                                </tr>
                                <tr>
                                    <th>Phương thức thanh toán:</th>
                                    <td>{{ $order->payment_type ?? 'COD' }}</td>
                                </tr>
                                <tr>
                                    <th>Tổng tiền:</th>
                                    <td><strong class="text-danger">{{ number_format($order->total, 0, ',', '.') }}₫</strong></td>
                                </tr>
                            </tbody>
                        </table>

                        <h6 class="mt-4 mb-3">Chi tiết Sản phẩm:</h6>
                        <ul class="list-group mb-4">
                            @foreach ($order->orderDetails as $item)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $item->qty }} x {{ $item->product_name ?? 'Sản phẩm ID ' . $item->product_id }}
                                    <span>{{ number_format($item->total, 0, ',', '.') }}₫</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    {{-- Trường hợp đơn hàng không tìm thấy (thường là lỗi) --}}
                    <p class="mt-4 text-muted">Không tìm thấy chi tiết đơn hàng. Vui lòng kiểm tra email xác nhận.</p>
                @endif
                
                <a href="/shop" class="primary-btn mt-5">Tiếp tục mua sắm</a>
            </div>
        </div> 
    </div>
</section>
    <!-- ResultOrder Session End -->

@endsection
