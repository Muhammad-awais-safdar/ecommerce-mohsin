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
                        <form class="select-item select-form">
                            <span class="title">Sort</span>
                            <select title="sort" data-placeholder="All " class="chosen-select">
                                <option value="2">Brands</option>
                                <option value="1">Brands</option>

                            </select>
                        </form>
                        <form class="filter-choice select-form">
                            <span class="title">Sort by</span>
                            <select title="sort-by" data-placeholder="Price: Low to High" class="chosen-select">
                                <option value="1">Price: Low to High</option>
                                <option value="2">Sort by popularity</option>
                                <option value="3">Sort by average rating</option>
                                <option value="4">Sort by newness</option>
                                <option value="5">Sort by price: low to high</option>
                            </select>
                        </form>

                    </div>
                    <ul class="row list-products auto-clear equal-container product-grid" id="product-grid">
                        @foreach ($products as $product)
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
                                        <span class="onnew">
                                            <span class="text">
                                                new
                                            </span>
                                        </span>
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
                                                        <a href="{{ route('product.show', $product->slug) }}">{{
                                                            $product->name }}</a>
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
                                                    </div>
                                            </div>
                                        </div>
                        </li>
                        @endforeach


                    </ul>
                    <div id="pagination-container">
                        {{ $products->links('vendor.pagination.default') }}
                    </div>

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