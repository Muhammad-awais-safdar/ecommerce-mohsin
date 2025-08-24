@extends('Ecommerce.layouts.app')

@section('content')
<div class="main-content main-content-product no-sidebar">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-trail breadcrumbs">
                    <ul class="trail-items breadcrumb">
                        <li class="trail-item trail-begin">
                            <a href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="trail-item trail-end active">
                            Products
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="content-area shop-grid-content full-width col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="site-main">
                    <h3 class="custom_blog_title">
                        Products
                    </h3>
                    <div class="shop-top-control">
                        <div class="row">
                            <div class="col-md-4">
                                <form class="search-form" method="GET">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control" placeholder="Search products..." value="{{ request('search') }}">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-3">
                                <form class="filter-choice select-form" method="GET">
                                    <span class="title">Sort by</span>
                                    <select name="sort" title="sort-by" class="form-control" onchange="this.form.submit()">
                                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name A-Z</option>
                                    </select>
                                    @if(request('search'))
                                        <input type="hidden" name="search" value="{{ request('search') }}">
                                    @endif
                                </form>
                            </div>
                            <div class="col-md-3">
                                <form class="price-filter" method="GET">
                                    <span class="title">Price Range</span>
                                    <div class="input-group">
                                        <input type="number" name="min_price" class="form-control" placeholder="Min" value="{{ request('min_price') }}" style="width: 80px;">
                                        <input type="number" name="max_price" class="form-control" placeholder="Max" value="{{ request('max_price') }}" style="width: 80px;">
                                        <button type="submit" class="btn btn-secondary">Filter</button>
                                    </div>
                                    @if(request('search'))
                                        <input type="hidden" name="search" value="{{ request('search') }}">
                                    @endif
                                    @if(request('sort'))
                                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                                    @endif
                                </form>
                            </div>
                            <div class="col-md-2">
                                <div class="results-info">
                                    <span class="title">Results</span>
                                    <p class="count">{{ $products->total() }} products found</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ul class="row list-products auto-clear equal-container product-grid" id="product-grid">
                        @forelse ($products as $product)
                        @php
                        $originalPrice = $product->price;
                        $discount = $product->discount_percentage ?? 0;
                        $finalPrice =
                        $discount > 0
                        ? $originalPrice - $originalPrice * ($discount / 100)
                        : $originalPrice;
                        @endphp
                        <li class="product-item  col-lg-3 col-md-4 col-sm-6 col-xs-6 col-ts-12 style-1">
                            <div class="product-inner equal-element">
                                <div class="product-top">
                                    <div class="flash">
                                        @if($product->created_at->diffInDays() < 7)
                                        <span class="onnew">
                                            <span class="text">
                                                new
                                            </span>
                                        </span>
                                        @endif
                                        @if($discount > 0)
                                        <span class="onsale">
                                            <span class="text">
                                                -{{ $discount }}%
                                            </span>
                                        </span>
                                        @endif
                                        @if($product->is_deal)
                                        <span class="ondeal">
                                            <span class="text">
                                                Deal
                                            </span>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="product-thumb">
                                    <div class="thumb-inner">
                                        <a href="{{ route('product.show', $product->slug) }}">
                                            <img src="{{ asset('storage/' . $product->images[0]) }}" loading="lazy"
                                                alt="img">
                                        </a>
                                        <div class="thumb-group">

                                            <div class="loop-form-add-to-cart">
                                                <button class="single_add_to_cart_button button add-to-cart-btn"
                                                    data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                                                    data-price="{{ $finalPrice }}"
                                                    onclick="addToCart({{ $product->id }})">Add to cart
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                        <div class=" product-info">
                                                    <h5 class="product-name product_title">
                                                        <a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
                                                    </h5>
                                                    <div class="group-info">
                                                        @php
                                                        // Make sure $product->reviews is loaded
                                                        $count = $product->reviews->count();
                                                        $avg = $count
                                                        ? round($product->reviews->avg('rating')) // round to nearest integer
                                                        : 0;
                                                        @endphp

                                                        <div class="stars-rating">
                                                            <div class="star-rating">
                                                                {{-- “star-{{ $avg }}” will show N filled stars via your
                                                                CSS --}}
                                                                <span class="star-{{ $avg }}"></span>
                                                            </div>
                                                            <div class="count-star">
                                                                ({{ $count }})
                                                            </div>
                                                        </div>
                                                        <div class="price">

                                                            @if ($discount > 0)
                                                            <del>£{{ number_format($originalPrice, 2) }}</del>
                                                            <ins>£{{ number_format($finalPrice, 2) }}</ins>
                                                            @else
                                                            <ins>£{{ number_format($originalPrice, 2) }}</ins>
                                                            @endif
                                                        </div>
                                                        
                                                        @if($product->stock && $product->stock->quantity <= 5 && $product->stock->quantity > 0)
                                                        <div class="stock-warning">
                                                            <small class="text-warning">Only {{ $product->stock->quantity }} left!</small>
                                                        </div>
                                                        @elseif($product->stock && $product->stock->quantity == 0)
                                                        <div class="stock-warning">
                                                            <small class="text-danger">Out of stock</small>
                                                        </div>
                                                        @endif
                                                    </div>
                                            </div>
                                        </div>
                        </li>
                        @empty
                        <li class="col-12">
                            <div class="no-products-found text-center py-5">
                                <h4>No products found</h4>
                                <p>Try adjusting your search or filter criteria.</p>
                                @if(request()->hasAny(['search', 'min_price', 'max_price', 'sort']))
                                <a href="{{ route('shop') }}" class="btn btn-primary">Clear Filters</a>
                                @endif
                            </div>
                        </li>
                        @endforelse


                    </ul>
                    @if($products->hasPages())
                    <div id="pagination-container">
                        {{ $products->appends(request()->query())->links('vendor.pagination.default') }}
                    </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Add to cart tracking
        document.querySelectorAll('.add-to-cart-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                fbq('track', 'AddToCart', {
                    content_ids: [button.dataset.id],
                    content_name: button.dataset.name,
                    content_type: 'product',
                    value: button.dataset.price,
                    currency: 'GBP'
                });
            });
        });
    });
</script>
@endpush