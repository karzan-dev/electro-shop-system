{{--
    resources/views/debtors/index.blade.php
    List of debtors (قەرزارەکان) with search, filtering, and responsive design
    DARK MODE SUPPORTED
    EACH PRODUCT IN SEPARATE ROW - NO GROUPING
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
        --dark: #1e293b;
        --light: #f8fafc;
        --text: #1e293b;
        --text-secondary: #64748b;
        --border-color: #e2e8f0;
        --bg-light: #f8fafc;
        --card-bg: #ffffff;
        --input-bg: #f8fafc;
        --table-hover: #f8fafc;
        --glass-bg: rgba(255, 255, 255, 0.95);
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
        --glass-bg: rgba(30, 41, 59, 0.95);
        background: #0f172a;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
        min-height: 100vh;
        color: var(--text);
    }

    body.dark-mode {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-fade-in-up { animation: fadeInUp 0.5s ease forwards; }
    .animate-delay-100 { animation-delay: 0.1s; }
    .animate-delay-200 { animation-delay: 0.2s; }
    .animate-delay-300 { animation-delay: 0.3s; }
    .animate-delay-400 { animation-delay: 0.4s; }
    .animate-delay-500 { animation-delay: 0.5s; }

    .debtors-container {
        padding: 20px 16px;
        max-width: 1600px;
        margin: 0 auto;
    }

    @media (min-width: 768px) {
        .debtors-container { padding: 30px 24px; }
    }

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
        top: -50%;
        right: -20%;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .page-header::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -10%;
        width: 150px;
        height: 150px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
    }

    .page-header-left {
        position: relative;
        z-index: 1;
    }

    .page-title {
        font-size: 1.6rem;
        font-weight: 800;
        margin: 0 0 8px 0;
        position: relative;
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    @media (min-width: 768px) {
        .page-title { font-size: 2rem; }
    }

    .page-title i {
        background: rgba(255, 255, 255, 0.2);
        padding: 10px;
        border-radius: 20px;
    }

    .page-subtitle {
        font-size: 0.9rem;
        opacity: 0.9;
        position: relative;
    }

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
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: inline-flex;
        align-items: center;
        gap: 10px;
        font-size: 0.95rem;
        text-decoration: none;
        white-space: nowrap;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .btn-record-own-debt:hover {
        background: rgba(255, 255, 255, 0.3);
        border-color: rgba(255, 255, 255, 0.5);
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        color: white;
        text-decoration: none;
    }

    .btn-record-own-debt i {
        font-size: 1.2rem;
        background: rgba(255, 255, 255, 0.25);
        padding: 8px;
        border-radius: 12px;
        transition: all 0.3s;
    }

    .btn-record-own-debt:hover i {
        background: rgba(255, 255, 255, 0.4);
        transform: rotate(-10deg);
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

    .filter-bar {
        background: var(--card-bg);
        border-radius: 20px;
        padding: 16px;
        margin-bottom: 24px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--border-color);
    }

    body.dark-mode .filter-bar {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .filter-grid {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    @media (min-width: 768px) {
        .filter-grid {
            flex-direction: row;
            flex-wrap: wrap;
            align-items: flex-end;
            gap: 16px;
        }
        
        .filter-group {
            flex: 1;
            min-width: 160px;
        }
        
        .filter-group.search-group {
            flex: 2;
        }
        
        .filter-group.date-group {
            min-width: 140px;
        }
    }

    .filter-group label {
        display: block;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        color: var(--text-secondary);
        margin-bottom: 6px;
        letter-spacing: 0.5px;
    }

    .filter-input {
        width: 100%;
        padding: 10px 14px;
        border: 2px solid var(--border-color);
        border-radius: 14px;
        font-size: 0.9rem;
        transition: all 0.2s;
        background: var(--input-bg);
        color: var(--text);
    }

    .filter-input:focus {
        outline: none;
        border-color: var(--primary);
        background: var(--card-bg);
        box-shadow: 0 0 0 3px rgba(74, 100, 145, 0.1);
    }

    body.dark-mode .filter-input:focus {
        box-shadow: 0 0 0 3px rgba(108, 141, 184, 0.2);
    }

    .filter-input::placeholder {
        color: var(--text-secondary);
    }

    .btn-filter {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-filter:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(74, 100, 145, 0.3);
    }

    .btn-reset {
        background: var(--bg-light);
        color: var(--text);
        border: 2px solid var(--border-color);
        padding: 10px 20px;
        border-radius: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-reset:hover {
        background: var(--border-color);
    }

    .table-wrapper {
        background: var(--card-bg);
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--border-color);
    }

    body.dark-mode .table-wrapper {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }

    .debtors-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.8rem;
        color: var(--text);
    }

    @media (min-width: 768px) {
        .debtors-table { font-size: 0.9rem; }
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
        letter-spacing: 0.5px;
    }

    @media (min-width: 768px) {
        .debtors-table th { padding: 16px 12px; font-size: 0.8rem; }
    }

    .debtors-table td {
        padding: 12px 8px;
        text-align: center;
        border-bottom: 1px solid var(--border-color);
        vertical-align: middle;
    }

    @media (min-width: 768px) {
        .debtors-table td { padding: 14px 10px; }
    }

    .debtors-table tbody tr {
        transition: background 0.2s;
    }

    .debtors-table tbody tr.row-clickable {
        cursor: pointer;
    }

    .debtors-table tbody tr:hover {
        background: var(--table-hover);
    }

    .product-image {
        width: 40px;
        height: 40px;
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

    .badge-active {
        background: #dcfce7;
        color: #166534;
    }

    .badge-overdue {
        background: #fee2e2;
        color: #991b1b;
    }

    .badge-warning {
        background: #f6e8d3;
        color: #92400e;
    }
    .badge-warningg{
        background: #fef3c7;
        color: #78350f;
    }

    .amount-positive {
        color: var(--danger);
        font-weight: 700;
    }

    .action-btns {
        display: flex;
        gap: 6px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-icon {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        color: white;
        font-size: 0.85rem;
    }

    .btn-view {
        background: linear-gradient(135deg, var(--info), #2563eb);
    }

    .btn-icon:hover {
        transform: scale(1.1);
        filter: brightness(1.15);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

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

    .pagination {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }

    .pagination button, .pagination a {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--border-color);
        background: var(--card-bg);
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        color: var(--text);
        font-weight: 500;
    }

    .pagination button.active, .pagination a.active {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        border: none;
    }

    .pagination button:hover:not(.active), .pagination a:hover:not(.active) {
        background: var(--bg-light);
        border-color: var(--primary);
    }

    .showing-info {
        font-size: 0.8rem;
        color: var(--text-secondary);
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: var(--text-secondary);
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 20px;
        opacity: 0.5;
    }

    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(5px);
        z-index: 10000;
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        background: var(--card-bg);
        border-radius: 28px;
        width: 90%;
        max-width: 700px;
        max-height: 85vh;
        overflow-y: auto;
        animation: fadeInUp 0.3s ease;
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

    .modal-body {
        padding: 20px;
    }

    .modal-footer {
        padding: 16px 20px;
        border-top: 1px solid var(--border-color);
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        position: sticky;
        bottom: 0;
        background: var(--card-bg);
    }

    .close-modal {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        color: white;
        cursor: pointer;
        font-size: 1.2rem;
        transition: all 0.2s;
    }

    .close-modal:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: rotate(90deg);
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid var(--border-color);
    }

    .detail-label {
        font-weight: 700;
        color: var(--text-secondary);
    }

    .detail-value {
        color: var(--text);
        font-weight: 600;
    }

    .image-fullscreen-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.95);
        z-index: 12000;
        align-items: center;
        justify-content: center;
        cursor: zoom-out;
    }

    .image-fullscreen-overlay img {
        max-width: 95%;
        max-height: 95%;
        object-fit: contain;
        border-radius: 12px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        animation: zoomIn 0.3s ease;
    }

    @keyframes zoomIn {
        from { transform: scale(0.8); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    .image-fullscreen-close {
        position: absolute;
        top: 20px;
        right: 20px;
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.2);
        border: none;
        border-radius: 50%;
        color: white;
        font-size: 1.5rem;
        cursor: pointer;
        transition: all 0.3s;
        z-index: 12001;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .image-fullscreen-close:hover {
        background: rgba(255, 255, 255, 0.4);
        transform: rotate(90deg) scale(1.1);
    }

    .product-image-clickable {
        cursor: zoom-in;
        transition: all 0.3s;
    }

    .product-image-clickable:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .product-info-container {
        display: flex;
        align-items: center;
        gap: 10px;
        justify-content: center;
    }

    .required-star {
        color: var(--danger);
        margin-right: 2px;
    }

    .toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 11000;
        width: calc(100% - 40px);
        max-width: 360px;
    }

    .toast {
        background: var(--card-bg);
        border-radius: 16px;
        padding: 14px 16px;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        animation: slideInRight 0.3s ease;
        border-right: 4px solid;
        color: var(--text);
    }

    body.dark-mode .toast {
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    }

    .toast-success { border-right-color: var(--success); }
    .toast-error { border-right-color: var(--danger); }
    .toast-info { border-right-color: var(--info); }

    @keyframes slideInRight {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }

    .loading-spinner {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 2px solid var(--border-color);
        border-radius: 50%;
        border-top-color: var(--primary);
        animation: spin 0.6s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* 🔴 ستایلی تەیبڵی کۆی گشتییەکان */
    .summary-table-wrapper {
        background: var(--card-bg);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--border-color);
        margin-top: 24px;
    }

    body.dark-mode .summary-table-wrapper {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }

    .summary-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.85rem;
        color: var(--text);
    }

    .summary-table thead tr {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
    }

    .summary-table th {
        padding: 14px 12px;
        text-align: center;
        font-weight: 700;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .summary-table td {
        padding: 16px 12px;
        text-align: center;
        border-bottom: 1px solid var(--border-color);
        vertical-align: middle;
        font-weight: 700;
        font-size: 1rem;
    }

    .summary-table tbody tr {
        transition: background 0.2s;
    }

    .summary-table tbody tr:hover {
        background: var(--table-hover);
    }

    .summary-table .summary-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border-radius: 10px;
        color: white;
        margin-right: 10px;
        font-size: 0.9rem;
    }

    .summary-icon.debtors { background: linear-gradient(135deg, var(--primary-light), var(--primary)); }
    .summary-icon.amount { background: linear-gradient(135deg, #f59e0b, #d97706); }
    .summary-icon.paid { background: linear-gradient(135deg, #10b981, #059669); }
    .summary-icon.remaining { background: linear-gradient(135deg, #ef4444, #dc2626); }

    @media (max-width: 640px) {
        .debtors-table thead {
            display: none;
        }
        
        .debtors-table tbody tr {
            display: block;
            margin-bottom: 16px;
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 12px;
            background: var(--card-bg);
        }
        
        .debtors-table tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid var(--border-color);
            text-align: right;
        }
        
        .debtors-table tbody td:last-child {
            border-bottom: none;
        }
        
        .debtors-table tbody td::before {
            content: attr(data-label);
            font-weight: 700;
            font-size: 0.7rem;
            color: var(--primary);
            text-transform: uppercase;
        }
        
        .action-btns {
            justify-content: flex-end;
        }

        .page-header {
            flex-direction: column;
            align-items: stretch;
        }

        .btn-record-own-debt {
            width: 100%;
            justify-content: center;
        }

        .summary-table th,
        .summary-table td {
            padding: 10px 8px;
            font-size: 0.75rem;
        }
    }

    .modal-content::-webkit-scrollbar {
        width: 6px;
    }

    .modal-content::-webkit-scrollbar-track {
        background: var(--bg-light);
    }

    .modal-content::-webkit-scrollbar-thumb {
        background: var(--primary);
        border-radius: 3px;
    }

    .text-center { text-align: center; }
    .text-muted { color: var(--text-secondary); }
    .text-primary { color: var(--primary); }
    .me-2 { margin-right: 0.5rem; }
</style>

<div class="debtors-container">
    <!-- Page Header -->
    <div class="page-header animate-fade-in-up">
        <div class="page-header-left">
            <div class="page-title">
                <i class="fas fa-users"></i>
                <span>ڕاپۆرتی قەرزەکان</span>
            </div>
            <p class="page-subtitle">هەموو قەرزە تۆمارکراوەکان لێرە بەڕێوەبەرە</p>
        </div>

    </div>

    <!-- Filter Bar -->
    <div class="filter-bar animate-fade-in-up animate-delay-200">
        <div class="filter-grid">
            <div class="filter-group date-group">
                <label><i class="fas fa-calendar-alt"></i> بەرواری دەستپێک <span class="required-star">*</span></label>
                <input type="date" id="filter-start-date" class="filter-input">
            </div>
            <div class="filter-group date-group">
                <label><i class="fas fa-calendar-alt"></i> بەرواری کۆتایی <span class="required-star">*</span></label>
                <input type="date" id="filter-end-date" class="filter-input">
            </div>
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
            <div class="filter-group" style="display: flex; align-items: flex-end; gap: 8px;">
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

    <!-- 🔴 کۆی گشتییەکان - بە شێوەی تەیبڵ -->
    <div class="summary-table-wrapper animate-fade-in-up animate-delay-400" id="summary-table-container" style="display: none;">
        <div style="overflow-x: auto;">
            <table class="summary-table">
                <thead>
                    <tr>
                        <th><i class="fas fa-users me-2"></i> کۆی قەرزارەکان</th>
                        <th><i class="fas fa-hand-holding-usd me-2"></i> کۆی قەرزەکان (IQD)</th>
                        <th><i class="fas fa-check-circle me-2"></i> کۆی پارەی دراو (IQD)</th>
                        <th><i class="fas fa-exclamation-triangle me-2"></i> کۆی قەرزی ماوە (IQD)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <span class="summary-icon debtors"><i class="fas fa-users"></i></span>
                            <strong id="summary-total-debtors">0</strong>
                        </td>
                        <td>
                            <span class="summary-icon amount"><i class="fas fa-hand-holding-usd"></i></span>
                            <strong id="summary-total-amount">0</strong>
                        </td>
                        <td>
                            <span class="summary-icon paid"><i class="fas fa-check-circle"></i></span>
                            <strong id="summary-total-paid">0</strong>
                        </td>
                        <td>
                            <span class="summary-icon remaining"><i class="fas fa-exclamation-triangle"></i></span>
                            <strong id="summary-total-remaining">0</strong>
                        </td>
                    </tr>
                </tbody>
            </table>
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
        <div class="modal-body" id="modal-body">
            <div style="text-align:center;padding:40px;">
                <div class="loading-spinner"></div>
                <p style="margin-top:12px;color:var(--text-secondary);">بارده‌کێت...</p>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn-reset" onclick="closeModal()"><i class="fas fa-times"></i> داخستن</button>
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

// ==================== FULL SCREEN IMAGE ====================
function openFullscreenImage(imageUrl) {
    if (!imageUrl) return;
    const overlay = document.getElementById('image-fullscreen');
    const img = document.getElementById('fullscreen-image');
    img.src = imageUrl;
    overlay.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeFullscreenImage() {
    const overlay = document.getElementById('image-fullscreen');
    overlay.style.display = 'none';
    document.body.style.overflow = 'auto';
}

// ==================== TOAST ALERTS ====================
function showToast(message, type = 'success') {
    const id = 'toast-' + Date.now();
    const icon = type === 'success' ? 'fa-check-circle' : (type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle');
    const html = `<div id="${id}" class="toast toast-${type}">
        <i class="fas ${icon} fa-lg"></i>
        <span>${message}</span>
    </div>`;
    $('#toast-container').append(html);
    setTimeout(() => {
        $(`#${id}`).fadeOut(300, function() { $(this).remove(); });
    }, 4000);
}

// ==================== LOAD DEBTORS ====================
function loadDebtors() {
    const search = $('#search-input').val();
    const status = $('#status-filter').val();
    const sort = $('#sort-by').val();
    const startDate = $('#filter-start-date').val();
    const endDate = $('#filter-end-date').val();
    
    $.ajax({
        url: '{{ route("debtors.list") }}',
        type: 'GET',
        data: {
            page: currentPage,
            search: search,
            status: status,
            sort: sort,
            per_page: 15,
            start_date: startDate || '',
            end_date: endDate || ''
        },
        beforeSend: function() {
            $('#debtors-tbody').html('<tr><td colspan="10" class="empty-state"><i class="fas fa-spinner fa-pulse"></i><p>بارده‌کێت...</p></td></tr>');
        },
        success: function(response) {
            if (response.success) {
                currentDebtors = response.debtors.data;
                totalPages = response.debtors.last_page;
                responseTotal = response.debtors.total;
                renderDebtorsTable(currentDebtors);
                renderPagination();
                updateSummaryTable(response.summary);
            } else {
                showToast(response.message || 'هەڵەیەک ڕوویدا', 'error');
            }
        },
        error: function(xhr) {
            console.error('Error:', xhr);
            showToast('هەڵە لە گەڕانی داتا', 'error');
            $('#debtors-tbody').html('<tr><td colspan="10" class="empty-state"><i class="fas fa-exclamation-triangle"></i><p>هەڵەیەک ڕوویدا</p></td></tr>');
        }
    });
}

// 🔴 ئەپدەیتی تەیبڵی کۆی گشتییەکان
function updateSummaryTable(summary) {
    if (summary) {
        $('#summary-total-debtors').text(summary.total_debtors || 0);
        $('#summary-total-amount').text(formatNumber(summary.total_amount || 0));
        $('#summary-total-paid').text(formatNumber(summary.total_paid || 0));
        $('#summary-total-remaining').text(formatNumber(summary.total_remaining || 0));
        $('#summary-table-container').slideDown(300);
    }
}

function renderDebtorsTable(debtors) {
    if (!debtors || debtors.length === 0) {
        $('#debtors-tbody').html('<tr><td colspan="10" class="empty-state"><i class="fas fa-inbox"></i><p>هیچ قەرزارێک نەدۆزرایەوە</p></td></tr>');
        return;
    }
    
    let html = '';
    
    debtors.forEach((debtor, index) => {
        const statusClass =
            debtor.status === 'warning'
                ? 'badge-warningg'
                : debtor.status === 'overdue'
                    ? 'badge-overdue'
                    : debtor.status === 'paidoff'
                        ? 'badge-active'
                        : 'badge-warning';

        const statusText =
            debtor.status === 'warning'
                ? 'نزیکە'
                : debtor.status === 'overdue'
                    ? 'بەسەرچوو'
                    : debtor.status === 'paidoff'
                        ? 'پارەدراو'
                        : 'چالاک';

        const amountClass = debtor.pending_amount > 0 ? 'amount-positive' : '';
        
        const productName = debtor.product_name || '—';
        const company = debtor.company || '—';
        const productImage = debtor.product_image || null;
        
        html += `
        <tr class="row-clickable" onclick="showDebtorDetail(${debtor.id})" style="cursor: pointer;">
            <td data-label="ناوی کڕیار">
                <i class="fas fa-user text-primary me-2"></i> ${escapeHtml(debtor.customer_name || '—')}
            </td>
            <td data-label="ژمارەی مۆبایل">${escapeHtml(debtor.customer_phone || '—')}</td>
            <td data-label="ناونیشان">
                <i class="fas fa-map-marker-alt text-primary me-2"></i> ${escapeHtml(debtor.customer_address || '—')}
            </td>
            <td data-label="ناوی کاڵا" onclick="event.stopPropagation()">
                <div class="product-info-container">
                    ${productImage ? `<img src="${productImage}" alt="${escapeHtml(productName)}" class="product-image product-image-clickable" onclick="event.stopPropagation(); openFullscreenImage('${productImage}')" title="کلیک بکە بۆ بینینی گەورە">` : '<i class="fas fa-box text-primary"></i>'}
                    <span style="font-weight: 600;">${escapeHtml(productName)}</span>
                </div>
            </td>
            <td data-label="کۆمپانیا">${escapeHtml(company)}</td>
            <td data-label="بڕی پارەی ماوە" class="${amountClass}">${formatNumber(debtor.period)} IQD</td>
            <td data-label="بەرواری وەرگرتن">${formatDate(debtor.created_at)}</td>
            <td data-label="بەرواری کۆتایی">${formatDate(debtor.due_date)}</td>
            <td data-label="ڕەوش"><span class="badge-status ${statusClass}">${statusText}</span></td>
            <td data-label="کردارەکان" onclick="event.stopPropagation()">
                <div class="action-btns">
                    <button class="btn-icon btn-view" onclick="showDebtorDetail(${debtor.id})" title="بینین">
                        <i class="fas fa-eye"></i>
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

// ==================== DEBTOR DETAIL ====================
function showDebtorDetail(debtorId) {
    selectedDebtorId = debtorId;
    $('#detail-modal').css('display', 'flex');
    $('#modal-body').html('<div style="text-align:center;padding:40px;"><div class="loading-spinner"></div><p style="margin-top:12px;color:var(--text-secondary);">بارده‌کێت...</p></div>');
    
    const debtor = currentDebtors.find(d => d.id == debtorId);
    
    if (debtor) {
        renderDebtorDetail(debtor);
    } else {
        $('#modal-body').html('<p class="empty-state">قەرزار نەدۆزرایەوە</p>');
    }
}

function renderDebtorDetail(debtor) {
    const statusClass =
        debtor.status === 'warning'
            ? 'badge-warning'
            : debtor.status === 'overdue'
                ? 'badge-overdue'
                : debtor.status === 'paidoff'
                    ? 'badge-active'
                    : 'badge-warning';

    const statusText =
        debtor.status === 'warning'
            ? 'نزیکە'
            : debtor.status === 'overdue'
                ? 'بەسەرچوو'
                : debtor.status === 'paidoff'
                    ? 'پارەدراو'
                    : 'چالاک';

    const productImage = debtor.product_image || null;
    
    const html = `
        ${productImage ? `
        <div class="detail-row">
            <span class="detail-label"><i class="fas fa-image"></i> وێنەی کاڵا:</span>
            <span class="detail-value">
                <img src="${productImage}" 
                     alt="${escapeHtml(debtor.product_name || '')}" 
                     class="product-image-clickable"
                     style="width: 120px; height: 120px; border-radius: 12px; object-fit: cover; border: 2px solid var(--border-color);"
                     onclick="openFullscreenImage('${productImage}')"
                     title="کلیک بکە بۆ بینینی گەورە">
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
            <span class="detail-value">${escapeHtml(debtor.company || '—')}</span>
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
    selectedDebtorId = null;
}

// ==================== HELPER FUNCTIONS ====================
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

// ==================== EVENT LISTENERS ====================
$(document).ready(function() {
    const today = new Date().toISOString().split('T')[0];
    $('#filter-start-date').val(today);
    $('#filter-end-date').val(today);
    
    loadDebtors();
    
    let searchTimeout;
    $('#search-input').on('keyup', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            currentPage = 1;
            loadDebtors();
        }, 400);
    });
    
    $('#status-filter, #sort-by').on('change', function() {
        currentPage = 1;
        loadDebtors();
    });
    
    $('#filter-start-date, #filter-end-date').on('change', function() {
        currentPage = 1;
        loadDebtors();
    });
    
    $('#reset-filters').on('click', function() {
        $('#search-input').val('');
        $('#status-filter').val('all');
        $('#sort-by').val('name');
        const today = new Date().toISOString().split('T')[0];
        $('#filter-start-date').val(today);
        $('#filter-end-date').val(today);
        currentPage = 1;
        loadDebtors();
    });
    
    $('#detail-modal').on('click', function(e) {
        if (e.target === this) closeModal();
    });
    
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape') {
            if ($('#image-fullscreen').css('display') === 'flex') {
                closeFullscreenImage();
            } else if ($('#detail-modal').css('display') === 'flex') {
                closeModal();
            }
        }
    });
    
    $('#fullscreen-image').on('click', function(e) {
        e.stopPropagation();
    });
});
</script>
@endsection