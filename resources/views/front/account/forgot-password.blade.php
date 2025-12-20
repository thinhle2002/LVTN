@extends('front.layout.master')

@section('title', 'Quên mật khẩu')

@section('body')

<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <a href="/"><i class="fa fa-home"></i>Trang chủ</a>
                    <span>Quên mật khẩu</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="register-login-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="login-form">
                    <h2>Quên mật khẩu</h2>
                    <p>Nhập email của bạn để nhận link đặt lại mật khẩu</p>
                    
                    @if (session('notification'))
                        <div class="alert alert-info" role="alert">
                            {{ session('notification') }}
                        </div>
                    @endif

                    <form action="{{ route('password.email') }}" method="POST">
                        @csrf
                        <div class="group-input">
                            <label for="email">Email *</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="site-btn login-btn">GỬI LINK ĐẶT LẠI MẬT KHẨU</button>
                    </form>
                    
                    <div class="switch-login">
                        <a href="/account/login" class="or-login">Quay lại đăng nhập</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection