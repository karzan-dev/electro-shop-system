<?php $__env->startSection('content'); ?>
<style>
    :root {
        --primary: #4a6491;
        --secondary: #2c3e50;
        --accent: #C084FC;
        --success: #10b981;
        --warning: #f59e0b;
        --error: #ef4444;
        --light: #f8f9fa;
        --dark: #212529;
        /* Light mode specific */
        --card-bg: rgba(255, 255, 255, 0.95);
        --glass-bg: rgba(255, 255, 255, 0.95);
        --text-primary: #2c3e50;
        --text-secondary: #6c757d;
        --border-color: rgba(0, 0, 0, 0.1);
        --shadow-color: rgba(0, 0, 0, 0.1);
    }

    /* Dark mode variables - applied via body class */
    body.dark-mode {
        --primary: #6c8db8;
        --secondary: #1e2a3a;
        --accent: #D8B4FE;
        --card-bg: rgba(30, 41, 59, 0.95);
        --glass-bg: rgba(30, 41, 59, 0.97);
        --text-primary: #e2e8f0;
        --text-secondary: #94a3b8;
        --border-color: rgba(255, 255, 255, 0.1);
        --shadow-color: rgba(0, 0, 0, 0.3);
    }

    /* Smooth transitions for all elements */
    * {
        transition: background-color 0.3s ease, color 0.2s ease, border-color 0.3s ease, box-shadow 0.3s ease;
    }

    body {
        background: linear-gradient(135deg, #4a6491, #2c3e50);
        min-height: 100vh;
    }

    body.dark-mode {
        background: linear-gradient(135deg, #1e293b, #0f172a);
    }

    .card-hover {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        border: none;
        overflow: hidden;
        height: 100%;
        border-top: 4px solid transparent;
     
    }

    .card-hover:hover:not(.disabled) {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 25px 50px var(--shadow-color) !important;
        border-image: linear-gradient(135deg, var(--accent), var(--primary)) 1;
    }

    .card-hover.disabled {
        opacity: 0.5;
        cursor: not-allowed;
        filter: grayscale(50%);
    }

    .btn-gradient {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border: none;
        color: white;
        transition: all 0.3s ease;
        font-weight: 600;
    }

    .btn-gradient:hover:not(.disabled) {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(74, 100, 145, 0.4);
        color: white;
        background: linear-gradient(135deg, var(--secondary), var(--primary));
    }

    body.dark-mode .btn-gradient:hover:not(.disabled) {
        box-shadow: 0 6px 20px rgba(108, 141, 184, 0.3);
    }

    /* Floating animations */
    @keyframes float {
        0%, 100% {
            transform: translateY(0px) translateX(0px);
        }
        25% {
            transform: translateY(-20px) translateX(10px);
        }
        50% {
            transform: translateY(0px) translateX(20px);
        }
        75% {
            transform: translateY(20px) translateX(10px);
        }
    }

    .float-element {
        animation: float 20s infinite linear;
    }

    /* RTL specific styles */
    .text-rtl {
        direction: rtl;
    }

    .icon-container {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.25rem;
        box-shadow: 0 8px 25px rgba(74, 100, 145, 0.3);
        transition: all 0.3s ease;
    }

    .card-hover:hover:not(.disabled) .icon-container {
        transform: rotate(5deg) scale(1.1);
        background: linear-gradient(135deg, var(--accent), var(--primary));
        box-shadow: 0 12px 30px rgba(192, 132, 252, 0.4);
    }

    .icon-container i {
        color: white;
        font-size: 1.75rem;
        transition: all 0.3s ease;
    }

    /* Glass effect for cards */
    .glass {
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border-radius: 1rem;
        border: 1px solid var(--border-color);
    }

    /* Card text colors */
    .glass .card-title,
    .glass h3.h6 {
        color: var(--text-primary) !important;
    }

    .glass .text-muted {
        color: var(--text-secondary) !important;
    }

    /* Animation for cards */
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

    .animate-fade-in-up {
        animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        opacity: 0;
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    ::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(135deg, var(--accent), var(--primary));
    }

    /* Grid system for menu */
    .menu-grid {
        display: grid;
        gap: 1.75rem;
        grid-template-columns: repeat(1, 1fr);
        padding: 1rem;
    }

    /* Dark Mode Toggle Button Styles */
    .dark-mode-toggle {
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid var(--border-color);
        color: var(--text-primary);
        padding: 0.5rem 1rem;
        border-radius: 50px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        backdrop-filter: blur(5px);
    }

    .dark-mode-toggle:hover {
        background: var(--primary);
        color: white;
        transform: scale(1.05);
    }

    body.dark-mode .dark-mode-toggle i {
        transform: rotate(15deg);
    }

    /* Responsive design */
    @media (max-width: 575.98px) {
        .menu-grid {
            gap: 1rem;
            padding: 0.25rem;
        }
        .glass.card-hover {
            margin-bottom: 0.75rem;
            padding: 1.25rem !important;
        }
        .icon-container {
            width: 55px;
            height: 55px;
            margin-bottom: 1rem;
        }
        .icon-container i {
            font-size: 1.4rem;
        }
        h3.h6 {
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
        }
        p.text-muted {
            font-size: 0.8rem;
            margin-bottom: 1rem;
            line-height: 1.4;
        }
        .btn-sm {
            padding: 0.375rem 1rem;
            font-size: 0.85rem;
        }
        .dark-mode-toggle {
            padding: 0.375rem 0.75rem;
            font-size: 0.75rem;
        }
    }

    @media (min-width: 576px) {
        .menu-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1.25rem;
        }
        .icon-container {
            width: 60px;
            height: 60px;
        }
        .icon-container i {
            font-size: 1.5rem;
        }
    }

    @media (min-width: 768px) {
        .menu-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
        }
        .icon-container {
            width: 65px;
            height: 65px;
        }
        .icon-container i {
            font-size: 1.6rem;
        }
    }

    @media (min-width: 992px) {
        .menu-grid {
            grid-template-columns: repeat(4, 1fr);
            gap: 1.75rem;
        }
        .icon-container {
            width: 70px;
            height: 70px;
        }
    }

    @media (min-width: 1200px) {
        .menu-grid {
            grid-template-columns: repeat(5, 1fr);
            gap: 2rem;
        }
    }

    @media (min-width: 1600px) {
        .menu-grid {
            grid-template-columns: repeat(6, 1fr);
            gap: 2.5rem;
            max-width: 1800px;
            margin: 0 auto;
        }
        .icon-container {
            width: 80px;
            height: 80px;
        }
        .icon-container i {
            font-size: 2rem;
        }
    }

    /* Touch device optimizations */
    @media (hover: none) and (pointer: coarse) {
        .card-hover:hover:not(.disabled) {
            transform: none;
        }
        .card-hover:active:not(.disabled) {
            transform: scale(0.98);
            transition: transform 0.1s ease;
        }
    }

    /* Print styles */
    @media print {
        .glass {
            background: white !important;
            border: 1px solid #dee2e6 !important;
            box-shadow: none !important;
        }
        .dark-mode-toggle {
            display: none !important;
        }
    }

    /* Accessibility improvements */
    @media (prefers-reduced-motion: reduce) {
        .card-hover,
        .btn-gradient,
        .icon-container,
        .float-element,
        .dark-mode-toggle {
            transition: none !important;
            animation: none !important;
        }
        .card-hover:hover:not(.disabled) {
            transform: none !important;
        }
    }

    /* Grid item animation delay */
    .animate-delay-100 { animation-delay: 100ms; }
    .animate-delay-200 { animation-delay: 200ms; }
    .animate-delay-300 { animation-delay: 300ms; }
    .animate-delay-400 { animation-delay: 400ms; }
    .animate-delay-500 { animation-delay: 500ms; }
    .animate-delay-600 { animation-delay: 600ms; }
    .animate-delay-700 { animation-delay: 700ms; }
    .animate-delay-800 { animation-delay: 800ms; }
    .animate-delay-900 { animation-delay: 900ms; }
    .animate-delay-1000 { animation-delay: 1000ms; }

    /* Card content layout */
    .card-content {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .card-title {
        min-height: 3.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card-description {
        flex-grow: 1;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card-action {
        margin-top: auto;
    }

    custom-radius {
        border-radius: 20px;
    }
</style>

<!-- Dark Mode Toggle Button (Floating or in header) -->


<!-- Main Content -->
<main class="px-4 py-4">
    <!-- Menu Grid -->
    <section class="menu-grid">
        <!-- Card 1 -->
        <div class="glass card-hover p-3 p-md-4 shadow-sm animate-fade-in-up animate-delay-100 rounded-3">
            <a href="<?php echo e(route('reports-warehouse')); ?>" class="d-flex text-decoration-none flex-column align-items-center text-center h-100">
                <div class="icon-container">
                    <i class="fas fa-warehouse"></i>
                </div>
                <h3 class="h6 fw-bold mb-2 card-title" style="color: var(--text-primary);">ڕاپۆرتی ڕەوشی کۆگا</h3>
                <button class="btn btn-sm btn-gradient mt-auto px-3 card-action">
                    بینین <i class="fas fa-arrow-left ms-2"></i>
                </button>
            </a>
        </div>

        <!-- Card 3 -->
        <div class="glass card-hover p-3 p-md-4 shadow-sm animate-fade-in-up animate-delay-300">
            <a href="<?php echo e(route('items-edit')); ?>" class="d-flex text-decoration-none flex-column align-items-center text-center h-100">
                <div class="icon-container">
                    <i class="fas fa-edit"></i>
                </div>
                <h3 class="h6 fw-bold mb-2 card-title" style="color: var(--text-primary);">گۆڕانکاری زانیارییەکانی کاڵا</h3>
                <button class="btn btn-sm btn-gradient mt-auto px-3 card-action">
                    بینین <i class="fas fa-arrow-left ms-2"></i>
                </button>
            </a>
        </div>

        <!-- Card 4 -->
        <div class="glass card-hover p-3 p-md-4 shadow-sm animate-fade-in-up animate-delay-400">
            <a href="<?php echo e(route('register-item')); ?>" class="d-flex text-decoration-none flex-column align-items-center text-center h-100">
                <div class="icon-container">
                    <i class="fas fa-tag"></i>
                </div>
                <h3 class="h6 fw-bold mb-2 card-title" style="color: var(--text-primary);"> زیادکردنی كاڵا بۆ دووکان </h3>
                <button class="btn btn-sm btn-gradient mt-auto px-3 card-action">
                    بینین <i class="fas fa-arrow-left ms-2"></i>
                </button>
            </a>
        </div>

        <!-- Card 5 -->
        <div class="glass card-hover p-3 p-md-4 shadow-sm animate-fade-in-up animate-delay-500">
            <a href="<?php echo e(route('create-barcode')); ?>" class="text-decoration-none d-flex flex-column align-items-center text-center h-100">
                <div class="icon-container">
                    <i class="fas fa-barcode"></i>
                </div>
                <h3 class="h6 fw-bold mb-2 card-title" style="color: var(--text-primary);">چاپکردنی بارکۆد</h3>
                <button class="btn btn-sm btn-gradient mt-auto px-3 card-action">
                    بینین <i class="fas fa-arrow-left ms-2"></i>
                </button>
            </a>
        </div>

        <!-- Card 6 -->
        <div class="glass card-hover p-3 p-md-4 shadow-sm animate-fade-in-up animate-delay-600">
            <a href="<?php echo e(route('Casher-coin')); ?>" class="d-flex text-decoration-none flex-column align-items-center text-center h-100">
                <div class="icon-container">
                    <i class="fas fa-coins"></i>
                </div>
                <h3 class="h6 fw-bold mb-2 card-title" style="color: var(--text-primary);">پێدانی ووردە بەکاشێر</h3>
                <button class="btn btn-sm btn-gradient mt-auto px-3 card-action">
                    بینین <i class="fas fa-arrow-left ms-2"></i>
                </button>
            </a>
        </div>

        <div class="glass card-hover p-3 p-md-4 shadow-sm animate-fade-in-up animate-delay-700">
            <a href="<?php echo e(route('items-loans.index')); ?>" class="d-flex text-decoration-none flex-column align-items-center text-center h-100">
                <div class="icon-container">
                    <i class="fas fa-users"></i>
                </div>
                <h3 class="h6 fw-bold mb-2 card-title" style="color: var(--text-primary);">لیستی قەرزارەکان</h3>
                <button class="btn btn-sm btn-gradient mt-auto px-3 card-action">
                    بینین <i class="fas fa-arrow-left ms-2"></i>
                </button>
            </a>
        </div>

        <div class="glass card-hover p-3 p-md-4 shadow-sm animate-fade-in-up animate-delay-800">
            <a href="<?php echo e(route('sales.index')); ?>" class="d-flex text-decoration-none flex-column align-items-center text-center h-100">
                <div class="icon-container">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <h3 class="h6 fw-bold mb-2 card-title" style="color: var(--text-primary);">فرۆشتن</h3>
                <button class="btn btn-sm btn-gradient mt-auto px-3 card-action">
                    بینین <i class="fas fa-arrow-left ms-2"></i>
                </button>
            </a>
        </div>

        <div class="glass card-hover p-3 p-md-4 shadow-sm animate-fade-in-up animate-delay-1000">
            <a href="<?php echo e(route('stock.index')); ?>" class="d-flex text-decoration-none flex-column align-items-center text-center h-100">
                <div class="icon-container mb-3 d-flex justify-content-center align-items-center">
                    <i class="fas fa-exclamation-circle fa-2x"></i>
                </div>
                <h3 class="h6 fw-bold mb-2 card-title" style="color: var(--text-primary);">ستۆك</h3>
                <button class="btn btn-sm btn-gradient mt-auto px-3 card-action">
                    بینین <i class="fas fa-arrow-left ms-2"></i>
                </button>
            </a>
        </div>

        <div class="glass card-hover p-3 p-md-4 shadow-sm animate-fade-in-up animate-delay-800">
            <a href="<?php echo e(route('create.daily.accounting')); ?>" class="d-flex text-decoration-none flex-column align-items-center text-center h-100">
                <div class="icon-container">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3 class="h6 fw-bold mb-2 card-title" style="color: var(--text-primary);">ژمێریاری ڕۆژانە</h3>
                <button class="btn btn-sm btn-gradient mt-auto px-3 card-action">
                    بینین <i class="fas fa-arrow-left ms-2"></i>
                </button>
            </a>
        </div>
    </section>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // ============================================
    // DARK MODE IMPLEMENTATION - NO REFRESH
    // ============================================
    (function() {
        // Check for saved theme preference in localStorage
        const savedTheme = localStorage.getItem('kurdistan_market_theme_dashboard');
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        
        // Determine initial mode
        let isDarkMode = false;
        if (savedTheme === 'dark') {
            isDarkMode = true;
        } else if (savedTheme === 'light') {
            isDarkMode = false;
        } else if (prefersDark) {
            isDarkMode = true;
        }
        
        // Function to apply dark mode class to body
        function applyDarkMode(enabled) {
            if (enabled) {
                document.body.classList.add('dark-mode');
                localStorage.setItem('kurdistan_market_theme_dashboard', 'dark');
            } else {
                document.body.classList.remove('dark-mode');
                localStorage.setItem('kurdistan_market_theme_dashboard', 'light');
            }
            
            // Update toggle button UI
         
        }
        
        // Update the toggle button icon and text
     
        
        // Toggle function
        function toggleDarkMode() {
            const currentlyDark = document.body.classList.contains('dark-mode');
            applyDarkMode(!currentlyDark);
        }
        
        // Initialize theme
        applyDarkMode(isDarkMode);
        
        // Add event listener to toggle button
     

        
        // Listen for system theme changes
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
            const saved = localStorage.getItem('kurdistan_market_theme_dashboard');
            // Only auto-switch if user hasn't manually set a preference
            if (!saved) {
                applyDarkMode(e.matches);
            }
        });
    })();

    // ============================================
    // EXISTING FUNCTIONS (preserved)
    // ============================================
    
    function notAllowed() {
        Swal.fire({
            title: 'هەڵەیەك ڕویدا',
            text: 'ئەم بەکارهێنەی تۆ توانای بینینی ئەم بەشەی نیە، ڕێگەپێدراو نیت',
            icon: 'warning',
            confirmButtonText: 'باشە',
            confirmButtonColor: '#4a6491',
            customClass: {
                popup: 'rounded-3',
                title: 'text-primary fw-bold',
                confirmButton: 'btn-gradient py-2 px-4'
            }
        });
    }

    // Enhanced card click animation
    document.addEventListener('click', function(e) {
        const card = e.target.closest('.card-hover:not(.disabled)');
        if(card) {
            card.style.transform = 'scale(0.97)';
            setTimeout(() => {
                card.style.transform = '';
            }, 150);
        }
    });

    // Handle disabled cards
    document.querySelectorAll('.card-hover.disabled').forEach(card => {
        if (card) {
            card.addEventListener('click', function(e) {
                e.preventDefault();
                notAllowed();
            });
        }
    });

    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if(e.key === 'Escape') {
            console.log('Escape pressed - navigation action');
        }

        // Number shortcuts for cards (1-9)
        if(e.key >= '1' && e.key <= '9') {
            const index = parseInt(e.key) - 1;
            const cards = document.querySelectorAll('.card-hover:not(.disabled)');
            if(cards[index]) {
                cards[index].click();
            }
        }
    });

    // Touch device detection and optimization
    if ('ontouchstart' in window || navigator.maxTouchPoints) {
        document.body.classList.add('touch-device');
        document.querySelectorAll('.card-hover:not(.disabled)').forEach(card => {
            card.style.cursor = 'pointer';
        });
    }

    // Initialize animations on page load
    document.addEventListener('DOMContentLoaded', function() {
        document.body.classList.add('loaded');
        window.dispatchEvent(new Event('resize'));

        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl, {
                placement: 'top',
                trigger: 'hover'
            });
        });

        // Add accessibility attributes
        document.querySelectorAll('.card-hover').forEach((card, index) => {
            card.setAttribute('tabindex', '0');
            card.setAttribute('role', 'button');
            const titleEl = card.querySelector('.card-title');
            if (titleEl) {
                card.setAttribute('aria-label', `کرتە بکە بۆ ${titleEl.textContent}`);
            }

            card.addEventListener('keydown', function(e) {
                if(e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    this.click();
                }
            });
        });

        // Lazy load animations with Intersection Observer
        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if(entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.querySelectorAll('.animate-fade-in-up').forEach(el => {
            observer.observe(el);
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamnp64\www\mobileHardy\resources\views/dashboard.blade.php ENDPATH**/ ?>