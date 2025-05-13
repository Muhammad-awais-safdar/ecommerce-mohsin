@extends('Ecommerce.layouts.app')
@section('content')
    <div class="site-content">
        <main class="site-main main-container no-sidebar">
            <div class="container">
                <div class="breadcrumb-trail breadcrumbs">
                    <ul class="trail-items breadcrumb">
                        <li class="trail-item trail-begin"><a href="{{ route('home') }}"><span>Home</span></a></li>
                        <li class="trail-item trail-end active"><span>Shopping Cart</span></li>
                    </ul>
                </div>

                <div class="row">
                    <div class="main-content-cart main-content col-sm-12">
                        <h3 class="custom_blog_title">Shopping Cart</h3>

                        <div class="page-main-content">
                            <div class="shoppingcart-content">
                                <form action="#" class="cart-form">
                                    <table class="shop_table">
                                        <thead>
                                            <tr>
                                                <th class="product-remove"></th>
                                                <th class="product-thumbnail"></th>
                                                <th class="product-name">Product</th>
                                                <th class="product-price">Price</th>
                                                <th class="product-quantity">Quantity</th>
                                                <th class="product-subtotal">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $subtotal = 0; @endphp
                                            @foreach ($cart as $id => $item)
                                                @php
                                                    $itemTotal = $item['price'] * $item['quantity'];
                                                    $subtotal += $itemTotal;
                                                @endphp
                                                <tr class="cart_item" data-id="{{ $id }}">
                                                    <td class="product-thumbnail">
                                                        <a href="#">
                                                            <img src="{{ asset('storage/' . ($item['image'] ?? 'default.jpg')) }}"
                                                                alt="img"
                                                                class="attachment-shop_thumbnail size-shop_thumbnail wp-post-image">
                                                        </a>
                                                    </td>
                                                    <td class="product-name" data-title="Product">
                                                        <a href="#" class="title">{{ $item['name'] }}</a>
                                                    </td>
                                                    <td class="product-price" data-title="Price">
                                                        {{-- £{{ number_format($item['price'], 2) }} --}}

                                                        @if ($item['discount'] && $item['discount'] > 0 )
                                                            <del>£{{ number_format($item['original_price'], 2) }}</del>
                                                            <span>£{{ number_format($item['price'], 2) }}</span>
                                                        @else
                                                            <span>£{{ number_format($item['price'], 2) }}</span>
                                                        @endif
                                                    </td>
                                                    <td class="product-quantity" data-title="Quantity">
                                                        <div class="quantity">
                                                            <div class="control">
                                                                <a class="btn-number qtyminus" href="javascript:void(0);"
                                                                    data-id="{{ $id }}">-</a>
                                                                <input type="text" data-step="1" data-min="1"
                                                                    value="{{ $item['quantity'] }}" title="Qty"
                                                                    class="input-qty qty" size="4"
                                                                    data-id="{{ $id }}">
                                                                <a href="javascript:void(0);" class="btn-number qtyplus"
                                                                    data-id="{{ $id }}">+</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="product-price item-total" data-id="{{ $id }}">
                                                        £{{ number_format($itemTotal, 2) }}
                                                    </td>
                                                    <td class="product-remove">
                                                        <a href="javascript:void(0);" class="remove remove-from-cart"
                                                            data-id="{{ $id }}"></a>
                                                    </td>
                                                </tr>
                                            @endforeach

                                            <tr>
                                                <td colspan="6" class="actions">
                                                    <div class="coupon"></div>
                                                    <div class="order-total">
                                                        <span class="title">Total Price:</span>
                                                        <span class="total-price"
                                                            id="cart-subtotal">£{{ number_format($subtotal, 2) }}</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </form>

                                <div class="control-cart mt-4">
                                    <a href="{{ route('shop') }}" class="button btn-continue-shopping">Continue
                                        Shopping</a>
                                    <a href="{{ route('checkout') }}" class="button btn-cart-to-checkout">Checkout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection

{{-- deleteitem --}}
@push('scripts')
    <script>
        $(document).ready(function() {
            $('.remove-from-cart').on('click', function(e) {
                e.preventDefault();
                var itemId = $(this).data('id'); // Get the item ID from the data attribute

                // Send AJAX request to the removeItem method in the controller
                $.ajax({
                    url: '/cart/remove/' + itemId, // Make sure the URL matches your route
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // Include CSRF token
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#cart-count').text(response.cart_count);
                            // Remove the item from the table
                            $('tr[data-id="' + itemId + '"]').remove();

                        } else {
                            alert('Error removing item.');
                        }
                    },
                    error: function() {
                        alert('Error removing item.');
                    }
                });
            });
        });
    </script>
@endpush

{{-- updateitem --}}
@push('scripts')
    <script>
        $(document).ready(function() {
            function updateCartAjax(id, quantity) {
                $.ajax({
                    url: '/cart/update/' + id,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        quantity: quantity
                    },
                    success: function(res) {
                        if (res.success) {
                            // Update item total
                            $('.item-total[data-id="' + id + '"]').text(res.item_total);
                            // Update subtotal
                            $('#cart-subtotal').text(res.subtotal);
                        } else {
                            alert('Could not update cart.');
                        }
                    },
                    error: function() {
                        alert('Error updating cart.');
                    }
                });
            }

            // Unbind first to avoid multiple bindings
            $(document).off('click', '.qtyplus').on('click', '.qtyplus', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                let input = $('.qty[data-id="' + id + '"]');
                let currentVal = parseInt(input.val());
                if (!isNaN(currentVal)) {
                    let newVal = currentVal + 1;
                    input.val(newVal);
                    updateCartAjax(id, newVal);
                }
            });

            $(document).off('click', '.qtyminus').on('click', '.qtyminus', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                let input = $('.qty[data-id="' + id + '"]');
                let currentVal = parseInt(input.val());
                if (!isNaN(currentVal) && currentVal > 1) {
                    let newVal = currentVal - 1;
                    input.val(newVal);
                    updateCartAjax(id, newVal);
                }
            });
        });
    </script>
@endpush
