@extends('Ecommerce.layouts.app')

@section('content')
    <div class="payment-failure-container">
        <div class="payment-summary">
            <div class="payment-header">
                <h2 class="payment-title">Payment Failed!</h2>
                <p class="payment-subtitle">Something went wrong, please try again.</p>
            </div>

            <div class="order-summary">
                <h3>Order Summary</h3>
                <p><strong>Order ID:</strong> #{{ $order->id }}</p>
                <p><strong>Date:</strong> {{ $order->created_at->format('F d, Y') }}</p>
                <p><strong>Name:</strong> {{ $order->customer_name }}</p>
                <p><strong>Phone:</strong> {{ $order->customer_phone }}</p>

                <h4>Items:</h4>
                <ul class="order-items">
                    @foreach ($order->orderItems as $item)
                        <li class="order-item">
                            <span class="product-name">{{ $item->product_name }}</span>
                            <span class="quantity">({{ $item->quantity }}x)</span>
                            = <span class="item-total">£{{ number_format($item->price * $item->quantity, 2) }}</span>
                        </li>
                    @endforeach
                </ul>

                <div class="order-total">
                    <span class="total-label">Total Paid:</span>
                    <span class="total-price">£{{ number_format($order->total_amount, 2) }}</span>
                </div>

                <div class="order-status">
                    <span class="status-label">Order Status:</span>
                    <span class="status-failed">Failed</span>
                </div>
            </div>

            <div class="payment-actions">
                <a href="{{ url('/') }}" class="retry-payment-btn">Try Payment Again</a>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .payment-failure-container {
            background-color: #f4f5f7;
            padding: 30px;
        }

        .payment-summary {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        .payment-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .payment-title {
            font-size: 32px;
            font-weight: 700;
            color: #f44336;
            /* Red color for failure */
        }

        .payment-subtitle {
            font-size: 18px;
            color: #333;
            margin-top: 10px;
        }

        .order-summary {
            margin-top: 20px;
        }

        .order-summary h3 {
            font-size: 24px;
            color: #f44336;
            /* Red color for failure */
            margin-bottom: 15px;
        }

        .order-items {
            list-style: none;
            padding-left: 0;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 16px;
            color: #444;
        }

        .product-name {
            font-weight: 600;
        }

        .quantity {
            font-style: italic;
            color: #777;
        }

        .item-total {
            font-weight: 600;
            color: #d9534f;
            /* Red color for failure */
        }

        .order-total {
            display: flex;
            justify-content: space-between;
            font-size: 18px;
            margin-top: 15px;
            font-weight: bold;
        }

        .order-status {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
            font-size: 16px;
            font-weight: 600;
        }

        .status-label {
            font-weight: 700;
        }

        .status-failed {
            color: #d9534f;
            /* Red color for failure */
        }

        .payment-actions {
            margin-top: 30px;
            text-align: center;
        }

        .retry-payment-btn {
            background-color: #f44336;
            /* Red color */
            color: #fff;
            padding: 12px 25px;
            border-radius: 5px;
            font-size: 18px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s;
        }

        .retry-payment-btn:hover {
            background-color: #c9302c;
            /* Darker red */
        }
    </style>
@endpush


@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        fbq('track', 'InitiateCheckout');
    });
</script>
@endpush