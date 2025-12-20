@extends('admin.layout.master')
@section('title', 'Voucher Detail')
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
                        Chi tiết Voucher
                        <div class="page-title-subheading">
                            Xem thông tin chi tiết mã khuyến mãi.
                        </div>
                    </div>
                </div>
                
                <div class="page-title-actions">
                    <a href="{{ route('voucher.index') }}" class="btn-shadow mr-3 btn btn-dark">
                        <i class="fa fa-arrow-left"></i> Quay lại
                    </a>
                    <a href="{{ route('voucher.edit', $voucher->id) }}" class="btn-shadow mr-3 btn btn-primary">
                        <i class="fa fa-edit"></i> Chỉnh sửa
                    </a>
                    <form action="{{ route('voucher.destroy', $voucher->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Bạn có chắc muốn xóa voucher này?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-shadow btn btn-danger">
                            <i class="fa fa-trash"></i> Xóa
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        
                        <!-- Tiêu đề và mã -->
                        <div class="position-relative row form-group">
                            <label class="col-md-3 text-md-right col-form-label font-weight-bold">
                                <i class="fa fa-tag mr-2"></i>Tiêu đề khuyến mãi
                            </label>
                            <div class="col-md-9 col-xl-8">
                                <p class="form-control-plaintext">{{ $voucher->title }}</p>
                            </div>
                        </div>

                        <div class="position-relative row form-group">
                            <label class="col-md-3 text-md-right col-form-label font-weight-bold">
                                <i class="fa fa-barcode mr-2"></i>Mã khuyến mãi
                            </label>
                            <div class="col-md-9 col-xl-8">
                                <span class="badge badge-primary" style="font-size: 16px; padding: 8px 15px;">
                                    {{ $voucher->code }}
                                </span>
                            </div>
                        </div>
                    
                        <!-- Loại khuyến mãi -->
                        <div class="position-relative row form-group">
                            <label class="col-md-3 text-md-right col-form-label font-weight-bold">
                                <i class="fa fa-list-alt mr-2"></i>Loại khuyến mãi
                            </label>
                            <div class="col-md-9 col-xl-8">
                                @if($voucher->type == 1)
                                    <span class="badge badge-info" style="font-size: 14px; padding: 6px 12px;">
                                        <i class="fa fa-percent mr-1"></i>Giảm theo phần trăm
                                    </span>
                                @else
                                    <span class="badge badge-success" style="font-size: 14px; padding: 6px 12px;">
                                        <i class="fa fa-money-bill-wave mr-1"></i>Giảm giá cố định
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Giá trị giảm -->
                        <div class="position-relative row form-group">
                            <label class="col-md-3 text-md-right col-form-label font-weight-bold">
                                <i class="fa fa-gift mr-2"></i>Giá trị giảm
                            </label>
                            <div class="col-md-9 col-xl-8">
                                @if($voucher->type == 1)
                                    <h4 class="text-danger mb-0">
                                        <strong>{{ number_format($voucher->reduce, 0, ',', '.') }}%</strong>
                                    </h4>
                                @else
                                    <h4 class="text-danger mb-0">
                                        <strong>{{ number_format($voucher->reduce, 0, ',', '.') }}đ</strong>
                                    </h4>
                                @endif
                            </div>
                        </div>

                        <!-- Giảm tối đa - CHỈ HIỂN THỊ KHI TYPE = 1 VÀ CÓ GIÁ TRỊ -->
                        @if($voucher->type == 1 && $voucher->max_discount)
                            <div class="position-relative row form-group">
                                <label class="col-md-3 text-md-right col-form-label font-weight-bold">
                                    <i class="fa fa-hand-holding-usd mr-2"></i>Giảm tối đa
                                </label>
                                <div class="col-md-9 col-xl-8">
                                    <h5 class="text-warning mb-0">
                                        <strong>{{ number_format($voucher->max_discount, 0, ',', '.') }}đ</strong>
                                    </h5>
                                    <small class="text-muted">Số tiền giảm tối đa có thể nhận được</small>
                                </div>
                            </div>
                        @endif

                        <!-- Số lượng -->
                        <div class="position-relative row form-group">
                            <label class="col-md-3 text-md-right col-form-label font-weight-bold">
                                <i class="fa fa-sort-numeric-up mr-2"></i>Số lượng
                            </label>
                            <div class="col-md-9 col-xl-8">
                                <p class="form-control-plaintext">
                                    <span class="badge badge-secondary" style="font-size: 14px; padding: 6px 12px;">
                                        {{ $voucher->qty }} lần sử dụng
                                    </span>
                                </p>
                            </div>
                        </div>
                        
                        <hr class="my-4">

                        <!-- Đơn hàng tối thiểu -->
                        <div class="position-relative row form-group">
                            <label class="col-md-3 text-md-right col-form-label font-weight-bold">
                                <i class="fa fa-wallet mr-2"></i>Đơn hàng tối thiểu
                            </label>
                            <div class="col-md-9 col-xl-8">
                                @if ($voucher->min_total_value > 0)
                                    <span class="badge badge-warning" style="font-size: 14px; padding: 6px 12px;">
                                        {{ number_format($voucher->min_total_value, 0, ',', '.') }}đ
                                    </span>
                                @else
                                    <span class="badge badge-success" style="font-size: 14px; padding: 6px 12px;">
                                        Không giới hạn
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Ngày bắt đầu -->
                        <div class="position-relative row form-group">
                            <label class="col-md-3 text-md-right col-form-label font-weight-bold">
                                <i class="fa fa-calendar-check mr-2"></i>Ngày bắt đầu
                            </label>
                            <div class="col-md-9 col-xl-8">
                                <p class="form-control-plaintext">
                                    <i class="fa fa-clock mr-1 text-primary"></i>
                                    {{ \Carbon\Carbon::parse($voucher->start_date)->format('d/m/Y') }}
                                </p>
                            </div>
                        </div>

                        <!-- Ngày hết hạn -->
                        <div class="position-relative row form-group">
                            <label class="col-md-3 text-md-right col-form-label font-weight-bold">
                                <i class="fa fa-calendar-times mr-2"></i>Ngày hết hạn
                            </label>
                            <div class="col-md-9 col-xl-8">
                                <p class="form-control-plaintext">
                                    <i class="fa fa-clock mr-1 text-danger"></i>
                                    {{ \Carbon\Carbon::parse($voucher->end_date)->format('d/m/Y') }}
                                </p>
                            </div>
                        </div>

                        <!-- Trạng thái -->
                        <div class="position-relative row form-group">
                            <label class="col-md-3 text-md-right col-form-label font-weight-bold">
                                <i class="fa fa-info-circle mr-2"></i>Trạng thái
                            </label>
                            <div class="col-md-9 col-xl-8">
                                @php
                                    $now = now();
                                    $startDate = \Carbon\Carbon::parse($voucher->start_date)->startOfDay();
                                    $endDate = \Carbon\Carbon::parse($voucher->end_date)->endOfDay();
                                @endphp
                                
                                @if($voucher->qty <= 0)
                                    <span class="badge badge-secondary" style="font-size: 14px; padding: 6px 12px;">
                                        <i class="fa fa-times-circle mr-1"></i>Đã hết lượt sử dụng
                                    </span>
                                @elseif($now < $startDate)
                                    <span class="badge badge-warning" style="font-size: 14px; padding: 6px 12px;">
                                        <i class="fa fa-clock mr-1"></i>Chưa đến thời gian áp dụng
                                    </span>
                                @elseif($now > $endDate)
                                    <span class="badge badge-danger" style="font-size: 14px; padding: 6px 12px;">
                                        <i class="fa fa-ban mr-1"></i>Đã hết hạn
                                    </span>
                                @else
                                    <span class="badge badge-success" style="font-size: 14px; padding: 6px 12px;">
                                        <i class="fa fa-check-circle mr-1"></i>Đang hoạt động
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Thời gian tạo -->
                        <hr class="my-4">
                        
                        <div class="position-relative row form-group">
                            <label class="col-md-3 text-md-right col-form-label font-weight-bold">
                                <i class="fa fa-calendar-plus mr-2"></i>Ngày tạo
                            </label>
                            <div class="col-md-9 col-xl-8">
                                <p class="form-control-plaintext text-muted">
                                    {{ $voucher->created_at->format('H:i - d/m/Y') }}
                                </p>
                            </div>
                        </div>

                        <div class="position-relative row form-group">
                            <label class="col-md-3 text-md-right col-form-label font-weight-bold">
                                <i class="fa fa-calendar-edit mr-2"></i>Cập nhật lần cuối
                            </label>
                            <div class="col-md-9 col-xl-8">
                                <p class="form-control-plaintext text-muted">
                                    {{ $voucher->updated_at->format('H:i - d/m/Y') }}
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Main -->

@endsection