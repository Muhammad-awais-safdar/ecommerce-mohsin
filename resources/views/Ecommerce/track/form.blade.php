@extends('Ecommerce.layouts.app')
@section('content')
<!-- resources/views/track.blade.php -->
<div class="container mx-auto max-w-xl p-6 bg-white shadow-lg rounded-lg mt-10 border border-gray-200">
    <h2 class="text-2xl font-bold mb-4 text-center text-gray-800">Track Your Order</h2>

    <form id="trackOrderForm" class="space-y-4">
        @csrf
        <label for="tracking_number" class="block text-gray-700 font-medium">Enter Tracking Number:</label>
        <input type="text" name="tracking_number" id="tracking_number" required
            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="e.g., #123456">
        <button type="submit"
            class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition duration-300">
            Track Order
        </button>
    </form>

    <div id="loader" class="mt-4 hidden text-center">
        <svg class="animate-spin h-6 w-6 text-blue-600 mx-auto" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
            <path class="opacity-75" fill="currentColor"
                d="M4 12a8 8 0 018-8v4l3-3-3-3v4a8 8 0 100 16v-4l-3 3 3 3v-4a8 8 0 01-8-8z" />
        </svg>
        <p class="text-gray-600 mt-2">Tracking your order...</p>
    </div>

    <div id="responseContainer" class="mt-6 hidden"></div>
</div>

<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $('#trackOrderForm').on('submit', function (e) {
        e.preventDefault();
        let trackingNumber = $('#tracking_number').val();
        let token = $('input[name="_token"]').val();
        $('#loader').removeClass('hidden');
        $('#responseContainer').addClass('hidden').html('');

        $.ajax({
            url: "{{ route('order.track') }}",
            method: "POST",
            data: {
                _token: token,
                tracking_number: trackingNumber
            },
          success: function (response) {
            $('#loader').addClass('hidden');
            
            if (response.success) {
            const trackingHtml = renderTrackingStatus(response.data.tracking_status);
            const paymentHtml = renderPaymentStatus(response.data.status); // status = payment status
            
            $('#responseContainer').removeClass('hidden').html(`
            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Payment Status</h3>
                ${paymentHtml}
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Tracking Status</h3>
                ${trackingHtml}
            </div>
            `);
            } else {
            $('#responseContainer').removeClass('hidden').html(`<p class="text-red-600 font-semibold">${response.message}</p>`);
            }
            },
            error: function () {
                $('#loader').addClass('hidden');
                $('#responseContainer').removeClass('hidden').html(`<p class="text-red-600 font-semibold">Something went wrong. Try again.</p>`);
            }
        });
    });

    function renderTrackingStatus(status) {
        const steps = {
            processing: 'Processing',
            in_transit: 'In Transit',
            out_for_delivery: 'Out for Delivery',
            delivered: 'Delivered',
            failed: 'Failed'
        };

        const order = ['processing', 'in_transit', 'out_for_delivery', 'delivered'];
        const isFailed = status === 'failed';
        let html = `<div class="flex flex-col space-y-4">`;

        for (const step of order) {
            const active = order.indexOf(step) <= order.indexOf(status) && !isFailed;
            html += `
                <div class="flex items-center space-x-4">
                    ${getStatusSVG(step, active, isFailed && step === status)}
                    <span class="${active ? 'text-green-700 font-semibold' : 'text-gray-600'}">${steps[step]}</span>
                </div>`;
        }

        if (isFailed) {
            html += `
                <div class="flex items-center space-x-4">
                    ${getStatusSVG('failed', true, true)}
                    <span class="text-red-600 font-semibold">Failed</span>
                </div>`;
        }

        html += `</div>`;
        return html;
    }

    function getStatusSVG(status, active, isFailed = false) {
        const color = isFailed ? 'text-red-600' : (active ? 'text-green-600' : 'text-gray-400');

        const icons = {
            processing: `<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ${color}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582a7 7 0 101.164 8H4v5H3V4h1z" />
                        </svg>`,
            in_transit: `<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ${color}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h1l1 2h13l1-2h1m-4 10a2 2 0 11-4 0 2 2 0 014 0zm-8 0a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>`,
            out_for_delivery: `<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ${color}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6h13V9l-3-3H9a1 1 0 00-1 1v10h1zm0 0H5a2 2 0 00-2 2v1h6v-3z" />
                              </svg>`,
            delivered: `<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ${color}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>`,
            failed: `<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ${color}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>`
        };

        return icons[status];
    }
</script>
@endsection
