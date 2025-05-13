@component('mail::message')
# Offer Status Updated

Dear {{ $offer->name }},

Your offer for **{{ $offer->product->name }}** has been **{{ ucfirst($offer->status) }}**.

- Quantity: {{ $offer->quantity }}
- Offered Price: ${{ $offer->offer_price }}

Thank you for your interest!

Thanks,<br>
{{ config('app.name') }}
@endcomponent