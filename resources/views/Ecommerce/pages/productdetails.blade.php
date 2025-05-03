@extends('Ecommerce.layouts.app')
@push('seo')
    <title>{{ $product->name }}</title>
    <meta name="description" content="  {!! $product->description !!}">
    <link rel="canonical" href="{{ url()->current() }}" />

    <!-- OpenGraph -->
    <meta property="og:title" content="{{ $product->name }}">
    <meta property="og:description" content="  {!! $product->description !!}">
    @if ($product->image)
        <meta property="og:image" content="{{ asset('storage/' . $product->image) }}">
    @endif

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $product->name }}">
    <meta name="twitter:description" content="  {!! $product->description !!}">
    @if ($product->image)
        <meta name="twitter:image" content="{{ asset('storage/' . $product->image) }}">
    @endif
@endpush
@section('content')
    <div class="main-content main-content-details single no-sidebar">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-trail breadcrumbs">
                        <ul class="trail-items breadcrumb">
                            <li class="trail-item trail-begin">
                                <a href="{{ route('home') }}">Home</a>
                            </li>

                            <li class="trail-item trail-end active">
                                {{ $product->name }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="content-area content-details full-width col-lg-9 col-md-8 col-sm-12 col-xs-12">
                    <div class="site-main">
                        <div class="details-product">
                            <div class="details-thumd">
                                <div class="image-preview-container image-thick-box image_preview_container">
                                    <img id="img_zoom" data-zoom-image="{{ asset($product->image) }}"
                                        src="{{ asset('storage/' . $product->image) }}" alt="img">
                                    <a href="{{ asset('storage/' . $product->image) }}" class="btn-zoom open_qv"><i
                                            class="fa fa-search" aria-hidden="true"></i></a>
                                </div>
                                {{-- <div class="product-preview image-small product_preview">
                                    <img src="{{ asset($product->image) }}" alt="img">
                                </div> --}}
                            </div>
                            <div class="details-infor">
                                <h1 class="product-title">
                                    {{ $product->name }}
                                </h1>
                                <div class="stars-rating">
                                    <div class="star-rating">
                                        <span class="star-5"></span>
                                    </div>
                                    <div class="count-star">
                                        (7)
                                    </div>
                                </div>
                                <div class="availability">
                                    availability:
                                    <a href="#">in Stock</a>
                                </div>
                                <div class="price">
                                    @php
                                        $originalPrice = $product->price;
                                        $discount = $product->discount_percentage ?? 0;
                                        $finalPrice =
                                            $discount > 0
                                                ? $originalPrice - $originalPrice * ($discount / 100)
                                                : $originalPrice;
                                    @endphp

                                    @if ($discount > 0)
                                        <del class="badge">${{ number_format($originalPrice, 2) }}</del>
                                        <ins>${{ number_format($finalPrice, 2) }}</ins>
                                    @else
                                        <ins>${{ number_format($originalPrice, 2) }}</ins>
                                    @endif
                                </div>


                                <div class="group-button">

                                    <div class="quantity-add-to-cart">
                                        <div class="quantity">
                                            <div class="control">
                                                <a class="btn-number qtyminus quantity-minus" href="#">-</a>
                                                <input type="text" data-step="1" data-min="0" value="1"
                                                    title="Qty" class="input-qty qty" size="4">
                                                <a href="#" class="btn-number qtyplus quantity-plus">+</a>
                                            </div>
                                        </div>
                                        <button class="single_add_to_cart_button button"
                                            onclick="addToCart({{ $product->id }})">Add to cart</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-details-product">
                            <ul class="tab-link">
                                <li class="active">
                                    <a data-toggle="tab" aria-expanded="true" href="#product-descriptions">Descriptions
                                    </a>
                                </li>

                                <li class="">
                                    <a data-toggle="tab" aria-expanded="true" href="#reviews">Reviews</a>
                                </li>
                            </ul>
                            <div class="tab-container">
                                <div id="product-descriptions" class="tab-panel active">
                                    {!! $product->description !!}
                                </div>

                                <div id="reviews" class="tab-panel">
                                    <div class="reviews-tab">
                                        <div class="comments">
                                            <h2 class="reviews-title">
                                                1 review for
                                                <span>{{ $product->name }}/span>
                                            </h2>
                                            <ol class="commentlist">
                                                @forelse($product->reviews as $review)
                                                    <li class="conment">
                                                        <div class="conment-container">
                                                            <a href="#" class="avatar">
                                                                <img src="{{ asset('assets/images/avartar.png') }}"
                                                                    alt="Avatar">
                                                            </a>
                                                            <div class="comment-text">
                                                                <div class="stars-rating">
                                                                    <div class="star-rating">
                                                                        {{-- star-{rating} gives you the proper filled stars via your CSS --}}
                                                                        <span class="star-{{ $review->rating }}"></span>
                                                                    </div>
                                                                    <div class="count-star">
                                                                        ({{ $review->rating }})
                                                                    </div>
                                                                </div>
                                                                <p class="meta">
                                                                    <strong
                                                                        class="author">{{ $review->user_name }}</strong>
                                                                    <span>-</span>
                                                                    <span
                                                                        class="time">{{ $review->created_at->format('F j, Y') }}</span>
                                                                </p>
                                                                <div class="description">
                                                                    <p>{{ $review->comment }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @empty
                                                    <li class="conment">
                                                        <div class="conment-container">
                                                            <div class="comment-text">
                                                                <p>No reviews yet for this product.</p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforelse
                                            </ol>

                                        </div>
                                        <div class="review_form_wrapper">
                                            <div class="review_form">
                                                <div class="comment-respond">
                                                    <span class="comment-reply-title">Add a review</span>
                                                    <form id="reviewForm">
                                                        @csrf
                                                        <input type="hidden" name="product_id"
                                                            value="{{ $product->id }}">
                                                        <input type="hidden" name="rating" id="rating"
                                                            value="0">

                                                        <p class="comment-notes">
                                                            <span class="email-notes">Your email address will not be
                                                                published.</span>
                                                            Required fields are marked <span class="required">*</span>
                                                        </p>

                                                        <div class="comment-form-rating">
                                                            <label>Your rating</label>
                                                            <p class="stars">
                                                                <span>
                                                                    @for ($i = 1; $i <= 5; $i++)
                                                                        <a href="#" class="star"
                                                                            data-value="{{ $i }}">★</a>
                                                                    @endfor
                                                                </span>
                                                            </p>
                                                        </div>

                                                        <p class="comment-form-comment">
                                                            <label>Your review <span class="required">*</span></label>
                                                            <textarea name="comment" id="comment" cols="45" rows="8" required></textarea>
                                                        </p>

                                                        <p class="comment-form-author">
                                                            <label>Name <span class="required">*</span></label>
                                                            <input name="author" id="author" type="text" required>
                                                        </p>

                                                        <p class="comment-form-email">
                                                            <label>Email <span class="required">*</span></label>
                                                            <input name="email" id="email" type="email" required>
                                                        </p>

                                                        <p class="form-submit">
                                                            <input type="submit" id="submit" class="submit"
                                                                value="Submit">
                                                        </p>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="clear: left;"></div>
                        <div class="related products product-grid">
                            <h2 class="product-grid-title">You may also like</h2>
                            <div class="owl-products owl-slick equal-container nav-center"
                                data-slick='{"autoplay":true, "autoplaySpeed":1000, "arrows":false, "dots":false, "infinite":true, "speed":800, "rows":1}'
                                data-responsive='[{"breakpoint":"2000","settings":{"slidesToShow":4}},{"breakpoint":"1200","settings":{"slidesToShow":3}},{"breakpoint":"992","settings":{"slidesToShow":2}},{"breakpoint":"480","settings":{"slidesToShow":1}}]'>
                                @foreach ($allproducts as $item)
                                    <div class="product-item style-5">
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
                                                        <img src="{{ asset(path: 'storage/' . $item->image) }}"
                                                            alt="img">
                                                    </a>
                                                    <div class="thumb-group">

                                                        {{-- <a href="#" class="button quick-wiew-button">Quick View</a> --}}
                                                        <div class="loop-form-add-to-cart">
                                                            <button class="single_add_to_cart_button button"
                                                                onclick="addToCart({{ $item->id }})">Add to cart
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="product-count-down">
                                                    <div class="stelina-countdown" data-y="2021" data-m="10"
                                                        data-w="4" data-d="10" data-h="20" data-i="20"
                                                        data-s="60"></div>
                                                </div>
                                            </div>
                                            <div class="product-info">
                                                <h5 class="product-name product_title">
                                                    <a
                                                        href="{{ route('product.show', $item->id) }}">{{ $item->name }}</a>
                                                </h5>
                                                <div class="group-info">
                                                    @php
                                                        // Make sure $product->reviews is loaded
                                                        $count = $item->reviews->count();
                                                        $avg = $count
                                                            ? round($item->reviews->avg('rating')) // round to nearest integer
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
                                                        @php
                                                            $originalPrice = $item->price;
                                                            $discount = $item->discount_percentage ?? 0;
                                                            $finalPrice =
                                                                $discount > 0
                                                                    ? $originalPrice -
                                                                        $originalPrice * ($discount / 100)
                                                                    : $originalPrice;
                                                        @endphp

                                                        @if ($discount > 0)
                                                            <del>${{ number_format($originalPrice, 2) }}</del>
                                                            <ins>${{ number_format($finalPrice, 2) }}</ins>
                                                        @else
                                                            <ins>${{ number_format($originalPrice, 2) }}</ins>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
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
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(function() {
            // STAR CLICK HANDLER
            $('.star').on('click', function(e) {
                e.preventDefault();
                const val = $(this).data('value');
                $('#rating').val(val);
                // highlight stars up to selected
                $('.star').each(function() {
                    $(this).toggleClass('selected', $(this).data('value') <= val);
                });
            });

            // FORM SUBMIT VIA AJAX
            $('#reviewForm').submit(function(e) {
                e.preventDefault();
                let data = $(this).serialize();

                $.ajax({
                    url: "{{ route('reviews.store') }}",
                    method: 'POST',
                    data: data,
                    success: function(res) {
                        // reset form
                        $('#reviewForm')[0].reset();
                        $('.star').removeClass('selected');

                        // prepend the new comment to the list
                        let r = res.review;
                        let html = `
<li class="conment">
  <div class="conment-container">
    <a href="#" class="avatar">
      <img src="{{ asset('assets/images/avartar.png') }}" alt="Avatar">
    </a>
    <div class="comment-text">
      <div class="stars-rating">
        <div class="star-rating">
          <span class="star-${r.rating}"></span>
        </div>
        <div class="count-star">(${r.rating})</div>
      </div>
      <p class="meta">
        <strong class="author">${r.user_name}</strong>
        <span>-</span>
        <span class="time">${r.created_at}</span>
      </p>
      <div class="description">
        <p>${r.comment}</p>
      </div>
    </div>
  </div>
</li>`;
                        $('#commentList').prepend(html);

                        Swal.fire({
                            icon: 'success',
                            title: 'Thank you!',
                            text: res.message
                        });
                    },
                    error: function(xhr) {
                        let errs = xhr.responseJSON.errors;
                        let msg = [];
                        $.each(errs, (k, v) => msg.push(v[0]));
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            html: msg.join('<br>')
                        });
                    }
                });
            });
        });
    </script>
@endpush
