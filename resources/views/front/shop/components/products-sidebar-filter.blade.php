<form action="{{ request()->segment(2) == 'product' ? url('shop') : '' }}" method="GET" id="filter-auto-submit">
    
    @foreach(request()->except(['brand', 'size', 'color', 'tag', 'price_min', 'price_max', 'page']) as $name => $value)
        @if(is_array($value))
            @foreach($value as $k => $v)
                <input type="hidden" name="{{ $name }}[{{ $k }}]" value="{{ $v }}">
            @endforeach
        @else
            <input type="hidden" name="{{ $name }}" value="{{ $value }}">
        @endif
    @endforeach
    
    @if(request('price_min'))
        <input type="hidden" name="price_min" value="{{ request('price_min') }}">
    @endif
    @if(request('price_max'))
        <input type="hidden" name="price_max" value="{{ request('price_max') }}">
    @endif

    <div class="filter-widget">
        <h4 class="fw-title">Categories</h4>
        <ul class="filter-categories">
            @foreach($categories as $category)
                <li><a href="{{ request()->segment(2) == 'product' ? url('shop/category/' . $category->name) : url('shop/category/' . $category->name) }}">{{ $category->name }}</a></li>
            @endforeach
        </ul>
    </div>

    <div class="filter-widget">
        <h4 class="fw-title">Brand</h4>
        <div class="fw-brand-check">
            @foreach($brands as $brand)
                <div class="bc-item">
                    <label for="bc-{{ $brand->id }}">
                        {{ $brand->name }} 
                        <input type="checkbox"
                               {{ (request("brand")[$brand->id] ?? '') == 'on' ? 'checked' : '' }}
                               id="bc-{{ $brand->id }}"
                               name="brand[{{ $brand->id }}]"
                               onchange="this.form.submit();">
                        <span class="checkmark"></span>
                    </label>
                </div>
            @endforeach
        </div>
    </div>
    
    <div class="filter-widget">
        <h4 class="fw-title">Tags</h4>
        <div class="fw-tags-choose"> 
            @foreach(['Clothing', 'Handbags', 'Accessories', 'Hats'] as $tag)
                <div class="tag-item"> 
                    <input type="radio" 
                    id="tag-{{ $tag }}" 
                    name="tag" 
                    value="{{ $tag }}" 
                    {{ request('tag') == $tag ? 'checked' : '' }}
                    onchange="this.form.submit();">
                
                    <label for="tag-{{ $tag }}" class="{{ request('tag') == $tag ? 'active' : '' }}">
                    {{ ucwords($tag) }} </label>
                </div>
            @endforeach
        </div>
    </div>
    
    <div class="filter-widget">
        <h4 class="fw-title">Size</h4>
        <div class="fw-size-choose">
            @foreach(['s', 'm', 'l', 'xl', '20l', '25l', '30l', 'fs'] as $size)
            <div class="sc-item">
                <input type="radio" id="{{ $size }}-size" name="size" value="{{ $size }}" 
                    {{ request('size') == $size ? 'checked' : '' }}
                    onchange="this.form.submit();">
                <label for="{{ $size }}-size" class="{{ request('size') == $size ? 'active' : '' }}">{{ strtoupper($size) }}</label>
            </div>
            @endforeach
        </div>
    </div>
    
    <div class="filter-widget">
        <h4 class="fw-title">Color</h4>
        <div class="fw-color-choose">
            @foreach([
                'black' => 'Đen', 'white' => 'Trắng', 'pink' => 'Hồng', 'gray' => 'Xám đậm',
                'yellow' => 'Vàng', 'lavender' => 'Tím nhạt', 'dark-green' => 'Xanh lá', 'red' => 'Đỏ',
                'taupe' => 'Nâu','cream' => 'Be/Kem','sky-blue' => 'Xanh nhạt','cyan' => 'Xanh Cyan','orange' => 'Cam',
                'silver' => 'Xám bạc','purple' => 'Tím','blue' => 'Xanh dương'
            ] as $value => $label)
            <div class="cs-item">
                <input type="radio" id="cs-{{ $value }}" name="color" value="{{ $value }}" 
                    {{ request('color') == $value ? 'checked' : '' }}
                    onchange="this.form.submit();">
                <label class="cs-{{ $value }}" for="cs-{{ $value }}">{{ $label }}</label>
            </div>
            @endforeach
        </div>
    </div>
</form>


<form action="{{ request()->segment(2) == 'product' ? url('shop') : '' }}" method="GET" id="filter-price">
    
    @foreach(request()->except(['price_min', 'price_max', 'page']) as $name => $value)
        @if(is_array($value))
            @foreach($value as $k => $v)
                <input type="hidden" name="{{ $name }}[{{ $k }}]" value="{{ $v }}">
            @endforeach
        @else
            <input type="hidden" name="{{ $name }}" value="{{ $value }}">
        @endif
    @endforeach

    <div class="filter-widget">
        <h4 class="fw-title">Price</h4>
        <div class="filter-range-wrap">
            <div class="range-slider">
                <div class="price-input">
                    <input type="hidden" id="minamount_hidden" name="price_min"
                        value="{{ str_replace(['.', 'đ'], '', request('price_min') ?? '') ?: 100000 }}">
                    <input type="hidden" id="maxamount_hidden" name="price_max"
                        value="{{ str_replace(['.', 'đ'], '', request('price_max') ?? '') ?: 3000000 }}">
                    
                    <input type="text" id="minamount" readonly> 
                    <input type="text" id="maxamount" readonly>
                </div>
            </div>
            <?php
                $min_val_req = request('price_min') ?? ''; 
                $max_val_req = request('price_max') ?? '';
                $cleaned_min_raw = str_replace(['.', 'đ'], '', $min_val_req);
                $cleaned_max_raw = str_replace(['.', 'đ'], '', $max_val_req);
                $min_val_slider = $cleaned_min_raw ? (float)$cleaned_min_raw / 1000 : 100;
                $max_val_slider = $cleaned_max_raw ? (float)$cleaned_max_raw / 1000 : 3000;
            ?>
            <div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content "
                data-min="100"
                data-max="3000"
                data-min-value="{{ (int)$min_val_slider }}"
                data-max-value="{{ (int)$max_val_slider }}">
                <div class="ui-slider ui-corner-all ui-widget-header"></div>
                <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
            </div>
        </div>
        <button type="submit" class="filter-btn">Filter</button>
    </div>
</form>