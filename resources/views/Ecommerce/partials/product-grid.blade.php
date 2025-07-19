@foreach ($products as $product)
@php
$originalPrice = $product->price;
$discount = $product->discount_percentage ?? 0;
$finalPrice = $discount > 0 ? $originalPrice - $originalPrice * ($discount / 100) : $originalPrice;
$isListView = request('view') === 'list';
@endphp
<li class="product-item {{ $isListView ? 'col-12' : 'col-lg-3 col-md-4 col-sm-6 col-xs-6 col-ts-12' }} style-1">
    <div class="product-inner equal-element {{ $isListView ? 'list-view' : '' }}">
        @if (!$isListView)
        <div class="product-top">
            <div class="flash">
                <span class="onnew">
                    <span class="text">new</span>
                </span>
            </div>
        </div>
        @endif
        
        <div class="product-thumb {{ $isListView ? 'list-thumb' : '' }}">
            <div class="thumb-inner">
                <a href="{{ route('product.show', $product->slug) }}">
                    <img src="{{ asset('storage/' . $product->images[0]) }}"loading="lazy" alt="{{ $product->name }}">
                </a>
                @if (!$isListView)
                <div class="thumb-group">
                    <div class="loop-form-add-to-cart">
                        <button class="single_add_to_cart_button button add-to-cart-btn" 
                                data-id="{{ $product->id }}" 
                                data-name="{{ $product->name }}" 
                                data-price="{{ $finalPrice }}"
                                onclick="addToCart({{ $product->id }})">Add to cart</button>
                    </div>
                </div>
                @endif
            </div>
        </div>
        
        <div class="product-info {{ $isListView ? 'list-info' : '' }}">
            <h5 class="product-name product_title">
                <a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
            </h5>
            
            @if ($isListView)
            <div class="product-description">
                <p>{{ Str::limit($product->description, 150) }}</p>
            </div>
            @endif
            
            <div class="group-info">
                @php
                    $count = $product->reviews->count();
                    $avg = $count ? round($product->reviews->avg('rating')) : 0;
                @endphp
                <div class="stars-rating">
                    <div class="star-rating">
                        <span class="star-{{ $avg }}"></span>
                    </div>
                    <div class="count-star">({{ $count }})</div>
                </div>
                <div class="price">
                    @if ($discount > 0)
                        <del>£{{ number_format($originalPrice, 2) }}</del>
                        <ins>£{{ number_format($finalPrice, 2) }}</ins>
                    @else
                        <ins>£{{ number_format($originalPrice, 2) }}</ins>
                    @endif
                </div>
            </div>
            
            @if ($isListView)
            <div class="list-actions">
                <button class="single_add_to_cart_button button add-to-cart-btn" 
                        data-id="{{ $product->id }}" 
                        data-name="{{ $product->name }}" 
                        data-price="{{ $finalPrice }}"
                        onclick="addToCart({{ $product->id }})">Add to cart</button>
                <a href="{{ route('product.show', $product->slug) }}" class="btn btn-outline-secondary">View Details</a>
            </div>
            @endif
        </div>
    </div>
</li>
@endforeach