@props([
    'class' => '',
    'delay' => 5000,
    'showOnMobile' => true,
])

@php
    // Don't show ads on checkout pages
    $currentRoute = request()->route()?->getName();
    $adService = app(\App\Services\AdService::class);
    
    if (!$adService->shouldShowAdsOnRoute($currentRoute)) {
        echo "<!-- Simple Ad Modal Debug: Route '{$currentRoute}' is excluded from ads -->";
        return;
    }

    // Get a random active ad
    $ad = $adService->getRandomActiveAd();
    
    if (!$ad || !$ad->image_url) {
        echo "<!-- Simple Ad Modal Debug: No valid ad found -->";
        return;
    }
    
    echo "<!-- Simple Ad Modal Debug: Showing ad '{$ad->title}' -->";
@endphp

<!-- Simple Modal (No Bootstrap Dependency) -->
<div id="simpleAdModal{{ $ad->id }}" class="simple-ad-modal" style="display: none;" data-ad-id="{{ $ad->id }}">
    <!-- Backdrop -->
    <div class="simple-modal-backdrop"></div>
    
    <!-- Modal Content -->
    <div class="simple-modal-content">
        <!-- Close button -->
        <button type="button" class="simple-modal-close" onclick="closeSimpleModal('{{ $ad->id }}')">&times;</button>
        
        <!-- Modal body -->
        <div class="simple-modal-body">
            <div class="simple-modal-grid">
                <!-- Image Section -->
                <div class="simple-modal-image">
                    <img src="{{ $ad->image_url }}" alt="{{ $ad->title }}" />
                </div>
                
                <!-- Content Section -->
                <div class="simple-modal-text">
                    <!-- Badge -->
                    <div class="simple-offer-badge">🔥 Special Offer</div>
                    
                    <!-- Title -->
                    <h2 class="simple-modal-title">{{ $ad->title }}</h2>

                    <!-- Description -->
                    @if($ad->description)
                    <p class="simple-modal-description">{{ $ad->description }}</p>
                    @endif

                    <!-- Features -->
                    <ul class="simple-modal-features">
                        <li>✓ Limited Time Offer</li>
                        <li>✓ Free UK Delivery</li>
                        <li>✓ Secure Payment</li>
                    </ul>

                    <!-- CTA Button -->
                    <button class="simple-modal-cta" 
                            onclick="handleSimpleAdClick('{{ $ad->id }}', '{{ $ad->button_link }}')">
                        {{ $ad->button_text }} →
                    </button>
                    
                    <!-- Urgency text -->
                    <p class="simple-modal-urgency">⏰ Don't miss out - Limited time only!</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.simple-ad-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 9999;
    animation: fadeIn 0.3s ease-out;
}

.simple-modal-backdrop {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(5px);
}

.simple-modal-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    border-radius: 20px;
    overflow: hidden;
    max-width: 90vw;
    max-height: 90vh;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    animation: modalSlideIn 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
}

.simple-modal-close {
    position: absolute;
    top: 15px;
    right: 15px;
    background: rgba(255, 255, 255, 0.9);
    border: none;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #333;
    border-radius: 50%;
    font-size: 24px;
    cursor: pointer;
    z-index: 10;
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
}

.simple-modal-close:hover {
    background: white;
    transform: scale(1.1) rotate(90deg);
}

.simple-modal-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    min-height: 400px;
}

.simple-modal-image {
    position: relative;
    overflow: hidden;
}

.simple-modal-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.simple-modal-content:hover .simple-modal-image img {
    transform: scale(1.05);
}

.simple-modal-text {
    padding: 40px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.simple-offer-badge {
    background: #ffc107;
    color: #000;
    padding: 8px 16px;
    border-radius: 20px;
    font-weight: bold;
    margin-bottom: 20px;
    align-self: flex-start;
    animation: pulse 2s infinite;
}

.simple-modal-title {
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 15px;
    line-height: 1.2;
}

.simple-modal-description {
    font-size: 1.1rem;
    opacity: 0.9;
    margin-bottom: 20px;
    line-height: 1.5;
}

.simple-modal-features {
    list-style: none;
    padding: 0;
    margin-bottom: 25px;
}

.simple-modal-features li {
    padding: 5px 0;
    opacity: 0.9;
}

.simple-modal-cta {
    background: #ffc107;
    color: #000;
    border: none;
    padding: 15px 40px;
    border-radius: 50px;
    font-size: 1.1rem;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-bottom: 15px;
    box-shadow: 0 4px 15px rgba(255, 193, 7, 0.4);
}

.simple-modal-cta:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 193, 7, 0.6);
}

.simple-modal-urgency {
    text-align: center;
    font-size: 0.9rem;
    opacity: 0.8;
    margin: 0;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translate(-50%, -60%) scale(0.9);
    }
    to {
        opacity: 1;
        transform: translate(-50%, -50%) scale(1);
    }
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .simple-modal-grid {
        grid-template-columns: 1fr;
        grid-template-rows: 200px 1fr;
    }
    
    .simple-modal-text {
        padding: 30px 20px;
    }
    
    .simple-modal-title {
        font-size: 1.5rem;
    }
    
    @if(!$showOnMobile)
    .simple-ad-modal {
        display: none !important;
    }
    @endif
}
</style>

<script>
// Simple Modal Functions (No Dependencies)
document.addEventListener('DOMContentLoaded', function() {
    console.log('🎯 Simple Ad Modal Loading...');
    
    const modalId = 'simpleAdModal{{ $ad->id }}';
    const adId = '{{ $ad->id }}';
    const delay = {{ $delay }};
    
    // Check if already shown today
    const sessionKey = 'simpleAdModal_' + adId + '_shown_today';
    const today = new Date().toDateString();
    const lastShown = sessionStorage.getItem(sessionKey);
    
    if (lastShown === today) {
        console.log('📅 Simple modal already shown today');
        return;
    }
    
    // Show modal after delay
    setTimeout(function() {
        console.log('🚀 Showing simple modal...');
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden'; // Prevent scrolling
            
            // Mark as shown
            sessionStorage.setItem(sessionKey, today);
            
            // Track view
            trackSimpleAdView(adId);
        }
    }, delay);
});

function closeSimpleModal(adId) {
    console.log('❌ Closing simple modal');
    const modal = document.getElementById('simpleAdModal' + adId);
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto'; // Re-enable scrolling
    }
}

function handleSimpleAdClick(adId, targetUrl) {
    console.log('🖱️ Simple ad clicked');
    
    // Track click
    trackSimpleAdClick(adId);
    
    // Close modal
    closeSimpleModal(adId);
    
    // Open link
    setTimeout(() => {
        window.open(targetUrl, '_blank');
    }, 300);
}

function trackSimpleAdView(adId) {
    fetch(`/ads/${adId}/track-view`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        }
    }).then(response => response.json())
      .then(data => console.log('✅ View tracked:', data))
      .catch(error => console.error('❌ View tracking failed:', error));
}

function trackSimpleAdClick(adId) {
    fetch(`/ads/${adId}/track-click`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        }
    }).then(response => response.json())
      .then(data => console.log('✅ Click tracked:', data))
      .catch(error => console.error('❌ Click tracking failed:', error));
}

// Close modal when clicking backdrop
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('simple-modal-backdrop')) {
        const modal = e.target.closest('.simple-ad-modal');
        if (modal) {
            const adId = modal.dataset.adId;
            closeSimpleModal(adId);
        }
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const visibleModal = document.querySelector('.simple-ad-modal[style*="block"]');
        if (visibleModal) {
            const adId = visibleModal.dataset.adId;
            closeSimpleModal(adId);
        }
    }
});
</script>