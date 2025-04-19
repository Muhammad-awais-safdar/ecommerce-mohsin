<div class="p-6 space-y-4">
    <h2 class="text-xl font-bold">Order Info</h2>
    <p><strong>Name:</strong> {{ $order->customer_name }}</p>
    <p><strong>Phone:</strong> {{ $order->customer_phone }}</p>
    <p><strong>Address:</strong> {{ $order->shipping_address }}</p>
    <p><strong>Status:</strong> {{ $order->status }}</p>
    <p><strong>Total Amount:</strong> ${{ $order->total_amount }}</p>

    <h3 class="mt-6 text-lg font-semibold">Order Items</h3>
    <table class="w-full mt-2 text-left border">
        <thead>
            <tr>
                <th class="p-2 border">Product</th>
                <th class="p-2 border">Quantity</th>
                <th class="p-2 border">Price</th>
                <th class="p-2 border">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orderItems as $item)
            <tr>
                <td class="p-2 border">{{ $item->product->name ?? 'N/A' }}</td>
                <td class="p-2 border">{{ $item->quantity }}</td>
                <td class="p-2 border">${{ $item->price }}</td>
                <td class="p-2 border">${{ $item->quantity * $item->price }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>