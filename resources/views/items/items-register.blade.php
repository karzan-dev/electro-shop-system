@extends('layouts.navigation')

@section('content')
<style>
    body {
        background: #f1f5f9;
        font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
        transition: background-color 0.3s ease, color 0.2s ease;
        overflow-x: hidden;
    }
    
    body.dark-mode { background: #0f172a; }
    
    :root {
        --primary: #4a6491;
        --primary-dark: #2c3e50;
        --secondary: #5d7ab0;
        --accent: #c084fc;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --info: #3b82f6;
        --text: #1e293b;
        --border-color: #e2e8f0;
        --card-bg: #ffffff;
    }
    
    body.dark-mode {
        --primary: #6c8db8;
        --primary-dark: #1e293b;
        --secondary: #5d7ab0;
        --text: #e2e8f0;
        --border-color: #334155;
        --card-bg: #1e293b;
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
    
    .clickable-image { cursor: pointer; transition: all 0.3s ease; }
    .clickable-image:hover { transform: scale(1.02); box-shadow: 0 4px 15px rgba(0,0,0,0.3); }
    
    body.dark-mode .card { background: var(--card-bg) !important; border-color: var(--border-color) !important; }
    body.dark-mode .card-header { background: linear-gradient(135deg, var(--primary), var(--primary-dark)) !important; }
    body.dark-mode .form-control,
    body.dark-mode .form-select {
        background-color: #0f172a;
        border-color: var(--border-color);
        color: var(--text);
    }
    body.dark-mode .form-control:focus { background-color: #1e293b; border-color: var(--primary); color: var(--text); }
    body.dark-mode .form-label { color: var(--text); }
    body.dark-mode .input-with-icon-custom i.field-icon { color: var(--primary); }
    body.dark-mode .existing-image-preview { background: #0f172a; border-color: var(--border-color); }
    body.dark-mode .existing-image-label { color: var(--primary); }
    body.dark-mode .same-barcode-alert { background: linear-gradient(135deg, #451a03, #78350f); border-right-color: var(--warning); }
    body.dark-mode .modal-content { background-color: #1e293b; border-color: var(--border-color); }
    body.dark-mode .btn-close { filter: invert(1) grayscale(100%) brightness(200%); }
    body.dark-mode .product-item-card { background: #0f172a; border-color: var(--border-color); }
    body.dark-mode .product-item-name { color: var(--text); }
    body.dark-mode .product-item-detail { color: #94a3b8; }
    body.dark-mode .form-text { color: #94a3b8; }
    body.dark-mode .btn-custom-secondary { background-color: #0f172a; border-color: var(--primary); color: var(--primary); }
    body.dark-mode .section-title-custom { color: var(--primary); border-bottom-color: var(--accent); }
    body.dark-mode .form-logo-custom { background-color: #334155; }
    body.dark-mode #barcode-container { background: #0f172a; }
    body.dark-mode #barcode-container svg { filter: invert(1); }
    body.dark-mode .form-control::placeholder { color: #98b0a9 !important; }

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
    .input-with-icon-custom { position: relative; }
    .input-with-icon-custom .form-control,
    .input-with-icon-custom select { padding-left: 3rem; padding-right: 3rem; }
    .input-with-icon-custom i.field-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--primary);
        font-size: 1.1rem;
        z-index: 4;
    }
    
    /* AUTOCOMPLETE — LIGHT MODE */
    .autocomplete-items {
        position: absolute;
        border: 1px solid #d4d4d4;
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
        padding: 10px 15px;
        cursor: pointer;
        background-color: #fff;
        border-bottom: 1px solid #f0f0f0;
        font-size: 0.95rem;
        transition: background-color 0.15s ease;
        color: #1e293b;
    }
    .autocomplete-items div:last-child { border-bottom: none; }
    .autocomplete-items div:hover { background-color: #e9e9e9; }
    .autocomplete-items div strong {
        color: var(--primary);
        font-weight: 700;
        background: rgba(192,132,252,0.12);
        padding: 0 2px;
        border-radius: 3px;
    }
    .autocomplete-items div.autocomplete-empty {
        background: #f8fafc !important;
        color: #94a3b8 !important;
        font-style: italic;
        text-align: center;
        cursor: default !important;
        padding: 14px 10px;
    }
    .autocomplete-items div.autocomplete-empty:hover {
        background: #f8fafc !important;
    }
    .autocomplete-active { 
        background-color: var(--primary) !important; 
        color: white !important;
    }
    .autocomplete-active strong {
        color: white !important;
        background: rgba(255,255,255,0.25) !important;
    }

    /* AUTOCOMPLETE — DARK MODE */
    body.dark-mode .autocomplete-items {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.5);
    }
    body.dark-mode .autocomplete-items div {
        background-color: #1e293b !important;
        border-bottom-color: #334155 !important;
        color: #e2e8f0 !important;
    }
    body.dark-mode .autocomplete-items div:hover {
        background-color: #334155 !important;
        color: #ffffff !important;
    }
    body.dark-mode .autocomplete-items div strong {
        color: #c084fc !important;
        background: rgba(192,132,252,0.2) !important;
    }
    body.dark-mode .autocomplete-items div.autocomplete-empty,
    body.dark-mode .autocomplete-items div.autocomplete-empty:hover {
        background-color: #1e293b !important;
        color: #64748b !important;
    }
    body.dark-mode .autocomplete-items div.autocomplete-active {
        background-color: var(--primary) !important;
        color: #ffffff !important;
    }
    body.dark-mode .autocomplete-items div.autocomplete-active strong {
        color: #ffffff !important;
        background: rgba(255,255,255,0.25) !important;
    }

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

    #alert-container {
        position: fixed;
        top: 20px; right: 20px;
        z-index: 99999;
        width: 350px;
        max-width: calc(100vw - 40px);
        pointer-events: none;
    }
    #alert-container > * { pointer-events: auto; }
    .custom-alert {
        border-radius: 12px;
        border: none;
        padding: 16px 20px;
        margin-bottom: 15px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        display: flex;
        align-items: flex-start;
        animation: slideDown 0.3s ease-out;
        position: relative;
        overflow: hidden;
    }
    .custom-alert::before {
        content: '';
        position: absolute;
        left: 0; top: 0;
        width: 5px; height: 100%;
    }
    .alert-success-custom { background: rgba(12, 239, 4, 0.982); color: #065f46; border-left: 5px solid var(--success); }
    .alert-error-custom { background: rgba(239, 12, 4, 0.982); color: #740a0a; border-left: 5px solid var(--danger); }
    .alert-warning-custom { background: rgba(249, 115, 22, 0.98); color: #9a3412; border-left: 5px solid var(--warning); }
    .alert-info-custom { background: rgba(59, 130, 246, 0.98); color: #1e3a8a; border-left: 5px solid var(--info); }
    .alert-icon { font-size: 1.5rem; margin-right: 15px; flex-shrink: 0; margin-top: 2px; }
    .alert-content { flex-grow: 1; min-width: 0; }
    .alert-title { font-weight: 700; font-size: 1.05rem; margin-bottom: 5px; }
    .alert-message { font-size: 0.95rem; line-height: 1.5; word-wrap: break-word; }
    .alert-close {
        background: none; border: none; color: inherit;
        opacity: 0.7; font-size: 1.2rem; cursor: pointer;
        padding: 0; margin-left: 8px; flex-shrink: 0;
    }
    .alert-close:hover { opacity: 1; }
    
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .btn-custom-primary {
        background: linear-gradient(135deg, var(--primary), var(--accent));
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.75rem 1rem;
        box-shadow: 0 4px 15px rgba(74, 100, 145, 0.3);
    }
    .btn-custom-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(74, 100, 145, 0.4); color: white; }
    .btn-custom-secondary {
        background-color: white;
        color: var(--primary);
        border: 2px solid var(--primary);
        font-weight: 600;
        padding: 0.75rem 1rem;
    }
    .btn-custom-secondary:hover { background-color: #f8f9fa; }

    .validation-error { color: var(--danger); font-size: 0.875rem; margin-top: 0.25rem; display: none; }

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

    .barcode-generate-btn {
        position: absolute;
        left: 0.6rem; top: 50%;
        transform: translateY(-50%);
        z-index: 5;
        width: 38px; height: 38px;
        border-radius: 8px;
        background: linear-gradient(135deg, var(--primary), var(--accent));
        border: none;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
    .barcode-scan-btn {
        position: absolute;
        right: 0.6rem; top: 50%;
        transform: translateY(-50%);
        z-index: 5;
        width: 38px; height: 38px;
        border-radius: 8px;
        background: linear-gradient(135deg, var(--primary), var(--accent));
        border: none;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
    .barcode-generate-btn:hover,
    .barcode-scan-btn:hover { transform: translateY(-50%) scale(1.1); }

    .fixed-action-btn {
        position: fixed;
        bottom: 30px; right: 30px;
        z-index: 1000;
    }
    .btn-edit-barcode {
        width: 60px; height: 60px;
        border-radius: 30px;
        background: linear-gradient(135deg, var(--primary), var(--accent));
        border: none;
        color: white;
        font-size: 1.5rem;
        box-shadow: 0 4px 15px rgba(74, 100, 145, 0.4);
    }
    .btn-edit-barcode:hover { transform: scale(1.1); }
    .btn-print-barcode { background: linear-gradient(135deg, #10b981, #059669) !important; }

    .scanner-modal .modal-content { background: #000; border-radius: 1rem; }
    .scanner-modal .modal-header { background: linear-gradient(135deg, var(--primary), var(--secondary)); color: white; border-bottom: none; }
    #qr-reader { width: 100%; overflow: hidden; }
    #qr-reader video { width: 100% !important; min-height: 400px; object-fit: cover; }

    .print-modal .modal-content { border-radius: 1rem; }
    .print-modal .modal-header { background: linear-gradient(135deg, var(--primary), var(--secondary)); color: white; }
    #barcode-container {
        background: white;
        padding: 20px;
        border-radius: 12px;
        display: inline-block;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .existing-image-preview {
        margin-top: 15px;
        padding: 10px;
        background: #f8f9fa;
        border-radius: 8px;
        text-align: center;
    }
    .existing-image-preview img {
        max-width: 200px; max-height: 200px;
        border-radius: 8px;
        border: 2px solid var(--primary);
    }
    .existing-image-label { font-size: 0.85rem; color: var(--primary); margin-top: 5px; }

    .camera-toggle-buttons {
        display: flex;
        justify-content: center;
        gap: 1rem;
        margin-top: 1rem;
    }

    .products-list-modal .modal-content { border-radius: 1rem; max-height: 90vh; }
    .products-list-modal .modal-header { background: linear-gradient(135deg, var(--primary), var(--secondary)); color: white; }
    .products-list-modal .modal-body { max-height: 70vh; overflow-y: auto; }
    .product-item-card {
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        margin-bottom: 15px;
        padding: 15px;
        background: white;
        cursor: pointer;
    }
    .product-item-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.1); transform: translateY(-2px); }
    .product-item-image {
        width: 80px; height: 80px;
        object-fit: cover;
        border-radius: 10px;
        border: 2px solid var(--primary);
    }
    .product-item-name { font-size: 1rem; font-weight: 600; color: var(--secondary); margin-bottom: 5px; }
    .product-item-detail { font-size: 0.85rem; color: #6b7280; margin-bottom: 3px; }
    .stock-badge { padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
    .stock-available { background: #d1fae5; color: #065f46; }
    .stock-low { background: #fed7aa; color: #92400e; }
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
    }
    .same-barcode-alert:hover { background: linear-gradient(135deg, #fde68a, #fcd34d); }
    .same-barcode-alert small { display: block; line-height: 1.4; }

    @media (max-width: 992px) {
        .container.py-5 { padding: 1.5rem 12px !important; }
        .card-body.p-4.p-md-5 { padding: 1.5rem !important; }
        .form-header-custom h1 { font-size: 1.5rem; }
        .form-header-custom p { font-size: 0.9rem; }
        .section-title-custom { font-size: 1.1rem; }
        .form-logo-custom { width: 70px; height: 70px; }
        .form-logo-custom i { font-size: 2.2rem; }
    }

    @media (max-width: 768px) {
        .form-logo-custom {
            width: 60px;
            height: 60px;
            margin-bottom: 1rem;
            border-radius: 16px;
        }
        .form-logo-custom i { font-size: 1.8rem; }
        .form-header-custom { padding: 1.25rem 0.75rem !important; }
        .form-header-custom h1 { font-size: 1.2rem; margin-bottom: 0.25rem; }
        .form-header-custom p { font-size: 0.8rem; }

        .container.py-5 { padding: 0.75rem 8px !important; }
        .card.shadow-lg { border-radius: 12px !important; }
        .card-body.p-4.p-md-5 { padding: 1rem 0.85rem !important; }

        .section-title-custom {
            font-size: 1rem;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
        }
        .section-title-custom i { font-size: 0.95rem; }
        .mb-5 { margin-bottom: 1.5rem !important; }

        .form-label { font-size: 0.88rem; margin-bottom: 0.35rem; }
        .form-control,
        .form-control-lg {
            font-size: 0.95rem !important;
            padding: 0.65rem 0.85rem !important;
            border-radius: 10px;
        }
        .input-with-icon-custom .form-control,
        .input-with-icon-custom select {
            padding-left: 2.6rem !important;
            padding-right: 2.6rem !important;
        }
        .input-with-icon-custom i.field-icon {
            left: 0.8rem;
            font-size: 1rem;
        }

        #product-barcode {
            padding: 0.7rem 2.8rem 0.7rem 3.2rem !important;
            font-size: 0.95rem !important;
        }
        .barcode-generate-btn,
        .barcode-scan-btn {
            width: 32px;
            height: 32px;
            font-size: 0.85rem;
        }
        .barcode-generate-btn { left: 0.4rem; }
        .barcode-scan-btn { right: 0.4rem; }

        .mb-4 { margin-bottom: 1rem !important; }
        .col-md-6.mb-4,
        .col-md-12.mb-4 { margin-bottom: 1rem !important; }

        .btn-custom-primary,
        .btn-custom-secondary {
            width: 100%;
            font-size: 0.9rem;
            padding: 0.7rem 0.85rem;
            border-radius: 10px;
        }
        .d-flex.justify-content-between {
            flex-direction: column-reverse;
            gap: 8px;
        }
        .d-flex.justify-content-between .m-2 { margin: 0.25rem !important; }

        .camera-toggle-buttons {
            flex-direction: column;
            gap: 0.6rem;
            margin-bottom: 1rem !important;
        }
        .camera-toggle-buttons .btn {
            width: 100%;
            font-size: 0.9rem;
        }

        .fixed-action-btn {
            bottom: 18px;
            right: 18px;
        }
        .btn-edit-barcode {
            width: 52px;
            height: 52px;
            font-size: 1.3rem;
        }

        #alert-container {
            top: 10px;
            right: 10px;
            left: 10px;
            width: auto;
            max-width: none;
        }
        .custom-alert {
            padding: 12px 14px;
            margin-bottom: 10px;
            border-radius: 10px;
        }
        .alert-icon {
            font-size: 1.25rem;
            margin-right: 10px;
            margin-top: 1px;
        }
        .alert-title { font-size: 0.95rem; margin-bottom: 3px; }
        .alert-message { font-size: 0.85rem; line-height: 1.4; }
        .alert-close { font-size: 1.1rem; margin-left: 5px; }

        .custom-alert .btn-sm {
            font-size: 0.8rem;
            padding: 0.35rem 0.9rem;
        }

        .same-barcode-alert {
            padding: 10px 12px;
            font-size: 0.85rem;
        }
        .same-barcode-alert strong { font-size: 0.85rem; }
        .same-barcode-alert small { font-size: 0.78rem; }

        #barcode-status { font-size: 0.82rem; }

        .existing-image-preview img {
            max-width: 150px;
            max-height: 150px;
        }
        .existing-image-label { font-size: 0.78rem; }

        .modal-dialog { margin: 0.5rem; }
        .modal-content { border-radius: 12px; }
        .modal-header { padding: 0.85rem 1rem; }
        .modal-header h5 { font-size: 1rem; }
        .modal-body { padding: 0.85rem; }
        .modal-footer { padding: 0.7rem 0.85rem; gap: 0.4rem; }
        .modal-footer .btn { font-size: 0.85rem; padding: 0.45rem 0.8rem; }

        .camera-fullscreen .camera-controls-full {
            bottom: 15px;
            gap: 12px;
            padding: 15px 10px;
            flex-wrap: wrap;
        }
        .camera-fullscreen .camera-controls-full button {
            padding: 12px 18px;
            font-size: 1rem;
            flex: 1;
            min-width: 130px;
        }
        .camera-fullscreen .close-camera {
            top: 12px;
            right: 12px;
            width: 40px;
            height: 40px;
            font-size: 20px;
        }

        #qr-reader video { min-height: 280px; }

        .product-item-card { padding: 12px; }
        .product-item-card .row > div { text-align: center; }
        .product-item-card .col-md-2 { margin-bottom: 8px; }
        .product-item-card .col-md-3 { margin-top: 8px; }
        .product-item-image {
            width: 70px;
            height: 70px;
        }
        .product-item-name { font-size: 0.95rem; }
        .product-item-detail { font-size: 0.8rem; }
        .btn-view-product {
            width: 100%;
            padding: 7px 12px;
            font-size: 0.82rem;
        }

        #barcode-container { padding: 12px; }
        #barcode-container svg { max-width: 100%; height: auto; }

        #file-upload-section .input-group { flex-wrap: nowrap; }
        #file-upload-section .form-control { font-size: 0.82rem; }

        .fullscreen-image-modal .btn-close {
            top: 12px;
            right: 12px;
            width: 36px;
            height: 36px;
        }

        .autocomplete-items { max-height: 220px; }
        .autocomplete-items div { padding: 9px 12px; font-size: 0.9rem; }
    }

    @media (max-width: 480px) {
        .container.py-5 { padding: 0.5rem 6px !important; }
        .card-body.p-4.p-md-5 { padding: 0.85rem 0.7rem !important; }

        .form-logo-custom {
            width: 52px;
            height: 52px;
            border-radius: 14px;
        }
        .form-logo-custom i { font-size: 1.5rem; }
        .form-header-custom h1 { font-size: 1.05rem; }
        .form-header-custom p { font-size: 0.72rem; }

        .section-title-custom { font-size: 0.92rem; }
        .form-label { font-size: 0.82rem; }

        .form-control,
        .form-control-lg {
            font-size: 0.88rem !important;
            padding: 0.6rem 0.7rem !important;
        }

        #product-barcode {
            padding: 0.6rem 2.5rem 0.6rem 2.9rem !important;
            font-size: 0.88rem !important;
        }
        .barcode-generate-btn,
        .barcode-scan-btn {
            width: 28px;
            height: 28px;
            font-size: 0.75rem;
        }

        .btn-custom-primary,
        .btn-custom-secondary {
            font-size: 0.85rem;
            padding: 0.65rem 0.7rem;
        }

        .custom-alert { padding: 10px 12px; }
        .alert-icon { font-size: 1.1rem; margin-right: 8px; }
        .alert-title { font-size: 0.88rem; }
        .alert-message { font-size: 0.78rem; }

        .camera-fullscreen .camera-controls-full button {
            font-size: 0.9rem;
            padding: 10px 14px;
            min-width: 110px;
        }

        .btn-edit-barcode {
            width: 48px;
            height: 48px;
            font-size: 1.15rem;
        }

        .product-item-image { width: 60px; height: 60px; }
        .product-item-name { font-size: 0.88rem; }
        .product-item-detail { font-size: 0.75rem; }

        .modal-dialog { margin: 0.4rem; }
        .modal-header h5 { font-size: 0.92rem; }
        .modal-footer .btn { font-size: 0.78rem; padding: 0.4rem 0.7rem; }

        .autocomplete-items div { padding: 8px 10px; font-size: 0.85rem; }
    }

    @media (max-width: 768px) and (orientation: landscape) {
        .form-header-custom { padding: 0.85rem 0.75rem !important; }
        .form-logo-custom {
            width: 45px;
            height: 45px;
            margin-bottom: 0.5rem;
        }
        .form-logo-custom i { font-size: 1.35rem; }
        .form-header-custom h1 { font-size: 1rem; }
        .form-header-custom p { font-size: 0.72rem; }
        .camera-fullscreen .camera-controls-full { bottom: 8px; padding: 8px; }
    }

    @media (hover: none) and (pointer: coarse) {
        .form-control,
        .form-control-lg,
        .form-select {
            font-size: 16px !important;
        }
        #product-barcode {
            font-size: 16px !important;
        }
    }
</style>

<!-- Alert Container -->
<div id="alert-container"></div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-11">
            <div class="card shadow-lg overflow-hidden">

                <div class="card-header form-header-custom text-white text-center py-4">
                    <div class="form-logo-custom">
                        <i class="fas fa-tag"></i>
                    </div>
                    <h1 class="h2 mb-2">زیادکردنی کاڵای نوێ</h1>
                    <p class="mb-0 opacity-75">تۆمارکردنی کاڵای نوێ بۆ کۆگا و دوکان</p>
                </div>

                <div class="card-body p-4 p-md-5">
                    <form id="product-form" method="POST" enctype="multipart/form-data">
                        @csrf

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
                                        <input type="text" id="product-barcode" name="barcode"
                                               class="form-control form-control-lg"
                                               placeholder="ژمارەی بارکۆد بنوسە ..."
                                               autocomplete="off" required>
                                        <button type="button" id="auto-barcode-btn" class="barcode-generate-btn" title="دروستکردنی بارکۆدی ئەلێاتۆری">
                                            <i class="fas fa-magic"></i>
                                        </button>
                                        <button type="button" id="scan-barcode-camera-btn" class="barcode-scan-btn" title="سکانکردنی بارکۆد بە کامێرا">
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
                                    <div class="validation-error" id="name-error"></div>
                                </div>

                                <!-- 🏢 کۆمپانیا -->
                                <div class="col-md-6 mb-4">
                                    <label for="company-name" class="form-label fw-semibold">
                                        ناوی کۆمپانیا
                                        <small class="text-muted">(ئارەزوومەندانە)</small>
                                    </label>
                                    <div class="input-with-icon-custom" style="position: relative;">
                                        <i class="fas fa-building field-icon"></i>
                                        <input type="text" id="company-name" name="company_name"
                                               class="form-control form-control-lg"
                                               placeholder="ناوی کۆمپانیا بنووسە..."
                                               autocomplete="off">
                                        <input type="hidden" id="company-id" name="company_id" value="">
                                    </div>
                                    <div class="validation-error" id="company_id-error"></div>
                                </div>

                                <!-- ⭐ ناوی فرۆشیار -->
                                <div class="col-md-12 mb-4">
                                    <label for="seller-name" class="form-label fw-semibold">
                                        <span class="text-danger">*</span> ناوی فرۆشیار
                                    </label>
                                    <div class="input-with-icon-custom" style="position: relative;">
                                        <i class="fas fa-user-tie field-icon"></i>
                                        <input type="text" id="seller-name" name="seller"
                                               class="form-control form-control-lg"
                                               placeholder="ناوی فرۆشیار بنووسە ..."
                                               autocomplete="off" required>
                                    </div>
                                    <div class="validation-error" id="seller-error"></div>
                                </div>
                            </div>
                        </div>

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

                                <div id="camera-section" class="d-none"></div>

                                <div id="file-upload-section" class="d-none">
                                    <div class="input-group mb-3">
                                        <input type="file" id="file-input" name="image_product_camera"
                                               accept="image/*" class="form-control">
                                    </div>
                                    <div id="file-preview" class="mt-3 text-center d-none">
                                        <img id="file-preview-image" src="" alt="پیشاندانی فایل"
                                             class="img-thumbnail clickable-image" style="max-height: 200px;">
                                    </div>
                                </div>

                                <div id="existing-image-container" class="existing-image-preview d-none">
                                    <img id="existing-product-image" src="" alt="وێنەی کاڵا" class="clickable-image">
                                    <div class="existing-image-label">وێنەی ئێستای کاڵا - کلیک بکە بۆ گەورەکردن</div>
                                </div>

                                <input type="hidden" id="captured-image-data" name="captured_image">
                                <input type="hidden" id="image-source-type" name="image_source_type" value="">
                                <input type="hidden" id="existing-image-path" name="existing_image_path" value="">
                                <div class="validation-error" id="image_product_camera-error"></div>
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

<!-- Fullscreen Camera Modal -->
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
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <img id="fullscreen-image" src="" alt="وێنەی گەورە">
            </div>
        </div>
    </div>
</div>

<!-- Barcode Scanner Modal -->
<div class="modal fade scanner-modal" id="barcodeScannerModal" tabindex="-1" data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-camera ms-2"></i>سکانکردنی بارکۆد</h5>
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

<!-- Print Barcode Modal -->
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

<!-- Same Barcode Products Modal -->
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
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="mt-3">بارکردنی زانیاری...</p>
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

<!-- Fixed Reset Button -->
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
// DARK MODE
// ============================================
(function() {
    const savedTheme = localStorage.getItem('kurdistan_market_theme_dashboard');
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    let isDarkMode = savedTheme === 'dark' || (!savedTheme && prefersDark);
    
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
        applyDarkMode(!document.body.classList.contains('dark-mode'));
    };
    
    applyDarkMode(isDarkMode);
})();

$(document).ready(function () {

    let fullscreenStream = null;
    let capturedImageBlob = null;
    let isSubmitting = false;
    let currentFacingMode = 'environment';
    let html5QrCode = null;
    let currentBarcodeProducts = null;
    let sellersList = [];
    let companiesList = [];

    let fullscreenImageModal = new bootstrap.Modal(document.getElementById('fullscreenImageModal'));

    // ============================================
    // 🔐 escapeHtml
    // ============================================
    function escapeHtml(text) {
        if (!text) return '';
        return String(text)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;');
    }

    // ============================================
    // Normalize Barcode
    // ============================================
    function normalizeBarcodeToEnglish(barcode) {
        if (!barcode) return barcode;
        const kurdishNumbers = ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];
        const persianNumbers = ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];
        const englishNumbers = ['0','1','2','3','4','5','6','7','8','9'];
        let result = barcode.toString();
        
        for (let i = 0; i < kurdishNumbers.length; i++) {
            result = result.replace(new RegExp(kurdishNumbers[i], 'g'), englishNumbers[i]);
        }
        for (let i = 0; i < persianNumbers.length; i++) {
            result = result.replace(new RegExp(persianNumbers[i], 'g'), englishNumbers[i]);
        }
        return result.replace(/[^0-9A-Za-z\-_]/g, '');
    }
    
    $('#product-barcode').on('input', function() {
        const original = $(this).val();
        const normalized = normalizeBarcodeToEnglish(original);
        if (original !== normalized) {
            const pos = this.selectionStart;
            $(this).val(normalized);
            this.setSelectionRange(pos, pos);
        }
    });

    // ============================================
    // Fullscreen Image
    // ============================================
    function openFullscreenImage(imageSrc) {
        if (imageSrc && imageSrc !== '' && imageSrc !== '#') {
            $('#fullscreen-image').attr('src', imageSrc);
            fullscreenImageModal.show();
        }
    }
    
    $(document).on('click', '#existing-product-image, #file-preview-image', function() {
        openFullscreenImage($(this).attr('src'));
    });
    $(document).on('click', '#fullscreen-image', function() {
        fullscreenImageModal.hide();
    });

    // ============================================
    // 🏢 Load Companies
    // ============================================
    function loadCompanies() {
        return $.ajax({
            url: '{{ route("companies.list") }}',
            type: 'GET',
            success: function(response) {
                if (response.success && response.companies) {
                    companiesList = response.companies.map(function(item) {
                        return {
                            id: parseInt(item.id),
                            name: item.company
                        };
                    });
                    console.log('✅ کۆمپانیاکان نوێکرانەوە. کۆی:', companiesList.length);
                    setupCompanyAutocomplete();
                }
            },
            error: function(xhr) {
                console.error('❌ هەڵە لە بارکردنی کۆمپانیاکان:', xhr);
            }
        });
    }

    // ============================================
    // 🔎 Company Autocomplete
    // ============================================
    function setupCompanyAutocomplete() {
        const inp = document.getElementById('company-name');
        if (!inp) return;

        if (inp._companyAcSetup) {
            console.log('ℹ️ Company Autocomplete پێشتر دامەزراوە');
            return;
        }
        inp._companyAcSetup = true;

        let currentFocus = -1;

        inp.addEventListener("input", function () {
            const val = this.value.trim();
            closeAllLists();
            if (!val) {
                document.getElementById('company-id').value = '';
                return;
            }

            currentFocus = -1;
            const a = document.createElement("DIV");
            a.setAttribute("class", "autocomplete-items");
            this.parentNode.appendChild(a);

            const lowerVal = val.toLowerCase();
            let matchCount = 0;

            for (let i = 0; i < companiesList.length && matchCount < 50; i++) {
                const item = companiesList[i];
                if (!item || !item.name) continue;

                const lowerName = item.name.toLowerCase();
                const matchIndex = lowerName.indexOf(lowerVal);

                if (matchIndex !== -1) {
                    const b = document.createElement("DIV");

                    const before = item.name.substring(0, matchIndex);
                    const match  = item.name.substring(matchIndex, matchIndex + val.length);
                    const after  = item.name.substring(matchIndex + val.length);

                    b.innerHTML = escapeHtml(before)
                                + '<strong>' + escapeHtml(match) + '</strong>'
                                + escapeHtml(after);

                    b.innerHTML += "<input type='hidden' value='" + escapeHtml(item.name) + "'>";
                    b.dataset.companyId = item.id;

                    b.addEventListener("click", function () {
                        inp.value = this.getElementsByTagName("input")[0].value;
                        document.getElementById('company-id').value = this.dataset.companyId;
                        closeAllLists();
                        $(inp).trigger('change');
                    });

                    a.appendChild(b);
                    matchCount++;
                }
            }

            if (matchCount === 0) {
                const empty = document.createElement("DIV");
                empty.className = "autocomplete-empty";
                empty.innerHTML = '<i class="fas fa-search"></i> هیچ ئەنجامێک نەدۆزرایەوە';
                empty.addEventListener("click", function (e) {
                    e.stopPropagation();
                });
                a.appendChild(empty);
            }
        });

        inp.addEventListener("keydown", function (e) {
            let x = this.parentNode.querySelectorAll('.autocomplete-items div');

            if (e.keyCode === 40) { currentFocus++; addActive(x); }
            else if (e.keyCode === 38) { currentFocus--; addActive(x); }
            else if (e.keyCode === 13) {
                e.preventDefault();
                if (currentFocus > -1 && x && x[currentFocus]) {
                    x[currentFocus].click();
                }
            }
        });

        inp.addEventListener('blur', function() {
            setTimeout(function() {
                const typedValue = inp.value.trim();
                if (!typedValue) {
                    document.getElementById('company-id').value = '';
                    return;
                }
                const exactMatch = companiesList.find(function(c) {
                    return c.name.toLowerCase() === typedValue.toLowerCase();
                });
                if (exactMatch) {
                    document.getElementById('company-id').value = exactMatch.id;
                } else {
                    document.getElementById('company-id').value = '';
                }
            }, 200);
        });

        function addActive(x) {
            if (!x || !x.length) return false;
            removeActive(x);
            if (currentFocus >= x.length) currentFocus = 0;
            if (currentFocus < 0) currentFocus = x.length - 1;
            if (x[currentFocus] && !x[currentFocus].classList.contains('autocomplete-empty')) {
                x[currentFocus].classList.add("autocomplete-active");
            }
        }
        function removeActive(x) {
            for (let i = 0; i < x.length; i++) x[i].classList.remove("autocomplete-active");
        }
        function closeAllLists(elmnt) {
            const x = document.getElementsByClassName("autocomplete-items");
            for (let i = 0; i < x.length; i++) {
                if (elmnt != x[i] && elmnt != inp) {
                    x[i].parentNode.removeChild(x[i]);
                }
            }
        }
        document.addEventListener("click", function (e) {
            closeAllLists(e.target);
        });
    }

    // ============================================
    // 🔎 Seller Autocomplete — FIXED
    // ============================================
    function simpleAutocomplete(inp) {
        let currentFocus;
        const MAX_RESULTS = 50;

        // ✅ Always remove old listeners by cloning the input
        if (inp._sellerAcSetup) {
            const freshInput = inp.cloneNode(true);
            inp.parentNode.replaceChild(freshInput, inp);
            inp = freshInput;
        }
        inp._sellerAcSetup = true;

        inp.addEventListener("input", function() {
            const val = this.value.trim();
            closeAllLists();
            if (!val) return false;

            currentFocus = -1;

            const a = document.createElement("DIV");
            a.setAttribute("class", "autocomplete-items");
            this.parentNode.appendChild(a);

            const lowerVal = val.toLowerCase();
            let matchCount = 0;

            // ✅ CRITICAL: read from the LIVE sellersList
            for (let i = 0; i < sellersList.length && matchCount < MAX_RESULTS; i++) {
                const item = sellersList[i];
                if (!item) continue;

                const lowerItem = item.toLowerCase();
                const matchIndex = lowerItem.indexOf(lowerVal);

                if (matchIndex !== -1) {
                    const b = document.createElement("DIV");

                    const before = item.substring(0, matchIndex);
                    const match  = item.substring(matchIndex, matchIndex + val.length);
                    const after  = item.substring(matchIndex + val.length);

                    b.innerHTML = escapeHtml(before)
                                + '<strong>' + escapeHtml(match) + '</strong>'
                                + escapeHtml(after);

                    b.innerHTML += "<input type='hidden' value='" + escapeHtml(item) + "'>";

                    b.addEventListener("click", function() {
                        inp.value = this.getElementsByTagName("input")[0].value;
                        closeAllLists();
                        $(inp).trigger('change');
                    });

                    a.appendChild(b);
                    matchCount++;
                }
            }

            if (matchCount === 0) {
                const empty = document.createElement("DIV");
                empty.className = "autocomplete-empty";
                empty.innerHTML = '<i class="fas fa-search"></i> هیچ ئەنجامێک نەدۆزرایەوە';
                empty.addEventListener("click", function(e) {
                    e.stopPropagation();
                });
                a.appendChild(empty);
            }
        });

        inp.addEventListener("keydown", function(e) {
            let x = this.parentNode.querySelectorAll('.autocomplete-items div');

            if (e.keyCode === 40) { currentFocus++; addActive(x); }
            else if (e.keyCode === 38) { currentFocus--; addActive(x); }
            else if (e.keyCode === 13) {
                e.preventDefault();
                if (currentFocus > -1 && x && x[currentFocus]) {
                    x[currentFocus].click();
                }
            }
        });

        function addActive(x) {
            if (!x || !x.length) return false;
            removeActive(x);
            if (currentFocus >= x.length) currentFocus = 0;
            if (currentFocus < 0) currentFocus = x.length - 1;
            if (x[currentFocus] && !x[currentFocus].classList.contains('autocomplete-empty')) {
                x[currentFocus].classList.add("autocomplete-active");
            }
        }
        function removeActive(x) {
            for (let i = 0; i < x.length; i++) x[i].classList.remove("autocomplete-active");
        }
        function closeAllLists(elmnt) {
            const x = document.getElementsByClassName("autocomplete-items");
            for (let i = 0; i < x.length; i++) {
                if (elmnt != x[i] && elmnt != inp) x[i].parentNode.removeChild(x[i]);
            }
        }
        document.addEventListener("click", function(e) { closeAllLists(e.target); });
    }

    // ============================================
    // Autosave
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
                company_name: $('#company-name').val(),
                company_id: $('#company-id').val(),
                seller: $('#seller-name').val(),
                purchase_price: $('#purchase-price').val(),
                selling_price: $('#selling-price').val(),
                minimum_wearhouse: $('#minimum-stock').val(),
                image_source_type: $('#image-source-type').val(),
                captured_image_data: $('#captured-image-data').val(),
                existing_image_path: $('#existing-image-path').val(),
                timestamp: new Date().getTime()
            };
            localStorage.setItem(STORAGE_KEY, JSON.stringify(formData));
        } catch(e) {}
    }
    
    function restoreFormFromLocalStorage() {
        const savedData = localStorage.getItem(STORAGE_KEY);
        if (!savedData) return false;
        try {
            isRestoring = true;
            const data = JSON.parse(savedData);
            let hasData = false;
            if (data.barcode) { $('#product-barcode').val(normalizeBarcodeToEnglish(data.barcode)); hasData = true; }
            if (data.name) { $('#product-name').val(data.name); hasData = true; }
            if (data.company_name) { $('#company-name').val(data.company_name); hasData = true; }
            if (data.company_id) { $('#company-id').val(data.company_id); hasData = true; }
            if (data.seller) { $('#seller-name').val(data.seller); hasData = true; }
            if (data.purchase_price) { $('#purchase-price').val(data.purchase_price); hasData = true; }
            if (data.selling_price) { $('#selling-price').val(data.selling_price); hasData = true; }
            if (data.minimum_wearhouse) { $('#minimum-stock').val(data.minimum_wearhouse); hasData = true; }
            if (data.image_source_type) { $('#image-source-type').val(data.image_source_type); hasData = true; }
            if (data.captured_image_data) {
                $('#captured-image-data').val(data.captured_image_data);
                restoreCapturedImage(data.captured_image_data);
                hasData = true;
            }
            if (data.existing_image_path) {
                $('#existing-image-path').val(data.existing_image_path);
                displayExistingImage(data.existing_image_path);
                hasData = true;
            }
            if (hasData && data.barcode) updateBarcodeStatus(normalizeBarcodeToEnglish(data.barcode));
            return hasData;
        } catch(e) { return false; }
        finally { setTimeout(() => { isRestoring = false; }, 100); }
    }
    
    function restoreCapturedImage(imageData) {
        if (imageData && imageData.startsWith('data:image')) {
            $('#file-preview-image').attr('src', imageData);
            $('#file-preview').removeClass('d-none');
            $('#image-source-type').val('camera');
            $('#file-upload-section').removeClass('d-none');
        }
    }

    function clearLocalStorageSave() { localStorage.removeItem(STORAGE_KEY); }
    function clearFormAndStorage() { clearForm(); clearLocalStorageSave(); }
    function startAutosave() {
        if (autosaveTimer) clearInterval(autosaveTimer);
        autosaveTimer = setInterval(saveFormToLocalStorage, 2000);
    }
    function debouncedSave() {
        if (saveTimeout) clearTimeout(saveTimeout);
        saveTimeout = setTimeout(saveFormToLocalStorage, 500);
    }

    $('#product-form input, #product-form select, #product-form textarea').on('input change', function() {
        if (!isRestoring) debouncedSave();
    });

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // ============================================
    // ⭐ SAVE SELLER — FIXED (adds to sellersList locally)
    // ============================================
    function saveSeller() {
        return new Promise((resolve) => {
            const sellerName = $('#seller-name').val().trim();
            const productName = $('#product-name').val().trim();
            if (!sellerName) return resolve();

            $.ajax({
                url: '{{ route("seller.store") }}',
                type: 'POST',
                data: { _token: '{{ csrf_token() }}', voucher_name: sellerName, product_name: productName },
                success: function(response) {
                    console.log('✅ Seller response:', response);
                    
                    // ✅ Add to sellersList immediately
                    const exists = sellersList.some(function(s) {
                        return s.toLowerCase() === sellerName.toLowerCase();
                    });
                    if (!exists) {
                        sellersList.push(sellerName);
                        console.log('🎉 فرۆشیاری نوێ زیادکرا بۆ لیست:', sellerName, '| کۆی:', sellersList.length);
                    }
                    
                    if (!window.savedSellers) window.savedSellers = [];
                    window.savedSellers.push(sellerName);
                    resolve();
                },
                error: function(xhr) {
                    console.error('❌ هەڵە فرۆشیار:', xhr);
                    resolve();
                }
            });
        });
    }

    // ============================================
    // Load Sellers — FIXED (re-init autocomplete)
    // ============================================
    function loadSellers() {
        $.ajax({
            url: '{{ route("sellers.list") }}',
            type: 'GET',
            success: function(response) {
                if (response.success && response.sellers) {
                    sellersList = response.sellers
                        .map(s => s.name)
                        .filter(name => name !== null && name !== '' && name !== undefined);
                    
                    console.log('✅ فرۆشیارەکان بارکران. کۆی:', sellersList.length);
                    
                    // ✅ Re-init autocomplete (simpleAutocomplete clones the input internally)
                    const sellerInput = document.getElementById('seller-name');
                    if (sellerInput) {
                        simpleAutocomplete(sellerInput);
                    }
                }
            }
        });
    }

    // ============================================
    // Camera Functions
    // ============================================
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
            showAlert('error', 'هەڵەی کامێرا', 'ناتواندرێت کامێرا بکرێتەوە');
            closeFullscreenCamera();
        });
    }

    function stopFullscreenCamera() {
        if (fullscreenStream) {
            fullscreenStream.getTracks().forEach(track => track.stop());
            fullscreenStream = null;
            document.getElementById('fullscreenVideo').srcObject = null;
        }
    }

    function openFullscreenCamera() {
        document.getElementById('fullscreenCamera').classList.add('active');
        document.body.style.overflow = 'hidden';
        startFullscreenCamera();
    }

    function closeFullscreenCamera() {
        document.getElementById('fullscreenCamera').classList.remove('active');
        document.body.style.overflow = '';
        stopFullscreenCamera();
    }

    function switchFullscreenCamera() {
        currentFacingMode = currentFacingMode === 'environment' ? 'user' : 'environment';
        startFullscreenCamera();
    }

    function captureFullscreenPhoto() {
        if (!fullscreenStream) { showAlert('warning', 'ئاگاداری', 'کامێرا کار ناکات'); return; }
        
        const video = document.getElementById('fullscreenVideo');
        const canvas = document.createElement('canvas');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        canvas.getContext('2d').drawImage(video, 0, 0);
        
        canvas.toBlob(function (blob) {
            capturedImageBlob = blob;
            const reader = new FileReader();
            reader.onloadend = function () {
                $('#captured-image-data').val(reader.result);
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
        }, 'image/jpeg', 0.9);
    }

    // ============================================
    // Barcode Scanner
    // ============================================
    async function startBarcodeScanner() {
        const qrReader = document.getElementById('qr-reader');
        if (!qrReader) return;
        if (html5QrCode) {
            try {
                if (html5QrCode.isScanning) await html5QrCode.stop();
                await html5QrCode.clear();
            } catch(e) {}
        }
        html5QrCode = new Html5Qrcode("qr-reader");
        try {
            await html5QrCode.start(
                { facingMode: "environment" },
                { fps: 10, qrbox: { width: 250, height: 200 }, aspectRatio: 1.0 },
                (decodedText) => {
                    const normalized = normalizeBarcodeToEnglish(decodedText);
                    stopBarcodeScanner();
                    $('#barcodeScannerModal').modal('hide');
                    $('#product-barcode').val(normalized).trigger('keyup');
                    saveFormToLocalStorage();
                    $('#product-name').focus();
                    showAlert('success', 'سکان کرا', `بارکۆد: ${normalized}`);
                },
                () => {}
            );
        } catch (err) {
            showAlert('error', 'هەڵە', 'ناتوانرێت کامێرا بکرێتەوە');
            $('#barcodeScannerModal').modal('hide');
        }
    }
    
    async function stopBarcodeScanner() {
        if (html5QrCode && html5QrCode.isScanning) {
            try { await html5QrCode.stop(); await html5QrCode.clear(); } catch(e) {}
        }
    }

    // ============================================
    // Barcode Printing
    // ============================================
    function generateBarcode(barcodeValue) {
        if (!barcodeValue || barcodeValue.trim() === '') return false;
        try {
            JsBarcode("#barcode-svg", normalizeBarcodeToEnglish(barcodeValue), {
                format: "CODE128", lineColor: "#000000", width: 1.8, height: 45,
                displayValue: true, fontSize: 14, font: "Arial", fontOptions: "bold",
                textMargin: 3, margin: 2, background: "#FFFFFF"
            });
            return true;
        } catch(e) { return false; }
    }

    function printBarcodeFromModal() {
        const barcodeValue = $('#product-barcode').val().trim();
        if (!barcodeValue) return;
        
        const normalizedBarcode = normalizeBarcodeToEnglish(barcodeValue);
        const productName = $('#product-name').val().trim();
        const companyName = $('#company-name').val().trim();
        
        let priceValue = $('#selling-price').val().trim();
        let formattedPrice = '';
        if (priceValue) {
            const numericPrice = priceValue.replace(/,/g, '');
            if (!isNaN(numericPrice) && numericPrice !== '') {
                formattedPrice = Number(numericPrice).toLocaleString() + ' د';
            }
        }
        
        const LABEL_WIDTH = 48;
        const LABEL_HEIGHT = 39.38;
        
        const printWindow = window.open('', '_blank', 'width=400,height=300');
        if (!printWindow) {
            showAlert('error', 'هەڵە', 'تکایە Pop-up چالاک بکە');
            return;
        }
        
        printWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="UTF-8">
                <title>چاپی بارکۆد</title>
                <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"><\/script>
                <style>
                    @page { size: ${LABEL_WIDTH}mm ${LABEL_HEIGHT}mm !important; margin: 0 !important; }
                    * { margin: 0; padding: 0; box-sizing: border-box; }
                    html, body {
                        width: ${LABEL_WIDTH}mm !important;
                        height: ${LABEL_HEIGHT}mm !important;
                        background: white !important;
                        overflow: hidden !important;
                    }
                    .barcode-label {
                        width: ${LABEL_WIDTH}mm !important;
                        height: ${LABEL_HEIGHT}mm !important;
                        padding: 1.2mm 1mm !important;
                        text-align: center !important;
                    }
                    .barcode-svg-print {
                        display: block !important;
                        margin: 0 auto !important;
                        width: ${LABEL_WIDTH - 8}mm !important;
                    }
                    .product-name {
                        font-size: 9pt !important;
                        font-weight: bold !important;
                        margin-bottom: 0.5mm !important;
                        direction: rtl !important;
                    }
                    .product-company {
                        font-size: 7pt !important;
                        color: #333 !important;
                        margin-bottom: 0.3mm !important;
                        direction: rtl !important;
                    }
                    .product-price {
                        font-size: 9pt !important;
                        font-weight: bold !important;
                        border-top: 0.5px dashed #ccc !important;
                        padding-top: 0.3mm !important;
                        direction: rtl !important;
                    }
                </style>
            </head>
            <body>
                <div class="barcode-label">
                    ${productName ? `<div class="product-name">${escapeHtml(productName)}</div>` : ''}
                    ${companyName ? `<div class="product-company">${escapeHtml(companyName)}</div>` : ''}
                    <svg id="barcode-print" class="barcode-svg-print"></svg>
                    ${formattedPrice ? `<div class="product-price">${escapeHtml(formattedPrice)}</div>` : ''}
                </div>
                <script>
                    function renderBarcode() {
                        if (typeof JsBarcode === 'undefined') { setTimeout(renderBarcode, 100); return; }
                        const svg = document.getElementById('barcode-print');
                        try {
                            JsBarcode(svg, '${normalizedBarcode}', {
                                format: 'CODE128', width: 1.8, height: 45,
                                displayValue: true, fontSize: 14, margin: 2,
                                textAlign: 'center', font: 'Arial', fontOptions: 'bold'
                            });
                        } catch(e) {}
                        setTimeout(function() { window.print(); setTimeout(function() { window.close(); }, 500); }, 800);
                    }
                    if (document.readyState === 'loading') {
                        document.addEventListener('DOMContentLoaded', renderBarcode);
                    } else { renderBarcode(); }
                <\/script>
            </body>
            </html>
        `);
        printWindow.document.close();
    }

    // ============================================
    // Helpers
    // ============================================
    function displayExistingImage(imagePath) {
        if (!imagePath) return;
        let imageUrl = imagePath;
        if (!imageUrl.startsWith('/') && !imageUrl.startsWith('http')) {
            imageUrl = imageUrl.startsWith('storage/') ? '/' + imageUrl : '/storage/' + imageUrl;
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

    function removeThousandSeparators(value) { return value.toString().replace(/,/g, ''); }

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
        $('#existing-image-container').addClass('d-none');
        $('#existing-image-path').val('');
        $('#same-barcode-products').hide().empty();
        $('#file-preview-image').attr('src', '');
        $('#company-id').val('');
        currentBarcodeProducts = null;
        $('.validation-error').hide().empty();
        $('#product-barcode').focus();
    }

    function showValidationErrors(errors) {
        $('.validation-error').hide().empty();
        $.each(errors, function (field, messages) {
            const errorDiv = $(`#${field.replace(/\./g, '_')}-error`);
            const inputField = $(`[name="${field}"]`);
            if (errorDiv.length && inputField.length) {
                errorDiv.html(messages.join('<br>')).show();
                inputField.addClass('is-invalid');
            }
        });
    }

    function updateBarcodeStatus(barcode) {
        if (!barcode || barcode.trim() === '') {
            $('#barcode-status').text('');
            $('#product-barcode').removeClass('search-inputerror');
            $('#same-barcode-products').hide().empty();
            currentBarcodeProducts = null;
            return;
        }
        
        $('#barcode-status').html('<i class="fas fa-spinner fa-spin"></i> پشکنین...').css('color', '#3b82f6');
        
        $.ajax({
            url: '{{ route("barcode.check") }}',
            type: 'POST',
            data: { _token: '{{ csrf_token() }}', barcode: normalizeBarcodeToEnglish(barcode) },
            success: function(response) {
                if (response.exists && response.products && response.products.length > 0) {
                    currentBarcodeProducts = response.products;
                    let productNames = response.products.map(p => p.company_name || 'بێ کۆمپانیا').join('، ');
                    $('#same-barcode-products').html(`
                        <div class="same-barcode-alert" data-action="show-products">
                            <i class="fas fa-exclamation-triangle text-warning ms-2"></i>
                            <strong>⚠️ بۆ ${response.total_count} کۆمپانیا بەکارهاتووە:</strong><br>
                            <small>${escapeHtml(productNames.substring(0, 100))}</small><br>
                            <span class="text-primary"><i class="fas fa-eye ms-1"></i> کلیک بکە</span>
                        </div>
                    `).show();
                    $('#barcode-status').html(`⚠️ بۆ ${response.total_count} کاڵا بەکارهاتووە`).css('color', '#f59e0b');
                    $('#product-barcode').addClass('search-inputerror');
                } else {
                    $('#barcode-status').html('✅ بارکۆد بەردەستە').css('color', '#10b981');
                    $('#product-barcode').removeClass('search-inputerror');
                    $('#same-barcode-products').hide();
                    currentBarcodeProducts = null;
                }
            }
        });
    }

    // ✅ FIXED: private function (not window global), single click handler
    function showProductsListModal() {
        if (!currentBarcodeProducts || currentBarcodeProducts.length === 0) return;
        
        let html = '';
        currentBarcodeProducts.forEach((product, index) => {
            let imageUrl = product.image_producte_path || '/default-image.jpg';
            if (imageUrl && !imageUrl.startsWith('http') && !imageUrl.startsWith('/')) imageUrl = '/' + imageUrl;
            
            html += `
                <div class="product-item-card" data-product-index="${index}">
                    <div class="row align-items-center">
                        <div class="col-md-2 text-center">
                            <img src="${escapeHtml(imageUrl)}" class="product-item-image" alt="${escapeHtml(product.name)}">
                        </div>
                        <div class="col-md-7">
                            <div class="product-item-name"><i class="fas fa-box"></i> ${escapeHtml(product.name)}</div>
                            <div class="product-item-detail"><i class="fas fa-building"></i> ${escapeHtml(product.company_name || 'بێ کۆمپانیا')}</div>
                        
                            <div class="product-item-detail"><i class="fas fa-tag"></i> ${escapeHtml(product.barcode)}</div>
                            <div class="product-item-detail">نرخی کڕین: ${formatNumberToIQD(product.purchase_price)} د</div>
                            <div class="product-item-detail">نرخی فرۆشتن: ${formatNumberToIQD(product.selling_price)} د</div>
                        </div>
                        <div class="col-md-3 text-center">
                            <button class="btn btn-view-product view-product-btn" data-product-index="${index}">
                                <i class="fas fa-eye"></i> بینین
                            </button>
                        </div>
                    </div>
                </div>
            `;
        });
        
        $('#products-list-container').html(html);
        
        $('.view-product-btn').off('click').on('click', function(e) {
            e.stopPropagation();
            const index = $(this).data('product-index');
            const selected = currentBarcodeProducts[index];
            if (selected) {
                $('#product-name').val(selected.name);
                $('#company-name').val(selected.company_name || '');
                $('#company-id').val(selected.company_id || '');
                $('#seller-name').val(selected.seller || '');
                $('#purchase-price').val(formatNumberToIQD(selected.purchase_price));
                $('#selling-price').val(formatNumberToIQD(selected.selling_price));
                $('#sameBarcodeProductsModal').modal('hide');
            }
        });
        
        $('#sameBarcodeProductsModal').modal('show');
    }

    // ✅ FIXED: single click handler (no double-binding)
    $(document).off('click', '[data-action="show-products"]').on('click', '[data-action="show-products"]', function(e) {
        e.preventDefault();
        e.stopPropagation();
        showProductsListModal();
    });

    // ============================================
    // Event Listeners
    // ============================================
    
    $('#file-input').on('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                $('#file-preview-image').attr('src', event.target.result);
                $('#file-preview').removeClass('d-none');
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
        if (fullscreenStream) stopFullscreenCamera();
        $('#image-source-type').val('file');
    });

    $('#scan-barcode-camera-btn').on('click', function() {
        $('#barcodeScannerModal').modal('show');
    });

    $('#barcodeScannerModal').on('shown.bs.modal', startBarcodeScanner);
    $('#barcodeScannerModal').on('hidden.bs.modal', stopBarcodeScanner);
    $('#closeScannerBtn').on('click', function() {
        $('#barcodeScannerModal').modal('hide');
        $('#product-barcode').focus();
    });

    $('#print-barcode-btn').on('click', function() {
        const barcodeValue = $('#product-barcode').val().trim();
        if (!barcodeValue) { showAlert('warning', 'ئاگاداری', 'بارکۆدێک داخڵ بکە'); return; }
        if (generateBarcode(normalizeBarcodeToEnglish(barcodeValue))) {
            $('#printBarcodeModal').modal('show');
        }
    });
    
    $('#print-barcode-modal-btn').on('click', printBarcodeFromModal);
    $('#printBarcodeModal').on('show.bs.modal', function() {
        const barcodeValue = $('#product-barcode').val().trim();
        if (barcodeValue) generateBarcode(normalizeBarcodeToEnglish(barcodeValue));
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
                url: '{{ route("barcode.check") }}',
                type: 'POST',
                data: { _token: '{{ csrf_token() }}', barcode: candidate },
                success: function(res) {
                    if (res.exists && res.products && res.products.length > 0) {
                        tryBarcode();
                    } else {
                        $('#product-barcode').val(candidate).trigger('keyup');
                        $('#barcode-status').html('✅ بارکۆدی نوێ').css('color', '#10b981');
                        btn.prop('disabled', false).html('<i class="fas fa-magic"></i>');
                        saveFormToLocalStorage();
                        $('#product-name').focus();
                    }
                },
                error: function() {
                    showAlert('error', 'هەڵە', 'دووبارە هەوڵبدەرەوە');
                    btn.prop('disabled', false).html('<i class="fas fa-magic"></i>');
                }
            });
        }
        tryBarcode();
    });
    
    let typingTimer;
    $('#product-barcode').on('keyup', function() {
        clearTimeout(typingTimer);
        let barcode = $(this).val().trim();
        if (!barcode) { 
            $('#barcode-status').text('');
            $('#same-barcode-products').hide().empty();
            currentBarcodeProducts = null;
            return;
        }
        typingTimer = setTimeout(function() {
            updateBarcodeStatus(normalizeBarcodeToEnglish(barcode));
        }, 500);
    });

    $('#purchase-price, #selling-price').on('input', function() {
        let value = removeThousandSeparators($(this).val());
        if (value && !isNaN(value)) $(this).val(formatNumberToIQD(value));
    });
    $('#purchase-price, #selling-price').on('focus', function() {
        $(this).val(removeThousandSeparators($(this).val()));
    });
    $('#purchase-price, #selling-price').on('blur', function() {
        let value = removeThousandSeparators($(this).val());
        if (value && !isNaN(value)) $(this).val(formatNumberToIQD(value));
    });

    $('#reset-form-btn').click(function() {
        showConfirmAlert('ئاگاداری', 'دڵنیایت؟', function(result) {
            if (result) clearFormAndStorage();
        });
    });

    function showConfirmAlert(title, message, callback) {
        const id = 'confirm-' + Date.now();
        $('#alert-container').prepend(`
            <div id="${id}" class="custom-alert alert-warning-custom mb-3">
                <i class="fas fa-question-circle alert-icon"></i>
                <div class="alert-content">
                    <div class="alert-title">${escapeHtml(title)}</div>
                    <div class="alert-message">${escapeHtml(message)}</div>
                    <div style="margin-top:12px; display:flex; gap:8px; flex-wrap:wrap;">
                        <button class="btn btn-sm btn-success" id="yes-${id}">بەڵێ</button>
                        <button class="btn btn-sm btn-secondary" id="no-${id}">نەخێر</button>
                    </div>
                </div>
                <button class="alert-close" onclick="$('#${id}').remove()">×</button>
            </div>
        `);
        $(`#yes-${id}`).on('click', function() { $(`#${id}`).remove(); callback(true); });
        $(`#no-${id}`).on('click', function() { $(`#${id}`).remove(); callback(false); });
    }

    // ============================================
    // ⭐ SUBMIT FORM
    // ============================================
    $('#product-form').submit(async function(e) {
        e.preventDefault();
        if (isSubmitting) return;

        await saveSeller();

        $('#purchase-price').val(removeThousandSeparators($('#purchase-price').val()));
        $('#selling-price').val(removeThousandSeparators($('#selling-price').val()));
        
        const barcodeField = $('#product-barcode');
        barcodeField.val(normalizeBarcodeToEnglish(barcodeField.val()));

        const pp = parseFloat($('#purchase-price').val()) || 0;
        const sp = parseFloat($('#selling-price').val()) || 0;
        if (sp <= pp && sp > 0 && pp > 0) {
            showAlert('error', 'هەڵە', 'نرخی فرۆشتن دەبێت زیاتر بێت');
            return false;
        }

        const formData = new FormData(this);
        isSubmitting = true;
        const submitBtn = $('#submit-btn');
        const origText = submitBtn.html();
        submitBtn.html('<i class="fas fa-spinner fa-spin ms-2"></i>تۆمار دەکرێت...').prop('disabled', true);

        $.ajax({
            url: '{{ route("products.store") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    const companyName = $('#company-name').val().trim();
                    const companyId = response.company_id;

                    console.log('✅ Response:', response);
                    console.log('🏢 Company Name:', companyName, '| ID:', companyId);

                    showAlert('success', 'سەرکەوتوو', 'کاڵاکە تۆمارکرا');

                    // ✅ Add new company locally
                    if (companyName && companyId) {
                        const exists = companiesList.some(function(c) {
                            return c.name.toLowerCase() === companyName.toLowerCase();
                        });

                        if (!exists) {
                            companiesList.push({
                                id: parseInt(companyId),
                                name: companyName
                            });
                            console.log('🎉 کۆمپانیای نوێ زیادکرا:', companyName, '| کۆی:', companiesList.length);
                        }
                    }

                    clearFormAndStorage();

                    // ✅ Refresh both immediately
                    loadCompanies();
                    loadSellers();

                    $("html, body").animate({ scrollTop: 300 }, 500);
                    $('#product-barcode').focus();
                } else {
                    showAlert('error', 'هەڵە', response.message || 'هەڵە');
                }
            },
            error: function(xhr) {
                console.error('❌ Error:', xhr);
                if (xhr.status === 422) {
                    showValidationErrors(xhr.responseJSON.errors);
                    showAlert('error', 'هەڵە', 'زانیارییەکان پشکنین بکە');
                } else {
                    showAlert('error', 'هەڵە', 'هەڵەیەک ڕوویدا');
                }
            },
            complete: function() {
                isSubmitting = false;
                submitBtn.html(origText).prop('disabled', false);
            }
        });
    });

    $(document).on('keydown', function(e) {
        if (e.key === 'Escape') { e.preventDefault(); $('#reset-form-btn').click(); }
        if (e.key === 'F1') { e.preventDefault(); if (!isSubmitting) $('#submit-btn').click(); }
        if (e.key === 'F2') {
            e.preventDefault();
            if ($('#product-barcode').val().trim()) $('#print-barcode-btn').click();
        }
    });

    // ============================================
    // INIT
    // ============================================
    loadCompanies();
    loadSellers();
    
    setTimeout(function() {
        restoreFormFromLocalStorage();
        startAutosave();
    }, 500);

});
</script>
@endsection