<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Order Receipt</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 13px;
            margin: 0;
            padding: 20px;
            color: #000;
        }

        .receipt-container {
            border: 5px solid #f2aa3c;
            padding: 20px;
            width: 100%;
        }

        .header,
        .footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .section {
            margin-top: 15px;
        }

        .line {
            border-bottom: 1px dotted #000;
            margin: 4px 0;
        }

        .box {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 1px solid #000;
            margin-right: 5px;
            text-align: center;
        }

        .footer {
            margin-top: 30px;
        }

        .signature {
            text-align: right;
            font-style: italic;
        }

        .product-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .product-table th,
        .product-table td {
            border: 1px solid #ccc;
            padding: 6px 10px;
            text-align: left;
        }

        .product-table th {
            background-color: #f2aa3c;
        }
    </style>
</head>

<body>
    <div class="receipt-container">
        <div class="header">
            <div><strong>
                    <img src="{{ asset('assets/images/logo.png') }}" class="img-fluid" />
                </strong></div>
            <div>
                <div>Receipt No.: {{ $order->id }}</div>
                <div>Date: {{ $order->created_at->format('d-m-Y') }}</div>
            </div>
        </div>

        <div class="section">
            <div><strong>Customer:</strong> {{ $order->customer_name }}</div>
            <div><strong>Email:</strong> {{ $order->customer_email }}</div>
            <div><strong>Phone:</strong> {{ $order->customer_phone }}</div>
            <div><strong>Shipping Address:</strong> {{ $order->shipping_address }}</div>
        </div>

        <div class="section">
            <table class="product-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderItems as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>Rs. {{ number_format($item->price, 2) }}</td>
                        <td>Rs. {{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3"><strong>Grand Total</strong></td>
                        <td><strong>Rs. {{ number_format($order->total_amount, 2) }}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="section">
            <strong>Payment Status:</strong> {{ ucfirst($order->status) }}<br>
            <strong>Tracking No:</strong> {{ $order->tracking_number ?? 'N/A' }}<br>
            <strong>Service Provider:</strong> {{ $order->tracking_service_provider ?? 'N/A' }}<br>
            <strong>Tracking Status:</strong> {{ ucfirst($order->tracking_status ?? 'pending') }}
        </div>

        <div class="footer">
            <div>
                <small>
                    contact@toptrendsuk.store&nbsp;&nbsp;
                    www.toptrendsuk.store &nbsp;&nbsp;
                    124 City Road, London EC1V 2NX </small>
            </div>
            <div class="signature">
                ___________________________<br>
                Authorized Signature
            </div>
        </div>
    </div>
</body>

</html>
