<?php $__env->startSection('content'); ?>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<title><?php echo e(config('app.name', 'Laravel')); ?> - تۆمارکردنی قەرز</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

<style>
    :root {
        --primary: #4a6491;
        --primary-dark: #2c3e50;
        --secondary: #5d7ab0;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --info: #3b82f6;
        --accent: #8b5cf6;
        --text: #1e293b;
        --text-secondary: #64748b;
        --border-color: #e2e8f0;
        --bg-light: #f8fafc;
        --card-bg: #ffffff;
        --input-bg: #ffffff;
        --hover-bg: #f8fafc;
        --transition-base: all 0.3s ease;
    }

    body.dark-mode {
        --primary: #6c8db8;
        --primary-dark: #1e293b;
        --secondary: #5d7ab0;
        --text: #e2e8f0;
        --text-secondary: #94a3b8;
        --border-color: #334155;
        --bg-light: #1e293b;
        --card-bg: #1e293b;
        --input-bg: #0f172a;
        --hover-bg: #1e293b;
        background: #0f172a;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }

    body { 
        background: #f1f5f9; 
        font-family: system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif; 
        color: var(--text);
    }

    .container { 
        padding: 12px; 
        min-height: 100vh; 
        max-width: 1400px; 
        margin: 0 auto; 
    }

    @media (min-width: 640px) { .container { padding: 16px; } }
    @media (min-width: 1024px) { .container { padding: 24px; } }

    /* Header */
    .page-header {
        background: linear-gradient(135deg, var(--accent), #6d28d9);
        border-radius: 24px;
        padding: 24px 20px;
        margin-bottom: 24px;
        color: white;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: -30%;
        right: -10%;
        width: 150px;
        height: 150px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .page-header h1 {
        font-size: 1.6rem;
        font-weight: 800;
        margin-bottom: 8px;
        position: relative;
    }

    .page-header p {
        font-size: 0.9rem;
        opacity: 0.9;
        position: relative;
    }

    /* Cards */
    .form-card {
        background: var(--card-bg);
        border-radius: 20px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--border-color);
        transition: all 0.2s ease;
    }

    body.dark-mode .form-card {
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    }

    .section-title {
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 20px;
        text-align: center;
        color: var(--text);
        position: relative;
        padding-bottom: 12px;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background: linear-gradient(90deg, var(--accent), var(--primary));
        border-radius: 2px;
    }

    /* Layout */
    .grid-2 {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    @media (min-width: 992px) {
        .grid-2 {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
        }
    }

    .grid-3 {
        display: grid;
        grid-template-columns: 1fr;
        gap: 16px;
    }

    @media (min-width: 768px) {
        .grid-3 {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    /* Form Elements */
    .form-group {
        margin-bottom: 16px;
    }

    .form-label {
        display: block;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        color: var(--text);
        margin-bottom: 8px;
        letter-spacing: 0.5px;
    }

    .form-label i {
        color: var(--accent);
        margin-left: 6px;
    }

    .form-input {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid var(--border-color);
        border-radius: 14px;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s;
        background: var(--input-bg);
        color: var(--text);
    }

    .form-input:focus {
        outline: none;
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
    }

    .form-input::placeholder {
        color: var(--text-secondary);
    }

    textarea.form-input {
        resize: vertical;
        min-height: 80px;
    }

    /* Product Item Card */
    .product-item-card {
        background: var(--bg-light);
        border-radius: 16px;
        padding: 16px;
        margin-bottom: 12px;
        border: 1px solid var(--border-color);
        transition: all 0.2s;
    }

    .product-item-card:hover {
        border-color: var(--accent);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .product-item-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }

    .product-item-title {
        font-weight: 700;
        color: var(--text);
        font-size: 1rem;
    }

    .btn-remove-product {
        background: var(--danger);
        color: white;
        border: none;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-remove-product:hover {
        transform: scale(1.05);
        filter: brightness(1.1);
    }

    .product-item-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    @media (min-width: 640px) {
        .product-item-grid {
            grid-template-columns: 1fr 1fr 1fr;
        }
    }

    /* Buttons */
    .btn {
        border: none;
        font-weight: 700;
        padding: 12px 20px;
        border-radius: 14px;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        text-decoration: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        box-shadow: 0 4px 12px rgba(74, 100, 145, 0.3);
    }

    .btn-success {
        background: linear-gradient(135deg, var(--success), #059669);
        color: white;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .btn-accent {
        background: linear-gradient(135deg, var(--accent), #6d28d9);
        color: white;
        box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);
    }

    .btn-warning {
        background: linear-gradient(135deg, var(--warning), #d97706);
        color: white;
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
    }

    .btn-danger {
        background: linear-gradient(135deg, var(--danger), #dc2626);
        color: white;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    .btn-outline {
        background: transparent;
        color: var(--accent);
        border: 2px solid var(--accent);
    }

    .btn:hover {
        transform: translateY(-2px);
        filter: brightness(1.05);
    }

    .btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .btn-block {
        width: 100%;
    }

    .btn-lg {
        padding: 16px 24px;
        font-size: 16px;
    }

    /* Summary Card */
    .summary-card {
        background: linear-gradient(135deg, var(--bg-light), var(--card-bg));
        border-radius: 16px;
        padding: 20px;
        border: 2px solid var(--accent);
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid var(--border-color);
    }

    .summary-row:last-child {
        border-bottom: none;
    }

    .summary-label {
        font-weight: 600;
        color: var(--text-secondary);
    }

    .summary-value {
        font-weight: 700;
        color: var(--text);
    }

    .summary-total {
        font-size: 1.3rem;
        color: var(--accent);
    }

    /* Recent Credits Table */
    .table-container {
        width: 100%;
        overflow-x: auto;
        border-radius: 16px;
        border: 1px solid var(--border-color);
        background: var(--card-bg);
    }

    .credits-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
        color: var(--text);
    }

    @media (min-width: 768px) {
        .credits-table {
            font-size: 14px;
        }
    }

    .credits-table thead th {
        background: linear-gradient(135deg, var(--accent), #6d28d9);
        color: white;
        font-weight: 700;
        padding: 14px 10px;
        text-align: center;
        font-size: 11px;
        text-transform: uppercase;
    }

    .credits-table tbody td {
        padding: 12px 10px;
        border-bottom: 1px solid var(--border-color);
        text-align: center;
        vertical-align: middle;
    }

    .credits-table tbody tr:hover {
        background: var(--hover-bg);
    }

    .badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 700;
    }

    .badge-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .badge-paid {
        background: #dcfce7;
        color: #166534;
    }

    /* Alerts */
    .alert-container {
        position: fixed;
        top: 15px;
        right: 15px;
        z-index: 9999;
        width: calc(100% - 30px);
        max-width: 360px;
    }

    .alert {
        background: var(--card-bg);
        border-radius: 16px;
        padding: 12px 16px;
        margin-bottom: 12px;
        display: flex;
        gap: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        position: relative;
        overflow: hidden;
        color: var(--text);
    }

    .alert-success { border-right: 4px solid var(--success); }
    .alert-error { border-right: 4px solid var(--danger); }
    .alert-warning { border-right: 4px solid var(--warning); }
    .alert-info { border-right: 4px solid var(--info); }

    .alert-progress {
        position: absolute;
        bottom: 0;
        left: 0;
        height: 3px;
        background: currentColor;
        animation: progress 5s linear;
    }

    @keyframes progress {
        0% { width: 100%; }
        100% { width: 0%; }
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 40px;
        color: var(--text-secondary);
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 16px;
        opacity: 0.5;
    }

    /* Responsive */
    @media (max-width: 640px) {
        .credits-table thead {
            display: none;
        }
        
        .credits-table tbody tr {
            display: block;
            margin-bottom: 12px;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 12px;
            background: var(--card-bg);
        }
        
        .credits-table tbody td {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid var(--border-color);
            text-align: right;
        }
        
        .credits-table tbody td:last-child {
            border-bottom: none;
        }
        
        .credits-table tbody td::before {
            content: attr(data-label);
            font-weight: 700;
            font-size: 0.7rem;
            color: var(--accent);
            text-transform: uppercase;
        }
    }
</style>

<!-- Alert Container -->
<div class="alert-container" id="alert-container"></div>

<div class="container">
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-hand-holding-heart"></i> تۆمارکردنی قەرز</h1>
        <p>زانیاری کڕیار و کاڵاکانی قەرز تۆمار بکە</p>
    </div>

    <div class="grid-2">
        <!-- Left Column - Products Form -->
        <div>
            <div class="form-card">
                <h2 class="section-title"><i class="fas fa-boxes"></i> کاڵاکان</h2>
                
                <div id="products-container">
                    <!-- Product items will be added here -->
                    <div class="product-item-card" id="product-0">
                        <div class="product-item-header">
                            <span class="product-item-title">کاڵای #1</span>
                            <button type="button" class="btn-remove-product" onclick="removeProduct(0)" style="display: none;">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="product-item-grid">
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-tag"></i> ناوی کاڵا</label>
                                <input type="text" class="form-input product-name" placeholder="ناوی کاڵا...">
                            </div>
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-building"></i> کۆمپانیا</label>
                                <input type="text" class="form-input product-company" placeholder="ناوی کۆمپانیا...">
                            </div>
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-barcode"></i> بارکۆد</label>
                                <input type="text" class="form-input product-barcode" placeholder="ژمارەی بارکۆد...">
                            </div>
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-sort-numeric-up"></i> ژمارە</label>
                                <input type="number" class="form-input product-quantity" placeholder="0" min="1" value="1">
                            </div>
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-dollar-sign"></i> نرخی کڕین</label>
                                <input type="number" class="form-input product-price" placeholder="0" min="0" step="100">
                            </div>
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-calculator"></i> کۆی گشتی</label>
                                <input type="text" class="form-input product-total" placeholder="0" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="display: flex; gap: 12px; margin-top: 16px;">
                    <button type="button" class="btn btn-accent" onclick="addProduct()">
                        <i class="fas fa-plus-circle"></i> زیادکردنی کاڵای تر
                    </button>
                    <button type="button" class="btn btn-outline" onclick="clearAllProducts()">
                        <i class="fas fa-trash-alt"></i> پاککردنەوە
                    </button>
                </div>
            </div>

            <!-- Recent Self Credits -->
            <div class="form-card">
                <h2 class="section-title"><i class="fas fa-history"></i> دوایین قەرزەکان</h2>
                <div class="table-container">
                    <table class="credits-table">
                        <thead>
                            <tr>
                                <th>بەروار</th>
                                <th>کڕیار</th>
                                <th>بڕی گشتی</th>
                                <th>ڕەوش</th>
                            </tr>
                        </thead>
                        <tbody id="recent-credits-tbody">
                            <tr>
                                <td colspan="4" class="empty-state">
                                    <i class="fas fa-spinner fa-pulse"></i>
                                    <p>بارکردن...</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Column - Customer & Debt Details -->
        <div>
            <!-- Customer Information Card -->
            <div class="form-card">
                <h2 class="section-title"><i class="fas fa-user-circle"></i> زانیاری کڕیار</h2>
                <div class="form-group">
                    <label class="form-label"><i class="fas fa-user"></i> ناوی کڕیار</label>
                    <input type="text" id="customer-name" class="form-input" placeholder="ناوی کڕیار بنووسە..." required>
                </div>
                <div class="form-group">
                    <label class="form-label"><i class="fas fa-phone"></i> مۆبایل / تەلەفون</label>
                    <input type="text" id="customer-phone" class="form-input" placeholder="ژمارەی مۆبایل..." required>
                </div>
                <div class="form-group">
                    <label class="form-label"><i class="fas fa-map-marker-alt"></i> ناونیشان</label>
                    <input type="text" id="customer-address" class="form-input" placeholder="ناونیشانی کڕیار..." required>
                </div>
            </div>

            <!-- Debt Details Card -->
            <div class="form-card">
                <h2 class="section-title"><i class="fas fa-coins"></i> وردەکاری قەرز</h2>
                
                <div class="form-group">
                    <label class="form-label"><i class="fas fa-calendar-alt"></i> بەرواری وەرگرتن</label>
                    <input type="date" id="credit-date" class="form-input" value="<?php echo e(date('Y-m-d')); ?>">
                </div>
                
                <div class="form-group">
                    <label class="form-label"><i class="fas fa-hand-holding-usd"></i> پارەی پێشەکی (دینار)</label>
                    <input type="number" id="advance-payment" class="form-input" placeholder="0" min="0" step="100" value="0">
                </div>
                
                <div class="form-group">
                    <label class="form-label"><i class="fas fa-hourglass-half"></i> کاتی گەڕانەوەی قەرز (ڕۆژ)</label>
                    <input type="number" id="repayment-period" class="form-input" placeholder="30" min="1" value="30">
                </div>
                
                <div class="form-group">
                    <label class="form-label"><i class="fas fa-sticky-note"></i> تێبینی</label>
                    <textarea id="credit-notes" class="form-input" placeholder="هەر تێبینیەک هەیە بنووسە..."></textarea>
                </div>
            </div>

            <!-- Summary Card (Updated) -->
            <div class="form-card">
                <h2 class="section-title"><i class="fas fa-calculator"></i> پوختە</h2>
                
                <div class="summary-card" id="summary-card">
                    <div class="summary-row">
                        <span class="summary-label">ژمارەی کاڵاکان</span>
                        <span class="summary-value" id="summary-products-count">0</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">کۆی ژمارە</span>
                        <span class="summary-value" id="summary-total-quantity">0</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">کۆی گشتی قەرز</span>
                        <span class="summary-value" id="summary-grand-total">0 دینار</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">پارەی پێشەکی</span>
                        <span class="summary-value" id="summary-advance">0 دینار</span>
                    </div>
                    <div class="summary-row" style="border-top: 2px solid var(--accent); margin-top: 8px; padding-top: 12px;">
                        <span class="summary-label" style="font-size: 1.1rem; color: var(--danger);">بڕی قەرزی ماوە</span>
                        <span class="summary-value summary-total" id="summary-remaining" style="color: var(--danger);">0 دینار</span>
                    </div>
                </div>

                <div style="display: flex; flex-direction: column; gap: 12px; margin-top: 20px;">
                    <button type="button" class="btn btn-success btn-block btn-lg" onclick="saveCredit()">
                        <i class="fas fa-save"></i> تۆمارکردنی قەرز
                    </button>
                    <a href="<?php echo e(route('debtors.index')); ?>" class="btn btn-primary btn-block">
                        <i class="fas fa-list"></i> بینینی لیستی قەرزەکان
                    </a>
                    <a href="<?php echo e(route('sales-credit.index')); ?>" class="btn btn-warning btn-block">
                        <i class="fas fa-arrow-right"></i> گەڕانەوە بۆ فرۆشتنی قەرز
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
let productCount = 1;

// ==================== PRODUCT MANAGEMENT ====================
function addProduct() {
    productCount++;
    const productHtml = `
        <div class="product-item-card" id="product-${productCount}">
            <div class="product-item-header">
                <span class="product-item-title">کاڵای #${productCount}</span>
                <button type="button" class="btn-remove-product" onclick="removeProduct(${productCount})">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="product-item-grid">
                <div class="form-group">
                    <label class="form-label"><i class="fas fa-tag"></i> ناوی کاڵا</label>
                    <input type="text" class="form-input product-name" placeholder="ناوی کاڵا...">
                </div>
                <div class="form-group">
                    <label class="form-label"><i class="fas fa-building"></i> کۆمپانیا</label>
                    <input type="text" class="form-input product-company" placeholder="ناوی کۆمپانیا...">
                </div>
                <div class="form-group">
                    <label class="form-label"><i class="fas fa-barcode"></i> بارکۆد</label>
                    <input type="text" class="form-input product-barcode" placeholder="ژمارەی بارکۆد...">
                </div>
                <div class="form-group">
                    <label class="form-label"><i class="fas fa-sort-numeric-up"></i> ژمارە</label>
                    <input type="number" class="form-input product-quantity" placeholder="0" min="1" value="1">
                </div>
                <div class="form-group">
                    <label class="form-label"><i class="fas fa-dollar-sign"></i> نرخی کڕین</label>
                    <input type="number" class="form-input product-price" placeholder="0" min="0" step="100">
                </div>
                <div class="form-group">
                    <label class="form-label"><i class="fas fa-calculator"></i> کۆی گشتی</label>
                    <input type="text" class="form-input product-total" placeholder="0" readonly>
                </div>
            </div>
        </div>
    `;
    $('#products-container').append(productHtml);
    updateSummary();
    
    // Show remove button on first product if more than one
    if (productCount > 1) {
        $('#product-0 .btn-remove-product').show();
    }
}

function removeProduct(id) {
    if ($('.product-item-card').length <= 1) {
        showAlert('warning', 'نابێت کەمتر لە یەک کاڵا هەبێت');
        return;
    }
    $(`#product-${id}`).remove();
    updateSummary();
}

function clearAllProducts() {
    if (confirm('دڵنیایت دەتەوێت هەموو کاڵاکان پاک بکەیتەوە؟')) {
        $('#products-container').empty();
        productCount = 0;
        addProduct();
        updateSummary();
    }
}

// ==================== CALCULATIONS ====================
$(document).on('input', '.product-quantity, .product-price', function() {
    const card = $(this).closest('.product-item-card');
    const quantity = parseInt(card.find('.product-quantity').val()) || 0;
    const price = parseFloat(card.find('.product-price').val()) || 0;
    const total = quantity * price;
    card.find('.product-total').val(formatNumber(total));
    updateSummary();
});

// Listen for advance payment changes
$('#advance-payment').on('input', function() {
    updateSummary();
});

function updateSummary() {
    let totalQuantity = 0;
    let grandTotal = 0;
    let productsCount = $('.product-item-card').length;
    
    $('.product-item-card').each(function() {
        const quantity = parseInt($(this).find('.product-quantity').val()) || 0;
        const price = parseFloat($(this).find('.product-price').val()) || 0;
        totalQuantity += quantity;
        grandTotal += quantity * price;
    });
    
    const advance = parseFloat($('#advance-payment').val()) || 0;
    const remaining = Math.max(grandTotal - advance, 0);
    
    $('#summary-products-count').text(productsCount);
    $('#summary-total-quantity').text(totalQuantity);
    $('#summary-grand-total').text(formatNumber(grandTotal) + ' دینار');
    $('#summary-advance').text(formatNumber(advance) + ' دینار');
    $('#summary-remaining').text(formatNumber(remaining) + ' دینار');
}

// ==================== SAVE CREDIT ====================
function saveCredit() {
    const products = [];
    let hasError = false;
    
    // Validate customer fields
    const customerName = $('#customer-name').val().trim();
    const customerPhone = $('#customer-phone').val().trim();
    const customerAddress = $('#customer-address').val().trim();
    
    if (!customerName) {
        showAlert('error', 'ناوی کڕیار پێویستە');
        return;
    }
    if (!customerPhone) {
        showAlert('error', 'ژمارەی مۆبایل پێویستە');
        return;
    }
    
    $('.product-item-card').each(function(index) {
        const name = $(this).find('.product-name').val().trim();
        const company = $(this).find('.product-company').val().trim();
        const barcode = $(this).find('.product-barcode').val().trim();
        const quantity = parseInt($(this).find('.product-quantity').val()) || 0;
        const price = parseFloat($(this).find('.product-price').val()) || 0;
        
        if (!name) {
            showAlert('error', `ناوی کاڵا بۆ کاڵای #${index + 1} پێویستە`);
            hasError = true;
            return false;
        }
        
        if (quantity <= 0) {
            showAlert('error', `ژمارە بۆ کاڵای #${index + 1} پێویستە`);
            hasError = true;
            return false;
        }
        
        if (price <= 0) {
            showAlert('error', `نرخی کڕین بۆ کاڵای #${index + 1} پێویستە`);
            hasError = true;
            return false;
        }
        
        products.push({
            name: name,
            company: company || 'بێ کۆمپانیا',
            barcode: barcode || '',
            quantity: quantity,
            price: price,
            total: quantity * price
        });
    });
    
    if (hasError || products.length === 0) return;
    
    const grandTotal = products.reduce((sum, p) => sum + p.total, 0);
    const advance = parseFloat($('#advance-payment').val()) || 0;
    const remaining = Math.max(grandTotal - advance, 0);
    const creditDate = $('#credit-date').val();
    const repaymentPeriod = parseInt($('#repayment-period').val()) || 30;
    const notes = $('#credit-notes').val().trim();
    
    if (!creditDate) {
        showAlert('error', 'تکایە بەرواری وەرگرتن دیاری بکە');
        return;
    }
    
    const formData = {
        customer_name: customerName,
        customer_phone: customerPhone,
        customer_address: customerAddress,
        products: products,
        credit_date: creditDate,
        advance_payment: advance,
        repayment_period: repaymentPeriod,
        notes: notes,
        total_amount: grandTotal,
        remaining_amount: remaining,
        _token: $('meta[name="csrf-token"]').attr('content')
    };
    
    $.ajax({
        url: '<?php echo e(route("debtors.save-products")); ?>',
        type: 'POST',
        data: formData,
        beforeSend: function() {
            $('.btn-success').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> تۆمارکردن...');
        },
        success: function(response) {
            if (response.success) {
                showAlert('success', response.message);
                // Reset form
                $('#products-container').empty();
                productCount = 0;
                addProduct();
                $('#customer-name, #customer-phone, #customer-address, #credit-notes').val('');
                $('#advance-payment').val('0');
                $('#repayment-period').val('30');
                updateSummary();
                loadRecentCredits();
            } else {
                showAlert('error', response.message || 'هەڵەیەک ڕوویدا');
            }
        },
        error: function(xhr) {
            let msg = 'هەڵەیەک ڕوویدا لە کاتی تۆمارکردن';
            try {
                const res = JSON.parse(xhr.responseText);
                msg = res.message || msg;
            } catch(e) {}
            showAlert('error', msg);
        },
        complete: function() {
            $('.btn-success').prop('disabled', false).html('<i class="fas fa-save"></i> تۆمارکردنی قەرز');
        }
    });
}

// ==================== LOAD RECENT CREDITS ====================
function loadRecentCredits() {
    $.ajax({
        url: '',
        type: 'GET',
        success: function(response) {
            if (response.success && response.credits && response.credits.length > 0) {
                let html = '';
                response.credits.forEach(function(credit) {
                    const statusBadge = credit.is_paid ? 
                        '<span class="badge badge-paid">پاردراوە</span>' : 
                        '<span class="badge badge-pending">چاوەڕوانە</span>';
                    
                    html += `
                        <tr>
                            <td data-label="بەروار">${formatDate(credit.credit_date || credit.created_at)}</td>
                            <td data-label="کڕیار">${credit.customer_name || '—'}</td>
                            <td data-label="بڕی گشتی">${formatNumber(credit.total_amount)} دینار</td>
                            <td data-label="ڕەوش">${statusBadge}</td>
                        </tr>
                    `;
                });
                $('#recent-credits-tbody').html(html);
            } else {
                $('#recent-credits-tbody').html(`
                    <tr>
                        <td colspan="4" class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <p>هیچ قەرزێک تۆمار نەکراوە</p>
                        </td>
                    </tr>
                `);
            }
        },
        error: function() {
            $('#recent-credits-tbody').html(`
                <tr>
                    <td colspan="4" class="empty-state">
                        <i class="fas fa-exclamation-triangle"></i>
                        <p>هەڵەیەک ڕوویدا</p>
                    </td>
                </tr>
            `);
        }
    });
}

// ==================== HELPER FUNCTIONS ====================
function formatNumber(n) {
    if (n === undefined || n === null || isNaN(n)) return '0';
    return Number(n).toLocaleString();
}

function formatDate(dateString) {
    if (!dateString) return '—';
    const date = new Date(dateString);
    return date.toLocaleDateString('ku-IQ', { 
        year: 'numeric', 
        month: '2-digit', 
        day: '2-digit' 
    });
}

function showAlert(type, message) {
    const icons = {
        success: 'fa-check-circle',
        error: 'fa-exclamation-circle',
        warning: 'fa-exclamation-triangle',
        info: 'fa-info-circle'
    };
    
    const titles = {
        success: 'سەرکەوتوو',
        error: 'هەڵە',
        warning: 'ئاگاداری',
        info: 'زانیاری'
    };
    
    const id = 'alert-' + Date.now();
    const html = `
        <div id="${id}" class="alert alert-${type}">
            <div><i class="fas ${icons[type]} fa-lg"></i></div>
            <div>
                <strong>${titles[type]}</strong>
                <div style="margin-top: 4px;">${message}</div>
            </div>
            <div class="alert-progress"></div>
        </div>
    `;
    $('#alert-container').append(html);
    setTimeout(() => {
        $(`#${id}`).fadeOut(300, function() { $(this).remove(); });
    }, 4000);
}

// ==================== INITIALIZATION ====================
$(document).ready(function() {
    loadRecentCredits();
    updateSummary();
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamnp64\www\mobileHardy\resources\views/items/debtor-save-products.blade.php ENDPATH**/ ?>