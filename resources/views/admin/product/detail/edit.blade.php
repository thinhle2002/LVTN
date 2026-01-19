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
                                        class="form-control" value="{{ $productDetail->color }}" readonly>
                                    
                                    <!-- Bảng màu -->
                                    <div class="color-palette mt-3">
                                        <p class="mb-2" style="font-size: 13px; color: #666;">Chọn màu từ bảng màu:</p>
                                        <div class="color-options d-flex flex-wrap gap-2">
                                            <div class="color-item {{ $productDetail->color == 'pink' ? 'selected' : '' }}" 
                                                 data-color="pink" title="Hồng">
                                                <div class="color-box" style="background-color: #F7BFCB;"></div>
                                                <span class="color-name">Pink</span>
                                            </div>
                                            <div class="color-item {{ $productDetail->color == 'gray' ? 'selected' : '' }}" 
                                                 data-color="gray" title="Xám">
                                                <div class="color-box" style="background-color: #7F7F7F;"></div>
                                                <span class="color-name">Gray</span>
                                            </div>
                                            <div class="color-item {{ $productDetail->color == 'yellow' ? 'selected' : '' }}" 
                                                 data-color="yellow" title="Vàng">
                                                <div class="color-box" style="background-color: #FFD93E;"></div>
                                                <span class="color-name">Yellow</span>
                                            </div>
                                            <div class="color-item {{ $productDetail->color == 'lavender' ? 'selected' : '' }}" 
                                                 data-color="lavender" title="Lavender">
                                                <div class="color-box" style="background-color: #C9C4E5;"></div>
                                                <span class="color-name">Lavender</span>
                                            </div>
                                            <div class="color-item {{ $productDetail->color == 'dark-green' ? 'selected' : '' }}" 
                                                 data-color="dark-green" title="Xanh đậm">
                                                <div class="color-box" style="background-color: #1E754C;"></div>
                                                <span class="color-name">Dark Green</span>
                                            </div>
                                            <div class="color-item {{ $productDetail->color == 'red' ? 'selected' : '' }}" 
                                                 data-color="red" title="Đỏ">
                                                <div class="color-box" style="background-color: #D92330;"></div>
                                                <span class="color-name">Red</span>
                                            </div>
                                            <div class="color-item {{ $productDetail->color == 'taupe' ? 'selected' : '' }}" 
                                                 data-color="taupe" title="Taupe">
                                                <div class="color-box" style="background-color: #A38C61;"></div>
                                                <span class="color-name">Taupe</span>
                                            </div>
                                            <div class="color-item {{ $productDetail->color == 'cream' ? 'selected' : '' }}" 
                                                 data-color="cream" title="Kem">
                                                <div class="color-box" style="background-color: #F6E9CC;"></div>
                                                <span class="color-name">Cream</span>
                                            </div>
                                            <div class="color-item {{ $productDetail->color == 'sky-blue' ? 'selected' : '' }}" 
                                                 data-color="sky-blue" title="Xanh da trời">
                                                <div class="color-box" style="background-color: #9CC5E6;"></div>
                                                <span class="color-name">Sky Blue</span>
                                            </div>
                                            <div class="color-item {{ $productDetail->color == 'cyan' ? 'selected' : '' }}" 
                                                 data-color="cyan" title="Cyan">
                                                <div class="color-box" style="background-color: #5DE6F0;"></div>
                                                <span class="color-name">Cyan</span>
                                            </div>
                                            <div class="color-item {{ $productDetail->color == 'orange' ? 'selected' : '' }}" 
                                                 data-color="orange" title="Cam">
                                                <div class="color-box" style="background-color: #FF8C36;"></div>
                                                <span class="color-name">Orange</span>
                                            </div>
                                            <div class="color-item {{ $productDetail->color == 'silver' ? 'selected' : '' }}" 
                                                 data-color="silver" title="Bạc">
                                                <div class="color-box" style="background-color: #C0C0C0;"></div>
                                                <span class="color-name">Silver</span>
                                            </div>
                                            <div class="color-item {{ $productDetail->color == 'purple' ? 'selected' : '' }}" 
                                                 data-color="purple" title="Tím">
                                                <div class="color-box" style="background-color: #471A8E;"></div>
                                                <span class="color-name">Purple</span>
                                            </div>
                                            <div class="color-item {{ $productDetail->color == 'blue' ? 'selected' : '' }}" 
                                                 data-color="blue" title="Xanh dương">
                                                <div class="color-box" style="background-color: #1D64FF;"></div>
                                                <span class="color-name">Blue</span>
                                            </div>
                                            <div class="color-item {{ $productDetail->color == 'white' ? 'selected' : '' }}" 
                                                 data-color="white" title="Trắng">
                                                <div class="color-box" style="background-color: #FFFFFF; border: 1px solid #ccc;"></div>
                                                <span class="color-name">White</span>
                                            </div>
                                            <div class="color-item {{ $productDetail->color == 'black' ? 'selected' : '' }}" 
                                                 data-color="black" title="Đen">
                                                <div class="color-box" style="background-color: #000000;"></div>
                                                <span class="color-name">Black</span>
                                            </div>
                                        </div>
                                    </div>
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
    <style>
        .color-palette {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }

        .color-options {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .color-item {
            cursor: pointer;
            text-align: center;
            transition: all 0.3s ease;
            padding: 8px;
            border-radius: 6px;
            border: 2px solid transparent;
            background: white;
        }

        .color-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .color-item.selected {
            border-color: #007bff;
            background: #e7f3ff;
        }

        .color-box {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            margin: 0 auto 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .color-item:hover .color-box {
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .color-name {
            display: block;
            font-size: 11px;
            font-weight: 500;
            color: #495057;
            text-transform: capitalize;
        }

        .color-item.selected .color-name {
            color: #007bff;
            font-weight: 600;
        }
    </style>
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
         document.addEventListener('DOMContentLoaded', function() {
            const colorItems = document.querySelectorAll('.color-item');
            const colorInput = document.getElementById('color');

            colorItems.forEach(item => {
                item.addEventListener('click', function() {
                    
                    colorItems.forEach(i => i.classList.remove('selected'));
                    
                    
                    this.classList.add('selected');
                    
                    
                    const colorValue = this.getAttribute('data-color');
                    colorInput.value = colorValue;
                });
            });
        });
    </script>
@endsection
                