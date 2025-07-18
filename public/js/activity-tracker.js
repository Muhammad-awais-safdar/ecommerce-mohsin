class ActivityTracker {
    constructor() {
        this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        this.baseUrl = window.location.origin;
        this.init();
    }

    init() {
        this.trackPageView();
        this.trackClicks();
        this.trackFormSubmissions();
        this.trackFilterUsage();
        this.trackProductViews();
        this.trackCartActions();
        this.trackSearches();
    }

    async logActivity(action, details = {}) {
        try {
            const response = await fetch(`${this.baseUrl}/log-activity`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    action: action,
                    details: details,
                    page: window.location.pathname,
                    timestamp: new Date().toISOString()
                })
            });

            if (!response.ok) {
                console.warn('Activity logging failed:', response.statusText);
            }
        } catch (error) {
            console.warn('Activity logging error:', error);
        }
    }

    trackPageView() {
        const pageType = this.getPageType();
        this.logActivity(`Visited ${pageType} page`, {
            url: window.location.href,
            referrer: document.referrer,
            page_type: pageType
        });
    }

    trackClicks() {
        document.addEventListener('click', (event) => {
            const element = event.target;
            const tagName = element.tagName.toLowerCase();
            
            // Track important button clicks
            if (tagName === 'button' || element.classList.contains('btn')) {
                this.logActivity('Button clicked', {
                    button_text: element.textContent.trim(),
                    button_class: element.className,
                    button_id: element.id
                });
            }
            
            // Track link clicks
            if (tagName === 'a') {
                this.logActivity('Link clicked', {
                    link_text: element.textContent.trim(),
                    link_href: element.href,
                    link_class: element.className
                });
            }
        });
    }

    trackFormSubmissions() {
        document.addEventListener('submit', (event) => {
            const form = event.target;
            const formData = new FormData(form);
            const formFields = {};
            
            for (let [key, value] of formData.entries()) {
                // Don't log sensitive data
                if (!['password', 'token', 'email'].includes(key)) {
                    formFields[key] = value;
                }
            }
            
            this.logActivity('Form submitted', {
                form_id: form.id,
                form_action: form.action,
                form_method: form.method,
                fields: Object.keys(formFields)
            });
        });
    }

    trackFilterUsage() {
        // Track filter form submissions
        const filterForm = document.querySelector('.shop-filters form');
        if (filterForm) {
            filterForm.addEventListener('submit', (event) => {
                const formData = new FormData(event.target);
                const filters = {};
                
                for (let [key, value] of formData.entries()) {
                    if (value) filters[key] = value;
                }
                
                this.logActivity('Applied shop filters', {
                    filters: filters,
                    filter_count: Object.keys(filters).length
                });
            });
            
            // Track individual filter changes
            const filterInputs = filterForm.querySelectorAll('input, select');
            filterInputs.forEach(input => {
                input.addEventListener('change', (event) => {
                    this.logActivity('Filter changed', {
                        filter_type: event.target.name,
                        filter_value: event.target.value
                    });
                });
            });
        }
    }

    trackProductViews() {
        // Track product page views
        if (window.location.pathname.startsWith('/product/')) {
            const productName = document.querySelector('h1')?.textContent.trim();
            this.logActivity('Product viewed', {
                product_name: productName,
                product_slug: window.location.pathname.split('/').pop()
            });
        }
        
        // Track product clicks in listings
        document.addEventListener('click', (event) => {
            const productLink = event.target.closest('.product-item a');
            if (productLink) {
                this.logActivity('Product clicked in listing', {
                    product_url: productLink.href
                });
            }
        });
    }

    trackCartActions() {
        // Track add to cart buttons
        document.addEventListener('click', (event) => {
            if (event.target.classList.contains('add-to-cart-btn')) {
                const productId = event.target.dataset.id;
                const productName = event.target.dataset.name;
                const productPrice = event.target.dataset.price;
                
                this.logActivity('Added to cart', {
                    product_id: productId,
                    product_name: productName,
                    product_price: productPrice
                });
            }
        });
    }

    trackSearches() {
        // Track search input usage
        const searchInputs = document.querySelectorAll('input[name="search"]');
        searchInputs.forEach(input => {
            let searchTimeout;
            input.addEventListener('input', (event) => {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    if (event.target.value.length > 2) {
                        this.logActivity('Search performed', {
                            search_term: event.target.value,
                            search_length: event.target.value.length
                        });
                    }
                }, 1000);
            });
        });
    }

    getPageType() {
        const path = window.location.pathname;
        
        if (path === '/') return 'home';
        if (path === '/shop') return 'shop';
        if (path.startsWith('/product/')) return 'product';
        if (path.startsWith('/cart')) return 'cart';
        if (path.startsWith('/checkout')) return 'checkout';
        if (path.startsWith('/admin')) return 'admin';
        
        return 'other';
    }
}

// Initialize activity tracker when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    new ActivityTracker();
});

// Export for use in other scripts
window.ActivityTracker = ActivityTracker;