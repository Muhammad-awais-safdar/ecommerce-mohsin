<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Under Maintenance</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .maintenance-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        
        .maintenance-card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .pulse-animation {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        
        @keyframes floating {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .gear {
            animation: rotate 4s linear infinite;
        }
        
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="maintenance-bg">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="max-w-2xl w-full">
            <!-- Main Maintenance Card -->
            <div class="maintenance-card rounded-2xl p-8 md:p-12 text-center text-white shadow-2xl">
                <!-- Animated Icon -->
                <div class="mb-8">
                    <div class="relative inline-block">
                        <i class="fas fa-cog gear text-6xl md:text-8xl text-white opacity-80"></i>
                        <i class="fas fa-wrench absolute top-4 right-4 text-2xl md:text-3xl floating"></i>
                    </div>
                </div>
                
                <!-- Main Heading -->
                <h1 class="text-4xl md:text-6xl font-bold mb-4">
                    We'll Be Right Back!
                </h1>
                
                <!-- Subheading -->
                <h2 class="text-xl md:text-2xl font-medium mb-6 opacity-90">
                    {{ config('app.name') }} is Under Maintenance
                </h2>
                
                <!-- Description -->
                <p class="text-lg md:text-xl mb-8 opacity-80 leading-relaxed">
                    We're currently performing scheduled maintenance to improve your shopping experience. 
                    Our team is working hard to get everything back online as soon as possible.
                </p>
                
                <!-- Features Being Updated -->
                <div class="grid md:grid-cols-3 gap-6 mb-8">
                    <div class="maintenance-card rounded-lg p-4">
                        <i class="fas fa-shopping-cart text-2xl mb-2 pulse-animation"></i>
                        <h3 class="font-semibold mb-1">Shopping Experience</h3>
                        <p class="text-sm opacity-75">Enhancing product browsing</p>
                    </div>
                    <div class="maintenance-card rounded-lg p-4">
                        <i class="fas fa-credit-card text-2xl mb-2 pulse-animation" style="animation-delay: 0.5s;"></i>
                        <h3 class="font-semibold mb-1">Payment System</h3>
                        <p class="text-sm opacity-75">Improving checkout process</p>
                    </div>
                    <div class="maintenance-card rounded-lg p-4">
                        <i class="fas fa-shield-alt text-2xl mb-2 pulse-animation" style="animation-delay: 1s;"></i>
                        <h3 class="font-semibold mb-1">Security Updates</h3>
                        <p class="text-sm opacity-75">Strengthening protection</p>
                    </div>
                </div>
                
                <!-- Expected Time -->
                <div class="maintenance-card rounded-lg p-6 mb-8">
                    <h3 class="text-lg font-semibold mb-2">
                        <i class="fas fa-clock mr-2"></i>
                        Expected Completion
                    </h3>
                    <p class="text-2xl font-bold" id="countdown">
                        Estimated: 2-4 hours
                    </p>
                    <p class="text-sm opacity-75 mt-2">
                        Started: {{ now()->format('M j, Y \a\t g:i A') }}
                    </p>
                </div>
                
                <!-- Contact Information -->
                <div class="border-t border-white border-opacity-20 pt-6">
                    <p class="text-sm opacity-75 mb-4">
                        Need immediate assistance? Contact our support team:
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
                        <a href="mailto:support@{{ parse_url(config('app.url'), PHP_URL_HOST) }}" 
                           class="inline-flex items-center px-4 py-2 bg-white bg-opacity-20 rounded-lg hover:bg-opacity-30 transition-all duration-200">
                            <i class="fas fa-envelope mr-2"></i>
                            Email Support
                        </a>
                        <a href="tel:+1234567890" 
                           class="inline-flex items-center px-4 py-2 bg-white bg-opacity-20 rounded-lg hover:bg-opacity-30 transition-all duration-200">
                            <i class="fas fa-phone mr-2"></i>
                            Call Us
                        </a>
                    </div>
                </div>
                
                <!-- Social Media Links -->
                <div class="mt-8 pt-6 border-t border-white border-opacity-20">
                    <p class="text-sm opacity-75 mb-4">Stay updated on our social channels:</p>
                    <div class="flex justify-center space-x-4">
                        <a href="#" class="text-2xl hover:text-blue-300 transition-colors duration-200">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="#" class="text-2xl hover:text-blue-400 transition-colors duration-200">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-2xl hover:text-pink-300 transition-colors duration-200">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-2xl hover:text-blue-500 transition-colors duration-200">
                            <i class="fab fa-linkedin"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="text-center mt-6 text-white opacity-60">
                <p class="text-sm">
                    © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                </p>
            </div>
        </div>
    </div>

    <!-- Auto-refresh script -->
    <script>
        // Auto refresh every 5 minutes to check if maintenance is over
        setTimeout(function() {
            window.location.reload();
        }, 300000); // 5 minutes

        // Add some interactivity
        document.addEventListener('DOMContentLoaded', function() {
            // Animate cards on load
            const cards = document.querySelectorAll('.maintenance-card');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.transform = 'translateY(0)';
                    card.style.opacity = '1';
                }, index * 200);
            });
        });
    </script>
</body>
</html>
