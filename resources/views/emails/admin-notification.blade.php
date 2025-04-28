@component('mail::message')
{{-- Logo and Brand Name --}}
<div style="text-align: center; margin-bottom: 20px;">
    <img src="{{ asset('assets/images/logo.png') }}" alt="Top Trends UK" style="height: 80px; margin-bottom: 10px;">
    <h1 style="color: #4CAF50; font-size: 24px; margin-top: 0;">New Contact Submission</h1>
</div>

---

## 🧑 Contact Details

<table style="width: 100%; border-collapse: collapse; font-size: 16px;">
    <tr style="background-color: #f2f2f2;">
        <td style="padding: 10px;"><strong>Name:</strong></td>
        <td style="padding: 10px;">{{ $contact->name }}</td>
    </tr>
    <tr>
        <td style="padding: 10px;"><strong>Email:</strong></td>
        <td style="padding: 10px;">{{ $contact->email }}</td>
    </tr>
    <tr style="background-color: #f2f2f2;">
        <td style="padding: 10px;"><strong>Phone:</strong></td>
        <td style="padding: 10px;">{{ $contact->phone }}</td>
    </tr>
    <tr>
        <td style="padding: 10px;"><strong>Company:</strong></td>
        <td style="padding: 10px;">{{ $contact->company }}</td>
    </tr>
</table>

---

## 📝 Message

<div style="background-color: #f9f9f9; padding: 15px; border-left: 5px solid #4CAF50; font-size: 16px; margin-top: 10px;">
    {{ $contact->message }}
</div>

---

@component('mail::button', ['url' => url('/')])
🌐 Visit Top Trends UK
@endcomponent

Thanks,<br>
**Top Trends UK**
@endcomponent
