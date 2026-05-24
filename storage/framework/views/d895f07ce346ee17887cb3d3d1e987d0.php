<?php $__env->startSection('content'); ?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

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
        --morning: #f59e0b;
        --afternoon: #3b82f6;
        --night: #1e293b;
        --text: #1e293b;
        --border-color: #e2e8f0;
        --bg-light: #f8fafc;
        --transition-base: all 0.3s ease;
    }

    body {
        background: #f1f5f9;
        font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
        transition: background-color 0.3s ease, color 0.2s ease;
    }

    /* ========== DARK MODE STYLES ========== */
    body.dark-mode {
        background: #0f172a;
        --text: #e2e8f0;
        --border-color: #334155;
        --bg-light: #1e293b;
        --primary: #6c8db8;
    }

    /* ========== CUSTOM CONFIRMATION MODAL ========== */
    .custom-confirm-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.7);
        z-index: 99999;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: fadeInOverlay 0.3s ease;
        backdrop-filter: blur(4px);
    }

    @keyframes fadeInOverlay {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .custom-confirm-dialog {
        background: white;
        border-radius: 24px;
        padding: 2rem;
        max-width: 450px;
        width: 90%;
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.3);
        animation: slideUpDialog 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        text-align: center;
        direction: rtl;
    }

    body.dark-mode .custom-confirm-dialog {
        background: #1e293b;
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.5);
    }

    @keyframes slideUpDialog {
        from {
            opacity: 0;
            transform: translateY(30px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .confirm-icon-wrapper {
        width: 80px;
        height: 80px;
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

    body.dark-mode .confirm-icon-wrapper i {
        color: #fbbf24;
    }

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

    body.dark-mode .confirm-title {
        color: #e2e8f0;
    }

    .confirm-message {
        font-size: 0.95rem;
        color: #64748b;
        line-height: 1.6;
        margin-bottom: 0.5rem;
    }

    body.dark-mode .confirm-message {
        color: #94a3b8;
    }

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

    body.dark-mode .confirm-detail {
        color: #64748b;
    }

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
    .btn-confirm-cancel:active {
        transform: scale(0.97);
    }

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

    .autosave-indicator.show {
        display: block;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* فۆرمی پێدانی وردە بە کاشێر */
    .form-header-custom {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border-radius: 0.75rem 0.75rem 0 0 !important;
    }

    .form-logo-custom {
        background-color: white;
        width: 80px;
        height: 80px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        transition: background-color 0.3s ease;
    }

    body.dark-mode .form-logo-custom {
        background-color: #334155;
    }

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

    body.dark-mode .section-title-custom {
        border-bottom-color: #334155;
    }

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

    .casher-select-wrapper {
        position: relative;
    }

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

    .amount-input-wrapper {
        position: relative;
        margin-bottom: 1rem;
    }

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

    .amount-input::placeholder {
        color: #cbd5e1;
        font-size: 1rem;
    }

    body.dark-mode .amount-input::placeholder {
        color: #475569;
    }

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

    body.dark-mode .amount-currency {
        background: rgba(108, 141, 184, 0.2);
    }

    .amount-hint {
        font-size: 0.75rem;
        color: #94a3b8;
        text-align: center;
        margin-top: 0.5rem;
        transition: color 0.3s ease;
    }

    body.dark-mode .amount-hint {
        color: #64748b;
    }

    .amount-hint i {
        font-size: 0.7rem;
        margin-left: 0.25rem;
    }

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

    .submit-btn:disabled {
        opacity: 0.7;
        transform: none;
    }

    .casher-info {
        background: rgba(74, 100, 145, 0.05);
        border-radius: 12px;
        padding: 1rem;
        margin-top: 1rem;
        display: none;
        transition: background 0.3s ease;
    }

    body.dark-mode .casher-info {
        background: rgba(108, 141, 184, 0.1);
    }

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
        transition: border-color 0.3s ease;
    }

    body.dark-mode .casher-info-item {
        border-bottom-color: rgba(108, 141, 184, 0.2);
    }

    .casher-info-item:last-child {
        border-bottom: none;
    }

    .casher-info-label {
        font-size: 0.8rem;
        color: #64748b;
        transition: color 0.3s ease;
    }

    body.dark-mode .casher-info-label {
        color: #94a3b8;
    }

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

    body.dark-mode .card-body {
        color: #e2e8f0;
    }

    .custom-alert {
        border-radius: 12px;
        border: none;
        padding: 12px 16px;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        animation: slideDown 0.3s ease-out;
    }

    .alert-success-custom {
        background: rgba(16, 185, 129, 0.95);
        color: white;
    }

    .alert-error-custom {
        background: rgba(239, 68, 68, 0.95);
        color: white;
    }

    .alert-warning-custom {
        background: rgba(245, 158, 11, 0.95);
        color: white;
    }

    .alert-info-custom {
        background: rgba(59, 130, 246, 0.95);
        color: white;
    }

    body.dark-mode .alert-success-custom {
        background: rgba(16, 185, 129, 0.9);
    }

    body.dark-mode .alert-error-custom {
        background: rgba(239, 68, 68, 0.9);
    }

    body.dark-mode .alert-warning-custom {
        background: rgba(245, 158, 11, 0.9);
    }

    body.dark-mode .alert-info-custom {
        background: rgba(59, 130, 246, 0.9);
    }

    .alert-icon {
        font-size: 1.2rem;
        margin-left: 12px;
    }

    .alert-content {
        flex: 1;
    }

    .alert-message {
        font-size: 0.875rem;
    }

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

    .alert-close:hover {
        opacity: 1;
    }

    .validation-error {
        color: var(--danger);
        font-size: 0.75rem;
        margin-top: 0.25rem;
        display: none;
    }

    .is-invalid {
        border-color: var(--danger) !important;
    }

    body.dark-mode .text-white {
        color: #e2e8f0 !important;
    }

    body.dark-mode .opacity-75 {
        opacity: 0.85 !important;
    }

    body.dark-mode .small {
        color: #94a3b8 !important;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-5px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 768px) {
        .amount-input {
            font-size: 1.5rem;
            padding: 0.875rem 1rem 0.875rem 3.5rem;
        }

        .quick-amounts {
            gap: 0.5rem;
        }

        .quick-amount-btn {
            padding: 0.4rem 0.75rem;
            font-size: 0.75rem;
        }

        .custom-confirm-dialog {
            padding: 1.5rem;
        }

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
    }
</style>

<!-- Alert Container -->
<div id="alert-container" style="position: fixed; top: 20px; right: 20px; z-index: 9999; width: 320px;"></div>

<!-- Autosave Indicator -->


<!-- Custom Confirmation Overlay (Hidden by default) -->
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

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-11">
            <div class="card shadow-lg border-0 overflow-hidden">
                <!-- Form Header -->
                <div class="card-header form-header-custom text-white text-center py-4">
                    <div class="form-logo-custom">
                        <i class="fas fa-hand-holding-usd"></i>
                    </div>
                    <h1 class="h3 mb-1">پێدانی وردە بە کاشێر</h1>
                    <p class="mb-0 small opacity-75">دابینکردنی وردە بۆ کاشێرەکان بۆ کارکردنی ڕۆژانە</p>
                </div>

                <!-- Form Body -->
                <div class="card-body p-4">
                    <form id="coin-form" method="POST">
                        <?php echo csrf_field(); ?>

                        <!-- هەڵبژاردنی کاشێر -->
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

                                <!-- زانیاری کاشێر -->
                                <div id="casher-info" class="casher-info">
                                    <div class="casher-info-item">
                                        <span class="casher-info-label"><i class="fas fa-id-card ms-1"></i>ناسنامە:</span>
                                        <span class="casher-info-value" id="info-id">-</span>
                                    </div>
                                    <div class="casher-info-item">
                                        <span class="casher-info-label"><i class="fas fa-user ms-1"></i>ناو:</span>
                                        <span class="casher-info-value" id="info-name">-</span>
                                    </div>
                                    <div class="casher-info-item">
                                        <span class="casher-info-label"><i class="fas fa-envelope ms-1"></i>ئیمەیڵ:</span>
                                        <span class="casher-info-value" id="info-email">-</span>
                                    </div>
                                    <div class="casher-info-item">
                                        <span class="casher-info-label"><i class="fas fa-coins ms-1"></i>کۆی وردە پێدراوەکان:</span>
                                        <span class="casher-info-value" id="info-total">0</span>
                                    </div>
                                    <div class="casher-info-item">
                                        <span class="casher-info-label"><i class="fas fa-calendar ms-1"></i>دوایین وردە:</span>
                                        <span class="casher-info-value" id="info-last">-</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- بڕی وردە -->
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

                            <!-- بڕە خێراکان -->
                            <div class="quick-amounts">
                                <button type="button" class="quick-amount-btn" data-amount="5000">5,000</button>
                                <button type="button" class="quick-amount-btn" data-amount="10000">10,000</button>
                                <button type="button" class="quick-amount-btn" data-amount="25000">25,000</button>
                                <button type="button" class="quick-amount-btn" data-amount="50000">50,000</button>
                            </div>
                        </div>

                        <!-- دوگمەی پێدانی وردە -->
                        <button type="submit" class="submit-btn" id="submit-btn">
                            <i class="fas fa-hand-holding-usd ms-2"></i>
                            پێدانی وردە
                        </button>
                    </form>
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
    
    // ============================================
    // LOCAL STORAGE KEY
    // ============================================
    const STORAGE_KEY = 'casher_coin_form_data';
    
    // ============================================
    // LOCAL STORAGE FUNCTIONS
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
            console.log('💾 Form data saved to localStorage:', formData);
            
            // Show autosave indicator
            showAutosaveIndicator();
        } catch(e) {
            console.error('Error saving to localStorage:', e);
        }
    }
    
    function restoreFormFromLocalStorage() {
        const savedData = localStorage.getItem(STORAGE_KEY);
        if (!savedData) {
            console.log('📭 No saved data found in localStorage');
            return false;
        }
        
        try {
            isRestoring = true;
            const data = JSON.parse(savedData);
            
            // Check if data is older than 24 hours
            const now = new Date().getTime();
            const oneDay = 24 * 60 * 60 * 1000;
            if (now - (data.timestamp || 0) > oneDay) {
                console.log('⏰ Saved data is older than 24 hours, clearing...');
                clearLocalStorage();
                return false;
            }
            
            console.log('📥 Restoring form data from localStorage:', data);
            
            // Restore amount
            if (data.amount) {
                $('#amount').val(data.amount);
            }
            
            // We'll restore casher selection after the dropdown is populated
            // Store the casher_id for later use
            window._restoredCasherId = data.casher_id || null;
            
            return true;
        } catch(e) {
            console.error('Error restoring from localStorage:', e);
            return false;
        } finally {
            setTimeout(() => {
                isRestoring = false;
            }, 500);
        }
    }
    
    function clearLocalStorage() {
        localStorage.removeItem(STORAGE_KEY);
        window._restoredCasherId = null;
        console.log('🗑️ LocalStorage cleared');
    }
    
    function showAutosaveIndicator() {
        const $indicator = $('#autosave-indicator');
        $indicator.addClass('show');
        
        // Hide after 2 seconds
        setTimeout(() => {
            $indicator.fadeOut(300, function() {
                $(this).removeClass('show').show();
            });
        }, 2000);
    }
    
    function startAutosave() {
        // Save on input changes
        $('#amount').on('input', function() {
            if (!isRestoring) {
                saveFormToLocalStorage();
            }
        });
        
        $('#casher-select').on('change', function() {
            if (!isRestoring) {
                saveFormToLocalStorage();
            }
        });
        
        // Also save periodically every 5 seconds
        setInterval(() => {
            if (!isRestoring) {
                saveFormToLocalStorage();
            }
        }, 5000);
        
        console.log('🔄 Autosave started');
    }

    // ============================================
    // Custom Confirmation Dialog Functions
    // ============================================
    
    function showCustomConfirm(amount, casherName, callback) {
        $('#confirm-amount-display').text(amount + ' دینار');
        $('#confirm-casher-name').text(casherName);
        confirmCallback = callback;
        $('#custom-confirm-overlay').fadeIn(300);
        
        setTimeout(() => {
            $('#confirm-btn-cancel').focus();
        }, 400);
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
        if (confirmCallback) {
            confirmCallback(true);
        }
    });
    
    $('#confirm-btn-cancel').on('click', function() {
        hideCustomConfirm();
        if (confirmCallback) {
            confirmCallback(false);
        }
    });
    
    $('#custom-confirm-overlay').on('click', function(e) {
        if (e.target === this) {
            hideCustomConfirm();
            if (confirmCallback) {
                confirmCallback(false);
            }
        }
    });
    
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape' && $('#custom-confirm-overlay').is(':visible')) {
            hideCustomConfirm();
            if (confirmCallback) {
                confirmCallback(false);
            }
        }
        if (e.key === 'Enter' && $('#custom-confirm-overlay').is(':visible')) {
            hideCustomConfirm();
            if (confirmCallback) {
                confirmCallback(true);
            }
        }
    });

    function formatNumber(value) {
        if (!value && value !== 0) return '';
        return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }

    function unformatNumber(value) {
        return value.toString().replace(/,/g, '');
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

    function loadCashers() {
        $.ajax({
            url: '<?php echo e(route("casher.getData")); ?>',
            type: 'GET',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success && response.users) {
                    console.log('📊 Cashers loaded:', response.users);
                    $('#casher-select').empty();
                    $('#casher-select').append('<option value="">هەڵبژێرە</option>');

                    $.each(response.users, function(index, user) {
                        $('#casher-select').append(`
                            <option value="${user.id}">${user.name}</option>
                        `);
                    });
                    
                    console.log('✅ Cashers loaded:', response.users.length);

                    // Restore casher selection if available
                    if (window._restoredCasherId) {
                        const casherId = window._restoredCasherId;
                        // Check if the casher still exists in the dropdown
                        if ($('#casher-select option[value="' + casherId + '"]').length > 0) {
                            $('#casher-select').val(casherId);
                            loadCasherData(casherId);
                            console.log('🔄 Restored casher selection:', casherId);
                        } else {
                            console.log('⚠️ Saved casher no longer available');
                        }
                    } else if (response.users.length === 1) {
                        // Auto-select if only one casher
                        $('#casher-select').val(response.users[0].id);
                        loadCasherData(response.users[0].id);
                        saveFormToLocalStorage();
                    }
                } else {
                    $('#casher-select').empty();
                    $('#casher-select').append('<option value="">هیچ کاشێرێک نەدۆزرایەوە</option>');
                }
            },
            error: function(xhr, status, error) {
                showAlert('error', 'هەڵە لە هێنانی داتاکانی کاشێر');
                $('#casher-select').empty();
                $('#casher-select').append('<option value="">هەڵەی هێنانی داتا</option>');
            }
        });
    }

    function loadCasherData(casherId) {
        $.ajax({
            url: '/get-casher-details/' + casherId,
            type: 'GET',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success && response.casher) {
                    $('#info-id').text(response.casher.id);
                    $('#info-name').text(response.casher.name);
                    $('#info-email').text(response.casher.email);
                    $('#info-total').text(response.casher.total_coins || '0');
                    $('#info-last').text(response.casher.last_coin || '-');
                    $('#casher-info').addClass('show');
                
                } else {
                    $('#casher-info').removeClass('show');
                }
            },
            error: function(xhr, status, error) {
                $('#casher-info').removeClass('show');
            }
        });
    }

    function showAlert(type, message, duration = 3000) {
        let icon, alertClass;

        switch(type) {
            case 'success':
                icon = 'fas fa-check-circle';
                alertClass = 'alert-success-custom';
                break;
            case 'error':
                icon = 'fas fa-exclamation-circle';
                alertClass = 'alert-error-custom';
                break;
            case 'warning':
                icon = 'fas fa-exclamation-triangle';
                alertClass = 'alert-warning-custom';
                break;
            default:
                icon = 'fas fa-info-circle';
                alertClass = 'alert-info-custom';
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
            $(`#${alertId}`).fadeOut(300, function() {
                $(this).remove();
            });
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

    function submitCoinTransaction() {
        const casherId = $('#casher-select').val();
        const amountRaw = $('#amount').val();
        const amount = parseInt(unformatNumber(amountRaw));

        isSubmitting = true;
        const submitBtn = $('#submit-btn');
        const originalText = submitBtn.html();
        submitBtn.html('<i class="fas fa-spinner fa-spin ms-2"></i>تۆمار دەکرێت...').prop('disabled', true);

        $.ajax({
            url: '<?php echo e(route("casher.store")); ?>',
            type: 'POST',
            data: {
                casher_id: casherId,
                amount: amount,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    showAlert('success', response.message || 'وردەکە بە سەرکەوتوویی پێدرا');

                    if (casherId) {
                        loadCasherData(casherId);
                    }

                    // Clear amount after successful transaction
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
                        if (errors.hasOwnProperty(field)) {
                            showError(field, errors[field][0]);
                        }
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
            if (confirmed) {
                submitCoinTransaction();
            }
        });
    });

    $('#amount').keypress(function(e) {
        if (e.which === 13) {
            e.preventDefault();
            $('#coin-form').submit();
        }
    });
    
    // Quick amount buttons
    $('.quick-amount-btn').click(function() {
        const amount = $(this).data('amount');
        updateAmount(amount);
        $('#amount').focus();
    });

    // ============================================
    // INITIALIZATION
    // ============================================
    
    console.log('🚀 Initializing Casher Coin page...');
    
    // First restore saved data (this sets window._restoredCasherId)
    const hasSavedData = restoreFormFromLocalStorage();
    
    if (hasSavedData) {
        console.log('📥 Saved data found, will restore after cashers load');
    } else {
        console.log('📭 No saved data, starting fresh');
    }
    
    // Load cashers (will use window._restoredCasherId after load)
    loadCashers();
    
    // Start autosave
    startAutosave();
    
    // Focus on amount input after page loads
    setTimeout(() => {
        if (!$('#amount').val()) {
            $('#amount').focus();
        }
    }, 1000);
    
    console.log('✅ Initialization complete');
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamnp64\www\mobileHardy\resources\views/items/casher-coin.blade.php ENDPATH**/ ?>