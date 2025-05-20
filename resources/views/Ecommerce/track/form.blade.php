<!-- resources/views/Ecommerce/track.blade.php -->
@extends('Ecommerce.layouts.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-light animate__animated animate__fadeInDown">
                <div class="card-header bg-white text-center border-0">
                    <h2 class="mb-0"><i class="bi bi-box-seam-fill text-primary"></i> Track Your Order</h2>
                </div>
                <div class="card-body">
                    <form id="trackOrderForm" class="mb-4">
                        @csrf
                        <div class="mb-3">
                            <label for="tracking_number" class="form-label">Tracking Number</label>
                            <input type="text" class="form-control" id="tracking_number" name="tracking_number"
                                placeholder="#123456" required>
                        </div>
                        <button type="submit"
                            class="ms-3 btn-stelina-primary button w-100 animate__animated animate__pulse">
                            <i class="bi bi-search me-2"></i> Track Order
                        </button>
                    </form>

                    <div id="loader" class="text-center my-4 d-none">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Looking up your order...</p>
                    </div>

                    <div id="responseContainer" class="d-none"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Icons CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<!-- Animate.css CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#trackOrderForm').on('submit', function(e) {
            e.preventDefault();
            const trackingNumber = $('#tracking_number').val().trim();
            const token = $('input[name="_token"]').val();

            if (!trackingNumber) {
                showError('Please enter a tracking number.');
                return;
            }

            $('#loader').removeClass('d-none');
            $('#responseContainer').addClass('d-none').html('');

            $.ajax({
                url: '{{ route('order.track') }}',
                method: 'POST',
                data: { _token: token, tracking_number: trackingNumber },
                success(response) {
                    $('#loader').addClass('d-none');
                    if (response.success) {
                        renderResponse(response.data);
                    } else {
                        showError(response.message);
                    }
                },
                error() {
                    $('#loader').addClass('d-none');
                    showError('An error occurred. Please try again.');
                }
            });
        });

        function showError(message) {
            $('#responseContainer')
                .removeClass('d-none')
                .html(
                    `<div class="alert alert-danger animate__animated animate__shakeX" role="alert">
                        ${message}
                    </div>`
                );
        }

        function renderResponse(data) {
            console.log(data);
            const orderDate = new Date(data.order_date);
            const paymentBadge = data.status === 'paid'
                ? '<span class="badge bg-success">Paid</span>'
                : '<span class="badge bg-warning text-dark">Pending</span>';

            const steps = ['processing','in_transit','out_for_delivery','delivered'];
            const stepNames = { processing: 'Processing', in_transit: 'In Transit', out_for_delivery: 'Out for Delivery', delivered: 'Delivered' };
            const currentIndex = steps.indexOf(data.tracking_status);

            let trackerHtml = '<div class="d-flex justify-content-between align-items-center position-relative pb-4">';

            steps.forEach((step, idx) => {
                const active = idx <= currentIndex;
                const iconClass = active ? 'bi-check-circle-fill text-primary' : 'bi-circle text-secondary';
                const textClass = active ? 'text-dark fw-bold' : 'text-muted';

                trackerHtml += `
                    <div class="text-center flex-fill">
                        <i class="bi ${iconClass} fs-2 animate__animated ${active ? 'animate__fadeInDown' : ''}"></i>
                        <p class="mt-2 mb-0 ${textClass} small">${stepNames[step]}</p>
                    </div>
                `;
            });

            trackerHtml += '</div>';

            $('#responseContainer')
                .removeClass('d-none')
                .html(
                    `<div class="card border-success animate__animated animate__fadeInUp">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-credit-card-2-front-fill text-success me-2"></i>Payment Status</h5>
                            ${paymentBadge}
                        </div>
                    </div>
                    <div class="mt-4 card border-info animate__animated animate__fadeInUp animate__delay-1s">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-truck text-info me-2"></i>Tracking Progress</h5>
                            ${trackerHtml}
                        </div>
                    </div>`
                );
        }
    });
</script>
@endsection