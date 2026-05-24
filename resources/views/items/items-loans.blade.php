{{--
    resources/views/debtors/index.blade.php
    List of debtors (قەرزارەکان) with search, filtering, and responsive design
    DARK MODE SUPPORTED
--}}

@extends('layouts.navigation')

@section('content')

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ config('app.name', 'Laravel') }} - لیستی قەرزارەکان</title>
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
        font-family: system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
        min-height: 100vh;
        color: var(--text);
    }

    body.dark-mode {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    }

    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in-up {
        animation: fadeInUp 0.5s ease forwards;
    }

    .animate-delay-100 { animation-delay: 0.1s; }
    .animate-delay-200 { animation-delay: 0.2s; }
    .animate-delay-300 { animation-delay: 0.3s; }
    .animate-delay-400 { animation-delay: 0.4s; }
    .animate-delay-500 { animation-delay: 0.5s; }
    .animate-delay-600 { animation-delay: 0.6s; }
    .animate-delay-700 { animation-delay: 0.7s; }

    /* Glass effect */
    .glass {
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        border-radius: 24px;
        border: 1px solid var(--border-color);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
    }

    body.dark-mode .glass {
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
    }

    .card-hover {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        border-color: rgba(74, 100, 145, 0.3);
    }

    body.dark-mode .card-hover:hover {
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
    }

    /* Container */
    .debtors-container {
        padding: 20px 16px;
        max-width: 1600px;
        margin: 0 auto;
    }

    @media (min-width: 768px) {
        .debtors-container {
            padding: 30px 24px;
        }
    }

    /* Header */
    .page-header {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border-radius: 28px;
        padding: 24px 20px;
        margin-bottom: 28px;
        color: white;
        position: relative;
        overflow: hidden;
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
        .page-title {
            font-size: 2rem;
        }
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

    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
        margin-bottom: 28px;
    }

    @media (min-width: 640px) {
        .stats-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    .stat-card {
        background: var(--card-bg);
        border-radius: 20px;
        padding: 16px;
        text-align: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        transition: all 0.2s;
        border: 1px solid var(--border-color);
        color: var(--text);
    }

    body.dark-mode .stat-card {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .stat-card:hover {
        transform: scale(1.02);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    body.dark-mode .stat-card:hover {
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, var(--primary-light), var(--primary));
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        color: white;
        font-size: 1.4rem;
    }

    .stat-value {
        font-size: 1.6rem;
        font-weight: 800;
        color: var(--text);
        margin-bottom: 4px;
    }

    .stat-label {
        font-size: 0.75rem;
        color: var(--text-secondary);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Search and Filter */
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
            min-width: 180px;
        }
        
        .filter-group.search-group {
            flex: 2;
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

    /* Table - Responsive */
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
        .debtors-table {
            font-size: 0.9rem;
        }
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
        .debtors-table th {
            padding: 16px 12px;
            font-size: 0.8rem;
        }
    }

    .debtors-table td {
        padding: 12px 8px;
        text-align: center;
        border-bottom: 1px solid var(--border-color);
        vertical-align: middle;
    }

    @media (min-width: 768px) {
        .debtors-table td {
            padding: 14px 10px;
        }
    }

    .debtors-table tbody tr {
        transition: background 0.2s;
        cursor: pointer;
    }

    .debtors-table tbody tr:hover {
        background: var(--table-hover);
    }

    /* Badges */
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
        background: #fffbeb;
        color: #92400e;
    }

    .amount-positive {
        color: var(--danger);
        font-weight: 700;
    }

    /* Action Buttons */
    .action-btns {
        display: flex;
        gap: 8px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-icon {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        color: white;
        font-size: 0.8rem;
    }

    .btn-view {
        background: linear-gradient(135deg, var(--info), #2563eb);
    }

    .btn-pay {
        background: linear-gradient(135deg, var(--success), #059669);
    }

    .btn-icon:hover {
        transform: scale(1.05);
        filter: brightness(1.1);
    }

    /* Pagination */
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

    /* Empty State */
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

    /* Modal */
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
        max-width: 500px;
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

    .payment-history {
        margin-top: 16px;
        max-height: 200px;
        overflow-y: auto;
    }

    .payment-item {
        background: var(--bg-light);
        padding: 10px;
        border-radius: 12px;
        margin-bottom: 8px;
        display: flex;
        justify-content: space-between;
        font-size: 0.8rem;
        border: 1px solid var(--border-color);
    }

    /* Toast Alerts */
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
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    /* Loading */
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

    /* Responsive adjustments */
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
    }

    /* Modal scrollbar */
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

    /* Text colors */
    .text-center { text-align: center; }
    .text-muted { color: var(--text-secondary); }
    .text-primary { color: var(--primary); }
    .me-2 { margin-right: 0.5rem; }
</style>

<div class="debtors-container">
    <!-- Page Header -->
    <div class="page-header animate-fade-in-up">
        <div class="page-title">
            <i class="fas fa-users"></i>
            <span>لیستی قەرزارەکان</span>
        </div>
        <div class="page-subtitle">
            <i class="fas fa-chart-line"></i> ڕاپۆرتی قەرزەکان و کەسانی قەرزار
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid animate-fade-in-up animate-delay-100">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-user-friends"></i>
            </div>
            <div class="stat-value" id="total-debtors">0</div>
            <div class="stat-label">کۆی قەرزارەکان</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                <i class="fas fa-hand-holding-usd"></i>
            </div>
            <div class="stat-value" id="total-debt">0</div>
            <div class="stat-label">کۆی قەرز</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #10b981, #059669);">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-value" id="active-debtors">0</div>
            <div class="stat-label">قەرزە چالاکەکان</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #ef4444, #dc2626);">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="stat-value" id="overdue-debtors">0</div>
            <div class="stat-label">قەرزی کەوتوو</div>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="filter-bar animate-fade-in-up animate-delay-200">
        <div class="filter-grid">
            <div class="filter-group search-group">
                <label><i class="fas fa-search"></i> گەڕان</label>
                <input type="text" id="search-input" class="filter-input" placeholder="ناوی کڕیار...">
            </div>
            <div class="filter-group">
                <label><i class="fas fa-calendar"></i> فلتەر بە ڕۆژ</label>
                <select id="status-filter" class="filter-input">
                    <option value="all">هەموو قەرزەکان</option>
                    <option value="active">قەرزی چالاک</option>
                    <option value="overdue">قەرزی کەوتوو</option>
                </select>
            </div>
            <div class="filter-group">
                <label><i class="fas fa-sort-amount-down"></i> ڕیزکردن</label>
                <select id="sort-by" class="filter-input">
                    <option value="name">ناوی کڕیار</option>
                    <option value="amount">بڕی قەرز</option>
                    <option value="date">بەرواری قەرز</option>
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
                        <th>#</th>
                        <th>ناوی کڕیار</th>
                        <th>ژمارەی مۆبایل</th>
                        <th>بڕی قەرز</th>
                        <th>بەرواری کۆتایی</th>
                        <th>ڕەوش</th>
                        <th>کردارەکان</th>
                    </tr>
                </thead>
                <tbody id="debtors-tbody">
                    <tr>
                        <td colspan="7" class="empty-state">
                            <i class="fas fa-spinner fa-pulse"></i>
                            <p>بارده‌کێت...</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
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
        <div class="modal-body" id="modal-body">
            <div style="text-align:center;padding:40px;">
                <div class="loading-spinner"></div>
                <p style="margin-top:12px;color:var(--text-secondary);">بارده‌کێت...</p>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn-reset" onclick="closeModal()"><i class="fas fa-times"></i> داخستن</button>
            <button class="btn-filter" onclick="payDebtFromModal()"><i class="fas fa-money-bill-wave"></i> پارەدان</button>
        </div>
    </div>
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
    
    $.ajax({
        url: '{{ route("debtors.list") }}',
        type: 'GET',
        data: {
            page: currentPage,
            search: search,
            status: status,
            sort: sort,
            per_page: 15
        },
        beforeSend: function() {
            $('#debtors-tbody').html('<tr><td colspan="7" class="empty-state"><i class="fas fa-spinner fa-pulse"></i><p>بارده‌کێت...</p></td></tr>');
        },
        success: function(response) {
            console.log(response);
            if (response.success) {
                currentDebtors = response.debtors.data;
                totalPages = response.debtors.last_page;
                renderDebtorsTable(currentDebtors);
                renderPagination();
                updateStats(response.stats);
            } else {
                showToast(response.message || 'هەڵەیەک ڕوویدا', 'error');
            }
        },
        error: function() {
            showToast('هەڵە لە گەڕانی داتا', 'error');
            $('#debtors-tbody').html('<tr><td colspan="7" class="empty-state"><i class="fas fa-exclamation-triangle"></i><p>هەڵەیەک ڕوویدا</p></td></tr>');
        }
    });
}

function renderDebtorsTable(debtors) {
    if (!debtors || debtors.length === 0) {
        $('#debtors-tbody').html('<tr><td colspan="7" class="empty-state"><i class="fas fa-inbox"></i><p>هیچ قەرزارێک نەدۆزرایەوە</p></td></tr>');
        return;
    }
    
    let html = '';
    debtors.forEach((debtor, index) => {
        const statusClass = debtor.status === 'active' ? 'badge-active' : (debtor.status === 'overdue' ? 'badge-overdue' : 'badge-warning');
        const statusText = debtor.status === 'active' ? 'چالاک' : (debtor.status === 'overdue' ? 'کەوتوو' : 'نزیکە');
        const amountClass = debtor.remaining_amount > 0 ? 'amount-positive' : '';
        
        html += `<tr onclick="showDebtorDetail(${debtor.id})" style="cursor: pointer;">
            <td data-label="#"><strong>${((currentPage-1)*15) + index + 1}</strong></td>
            <td data-label="ناوی کڕیار"><i class="fas fa-user text-primary me-2"></i> ${escapeHtml(debtor.customer_name)}</td>
            <td data-label="ژمارەی مۆبایل">${debtor.customer_phone ? escapeHtml(debtor.customer_phone) : '—'}</td>
            <td data-label="بڕی قەرز" class="${amountClass}">${formatNumber(debtor.remaining_amount)} IQD</td>
            <td data-label="بەرواری کۆتایی">${formatDate(debtor.due_date)}</td>
            <td data-label="ڕەوش"><span class="badge-status ${statusClass}">${statusText}</span></td>
            <td data-label="کردارەکان" onclick="event.stopPropagation()">
                <div class="action-btns">
                    <button class="btn-icon btn-view" onclick="showDebtorDetail(${debtor.id})" title="بینین">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn-icon btn-pay" onclick="showPayDebtModal(${debtor.id})" title="پارەدان">
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
    const start = ((currentPage - 1) * 15) + 1;
    const end = Math.min(currentPage * 15, currentDebtors.length + ((currentPage - 1) * 15));
    $('#showing-info').text(`پیشاندانی ${start} - ${end} لە ${totalPages * 15}+ کۆی گشتی`);
}

function updateStats(stats) {
    if (stats) {
        $('#total-debtors').text(stats.total_debtors || 0);
        $('#total-debt').text(formatNumber(stats.total_debt || 0));
        $('#active-debtors').text(stats.active_debtors || 0);
        $('#overdue-debtors').text(stats.overdue_debtors || 0);
    }
}

function changePage(page) {
    if (page >= 1 && page <= totalPages && page !== currentPage) {
        currentPage = page;
        loadDebtors();
    }
}

// ==================== DEBTOR DETAIL ====================
function showDebtorDetail(debtorId) {
    selectedDebtorId = debtorId;
    $('#detail-modal').css('display', 'flex');
    $('#modal-body').html('<div style="text-align:center;padding:40px;"><div class="loading-spinner"></div><p style="margin-top:12px;color:var(--text-secondary);">بارده‌کێت...</p></div>');
    
    $.ajax({
        url: '/debtors/' + debtorId + '/show',
        type: 'GET',
        success: function(response) {
            if (response.success) {
                renderDebtorDetail(response.debtor, response.payments);
            } else {
                $('#modal-body').html('<p class="empty-state">هەڵە لە بارکردنی داتا</p>');
            }
        },
        error: function() {
            $('#modal-body').html('<p class="empty-state">هەڵەیەک ڕوویدا</p>');
        }
    });
}

function renderDebtorDetail(debtor, payments) {
    const statusClass = debtor.status === 'active' ? 'badge-active' : (debtor.status === 'overdue' ? 'badge-overdue' : 'badge-warning');
    const statusText = debtor.status === 'active' ? 'چالاک' : (debtor.status === 'overdue' ? 'کەوتوو' : 'نزیکە');
    
    let paymentsHtml = '';
    if (payments && payments.length > 0) {
        payments.forEach(payment => {
            paymentsHtml += `<div class="payment-item">
                <span>${formatDate(payment.payment_date)}</span>
                <span class="amount-positive">${formatNumber(payment.amount)} IQD</span>
                <span>${payment.payment_method === 'cash' ? 'نەقد' : 'ڕەشید'}</span>
            </div>`;
        });
    } else {
        paymentsHtml = '<p class="text-center text-muted">هیچ پارەدانێک تۆمار نەکراوە</p>';
    }
    
    const html = `
        <div class="detail-row">
            <span class="detail-label"><i class="fas fa-user"></i> ناوی کڕیار:</span>
            <span class="detail-value">${escapeHtml(debtor.customer_name)}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label"><i class="fas fa-phone"></i> ژمارەی مۆبایل:</span>
            <span class="detail-value">${debtor.customer_phone ? escapeHtml(debtor.customer_phone) : '—'}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label"><i class="fas fa-map-marker-alt"></i> ناونیشان:</span>
            <span class="detail-value">${debtor.customer_address ? escapeHtml(debtor.customer_address) : '—'}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label"><i class="fas fa-hand-holding-usd"></i> کۆی قەرز:</span>
            <span class="detail-value amount-positive">${formatNumber(debtor.total_amount)} IQD</span>
        </div>
        <div class="detail-row">
            <span class="detail-label"><i class="fas fa-check-circle"></i> پارەی پێدراو:</span>
            <span class="detail-value" style="color:#10b981;">${formatNumber(debtor.paid_amount)} IQD</span>
        </div>
        <div class="detail-row">
            <span class="detail-label"><i class="fas fa-exclamation-triangle"></i> قەرزی ماوە:</span>
            <span class="detail-value amount-positive">${formatNumber(debtor.remaining_amount)} IQD</span>
        </div>
        <div class="detail-row">
            <span class="detail-label"><i class="fas fa-calendar-alt"></i> بەرواری قەرز:</span>
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
        <div class="detail-row">
            <span class="detail-label"><i class="fas fa-history"></i> مێژووی پارەدان:</span>
            <div class="payment-history" style="width:60%;">${paymentsHtml}</div>
        </div>
    `;
    $('#modal-body').html(html);
}

function closeModal() {
    $('#detail-modal').css('display', 'none');
    selectedDebtorId = null;
}

function payDebtFromModal() {
    if (selectedDebtorId) {
        showPayDebtModal(selectedDebtorId);
    }
}

// ==================== PAY DEBT MODAL ====================
function showPayDebtModal(debtorId) {
    selectedDebtorId = debtorId;
    const amount = prompt('بڕی پارەی دەتەوێت بپێری بنووسە:');
    if (amount && !isNaN(amount) && parseFloat(amount) > 0) {
        processPayment(debtorId, parseFloat(amount));
    } else if (amount) {
        showToast('تکایە بڕێکی دروست بنووسە', 'error');
    }
}

function processPayment(debtorId, amount) {
    $.ajax({
        url: '{{ route("debtors.pay") }}',
        type: 'POST',
        data: {
            debtor_id: debtorId,
            amount: amount,
            _token: '{{ csrf_token() }}'
        },
        beforeSend: function() {
            showToast('تۆمارکردنی پارەدان...', 'info');
        },
        success: function(response) {
            if (response.success) {
                showToast(response.message, 'success');
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

// ==================== HELPER FUNCTIONS ====================
function formatNumber(n) {
    if (n === undefined || n === null) return '0';
    return Number(n).toLocaleString();
}

function formatDate(dateString) {
    if (!dateString) return '—';
    const date = new Date(dateString);
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
    loadDebtors();
    
    $('#search-input').on('keyup', function() {
        currentPage = 1;
        loadDebtors();
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
    
    // Close modal on overlay click
    $('#detail-modal').on('click', function(e) {
        if (e.target === this) closeModal();
    });
    
    // Keyboard shortcuts
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape' && $('#detail-modal').css('display') === 'flex') {
            closeModal();
        }
    });
});
</script>
@endsection