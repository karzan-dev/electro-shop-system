{{--
    resources/views/debtors/index.blade.php
    List of debtors (قەرزارەکان) with search, filtering, and responsive design
    DARK MODE SUPPORTED
    WITH COMPANY COLUMN
--}}

@extends('layouts.navigation')

@section('content')

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ config('app.name', 'Laravel') }} - لیستی قەرزەکان</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    :root {
        --primary: #4a6491;
        --primary-light: #5d7ab0;
        --secondary: #2c3e50;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --info: #3b82f6;
        --text: #1e293b;
        --text-secondary: #64748b;
        --border-color: #e2e8f0;
        --bg-light: #f8fafc;
        --card-bg: #ffffff;
        --input-bg: #f8fafc;
        --table-hover: #f8fafc;
    }

    body.dark-mode {
        --primary: #6c8db8;
        --primary-light: #5d7ab0;
        --secondary: #1e293b;
        --text: #e2e8f0;
        --text-secondary: #94a3b8;
        --border-color: #334155;
        --bg-light: #1e293b;
        --card-bg: #1e293b;
        --input-bg: #0f172a;
        --table-hover: #1e293b;
        background: #0f172a;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        font-family: system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
        min-height: 100vh;
        color: var(--text);
    }

    body.dark-mode { background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-fade-in-up { animation: fadeInUp 0.5s ease forwards; }
    .animate-delay-200 { animation-delay: 0.2s; }
    .animate-delay-300 { animation-delay: 0.3s; }

    .debtors-container { padding: 20px 16px; max-width: 1600px; margin: 0 auto; }
    @media (min-width: 768px) { .debtors-container { padding: 30px 24px; } }

    /* ============================================ */
    /* PAGE HEADER                                   */
    /* ============================================ */
    .page-header {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border-radius: 28px;
        padding: 24px 20px;
        margin-bottom: 28px;
        color: white;
        position: relative;
        overflow: hidden;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: -50%; right: -20%;
        width: 200px; height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .page-title {
        font-size: 1.6rem;
        font-weight: 800;
        margin: 0 0 8px 0;
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    @media (min-width: 768px) { .page-title { font-size: 2rem; } }

    .page-title i {
        background: rgba(255, 255, 255, 0.2);
        padding: 10px;
        border-radius: 20px;
    }

    .page-subtitle { font-size: 0.9rem; opacity: 0.9; }

    .btn-record-own-debt {
        position: relative;
        z-index: 1;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        color: white;
        border: 2px solid rgba(255, 255, 255, 0.3);
        padding: 12px 24px;
        border-radius: 16px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        font-size: 0.95rem;
        text-decoration: none;
        white-space: nowrap;
    }

    .btn-record-own-debt:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-3px);
        color: white;
        text-decoration: none;
    }

    .btn-record-own-debt i {
        font-size: 1.2rem;
        background: rgba(255, 255, 255, 0.25);
        padding: 8px;
        border-radius: 12px;
    }

    .btn-record-own-debt .btn-text {
        display: flex;
        flex-direction: column;
        line-height: 1.2;
    }

    .btn-record-own-debt .btn-text-small {
        font-size: 0.7rem;
        opacity: 0.8;
        font-weight: 500;
    }

    /* ============================================ */
    /* FILTER BAR                                    */
    /* ============================================ */
    .filter-bar {
        background: var(--card-bg);
        border-radius: 20px;
        padding: 16px;
        margin-bottom: 24px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--border-color);
    }

    .filter-grid { display: flex; flex-direction: column; gap: 12px; }

    @media (min-width: 768px) {
        .filter-grid { flex-direction: row; flex-wrap: wrap; align-items: flex-end; gap: 16px; }
        .filter-group { flex: 1; min-width: 180px; }
        .filter-group.search-group { flex: 2; }
    }

    .filter-group label {
        display: block;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        color: var(--text-secondary);
        margin-bottom: 6px;
    }

    .filter-input {
        width: 100%;
        padding: 10px 14px;
        border: 2px solid var(--border-color);
        border-radius: 14px;
        font-size: 0.9rem;
        background: var(--input-bg);
        color: var(--text);
    }

    .filter-input:focus {
        outline: none;
        border-color: var(--primary);
        background: var(--card-bg);
        box-shadow: 0 0 0 3px rgba(74, 100, 145, 0.1);
    }

    .btn-reset {
        background: var(--bg-light);
        color: var(--text);
        border: 2px solid var(--border-color);
        padding: 10px 20px;
        border-radius: 14px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-reset:hover { background: var(--border-color); }

    /* ============================================ */
    /* TABLE                                         */
    /* ============================================ */
    .table-wrapper {
        background: var(--card-bg);
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--border-color);
    }

    .debtors-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.85rem;
        color: var(--text);
    }

    .debtors-table thead tr {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
    }

    .debtors-table th {
        padding: 14px 10px;
        text-align: center;
        font-weight: 700;
        font-size: 0.75rem;
        text-transform: uppercase;
    }

    .debtors-table td {
        padding: 12px 8px;
        text-align: center;
        border-bottom: 1px solid var(--border-color);
        vertical-align: middle;
    }

    .debtors-table tbody tr.row-clickable { cursor: pointer; }
    .debtors-table tbody tr:hover { background: var(--table-hover); }

    .product-image {
        width: 40px; height: 40px;
        border-radius: 10px;
        object-fit: cover;
        border: 2px solid var(--border-color);
    }

    .badge-status {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 30px;
        font-size: 0.7rem;
        font-weight: 700;
    }

    .badge-active { background: #dcfce7; color: #166534; }
    .badge-overdue { background: #fee2e2; color: #991b1b; }
    .badge-warning { background: #f6e8d3; color: #92400e; }
    .badge-warningg { background: #fef3c7; color: #78350f; }

    body.dark-mode .badge-active { background: #14532d; color: #86efac; }
    body.dark-mode .badge-overdue { background: #7f1d1d; color: #fecaca; }
    body.dark-mode .badge-warning { background: #78350f; color: #fde68a; }
    body.dark-mode .badge-warningg { background: #451a03; color: #fcd34d; }

    .amount-positive { color: var(--danger); font-weight: 700; }

    .action-btns { display: flex; gap: 6px; justify-content: center; flex-wrap: wrap; }

    .btn-icon {
        width: 34px; height: 34px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
        color: white;
        font-size: 0.85rem;
        transition: all 0.2s;
    }

    .btn-view { background: linear-gradient(135deg, var(--info), #2563eb); }
    .btn-pay { background: linear-gradient(135deg, var(--success), #059669); }

    .btn-icon:hover { transform: scale(1.1); }

    /* ⭐ COMPANY BADGE */
    .company-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        color: white;
        padding: 0.25rem 0.7rem;
        border-radius: 2rem;
        font-size: 0.7rem;
        font-weight: 700;
        white-space: nowrap;
        box-shadow: 0 2px 6px rgba(74, 100, 145, 0.3);
        transition: all 0.2s;
    }

    .company-badge:hover { transform: translateY(-1px); }

    .company-badge.no-company {
        background: linear-gradient(135deg, #94a3b8, #64748b);
        font-style: italic;
        opacity: 0.85;
    }

    /* ============================================ */
    /* PRODUCT INFO CONTAINER                        */
    /* ============================================ */
    .product-info-container {
        display: flex;
        align-items: center;
        gap: 10px;
        justify-content: center;
    }

    .product-image-clickable {
        cursor: zoom-in;
        transition: all 0.3s;
    }

    .product-image-clickable:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    /* ============================================ */
    /* PAGINATION                                    */
    /* ============================================ */
    .pagination-container {
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        background: var(--card-bg);
        border-top: 1px solid var(--border-color);
    }

    .pagination { display: flex; gap: 6px; flex-wrap: wrap; }

    .pagination button {
        width: 36px; height: 36px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--border-color);
        background: var(--card-bg);
        cursor: pointer;
        color: var(--text);
        font-weight: 500;
    }

    .pagination button.active {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        border: none;
    }

    .pagination button:hover:not(.active) { background: var(--bg-light); }

    .showing-info { font-size: 0.8rem; color: var(--text-secondary); }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: var(--text-secondary);
    }

    .empty-state i { font-size: 4rem; margin-bottom: 20px; opacity: 0.5; }

    /* ============================================ */
    /* MODALS                                        */
    /* ============================================ */
    .modal-overlay, .payment-modal-overlay, .confirm-modal-overlay {
        display: none;
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(5px);
        z-index: 10000;
        align-items: center;
        justify-content: center;
        padding: 16px;
    }

    .modal-content {
        background: var(--card-bg);
        border-radius: 28px;
        width: 100%;
        max-width: 700px;
        max-height: 85vh;
        overflow-y: auto;
        color: var(--text);
    }

    .modal-header {
        padding: 20px;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        border-radius: 28px 28px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .modal-header h3 {
        margin: 0;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .modal-body { padding: 20px; }

    .modal-footer {
        padding: 16px 20px;
        border-top: 1px solid var(--border-color);
        display: flex;
        gap: 12px;
        justify-content: flex-end;
    }

    .close-modal {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        width: 36px; height: 36px;
        border-radius: 50%;
        color: white;
        cursor: pointer;
        font-size: 1.2rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .close-modal:hover { background: rgba(255, 255, 255, 0.3); }

    .detail-row {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid var(--border-color);
        gap: 12px;
        align-items: center;
    }

    .detail-label {
        font-weight: 700;
        color: var(--text-secondary);
        flex-shrink: 0;
    }

    .detail-value {
        color: var(--text);
        font-weight: 600;
        text-align: left;
        word-break: break-word;
    }

    /* ============================================ */
    /* PAYMENT MODAL                                 */
    /* ============================================ */
    .payment-modal {
        background: var(--card-bg);
        border-radius: 24px;
        width: 100%;
        max-width: 500px;
        max-height: 90vh;
        overflow-y: auto;
        color: var(--text);
    }

    .payment-modal-header {
        padding: 20px;
        background: linear-gradient(135deg, var(--success), #059669);
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .payment-modal-header h3 {
        margin: 0;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .payment-modal-body { padding: 24px; }

    .payment-modal-footer {
        padding: 16px 24px;
        border-top: 1px solid var(--border-color);
        display: flex;
        gap: 12px;
        justify-content: flex-end;
    }

    .payment-info-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid var(--border-color);
        font-size: 0.9rem;
    }

    .payment-info-label { color: var(--text-secondary); font-weight: 600; }
    .payment-info-value { font-weight: 700; }

    .payment-input {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid var(--border-color);
        border-radius: 14px;
        font-size: 1.1rem;
        font-weight: 700;
        background: var(--input-bg);
        color: var(--text);
        text-align: center;
    }

    .payment-input:focus {
        outline: none;
        border-color: var(--success);
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }

    .btn-submit-payment {
        background: linear-gradient(135deg, var(--success), #059669);
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 14px;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-cancel-payment {
        background: var(--bg-light);
        color: var(--text);
        border: 2px solid var(--border-color);
        padding: 12px 24px;
        border-radius: 14px;
        font-weight: 600;
        cursor: pointer;
    }

    /* ============================================ */
    /* TOAST NOTIFICATIONS                           */
    /* ============================================ */
    .toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 999999;
        width: calc(100% - 40px);
        max-width: 380px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .toast {
        background: white;
        border-radius: 16px;
        padding: 14px 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
        animation: toastSlideIn 0.35s ease;
        border-right: 5px solid #4a6491;
        font-size: 0.9rem;
        font-weight: 600;
    }

    .toast i { font-size: 1.3rem; flex-shrink: 0; }

    .toast-success {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        color: #065f46;
        border-right-color: #10b981;
    }

    .toast-error {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        color: #991b1b;
        border-right-color: #ef4444;
    }

    .toast-warning {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #92400e;
        border-right-color: #f59e0b;
    }

    .toast-info {
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        color: #1e3a8a;
        border-right-color: #3b82f6;
    }

    body.dark-mode .toast-success { background: linear-gradient(135deg, #064e3b, #065f46); color: #a7f3d0; }
    body.dark-mode .toast-error { background: linear-gradient(135deg, #7f1d1d, #991b1b); color: #fecaca; }
    body.dark-mode .toast-warning { background: linear-gradient(135deg, #78350f, #92400e); color: #fde68a; }
    body.dark-mode .toast-info { background: linear-gradient(135deg, #1e3a8a, #1e40af); color: #bfdbfe; }

    @keyframes toastSlideIn {
        from { transform: translateX(120%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }

    @keyframes toastSlideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(120%); opacity: 0; }
    }

    .loading-spinner {
        display: inline-block;
        width: 20px; height: 20px;
        border: 2px solid var(--border-color);
        border-radius: 50%;
        border-top-color: var(--primary);
        animation: spin 0.6s linear infinite;
    }

    @keyframes spin { to { transform: rotate(360deg); } }

    /* ============================================ */
    /* FULLSCREEN IMAGE                              */
    /* ============================================ */
    .image-fullscreen-overlay {
        display: none;
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.95);
        z-index: 12000;
        align-items: center;
        justify-content: center;
    }

    .image-fullscreen-overlay img {
        max-width: 95%; max-height: 95%;
        object-fit: contain;
        border-radius: 12px;
    }

    .image-fullscreen-close {
        position: absolute;
        top: 20px; right: 20px;
        width: 50px; height: 50px;
        background: rgba(255, 255, 255, 0.2);
        border: none;
        border-radius: 50%;
        color: white;
        font-size: 1.5rem;
        cursor: pointer;
    }

    /* ============================================ */
    /* MOBILE RESPONSIVE                             */
    /* ============================================ */
    @media (max-width: 768px) {
        .page-header { flex-direction: column; align-items: stretch; }
        .btn-record-own-debt { width: 100%; justify-content: center; }
        
        .table-wrapper {
            border-radius: 16px;
            overflow: visible;
            background: transparent;
            box-shadow: none;
            border: none;
        }

        .debtors-table { display: block; }
        .debtors-table thead { display: none; }
        .debtors-table tbody { display: block; }

        .debtors-table tbody tr {
            display: block;
            margin-bottom: 12px;
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 14px;
            background: var(--card-bg);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .debtors-table tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid var(--border-color);
            text-align: right;
        }

        .debtors-table tbody td:last-child { border-bottom: none; }

        .debtors-table tbody td::before {
            content: attr(data-label);
            font-weight: 700;
            font-size: 0.7rem;
            color: var(--primary);
            text-transform: uppercase;
            flex-shrink: 0;
        }

        .action-btns { justify-content: flex-end; width: 100%; }
        .product-info-container { justify-content: flex-end; flex-direction: row-reverse; }
        .company-badge { font-size: 0.65rem; padding: 0.2rem 0.5rem; }
    }
</style>

<div class="debtors-container">
    <!-- Page Header -->
    <div class="page-header animate-fade-in-up">
        <div class="page-header-left">
            <div class="page-title">
                <i class="fas fa-users"></i>
                <span>لیستی قەرزەکان</span>
            </div>
            <p class="page-subtitle">هەموو قەرزە تۆمارکراوەکان لێرە بەڕێوەبەرە</p>
        </div>
        <button class="btn-record-own-debt" onclick="window.location.href= '{{ route('debtors.save-products') }}'">
            <i class="fas fa-hand-holding-dollar"></i>
            <span class="btn-text">
                <span>تۆمارکردنی قەرزەکانی خۆم</span>
                <span class="btn-text-small">قەرزی تایبەتی خۆت تۆمار بکە</span>
            </span>
        </button>
    </div>

    <!-- Filter Bar -->
    <div class="filter-bar animate-fade-in-up animate-delay-200">
        <div class="filter-grid">
            <div class="filter-group search-group">
                <label><i class="fas fa-search"></i> گەڕان</label>
                <input type="text" id="search-input" class="filter-input" placeholder="گەڕان بە ناو، کاڵا، یان کۆمپانیا...">
            </div>
            <div class="filter-group">
                <label><i class="fas fa-calendar"></i> فلتەر بە ڕەوش</label>
                <select id="status-filter" class="filter-input">
                    <option value="all">هەموو قەرزەکان</option>
                    <option value="active">قەرزی چالاک</option>
                    <option value="overdue">قەرزی بەسەرچوو</option>
                    <option value="warning">نزیکە لە کۆتایی</option>
                </select>
            </div>
            <div class="filter-group">
                <label><i class="fas fa-sort-amount-down"></i> ڕیزکردن</label>
                <select id="sort-by" class="filter-input">
                    <option value="name">ناوی کڕیار</option>
                    <option value="amount">بڕی قەرز (زیاتر)</option>
                    <option value="amount_asc">بڕی قەرز (کەمتر)</option>
                    <option value="date">بەرواری قەرز (نوێترین)</option>
                    <option value="date_asc">بەرواری قەرز (کۆنترین)</option>
                    <option value="due_date">بەرواری کۆتایی</option>
                </select>
            </div>
            <div class="filter-group">
                <button id="reset-filters" class="btn-reset">
                    <i class="fas fa-undo-alt"></i> ڕێکخستنەوە
                </button>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="table-wrapper animate-fade-in-up animate-delay-300">
        <div style="overflow-x: auto;">
            <table class="debtors-table" id="debtors-table">
                <thead>
                    <tr>
                        <th>ناوی کڕیار</th>
                        <th>ژمارەی مۆبایل</th>
                        <th>ناونیشان</th>
                        <th>ناوی کاڵا</th>
                        <th>کۆمپانیا</th>
                        <th>بڕی پارەی ماوە</th>
                        <th>بەرواری وەرگرتن</th>
                        <th>بەرواری کۆتایی</th>
                        <th>ڕەوش</th>
                        <th>کردارەکان</th>
                    </tr>
                </thead>
                <tbody id="debtors-tbody">
                    <tr>
                        <td colspan="10" class="empty-state">
                            <i class="fas fa-spinner fa-pulse"></i>
                            <p>بارده‌کێت...</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="pagination-container">
            <div class="showing-info" id="showing-info"></div>
            <div class="pagination" id="pagination"></div>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div id="detail-modal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-user-circle"></i> وردەکاری قەرزار</h3>
            <button class="close-modal" onclick="closeModal()"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body" id="modal-body"></div>
        <div class="modal-footer">
            <button class="btn-reset" onclick="closeModal()"><i class="fas fa-times"></i> داخستن</button>
            <button class="btn-submit-payment" onclick="payDebtFromModal()"><i class="fas fa-money-bill-wave"></i> پارەدان</button>
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div id="payment-modal" class="payment-modal-overlay">
    <div class="payment-modal">
        <div class="payment-modal-header">
            <h3><i class="fas fa-money-bill-wave"></i> تۆمارکردنی پارەدان</h3>
            <button class="close-modal" onclick="closePaymentModal()"><i class="fas fa-times"></i></button>
        </div>
        <div class="payment-modal-body">
            <div class="payment-info-row">
                <span class="payment-info-label">ناوی کڕیار:</span>
                <span class="payment-info-value" id="pay-customer-name">—</span>
            </div>
            <div class="payment-info-row">
                <span class="payment-info-label">کۆی قەرز:</span>
                <span class="payment-info-value" id="pay-total-amount">0 IQD</span>
            </div>
            <div class="payment-info-row">
                <span class="payment-info-label">پارەی دراو:</span>
                <span class="payment-info-value" id="pay-paid-amount">0 IQD</span>
            </div>
            <div class="payment-info-row">
                <span class="payment-info-label">قەرزی ماوە:</span>
                <span class="payment-info-value amount-positive" id="pay-remaining-amount">0 IQD</span>
            </div>
            
            <div style="margin-top: 16px;">
                <label style="display: block; font-size: 0.8rem; font-weight: 700; color: var(--text-secondary); margin-bottom: 8px;">
                    <i class="fas fa-coins"></i> بڕی پارەدان:
                </label>
                <input type="number" id="payment-amount" class="payment-input" placeholder="بڕی پارەکە بنووسە..." min="1">
            </div>
        </div>
        <div class="payment-modal-footer">
            <button class="btn-cancel-payment" onclick="closePaymentModal()"><i class="fas fa-times"></i> ڕەتکردنەوە</button>
            <button class="btn-submit-payment" onclick="submitPayment()"><i class="fas fa-check-circle"></i> تۆمارکردنی پارەدان</button>
        </div>
    </div>
</div>

<!-- Full Screen Image Overlay -->
<div id="image-fullscreen" class="image-fullscreen-overlay" onclick="closeFullscreenImage()">
    <button class="image-fullscreen-close" onclick="closeFullscreenImage()">
        <i class="fas fa-times"></i>
    </button>
    <img id="fullscreen-image" src="" alt="Product Image">
</div>

<!-- Toast Container -->
<div class="toast-container" id="toast-container"></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// ==================== GLOBALS ====================
let currentPage = 1;
let currentDebtors = [];
let totalPages = 1;
let selectedDebtorId = null;
let responseTotal = 0;

// ==================== FULLSCREEN IMAGE ====================
function openFullscreenImage(imageUrl) {
    if (!imageUrl) return;
    document.getElementById('fullscreen-image').src = imageUrl;
    document.getElementById('image-fullscreen').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeFullscreenImage() {
    document.getElementById('image-fullscreen').style.display = 'none';
    document.body.style.overflow = 'auto';
}

// ==================== TOAST ====================
function showToast(message, type = 'success') {
    const container = document.getElementById('toast-container');
    const id = 'toast-' + Date.now();
    const iconMap = {
        'success': 'fa-check-circle',
        'error': 'fa-exclamation-circle',
        'warning': 'fa-exclamation-triangle',
        'info': 'fa-info-circle'
    };
    
    const toast = document.createElement('div');
    toast.id = id;
    toast.className = `toast toast-${type}`;
    toast.innerHTML = `<i class="fas ${iconMap[type]}"></i><span>${message}</span>`;
    container.appendChild(toast);
    
    setTimeout(() => {
        const el = document.getElementById(id);
        if (el) {
            el.style.animation = 'toastSlideOut 0.3s ease forwards';
            setTimeout(() => el.remove(), 300);
        }
    }, 4000);
}

// ==================== LOAD DEBTORS ====================
function loadDebtors() {
    $.ajax({
        url: '{{ route("debtors.list") }}',
        type: 'GET',
        data: {
            page: currentPage,
            search: $('#search-input').val(),
            status: $('#status-filter').val(),
            sort: $('#sort-by').val(),
            per_page: 15
        },
        beforeSend: function() {
            $('#debtors-tbody').html('<tr><td colspan="10" class="empty-state"><i class="fas fa-spinner fa-pulse"></i><p>بارده‌کێت...</p></td></tr>');
        },
        success: function(response) {
            console.log('📥 API Response:', response);
            
            if (response.success) {
                currentDebtors = response.debtors.data;
                totalPages = response.debtors.last_page;
                responseTotal = response.debtors.total;
                renderDebtorsTable(currentDebtors);
                renderPagination();
            } else {
                showToast(response.message || 'هەڵەیەک ڕوویدا', 'error');
            }
        },
        error: function(xhr) {
            console.error('❌ Error:', xhr);
            showToast('هەڵە لە گەڕانی داتا', 'error');
            $('#debtors-tbody').html('<tr><td colspan="10" class="empty-state"><i class="fas fa-exclamation-triangle"></i><p>هەڵەیەک ڕوویدا</p></td></tr>');
        }
    });
}

function renderDebtorsTable(debtors) {
    if (!debtors || debtors.length === 0) {
        $('#debtors-tbody').html('<tr><td colspan="10" class="empty-state"><i class="fas fa-inbox"></i><p>هیچ قەرزارێک نەدۆزرایەوە</p></td></tr>');
        return;
    }
    
    let html = '';
    
    debtors.forEach((debtor) => {
        const statusClass =
            debtor.status === 'warning' ? 'badge-warningg'
            : debtor.status === 'overdue' ? 'badge-overdue'
            : debtor.status === 'paidoff' ? 'badge-active'
            : 'badge-warning';

        const statusText =
            debtor.status === 'warning' ? 'نزیکە'
            : debtor.status === 'overdue' ? 'بەسەرچوو'
            : debtor.status === 'paidoff' ? 'پارەدراو'
            : 'چالاک';

        const amountClass = debtor.pending_amount > 0 ? 'amount-positive' : '';
        const productName = debtor.product_name || '—';
        const company = debtor.company || '—';
        const productImage = debtor.product_image || null;
        
        // ⭐ ناوی کۆمپانیا - پشتگیری هەردووکی
        const hasCompany = company && company !== '—' && company.trim() !== '';
        const companyClass = hasCompany ? 'company-badge' : 'company-badge no-company';
        
        html += `
        <tr class="row-clickable" onclick="showDebtorDetail(${debtor.id})">
            <td data-label="ناوی کڕیار">
                <i class="text-primary me-2"></i> ${escapeHtml(debtor.customer_name || '—')}
            </td>
            <td data-label="ژمارەی مۆبایل">${escapeHtml(debtor.customer_phone || '—')}</td>
            <td data-label="ناونیشان">
                <i class="text-primary me-2"></i> ${escapeHtml(debtor.customer_address || '—')}
            </td>
            <td data-label="ناوی کاڵا" onclick="event.stopPropagation()">
                <div class="product-info-container">
                    ${productImage 
                        ? `<img src="${productImage}" alt="${escapeHtml(productName)}" class="product-image product-image-clickable" onclick="event.stopPropagation(); openFullscreenImage('${productImage}')">` 
                        : '<i class="fas fa-box text-primary"></i>'}
                    <span style="font-weight: 600;">${escapeHtml(productName)}</span>
                </div>
            </td>
            <td data-label="کۆمپانیا">
                <span class="${companyClass}">
                    <i class="fas fa-building"></i> ${escapeHtml(company)}
                </span>
            </td>
            <td data-label="بڕی پارەی ماوە" class="${amountClass}">${formatNumber(debtor.period)} IQD</td>
            <td data-label="بەرواری وەرگرتن">${formatDate(debtor.created_at)}</td>
            <td data-label="بەرواری کۆتایی">${formatDate(debtor.due_date)}</td>
            <td data-label="ڕەوش"><span class="badge-status ${statusClass}">${statusText}</span></td>
            <td data-label="کردارەکان" onclick="event.stopPropagation()">
                <div class="action-btns">
                    <button class="btn-icon btn-view" onclick="showDebtorDetail(${debtor.id})" title="بینین">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn-icon btn-pay" onclick="showPaymentModal(${debtor.id})" title="پارەدان">
                        <i class="fas fa-money-bill-wave"></i>
                    </button>
                </div>
            </td>
        </tr>`;
    });
    
    $('#debtors-tbody').html(html);
}

function renderPagination() {
    let paginationHtml = '';
    const maxVisible = 5;
    let startPage = Math.max(1, currentPage - Math.floor(maxVisible / 2));
    let endPage = Math.min(totalPages, startPage + maxVisible - 1);
    if (endPage - startPage + 1 < maxVisible) {
        startPage = Math.max(1, endPage - maxVisible + 1);
    }
    
    if (currentPage > 1) {
        paginationHtml += `<button onclick="changePage(${currentPage - 1})"><i class="fas fa-chevron-right"></i></button>`;
    }
    
    for (let i = startPage; i <= endPage; i++) {
        paginationHtml += `<button class="${i === currentPage ? 'active' : ''}" onclick="changePage(${i})">${i}</button>`;
    }
    
    if (currentPage < totalPages) {
        paginationHtml += `<button onclick="changePage(${currentPage + 1})"><i class="fas fa-chevron-left"></i></button>`;
    }
    
    $('#pagination').html(paginationHtml);
    
    if (currentDebtors.length > 0) {
        const start = ((currentPage - 1) * 15) + 1;
        const end = Math.min(currentPage * 15, responseTotal || 0);
        $('#showing-info').text(`پیشاندانی ${start} - ${end} لە کۆی ${responseTotal} تۆمار`);
    } else {
        $('#showing-info').text('هیچ تۆمارێک نەدۆزرایەوە');
    }
}

function changePage(page) {
    if (page >= 1 && page <= totalPages && page !== currentPage) {
        currentPage = page;
        loadDebtors();
        $('html, body').animate({ scrollTop: $('.table-wrapper').offset().top - 100 }, 300);
    }
}

// ==================== PAYMENT MODAL ====================
function showPaymentModal(debtorId) {
    selectedDebtorId = debtorId;
    const debtor = currentDebtors.find(d => d.id == debtorId);
    
    if (!debtor) {
        showToast('قەرزار نەدۆزرایەوە', 'error');
        return;
    }
    
    $('#pay-customer-name').text(debtor.customer_name || '—');
    $('#pay-total-amount').text(formatNumber(debtor.total_amount || 0) + ' IQD');
    $('#pay-paid-amount').text(formatNumber(debtor.currency || 0) + ' IQD');
    $('#pay-remaining-amount').text(formatNumber(debtor.period || 0) + ' IQD');
    $('#payment-amount').val('');
    
    $('#payment-modal').css('display', 'flex');
    document.body.style.overflow = 'hidden';
    setTimeout(() => $('#payment-amount').focus(), 300);
}

function closePaymentModal() {
    $('#payment-modal').css('display', 'none');
    document.body.style.overflow = 'auto';
    selectedDebtorId = null;
}

function submitPayment() {
    const amount = parseFloat($('#payment-amount').val());
    
    if (!amount || amount <= 0) {
        showToast('تکایە بڕێکی دروست بنووسە', 'error');
        $('#payment-amount').focus();
        return;
    }
    
    const debtor = currentDebtors.find(d => d.id == selectedDebtorId);
    if (debtor && amount > parseFloat(debtor.period)) {
        showToast('بڕی پارەدان ناتوانێت زیاتر بێت لە قەرزی ماوە', 'error');
        return;
    }
    
    $.ajax({
        url: '{{ route("debtors.pay") }}',
        type: 'POST',
        data: {
            debtor_id: selectedDebtorId,
            amount: amount,
            payment_type: 'now',
            _token: '{{ csrf_token() }}'
        },
        beforeSend: () => showToast('تۆمارکردنی پارەدان...', 'info'),
        success: function(response) {
            if (response.success) {
                showToast(response.message || 'پارەدان بە سەرکەوتوویی تۆمارکرا', 'success');
                closePaymentModal();
                closeModal();
                loadDebtors();
            } else {
                showToast(response.message || 'هەڵەیەک ڕوویدا', 'error');
            }
        },
        error: function(xhr) {
            let msg = 'هەڵەیەک ڕوویدا';
            try {
                const res = JSON.parse(xhr.responseText);
                msg = res.message || msg;
            } catch(e) {}
            showToast(msg, 'error');
        }
    });
}

// ==================== DEBTOR DETAIL ====================
function showDebtorDetail(debtorId) {
    selectedDebtorId = debtorId;
    $('#detail-modal').css('display', 'flex');
    document.body.style.overflow = 'hidden';
    $('#modal-body').html('<div style="text-align:center;padding:40px;"><div class="loading-spinner"></div><p style="margin-top:12px;">بارده‌کێت...</p></div>');
    
    const debtor = currentDebtors.find(d => d.id == debtorId);
    
    if (debtor) {
        renderDebtorDetail(debtor);
    } else {
        $('#modal-body').html('<p class="empty-state">قەرزار نەدۆزرایەوە</p>');
    }
}

function renderDebtorDetail(debtor) {
    const statusClass =
        debtor.status === 'warning' ? 'badge-warningg'
        : debtor.status === 'overdue' ? 'badge-overdue'
        : debtor.status === 'paidoff' ? 'badge-active'
        : 'badge-warning';

    const statusText =
        debtor.status === 'warning' ? 'نزیکە'
        : debtor.status === 'overdue' ? 'بەسەرچوو'
        : debtor.status === 'paidoff' ? 'پارەدراو'
        : 'چالاک';

    const productImage = debtor.product_image || null;
    const companyDisplay = debtor.company || '—';
    
    // ⭐ Company Badge class
    const hasCompany = companyDisplay && companyDisplay !== '—';
    const companyClass = hasCompany ? 'company-badge' : 'company-badge no-company';
    
    const html = `
        ${productImage ? `
        <div class="detail-row">
            <span class="detail-label"><i class="fas fa-image"></i> وێنەی کاڵا:</span>
            <span class="detail-value">
                <img src="${productImage}" 
                     alt="${escapeHtml(debtor.product_name || '')}" 
                     class="product-image-clickable"
                     style="width: 120px; height: 120px; border-radius: 12px; object-fit: cover; border: 2px solid var(--border-color);"
                     onclick="openFullscreenImage('${productImage}')">
            </span>
        </div>
        ` : ''}
        
        <div class="detail-row">
            <span class="detail-label"><i class="fas fa-user"></i> ناوی کڕیار:</span>
            <span class="detail-value">${escapeHtml(debtor.customer_name || '—')}</span>
        </div>
        
        <div class="detail-row">
            <span class="detail-label"><i class="fas fa-phone"></i> ژمارەی مۆبایل:</span>
            <span class="detail-value">${escapeHtml(debtor.customer_phone || '—')}</span>
        </div>
        
        <div class="detail-row">
            <span class="detail-label"><i class="fas fa-map-marker-alt"></i> ناونیشان:</span>
            <span class="detail-value">${escapeHtml(debtor.customer_address || '—')}</span>
        </div>
        
        <div class="detail-row">
            <span class="detail-label"><i class="fas fa-box"></i> ناوی کاڵا:</span>
            <span class="detail-value">${escapeHtml(debtor.product_name || '—')}</span>
        </div>
        
        <div class="detail-row">
            <span class="detail-label"><i class="fas fa-building"></i> کۆمپانیا:</span>
            <span class="detail-value">
                <span class="${companyClass}">
                    <i class="fas fa-building"></i> ${escapeHtml(companyDisplay)}
                </span>
            </span>
        </div>
        
        <div class="detail-row">
            <span class="detail-label"><i class="fas fa-file-invoice"></i> ژمارەی پسوڵە:</span>
            <span class="detail-value">${escapeHtml(debtor.invoice_number || '—')}</span>
        </div>
        
        <div class="detail-row">
            <span class="detail-label"><i class="fas fa-hand-holding-usd"></i> کۆی قەرز:</span>
            <span class="detail-value amount-positive">${formatNumber(debtor.total_amount || 0)} IQD</span>
        </div>
        
        <div class="detail-row">
            <span class="detail-label"><i class="fas fa-check-circle"></i> پارەی دراو:</span>
            <span class="detail-value" style="color:#10b981;">${formatNumber(debtor.currency || 0)} IQD</span>
        </div>
        
        <div class="detail-row">
            <span class="detail-label"><i class="fas fa-exclamation-triangle"></i> قەرزی ماوە:</span>
            <span class="detail-value amount-positive">${formatNumber(debtor.period || 0)} IQD</span>
        </div>
        
        <div class="detail-row">
            <span class="detail-label"><i class="fas fa-calendar-alt"></i> بەرواری وەرگرتن:</span>
            <span class="detail-value">${formatDate(debtor.created_at)}</span>
        </div>
        
        <div class="detail-row">
            <span class="detail-label"><i class="fas fa-calendar-check"></i> بەرواری کۆتایی:</span>
            <span class="detail-value">${formatDate(debtor.due_date)}</span>
        </div>
        
        <div class="detail-row">
            <span class="detail-label"><i class="fas fa-tag"></i> ڕەوش:</span>
            <span class="detail-value"><span class="badge-status ${statusClass}">${statusText}</span></span>
        </div>
    `;
    
    $('#modal-body').html(html);
}

function closeModal() {
    $('#detail-modal').css('display', 'none');
    document.body.style.overflow = 'auto';
    selectedDebtorId = null;
}

function payDebtFromModal() {
    if (selectedDebtorId) {
        const id = selectedDebtorId;
        closeModal();
        setTimeout(() => showPaymentModal(id), 300);
    }
}

// ==================== HELPERS ====================
function formatNumber(n) {
    if (n === undefined || n === null) return '0';
    return Number(n).toLocaleString();
}

function formatDate(dateString) {
    if (!dateString || dateString === '0000-00-00') return '—';
    const date = new Date(dateString);
    if (isNaN(date.getTime())) return '—';
    return date.toLocaleDateString('ku-IQ', { year: 'numeric', month: '2-digit', day: '2-digit' });
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

// ==================== EVENTS ====================
$(document).ready(function() {
    loadDebtors();
    
    let searchTimeout;
    $('#search-input').on('keyup', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            currentPage = 1;
            loadDebtors();
        }, 400);
    });
    
    $('#status-filter, #sort-by').on('change', function() {
        currentPage = 1;
        loadDebtors();
    });
    
    $('#reset-filters').on('click', function() {
        $('#search-input').val('');
        $('#status-filter').val('all');
        $('#sort-by').val('name');
        currentPage = 1;
        loadDebtors();
    });
    
    $('#detail-modal').on('click', function(e) {
        if (e.target === this) closeModal();
    });
    
    $('#payment-modal').on('click', function(e) {
        if (e.target === this) closePaymentModal();
    });
    
    $('#payment-amount').on('keypress', function(e) {
        if (e.key === 'Enter') submitPayment();
    });
    
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape') {
            if ($('#image-fullscreen').css('display') === 'flex') closeFullscreenImage();
            else if ($('#payment-modal').css('display') === 'flex') closePaymentModal();
            else if ($('#detail-modal').css('display') === 'flex') closeModal();
        }
    });
});
</script>
@endsection