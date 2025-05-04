@extends('Ecommerce.layouts.app')
@section('content')
    <div class="main-content main-content-about">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-trail breadcrumbs">
                        <ul class="trail-items breadcrumb">
                            <li class="trail-item trail-begin">
                                <a href="{{ route('home') }}">Home</a>
                            </li>
                            <li class="trail-item trail-end active">
                                About Us
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="content-area content-about col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="site-main">
                        <h3 class="custom_blog_title">About Us</h3>
                        <div class="page-main-content">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-4" style="background: url({{ asset('assets/images/item-instagram-1.jpg') }}) center/cover no-repeat content-box;">
                                    
                                    </div>
                                    <div class="col-md-8">
                                        <section class="bg-white py-12 px-6 md:px-12 lg:px-24 text-gray-800">
                                            <div class="max-w-5xl mx-auto">
                                                <h2 class="text-4xl font-bold mb-6 text-gray-900">Welcome to Top Trends UK
                                                </h2>

                                                <p class="text-lg leading-relaxed mb-4">
                                                    At <strong>Top Trends UK</strong>, we bring you closer to the world’s
                                                    finest fragrances with a promise of authenticity,
                                                    elegance, and trust. As official resellers of <strong>100% original
                                                        luxury branded perfumes</strong>, we’ve earned our
                                                    reputation across major platforms like <em>eBay, Amazon, Walmart</em>,
                                                    and <em>OnBuy</em> by delivering only the best in
                                                    quality and customer experience.
                                                </p>

                                                <p class="text-lg leading-relaxed mb-4">
                                                    Our journey began with a passion for premium scents and a mission to
                                                    make luxury fragrances more
                                                    accessible to scent lovers across the UK. Now, with the launch of our
                                                    dedicated online store, shopping
                                                    your favourite designer perfumes is easier than ever—directly from a
                                                    name you can trust.
                                                </p>

                                                <p class="text-lg leading-relaxed mb-6">
                                                    Whether you're seeking timeless classics or modern masterpieces, each
                                                    product we offer is carefully
                                                    curated to meet the highest standards of authenticity and excellence.
                                                </p>

                                                <div class="bg-gray-100 p-6 rounded-xl mb-6">
                                                    <h3 class="text-2xl font-semibold text-gray-900 mb-4">Why Shop with Us?
                                                    </h3>
                                                    <ul class="space-y-3 text-lg list-disc pl-6">
                                                        <li>💎 <strong>100% Original Luxury Perfumes</strong></li>
                                                        <li>🚚 <strong>Free UK Delivery on All Orders</strong></li>
                                                        <li>🔄 <strong>Easy 1-Click Refund Process Within 24 Hours</strong>
                                                        </li>
                                                        <li>🛒 <strong>Trusted by Thousands Across Major
                                                                Marketplaces</strong></li>
                                                        <li>🕒 <strong>24/7 Customer Support for a Seamless
                                                                Experience</strong></li>
                                                    </ul>
                                                </div>

                                                <p class="text-lg font-medium mb-8">
                                                    <em>Top Trends UK</em> is more than just a store—it's your destination
                                                    for luxury, confidence, and timeless
                                                    fragrance.
                                                </p>

                                                <a href="#shop"
                                                    class="inline-block bg-black text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-gray-800 transition">
                                                    SHOP NOW
                                                </a>
                                            </div>
                                        </section>

                                    </div>
                                </div>
                            </div>
                            <div class="header-banner banner-image">
                                <div class="banner-wrap">
                                    <div class="banner-header">
                                        <div class="col-lg-5 col-md-offset-7">
                                            <div class="content-inner">
                                                <h2 class="title">
                                                    New Collection <br /> for you
                                                </h2>
                                                <div class="sub-title">
                                                    Shop the latest products right <br />
                                                    We have beard supplies from top brands.
                                                </div>
                                                <a href="#" class="stelina-button button">Shop now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-4 col-sm-4">
                                    <div class="stelina-iconbox  layout1">
                                        <div class="iconbox-inner">
                                            <div class="icon-item">
                                                <span class="placeholder-text">01</span>
                                                <span class="icon flaticon-rocket-ship"></span>
                                            </div>
                                            <div class="content">
                                                <h4 class="title">
                                                    COMPLIMENTARY UK DELIVERY
                                                </h4>
                                                <div class="text">
                                                    We offer <strong>free delivery</strong> across the UK on every order.
                                                    Seamless service—because luxury should arrive effortlessly. </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-4 col-lg-offset-1">
                                    <div class="stelina-iconbox  layout1">
                                        <div class="iconbox-inner">
                                            <div class="icon-item">
                                                <span class="placeholder-text">02</span>
                                                <span class="icon flaticon-return"></span>
                                            </div>
                                            <div class="content">
                                                <h4 class="title">
                                                    7-DAY REFUND POLICY </h4>
                                                <div class="text">
                                                    Changed your mind? <strong>Apply for a refund within 7 days</strong> of
                                                    delivery.
                                                    Hassle-free and customer-first.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-4 col-lg-offset-1">
                                    <div class="stelina-iconbox  layout1">
                                        <div class="iconbox-inner">
                                            <div class="icon-item">
                                                <span class="placeholder-text">03</span>
                                                <span class="icon flaticon-padlock"></span>
                                            </div>
                                            <div class="content">
                                                <h4 class="title">
                                                    DEDICATED SUPPORT 24/7 </h4>
                                                <div class="text">
                                                    Our expert team is available 24/7 to assist you.
                                                    Premium support—whenever you need it
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
