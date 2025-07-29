@props([
    'class' => '',
    'position' => 'center', // center, left, right
    'showOnMobile' => true,
])

@php
    // Don't show ads on checkout pages
    $currentRoute = request()->route()?->getName();
    $adService = app(\App\Services\AdService::class);
    
    if (!$adService->shouldShowAdsOnRoute($currentRoute)) {
        return;
    }

    // Get a random active ad
    $ad = $adService->getRandomActiveAd();
    
    if (!$ad || !$ad->image_url) {
        return;
    }
@endphp

<div 
    class="ad-banner-container {{ $class }} @if(!$showOnMobile) d-none d-md-block @endif" 
    data-ad-id="{{ $ad->id }}"
    style="margin: 20px 0;"
>
    <div class="ad-banner position-relative overflow-hidden rounded shadow-sm" 
         style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border: 1px solid #dee2e6;">
        
        <!-- Ad Image -->
        <div class="ad-image-container text-{{ $position }}">
            <img 
                src="{{ $ad->image_url }}" 
                alt="{{ $ad->title }}"
                class="ad-image img-fluid rounded"
                style="max-height: 200px; width: auto; object-fit: cover;"
                loading="lazy"
            >
        </div>

        <!-- Ad Content Overlay -->
        <div class="ad-content position-absolute bottom-0 start-0 end-0 p-3" 
             style="background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.4) 50%, transparent 100%);">
            
            <!-- Ad Title -->
            <h5 class="ad-title text-white mb-2 fw-bold" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">
                {{ $ad->title }}
            </h5>

            <!-- Call to Action Button -->
            <button 
                type="button"
                class="ad-cta-button btn btn-primary btn-sm fw-bold px-4 py-2"
                data-ad-id="{{ $ad->id }}"
                data-target-url="{{ $ad->button_link }}"
                style="border-radius: 25px; box-shadow: 0 4px 8px rgba(0,0,0,0.2); transition: all 0.3s ease;"
                onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 12px rgba(0,0,0,0.3)';"
                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 8px rgba(0,0,0,0.2)';"
            >
                {{ $ad->button_text }}
                <i class="fas fa-arrow-right ms-1"></i>
            </button>
        </div>

        <!-- Loading Overlay -->
        <div class="ad-loading position-absolute top-0 start-0 w-100 h-100 d-none align-items-center justify-content-center"
             style="background: rgba(255,255,255,0.8); backdrop-filter: blur(2px);">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    <!-- Ad Performance (Hidden, for tracking) -->
    <div class="ad-stats d-none" data-views="{{ $ad->views }}" data-clicks="{{ $ad->clicks }}"></div>
</div>

@push('styles')
<style>
.ad-banner-container {
    max-width: 100%;
    margin: 0 auto;
}

.ad-banner {
    transition: all 0.3s ease;
    cursor: pointer;
}

.ad-banner:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.ad-image {
    transition: transform 0.3s ease;
}

.ad-banner:hover .ad-image {
    transform: scale(1.05);
}

.ad-cta-button {
    transition: all 0.3s ease !important;
    text-decoration: none !important;
}

.ad-cta-button:hover {
    text-decoration: none !important;
}

@media (max-width: 768px) {
    .ad-banner {
        margin: 10px 0;
    }
    
    .ad-content {
        padding: 15px !important;
    }
    
    .ad-title {
        font-size: 1rem !important;
    }
    
    .ad-cta-button {
        font-size: 0.875rem !important;
        padding: 8px 16px !important;
    }
}

/* Animation for ad appearance */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.ad-banner-container {
    animation: fadeInUp 0.6s ease-out;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Track ad view when it becomes visible
    const adBanner = document.querySelector('.ad-banner-container[data-ad-id="{{ $ad->id }}"]');
    
    if (adBanner) {
        const adId = adBanner.dataset.adId;
        
        // Create intersection observer for view tracking
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !entry.target.dataset.viewed) {
                    entry.target.dataset.viewed = 'true';
                    trackAdView(adId);
                }
            });
        }, {
            threshold: 0.5 // Track when 50% of ad is visible
        });
        
        observer.observe(adBanner);
        
        // Handle CTA button clicks
        const ctaButton = adBanner.querySelector('.ad-cta-button');
        if (ctaButton) {
            ctaButton.addEventListener('click', function(e) {
                e.preventDefault();
                
                const targetUrl = this.dataset.targetUrl;
                const loadingOverlay = adBanner.querySelector('.ad-loading');
                
                // Show loading state
                if (loadingOverlay) {
                    loadingOverlay.classList.remove('d-none');
                    loadingOverlay.classList.add('d-flex');
                }
                
                // Track click and redirect
                trackAdClick(adId, targetUrl);
            });
        }
    }
});

function trackAdView(adId) {
    fetch(`/ads/${adId}/track-view`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        },
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Ad view tracked successfully');
            // Update view counter if needed
            const statsDiv = document.querySelector(`[data-ad-id="${adId}"] .ad-stats`);
            if (statsDiv) {
                statsDiv.dataset.views = data.views;
            }
        }
    })
    .catch(error => {
        console.error('Failed to track ad view:', error);
    });
}

function trackAdClick(adId, targetUrl) {
    fetch(`/ads/${adId}/track-click`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        },
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(data => {
        // Hide loading state
        const loadingOverlay = document.querySelector(`[data-ad-id="${adId}"] .ad-loading`);
        if (loadingOverlay) {
            loadingOverlay.classList.add('d-none');
            loadingOverlay.classList.remove('d-flex');
        }
        
        if (data.success) {
            console.log('Ad click tracked successfully');
            // Update click counter if needed
            const statsDiv = document.querySelector(`[data-ad-id="${adId}"] .ad-stats`);
            if (statsDiv) {
                statsDiv.dataset.clicks = data.clicks;
            }
        }
        
        // Redirect to target URL
        if (data.redirect_url || targetUrl) {
            window.open(data.redirect_url || targetUrl, '_blank');
        }
    })
    .catch(error => {
        console.error('Failed to track ad click:', error);
        
        // Hide loading state and still redirect
        const loadingOverlay = document.querySelector(`[data-ad-id="${adId}"] .ad-loading`);
        if (loadingOverlay) {
            loadingOverlay.classList.add('d-none');
            loadingOverlay.classList.remove('d-flex');
        }
        
        // Still redirect even if tracking fails
        if (targetUrl) {
            window.open(targetUrl, '_blank');
        }
    });
}
</script>
@endpush