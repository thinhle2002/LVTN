@extends('front.layout.master')

@section('title', 'Profile')

@section('body')

    <!-- Breadcrumb Session Begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="/"><i class="fa fa-home"></i> Trang chủ</a>
                        <span>Thông tin cá nhân</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Session End -->

    <!-- CheckOut Session Begin -->
    <div class="checkout-section spad">
        <div class="container">
            {{-- Hiển thị thông báo chung --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            
            <div class="row">                  
                {{-- Form cập nhật thông tin cá nhân --}}
                <div class="col-lg-6 mb-4">
                    <div class="profile-box">
                        <form action="/account/profile-info" method="POST" class="checkout-form">
                            @csrf
                            
                            <h4>Thông tin cá nhân</h4>
                            
                            <div class="form-group">                             
                                <input type="text" name="name" placeholder="Họ và tên*" 
                                    class="form-control" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input type="email" name="email" placeholder="Email *" 
                                            class="form-control" value="{{ old('email', $user->email) }}" required>
                                        @error('email')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input type="text" name="phone" placeholder="Số điện thoại *" 
                                            class="form-control" value="{{ old('phone', $user->phone) }}" required>
                                        @error('phone')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">                                 
                                <input type="text" name="street_address" placeholder="Địa chỉ *" 
                                    class="form-control" value="{{ old('street_address', $user->street_address) }}" required>
                                @error('street_address')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <select id="town" name="town_city" class="form-control" required>
                                            <option value="">Tỉnh / Thành phố *</option>
                                        </select>
                                        @error('town_city')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <select id="district" name="district" class="form-control" required>
                                            <option value="">Quận / Huyện *</option>
                                        </select>
                                        @error('district')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <button type="submit" class="site-btn place-btn">Cập nhật</button>
                        </form>
                    </div>
                </div>

                {{-- Form đổi mật khẩu --}}
                <div class="col-lg-6 mb-4">
                    <div class="profile-box password-box">
                        <form action="{{ route('account.change-password') }}" method="POST" class="password-form">
                            @csrf
                            
                            <h4>Đổi mật khẩu</h4>
                            
                            <div class="form-group">
                                <label for="current_password">Mật khẩu hiện tại *</label>
                                <input type="password" id="current_password" name="current_password" 
                                    class="form-control" placeholder="Nhập mật khẩu hiện tại" required>
                                @error('current_password')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="new_password">Mật khẩu mới *</label>
                                <input type="password" id="new_password" name="new_password" 
                                    class="form-control" placeholder="Nhập mật khẩu mới" required>
                                @error('new_password')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="new_password_confirmation">Xác nhận mật khẩu mới *</label>
                                <input type="password" id="new_password_confirmation" name="new_password_confirmation" 
                                    class="form-control" placeholder="Nhập lại mật khẩu mới" required>
                            </div>
                            
                            <button type="submit" class="site-btn place-btn">Đổi mật khẩu</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- CheckOut Session End -->
@endsection

@section('scripts')
<style>
    #town, #district {
        width: 100%; 
        padding: 10px 10px; 
        height: 50px;
        border: 1px solid #ced4da; 
        border-radius: 4px; 
        appearance: none; 
        -webkit-appearance: none; 
        font-size: 16px;
        line-height: 1.5;
        background-color: #fff;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 10px center;
        background-size: 16px 16px;
        padding-right: 30px;
    }
    
    .password-form label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
        color: #333;
    }
    
    .password-form input[type="password"] {
        width: 100%;
        padding: 10px;
        height: 50px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        font-size: 16px;
    }
    .profile-box {
        background: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        height: 100%;
    }
    
    .password-box {
        background: #f8f9fa;
    }
    
    .profile-box h4 {
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 2px solid #e7ab3c;
        font-size: 20px;
        font-weight: 600;
        color: #333;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #333;
        font-size: 14px;
    }
    
    .form-control {
        width: 100%;
        padding: 12px 15px;
        height: 50px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        font-size: 15px;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        outline: none;
        border-color: #e7ab3c;
        box-shadow: 0 0 0 0.2rem rgba(231, 171, 60, 0.25);
    }
    
    select.form-control {
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 15px center;
        background-size: 16px 16px;
        padding-right: 40px;
    }
    
    .site-btn.place-btn {
        width: 100%;
        max-width: 200px;
        padding: 12px 30px;
        margin-top: 10px;
    }
    
    .text-danger.small {
        font-size: 13px;
        margin-top: 5px;
        display: block;
    }
    
    @media (max-width: 991px) {
        .profile-box {
            margin-bottom: 30px;
        }
    }
</style>

<script>
    $(document).ready(function() {
        // Kiểm tra xem districts.min.js đã load chưa
        if (typeof c === 'undefined' || typeof arr === 'undefined') {
            console.error('File districts.min.js chưa được load!');
            return;
        }
        
        // Chuyển đổi dữ liệu sang định dạng dễ dùng
        var vietnamProvinces = [];
        for (var i = 0; i < c.length; i++) {
            var districts = [];
            if (arr[i]) {
                for (var j = 0; j < arr[i].length; j++) {
                    districts.push({
                        id: j + 1,
                        name: arr[i][j]
                    });
                }
            }
            vietnamProvinces.push({
                id: i + 1,
                name: c[i],
                districts: districts
            });
        }
        
        console.log('✓ Đã load ' + vietnamProvinces.length + ' tỉnh/thành phố');
        
        // Lấy giá trị từ DB (nếu có)
        var userTownCity = "{{ old('town_city', $user->town_city ?? '') }}";
        var userDistrict = "{{ old('district', $user->district ?? '') }}";
        
        // Load danh sách tỉnh/thành phố
        function loadProvinces() {
            var townSelect = $('#town');
            townSelect.empty();
            townSelect.append('<option value="">Tỉnh / Thành phố *</option>');
            
            $.each(vietnamProvinces, function(index, city) {
                var selected = (city.name === userTownCity) ? 'selected' : '';
                townSelect.append('<option value="' + city.name + '" data-id="' + city.id + '" ' + selected + '>' + city.name + '</option>');
            });
        }
        
        // Load danh sách quận/huyện theo tỉnh/thành phố
        function loadDistricts(cityName, selectDistrict) {
            var districtSelect = $('#district');
            districtSelect.empty();
            districtSelect.append('<option value="">Quận / Huyện *</option>');
            
            if (cityName) {
                var selectedCity = vietnamProvinces.find(function(c) {
                    return c.name === cityName;
                });
                
                if (selectedCity && selectedCity.districts) {
                    $.each(selectedCity.districts, function(index, district) {
                        var selected = (district.name === selectDistrict) ? 'selected' : '';
                        districtSelect.append('<option value="' + district.name + '" ' + selected + '>' + district.name + '</option>');
                    });
                    console.log('✓ Đã load ' + selectedCity.districts.length + ' quận/huyện cho ' + selectedCity.name);
                }
            }
        }
        
        // Gọi hàm load tỉnh/thành
        loadProvinces();
        
        // Nếu có dữ liệu từ DB, load luôn danh sách quận/huyện
        if (userTownCity) {
            loadDistricts(userTownCity, userDistrict);
        }
        
        // Xử lý khi chọn tỉnh/thành
        $('#town').on('change', function() {
            var selectedCityName = $(this).val();
            loadDistricts(selectedCityName, '');
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Validate form cập nhật thông tin
        const requiredFields = [
            'input[name="name"]',            
            'input[name="email"]',
            'input[name="phone"]',
            'input[name="street_address"]',
            'select[name="town_city"]',
            'select[name="district"]'
        ];

        $('.checkout-form').on('submit', function(e) {
            let isValid = true;
            let missingFields = [];

            requiredFields.forEach(selector => {
                const field = $(selector);
                let value = field.val();

                if (typeof value === 'string') {
                    value = value.trim();
                }

                if (!value) {
                    isValid = false;
                    field.addClass('input-error');
                    missingFields.push(selector);
                } else {
                    field.removeClass('input-error');
                }
            });

            if (!isValid) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Thiếu thông tin!',
                    text: 'Vui lòng nhập đầy đủ thông tin.',
                    confirmButtonText: 'Đã hiểu'
                });
            }
        });

        // Validate form đổi mật khẩu
        $('.password-form').on('submit', function(e) {
            const currentPassword = $('input[name="current_password"]').val().trim();
            const newPassword = $('input[name="new_password"]').val().trim();
            const confirmPassword = $('input[name="new_password_confirmation"]').val().trim();

            if (!currentPassword || !newPassword || !confirmPassword) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Thiếu thông tin!',
                    text: 'Vui lòng nhập đầy đủ thông tin mật khẩu.',
                    confirmButtonText: 'Đã hiểu'
                });
                return;
            }

            if (newPassword.length < 6) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Mật khẩu quá ngắn!',
                    text: 'Mật khẩu mới phải có ít nhất 6 ký tự.',
                    confirmButtonText: 'Đã hiểu'
                });
                return;
            }

            if (newPassword !== confirmPassword) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Mật khẩu không khớp!',
                    text: 'Mật khẩu xác nhận không trùng với mật khẩu mới.',
                    confirmButtonText: 'Đã hiểu'
                });
                return;
            }
        });
    });
</script>
@endsection