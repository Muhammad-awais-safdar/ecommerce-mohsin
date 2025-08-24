<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>

    <!-- Google Fonts (Poppins) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        poppins: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            500: '#3B82F6', // blue
                            600: '#2563EB',
                        },
                        success: {
                            600: '#16A34A', // green
                        },
                        warning: {
                            600: '#F59E0B', // orange
                        },
                        danger: {
                            600: '#DC2626', // red
                        }
                    }
                }
            }
        }
    </script>

    <!-- Custom CSS (Optional if needed more custom styles) -->
    <link rel="stylesheet" href="{{ asset('css/order.css') }}">
</head>

<div class="space-y-6 bg-white rounded-lg shadow-lg" style="padding: 2rem;">
    <h2 class="text-2xl font-bold text-primary-600 flex items-center gap-2">
        📦 Order Information
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-2">
            <p class="flex items-center gap-2 text-gray-700">
                🧑 <span class="font-semibold">Name:</span> {{ $order->customer_name }}
            </p>
            <p class="flex items-center gap-2 text-gray-700">
                📞 <span class="font-semibold">Phone:</span> {{ $order->customer_phone }}
            </p>
            <p class="flex items-center gap-2 text-gray-700">
                📧 <span class="font-semibold">Email:</span> {{ $order->customer_email }}
            </p>
        </div>
        <div class="space-y-2">
            <p class="flex items-center gap-2 text-gray-700">
                📍 <span class="font-semibold">Address:</span> {{ $order->shipping_address }}
            </p>
            <p class="flex items-center gap-2 text-gray-700">
                🚚 <span class="font-semibold">Status:</span>
                <span class="inline-flex items-center px-2 py-1 rounded text-white text-sm
                    @if($order->status == 'paid') bg-success-600
                    @elseif($order->status == 'pending') bg-warning-600
                        @else bg-danger-600
                    @endif">
                    {{ ucfirst($order->status) }}
                </span>
            </p>
            <p class="flex items-center gap-2 text-gray-700">
                💵 <span class="font-semibold">Total Amount:</span> ${{ number_format($order->total_amount, 2) }}
            </p>
        </div>
    </div>

    <div>
        <h3 class="text-xl font-semibold mt-8 mb-4 text-primary-500 flex items-center gap-2">
            🛒 Order Items
        </h3>
        <div class="overflow-x-auto rounded-lg shadow-sm">
            <table class="w-full text-sm text-left border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 border">Product</th>
                        <th class="p-3 border">Quantity</th>
                        <th class="p-3 border">Price</th>
                        <th class="p-3 border">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orderItems as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 border">{{ $item->product->name ?? 'N/A' }}</td>
                            <td class="p-3 border">{{ $item->quantity }}</td>
                            <td class="p-3 border">${{ number_format($item->price, 2) }}</td>
                            <td class="p-3 border">${{ number_format($item->quantity * $item->price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>