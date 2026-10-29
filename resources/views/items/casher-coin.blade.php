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
        --return: #8b5cf6;
        --text: #1e293b;
        --border-color: #e2e8f0;
        --bg-light: #f8fafc;
        --transition-base: all 0.3s ease;
        --card-bg: #ffffff;
    }

    body {
        background: #f1f5f9;
        font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
        transition: background-color 0.3s ease, color 0.2s ease;
        color: var(--text);
    }

    body.dark-mode {
        background: #0f172a;
        --text: #e2e8f0;
        --border-color: #334155;
        --bg-light: #1e293b;
        --primary: #6c8db8;
        --card-bg: #1e293b;
        color: #e2e8f0;
    }

    * { box-sizing: border-box; }

    /* ========== CUSTOM CONFIRMATION MODAL ========== */
    .custom-confirm-overlay {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0, 0, 0, 0.7);
        z-index: 99999;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: fadeInOverlay 0.3s ease;
        backdrop-filter: blur(4px);
        padding: 16px;
    }

    @keyframes fadeInOverlay { from { opacity: 0; } to { opacity: 1; } }

    .custom-confirm-dialog {
        background: white;
        border-radius: 24px;
        padding: 2rem;
        max-width: 450px;
        width: 100%;
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.3);
        animation: slideUpDialog 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        text-align: center;
        direction: rtl;
        max-height: 92vh;
        overflow-y: auto;
    }

    body.dark-mode .custom-confirm-dialog {
        background: #1e293b;
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.5);
    }

    @keyframes slideUpDialog {
        from { opacity: 0; transform: translateY(30px) scale(0.95); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }

    .confirm-icon-wrapper {
        width: 80px; height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.25rem;
        animation: bounceIcon 0.6s ease 0.2s both;
    }

    body.dark-mode .confirm-icon-wrapper {
        background: linear-gradient(135deg, #78350f, #92400e);
    }

    @keyframes bounceIcon {
        0% { transform: scale(0); }
        50% { transform: scale(1.2); }
        100% { transform: scale(1); }
    }

    .confirm-icon-wrapper i {
        font-size: 2.5rem;
        color: #f59e0b;
        animation: pulseIcon 1.5s ease-in-out infinite;
    }

    body.dark-mode .confirm-icon-wrapper i { color: #fbbf24; }

    @keyframes pulseIcon {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }

    .confirm-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.75rem;
    }

    body.dark-mode .confirm-title { color: #e2e8f0; }

    .confirm-message {
        font-size: 0.95rem;
        color: #64748b;
        line-height: 1.6;
        margin-bottom: 0.5rem;
    }

    body.dark-mode .confirm-message { color: #94a3b8; }

    .confirm-highlight {
        display: inline-block;
        background: linear-gradient(135deg, #4a6491, #5d7ab0);
        color: white;
        padding: 0.4rem 1rem;
        border-radius: 30px;
        font-weight: 700;
        font-size: 1.1rem;
        margin: 0.5rem 0;
        box-shadow: 0 4px 15px rgba(74, 100, 145, 0.3);
    }

    body.dark-mode .confirm-highlight {
        background: linear-gradient(135deg, #6c8db8, #5d7ab0);
        box-shadow: 0 4px 15px rgba(108, 141, 184, 0.4);
    }

    .confirm-detail {
        font-size: 0.85rem;
        color: #94a3b8;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    body.dark-mode .confirm-detail { color: #64748b; }

    .confirm-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        justify-content: center;
    }

    .btn-confirm-cancel {
        flex: 1;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        border: 2px solid #e2e8f0;
        background: white;
        color: #64748b;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    body.dark-mode .btn-confirm-cancel {
        background: #0f172a;
        border-color: #334155;
        color: #94a3b8;
    }

    .btn-confirm-cancel:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
        transform: translateY(-2px);
    }

    body.dark-mode .btn-confirm-cancel:hover {
        background: #334155;
        border-color: #475569;
    }

    .btn-confirm-ok {
        flex: 1;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        border: none;
        background: linear-gradient(135deg, #4a6491, #5d7ab0);
        color: white;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(74, 100, 145, 0.3);
    }

    .btn-confirm-ok:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(74, 100, 145, 0.4);
        background: linear-gradient(135deg, #5d7ab0, #4a6491);
    }

    body.dark-mode .btn-confirm-ok {
        background: linear-gradient(135deg, #6c8db8, #5d7ab0);
    }

    .btn-confirm-ok:active,
    .btn-confirm-cancel:active { transform: scale(0.97); }

    /* ========== AUTOSAVE INDICATOR ========== */
    .autosave-indicator {
        position: fixed;
        bottom: 100px;
        left: 30px;
        background: rgba(16, 185, 129, 0.95);
        color: white;
        padding: 8px 16px;
        border-radius: 30px;
        font-size: 0.8rem;
        z-index: 1000;
        display: none;
        animation: fadeInUp 0.3s ease;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }

    body.dark-mode .autosave-indicator {
        background: rgba(16, 185, 129, 0.9);
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
    }

    .autosave-indicator.show { display: block; }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* ========== FORM ========== */
    .form-header-custom {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border-radius: 0.75rem 0.75rem 0 0 !important;
    }

    .form-logo-custom {
        background-color: white;
        width: 80px; height: 80px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        transition: background-color 0.3s ease;
    }

    body.dark-mode .form-logo-custom { background-color: #334155; }

    .form-logo-custom i {
        font-size: 2.5rem;
        background: linear-gradient(135deg, var(--primary), var(--accent));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .section-title-custom {
        font-size: 1rem;
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid var(--secondary);
        transition: color 0.3s ease, border-color 0.3s ease;
    }

    body.dark-mode .section-title-custom { border-bottom-color: #334155; }

    .casher-select-card {
        background: linear-gradient(135deg, rgba(74, 100, 145, 0.05), rgba(192, 132, 252, 0.05));
        border-radius: 16px;
        padding: 1.25rem;
        border: 1px solid rgba(74, 100, 145, 0.2);
        transition: background 0.3s ease, border-color 0.3s ease;
    }

    body.dark-mode .casher-select-card {
        background: linear-gradient(135deg, rgba(108, 141, 184, 0.1), rgba(192, 132, 252, 0.05));
        border-color: rgba(108, 141, 184, 0.3);
    }

    .casher-select-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 0.5rem;
        display: block;
    }

    .casher-select-wrapper { position: relative; }

    .casher-select-wrapper i {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--primary);
        z-index: 4;
        font-size: 1rem;
    }

    .casher-select {
        width: 100%;
        padding: 0.875rem 2.5rem 0.875rem 1rem;
        border: 2px solid rgba(74, 100, 145, 0.2);
        border-radius: 12px;
        font-size: 1rem;
        background: white;
        transition: all 0.3s ease;
        appearance: none;
        cursor: pointer;
        color: #1e293b;
    }

    body.dark-mode .casher-select {
        background: #0f172a;
        border-color: #334155;
        color: #e2e8f0;
    }

    body.dark-mode .casher-select option {
        background: #1e293b;
        color: #e2e8f0;
    }

    .casher-select:focus {
        border-color: var(--primary);
        outline: none;
        box-shadow: 0 0 0 3px rgba(74, 100, 145, 0.1);
    }

    .amount-card {
        background: white;
        border-radius: 20px;
        padding: 1.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(74, 100, 145, 0.1);
        transition: background-color 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
    }

    body.dark-mode .amount-card {
        background: #1e293b;
        border-color: #334155;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .amount-input-wrapper { position: relative; margin-bottom: 1rem; }

    .amount-input {
        width: 100%;
        padding: 1rem 1rem 1rem 4rem;
        font-size: 2rem;
        font-weight: 700;
        text-align: center;
        border: 2px solid rgba(74, 100, 145, 0.2);
        border-radius: 16px;
        background: white;
        transition: all 0.3s ease;
        color: var(--primary);
    }

    body.dark-mode .amount-input {
        background: #0f172a;
        border-color: #334155;
        color: #6c8db8;
    }

    .amount-input:focus {
        border-color: var(--primary);
        outline: none;
        box-shadow: 0 0 0 4px rgba(74, 100, 145, 0.1);
    }

    body.dark-mode .amount-input:focus {
        box-shadow: 0 0 0 4px rgba(108, 141, 184, 0.2);
    }

    .amount-input::placeholder { color: #cbd5e1; font-size: 1rem; }
    body.dark-mode .amount-input::placeholder { color: #475569; }

    .amount-currency {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        font-size: 0.875rem;
        color: var(--primary);
        font-weight: 500;
        background: rgba(74, 100, 145, 0.1);
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        transition: background 0.3s ease;
    }

    body.dark-mode .amount-currency { background: rgba(108, 141, 184, 0.2); }

    .amount-hint {
        font-size: 0.75rem;
        color: #94a3b8;
        text-align: center;
        margin-top: 0.5rem;
    }

    body.dark-mode .amount-hint { color: #64748b; }
    .amount-hint i { font-size: 0.7rem; margin-left: 0.25rem; }

    .quick-amounts {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
        justify-content: center;
        margin-top: 1rem;
    }

    .quick-amount-btn {
        background: rgba(74, 100, 145, 0.1);
        border: 1px solid rgba(74, 100, 145, 0.2);
        padding: 0.5rem 1rem;
        border-radius: 40px;
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--primary);
        transition: all 0.3s ease;
        cursor: pointer;
    }

    body.dark-mode .quick-amount-btn {
        background: rgba(108, 141, 184, 0.15);
        border-color: rgba(108, 141, 184, 0.3);
    }

    .quick-amount-btn:hover {
        background: var(--primary);
        color: white;
        transform: translateY(-2px);
    }

    .submit-btn {
        width: 100%;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border: none;
        color: white;
        padding: 1rem;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 16px;
        transition: all 0.3s ease;
        margin-top: 1rem;
    }

    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(74, 100, 145, 0.3);
    }

    body.dark-mode .submit-btn:hover {
        box-shadow: 0 10px 25px rgba(108, 141, 184, 0.4);
    }

    .submit-btn:disabled { opacity: 0.7; transform: none; }

    .casher-info {
        background: rgba(74, 100, 145, 0.05);
        border-radius: 12px;
        padding: 1rem;
        margin-top: 1rem;
        display: none;
        transition: background 0.3s ease;
    }

    body.dark-mode .casher-info { background: rgba(108, 141, 184, 0.1); }

    .casher-info.show {
        display: block;
        animation: fadeIn 0.3s ease;
    }

    .casher-info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0;
        border-bottom: 1px solid rgba(74, 100, 145, 0.1);
    }

    body.dark-mode .casher-info-item {
        border-bottom-color: rgba(108, 141, 184, 0.2);
    }

    .casher-info-item:last-child { border-bottom: none; }

    .casher-info-label {
        font-size: 0.8rem;
        color: #64748b;
    }

    body.dark-mode .casher-info-label { color: #94a3b8; }

    .casher-info-value {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--primary);
    }

    body.dark-mode .card {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }

    body.dark-mode .card-header {
        background: linear-gradient(135deg, #4a6491, #2c3e50) !important;
    }

    body.dark-mode .card-body { color: #e2e8f0; }

    .custom-alert {
        border-radius: 12px;
        border: none;
        padding: 12px 16px;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        animation: slideDown 0.3s ease-out;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .alert-success-custom { background: rgba(16, 185, 129, 0.95); color: white; }
    .alert-error-custom { background: rgba(239, 68, 68, 0.95); color: white; }
    .alert-warning-custom { background: rgba(245, 158, 11, 0.95); color: white; }
    .alert-info-custom { background: rgba(59, 130, 246, 0.95); color: white; }

    body.dark-mode .alert-success-custom { background: rgba(16, 185, 129, 0.9); }
    body.dark-mode .alert-error-custom { background: rgba(239, 68, 68, 0.9); }
    body.dark-mode .alert-warning-custom { background: rgba(245, 158, 11, 0.9); }
    body.dark-mode .alert-info-custom { background: rgba(59, 130, 246, 0.9); }

    .alert-icon { font-size: 1.2rem; margin-left: 12px; }
    .alert-content { flex: 1; }
    .alert-message { font-size: 0.875rem; }

    .alert-close {
        background: none;
        border: none;
        color: white;
        opacity: 0.7;
        cursor: pointer;
        font-size: 1.1rem;
        padding: 0;
        margin-right: 10px;
    }

    .alert-close:hover { opacity: 1; }

    .validation-error {
        color: var(--danger);
        font-size: 0.75rem;
        margin-top: 0.25rem;
        display: none;
    }

    .is-invalid { border-color: var(--danger) !important; }

    body.dark-mode .text-white { color: #e2e8f0 !important; }
    body.dark-mode .opacity-75 { opacity: 0.85 !important; }
    body.dark-mode .small { color: #94a3b8 !important; }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-5px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* ========== HISTORY TABLE ========== */
    .history-section {
        margin-top: 2rem;
        background: white;
        border-radius: 20px;
        padding: 1.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(74, 100, 145, 0.1);
        transition: background-color 0.3s ease, border-color 0.3s ease;
    }

    body.dark-mode .history-section {
        background: #1e293b;
        border-color: #334155;
    }

    .history-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .history-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--primary);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin: 0;
    }

    .history-summary {
        font-size: 0.85rem;
        color: #64748b;
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    body.dark-mode .history-summary { color: #94a3b8; }
    .history-summary strong { color: var(--primary); }

    .table-responsive { border-radius: 12px; overflow: hidden; }

    .history-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.875rem;
        background: white;
    }

    body.dark-mode .history-table { background: #0f172a; }

    .history-table thead {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
    }

    .history-table thead th {
        padding: 0.875rem 1rem;
        text-align: right;
        font-weight: 600;
        font-size: 0.8rem;
        white-space: nowrap;
        border: none;
    }

    .history-table tbody tr {
        border-bottom: 1px solid rgba(74, 100, 145, 0.08);
        transition: background-color 0.2s ease;
    }

    body.dark-mode .history-table tbody tr {
        border-bottom-color: rgba(108, 141, 184, 0.15);
    }

    .history-table tbody tr:hover {
        background: rgba(74, 100, 145, 0.05);
    }

    body.dark-mode .history-table tbody tr:hover {
        background: rgba(108, 141, 184, 0.1);
    }

    .history-table tbody td {
        padding: 0.75rem 1rem;
        color: #334155;
        vertical-align: middle;
        white-space: nowrap;
    }

    body.dark-mode .history-table tbody td { color: #cbd5e1; }

    .history-table tbody td.amount-cell {
        font-weight: 700;
        color: var(--primary);
        font-size: 0.95rem;
    }

    .badge-row {
        display: inline-block;
        background: rgba(74, 100, 145, 0.1);
        color: var(--primary);
        padding: 0.2rem 0.6rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    body.dark-mode .badge-row { background: rgba(108, 141, 184, 0.2); }

    .badge-casher {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        background: linear-gradient(135deg, rgba(74, 100, 145, 0.12), rgba(192, 132, 252, 0.12));
        color: var(--primary);
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    body.dark-mode .badge-casher {
        background: linear-gradient(135deg, rgba(108, 141, 184, 0.2), rgba(192, 132, 252, 0.15));
    }

    .empty-state {
        text-align: center;
        padding: 2.5rem 1rem;
        color: #94a3b8;
    }

    .empty-state i {
        font-size: 3rem;
        opacity: 0.4;
        margin-bottom: 0.75rem;
        display: block;
    }

    .empty-state p { margin: 0; font-size: 0.9rem; }

    .loading-row td {
        text-align: center;
        padding: 2rem;
        color: #94a3b8;
    }

    /* ========== ACTION BUTTONS ========== */
    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.35rem;
        padding: 0.4rem 0.75rem;
        border-radius: 10px;
        border: none;
        font-size: 0.78rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.25s ease;
        white-space: nowrap;
        line-height: 1;
    }

    .action-btn i { font-size: 0.75rem; }

    .action-btn-edit {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white;
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.25);
    }

    .action-btn-edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(59, 130, 246, 0.4);
    }

    .action-btn-delete {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.25);
    }

    .action-btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(239, 68, 68, 0.4);
    }

    .action-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none !important;
        box-shadow: none !important;
    }

    .action-group {
        display: flex;
        gap: 0.4rem;
        justify-content: center;
        align-items: center;
    }

    /* ========== EDIT MODAL ========== */
    .edit-modal-input {
        width: 100%;
        padding: 0.875rem 1rem;
        font-size: 1.5rem;
        font-weight: 700;
        text-align: center;
        border: 2px solid rgba(74, 100, 145, 0.2);
        border-radius: 12px;
        background: white;
        color: var(--primary);
        transition: all 0.3s ease;
        margin-top: 0.5rem;
    }

    body.dark-mode .edit-modal-input {
        background: #0f172a;
        border-color: #334155;
        color: #6c8db8;
    }

    .edit-modal-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(74, 100, 145, 0.1);
    }

    .edit-modal-actions {
        display: flex;
        gap: 0.75rem;
        margin-top: 1.5rem;
        justify-content: center;
    }

    .edit-modal-actions .btn-confirm-cancel,
    .edit-modal-actions .btn-confirm-ok {
        flex: 1;
    }

    .confirm-icon-wrapper.delete-icon {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
    }

    body.dark-mode .confirm-icon-wrapper.delete-icon {
        background: linear-gradient(135deg, #7f1d1d, #991b1b);
    }

    .confirm-icon-wrapper.delete-icon i { color: #ef4444; }
    body.dark-mode .confirm-icon-wrapper.delete-icon i { color: #fca5a5; }

    .confirm-highlight.delete-highlight {
        background: linear-gradient(135deg, #ef4444, #dc2626);
    }

    /* ============================================
       MOBILE RESPONSIVE - TABLE TO CARDS
       ============================================ */
    @media (max-width: 768px) {
        .amount-input {
            font-size: 1.5rem;
            padding: 0.875rem 1rem 0.875rem 3.5rem;
        }

        .quick-amounts { gap: 0.5rem; }

        .quick-amount-btn {
            padding: 0.4rem 0.75rem;
            font-size: 0.75rem;
        }

        .custom-confirm-dialog { padding: 1.5rem; }

        .confirm-actions {
            flex-direction: column;
            gap: 0.75rem;
        }

        .autosave-indicator {
            bottom: 80px;
            left: 15px;
            font-size: 0.7rem;
            padding: 6px 12px;
        }

        .history-section { padding: 1rem; }

        .action-btn {
            padding: 0.5rem 0.75rem;
            font-size: 0.75rem;
            width: 100%;
            justify-content: center;
        }

        /* ============================================
           HISTORY TABLE → CARDS
           ============================================ */
        .table-responsive {
            overflow-x: visible !important;
            border-radius: 0 !important;
            background: transparent !important;
        }

        .history-table {
            display: block;
            width: 100%;
            white-space: normal;
            background: transparent;
        }

        .history-table thead {
            display: none !important;
        }

        .history-table tbody {
            display: block;
            width: 100%;
            background: transparent;
        }

        /* هەر ڕیزێک = کارتێک */
        .history-table tbody tr {
            display: block;
            margin-bottom: 14px;
            border: 1px solid rgba(74, 100, 145, 0.15);
            border-radius: 16px;
            padding: 14px;
            background: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
        }

        body.dark-mode .history-table tbody tr {
            background: #0f172a;
            border-color: #334155;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        }

        .history-table tbody tr:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            background: white !important;
        }

        body.dark-mode .history-table tbody tr:hover {
            background: #0f172a !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
        }

        /* هەر خانەیەک = ڕیزێک لە کارت */
        .history-table tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0 !important;
            border: none !important;
            border-bottom: 1px solid rgba(74, 100, 145, 0.08) !important;
            text-align: right;
            gap: 10px;
            font-size: 0.85rem;
            background: transparent !important;
            color: #334155;
            white-space: normal;
        }

        body.dark-mode .history-table tbody td {
            border-bottom-color: rgba(108, 141, 184, 0.15) !important;
            color: #cbd5e1;
        }

        .history-table tbody td:last-child {
            border-bottom: none !important;
            padding-top: 12px !important;
            margin-top: 8px;
            border-top: 1px solid rgba(74, 100, 145, 0.1) !important;
            justify-content: center;
        }

        body.dark-mode .history-table tbody td:last-child {
            border-top-color: rgba(108, 141, 184, 0.2) !important;
        }

        /* ناوی خانەکان */
        .history-table tbody td::before {
            content: attr(data-label);
            font-weight: 700;
            font-size: 0.72rem;
            color: var(--primary);
            text-transform: uppercase;
            flex-shrink: 0;
            text-align: left;
            letter-spacing: 0.3px;
        }

        body.dark-mode .history-table tbody td::before {
            color: #6c8db8;
        }

        .history-table tbody td:last-child::before {
            display: none;
        }

        /* خانەی # ون دەبێت لە مۆبایل */
        .history-table tbody td[data-label="#"] {
            display: none;
        }

        /* ناوی کاشێر لە سەرەوەی کارت */
        .history-table tbody td[data-label="ناوی کاشێر"] {
            font-size: 1rem;
            font-weight: 700;
            color: var(--primary);
            border-bottom: 2px solid rgba(74, 100, 145, 0.15) !important;
            padding-bottom: 12px !important;
            padding-top: 0 !important;
            justify-content: center;
            text-align: center;
            margin-bottom: 8px;
        }

        body.dark-mode .history-table tbody td[data-label="ناوی کاشێر"] {
            color: #93c5fd;
            border-bottom-color: #334155 !important;
        }

        .history-table tbody td[data-label="ناوی کاشێر"]::before {
            display: none;
        }

        /* بڕی وردە */
        .history-table tbody td.amount-cell {
            font-size: 0.95rem;
            font-weight: 700;
        }

        /* گروپی کردارەکان */
        .action-group {
            flex-direction: row;
            gap: 8px;
            width: 100%;
        }

        .action-group .action-btn {
            flex: 1;
        }

        /* Empty state */
        .history-table tbody tr:has(.empty-state) {
            padding: 0;
            border: none;
            box-shadow: none;
            background: transparent;
        }

        .empty-state {
            padding: 2rem 1rem;
        }

        .empty-state i {
            font-size: 2.5rem;
        }

        /* Loading row */
        .history-table tbody tr:has(.loading-row),
        .loading-row {
            display: block;
        }

        .loading-row td {
            display: block;
            text-align: center;
            padding: 2rem 1rem !important;
        }

        .loading-row td::before {
            display: none;
        }

        /* Header adjustments */
        .history-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }

        .history-title {
            font-size: 1rem;
        }

        .history-summary {
            font-size: 0.8rem;
            width: 100%;
            justify-content: space-between;
        }
    }

    @media (max-width: 480px) {
        .history-table tbody td {
            font-size: 0.8rem;
            padding: 8px 0 !important;
        }

        .history-table tbody td::before {
            font-size: 0.68rem;
        }

        .history-table tbody td[data-label="ناوی کاشێر"] {
            font-size: 0.95rem;
        }

        .action-btn {
            padding: 0.45rem 0.6rem;
            font-size: 0.7rem;
        }

        .action-btn i {
            font-size: 0.7rem;
        }

        .badge-casher {
            font-size: 0.75rem;
            padding: 0.2rem 0.6rem;
        }
    }

    /* iOS Zoom Prevention */
    @media (max-width: 576px) {
        input, select, textarea {
            font-size: 16px !important;
        }
    }

    /* Touch Optimizations */
    @media (max-width: 768px) {
        button, .btn, input, select, a {
            -webkit-tap-highlight-color: transparent;
            touch-action: manipulation;
        }

        .btn:active, button:active {
            transform: scale(0.98);
        }
    }
</style>

<!-- Alert Container -->
<div id="alert-container" style="position: fixed; top: 20px; right: 20px; z-index: 99999; width: 320px; max-width: calc(100% - 40px);"></div>

<!-- Autosave Indicator -->

<!-- CONFIRM PAYMENT OVERLAY -->
<div id="custom-confirm-overlay" class="custom-confirm-overlay" style="display: none;">
    <div class="custom-confirm-dialog">
        <div class="confirm-icon-wrapper">
            <i class="fas fa-coins"></i>
        </div>
        <h3 class="confirm-title">پشتڕاستکردنەوەی پێدانی وردە</h3>
        <p class="confirm-message">دڵنیایت کە دەتەوێت</p>
        <div class="confirm-highlight" id="confirm-amount-display">0 دینار</div>
        <p class="confirm-message">وردە بدەیت بە</p>
        <div class="confirm-detail">
            <i class="fas fa-user-circle"></i>
            <strong id="confirm-casher-name">-</strong>
        </div>
        <p class="confirm-message" style="margin-top: 1rem; font-size: 0.8rem; color: #94a3b8;">
            <i class="fas fa-info-circle ms-1"></i>
            ئەم کردارە هەڵنەگەڕێتەوە
        </p>
        <div class="confirm-actions">
            <button class="btn-confirm-cancel" id="confirm-btn-cancel">
                <i class="fas fa-times ms-2"></i>
                پەشیمان بوومەوە
            </button>
            <button class="btn-confirm-ok" id="confirm-btn-ok">
                <i class="fas fa-check ms-2"></i>
                بەڵێ، پێبدە
            </button>
        </div>
    </div>
</div>

<!-- EDIT MODAL -->
<div id="edit-modal-overlay" class="custom-confirm-overlay" style="display: none;">
    <div class="custom-confirm-dialog">
        <div class="confirm-icon-wrapper">
            <i class="fas fa-edit"></i>
        </div>
        <h3 class="confirm-title">دەستکاریکردنی بڕی وردە</h3>
        <p class="confirm-message">
            بڕی نوێ بنووسە بۆ
            <strong id="edit-casher-name" style="color: var(--primary);">-</strong>
        </p>
        <input type="text"
               id="edit-amount-input"
               class="edit-modal-input"
               placeholder="بڕی نوێ"
               autocomplete="off">
        <div class="validation-error" id="edit-amount-error"
             style="text-align: center; margin-top: 0.5rem;"></div>
        <div class="edit-modal-actions">
            <button class="btn-confirm-cancel" id="edit-btn-cancel">
                <i class="fas fa-times ms-2"></i>
                پەشیمان بوومەوە
            </button>
            <button class="btn-confirm-ok" id="edit-btn-save">
                <i class="fas fa-save ms-2"></i>
                پاشەکەوتکردن
            </button>
        </div>
    </div>
</div>

<!-- DELETE CONFIRMATION MODAL -->
<div id="delete-modal-overlay" class="custom-confirm-overlay" style="display: none;">
    <div class="custom-confirm-dialog">
        <div class="confirm-icon-wrapper delete-icon">
            <i class="fas fa-trash-alt"></i>
        </div>
        <h3 class="confirm-title">سڕینەوەی وردە</h3>
        <p class="confirm-message">دڵنیایت کە دەتەوێت ئەم وردەیە بسڕیتەوە؟</p>
        <div class="confirm-highlight delete-highlight" id="delete-amount-display">0 دینار</div>
        <div class="confirm-detail">
            <i class="fas fa-user-circle"></i>
            <strong id="delete-casher-name">-</strong>
        </div>
        <p class="confirm-message" style="margin-top: 1rem; font-size: 0.8rem; color: #ef4444;">
            <i class="fas fa-exclamation-triangle ms-1"></i>
            ئەم کردارە هەڵنەگەڕێتەوە!
        </p>
        <div class="confirm-actions">
            <button class="btn-confirm-cancel" id="delete-btn-cancel">
                <i class="fas fa-times ms-2"></i>
                پەشیمان بوومەوە
            </button>
            <button class="btn-confirm-ok"
                    id="delete-btn-confirm"
                    style="background: linear-gradient(135deg, #ef4444, #dc2626);">
                <i class="fas fa-trash ms-2"></i>
                بەڵێ، بسڕەوە
            </button>
        </div>
    </div>
</div>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-11">
            <div class="card shadow-lg border-0 overflow-hidden">
                <div class="card-header form-header-custom text-white text-center py-4">
                    <div class="form-logo-custom">
                        <i class="fas fa-hand-holding-usd"></i>
                    </div>
                    <h1 class="h3 mb-1">پێدانی وردە بە کاشێر</h1>
                    <p class="mb-0 small opacity-75">دابینکردنی وردە بۆ کاشێرەکان بۆ کارکردنی ڕۆژانە</p>
                </div>

                <div class="card-body p-4">
                    <form id="coin-form" method="POST">
                        @csrf

                        <div class="mb-4">
                            <div class="casher-select-card">
                                <label class="casher-select-label">
                                    <i class="fas fa-user-tie ms-1"></i>ناوی کاشێر
                                </label>
                                <div class="casher-select-wrapper">
                                    <i class="fas fa-chevron-down"></i>
                                    <select id="casher-select" name="casher_id" class="casher-select" required>
                                        <option value="">هەڵبژێرە</option>
                                    </select>
                                </div>
                                <div class="validation-error" id="casher-error"></div>


                            </div>
                        </div>

                        <div class="amount-card">
                            <div class="section-title-custom">
                                <i class="fas fa-dollar-sign ms-2"></i>بڕی ووردە
                            </div>

                            <div class="amount-input-wrapper">
                                <input type="text"
                                       id="amount"
                                       name="amount"
                                       class="amount-input"
                                       placeholder="بڕەکە بنووسە"
                                       autocomplete="off">
                                <span class="amount-currency">IQD</span>
                            </div>

                            <div class="amount-hint">
                                <i class="fas fa-info-circle"></i>
                                کەمترین: <strong>1 دینار</strong>
                            </div>
                            <div class="validation-error" id="amount-error"></div>

                            <div class="quick-amounts">
                                <button type="button" class="quick-amount-btn" data-amount="5000">5,000</button>
                                <button type="button" class="quick-amount-btn" data-amount="10000">10,000</button>
                                <button type="button" class="quick-amount-btn" data-amount="25000">25,000</button>
                                <button type="button" class="quick-amount-btn" data-amount="50000">50,000</button>
                            </div>
                        </div>

                        <button type="submit" class="submit-btn" id="submit-btn">
                            <i class="fas fa-hand-holding-usd ms-2"></i>
                            پێدانی وردە
                        </button>
                    </form>
                </div>
            </div>

            <div class="history-section">
                <div class="history-header">
                    <h3 class="history-title">
                        <i class="fas fa-history"></i>
                        مێژووی وردە پێدراوەکان
                    </h3>
                    <div class="history-summary">
                        <span>ژمارە: <strong id="summary-count">0</strong></span>
                        <span>کۆی گشتی: <strong id="summary-total">0</strong> دینار</span>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="history-table" id="history-table">
                        <thead>
                            <tr>
                                <th style="width: 60px;">#</th>
                                <th>ناوی کاشێر</th>
                                <th>ئیمەیڵ</th>
                                <th>بڕی وردە</th>
                                <th>بەروار و کات</th>
                                <th style="width: 170px; text-align: center;">کردارەکان</th>
                            </tr>
                        </thead>
                        <tbody id="history-tbody">
                            <tr class="loading-row">
                                <td colspan="6">
                                    <i class="fas fa-spinner fa-spin ms-2"></i>
                                    چاوەڕوان بە... داتا بار دەکرێت
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    let isSubmitting = false;
    let confirmCallback = null;
    let isRestoring = false;
    let historyData = [];

    const STORAGE_KEY = 'casher_coin_form_data';

    // ============================================
    // HELPERS
    // ============================================
    function formatNumber(value) {
        if (!value && value !== 0) return '';
        return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }

    function unformatNumber(value) {
        return value.toString().replace(/,/g, '');
    }

    function formatDateTime(dateStr) {
        if (!dateStr) return '-';
        const d = new Date(dateStr.replace(' ', 'T'));
        if (isNaN(d.getTime())) return dateStr;
        const pad = n => n.toString().padStart(2, '0');
        return `${d.getFullYear()}-${pad(d.getMonth()+1)}-${pad(d.getDate())} ${pad(d.getHours())}:${pad(d.getMinutes())}`;
    }

    function escapeHtml(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;');
    }

    // ============================================
    // ALERTS
    // ============================================
    function showAlert(type, message, duration = 3000) {
        let icon, alertClass;
        switch(type) {
            case 'success': icon = 'fas fa-check-circle'; alertClass = 'alert-success-custom'; break;
            case 'error':   icon = 'fas fa-exclamation-circle'; alertClass = 'alert-error-custom'; break;
            case 'warning': icon = 'fas fa-exclamation-triangle'; alertClass = 'alert-warning-custom'; break;
            default:        icon = 'fas fa-info-circle'; alertClass = 'alert-info-custom';
        }

        const alertId = 'alert-' + Date.now();
        const alertHtml = `
            <div id="${alertId}" class="custom-alert ${alertClass}">
                <i class="${icon} alert-icon"></i>
                <div class="alert-content">
                    <div class="alert-message">${message}</div>
                </div>
                <button class="alert-close" onclick="$('#${alertId}').fadeOut(300, function() { $(this).remove(); })">×</button>
            </div>
        `;
        $('#alert-container').prepend(alertHtml);
        setTimeout(() => {
            $(`#${alertId}`).fadeOut(300, function() { $(this).remove(); });
        }, duration);
    }

    function clearErrors() {
        $('.validation-error').hide().empty();
        $('.is-invalid').removeClass('is-invalid');
    }

    function showError(field, message) {
        $(`#${field}-error`).text(message).show();
        $(`#${field}`).addClass('is-invalid');
    }

    // ============================================
    // LOCAL STORAGE
    // ============================================
    function saveFormToLocalStorage() {
        if (isRestoring) return;
        try {
            const formData = {
                casher_id: $('#casher-select').val(),
                casher_name: $('#casher-select option:selected').text(),
                amount: $('#amount').val(),
                timestamp: new Date().getTime()
            };
            localStorage.setItem(STORAGE_KEY, JSON.stringify(formData));
            showAutosaveIndicator();
        } catch(e) {
            console.error('Error saving to localStorage:', e);
        }
    }

    function restoreFormFromLocalStorage() {
        const savedData = localStorage.getItem(STORAGE_KEY);
        if (!savedData) return false;
        try {
            isRestoring = true;
            const data = JSON.parse(savedData);
            const now = new Date().getTime();
            const oneDay = 24 * 60 * 60 * 1000;
            if (now - (data.timestamp || 0) > oneDay) {
                clearLocalStorage();
                return false;
            }
            if (data.amount) $('#amount').val(data.amount);
            window._restoredCasherId = data.casher_id || null;
            return true;
        } catch(e) {
            console.error('Error restoring:', e);
            return false;
        } finally {
            setTimeout(() => { isRestoring = false; }, 500);
        }
    }

    function clearLocalStorage() {
        localStorage.removeItem(STORAGE_KEY);
        window._restoredCasherId = null;
    }

    function showAutosaveIndicator() {
        const $indicator = $('#autosave-indicator');
        $indicator.stop(true, true).fadeIn(200);
        setTimeout(() => {
            $indicator.fadeOut(300);
        }, 1500);
    }

    function startAutosave() {
        $('#amount').on('input', function() {
            if (!isRestoring) saveFormToLocalStorage();
        });
        $('#casher-select').on('change', function() {
            if (!isRestoring) saveFormToLocalStorage();
        });
        setInterval(() => {
            if (!isRestoring) saveFormToLocalStorage();
        }, 5000);
    }

    function updateAmount(value) {
        const numericValue = value.toString().replace(/[^0-9]/g, '');
        if (numericValue === '') {
            $('#amount').val('');
            saveFormToLocalStorage();
            return;
        }
        $('#amount').val(formatNumber(numericValue));
        saveFormToLocalStorage();
    }

    // ============================================
    // PAYMENT CONFIRM MODAL
    // ============================================
    function showCustomConfirm(amount, casherName, callback) {
        $('#confirm-amount-display').text(amount + ' دینار');
        $('#confirm-casher-name').text(casherName);
        confirmCallback = callback;
        $('#custom-confirm-overlay').fadeIn(300);
        setTimeout(() => { $('#confirm-btn-cancel').focus(); }, 400);
    }

    function hideCustomConfirm() {
        $('#custom-confirm-overlay').fadeOut(300, function() {
            $('#confirm-amount-display').text('0 دینار');
            $('#confirm-casher-name').text('-');
            confirmCallback = null;
        });
    }

    $('#confirm-btn-ok').on('click', function() {
        hideCustomConfirm();
        if (confirmCallback) confirmCallback(true);
    });

    $('#confirm-btn-cancel').on('click', function() {
        hideCustomConfirm();
        if (confirmCallback) confirmCallback(false);
    });

    $('#custom-confirm-overlay').on('click', function(e) {
        if (e.target === this) {
            hideCustomConfirm();
            if (confirmCallback) confirmCallback(false);
        }
    });

    // ============================================
    // LOAD CASHERS
    // ============================================
    function loadCashers() {
        $.ajax({
            url: '{{ route("casher.getData") }}',
            type: 'GET',
            success: function(response) {
                if (response.success && response.users) {
                    $('#casher-select').empty().append('<option value="">هەڵبژێرە</option>');
                    $.each(response.users, function(index, user) {
                        $('#casher-select').append(`<option value="${user.id}">${escapeHtml(user.name)}</option>`);
                    });

                    if (window._restoredCasherId) {
                        const casherId = window._restoredCasherId;
                        if ($('#casher-select option[value="' + casherId + '"]').length > 0) {
                            $('#casher-select').val(casherId);
                            loadCasherData(casherId);
                        }
                    } else if (response.users.length === 1) {
                        $('#casher-select').val(response.users[0].id);
                        loadCasherData(response.users[0].id);
                        saveFormToLocalStorage();
                    }
                } else {
                    $('#casher-select').empty().append('<option value="">هیچ کاشێرێک نەدۆزرایەوە</option>');
                }
            },
            error: function() {
                showAlert('error', 'هەڵە لە هێنانی داتاکانی کاشێر');
                $('#casher-select').empty().append('<option value="">هەڵەی هێنانی داتا</option>');
            }
        });
    }

    function loadCasherData(casherId) {
        $.ajax({
            url: '{{ url("/get-casher-details") }}/' + casherId,
            type: 'GET',
            success: function(response) {
                if (response.success && response.casher) {
                    $('#info-name').text(response.casher.name);
                    $('#info-email').text(response.casher.email);
                    $('#info-total').text(response.casher.total_coins || '0');
                    $('#casher-info').addClass('show');
                } else {
                    $('#casher-info').removeClass('show');
                }
            },
            error: function() {
                $('#casher-info').removeClass('show');
            }
        });
    }

    // ============================================
    // HISTORY TABLE
    // ============================================
    function loadHistory() {
        $('#history-tbody').html(`
            <tr class="loading-row">
                <td colspan="6">
                    <i class="fas fa-spinner fa-spin ms-2"></i>
                    چاوەڕوان بە... داتا بار دەکرێت
                </td>
            </tr>
        `);

        $.ajax({
            url: '{{ route("casher.allHistory") }}',
            type: 'GET',
            success: function(response) {
                if (response.success && response.data) {
                    historyData = response.data;
                    renderHistoryTable(historyData);
                    $('#summary-count').text(response.count || 0);
                    $('#summary-total').text(formatNumber(response.total_amount || 0));
                } else {
                    renderEmptyState();
                }
            },
            error: function(xhr) {
                console.warn('History endpoint not found.', xhr.status);
                renderEmptyState();
            }
        });
    }

    function renderHistoryTable(data) {
        if (!data || data.length === 0) {
            renderEmptyState();
            return;
        }

        let html = '';
        data.forEach(function(item, index) {
            const casherName = escapeHtml(item.casher_name || 'نەناسراو');
            const email = escapeHtml(item.casher_email || '-');
            const amount = formatNumber(item.amount || 0);
            const date = formatDateTime(item.created_at);
            const amountNum = parseInt(item.amount) || 0;
            const nameForJs = (item.casher_name || 'نەناسراو').replace(/'/g, "\\'").replace(/"/g, '&quot;');

            html += `
                <tr data-id="${item.id}" data-amount="${amountNum}" data-casher="${escapeHtml(item.casher_name || '')}">
                    <td data-label="#"><span class="badge-row">${index + 1}</span></td>
                    <td data-label="ناوی کاشێر">
                        <span class="badge-casher">
                            <i class="fas fa-user-circle"></i>
                            ${casherName}
                        </span>
                    </td>
                    <td data-label="ئیمەیڵ">${email}</td>
                    <td data-label="بڕی وردە" class="amount-cell">${amount} دینار</td>
                    <td data-label="بەروار و کات"><i class="far fa-clock ms-1"></i>${date}</td>
                    <td data-label="کردارەکان">
                        <div class="action-group">
                            <button type="button"
                                    class="action-btn action-btn-edit"
                                    onclick="openEditModal(${item.id}, ${amountNum}, '${nameForJs}')">
                                <i class="fas fa-edit"></i>
                                دەستکاری
                            </button>
                            <button type="button"
                                    class="action-btn action-btn-delete"
                                    onclick="openDeleteModal(${item.id}, ${amountNum}, '${nameForJs}')">
                                <i class="fas fa-trash"></i>
                                سڕینەوە
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        });

        $('#history-tbody').html(html);
    }

    function renderEmptyState() {
        $('#history-tbody').html(`
            <tr>
                <td colspan="6">
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <p>هیچ وردەیەک تۆمار نەکراوە هێشتا</p>
                    </div>
                </td>
            </tr>
        `);
        $('#summary-count').text('0');
        $('#summary-total').text('0');
    }

    function prependHistoryRow(coinId, casherName, casherEmail, amount) {
        $('#history-tbody .empty-state, #history-tbody .loading-row').closest('tr').remove();

        const rowCount = $('#history-tbody tr').length;
        const safeName = escapeHtml(casherName);
        const safeEmail = escapeHtml(casherEmail || '-');
        const nameForJs = (casherName || '').replace(/'/g, "\\'").replace(/"/g, '&quot;');

        const newRow = `
            <tr data-id="${coinId}" data-amount="${amount}" data-casher="${safeName}"
                style="background: rgba(16, 185, 129, 0.08);">
                <td data-label="#"><span class="badge-row">${rowCount + 1}</span></td>
                <td data-label="ناوی کاشێر">
                    <span class="badge-casher">
                        <i class="fas fa-user-circle"></i>
                        ${safeName}
                    </span>
                </td>
                <td data-label="ئیمەیڵ">${safeEmail}</td>
                <td data-label="بڕی وردە" class="amount-cell">${formatNumber(amount)} دینار</td>
                <td data-label="بەروار و کات"><i class="far fa-clock ms-1"></i>${formatDateTime(new Date().toISOString())}</td>
                <td data-label="کردارەکان">
                    <div class="action-group">
                        <button type="button"
                                class="action-btn action-btn-edit"
                                onclick="openEditModal(${coinId}, ${amount}, '${nameForJs}')">
                            <i class="fas fa-edit"></i>
                            دەستکاری
                        </button>
                        <button type="button"
                                class="action-btn action-btn-delete"
                                onclick="openDeleteModal(${coinId}, ${amount}, '${nameForJs}')">
                            <i class="fas fa-trash"></i>
                            سڕینەوە
                        </button>
                    </div>
                </td>
            </tr>
        `;
        $('#history-tbody').prepend(newRow);

        const oldCount = parseInt($('#summary-count').text()) || 0;
        const oldTotal = parseInt(unformatNumber($('#summary-total').text())) || 0;
        $('#summary-count').text(oldCount + 1);
        $('#summary-total').text(formatNumber(oldTotal + parseInt(amount)));

        setTimeout(() => {
            $('#history-tbody tr:first').css('background', '');
        }, 2500);
    }

    // ============================================
    // EDIT MODAL
    // ============================================
    let currentEditId = null;

    window.openEditModal = function(id, amount, casherName) {
        currentEditId = id;
        $('#edit-casher-name').text(casherName);
        $('#edit-amount-input').val(formatNumber(amount));
        $('#edit-amount-error').hide().text('');
        $('#edit-modal-overlay').fadeIn(250);
        setTimeout(() => {
            $('#edit-amount-input').focus().select();
        }, 300);
    };

    function closeEditModal() {
        $('#edit-modal-overlay').fadeOut(250, function() {
            currentEditId = null;
            $('#edit-amount-input').val('');
            $('#edit-amount-error').hide().text('');
        });
    }

    $('#edit-amount-input').on('input', function() {
        let raw = $(this).val().replace(/[^0-9]/g, '');
        if (raw === '') {
            $(this).val('');
            return;
        }
        $(this).val(formatNumber(raw));
    });

    $('#edit-btn-cancel').on('click', function() {
        closeEditModal();
    });

    $('#edit-modal-overlay').on('click', function(e) {
        if (e.target === this) closeEditModal();
    });

    $('#edit-btn-save').on('click', function() {
        if (!currentEditId) return;

        const rawAmount = $('#edit-amount-input').val();
        const amount = parseInt(unformatNumber(rawAmount));

        if (!rawAmount || isNaN(amount) || amount < 1) {
            $('#edit-amount-error').text('بڕی وردە دەبێت لانیکەم 1 دینار بێت').show();
            return;
        }

        const $btn = $(this);
        const originalHtml = $btn.html();
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin ms-2"></i>پاشەکەوت دەکرێت...');

        const row = $(`#history-tbody tr[data-id="${currentEditId}"]`);
        const oldAmount = parseInt(row.data('amount')) || 0;

        $.ajax({
            url: '{{ url("/casher/coin") }}/' + currentEditId,
            type: 'PUT',
            data: {
                amount: amount,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    showAlert('success', response.message || 'وردەکە نوێکرایەوە');

                    row.attr('data-amount', amount);
                    row.find('.amount-cell').text(formatNumber(amount) + ' دینار');

                    const casherName = row.data('casher');
                    const nameForJs = (casherName || '').replace(/'/g, "\\'").replace(/"/g, '&quot;');
                    row.find('.action-btn-edit').attr('onclick', `openEditModal(${currentEditId}, ${amount}, '${nameForJs}')`);
                    row.find('.action-btn-delete').attr('onclick', `openDeleteModal(${currentEditId}, ${amount}, '${nameForJs}')`);

                    row.css('background', 'rgba(16, 185, 129, 0.15)');
                    setTimeout(() => row.css('background', ''), 1500);

                    const summaryTotal = parseInt(unformatNumber($('#summary-total').text())) || 0;
                    $('#summary-total').text(formatNumber(summaryTotal - oldAmount + amount));

                    const selectedCasher = $('#casher-select').val();
                    if (selectedCasher) loadCasherData(selectedCasher);

                    closeEditModal();
                } else {
                    showAlert('error', response.message || 'هەڵەیەک ڕوویدا');
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    if (errors && errors.amount) {
                        $('#edit-amount-error').text(errors.amount[0]).show();
                    }
                } else {
                    showAlert('error', 'هەڵەیەک ڕوویدا. تکایە دووبارە هەوڵبدەرەوە');
                }
            },
            complete: function() {
                $btn.prop('disabled', false).html(originalHtml);
            }
        });
    });

    // ============================================
    // DELETE MODAL
    // ============================================
    let currentDeleteId = null;
    let currentDeleteAmount = 0;

    window.openDeleteModal = function(id, amount, casherName) {
        currentDeleteId = id;
        currentDeleteAmount = amount;
        $('#delete-casher-name').text(casherName);
        $('#delete-amount-display').text(formatNumber(amount) + ' دینار');
        $('#delete-modal-overlay').fadeIn(250);
    };

    function closeDeleteModal() {
        $('#delete-modal-overlay').fadeOut(250, function() {
            currentDeleteId = null;
            currentDeleteAmount = 0;
            $('#delete-casher-name').text('-');
            $('#delete-amount-display').text('0 دینار');
        });
    }

    $('#delete-btn-cancel').on('click', function() {
        closeDeleteModal();
    });

    $('#delete-modal-overlay').on('click', function(e) {
        if (e.target === this) closeDeleteModal();
    });

    $('#delete-btn-confirm').on('click', function() {
        if (!currentDeleteId) return;

        const $btn = $(this);
        const originalHtml = $btn.html();
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin ms-2"></i>سڕینەوە...');

        const idToDelete = currentDeleteId;
        const amountToDelete = currentDeleteAmount;
        const row = $(`#history-tbody tr[data-id="${idToDelete}"]`);

        $.ajax({
            url: '{{ url("/casher/coin") }}/' + idToDelete,
            type: 'DELETE',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    showAlert('success', response.message || 'وردەکە سڕایەوە');

                    row.fadeOut(300, function() {
                        $(this).remove();

                        $('#history-tbody tr').each(function(i) {
                            $(this).find('.badge-row').text(i + 1);
                        });

                        if ($('#history-tbody tr').length === 0) {
                            renderEmptyState();
                        }
                    });

                    const summaryCount = parseInt($('#summary-count').text()) || 0;
                    const summaryTotal = parseInt(unformatNumber($('#summary-total').text())) || 0;
                    $('#summary-count').text(Math.max(0, summaryCount - 1));
                    $('#summary-total').text(formatNumber(Math.max(0, summaryTotal - amountToDelete)));

                    const selectedCasher = $('#casher-select').val();
                    if (selectedCasher) loadCasherData(selectedCasher);

                    closeDeleteModal();
                } else {
                    showAlert('error', response.message || 'هەڵەیەک ڕوویدا');
                }
            },
            error: function(xhr) {
                if (xhr.status === 404) {
                    showAlert('error', 'وردە نەدۆزرایەوە');
                    row.remove();
                } else {
                    showAlert('error', 'هەڵەیەک ڕوویدا. تکایە دووبارە هەوڵبدەرەوە');
                }
            },
            complete: function() {
                $btn.prop('disabled', false).html(originalHtml);
            }
        });
    });

    // ESC closes whichever modal is open
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape') {
            if ($('#edit-modal-overlay').is(':visible')) closeEditModal();
            if ($('#delete-modal-overlay').is(':visible')) closeDeleteModal();
            if ($('#custom-confirm-overlay').is(':visible')) {
                hideCustomConfirm();
                if (confirmCallback) confirmCallback(false);
            }
        }
    });

    // ============================================
    // SUBMIT COIN TRANSACTION
    // ============================================
    function submitCoinTransaction() {
        const casherId = $('#casher-select').val();
        const casherName = $('#casher-select option:selected').text();
        const casherEmail = historyData.find(x => x.casher_id == casherId)?.casher_email || '';
        const amountRaw = $('#amount').val();
        const amount = parseInt(unformatNumber(amountRaw));

        isSubmitting = true;
        const submitBtn = $('#submit-btn');
        const originalText = submitBtn.html();
        submitBtn.html('<i class="fas fa-spinner fa-spin ms-2"></i>تۆمار دەکرێت...').prop('disabled', true);

        $.ajax({
            url: '{{ route("casher.store") }}',
            type: 'POST',
            data: {
                casher_id: casherId,
                amount: amount,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    showAlert('success', response.message || 'وردەکە بە سەرکەوتوویی پێدرا');

                    if (casherId) loadCasherData(casherId);

                    prependHistoryRow(response.coin_id, casherName, casherEmail, amount);

                    $('#amount').val('');
                    saveFormToLocalStorage();
                } else {
                    showAlert('error', response.message || 'هەڵەیەک ڕوویدا');
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    for (let field in errors) {
                        if (errors.hasOwnProperty(field)) showError(field, errors[field][0]);
                    }
                    showAlert('error', 'تکایە زانیارییەکان ڕاست بکەرەوە');
                } else if (xhr.status === 404) {
                    showAlert('error', 'کاشێر نەدۆزرایەوە');
                } else {
                    showAlert('error', 'هەڵەیەک ڕوویدا. تکایە دووبارە هەوڵبدەرەوە');
                }
            },
            complete: function() {
                isSubmitting = false;
                submitBtn.html(originalText).prop('disabled', false);
            }
        });
    }

    $('#coin-form').submit(function(e) {
        e.preventDefault();
        if (isSubmitting) return false;
        clearErrors();

        const casherId = $('#casher-select').val();
        const amountRaw = $('#amount').val();
        const amount = parseInt(unformatNumber(amountRaw));

        let hasError = false;

        if (!casherId) {
            showError('casher', 'تکایە کاشێرێک هەڵبژێرە');
            hasError = true;
        }
        if (!amountRaw || isNaN(amount) || amount < 1) {
            showError('amount', 'بڕی وردە دەبێت لانیکەم 1 دینار بێت');
            hasError = true;
        }
        if (hasError) return false;

        const casherName = $('#casher-select option:selected').text();
        const formattedAmount = formatNumber(amount);

        showCustomConfirm(formattedAmount, casherName, function(confirmed) {
            if (confirmed) submitCoinTransaction();
        });
    });

    $('#amount').keypress(function(e) {
        if (e.which === 13) {
            e.preventDefault();
            $('#coin-form').submit();
        }
    });

    $('.quick-amount-btn').click(function() {
        const amount = $(this).data('amount');
        updateAmount(amount);
        $('#amount').focus();
    });

    // ============================================
    // AUTO-REFRESH CASHER INFO (every 60s)
    // ============================================
    setInterval(function() {
        const selectedCasher = $('#casher-select').val();
        if (selectedCasher) {
            loadCasherData(selectedCasher);
        }
    }, 60000);

    // ============================================
    // INIT
    // ============================================
    console.log('🚀 Initializing Casher Coin page...');

    restoreFormFromLocalStorage();
    loadCashers();
    loadHistory();
    startAutosave();

    setTimeout(() => {
        if (!$('#amount').val()) $('#amount').focus();
    }, 1000);

    console.log('✅ Initialization complete');
});
</script>
@endsection