@extends('front.layout.master')

@section('title', 'Check Out')

@section('body')


    <!-- CheckOut Session Begin -->
    <div class="checkout-section spad">
        <div class="container">
            <form action="" method="POST" class="checkout-form">
                @csrf
                <div class="row">
                    @if(Cart::count() > 0)
                        <div class="col-lg-6">
                            <div class="checkout-content">
                                <a href="login.html" class="content-btn">Đăng nhập</a>
                            </div>
                            <h4>Thông tin nhận hàng</h4>
                            <div class="row">
                                <div class="col-lg-6">                               
                                    <input type="text" id="fir" name="first_name" placeholder="Họ *">
                                </div>
                                <div class="col-lg-6">                                 
                                    <input type="text" id="last"name="last_name" placeholder="Tên *">
                                </div>                                                                                                                                                                                          
                                <div class="col-lg-6">
                                    <input type="text" id="email" name="email" placeholder="Email *">
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" id="phone" name="phone" placeholder="Số điện thoại *">
                                </div>
                                <div class="col-lg-12">                                 
                                    <input type="text" id="street" name="street_address" placeholder="Địa chỉ *" class="street-first">                         
                                </div>
                                <div class="col-lg-6">
                                    <select  id="town" name="town_city" required="">
                                        <option value="">Tỉnh / Thành phố <span>*</span></option>
                                    </select>                                             
                                </div>          
                                <div class="col-lg-6">
                                    <select  id="district" name="district" required="">
                                        <option value="">Quận / Huyện <span>*</span></option>
                                    </select>                                          
                                </div>
                                {{-- <div class="col-lg-12">
                                    <div class="create-item">
                                        <label for="acc-create">
                                            Tạo tài khoản?
                                            <input type="checkbox" id="acc-create">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="checkout-content">
                                <a href="register.html" class="content-btn">Đăng ký</a>
                            </div>
                            <div class="place-order">
                                <h4>Đơn hàng</h4>
                                <div class="order-total">
                                    <ul class="order-table">
                                        <li>Sản phẩm                         
                                            <span>Tổng tiền</span>
                                        </li>
                                        @php  
                                            $colorMap = config('convertColor.colors');
                                        @endphp
                                        @foreach ($carts as $cart)
                                            <li class="fw-normal">
                                                {{ $cart->name }} <strong>x{{ $cart->qty }}</strong>
                                                @php
                                                $rawColor = $cart->options->color ?? null;
                                                $productSize = $cart->options->size ?? null;
                                          
                                                $displayColor = $colorMap[$rawColor] ?? $rawColor;
                                                
                                                $attributes = [];
                                                if ($rawColor) {
                                                    $attributes[] = 'Màu: ' . $displayColor;
                                                }
                                                if ($productSize) {
                                                    $attributes[] = 'Size: ' . $productSize;
                                                }
                                                $attributeDisplay = implode(' | ', $attributes);
                                            @endphp
                                            <span>{{ number_format($cart->price * $cart->qty * 1000, 0, ',', '.') }}đ</span>
                                            @if (!empty($attributeDisplay))
                                                <small class="d-block" style="color: #6c757d;">({{ $attributeDisplay }})</small>
                                            @endif
                                                
                                            </li>
                                        @endforeach      

                                        <li class="fw-normal">Tạm tính <span>{{ number_format($subtotal * 1000, 0, ',', '.') }}đ</span></li>
                                        <li class="fw-normal">Phí vận chuyển <span></span></li>
                                        <li class="total-price">Tổng tiền  <span>{{ number_format($total * 1000, 0, ',', '.') }}đ</span></li>
                                    </ul>
                                    <div class="payment-check">
                                        <div class="pc-item">
                                            <label for="pc-check">
                                                Thanh toán khi nhận hàng (COD)
                                                <input type="radio" name="payment_type" value="COD" id="pc-check">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="pc-item">
                                            <label for="pc-paypal">
                                                Thanh toán online (Banking)
                                                <input type="radio" name="payment_type" value="ONLINE" id="pc-paypal">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="order-btn">
                                        <button type="submit" class="site-btn place-btn">Đặt hàng</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-lg-12">
                            <h4>Giỏ hàng của bạn đang trống!</h4>
                        </div>
                    @endif
                </div>
            </form>
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
        appearance: none; 
        -webkit-appearance: none; 
        
        
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 10px center;
        background-size: 16px 16px;
        
        padding-right: 30px;
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
        
        // Load danh sách tỉnh/thành phố
        function loadProvinces() {
            var townSelect = $('#town');
            townSelect.empty();
            townSelect.append('<option value="">Tỉnh / Thành phố *</option>');
            
            $.each(vietnamProvinces, function(index, city) {
                townSelect.append('<option value="' + city.name + '" data-id="' + city.id + '">' + city.name + '</option>');
            });
        }
        
        // Gọi hàm load tỉnh/thành
        loadProvinces();
        
        // Xử lý khi chọn tỉnh/thành
        $('#town').on('change', function() {
            var cityDataId = parseInt($(this).find('option:selected').data('id'));
            var districtSelect = $('#district');
            
            districtSelect.empty();
            districtSelect.append('<option value="">Quận / Huyện *</option>');
            
            if (cityDataId) {
                // Tìm tỉnh/thành phố được chọn (id bắt đầu từ 1, nên index = id - 1)
                var selectedCity = vietnamProvinces.find(function(c) {
                    return c.id === cityDataId;
                });
                
                if (selectedCity && selectedCity.districts) {
                    $.each(selectedCity.districts, function(index, district) {
                        districtSelect.append('<option value="' + district.name + '">' + district.name + '</option>');
                    });
                    console.log('✓ Đã load ' + selectedCity.districts.length + ' quận/huyện cho ' + selectedCity.name);
                }
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        const requiredFields = [
            'input[name="first_name"]',
            'input[name="last_name"]',
            'input[name="email"]',
            'input[name="phone"]',
            'input[name="street_address"]',
            'select[name="town_city"]',
            'select[name="district"]'
        ];

        $('.checkout-form').on('submit', function(e) {
            let isValid = true;
            let missingFields = [];
            let paymentSelected = $('input[name="payment_type"]:checked').length > 0;

            // 1. Kiểm tra các trường dữ liệu bắt buộc
            requiredFields.forEach(selector => {
                const field = $(selector);
                let value = field.val();

                // Loại bỏ khoảng trắng ở đầu/cuối
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

            // 2. Kiểm tra phương thức thanh toán
            if (!paymentSelected) {
                isValid = false;
            }

            // 3. Xử lý kết quả kiểm tra
            if (!isValid) {
                e.preventDefault(); // Chặn gửi form

                // Hiển thị thông báo
                if (missingFields.length > 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Thiếu thông tin!',
                        text: 'Vui lòng nhập đầy đủ thông tin nhận hàng.',
                        confirmButtonText: 'Đã hiểu'
                    });
                } else if (!paymentSelected) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Chưa chọn thanh toán!',
                        text: 'Vui lòng chọn phương thức thanh toán.',
                        confirmButtonText: 'Đã hiểu'
                    });
                }
            } else {
                // Nếu mọi thứ hợp lệ, form sẽ được gửi đi
                $('.payment-check').css('border', 'none');
            }
        });
    });
</script>
@endsection