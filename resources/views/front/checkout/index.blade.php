@extends('front.layout.master')

@section('title', 'Check Out')

@section('body')

    <!-- Breadcrumb Session Begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="/"><i class="fa fa-home"></i> Trang chủ</a>
                        <span>Thanh toán</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Session End -->

    <!-- CheckOut Session Begin -->
    <div class="checkout-section spad">
        <div class="container">
            <form action="{{ route('checkout.addOrder') }}" method="POST" class="checkout-form">
                @csrf
                <div class="row">
                    @if(Cart::count() > 0)
                        <div class="col-lg-6">
                            {{-- <div class="checkout-content">
                                <a href="login.html" class="content-btn">Đăng nhập</a>
                            </div> --}}
                            <h4>Thông tin nhận hàng</h4>
                            <div class="row">
                                <div class="col-lg-12">                               
                                    <input type="text" id="fir" name="name" placeholder="Họ và tên*" value="{{ Auth::user()->name ?? '' }}">
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" id="email" name="email" placeholder="Email *" value="{{ Auth::user()->email ?? '' }}">
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" id="phone" name="phone" placeholder="Số điện thoại *" value="{{ Auth::user()->phone ?? '' }}">
                                </div>
                                <div class="col-lg-12">                                 
                                    <input type="text" id="street" name="street_address" placeholder="Địa chỉ *" class="street-first" value="{{ Auth::user()->street_address ?? '' }}">                         
                                </div>
                                <div class="col-lg-6">
                                    <select  id="town" name="town_city" required="" >
                                        <option value="">Tỉnh / Thành phố <span>*</span></option>
                                    </select>                                             
                                </div>          
                                <div class="col-lg-6">
                                    <select  id="district" name="district" required="">
                                        <option value="">Quận / Huyện <span>*</span></option>
                                    </select>                                          
                                </div>
                                <input type="hidden" name="shipping_fee" id="shipping_fee" value="0">                               
                            </div>
                        </div>
                        {{-- <div class="checkout-content">
                                <a href="login.html" class="content-btn">Đăng nhập</a>
                            </div> --}}
                        <div class="col-lg-6">                           
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
                                        <li class="fw-normal">Phí vận chuyển <span id="shipping-fee-display">0đ</span></li>                                  
                                        <li class="total-price">Tổng tiền  <span id="final-total">{{ number_format($total * 1000, 0, ',', '.') }}đ</span></li>
                                        <li class="fw-normal">
                                            <div style="margin-top:15px">
                                                <input 
                                                    type="text" 
                                                    id="voucher_code" 
                                                    placeholder="Nhập mã giảm giá"
                                                    style="width:70%;padding:8px"
                                                >
                                                <button type="button" id="apply-voucher" class="site-btn" style="padding:8px 15px">
                                                    Áp dụng
                                                </button>
                                            </div>

                                            <small id="voucher-message" style="display:block;margin-top:5px"></small>
                                        </li>

                                        <li class="fw-normal" id="discount-row" style="display:none">
                                            Giảm giá <span id="discount-amount">0đ</span>
                                        </li>
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
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 10px center;
        background-size: 16px 16px;
        padding-right: 30px;
    }
    
    #voucher-message.success {
        color: #28a745;
        font-weight: 600;
    }
    
    #voucher-message.error {
        color: #dc3545;
        font-weight: 600;
    }
    
    #voucher_code {
        border: 1px solid #ced4da;
        border-radius: 4px;
    }
    
    #voucher_code:focus {
        outline: none;
        border-color: #ca1515;
    }
    
    .voucher-applied {
        background-color: #d4edda;
        border: 1px solid #c3e6cb;
        padding: 10px;
        border-radius: 5px;
        margin-top: 10px;
    }
</style>

<script>
    $(document).ready(function() {
        // Khởi tạo biến
        let appliedVoucherData = null;
        const subtotalBase = {{ $subtotal * 1000 }};
        
        // ========== VOUCHER LOGIC ==========
        $('#apply-voucher').on('click', function() {
            const voucherCode = $('#voucher_code').val().trim().toUpperCase();
            const shippingFee = parseInt($('#shipping_fee').val()) || 0;
            
            if (!voucherCode) {
                showVoucherMessage('Vui lòng nhập mã giảm giá!', 'error');
                return;
            }
            
            // Disable button khi đang xử lý
            $(this).prop('disabled', true).text('Đang xử lý...');
            
            $.ajax({
                url: '{{ route("checkout.applyVoucher") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    code: voucherCode,
                    subtotal: subtotalBase, // Đã x1000 rồi
                    shipping_fee: shippingFee
                },
                success: function(response) {
                    if (response.success) {
                        appliedVoucherData = response.data;
                        
                        
                        $('#discount-row').show();
                        $('#discount-amount').text(
                            formatCurrency(response.data.discount_amount) + 'đ'
                        );
                        
                        // Cập nhật tổng tiền
                        updateFinalTotal();
                        
                        // Hiển thị thông báo thành công
                        let message = 'Áp dụng mã "' + response.data.code + '" thành công!';
                        if (response.data.type == 1) {
                            message += ' (Giảm ' + response.data.reduce_value + '%)';
                        } else {
                            message += ' (Giảm ' + formatCurrency(response.data.reduce_value) + 'đ)';
                        }
                        showVoucherMessage(message, 'success');
                        
                        // Disable input và button
                        $('#voucher_code').prop('disabled', true);
                        $('#apply-voucher').text('Đã áp dụng').removeClass('site-btn').addClass('btn-success');
                        
                    } else {
                        showVoucherMessage(response.message, 'error');
                    }
                },
                error: function(xhr) {
                    let errorMsg = 'Có lỗi xảy ra khi áp dụng mã!';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    showVoucherMessage(errorMsg, 'error');
                },
                complete: function() {
                    $('#apply-voucher').prop('disabled', false);
                    if (!appliedVoucherData) {
                        $('#apply-voucher').text('Áp dụng');
                    }
                }
            });
        });
        
        // Hàm hiển thị thông báo voucher
        function showVoucherMessage(message, type) {
            const $msg = $('#voucher-message');
            $msg.text(message)
                .removeClass('success error')
                .addClass(type)
                .fadeIn();
            
            if (type === 'error') {
                setTimeout(function() {
                    $msg.fadeOut();
                }, 5000);
            }
        }
        
        // Hàm cập nhật tổng tiền
        function updateFinalTotal() {
            const shippingFee = parseInt($('#shipping_fee').val()) || 0;
            
            // Backend trả về discount_amount ĐÃ LÀ GIÁ TRỊ ĐÚNG (VD: 255200)
            // KHÔNG NHÂN 1000 NỮA!
            const discountAmount = appliedVoucherData ? appliedVoucherData.discount_amount : 0;
            
            const finalTotal = subtotalBase - discountAmount + shippingFee;
            
            console.log('=== DEBUG TOTAL ===');
            console.log('Subtotal:', subtotalBase);
            console.log('Discount:', discountAmount);
            console.log('Shipping:', shippingFee);
            console.log('Final:', finalTotal);
            
            $('#shipping-fee-display').text(formatCurrency(shippingFee) + 'đ');
            $('#discount-amount').text(formatCurrency(discountAmount) + 'đ');
            $('#final-total').text(formatCurrency(finalTotal) + 'đ');
        }
        
        // Hàm format tiền
        function formatCurrency(amount) {
            return Math.round(amount).toLocaleString('vi-VN');
        }
        
        // ========== DISTRICT LOGIC (GIỮ NGUYÊN) ==========
        if (typeof c === 'undefined' || typeof arr === 'undefined') {
            console.error('File districts.min.js chưa được load!');
            return;
        }
        
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
        
        var userTownCity = "{{ Auth::check() ? Auth::user()->town_city : '' }}";
        var userDistrict = "{{ Auth::check() ? Auth::user()->district : '' }}";
        
        function loadProvinces() {
            var townSelect = $('#town');
            townSelect.empty();
            townSelect.append('<option value="">Tỉnh / Thành phố *</option>');
            
            $.each(vietnamProvinces, function(index, city) {
                var selected = (city.name === userTownCity) ? 'selected' : '';
                townSelect.append('<option value="' + city.name + '" data-id="' + city.id + '" ' + selected + '>' + city.name + '</option>');
            });
        }
        
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
                }
            }
        }
        
        function calculateShippingFee(cityName) {
            let shippingFee = 0;
            
            if (cityName === 'Thành phố Hồ Chí Minh' || cityName === 'Hồ Chí Minh') {
                shippingFee = 20000;
            } else if (cityName && cityName !== '') {
                shippingFee = 35000;
            }
            
            return shippingFee;
        }
        
        loadProvinces();
        
        if (userTownCity) {
            loadDistricts(userTownCity, userDistrict);
            const shippingFee = calculateShippingFee(userTownCity);
            $('#shipping_fee').val(shippingFee);
            updateFinalTotal();
        }
        
        $('#town').on('change', function() {
            var selectedCityName = $(this).val();
            loadDistricts(selectedCityName, '');
            const shippingFee = calculateShippingFee(selectedCityName);
            $('#shipping_fee').val(shippingFee);
            updateFinalTotal();
        });
        
        // ========== FORM VALIDATION (GIỮ NGUYÊN) ==========
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
            let paymentSelected = $('input[name="payment_type"]:checked').length > 0;

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

            if (!paymentSelected) {
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();

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
            }
        });
    });
</script>
@endsection