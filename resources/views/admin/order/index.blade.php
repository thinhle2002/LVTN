@extends('admin.layout.master')
@section('title', 'Order')
@section('body')

    <!-- Main -->
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-ticket icon-gradient bg-mean-fruit"></i>
                    </div>
                    <div>
                        Order
                        <div class="page-title-subheading">
                            View, create, update, delete and manage.
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card">

                    <div class="card-header">

                        <form>
                            <div class="input-group">
                                <input type="search" name="search" id="search" value="{{ request('search') }}"
                                    placeholder="Nhập từ khóa" class="form-control">
                                <span class="input-group-append">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-search"></i>&nbsp;
                                        Tìm kiếm
                                    </button>
                                </span>
                            </div>
                        </form>

                    </div>

                    <div class="table-responsive">
                        <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th>Khách hàng / Sản phẩm</th>
                                    <th class="text-center">Ngày đặt</th>
                                    <th class="text-center">Địa chỉ</th>
                                    <th class="text-center">Tổng tiền</th>
                                    <th class="text-center">Trạng thái</th>
                                    <th class="text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    @php
                                        // TÍNH TỔNG TỪ ORDER_DETAILS (total đã trừ discount)
                                        $totalAfterDiscount = $order->orderDetails->sum('total');
                                        $totalDiscount = $order->orderDetails->sum('discount_amount');
                                        $shippingFee = $order->orderDetails->first()->shipping_fee ?? 0;
                                        $finalTotal = $totalAfterDiscount + $shippingFee;
                                    @endphp
                                    <tr>
                                        <td class="text-center text-muted">#{{ $order->id}}</td>
                                        <td>
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left mr-3">
                                                        <div class="widget-content-left">
                                                            <img style="height: 60px;"
                                                                data-toggle="tooltip" title="Image"
                                                                data-placement="bottom"
                                                                src="upload/front/img/products/{{ $order->orderDetails[0]->product->productImages[0]->path }}" alt="">
                                                        </div>
                                                    </div>
                                                    <div class="widget-content-left flex2">
                                                        <div class="widget-heading">{{ $order->user->name }}</div>
                                                        <div class="widget-subheading opacity-7">
                                                            {{ $order->orderDetails[0]->product->name }}
                                                            @if(count($order->orderDetails) > 1)
                                                                (và {{count($order->orderDetails)}} sản phẩm khác)
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            {{ $order->created_at }}
                                        </td>
                                        <td class="text-center">
                                            {{$order->street_address}}, {{$order->district}}, {{$order->town_city}}
                                        </td>
                                        <td class="text-center">
                                            <strong>{{ number_format($finalTotal, 0, ',', '.') }}đ</strong>
                                            @if($totalDiscount > 0)
                                                <br>
                                                <small class="text-success">
                                                    (Đã giảm {{ number_format($totalDiscount, 0, ',', '.') }}đ)
                                                </small>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="badge badge-dark">
                                                {{ \App\Utilities\Constant::$order_status[$order->status] }}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <a href="./admin/order/{{ $order->id }}"
                                                class="btn btn-hover-shine btn-outline-primary border-0 btn-sm">
                                                Chi tiết
                                            </a>
                                        </td>
                                    </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-block card-footer">
                        {{ $orders->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- End Main -->

@endsection