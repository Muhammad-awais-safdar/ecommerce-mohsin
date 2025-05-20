<h2>Tracking Information</h2>
<p><strong>Order ID:</strong> {{ $order->id }}</p>
<p><strong>Status:</strong> {{ ucfirst($order->tracking_status) }}</p>
<p><strong>Tracking Number:</strong> {{ $order->tracking_number }}</p>
<p><strong>Customer:</strong> {{ $order->customer_name }}</p>
<p><strong>Shipping Address:</strong> {{ $order->shipping_address }}</p>
