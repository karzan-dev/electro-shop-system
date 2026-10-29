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

    .report-header h2 {
        color: white;
        margin-bottom: 0.5rem;
    }

    .report-header p {
        color: rgba(255, 255, 255, 0.85);
        margin: 0;
    }

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

    .search-input-group input::placeholder {
        color: var(--text-light);
        opacity: 0.7;
    }

    .search-input-group input:focus {
        border-color: var(--primary);
        outline: none;
        box-shadow: 0 0 0 3px rgba(74, 100, 145, 0.15);
    }

    @media (max-width: 768px) {
        .search-input-group input {
            font-size: 0.8rem;
            padding: 0.5rem 0.75rem 0.5rem 2.5rem;
        }
        .search-input-group > i {
            font-size: 0.9rem;
            left: 0.85rem;
        }
    }

    @media (max-width: 576px) {
        .search-input-group input {
            font-size: 16px !important;
        }
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

    .btn-reset:hover {
        background: var(--text-light);
        color: white;
    }

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
       SELLERS CONTAINER
       ============================================ */
    .sellers-container {
        background: var(--card-bg);
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 4px 15px var(--shadow);
        border: 1px solid var(--border);
        transition: all 0.3s ease;
    }

    .sellers-table {
        width: 100%;
        margin-bottom: 0;
        background-color: var(--table-row-bg);
        table-layout: fixed;
        min-width: 750px;
    }

    /* پانیی کۆڵۆمەکان — دیاریکراو */
    .sellers-table thead th:nth-child(1) { width: 50px; }    /* ژ */
    .sellers-table thead th:nth-child(2) { width: 280px; }   /* فرۆشیار */
    .sellers-table thead th:nth-child(3) { width: 120px; }   /* ژمارەی کاڵاکان */
    .sellers-table thead th:nth-child(4) { width: 120px; }   /* کردار */

    @media (max-width: 992px) {
        .sellers-table { min-width: 700px; }
        .sellers-table thead th:nth-child(1) { width: 45px; }
        .sellers-table thead th:nth-child(2) { width: 200px; }
        .sellers-table thead th:nth-child(3) { width: 110px; }
        .sellers-table thead th:nth-child(4) { width: 260px; }
    }

    .sellers-table thead th {
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
        .sellers-table thead th {
            padding: 0.6rem 0.5rem;
            font-size: 0.75rem;
        }
    }

    .sellers-table tbody tr {
        background-color: var(--table-row-bg);
        transition: background-color 0.2s ease;
    }

    .sellers-table tbody tr:nth-child(even) {
        background-color: var(--table-row-alt-bg);
    }

    .sellers-table tbody tr:hover {
        background: var(--table-hover) !important;
    }

    .sellers-table tbody td {
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
        .sellers-table tbody td {
            padding: 0.5rem;
            font-size: 0.8rem;
        }
    }

    /* ============================================
       TABLE → CARDS - MOBILE
       ============================================ */
    @media (max-width: 767px) {
        .sellers-container {
            background: transparent !important;
            box-shadow: none !important;
            border-radius: 0;
            overflow: visible !important;
            border: none;
        }

        .sellers-table {
            display: block;
            min-width: 0 !important;
            table-layout: auto;
        }

        .sellers-table thead { display: none; }
        .sellers-table tbody { display: block; }

        .sellers-table tbody tr {
            display: block;
            background: var(--card-bg) !important;
            border-radius: 12px;
            margin-bottom: 10px;
            padding: 12px;
            border: 1px solid var(--border) !important;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
        }

        body.dark-mode .sellers-table tbody tr {
            background: var(--card-bg) !important;
            border-color: var(--border) !important;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        }

        .sellers-table tbody tr:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .sellers-table tbody td {
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

        .sellers-table tbody td:last-child {
            border-bottom: none !important;
        }

        .sellers-table tbody td::before {
            content: attr(data-label);
            font-weight: 700;
            font-size: 0.7rem;
            text-transform: uppercase;
            flex-shrink: 0;
            text-align: left;
            color: var(--primary);
        }

        body.dark-mode .sellers-table tbody td::before {
            color: #94a3b8;
        }

        .sellers-table tbody td[data-label="فرۆشیار"] {
            border-bottom: 2px solid var(--border) !important;
            padding-bottom: 10px !important;
            justify-content: center;
            text-align: center;
            margin-bottom: 6px;
        }

        .sellers-table tbody td[data-label="فرۆشیار"]::before {
            display: none;
        }

        .action-buttons {
            width: 100%;
            justify-content: center;
        }

        .btn-action {
            flex: 1;
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .sellers-table tbody tr {
            padding: 10px;
            margin-bottom: 8px;
        }
        .sellers-table tbody td {
            font-size: 0.75rem;
            padding: 5px 0 !important;
        }
        .sellers-table tbody td::before {
            font-size: 0.65rem;
        }
    }

    /* ============================================
       SELLER NAME / AVATAR
       ============================================ */
    .seller-name {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        min-width: 0;
    }

    .seller-avatar {
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

    .seller-name-text {
        font-weight: 600;
        color: var(--text);
        font-size: 0.95rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .seller-id-badge {
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

    body.dark-mode .products-count {
        background: #1e3a8a;
        color: #bfdbfe;
    }

    .products-count.has-products {
        background: #d1fae5;
        color: #065f46;
    }

    body.dark-mode .products-count.has-products {
        background: #064e3b;
        color: #d1fae5;
    }

    /* ============================================
       ACTION BUTTONS
       ============================================ */
    .action-buttons {
        display: flex;
        gap: 0.3rem;
        flex-wrap: nowrap;
        justify-content: flex-start;
    }

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

    .btn-action:hover {
        transform: translateY(-2px);
    }

    .btn-edit {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white;
    }

    .btn-edit:hover {
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }

    .btn-view {
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        color: white;
        padding: 0.4rem 0.6rem;
    }

    .btn-view:hover {
        box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);
    }

    .btn-delete {
        background: transparent;
        border: 1px solid #ef4444;
        color: #ef4444;
        padding: 0.35rem 0.6rem;
    }

    .btn-delete:hover {
        background: #ef4444;
        color: white;
    }

    body.dark-mode .btn-delete {
        border-color: #f87171;
        color: #f87171;
    }

    body.dark-mode .btn-delete:hover {
        background: #f87171;
        color: white;
    }

    .btn-delete:disabled,
    .btn-delete.disabled {
        opacity: 0.4;
        cursor: not-allowed;
        transform: none !important;
    }

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

    .loading-state {
        text-align: center;
        padding: 3rem;
        color: var(--text-light);
    }

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
        .pagination-wrapper {
            flex-direction: column;
            justify-content: center;
            padding: 0.85rem 0.75rem;
        }
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

    @media (max-width: 768px) {
        .page-link { padding: 0.4rem 0.6rem; font-size: 0.75rem; }
    }

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

    .per-page-select option {
        background-color: var(--input-bg);
        color: var(--input-text);
    }

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

    .modal-header {
        padding: 1.25rem 1.5rem;
        border-bottom: none;
    }

    .modal-header.purple {
        background: linear-gradient(135deg, #4a6491, #2c3e50);
        color: white;
    }

    .modal-header.blue {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white;
    }

    .modal-header.red {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
    }

    .modal-header.green {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }

    .modal-header .btn-close {
        filter: invert(1);
        opacity: 0.9;
    }

    .modal-body { padding: 1.5rem; }

    .modal-footer {
        padding: 1rem 1.5rem;
        border-top: 1px solid var(--border);
        gap: 0.5rem;
    }

    body.dark-mode .modal-footer {
        background-color: var(--modal-bg);
        border-top-color: var(--border);
    }

    /* ============================================
       FORM CONTROLS
       ============================================ */
    .form-label {
        font-weight: 600;
        color: var(--text);
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }

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

    .btn-modal-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(74, 100, 145, 0.4);
    }

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

    .btn-modal-secondary:hover {
        background: var(--text-light);
        color: white;
    }

    body.dark-mode .btn-modal-secondary {
        background: #475569;
        color: #e2e8f0;
    }

    body.dark-mode .btn-modal-secondary:hover {
        background: #334155;
    }

    /* ============================================
       PRODUCT CARDS IN MODAL — FULL RESPONSIVE
       ============================================ */
    .products-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(110px, 1fr));
        gap: 0.5rem;
        padding: 0.85rem;
        background: var(--bg-light);
        border-bottom: 1px solid var(--border);
    }

    .stat-box {
        text-align: center;
        padding: 0.55rem 0.4rem;
        background: var(--card-bg);
        border-radius: 10px;
        border: 1px solid var(--border);
    }

    .stat-box-label {
        font-size: 0.65rem;
        color: var(--text-light);
        font-weight: 600;
        margin-bottom: 0.2rem;
    }

    .stat-box-value {
        font-size: 0.95rem;
        font-weight: 800;
        color: var(--primary);
    }

    @media (max-width: 480px) {
        .products-stats { grid-template-columns: repeat(2, 1fr); padding: 0.6rem; }
        .stat-box-value { font-size: 0.85rem; }
    }

    .products-list {
        max-height: 65vh;
        overflow-y: auto;
        padding: 0.5rem;
    }

    .product-card {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 1rem;
        margin-bottom: 0.85rem;
        transition: all 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px var(--shadow);
        border-color: var(--primary);
    }

    .product-card-header {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        margin-bottom: 0.75rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid var(--border);
    }

    .product-card-img {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        object-fit: cover;
        border: 1px solid var(--border);
        flex-shrink: 0;
        background: var(--bg-light);
    }

    .product-card-title {
        flex: 1;
        min-width: 0;
    }

    .product-card-name {
        font-weight: 700;
        font-size: 0.95rem;
        color: var(--text);
        margin-bottom: 0.2rem;
        word-break: break-word;
    }

    .product-card-company {
        font-size: 0.78rem;
        color: var(--text-light);
        display: flex;
        align-items: center;
        gap: 0.35rem;
        flex-wrap: wrap;
    }

    .product-card-stock {
        padding: 0.3rem 0.7rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .stock-good { background: #d1fae5; color: #065f46; }
    .stock-low { background: #fed7aa; color: #92400e; }
    .stock-out { background: #fee2e2; color: #991b1b; }

    body.dark-mode .stock-good { background: #065f46; color: #d1fae5; }
    body.dark-mode .stock-low { background: #92400e; color: #fed7aa; }
    body.dark-mode .stock-out { background: #7f1d1d; color: #fecaca; }

    .product-card-body {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
        gap: 0.6rem;
    }

    .product-detail {
        background: var(--bg-light);
        border-radius: 10px;
        padding: 0.55rem 0.7rem;
        border: 1px solid var(--border);
    }

    .product-detail-label {
        font-size: 0.68rem;
        color: var(--text-light);
        text-transform: uppercase;
        font-weight: 600;
        margin-bottom: 0.15rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .product-detail-value {
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--text);
        word-break: break-word;
    }

    .product-detail-value.price-buy { color: #ef4444; }
    .product-detail-value.price-sell { color: #10b981; }
    .product-detail-value.profit { color: #3b82f6; }

    .critical-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        background: #fee2e2;
        color: #991b1b;
        padding: 0.2rem 0.55rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 700;
        margin-top: 0.35rem;
    }

    body.dark-mode .critical-badge {
        background: #7f1d1d;
        color: #fecaca;
    }

    .product-notes {
        margin-top: 0.6rem;
        padding: 0.55rem 0.7rem;
        background: #fff7ed;
        border-right: 3px solid #f59e0b;
        border-radius: 8px;
        font-size: 0.78rem;
        color: #9a3412;
    }

    body.dark-mode .product-notes {
        background: #78350f;
        color: #fde68a;
    }

    @media (max-width: 768px) {
        .product-card { padding: 0.85rem; border-radius: 12px; }
        .product-card-img { width: 50px; height: 50px; }
        .product-card-name { font-size: 0.88rem; }
        .product-detail { padding: 0.45rem 0.55rem; }
        .product-detail-value { font-size: 0.78rem; }
        .product-detail-label { font-size: 0.62rem; }
    }

    @media (max-width: 480px) {
        .product-card { padding: 0.7rem; margin-bottom: 0.6rem; }
        .product-card-img { width: 45px; height: 45px; border-radius: 10px; }
        .product-card-body {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.45rem;
        }
        .product-card-name { font-size: 0.82rem; }
        .product-detail { padding: 0.4rem 0.5rem; }
        .product-detail-value { font-size: 0.72rem; }
    }

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

    .custom-alert strong {
        display: block;
        margin-bottom: 0.15rem;
        font-size: 0.9rem;
    }

    .custom-alert div:last-child {
        font-size: 0.85rem;
        word-break: break-word;
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .alert-success-c { background: linear-gradient(135deg, #d1fae5, #a7f3d0); color: #065f46; border-right: 4px solid #10b981; }
    .alert-error-c { background: linear-gradient(135deg, #fee2e2, #fecaca); color: #991b1b; border-right: 4px solid #ef4444; }
    .alert-warning-c { background: linear-gradient(135deg, #fff3e3, #fed7aa); color: #9a3412; border-right: 4px solid #f59e0b; }
    .alert-info-c { background: linear-gradient(135deg, #dbeafe, #bfdbfe); color: #1e3a8a; border-right: 4px solid #3b82f6; }

    body.dark-mode .alert-success-c { background: linear-gradient(135deg, #064e3b, #065f46); color: #a7f3d0; }
    body.dark-mode .alert-error-c { background: linear-gradient(135deg, #7f1d1d, #991b1b); color: #fecaca; }
    body.dark-mode .alert-warning-c { background: linear-gradient(135deg, #78350f, #92400e); color: #fde68a; }
    body.dark-mode .alert-info-c { background: linear-gradient(135deg, #1e3a8a, #1e40af); color: #bfdbfe; }

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
                    <i class="fas fa-user-tie me-2"></i>
                    بەڕێوەبردنی فرۆشیارەکان
                </h2>
                <p class="mb-0 opacity-75">
                    <i class="fas fa-info-circle me-1"></i>
                    زیادکردن، دەستکاریکردن و سڕینەوەی فرۆشیارەکان
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
                    <input type="text" id="search-seller" placeholder="گەڕان بە ناوی فرۆشیار ..." autocomplete="off">
                </div>
            </div>
            <div class="col-12 col-md-3">
                <button class="btn-add-main w-100" onclick="openAddModal()">
                    <i class="fas fa-plus-circle"></i>
                    زیادکردنی فرۆشیاری نوێ
                </button>
            </div>
            <div class="col-12 col-md-3">
                <button class="btn-reset" onclick="resetFilters()">
                    <i class="fas fa-undo-alt"></i> ڕێکخستنەوە
                </button>
            </div>
        </div>
    </div>

    <!-- Sellers Table -->
    <div class="sellers-container">
        <table class="sellers-table table">
            <thead>
                <tr>
                    <th>ژ</th>
                    <th>فرۆشیار</th>
                    <th>ژمارەی کاڵاکان</th>
                    <th>کردار</th>
                </tr>
            </thead>
            <tbody id="sellers-body">
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
                <span class="text-muted" style="font-size: 0.85rem;">فرۆشیار لە لاپەڕە:</span>
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

<!-- ADD SELLER MODAL -->
<div class="modal fade" id="addSellerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header purple">
                <h5 class="modal-title">
                    <i class="fas fa-user-plus me-2"></i> زیادکردنی فرۆشیاری نوێ
                </h5>
              
            </div>
            <form id="add-seller-form">
                <div class="modal-body">
                    <label class="form-label">
                        <span class="text-danger">*</span> ناوی فرۆشیار
                    </label>
                    <input type="text"
                           id="add-seller-name"
                           class="form-control"
                           placeholder="ناوی فرۆشیار بنووسە ..."
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
                    <button type="submit" class="btn-modal-primary" id="save-seller-btn">
                        <i class="fas fa-save me-1"></i> تۆمارکردن
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- EDIT SELLER MODAL -->
<div class="modal fade" id="editSellerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header blue">
                <h5 class="modal-title">
                    <i class="fas fa-user-edit me-2"></i> دەستکاریکردنی ناوی فرۆشیار
                </h5>
        \
            </div>
            <form id="edit-seller-form">
                <div class="modal-body">
                    <input type="hidden" id="edit-seller-id">
                    <label class="form-label">
                        <span class="text-danger">*</span> ناوی فرۆشیار
                    </label>
                    <input type="text"
                           id="edit-seller-name"
                           class="form-control"
                           placeholder="ناوی فرۆشیار بنووسە ..."
                           autocomplete="off"
                           required
                           maxlength="255">
                    <div class="invalid-feedback" id="edit-name-error"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> پاشگەزبوونەوە
                    </button>
                    <button type="submit" class="btn-modal-primary" id="update-seller-btn">
                        <i class="fas fa-save me-1"></i> نوێکردنەوە
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- DELETE SELLER MODAL -->
<div class="modal fade" id="deleteSellerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header red">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle me-2"></i> دڵنیایت؟
                </h5>
               
            </div>
            <div class="modal-body text-center">
                <i class="fas fa-trash-alt fa-3x text-danger mb-3 d-block"></i>
                <p class="mb-2">دەتەوێت ئەم فرۆشیارە بسڕیتەوە؟</p>
                <p class="fw-bold mb-0" id="delete-seller-name" style="color: var(--danger);"></p>
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

<!-- SELLER PRODUCTS MODAL — FULL RESPONSIVE -->
<div class="modal fade" id="sellerProductsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header green">
                <h5 class="modal-title">
                    <i class="fas fa-boxes me-2"></i>
                    کاڵاکانی <span id="products-seller-name"></span>
                </h5>
               
            </div>

            <!-- Statistics Bar -->
            <div class="products-stats" id="products-stats" style="display:none;">
                <div class="stat-box">
                    <div class="stat-box-label">کۆی کاڵا</div>
                    <div class="stat-box-value" id="stat-total-products">0</div>
                </div>
                <div class="stat-box">
                    <div class="stat-box-label">کۆی بڕ</div>
                    <div class="stat-box-value" id="stat-total-stock">0</div>
                </div>
                <div class="stat-box">
                    <div class="stat-box-label">کڕین</div>
                    <div class="stat-box-value" id="stat-total-purchase">0</div>
                </div>
                <div class="stat-box">
                    <div class="stat-box-label">فرۆشتن</div>
                    <div class="stat-box-value" id="stat-total-selling">0</div>
                </div>
                <div class="stat-box">
                    <div class="stat-box-label">قازانج</div>
                    <div class="stat-box-value" id="stat-total-profit">0</div>
                </div>
            </div>

            <div class="modal-body p-2 p-md-3" style="background: var(--bg-light);">
                <div class="products-list" id="products-list-container">
                    <div class="text-center py-5">
                        <i class="fas fa-spinner fa-spin fa-2x text-primary"></i>
                        <p class="mt-2 mb-0">بارکردنی کاڵاکان...</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-secondary w-100" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> داخستن
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
let addModal, editModal, deleteModal, productsModal;
let deleteSellerId = null;
let debounceTimer;
let allSellersCache = [];

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

function getImageUrl(path) {
    if (!path) return '';
    if (path.startsWith('http')) return path;
    if (path.startsWith('/')) return path;
    return '/' + path;
}

function getInitials(name) {
    if (!name) return '?';
    return name.trim().charAt(0).toUpperCase();
}

function formatNumber(num) {
    const n = parseFloat(num) || 0;
    return n.toLocaleString('en-US', { maximumFractionDigits: 2 });
}

function formatDate(dateStr) {
    if (!dateStr) return '—';
    try {
        const d = new Date(dateStr);
        const y = d.getFullYear();
        const m = String(d.getMonth() + 1).padStart(2, '0');
        const day = String(d.getDate()).padStart(2, '0');
        return `${y}/${m}/${day}`;
    } catch (e) {
        return dateStr;
    }
}

// ==================== LOAD SELLERS ====================
function loadSellers(page = 1) {
    $('#loading-overlay').addClass('active');
    const perPage = $('#per-page').val() || 15;

    $.ajax({
        url: '{{ route("sellers.list") }}',
        type: 'GET',
        data: {
            page: page,
            per_page: perPage,
            search: currentSearch
        },
        success: function (res) {
            
            if (res.success) {
                console.log(res)
                allSellersCache = res.sellers || [];
                renderSellers(res.sellers);
                renderPagination(res);
                $('#pagination-wrapper').toggle(res.last_page > 1);
            } else {
                showAlert('error', res.message || 'هەڵە لە بارکردن');
            }
        },
        error: function () {
            showAlert('error', 'هەڵە لە پەیوەندیدا');
            $('#sellers-body').html(`
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
function renderSellers(sellers) {
    const tbody = $('#sellers-body');

    if (!sellers || sellers.length === 0) {
        tbody.html(`
            <tr><td colspan="4" class="empty-state">
                <i class="fas fa-user-slash"></i>
                <p class="mb-2">هیچ فرۆشیارێک نەدۆزرایەوە</p>
                <button class="btn-add-main" onclick="openAddModal()" style="margin: 0 auto;">
                    <i class="fas fa-plus-circle"></i> زیادکردنی فرۆشیاری نوێ
                </button>
            </td></tr>`);
        return;
    }

    const perPage = parseInt($('#per-page').val()) || 15;
    const startIndex = (currentPage - 1) * perPage;
    let html = '';

    sellers.forEach((seller, index) => {
        const rowNum = startIndex + index + 1;
        const productsCount = seller.products_count || 0;
        const hasProducts = productsCount > 0;
        const initials = getInitials(seller.name);

        html += `
            <tr data-seller-id="${seller.id}">
                <td data-label="ژ">${rowNum}</td>
                <td data-label="فرۆشیار">
                    <div class="seller-name">
                        <div class="seller-avatar">${escapeHtml(initials)}</div>
                        <div style="min-width:0;">
                            <div class="seller-name-text">${escapeHtml(seller.name)}</div>
                            <span class="seller-id-badge">#${seller.id}</span>
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
                        <button class="btn-action btn-view"
                                onclick="viewSellerProducts(${seller.id}, '${escapeHtml(seller.name)}')"
                                title="بینینی کاڵاکان">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn-action btn-edit"
                                onclick="openEditModal(${seller.id}, '${escapeHtml(seller.name)}')"
                                title="دەستکاریکردن">
                            <i class="fas fa-edit"></i> دەستکاری
                        </button>
                        <button class="btn-action btn-delete ${hasProducts ? 'disabled' : ''}"
                                onclick="${hasProducts ? "showAlert('warning', 'ناتوانرێت بسڕدرێتەوە — کاڵای پەیوەست هەیە')" : `openDeleteModal(${seller.id}, '${escapeHtml(seller.name)}')`}"
                                title="${hasProducts ? 'ناتوانرێت بسڕدرێتەوە' : 'سڕینەوە'}"
                                ${hasProducts ? 'disabled' : ''}>
                            <i class="fas fa-trash"></i> سڕینەوە
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
            loadSellers(page);
            $('html, body').animate({ scrollTop: $('.sellers-container').offset().top - 100 }, 300);
        }
    });
}

// ==================== RESET ====================
function resetFilters() {
    $('#search-seller').val('');
    currentSearch = '';
    currentPage = 1;
    loadSellers(1);
}

// ==================== ADD ====================
function openAddModal() {
    $('#add-seller-name').val('').removeClass('is-invalid');
    $('#add-name-error').removeClass('show').text('');
    addModal.show();
    setTimeout(() => $('#add-seller-name').focus(), 300);
}

$('#add-seller-form').on('submit', function (e) {
    e.preventDefault();
    const name = $('#add-seller-name').val().trim();

    if (!name) {
        $('#add-seller-name').addClass('is-invalid');
        $('#add-name-error').addClass('show').text('تکایە ناوی فرۆشیار بنووسە');
        return;
    }

    const btn = $('#save-seller-btn');
    btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> تۆمار دەکرێت...');

    $.ajax({
        url: '{{ route("sellers.store") }}',
        type: 'POST',
        data: { voucher_name: name },
        success: function (res) {
            if (res.success) {
                showAlert('success', 'فرۆشیار بە سەرکەوتوویی زیادکرا');
                addModal.hide();
                currentPage = 1;
                loadSellers(1);
            } else {
                showAlert('error', res.message || 'هەڵەیەک ڕوویدا');
            }
        },
        error: function (xhr) {
            let msg = 'هەڵەیەک ڕوویدا';
            if (xhr.responseJSON?.errors?.voucher_name) {
                msg = xhr.responseJSON.errors.voucher_name[0];
                $('#add-seller-name').addClass('is-invalid');
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
    $('#edit-seller-id').val(id);
    $('#edit-seller-name').val(name).removeClass('is-invalid');
    $('#edit-name-error').removeClass('show').text('');
    editModal.show();
    setTimeout(() => $('#edit-seller-name').focus().select(), 300);
}

$('#edit-seller-form').on('submit', function (e) {
    e.preventDefault();
    const id = $('#edit-seller-id').val();
    const name = $('#edit-seller-name').val().trim();

    if (!name) {
        $('#edit-seller-name').addClass('is-invalid');
        $('#edit-name-error').addClass('show').text('تکایە ناوی فرۆشیار بنووسە');
        return;
    }

    const btn = $('#update-seller-btn');
    btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> نوێ دەکرێتەوە...');

    $.ajax({
        url: '{{ route("sellers.update") }}',
        type: 'POST',
        data: { id: id, voucher_name: name },
        success: function (res) {
            if (res.success) {
                showAlert('success', 'ناوی فرۆشیار بە سەرکەوتوویی نوێکرایەوە');
                editModal.hide();
                loadSellers(currentPage);
            } else {
                showAlert('error', res.message || 'هەڵەیەک ڕوویدا');
            }
        },
        error: function (xhr) {
            let msg = 'هەڵەیەک ڕوویدا';
            if (xhr.responseJSON?.errors?.voucher_name) {
                msg = xhr.responseJSON.errors.voucher_name[0];
                $('#edit-seller-name').addClass('is-invalid');
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
    deleteSellerId = id;
    $('#delete-seller-name').text(name);
    deleteModal.show();
}

$('#confirm-delete-btn').on('click', function () {
    if (!deleteSellerId) return;
    const btn = $(this);
    btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> سڕینەوە...');

    $.ajax({
        url: '/sellers/' + deleteSellerId + '/delete',
        type: 'DELETE',
        success: function (res) {
            if (res.success) {
                showAlert('success', 'فرۆشیار بە سەرکەوتوویی سڕایەوە');
                deleteModal.hide();
                loadSellers(currentPage);
            } else {
                showAlert('error', res.message || 'هەڵەیەک ڕوویدا');
            }
        },
        error: function (xhr) {
            showAlert('error', xhr.responseJSON?.message || 'هەڵە لە سڕینەوەدا');
        },
        complete: function () {
            btn.prop('disabled', false).html('<i class="fas fa-trash me-1"></i> سڕینەوە');
            deleteSellerId = null;
        }
    });
});

// ==================== VIEW PRODUCTS ====================
function viewSellerProducts(id, name) {
    $('#products-seller-name').text(name);
    $('#products-stats').hide();
    $('#products-list-container').html(`
        <div class="text-center py-5">
            <i class="fas fa-spinner fa-spin fa-2x text-primary"></i>
            <p class="mt-2 mb-0">بارکردنی کاڵاکان...</p>
        </div>`);
    productsModal.show();

    $.ajax({
        url: '/sellers/' + id + '/products',
        type: 'GET',
        success: function (res) {
            if (res.success) {
                renderSellerProducts(res.products, res.statistics);
            } else {
                $('#products-list-container').html(`
                    <div class="empty-state">
                        <i class="fas fa-exclamation-circle"></i>
                        <p>${escapeHtml(res.message || 'هەڵەیەک ڕوویدا')}</p>
                    </div>`);
            }
        },
        error: function () {
            $('#products-list-container').html(`
                <div class="empty-state">
                    <i class="fas fa-exclamation-circle"></i>
                    <p>هەڵە لە پەیوەندیدا</p>
                </div>`);
        }
    });
}

// ==================== RENDER PRODUCTS (کارت) ====================
function renderSellerProducts(products, stats) {
    if (!products || products.length === 0) {
        $('#products-list-container').html(`
            <div class="empty-state">
                <i class="fas fa-box-open"></i>
                <p>هیچ کاڵایەک نییە بۆ ئەم فرۆشیارە</p>
            </div>`);
        $('#products-stats').hide();
        return;
    }

    if (stats) {
        $('#stat-total-products').text(stats.total_products || 0);
        $('#stat-total-stock').text(stats.total_stock || 0);
        $('#stat-total-purchase').text(formatNumber(stats.total_purchase));
        $('#stat-total-selling').text(formatNumber(stats.total_selling));
        $('#stat-total-profit').text(formatNumber(stats.total_profit));
        $('#products-stats').show();
    }

    let html = '';
    products.forEach(p => {
        const stock = parseInt(p.counter) || 0;
        let stockClass = 'stock-good';
        let stockIcon = 'fa-check-circle';
        if (stock < 0) { stockClass = 'stock-out'; stockIcon = 'fa-exclamation-circle'; }
        else if (stock === 0) { stockClass = 'stock-out'; stockIcon = 'fa-times-circle'; }
        else if (stock < 3) { stockClass = 'stock-out'; stockIcon = 'fa-exclamation-triangle'; }
        else if (stock < 10) { stockClass = 'stock-low'; stockIcon = 'fa-exclamation-triangle'; }

        const imgUrl = p.image_url || getImageUrl(p.image_producte_path) || getImageUrl(p.image_product_camera);
        const imgHtml = imgUrl
            ? `<img src="${escapeHtml(imgUrl)}" class="product-card-img" onerror="this.onerror=null;this.src='data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2260%22%20height%3D%2260%22%3E%3Crect%20width%3D%2260%22%20height%3D%2260%22%20fill%3D%22%23cbd5e1%22%2F%3E%3C%2Fsvg%3E'">`
            : `<div class="product-card-img" style="display:flex;align-items:center;justify-content:center;"><i class="fas fa-box text-muted fa-lg"></i></div>`;

        let criticalHtml = '';
        if (p.in_critical_list == 1) {
            criticalHtml = `
                <div class="critical-badge">
                    <i class="fas fa-exclamation-triangle"></i>
                    لە لیستی گرنگدا
                    ${p.added_to_critical_list_at ? ` — ${formatDate(p.added_to_critical_list_at)}` : ''}
                </div>`;
        }

        let notesHtml = '';
        if (p.critical_list_notes && p.critical_list_notes.trim() !== '') {
            notesHtml = `
                <div class="product-notes">
                    <i class="fas fa-sticky-note me-1"></i>
                    <strong>تێبینی:</strong> ${escapeHtml(p.critical_list_notes)}
                </div>`;
        }

        html += `
            <div class="product-card">
                <div class="product-card-header">
                    ${imgHtml}
                    <div class="product-card-title">
                        <div class="product-card-name me-1">${escapeHtml(p.name || 'بێ ناو')}</div>
                        <div class="product-card-company ">
                            <span class="ms-3"><i class="fas fa-building ms-1"></i>${escapeHtml(p.company || 'بێ کۆمپانیا')}</span>
                            ${p.barcode ? `<span><i class="fas fa-barcode ms-1"></i>${escapeHtml(p.barcode)}</span>` : ''}
                        </div>
                        ${criticalHtml}
                    </div>
                    <div class="product-card-stock ${stockClass}">
                        <i class="fas ${stockIcon} ms-2"></i>${stock}
                    </div>
                </div>

                <div class="product-card-body">
                    <div class="product-detail">
                        <div class="product-detail-label"><i class="fas fa-shopping-cart"></i> نرخی کڕین</div>
                        <div class="product-detail-value price-buy">${formatNumber(p.purchase_price)}</div>
                    </div>
                    <div class="product-detail">
                        <div class="product-detail-label"><i class="fas fa-tag"></i> نرخی فرۆشتن</div>
                        <div class="product-detail-value price-sell">${formatNumber(p.selling_price)}</div>
                    </div>
                    <div class="product-detail">
                        <div class="product-detail-label"><i class="fas fa-cubes"></i> کۆگا</div>
                        <div class="product-detail-value">${stock}</div>
                    </div>
                    <div class="product-detail">
                        <div class="product-detail-label"><i class="fas fa-exclamation-circle"></i> کەمترین</div>
                        <div class="product-detail-value">${p.minimum_wearhouse || 0}</div>
                    </div>
                    <div class="product-detail">
                        <div class="product-detail-label"><i class="fas fa-coins"></i> کۆی کڕین</div>
                        <div class="product-detail-value price-buy">${formatNumber(p.purchase_total)}</div>
                    </div>
                    <div class="product-detail">
                        <div class="product-detail-label"><i class="fas fa-money-bill-wave"></i> کۆی فرۆشتن</div>
                        <div class="product-detail-value price-sell">${formatNumber(p.selling_total)}</div>
                    </div>
                    <div class="product-detail">
                        <div class="product-detail-label"><i class="fas fa-chart-line"></i> قازانج</div>
                        <div class="product-detail-value profit">${formatNumber(p.profit)}</div>
                    </div>
                    <div class="product-detail">
                        <div class="product-detail-label"><i class="fas fa-calendar"></i> بەروار</div>
                        <div class="product-detail-value">${formatDate(p.created_at)}</div>
                    </div>
                </div>

                ${notesHtml}
            </div>`;
    });

    $('#products-list-container').html(html);
}

// ==================== DOCUMENT READY ====================
$(document).ready(function () {
    addModal = new bootstrap.Modal(document.getElementById('addSellerModal'));
    editModal = new bootstrap.Modal(document.getElementById('editSellerModal'));
    deleteModal = new bootstrap.Modal(document.getElementById('deleteSellerModal'));
    productsModal = new bootstrap.Modal(document.getElementById('sellerProductsModal'));

    loadSellers(1);

    $('#search-seller').on('input', function () {
        clearTimeout(debounceTimer);
        const val = $(this).val().trim();
        debounceTimer = setTimeout(() => {
            currentSearch = val;
            currentPage = 1;
            loadSellers(1);
        }, 400);
    });

    $('#per-page').on('change', function () {
        currentPage = 1;
        loadSellers(1);
    });

    $('#add-seller-name').on('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            $('#add-seller-form').submit();
        }
    });

    $('#edit-seller-name').on('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            $('#edit-seller-form').submit();
        }
    });
});
</script>
@endsection