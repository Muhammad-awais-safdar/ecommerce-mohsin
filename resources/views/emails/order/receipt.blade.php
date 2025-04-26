<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Order Confirmation - {{ config('app.name') }}</title>
</head>

<body style="font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px;">

    <table width="100%"
        style="max-width:600px;margin:auto;background:white;padding:20px;border-radius:10px;box-shadow:0 0 10px rgba(0,0,0,0.1);">
        <tr>
            <td style="text-align: center;">
                <img src="https://yourstore.com/logo.png" alt="{{ config('app.name') }}"
                    style="width:150px;margin-bottom:20px;">
                <h2 style="color: #4CAF50;">Thank you for your order!</h2>
                <p>Hi <strong>{{ $order->customer_name }}</strong>,</p>
                <p>Your order <strong>#{{ $order->id }}</strong> has been successfully placed!</p>
            </td>
        </tr>

        <tr>
            <td style="padding-top:20px;">
                <h3>Shipping Address:</h3>
                <p>{{ $order->shipping_address }}</p>

                <h3 style="margin-top:30px;">Order Summary:</h3>

                <table width="100%" style="border-collapse: collapse; margin-top: 15px;">
                    <thead>
                        <tr style="background: #4CAF50; color: white;">
                            <th style="padding:10px;border:1px solid #ddd;">Product</th>
                            <th style="padding:10px;border:1px solid #ddd;">Qty</th>
                            <th style="padding:10px;border:1px solid #ddd;">Price</th>
                            <th style="padding:10px;border:1px solid #ddd;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $item)
                            <tr>
                                <td style="padding:10px;border:1px solid #ddd;">{{ $item->product->name ?? 'Product' }}</td>
                                <td style="padding:10px;border:1px solid #ddd;">{{ $item->quantity }}</td>
                                <td style="padding:10px;border:1px solid #ddd;">${{ number_format($item->price, 2) }}</td>
                                <td style="padding:10px;border:1px solid #ddd;">
                                    ${{ number_format($item->price * $item->quantity, 2) }}</td>
                            </tr>
                        @endforeach
                        <tr style="background: #f9f9f9;">
                            <td colspan="3" style="padding:10px;text-align:right;font-weight:bold;">Grand Total:</td>
                            <td style="padding:10px;font-weight:bold;">${{ number_format($order->total_amount, 2) }}
                            </td>
                        </tr>
                    </tbody>
                </table>

                <a href="{{ url('/') }}"
                    style="display:inline-block;margin-top:30px;padding:10px 20px;background:#4CAF50;color:white;text-decoration:none;border-radius:5px;">
                    Visit Our Store
                </a>
            </td>
        </tr>

        <tr>
            <td style="padding-top:30px;font-size:12px;color:gray;text-align:center;">
                © {{ date('Y') + 1 }} {{ config('app.name') }}. All rights reserved.
            </td>
        </tr>
    </table>

</body>

</html>