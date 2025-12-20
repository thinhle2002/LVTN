@extends('front.layout.master')

@section('title', 'Cart')

@section('body')

    <!-- Shopping Cart Session Begin -->
    <div class="shopping-cart spad">
        <div class="container">
            <div class="row">
                @if(Cart::count() > 0)
                    <div class="col-lg-12">
                        <div class="cart-table">
                        <table>
                            <thead>
                            <tr>
                                <th>Hình ảnh</th>
                                <th class="p-name">Sản phẩm</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Tổng tiền</th>
                                <th>
                                    <i onclick="confirm('Are you sure to delete all carts?') === true ? destroyCart() : ''" class="ti-close" style="cursor: pointer"></i>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($carts as $cart)
                                    <tr data-rowid="{{ $cart->rowId }}">
                                        <td>
                                            <div class="cart-pic first-row">
                                                <img style="height: 170px;" src="upload/front/img/products/{{ $cart->options->images['path'] }}" alt="">
                                            </div>
                                        </td>                                                                         
                                        <td class="cart-title first-row">
                                            <h5>{{ $cart->name }}</h5>                                     
                                            @php
                                                $colorMap = config('convertColor.colors');
                                                $rawColor = $cart->options->color ?? null;
                                                $productSize = $cart->options->size ?? null;

                                                $displayColor = $colorMap[$rawColor] ?? $rawColor;
                                            @endphp
                                 
                                            @if ($rawColor || $productSize)
                                                <p style="font-size: 14px; color: #666; margin-top: 5px;">
                                                    @if ($rawColor)
                                                        {{ $displayColor }}
                                                    @endif
                                                    @if ($productSize)
                                                        @if ($rawColor) / @endif {{ $productSize }}
                                                    @endif
                                                </p>
                                            @endif
                                        </td>
                                        <td class="p-price first-row">{{ number_format($cart->price * 1000, 0, ',', '.') }}đ</td>
                                        <td class="qua-col first-row">
                                            <div class="quantity">
                                                <div class="pro-qty">
                                                    <input type="text" value="{{ $cart->qty }}" data-rowId="{{ $cart->rowId }}">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="total-price first-row">{{ number_format($cart->price * $cart->qty * 1000, 0, ',', '.') }}đ</td>
                                        <td class="close-td first-row">
                                            <div class="si-close">
                                                <i onclick="removeCart('{{ $cart->rowId }}')" class="ti-trash remove-icon-red"></i>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="cart-buttons">
                                <a href="/shop" class="primary-btn continue-shop">Tiếp tục mua sắm</a>
                                {{-- <a href="#" class="primary-btn up-cart">Update cart</a> --}}
                            </div>
                            {{-- <div class="discount-coupon">
                                <h6>Discount Codes</h6>
                                <form action="#" class="coupon-form">
                                    <input type="text" placeholder="Enter your codes">
                                    <button type="submit" class="site-btn coupon-btn">Apply</button>
                                </form>
                            </div> --}}
                        </div>
                        <div class="col-lg-4 offset-lg-4">
                            <div class="proceed-checkout">
                                <ul>
                                    <li class="subtotal">Tạm tính <span> {{ number_format($subtotal * 1000, 0, ',', '.') }}đ</span></li>
                                    <li class="cart-total">Tổng tiền <span> {{ number_format($total * 1000, 0, ',', '.') }}đ</span></li>
                                </ul>
                                @if(Auth::check())
                                    <a href="{{ url('/checkout') }}" class="proceed-btn">THANH TOÁN</a>
                                @else
                                    <a href="{{ url('./account/login') }}" class="proceed-btn **disabled**" **title="Vui lòng đăng nhập để thanh toán"**>Thanh toán</a> 
                                    <p style="color: red; text-align: center; margin-top: 10px;">Vui lòng đăng nhập để thanh toán</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @else
                    <div class="col-lg-12">
                        <h4>Giỏ hàng của bạn đang trống.</h4>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- Shopping Cart Session End -->

@endsection
