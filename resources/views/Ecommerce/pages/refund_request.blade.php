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
                    </div>
                @endif
            </h3>
            <div class="checkout-wrapp">
                <div class="shipping-address-form checkout-form">
                    <form method="POST" action="{{ route('refund.request.store') }}" id="refundForm">
                        @csrf
                        <div class="row-col-1 row-col">
                            <div class="refund-request">
                                <h3 class="title-form">Refund Request</h3>

                                <p class="form-row form-row-first">
                                    <label class="text">Order ID</label>
                                    <input type="text" class="input-text" name="order_id" id="order_id"
                                        placeholder="Order ID" required>
                                    <span class="error" id="order_id_error"></span>
                                </p>

                                <p class="form-row form-row-first">
                                    <label class="text">Your Email</label>
                                    <input type="email" class="input-text" name="customer_email" id="customer_email"
                                        placeholder="Your Email" required>
                                    <span class="error" id="customer_email_error"></span>
                                </p>

                                <p class="form-row form-row-last">
                                    <label class="text">Your Phone</label>
                                    <input type="text" class="input-text" name="customer_phone" id="customer_phone"
                                        placeholder="Your Phone" required>
                                    <span class="error" id="customer_phone_error"></span>
                                </p>

                                <p class="form-row">
                                    <label class="text">Reason for Refund</label>
                                    <textarea name="reason" id="reason" class="input-text" placeholder="Reason for refund" required></textarea>
                                    <span class="error" id="reason_error"></span>
                                </p>

                                <p class="form-row">
                                    <button type="submit" class="button">Submit Refund Request</button>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#refundForm').on('submit', function(e) {
                    e.preventDefault();

                    // Clear previous error messages
                    $('.error').text('');

                    var formData = $(this).serialize();

                    $.ajax({
                        url: $(this).attr('action'),
                        type: 'POST',
                        data: formData,
                        success: function(response) {
                            if (response.success) {
                                alert('Refund request submitted successfully!');
                                window.location.href = '/';
                            } else {
                                alert('Failed to submit refund request. Please try again.');
                                // alert(response);
                            }
                        },
                        error: function(xhr) {
                            // Display backend validation errors
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                // Display error below the corresponding field
                                $('#' + key + '_error').text(value).css('color', 'red');
                            });
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
