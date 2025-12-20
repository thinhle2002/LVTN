<!DOCTYPE html>
<html lang="zxx">

<head>
    <base href="{{asset('/')}}">
    <meta charset="UTF-8">
    <meta name="description" content="codelean Template">
    <meta name="keywords" content="codelean, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') | FashionShop</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="front/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="front/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="front/css/themify-icons.css" type="text/css">
    <link rel="stylesheet" href="front/css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="front/css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="front/css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="front/css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="front/css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="{{ asset('front/css/style.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('front/css/category-dropdown.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('front/css/rating.css') }}">

</head>

<body>

    <!-- Page Preloader -->
    <div id="preloader">
        <div class="loader"></div>
    </div>

    <!-- Header Session Begin -->
    <header class="header-section">
        <div class="header-top" id="header-top">
            <div class="container">
                <div class="ht-left">
                    <div class="mail-service">
                        <i class="fa fa-envelope"></i>
                        thinhle15112002@gmail.com
                    </div>
                    <div class="phone-service">
                        <i class="fa fa-phone"></i>
                        (+84) 0765 232 360
                    </div>
                </div>

                <div class="ht-right">

                    @if (Auth::check())
                        <div class="dropdown-login">
                            <a href="#" class="login-panel dropdown-toggle">
                                <i class="fa fa-user"></i>{{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu-custom">
                                <a href="./account/profile-info" class="dropdown-item">
                                    <i class="fa fa-pencil"></i> Thông tin cá nhân
                                </a>
                                <a href="./account/logout" class="dropdown-item">
                                    <i class="fa fa-sign-out"></i> Đăng xuất
                                </a>                    
                            </div>
                        </div>
                    @else
                        <a href="./account/login" class="login-panel"><i class="fa fa-user"></i>Đăng nhập / Đăng ký</a>
                    @endif

                    {{-- <div class="top-social">
                        <a href="https://www.facebook.com/thinhh.02"><i class="ti-facebook"></i></a>
                        <a href="https://www.instagram.com/_dinoshelby_/"><i class="ti-instagram"></i></a>                    
                    </div> --}}
                </div>
            </div>
        </div>

        <div class="container">
            <div class="inner-header">
                <div class="row">
                    {{-- <div class="col-lg-2 col-md-2">
                        <div class="logo">
                            <a href="index.html">
                                <img src="front/img/logotfashion.png" height="25" alt="">
                            </a>
                        </div>
                    </div> --}}

                    <div class="col-lg-9 col-md-9">
                        <form action="shop">
                            <div class="advanced-search">
                                {{-- <button type="button" class="category-btn">All Categories</button> --}}
                                <div class="input-group">
                                    <input name="search" value="{{ request('search') }}" type="text" placeholder="Bạn muốn tìm gì?">
                                    {{-- <button type="submit"><i class="ti-search"></i></button> --}}
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-3 col-md-3 text-right">
                        <ul class="nav-right">
                            <li class="heart-icon">
                                <a href="./account/user-orders">
                                    <i class="icon_document" title="Đơn hàng của bạn"></i>
                                    {{-- <span>0</span> --}}
                                </a>
                            </li>
                            <li class="cart-icon">
                                <a href="./cart">
                                    <i class="icon_bag_alt"></i>
                                    <span class="cart-count">{{ Cart::count() }}</span>
                                </a>
                                <div class="cart-hover">
                                    <div class="select-items">
                                        <table>
                                            <tbody>
                                            @foreach(Cart::content() as $cart)
                                                <tr data-rowId="{{ $cart->rowId }}">
                                                    <td class="si-pic"><img style="height: 70px;" src="upload/front/img/products/{{ $cart->options->images['path'] }}"></td>
                                                    <td class="si-text">
                                                        <div class="product-selected">
                                                            @php                                                      
                                                                $colorMap = config('convertColor.colors');
                                                                $rawColor = $cart->options->color;
                                                                $displayColor = $colorMap[$rawColor] ?? $rawColor;
                                                            @endphp
                                                            {{-- <p>{{ number_format($cart->price * 1000, 0, ',', '.') }}đ </p> --}}
                                                            <h6>{{$cart->name}} | x{{$cart->qty}}</h6>
                                                            <p>{{ $displayColor }} / {{ $cart->options->size }}</p>
                                                        </div>
                                                    </td>
                                                    <td class="si-close">
                                                        <i onclick="removeCart('{{ $cart->rowId }}')" class="ti-trash remove-icon-red"></i>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="select-total">
                                        <span>Total : </span>
                                        <h5>{{ number_format(Cart::priceTotal(0, '', '') * 1000, 0, ',', '.') }}đ</h5>
                                    </div>
                                    <div class="select-button">
                                        <a href="./cart" class="primary-btn view-card">View card</a>
                                        <a href="./checkout" class="primary-btn checkout-btn">Check out</a>
                                    </div>
                                </div>
                            </li>
                            <li class="cart-price">{{ number_format(Cart::priceTotal(0, '', '') * 1000, 0, ',', '.') }}đ</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Phần Nav Item với Dropdown Danh mục 2 cột -->
        <div class="nav-item">
            <div class="container">
                <div class="nav-depart">
                    <div class="depart-btn">
                        <i class="ti-menu"></i>
                        <span>Danh mục sản phẩm</span>
                        <div class="depart-hover">
                            @php
                                $tagLabels = config('tags.labels');
                            @endphp          
                            @foreach($categoriesWithTags as $category)
                                <div class="category-column">
                                    <h5>{{ $category['display_name'] }}</h5>
                                    <ul>
                                        @foreach($category['tags'] as $tag)
                                            <li>
                                                <a href="./shop?tag={{ $tag }}">
                                                    {{ $tagLabels[$tag] ?? $tag }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>                    
                <nav class="nav-menu mobile-menu">
                    <ul>
                        <li class="{{ (request()->segment(1) == '') ? 'active' : ''}} ">
                            <a href="./">Trang chủ</a>
                        </li>
                        <li class="{{ (request()->segment(1) == 'shop') ? 'active' : ''}} ">
                            <a href="./shop">Sản phẩm</a>
                        </li>
                        <li class="{{ (request()->segment(1) == 'vouchers') ? 'active' : ''}}">
                            <a href="./vouchers">Mã khuyến mãi</a>
                        </li>
                    </ul>
                </nav>
                <div id="mobile-menu-wrap"></div>
            </div>
        </div>
    </header>
    <div id="header-toggle" class="header-toggle" title="Toggle header info">
        <i class="fa fa-chevron-down"></i>
    </div>

    <!-- Header End -->

    <!-- Body Here -->
    @yield('body')

    <!-- Footer Section Begin -->
        <footer class="footer-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="footer-left">
                            {{-- <div class="footer-logo">
                                <a href="index.html">
                                    <img src="front/img/" height="25" alt="">
                                </a>
                            </div> --}}
                            <ul>
                                <div class="footer-widget">
                                    <h5>Chăm sóc khách hàng</h5>
                                    <li>Điện thoại : (+84) 765232360</li>
                                    <li>Email: txfashion@mail.com</li>
                                </div>                       
                            </ul>
                            <div class="footer-social">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-pinterest"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 offset-lg-1">
                        <div class="footer-widget">
                            <h5>
                                Thông tin
                            </h5>
                            <ul>
                                <li><a href="">Về chúng tôi</a></li>                      
                                <li><a href="">Liên hệ</a></li>
                                <li><a href="">Dịch vụ</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="footer-widget">
                            <h5>
                                Tài khoản của tôi
                            </h5>
                            <ul>
                                <li><a href="">Tài khoản của tôi</a></li>                      
                                <li><a href="">Giỏ hàng</a></li>
                                <li><a href="">Cửa hàng</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="footer-widget">
                            <div class="google-map-footer">
                                <h5>Vị trí cửa hàng</h5>
                                <p>164 Trần Thị Nơi, Phường 4, Quận 8, TP.HCM</p>

                                <div class="map-container" style="width: 100%; height: 200px; border-radius: 8px; overflow: hidden;">
                                    <iframe
                                        width="100%"
                                        height="100%"
                                        frameborder="0"
                                        style="border:0;"
                                        allowfullscreen
                                        loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade"
                                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.8930092704156!2d106.62957537488054!3d10.744040789395047!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752ff9fd26219d%3A0xd8d50a3f217b2d0!2zMTY0IFRy4bqnbiBUaOG7iyBO4buZaSwgUC4gNCwgUXXhuq1uIDgsIFRow6BuaCBwaOG7kSBIb8OgIFRo4buNIE1pbmgsIFZp4buHdCBOYW0!5e0!3m2!1svi!2svi!4v1733145470000">
                                    </iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="copyright-reserved">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="copyright-text">
                                Bản quyền © <script>document.write(new Date().getFullYear()); </script> Mọi quyền được bảo lưu 
                                <i class="fa fa-heart-o" aria-hidden="true"></i>
                            </div>
                            {{-- <div class="payment-pic">
                                <img src="front/img/payment-method.png" alt="">
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    <!-- Footer Section End -->




    <!-- Js Plugins -->
    <script src="front/js/jquery-3.3.1.min.js"></script>
    <script src="{{ asset('front/js/districts.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="front/js/bootstrap.min.js"></script>
    <script src="front/js/jquery-ui.min.js"></script>
    <script src="front/js/jquery.countdown.min.js"></script>
    <script src="front/js/jquery.nice-select.min.js"></script>
    <script src="front/js/jquery.zoom.min.js"></script>
    <script src="front/js/jquery.dd.min.js"></script>
    <script src="front/js/jquery.slicknav.js"></script>
    <script src="front/js/owl.carousel.min.js"></script>
    <script src="front/js/owlcarousel2-filter.min.js"></script>
    <script src="front/js/main.js"></script>
    <script>
        $(document).ready(function() {
            var $toggle = $('#header-toggle');
            var $headerTop = $('#header-top');
            var $innerHeader = $('.inner-header');
            var $headerContainer = $('.inner-header').parent('.container'); // Lấy container chứa inner-header
            
            if (!$toggle.length || !$headerTop.length || !$innerHeader.length) {
                console.error('Some elements not found!');
                return;
            }
            
            // Ẩn cả header-top và inner-header khi load
            $headerTop.hide();
            $innerHeader.hide();
            
            $toggle.on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                // Kiểm tra trạng thái hiện tại
                var isVisible = $headerTop.is(':visible');
                
                if (isVisible) {
                    // Đang hiển thị -> Ẩn đi
                    $headerTop.slideUp(300);
                    $innerHeader.slideUp(300);
                    $toggle.removeClass('active');
                    $toggle.find('i')
                        .removeClass('fa-chevron-up')
                        .addClass('fa-chevron-down');
                } else {
                    // Đang ẩn -> Hiển thị
                    $headerTop.slideDown(300);
                    $innerHeader.slideDown(300);
                    $toggle.addClass('active');
                    $toggle.find('i')
                        .removeClass('fa-chevron-down')
                        .addClass('fa-chevron-up');
                }
            });
        });
    </script>

    @yield('scripts')
</body>

</html>
