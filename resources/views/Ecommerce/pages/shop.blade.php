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
                                                                    <a href="#">
                                                                        <img src="{{ asset($product->image) }}" alt="img">
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
                                                                                    <a href="#">{{ $product->name }}</a>
                                                                                </h5>
                                                                                <div class="group-info">
                                                                                    <div class="stars-rating">
                                                                                        <div class="star-rating">
                                                                                            <span class="star-3"></span>
                                                                                        </div>
                                                                                        <div class="count-star">
                                                                                            (3)
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

@push('scripts')
    <script>
        function addToCart(productId) {
            $.ajax({
                url: '/add-to-cart/' + productId,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.status === 'success') {
                        // ✅ Update cart count
                        $('#cart-count').text(response.cart_count);

                        // ✅ Flash message
                        $('.flash-message').html(`
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                ${response.message}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        `);

                        setTimeout(() => {
                            $('.flash-message .alert').alert('close');
                        }, 3000);
                    }
                }
            });
        }
    </script>
@endpush