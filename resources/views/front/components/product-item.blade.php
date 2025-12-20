@php
    $tagLabels = config('tags.labels');
@endphp
<div class="product-item item {{ $product->tag }}">
    <div class="pi-pic">
        <img src="upload/front/img/products/{{ $product->productImages[0]->path ?? '' }}" alt="">

        @if($product->discount != null)
            <div class="sale">Sale</div>
        @endif

        <ul>
            <li class="quick-view">
                <a href="shop/product/{{ $product->id }}">+ Xem chi tiết</a>
            </li>
        </ul>
    </div>

    <div class="pi-text">
        <div class="catagory-name">
            {{ $tagLabels[$product->tag] ?? $product->tag }}
        </div>

        <a href="shop/product/{{ $product->id }}">
            <h5>{{ $product->name }}</h5>
        </a>

        <div class="product-price">
            @if($product->discount != null)
                {{ number_format($product->discount * 1000, 0, ',', '.') }}đ
                <span>{{ number_format($product->price * 1000, 0, ',', '.') }}đ</span>
            @else
                {{ number_format($product->price * 1000, 0, ',', '.') }}đ
            @endif
        </div>
    </div>
</div>


