<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/favicon.png') }}" /> --}}
    @php
        $favicon = \App\Models\SiteSetting::first()?->favicon;
    @endphp

    @if ($favicon)
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $favicon) }}">
    @endif
    <link
        href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/chosen.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pe-icon-7-stroke.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/lightbox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/fancybox/source/jquery.fancybox.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery.scrollbar.min.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('assets/css/mobile-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/flaticon/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <!-- SweetAlert2 CSS & JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('seo')


    @if ($seo)

        <title>{{ $seo?->meta_title ?? 'Default Title' }}</title>
        <meta name="description" content="{{ $seo?->meta_description }}">
        <meta name="keywords" content="{{ $seo?->meta_keywords }}">

        <!-- Open Graph -->
        <meta property="og:title" content="{{ $seo?->og_title }}">
        <!-- OG Image -->
        @if ($seo?->og_image)
            <meta property="og:image" content="{{ asset('storage/' . $seo->og_image) }}">
        @endif


        <!-- Canonical & Robots -->
        <link rel="canonical" href="{{ $seo?->canonical_url ?? url()->current() }}">
        <meta name="robots" content="{{ $seo?->robots ?? 'index, follow' }}">

        <!-- Twitter Card -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $seo?->twitter_title ?? $seo?->meta_title }}">

        <!-- Twitter Image -->
        @if ($seo?->twitter_image)
            <meta name="twitter:image" content="{{ asset('storage/' . $seo->twitter_image) }}">
        @endif
    @endif


    <!-- Schema.org JSON-LD -->
    <script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "WebPage",
    "name": "{{ $seo?->meta_title }}",
    "description": "{{ $seo?->meta_description }}",
    "url": "{{ url()->current() }}"
}
</script>

    @stack('styles')
</head>

<body class="home">
    <header class="header style7">
        <div class="top-bar">
            <div class="container" style="overflow-x:hidden">
                <div class="top-bar-left">
                    <div class="header-message">
                       <div class="marquee-wrapper" id="marqueeWrapper">
  <div class="marquee-content" id="marqueeContent">
    Welcome to our online Store: Top Trends UK — Your destination for 100% original luxury
    and branded fragrances. We guarantee authenticity, top-quality service, and an
    exceptional shopping experience. Enjoy free UK delivery, easy returns, and 24/7 customer
    support. Shop with confidence today!
  </div>
</div>
                    </div>
                </div>

            </div>
        </div>
        <div class="container">
            <div class="main-header">
                <div class="row d-flex align-items-center justify-content-center">
                    <div class="col-lg-3 col-sm-4 col-md-3 col-xs-7 col-ts-12 header-element">
                        <div class="logo">
                            <a href="{{ route('home') }}">
                                <img src="{{ asset('assets/images/logo.png') }}" alt="img">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-7 col-sm-8 col-md-6 col-xs-5 col-ts-12">
                        <div class="header-nav-container rows-space-20">
                            <div class="container">
                                <div class="header-nav-wapper main-menu-wapper">

                                    <div class="header-nav">
                                        <div class="container-wapper">
                                            <ul class="stelina-clone-mobile-menu stelina-nav main-menu "
                                                id="menu-main-menu">
                                                <li class="menu-item ">
                                                    <a href="{{ route('home') }}" class="stelina-menu-item-title"
                                                        title="Home">Home</a>
                                                </li>
                                                <li class="menu-item ">
                                                    <a href="{{ route('shop') }}" class="stelina-menu-item-title"
                                                        title="Shop">Shop</a>
                                                </li>
                                                <li class="menu-item">
                                                    <a href="{{ route('about') }}" class="stelina-menu-item-title"
                                                        title="About">About</a>
                                                </li>
                                                <li class="menu-item">
                                                    <a href="{{ route('contact') }}" class="stelina-menu-item-title"
                                                        title="contact Us">Contact</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-12 col-md-3 col-xs-12 col-ts-12">
                        <div class="header-control">
                            <div class="block-minicart block-header">
                                <a href="{{ route('showCart') }}" class="shopcart-icon"
                                    data-stelina="stelina-dropdown">
                                    Cart
                                    <span class="count"
                                        id="cart-count">{{ session('cart') ? array_sum(array_column(session('cart'), 'quantity')) : 0 }}</span>
                                </a>

                            </div>

                            <a class="menu-bar mobile-navigation menu-toggle" href="#">
                                <span></span>
                                <span></span>
                                <span></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </header>
    <div class="header-device-mobile">
        <div class="wapper">
            <div class="item mobile-logo">
                <div class="logo">
                    <a href="#">
                        <img src="assets/images/logo.png" alt="img">
                    </a>
                </div>
            </div>


            <div class="item menu-bar">
                <a class=" mobile-navigation menu-toggle" href="#">
                    <span></span>
                    <span></span>
                    <span></span>
                </a>
            </div>
        </div>
    </div>

    @yield('content')
    <footer class="footer style7">
        <div class="container">
            <div class="container-wapper">
                <div class="row">
                    <div class="box-footer col-xs-12 col-sm-4 col-md-4 col-lg-4 hidden-sm hidden-md hidden-lg">
                        <div class="stelina-newsletter style1">
                            <div class="newsletter-head">
                                <h3 class="title">Newsletter</h3>
                            </div>
                            <div class="newsletter-form-wrap">
                                <div class="list">
                                    Sign up for our free video course and <br /> urban garden inspiration
                                </div>
                                <input type="email" class="input-text email email-newsletter"
                                    placeholder="Your email letter">
                                <button class="button btn-submit submit-newsletter">SUBSCRIBE</button>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="stelina-custommenu default">
                            <h2 class="widgettitle">Quick Menu</h2>
                            <ul class="menu">
                                <li class="menu-item">
                                    <a href="#">New arrivals</a>
                                </li>
                                <li class="menu-item">
                                    <a href="#">Life style</a>
                                </li>
                                <li class="menu-item">
                                    <a href="#">Accents</a>
                                </li>
                                <li class="menu-item">
                                    <a href="#">Tables</a>
                                </li>
                                <li class="menu-item">
                                    <a href="#">Dining</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="box-footer col-xs-12 col-sm-4 col-md-4 col-lg-4 hidden-xs">
                        <div class="stelina-newsletter style1">
                            <div class="newsletter-head">
                                <h3 class="title">Newsletter</h3>
                            </div>
                            <div class="newsletter-form-wrap">
                                <div class="list">
                                    Sign up for our free video series and discover exclusive fragrance tips &
                                    inspiration – crafted for perfume lovers across the UK.
                                </div>
                                <input type="email" class="input-text email email-newsletter"
                                    placeholder="Your email letter">
                                <button class="button btn-submit submit-newsletter">SUBSCRIBE</button>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="stelina-custommenu default">
                            <h2 class="widgettitle">Information</h2>
                            <ul class="menu">
                                @foreach (App\Models\Page::all() as $page)
                                    <li class="menu-item">
                                        <a href="{{ url($page->slug) }}">{{ ucwords(strtolower($page->name)) }}</a>
                                    </li>
                                @endforeach

                                <li class="menu-item">
                                    <a href="{{ route('refund.request.form') }}">Apply Refund</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="footer-end">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <div class="stelina-socials">
                                <ul class="socials">
                                    <li>
                                        <a href="#" class="social-item" target="_blank">
                                            <i class="icon fa fa-facebook"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="social-item" target="_blank">
                                            <i class="icon fa fa-twitter"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="social-item" target="_blank">
                                            <i class="icon fa fa-instagram"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="coppyright">
                                Copyright © @php
                                    echo date('Y');
                                @endphp
                                <a href="{{ route('home') }}">Top Trends UK</a>
                                . All rights reserved
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <div class="footer-device-mobile">
        <div class="wapper">
            <div class="footer-device-mobile-item device-home">
                <a href="{{ route('home') }}">
                    <span class="icon">
                        <i class="fa fa-home" aria-hidden="true"></i>
                    </span>
                    Home
                </a>
            </div>

            <div class="footer-device-mobile-item device-home device-cart">

                <a href="{{ route('showCart') }}">
                    <span class="icon">
                        <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                        <span class="count-icon"
                            id="cart-count">{{ session('cart') ? array_sum(array_column(session('cart'), 'quantity')) : 0 }}</span>
                    </span>
                    <span class="text">Cart</span>
                </a>
            </div>

        </div>
    </div>
    <a href="#" class="backtotop">
        <i class="fa fa-angle-double-up"></i>
    </a>
    <script src="{{ asset('assets/js/jquery-1.12.4.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.plugin-countdown.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-countdown.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/js/isotope.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/mobile-menu.js') }}"></script>
    <script src="{{ asset('assets/js/chosen.min.js') }}"></script>
    <script src="{{ asset('assets/js/slick.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.elevateZoom.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.actual.min.js') }}"></script>
    <script src="{{ asset('assets/js/fancybox/source/jquery.fancybox.js') }}"></script>
    <script src="{{ asset('assets/js/lightbox.min.js') }}"></script>
    <script src="{{ asset('assets/js/owl.thumbs.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/frontend-plugin.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    @stack('scripts')
</body>

</html>
