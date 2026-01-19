@extends('admin.layout.master')
@section('title', 'Tạo Banner Mới')
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
                        Tạo Banner Mới
                        <div class="page-title-subheading">
                            Tạo banner mới cho trang chủ
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('banner.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="position-relative row form-group">
                                <label for="title" class="col-md-3 text-md-right col-form-label">
                                    Tiêu đề <span class="text-danger">*</span>
                                </label>
                                <div class="col-md-9 col-xl-8">
                                    <input required name="title" id="title" placeholder="Nhập tiêu đề" 
                                           type="text" class="form-control" value="{{ old('title') }}">
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="image" class="col-md-3 text-md-right col-form-label">
                                    Hình Ảnh <span class="text-danger">*</span>
                                </label>
                                <div class="col-md-9 col-xl-8">
                                    <input required name="image" id="image" type="file" 
                                           class="form-control-file" accept="image/*" onchange="previewImage(this)">
                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    
                                    <!-- Preview image -->
                                    <div id="imagePreview" style="margin-top: 10px; display: none;">
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
                                               class="form-check-input" value="1" checked>
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
                                            <i class="fa fa-save fa-w-20"></i>
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
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection