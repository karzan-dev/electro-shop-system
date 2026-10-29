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
        --input-bg: #ffffff;
        --input-text: #1e293b;
        --pagination-bg: #ffffff;
        --pagination-active-bg: #4a6491;
        --pagination-active-text: #ffffff;
        --pagination-hover-bg: #e2e8f0;
        --pagination-text: #4a6491;
        --pagination-border: #e2e8f0;
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
        --input-bg: #0f172a;
        --input-text: #e2e8f0;
        --pagination-bg: #1e293b;
        --pagination-active-bg: #6c8db8;
        --pagination-active-text: #ffffff;
        --pagination-hover-bg: #334155;
        --pagination-text: #94a3b8;
        --pagination-border: #334155;
    }

    body {
        background: var(--bg-light);
        font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
        transition: background-color 0.3s ease, color 0.3s ease;
        color: var(--text);
    }

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

    .search-input-group i.fa-barcode,
    .search-input-group i.fa-building,
    .search-input-group i.fa-chart-simple {
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
        background-color: var(--input-bg) !important;
        color: var(--input-text) !important;
        font-size: 0.9rem;
    }
    
    /* Placeholder color for dark mode */
    .search-input-group input::placeholder,
    .search-input-group select::placeholder {
        color: var(--text-light);
        opacity: 0.7;
    }
    
    /* Select dropdown styling */
    .search-input-group select {
        appearance: auto;
        -webkit-appearance: auto;
        -moz-appearance: auto;
    }
    
    .search-input-group select option {
        background-color: var(--input-bg);
        color: var(--input-text);
    }
    
    /* Barcode input with camera button needs extra padding on the right */
    #filter-barcode {
        padding-right: 2.5rem;
    }
    
    @media (max-width: 768px) {
        .search-input-group input,
        .search-input-group select {
            font-size: 0.8rem;
            padding: 0.5rem 0.75rem 0.5rem 2.5rem;
        }
        #filter-barcode {
            padding-right: 2.5rem;
        }
    }

    .search-input-group input:focus,
    .search-input-group select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(74, 100, 145, 0.1);
        outline: none;
    }

    /* Scan Button (Same style as sales page) */
    .scan-btn {
        position: absolute;
        right: 8px;
        top: 50%;
        transform: translateY(-50%);
        background: var(--secondary);
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
        z-index: 5;
    }

    @media (min-width: 640px) {
        .scan-btn { width: 20px; height: 20px; font-size: 18px; right: 10px; }
    }

    .scan-btn:hover {
        background: var(--secondary);
        transform: translateY(-50%) scale(1.05);
    }

    /* Scanner Modal (Same style as sales page) */
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
        z-index: 20001;
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

    /* Stock Status Row Styles */
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

    /* ==================== PAGINATION STYLES ==================== */
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

    /* Pagination */
    .pagination {
        display: flex;
        padding-left: 0;
        list-style: none;
        margin: 0;
        gap: 4px;
    }

    .page-item {
        margin: 0 2px;
    }

    .page-link {
        position: relative;
        display: block;
        padding: 0.5rem 0.75rem;
        font-size: 0.85rem;
        font-weight: 500;
        color: var(--pagination-text);
        text-decoration: none;
        background-color: var(--pagination-bg);
        border: 1px solid var(--pagination-border);
        border-radius: 0.5rem;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .page-link:hover {
        background-color: var(--pagination-hover-bg);
        color: var(--primary);
        border-color: var(--primary);
        z-index: 2;
    }

    .page-item.active .page-link {
        background-color: var(--pagination-active-bg) !important;
        border-color: var(--pagination-active-bg) !important;
        color: var(--pagination-active-text) !important;
        font-weight: 700;
        box-shadow: 0 2px 8px rgba(74, 100, 145, 0.3);
        z-index: 3;
    }

    .page-item.disabled .page-link {
        color: var(--text-light);
        pointer-events: none;
        background-color: transparent;
        border-color: var(--border);
        opacity: 0.5;
    }

    @media (max-width: 768px) {
        .page-link {
            padding: 0.4rem 0.6rem;
            font-size: 0.75rem;
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
        border: 1px solid var(--pagination-border);
        padding: 0.25rem 0.5rem;
        background-color: var(--input-bg);
        color: var(--input-text);
        font-size: 0.85rem;
    }

    .per-page-select option {
        background-color: var(--input-bg);
        color: var(--input-text);
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

    /* Statistics Row */
    .statistics-row {
        margin-bottom: 1.5rem;
    }

    /* Alert Container */
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
        align-items: center;
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

    /* Text muted */
    .text-muted {
        color: var(--text-light) !important;
    }

    /* Print Styles */
    @media print {
        .dark-mode-toggle, .filter-section, .pagination-container, .no-print,
        .scan-btn, .scanner-modal, .alert-container {
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
        .report-header {
            background: #4a6491 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
    }
</style>

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

    <!-- Statistics Cards -->

    <!-- Filter Section -->
    <div class="filter-section no-print">
        <div class="row g-2 g-md-3">
            <div class="col-12 col-md-3">
                <div class="search-input-group">
                    <i class="fas fa-barcode"></i>
                    <input type="text" id="filter-barcode" class="form-control" placeholder="بارکۆد" autocomplete="off">
                    <button type="button" class="scan-btn" onclick="openScanner()" title="سکانکردنی بارکۆد بە کامێرا">
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

    <!-- Products Table -->
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
                    </tr>
                </thead>
                <tbody id="products-table-body">
                    <tr>
                        <td colspan="10" class="text-center py-5">
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

<!-- Fullscreen Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen">
        <div class="modal-content" style="background: transparent;">
            <div class="modal-body">
                <div class="d-flex align-items-center justify-content-center" style="height: calc(100vh - 100px);">
                    <div class="modal-header border-0">
                        <button type="button" class="btn-close btn-close-white fs-5 p-3" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <img id="fullscreen-image" src="" alt="Product Image" class="img-fluid" 
                         style="max-width: 95%; max-height: 95%; object-fit: contain; box-shadow: 0 0 30px rgba(0,0,0,0.5); border-radius: 10px;">
                </div>
            </div>
        </div>
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

<!-- Loading Overlay -->
<div id="loading-overlay" class="loading-overlay">
    <div class="loading-spinner">
        <i class="fas fa-spinner fa-spin fa-2x text-primary mb-2"></i>
        <p class="mb-0">تکایە چاوەڕێ بە...</p>
    </div>
</div>

<!-- HTML5 QR Code Scanner Library -->
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// ==================== NUMBER CONVERSION FUNCTIONS ====================
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
    barcode: '',
    company: '',
    stock_status: ''
};
let debounceTimer;
let imageModal;
let html5QrCode = null;

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
            const normalizedBarcode = toEnglishNumbers(decodedText);
            $('#filter-barcode').val(normalizedBarcode);
            currentPage = 1;
            applyFilters();
            showAlert('success', `بارکۆد دۆزرایەوە: ${normalizedBarcode}`);
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

// ==================== ALERT FUNCTIONS ====================
function showAlert(type, msg, title='') {
    let icons = { success:'fa-check-circle', error:'fa-exclamation-circle', warning:'fa-exclamation-triangle', info:'fa-info-circle' };
    let id = 'alert-'+Date.now();
    let html = `<div id="${id}" class="custom-alert alert-${type}"><div><i class="fas ${icons[type]} fa-lg"></i></div><div><strong>${title||(type==='success'?'سەرکەوتوو':type==='error'?'هەڵە':type==='warning'?'ئاگاداری':'زانیاری')}</strong><div style="font-size:0.85rem;">${msg}</div></div><div class="alert-progress"></div></div>`;
    $('#alert-container').append(html);
    setTimeout(()=>$(`#${id}`).fadeOut(300,function(){$(this).remove();}),4000);
}

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
    showAlert('error', message);
}

function showFullscreenImage(imageUrl, productName) {
    document.getElementById('fullscreen-image').src = imageUrl;
    imageModal.show();
}

// Update Statistics
function updateStatistics(products) {
    if (!products || products.length === 0) {
        $('#total-products').text('0');
        $('#total-purchase').text('0');
        $('#total-selling').text('0');
        $('#total-profit').text('0');
        return;
    }
    
    let totalProducts = products.length;
    let totalPurchase = 0;
    let totalSelling = 0;
    let totalProfit = 0;
    
    products.forEach(product => {
        const quantity = product.counter || 0;
        const purchasePrice = parseFloat(product.purchase_price) || 0;
        const sellingPrice = parseFloat(product.selling_price) || 0;
        const purchaseTotal = quantity * purchasePrice;
        const sellingTotal = quantity * sellingPrice;
        
        totalPurchase += purchaseTotal;
        totalSelling += sellingTotal;
        totalProfit += (sellingTotal - purchaseTotal);
    });
    
    $('#total-products').text(formatNumber(totalProducts));
    $('#total-purchase').text(formatNumber(totalPurchase));
    $('#total-selling').text(formatNumber(totalSelling));
    
    const profitElement = $('#total-profit');
    const profitValue = formatNumber(totalProfit);
    profitElement.text(profitValue);
    if (totalProfit > 0) {
        profitElement.css('color', '#10b981');
    } else if (totalProfit < 0) {
        profitElement.css('color', '#ef4444');
    } else {
        profitElement.css('color', 'var(--text-light)');
    }
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
        if (typeof loadProducts === 'function' && currentPage) {
            loadProducts();
        }
    }
    
    // Initialize
    if (isDarkMode) {
        document.body.classList.add('dark-mode');
        localStorage.setItem('kurdistan_warehouse_theme', 'dark');
    } else {
        document.body.classList.remove('dark-mode');
        localStorage.setItem('kurdistan_warehouse_theme', 'light');
    }
    
    // Add toggle button after navigation
    $(document).ready(function() {
        const headerDiv = $('.report-header .d-flex');
        if (headerDiv.length && !document.getElementById('darkModeToggle')) {
            const toggleHtml = `<button id="darkModeToggle" class="btn btn-sm btn-light rounded-pill" style="background: rgba(255,255,255,0.2); color: white; border: none;">
                <i class="fas ${document.body.classList.contains('dark-mode') ? 'fa-sun' : 'fa-moon'}"></i>
            </button>`;
            headerDiv.append(toggleHtml);
            
            $('#darkModeToggle').on('click', function() {
                const isDark = document.body.classList.contains('dark-mode');
                if (isDark) {
                    document.body.classList.remove('dark-mode');
                    localStorage.setItem('kurdistan_warehouse_theme', 'light');
                    $(this).html('<i class="fas fa-moon"></i>');
                } else {
                    document.body.classList.add('dark-mode');
                    localStorage.setItem('kurdistan_warehouse_theme', 'dark');
                    $(this).html('<i class="fas fa-sun"></i>');
                }
                loadProducts();
            });
        }
    });
    
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

// ==================== PRODUCT FUNCTIONS ====================
function renderProductsTable(products) {
    const tbody = $('#products-table-body');
    if (!products || products.length === 0) {
        tbody.html(`<tr><td colspan="10" class="text-center py-5"><i class="fas fa-box-open fa-3x text-muted mb-3 d-block"></i><p class="text-muted">هیچ کاڵایەک نەدۆزرایەوە</p></td></tr>`);
        updateStatistics([]);
        return;
    }
    
    let html = '';
    products.forEach((product, index) => {
        const startIndex = (currentPage - 1) * parseInt($('#per-page').val());
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
        let imageUrl = getImageUrl(product.image_producte_path);
        
        html += `<tr class="${rowClass}">
            <td>${rowNumber}</td>
            <td><img src="${escapeHtml(imageUrl)}" class="product-image" alt="${escapeHtml(productName)}" onerror="this.src='data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2240%22%20height%3D%2240%22%20viewBox%3D%220%200%2040%2040%22%3E%3Crect%20width%3D%2240%22%20height%3D%2240%22%20fill%3D%22%23cbd5e1%22%2F%3E%3Ctext%20x%3D%2220%22%20y%3D%2225%22%20text-anchor%3D%22middle%22%20fill%3D%22%234b5563%22%3E${productName.charAt(0)||'?'}%3C%2Ftext%3E%3C%2Fsvg%3E';" onclick="showFullscreenImage('${escapeHtml(imageUrl)}', '${escapeHtml(productName)}')"></td>
            <td><strong>${escapeHtml(productName)}</strong></td>
            <td>${escapeHtml(companyName)}</td>
            <td><span class="stock-badge ${stockClass}">${quantity} ${product.unit === 'piece' ? '' : (product.unit || '')}</span>${quantity < 0 ? '<br><small class="text-danger">لە کۆگا کەمترە</small>' : ''}</td>
            <td>${formatNumber(purchasePrice)}</td>
            <td>${formatNumber(totalPurchase)}</td>
            <td>${formatNumber(sellingPrice)}</td>
            <td>${formatNumber(totalSelling)}</td>
            <td class="${profitClass}">${profitText}</td>
        </tr>`;
    });
    tbody.html(html);
    updateStatistics(products);
}

function renderPagination(response) {
    totalPages = response.last_page || 1;
    currentPage = response.current_page || 1;
    
    if (totalPages <= 1) {
        $('#pagination-nav').html('');
        return;
    }
    
    let paginationHtml = '<ul class="pagination mb-0 flex-wrap">';
    paginationHtml += currentPage > 1 ? `<li class="page-item"><a class="page-link" href="#" data-page="${currentPage - 1}">پێشوو</a></li>` : `<li class="page-item disabled"><span class="page-link">پێشوو</span></li>`;
    
    let startPage = Math.max(1, currentPage - 2);
    let endPage = Math.min(totalPages, currentPage + 2);
    
    if (startPage > 1) {
        paginationHtml += `<li class="page-item"><a class="page-link" href="#" data-page="1">1</a></li>`;
        if (startPage > 2) paginationHtml += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
    }
    
    for (let i = startPage; i <= endPage; i++) {
        paginationHtml += i === currentPage ? `<li class="page-item active"><span class="page-link">${i}</span></li>` : `<li class="page-item"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`;
    }
    
    if (endPage < totalPages) {
        if (endPage < totalPages - 1) paginationHtml += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
        paginationHtml += `<li class="page-item"><a class="page-link" href="#" data-page="${totalPages}">${totalPages}</a></li>`;
    }
    
    paginationHtml += currentPage < totalPages ? `<li class="page-item"><a class="page-link" href="#" data-page="${currentPage + 1}">دواتر</a></li>` : `<li class="page-item disabled"><span class="page-link">دواتر</span></li>`;
    paginationHtml += '</ul>';
    
    $('#pagination-nav').html(paginationHtml);
    
    $('#pagination-nav .page-link').on('click', function(e) {
        e.preventDefault();
        const page = $(this).data('page');
        if (page && page !== currentPage) {
            currentPage = page;
            loadProducts();
            $('html, body').animate({ scrollTop: $('.products-table-container').offset().top - 100 }, 300);
        }
    });
}

function loadProducts() {
    $('#loading-overlay').addClass('active');
    const perPage = $('#per-page').val();
    
    $.ajax({
        url: '/warehouse/report',
        type: 'GET',
        data: {
            page: currentPage,
            per_page: perPage,
            barcode: currentFilters.barcode,
            company: currentFilters.company,
            stock_status: currentFilters.stock_status
        },
        success: function(response) {
            if (response.success) {
                renderProductsTable(response.data || []);
                renderPagination(response);
            } else {
                showError('هەڵەیەک ڕوویدا لە بارکردنی زانیاری');
                $('#products-table-body').html(`<tr><td colspan="10" class="text-center py-5"><i class="fas fa-exclamation-circle fa-3x text-danger mb-3 d-block"></i><p>هەڵەیەک ڕوویدا لە بارکردنی زانیاری</p></td></tr>`);
                updateStatistics([]);
            }
        },
        error: function() {
            showError('هەڵە لە پەیوەندیدا، تکایە دووبارە هەوڵبدەرەوە');
            $('#products-table-body').html(`<tr><td colspan="10" class="text-center py-5"><i class="fas fa-exclamation-circle fa-3x text-danger mb-3 d-block"></i><p>هەڵە لە پەیوەندیدا</p></td></tr>`);
            updateStatistics([]);
        },
        complete: function() {
            $('#loading-overlay').removeClass('active');
        }
    });
}

function applyFilters() {
    currentFilters = {
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
    currentFilters = { barcode: '', company: '', stock_status: '' };
    currentPage = 1;
    loadProducts();
}

// ==================== DOCUMENT READY ====================
$(document).ready(function() {
    imageModal = new bootstrap.Modal(document.getElementById('imageModal'), {
        backdrop: 'static',
        keyboard: true
    });
    
    forceNumericInputForBarcode();
    
    // Initial load
    loadProducts();
    
    // Event listeners
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
    
    // Barcode scanner Enter key
    $('#filter-barcode').on('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            currentPage = 1;
            applyFilters();
        }
    });
    
    // Handle escape key to close scanner
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape' && $('#scannerModal').is(':visible')) {
            closeScanner();
        }
    });
    
    $('#filter-barcode').focus();
});
</script>
@endsection