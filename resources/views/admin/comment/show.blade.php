@extends('admin.layout.master')
@section('title', 'Chi tiết Comment')
@section('body')

<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-comment icon-gradient bg-mean-fruit"></i>
                </div>
                <div>
                    Chi tiết Comment
                    <div class="page-title-subheading">
                        Xem thông tin chi tiết đánh giá của khách hàng
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <div class="position-relative row form-group">
                        <label class="col-md-3 text-md-right col-form-label">ID</label>
                        <div class="col-md-9 col-xl-8">
                            <p class="form-control-plaintext">#{{ $comment->id }}</p>
                        </div>
                    </div>

                    <div class="position-relative row form-group">
                        <label class="col-md-3 text-md-right col-form-label">Sản phẩm</label>
                        <div class="col-md-9 col-xl-8">
                            <p class="form-control-plaintext">
                                {{ $comment->product ? $comment->product->name : 'N/A' }}
                            </p>
                        </div>
                    </div>

                    <div class="position-relative row form-group">
                        <label class="col-md-3 text-md-right col-form-label">Khách hàng</label>
                        <div class="col-md-9 col-xl-8">
                            <p class="form-control-plaintext">
                                {{ $comment->user ? $comment->user->name : 'N/A' }}
                            </p>
                        </div>
                    </div>

                    <div class="position-relative row form-group">
                        <label class="col-md-3 text-md-right col-form-label">Số sao</label>
                        <div class="col-md-9 col-xl-8">
                            <p class="form-control-plaintext">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fa fa-star{{ $i <= $comment->rating ? '' : '-o' }}" 
                                       style="color: #ffa500;"></i>
                                @endfor
                                ({{ $comment->rating }}/5)
                            </p>
                        </div>
                    </div>

                    <div class="position-relative row form-group">
                        <label class="col-md-3 text-md-right col-form-label">Nội dung đánh giá</label>
                        <div class="col-md-9 col-xl-8">
                            <p class="form-control-plaintext">{{ $comment->messages }}</p>
                        </div>
                    </div>

                    <div class="position-relative row form-group">
                        <label class="col-md-3 text-md-right col-form-label">Ngày tạo</label>
                        <div class="col-md-9 col-xl-8">
                            <p class="form-control-plaintext">
                                {{ $comment->created_at->format('d/m/Y H:i:s') }}
                            </p>
                        </div>
                    </div>

                    <div class="position-relative row form-group mb-1">
                        <div class="col-md-9 col-xl-8 offset-md-3">
                            <a href="{{ route('comment.index') }}" class="btn btn-outline-secondary mr-1">
                                <i class="fa fa-arrow-left"></i> Quay lại
                            </a>
                            
                            <form class="d-inline" action="{{ route('comment.destroy', $comment->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa comment này?')">
                                    <i class="fa fa-trash"></i> Xóa
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection