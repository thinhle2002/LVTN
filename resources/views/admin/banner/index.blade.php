@extends('admin.layout.master')
@section('title', 'Danh sách Banner')
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
                        Quản lý Banner
                        <div class="page-title-subheading">
                            Danh sách tất cả banner trên trang web
                        </div>
                    </div>
                </div>
                <div class="page-title-actions">
                    <a href="{{ route('banner.create') }}" class="btn-shadow btn-hover-shine mr-3 btn btn-primary">
                        <span class="btn-icon-wrapper pr-2 opacity-7">
                            <i class="fa fa-plus fa-w-20"></i>
                        </span>
                        Thêm
                    </a> 
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card">

                    <div class="card-header">
                        Danh Sách Banner
                    </div>

                    <div class="table-responsive">
                        <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th>Hình Ảnh</th>
                                    <th>Tiêu đề</th>
                                    <th class="text-center">Trạng Thái</th>
                                    <th class="text-center">Hành Động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($banners as $banner)
                                    <tr>
                                        <td class="text-center text-muted">#{{ $banner->id }}</td>
                                        <td class="text-center">
                                            @if($banner->image)
                                                <img src="{{ asset('upload/front/img/banners/' . $banner->image) }}" 
                                                     alt="{{ $banner->name }}"
                                                     style="width: 100px; height: 60px; object-fit: cover; border-radius: 4px;">
                                            @else
                                                <span class="badge badge-secondary">Chưa có ảnh</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left flex2">
                                                        <div class="widget-heading">{{ $banner->title }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @if($banner->active)
                                                <span class="badge badge-success">Kích hoạt</span>
                                            @else
                                                <span class="badge badge-secondary">Tắt</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('banner.edit', $banner->id) }}" 
                                               class="btn btn-hover-shine btn-outline-primary border-0 btn-sm">
                                                Sửa
                                            </a>
                                            <form action="{{ route('banner.destroy', $banner->id) }}" 
                                                  method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        onclick="return confirm('Bạn có chắc muốn xóa banner này?')"
                                                        class="btn btn-hover-shine btn-outline-danger border-0 btn-sm">
                                                    Xóa
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- End Main -->
@endsection