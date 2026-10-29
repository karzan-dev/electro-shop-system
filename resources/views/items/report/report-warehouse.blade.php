@extends('layouts.navigation')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

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

    .report-header {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border-radius: 1rem 1rem 0 0 !important;
        padding: 1.5rem 2rem;
        transition: all 0.3s ease;
    }

    @media (max-width: 768px) {
        .report-header { padding: 1rem 1.25rem; }
        .report-header h2 { font-size: 1.25rem; }
        .report-header p { font-size: 0.8rem; }
    }

    .filter-section {
        background: var(--card-bg);
        border-radius: 1rem;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
        border: 1px solid var(--border);
        transition: all 0.3s ease;
    }

    @media (max-width: 768px) { .filter-section { padding: 1rem; } }

    .search-input-wrapper { position: relative; flex: 1; min-width: 200px; }

    .search-input-wrapper > i {
        position: absolute; left: 1rem; top: 50%; transform: translateY(-50%);
        color: var(--primary); font-size: 1rem; z-index: 4; pointer-events: none;
    }

    .search-input-wrapper .form-control {
        width: 100%; padding: 0.75rem 1rem; padding-left: 2.5rem; padding-right: 40px;
        border: 2px solid var(--border); border-radius: 12px; transition: all 0.3s;
        background-color: var(--bg-white); color: var(--text); font-size: 0.9rem;
    }

    body.dark-mode .search-input-wrapper .form-control {
        background-color: var(--bg-light); border-color: var(--border); color: var(--text);
    }

    body.dark-mode .search-input-wrapper .form-control::placeholder { color: #64748b; }

    .search-input-wrapper .form-control:focus {
        border-color: var(--primary); outline: none;
        box-shadow: 0 0 0 3px rgba(74, 100, 145, 0.2);
    }

    body.dark-mode .search-input-wrapper .form-control:focus {
        box-shadow: 0 0 0 3px rgba(74, 100, 145, 0.3);
    }

    .search-input-wrapper select.form-control {
        padding-left: 2.5rem; padding-right: 2.5rem;
        appearance: none; -webkit-appearance: none; -moz-appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%234a6491' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat; background-position: right 0.85rem center; background-size: 1em;
    }

    body.dark-mode .search-input-wrapper select.form-control {
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%236c8db8' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
    }

    .search-input-wrapper .camera-search-btn {
        position: absolute; right: 8px; top: 50%; transform: translateY(-50%);
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border: none; color: white; width: 32px; height: 32px; border-radius: 8px;
        cursor: pointer; display: flex; align-items: center; justify-content: center;
        transition: all 0.2s; font-size: 0.85rem;
        box-shadow: 0 2px 6px rgba(74, 100, 145, 0.3); z-index: 5;
    }

    .search-input-wrapper .camera-search-btn:hover {
        transform: translateY(-50%) scale(1.08);
        box-shadow: 0 3px 10px rgba(74, 100, 145, 0.5);
    }

    .search-input-wrapper .camera-search-btn:active { transform: translateY(-50%) scale(0.95); }

    @media (max-width: 768px) {
        .search-input-wrapper .camera-search-btn { width: 28px; height: 28px; font-size: 0.75rem; right: 6px; }
        .search-input-wrapper .form-control { font-size: 0.8rem; padding: 0.5rem 0.75rem 0.5rem 2.5rem; padding-right: 38px; }
        .search-input-wrapper > i { font-size: 0.9rem; left: 0.85rem; }
    }

    .products-table-container {
        background: var(--card-bg); border-radius: 1rem; overflow-x: auto;
        box-shadow: 0 4px 15px var(--shadow); transition: all 0.3s ease;
    }

    .products-table {
        width: 100%; margin-bottom: 0; background-color: var(--table-row-bg); min-width: 900px;
    }

    @media (max-width: 992px) { .products-table { min-width: 800px; } }

    .products-table thead th {
        background: var(--table-header-bg); color: white; font-weight: 600;
        padding: 0.875rem 0.75rem; font-size: 0.85rem; border: none; white-space: nowrap;
    }

    @media (max-width: 768px) {
        .products-table thead th { padding: 0.6rem 0.5rem; font-size: 0.75rem; }
    }

    .products-table tbody tr { background-color: var(--table-row-bg); transition: background-color 0.2s ease; }
    .products-table tbody tr:nth-child(even) { background-color: var(--table-row-alt-bg); }

    .products-table tbody td {
        padding: 0.75rem 0.75rem; vertical-align: middle;
        border-bottom: 1px solid var(--border); font-size: 0.85rem;
        color: var(--text); background-color: inherit;
    }

    @media (max-width: 768px) {
        .products-table tbody td { padding: 0.5rem; font-size: 0.75rem; }
    }

    .products-table tbody tr:hover { background: var(--table-hover) !important; }

    .warning-row, body.dark-mode .warning-row {
        background-color: rgba(245, 158, 11, 0.15) !important;
        border-right: 3px solid #f59e0b;
    }

    .danger-row, body.dark-mode .danger-row {
        background-color: rgba(239, 68, 68, 0.15) !important;
        border-right: 3px solid #ef4444;
    }

    .critical-row, body.dark-mode .critical-row {
        background-color: rgba(220, 38, 38, 0.2) !important;
        border-right: 3px solid #dc2626;
        animation: pulse 2s infinite;
    }

    .warning-row td, .danger-row td, .critical-row td { background-color: transparent !important; }

    @keyframes pulse {
        0% { background-color: rgba(220, 38, 38, 0.2); }
        50% { background-color: rgba(220, 38, 38, 0.4); }
        100% { background-color: rgba(220, 38, 38, 0.2); }
    }

    .stock-badge {
        display: inline-block; padding: 0.2rem 0.6rem; border-radius: 2rem;
        font-size: 0.75rem; font-weight: 600; white-space: nowrap;
    }

    @media (max-width: 768px) { .stock-badge { font-size: 0.65rem; padding: 0.15rem 0.45rem; } }

    .stock-normal { background: #d1fae5; color: #065f46; }
    body.dark-mode .stock-normal { background: #065f46; color: #d1fae5; }

    .stock-low { background: #fed7aa; color: #92400e; }
    body.dark-mode .stock-low { background: #92400e; color: #fed7aa; }

    .stock-out { background: #fee2e2; color: #991b1b; }
    body.dark-mode .stock-out { background: #7f1d1d; color: #fecaca; }

    .stock-negative { background: #fecaca; color: #7f1d1d; }
    body.dark-mode .stock-negative { background: #7f1d1d; color: #fecaca; }

    .stock-critical { background: #dc2626; color: white; }

    .pagination-container {
        padding: 1rem 1.25rem; background: var(--card-bg);
        border-top: 1px solid var(--border); display: flex;
        justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;
    }

    @media (max-width: 768px) {
        .pagination-container { flex-direction: column; justify-content: center; }
    }

    .btn-reset {
        background: var(--border); color: var(--text); border: none;
        padding: 0.5rem 1.25rem; border-radius: 0.75rem; font-weight: 600;
        transition: all 0.3s ease; font-size: 0.85rem;
    }

    @media (max-width: 768px) {
        .btn-reset { padding: 0.4rem 1rem; font-size: 0.75rem; width: 100%; }
    }

    .btn-reset:hover { background: var(--text-light); color: white; }

    .per-page-select {
        width: auto; display: inline-block; border-radius: 0.5rem;
        border: 1px solid var(--border); padding: 0.25rem 0.5rem;
        background-color: var(--bg-white); color: var(--text); font-size: 0.85rem;
    }

    .loading-overlay {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.5); z-index: 9999;
        display: flex; align-items: center; justify-content: center; visibility: hidden;
    }

    .loading-overlay.active { visibility: visible; }

    .loading-spinner {
        background: var(--card-bg); padding: 1.5rem; border-radius: 1rem;
        text-align: center; color: var(--text); box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .btn-add-to-store {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white; border: none; padding: 0.35rem 0.7rem;
        border-radius: 0.5rem; font-size: 0.7rem; font-weight: 600;
        transition: all 0.3s ease; cursor: pointer; margin-right: 0.25rem; white-space: nowrap;
    }

    @media (max-width: 768px) {
        .btn-add-to-store { font-size: 0.65rem; padding: 0.3rem 0.5rem; }
    }

    .btn-add-to-store:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .btn-add-to-list {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white; border: none; padding: 0.35rem 0.7rem;
        border-radius: 0.5rem; font-size: 0.7rem; font-weight: 600;
        transition: all 0.3s ease; cursor: pointer; white-space: nowrap;
    }

    @media (max-width: 768px) {
        .btn-add-to-list { font-size: 0.65rem; padding: 0.3rem 0.5rem; }
    }

    .btn-add-to-list:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }

    .btn-show-list {
        background: linear-gradient(135deg, var(--warning), #d97706);
        color: white; border: none; padding: 0.5rem 1rem;
        border-radius: 0.75rem; font-weight: 600;
        transition: all 0.3s ease; margin-bottom: 1rem; font-size: 0.85rem;
    }

    @media (max-width: 768px) {
        .btn-show-list { font-size: 0.75rem; padding: 0.4rem 0.8rem; width: 100%; }
    }

    .btn-show-list:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
        color: white;
    }

    .action-buttons { display: flex; gap: 0.25rem; flex-wrap: wrap; }

    .list-badge {
        display: inline-block; background: var(--primary); color: white;
        padding: 0.15rem 0.4rem; border-radius: 0.5rem;
        font-size: 0.6rem; margin-left: 0.3rem; white-space: nowrap;
    }

    .voucher-badge {
        display: inline-block; background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        color: white; padding: 0.2rem 0.6rem; border-radius: 0.5rem;
        font-size: 0.7rem; font-weight: 600; white-space: nowrap;
    }

    body.dark-mode .voucher-badge {
        background: linear-gradient(135deg, #a78bfa, #8b5cf6);
    }

    .product-image {
        width: 40px; height: 40px; object-fit: cover; border-radius: 0.5rem;
        cursor: pointer; transition: transform 0.2s ease;
        border: 1px solid var(--border); display: block;
    }

    @media (max-width: 768px) { .product-image { width: 32px; height: 32px; } }

    .product-image:hover {
        transform: scale(1.1); box-shadow: 0 4px 12px var(--shadow);
    }

    .critical-items-container { max-height: 60vh; overflow-y: auto; }

    .critical-item {
        display: flex; align-items: center; gap: 1rem;
        padding: 1rem; border-bottom: 1px solid var(--border);
        transition: background 0.2s ease; background-color: var(--card-bg); flex-wrap: wrap;
    }

    @media (max-width: 768px) {
        .critical-item { flex-direction: column; text-align: center; gap: 0.5rem; }
        .critical-item-quantity { width: 100%; }
    }

    .critical-item:hover { background: var(--table-hover); }

    .critical-item-image {
        width: 50px; height: 50px; object-fit: cover; border-radius: 0.75rem;
        border: 1px solid var(--border); cursor: pointer; display: block;
    }

    @media (max-width: 768px) {
        .critical-item-image { width: 60px; height: 60px; }
    }

    .critical-item-info { flex: 1; }

    .critical-item-name {
        font-weight: 600; color: var(--text); margin-bottom: 0.25rem;
    }

    .critical-item-company { font-size: 0.8rem; color: var(--text-light); }

    .critical-item-requested {
        margin-top: 0.4rem; font-size: 0.85rem; color: var(--info);
        font-weight: 500;
    }

    .critical-item-quantity { text-align: center; min-width: 70px; }

    .quantity-badge {
        display: inline-block; background: #dc2626; color: white;
        padding: 0.2rem 0.6rem; border-radius: 2rem;
        font-size: 0.85rem; font-weight: 600;
    }

    .empty-critical { text-align: center; padding: 2rem; color: var(--text-light); }

    .btn-delete-from-list {
        background: transparent; border: 1px solid #ef4444; color: #ef4444;
        padding: 0.3rem 0.5rem; border-radius: 0.5rem; font-size: 0.75rem;
        cursor: pointer; transition: all 0.2s ease; white-space: nowrap;
    }

    .btn-delete-from-list:hover { background: #ef4444; color: white; }

    body.dark-mode .btn-delete-from-list { border-color: #f87171; color: #f87171; }
    body.dark-mode .btn-delete-from-list:hover { background: #f87171; color: white; }

    .modal-content {
        background-color: var(--modal-bg); color: var(--text);
        border: 1px solid var(--border); box-shadow: none !important;
    }
    .modal-dialog { box-shadow: none !important; }
    .modal-header { border-bottom-color: var(--border); }
    .modal-footer { border-top-color: var(--border); }
    .modal-header .btn-close { filter: invert(1); }
    body.dark-mode .modal-header .btn-close { filter: invert(1) brightness(2); }
    .form-control, .form-select {
        background-color: var(--bg-white); color: var(--text); border-color: var(--border);
    }
    .form-control:focus, .form-select:focus {
        background-color: var(--bg-white); color: var(--text); border-color: var(--primary);
    }
    .form-control[readonly] { background-color: var(--border); color: var(--text-light); }
    .alert-info {
        background-color: rgba(59, 130, 246, 0.2); color: var(--info); border-color: var(--info);
    }
    .form-control::placeholder { color: var(--text-light); }

    #addAmountModal .modal-content,
    #addToListModal .modal-content,
    #criticalListModal .modal-content,
    #imageModal .modal-content,
    #barcodeScannerModal .modal-content,
    #confirmDeleteModal .modal-content { box-shadow: none !important; }

    .modal-header .btn-close {
        z-index: 10; position: relative; opacity: 0.9; transition: opacity 0.2s ease;
    }
    .modal-header .btn-close:hover { opacity: 1; }

    .pagination .page-item .page-link {
        background-color: var(--card-bg); border-color: var(--border);
        color: var(--text); font-size: 0.8rem; padding: 0.4rem 0.7rem;
    }

    @media (max-width: 768px) {
        .pagination .page-item .page-link { padding: 0.3rem 0.5rem; font-size: 0.7rem; }
    }

    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border-color: var(--primary); color: white;
    }
    .pagination .page-item.disabled .page-link {
        background-color: var(--card-bg); border-color: var(--border); color: var(--text-light);
    }

    .scanner-modal .modal-content {
        background: #000; border-radius: 1rem; overflow: hidden; box-shadow: none !important;
    }

    .scanner-modal .modal-header {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white; border-bottom: none;
    }

    .scanner-modal .btn-close { filter: invert(1); }

    #qr-reader { width: 100%; border-radius: 0; overflow: hidden; }

    #qr-reader video {
        width: 100% !important; min-height: 400px; object-fit: cover;
    }

    @media (max-width: 768px) {
        #qr-reader video { min-height: 300px; }
        .scanner-modal .modal-dialog { margin: 0.5rem; }
        .scanner-modal .modal-body { min-height: 300px !important; }
        .scanner-modal .modal-footer { flex-wrap: wrap; }
        .scanner-modal .modal-footer .btn { width: 100%; }
    }

    .fullscreen-image-modal .modal-content {
        background: rgba(0, 0, 0, 0.95); border: none; border-radius: 0; box-shadow: none !important;
    }

    .fullscreen-image-modal .modal-body {
        padding: 0; display: flex; justify-content: center; align-items: center; min-height: 100vh;
    }

    .fullscreen-image-modal img {
        max-width: 100%; max-height: 100vh; object-fit: contain; cursor: zoom-out;
    }

    .fullscreen-image-modal .btn-close {
        position: absolute; top: 20px; right: 20px; z-index: 10;
        filter: invert(1); width: 40px; height: 40px; opacity: 0.8;
    }

    .fullscreen-image-modal .btn-close:hover { opacity: 1; }

    @media (max-width: 768px) {
        .fullscreen-image-modal .btn-close { top: 10px; right: 10px; width: 35px; height: 35px; }
    }

    .alert-custom {
        border-radius: 12px; padding: 1rem 1.2rem; margin-bottom: 1rem;
        display: flex; align-items: flex-start; gap: 0.8rem;
        animation: slideDown 0.3s ease-out; position: relative;
        overflow: hidden; word-wrap: break-word;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        min-width: 280px; max-width: 500px;
    }

    .alert-custom .alert-close {
        background: none; border: none; font-size: 1rem; cursor: pointer;
        opacity: 0.7; flex-shrink: 0; margin-left: auto;
        color: inherit; padding: 0; line-height: 1;
    }

    .alert-custom .alert-close:hover { opacity: 1; }
    .alert-custom > div { flex: 1; min-width: 0; }

    .alert-success-custom {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        color: #065f46; border-left: 5px solid #10b981;
    }
    .alert-error-custom {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        color: #991b1b; border-left: 5px solid #ef4444;
    }
    .alert-warning-custom {
        background: linear-gradient(135deg, #fed7aa, #fdba74);
        color: #92400e; border-left: 5px solid #f59e0b;
    }
    .alert-info-custom {
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        color: #1e3a8a; border-left: 5px solid #3b82f6;
    }

    body.dark-mode .alert-success-custom {
        background: linear-gradient(135deg, #064e3b, #065f46);
        color: #a7f3d0; border-left-color: #34d399; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
    }
    body.dark-mode .alert-error-custom {
        background: linear-gradient(135deg, #7f1d1d, #991b1b);
        color: #fecaca; border-left-color: #f87171; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
    }
    body.dark-mode .alert-warning-custom {
        background: linear-gradient(135deg, #78350f, #92400e);
        color: #fde68a; border-left-color: #fbbf24; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
    }
    body.dark-mode .alert-info-custom {
        background: linear-gradient(135deg, #1e3a8a, #1e40af);
        color: #bfdbfe; border-left-color: #60a5fa; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 576px) {
        .position-fixed.alert-custom, .position-fixed.alert {
            width: calc(100% - 20px) !important; left: 10px !important;
            right: 10px !important; transform: none !important; top: 10px !important;
            min-width: auto !important; max-width: none !important;
            font-size: 0.85rem; padding: 0.85rem 1rem;
        }
        .position-fixed.alert-custom i, .position-fixed.alert i { font-size: 1rem !important; }
    }

    #confirmDeleteModal .modal-content {
        border-radius: 1rem; background-color: var(--card-bg);
        color: var(--text); border: 1px solid var(--border); box-shadow: none !important;
    }
    body.dark-mode #confirmDeleteModal .modal-content { background-color: #1e293b; }
    #confirmDeleteModal .modal-title { color: var(--text); }
    body.dark-mode #confirmDeleteModal .modal-title { color: #e2e8f0; }
    #confirmDeleteModal .btn-secondary { background: var(--border); color: var(--text); border: none; }
    body.dark-mode #confirmDeleteModal .btn-secondary { background: #475569; color: #e2e8f0; }
    #confirmDeleteModal .btn-danger {
        background: linear-gradient(135deg, #ef4444, #dc2626); border: none; color: white;
    }

    @media (max-width: 576px) {
        #confirmDeleteModal .modal-dialog { margin: 0.75rem; }
        #confirmDeleteModal .modal-footer { flex-direction: column; gap: 8px; }
        #confirmDeleteModal .modal-footer .btn { width: 100%; }
    }

    @media (max-width: 768px) {
        .products-table-container {
            background: transparent !important; box-shadow: none !important;
            border-radius: 0; overflow: visible;
        }
        .products-table { min-width: 100% !important; }
        .products-table thead { display: none; }
        .products-table, .products-table tbody, .products-table tr, .products-table td {
            display: block; width: 100%;
        }
        .products-table tr {
            background: var(--card-bg) !important; border-radius: 12px;
            margin-bottom: 12px; padding: 12px;
            box-shadow: 0 2px 8px var(--shadow);
            border: 1px solid var(--border) !important; border-right: none !important;
        }
        .products-table tr.warning-row { border-right: 4px solid #f59e0b !important; }
        .products-table tr.danger-row { border-right: 4px solid #ef4444 !important; }
        .products-table tr.critical-row { border-right: 4px solid #dc2626 !important; animation: none; }
        .products-table tbody td {
            border: none !important; padding: 6px 0 !important; text-align: right;
            display: flex; justify-content: space-between; align-items: center;
            font-size: 0.8rem; background-color: transparent !important;
        }
        .products-table tbody td:before {
            content: attr(data-label); font-weight: 700; color: var(--primary);
            margin-left: 10px; flex-shrink: 0; font-size: 0.75rem;
        }
        body.dark-mode .products-table tbody td:before { color: #94a3b8; }
        .products-table tbody td:first-child {
            justify-content: center; padding-bottom: 10px !important;
            border-bottom: 1px solid var(--border) !important; margin-bottom: 8px;
        }
        .products-table tbody td:first-child:before { display: none; }
        .products-table .product-image { width: 70px; height: 70px; }
        .products-table .action-buttons {
            flex-direction: column; gap: 6px; margin-top: 10px;
            padding-top: 10px; border-top: 1px solid var(--border); width: 100%;
        }
        .products-table .action-buttons:before { display: none !important; }
        .products-table .btn-add-to-store, .products-table .btn-add-to-list {
            width: 100%; padding: 10px; font-size: 0.8rem; margin: 0;
        }
        .critical-list-modal .modal-dialog { margin: 0.5rem; }
        .critical-list-modal .modal-footer { flex-direction: column; gap: 8px; }
        .critical-list-modal .modal-footer .btn { width: 100%; }
        .modal-dialog { margin: 0.5rem; }
        .modal-footer { flex-direction: column; gap: 8px; }
        .modal-footer .btn { width: 100%; }
    }

    @media (max-width: 480px) {
        .products-table tr { padding: 10px; margin-bottom: 10px; }
        .products-table tbody td { font-size: 0.75rem; }
        .products-table tbody td:before { font-size: 0.7rem; }
        .products-table .product-image { width: 60px; height: 60px; }
        .stock-badge { font-size: 0.65rem; padding: 0.15rem 0.5rem; }
    }

    @media (max-width: 768px) {
        button, .btn, input, select, a {
            -webkit-tap-highlight-color: transparent; touch-action: manipulation;
        }
        .btn:active { transform: scale(0.98); }
    }

    @media (max-width: 768px) {
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: var(--bg-light); border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: var(--primary); border-radius: 10px; }
    }

    @media print {
        .dark-mode-toggle, .btn-show-list, .filter-section, .pagination-container,
        .action-buttons, .btn-add-to-store, .btn-add-to-list, .no-print { display: none !important; }
        .products-table-container { box-shadow: none; overflow-x: visible; }
        .products-table thead th {
            background: #4a6491 !important;
            -webkit-print-color-adjust: exact; print-color-adjust: exact;
        }
        body, body.dark-mode { background: white; color: black; }
        .products-table tbody tr { background-color: white !important; }
        .products-table tbody td { color: black !important; }
    }

    #filter-barcode::placeholder { padding-right: 6px; }
</style>

<div class="container-fluid py-3 py-md-4">
    <div class="report-header text-white mb-3 mb-md-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h2 class="mb-1 mb-md-2">
                    <i class="fas fa-chart-line me-2"></i>
                    ڕەوشی کۆگا
                </h2>
                <p class="mb-0 opacity-75">
                    <i class="fas fa-boxes me-1"></i>
                    بینینی هەموو کاڵاکانی کۆگا
                </p>
            </div>
        </div>
    </div>

    <div class="mb-3 no-print">
        <button class="btn-show-list w-100 w-md-auto" id="openCriticalListBtn" type="button">
            <i class="fas fa-exclamation-triangle me-2"></i>
            لیستی ئەو کاڵایانەی کە لە ٣ کەمترن (کەمترین بڕ)
        </button>
    </div>

    <!-- Filter Section -->
    <div class="filter-section no-print">
        <div class="row g-2 g-md-3">
            <div class="col-12 col-md-2">
                <div class="search-input-wrapper">
                    <i class="fas fa-barcode"></i>
                    <input type="text" id="filter-barcode" class="form-control" placeholder="بارکۆد ..." autocomplete="off">
                    <button type="button" id="scan-barcode-filter-btn" class="camera-search-btn" title="سکانکردنی بارکۆد">
                        <i class="fas fa-camera"></i>
                    </button>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="search-input-wrapper">
                    <i class="fas fa-user-tie"></i>
                    <input type="text" id="filter-voucher" class="form-control" placeholder="ناوی فرۆشیار ..." autocomplete="off">
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="search-input-wrapper">
                    <i class="fas fa-building"></i>
                    <input type="text" id="filter-company" class="form-control" placeholder="ناوی کۆمپانیا ..." autocomplete="off">
                </div>
            </div>
            <div class="col-12 col-md-2">
                <div class="search-input-wrapper">
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
            <div class="col-12 col-md-2">
                <button class="btn-reset w-100" id="resetFiltersBtn" type="button">
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
                        <th style="min-width: 70px;">وێنە</th>
                        <th style="min-width: 120px;">ناوی کاڵا</th>
                        <th style="min-width: 100px;">کۆمپانیا</th>
                        <th style="min-width: 120px;">ناوی فرۆشیار</th>
                        <th style="min-width: 70px;">بڕ</th>
                        <th style="min-width: 80px;">نرخی کڕین</th>
                        <th style="min-width: 80px;">نرخی فرۆشتن</th>
                        <th style="min-width: 140px;" class="no-print">کردار</th>
                    </tr>
                </thead>
                <tbody id="products-table-body">
                    <tr>
                        <td colspan="8" class="text-center py-5">
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
                <select id="per-page" class="per-page-select" aria-label="کاڵا لە لاپەڕە">
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
                        <i class="fas fa-check me-1"></i> زیادکردن بۆ دوکان
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- داواکاری کاڵا -->
<div class="modal fade" id="addToListModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8); color: white;">
                <h5 class="modal-title">
                    <i class="fas fa-clipboard-list me-2"></i>
                    داواکاری کاڵا
                </h5>
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
                    <div class="mb-3">
                        <label class="form-label">ژمارەی کاڵای داواکراو</label>
                        <input type="number" id="list-request-quantity" class="form-control" required min="1" placeholder="ژمارە داخڵ بکە" value="1">
                    </div>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        ئەم داواکارییە تۆمار دەکرێت بۆ دابینکردنی کاڵاکە
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">داخستن</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-1"></i> ناردنی داواکاری
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
                <button type="button" class="btn btn-danger" id="printCriticalListBtn">
                    <i class="fas fa-print me-1"></i> Print
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Fullscreen Image Modal -->
<div class="modal fade fullscreen-image-modal" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header" style="border: none; background: transparent; position: absolute; top: 0; right: 0; z-index: 10;">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <img id="fullscreen-image" src="" alt="وێنەی گەورەی کاڵا">
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

<!-- Loading Overlay -->
<div id="loading-overlay" class="loading-overlay">
    <div class="loading-spinner">
        <i class="fas fa-spinner fa-spin fa-2x text-primary mb-2"></i>
        <p class="mb-0">تکایە چاوەڕێ بە...</p>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
(function() {
    'use strict';

    // ==================== CONSTANTS ====================
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
    const URLS = {
        report:        '/warehouse/report',
        criticalList:  '/warehouse/critical-list',
        addToStore:    '/warehouse/add-to-store',
        addToCritical: '/warehouse/add-to-critical-list',
        deleteCritical: '/warehouse/delete-from-critical-list'
    };
    const PLACEHOLDER_IMG = 'data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2240%22%20height%3D%2240%22%20viewBox%3D%220%200%2040%2040%22%3E%3Crect%20width%3D%2240%22%20height%3D%2240%22%20fill%3D%22%23cbd5e1%22%2F%3E%3Ctext%20x%3D%2220%22%20y%3D%2225%22%20text-anchor%3D%22middle%22%20fill%3D%22%234b5563%22%20font-size%3D%2216%22%3E%3F%3C%2Ftext%3E%3C%2Fsvg%3E';

    // ==================== STATE ====================
    const state = {
        currentPage: 1,
        totalPages: 1,
        filters: { name: '', barcode: '', company: '', voucher: '', stock_status: '' },
        debounceTimer: null,
        currentProductsData: [],
        criticalProductsCache: [],
        html5QrCode: null,
        scannerStarting: false,
        deleteContext: { id: null, name: null }
    };

    const modals = {};

    // ==================== HELPERS ====================
    function toEnglishNumbers(str) {
        if (!str) return str;
        const persianNumbers = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
        const arabicNumbers  = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        const englishNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        let result = String(str);
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
        return toEnglishNumbers(value).replace(/[^0-9]/g, '');
    }

    // ✅ FIX: Preserve 2 decimals for prices
    function formatNumber(num, decimals = 0) {
        if (num === null || num === undefined || isNaN(num)) {
            return decimals > 0 ? (0).toFixed(decimals) : '0';
        }
        return Number(num).toLocaleString(undefined, {
            minimumFractionDigits: decimals,
            maximumFractionDigits: decimals
        });
    }

    function escapeHtml(text) {
        if (text === null || text === undefined) return '';
        return String(text).replace(/[&<>"']/g, function(m) {
            if (m === '&') return '&amp;';
            if (m === '<') return '&lt;';
            if (m === '>') return '&gt;';
            if (m === '"') return '&quot;';
            if (m === "'") return '&#39;';
            return m;
        });
    }

    function getImageUrl(imagePath) {
        if (!imagePath) return PLACEHOLDER_IMG;
        if (imagePath.startsWith('http')) return imagePath;
        if (imagePath.startsWith('/')) return imagePath;
        return '/' + imagePath;
    }

    function onImageError(img) {
        img.onerror = null;
        img.src = PLACEHOLDER_IMG;
    }

    // ✅ FIX: Use data attributes instead of inline onclick for safety
    function buildImageTag(imageUrl, productName, extraClass) {
        return `<img src="${escapeHtml(imageUrl)}" class="${extraClass}" alt="${escapeHtml(productName)}" data-image-url="${escapeHtml(imageUrl)}" onerror="window.__reportPage.onImageError(this)">`;
    }

    // ==================== ALERTS ====================
    function showAlert(type, message) {
        const icons = {
            success: 'fa-check-circle',
            error:   'fa-exclamation-circle',
            warning: 'fa-exclamation-triangle',
            info:    'fa-info-circle'
        };
        const classes = {
            success: 'alert-success-custom',
            error:   'alert-error-custom',
            warning: 'alert-warning-custom',
            info:    'alert-info-custom'
        };
        const icon = icons[type] || icons.info;
        const cls  = classes[type] || classes.info;

        const html = `
            <div class="alert alert-custom ${cls} alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3"
                 style="z-index: 10000;" role="alert">
                <i class="fas ${icon}" style="font-size: 1.2rem;"></i>
                <div>${escapeHtml(message)}</div>
                <button type="button" class="alert-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>`;
        const $alert = $(html);
        $('body').append($alert);
        $alert.find('.alert-close').on('click', function() {
            $alert.fadeOut(300, function() { $(this).remove(); });
        });
        setTimeout(() => $alert.fadeOut(300, function() { $(this).remove(); }), 3500);
    }

    const showError   = (m) => showAlert('error', m);
    const showSuccess = (m) => showAlert('success', m);
    const showWarning = (m) => showAlert('warning', m);

    // ==================== IMAGE MODAL ====================
    function showFullscreenImage(imageUrl) {
        if (!imageUrl || imageUrl === '' || imageUrl === '/' || imageUrl === PLACEHOLDER_IMG) return;
        document.getElementById('fullscreen-image').src = imageUrl;
        modals.image.show();
    }

    // ==================== DARK MODE ====================
    (function initDarkMode() {
        const savedTheme = localStorage.getItem('kurdistan_warehouse_theme');
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        const isDark = savedTheme === 'dark' || (savedTheme === null && prefersDark);
        document.body.classList.toggle('dark-mode', isDark);
        if (savedTheme === null) {
            localStorage.setItem('kurdistan_warehouse_theme', isDark ? 'dark' : 'light');
        }
    })();

    // ==================== BARCODE INPUT ====================
    function forceNumericInputForBarcode() {
        const barcodeInput = document.getElementById('filter-barcode');
        if (!barcodeInput) return;

        barcodeInput.addEventListener('input', function() {
            const rawValue = this.value;
            const numericValue = toEnglishNumbers(rawValue).replace(/[^0-9]/g, '');
            if (rawValue !== numericValue) this.value = numericValue;
        });

        barcodeInput.addEventListener('keydown', function(e) {
            const allowedKeys = ['Backspace', 'Delete', 'Tab', 'Escape', 'Enter',
                'ArrowLeft', 'ArrowRight', 'ArrowUp', 'ArrowDown', 'Home', 'End'];
            if (allowedKeys.includes(e.key)) return;
            if (e.ctrlKey && ['a', 'c', 'v', 'x'].includes(e.key.toLowerCase())) return;
            const ok = /^[0-9]$/.test(e.key) || /^[٠١٢٣٤٥٦٧٨٩]$/.test(e.key) || /^[۰۱۲۳۴۵۶۷۸۹]$/.test(e.key);
            if (!ok) e.preventDefault();
        });

        barcodeInput.addEventListener('paste', function(e) {
            e.preventDefault();
            const pasted = (e.clipboardData || window.clipboardData).getData('text');
            this.value = toEnglishNumbers(pasted).replace(/[^0-9]/g, '');
            this.dispatchEvent(new Event('input', { bubbles: true }));
        });
    }

    // ==================== BARCODE SCANNER ====================
    async function startBarcodeScanner() {
        if (state.scannerStarting) return;
        state.scannerStarting = true;

        try {
            if (state.html5QrCode) {
                try {
                    if (state.html5QrCode.isScanning) await state.html5QrCode.stop();
                    await state.html5QrCode.clear();
                } catch (e) { /* ignore */ }
            }

            const qrReader = document.getElementById('qr-reader');
            if (!qrReader) return;

            state.html5QrCode = new Html5Qrcode("qr-reader");
            const config = { fps: 10, qrbox: { width: 250, height: 200 }, aspectRatio: 1.0 };

            await state.html5QrCode.start(
                { facingMode: "environment" },
                config,
                (decodedText) => {
                    const normalizedBarcode = cleanBarcodeValue(decodedText);
                    stopBarcodeScanner();
                    modals.scanner.hide();
                    $('#filter-barcode').val(normalizedBarcode).trigger('input');
                    $('#filter-barcode').focus();
                    showSuccess('بارکۆد سکان کرا: ' + normalizedBarcode);
                },
                () => { /* per-frame errors ignored */ }
            );
        } catch (err) {
            console.error('Error starting scanner:', err);
            showError('ناتوانرێت کامێرا بۆ سکانکردن بکرێتەوە.');
            modals.scanner.hide();
        } finally {
            state.scannerStarting = false;
        }
    }

    async function stopBarcodeScanner() {
        if (state.html5QrCode && state.html5QrCode.isScanning) {
            try {
                await state.html5QrCode.stop();
                await state.html5QrCode.clear();
            } catch (e) {
                console.error('Error stopping scanner:', e);
            }
        }
    }

    // ==================== CRITICAL LIST ====================
    function renderCriticalList(products) {
        if (!products || products.length === 0) {
            $('#critical-items-container').html(`
                <div class="empty-critical">
                    <i class="fas fa-check-circle fa-3x text-success mb-3 d-block"></i>
                    <p class="mb-0">هیچ کاڵایەکی کەم نییە</p>
                </div>
            `);
            return;
        }

        const html = products.map((product) => {
            const quantity     = product.counter || 0;
            const requestedQty = product.requested_quantity || 0;
            const companyName  = product.company_name || product.company || 'بێ کۆمپانیا';
            const productName  = product.product_name || product.name || 'بێ ناو';
            const voucherName  = product.voucher_name || '';
            const imageUrl     = getImageUrl(product.image_producte_path);

            return `
                <div class="critical-item">
                    ${buildImageTag(imageUrl, productName, 'critical-item-image')}
                    <div class="critical-item-info">
                        <div class="critical-item-name">
                            ${escapeHtml(productName)}
                            ${requestedQty > 0 ? '<span class="list-badge ps-2"><i class="fas fa-clipboard-list"></i> داواکاری هەیە</span>' : ''}
                        </div>
                        <div class="critical-item-company">
                            <i class="fas fa-building ms-2"></i>${escapeHtml(companyName)}
                            ${voucherName ? `<span class="voucher-badge ms-2"><i class="fas fa-user-tie me-1"></i>${escapeHtml(voucherName)}</span>` : ''}
                        </div>
                        ${requestedQty > 0 ? `
                        <div class="critical-item-requested">
                            <i class="fas fa-paper-plane ms-2"></i>
                            ژمارەی داواکراو: <strong>${requestedQty}</strong>
                        </div>` : ''}
                    </div>
                    <div class="critical-item-quantity">
                        <span class="quantity-badge">${quantity}</span>
                        <div style="font-size: 0.7rem; color: var(--text-light); margin-top: 0.25rem;">لە کۆگا</div>
                    </div>
                    <button type="button" class="btn-delete-from-list"
                            data-delete-id="${product.product_id}"
                            data-delete-name="${escapeHtml(productName)}"
                            title="سڕینەوە لە لیست">
                        <i class="fas fa-trash"></i> سڕینەوە
                    </button>
                </div>`;
        }).join('');

        $('#critical-items-container').html(html);
    }

    function confirmDeleteFromCriticalList(productId, productName) {
        state.deleteContext = { id: productId, name: productName };

        const html = `
        <div class="modal fade" id="confirmDeleteModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content border-0">
                    <div class="modal-header border-0 pb-0" style="background: transparent;">
                        <h6 class="modal-title w-100 text-center">
                            <i class="fas fa-exclamation-triangle text-warning fa-2x mb-3 d-block"></i>
                            دڵنیایت لە سڕینەوە؟
                        </h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center pt-2">
                        <p class="mb-1 fw-bold" style="font-size: 1rem; color: var(--danger);">${escapeHtml(productName)}</p>
                        <p class="mb-0" style="font-size: 0.85rem; color: var(--text-light);">لە لیستی کاڵا کەمەکان دەسڕێتەوە</p>
                    </div>
                    <div class="modal-footer border-0 justify-content-center pt-0">
                        <button type="button" class="btn btn-secondary btn-sm px-4" data-bs-dismiss="modal" style="border-radius: 0.5rem;">
                            <i class="fas fa-times me-1"></i> پاشگەزبوونەوە
                        </button>
                        <button type="button" class="btn btn-danger btn-sm px-4" id="confirmDeleteBtn" style="border-radius: 0.5rem;">
                            <i class="fas fa-trash me-1"></i> سڕینەوە
                        </button>
                    </div>
                </div>
            </div>
        </div>`;

        $('#confirmDeleteModal').remove();
        $('body').append(html);

        const confirmModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
        confirmModal.show();

        $('#confirmDeleteBtn').off('click').on('click', function() {
            confirmModal.hide();
            doDeleteFromCriticalList(productId);
        });

        document.getElementById('confirmDeleteModal').addEventListener('hidden.bs.modal', function() {
            $(this).remove();
        }, { once: true });
    }

    function doDeleteFromCriticalList(productId) {
        $('#loading-overlay').addClass('active');
        $.ajax({
            url: URLS.deleteCritical,
            type: 'POST',
            data: { product_id: productId, _token: CSRF_TOKEN },
            success: function(response) {
                if (response.success) {
                    showSuccess('کاڵاکە بە سەرکەوتوویی لە لیست سڕایەوە');
                    loadCriticalProducts();
                    loadProducts();
                } else {
                    showError(response.message || 'هەڵەیەک ڕوویدا');
                }
            },
            error: function(xhr) {
                showError(xhr.responseJSON?.message || 'هەڵە لە سڕینەوەی کاڵا');
            },
            complete: function() {
                $('#loading-overlay').removeClass('active');
            }
        });
    }

    function openCriticalListModal() {
        modals.criticalList.show();
        loadCriticalProducts();
    }

    function loadCriticalProducts() {
        $('#critical-items-container').html(`
            <div class="text-center py-5">
                <i class="fas fa-spinner fa-spin fa-2x text-warning"></i>
                <p class="mt-2">بارکردنی زانیاری...</p>
            </div>
        `);

        $.ajax({
            url: URLS.criticalList,
            type: 'GET',
            success: function(response) {
                if (response.success && response.data && response.data.length > 0) {
                    state.criticalProductsCache = response.data;
                    renderCriticalList(response.data);
                } else {
                    state.criticalProductsCache = [];
                    $('#critical-items-container').html(`
                        <div class="empty-critical">
                            <i class="fas fa-check-circle fa-3x text-success mb-3 d-block"></i>
                            <p class="mb-0">هیچ کاڵایەک بە کەمتر لە 3 نییە</p>
                        </div>
                    `);
                }
            },
            error: function() {
                state.criticalProductsCache = [];
                $('#critical-items-container').html(`
                    <div class="empty-critical">
                        <i class="fas fa-exclamation-circle fa-3x text-danger mb-3 d-block"></i>
                        <p class="mb-0">هەڵەیەک ڕوویدا لە بارکردنی زانیاری</p>
                    </div>
                `);
            }
        });
    }

    // ==================== PRODUCTS TABLE ====================
    function renderProductsTable(products) {
        const $tbody = $('#products-table-body');

        if (!products || products.length === 0) {
            $tbody.html(`<tr><td colspan="8" class="text-center py-5">
                <i class="fas fa-box-open fa-3x text-muted mb-3 d-block"></i>
                <p class="text-muted">هیچ کاڵایەک نەدۆزرایەوە</p>
            </td></tr>`);
            return;
        }

        const html = products.map((product) => {
            const quantity     = product.counter || 0;
            const purchasePrice = parseFloat(product.purchase_price) || 0;
            const sellingPrice  = parseFloat(product.selling_price) || 0;

            let stockClass = '', rowClass = '';
            if (quantity < 0)       { stockClass = 'stock-negative'; rowClass = 'danger-row'; }
            else if (quantity === 0){ stockClass = 'stock-out';      rowClass = 'danger-row'; }
            else if (quantity < 3)  { stockClass = 'stock-critical'; rowClass = 'critical-row'; }
            else if (quantity < 10) { stockClass = 'stock-low';      rowClass = 'warning-row'; }
            else                    { stockClass = 'stock-normal'; }

            const companyName = product.company_name || product.company || 'بێ کۆمپانیا';
            const productName = product.name || 'بێ ناو';
            const voucherName = product.voucher_name || '';
            const isInCriticalList = product.in_critical_list || false;
            const imageUrl = getImageUrl(product.image_producte_path);

            return `
            <tr class="${rowClass}">
                <td data-label="وێنە">
                    ${buildImageTag(imageUrl, productName, 'product-image')}
                </td>
                <td data-label="ناوی کاڵا">
                    <strong>${escapeHtml(productName)}</strong>
                    ${isInCriticalList ? '<span class="list-badge mx-2"><i class="fas fa-check-circle"></i> لە لیستدا</span>' : ''}
                </td>
                <td data-label="کۆمپانیا">${escapeHtml(companyName)}</td>
                <td data-label="ناوی فرۆشیار">
                    ${voucherName
                        ? `<span class="voucher-badge"><i class="fas fa-user-tie me-1"></i>${escapeHtml(voucherName)}</span>`
                        : '<span class="text-muted">—</span>'}
                </td>
                <td data-label="بڕ">
                    <span class="stock-badge ${stockClass}">${quantity}${product.unit ? ' ' + escapeHtml(product.unit) : ''}</span>
                    ${quantity < 0 ? '<br><small class="text-danger">لە کۆگا کەمترە</small>' : ''}
                </td>
                <td data-label="نرخی کڕین">${formatNumber(purchasePrice, 2)}</td>
                <td data-label="نرخی فرۆشتن">${formatNumber(sellingPrice, 2)}</td>
                <td data-label="کردار" class="action-buttons no-print">
                    <button type="button" class="btn-add-to-store"
                            data-product-id="${product.id}"
                            data-product-name="${escapeHtml(productName)}"
                            data-product-qty="${quantity}">
                        <i class="fas fa-store me-1"></i> زیادکردن بۆ دوکان
                    </button>
                    <button type="button" class="btn-add-to-list"
                            data-product-id="${product.id}"
                            data-product-name="${escapeHtml(productName)}"
                            data-product-qty="${quantity}">
                        <i class="fas fa-clipboard-list me-1"></i> داواکاری
                    </button>
                </td>
            </tr>`;
        }).join('');

        $tbody.html(html);
    }

    function renderPagination(response) {
        state.totalPages  = response.last_page    || 1;
        state.currentPage = response.current_page || 1;

        if (state.totalPages <= 1) {
            $('#pagination-nav').html('');
            return;
        }

        const cur = state.currentPage;
        const total = state.totalPages;
        let html = '<ul class="pagination mb-0 flex-wrap">';

        // Previous
        if (cur > 1) html += `<li class="page-item"><a class="page-link" href="#" data-page="${cur - 1}">پێشوو</a></li>`;
        else         html += `<li class="page-item disabled"><span class="page-link">پێشوو</span></li>`;

        let startPage = Math.max(1, cur - 2);
        let endPage   = Math.min(total, cur + 2);

        if (startPage > 1) {
            html += `<li class="page-item"><a class="page-link" href="#" data-page="1">1</a></li>`;
            if (startPage > 2) html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
        }

        for (let i = startPage; i <= endPage; i++) {
            if (i === cur) html += `<li class="page-item active"><span class="page-link">${i}</span></li>`;
            else           html += `<li class="page-item"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`;
        }

        if (endPage < total) {
            if (endPage < total - 1) html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
            html += `<li class="page-item"><a class="page-link" href="#" data-page="${total}">${total}</a></li>`;
        }

        // Next
        if (cur < total) html += `<li class="page-item"><a class="page-link" href="#" data-page="${cur + 1}">دواتر</a></li>`;
        else             html += `<li class="page-item disabled"><span class="page-link">دواتر</span></li>`;

        html += '</ul>';
        $('#pagination-nav').html(html);
    }

    function loadProducts() {
        $('#loading-overlay').addClass('active');
        const perPage = $('#per-page').val();

        $.ajax({
            url: URLS.report,
            type: 'GET',
            data: {
                page: state.currentPage,
                per_page: perPage,
                name: state.filters.name,
                barcode: state.filters.barcode,
                company: state.filters.company,
                voucher: state.filters.voucher,
                stock_status: state.filters.stock_status
            },
            success: function(response) {
                if (response.success) {
                    state.currentProductsData = response.data || [];
                    renderProductsTable(state.currentProductsData);
                    renderPagination(response);
                } else {
                    showError('هەڵەیەک ڕوویدا لە بارکردنی زانیاری');
                }
            },
            error: function() {
                showError('هەڵە لە پەیوەندیدا، تکایە دووبارە هەوڵبدەرەوە');
            },
            complete: function() {
                $('#loading-overlay').removeClass('active');
            }
        });
    }

    function applyFilters() {
        state.filters = {
            name: '',
            barcode: cleanBarcodeValue($('#filter-barcode').val()),
            voucher: $('#filter-voucher').val() || '',
            company: $('#filter-company').val() || '',
            stock_status: $('#filter-stock-status').val() || ''
        };
        state.currentPage = 1;
        loadProducts();
    }

    function resetFilters() {
        $('#filter-barcode').val('');
        $('#filter-voucher').val('');
        $('#filter-company').val('');
        $('#filter-stock-status').val('');
        state.filters = { name: '', barcode: '', company: '', voucher: '', stock_status: '' };
        state.currentPage = 1;
        loadProducts();
    }

    function openAddToStoreModal(productId, productName, currentQuantity) {
        $('#product-id').val(productId);
        $('#product-name').val(productName);
        $('#current-quantity').val(currentQuantity);
        $('#add-quantity').val('');
        modals.addAmount.show();
    }

    function openAddToListModal(productId, productName, currentQuantity) {
        $('#list-product-id').val(productId);
        $('#list-product-name').val(productName);
        $('#list-current-quantity').val(currentQuantity);
        $('#list-request-quantity').val(1);
        modals.addToList.show();
    }

    function addToStore() {
        const productId = $('#product-id').val();
        const quantity  = $('#add-quantity').val();
        if (!quantity || quantity <= 0) {
            showWarning('تکایە ژمارەی کاڵا بۆ زیادکردن دیاری بکە');
            return;
        }

        $('#loading-overlay').addClass('active');
        $.ajax({
            url: URLS.addToStore,
            type: 'POST',
            data: { product_id: productId, quantity: quantity, _token: CSRF_TOKEN },
            success: function(response) {
                if (response.success) {
                    showSuccess('کاڵاکە بە سەرکەوتوویی زیاد کرا بۆ دوکان');
                    modals.addAmount.hide();
                    loadProducts();
                } else {
                    showError(response.message || 'هەڵەیەک ڕوویدا');
                }
            },
            error: function(xhr) {
                showError(xhr.responseJSON?.message || 'هەڵە لە زیادکردنی کاڵا بۆ دوکان');
            },
            complete: function() {
                $('#loading-overlay').removeClass('active');
            }
        });
    }

    function addToCriticalList() {
        const productId = $('#list-product-id').val();
        const requestQuantity = $('#list-request-quantity').val();
        if (!requestQuantity || requestQuantity <= 0) {
            showWarning('تکایە ژمارەی کاڵای داواکراو دیاری بکە');
            return;
        }

        $('#loading-overlay').addClass('active');
        $.ajax({
            url: URLS.addToCritical,
            type: 'POST',
            data: { product_id: productId, quantity: requestQuantity, _token: CSRF_TOKEN },
            success: function(response) {
                if (response.success) {
                    showSuccess('داواکارییەکەت بە سەرکەوتوویی تۆمار کرا');
                    modals.addToList.hide();
                    loadProducts();
                } else {
                    showError(response.message || 'هەڵەیەک ڕوویدا');
                }
            },
            error: function(xhr) {
                showError(xhr.responseJSON?.message || 'هەڵە لە تۆمارکردنی داواکاری');
            },
            complete: function() {
                $('#loading-overlay').removeClass('active');
            }
        });
    }

    // ==================== PRINT ====================
    function printCriticalList() {
        if (state.criticalProductsCache.length === 0) {
            showWarning('هیچ کاڵایەکی کەم نییە بۆ پرینت کردن');
            return;
        }

        $('#loading-overlay').addClass('active');
        const printContent = generateCriticalListHTML();
        const printWindow = window.open('', '_blank');
        printWindow.document.write(printContent);
        printWindow.document.close();
        printWindow.onload = function() {
            printWindow.focus();
            printWindow.print();
            $('#loading-overlay').removeClass('active');
        };
    }

    function generateCriticalListHTML() {
        const now = new Date();
        const dateStr = now.toLocaleDateString('ku-Arab', { year: 'numeric', month: 'long', day: 'numeric' });

        const tableRows = state.criticalProductsCache.map((product, index) => {
            const requestedQty = product.requested_quantity || 0;
            const companyName  = product.company_name || product.company || 'بێ کۆمپانیا';
            const productName  = product.product_name || product.name || 'بێ ناو';
            return `
            <tr>
                <td style="padding: 10px; border: 1px solid #ddd; text-align: center;">${index + 1}</td>
                <td style="padding: 10px; border: 1px solid #ddd; text-align: center;">${escapeHtml(productName)}</td>
                <td style="padding: 10px; border: 1px solid #ddd; text-align: center;">${escapeHtml(companyName)}</td>
                <td style="padding: 10px; border: 1px solid #ddd; text-align: center;">${escapeHtml(product.voucher_name || '—')}</td>
                <td style="padding: 10px; border: 1px solid #ddd; text-align: center; color: #dc2626; font-weight: bold;">${product.counter || 0}</td>
                <td style="padding: 10px; border: 1px solid #ddd; text-align: center; color: #2563eb; font-weight: bold;">${requestedQty}</td>
            </tr>`;
        }).join('');

        return `
        <!DOCTYPE html>
        <html dir="rtl">
        <head>
            <title>لیستی کاڵا کەمەکان</title>
            <meta charset="UTF-8">
            <style>
                body { margin: 0; padding: 20px; font-family: Arial, sans-serif; direction: rtl; }
                .header { text-align: center; margin-bottom: 30px; }
                .header h2 { color: #4a6491; margin-bottom: 10px; }
                .header p { color: #6b7280; font-size: 14px; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                th { background: #4a6491; color: white; padding: 12px; border: 1px solid #ddd; text-align: center; }
                td { padding: 10px; border: 1px solid #ddd; text-align: center; }
                .footer { margin-top: 30px; text-align: center; color: #9ca3af; font-size: 12px; }
            </style>
        </head>
        <body>
            <div class="header">
                <h2>لیستی کاڵا کەمەکان</h2>
                <p>تاریخ: ${dateStr}</p>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>ژ</th>
                        <th>ناوی کاڵا</th>
                        <th>کۆمپانیا</th>
                        <th>ناوی فرۆشیار</th>
                        <th>بڕ لە کۆگا</th>
                        <th>ژمارەی داواکراو</th>
                    </tr>
                </thead>
                <tbody>${tableRows}</tbody>
            </table>
            <div class="footer"><p>ڕاپۆرت لە کۆگا دروست کراوە</p></div>
        </body>
        </html>`;
    }

    // ==================== INIT ====================
    $(document).ready(function() {
        // Init modals
        modals.addAmount    = new bootstrap.Modal(document.getElementById('addAmountModal'));
        modals.addToList    = new bootstrap.Modal(document.getElementById('addToListModal'));
        modals.image        = new bootstrap.Modal(document.getElementById('imageModal'));
        modals.criticalList = new bootstrap.Modal(document.getElementById('criticalListModal'));
        modals.scanner      = new bootstrap.Modal(document.getElementById('barcodeScannerModal'));

        forceNumericInputForBarcode();
        loadProducts();

        // ---- Filter inputs with debounce ----
        $('#filter-barcode').on('input', function() {
            const clean = cleanBarcodeValue($(this).val());
            if ($(this).val() !== clean) $(this).val(clean);
            clearTimeout(state.debounceTimer);
            state.debounceTimer = setTimeout(() => { state.currentPage = 1; applyFilters(); }, 500);
        });

        $('#filter-voucher, #filter-company').on('input', function() {
            clearTimeout(state.debounceTimer);
            state.debounceTimer = setTimeout(() => { state.currentPage = 1; applyFilters(); }, 500);
        });

        $('#filter-stock-status').on('change', function() {
            state.currentPage = 1;
            applyFilters();
        });

        $('#per-page').on('change', function() {
            state.currentPage = 1;
            loadProducts();
        });

        // ---- Reset filters ----
        $('#resetFiltersBtn').on('click', resetFilters);

        // ---- Forms ----
        $('#add-amount-form').on('submit', function(e) { e.preventDefault(); addToStore(); });
        $('#add-to-list-form').on('submit', function(e) { e.preventDefault(); addToCriticalList(); });

        // ---- Critical list button ----
        $('#openCriticalListBtn').on('click', openCriticalListModal);
        $('#printCriticalListBtn').on('click', printCriticalList);

        // ---- Scanner ----
        $('#scan-barcode-filter-btn').on('click', function() { modals.scanner.show(); });
        document.getElementById('barcodeScannerModal').addEventListener('shown.bs.modal', startBarcodeScanner);
        document.getElementById('barcodeScannerModal').addEventListener('hidden.bs.modal', stopBarcodeScanner);
        $('#closeScannerBtn').on('click', function() {
            modals.scanner.hide();
            $('#filter-barcode').focus();
        });

        // ---- Pagination (event delegation) ----
        $('#pagination-nav').on('click', '.page-link', function(e) {
            e.preventDefault();
            const page = $(this).data('page');
            if (page && page !== state.currentPage) {
                state.currentPage = page;
                loadProducts();
                $('html, body').animate({ scrollTop: $('.products-table-container').offset().top - 100 }, 300);
            }
        });

        // ---- Product table: image click ----
        $('#products-table-body, #critical-items-container').on('click', '.product-image, .critical-item-image', function() {
            showFullscreenImage($(this).data('image-url') || $(this).attr('src'));
        });

        // ---- Product table: add to store ----
        $('#products-table-body').on('click', '.btn-add-to-store', function() {
            const id   = $(this).data('product-id');
            const name = $(this).data('product-name');
            const qty  = $(this).data('product-qty');
            openAddToStoreModal(id, name, qty);
        });

        // ---- Product table: add to list (request) ----
        $('#products-table-body').on('click', '.btn-add-to-list', function() {
            const id   = $(this).data('product-id');
            const name = $(this).data('product-name');
            const qty  = $(this).data('product-qty');
            openAddToListModal(id, name, qty);
        });

        // ---- Critical list: delete ----
        $('#critical-items-container').on('click', '.btn-delete-from-list', function() {
            const id   = $(this).data('delete-id');
            const name = $(this).data('delete-name');
            confirmDeleteFromCriticalList(id, name);
        });
    });

    // Expose for inline handlers
    window.__reportPage = {
        onImageError: onImageError,
        showFullscreenImage: showFullscreenImage
    };
})();
</script>
@endsection