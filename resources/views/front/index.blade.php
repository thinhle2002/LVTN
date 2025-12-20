@extends('front.layout.master')

@section('title','Home')

@section('body')
    <!-- Hero Section Begin -->
    <section class="hero-section">
        <div class="hero-items owl-carousel">
            <div class="single-hero-items set-bg" data-setbg="front/img/hero-1.jpg">
                {{-- <div class="container">
                    <div class="row">
                        <div class="col-lg-5">
                            <span>Men</span>
                            <h1>11/11 Sales</h1>
                            <p>Tưng bừng ngày đôi hàng tháng, deal hời thỏa sức mua sắm</p>
                            <a href="#" class="primary-btn">Shop Now</a>
                        </div>
                    </div>
                    <div class="off-card">
                        <h2>Sale <span>44%</span></h2>
                    </div>
                </div> --}}
            </div>
            <div class="single-hero-items set-bg" data-setbg="front/img/hero-2.jpg">
                {{-- <div class="container">
                    <div class="row">
                        <div class="col-lg-5">
                            <span>Kids</span>
                            <h1>Siêu Sale Sập Sàn</h1>
                            <p>SALE bùng cháy - Ưu đãi khủng. Chương trình chỉ áp dụng duy nhất ngày 11/11</p>
                            <a href="#" class="primary-btn">Shop Now</a>
                        </div>
                    </div>
                    <div class="off-card">
                        <h2>Sale <span>44%</span></h2>
                    </div>
                </div> --}}
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    {{-- <!-- Banner Section Begin -->
    <div class="banner-section spad">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4">
                    <div class="single-banner">
                        <img src="front/img/banner-1.jpg" alt="">
                        <div class="inner-text">
                            <h4>Men's</h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="single-banner">
                        <img src="front/img/banner-2.jpg" alt="">
                        <div class="inner-text">
                            <h4>Women's</h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="single-banner">
                        <img src="front/img/banner-3.jpg" alt="">
                        <div class="inner-text">
                            <h4>Unisex</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Banner Section End --> --}}

    <!-- Clothing Banner Section Begin -->
    <section class="women-banner spad">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3">
                    <div class="product-large set-bg" data-setbg="upload/front/img/products/women-large.jpg">
                    </div>
                </div>
                <div class="col-lg-8 offset-lg-1">
                    <h2 style="font-size: 28px; font-weight: 600; text-align: center; margin-bottom: 20px;">Thời trang</h2>
                    <div class="filter-control">                       
                        <ul>
                            <li class="active item" data-tag="*" data-category="clothing">Tất cả</li>
                            <li class="item" data-tag=".T-Shirt" data-category="clothing">Áo thun</li>
                            <li class="item" data-tag=".Shirt" data-category="clothing">Áo sơ mi</li>
                            <li class="item" data-tag=".Polo" data-category="clothing">Áo polo</li>
                            <li class="item" data-tag=".Pants" data-category="clothing">Quần dài</li>
                            <li class="item" data-tag=".Short" data-category="clothing">Quần short</li>
                        </ul>
                    </div>
                    <div class="product-slider owl-carousel clothing">
                        @foreach($featuredProducts['clothing'] as $product)
                            <div class="product-item item {{ $product->tag }}">
                                @include('front.components.product-item')
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Clothing Banner Section End -->

    <!-- Accessories Banner Section Begin -->
    <section class="women-banner spad">
        <div class="container-fluid">
            <div class="row">
                <!-- Left side: Product slider -->
                <div class="col-lg-8">
                    <h2 style="font-size: 28px; font-weight: 600; text-align: center; margin-bottom: 20px;">Phụ kiện</h2>
                    <div class="filter-control">                    
                        <ul>
                            <li class="active item" data-tag="*" data-category="accessories"></li>
                            <li class="item" data-tag=".Balo" data-category="accessories">Balo</li>
                            <li class="item" data-tag=".HandBag" data-category="accessories">Túi xách</li>
                            <li class="item" data-tag=".Hat" data-category="accessories">Nón</li>                          
                        </ul>
                    </div>
                    <div class="product-slider owl-carousel accessories">
                        @foreach($featuredProducts['accessories'] as $product)
                            <div class="product-item item {{ $product->tag }}">
                                @include('front.components.product-item')
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Right side: Accessories banner -->
                <div class="col-lg-3 offset-lg-1">
                    <div class="product-large set-bg" data-setbg="upload/front/img/products/man-large.jpg">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Accessories Banner Section End -->

    <!-- Social Section Begin -->
    <div class="instagram-photo">
        <div class="insta-item set-bg" data-setbg="front/img/insta-1.jpg">
            <div class="inside-text">
                <i class="ti-instagram"></i>
                <h5><a href="https://www.instagram.com/badhabitsstore.vn/">Bad Habits</a></h5>
            </div>
        </div>
        <div class="insta-item set-bg" data-setbg="front/img/insta-2.jpg">
            <div class="inside-text">
                <i class="ti-instagram"></i>
                <h5><a href="https://www.instagram.com/degrey.saigon/">Degrey</a></h5>
            </div>
        </div>
        <div class="insta-item set-bg" data-setbg="front/img/insta-3.jpg">
            <div class="inside-text">
                <i class="ti-instagram"></i>
                <h5><a href="https://www.instagram.com/teelab.vn/">Teelab</a></h5>
            </div>
        </div>
        <div class="insta-item set-bg" data-setbg="front/img/insta-4.jpg">
            <div class="inside-text">
                <i class="ti-instagram"></i>
                <h5><a href="https://www.instagram.com/dearjose.xo/">Dear José</a></h5>
            </div>
        </div>
        <div class="insta-item set-bg" data-setbg="front/img/insta-5.jpg">
            <div class="inside-text">
                <i class="ti-instagram"></i>
                <h5><a href="https://www.instagram.com/tingoan_store/">Tingoan</a></h5>
            </div>
        </div>
        <div class="insta-item set-bg" data-setbg="front/img/insta-6.jpg">
            <div class="inside-text">
                <i class="ti-instagram"></i>
                <h5><a href="https://www.instagram.com/cardinal.id/">Cardina</a></h5>
            </div>
        </div>
    </div>
    <!-- Social Section End -->

    <!-- Latest Blog Section End (Removed) -->

    <!-- Benefit Items Section Begin -->
    <section class="latest-blog spad">
        <div class="container">
            <div class="benefit-items">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="single-benefit">
                            <div class="sb-icon">
                                <img src="front/img/icon-1.png" alt="">
                            </div>
                            <div class="sb-text">
                                <h6>Giảm giá vận chuyển</h6>
                                <p>Nội thành - TP.HCM</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="single-benefit">
                            <div class="sb-icon">
                                <img src="front/img/icon-2.png" alt="">
                            </div>
                            <div class="sb-text">
                                <h6>Giao hàng</h6>
                                <p>Nhanh chóng và an toàn</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="single-benefit">
                            <div class="sb-icon">
                                <img src="front/img/icon-3.png" alt="">
                            </div>
                            <div class="sb-text">
                                <h6>Thanh toán</h6>
                                <p>An toàn và tiện lợi</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Latest Blog Section End -->
@endsection
