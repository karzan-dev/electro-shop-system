@extends('layouts.navigation')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    :root {
        --casher: #3b82f6;
        --casher-light: #eff6ff;
        --discount: #f59e0b;
        --discount-light: #fffbeb;
        --before: #10b981;
        --before-light: #ecfdf5;
        --after: #8b5cf6;
        --after-light: #f5f3ff;
        --header-bg: #1e293b;
        --header-gradient: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --danger-light: #fef2f2;
        --text: #1e293b;
        --text-secondary: #64748b;
        --text-muted: #94a3b8;
        --border-color: #e2e8f0;
        --bg-white: #ffffff;
        --bg-light: #f8fafc;
        --bg-body: #f1f5f9;
        --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1);
        --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
        --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1);
        --radius-sm: 0.375rem;
        --radius: 0.5rem;
        --radius-md: 0.75rem;
        --radius-lg: 1rem;
        --radius-xl: 1.5rem;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body.dark-mode {
        --text: #e2e8f0;
        --text-secondary: #94a3b8;
        --text-muted: #64748b;
        --border-color: #334155;
        --bg-white: #1e293b;
        --bg-light: #1e293b;
        --bg-body: #0f172a;
        --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.3);
        --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.4);
        --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.4);
        --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.4);
        --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.4);
        --casher-light: rgba(59, 130, 246, 0.15);
        --discount-light: rgba(245, 158, 11, 0.15);
        --before-light: rgba(16, 185, 129, 0.15);
        --after-light: rgba(139, 92, 246, 0.15);
        --danger-light: rgba(239, 68, 68, 0.15);
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background: var(--bg-body);
        font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
        color: var(--text);
        transition: background-color 0.3s ease, color 0.3s ease;
        min-height: 100vh;
        line-height: 1.6;
    }

    /* Alert Container */
    #alert-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        width: 400px;
        max-width: 90vw;
    }

    .alert-toast {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 16px 20px;
        border-radius: var(--radius-lg);
        backdrop-filter: blur(10px);
        box-shadow: var(--shadow-xl);
        animation: slideInRight 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        font-weight: 500;
        font-size: 0.95rem;
        margin-bottom: 12px;
        background: var(--bg-white);
        border: 1px solid var(--border-color);
    }

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

    @keyframes fadeOut {
        from { opacity: 1; }
        to { opacity: 0; }
    }

    .alert-success {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        color: #065f46;
        border-left: 4px solid var(--success);
    }

    .alert-error {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        color: #991b1b;
        border-left: 4px solid var(--danger);
    }

    body.dark-mode .alert-success {
        background: linear-gradient(135deg, #064e3b, #065f46);
        color: #d1fae5;
    }

    body.dark-mode .alert-error {
        background: linear-gradient(135deg, #7f1d1d, #991b1b);
        color: #fecaca;
    }

    /* Main Container */
    .main-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 32px 24px;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }

    .stat-card {
        background: var(--bg-white);
        backdrop-filter: blur(10px);
        border-radius: var(--radius-lg);
        padding: 24px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-color);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        cursor: default;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-xl);
    }

    .stat-card:nth-child(1)::before { 
        background: linear-gradient(90deg, var(--casher), #60a5fa); 
    }
    .stat-card:nth-child(2)::before { 
        background: linear-gradient(90deg, var(--discount), #fbbf24); 
    }
    .stat-card:nth-child(3)::before { 
        background: linear-gradient(90deg, var(--before), #34d399); 
    }
    .stat-card:nth-child(4)::before { 
        background: linear-gradient(90deg, var(--after), #a78bfa); 
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 16px;
    }

    .stat-icon.casher {
        background: var(--casher-light);
        color: var(--casher);
    }

    .stat-icon.discount {
        background: var(--discount-light);
        color: var(--discount);
    }

    .stat-icon.before {
        background: var(--before-light);
        color: var(--before);
    }

    .stat-icon.after {
        background: var(--after-light);
        color: var(--after);
    }

    .stat-label {
        font-size: 0.875rem;
        color: var(--text-secondary);
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 8px;
    }

    .stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--text);
        line-height: 1.2;
        font-family: 'Courier New', monospace;
    }

    /* Content Wrapper */
    .content-wrapper {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        align-items: start;
    }

    @media (max-width: 1024px) {
        .content-wrapper {
            grid-template-columns: 1fr;
        }
        
        .withdraw-card {
            position: static !important;
        }
    }

    /* Withdraw Card */
    .withdraw-card {
        background: var(--bg-white);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-lg);
        overflow: hidden;
        border: 1px solid var(--border-color);
        transition: var(--transition);
        position: sticky;
        top: 100px;
    }

    .withdraw-header {
        background: var(--header-gradient);
        padding: 32px;
        color: white;
        position: relative;
        overflow: hidden;
        transition: var(--transition);
    }

    .withdraw-header::after {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 60%);
        animation: pulse 3s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 0.5; }
        50% { transform: scale(1.1); opacity: 0.8; }
    }

    .withdraw-header.edit-mode {
        background: linear-gradient(135deg, var(--discount) 0%, #fbbf24 100%);
    }

    .withdraw-icon {
        width: 64px;
        height: 64px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        margin-bottom: 16px;
        position: relative;
        z-index: 1;
        backdrop-filter: blur(10px);
        transition: var(--transition);
    }

    .withdraw-icon.edit-mode {
        background: rgba(255, 255, 255, 0.3);
    }

    .withdraw-title {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 8px;
        position: relative;
        z-index: 1;
    }

    .withdraw-subtitle {
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.95rem;
        position: relative;
        z-index: 1;
    }

    .withdraw-body {
        padding: 32px;
    }

    .form-group {
        margin-bottom: 24px;
    }

    .form-label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 600;
        color: var(--text);
        margin-bottom: 12px;
        font-size: 0.95rem;
    }

    .form-label i {
        color: var(--casher);
        font-size: 1rem;
    }

    .optional-badge {
        background: var(--bg-light);
        color: var(--text-muted);
        font-size: 0.75rem;
        padding: 4px 12px;
        border-radius: 20px;
        font-weight: 500;
        border: 1px solid var(--border-color);
    }

    .amount-section {
        background: var(--bg-light);
        border: 2px solid var(--border-color);
        border-radius: var(--radius-md);
        padding: 20px;
        transition: var(--transition);
    }

    .amount-section:focus-within {
        border-color: var(--casher);
        background: var(--bg-white);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .amount-section.edit-mode:focus-within {
        border-color: var(--discount);
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
    }

    .amount-input-wrapper {
        margin-bottom: 16px;
    }

    .amount-input {
        width: 100%;
        padding: 14px 16px;
        font-size: 2rem;
        font-weight: 700;
        border: none;
        background: transparent;
        color: var(--text);
        text-align: center;
        outline: none;
        font-family: 'Courier New', monospace;
        letter-spacing: 2px;
    }

    .amount-input::placeholder {
        color: var(--text-muted);
        font-size: 1.5rem;
    }

    .currency-badge {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 8px 16px;
        background: var(--casher);
        color: white;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.875rem;
        width: fit-content;
        margin: 0 auto 16px;
        transition: var(--transition);
    }

    .currency-badge.edit-mode {
        background: var(--discount);
    }

    .quick-amounts {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 8px;
    }

    .quick-amount-btn {
        padding: 10px 12px;
        background: var(--bg-white);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-sm);
        cursor: pointer;
        font-weight: 500;
        font-size: 0.875rem;
        transition: var(--transition);
        color: var(--text-secondary);
    }

    .quick-amount-btn:hover {
        background: var(--casher-light);
        border-color: var(--casher);
        color: var(--casher);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .custom-textarea {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid var(--border-color);
        border-radius: var(--radius-md);
        font-size: 0.95rem;
        font-family: inherit;
        resize: vertical;
        transition: var(--transition);
        background: var(--bg-light);
        color: var(--text);
    }

    .custom-textarea:focus {
        outline: none;
        border-color: var(--casher);
        background: var(--bg-white);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .custom-textarea::placeholder {
        color: var(--text-muted);
    }

    .submit-btn {
        width: 100%;
        padding: 16px;
        background: linear-gradient(135deg, var(--casher) 0%, #2563eb 100%);
        color: white;
        border: none;
        border-radius: var(--radius-md);
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        position: relative;
        overflow: hidden;
    }

    .submit-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s ease;
    }

    .submit-btn:hover::before {
        left: 100%;
    }

    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .submit-btn:active {
        transform: translateY(0);
    }

    .submit-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .submit-btn.edit-mode {
        background: linear-gradient(135deg, var(--discount) 0%, #fbbf24 100%);
    }

    .cancel-edit-btn {
        width: 100%;
        padding: 12px;
        margin-top: 12px;
        background: var(--bg-white);
        color: var(--text-secondary);
        border: 2px solid var(--border-color);
        border-radius: var(--radius-md);
        font-size: 0.95rem;
        font-weight: 500;
        cursor: pointer;
        transition: var(--transition);
        display: none;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .cancel-edit-btn:hover {
        border-color: var(--danger);
        color: var(--danger);
        background: var(--danger-light);
    }

    .cancel-edit-btn.visible {
        display: flex;
    }

    /* History Card */
    .history-card {
        background: var(--bg-white);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-lg);
        overflow: hidden;
        border: 1px solid var(--border-color);
    }

    .history-header {
        background: var(--header-gradient);
        padding: 24px 32px;
        color: white;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .history-header i {
        font-size: 1.25rem;
        opacity: 0.9;
    }

    .history-header h2 {
        font-size: 1.25rem;
        font-weight: 600;
    }

    .filter-section {
        padding: 20px 32px;
        display: flex;
        gap: 16px;
        background: var(--bg-light);
        border-bottom: 1px solid var(--border-color);
        flex-wrap: wrap;
    }

    .filter-group {
        flex: 1;
        min-width: 200px;
    }

    .filter-group label {
        display: block;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-secondary);
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .filter-input {
        width: 100%;
        padding: 10px 14px;
        border: 2px solid var(--border-color);
        border-radius: var(--radius-sm);
        font-size: 0.9rem;
        transition: var(--transition);
        background: var(--bg-white);
        color: var(--text);
    }

    .filter-input:focus {
        outline: none;
        border-color: var(--casher);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .history-body {
        padding: 24px;
        overflow-x: auto;
    }

    .withdraw-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.9rem;
    }

    .withdraw-table thead th {
        background: var(--bg-light);
        padding: 14px 16px;
        text-align: right;
        font-weight: 600;
        color: var(--text-secondary);
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 2px solid var(--border-color);
        white-space: nowrap;
    }

    .withdraw-table tbody td {
        padding: 16px;
        border-bottom: 1px solid var(--border-color);
        color: var(--text);
        transition: var(--transition);
    }

    .withdraw-table tbody tr {
        transition: var(--transition);
    }

    .withdraw-table tbody tr:hover {
        background: var(--bg-light);
    }

    .withdraw-table tbody tr.editing {
        background: rgba(245, 158, 11, 0.1);
        box-shadow: inset 4px 0 0 var(--discount);
    }

    .amount-cell {
        font-weight: 700;
        color: var(--danger);
        font-family: 'Courier New', monospace;
        font-size: 1rem;
    }

    .note-cell {
        max-width: 200px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        color: var(--text-muted);
    }

    .date-cell {
        white-space: nowrap;
        font-size: 0.85rem;
        color: var(--text-muted);
    }

    .action-cell {
        display: flex;
        gap: 8px;
    }

    .btn-action {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        border: none;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
    }

    .btn-edit {
        background: rgba(59, 130, 246, 0.1);
        color: var(--casher);
    }

    .btn-edit:hover {
        background: var(--casher);
        color: white;
        transform: scale(1.1);
    }

    .btn-delete {
        background: var(--danger-light);
        color: var(--danger);
    }

    .btn-delete:hover {
        background: var(--danger);
        color: white;
        transform: scale(1.1);
    }

    .btn-action:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
    }

    .total-section {
        padding: 20px 32px;
        background: var(--bg-light);
        border-top: 2px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .total-label {
        font-weight: 600;
        color: var(--text);
        font-size: 1.1rem;
    }

    .total-amount {
        font-weight: 700;
        color: var(--danger);
        font-size: 1.3rem;
        font-family: 'Courier New', monospace;
    }

    .no-data {
        text-align: center;
        padding: 48px 24px;
        color: var(--text-muted);
    }

    .no-data i {
        font-size: 3rem;
        margin-bottom: 16px;
        display: block;
    }

    .no-data p {
        font-size: 1rem;
    }

    /* Scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    ::-webkit-scrollbar-track {
        background: var(--bg-light);
    }

    ::-webkit-scrollbar-thumb {
        background: var(--text-muted);
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: var(--text-secondary);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .main-container {
            padding: 16px;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .withdraw-body {
            padding: 20px;
        }

        .amount-input {
            font-size: 1.5rem;
        }

        .quick-amounts {
            grid-template-columns: repeat(2, 1fr);
        }

        .filter-section {
            flex-direction: column;
            padding: 16px;
        }

        .history-body {
            padding: 16px;
        }

        .withdraw-table {
            font-size: 0.8rem;
        }

        .action-cell {
            flex-direction: column;
        }
        
        .withdraw-table thead th,
        .withdraw-table tbody td {
            padding: 10px 8px;
        }
    }

    @media (max-width: 480px) {
        .stat-card {
            padding: 16px;
        }
        
        .stat-value {
            font-size: 1.25rem;
        }
        
        .withdraw-header {
            padding: 24px;
        }
        
        .withdraw-title {
            font-size: 1.25rem;
        }
        
        .quick-amounts {
            grid-template-columns: 1fr 1fr;
        }
    }
</style>

<div id="alert-container"></div>

<div class="main-container">
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon casher"><i class="fas fa-coins"></i></div>
            <div class="stat-label">پارەی ناو قاسە</div>
            <div class="stat-value" id="stat-casher">{{ number_format($cashInDrawer ?? 0, 0) }} د.ع</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon discount"><i class="fas fa-tags"></i></div>
            <div class="stat-label">کۆی داشکان</div>
            <div class="stat-value" id="stat-discount">{{ number_format($totalDiscount ?? 0, 0) }} د.ع</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon before"><i class="fas fa-arrow-up"></i></div>
            <div class="stat-label">پارەی پێش ڕاکێشان</div>
            <div class="stat-value" id="stat-before">{{ number_format($lastCashBeforeWithdraw ?? $cashInDrawer ?? 0, 0) }} د.ع</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon after"><i class="fas fa-wallet"></i></div>
            <div class="stat-label">پارەی دوای ڕاکێشان</div>
            <div class="stat-value" id="stat-after">{{ number_format($lastCashAfterWithdraw ?? $cashInDrawer ?? 0, 0) }} د.ع</div>
        </div>
    </div>

    <div class="content-wrapper">
        <div class="withdraw-card" id="withdrawCard">
            <div class="withdraw-header" id="withdrawHeader">
                <div class="withdraw-icon" id="withdrawIcon">
                    <i class="fas fa-arrow-up" id="withdrawIconElement"></i>
                </div>
                <h1 class="withdraw-title" id="withdrawTitle">ڕاکێشانی پارە</h1>
                <p class="withdraw-subtitle" id="withdrawSubtitle">ڕاکێشانی پارە لە قاسە بە شێوەیەکی سادە</p>
            </div>

            <div class="withdraw-body">
                <form id="withdraw-form">
                    @csrf
                    <input type="hidden" id="edit_id" value="">
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-money-bill-wave"></i>
                            بڕی پارە
                            <span style="color: #ef4444;">*</span>
                        </label>
                        <div class="amount-section" id="amountSection">
                            <div class="amount-input-wrapper">
                                <input type="text" id="amount" name="amount" class="amount-input" placeholder="0" autocomplete="off" required>
                            </div>
                            <div class="currency-badge" id="currencyBadge">
                                <i class="fas fa-circle" style="font-size: 0.5rem;"></i>
                                IQD
                            </div>
                            <div class="quick-amounts">
                                <button type="button" class="quick-amount-btn" data-amount="5000">5,000</button>
                                <button type="button" class="quick-amount-btn" data-amount="10000">10,000</button>
                                <button type="button" class="quick-amount-btn" data-amount="25000">25,000</button>
                                <button type="button" class="quick-amount-btn" data-amount="50000">50,000</button>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-sticky-note"></i>
                            تێبینی
                            <span class="optional-badge">ئارەزوومەندانە</span>
                        </label>
                        <textarea id="note" name="note" class="custom-textarea" placeholder="تێبینییەکت بنووسە..." rows="3"></textarea>
                    </div>

                    <button type="submit" class="submit-btn" id="submit-btn">
                        <i class="fas fa-arrow-up ms-2"></i>
                        ڕاکێشانی پارە
                    </button>

                    <button type="button" class="cancel-edit-btn" id="cancel-edit-btn" onclick="cancelEdit()">
                        <i class="fas fa-times ms-2"></i>
                        پاشگەزبوونەوە
                    </button>
                </form>
            </div>
        </div>

        <div class="history-card">
            <div class="history-header">
                <i class="fas fa-history"></i>
                <h2>مێژووی ڕاکێشانی پارە</h2>
            </div>

            <div class="filter-section">
                <div class="filter-group">
                    <label><i class="fas fa-calendar-alt ms-1"></i> بەرواری دەستپێک</label>
                    <input type="date" id="start_date" class="filter-input">
                </div>
                <div class="filter-group">
                    <label><i class="fas fa-calendar-alt ms-1"></i> بەرواری کۆتایی</label>
                    <input type="date" id="end_date" class="filter-input">
                </div>
            </div>

            <div class="history-body" id="history-body"></div>

            <div class="total-section" id="total-section" style="display: none;">
                <span class="total-label">کۆی گشتی</span>
                <span class="total-amount" id="total-amount">0 د.ع</span>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// ==================== GLOBAL VARIABLES ====================
let isEditMode = false;
let editingRowId = null;
let isSubmitting = false;

// ==================== GLOBAL FUNCTIONS ====================

function formatNumber(value) {
    if (!value && value !== 0) return '';
    return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}

function unformatNumber(value) {
    if (!value) return '0';
    return value.toString().replace(/,/g, '');
}

function formatCurrency(amount) {
    return parseFloat(amount).toLocaleString('en-US', {minimumFractionDigits: 0, maximumFractionDigits: 0}) + ' د.ع';
}

function showAlert(type, message) {
    let icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
    let alertClass = type === 'success' ? 'alert-success' : 'alert-error';
    $('#alert-container').html(`<div class="alert-toast ${alertClass}"><i class="fas ${icon}"></i><span>${message}</span></div>`);
    setTimeout(() => { $('#alert-container').fadeOut(300, function() { $(this).empty().show(); }); }, 4000);
}

function loadHistory() {
    const startDate = $('#start_date').val();
    const endDate = $('#end_date').val();

    $.ajax({
        url: '{{ route("withdraw.history") }}',
        type: 'GET',
        data: { start_date: startDate, end_date: endDate },
        success: function(response) {
            if (response.success) {
                if (response.stats) {
                    $('#stat-casher').text(formatCurrency(response.stats.cash_in_drawer || 0));
                    $('#stat-discount').text(formatCurrency(response.stats.total_discount || 0));
                    $('#stat-before').text(formatCurrency(response.stats.cash_before_withdraw || response.stats.cash_in_drawer || 0));
                    $('#stat-after').text(formatCurrency(response.stats.cash_after_withdraw || response.stats.cash_in_drawer || 0));
                }

                let html = '';
                
                if (response.data && response.data.length > 0) {
                    html += `<table class="withdraw-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>بڕی پارە</th>
                                <th>پارەی پێش ڕاکێشان</th>
                                <th>پارەی دوای ڕاکێشان</th>
                                <th>تێبینی</th>
                                <th>بەروار</th>
                                <th>کردارەکان</th>
                            </tr>
                        </thead>
                        <tbody>`;
                    
                    let totalSum = 0;
                    
                    response.data.forEach(function(item, index) {
                        totalSum += parseFloat(item.amount || 0);
                        const escapedNote = (item.note || '').replace(/'/g, "&#39;").replace(/"/g, '&quot;');
                        html += `<tr id="row-${item.id}" class="${editingRowId === item.id ? 'editing' : ''}">
                            <td>${index + 1}</td>
                            <td class="amount-cell">${formatCurrency(item.amount || 0)}</td>
                            <td>${formatCurrency(item.cash_before_withdraw || 0)}</td>
                            <td>${formatCurrency(item.cash_after_withdraw || 0)}</td>
                            <td class="note-cell">${item.note || '-'}</td>
                            <td class="date-cell">${item.created_at || ''}</td>
                            <td class="action-cell">
                                <button class="btn-action btn-edit" onclick="editWithdraw(${item.id}, ${item.amount}, '${escapedNote}')" title="دەستکاری" type="button">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-action btn-delete" onclick="deleteWithdrawDirect(${item.id})" title="سڕینەوە" type="button">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>`;
                    });
                    
                    html += '</tbody></table>';
                    $('#total-amount').text(formatCurrency(totalSum));
                    $('#total-section').show();
                } else {
                    html = '<div class="no-data"><i class="fas fa-inbox"></i><p>هیچ پارەیەک نەدۆزرایەوە</p></div>';
                    $('#total-section').hide();
                }
                
                $('#history-body').html(html);
            }
        },
        error: function(xhr) {
            console.error('Error loading history:', xhr);
            $('#history-body').html('<div class="no-data"><i class="fas fa-exclamation-triangle"></i><p>هەڵەیەک ڕوویدا</p></div>');
        }
    });
}

function editWithdraw(id, amount, note) {
    isEditMode = true;
    editingRowId = id;
    
    $('#edit_id').val(id);
    $('#amount').val(formatNumber(amount.toString()));
    $('#note').val(note || '');
    
    $('#withdrawHeader').addClass('edit-mode');
    $('#withdrawIcon').addClass('edit-mode');
    $('#withdrawIconElement').removeClass('fa-arrow-up').addClass('fa-edit');
    $('#withdrawTitle').text('دەستکاری ڕاکێشانی پارە');
    $('#withdrawSubtitle').text('بڕی پارە و تێبینییەکە دەستکاری بکە');
    $('#amountSection').addClass('edit-mode');
    $('#currencyBadge').addClass('edit-mode');
    
    const $btn = $('#submit-btn');
    $btn.addClass('edit-mode');
    $btn.html('<i class="fas fa-save ms-2"></i> نوێکردنەوە');
    
    $('#cancel-edit-btn').addClass('visible');
    
    loadHistory();
    
    $('html, body').animate({
        scrollTop: $('#withdrawCard').offset().top - 100
    }, 500);
    
    $('#amount').focus();
}

function cancelEdit() {
    resetForm();
}

function resetForm() {
    isEditMode = false;
    editingRowId = null;
    
    $('#edit_id').val('');
    $('#amount').val('');
    $('#note').val('');
    
    $('#withdrawHeader').removeClass('edit-mode');
    $('#withdrawIcon').removeClass('edit-mode');
    $('#withdrawIconElement').removeClass('fa-edit').addClass('fa-arrow-up');
    $('#withdrawTitle').text('ڕاکێشانی پارە');
    $('#withdrawSubtitle').text('ڕاکێشانی پارە لە قاسە بە شێوەیەکی سادە');
    $('#amountSection').removeClass('edit-mode');
    $('#currencyBadge').removeClass('edit-mode');
    
    const $btn = $('#submit-btn');
    $btn.removeClass('edit-mode');
    $btn.html('<i class="fas fa-arrow-up ms-2"></i> ڕاکێشانی پارە');
    
    $('#cancel-edit-btn').removeClass('visible');
    
    loadHistory();
}

// ==================== DELETE FUNCTION (DIRECT - NO CONFIRMATION) ====================
function deleteWithdrawDirect(id) {
    if (!id) {
        showAlert('error', 'هیچ ڕاکێشانێک دیاری نەکراوە');
        return;
    }
    
    // Disable the delete button for this row
    const $deleteBtn = $(`#row-${id} .btn-delete`);
    $deleteBtn.prop('disabled', true);
    $deleteBtn.html('<i class="fas fa-spinner fa-spin"></i>');

    $.ajax({
        url: `/withdraw/${id}`,
        type: 'DELETE',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                showAlert('success', 'ڕاکێشانی پارە بە سەرکەوتوویی سڕایەوە');
                
                // If we deleted the item we were editing, reset form
                if (isEditMode && $('#edit_id').val() == id) {
                    resetForm();
                }
                
                loadHistory();
            } else {
                showAlert('error', response.message || 'هەڵەیەک ڕوویدا');
                // Re-enable the button on error
                $deleteBtn.prop('disabled', false);
                $deleteBtn.html('<i class="fas fa-trash"></i>');
            }
        },
        error: function(xhr) {
            let errorMsg = 'هەڵەی پەیوەندی، تکایە دووبارە هەوڵبدەوە';
            try {
                const response = JSON.parse(xhr.responseText);
                if (response.message) errorMsg = response.message;
            } catch (e) {}
            showAlert('error', errorMsg);
            // Re-enable the button on error
            $deleteBtn.prop('disabled', false);
            $deleteBtn.html('<i class="fas fa-trash"></i>');
        }
    });
}

// ==================== DOCUMENT READY ====================
$(document).ready(function() {
    
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    loadHistory();

    $('#start_date, #end_date').on('change', function() { 
        loadHistory(); 
    });

    $('#amount').on('input', function() {
        let value = $(this).val();
        let numeric = value.replace(/[^0-9]/g, '');
        if (numeric === '') { 
            $(this).val(''); 
            return; 
        }
        $(this).val(formatNumber(numeric));
    });

    $('.quick-amount-btn').on('click', function() {
        $('#amount').val(formatNumber($(this).data('amount'))).focus();
    });

    $('#withdraw-form').on('submit', function(e) {
        e.preventDefault();
        if (isSubmitting) return;

        const amountRaw = $('#amount').val();
        const amount = parseInt(unformatNumber(amountRaw));
        const note = $('#note').val();

        if (!amountRaw || isNaN(amount) || amount < 1) {
            showAlert('error', 'بڕی پارە دەبێت لە ١ زیاتر بێت');
            return;
        }

        isSubmitting = true;
        const $btn = $('#submit-btn');
        const originalText = $btn.html();
        $btn.html('<i class="fas fa-spinner fa-spin ms-2"></i> تکایە چاوەڕێ بکە...').prop('disabled', true);

        const url = isEditMode ? `/withdraw/${$('#edit_id').val()}` : '{{ route("withdraw.store") }}';
        const method = isEditMode ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            type: method,
            data: { amount: amount, note: note || '' },
            success: function(response) {
                if (response.success) {
                    showAlert('success', isEditMode ? 'ڕاکێشانی پارە بە سەرکەوتوویی نوێکرایەوە' : 'پارە بە سەرکەوتوویی ڕاکێشرا');
                    resetForm();
                } else {
                    showAlert('error', response.message || 'هەڵەیەک ڕوویدا');
                }
            },
            error: function(xhr) {
                let errorMsg = 'هەڵەی پەیوەندی، تکایە دووبارە هەوڵبدەوە';
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.message) errorMsg = response.message;
                    if (response.errors) errorMsg = Object.values(response.errors).flat().join('، ');
                } catch (e) {}
                showAlert('error', errorMsg);
            },
            complete: function() {
                isSubmitting = false;
                $btn.html(originalText).prop('disabled', false);
            }
        });
    });
});
</script>
@endsection