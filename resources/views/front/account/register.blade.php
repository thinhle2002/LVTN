@extends('front.layout.master')

@section('title', 'Register')

@section('body')

<!-- Breadcrumb Session Begin -->
<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <a href="/"><i class="fa fa-home"></i>Trang chủ</a>
                    <span>Đăng ký</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Session End -->

<!-- Register Session Begin -->
<div class="register-login-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="register-form">
                    <h2>Đăng ký</h2>
                    
                    @if (session('notification'))
                        <div class="alert alert-success" role="alert">
                            {{ session('notification') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="" method="POST">
                        @csrf
                        <div class="group-input">
                            <label for="name">Họ tên *</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                        </div>
                        <div class="group-input">
                            <label for="email">Email *</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                        </div>
                        <div class="group-input">
                            <label for="phone">Số điện thoại *</label>
                            <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required>
                        </div>
                        <div class="group-input">
                            <label for="password">Mật khẩu *</label>
                            <input type="password" id="password" name="password" required>
                        </div>
                        <div class="group-input">
                            <label for="password_confirmation">Xác nhận mật khẩu *</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required>
                        </div>
                        
                        <button type="submit" class="site-btn register-btn">ĐĂNG KÝ</button>
                    </form>
                    <div class="switch-login">
                        <a href="/account/login" class="or-login">Đăng nhập ngay</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Register Session End -->

@endsection