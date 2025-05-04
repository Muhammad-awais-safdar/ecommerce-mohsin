@extends('Ecommerce.layouts.app')
@section('content')
    <div class="fullwidth-template">
        <div class="home-slider-banner">
            <div class="container">
                <div class="row10">
                    <div class="col-lg-8 silider-wrapp">
                        <div class="home-slider">
                            <div class="slider-owl owl-slick equal-container nav-center"
                                data-slick='{"autoplay":true, "autoplaySpeed":9000, "arrows":false, "dots":true, "infinite":true, "speed":1000, "rows":1}'
                                data-responsive='[{"breakpoint":"2000","settings":{"slidesToShow":1}}]'>
                                <div class="slider-item style7">
                                    <div class="slider-inner equal-element">
                                        <div class="slider-infor">
                                            <h5 class="title-small">
                                                Sale up to 20% off! 
                                            </h5>
                                            <h3 class="title-big">
                                             TAKE A PERFUME <br> TOP TRENDS UK
                                            </h3>
                                            <div class="price">
                                                Now from just: 
                                                <span class="number-price">
                                                   £109.00
                                                </span>
                                            </div>
                                            <a href="#" class="button btn-shop-the-look bgroud-style">Shop now</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="slider-item style8">
                                    <div class="slider-inner equal-element">
                                        <div class="slider-infor">
                                            <h5 class="title-small">
                                                Take A perfume
                                            </h5>
                                            <h3 class="title-big">
                                                Up to 25% Off <br />order now
                                            </h3>
                                            <div class="price">
                                                Save Price:
                                                <span class="number-price">
                                                    $170.00
                                                </span>
                                            </div>
                                            <a href="#" class="button btn-shop-product">Shop now</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="slider-item style9">
                                    <div class="slider-inner equal-element">
                                        <div class="slider-infor">
                                            <h5 class="title-small">
                                                Stelina Best Collection
                                            </h5>
                                            <h3 class="title-big">
                                                A range of <br />perfume
                                            </h3>
                                            <div class="price">
                                                New Price:
                                                <span class="number-price">
                                                    $250.00
                                                </span>
                                            </div>
                                            <a href="#" class="button btn-chekout">Shop now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 banner-wrapp">
                        <div class="banner">
                            <div class="item-banner style7">
                                <div class="inner">
                                    <div class="banner-content">
                                        <h3 class="title">Pick Your <br />Items</h3>
                                        <div class="description">
                                            Adipiscing elit curabitur senectus sem
                                        </div>
                                        <a href="#" class="button btn-lets-do-it">Shop now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="banner">
                            <div class="item-banner style8">
                                <div class="inner">
                                    <div class="banner-content">
                                        <h3 class="title">Best Of<br />Products</h3>
                                        <div class="description">
                                            Cras pulvinar loresum dolor conse
                                        </div>
                                        <span class="price">$379.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="stelina-product produc-featured rows-space-65">
            <div class="container">
                <h3 class="custommenu-title-blog">
                    Deal of the day
                </h3>

                <div class="owl-products owl-slick equal-container nav-center"
                    data-slick='{"autoplay":true, "autoplaySpeed":1000, "arrows":false, "dots":false, "infinite":true, "speed":800, "rows":1}'
                    data-responsive='[{"breakpoint":"2000","settings":{"slidesToShow":4}},{"breakpoint":"1200","settings":{"slidesToShow":3}},{"breakpoint":"992","settings":{"slidesToShow":2}},{"breakpoint":"480","settings":{"slidesToShow":1}}]'>
                    @foreach ($products as $item)
                        <div class="product-item style-5">
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
                                        <a href="#">
                                            <img src="{{ asset('storage/' . $item->image) }}" alt="img">
                                        </a>
                                        <div class="thumb-group">

                                            {{-- <a href="#" class="button quick-wiew-button">Quick View</a> --}}
                                            <div class="loop-form-add-to-cart">
                                                <button class="single_add_to_cart_button button"
                                                    onclick="addToCart({{ $item->id }})">Add to cart
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-count-down">
                                        <div class="stelina-countdown" id="countdown"></div>
                                    </div>
                                </div>
                                <div class="product-info">
                                    <h5 class="product-name product_title">
                                        <a href="{{ route('product.show', $item->id) }}">{{ $item->name }}</a>
                                    </h5>
                                    <div class="group-info">
                                        @php
                                            // Make sure $product->reviews is loaded
                                            $count = $item->reviews->count();
                                            $avg = $count
                                                ? round($item->reviews->avg('rating')) // round to nearest integer
                                                : 0;
                                        @endphp

                                        <div class="stars-rating">
                                            <div class="star-rating">
                                                {{-- “star-{{ $avg }}” will show N filled stars via your CSS --}}
                                                <span class="star-{{ $avg }}"></span>
                                            </div>
                                            <div class="count-star">
                                                ({{ $count }})
                                            </div>
                                        </div>
                                        <div class="price">
                                            @php
                                                $originalPrice = $item->price;
                                                $discount = $item->discount_percentage ?? 0;
                                                $finalPrice =
                                                    $discount > 0
                                                        ? $originalPrice - $originalPrice * ($discount / 100)
                                                        : $originalPrice;
                                            @endphp

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
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="stelina-iconbox-wrapp default">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <div class="stelina-iconbox  default">
                            <div class="iconbox-inner">
                                <div class="icon-item">
                                    <span class="icon flaticon-rocket-ship"></span>
                                </div>
                                <div class="content">
                                    <h4 class="title">
                                        EU Free Delivery
                                    </h4>
                                    <div class="text">
                                        Free Delivery on all order from EU <br />with price more than $90.00
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="stelina-iconbox  default">
                            <div class="iconbox-inner">
                                <div class="icon-item">
                                    <span class="icon flaticon-return"></span>
                                </div>
                                <div class="content">
                                    <h4 class="title">
                                        Money Guarantee
                                    </h4>
                                    <div class="text">
                                        30 Days money back guarantee <br />no question asked!
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="stelina-iconbox  default">
                            <div class="iconbox-inner">
                                <div class="icon-item">
                                    <span class="icon flaticon-padlock"></span>
                                </div>
                                <div class="content">
                                    <h4 class="title">
                                        Online Support 24/7
                                    </h4>
                                    <div class="text">
                                        We’re here to support to you. <br />Let’s shopping now!
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="banner-wrapp">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="banner">
                            <div class="item-banner style4">
                                <div class="inner">
                                    <div class="banner-content">
                                        <h4 class="stelina-subtitle">TOP STAFF PICK</h4>
                                        <h3 class="title">Best Collection</h3>
                                        <div class="description">
                                            Proin interdum magna primis id consequat
                                        </div>
                                        <a href="#" class="button btn-shop-now">Shop now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="banner">
                            <div class="item-banner style5">
                                <div class="inner">
                                    <div class="banner-content">
                                        <h3 class="title">Maybe You’ve <br />Earned it</h3>
                                        <span class="code">
                                            Use code:
                                            <span>
                                                STELINA
                                            </span>
                                            Get 25% Off for all items!
                                        </span>
                                        <a href="#" class="button btn-shop-now">Shop now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="banner-wrapp rows-space-65">
            <div class="container">
                <div class="banner">
                    <div class="item-banner style17">
                        <div class="inner">
                            <div class="banner-content">
                                <h3 class="title">Collection Arrived</h3>
                                <div class="description">
                                    You have no items & Are you <br />ready to use? come & shop with us!
                                </div>
                                <div class="banner-price">
                                    Price from:
                                    <span class="number-price">$45.00</span>
                                </div>
                                <a href="#" class="button btn-shop-now">Shop now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="stelina-tabs  default rows-space-40">
            <div class="container">
                <div class="tab-head">
                    <ul class="tab-link">
                        <li class="active">
                            <a aria-expanded="true">Bestseller</a>
                        </li>

                    </ul>
                </div>
                <div class="stelina-product">
                    <ul class="row list-products auto-clear equal-container product-grid">
                        <ul class="products-list row">
                            @foreach ($allproducts as $product)
                                @php
                                    // Compute average rating (rounded to nearest whole star)
                                    $avgRating = $product->reviews_count
                                        ? round($product->reviews_avg_rating ?? $product->reviews()->avg('rating'))
                                        : 0;
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
                                                <a href="{{ route('product.show', $product->id) }}">
                                                    <img src="{{ asset('storage/' . $product->image) }}" alt="img">
                                                </a>
                                                <div class="thumb-group">

                                                    <div class="loop-form-add-to-cart">
                                                        <button class="single_add_to_cart_button button"
                                                            onclick="addToCart({{ $product->id }})"">Add to cart
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" product-info">
                                            <h5 class="product-name product_title">
                                                <a
                                                    href="{{ route('product.show', $product->id) }}">{{ $product->name }}</a>
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
                                                        {{-- “star-{{ $avg }}” will show N filled stars via your CSS --}}
                                                        <span class="star-{{ $avg }}"></span>
                                                    </div>
                                                    <div class="count-star">
                                                        ({{ $count }})
                                                    </div>
                                                </div>
                                                <div class="price">
                                                    @php
                                                        $originalPrice = $product->price;
                                                        $discount = $product->discount_percentage ?? 0;
                                                        $finalPrice =
                                                            $discount > 0
                                                                ? $originalPrice - $originalPrice * ($discount / 100)
                                                                : $originalPrice;
                                                    @endphp

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


                    </ul>


                </div>

            </div>
        </div>


    </div>
@endsection
