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

    .glass {
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
       
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

            font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
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

    /* Stats Cards - Below Table */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
        margin-top: 28px;
        margin-bottom: 0;
    }

    @media (min-width: 640px) {
        .stats-grid { grid-template-columns: repeat(4, 1fr); }
    }

    .stat-card {
        background: var(--card-bg);
        border-radius: 20px;
        padding: 20px 16px;
        text-align: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        transition: all 0.3s;
        border: 1px solid var(--border-color);
        color: var(--text);
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: var(--primary);
        border-radius: 0 4px 4px 0;
    }

    .stat-card:nth-child(2)::before {
        background: linear-gradient(135deg, #f59e0b, #d97706);
    }

    .stat-card:nth-child(3)::before {
        background: linear-gradient(135deg, #10b981, #059669);
    }

    .stat-card:nth-child(4)::before {
        background: linear-gradient(135deg, #ef4444, #dc2626);
    }

    body.dark-mode .stat-card {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
    }

    body.dark-mode .stat-card:hover {
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.3);
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

    .stat-card:nth-child(2) .stat-icon {
        background: linear-gradient(135deg, #f59e0b, #d97706);
    }

    .stat-card:nth-child(3) .stat-icon {
        background: linear-gradient(135deg, #10b981, #059669);
    }

    .stat-card:nth-child(4) .stat-icon {
        background: linear-gradient(135deg, #ef4444, #dc2626);
    }

    .stat-value {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--text);
        margin-bottom: 4px;
        transition: all 0.3s;
    }

    .stat-label {
        font-size: 0.75rem;
        color: var(--text-secondary);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
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

    .btn-pay {
        background: linear-gradient(135deg, var(--success), #059669);
    }

    .btn-delete {
        background: linear-gradient(135deg, var(--danger), #dc2626);
    }

    .btn-icon:hover {
        transform: scale(1.1);
        filter: brightness(1.15);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    /* Payment Modal Styles */
    .payment-modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(5px);
        z-index: 10001;
        align-items: center;
        justify-content: center;
    }

    .payment-modal {
        background: var(--card-bg);
        border-radius: 24px;
        width: 90%;
        max-width: 500px;
        animation: fadeInUp 0.3s ease;
        color: var(--text);
        overflow: hidden;
        max-height: 90vh;
        overflow-y: auto;
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

    .payment-modal-body {
        padding: 24px;
    }

    .payment-modal-footer {
        padding: 16px 24px;
        border-top: 1px solid var(--border-color);
        display: flex;
        gap: 12px;
        justify-content: flex-end;
    }

    /* Payment Type Tabs */
    .payment-type-tabs {
        display: flex;
        gap: 4px;
        margin-bottom: 20px;
        background: var(--bg-light);
        border-radius: 14px;
        padding: 4px;
    }

    .payment-type-tab {
        flex: 1;
        padding: 10px 12px;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        font-weight: 700;
        font-size: 0.8rem;
        transition: all 0.3s;
        background: transparent;
        color: var(--text-secondary);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .payment-type-tab.active {
        background: var(--card-bg);
        color: var(--text);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .payment-type-tab.active.now-tab {
        color: #059669;
    }

    .payment-type-tab.active.later-tab {
        color: #d97706;
    }

    .payment-type-tab:hover {
        color: var(--text);
    }

    .payment-info-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid var(--border-color);
        font-size: 0.9rem;
    }

    .payment-info-label {
        color: var(--text-secondary);
        font-weight: 600;
    }

    .payment-info-value {
        font-weight: 700;
    }

    .payment-input-group {
        margin-top: 16px;
    }

    .payment-input-group label {
        display: block;
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--text-secondary);
        margin-bottom: 8px;
    }

    .payment-input {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid var(--border-color);
        border-radius: 14px;
        font-size: 1.1rem;
        font-weight: 700;
        transition: all 0.2s;
        background: var(--input-bg);
        color: var(--text);
        text-align: center;
    }

    .payment-input:focus {
        outline: none;
        border-color: var(--success);
        background: var(--card-bg);
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
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
    }

    .btn-submit-payment:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .btn-cancel-payment {
        background: var(--bg-light);
        color: var(--text);
        border: 2px solid var(--border-color);
        padding: 12px 24px;
        border-radius: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-cancel-payment:hover {
        background: var(--border-color);
    }

    .quick-amount-btns {
        display: flex;
        gap: 8px;
        margin-top: 12px;
        flex-wrap: wrap;
    }

    .quick-amount-btn {
        padding: 8px 16px;
        border: 2px solid var(--border-color);
        border-radius: 10px;
        background: var(--bg-light);
        color: var(--text);
        cursor: pointer;
        font-weight: 600;
        font-size: 0.8rem;
        transition: all 0.2s;
    }

    .quick-amount-btn:hover {
        border-color: var(--success);
        background: #dcfce7;
        color: #166534;
    }

    /* Later Payment Section */
    .later-payment-section {
        display: none;
    }

    .later-payment-section.active {
        display: block;
    }

    .now-payment-section {
        display: block;
    }

    .now-payment-section.hidden {
        display: none;
    }

    .later-date-input {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid var(--border-color);
        border-radius: 14px;
        font-size: 1rem;
        font-weight: 600;
        transition: all 0.2s;
        background: var(--input-bg);
        color: var(--text);
        text-align: center;
        cursor: pointer;
    }

    .later-date-input:focus {
        outline: none;
        border-color: #d97706;
        background: var(--card-bg);
        box-shadow: 0 0 0 3px rgba(217, 119, 6, 0.1);
    }

    .later-note-input {
        width: 100%;
        padding: 10px 14px;
        border: 2px solid var(--border-color);
        border-radius: 12px;
        font-size: 0.9rem;
        transition: all 0.2s;
        background: var(--input-bg);
        color: var(--text);
        resize: vertical;
        min-height: 70px;
        font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
    }

    .later-note-input:focus {
        outline: none;
        border-color: #d97706;
        background: var(--card-bg);
        box-shadow: 0 0 0 3px rgba(217, 119, 6, 0.1);
    }

    .later-summary {
        background: #fffbeb;
        border: 1px solid #fcd34d;
        border-radius: 12px;
        padding: 12px;
        margin-top: 12px;
        font-size: 0.8rem;
        color: #92400e;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    body.dark-mode .later-summary {
        background: #422006;
        border-color: #78350f;
        color: #fbbf24;
    }

    /* Confirm Delete Modal */
    .confirm-modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(5px);
        z-index: 10002;
        align-items: center;
        justify-content: center;
    }

    .confirm-modal {
        background: var(--card-bg);
        border-radius: 24px;
        width: 90%;
        max-width: 420px;
        animation: fadeInUp 0.3s ease;
        color: var(--text);
        overflow: hidden;
    }

    .confirm-modal-header {
        padding: 20px;
        background: linear-gradient(135deg, var(--danger), #dc2626);
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .confirm-modal-body {
        padding: 24px;
        text-align: center;
    }

    .confirm-modal-body i {
        font-size: 3rem;
        color: var(--danger);
        margin-bottom: 16px;
    }

    .confirm-modal-body p {
        font-size: 0.95rem;
        line-height: 1.6;
        color: var(--text-secondary);
    }

    .confirm-modal-body strong {
        color: var(--text);
    }

    .confirm-modal-footer {
        padding: 16px 24px;
        border-top: 1px solid var(--border-color);
        display: flex;
        gap: 12px;
        justify-content: center;
    }

    .btn-confirm-delete {
        background: linear-gradient(135deg, var(--danger), #dc2626);
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-confirm-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    .btn-cancel-delete {
        background: var(--bg-light);
        color: var(--text);
        border: 2px solid var(--border-color);
        padding: 12px 24px;
        border-radius: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
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

    /* Payment History Section */
    .payment-history-section {
        margin-top: 24px;
        border-top: 2px solid var(--border-color);
        padding-top: 20px;
    }

    .payment-history-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .payment-history-title i {
        color: var(--primary);
    }

    .payment-history-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
        max-height: 300px;
        overflow-y: auto;
        padding-right: 4px;
    }

    .payment-history-list::-webkit-scrollbar {
        width: 5px;
    }

    .payment-history-list::-webkit-scrollbar-track {
        background: var(--bg-light);
        border-radius: 3px;
    }

    .payment-history-list::-webkit-scrollbar-thumb {
        background: var(--primary);
        border-radius: 3px;
    }

    .payment-history-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 16px;
        background: var(--bg-light);
        border-radius: 12px;
        border: 1px solid var(--border-color);
        transition: all 0.2s;
    }

    .payment-history-item:hover {
        border-color: var(--primary);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    body.dark-mode .payment-history-item:hover {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    .payment-history-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .payment-history-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1rem;
    }

    .payment-history-icon.now-payment {
        background: linear-gradient(135deg, var(--success), #059669);
    }

    .payment-history-icon.later-payment {
        background: linear-gradient(135deg, #f59e0b, #d97706);
    }

    .payment-history-info {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .payment-history-amount {
        font-weight: 700;
        font-size: 0.95rem;
        color: var(--text);
    }

    .payment-history-date {
        font-size: 0.75rem;
        color: var(--text-secondary);
    }

    .payment-history-right {
        text-align: right;
    }

    .payment-history-type {
        font-size: 0.7rem;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 20px;
        display: inline-block;
    }

    .payment-history-type.now-type {
        background: #dcfce7;
        color: #166534;
    }

    .payment-history-type.later-type {
        background: #fef3c7;
        color: #92400e;
    }

    body.dark-mode .payment-history-type.now-type {
        background: #14532d;
        color: #86efac;
    }

    body.dark-mode .payment-history-type.later-type {
        background: #451a03;
        color: #fcd34d;
    }

    .payment-history-empty {
        text-align: center;
        padding: 30px;
        color: var(--text-secondary);
    }

    .payment-history-empty i {
        font-size: 2rem;
        opacity: 0.5;
        margin-bottom: 10px;
    }

    .products-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .products-table th {
        background: var(--bg-light);
        padding: 8px;
        font-size: 0.7rem;
        text-transform: uppercase;
        color: var(--text-secondary);
        border-bottom: 2px solid var(--border-color);
    }

    .products-table td {
        padding: 8px;
        font-size: 0.8rem;
        border-bottom: 1px solid var(--border-color);
        text-align: center;
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

    /* Full Screen Image Overlay */
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

    .modal-content::-webkit-scrollbar,
    .payment-modal::-webkit-scrollbar {
        width: 6px;
    }

    .modal-content::-webkit-scrollbar-track,
    .payment-modal::-webkit-scrollbar-track {
        background: var(--bg-light);
    }

    .modal-content::-webkit-scrollbar-thumb,
    .payment-modal::-webkit-scrollbar-thumb {
        background: var(--primary);
        border-radius: 3px;
    }

    .text-center { text-align: center; }
    .text-muted { color: var(--text-secondary); }
    .text-primary { color: var(--primary); }
    .me-2 { margin-right: 0.5rem; }
    
    .stat-value-updating {
        animation: pulse 0.5s ease;
    }
    
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.15); color: var(--primary); }
    }
</style>

<div class="debtors-container">
    <!-- Page Header -->
    <div class="page-header animate-fade-in-up">
        <div class="page-title">
            <i class="fas fa-users"></i>
            <span>لیستی قەرزەکان</span>
        </div>
       
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

    <!-- Table - EACH PRODUCT IN SEPARATE ROW -->
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
                <span class="payment-info-value amount-positive" id="pay-total-amount">0 IQD</span>
            </div>
            <div class="payment-info-row">
                <span class="payment-info-label">پارەی دراو:</span>
                <span class="payment-info-value" style="color:#10b981;" id="pay-paid-amount">0 IQD</span>
            </div>
            <div class="payment-info-row">
                <span class="payment-info-label">قەرزی ماوە:</span>
                <span class="payment-info-value amount-positive" id="pay-remaining-amount">0 IQD</span>
            </div>
            
            <!-- Payment Type Tabs -->
            <div class="payment-type-tabs" style="margin-top: 16px;">
                <button class="payment-type-tab active now-tab" onclick="switchPaymentType('now')" id="tab-now">
                    <i class="fas fa-check-circle"></i> پارەدانی ئێستا
                </button>
                <button class="payment-type-tab later-tab" onclick="switchPaymentType('later')" id="tab-later">
                    <i class="fas fa-clock"></i> کاتی دواتر
                </button>
            </div>
            
            <!-- Now Payment Section -->
            <div class="now-payment-section" id="now-payment-section">
                <div class="payment-input-group">
                    <label><i class="fas fa-coins"></i> بڕی پارەدان:</label>
                    <input type="number" id="payment-amount" class="payment-input" placeholder="بڕی پارەکە بنووسە..." min="1">
                    <div class="quick-amount-btns">
                        <button class="quick-amount-btn" onclick="setPaymentAmount('full')">💵 هەموو قەرزەکە</button>
                        <button class="quick-amount-btn" onclick="setPaymentAmount('half')">💰 نیوەی قەرز</button>
                        <button class="quick-amount-btn" onclick="setPaymentAmount('quarter')">🪙 چارەکی قەرز</button>
                    </div>
                </div>
            </div>
            
            <!-- Later Payment Section -->
            <div class="later-payment-section" id="later-payment-section">
                <div class="payment-input-group">
                    <label><i class="fas fa-calendar-plus"></i> بەرواری پارەدان:</label>
                    <input type="date" id="later-date" class="later-date-input">
                </div>
                <div class="payment-input-group">
                    <label><i class="fas fa-coins"></i> بڕی پارەدان (ئارەزوومەندانە):</label>
                    <input type="number" id="later-amount" class="payment-input" placeholder="بڕی پارەکە بنووسە..." min="0">
                    <div class="quick-amount-btns">
                        <button class="quick-amount-btn" onclick="setLaterAmount('full')">💵 هەموو قەرزەکە</button>
                        <button class="quick-amount-btn" onclick="setLaterAmount('half')">💰 نیوەی قەرز</button>
                        <button class="quick-amount-btn" onclick="setLaterAmount('quarter')">🪙 چارەکی قەرز</button>
                    </div>
                </div>
                <div class="later-summary" id="later-summary" style="display: none;">
                    <i class="fas fa-info-circle"></i>
                    <span id="later-summary-text"></span>
                </div>
            </div>
        </div>
        <div class="payment-modal-footer">
            <button class="btn-cancel-payment" onclick="closePaymentModal()"><i class="fas fa-times"></i> ڕەتکردنەوە</button>
            <button class="btn-submit-payment" id="btn-submit-payment" onclick="submitPayment()"><i class="fas fa-check-circle"></i> تۆمارکردنی پارەدان</button>
        </div>
    </div>
</div>

<!-- Confirm Delete Modal -->
<div id="confirm-delete-modal" class="confirm-modal-overlay">
    <div class="confirm-modal">
        <div class="confirm-modal-header">
            <h3><i class="fas fa-exclamation-triangle"></i> پشتڕاستکردنەوە</h3>
            <button class="close-modal" onclick="closeConfirmDeleteModal()"><i class="fas fa-times"></i></button>
        </div>
        <div class="confirm-modal-body">
            <i class="fas fa-trash-alt"></i>
            <p>ئایا دڵنیایت کە دەتەوێت ئەم قەرزە بسڕیتەوە؟</p>
            <p style="margin-top: 8px;"><strong id="delete-customer-name">—</strong></p>
            <p style="margin-top: 4px; color: var(--danger);">ئەم کارە ناگەڕێتەوە!</p>
        </div>
        <div class="confirm-modal-footer">
            <button class="btn-cancel-delete" onclick="closeConfirmDeleteModal()"><i class="fas fa-times"></i> ڕەتکردنەوە</button>
            <button class="btn-confirm-delete" onclick="confirmDeleteDebtor()"><i class="fas fa-trash-alt"></i> بەڵێ، بیسڕەوە</button>
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
let selectedDeleteId = null;
let responseTotal = 0;
let currentPaymentType = 'now';

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
            $('#debtors-tbody').html('<tr><td colspan="10" class="empty-state"><i class="fas fa-spinner fa-pulse"></i><p>بارده‌کێت...</p></td></tr>');
        },
        success: function(response) {
            console.log(response);
            if (response.success) {
                currentDebtors = response.debtors.data;
                totalPages = response.debtors.last_page;
                renderDebtorsTable(currentDebtors);
                renderPagination();
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
                    <button class="btn-icon btn-pay" onclick="showPaymentModal(${debtor.id})" title="پارەدان">
                        <i class="fas fa-money-bill-wave"></i>
                    </button>
                    <button class="btn-icon btn-delete" onclick="showConfirmDelete(${debtor.id}, '${escapeHtml(debtor.customer_name || '')}')" title="سڕینەوە">
                        <i class="fas fa-trash-alt"></i>
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

// ==================== PAYMENT TYPE SWITCHER ====================
function switchPaymentType(type) {
    currentPaymentType = type;
    
    if (type === 'now') {
        $('#tab-now').addClass('active');
        $('#tab-later').removeClass('active');
        $('#now-payment-section').removeClass('hidden');
        $('#later-payment-section').removeClass('active');
        $('#btn-submit-payment').html('<i class="fas fa-check-circle"></i> تۆمارکردنی پارەدان');
    } else {
        $('#tab-later').addClass('active');
        $('#tab-now').removeClass('active');
        $('#now-payment-section').addClass('hidden');
        $('#later-payment-section').addClass('active');
        $('#btn-submit-payment').html('<i class="fas fa-clock"></i> تۆمارکردن بۆ کاتی دواتر');
        
        // Set default date to tomorrow
        if (!$('#later-date').val()) {
            const tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            $('#later-date').val(tomorrow.toISOString().split('T')[0]);
        }
    }
    
    updateLaterSummary();
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
    $('#later-amount').val('');
    $('#later-note').val('');
    $('#later-summary').hide();
    
    // Reset to 'now' tab
    currentPaymentType = 'now';
    $('#tab-now').addClass('active');
    $('#tab-later').removeClass('active');
    $('#now-payment-section').removeClass('hidden');
    $('#later-payment-section').removeClass('active');
    $('#btn-submit-payment').html('<i class="fas fa-check-circle"></i> تۆمارکردنی پارەدان');
    
    $('#payment-modal').css('display', 'flex');
    setTimeout(() => {
        $('#payment-amount').focus();
    }, 300);
}

function closePaymentModal() {
    $('#payment-modal').css('display', 'none');
    selectedDebtorId = null;
    currentPaymentType = 'now';
}

function setPaymentAmount(type) {
    const debtor = currentDebtors.find(d => d.id == selectedDebtorId);
    if (!debtor) return;
    
    const remaining = parseFloat(debtor.period) || 0;
    let amount = 0;
    
    switch(type) {
        case 'full':
            amount = remaining;
            break;
        case 'half':
            amount = Math.ceil(remaining / 2);
            break;
        case 'quarter':
            amount = Math.ceil(remaining / 4);
            break;
    }
    
    $('#payment-amount').val(amount);
    $('#payment-amount').focus();
}

function setLaterAmount(type) {
    const debtor = currentDebtors.find(d => d.id == selectedDebtorId);
    if (!debtor) return;
    
    const remaining = parseFloat(debtor.period) || 0;
    let amount = 0;
    
    switch(type) {
        case 'full':
            amount = remaining;
            break;
        case 'half':
            amount = Math.ceil(remaining / 2);
            break;
        case 'quarter':
            amount = Math.ceil(remaining / 4);
            break;
    }
    
    $('#later-amount').val(amount);
    updateLaterSummary();
}

function updateLaterSummary() {
    const date = $('#later-date').val();
    const amount = $('#later-amount').val();
    const debtor = currentDebtors.find(d => d.id == selectedDebtorId);
    
    if (date && debtor) {
        const formattedDate = formatDate(date);
        const amountText = amount ? formatNumber(amount) + ' IQD' : 'بڕی دیاری نەکراو';
        $('#later-summary-text').html(
            `پارەدانی <strong>${amountText}</strong> بۆ ڕێکەوتی <strong>${formattedDate}</strong> تۆمار دەکرێت`
        );
        $('#later-summary').show();
    } else if (date) {
        const formattedDate = formatDate(date);
        $('#later-summary-text').html(
            `یادداشتێک بۆ ڕێکەوتی <strong>${formattedDate}</strong> تۆمار دەکرێت`
        );
        $('#later-summary').show();
    } else {
        $('#later-summary').hide();
    }
}

// Update later summary when inputs change
$(document).on('input', '#later-date, #later-amount', function() {
    updateLaterSummary();
});

function submitPayment() {
    if (currentPaymentType === 'now') {
        submitNowPayment();
    } else {
        submitLaterPayment();
    }
}

function submitNowPayment() {
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
    
    processPayment(selectedDebtorId, amount, 'now');
}

function submitLaterPayment() {
    const date = $('#later-date').val();
    
    if (!date) {
        showToast('تکایە بەرواری پارەدان دیاری بکە', 'error');
        $('#later-date').focus();
        return;
    }
    
    const amount = parseFloat($('#later-amount').val()) || 0;
    const note = $('#later-note').val() || '';
    
    processPayment(selectedDebtorId, amount, 'later', date, note);
}

function processPayment(debtorId, amount, paymentType, laterDate = null, laterNote = '') {
    const data = {
        debtor_id: debtorId,
        amount: amount,
        payment_type: paymentType,
        _token: '{{ csrf_token() }}'
    };
    
    if (paymentType === 'later') {
        data.later_date = laterDate;
        data.later_note = laterNote;
    }
    
    console.log('Sending payment data:', data);
    
    $.ajax({
        url: '{{ route("debtors.pay") }}',
        type: 'POST',
        data: data,
        beforeSend: function() {
            const msg = paymentType === 'now' ? 'تۆمارکردنی پارەدان...' : 'تۆمارکردن بۆ کاتی دواتر...';
            showToast(msg, 'info');
        },
        success: function(response) {
            console.log('Payment Response:', response);
            if (response.success) {
                const msg = paymentType === 'now' 
                    ? 'پارەدان بە سەرکەوتوویی تۆمارکرا' 
                    : 'پارەدانی دواخراو بە سەرکەوتوویی تۆمارکرا';
                showToast(response.message || msg, 'success');
                closePaymentModal();
                closeModal();
                loadDebtors();
            } else {
                showToast(response.message || 'هەڵەیەک ڕوویدا', 'error');
            }
        },
        error: function(xhr) {
            console.log('Payment Error:', xhr);
            let msg = 'هەڵەیەک ڕوویدا';
            try {
                const res = JSON.parse(xhr.responseText);
                if (res.errors) {
                    const firstError = Object.values(res.errors)[0][0];
                    msg = firstError || res.message;
                } else {
                    msg = res.message || msg;
                }
            } catch(e) {}
            showToast(msg, 'error');
        }
    });
}

// ==================== DELETE CONFIRMATION ====================
function showConfirmDelete(debtorId, customerName) {
    selectedDeleteId = debtorId;
    $('#delete-customer-name').text(customerName || '—');
    $('#confirm-delete-modal').css('display', 'flex');
}

function closeConfirmDeleteModal() {
    $('#confirm-delete-modal').css('display', 'none');
    selectedDeleteId = null;
}

function confirmDeleteDebtor() {
    if (!selectedDeleteId) return;
    
    $.ajax({
        url: '/debtors/' + selectedDeleteId + '/delete',
        type: 'DELETE',
        data: {
            _token: '{{ csrf_token() }}'
        },
        beforeSend: function() {
            showToast('سڕینەوەی قەرز...', 'info');
        },
        success: function(response) {
            console.log("delete response:", response);
            if (response.success) {
                showToast(response.message || 'قەرز بە سەرکەوتوویی سڕایەوە', 'success');
                closeConfirmDeleteModal();
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

// ==================== LOAD PAYMENT HISTORY ====================
function loadPaymentHistory(debtorId) {
    $.ajax({
        url: '{{ route("debtors.payment-history") }}',
        type: 'GET',
        data: {
            debtor_id: debtorId,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            console.log('Payment History Response:', response);
            if (response.success) {
                renderPaymentHistory(response.payments);
            } else {
                renderPaymentHistory([]);
            }
        },
        error: function(xhr) {
            console.error('Payment History Error:', xhr);
            renderPaymentHistory([]);
        }
    });
}

function renderPaymentHistory(payments) {
    let historyHtml = '';
    
    if (!payments || payments.length === 0) {
        historyHtml = `
            <div class="payment-history-empty">
                <i class="fas fa-receipt"></i>
                <p>هیچ پارەدانێک تۆمار نەکراوە</p>
            </div>`;
    } else {
        payments.forEach(payment => {
            const isNowPayment = payment.payment_type === 'now' || payment.payment_type === 'cash' || !payment.later_date;
            const iconClass = isNowPayment ? 'now-payment' : 'later-payment';
            const icon = isNowPayment ? 'fa-check-circle' : 'fa-clock';
            const typeClass = isNowPayment ? 'now-type' : 'later-type';
            const typeText = isNowPayment ? 'پارەدانی ڕاستەوخۆ' : 'بۆ کاتی دواتر';
            const amount = parseFloat(payment.amount || payment.pyment_of_mony || 0);
            const date = payment.created_at || payment.payment_date || '';
            const laterDate = payment.later_date || '';
            
            let dateDisplay = formatDate(date);
            if (!isNowPayment && laterDate) {
                dateDisplay = `📅 ${formatDate(laterDate)}`;
            }
            
            historyHtml += `
                <div class="payment-history-item">
                    <div class="payment-history-left">
                        <div class="payment-history-icon ${iconClass}">
                            <i class="fas ${icon}"></i>
                        </div>
                        <div class="payment-history-info">
                            <span class="payment-history-amount">${formatNumber(amount)} IQD</span>
                            <span class="payment-history-date">${dateDisplay}</span>
                        </div>
                    </div>
                    <div class="payment-history-right">
                        <span class="payment-history-type ${typeClass}">${typeText}</span>
                    </div>
                </div>`;
        });
    }
    
    $('#payment-history-content').html(historyHtml);
}

// ==================== DEBTOR DETAIL ====================
function showDebtorDetail(debtorId) {
    selectedDebtorId = debtorId;
    $('#detail-modal').css('display', 'flex');
    $('#modal-body').html('<div style="text-align:center;padding:40px;"><div class="loading-spinner"></div><p style="margin-top:12px;color:var(--text-secondary);">بارده‌کێت...</p></div>');
    
    const debtor = currentDebtors.find(d => d.id == debtorId);
    
    if (debtor) {
        renderDebtorDetail(debtor);
        // Load payment history after rendering detail
        loadPaymentHistory(debtorId);
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
        
        <!-- Payment History Section -->
        <div class="payment-history-section">
            <div class="payment-history-title">
                <i class="fas fa-history"></i>
                <span>مێژووی پارەدانەکان</span>
            </div>
            <div class="payment-history-list" id="payment-history-content">
                <div style="text-align:center;padding:20px;">
                    <div class="loading-spinner"></div>
                    <p style="margin-top:8px;color:var(--text-secondary);font-size:0.8rem;">بارکردنی مێژوو...</p>
                </div>
            </div>
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
        closeModal();
        setTimeout(() => {
            showPaymentModal(selectedDebtorId);
        }, 300);
    }
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
    
    $('#reset-filters').on('click', function() {
        $('#search-input').val('');
        $('#status-filter').val('all');
        $('#sort-by').val('name');
        currentPage = 1;
        loadDebtors();
    });
    
    // Close modals on overlay click
    $('#detail-modal').on('click', function(e) {
        if (e.target === this) closeModal();
    });
    
    $('#payment-modal').on('click', function(e) {
        if (e.target === this) closePaymentModal();
    });
    
    $('#confirm-delete-modal').on('click', function(e) {
        if (e.target === this) closeConfirmDeleteModal();
    });
    
    // Payment amount enter key
    $('#payment-amount').on('keypress', function(e) {
        if (e.key === 'Enter') {
            submitPayment();
        }
    });
    
    // Later date/amount enter key
    $('#later-date, #later-amount').on('keypress', function(e) {
        if (e.key === 'Enter') {
            submitPayment();
        }
    });
    
    // Keyboard shortcuts
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape') {
            if ($('#image-fullscreen').css('display') === 'flex') {
                closeFullscreenImage();
            } else if ($('#confirm-delete-modal').css('display') === 'flex') {
                closeConfirmDeleteModal();
            } else if ($('#payment-modal').css('display') === 'flex') {
                closePaymentModal();
            } else if ($('#detail-modal').css('display') === 'flex') {
                closeModal();
            }
        }
    });
    
    // Prevent image fullscreen close when clicking on image
    $('#fullscreen-image').on('click', function(e) {
        e.stopPropagation();
    });
});
</script>
@endsection