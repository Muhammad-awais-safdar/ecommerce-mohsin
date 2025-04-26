@extends('Ecommerce.layouts.app')

@section('content')
    <div class="payment-success-container">
        <div class="payment-summary">
            <div class="end-checkout-wrapp">
                <div class="end-checkout checkout-form">
                    <div class="icon">
                    </div>
                    <h3 class="title-checkend">
                        Congratulation! Your order has been processed.
                    </h3>
                    <div class="sub-title">
                        Aenean dui mi, tempus non volutpat eget, molestie a orci.
                        Nullam eget sem et eros laoreet rutrum.
                        Quisque sem ante, feugiat quis lorem in.
                    </div>
                    {{-- <a href="#" class="button btn-return">Return to Store</a> --}}
                </div>
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
                            <span class="product-name">{{ $item->product->name ?? 'N/A' }}</span>
                            <!-- Check if product exists -->
                            <span class="quantity">({{ $item->quantity }}x)</span>
                            = <span class="item-total">${{ number_format($item->product->price ?? 0, 2) }}</span>
                            <!-- Check if price exists -->
                        </li>
                    @endforeach
                </ul>

                <div class="order-total">
                    <span class="total-label">Total Paid:</span>
                    <span class="total-price">${{ number_format($order->total_amount, 2) }}</span>
                </div>

                <div class="order-status">
                    <span class="status-label">Order Status:</span>
                    <span class="status-paid">Paid</span>
                </div>
            </div>

            <div class="payment-actions">
                <a href="{{ url('/') }}" class="button btn-return">Continue Shopping</a>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .payment-success-container {
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
            color: #f3c746;
            /* Gold color from your website */
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
            color: #f3c746;
            /* Gold color from your website */
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
            color: #1a9d28;
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

        .status-paid {
            color: #28a745;
            endpush
            /* Green for success */
        }

        .payment-actions {
            margin-top: 30px;
            text-align: center;
        }

        .continue-shopping-btn {
            background-color: #f3c746;
            /* Gold color */
            color: #fff;
            padding: 12px 25px;
            border-radius: 5px;
            font-size: 18px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s;
        }

        .continue-shopping-btn:hover {
            background-color: #d1a33d;
            /* Slightly darker gold */
        }
    </style>
@endpush