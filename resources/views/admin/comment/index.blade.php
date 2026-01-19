@extends('admin.layout.master')
@section('title', 'Comments')
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
                        Comments
                        <div class="page-title-subheading">
                            View, create, update, and manage.
                        </div>
                    </div>
                </div>

                {{-- <div class="page-title-actions">
                    <a href="./admin/voucher/create" class="btn-shadow btn-hover-shine mr-3 btn btn-primary">
                        <span class="btn-icon-wrapper pr-2 opacity-7">
                            <i class="fa fa-plus fa-w-20"></i>
                        </span>
                        Thêm
                    </a>
                </div> --}}
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

                        {{-- <div class="btn-actions-pane-right">
                            <div role="group" class="btn-group-sm btn-group">
                                <button class="btn btn-focus">This week</button>
                                <button class="active btn btn-focus">Anytime</button>
                            </div>
                        </div> --}}
                    </div>

                    <div class="table-responsive">
                        <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th>Tên sản phẩm</th>
                                    <th class="text-center">Tên khách hàng</th>
                                    <th class="text-center">Đánh giá</th>
                                    <th class="text-center">Số sao</th>
                                    <th class="text-center">Thao tác</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($comments as $comment)
                                    <tr>
                                        <td class="text-center text-muted">#{{ $comment->id }}</td>
                                        <td>{{ $comment->product ? $comment->product->name : 'N/A' }}</td>
                                        <td class="text-center">
                                            {{ $comment->user ? $comment->user->name : 'N/A' }}
                                        </td>
                                        <td class="text-center">{{ $comment->messages }}</td>
                                        <td class="text-center">{{ $comment->rating }}</td>                                    
                                        <td class="text-center">
                                            <a href="./admin/comment/{{ $comment->id }}" data-toggle="tooltip"
                                                class="btn btn-hover-shine btn-outline-primary border-0 btn-sm">
                                                Chi tiết
                                            </a>
                                            <form class="d-inline" action="{{ route('comment.destroy', $comment->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-hover-shine btn-outline-danger border-0 btn-sm"
                                                    type="submit" data-toggle="tooltip" title="Xóa"
                                                    data-placement="bottom"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa comment này?')">
                                                    <span class="btn-icon-wrapper opacity-8">
                                                        <i class="fa fa-trash fa-w-20"></i>
                                                    </span>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-block card-footer">
                        {{ $comments->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- End Main -->

@endsection
               