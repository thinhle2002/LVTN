@extends('front.layout.master')

@section('title', 'Đặt lại mật khẩu')

@section('body')

<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <a href="/"><i class="fa fa-home"></i>Trang chủ</a>
                    <span>Đặt lại mật khẩu</span>
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
                    <h2>Đặt lại mật khẩu</h2>
                    
                    @if (session('notification'))
                        <div class="alert alert-warning" role="alert">
                            {{ session('notification') }}
                        </div>
                    @endif

                    <form action="{{ route('password.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        
                        <div class="group-input">
                            <label for="email">Email *</label>
                            <input type="email" id="email" name="email" value="{{ old('email', request()->email) }}" required>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="group-input">
                            <label for="password">Mật khẩu mới *</label>
                            <input type="password" id="password" name="password" required>
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="group-input">
                            <label for="password_confirmation">Xác nhận mật khẩu *</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required>
                        </div>
                        
                        <button type="submit" class="site-btn login-btn">ĐẶT LẠI MẬT KHẨU</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection