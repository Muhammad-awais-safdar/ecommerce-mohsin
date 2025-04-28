@component('mail::message')
    {{-- Logo and Thank You Heading --}}
    <div style="text-align: center; margin-bottom: 20px;">
        <img src="{{ asset('assets/images/logo.png') }}" alt="Top Trends UK" style="height: 80px; margin-bottom: 10px;">
        <h1 style="color: #4CAF50; font-size: 26px; margin-top: 0;">Thank you, {{ $contact->name }}!</h1>
    </div>

    ---

    ## 🙏 We Have Received Your Message

    <p style="font-size: 16px; color: #555;">
        Thank you for reaching out to us at <strong>Top Trends UK</strong>.<br>
        Our team has received your message and will get back to you as soon as possible.
    </p>

    ---

    @component('mail::button', ['url' => url('/')])
        🌐 Visit Top Trends UK
    @endcomponent

    Thanks again,<br>
    **Top Trends UK Team**
@endcomponent
