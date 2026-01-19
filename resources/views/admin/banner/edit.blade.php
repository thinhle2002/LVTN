@extends('admin.layout.master')
@section('title', 'Chỉnh sửa Banner')
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
                        Chỉnh sửa Banner
                        <div class="page-title-subheading">
                            Cập nhật thông tin và hình ảnh banner
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('banner.update', $banner->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="position-relative row form-group">
                                <label for="title" class="col-md-3 text-md-right col-form-label">
                                    Tiêu đề <span class="text-danger">*</span>
                                </label>
                                <div class="col-md-9 col-xl-8">
                                    <input required name="title" id="title" placeholder="Nhập tiêu đề" 
                                           type="text" class="form-control" value="{{ old('title', $banner->title) }}">
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="image" class="col-md-3 text-md-right col-form-label">
                                    Hình Ảnh
                                </label>
                                <div class="col-md-9 col-xl-8">
                                    @if($banner->image)
                                        <div style="margin-bottom: 10px;">
                                            <p class="mb-2">Hình ảnh hiện tại:</p>
                                            <img src="{{ asset('upload/front/img/banners/' . $banner->image) }}" 
                                                 alt="{{ $banner->name }}"
                                                 id="currentImage"
                                                 style="max-width: 300px; max-height: 200px; border-radius: 4px; border: 1px solid #ddd;">
                                        </div>
                                    @endif
                                    
                                    <input name="image" id="image" type="file" 
                                           class="form-control-file" accept="image/*" onchange="previewImage(this)">
                                    <small class="form-text text-muted">
                                        Để trống nếu không muốn thay đổi hình ảnh
                                    </small>
                                    @error('image')
                                        <span class="text-danger d-block">{{ $message }}</span>
                                    @enderror
                                    
                                    <!-- Preview new image -->
                                    <div id="imagePreview" style="margin-top: 10px; display: none;">
                                        <p class="mb-2">Hình ảnh mới:</p>
                                        <img id="preview" src="" alt="Preview" 
                                             style="max-width: 300px; max-height: 200px; border-radius: 4px; border: 1px solid #ddd;">
                                    </div>
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="active" class="col-md-3 text-md-right col-form-label">
                                    Trạng Thái
                                </label>
                                <div class="col-md-9 col-xl-8">
                                    <div class="position-relative form-check pt-2">
                                        <input name="active" id="active" type="checkbox" 
                                               class="form-check-input" value="1" 
                                               {{ old('active', $banner->active) ? 'checked' : '' }}>
                                        <label for="active" class="form-check-label">Kích hoạt</label>
                                    </div>
                                </div>
                            </div>

                            <div class="position-relative row form-group mb-1">
                                <div class="col-md-9 col-xl-8 offset-md-3">
                                    <a href="{{ route('banner.index') }}" class="btn-shadow btn btn-secondary">
                                        <span class="btn-icon-wrapper pr-2 opacity-8">
                                            <i class="fa fa-arrow-left fa-w-20"></i>
                                        </span>
                                        <span>Quay lại</span>
                                    </a>

                                    <button type="submit" class="btn-shadow btn-hover-shine btn btn-primary">
                                        <span class="btn-icon-wrapper pr-2 opacity-8">
                                            <i class="fa fa-check fa-w-20"></i>
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
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview').src = e.target.result;
                    document.getElementById('imagePreview').style.display = 'block';
                    // Ẩn ảnh cũ khi có ảnh mới
                    var currentImage = document.getElementById('currentImage');
                    if (currentImage) {
                        currentImage.style.opacity = '0.5';
                    }
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection