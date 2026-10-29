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

    * { box-sizing: border-box; }

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

    body.dark-mode .form-control::placeholder {
        color: #94a3b8;
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

    .btn-outline-custom {
        background: white;
        border: 2px solid var(--primary);
        color: var(--primary);
        padding: 0.6rem 1rem;
        border-radius: 40px;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition-base);
        font-family: inherit;
        font-size: 0.9rem;
        white-space: nowrap;
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

    .btn-sm-custom {
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: linear-gradient(135deg, var(--info), #2563eb);
        color: white;
    }

    .btn-sm-custom:hover {
        transform: scale(1.05);
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.4);
        color: white;
    }

    .search-input-wrapper {
        position: relative;
    }
    .search-input-wrapper .form-control {
        padding-right: 2.5rem;
    }
    .search-input-wrapper i {
        position: absolute;
        right: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--primary);
        z-index: 4;
    }

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

    .profit-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.8rem;
        white-space: nowrap;
        color: var(--text);
        min-width: 1200px;
    }

    .profit-table thead {
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .profit-table th {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        font-weight: 600;
        padding: 0.75rem 0.5rem;
        text-align: center;
        border-bottom: 2px solid var(--primary-dark);
        font-size: 0.75rem;
    }

    .profit-table td {
        padding: 0.625rem 0.5rem;
        text-align: center;
        border-bottom: 1px solid var(--border-color);
        vertical-align: middle;
        font-size: 0.8rem;
    }

    .profit-table tbody tr {
        transition: background-color 0.2s ease;
    }

    .profit-table tbody tr:nth-child(even) {
        background-color: var(--bg-light);
    }

    .profit-table tbody tr:hover {
        background-color: var(--table-hover) !important;
    }

    .empty-row td {
        color: var(--text-secondary);
        padding: 30px;
        text-align: center;
    }

    .badge {
        display: inline-block;
        padding: 0.15rem 0.5rem;
        border-radius: 2rem;
        font-size: 0.7rem;
        font-weight: 600;
        white-space: nowrap;
    }

    .badge-profit { background: #d1fae5; color: #065f46; }
    .badge-loss { background: #fee2e2; color: #991b1b; }

    body.dark-mode .badge-profit { background: #064e3b; color: #d1fae5; }
    body.dark-mode .badge-loss { background: #7f1d1d; color: #fee2e2; }

    .totals-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
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
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    .total-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .total-card-icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.6rem;
        font-size: 1.1rem;
        color: white;
    }

    .total-card-icon.items { background: linear-gradient(135deg, #06b6d4, #0891b2); }
    .total-card-icon.sales { background: linear-gradient(135deg, #3b82f6, #2563eb); }
    .total-card-icon.discount { background: linear-gradient(135deg, #f59e0b, #d97706); }
    .total-card-icon.loans { background: linear-gradient(135deg, #f97316, #ea580c); }
    .total-card-icon.net { background: linear-gradient(135deg, #14b8a6, #0d9488); }
    .total-card-icon.purchase { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
    .total-card-icon.profit { background: linear-gradient(135deg, #10b981, #059669); }

    .total-card-label {
        font-size: 0.7rem;
        font-weight: 600;
        color: var(--text-secondary);
        margin-bottom: 0.3rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .total-card-value {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--text);
    }

    .total-card-subtitle {
        font-size: 0.65rem;
        color: var(--text-secondary);
    }

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
        min-width: 35px;
        text-align: center;
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
    }

    .pagination-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .pagination-btn.active {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border-color: var(--primary);
        color: white;
        font-weight: 700;
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
        z-index: 99999;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.3);
        transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        pointer-events: none;
        white-space: nowrap;
        max-width: calc(100% - 40px);
    }
    .toast-custom.show { transform: translateX(-50%) translateY(0); }
    .toast-custom.success { background: #10b981; }
    .toast-custom.error { background: #ef4444; }

    body.dark-mode .toast-custom {
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.6);
    }

    @media (max-width: 576px) {
        .toast-custom {
            left: 10px;
            right: 10px;
            transform: translateX(0) translateY(100px);
            white-space: normal;
            text-align: center;
            padding: 12px 16px;
            font-size: 0.85rem;
            max-width: none;
        }
        .toast-custom.show {
            transform: translateX(0) translateY(0);
        }
    }

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

    @media print {
        .no-print { display: none !important; }
        .profit-table th { background: #4a6491 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        body { background: white; color: black; }
        .profit-table { min-width: 100%; }
        .table-container { overflow-x: visible; max-height: none; }
    }

    @media (min-width: 1400px) {
        .container { max-width: 1320px; }
        .profit-table { min-width: 100%; }
    }

    @media (max-width: 1199px) {
        .profit-table { min-width: 1100px; }
    }

    @media (max-width: 991px) {
        .profit-table { min-width: 1000px; }
        .form-header h1 { font-size: 1.3rem; }
        .total-card-value { font-size: 1.1rem; }
        .totals-grid { grid-template-columns: repeat(3, 1fr); }
    }

    @media (max-width: 767px) {
        .totals-grid { grid-template-columns: repeat(2, 1fr); }
        .form-header h1 { font-size: 1.1rem; }
        .pagination-container { flex-direction: column; align-items: center; }
        .form-card { padding: 12px; }
        .btn-outline-custom { font-size: 0.8rem; padding: 0.5rem 0.8rem; }

        .table-container {
            overflow-x: visible !important;
            border: none !important;
            background: transparent !important;
            max-height: none !important;
            border-radius: 0 !important;
        }

        .profit-table {
            display: block;
            width: 100%;
            min-width: 100% !important;
            white-space: normal;
        }

        .profit-table thead {
            display: none !important;
        }

        .profit-table tbody {
            display: block;
            width: 100%;
        }

        .profit-table tbody tr {
            display: block;
            margin-bottom: 14px;
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 14px;
            background: var(--card-bg);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
        }

        body.dark-mode .profit-table tbody tr {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        }

        .profit-table tbody tr:nth-child(even) {
            background-color: var(--card-bg);
        }

        .profit-table tbody tr:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            background-color: var(--card-bg) !important;
        }

        body.dark-mode .profit-table tbody tr:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
        }

        .profit-table tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 9px 0 !important;
            border: none !important;
            border-bottom: 1px solid var(--border-color) !important;
            text-align: right;
            gap: 10px;
            font-size: 0.85rem;
            background: transparent !important;
            color: var(--text);
            white-space: normal;
        }

        body.dark-mode .profit-table tbody td {
            border-bottom-color: #334155 !important;
        }

        .profit-table tbody td:last-child {
            border-bottom: none !important;
        }

        .profit-table tbody td::before {
            content: attr(data-label);
            font-weight: 700;
            font-size: 0.72rem;
            color: var(--primary);
            text-transform: uppercase;
            flex-shrink: 0;
            text-align: left;
            letter-spacing: 0.3px;
        }

        body.dark-mode .profit-table tbody td::before {
            color: var(--primary);
        }

        .profit-table tbody td[data-label="#"] {
            display: none;
        }

        .profit-table tbody td[data-label="ناوی کاڵا"] {
            font-size: 1rem;
            font-weight: 700;
            color: var(--primary);
            border-bottom: 2px solid var(--border-color) !important;
            padding-bottom: 12px !important;
            padding-top: 0 !important;
            justify-content: center;
            text-align: center;
            margin-bottom: 8px;
        }

        body.dark-mode .profit-table tbody td[data-label="ناوی کاڵا"] {
            color: #93c5fd;
            border-bottom-color: #334155 !important;
        }

        .profit-table tbody td[data-label="ناوی کاڵا"]::before {
            display: none;
        }

        .profit-table tbody td[data-label="کۆمپانیا"] {
            justify-content: space-between;
            color: var(--text-secondary);
            font-style: italic;
        }

        .profit-table tbody td .badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.6rem;
        }

        .profit-table tbody td[data-label="پوختەی فرۆش"],
        .profit-table tbody td[data-label="قازانج"] {
            font-weight: 700;
            font-size: 0.9rem;
        }

        .profit-table tbody tr.empty-row {
            display: block;
            text-align: center;
            padding: 30px 14px;
        }

        .profit-table tbody tr.empty-row td {
            display: block;
            text-align: center;
            border: none !important;
            padding: 10px 0 !important;
            color: var(--text-secondary);
        }

        .profit-table tbody tr.empty-row td::before {
            display: none;
        }
    }

    @media (max-width: 575px) {
        .totals-grid { grid-template-columns: 1fr 1fr; gap: 0.5rem; }
        .total-card { padding: 0.75rem 0.5rem; }
        .total-card-value { font-size: 1rem; }
        .total-card-icon { width: 35px; height: 35px; font-size: 0.9rem; }
        .form-header { padding: 12px 8px; }
        .form-header h1 { font-size: 1rem; }
        .form-logo { width: 45px; height: 45px; }
        .form-logo i { font-size: 1.3rem; }
        .section-title { font-size: 0.85rem; }

        .profit-table tbody td {
            font-size: 0.8rem;
            padding: 8px 0 !important;
        }

        .profit-table tbody td::before {
            font-size: 0.68rem;
        }

        .profit-table tbody td[data-label="ناوی کاڵا"] {
            font-size: 0.95rem;
        }

        .pagination-btn {
            min-width: 32px;
            padding: 0.35rem 0.5rem;
            font-size: 0.75rem;
        }

        .page-info {
            font-size: 0.75rem;
            padding: 4px 10px;
        }
    }

    @media (max-width: 576px) {
        input, select, textarea {
            font-size: 16px !important;
        }
    }

    @media (max-width: 768px) {
        button, .btn, input, select, a {
            -webkit-tap-highlight-color: transparent;
            touch-action: manipulation;
        }

        .btn:active, button:active {
            transform: scale(0.98);
        }
    }
</style>

<div class="toast-custom" id="toast"></div>

<div class="container py-4">
    <!-- Page Header -->
    <div class="form-header text-white text-center py-3 mb-3">
        <div class="form-logo">
            <i class="fas fa-chart-line"></i>
        </div>
        <h1 class="h2 mb-2">ڕاپۆرتی فرۆشتن و قازانج</h1>
        <p class="mb-0 opacity-75">پوختەی فرۆشتن، قازانج بەپێی کاڵا</p>
    </div>

    <!-- Filters Card -->
    <div class="form-card mb-4 no-print">
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
                <label class="form-label" for="filterSearch">
                    <i class="fas fa-search"></i> گەڕان (بە ناو یان بارکۆد)
                </label>
                <div class="search-input-wrapper">
                    <i class="fas fa-search"></i>
                    <input type="text" id="filterSearch" class="form-control" placeholder="ناوی کاڵا یان بارکۆد...">
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <label class="form-label" for="filterCompany">
                    <i class="fas fa-building"></i> ناوی کۆمپانیا
                </label>
                <div class="search-input-wrapper">
                    <i class="fas fa-building"></i>
                    <input type="text" id="filterCompany" class="form-control" placeholder="ناوی کۆمپانیا...">
                </div>
            </div>
        </div>

        <div id="infoContainer" style="display: none; margin-top: 1rem;"></div>
        <div id="loadingIndicator" style="display: none; text-align: center; padding: 1rem;">
            <div class="loading-spinner"></div>
            <span class="me-2">بارکردنی داتاکان...</span>
        </div>
    </div>

    <!-- Table Card -->
    <div class="form-card">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
            <h3 style="font-size: 1rem; font-weight: 700; color: var(--text); margin: 0;">
                <i class="fas fa-table me-2"></i>لیستی فرۆشتن و قازانج بەپێی کاڵا
            </h3>
            <div class="d-flex align-items-center gap-2">
                <span class="text-muted small" id="resultCount">٠ ئەنجام</span>
                <button type="button" class="btn-outline-custom btn-sm" id="btnExportPDF" title="هەناردەکردنی PDF">
                    <i class="fas fa-file-pdf"></i> PDF
                </button>
                <button type="button" class="btn-outline-custom btn-sm" id="btnReset" title="پاککردنەوە">
                    <i class="fas fa-undo-alt"></i>
                </button>
            </div>
        </div>

        <div class="table-container">
            <table class="profit-table" id="profitTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ناوی کاڵا</th>
                        <th>کۆمپانیا</th>
                        <th>ژمارە</th>
                        <th>نرخی کڕین (تاک)</th>
                        <th>کۆی کڕین</th>
                        <th>نرخی فرۆشتن (تاک)</th>
                        <th>کۆی فرۆشتن</th>
                        <th>داشکاندن</th>
                        <th>پوختەی فرۆش</th>
                        <th>قازانج</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <tr class="empty-row">
                        <td colspan="11">تکایە بەروارێک هەڵبژێرە</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pagination-container" id="paginationContainer" style="display: none;">
            <div class="rows-per-page">
                <span>تۆمار:</span>
                <select id="rowsPerPage">
                    <option value="10">10</option>
                    <option value="25" selected>25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
            <div class="pagination-controls">
                <button class="pagination-btn" id="firstPageBtn" disabled title="یەکەم لاپەڕە">
                    <i class="fas fa-angle-double-right"></i>
                </button>
                <button class="pagination-btn" id="prevPageBtn" disabled title="لاپەڕەی پێشوو">
                    <i class="fas fa-angle-right"></i>
                </button>
                <span class="page-info" id="pageInfo">لاپەڕە 1 لە 1</span>
                <button class="pagination-btn" id="nextPageBtn" disabled title="لاپەڕەی داهاتوو">
                    <i class="fas fa-angle-left"></i>
                </button>
                <button class="pagination-btn" id="lastPageBtn" disabled title="کۆتا لاپەڕە">
                    <i class="fas fa-angle-double-left"></i>
                </button>
            </div>
        </div>

        <p style="margin-top:10px; font-size:0.8rem; color: var(--text-secondary);" id="recordCount">٠ تۆمار</p>

        <!-- Totals Cards -->
        <div id="totalsCardsContainer" style="display: none;">
            <div class="section-title mt-4"><span class="dot"></span> کۆی گشتی</div>
            <div class="totals-grid" id="totalsGrid">
                <!-- Filled by JS -->
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function(){
    let allRecords = [];
    let filteredRecords = [];
    let currentPage = 1;
    let rowsPerPage = 25;
    let isLoading = false;
    let searchTimeout;

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // ==================== HELPERS ====================
    function formatNum(val) {
        const n = parseFloat(val);
        if (isNaN(n)) return '0';
        return n.toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
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
        return result;
    }

    function showToast(msg, type = '') {
        const toast = $('#toast');
        clearTimeout(window.toastTimer);
        toast.text(msg);
        toast.attr('class', 'toast-custom ' + type + ' show');
        window.toastTimer = setTimeout(() => toast.removeClass('show'), 2800);
    }

    // ==================== LOAD REPORT ====================
    function loadReport() {
        const startDate = $('#filterStartDate').val();
        const endDate = $('#filterEndDate').val();

        if (!startDate || !endDate) {
            allRecords = [];
            filteredRecords = [];
            $('#tableBody').html('<tr class="empty-row"><td colspan="11">تکایە بەرواری دەستپێک و کۆتایی هەڵبژێرە</td></tr>');
            $('#totalsCardsContainer').hide();
            $('#paginationContainer').hide();
            $('#infoContainer').hide();
            $('#resultCount').text('٠ ئەنجام');
            $('#recordCount').text('٠ تۆمار');
            return;
        }

        if (isLoading) return;
        isLoading = true;
        currentPage = 1;

        $('#loadingIndicator').show();

        if ($('#tableBody tr.empty-row').length > 0) {
            $('#tableBody').html('<tr class="empty-row"><td colspan="11"><div class="loading-spinner"></div> بارکردن...</td></tr>');
        }

        $.ajax({
            url: '/profit-report/data',
            type: 'GET',
            data: {
                start_date: startDate,
                end_date: endDate,
                search: $('#filterSearch').val().trim() || '',
                company: $('#filterCompany').val().trim() || ''
            },
            success: function(response) {
                isLoading = false;
                $('#loadingIndicator').hide();

                if (response?.success) {
                    allRecords = response.report || [];
                    filteredRecords = [...allRecords];
                    updateSummaryCards(response.summary);
                    renderCurrentPage();
                    displayInfo(response.summary, startDate, endDate);
                    $('#resultCount').text(`${filteredRecords.length} ئەنجام`);
                } else {
                    allRecords = [];
                    filteredRecords = [];
                    $('#tableBody').html('<tr class="empty-row"><td colspan="11">هیچ تۆمارێک نەدۆزرایەوە</td></tr>');
                    $('#totalsCardsContainer').hide();
                    $('#paginationContainer').hide();
                    $('#infoContainer').hide();
                    $('#resultCount').text('٠ ئەنجام');
                    $('#recordCount').text('٠ تۆمار');
                }
            },
            error: function(xhr) {
                isLoading = false;
                $('#loadingIndicator').hide();
                console.error('Error:', xhr);
                showToast('هەڵە لە بارکردنی داتاکان', 'error');
            }
        });
    }

    function displayInfo(summary, startDate, endDate) {
        if (!summary) return;
        
        const netSales = (summary.total_sales || 0) - (summary.total_loans || 0) - (summary.total_discount || 0);
        // قازانج = قازانج خاو - داشکاندن
        const netProfit = (summary.total_profit || 0) - (summary.total_discount || 0);
        
        $('#infoContainer').html(`
            <div class="info-card">
                <div class="row g-3">
                    <div class="col-md-3 col-sm-6">
                        <small class="text-muted d-block">مەودای بەروار</small>
                        <span class="info-display"><i class="fas fa-calendar-alt me-1"></i> ${startDate} تا ${endDate}</span>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <small class="text-muted d-block">کۆی فرۆش</small>
                        <span class="info-display">${formatNum(summary.total_sales)} د.ع</span>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <small class="text-muted d-block">پوختەی فرۆش (بەبێ قەرز و داشکاندن)</small>
                        <span class="info-display text-success">${formatNum(netSales)} د.ع</span>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <small class="text-muted d-block">کۆی قازانج</small>
                        <span class="info-display text-success">${formatNum(netProfit)} د.ع</span>
                    </div>
                </div>
            </div>
        `).slideDown(300);
    }

    function updateSummaryCards(summary) {
        if (!summary) return;
        
        const netSales = (summary.total_sales || 0) - (summary.total_loans || 0) - (summary.total_discount || 0);
        // قازانج = قازانج خاو - داشکاندن
        const netProfit = (summary.total_profit || 0) - (summary.total_discount || 0);
        
        const cards = [
            { icon: 'items', label: 'کۆی کاڵا', value: formatNum(summary.total_items_sold), sub: 'دانە', iconClass: 'fa-boxes' },
            { icon: 'sales', label: 'کۆی فرۆش', value: formatNum(summary.total_sales), sub: 'د.ع', iconClass: 'fa-shopping-cart' },
            { icon: 'discount', label: 'کۆی داشکاندن', value: formatNum(summary.total_discount || 0), sub: 'د.ع', iconClass: 'fa-tags' },
            { icon: 'loans', label: 'کۆی قەرز', value: formatNum(summary.total_loans || 0), sub: 'د.ع', iconClass: 'fa-hand-holding-usd' },
         
            { icon: 'purchase', label: 'کۆی کڕین', value: formatNum(summary.total_purchase), sub: 'د.ع', iconClass: 'fa-shopping-bag' },
            { icon: 'profit', label: 'کۆی قازانج', value: formatNum(netProfit), sub: 'د.ع', iconClass: 'fa-chart-line' },
        ];

        let html = '';
        cards.forEach(c => {
            html += `<div class="total-card">
                <div class="total-card-icon ${c.icon}"><i class="fas ${c.iconClass}"></i></div>
                <div class="total-card-label">${c.label}</div>
                <div class="total-card-value">${c.value}</div>
                <div class="total-card-subtitle">${c.sub}</div>
            </div>`;
        });
        $('#totalsGrid').html(html);
        $('#totalsCardsContainer').slideDown(300);
    }

    // ==================== PAGINATION ====================
    function renderCurrentPage() {
        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        const paginated = filteredRecords.slice(start, end);
        renderTable(paginated);
        updatePagination();
    }

    function renderTable(records) {
        const tbody = $('#tableBody');
        tbody.empty();

        if (!records.length) {
            tbody.html('<tr class="empty-row"><td colspan="11">هیچ تۆمارێک نەدۆزرایەوە</td></tr>');
            $('#recordCount').text('٠ تۆمار');
            return;
        }

        records.forEach((rec, i) => {
            const idx = ((currentPage - 1) * rowsPerPage) + i + 1;
            const quantity = rec.total_quantity || rec.quantity || 0;
            const purchasePrice = rec.purchase_price || 0;
            const totalPurchase = rec.total_purchase || (purchasePrice * quantity) || 0;
            const salePrice = rec.sale_price || rec.price || 0;
            const totalSale = rec.total_sale || rec.total || (salePrice * quantity) || 0;
            const discount = rec.discount || rec.total_discount || 0;
            const netSale = totalSale - discount;
            // قازانج = قازانج خاو - داشکاندن
            const rawProfit = rec.profit || (netSale - totalPurchase) || 0;
            const profit = rawProfit - discount;
            const companyName = rec.company || rec.company_name || '---';
            
            const profitClass = profit >= 0 ? 'badge-profit' : 'badge-loss';

            tbody.append(`<tr>
                <td data-label="#">${idx}</td>
                <td data-label="ناوی کاڵا"><strong>${rec.product_name || rec.name || '---'}</strong></td>
                <td data-label="کۆمپانیا">${companyName}</td>
                <td data-label="ژمارە">${quantity}</td>
                <td data-label="نرخی کڕین (تاک)">${formatNum(purchasePrice)}</td>
                <td data-label="کۆی کڕین">${formatNum(totalPurchase)}</td>
                <td data-label="نرخی فرۆشتن (تاک)">${formatNum(salePrice)}</td>
                <td data-label="کۆی فرۆشتن">${formatNum(totalSale)}</td>
                <td data-label="داشکاندن"><span class="text-warning">${formatNum(discount)}</span></td>
                <td data-label="پوختەی فرۆش"><strong>${formatNum(netSale)}</strong></td>
                <td data-label="قازانج"><span class="badge ${profitClass}">${formatNum(profit)}</span></td>
            </tr>`);
        });

        $('#recordCount').text(`${filteredRecords.length} تۆمار`);
    }

    function updatePagination() {
        const totalPages = Math.ceil(filteredRecords.length / rowsPerPage) || 1;
        
        $('#pageInfo').text(`لاپەڕە ${currentPage} لە ${totalPages}`);
        
        $('#firstPageBtn, #prevPageBtn').prop('disabled', currentPage === 1);
        $('#nextPageBtn, #lastPageBtn').prop('disabled', currentPage === totalPages || totalPages === 0);
        
        $('.pagination-btn').removeClass('active');
        
        if (filteredRecords.length > rowsPerPage) {
            $('#paginationContainer').slideDown(200);
        } else {
            $('#paginationContainer').slideUp(200);
        }
    }

    // ==================== EVENTS ====================
    
    $('#filterSearch').on('input', function() {
        const original = $(this).val();
        const normalized = normalizeToEnglishNumbers(original);
        if (original !== normalized) {
            const cursor = this.selectionStart;
            $(this).val(normalized);
            this.setSelectionRange(cursor, cursor);
        }
        
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            loadReport();
        }, 500);
    });

    $('#filterCompany').on('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            loadReport();
        }, 500);
    });

    $('#filterStartDate, #filterEndDate').on('change', function() {
        loadReport();
    });
    
    $('#btnReset').click(function() {
        $('#filterSearch').val('');
        $('#filterCompany').val('');
        const today = new Date().toISOString().split('T')[0];
        $('#filterStartDate').val(today);
        $('#filterEndDate').val(today);
        loadReport();
    });

    $('#btnExportPDF').click(function() {
        const start = $('#filterStartDate').val();
        const end = $('#filterEndDate').val();
        if (!start || !end) { showToast('بەروار هەڵبژێرە', 'error'); return; }
        const params = new URLSearchParams({
            start_date: start,
            end_date: end,
            search: $('#filterSearch').val().trim() || '',
            company: $('#filterCompany').val().trim() || ''
        });
        window.open(`/profit-report/export-pdf?${params.toString()}`, '_blank');
    });

    // Pagination Events
    $('#firstPageBtn').click(function() {
        if (currentPage !== 1) {
            currentPage = 1;
            renderCurrentPage();
        }
    });
    
    $('#prevPageBtn').click(function() {
        if (currentPage > 1) {
            currentPage--;
            renderCurrentPage();
        }
    });
    
    $('#nextPageBtn').click(function() {
        const totalPages = Math.ceil(filteredRecords.length / rowsPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            renderCurrentPage();
        }
    });
    
    $('#lastPageBtn').click(function() {
        const totalPages = Math.ceil(filteredRecords.length / rowsPerPage);
        if (currentPage !== totalPages) {
            currentPage = totalPages;
            renderCurrentPage();
        }
    });
    
    $('#rowsPerPage').change(function() {
        rowsPerPage = parseInt($(this).val());
        currentPage = 1;
        renderCurrentPage();
    });

    // ==================== INIT ====================
    const today = new Date().toISOString().split('T')[0];
    $('#filterStartDate').val(today);
    $('#filterEndDate').val(today);
    setTimeout(() => loadReport(), 300);
});
</script>
@endsection