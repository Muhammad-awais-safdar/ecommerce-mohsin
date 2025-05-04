{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Receipt</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            height: 80px;
        }

        h1 {
            color: #333;
            font-size: 24px;
        }

        .order-details {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .order-details h2 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .order-details table {
            width: 100%;
            border-collapse: collapse;
        }

        .order-details table th,
        .order-details table td {
            text-align: left;
            padding: 10px;
            border: 1px solid #e2e2e2;
        }

        .order-details table th {
            background-color: #f4f4f9;
        }

        .button {
            display: inline-block;
            background-color: #007BFF;
            color: #fff;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 5px;
            font-size: 16px;
            text-align: center;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            color: #777;
        }

        .footer p {
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Top Trends UK">
        </div>

        <h1>🛒 Order Placed Successfully!</h1>

        <p>Hi <strong>{{ $order->customer_name }}</strong>,</p>
        <p>Thank you for shopping with <strong>Top Trends UK</strong>. We've received your order and will process it
            shortly!</p>

        <div class="order-details">
            <h2>📋 Order Details</h2>
            <table>
                <tr>
                    <th>Order ID</th>
                    <td>#{{ $order->id }}</td>
                </tr>
                <tr>
                    <th>Order Date</th>
                    <td>{{ $order->created_at->format('d M Y, h:i A') }}</td>
                </tr>
                <tr>
                    <th>Payment Status</th>
                    <td>Paid</td>
                </tr>
                <tr>
                    <th>Total Amount</th>
                    <td><strong>£{{ number_format($order->total_amount, 2) }}</strong></td>
                </tr>
            </table>
        </div>

        <div class="order-details">
            <h2>👤 Customer Information</h2>
            <p><strong>Name:</strong> {{ $order->customer_name }}</p>
            <p><strong>Email:</strong> {{ $order->customer_email }}</p>
            <p><strong>Phone:</strong> {{ $order->customer_phone }}</p>
        </div>

        <a href="{{ url('/user/orders') }}" class="button">📦 View My Orders</a>

        <div class="footer">
            <p>If you have any questions, feel free to reply to this email. We are here to help you 24/7!</p>
            <p>Thanks again for choosing <strong>Top Trends UK</strong>!</p>
            <p>Happy Shopping! 🎉</p>
        </div>
    </div>
</body>

</html> --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Receipt</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            height: 80px;
        }

        h1 {
            color: #333;
            font-size: 24px;
        }

        .order-details,
        .order-items {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .order-details h2,
        .order-items h2 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .order-details table,
        .order-items table {
            width: 100%;
            border-collapse: collapse;
        }

        .order-details table th,
        .order-details table td,
        .order-items table th,
        .order-items table td {
            text-align: left;
            padding: 10px;
            border: 1px solid #e2e2e2;
        }

        .order-details table th,
        .order-items table th {
            background-color: #f4f4f9;
        }

        .button {
            display: inline-block;
            background-color: #007BFF;
            color: #fff;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 5px;
            font-size: 16px;
            text-align: center;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            color: #777;
        }

        .footer p {
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Top Trends UK">
        </div>

        <h1>🛒 Order Placed Successfully!</h1>

        <p>Hi <strong>{{ $order->customer_name }}</strong>,</p>
        <p>Thank you for shopping with <strong>Top Trends UK</strong>. We've received your order and will process it
            shortly!</p>

        <div class="order-details">
            <h2>📋 Order Details</h2>
            <table>
                <tr>
                    <th>Order ID</th>
                    <td>#{{ $order->id }}</td>
                </tr>
                <tr>
                    <th>Order Date</th>
                    <td>{{ $order->created_at->format('d M Y, h:i A') }}</td>
                </tr>
                <tr>
                    <th>Payment Status</th>
                    <td>Paid</td>
                </tr>
                <tr>
                    <th>Total Amount</th>
                    <td><strong>£{{ number_format($order->total_amount, 2) }}</strong></td>
                </tr>
            </table>
        </div>

        <div class="order-items">
            <h2>🛍️ Order Items</h2>
            <table>
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderItems as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>£{{ number_format($item->price, 2) }}</td>
                            <td>£{{ number_format($item->quantity * $item->price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="order-details">
            <h2>👤 Customer Information</h2>
            <p><strong>Name:</strong> {{ $order->customer_name }}</p>
            <p><strong>Email:</strong> {{ $order->customer_email }}</p>
            <p><strong>Phone:</strong> {{ $order->customer_phone }}</p>
        </div>

        <a href="{{ url('/user/orders') }}" class="button">📦 View My Orders</a>

        <div class="footer">
            <p>If you have any questions, feel free to reply to this email. We are here to help you 24/7!</p>
            <p>Thanks again for choosing <strong>Top Trends UK</strong>!</p>
            <p>Happy Shopping! 🎉</p>
        </div>
    </div>
</body>

</html>
