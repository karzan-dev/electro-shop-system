{{--
    resources/views/debtors/save-products.blade.php
    تۆمارکردنی قەرز – بە زیادکردنی زانیاری کڕیار و وردەکاری قەرز
    Fully responsive with dark mode support
--}}

@extends('layouts.navigation')

@section('content')

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ config('app.name', 'Laravel') }} - تۆمارکردنی قەرز</title>
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

    .container { 
        padding: 12px; 
        min-height: 100vh; 
        max-width: 1400px; 
        margin: 0 auto; 
    }

    @media (min-width: 640px) { .container { padding: 16px; } }
    @media (min-width: 1024px) { .container { padding: 24px; } }

    .form-card {
        background: var(--card-bg);
        border-radius: 20px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--border-color);
        transition: all 0.2s ease;
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

    .product-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 12px;
    }

    @media (min-width: 768px) {
        .product-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (min-width: 1200px) {
        .product-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    .form-group {
        margin-bottom: 16px;
        position: relative;
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
        padding-bottom: 8px;
        border-bottom: 1px solid var(--border-color);
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

    #btnn {
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
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
    }

    .btn-success {
        background: linear-gradient(135deg, var(--success), #059669);
        color: white;
    }

    .btn-warning {
        background: linear-gradient(135deg, var(--warning), #d97706);
        color: white;
    }

    .btn-danger {
        background: linear-gradient(135deg, var(--danger), #dc2626);
        color: white;
    }

    .btn-secondary {
        background: linear-gradient(135deg, var(--text-secondary), #475569);
        color: white;
    }

    .btn:hover {
        transform: translateY(-2px);
        filter: brightness(1.05);
    }

    .btn-block {
        width: 100%;
    }

    .btn-lg {
        padding: 16px 24px;
        font-size: 16px;
    }

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
        color: var(--danger);
    }

    .profit-positive {
        color: var(--success);
    }

    .profit-negative {
        color: var(--danger);
    }

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

    .shortcut-hint {
        display: inline-block;
        background: var(--bg-light);
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
        color: var(--text-secondary);
        margin-right: 8px;
        border: 1px solid var(--border-color);
    }

    /* Suggestions Dropdown - Shared for Customer & Product */
    .suggestions-container {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        z-index: 1000;
        background: var(--card-bg);
        border: 2px solid var(--border-color);
        border-radius: 0 0 14px 14px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        max-height: 280px;
        overflow-y: auto;
        display: none;
    }

    .suggestion-item {
        padding: 10px 15px;
        cursor: pointer;
        border-bottom: 1px solid var(--border-color);
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .suggestion-item:last-child {
        border-bottom: none;
    }

    .suggestion-item:hover,
    .suggestion-item.active {
        background: var(--hover-bg);
        border-color: var(--accent);
    }

    .suggestion-item .avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 14px;
    }

    .suggestion-item .info {
        flex: 1;
        min-width: 0;
    }

    .suggestion-item .name {
        font-weight: 600;
        font-size: 13px;
        color: var(--text);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .suggestion-item .details {
        font-size: 11px;
        color: var(--text-secondary);
    }

    .suggestions-container .no-results,
    .suggestions-container .loading-indicator {
        padding: 15px;
        text-align: center;
        color: var(--text-secondary);
        font-size: 13px;
    }
</style>

<div class="alert-container" id="alert-container"></div>

<div class="container">
    <div class="grid-2">
        <!-- Left Column -->
        <div>
            <div class="form-card">
                <h2 class="section-title"><i class="fas fa-user-circle"></i> زانیاری کڕیار</h2>
                <div class="form-group">
                    <label class="form-label"><i class="fas fa-user"></i> ناوی کڕیار</label>
                    <input type="text" id="customer-name" class="form-input" placeholder="ناوی کڕیار بنووسە..." required autocomplete="off">
                    <div id="customer-suggestions" class="suggestions-container"></div>
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

            <div class="form-card">
                <h2 class="section-title"><i class="fas fa-boxes"></i> کاڵاکان</h2>
                <div id="products-container">
                    <!-- Products will be added here dynamically -->
                </div>
             
            </div>
        </div>

        <!-- Right Column -->
        <div>
            <div class="form-card">
                <h2 class="section-title"><i class="fas fa-coins"></i> وردەکاری قەرز</h2>
                
                <div class="form-group">
                    <label class="form-label"><i class="fas fa-calendar-alt"></i> بەرواری بردن</label>
                    <input type="date" id="credit-date" class="form-input" value="{{ date('Y-m-d') }}">
                </div>
                
                <div class="form-group">
                    <label class="form-label"><i class="fas fa-hand-holding-usd"></i> پارەی پێشەکی (دینار)</label>
                    <input type="number" id="advance-payment" class="form-input number-input" placeholder="0" min="0" step="100" value="0">
                </div>
                
                <div class="form-group">
                    <label class="form-label"><i class="fas fa-calendar-check"></i> کاتی گەڕانەوەی قەرز (بەروار)</label>
                    <input type="date" id="repayment-date" class="form-input" value="{{ date('Y-m-d', strtotime('+30 days')) }}">
                </div>
                
            </div>

            <div class="form-card">
                <h2 class="section-title"><i class="fas fa-calculator"></i> پوختە</h2>
                <div class="summary-card" id="summary-card">
                    <div class="summary-row">
                        <span class="summary-label">کۆی نرخی فرۆشتن</span>
                        <span class="summary-value" id="summary-total-selling">0 دینار</span>
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
                    <button type="button" id="btnn" class="btn btn-success btn-block btn-lg" onclick="saveCredit()" id="btn-save-credit">
                        <i class="fas fa-save"></i> تۆمارکردنی قەرز <span class="shortcut-hint">F1</span>
                    </button>
                    <button type="button" id="btnn" class="btn btn-danger btn-block" onclick="clearAllFormData()" id="btn-clear-form">
                        <i class="fas fa-eraser"></i> پاککردنەوەی فۆرم <span class="shortcut-hint">Esc</span>
                    </button>
                    <a  href=""  class="btn btn-primary btn-block hidden" hidden>
                        <i class="fas fa-list"></i> بینینی لیستی قەرزەکان
                    </a>
                    <a href="" class="btn btn-warning btn-block hidden" hidden>
                        <i class="fas fa-arrow-right"></i> گەڕانەوە بۆ فرۆشتنی قەرز
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
let productCount = 0;
const STORAGE_KEY = 'debtor_save_products_data';
const CLEAR_KEYWORD = 'تۆمارکردنی قەرز';

// Store active timeouts and selected indices for suggestions
let customerSearchTimeout;
let customerSelectedIndex = -1;

// Store product search timeouts and selected indices (per product)
let productSearchTimeouts = {};
let productSelectedIndices = {};

// Mapping for Kurdish and Arabic digits to English digits
const digitMap = {
    '٠': '0', '١': '1', '٢': '2', '٣': '3', '٤': '4',
    '٥': '5', '٦': '6', '٧': '7', '٨': '8', '٩': '9',
    '۰': '0', '۱': '1', '۲': '2', '۳': '3', '۴': '4',
    '۵': '5', '۶': '6', '۷': '7', '۸': '8', '۹': '9'
};

// Escape HTML to prevent XSS
function escapeHtml(text) {
    if (!text) return '';
    return String(text)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}

/**
 * Convert Kurdish/Arabic digits and number text to English digits
 */
function convertToEnglishDigits(input) {
    if (input === null || input === undefined) return '';
    
    let str = String(input).trim();
    
    // Convert Arabic/Kurdish/Persian digits to English
    str = str.replace(/[٠-٩۰-۹]/g, function(match) {
        return digitMap[match] || match;
    });
    
    // Replace Arabic/Persian decimal separator
    str = str.replace(/٫/g, '.').replace(/,/g, '');
    
    // Parse Kurdish/Arabic number words
    const numberWords = {
        'سفر': 0, 'صفر': 0,
        'یەک': 1, 'یک': 1, 'واحد': 1,
        'دوو': 2, 'دو': 2, 'اثنان': 2,
        'سێ': 3, 'سه': 3, 'ثلاثة': 3,
        'چوار': 4, 'چهار': 4, 'اربعة': 4,
        'پێنج': 5, 'پنج': 5, 'خمسة': 5,
        'شەش': 6, 'شش': 6, 'ستة': 6,
        'حەوت': 7, 'هفت': 7, 'سبعة': 7,
        'هەشت': 8, 'هشت': 8, 'ثمانیة': 8,
        'نۆ': 9, 'نه': 9, 'تسعة': 9,
        'دە': 10, 'ده': 10, 'عشرة': 10,
        'هەزار': 1000, 'هزار': 1000, 'الف': 1000,
        'ملیۆن': 1000000, 'ملیون': 1000000,
    };
    
    const lowerStr = str.toLowerCase();
    for (const [word, value] of Object.entries(numberWords)) {
        if (lowerStr.includes(word)) {
            const remaining = lowerStr.replace(word, '').trim();
            if (remaining === '') return String(value);
            const remainingNum = parseFloat(remaining);
            if (!isNaN(remainingNum)) return String(value * remainingNum);
            return String(value);
        }
    }
    
    const num = parseFloat(str);
    if (!isNaN(num)) return String(num);
    
    return str;
}

// Handle number input conversion
$(document).on('input', 'input[type="number"], .number-input', function() {
    const input = $(this);
    const rawValue = input.val();
    const convertedValue = convertToEnglishDigits(rawValue);
    if (rawValue !== convertedValue) {
        input.val(convertedValue);
    }
});

// Handle paste events for number inputs
$(document).on('paste', 'input[type="number"], .number-input', function(e) {
    setTimeout(() => {
        const input = $(this);
        const rawValue = input.val();
        const convertedValue = convertToEnglishDigits(rawValue);
        if (rawValue !== convertedValue) {
            input.val(convertedValue);
            input.trigger('input');
        }
    }, 10);
});

// =====================================================
// CUSTOMER SEARCH / SUGGESTIONS
// =====================================================

$('#customer-name').on('input', function() {
    const term = $(this).val().trim();
    
    clearTimeout(customerSearchTimeout);
    customerSelectedIndex = -1;
    
    if (term.length < 2) {
        $('#customer-suggestions').hide().empty();
        return;
    }
    
    $('#customer-suggestions').html('<div class="loading-indicator"><i class="fas fa-spinner fa-spin"></i> بەدواداگەڕان...</div>').show();
    
    customerSearchTimeout = setTimeout(function() {
        $.ajax({
            url: '/customers/search',
            type: 'POST',
            data: { 
                search_term: term, 
                _token: $('meta[name="csrf-token"]').attr('content') 
            },
            success: function(res) {
                if (res.success && res.customers && res.customers.length > 0) {
                    let html = '';
                    res.customers.forEach(function(c, index) {
                        html += `
                            <div class="suggestion-item" 
                                 data-index="${index}"
                                 onclick='selectCustomer("${escapeHtml(c.name)}", "${escapeHtml(c.number_phone || '')}", "${escapeHtml(c.address || '')}")'
                                 onmouseenter="highlightCustomerSuggestion(${index})">
                                <div class="avatar">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="info">
                                    <div class="name">${escapeHtml(c.name)}</div>
                                    <div class="details">
                                        ${c.number_phone ? '<i class="fas fa-phone"></i> ' + escapeHtml(c.number_phone) : ''}
                                        ${c.number_phone && c.address ? ' <span style="margin: 0 4px;">|</span> ' : ''}
                                        ${c.address ? '<i class="fas fa-map-marker-alt"></i> ' + escapeHtml(c.address) : ''}
                                    </div>
                                </div>
                            </div>`;
                    });
                    $('#customer-suggestions').html(html).show();
                } else {
                    $('#customer-suggestions').html('<div class="no-results"><i class="fas fa-search"></i> هیچ کڕیارێک نەدۆزرایەوە</div>').show();
                }
            },
            error: function() {
                $('#customer-suggestions').html('<div class="no-results"><i class="fas fa-exclamation-circle"></i> هەڵەیەک ڕوویدا</div>').show();
            }
        });
    }, 300);
});

function selectCustomer(name, phone, address) {
    $('#customer-name').val(name);
    $('#customer-phone').val(phone);
    $('#customer-address').val(address);
    
    $('#customer-suggestions').hide().empty();
    customerSelectedIndex = -1;
    
    saveToLocalStorage();
    showAlert('success', 'کڕیار هەڵبژێردرا: ' + name);
}

function highlightCustomerSuggestion(index) {
    customerSelectedIndex = index;
    $('#customer-suggestions .suggestion-item').removeClass('active');
    $(`#customer-suggestions .suggestion-item[data-index="${index}"]`).addClass('active');
}

// Customer keyboard navigation
$('#customer-name').on('keydown', function(e) {
    const container = $('#customer-suggestions');
    const items = container.find('.suggestion-item');
    
    if (!container.is(':visible') || items.length === 0) return;
    
    if (e.key === 'ArrowDown' || e.keyCode === 40) {
        e.preventDefault();
        customerSelectedIndex++;
        if (customerSelectedIndex >= items.length) customerSelectedIndex = 0;
        items.removeClass('active');
        $(items[customerSelectedIndex]).addClass('active');
        $(items[customerSelectedIndex])[0].scrollIntoView({ block: 'nearest' });
    }
    
    if (e.key === 'ArrowUp' || e.keyCode === 38) {
        e.preventDefault();
        customerSelectedIndex--;
        if (customerSelectedIndex < 0) customerSelectedIndex = items.length - 1;
        items.removeClass('active');
        $(items[customerSelectedIndex]).addClass('active');
        $(items[customerSelectedIndex])[0].scrollIntoView({ block: 'nearest' });
    }
    
    if (e.key === 'Enter' || e.keyCode === 13) {
        if (customerSelectedIndex >= 0 && customerSelectedIndex < items.length) {
            e.preventDefault();
            $(items[customerSelectedIndex]).trigger('click');
        }
    }
    
    if (e.key === 'Escape' || e.keyCode === 27) {
        container.hide().empty();
        customerSelectedIndex = -1;
    }
});

// =====================================================
// PRODUCT SEARCH / SUGGESTIONS (from save-debtors table)
// =====================================================

/**
 * Initialize product search on dynamically added product name inputs
 * Uses event delegation to handle both existing and future product inputs
 */
$(document).on('input', '.product-name', function() {
    const input = $(this);
    const term = input.val().trim();
    const productCard = input.closest('.product-item-card');
    const productId = productCard.attr('id'); // e.g., "product-1"
    const suggestionsContainer = productCard.find('.product-suggestions');
    
    // Create suggestions container if it doesn't exist
    if (!suggestionsContainer.length) {
        const formGroup = input.closest('.form-group');
        formGroup.append('<div class="suggestions-container product-suggestions"></div>');
    }
    
    const container = productCard.find('.product-suggestions');
    
    // Clear previous timeout for this specific product
    if (productSearchTimeouts[productId]) {
        clearTimeout(productSearchTimeouts[productId]);
    }
    
    // Reset selected index for this product
    productSelectedIndices[productId] = -1;
    
    if (term.length < 2) {
        container.hide().empty();
        return;
    }
    
    container.html('<div class="loading-indicator"><i class="fas fa-spinner fa-spin"></i> بەدواداگەڕانی کاڵا...</div>').show();
    
    // Search in save-debtors table
    productSearchTimeouts[productId] = setTimeout(function() {
        $.ajax({
            url: '/products/search-debtors',
            type: 'POST',
            data: { 
                search_term: term, 
                _token: $('meta[name="csrf-token"]').attr('content') 
            },
            success: function(res) {
                if (res.success && res.products && res.products.length > 0) {
                    let html = '';
                    res.products.forEach(function(p, index) {
                        const initial = (p.name || '?').charAt(0).toUpperCase();
                        html += `
                            <div class="suggestion-item" 
                                 data-index="${index}"
                                 data-product-id="${productId}"
                                 onclick='selectProduct("${productId}", "${escapeHtml(p.name)}", "${escapeHtml(p.company || '')}", "${escapeHtml(p.selling_price || p.price || '')}")'
                                 onmouseenter="highlightProductSuggestion('${productId}', ${index})">
                                <div class="avatar">
                                    ${initial}
                                </div>
                                <div class="info">
                                    <div class="name">${escapeHtml(p.name)}</div>
                                    <div class="details">
                                        ${p.company ? '<i class="fas fa-building"></i> ' + escapeHtml(p.company) : ''}
                                        ${p.company && (p.selling_price || p.price) ? ' <span style="margin: 0 4px;">|</span> ' : ''}
                                        ${p.selling_price || p.price ? '<i class="fas fa-tags"></i> ' + escapeHtml(String(p.selling_price || p.price)) + ' دینار' : ''}
                                    </div>
                                </div>
                            </div>`;
                    });
                    container.html(html).show();
                } else {
                    container.html('<div class="no-results"><i class="fas fa-search"></i> هیچ کاڵایەک نەدۆزرایەوە</div>').show();
                }
            },
            error: function() {
                container.html('<div class="no-results"><i class="fas fa-exclamation-circle"></i> هەڵەیەک ڕوویدا</div>').show();
            }
        });
    }, 300);
});

/**
 * Select a product from the suggestions dropdown
 * Fills in product name, company, and selling price for the specific product card
 */
function selectProduct(productId, name, company, sellingPrice) {
    const productCard = $('#' + productId);
    productCard.find('.product-name').val(name);
    productCard.find('.product-company').val(company || '');
    productCard.find('.product-selling-price').val(sellingPrice || '');
    
    // Hide suggestions
    productCard.find('.product-suggestions').hide().empty();
    productSelectedIndices[productId] = -1;
    
    // Trigger input events to update summary and save
    productCard.find('.product-selling-price').trigger('input');
    updateSummary();
    saveToLocalStorage();
    
    showAlert('success', 'کاڵا هەڵبژێردرا: ' + name);
}

/**
 * Highlight product suggestion on mouse hover
 */
function highlightProductSuggestion(productId, index) {
    productSelectedIndices[productId] = index;
    const productCard = $('#' + productId);
    productCard.find('.product-suggestions .suggestion-item').removeClass('active');
    productCard.find(`.product-suggestions .suggestion-item[data-index="${index}"]`).addClass('active');
}

/**
 * Handle keyboard navigation for product suggestions (event delegation)
 */
$(document).on('keydown', '.product-name', function(e) {
    const input = $(this);
    const productCard = input.closest('.product-item-card');
    const productId = productCard.attr('id');
    const container = productCard.find('.product-suggestions');
    const items = container.find('.suggestion-item');
    
    if (!container.is(':visible') || items.length === 0) return;
    
    // Initialize index if not set
    if (productSelectedIndices[productId] === undefined) {
        productSelectedIndices[productId] = -1;
    }
    
    if (e.key === 'ArrowDown' || e.keyCode === 40) {
        e.preventDefault();
        productSelectedIndices[productId]++;
        if (productSelectedIndices[productId] >= items.length) {
            productSelectedIndices[productId] = 0;
        }
        items.removeClass('active');
        $(items[productSelectedIndices[productId]]).addClass('active');
        $(items[productSelectedIndices[productId]])[0].scrollIntoView({ block: 'nearest' });
    }
    
    if (e.key === 'ArrowUp' || e.keyCode === 38) {
        e.preventDefault();
        productSelectedIndices[productId]--;
        if (productSelectedIndices[productId] < 0) {
            productSelectedIndices[productId] = items.length - 1;
        }
        items.removeClass('active');
        $(items[productSelectedIndices[productId]]).addClass('active');
        $(items[productSelectedIndices[productId]])[0].scrollIntoView({ block: 'nearest' });
    }
    
    if (e.key === 'Enter' || e.keyCode === 13) {
        if (productSelectedIndices[productId] >= 0 && productSelectedIndices[productId] < items.length) {
            e.preventDefault();
            $(items[productSelectedIndices[productId]]).trigger('click');
        }
    }
    
    if (e.key === 'Escape' || e.keyCode === 27) {
        container.hide().empty();
        productSelectedIndices[productId] = -1;
    }
});

// Close any suggestions when clicking outside
$(document).on('click', function(e) {
    // Close customer suggestions
    if (!$(e.target).closest('#customer-name').length && !$(e.target).closest('#customer-suggestions').length) {
        $('#customer-suggestions').hide().empty();
        customerSelectedIndex = -1;
    }
    
    // Close product suggestions
    if (!$(e.target).closest('.product-name').length && !$(e.target).closest('.product-suggestions').length) {
        $('.product-suggestions').hide().empty();
        // Reset all product selected indices
        for (const key in productSelectedIndices) {
            productSelectedIndices[key] = -1;
        }
    }
});

// =====================================================
// END PRODUCT SEARCH
// =====================================================

// Function to completely clear the form and localStorage
function clearAllFormData(silent = false) {
    localStorage.removeItem(STORAGE_KEY);
    
    $('#customer-name').val('');
    $('#customer-phone').val('');
    $('#customer-address').val('');
    $('#credit-notes').val('');
    
    // Hide all suggestions
    $('#customer-suggestions').hide().empty();
    $('.product-suggestions').hide().empty();
    customerSelectedIndex = -1;
    productSelectedIndices = {};
    productSearchTimeouts = {};
    
    $('#advance-payment').val('0');
    $('#credit-date').val('{{ date("Y-m-d") }}');
    $('#repayment-date').val('{{ date("Y-m-d", strtotime("+30 days")) }}');
    
    $('#products-container').empty();
    productCount = 0;
    addProduct();
    
    updateSummary();
    
    if (!silent) {
        showAlert('info', 'هەموو فۆرمەکە پاککرایەوە - Esc');
    }
}

// Check if URL or form contains the keyword
function checkClearKeyword() {
    const urlParams = new URLSearchParams(window.location.search);
    const urlKeyword = urlParams.get('action') || urlParams.get('type') || '';
    
    if (urlKeyword.includes(CLEAR_KEYWORD)) {
        clearAllFormData(true);
        return true;
    }
    
    const shouldClear = sessionStorage.getItem('clear_debtor_form');
    if (shouldClear === 'true') {
        sessionStorage.removeItem('clear_debtor_form');
        clearAllFormData(true);
        return true;
    }
    
    return false;
}

// Save all form data to localStorage
function saveToLocalStorage() {
    const data = {
        customer_name: $('#customer-name').val() || '',
        customer_phone: $('#customer-phone').val() || '',
        customer_address: $('#customer-address').val() || '',
        credit_date: $('#credit-date').val() || '',
        advance_payment: $('#advance-payment').val() || '0',
        repayment_date: $('#repayment-date').val() || '',
        credit_notes: $('#credit-notes').val() || '',
        products: []
    };
    
    $('.product-item-card').each(function() {
        data.products.push({
            name: $(this).find('.product-name').val() || '',
            company: $(this).find('.product-company').val() || '',
            selling_price: $(this).find('.product-selling-price').val() || ''
        });
    });
    
    localStorage.setItem(STORAGE_KEY, JSON.stringify(data));
}

// Load data from localStorage
function loadFromLocalStorage() {
    const savedData = localStorage.getItem(STORAGE_KEY);
    if (!savedData) return false;
    
    try {
        const data = JSON.parse(savedData);
        
        if (data.customer_name) $('#customer-name').val(data.customer_name);
        if (data.customer_phone) $('#customer-phone').val(data.customer_phone);
        if (data.customer_address) $('#customer-address').val(data.customer_address);
        if (data.credit_date) $('#credit-date').val(data.credit_date);
        if (data.advance_payment) $('#advance-payment').val(data.advance_payment);
        if (data.repayment_date) $('#repayment-date').val(data.repayment_date);
        if (data.credit_notes) $('#credit-notes').val(data.credit_notes);
        
        if (data.products && data.products.length > 0) {
            $('#products-container').empty();
            productCount = 0;
            
            data.products.forEach(function(product) {
                productCount++;
                const html = getProductHTMLWithData(productCount, product);
                $('#products-container').append(html);
            });
        }
        
        updateSummary();
        return true;
    } catch(e) {
        console.error('Error loading from localStorage:', e);
        return false;
    }
}

// Create product HTML with pre-filled data
function getProductHTMLWithData(count, product) {
    return `
        <div class="product-item-card" id="product-${count}">
            <div class="product-item-header">
                <span class="product-item-title">کاڵای #${count}</span>
                <button type="button" class="btn-remove-product" onclick="removeProduct(${count})" ${count === 1 ? 'style="display:none;"' : ''}>
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="product-grid">
                <div class="form-group">
                    <label class="form-label"><i class="fas fa-tag"></i> ناوی کاڵا</label>
                    <input type="text" class="form-input product-name" placeholder="ناوی کاڵا..." value="${product.name || ''}" autocomplete="off">
                </div>
                <div class="form-group">
                    <label class="form-label"><i class="fas fa-building"></i> کۆمپانیا</label>
                    <input type="text" class="form-input product-company" placeholder="ناوی کۆمپانیا..." value="${product.company || ''}">
                </div>
                <div class="form-group">
                    <label class="form-label"><i class="fas fa-tags"></i> نرخی فرۆشتن (دینار)</label>
                    <input type="number" class="form-input product-selling-price number-input" placeholder="نرخی فرۆشتن..." min="0" step="100" value="${product.selling_price || ''}">
                </div>
            </div>
        </div>
    `;
}

// Create product HTML (empty)
function getProductHTML(count) {
    return getProductHTMLWithData(count, { name: '', company: '', selling_price: '' });
}

function addProduct() {
    productCount++;
    $('#products-container').append(getProductHTML(productCount));
    updateSummary();
    saveToLocalStorage();
}

function removeProduct(id) {
    if ($('.product-item-card').length <= 1) {
        showAlert('warning', 'نابێت کەمتر لە یەک کاڵا هەبێت');
        return;
    }
    
    // Clean up product search data
    delete productSearchTimeouts['product-' + id];
    delete productSelectedIndices['product-' + id];
    
    $(`#product-${id}`).remove();
    updateSummary();
    saveToLocalStorage();
}

// Update summary when inputs change
$(document).on('input', '.product-selling-price, #advance-payment, #customer-name, #customer-phone, #customer-address, #credit-date, #repayment-date, #credit-notes', function() {
    updateSummary();
    saveToLocalStorage();
});

// Also save when product name or company changes
$(document).on('input', '.product-name, .product-company', function() {
    saveToLocalStorage();
});

function updateSummary() {
    let totalSellingAmount = 0;
    
    $('.product-item-card').each(function() {
        const rawPrice = $(this).find('.product-selling-price').val() || '0';
        const convertedPrice = convertToEnglishDigits(rawPrice);
        const sellingPrice = parseFloat(convertedPrice) || 0;
        totalSellingAmount += sellingPrice;
    });
    
    const rawAdvance = $('#advance-payment').val() || '0';
    const convertedAdvance = convertToEnglishDigits(rawAdvance);
    const advance = parseFloat(convertedAdvance) || 0;
    const remaining = Math.max(totalSellingAmount - advance, 0);
    
    $('#summary-total-selling').text(formatNumber(totalSellingAmount) + ' دینار');
    $('#summary-advance').text(formatNumber(advance) + ' دینار');
    $('#summary-remaining').text(formatNumber(remaining) + ' دینار');
}

function saveCredit() {
    const products = [];
    let hasError = false;
    
    const customerName = ($('#customer-name').val() || '').toString().trim();
    const customerPhone = ($('#customer-phone').val() || '').toString().trim();
    const customerAddress = ($('#customer-address').val() || '').toString().trim();
    
    if (!customerName) {
        showAlert('error', 'ناوی کڕیار پێویستە');
        return;
    }
    if (!customerPhone) {
        showAlert('error', 'ژمارەی مۆبایل پێویستە');
        return;
    }
    
    $('.product-item-card').each(function(index) {
        const name = ($(this).find('.product-name').val() || '').toString().trim();
        const company = ($(this).find('.product-company').val() || '').toString().trim();
        const rawPrice = $(this).find('.product-selling-price').val() || '0';
        const convertedPrice = convertToEnglishDigits(rawPrice);
        const sellingPrice = parseFloat(convertedPrice) || 0;
        
        if (!name) {
            showAlert('error', `ناوی کاڵا بۆ کاڵای #${index + 1} پێویستە`);
            hasError = true;
            return false;
        }
        
        if (sellingPrice <= 0) {
            showAlert('error', `نرخی فرۆشتن بۆ کاڵای #${index + 1} پێویستە`);
            hasError = true;
            return false;
        }
        
        products.push({
            name: name,
            company: company || 'بێ کۆمپانیا',
            selling_price: sellingPrice,
            total_selling: sellingPrice
        });
    });
    
    if (hasError || products.length === 0) return;
    
    const totalSellingAmount = products.reduce((sum, p) => sum + p.total_selling, 0);
    const rawAdvance = $('#advance-payment').val() || '0';
    const convertedAdvance = convertToEnglishDigits(rawAdvance);
    const advance = parseFloat(convertedAdvance) || 0;
    const remaining = Math.max(totalSellingAmount - advance, 0);
    const creditDate = $('#credit-date').val();
    const repaymentDate = $('#repayment-date').val();
    const notes = ($('#credit-notes').val() || '').toString().trim();
    
    if (!creditDate) {
        showAlert('error', 'تکایە بەرواری وەرگرتن دیاری بکە');
        return;
    }
    
    if (!repaymentDate) {
        showAlert('error', 'تکایە بەرواری گەڕانەوەی قەرز دیاری بکە');
        return;
    }
    
    const formData = {
        customer_name: customerName,
        customer_phone: customerPhone,
        customer_address: customerAddress,
        products: products,
        credit_date: creditDate,
        advance_payment: advance,
        repayment_date: repaymentDate,
        notes: notes,
        total_amount: totalSellingAmount,
        remaining_amount: remaining,
        _token: $('meta[name="csrf-token"]').attr('content')
    };
    
    $.ajax({
        url: '{{ route("debtors.save") }}',
        type: 'POST',
        data: formData,
        beforeSend: function() {
            $('.btn-success').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> تۆمارکردن...');
        },
        success: function(response) {
            if (response.success) {
                showAlert('success', response.message);
                clearAllFormData(true);
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
            $('.btn-success').prop('disabled', false).html('<i class="fas fa-save"></i> تۆمارکردنی قەرز <span class="shortcut-hint">F1</span>');
        }
    });
}

function formatNumber(n) {
    if (n === undefined || n === null || isNaN(n)) return '0';
    return Number(n).toLocaleString();
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

// Initialize on page load
$(document).ready(function() {
    const shouldClear = checkClearKeyword();
    
    if (shouldClear) {
        updateSummary();
    } else {
        const loaded = loadFromLocalStorage();
        
        if (!loaded) {
            addProduct();
        }
        
        updateSummary();
    }
    
    // =====================================================
    // KEYBOARD SHORTCUTS
    // =====================================================
    
    $(document).on('keydown', function(e) {
        const isInputFocused = $(e.target).is('input, textarea, select, [contenteditable="true"]');
        const suggestionsOpen = $('#customer-suggestions').is(':visible') || $('.product-suggestions').is(':visible');
        
        // F1 Key - تۆمارکردنی قەرز
        if (e.key === 'F1' || e.keyCode === 112) {
            e.preventDefault();
            
            if (!$('.btn-success').prop('disabled')) {
                showAlert('info', 'تۆمارکردنی قەرز - F1');
                saveCredit();
            }
            return false;
        }
        
        // Esc Key - Clear form (only if no suggestions are open)
        if (e.key === 'Escape' || e.keyCode === 27) {
            if (suggestionsOpen) return;
            
            if (isInputFocused) {
                $(e.target).blur();
                
                if (window._escPendingClear) {
                    clearTimeout(window._escTimer);
                    window._escPendingClear = false;
                    clearAllFormData();
                } else {
                    window._escPendingClear = true;
                    showAlert('warning', 'دووبارە Esc بکەوە بۆ پاککردنەوەی هەموو فۆرمەکە');
                    
                    window._escTimer = setTimeout(function() {
                        window._escPendingClear = false;
                    }, 2000);
                }
            } else {
                clearAllFormData();
            }
            
            return false;
        }
        
        // Ctrl+Shift+C - Alternative clear shortcut
        if (e.ctrlKey && e.shiftKey && (e.key === 'C' || e.keyCode === 67)) {
            e.preventDefault();
            clearAllFormData();
            return false;
        }
        
        // Ctrl+S - Alternative save shortcut
        if (e.ctrlKey && (e.key === 's' || e.keyCode === 83)) {
            e.preventDefault();
            if (!$('.btn-success').prop('disabled')) {
                saveCredit();
            }
            return false;
        }
    });
    
    $(document).on('click', function() {
        window._escPendingClear = false;
        if (window._escTimer) {
            clearTimeout(window._escTimer);
        }
    });
});

// Expose functions globally
window.clearDebtorForm = clearAllFormData;
window.setClearDebtorFormFlag = function() {
    sessionStorage.setItem('clear_debtor_form', 'true');
};
window.selectCustomer = selectCustomer;
window.selectProduct = selectProduct;

window.addEventListener('message', function(event) {
    if (event.data === 'clear_debtor_form') {
        clearAllFormData(true);
    }
});
</script>
@endsection