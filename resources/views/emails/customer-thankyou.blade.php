<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Thank You</title>
</head>

<body style="font-family: 'Segoe UI', sans-serif; background-color: #f5f8fa; padding: 20px; color: #333;">
    <table width="100%" cellpadding="0" cellspacing="0"
        style="max-width: 600px; margin: auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); overflow: hidden;">
        <tr>
            <td style="text-align: center; background-color: #1a73e8; padding: 30px;">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Top Trends UK"
                    style="height: 80px; margin-bottom: 15px;">
                <h1 style="color: #ffffff; margin: 0; font-size: 24px;">🎉 Thank You, {{ $contact->name }}!</h1>
            </td>
        </tr>
        <tr>
            <td style="padding: 30px;">
                <h2 style="color: #1a73e8;">🙏 We've Received Your Message</h2>
                <p style="font-size: 16px; line-height: 1.6;">
                    Thank you for reaching out to <strong>Top Trends UK</strong>.<br>
                    Our team is reviewing your message and will get back to you shortly. We appreciate your interest and
                    value your time.
                </p>

                <h3 style="color: #1a73e8;">💬 What's Next?</h3>
                <ul style="font-size: 16px; line-height: 1.6; padding-left: 20px;">
                    <li>We'll review your message carefully.</li>
                    <li>Expect a reply within 24–48 hours.</li>
                    <li>Need urgent help? Visit our website below.</li>
                </ul>

                <div style="text-align: center; margin-top: 30px;">
                    <a href="{{ url('/') }}"
                        style="background-color: #1a73e8; color: #ffffff; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold;">
                        🌐 Visit Top Trends UK
                    </a>
                </div>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; background-color: #f1f3f4; padding: 20px; font-size: 14px; color: #777;">
                Thanks again,<br>
                <strong>Top Trends UK Team</strong><br>
                <a href="{{ url('/') }}" style="color: #1a73e8;">toptrendsuk.com</a>
            </td>
        </tr>
    </table>
</body>

</html>
