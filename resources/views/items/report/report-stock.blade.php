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
        --card-bg: #ffffff;
    }

    body {
        background: #f1f5f9;
        font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
        transition: background-color 0.3s ease, color 0.2s ease;
        color: var(--text);
        font-size: 14px;
        overflow-x: hidden;
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

    .container {
        max-width: 100%;
        padding-left: 12px;
        padding-right: 12px;
    }

    .main-panel {
        background: var(--card-bg);
        border-radius: 1rem;
        box-shadow: 0 12px 30px rgba(0,0,0,0.08);
        overflow: hidden;
        margin-bottom: 1rem;
    }
    
    body.dark-mode .main-panel {
        background: var(--card-bg);
        box-shadow: 0 12px 30px rgba(0,0,0,0.3);
    }

    .form-header-custom {
        background: linear-gradient(135deg, var(--secondary), var(--primary-dark));
        border-radius: 16px;
        padding: 20px 16px;
        margin-bottom: 16px;
        text-align: center;
    }

    .form-logo-custom {
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

    .form-logo-custom i {
        font-size: 1.8rem;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    
    body.dark-mode .form-logo-custom {
        background-color: #334155;
    }
    body.dark-mode .form-logo-custom i {
        background: linear-gradient(135deg, #D8B4FE, #6c8db8);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .section-title-custom {
        font-size: 1rem;
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 0.8rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--secondary);
    }

    /* Form Controls */
    .form-control,
    .form-select {
        font-size: 14px;
        padding: 0.5rem 0.75rem;
        border-radius: 0.5rem;
    }

    body.dark-mode .form-control,
    body.dark-mode .form-select {
        background-color: #334155;
        color: #e2e8f0;
        border-color: var(--border-color);
    }

    body.dark-mode .form-control::placeholder {
        color: #94a3b8;
    }
    
    body.dark-mode .form-select option {
        background-color: #1e293b;
        color: #e2e8f0;
    }

    body.dark-mode .form-control:focus,
    body.dark-mode .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(108, 141, 184, 0.2);
    }

    .input-with-icon-custom {
        position: relative;
    }
    .input-with-icon-custom .form-control {
        padding-right: 2.5rem;
    }
    .input-with-icon-custom i {
        position: absolute;
        right: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--primary);
        z-index: 4;
    }

    /* Search Button */
    .btn-search-custom {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.6rem 1rem;
        border-radius: 40px;
        transition: 0.3s;
        width: 100%;
        font-size: 14px;
        white-space: nowrap;
    }
    .btn-search-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(74,100,145,0.4);
        color: white;
    }

    .btn-reset-custom {
        background-color: white;
        color: var(--primary);
        border: 2px solid var(--primary);
        border-radius: 40px;
        font-weight: 600;
        padding: 0.6rem 1rem;
        transition: 0.3s;
        width: 50%;
        font-size: 14px;
        white-space: nowrap;
    }
    body.dark-mode .btn-reset-custom {
        background-color: transparent;
        color: var(--primary);
        border-color: var(--primary);
    }
    .btn-reset-custom:hover {
        background-color: var(--primary);
        color: white;
    }

    /* Statistics Cards */
    .statistics-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
        margin-bottom: 16px;
    }

    .stat-card {
        background: var(--card-bg);
        border-radius: 0.75rem;
        padding: 1rem 0.5rem;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        border: 1px solid var(--border-color);
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    .stat-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.5rem;
        font-size: 1.1rem;
        color: white;
    }
    .stat-icon.total { background: linear-gradient(135deg, var(--primary), var(--secondary)); }
    .stat-icon.damage { background: linear-gradient(135deg, #f59e0b, #d97706); }
    .stat-icon.loss { background: linear-gradient(135deg, #ef4444, #dc2626); }
    .stat-icon.amount { background: linear-gradient(135deg, #10b981, #059669); }
    
    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 0.15rem;
        line-height: 1.2;
    }
    .stat-label {
        color: #6b7280;
        font-size: 0.75rem;
        font-weight: 500;
    }
    body.dark-mode .stat-label {
        color: #94a3b8;
    }

    /* Filter Grid */
    .filter-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
        align-items: end;
    }

    /* Table Styles - Full Responsive */
    .table-container {
        background: var(--card-bg);
        border-radius: 0.75rem;
        overflow-x: auto;
        border: 1px solid var(--border-color);
        -webkit-overflow-scrolling: touch;
    }
    
    .stock-table {
        width: 100%;
        min-width: 800px;
        border-collapse: collapse;
    }
    
    .stock-table thead th {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        font-weight: 600;
        padding: 0.625rem 0.5rem;
        font-size: 0.75rem;
        border: none;
        white-space: nowrap;
        text-align: center;
        position: sticky;
        top: 0;
        z-index: 10;
    }
    
    .stock-table tbody td {
        padding: 0.5rem 0.5rem;
        vertical-align: middle;
        border-bottom: 1px solid var(--border-color);
        font-size: 0.8rem;
        color: var(--text);
        text-align: center;
        white-space: nowrap;
    }
    
    .stock-table tbody tr {
        transition: background-color 0.2s ease;
    }
    
    .stock-table tbody tr:nth-child(even) {
        background-color: var(--bg-light);
    }
    
    .stock-table tbody tr:hover {
        background-color: #fef9e3 !important;
    }
    body.dark-mode .stock-table tbody tr:hover {
        background-color: #334155 !important;
    }

    /* Reason Badges */
    .reason-badge {
        display: inline-block;
        padding: 0.15rem 0.5rem;
        border-radius: 2rem;
        font-size: 0.7rem;
        font-weight: 600;
        white-space: nowrap;
    }
    .reason-damage { background: #fee2e2; color: #991b1b; }
    .reason-defect { background: #fef3c7; color: #92400e; }
    .reason-shop { background: #dbeafe; color: #1e40af; }
    .reason-other { background: #e0e7ff; color: #3730a3; }
    
    body.dark-mode .reason-damage { background: #7f1d1d; color: #fecaca; }
    body.dark-mode .reason-defect { background: #78350f; color: #fde68a; }
    body.dark-mode .reason-shop { background: #1e3a5f; color: #bfdbfe; }
    body.dark-mode .reason-other { background: #312e81; color: #c7d2fe; }

    /* Pagination */
    .pagination-container {
        margin-top: 0.75rem;
        display: flex;
        justify-content: center;
        overflow-x: auto;
    }
    .pagination {
        gap: 3px;
        flex-wrap: wrap;
        justify-content: center;
    }
    .page-link {
        border-radius: 6px !important;
        color: var(--primary);
        border: 1px solid #dee2e6;
        padding: 0.4rem 0.6rem;
        font-size: 0.8rem;
    }
    body.dark-mode .page-link {
        background-color: #334155;
        color: #e2e8f0;
        border-color: #475569;
    }
    .page-item.active .page-link {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border-color: var(--primary);
        color: white;
    }
    body.dark-mode .page-item.active .page-link {
        background: linear-gradient(135deg, #6c8db8, #5d7ab0);
    }

    /* Alert */
    .alert-container {
        position: fixed;
        top: 10px;
        right: 10px;
        z-index: 9999;
        width: auto;
        max-width: 350px;
    }
    .custom-alert {
        border-radius: 12px;
        padding: 0.75rem 1rem;
        margin-bottom: 0.5rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        border-right: 4px solid;
        animation: slideInRight 0.25s ease-out;
        display: flex;
        align-items: center;
        gap: 10px;
        text-align: right;
        font-size: 0.85rem;
    }
    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(30px);}
        to { opacity: 1; transform: translateX(0);}
    }
    .alert-success-custom { background: #dcfce7; border-right-color: var(--success); color: #166534; }
    .alert-error-custom { background: #fee2e2; border-right-color: var(--danger); color: #991b1b; }
    .alert-warning-custom { background: #fff3e3; border-right-color: var(--warning); color: #9a3412; }

    /* Barcode Scanner */
    .search-input-wrapper {
        position: relative;
    }
    .search-input-wrapper .form-control {
        padding-left: 42px;
    }
    .camera-search-btn {
        position: absolute;
        left: 8px;
        top: 50%;
        transform: translateY(-50%);
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border: none;
        color: white;
        width: 28px;
        height: 28px;
        border-radius: 6px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 5;
        font-size: 0.75rem;
    }
    .camera-search-btn:hover {
        transform: translateY(-50%) scale(1.05);
    }

    .scanner-modal .modal-content {
        background: #000;
        border-radius: 0.75rem;
        overflow: hidden;
    }
    .scanner-modal .modal-header {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        border-bottom: none;
        padding: 0.75rem 1rem;
    }
    .scanner-modal .btn-close {
        filter: invert(1);
    }
    #qr-reader {
        width: 100%;
        max-width: 100%;
        border-radius: 0;
        overflow: hidden;
    }
    #qr-reader video {
        width: 100% !important;
        min-height: 250px;
        object-fit: cover;
    }

    /* Print */
    @media print {
        .no-print { display: none !important; }
        .stock-table thead th {
            background: #4a6491 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        body, body.dark-mode { background: white; color: black; }
        .stock-table tbody td { color: black !important; }
        .table-container { overflow-x: visible; }
        .stock-table { min-width: 100%; }
        .statistics-row { grid-template-columns: repeat(4, 1fr); }
    }

    /* ==================== RESPONSIVE BREAKPOINTS ==================== */

    /* XX-Large (2xl - 1400px+) */
    @media (min-width: 1400px) {
        .container {
            max-width: 1320px;
        }
        .stock-table {
            min-width: 100%;
        }
        .stock-table thead th {
            font-size: 0.85rem;
            padding: 0.75rem 0.75rem;
        }
        .stock-table tbody td {
            font-size: 0.85rem;
            padding: 0.625rem 0.75rem;
        }
        .stat-value {
            font-size: 1.75rem;
        }
        .stat-icon {
            width: 48px;
            height: 48px;
            font-size: 1.3rem;
        }
    }

    /* Large (lg - 992px to 1199px) */
    @media (max-width: 1199px) {
        .container {
            max-width: 960px;
        }
        .filter-grid {
            grid-template-columns: repeat(3, 1fr);
        }
        .stock-table {
            min-width: 750px;
        }
    }

    /* Medium (md - 768px to 991px) */
    @media (max-width: 991px) {
        .container {
            max-width: 720px;
            padding-left: 8px;
            padding-right: 8px;
        }
        .statistics-row {
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }
        .filter-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }
        .form-header-custom {
            padding: 16px 12px;
        }
        .form-header-custom h1 {
            font-size: 1.3rem;
        }
        .form-header-custom p {
            font-size: 0.85rem;
        }
        .stock-table {
            min-width: 650px;
        }
        .stock-table thead th {
            font-size: 0.7rem;
            padding: 0.5rem 0.4rem;
        }
        .stock-table tbody td {
            font-size: 0.7rem;
            padding: 0.4rem 0.4rem;
        }
        .btn-search-custom,
        .btn-reset-custom {
            font-size: 0.8rem;
            padding: 0.5rem 0.75rem;
        }
        .stat-value {
            font-size: 1.3rem;
        }
        .stat-icon {
            width: 35px;
            height: 35px;
            font-size: 0.9rem;
        }
    }

    /* Small (sm - 576px to 767px) */
    @media (max-width: 767px) {
        .container {
            max-width: 100%;
            padding-left: 6px;
            padding-right: 6px;
        }
        .statistics-row {
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
        }
        .filter-grid {
            grid-template-columns: 1fr;
            gap: 8px;
        }
        .form-header-custom {
            padding: 14px 10px;
            border-radius: 12px;
        }
        .form-header-custom h1 {
            font-size: 1.1rem;
        }
        .form-header-custom p {
            font-size: 0.75rem;
        }
        .form-logo-custom {
            width: 50px;
            height: 50px;
        }
        .form-logo-custom i {
            font-size: 1.5rem;
        }
        .main-panel {
            padding: 12px !important;
            border-radius: 0.75rem;
        }
        .section-title-custom {
            font-size: 0.9rem;
        }
        .stock-table {
            min-width: 600px;
        }
        .stock-table thead th {
            font-size: 0.65rem;
            padding: 0.4rem 0.3rem;
        }
        .stock-table tbody td {
            font-size: 0.65rem;
            padding: 0.35rem 0.3rem;
        }
        .stat-card {
            padding: 0.75rem 0.5rem;
        }
        .stat-value {
            font-size: 1.2rem;
        }
        .stat-label {
            font-size: 0.65rem;
        }
        .stat-icon {
            width: 32px;
            height: 32px;
            font-size: 0.85rem;
        }
        .btn-search-custom,
        .btn-reset-custom {
            font-size: 0.8rem;
            padding: 0.5rem;
            border-radius: 30px;
        }
        .form-control,
        .form-select {
            font-size: 13px;
            padding: 0.45rem 0.65rem;
        }
        .alert-container {
            left: 8px;
            right: 8px;
            max-width: 100%;
        }
        .custom-alert {
            font-size: 0.75rem;
            padding: 0.6rem 0.75rem;
        }
        .pagination {
            gap: 2px;
        }
        .page-link {
            padding: 0.3rem 0.5rem;
            font-size: 0.7rem;
        }
        #qr-reader video {
            min-height: 200px;
        }
    }

    /* Extra Small (xs - under 576px) */
    @media (max-width: 575px) {
        .container {
            padding-left: 4px;
            padding-right: 4px;
        }
        .statistics-row {
            grid-template-columns: 1fr 1fr;
            gap: 6px;
        }
        .filter-grid {
            grid-template-columns: 1fr;
            gap: 6px;
        }
        .form-header-custom {
            padding: 12px 8px;
            border-radius: 10px;
        }
        .form-header-custom h1 {
            font-size: 1rem;
        }
        .form-header-custom p {
            font-size: 0.7rem;
        }
        .form-logo-custom {
            width: 45px;
            height: 45px;
            border-radius: 12px;
        }
        .form-logo-custom i {
            font-size: 1.3rem;
        }
        .main-panel {
            padding: 8px !important;
            border-radius: 0.6rem;
        }
        .section-title-custom {
            font-size: 0.85rem;
            margin-bottom: 0.6rem;
        }
        .stock-table {
            min-width: 550px;
        }
        .stock-table thead th {
            font-size: 0.6rem;
            padding: 0.3rem 0.25rem;
        }
        .stock-table tbody td {
            font-size: 0.6rem;
            padding: 0.3rem 0.25rem;
        }
        .stat-card {
            padding: 0.6rem 0.4rem;
            border-radius: 0.5rem;
        }
        .stat-value {
            font-size: 1.1rem;
        }
        .stat-label {
            font-size: 0.6rem;
        }
        .stat-icon {
            width: 28px;
            height: 28px;
            font-size: 0.75rem;
            margin-bottom: 0.3rem;
        }
        .btn-search-custom,
        .btn-reset-custom {
            font-size: 0.75rem;
            padding: 0.45rem;
            border-radius: 25px;
        }
        .form-control,
        .form-select {
            font-size: 12px;
            padding: 0.4rem 0.6rem;
            border-radius: 0.4rem;
        }
        .form-label {
            font-size: 0.75rem;
            margin-bottom: 0.25rem;
        }
        .reason-badge {
            font-size: 0.6rem;
            padding: 0.1rem 0.4rem;
        }
        .camera-search-btn {
            width: 24px;
            height: 24px;
            font-size: 0.65rem;
            left: 6px;
        }
        .search-input-wrapper .form-control {
            padding-left: 36px;
        }
        .alert-container {
            top: 5px;
            left: 4px;
            right: 4px;
        }
        .custom-alert {
            font-size: 0.7rem;
            padding: 0.5rem 0.6rem;
            border-radius: 8px;
        }
        .pagination-container {
            margin-top: 0.5rem;
        }
        .page-link {
            padding: 0.25rem 0.4rem;
            font-size: 0.65rem;
            border-radius: 4px !important;
        }
        #qr-reader video {
            min-height: 180px;
        }
        .scanner-modal .modal-header {
            padding: 0.5rem 0.75rem;
        }
        .scanner-modal .modal-title {
            font-size: 0.9rem;
        }
        .d-flex.justify-content-between.align-items-center {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 0.5rem;
        }
        #result-count {
            align-self: flex-end;
        }
    }
</style>

<div class="container py-4">
    <!-- Header -->
    <div class="form-header-custom text-white text-center py-3 mb-3">
        <div class="form-logo-custom">
            <i class="fas fa-chart-bar"></i>
        </div>
        <h1 class="h2 mb-2">ڕاپۆرتی کاڵاکانی ستۆکبوون</h1>
        <p class="mb-0 opacity-75">نیشاندانی کاڵاکانی ستۆكبوون و خەسارەتیان</p>
    </div>

    <!-- Alert Container -->
    <div id="alert-container" class="alert-container"></div>

    <!-- Statistics Cards -->
    <div class="statistics-row">
        <div class="stat-card">
            <div class="stat-icon total"><i class="fas fa-boxes"></i></div>
            <div class="stat-value" id="stat-total-items">0</div>
            <div class="stat-label">کۆی گشتی کاڵاکان</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon amount"><i class="fas fa-cubes"></i></div>
            <div class="stat-value" id="stat-total-quantity">0</div>
            <div class="stat-label">کۆی بڕی ستۆکبوو</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon loss"><i class="fas fa-money-bill-wave"></i></div>
            <div class="stat-value" id="stat-total-cost">0</div>
            <div class="stat-label">کۆی خەسارەت (IQD)</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon damage"><i class="fas fa-exclamation-triangle"></i></div>
            <div class="stat-value" id="stat-reason-count">0</div>
            <div class="stat-label">هۆکاری جیاواز</div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="main-panel p-3 p-md-4 mb-3 no-print">
        <h5 class="section-title-custom"><i class="fas fa-search me-2"></i>گەڕان بۆ کاڵا</h5>
        <div class="filter-grid">
            <div>
                <label class="form-label fw-semibold">لەبەرواری</label>
                <div class="input-with-icon-custom">
                    <i class="fas fa-calendar-alt"></i>
                    <input type="date" id="filter-date-from" class="form-control">
                </div>
            </div>
            <div>
                <label class="form-label fw-semibold">تا بەرواری</label>
                <div class="input-with-icon-custom">
                    <i class="fas fa-calendar-alt"></i>
                    <input type="date" id="filter-date-to" class="form-control">
                </div>
            </div>
            <div>
                <label class="form-label fw-semibold">بارکۆد</label>
                <div class="search-input-wrapper">
                    <input type="text" id="filter-barcode" class="form-control" placeholder="ژمارەی بارکۆد بنووسە">
                    <button type="button" class="camera-search-btn" id="filter-camera-btn" title="سکانکردنی بارکۆد">
                        <i class="fas fa-camera"></i>
                    </button>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="button" class="btn-search-custom flex-grow-1" id="btn-search">
                    <i class="fas fa-search me-1"></i> گەڕان
                </button>
                <button type="button" class="btn-reset-custom flex-shrink-0" id="btn-reset">
                    <i class="fas fa-undo-alt"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Stock Table -->
    <div class="main-panel p-3 p-md-4">
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
            <h5 class="section-title-custom mb-0"><i class="fas fa-list me-2"></i>لیستی کاڵا ستۆکبووەکان</h5>
            <span class="text-muted small" id="result-count">٠ ئەنجام</span>
        </div>
        <div class="table-container">
            <table class="stock-table">
                <thead>
                    <tr>
                        <th>ژمارە</th>
                        <th>ناوی کاڵا</th>
                        <th>بارکۆد</th>
                        <th>عدد</th>
                        <th>نرخی کڕین (تاک)</th>
                        <th>کۆی کڕین</th>
                        <th>هۆکاری ستۆكبوون</th>
                        <th>تێبینی</th>
                        <th>بەکارهێنەر</th>
                        <th>بەروار</th>
                    </tr>
                </thead>
                <tbody id="stock-tbody">
                    <tr><td colspan="10" class="text-center py-5 text-muted"><div class="spinner-border text-primary spinner-border-sm"></div> بارکردن...</td></tr>
                </tbody>
            </table>
        </div>
        <div id="pagination-container" class="pagination-container mt-3"></div>
    </div>
</div>

<!-- Barcode Scanner Modal -->
<div class="modal fade scanner-modal" id="barcodeScannerModal" tabindex="-1" data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-camera ms-2"></i>سکانکردنی بارکۆد</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0" style="min-height: 300px; background: #000;">
                <div id="qr-reader" style="width: 100%;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                    <i class="fas fa-times ms-1"></i>داخستن
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

<script>
$(document).ready(function(){
    let currentPage = 1;
    let html5QrCode = null;
    let barcodeScannerModal = null;
    
    // Initialize modal
    barcodeScannerModal = new bootstrap.Modal(document.getElementById('barcodeScannerModal'));
    
    // ==================== NUMBER NORMALIZATION ====================
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
    
    // ==================== HELPER FUNCTIONS ====================
    function escapeHtml(str) {
        if(!str) return '';
        return String(str).replace(/[&<>]/g, function(m) {
            if(m === '&') return '&amp;';
            if(m === '<') return '&lt;';
            if(m === '>') return '&gt;';
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
                        <i class="fas ${icon} fa-lg"></i>
                        <div class="flex-grow-1"><strong>${title}</strong><br><small>${message}</small></div>
                        <button class="btn-close btn-close-sm ms-2" onclick="$('#${alertId}').remove()" style="font-size:0.6rem;"></button>
                      </div>`;
        $('#alert-container').prepend(html);
        setTimeout(() => $(`#${alertId}`).fadeOut(300, function(){ $(this).remove(); }), duration);
    }
    
    function getReasonBadgeClass(reason) {
        if (!reason) return 'reason-other';
        const r = reason.toLowerCase();
        if (r.includes('شکان')) return 'reason-damage';
        if (r.includes('تێکچون')) return 'reason-defect';
        if (r.includes('دوکان') || r.includes('بەکار')) return 'reason-shop';
        return 'reason-other';
    }
    
    // ==================== SCANNER FUNCTIONS ====================
    async function startBarcodeScanner() {
        await stopBarcodeScanner();
        const qrReader = document.getElementById('qr-reader');
        if (!qrReader) return;
        
        if (html5QrCode) {
            try {
                if (html5QrCode.isScanning) await html5QrCode.stop();
                await html5QrCode.clear();
            } catch(e) {
                console.error('Error stopping scanner:', e);
            }
        }
        
        html5QrCode = new Html5Qrcode("qr-reader");
        const config = { 
            fps: 10, 
            qrbox: function(viewfinderWidth, viewfinderHeight) {
                let minEdge = Math.min(viewfinderWidth, viewfinderHeight) * 0.7;
                return { width: minEdge, height: minEdge };
            },
            aspectRatio: 1.0 
        };
        
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
                        showAlert('success', 'سەرکەوتوو', 'بارکۆد سکان کرا: ' + normalizedBarcode);
                        loadStockReport();
                    }
                },
                (errorMessage) => {
                    // Silently handle scanning errors
                }
            );
        } catch (err) {
            console.error('Scanner error:', err);
            showAlert('error', 'هەڵەی کامێرا', 'ناتوانرێت کامێرا بۆ سکانکردن بکرێتەوە');
            barcodeScannerModal.hide();
        }
    }
    
    async function stopBarcodeScanner() {
        if (html5QrCode && html5QrCode.isScanning) {
            try {
                await html5QrCode.stop();
                await html5QrCode.clear();
            } catch(e) {
                console.error('Error stopping scanner:', e);
            }
        }
    }
    
    // ==================== LOAD STOCK REPORT ====================
    function loadStockReport(page = 1) {
        currentPage = page;
        $('#stock-tbody').html('<tr><td colspan="10" class="text-center py-4"><div class="spinner-border text-primary spinner-border-sm"></div> بارکردن...</td></tr>');
        
        const dateFrom = $('#filter-date-from').val();
        const dateTo = $('#filter-date-to').val();
        const barcode = normalizeToEnglishNumbers($('#filter-barcode').val().trim());
        
        $.ajax({
            url: '{{ route("stock-products.report") }}',
            method: 'GET',
            data: {
                date_from: dateFrom,
                date_to: dateTo,
                barcode: barcode,
                page: page
            },
            success: function(response) {
                if (response.success) {
                    renderStockTable(response.data || []);
                    renderPagination(response);
                    updateStatistics(response);
                    $('#result-count').text(response.total_items > 0 ? 
                        `نیشاندانی ${response.from || 0} - ${response.to || 0} لە کۆی ${response.total_items} ئەنجام` : 
                        '٠ ئەنجام');
                } else {
                    console.error('Error response:', response);
                    renderEmptyTable();
                    $('#result-count').text('٠ ئەنجام');
                    updateStatistics({ total: 0, total_quantity: 0, total_cost: 0, unique_reasons: 0 });
                    showAlert('error', 'هەڵە', response.message || 'هەڵەیەک ڕوویدا');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
                console.error('Response:', xhr.responseText);
                renderEmptyTable();
                $('#result-count').text('٠ ئەنجام');
                updateStatistics({ total: 0, total_quantity: 0, total_cost: 0, unique_reasons: 0 });
                
                let errorMessage = 'هەڵەی پەیوەندی بە سێرڤەرەوە';
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.message) {
                        errorMessage = response.message;
                    }
                } catch(e) {}
                
                showAlert('error', 'هەڵە', errorMessage);
            }
        });
    }
    
    function renderEmptyTable() {
        $('#stock-tbody').html('<tr><td colspan="10" class="text-center py-5 text-muted">هیچ کاڵایەکی ستۆکبوو نەدۆزرایەوە</td></tr>');
    }
    
    function renderStockTable(items) {
        const tbody = $('#stock-tbody');
        if (!items || !items.length) {
            renderEmptyTable();
            return;
        }
        
        let html = '';
        items.forEach((item, index) => {
            const rowNumber = (currentPage - 1) * 15 + index + 1;
            const productName = item.product_name || 'بێ ناو';
            const barcode = item.barcode || '-';
            const quantity = item.amount || 0;
            const purchasePrice = parseFloat(item.purchase_price || 0);
            const totalCost = quantity * purchasePrice;
            const reason = item.stock_reason || 'دیاری نەکراو';
            const notes = item.notes || '-';
            const userName = item.user_name || 'نەناسراو';
            
            let date = '-';
            if (item.entry_date) {
                try {
                    date = new Date(item.entry_date).toLocaleDateString('ku');
                } catch(e) {
                    date = item.entry_date;
                }
            }
            
            const reasonClass = getReasonBadgeClass(reason);
            
            html += `<tr>
                <td>${rowNumber}</td>
                <td class="fw-bold">${escapeHtml(productName)}</td>
                <td><small>${escapeHtml(barcode)}</small></td>
                <td><strong>${quantity}</strong></td>
                <td>${formatPrice(purchasePrice)} IQD</td>
                <td><strong class="text-danger">${formatPrice(totalCost)} IQD</strong></td>
                <td><span class="reason-badge ${reasonClass}">${escapeHtml(reason)}</span></td>
                <td><small>${escapeHtml(notes)}</small></td>
                <td><small><i class="fas fa-user me-1"></i>${escapeHtml(userName)}</small></td>
                <td><small>${date}</small></td>
            </tr>`;
        });
        tbody.html(html);
    }
    
    function renderPagination(response) {
        if (!response || response.last_page <= 1) {
            $('#pagination-container').empty();
            return;
        }
        
        let paginationHtml = '<ul class="pagination">';
        
        if (response.current_page > 1) {
            paginationHtml += `<li class="page-item"><a class="page-link" href="#" data-page="${response.current_page - 1}">&laquo;</a></li>`;
        } else {
            paginationHtml += `<li class="page-item disabled"><span class="page-link">&laquo;</span></li>`;
        }
        
        let startPage = Math.max(1, response.current_page - 2);
        let endPage = Math.min(response.last_page, response.current_page + 2);
        
        if (startPage > 1) {
            paginationHtml += `<li class="page-item"><a class="page-link" href="#" data-page="1">1</a></li>`;
            if (startPage > 2) paginationHtml += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
        }
        
        for (let i = startPage; i <= endPage; i++) {
            if (i === response.current_page) {
                paginationHtml += `<li class="page-item active"><span class="page-link">${i}</span></li>`;
            } else {
                paginationHtml += `<li class="page-item"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`;
            }
        }
        
        if (endPage < response.last_page) {
            if (endPage < response.last_page - 1) paginationHtml += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
            paginationHtml += `<li class="page-item"><a class="page-link" href="#" data-page="${response.last_page}">${response.last_page}</a></li>`;
        }
        
        if (response.current_page < response.last_page) {
            paginationHtml += `<li class="page-item"><a class="page-link" href="#" data-page="${response.current_page + 1}">&raquo;</a></li>`;
        } else {
            paginationHtml += `<li class="page-item disabled"><span class="page-link">&raquo;</span></li>`;
        }
        paginationHtml += '</ul>';
        
        $('#pagination-container').html(paginationHtml);
        $('#pagination-container .page-link[data-page]').click(function(e) {
            e.preventDefault();
            const page = $(this).data('page');
            loadStockReport(page);
            $('html, body').animate({ scrollTop: $('.stock-table').offset().top - 100 }, 300);
        });
    }
    
    function updateStatistics(response) {
        $('#stat-total-items').text(formatPrice(response.total || 0));
        $('#stat-total-quantity').text(formatPrice(response.total_quantity || 0));
        $('#stat-total-cost').text(formatPrice(response.total_cost || 0));
        $('#stat-reason-count').text(response.unique_reasons || 0);
    }
    
    // ==================== SET DEFAULT DATES ====================
    function setDefaultDates() {
        const today = new Date();
        const thirtyDaysAgo = new Date();
        thirtyDaysAgo.setDate(today.getDate() - 30);
        
        $('#filter-date-from').val(thirtyDaysAgo.toISOString().split('T')[0]);
        $('#filter-date-to').val(today.toISOString().split('T')[0]);
    }
    
    // ==================== EVENT LISTENERS ====================
    $('#btn-search').on('click', function() {
        loadStockReport(1);
    });
    
    $('#btn-reset').on('click', function() {
        $('#filter-barcode').val('');
        setDefaultDates();
        loadStockReport(1);
    });
    
    $('#filter-barcode').on('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            loadStockReport(1);
        }
    });
    
    $('#filter-camera-btn').on('click', function() {
        barcodeScannerModal.show();
    });
    
    $('#barcodeScannerModal').on('shown.bs.modal', function() {
        startBarcodeScanner();
    });
    
    $('#barcodeScannerModal').on('hidden.bs.modal', function() {
        stopBarcodeScanner();
    });
    
    // Handle window resize for scanner
    $(window).on('resize', function() {
        if ($('#barcodeScannerModal').hasClass('show') && html5QrCode && html5QrCode.isScanning) {
            startBarcodeScanner();
        }
    });
    
    // ==================== INITIALIZE ====================
    setDefaultDates();
    loadStockReport();
});
</script>
@endsection