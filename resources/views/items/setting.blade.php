@extends('layouts.navigation')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    :root {
        --primary: #8b5cf6;
        --primary-dark: #6d28d9;
        --primary-light: #c4b5fd;
        --primary-soft: rgba(139, 92, 246, 0.1);
        --success: #10b981;
        --success-soft: rgba(16, 185, 129, 0.1);
        --success-dark: #065f46;
        --success-light: #d1fae5;
        --warning: #f59e0b;
        --warning-soft: rgba(245, 158, 11, 0.1);
        --warning-dark: #92400e;
        --warning-light: #fef3c7;
        --danger: #ef4444;
        --danger-soft: rgba(239, 68, 68, 0.1);
        --danger-dark: #991b1b;
        --danger-light: #fee2e2;
        --info: #3b82f6;
        --info-soft: rgba(59, 130, 246, 0.1);
        --info-dark: #1e40af;
        --info-light: #dbeafe;
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
        --shadow-2xl: 0 25px 50px -12px rgb(0 0 0 / 0.25);
        --radius-sm: 0.375rem;
        --radius: 0.5rem;
        --radius-md: 0.75rem;
        --radius-lg: 1rem;
        --radius-xl: 1.5rem;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        --gradient-purple: linear-gradient(135deg, #8b5cf6, #6d28d9);
        --gradient-dark: linear-gradient(135deg, #1e293b 0%, #334155 100%);
    }

    body.dark-mode {
        --text: #e2e8f0;
        --text-secondary: #94a3b8;
        --text-muted: #64748b;
        --border-color: #334155;
        --bg-white: #1e293b;
        --bg-light: #1e293b;
        --bg-body: #0f172a;
        --primary-soft: rgba(139, 92, 246, 0.15);
        --success-soft: rgba(16, 185, 129, 0.15);
        --warning-soft: rgba(245, 158, 11, 0.15);
        --danger-soft: rgba(239, 68, 68, 0.15);
        --info-soft: rgba(59, 130, 246, 0.15);
        --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.3);
        --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.4);
        --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.4);
        --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.4);
        --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.4);
        --shadow-2xl: 0 25px 50px -12px rgb(0 0 0 / 0.5);
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background: var(--bg-body);
        font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
        color: var(--text);
        transition: background-color 0.3s ease, color 0.3s ease;
        min-height: 100vh;
        line-height: 1.6;
    }

    /* ==================== ALERT STYLES ==================== */
    #alert-container {
        position: fixed;
        top: 24px;
        right: 24px;
        z-index: 10000;
        width: 440px;
        max-width: 90vw;
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .alert-toast {
        display: flex;
        align-items: stretch;
        gap: 0;
        border-radius: var(--radius-lg);
        backdrop-filter: blur(12px);
        box-shadow: var(--shadow-2xl);
        animation: slideInRight 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        position: relative;
        overflow: hidden;
        border: 1px solid;
        min-height: 80px;
    }

    .alert-toast .alert-stripe {
        width: 6px;
        flex-shrink: 0;
    }

    .alert-toast .alert-body {
        flex: 1;
        padding: 16px 18px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: relative;
        z-index: 1;
        min-width: 0;
    }

    .alert-toast .alert-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 6px;
    }

    .alert-toast .alert-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .alert-toast .alert-title {
        font-weight: 700;
        font-size: 0.9rem;
        margin-bottom: 4px;
        line-height: 1.3;
    }

    .alert-toast .alert-message {
        font-size: 0.85rem;
        opacity: 0.85;
        line-height: 1.5;
        word-wrap: break-word;
        font-weight: 400;
    }

    .alert-close-btn {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: none;
        background: rgba(0, 0, 0, 0.08);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        flex-shrink: 0;
        transition: var(--transition);
        opacity: 0.6;
        color: inherit;
    }

    .alert-close-btn:hover {
        opacity: 1;
        background: rgba(0, 0, 0, 0.15);
        transform: scale(1.1) rotate(90deg);
    }

    .alert-success {
        background: linear-gradient(135deg, #ecfdf5, #d1fae5);
        border-color: #a7f3d0;
        color: var(--success-dark);
    }

    .alert-success .alert-stripe {
        background: linear-gradient(180deg, #10b981, #059669);
    }

    .alert-success .alert-badge {
        background: rgba(16, 185, 129, 0.15);
        color: #059669;
    }

    .alert-error {
        background: linear-gradient(135deg, #fef2f2, #fee2e2);
        border-color: #fca5a5;
        color: var(--danger-dark);
    }

    .alert-error .alert-stripe {
        background: linear-gradient(180deg, #ef4444, #dc2626);
    }

    .alert-error .alert-badge {
        background: rgba(239, 68, 68, 0.15);
        color: #dc2626;
    }

    .alert-warning {
        background: linear-gradient(135deg, #fffbeb, #fef3c7);
        border-color: #fcd34d;
        color: var(--warning-dark);
    }

    .alert-warning .alert-stripe {
        background: linear-gradient(180deg, #f59e0b, #d97706);
    }

    .alert-warning .alert-badge {
        background: rgba(245, 158, 11, 0.15);
        color: #d97706;
    }

    .alert-info {
        background: linear-gradient(135deg, #eff6ff, #dbeafe);
        border-color: #93c5fd;
        color: var(--info-dark);
    }

    .alert-info .alert-stripe {
        background: linear-gradient(180deg, #3b82f6, #2563eb);
    }

    .alert-info .alert-badge {
        background: rgba(59, 130, 246, 0.15);
        color: #2563eb;
    }

    body.dark-mode .alert-success {
        background: linear-gradient(135deg, #064e3b, #065f46);
        border-color: #059669;
        color: #d1fae5;
    }

    body.dark-mode .alert-error {
        background: linear-gradient(135deg, #7f1d1d, #991b1b);
        border-color: #dc2626;
        color: #fecaca;
    }

    body.dark-mode .alert-warning {
        background: linear-gradient(135deg, #78350f, #92400e);
        border-color: #d97706;
        color: #fde68a;
    }

    body.dark-mode .alert-info {
        background: linear-gradient(135deg, #1e3a5f, #1e40af);
        border-color: #2563eb;
        color: #bfdbfe;
    }

    .alert-progress {
        position: absolute;
        bottom: 0;
        left: 6px;
        right: 0;
        height: 3px;
        background: rgba(0, 0, 0, 0.05);
    }

    .alert-progress-bar {
        height: 100%;
        border-radius: 0 0 var(--radius-lg) 0;
        animation: progressShrink 4s linear forwards;
    }

    .alert-success .alert-progress-bar { background: var(--success); }
    .alert-error .alert-progress-bar { background: var(--danger); }
    .alert-warning .alert-progress-bar { background: var(--warning); }
    .alert-info .alert-progress-bar { background: var(--info); }

    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(120px) scale(0.9); }
        to { opacity: 1; transform: translateX(0) scale(1); }
    }

    @keyframes progressShrink {
        from { width: 100%; }
        to { width: 0%; }
    }

    @keyframes fadeOutRight {
        from { opacity: 1; transform: translateX(0) scale(1); }
        to { opacity: 0; transform: translateX(100px) scale(0.9); }
    }

    .alert-removing {
        animation: fadeOutRight 0.4s ease forwards;
    }

    /* ==================== CONFIRM DIALOG ==================== */
    .confirm-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
        z-index: 10001;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: fadeIn 0.2s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .confirm-dialog {
        background: var(--bg-white);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-2xl);
        width: 440px;
        max-width: 90vw;
        overflow: hidden;
        animation: scaleIn 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        border: 1px solid var(--border-color);
    }

    @keyframes scaleIn {
        from { opacity: 0; transform: scale(0.9); }
        to { opacity: 1; transform: scale(1); }
    }

    .confirm-header {
        padding: 20px 24px;
        display: flex;
        align-items: center;
        gap: 14px;
        border-bottom: 1px solid var(--border-color);
    }

    .confirm-icon-wrapper {
        width: 48px;
        height: 48px;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .confirm-icon-wrapper.warning { background: var(--warning-soft); color: var(--warning); }
    .confirm-icon-wrapper.danger { background: var(--danger-soft); color: var(--danger); }
    .confirm-icon-wrapper.info { background: var(--info-soft); color: var(--info); }

    .confirm-title-section h4 {
        font-weight: 700;
        font-size: 1.1rem;
        color: var(--text);
        margin-bottom: 2px;
    }

    .confirm-title-section p {
        font-size: 0.8rem;
        color: var(--text-muted);
        margin: 0;
    }

    .confirm-body {
        padding: 24px;
    }

    .confirm-body .user-info-highlight {
        background: var(--bg-light);
        border-radius: var(--radius-md);
        padding: 16px;
        text-align: center;
        margin-bottom: 16px;
        border: 1px solid var(--border-color);
    }

    .confirm-body .user-info-highlight .user-name-large {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 4px;
    }

    .confirm-body .user-info-highlight .role-change-info {
        font-size: 0.85rem;
        color: var(--text-secondary);
    }

    .confirm-body .user-info-highlight .role-change-info .old-role {
        text-decoration: line-through;
        opacity: 0.6;
        margin: 0 4px;
    }

    .confirm-body .user-info-highlight .role-change-info .new-role {
        font-weight: 700;
        color: var(--primary);
        margin: 0 4px;
    }

    .confirm-body .warning-text {
        color: var(--danger);
        font-size: 0.85rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 14px;
        background: var(--danger-soft);
        border-radius: var(--radius-md);
        margin-top: 12px;
    }

    .confirm-footer {
        padding: 16px 24px;
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        border-top: 1px solid var(--border-color);
        background: var(--bg-light);
    }

    .btn-confirm {
        padding: 10px 20px;
        border-radius: var(--radius-md);
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: var(--transition);
        border: none;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-confirm-cancel {
        background: transparent;
        color: var(--text-secondary);
        border: 2px solid var(--border-color);
    }

    .btn-confirm-cancel:hover {
        border-color: var(--text-muted);
        color: var(--text);
    }

    .btn-confirm-primary {
        background: var(--primary);
        color: white;
    }

    .btn-confirm-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);
    }

    .btn-confirm-danger {
        background: var(--danger);
        color: white;
    }

    .btn-confirm-danger:hover {
        background: #dc2626;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    .btn-confirm:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    /* ==================== LAYOUT ==================== */
    .container-fluid {
        padding: 2rem 2rem;
        max-width: 1400px;
        margin: 0 auto;
    }

    @media (max-width: 768px) {
        .container-fluid { padding: 1rem; }
    }

    .page-header {
        background: var(--bg-white);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-md);
        padding: 2rem 2.5rem;
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .page-header-left {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .header-icon {
        width: 60px;
        height: 60px;
        background: var(--gradient-purple);
        color: white;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .header-title {
        font-weight: 700;
        font-size: 1.5rem;
        color: var(--text);
        margin-bottom: 0.25rem;
    }

    .header-subtitle {
        color: var(--text-muted);
        font-size: 0.9rem;
    }

    .btn-add-user {
        background: var(--gradient-purple);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: var(--radius-md);
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        white-space: nowrap;
    }

    .btn-add-user:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(139, 92, 246, 0.4);
    }

    .table-card {
        background: var(--bg-white);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-lg);
        overflow: hidden;
    }

    .table-header {
        background: var(--gradient-dark);
        color: white;
        padding: 1rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .table-header h5 {
        font-weight: 700;
        margin-bottom: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .table-header h5 i { color: var(--primary-light); }

    .search-box { display: flex; align-items: center; }

    .search-icon {
        background: rgba(255, 255, 255, 0.1);
        color: rgba(255, 255, 255, 0.5);
        padding: 0.5rem 0.75rem;
        border-radius: var(--radius-md);
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }

    .search-input {
        background: rgba(255, 255, 255, 0.1);
        border: none;
        color: white;
        padding: 0.5rem 0.75rem;
        border-radius: var(--radius-md);
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
        font-size: 0.9rem;
        min-width: 220px;
    }

    .search-input::placeholder { color: rgba(255, 255, 255, 0.5); }
    .search-input:focus { outline: none; background: rgba(255, 255, 255, 0.2); }

    .table-body { padding: 0; overflow-x: auto; }

    .data-table { width: 100%; border-collapse: collapse; font-size: 0.9rem; }

    .data-table thead {
        background: var(--bg-light);
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .data-table thead th {
        padding: 1rem 1.25rem;
        text-align: right;
        font-weight: 700;
        font-size: 0.8rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 2px solid var(--border-color);
        white-space: nowrap;
    }

    .data-table thead th:first-child { width: 50px; text-align: center; }
    .data-table thead th:last-child { text-align: center; width: 200px; }

    .data-table tbody td {
        padding: 0.875rem 1.25rem;
        border-bottom: 1px solid var(--border-color);
        color: var(--text);
        transition: var(--transition);
        white-space: nowrap;
    }

    .data-table tbody td:first-child { text-align: center; }
    .data-table tbody td:last-child { text-align: center; }
    .data-table tbody tr:hover { background: var(--primary-soft); }

    .user-name { font-weight: 600; color: var(--text); }
    .user-email { color: var(--text-secondary); font-size: 0.85rem; }

    .role-badge {
        padding: 0.3rem 0.75rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 700;
        display: inline-block;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .role-admin { background: var(--danger-soft); color: var(--danger); }
    .role-casher { background: var(--info-soft); color: var(--info); }
    .role-unknown { background: var(--warning-soft); color: var(--warning); }

    .date-cell { font-size: 0.8rem; color: var(--text-muted); }

    .action-buttons { display: flex; gap: 0.5rem; justify-content: center; align-items: center; }

    .btn-icon {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        border: 2px solid;
        background: transparent;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        font-weight: 700;
    }

    .btn-icon-edit { color: var(--info); border-color: var(--info); }
    .btn-icon-edit:hover { background: var(--info); color: white; transform: scale(1.15); }

    .btn-icon-delete { color: var(--danger); border-color: var(--danger); }
    .btn-icon-delete:hover { background: var(--danger); color: white; transform: scale(1.15); }

    .btn-icon-role {
        width: auto;
        min-width: 36px;
        padding: 0 10px;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .btn-make-admin { color: var(--danger); border-color: var(--danger); }
    .btn-make-admin:hover { background: var(--danger); color: white; }

    .btn-make-casher { color: var(--info); border-color: var(--info); }
    .btn-make-casher:hover { background: var(--info); color: white; }

    .select-all-cell { width: 40px; text-align: center; }
    .select-all-cell input[type="checkbox"],
    .row-checkbox { width: 18px; height: 18px; cursor: pointer; accent-color: var(--primary); }

    .btn-bulk-delete {
        background: var(--danger);
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: var(--radius-md);
        font-weight: 600;
        font-size: 0.85rem;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-bulk-delete:hover { background: #dc2626; transform: translateY(-2px); }
    .btn-bulk-delete:disabled { opacity: 0.6; cursor: not-allowed; }

    /* Modal */
    .custom-modal .modal-content {
        border-radius: var(--radius-xl);
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-xl);
        background: var(--bg-white);
        overflow: hidden;
    }

    .custom-modal .modal-header {
        background: var(--gradient-purple);
        color: white;
        border-bottom: none;
        padding: 1.25rem 1.5rem;
    }

    .custom-modal .modal-title { font-weight: 700; display: flex; align-items: center; gap: 0.5rem; }
    .custom-modal .btn-close { filter: brightness(0) invert(1); }
    .custom-modal .modal-body { padding: 2rem; }
    .custom-modal .modal-footer { border-top: 1px solid var(--border-color); padding: 1rem 1.5rem; }

    .form-label { font-weight: 600; font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 0.5rem; }

    .form-control-custom {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid var(--border-color);
        border-radius: var(--radius-md);
        font-size: 0.95rem;
        transition: var(--transition);
        background: var(--bg-light);
        color: var(--text);
    }

    .form-control-custom:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 0.25rem rgba(139, 92, 246, 0.15);
        background: var(--bg-white);
    }

    .form-control-custom::placeholder { color: var(--text-muted); }
    .form-group { margin-bottom: 1.25rem; }

    /* Password Input Group */
    .password-input-group {
        position: relative;
        display: flex;
        align-items: center;
    }

    .password-input-group .form-control-custom {
        padding-left: 45px;
    }

    .password-toggle-btn {
        position: absolute;
        left: 8px;
        top: 50%;
        transform: translateY(-50%);
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: none;
        background: transparent;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-muted);
        transition: var(--transition);
        font-size: 0.9rem;
    }

    .password-toggle-btn:hover {
        color: var(--primary);
        background: var(--primary-soft);
    }

    .btn-primary-custom {
        background: var(--gradient-purple);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: var(--radius-md);
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary-custom:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(139, 92, 246, 0.4); }
    .btn-primary-custom:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }

    .btn-secondary-custom {
        background: transparent;
        color: var(--text-secondary);
        border: 2px solid var(--border-color);
        padding: 0.75rem 1.5rem;
        border-radius: var(--radius-md);
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: var(--transition);
    }

    .btn-secondary-custom:hover { border-color: var(--primary); color: var(--primary); }

    .empty-state { text-align: center; padding: 4rem 2rem; color: var(--text-muted); }
    .empty-state i { font-size: 4rem; margin-bottom: 1rem; display: block; opacity: 0.4; }
    .empty-state h5 { margin-bottom: 0.5rem; color: var(--text-secondary); }

    @media (max-width: 768px) {
        .page-header { flex-direction: column; align-items: flex-start; padding: 1.5rem; }
        .table-header { flex-direction: column; align-items: flex-start; }
        .search-input { min-width: 150px; }
        .action-buttons { flex-wrap: wrap; }
        #alert-container { width: 90vw; right: 5vw; }
    }
</style>

<div id="alert-container"></div>
<div id="confirm-container"></div>

<div class="container-fluid">
    
    <div class="page-header">
        <div class="page-header-left">
            <div class="header-icon">
                <i class="fas fa-users-cog"></i>
            </div>
            <div>
                <h2 class="header-title">ڕێکخستنەکانی بەکارهێنەران</h2>
                <p class="header-subtitle">بەڕێوەبردنی بەکارهێنەران و ڕۆڵەکانیان</p>
            </div>
        </div>
        <button class="btn-add-user" onclick="openAddModal()">
            <i class="fas fa-user-plus"></i>
            زیادکردنی بەکارهێنەر
        </button>
    </div>

    <div class="table-card">
        <div class="table-header">
            <h5><i class="fas fa-list"></i> لیستی بەکارهێنەران</h5>
            <div style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
             
                <div class="search-box">
                    <span class="search-icon"><i class="fas fa-search"></i></span>
                    <input type="text" id="searchInput" class="search-input" placeholder="گەڕان...">
                </div>
            </div>
        </div>
        <div class="table-body">
            <div id="table-content">
                <div class="empty-state">
                    <i class="fas fa-spinner fa-spin"></i>
                    <h5>بارکردنی زانیاری...</h5>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- User Modal --}}
<div class="modal fade custom-modal" id="userModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalTitle">
                    <i class="fas fa-user-plus"></i> زیادکردنی بەکارهێنەر
                </h5>
         
            </div>
            <div class="modal-body">
                <form id="userForm" onsubmit="saveUser(event)">
                    <input type="hidden" id="userId">
                    
                    <div class="form-group">
                        <label class="form-label">ناوی بەکارهێنەر <span class="text-danger">*</span></label>
                        <input type="text" id="userName" class="form-control-custom" placeholder="ناو بنووسە..." required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">ئیمەیڵ <span class="text-danger">*</span></label>
                        <input type="email" id="userEmail" class="form-control-custom" placeholder="example@email.com" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">
                            پاسۆرد <span class="text-danger" id="passwordRequired">*</span>
                        </label>
                        <div class="password-input-group">
                            <input type="password" id="userPassword" class="form-control-custom" placeholder="پاسۆرد بنووسە...">
                            <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility('userPassword', this)" title="نیشاندانی پاسۆرد">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <small class="text-muted" id="passwordHint" style="display: none;">بەتاڵ بەجێبهێڵە ئەگەر ناتەوێت بیگۆڕیت</small>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">ڕۆڵ <span class="text-danger">*</span></label>
                        <select id="userRole" class="form-control-custom" required>
                            <option value="">ڕۆڵ هەڵبژێرە...</option>
                            <option value="1">ئەدمین (Admin)</option>
                            <option value="2">کاشێر (Casher)</option>
                        </select>
                    </div>
                    
                    <div class="d-flex justify-content-end gap-3 mt-4">
                        <button type="button" class="btn-secondary-custom" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i> پاشگەزبوونەوە
                        </button>
                        <button type="submit" class="btn-primary-custom" id="saveBtn">
                            <i class="fas fa-save"></i> تۆمارکردن
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
let isEditMode = false;
let userModal;
let alertTimers = {};

$(document).ready(function() {
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });
    
    userModal = new bootstrap.Modal(document.getElementById('userModal'));
    
    loadUsers();
    
    let searchTimeout;
    $('#searchInput').on('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => loadUsers(), 300);
    });
    
    $('#alert-container').on('click', '.alert-close-btn', function() {
        const alertId = $(this).closest('.alert-toast').attr('id');
        removeAlert(alertId);
    });
});

// ==================== TOGGLE PASSWORD VISIBILITY ====================
function togglePasswordVisibility(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon = btn.querySelector('i');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// ==================== ALERT FUNCTIONS ====================
function showAlert(type, message, title = null, duration = 4000) {
    let badgeText, alertClass, defaultTitle;
    
    switch(type) {
        case 'success':
            badgeText = 'سەرکەوتوو';
            alertClass = 'alert-success';
            defaultTitle = 'سەرکەوتوو';
            break;
        case 'error':
            badgeText = 'هەڵە';
            alertClass = 'alert-error';
            defaultTitle = 'هەڵە';
            break;
        case 'warning':
            badgeText = 'ئاگاداری';
            alertClass = 'alert-warning';
            defaultTitle = 'ئاگاداری';
            break;
        case 'info':
            badgeText = 'زانیاری';
            alertClass = 'alert-info';
            defaultTitle = 'زانیاری';
            break;
        default:
            badgeText = 'زانیاری';
            alertClass = 'alert-info';
            defaultTitle = 'زانیاری';
    }
    
    const alertId = 'alert-' + Date.now() + '-' + Math.random().toString(36).substr(2, 9);
    const alertTitle = title || defaultTitle;
    
    const alertHtml = `
        <div id="${alertId}" class="alert-toast ${alertClass}">
            <div class="alert-stripe"></div>
            <div class="alert-body">
                <div class="alert-header">
                    <span class="alert-badge">${badgeText}</span>
                    <button class="alert-close-btn" title="داخستن">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="alert-title">${alertTitle}</div>
                <div class="alert-message">${escapeHtml(message)}</div>
            </div>
            <div class="alert-progress">
                <div class="alert-progress-bar"></div>
            </div>
        </div>
    `;
    
    $('#alert-container').append(alertHtml);
    
    if (duration > 0) {
        alertTimers[alertId] = setTimeout(() => removeAlert(alertId), duration);
    }
    
    $(`#${alertId}`).on('mouseenter', function() {
        clearTimeout(alertTimers[alertId]);
        $(this).find('.alert-progress-bar').css('animation-play-state', 'paused');
    });
    
    $(`#${alertId}`).on('mouseleave', function() {
        $(this).find('.alert-progress-bar').css('animation-play-state', 'running');
        alertTimers[alertId] = setTimeout(() => removeAlert(alertId), duration);
    });
}

function removeAlert(alertId) {
    if (!alertId) return;
    clearTimeout(alertTimers[alertId]);
    delete alertTimers[alertId];
    
    const $alert = $(`#${alertId}`);
    if ($alert.length) {
        $alert.addClass('alert-removing');
        setTimeout(() => $alert.remove(), 400);
    }
}

// ==================== CONFIRM DIALOG ====================
function showConfirm(options) {
    const {
        title = 'پشتڕاستکردنەوە',
        message = '',
        iconType = 'warning',
        confirmText = 'بەڵێ',
        cancelText = 'پاشگەزبوونەوە',
        confirmClass = 'btn-confirm-primary',
        userInfo = null,
        warningMessage = null,
        onConfirm = null,
        onCancel = null
    } = options;
    
    let iconClass = 'fa-exclamation-triangle';
    if (iconType === 'danger') iconClass = 'fa-trash-alt';
    else if (iconType === 'info') iconClass = 'fa-info-circle';
    
    let userInfoHtml = '';
    if (userInfo) {
        userInfoHtml = `
            <div class="user-info-highlight">
                <div class="user-name-large">${escapeHtml(userInfo.name || '')}</div>
                ${userInfo.roleChange ? `
                    <div class="role-change-info">
                        گۆڕینی ڕۆڵ لە <span class="old-role">${escapeHtml(userInfo.roleChange.from)}</span> 
                        بۆ <span class="new-role">${escapeHtml(userInfo.roleChange.to)}</span>
                    </div>
                ` : ''}
            </div>
        `;
    }
    
    let warningHtml = '';
    if (warningMessage) {
        warningHtml = `
            <div class="warning-text">
                <i class="fas fa-exclamation-triangle"></i>
                ${escapeHtml(warningMessage)}
            </div>
        `;
    }
    
    const confirmHtml = `
        <div id="confirm-overlay" class="confirm-overlay">
            <div class="confirm-dialog">
                <div class="confirm-header">
                    <div class="confirm-icon-wrapper ${iconType}">
                        <i class="fas ${iconClass}"></i>
                    </div>
                    <div class="confirm-title-section">
                        <h4>${escapeHtml(title)}</h4>
                        <p>تکایە پشتڕاستی بکەرەوە</p>
                    </div>
                </div>
                <div class="confirm-body">
                    ${userInfoHtml}
                    <p style="color: var(--text-secondary); font-size: 0.95rem;">${escapeHtml(message)}</p>
                    ${warningHtml}
                </div>
                <div class="confirm-footer">
                    <button class="btn-confirm btn-confirm-cancel" id="confirm-cancel-btn">
                        <i class="fas fa-times"></i> ${escapeHtml(cancelText)}
                    </button>
                    <button class="btn-confirm ${confirmClass}" id="confirm-ok-btn">
                        <i class="fas fa-check"></i> ${escapeHtml(confirmText)}
                    </button>
                </div>
            </div>
        </div>
    `;
    
    $('#confirm-container').html(confirmHtml);
    
    $('#confirm-cancel-btn').on('click', function() {
        closeConfirm();
        if (onCancel) onCancel();
    });
    
    $('#confirm-ok-btn').on('click', function() {
        closeConfirm();
        if (onConfirm) onConfirm();
    });
    
    $('#confirm-overlay').on('click', function(e) {
        if (e.target === this) {
            closeConfirm();
            if (onCancel) onCancel();
        }
    });
}

function closeConfirm() {
    const $overlay = $('#confirm-overlay');
    if ($overlay.length) {
        $overlay.fadeOut(200, function() { $(this).remove(); });
    }
}

// ==================== DATA FUNCTIONS ====================
function escapeHtml(text) {
    if (!text) return '';
    return String(text).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#039;');
}

function getRoleBadge(role) {
    switch(role) {
        case 1: return '<span class="role-badge role-admin">ئەدمین</span>';
        case 2: return '<span class="role-badge role-casher">کاشێر</span>';
        default: return '<span class="role-badge role-unknown">نەناسراو</span>';
    }
}

function getRoleName(role) {
    switch(role) {
        case 1: return 'ئەدمین';
        case 2: return 'کاشێر';
        default: return 'نەناسراو';
    }
}

function loadUsers() {
    const search = $('#searchInput').val();
    
    $.ajax({
        url: '{{ route("users.list") }}',
        type: 'GET',
        data: { search: search },
        success: function(response) {
            if (response.success) {
                renderTable(response.users);
            } else {
                showAlert('error', response.message || 'هەڵەیەک ڕوویدا');
            }
        },
        error: function() {
            showAlert('error', 'هەڵەی پەیوەندی، تکایە دووبارە هەوڵبدەوە');
        }
    });
}

function renderTable(users) {
    if (!users || users.length === 0) {
        $('#table-content').html(`
            <div class="empty-state">
                <i class="fas fa-users-slash"></i>
                <h5>هیچ بەکارهێنەرێک نەدۆزرایەوە</h5>
                <p class="text-muted">بەکارهێنەرێکی نوێ زیاد بکە</p>
            </div>
        `);
        return;
    }
    
    let html = `
        <table class="data-table">
            <thead>
                <tr>
                    <th class="select-all-cell">
                        <input type="checkbox" id="selectAll" onchange="toggleSelectAll(this)">
                    </th>
                    <th>#</th>
                    <th>ناو</th>
                    <th>ئیمەیڵ</th>
                    <th>ڕۆڵ</th>
                    <th>بەرواری دروستکردن</th>
                    <th>دوایین نوێکردنەوە</th>
                    <th>کردارەکان</th>
                </tr>
            </thead>
            <tbody>`;
    
    users.forEach(function(user, index) {
        let roleButton = '';
        if (user.role == 1) { // Admin
            roleButton = `
                <button class="btn-icon btn-icon-role btn-make-casher" 
                    onclick="changeUserRole(${user.id}, '2', '${escapeHtml(user.name)}', 'ئەدمین', 'کاشێر')" 
                    title="گۆڕین بۆ کاشێر">
                    کاشێر
                </button>`;
        } else {
            roleButton = `
                <button class="btn-icon btn-icon-role btn-make-admin" 
                    onclick="changeUserRole(${user.id}, '1', '${escapeHtml(user.name)}', 'کاشێر', 'ئەدمین')" 
                    title="گۆڕین بۆ ئەدمین">
                    ئەدمین
                </button>`;
        }
        
        html += `
            <tr>
                <td class="select-all-cell">
                    <input type="checkbox" class="row-checkbox" value="${user.id}">
                </td>
                <td>${index + 1}</td>
                <td><span class="user-name">${escapeHtml(user.name)}</span></td>
                <td><span class="user-email">${escapeHtml(user.email)}</span></td>
                <td>${getRoleBadge(user.role)}</td>
                <td><span class="date-cell">${user.created_at || '-'}</span></td>
                <td><span class="date-cell">${user.updated_at || '-'}</span></td>
                <td>
                    <div class="action-buttons">
                        <button class="btn-icon btn-icon-edit" onclick="openEditModal(${user.id}, '${escapeHtml(user.name)}', '${escapeHtml(user.email)}', '${user.role}')" title="دەستکاری">
                            <i class="fas fa-edit"></i>
                        </button>
                       
                        <button class="btn-icon btn-icon-delete" onclick="deleteUserConfirm(${user.id}, '${escapeHtml(user.name)}')" title="سڕینەوە">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>`;
    });
    
    html += '</tbody></table>';
    $('#table-content').html(html);
}

function toggleSelectAll(checkbox) {
    $('.row-checkbox').prop('checked', checkbox.checked);
}

function getSelectedIds() {
    let ids = [];
    $('.row-checkbox:checked').each(function() {
        ids.push($(this).val());
    });
    return ids;
}

// ==================== USER ACTIONS ====================
function changeUserRole(userId, newRole, userName, oldRoleName, newRoleName) {
    showConfirm({
        title: 'گۆڕینی ڕۆڵی بەکارهێنەر',
        message: `ئایا دڵنیایت کە دەتەوێت ڕۆڵی ئەم بەکارهێنەرە بگۆڕیت؟`,
        iconType: 'info',
        confirmText: 'بەڵێ، بیگۆڕە',
        confirmClass: 'btn-confirm-primary',
        userInfo: {
            name: userName,
            roleChange: {
                from: oldRoleName,
                to: newRoleName
            }
        },
        onConfirm: function() {
            $.ajax({
                url: `{{ url('/users') }}/${userId}/role`,
                type: 'POST',
                data: { role: newRole },
                success: function(response) {
                    if (response.success) {
                        showAlert('success', `ڕۆڵی ${escapeHtml(userName)} بە سەرکەوتوویی گۆڕدرا بۆ ${newRoleName}`);
                        loadUsers();
                    } else {
                        showAlert('error', response.message || 'هەڵەیەک ڕوویدا');
                    }
                },
                error: function(xhr) {
                    let msg = 'هەڵەی پەیوەندی';
                    try { const res = JSON.parse(xhr.responseText); if (res.message) msg = res.message; } catch(e) {}
                    showAlert('error', msg);
                }
            });
        }
    });
}

function deleteUserConfirm(userId, userName) {
    showConfirm({
        title: 'سڕینەوەی بەکارهێنەر',
        message: `ئایا دڵنیایت کە دەتەوێت "${escapeHtml(userName)}" بسڕیتەوە؟`,
        iconType: 'danger',
        confirmText: 'بەڵێ، بیسڕەوە',
        confirmClass: 'btn-confirm-danger',
        warningMessage: 'ئاگاداری: ئەم کردارە هەڵنەگەڕێتەوە و هەموو زانیارییەکانی ئەم بەکارهێنەرە دەسڕێتەوە!',
        onConfirm: function() {
            $.ajax({
                url: `{{ url('/users') }}/${userId}`,
                type: 'DELETE',
                success: function(response) {
                    if (response.success) {
                        showAlert('success', `بەکارهێنەری ${escapeHtml(userName)} بە سەرکەوتوویی سڕایەوە`);
                        loadUsers();
                    } else {
                        showAlert('error', response.message || 'هەڵەیەک ڕوویدا');
                    }
                },
                error: function(xhr) {
                    let msg = 'هەڵەی پەیوەندی';
                    try { const res = JSON.parse(xhr.responseText); if (res.message) msg = res.message; } catch(e) {}
                    showAlert('error', msg);
                }
            });
        }
    });
}

function openAddModal() {
    isEditMode = false;
    $('#userId').val('');
    $('#userName').val('');
    $('#userEmail').val('');
    $('#userPassword').val('').attr('type', 'password');
    $('#userPassword').siblings('.password-toggle-btn').find('i').removeClass('fa-eye-slash').addClass('fa-eye');
    $('#userRole').val('');
    $('#userModalTitle').html('<i class="fas fa-user-plus"></i> زیادکردنی بەکارهێنەر');
    $('#saveBtn').html('<i class="fas fa-save"></i> تۆمارکردن');
    $('#passwordRequired').show();
    $('#passwordHint').hide();
    $('#userPassword').prop('required', true);
    userModal.show();
}

function openEditModal(id, name, email, role) {
    isEditMode = true;
    $('#userId').val(id);
    $('#userName').val(name);
    $('#userEmail').val(email);
    $('#userPassword').val('').attr('type', 'password');
    $('#userPassword').siblings('.password-toggle-btn').find('i').removeClass('fa-eye-slash').addClass('fa-eye');
    $('#userRole').val(role);
    $('#userModalTitle').html('<i class="fas fa-edit"></i> دەستکاری بەکارهێنەر');
    $('#saveBtn').html('<i class="fas fa-save"></i> نوێکردنەوە');
    $('#passwordRequired').hide();
    $('#passwordHint').show();
    $('#userPassword').prop('required', false);
    userModal.show();
}

function saveUser(e) {
    e.preventDefault();
    
    const id = $('#userId').val();
    const name = $('#userName').val().trim();
    const email = $('#userEmail').val().trim();
    const password = $('#userPassword').val();
    const role = $('#userRole').val();
    
    if (!name || !email || !role) {
        showAlert('warning', 'تکایە هەموو خانە پێویستەکان پڕبکەرەوە', 'زانیاری کەم');
        return;
    }
    
    if (!isEditMode && !password) {
        showAlert('warning', 'پاسۆرد پێویستە بۆ زیادکردنی بەکارهێنەر', 'پاسۆرد پێویستە');
        return;
    }
    
    const $btn = $('#saveBtn');
    const originalText = $btn.html();
    $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> چاوەڕێ بکە...');
    
    const url = isEditMode ? `{{ url('/users') }}/${id}` : '{{ route("users.store") }}';
    const method = isEditMode ? 'PUT' : 'POST';
    
    const data = { name, email, role };
    if (password) data.password = password;
    
    $.ajax({
        url: url,
        type: method,
        data: data,
        success: function(response) {
            if (response.success) {
                showAlert('success', isEditMode ? 'بەکارهێنەر بە سەرکەوتوویی نوێکرایەوە' : 'بەکارهێنەری نوێ بە سەرکەوتوویی زیادکرا');
                userModal.hide();
                loadUsers();
            } else {
                showAlert('error', response.message || 'هەڵەیەک ڕوویدا');
            }
        },
        error: function(xhr) {
            let msg = 'هەڵەی پەیوەندی';
            try {
                const res = JSON.parse(xhr.responseText);
                if (res.message) msg = res.message;
                if (res.errors) msg = Object.values(res.errors).flat().join('، ');
            } catch(e) {}
            showAlert('error', msg);
        },
        complete: function() {
            $btn.prop('disabled', false).html(originalText);
        }
    });
}

function bulkDelete() {
    const ids = getSelectedIds();
    if (ids.length === 0) {
        showAlert('warning', 'تکایە بەکارهێنەرێک هەڵبژێرە', 'هیچ هەڵنەبژێردراوە');
        return;
    }
    
    showConfirm({
        title: 'سڕینەوەی گروپی',
        message: `ئایا دڵنیایت کە دەتەوێت ${ids.length} بەکارهێنەر بسڕیتەوە؟`,
        iconType: 'danger',
        confirmText: 'بەڵێ، بیانسرەوە',
        confirmClass: 'btn-confirm-danger',
        warningMessage: `ئاگاداری: ئەم کردارە ${ids.length} بەکارهێنەر دەسڕێتەوە و هەڵنەگەڕێتەوە!`,
        onConfirm: function() {
            const $btn = $('.btn-bulk-delete');
            $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');
            
            $.ajax({
                url: '{{ route("users.bulk.delete") }}',
                type: 'POST',
                data: { ids: ids },
                success: function(response) {
                    if (response.success) {
                        showAlert('success', response.message);
                        $('#selectAll').prop('checked', false);
                        loadUsers();
                    } else {
                        showAlert('error', response.message || 'هەڵەیەک ڕوویدا');
                    }
                },
                error: function() {
                    showAlert('error', 'هەڵەی پەیوەندی، تکایە دووبارە هەوڵبدەوە');
                },
            
            });
        }
    });
}
</script>
@endsection