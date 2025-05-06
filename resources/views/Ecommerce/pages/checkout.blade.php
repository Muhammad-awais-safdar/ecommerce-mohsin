@extends('Ecommerce.layouts.app')
@section('content')
    <div class="main-content main-content-checkout">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-trail breadcrumbs">
                        <ul class="trail-items breadcrumb">
                            <li class="trail-item trail-begin">
                                <a href="{{ route('home') }}">Home</a>
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
            @if ($errors->any())
                {!! implode('', $errors->all('<div>:message</div>')) !!}
            @endif
            <div class="checkout-wrapp">

                <div class="shipping-address-form checkout-form">
                    <form action="{{ route('checkout.store') }}" method="POST">
                        @csrf

                        <div class="shipping-address-form checkout-form">
                            {{-- <p class="form-row">
                                <button type="button" id="use-location" class="button">Use My Location</button>
                            </p> --}}
                            <div class="row-col-1 row-col">
                                <div class="shipping-address">
                                    <h3 class="title-form">Shipping Address (UK)</h3>

                                    <p class="form-row form-row-first">
                                        <label class="text">First Name</label>
                                        <input type="text" class="input-text" name="first_name" required>
                                    </p>
                                    <p class="form-row form-row-last">
                                        <label class="text">Last Name</label>
                                        <input type="text" class="input-text" name="last_name" required>
                                    </p>
                                    <p class="form-row form-row-first">
                                        <label class="text">Email</label>
                                        <input type="email" class="input-text" name="customer_email" required>
                                    </p>
                                    <p class="form-row form-row-last">
                                        <label class="text">Phone Number</label>
                                        <input type="text" class="input-text" name="customer_phone" required>
                                    </p>

                                    <p class="form-row">
                                        <label class="text">Address Line 1</label>
                                        <input type="text" class="input-text" name="address_line1" id="address_line1"
                                            required>
                                    </p>
                                    <p class="form-row">
                                        <label class="text">Address Line 2 <small>(optional)</small></label>
                                        <input type="text" class="input-text" name="address_line2" id="address_line2">
                                    </p>



                                    <p class="form-row form-row-last">
                                        <label class="text">State</label>
                                        <input type="text" class="input-text" name="state" id="state" required>
                                    </p>

                                    <p class="form-row form-row-first">
                                        <label class="text">City</label>
                                        <input type="text" class="input-text" name="city" id="city" required>
                                    </p>
                                    <div class="form-row form-row-first">
                                        <p class="postcode-container">
                                            <label for="postcode" class="text">Postcode</label>
                                            <input type="text" class="input-text" name="postcode" id="postcode" required
                                                pattern="^([A-Z]{1,2}\d[A-Z\d]? ?\d[A-Z]{2})$"
                                                title="Enter a valid UK postcode (e.g., SW1A 1AA)"
                                                aria-describedby="postcode-info">
                                            <span class="arrow-btn" id="check-postcode">
                                                <i class="fa fa-arrow-right"></i>
                                            </span>

                                        </p>
                                    </div>
                                    <p class="form-row form-row-last">
                                        <label class="text">Country</label>
                                        <input type="text" class="input-text" name="country" value="United Kingdom"
                                            readonly>
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
                                                        <h5 class="product-name">{{ $item['name'] ?? 'Unknown Product' }}
                                                        </h5>
                                                        <div class="price">
                                                            £{{ number_format($item['price'], 2) }} x
                                                            {{ $item['quantity'] }}
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>

                                        <div class="order-total">
                                            <span class="title">Total Price:</span>
                                            <span class="total-price">£{{ number_format($subtotal, 2) }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <button type="submit" class="button button-payment">Place Order</button>
                                </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

    @endsection
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            // Check if geolocation is available
            // $('#use-location').on('click', function() {
            //     if (navigator.geolocation) {
            //         navigator.geolocation.getCurrentPosition(
            //             function(position) {
            //                 const latitude = position.coords.latitude;
            //                 const longitude = position.coords.longitude;

            //                 // Call reverse geocoding API to get address from latitude and longitude
            //                 $.ajax({
            //                     url: `https://nominatim.openstreetmap.org/reverse?lat=${latitude}&lon=${longitude}&format=json&addressdetails=1`,
            //                     method: 'GET',
            //                     success: function(response) {
            //                         if (response && response.place_id) {
            //                             console.log(response.place_id);
            //                             const address = response.address;
            //                             $('#address_line1').val(response.display_name);
            //                             $('#city').val(address.city || address.town || '');

            //                             $('#postcode').val(address.postcode || '');
            //                         } else {
            //                             // If no address found
            //                             Swal.fire({
            //                                 icon: 'warning',
            //                                 title: 'Address Not Found',
            //                                 text: 'Could not determine your address. Please check your location settings.',
            //                             });
            //                         }
            //                     },
            //                     error: function() {
            //                         Swal.fire({
            //                             icon: 'error',
            //                             title: 'Error',
            //                             text: 'Unable to fetch address details. Please try again later.',
            //                         });
            //                     }
            //                 });
            //             },
            //             function(error) {
            //                 console.error(error); // Log the full error object for debugging
            //                 let errorMessage = 'Unable to fetch location.';

            //                 // More detailed error handling
            //                 switch (error.code) {
            //                     case error.PERMISSION_DENIED:
            //                         errorMessage =
            //                             'You denied the request for Geolocation. Please allow location access in your browser settings.';
            //                         break;
            //                     case error.POSITION_UNAVAILABLE:
            //                         errorMessage = 'Location information is unavailable. Please try again later.';
            //                         break;
            //                     case error.TIMEOUT:
            //                         errorMessage =
            //                             'The request to get user location timed out. Please try again later.';
            //                         break;
            //                     case error.UNKNOWN_ERROR:
            //                         errorMessage = 'An unknown error occurred while fetching your location.';
            //                         break;
            //                 }

            //                 // Display the error message with more details
            //                 Swal.fire({
            //                     icon: 'error',
            //                     title: 'Geolocation Error',
            //                     text: errorMessage,
            //                 });
            //             }
            //         );
            //     } else {
            //         Swal.fire({
            //             icon: 'error',
            //             title: 'Geolocation Not Supported',
            //             text: 'Your browser does not support geolocation.',
            //         });
            //     }
            // });

            // Check postcode logic as you already have it
            $('#check-postcode').on('click', function() {
                let postcode = $('#postcode').val().trim().toUpperCase();

                const regex = /^([A-Z]{1,2}\d[A-Z\d]?\s?\d[A-Z]{2})$/i;
                if (!regex.test(postcode)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid Postcode',
                        text: 'Please enter a valid UK postcode (e.g., SW1A 1AA)',
                    });
                    return;
                }

                Swal.fire({
                    title: 'Looking up postcode...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: `https://api.postcodes.io/postcodes/${postcode}`,
                    method: 'GET',
                    success: function(response) {
                        Swal.close();
                        if (response.status === 200) {
                            const data = response.result;
                            $('#city').val(data.admin_district);
                            $('#county').val(data.region);
                        } else if (response.status === 404) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Postcode Not Found',
                                text: 'The postcode entered does not exist in our database. Please check and try again.',
                            });
                        } else {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Error',
                                text: 'An unexpected error occurred. Please try again later.',
                            });
                        }
                    },
                    error: function() {
                        Swal.close();
                        Swal.fire({
                            icon: 'error',
                            title: 'Lookup Failed',
                            text: 'Unable to fetch address. Please check your postcode or internet connection.',
                        });
                    }
                });
            });
        </script>
    @endpush
