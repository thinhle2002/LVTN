@extends('admin.layout.master')
@section('title', 'Product Detail')
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
                        Product detail
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
                    <div class="card-body">
                        <form method="post" action="admin/product/{{ $product->id }}/detail/{{ $productDetail->id }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="position-relative row form-group">
                                <label class="col-md-3 text-md-right col-form-label">Tên sản phẩm</label>
                                <div class="col-md-9 col-xl-8">
                                    <input disabled placeholder="Nhập tên sản phẩm" type="text"
                                        class="form-control" value="{{ $product->name }}">
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="color" class="col-md-3 text-md-right col-form-label">Màu sắc</label>
                                <div class="col-md-9 col-xl-8">
                                    <input required name="color" id="color" placeholder="Color" type="text"
                                        class="form-control" value="{{ $productDetail->color }}">
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="size" class="col-md-3 text-md-right col-form-label">Kích cỡ</label>
                                <div class="col-md-9 col-xl-8">
                                    <input required name="size" id="size" placeholder="Size" type="text"
                                        class="form-control" value="{{ $productDetail->size }}">
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="qty" class="col-md-3 text-md-right col-form-label">Số lượng</label>
                                <div class="col-md-9 col-xl-8">
                                    <input required name="qty" id="qty" placeholder="Qty" type="text"
                                        class="form-control" value="{{ $productDetail->qty }}">
                                </div>
                            </div>
                            <div class="position-relative row form-group">
                                <label for="image_id" class="col-md-3 text-md-right col-form-label">
                                    Chọn hình ảnh sản phẩm
                                </label>

                                <div class="col-md-9 col-xl-8">
                                    <div class="d-flex flex-wrap gap-3">

                                        @foreach($product->productImages as $productImage)
                                            <label style="cursor:pointer; text-align:center; margin-right:15px">
                                                <input
                                                    type="radio"
                                                    name="image_id"
                                                    value="{{ $productImage->id }}"
                                                    required
                                                    onclick="selectImage(this)"
                                                    {{ $productDetail->image_id == $productImage->id ? 'checked' : '' }}
                                                    style="display:none"
                                                >

                                                <img
                                                    src="{{ asset('upload/front/img/products/'.$productImage->path) }}"
                                                    class="img-select"
                                                    style="
                                                        width:100px;
                                                        height:120px;
                                                        object-fit:cover;
                                                        border:2px solid
                                                            {{ $productDetail->image_id == $productImage->id ? '#007bff' : '#ddd' }};
                                                        border-radius:6px;
                                                        padding:3px;
                                                    "
                                                >

                                                <div style="font-size:12px; margin-top:5px">
                                                    ID: {{ $productImage->id }}
                                                </div>
                                            </label>
                                        @endforeach

                                    </div>
                                </div>
                            </div>

                            <div class="position-relative row form-group mb-1">
                                <div class="col-md-9 col-xl-8 offset-md-2">
                                    <a href="./admin/product/{{ $product->id }}/detail" class="border-0 btn btn-outline-danger mr-1">
                                        <span class="btn-icon-wrapper pr-1 opacity-8">
                                            <i class="fa fa-times fa-w-20"></i>
                                        </span>
                                        <span>Hủy</span>
                                    </a>

                                    <button type="submit"
                                        class="btn-shadow btn-hover-shine btn btn-primary">
                                        <span class="btn-icon-wrapper pr-2 opacity-8">
                                            <i class="fa fa-download fa-w-20"></i>
                                        </span>
                                        <span>Lưu</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Main -->
    <script>
        function selectImage(el) {
            document.querySelectorAll('.img-select').forEach(img => {
                img.style.border = '2px solid #ddd';
            });

            const img = el.closest('label').querySelector('.img-select');
            if (img) {
                img.style.border = '2px solid #007bff';
            }
        }
    </script>
@endsection
                