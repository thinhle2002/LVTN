@extends('front.layout.master')

@section('title', 'Login')

@section('body')

<!-- Breadcrumb Session Begin -->
<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <a href="/"><i class="fa fa-home"></i>Trang chủ</a>
                    <span>Đăng nhập</span>
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
                <div class="login-form">
                    <h2>Đăng nhập</h2>
                    
                    @if (session('notification'))
                        <div class="alert alert-warning" role="alert">
                            {{ session('notification') }}
                        </div>
                    @endif

                    <form action="" method="POST">
                        @csrf
                        <div class="group-input">
                            <label for="email">Email *</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="group-input">
                            <label for="password">Mật khẩu *</label>
                            <input type="password" id="password" name="password" required>
                        </div>
                        <div class="group-input gi-check">
                            <div class="gi-more">
                                <label for="remember">
                                    Ghi nhớ đăng nhập
                                    <input type="checkbox" id="remember" name="remember">
                                    <span class="checkmark"></span>
                                </label>
                                <a href="{{ route('password.request') }}" class="forget-pass">Quên mật khẩu</a>
                            </div>
                        </div>
                        <button type="submit" class="site-btn login-btn">ĐĂNG NHẬP</button>
                    </form>
                    
                    <div class="switch-login">
                        <a href="/account/register" class="or-login">Hoặc tạo tài khoản</a>
                    </div>
                    
                    <!-- Form gửi lại email xác minh -->
                    <div class="mt-4 pt-4" style="border-top: 1px solid #eee;">
                        <h5>Chưa nhận được email xác minh?</h5>
                        <form action="{{ route('verification.resend') }}" method="POST" class="mt-3">
                            @csrf
                            <div class="group-input">
                                <input type="email" name="email" placeholder="Nhập email để gửi lại" required>
                            </div>
                            <button type="submit" class="site-btn" style="background: #6c757d;">Gửi lại email xác minh</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Register Session End -->

@endsection