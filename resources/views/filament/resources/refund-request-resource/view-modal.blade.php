
<div class="space-y-6 p-6 bg-gradient-to-br from-blue-100 via-white to-purple-100 rounded-xl shadow-2xl">
    <div class="bg-white p-5 rounded-lg shadow-md hover:shadow-lg transition">
        <h3 class="text-xl font-bold text-blue-700 mb-3 border-b pb-2">🛒 Order Details</h3>
        <p class="text-gray-700"><strong>Order ID:</strong> {{ $record->order->id ?? 'N/A' }}</p>
        <p class="text-gray-700"><strong>Order Total:</strong> ${{ $record->order->total_amount ?? 'N/A' }}</p>
        <p class="text-gray-700"><strong>Order Date:</strong> {{ $record->order->created_at?->format('d M Y') ?? 'N/A' }}
        </p>
    </div>

    <div class="bg-white p-5 rounded-lg shadow-md hover:shadow-lg transition">
        <h3 class="text-xl font-bold text-green-700 mb-3 border-b pb-2">👤 Customer Details</h3>
        <p class="text-gray-700"><strong>Name:</strong> {{ $record->customer_name }}</p>
        <p class="text-gray-700"><strong>Email:</strong> {{ $record->customer_email }}</p>
        <p class="text-gray-700"><strong>Phone:</strong> {{ $record->customer_phone }}</p>
    </div>

    <div class="bg-white p-5 rounded-lg shadow-md hover:shadow-lg transition">
        <h3 class="text-xl font-bold text-yellow-700 mb-3 border-b pb-2">📝 Refund Reason</h3>
        <p class="text-gray-700">{{ $record->reason }}</p>
    </div>

    <div class="bg-white p-5 rounded-lg shadow-md hover:shadow-lg transition">
        <h3 class="text-xl font-bold text-purple-700 mb-3 border-b pb-2">🔖 Status</h3>
        <p class="text-gray-700">{{ ucfirst($record->status) }}</p>
    </div>

    <!-- New section for displaying order items -->
    <div class="bg-white p-5 rounded-lg shadow-md hover:shadow-lg transition">
        <h3 class="text-xl font-bold text-teal-700 mb-3 border-b pb-2">🛍️ Order Items</h3>
        <div class="space-y-3">
            @forelse($orderItems as $item)
                {{-- {{ dd($item) }} --}}
                <div class="flex justify-between">
                    <p class="text-gray-700">{{ $item->product->name }}</p>
                    <p class="text-gray-700">${{ $item->price }}</p> 
                    <p class="text-gray-700">{{ $item->quantity }}</p> =
                    <p class="text-gray-700">${{ $item->quantity * $item->quantity }}</p>
                </div>
            @empty
                <p class="text-gray-700">No items found for this order.</p>
            @endforelse
        </div>
    </div>
</div>
