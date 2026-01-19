@extends('admin.layout.master')
@section('title', 'Product Create')
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
                        Product
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
                        <form method="post" action="admin/product" enctype="multipart/form-data">
                            @csrf
                            <div class="position-relative row form-group">
                                <label for="brand_id"
                                    class="col-md-3 text-md-right col-form-label">Thương hiệu</label>
                                <div class="col-md-9 col-xl-8">
                                    <select required name="brand_id" id="brand_id" class="form-control">
                                        <option value="">-- Chọn thương hiệu --</option>
                                        @foreach($brands as $brand)
                                            <option value={{ $brand->id }}>
                                                {{ $brand->name }}
                                            </option> 
                                        @endforeach                                   
                                    </select>
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="product_category_id"
                                    class="col-md-3 text-md-right col-form-label">Danh mục</label>
                                <div class="col-md-9 col-xl-8">
                                    <select required name="product_category_id" id="product_category_id" class="form-control">
                                        <option value="">-- Chọn danh mục --</option>
                                        @foreach($categories as $category)
                                            <option value= {{ $category->id }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>                           
                            <div class="position-relative row form-group">
                                <label for="tag" class="col-md-3 text-md-right col-form-label">Loại sản phẩm</label>
                                <div class="col-md-9 col-xl-8">
                                    <select name="tag" id="tag" class="form-control" required>
                                        <option value="">-- Chọn loại sản phẩm --</option>
                                        @foreach($tags as $tag)
                                            <option value="{{ $tag }}">{{ $tag }}</option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted mt-2" id="addNewTagLinkWrapper">
                                        Không tìm thấy loại sản phẩm? 
                                        <a href="javascript:void(0)" id="addNewTagLink" class="text-primary">Thêm loại mới</a>
                                    </small>
                                    <div id="newTagContainer" style="display: none;" class="mt-2">
                                        <input type="text" name="new_tag" id="new_tag" class="form-control" 
                                            placeholder="Nhập loại sản phẩm mới">
                                        <small class="form-text text-muted">
                                            <a href="javascript:void(0)" id="cancelNewTag" class="text-danger">Hủy</a>
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="position-relative row form-group">
                                <label for="name" class="col-md-3 text-md-right col-form-label">Tên sản phẩm</label>
                                <div class="col-md-9 col-xl-8">
                                    <input required name="name" id="name" placeholder="Nhập tên sản phẩm" type="text"
                                        class="form-control" value="">
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="content"
                                    class="col-md-3 text-md-right col-form-label">Nội dung</label>
                                <div class="col-md-9 col-xl-8">
                                    <input name="content" id="content"
                                        placeholder="Nội dung (trống)" type="text" class="form-control" value="">
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="price"
                                    class="col-md-3 text-md-right col-form-label">Giá</label>
                                <div class="col-md-9 col-xl-8">
                                    <input required name="price" id="price"
                                        placeholder="Nhập giá sản phẩm" type="text" class="form-control" value="">
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="discount"
                                    class="col-md-3 text-md-right col-form-label">Giá sale</label>
                                <div class="col-md-9 col-xl-8">
                                    <input required name="discount" id="discount"
                                        placeholder="Giá khi sale (trống)" type="text" class="form-control" value="">
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="weight"
                                    class="col-md-3 text-md-right col-form-label">Trọng lượng</label>
                                <div class="col-md-9 col-xl-8">
                                    <input required name="weight" id="weight"
                                        placeholder="Nhập trọng lượng sản phẩm" type="text" class="form-control" value="">
                                </div>
                            </div>
                            
                            <div class="position-relative row form-group">
                                <label for="sku"
                                    class="col-md-3 text-md-right col-form-label">SKU</label>
                                <div class="col-md-9 col-xl-8">
                                    <input required name="sku" id="sku"
                                        placeholder="SKU" type="text" class="form-control" value="">
                                </div>
                            </div>          
                            <div class="position-relative row form-group">
                                <label for="featured"
                                    class="col-md-3 text-md-right col-form-label">Nổi bật</label>
                                <div class="col-md-9 col-xl-8">
                                    <div class="position-relative form-check pt-sm-2">
                                        <input name="featured" id="featured" type="checkbox" value="1" class="form-check-input">
                                        <label for="featured" class="form-check-label">Nổi bật</label>
                                    </div>
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="description"
                                    class="col-md-3 text-md-right col-form-label">Mô tả</label>
                                <div class="col-md-9 col-xl-8">
                                    <textarea class="form-control" name="description" id="description" placeholder="Nhập mô tả sản phẩm"></textarea>
                                </div>
                            </div>

                            <div class="position-relative row form-group mb-1">
                                <div class="col-md-9 col-xl-8 offset-md-2">
                                    <a href="./admin/product" class="border-0 btn btn-outline-danger mr-1">
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
                                        <span>Thêm</span>
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

@endsection
@section('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create( document.querySelector( '#description' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>
    <script>
        console.log('Script loaded');

        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded');
            
            const tagSelect = document.getElementById('tag');
            const newTagContainer = document.getElementById('newTagContainer');
            const newTagInput = document.getElementById('new_tag');
            const addNewTagLink = document.getElementById('addNewTagLink');
            const addNewTagLinkWrapper = document.getElementById('addNewTagLinkWrapper');
            const cancelNewTag = document.getElementById('cancelNewTag');

            if (addNewTagLink) {
                addNewTagLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    console.log('Add new tag clicked');
                    
                    // Ẩn và disable dropdown
                    tagSelect.style.display = 'none';
                    tagSelect.removeAttribute('required');
                    tagSelect.disabled = true; 
                    tagSelect.value = '';
                    
                    // Hiện input mới
                    newTagContainer.style.display = 'block';
                    newTagInput.setAttribute('required', 'required');
                    newTagInput.setAttribute('name', 'tag'); 
                    newTagInput.focus();
                    
                    // Ẩn link
                    addNewTagLinkWrapper.style.display = 'none';
                });
            }

            if (cancelNewTag) {
                cancelNewTag.addEventListener('click', function(e) {
                    e.preventDefault();
                    console.log('Cancel clicked');
                    
                    // Hiện và enable dropdown
                    tagSelect.style.display = 'block';
                    tagSelect.setAttribute('required', 'required');
                    tagSelect.disabled = false; // Enable lại
                    
                    // Ẩn input
                    newTagContainer.style.display = 'none';
                    newTagInput.removeAttribute('required');
                    newTagInput.setAttribute('name', 'new_tag'); // Đổi lại name
                    newTagInput.value = '';
                    
                    // Hiện link
                    addNewTagLinkWrapper.style.display = 'block';
                });
            }
        });
    </script>
@endsection  