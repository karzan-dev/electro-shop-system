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

    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
        background: var(--bg-body);
        font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
        color: var(--text);
        transition: background-color 0.3s ease, color 0.3s ease;
        min-height: 100vh;
        line-height: 1.6;
    }

    #alert-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        width: 400px;
        max-width: calc(100vw - 40px);
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
        word-wrap: break-word;
    }

    @keyframes slideInRight {
        from { transform: translateX(100%); opacity: 0; }
        to   { transform: translateX(0);    opacity: 1; }
    }

    @keyframes fadeOut {
        from { opacity: 1; }
        to   { opacity: 0; }
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

    @media (max-width: 576px) {
        #alert-container { top: 10px; right: 10px; left: 10px; width: auto; max-width: none; }
        .alert-toast { padding: 12px 14px; font-size: 0.85rem; }
    }

    .main-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 32px 24px;
    }

    @media (max-width: 768px) { .main-container { padding: 16px 12px; } }
    @media (max-width: 480px) { .main-container { padding: 12px 10px; } }

    /* ============================================
       STATS GRID — 6 cards
       ============================================ */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 18px;
        margin-bottom: 40px;
    }

    @media (max-width: 768px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; margin-bottom: 24px; }
    }

    @media (max-width: 480px) {
        .stats-grid { gap: 10px; }
    }

    .stat-card {
        background: var(--bg-white);
        backdrop-filter: blur(10px);
        border-radius: var(--radius-lg);
        padding: 20px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-color);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        cursor: default;
    }

    @media (max-width: 768px) { .stat-card { padding: 14px 12px; } }
    @media (max-width: 480px) { .stat-card { padding: 12px 10px; } }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 4px;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-xl);
    }

    @media (max-width: 768px) { .stat-card:hover { transform: none; } }

    .stat-card:nth-child(1)::before { background: linear-gradient(90deg, #3b82f6, #60a5fa); }
    .stat-card:nth-child(2)::before { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
    .stat-card:nth-child(3)::before { background: linear-gradient(90deg, #10b981, #34d399); }
    .stat-card:nth-child(4)::before { background: linear-gradient(90deg, #8b5cf6, #a78bfa); }
    .stat-card:nth-child(5)::before { background: linear-gradient(90deg, #ef4444, #f87171); }
    .stat-card:nth-child(6)::before { background: linear-gradient(90deg, #6366f1, #818cf8); }

    .stat-icon {
        width: 44px;
        height: 44px;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        margin-bottom: 12px;
    }

    @media (max-width: 768px) {
        .stat-icon { width: 36px; height: 36px; font-size: 1rem; margin-bottom: 8px; border-radius: 10px; }
    }

    .stat-icon.casher    { background: var(--casher-light);   color: var(--casher); }
    .stat-icon.discount  { background: var(--discount-light); color: var(--discount); }
    .stat-icon.before    { background: var(--before-light);   color: var(--before); }
    .stat-icon.after     { background: var(--after-light);    color: var(--after); }
    .stat-icon.danger    { background: var(--danger-light);   color: var(--danger); }
    .stat-icon.indigo    { background: rgba(99,102,241,0.15); color: #6366f1; }

    .stat-label {
        font-size: 0.8rem;
        color: var(--text-secondary);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 6px;
    }

    @media (max-width: 768px) {
        .stat-label { font-size: 0.68rem; margin-bottom: 4px; letter-spacing: 0; }
    }

    .stat-value {
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--text);
        line-height: 1.2;
        font-family: 'Courier New', monospace;
        word-break: break-word;
    }

    @media (max-width: 768px) { .stat-value { font-size: 1rem; } }
    @media (max-width: 480px) { .stat-value { font-size: 0.9rem; } }

    .stat-sub {
        font-size: 0.7rem;
        color: var(--text-muted);
        margin-top: 4px;
    }

    .content-wrapper {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        align-items: start;
    }

    @media (max-width: 1024px) {
        .content-wrapper { grid-template-columns: 1fr; }
        .withdraw-card { position: static !important; }
    }

    @media (max-width: 768px) { .content-wrapper { gap: 20px; } }

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

    @media (max-width: 768px) { .withdraw-header { padding: 20px; } }
    @media (max-width: 480px) { .withdraw-header { padding: 18px 16px; } }

    .withdraw-header::after {
        content: '';
        position: absolute;
        top: -50%; right: -50%;
        width: 200%; height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 60%);
        animation: pulse 3s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 0.5; }
        50%      { transform: scale(1.1); opacity: 0.8; }
    }

    .withdraw-header.edit-mode {
        background: linear-gradient(135deg, var(--discount) 0%, #fbbf24 100%);
    }

    .withdraw-icon {
        width: 64px; height: 64px;
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

    @media (max-width: 768px) {
        .withdraw-icon { width: 50px; height: 50px; font-size: 1.3rem; margin-bottom: 12px; }
    }

    .withdraw-icon.edit-mode { background: rgba(255, 255, 255, 0.3); }

    .withdraw-title {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 8px;
        position: relative;
        z-index: 1;
    }

    @media (max-width: 768px) { .withdraw-title { font-size: 1.3rem; } }
    @media (max-width: 480px) { .withdraw-title { font-size: 1.15rem; } }

    .withdraw-subtitle {
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.95rem;
        position: relative;
        z-index: 1;
    }

    @media (max-width: 768px) { .withdraw-subtitle { font-size: 0.8rem; } }

    .withdraw-body { padding: 32px; }

    @media (max-width: 768px) { .withdraw-body { padding: 20px; } }
    @media (max-width: 480px) { .withdraw-body { padding: 16px; } }

    .form-group { margin-bottom: 24px; }

    @media (max-width: 768px) { .form-group { margin-bottom: 18px; } }

    .form-label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 600;
        color: var(--text);
        margin-bottom: 12px;
        font-size: 0.95rem;
        flex-wrap: wrap;
    }

    @media (max-width: 768px) { .form-label { font-size: 0.85rem; margin-bottom: 8px; } }

    .form-label i { color: var(--casher); font-size: 1rem; }

    .optional-badge {
        background: var(--bg-light);
        color: var(--text-muted);
        font-size: 0.75rem;
        padding: 4px 12px;
        border-radius: 20px;
        font-weight: 500;
        border: 1px solid var(--border-color);
    }

    @media (max-width: 480px) { .optional-badge { font-size: 0.65rem; padding: 3px 8px; } }

    .amount-section {
        background: var(--bg-light);
        border: 2px solid var(--border-color);
        border-radius: var(--radius-md);
        padding: 20px;
        transition: var(--transition);
    }

    @media (max-width: 768px) { .amount-section { padding: 14px; } }

    .amount-section:focus-within {
        border-color: var(--casher);
        background: var(--bg-white);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .amount-section.edit-mode:focus-within {
        border-color: var(--discount);
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
    }

    .amount-input-wrapper { margin-bottom: 16px; }

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

    @media (max-width: 768px) {
        .amount-input { font-size: 1.5rem; padding: 10px 12px; letter-spacing: 1px; }
    }

    @media (max-width: 480px) {
        .amount-input { font-size: 1.25rem; padding: 8px 10px; }
    }

    .amount-input::placeholder { color: var(--text-muted); font-size: 1.5rem; }

    @media (max-width: 768px) { .amount-input::placeholder { font-size: 1.1rem; } }

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

    .currency-badge.edit-mode { background: var(--discount); }

    .quick-amounts {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 8px;
    }

    @media (max-width: 768px) { .quick-amounts { grid-template-columns: repeat(2, 1fr); gap: 6px; } }
    @media (max-width: 480px) { .quick-amounts { grid-template-columns: 1fr 1fr; gap: 5px; } }

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

    @media (max-width: 768px) { .quick-amount-btn { padding: 8px 8px; font-size: 0.75rem; } }

    .quick-amount-btn:hover {
        background: var(--casher-light);
        border-color: var(--casher);
        color: var(--casher);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    @media (max-width: 768px) { .quick-amount-btn:hover { transform: none; } }

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

    @media (max-width: 768px) { .custom-textarea { font-size: 0.85rem; padding: 10px 12px; } }

    .custom-textarea:focus {
        outline: none;
        border-color: var(--casher);
        background: var(--bg-white);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .custom-textarea::placeholder { color: var(--text-muted); }

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

    @media (max-width: 768px) { .submit-btn { font-size: 0.95rem; padding: 14px; } }

    .submit-btn::before {
        content: '';
        position: absolute;
        top: 0; left: -100%;
        width: 100%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s ease;
    }

    .submit-btn:hover::before { left: 100%; }

    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .submit-btn:active { transform: translateY(0); }

    .submit-btn:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }

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

    .cancel-edit-btn.visible { display: flex; }

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

    @media (max-width: 768px) { .history-header { padding: 18px 20px; gap: 10px; } }
    @media (max-width: 480px) { .history-header { padding: 16px 14px; } }

    .history-header i { font-size: 1.25rem; opacity: 0.9; }

    @media (max-width: 768px) { .history-header i { font-size: 1.1rem; } }

    .history-header h2 { font-size: 1.25rem; font-weight: 600; }

    @media (max-width: 768px) { .history-header h2 { font-size: 1rem; } }
    @media (max-width: 480px) { .history-header h2 { font-size: 0.9rem; } }

    .filter-section {
        padding: 20px 32px;
        display: flex;
        gap: 16px;
        background: var(--bg-light);
        border-bottom: 1px solid var(--border-color);
        flex-wrap: wrap;
    }

    @media (max-width: 768px) {
        .filter-section { padding: 14px 16px; flex-direction: column; gap: 10px; }
    }

    .filter-group { flex: 1; min-width: 200px; }

    @media (max-width: 768px) { .filter-group { min-width: 100%; } }

    .filter-group label {
        display: block;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-secondary);
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    @media (max-width: 768px) { .filter-group label { font-size: 0.7rem; margin-bottom: 4px; } }

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

    @media (max-width: 768px) { .filter-input { padding: 9px 12px; font-size: 0.85rem; } }

    .filter-input:focus {
        outline: none;
        border-color: var(--casher);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .history-body { padding: 24px; overflow-x: auto; }

    @media (max-width: 768px) { .history-body { padding: 14px; } }

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

    @media (max-width: 768px) { .withdraw-table tbody td { padding: 10px 8px; } }

    .withdraw-table tbody tr { transition: var(--transition); }
    .withdraw-table tbody tr:hover { background: var(--bg-light); }

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

    .action-cell { display: flex; gap: 8px; }

    .btn-action {
        width: 36px; height: 36px;
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

    .btn-edit:hover { background: var(--casher); color: white; transform: scale(1.1); }

    .btn-delete {
        background: var(--danger-light);
        color: var(--danger);
    }

    .btn-delete:hover { background: var(--danger); color: white; transform: scale(1.1); }

    .btn-action:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }

    .total-section {
        padding: 20px 32px;
        background: var(--bg-light);
        border-top: 2px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    @media (max-width: 768px) { .total-section { padding: 14px 16px; } }

    .total-label { font-weight: 600; color: var(--text); font-size: 1.1rem; }

    @media (max-width: 768px) { .total-label { font-size: 0.9rem; } }

    .total-amount {
        font-weight: 700;
        color: var(--danger);
        font-size: 1.3rem;
        font-family: 'Courier New', monospace;
    }

    @media (max-width: 768px) { .total-amount { font-size: 1rem; } }

    .no-data {
        text-align: center;
        padding: 48px 24px;
        color: var(--text-muted);
    }

    @media (max-width: 768px) { .no-data { padding: 32px 16px; } }

    .no-data i { font-size: 3rem; margin-bottom: 16px; display: block; }

    @media (max-width: 768px) { .no-data i { font-size: 2rem; } }

    .no-data p { font-size: 1rem; }

    @media (max-width: 768px) { .no-data p { font-size: 0.85rem; } }

    ::-webkit-scrollbar { width: 8px; height: 8px; }
    ::-webkit-scrollbar-track { background: var(--bg-light); }
    ::-webkit-scrollbar-thumb { background: var(--text-muted); border-radius: 4px; }
    ::-webkit-scrollbar-thumb:hover { background: var(--text-secondary); }

    /* ============================================
       TABLE TO CARDS - MOBILE
       ============================================ */
    @media (max-width: 768px) {
        .history-body { padding: 12px; overflow-x: visible; }
        .withdraw-table { display: block; font-size: 0.85rem; }
        .withdraw-table thead { display: none; }
        .withdraw-table tbody { display: block; }
        .withdraw-table tbody tr {
            display: block;
            margin-bottom: 12px;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 14px;
            background: var(--bg-white);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }
        body.dark-mode .withdraw-table tbody tr {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        }
        .withdraw-table tbody tr.editing {
            border: 2px solid var(--discount);
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.2);
        }
        .withdraw-table tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid var(--border-color);
            text-align: right;
            gap: 10px;
            font-size: 0.85rem;
        }
        .withdraw-table tbody td:last-child { border-bottom: none; padding-bottom: 0; padding-top: 10px; }
        .withdraw-table tbody td:first-child {
            padding-top: 0;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 8px;
            justify-content: center;
            font-weight: 700;
            color: var(--casher);
        }
        .withdraw-table tbody td::before {
            content: attr(data-label);
            font-weight: 700;
            font-size: 0.75rem;
            color: var(--text-secondary);
            text-transform: uppercase;
            flex-shrink: 0;
            text-align: left;
        }
        .withdraw-table tbody td:first-child::before { content: '#'; color: var(--text-muted); }
        .action-cell { flex-direction: row; justify-content: center; gap: 12px; }
        .action-cell::before { content: 'کردارەکان'; margin-left: auto; }
        .btn-action { width: 40px; height: 40px; font-size: 1rem; }
        .note-cell { max-width: none; text-align: right; white-space: normal; }
    }

    @media (max-width: 480px) {
        .withdraw-table tbody tr { padding: 12px; }
        .withdraw-table tbody td { font-size: 0.8rem; padding: 7px 0; }
        .withdraw-table tbody td::before { font-size: 0.7rem; }
        .btn-action { width: 36px; height: 36px; }
        .amount-cell { font-size: 0.9rem; }
    }

    @media (max-width: 768px) {
        button, .btn, input, select, a, textarea {
            -webkit-tap-highlight-color: transparent;
            touch-action: manipulation;
        }
        .btn:active, button:active { transform: scale(0.98); }
    }
</style>

<div id="alert-container"></div>

<div class="main-container">

    <!-- ============================================
         STATS GRID — 6 cards
         ============================================ -->
    <div class="stats-grid">

        <!-- 1. پارەی ناو قاسە -->
        <div class="stat-card">
            <div class="stat-icon casher"><i class="fas fa-coins"></i></div>
            <div class="stat-label">پارەی ناو قاسە</div>
            <div class="stat-value" id="stat-casher">{{ number_format($cash_in_drawer ?? 0, 0) }} د.ع</div>
        </div>

        <!-- 2. کۆی داشکان -->
        <div class="stat-card">
            <div class="stat-icon discount"><i class="fas fa-tags"></i></div>
            <div class="stat-label">کۆی داشکان</div>
            <div class="stat-value" id="stat-discount">{{ number_format($total_discount ?? 0, 0) }} د.ع</div>
        </div>

        <!-- 3. پارەی کاشێر -->
        <div class="stat-card">
            <div class="stat-icon before"><i class="fas fa-cash-register"></i></div>
            <div class="stat-label">پارەی کاشێر</div>
            <div class="stat-value" id="stat-casher-coin">{{ number_format($total_casher_coin ?? 0, 0) }} د.ع</div>
            <div class="stat-sub">پارەی سەرەتایی</div>
        </div>

        <!-- 4. پارەی قەرزی دراو -->
        <div class="stat-card">
            <div class="stat-icon after"><i class="fas fa-hand-holding-usd"></i></div>
            <div class="stat-label">پارەی قەرزی دراو</div>
            <div class="stat-value" id="stat-loans-currency">{{ number_format($total_loans_currency ?? 0, 0) }} د.ع</div>
            <div class="stat-sub">پارەی وەرگیراو لە قەرزەکان</div>
        </div>

        <!-- 5. پارەی ماوە لە قەرز -->
        <div class="stat-card">
            <div class="stat-icon danger"><i class="fas fa-hourglass-half"></i></div>
            <div class="stat-label">پارەی ماوە لە قەرز</div>
            <div class="stat-value" id="stat-remaining-loans">{{ number_format($remaining_loans ?? 0, 0) }} د.ع</div>
            <div class="stat-sub">هێشتا نەگیراوە لە کڕیار</div>
        </div>

        <!-- 6. کۆی ڕاکێشراو -->
        <div class="stat-card">
            <div class="stat-icon indigo"><i class="fas fa-arrow-down"></i></div>
            <div class="stat-label">کۆی ڕاکێشراو</div>
            <div class="stat-value" id="stat-withdraws">{{ number_format($total_withdraws ?? 0, 0) }} د.ع</div>
            <div class="stat-sub">لە قاسە ڕاکێشراوە</div>
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

function escapeHtml(str) {
    if (!str) return '';
    return String(str).replace(/[&<>"']/g, function(m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        if (m === '"') return '&quot;';
        if (m === "'") return '&#39;';
        return m;
    });
}

// ==================== CONFIRM MODAL ====================
function showConfirmAlert(options) {
    const {
        title = 'پشتڕاستکردنەوە',
        message = '',
        confirmText = 'بەڵێ، بیسڕەوە',
        cancelText = 'پاشگەزبوونەوە',
        onConfirm = null
    } = options;

    const id = 'confirm-' + Date.now();

    const html = `
        <div id="${id}" class="confirm-overlay">
            <div class="confirm-modal">
                <div class="confirm-header">
                    <i class="fas fa-exclamation-triangle"></i>
                    <h3>${escapeHtml(title)}</h3>
                </div>
                <div class="confirm-body">
                    <p>${escapeHtml(message)}</p>
                    <p class="confirm-warning">ئەم کارە ناگەڕێتەوە!</p>
                </div>
                <div class="confirm-footer">
                    <button class="confirm-btn confirm-btn-cancel" data-action="cancel">
                        <i class="fas fa-times"></i> ${escapeHtml(cancelText)}
                    </button>
                    <button class="confirm-btn confirm-btn-danger" data-action="confirm">
                        <i class="fas fa-trash-alt"></i> ${escapeHtml(confirmText)}
                    </button>
                </div>
            </div>
        </div>
    `;

    $('body').append(html);

    setTimeout(() => { $(`#${id}`).addClass('active'); }, 10);

    function close() {
        $(`#${id}`).removeClass('active');
        setTimeout(() => $(`#${id}`).remove(), 300);
    }

    $(`#${id} [data-action="cancel"]`).on('click', function() { close(); });

    $(`#${id} [data-action="confirm"]`).on('click', function() {
        if (typeof onConfirm === 'function') onConfirm();
        close();
    });

    $(`#${id}`).on('click', function(e) {
        if (e.target === this) close();
    });

    const escHandler = function(e) {
        if (e.key === 'Escape') { close(); $(document).off('keydown', escHandler); }
    };
    $(document).on('keydown', escHandler);
}

// ==================== LOAD HISTORY ====================
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
                    $('#stat-casher-coin').text(formatCurrency(response.stats.total_casher_coin || 0));
                    $('#stat-loans-currency').text(formatCurrency(response.stats.total_loans_currency || 0));
                    $('#stat-remaining-loans').text(formatCurrency(response.stats.remaining_loans || 0));
                    $('#stat-withdraws').text(formatCurrency(response.stats.total_withdraws || 0));
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
                            <td data-label="#">${index + 1}</td>
                            <td data-label="بڕی پارە" class="amount-cell">${formatCurrency(item.amount || 0)}</td>
                            <td data-label="پارەی پێش">${formatCurrency(item.cash_before_withdraw || 0)}</td>
                            <td data-label="پارەی دوای">${formatCurrency(item.cash_after_withdraw || 0)}</td>
                            <td data-label="تێبینی" class="note-cell">${item.note || '-'}</td>
                            <td data-label="بەروار" class="date-cell">${item.created_at || ''}</td>
                            <td data-label="کردارەکان" class="action-cell">
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

function cancelEdit() { resetForm(); }

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

// ==================== DELETE ====================
function deleteWithdrawDirect(id) {
    if (!id) { showAlert('error', 'هیچ ڕاکێشانێک دیاری نەکراوە'); return; }

    showConfirmAlert({
        title: 'سڕینەوەی ڕاکێشانی پارە',
        message: 'ئایا دڵنیایت کە دەتەوێت ئەم ڕاکێشانە بسڕیتەوە؟',
        confirmText: 'بەڵێ، بیسڕەوە',
        cancelText: 'پاشگەزبوونەوە',
        onConfirm: function() { performDelete(id); }
    });
}

function performDelete(id) {
    const $deleteBtn = $(`#row-${id} .btn-delete`);
    $deleteBtn.prop('disabled', true);
    $deleteBtn.html('<i class="fas fa-spinner fa-spin"></i>');

    $.ajax({
        url: `/withdraw/${id}`,
        type: 'DELETE',
        data: { _token: $('meta[name="csrf-token"]').attr('content') },
        success: function(response) {
            if (response.success) {
                showAlert('success', 'ڕاکێشانی پارە بە سەرکەوتوویی سڕایەوە');

                if (isEditMode && $('#edit_id').val() == id) { resetForm(); }

                loadHistory();
            } else {
                showAlert('error', response.message || 'هەڵەیەک ڕوویدا');
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

    $('#start_date, #end_date').on('change', function() { loadHistory(); });

    $('#amount').on('input', function() {
        let value = $(this).val();
        let numeric = value.replace(/[^0-9]/g, '');
        if (numeric === '') { $(this).val(''); return; }
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

<!-- ============================================
     CONFIRM MODAL STYLES
     ============================================ -->
<style>
    .confirm-overlay {
        display: flex;
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(5px);
        z-index: 99999;
        align-items: center;
        justify-content: center;
        padding: 16px;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }

    .confirm-overlay.active { opacity: 1; visibility: visible; }

    .confirm-modal {
        background: var(--bg-white);
        border-radius: 20px;
        width: 100%;
        max-width: 420px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        animation: confirmSlideIn 0.3s ease;
        overflow: hidden;
    }

    body.dark-mode .confirm-modal { box-shadow: 0 20px 60px rgba(0, 0, 0, 0.6); }

    @keyframes confirmSlideIn {
        from { transform: scale(0.9) translateY(-20px); opacity: 0; }
        to   { transform: scale(1) translateY(0);       opacity: 1; }
    }

    .confirm-header {
        background: linear-gradient(135deg, var(--danger), #dc2626);
        color: white;
        padding: 18px 20px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .confirm-header i { font-size: 1.5rem; }

    .confirm-header h3 { font-size: 1.1rem; font-weight: 700; margin: 0; }

    @media (max-width: 480px) {
        .confirm-header { padding: 14px 16px; }
        .confirm-header i { font-size: 1.2rem; }
        .confirm-header h3 { font-size: 0.95rem; }
    }

    .confirm-body { padding: 24px 20px; text-align: center; }

    @media (max-width: 480px) { .confirm-body { padding: 20px 16px; } }

    .confirm-body p {
        font-size: 0.95rem;
        color: var(--text);
        line-height: 1.6;
        margin-bottom: 8px;
    }

    @media (max-width: 480px) { .confirm-body p { font-size: 0.85rem; } }

    .confirm-warning {
        color: var(--danger) !important;
        font-weight: 600;
        font-size: 0.85rem !important;
    }

    .confirm-footer {
        padding: 16px 20px;
        display: flex;
        gap: 10px;
        background: var(--bg-light);
        border-top: 1px solid var(--border-color);
    }

    @media (max-width: 480px) {
        .confirm-footer { padding: 12px 16px; flex-direction: column; gap: 8px; }
    }

    .confirm-btn {
        flex: 1;
        padding: 12px 20px;
        border: none;
        border-radius: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-size: 0.9rem;
    }

    .confirm-btn:active { transform: scale(0.97); }

    .confirm-btn-cancel {
        background: var(--bg-white);
        color: var(--text-secondary);
        border: 2px solid var(--border-color);
    }

    .confirm-btn-cancel:hover { background: var(--border-color); color: var(--text); }

    .confirm-btn-danger {
        background: linear-gradient(135deg, var(--danger), #dc2626);
        color: white;
    }

    .confirm-btn-danger:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
    }
</style>
@endsection