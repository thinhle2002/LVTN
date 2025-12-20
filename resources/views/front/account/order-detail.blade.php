@extends('front.layout.master')

@section('title', 'Chi tiết đơn hàng #' . $order->id)

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
                        <a href="{{ route('user.orders') }}">Đơn hàng của tôi</a>
                        <span>Chi tiết đơn hàng #{{ $order->id }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Session End -->
    
    <!-- Order Detail Section Begin -->
    <section class="shopping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="mb-4">
                        <a href="{{ route('user.orders') }}" class="btn btn-sm" style="background-color: #ca1515; color: white; padding: 8px 20px; text-decoration: none; border-radius: 3px;">
                            <i class="fa fa-arrow-left"></i> Quay lại danh sách đơn hàng
                        </a>
                    </div>

                    @php
               
                        $firstDetail = $order->orderDetails->first();
                        $voucherInfo = null;
                        $totalVoucherDiscount = 0;
                        
                        if ($firstDetail && $firstDetail->voucher_id) {
                            
                            $voucherInfo = $firstDetail->voucher;                                       
                            $totalVoucherDiscount = $order->orderDetails->sum('discount_amount');
                        }
                    @endphp

                    <!-- Thông tin đơn hàng -->
                    <div class="card mb-4">
                        <div class="card-header" style="background-color: #f8f9fa; padding: 15px;">
                            <h5 class="mb-0">Thông tin đơn hàng #{{ $order->id }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">                                    
                                    <table class="table table-borderless">
                                        <tr>
                                            <td style="width: 40%; font-weight: 600;">Mã đơn hàng:</td>
                                            <td>#{{ $order->id }}</td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: 600;">Ngày đặt hàng:</td>
                                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: 600;">Trạng thái:</td>
                                            <td>
                                                @php                                                   
                                                    $statusText = Constant::$order_status[$order->status] ?? 'Chờ xác nhận';
                                                    $statusColor = '#95a5a6';
                                                    
                                                    switch ($order->status) {                                                       
                                                        case Constant::order_status_Unconfirmed:
                                                            $statusColor = '#f39c12';
                                                            break;
                                                        case Constant::order_status_Confirmed:
                                                            $statusColor = '#3498db';
                                                            break;
                                                        case Constant::order_status_Processing:
                                                            $statusColor = '#9b59b6';
                                                            break;
                                                        case Constant::order_status_Shipping:
                                                            $statusColor = '#e67e22';
                                                            break;
                                                        case Constant::order_status_Finished:
                                                            $statusColor = '#27ae60';
                                                            break;
                                                        case Constant::order_status_Paid:
                                                            $statusColor = '#28a745';
                                                            break;
                                                        case Constant::order_status_Canceled:
                                                            $statusColor = '#e74c3c';
                                                            break;
                                                    }
                                                @endphp
                                                <span style="background-color: {{ $statusColor }}; color: white; padding: 5px 15px; border-radius: 3px; font-size: 13px;">
                                                    {{ $statusText }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: 600;">Phương thức thanh toán:</td>
                                            <td>
                                                @if($order->payment_type == 'COD')
                                                    <span style="background-color: #f39c12; color: white; padding: 5px 15px; border-radius: 3px; font-size: 13px;">
                                                        Thanh toán khi nhận hàng (COD)
                                                    </span>
                                                @else
                                                    <span style="background-color: #28a745; color: white; padding: 5px 15px; border-radius: 3px; font-size: 13px;">
                                                        Thanh toán Online
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                        @if($voucherInfo)
                                        <tr>
                                            <td style="font-weight: 600;">Mã giảm giá:</td>
                                            <td>
                                                <span style="background-color: #28a745; color: white; padding: 5px 15px; border-radius: 3px; font-size: 13px;">
                                                    <i class="fa fa-ticket-alt"></i> {{ $voucherInfo->code }}
                                                </span>
                                            </td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h6 style="font-weight: 600; margin-bottom: 15px;">Thông tin người nhận:</h6>
                                    <p class="mb-2"><strong>Họ tên:</strong> {{ $order->name }}</p>
                                    <p class="mb-2"><strong>Email:</strong> {{ $order->email }}</p>
                                    <p class="mb-2"><strong>Số điện thoại:</strong> {{ $order->phone }}</p>
                                    <p class="mb-2"><strong>Địa chỉ:</strong> {{ $order->street_address }}, {{ $order->district }}, {{ $order->town_city }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Chi tiết sản phẩm -->
                    <div class="card">
                        <div class="card-header" style="background-color: #f8f9fa; padding: 15px;">
                            <h5 class="mb-0">Chi tiết sản phẩm</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="cart-table">
                                <table>
                                    <thead>
                                        <tr>
                                            <th style="width: 10%;">Hình ảnh</th>
                                            <th style="width: 35%;">Sản phẩm</th>
                                            <th style="width: 15%;">Đơn giá</th>
                                            <th style="width: 15%;">Số lượng</th>
                                            <th style="width: 15%;">Thành tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $subtotal = 0;
                                            $shippingFee = 0;
                                        @endphp

                                        @foreach($order->orderDetails as $item)
                                            @php
                                                
                                                $itemSubtotal = $item->total + ($item->discount_amount ?? 0);
                                                $subtotal += $itemSubtotal;
                                                
                                                if ($shippingFee == 0 && isset($item->shipping_fee)) {
                                                    $shippingFee = $item->shipping_fee;
                                                }
                                            @endphp
                                            <tr>
                                                <td class="cart-pic first-row">
                                                    @php
                                                        $imageToShow = \App\Helpers\ProductImageHelper::getImageByColor(
                                                            $item->product_id, 
                                                            $item->color
                                                        );
                                                    @endphp
                                                    
                                                    @if($imageToShow)
                                                        <img src="{{ asset('upload/front/img/products/' . $imageToShow->path) }}" 
                                                            alt="{{ $item->product->name ?? 'Product' }}" 
                                                            style="width: 80px; height: 80px; object-fit: cover;">
                                                    @else
                                                        <img src="{{ asset('upload/front/img/products/default.jpg') }}" 
                                                            alt="No image" 
                                                            style="width: 80px; height: 80px; object-fit: cover;">
                                                    @endif
                                                </td>
                                                <td class="cart-title first-row">
                                                    @if($item->product)
                                                        <h5>{{ $item->product->name }}</h5>                                       
                                                        @php
                                                            $colorMap = config('convertColor.colors');
                                                            $rawColor = $item->color ?? null;
                                                            $productSize = $item->size ?? null;
                                                            
                                                            $displayColor = $colorMap[$rawColor] ?? $rawColor;
                                                        @endphp
                                                        
                                                        @if ($rawColor || $productSize)
                                                            <p style="font-size: 14px; color: #666; margin-top: 5px;">
                                                                @if ($rawColor)
                                                                    Màu: {{ $displayColor }}
                                                                @endif
                                                                @if ($productSize)
                                                                    @if ($rawColor) / @endif Size: {{ $productSize }}
                                                                @endif
                                                            </p>
                                                        @endif
                                                    @else
                                                        <h5>Sản phẩm ID: {{ $item->product_id }}</h5>
                                                    @endif
                                                </td>
                                                <td class="p-price first-row">{{ number_format($item->amount, 0, ',', '.') }}đ</td>
                                                <td class="qua-col first-row">
                                                    <div style="text-align: center;">
                                                        <strong>x{{ $item->qty }}</strong>
                                                    </div>
                                                </td>
                                                <td class="total-price first-row">
                                                    <strong>{{ number_format($itemSubtotal, 0, ',', '.') }}đ</strong>
                                                </td>
                                            </tr>
                                        @endforeach

                                        <!-- Tổng cộng -->
                                        <tr style="background-color: #f8f9fa;">
                                            <td colspan="4" class="text-right" style="padding: 15px; font-weight: 600; text-align: right;">
                                                Tạm tính:
                                            </td>
                                            <td class="total-price" style="padding: 15px;">
                                                <strong>{{ number_format($subtotal, 0, ',', '.') }}đ</strong>
                                            </td>
                                        </tr>

                                        @if($shippingFee > 0)
                                        <tr style="background-color: #f8f9fa;">
                                            <td colspan="4" class="text-right" style="padding: 15px; font-weight: 600; text-align: right;">
                                                Phí vận chuyển:
                                            </td>
                                            <td class="total-price" style="padding: 15px;">
                                                <strong>{{ number_format($shippingFee, 0, ',', '.') }}đ</strong>
                                            </td>
                                        </tr>
                                        @endif

                                        @if($totalVoucherDiscount > 0)
                                        <tr style="background-color: #e8f5e9;">
                                            <td colspan="4" class="text-right" style="padding: 15px; font-weight: 600; text-align: right;">
                                                <i class="fa fa-ticket-alt" style="color: #28a745;"></i> Giảm giá voucher 
                                                @if($voucherInfo)
                                                    <span style="color: #28a745; font-weight: bold;">({{ $voucherInfo->code }})</span>
                                                @endif
                                                :
                                            </td>
                                            <td class="total-price" style="padding: 15px;">
                                                <strong style="color: #28a745;">-{{ number_format($totalVoucherDiscount, 0, ',', '.') }}đ</strong>
                                            </td>
                                        </tr>
                                        @endif

                                        <tr style="background-color: #fff3cd;">
                                            <td colspan="4" class="text-right" style="padding: 15px; font-weight: 600; font-size: 18px; text-align: right;">
                                                Tổng tiền:
                                            </td>
                                            <td class="total-price" style="padding: 15px;">
                                                <strong style="color: #ca1515; font-size: 18px;">
                                                    {{ number_format(($subtotal + $shippingFee - $totalVoucherDiscount), 0, ',', '.') }}đ
                                                </strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Nút hành động -->
                    <div class="row mt-4">
                        <div class="col-lg-12 text-center">                         
                            <a href="/shop" class="primary-btn" style="margin-left: 10px;">Tiếp tục mua sắm</a>
                            @php
                                // Kiểm tra điều kiện hiển thị nút hủy
                                $canCancel = $order->payment_type == 'COD' && 
                                    in_array($order->status, [
                                        Constant::order_status_Unconfirmed,
                                        Constant::order_status_Confirmed,
                                        Constant::order_status_Processing
                                    ]);
                            @endphp

                            @if($canCancel)
                                <button type="button" class="primary-btn" style="margin-left: 10px; background-color: #dc3545;" 
                                    onclick="confirmCancel({{ $order->id }})">
                                    Hủy đơn hàng
                                </button>

                                <!-- Form ẩn để submit -->
                                <form id="cancel-form-{{ $order->id }}" 
                                    action="{{ route('user.orders.cancel', $order->id) }}" 
                                    method="POST" 
                                    style="display: none;">
                                    @csrf
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Order Detail Section End -->

@endsection

@section('styles')
    <style>
        .card {
            border: 1px solid #dee2e6;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .card-header {
            border-bottom: 1px solid #dee2e6;
        }
        
        .cart-table table {
            margin-bottom: 0;
        }
        
        .cart-table table tbody tr td {
            vertical-align: middle;
        }
        
        .text-right {
            text-align: right;
        }
        
        .primary-btn {
            display: inline-block;
            padding: 12px 30px;
            text-decoration: none;
        }
    </style>
@endsection

@section('scripts')
    <script>
    // Hàm xác nhận hủy đơn hàng
    function confirmCancel(orderId) {
        Swal.fire({
            title: 'Xác nhận hủy đơn hàng',
            html: `Bạn có chắc chắn muốn hủy đơn hàng <strong>#${orderId}</strong>?<br><small style="color: #666;">Hành động này không thể hoàn tác.</small>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fa fa-times"></i> Hủy đơn hàng',
            cancelButtonText: '<i class="fa fa-arrow-left"></i> Quay lại',
            reverseButtons: true,
            focusCancel: true,
            customClass: {
                popup: 'swal-custom-popup',
                confirmButton: 'swal-custom-confirm',
                cancelButton: 'swal-custom-cancel'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Hiển thị loading
                Swal.fire({
                    title: 'Đang xử lý...',
                    text: 'Vui lòng đợi trong giây lát',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Submit form
                document.getElementById('cancel-form-' + orderId).submit();
            }
        });
    }

    // Hiển thị thông báo success/error từ session
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Thành công!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#28a745',
                confirmButtonText: 'Đóng',
                timer: 5000,
                timerProgressBar: true,
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Lỗi!',
                text: '{{ session('error') }}',
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'Đóng',
                timer: 5000,
                timerProgressBar: true,
            });
        @endif
    });

    // Auto dismiss alert sau 5 giây
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        });
    }, 5000);
    </script>

    <style>
    /* Custom style cho SweetAlert2 */
    .swal-custom-popup {
        font-family: Arial, sans-serif;
    }

    .swal-custom-confirm {
        padding: 10px 24px !important;
        font-weight: 600 !important;
    }

    .swal-custom-cancel {
        padding: 10px 24px !important;
        font-weight: 600 !important;
    }

    .swal2-html-container {
        line-height: 1.6 !important;
    }

    /* Style cho alert Bootstrap */
    .alert {
        position: relative;
        border-radius: 5px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .alert .close {
        position: absolute;
        top: 50%;
        right: 15px;
        transform: translateY(-50%);
        font-size: 24px;
        font-weight: 300;
        line-height: 1;
        color: inherit;
        opacity: 0.5;
        background: none;
        border: none;
        cursor: pointer;
        padding: 0;
    }

    .alert .close:hover {
        opacity: 0.8;
    }
    </style>
@endsection