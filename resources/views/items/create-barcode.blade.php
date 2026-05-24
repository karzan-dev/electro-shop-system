@extends('layouts.navigation')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
   :root {
        --primary: #4a6491;
        --primary-dark: #2c3e50;
        --secondary: #5d7ab0;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --info: #3b82f6;
        --return: #8b5cf6;
        --morning: #f59e0b;
        --afternoon: #3b82f6;
        --night: #1e293b;
        --text: #1e293b;
        --border-color: #e2e8f0;
        --bg-light: #f8fafc;
        --transition-base: all 0.3s ease;
        --accent: var(--primary);
        
        /* Light mode variables */
        --card-bg: #ffffff;
        --body-bg: #f1f5f9;
        --header-bg: rgba(255, 255, 255, 0.98);
        --shadow-color: rgba(0, 0, 0, 0.1);
    }

    /* Dark mode class */
    body.dark-mode {
        --primary: #6c8db8;
        --primary-dark: #1a2a3a;
        --secondary: #4a6a8a;
        --accent: #D8B4FE;
        --text: #e2e8f0;
        --border-color: #334155;
        --bg-light: #1e293b;
        --card-bg: #1e293b;
        --body-bg: #0f172a;
        --header-bg: rgba(30, 41, 59, 0.98);
        --shadow-color: rgba(0, 0, 0, 0.3);
    }
    
    body {
        background: var(--body-bg);
        font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
        transition: background-color 0.3s ease, color 0.3s ease;
        color: var(--text);
    }

    /* Card and container dark mode support */
    .card {
        background-color: var(--card-bg) !important;
        transition: background-color 0.3s ease, color 0.3s ease;
    }
    
    .card-body {
        background-color: var(--card-bg);
    }
    
    .form-header-custom {
        background: linear-gradient(135deg, var(--secondary), var(--primary-dark));
        border-radius: 0.75rem 0.75rem 0 0 !important;
    }

    .form-logo-custom {
        background-color: white;
        width: 80px;
        height: 80px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        box-shadow: 0 10px 20px rgba(0,0,0,0.15);
        transition: background-color 0.3s ease;
    }
    
    body.dark-mode .form-logo-custom {
        background-color: #2d3748;
    }

    .form-logo-custom i {
        font-size: 2.5rem;
        background: linear-gradient(135deg, var(--primary), var(--accent));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .section-title-custom {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid var(--accent);
    }

    .search-container { position: relative; }

    .search-wrapper {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px var(--shadow-color);
        border: 2px solid var(--primary);
        transition: all 0.3s ease;
    }

    .search-wrapper:focus-within {
        box-shadow: 0 6px 20px rgba(74,100,145,0.3);
        border-color: var(--accent);
    }

    .search-input {
        width: 100%;
        padding: 1rem 1rem 1rem 4rem !important;
        border: none !important;
        font-size: 1.1rem;
        background: linear-gradient(135deg, #1e3a5f, #1e40af) !important;
        color: rgba(255,255,255,0.95) !important;
    }

    .search-input::placeholder { color: #bfdbfe; }

    .barcode-search-wrapper {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px var(--shadow-color);
        border: 2px solid var(--primary);
        transition: all 0.3s ease;
    }

    .barcode-search-wrapper:focus-within {
        box-shadow: 0 6px 20px rgba(74,100,145,0.3);
        border-color: var(--accent);
    }

    .barcode-search-input {
        width: 100%;
        padding: 1rem 3.2rem 1rem 4rem !important;
        border: none !important;
        font-size: 1.1rem;
        background: linear-gradient(135deg, #064e3b, #047857) !important;
        color: rgba(255,255,255,0.95) !important;
    }

    .barcode-search-input::placeholder { color: #a7f3d0; }

    .search-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--primary);
        z-index: 10;
        font-size: 1.3rem;
    }

    .barcode-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #10b981;
        z-index: 10;
        font-size: 1.3rem;
    }

    .barcode-scan-btn {
        position: absolute;
        right: 0.6rem;
        top: 50%;
        transform: translateY(-50%);
        z-index: 5;
        width: 38px;
        height: 38px;
        border-radius: 8px;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border: none;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 1.1rem;
        transition: all 0.2s ease;
        box-shadow: 0 2px 8px rgba(74,100,145,0.35);
    }
    .barcode-scan-btn:hover {
        transform: translateY(-50%) scale(1.1);
        box-shadow: 0 4px 14px rgba(74,100,145,0.55);
    }

    .scanner-modal {
        display: none;
        position: fixed;
        z-index: 20000;
        left: 0; top: 0;
        width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.95);
        backdrop-filter: blur(10px);
    }
    .scanner-container {
        position: relative;
        width: 100%; height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }
    #qr-reader { width: 100%; max-width: 450px; border-radius: 20px; overflow: hidden; }
    #qr-reader video { width: 100% !important; }
    .scanner-close {
        position: absolute;
        top: 20px;
        right: 20px;
        background: rgba(255,255,255,0.2);
        border: none;
        width: 44px;
        height: 44px;
        border-radius: 50%;
        color: white;
        font-size: 24px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .scanner-instruction {
        color: white;
        text-align: center;
        margin-top: 20px;
        font-size: 13px;
        background: rgba(0,0,0,0.5);
        padding: 8px 16px;
        border-radius: 30px;
    }

    .name-search-results,
    .barcode-search-results {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        box-shadow: 0 10px 30px var(--shadow-color);
        z-index: 1000;
        max-height: 300px;
        overflow-y: auto;
        display: none;
    }

    .name-search-item, .barcode-search-item {
        padding: 0.75rem 1rem;
        cursor: pointer;
        border-bottom: 1px solid var(--border-color);
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: space-between;
        color: var(--text);
    }

    .name-search-item:hover, .barcode-search-item:hover { background-color: rgba(74,100,145,0.1); }

    .product-barcode-badge {
        font-size: 0.75rem;
        background: var(--info);
        color: white;
        padding: 0.2rem 0.5rem;
        border-radius: 4px;
    }

    .product-image-small {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 6px;
        border: 2px solid var(--primary);
        margin-left: 10px;
    }

    .product-info-card {
        background: linear-gradient(135deg, var(--bg-light), var(--border-color));
        border-radius: 16px;
        padding: 20px;
        border: 2px solid var(--primary);
        box-shadow: 0 8px 25px var(--shadow-color);
    }

    .product-info-card .product-image-large {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 12px;
        border: 3px solid var(--primary);
        cursor: zoom-in;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .product-info-card .product-image-large:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 16px rgba(74,100,145,0.35);
    }

    .product-info-card .info-label {
        font-size: 0.8rem;
        color: var(--text);
        opacity: 0.7;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .product-info-card .info-value {
        font-size: 1rem;
        font-weight: 700;
        color: var(--text);
    }

    .product-info-card .company-badge {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-block;
    }

    .product-info-card .price-badge {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #92400e;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 700;
        display: inline-block;
    }
    
    body.dark-mode .product-info-card .company-badge {
        background: linear-gradient(135deg, var(--primary-dark), var(--secondary));
        color: #e2e8f0;
    }
    
    body.dark-mode .product-info-card .price-badge {
        background: linear-gradient(135deg, #92400e, #b45309);
        color: #fef3c7;
    }

    .barcode-preview {
        background: var(--card-bg);
        padding: 1.5rem;
        border-radius: 16px;
        text-align: center;
        margin: 1rem 0;
        border: 1px dashed var(--primary);
    }

    .barcode-label {
        display: inline-block;
        margin: 10px;
        padding: 10px 12px;
        background: var(--card-bg);
        border-radius: 8px;
        box-shadow: 0 2px 8px var(--shadow-color);
        text-align: center;
        min-width: 120px;
        vertical-align: top;
        cursor: default;
        border: 1px solid var(--border-color);
    }

    .barcode-label canvas { display: block; margin: 0 auto; }

    .barcode-label .product-name {
        font-size: 11px;
        margin-top: 5px;
        font-weight: bold;
        color: var(--text);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 140px;
    }

    .barcode-label .product-company {
        font-size: 10px;
        margin-top: 2px;
        color: var(--text);
        opacity: 0.7;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 140px;
    }

    .barcode-label .product-price {
        font-size: 12px;
        margin-top: 4px;
        color: #e53e3e;
        font-weight: bold;
    }
    
    body.dark-mode .barcode-label .product-price {
        color: #f87171;
    }

    .print-area {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 10px;
    }

    @media print {
        .no-print { display: none !important; }
        .print-area { display: flex !important; }
        .barcode-label { page-break-inside: avoid; break-inside: avoid; }
    }

    .btn-custom-primary {
        background: linear-gradient(135deg, var(--primary), var(--accent));
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.75rem 2rem;
        box-shadow: 0 4px 15px var(--shadow-color);
        transition: all 0.3s ease;
    }

    body.dark-mode .btn-custom-primary {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.75rem 2rem;
        box-shadow: 0 4px 15px var(--shadow-color);
        transition: all 0.3s ease;
    }

    .btn-custom-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(74,100,145,0.4);
        color: white;
    }

    .btn-custom-secondary {
        background-color: var(--card-bg);
        color: var(--primary);
        border: 2px solid var(--primary);
        font-weight: 600;
        padding: 0.75rem 2rem;
        transition: all 0.3s ease;
    }
    
    .btn-custom-secondary:hover {
        background-color: var(--primary);
        color: white;
    }

    .custom-alert {
        border-radius: 12px;
        border: none;
        padding: 16px 20px;
        margin-bottom: 20px;
        box-shadow: 0 4px 12px var(--shadow-color);
        display: flex;
        align-items: center;
        animation: slideDown 0.3s ease-out;
        position: relative;
        overflow: hidden;
    }

    .alert-success-custom { background: #10b981; color: #065f46; border-left: 5px solid var(--success); }
    .alert-error-custom   { background: #ef4444; color: #7f1d1d; border-left: 5px solid var(--danger); }
    .alert-warning-custom { background: #f59e0b; color: #78350f; border-left: 5px solid var(--warning); }
    .alert-info-custom    { background: #3b82f6; color: #1e3a8a; border-left: 5px solid var(--info); }
    
    body.dark-mode .alert-success-custom { background: #065f46; color: #a7f3d0; }
    body.dark-mode .alert-error-custom { background: #7f1d1d; color: #fecaca; }
    body.dark-mode .alert-warning-custom { background: #78350f; color: #fde68a; }
    body.dark-mode .alert-info-custom { background: #1e3a8a; color: #bfdbfe; }

    .alert-icon    { font-size: 1.5rem; margin-left: 15px; flex-shrink: 0; }
    .alert-content { flex-grow: 1; }
    .alert-title   { font-weight: 700; margin-bottom: 5px; }
    .alert-close   { background: none; border: none; opacity: 0.7; cursor: pointer; font-size: 1.2rem; color: inherit; }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-20px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    #img-modal {
        display: none;
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0,0,0,0.82);
        z-index: 99999;
        align-items: center;
        justify-content: center;
        cursor: zoom-out;
        animation: fadeIn 0.2s ease;
    }

    #img-modal.active { display: flex; }

    #img-modal img {
        max-width: 88vw;
        max-height: 88vh;
        border-radius: 14px;
        box-shadow: 0 24px 80px rgba(0,0,0,0.6);
        border: 3px solid rgba(255,255,255,0.15);
        pointer-events: none;
    }

    #img-modal-close {
        position: absolute;
        top: 18px; right: 22px;
        color: white;
        font-size: 2rem;
        cursor: pointer;
        line-height: 1;
        opacity: 0.8;
        transition: opacity 0.2s;
        background: none;
        border: none;
    }

    #img-modal-close:hover { opacity: 1; }

    @keyframes fadeIn {
        from { opacity: 0; }
        to   { opacity: 1; }
    }
    
    /* Dark Mode Toggle Button Styling */

    /* Form controls dark mode */
    .form-control, .form-control-lg {
        background-color: var(--card-bg);
        color: var(--text);
        border-color: var(--border-color);
    }
    
    .form-control:focus {
        background-color: var(--card-bg);
        color: var(--text);
        border-color: var(--primary);
    }
    
    .form-label {
        color: var(--text);
    }
</style>

<!-- Image Modal -->
<div id="img-modal" onclick="closeModal(event)">
    <button id="img-modal-close" onclick="$('#img-modal').removeClass('active')">✕</button>
    <img id="img-modal-src" src="" alt="وێنەی کاڵا">
</div>

<!-- Scanner Modal -->
<div id="scannerModal" class="scanner-modal">
    <div class="scanner-container">
        <button class="scanner-close" onclick="closeScanner()"><i class="fas fa-times"></i></button>
        <div id="qr-reader"></div>
        <div class="scanner-instruction">
            <i class="fas fa-camera"></i> بارکۆدەکە بخەرە بەردەم کامێرا
        </div>
    </div>
</div>

<!-- Dark Mode Toggle Button -->


<div id="alert-container" style="position:fixed;top:20px;right:20px;z-index:9999;width:350px;"></div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-11">
            <div class="card shadow-lg border-0 overflow-hidden">

                <!-- Header -->
                <div class="card-header form-header-custom text-white text-center py-4">
                    <div class="form-logo-custom">
                        <i class="fas fa-print"></i>
                    </div>
                    <h1 class="h2 mb-2">چاپکردنی بارکۆد</h1>
                    <p class="mb-0 opacity-75">بارکۆدی کاڵا بدۆزەوە و ژمارەی چاپ دیاری بکە</p>
                </div>

                <div class="card-body p-4 p-md-5">

                    <!-- Search Section -->
                    <div class="mb-5">
                        <h3 class="section-title-custom">
                            <i class="fas fa-search ms-2"></i>گەڕان بەدوای کاڵادا
                        </h3>
                        
                        <div class="row mb-4">
                            <!-- Barcode Search -->
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-barcode"></i> بارکۆد
                                </label>
                                <div class="search-container">
                                    <div class="barcode-search-wrapper">
                                        <i class="fas fa-barcode barcode-icon"></i>
                                        <input type="text" id="barcode-search" class="form-control barcode-search-input"
                                               placeholder="بارکۆد بنووسە یان سکان بکە..." autocomplete="off">
                                        <button type="button" id="scan-barcode-btn" class="barcode-scan-btn" title="سکانکردنی بارکۆد">
                                            <i class="fas fa-camera"></i>
                                        </button>
                                    </div>
                                    <div id="barcode-search-results" class="barcode-search-results"></div>
                                </div>
                            </div>
                            
                            <!-- Name Search -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-tag"></i> ناوی کاڵا
                                </label>
                                <div class="search-container">
                                    <div class="search-wrapper">
                                        <i class="fas fa-search search-icon"></i>
                                        <input type="text" id="name-search" class="form-control search-input"
                                               placeholder="ناوی کاڵا بنووسە..." autocomplete="off">
                                    </div>
                                    <div id="name-search-results" class="name-search-results"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div id="product-info" class="mb-5" style="display:none;">
                        <h3 class="section-title-custom">
                            <i class="fas fa-info-circle ms-2"></i>زانیاری کاڵا
                        </h3>
                        <div class="product-info-card">
                            <div class="row align-items-center">
                                <div class="col-auto text-center">
                                    <img id="disp-image" src="" alt="وێنەی کاڵا" class="product-image-large"
                                         style="display:none;cursor:zoom-in;"
                                         onclick="openModal(this.src)">
                                    <div id="disp-image-placeholder" style="width:80px;height:80px;border-radius:12px;background:#cbd5e1;display:flex;align-items:center;justify-content:center;">
                                        <i class="fas fa-box" style="font-size:2rem;color:#64748b;"></i>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <span class="info-label">📦 ناوی کاڵا</span><br>
                                            <span class="info-value" id="disp-name">---</span>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <span class="info-label">🏢 کۆمپانیا</span><br>
                                            <span id="disp-company" class="company-badge">---</span>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <span class="info-label">🏷️ بارکۆد</span><br>
                                            <span class="info-value" id="disp-barcode">---</span>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <span class="info-label">💰 نرخی فرۆشتن</span><br>
                                            <span id="disp-price" class="price-badge">---</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Print Settings -->
                    <div class="mb-5">
                        <h3 class="section-title-custom">
                            <i class="fas fa-cog ms-2"></i>ڕێکخستنەکانی چاپ
                        </h3>
                        <div class="row align-items-end">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">ژمارەی چاپ (کۆپی)</label>
                                <input type="number" id="copy-count" class="form-control form-control-lg"
                                       value="1" min="1" max="100">
                            </div>
                            <div class="col-md-6 mb-3">
                                <button id="generate-btn" class="btn btn-custom-primary w-100">
                                    <i class="fas fa-qrcode ms-2"></i>دروستکردنی بارکۆد
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Barcode Preview -->
                    <div id="barcode-preview-area" class="barcode-preview no-print" style="display:none;">
                        <h5 class="text-center mb-3">لیستیی بارکۆدەکان</h5>
                        <div id="barcode-container" class="print-area"></div>
                        <div class="d-flex justify-content-center mt-4 gap-3">
                            <button id="print-btn" class="btn btn-custom-primary">
                                <i class="fas fa-print ms-2"></i>چاپکردن
                            </button>
                            <button id="clear-btn" class="btn btn-custom-secondary">
                                <i class="fas fa-trash-alt ms-2"></i>پاککردنەوە
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>

// ==================== DARK MODE IMPLEMENTATION with localStorage ====================
(function() {
    // Check for saved theme preference
    const savedTheme = localStorage.getItem('kurdistan_barcode_theme');
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    
    let isDarkMode = savedTheme === 'dark' || (savedTheme === null && prefersDark);
    
    function applyDarkMode(enabled) {
        if (enabled) {
            document.body.classList.add('dark-mode');
            localStorage.setItem('kurdistan_barcode_theme', 'dark');
        } else {
            document.body.classList.remove('dark-mode');
            localStorage.setItem('kurdistan_barcode_theme', 'light');
        }
    }
    
    // Initialize
    applyDarkMode(isDarkMode);
    
    // Event listener for toggle button (will be bound when DOM ready)
    $(document).ready(function() {
        $('#darkModeToggle').on('click', function() {
            isDarkMode = !isDarkMode;
            applyDarkMode(isDarkMode);
            const icon = $('#darkModeToggle i');
            if (isDarkMode) {
                icon.removeClass('fa-moon').addClass('fa-sun');
            } else {
                icon.removeClass('fa-sun').addClass('fa-moon');
            }
        });
        
        // Set initial icon
        const icon = $('#darkModeToggle i');
        if (isDarkMode) {
            icon.removeClass('fa-moon').addClass('fa-sun');
        } else {
            icon.removeClass('fa-sun').addClass('fa-moon');
        }
    });
    
    // Listen for system theme changes (only if no saved preference)
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
        const saved = localStorage.getItem('kurdistan_barcode_theme');
        if (!saved) {
            applyDarkMode(e.matches);
            isDarkMode = e.matches;
        }
    });
})();

// ==================== SCANNER FUNCTIONS (FIXED) ====================
let html5QrCode = null;
let isScannerRunning = false;
let isScannerInitialized = false;

function onScanSuccess(decodedText) {
    const normalizedBarcode = normalizeToEnglishNumbers(decodedText);
    closeScanner();
    $('#barcode-search').val(normalizedBarcode);
    searchByExactBarcode(normalizedBarcode);
}

function onScanFailure(error) {
    // Silently handle scan failures - this is normal when no barcode is detected
    // console.warn(`Scan error: ${error}`);
}

async function startScanner() {
    try {
        // Clean up any existing scanner first
        if (html5QrCode) {
            if (isScannerRunning) {
                try {
                    await html5QrCode.stop();
                } catch (stopError) {
                    console.log('Error stopping scanner:', stopError);
                }
            }
            html5QrCode = null;
            isScannerRunning = false;
            isScannerInitialized = false;
        }
        
        // Clear the reader container
        const readerElement = document.getElementById('qr-reader');
        if (readerElement) {
            readerElement.innerHTML = '';
        }
        
        // Create new scanner instance
        html5QrCode = new Html5Qrcode("qr-reader");
        isScannerInitialized = true;
        
        // Start scanning
        await html5QrCode.start(
            { facingMode: "environment" },
            {
                fps: 10,
                qrbox: { width: 250, height: 200 },
                aspectRatio: 1.0
            },
            onScanSuccess,
            onScanFailure
        );
        
        isScannerRunning = true;
        console.log('Scanner started successfully');
    } catch (err) {
        console.error('Error starting scanner:', err);
        showAlert('error', 'هەڵە', 'نەتوانرا کامێرا دەستپێبکرێت. تکایە ڕێگەپێدانی کامێرا پشکنین بکە.');
        closeScanner();
    }
}

async function closeScanner() {
    try {
        if (html5QrCode && isScannerRunning) {
            await html5QrCode.stop();
            isScannerRunning = false;
        }
        if (html5QrCode) {
            html5QrCode.clear();
            html5QrCode = null;
        }
        isScannerInitialized = false;
    } catch (err) {
        console.error('Error closing scanner:', err);
    } finally {
        $('#scannerModal').hide();
        // Clear the reader container to prevent issues when reopening
        const readerElement = document.getElementById('qr-reader');
        if (readerElement) {
            readerElement.innerHTML = '';
        }
    }
}

function openScanner() {
    $('#scannerModal').show();
    // Small delay to ensure modal is visible before starting scanner
    setTimeout(() => {
        startScanner();
    }, 100);
}

$(document).ready(function() {
    $("#name-search").focus();
});

// ==================== GLOBAL FUNCTIONS ====================

function openModal(src) {
    if (!src) return;
    $('#img-modal-src').attr('src', src);
    $('#img-modal').addClass('active');
}

function closeModal(e) {
    if (!e || e.target === document.getElementById('img-modal')) {
        $('#img-modal').removeClass('active');
    }
}

function normalizeToEnglishNumbers(str) {
    if (!str) return str;
    const kurdishNumbers = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
    const persianNumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    const englishNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
    let result = str.toString();
    for (let i = 0; i < kurdishNumbers.length; i++) {
        result = result.replace(new RegExp(kurdishNumbers[i], 'g'), englishNumbers[i]);
    }
    for (let i = 0; i < persianNumbers.length; i++) {
        result = result.replace(new RegExp(persianNumbers[i], 'g'), englishNumbers[i]);
    }
    result = result.replace(/[^0-9A-Za-z\-\_]/g, '');
    return result;
}

function enableBarcodeNormalizationForField(selector) {
    $(selector).on('input', function() {
        const originalValue = $(this).val();
        const normalizedValue = normalizeToEnglishNumbers(originalValue);
        if (originalValue !== normalizedValue) {
            const cursorPosition = this.selectionStart;
            $(this).val(normalizedValue);
            this.setSelectionRange(cursorPosition, cursorPosition);
        }
    });
}

enableBarcodeNormalizationForField('#barcode-search');

$(document).ready(function () {
    let selectedProduct = null;
    let nameSearchDebounceTimer = null;
    let barcodeSearchDebounceTimer = null;

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    function getImageUrl(imagePath) {
        if (!imagePath || imagePath === 'null') return null;
        const base = '{{ url("/") }}';
        if (imagePath.startsWith('http')) return imagePath;
        if (imagePath.startsWith('/')) return base + imagePath;
        if (imagePath.startsWith('images/')) return base + '/' + imagePath;
        return base + '/images/products/' + imagePath;
    }

    function formatPrice(val) {
        if (!val && val !== 0) return '';
        return Number(val).toLocaleString() + ' د';
    }

    function escapeHtml(str) {
        if (!str) return '';
        return String(str).replace(/[&<>]/g, function(m) {
            if (m === '&') return '&amp;';
            if (m === '<') return '&lt;';
            if (m === '>') return '&gt;';
            return m;
        });
    }

    window.showAlert = function(type, title, message, duration = 5000) {
        const map = {
            success: ['fas fa-check-circle', 'alert-success-custom'],
            error: ['fas fa-exclamation-circle', 'alert-error-custom'],
            warning: ['fas fa-exclamation-triangle', 'alert-warning-custom'],
            info: ['fas fa-info-circle', 'alert-info-custom'],
        };
        const [icon, cls] = map[type] || map.info;
        const id = 'alert-' + Date.now();
        $('#alert-container').prepend(`
            <div id="${id}" class="custom-alert ${cls} mb-3">
                <i class="${icon} alert-icon"></i>
                <div class="alert-content">
                    <div class="alert-title">${escapeHtml(title)}</div>
                    <div class="alert-message">${escapeHtml(message)}</div>
                </div>
                <button class="alert-close" onclick="$('#${id}').fadeOut(300,function(){$(this).remove();})">×</button>
            </div>
        `);
        if (duration > 0) setTimeout(() => $(`#${id}`).fadeOut(300, function(){ $(this).remove(); }), duration);
    };

    function hideNameResults() { $('#name-search-results').hide().empty(); }
    function hideBarcodeResults() { $('#barcode-search-results').hide().empty(); }

    function searchByName(term) {
        if (!term || term.length < 2) { hideNameResults(); return; }
        $.ajax({
            url: '{{ route("products.searchByName") }}',
            type: 'POST',
            data: { name: term },
            success: function (res) {
                if (res.success && res.products && res.products.length) {
                    let html = '';
                    res.products.forEach(p => {
                        const imgPath = p.image_producte_path || p.image_product_camera;
                        const imgUrl = getImageUrl(imgPath);
                        const imgTag = imgUrl ? `<img src="${imgUrl}" class="product-image-small" onerror="this.style.display='none'">` : `<i class="fas fa-box text-muted me-2" style="font-size:1.4rem;"></i>`;
                        html += `<div class="name-search-item" data-product='${JSON.stringify(p).replace(/'/g,"&#39;")}'>
                                    <div class="d-flex align-items-center">
                                        ${imgTag}
                                        <div class="me-2">
                                            <div class="fw-semibold">${escapeHtml(p.name || '')}</div>
                                            <div class="small text-muted">${escapeHtml(p.company || 'بێ کۆمپانیا')}</div>
                                            <div class="small">بارکۆد: ${escapeHtml(p.barcode || '')}</div>
                                        </div>
                                    </div>
                                    <span class="product-barcode-badge">${escapeHtml(p.barcode || '')}</span>
                                </div>`;
                    });
                    $('#name-search-results').html(html).show();
                } else {
                    $('#name-search-results').html('<div class="name-search-item text-center text-muted py-2">کاڵا نەدۆزرایەوە</div>').show();
                }
            }
        });
    }

    function searchByBarcode(term) {
        if (!term || term.length < 1) { hideBarcodeResults(); return; }
        const normalizedTerm = normalizeToEnglishNumbers(term);
        $.ajax({
            url: '{{ route("barcode.searchByBarcode") }}',
            type: 'POST',
            data: { barcode: normalizedTerm },
            success: function (res) {
                if (res.success && res.products && res.products.length) {
                    let html = '';
                    res.products.forEach(p => {
                        const imgPath = p.image_producte_path || p.image_product_camera;
                        const imgUrl = getImageUrl(imgPath);
                        const imgTag = imgUrl ? `<img src="${imgUrl}" class="product-image-small" onerror="this.style.display='none'">` : `<i class="fas fa-box text-muted me-2" style="font-size:1.4rem;"></i>`;
                        html += `<div class="barcode-search-item" data-product='${JSON.stringify(p).replace(/'/g,"&#39;")}'>
                                    <div class="d-flex align-items-center">
                                        ${imgTag}
                                        <div class="me-2">
                                            <div class="fw-semibold">${escapeHtml(p.name || '')}</div>
                                            <div class="small text-muted">${escapeHtml(p.company || 'بێ کۆمپانیا')}</div>
                                            <div class="small">بارکۆد: ${escapeHtml(p.barcode || '')}</div>
                                        </div>
                                    </div>
                                    <span class="product-barcode-badge">${escapeHtml(p.barcode || '')}</span>
                                </div>`;
                    });
                    $('#barcode-search-results').html(html).show();
                } else {
                    $('#barcode-search-results').html('<div class="barcode-search-item text-center text-muted py-2">کاڵا نەدۆزرایەوە</div>').show();
                }
            }
        });
    }

    window.searchByExactBarcode = function(barcode) {
        if (!barcode) return;
        const normalizedBarcode = normalizeToEnglishNumbers(barcode);
        $.ajax({
            url: '{{ route("barcode.searchByBarcode") }}',
            type: 'POST',
            data: { barcode: normalizedBarcode },
            success: function(res) {
                if (res.success && res.products && res.products.length === 1) {
                    displayProductInfo(res.products[0]);
                    $('#barcode-search').val('');
                    hideBarcodeResults();
                    showAlert('success', 'دۆزرایەوە', 'کاڵاکە دۆزرایەوە');
                } else if (res.success && res.products && res.products.length > 1) {
                    searchByBarcode(normalizedBarcode);
                } else {
                    showAlert('warning', 'نەدۆزرایەوە', 'هیچ کاڵایەک بەم بارکۆدە نەدۆزرایەوە');
                }
            }
        });
    };

    function displayProductInfo(product) {
        selectedProduct = product;
        $('#disp-name').text(product.name || '---');
        $('#disp-company').text(product.company || 'بێ کۆمپانیا');
        $('#disp-barcode').text(product.barcode || '---');
        $('#disp-price').text(product.selling_price ? formatPrice(product.selling_price) : '---');
        const imgPath = product.image_producte_path || product.image_product_camera;
        const imgUrl = getImageUrl(imgPath);
        if (imgUrl) {
            $('#disp-image').attr('src', imgUrl).show();
            $('#disp-image-placeholder').hide();
        } else {
            $('#disp-image').hide();
            $('#disp-image-placeholder').show();
        }
        $('#product-info').show();
        $('#barcode-container').empty();
        $('#barcode-preview-area').hide();
    }

    function generateBarcodes() {
        if (!selectedProduct || !selectedProduct.barcode) {
            showAlert('warning', 'ئاگاداری', 'تکایە یەکەمجار کاڵایەک هەڵبژێرە');
            return;
        }
        const normalizedBarcode = normalizeToEnglishNumbers(selectedProduct.barcode);
        let copies = parseInt($('#copy-count').val());
        if (isNaN(copies) || copies < 1) copies = 1;
        if (copies > 100) copies = 100;
        const container = $('#barcode-container').empty();
        for (let i = 0; i < copies; i++) {
            const div = $('<div>').addClass('barcode-label');
            if (selectedProduct.name) {
                $('<div>').addClass('product-name').text(selectedProduct.name).appendTo(div);
            }
            if (selectedProduct.company) {
                $('<div>').addClass('product-company').text('🏢 ' + selectedProduct.company).appendTo(div);
            }
            const canvas = $('<canvas>').appendTo(div);
            if (selectedProduct.selling_price) {
                $('<div>').addClass('product-price').text('💰 ' + formatPrice(selectedProduct.selling_price)).appendTo(div);
            }
            container.append(div);
            JsBarcode(canvas[0], normalizedBarcode, {
                format: 'CODE128',
                width: 1.5,
                height: 50,
                displayValue: true,
                fontSize: 13,
                margin: 5
            });
        }
        $('#barcode-preview-area').show();
        showAlert('success', 'ئامادەیە', `${copies} بارکۆد دروستکرا. ئێستا دەتوانیت چاپی بکەیت.`);
    }

    function printBarcodes() {
        if (!selectedProduct) { showAlert('warning','ئاگاداری','کاڵایەک هەڵبژێرە'); return; }
        $('#barcode-container canvas').each(function () {
            const dataUrl = this.toDataURL('image/png');
            $(this).replaceWith($('<img>').attr('src', dataUrl).css({ display: 'block', margin: '0 auto' }));
        });
        const printContents = $('#barcode-container').html();
        const name = selectedProduct.name || '';
        const pw = window.open('', '_blank');
        pw.document.write(`<!DOCTYPE html><html><head><meta charset="UTF-8"><title>چاپی بارکۆد - ${escapeHtml(name)}</title><style>*{box-sizing:border-box;}body{margin:0;padding:20px;font-family:sans-serif;background:white;}.print-area{display:flex;flex-wrap:wrap;justify-content:flex-start;gap:10px;}.barcode-label{display:inline-block;padding:10px 12px;background:white;border:1px solid #e2e8f0;border-radius:8px;text-align:center;min-width:120px;vertical-align:top;page-break-inside:avoid;break-inside:avoid;}.barcode-label img{display:block;margin:0 auto;}.barcode-label .product-name{font-size:11px;margin-top:5px;font-weight:bold;color:#1e293b;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:140px;}.barcode-label .product-company{font-size:10px;margin-top:2px;color:#64748b;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:140px;}.barcode-label .product-price{font-size:12px;margin-top:4px;color:#e53e3e;font-weight:bold;}</style></head><body><div class="print-area">${printContents}</div><script>window.onload=function(){window.print();window.onafterprint=function(){window.close();};};<\/script></body></html>`);
        pw.document.close();
        setTimeout(generateBarcodes, 600);
    }

    $('#scan-barcode-btn').on('click', function() { openScanner(); });
    $('#name-search').on('input', function () {
        clearTimeout(nameSearchDebounceTimer);
        const term = $(this).val().trim();
        if (!term) { hideNameResults(); return; }
        nameSearchDebounceTimer = setTimeout(() => searchByName(term), 300);
    });
    $('#barcode-search').on('input', function () {
        clearTimeout(barcodeSearchDebounceTimer);
        const term = $(this).val().trim();
        if (!term) { hideBarcodeResults(); return; }
        barcodeSearchDebounceTimer = setTimeout(() => searchByBarcode(term), 300);
    });
    $('#barcode-search').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            const barcode = $(this).val().trim();
            if (barcode) searchByExactBarcode(barcode);
        }
    });
    $(document).on('click', '.name-search-item, .barcode-search-item', function () {
        try {
            const raw = $(this).data('product');
            const p = typeof raw === 'string' ? JSON.parse(raw) : raw;
            if (p) {
                displayProductInfo(p);
                if ($(this).hasClass('name-search-item')) $('#name-search').val(p.name || '');
                else $('#barcode-search').val(p.barcode || '');
                hideNameResults();
                hideBarcodeResults();
            }
        } catch (e) { console.error(e); }
    });
    $(document).on('click', function (e) {
        if (!$(e.target).closest('.search-container').length) {
            hideNameResults();
            hideBarcodeResults();
        }
    });
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape') {
            $('#img-modal').removeClass('active');
            closeScanner();
        }
    });
    $('#generate-btn').click(generateBarcodes);
    $('#print-btn').click(printBarcodes);
    $('#clear-btn').click(function () {
        $('#barcode-container').empty();
        $('#barcode-preview-area').hide();
        showAlert('info', 'پاککرایەوە', 'هەموو بارکۆدەکان لابران');
    });
    
    // Close scanner when clicking on modal background
    $('#scannerModal').on('click', function(e) {
        if (e.target === this) {
            closeScanner();
        }
    });
});
</script>
@endsection