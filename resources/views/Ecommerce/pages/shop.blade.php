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

                        <ul class="row list-products auto-clear equal-container product-grid">
                            @foreach ($products as $product)
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
                                                <a href="{{ route('product.show', $product->id) }}">{{ $product->name }}</a>
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
                                                    <del>
                                                        @php
                                                            $price = $product->price;
                                                            $price = number_format($price, 2);
                                                            $unorderedprice = $price + rand(10, 100);
                                                        @endphp
                                                        ${{ $unorderedprice }}
                                                    </del>
                                                    <ins>
                                                        ${{ $price }}
                                                    </ins>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach


                        </ul>
                        {{ $products->links('vendor.pagination.default') }}

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
