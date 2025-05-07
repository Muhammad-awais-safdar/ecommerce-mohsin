@extends('Ecommerce.layouts.app')
@section('content')
    <div class="main-content main-content-contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-trail breadcrumbs">
                        <ul class="trail-items breadcrumb">
                            <li class="trail-item trail-begin">
                                <a href="{{ route('home') }}">Home</a>
                            </li>
                            <li class="trail-item trail-end active">
                                Contact us
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="content-area content-contact col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="site-main">
                        <h3 class="custom_blog_title">Contact us</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-main-content">
            <div class="google-map">
                <iframe width="100%" height="500" id="gmap_canvas"
                    src="https://maps.google.com/maps?q=university%20of%20san%20francisco&amp;t=&amp;z=13&amp;ie=UTF8&amp;iwloc=&amp;output=embed"
                    frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-contact">
                            <div class="col-lg-8 no-padding">
                                <div class="form-message">
                                    <h2 class="title">
                                        Send us a Message!
                                    </h2>
                                    <form id="contactForm" class="stelina-contact-fom">
                                        @csrf
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p>
                                                    <span class="form-label">Your Name *</span>
                                                    <span class="form-control-wrap your-name">
                                                        <input type="text" name="your-name"
                                                            class="form-control form-control-name" required>
                                                    </span>
                                                </p>
                                            </div>
                                            <div class="col-sm-6">
                                                <p>
                                                    <span class="form-label">Your Email *</span>
                                                    <span class="form-control-wrap your-email">
                                                        <input type="email" name="your-email"
                                                            class="form-control form-control-email" required>
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p>
                                                    <span class="form-label">Phone</span>
                                                    <span class="form-control-wrap your-phone">
                                                        <input type="text" name="your-phone"
                                                            class="form-control form-control-phone">
                                                    </span>
                                                </p>
                                            </div>
                                            <div class="col-sm-6">
                                                <p>
                                                    <span class="form-label">Company</span>
                                                    <span class="form-control-wrap your-company">
                                                        <input type="text" name="your-company"
                                                            class="form-control your-company">
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                        <p>
                                            <span class="form-label">Your Message</span>
                                            <span class="wpcf7-form-control-wrap your-message">
                                                <textarea name="your-message" cols="40" rows="9" class="form-control your-textarea" required></textarea>
                                            </span>
                                        </p>
                                        <p>

                                            <button type="submit" class="form-control-submit button-submit">
                                                <span class="btn-text">SEND MESSAGE</span>
                                                <span class="btn-spinner" style="display:none;">
                                                    <i class="fa fa-spinner fa-spin"></i> Sending...
                                                </span>
                                            </button>
                                        </p>
                                    </form>

                                    <!-- Add a div to show errors or success message -->
                                    <div id="form-messages"></div>

                                </div>
                            </div>
                            <div class="col-lg-4 no-padding">
                                <div class="form-contact-information">
                                    <form action="#" class="stelina-contact-info">
                                        <h2 class="title">
                                            Contact information
                                        </h2>
                                        <div class="info">
                                            <div class="item address">
                                                <span class="icon">

                                                </span>
                                                <span class="text">
                                                    124 City Road, London EC1V 2NX
                                                </span>
                                            </div>
                                            <div class="item phone">
                                                <span class="icon">

                                                </span>
                                                <span class="text">

                                                    + 44 7577 305729
                                                </span>
                                            </div>
                                            <div class="item email">
                                                <span class="icon">

                                                </span>
                                                <span class="text">

                                                    contact@toptrendsuk.store
                                                </span>
                                            </div>
                                        </div>
                                        <div class="socials">
                                            <a href="#" class="social-item" target="_blank">
                                                <span class="icon fa fa-facebook">

                                                </span>
                                            </a>
                                            <a href="#" class="social-item" target="_blank">
                                                <span class="icon fa fa-twitter-square">

                                                </span>
                                            </a>
                                            <a href="#" class="social-item" target="_blank">
                                                <span class="icon fa fa-instagram">

                                                </span>
                                            </a>
                                        </div>
                                    </form>
                                </div>
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
    <script>
        $('#contactForm').submit(function(e) {
            e.preventDefault();

            let form = $(this);
            let submitBtn = form.find('.form-control-submit');
            let btnText = submitBtn.find('.btn-text');
            let btnSpinner = submitBtn.find('.btn-spinner');

            // Disable and show spinner
            submitBtn.prop('disabled', true);
            btnText.hide();
            btnSpinner.show();

            let formData = form.serialize();

            $.ajax({
                type: 'POST',
                url: "{{ route('contact.submit') }}",
                data: formData,
                success: function(response) {
                    form[0].reset();

                    Swal.fire({
                        icon: 'success',
                        title: 'Thank you!',
                        text: response.message,
                        confirmButtonText: 'OK'
                    });
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    let errorHtml = Object.values(errors).flat().join('<br>');

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        html: errorHtml,
                        confirmButtonText: 'Fix it'
                    });
                },
                complete: function() {
                    // Reset button state
                    submitBtn.prop('disabled', false);
                    btnText.show();
                    btnSpinner.hide();
                }
            });
        });
    </script>
@endpush
