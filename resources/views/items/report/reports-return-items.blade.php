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
        --text-secondary: #6b7280;
        --border-color: #e2e8f0;
        --bg-light: #f8fafc;
        --transition-base: all 0.3s ease;
        --card-bg: #ffffff;
        --input-bg: #ffffff;
        --table-hover: #fef9e3;
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
        --table-hover: #334155;
        background: #0f172a;
    }

    body {
        background: #f1f5f9;
        font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
        transition: background-color 0.3s ease, color 0.3s ease;
        color: var(--text);
        font-size: 14px;
        overflow-x: hidden;
    }

    body.dark-mode {
        background: #0f172a;
        color: #e2e8f0;
    }

    .container {
        max-width: 100%;
        padding-left: 12px;
        padding-right: 12px;
    }

    /* ============================================
       CARD STYLES
       ============================================ */
    .form-card {
        background: var(--card-bg);
        border-radius: 1rem;
        padding: 1.25rem;
        margin-bottom: 1rem;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
        border: 1px solid var(--border-color);
    }

    body.dark-mode .form-card {
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.3);
        background: var(--card-bg);
    }

    .form-header {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border-radius: 16px;
        padding: 20px 16px;
        margin-bottom: 16px;
        color: white;
        box-shadow: 0 10px 25px -5px rgba(74, 100, 145, 0.3);
        text-align: center;
    }

    .form-logo {
        background-color: white;
        width: 60px;
        height: 60px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }

    body.dark-mode .form-logo {
        background-color: #334155;
    }

    .form-logo i {
        font-size: 1.8rem;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    body.dark-mode .form-logo i {
        background: linear-gradient(135deg, #D8B4FE, #6c8db8);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* ============================================
       SECTION TITLE
       ============================================ */
    .section-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 0.8rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--secondary);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    body.dark-mode .section-title {
        color: #e2e8f0;
        border-bottom-color: var(--secondary);
    }

    .section-title .dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--primary);
        display: inline-block;
        flex-shrink: 0;
    }

    /* ============================================
       FORM STYLES
       ============================================ */
    .form-label {
        font-weight: 600;
        color: var(--text);
        margin-bottom: 0.4rem;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .form-label i {
        color: var(--primary);
    }

    .required-star {
        color: var(--danger);
        margin-right: 2px;
    }

    .form-control, .form-select {
        width: 100%;
        padding: 0.6rem 0.75rem;
        border: 2px solid var(--border-color);
        border-radius: 0.5rem;
        font-size: 0.9rem;
        transition: var(--transition-base);
        outline: none;
        background: var(--input-bg);
        color: var(--text);
    }

    body.dark-mode .form-control,
    body.dark-mode .form-select {
        background-color: #334155;
        border-color: #334155;
        color: #e2e8f0;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(74, 100, 145, 0.2);
    }

    body.dark-mode .form-control:focus,
    body.dark-mode .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(108, 141, 184, 0.2);
    }

    .form-select {
        cursor: pointer;
    }

    /* ============================================
       BUTTONS
       ============================================ */
    .btn-primary-custom {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        border: none;
        padding: 0.6rem 1.2rem;
        border-radius: 40px;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition-base);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-family: inherit;
        font-size: 0.9rem;
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(74, 100, 145, 0.4);
        color: white;
    }

    .btn-outline-custom {
        background: white;
        border: 2px solid var(--primary);
        color: var(--primary);
        padding: 0.6rem 1.2rem;
        border-radius: 40px;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition-base);
        font-family: inherit;
        font-size: 0.9rem;
    }

    body.dark-mode .btn-outline-custom {
        background: transparent;
        border-color: var(--primary);
        color: var(--primary);
    }

    .btn-outline-custom:hover {
        background: var(--primary);
        color: white;
    }

    /* ============================================
       TABLE STYLES
       ============================================ */
    .table-container {
        overflow-x: auto;
        border-radius: 0.75rem;
        border: 1px solid var(--border-color);
        max-height: 500px;
        overflow-y: auto;
        background: var(--card-bg);
        -webkit-overflow-scrolling: touch;
    }

    .table-container::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    .table-container::-webkit-scrollbar-track {
        background: var(--bg-light);
        border-radius: 10px;
    }

    .table-container::-webkit-scrollbar-thumb {
        background: var(--primary);
        border-radius: 10px;
    }

    .returns-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.8rem;
        white-space: nowrap;
        color: var(--text);
        min-width: 800px;
    }

    .returns-table thead {
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .returns-table th {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        font-weight: 600;
        padding: 0.75rem 0.5rem;
        text-align: center;
        border-bottom: 2px solid var(--primary-dark);
        font-size: 0.75rem;
    }

    .returns-table td {
        padding: 0.625rem 0.5rem;
        text-align: center;
        border-bottom: 1px solid var(--border-color);
        vertical-align: middle;
        font-size: 0.8rem;
    }

    .returns-table tbody tr {
        transition: background-color 0.2s ease;
    }

    .returns-table tbody tr:nth-child(even) {
        background-color: var(--bg-light);
    }

    .returns-table tbody tr:hover {
        background-color: var(--table-hover) !important;
    }

    .empty-row td {
        color: var(--text-secondary);
        padding: 30px;
        text-align: center;
    }

    /* ============================================
       TABLE → CARDS - MOBILE (باکگراوندی یەکسان)
       ============================================ */
    @media (max-width: 767px) {
        .table-container {
            overflow-x: visible !important;
            border: none !important;
            border-radius: 0;
            background: transparent !important;
            max-height: none;
        }

        .returns-table {
            display: block;
            white-space: normal;
            min-width: 0 !important;
        }

        .returns-table thead {
            display: none;
        }

        .returns-table tbody {
            display: block;
        }

        /* کارتەکان - باکگراوندی یەکسان */
        .returns-table tbody tr {
            display: block;
            background: var(--card-bg);
            border-radius: 12px;
            margin-bottom: 10px;
            padding: 12px;
            border: 1px solid var(--border-color);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
        }

        body.dark-mode .returns-table tbody tr {
            background: var(--card-bg);
            border-color: var(--border-color);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        }

        .returns-table tbody tr:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        body.dark-mode .returns-table tbody tr:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
        }

        /* خانەکان */
        .returns-table tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 0 !important;
            border: none !important;
            border-bottom: 1px solid var(--border-color) !important;
            text-align: right;
            gap: 10px;
            font-size: 0.8rem;
            background: transparent !important;
            color: var(--text);
            white-space: normal;
        }

        .returns-table tbody td:last-child {
            border-bottom: none !important;
        }

        .returns-table tbody td::before {
            content: attr(data-label);
            font-weight: 700;
            font-size: 0.7rem;
            text-transform: uppercase;
            flex-shrink: 0;
            text-align: left;
            color: var(--primary);
        }

        body.dark-mode .returns-table tbody td::before {
            color: #94a3b8;
        }

        /* شاردنەوەی # لە مۆبایل */
        .returns-table tbody td[data-label="#"] {
            display: none;
        }

        /* ناوی کاڵا لە سەرەوەی کارت */
        .returns-table tbody td[data-label="ناوی کاڵا"] {
            font-size: 1rem;
            font-weight: 700;
            color: var(--primary);
            border-bottom: 2px solid var(--border-color) !important;
            padding-bottom: 10px !important;
            justify-content: center;
            text-align: center;
            margin-bottom: 6px;
        }

        body.dark-mode .returns-table tbody td[data-label="ناوی کاڵا"] {
            color: #93c5fd;
        }

        .returns-table tbody td[data-label="ناوی کاڵا"]::before {
            display: none;
        }

        .empty-row td {
            background: var(--card-bg) !important;
            border-radius: 12px;
            padding: 30px 15px;
            display: block;
            text-align: center;
        }
    }

    @media (max-width: 480px) {
        .returns-table tbody tr {
            padding: 10px;
            margin-bottom: 8px;
        }

        .returns-table tbody td {
            font-size: 0.75rem;
            padding: 5px 0 !important;
        }

        .returns-table tbody td::before {
            font-size: 0.65rem;
        }

        .returns-table tbody td[data-label="ناوی کاڵا"] {
            font-size: 0.9rem;
        }
    }

    /* ============================================
       BADGES
       ============================================ */
    .badge {
        display: inline-block;
        padding: 0.15rem 0.5rem;
        border-radius: 2rem;
        font-size: 0.7rem;
        font-weight: 600;
        white-space: nowrap;
    }

    .badge-damaged { background: #fee2e2; color: #991b1b; }
    .badge-defective { background: #fef3c7; color: #92400e; }
    .badge-exchange { background: #dbeafe; color: #1e40af; }
    .badge-other { background: #e0e7ff; color: #3730a3; }

    body.dark-mode .badge-damaged { background: #7f1d1d; color: #fecaca; }
    body.dark-mode .badge-defective { background: #78350f; color: #fde68a; }
    body.dark-mode .badge-exchange { background: #1e3a5f; color: #bfdbfe; }
    body.dark-mode .badge-other { background: #312e81; color: #c7d2fe; }

    /* ============================================
       INFO CARD
       ============================================ */
    .info-card {
        background: linear-gradient(135deg, rgba(74, 100, 145, 0.05), rgba(93, 122, 176, 0.05));
        border-radius: 12px;
        padding: 1.2rem;
        border-right: 4px solid var(--primary);
        margin-bottom: 1rem;
    }

    body.dark-mode .info-card {
        background: linear-gradient(135deg, rgba(108, 141, 184, 0.1), rgba(93, 122, 176, 0.1));
    }

    .info-display {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--primary);
    }

    body.dark-mode .info-display {
        color: #94a3b8;
    }

    @media (max-width: 767px) {
        .info-card {
            padding: 1rem;
        }
        .info-display {
            font-size: 0.95rem;
        }
    }

    /* ============================================
       LOADING SPINNER
       ============================================ */
    .loading-spinner {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 3px solid rgba(74, 100, 145, 0.2);
        border-radius: 50%;
        border-top-color: var(--primary);
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* ============================================
       TOTALS CARDS
       ============================================ */
    .totals-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .total-card {
        background: var(--card-bg);
        border-radius: 12px;
        padding: 1.2rem 1rem;
        text-align: center;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    .total-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    body.dark-mode .total-card:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }

    .total-card-icon {
        width: 45px;
        height: 45px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.8rem;
        font-size: 1.2rem;
        color: white;
    }
    
    .total-card-icon.amount-icon { background: linear-gradient(135deg, var(--primary), var(--secondary)); }
    .total-card-icon.count-icon { background: linear-gradient(135deg, #10b981, #059669); }
    .total-card-icon.qty-icon { background: linear-gradient(135deg, #f59e0b, #d97706); }

    .total-card-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--text-secondary);
        margin-bottom: 0.4rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .total-card-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 0.2rem;
    }

    .total-card-subtitle {
        font-size: 0.7rem;
        color: var(--text-secondary);
    }

    @media (max-width: 767px) {
        .totals-grid {
            grid-template-columns: 1fr;
            gap: 0.75rem;
            margin-top: 1rem;
        }
        .total-card {
            padding: 0.85rem 0.75rem;
        }
        .total-card-value {
            font-size: 1.2rem;
        }
        .total-card-icon {
            width: 38px;
            height: 38px;
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }
        .total-card:hover {
            transform: none;
        }
    }

    @media (max-width: 480px) {
        .total-card {
            padding: 0.75rem 0.6rem;
        }
        .total-card-value {
            font-size: 1.05rem;
        }
        .total-card-label {
            font-size: 0.68rem;
        }
        .total-card-subtitle {
            font-size: 0.65rem;
        }
    }

    /* ============================================
       PAGINATION
       ============================================ */
    .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 1rem;
        padding: 0.75rem 0 0.5rem;
        flex-wrap: wrap;
        gap: 0.75rem;
        border-top: 1px solid var(--border-color);
    }

    .pagination-controls {
        display: flex;
        gap: 5px;
        align-items: center;
        flex-wrap: wrap;
        justify-content: center;
    }

    .pagination-btn {
        padding: 0.4rem 0.6rem;
        border: 1px solid var(--border-color);
        background: var(--card-bg);
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 0.8rem;
        font-weight: 500;
        color: var(--primary);
    }

    body.dark-mode .pagination-btn {
        background-color: #334155;
        color: #e2e8f0;
        border-color: #475569;
    }

    .pagination-btn:hover:not(:disabled) {
        background: var(--primary);
        border-color: var(--primary);
        color: white;
        transform: translateY(-1px);
    }

    .pagination-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .pagination-btn.active {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border-color: var(--primary);
        color: white;
    }

    .page-info {
        font-size: 0.8rem;
        color: var(--text-secondary);
        padding: 5px 12px;
        background: var(--bg-light);
        border-radius: 20px;
    }

    .rows-per-page {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.8rem;
        color: var(--text-secondary);
    }

    .rows-per-page select {
        padding: 6px 10px;
        border-radius: 8px;
        border: 1px solid var(--border-color);
        background: var(--card-bg);
        cursor: pointer;
        color: var(--text);
        font-size: 0.8rem;
    }

    body.dark-mode .rows-per-page select {
        background-color: #334155;
        color: #e2e8f0;
        border-color: #475569;
    }

    @media (max-width: 767px) {
        .pagination-container {
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
        }
        .pagination-btn {
            padding: 0.35rem 0.55rem;
            font-size: 0.75rem;
        }
        .page-info {
            font-size: 0.75rem;
            padding: 4px 10px;
        }
    }

    @media (max-width: 480px) {
        .pagination-controls {
            flex-wrap: wrap;
        }
        .pagination-btn {
            padding: 0.3rem 0.5rem;
            font-size: 0.7rem;
        }
        .page-info {
            font-size: 0.7rem;
            padding: 3px 8px;
            flex: 1 1 100%;
            text-align: center;
            order: -1;
        }
    }

    /* ============================================
       TOAST - RESPONSIVE + DARK MODE
       ============================================ */
    .toast-custom {
        position: fixed;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%) translateY(100px);
        background: #1e293b;
        color: #fff;
        padding: 14px 28px;
        border-radius: 30px;
        font-size: 0.9rem;
        font-weight: 500;
        z-index: 9999;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.3);
        transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        pointer-events: none;
        white-space: nowrap;
        max-width: calc(100vw - 40px);
    }
    .toast-custom.show { transform: translateX(-50%) translateY(0); }
    .toast-custom.success { 
        background: linear-gradient(135deg, #10b981, #059669); 
        color: white;
    }
    .toast-custom.error { 
        background: linear-gradient(135deg, #ef4444, #dc2626); 
        color: white;
    }

    body.dark-mode .toast-custom {
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.6);
    }

    @media (max-width: 576px) {
        .toast-custom {
            bottom: 15px;
            padding: 11px 20px;
            font-size: 0.8rem;
            white-space: normal;
            text-align: center;
            border-radius: 24px;
            left: 15px;
            right: 15px;
            transform: translateX(0) translateY(100px);
            max-width: none;
        }
        .toast-custom.show {
            transform: translateX(0) translateY(0);
        }
    }

    /* ============================================
       iOS ZOOM PREVENTION
       ============================================ */
    @media (max-width: 576px) {
        input, select, textarea {
            font-size: 16px !important;
        }
        .form-control, .form-select {
            font-size: 16px !important;
        }
    }

    /* ============================================
       TOUCH OPTIMIZATIONS
       ============================================ */
    @media (max-width: 768px) {
        button, .btn, input, select, a {
            -webkit-tap-highlight-color: transparent;
            touch-action: manipulation;
        }
        .btn:active, button:active {
            transform: scale(0.98);
        }
    }

    /* ============================================
       PRINT
       ============================================ */
    @media print {
        .no-print { display: none !important; }
        .returns-table th {
            background: #4a6491 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        body, body.dark-mode { background: white; color: black; }
        .returns-table td { color: black !important; }
        .table-container { overflow-x: visible; }
        .returns-table { min-width: 100%; }
    }
</style>

<!-- Toast -->
<div class="toast-custom" id="toast"></div>

<div class="container py-4">
    <!-- Page Header -->
    <div class="form-header text-white text-center py-3 mb-3">
        <div class="form-logo">
            <i class="fas fa-undo-alt"></i>
        </div>
        <h1 class="h2 mb-2">ڕاپۆرتی گەڕاوەکان</h1>
        <p class="mb-0 opacity-75">بەڕێوەبردنی هەموو کاڵا گەڕێندراوەکان</p>
    </div>

    <!-- Filters Card -->
    <div class="form-card mb-4">
        <div class="section-title"><span class="dot"></span> هەڵبژاردنی فلتەر</div>
        <div class="row g-3 align-items-end">
            <div class="col-md-3 col-sm-6">
                <label class="form-label" for="filterStartDate">
                    <i class="fas fa-calendar-alt"></i> بەرواری دەستپێک <span class="required-star">*</span>
                </label>
                <input type="date" id="filterStartDate" class="form-control">
            </div>
            <div class="col-md-3 col-sm-6">
                <label class="form-label" for="filterEndDate">
                    <i class="fas fa-calendar-alt"></i> بەرواری کۆتایی <span class="required-star">*</span>
                </label>
                <input type="date" id="filterEndDate" class="form-control">
            </div>
            <div class="col-md-3 col-sm-6">
                <label class="form-label" for="cashierFilter">
                    <i class="fas fa-user"></i> کاشێر
                </label>
                <select class="form-select" id="cashierFilter">
                    <option value="">هەموو کاشێرەکان</option>
                </select>
            </div>
            <div class="col-md-3 col-sm-6">
                <label class="form-label" for="reasonFilter">
                    <i class="fas fa-tag"></i> هۆکاری گەڕانەوە
                </label>
                <select class="form-select" id="reasonFilter">
                    <option value="">هەموو هۆکارەکان</option>
                    <option value="damaged">شکاوە / زیان پێگەیشتووە</option>
                    <option value="defective">تێکچوون</option>
                    <option value="exchange">گۆڕین</option>
                    <option value="other">هۆکاری تر</option>
                </select>
            </div>
        </div>
        
        <!-- Info Display -->
        <div id="infoContainer" style="display: none; margin-top: 1rem;"></div>
        
        <!-- Loading Indicator -->
        <div id="loadingIndicator" style="display: none; text-align: center; padding: 1rem;">
            <div class="loading-spinner"></div>
            <span class="me-2">بارکردنی داتاکان...</span>
        </div>
    </div>

    <!-- Table Card -->
    <div class="form-card">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
            <h3 style="font-size: 1rem; font-weight: 700; color: var(--text); margin: 0;">
                <i class="fas fa-table me-2"></i>لیستی گەڕاوەکان
            </h3>
            <button class="btn-outline-custom" id="clearFilterBtn">
                <i class="fas fa-times me-1"></i> پاککردنەوەی فلتەر
            </button>
        </div>
        <div class="table-container">
            <table class="returns-table" id="returnsTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ژمارەی پسوڵە</th>
                        <th>ناوی کاڵا</th>
                        <th>بڕی گەڕاوە</th>
                        <th>نرخی فرۆشتن</th>
                        <th>کۆی گەڕانەوە</th>
                        <th>هۆکار</th>
                        <th>کاشێر</th>
                        <th>بەرواری گەڕانەوە</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <tr class="empty-row">
                        <td colspan="9">تکایە بەرواری دەستپێک و کۆتایی هەڵبژێرە</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="pagination-container" id="paginationContainer" style="display: none;">
            <div class="rows-per-page">
                <span>ژمارەی تۆمارەکان:</span>
                <select id="rowsPerPage">
                    <option value="10">10</option>
                    <option value="25" selected>25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
            <div class="pagination-controls">
                <button class="pagination-btn" id="firstPageBtn" disabled>
                    <i class="fas fa-angle-double-right"></i> یەکەم
                </button>
                <button class="pagination-btn" id="prevPageBtn" disabled>
                    <i class="fas fa-angle-right"></i> پێشوو
                </button>
                <span class="page-info" id="pageInfo">لاپەڕە 1 لە 1</span>
                <button class="pagination-btn" id="nextPageBtn" disabled>
                    داهاتوو <i class="fas fa-angle-left"></i>
                </button>
                <button class="pagination-btn" id="lastPageBtn" disabled>
                    کۆتایی <i class="fas fa-angle-double-left"></i>
                </button>
            </div>
        </div>
        
        <p style="margin-top:10px; font-size:0.8rem; color: var(--text-secondary);" id="recordCount">٠ تۆمار</p>
        
        <!-- Totals Cards -->
        <div id="totalsCardsContainer" style="display: none;">
            <div class="section-title mt-4">
                <span class="dot"></span> کۆی گشتی
            </div>
            <div class="totals-grid">
                <div class="total-card">
                    <div class="total-card-icon amount-icon">
                        <i class="fas fa-boxes"></i>
                    </div>
                    <div class="total-card-label">کۆی گشتی گەڕاوەکان</div>
                    <div class="total-card-value" id="cardTotalAmount">٠</div>
                    <div class="total-card-subtitle">دیناری عێراقی</div>
                </div>
                <div class="total-card">
                    <div class="total-card-icon count-icon">
                        <i class="fas fa-sort-amount-up"></i>
                    </div>
                    <div class="total-card-label">ژمارەی گەڕاوەکان</div>
                    <div class="total-card-value" id="cardTotalCount">٠</div>
                    <div class="total-card-subtitle">کاڵا</div>
                </div>
                <div class="total-card">
                    <div class="total-card-icon qty-icon">
                        <i class="fas fa-cube"></i>
                    </div>
                    <div class="total-card-label">کۆی بڕی گەڕاوە</div>
                    <div class="total-card-value" id="cardTotalQty">٠</div>
                    <div class="total-card-subtitle">یەکە</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    
    // ============================================
    // Variables
    // ============================================
    let allRecords = [];
    let filteredRecords = [];
    let currentPage = 1;
    let rowsPerPage = 25;
    let isLoading = false;
    
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // ============================================
    // Helper Functions
    // ============================================
    
    function formatNum(val) {
        const n = parseFloat(val);
        if (isNaN(n)) return '0';
        return n.toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
    }

    function escapeHtml(text) {
        if (!text) return '';
        return String(text).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#039;');
    }

    function showToast(msg, type = '') {
        const toast = $('#toast');
        clearTimeout(window.toastTimer);
        toast.text(msg);
        toast.attr('class', 'toast-custom ' + type + ' show');
        window.toastTimer = setTimeout(() => toast.removeClass('show'), 2800);
    }

    function getReasonBadge(reason, reasonCode) {
        const code = reasonCode || 'other';
        const classes = {
            'damaged': 'badge-damaged',
            'defective': 'badge-defective',
            'exchange': 'badge-exchange',
            'other': 'badge-other'
        };
        const icons = {
            'damaged': '🔨',
            'defective': '⚠️',
            'exchange': '🔄',
            'other': '📝'
        };
        return `<span class="badge ${classes[code] || 'badge-other'}">${icons[code] || ''} ${escapeHtml(reason || 'هۆکاری تر')}</span>`;
    }

    // ============================================
    // Calculate Totals
    // ============================================
    
    function calculateTotals(records) {
        const totals = {
            totalAmount: 0,
            totalCount: 0,
            totalQty: 0
        };
        
        if (!records || records.length === 0) return totals;
        
        records.forEach(function(rec) {
            totals.totalAmount += parseFloat(rec.Return_Total || rec.return_total || 0);
            totals.totalQty += parseFloat(rec.Amount || rec.amount || 0);
        });
        
        totals.totalCount = records.length;
        return totals;
    }

    function updateTotalsCards(totals, recordCount) {
        const container = $('#totalsCardsContainer');
        
        if (recordCount === 0) {
            $('#cardTotalAmount').text('٠');
            $('#cardTotalCount').text('٠');
            $('#cardTotalQty').text('٠');
            container.slideDown(300);
            return;
        }
        
        $('#cardTotalAmount').text(formatNum(totals.totalAmount));
        $('#cardTotalCount').text(formatNum(totals.totalCount));
        $('#cardTotalQty').text(formatNum(totals.totalQty));
        
        container.slideDown(300);
    }

    // ============================================
    // Pagination Functions
    // ============================================
    
    function getPaginatedRecords() {
        const startIndex = (currentPage - 1) * rowsPerPage;
        const endIndex = startIndex + rowsPerPage;
        return filteredRecords.slice(startIndex, endIndex);
    }
    
    function updatePaginationControls() {
        const totalPages = Math.ceil(filteredRecords.length / rowsPerPage) || 1;
        const hasRecords = filteredRecords.length > 0;
        
        $('#pageInfo').text(`لاپەڕە ${currentPage} لە ${totalPages}`);
        
        $('#firstPageBtn').prop('disabled', currentPage === 1 || !hasRecords);
        $('#prevPageBtn').prop('disabled', currentPage === 1 || !hasRecords);
        $('#nextPageBtn').prop('disabled', currentPage === totalPages || !hasRecords);
        $('#lastPageBtn').prop('disabled', currentPage === totalPages || !hasRecords);
        
        if (filteredRecords.length > rowsPerPage) {
            $('#paginationContainer').show();
        } else {
            $('#paginationContainer').hide();
        }
    }
    
    function renderCurrentPage() {
        const paginatedRecords = getPaginatedRecords();
        renderTable(paginatedRecords, filteredRecords.length);
        updatePaginationControls();
    }

    // ============================================
    // Load Cashiers
    // ============================================
    
    function loadCashiers() {
        $.ajax({
            url: '{{ route("casher.getDataDetails") }}',
            type: 'GET',
            success: function(response) {
                const select = $('#cashierFilter');
                select.html('<option value="">هەموو کاشێرەکان</option>');
                
                if (response && response.users && response.users.length > 0) {
                    response.users.forEach(function(user) {
                        select.append(`<option value="${user.id}">${escapeHtml(user.name)}</option>`);
                    });
                } else if (response && Array.isArray(response)) {
                    response.forEach(function(user) {
                        select.append(`<option value="${user.id}">${escapeHtml(user.name)}</option>`);
                    });
                }
            },
            error: function(xhr) {
                console.error('Error loading cashiers:', xhr);
                showToast('هەڵە لە بارکردنی لیستی کاشێرەکان', 'error');
            }
        });
    }

    // ============================================
    // Load Returns Data
    // ============================================
    
    function loadReturns() {
        const startDateVal = $('#filterStartDate').val();
        const endDateVal = $('#filterEndDate').val();
        
        if (!startDateVal || !endDateVal) {
            allRecords = [];
            filteredRecords = [];
            $('#tableBody').html('<tr class="empty-row"><td colspan="9">تکایە بەرواری دەستپێک و کۆتایی هەڵبژێرە</td></tr>');
            $('#infoContainer').hide();
            $('#totalsCardsContainer').hide();
            $('#paginationContainer').hide();
            $('#recordCount').text('٠ تۆمار');
            return;
        }
        
        if (startDateVal > endDateVal) {
            showToast('بەرواری دەستپێک نابێت لە بەرواری کۆتایی گەورەتر بێت', 'error');
            return;
        }
        
        if (isLoading) return;
        isLoading = true;
        
        const cashierId = $('#cashierFilter').val();
        const reasonFilter = $('#reasonFilter').val();
        
        currentPage = 1;
        
        $('#loadingIndicator').show();
        $('#infoContainer').hide();
        $('#totalsCardsContainer').hide();
        $('#paginationContainer').hide();
        
        $('#tableBody').html(`
            <tr class="empty-row">
                <td colspan="9">
                    <div class="loading-spinner"></div>
                    <span class="me-2">بارکردنی گەڕاوەکان...</span>
                </td>
            </tr>
        `);
        
        $.ajax({
            url: '/returns/report',
            type: 'GET',
            data: {
                start_date: startDateVal,
                end_date: endDateVal,
                cashier_id: cashierId,
                reason: reasonFilter
            },
            success: function(response) {
                console.log('Returns loaded:', response);
                isLoading = false;
                $('#loadingIndicator').hide();
                
                if (response && response.success && response.returns && response.returns.length > 0) {
                    allRecords = response.returns;
                    filteredRecords = [...allRecords];
                    displaySummaryInfo(response.returns, startDateVal, endDateVal, cashierId);
                    renderCurrentPage();
                } else if (response && Array.isArray(response) && response.length > 0) {
                    allRecords = response;
                    filteredRecords = [...allRecords];
                    displaySummaryInfo(response, startDateVal, endDateVal, cashierId);
                    renderCurrentPage();
                } else {
                    allRecords = [];
                    filteredRecords = [];
                    renderTable([], 0);
                    updatePaginationControls();
                    displaySummaryInfo([], startDateVal, endDateVal, cashierId);
                    showToast('هیچ گەڕانەوەیەک نەدۆزرایەوە', '');
                }
            },
            error: function(xhr) {
                isLoading = false;
                console.error('Error loading returns:', xhr);
                $('#loadingIndicator').hide();
                allRecords = [];
                filteredRecords = [];
                $('#tableBody').html('<tr class="empty-row"><td colspan="9">هەڵە لە بارکردنی داتاکان</td></tr>');
                $('#totalsCardsContainer').hide();
                $('#paginationContainer').hide();
                $('#infoContainer').hide();
                $('#recordCount').text('٠ تۆمار');
                showToast('هەڵە لە بارکردنی گەڕاوەکان', 'error');
            }
        });
    }

    function displaySummaryInfo(returns, startDateVal, endDateVal, cashierId) {
        if (!returns || returns.length === 0) {
            let html = `
                <div class="info-card">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <small class="text-muted d-block">مەودای بەروار</small>
                            <span class="info-display">
                                <i class="fas fa-calendar-alt me-1"></i> ${startDateVal}
                                <span class="mx-1">تا</span>
                                <i class="fas fa-calendar-alt me-1"></i> ${endDateVal}
                            </span>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block">کۆی گەڕاوە</small>
                            <span class="info-display">٠ د.ع | ٠ کاڵا</span>
                        </div>
                    </div>
                </div>
            `;
            $('#infoContainer').html(html).slideDown(300);
            return;
        }
        
        const totalAmount = returns.reduce((sum, r) => sum + parseFloat(r.Return_Total || r.return_total || 0), 0);
        const totalCount = returns.length;
        
        let html = `
            <div class="info-card">
                <div class="row g-3">
                    <div class="col-md-3 col-6">
                        <small class="text-muted d-block">بەرواری دەستپێک</small>
                        <span class="info-display">
                            <i class="fas fa-calendar-alt me-1"></i> ${startDateVal}
                        </span>
                    </div>
                    <div class="col-md-3 col-6">
                        <small class="text-muted d-block">بەرواری کۆتایی</small>
                        <span class="info-display">
                            <i class="fas fa-calendar-alt me-1"></i> ${endDateVal}
                        </span>
                    </div>
                    <div class="col-md-3 col-6">
                        <small class="text-muted d-block">کۆی گەڕاوە</small>
                        <span class="info-display">${formatNum(totalAmount)} د.ع</span>
                    </div>
                    <div class="col-md-3 col-6">
                        <small class="text-muted d-block">ژمارەی گەڕاوەکان</small>
                        <span class="info-display">${totalCount} کاڵا</span>
                    </div>
                </div>
            </div>
        `;
        $('#infoContainer').html(html).slideDown(300);
    }

    // ============================================
    // Render Table
    // ============================================
    
    function renderTable(records, totalFilteredCount = null) {
        const tbody = $('#tableBody');
        tbody.empty();
        
        const displayTotal = totalFilteredCount !== null ? totalFilteredCount : filteredRecords.length;
        
        if (!records || records.length === 0) {
            tbody.html('<tr class="empty-row"><td colspan="9">هیچ تۆمارێک نەدۆزرایەوە</td></tr>');
            const totals = calculateTotals([]);
            updateTotalsCards(totals, 0);
            $('#recordCount').text('٠ تۆمار');
            $('#paginationContainer').hide();
            return;
        }
        
        records.forEach(function(rec, index) {
            const globalIndex = ((currentPage - 1) * rowsPerPage) + index + 1;
            const returnDate = rec.Return_Date || rec.return_date || rec.created_at || '';
            const formattedDate = returnDate ? new Date(returnDate).toLocaleDateString('en-US') : '---';
            const reasonBadge = getReasonBadge(rec.Return_Cause || rec.return_cause || '---', rec.reason_code || 'other');
            
            const row = `
                <tr>
                    <td data-label="#">${globalIndex}</td>
                    <td data-label="ژمارەی پسوڵە"><strong>#${escapeHtml(rec.invoice_number || rec.invoice_id || '---')}</strong></td>
                    <td data-label="ناوی کاڵا">${escapeHtml(rec.product_name || rec.Item_Code || '---')}</td>
                    <td data-label="بڕی گەڕاوە">${formatNum(rec.Amount || rec.amount || 0)}</td>
                    <td data-label="نرخی فرۆشتن">${formatNum(rec.Sale_Price || rec.sale_price || 0)} د.ع</td>
                    <td data-label="کۆی گەڕانەوە"><strong style="color: var(--danger);">${formatNum(rec.Return_Total || rec.return_total || 0)} د.ع</strong></td>
                    <td data-label="هۆکار">${reasonBadge}</td>
                    <td data-label="کاشێر">${escapeHtml(rec.cashier_name || rec.Casher_id || '---')}</td>
                    <td data-label="بەرواری گەڕانەوە">${formattedDate}</td>
                </tr>
            `;
            tbody.append(row);
        });
        
        $('#recordCount').text(`${displayTotal} تۆمار`);
        
        const totals = calculateTotals(filteredRecords);
        updateTotalsCards(totals, filteredRecords.length);
    }

    // ============================================
    // Event Handlers
    // ============================================
    
    $('#filterStartDate').on('change', function() {
        const endDateVal = $('#filterEndDate').val();
        if (endDateVal) loadReturns();
    });
    
    $('#filterEndDate').on('change', function() {
        const startDateVal = $('#filterStartDate').val();
        if (startDateVal) loadReturns();
    });
    
    $('#cashierFilter').on('change', function() {
        const startDateVal = $('#filterStartDate').val();
        const endDateVal = $('#filterEndDate').val();
        if (startDateVal && endDateVal) loadReturns();
    });
    
    $('#reasonFilter').on('change', function() {
        if (allRecords.length > 0) {
            applyReasonFilter();
        }
    });
    
    function applyReasonFilter() {
        const reasonFilter = $('#reasonFilter').val();
        
        if (!reasonFilter) {
            filteredRecords = [...allRecords];
        } else {
            filteredRecords = allRecords.filter(function(rec) {
                const recCode = rec.reason_code || 'other';
                return recCode === reasonFilter;
            });
        }
        
        currentPage = 1;
        
        if (filteredRecords.length > 0) {
            renderCurrentPage();
        } else {
            renderTable([], 0);
            updatePaginationControls();
        }
    }
    
    $('#clearFilterBtn').on('click', function() {
        $('#reasonFilter').val('');
        if (allRecords.length > 0) {
            applyReasonFilter();
        }
    });
    
    // Pagination Events
    $('#rowsPerPage').on('change', function() {
        rowsPerPage = parseInt($(this).val());
        currentPage = 1;
        if (filteredRecords.length > 0) renderCurrentPage();
    });
    
    $('#firstPageBtn').on('click', function() {
        if (currentPage !== 1) { currentPage = 1; renderCurrentPage(); }
    });
    
    $('#prevPageBtn').on('click', function() {
        if (currentPage > 1) { currentPage--; renderCurrentPage(); }
    });
    
    $('#nextPageBtn').on('click', function() {
        const totalPages = Math.ceil(filteredRecords.length / rowsPerPage);
        if (currentPage < totalPages) { currentPage++; renderCurrentPage(); }
    });
    
    $('#lastPageBtn').on('click', function() {
        const totalPages = Math.ceil(filteredRecords.length / rowsPerPage);
        if (currentPage !== totalPages && totalPages > 0) { currentPage = totalPages; renderCurrentPage(); }
    });

    // ============================================
    // Initial Load
    // ============================================
    loadCashiers();
    
    const today = new Date().toISOString().split('T')[0];
    $('#filterStartDate').val(today);
    $('#filterEndDate').val(today);
    
    setTimeout(function() {
        loadReturns();
    }, 500);
});
</script>
@endsection