@extends('Ecommerce.layouts.app')
@push('styles')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.js"
    integrity="sha512-Ysw1DcK1P+uYLqprEAzNQJP+J4hTx4t/3X2nbVwszao8wD+9afLjBQYjz7Uk4ADP+Er++mJoScI42ueGtQOzEA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.css"
    integrity="sha512-rd0qOHVMOcez6pLWPVFIv7EfSdGKLt+eafXh4RO/12Fgr41hDQxfGvoi1Vy55QIVcQEujUE1LQrATCLl2Fs+ag=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    .reviews-section {
        /* background-color: var(--color-background); */
        padding: 80px 0;
        position: relative;
        z-index: 5;
    }

    .reviews-section h2 {
        text-align: center;
        color: var(--color-background);
        font-size: 2rem;
        margin-bottom: 30px;
        font-weight: 700;
        position: relative;
    }

    .review-slider {
        max-width: 700px;
        margin: 0 auto;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.1);
        border: 2px solid var(--color-border);
    }

    .swiper-slide {
        width: auto !important;
        /* Adapt to image width */
        display: inline-block;
        text-align: center;
    }

    .swiper-slide img {
        width: 100%;
        height: auto;
        display: block;
        transition: transform 0.5s ease;
    }

    .swiper-slide:hover img {
        transform: scale(1.02);
    }

    .swiper-pagination-bullet {
        background-color: var(--color-accent-primary);
        opacity: 1;
    }

    .swiper-pagination-bullet-active {
        background-color: var(--color-accent-secondary);
    }
</style>
@endpush
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

                            <div class="slider-item style8">
                                <div class="slider-inner equal-element">
                                    <div class="slider-infor">
                                        <h5 class="title-small">
                                            TAKE A PERFUME <br> TOP TRENDS UK
                                        </h5>
                                        <h3 class="title-big">
                                            Up to 20% Off <br />order now
                                        </h3>
                                        <div class="price">
                                            Save Price:
                                            <span class="number-price">
                                                &#163;99.00
                                            </span>
                                        </div>
                                        <a href="{{ route('shop') }}" class="button btn-shop-product">Shop now</a>
                                    </div>
                                </div>
                            </div>

                            <div class="slider-item style9">
                                <div class="slider-inner equal-element">
                                    <div class="slider-infor">
                                        <h5 class="title-small">
                                            Top Trends Uk <br /> Best Collection
                                        </h5>
                                        <h3 class="title-big">
                                            TAKE A PERFUME <br> TOP TRENDS UK
                                        </h3>
                                        <div class="price">
                                            New Price:
                                            <span class="number-price">
                                                $150.00
                                            </span>
                                        </div>
                                        <a href="{{ route('shop') }}" class="button btn-chekout">Shop now</a>
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
                                        Experience elegance — crafted luxury from £105
                                    </div>
                                    <a href="{{ route('shop') }}" class="button btn-lets-do-it">Shop now</a>
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
                                        Finest luxury perfumes from £99
                                    </div>
                                    <span class="price">now just £89!</span>
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
                data-slick='{"autoplay":true, "autoplaySpeed":3000, "arrows":false, "dots":false, "infinite":true, "speed":3000, "rows":1}'
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
                                <a href="{{ route('product.show', $item->slug) }}">
                                    <img src="{{ asset('storage/' . $item->images[0]) }}" alt="img">
                                </a>
                                <div class="thumb-group">
                                    <div class="loop-form-add-to-cart">
                                        <button class="single_add_to_cart_button button"
                                            onclick="addToCart({{ $item->id }})">Add to cart
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="product-count-down">
                                <div class="stelina-countdown" data-countdown></div>
                            </div>
                        </div>
                        <div class="product-info">
                            <h5 class="product-name product_title">
                                <a href="{{ route('product.show', $item->slug) }}">{{ $item->name }}</a>
                            </h5>
                            <div class="group-info">
                                @php
                                $count = $item->reviews->count();
                                $avg = $count ? round($item->reviews->avg('rating')) : 0;
                                @endphp

                                <div class="stars-rating">
                                    <div class="star-rating">
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
                                    COMPLIMENTARY UK DELIVERY
                                </h4>
                                <div class="text">
                                    We offer <strong>free delivery</strong> across the UK on every order.
                                    Seamless service—because luxury should arrive effortlessly.
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
                                    7-DAY REFUND POLICY
                                </h4>
                                <div class="text">
                                    Changed your mind? <strong>Apply for a refund within 7 days</strong> of delivery.
                                    Hassle-free and customer-first.
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
                                    DEDICATED SUPPORT 24/7
                                </h4>
                                <div class="text">
                                    Our expert team is available 24/7 to assist you.
                                    Premium support—whenever you need it </div>
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
                                    <h4 class="stelina-subtitle">STAFF FAVORITE — TOP TRENDS UK</h4>
                                    <h3 class="title">Curated Best Collection</h3>
                                    <div class="description">
                                        Discover our most loved luxury fragrances, hand-selected for you.
                                        Crafted elegance in every bottle.
                                    </div>
                                    <a href="{{ route('shop') }}" class="button btn-shop-now">Shop now</a>
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
                                    <h3 class="title">SALE — UP TO 20% OFF</h3>
                                    <span class="code">
                                        Enjoy up to 20% off across our entire collection.
                                        Because luxury should feel rewarding.
                                    </span>
                                    <a href="{{ route('shop') }}" class="button btn-shop-now">Shop now</a>
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
                                <span class="number-price">&#163;99.00</span>
                            </div>
                            <a href="{{ route('shop') }}" class="button btn-shop-now">Shop now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="banner-wrapp rows-space-65" style="background-color: var(--color-accent-primary);">
        <div class="container">
            <div class="reviews-section banner-wrapp rows-space-65">
                <div class="container">
                    <h2>What Our eBay Customers Say</h2>
                    <div class="review-slider swiper">
                        <div class="swiper-wrapper">
                            @if (!empty($ebayVerified) && $ebayVerified->isNotEmpty())
                            @foreach ($ebayVerified as $ebay)
                            @if (!empty($ebay->imagePath))
                            <div class="swiper-slide">
                                <img src="{{ asset('storage/' . $ebay->imagePath) }}"
                                    alt="{{ $ebay->imageName ?? 'Ebay Image' }}" class="img-fluid" />
                            </div>
                            @else
                            <div class="swiper-slide">
                                <img src="{{ asset('images/default-placeholder.png') }}" class="img-fluid"
                                    alt="Default Image" />
                            </div>
                            @endif
                            @endforeach
                            @else
                            <div class="swiper-slide">
                                <img src="{{ asset('images/no-items-found.png') }}" class="img-fluid"
                                    alt="No Ebay Items" />
                            </div>
                            @endif
                        </div>
                        <!-- Pagination -->
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="stelina-tabs  default rows-space-40">
        <div class="container">
            <h3 class="custommenu-title-blog">
                Best Seller
            </h3>
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
                                        <a href="{{ route('product.show', $product->slug) }}">
                                            <img src="{{ asset('storage/' . $product->images[0]) }}" alt="img">
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
                                                        <a href="{{ route('product.show', $product->slug) }}">{{
                                                            $product->name }}</a>
                                                    </h5>
                                                    <div class="group-info">
                                                        @php
                                                        $count = $product->reviews->count();
                                                        $avg = $count ? round($product->reviews->avg('rating')) : 0;
                                                        @endphp

                                                        @if ($count > 0)
                                                        <div class="stars-rating">
                                                            <div class="star-rating">

                                                                <span class="star-{{ $avg }}"></span>
                                                            </div>
                                                            <div class="count-star">
                                                                ({{ $count }})
                                                            </div>
                                                        </div>
                                                        @else
                                                        <p>No reviews yet</p>
                                                        @endif


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
@push('scripts')
<script>
    const swiper = new Swiper('.swiper', {
    loop: true,
    autoplay: {
    delay: 1500,
    disableOnInteraction: true,
    },
    pagination: {
    el: '.swiper-pagination',
    clickable: true,
    },
    slidesPerView: 'auto', // Adaptive to content width
    spaceBetween: 20, // Optional: spacing between slides
    });
    // const swiper = new Swiper('.swiper', {
    //         loop: true,
    //         autoplay: {
    //             delay: 1500,
    //             disableOnInteraction: true,
    //         },
    //         pagination: {
    //             el: '.swiper-pagination',
    //             clickable: true,
    //         },
    //         effect: 'fade', // Only use fade if you want single slide at a time
    //         fadeEffect: {
    //             crossFade: true
    //         },
    //         breakpoints: {
    //             0: {
    //                 slidesPerView: 1,
    //                 spaceBetween: 10
    //             },
    //             768: {
    //                 slidesPerView: 2,
    //                 spaceBetween: 20
    //             },
    //             1024: {
    //                 slidesPerView: 3,
    //                 spaceBetween: 30
    //             }
    //         }
    //     });
</script>

@endpush