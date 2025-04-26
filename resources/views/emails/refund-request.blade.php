<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refund Request Status</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
            color: #333;
        }

        .email-container {
            width: 100%;
            background-color: #ffffff;
            padding: 30px;
            margin: 0 auto;
            max-width: 650px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            font-size: 28px;
            color: #4CAF50;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
            background-color: #f1f8e9;
            padding: 15px;
            border-radius: 8px;
        }

        .email-content {
            font-size: 16px;
            color: #555;
            line-height: 1.7;
            padding: 20px;
            background-color: #fafafa;
            border-radius: 8px;
        }

        .email-content h3 {
            font-size: 22px;
            color: #f3c746;
            /* Gold color */
            margin-top: 20px;
            margin-bottom: 15px;
            border-bottom: 2px solid #f3c746;
            padding-bottom: 8px;
        }

        .order-details,
        .refund-status {
            margin-top: 20px;
        }

        .order-details p,
        .refund-status p {
            margin: 10px 0;
        }

        .order-details span {
            font-weight: bold;
            color: #333;
        }

        .order-items {
            margin-top: 10px;
            margin-left: 20px;
        }

        .order-items li {
            font-size: 16px;
            margin-bottom: 8px;
            color: #333;
        }

        .refund-status {
            margin-top: 20px;
            background-color: #f8d7da;
            padding: 10px;
            border-radius: 6px;
        }

        .refund-status p {
            font-weight: bold;
            color: #721c24;
        }

        .email-footer {
            margin-top: 30px;
            text-align: center;
            padding: 20px;
            background-color: #f1f8e9;
            border-radius: 8px;
        }

        .email-footer a {
            background-color: #4CAF50;
            color: #fff;
            padding: 12px 25px;
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .email-footer a:hover {
            background-color: #45a049;
            /* Darker green */
        }

        .email-footer p {
            margin-top: 15px;
            font-size: 14px;
            color: #555;
        }

        .highlight {
            color: #f44336;
            /* Red color for emphasis */
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-header">
            Refund Request Status: <span class="highlight">{{ ucfirst($status) }}</span>
        </div>

        <div class="email-content">
            <p>Dear <strong>{{ $order->customer_name }}</strong>,</p>

            <p>We have reviewed your refund request for Order ID: <strong>#{{ $order->id }}</strong> placed on
                <strong>{{ $order->created_at->format('F j, Y') }}</strong>.
            </p>

            <div class="order-details">
                <h3>Refund Request Details:</h3>
                <p><span>Order ID:</span> #{{ $order->id }}</p>
                <p><span>Total Paid:</span> ${{ $order->total }}</p>
                <p><span>Items:</span></p>
                <ul class="order-items">
                    @foreach ($order->orderItems as $item)
                        <li>{{ $item->name }} ({{ $item->quantity }}x) = ${{ $item->price * $item->quantity }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="refund-status">
                <p>Your refund request status is: <strong>{{ ucfirst($status) }}</strong>.</p>

                @if($status == 'approved')
                    <p>You will receive a refund to your original payment method within 7 business days. Thank you for your
                        patience!</p>
                @else
                    <p>Unfortunately, your refund request has been <strong>denied</strong> due to the reasons outlined in
                        our Refund Policy. If you have any questions, feel free to <a
                            href="mailto:{{ env('ADMIN_EMAIL') }}">contact us</a>.</p>
                @endif
            </div>

            <p>Thank you for shopping with us!</p>
        </div>

        <div class="email-footer">
            <a href="{{ route('home') }}">Visit Our Shop</a>
            <p>Need help? <a href="mailto:{{ env('ADMIN_EMAIL') }}">Contact us</a></p>
        </div>

        <p style="text-align: center; font-size: 14px; color: #888;">Thanks,<br>{{ config('app.name') }}</p>
    </div>
</body>

</html>