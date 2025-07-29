<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Advertisement Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration options for the advertisement management system.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Modal Type
    |--------------------------------------------------------------------------
    |
    | Choose between 'simple' (no dependencies) or 'bootstrap' modal type.
    |
    */
    'use_simple_modal' => env('ADS_USE_SIMPLE_MODAL', true),

    /*
    |--------------------------------------------------------------------------
    | Cache Settings
    |--------------------------------------------------------------------------
    |
    | Configure how long ads should be cached to improve performance.
    |
    */
    'cache' => [
        'ttl' => env('ADS_CACHE_TTL', 300), // 5 minutes in seconds
        'key_prefix' => env('ADS_CACHE_PREFIX', 'ads_'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Display Settings
    |--------------------------------------------------------------------------
    |
    | Configure how ads are displayed on the frontend.
    |
    */
    'display' => [
        'default_position' => env('ADS_DEFAULT_POSITION', 'center'), // center, left, right
        'show_on_mobile' => env('ADS_SHOW_ON_MOBILE', true),
        'max_width' => env('ADS_MAX_WIDTH', '100%'),
        'max_height' => env('ADS_MAX_HEIGHT', '200px'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Excluded Routes
    |--------------------------------------------------------------------------
    |
    | Routes where ads should not be displayed.
    |
    */
    'excluded_routes' => [
        'checkout',
        'checkout.store',
        'checkout.payment',
        'payment.success',
        'payment.failure',
        'refund.request.form',
        'refund.request.store',
    ],

    /*
    |--------------------------------------------------------------------------
    | File Upload Settings
    |--------------------------------------------------------------------------
    |
    | Configuration for ad image uploads.
    |
    */
    'uploads' => [
        'disk' => env('ADS_UPLOAD_DISK', 'public'),
        'directory' => env('ADS_UPLOAD_DIRECTORY', 'ads'),
        'max_size' => env('ADS_MAX_FILE_SIZE', 2048), // KB
        'allowed_types' => [
            'image/jpeg',
            'image/png',
            'image/webp',
            'image/gif',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Analytics Settings
    |--------------------------------------------------------------------------
    |
    | Configuration for ad performance tracking.
    |
    */
    'analytics' => [
        'track_impressions' => env('ADS_TRACK_IMPRESSIONS', true),
        'track_clicks' => env('ADS_TRACK_CLICKS', true),
        'log_user_agents' => env('ADS_LOG_USER_AGENTS', true),
        'log_ip_addresses' => env('ADS_LOG_IP_ADDRESSES', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Performance Thresholds
    |--------------------------------------------------------------------------
    |
    | Define CTR thresholds for performance categorization.
    |
    */
    'performance_thresholds' => [
        'high_ctr' => env('ADS_HIGH_CTR_THRESHOLD', 5.0), // 5% CTR
        'medium_ctr' => env('ADS_MEDIUM_CTR_THRESHOLD', 2.0), // 2% CTR
        'low_ctr' => env('ADS_LOW_CTR_THRESHOLD', 1.0), // 1% CTR
    ],

    /*
    |--------------------------------------------------------------------------
    | Auto-expiration Settings
    |--------------------------------------------------------------------------
    |
    | Configure automatic handling of expired ads.
    |
    */
    'auto_expiration' => [
        'enabled' => env('ADS_AUTO_EXPIRATION', true),
        'deactivate_expired' => env('ADS_DEACTIVATE_EXPIRED', false),
        'notify_before_expiry' => env('ADS_NOTIFY_BEFORE_EXPIRY', true),
        'notification_days' => env('ADS_NOTIFICATION_DAYS', 7), // Notify 7 days before expiry
    ],

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    |
    | Configure rate limiting for ad tracking endpoints.
    |
    */
    'rate_limiting' => [
        'views_per_minute' => env('ADS_VIEWS_RATE_LIMIT', 60),
        'clicks_per_minute' => env('ADS_CLICKS_RATE_LIMIT', 10),
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Button Texts
    |--------------------------------------------------------------------------
    |
    | Common button texts for quick selection.
    |
    */
    'default_button_texts' => [
        'Shop Now',
        'Buy Now',
        'Learn More',
        'Discover',
        'Explore',
        'Get Yours',
        'Order Today',
        'Limited Time',
        'Don\'t Miss Out',
        'See Details',
        'View Products',
        'Browse Collection',
    ],

    /*
    |--------------------------------------------------------------------------
    | Placeholder Images
    |--------------------------------------------------------------------------
    |
    | Default images to use when no ad image is available.
    |
    */
    'placeholders' => [
        'default' => '/images/ad-placeholder.png',
        'loading' => '/images/ad-loading.gif',
        'error' => '/images/ad-error.png',
    ],

];