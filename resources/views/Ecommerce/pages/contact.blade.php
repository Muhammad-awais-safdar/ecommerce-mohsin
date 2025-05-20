@extends('Ecommerce.layouts.app')

@section('content')
<div class="main-content main-content-contact">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <nav class="breadcrumb-trail breadcrumbs">
                    <ul class="trail-items breadcrumb">
                        <li class="trail-item trail-begin"><a href="{{ route('home') }}">Home</a></li>
                        <li class="trail-item trail-end active">Contact Us</li>
                    </ul>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="content-area content-contact col-12">
                <div class="site-main">
                    <h3 class="custom_blog_title">Contact Us</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="page-main-content">
        <div class="google-map mb-5">
            <iframe width="100%" height="500"
                src="https://maps.google.com/maps?q=university%20of%20san%20francisco&amp;t=&amp;z=13&amp;ie=UTF8&amp;iwloc=&amp;output=embed"
                frameborder="0"></iframe>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-contact">
                        <div class="col-lg-8">
                            <div class="form-message">
                                <h2 class="title">Send us a Message!</h2>

                                <form id="contactForm" class="stelina-contact-form" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">Your Name *</label>
                                            <input type="text" name="your-name" class="form-control" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Your Email *</label>
                                            <input type="email" name="your-email" class="form-control" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Phone</label>
                                            <input type="text" name="your-phone" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Company</label>
                                            <input type="text" name="your-company" class="form-control">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Your Message *</label>
                                            <textarea name="your-message" rows="6" class="form-control"
                                                required></textarea>
                                        </div>
                                    </div>

                                    <p class="mt-4">
                                        <button type="submit" class="btn-stelina-primary form-control-submit">
                                            <span class="btn-text">SEND MESSAGE</span>
                                            <span class="btn-spinner" style="display:none;">
                                                <i class="fa fa-spinner fa-spin"></i> Sending...
                                            </span>
                                        </button>
                                    </p>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-4 no-padding">
                            <div class="form-contact-information">
                                <form class="stelina-contact-info">
                                    <h2 class="title">Contact information</h2>
                                    <div class="info">
                                        <div class="item address">
                                            <span class="text">124 City Road, London EC1V 2NX</span>
                                        </div>
                                        <div class="item phone">
                                            <span class="text">+ 44 7577 305729</span>
                                        </div>
                                        <div class="item email">
                                            <span class="text">contact@toptrendsuk.store</span>
                                        </div>
                                    </div>
                                    <div class="socials">
                                        <a href="#" class="social-item" target="_blank"><span
                                                class="icon fa fa-facebook"></span></a>
                                        <a href="#" class="social-item" target="_blank"><span
                                                class="icon fa fa-twitter-square"></span></a>
                                        <a href="#" class="social-item" target="_blank"><span
                                                class="icon fa fa-instagram"></span></a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="col-lg-4 no-padding">
                <form class="stelina-contact-info">
                    <div class="form-contact-information">
                        <h2 class="title">Contact Information</h2>
                        <ul class="info list-unstyled">
                            <li><i class="fa fa-map-marker"></i> 124 City Road, London EC1V 2NX</li>
                            <li><i class="fa fa-phone"></i> +44 7577 305729</li>
                            <li><i class="fa fa-envelope"></i> contact@toptrendsuk.store</li>
                        </ul>
                        <div class="socials mt-3">
                            <a href="#" target="_blank"><i class="fa fa-facebook"></i></a>
                            <a href="#" target="_blank"><i class="fa fa-twitter"></i></a>
                            <a href="#" target="_blank"><i class="fa fa-instagram"></i></a>
                        </div>
                    </div>
                </form>
            </div> --}}
        </div>
    </div>
</div>

</div>
@endsection

@push('scripts')
<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.client_key') }}"></script>

<script type="text/javascript">
    $(function () {
        const form = $('#contactForm');
        const submitBtn = form.find('.form-control-submit');
        const btnText = submitBtn.find('.btn-text');
        const btnSpinner = submitBtn.find('.btn-spinner');

        form.on('submit', function (e) {
            e.preventDefault();

            grecaptcha.ready(function () {
                grecaptcha.execute('{{ config("services.recaptcha.client_key") }}', { action: 'contact_form' })
                    .then(function (token) {
                        form.find('input[name="g-recaptcha-response"]').remove();
                        form.prepend('<input type="hidden" name="g-recaptcha-response" value="' + token + '">');

                        submitBtn.prop('disabled', true);
                        btnText.hide();
                        btnSpinner.show();

                        $.ajax({
                            type: 'POST',
                            url: "{{ route('contact.submit') }}",
                            data: form.serialize(),
                            success: function (res) {
                                form[0].reset();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Thank you!',
                                    text: res.message || 'Your message has been sent.',
                                });
                            },
                            error: function (xhr) {
                                const errors = xhr.responseJSON?.errors;
                                let errorMsg = errors
                                    ? Object.values(errors).flat().join('<br>')
                                    : 'Something went wrong. Please try again.';

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    html: errorMsg,
                                });
                            },
                            complete: function () {
                                submitBtn.prop('disabled', false);
                                btnText.show();
                                btnSpinner.hide();
                            }
                        });
                    });
            });
        });
    });
</script>
@endpush
