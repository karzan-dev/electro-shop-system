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

    #alert-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        width: 350px;
        max-width: calc(100vw - 40px);
    }

    .alert-custom {
        border-radius: 12px;
        padding: 1rem 1.2rem;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.8rem;
        animation: slideDown 0.3s ease-out;
        background: white;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    body.dark-mode .alert-custom {
        background: #1e293b;
        color: #e2e8f0;
    }

    .alert-success-custom { border-right: 4px solid var(--success); }
    .alert-error-custom { border-right: 4px solid var(--danger); }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .card {
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    body.dark-mode .card {
        background-color: #1e293b !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2) !important;
    }

    .form-header-custom {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border-radius: 0.75rem 0.75rem 0 0 !important;
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
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.12);
        transition: background-color 0.3s ease;
    }

    body.dark-mode .form-logo-custom {
        background-color: #334155;
    }

    .form-logo-custom i {
        font-size: 1.75rem;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Stats Grid - Compact */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    @media (max-width: 992px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }
    }

    @media (max-width: 576px) {
        .stats-grid {
            grid-template-columns: 1fr;
            gap: 0.5rem;
        }
    }

    .stat-card {
        background: white;
        border-radius: 0.75rem;
        padding: 1.25rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        border: 1px solid var(--border-color);
        transition: var(--transition-base);
        position: relative;
        overflow: hidden;
    }

    body.dark-mode .stat-card {
        background: #1e293b;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        border-color: #334155;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
    }

    .stat-card::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 70px;
        height: 70px;
        background: currentColor;
        opacity: 0.05;
        border-radius: 50%;
        transform: translate(20px, -20px);
    }

    @media (max-width: 768px) {
        .stat-card {
            padding: 1rem;
        }
    }

    .stat-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        margin-bottom: 0.75rem;
    }

    @media (max-width: 768px) {
        .stat-icon {
            width: 36px;
            height: 36px;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }
    }

    .stat-icon-purple { background: rgba(74, 100, 145, 0.1); color: var(--primary); }
    .stat-icon-emerald { background: rgba(16, 185, 129, 0.1); color: var(--success); }
    .stat-icon-red { background: rgba(239, 68, 68, 0.1); color: var(--danger); }
    .stat-icon-blue { background: rgba(59, 130, 246, 0.1); color: var(--info); }

    .stat-label {
        font-size: 0.75rem;
        color: #64748b;
        font-weight: 500;
        margin-bottom: 0.25rem;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    body.dark-mode .stat-label { color: #94a3b8; }

    .stat-value {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text);
    }

    @media (max-width: 768px) {
        .stat-value { font-size: 1.1rem; }
    }

    body.dark-mode .stat-value { color: #e2e8f0; }

    /* Content Grid */
    .content-grid {
        display: grid;
        grid-template-columns: 340px 1fr;
        gap: 1rem;
        align-items: start;
    }

    @media (max-width: 1100px) {
        .content-grid {
            grid-template-columns: 1fr;
        }
        .form-column { order: -1; }
    }

    /* Form Card */
    .form-card {
        background: white;
        border-radius: 0.75rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        overflow: hidden;
        transition: var(--transition-base);
        position: sticky;
        top: 20px;
    }

    @media (max-width: 1100px) {
        .form-card { position: static; }
    }

    body.dark-mode .form-card {
        background: #1e293b;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    .form-card-header {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        padding: 1rem 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    @media (max-width: 576px) {
        .form-card-header { padding: 0.75rem; }
    }

    .form-card-header i { font-size: 1.1rem; }

    .form-card-header h2 {
        font-size: 1rem;
        font-weight: 600;
        margin: 0;
    }

    @media (max-width: 576px) {
        .form-card-header h2 { font-size: 0.9rem; }
    }

    .form-card-body { padding: 1.25rem; }

    @media (max-width: 576px) {
        .form-card-body { padding: 0.75rem; }
    }

    .form-group { margin-bottom: 1rem; }

    @media (max-width: 576px) {
        .form-group { margin-bottom: 0.75rem; }
    }

    .form-label-custom {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-weight: 600;
        color: var(--secondary);
        margin-bottom: 0.35rem;
        font-size: 0.8rem;
    }

    body.dark-mode .form-label-custom { color: #94a3b8; }
    .form-label-custom i { color: var(--primary); }
    .required { color: var(--danger); font-weight: 700; }

    .form-control-custom {
        width: 100%;
        padding: 0.6rem 0.75rem;
        border: 2px solid var(--border-color);
        border-radius: 8px;
        font-size: 0.85rem;
        transition: var(--transition-base);
        background: white;
        color: var(--text);
        font-family: inherit;
    }

    @media (max-width: 576px) {
        .form-control-custom {
            padding: 0.55rem 0.7rem;
            font-size: 16px;
        }
    }

    body.dark-mode .form-control-custom {
        background: #0f172a;
        border-color: #334155;
        color: #e2e8f0;
    }

    body.dark-mode .form-control-custom::placeholder { color: #64748b; }

    .form-control-custom:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(74, 100, 145, 0.2);
    }

    textarea.form-control-custom {
        resize: vertical;
        min-height: 60px;
    }

    .input-with-currency { position: relative; }

    .input-with-currency input {
        padding-right: 3.5rem !important;
    }

    @media (max-width: 576px) {
        .input-with-currency input {
            padding-right: 3rem !important;
        }
    }

    .currency-badge {
        position: absolute;
        right: 0;
        top: 0;
        height: 100%;
        padding: 0 0.75rem;
        background: var(--bg-light);
        border: 2px solid var(--border-color);
        border-left: none;
        border-radius: 0 8px 8px 0;
        display: flex;
        align-items: center;
        font-weight: 600;
        color: var(--secondary);
        font-size: 0.8rem;
    }

    @media (max-width: 576px) {
        .currency-badge {
            padding: 0 0.6rem;
            font-size: 0.75rem;
        }
    }

    body.dark-mode .currency-badge {
        background: #334155;
        border-color: #334155;
        color: #94a3b8;
    }

    .btn-primary-custom {
        width: 100%;
        padding: 0.7rem 1.25rem;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        border: none;
        border-radius: 25px;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: var(--transition-base);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        box-shadow: 0 3px 10px rgba(74, 100, 145, 0.3);
    }

    @media (max-width: 576px) {
        .btn-primary-custom {
            padding: 0.65rem 1rem;
            font-size: 0.85rem;
        }
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(74, 100, 145, 0.4);
    }

    .btn-primary-custom:active { transform: translateY(0); }

    .btn-primary-custom:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
    }

    .btn-secondary-custom {
        width: 100%;
        padding: 0.6rem 1.25rem;
        background: var(--bg-light);
        color: var(--text);
        border: 2px solid var(--border-color);
        border-radius: 25px;
        font-weight: 600;
        font-size: 0.85rem;
        cursor: pointer;
        transition: var(--transition-base);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        margin-top: 0.4rem;
    }

    @media (max-width: 576px) {
        .btn-secondary-custom {
            padding: 0.55rem 1rem;
            font-size: 0.8rem;
        }
    }

    body.dark-mode .btn-secondary-custom {
        background: #334155;
        border-color: #475569;
        color: #e2e8f0;
    }

    .btn-secondary-custom:hover { background: var(--border-color); }

    /* Table Card - Compact */
    .table-card {
        background: white;
        border-radius: 0.75rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        overflow: hidden;
        transition: var(--transition-base);
    }

    body.dark-mode .table-card {
        background: #1e293b;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    .table-card-header {
        background: linear-gradient(135deg, #1e293b, #0f172a);
        color: white;
        padding: 0.75rem 1rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    @media (max-width: 768px) {
        .table-card-header {
            flex-direction: column;
            align-items: stretch;
            padding: 0.75rem;
        }
    }

    .header-title {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .header-title i { font-size: 1rem; }

    .header-title h2 {
        font-size: 1rem;
        font-weight: 600;
        margin: 0;
    }

    @media (max-width: 576px) {
        .header-title h2 { font-size: 0.9rem; }
    }

    .search-box {
        position: relative;
        flex: 1;
        max-width: 220px;
    }

    @media (max-width: 768px) {
        .search-box { max-width: 100%; }
    }

    .search-box .search-icon {
        position: absolute;
        left: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.8rem;
        pointer-events: none;
    }

    .search-input-custom {
        width: 100%;
        padding: 0.45rem 0.75rem 0.45rem 2rem;
        border: 2px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.1);
        color: white;
        font-size: 0.8rem;
        transition: var(--transition-base);
        font-family: inherit;
    }

    .search-input-custom::placeholder { color: rgba(255, 255, 255, 0.5); }

    .search-input-custom:focus {
        outline: none;
        background: rgba(255, 255, 255, 0.15);
        border-color: rgba(255, 255, 255, 0.4);
    }

    .table-wrapper {
        overflow-x: auto;
        padding: 0.75rem;
        -webkit-overflow-scrolling: touch;
    }

    @media (max-width: 576px) {
        .table-wrapper { padding: 0.5rem; }
    }

    .debt-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 0.78rem;
        min-width: 700px;
    }

    @media (max-width: 768px) {
        .debt-table { font-size: 0.7rem; }
    }

    @media (max-width: 480px) {
        .debt-table {
            min-width: 100%;
            font-size: 0.65rem;
        }
    }

    .debt-table thead th {
        background: var(--bg-light);
        padding: 0.5rem 0.4rem;
        text-align: right;
        font-weight: 600;
        color: var(--secondary);
        font-size: 0.68rem;
        text-transform: uppercase;
        letter-spacing: 0.02em;
        border-bottom: 2px solid var(--border-color);
        white-space: nowrap;
    }

    @media (max-width: 768px) {
        .debt-table thead th {
            padding: 0.4rem 0.3rem;
            font-size: 0.62rem;
        }
    }

    @media (max-width: 480px) {
        .debt-table thead th {
            padding: 0.35rem 0.25rem;
            font-size: 0.58rem;
        }
        
        .debt-table thead th:nth-child(6),
        .debt-table tbody td:nth-child(6),
        .debt-table thead th:nth-child(7),
        .debt-table tbody td:nth-child(7) {
            display: none;
        }
    }

    body.dark-mode .debt-table thead th {
        background: #0f172a;
        color: #94a3b8;
        border-bottom-color: #334155;
    }

    .debt-table tbody td {
        padding: 0.5rem 0.4rem;
        border-bottom: 1px solid var(--border-color);
        vertical-align: middle;
        font-size: 0.78rem;
    }

    @media (max-width: 768px) {
        .debt-table tbody td { 
            padding: 0.4rem 0.3rem;
            font-size: 0.7rem;
        }
    }

    @media (max-width: 480px) {
        .debt-table tbody td {
            padding: 0.35rem 0.25rem;
            font-size: 0.65rem;
        }
    }

    body.dark-mode .debt-table tbody td {
        border-bottom-color: #334155;
        color: #e2e8f0;
    }

    .debt-table tbody tr {
        transition: var(--transition-base);
    }

    .debt-table tbody tr:hover { background: var(--bg-light); }

    body.dark-mode .debt-table tbody tr:hover {
        background: rgba(255, 255, 255, 0.05);
    }

    .btn-table-action {
        padding: 0.25rem;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: var(--transition-base);
        font-size: 0.75rem;
        width: 26px;
        height: 26px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin: 0 0.08rem;
    }

    @media (max-width: 768px) {
        .btn-table-action {
            width: 24px;
            height: 24px;
            font-size: 0.7rem;
            min-width: 26px;
            min-height: 26px;
        }
    }

    @media (max-width: 480px) {
        .btn-table-action {
            width: 22px;
            height: 22px;
            font-size: 0.65rem;
            min-width: 24px;
            min-height: 24px;
            margin: 0 0.04rem;
            border-radius: 4px;
        }
    }

    .btn-payment { background: rgba(16, 185, 129, 0.1); color: var(--success); }
    .btn-payment:hover { background: var(--success); color: white; transform: scale(1.1); }
    .btn-edit { background: rgba(74, 100, 145, 0.1); color: var(--primary); }
    .btn-edit:hover { background: var(--primary); color: white; transform: scale(1.1); }
    .btn-delete { background: rgba(239, 68, 68, 0.1); color: var(--danger); }
    .btn-delete:hover { background: var(--danger); color: white; transform: scale(1.1); }

    .badge-custom {
        padding: 0.15rem 0.45rem;
        border-radius: 100px;
        font-size: 0.65rem;
        font-weight: 600;
        display: inline-block;
        text-transform: uppercase;
        letter-spacing: 0.02em;
        white-space: nowrap;
    }

    @media (max-width: 768px) {
        .badge-custom {
            padding: 0.12rem 0.35rem;
            font-size: 0.6rem;
        }
    }

    @media (max-width: 480px) {
        .badge-custom {
            padding: 0.1rem 0.3rem;
            font-size: 0.55rem;
        }
    }

    .badge-success { background: rgba(16, 185, 129, 0.1); color: #059669; border: 1px solid rgba(16, 185, 129, 0.2); }
    body.dark-mode .badge-success { background: rgba(16, 185, 129, 0.2); color: #6ee7b7; }
    .badge-warning { background: rgba(245, 158, 11, 0.1); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.2); }
    body.dark-mode .badge-warning { background: rgba(245, 158, 11, 0.2); color: #fcd34d; }
    .badge-danger { background: rgba(239, 68, 68, 0.1); color: #dc2626; border: 1px solid rgba(239, 68, 68, 0.2); }
    body.dark-mode .badge-danger { background: rgba(239, 68, 68, 0.2); color: #fca5a5; }

    .empty-state {
        text-align: center;
        padding: 2rem 1rem;
        color: #94a3b8;
    }

    @media (max-width: 576px) {
        .empty-state { padding: 1.5rem 0.5rem; }
        .empty-state i { font-size: 1.5rem; }
    }

    .empty-state i {
        font-size: 2rem;
        margin-bottom: 0.5rem;
        opacity: 0.5;
    }

    .empty-state p { font-size: 0.9rem; font-weight: 500; }

    /* Modal */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(4px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease;
        padding: 1rem;
    }

    @media (max-width: 480px) {
        .modal-overlay {
            align-items: flex-end;
            padding: 0;
        }
    }

    .modal-overlay.active {
        opacity: 1;
        pointer-events: all;
    }

    .modal-content-custom {
        background: white;
        border-radius: 1rem;
        width: 100%;
        max-width: 450px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        animation: modalSlideIn 0.3s ease;
    }

    @media (max-width: 576px) {
        .modal-content-custom {
            border-radius: 0.75rem;
            max-height: 95vh;
            margin: 0.5rem;
        }
    }

    @media (max-width: 480px) {
        .modal-content-custom {
            margin: 0;
            border-radius: 0.75rem 0.75rem 0 0;
            max-height: 95vh;
            width: 100%;
        }
        
        @keyframes modalSlideIn {
            from { transform: translateY(100%); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        
        .modal-header-custom {
            border-radius: 0.75rem 0.75rem 0 0;
            padding: 0.75rem;
        }
        
        .modal-body-custom {
            padding: 0.75rem;
            max-height: calc(95vh - 120px);
            overflow-y: auto;
        }
    }

    body.dark-mode .modal-content-custom { background: #1e293b; }

    @keyframes modalSlideIn {
        from { transform: translateY(-50px) scale(0.95); opacity: 0; }
        to { transform: translateY(0) scale(1); opacity: 1; }
    }

    .modal-header-custom {
        padding: 1.25rem;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        position: sticky;
        top: 0;
        z-index: 1;
    }

    @media (max-width: 576px) {
        .modal-header-custom { padding: 0.75rem; }
    }

    body.dark-mode .modal-header-custom { border-bottom-color: #334155; }

    .modal-header-custom h3 {
        font-size: 1rem;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    @media (max-width: 576px) {
        .modal-header-custom h3 { font-size: 0.9rem; }
    }

    .modal-close-btn {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        border: 2px solid rgba(255, 255, 255, 0.3);
        background: transparent;
        color: white;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition-base);
        font-size: 0.9rem;
        flex-shrink: 0;
    }

    @media (max-width: 576px) {
        .modal-close-btn {
            width: 28px;
            height: 28px;
            font-size: 0.8rem;
        }
    }

    .modal-close-btn:hover {
        background: var(--danger);
        border-color: var(--danger);
        transform: rotate(90deg);
    }

    .modal-body-custom { padding: 1.25rem; }

    @media (max-width: 576px) {
        .modal-body-custom { padding: 0.75rem; }
    }

    .modal-body-custom .form-group { margin-bottom: 0.75rem; }

    .payment-info-box {
        background: var(--bg-light);
        padding: 0.75rem;
        border-radius: 8px;
        margin-bottom: 1rem;
        border: 1px solid var(--border-color);
    }

    @media (max-width: 576px) {
        .payment-info-box { padding: 0.6rem; }
    }

    body.dark-mode .payment-info-box {
        background: #0f172a;
        border-color: #334155;
    }

    .payment-info-box p {
        margin-bottom: 0.35rem;
        font-size: 0.85rem;
        color: var(--text);
    }

    body.dark-mode .payment-info-box p { color: #e2e8f0; }
    .payment-info-box p:last-child { margin-bottom: 0; }
    .remaining-text { color: var(--warning); }

    .modal-footer-custom {
        padding: 1.25rem;
        border-top: 1px solid var(--border-color);
        display: flex;
        gap: 0.6rem;
        position: sticky;
        bottom: 0;
        background: white;
        z-index: 1;
    }

    @media (max-width: 576px) {
        .modal-footer-custom {
            padding: 0.75rem;
            flex-direction: column-reverse;
        }
    }

    body.dark-mode .modal-footer-custom {
        background: #1e293b;
        border-top-color: #334155;
    }

    .btn-cancel {
        flex: 1;
        padding: 0.6rem 1.25rem;
        background: var(--bg-light);
        color: var(--text);
        border: 2px solid var(--border-color);
        border-radius: 25px;
        font-weight: 600;
        font-size: 0.85rem;
        cursor: pointer;
        transition: var(--transition-base);
    }

    body.dark-mode .btn-cancel {
        background: #334155;
        border-color: #475569;
        color: #e2e8f0;
    }

    .btn-cancel:hover { background: var(--border-color); }

    .btn-save {
        flex: 1;
        padding: 0.6rem 1.25rem;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        border: none;
        border-radius: 25px;
        font-weight: 600;
        font-size: 0.85rem;
        cursor: pointer;
        transition: var(--transition-base);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
    }

    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(74, 100, 145, 0.4);
    }

    .btn-save:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
    }

    .spinner {
        width: 18px;
        height: 18px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-top-color: white;
        border-radius: 50%;
        animation: spin 0.6s linear infinite;
        display: inline-block;
        flex-shrink: 0;
    }

    @keyframes spin { to { transform: rotate(360deg); } }

    .dir-ltr { direction: ltr; text-align: left; }

    /* Container */
    .container {
        padding-left: 1rem;
        padding-right: 1rem;
    }

    @media (min-width: 576px) {
        .container {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }
    }

    @media (min-width: 992px) {
        .container {
            padding-left: 2rem;
            padding-right: 2rem;
        }
    }

    /* Prevent iOS zoom */
    @media (max-width: 576px) {
        input, select, textarea, button {
            font-size: 16px !important;
        }
    }

    /* Fix for alert container on mobile */
    @media (max-width: 480px) {
        #alert-container {
            width: calc(100vw - 20px);
            top: 10px;
            right: 10px;
        }
        
        .alert-custom {
            padding: 0.6rem;
            font-size: 0.8rem;
        }
        
        .alert-custom i {
            font-size: 0.9rem !important;
        }
    }
</style>

<div id="alert-container"></div>

<div class="container py-3 py-md-4">
    <!-- Page Header -->
    <div class="card shadow-sm mb-3 border-0 rounded-4 overflow-hidden">
        <div class="card-header form-header-custom text-white text-center py-2 py-md-3">
            <div class="form-logo-custom">
                <i class="fas fa-building"></i>
            </div>
            <h1 class="h5 mb-1">قەرزی کۆمپانیاکان</h1>
            <p class="mb-0 opacity-75 small">بەڕێوەبردنی قەرز و پارەدانەکانی کۆمپانیاکان</p>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon stat-icon-purple"><i class="fas fa-coins"></i></div>
            <div class="stat-label">کۆی گشتی قەرزەکان</div>
            <div class="stat-value dir-ltr" id="stat-total-debt">0 د.ع</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon stat-icon-emerald"><i class="fas fa-check-circle"></i></div>
            <div class="stat-label">کۆی پارەی دراو</div>
            <div class="stat-value dir-ltr" id="stat-total-paid">0 د.ع</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon stat-icon-red"><i class="fas fa-clock"></i></div>
            <div class="stat-label">کۆی قەرزی ماوە</div>
            <div class="stat-value dir-ltr" id="stat-total-remaining">0 د.ع</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon stat-icon-blue"><i class="fas fa-building"></i></div>
            <div class="stat-label">ژمارەی کۆمپانیاکان</div>
            <div class="stat-value" id="stat-companies-count">0</div>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="content-grid">
        <div class="form-column" id="formCard">
            <div class="form-card">
                <div class="form-card-header">
                    <i class="fas fa-plus-circle"></i>
                    <h2 id="formTitle">تۆمارکردنی قەرزی نوێ</h2>
                </div>
                <div class="form-card-body">
                    <form id="debt-form" onsubmit="handleDebtFormSubmit(event)">
                        @csrf
                        <input type="hidden" id="edit_id" value="">
                        
                        <div class="form-group">
                            <label class="form-label-custom">
                                <i class="fas fa-building"></i> ناوی کۆمپانیا <span class="required">*</span>
                            </label>
                            <input type="text" id="company_name" name="company_name" class="form-control-custom" placeholder="ناوی کۆمپانیاکە بنووسە..." required>
                        </div>

                        <div class="form-group">
                            <label class="form-label-custom">
                                <i class="fas fa-money-bill-wave"></i> بڕی قەرز <span class="required">*</span>
                            </label>
                            <div class="input-with-currency">
                                <input type="text" id="debt_amount" name="debt_amount" class="form-control-custom dir-ltr" placeholder="0" required>
                                <span class="currency-badge">د.ع</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label-custom">
                                <i class="fas fa-calendar-alt"></i> بەرواری قەرز <span class="required">*</span>
                            </label>
                            <input type="date" id="debt_date" name="debt_date" class="form-control-custom" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label-custom">
                                <i class="fas fa-calendar-check"></i> بەرواری کۆتایی
                            </label>
                            <input type="date" id="due_date" name="due_date" class="form-control-custom">
                        </div>

                        <div class="form-group">
                            <label class="form-label-custom">
                                <i class="fas fa-sticky-note"></i> تێبینی
                            </label>
                            <textarea id="note" name="note" class="form-control-custom" rows="2" placeholder="تێبینییەکت بنووسە..."></textarea>
                        </div>

                        <button type="submit" id="submit-btn" class="btn-primary-custom">
                            <i class="fas fa-save"></i> تۆمارکردنی قەرز
                        </button>
                        <button type="button" id="cancel-btn" class="btn-secondary-custom" onclick="cancelEdit()" style="display: none;">
                            <i class="fas fa-times"></i> پاشگەزبوونەوە
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="table-column">
            <div class="table-card">
                <div class="table-card-header">
                    <div class="header-title">
                        <i class="fas fa-list"></i>
                        <h2>لیستی قەرزەکان</h2>
                    </div>
                    <div class="search-box">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" id="searchInput" class="search-input-custom" placeholder="گەڕان...">
                    </div>
                </div>
                <div class="table-wrapper">
                    <div id="table-body">
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <p>هیچ قەرزێک نەدۆزرایەوە</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div class="modal-overlay" id="paymentModal">
    <div class="modal-content-custom">
        <div class="modal-header-custom">
            <h3><i class="fas fa-money-bill-wave"></i> تۆمارکردنی پارەدان</h3>
            <button class="modal-close-btn" onclick="closePaymentModal()"><i class="fas fa-times"></i></button>
        </div>
        <form id="payment-form" onsubmit="submitPayment(event)">
            <div class="modal-body-custom">
                <input type="hidden" id="payment_debt_id">
                <div class="payment-info-box">
                    <p>ناوی کۆمپانیا: <strong id="payment_company_name"></strong></p>
                    <p class="remaining-text">قەرزی ماوە: <strong id="payment_remaining"></strong></p>
                </div>
                <div class="form-group">
                    <label class="form-label-custom">بڕی پارەدان</label>
                    <div class="input-with-currency">
                        <input type="text" id="payment_amount" class="form-control-custom dir-ltr" placeholder="0" required>
                        <span class="currency-badge">د.ع</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label-custom">بەرواری پارەدان</label>
                    <input type="date" id="payment_date" class="form-control-custom" required>
                </div>
                <div class="form-group">
                    <label class="form-label-custom">تێبینی</label>
                    <textarea id="payment_note" class="form-control-custom" rows="2" placeholder="تێبینی..."></textarea>
                </div>
            </div>
            <div class="modal-footer-custom">
                <button type="button" class="btn-cancel" onclick="closePaymentModal()">پاشگەزبوونەوە</button>
                <button type="submit" id="save-payment-btn" class="btn-save">
                    <i class="fas fa-check"></i> تۆمارکردن
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
let isEditMode = false, isSubmitting = false, isPaymentSubmitting = false;

function escapeHtml(v) { return v == null ? '' : String(v).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#039;'); }
function formatNumber(v) { return (!v && v !== 0) ? '' : v.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','); }
function unformatNumber(v) { return v ? v.toString().replace(/,/g, '') : '0'; }
function formatCurrency(a) { const n = parseFloat(a); return isNaN(n) ? '0 د.ع' : Math.round(n).toLocaleString('en-US',{minimumFractionDigits:0,maximumFractionDigits:0}) + ' د.ع'; }

function showAlert(type, msg) {
    const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
    const cls = type === 'success' ? 'alert-success-custom' : 'alert-error-custom';
    const id = 'alert-' + Date.now();
    $('#alert-container').prepend(`<div id="${id}" class="alert-custom ${cls}"><i class="fas ${icon}" style="font-size:1.1rem;"></i><div style="flex:1;min-width:0;"><strong>${type==='success'?'سەرکەوتوو':'هەڵە'}</strong><br><small style="word-break:break-word;">${escapeHtml(msg)}</small></div><button class="btn-close" style="font-size:.65rem;flex-shrink:0;" onclick="$('#${id}').fadeOut(300,function(){$(this).remove();})"></button></div>`);
    setTimeout(() => { $(`#${id}`).fadeOut(300, function(){ $(this).remove(); }); }, 4000);
}

$('#debt_date').val(new Date().toISOString().split('T')[0]);
$('#payment_date').val(new Date().toISOString().split('T')[0]);

$('#debt_amount, #payment_amount').on('input', function() {
    let v = $(this).val(), n = v.replace(/[^0-9]/g, '');
    if (n === '') { $(this).val(''); return; }
    $(this).val(formatNumber(n.slice(0, 15)));
});

function loadData() {
    $.ajax({
        url: '{{ route("company.debts.list") }}',
        type: 'GET',
        data: { search: $('#searchInput').val() },
        success: function(r) {
            if (r.success) { updateStats(r.stats); renderTable(r.data); }
            else showAlert('error', r.message || 'هەڵەیەک ڕوویدا');
        },
        error: function() { showAlert('error', 'هەڵەی پەیوەندی'); }
    });
}

function updateStats(s) {
    $('#stat-total-debt').text(formatCurrency(s.total_debt||0));
    $('#stat-total-paid').text(formatCurrency(s.total_paid||0));
    $('#stat-total-remaining').text(formatCurrency(s.total_remaining||0));
    $('#stat-companies-count').text(s.companies_count||0);
}

function renderTable(data) {
    if (!data || !data.length) {
        $('#table-body').html(`<div class="empty-state"><i class="fas fa-inbox"></i><p>هیچ قەرزێک نەدۆزرایەوە</p></div>`);
        return;
    }
    let h = `<table class="debt-table"><thead><tr><th>#</th><th>ناوی کۆمپانیا</th><th>بڕی قەرز</th><th>پارەی دراو</th><th>قەرزی ماوە</th><th>بەرواری قەرز</th><th>بەرواری کۆتایی</th><th>دۆخ</th><th>کردارەکان</th></tr></thead><tbody>`;
    data.forEach(function(item, i) {
        const da = parseFloat(item.debt_amount)||0, tp = parseFloat(item.total_paid)||0, rm = Math.max(0, da - tp);
        let sb = '', sc = '';
        if (rm <= 0) { sb = 'پارەدراوە'; sc = 'badge-custom badge-success'; }
        else if (tp > 0) { sb = 'بەشێک دراوە'; sc = 'badge-custom badge-warning'; }
        else { sb = 'نەدراوە'; sc = 'badge-custom badge-danger'; }
        h += `<tr>
            <td style="color:#64748b;font-size:11px;width:25px;">${i+1}</td>
            <td style="font-weight:600;color:var(--primary);font-size:0.8rem;">${escapeHtml(item.company_name)}</td>
            <td style="font-weight:700;color:#ef4444;font-size:0.8rem;" class="dir-ltr">${formatCurrency(da)}</td>
            <td style="font-weight:700;color:#10b981;font-size:0.8rem;" class="dir-ltr">${formatCurrency(tp)}</td>
            <td style="font-weight:700;color:#f59e0b;font-size:0.8rem;" class="dir-ltr">${formatCurrency(rm)}</td>
            <td style="color:#64748b;font-size:11px;">${escapeHtml(item.debt_date||'-')}</td>
            <td style="color:#64748b;font-size:11px;">${escapeHtml(item.due_date||'-')}</td>
            <td><span class="${sc}">${sb}</span></td>
            <td style="text-align:center;white-space:nowrap;">${rm>0?`<button class="btn-table-action btn-payment" title="پارەدان" data-id="${item.id}" data-name="${escapeHtml(item.company_name)}" data-remaining="${rm}"><i class="fas fa-money-bill-wave"></i></button>`:''}<button class="btn-table-action btn-edit" title="دەستکاری" data-id="${item.id}" data-name="${escapeHtml(item.company_name)}" data-amount="${da}" data-debt-date="${escapeHtml(item.debt_date||'')}" data-due-date="${escapeHtml(item.due_date||'')}" data-note="${escapeHtml(item.note||'')}"><i class="fas fa-edit"></i></button><button class="btn-table-action btn-delete" title="سڕینەوە" data-id="${item.id}"><i class="fas fa-trash"></i></button></td></tr>`;
    });
    h += '</tbody></table>';
    $('#table-body').html(h);
}

$('#table-body').on('click', '.btn-payment', function() { openPaymentModal($(this).data('id'), $(this).data('name'), parseFloat($(this).data('remaining'))||0); });
$('#table-body').on('click', '.btn-edit', function() { editDebt($(this).data('id'), $(this).data('name'), parseFloat($(this).data('amount'))||0, String($(this).data('debt-date')||''), String($(this).data('due-date')||''), String($(this).data('note')||'')); });
$('#table-body').on('click', '.btn-delete', function() { deleteDebt($(this).data('id')); });

function handleDebtFormSubmit(e) {
    e.preventDefault();
    if (isSubmitting) return;
    const cn = $('#company_name').val().trim(), da = parseInt(unformatNumber($('#debt_amount').val()),10), dd = $('#debt_date').val(), du = $('#due_date').val(), nt = $('#note').val();
    if (!cn) { showAlert('error','ناوی کۆمپانیا پێویستە'); return; }
    if (!da || isNaN(da) || da < 1) { showAlert('error','بڕی قەرز دەبێت لە ١ زیاتر بێت'); return; }
    if (!dd) { showAlert('error','بەرواری قەرز پێویستە'); return; }
    if (du && du < dd) { showAlert('error','بەرواری کۆتایی ناتوانێت پێش بەرواری قەرز بێت'); return; }
    isSubmitting = true;
    const $b = $('#submit-btn'), ot = $b.html();
    $b.html('<span class="spinner"></span> تکایە چاوەڕێ بکە...').prop('disabled', true);
    const url = isEditMode ? `/company-debts/${$('#edit_id').val()}` : '{{ route("company.debts.store") }}';
    $.ajax({
        url, type: isEditMode ? 'PUT' : 'POST',
        data: { company_name: cn, debt_amount: da, debt_date: dd, due_date: du || null, note: nt || '' },
        success: function(r) {
            if (r.success) { showAlert('success', isEditMode ? 'قەرز نوێکرایەوە' : 'قەرز تۆمارکرا'); resetForm(); loadData(); }
            else showAlert('error', r.message || 'هەڵەیەک ڕوویدا');
        },
        error: function(x) {
            let m = 'هەڵەی پەیوەندی';
            try { const r = JSON.parse(x.responseText); if (r.message) m = r.message; if (r.errors) m = Object.values(r.errors).flat().join('، '); } catch(e) {}
            showAlert('error', m);
        },
        complete: function() { isSubmitting = false; $b.html(ot).prop('disabled', false); }
    });
}

function editDebt(id, cn, da, dd, du, nt) {
    isEditMode = true;
    $('#edit_id').val(id); $('#company_name').val(cn); $('#debt_amount').val(formatNumber(da.toString())); $('#debt_date').val(dd||''); $('#due_date').val(du||''); $('#note').val(nt||'');
    $('#formTitle').text('دەستکاری قەرز'); $('#submit-btn').html('<i class="fas fa-save"></i> نوێکردنەوە'); $('#cancel-btn').show();
    if (window.innerWidth <= 1100) $('html, body').animate({ scrollTop: $('#formCard').offset().top - 20 }, 500);
    $('#company_name').focus();
}
function cancelEdit() { resetForm(); }
function resetForm() {
    isEditMode = false;
    $('#edit_id').val(''); $('#company_name').val(''); $('#debt_amount').val(''); $('#debt_date').val(new Date().toISOString().split('T')[0]); $('#due_date').val(''); $('#note').val('');
    $('#formTitle').text('تۆمارکردنی قەرزی نوێ'); $('#submit-btn').html('<i class="fas fa-save"></i> تۆمارکردنی قەرز'); $('#cancel-btn').hide();
}
function deleteDebt(id) {
    if (!confirm('ئایا دڵنیایت؟')) return;
    $.ajax({
        url: `/company-debts/${id}`, type: 'DELETE',
        success: function(r) { if (r.success) { showAlert('success','سڕایەوە'); if (isEditMode && $('#edit_id').val() == id) resetForm(); loadData(); } else showAlert('error', r.message||'هەڵە'); },
        error: function() { showAlert('error','هەڵەی پەیوەندی'); }
    });
}
function openPaymentModal(id, cn, rm) {
    $('#payment_debt_id').val(id); $('#payment_company_name').text(cn); $('#payment_remaining').text(formatCurrency(rm)); $('#payment_amount').val(''); $('#payment_note').val(''); $('#payment_date').val(new Date().toISOString().split('T')[0]);
    $('#paymentModal').addClass('active'); $('body').css('overflow', 'hidden');
}
function closePaymentModal() { $('#paymentModal').removeClass('active'); $('body').css('overflow', ''); }
window.cancelEdit = cancelEdit;
window.closePaymentModal = closePaymentModal;

function submitPayment(e) {
    e.preventDefault();
    if (isPaymentSubmitting) return;
    const id = $('#payment_debt_id').val(), am = parseInt(unformatNumber($('#payment_amount').val()),10), dt = $('#payment_date').val(), nt = $('#payment_note').val();
    if (!id) { showAlert('error','هەڵە'); return; }
    if (!am || isNaN(am) || am < 1) { showAlert('error','بڕی پارەدان دەبێت لە ١ زیاتر بێت'); return; }
    if (!dt) { showAlert('error','بەرواری پارەدان پێویستە'); return; }
    isPaymentSubmitting = true;
    const $b = $('#save-payment-btn'), ot = $b.html();
    $b.prop('disabled', true).html('<span class="spinner"></span> چاوەڕێ بکە...');
    $.ajax({
        url: `/company-debts/${id}/payment`, type: 'POST',
        data: { amount: am, payment_date: dt, note: nt || '' },
        success: function(r) { if (r.success) { showAlert('success','پارەدان تۆمارکرا'); closePaymentModal(); loadData(); } else showAlert('error', r.message||'هەڵە'); },
        error: function(x) { let m = 'هەڵەی پەیوەندی'; try { m = JSON.parse(x.responseText).message || m; } catch(e) {} showAlert('error', m); },
        complete: function() { isPaymentSubmitting = false; $b.prop('disabled', false).html(ot); }
    });
}
window.submitPayment = submitPayment;
window.handleDebtFormSubmit = handleDebtFormSubmit;

$('#paymentModal').on('click', function(e) { if (e.target === this) closePaymentModal(); });
$(document).on('keydown', function(e) { if (e.key === 'Escape' && $('#paymentModal').hasClass('active')) closePaymentModal(); });

let searchTimeout;
$('#searchInput').on('input', function() { clearTimeout(searchTimeout); searchTimeout = setTimeout(loadData, 300); });

$(document).ready(function() {
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
    loadData();
});
</script>
@endsection