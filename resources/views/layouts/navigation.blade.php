<!DOCTYPE html>
<html lang="ku" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مارکێتی کوردستان - داشبۆرد</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* ========== CSS VARIABLES FOR DARK/LIGHT MODES ========== */
        :root {
            /* Light mode (default) */
            --primary: #4a6491;
            --secondary: #2c3e50;
            --accent: #C084FC;
            --success: #10b981;
            --warning: #f59e0b;
            --error: #ef4444;
            
            /* Background & Text */
            --bg-gradient-start: #4a6491;
            --bg-gradient-end: #2c3e50;
            --body-bg: linear-gradient(135deg, var(--bg-gradient-start), var(--bg-gradient-end));
            --header-bg: rgba(255, 255, 255, 0.98);
            --header-border: rgba(255, 255, 255, 0.2);
            --text-primary: #2c3e50;
            --text-secondary: #666;
            --card-bg: #ffffff;
            --btn-outline-border: #4a6491;
            --btn-outline-color: #4a6491;
            --badge-bg: linear-gradient(135deg, #4a6491, #2c3e50);
            --shadow-color: rgba(0, 0, 0, 0.1);
            --mobile-menu-bg: rgba(255, 255, 255, 0.98);
        }

        /* Dark mode styles - will be applied via JavaScript */
        body.dark-mode {
            --primary: #6c8db8;
            --secondary: #1a2a3a;
            --accent: #D8B4FE;
            --success: #34d399;
            --warning: #fbbf24;
            --error: #f87171;
            
            --bg-gradient-start: #1e293b;
            --bg-gradient-end: #0f172a;
            --body-bg: linear-gradient(135deg, var(--bg-gradient-start), var(--bg-gradient-end));
            --header-bg: rgba(30, 41, 59, 0.98);
            --header-border: rgba(255, 255, 255, 0.1);
            --text-primary: #e2e8f0;
            --text-secondary: #94a3b8;
            --card-bg: #1e293b;
            --btn-outline-border: #6c8db8;
            --btn-outline-color: #6c8db8;
            --badge-bg: linear-gradient(135deg, #6c8db8, #1a2a3a);
            --shadow-color: rgba(0, 0, 0, 0.3);
            --mobile-menu-bg: rgba(30, 41, 59, 0.98);
        }

        * {
            transition: background-color 0.3s ease, color 0.2s ease, border-color 0.3s ease, box-shadow 0.3s ease;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--body-bg);
            min-height: 100vh;
            overflow-x: hidden;
            color: var(--text-primary);
        }

        /* Header Styles - Dynamic */
        .glass {
            background: var(--header-bg);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--header-border);
            box-shadow: 0 4px 30px var(--shadow-color);
        }

        .header-container {
            transition: all 0.3s ease;
        }

        /* User Info Styles */
        .user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .badge-title {
            background: var(--badge-bg);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
        }

        /* Button Styles */
        .btn-responsive {
            padding: 0.375rem 1rem;
            font-size: 0.875rem;
            border-radius: 50px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            min-height: 38px;
        }

        .btn-gradient {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border: none;
            color: white;
        }

        .btn-gradient:hover {
            background: linear-gradient(135deg, #3a5481, #1c2e40);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(74, 100, 145, 0.3);
            color: white;
        }

        body.dark-mode .btn-gradient:hover {
            background: linear-gradient(135deg, #5a7aa3, #1a2a3a);
            box-shadow: 0 4px 15px rgba(108, 141, 184, 0.3);
        }

        .btn-outline-custom {
            border: 1px solid var(--btn-outline-border);
            color: var(--btn-outline-color);
            background: transparent;
        }

        .btn-outline-custom:hover {
            background-color: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        /* Dark Mode Toggle Button */
        .dark-mode-toggle {
            background: transparent;
            border: 1px solid var(--btn-outline-border);
            color: var(--btn-outline-color);
            padding: 0.375rem 0.75rem;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            min-height: 38px;
        }

        .dark-mode-toggle:hover {
            background-color: var(--primary);
            color: white;
            transform: scale(1.05);
        }

        body.dark-mode .dark-mode-toggle i {
            transform: rotate(15deg);
        }

        /* Mobile Menu */
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--text-primary);
            padding: 0.5rem;
            cursor: pointer;
        }

        .mobile-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: var(--mobile-menu-bg);
            backdrop-filter: blur(10px);
            padding: 1rem;
            box-shadow: 0 10px 30px var(--shadow-color);
            z-index: 1000;
        }

        .mobile-menu.active {
            display: block;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Typography */
        .company-name {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-primary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-name {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
        }

        .current-date {
            font-size: 0.8rem;
            color: var(--text-secondary);
        }

        /* Main content placeholder style */
        main {
            background: transparent;
        }

        /* Extra Large Screens (1440px and up) */
        @media (min-width: 1440px) {
            .header-container {
                padding-left: 4rem !important;
                padding-right: 4rem !important;
            }
            .company-name {
                font-size: 1.5rem;
            }
            .btn-responsive {
                padding: 0.5rem 1.5rem;
                font-size: 1rem;
            }
        }

        /* Large Screens (1200px to 1439px) */
        @media (min-width: 1200px) and (max-width: 1439.98px) {
            .company-name {
                font-size: 1.3rem;
            }
            .user-name {
                font-size: 1rem;
            }
        }

        /* Medium Screens (992px to 1199px) - Tablets Landscape */
        @media (min-width: 992px) and (max-width: 1199.98px) {
            .btn-responsive span {
                display: none;
            }
            .btn-responsive {
                padding: 0.5rem;
                width: 40px;
                height: 40px;
            }
            .company-name {
                font-size: 1.1rem;
            }
        }

        /* Small Screens (768px to 991px) - Tablets Portrait */
        @media (min-width: 768px) and (max-width: 991.98px) {
            .header-container {
                padding: 0.75rem 1rem !important;
            }
            .company-name {
                font-size: 1rem;
            }
            .user-avatar {
                width: 35px;
                height: 35px;
                font-size: 1rem;
            }
            .user-name {
                font-size: 0.85rem;
            }
            .badge-title {
                font-size: 0.7rem;
                padding: 0.2rem 0.6rem;
            }
            .btn-responsive {
                min-height: 35px;
                font-size: 0.8rem;
            }
            .desktop-buttons {
                gap: 0.5rem !important;
            }
        }

        /* Extra Small Screens (576px to 767px) - Large Phones */
        @media (min-width: 576px) and (max-width: 767.98px) {
            .header-container {
                padding: 0.5rem !important;
            }
            .company-name {
                font-size: 0.9rem;
            }
            .mobile-menu-btn {
                display: block;
            }
            .desktop-buttons {
                display: none !important;
            }
            .user-info {
                text-align: center;
            }
            .user-name {
                font-size: 0.8rem;
            }
            .current-date {
                font-size: 0.75rem;
            }
        }

        /* Very Small Screens (Below 576px) - Small Phones */
        @media (max-width: 575.98px) {
            .header-container {
                padding: 0.5rem 0.25rem !important;
            }
            .company-name {
                font-size: 0.85rem;
                max-width: 150px;
            }
            .mobile-menu-btn {
                display: block;
                font-size: 1.25rem;
            }
            .desktop-buttons {
                display: none !important;
            }
            .user-avatar {
                width: 32px;
                height: 32px;
                font-size: 0.9rem;
            }
            .user-info {
                text-align: center;
                flex-direction: column;
                align-items: center !important;
                gap: 0.25rem !important;
            }
            .user-name {
                font-size: 0.75rem;
                text-align: center;
            }
            .badge-title {
                font-size: 0.65rem;
                padding: 0.15rem 0.5rem;
            }
            .current-date {
                font-size: 0.7rem;
            }
            .mobile-menu .btn-responsive {
                width: 100%;
                margin-bottom: 0.5rem;
                justify-content: center;
            }
            .mobile-menu .btn-responsive:last-child {
                margin-bottom: 0;
            }
            .dark-mode-toggle {
                width: 100%;
                justify-content: center;
                margin-bottom: 0.5rem;
            }
        }

        /* Extra Small Height Adjustment */
        @media (max-height: 600px) and (max-width: 767.98px) {
            .header-container {
                padding-top: 0.25rem !important;
                padding-bottom: 0.25rem !important;
            }
            .company-name {
                font-size: 0.8rem;
            }
            .user-avatar {
                width: 30px;
                height: 30px;
                font-size: 0.8rem;
            }
        }

        /* Landscape Mode Optimization */
        @media (max-height: 500px) and (orientation: landscape) {
            .header-container {
                position: static !important;
            }
            .company-name {
                font-size: 0.8rem;
            }
            .mobile-menu {
                max-height: 200px;
                overflow-y: auto;
            }
        }

        /* Touch Device Optimizations */
        @media (hover: none) and (pointer: coarse) {
            .btn-responsive {
                min-height: 44px;
            }
            .user-avatar {
                min-width: 44px;
                min-height: 44px;
            }
            .mobile-menu-btn {
                padding: 0.75rem;
            }
            .dark-mode-toggle {
                min-height: 44px;
            }
        }

        /* High DPI Screens */
        @media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
            .glass {
                background: var(--header-bg);
            }
        }

        /* Print Styles */
        @media print {
            .glass {
                background: white !important;
                box-shadow: none !important;
                border-bottom: 1px solid #ddd !important;
            }
            .btn-responsive,
            .mobile-menu-btn,
            .mobile-menu,
            .dark-mode-toggle {
                display: none !important;
            }
            body.dark-mode {
                --text-primary: #000 !important;
                --card-bg: #fff !important;
            }
        }
    </style>
</head>
<body>

<header class="glass sticky-top">
    <div class="container-fluid header-container py-2">
        <div class="row align-items-center g-0">

            <!-- Left: Company Name -->
            <div class="col-4 col-sm-3 col-md-2 col-lg-2 d-flex align-items-center">
                <h1 class="company-name mb-0">
                    مارکێتی کوردستان
                </h1>
            </div>

            <!-- Center: Spacer + Desktop Buttons + Dark Mode Toggle -->
            <div class="col-4 col-md-8 col-lg-7 d-flex justify-content-center align-items-center">
                
                <!-- Mobile Menu Button -->
                <button class="mobile-menu-btn d-md-none" id="mobileMenuBtn" aria-label="بینینی مێنوو">
                    <i class="fas fa-bars"></i>
                </button>

                <!-- Desktop Buttons + Dark Mode Toggle -->
                <div class="desktop-buttons d-none d-md-flex gap-2 align-items-center">
                    <button onclick="window.history.back()" class="btn btn-outline-custom btn-responsive">
                        <i class="fas fa-arrow-right"></i>
                        <span>گەڕانەوە</span>
                    </button>

                    <a href="{{ route('dashboard') }}" class="btn btn-outline-custom btn-responsive">
                        <i class="fas fa-home"></i>
                        <span>ماڵەوە</span>
                    </a>

                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-gradient btn-responsive">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>چوونەدەرەوە</span>
                        </button>
                    </form>

                    <!-- DARK MODE TOGGLE BUTTON (Desktop) -->
                    <button id="darkModeToggle" class="dark-mode-toggle" aria-label="ڕێژەی تاریک/ڕووناک">
                        <i class="fas fa-moon"></i>
                        <span class="toggle-text">تاریک</span>
                    </button>
                </div>
            </div>

            <!-- Right: User Info -->
            <div class="col-4 col-sm-3 col-md-2 col-lg-3">
                <div class="d-flex align-items-center justify-content-end gap-2 user-info">
                    <div class="user-avatar d-none d-md-flex">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="text-end">
                        <div class="user-name">
                            {{ Auth::user()->name }}
                        </div>
                        <div class="d-flex justify-content-end gap-1">
                            <span class="badge-title">admin</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <div class="d-flex flex-column">
            <button onclick="window.history.back()" class="btn btn-outline-custom btn-responsive mb-2">
                <i class="fas fa-arrow-right me-2"></i>
                گەڕانەوە
            </button>

            <a href="{{ route('dashboard') }}" class="btn btn-outline-custom btn-responsive mb-2">
                <i class="fas fa-home me-2"></i>
                ماڵەوە
            </a>

            <form action="{{ route('logout') }}" method="POST" class="w-100 mb-2">
                @csrf
                <button type="submit" class="btn btn-gradient btn-responsive w-100">
                    <i class="fas fa-sign-out-alt me-2"></i>
                    چوونەدەرەوە
                </button>
            </form>

            <!-- DARK MODE TOGGLE BUTTON (Mobile) -->
            <button id="darkModeToggleMobile" class="dark-mode-toggle w-100 justify-content-center">
                <i class="fas fa-moon"></i>
                <span class="toggle-text-mobile">ڕێژەی تاریک</span>
            </button>
        </div>
    </div>
    <span id="screenWidth" hidden></span>
</header>

<!-- Main Content Placeholder -->
<main class="py-4">
    @yield('content')
    
    <!-- Sample content to demonstrate dark mode effect (optional) -->
    @if(trim($__env->yieldContent('content')) == '')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card" style="background: var(--card-bg); border: none; box-shadow: 0 8px 20px var(--shadow-color);">
                    <div class="card-body text-center p-5">
                        <i class="fas fa-store fa-3x mb-3" style="color: var(--primary);"></i>
                        <h3 style="color: var(--text-primary);">بەخێربێیت بۆ داشبۆردی مارکێتی کوردستان</h3>
                        <p style="color: var(--text-secondary);">ئەمە پەڕەی سەرەکییە. تۆ دەتوانیت بەکاربێنی بۆ بەڕێوەبردنی فرۆشگاکەت.</p>
                        <button class="btn btn-gradient mt-3" onclick="alert('ڕێژەی تاریک چالاک/ناچالاک دەکرێت!')">تاقیکردنەوەی تاریک</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</main>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // ========== DARK MODE IMPLEMENTATION (No Refresh) ==========
    (function() {
        // Check for saved theme preference in localStorage
        const savedTheme = localStorage.getItem('kurdistan_market_theme');
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
                localStorage.setItem('kurdistan_market_theme', 'dark');
            } else {
                document.body.classList.remove('dark-mode');
                localStorage.setItem('kurdistan_market_theme', 'light');
            }
            
            // Update all toggle buttons' icons and text
            updateToggleButtons(enabled);
        }
        
        // Update UI elements for both desktop and mobile toggles
        function updateToggleButtons(isDark) {
            // Select all dark mode toggle buttons (both desktop and mobile)
            const toggles = document.querySelectorAll('#darkModeToggle, #darkModeToggleMobile');
            toggles.forEach(toggle => {
                const icon = toggle.querySelector('i');
                const textSpan = toggle.querySelector('.toggle-text') || toggle.querySelector('.toggle-text-mobile');
                
                if (isDark) {
                    if (icon) {
                        icon.classList.remove('fa-moon');
                        icon.classList.add('fa-sun');
                    }
                    if (textSpan) {
                        textSpan.textContent = 'ڕووناک';
                    }
                    toggle.setAttribute('aria-label', 'ڕووناک کردنەوە');
                } else {
                    if (icon) {
                        icon.classList.remove('fa-sun');
                        icon.classList.add('fa-moon');
                    }
                    if (textSpan) {
                        textSpan.textContent = 'تاریک';
                    }
                    toggle.setAttribute('aria-label', 'تاریک کردنەوە');
                }
            });
        }
        
        // Toggle function
        function toggleDarkMode() {
            const currentlyDark = document.body.classList.contains('dark-mode');
            applyDarkMode(!currentlyDark);
        }
        
        // Initialize theme
        applyDarkMode(isDarkMode);
        
        // Add event listeners to both toggle buttons (desktop and mobile)
        const desktopToggle = document.getElementById('darkModeToggle');
        const mobileToggle = document.getElementById('darkModeToggleMobile');
        
        if (desktopToggle) {
            desktopToggle.addEventListener('click', function(e) {
                e.preventDefault();
                toggleDarkMode();
            });
        }
        
        if (mobileToggle) {
            mobileToggle.addEventListener('click', function(e) {
                e.preventDefault();
                toggleDarkMode();
                // Optional: Close mobile menu after clicking toggle on mobile for better UX
                const mobileMenu = document.getElementById('mobileMenu');
                if (mobileMenu && mobileMenu.classList.contains('active')) {
                    mobileMenu.classList.remove('active');
                    const menuBtnIcon = document.querySelector('#mobileMenuBtn i');
                    if (menuBtnIcon) {
                        menuBtnIcon.classList.remove('fa-times');
                        menuBtnIcon.classList.add('fa-bars');
                    }
                }
            });
        }
        
        // Listen for system theme changes
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
            const saved = localStorage.getItem('kurdistan_market_theme');
            // Only auto-switch if user hasn't manually set a preference
            if (!saved) {
                applyDarkMode(e.matches);
            }
        });
    })();

    // ========== MOBILE MENU TOGGLE (Remains same but improved) ==========
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');

    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            mobileMenu.classList.toggle('active');
            const icon = this.querySelector('i');
            if (mobileMenu.classList.contains('active')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
            } else {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            if (mobileMenu && mobileMenuBtn && !mobileMenu.contains(event.target) && !mobileMenuBtn.contains(event.target)) {
                mobileMenu.classList.remove('active');
                const icon = mobileMenuBtn.querySelector('i');
                if (icon) {
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                }
            }
        });
    }

    // Update screen width display (optional debug)
    function updateScreenWidth() {
        const widthSpan = document.getElementById('screenWidth');
        if (widthSpan) widthSpan.textContent = window.innerWidth + 'px';
    }
    updateScreenWidth();
    window.addEventListener('resize', updateScreenWidth);

    // Close mobile menu on window resize
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            if (window.innerWidth >= 768 && mobileMenu && mobileMenu.classList.contains('active')) {
                mobileMenu.classList.remove('active');
                if (mobileMenuBtn) {
                    const icon = mobileMenuBtn.querySelector('i');
                    if (icon) {
                        icon.classList.remove('fa-times');
                        icon.classList.add('fa-bars');
                    }
                }
            }
        }, 250);
    });

    // Touch device detection and feedback
    function isTouchDevice() {
        return 'ontouchstart' in window || navigator.maxTouchPoints;
    }

    if (isTouchDevice()) {
        document.body.classList.add('touch-device');
        document.querySelectorAll('.btn-responsive, .dark-mode-toggle').forEach(btn => {
            btn.addEventListener('touchstart', function() {
                this.style.transform = 'scale(0.95)';
            });
            btn.addEventListener('touchend', function() {
                this.style.transform = '';
            });
            btn.addEventListener('touchcancel', function() {
                this.style.transform = '';
            });
        });
    }
</script>

<!-- Additional style override for dynamic card backgrounds -->
<style>
    /* Ensure any content cards adapt automatically */
    .card, .bg-white, .bg-light {
        background-color: var(--card-bg) !important;
        color: var(--text-primary) !important;
        transition: background-color 0.3s ease, color 0.3s ease;
    }
    
    .text-dark, .text-muted {
        color: var(--text-secondary) !important;
    }
    
    /* Dropdown menus, modals, etc would also inherit */
    .dropdown-menu, .modal-content {
        background-color: var(--card-bg);
        color: var(--text-primary);
        border-color: var(--header-border);
    }
    
    /* Table styling if any */
    .table {
        color: var(--text-primary);
    }
    
    .table-striped > tbody > tr:nth-of-type(odd) {
        background-color: rgba(0, 0, 0, 0.05);
    }
    
    body.dark-mode .table-striped > tbody > tr:nth-of-type(odd) {
        background-color: rgba(255, 255, 255, 0.05);
    }
    
    /* Links */
    a:not(.btn) {
        color: var(--primary);
    }
    
    /* Input fields */
    input, textarea, select {
        background-color: var(--card-bg);
        color: var(--text-primary);
        border-color: var(--header-border);
    }
</style>

</body>
</html>