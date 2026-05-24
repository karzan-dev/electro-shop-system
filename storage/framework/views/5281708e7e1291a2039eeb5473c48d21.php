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

    .container {
        max-width: 1400px;
    }

    /* Summary Cards */
    .summary-card {
        background: white;
        border-radius: 1rem;
        padding: 1.5rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border-right: 4px solid transparent;
        height: 100%;
    }

    body.dark-mode .summary-card {
        background: #1e293b;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .summary-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    }

    .summary-card.total-sales {
        border-right-color: var(--info);
    }

    .summary-card.returns {
        border-right-color: var(--danger);
    }

    .summary-card.discounts {
        border-right-color: var(--warning);
    }

    .summary-card.net-returns {
        border-right-color: var(--return);
    }

    .summary-card.profit {
        border-right-color: var(--success);
    }

    .summary-card.cash-status {
        border-right-color: var(--morning);
    }

    .summary-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }

    .summary-icon.sales-icon {
        background: rgba(59, 130, 246, 0.1);
        color: var(--info);
    }

    .summary-icon.returns-icon {
        background: rgba(239, 68, 68, 0.1);
        color: var(--danger);
    }

    .summary-icon.discounts-icon {
        background: rgba(245, 158, 11, 0.1);
        color: var(--warning);
    }

    .summary-icon.net-returns-icon {
        background: rgba(139, 92, 246, 0.1);
        color: var(--return);
    }

    .summary-icon.profit-icon {
        background: rgba(16, 185, 129, 0.1);
        color: var(--success);
    }

    .summary-icon.cash-icon {
        background: rgba(245, 158, 11, 0.1);
        color: var(--morning);
    }

    .summary-label {
        font-size: 0.85rem;
        color: #64748b;
        margin-bottom: 0.25rem;
    }

    body.dark-mode .summary-label {
        color: #94a3b8;
    }

    .summary-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--text);
    }

    body.dark-mode .summary-value {
        color: #e2e8f0;
    }

    .summary-value.negative {
        color: var(--danger);
    }

    .summary-value.positive {
        color: var(--success);
    }

    /* Form Card */
    .form-card {
        background: white;
        border-radius: 1rem;
        padding: 2rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        margin-bottom: 1.5rem;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    body.dark-mode .form-card {
        background: #1e293b;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .form-header {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border-radius: 0.75rem 0.75rem 0 0 !important;
    }

    .form-logo {
        background-color: white;
        width: 70px;
        height: 70px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
    }

    body.dark-mode .form-logo {
        background-color: #334155;
    }

    .form-logo i {
        font-size: 2rem;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .section-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 1.2rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--secondary);
    }

    body.dark-mode .section-title {
        color: #94a3b8;
        border-bottom-color: #334155;
    }

    .form-label {
        font-weight: 600;
        color: var(--secondary);
        margin-bottom: 0.5rem;
    }

    body.dark-mode .form-label {
        color: #94a3b8;
    }

    .form-control, .form-select {
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        padding: 0.7rem 1rem;
        transition: all 0.3s;
        background-color: white;
        color: #1e293b;
    }

    body.dark-mode .form-control,
    body.dark-mode .form-select {
        background-color: #0f172a;
        border-color: #334155;
        color: #e2e8f0;
    }

    body.dark-mode .form-control::placeholder {
        color: #64748b;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary);
        outline: none;
        box-shadow: 0 0 0 3px rgba(74,100,145,0.2);
    }

    body.dark-mode .form-control:focus,
    body.dark-mode .form-select:focus {
        box-shadow: 0 0 0 3px rgba(74,100,145,0.3);
    }

    .input-group-text {
        background: var(--bg-light);
        border: 2px solid #e5e7eb;
        border-left: none;
        border-radius: 0 10px 10px 0;
        color: #64748b;
    }

    body.dark-mode .input-group-text {
        background: #0f172a;
        border-color: #334155;
        color: #94a3b8;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.75rem 2rem;
        border-radius: 30px;
        transition: all 0.3s ease;
        font-size: 1rem;
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(74, 100, 145, 0.4);
        color: white;
    }

    .btn-secondary-custom {
        background: #6b7280;
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.75rem 2rem;
        border-radius: 30px;
        transition: all 0.3s ease;
    }

    .btn-secondary-custom:hover {
        background: #4b5563;
        color: white;
    }

    .btn-success-custom {
        background: linear-gradient(135deg, var(--success), #059669);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.75rem 2rem;
        border-radius: 30px;
        transition: all 0.3s ease;
    }

    .btn-success-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
        color: white;
    }

    /* Alert Styles */
    .alert-custom {
        border-radius: 12px;
        padding: 1rem 1.2rem;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.8rem;
        animation: slideDown 0.3s ease-out;
    }

    .alert-success-custom {
        background: #d1fae5;
        color: #065f46;
        border-right: 4px solid var(--success);
    }

    body.dark-mode .alert-success-custom {
        background: #064e3b;
        color: #d1fae5;
    }

    .alert-error-custom {
        background: #fee2e2;
        color: #991b1b;
        border-right: 4px solid var(--danger);
    }

    body.dark-mode .alert-error-custom {
        background: #7f1d1d;
        color: #fee2e2;
        border-right-color: #ef4444;
    }

    .alert-warning-custom {
        background: #fed7aa;
        color: #92400e;
        border-right: 4px solid var(--warning);
    }

    body.dark-mode .alert-warning-custom {
        background: #78350f;
        color: #fed7aa;
        border-right-color: #f59e0b;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Cash Status Indicator */
    .cash-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .cash-status-balanced {
        background: #d1fae5;
        color: #065f46;
    }

    body.dark-mode .cash-status-balanced {
        background: #064e3b;
        color: #d1fae5;
    }

    .cash-status-shortage {
        background: #fee2e2;
        color: #991b1b;
    }

    body.dark-mode .cash-status-shortage {
        background: #7f1d1d;
        color: #fee2e2;
    }

    .cash-status-surplus {
        background: #dbeafe;
        color: #1e40af;
    }

    body.dark-mode .cash-status-surplus {
        background: #1e3a5f;
        color: #dbeafe;
    }

    /* Loading Spinner */
    .loading-spinner {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 3px solid rgba(255,255,255,0.3);
        border-radius: 50%;
        border-top-color: white;
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .summary-value {
            font-size: 1.3rem;
        }
        .summary-card {
            padding: 1rem;
        }
    }

    .card {
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    body.dark-mode .card {
        background-color: #1e293b !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2) !important;
    }

    body.dark-mode .card-header {
        background: linear-gradient(135deg, #4a6491, #2c3e50) !important;
    }

    body.dark-mode .text-muted {
        color: #94a3b8 !important;
    }
</style>

<!-- Alert Container -->
<div id="alert-container" style="position: fixed; top: 20px; right: 20px; z-index: 9999; width: 350px;"></div>

<div class="container py-4">
    <!-- Page Header -->
    <div class="card shadow-sm mb-4 border-0 rounded-4 overflow-hidden">
        <div class="card-header form-header text-white text-center py-4">
            <div class="form-logo">
                <i class="fas fa-calculator"></i>
            </div>
            <h1 class="h2 mb-2">پوختەی حساباتی ڕۆژانە</h1>
            <p class="mb-0 opacity-75">کۆکردنەوە و تۆمارکردنی هەموو فرۆش و گەڕاوەکانی ڕۆژ</p>
        </div>
    </div>

    <!-- Top Summary Cards -->
    <div class="row g-3 mb-4" id="summary-cards-container">
        <div class="col-md-4 col-lg-2">
            <div class="summary-card total-sales">
                <div class="summary-icon sales-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="summary-label">کۆی فرۆشی ڕۆژ</div>
                <div class="summary-value" id="total-sales">0 د.ع</div>
            </div>
        </div>
        <div class="col-md-4 col-lg-2">
            <div class="summary-card returns">
                <div class="summary-icon returns-icon">
                    <i class="fas fa-undo-alt"></i>
                </div>
                <div class="summary-label">کۆی گەڕاوەی فرۆش</div>
                <div class="summary-value" id="total-returns">0 د.ع</div>
            </div>
        </div>
        <div class="col-md-4 col-lg-2">
            <div class="summary-card discounts">
                <div class="summary-icon discounts-icon">
                    <i class="fas fa-tags"></i>
                </div>
                <div class="summary-label">کۆی داشکاندن</div>
                <div class="summary-value" id="total-discounts">0 د.ع</div>
            </div>
        </div>
        <div class="col-md-4 col-lg-2">
            <div class="summary-card net-returns">
                <div class="summary-icon net-returns-icon">
                    <i class="fas fa-exchange-alt"></i>
                </div>
                <div class="summary-label">صافی گەڕاوە</div>
                <div class="summary-value" id="net-returns">0 د.ع</div>
            </div>
        </div>
        <div class="col-md-4 col-lg-2">
            <div class="summary-card profit">
                <div class="summary-icon profit-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="summary-label">بڕی قازانجی ئەمڕۆ</div>
                <div class="summary-value" id="daily-profit">0 د.ع</div>
            </div>
        </div>
        <div class="col-md-4 col-lg-2">
            <div class="summary-card cash-status">
                <div class="summary-icon cash-icon">
                    <i class="fas fa-wallet"></i>
                </div>
                <div class="summary-label">ڕەوشی حساب</div>
                <div class="summary-value" id="cash-status-display">--</div>
            </div>
        </div>
    </div>

    <!-- Main Form -->
    <div class="form-card">
        <form id="daily-summary-form">
            <?php echo csrf_field(); ?>
            
            <!-- Cashier & Date Selection -->
            <div class="mb-4">
                <h3 class="section-title">
                    <i class="fas fa-user-tie ms-2"></i>زانیاری کاشێر و بەروار
                </h3>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label" for="cashier-select">
                            <span class="text-danger">*</span> ناوی کاشێر
                        </label>
                        <select class="form-select" id="cashier-select" name="cashier_id" required>
                            <option value="">هەڵبژێرە</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="summary-date">
                            <span class="text-danger">*</span> بەرواری حساباتی
                        </label>
                        <input type="text" class="form-control" id="summary-date" name="summary_date" 
                               placeholder="MM/DD/YYYY" readonly>
                    </div>
                </div>
            </div>

            <!-- Sales & Returns -->
            <div class="mb-4">
                <h3 class="section-title">
                    <i class="fas fa-receipt ms-2"></i>فرۆش و گەڕاوە
                </h3>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label" for="total-sales-input">
                            <span class="text-danger">*</span> کۆی فرۆشی ڕۆژ (دینار)
                        </label>
                        <input type="text" class="form-control" id="total-sales-input" 
                               name="total_sales" placeholder="0" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="total-returns-input">
                            کۆی گەڕاوەی فرۆش (دینار)
                        </label>
                        <input type="text" class="form-control" id="total-returns-input" 
                               name="total_returns" placeholder="0">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="total-discounts-input">
                            کۆی داشکاندن (دینار)
                        </label>
                        <input type="text" class="form-control" id="total-discounts-input" 
                               name="total_discounts" placeholder="0">
                    </div>
                </div>
            </div>

            <!-- Cash Details -->
            <div class="mb-4">
                <h3 class="section-title">
                    <i class="fas fa-money-bill-wave ms-2"></i>وردەکاری پارە
                </h3>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label" for="given-cash-input">
                            وردەی پێدراو (دینار)
                        </label>
                        <input type="text" class="form-control" id="given-cash-input" 
                               name="given_cash" placeholder="0">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">ڕەوشی حساب</label>
                        <div>
                            <select class="form-select" id="cash-status-select" name="cash_status">
                                <option value="">هەڵبژێرە</option>
                                <option value="balanced">هاوسەنگ</option>
                                <option value="shortage">کەمی</option>
                                <option value="surplus">زیادە</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row g-3 mt-2" id="cash-difference-section" style="display: none;">
                    <div class="col-md-6" id="shortage-container" style="display: none;">
                        <label class="form-label" for="shortage-amount-input">
                            بڕی کەمی لە حسابدا (دینار)
                        </label>
                        <input type="text" class="form-control" id="shortage-amount-input" 
                               name="shortage_amount" placeholder="0">
                    </div>
                    <div class="col-md-6" id="surplus-container" style="display: none;">
                        <label class="form-label" for="surplus-amount-input">
                            بڕی زیادە لە حسابدا (دینار)
                        </label>
                        <input type="text" class="form-control" id="surplus-amount-input" 
                               name="surplus_amount" placeholder="0">
                    </div>
                </div>
            </div>

            <!-- Calculated Summary -->
            <div class="mb-4 p-3 rounded-3" style="background: rgba(74, 100, 145, 0.05);">
                <h3 class="section-title">
                    <i class="fas fa-calculator ms-2"></i>پوختەی ژمێریاری
                </h3>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">صافی فرۆش:</span>
                            <strong id="net-sales-display">0 د.ع</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">صافی گەڕاوە:</span>
                            <strong id="net-returns-display">0 د.ع</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">بڕی قازانج:</span>
                            <strong id="profit-display" class="text-success">0 د.ع</strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex gap-3 justify-content-center flex-wrap">
                <button type="button" class="btn btn-secondary-custom" id="reset-form-btn">
                    <i class="fas fa-undo-alt me-2"></i> ڕێکخستنەوە
                </button>
                <button type="button" class="btn btn-primary-custom" id="calculate-summary-btn">
                    <i class="fas fa-calculator me-2"></i> ژمێریاری بکە
                </button>
                <button type="submit" class="btn btn-success-custom" id="save-summary-btn" disabled>
                    <i class="fas fa-save me-2"></i> تۆمارکردنی پوختە
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    
    // ============================================
    // Variables
    // ============================================
    let calculatedData = null;
    
    // CSRF Token setup
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // ============================================
    // Helper Functions
    // ============================================
    
    function formatNumberToIQD(value) {
        if (!value && value !== 0) return '0';
        let num = parseFloat(value);
        if (isNaN(num)) return '0';
        return num.toLocaleString('en-US');
    }

    function removeThousandSeparators(value) {
        if (!value) return '';
        return value.toString().replace(/,/g, '');
    }

    function parseNumericValue(value) {
        let cleaned = removeThousandSeparators(value);
        let parsed = parseFloat(cleaned);
        return isNaN(parsed) ? 0 : parsed;
    }

    function escapeHtml(text) {
        if (!text) return '';
        return String(text).replace(/[&<>]/g, function(m) {
            if (m === '&') return '&amp;';
            if (m === '<') return '&lt;';
            if (m === '>') return '&gt;';
            return m;
        });
    }

    function showAlert(type, title, message, duration = 4000) {
        let icon, alertClass;
        switch(type) {
            case 'success': icon = 'fas fa-check-circle'; alertClass = 'alert-success-custom'; break;
            case 'error': icon = 'fas fa-exclamation-circle'; alertClass = 'alert-error-custom'; break;
            case 'warning': icon = 'fas fa-exclamation-triangle'; alertClass = 'alert-warning-custom'; break;
            default: icon = 'fas fa-info-circle'; alertClass = 'alert-success-custom';
        }
        const alertId = 'alert-' + Date.now();
        const alertHtml = `
            <div id="${alertId}" class="alert-custom ${alertClass}" style="background: white; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                <i class="${icon}" style="font-size: 1.3rem;"></i>
                <div style="flex: 1;">
                    <strong>${escapeHtml(title)}</strong><br>
                    <small>${escapeHtml(message)}</small>
                </div>
                <button class="btn-close" style="font-size: 0.7rem;" onclick="$('#${alertId}').fadeOut(300,function(){$(this).remove();})"></button>
            </div>
        `;
        $('#alert-container').prepend(alertHtml);
        if (duration > 0) setTimeout(() => $(`#${alertId}`).fadeOut(300, function(){ $(this).remove(); }), duration);
    }

    // Set today's date
    function setTodayDate() {
        const today = new Date();
        const month = String(today.getMonth() + 1).padStart(2, '0');
        const day = String(today.getDate()).padStart(2, '0');
        const year = today.getFullYear();
        $('#summary-date').val(`${month}/${day}/${year}`);
    }
    setTodayDate();

    // Load cashiers
    function loadCashiers() {
        $.ajax({
            url: '<?php echo e(route("cashiers.list")); ?>',
            type: 'GET',
            success: function(response) {
                if (response.success && response.cashiers) {
                    let options = '<option value="">هەڵبژێرە</option>';
                    response.cashiers.forEach(function(cashier) {
                        options += `<option value="${cashier.id}">${escapeHtml(cashier.name)}</option>`;
                    });
                    $('#cashier-select').html(options);
                }
            },
            error: function() {
                $('#cashier-select').html('<option value="">هەڵبژێرە</option>');
            }
        });
    }
    loadCashiers();

    // Format inputs on blur
    $('#total-sales-input, #total-returns-input, #total-discounts-input, #given-cash-input, #shortage-amount-input, #surplus-amount-input').on('blur', function() {
        let value = parseNumericValue($(this).val());
        $(this).val(formatNumberToIQD(value));
    });

    $('#total-sales-input, #total-returns-input, #total-discounts-input, #given-cash-input, #shortage-amount-input, #surplus-amount-input').on('focus', function() {
        $(this).val(removeThousandSeparators($(this).val()));
    });

    // Handle cash status change
    $('#cash-status-select').on('change', function() {
        const status = $(this).val();
        const diffSection = $('#cash-difference-section');
        const shortageContainer = $('#shortage-container');
        const surplusContainer = $('#surplus-container');
        
        diffSection.hide();
        shortageContainer.hide();
        surplusContainer.hide();
        
        if (status === 'shortage') {
            diffSection.show();
            shortageContainer.show();
            $('#surplus-amount-input').val('');
        } else if (status === 'surplus') {
            diffSection.show();
            surplusContainer.show();
            $('#shortage-amount-input').val('');
        } else {
            $('#shortage-amount-input').val('');
            $('#surplus-amount-input').val('');
        }
        
        updateCashStatusDisplay();
    });

    // ============================================
    // Calculate Summary
    // ============================================
    
    function calculateSummary() {
        const totalSales = parseNumericValue($('#total-sales-input').val());
        const totalReturns = parseNumericValue($('#total-returns-input').val());
        const totalDiscounts = parseNumericValue($('#total-discounts-input').val());
        const givenCash = parseNumericValue($('#given-cash-input').val());
        const cashStatus = $('#cash-status-select').val();
        const shortageAmount = parseNumericValue($('#shortage-amount-input').val());
        const surplusAmount = parseNumericValue($('#surplus-amount-input').val());
        
        // Calculations
        const netSales = totalSales - totalDiscounts;
        const netReturns = totalReturns;
        const netAfterReturns = netSales - netReturns;
        // Assuming profit margin is calculated (can be adjusted based on business logic)
        // For now, using a simple calculation: profit = netSales - netReturns (adjust as needed)
        const estimatedCost = netAfterReturns * 0.7; // 70% cost assumption
        const profit = netAfterReturns - estimatedCost;
        
        calculatedData = {
            total_sales: totalSales,
            total_returns: totalReturns,
            total_discounts: totalDiscounts,
            net_sales: netSales,
            net_returns: netReturns,
            net_after_returns: netAfterReturns,
            profit: profit,
            given_cash: givenCash,
            cash_status: cashStatus,
            shortage_amount: shortageAmount,
            surplus_amount: surplusAmount
        };
        
        // Update summary cards
        $('#total-sales').text(formatNumberToIQD(totalSales) + ' د.ع');
        $('#total-returns').text(formatNumberToIQD(totalReturns) + ' د.ع');
        $('#total-discounts').text(formatNumberToIQD(totalDiscounts) + ' د.ع');
        $('#net-returns').text(formatNumberToIQD(netReturns) + ' د.ع');
        $('#daily-profit').text(formatNumberToIQD(profit) + ' د.ع');
        
        // Update calculated displays
        $('#net-sales-display').text(formatNumberToIQD(netSales) + ' د.ع');
        $('#net-returns-display').text(formatNumberToIQD(netReturns) + ' د.ع');
        $('#profit-display').text(formatNumberToIQD(profit) + ' د.ع');
        
        // Update cash status
        updateCashStatusDisplay();
        
        // Enable save button
        $('#save-summary-btn').prop('disabled', false);
        
        showAlert('success', 'ژمێریاری تەواو', 'پوختەی حساباتی ڕۆژانە ژمێریاری کرا');
    }
    
    function updateCashStatusDisplay() {
        const cashStatus = $('#cash-status-select').val();
        const shortageAmount = parseNumericValue($('#shortage-amount-input').val());
        const surplusAmount = parseNumericValue($('#surplus-amount-input').val());
        
        let displayText = '--';
        let displayClass = '';
        
        if (cashStatus === 'balanced') {
            displayText = 'هاوسەنگ ✅';
            displayClass = 'cash-status-balanced';
        } else if (cashStatus === 'shortage') {
            displayText = 'کەمی: ' + formatNumberToIQD(shortageAmount) + ' د.ع ⚠️';
            displayClass = 'cash-status-shortage';
        } else if (cashStatus === 'surplus') {
            displayText = 'زیادە: ' + formatNumberToIQD(surplusAmount) + ' د.ع ℹ️';
            displayClass = 'cash-status-surplus';
        }
        
        const displayEl = $('#cash-status-display');
        displayEl.text(displayText);
        displayEl.removeClass('cash-status-balanced cash-status-shortage cash-status-surplus');
        if (displayClass) {
            displayEl.addClass(displayClass);
        }
    }

    // Calculate button
    $('#calculate-summary-btn').on('click', function() {
        const cashierId = $('#cashier-select').val();
        if (!cashierId) {
            showAlert('warning', 'پێویستی بە کاشێر', 'تکایە ناوی کاشێر هەڵبژێرە');
            return;
        }
        if (!parseNumericValue($('#total-sales-input').val()) && parseNumericValue($('#total-sales-input').val()) === 0) {
            showAlert('warning', 'پێویستی بە فرۆش', 'تکایە کۆی فرۆشی ڕۆژ بنوسە');
            return;
        }
        calculateSummary();
    });

    // ============================================
    // Save Summary
    // ============================================
    
    $('#daily-summary-form').on('submit', function(e) {
        e.preventDefault();
        
        if (!calculatedData) {
            showAlert('warning', 'ژمێریاری نەکراوە', 'تکایە سەرەتا ژمێریاری بکە');
            return;
        }
        
        const cashierId = $('#cashier-select').val();
        if (!cashierId) {
            showAlert('warning', 'پێویستی بە کاشێر', 'تکایە ناوی کاشێر هەڵبژێرە');
            return;
        }
        
        const formData = {
            cashier_id: cashierId,
            summary_date: $('#summary-date').val(),
            total_sales: calculatedData.total_sales,
            total_returns: calculatedData.total_returns,
            total_discounts: calculatedData.total_discounts,
            net_sales: calculatedData.net_sales,
            net_returns: calculatedData.net_returns,
            net_after_returns: calculatedData.net_after_returns,
            profit: calculatedData.profit,
            given_cash: calculatedData.given_cash,
            cash_status: calculatedData.cash_status,
            shortage_amount: calculatedData.shortage_amount,
            surplus_amount: calculatedData.surplus_amount
        };
        
        let saveBtn = $('#save-summary-btn');
        let originalText = saveBtn.html();
        saveBtn.html('<span class="loading-spinner"></span> تۆمار دەکرێت...').prop('disabled', true);
        
        $.ajax({
            url: '<?php echo e(route("daily-summary.store")); ?>',
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    showAlert('success', 'سەرکەوتوو', response.message || 'پوختەی حساباتی ڕۆژانە بە سەرکەوتوویی تۆمارکرا');
                    resetForm();
                } else {
                    showAlert('error', 'هەڵە', response.message || 'هەڵەیەک ڕوویدا');
                }
            },
            error: function(xhr) {
                let msg = 'هەڵەیەک ڕوویدا لە تۆمارکردندا';
                if (xhr.responseJSON?.errors) {
                    msg = Object.values(xhr.responseJSON.errors).flat().join(', ');
                } else if (xhr.responseJSON?.message) {
                    msg = xhr.responseJSON.message;
                }
                showAlert('error', 'هەڵە', msg);
            },
            complete: function() {
                saveBtn.html(originalText).prop('disabled', true);
            }
        });
    });

    // ============================================
    // Reset Form
    // ============================================
    
    function resetForm() {
        $('#daily-summary-form')[0].reset();
        $('#cashier-select').val('');
        $('#total-sales-input, #total-returns-input, #total-discounts-input, #given-cash-input, #shortage-amount-input, #surplus-amount-input').val('');
        $('#cash-difference-section').hide();
        $('#shortage-container').hide();
        $('#surplus-container').hide();
        calculatedData = null;
        
        $('#total-sales').text('0 د.ع');
        $('#total-returns').text('0 د.ع');
        $('#total-discounts').text('0 د.ع');
        $('#net-returns').text('0 د.ع');
        $('#daily-profit').text('0 د.ع');
        $('#cash-status-display').text('--').removeClass('cash-status-balanced cash-status-shortage cash-status-surplus');
        $('#net-sales-display').text('0 د.ع');
        $('#net-returns-display').text('0 د.ع');
        $('#profit-display').text('0 د.ع');
        
        $('#save-summary-btn').prop('disabled', true);
        setTodayDate();
    }
    
    $('#reset-form-btn').on('click', resetForm);

    // ============================================
    // Auto-calculate on input changes
    // ============================================
    
    let autoCalcTimeout;
    function autoCalculate() {
        clearTimeout(autoCalcTimeout);
        autoCalcTimeout = setTimeout(function() {
            if ($('#cashier-select').val() && parseNumericValue($('#total-sales-input').val()) > 0) {
                calculateSummary();
            }
        }, 800);
    }
    
    $('#total-sales-input, #total-returns-input, #total-discounts-input, #given-cash-input, #shortage-amount-input, #surplus-amount-input').on('input', autoCalculate);
    $('#cash-status-select').on('change', function() {
        if (calculatedData) {
            updateCashStatusDisplay();
        }
    });

});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamnp64\www\mobileHardy\resources\views/items/items-edit.blade.php ENDPATH**/ ?>