@props([
    'class' => '',
    'delay' => 5000, // delay in milliseconds before showing modal
    'showOnMobile' => true,
])

@php
    // Don't show ads on checkout pages
    $currentRoute = request()->route()?->getName();
    $adService = app(\App\Services\AdService::class);
    
    // Debug information
    $debug = [
        'current_route' => $currentRoute,
        'should_show' => $adService->shouldShowAdsOnRoute($currentRoute),
        'total_ads' => \App\Models\Ad::count(),
        'active_ads' => \App\Models\Ad::active()->count(),
    ];
    
    if (!$adService->shouldShowAdsOnRoute($currentRoute)) {
        // Add debug comment in HTML
        echo "<!-- Ad Modal Debug: Route '{$currentRoute}' is excluded from ads -->";
        return;
    }

    // Get a random active ad
    $ad = $adService->getRandomActiveAd();
    
    if (!$ad) {
        echo "<!-- Ad Modal Debug: No active ads found. Total ads: {$debug['total_ads']}, Active ads: {$debug['active_ads']} -->";
        return;
    }
    
    if (!$ad->image_url) {
        echo "<!-- Ad Modal Debug: Ad '{$ad->title}' has no image URL -->";
        return;
    }
    
    // Debug success
    echo "<!-- Ad Modal Debug: Showing ad '{$ad->title}' with image: {$ad->image_url} -->";
@endphp

<!-- Modal -->
<div class="modal fade" id="adModal{{ $ad->id }}" tabindex="-1" aria-labelledby="adModalLabel{{ $ad->id }}" aria-hidden="true" data-ad-id="{{ $ad->id }}">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg position-relative" style="border-radius: 25px; overflow: hidden;">
            <!-- Close button -->
            <button type="button" class="btn-close position-absolute top-0 end-0 m-4 bg-white rounded-circle shadow-lg" 
                    data-bs-dismiss="modal" aria-label="Close" 
                    style="z-index: 1050; width: 45px; height: 45px; border: 2px solid rgba(255,255,255,0.3);">
            </button>
            
            <!-- Modal body -->
            <div class="modal-body p-0 position-relative">
                <div class="row g-0">
                    <!-- Image Section -->
                    <div class="col-md-7">
                        <div class="ad-image-container position-relative h-100">
                            <img 
                                src="{{ $ad->image_url }}" 
                                alt="{{ $ad->title }}"
                                class="ad-image w-100 h-100"
                                style="min-height: 400px; object-fit: cover;"
                                loading="lazy"
                            >
                            <!-- Gradient overlay for better text readability -->
                            <div class="position-absolute top-0 start-0 w-100 h-100" 
                                 style="background: linear-gradient(45deg, rgba(0,0,0,0.3) 0%, transparent 50%, rgba(0,0,0,0.1) 100%);"></div>
                        </div>
                    </div>
                    
                    <!-- Content Section -->
                    <div class="col-md-5 d-flex align-items-center">
                        <div class="ad-content p-5 w-100" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <!-- Special Offer Badge -->
                            <div class="mb-3">
                                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold" style="font-size: 0.9rem;">
                                    🔥 Special Offer
                                </span>
                            </div>
                            
                            <!-- Ad Title -->
                            <h2 class="ad-title text-white mb-4 fw-bold" style="font-size: 2rem; line-height: 1.2;">
                                {{ $ad->title }}
                            </h2>

                            <!-- Description if available -->
                            @if($ad->description)
                            <p class="ad-description text-white mb-4" style="font-size: 1.1rem; opacity: 0.9; line-height: 1.6;">
                                {{ $ad->description }}
                            </p>
                            @endif

                            <!-- Features list -->
                            <ul class="list-unstyled text-white mb-4" style="opacity: 0.9;">
                                <li class="mb-2"><i class="fas fa-check-circle me-2 text-warning"></i>Limited Time Offer</li>
                                <li class="mb-2"><i class="fas fa-truck me-2 text-warning"></i>Free UK Delivery</li>
                                <li class="mb-2"><i class="fas fa-shield-alt me-2 text-warning"></i>Secure Payment</li>
                            </ul>

                            <!-- Call to Action Button -->
                            <button 
                                type="button"
                                class="ad-cta-button btn btn-warning btn-lg fw-bold px-5 py-3 w-100 text-dark"
                                data-ad-id="{{ $ad->id }}"
                                data-target-url="{{ $ad->button_link }}"
                                style="border-radius: 50px; box-shadow: 0 6px 20px rgba(255,193,7,0.4); transition: all 0.3s ease; border: 2px solid rgba(255,255,255,0.2);"
                            >
                                {{ $ad->button_text }}
                                <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                            
                            <!-- Urgency text -->
                            <p class="text-center text-white mt-3 mb-0" style="font-size: 0.9rem; opacity: 0.8;">
                                <i class="fas fa-clock me-1"></i>
                                Don't miss out - Limited time only!
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Loading Overlay -->
                <div class="ad-loading position-absolute top-0 start-0 w-100 h-100 d-none align-items-center justify-content-center"
                     style="background: rgba(255,255,255,0.95); backdrop-filter: blur(5px); z-index: 1040;">
                    <div class="text-center">
                        <div class="spinner-border text-primary mb-3" role="status" style="width: 3rem; height: 3rem;">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="text-muted">Taking you to our offer...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ad Performance (Hidden, for tracking) -->
<div class="ad-stats d-none" data-views="{{ $ad->views }}" data-clicks="{{ $ad->clicks }}"></div>

@push('styles')
<style>
.modal-content {
    border-radius: 25px !important;
    overflow: hidden;
    background: transparent;
}

.ad-image {
    transition: transform 0.5s ease;
}

.modal-body:hover .ad-image {
    transform: scale(1.03);
}

.ad-cta-button {
    transition: all 0.3s ease !important;
    text-decoration: none !important;
    position: relative;
    overflow: hidden;
}

.ad-cta-button::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    transition: left 0.5s;
}

.ad-cta-button:hover::before {
    left: 100%;
}

.ad-cta-button:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(255,193,7,0.6) !important;
    text-decoration: none !important;
}

.btn-close {
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.btn-close:hover {
    transform: scale(1.15) rotate(90deg);
    background-color: rgba(255,255,255,0.9) !important;
}

/* Responsive design */
@media (max-width: 992px) {
    .modal-dialog {
        margin: 1rem;
        max-width: calc(100% - 2rem);
    }
    
    .row.g-0 {
        flex-direction: column;
    }
    
    .col-md-7, .col-md-5 {
        max-width: 100%;
        flex: 0 0 100%;
    }
    
    .ad-image {
        min-height: 250px !important;
    }
    
    .ad-content {
        padding: 2rem !important;
    }
    
    .ad-title {
        font-size: 1.5rem !important;
    }
    
    .ad-cta-button {
        font-size: 1rem !important;
        padding: 12px 24px !important;
    }
}

@media (max-width: 576px) {
    .modal-dialog {
        margin: 0.5rem;
        max-width: calc(100% - 1rem);
    }
    
    .ad-content {
        padding: 1.5rem !important;
    }
    
    .ad-title {
        font-size: 1.3rem !important;
    }
    
    @if(!$showOnMobile)
    .modal {
        display: none !important;
    }
    @endif
}

/* Enhanced modal entrance animation */
.modal.fade .modal-dialog {
    transform: translate(0, -50px) scale(0.8) rotateX(15deg);
    transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
    opacity: 0;
}

.modal.show .modal-dialog {
    transform: translate(0, 0) scale(1) rotateX(0deg);
    opacity: 1;
}

/* Pulse animation for special offer badge */
@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.badge {
    animation: pulse 2s infinite;
}

/* Floating animation for features */
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-5px); }
}

.list-unstyled li {
    animation: float 3s ease-in-out infinite;
}

.list-unstyled li:nth-child(2) {
    animation-delay: 0.5s;
}

.list-unstyled li:nth-child(3) {
    animation-delay: 1s;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('🎯 Ad Modal Script Loading...');
    
    const modalElement = document.getElementById('adModal{{ $ad->id }}');
    const adId = '{{ $ad->id }}';
    const delay = {{ $delay }};
    
    console.log('📊 Modal Debug Info:', {
        modalElement: modalElement ? 'Found' : 'Not Found',
        adId: adId,
        delay: delay,
        bootstrap: typeof bootstrap !== 'undefined' ? 'Available' : 'Not Available'
    });
    
    // Check if modal should be shown (not shown in current session and not on excluded pages)
    const sessionKey = 'adModal_' + adId + '_shown_today';
    const alreadyShown = sessionStorage.getItem(sessionKey);
    
    console.log('🔍 Session Check:', {
        sessionKey: sessionKey,
        alreadyShown: alreadyShown ? 'Yes' : 'No'
    });
    
    if (modalElement && !alreadyShown) {
        // Show modal after delay
        console.log(`⏰ Setting timeout for ${delay}ms...`);
        setTimeout(function() {
            console.log('🚀 Attempting to show modal...');
            
            if (typeof bootstrap === 'undefined') {
                console.error('❌ Bootstrap not available');
                return;
            }
            
            try {
                const modal = new bootstrap.Modal(modalElement, {
                    backdrop: true,
                    keyboard: true,
                    focus: true
                });
                
                console.log('✅ Modal instance created');
                
                // Add entrance sound effect (optional)
                playNotificationSound();
                
                console.log('🎊 Showing modal...');
                modal.show();
                
                // Mark as shown for today to prevent showing again
                const today = new Date().toDateString();
                sessionStorage.setItem('adModal_' + adId + '_shown_today', today);
                console.log('💾 Session storage updated');
                
                // Track ad view when modal is shown
                trackAdView(adId);
                
            } catch (error) {
                console.error('❌ Error showing modal:', error);
            }
        }, delay);
    }
    
    // Handle CTA button clicks
    const ctaButton = modalElement?.querySelector('.ad-cta-button');
    if (ctaButton) {
        ctaButton.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetUrl = this.dataset.targetUrl;
            const loadingOverlay = modalElement.querySelector('.ad-loading');
            
            // Show loading state
            if (loadingOverlay) {
                loadingOverlay.classList.remove('d-none');
                loadingOverlay.classList.add('d-flex');
            }
            
            // Track click and redirect
            trackAdClick(adId, targetUrl, modalElement);
        });
    }
    
    // Track modal dismissal
    modalElement?.addEventListener('hidden.bs.modal', function() {
        console.log('Ad modal dismissed');
    });
});

// Optional sound effect for modal appearance
function playNotificationSound() {
    try {
        // Create a subtle notification sound
        const audioContext = new (window.AudioContext || window.webkitAudioContext)();
        const oscillator = audioContext.createOscillator();
        const gainNode = audioContext.createGain();
        
        oscillator.connect(gainNode);
        gainNode.connect(audioContext.destination);
        
        oscillator.frequency.setValueAtTime(800, audioContext.currentTime);
        oscillator.frequency.setValueAtTime(600, audioContext.currentTime + 0.1);
        
        gainNode.gain.setValueAtTime(0, audioContext.currentTime);
        gainNode.gain.linearRampToValueAtTime(0.1, audioContext.currentTime + 0.01);
        gainNode.gain.linearRampToValueAtTime(0, audioContext.currentTime + 0.2);
        
        oscillator.start(audioContext.currentTime);
        oscillator.stop(audioContext.currentTime + 0.2);
    } catch (error) {
        // Sound effects not supported or disabled
        console.log('Sound effects not available');
    }
}

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
            const statsDiv = document.querySelector('.ad-stats');
            if (statsDiv) {
                statsDiv.dataset.views = data.views;
            }
        }
    })
    .catch(error => {
        console.error('Failed to track ad view:', error);
    });
}

function trackAdClick(adId, targetUrl, modalElement) {
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
        const loadingOverlay = modalElement?.querySelector('.ad-loading');
        if (loadingOverlay) {
            loadingOverlay.classList.add('d-none');
            loadingOverlay.classList.remove('d-flex');
        }
        
        if (data.success) {
            console.log('Ad click tracked successfully');
            // Update click counter if needed
            const statsDiv = document.querySelector('.ad-stats');
            if (statsDiv) {
                statsDiv.dataset.clicks = data.clicks;
            }
        }
        
        // Close modal and redirect
        const modal = bootstrap.Modal.getInstance(modalElement);
        if (modal) {
            modal.hide();
        }
        
        // Redirect to target URL
        setTimeout(() => {
            if (data.redirect_url || targetUrl) {
                window.open(data.redirect_url || targetUrl, '_blank');
            }
        }, 300);
    })
    .catch(error => {
        console.error('Failed to track ad click:', error);
        
        // Hide loading state and still redirect
        const loadingOverlay = modalElement?.querySelector('.ad-loading');
        if (loadingOverlay) {
            loadingOverlay.classList.add('d-none');
            loadingOverlay.classList.remove('d-flex');
        }
        
        // Close modal
        const modal = bootstrap.Modal.getInstance(modalElement);
        if (modal) {
            modal.hide();
        }
        
        // Still redirect even if tracking fails
        setTimeout(() => {
            if (targetUrl) {
                window.open(targetUrl, '_blank');
            }
        }, 300);
    });
}
</script>
@endpush