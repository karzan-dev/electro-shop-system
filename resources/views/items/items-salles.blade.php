{{--
    resources/views/sales/index.blade.php
    Complete working sales page with barcode and name search
    Fully responsive for all devices (mobile, tablet, desktop)
    
    PRODUCT MATCHING LOGIC:
    Products are considered the SAME only if: Name AND Company AND Barcode ALL match
    If any of these three is different → Added as separate item in cart
--}}

@extends('layouts.navigation')

@section('content')

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ config('app.name', 'Laravel') }} - فرۆشتن</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<!-- HTML5 QR Code Scanner Library -->
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
        --morning: #f59e0b;
        --afternoon: #3b82f6;
        --night: #1e293b;
        --text: #1e293b;
        --border-color: #e2e8f0;
        --bg-light: #f8fafc;
        --card-bg: #ffffff;
        --input-bg: #ffffff;
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
        --input-bg: #0f172a;
        background: #0f172a;
    }

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        background: #f1f5f9;
        font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
        color: var(--text);
    }

    .sales-container {
        padding: 12px;
        min-height: 100vh;
        max-width: 1600px;
        margin: 0 auto;
    }

    @media (min-width: 640px) {
        .sales-container { padding: 16px; }
    }
    @media (min-width: 1024px) {
        .sales-container { padding: 24px; }
    }

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

    @media (min-width: 768px) {
        .form-card {
            padding: 20px;
            margin-bottom: 20px;
        }
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 700;
        margin: 0 0 16px 0;
        text-align: center;
        color: var(--text);
        position: relative;
        padding-bottom: 10px;
    }

    @media (min-width: 640px) {
        .section-title { font-size: 1.2rem; margin-bottom: 18px; }
    }
    @media (min-width: 1024px) {
        .section-title { font-size: 1.3rem; margin-bottom: 22px; }
    }

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

    .barcode-wrapper {
        position: relative;
        width: 100%;
    }

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

    @media (min-width: 640px) {
        .barcode-input { padding: 14px 52px 14px 18px; font-size: 15px; }
    }

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

    @media (min-width: 640px) {
        .scan-btn { width: 40px; height: 40px; font-size: 18px; right: 10px; }
    }

    .scan-btn:hover {
        background: var(--secondary);
        transform: translateY(-50%) scale(1.05);
    }

    .barcode-search-results {
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
        background: var(--bg-light);
    }

    .barcode-result-item img, .name-result-item img {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 10px;
        border: 1px solid var(--border-color);
    }

    .barcode-result-info, .name-result-info {
        flex: 1;
    }

    .barcode-result-info h4, .name-result-info h4 {
        font-size: 13px;
        font-weight: 700;
        margin: 0 0 4px;
        color: var(--text);
    }

    @media (min-width: 640px) {
        .barcode-result-info h4, .name-result-info h4 { font-size: 14px; }
    }

    .barcode-result-info p, .name-result-info p {
        font-size: 11px;
        color: #64748b;
        margin: 0;
    }

    body.dark-mode .barcode-result-info p,
    body.dark-mode .name-result-info p {
        color: #94a3b8;
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

    .barcode-result-badge.out-of-stock {
        background: linear-gradient(135deg, #ef4444, #dc2626);
    }

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

    @media (min-width: 640px) {
        .name-input { padding: 14px 18px; font-size: 15px; }
    }

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

    .total-input, .final-total-input, .payment-input, .change-display {
        width: 100%;
        border: none;
        font-size: 14px;
        font-weight: 700;
        border-radius: 14px;
        padding: 12px 16px;
        text-align: center;
    }

    @media (min-width: 640px) {
        .total-input, .final-total-input, .payment-input, .change-display { 
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

    .change-display { 
        background: var(--input-bg) !important; 
        color: var(--text) !important; 
        border: 2px solid #8b5cf6 !important; 
        margin-top: 8px; 
        font-size: 18px; 
        font-weight: 800; 
    }

    #voucher-number {
        background: var(--input-bg) !important;
        color: var(--text) !important;
        border: 2px solid #f59e0b !important;
        font-weight: 800;
        font-size: 15px;
        text-align: center;
    }

    @media (min-width: 640px) {
        #voucher-number { font-size: 17px; }
    }

    .block {
        display: block;
        font-size: 11px;
        margin-bottom: 6px;
        color: var(--text);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    @media (min-width: 640px) {
        .block { font-size: 12px; margin-bottom: 8px; }
    }

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
    .btn-info    { background: linear-gradient(135deg, var(--info), #2563eb); box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3); }
    .btn-credit  { background: linear-gradient(135deg, #0891b2, #0e7490); box-shadow: 0 4px 12px rgba(8, 145, 178, 0.3); }
    .btn-return  { background: linear-gradient(135deg, #d97706, #b45309); box-shadow: 0 4px 12px rgba(217, 119, 6, 0.3); }

    .btn-primary:hover, .btn-success:hover, .btn-warning:hover,
    .btn-danger:hover, .btn-info:hover, .btn-credit:hover, .btn-return:hover {
        transform: translateY(-2px);
        filter: brightness(1.1);
    }

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

    @media (min-width: 640px) {
        .sales-table { min-width: 700px; font-size: 13px; }
    }
    @media (min-width: 768px) {
        .sales-table { min-width: 100%; font-size: 14px; }
    }

    .sales-table thead th {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        font-weight: 700;
        padding: 12px 6px;
        text-align: center;
        white-space: nowrap;
        font-size: 11px;
    }

    @media (min-width: 640px) {
        .sales-table thead th { padding: 14px 8px; font-size: 12px; }
    }
    @media (min-width: 1024px) {
        .sales-table thead th { padding: 16px 12px; font-size: 13px; }
    }

    .sales-table tbody td {
        padding: 10px 6px;
        border-bottom: 1px solid var(--border-color);
        text-align: center;
        vertical-align: middle;
    }

    @media (min-width: 640px) {
        .sales-table tbody td { padding: 12px 8px; }
    }
    @media (min-width: 1024px) {
        .sales-table tbody td { padding: 14px 12px; }
    }

    .sales-table tbody tr:hover {
        background: var(--bg-light);
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

    @media (min-width: 640px) {
        .product-image-thumb { width: 40px; height: 40px; }
    }

    .product-name {
        font-weight: 600;
        color: var(--text);
        font-size: 11px;
        word-break: break-word;
        max-width: 120px;
    }

    @media (min-width: 640px) {
        .product-name { font-size: 13px; max-width: 160px; }
    }

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

    @media (min-width: 640px) {
        .company-badge { font-size: 10px; padding: 3px 10px; }
    }

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

    @media (min-width: 640px) {
        .quantity-btn { width: 30px; height: 30px; font-size: 13px; }
    }

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

    @media (min-width: 640px) {
        .quantity-input { width: 65px; padding: 6px; font-size: 14px; }
    }

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

    @media (min-width: 640px) {
        .delete-btn { padding: 8px 12px; font-size: 12px; gap: 6px; }
    }

    .delete-btn:hover {
        transform: translateY(-1px);
        filter: brightness(1.1);
    }

    .grid-2 {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    @media (min-width: 992px) {
        .grid-2 {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
        }
    }

    .grid-3 {
        display: grid;
        grid-template-columns: 1fr;
        gap: 12px;
    }

    @media (min-width: 640px) {
        .grid-3 { grid-template-columns: repeat(3, 1fr); gap: 16px; }
    }

    .grid-4 {
        display: grid;
        grid-template-columns: 1fr;
        gap: 12px;
    }

    @media (min-width: 640px) {
        .grid-4 { grid-template-columns: repeat(2, 1fr); gap: 16px; }
    }
    @media (min-width: 1024px) {
        .grid-4 { grid-template-columns: repeat(4, 1fr); gap: 20px; }
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

    #qr-reader {
        width: 100%;
        max-width: 450px;
        border-radius: 20px;
        overflow: hidden;
    }

    #qr-reader video {
        width: 100% !important;
    }

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
        transition: all 0.2s;
    }

    .scanner-close:hover {
        background: rgba(255,255,255,0.3);
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

    @keyframes progress {
        0% { width: 100%; }
        100% { width: 0%; }
    }

    /* Print Styles */
    #print-section {
        display: none;
    }

    #print-section.print-show {
        display: block;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: white;
        z-index: 99999;
        overflow-y: auto;
        direction: rtl;
    }

    @media print {
        body * {
            visibility: hidden;
        }
        #print-section, #print-section * {
            visibility: visible;
        }
        #print-section {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            background: white;
        }
        .print-receipt {
            width: 100%;
            max-width: 80mm;
            margin: 0 auto;
            padding: 5px;
            font-family: 'Courier New', 'Monaco', monospace;
            direction: rtl;
            font-size: 12px;
            color: #000 !important;
        }
        .no-print {
            display: none;
        }
    }

    .print-receipt {
        width: 100%;
        max-width: 80mm;
        margin: 0 auto;
        padding: 15px 10px;
        font-family: 'Courier New', 'Monaco', 'Tahoma', monospace;
        direction: rtl;
        background: white;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        color: #000;
    }

    .print-header {
        text-align: center;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px dashed #333;
    }

    .print-market-name {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 5px;
        color: #1e40af;
    }

    .print-market-subtitle {
        font-size: 10px;
        color: #666;
        margin-bottom: 3px;
    }

    .print-address {
        font-size: 9px;
        color: #666;
        margin-bottom: 3px;
    }

    .print-phone {
        font-size: 9px;
        color: #666;
        margin-bottom: 8px;
    }

    .print-divider {
        border-top: 1px dashed #333;
        margin: 8px 0;
    }

    .print-datetime {
        display: flex;
        justify-content: space-between;
        font-size: 9px;
        margin: 5px 0;
    }

    .print-voucher {
        font-size: 10px;
        font-weight: bold;
        margin: 5px 0;
        text-align: center;
        background: #f3f4f6;
        padding: 4px;
        border-radius: 4px;
    }

    .print-cashier {
        font-size: 9px;
        text-align: center;
        margin: 5px 0;
        color: #555;
    }

    .print-table {
        width: 100%;
        border-collapse: collapse;
        margin: 10px 0;
        font-size: 10px;
    }

    .print-table th {
        background: #f3f4f6;
        padding: 6px 3px;
        text-align: center;
        font-weight: bold;
        border: 1px solid #ccc;
        font-size: 9px;
    }

    .print-table td {
        padding: 5px 3px;
        text-align: center;
        border: 1px solid #ccc;
    }

    .print-totals {
        margin: 10px 0;
        padding: 8px 0;
        border-top: 1px dashed #333;
        border-bottom: 1px dashed #333;
    }

    .print-total-row {
        display: flex;
        justify-content: space-between;
        font-size: 10px;
        padding: 3px 0;
    }

    .print-total-row.discount {
        color: #dc2626;
    }

    .print-total-row.grand {
        font-weight: bold;
        font-size: 12px;
        border-top: 1px solid #333;
        margin-top: 5px;
        padding-top: 5px;
    }

    .print-footer {
        text-align: center;
        margin-top: 15px;
        padding-top: 10px;
        border-top: 2px dashed #333;
    }

    .print-thanks {
        font-size: 11px;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .print-return-policy {
        font-size: 8px;
        color: #666;
        margin-top: 5px;
    }

    .print-website {
        font-size: 8px;
        color: #999;
        margin-top: 5px;
    }

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
        --secondary: #5d7ab0;
        --secondary: #4a6491;
        background: linear-gradient(135deg, var(--secondary), var(--primary-dark));
        border-radius: 24px;
        padding: 20px 16px;
        margin-bottom: 20px;
        text-align: center;
        color: white;
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
         background: linear-gradient(135deg,var(--primary), var(--primary-dark));
        width: 70px;
        height: 70px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
    }

    body.dark-mode .form-logo-custom i {
        font-size: 2.5rem;
        color: var(--accent);
    }
    .form-logo-custom i{
        font-size: 2.5rem;
        color:rgb(184, 171, 250);
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

    /* Dark mode input focus styles */
    body.dark-mode input:focus {
        box-shadow: 0 0 0 2px var(--primary);
    }

    /* Dark mode select styles */
    body.dark-mode select {
        background: var(--input-bg);
        color: var(--text);
        border-color: var(--border-color);
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

<!-- Alert Container -->
<div id="alert-container" class="alert-container"></div>

<!-- Print Receipt Section -->
<div id="print-section">
    <div class="print-receipt">
        <div class="print-header">
            <div class="print-market-name">🏪 بازاڕی کوردستان</div>
            <div class="print-market-subtitle">Kurdistan Market</div>
            <div class="print-address">سلیمانی - کانی کوردە</div>
            <div class="print-phone">📞 0770 123 4567</div>
            <div class="print-divider"></div>
            <div class="print-datetime">
                <span>📅 <span id="print-date"></span></span>
                <span>⏰ <span id="print-time"></span></span>
            </div>
            <div class="print-voucher">
                🧾 ژمارەی پسۆنە: <strong><span id="print-voucher"></span></strong>
            </div>
            <div class="print-cashier">
                فرۆشیار: {{ Auth::user()->name ?? 'کارمەند' }}
            </div>
        </div>

        <table class="print-table" width="100%" cellpadding="4" cellspacing="0">
            <thead>
                <tr><th>#</th><th>کاڵا</th><th>کۆمپانیا</th><th>ژ</th><th>نرخ</th><th>کۆ</th></tr>
            </thead>
            <tbody id="print-table-body"></tbody>
        </table>

        <div class="print-totals">
            <div class="print-total-row">
                <span>💰 کۆی گشتی:</span>
                <span><span id="print-subtotal"></span> دینار</span>
            </div>
            <div class="print-total-row discount">
                <span>🏷️ داشکاندن:</span>
                <span>- <span id="print-discount"></span> دینار</span>
            </div>
            <div class="print-total-row grand">
                <span>✨ کۆی کۆتایی:</span>
                <span><strong><span id="print-final-total"></span> دینار</strong></span>
            </div>
        </div>

        <div class="print-payment-details">
            <div class="print-total-row">
                <span>💵 پارەی دراو:</span>
                <span><span id="print-cash-paid"></span> دینار</span>
            </div>
            <div class="print-total-row">
                <span>💰 پارەی گەڕاوە:</span>
                <span><span id="print-change"></span> دینار</span>
            </div>
        </div>

        <div class="print-footer">
            <div class="print-thanks">🙏 سوپاس بۆ کڕینتان 🙏</div>
            <div class="print-return-policy">پسوڵەکە بپارێزن بۆ گەڕاندنەوەی کاڵا</div>
            <div class="print-divider"></div>
            <div class="print-website">www.kurdistanmarket.com</div>
        </div>
    </div>
</div>

<!-- Main Container -->
<div class="sales-container">
    <div class="form-header-custom text-white">
        <div class="form-logo-custom">
            <i class="fas fa-bag-shopping fa-2x"></i>
        </div>
        <h1 style="font-size: 1.4rem; margin-bottom: 8px;">فرۆشتنی کاڵا</h1>
        <div style="display: flex; gap: 12px; justify-content: center; margin-top: 16px; flex-wrap: wrap;">
            <a href="{{ route('sales-credit.index') }}" class="btn-credit" style="width: auto; padding: 8px 16px;">
                <i class="fas fa-hand-holding-usd"></i> فرۆشتن بە قەرز
            </a>
            <a href="{{ route('delete-invoice') }}" class="btn-return" style="width: auto; padding: 8px 16px;">
                <i class="fas fa-undo-alt"></i> گەڕاندنەوەی کاڵا
            </a>
        </div>
    </div>

    <div class="grid-2">
        <!-- Left Column -->
        <div>
            <div class="form-card">
                <p class="section-title">گەڕان بە بارکۆد یان ناوی کاڵا</p>
                <div class="grid-3">
                    <div>
                        <label class="block">بارکۆد <i class="fas fa-barcode"></i></label>
                        <div class="barcode-wrapper">
                            <input type="text" id="barcode-search" class="barcode-input" placeholder="بارکۆد بنووسە یان سکان بکە..." autocomplete="off">
                            <button type="button" class="scan-btn" onclick="openScanner()">
                                <i class="fas fa-camera"></i>
                            </button>
                            <div id="barcode-search-results" class="barcode-search-results" style="display: none;"></div>
                        </div>
                    </div>
                    <div>
                        <label class="block">ناوی کاڵا <i class="fas fa-box"></i></label>
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

            <div class="form-card">
                <p class="section-title">زانیارییەکانی پسوڵە</p>
                <div class="grid-4">
                    <div>
                        <label class="block">ژمارەی پسوڵە</label>
                        <input type="text" id="voucher-number" class="total-input" value="{{ $nextVoucherNumber ?? 'INV-0001' }}" readonly>
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

            <div class="form-card">
                <p class="section-title">کاڵاکانی فرۆشتن</p>
                <div class="table-container">
                    <table class="sales-table">
                        <thead>
                            <tr><th>ژ</th><th>ناوی کاڵا</th><th>کۆمپانیا</th><th>ژمارە</th><th>نرخ</th><th>کۆ</th><th>سڕینەوە</th></tr>
                        </thead>
                        <tbody id="sales-items">
                            <tr id="empty-message">
                                <td colspan="7" style="text-align: center; padding: 30px;">هیچ کاڵایەک زیاد نەکراوە</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div>
            <div class="form-card">
                <p class="section-title">تەواوکردنی پارە</p>
                <div style="display: flex; flex-direction: column; gap: 15px;">
                    <div>
                        <label class="block">کۆی گشتی</label>
                        <input type="text" id="total-payment" class="final-total-input" value="0" readonly>
                    </div>
                    <div>
                        <label class="block">بڕی پارەی دراو</label>
                        <input type="number" id="cash-paid" class="payment-input" value="0" min="0" step="1000" placeholder="پارەکە داخڵ بکە">
                    </div>
                    <div>
                        <label class="block">بڕی پارەی گەڕاوە</label>
                        <div id="change-display" class="change-display">
                            <span id="change-amount">0</span> دینار
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-card">
                <p class="section-title">کردارەکان</p>
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <button type="button" class="btn-success" onclick="completeSale(false)">
                        <i class="fas fa-save"></i> تۆمارکردن <span style="font-size: 10px;">F1</span>
                    </button>
                    <button type="button" class="btn-primary" onclick="completeSale(true)">
                        <i class="fas fa-print"></i> پرینتکردن <span style="font-size: 10px;">F2</span>
                    </button>
                    <button type="button" class="btn-danger" onclick="clearCart()">
                        <i class="fas fa-trash"></i> پاككردنەوە
                    </button>
                    <button type="button" class="btn-warning" onclick="newInvoice()">
                        <i class="fas fa-file-invoice"></i> پسوڵەی نوێ
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="shortcut-hint">
    <kbd>F2</kbd> پرینت | <kbd>F1</kbd> تۆمار | <kbd>Esc</kbd> پاككردنەوە
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// ==================== GLOBALS ====================
let cart = [];
let barcodeSearchTimeout = null;
let nameSearchTimeout = null;
let html5QrCode = null;
let currentImageIndex = 0;
let productImages = [];

// ==================== LOCALSTORAGE ====================
function saveCartToLocalStorage() {
    try {
        localStorage.setItem('sales_cart', JSON.stringify({
            items: cart,
            timestamp: new Date().getTime(),
            voucherNumber: $('#voucher-number').val(),
            discount: $('#discount').val()
        }));
    } catch(e) {}
}

/**
 * گۆڕینی هەر ژمارەیەکی نا ئینگلیزی (کوردی، فارسی، عەرەبی) بۆ ئینگلیزی
 * @param {string} str - بارکۆدەکە یان هەر نوسینێک
 * @returns {string} - نوسینی پاککراوە بە ژمارەی ئینگلیزی
 */
function normalizeToEnglishNumbers(str) {
    if (!str) return str;
    
    const kurdishNumbers = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
    const persianNumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    const englishNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
    
    let result = str.toString();
    
    for (let i = 0; i < kurdishNumbers.length; i++) {
        const regex = new RegExp(kurdishNumbers[i], 'g');
        result = result.replace(regex, englishNumbers[i]);
    }
    
    for (let i = 0; i < persianNumbers.length; i++) {
        const regex = new RegExp(persianNumbers[i], 'g');
        result = result.replace(regex, englishNumbers[i]);
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

function loadCartFromLocalStorage() {
    try {
        const saved = localStorage.getItem('sales_cart');
        if(saved) {
            const data = JSON.parse(saved);
            if(data.items && data.items.length > 0 && (new Date().getTime() - data.timestamp) < 86400000) {
                cart = data.items;
                if(data.voucherNumber) $('#voucher-number').val(data.voucherNumber);
                if(data.discount) $('#discount').val(data.discount);
                renderCart();
                return true;
            }
        }
    } catch(e) {}
    return false;
}

// ==================== SEARCH FUNCTIONS ====================
function searchBarcodeSuggestions(term) {
    if(!term || term.length < 1) { $('#barcode-search-results').hide(); return; }
    $.ajax({
        url: '/products/search-by-barcode',
        type: 'POST',
        data: { search_term: term, _token: '{{ csrf_token() }}' },
        success: function(res) {
            if(res.success && res.products?.length) {
                let html = '';
                res.products.forEach(p => {
                    const stockClass = (p.counter || 0) <= 0 ? 'out-of-stock' : '';
                    html += `<div class="barcode-result-item" onclick='addProductToCart(${JSON.stringify(p)})'>
                        ${p.image_producte_path ? `<img src="${p.image_producte_path}" onerror="this.src='data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2240%22%20height%3D%2240%22%20viewBox%3D%220%200%2040%2040%22%3E%3Crect%20width%3D%2240%22%20height%3D%2240%22%20fill%3D%22%23cbd5e1%22%2F%3E%3Ctext%20x%3D%2220%22%20y%3D%2225%22%20text-anchor%3D%22middle%22%20fill%3D%22%234b5563%22%3E${p.name?.charAt(0)||'?'}%3C%2Ftext%3E%3C%2Fsvg%3E'">` : `<div class="no-image-fallback"><i class="fas fa-image"></i></div>`}
                        <div class="barcode-result-info"><h4>${escapeHtml(p.name)}</h4><p>${p.barcode} | ${escapeHtml(p.company||'بێ کۆمپانیا')} | ${formatNumber(p.selling_price)} دینار</p></div>
                        <div class="barcode-result-badge ${stockClass}">${(p.counter||0)<=0?'لە کۆگا نیە':p.counter+' دانە'}</div>
                    </div>`;
                });
                $('#barcode-search-results').html(html).show();
            } else {
                $('#barcode-search-results').hide();
            }
        }
    });
}

function searchNameSuggestions(term) {
    if(!term || term.length < 2) { $('#name-search-results').hide(); return; }
    $.ajax({
        url: '/products/search-by-nameee',
        type: 'POST',
        data: { search_term: term, _token: '{{ csrf_token() }}' },
        success: function(res) {
            if(res.success && res.products?.length) {
                let html = '';
                res.products.forEach(p => {
                    const stockClass = (p.counter || 0) <= 0 ? 'out-of-stock' : '';
                    html += `<div class="name-result-item" onclick='addProductToCart(${JSON.stringify(p)})'>
                        ${p.image_producte_path ? `<img src="${p.image_producte_path}" onerror="this.src='data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2240%22%20height%3D%2240%22%20viewBox%3D%220%200%2040%2040%22%3E%3Crect%20width%3D%2240%22%20height%3D%2240%22%20fill%3D%22%23cbd5e1%22%2F%3E%3Ctext%20x%3D%2220%22%20y%3D%2225%22%20text-anchor%3D%22middle%22%20fill%3D%22%234b5563%22%3E${p.name?.charAt(0)||'?'}%3C%2Ftext%3E%3C%2Fsvg%3E'">` : `<div class="no-image-fallback"><i class="fas fa-image"></i></div>`}
                        <div class="name-result-info"><h4>${escapeHtml(p.name)}</h4><p>${p.barcode} | ${escapeHtml(p.company||'بێ کۆمپانیا')} | ${formatNumber(p.selling_price)} دینار</p></div>
                        <div class="barcode-result-badge ${stockClass}">${(p.counter||0)<=0?'لە کۆگا نیە':p.counter+' دانە'}</div>
                    </div>`;
                });
                $('#name-search-results').html(html).show();
            } else {
                $('#name-search-results').html('<div class="search-loading" style="padding:20px;text-align:center;color:var(--text);">هیچ کاڵایەک نەدۆزرایەوە</div>').show();
                setTimeout(() => $('#name-search-results').fadeOut(), 1500);
            }
        }
    });
}

// ==================== Search by barcode and handle based on result count ====================
function searchAndHandleBarcode(barcode) {
    if(!barcode) return;
    const normalizedBarcode = normalizeToEnglishNumbers(barcode);
    $.ajax({
        url: '/products/search-by-barcode',
        type: 'POST',
        data: { search_term: barcode, _token: '{{ csrf_token() }}' },
        success: function(res) {
            if(res.success && res.products) {
                const products = res.products;
                
                if(products.length === 0) {
                    showAlert('error', 'کاڵا نەدۆزرایەوە');
                    $('#barcode-search').val('').focus();
                }
                else if(products.length === 1) {
                    addProductToCart(products[0]);
                    $('#barcode-search').val('').focus();
                }
                else {
                    let html = '';
                    products.forEach(p => {
                        const stockClass = (p.counter || 0) <= 0 ? 'out-of-stock' : '';
                        html += `<div class="barcode-result-item" onclick='addProductToCart(${JSON.stringify(p)})'>
                            ${p.image_producte_path ? `<img src="${p.image_producte_path}" onerror="this.src='data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2240%22%20height%3D%2240%22%20viewBox%3D%220%200%2040%2040%22%3E%3Crect%20width%3D%2240%22%20height%3D%2240%22%20fill%3D%22%23cbd5e1%22%2F%3E%3Ctext%20x%3D%2220%22%20y%3D%2225%22%20text-anchor%3D%22middle%22%20fill%3D%22%234b5563%22%3E${p.name?.charAt(0)||'?'}%3C%2Ftext%3E%3C%2Fsvg%3E'">` : `<div class="no-image-fallback"><i class="fas fa-image"></i></div>`}
                            <div class="barcode-result-info"><h4>${escapeHtml(p.name)}</h4><p>${p.barcode} | ${escapeHtml(p.company||'بێ کۆمپانیا')} | ${formatNumber(p.selling_price)} دینار</p></div>
                            <div class="barcode-result-badge ${stockClass}">${(p.counter||0)<=0?'لە کۆگا نیە':p.counter+' دانە'}</div>
                        </div>`;
                    });
                    $('#barcode-search-results').html(html).show();
                    showAlert('info', 'چەند کاڵایەک دۆزرایەوە، تکایە کاڵای پێویست هەڵبژێرە');
                }
            } else {
                showAlert('error', 'کاڵا نەدۆزرایەوە');
                $('#barcode-search').val('').focus();
            }
        },
        error: function() {
            showAlert('error', 'هەڵە لە گەڕان بە بارکۆد');
        }
    });
}

// ==================== CART MANAGEMENT ====================
function addProductToCart(product) {
    if(!product) return;
    if(product.counter <= 0) {
        showAlert('warning', `${product.name} لە کۆگا بەردەست نیە`);
        return;
    }
    const price = parseFloat(product.selling_price) || parseFloat(product.price) || 0;
    if(price <= 0) { showAlert('warning', 'نرخی کاڵا دیاری نەکراوە'); return; }
    
    const existing = cart.find(i => 
        i.name === product.name && 
        i.company === (product.company || 'بێ کۆمپانیا') &&
        i.barcode === product.barcode
    );
    
    if(existing) {
        if(existing.quantity < (product.counter || 999)) {
            existing.quantity++;
            existing.total = existing.quantity * existing.price;
            showAlert('success', `${product.name} زیادکرا (${existing.quantity})`);
        } else {
            showAlert('warning', `تەنها ${product.counter} دانە ماوە`);
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
            image_producte_path: product.image_producte_path || null,
            product_id: product.id
        });
        showAlert('success', `${product.name} زیادکرا`);
    }
    $('#barcode-search, #name-search').val('');
    $('#barcode-search-results, #name-search-results').hide();
    renderCart();
    saveCartToLocalStorage();
    $('#barcode-search').focus();
}

function updateQuantity(index, qty) {
    const max = cart[index].counter || 999;
    if(qty < 1) return false;
    if(qty > max) { showAlert('warning', `تەنها ${max} دانە ماوە`); return false; }
    cart[index].quantity = qty;
    cart[index].total = qty * cart[index].price;
    renderCart();
    saveCartToLocalStorage();
    return true;
}

function removeFromCart(index) {
    cart.splice(index, 1);
    renderCart();
    saveCartToLocalStorage();
    showAlert('info', 'کاڵا سڕدرایەوە');
}

function clearCart() {
    if(cart.length && confirm('دڵنیایت؟')) {
        cart = [];
        renderCart();
        $('#cash-paid, #discount').val(0);
        clearCartLocal();
        showAlert('success', 'فرۆشتن پاككرایەوە');
    }
}

function clearCartLocal() { 
    try { localStorage.removeItem('sales_cart'); } catch(e) {} 
}

function newInvoice() {
    if(cart.length && !confirm('پسوڵەی نوێ؟ فرۆشتنەکانی ئێستا لەدەست دەدەیت')) return;
    cart = [];
    renderCart();
    $('#cash-paid, #discount').val(0);
    clearCartLocal();
    refreshVoucherNumber();
    $('#barcode-search').focus();
}

function calculateTotals() {
    let sub = cart.reduce((s,i)=>s+i.total,0);
    let disc = parseFloat($('#discount').val()) || 0;
    let final = sub - disc;
    $('#subtotal').val(formatNumber(sub));
    $('#final-total').val(formatNumber(final));
    $('#total-payment').val(formatNumber(final));
    calculateChange();
    saveCartToLocalStorage();
    return final;
}

function calculateChange() {
    let cash = parseFloat($('#cash-paid').val()) || 0;
    let total = parseFormattedNumber($('#final-total').val());
    let change = cash - total;
    $('#change-amount').text(formatNumber(change >=0 ? change : 0));
}

function formatNumber(n) { 
    return Number(n).toLocaleString(); 
}

function parseFormattedNumber(s) { 
    return parseFloat(s?.toString().replace(/,/g,'')) || 0; 
}

function renderCart() {
    let html = '';
    if(!cart.length) {
        html = '<tr><td colspan="7" style="text-align:center;padding:30px;">هیچ کاڵایەک زیاد نەکراوە</td></tr>';
    } else {
        cart.forEach((item,i) => {
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
    if(!cart.length) { showAlert('info','هیچ کاڵایەک نیە'); return; }
    let profit = cart.reduce((s,i)=> s + ((i.price - (i.purchase_price||0)) * i.quantity),0);
    showAlert('success', `کۆی قازانج: ${formatNumber(profit)} دینار`, '💰 قازانج');
}

// ==================== SCANNER FUNCTIONS ====================
function openScanner() {
    $('#scannerModal').show();
    if(html5QrCode && html5QrCode.isScanning) {
        html5QrCode.stop().then(() => {
            startScanner();
        }).catch(() => {
            startScanner();
        });
    } else {
        startScanner();
    }
}

function startScanner() {
    html5QrCode = new Html5Qrcode("qr-reader");
    html5QrCode.start(
        { facingMode: "environment" }, 
        { fps: 10, qrbox: { width: 250, height: 200 } },
        (decodedText) => {
            closeScanner();
            const normalizedBarcode = normalizeToEnglishNumbers(decodedText);
            $('#barcode-search').val(normalizedBarcode);
            searchAndHandleBarcode(normalizedBarcode);
        },
        (errorMessage) => {
            console.log("Scan error: ", errorMessage);
        }
    ).catch((err) => {
        showAlert('error', 'نەتوانرا کامێرا دەستپێبکرێت: ' + err);
        closeScanner();
    });
}

function closeScanner() {
    if (html5QrCode && typeof html5QrCode.stop === 'function') {
        html5QrCode.stop()
            .then(() => {
                console.log("Scanner stopped");
            })
            .catch((err) => {
                console.log("Error stopping scanner: ", err);
            });
    }
    $('#scannerModal').hide();
}

// ==================== SALE COMPLETION ====================
function completeSale(withPrint = false) {
    if(!cart.length) { showAlert('error','هیچ کاڵایەک زیاد نەکراوە'); return; }
    let cashPaid = parseFloat($('#cash-paid').val()) || 0;
    let subtotal = cart.reduce((s,i)=>s+i.total,0);
    let discount = parseFloat($('#discount').val()) || 0;
    let finalTotal = subtotal - discount;

    
    let formData = new FormData();
    formData.append('items', JSON.stringify(cart.map(i=>({
        id: i.product_id || i.id, 
        quantity: i.quantity, 
        price: i.price, 
        company: i.company,
        name: i.name,
        barcode: i.barcode
    }))));
    formData.append('subtotal', subtotal);
    formData.append('discount', discount);
    formData.append('total', finalTotal);
    formData.append('delivery_fee', 0);
    formData.append('grand_total', finalTotal);
    formData.append('cash_paid', cashPaid);
    formData.append('change', cashPaid - finalTotal);
    formData.append('payment_method', 'cash');
    formData.append('_token', '{{ csrf_token() }}');
    
    $.ajax({
        url: '/sales/store',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(res) {
            if(res.success) {
                showAlert('success', res.message);
                if(withPrint) printInvoice({ 
                    voucher_number: $('#voucher-number').val(), 
                    items: cart,
                    discount: discount,
                    cash_paid: cashPaid,
                    change: cashPaid - finalTotal
                });
                resetAfterSale();
            } else {
                showAlert('error', res.message || 'هەڵەیەک ڕوویدا');
            }
        },
        error: function(xhr) {
            let msg = 'هەڵەیەک ڕوویدا';
            if(xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
            showAlert('error', msg);
        }
    });
}

function resetAfterSale() {
    cart = [];
    renderCart();
    $('#cash-paid, #discount').val(0);
    clearCartLocal();
    refreshVoucherNumber();
    $('#barcode-search').focus();
}

function refreshVoucherNumber() {
    $.get('/sales/next-voucher-number', function(res) {
        if(res.success) $('#voucher-number').val(res.voucher_number);
    }).fail(function() {
        console.log('Could not refresh voucher number');
    });
}

function printInvoice(data) {
    let now = new Date();
    $('#print-date').text(now.toLocaleDateString('ku'));
    $('#print-time').text(now.toLocaleTimeString('ku'));
    $('#print-voucher').text(data.voucher_number);
    let rows = '', sub=0;
    data.items.forEach((item,i) => {
        let total = item.price * item.quantity;
        sub += total;
        rows += `<tr>
            <td>${i+1}</td>
            <td>${escapeHtml(item.name)}</td>
            <td>${escapeHtml(item.company)}</td>
            <td>${item.quantity}</td>
            <td>${formatNumber(item.price)}</td>
            <td>${formatNumber(total)}</td>
        </tr>`;
    });
    let disc = data.discount || 0;
    let final = sub - disc;
    let cash = data.cash_paid || 0;
    let change = data.change || (cash - final);
    $('#print-table-body').html(rows);
    $('#print-subtotal').text(formatNumber(sub));
    $('#print-discount').text(formatNumber(disc));
    $('#print-final-total').text(formatNumber(final));
    $('#print-cash-paid').text(formatNumber(cash));
    $('#print-change').text(formatNumber(change >=0 ? change : 0));
    $('#print-section').addClass('print-show');
    setTimeout(()=>{ 
        window.print(); 
        setTimeout(()=>$('#print-section').removeClass('print-show'),500); 
    },100);
}

// ==================== IMAGE MODAL ====================
function openImageModal(src, name) {
    if(!src) return;
    $('#modalImage').attr('src',src);
    $('#modalCaption').text(name);
    $('#imageModal').show();
}
function closeImageModal() { $('#imageModal').hide(); }
function showPrevImage() {}
function showNextImage() {}

// ==================== ALERTS ====================
function showAlert(type, msg, title='') {
    let icons = { success:'fa-check-circle', error:'fa-exclamation-circle', warning:'fa-exclamation-triangle', info:'fa-info-circle' };
    let id = 'alert-'+Date.now();
    let html = `<div id="${id}" class="custom-alert alert-${type}"><div><i class="fas ${icons[type]}"></i></div><div><strong>${title||type}</strong><div>${msg}</div></div><div class="alert-progress"></div></div>`;
    $('#alert-container').append(html);
    setTimeout(()=>$(`#${id}`).fadeOut(300,function(){$(this).remove();}),4000);
}

function escapeHtml(str) { 
    if(!str) return ''; 
    return str.replace(/[&<>]/g, function(m){
        if(m==='&') return '&amp;'; 
        if(m==='<') return '&lt;'; 
        if(m==='>') return '&gt;'; 
        return m;
    }); 
}

// ==================== DOCUMENT READY ====================
$(document).ready(function(){
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
    
    // Enable barcode normalization
    enableBarcodeNormalizationForField('#barcode-search');
    
    refreshVoucherNumber();
    loadCartFromLocalStorage();
    
    $('#barcode-search').on('input',function(){ 
        clearTimeout(barcodeSearchTimeout); 
        barcodeSearchTimeout=setTimeout(()=>searchBarcodeSuggestions($(this).val().trim()),300); 
    });
    
    $('#name-search').on('input',function(){ 
        clearTimeout(nameSearchTimeout); 
        nameSearchTimeout=setTimeout(()=>searchNameSuggestions($(this).val().trim()),300); 
    });
    
    $('#barcode-search').on('keypress',function(e){ 
        if(e.which===13){ 
            e.preventDefault(); 
            searchAndHandleBarcode($(this).val().trim()); 
        } 
    });
    
    $(document).on('click','.decrease',function(){ 
        let idx=$(this).data('index'); 
        let inp=$(`.quantity-input[data-index="${idx}"]`); 
        updateQuantity(idx, parseInt(inp.val())-1); 
    });
    
    $(document).on('click','.increase',function(){ 
        let idx=$(this).data('index'); 
        let inp=$(`.quantity-input[data-index="${idx}"]`); 
        updateQuantity(idx, parseInt(inp.val())+1); 
    });
    
    $(document).on('change','.quantity-input',function(){ 
        let idx=$(this).data('index'); 
        updateQuantity(idx, parseInt($(this).val())); 
    });
    
    $(document).on('click','.delete-btn',function(){ 
        removeFromCart($(this).data('index')); 
    });
    
    $('#discount, #cash-paid').on('change keyup', function(){ 
        calculateTotals(); 
    });
    
    $(document).on('keydown',function(e){ 
        if(e.key==='F1'){ 
            e.preventDefault(); 
            if(cart.length) completeSale(false); 
            else showAlert('warning','هیچ کاڵایەک نیە'); 
        } 
        if(e.key==='F2'){ 
            e.preventDefault(); 
            if(cart.length) completeSale(true); 
            else showAlert('warning','هیچ کاڵایەک نیە'); 
        } 
        if(e.key==='Escape') clearCart(); 
    });
    
    $('#barcode-search').focus();
});
</script>
@endsection