<?php $__env->startSection('content'); ?>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<title><?php echo e(config('app.name', 'Laravel')); ?> - فرۆشتنی قەرز</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

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
        --text-secondary: #64748b;
        --border-color: #e2e8f0;
        --bg-light: #f8fafc;
        --card-bg: #ffffff;
        --input-bg: #ffffff;
        --hover-bg: #f8fafc;
        --transition-base: all 0.3s ease;
    }

    body.dark-mode {
        --primary: #6c8db8;
        --primary-dark: #1e293b;
        --secondary: #5d7ab0;
        --text: #e2e8f0;
        --text-secondary: #94a3b8;
        --border-color: #334155;
        --bg-light: #1e293b;
        --card-bg: #1e293b;
        --input-bg: #0f172a;
        --hover-bg: #1e293b;
        background: #0f172a;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }

    body { 
        background: #f1f5f9; 
        font-family: system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif; 
        color: var(--text);
    }

    .sales-container { padding: 12px; min-height: 100vh; max-width: 1600px; margin: 0 auto; }
    @media (min-width: 640px) { .sales-container { padding: 16px; } }
    @media (min-width: 1024px) { .sales-container { padding: 24px; } }

    .form-card {
        background: var(--card-bg);
        border-radius: 20px;
        padding: 16px;
        margin-bottom: 16px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--border-color);
        transition: all 0.2s ease;
    }
    
    body.dark-mode .form-card {
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    }
    
    @media (min-width: 768px) { .form-card { padding: 20px; margin-bottom: 20px; } }

    .section-title {
        font-size: 1.1rem;
        font-weight: 700;
        margin: 0 0 16px 0;
        text-align: center;
        color: var(--text);
        position: relative;
        padding-bottom: 10px;
    }
    @media (min-width: 640px) { .section-title { font-size: 1.2rem; margin-bottom: 18px; } }
    @media (min-width: 1024px) { .section-title { font-size: 1.3rem; margin-bottom: 22px; } }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background: linear-gradient(90deg, var(--primary), var(--secondary));
        border-radius: 2px;
    }

    /* Barcode wrapper */
    .barcode-wrapper { position: relative; width: 100%; }

    .barcode-input {
        background: var(--input-bg) !important;
        color: var(--text) !important;
        border: 2px solid var(--primary) !important;
        font-weight: 600;
        border-radius: 14px;
        padding: 12px 48px 12px 16px;
        width: 100%;
        font-size: 14px;
        transition: all 0.3s;
        box-shadow: 0 2px 8px rgba(74, 100, 145, 0.2);
    }
    
    body.dark-mode .barcode-input {
        border-color: #065f46 !important;
    }
    
    @media (min-width: 640px) { .barcode-input { padding: 14px 52px 14px 18px; font-size: 15px; } }

    .barcode-input:focus {
        transform: scale(1.01);
        box-shadow: 0 8px 20px rgba(74, 100, 145, 0.3);
        outline: none;
    }
    .barcode-input::placeholder { 
        color: #94a3b8; 
        font-style: italic; 
    }
    
    body.dark-mode .barcode-input::placeholder {
        color: #64748b;
    }

    .scan-btn {
        position: absolute;
        right: 8px;
        top: 50%;
        transform: translateY(-50%);
        background: var(--primary);
        border: none;
        color: white;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }
    @media (min-width: 640px) { .scan-btn { width: 40px; height: 40px; font-size: 18px; right: 10px; } }
    .scan-btn:hover { 
        background: var(--secondary);
        transform: translateY(-50%) scale(1.05); 
    }

    /* Search results */
    .barcode-search-results{
        position: absolute;
        background: var(--card-bg);
        border-radius: 16px;
        max-height: 280px;
        overflow-y: auto;
        z-index: 1000;
        box-shadow: 0 20px 35px rgba(0, 0, 0, 0.15);
        width: 100%;
        left: 0;
        top: calc(100% + 5px);
        border: 1px solid var(--border-color);
    }
    
    .name-search-results {
        position: absolute;
        background: var(--card-bg);
        border-radius: 16px;
        max-height: 280px;
        overflow-y: auto;
        z-index: 1000;
        box-shadow: 0 20px 35px rgba(0, 0, 0, 0.15);
        width: 50%;
        border: 1px solid var(--border-color);
    }

    @media (max-width: 768px) {
        .name-search-results {
            width: 100%;
            margin-right: -30px;
        }
    }

    .barcode-result-item, .name-result-item {
        display: flex;
        align-items: center;
        padding: 10px 12px;
        cursor: pointer;
        border-bottom: 1px solid var(--border-color);
        transition: background 0.2s;
        gap: 12px;
    }
    .barcode-result-item:hover, .name-result-item:hover { 
        background: var(--hover-bg); 
    }

    .barcode-result-item img, .name-result-item img {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 10px;
        border: 1px solid var(--border-color);
    }

    .barcode-result-info, .name-result-info { flex: 1; }
    .barcode-result-info h4, .name-result-info h4 { 
        font-size: 13px; 
        font-weight: 700; 
        margin: 0 0 4px; 
        color: var(--text); 
    }
    @media (min-width: 640px) { .barcode-result-info h4, .name-result-info h4 { font-size: 14px; } }
    .barcode-result-info p, .name-result-info p { 
        font-size: 11px; 
        color: var(--text-secondary); 
        margin: 0; 
    }

    .barcode-result-badge {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        padding: 4px 10px;
        border-radius: 30px;
        font-size: 10px;
        font-weight: 600;
        white-space: nowrap;
    }
    .barcode-result-badge.out-of-stock { background: linear-gradient(135deg, #ef4444, #dc2626); }

    /* Input styles */
    .name-input {
        background: var(--input-bg) !important;
        color: var(--text) !important;
        border: 2px solid var(--primary) !important;
        font-weight: 600;
        border-radius: 14px;
        padding: 12px 16px;
        width: 100%;
        font-size: 14px;
        transition: all 0.3s;
        box-shadow: 0 2px 8px rgba(74, 100, 145, 0.2);
    }
    @media (min-width: 640px) { .name-input { padding: 14px 18px; font-size: 15px; } }
    .name-input:focus { 
        transform: scale(1.01); 
        box-shadow: 0 8px 20px rgba(74, 100, 145, 0.3); 
        outline: none; 
    }
    .name-input::placeholder { 
        color: #94a3b8; 
    }
    
    body.dark-mode .name-input::placeholder {
        color: #64748b;
    }

    .total-input, .final-total-input, .payment-input, .credit-display, .customer-input {
        width: 100%;
        border: none;
        font-size: 14px;
        font-weight: 700;
        border-radius: 14px;
        padding: 12px 16px;
        text-align: center;
    }
    @media (min-width: 640px) { 
        .total-input, .final-total-input, .payment-input, .credit-display, .customer-input { 
            font-size: 16px; 
            padding: 14px 18px; 
        } 
    }

    .total-input { 
        background: var(--input-bg) !important; 
        color: var(--text) !important; 
        border: 2px solid #fbbf24 !important; 
    }
    
    .final-total-input { 
        background: var(--input-bg) !important; 
        color: var(--text) !important; 
        border: 2px solid #0ea5e9 !important; 
    }
    
    .payment-input { 
        background: var(--input-bg) !important; 
        color: var(--text) !important; 
        border: 2px solid #10b981 !important; 
    }
    
    .credit-display { 
        background: var(--input-bg) !important; 
        color: var(--text) !important; 
        border: 2px solid #8b5cf6 !important; 
        margin-top: 8px; 
        font-size: 18px; 
        font-weight: 800; 
    }
    
    .customer-input { 
        background: var(--input-bg) !important; 
        color: var(--text) !important; 
        border: 2px solid #8b5cf6 !important; 
        text-align: right; 
        font-weight: 600; 
    }
    
    .customer-input::placeholder {
        color: #94a3b8;
    }
    
    body.dark-mode .customer-input::placeholder {
        color: #64748b;
    }

    #voucher-number {
        background: var(--input-bg) !important;
        color: var(--text) !important;
        border: 2px solid #f59e0b !important;
        font-weight: 800;
        font-size: 15px;
        text-align: center;
    }
    @media (min-width: 640px) { #voucher-number { font-size: 17px; } }

    .block {
        display: block;
        font-size: 11px;
        margin-bottom: 6px;
        color: var(--text);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    @media (min-width: 640px) { .block { font-size: 12px; margin-bottom: 8px; } }

    /* Customer Suggestions */
    .customer-wrapper {
        position: relative;
    }
    .customer-suggestions {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: var(--card-bg);
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        max-height: 250px;
        overflow-y: auto;
        z-index: 1001;
        margin-top: 4px;
        border: 1px solid var(--border-color);
    }
    .customer-suggestion-item:hover {
        background: var(--hover-bg) !important;
    }
    
    .customer-suggestion-item {
        border-bottom: 1px solid var(--border-color) !important;
        color: var(--text);
    }
    
    .customer-suggestion-item div:first-child {
        color: var(--text);
    }

    /* Buttons */
    .btn-primary, .btn-success, .btn-warning, .btn-danger, .btn-info, .btn-credit, .btn-return {
        border: none;
        color: white !important;
        font-weight: 700;
        padding: 12px 16px;
        border-radius: 14px;
        cursor: pointer;
        transition: all 0.2s;
        width: 100%;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        text-decoration: none;
    }
    @media (min-width: 640px) { 
        .btn-primary, .btn-success, .btn-warning, .btn-danger, .btn-info, .btn-credit, .btn-return { 
            padding: 14px 20px; 
            font-size: 14px; 
            gap: 10px; 
        } 
    }

    .btn-primary { background: linear-gradient(135deg, var(--primary), var(--secondary)); box-shadow: 0 4px 12px rgba(74, 100, 145, 0.3); }
    .btn-success { background: linear-gradient(135deg, var(--success), #059669); box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3); }
    .btn-warning { background: linear-gradient(135deg, var(--warning), #d97706); box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3); }
    .btn-danger  { background: linear-gradient(135deg, var(--danger), #dc2626); box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3); }
    .btn-credit  { background: linear-gradient(135deg, #0891b2, #0e7490); box-shadow: 0 4px 12px rgba(8, 145, 178, 0.3); }
    .btn-return  { background: linear-gradient(135deg, #d97706, #b45309); box-shadow: 0 4px 12px rgba(217, 119, 6, 0.3); }

    .btn-primary:hover, .btn-success:hover, .btn-warning:hover, 
    .btn-danger:hover, .btn-credit:hover, .btn-return:hover { 
        transform: translateY(-2px); 
        filter: brightness(1.1); 
    }

    /* Table - FULLY RESPONSIVE */
    .table-container {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        border-radius: 16px;
        border: 1px solid var(--border-color);
        background: var(--card-bg);
    }
    .sales-table {
        width: 100%;
        min-width: 600px;
        border-collapse: collapse;
        font-size: 12px;
        color: var(--text);
    }
    @media (min-width: 640px) { .sales-table { min-width: 700px; font-size: 13px; } }
    @media (min-width: 768px) { .sales-table { min-width: 100%; font-size: 14px; } }

    .sales-table thead th {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        font-weight: 700;
        padding: 12px 6px;
        text-align: center;
        white-space: nowrap;
        font-size: 11px;
    }
    @media (min-width: 640px) { .sales-table thead th { padding: 14px 8px; font-size: 12px; } }
    @media (min-width: 1024px) { .sales-table thead th { padding: 16px 12px; font-size: 13px; } }

    .sales-table tbody td {
        padding: 10px 6px;
        border-bottom: 1px solid var(--border-color);
        text-align: center;
        vertical-align: middle;
    }
    @media (min-width: 640px) { .sales-table tbody td { padding: 12px 8px; } }
    @media (min-width: 1024px) { .sales-table tbody td { padding: 14px 12px; } }
    
    .sales-table tbody tr:hover {
        background: var(--hover-bg);
    }

    .product-info { 
        display: flex; 
        align-items: center; 
        justify-content: flex-start; 
        gap: 8px; 
        cursor: pointer; 
        flex-wrap: wrap; 
    }
    .product-image-thumb { 
        width: 32px; 
        height: 32px; 
        object-fit: cover; 
        border-radius: 8px; 
        border: 1px solid var(--primary); 
    }
    @media (min-width: 640px) { .product-image-thumb { width: 40px; height: 40px; } }
    .product-name { 
        font-weight: 600; 
        color: var(--text); 
        font-size: 11px; 
        word-break: break-word; 
    }
    @media (min-width: 640px) { .product-name { font-size: 13px; } }

    .company-badge {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        padding: 2px 8px;
        border-radius: 20px;
        font-size: 9px;
        font-weight: 600;
        display: inline-block;
        white-space: nowrap;
    }
    @media (min-width: 640px) { .company-badge { font-size: 10px; padding: 3px 10px; } }

    .quantity-controls { 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        gap: 6px; 
        flex-wrap: wrap; 
    }
    .quantity-btn {
        width: 26px;
        height: 26px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 11px;
        transition: all 0.2s;
    }
    @media (min-width: 640px) { .quantity-btn { width: 30px; height: 30px; font-size: 13px; } }
    .quantity-btn:hover {
        transform: scale(1.1);
        filter: brightness(1.2);
    }
    .quantity-input {
        width: 50px;
        text-align: center;
        border: 1px solid var(--primary);
        border-radius: 8px;
        padding: 5px;
        font-size: 12px;
        font-weight: 600;
        background: var(--input-bg);
        color: var(--text);
    }
    @media (min-width: 640px) { .quantity-input { width: 65px; padding: 6px; font-size: 14px; } }

    .delete-btn {
        background: linear-gradient(135deg, var(--danger), #dc2626);
        color: white;
        border: none;
        padding: 6px 10px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 10px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.2s;
    }
    @media (min-width: 640px) { .delete-btn { padding: 8px 12px; font-size: 12px; gap: 6px; } }
    .delete-btn:hover {
        transform: translateY(-1px);
        filter: brightness(1.1);
    }

    /* Layout grids */
    .grid-2 { display: flex; flex-direction: column; gap: 16px; }
    @media (min-width: 992px) { .grid-2 { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; } }

    .grid-3 { display: grid; grid-template-columns: 1fr; gap: 12px; }
    @media (min-width: 640px) { .grid-3 { grid-template-columns: repeat(3, 1fr); gap: 16px; } }

    .grid-4 { display: grid; grid-template-columns: 1fr; gap: 12px; }
    @media (min-width: 640px) { .grid-4 { grid-template-columns: repeat(2, 1fr); gap: 16px; } }
    @media (min-width: 1024px) { .grid-4 { grid-template-columns: repeat(4, 1fr); gap: 20px; } }

    .customer-grid { display: grid; grid-template-columns: 1fr; gap: 12px; margin-bottom: 20px; }
    @media (min-width: 768px) { .customer-grid { grid-template-columns: repeat(3, 1fr); gap: 16px; } }

    /* Scanner Modal */
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
    #qr-reader {
        width: 100%;
        max-width: 500px;
        border-radius: 20px;
        overflow: hidden;
        background: #000;
    }
    #qr-reader video {
        width: 100% !important;
        height: auto !important;
        max-height: 70vh;
        object-fit: cover;
    }
    #qr-reader__dashboard {
        display: none !important;
    }
    .scanner-close {
        position: absolute;
        top: 20px;
        right: 20px;
        background: rgba(255,255,255,0.2);
        border: none;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        color: white;
        font-size: 24px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 20001;
        transition: all 0.2s;
    }
    .scanner-close:hover {
        background: rgba(255,255,255,0.4);
        transform: scale(1.05);
    }
    .scanner-instruction {
        color: white;
        text-align: center;
        margin-top: 20px;
        font-size: 14px;
        background: rgba(0,0,0,0.6);
        padding: 10px 20px;
        border-radius: 40px;
        direction: rtl;
    }
    .scanner-status {
        color: #fbbf24;
        font-size: 12px;
        margin-top: 10px;
        text-align: center;
    }

    /* Image Modal */
    .image-modal {
        display: none;
        position: fixed;
        z-index: 10000;
        left: 0; top: 0;
        width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.95);
        backdrop-filter: blur(10px);
    }
    .modal-content {
        position: relative;
        margin: auto;
        padding: 20px;
        width: 90%;
        max-width: 800px;
        height: 90%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .modal-image { 
        max-width: 100%; 
        max-height: 80vh; 
        object-fit: contain; 
        border-radius: 16px; 
        border: 2px solid white; 
    }
    .close-modal {
        position: absolute;
        top: 20px;
        right: 25px;
        color: white;
        font-size: 35px;
        cursor: pointer;
        background: rgba(255,255,255,0.2);
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }
    .close-modal:hover {
        background: rgba(255,255,255,0.3);
    }
    .modal-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 40px;
        height: 40px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        cursor: pointer;
        transition: all 0.2s;
    }
    .modal-nav:hover {
        background: rgba(255,255,255,0.3);
    }
    .modal-prev { left: 15px; }
    .modal-next { right: 15px; }
    .modal-caption { 
        position: absolute; 
        bottom: 20px; 
        left: 0; 
        right: 0; 
        text-align: center; 
        color: white; 
        font-size: 16px; 
        background: rgba(0,0,0,0.6); 
        padding: 8px; 
        margin: 0 20px; 
        border-radius: 30px; 
    }

    /* Alerts */
    .alert-container {
        position: fixed;
        top: 15px;
        right: 15px;
        z-index: 9999;
        width: calc(100% - 30px);
        max-width: 360px;
    }
    .custom-alert {
        background: var(--card-bg);
        border-radius: 16px;
        padding: 12px;
        margin-bottom: 12px;
        display: flex;
        gap: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        position: relative;
        overflow: hidden;
        color: var(--text);
    }
    .alert-success { border-right: 4px solid var(--success); }
    .alert-error { border-right: 4px solid var(--danger); }
    .alert-warning { border-right: 4px solid var(--warning); }
    .alert-info { border-right: 4px solid var(--info); }
    
    .alert-progress {
        position: absolute;
        bottom: 0; left: 0;
        height: 3px;
        background: currentColor;
        animation: progress 5s linear;
    }
    @keyframes progress { 0% { width: 100%; } 100% { width: 0%; } }

    /* Print styles */
    #print-section { display: none; }
    #print-section.print-show { display: block; }
    @media print {
        body * { visibility: hidden; }
        #print-section, #print-section * { visibility: visible; }
        #print-section { 
            position: absolute; 
            left: 0; 
            top: 0; 
            width: 100%; 
            background: white; 
            color: #000 !important;
        }
        .print-receipt { 
            width: 100%; 
            max-width: 80mm; 
            margin: 0 auto; 
            padding: 10px; 
            font-family: monospace; 
            direction: rtl;
            color: #000 !important;
        }
        .shortcut-hint { display: none; }
    }
    .print-receipt { 
        font-family: monospace; 
        color: #000;
    }
    .print-header { text-align: center; margin-bottom: 15px; }
    .market-name { font-size: 16px; font-weight: bold; }
    .print-table { width: 100%; border-collapse: collapse; margin: 10px 0; }
    .print-table th, .print-table td { 
        border: 1px solid #000; 
        padding: 4px; 
        text-align: center; 
        font-size: 10px; 
    }
    .totals-section { margin-top: 10px; text-align: left; }
    .total-row { display: flex; justify-content: space-between; font-size: 10px; margin-bottom: 4px; }
    .grand { font-weight: bold; font-size: 12px; margin-top: 6px; border-top: 1px dashed #000; padding-top: 4px; }
    .print-footer { text-align: center; margin-top: 15px; font-size: 10px; }

    .shortcut-hint {
        position: fixed;
        bottom: 10px;
        left: 10px;
        background: rgba(0,0,0,0.7);
        color: white;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 10px;
        z-index: 9998;
    }
    .form-header-custom {
        background: linear-gradient(135deg, var(--secondary), var(--primary-dark));
        border-radius: 24px;
        padding: 20px 16px;
        margin-bottom: 20px;
        text-align: center;
    }
    .form-logo-custom {
        background: white;
        width: 70px;
        height: 70px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
    }
    body.dark-mode .form-logo-custom {
        background: var(--primary-dark);
    }

    .no-image-fallback {
        background: #cbd5e1;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }
    body.dark-mode .no-image-fallback {
        background: #475569;
    }
    .credit-positive { animation: pulse 0.5s ease; }
    @keyframes pulse { 
        0% { transform: scale(1); } 
        50% { transform: scale(1.05); } 
        100% { transform: scale(1); } 
    }
    .text-white { color: white; }
    .text-center { text-align: center; }
    .py-4 { padding-top: 1rem; padding-bottom: 1rem; }
    .px-4 { padding-left: 1rem; padding-right: 1rem; }
    .mb-2 { margin-bottom: 0.5rem; }
    .h2 { font-size: 1.5rem; font-weight: bold; }
    .d-flex { display: flex; }
    .justify-content-between { justify-content: space-between; }
    .text-decoration-none { text-decoration: none; }
    
    /* Loading spinner for scanner */
    .scanner-loading {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        text-align: center;
        z-index: 10;
    }
    .spinner {
        width: 40px;
        height: 40px;
        border: 3px solid rgba(255,255,255,0.3);
        border-radius: 50%;
        border-top-color: white;
        animation: spin 1s linear infinite;
        margin: 0 auto 10px;
    }
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    
    /* Dark mode additional styles */
    body.dark-mode input:focus,
    body.dark-mode select:focus,
    body.dark-mode textarea:focus {
        box-shadow: 0 0 0 2px var(--primary);
    }
    
    body.dark-mode select {
        background: var(--input-bg);
        color: var(--text);
        border-color: var(--border-color);
    }
    
    body.dark-mode .search-loading {
        color: var(--text);
    }
</style>

<!-- Image Modal -->
<div id="imageModal" class="image-modal">
    <span class="close-modal" onclick="closeImageModal()">&times;</span>
    <div class="modal-nav modal-prev" onclick="showPrevImage()"><i class="fas fa-chevron-right"></i></div>
    <div class="modal-nav modal-next" onclick="showNextImage()"><i class="fas fa-chevron-left"></i></div>
    <div class="modal-content">
        <img class="modal-image" id="modalImage" src="" alt="وێنەی کاڵا">
        <div class="modal-caption" id="modalCaption"></div>
    </div>
</div>

<!-- Scanner Modal - FIXED -->
<div id="scannerModal" class="scanner-modal">
    <div class="scanner-container">
        <button class="scanner-close" onclick="closeScanner()">
            <i class="fas fa-times"></i>
        </button>
        <div id="qr-reader"></div>
        <div id="scanner-loading" class="scanner-loading" style="display: none;">
            <div class="spinner"></div>
        </div>
        <div class="scanner-instruction">
            <i class="fas fa-camera"></i> بارکۆدەکە بخەرە بەردەم کامێرا
        </div>
        <div id="scanner-status" class="scanner-status"></div>
    </div>
</div>

<!-- Alert Container -->
<div id="alert-container" class="alert-container"></div>

<!-- Print Section -->
<div id="print-section">
    <div class="print-receipt">
        <div class="print-header">
            <div class="market-name">مارکیتی کوردستان</div>
            <div class="address">سلیمانی - کانیکورده</div>
            <div class="datetime">
                <span>به‌روز: <span id="print-date"></span></span>
                <span>کات: <span id="print-time"></span></span>
            </div>
            <div class="voucher-number">ژمارەی پسۆنە: <span id="print-voucher"></span></div>
        </div>
        <table class="print-table" width="100%" cellpadding="4" cellspacing="0" border="1">
            <thead>
                <tr><th>ژ</th><th>ناوی کاڵا</th><th>کۆمپانیا</th><th>ژمارە</th><th>نرخ</th><th>کۆ</th></tr>
            </thead>
            <tbody id="print-table-body"></tbody>
        </table>
        <div class="totals-section">
            <div class="total-row"><span>کۆی گشتی</span><span id="print-subtotal">0</span></div>
            <div class="total-row discount"><span>داشکاندن</span><span id="print-discount">0</span></div>
            <div class="total-row"><span>پارەی پێشەکی</span><span id="print-advance">0</span></div>
            <div class="total-row"><span>کاتی گەڕانەوەی قەرز</span><span id="print-credit-period">0</span></div>
            <div class="total-row grand"><span>قەرزی ماوە</span><span id="print-credit">0</span></div>
        </div>
        <div class="print-footer">
            <div class="thanks">سوپاس بۆ مامەڵەکردن لەگەڵمان</div>
        </div>
    </div>
</div>

<!-- Keyboard Shortcut Hint -->
<div class="shortcut-hint">
    <kbd>F2</kbd> پرینت | <kbd>F1</kbd> تۆمار | <kbd>Esc</kbd> پاككردنەوە
</div>

<!-- Main Container -->
<div class="sales-container">
    <div class="form-header-custom text-white">
        <div class="form-logo-custom">
            <i class="fas fa-hand-holding-usd fa-2x" style="color: var(--accent);"></i>
        </div>
        <h1 style="font-size: 1.4rem; margin-bottom: 8px;">فرۆشتنی بە قەرز</h1>
        <div style="display: flex; gap: 12px; justify-content: center; margin-top: 16px; flex-wrap: wrap;">
            <a href="<?php echo e(route('sales.index')); ?>" class="btn-credit" style="width: auto; padding: 8px 16px;">
                <i class="fas fa-cart-plus"></i> فرۆشتن نەقدی
            </a>
            <a href="<?php echo e(route('delete-invoice')); ?>" class="btn-return" style="width: auto; padding: 8px 16px;">
                <i class="fas fa-undo-alt"></i> گەڕاندنەوەی کاڵا
            </a>
        </div>
        <a href="<?php echo e(route('debtors.save-products')); ?>" class="btn-return mt-3" style="width: auto; padding: 8px 16px;">
                <i class="fas fa-save"></i> تۆماركردنی قه‌رز لای خۆت 
        </a>
    </div>

    <div class="grid-2">
        <!-- Left Column -->
        <div>
            <!-- Customer Information -->
            <div class="form-card">
                <p class="section-title">زانیاری کڕیار</p>
                <div class="customer-grid">
                    <div class="customer-wrapper">
                        <label class="block"><i class="fas fa-user"></i> ناوی کڕیار</label>
                        <input type="text" 
                               id="customer-name" 
                               class="customer-input" 
                               placeholder="ناوی کڕیار بنووسە..." 
                               autocomplete="off" 
                               required>
                        <div id="customer-suggestions" class="customer-suggestions" style="display: none;"></div>
                    </div>
                    <div>
                        <label class="block"><i class="fas fa-phone"></i> مۆبایل / تەلەفون</label>
                        <input type="text" 
                               id="customer-phone" 
                               class="customer-input" 
                               placeholder="ژمارەی مۆبایل..." 
                               autocomplete="off">
                    </div>
                    <div>
                        <label class="block"><i class="fas fa-map-marker-alt"></i> ناونیشان</label>
                        <input type="text" 
                               id="customer-address" 
                               class="customer-input" 
                               placeholder="ناونیشان..." 
                               autocomplete="off">
                    </div>
                </div>
            </div>

            <!-- Search Section -->
            <div class="form-card">
                <p class="section-title">گەڕان بە بارکۆد یان ناوی کاڵا</p>
                <div class="grid-3">
                    <div>
                        <label class="block"><i class="fas fa-barcode"></i> بارکۆد</label>
                        <div class="barcode-wrapper">
                            <input type="text" id="barcode-search" class="barcode-input" placeholder="بارکۆد بنووسە یان سکان بکە..." autocomplete="off">
                            <button type="button" class="scan-btn" onclick="openScanner()">
                                <i class="fas fa-camera"></i>
                            </button>
                            <div id="barcode-search-results" class="barcode-search-results" style="display: none;"></div>
                        </div>
                    </div>
                    <div>
                        <label class="block"><i class="fas fa-box"></i> ناوی کاڵا</label>
                        <input type="text" id="name-search" class="name-input" placeholder="ناوی کاڵا بنووسە..." autocomplete="off">
                        <div id="name-search-results" class="name-search-results" style="display: none;"></div>
                    </div>
                    <div>
                        <label class="block">قازانج</label>
                        <button type="button" onclick="calculateProfit()" class="btn-warning">
                            <i class="fas fa-calculator"></i> قازانج
                        </button>
                    </div>
                </div>
            </div>

            <!-- Voucher Summary -->
            <div class="form-card">
                <p class="section-title">پوختەی پسوڵە</p>
                <div class="grid-4">
                    <div>
                        <label class="block">ژمارەی پسوڵە</label>
                        <input type="text" id="voucher-number" class="total-input" value="<?php echo e($nextVoucherNumber ?? 'INV-0001'); ?>" readonly>
                    </div>
                    <div>
                        <label class="block">کۆی گشتی</label>
                        <input type="text" id="subtotal" class="total-input" value="0" readonly>
                    </div>
                    <div>
                        <label class="block">بڕی داشکاندن</label>
                        <input type="number" id="discount" class="total-input" value="0" min="0" step="100" placeholder="داشکاندن">
                    </div>
                    <div>
                        <label class="block">کۆی کۆتایی</label>
                        <input type="text" id="final-total" class="final-total-input" value="0" readonly>
                    </div>
                </div>
            </div>

            <!-- Items Table -->
            <div class="form-card">
                <p class="section-title">کاڵاکانی فرۆشتن</p>
                <div class="table-container">
                    <table class="sales-table">
                        <thead>
                            <tr>
                                <th width="5%">ژ</th>
                                <th width="30%">ناوی کاڵا</th>
                                <th width="15%">کۆمپانیا</th>
                                <th width="20%">ژمارە</th>
                                <th width="15%">نرخ</th>
                                <th width="15%">کۆ</th>
                                <th width="15%">سڕینەوە</th>
                            </tr>
                        </thead>
                        <tbody id="sales-items">
                            <tr id="empty-message">
                                <td colspan="7" style="text-align: center; padding: 40px; color: var(--text-secondary);">
                                    <i class="fas fa-shopping-cart fa-4x" style="margin-bottom: 15px; opacity: 0.5;"></i>
                                    <p>هیچ کاڵایەک زیاد نەکراوە</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div>
            <div class="form-card">
                <p class="section-title">پارەدان بە قەرز</p>
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    <div>
                        <label class="block">کۆی گشتی</label>
                        <input type="text" id="total-payment" class="final-total-input" value="0" readonly>
                    </div>
                    <div>
                        <label class="block"><i class="fas fa-money-bill-wave"></i> پارەی پێشەکی</label>
                        <input type="number" id="advance-payment" class="payment-input" value="0" min="0" step="1000" placeholder="بڕی پارەی پێشەکی">
                    </div>
                    <div>
                        <label class="block"><i class="fas fa-calendar-alt"></i> کاتی گەڕانەوەی قەرز (ڕۆژ)</label>
                        <input type="number" id="credit-period" class="payment-input" value="30" min="1" max="365" step="1">
                    </div>
                    <div>
                        <label class="block"><i class="fas fa-credit-card"></i> بڕی قەرزی ماوە</label>
                        <div id="credit-display" class="credit-display">
                            <span id="credit-amount">0</span>
                            <span style="font-size: 16px;">دینار</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-card">
                <p class="section-title">کردارەکان</p>
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <button type="button" class="btn-success" onclick="completeSale(false)">
                        <i class="fas fa-file-invoice"></i> تۆمارکردنی قەرز
                    </button>
                    <button type="button" class="btn-primary" onclick="completeSale(true)">
                        <i class="fas fa-print"></i> پرینتکردن
                    </button>
                    <button type="button" class="btn-danger" onclick="clearCart()">
                        <i class="fas fa-trash"></i> پاککردنەوە
                    </button>
                    <button type="button" class="btn-warning" onclick="newInvoice()">
                        <i class="fas fa-file-invoice-dollar"></i> پسوڵەی نوێ
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// ==================== FORCE NUMERIC INPUT FOR BARCODE ====================
function toEnglishNumbers(str) {
    if (!str) return str;
    
    const persianNumbers = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
    const arabicNumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    const englishNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
    
    let result = str;
    
    for (let i = 0; i < persianNumbers.length; i++) {
        result = result.split(persianNumbers[i]).join(englishNumbers[i]);
    }
    
    for (let i = 0; i < arabicNumbers.length; i++) {
        result = result.split(arabicNumbers[i]).join(englishNumbers[i]);
    }
    
    return result;
}

function forceNumericInputForBarcode() {
    const barcodeInput = document.getElementById('barcode-search');
    if (!barcodeInput) return;

    barcodeInput.addEventListener('input', function(e) {
        let rawValue = this.value;
        let englishValue = toEnglishNumbers(rawValue);
        let numericValue = englishValue.replace(/[^0-9]/g, '');
        if (rawValue !== numericValue) {
            this.value = numericValue;
        }
    });

    barcodeInput.addEventListener('keydown', function(e) {
        const allowedKeys = ['Backspace', 'Delete', 'Tab', 'Escape', 'Enter', 'ArrowLeft', 'ArrowRight', 'ArrowUp', 'ArrowDown', 'Home', 'End'];
        if (allowedKeys.includes(e.key)) {
            return;
        }
        
        if (e.ctrlKey && (e.key === 'a' || e.key === 'c' || e.key === 'v' || e.key === 'x')) {
            return;
        }
        
        if (!/^[0-9]$/.test(e.key) && !/^[٠١٢٣٤٥٦٧٨٩]$/.test(e.key) && !/^[۰۱۲۳۴۵۶۷۸۹]$/.test(e.key)) {
            e.preventDefault();
        }
    });
    
    barcodeInput.addEventListener('paste', function(e) {
        e.preventDefault();
        let pastedText = (e.clipboardData || window.clipboardData).getData('text');
        let englishText = toEnglishNumbers(pastedText);
        let numericText = englishText.replace(/[^0-9]/g, '');
        
        const start = this.selectionStart;
        const end = this.selectionEnd;
        const currentValue = this.value;
        const newValue = currentValue.substring(0, start) + numericText + currentValue.substring(end);
        this.value = newValue;
        
        const inputEvent = new Event('input', { bubbles: true });
        this.dispatchEvent(inputEvent);
    });
}

// ==================== GLOBALS ====================
let cart = [];
let barcodeSearchTimeout = null;
let nameSearchTimeout = null;
let customerSearchTimeout = null;
let html5QrCode = null;
let scannerActive = false;
let currentImageIndex = 0;
let productImages = [];

// ==================== LOCALSTORAGE ====================
function saveAllFormDataToLocalStorage() {
    try {
        const allFormData = {
            items: cart,
            timestamp: new Date().getTime(),
            voucherNumber: $('#voucher-number').val(),
            discount: $('#discount').val(),
            advancePayment: $('#advance-payment').val(),
            creditPeriod: $('#credit-period').val(),
            customerName: $('#customer-name').val(),
            customerPhone: $('#customer-phone').val(),
            customerAddress: $('#customer-address').val(),
            version: '2.0'
        };
        localStorage.setItem('credit_sales_all_form_data', JSON.stringify(allFormData));
    } catch (e) { console.error('Error saving:', e); }
}

function loadAllFormDataFromLocalStorage() {
    try {
        const savedData = localStorage.getItem('credit_sales_all_form_data');
        if (savedData) {
            const formData = JSON.parse(savedData);
            const dataAge = new Date().getTime() - (formData.timestamp || 0);
            if (dataAge < 86400000) {
                if (formData.items && Array.isArray(formData.items) && formData.items.length > 0) cart = formData.items;
                if (formData.voucherNumber) $('#voucher-number').val(formData.voucherNumber);
                if (formData.discount !== undefined) $('#discount').val(formData.discount);
                if (formData.advancePayment !== undefined) $('#advance-payment').val(formData.advancePayment);
                if (formData.creditPeriod !== undefined) $('#credit-period').val(formData.creditPeriod);
                if (formData.customerName) $('#customer-name').val(formData.customerName);
                if (formData.customerPhone) $('#customer-phone').val(formData.customerPhone);
                if (formData.customerAddress) $('#customer-address').val(formData.customerAddress);
                renderCart();
                calculateCredit();
                return true;
            } else { localStorage.removeItem('credit_sales_all_form_data'); }
        }
    } catch (e) { console.error('Error loading:', e); }
    return false;
}

function clearCartFromLocalStorage() { try { localStorage.removeItem('credit_sales_all_form_data'); } catch(e) {} }

// ==================== KEYBOARD SHORTCUTS ====================
$(document).on('keydown', function(e) {
    if (e.key === 'F1' || e.keyCode === 112) {
        e.preventDefault();
        if (cart.length > 0) completeSale(false);
        else showAlert('warning', 'هیچ کاڵایەک زیاد نەکراوە');
    }
    else if (e.key === 'F2' || e.keyCode === 113) {
        e.preventDefault();
        if (cart.length > 0) completeSale(true);
        else showAlert('warning', 'هیچ کاڵایەک زیاد نەکراوە');
    }
    else if (e.key === 'Escape' || e.keyCode === 27) {
        e.preventDefault();
        if (cart.length > 0 && confirm('دڵنیایت کە دەتەوێت هەموو کاڵاکان سڕبکەیتەوە؟')) clearCart();
    }
});

// ==================== CUSTOMER AUTOCOMPLETE ====================
function searchCustomerSuggestions(term) {
    if (!term || term.length < 1) {
        $('#customer-suggestions').hide();
        return;
    }
    
    $.ajax({
        url: '/customers/search',
        type: 'POST',
        data: { search_term: term, _token: $('meta[name="csrf-token"]').attr('content') },
        success: function(res) {
            if (res.success && res.customers && res.customers.length > 0) {
                let html = '';
                res.customers.forEach(function(c) {
                    html += `
                        <div class="customer-suggestion-item" 
                             onclick='selectCustomer("${escapeHtml(c.name)}", "${escapeHtml(c.number_phone || '')}", "${escapeHtml(c.address || '')}")'
                             style="padding: 10px 15px; cursor: pointer; border-bottom: 1px solid #e2e8f0; transition: all 0.2s; display: flex; align-items: center; gap: 10px;">
                            <div style="width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, #4a6491, #5d7ab0); color: white; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="fas fa-user"></i>
                            </div>
                            <div style="flex: 1;">
                                <div style="font-weight: 600; font-size: 13px;">${escapeHtml(c.name)}</div>
                                <div style="font-size: 11px; color: #64748b;">
                                    ${c.number_phone ? '<i class="fas fa-phone"></i> ' + escapeHtml(c.number_phone) : ''}
                                    ${c.number_phone && c.address ? ' | ' : ''}
                                    ${c.address ? '<i class="fas fa-map-marker-alt"></i> ' + escapeHtml(c.address) : ''}
                                </div>
                            </div>
                        </div>`;
                });
                $('#customer-suggestions').html(html).show();
            } else {
                $('#customer-suggestions').hide();
            }
        },
        error: function() {
            $('#customer-suggestions').hide();
        }
    });
}

function selectCustomer(name, phone, address) {
    $('#customer-name').val(name);
    $('#customer-phone').val(phone);
    $('#customer-address').val(address);
    $('#customer-suggestions').hide();
    $('#barcode-search').focus();
    saveAllFormDataToLocalStorage();
    if (phone || address) {
        showAlert('success', 'زانیاری کڕیار پڕکرایەوە');
    }
}

// ==================== SEARCH FUNCTIONS ====================
function searchBarcodeSuggestions(term) {
    if (!term || term.length < 1) { $('#barcode-search-results').hide(); return; }
    $.ajax({
        url: '/products/search-by-barcode',
        type: 'POST',
        data: { search_term: term, _token: '<?php echo e(csrf_token()); ?>' },
        success: function(res) {
            if (res.success && res.products?.length) {
                let html = '';
                res.products.forEach(p => {
                    const stockClass = (p.counter || 0) <= 0 ? 'out-of-stock' : '';
                    html += `<div class="barcode-result-item" onclick='addProductToCart(${JSON.stringify(p).replace(/'/g, "&#39;")})'>
                        ${p.image_producte_path ? `<img src="${p.image_producte_path}" onerror="this.src='data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2240%22%20height%3D%2240%22%20viewBox%3D%220%200%2040%2040%22%3E%3Crect%20width%3D%2240%22%20height%3D%2240%22%20fill%3D%22%23cbd5e1%22%2F%3E%3Ctext%20x%3D%2220%22%20y%3D%2225%22%20text-anchor%3D%22middle%22%20fill%3D%22%234b5563%22%3E${(p.name?.charAt(0)||'?')}%3C%2Ftext%3E%3C%2Fsvg%3E'">` : `<div class="no-image-fallback"><i class="fas fa-image"></i></div>`}
                        <div class="barcode-result-info"><h4>${escapeHtml(p.name)}</h4><p>${p.barcode} | ${escapeHtml(p.company||'بێ کۆمپانیا')} | ${formatNumber(p.selling_price)} دینار</p></div>
                        <div class="barcode-result-badge ${stockClass}">${(p.counter||0)<=0?'لە کۆگا نیە':p.counter+' دانە'}</div>
                    </div>`;
                });
                $('#barcode-search-results').html(html).show();
            } else { $('#barcode-search-results').hide(); }
        }
    });
}

function searchNameSuggestions(term) {
    if (!term || term.length < 2) { $('#name-search-results').hide(); return; }
    $.ajax({
        url: '/products/search-by-nameee',
        type: 'POST',
        data: { search_term: term, _token: '<?php echo e(csrf_token()); ?>' },
        success: function(res) {
            if (res.success && res.products?.length) {
                let html = '';
                res.products.forEach(p => {
                    const stockClass = (p.counter || 0) <= 0 ? 'out-of-stock' : '';
                    html += `<div class="name-result-item" onclick='addProductToCart(${JSON.stringify(p).replace(/'/g, "&#39;")})'>
                        ${p.image_producte_path ? `<img src="${p.image_producte_path}" onerror="this.src='data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2240%22%20height%3D%2240%22%20viewBox%3D%220%200%2040%2040%22%3E%3Crect%20width%3D%2240%22%20height%3D%2240%22%20fill%3D%22%23cbd5e1%22%2F%3E%3Ctext%20x%3D%2220%22%20y%3D%2225%22%20text-anchor%3D%22middle%22%20fill%3D%22%234b5563%22%3E${(p.name?.charAt(0)||'?')}%3C%2Ftext%3E%3C%2Fsvg%3E'">` : `<div class="no-image-fallback"><i class="fas fa-image"></i></div>`}
                        <div class="name-result-info"><h4>${escapeHtml(p.name)}</h4><p>${p.barcode} | ${escapeHtml(p.company||'بێ کۆمپانیا')} | ${formatNumber(p.selling_price)} دینار</p></div>
                        <div class="barcode-result-badge ${stockClass}">${(p.counter||0)<=0?'لە کۆگا نیە':p.counter+' دانە'}</div>
                    </div>`;
                });
                $('#name-search-results').html(html).show();
            } else {
                $('#name-search-results').html('<div class="search-loading" style="padding:20px;text-align:center;">هیچ کاڵایەک نەدۆزرایەوە</div>').show();
                setTimeout(() => $('#name-search-results').fadeOut(), 1500);
            }
        }
    });
}

function searchByExactBarcode(barcode) {
    if (!barcode) return;
    const cleanBarcode = toEnglishNumbers(barcode).replace(/[^0-9]/g, '');
    if (!cleanBarcode) {
        showAlert('warning', 'تکایە بارکۆدێکی دروست بنووسە');
        return;
    }
    
    $.ajax({
        url: '/products/search-by-barcode',
        type: 'POST',
        data: { search_term: cleanBarcode, _token: '<?php echo e(csrf_token()); ?>' },
        success: function(res) {
            if (res.success && res.products) {
                if (res.products.length === 1) {
                    addProductToCart(res.products[0]);
                    $('#barcode-search').val('');
                } else if (res.products.length > 1) {
                    let html = '';
                    res.products.forEach(p => {
                        const stockClass = (p.counter || 0) <= 0 ? 'out-of-stock' : '';
                        html += `<div class="barcode-result-item" onclick='addProductToCart(${JSON.stringify(p).replace(/'/g, "&#39;")})'>
                            ${p.image_producte_path ? `<img src="${p.image_producte_path}" onerror="this.src='data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2240%22%20height%3D%2240%22%20viewBox%3D%220%200%2040%2040%22%3E%3Crect%20width%3D%2240%22%20height%3D%2240%22%20fill%3D%22%23cbd5e1%22%2F%3E%3Ctext%20x%3D%2220%22%20y%3D%2225%22%20text-anchor%3D%22middle%22%20fill%3D%22%234b5563%22%3E${(p.name?.charAt(0)||'?')}%3C%2Ftext%3E%3C%2Fsvg%3E'">` : `<div class="no-image-fallback"><i class="fas fa-image"></i></div>`}
                            <div class="barcode-result-info"><h4>${escapeHtml(p.name)}</h4><p>${p.barcode} | ${escapeHtml(p.company||'بێ کۆمپانیا')} | ${formatNumber(p.selling_price)} دینار</p></div>
                            <div class="barcode-result-badge ${stockClass}">${(p.counter||0)<=0?'لە کۆگا نیە':p.counter+' دانە'}</div>
                        </div>`;
                    });
                    $('#barcode-search-results').html(html).show();
                } else {
                    showAlert('error', 'کاڵا نەدۆزرایەوە');
                }
            } else {
                showAlert('error', 'کاڵا نەدۆزرایەوە');
            }
            $('#barcode-search').val('');
        },
        error: function() {
            showAlert('error', 'هەڵەیەک ڕوویدا لە گەڕان');
            $('#barcode-search').val('');
        }
    });
}

// ==================== SCANNER - FIXED STABLE VERSION ====================
async function checkCameraAvailability() {
    try {
        const devices = await navigator.mediaDevices.enumerateDevices();
        const cameras = devices.filter(device => device.kind === 'videoinput');
        return cameras.length > 0;
    } catch (error) {
        console.error('Camera check error:', error);
        return false;
    }
}

async function cleanupScanner() {
    if (html5QrCode) {
        try {
            if (html5QrCode.isScanning) {
                await html5QrCode.stop();
            }
        } catch (e) {
            console.warn('Error stopping scanner:', e);
        }
        html5QrCode = null;
    }
    scannerActive = false;
}

async function startScanner() {
    await cleanupScanner();
    
    const hasCamera = await checkCameraAvailability();
    if (!hasCamera) {
        showAlert('error', 'هیچ کامێرایەک نەدۆزرایەوە لەم ئامێرەدا');
        closeScanner();
        return false;
    }
    
    try {
        $('#scanner-loading').show();
        
        html5QrCode = new Html5Qrcode("qr-reader");
        
        const config = {
            fps: 15,
            qrbox: { width: 280, height: 280 },
            aspectRatio: 1.0,
            disableFlip: false
        };
        
        await html5QrCode.start(
            { facingMode: "environment" },
            config,
            (decodedText, decodedResult) => {
                if (!scannerActive) return;
                
                if (scannerActive && decodedText) {
                    scannerActive = false;
                    let cleanBarcode = toEnglishNumbers(decodedText.trim());
                    cleanBarcode = cleanBarcode.replace(/[^0-9]/g, '');
                    
                    closeScanner().then(() => {
                        $('#barcode-search').val(cleanBarcode);
                        $('#barcode-search').focus();
                        searchByExactBarcode(cleanBarcode);
                    }).catch(() => {
                        $('#barcode-search').val(cleanBarcode);
                        searchByExactBarcode(cleanBarcode);
                    });
                }
            },
            (errorMessage) => {
                // تێپەڕین - هەڵەکانی سکان پیشان مەدە
            }
        );
        
        scannerActive = true;
        $('#scanner-loading').hide();
        $('#qr-reader').show();
        
    } catch (err) {
        console.error('Failed to start scanner:', err);
        $('#scanner-loading').hide();
        $('#scanner-status').text('هەڵە لە کردنەوەی کامێرا');
        showAlert('error', 'نەتوانرا کامێرا دەستپێبکرێت. تکایە دەستپێکردنەوەی ڕێگەپێدان بۆ کامێرا پشکنین بکە.');
        closeScanner();
        return false;
    }
    return true;
}

async function openScanner() {
    if (scannerActive && html5QrCode && html5QrCode.isScanning) {
        await closeScanner();
    }
    
    $('#scannerModal').show();
    $('#qr-reader').hide();
    $('#scanner-loading').show();
    
    setTimeout(async () => {
        await startScanner();
    }, 100);
}

async function closeScanner() {
    await cleanupScanner();
    $('#scannerModal').hide();
    $('#qr-reader').hide();
    $('#scanner-loading').hide();
    $('#scanner-status').text('');
}

window.addEventListener('beforeunload', function() {
    if (html5QrCode && html5QrCode.isScanning) {
        html5QrCode.stop().catch(() => {});
    }
});

// ==================== CART MANAGEMENT ====================
function addProductToCart(product) {
    if (!product) return;
    
    if (product.counter <= 0) { 
        showAlert('warning', `${product.name} لە کۆگا بەردەست نیە`); 
        return; 
    }
    
    const price = parseFloat(product.selling_price) || parseFloat(product.price) || 0;
    if (price <= 0) { 
        showAlert('warning', 'نرخی کاڵا دیاری نەکراوە'); 
        return; 
    }

    const existing = cart.find(item => 
        item.barcode === product.barcode && 
        item.company === (product.company || 'بێ کۆمپانیا') &&
        item.name === product.name
    );
    
    if (existing) {
        const maxQuantity = product.counter || 999;
        if (existing.quantity < maxQuantity) {
            existing.quantity++;
            existing.total = existing.quantity * existing.price;
            showAlert('success', `${product.name} زیادکرا (${existing.quantity})`);
        } else {
            showAlert('warning', `${product.name} - تەنها ${maxQuantity} دانە ماوە لە کۆگا`);
        }
    } else {
        cart.push({
            id: product.id, 
            barcode: product.barcode, 
            name: product.name,
            company: product.company || 'بێ کۆمپانیا', 
            price: price, 
            quantity: 1,
            total: price, 
            counter: product.counter || 999, 
            purchase_price: product.purchase_price || 0,
            image_producte_path: product.image_producte_path || null
        });
        showAlert('success', `${product.name} (${product.company || 'بێ کۆمپانیا'}) زیادکرا`);
    }
    
    $('#barcode-search, #name-search').val('');
    $('#barcode-search-results, #name-search-results').hide();
    renderCart();
    saveAllFormDataToLocalStorage();
    $('#barcode-search').focus();
}

function updateQuantity(index, qty) {
    const max = cart[index].counter || 999;
    if (qty < 1) return false;
    if (qty > max) { showAlert('warning', `تەنها ${max} دانە ماوە`); return false; }
    cart[index].quantity = qty;
    cart[index].total = qty * cart[index].price;
    renderCart();
    saveAllFormDataToLocalStorage();
    return true;
}

function removeFromCart(index) {
    const productName = cart[index].name;
    const productCompany = cart[index].company;
    cart.splice(index, 1);
    renderCart();
    saveAllFormDataToLocalStorage();
    showAlert('info', `${productName} (${productCompany}) سڕدرایەوە`);
}

function clearCart() {
    if (cart.length && confirm('دڵنیایت کە دەتەوێت هەموو کاڵاکان سڕبکەیتەوە؟')) {
        cart = [];
        renderCart();
        $('#advance-payment, #discount').val(0);
        $('#credit-period').val(30);
        $('#credit-amount').text('0');
        clearCartFromLocalStorage();
        showAlert('success', 'فرۆشتن پاککرایەوە');
    }
}

function newInvoice() {
    if (cart.length && !confirm('پسوڵەی نوێ؟ فرۆشتنەکانی ئێستا لەدەست دەدەیت')) return;
    cart = [];
    renderCart();
    $('#advance-payment, #discount').val(0);
    $('#credit-period').val(30);
    $('#credit-amount').text('0');
    $('#customer-name, #customer-phone, #customer-address').val('');
    clearCartFromLocalStorage();
    refreshVoucherNumber();
    $('#barcode-search').focus();
    showAlert('success', 'پسوڵەی نوێ دروستکرا');
}

function calculateTotals() {
    let sub = cart.reduce((s,i) => s + i.total, 0);
    let disc = parseFloat($('#discount').val()) || 0;
    let final = sub - disc;
    $('#subtotal').val(formatNumber(sub));
    $('#final-total').val(formatNumber(final));
    $('#total-payment').val(formatNumber(final));
    calculateCredit();
    saveAllFormDataToLocalStorage();
    return final;
}

function calculateCredit() {
    let advance = parseFloat($('#advance-payment').val()) || 0;
    let total = parseFormattedNumber($('#final-total').val());
    let credit = total - advance;
    $('#credit-amount').text(formatNumber(credit >= 0 ? credit : 0));
    if (credit < 0) showAlert('warning', 'پارەی پێشەکی زۆرترە لە کۆی گشتی');
}

function formatNumber(n) { return Number(n).toLocaleString(); }
function parseFormattedNumber(s) { return parseFloat(s?.toString().replace(/,/g,'')) || 0; }

function renderCart() {
    let html = '';
    if (!cart.length) {
        html = '<tr><td colspan="7" style="text-align:center;padding:40px;">هیچ کاڵایەک زیاد نەکراوە</td></tr>';
    } else {
        cart.forEach((item, i) => {
            html += `<tr>
                <td>${i+1}</td>
                <td><div class="product-info" onclick="openImageModal('${item.image_producte_path||''}','${escapeHtml(item.name)}')">${item.image_producte_path ? `<img src="${item.image_producte_path}" class="product-image-thumb" onerror="this.src='data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2240%22%20height%3D%2240%22%20viewBox%3D%220%200%2040%2040%22%3E%3Crect%20width%3D%2240%22%20height%3D%2240%22%20fill%3D%22%23cbd5e1%22%2F%3E%3Ctext%20x%3D%2220%22%20y%3D%2225%22%20text-anchor%3D%22middle%22%20fill%3D%22%234b5563%22%3E${item.name?.charAt(0)||'?'}%3C%2Ftext%3E%3C%2Fsvg%3E'">` : `<div class="no-image-fallback"><i class="fas fa-image"></i></div>`}<span class="product-name">${escapeHtml(item.name)}</span></div></td>
                <td><span class="company-badge">${escapeHtml(item.company)}</span></td>
                <td><div class="quantity-controls"><button class="quantity-btn decrease" data-index="${i}"><i class="fas fa-minus"></i></button><input type="number" class="quantity-input" value="${item.quantity}" data-index="${i}" min="1" max="${item.counter||999}"><button class="quantity-btn increase" data-index="${i}"><i class="fas fa-plus"></i></button></div></td>
                <td>${formatNumber(item.price)}</td>
                <td><strong>${formatNumber(item.total)}</strong></td>
                <td><button class="delete-btn" data-index="${i}"><i class="fas fa-trash"></i> سڕینەوە</button></td>
            </tr>`;
        });
    }
    $('#sales-items').html(html);
    calculateTotals();
}

function calculateProfit() {
    if (!cart.length) { showAlert('info', 'هیچ کاڵایەک نیە'); return; }
    let profit = cart.reduce((s,i) => s + ((i.price - (i.purchase_price||0)) * i.quantity), 0);
    showAlert('success', `کۆی قازانج: ${formatNumber(profit)} دینار`, '💰 قازانج');
}

// ==================== IMAGE MODAL ====================
function openImageModal(src, name) {
    if (!src) return;
    $('#modalImage').attr('src', src);
    $('#modalCaption').text(name);
    $('#imageModal').show();
}
function closeImageModal() { $('#imageModal').hide(); }
function showPrevImage() {}
function showNextImage() {}

// ==================== ALERTS ====================
function showAlert(type, msg, title = '') {
    let icons = { success: 'fa-check-circle', error: 'fa-exclamation-circle', warning: 'fa-exclamation-triangle', info: 'fa-info-circle' };
    let id = 'alert-' + Date.now();
    let html = `<div id="${id}" class="custom-alert alert-${type}"><div><i class="fas ${icons[type]}"></i></div><div><strong>${title||type}</strong><div>${msg}</div></div><div class="alert-progress"></div></div>`;
    $('#alert-container').append(html);
    setTimeout(() => $(`#${id}`).fadeOut(300, function() { $(this).remove(); }), 4000);
}

function escapeHtml(str) { if (!str) return ''; return String(str).replace(/[&<>]/g, function(m) { if (m === '&') return '&amp;'; if (m === '<') return '&lt;'; if (m === '>') return '&gt;'; return m; }); }

// ==================== SALE COMPLETION ====================
function refreshVoucherNumber() {
    $.get('/sales/next-voucher-number', function(res) { if (res.success) $('#voucher-number').val(res.voucher_number); });
}

function printInvoice(data) {
    let now = new Date();
    $('#print-date').text(now.toLocaleDateString());
    $('#print-time').text(now.toLocaleTimeString());
    $('#print-voucher').text(data.voucher_number);
    $('#print-credit-period').text($('#credit-period').val());
    
    let rows = '', sub = 0;
    cart.forEach((item, i) => {
        let total = item.price * item.quantity;
        sub += total;
        rows += `<tr><td>${i+1}</td><td>${escapeHtml(item.name)}</td><td>${escapeHtml(item.company)}</td><td>${item.quantity}</td><td>${formatNumber(item.price)}</td><td>${formatNumber(total)}</td></tr>`;
    });
    let disc = parseFloat($('#discount').val()) || 0;
    let final = sub - disc;
    let advance = parseFloat($('#advance-payment').val()) || 0;
    $('#print-table-body').html(rows);
    $('#print-subtotal').text(formatNumber(sub));
    $('#print-discount').text(formatNumber(disc));
    $('#print-advance').text(formatNumber(advance));
    $('#print-credit').text(formatNumber(final - advance));
    
    $('#print-section').addClass('print-show');
    setTimeout(() => { window.print(); setTimeout(() => $('#print-section').removeClass('print-show'), 500); }, 100);
}

function completeSale(withPrint = false) {
    if (!cart.length) { showAlert('error', 'هیچ کاڵایەک زیاد نەکراوە'); return; }
    let customerName = $('#customer-name').val().trim();
    if (!customerName) { showAlert('error', 'تکایە ناوی کڕیار بنووسە'); $('#customer-name').focus(); return; }
    
    let subtotal = cart.reduce((s,i) => s + i.total, 0);
    let discount = parseFloat($('#discount').val()) || 0;
    let finalTotal = subtotal - discount;
    let advancePayment = parseFloat($('#advance-payment').val()) || 0;
    let creditPeriod = parseInt($('#credit-period').val()) || 30;
    
    if (creditPeriod < 1 || creditPeriod > 365) { showAlert('error', 'ڕۆژی قەرز لە نێوان 1-365 دابنێ'); return; }
    
    let formData = {
        customer_name: customerName,
        customer_phone: $('#customer-phone').val() || '',
        customer_address: $('#customer-address').val() || '',
        items: cart.map(i => ({ product_id: i.id, quantity: i.quantity, price: i.price, product_name: i.name, barcode: i.barcode, company: i.company })),
        subtotal: subtotal,
        discount: discount,
        total: finalTotal,
        advance_payment: advancePayment,
        credit_period: creditPeriod,
        credit_amount: finalTotal - advancePayment,
        _token: $('meta[name="csrf-token"]').attr('content')
    };
    
    $.ajax({
        url: '/credit-sales/store',
        type: 'POST',
        data: formData,
        beforeSend: function() { $('.btn-success, .btn-primary').prop('disabled', true); showAlert('info', 'تۆمارکردنی قەرز...'); },
        success: function(res) {
            if (res.success) {
                showAlert('success', res.message + ` (${creditPeriod} ڕۆژ)`);
                if (withPrint) printInvoice({ voucher_number: $('#voucher-number').val() });
                cart = [];
                renderCart();
                $('#advance-payment, #discount').val(0);
                $('#credit-period').val(30);
                $('#customer-name, #customer-phone, #customer-address').val('');
                clearCartFromLocalStorage();
                refreshVoucherNumber();
                $('#barcode-search').focus();
            } else showAlert('error', res.message);
        },
        error: function(xhr) {
            let msg = 'هەڵەیەک ڕوویدا';
            try { msg = JSON.parse(xhr.responseText).message || msg; } catch(e) {}
            showAlert('error', msg);
        },
        complete: function() { $('.btn-success, .btn-primary').prop('disabled', false); }
    });
}

// ==================== DOCUMENT READY ====================
$(document).ready(function() {
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
    refreshVoucherNumber();
    if (!loadAllFormDataFromLocalStorage()) renderCart();
    
    forceNumericInputForBarcode();
    
    $('#customer-name').on('input', function() {
        clearTimeout(customerSearchTimeout);
        const term = $(this).val().trim();
        if (term.length >= 1) {
            customerSearchTimeout = setTimeout(() => searchCustomerSuggestions(term), 300);
        } else {
            $('#customer-suggestions').hide();
        }
    });
    
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.customer-wrapper').length && !$(e.target).closest('#customer-name').length) {
            $('#customer-suggestions').hide();
        }
    });
    
    $('#customer-name').on('keydown', function(e) {
        if (e.key === 'Escape') {
            $('#customer-suggestions').hide();
        }
    });
    
    $('#barcode-search').on('input', function() { 
        clearTimeout(barcodeSearchTimeout); 
        let term = $(this).val().trim();
        if (term.length >= 1) {
            barcodeSearchTimeout = setTimeout(() => searchBarcodeSuggestions(term), 300);
        } else {
            $('#barcode-search-results').hide();
        }
    });
    
    $('#name-search').on('input', function() { 
        clearTimeout(nameSearchTimeout); 
        let term = $(this).val().trim();
        if (term.length >= 2) {
            nameSearchTimeout = setTimeout(() => searchNameSuggestions(term), 300);
        } else {
            $('#name-search-results').hide();
        }
    });
    
    $('#barcode-search').on('keypress', function(e) { 
        if (e.which === 13) { 
            e.preventDefault(); 
            let barcode = $(this).val().trim();
            if (barcode) {
                searchByExactBarcode(barcode);
                $(this).val('');
            }
        } 
    });
    
    $('#name-search').on('keypress', function(e) { 
        if (e.which === 13) { 
            e.preventDefault(); 
            let term = $(this).val().trim(); 
            if (term.length >= 2) searchNameSuggestions(term); 
        } 
    });
    
    $(document).on('click', '.decrease', function() { 
        let idx = $(this).data('index'); 
        let inp = $(`.quantity-input[data-index="${idx}"]`); 
        updateQuantity(idx, parseInt(inp.val()) - 1); 
    });
    
    $(document).on('click', '.increase', function() { 
        let idx = $(this).data('index'); 
        let inp = $(`.quantity-input[data-index="${idx}"]`); 
        updateQuantity(idx, parseInt(inp.val()) + 1); 
    });
    
    $(document).on('change', '.quantity-input', function() { 
        let idx = $(this).data('index'); 
        updateQuantity(idx, parseInt($(this).val())); 
    });
    
    $(document).on('click', '.delete-btn', function() { 
        removeFromCart($(this).data('index')); 
    });
    
    $('#discount, #advance-payment, #credit-period, #customer-name, #customer-phone, #customer-address').on('change keyup', function() { 
        calculateTotals(); 
        saveAllFormDataToLocalStorage(); 
    });
    
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.barcode-wrapper').length) $('#barcode-search-results').hide();
        if (!$(e.target).closest('#name-search').length && !$(e.target).closest('#name-search-results').length) $('#name-search-results').hide();
    });
    
    $('#barcode-search').focus();
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamnp64\www\mobileHardy\resources\views/items/items-sales-credit.blade.php ENDPATH**/ ?>