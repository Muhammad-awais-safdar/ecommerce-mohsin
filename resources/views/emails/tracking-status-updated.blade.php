<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Order Tracking Status Update</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f1f3f8;
            color: #1a1a1a;
        }

        .container {
            max-width: 640px;
            margin: 30px auto;
            background-color: #ffffff;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header img {
            height: 70px;
        }

        .title {
            font-size: 28px;
            font-weight: 700;
            color: #2b2d42;
            margin-top: 10px;
        }

        .subheading {
            font-size: 16px;
            color: #555;
            margin-top: 8px;
        }

        .status-box {
            margin: 30px 0;
            padding: 20px 24px;
            background: linear-gradient(to right, #6a11cb 0%, #2575fc 100%);
            border-radius: 12px;
            color: #fff;
            font-size: 20px;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-align: center;
        }

        .details {
            background-color: #f9fafc;
            padding: 24px;
            border-radius: 10px;
            border: 1px solid #e5eaf1;
            margin-bottom: 24px;
        }

        .details p {
            margin: 8px 0;
            font-size: 16px;
        }

        .details span {
            font-weight: 600;
            color: #333;
        }

        .cta-button {
            display: inline-block;
            padding: 14px 28px;
            font-size: 16px;
            font-weight: 600;
            background: #2575fc;
            color: #fff !important;
            border-radius: 8px;
            text-decoration: none;
            transition: background 0.3s ease;
            margin-top: 16px;
        }

        .cta-button:hover {
            background: #1a5fe0;
            color: #fff !important;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 14px;
            color: #888;
        }

        .footer p {
            margin: 6px 0;
        }

        @media (max-width: 640px) {
            .container {
                padding: 20px;
            }

            .title {
                font-size: 24px;
            }

            .status-box {
                font-size: 18px;
            }

            .cta-button {
                width: 100%;
                text-align: center;
                display: block;

            }
        }
    </style>
</head>

<body>
    <div class="container">

        <div class="header">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Top Trends UK Logo">
            <div class="title">🚚 Order Status Update</div>
            <div class="subheading">Stay informed, always. Here's the latest on your order.</div>
        </div>

        <p>Hello <strong>{{ $order->customer_name }}</strong>,</p>

        <p>We’ve got an update regarding your recent order with us.</p>

        <a href="https://www.royalmail.com/track-your-item" class="status-box">
            Current Status: {{ strtoupper($order->tracking_status) }}
        </a>

        <div class="details">
            <p><span>Tracking Number:</span> {{ $order->tracking_number }}</p>
            <p><span>Order ID:</span> #{{ $order->id }}</p>
            <p><span>Delievry Partner:</span> #{{ $order->tracking_service_provider }}</p>
            <p><span>Order Date:</span> {{ $order->created_at->format('d M Y, h:i A') }}</p>
            <p><span>Total:</span> £{{ number_format($order->total_amount, 2) }}</p>
        </div>

        <a href="https://www.royalmail.com/track-your-item" class=" cta-button">🔍 Track My Order</a>

        <div class="footer">
            <p>Need help? Just reply to this email or reach out to our support team.</p>
            <p>Thank you for shopping with <strong>Top Trends UK</strong> ✨</p>
        </div>

    </div>
</body>

</html>