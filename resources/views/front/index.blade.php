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

    <!-- Banner Section Begin -->
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
    <!-- Banner Section End -->

    <!-- Women Banner Section Begin -->
    <section class="women-banner spad">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3">
                    <div class="product-large set-bg" data-setbg="front/img/products/women-large.jpg">
                        <h2>Women's</h2>
                        <a href="#">Discover More</a>
                    </div>
                </div>
                <div class="col-lg-8 offset-lg-1">
                    <div class="filter-control">
                        <ul>
                            <li class="active item" data-tag="*" data-category="women">All</li>
                            <li class="item" data-tag=".Clothing" data-category="women">Clothings</li>
                            <li class="item" data-tag=".HandBag" data-category="women">HandBags</li>
                            <li class="item" data-tag=".Hats" data-category="women">Hats</li>
                            <li class="item" data-tag=".Accessories" data-category="women">Accessories</li>
                        </ul>
                    </div>
                    <div class="product-slider owl-carousel women">
                        @foreach($featuredProducts['women'] as $product)
                            @include('front.components.product-item')
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Women Banner Section End -->

    <!-- Deal Of The Week Section Begin -->
    <section class="deal-of-week set-bg spad" data-setbg="front/img/time-bg.jpg">
        <div class="container">
            <div class="col-lg-6 text-center">
                <div class="section-title">
                    <h2>Hot Deal</h2>
                    <p>Basic TEE Oversize</p>
                    <div class="product-price">
                        139.000đ
                        <span>/ T-Shirt</span>
                    </div>
                </div>
                <div class="countdown-timer" id="countdown">          
                </div>
                <a href="" class="primary-btn">Mua ngay</a>
            </div>
        </div>
    </section>
    <!-- Deal Of The Week Section End -->

    <!-- Man Banner Section Begin -->
    <section class="women-banner spad">
        <div class="container-fluid">
            <div class="row">
                <!-- Left side: Product slider -->
                <div class="col-lg-8">
                    <div class="filter-control">
                        <ul>
                            <li class="active item" data-tag="*" data-category="men">All</li>
                            <li class="item" data-tag=".Clothing" data-category="men">Clothings</li>
                            <li class="item" data-tag=".HandBags" data-category="men">HandBags</li>
                            <li class="item" data-tag=".Hats" data-category="men">Hats</li>
                            <li class="item" data-tag=".Accessories" data-category="men">Accessories</li>
                        </ul>
                    </div>
                    <div class="product-slider owl-carousel men">
                        @foreach($featuredProducts['men'] as $product)
                            @include('front.components.product-item')
                        @endforeach
                    </div>
                </div>

                <!-- Right side: Men banner -->
                <div class="col-lg-3 offset-lg-1">
                    <div class="product-large set-bg" data-setbg="front/img/products/man-large.jpg">
                        <h2>Men’s</h2>
                        <a href="#">Discover More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Man Banner Section End -->

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

    <!-- Latest Blog Section Begin -->
    <section class="latest-blog spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>From The Blog</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($blogs as $blog)
                    <div class="col-lg-4 col-md-6">
                        <div class="single-latest-blog">
                            <img src="front/img/blog/{{$blog->image}}" alt="">
                            <div class="latest-text">
                                <div class="tag-list">
                                    <div class="tab-item">
                                        <i class="fa fa-calendar-o"></i>
                                        {{date('M d, Y', strtotime($blog->created_at))}}
                                    </div>
                                    <div class="tab-item">
                                        <i class="fa fa-comment"></i>
                                        {{count($blog->blogComments)}}
                                    </div>
                                </div>
                                <a href="">
                                    <h4>{{$blog->title}}</h4>
                                </a>
                                <p>{{$blog->subtitle}}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="benefit-items">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="single-benefit">
                            <div class="sb-icon">
                                <img src="front/img/icon-1.png" alt="">
                            </div>
                            <div class="sb-text">
                                <h6>Free Ship</h6>
                                <p>Nội thành và đơn trên 1tr</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="single-benefit">
                            <div class="sb-icon">
                                <img src="front/img/icon-1.png" alt="">
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
                                <img src="front/img/icon-1.png" alt="">
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
