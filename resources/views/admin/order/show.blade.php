@extends('admin.layout.master')
@section('title', 'Order Details')
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
                    <div class="card-body display_data">

                        <div class="table-responsive">
                            <h2 class="text-center">Sản phẩm đã đặt</h2>
                            <hr>
                            <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Tên sản phẩm</th>
                                        <th class="text-center">Số lượng</th>
                                        <th class="text-center">Đơn giá</th>
                                        <th class="text-center">Tổng tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->orderDetails as $orderDetail) 
                                        <tr>
                                            <td>
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-wrapper">
                                                        <div class="widget-content-left mr-3">
                                                            <div class="widget-content-left">
                                                                <img style="height: 60px;"
                                                                    data-toggle="tooltip" title="Image"
                                                                    data-placement="bottom"
                                                                    src="upload/front/img/products/{{$orderDetail->product->productImages[0]->path}}" alt="">
                                                            </div>
                                                        </div>
                                                        <div class="widget-content-left flex2">
                                                            <div class="widget-heading">{{ $orderDetail->product->name }}</div>
                                                            @php
                                                                $colorMap = config('convertColor.colors');
                                                                $rawColor = $orderDetail->color ?? null;
                                                                $productSize = $orderDetail->size ?? null;
                                                                
                                                                $displayColor = $colorMap[$rawColor] ?? $rawColor;
                                                            @endphp
                                                            
                                                            @if ($rawColor || $productSize)
                                                                <div class="widget-subheading" style="font-size: 13px; color: #666; margin-top: 5px;">
                                                                    @if ($rawColor)
                                                                        <span>Màu: <strong>{{ $displayColor }}</strong></span>
                                                                    @endif
                                                                    @if ($productSize)
                                                                        @if ($rawColor) <span class="mx-1">/</span> @endif
                                                                        <span>Size: <strong>{{ $productSize }}</strong></span>
                                                                    @endif
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                {{ $orderDetail->qty }}
                                            </td>
                                            <td class="text-center">{{ number_format($orderDetail->amount, 0, ',', '.')}}đ</td>
                                            <td class="text-center">
                                                {{ number_format($orderDetail->total, 0, ',', '.')}}đ
                                            </td>
                                        </tr>
                                    @endforeach 
                                </tbody>
                            </table>
                        </div>



                        <h2 class="text-center mt-5">Thông tin giao hàng</h2>
                            <hr>
                        <div class="position-relative row form-group">
                            <label for="name" class="col-md-3 text-md-right col-form-label">
                                Tên khách hàng
                            </label>
                            <div class="col-md-9 col-xl-8">
                                <p>{{ $order->user->name }}</p>
                            </div>
                        </div>

                        <div class="position-relative row form-group">
                            <label for="email" class="col-md-3 text-md-right col-form-label">Email</label>
                            <div class="col-md-9 col-xl-8">
                                <p>{{ $order->email }}</p>
                            </div>
                        </div>

                        <div class="position-relative row form-group">
                            <label for="phone" class="col-md-3 text-md-right col-form-label">Số điện thoại</label>
                            <div class="col-md-9 col-xl-8">
                                <p>{{ $order->phone }}</p>
                            </div>
                        </div>
               
                        <div class="position-relative row form-group">
                            <label for="street_address" class="col-md-3 text-md-right col-form-label">
                                Số nhà / Tên đường</label>
                            <div class="col-md-9 col-xl-8">
                                <p>{{ $order->street_address }}</p>
                            </div>
                        </div>

                        <div class="position-relative row form-group">
                            <label for="district" class="col-md-3 text-md-right col-form-label">
                                Phường / Xã</label>
                            <div class="col-md-9 col-xl-8">
                                <p>{{ $order->district }}</p>
                            </div>
                        </div>

                        <div class="position-relative row form-group">
                            <label for="town_city" class="col-md-3 text-md-right col-form-label">
                                Tỉnh / Thành phố</label>
                            <div class="col-md-9 col-xl-8">
                                <p>{{ $order->town_city }}</p>
                            </div>
                        </div>                       
                  
                        <div class="position-relative row form-group">
                            <label for="payment_type" class="col-md-3 text-md-right col-form-label">Phương thức thanh toán</label>
                            <div class="col-md-9 col-xl-8">
                                <p>
                                    {{ $order->payment_type == 'COD' ? 'Thanh toán khi nhận hàng' : 'Đã thanh toán trực tuyến' }}
                                </p>

                            </div>
                        </div>

                        <div class="position-relative row form-group">
                            <label for="status" class="col-md-3 text-md-right col-form-label">Trạng thái đơn hàng</label>
                            <div class="col-md-9 col-xl-8">
                                <select name="status" id="status" class="form-control" onchange="updateOrderStatus({{ $order->id }}, this.value)">
                                    @foreach(\App\Utilities\Constant::$order_status as $key => $value)
                                        <option value="{{ $key }}" {{ $order->status == $key ? 'selected' : '' }}>
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        {{-- <div class="position-relative row form-group">
                            <label for="town_city" class="col-md-3 text-md-right col-form-label">
                                Ngày giao hàng dự kiến</label>
                            <div class="col-md-9 col-xl-8">
                                <p></p>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Main -->
<script>
    function updateOrderStatus(orderId, newStatus) {
        console.log('Updating order:', orderId, 'Status:', newStatus); // Debug
        
        Swal.fire({
            title: 'Xác nhận',
            text: 'Bạn có chắc muốn thay đổi trạng thái đơn hàng này?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Đồng ý',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                // Disable select box
                $('#status').prop('disabled', true);
                
                $.ajax({
                    url: '/admin/order/' + orderId + '/update-status',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: newStatus
                    },
                    success: function(response) {
                        console.log('Response:', response); // Debug
                        
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công!',
                                text: 'Cập nhật trạng thái thành công!',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi!',
                                text: response.message || 'Có lỗi xảy ra!'
                            });
                            $('#status').prop('disabled', false);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error details:', {
                            status: xhr.status,
                            responseText: xhr.responseText,
                            error: error
                        }); // Debug
                        
                        let errorMessage = 'Có lỗi xảy ra khi cập nhật!';
                        
                        if (xhr.status === 404) {
                            errorMessage = 'Không tìm thấy đường dẫn API!';
                        } else if (xhr.status === 500) {
                            errorMessage = 'Lỗi server!';
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: errorMessage,
                            footer: 'Mã lỗi: ' + xhr.status
                        });
                        
                        // Reset select về giá trị cũ
                        $('#status').val('{{ $order->status }}').prop('disabled', false);
                    }
                });
            } else {
                // Nếu hủy thì reset select về giá trị cũ
                $('#status').val('{{ $order->status }}');
            }
        });
    }
</script>
@endsection
                