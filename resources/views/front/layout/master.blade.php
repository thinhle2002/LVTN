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
    <link rel="stylesheet" href="{{ asset('front/css/rating.css') }}">

</head>

<body>

    <!-- Page Preloader -->
    <div id="preloader">
        <div class="loader"></div>
    </div>

    <!-- Header Session Begin -->
    <header class="header-section">
        {{-- <div class="header-top">
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
                    <a href="login.html" class="login-panel"><i class="fa fa-user"></i>Đăng nhập / Đăng ký</a>
                    
                    <div class="top-social">
                        <a href="https://www.facebook.com/thinhh.02"><i class="ti-facebook"></i></a>
                        <a href="https://www.instagram.com/_dinoshelby_/"><i class="ti-instagram"></i></a>                    
                    </div>
                </div>
            </div>
        </div> --}}

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
                                    <input name="search" value="{{ request('search') }}" type="text" placeholder="What do you need?">
                                    {{-- <button type="submit"><i class="ti-search"></i></button> --}}
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-3 col-md-3 text-right">
                        <ul class="nav-right">
                            <li class="heart-icon">
                                <a href="#">
                                    <i class="icon_heart_alt"></i>
                                    <span>1</span>
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
                                                    <td class="si-pic"><img style="height: 70px;" src="front/img/products/{{ $cart->options->images[0]->path }}"></td>
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

        <div class="nav-item">
            <div class="container">
                <div class="nav-depart">
                    {{-- <div class="depart-btn">
                        <i class="ti-menu"></i>
                        <span>All departments</span>
                        <ul class="depart-hover">
                            <li class="active"><a href="#">Women's Clothing</a></li>
                            <li><a href="#">Men's Clothing</a></li>
                            <li><a href="#">Unisex</a></li>                      
                            <li><a href="#">Handbags</a></li>
                            <li><a href="#">Accessories</a></li>
                            <li><a href="#">Hats</a></li>
                        </ul>
                    </div> --}}
                </div>
                <nav class="nav-menu mobile-menu">
                    <ul>
                        <li class="{{ (request()->segment(1) == '') ? 'active' : ''}} "><a href="./">Home</a></li>
                        <li class="{{ (request()->segment(1) == 'shop') ? 'active' : ''}} "><a href="./shop">Shop</a></li>
                        <li><a href="">Collection</a>
                            <ul class="dropdown">
                                <li><a href="">Men</a></li>
                                <li><a href="">Women</a></li>
                                <li><a href="">Unisex</a></li>
                            </ul>
                        </li>
                        <li><a href="">Blog</a></li>
                        {{-- <li><a href="">Contact</a></li> --}}
                        <li><a href="">Login</a></li>
                        {{-- <li><a href="">Pages</a>
                            <ul class="dropdown">
                                <li><a href="blog-details.html">Blog Details</a></li>
                                <li><a href="./cart">Shopping Cart</a></li>
                                <li><a href="./checkout">Checkout</a></li>
                                <li><a href="faq.html">Faq</a></li>
                                <li><a href="register.html">Register</a></li>
                                <li><a href="login.html">Login</a></li>
                            </ul>
                        </li> --}}
                    </ul>
                </nav>
                <div id="mobile-menu-wrap"></div>
            </div>
        </div>
    </header>
    <!-- Header End -->

    <!-- Body Here -->
    @yield('body')

    <!-- Partner Logo Section Begin -->
    {{-- <div class="partner-logo">
        <div class="container">
            <div class="logo-carousel owl-carousel">
                <div class="logo-item">
                    <div class="tablecell-inner">
                        <img src="front/img/logo-carousel/logo-1.png">
                    </div>
                </div>
                <div class="logo-item">
                    <div class="tablecell-inner">
                        <img src="front/img/logo-carousel/logo-2.png">
                    </div>
                </div>
                <div class="logo-item">
                    <div class="tablecell-inner">
                        <img src="front/img/logo-carousel/logo-3.png">
                    </div>
                </div>
                <div class="logo-item">
                    <div class="tablecell-inner">
                        <img src="front/img/logo-carousel/logo-4.png">
                    </div>
                </div>
                <div class="logo-item">
                    <div class="tablecell-inner">
                        <img src="front/img/logo-carousel/logo-5.png">
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- Partner Logo Section End -->

    <!-- Footer Section Begin -->
    <footer class="footer-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="footer-left">
                        <div class="footer-logo">
                            <a href="index.html">
                                <img src="front/img/" height="25" alt="">
                            </a>
                        </div>
                        <ul>
                            <li>164 TTN . TPHCM</li>
                            <li>Phone : +84 24.55.66.525</li>
                            <li>Email: txfashion@mail.com</li>
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
                            Information
                        </h5>
                        <ul>
                            <li><a href="">About us</a></li>
                            <li><a href="">Checkout</a></li>
                            <li><a href="">Contact</a></li>
                            <li><a href="">Service</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="footer-widget">
                        <h5>
                            My Account
                        </h5>
                        <ul>
                            <li><a href="">My Account</a></li>
                            <li><a href="">Contact</a></li>
                            <li><a href="">Shopping cart</a></li>
                            <li><a href="">Shop</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="newslatter-item">
                        <h5>Join Our Newsletter Now</h5>
                        <p>Got E-mail updates about our latest shop and speacial offers</p>
                        <form action="#" class="subscribe-form">
                            <input type="text" placeholder="Enter your email">
                            <button type="button"> Subscribe</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright-reserved">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="copyright-text">
                            Copyright © <script>document.write(new Date().getFullYear()); </script> All right reserved <i class="fa fa-heart-o" aria-hidden="true"></i>
                        </div>
                        <div class="payment-pic">
                            <img src="front/img/payment-method.png" alt="">
                        </div>
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
    @yield('scripts')
</body>

</html>
