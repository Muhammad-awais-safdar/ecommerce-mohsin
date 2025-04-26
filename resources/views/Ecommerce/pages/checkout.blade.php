@extends('Ecommerce.layouts.app')
@section('content')
    <div class="main-content main-content-checkout">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-trail breadcrumbs">
                        <ul class="trail-items breadcrumb">
                            <li class="trail-item trail-begin">
                                <a href="index-2.html">Home</a>
                            </li>
                            <li class="trail-item trail-end active">
                                Checkout
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <h3 class="custom_blog_title">
                Checkout
                @if (session('error'))
                    <div class="alert alert-danger">
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                @endif
            </h3>
            <div class="checkout-wrapp">
                <form action="{{ route('checkout.store') }}" method="POST">
                    @csrf
                    <div class="shipping-address-form checkout-form">
                        <div class="row-col-1 row-col">
                            <div class="shipping-address">
                                <h3 class="title-form">Shipping Address</h3>

                                <p class="form-row form-row-first">
                                    <label class="text">First name</label>
                                    <input type="text" class="input-text" name="first_name" required>
                                </p>
                                <p class="form-row form-row-last">
                                    <label class="text">Last name</label>
                                    <input type="text" class="input-text" name="last_name" required>
                                </p>
                                <p class="form-row form-row-first">
                                    <label class="text">Email</label>
                                    <input type="email" class="input-text" name="customer_email" required>
                                </p>

                                <p class="form-row form-row-last">
                                    <label class="text">Phone number</label>
                                    <input type="text" class="input-text" name="customer_phone" required>
                                </p>
                                <p class="form-row form-row-first">
                                    <label class="text">Country</label>
                                    <input type="text" class="input-text" name="country" required>
                                </p>
                                <p class="form-row form-row-last">
                                    <label class="text">States</label>
                                    <input type="text" class="input-text" name="state" required>
                                </p>
                                <p class="form-row form-row-first">
                                    <label class="text">City</label>
                                    <input type="text" class="input-text" name="city" required>
                                </p>
                                <p class="form-row form-row-last">
                                    <label class="text">Zip code</label>
                                    <input type="text" class="input-text" name="zip" required>
                                </p>


                                <p class="form-row">

                                    <label class="text">Address</label>
                                    <input type="text" class="input-text" name="address" required>
                                </p>
                            </div>
                        </div>

                        {{-- Order Summary --}}
                        @if (isset($cart) && count($cart) > 0)
                            <div class="row-col-2 row-col">
                                <div class="your-order">
                                    <h3 class="title-form">Your Order</h3>
                                    <ul class="list-product-order">
                                        @php $subtotal = 0; @endphp
                                        @foreach ($cart as $id => $item)
                                            @php
                                                $itemTotal = $item['price'] * $item['quantity'];
                                                $subtotal += $itemTotal;
                                            @endphp
                                            <li class="product-item-order">
                                                <div class="product-thumb">
                                                    <img src="{{ asset('storage/' . ($item['image'] ?? 'default.jpg')) }}"
                                                        alt="Product Image">
                                                </div>
                                                <div class="product-order-inner">
                                                    <h5 class="product-name">{{ $item['name'] ?? 'Unknown Product' }}</h5>
                                                    <div class="price">
                                                        ${{ number_format($item['price'], 2) }} x {{ $item['quantity'] }}
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>

                                    <div class="order-total">
                                        <span class="title">Total Price:</span>
                                        <span class="total-price">${{ number_format($subtotal, 2) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <button type="submit" class="button button-payment">Place Order</button>
                            </div>
                        @endif
                    </div>
            </div>
        </div>
    @endsection
