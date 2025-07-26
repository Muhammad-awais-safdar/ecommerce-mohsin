@extends('Ecommerce.layouts.app')
@push('seo')
<title>{{ $product->name }}</title>
<meta name="description" content="  {!! $product->description !!}">
<link rel="canonical" href="{{ url()->current() }}" />

<!-- OpenGraph -->
<meta property="og:title" content="{{ $product->name }}">
<meta property="og:description" content="  {!! $product->description !!}">
@if ($product->image)
<meta property="og:image" content="{{ asset('storage/' . $product->image) }}">
@endif

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $product->name }}">
<meta name="twitter:description" content="  {!! $product->description !!}">
@if ($product->image)
<meta name="twitter:image" content="{{ asset('storage/' . $product->image) }}">
@endif
<style>
    /* Custom Modal Styles */
    .custom-modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 35;
        /* Sit on top */
        left: 0;
        top: 0;
        width: 100%;
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgba(0, 0, 0, 0.4);
        /* Background color */
        animation: fadeIn 0.4s ease-in-out;
    }

    /* Modal Content */
    .custom-modal-content {
        background-color: #fff;
        margin: 10% auto;
        /* 15% from top, centered */
        padding: 20px;
        border-radius: 8px;
        width: 80%;
        max-width: 600px;
        animation: slideIn 0.5s ease-out;
    }

    /* Close Button */
    .close-modal {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        transition: color 0.2s ease-in-out;
    }

    .close-modal:hover,
    .close-modal:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }

    /* Form Inputs */
    .modal-input {
        margin-bottom: 15px;
    }

    .modal-input label {
        display: block;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .modal-input input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 16px;
        outline: none;
        transition: border 0.3s ease;
    }

    .modal-input input:focus {
        border: 1px solid #3498db;
    }

    /* Submit Button */
    .submit-offer-btn {
        background-color: #3498db;
        color: white;
        border: none;
        padding: 12px 20px;
        font-size: 16px;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .submit-offer-btn:hover {
        background-color: #2980b9;
    }

    /* Modal Animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes slideIn {
        from {
            transform: translateY(-50px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    /* If using custom CSS instead of utility classes */
    [class^="star-"]::before {
        content: "★★★★★";
        letter-spacing: 3px;
        background: linear-gradient(90deg, #facc15 var(--rating, 0%), #e5e7eb var(--rating, 0%));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .star-1 {
        --rating: 20%;
    }

    .star-2 {
        --rating: 40%;
    }

    .star-3 {
        --rating: 60%;
    }

    .star-4 {
        --rating: 80%;
    }

    .star-5 {
        --rating: 100%;
    }

    @keyframes flicker {
        0% { opacity: 0.8; transform: scale(1); }
        50% { opacity: 1; transform: scale(1.05); }
        100% { opacity: 0.9; transform: scale(1); }
    }

</style>
@endpush
@section('content')
<div class="main-content main-content-details single no-sidebar">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-trail breadcrumbs">
                    <ul class="trail-items breadcrumb">
                        <li class="trail-item trail-begin">
                            <a href="{{ route('home') }}">Home</a>
                        </li>

                        <li class="trail-item trail-end active">
                            {{ $product->name }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="content-area content-details full-width col-lg-9 col-md-8 col-sm-12 col-xs-12">
                <div class="site-main">
                    <div class="details-product">
                        <div class="details-thumd">
                            <div class="image-preview-container image-thick-box image_preview_container">
                                <img id="img_zoom" data-zoom-image="{{ asset('storage/' . $product->images[0]) }}" src="{{ asset('storage/' . $product->images[0]) }}"loading="lazy" alt="img">
                                <a href="{{ asset('storage/' . $product->images[0]) }}" class="btn-zoom open_qv">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </a>
                            </div>

                            <div class="product-preview image-small product_preview">
                                <div id="thumbnails" class="thumbnails_carousel owl-carousel" data-nav="true" data-autoplay="true" data-dots="false" data-loop="true" data-margin="10" data-responsive='{"0":{"items":3},"480":{"items":3},"600":{"items":3},"1000":{"items":3}}'>

                                    @foreach($product->images as $key => $image)
                                    <a href="#" data-image="{{ asset('storage/' . $image) }}" data-zoom-image="{{ asset('storage/' . $image) }}" class="{{ $key === 0 ? 'active' : '' }}">
                                        <img src="{{ asset('storage/' . $image) }}" data-large-image="{{ asset('storage/' . $image) }}"loading="lazy" alt="img">
                                    </a>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                        <div class="details-infor">
                            <h1 class="product-title">
                                {{ $product->name }}
                            </h1>
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

                            <div class="product-meta" style="margin-bottom: 20px;">
                                <div class="meta-item" style="margin-bottom: 8px;">
                                    <strong>SKU:</strong> <span style="color: #666;">{{ $product->sku }}</span>
                                </div>
                                <div class="meta-item" style="margin-bottom: 8px;">
                                    <strong>Availability:</strong>
                                    @if($product->available_stock > 0)
                                        <span class="text-success">{{ $product->available_stock }} in Stock</span>
                                    @else
                                        <span class="text-danger">Out of Stock</span>
                                    @endif
                                </div>
                                @if($product->details)
                                    @if($product->details->gender)
                                    <div class="meta-item" style="margin-bottom: 8px;">
                                        <strong>For:</strong> <span style="color: #666;">{{ ucfirst($product->details->gender) }}</span>
                                    </div>
                                    @endif
                                    @if($product->details->concentration)
                                    <div class="meta-item" style="margin-bottom: 8px;">
                                        <strong>Type:</strong> <span style="color: #666;">{{ $product->details->concentration }}</span>
                                    </div>
                                    @endif
                                    @if($product->details->volume_ml)
                                    <div class="meta-item" style="margin-bottom: 8px;">
                                        <strong>Size:</strong> <span style="color: #666;">{{ $product->details->volume_ml }}ml</span>
                                    </div>
                                    @endif
                                @endif
                            </div>
                            
                            @if($product->available_stock > 0)
                            <div class="sales-tracking" style="margin: 15px 0; padding: 10px 15px; background: linear-gradient(135deg, #fff3cd 0%, #fff8dc 100%); border-radius: 8px; border-left: 4px solid #ffc107; font-size: 14px; color: #856404; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                <i class="fa fa-fire" style="color: #ff6b35; margin-right: 8px; animation: flicker 1.5s infinite alternate;"></i>
                                <strong>{{ $product->random_sales_message }}</strong>
                            </div>
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
                                <del class="badge">£{{ number_format($originalPrice, 2) }}</del>
                                <ins>£{{ number_format($finalPrice, 2) }}</ins>
                                @else
                                <ins>£{{ number_format($originalPrice, 2) }}</ins>
                                @endif
                            </div>


                            <div class="group-button">
                                <div class="d-flex flex-wrap gap-5">
                                    @if($product->available_stock > 0)
                                        <button class="btn-stelina-outline add-to-cart-btn" data-id="{{ $product->id }}" data-name="{{ $product->name }}" data-price="{{ $finalPrice }}" onclick="addToCart({{ $product->id }})">
                                            <span>Add to cart</span>
                                        </button>

                                        <form method="POST" action="{{ route('buy.now') }}">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <button type="submit" class="btn-stelina-primary button">
                                                Buy Now
                                            </button>
                                        </form>

                                        <button onclick="openModal()" class="btn-stelina-primary button">
                                            Make an Offer
                                        </button>
                                    @else
                                        <button class="btn-stelina-outline" disabled style="background: #ccc; cursor: not-allowed;">
                                            <span>Out of Stock</span>
                                        </button>
                                        
                                        <button onclick="openModal()" class="btn-stelina-primary button">
                                            Make an Offer
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Make an Offer Modal -->
                    <div id="offerModal" class="custom-modal">
                        <div class="custom-modal-content">
                            <span class="close-modal">&times;</span>
                            <h2>Make an Offer</h2>
                            <form method="POST" action="{{ route('make.offer') }}">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">

                                <div class="modal-input">
                                    <label for="name">Your Name</label>
                                    <input type="text" id="name" name="name" required>
                                </div>
                                <div class="modal-input">
                                    <label for="email">Your Email</label>
                                    <input type="email" id="email" name="email" required>
                                </div>
                                <div class="modal-input">
                                    <label for="phone">Your Phone</label>
                                    <input type="text" id="phone" name="phone" required>
                                </div>
                                <div class="modal-input">
                                    <label for="offer_price">Your Offer Price</label>
                                    <input type="number" id="offer_price" name="offer_price" min="1" required>
                                </div>
                                <div class="modal-input">
                                    <label for="quantity">Quantity</label>
                                    <input type="number" id="quantity" name="quantity" min="1" value="1" required>
                                </div>

                                <button type="submit" class="submit-offer-btn">Submit Offer</button>
                            </form>
                        </div>
                    </div>
                    <div class="tab-details-product">
                        <ul class="tab-link">
                            <li class="active">
                                <a data-toggle="tab" aria-expanded="true" href="#product-descriptions">Descriptions
                                </a>
                            </li>

                            <li class="">
                                <a data-toggle="tab" aria-expanded="true" href="#reviews">Reviews</a>
                            </li>
                        </ul>
                        <div class="tab-container">
                            <div id="product-descriptions" class="tab-panel active">
                                @if($product->details && $product->details->short_description)
                                    <div class="short-description" style="margin-bottom: 20px; padding: 15px; background: #f8f9fa; border-radius: 8px;">
                                        <h4 style="margin-bottom: 10px; color: #333;">Product Overview</h4>
                                        <p style="line-height: 1.6; color: #666;">{{ $product->details->short_description }}</p>
                                    </div>
                                @endif

                                @if($product->description)
                                    <div class="main-description" style="margin-bottom: 25px;">
                                        <h4 style="margin-bottom: 15px; color: #333;">Description</h4>
                                        <div style="line-height: 1.7; color: #555;">
                                            {!! $product->description !!}
                                        </div>
                                    </div>
                                @endif

                                @if($product->details && $product->details->long_description)
                                    <div class="detailed-description" style="margin-bottom: 25px;">
                                        <h4 style="margin-bottom: 15px; color: #333;">Detailed Information</h4>
                                        <div style="line-height: 1.7; color: #555;">
                                            {!! nl2br(e($product->details->long_description)) !!}
                                        </div>
                                    </div>
                                @endif

                                @if($product->details)
                                    <div class="product-specifications" style="margin-top: 30px;">
                                        <h4 style="margin-bottom: 20px; color: #333; border-bottom: 2px solid #ddd; padding-bottom: 10px;">Product Specifications</h4>
                                        
                                        <div class="spec-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
                                            <div class="spec-column">
                                                @if($product->details->gender)
                                                <div class="spec-item" style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #eee;">
                                                    <strong style="color: #333;">Target Gender:</strong>
                                                    <span style="color: #666;">{{ ucfirst($product->details->gender) }}</span>
                                                </div>
                                                @endif
                                                
                                                @if($product->details->fragrance_type)
                                                <div class="spec-item" style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #eee;">
                                                    <strong style="color: #333;">Fragrance Type:</strong>
                                                    <span style="color: #666;">{{ ucwords($product->details->fragrance_type) }}</span>
                                                </div>
                                                @endif
                                                
                                                @if($product->details->concentration)
                                                <div class="spec-item" style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #eee;">
                                                    <strong style="color: #333;">Concentration:</strong>
                                                    <span style="color: #666;">{{ $product->details->concentration }}</span>
                                                </div>
                                                @endif
                                                
                                                @if($product->details->volume_ml)
                                                <div class="spec-item" style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #eee;">
                                                    <strong style="color: #333;">Volume:</strong>
                                                    <span style="color: #666;">{{ $product->details->volume_ml }} ml</span>
                                                </div>
                                                @endif
                                            </div>
                                            
                                            <div class="spec-column">
                                                @if($product->details->longevity_hours)
                                                <div class="spec-item" style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #eee;">
                                                    <strong style="color: #333;">Longevity:</strong>
                                                    <span style="color: #666;">{{ $product->details->longevity_hours }} hours</span>
                                                </div>
                                                @endif
                                                
                                                @if($product->details->country_of_origin)
                                                <div class="spec-item" style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #eee;">
                                                    <strong style="color: #333;">Country of Origin:</strong>
                                                    <span style="color: #666;">{{ $product->details->country_of_origin }}</span>
                                                </div>
                                                @endif
                                                
                                                <div class="spec-item" style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #eee;">
                                                    <strong style="color: #333;">SKU:</strong>
                                                    <span style="color: #666;">{{ $product->sku }}</span>
                                                </div>
                                                
                                                @if($product->total_sales > 0)
                                                <div class="spec-item" style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #eee;">
                                                    <strong style="color: #333;">Total Sold:</strong>
                                                    <span style="color: #28a745; font-weight: 600;">{{ number_format($product->total_sales) }} units</span>
                                                </div>
                                                @endif
                                            </div>
                                        </div>

                                        @if($product->details->top_notes || $product->details->middle_notes || $product->details->base_notes)
                                        <div class="fragrance-notes" style="margin-top: 25px;">
                                            <h5 style="margin-bottom: 15px; color: #333;">Fragrance Notes</h5>
                                            <div class="notes-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                                                @if($product->details->top_notes)
                                                <div class="note-card" style="padding: 15px; background: #f0f8ff; border-radius: 8px; border-left: 4px solid #007bff;">
                                                    <h6 style="margin-bottom: 8px; color: #007bff; font-size: 14px; font-weight: 600;">Top Notes</h6>
                                                    <p style="margin: 0; color: #555; font-size: 13px; line-height: 1.4;">{{ $product->details->top_notes }}</p>
                                                </div>
                                                @endif
                                                
                                                @if($product->details->middle_notes)
                                                <div class="note-card" style="padding: 15px; background: #fff0f5; border-radius: 8px; border-left: 4px solid #e91e63;">
                                                    <h6 style="margin-bottom: 8px; color: #e91e63; font-size: 14px; font-weight: 600;">Heart Notes</h6>
                                                    <p style="margin: 0; color: #555; font-size: 13px; line-height: 1.4;">{{ $product->details->middle_notes }}</p>
                                                </div>
                                                @endif
                                                
                                                @if($product->details->base_notes)
                                                <div class="note-card" style="padding: 15px; background: #f0f8f0; border-radius: 8px; border-left: 4px solid #4caf50;">
                                                    <h6 style="margin-bottom: 8px; color: #4caf50; font-size: 14px; font-weight: 600;">Base Notes</h6>
                                                    <p style="margin: 0; color: #555; font-size: 13px; line-height: 1.4;">{{ $product->details->base_notes }}</p>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <div id="reviews" class="tab-panel">
                                <div class="reviews-tab">
                                    <div class="comments">
                                        <h2 class="reviews-title">
                                            1 review for
                                            <span>{{ $product->name }}</span>
                                        </h2>
                                        <ol class="commentlist space-y-6">
                                            @forelse($product->reviews as $review)
                                            <li class="conment">
                                                <div class="conment-container">
                                                    {{-- <a href="#" class="avatar">
                                                        <img src="{{ asset('assets/images/avartar.png') }}"
                                                   loading="lazy" alt="Avatar">
                                                    </a> --}}
                                                    <div class="comment-text">
                                                        <div class="comment-text">
                                                            @php
                                                            $count = $product->reviews->count();
                                                            $avg = $count ? round($product->reviews->avg('rating')) : 0;
                                                            @endphp

                                                            <div class="stars-rating">
                                                                <div class="star-rating">
                                                                    <span class="star-{{ $avg }}"></span> {{-- Expected
                                                                    to be styled via CSS --}}
                                                                </div>

                                                                @if ($count > 0)
                                                                <div class="count-star">
                                                                    ({{ $count }})
                                                                </div>
                                                                @else
                                                                <div class="count-star">
                                                                    (No reviews)
                                                                </div>
                                                                @endif
                                                            </div>
                                                            <p class="meta">
                                                                <strong class="author">{{ $review->user_name }}</strong>
                                                                <span>-</span>
                                                                <span class="time">{{ $review->created_at->format('F j,
                                                                    Y')
                                                                    }}</span>
                                                            </p>
                                                            <div class="description">
                                                                <p>{{ $review->comment }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </li>
                                            @empty
                                            <li class="conment">
                                                <div class="conment-container">
                                                    <div class="comment-text">
                                                        <p>No reviews yet for this product.</p>
                                                    </div>
                                                </div>
                                            </li>
                                            @endforelse
                                        </ol>

                                    </div>
                                    <div class="review_form_wrapper">
                                        <div class="review_form">
                                            <div class="comment-respond">
                                                <span class="comment-reply-title">Add a review</span>
                                                <form id="reviewForm">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                    <input type="hidden" name="rating" id="rating" value="0">

                                                    <p class="comment-notes">
                                                        <span class="email-notes">Your email address will not be
                                                            published.</span>
                                                        Required fields are marked <span class="required">*</span>
                                                    </p>

                                                    <div class="comment-form-rating">
                                                        <label>Your rating</label>
                                                        <p class="stars">
                                                            <span>
                                                                @for ($i = 1; $i <= 5; $i++) <a href="#" class="star" data-value="{{ $i }}">★</a>
                                                                    @endfor
                                                            </span>
                                                        </p>
                                                    </div>

                                                    <p class="comment-form-comment">
                                                        <label>Your review <span class="required">*</span></label>
                                                        <textarea name="comment" id="comment" cols="45" rows="8" required></textarea>
                                                    </p>

                                                    <p class="comment-form-author">
                                                        <label>Name <span class="required">*</span></label>
                                                        <input name="author" id="author" type="text" required>
                                                    </p>

                                                    <p class="comment-form-email">
                                                        <label>Email <span class="required">*</span></label>
                                                        <input name="email" id="email" type="email" required>
                                                    </p>

                                                    <p class="form-submit">
                                                        <input type="submit" id="submit" class="submit" value="Submit">
                                                    </p>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="clear: left;"></div>
                    <div class="related products product-grid">
                        <h2 class="product-grid-title">You may also like</h2>
                        <div class="owl-products owl-slick equal-container nav-center" data-slick='{"autoplay":true, "autoplaySpeed":1000, "arrows":false, "dots":false, "infinite":true, "speed":800, "rows":1}' data-responsive='[{"breakpoint":"2000","settings":{"slidesToShow":4}},{"breakpoint":"1200","settings":{"slidesToShow":3}},{"breakpoint":"992","settings":{"slidesToShow":2}},{"breakpoint":"480","settings":{"slidesToShow":1}}]'>
                            @foreach ($allproducts as $item)
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
                                                <img src="{{ asset('storage/' . $item->images[0]) }}"loading="lazy" alt="img">
                                            </a>
                                            <div class="thumb-group">

                                                {{-- <a href="#" class="button quick-wiew-button">Quick View</a> --}}
                                                <div class="loop-form-add-to-cart">
                                                    <button class="single_add_to_cart_button button" onclick="addToCart({{ $item->id }})">Add to cart
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
                                                ? $originalPrice -
                                                $originalPrice * ($discount / 100)
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
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(function() {
        // STAR CLICK HANDLER
        $('.star').on('click', function(e) {
            e.preventDefault();
            const val = $(this).data('value');
            $('#rating').val(val);
            // highlight stars up to selected
            $('.star').each(function() {
                $(this).toggleClass('selected', $(this).data('value') <= val);
            });
        });

        // FORM SUBMIT VIA AJAX
        $('#reviewForm').submit(function(e) {
            e.preventDefault();
            let data = $(this).serialize();

            $.ajax({
                url: "{{ route('reviews.store') }}"
                , method: 'POST'
                , data: data
                , success: function(res) {
                    // reset form
                    $('#reviewForm')[0].reset();
                    $('.star').removeClass('selected');

                    // prepend the new comment to the list
                    let r = res.review;
                    let html = `
<li class="conment">
  <div class="conment-container">
    <a href="#" class="avatar">
      <img src="{{ asset('assets/images/avartar.png') }}"loading="lazy" alt="Avatar">
    </a>
    <div class="comment-text">
      <div class="stars-rating">
        <div class="star-rating">
          <span class="star-${r.rating}"></span>
        </div>
        <div class="count-star">(${r.rating})</div>
      </div>
      <p class="meta">
        <strong class="author">${r.user_name}</strong>
        <span>-</span>
        <span class="time">${r.created_at}</span>
      </p>
      <div class="description">
        <p>${r.comment}</p>
      </div>
    </div>
  </div>
</li>`;
                    $('#commentList').prepend(html);

                    Swal.fire({
                        icon: 'success'
                        , title: 'Thank you!'
                        , text: res.message
                    });
                }
                , error: function(xhr) {
                    let errs = xhr.responseJSON.errors;
                    let msg = [];
                    $.each(errs, (k, v) => msg.push(v[0]));
                    Swal.fire({
                        icon: 'error'
                        , title: 'Oops...'
                        , html: msg.join('<br>')
                    });
                }
            });
        });
    });
    // Get modal elements
    // Get the modal and buttons
    const modal = document.getElementById("offerModal");
    const closeModal = document.querySelector(".close-modal");

    // Open the modal when the button is clicked
    function openModal() {
        modal.style.display = "block";
    }

    // Close the modal when the user clicks the close button (×)
    closeModal.onclick = function() {
        modal.style.display = "none";
    }

    // Close the modal when the user clicks anywhere outside the modal
    window.onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    }

</script>
@endpush
@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('.add-to-cart-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                fbq('track', 'AddToCart', {
                    content_ids: [button.dataset.id]
                    , content_name: button.dataset.name
                    , content_type: 'product'
                    , value: button.dataset.price
                    , currency: 'GBP'
                });
            });
        });
    });

</script>
@endpush
