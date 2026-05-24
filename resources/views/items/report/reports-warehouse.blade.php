@extends('layouts.navigation')

@section('content')
<style>
    :root {
        --primary: #4a6491;
        --primary-light: #5d7ab0;
        --secondary: #2c3e50;
        --accent: #C084FC;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --info: #3b82f6;
        --text: #1e293b;
        --text-light: #6b7280;
        --bg-white: #ffffff;
        --bg-light: #f8fafc;
        --border: #e2e8f0;
        --shadow: rgba(0, 0, 0, 0.08);
        --card-bg: #ffffff;
        --table-hover: #f8fafc;
        --modal-bg: #ffffff;
        --table-header-bg: linear-gradient(135deg, #4a6491, #2c3e50);
        --table-row-bg: #ffffff;
        --table-row-alt-bg: #f8fafc;
    }

    /* Dark Mode Variables */
    body.dark-mode {
        --primary: #6c8db8;
        --primary-light: #5d7ab0;
        --secondary: #1a2a3a;
        --accent: #D8B4FE;
        --success: #34d399;
        --warning: #fbbf24;
        --danger: #f87171;
        --info: #60a5fa;
        --text: #e2e8f0;
        --text-light: #94a3b8;
        --bg-white: #1e293b;
        --bg-light: #0f172a;
        --border: #334155;
        --shadow: rgba(0, 0, 0, 0.3);
        --card-bg: #1e293b;
        --table-hover: #334155;
        --modal-bg: #1e293b;
        --table-header-bg: linear-gradient(135deg, #1e293b, #0f172a);
        --table-row-bg: #1e293b;
        --table-row-alt-bg: #162236;
    }

    body {
        background: var(--bg-light);
        font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
        transition: background-color 0.3s ease, color 0.3s ease;
        color: var(--text);
    }

    /* Dark Mode Toggle Button */
   

    .report-header {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border-radius: 1rem 1rem 0 0 !important;
        padding: 1.5rem 2rem;
        transition: all 0.3s ease;
    }
    
    @media (max-width: 768px) {
        .report-header {
            padding: 1rem 1.25rem;
        }
        .report-header h2 {
            font-size: 1.25rem;
        }
        .report-header p {
            font-size: 0.8rem;
        }
    }

    .stat-card {
        background: var(--card-bg);
        border-radius: 1rem;
        padding: 1.25rem;
        text-align: center;
        box-shadow: 0 4px 15px var(--shadow);
        transition: all 0.3s ease;
        border: 1px solid var(--border);
        height: 100%;
    }
    
    @media (max-width: 768px) {
        .stat-card {
            padding: 0.75rem;
        }
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px var(--shadow);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.75rem;
        font-size: 1.5rem;
    }
    
    @media (max-width: 768px) {
        .stat-icon {
            width: 40px;
            height: 40px;
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
        }
    }

    .stat-icon.products { background: linear-gradient(135deg, var(--primary), var(--accent)); color: white; }
    .stat-icon.purchase { background: linear-gradient(135deg, #f59e0b, #d97706); color: white; }
    .stat-icon.selling { background: linear-gradient(135deg, #10b981, #059669); color: white; }
    .stat-icon.profit { background: linear-gradient(135deg, #ef4444, #dc2626); color: white; }

    .stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 0.25rem;
    }
    
    @media (max-width: 768px) {
        .stat-value {
            font-size: 1.25rem;
        }
    }

    .stat-label {
        color: var(--text-light);
        font-size: 0.8rem;
        font-weight: 500;
    }
    
    @media (max-width: 768px) {
        .stat-label {
            font-size: 0.7rem;
        }
    }

    .filter-section {
        background: var(--card-bg);
        border-radius: 1rem;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
        border: 1px solid var(--border);
        transition: all 0.3s ease;
    }
    
    @media (max-width: 768px) {
        .filter-section {
            padding: 1rem;
        }
    }

    .search-input-group {
        position: relative;
    }

    .search-input-group i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--primary);
        font-size: 1rem;
        z-index: 4;
    }

    .search-input-group input,
    .search-input-group select {
        padding-left: 2.5rem;
        border-radius: 0.75rem;
        border: 2px solid var(--border);
        transition: all 0.3s ease;
        background-color: var(--bg-white);
        color: var(--text);
        font-size: 0.9rem;
    }
    
    @media (max-width: 768px) {
        .search-input-group input,
        .search-input-group select {
            font-size: 0.8rem;
            padding: 0.5rem 0.75rem 0.5rem 2.5rem;
        }
    }

    .search-input-group input:focus,
    .search-input-group select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(74, 100, 145, 0.1);
        outline: none;
    }

    .barcode-scan-btn {
        position: absolute;
        right: 0.5rem;
        top: 50%;
        transform: translateY(-50%);
        z-index: 5;
        width: 34px;
        height: 34px;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 1rem;
        transition: all 0.2s ease;
        background-color: transparent;
        color: var(--primary);
        border-radius: 8px;
    }
    
    @media (max-width: 768px) {
        .barcode-scan-btn {
            width: 30px;
            height: 30px;
        }
    }
    
    .barcode-scan-btn:hover {
        transform: translateY(-50%) scale(1.1);
    }

    .products-table-container {
        background: var(--card-bg);
        border-radius: 1rem;
        overflow-x: auto;
        box-shadow: 0 4px 15px var(--shadow);
        transition: all 0.3s ease;
    }

    .products-table {
        width: 100%;
        margin-bottom: 0;
        background-color: var(--table-row-bg);
        min-width: 800px;
    }
    
    @media (max-width: 992px) {
        .products-table {
            min-width: 700px;
        }
    }

    .products-table thead th {
        background: var(--table-header-bg);
        color: white;
        font-weight: 600;
        padding: 0.875rem 0.75rem;
        font-size: 0.85rem;
        border: none;
        white-space: nowrap;
    }
    
    @media (max-width: 768px) {
        .products-table thead th {
            padding: 0.6rem 0.5rem;
            font-size: 0.75rem;
        }
    }

    .products-table tbody tr {
        background-color: var(--table-row-bg);
        transition: background-color 0.2s ease;
    }

    .products-table tbody tr:nth-child(even) {
        background-color: var(--table-row-alt-bg);
    }

    .products-table tbody td {
        padding: 0.75rem 0.75rem;
        vertical-align: middle;
        border-bottom: 1px solid var(--border);
        font-size: 0.85rem;
        color: var(--text);
        background-color: inherit;
    }
    
    @media (max-width: 768px) {
        .products-table tbody td {
            padding: 0.5rem;
            font-size: 0.75rem;
        }
    }

    .products-table tbody tr:hover {
        background: var(--table-hover) !important;
    }

    /* Override row classes for dark mode compatibility */
    .warning-row,
    body.dark-mode .warning-row {
        background-color: rgba(245, 158, 11, 0.15) !important;
        border-right: 3px solid #f59e0b;
    }
    
    .danger-row,
    body.dark-mode .danger-row {
        background-color: rgba(239, 68, 68, 0.15) !important;
        border-right: 3px solid #ef4444;
    }
    
    .critical-row,
    body.dark-mode .critical-row {
        background-color: rgba(220, 38, 38, 0.2) !important;
        border-right: 3px solid #dc2626;
        animation: pulse 2s infinite;
    }
    
    .warning-row td,
    .danger-row td,
    .critical-row td {
        background-color: transparent !important;
    }

    @keyframes pulse {
        0% { background-color: rgba(220, 38, 38, 0.2); }
        50% { background-color: rgba(220, 38, 38, 0.4); }
        100% { background-color: rgba(220, 38, 38, 0.2); }
    }

    .profit-positive {
        color: #10b981;
        font-weight: 600;
    }

    .profit-negative {
        color: #ef4444;
        font-weight: 600;
    }

    .profit-zero {
        color: var(--text-light);
    }

    .stock-badge {
        display: inline-block;
        padding: 0.2rem 0.6rem;
        border-radius: 2rem;
        font-size: 0.75rem;
        font-weight: 600;
        white-space: nowrap;
    }
    
    @media (max-width: 768px) {
        .stock-badge {
            font-size: 0.65rem;
            padding: 0.15rem 0.45rem;
        }
    }

    .stock-normal {
        background: #d1fae5;
        color: #065f46;
    }
    body.dark-mode .stock-normal {
        background: #065f46;
        color: #d1fae5;
    }

    .stock-low {
        background: #fed7aa;
        color: #92400e;
    }
    body.dark-mode .stock-low {
        background: #92400e;
        color: #fed7aa;
    }

    .stock-out {
        background: #fee2e2;
        color: #991b1b;
    }
    body.dark-mode .stock-out {
        background: #7f1d1d;
        color: #fecaca;
    }

    .stock-negative {
        background: #fecaca;
        color: #7f1d1d;
    }
    body.dark-mode .stock-negative {
        background: #7f1d1d;
        color: #fecaca;
    }

    .stock-critical {
        background: #dc2626;
        color: white;
    }

    .pagination-container {
        padding: 1rem 1.25rem;
        background: var(--card-bg);
        border-top: 1px solid var(--border);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    @media (max-width: 768px) {
        .pagination-container {
            flex-direction: column;
            justify-content: center;
        }
    }

    .btn-reset {
        background: var(--border);
        color: var(--text);
        border: none;
        padding: 0.5rem 1.25rem;
        border-radius: 0.75rem;
        font-weight: 600;
        transition: all 0.3s ease;
        font-size: 0.85rem;
    }
    
    @media (max-width: 768px) {
        .btn-reset {
            padding: 0.4rem 1rem;
            font-size: 0.75rem;
            width: 100%;
        }
    }

    .btn-reset:hover {
        background: var(--text-light);
        color: white;
    }

    .per-page-select {
        width: auto;
        display: inline-block;
        border-radius: 0.5rem;
        border: 1px solid var(--border);
        padding: 0.25rem 0.5rem;
        background-color: var(--bg-white);
        color: var(--text);
        font-size: 0.85rem;
    }

    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        visibility: hidden;
    }

    .loading-overlay.active {
        visibility: visible;
    }

    .loading-spinner {
        background: var(--card-bg);
        padding: 1.5rem;
        border-radius: 1rem;
        text-align: center;
        color: var(--text);
    }

    .btn-add-to-store {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border: none;
        padding: 0.35rem 0.7rem;
        border-radius: 0.5rem;
        font-size: 0.7rem;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
        margin-right: 0.25rem;
        white-space: nowrap;
    }
    
    @media (max-width: 768px) {
        .btn-add-to-store {
            font-size: 0.65rem;
            padding: 0.3rem 0.5rem;
        }
    }

    .btn-add-to-store:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .btn-add-to-list {
        background: linear-gradient(135deg, var(--primary), var(--accent));
        color: white;
        border: none;
        padding: 0.35rem 0.7rem;
        border-radius: 0.5rem;
        font-size: 0.7rem;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
        white-space: nowrap;
    }
    
    @media (max-width: 768px) {
        .btn-add-to-list {
            font-size: 0.65rem;
            padding: 0.3rem 0.5rem;
        }
    }

    .btn-add-to-list:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(74, 100, 145, 0.3);
    }

    .btn-show-list {
        background: linear-gradient(135deg, var(--warning), #d97706);
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 0.75rem;
        font-weight: 600;
        transition: all 0.3s ease;
        margin-bottom: 1rem;
        font-size: 0.85rem;
    }
    
    @media (max-width: 768px) {
        .btn-show-list {
            font-size: 0.75rem;
            padding: 0.4rem 0.8rem;
            width: 100%;
        }
    }

    .btn-show-list:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
        color: white;
    }

    .action-buttons {
        display: flex;
        gap: 0.25rem;
        flex-wrap: wrap;
    }

    .list-badge {
        display: inline-block;
        background: var(--primary);
        color: white;
        padding: 0.15rem 0.4rem;
        border-radius: 0.5rem;
        font-size: 0.6rem;
        margin-left: 0.3rem;
        white-space: nowrap;
    }

    .product-image {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 0.5rem;
        cursor: pointer;
        transition: transform 0.2s ease;
        border: 1px solid var(--border);
    }
    
    @media (max-width: 768px) {
        .product-image {
            width: 32px;
            height: 32px;
        }
    }
    
    .product-image:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 12px var(--shadow);
    }

    /* Critical Items Container */
    .critical-items-container {
        max-height: 60vh;
        overflow-y: auto;
    }
    
    .critical-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        border-bottom: 1px solid var(--border);
        transition: background 0.2s ease;
        background-color: var(--card-bg);
        flex-wrap: wrap;
    }
    
    @media (max-width: 768px) {
        .critical-item {
            flex-direction: column;
            text-align: center;
            gap: 0.5rem;
        }
        .critical-item-quantity {
            width: 100%;
        }
    }
    
    .critical-item:hover {
        background: var(--table-hover);
    }
    
    .critical-item-image {
        
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 0.75rem;
        border: 1px solid var(--border);
        cursor: pointer;
    }
    
    @media (max-width: 768px) {
        .critical-item-image {
            width: 60px;
            height: 60px;
        }
    }
    
    .critical-item-info {
        flex: 1;
    }
    
    .critical-item-name {
        font-weight: 600;
        color: var(--text);
        margin-bottom: 0.25rem;
    }
    
    .critical-item-company {
        font-size: 0.8rem;
        color: var(--text-light);
    }
    
    .critical-item-quantity {
        text-align: center;
        min-width: 70px;
    }
    
    .quantity-badge {
        display: inline-block;
        background: #dc2626;
        color: white;
        padding: 0.2rem 0.6rem;
        border-radius: 2rem;
        font-size: 0.85rem;
        font-weight: 600;
    }
    
    .empty-critical {
        text-align: center;
        padding: 2rem;
        color: var(--text-light);
    }

    /* Modal Dark Mode Styles */
    .modal-content {
        background-color: var(--modal-bg);
        color: var(--text);
        border: 1px solid var(--border);
    }
    .modal-header {
        border-bottom-color: var(--border);
    }
    .modal-footer {
        border-top-color: var(--border);
    }
    .modal-header .btn-close {
        filter: invert(1);
    }
    body.dark-mode .modal-header .btn-close {
        filter: invert(1) brightness(2);
    }
    .form-control, .form-select {
        background-color: var(--bg-white);
        color: var(--text);
        border-color: var(--border);
    }
    .form-control:focus, .form-select:focus {
        background-color: var(--bg-white);
        color: var(--text);
        border-color: var(--primary);
    }
    .form-control[readonly] {
        background-color: var(--border);
        color: var(--text-light);
    }
    .alert-info {
        background-color: rgba(59, 130, 246, 0.2);
        color: var(--info);
        border-color: var(--info);
    }
    .alert-warning {
        background-color: rgba(245, 158, 11, 0.2);
        color: var(--warning);
        border-color: var(--warning);
    }

    .form-control::placeholder {
        color: var(--text-light);
    }
    
    /* Pagination Dark Mode */
    .pagination .page-item .page-link {
        background-color: var(--card-bg);
        border-color: var(--border);
        color: var(--text);
        font-size: 0.8rem;
        padding: 0.4rem 0.7rem;
    }
    
    @media (max-width: 768px) {
        .pagination .page-item .page-link {
            padding: 0.3rem 0.5rem;
            font-size: 0.7rem;
        }
    }
    
    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border-color: var(--primary);
        color: white;
    }
    .pagination .page-item.disabled .page-link {
        background-color: var(--card-bg);
        border-color: var(--border);
        color: var(--text-light);
    }

    /* Scanner Modal Dark Mode */
    .scanner-modal .modal-content {
        background: #000;
    }
    
    .scanner-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        pointer-events: none;
    }
    
    .scan-region {
        width: 70%;
        height: 100px;
        border: 2px solid var(--accent);
        border-radius: 12px;
        box-shadow: 0 0 0 9999px rgba(0, 0, 0, 0.5);
        animation: scanPulse 1.5s infinite;
    }
    
    @media (max-width: 768px) {
        .scan-region {
            width: 85%;
            height: 80px;
        }
    }
    
    @keyframes scanPulse {
        0% { border-color: var(--accent); box-shadow: 0 0 0 9999px rgba(0, 0, 0, 0.5); }
        50% { border-color: var(--primary); box-shadow: 0 0 0 9999px rgba(0, 0, 0, 0.6); }
        100% { border-color: var(--accent); box-shadow: 0 0 0 9999px rgba(0, 0, 0, 0.5); }
    }
    
    .scan-instruction {
        position: absolute;
        bottom: 15px;
        left: 0;
        right: 0;
        text-align: center;
        color: white;
        background: rgba(0,0,0,0.7);
        padding: 6px;
        font-size: 0.8rem;
    }
    
    @media (max-width: 768px) {
        .scan-instruction {
            font-size: 0.7rem;
            bottom: 10px;
        }
    }

    /* Print Styles */
    @media print {
        .dark-mode-toggle, .btn-show-list, .filter-section, .pagination-container, .action-buttons, .btn-add-to-store, .btn-add-to-list, .no-print {
            display: none !important;
        }
        .stat-card {
            box-shadow: none;
            border: 1px solid #ddd;
            break-inside: avoid;
        }
        .products-table-container {
            box-shadow: none;
            overflow-x: visible;
        }
        .products-table thead th {
            background: #4a6491 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        body, body.dark-mode {
            background: white;
            color: black;
        }
        .products-table tbody tr {
            background-color: white !important;
        }
        .products-table tbody td {
            color: black !important;
        }
    }

    .barcode-input {
        padding-right: 45px;
    }


    
    /* Responsive Statistics Row */
    .statistics-row {
        margin-bottom: 1.5rem;
    }
    
    /* Responsive Modal */
    @media (max-width: 576px) {
        .modal-dialog {
            margin: 0.5rem;
        }
        .modal-body {
            padding: 1rem;
        }
        .modal-header, .modal-footer {
            padding: 0.75rem 1rem;
        }
        .modal-title {
            font-size: 1rem;
        }
    }
    
    /* Alert responsive */
    @media (max-width: 576px) {
        .position-fixed.alert {
            width: 90% !important;
            left: 5% !important;
            right: 5% !important;
            transform: none !important;
            top: 10px !important;
        }
    }
</style>

<!-- Dark Mode Toggle Button -->


<div class="container-fluid py-3 py-md-4">
    <div class="report-header text-white mb-3 mb-md-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h2 class="mb-1 mb-md-2">
                    <i class="fas fa-chart-line me-2"></i>
                    ڕاپۆرتی ڕەوشی کۆگا
                </h2>
                <p class="mb-0 opacity-75">
                    <i class="fas fa-boxes me-1"></i>
                    بینینی هەموو کاڵاکانی کۆگا و ڕێژەی قازانج
                </p>
            </div>
        </div>
    </div>

    <div class="mb-3 no-print">
        <button class="btn-show-list w-100 w-md-auto" onclick="openCriticalListModal()">
            <i class="fas fa-exclamation-triangle me-2"></i>
            لیستی ئەو کاڵایانەی کە لە ٣ کەمترن (کەمترین بڕ)
        </button>
    </div>

    <div class="filter-section no-print">
        <div class="row g-2 g-md-3">
            <div class="col-12 col-md-3">
                <div class="search-input-group">
                    <i class="fas fa-barcode"></i>
                    <input type="text" id="filter-barcode" class="form-control barcode-input" placeholder="بارکۆد" autocomplete="off">
                    <button type="button" id="scan-barcode-filter-btn" class="barcode-scan-btn" title="سکانکردنی بارکۆد بە کامێرا">
                        <i class="fas fa-camera"></i>
                    </button>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="search-input-group">
                    <i class="fas fa-building"></i>
                    <input type="text" id="filter-company" class="form-control" placeholder="ناوی کۆمپانیا" autocomplete="off">
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="search-input-group">
                    <i class="fas fa-chart-simple"></i>
                    <select id="filter-stock-status" class="form-control">
                        <option value="">هەموو کاڵاکان</option>
                        <option value="normal">بەردەست (بڕ > 10)</option>
                        <option value="low">کەم (< 10)</option>
                        <option value="critical">کەمترین (بڕ < 3)</option>
                        <option value="out">تەواو بوو (بڕ = 0)</option>
                        <option value="negative">کەمبوونەوە (بڕ < 0)</option>
                    </select>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <button class="btn-reset w-100" onclick="resetFilters()">
                    <i class="fas fa-undo-alt me-1"></i> ڕێکخستنەوە
                </button>
            </div>
        </div>
    </div>

    <div class="products-table-container" id="pdf-content">
        <div class="table-responsive">
            <table class="products-table table" id="products-table">
                <thead>
                    <tr>
                        <th style="min-width: 50px;">ژ</th>
                        <th style="min-width: 70px;">وێنە</th>
                        <th style="min-width: 120px;">ناوی کاڵا</th>
                        <th style="min-width: 100px;">کۆمپانیا</th>
                        <th style="min-width: 70px;">بڕ</th>
                        <th style="min-width: 80px;">نرخی کڕین</th>
                        <th style="min-width: 90px;">کۆی کڕین</th>
                        <th style="min-width: 80px;">نرخی فرۆشتن</th>
                        <th style="min-width: 90px;">کۆی فرۆشتن</th>
                        <th style="min-width: 80px;">قازانج</th>
                        <th style="min-width: 140px;" class="no-print">کردار</th>
                    </tr>
                </thead>
                <tbody id="products-table-body">
                    <tr>
                        <td colspan="12" class="text-center py-5">
                            <i class="fas fa-spinner fa-spin fa-2x text-primary"></i>
                            <p class="mt-3">بارکردنی زانیاری...</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="pagination-container no-print">
            <div class="d-flex align-items-center gap-2">
                <span class="text-muted">کاڵا لە لاپەڕە:</span>
                <select id="per-page" class="per-page-select">
                    <option value="15">15</option>
                    <option value="30">30</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
            <nav id="pagination-nav" class="mt-2 mt-md-0"></nav>
        </div>
    </div>
</div>

<!-- Add Amount Modal -->
<div class="modal fade" id="addAmountModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #4a6491, #2c3e50); color: white;">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle me-2"></i>
                    زیادکردنی ژماری کاڵا بۆ دوکان
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="add-amount-form">
                <div class="modal-body">
                    <input type="hidden" id="product-id">
                    <div class="mb-3">
                        <label class="form-label">ناوی کاڵا</label>
                        <input type="text" id="product-name" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">بڕی ئێستا لە کۆگا</label>
                        <input type="text" id="current-quantity" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ژمارەی کاڵا بۆ زیادکردن بۆ دوکان</label>
                        <input type="number" id="add-quantity" class="form-control" required min="1" placeholder="ژمارە داخڵ بکە">
                    </div>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        ئەگەر کاڵاکە لە کۆگادا بەردەست بێت، ژمارەی کاڵاکە کەم دەبێتەوە و بۆ دوکان زیاد دەبێت
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">داخستن</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check me-1"></i> زیادکردن بۆ دوکان                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add to Critical List Modal -->
<div class="modal fade" id="addToListModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #f59e0b, #d97706); color: white;">
                <h5 class="modal-title">
                    <i class="fas fa-list me-2"></i>
                    زیادکردن بۆ لیستی کەمترین بڕ
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="add-to-list-form">
                <div class="modal-body">
                    <input type="hidden" id="list-product-id">
                    <div class="mb-3">
                        <label class="form-label">ناوی کاڵا</label>
                        <input type="text" id="list-product-name" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">بڕی ئێستا لە کۆگا</label>
                        <input type="text" id="list-current-quantity" class="form-control" readonly>
                    </div>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        ئەم کاڵایە دەخرێتە ناوی لیستی ئەو کاڵایانەی کە بڕیان کەمە (کەمتر لە 5)
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">داخستن</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save me-1"></i> زیادکردن بۆ لیست
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Critical List Modal -->
<div class="modal fade critical-list-modal" id="criticalListModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    لیستی کاڵا کەمەکان (کەمتر لە 3)
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <div id="critical-items-container" class="critical-items-container">
                    <div class="text-center py-5">
                        <i class="fas fa-spinner fa-spin fa-2x text-warning"></i>
                        <p class="mt-2">بارکردنی زانیاری...</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer flex-wrap gap-2">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">داخستن</button>
                <button type="button" class="btn btn-success" onclick="exportCriticalListToExcel()">
                    <i class="fas fa-file-excel me-1"></i> Excel
                </button>
                <button type="button" class="btn btn-danger" onclick="printCriticalList()">
                    <i class="fas fa-print me-1"></i> Print
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Fullscreen Image Modal -->
<!-- Fullscreen Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen"   >
        <div class="modal-content" style="background: transparent;">
          
            <div class="modal-body">
                
                <div class="d-flex align-items-center justify-content-center" style="height: calc(100vh - 100px);">
                      <div class="modal-header border`-0">
                <button type="button" class="btn-close btn-close-white fs-5 p-3" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                    <img id="fullscreen-image" src="" alt="Product Image" class="img-fluid" 
                         style="max-width: 95%; max-height: 95%; object-fit: contain; box-shadow: 0 0 30px rgba(0,0,0,0.5); border-radius: 10px;">
                </div>
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
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0 position-relative" style="min-height: 300px; background: #000;">
                <video id="scanner-video" autoplay playsinline style="width: 100%; height: auto; min-height: 300px; background: #000; transform: scaleX(-1);"></video>
                <div class="scanner-overlay">
                    <div class="scan-region"></div>
                </div>
                <div class="scan-instruction">
                    <i class="fas fa-qrcode ms-1"></i> بارکۆدەکە لە ناوچەی سکاندا دابنێ
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="closeScannerBtn">
                    <i class="fas fa-times ms-1"></i>داخستن
                </button>
                <button type="button" id="manual-input-btn" class="btn btn-primary">
                    <i class="fas fa-keyboard ms-1"></i>دەستکاری بارکۆد
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div id="loading-overlay" class="loading-overlay">
    <div class="loading-spinner">
        <i class="fas fa-spinner fa-spin fa-2x text-primary mb-2"></i>
        <p class="mb-0">تکایە چاوەڕێ بە...</p>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
// ==================== NUMBER CONVERSION FUNCTIONS (defined first) ====================
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

function cleanBarcodeValue(value) {
    if (!value) return '';
    let englishValue = toEnglishNumbers(value);
    return englishValue.replace(/[^0-9]/g, '');
}

// ==================== GLOBAL VARIABLES ====================
let currentPage = 1;
let totalPages = 1;
let currentFilters = {
    name: '',
    barcode: '',
    company: '',
    stock_status: ''
};
let debounceTimer;
let modal;
let listModal;
let imageModal;
let criticalListModal;
let currentProductsData = [];
let criticalProductsCache = [];
let scannerStream = null;
let scannerActive = false;
let scannerModal = null;

// ==================== HELPER FUNCTIONS ====================
function formatNumber(num) {
    if (num === null || num === undefined || isNaN(num)) return '0';
    return Math.round(num).toLocaleString();
}

function escapeHtml(text) {
    if (!text) return '';
    return String(text).replace(/[&<>]/g, function(m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        return m;
    });
}

function getImageUrl(imagePath) {
    if (!imagePath) return '';
    if (imagePath.startsWith('http')) return imagePath;
    if (imagePath.startsWith('/')) return imagePath;
    return '/' + imagePath;
}

function showError(message) {
    const alertHtml = `<div class="alert alert-danger alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3" style="z-index: 10000; min-width: 280px; max-width: 90%;" role="alert"><i class="fas fa-exclamation-circle me-2"></i>${escapeHtml(message)}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>`;
    $('body').append(alertHtml);
    setTimeout(() => $('.alert-danger').fadeOut(300, function() { $(this).remove(); }), 3000);
}

function showSuccess(message) {
    const alertHtml = `<div class="alert alert-success alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3" style="z-index: 10000; min-width: 280px; max-width: 90%;" role="alert"><i class="fas fa-check-circle me-2"></i>${escapeHtml(message)}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>`;
    $('body').append(alertHtml);
    setTimeout(() => $('.alert-success').fadeOut(300, function() { $(this).remove(); }), 3000);
}

function showFullscreenImage(imageUrl, productName) {
    document.getElementById('fullscreen-image').src = imageUrl;
    imageModal.show();
}

// ==================== DARK MODE IMPLEMENTATION ====================
(function() {
    const savedTheme = localStorage.getItem('kurdistan_warehouse_theme');
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    let isDarkMode = savedTheme === 'dark' || (savedTheme === null && prefersDark);
    
    function applyDarkMode(enabled) {
        if (enabled) {
            document.body.classList.add('dark-mode');
            localStorage.setItem('kurdistan_warehouse_theme', 'dark');
            const toggleBtn = document.getElementById('darkModeToggle');
            if (toggleBtn) {
                toggleBtn.innerHTML = '<i class="fas fa-sun"></i>';
            }
        } else {
            document.body.classList.remove('dark-mode');
            localStorage.setItem('kurdistan_warehouse_theme', 'light');
            const toggleBtn = document.getElementById('darkModeToggle');
            if (toggleBtn) {
                toggleBtn.innerHTML = '<i class="fas fa-moon"></i>';
            }
        }
        // Only reload if loadProducts exists and is a function
        if (typeof loadProducts === 'function' && currentPage) {
            loadProducts();
        }
    }
    
    function toggleDarkMode() {
        isDarkMode = !isDarkMode;
        applyDarkMode(isDarkMode);
    }
    
    // Initialize - apply dark mode without calling loadProducts yet
    if (isDarkMode) {
        document.body.classList.add('dark-mode');
        localStorage.setItem('kurdistan_warehouse_theme', 'dark');
    } else {
        document.body.classList.remove('dark-mode');
        localStorage.setItem('kurdistan_warehouse_theme', 'light');
    }
    
    // Set the toggle button icon
    $(document).ready(function() {
        const toggleBtn = document.getElementById('darkModeToggle');
        if (toggleBtn) {
            if (document.body.classList.contains('dark-mode')) {
                toggleBtn.innerHTML = '<i class="fas fa-sun"></i>';
            } else {
                toggleBtn.innerHTML = '<i class="fas fa-moon"></i>';
            }
        }
        $('#darkModeToggle').on('click', toggleDarkMode);
    });
    
    // Listen for system theme changes
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
        const saved = localStorage.getItem('kurdistan_warehouse_theme');
        if (!saved) {
            if (e.matches) {
                document.body.classList.add('dark-mode');
                localStorage.setItem('kurdistan_warehouse_theme', 'dark');
            } else {
                document.body.classList.remove('dark-mode');
                localStorage.setItem('kurdistan_warehouse_theme', 'light');
            }
            isDarkMode = e.matches;
            if (typeof loadProducts === 'function') {
                loadProducts();
            }
        }
    });
})();

// ==================== BARCODE INPUT NORMALIZATION ====================
function forceNumericInputForBarcode() {
    const barcodeInput = document.getElementById('filter-barcode');
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
        if (allowedKeys.includes(e.key)) return;
        if (e.ctrlKey && (e.key === 'a' || e.key === 'c' || e.key === 'v' || e.key === 'x')) return;
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

// ==================== BARCODE SCANNER FUNCTIONS ====================
async function startBarcodeScanner() {
    await stopBarcodeScanner();
    const videoElement = document.getElementById('scanner-video');
    if (!videoElement) return;
    try {
        const stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } });
        scannerStream = stream;
        videoElement.srcObject = stream;
        await videoElement.play();
        scannerActive = true;
        if ('BarcodeDetector' in window) {
            const barcodeDetector = new BarcodeDetector({ formats: ['code_128', 'ean_13', 'ean_8', 'code_39', 'upc_a', 'upc_e', 'codabar'] });
            async function scanFrame() {
                if (!scannerActive) return;
                if (videoElement.readyState === videoElement.HAVE_ENOUGH_DATA) {
                    try {
                        const barcodes = await barcodeDetector.detect(videoElement);
                        if (barcodes && barcodes.length > 0) {
                            let barcodeValue = barcodes[0].rawValue;
                            if (barcodeValue) {
                                barcodeValue = cleanBarcodeValue(barcodeValue);
                                scannerActive = false;
                                await stopBarcodeScanner();
                                $('#filter-barcode').val(barcodeValue).trigger('input');
                                scannerModal.hide();
                                $('#filter-barcode').focus();
                                return;
                            }
                        }
                    } catch (err) { console.error(err); }
                }
                if (scannerActive) requestAnimationFrame(scanFrame);
            }
            scanFrame();
        } else {
            showError('ئەم وێبگەڕە پشتیوانی لە سکانکردنی ئۆتۆماتیکی بارکۆد ناکات.');
        }
    } catch (err) {
        console.error(err);
        showError('ناتوانرێت کامێرا بۆ سکانکردن بکرێتەوە.');
        scannerModal.hide();
    }
}

async function stopBarcodeScanner() {
    scannerActive = false;
    if (scannerStream) {
        scannerStream.getTracks().forEach(track => track.stop());
        scannerStream = null;
    }
    const videoElement = document.getElementById('scanner-video');
    if (videoElement) videoElement.srcObject = null;
}

// ==================== PRODUCT FUNCTIONS ====================
function renderCriticalList(products) {
    let html = '';
    products.forEach((product) => {
        const quantity = product.counter || 0;
        const companyName = product.company || 'بێ کۆمپانیا';
        const productName = product.name || 'بێ ناو';
        let imageUrl = getImageUrl(product.image_producte_path);
        html += `<div class="critical-item"><img src="${escapeHtml(imageUrl)}" class="critical-item-image" alt="${escapeHtml(productName)}" onerror="this.src='data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2240%22%20height%3D%2240%22%20viewBox%3D%220%200%2040%2040%22%3E%3Crect%20width%3D%2240%22%20height%3D%2240%22%20fill%3D%22%23cbd5e1%22%2F%3E%3Ctext%20x%3D%2220%22%20y%3D%2225%22%20text-anchor%3D%22middle%22%20fill%3D%22%234b5563%22%3E${productName.charAt(0)||'?'}%3C%2Ftext%3E%3C%2Fsvg%3E';" onclick="showFullscreenImage('${escapeHtml(imageUrl)}', '${escapeHtml(productName)}')"><div class="critical-item-info"><div class="critical-item-name">${escapeHtml(productName)}${product.in_critical_list ? '<span class="list-badge"><i class="fas fa-check-circle"></i> لە لیستدا</span>' : ''}</div><div class="critical-item-company"><i class="fas fa-building ms-2"></i>${escapeHtml(companyName)}</div></div><div class="critical-item-quantity"><span class="quantity-badge">${quantity} ${product.unit === 'piece' ? '' : (product.unit || '')}</span></div></div>`;
    });
    $('#critical-items-container').html(html);
}

function openCriticalListModal() {
    criticalListModal.show();
    loadCriticalProducts();
}

function loadCriticalProducts() {
    $('#critical-items-container').html(`<div class="text-center py-5"><i class="fas fa-spinner fa-spin fa-2x text-warning"></i><p class="mt-2">بارکردنی زانیاری...</p></div>`);
    $.ajax({
        url: '/warehouse/critical-list',
        type: 'GET',
        success: function(response) {
            if (response.success && response.data && response.data.length > 0) {
                criticalProductsCache = response.data;
                renderCriticalList(response.data);
            } else {
                criticalProductsCache = [];
                $('#critical-items-container').html(`<div class="empty-critical"><i class="fas fa-check-circle fa-3x text-success mb-3 d-block"></i><p class="mb-0">هیچ کاڵایەک بە کەمتر لە 3 نییە</p></div>`);
            }
        },
        error: function() {
            criticalProductsCache = [];
            $('#critical-items-container').html(`<div class="empty-critical"><i class="fas fa-exclamation-circle fa-3x text-danger mb-3 d-block"></i><p class="mb-0">هەڵەیەک ڕوویدا لە بارکردنی زانیاری</p></div>`);
        }
    });
}

function renderProductsTable(products) {
    const tbody = $('#products-table-body');
    if (!products || products.length === 0) {
        tbody.html(`<td><td colspan="12" class="text-center py-5"><i class="fas fa-box-open fa-3x text-muted mb-3 d-block"></i><p class="text-muted">هیچ کاڵایەک نەدۆزرایەوە</p></td></tr>`);
        return;
    }
    let html = '';
    products.forEach((product, index) => {
        const startIndex = (currentPage - 1) * $('#per-page').val();
        const rowNumber = startIndex + index + 1;
        const quantity = product.counter || 0;
        const purchasePrice = parseFloat(product.purchase_price) || 0;
        const sellingPrice = parseFloat(product.selling_price) || 0;
        const totalPurchase = quantity * purchasePrice;
        const totalSelling = quantity * sellingPrice;
        const profit = totalSelling - totalPurchase;
        let stockClass = '', rowClass = '';
        if (quantity < 0) { stockClass = 'stock-negative'; rowClass = 'danger-row'; }
        else if (quantity === 0) { stockClass = 'stock-out'; rowClass = 'danger-row'; }
        else if (quantity < 3) { stockClass = 'stock-critical'; rowClass = 'critical-row'; }
        else if (quantity < 10) { stockClass = 'stock-low'; rowClass = 'warning-row'; }
        else { stockClass = 'stock-normal'; }
        let profitClass = '', profitText = '';
        if (profit > 0) { profitClass = 'profit-positive'; profitText = '+' + formatNumber(profit); }
        else if (profit < 0) { profitClass = 'profit-negative'; profitText = formatNumber(profit); }
        else { profitClass = 'profit-zero'; profitText = '0'; }
        const companyName = product.company || 'بێ کۆمپانیا';
        const productName = product.name || 'بێ ناو';
        const isInCriticalList = product.in_critical_list || false;
        let imageUrl = getImageUrl(product.image_producte_path);
        html += `<tr class="${rowClass}"><td>${rowNumber}</td><td><img src="${escapeHtml(imageUrl)}" class="product-image" alt="${escapeHtml(productName)}" onerror="this.src='data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2240%22%20height%3D%2240%22%20viewBox%3D%220%200%2040%2040%22%3E%3Crect%20width%3D%2240%22%20height%3D%2240%22%20fill%3D%22%23cbd5e1%22%2F%3E%3Ctext%20x%3D%2220%22%20y%3D%2225%22%20text-anchor%3D%22middle%22%20fill%3D%22%234b5563%22%3E${productName.charAt(0)||'?'}%3C%2Ftext%3E%3C%2Fsvg%3E';" onclick="showFullscreenImage('${escapeHtml(imageUrl)}', '${escapeHtml(productName)}')"></td><td><strong>${escapeHtml(productName)}</strong>${isInCriticalList ? '<span class="list-badge"><i class="fas fa-check-circle"></i> لە لیستدا</span>' : ''}</td><td>${escapeHtml(companyName)}</td><td><span class="stock-badge ${stockClass}">${quantity} ${product.unit === 'piece' ? '' : (product.unit || '')}</span>${quantity < 0 ? '<br><small class="text-danger">لە کۆگا کەمترە</small>' : ''}</td><td>${formatNumber(purchasePrice)}</td><td>${formatNumber(totalPurchase)}</td><td>${formatNumber(sellingPrice)}</td><td>${formatNumber(totalSelling)}</td><td class="${profitClass}">${profitText}</td><td class="action-buttons no-print"><button class="btn-add-to-store" onclick="openAddToStoreModal(${product.id}, '${escapeHtml(productName)}', ${quantity})"><i class="fas fa-store me-1"></i> زیادکردن بۆ دوکان</button>${quantity < 5 && quantity > 0 ? `<button class="btn-add-to-list" onclick="openAddToListModal(${product.id}, '${escapeHtml(productName)}', ${quantity})"><i class="fas fa-list me-1"></i> زیادکردن بۆ لیست</button>` : ''}</td></tr>`;
    });
    tbody.html(html);
}

function renderPagination(response) {
    totalPages = response.last_page || 1;
    currentPage = response.current_page || 1;
    if (totalPages <= 1) { $('#pagination-nav').html(''); return; }
    let paginationHtml = '<ul class="pagination mb-0 flex-wrap">';
    paginationHtml += currentPage > 1 ? `<li class="page-item"><a class="page-link" href="#" data-page="${currentPage - 1}">پێشوو</a></li>` : `<li class="page-item disabled"><span class="page-link">پێشوو</span></li>`;
    let startPage = Math.max(1, currentPage - 2);
    let endPage = Math.min(totalPages, currentPage + 2);
    if (startPage > 1) { paginationHtml += `<li class="page-item"><a class="page-link" href="#" data-page="1">1</a></li>`; if (startPage > 2) paginationHtml += `<li class="page-item disabled"><span class="page-link">...</span></li>`; }
    for (let i = startPage; i <= endPage; i++) {
        paginationHtml += i === currentPage ? `<li class="page-item active"><span class="page-link">${i}</span></li>` : `<li class="page-item"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`;
    }
    if (endPage < totalPages) { if (endPage < totalPages - 1) paginationHtml += `<li class="page-item disabled"><span class="page-link">...</span></li>`; paginationHtml += `<li class="page-item"><a class="page-link" href="#" data-page="${totalPages}">${totalPages}</a></li>`; }
    paginationHtml += currentPage < totalPages ? `<li class="page-item"><a class="page-link" href="#" data-page="${currentPage + 1}">دواتر</a></li>` : `<li class="page-item disabled"><span class="page-link">دواتر</span></li>`;
    paginationHtml += '</ul>';
    $('#pagination-nav').html(paginationHtml);
    $('#pagination-nav .page-link').on('click', function(e) {
        e.preventDefault();
        const page = $(this).data('page');
        if (page && page !== currentPage) { currentPage = page; loadProducts(); $('html, body').animate({ scrollTop: $('.products-table-container').offset().top - 100 }, 300); }
    });
}

function loadProducts() {
    $('#loading-overlay').addClass('active');
    const perPage = $('#per-page').val();
    $.ajax({
        url: '/warehouse/report',
        type: 'GET',
        data: { page: currentPage, per_page: perPage, barcode: currentFilters.barcode, company: currentFilters.company, stock_status: currentFilters.stock_status },
        success: function(response) {
            if (response.success) {
                currentProductsData = response.data || [];
                renderProductsTable(currentProductsData);
                renderPagination(response);
            } else { showError('هەڵەیەک ڕوویدا لە بارکردنی زانیاری'); }
        },
        error: function() { showError('هەڵە لە پەیوەندیدا، تکایە دووبارە هەوڵبدەرەوە'); },
        complete: function() { $('#loading-overlay').removeClass('active'); }
    });
}

function applyFilters() {
    currentFilters = {
        name: $('#filter-name').val(),
        barcode: cleanBarcodeValue($('#filter-barcode').val()),
        company: $('#filter-company').val(),
        stock_status: $('#filter-stock-status').val()
    };
    currentPage = 1;
    loadProducts();
}

function resetFilters() {
    $('#filter-barcode').val('');
    $('#filter-company').val('');
    $('#filter-stock-status').val('');
    currentFilters = { name: '', barcode: '', company: '', stock_status: '' };
    currentPage = 1;
    loadProducts();
}

function openAddToStoreModal(productId, productName, currentQuantity) {
    $('#product-id').val(productId);
    $('#product-name').val(productName);
    $('#current-quantity').val(currentQuantity);
    $('#add-quantity').val('');
    modal.show();
}

function openAddToListModal(productId, productName, currentQuantity) {
    $('#list-product-id').val(productId);
    $('#list-product-name').val(productName);
    $('#list-current-quantity').val(currentQuantity);
    listModal.show();
}

function addToStore() {
    const productId = $('#product-id').val();
    const quantity = $('#add-quantity').val();
    if (!quantity || quantity <= 0) { showError('تکایە ژمارەی کاڵا بۆ زیادکردن دیاری بکە'); return; }
    $('#loading-overlay').addClass('active');
    $.ajax({
        url: '/warehouse/add-to-store',
        type: 'POST',
        data: { product_id: productId, quantity: quantity, _token: $('meta[name="csrf-token"]').attr('content') || '{{ csrf_token() }}' },
        success: function(response) {
            if (response.success) { showSuccess('کاڵاکە بە سەرکەوتوویی زیاد کرا بۆ دوکان'); modal.hide(); loadProducts(); }
            else { showError(response.message || 'هەڵەیەک ڕوویدا'); }
        },
        error: function(xhr) { showError(xhr.responseJSON?.message || 'هەڵە لە زیادکردنی کاڵا بۆ دوکان'); },
        complete: function() { $('#loading-overlay').removeClass('active'); }
    });
}

function addToCriticalList() {
    const productId = $('#list-product-id').val();
    $('#loading-overlay').addClass('active');
    $.ajax({
        url: '/warehouse/add-to-critical-list',
        type: 'POST',
        data: { product_id: productId, _token: $('meta[name="csrf-token"]').attr('content') || '{{ csrf_token() }}' },
        success: function(response) {
            if (response.success) { showSuccess('کاڵاکە بە سەرکەوتوویی زیاد کرا بۆ لیستی کەمترین بڕ'); listModal.hide(); loadProducts(); }
            else { showError(response.message || 'هەڵەیەک ڕوویدا'); }
        },
        error: function(xhr) { showError(xhr.responseJSON?.message || 'هەڵە لە زیادکردن بۆ لیست'); },
        complete: function() { $('#loading-overlay').removeClass('active'); }
    });
}

function printCriticalList() {
    if (criticalProductsCache.length === 0) { showError('هیچ کاڵایەکی کەم نییە بۆ پرینت کردن'); return; }
    $('#loading-overlay').addClass('active');
    const printContent = generateCriticalListHTML();
    const printWindow = window.open('', '_blank');
    printWindow.document.write(printContent);
    printWindow.document.close();
    printWindow.onload = function() { printWindow.print(); $('#loading-overlay').removeClass('active'); };
    printWindow.onafterprint = function() { printWindow.close(); };
}

function generateCriticalListHTML() {
    const now = new Date();
    const dateStr = now.toLocaleDateString('ku-Arab', { year: 'numeric', month: 'long', day: 'numeric' });
    let tableRows = '';
    criticalProductsCache.forEach((product, index) => {
        tableRows += `<tr><td style="padding: 10px; border: 1px solid #ddd; text-align: center;">${index + 1}</td><td style="padding: 10px; border: 1px solid #ddd; text-align: center;">${escapeHtml(product.name || 'بێ ناو')}</td><td style="padding: 10px; border: 1px solid #ddd; text-align: center;">${escapeHtml(product.company || 'بێ کۆمپانیا')}</td><td style="padding: 10px; border: 1px solid #ddd; text-align: center; color: #dc2626; font-weight: bold;">${product.counter || 0}</td><td style="padding: 10px; border: 1px solid #ddd; text-align: center;">${product.unit === 'piece' ? 'دانە' : (product.unit || 'دانە')}</td></tr>`;
    });
    return `<!DOCTYPE html><html dir="rtl"><head><title>لیستی کاڵا کەمەکان</title><meta charset="UTF-8"><style>body{margin:0;padding:20px;font-family:Arial,sans-serif;direction:rtl}.header{text-align:center;margin-bottom:30px}.header h2{color:#4a6491;margin-bottom:10px}.header p{color:#6b7280;font-size:14px}table{width:100%;border-collapse:collapse;margin-top:20px}th{background:#4a6491;color:white;padding:12px;border:1px solid #ddd;text-align:center}td{padding:10px;border:1px solid #ddd;text-align:center}.footer{margin-top:30px;text-align:center;color:#9ca3af;font-size:12px}</style></head><body><div class="header"><h2>لیستی کاڵا کەمەکان</h2><p>کاڵا کەمتر لە 3 دانە - تاریخ: ${dateStr}</p></div><table><thead><tr><th>ژ</th><th>ناوی کاڵا</th><th>کۆمپانیا</th><th>بڕ</th><th>یەکە</th></tr></thead><tbody>${tableRows}</tbody></table><div class="footer"><p>ڕاپۆرت لە کۆگا دروست کراوە</p></div></body></html>`;
}

function exportCriticalListToExcel() {
    window.location.href = '/warehouse/critical-list/excel';
}

// ==================== DOCUMENT READY ====================
$(document).ready(function() {
    modal = new bootstrap.Modal(document.getElementById('addAmountModal'));
    listModal = new bootstrap.Modal(document.getElementById('addToListModal'));
    imageModal = new bootstrap.Modal(document.getElementById('imageModal'), {
        backdrop: 'static',
        keyboard: true
    });
    criticalListModal = new bootstrap.Modal(document.getElementById('criticalListModal'));
    scannerModal = new bootstrap.Modal(document.getElementById('barcodeScannerModal'));
    forceNumericInputForBarcode();
    
    // Initial load
    loadProducts();
    
    $('#filter-barcode').on('input', function() {
        let cleanValue = cleanBarcodeValue($(this).val());
        if ($(this).val() !== cleanValue) $(this).val(cleanValue);
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => { currentPage = 1; applyFilters(); }, 500);
    });
    
    $('#filter-company').on('input', function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => { currentPage = 1; applyFilters(); }, 500);
    });
    
    $('#filter-stock-status').on('change', function() {
        currentPage = 1;
        applyFilters();
    });
    
    $('#per-page').on('change', function() {
        currentPage = 1;
        loadProducts();
    });
    
    $('#add-amount-form').on('submit', function(e) {
        e.preventDefault();
        addToStore();
    });
    
    $('#add-to-list-form').on('submit', function(e) {
        e.preventDefault();
        addToCriticalList();
    });
    
    $('#scan-barcode-filter-btn').on('click', function() {
        scannerModal.show();
    });
    
    $('#barcodeScannerModal').on('shown.bs.modal', function() {
        startBarcodeScanner();
    });
    
    $('#barcodeScannerModal').on('hidden.bs.modal', function() {
        stopBarcodeScanner();
    });
    
    $('#manual-input-btn, #closeScannerBtn').on('click', function() {
        scannerModal.hide();
        $('#filter-barcode').focus();
    });
});
</script>
@endsection