<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>New Contact Submission</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #ffffff; padding: 20px; color: #333;">
    <div
        style="max-width: 600px; margin: auto; border: 1px solid #e0e0e0; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">

        <!-- Header -->
        <div style="text-align: center; background-color: #f9f9f9; padding: 30px 20px;">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Top Trends UK" style="height: 80px;">
            <h1 style="color: #4CAF50; margin: 10px 0 0;">📩 New Contact Submission</h1>
        </div>

        <!-- Contact Details -->
        <div style="padding: 20px;">
            <h2 style="font-size: 20px; margin-bottom: 10px;">🧑 Contact Details</h2>
            <table style="width: 100%; border-collapse: collapse; font-size: 15px;">
                <tr style="background-color: #f7f7f7;">
                    <td style="padding: 10px;"><strong>👤 Name:</strong></td>
                    <td style="padding: 10px;">{{ $contact->name }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px;"><strong>📧 Email:</strong></td>
                    <td style="padding: 10px;">{{ $contact->email }}</td>
                </tr>
                <tr style="background-color: #f7f7f7;">
                    <td style="padding: 10px;"><strong>📞 Phone:</strong></td>
                    <td style="padding: 10px;">{{ $contact->phone }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px;"><strong>🏢 Company:</strong></td>
                    <td style="padding: 10px;">{{ $contact->company }}</td>
                </tr>
            </table>

            <!-- Message -->
            <h2 style="font-size: 20px; margin-top: 30px;">📝 Message</h2>
            <div
                style="background-color: #f1f8e9; padding: 15px; border-left: 5px solid #4CAF50; font-size: 15px; line-height: 1.5;">
                {{ $contact->message }}
            </div>

            <!-- CTA Button -->
            <div style="text-align: center; margin-top: 30px;">
                <a href="{{ url('/') }}"
                    style="background-color: #4CAF50; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-size: 16px;">
                    🌐 Visit Top Trends UK
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div style="background-color: #f9f9f9; text-align: center; padding: 15px; font-size: 13px; color: #777;">
            <p>Thank you,<br><strong>Top Trends UK Team</strong></p>
        </div>
    </div>
</body>

</html>