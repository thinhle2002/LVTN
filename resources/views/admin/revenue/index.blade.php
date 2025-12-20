@extends('admin.layout.master')
@section('title', 'Doanh thu sản phẩm')
@section('body')

<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-graph2 icon-gradient bg-mean-fruit"></i>
                </div>
                <div>
                    Doanh thu sản phẩm
                    <div class="page-title-subheading">
                        Xem thống kê doanh thu theo sản phẩm
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bộ lọc -->
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="main-card card">
                <div class="card-body">
                    <form method="GET" action="{{ route('revenue.index') }}">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Từ ngày</label>
                                    <input type="date" name="from_date" class="form-control" 
                                           value="{{ $fromDate }}" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Đến ngày</label>
                                    <input type="date" name="to_date" class="form-control" 
                                           value="{{ $toDate }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tìm kiếm sản phẩm</label>
                                    <input type="text" name="search" class="form-control" 
                                           value="{{ $search }}" placeholder="Nhập tên sản phẩm">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="fa fa-search"></i> Lọc
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Thẻ thống kê tổng quan -->
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="card mb-3 widget-chart">
                <div class="widget-chart-content">
                    <div class="icon-wrapper rounded-circle">
                        <div class="icon-wrapper-bg bg-primary"></div>
                        <i class="lnr-cart text-primary"></i>
                    </div>
                    <div class="widget-numbers">
                        {{ number_format($summary->total_products ?? 0, 0, ',', '.') }}
                    </div>
                    <div class="widget-subheading">Tổng số sản phẩm đã bán</div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-3 widget-chart">
                <div class="widget-chart-content">
                    <div class="icon-wrapper rounded-circle">
                        <div class="icon-wrapper-bg bg-success"></div>
                        <i class="lnr-database text-success"></i>
                    </div>
                    <div class="widget-numbers text-success">
                        {{ number_format(($summary->total_revenue ?? 0), 0, ',', '.') }}đ
                    </div>
                    <div class="widget-subheading">Tổng doanh thu</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bảng doanh thu -->
    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-header">
                    <div class="card-header-title">
                        <i class="header-icon lnr-chart-bars icon-gradient bg-mean-fruit"></i>
                        Danh sách doanh thu theo sản phẩm
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">STT</th>
                                <th>Tên sản phẩm</th>
                                <th class="text-center">Số lượng bán</th>
                                <th class="text-center">Doanh thu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($revenueData as $index => $item)
                                <tr>
                                    <td class="text-center">
                                        {{ ($revenueData->currentPage() - 1) * $revenueData->perPage() + $index + 1 }}
                                    </td>
                                    <td>
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left flex2">
                                                    <div class="widget-heading">{{ $item->product_name }}</div>
                                                    <div class="widget-subheading opacity-7">
                                                        Mã SP: #{{ $item->product_id }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="badge badge-info">
                                            {{ number_format($item->total_quantity, 0, ',', '.') }}
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-success font-weight-bold">
                                            {{ number_format($item->total_revenue, 0, ',', '.') }}đ
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">
                                        <div class="p-5">
                                            <i class="fa fa-inbox fa-3x text-muted mb-3"></i>
                                            <p>Không có dữ liệu trong khoảng thời gian này</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($revenueData->total() > 0)
                    <div class="d-block card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                Hiển thị {{ $revenueData->firstItem() }} - {{ $revenueData->lastItem() }} 
                                trong tổng số {{ $revenueData->total() }} kết quả
                            </div>
                            <div>
                                {{ $revenueData->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    <script>
        // Auto submit form when date changes
        $('input[name="from_date"], input[name="to_date"]').on('change', function() {
            // Optional: auto submit form
            // $(this).closest('form').submit();
        });
    </script>
@endsection