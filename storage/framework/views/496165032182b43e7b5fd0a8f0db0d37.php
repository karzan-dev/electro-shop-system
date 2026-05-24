<?php $__env->startSection('content'); ?>
<style>
    /* Dark mode support - inherits from parent layout */
    body {
        background: #f1f5f9;
        font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
        transition: background-color 0.3s ease, color 0.2s ease;
    }
    
    body.dark-mode {
        background: #0f172a;
    }
    
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
        --card-bg: #ffffff;
        --transition-base: all 0.3s ease;
    }
    
    body.dark-mode {
        --primary: #6c8db8;
        --primary-dark: #1e293b;
        --secondary: #5d7ab0;
        --text: #e2e8f0;
        --border-color: #334155;
        --bg-light: #1e293b;
        --card-bg: #1e293b;
    }
    
    /* Fullscreen Image Modal Styles */
    .fullscreen-image-modal .modal-content {
        background: rgba(0, 0, 0, 0.95);
        border: none;
        border-radius: 0;
    }
    
    .fullscreen-image-modal .modal-body {
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }
    
    .fullscreen-image-modal img {
        max-width: 100%;
        max-height: 100vh;
        object-fit: contain;
        cursor: pointer;
    }
    
    .fullscreen-image-modal .btn-close {
        position: absolute;
        top: 20px;
        right: 20px;
        z-index: 10;
        filter: invert(1);
        width: 40px;
        height: 40px;
        opacity: 0.8;
    }
    
    .fullscreen-image-modal .btn-close:hover {
        opacity: 1;
    }
    
    /* Image clickable cursor */
    .clickable-image {
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .clickable-image:hover {
        transform: scale(1.02);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    }
    
    body.dark-mode .clickable-image:hover {
        box-shadow: 0 4px 15px rgba(255, 255, 255, 0.1);
    }
    
    /* Rest of your existing styles */
    body.dark-mode .card {
        background: var(--card-bg) !important;
        border-color: var(--border-color) !important;
    }
    
    body.dark-mode .card-header {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark)) !important;
    }
    
    body.dark-mode .form-control,
    body.dark-mode .form-select {
        background-color: #0f172a;
        border-color: var(--border-color);
        color: var(--text);
    }
    
    body.dark-mode .form-control:focus,
    body.dark-mode .form-select:focus {
        background-color: #1e293b;
        border-color: var(--primary);
        color: var(--text);
    }
    
    body.dark-mode .form-label {
        color: var(--text);
    }
    
    body.dark-mode .input-with-icon-custom i.field-icon {
        color: var(--primary);
    }
    
    body.dark-mode .alert-info {
        background-color: #1e293b;
        border-color: var(--info);
        color: #93c5fd;
    }
    
    body.dark-mode .existing-image-preview {
        background: #0f172a;
        border-color: var(--border-color);
    }
    
    body.dark-mode .existing-image-label {
        color: var(--primary);
    }
    
    body.dark-mode .autocomplete-items {
        background-color: #1e293b;
        border-color: var(--border-color);
    }
    
    body.dark-mode .autocomplete-items div {
        background-color: #1e293b;
        border-bottom-color: var(--border-color);
        color: var(--text);
    }
    
    body.dark-mode .autocomplete-items div:hover {
        background-color: var(--primary);
        color: white;
    }
    
    body.dark-mode .same-barcode-alert {
        background: linear-gradient(135deg, #451a03, #78350f);
        border-right-color: var(--warning);
    }
    
    body.dark-mode .same-barcode-alert .text-primary {
        color: #93c5fd !important;
    }
    
    body.dark-mode .modal-content {
        background-color: #1e293b;
        border-color: var(--border-color);
    }
    
    body.dark-mode .modal-header {
        border-bottom-color: var(--border-color);
    }
    
    body.dark-mode .modal-footer {
        border-top-color: var(--border-color);
    }
    
    body.dark-mode .btn-close {
        filter: invert(1) grayscale(100%) brightness(200%);
    }
    
    body.dark-mode .product-item-card {
        background: #0f172a;
        border-color: var(--border-color);
    }
    
    body.dark-mode .product-item-name {
        color: var(--text);
    }
    
    body.dark-mode .product-item-detail {
        color: #94a3b8;
    }
    
    body.dark-mode .form-text {
        color: #94a3b8;
    }
    
    body.dark-mode .text-muted {
        color: #94a3b8 !important;
    }
    
    body.dark-mode .btn-custom-secondary {
        background-color: #0f172a;
        border-color: var(--primary);
        color: var(--primary);
    }
    
    body.dark-mode .btn-custom-secondary:hover {
        background-color: #1e293b;
        color: var(--primary);
    }
    
    body.dark-mode .section-title-custom {
        color: var(--primary);
        border-bottom-color: var(--accent);
    }
    
    body.dark-mode .form-logo-custom {
        background-color: #334155;
    }
    
    body.dark-mode #barcode-container {
        background: #0f172a;
    }
    
    body.dark-mode #barcode-container svg {
        filter: invert(1);
    }

    .form-header-custom {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
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
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }

    .form-logo-custom i {
        font-size: 2.5rem;
        background: linear-gradient(135deg, var(--primary), var(--accent));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .section-title-custom {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid var(--accent);
    }

    .input-with-icon-custom {
        position: relative;
    }

    .input-with-icon-custom .form-control,
    .input-with-icon-custom select {
        padding-left: 3rem;
        padding-right: 3rem;
    }

    .input-with-icon-custom i.field-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--primary);
        font-size: 1.1rem;
        z-index: 4;
    }

    .autocomplete-items {
        position: absolute;
        border: 1px solid #d4d4d4;
        border-bottom: none;
        border-top: none;
        z-index: 99;
        top: 100%;
        left: 0;
        right: 0;
        max-height: 300px;
        overflow-y: auto;
        background-color: #fff;
        border-radius: 0 0 8px 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    .autocomplete-items div {
        padding: 10px;
        cursor: pointer;
        background-color: #fff;
        border-bottom: 1px solid #d4d4d4;
        transition: all 0.2s ease;
    }
    
    .autocomplete-items div:hover {
        background-color: #e9e9e9;
    }
    
    .autocomplete-active {
        background-color: var(--primary) !important;
        color: white;
    }

    .camera-fullscreen {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: black;
        z-index: 99999;
        display: none;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .camera-fullscreen.active {
        display: flex;
    }

    .camera-fullscreen video {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .camera-fullscreen .camera-controls-full {
        position: fixed;
        bottom: 30px;
        left: 0;
        right: 0;
        display: flex;
        justify-content: center;
        gap: 20px;
        padding: 20px;
        background: rgba(0, 0, 0, 0.7);
        z-index: 100000;
    }

    .camera-fullscreen .camera-controls-full button {
        padding: 15px 25px;
        font-size: 1.2rem;
        border: none;
        border-radius: 50px;
        cursor: pointer;
        transition: transform 0.2s;
    }

    .camera-fullscreen .camera-controls-full button:active {
        transform: scale(0.95);
    }

    .camera-fullscreen .btn-capture-full {
        background-color: #10b981;
        color: white;
    }

    .camera-fullscreen .btn-switch-full {
        background-color: #3b82f6;
        color: white;
    }

    .camera-fullscreen .close-camera {
        position: absolute;
        top: 20px;
        right: 20px;
        background: rgba(0, 0, 0, 0.6);
        color: white;
        border: none;
        width: 45px;
        height: 45px;
        border-radius: 50%;
        font-size: 24px;
        cursor: pointer;
        z-index: 100001;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .custom-alert {
        border-radius: 12px;
        border: none;
        padding: 16px 20px;
        margin-bottom: 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        display: flex;
        align-items: center;
        animation: slideDown 0.3s ease-out;
        position: relative;
        overflow: hidden;
    }

    .search-inputerror {
        width: 100%;
        padding: 1rem 1rem 1rem 4rem !important;
        border: none !important;
        font-size: 1.1rem;
        background: rgba(239, 12, 4, 0.982) !important;
        color: rgba(255, 255, 255, 0.886) !important;
    }

    .custom-alert::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 5px;
        height: 100%;
    }

    .alert-success-custom { background: rgba(12, 239, 4, 0.982); color: #065f46; border-left: 5px solid var(--success); }
    .alert-success-custom::before { background: var(--success); }
    .alert-error-custom { background: rgba(239, 12, 4, 0.982); color: #740a0a; border-left: 5px solid var(--danger); }
    .alert-error-custom::before { background: var(--danger); }
    .alert-warning-custom { background: rgba(249, 115, 22, 0.98); color: #9a3412; border-left: 5px solid var(--warning); }
    .alert-warning-custom::before { background: var(--warning); }
    .alert-info-custom { background: rgba(59, 130, 246, 0.98); color: #1e3a8a; border-left: 5px solid var(--info); }
    .alert-info-custom::before { background: var(--info); }

    .alert-icon { font-size: 1.5rem; margin-right: 15px; flex-shrink: 0; }
    .alert-content { flex-grow: 1; }
    .alert-title { font-weight: 700; font-size: 1.05rem; margin-bottom: 5px; }
    .alert-message { font-size: 0.95rem; line-height: 1.5; }
    .alert-close {
        background: none; border: none; color: inherit;
        opacity: 0.7; font-size: 1.2rem; cursor: pointer;
        padding: 0; margin-left: 5px; transition: opacity 0.3s;
    }
    .alert-close:hover { opacity: 1; }

    .custom-toast {
        position: fixed;
        bottom: 30px;
        left: 30px;
        z-index: 9999;
        max-width: 350px;
        animation: slideInLeft 0.3s ease-out;
    }

    body.dark-mode .btn-custom-primary {
       background: linear-gradient(135deg, #101537, #2c3e50);
        border: none; color: white; font-weight: 600;
        padding: 0.75rem 1rem;
        box-shadow: 0 4px 15px rgba(74, 100, 145, 0.3);
        transition: all 0.3s ease;
    }

    .btn-custom-primary {
       background: linear-gradient(135deg, var(--primary), var(--accent));
        border: none; color: white; font-weight: 600;
        padding: 0.75rem 1rem;
        box-shadow: 0 4px 15px rgba(74, 100, 145, 0.3);
        transition: all 0.3s ease;
    }
    .btn-custom-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(74, 100, 145, 0.4);
        color: white;
    }

    .btn-custom-secondary {
        background-color: white; color: var(--primary);
        border: 2px solid var(--primary); font-weight: 600;
        padding: 0.75rem 1rem;
    }
    .btn-custom-secondary:hover { background-color: #f8f9fa; }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-20px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes slideInLeft {
        from { opacity: 0; transform: translateX(-30px); }
        to   { opacity: 1; transform: translateX(0); }
    }

    .validation-error {
        color: var(--danger); font-size: 0.875rem;
        margin-top: 0.25rem; display: none;
    }
    .has-error .form-control, .has-error select { border-color: var(--danger); }

    @media (max-width: 768px) {
        .custom-toast { left: 15px; right: 15px; max-width: none; }
    }

    #product-barcode {
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        background: rgb(26, 90, 26);
        color: rgba(255, 255, 255, 0.886);
        padding: 1rem 3.2rem 1rem 4rem !important;
        border: 2px solid var(--primary);
        border-radius: 12px;
    }
    #product-barcode:focus {
        border-color: var(--accent);
        outline: none;
        box-shadow: 0 0 0 3px rgba(192,132,252,0.2);
    }
    #product-barcode::placeholder { color: #98b0a9; }

    .barcode-generate-btn {
        position: absolute;
        left: 0.6rem;
        top: 50%;
        transform: translateY(-50%);
        z-index: 5;
        width: 38px;
        height: 38px;
        border-radius: 8px;
        background: linear-gradient(135deg, var(--primary), var(--accent));
        border: none;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 1.05rem;
        transition: all 0.2s ease;
        box-shadow: 0 2px 8px rgba(74,100,145,0.35);
        flex-shrink: 0;
    }
    .barcode-generate-btn:hover {
        transform: translateY(-50%) scale(1.1);
        box-shadow: 0 4px 14px rgba(74,100,145,0.55);
    }
    .barcode-generate-btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: translateY(-50%);
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
        background: linear-gradient(135deg, var(--primary), var(--accent));
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

    .fixed-action-btn {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 1000;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    .btn-edit-barcode {
        width: 60px;
        height: 60px;
        border-radius: 30px;
        background: linear-gradient(135deg, var(--primary), var(--accent));
        border: none;
        color: white;
        font-size: 1.5rem;
        box-shadow: 0 4px 15px rgba(74, 100, 145, 0.4);
        transition: all 0.3s ease;
    }
    .btn-edit-barcode:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 20px rgba(74, 100, 145, 0.5);
    }
    .btn-print-barcode {
        background: linear-gradient(135deg, #10b981, #059669) !important;
    }

    .scanner-modal .modal-content {
        background: #000;
        border-radius: 1rem;
        overflow: hidden;
    }
    .scanner-modal .modal-header {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        border-bottom: none;
    }
    .scanner-modal .btn-close {
        filter: invert(1);
    }
    #qr-reader {
        width: 100%;
        border-radius: 0;
        overflow: hidden;
    }
    #qr-reader video {
        width: 100% !important;
        min-height: 400px;
        object-fit: cover;
    }

    .print-modal .modal-content {
        border-radius: 1rem;
    }
    .print-modal .modal-header {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        border-bottom: none;
    }
    #barcode-container {
        background: white;
        padding: 20px;
        border-radius: 12px;
        display: inline-block;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    @media print {
        body * {
            visibility: hidden;
        }
        .print-only, .print-only * {
            visibility: visible;
        }
        .print-only {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            margin: 0;
            padding: 20px;
        }
        .modal {
            position: absolute;
            top: 0;
            left: 0;
            display: block !important;
            background: white;
        }
        .modal-dialog {
            margin: 0;
            max-width: 100%;
        }
        .modal-content {
            border: none;
            box-shadow: none;
        }
        .modal-header, .modal-footer, .btn-close, .alert-info {
            display: none !important;
        }
    }

    .existing-image-preview {
        margin-top: 15px;
        padding: 10px;
        background: #f8f9fa;
        border-radius: 8px;
        text-align: center;
    }
    .existing-image-preview img {
        max-width: 200px;
        max-height: 200px;
        border-radius: 8px;
        border: 2px solid var(--primary);
    }
    .existing-image-label {
        font-size: 0.85rem;
        color: var(--primary);
        margin-top: 5px;
    }

    .camera-toggle-buttons {
        display: flex;
        justify-content: center;
        gap: 1rem;
        margin-top: 1rem;
    }
    #camera-section, #file-upload-section {
        transition: all 0.3s ease;
    }

    .products-list-modal .modal-content {
        border-radius: 1rem;
        max-height: 90vh;
    }
    .products-list-modal .modal-header {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        border-bottom: none;
    }
    .products-list-modal .modal-body {
        max-height: 70vh;
        overflow-y: auto;
    }
    .product-item-card {
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        margin-bottom: 15px;
        padding: 15px;
        transition: all 0.3s ease;
        background: white;
    }
    .product-item-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }
    .product-item-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 10px;
        border: 2px solid var(--primary);
    }
    .product-item-name {
        font-size: 1rem;
        font-weight: 600;
        color: var(--secondary);
        margin-bottom: 5px;
    }
    .product-item-detail {
        font-size: 0.85rem;
        color: #6b7280;
        margin-bottom: 3px;
    }
    .stock-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    .stock-available {
        background: #d1fae5;
        color: #065f46;
    }
    .stock-low {
        background: #fed7aa;
        color: #92400e;
    }
    .btn-view-product {
        background: linear-gradient(135deg, #101537, #2c3e50);
        color: white;
        border: none;
        padding: 5px 15px;
        border-radius: 8px;
        font-size: 0.8rem;
    }
    .same-barcode-alert {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        border-right: 4px solid var(--warning);
        padding: 12px 15px;
        border-radius: 10px;
        margin-top: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .same-barcode-alert:hover {
        background: linear-gradient(135deg, #fde68a, #fcd34d);
        transform: scale(1.01);
    }

    body.dark-mode .form-control::placeholder {
        color: #98b0a9 !important;
        
    }
</style>

<!-- Alert Container -->
<div id="alert-container" style="position: fixed; top: 20px; right: 20px; z-index: 9999; width: 350px;"></div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-11">
            <div class="card shadow-lg overflow-hidden">

                <!-- Form Header -->
                <div class="card-header form-header-custom text-white text-center py-4">
                    <div class="form-logo-custom">
                        <i class="fas fa-tag"></i>
                    </div>
                    <h1 class="h2 mb-2">زیادکردنی کاڵای نوێ</h1>
                    <p class="mb-0 opacity-75">تۆمارکردنی کاڵای نوێ بۆ کۆگا و دوکان</p>
                </div>

                <!-- Form Body -->
                <div class="card-body p-4 p-md-5">
                    <form id="product-form" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>

                        <!-- Section 1: Basic Information -->
                        <div class="mb-5">
                            <h3 class="section-title-custom">
                                <i class="fas fa-info-circle ms-2"></i>زانیارییە سەرەکییەکانی کاڵا
                            </h3>

                            <div class="row">
                                <!-- بارکۆد -->
                                <div class="col-md-12 mb-4">
                                    <label for="product-barcode" class="form-label fw-semibold">
                                        <span class="text-danger">*</span> بارکۆدی کاڵا
                                    </label>

                                    <div class="input-with-icon-custom" style="position: relative;">
                                        <input type="text"
                                               id="product-barcode"
                                               name="barcode"
                                               class="form-control form-control-lg"
                                               placeholder="ژمارەی بارکۆد بنوسە ..."
                                               autocomplete="off"
                                               required>
                                        <button type="button"
                                                id="auto-barcode-btn"
                                                class="barcode-generate-btn"
                                                title="دروستکردنی بارکۆدی ئەلێاتۆری">
                                            <i class="fas fa-magic"></i>
                                        </button>
                                        <button type="button"
                                                id="scan-barcode-camera-btn"
                                                class="barcode-scan-btn"
                                                title="سکانکردنی بارکۆد بە کامێرا">
                                            <i class="fas fa-camera"></i>
                                        </button>
                                    </div>
                                    <span id="barcode-status" style="display:inline-block; margin-top:5px;"></span>
                                    <div id="same-barcode-products" style="display: none;"></div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="product-name" class="form-label fw-semibold">
                                        <span class="text-danger">*</span> ناوی کاڵا
                                    </label>
                                    <div class="input-with-icon-custom">
                                        <i class="fas fa-tag field-icon"></i>
                                        <input type="text" id="product-name" name="name"
                                               class="form-control form-control-lg"
                                               placeholder="ناوی کاڵا" required>
                                    </div>
                                    <div class="form-text">ناوی ڕوون و تەواوی کاڵاکە بنووسە</div>
                                    <div class="validation-error" id="name-error"></div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="company-name" class="form-label fw-semibold">
                                        <span class="text-danger">*</span> ناوی کۆمپانیا
                                    </label>
                                    <div class="input-with-icon-custom" style="position: relative;">
                                        <i class="fas fa-building field-icon"></i>
                                        <input type="text" 
                                               id="company-name" 
                                               name="company" 
                                               class="form-control form-control-lg"
                                               placeholder="ناوی کۆمپانیا بنوسە ..."
                                               autocomplete="off"
                                               required>
                                    </div>
                                    <div class="form-text">ناوی کۆمپانیا بنوسە یان لە لیستەکە هەڵبژێرە</div>
                                    <div class="validation-error" id="company-error"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Pricing and Storage -->
                        <div class="mb-5">
                            <h3 class="section-title-custom">
                                <i class="fas fa-chart-line ms-2"></i>نرخ و کۆگاکردن
                            </h3>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="purchase-price" class="form-label fw-semibold">
                                        <span class="text-danger">*</span> نرخی کڕین (دینار)
                                    </label>
                                    <div class="input-with-icon-custom">
                                        <i class="fas fa-shopping-cart field-icon"></i>
                                        <input type="text" id="purchase-price" name="purchase_price"
                                               class="form-control" placeholder="0" required>
                                    </div>
                                    <div class="validation-error" id="purchase_price-error"></div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="selling-price" class="form-label fw-semibold">
                                        <span class="text-danger">*</span> نرخی فرۆشتن (دینار)
                                    </label>
                                    <div class="input-with-icon-custom">
                                        <i class="fas fa-cash-register field-icon"></i>
                                        <input type="text" id="selling-price" name="selling_price"
                                               class="form-control" placeholder="0" required>
                                    </div>
                                    <div class="validation-error" id="selling_price-error"></div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="minimum-stock" class="form-label fw-semibold">
                                        <span class="text-danger">*</span> ژمارەی مادە        
                                    </label>
                                    <div class="input-with-icon-custom">
                                        <i class="fas fa-exclamation-triangle field-icon"></i>
                                        <input type="number" id="minimum-stock" name="minimum_wearhouse"
                                               class="form-control" placeholder="ژمارە" min="1" required>
                                    </div>
                                    <div class="validation-error" id="minimum_wearhouse-error"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 3: Product Image -->
                        <div class="mb-5">
                            <h3 class="section-title-custom">
                                <i class="fas fa-camera ms-2"></i>وێنەی کاڵا
                            </h3>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    <span class="text-danger">*</span> وێنەی سەرەکی کاڵا
                                </label>

                                <div class="camera-toggle-buttons mb-4">
                                    <button type="button" id="open-camera-btn" class="btn btn-primary">
                                        <i class="fas fa-camera ms-2"></i>کامێرا بکەرەوە و وێنە بگرە
                                    </button>
                                    <button type="button" id="upload-file-btn" class="btn btn-outline-primary">
                                        <i class="fas fa-upload ms-2"></i>فایل هەڵبگرە
                                    </button>
                                </div>

                                <div id="camera-section" class="d-none">
                                </div>

                                <div id="file-upload-section" class="d-none">
                                    <div class="input-group mb-3">
                                        <input type="file" id="file-input" name="image_product_camera"
                                               accept="image/*" class="form-control">
                                    </div>
                                    <div id="file-preview" class="mt-3 text-center d-none">
                                        <img id="file-preview-image" src="" alt="پیشاندانی فایل"
                                             class="img-thumbnail clickable-image" style="max-height: 200px;" title="کلیک بکە بۆ گەورەکردن">
                                    </div>
                                </div>

                                <!-- Existing image preview container -->
                                <div id="existing-image-container" class="existing-image-preview d-none">
                                    <img id="existing-product-image" src="" alt="وێنەی کاڵا" class="clickable-image" title="کلیک بکە بۆ گەورەکردن">
                                    <div class="existing-image-label">وێنەی ئێستای کاڵا - کلیک بکە بۆ گەورەکردن</div>
                                </div>

                                <input type="hidden" id="captured-image-data" name="captured_image">
                                <input type="hidden" id="image-source-type" name="image_source_type" value="">
                                <input type="hidden" id="existing-image-path" name="existing_image_path" value="">
                                <div class="validation-error" id="image_product_camera-error"></div>
                                <div class="form-text mt-2">دەتوانیت کامێرای ئامێرەکەت بەکاربێنی یان فایلێک هەڵبگری</div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between pt-4 border-top m-2">
                            <button type="button" class="btn btn-custom-secondary m-2" id="print-barcode-btn">
                                <i class="fas fa-print ms-2"></i>چاپکردنی بارکۆد <span style="font-size:11px;">(F2)</span>
                            </button>
                            <button type="submit" class="btn btn-custom-primary m-2" id="submit-btn">
                                <i class="fas fa-save ms-2"></i>تۆمارکردنی کاڵا <span style="font-size:11px;">(F1)</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Fullscreen Camera Modal for taking product photos -->
<div id="fullscreenCamera" class="camera-fullscreen">
    <button class="close-camera" id="closeFullscreenCamera">&times;</button>
    <video id="fullscreenVideo" autoplay playsinline></video>
    <div class="camera-controls-full">
        <button id="switchCameraFull" class="btn-switch-full">
            <i class="fas fa-sync-alt"></i> گۆڕینی کامێرا
        </button>
        <button id="capturePhotoFull" class="btn-capture-full">
            <i class="fas fa-camera"></i> وێنە بگرە
        </button>
    </div>
</div>

<!-- Fullscreen Image Preview Modal -->
<div class="modal fade fullscreen-image-modal" id="fullscreenImageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header" style="border: none; background: transparent; position: absolute; top: 0; right: 0; z-index: 10;">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <img id="fullscreen-image" src="" alt="وێنەی گەورەی کاڵا">
            </div>
        </div>
    </div>
</div>

<!-- مۆدالی سکانی بارکۆد -->
<div class="modal fade scanner-modal" id="barcodeScannerModal" tabindex="-1" data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-camera ms-2"></i>سکانکردنی بارکۆد</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0" style="min-height: 400px; background: #000;">
                <div id="qr-reader" style="width: 100%;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="closeScannerBtn">
                    <i class="fas fa-times ms-1"></i>داخستن
                </button>
            </div>
        </div>
    </div>
</div>

<!-- مۆدالی چاپکردنی بارکۆد -->
<div class="modal fade print-modal" id="printBarcodeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-print ms-2"></i>چاپکردنی بارکۆد
                </h5>
            </div>
            <div class="modal-body text-center">
                <div id="barcode-container">
                    <svg id="barcode-svg"></svg>
                </div>
                <div class="mt-3">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> کلیک لە دوگمەی چاپ بکە بۆ چاپکردنی بارکۆدەکە
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times ms-1"></i>داخستن
                </button>
                <button type="button" id="print-barcode-modal-btn" class="btn btn-success">
                    <i class="fas fa-print ms-1"></i>چاپکردن
                </button>
            </div>
        </div>
    </div>
</div>

<!-- مۆدالی پیشاندانی لیستی کاڵا هەمان بارکۆد -->
<div class="modal fade products-list-modal" id="sameBarcodeProductsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-list ms-2"></i> کاڵاکانی هەمان بارکۆد
                </h5>
            </div>
            <div class="modal-body" id="products-list-container">
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-3">بارکاردکردنی زانیاری...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times ms-1"></i>داخستن
                </button>
            </div>
        </div>
    </div>
</div>

<!-- دوگمەکانی خوارەوەی شاشە -->
<div class="fixed-action-btn">
    <button type="button" id="reset-form-btn" class="btn-edit-barcode btn-print-barcode" title="پاککردنەوەی فۆرم (Esc)">
        <i class="fas fa-eraser"></i>
    </button>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

<script>
// ============================================
// DARK MODE IMPLEMENTATION - Warehouse Page
// ============================================
(function() {
    const savedTheme = localStorage.getItem('kurdistan_market_theme_dashboard');
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    
    let isDarkMode = false;
    if (savedTheme === 'dark') {
        isDarkMode = true;
    } else if (savedTheme === 'light') {
        isDarkMode = false;
    } else if (prefersDark) {
        isDarkMode = true;
    }
    
    function applyDarkMode(enabled) {
        if (enabled) {
            document.body.classList.add('dark-mode');
            localStorage.setItem('kurdistan_market_theme_dashboard', 'dark');
        } else {
            document.body.classList.remove('dark-mode');
            localStorage.setItem('kurdistan_market_theme_dashboard', 'light');
        }
    }
    
    window.toggleDarkModeWarehouse = function() {
        const currentlyDark = document.body.classList.contains('dark-mode');
        applyDarkMode(!currentlyDark);
    };
    
    applyDarkMode(isDarkMode);
    
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
        const saved = localStorage.getItem('kurdistan_market_theme_dashboard');
        if (!saved) {
            applyDarkMode(e.matches);
        }
    });
})();

$(document).ready(function () {

    let fullscreenStream = null;
    let capturedImageBlob = null;
    let isSubmitting = false;
    let currentFacingMode = 'environment';
    let html5QrCode = null;
    let currentBarcodeProducts = null;
    let companiesList = [];
    
    // Fullscreen Image Modal
    let fullscreenImageModal = new bootstrap.Modal(document.getElementById('fullscreenImageModal'));

    // ============================================
    // !!! چارەسەری کێشەی بارکۆد بە هەر زمانێک !!!
    // ============================================
    
    function normalizeBarcodeToEnglish(barcode) {
        if (!barcode) return barcode;
        
        const kurdishNumbers = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
        const persianNumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        const englishNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        
        let result = barcode.toString();
        
        for (let i = 0; i < kurdishNumbers.length; i++) {
            const regex = new RegExp(kurdishNumbers[i], 'g');
            result = result.replace(regex, englishNumbers[i]);
        }
        
        for (let i = 0; i < persianNumbers.length; i++) {
            const regex = new RegExp(persianNumbers[i], 'g');
            result = result.replace(regex, englishNumbers[i]);
        }
        
        result = result.replace(/[^0-9A-Za-z\-_]/g, '');
        
        return result;
    }
    
    function enableBarcodeNormalization(selector) {
        $(selector).on('input', function() {
            const originalValue = $(this).val();
            const normalizedValue = normalizeBarcodeToEnglish(originalValue);
            
            if (originalValue !== normalizedValue) {
                const cursorPosition = this.selectionStart;
                $(this).val(normalizedValue);
                this.setSelectionRange(cursorPosition, cursorPosition);
                $(this).trigger('normalized');
            }
        });
    }
    
    enableBarcodeNormalization('#product-barcode');

    // ============================================
    // Image Click to Fullscreen Functionality
    // ============================================
    function openFullscreenImage(imageSrc) {
        if (imageSrc && imageSrc !== '' && imageSrc !== '#') {
            $('#fullscreen-image').attr('src', imageSrc);
            fullscreenImageModal.show();
        }
    }
    
    // Click handler for existing product image
    $(document).on('click', '#existing-product-image', function() {
        const imageSrc = $(this).attr('src');
        openFullscreenImage(imageSrc);
    });
    
    // Click handler for file preview image
    $(document).on('click', '#file-preview-image', function() {
        const imageSrc = $(this).attr('src');
        openFullscreenImage(imageSrc);
    });
    
    // Close fullscreen image on click (toggle behavior)
    $(document).on('click', '#fullscreen-image', function() {
        fullscreenImageModal.hide();
    });

    // ============================================
    // Load Companies for Autocomplete
    // ============================================
    function loadCompanies() {
        $.ajax({
            url: '<?php echo e(route("companies.list")); ?>',
            type: 'GET',
            success: function(response) {
                if (response.success && response.companies) {
                    companiesList = response.companies.map(function(item) {
                        return item.company;
                    }).filter(function(company) {
                        return company !== null && company !== '';
                    });
                    
                    companiesList = [...new Set(companiesList)];
                    setupAutocomplete();
                }
            },
            error: function(error) {
                console.error('Error loading companies:', error);
            }
        });
    }
    
    // ============================================
    // Autocomplete Function for Company Field
    // ============================================
    function setupAutocomplete() {
        const companyInput = document.getElementById('company-name');
        
        function autocomplete(inp, arr) {
            let currentFocus;
            
            inp.addEventListener("input", function(e) {
                let a, b, i, val = this.value;
                closeAllLists();
                if (!val) return false;
                currentFocus = -1;
                
                a = document.createElement("DIV");
                a.setAttribute("id", this.id + "autocomplete-list");
                a.setAttribute("class", "autocomplete-items");
                
                this.parentNode.appendChild(a);
                
                for (i = 0; i < arr.length; i++) {
                    if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                        b = document.createElement("DIV");
                        b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                        b.innerHTML += arr[i].substr(val.length);
                        b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                        
                        b.addEventListener("click", function(e) {
                            inp.value = this.getElementsByTagName("input")[0].value;
                            closeAllLists();
                            $(inp).trigger('change');
                        });
                        a.appendChild(b);
                    }
                }
            });
            
            inp.addEventListener("keydown", function(e) {
                let x = document.getElementById(this.id + "autocomplete-list");
                if (x) x = x.getElementsByTagName("div");
                if (e.keyCode == 40) {
                    currentFocus++;
                    addActive(x);
                } else if (e.keyCode == 38) {
                    currentFocus--;
                    addActive(x);
                } else if (e.keyCode == 13) {
                    e.preventDefault();
                    if (currentFocus > -1) {
                        if (x) x[currentFocus].click();
                    }
                }
            });
            
            function addActive(x) {
                if (!x) return false;
                removeActive(x);
                if (currentFocus >= x.length) currentFocus = 0;
                if (currentFocus < 0) currentFocus = (x.length - 1);
                x[currentFocus].classList.add("autocomplete-active");
            }
            
            function removeActive(x) {
                for (let i = 0; i < x.length; i++) {
                    x[i].classList.remove("autocomplete-active");
                }
            }
            
            function closeAllLists(elmnt) {
                const x = document.getElementsByClassName("autocomplete-items");
                for (let i = 0; i < x.length; i++) {
                    if (elmnt != x[i] && elmnt != inp) {
                        x[i].parentNode.removeChild(x[i]);
                    }
                }
            }
            
            document.addEventListener("click", function(e) {
                closeAllLists(e.target);
            });
        }
        
        autocomplete(companyInput, companiesList);
    }

    // ============================================
    // Autosave with LocalStorage Functions
    // ============================================
    const STORAGE_KEY = 'product_form_autosave';
    let autosaveTimer = null;
    let isRestoring = false;
    let saveTimeout = null;

    $("#product-barcode").focus();

    function saveFormToLocalStorage() {
        if (isRestoring) return;
        
        try {
            const formData = {
                barcode: $('#product-barcode').val(),
                name: $('#product-name').val(),
                company: $('#company-name').val(),
                purchase_price: $('#purchase-price').val(),
                selling_price: $('#selling-price').val(),
                minimum_wearhouse: $('#minimum-stock').val(),
                image_source_type: $('#image-source-type').val(),
                captured_image_data: $('#captured-image-data').val(),
                existing_image_path: $('#existing-image-path').val(),
                timestamp: new Date().getTime()
            };
            localStorage.setItem(STORAGE_KEY, JSON.stringify(formData));
        } catch(e) {
            console.error('Error saving to localStorage:', e);
        }
    }
    
    function restoreFormFromLocalStorage() {
        const savedData = localStorage.getItem(STORAGE_KEY);
        if (!savedData) return false;
        
        try {
            isRestoring = true;
            const data = JSON.parse(savedData);
            let hasData = false;
            
            if (data.barcode) {
                const normalizedBarcode = normalizeBarcodeToEnglish(data.barcode);
                $('#product-barcode').val(normalizedBarcode);
                hasData = true;
            }
            if (data.name) {
                $('#product-name').val(data.name);
                hasData = true;
            }
            if (data.company) {
                $('#company-name').val(data.company);
                hasData = true;
            }
            if (data.purchase_price) {
                $('#purchase-price').val(data.purchase_price);
                hasData = true;
            }
            if (data.selling_price) {
                $('#selling-price').val(data.selling_price);
                hasData = true;
            }
            if (data.minimum_wearhouse) {
                $('#minimum-stock').val(data.minimum_wearhouse);
                hasData = true;
            }
            if (data.image_source_type) {
                $('#image-source-type').val(data.image_source_type);
                hasData = true;
            }
            
            if (data.captured_image_data && data.captured_image_data !== '') {
                $('#captured-image-data').val(data.captured_image_data);
                hasData = true;
                restoreCapturedImage(data.captured_image_data);
            }
            
            if (data.existing_image_path && data.existing_image_path !== '') {
                $('#existing-image-path').val(data.existing_image_path);
                displayExistingImage(data.existing_image_path);
                hasData = true;
            }
            
            if (hasData && data.barcode) {
                const normalizedBarcode = normalizeBarcodeToEnglish(data.barcode);
                updateBarcodeStatus(normalizedBarcode);
            }
            
            return hasData;
        } catch(e) {
            console.error('Error restoring from localStorage:', e);
            return false;
        } finally {
            setTimeout(() => {
                isRestoring = false;
            }, 100);
        }
    }
    
    function restoreCapturedImage(imageData) {
        if (imageData && imageData.startsWith('data:image')) {
            $('#file-preview-image').attr('src', imageData);
            $('#file-preview').removeClass('d-none');
            $('#existing-image-container').addClass('d-none');
            $('#image-source-type').val('camera');
            $('#file-upload-section').removeClass('d-none');
            
            fetch(imageData)
                .then(res => res.blob())
                .then(blob => {
                    const file = new File([blob], 'product_photo.jpg', { type: 'image/jpeg' });
                    const dt = new DataTransfer();
                    dt.items.add(file);
                    $('#file-input')[0].files = dt.files;
                })
                .catch(error => console.error('Error restoring image file:', error));
        }
    }

    function clearLocalStorageSave() {
        localStorage.removeItem(STORAGE_KEY);
    }
    
    function clearFormAndStorage() {
        clearForm();
        clearLocalStorageSave();
    }

    function startAutosave() {
        if (autosaveTimer) clearInterval(autosaveTimer);
        autosaveTimer = setInterval(saveFormToLocalStorage, 2000);
    }
    
    function debouncedSave() {
        if (saveTimeout) clearTimeout(saveTimeout);
        saveTimeout = setTimeout(() => {
            saveFormToLocalStorage();
        }, 500);
    }

    $('#product-form input, #product-form select, #product-form textarea').on('input change', function() {
        if (!isRestoring) {
            debouncedSave();
        }
    });

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    /* ============================================
       Fullscreen Camera Functions
    ============================================ */
    function startFullscreenCamera() {
        if (fullscreenStream) stopFullscreenCamera();
        
        navigator.mediaDevices.getUserMedia({
            video: { facingMode: currentFacingMode, width: { ideal: 1920 }, height: { ideal: 1080 } },
            audio: false
        }).then(function (mediaStream) {
            fullscreenStream = mediaStream;
            const videoElement = document.getElementById('fullscreenVideo');
            videoElement.srcObject = mediaStream;
            videoElement.play();
        }).catch(function (error) {
            console.error('Camera error:', error);
            showAlert('error', 'هەڵەی کامێرا', 'ناتواندرێت کامێرا بکرێتەوە. تکایە ڕێگەدانەکەت پشکنین بکە.');
            closeFullscreenCamera();
        });
    }

    function stopFullscreenCamera() {
        if (fullscreenStream) {
            fullscreenStream.getTracks().forEach(track => track.stop());
            fullscreenStream = null;
            const videoElement = document.getElementById('fullscreenVideo');
            if (videoElement) videoElement.srcObject = null;
        }
    }

    function openFullscreenCamera() {
        const fullscreenDiv = document.getElementById('fullscreenCamera');
        fullscreenDiv.classList.add('active');
        document.body.style.overflow = 'hidden';
        startFullscreenCamera();
    }

    function closeFullscreenCamera() {
        const fullscreenDiv = document.getElementById('fullscreenCamera');
        fullscreenDiv.classList.remove('active');
        document.body.style.overflow = '';
        stopFullscreenCamera();
    }

    function switchFullscreenCamera() {
        currentFacingMode = currentFacingMode === 'environment' ? 'user' : 'environment';
        startFullscreenCamera();
    }

    function captureFullscreenPhoto() {
        if (!fullscreenStream) {
            showAlert('warning', 'ئاگاداری', 'کامێرا کار ناکات');
            return;
        }

        const video = document.getElementById('fullscreenVideo');
        const canvas = document.createElement('canvas');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);

        canvas.toBlob(function (blob) {
            capturedImageBlob = blob;
            const reader = new FileReader();
            reader.onloadend = function () { 
                const imageDataUrl = reader.result;
                $('#captured-image-data').val(imageDataUrl); 
                $('#existing-image-container').addClass('d-none');
                $('#image-source-type').val('camera');
                saveFormToLocalStorage();
            };
            reader.readAsDataURL(blob);
            
            closeFullscreenCamera();
            
            const file = new File([blob], 'product_photo.jpg', { type: 'image/jpeg' });
            const dt = new DataTransfer();
            dt.items.add(file);
            $('#file-input')[0].files = dt.files;
            $('#file-preview-image').attr('src', URL.createObjectURL(blob));
            $('#file-preview').removeClass('d-none');
            $('#file-upload-section').removeClass('d-none');
            $('#image-source-type').val('camera');
            $('#existing-image-container').addClass('d-none');
        }, 'image/jpeg', 0.9);
    }

    /* ============================================
       Barcode Scanner Functions
    ============================================ */
    
    async function startBarcodeScanner() {
        const qrReader = document.getElementById('qr-reader');
        if (!qrReader) return;
        
        if (html5QrCode) {
            try {
                if (html5QrCode.isScanning) {
                    await html5QrCode.stop();
                }
                await html5QrCode.clear();
            } catch(e) {}
        }
        
        html5QrCode = new Html5Qrcode("qr-reader");
        
        const config = {
            fps: 10,
            qrbox: { width: 250, height: 200 },
            aspectRatio: 1.0,
        };
        
        try {
            await html5QrCode.start(
                { facingMode: "environment" },
                config,
                (decodedText) => {
                    const normalizedBarcode = normalizeBarcodeToEnglish(decodedText);
                    stopBarcodeScanner();
                    $('#barcodeScannerModal').modal('hide');
                    $('#product-barcode').val(normalizedBarcode).trigger('keyup');
                    saveFormToLocalStorage();
                    $('#product-name').focus();
                    showAlert('success', 'سکان کرا', `بارکۆد: ${normalizedBarcode}`);
                },
                (errorMessage) => {}
            );
        } catch (err) {
            console.error('Error starting scanner:', err);
            showAlert('error', 'هەڵەی کامێرا', 'ناتوانرێت کامێرا بۆ سکانکردن بکرێتەوە.');
            $('#barcodeScannerModal').modal('hide');
        }
    }
    
    async function stopBarcodeScanner() {
        if (html5QrCode && html5QrCode.isScanning) {
            try {
                await html5QrCode.stop();
                await html5QrCode.clear();
            } catch(e) {}
        }
    }

    /* ============================================
       Barcode Printing Functions
    ============================================ */
    function generateBarcode(barcodeValue) {
        if (!barcodeValue || barcodeValue.trim() === '') return false;
        const normalizedBarcode = normalizeBarcodeToEnglish(barcodeValue);
        try {
            JsBarcode("#barcode-svg", normalizedBarcode, {
                format: "CODE128",
                lineColor: "#000000",
                width: 2,
                height: 100,
                displayValue: true,
                fontSize: 18,
                font: "monospace",
                textMargin: 10,
                margin: 10
            });
            return true;
        } catch(e) {
            console.error('Barcode generation error:', e);
            return false;
        }
    }

    function printBarcodeFromModal() {
        const barcodeValue = $('#product-barcode').val().trim();
        if (!barcodeValue) return;
        
        const normalizedBarcode = normalizeBarcodeToEnglish(barcodeValue);
        const productName = $('#product-name').val().trim();
        const companyName = $('#company-name').val().trim();
        
        generateBarcode(normalizedBarcode);
        
        setTimeout(function() {
            const svgElement = document.getElementById('barcode-svg');
            if (!svgElement) return;
            
            const printContent = `
                <!DOCTYPE html>
                <html>
                <head>
                    <meta charset="UTF-8">
                    <title>چاپکردنی بارکۆد - ${escapeHtml(normalizedBarcode)}</title>
                    <style>
                        * { margin: 0; padding: 0; box-sizing: border-box; }
                        body {
                            margin: 0; padding: 20px;
                            display: flex; justify-content: center; align-items: center;
                            min-height: 100vh; font-family: 'Segoe UI', Arial, sans-serif;
                            background: #f5f5f5;
                        }
                        .barcode-container {
                            text-align: center; padding: 30px;
                            border: 2px solid #ddd; border-radius: 12px;
                            background: white; box-shadow: 0 4px 15px rgba(0,0,0,0.1);
                            min-width: 350px; max-width: 500px;
                        }
                        svg { max-width: 100%; height: auto; }
                        .barcode-number {
                            margin-top: 15px; font-size: 18px;
                            font-weight: bold; font-family: 'Courier New', monospace;
                            letter-spacing: 1px; color: #333;
                        }
                        .product-details {
                            margin-top: 20px; padding-top: 15px;
                            border-top: 2px solid #4a6491;
                        }
                        .product-name { font-size: 18px; font-weight: bold; color: #4a6491; margin-bottom: 8px; }
                        .company-name { font-size: 14px; color: #666; }
                        @media print {
                            body { margin: 0; padding: 0; background: white; }
                            .barcode-container { border: none; padding: 10px; box-shadow: none; }
                        }
                    </style>
                </head>
                <body>
                    <div class="barcode-container">
                        ${svgElement.outerHTML}
                        <div class="barcode-number">${escapeHtml(normalizedBarcode)}</div>
                        <div class="product-details">
                            ${productName ? `<div class="product-name">🏷️ ${escapeHtml(productName)}</div>` : ''}
                            ${companyName ? `<div class="company-name">🏢 ${escapeHtml(companyName)}</div>` : ''}
                        </div>
                    </div>
                </body>
                </html>
            `;
            
            const printWindow = window.open('', '_blank', 'width=500,height=400,scrollbars=yes');
            printWindow.document.write(printContent);
            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
            printWindow.onafterprint = function() {
                printWindow.close();
            };
        }, 100);
    }

    /* ============================================
       Helper Functions
    ============================================ */
    function displayExistingImage(imagePath) {
        if (!imagePath) return;
        let imageUrl = imagePath;
        if (!imageUrl.startsWith('/') && !imageUrl.startsWith('http')) {
            if (imageUrl.startsWith('images/')) {
                imageUrl = '/' + imageUrl;
            } else if (imageUrl.startsWith('storage/')) {
                imageUrl = '/' + imageUrl;
            } else {
                imageUrl = '/storage/' + imageUrl;
            }
        }
        $('#existing-product-image').attr('src', imageUrl);
        $('#existing-image-container').removeClass('d-none');
    }

    function formatNumberToIQD(value) {
        if (!value) return '';
        const numericValue = value.toString().replace(/[^0-9.]/g, '');
        if (!numericValue) return '';
        return numericValue.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }

    function removeThousandSeparators(value) {
        return value.toString().replace(/,/g, '');
    }

    function fillFormWithProductData(product, warehouse) {
        if (!product) return;
        
        isRestoring = true;
        
        if (product.name) $('#product-name').val(product.name);
        if (product.company) $('#company-name').val(product.company);
        if (product.purchase_price) $('#purchase-price').val(formatNumberToIQD(product.purchase_price));
        if (product.selling_price) $('#selling-price').val(formatNumberToIQD(product.selling_price));
        if (warehouse && warehouse.counter) $('#minimum-stock').val(warehouse.counter);
        
        if (product.image_producte_path) {
            $('#existing-image-path').val(product.image_producte_path);
            displayExistingImage(product.image_producte_path);
            $('#image-source-type').val('existing');
            $('#captured-image-data').val('');
            $('#file-preview').addClass('d-none');
            $('#file-input').val('');
        } else {
            $('#existing-image-container').addClass('d-none');
            $('#existing-image-path').val('');
            $('#file-preview').addClass('d-none');
            $('#file-input').val('');
            $('#captured-image-data').val('');
        }
        
        $("html, body").animate({ scrollTop: 0 }, 500);
        
        setTimeout(() => {
            isRestoring = false;
            saveFormToLocalStorage();
        }, 100);
    }
    
    window.showProductsListModal = function() {
        if (!currentBarcodeProducts || currentBarcodeProducts.length === 0) {
            showAlert('warning', 'ئاگاداری', 'هیچ کاڵایەک بەم بارکۆدە نەدۆزرایەوە');
            return;
        }
        
        let productsHtml = '';
        currentBarcodeProducts.forEach((product, index) => {
            let imageUrl = product.image_producte_path || '/default-image.jpg';
            if (imageUrl && !imageUrl.startsWith('http') && !imageUrl.startsWith('/')) {
                imageUrl = '/' + imageUrl;
            }
            
            productsHtml += `
                <div class="product-item-card" data-product-index="${index}" style="cursor: pointer;">
                    <div class="row align-items-center">
                        <div class="col-md-2 text-center">
                            <img src="${escapeHtml(imageUrl)}" class="product-item-image clickable-image" alt="${escapeHtml(product.name)}"
                         onerror="this.src='data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2240%22%20height%3D%2240%22%20viewBox%3D%220%200%2040%2040%22%3E%3Crect%20width%3D%2240%22%20height%3D%2240%22%20fill%3D%22%23cbd5e1%22%2F%3E%3Ctext%20x%3D%2220%22%20y%3D%2225%22%20text-anchor%3D%22middle%22%20fill%3D%22%234b5563%22%3E${product.name?.charAt(0)||'?'}%3C%2Ftext%3E%3C%2Fsvg%3E';"
                         title="کلیک بکە بۆ گەورەکردنی وێنە">
                        </div>
                        <div class="col-md-7">
                            <div class="product-item-name"><i class="fas fa-box"></i> ${escapeHtml(product.name)}</div>
                            <div class="product-item-detail"><i class="fas fa-building"></i> کۆمپانیا: ${escapeHtml(product.company)}</div>
                            <div class="product-item-detail"><i class="fas fa-tag"></i> بارکۆد: ${escapeHtml(product.barcode)}</div>
                            <div class="product-item-detail"><i class="fas fa-dollar-sign"></i> نرخی کڕین: ${formatNumberToIQD(product.purchase_price)} دینار</div>
                            <div class="product-item-detail"><i class="fas fa-dollar-sign"></i> نرخی فرۆشتن: ${formatNumberToIQD(product.selling_price)} دینار</div>
                            <div class="product-item-detail"><i class="fas fa-warehouse"></i> بڕی کۆگا: ${product.warehouse_counter || 0}</div>
                        </div>
                        <div class="col-md-3 text-center">
                            <span class="stock-badge ${(product.warehouse_counter > 0) ? 'stock-available' : 'stock-low'}">
                                <i class="fas ${(product.warehouse_counter > 0) ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
                                ${(product.warehouse_counter > 0) ? 'بەردەستە' : 'کەمە یان نییە'}
                            </span>
                            <button class="btn btn-view-product mt-2 view-product-btn me-2 mb-2" data-product-index="${index}">
                                <i class="fas fa-eye"></i> بینینی کاڵا
                            </button>
                        </div>
                    </div>
                </div>
            `;
        });
        
        $('#products-list-container').html(productsHtml);
        
        // Click handler for product images in the list
        $('.product-item-image').on('click', function(e) {
            e.stopPropagation();
            const imageSrc = $(this).attr('src');
            openFullscreenImage(imageSrc);
        });
        
        $('.product-item-card').on('click', function(e) {
            if ($(e.target).is('img')) return; // Don't select if clicking on image
            const index = $(this).data('product-index');
            const selectedProduct = currentBarcodeProducts[index];
            if (selectedProduct) {
                fillFormWithProductData(selectedProduct, { counter: selectedProduct.warehouse_counter });
                $('#sameBarcodeProductsModal').modal('hide');
            }
        });
        
        $('.view-product-btn').on('click', function(e) {
            e.stopPropagation();
            const index = $(this).data('product-index');
            const selectedProduct = currentBarcodeProducts[index];
            if (selectedProduct) {
                fillFormWithProductData(selectedProduct, { counter: selectedProduct.warehouse_counter });
                $('#sameBarcodeProductsModal').modal('hide');
            }
        });
        
        $('#sameBarcodeProductsModal').modal('show');
    };
    
    function escapeHtml(text) {
        if (!text) return '';
        return text
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;');
    }
    
    function updateBarcodeStatus(barcode) {
        if (!barcode || barcode.trim() === '') {
            $('#barcode-status').text('');
            $('#product-barcode').removeClass('search-inputerror');
            $('#same-barcode-products').hide().empty();
            currentBarcodeProducts = null;
            return;
        }
        
        const normalizedBarcode = normalizeBarcodeToEnglish(barcode);
        
        $('#barcode-status').html('<i class="fas fa-spinner fa-spin"></i> پشکنین دەکرێت...').css('color', '#3b82f6');
        
        $.ajax({
            url: '<?php echo e(route("barcode.check")); ?>',
            type: 'POST',
            data: { _token: '<?php echo e(csrf_token()); ?>', barcode: normalizedBarcode },
            success: function(response) {
                if (response.exists && response.products && response.products.length > 0) {
                    currentBarcodeProducts = response.products;
                    let productNames = response.products.map(p => p.company).join('، ');
                    let alertHtml = `
                        <div class="same-barcode-alert" onclick="showProductsListModal()">
                            <i class="fas fa-exclamation-triangle text-warning ms-2"></i>
                            <strong>⚠️ ئەم بارکۆدە بۆ ${response.total_count} کۆمپانیا بەکارهاتووە:</strong><br>
                            <small>${escapeHtml(productNames.substring(0, 100))}${productNames.length > 100 ? '...' : ''}</small><br>
                            <span class="text-primary"><i class="fas fa-eye ms-1"></i> کلیک بکە بۆ بینینی هەموویان</span>
                        </div>
                    `;
                    $('#same-barcode-products').html(alertHtml).show();
                    $('#barcode-status').html(`⚠️ ئەم بارکۆدە بۆ ${response.total_count} کاڵا بەکارهاتووە`)
                        .css('color', '#f59e0b');
                    $('#product-barcode').addClass('search-inputerror');
                } else if (response.exists && (!response.products || response.products.length === 0)) {
                    $('#barcode-status').html('⚠️ بارکۆد هەیە بەڵام کاڵای تۆمارکراو نییە').css('color', '#f59e0b');
                    $('#product-barcode').addClass('search-inputerror');
                    $('#same-barcode-products').hide();
                    currentBarcodeProducts = null;
                } else {
                    $('#barcode-status').html('✅ بارکۆد بەردەستە - دەتوانیت کاڵای نوێ تۆمار بکەیت').css('color', '#10b981');
                    $('#product-barcode').removeClass('search-inputerror');
                    $('#same-barcode-products').hide();
                    currentBarcodeProducts = null;
                }
            },
            error: function() {
                $('#barcode-status').html('❌ هەڵە لە پشکنیندا').css('color', '#ef4444');
            }
        });
    }

    function clearFormButKeepBarcode() {
        const currentBarcode = $('#product-barcode').val();
        
        $('#product-name').val('');
        $('#company-name').val('');
        $('#purchase-price').val('');
        $('#selling-price').val('');
        $('#minimum-stock').val('');
        $('#file-input').val('');
        $('#file-preview').addClass('d-none');
        $('#captured-image-data').val('');
        $('#image-source-type').val('');
        $('#existing-image-container').addClass('d-none');
        $('#existing-image-path').val('');
        
        $('#product-barcode').val(currentBarcode);
        
        clearValidationErrors();
        saveFormToLocalStorage();
    }

    function showAlert(type, title, message, duration = 5000) {
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
    }

    function clearForm() {
        $('#product-form')[0].reset();
        $('#captured-image-data').val('');
        $('#image-source-type').val('');
        $('#camera-section').addClass('d-none');
        $('#file-upload-section').addClass('d-none');
        $('#file-preview').addClass('d-none');
        $('#barcode-status').text('');
        $('#product-barcode').removeClass('search-inputerror');
        $('#existing-image-container').addClass('d-none');
        $('#existing-image-path').val('');
        $('#same-barcode-products').hide().empty();
        $('#file-preview-image').attr('src', '');
        currentBarcodeProducts = null;
        clearValidationErrors();
        
        $('#product-barcode').focus();
    }

    function clearValidationErrors() {
        $('.validation-error').hide().empty();
        $('.has-error').removeClass('has-error');
        $('.is-invalid').removeClass('is-invalid');
    }

    function showValidationErrors(errors) {
        clearValidationErrors();
        $.each(errors, function (field, messages) {
            const errorDiv = $(`#${field.replace(/\./g, '_')}-error`);
            const inputField = $(`[name="${field}"]`);
            if (errorDiv.length && inputField.length) {
                errorDiv.html(messages.join('<br>')).show();
                inputField.closest('.input-with-icon-custom').addClass('has-error');
                inputField.addClass('is-invalid');
            }
        });
    }

    /* ============================================
       Event Listeners
    ============================================ */
    
    $('#file-input').on('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                $('#file-preview-image').attr('src', event.target.result);
                $('#file-preview').removeClass('d-none');
                $('#existing-image-container').addClass('d-none');
                $('#image-source-type').val('file');
                $('#captured-image-data').val('');
                saveFormToLocalStorage();
            };
            reader.readAsDataURL(file);
        }
    });
    
    $('#open-camera-btn').click(openFullscreenCamera);
    $('#closeFullscreenCamera').click(closeFullscreenCamera);
    $('#switchCameraFull').click(switchFullscreenCamera);
    $('#capturePhotoFull').click(captureFullscreenPhoto);

    $('#upload-file-btn').click(function() {
        $('#file-upload-section').removeClass('d-none');
        $('#camera-section').addClass('d-none');
        $('#existing-image-container').addClass('d-none');
        if (fullscreenStream) stopFullscreenCamera();
        $('#image-source-type').val('file');
    });

    $('#scan-barcode-camera-btn').on('click', function() {
        $('#barcodeScannerModal').modal('show');
    });

    $('#barcodeScannerModal').on('shown.bs.modal', function() {
        startBarcodeScanner();
    });

    $('#barcodeScannerModal').on('hidden.bs.modal', function() {
        stopBarcodeScanner();
    });

    $('#closeScannerBtn').on('click', function() {
        $('#barcodeScannerModal').modal('hide');
        $('#product-barcode').focus();
    });

    $('#print-barcode-btn').on('click', function() {
        const barcodeValue = $('#product-barcode').val().trim();
        if (!barcodeValue) {
            showAlert('warning', 'ئاگاداری', 'تکایە یەکەمجار بارکۆدێک داخڵ بکە یان دروست بکە');
            return;
        }
        const normalizedBarcode = normalizeBarcodeToEnglish(barcodeValue);
        if (generateBarcode(normalizedBarcode)) {
            $('#printBarcodeModal').modal('show');
        }
    });
    
    $('#print-barcode-modal-btn').on('click', function() {
        printBarcodeFromModal();
    });
    
    $('#printBarcodeModal').on('show.bs.modal', function() {
        const barcodeValue = $('#product-barcode').val().trim();
        if (barcodeValue) {
            const normalizedBarcode = normalizeBarcodeToEnglish(barcodeValue);
            generateBarcode(normalizedBarcode);
        }
    });

    $('#auto-barcode-btn').on('click', function() {
        const btn = $(this);
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
        
        function generateCandidate() {
            let code = '';
            for (let i = 0; i < 12; i++) code += Math.floor(Math.random() * 10);
            return code;
        }
        
        function tryBarcode() {
            const candidate = generateCandidate();
            $.ajax({
                url: '<?php echo e(route("barcode.check")); ?>',
                type: 'POST',
                data: { _token: '<?php echo e(csrf_token()); ?>', barcode: candidate },
                success: function(res) {
                    if (res.exists && res.products && res.products.length > 0) {
                        tryBarcode();
                    } else {
                        $('#product-barcode').val(candidate).trigger('keyup');
                        $('#barcode-status').html('✅ بارکۆدی نوێ بە سەرکەوتوویی دروستکرا').css('color', '#10b981');
                        btn.prop('disabled', false).html('<i class="fas fa-magic"></i>');
                        clearFormButKeepBarcode();
                        saveFormToLocalStorage();
                        $('#product-name').focus();
                    }
                },
                error: function() {
                    showAlert('error', 'هەڵە', 'هەڵە لە پشکنینی بارکۆددا، دووبارە هەوڵبدەرەوە');
                    btn.prop('disabled', false).html('<i class="fas fa-magic"></i>');
                }
            });
        }
        tryBarcode();
    });
    
    let typingTimer;
    const doneTypingInterval = 500;

    $('#product-barcode').on('keyup', function() {
        clearTimeout(typingTimer);
        let barcode = $(this).val().trim();
        if (!barcode) { 
            $('#barcode-status').text(''); 
            $('#product-barcode').removeClass('search-inputerror');
            $('#same-barcode-products').hide().empty();
            currentBarcodeProducts = null;
            return; 
        }
        const normalizedBarcode = normalizeBarcodeToEnglish(barcode);
        if (barcode !== normalizedBarcode) {
            $(this).val(normalizedBarcode);
            barcode = normalizedBarcode;
        }
        typingTimer = setTimeout(function() {
            updateBarcodeStatus(normalizedBarcode);
        }, doneTypingInterval);
    });
    
    $(document).on('click', '#same-barcode-products', function() {
        showProductsListModal();
    });

    $('#purchase-price, #selling-price').on('input', function() {
        let value = removeThousandSeparators($(this).val());
        if (value && !isNaN(value)) {
            $(this).val(formatNumberToIQD(value));
        }
    });
    
    $('#purchase-price, #selling-price').on('focus', function() {
        $(this).val(removeThousandSeparators($(this).val()));
    });
    
    $('#purchase-price, #selling-price').on('blur', function() {
        let value = removeThousandSeparators($(this).val());
        if (value && !isNaN(value) && value !== '') {
            $(this).val(formatNumberToIQD(value));
        }
    });

    $('#reset-form-btn').click(function() {
        showConfirmAlert('ئاگاداری', 'دڵنیایت کە دەتەوێت هەموو زانیارییەکان پاک بکەیتەوە؟', function(result) {
            if (result) { 
                clearFormAndStorage();
            }
        });
    });

    function showConfirmAlert(title, message, callback) {
        const id = 'confirm-alert-' + Date.now();
        $('#alert-container').prepend(`
            <div id="${id}" class="custom-alert alert-warning-custom mb-3">
                <i class="fas fa-question-circle alert-icon"></i>
                <div class="alert-content">
                    <div class="alert-title">${escapeHtml(title)}</div>
                    <div class="alert-message">${escapeHtml(message)}</div>
                    <div class="mt-3">
                        <button class="btn btn-sm btn-success ms-2" id="confirm-yes-${id}">بەڵێ</button>
                        <button class="btn btn-sm btn-secondary" id="confirm-no-${id}">نەخێر</button>
                    </div>
                </div>
                <button class="alert-close" onclick="$('#${id}').remove()">×</button>
            </div>
        `);
        $(`#confirm-yes-${id}`).on('click', function() { $(`#${id}`).remove(); callback(true); });
        $(`#confirm-no-${id}`).on('click', function() { $(`#${id}`).remove(); callback(false); });
    }

    $('#selling-price').on('change', function() {
        const pp = parseFloat(removeThousandSeparators($('#purchase-price').val())) || 0;
        const sp = parseFloat(removeThousandSeparators($(this).val())) || 0;
        if (sp <= pp && sp > 0 && pp > 0) {
            showAlert('warning', 'ئاگاداری', 'نرخی فرۆشتن دەبێت زیاتر لە نرخی کڕین بێت!');
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid');
        }
    });

    $('#product-form').submit(function(e) {
        e.preventDefault();
        if (isSubmitting) return;

        $('#purchase-price').val(removeThousandSeparators($('#purchase-price').val()));
        $('#selling-price').val(removeThousandSeparators($('#selling-price').val()));
        
        const barcodeField = $('#product-barcode');
        const normalizedBarcode = normalizeBarcodeToEnglish(barcodeField.val());
        barcodeField.val(normalizedBarcode);

        const pp = parseFloat($('#purchase-price').val()) || 0;
        const sp = parseFloat($('#selling-price').val()) || 0;
        if (sp <= pp && sp > 0 && pp > 0) {
            showAlert('error', 'هەڵەی نرخ', 'نرخی فرۆشتن دەبێت زیاتر لە نرخی کڕین بێت!');
            $('#selling-price').focus(); 
            return false;
        }

        const ms = parseInt($('#minimum-stock').val()) || 0;
        if (ms < 1) {
            showAlert('error', 'هەڵە', 'کەمترین بڕی کۆگا دەبێت لانیکەم ١ بێت!');
            $('#minimum-stock').focus(); 
            return false;
        }

        const formData = new FormData(this);
        isSubmitting = true;
        const submitBtn = $('#submit-btn');
        const origText = submitBtn.html();
        submitBtn.html('<i class="fas fa-spinner fa-spin ms-2"></i>تۆمار دەکرێت...').prop('disabled', true);

        $.ajax({
            url: '<?php echo e(route("products.store")); ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    showAlert('success', 'سەرکەوتوو', 'کاڵاکە بە سەرکەوتوویی تۆمارکرا');
                    clearFormAndStorage();
                    $("html, body").animate({ scrollTop: 300 }, 500);
                    $('#product-barcode').focus();
                } else {
                    showAlert('error', 'هەڵە', response.message || 'هەڵەیەک بونی هەیە');
                }
            },
            error: function(xhr) {
                console.log(xhr);
                if (xhr.status === 422) {
                    showValidationErrors(xhr.responseJSON.errors);
                    showAlert('error', 'هەڵە', 'تکایە زانیارییەکان پێداچوونەوە بکە');
                } else {
                    showAlert('error', 'هەڵە', 'هەڵەیەک ڕوویدا. تکایە دووبارە هەوڵبدەرەوە');
                }
            },
            complete: function() {
                isSubmitting = false;
                submitBtn.html(origText).prop('disabled', false);
            }
        });
    });

    // Keyboard Shortcuts
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape' || e.keyCode === 27) {
            e.preventDefault();
            $('#reset-form-btn').click();
        }
        if (e.key === 'F1' || e.keyCode === 112) {
            e.preventDefault();
            if (!isSubmitting) $('#submit-btn').click();
        }
        if (e.key === 'F2' || e.keyCode === 113) {
            e.preventDefault();
            const barcodeValue = $('#product-barcode').val().trim();
            if (barcodeValue) {
                $('#print-barcode-btn').click();
            } else {
                showAlert('warning', 'ئاگاداری', 'تکایە یەکەمجار بارکۆدێک داخڵ بکە یان دروست بکە');
            }
        }
    });

    // Initialize
    loadCompanies();
    
    setTimeout(function() {
        const hasRestoredData = restoreFormFromLocalStorage();
        startAutosave();
    }, 500);

});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamnp64\www\mobileHardy\resources\views/items/items-register.blade.php ENDPATH**/ ?>