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
    }

    body.dark-mode {
        --text: #e2e8f0;
        --border-color: #334155;
        --bg-light: #1e293b;
    }

    body {
        background: #f1f5f9;
        font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    body.dark-mode {
        background: #0f172a;
        color: #e2e8f0;
    }

    .container {
        max-width: 1400px;
    }

    /* Card Styles */
    .form-card {
        background: white;
        border-radius: 1rem;
        padding: 2rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        margin-bottom: 1.5rem;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    body.dark-mode .form-card {
        background: #1e293b;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .table-card {
        background: white;
        border-radius: 1rem;
        padding: 1.5rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    body.dark-mode .table-card {
        background: #1e293b;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .form-header {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border-radius: 0.75rem 0.75rem 0 0 !important;
    }

    .form-logo {
        background-color: white;
        width: 70px;
        height: 70px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
    }

    body.dark-mode .form-logo {
        background-color: #334155;
    }

    .form-logo i {
        font-size: 2rem;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Section Title */
    .section-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 1rem;
        padding-bottom: 0.6rem;
        border-bottom: 2px solid var(--secondary);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    body.dark-mode .section-title {
        color: #94a3b8;
        border-bottom-color: #334155;
    }

    .section-title .dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--primary);
        display: inline-block;
        flex-shrink: 0;
    }

    /* Form Styles */
    .form-label {
        font-weight: 600;
        color: var(--secondary);
        margin-bottom: 0.4rem;
        font-size: 0.85rem;
    }

    body.dark-mode .form-label {
        color: #94a3b8;
    }

    .required-star {
        color: var(--danger);
        margin-right: 2px;
    }

    .form-control, .form-select {
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        padding: 0.7rem 1rem;
        transition: all 0.3s;
        background-color: white;
        color: #1e293b;
        font-family: inherit;
        font-size: 0.9rem;
    }

    body.dark-mode .form-control,
    body.dark-mode .form-select {
        background-color: #0f172a;
        border-color: #334155;
        color: #e2e8f0;
    }

    body.dark-mode .form-control::placeholder {
        color: #64748b;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary);
        outline: none;
        box-shadow: 0 0 0 3px rgba(74,100,145,0.2);
    }

    body.dark-mode .form-control:focus,
    body.dark-mode .form-select:focus {
        box-shadow: 0 0 0 3px rgba(74,100,145,0.3);
    }

    .form-select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%235f6368' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: left 14px center;
        padding-left: 36px;
        cursor: pointer;
    }

    .readonly-input {
        background: #f0f4f8 !important;
        color: #374151 !important;
        font-weight: 500;
        cursor: default;
        border-color: #d5dce4 !important;
    }

    body.dark-mode .readonly-input {
        background: #1a2332 !important;
        color: #cbd5e1 !important;
        border-color: #334155 !important;
    }

    /* Buttons */
    .btn-primary-custom {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.75rem 2rem;
        border-radius: 30px;
        transition: all 0.3s ease;
        font-size: 0.95rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        justify-content: center;
        cursor: pointer;
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(74, 100, 145, 0.4);
        color: white;
    }

    .btn-secondary-custom {
        background: #6b7280;
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.75rem 2rem;
        border-radius: 30px;
        transition: all 0.3s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-secondary-custom:hover {
        background: #4b5563;
        color: white;
    }

    .btn-sm-custom {
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .btn-view {
        background: linear-gradient(135deg, var(--info), #2563eb);
        color: white;
    }

    .btn-view:hover {
        transform: scale(1.05);
        box-shadow: 0 2px 8px rgba(59,130,246,0.4);
        color: white;
    }

    .btn-outline-sm {
        background: transparent;
        border: 1.5px solid #d1d5db;
        color: #374151;
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        font-family: inherit;
    }

    body.dark-mode .btn-outline-sm {
        border-color: #475569;
        color: #e2e8f0;
    }

    .btn-outline-sm:hover {
        background: #f9fafb;
        border-color: #9ca3af;
    }

    body.dark-mode .btn-outline-sm:hover {
        background: #334155;
    }

    .btn-delete-sm {
        background: none;
        border: none;
        color: var(--danger);
        cursor: pointer;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 0.85rem;
        transition: 0.2s;
    }

    .btn-delete-sm:hover {
        background: #fee2e2;
    }

    body.dark-mode .btn-delete-sm:hover {
        background: #7f1d1d;
    }

    /* Alert / Toast */
    .alert-custom {
        border-radius: 12px;
        padding: 1rem 1.2rem;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.8rem;
        animation: slideDown 0.3s ease-out;
    }

    .alert-success-custom {
        background: #d1fae5;
        color: #065f46;
        border-right: 4px solid var(--success);
    }

    body.dark-mode .alert-success-custom {
        background: #064e3b;
        color: #d1fae5;
    }

    .alert-error-custom {
        background: #fee2e2;
        color: #991b1b;
        border-right: 4px solid var(--danger);
    }

    body.dark-mode .alert-error-custom {
        background: #7f1d1d;
        color: #fee2e2;
        border-right-color: #ef4444;
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Toast */
    .toast {
        position: fixed;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%) translateY(100px);
        background: #1f2937;
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
    }
    .toast.show { transform: translateX(-50%) translateY(0); }
    .toast.success { background: #0d9488; }
    .toast.error { background: #ef4444; }

    /* Table Styles */
    .table-container {
        overflow-x: auto;
        border-radius: 0.75rem;
        border: 1px solid #e8eaed;
        max-height: 500px;
        overflow-y: auto;
    }

    body.dark-mode .table-container {
        border-color: #334155;
    }

    .summaries-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.82rem;
        white-space: nowrap;
    }

    .summaries-table thead {
        position: sticky;
        top: 0;
        z-index: 2;
    }

    .summaries-table th {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        font-weight: 600;
        padding: 12px 10px;
        text-align: center;
        border-bottom: 2px solid var(--primary-dark);
    }

    .summaries-table td {
        padding: 10px 10px;
        text-align: center;
        border-bottom: 1px solid #e2e8f0;
        color: #334155;
        vertical-align: middle;
    }

    body.dark-mode .summaries-table td {
        border-bottom: 1px solid #334155;
        color: #e2e8f0;
    }

    .summaries-table tbody tr {
        transition: background-color 0.2s ease;
    }

    .summaries-table tbody tr:hover {
        background-color: rgba(74, 100, 145, 0.05);
    }

    body.dark-mode .summaries-table tbody tr:hover {
        background-color: rgba(74, 100, 145, 0.1);
    }

    .empty-row td {
        color: #9ca3af;
        padding: 30px;
        text-align: center;
    }

    body.dark-mode .empty-row td {
        color: #64748b;
    }

    /* Badges */
    .badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 600;
    }
    .badge-balanced { background: #d1fae5; color: #065f46; }
    .badge-short { background: #fee2e2; color: #991b1b; }
    .badge-extra { background: #fef3c7; color: #92400e; }
    .badge-credit { background: #e0e7ff; color: #3730a3; }
    .badge-normal { background: #f3f4f6; color: #374151; }

    body.dark-mode .badge-balanced { background: #064e3b; color: #d1fae5; }
    body.dark-mode .badge-short { background: #7f1d1d; color: #fee2e2; }
    body.dark-mode .badge-extra { background: #78350f; color: #fef3c7; }
    body.dark-mode .badge-credit { background: #312e81; color: #c7d2fe; }
    body.dark-mode .badge-normal { background: #374151; color: #d1d5db; }

    /* Cashier Info Card */
    .cashier-info-card {
        background: linear-gradient(135deg, rgba(74, 100, 145, 0.05), rgba(93, 122, 176, 0.05));
        border-radius: 12px;
        padding: 1.2rem;
        border-right: 4px solid var(--primary);
        margin-bottom: 1rem;
    }

    body.dark-mode .cashier-info-card {
        background: linear-gradient(135deg, rgba(74, 100, 145, 0.1), rgba(93, 122, 176, 0.1));
    }

    .cashier-name-display {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--primary);
    }

    body.dark-mode .cashier-name-display {
        color: #94a3b8;
    }

    /* Loading Spinner */
    .loading-spinner {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 3px solid rgba(74,100,145,0.2);
        border-radius: 50%;
        border-top-color: var(--primary);
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Invoice Modal */
    .invoice-modal .modal-content {
        border-radius: 1rem;
        overflow: hidden;
    }

    .invoice-modal .modal-header {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
    }

    body.dark-mode .invoice-modal .modal-content {
        background-color: #1e293b;
        color: #e2e8f0;
    }

    body.dark-mode .invoice-modal .modal-body {
        color: #e2e8f0;
    }

    /* Totals Cards Styles */
    .totals-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .total-card {
        background: linear-gradient(135deg, #ffffff, #f8fafc);
        border-radius: 12px;
        padding: 1.2rem 1rem;
        text-align: center;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    body.dark-mode .total-card {
        background: linear-gradient(135deg, #1e293b, #334155);
        border-color: #475569;
    }

    .total-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
    }

    .total-card.sales::before { background: linear-gradient(90deg, #3b82f6, #2563eb); }
    .total-card.returns::before { background: linear-gradient(90deg, #ef4444, #dc2626); }
    .total-card.discount::before { background: linear-gradient(90deg, #f59e0b, #d97706); }
    .total-card.net-returns::before { background: linear-gradient(90deg, #8b5cf6, #7c3aed); }
    .total-card.profit::before { background: linear-gradient(90deg, #10b981, #059669); }
    .total-card.difference::before { background: linear-gradient(90deg, #06b6d4, #0891b2); }
    .total-card.details::before { background: linear-gradient(90deg, #f97316, #ea580c); }

    .total-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    body.dark-mode .total-card:hover {
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
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

    .total-card.sales .total-card-icon { background: linear-gradient(135deg, #3b82f6, #2563eb); }
    .total-card.returns .total-card-icon { background: linear-gradient(135deg, #ef4444, #dc2626); }
    .total-card.discount .total-card-icon { background: linear-gradient(135deg, #f59e0b, #d97706); }
    .total-card.net-returns .total-card-icon { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
    .total-card.profit .total-card-icon { background: linear-gradient(135deg, #10b981, #059669); }
    .total-card.difference .total-card-icon { background: linear-gradient(135deg, #06b6d4, #0891b2); }
    .total-card.details .total-card-icon { background: linear-gradient(135deg, #f97316, #ea580c); }

    .total-card-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: #64748b;
        margin-bottom: 0.4rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    body.dark-mode .total-card-label {
        color: #94a3b8;
    }

    .total-card-value {
        font-size: 1.3rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.2rem;
    }

    body.dark-mode .total-card-value {
        color: #f1f5f9;
    }

    .total-card-subtitle {
        font-size: 0.7rem;
        color: #94a3b8;
    }

    body.dark-mode .total-card-subtitle {
        color: #64748b;
    }

    /* Pagination Styles */
    .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 1.5rem;
        padding: 1rem 0 0.5rem;
        flex-wrap: wrap;
        gap: 1rem;
        border-top: 1px solid var(--border-color);
    }

    .pagination-controls {
        display: flex;
        gap: 8px;
        align-items: center;
        flex-wrap: wrap;
    }

    .pagination-btn {
        padding: 8px 14px;
        border: 1px solid var(--border-color);
        background: white;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 0.85rem;
        font-weight: 500;
        color: var(--text);
    }

    body.dark-mode .pagination-btn {
        background: #1e293b;
        border-color: #475569;
        color: #e2e8f0;
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
        background: var(--primary);
        border-color: var(--primary);
        color: white;
    }

    .page-info {
        font-size: 0.85rem;
        color: #64748b;
        padding: 5px 12px;
        background: var(--bg-light);
        border-radius: 20px;
    }

    body.dark-mode .page-info {
        background: #0f172a;
        color: #94a3b8;
    }

    .rows-per-page {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .rows-per-page select {
        padding: 6px 10px;
        border-radius: 8px;
        border: 1px solid var(--border-color);
        background: white;
        cursor: pointer;
    }

    body.dark-mode .rows-per-page select {
        background: #1e293b;
        color: #e2e8f0;
        border-color: #475569;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .summaries-table {
            font-size: 0.75rem;
        }
        
        .totals-grid {
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 0.75rem;
        }
        
        .total-card {
            padding: 1rem 0.75rem;
        }
        
        .total-card-value {
            font-size: 1.1rem;
        }

        .pagination-container {
            flex-direction: column;
            align-items: center;
        }
    }
</style>

<!-- Alert Container -->
<div id="alert-container" style="position: fixed; top: 20px; right: 20px; z-index: 9999; width: 350px;"></div>

<div class="container py-4">
    <!-- Page Header -->
    <div class="card shadow-sm mb-4 border-0 rounded-4 overflow-hidden">
        <div class="card-header form-header text-white text-center py-4">
            <div class="form-logo">
                <i class="fas fa-calculator"></i>
            </div>
            <h1 class="h2 mb-2">پوختەی حساباتی ڕۆژانە</h1>
            <p class="mb-0 opacity-75">کۆکردنەوە و تۆمارکردنی هەموو فرۆش و گەڕاوەکانی ڕۆژ</p>
        </div>
    </div>

    <!-- Cashier Selection Card -->
    <div class="form-card mb-4">
        <div class="section-title"><span class="dot"></span> هەڵبژاردنی کاشێر</div>
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label" for="cashierSelect">ناوی کاشێر <span class="required-star">*</span></label>
                <select class="form-select" id="cashierSelect">
                    <option value="">هەڵبژێرە...</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label" for="filterDate">بەروار</label>
                <input type="date" id="filterDate" class="form-control">
            </div>
            <div class="col-md-4">
                <button type="button" class="btn btn-primary-custom" id="loadCashierDataBtn" disabled>
                    <i class="fas fa-sync-alt me-2"></i> بارکردنی زانیاری کاشێر
                </button>
            </div>
        </div>
        
        <!-- Cashier Info Display -->
        <div id="cashierInfoContainer" style="display: none; margin-top: 1rem;"></div>
        
        <!-- Loading Indicator -->
        <div id="cashierLoading" style="display: none; text-align: center; padding: 1rem;">
            <div class="loading-spinner"></div>
            <span class="me-2">بارکردنی زانیاری کاشێر...</span>
        </div>
    </div>

    <!-- Table Card -->
    <div class="table-card">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
            <h3 style="font-size: 1rem; font-weight: 700; color: var(--text);">
                <i class="fas fa-table me-2"></i>تۆمارەکانی حساباتی ڕۆژانە
            </h3>
            <div class="filter-group" style="display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">
                <select id="filterStatus" class="form-select form-select-sm" style="width: auto; min-width: 140px;">
                    <option value="">هەموو ڕەوشەکان</option>
                    <option value="هاوسەنگ">هاوسەنگ</option>
                    <option value="کەم">کەم</option>
                    <option value="زیاد">زیاد</option>
                </select>
                <select id="filterSaleType" class="form-select form-select-sm" style="width: auto; min-width: 140px;">
                    <option value="">هەموو جۆرەکانی فرۆشتن</option>
                    <option value="فرۆشتنی قەرزە">فرۆشتنی قەرزە</option>
                    <option value="فرۆشتنی ئاسایی">فرۆشتنی ئاسایی</option>
                </select>
                <button class="btn btn-outline-sm" id="clearFilterBtn">
                    <i class="fas fa-times me-1"></i> پاککردنەوە
                </button>
            </div>
        </div>
        <div class="table-container">
            <table class="summaries-table" id="recordsTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>پسوڵە</th>
                        <th>جۆری فرۆشتن</th>
                        <th>فرۆش پێش داشکان</th>
                        <th>داشکاندن</th>
                        <th>کۆی فرۆش</th>
                        <th>قەرزەکان</th>
                        <th>قازانج</th>
                        <th>کردار</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <tr class="empty-row">
                        <td colspan="9">تکایە کاشێرێک هەڵبژێرە بۆ بینینی تۆمارەکان</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination Controls -->
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
        
        <p style="margin-top:10px; font-size:0.8rem; color:#6b7280;" id="recordCount">٠ تۆمار</p>
        
        <!-- Totals Cards Section -->
        <div id="totalsCardsContainer" style="display: none;">
            <div class="section-title mt-4">
                <span class="dot"></span> کۆی گشتی
            </div>
            <div class="totals-grid">
                <div class="total-card sales">
                    <div class="total-card-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="total-card-label">کۆی فرۆش</div>
                    <div class="total-card-value" id="cardTotalSales">٠</div>
                    <div class="total-card-subtitle">دیناری عێراقی</div>
                </div>
                
                <div class="total-card returns">
                    <div class="total-card-icon">
                        <i class="fas fa-undo-alt"></i>
                    </div>
                    <div class="total-card-label">کۆی گەڕاوە</div>
                    <div class="total-card-value" id="cardTotalReturns">٠</div>
                    <div class="total-card-subtitle">دیناری عێراقی</div>
                </div>
                
                <div class="total-card discount">
                    <div class="total-card-icon">
                        <i class="fas fa-tags"></i>
                    </div>
                    <div class="total-card-label">کۆی داشکاندن</div>
                    <div class="total-card-value" id="cardTotalDiscount">٠</div>
                    <div class="total-card-subtitle">دیناری عێراقی</div>
                </div>
                
                <div class="total-card net-returns">
                    <div class="total-card-icon">
                        <i class="fas fa-calculator"></i>
                    </div>
                    <div class="total-card-label">صافی گەڕاوە</div>
                    <div class="total-card-value" id="cardTotalNetReturns">٠</div>
                    <div class="total-card-subtitle">دیناری عێراقی</div>
                </div>
                
                <div class="total-card profit">
                    <div class="total-card-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="total-card-label">کۆی قازانج</div>
                    <div class="total-card-value" id="cardTotalProfit">٠</div>
                    <div class="total-card-subtitle">دیناری عێراقی</div>
                </div>
                
                <div class="total-card details">
                    <div class="total-card-icon">
                        <i class="fas fa-coins"></i>
                    </div>
                    <div class="total-card-label">کۆی وردە</div>
                    <div class="total-card-value" id="cardTotalDetails">٠</div>
                    <div class="total-card-subtitle">دیناری عێراقی</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Invoice Detail Modal -->
<div class="modal fade invoice-modal" id="invoiceDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-file-invoice me-2"></i> وردەکاری پسوڵە
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="invoiceDetailBody">
                <div class="text-center py-4">
                    <div class="loading-spinner"></div>
                    <span class="me-2 mt-2 d-block">بارکردنی زانیاری پسوڵە...</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i> داخستن
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Toast -->
<div class="toast" id="toast"></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    
    // ============================================
    // Variables
    // ============================================
    let currentCashierId = null;
    let currentCashierData = null;
    let allRecords = [];
    let filteredRecords = []; // Records after applying filters (but before pagination)
    let currentPage = 1;
    let rowsPerPage = 25;
    let invoiceModal = new bootstrap.Modal(document.getElementById('invoiceDetailModal'));
    
    // CSRF Token setup
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

    function showToast(msg, type = '') {
        const toast = $('#toast');
        clearTimeout(window.toastTimer);
        toast.text(msg);
        toast.attr('class', 'toast ' + type + ' show');
        window.toastTimer = setTimeout(() => toast.removeClass('show'), 2800);
    }

    function showAlert(type, title, message, duration = 4000) {
        let icon, alertClass;
        switch(type) {
            case 'success': icon = 'fas fa-check-circle'; alertClass = 'alert-success-custom'; break;
            case 'error': icon = 'fas fa-exclamation-circle'; alertClass = 'alert-error-custom'; break;
            default: icon = 'fas fa-info-circle'; alertClass = 'alert-success-custom';
        }
        const alertId = 'alert-' + Date.now();
        const alertHtml = `
            <div id="${alertId}" class="alert-custom ${alertClass}" style="background: white; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                <i class="${icon}" style="font-size: 1.3rem;"></i>
                <div style="flex: 1;">
                    <strong>${title}</strong><br>
                    <small>${message}</small>
                </div>
                <button class="btn-close" style="font-size: 0.7rem;" onclick="$('#${alertId}').fadeOut(300,function(){$(this).remove();})"></button>
            </div>
        `;
        $('#alert-container').prepend(alertHtml);
        if (duration > 0) setTimeout(() => $(`#${alertId}`).fadeOut(300, function(){ $(this).remove(); }), duration);
    }

    // ============================================
    // Calculate Totals (over all filtered records, not just current page)
    // ============================================
    
    function calculateTotals(records) {
        const totals = {
            totalSales: 0,
            totalReturns: 0,
            totalDiscount: 0,
            totalNetReturns: 0,
            totalProfit: 0,
            totalShortAmount: 0,
            totalExtraAmount: 0,
            totalDetails: 0,
            totalLoans: 0
        };
        
        if (!records || records.length === 0) {
            return totals;
        }
        
        records.forEach(function(rec) {
            totals.totalSales += parseFloat(rec.totalSales || rec.total_sales || 0);
            totals.totalReturns += parseFloat(rec.totalReturns || rec.total_returns || 0);
            totals.totalDiscount += parseFloat(rec.totalDiscount || rec.total_discount || 0);
            totals.totalNetReturns += parseFloat(rec.netReturns || rec.net_returns || 0);
            totals.totalProfit += parseFloat(rec.todayProfit || rec.profit || 0);
            totals.totalShortAmount += parseFloat(rec.shortAmount || 0);
            totals.totalExtraAmount += parseFloat(rec.extraAmount || 0);
            totals.totalDetails = parseFloat(rec.casherCoinAmount || rec.details || 0);
            totals.totalLoans += parseFloat(rec.totalLoans || 0);
        });
        
        return totals;
    }

    function updateTotalsCards(totals, recordCount) {
        const container = $('#totalsCardsContainer');
        const dateVal = $('#filterDate').val();
        
        // ئەگەر بەروار دیاری نەکرابێت، هەمووی سفر دەکەین
        if (!dateVal) {
            $('#cardTotalSales').text('٠');
            $('#cardTotalReturns').text('٠');
            $('#cardTotalDiscount').text('٠');
            $('#cardTotalNetReturns').text('٠');
            $('#cardTotalProfit').text('٠');
            $('#cardTotalDetails').text('٠');
            container.slideDown(300);
            return;
        }
        
        if (recordCount === 0) {
            $('#cardTotalSales').text('٠');
            $('#cardTotalReturns').text('٠');
            $('#cardTotalDiscount').text('٠');
            $('#cardTotalNetReturns').text('٠');
            $('#cardTotalProfit').text('٠');
            $('#cardTotalDetails').text('٠');
            container.slideDown(300);
            return;
        }
        
        // Update card values
        $('#cardTotalSales').text(formatNum(totals.totalSales));
        $('#cardTotalReturns').text(formatNum(totals.totalReturns));
        $('#cardTotalDiscount').text(formatNum(totals.totalDiscount));
        $('#cardTotalNetReturns').text(formatNum(totals.totalNetReturns));
        $('#cardTotalProfit').text(formatNum(totals.totalProfit));
        $('#cardTotalDetails').text(formatNum(totals.totalDetails));
        
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
        
        // Update page info
        $('#pageInfo').text(`لاپەڕە ${currentPage} لە ${totalPages}`);
        
        // Update button states
        $('#firstPageBtn').prop('disabled', currentPage === 1 || !hasRecords);
        $('#prevPageBtn').prop('disabled', currentPage === 1 || !hasRecords);
        $('#nextPageBtn').prop('disabled', currentPage === totalPages || !hasRecords);
        $('#lastPageBtn').prop('disabled', currentPage === totalPages || !hasRecords);
        
        // Show/hide pagination container
        if (filteredRecords.length > rowsPerPage) {
            $('#paginationContainer').show();
        } else {
            $('#paginationContainer').hide();
        }
    }
    
    function goToFirstPage() {
        if (currentPage !== 1) {
            currentPage = 1;
            renderCurrentPage();
        }
    }
    
    function goToPrevPage() {
        if (currentPage > 1) {
            currentPage--;
            renderCurrentPage();
        }
    }
    
    function goToNextPage() {
        const totalPages = Math.ceil(filteredRecords.length / rowsPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            renderCurrentPage();
        }
    }
    
    function goToLastPage() {
        const totalPages = Math.ceil(filteredRecords.length / rowsPerPage);
        if (currentPage !== totalPages && totalPages > 0) {
            currentPage = totalPages;
            renderCurrentPage();
        }
    }
    
    function renderCurrentPage() {
        const paginatedRecords = getPaginatedRecords();
        renderTable(paginatedRecords, filteredRecords.length);
        updatePaginationControls();
    }

    // ============================================
    // Load Cashiers from Route
    // ============================================
    
    function loadCashiers() {
        $.ajax({
            url: '{{ route("casher.getDataDetails") }}',
            type: 'GET',
            success: function(response) {
                console.log(response);
                const select = $('#cashierSelect');
                select.html('<option value="">هەڵبژێرە...</option>');
                
                if (response && response.users && response.users.length > 0) {
                    response.users.forEach(function(user) {
                        select.append(`<option value="${user.id}">${user.name}</option>`);
                    });
                } else if (response && Array.isArray(response)) {
                    response.forEach(function(user) {
                        select.append(`<option value="${user.id}">${user.name}</option>`);
                    });
                }
            },
            error: function(xhr) {
                console.error('Error loading cashiers:', xhr);
                showToast('هەڵە لە بارکردنی لیستی کاشێرەکان', 'error');
            }
        });
    }

    // Enable/disable load button based on selection
    $('#cashierSelect').on('change', function() {
        const cashierId = $(this).val();
        $('#loadCashierDataBtn').prop('disabled', !cashierId);
        
        // Hide previous cashier info if selection changes
        if (cashierId !== String(currentCashierId)) {
            $('#cashierInfoContainer').hide().html('');
            $('#tableBody').html('<tr class="empty-row"><td colspan="9">تکایە کلیکی "بارکردنی زانیاری کاشێر" بکە</td></tr>');
            $('#totalsCardsContainer').hide();
            $('#paginationContainer').hide();
            $('#recordCount').text('٠ تۆمار');
        }
    });

    // ============================================
    // Load Cashier Details
    // ============================================
    
    $('#loadCashierDataBtn').on('click', function() {
        const cashierId = $('#cashierSelect').val();
        if (!cashierId) {
            showToast('تکایە کاشێرێک هەڵبژێرە', 'error');
            return;
        }
        
        loadCashierDetails(cashierId);
    });

    function loadCashierDetails(cashierId) {
        currentCashierId = cashierId;
        
        // Reset pagination
        currentPage = 1;
        
        // Show loading
        $('#cashierLoading').show();
        $('#cashierInfoContainer').hide();
        $('#totalsCardsContainer').hide();
        $('#paginationContainer').hide();
        $('#loadCashierDataBtn').prop('disabled', true).html('<span class="loading-spinner"></span> بارکردن...');
        
        $.ajax({
            url: '/get-casher-details/' + cashierId,
            type: 'GET',
            success: function(response) {
                currentCashierData = response;
                displayCashierInfo(response);
                loadCashierInvoices(cashierId);
            },
            error: function(xhr) {
                console.error('Error loading cashier details:', xhr);
                showToast('هەڵە لە بارکردنی زانیاری کاشێر', 'error');
                $('#cashierLoading').hide();
                resetLoadButton();
            }
        });
    }

    function displayCashierInfo(data) {
        console.log('displayCashierInfo', data);
        const dateVal = $('#filterDate').val();
        const dateDisplay = dateVal ? dateVal : 'دیاری نەکراوە';
        
        let html = `
            <div class="cashier-info-card">
                <div class="row g-3">
                    <div class="col-md-3">
                        <small class="text-muted d-block">ناوی کاشێر</small>
                        <span class="cashier-name-display">${data.name || '---'}</span>
                    </div>
                    <div class="col-md-3">
                        <small class="text-muted d-block">بەروار</small>
                        <span class="cashier-name-display">
                            <i class="fas fa-calendar-alt me-1"></i> ${dateDisplay}
                        </span>
                    </div>
                    <div class="col-md-3">
                        <small class="text-muted d-block">کۆی فرۆشی ڕۆژ</small>
                        <span class="cashier-name-display">${formatNum(data.today_sales || 0)} د.ع</span>
                    </div>
                    <div class="col-md-3">
                        <small class="text-muted d-block">ژمارەی پسوڵەکان</small>
                        <span class="cashier-name-display">${data.invoice_count || 0} پسوڵە</span>
                    </div>
                </div>
            </div>
        `;
        $('#cashierInfoContainer').html(html).slideDown(300);
        $('#cashierLoading').hide();
        resetLoadButton();
    }

    function resetLoadButton() {
        $('#loadCashierDataBtn').prop('disabled', false).html('<i class="fas fa-sync-alt me-2"></i> بارکردنی زانیاری کاشێر');
    }

    // ============================================
    // Load Cashier Invoices
    // ============================================
    
    function loadCashierInvoices(cashierId) {
        $('#tableBody').html(`
            <tr class="empty-row">
                <td colspan="9">
                    <div class="loading-spinner"></div>
                    <span class="me-2">بارکردنی پسوڵەکان...</span>
                 </tr>
            </tr>
        `);
        $('#totalsCardsContainer').hide();
        $('#paginationContainer').hide();
        
        $.ajax({
            url: '/get-invoices/Details',
            type: 'GET',
            data: { cashier_id: cashierId },
            success: function(response) {
                if (response && response.invoices && response.invoices.length > 0) {
                    allRecords = response.invoices;
                    applyFilters();
                } else if (Array.isArray(response)) {
                    allRecords = response;
                    applyFilters();
                } else {
                    allRecords = [];
                    filteredRecords = [];
                    renderTable([], 0);
                    showToast('هیچ پسوڵەیەک نەدۆزرایەوە بۆ ئەم کاشێرە', '');
                }
            },
            error: function(xhr) {
                console.error('Error loading invoices:', xhr);
                allRecords = [];
                filteredRecords = [];
                $('#tableBody').html('<tr class="empty-row"><td colspan="9">هەڵە لە بارکردنی پسوڵەکان</td></tr>');
                $('#totalsCardsContainer').hide();
                $('#paginationContainer').hide();
                $('#recordCount').text('٠ تۆمار');
                showToast('هەڵە لە بارکردنی پسوڵەکان', 'error');
            }
        });
    }

    // ============================================
    // Render Table (with pagination support)
    // ============================================
    
    function renderTable(records, totalFilteredCount = null) {
        const tbody = $('#tableBody');
        tbody.empty();
        
        // Use passed total count or records length for display
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
            // Calculate global index for display (not just page index)
            const globalIndex = ((currentPage - 1) * rowsPerPage) + index + 1;
            
            // Determine sale type and badge
            const saleType = rec.saleType || (rec.isCreditSale ? 'فرۆشتنی قەرزە' : 'فرۆشتنی ئاسایی');
            const saleTypeBadge = rec.isCreditSale ? 'badge-credit' : 'badge-normal';
            const saleTypeIcon = rec.isCreditSale ? '📋' : '💰';
            
            // Loans info
            const totalLoans = rec.totalLoans || 0;
            const loanCount = rec.loanCount || 0;
            const loansInfo = totalLoans > 0 ? 
                `<span class="text-danger fw-bold">${formatNum(totalLoans)}</span>
                 <small class="d-block text-muted">${loanCount} قەرز</small>` : 
                '<span class="text-muted">---</span>';
            
            const row = `
                <tr>
                    <td>${globalIndex}</td>
                    <td>${rec.invoice_number || rec.date || '---'}</td>
                    <td>
                        <span class="badge ${saleTypeBadge}">
                            ${saleTypeIcon} ${saleType}
                        </span>
                     </td>
                    <td>${formatNum(rec.subtotal || '---')}</td>
                    <td>${formatNum(rec.totalDiscount || rec.total_discount || 0)}</td>
                    <td>${formatNum(rec.totalSales || rec.total_sales || 0)}</td>
                    <td>${loansInfo}</td>
                    <td><strong>${formatNum(rec.todayProfit || rec.profit || 0)}</strong></td>
                    <td>
                        <button class="btn-sm-custom btn-view view-invoice-btn" data-invoice-id="${rec.id || rec.invoice_id}" title="بینینی پسوڵە">
                            <i class="fas fa-eye"></i>
                        </button>
                     </td>
                 </tr>
            `;
            tbody.append(row);
        });
        
        $('#recordCount').text(`${displayTotal} تۆمار`);
        
        // Calculate and display totals in cards (using all filtered records, not just current page)
        const totals = calculateTotals(filteredRecords);
        updateTotalsCards(totals, filteredRecords.length);
        
        // Attach view invoice events
        $('.view-invoice-btn').off('click').on('click', function() {
            const invoiceId = $(this).data('invoice-id');
            viewInvoiceDetail(invoiceId);
        });
    }

    // ============================================
    // View Invoice Detail
    // ============================================
    
    function viewInvoiceDetail(invoiceId) {
        $('#invoiceDetailBody').html(`
            <div class="text-center py-4">
                <div class="loading-spinner"></div>
                <span class="me-2 mt-2 d-block">بارکردنی زانیاری پسوڵە...</span>
            </div>
        `);
        invoiceModal.show();
        
        // Find the invoice in allRecords to get loan details
        const record = allRecords.find(r => (r.id || r.invoice_id) == invoiceId);
        
        $.ajax({
            url: '/invoice/Details/' + invoiceId,
            type: 'GET',
            success: function(response) {
                const inv = response.invoice || response;
                
                // Build loans section if available
                let loansSection = '';
                if (record && record.loans && record.loans.length > 0) {
                    loansSection = `
                        <div class="col-12 mt-3">
                            <h6 class="mb-2">
                                <i class="fas fa-hand-holding-usd me-2 text-warning"></i>
                                قەرزەکانی ئەم پسوڵەیە (${record.loans.length} قەرز)
                            </h6>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>کۆ</th>
                                            <th>پارەی دراو</th>
                                            <th>پارەی ماوە</th>
                                            <th>کاتی گەڕانەوە</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${record.loans.map((loan, i) => `
                                        <tr>
                                            <td><strong>${formatNum(loan.total || 0)}</strong></td>
                                            <td>${loan.currency || '---'}</td>
                                            <td>${loan.period || '---'}</td>
                                            <td>${loan.time_to_return || '---'}</td>
                                         </tr>
                                        `).join('')}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    `;
                } else if (record && record.isCreditSale) {
                    loansSection = `
                        <div class="col-12 mt-3">
                            <div class="alert alert-warning">
                                <i class="fas fa-info-circle me-2"></i>
                                ئەم فرۆشتنە قەرزەیە بەڵام وردەکاری قەرزەکان بەردەست نییە
                            </div>
                        </div>
                    `;
                }
                
                let html = `
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="p-3 rounded-3 bg-light">
                                <strong>ژمارەی پسوڵە:</strong> #${inv.id || invoiceId}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded-3 bg-light">
                                <strong>بەروار:</strong> ${inv.date || inv.accountingDate || '---'}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded-3 bg-light">
                                <strong>کاشێر:</strong> ${inv.cashier_name || inv.cashierName || currentCashierData?.name || '---'}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded-3 bg-light">
                                <strong>جۆری فرۆشتن:</strong> 
                                <span class="badge ${record && record.isCreditSale ? 'badge-credit' : 'badge-normal'}">
                                    ${record ? (record.saleType || (record.isCreditSale ? 'فرۆشتنی قەرزە' : 'فرۆشتنی ئاسایی')) : '---'}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded-3 bg-light">
                                <strong>کۆی فرۆش:</strong> ${formatNum(inv.total_sales || inv.totalSales || 0)} د.ع
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded-3 bg-light">
                                <strong>گەڕاوە:</strong> ${formatNum(inv.total_returns || inv.totalReturns || 0)} د.ع
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded-3 bg-light">
                                <strong>داشکاندن:</strong> ${formatNum(inv.total_discount || inv.totalDiscount || 0)} د.ع
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded-3 bg-light">
                                <strong>قازانج:</strong> ${formatNum(inv.profit || inv.todayProfit || 0)} د.ع
                            </div>
                        </div>
                        ${record && record.totalLoans > 0 ? `
                        <div class="col-md-6">
                            <div class="p-3 rounded-3 bg-light">
                                <strong>کۆی قەرزەکان:</strong> 
                                <span class="text-danger">${formatNum(record.totalLoans)} د.ع</span>
                                <small class="d-block text-muted">${record.loanCount || 0} قەرز</small>
                            </div>
                        </div>
                        ` : ''}
                    
                        ${inv.items ? `
                        <div class="col-12">
                            <h6 class="mt-3 mb-2">کاڵاکانی پسوڵە:</h6>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ناوی کاڵا</th>
                                            <th>بڕ</th>
                                            <th>نرخ</th>
                                            <th>کۆ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${inv.items.map(item => `
                                        <tr>
                                            <td>${item.name || item.product_name || '---'}</td>
                                            <td>${item.quantity || 0}</td>
                                            <td>${formatNum(item.price || 0)}</td>
                                            <td>${formatNum((item.quantity || 0) * (item.price || 0))}</td>
                                         </tr>
                                        `).join('')}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        ` : ''}
                        ${loansSection}
                    </div>
                `;
                $('#invoiceDetailBody').html(html);
            },
            error: function(xhr) {
                console.error('Error loading invoice:', xhr);
                $('#invoiceDetailBody').html(`
                    <div class="text-center py-4 text-danger">
                        <i class="fas fa-exclamation-circle fa-2x mb-2 d-block"></i>
                        هەڵە لە بارکردنی وردەکاری پسوڵە
                    </div>
                `);
            }
        });
    }

    // ============================================
    // Filter Functions (with pagination reset)
    // ============================================
    
    function applyFilters() {
        const dateVal = $('#filterDate').val();
        const statusVal = $('#filterStatus').val();
        const saleTypeVal = $('#filterSaleType').val();
        
        let filtered = [...allRecords];
        
        if (dateVal) {
            filtered = filtered.filter(r => {
                const recDate = r.accountingDate || r.date || '';
                return recDate === dateVal;
            });
        }
        if (statusVal) {
            filtered = filtered.filter(r => {
                const recStatus = r.accountStatus || r.status || '';
                return recStatus === statusVal;
            });
        }
        if (saleTypeVal) {
            filtered = filtered.filter(r => {
                const recSaleType = r.saleType || (r.isCreditSale ? 'فرۆشتنی قەرزە' : 'فرۆشتنی ئاسایی');
                return recSaleType === saleTypeVal;
            });
        }
        
        filteredRecords = filtered;
        currentPage = 1; // Reset to first page when filters change
        
        // Check if we have records to show
        if (filteredRecords.length > 0) {
            renderCurrentPage();
        } else {
            renderTable([], 0);
            updatePaginationControls();
        }
        
        // Update cashier info display with current date
        if (currentCashierData) {
            displayCashierInfo(currentCashierData);
        }
    }
    
    $('#filterDate').on('change', applyFilters);
    $('#filterStatus').on('change', applyFilters);
    $('#filterSaleType').on('change', applyFilters);
    
    $('#clearFilterBtn').on('click', function() {
        $('#filterDate').val('');
        $('#filterStatus').val('');
        $('#filterSaleType').val('');
        applyFilters();
    });
    
    // ============================================
    // Rows per page change handler
    // ============================================
    
    $('#rowsPerPage').on('change', function() {
        rowsPerPage = parseInt($(this).val());
        currentPage = 1; // Reset to first page
        if (filteredRecords.length > 0) {
            renderCurrentPage();
        } else if (allRecords.length > 0) {
            // If no filters applied but allRecords exists, apply empty filter
            applyFilters();
        }
    });
    
    // ============================================
    // Pagination button event handlers
    // ============================================
    
    $('#firstPageBtn').on('click', goToFirstPage);
    $('#prevPageBtn').on('click', goToPrevPage);
    $('#nextPageBtn').on('click', goToNextPage);
    $('#lastPageBtn').on('click', goToLastPage);

    // ============================================
    // Initial Load
    // ============================================
    loadCashiers();
});
</script>
@endsection