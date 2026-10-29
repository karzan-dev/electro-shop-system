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
        --input-bg: #ffffff;
        --input-text: #1e293b;
        --pagination-bg: #ffffff;
        --pagination-active-bg: #4a6491;
        --pagination-active-text: #ffffff;
        --pagination-hover-bg: #e2e8f0;
        --pagination-text: #4a6491;
        --pagination-border: #e2e8f0;
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

    /* ============================================
       REPORT HEADER
       ============================================ */
    .report-header {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border-radius: 1rem 1rem 0 0 !important;
        padding: 1.5rem 2rem;
        transition: all 0.3s ease;
    }

    .report-header h2 { color: white; margin-bottom: 0.5rem; }
    .report-header p  { color: rgba(255, 255, 255, 0.85); margin: 0; }

    @media (max-width: 768px) {
        .report-header { padding: 1rem 1.25rem; }
        .report-header h2 { font-size: 1.25rem; }
        .report-header p { font-size: 0.8rem; }
    }

    @media (max-width: 480px) {
        .report-header { padding: 0.85rem 1rem; }
        .report-header h2 { font-size: 1.1rem; }
        .report-header p { font-size: 0.72rem; }
    }

    /* ============================================
       FILTER SECTION
       ============================================ */
    .filter-section {
        background: var(--card-bg);
        border-radius: 1rem;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
        border: 1px solid var(--border);
        transition: all 0.3s ease;
    }

    @media (max-width: 768px) { .filter-section { padding: 1rem; } }
    @media (max-width: 480px) { .filter-section { padding: 0.75rem; border-radius: 0.75rem; } }

    .search-input-group { position: relative; }

    .search-input-group > i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--primary);
        font-size: 1rem;
        z-index: 4;
        pointer-events: none;
    }

    .search-input-group input {
        width: 100%;
        padding: 0.75rem 1rem 0.75rem 2.75rem;
        border: 2px solid var(--border);
        border-radius: 12px;
        background-color: var(--input-bg) !important;
        color: var(--input-text) !important;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .search-input-group input::placeholder { color: var(--text-light); opacity: 0.7; }

    .search-input-group input:focus {
        border-color: var(--primary);
        outline: none;
        box-shadow: 0 0 0 3px rgba(74, 100, 145, 0.15);
    }

    @media (max-width: 768px) {
        .search-input-group input { font-size: 0.8rem; padding: 0.5rem 0.75rem 0.5rem 2.5rem; }
        .search-input-group > i { font-size: 0.9rem; left: 0.85rem; }
    }

    @media (max-width: 576px) {
        .search-input-group input { font-size: 16px !important; }
    }

    .btn-reset {
        background: var(--border);
        color: var(--text);
        border: none;
        padding: 0.75rem 1.25rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        font-size: 0.9rem;
        cursor: pointer;
        width: 100%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
    }

    .btn-reset:hover { background: var(--text-light); color: white; }

    /* ============================================
       ADD BUTTON
       ============================================ */
    .btn-add-main {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
    }

    .btn-add-main:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(16, 185, 129, 0.4);
    }

    /* ============================================
       BRANDS CONTAINER
       ============================================ */
    .brands-container {
        background: var(--card-bg);
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 4px 15px var(--shadow);
        border: 1px solid var(--border);
        transition: all 0.3s ease;
    }

    .brands-table {
        width: 100%;
        margin-bottom: 0;
        background-color: var(--table-row-bg);
        table-layout: fixed;
        min-width: 750px;
    }

    .brands-table thead th:nth-child(1) { width: 50px; }
    .brands-table thead th:nth-child(2) { width: 280px; }
    .brands-table thead th:nth-child(3) { width: 120px; }
    .brands-table thead th:nth-child(4) { width: 260px; }

    @media (max-width: 992px) {
        .brands-table { min-width: 700px; }
        .brands-table thead th:nth-child(1) { width: 45px; }
        .brands-table thead th:nth-child(2) { width: 200px; }
        .brands-table thead th:nth-child(3) { width: 110px; }
        .brands-table thead th:nth-child(4) { width: 260px; }
    }

    .brands-table thead th {
        background: var(--table-header-bg);
        color: white;
        font-weight: 600;
        padding: 0.875rem 0.75rem;
        font-size: 0.85rem;
        border: none;
        text-align: right;
        white-space: nowrap;
    }

    @media (max-width: 768px) {
        .brands-table thead th { padding: 0.6rem 0.5rem; font-size: 0.75rem; }
    }

    .brands-table tbody tr {
        background-color: var(--table-row-bg);
        transition: background-color 0.2s ease;
    }

    .brands-table tbody tr:nth-child(even) { background-color: var(--table-row-alt-bg); }
    .brands-table tbody tr:hover { background: var(--table-hover) !important; }

    .brands-table tbody td {
        padding: 0.875rem 0.75rem;
        vertical-align: middle;
        border-bottom: 1px solid var(--border);
        font-size: 0.9rem;
        color: var(--text);
        background-color: inherit;
        text-align: right;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    @media (max-width: 768px) {
        .brands-table tbody td { padding: 0.5rem; font-size: 0.8rem; }
    }

    /* ============================================
       TABLE → CARDS - MOBILE
       ============================================ */
    @media (max-width: 767px) {
        .brands-container {
            background: transparent !important;
            box-shadow: none !important;
            border-radius: 0;
            overflow: visible !important;
            border: none;
        }

        .brands-table { display: block; min-width: 0 !important; table-layout: auto; }
        .brands-table thead { display: none; }
        .brands-table tbody { display: block; }

        .brands-table tbody tr {
            display: block;
            background: var(--card-bg) !important;
            border-radius: 12px;
            margin-bottom: 10px;
            padding: 12px;
            border: 1px solid var(--border) !important;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
        }

        body.dark-mode .brands-table tbody tr {
            background: var(--card-bg) !important;
            border-color: var(--border) !important;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        }

        .brands-table tbody tr:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .brands-table tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 0 !important;
            border: none !important;
            border-bottom: 1px solid var(--border) !important;
            text-align: right;
            gap: 10px;
            font-size: 0.8rem;
            background: transparent !important;
            color: var(--text);
            white-space: normal;
            overflow: visible;
            text-overflow: clip;
        }

        .brands-table tbody td:last-child { border-bottom: none !important; }

        .brands-table tbody td::before {
            content: attr(data-label);
            font-weight: 700;
            font-size: 0.7rem;
            text-transform: uppercase;
            flex-shrink: 0;
            text-align: left;
            color: var(--primary);
        }

        body.dark-mode .brands-table tbody td::before { color: #94a3b8; }

        .brands-table tbody td[data-label="براند"] {
            border-bottom: 2px solid var(--border) !important;
            padding-bottom: 10px !important;
            justify-content: center;
            text-align: center;
            margin-bottom: 6px;
        }

        .brands-table tbody td[data-label="براند"]::before { display: none; }

        .action-buttons { width: 100%; justify-content: center; }
        .btn-action { flex: 1; justify-content: center; }
    }

    @media (max-width: 480px) {
        .brands-table tbody tr { padding: 10px; margin-bottom: 8px; }
        .brands-table tbody td { font-size: 0.75rem; padding: 5px 0 !important; }
        .brands-table tbody td::before { font-size: 0.65rem; }
    }

    /* ============================================
       BRAND NAME / AVATAR
       ============================================ */
    .brand-name { display: flex; align-items: center; gap: 0.75rem; min-width: 0; }

    .brand-avatar {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.1rem;
        flex-shrink: 0;
        box-shadow: 0 2px 8px rgba(74, 100, 145, 0.3);
    }

    .brand-name-text {
        font-weight: 600;
        color: var(--text);
        font-size: 0.95rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .brand-id-badge {
        display: inline-block;
        background: var(--border);
        color: var(--text-light);
        padding: 0.15rem 0.5rem;
        border-radius: 6px;
        font-size: 0.7rem;
        font-weight: 600;
        margin-top: 0.15rem;
    }

    .products-count {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        background: #dbeafe;
        color: #1e40af;
        padding: 0.3rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 700;
        white-space: nowrap;
    }

    body.dark-mode .products-count { background: #1e3a8a; color: #bfdbfe; }

    .products-count.has-products { background: #d1fae5; color: #065f46; }
    body.dark-mode .products-count.has-products { background: #064e3b; color: #d1fae5; }

    /* ============================================
       ACTION BUTTONS
       ============================================ */
    .action-buttons { display: flex; gap: 0.3rem; flex-wrap: nowrap; justify-content: flex-start; }

    .btn-action {
        padding: 0.4rem 0.75rem;
        border-radius: 0.5rem;
        border: none;
        font-size: 0.75rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        white-space: nowrap;
    }

    .btn-action:hover { transform: translateY(-2px); }

    .btn-edit {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white;
    }

    .btn-edit:hover { box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3); }

    .btn-delete {
        background: transparent;
        border: 1px solid #ef4444;
        color: #ef4444;
        padding: 0.35rem 0.6rem;
    }

    .btn-delete:hover { background: #ef4444; color: white; }

    body.dark-mode .btn-delete { border-color: #f87171; color: #f87171; }
    body.dark-mode .btn-delete:hover { background: #f87171; color: white; }

    .btn-delete:disabled,
    .btn-delete.disabled { opacity: 0.4; cursor: not-allowed; transform: none !important; }

    /* ============================================
       EMPTY / LOADING STATES
       ============================================ */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--text-light);
    }

    .empty-state i {
        font-size: 4rem;
        color: var(--border);
        margin-bottom: 1rem;
    }

    .loading-state { text-align: center; padding: 3rem; color: var(--text-light); }

    /* ============================================
       PAGINATION
       ============================================ */
    .pagination-wrapper {
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
        .pagination-wrapper { flex-direction: column; justify-content: center; padding: 0.85rem 0.75rem; }
    }

    .pagination {
        display: flex;
        padding-left: 0;
        list-style: none;
        margin: 0;
        gap: 4px;
        flex-wrap: wrap;
        justify-content: center;
    }

    .page-item { margin: 0 2px; }

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

    @media (max-width: 768px) { .page-link { padding: 0.4rem 0.6rem; font-size: 0.75rem; } }

    @media (max-width: 480px) {
        .page-link { padding: 0.35rem 0.5rem; font-size: 0.7rem; }
        .pagination { gap: 2px; }
    }

    .per-page-select {
        width: auto;
        display: inline-block;
        border-radius: 0.5rem;
        border: 1px solid var(--pagination-border);
        padding: 0.4rem 0.6rem;
        background-color: var(--input-bg);
        color: var(--input-text);
        font-size: 0.85rem;
    }

    .per-page-select option { background-color: var(--input-bg); color: var(--input-text); }

    /* ============================================
       MODALS
       ============================================ */
    .modal-content {
        background-color: var(--modal-bg);
        color: var(--text);
        border: 1px solid var(--border);
        border-radius: 1.25rem;
        overflow: hidden;
        box-shadow: none !important;
    }

    .modal-dialog { box-shadow: none !important; }

    .modal-header { padding: 1.25rem 1.5rem; border-bottom: none; }

    .modal-header.purple { background: linear-gradient(135deg, #4a6491, #2c3e50); color: white; }
    .modal-header.blue   { background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; }
    .modal-header.red    { background: linear-gradient(135deg, #ef4444, #dc2626); color: white; }

    .modal-header .btn-close { filter: invert(1); opacity: 0.9; }

    .modal-body { padding: 1.5rem; }

    .modal-footer {
        padding: 1rem 1.5rem;
        border-top: 1px solid var(--border);
        gap: 0.5rem;
    }

    body.dark-mode .modal-footer { background-color: var(--modal-bg); border-top-color: var(--border); }

    /* ============================================
       FORM CONTROLS
       ============================================ */
    .form-label { font-weight: 600; color: var(--text); margin-bottom: 0.5rem; font-size: 0.9rem; }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid var(--border);
        border-radius: 10px;
        background-color: var(--input-bg);
        color: var(--input-text);
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: var(--primary);
        outline: none;
        box-shadow: 0 0 0 3px rgba(74, 100, 145, 0.2);
        background-color: var(--input-bg);
        color: var(--input-text);
    }

    .form-control::placeholder { color: var(--text-light); }
    .form-control.is-invalid { border-color: var(--danger); }

    .invalid-feedback {
        color: var(--danger);
        font-size: 0.8rem;
        margin-top: 0.35rem;
        display: none;
    }

    .invalid-feedback.show { display: block; }

    .btn-modal-primary {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        border: none;
        padding: 0.6rem 1.3rem;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.9rem;
    }

    .btn-modal-primary:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(74, 100, 145, 0.4); }

    .btn-modal-secondary {
        background: var(--border);
        color: var(--text);
        border: none;
        padding: 0.6rem 1.3rem;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }

    .btn-modal-secondary:hover { background: var(--text-light); color: white; }
    body.dark-mode .btn-modal-secondary { background: #475569; color: #e2e8f0; }
    body.dark-mode .btn-modal-secondary:hover { background: #334155; }

    /* ============================================
       ALERTS
       ============================================ */
    .alert-container {
        position: fixed;
        top: 15px;
        right: 15px;
        z-index: 99999;
        width: calc(100% - 30px);
        max-width: 380px;
        pointer-events: none;
    }

    .custom-alert {
        background: var(--card-bg);
        border-radius: 14px;
        padding: 0.9rem 1.1rem;
        margin-bottom: 10px;
        display: flex;
        gap: 0.75rem;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        position: relative;
        overflow: hidden;
        align-items: flex-start;
        pointer-events: auto;
        animation: slideDown 0.3s ease-out;
    }

    .custom-alert strong { display: block; margin-bottom: 0.15rem; font-size: 0.9rem; }
    .custom-alert div:last-child { font-size: 0.85rem; word-break: break-word; }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .alert-success-c { background: linear-gradient(135deg, #d1fae5, #a7f3d0); color: #065f46; border-right: 4px solid #10b981; }
    .alert-error-c   { background: linear-gradient(135deg, #fee2e2, #fecaca); color: #991b1b; border-right: 4px solid #ef4444; }
    .alert-warning-c { background: linear-gradient(135deg, #fff3e3, #fed7aa); color: #9a3412; border-right: 4px solid #f59e0b; }
    .alert-info-c    { background: linear-gradient(135deg, #dbeafe, #bfdbfe); color: #1e3a8a; border-right: 4px solid #3b82f6; }

    body.dark-mode .alert-success-c { background: linear-gradient(135deg, #064e3b, #065f46); color: #a7f3d0; }
    body.dark-mode .alert-error-c   { background: linear-gradient(135deg, #7f1d1d, #991b1b); color: #fecaca; }
    body.dark-mode .alert-warning-c { background: linear-gradient(135deg, #78350f, #92400e); color: #fde68a; }
    body.dark-mode .alert-info-c    { background: linear-gradient(135deg, #1e3a8a, #1e40af); color: #bfdbfe; }

    .alert-progress {
        position: absolute;
        bottom: 0; left: 0;
        height: 3px;
        background: currentColor;
        animation: progressBar 4s linear;
    }

    @keyframes progressBar {
        from { width: 100%; }
        to { width: 0%; }
    }

    @media (max-width: 576px) {
        .alert-container { top: 8px; left: 8px; right: 8px; width: auto; max-width: none; }
        .custom-alert { font-size: 0.8rem; padding: 0.75rem; }
    }

    /* ============================================
       LOADING OVERLAY
       ============================================ */
    .loading-overlay {
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 99998;
        display: flex;
        align-items: center;
        justify-content: center;
        visibility: hidden;
        backdrop-filter: blur(2px);
    }

    .loading-overlay.active { visibility: visible; }

    .loading-spinner {
        background: var(--card-bg);
        padding: 1.5rem 2rem;
        border-radius: 1rem;
        text-align: center;
        color: var(--text);
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }

    /* ============================================
       TOUCH
       ============================================ */
    @media (max-width: 768px) {
        button, .btn-action, input, select {
            -webkit-tap-highlight-color: transparent;
            touch-action: manipulation;
        }
        .btn:active, button:active { transform: scale(0.98); }
    }

    @media (max-width: 576px) {
        input, select { font-size: 16px !important; }
    }
</style>

<div class="container-fluid py-3 py-md-4">

    <!-- Report Header -->
    <div class="report-header text-white mb-3 mb-md-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h2 class="mb-1 mb-md-2">
                    <i class="fas fa-trademark me-2"></i>
                    بەڕێوەبردنی براندەکان
                </h2>
                <p class="mb-0 opacity-75">
                    <i class="fas fa-info-circle me-1"></i>
                    زیادکردن، دەستکاریکردن و سڕینەوەی براندەکان
                </p>
            </div>
        </div>
    </div>

    <!-- Toolbar -->
    <div class="filter-section no-print">
        <div class="row g-2 g-md-3 align-items-center">
            <div class="col-12 col-md-6">
                <div class="search-input-group">
                    <i class="fas fa-search"></i>
                    <input type="text" id="search-brand" placeholder="گەڕان بە ناوی براند ..." autocomplete="off">
                </div>
            </div>
            <div class="col-12 col-md-3">
                <button class="btn-add-main w-100" onclick="openAddModal()">
                    <i class="fas fa-plus-circle"></i>
                    زیادکردنی براندی نوێ
                </button>
            </div>
            <div class="col-12 col-md-3">
                <button class="btn-reset" onclick="resetFilters()">
                    <i class="fas fa-undo-alt"></i> ڕێکخستنەوە
                </button>
            </div>
        </div>
    </div>

    <!-- Brands Table -->
    <div class="brands-container">
        <table class="brands-table table">
            <thead>
                <tr>
                    <th>ژ</th>
                    <th>براند</th>
                    <th>ژمارەی کاڵاکان</th>
                    <th>کردار</th>
                </tr>
            </thead>
            <tbody id="brands-body">
                <tr>
                    <td colspan="4" class="loading-state">
                        <i class="fas fa-spinner fa-spin fa-2x text-primary"></i>
                        <p class="mt-2 mb-0">بارکردنی زانیاری...</p>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="pagination-wrapper" id="pagination-wrapper" style="display: none;">
            <div class="d-flex align-items-center gap-2">
                <span class="text-muted" style="font-size: 0.85rem;">براند لە لاپەڕە:</span>
                <select id="per-page" class="per-page-select">
                    <option value="15">15</option>
                    <option value="30">30</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
            <nav id="pagination-nav"></nav>
        </div>
    </div>
</div>

<!-- ADD BRAND MODAL -->
<div class="modal fade" id="addBrandModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header purple">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle me-2"></i> زیادکردنی براندی نوێ
                </h5>
            </div>
            <form id="add-brand-form">
                <div class="modal-body">
                    <label class="form-label">
                        <span class="text-danger">*</span> ناوی براند
                    </label>
                    <input type="text"
                           id="add-brand-name"
                           class="form-control"
                           placeholder="ناوی براند بنووسە ..."
                           autocomplete="off"
                           required
                           maxlength="255">
                    <div class="invalid-feedback" id="add-name-error"></div>
                    <small class="text-muted d-block mt-2">
                        <i class="fas fa-info-circle me-1"></i>
                        ناوەکە دەبێت لە لیستەکەدا نەبێت
                    </small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> پاشگەزبوونەوە
                    </button>
                    <button type="submit" class="btn-modal-primary" id="save-brand-btn">
                        <i class="fas fa-save me-1"></i> تۆمارکردن
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- EDIT BRAND MODAL -->
<div class="modal fade" id="editBrandModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header blue">
                <h5 class="modal-title">
                    <i class="fas fa-user-edit me-2"></i> دەستکاریکردنی ناوی براند
                </h5>
            </div>
            <form id="edit-brand-form">
                <div class="modal-body">
                    <input type="hidden" id="edit-brand-id">
                    <label class="form-label">
                        <span class="text-danger">*</span> ناوی براند
                    </label>
                    <input type="text"
                           id="edit-brand-name"
                           class="form-control"
                           placeholder="ناوی براند بنووسە ..."
                           autocomplete="off"
                           required
                           maxlength="255">
                    <div class="invalid-feedback" id="edit-name-error"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> پاشگەزبوونەوە
                    </button>
                    <button type="submit" class="btn-modal-primary" id="update-brand-btn">
                        <i class="fas fa-save me-1"></i> نوێکردنەوە
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- DELETE BRAND MODAL -->
<div class="modal fade" id="deleteBrandModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header red">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle me-2"></i> دڵنیایت؟
                </h5>
            </div>
            <div class="modal-body text-center">
                <i class="fas fa-trash-alt fa-3x text-danger mb-3 d-block"></i>
                <p class="mb-2">دەتەوێت ئەم براندە بسڕیتەوە؟</p>
                <p class="fw-bold mb-0" id="delete-brand-name" style="color: var(--danger);"></p>
                <p class="text-muted small mt-2 mb-0">
                    ئاگاداری: ئەم کردارە هەڵنەگەڕێتەوە
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-secondary w-100" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> پاشگەزبوونەوە
                </button>
                <button type="button" class="btn-modal-primary w-100" id="confirm-delete-btn"
                        style="background: linear-gradient(135deg, #ef4444, #dc2626);">
                    <i class="fas fa-trash me-1"></i> سڕینەوە
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Alert Container -->
<div class="alert-container" id="alert-container"></div>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loading-overlay">
    <div class="loading-spinner">
        <i class="fas fa-spinner fa-spin fa-2x text-primary mb-2"></i>
        <p class="mb-0">تکایە چاوەڕێ بە...</p>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// ==================== GLOBAL VARIABLES ====================
let currentPage = 1;
let currentSearch = '';
let addModal, editModal, deleteModal;
let deleteBrandId = null;
let debounceTimer;

// ==================== CSRF SETUP ====================
$.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
});

// ==================== ALERTS ====================
function showAlert(type, msg, title = '') {
    const icons = {
        success: 'fa-check-circle',
        error: 'fa-exclamation-circle',
        warning: 'fa-exclamation-triangle',
        info: 'fa-info-circle'
    };
    const titles = {
        success: 'سەرکەوتوو',
        error: 'هەڵە',
        warning: 'ئاگاداری',
        info: 'زانیاری'
    };
    const id = 'alert-' + Date.now();
    const html = `
        <div id="${id}" class="custom-alert alert-${type}-c">
            <div><i class="fas ${icons[type]} fa-lg"></i></div>
            <div style="flex:1;min-width:0;">
                <strong>${title || titles[type]}</strong>
                <div>${escapeHtml(msg)}</div>
            </div>
            <div class="alert-progress"></div>
        </div>`;
    $('#alert-container').append(html);
    setTimeout(() => $(`#${id}`).fadeOut(300, function () { $(this).remove(); }), 4000);
}

// ==================== HELPERS ====================
function escapeHtml(text) {
    if (!text) return '';
    return String(text).replace(/[&<>"']/g, m => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
    }[m]));
}

function getInitials(name) {
    if (!name) return '?';
    return name.trim().charAt(0).toUpperCase();
}

// ==================== LOAD BRANDS ====================
function loadBrands(page = 1) {
    $('#loading-overlay').addClass('active');
    const perPage = $('#per-page').val() || 15;

    $.ajax({
        url: '{{ route("brands.list") }}',
        type: 'GET',
        data: {
            page: page,
            per_page: perPage,
            search: currentSearch
        },
        success: function (res) {
            if (res.success) {
                renderBrands(res.brands);
                renderPagination(res);
                $('#pagination-wrapper').toggle(res.last_page > 1);
            } else {
                showAlert('error', res.message || 'هەڵە لە بارکردن');
            }
        },
        error: function () {
            showAlert('error', 'هەڵە لە پەیوەندیدا');
            $('#brands-body').html(`
                <tr><td colspan="4" class="empty-state">
                    <i class="fas fa-exclamation-circle"></i>
                    <p>هەڵە لە بارکردنی زانیاری</p>
                </td></tr>`);
        },
        complete: function () {
            $('#loading-overlay').removeClass('active');
        }
    });
}

// ==================== RENDER TABLE ====================
function renderBrands(brands) {
    const tbody = $('#brands-body');

    if (!brands || brands.length === 0) {
        tbody.html(`
            <tr><td colspan="4" class="empty-state">
                <i class="fas fa-trademark"></i>
                <p class="mb-2">هیچ براندێک نەدۆزرایەوە</p>
                <button class="btn-add-main" onclick="openAddModal()" style="margin: 0 auto;">
                    <i class="fas fa-plus-circle"></i> زیادکردنی براندی نوێ
                </button>
            </td></tr>`);
        return;
    }

    const perPage = parseInt($('#per-page').val()) || 15;
    const startIndex = (currentPage - 1) * perPage;
    let html = '';

    brands.forEach((brand, index) => {
        const rowNum = startIndex + index + 1;
        const productsCount = brand.products_count || 0;
        const hasProducts = productsCount > 0;
        const initials = getInitials(brand.name);
        const brandNameEscaped = escapeHtml(brand.name).replace(/'/g, '&#39;');

        html += `
            <tr data-brand-id="${brand.id}">
                <td data-label="ژ">${rowNum}</td>
                <td data-label="براند">
                    <div class="brand-name">
                        <div class="brand-avatar">${escapeHtml(initials)}</div>
                        <div style="min-width:0;">
                            <div class="brand-name-text">${escapeHtml(brand.name)}</div>
                            <span class="brand-id-badge">#${brand.id}</span>
                        </div>
                    </div>
                </td>
                <td data-label="ژمارەی کاڵاکان">
                    <span class="products-count ${hasProducts ? 'has-products' : ''}">
                        <i class="fas fa-box"></i> ${productsCount} کاڵا
                    </span>
                </td>
                <td data-label="کردار">
                    <div class="action-buttons">
                        <button class="btn-action btn-edit"
                                onclick="openEditModal(${brand.id}, '${brandNameEscaped}')"
                                title="دەستکاریکردن">
                            <i class="fas fa-edit"></i> دەستکاری
                        </button>
                  
                    </div>
                </td>
            </tr>`;
    });
    tbody.html(html);
}

// ==================== PAGINATION ====================
function renderPagination(res) {
    if (!res.last_page || res.last_page <= 1) {
        $('#pagination-nav').html('');
        return;
    }

    const current = res.current_page;
    const last = res.last_page;
    let html = '<ul class="pagination">';

    html += current > 1
        ? `<li class="page-item"><a class="page-link" data-page="${current - 1}">پێشوو</a></li>`
        : `<li class="page-item disabled"><span class="page-link">پێشوو</span></li>`;

    let start = Math.max(1, current - 2);
    let end = Math.min(last, current + 2);

    if (start > 1) {
        html += `<li class="page-item"><a class="page-link" data-page="1">1</a></li>`;
        if (start > 2) html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
    }

    for (let i = start; i <= end; i++) {
        html += i === current
            ? `<li class="page-item active"><span class="page-link">${i}</span></li>`
            : `<li class="page-item"><a class="page-link" data-page="${i}">${i}</a></li>`;
    }

    if (end < last) {
        if (end < last - 1) html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
        html += `<li class="page-item"><a class="page-link" data-page="${last}">${last}</a></li>`;
    }

    html += current < last
        ? `<li class="page-item"><a class="page-link" data-page="${current + 1}">دواتر</a></li>`
        : `<li class="page-item disabled"><span class="page-link">دواتر</span></li>`;

    html += '</ul>';
    $('#pagination-nav').html(html);

    $('#pagination-nav .page-link[data-page]').on('click', function (e) {
        e.preventDefault();
        const page = parseInt($(this).data('page'));
        if (page && page !== currentPage) {
            currentPage = page;
            loadBrands(page);
            $('html, body').animate({ scrollTop: $('.brands-container').offset().top - 100 }, 300);
        }
    });
}

// ==================== RESET ====================
function resetFilters() {
    $('#search-brand').val('');
    currentSearch = '';
    currentPage = 1;
    loadBrands(1);
}

// ==================== ADD ====================
function openAddModal() {
    $('#add-brand-name').val('').removeClass('is-invalid');
    $('#add-name-error').removeClass('show').text('');
    addModal.show();
    setTimeout(() => $('#add-brand-name').focus(), 300);
}

$('#add-brand-form').on('submit', function (e) {
    e.preventDefault();
    const name = $('#add-brand-name').val().trim();

    if (!name) {
        $('#add-brand-name').addClass('is-invalid');
        $('#add-name-error').addClass('show').text('تکایە ناوی براند بنووسە');
        return;
    }

    const btn = $('#save-brand-btn');
    btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> تۆمار دەکرێت...');

    $.ajax({
        url: '{{ route("brands.store") }}',
        type: 'POST',
        data: { name: name },
        success: function (res) {
            if (res.success) {
                showAlert('success', 'براند بە سەرکەوتوویی زیادکرا');
                addModal.hide();
                currentPage = 1;
                loadBrands(1);
            } else {
                showAlert('error', res.message || 'هەڵەیەک ڕوویدا');
            }
        },
        error: function (xhr) {
            let msg = 'هەڵەیەک ڕوویدا';
            if (xhr.responseJSON?.errors?.name) {
                msg = xhr.responseJSON.errors.name[0];
                $('#add-brand-name').addClass('is-invalid');
                $('#add-name-error').addClass('show').text(msg);
            } else if (xhr.responseJSON?.message) {
                msg = xhr.responseJSON.message;
            }
            showAlert('error', msg);
        },
        complete: function () {
            btn.prop('disabled', false).html('<i class="fas fa-save me-1"></i> تۆمارکردن');
        }
    });
});

// ==================== EDIT ====================
function openEditModal(id, name) {
    $('#edit-brand-id').val(id);
    $('#edit-brand-name').val(name).removeClass('is-invalid');
    $('#edit-name-error').removeClass('show').text('');
    editModal.show();
    setTimeout(() => $('#edit-brand-name').focus().select(), 300);
}

$('#edit-brand-form').on('submit', function (e) {
    e.preventDefault();
    const id = $('#edit-brand-id').val();
    const name = $('#edit-brand-name').val().trim();

    if (!name) {
        $('#edit-brand-name').addClass('is-invalid');
        $('#edit-name-error').addClass('show').text('تکایە ناوی براند بنووسە');
        return;
    }

    const btn = $('#update-brand-btn');
    btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> نوێ دەکرێتەوە...');

    $.ajax({
        url: '{{ route("brands.update") }}',
        type: 'POST',
        data: { id: id, name: name },
        success: function (res) {
            if (res.success) {
                showAlert('success', 'ناوی براند بە سەرکەوتوویی نوێکرایەوە');
                editModal.hide();
                loadBrands(currentPage);
            } else {
                showAlert('error', res.message || 'هەڵەیەک ڕوویدا');
            }
        },
        error: function (xhr) {
            let msg = 'هەڵەیەک ڕوویدا';
            if (xhr.responseJSON?.errors?.name) {
                msg = xhr.responseJSON.errors.name[0];
                $('#edit-brand-name').addClass('is-invalid');
                $('#edit-name-error').addClass('show').text(msg);
            } else if (xhr.responseJSON?.message) {
                msg = xhr.responseJSON.message;
            }
            showAlert('error', msg);
        },
        complete: function () {
            btn.prop('disabled', false).html('<i class="fas fa-save me-1"></i> نوێکردنەوە');
        }
    });
});

// ==================== DELETE ====================
function openDeleteModal(id, name) {
    deleteBrandId = id;
    $('#delete-brand-name').text(name);
    deleteModal.show();
}

$('#confirm-delete-btn').on('click', function () {
    if (!deleteBrandId) return;
    const btn = $(this);
    btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> سڕینەوە...');

    $.ajax({
        url: '/brands/' + deleteBrandId + '/delete',
        type: 'DELETE',
        success: function (res) {
            if (res.success) {
                showAlert('success', 'براند بە سەرکەوتوویی سڕایەوە');
                deleteModal.hide();
                loadBrands(currentPage);
            } else {
                showAlert('error', res.message || 'هەڵەیەک ڕوویدا');
            }
        },
        error: function (xhr) {
            showAlert('error', xhr.responseJSON?.message || 'هەڵە لە سڕینەوەدا');
        },
        complete: function () {
            btn.prop('disabled', false).html('<i class="fas fa-trash me-1"></i> سڕینەوە');
            deleteBrandId = null;
        }
    });
});

// ==================== DOCUMENT READY ====================
$(document).ready(function () {
    addModal = new bootstrap.Modal(document.getElementById('addBrandModal'));
    editModal = new bootstrap.Modal(document.getElementById('editBrandModal'));
    deleteModal = new bootstrap.Modal(document.getElementById('deleteBrandModal'));

    loadBrands(1);

    $('#search-brand').on('input', function () {
        clearTimeout(debounceTimer);
        const val = $(this).val().trim();
        debounceTimer = setTimeout(() => {
            currentSearch = val;
            currentPage = 1;
            loadBrands(1);
        }, 400);
    });

    $('#per-page').on('change', function () {
        currentPage = 1;
        loadBrands(1);
    });

    $('#add-brand-name').on('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            $('#add-brand-form').submit();
        }
    });

    $('#edit-brand-name').on('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            $('#edit-brand-form').submit();
        }
    });
});
</script>
@endsection