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
        --text: #1e293b;
        --border-color: #e2e8f0;
        --bg-light: #f8fafc;
        --accent: var(--primary);
        
        --card-bg: #ffffff;
        --body-bg: #f1f5f9;
        --shadow-color: rgba(0, 0, 0, 0.1);
    }

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
        --shadow-color: rgba(0, 0, 0, 0.3);
    }
    
    body {
        background: var(--body-bg);
        font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
        transition: background-color 0.3s ease, color 0.3s ease;
        color: var(--text);
    }

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

    .print-area {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 12px;
    }

    .barcode-label {
        display: inline-block;
        padding: 10px 12px;
        background: var(--card-bg);
        border-radius: 8px;
        box-shadow: 0 2px 8px var(--shadow-color);
        text-align: center;
        min-width: 120px;
        max-width: 150px;
        vertical-align: top;
        border: 1px solid var(--border-color);
    }

    .barcode-label svg {
        display: block;
        margin: 0 auto;
        max-width: 130px;
        height: auto;
    }

    .barcode-label .product-name {
        font-size: 11px;
        margin-top: 5px;
        font-weight: bold;
        color: var(--text);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 130px;
        direction: rtl;
        unicode-bidi: embed;
    }

    .barcode-label .product-company {
        font-size: 9px;
        margin-top: 2px;
        color: var(--text);
        opacity: 0.7;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 130px;
        direction: rtl;
        unicode-bidi: embed;
    }

    .barcode-label .product-price {
        font-size: 12px;
        margin-top: 4px;
        color: #e53e3e;
        font-weight: bold;
        direction: rtl;
        unicode-bidi: embed;
    }
    
    body.dark-mode .barcode-label .product-price {
        color: #f87171;
    }

    .print-area-container {
        display: none;
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
                    <p class="mb-0 opacity-75">چاپکەری گەرمی Xprinter XP-236B | 48mm | 203DPI</p>
                    <small class="opacity-50">SIZE: 48×39.38mm | GAP: 2.63mm</small>
                    <div class="mt-3">
                        <span class="badge bg-light text-dark">F1 = چاپکردن</span>
                        <span class="badge bg-light text-dark ms-2">Esc = پاکردنەوە</span>
                    </div>
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
                        
                        <div class="row mb-4">
                            <div class="col-12">
                                <label class="form-label fw-semibold">ڕێکخستنەکانی لیبڵ (بەپێی Self-Test)</label>
                                <div class="row g-2">
                                    <div class="col-md-3 col-6">
                                        <small class="text-muted">پانی لیبڵ</small>
                                        <span class="badge bg-primary d-block">48.00 mm</span>
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <small class="text-muted">بەرزی لیبڵ</small>
                                        <span class="badge bg-success d-block">39.38 mm</span>
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <small class="text-muted">GAP</small>
                                        <span class="badge bg-warning text-dark d-block">2.63 mm</span>
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <small class="text-muted">DENSITY / SPEED</small>
                                        <span class="badge bg-info d-block">7 / 3</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row align-items-end">
                            <div class="col-md-12 mb-3">
                                <button id="print-btn" class="btn btn-success w-100" style="background:#10b981;border:none;font-weight:600;padding:0.75rem 2rem;">
                                    <i class="fas fa-print ms-2"></i>چاپکردن (F1)
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Print Area Container -->
<div class="print-area-container">
    <div id="print-area-thermal" class="print-area"></div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>

// ==================== DARK MODE ====================
(function() {
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
    
    applyDarkMode(isDarkMode);
    
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
        const saved = localStorage.getItem('kurdistan_barcode_theme');
        if (!saved) {
            applyDarkMode(e.matches);
            isDarkMode = e.matches;
        }
    });
})();

// ==================== SCANNER ====================
let html5QrCode = null;
let isScannerRunning = false;

function onScanSuccess(decodedText) {
    const normalizedBarcode = normalizeToEnglishNumbers(decodedText);
    closeScanner();
    $('#barcode-search').val(normalizedBarcode);
    searchByExactBarcode(normalizedBarcode);
}

function onScanFailure(error) {
    // ignore
}

async function startScanner() {
    try {
        if (html5QrCode) {
            if (isScannerRunning) {
                try { await html5QrCode.stop(); } catch (e) {}
            }
            html5QrCode = null;
            isScannerRunning = false;
        }
        
        const readerElement = document.getElementById('qr-reader');
        if (readerElement) readerElement.innerHTML = '';
        
        html5QrCode = new Html5Qrcode("qr-reader");
        
        await html5QrCode.start(
            { facingMode: "environment" },
            { fps: 10, qrbox: { width: 250, height: 200 }, aspectRatio: 1.0 },
            onScanSuccess,
            onScanFailure
        );
        
        isScannerRunning = true;
    } catch (err) {
        console.error('Scanner error:', err);
        showAlert('error', 'هەڵە', 'نەتوانرا کامێرا دەستپێبکرێت');
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
    } catch (err) {
        console.error('Error closing scanner:', err);
    } finally {
        $('#scannerModal').hide();
        const readerElement = document.getElementById('qr-reader');
        if (readerElement) readerElement.innerHTML = '';
    }
}

function openScanner() {
    $('#scannerModal').show();
    setTimeout(() => { startScanner(); }, 100);
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

    // ═══════════════════════════════════════════════════════════
    // 🔍 گەڕان بە ناو — ✅ company_name
    // ═══════════════════════════════════════════════════════════
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
                        
                        // ✅ ناوی کۆمپانیا
                        const companyName = p.company_name || p.company || 'بێ کۆمپانیا';
                        
                        html += `<div class="name-search-item" data-product='${JSON.stringify(p).replace(/'/g,"&#39;")}'>
                                    <div class="d-flex align-items-center">
                                        ${imgTag}
                                        <div class="me-2">
                                            <div class="fw-semibold">${escapeHtml(p.name || '')}</div>
                                            <div class="small text-muted">${escapeHtml(companyName)}</div>
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

    // ═══════════════════════════════════════════════════════════
    // 🔍 گەڕان بە بارکۆد — ✅ company_name
    // ═══════════════════════════════════════════════════════════
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
                        
                        // ✅ ناوی کۆمپانیا
                        const companyName = p.company_name || p.company || 'بێ کۆمپانیا';
                        
                        html += `<div class="barcode-search-item" data-product='${JSON.stringify(p).replace(/'/g,"&#39;")}'>
                                    <div class="d-flex align-items-center">
                                        ${imgTag}
                                        <div class="me-2">
                                            <div class="fw-semibold">${escapeHtml(p.name || '')}</div>
                                            <div class="small text-muted">${escapeHtml(companyName)}</div>
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

    // ═══════════════════════════════════════════════════════════
    // 📋 نیشاندانی زانیاری کاڵا — ✅ company_name
    // ═══════════════════════════════════════════════════════════
    function displayProductInfo(product) {
        selectedProduct = product;
        $('#disp-name').text(product.name || '---');
        
        // ✅ ناوی کۆمپانیا
        const companyName = product.company_name || product.company || 'بێ کۆمپانیا';
        $('#disp-company').text(companyName);
        
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
        $('#print-area-thermal').empty();
        $('#barcode-preview-area').hide();
    }

    function clearAll() {
        selectedProduct = null;
        $('#product-info').hide();
        $('#disp-name').text('---');
        $('#disp-company').text('---');
        $('#disp-barcode').text('---');
        $('#disp-price').text('---');
        $('#disp-image').hide();
        $('#disp-image-placeholder').show();
        $('#barcode-container').empty();
        $('#print-area-thermal').empty();
        $('#barcode-preview-area').hide();
        $('#name-search').val('');
        $('#barcode-search').val('');
        hideNameResults();
        hideBarcodeResults();
    }

    // ═══════════════════════════════════════════════════════════
    // 🖨️ چاپکردنی بارکۆد — ✅ company_name
    // ═══════════════════════════════════════════════════════════
    function printBarcodes() {
        if (!selectedProduct) { 
            showAlert('warning','ئاگاداری','کاڵایەک هەڵبژێرە'); 
            return; 
        }
        
        const printWindow = window.open('', '_blank', 'width=400,height=300');
        if (!printWindow) {
            showAlert('error', 'هەڵە', 'تکایە Pop-up چالاک بکە');
            return;
        }
        
        const name = selectedProduct.name || '';
        // ✅ ناوی کۆمپانیا
        const company = selectedProduct.company_name || selectedProduct.company || '';
        const price = selectedProduct.selling_price ? formatPrice(selectedProduct.selling_price) : '';
        const normalizedBarcode = normalizeToEnglishNumbers(selectedProduct.barcode);
        
        const LABEL_WIDTH = 48;
        const LABEL_HEIGHT = 39.38;
        const totalHeight = LABEL_HEIGHT;
        
        printWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="UTF-8">
                <title>چاپی بارکۆد - Xprinter XP-236B</title>
                <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"><\/script>
                <style>
                    @page {
                        size: ${LABEL_WIDTH}mm ${totalHeight}mm !important;
                        margin: 0 !important;
                        padding: 0 !important;
                    }
                    
                    * { margin: 0; padding: 0; box-sizing: border-box; }
                    
                    html, body {
                        width: ${LABEL_WIDTH}mm !important;
                        height: ${totalHeight}mm !important;
                        margin: 0 !important;
                        padding: 0 !important;
                        background: white !important;
                        overflow: hidden !important;
                        -webkit-print-color-adjust: exact !important;
                        print-color-adjust: exact !important;
                    }
                    
                    .print-container {
                        display: block !important;
                        width: ${LABEL_WIDTH}mm !important;
                        height: auto !important;
                        padding: 0 !important;
                        margin: 0 !important;
                        background: white !important;
                    }
                    
                    .barcode-label {
                        display: block !important;
                        width: ${LABEL_WIDTH}mm !important;
                        height: ${LABEL_HEIGHT}mm !important;
                        min-height: ${LABEL_HEIGHT}mm !important;
                        padding: 1.2mm 1mm !important;
                        margin: 0 !important;
                        background: white !important;
                        text-align: center !important;
                        page-break-inside: avoid !important;
                        overflow: hidden !important;
                    }
                    
                    .barcode-svg-print {
                        display: block !important;
                        margin: 0 auto !important;
                        width: ${LABEL_WIDTH - 8}mm !important;
                        height: auto !important;
                        max-height: ${LABEL_HEIGHT - 14}mm !important;
                    }
                    
                    .product-name {
                        font-size: 9pt !important;
                        margin: 0 auto 0.5mm auto !important;
                        font-weight: bold !important;
                        color: #000 !important;
                        white-space: nowrap !important;
                        overflow: hidden !important;
                        text-overflow: ellipsis !important;
                        max-width: ${LABEL_WIDTH - 6}mm !important;
                        text-align: center !important;
                        line-height: 1.3 !important;
                        display: block !important;
                        direction: rtl !important;
                        font-family: Arial, sans-serif !important;
                    }
                    
                    .product-company {
                        font-size: 7pt !important;
                        margin: 0 auto 0.3mm auto !important;
                        color: #333 !important;
                        white-space: nowrap !important;
                        overflow: hidden !important;
                        text-overflow: ellipsis !important;
                        max-width: ${LABEL_WIDTH - 6}mm !important;
                        text-align: center !important;
                        line-height: 1.3 !important;
                        display: block !important;
                        direction: rtl !important;
                        font-family: Arial, sans-serif !important;
                    }
                    
                    .product-price {
                        font-size: 9pt !important;
                        margin: 0.5mm auto 0 auto !important;
                        color: #000 !important;
                        font-weight: bold !important;
                        text-align: center !important;
                        line-height: 1.3 !important;
                        display: block !important;
                        border-top: 0.5px dashed #ccc !important;
                        padding: 0.3mm 0 0.5mm 0 !important;
                        direction: rtl !important;
                        font-family: Arial, sans-serif !important;
                    }
                </style>
            </head>
            <body>
                <div class="print-container">
                    <div class="barcode-label">
                        <div class="product-name">${escapeHtml(name)}</div>
                        <div class="product-company">${escapeHtml(company)}</div>
                        <svg id="barcode-print" class="barcode-svg-print"></svg>
                        <div class="product-price">${escapeHtml(price)}</div>
                    </div>
                </div>
                <script>
                    function renderBarcode() {
                        if (typeof JsBarcode === 'undefined') {
                            setTimeout(renderBarcode, 100);
                            return;
                        }
                        
                        const svg = document.getElementById('barcode-print');
                        
                        try {
                            JsBarcode(svg, '${normalizedBarcode}', {
                                format: 'CODE128',
                                width: 1.8,
                                height: 45,
                                displayValue: true,
                                fontSize: 14,
                                margin: 2,
                                textMargin: 3,
                                textAlign: 'center',
                                font: 'Arial',
                                fontOptions: 'bold',
                                lineColor: '#000000',
                                background: '#FFFFFF'
                            });
                        } catch(e) {
                            console.error('JsBarcode error:', e);
                        }
                        
                        setTimeout(function() {
                            window.print();
                            setTimeout(function() {
                                window.close();
                            }, 500);
                        }, 800);
                    }
                    
                    if (document.readyState === 'loading') {
                        document.addEventListener('DOMContentLoaded', renderBarcode);
                    } else {
                        renderBarcode();
                    }
                <\/script>
            </body>
            </html>
        `);
        printWindow.document.close();
    }

    // ==================== KEYBOARD SHORTCUTS ====================
    $(document).on('keydown', function(e) {
        if (e.key === 'F1' || e.keyCode === 112) {
            e.preventDefault();
            if (selectedProduct) {
                printBarcodes();
            } else {
                showAlert('warning', 'ئاگاداری', 'تکایە یەکەمجار کاڵایەک هەڵبژێرە');
            }
        }
        
        if (e.key === 'Escape' || e.keyCode === 27) {
            e.preventDefault();
            $('#img-modal').removeClass('active');
            closeScanner();
            clearAll();
            showAlert('info', 'پاککرایەوە', 'هەموو شتێک پاککرایەوە');
        }
    });

    // ==================== EVENT BINDINGS ====================
    
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
    
    $('#print-btn').click(printBarcodes);
    
    $('#scannerModal').on('click', function(e) {
        if (e.target === this) {
            closeScanner();
        }
    });
});
</script>
@endsection