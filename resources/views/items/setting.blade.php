@extends('layouts.navigation')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    /* ============================================
       DARK MODE - ڕێک و پاک
       ============================================ */
    
    body.dark-mode .card {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }
    
    body.dark-mode .card-header {
        background-color: #1e293b !important;
        border-bottom-color: #334155 !important;
    }
    
    body.dark-mode .card-header.bg-white,
    body.dark-mode .bg-white {
        background-color: #1e293b !important;
    }
    
    body.dark-mode .card-body {
        background-color: #1e293b !important;
    }
    
    body.dark-mode {
        background-color: #0f172a !important;
        color: #e2e8f0 !important;
    }
    
    body.dark-mode h1,
    body.dark-mode h2,
    body.dark-mode h3,
    body.dark-mode h4,
    body.dark-mode h5,
    body.dark-mode h6,
    body.dark-mode .fw-bold,
    body.dark-mode .fw-semibold,
    body.dark-mode .form-label {
        color: #e2e8f0 !important;
    }
    
    body.dark-mode .text-muted {
        color: #94a3b8 !important;
    }
    
    body.dark-mode small.text-muted {
        color: #94a3b8 !important;
    }
    
    /* خشتەکان */
    body.dark-mode .table {
        color: #e2e8f0 !important;
    }
    
    body.dark-mode .table-light {
        background-color: #1e293b !important;
    }
    
    body.dark-mode .table-light th {
        background-color: #1e293b !important;
        color: #e2e8f0 !important;
        border-bottom-color: #334155 !important;
    }
    
    body.dark-mode .table td {
        border-bottom-color: #334155 !important;
        color: #e2e8f0 !important;
        background-color: #1e293b !important;
    }
    
    body.dark-mode .table-hover tbody tr:hover {
        background-color: #334155 !important;
    }
    
    body.dark-mode .table-hover tbody tr:hover td {
        background-color: #334155 !important;
    }
    
    body.dark-mode .table-responsive {
        background-color: #1e293b !important;
    }
    
    /* ناوی بەکارهێنەر و ئیمەیڵ */
    body.dark-mode .user-name {
        color: #e2e8f0 !important;
    }
    
    body.dark-mode .user-email {
        color: #94a3b8 !important;
    }
    
    body.dark-mode .date-cell {
        color: #94a3b8 !important;
    }
    
    /* ئینپوت و سێلێکت */
    body.dark-mode .form-control,
    body.dark-mode .form-select {
        background-color: #334155 !important;
        color: #e2e8f0 !important;
        border-color: #475569 !important;
    }
    
    body.dark-mode .form-control:focus,
    body.dark-mode .form-select:focus {
        background-color: #334155 !important;
        color: #e2e8f0 !important;
        border-color: #4a6491 !important;
        box-shadow: 0 0 0 0.2rem rgba(74, 100, 145, 0.25) !important;
    }
    
    body.dark-mode .form-control::placeholder {
        color: #64748b !important;
    }
    
    body.dark-mode .form-select option {
        background-color: #1e293b !important;
        color: #e2e8f0 !important;
    }
    
    body.dark-mode .input-group-text {
        background-color: #334155 !important;
        color: #94a3b8 !important;
        border-color: #475569 !important;
    }
    
    body.dark-mode .input-group-text.bg-white {
        background-color: #334155 !important;
    }
    
    /* دوگمەکان */
    body.dark-mode .btn-light {
        background-color: #334155 !important;
        color: #e2e8f0 !important;
        border-color: #475569 !important;
    }
    
    body.dark-mode .btn-light:hover {
        background-color: #475569 !important;
    }
    
    body.dark-mode .btn-outline-secondary {
        color: #94a3b8 !important;
        border-color: #475569 !important;
    }
    
    body.dark-mode .btn-outline-secondary:hover {
        background-color: #334155 !important;
        color: #e2e8f0 !important;
    }
    
    body.dark-mode .btn-outline-danger {
        color: #ef4444 !important;
        border-color: #ef4444 !important;
    }
    
    body.dark-mode .btn-outline-danger:hover {
        background-color: #ef4444 !important;
        color: white !important;
    }
    
    /* مۆداڵ */
    body.dark-mode .modal-content {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }
    
    body.dark-mode .modal-header {
        border-bottom-color: #334155 !important;
    }
    
    body.dark-mode .modal-footer {
        border-top-color: #334155 !important;
    }
    
    body.dark-mode .modal-title {
        color: #e2e8f0 !important;
    }
    
    body.dark-mode .btn-close {
        filter: invert(1) grayscale(100%) brightness(200%);
    }
    
    body.dark-mode .modal-body p,
    body.dark-mode .modal-body div {
        color: #e2e8f0 !important;
    }
    
    /* بەیج و پیلەکان */
    body.dark-mode .badge.bg-secondary {
        background-color: #334155 !important;
        color: #e2e8f0 !important;
    }
    
    /* چێکبۆکس */
    body.dark-mode .form-check-input {
        background-color: #334155 !important;
        border-color: #475569 !important;
    }
    
    body.dark-mode .form-check-input:checked {
        background-color: #4a6491 !important;
        border-color: #4a6491 !important;
    }
    
    body.dark-mode .input-group-text i {
        color: #94a3b8 !important;
    }
    
    body.dark-mode .spinner-border {
        border-color: #334155;
        border-right-color: #4a6491;
    }
    
    body.dark-mode .empty-state {
        color: #94a3b8 !important;
    }
    
    body.dark-mode .empty-state i {
        color: #94a3b8 !important;
    }
    
    body.dark-mode #confirmModal .modal-content {
        background-color: #1e293b !important;
    }
    
    body.dark-mode #confirmModal .bg-light {
        background-color: #334155 !important;
        color: #e2e8f0 !important;
    }
    
    body.dark-mode #confirmModal .alert-warning {
        background-color: rgba(245, 158, 11, 0.1) !important;
        color: #fbbf24 !important;
        border-color: rgba(245, 158, 11, 0.3) !important;
    }
    
    body.dark-mode .bg-light {
        background-color: #334155 !important;
        color: #e2e8f0 !important;
    }
    
    body.dark-mode .bg-primary.bg-opacity-10 {
        background-color: rgba(74, 100, 145, 0.2) !important;
    }
    
    body.dark-mode ::-webkit-scrollbar {
        width: 8px;
    }
    
    body.dark-mode ::-webkit-scrollbar-track {
        background: #0f172a;
    }
    
    body.dark-mode ::-webkit-scrollbar-thumb {
        background: #475569;
        border-radius: 4px;
    }
    
    body.dark-mode ::-webkit-scrollbar-thumb:hover {
        background: #64748b;
    }
    
    body.dark-mode .table-hover tbody tr {
        transition: all 0.2s ease;
    }
    
    body.dark-mode .table-hover tbody tr:hover {
        background-color: #334155 !important;
        transform: translateX(-5px);
    }
    
    body.dark-mode .pagination .page-link {
        background-color: #334155 !important;
        color: #e2e8f0 !important;
        border-color: #475569 !important;
    }
    
    body.dark-mode .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #4a6491, #2c3e50) !important;
        color: white !important;
        border-color: #4a6491 !important;
    }
    
    body.dark-mode .pagination .page-item.disabled .page-link {
        color: #64748b !important;
        opacity: 0.5;
    }
                                    
    .aa { color: #ffffff; }
    .aaa { color: #ffffff; }

    /* ============================================
       ROLE BADGES
       ============================================ */
    .role-badge {
        padding: 0.35rem 0.75rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-block;
        white-space: nowrap;
    }

    .role-admin {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .role-casher {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
    }

    .role-unknown {
        background: #6c757d;
        color: white;
    }

    .user-name {
        font-weight: 600;
    }

    .user-email {
        font-size: 0.9rem;
    }

    .date-cell {
        font-size: 0.85rem;
        direction: ltr;
        display: inline-block;
    }

    /* ============================================
       ACTION BUTTONS
       ============================================ */
    .btn-icon {
        padding: 0.4rem 0.75rem;
        border-radius: 8px;
        border: 1px solid transparent;
        transition: all 0.2s ease;
        font-size: 0.875rem;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .btn-icon-edit {
        background: rgba(59, 130, 246, 0.1);
        color: #3b82f6;
        border-color: rgba(59, 130, 246, 0.2);
    }

    .btn-icon-edit:hover {
        background: #3b82f6;
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }

    .btn-icon-delete {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
        border-color: rgba(239, 68, 68, 0.2);
    }

    .btn-icon-delete:hover {
        background: #ef4444;
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .select-all-cell {
        width: 40px;
        text-align: center;
    }

    /* ============================================
       ALERT TOAST - DARK MODE COMPATIBLE
       ============================================ */
    .alert-toast {
        position: fixed;
        top: 20px;
        right: 20px;
        min-width: 350px;
        max-width: 450px;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        padding: 1.25rem;
        z-index: 99999;
        animation: slideInRight 0.4s ease;
        border-right: 4px solid;
        word-wrap: break-word;
        transition: background 0.3s ease, box-shadow 0.3s ease;
    }

    /* Light Mode Alert Colors */
    .alert-toast.alert-success {
        border-right-color: #10b981;
        background: linear-gradient(135deg, #f0fdf4, #dcfce7);
    }
    .alert-toast.alert-success .badge {
        background: #10b981 !important;
    }
    .alert-toast.alert-success h6 {
        color: #065f46;
    }
    .alert-toast.alert-success p {
        color: #047857;
    }

    .alert-toast.alert-error {
        border-right-color: #ef4444;
        background: linear-gradient(135deg, #fef2f2, #fee2e2);
    }
    .alert-toast.alert-error .badge {
        background: #ef4444 !important;
    }
    .alert-toast.alert-error h6 {
        color: #991b1b;
    }
    .alert-toast.alert-error p {
        color: #b91c1c;
    }

    .alert-toast.alert-warning {
        border-right-color: #f59e0b;
        background: linear-gradient(135deg, #fffbeb, #fef3c7);
    }
    .alert-toast.alert-warning .badge {
        background: #f59e0b !important;
    }
    .alert-toast.alert-warning h6 {
        color: #92400e;
    }
    .alert-toast.alert-warning p {
        color: #b45309;
    }

    .alert-toast.alert-info {
        border-right-color: #3b82f6;
        background: linear-gradient(135deg, #eff6ff, #dbeafe);
    }
    .alert-toast.alert-info .badge {
        background: #3b82f6 !important;
    }
    .alert-toast.alert-info h6 {
        color: #1e3a8a;
    }
    .alert-toast.alert-info p {
        color: #1d4ed8;
    }

    /* Dark Mode Alert Colors */
    body.dark-mode .alert-toast {
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.6);
        border: 1px solid #334155;
        border-right-width: 4px;
    }

    body.dark-mode .alert-toast.alert-success {
        border-right-color: #10b981;
        background: linear-gradient(135deg, #064e3b, #065f46);
    }
    body.dark-mode .alert-toast.alert-success .badge {
        background: #10b981 !important;
        color: #ffffff !important;
    }
    body.dark-mode .alert-toast.alert-success h6 {
        color: #a7f3d0 !important;
    }
    body.dark-mode .alert-toast.alert-success p {
        color: #6ee7b7 !important;
    }

    body.dark-mode .alert-toast.alert-error {
        border-right-color: #ef4444;
        background: linear-gradient(135deg, #7f1d1d, #991b1b);
    }
    body.dark-mode .alert-toast.alert-error .badge {
        background: #ef4444 !important;
        color: #ffffff !important;
    }
    body.dark-mode .alert-toast.alert-error h6 {
        color: #fecaca !important;
    }
    body.dark-mode .alert-toast.alert-error p {
        color: #fca5a5 !important;
    }

    body.dark-mode .alert-toast.alert-warning {
        border-right-color: #f59e0b;
        background: linear-gradient(135deg, #78350f, #92400e);
    }
    body.dark-mode .alert-toast.alert-warning .badge {
        background: #f59e0b !important;
        color: #ffffff !important;
    }
    body.dark-mode .alert-toast.alert-warning h6 {
        color: #fde68a !important;
    }
    body.dark-mode .alert-toast.alert-warning p {
        color: #fcd34d !important;
    }

    body.dark-mode .alert-toast.alert-info {
        border-right-color: #3b82f6;
        background: linear-gradient(135deg, #1e3a8a, #1e40af);
    }
    body.dark-mode .alert-toast.alert-info .badge {
        background: #3b82f6 !important;
        color: #ffffff !important;
    }
    body.dark-mode .alert-toast.alert-info h6 {
        color: #bfdbfe !important;
    }
    body.dark-mode .alert-toast.alert-info p {
        color: #93c5fd !important;
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

    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }

    @media (max-width: 576px) {
        .alert-toast {
            top: 10px;
            right: 10px;
            left: 10px;
            min-width: auto;
            max-width: none;
            padding: 1rem;
            font-size: 0.85rem;
        }
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
    }

    .table > :not(caption) > * > * {
        padding: 1rem 1.25rem;
        vertical-align: middle;
    }

    .table-hover tbody tr {
        transition: all 0.2s ease;
    }

    .table-hover tbody tr:hover {
        transform: translateX(-5px);
    }

    /* ============================================
       MOBILE RESPONSIVE
       ============================================ */
    @media (max-width: 768px) {
        .page-header-mobile {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 1rem;
        }

        .page-header-mobile .btn {
            width: 100%;
            justify-content: center;
        }

        .card-header .d-flex {
            flex-direction: column;
            align-items: stretch !important;
        }

        .card-header .input-group {
            max-width: 100% !important;
            width: 100%;
        }

        .card-header #bulkDeleteBtn {
            width: 100%;
        }

        .table-responsive {
            overflow-x: visible !important;
            background-color: transparent !important;
        }

        .table {
            display: block;
            white-space: normal;
        }

        .table thead {
            display: none;
        }

        .table tbody {
            display: block;
        }

        .table tbody tr {
            display: block;
            background: white;
            border-radius: 12px;
            margin-bottom: 12px;
            padding: 14px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        body.dark-mode .table tbody tr {
            background: #1e293b;
            border-color: #334155;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        }

        .table tbody tr:hover {
            background: white;
            transform: none;
        }

        body.dark-mode .table tbody tr:hover {
            background: #1e293b;
        }

        .table tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0 !important;
            border: none !important;
            border-bottom: 1px solid #e5e7eb !important;
            text-align: right;
            gap: 10px;
            font-size: 0.85rem;
            background: transparent !important;
        }

        body.dark-mode .table tbody td {
            border-bottom-color: #334155 !important;
            background: transparent !important;
        }

        .table tbody td:last-child {
            border-bottom: none !important;
            padding-top: 12px !important;
            margin-top: 8px;
            border-top: 1px solid #e5e7eb !important;
            justify-content: center;
        }

        body.dark-mode .table tbody td:last-child {
            border-top-color: #334155 !important;
        }

        .table tbody td::before {
            content: attr(data-label);
            font-weight: 700;
            font-size: 0.72rem;
            color: #4a6491;
            text-transform: uppercase;
            flex-shrink: 0;
            text-align: left;
        }

        body.dark-mode .table tbody td::before {
            color: #94a3b8;
        }

        .table tbody td:last-child::before {
            display: none;
        }

        .table tbody td[data-label="#"],
        .table tbody td.select-all-cell {
            display: none;
        }

        .table tbody td[data-label="ناو"] {
            font-size: 1rem;
            font-weight: 700;
            color: #4a6491;
            border-bottom: 2px solid #e5e7eb !important;
            padding-bottom: 12px !important;
            justify-content: center;
            text-align: center;
        }

        body.dark-mode .table tbody td[data-label="ناو"] {
            color: #93c5fd;
            border-bottom-color: #334155 !important;
        }

        .table tbody td[data-label="ناو"]::before {
            display: none;
        }

        .action-buttons {
            flex-direction: column;
            gap: 8px;
            width: 100%;
        }

        .btn-icon {
            width: 100%;
            justify-content: center;
            padding: 10px;
            font-size: 0.85rem;
        }

        .modal-dialog {
            margin: 0.5rem;
        }

        .modal-content {
            border-radius: 16px !important;
        }

        .modal-header {
            padding: 1rem !important;
        }

        .modal-body {
            padding: 1rem !important;
        }

        .modal-footer {
            flex-direction: column;
            gap: 8px;
        }

        .modal-footer .btn {
            width: 100%;
        }

        .date-cell {
            font-size: 0.75rem;
        }
    }

    @media (max-width: 480px) {
        .table tbody tr {
            padding: 12px;
            margin-bottom: 10px;
        }

        .table tbody td {
            font-size: 0.8rem;
            padding: 6px 0 !important;
        }

        .table tbody td::before {
            font-size: 0.68rem;
        }

        .table tbody td[data-label="ناو"] {
            font-size: 0.95rem;
        }

        .role-badge {
            font-size: 0.75rem;
            padding: 0.3rem 0.6rem;
        }
    }

    @media (max-width: 576px) {
        input, select, textarea {
            font-size: 16px !important;
        }
    }

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

<div class="container-fluid py-4">
    <!-- Alert Container -->
    <div id="alert-container" class="position-fixed top-0 end-0 p-3" style="z-index: 99999;"></div>
    
    <!-- Confirm Container -->
    <div id="confirm-container"></div>

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 page-header-mobile">
        <div class="d-flex align-items-center">
            <div class="bg-primary bg-opacity-10 rounded-3 p-3 me-3">
                <i class="fas fa-users-cog text-primary fs-4"></i>
            </div>
            <div>
                <h2 class="aa mb-1 me-4">ڕێکخستنەکانی بەکارهێنەران</h2>
                <p class="aaa mb-0 me-4">بەڕێوەبردنی بەکارهێنەران و ڕۆڵەکانیان</p>
            </div>
        </div>
        <button class="btn btn-primary btn-lg rounded-3 shadow-sm" onclick="openAddModal()">
            <i class="fas fa-user-plus me-2"></i>
            زیادکردنی بەکارهێنەر
        </button>
    </div>

    <!-- Users Table Card -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 py-3 px-4 rounded-top-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="fw-bold mb-0">
                    <i class="fas fa-list text-primary me-2"></i>
                    لیستی بەکارهێنەران
                </h5>
                <div class="d-flex gap-3 align-items-center flex-wrap">
                    <div class="input-group shadow-sm" style="max-width: 300px;">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" id="searchInput" class="form-control border-start-0 ps-0" 
                               placeholder="گەڕان بە ناو یان ئیمەیڵ...">
                    </div>
                    <button class="btn btn-outline-danger rounded-3" onclick="bulkDelete()" id="bulkDeleteBtn" style="display: none;">
                        <i class="fas fa-trash-alt me-2"></i>
                        سڕینەوەی گروپی
                    </button>
                </div>
            </div>
        </div>
        
        <div class="card-body p-0">
            <div id="table-content" class="p-4">
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-3 text-muted">بارکردنی زانیاری...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- User Modal -->
<div class="modal fade" id="userModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="userModalTitle">
                    <i class="fas fa-user-plus me-2"></i>
                    زیادکردنی بەکارهێنەر
                </h5>
            </div>
            <div class="modal-body pt-3">
                <form id="userForm" onsubmit="saveUser(event)">
                    <input type="hidden" id="userId">
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">ناوی بەکارهێنەر <span class="text-danger">*</span></label>
                        <input type="text" id="userName" class="form-control rounded-3" placeholder="ناو بنووسە..." required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">ئیمەیڵ <span class="text-danger">*</span></label>
                        <input type="email" id="userEmail" class="form-control rounded-3" placeholder="example@email.com" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            پاسۆرد <span class="text-danger" id="passwordRequired">*</span>
                        </label>
                        <div class="input-group">
                            <input type="password" id="userPassword" class="form-control rounded-3" 
                                   placeholder="پاسۆرد بنووسە...">
                            <button type="button" class="btn btn-outline-secondary rounded-3 ms-2" 
                                    onclick="togglePasswordVisibility('userPassword', this)" 
                                    title="نیشاندانی پاسۆرد">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <small class="text-muted" id="passwordHint" style="display: none;">
                            بەتاڵ بەجێبهێڵە ئەگەر ناتەوێت بیگۆڕیت
                        </small>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-semibold">ڕۆڵ <span class="text-danger">*</span></label>
                        <select id="userRole" class="form-select rounded-3" required>
                            <option value="">ڕۆڵ هەڵبژێرە...</option>
                            <option value="1">ئەدمین (Admin)</option>
                            <option value="2">کاشێر (Casher)</option>
                        </select>
                    </div>
                    
                    <div class="d-flex justify-content-end gap-2 modal-footer-mobile">
                        <button type="button" class="btn btn-light rounded-3 px-4" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>
                            پاشگەزبوونەوە
                        </button>
                        <button type="submit" class="btn btn-primary rounded-3 px-4" id="saveBtn">
                            <i class="fas fa-save me-2"></i>
                            تۆمارکردن
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
let isEditMode = false;
let userModal;

$(document).ready(function() {
    userModal = new bootstrap.Modal(document.getElementById('userModal'));
    
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });
    
    loadUsers();
    
    let searchTimeout;
    $('#searchInput').on('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => loadUsers(), 300);
    });
    
    $(document).on('click', '.alert-close-btn', function() {
        $(this).closest('.alert-toast').fadeOut(300, function() { $(this).remove(); });
    });
    
    $(document).on('change', '.row-checkbox, #selectAll', function() {
        const selectedCount = $('.row-checkbox:checked').length;
        if (selectedCount > 0) {
            $('#bulkDeleteBtn').fadeIn(300);
        } else {
            $('#bulkDeleteBtn').fadeOut(300);
        }
    });
});

function openUserModal() {
    userModal.show();
}

function closeUserModal() {
    userModal.hide();
    $('#userForm')[0].reset();
}

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
    
    const alertTitle = title || defaultTitle;
    const uniqueId = 'alert-' + Date.now() + '-' + Math.floor(Math.random() * 1000);
    
    const alertHtml = `
        <div class="alert-toast ${alertClass}" id="${uniqueId}">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="badge px-3 py-2 rounded-pill">${badgeText}</span>
            </div>
            <h6 class="fw-bold mb-1">${escapeHtml(alertTitle)}</h6>
            <p class="mb-0" style="font-size: 0.9rem;">${escapeHtml(message)}</p>
        </div>
    `;
    
    $('#alert-container').append(alertHtml);
    
    if (duration > 0) {
        setTimeout(() => {
            $('#' + uniqueId).css('animation', 'slideOutRight 0.3s ease forwards');
            setTimeout(() => {
                $('#' + uniqueId).remove();
            }, 300);
        }, duration);
    }
}

function showConfirm(options) {
    const {
        title = 'پشتڕاستکردنەوە',
        message = '',
        iconType = 'warning',
        confirmText = 'بەڵێ',
        cancelText = 'پاشگەزبوونەوە',
        confirmClass = 'btn-primary',
        userInfo = null,
        warningMessage = null,
        onConfirm = null,
        onCancel = null
    } = options;
    
    let iconClass = 'fa-exclamation-triangle text-warning';
    if (iconType === 'danger') iconClass = 'fa-trash-alt text-danger';
    else if (iconType === 'info') iconClass = 'fa-info-circle text-primary';
    
    let userInfoHtml = '';
    if (userInfo) {
        userInfoHtml = `
            <div class="bg-light rounded-3 p-3 mb-3">
                <div class="fw-bold fs-5">${escapeHtml(userInfo.name || '')}</div>
                ${userInfo.roleChange ? `
                    <div class="mt-2">
                        <span class="badge bg-secondary">${escapeHtml(userInfo.roleChange.from)}</span>
                        <i class="fas fa-arrow-right mx-2 text-muted"></i>
                        <span class="badge bg-primary">${escapeHtml(userInfo.roleChange.to)}</span>
                    </div>
                ` : ''}
            </div>
        `;
    }
    
    let warningHtml = '';
    if (warningMessage) {
        warningHtml = `
            <div class="alert alert-warning rounded-3 mt-3">
                <i class="fas fa-exclamation-triangle me-2"></i>
                ${escapeHtml(warningMessage)}
            </div>
        `;
    }
    
    const confirmHtml = `
        <div class="modal fade" id="confirmModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg rounded-4">
                    <div class="modal-header border-0">
                        <h5 class="modal-title fw-bold">
                            <i class="fas ${iconClass} me-2"></i>
                            ${escapeHtml(title)}
                        </h5>
                    </div>
                    <div class="modal-body">
                        <p class="text-muted">تکایە پشتڕاستی بکەرەوە</p>
                        ${userInfoHtml}
                        <p>${escapeHtml(message)}</p>
                        ${warningHtml}
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light rounded-3 px-4" id="confirm-cancel-btn">
                            <i class="fas fa-times me-2"></i>
                            ${escapeHtml(cancelText)}
                        </button>
                        <button type="button" class="btn ${confirmClass} rounded-3 px-4" id="confirm-ok-btn">
                            <i class="fas fa-check me-2"></i>
                            ${escapeHtml(confirmText)}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    $('#confirm-container').html(confirmHtml);
    const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
    confirmModal.show();
    
    $('#confirm-cancel-btn').on('click', function() {
        confirmModal.hide();
        if (onCancel) onCancel();
    });
    
    $('#confirm-ok-btn').on('click', function() {
        confirmModal.hide();
        if (onConfirm) onConfirm();
    });
    
    $('#confirmModal').on('hidden.bs.modal', function() {
        $(this).remove();
    });
}

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
                <i class="fas fa-users-slash fs-1 text-muted"></i>
                <h5 class="mt-3">هیچ بەکارهێنەرێک نەدۆزرایەوە</h5>
                <p class="text-muted">بەکارهێنەرێکی نوێ زیاد بکە</p>
            </div>
        `);
        return;
    }
    
    let html = `
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="select-all-cell">
                            <input type="checkbox" class="form-check-input" id="selectAll" onchange="toggleSelectAll(this)">
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
        html += `
            <tr>
                <td class="select-all-cell" data-label="هەڵبژاردن">
                    <input type="checkbox" class="row-checkbox form-check-input" value="${user.id}">
                </td>
                <td data-label="#">${index + 1}</td>
                <td data-label="ناو"><span class="user-name">${escapeHtml(user.name)}</span></td>
                <td data-label="ئیمەیڵ"><span class="user-email">${escapeHtml(user.email)}</span></td>
                <td data-label="ڕۆڵ">${getRoleBadge(user.role)}</td>
                <td data-label="بەرواری دروستکردن"><span class="date-cell">${user.created_at || '-'}</span></td>
                <td data-label="دوایین نوێکردنەوە"><span class="date-cell">${user.updated_at || '-'}</span></td>
                <td data-label="کردارەکان">
                    <div class="action-buttons">
                        <button class="btn-icon btn-icon-edit" 
                            onclick="openEditModal(${user.id}, '${escapeHtml(user.name)}', '${escapeHtml(user.email)}', '${user.role}')" 
                            title="دەستکاری">
                            <i class="fas fa-edit"></i> دەستکاری
                        </button>
                        <button class="btn-icon btn-icon-delete" 
                            onclick="deleteUserConfirm(${user.id}, '${escapeHtml(user.name)}')" 
                            title="سڕینەوە">
                            <i class="fas fa-trash"></i> سڕینەوە
                        </button>
                    </div>
                </td>
            </tr>`;
    });
    
    html += '</tbody></table></div>';
    $('#table-content').html(html);
}

function toggleSelectAll(checkbox) {
    $('.row-checkbox').prop('checked', checkbox.checked);
    if (checkbox.checked) {
        $('#bulkDeleteBtn').fadeIn(300);
    } else {
        $('#bulkDeleteBtn').fadeOut(300);
    }
}

function getSelectedIds() {
    let ids = [];
    $('.row-checkbox:checked').each(function() {
        ids.push($(this).val());
    });
    return ids;
}

function changeUserRole(userId, newRole, userName, oldRoleName, newRoleName) {
    showConfirm({
        title: 'گۆڕینی ڕۆڵی بەکارهێنەر',
        message: `ئایا دڵنیایت کە دەتەوێت ڕۆڵی ئەم بەکارهێنەرە بگۆڕیت؟`,
        iconType: 'info',
        confirmText: 'بەڵێ، بیگۆڕە',
        confirmClass: 'btn-primary',
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
        confirmClass: 'btn-danger',
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
    $('#userRole').val('');
    $('#userModalTitle').html('<i class="fas fa-user-plus me-2"></i> زیادکردنی بەکارهێنەر');
    $('#saveBtn').html('<i class="fas fa-save me-2"></i> تۆمارکردن');
    $('#passwordRequired').show();
    $('#passwordHint').hide();
    $('#userPassword').prop('required', true);
    
    const toggleBtn = $('#userPassword').siblings('button');
    if (toggleBtn.length) {
        toggleBtn.find('i').removeClass('fa-eye-slash').addClass('fa-eye');
    }
    
    openUserModal();
}

function openEditModal(id, name, email, role) {
    isEditMode = true;
    $('#userId').val(id);
    $('#userName').val(name);
    $('#userEmail').val(email);
    $('#userPassword').val('').attr('type', 'password');
    $('#userRole').val(role);
    $('#userModalTitle').html('<i class="fas fa-edit me-2"></i> دەستکاری بەکارهێنەر');
    $('#saveBtn').html('<i class="fas fa-save me-2"></i> نوێکردنەوە');
    $('#passwordRequired').hide();
    $('#passwordHint').show();
    $('#userPassword').prop('required', false);
    
    const toggleBtn = $('#userPassword').siblings('button');
    if (toggleBtn.length) {
        toggleBtn.find('i').removeClass('fa-eye-slash').addClass('fa-eye');
    }
    
    openUserModal();
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
    $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span> چاوەڕێ بکە...');
    
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
                closeUserModal();
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
        confirmClass: 'btn-danger',
        warningMessage: `ئاگاداری: ئەم کردارە ${ids.length} بەکارهێنەر دەسڕێتەوە و هەڵنەگەڕێتەوە!`,
        onConfirm: function() {
            $.ajax({
                url: '{{ route("users.bulk.delete") }}',
                type: 'POST',
                data: { ids: ids },
                success: function(response) {
                    if (response.success) {
                        showAlert('success', response.message);
                        $('#selectAll').prop('checked', false);
                        $('#bulkDeleteBtn').fadeOut(300);
                        loadUsers();
                    } else {
                        showAlert('error', response.message || 'هەڵەیەک ڕوویدا');
                    }
                },
                error: function() {
                    showAlert('error', 'هەڵەی پەیوەندی، تکایە دووبارە هەوڵبدەرەوە');
                }
            });
        }
    });
}
</script>
@endsection