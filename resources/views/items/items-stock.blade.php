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
        --card-bg: #ffffff;
    }

    body {
        background: #f1f5f9;
        font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
        transition: background-color 0.3s ease, color 0.2s ease;
    }
    
    body.dark-mode {
        background: #0f172a;
        --primary: #6c8db8;
        --primary-dark: #1e293b;
        --secondary: #5d7ab0;
        --text: #e2e8f0;
        --border-color: #334155;
        --bg-light: #1e293b;
        --card-bg: #1e293b;
    }

    .search-table-panel {
        background: white;
        border-radius: 1.25rem;
        box-shadow: 0 12px 30px rgba(0,0,0,0.08);
        overflow: hidden;
        height: fit-content;
    }
    
    body.dark-mode .search-table-panel { background: var(--card-bg); }
    
    .form-sidebar-panel {
        background: white;
        border-radius: 1.25rem;
        box-shadow: 0 12px 30px rgba(0,0,0,0.08);
        position: sticky;
        top: 20px;
    }
    
    body.dark-mode .form-sidebar-panel { background: var(--card-bg); }

    @media (max-width: 992px) {
        .form-sidebar-panel { position: static; }
    }

    @media (max-width: 768px) {
        .search-table-panel,
        .form-sidebar-panel {
            border-radius: 1rem;
            padding: 1rem !important;
        }
    }

    .section-title-custom {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 1.2rem;
        padding-bottom: 0.6rem;
        border-bottom: 2px solid var(--secondary);
    }

    .input-with-icon-custom { position: relative; }
    .input-with-icon-custom .form-control,
    .input-with-icon-custom .form-select { padding-right: 2.8rem; }
    body.dark-mode .form-select {
        color: rgb(154, 154, 154);
        background-color: #334155;
        border-color: var(--border-color) !important;
    }
    body.dark-mode .form-select option {
        background-color: #1e293b;
        color: var(--text);
    }
    .input-with-icon-custom i {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--primary);
        z-index: 4;
    }

    .readonly-field {
        background-color: #f1f5f9 !important;
        border-color: #e2e8f0 !important;
        color: #334155 !important;
        font-weight: 500;
    }
    
    body.dark-mode .readonly-field {
        background-color: #0f172a !important;
        border-color: var(--border-color) !important;
        color: var(--text) !important;
    }

    .product-table tbody tr {
        cursor: pointer;
        transition: all 0.2s;
    }
    .product-table tbody tr:hover {
        background-color: #fef9e3;
        transform: scale(1.01);
    }
    body.dark-mode .product-table tbody tr:hover { background-color: #1e293b; }
    
    .table-selected-row {
        background-color: #e0e7ff !important;
        border-right: 3px solid var(--primary);
    }
    body.dark-mode .table-selected-row { background-color: #1e3a5f !important; }

    .duplicate-warning {
        background-color: #fff3cd !important;
        border-left: 3px solid var(--warning);
    }
    .duplicate-badge {
        display: inline-block;
        background-color: var(--warning);
        color: white;
        font-size: 0.7rem;
        padding: 2px 6px;
        border-radius: 20px;
        margin-left: 5px;
    }

    .btn-custom-primary {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.7rem 1.5rem;
        border-radius: 40px;
        transition: 0.3s;
    }
    .btn-custom-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(74,100,145,0.4);
    }
    .btn-custom-secondary {
        background-color: white;
        color: var(--primary);
        border: 2px solid var(--primary);
        border-radius: 40px;
        font-weight: 600;
        padding: 0.7rem 1.5rem;
    }
    body.dark-mode .btn-custom-secondary {
        background-color: #0f172a;
        color: var(--primary);
        border-color: var(--primary);
    }

    .custom-alert {
        border-radius: 16px;
        padding: 1rem 1.2rem;
        margin-bottom: 1rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        border-right: 5px solid;
        animation: slideInRight 0.25s ease-out;
        display: flex;
        align-items: center;
        gap: 12px;
        text-align: right;
        word-wrap: break-word;
    }
    .alert-success-custom { background: linear-gradient(135deg, #d1fae5, #a7f3d0); border-right-color: var(--success); color: #065f46; }
    .alert-error-custom { background: linear-gradient(135deg, #fee2e2, #fecaca); border-right-color: var(--danger); color: #991b1b; }
    .alert-warning-custom { background: linear-gradient(135deg, #fff3e3, #fed7aa); border-right-color: var(--warning); color: #9a3412; }
    body.dark-mode .alert-success-custom { background: linear-gradient(135deg, #064e3b, #065f46); color: #a7f3d0; }
    body.dark-mode .alert-error-custom { background: linear-gradient(135deg, #7f1d1d, #991b1b); color: #fecaca; }
    body.dark-mode .alert-warning-custom { background: linear-gradient(135deg, #78350f, #92400e); color: #fde68a; }
    
    .alert-close {
        background: none;
        border: none;
        font-size: 1.3rem;
        cursor: pointer;
        margin-right: auto;
        opacity: 0.7;
        color: inherit;
    }
    .alert-close:hover { opacity: 1; }
    
    .image-preview {
        max-width: 100%;
        max-height: 160px;
        object-fit: contain;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        background: #fff;
        padding: 6px;
        cursor: pointer;
        transition: transform 0.2s;
    }
    .image-preview:hover {
        transform: scale(1.02);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

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

    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(30px);}
        to { opacity: 1; transform: translateX(0);}
    }
    .loading-spinner {
        display: inline-block;
        width: 1.2rem;
        height: 1.2rem;
        border: 2px solid rgba(255,255,255,0.3);
        border-radius: 50%;
        border-top-color: white;
        animation: spin 0.6s linear infinite;
    }
    @keyframes spin { to { transform: rotate(360deg); } }

    .camera-fullscreen {
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background-color: black;
        z-index: 99999;
        display: none;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .camera-fullscreen.active { display: flex; }
    .camera-fullscreen video { width: 100%; height: 100%; object-fit: cover; }
    .camera-fullscreen .camera-controls-full {
        position: fixed;
        bottom: 30px;
        left: 0; right: 0;
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
    }
    .camera-fullscreen .btn-capture-full { background-color: #10b981; color: white; }
    .camera-fullscreen .btn-switch-full { background-color: #3b82f6; color: white; }
    .camera-fullscreen .close-camera {
        position: absolute;
        top: 20px; right: 20px;
        background: rgba(0, 0, 0, 0.6);
        color: white;
        border: none;
        width: 45px; height: 45px;
        border-radius: 50%;
        font-size: 24px;
        cursor: pointer;
        z-index: 100001;
    }

    .scanner-modal .modal-content { background: #000; border-radius: 1rem; overflow: hidden; }
    .scanner-modal .modal-header {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        border-bottom: none;
    }
    .scanner-modal .btn-close { filter: invert(1); }
    #qr-reader { width: 100%; max-width: 100%; border-radius: 0; overflow: hidden; }
    #qr-reader video { width: 100% !important; min-height: 400px; object-fit: cover; }

    @media (max-width: 768px) {
        #qr-reader video { min-height: 300px; }
        .scanner-modal .modal-dialog { margin: 0.5rem; }
        .scanner-modal .modal-body { min-height: 300px !important; }
        .scanner-modal .modal-footer { flex-wrap: wrap; }
        .scanner-modal .modal-footer .btn { width: 100%; }
    }

    .search-input-wrapper { position: relative; }
    .search-input-wrapper .form-control { padding-left: 50px; }

    body.dark-mode .form-control {
        background-color: #334155;
        color: rgb(255, 255, 255);
    }
    body.dark-mode .form-control::placeholder { color: #98b0a9; }
    
    .camera-search-btn {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border: none;
        color: white;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 5;
        transition: all 0.2s;
    }
    .camera-search-btn:hover { transform: translateY(-50%) scale(1.08); }

    @media (max-width: 576px) {
        .camera-search-btn { width: 28px; height: 28px; font-size: 0.8rem; left: 8px; }
        .search-input-wrapper .form-control { padding-left: 44px; }
    }

    .pagination-container {
        margin-top: 1rem;
        display: flex;
        justify-content: center;
    }
    .pagination {
        gap: 5px;
        flex-wrap: wrap;
        justify-content: center;
    }
    body.dark-mode .page-link {
        background-color: #334155;
        color: rgb(255, 255, 255);
        border-color: #475569;
    }
    .page-link {
        border-radius: 8px !important;
        color: var(--primary);
        border: 1px solid #dee2e6;
        padding: 0.5rem 0.75rem;
    }
    .page-item.active .page-link {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border-color: var(--primary);
        color: white;
    }

    .shortcut-hint {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: rgba(0,0,0,0.75);
        color: white;
        padding: 10px 18px;
        border-radius: 40px;
        font-size: 12px;
        z-index: 1000;
        backdrop-filter: blur(8px);
        font-family: monospace;
        display: flex;
        gap: 15px;
        letter-spacing: 0.5px;
    }
    .shortcut-hint kbd {
        background: linear-gradient(135deg, #2d2d2d, #1a1a1a);
        border-radius: 6px;
        padding: 3px 8px;
        margin: 0 3px;
        font-weight: bold;
        font-family: monospace;
        font-size: 11px;
        border: 1px solid #555;
        box-shadow: 0 1px 0 rgba(255,255,255,0.2);
    }
    .shortcut-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    @media (max-width: 768px) {
        .shortcut-hint { display: none; }
        .container { padding-left: 12px; padding-right: 12px; }
        .search-table-panel, .form-sidebar-panel { padding: 1rem !important; }
        .product-table { font-size: 0.85rem; }
        .product-table th, .product-table td { padding: 0.5rem; }
        .btn-custom-primary, .btn-custom-secondary { padding: 0.5rem 1rem; font-size: 0.9rem; }
    }

    @media (max-width: 480px) {
        .container { padding-left: 8px; padding-right: 8px; }
        .search-table-panel, .form-sidebar-panel { padding: 0.75rem !important; border-radius: 0.75rem; }
        .btn-custom-primary, .btn-custom-secondary { padding: 0.55rem 0.85rem; font-size: 0.85rem; }
    }
    
    .clickable-image { cursor: pointer; }
    
    .autosave-indicator {
        font-size: 0.7rem;
        color: #10b981;
        margin-top: 0.25rem;
        display: none;
    }
    .autosave-indicator.show { display: block; }

    .form-header-custom {
        background: linear-gradient(135deg, var(--secondary), var(--primary-dark));
        border-radius: 24px;
        padding: 20px 16px;
        margin-bottom: 20px;
        text-align: center;
        width: 88%;
        margin-left: 6%;
        margin-right: 6%;
    }

    @media (max-width: 768px) {
        .form-header-custom {
            width: 94%;
            margin-left: 3%;
            margin-right: 3%;
            padding: 16px 12px;
            border-radius: 18px;
        }
        .form-header-custom h1 { font-size: 1.2rem; }
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
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    @media (max-width: 768px) {
        .form-logo-custom { width: 60px; height: 60px; border-radius: 16px; margin-bottom: 1rem; }
        .form-logo-custom i { font-size: 1.8rem; }
    }
    
    body.dark-mode .form-logo-custom { background-color: #334155; }

    body.dark-mode .table-responsive {
        background-color: #1e293b !important;
        border-radius: 12px;
        color: #cbd5e1 !important;
    }
    
    body.dark-mode .table-responsive table { color: #e2e8f0 !important; }
    body.dark-mode .table-responsive table th {
        background: #4a6491 !important;
        color: #cbd5e1 !important;
    }
    body.dark-mode .table-responsive table td {
        border-bottom-color: #334155;
        background-color: #1e293b;
        color: #e2e8f0 !important;
    }
    body.dark-mode .table-responsive table tr:hover { background-color: #334155 !important; }
    body.dark-mode .table-responsive table .table-selected-row {
        background-color: #334155 !important;
        border-left-color: var(--primary);
    }

    .select-arrow {
        cursor: pointer;
        font-size: 1.2rem;
        color: var(--primary);
        transition: transform 0.2s;
        display: inline-block;
    }
    .select-arrow:hover { transform: translateX(-3px); color: var(--secondary); }

    @media (max-width: 768px) {
        .table-responsive {
            max-height: none !important;
            overflow: visible !important;
            background: transparent !important;
            border-radius: 0 !important;
        }

        .product-table { display: block; width: 100%; }
        .product-table thead { display: none; }
        .product-table tbody { display: block; width: 100%; }
        .product-table tbody tr {
            display: block;
            background: white;
            border-radius: 12px;
            margin-bottom: 10px;
            padding: 12px;
            border: 1px solid var(--border-color);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            cursor: pointer;
        }
        body.dark-mode .product-table tbody tr {
            background: #1e293b;
            border-color: #334155;
        }

        .product-table tbody tr.duplicate-warning {
            background: #fff3cd !important;
            border-left: 4px solid var(--warning);
        }
        body.dark-mode .product-table tbody tr.duplicate-warning {
            background: rgba(245, 158, 11, 0.15) !important;
        }
        .product-table tbody tr.table-selected-row {
            background: #e0e7ff !important;
            border-right: 4px solid var(--primary);
        }
        body.dark-mode .product-table tbody tr.table-selected-row {
            background: #1e3a5f !important;
        }

        .product-table tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 0 !important;
            border: none !important;
            border-bottom: 1px solid var(--border-color) !important;
            font-size: 0.85rem;
            text-align: right;
            gap: 8px;
            background: transparent !important;
        }
        body.dark-mode .product-table tbody td {
            border-bottom-color: #334155 !important;
            color: #e2e8f0;
        }

        .product-table tbody td:last-child {
            border-bottom: none !important;
            justify-content: center;
            padding-top: 10px !important;
            margin-top: 6px;
            border-top: 1px solid var(--border-color) !important;
        }
        body.dark-mode .product-table tbody td:last-child {
            border-top-color: #334155 !important;
        }

        .product-table tbody td::before {
            content: attr(data-label);
            font-weight: 700;
            font-size: 0.7rem;
            color: var(--primary);
            text-transform: uppercase;
            flex-shrink: 0;
            text-align: left;
        }
        body.dark-mode .product-table tbody td::before { color: #94a3b8; }
        .product-table tbody td:last-child::before { display: none; }
        .product-table tbody td:first-child { display: none; }

        .product-table tbody td img.clickable-image {
            width: 60px !important;
            height: 60px !important;
            border-radius: 10px !important;
            margin: 0 auto;
            display: block;
        }

        .product-table tbody td[data-label="ناوی کاڵا"] {
            font-size: 1rem;
            font-weight: 700;
            color: var(--primary);
            border-bottom: 2px solid var(--border-color) !important;
            padding-bottom: 10px !important;
            justify-content: center;
            text-align: center;
        }
        body.dark-mode .product-table tbody td[data-label="ناوی کاڵا"] { color: #cbd5e1; }
        .product-table tbody td[data-label="ناوی کاڵا"]::before { display: none; }

        .select-arrow {
            font-size: 1.5rem;
            padding: 8px;
            background: rgba(74, 100, 145, 0.1);
            border-radius: 50%;
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        body.dark-mode .select-arrow { background: rgba(108, 141, 184, 0.2); }
    }

    @media (max-width: 480px) {
        .product-table tbody tr { padding: 10px; margin-bottom: 8px; }
        .product-table tbody td { font-size: 0.8rem; padding: 5px 0 !important; }
        .product-table tbody td::before { font-size: 0.65rem; }
        .product-table tbody td[data-label="ناوی کاڵا"] { font-size: 0.9rem; }
    }

    .confirm-overlay {
        display: flex;
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(5px);
        z-index: 99999;
        align-items: center;
        justify-content: center;
        padding: 16px;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }
    .confirm-overlay.active { opacity: 1; visibility: visible; }

    .confirm-modal {
        background: white;
        border-radius: 20px;
        width: 100%;
        max-width: 400px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        animation: confirmSlideIn 0.3s ease;
        overflow: hidden;
    }
    body.dark-mode .confirm-modal {
        background: #1e293b;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.6);
    }

    @keyframes confirmSlideIn {
        from { transform: scale(0.9) translateY(-20px); opacity: 0; }
        to { transform: scale(1) translateY(0); opacity: 1; }
    }

    .confirm-header {
        color: white;
        padding: 18px 20px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .confirm-header i { font-size: 1.5rem; }
    .confirm-header h3 { font-size: 1.1rem; font-weight: 700; margin: 0; }

    .confirm-body {
        padding: 24px 20px;
        text-align: center;
    }
    .confirm-body p {
        font-size: 0.95rem;
        color: var(--text);
        line-height: 1.6;
        margin-bottom: 8px;
    }
    body.dark-mode .confirm-body p { color: #e2e8f0; }

    .confirm-footer {
        padding: 16px 20px;
        display: flex;
        gap: 10px;
        background: var(--bg-light);
        border-top: 1px solid var(--border-color);
    }
    body.dark-mode .confirm-footer {
        background: #0f172a;
        border-top-color: #334155;
    }

    .confirm-btn {
        flex: 1;
        padding: 12px 20px;
        border: none;
        border-radius: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-size: 0.9rem;
    }
    .confirm-btn:active { transform: scale(0.97); }
    .confirm-btn-cancel {
        background: var(--bg-light);
        color: var(--text-secondary);
        border: 2px solid var(--border-color);
    }
    body.dark-mode .confirm-btn-cancel {
        background: #334155;
        color: #e2e8f0;
        border-color: #475569;
    }

    @media (max-width: 576px) {
        input, select, textarea { font-size: 16px !important; }
        .form-control, .form-select { font-size: 16px !important; }
    }

    @media (max-width: 768px) {
        button, .btn, input, select, a {
            -webkit-tap-highlight-color: transparent;
            touch-action: manipulation;
        }
    }
</style>

<div class="card-header form-header-custom text-white text-center py-4">
    <div class="form-logo-custom">
        <i class="fas fa-exclamation-triangle"></i>
    </div>
    <h1 class="h2 mb-2">تۆمارکردنی کاڵای ستۆک</h1>
</div>

<!-- Alert Container -->
<div id="alert-container" style="position: fixed; top: 20px; right: 20px; z-index: 9999; width: 360px; max-width: calc(100vw - 40px);"></div>

<!-- Big Image Modal -->
<div class="modal fade fullscreen-image-modal" id="fullscreenImageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header" style="border: none; background: transparent; position: absolute; top: 0; right: 0; z-index: 10;">
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <img id="fullscreen-image" src="" alt="وێنەی گەورەی کاڵا">
            </div>
        </div>
    </div>
</div>

<!-- Fullscreen Camera for Barcode -->
<div id="fullscreenBarcodeCamera" class="camera-fullscreen">
    <button class="close-camera" id="closeFullscreenBarcodeCamera">&times;</button>
    <video id="fullscreenBarcodeVideo" autoplay playsinline></video>
    <div class="camera-controls-full">
        <button id="switchBarcodeCameraFull" class="btn-switch-full">
            <i class="fas fa-sync-alt"></i> گۆڕینی کامێرا
        </button>
        <button id="captureBarcodeFull" class="btn-capture-full">
            <i class="fas fa-qrcode"></i> سکانکردن
        </button>
    </div>
</div>

<!-- Barcode Scanner Modal -->
<div class="modal fade scanner-modal" id="barcodeScannerModal" tabindex="-1" data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-camera ms-2"></i>سکانکردنی بارکۆد</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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

<!-- Duplicate Barcode Modal -->
<div class="modal fade" id="duplicateBarcodeModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, var(--warning), var(--danger)); color: white;">
                <h5 class="modal-title"><i class="fas fa-exclamation-triangle"></i> بارکۆدی دووبارە</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>ئەم بارکۆدە بۆ زیاتر لە یەک کاڵا تۆمارکراوە. تکایە کاڵاکە هەڵبژێرە:</p>
                <div id="duplicate-products-list"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">داخستن</button>
            </div>
        </div>
    </div>
</div>

<div class="container py-4">
    <div class="row g-4">
        
        <!-- LEFT PANEL -->
        <div class="col-lg-7">
            <div class="search-table-panel p-4">
                
                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold"><i class="fas fa-barcode"></i> بارکۆد</label>
                        <div class="search-input-wrapper">
                            <input type="text" id="filter-barcode" class="form-control" placeholder="بارکۆد...">
                            <button type="button" class="camera-search-btn" id="filter-camera-btn">
                                <i class="fas fa-camera"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold"><i class="fas fa-tag"></i> ناوی کاڵا</label>
                        <input type="text" id="filter-name" class="form-control" placeholder="ناو...">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold"><i class="fas fa-building"></i> کۆمپانیا</label>
                        <input type="text" id="filter-company" class="form-control" placeholder="کۆمپانیا...">
                    </div>
                </div>

                <div class="table-responsive" style="max-height: 550px; overflow-y: auto;">
                    <table class="table table-hover align-middle product-table w-100">
                        <thead class="sticky-top bg-light">
                            <tr>
                                <th>#</th>
                                <th>ناوی کاڵا</th>
                                <th>کۆمپانیا</th>
                                <th>نرخی کڕین</th>
                                <th>وێنە</th>
                                <th>هەڵبژاردن</th>
                            </tr>
                        </thead>
                        <tbody id="products-tbody">
                            <tr><td colspan="6" class="text-center text-muted py-5">گەڕان بکە بۆ دۆزینەوەی کاڵا</td></tr>
                        </tbody>
                    </table>
                </div>
                <div class="mt-2 text-muted small" id="result-count">٠ ئەنجام</div>
                <div id="pagination-container" class="pagination-container"></div>
            </div>
        </div>

        <!-- RIGHT PANEL -->
        <div class="col-lg-5">
            <div class="form-sidebar-panel p-4">
                <div class="text-center mb-3">
                    <div class="form-logo-custom">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <h4 class="fw-bold" style="color: var(--primary);">تۆمارکردنی ستۆک</h4>
                    <p class="text-muted small">پاش هەڵبژاردنی کاڵا، زانیارییەکان پڕ دەبنەوە</p>
                </div>

                <form id="stock-product-form" method="POST">
                    @csrf
                    <input type="hidden" id="selected-product-id" name="product_id">
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">بارکۆد</label>
                        <div class="input-with-icon-custom">
                            <i class="fas fa-barcode"></i>
                            <input type="text" id="selected-barcode" class="form-control readonly-field" readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">ناوی کاڵا</label>
                        <div class="input-with-icon-custom">
                            <i class="fas fa-box"></i>
                            <input type="text" id="selected-name" class="form-control readonly-field" readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">کۆمپانیا</label>
                        <div class="input-with-icon-custom">
                            <i class="fas fa-building"></i>
                            <input type="text" id="selected-company" class="form-control readonly-field" readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">نرخی کڕین</label>
                        <div class="input-with-icon-custom">
                            <i class="fas fa-money-bill-wave"></i>
                            <input type="text" id="selected-price" class="form-control readonly-field" readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-danger">بڕی ستۆک *</label>
                        <div class="input-with-icon-custom">
                            <i class="fas fa-cubes"></i>
                            <input type="number" id="stock-amount" name="amount" class="form-control" placeholder="بڕ" min="1" value="1" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-danger">هۆکاری ستۆک *</label>
                        <div class="input-with-icon-custom">
                            <i class="fas fa-tags"></i>
                            <select id="stock-reason" name="stock_reason" class="form-select" required>
                                <option value="">هەڵبژێرە</option>
                                <option value="شکان">شکان</option>
                                <option value="تێکچون">تێکچوون</option>
                                <option value="بەکار هێنراوە بۆ دوکان">بەکارهێنراوە بۆ دوکان</option>
                                <option value="شتی تر">شتی تر</option>
                            </select>
                        </div>
                        <input type="text" id="custom-reason" name="custom_reason" class="form-control mt-2 d-none" placeholder="هۆکاری دیاری بکە...">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">تێبینی</label>
                        <textarea name="notes" class="form-control" rows="2" placeholder="تێبینی لەسەر ستۆکەکە..."></textarea>
                    </div>

                    <div id="autosave-indicator" class="autosave-indicator text-center">
                        <i class="fas fa-save"></i> پارێزرا
                    </div>

                    <div class="d-flex gap-2 mt-4 flex-column flex-sm-row">
                        <button type="button" id="reset-form-btn" class="btn btn-custom-secondary flex-fill">
                            <i class="fas fa-eraser"></i> پاککردنەوە
                        </button>
                        <button type="submit" id="submit-stock-btn" class="btn btn-custom-primary flex-fill">
                            <i class="fas fa-save"></i> تۆمارکردن
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Shortcuts -->
<div class="shortcut-hint">
    <div class="shortcut-item"><kbd>F1</kbd> <span>تۆمارکردن</span></div>
    <div class="shortcut-item"><kbd>ESC</kbd> <span>پاککردنەوە</span></div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.min.js"></script>

<script>
$(document).ready(function(){
    // ============================================
    // Normalize Numbers
    // ============================================
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
    
    $('#filter-barcode').on('input', function() {
        const originalValue = $(this).val();
        const normalizedValue = normalizeToEnglishNumbers(originalValue);
        if (originalValue !== normalizedValue) {
            const cursorPosition = this.selectionStart;
            $(this).val(normalizedValue);
            this.setSelectionRange(cursorPosition, cursorPosition);
        }
    });
    
    let currentProduct = null;
    let currentProductId = null;
    let isSubmitting = false;
    let searchTimeout = null;
    let autosaveTimer = null;
    let html5QrCode = null;
    let barcodeScannerModal = new bootstrap.Modal(document.getElementById('barcodeScannerModal'));
    let duplicateModal = new bootstrap.Modal(document.getElementById('duplicateBarcodeModal'));
    let fullscreenImageModal = new bootstrap.Modal(document.getElementById('fullscreenImageModal'));
    let currentPage = 1;
    
    let fullscreenBarcodeStream = null;
    let barcodeScanningActive = false;
    let currentFacingMode = 'environment';
    let barcodeScanInterval = null;

    const STORAGE_KEY = 'stock_registration_form';

    // ============================================
    // Helpers
    // ============================================
    function escapeHtml(str) {
        if(!str) return '';
        return String(str).replace(/[&<>"']/g, function(m) {
            if(m === '&') return '&amp;';
            if(m === '<') return '&lt;';
            if(m === '>') return '&gt;';
            if(m === '"') return '&quot;';
            if(m === "'") return '&#39;';
            return m;
        });
    }

    function formatPrice(price) {
        if(!price && price !== 0) return '0';
        return Number(price).toLocaleString();
    }

    function showAlert(type, title, message, duration = 4000) {
        const alertId = 'alert-' + Date.now();
        let icon = '', alertClass = '';
        if(type === 'success') { icon = 'fa-check-circle'; alertClass = 'alert-success-custom'; }
        else if(type === 'error') { icon = 'fa-exclamation-circle'; alertClass = 'alert-error-custom'; }
        else { icon = 'fa-exclamation-triangle'; alertClass = 'alert-warning-custom'; }
        
        const html = `<div id="${alertId}" class="custom-alert ${alertClass}">
                        <i class="fas ${icon}"></i>
                        <div style="flex:1;min-width:0;"><strong>${escapeHtml(title)}</strong><br><small style="word-break:break-word;">${escapeHtml(message)}</small></div>
                        <button class="alert-close" onclick="$('#${alertId}').remove()">×</button>
                      </div>`;
        $('#alert-container').prepend(html);
        setTimeout(() => $(`#${alertId}`).fadeOut(300, function(){ $(this).remove(); }), duration);
    }

    // ============================================
    // Confirm Modal
    // ============================================
    function showConfirmAlert(options) {
        const {
            title = 'پشتڕاستکردنەوە',
            message = '',
            confirmText = 'بەڵێ',
            cancelText = 'پاشگەزبوونەوە',
            onConfirm = null,
            type = 'danger'
        } = options;

        const id = 'confirm-' + Date.now();
        const gradient = type === 'danger' 
            ? 'linear-gradient(135deg, var(--danger), #dc2626)' 
            : 'linear-gradient(135deg, var(--warning), #d97706)';
        const iconClass = type === 'danger' ? 'fa-exclamation-triangle' : 'fa-question-circle';

        const html = `
            <div id="${id}" class="confirm-overlay">
                <div class="confirm-modal">
                    <div class="confirm-header" style="background: ${gradient};">
                        <i class="fas ${iconClass}"></i>
                        <h3>${escapeHtml(title)}</h3>
                    </div>
                    <div class="confirm-body">
                        <p>${escapeHtml(message)}</p>
                    </div>
                    <div class="confirm-footer">
                        <button class="confirm-btn confirm-btn-cancel" data-action="cancel">
                            <i class="fas fa-times"></i> ${escapeHtml(cancelText)}
                        </button>
                        <button class="confirm-btn confirm-btn-danger" data-action="confirm" style="background: ${gradient};color:white;">
                            <i class="fas fa-check"></i> ${escapeHtml(confirmText)}
                        </button>
                    </div>
                </div>
            </div>
        `;

        $('body').append(html);

        setTimeout(() => { $(`#${id}`).addClass('active'); }, 10);

        function close() {
            $(`#${id}`).removeClass('active');
            setTimeout(() => $(`#${id}`).remove(), 300);
        }

        $(`#${id} [data-action="cancel"]`).on('click', close);
        $(`#${id} [data-action="confirm"]`).on('click', function() {
            if (typeof onConfirm === 'function') onConfirm();
            close();
        });
        $(`#${id}`).on('click', function(e) {
            if (e.target === this) close();
        });
    }

    function showAutosaveIndicator() {
        const $indicator = $('#autosave-indicator');
        $indicator.addClass('show');
        setTimeout(() => {
            $indicator.fadeOut(300, function() {
                $(this).removeClass('show').show();
            });
        }, 1500);
    }

    // ============================================
    // LocalStorage
    // ============================================
    function saveFormToLocalStorage() {
        try {
            const formData = {
                selected_product_id: $('#selected-product-id').val(),
                selected_barcode: $('#selected-barcode').val(),
                selected_name: $('#selected-name').val(),
                selected_company: $('#selected-company').val(),
                selected_price: $('#selected-price').val(),
                stock_amount: $('#stock-amount').val(),
                stock_reason: $('#stock-reason').val(),
                custom_reason: $('#custom-reason').val(),
                notes: $('textarea[name="notes"]').val(),
                timestamp: new Date().getTime()
            };
            
            if (formData.selected_product_id && formData.selected_product_id !== '') {
                localStorage.setItem(STORAGE_KEY, JSON.stringify(formData));
                showAutosaveIndicator();
            }
        } catch(e) {}
    }

    function restoreFormFromLocalStorage() {
        const savedData = localStorage.getItem(STORAGE_KEY);
        if (!savedData) return false;
        
        try {
            const data = JSON.parse(savedData);
            const oneHour = 60 * 60 * 1000;
            const now = new Date().getTime();
            
            if (now - (data.timestamp || 0) > oneHour) {
                localStorage.removeItem(STORAGE_KEY);
                return false;
            }
            
            let hasData = false;
            
            if (data.selected_product_id && data.selected_product_id !== '') {
                $('#selected-product-id').val(data.selected_product_id);
                $('#selected-barcode').val(data.selected_barcode || '');
                $('#selected-name').val(data.selected_name || '');
                $('#selected-company').val(data.selected_company || '');
                $('#selected-price').val(data.selected_price || '');
                $('#stock-amount').val(data.stock_amount || 1);
                $('#stock-reason').val(data.stock_reason || '');
                
                if (data.stock_reason === 'شتی تر') {
                    $('#custom-reason').removeClass('d-none').val(data.custom_reason || '');
                }
                
                $('textarea[name="notes"]').val(data.notes || '');
                hasData = true;
                showAlert('info', 'زانیاری پێشوو', 'فۆرمەکە بە داتاکانی پێشوو پڕکرایەوە', 3000);
            }
            
            return hasData;
        } catch(e) { return false; }
    }

    function highlightSelectedProductInTable(productId) {
        $('.product-table tbody tr').removeClass('table-selected-row');
        $(`.product-table tbody tr[data-id="${productId}"]`).addClass('table-selected-row');
    }

    function clearLocalStorageSave() { localStorage.removeItem(STORAGE_KEY); }

    function startAutosave() {
        if (autosaveTimer) clearInterval(autosaveTimer);
        autosaveTimer = setInterval(saveFormToLocalStorage, 3000);
    }

    // ============================================
    // Fullscreen Barcode Camera
    // ============================================
    function startFullscreenBarcodeCamera() {
        if (fullscreenBarcodeStream) stopFullscreenBarcodeCamera();
        
        navigator.mediaDevices.getUserMedia({
            video: { facingMode: currentFacingMode, width: { ideal: 1920 }, height: { ideal: 1080 } },
            audio: false
        }).then(function (mediaStream) {
            fullscreenBarcodeStream = mediaStream;
            const videoElement = document.getElementById('fullscreenBarcodeVideo');
            videoElement.srcObject = mediaStream;
            videoElement.play();
            barcodeScanningActive = true;
            startBarcodeScanning();
        }).catch(function (error) {
            showAlert('error', 'هەڵەی کامێرا', 'ناتواندرێت کامێرا بکرێتەوە');
            closeFullscreenBarcodeCamera();
        });
    }

    function stopFullscreenBarcodeCamera() {
        if (fullscreenBarcodeStream) {
            fullscreenBarcodeStream.getTracks().forEach(track => track.stop());
            fullscreenBarcodeStream = null;
            const videoElement = document.getElementById('fullscreenBarcodeVideo');
            if (videoElement) videoElement.srcObject = null;
        }
        stopBarcodeScanning();
        barcodeScanningActive = false;
    }

    function openFullscreenBarcodeCamera() {
        document.getElementById('fullscreenBarcodeCamera').classList.add('active');
        document.body.style.overflow = 'hidden';
        startFullscreenBarcodeCamera();
    }

    function closeFullscreenBarcodeCamera() {
        document.getElementById('fullscreenBarcodeCamera').classList.remove('active');
        document.body.style.overflow = '';
        stopFullscreenBarcodeCamera();
    }

    function switchBarcodeCamera() {
        currentFacingMode = currentFacingMode === 'environment' ? 'user' : 'environment';
        startFullscreenBarcodeCamera();
    }

    function startBarcodeScanning() {
        if (barcodeScanInterval) clearInterval(barcodeScanInterval);
        const video = document.getElementById('fullscreenBarcodeVideo');
        
        barcodeScanInterval = setInterval(function() {
            if (!barcodeScanningActive || !fullscreenBarcodeStream || !video.videoWidth) return;
            
            const canvas = document.createElement('canvas');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            const ctx = canvas.getContext('2d');
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
            
            if (typeof jsQR !== 'undefined') {
                const code = jsQR(imageData.data, canvas.width, canvas.height, {
                    inversionAttempts: "dontInvert",
                });
                
                if (code) {
                    const normalizedBarcode = normalizeToEnglishNumbers(code.data);
                    barcodeScanningActive = false;
                    stopBarcodeScanning();
                    closeFullscreenBarcodeCamera();
                    $('#filter-barcode').val(normalizedBarcode);
                    triggerSearch();
                    showAlert('success', 'سەرکەوتوو', 'بارکۆد سکان کرا: ' + normalizedBarcode, 5000);
                }
            }
        }, 500);
    }

    function stopBarcodeScanning() {
        if (barcodeScanInterval) {
            clearInterval(barcodeScanInterval);
            barcodeScanInterval = null;
        }
    }

    // ============================================
    // html5-qrcode Scanner
    // ============================================
    async function startBarcodeScanner() {
        await stopBarcodeScanner();
        const qrReader = document.getElementById('qr-reader');
        if (!qrReader) return;
        
        if (html5QrCode) {
            try {
                if (html5QrCode.isScanning) await html5QrCode.stop();
                await html5QrCode.clear();
            } catch(e) {}
        }
        
        html5QrCode = new Html5Qrcode("qr-reader");
        const config = { fps: 10, qrbox: { width: 250, height: 200 }, aspectRatio: 1.0 };
        
        try {
            await html5QrCode.start(
                { facingMode: "environment" },
                config,
                (decodedText) => {
                    if (decodedText) {
                        const normalizedBarcode = normalizeToEnglishNumbers(decodedText);
                        stopBarcodeScanner();
                        barcodeScannerModal.hide();
                        $('#filter-barcode').val(normalizedBarcode);
                        triggerSearch();
                        showAlert('success', 'سەرکەوتوو', 'بارکۆد سکان کرا: ' + normalizedBarcode);
                    }
                },
                () => {}
            );
        } catch (err) {
            showAlert('error', 'هەڵەی کامێرا', 'ناتوانرێت کامێرا بۆ سکانکردن بکرێتەوە');
            barcodeScannerModal.hide();
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

    // ============================================
    // Fullscreen Image
    // ============================================
    function openFullscreenImage(imageSrc) {
        if (imageSrc && imageSrc !== '' && imageSrc !== '#') {
            $('#fullscreen-image').attr('src', imageSrc);
            fullscreenImageModal.show();
        }
    }
    
    $(document).on('click', '#products-tbody td img', function(e) {
        e.stopPropagation();
        openFullscreenImage($(this).attr('src'));
    });
    
    $(document).on('click', '#fullscreen-image', function() {
        fullscreenImageModal.hide();
    });

    // ============================================
    // Load Products
    // ============================================
    function loadAllProducts(barcode, name, company, page = 1) {
        currentPage = page;
        $('#products-tbody').html('<tr><td colspan="6" class="text-center py-4"><div class="spinner-border text-primary"></div> بارکردن...</td></tr>');
        
        const normalizedBarcode = normalizeToEnglishNumbers(barcode);
        
        $.ajax({
            url: '{{ route("products.listt") }}',
            method: 'GET',
            data: { barcode: normalizedBarcode, name: name, company: company, page: page },
            success: function(response) {
                if (response.success) {
                    let products = response.products.data || [];
                    let pagination = response.products;
                    renderProductTable(products);
                    let total = pagination.total || 0;
                    let from = pagination.from || 0;
                    let to = pagination.to || 0;
                    $('#result-count').text(total > 0 ? `نیشاندانی ${from} - ${to} لە کۆی ${total} ئەنجام` : '٠ ئەنجام');
                    renderPagination(pagination, normalizedBarcode, name, company);
                } else {
                    renderEmptyTable();
                    $('#result-count').text('٠ ئەنجام');
                    showAlert('error', 'هەڵە', response.message || 'هەڵەیەک ڕوویدا');
                }
            },
            error: function() {
                renderEmptyTable();
                $('#result-count').text('٠ ئەنجام');
                showAlert('error', 'هەڵە', 'هەڵەی پەیوەندی بە سێرڤەرەوە');
            }
        });
    }
    
    function renderEmptyTable() {
        $('#products-tbody').html('<tr><td colspan="6" class="text-center text-muted py-5">هیچ کاڵایەک نەدۆزرایەوە</td></tr>');
    }
    
    // ═══════════════════════════════════════════════════════════
    // ✅ renderProductTable — لەگەڵ company_name
    // ═══════════════════════════════════════════════════════════
    function renderProductTable(products) {
        const tbody = $('#products-tbody');
        if(!products || !products.length) {
            renderEmptyTable();
            return;
        }
        
        let html = '';
        products.forEach(prod => {
            let imagePath = prod.image_product_path || prod.image_producte_path || prod.image || '';
            let isDuplicate = prod.is_duplicate_barcode || false;
            let duplicateClass = isDuplicate ? 'duplicate-warning' : '';
            let duplicateBadge = isDuplicate ? '<span class="duplicate-badge"><i class="fas fa-copy"></i> دووبارە</span>' : '';
            
            // ✅ ناوی کۆمپانیا
            const companyName = prod.company_name || prod.company || 'بێ کۆمپانیا';
            
            let thumbnail = '';
            let thumbUrl = '';
            if (imagePath) {
                let baseUrl = '{{ url("/") }}';
                thumbUrl = imagePath.startsWith('http') ? imagePath : baseUrl + '/' + imagePath.replace(/^public\/|^storage\//, 'storage/');
                thumbnail = `<img src="${thumbUrl}" style="width: 40px; height: 40px; object-fit: cover; border-radius: 8px;" onerror="this.style.display='none'" class="clickable-image" title="کلیک بکە بۆ گەورەکردن">`;
            } else {
                thumbnail = '<i class="fas fa-image text-muted" style="font-size: 24px;"></i>';
            }
            
            html += `<tr class="${duplicateClass}" data-id="${prod.id}" 
                         data-barcode="${escapeHtml(prod.barcode)}" 
                         data-name="${escapeHtml(prod.name)}" 
                         data-company="${escapeHtml(companyName)}" 
                         data-price="${prod.purchase_price || 0}"
                         data-image="${escapeHtml(imagePath)}"
                         style="cursor:pointer">
                        <td data-label="#" class="text-muted small">${prod.id}</td>
                        <td data-label="ناوی کاڵا" class="fw-bold">${escapeHtml(prod.name)} ${duplicateBadge}</td>
                        <td data-label="کۆمپانیا">${escapeHtml(companyName)}</td>
                        <td data-label="نرخی کڕین">${formatPrice(prod.purchase_price)} IQD</td>
                        <td data-label="وێنە" class="text-center">${thumbnail}</td>
                        <td data-label="هەڵبژاردن" class="text-center"><i class="fas fa-arrow-left select-arrow"></i></td>
                     </tr>`;
        });
        tbody.html(html);
        
        const selectedId = $('#selected-product-id').val();
        if (selectedId) {
            highlightSelectedProductInTable(selectedId);
        }
    }
    
    function renderPagination(pagination, barcode, name, company) {
        if (!pagination || pagination.last_page <= 1) {
            $('#pagination-container').empty();
            return;
        }
        
        let paginationHtml = '<ul class="pagination">';
        if (pagination.current_page > 1) {
            paginationHtml += `<li class="page-item"><a class="page-link" href="#" data-page="${pagination.current_page - 1}">&raquo; پێشتر</a></li>`;
        } else {
            paginationHtml += `<li class="page-item disabled"><span class="page-link">&raquo; پێشتر</span></li>`;
        }
        
        let startPage = Math.max(1, pagination.current_page - 2);
        let endPage = Math.min(pagination.last_page, pagination.current_page + 2);
        
        if (startPage > 1) {
            paginationHtml += `<li class="page-item"><a class="page-link" href="#" data-page="1">1</a></li>`;
            if (startPage > 2) paginationHtml += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
        }
        
        for (let i = startPage; i <= endPage; i++) {
            if (i === pagination.current_page) {
                paginationHtml += `<li class="page-item active"><span class="page-link">${i}</span></li>`;
            } else {
                paginationHtml += `<li class="page-item"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`;
            }
        }
        
        if (endPage < pagination.last_page) {
            if (endPage < pagination.last_page - 1) paginationHtml += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
            paginationHtml += `<li class="page-item"><a class="page-link" href="#" data-page="${pagination.last_page}">${pagination.last_page}</a></li>`;
        }
        
        if (pagination.current_page < pagination.last_page) {
            paginationHtml += `<li class="page-item"><a class="page-link" href="#" data-page="${pagination.current_page + 1}">دواتر &laquo;</a></li>`;
        } else {
            paginationHtml += `<li class="page-item disabled"><span class="page-link">دواتر &laquo;</span></li>`;
        }
        paginationHtml += '</ul>';
        
        $('#pagination-container').html(paginationHtml);
        $('#pagination-container .page-link[data-page]').click(function(e) {
            e.preventDefault();
            const page = $(this).data('page');
            loadAllProducts($('#filter-barcode').val().trim(), $('#filter-name').val().trim(), $('#filter-company').val().trim(), page);
        });
    }

    // ═══════════════════════════════════════════════════════════
    // ✅ fillFormWithProductData — لەگەڵ company_name
    // ═══════════════════════════════════════════════════════════
    function fillFormWithProductData(product) {
        currentProduct = product;
        currentProductId = product.id;
        $('#selected-product-id').val(product.id);
        $('#selected-barcode').val(product.barcode);
        $('#selected-name').val(product.name || 'بێ ناو');
        
        // ✅ ناوی کۆمپانیا
        const companyName = product.company_name || product.company || 'بێ کۆمپانیا';
        $('#selected-company').val(companyName);
        
        $('#selected-price').val(formatPrice(product.purchase_price || 0));
        $('#stock-amount').val(1);
        
        saveFormToLocalStorage();
        
        $('.product-table tbody tr').removeClass('table-selected-row');
        $(`.product-table tbody tr[data-id="${product.id}"]`).addClass('table-selected-row');
        
        if (window.innerWidth <= 992) {
            $('html, body').animate({
                scrollTop: $('.form-sidebar-panel').offset().top - 20
            }, 500);
        }
    }

    function fillFormWithSelected(row) {
        fillFormWithProductData({
            id: row.data('id'),
            barcode: row.data('barcode'),
            name: row.data('name'),
            company: row.data('company'),
            purchase_price: row.data('price'),
            image_product_path: row.data('image')
        });
    }

    function clearFormSelection() {
        $('#stock-product-form')[0].reset();
        $('#selected-product-id').val('');
        $('#selected-barcode').val('');
        $('#selected-name').val('');
        $('#selected-company').val('');
        $('#selected-price').val('');
        $('#stock-amount').val('1');
        $('#stock-reason').val('');
        $('#custom-reason').addClass('d-none').val('');
        $('textarea[name="notes"]').val('');
        $('.product-table tbody tr').removeClass('table-selected-row');
        currentProduct = null;
        currentProductId = null;
        clearLocalStorageSave();
        showAlert('info', 'پاککرایەوە', 'هەموو زانیارییەکان پاککرانەوە', 2000);
    }

    function triggerSearch() {
        const filterBarcode = $('#filter-barcode').val().trim();
        const normalizedBarcode = normalizeToEnglishNumbers(filterBarcode);
        loadAllProducts(normalizedBarcode, $('#filter-name').val().trim(), $('#filter-company').val().trim(), 1);
    }
    
    // ============================================
    // Event Listeners
    // ============================================
    $('#stock-amount, #stock-reason, #custom-reason, textarea[name="notes"]').on('input change', function() {
        if ($('#selected-product-id').val()) {
            saveFormToLocalStorage();
        }
    });
    
    $(document).on('click', '#products-tbody tr', function(e) {
        if ($(e.target).is('.select-arrow') || $(e.target).closest('.select-arrow').length) return;
        if ($(e.target).is('img') || $(e.target).closest('img').length) return;
        fillFormWithSelected($(this));
    });
    
    $(document).on('click', '.select-arrow', function(e) {
        e.stopPropagation();
        fillFormWithSelected($(this).closest('tr'));
    });
    
    $('#filter-barcode, #filter-name, #filter-company').on('input', function() {
        if(searchTimeout) clearTimeout(searchTimeout);
        searchTimeout = setTimeout(triggerSearch, 400);
    });
    
    $('#filter-camera-btn').on('click', function() { barcodeScannerModal.show(); });
    
    $('#barcodeScannerModal').on('shown.bs.modal', function() { startBarcodeScanner(); });
    $('#barcodeScannerModal').on('hidden.bs.modal', function() { stopBarcodeScanner(); });
    
    $('#closeScannerBtn').on('click', function() {
        barcodeScannerModal.hide();
        $('#filter-barcode').focus();
    });
    
    $('#closeFullscreenBarcodeCamera').click(closeFullscreenBarcodeCamera);
    $('#switchBarcodeCameraFull').click(switchBarcodeCamera);
    $('#captureBarcodeFull').click(function() {
        showAlert('info', 'ڕێنمایی', 'کامێرا بە شێوەی خۆکار بارکۆد دەدۆزێتەوە', 2000);
    });
    
    $('#stock-reason').change(function() { 
        $(this).val() === 'شتی تر' ? $('#custom-reason').removeClass('d-none') : $('#custom-reason').addClass('d-none').val(''); 
        if ($('#selected-product-id').val()) saveFormToLocalStorage();
    });
    
    $(document).on('keydown', function(e) {
        if (e.key === 'F1') {
            e.preventDefault();
            $('#submit-stock-btn').click();
        }
        if (e.key === 'Escape') {
            e.preventDefault();
            if (document.getElementById('fullscreenBarcodeCamera').classList.contains('active')) {
                closeFullscreenBarcodeCamera();
            } else {
                $('#reset-form-btn').click();
            }
        }
    });
    
    $('#stock-product-form').submit(function(e) {
        e.preventDefault();
        if(isSubmitting) return;
        const productId = $('#selected-product-id').val();
        const amount = $('#stock-amount').val();
        let reason = $('#stock-reason').val();
        if(!productId) { showAlert('error', 'هەڵە', 'تکایە کاڵایەک هەڵبژێرە'); return; }
        if(!amount || amount < 1) { showAlert('error', 'هەڵە', 'بڕی ستۆک پێویستە'); return; }
        if(!reason) { showAlert('error', 'هەڵە', 'هۆکاری ستۆک دیاری بکە'); return; }
        if(reason === 'شتی تر' && !$('#custom-reason').val()) { showAlert('error', 'هەڵە', 'هۆکاری دی بنووسە'); return; }
        
        let finalReason = (reason === 'شتی تر') ? $('#custom-reason').val() : reason;
        const formData = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            product_id: productId,
            amount: amount,
            stock_reason: finalReason,
            notes: $('textarea[name="notes"]').val(),
        };
        
        isSubmitting = true;
        const $btn = $('#submit-stock-btn');
        const originalHtml = $btn.html();
        $btn.prop('disabled', true).html('<div class="loading-spinner"></div> تۆمار دەکرێت...');
        
        $.ajax({
            url: '{{ route("stock-products.store") }}',
            type: 'POST',
            data: formData,
            success: function(response) {
                if(response.success) {
                    showAlert('success', 'سەرکەوتوو', 'کاڵای ستۆککراو بە سەرکەوتوویی تۆمارکرا');
                    clearFormSelection();
                    triggerSearch();
                } else { showAlert('error', 'هەڵە', response.message || 'هەڵەیەک ڕوویدا'); }
            },
            error: function(xhr) {
                let msg = 'هەڵەی پەیوەندی';
                if(xhr.status === 422) { try { const err = JSON.parse(xhr.responseText); msg = err.message || 'داتا پوختە نییە'; } catch(e) {} }
                showAlert('error', 'هەڵە', msg);
            },
            complete: function() { isSubmitting = false; $btn.prop('disabled', false).html(originalHtml); }
        });
    });
    
    $('#reset-form-btn').click(function() { 
        showConfirmAlert({
            title: 'پاککردنەوەی فۆرم',
            message: 'دڵنیایت کە دەتەوێت هەموو زانیارییەکان پاک بکەیتەوە؟',
            confirmText: 'بەڵێ، پاکی بکەرەوە',
            cancelText: 'پاشگەزبوونەوە',
            type: 'warning',
            onConfirm: function() { clearFormSelection(); }
        });
    });
    
    restoreFormFromLocalStorage();
    startAutosave();
    triggerSearch();
});
</script>
@endsection