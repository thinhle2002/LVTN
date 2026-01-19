@extends('front.layout.master')
@section('title', 'Mã khuyến mãi')

@section('body')

<!-- Breadcrumb Section Begin -->
<div class="breacrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <a href="./"><i class="fa fa-home"></i> Trang chủ</a>
                    <span>Mã khuyến mãi</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Section End -->

<!-- Voucher Section Begin -->
<section class="voucher-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>Danh sách mã khuyến mãi</h2>
                    <p>Sao chép mã và áp dụng ngay khi thanh toán để nhận ưu đãi!</p>
                </div>
            </div>
        </div>

        <div class="row">
            @forelse($vouchers as $voucher)
                @php
                    $now = \Carbon\Carbon::now();
                    $startDate = \Carbon\Carbon::parse($voucher->start_date)->startOfDay();
                    $endDate = \Carbon\Carbon::parse($voucher->end_date)->endOfDay();

                    
                    $isActive = $now->between($startDate, $endDate) && $voucher->qty > 0;
                    $isExpired = $now->greaterThan($endDate);
                    $isUpcoming = $now->lessThan($startDate);
                    $isOutOfStock = $voucher->qty <= 0;
                    
                    
                    $status = '';
                    $statusClass = '';
                    if ($isActive) {
                        $status = 'Đang áp dụng';
                        $statusClass = 'status-active';
                    } elseif ($isExpired) {
                        $status = 'Đã hết hạn';
                        $statusClass = 'status-expired';
                    } elseif ($isUpcoming) {
                        $status = 'Sắp diễn ra';
                        $statusClass = 'status-upcoming';
                    } elseif ($isOutOfStock) {
                        $status = 'Đã hết lượt';
                        $statusClass = 'status-out';
                    }
                    
                    $cardClass = $isActive ? '' : 'voucher-inactive';
                @endphp

                <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
                    <div class="voucher-card {{ $cardClass }}">
                        <div class="voucher-header">
                            <div class="voucher-left">
                                <div class="voucher-icon">
                                    <i class="fa fa-gift"></i>
                                </div>
                            </div>
                            <div class="voucher-right">
                                <h4 class="voucher-title">{{ $voucher->title }}</h4>
                                <div class="voucher-discount">
                                    @if($voucher->type == 1)
                                        <span class="discount-value">{{ $voucher->reduce }}%</span>
                                        <span class="discount-label">Giảm giá</span>
                                    @else
                                        <span class="discount-value">{{ number_format($voucher->reduce, 0, ',', '.') }}đ</span>
                                        <span class="discount-label">Giảm tiền</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="voucher-body">
                            <div class="voucher-code-wrapper">
                                <span class="code-label">Mã:</span>
                                <span class="voucher-code" id="code-{{ $voucher->id }}">{{ $voucher->code }}</span>
                                @if($isActive)
                                    <button class="btn-copy" onclick="copyVoucherCode('{{ $voucher->code }}', {{ $voucher->id }})">
                                        <i class="fa fa-copy"></i> Sao chép
                                    </button>
                                @endif
                            </div>

                            <div class="voucher-info">
                                <div class="info-item">
                                    <i class="fa fa-calendar"></i>
                                    <span>Từ {{ \Carbon\Carbon::parse($voucher->start_date)->format('d/m/Y') }}</span>
                                </div>
                                <div class="info-item">
                                    <i class="fa fa-calendar-times-o"></i>
                                    <span>Đến hết {{ \Carbon\Carbon::parse($voucher->end_date)->format('d/m/Y') }}</span>
                                </div>
                                <div class="info-item">
                                    <i class="fa fa-money"></i>
                                    <span>
                                        @if($voucher->min_total_value && $voucher->min_total_value > 0)
                                            Áp dụng cho đơn hàng trên {{ number_format($voucher->min_total_value, 0, ',', '.') }}đ
                                        @else
                                            Áp dụng mọi đơn hàng
                                        @endif
                                    </span>
                                </div>
                                <div class="info-item">
                                    <i class="fa fa-ticket"></i>
                                    <span>Còn lại: {{ $voucher->qty }} lượt</span>
                                </div>
                            </div>

                            <div class="voucher-status {{ $statusClass }}">
                                <span>{{ $status }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-lg-12">
                    <div class="text-center py-5">
                        <i class="fa fa-ticket" style="font-size: 64px; color: #ccc;"></i>
                        <h4 class="mt-3">Chưa có mã khuyến mãi nào</h4>
                        <p class="text-muted">Vui lòng quay lại sau để nhận ưu đãi!</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>
<!-- Voucher Section End -->

<style>
    .breacrumb-section {
        padding: 15px 0;
        background: #f3f6fa;
    }

    .breadcrumb-text a {
        color: #252525;
    }

    .breadcrumb-text span {
        color: #000000;
    }

    .section-title {
        text-align: center;
        margin-bottom: 50px;
    }

    .section-title h2 {
        color: #252525;
        font-weight: 700;
        font-size: 34px;
        margin-bottom: 15px;
    }

    .section-title p {
        color: #888;
        font-size: 16px;
    }

    .voucher-card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: all 0.3s ease;
        position: relative;
    }

    .voucher-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }

    .voucher-card.voucher-inactive {
        opacity: 0.5;
        filter: grayscale(50%);
    }

    .voucher-card.voucher-inactive:hover {
        transform: none;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }

    .voucher-header {
        background: linear-gradient(135deg, #ca1515 0%, #e91e63 100%);
        padding: 25px;
        display: flex;
        align-items: center;
        color: #fff;
    }

    .voucher-card.voucher-inactive .voucher-header {
        background: linear-gradient(135deg, #999 0%, #666 100%);
    }

    .voucher-left {
        margin-right: 20px;
    }

    .voucher-icon {
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
    }

    .voucher-right {
        flex: 1;
    }

    .voucher-title {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 8px;
        color: #fff;
    }

    .voucher-discount {
        display: flex;
        align-items: baseline;
        gap: 8px;
    }

    .discount-value {
        font-size: 28px;
        font-weight: 700;
    }

    .discount-label {
        font-size: 14px;
        opacity: 0.9;
    }

    .voucher-body {
        padding: 25px;
    }

    .voucher-code-wrapper {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        border: 2px dashed #ca1515;
    }

    .voucher-card.voucher-inactive .voucher-code-wrapper {
        border-color: #999;
    }

    .code-label {
        color: #666;
        font-weight: 600;
        margin-right: 10px;
    }

    .voucher-code {
        font-size: 20px;
        font-weight: 700;
        color: #ca1515;
        letter-spacing: 2px;
        flex: 1;
    }

    .voucher-card.voucher-inactive .voucher-code {
        color: #999;
    }

    .btn-copy {
        background: #ca1515;
        color: #fff;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-copy:hover {
        background: #a01010;
        transform: scale(1.05);
    }

    .btn-copy i {
        margin-right: 5px;
    }

    .voucher-info {
        margin-bottom: 15px;
    }

    .info-item {
        display: flex;
        align-items: center;
        color: #666;
        margin-bottom: 10px;
        font-size: 14px;
    }

    .info-item i {
        color: #ca1515;
        margin-right: 10px;
        width: 20px;
    }

    .voucher-card.voucher-inactive .info-item i {
        color: #999;
    }

    .voucher-status {
        text-align: center;
        padding: 10px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 14px;
    }

    .status-active {
        background: #d4edda;
        color: #155724;
    }

    .status-expired {
        background: #f8d7da;
        color: #721c24;
    }

    .status-upcoming {
        background: #fff3cd;
        color: #856404;
    }

    .status-out {
        background: #e2e3e5;
        color: #383d41;
    }

    @media (max-width: 768px) {
        .voucher-header {
            flex-direction: column;
            text-align: center;
        }
        
        .voucher-left {
            margin-right: 0;
            margin-bottom: 15px;
        }
        
        .voucher-code-wrapper {
            flex-direction: column;
            text-align: center;
            gap: 10px;
        }
        
        .btn-copy {
            width: 100%;
        }
    }
</style>

<script>
    function copyVoucherCode(code, voucherId) {
        // Tạo một textarea tạm để copy
        const tempInput = document.createElement('textarea');
        tempInput.value = code;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand('copy');
        document.body.removeChild(tempInput);
        
        // Hiển thị thông báo
        Swal.fire({
            icon: 'success',
            title: 'Đã sao chép!',
            text: 'Mã khuyến mãi "' + code + '" đã được sao chép vào clipboard',
            timer: 2000,
            showConfirmButton: false
        });
    }
</script>

@endsection