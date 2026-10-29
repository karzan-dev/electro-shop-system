@extends('layouts.navigation')

@section('content')
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ config('app.name', 'Laravel') }} - گەڕاندنەوەی پسوڵە</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    :root {
        --primary: #4a6491;
        --primary-light: #5d7ab0;
        --secondary: #2c3e50;
        --accent: #C084FC;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --info: #3b82f6;
        --text: #1e293b;
        --border-color: #e2e8f0;
        --bg-light: #f8fafc;
        --card-bg: #ffffff;
        --input-bg: #ffffff;
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
        background: #f1f5f9;
        font-family: system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
        color: var(--text);
    }

    .sales-container {
        padding: 1.5rem;
        max-width: 1600px;
        margin: 0 auto;
    }

    /* ==================== HEADER ==================== */
    .form-header-custom {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border-radius: 1.5rem;
        padding: 2rem;
        margin-bottom: 2rem;
        text-align: center;
        color: white;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .form-logo-custom {
        background: white;
        width: 5rem;
        height: 5rem;
        border-radius: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .form-logo-custom i {
        font-size: 2.5rem;
        background: linear-gradient(135deg, var(--primary), var(--accent));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* ==================== CARDS ==================== */
    .form-card {
        background: var(--card-bg);
        border-radius: 1.5rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        border: 1px solid var(--border-color);
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 700;
        text-align: center;
        margin-bottom: 1.5rem;
        color: var(--text);
        position: relative;
        padding-bottom: 0.75rem;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 3px;
        background: linear-gradient(90deg, var(--primary), var(--secondary));
        border-radius: 2px;
    }

    /* ==================== FILTERS ==================== */
    .filters-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
    }

    .filter-group label {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text);
        margin-bottom: 0.4rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .filter-input, .filter-select {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid var(--border-color);
        border-radius: 0.75rem;
        font-size: 0.9rem;
        font-weight: 600;
        background: var(--input-bg);
        color: var(--text);
        transition: all 0.3s;
    }

    .filter-input:focus, .filter-select:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(74, 100, 145, 0.15);
    }

    .btn-search {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 0.75rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s;
        width: 100%;
        font-size: 0.9rem;
    }

    .btn-search:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(74, 100, 145, 0.4);
    }

    /* ==================== INVOICE CARD ==================== */
    .invoice-card {
        background: var(--card-bg);
        border-radius: 1.5rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        border: 2px solid var(--border-color);
        transition: all 0.3s;
    }

    .invoice-card:hover {
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
    }

    .invoice-card.credit {
        border-color: #f59e0b;
        background: linear-gradient(135deg, #fffbf0, #fef3c7);
    }

    .invoice-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 2px dashed var(--border-color);
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .invoice-number {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--primary);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .invoice-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.3rem 0.8rem;
        border-radius: 2rem;
        font-size: 0.8rem;
        font-weight: 700;
    }

    .badge-cash {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        color: #065f46;
    }

    .badge-credit {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #78350f;
    }

    .badge-time {
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        color: #1e40af;
        font-size: 0.75rem;
    }

    .invoice-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 0.75rem;
        margin-bottom: 1rem;
    }

    .info-box {
        background: var(--bg-light);
        border-radius: 0.75rem;
        padding: 0.75rem;
        text-align: center;
    }

    .info-label {
        font-size: 0.7rem;
        color: #64748b;
        text-transform: uppercase;
        margin-bottom: 0.25rem;
        font-weight: 600;
    }

    .info-value {
        font-weight: 800;
        color: var(--text);
        font-size: 1rem;
    }

    .info-value.total {
        color: var(--success);
        font-size: 1.15rem;
    }

    /* ==================== CREDIT INFO ==================== */
    .credit-info-box {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        border-radius: 1rem;
        padding: 1rem;
        margin-bottom: 1rem;
        border-right: 4px solid #f59e0b;
    }

    .credit-info-title {
        font-weight: 700;
        color: #78350f;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .credit-info-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 0.5rem;
        background: white;
        border-radius: 0.75rem;
        padding: 0.75rem;
    }

    .credit-detail-row {
        display: flex;
        justify-content: space-between;
        padding: 0.3rem 0;
        font-size: 0.85rem;
    }

    .credit-label {
        color: #78350f;
        font-weight: 600;
    }

    .credit-value {
        color: #92400e;
        font-weight: 800;
    }

    /* ==================== ITEMS TABLE ==================== */
    .items-table-wrapper {
        overflow-x: auto;
        border-radius: 1rem;
        border: 2px solid var(--border-color);
        margin-top: 1rem;
    }

    .items-table {
        width: 100%;
        border-collapse: collapse;
        background: var(--card-bg);
        font-size: 0.9rem;
        min-width: 700px;
    }

    .items-table thead th {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        font-weight: 700;
        padding: 0.875rem 0.75rem;
        text-align: center;
        white-space: nowrap;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
    }

    .items-table tbody td {
        padding: 0.75rem;
        border-bottom: 1px solid var(--border-color);
        text-align: center;
        vertical-align: middle;
    }

    .items-table tbody tr:nth-child(even) {
        background: var(--bg-light);
    }

    .items-table tbody tr:hover {
        background: #dbeafe;
        transition: all 0.2s;
    }

    /* ⭐ Company Badge */
    .company-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        padding: 0.3rem 0.75rem;
        border-radius: 2rem;
        font-size: 0.75rem;
        font-weight: 700;
        white-space: nowrap;
        box-shadow: 0 2px 6px rgba(74, 100, 145, 0.3);
        transition: all 0.2s;
    }

    .company-badge:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(74, 100, 145, 0.5);
    }

    .company-badge.no-company {
        background: linear-gradient(135deg, #94a3b8, #64748b);
        font-style: italic;
        opacity: 0.85;
    }

    .barcode-badge {
        display: inline-block;
        background: #f1f5f9;
        color: #475569;
        padding: 0.2rem 0.5rem;
        border-radius: 0.5rem;
        font-size: 0.7rem;
        font-family: 'Courier New', monospace;
        font-weight: 600;
        margin-top: 0.2rem;
    }

    .qty-badge {
        display: inline-block;
        background: linear-gradient(135deg, var(--info), #2563eb);
        color: white;
        padding: 0.25rem 0.7rem;
        border-radius: 2rem;
        font-size: 0.8rem;
        font-weight: 700;
    }

    /* ==================== RETURN BUTTON ==================== */
    .btn-return-item {
        background: linear-gradient(135deg, var(--warning), #d97706);
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        cursor: pointer;
        font-size: 0.8rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        transition: all 0.2s;
        white-space: nowrap;
    }

    .btn-return-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.5);
    }

    .btn-return-item:disabled {
        background: #cbd5e1;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    /* ==================== ACTION BUTTONS ==================== */
    .action-buttons-container {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
        flex-wrap: wrap;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 2px dashed var(--border-color);
    }

    .btn-action {
        padding: 0.75rem 1.5rem;
        border-radius: 0.75rem;
        border: none;
        color: white;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.85rem;
    }

    .btn-delete-invoice {
        background: linear-gradient(135deg, var(--danger), #dc2626);
    }

    .btn-delete-invoice:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
    }

    .btn-print-invoice {
        background: linear-gradient(135deg, var(--info), #2563eb);
    }

    .btn-print-invoice:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
    }

    /* ==================== ALERTS ==================== */
    .alert-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        width: 380px;
        max-width: calc(100% - 40px);
    }

    .custom-alert {
        background: white;
        border-radius: 1.25rem;
        padding: 1.25rem 1.5rem;
        margin-bottom: 1rem;
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        animation: slideIn 0.3s ease;
    }

    @keyframes slideIn {
        from { opacity: 0; transform: translateX(50px); }
        to { opacity: 1; transform: translateX(0); }
    }

    .alert-success { background: linear-gradient(135deg, #ecfdf5, #d1fae5); border-right: 5px solid var(--success); color: #065f46; }
    .alert-error { background: linear-gradient(135deg, #fef2f2, #fee2e2); border-right: 5px solid var(--danger); color: #991b1b; }
    .alert-warning { background: linear-gradient(135deg, #fffbeb, #fef3c7); border-right: 5px solid var(--warning); color: #92400e; }
    .alert-info { background: linear-gradient(135deg, #eff6ff, #dbeafe); border-right: 5px solid var(--info); color: #1e40af; }

    .alert-icon {
        font-size: 1.75rem;
        min-width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.5);
        border-radius: 0.75rem;
    }

    /* ==================== EMPTY STATE ==================== */
    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #94a3b8;
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    /* ==================== LOADING ==================== */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(5px);
        z-index: 10000;
        display: none;
        align-items: center;
        justify-content: center;
    }

    .loading-overlay.active {
        display: flex;
    }

    .loading-spinner {
        background: white;
        border-radius: 2rem;
        padding: 2rem;
        text-align: center;
    }

    .loading-spinner i {
        font-size: 3rem;
        color: var(--primary);
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    /* ==================== RESPONSIVE ==================== */
    @media (max-width: 768px) {
        .sales-container { padding: 1rem; }
        .form-header-custom { padding: 1.5rem 1rem; }
        .form-header-custom h1 { font-size: 1.25rem; }
        .form-card { padding: 1rem; }
        .items-table { font-size: 0.8rem; min-width: 600px; }
        .items-table thead th, .items-table tbody td { padding: 0.5rem 0.4rem; font-size: 0.75rem; }
        .company-badge { font-size: 0.65rem; padding: 0.2rem 0.5rem; }
        .invoice-info-grid { grid-template-columns: 1fr 1fr; }
        .invoice-header { flex-direction: column; align-items: flex-start; }
    }
</style>

<!-- Alert Container -->
<div id="alert-container" class="alert-container"></div>

<!-- Loading Overlay -->
<div id="loading-overlay" class="loading-overlay">
    <div class="loading-spinner">
        <i class="fas fa-spinner fa-spin"></i>
        <p>تکایە چاوەڕێ بە...</p>
    </div>
</div>

<!-- Main Container -->
<div class="sales-container">
    <!-- Header -->
    <div class="form-header-custom">
        <div class="form-logo-custom">
            <i class="fas fa-file-invoice"></i>
        </div>
        <h1 style="font-size: 1.5rem; margin-bottom: 0.5rem;">گەڕاندنەوە و سڕینەوەی پسوڵە</h1>
        <p style="opacity: 0.9;">گەڕان بە ژمارەی پسوڵە یان بارکۆد بۆ گەڕاندنەوە</p>
    </div>

    <!-- Filters -->
    <div class="form-card">
        <p class="section-title">گەڕان و فلتەرکردن</p>
        <div class="filters-grid">
            <div class="filter-group">
                <label><i class="fas fa-search"></i> ژمارەی پسوڵە</label>
                <input type="text" id="search-invoice" class="filter-input" placeholder="INV-0001" autocomplete="off">
            </div>
            <div class="filter-group">
                <label><i class="fas fa-barcode"></i> بارکۆد</label>
                <input type="text" id="search-barcode" class="filter-input" placeholder="بارکۆد..." autocomplete="off">
            </div>
            <div class="filter-group">
                <label><i class="fas fa-credit-card"></i> جۆری پارەدان</label>
                <select id="filter-payment" class="filter-select">
                    <option value="all">هەموو</option>
                    <option value="cash">نەقد</option>
                    <option value="credit">قەرز</option>
                </select>
            </div>
            <div class="filter-group">
                <label><i class="fas fa-clock"></i> کاتی ڕۆژ</label>
                <select id="filter-time" class="filter-select">
                    <option value="all">هەموو</option>
                    <option value="morning">بەیانی</option>
                    <option value="afternoon">ئێوارە</option>
                    <option value="night">شەو</option>
                </select>
            </div>
            <div class="filter-group">
                <label><i class="fas fa-calendar"></i> لە بەرواری</label>
                <input type="date" id="filter-from-date" class="filter-input">
            </div>
            <div class="filter-group">
                <label><i class="fas fa-calendar"></i> بۆ بەرواری</label>
                <input type="date" id="filter-to-date" class="filter-input">
            </div>
            <div class="filter-group">
                <label>&nbsp;</label>
                <button class="btn-search" onclick="loadInvoices()">
                    <i class="fas fa-search"></i> گەڕان
                </button>
            </div>
        </div>
    </div>

    <!-- Invoices Container -->
    <div id="invoices-container">
        <div class="empty-state">
            <i class="fas fa-file-invoice"></i>
            <p>تکایە گەڕان بکە بۆ پیشاندانی پسوڵەکان</p>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
});

// ==================== ALERT ====================
function showAlert(type, message, title = '') {
    const icons = {
        success: 'fa-check-circle',
        error: 'fa-exclamation-circle',
        warning: 'fa-exclamation-triangle',
        info: 'fa-info-circle'
    };

    const titles = {
        success: '✅ سەرکەوتوو',
        error: '❌ هەڵە',
        warning: '⚠️ ئاگاداری',
        info: 'ℹ️ زانیاری'
    };

    const id = 'alert-' + Date.now();
    const html = `
        <div id="${id}" class="custom-alert alert-${type}">
            <div class="alert-icon">
                <i class="fas ${icons[type]}"></i>
            </div>
            <div style="flex: 1;">
                <strong>${title || titles[type]}</strong>
                <div style="margin-top: 0.25rem; font-size: 0.9rem;">${message}</div>
            </div>
        </div>
    `;

    $('#alert-container').append(html);
    setTimeout(() => $(`#${id}`).fadeOut(300, function() { $(this).remove(); }), 4000);
}

// ==================== FORMAT NUMBER ====================
function formatNumber(num) {
    if (num === null || num === undefined || isNaN(num)) return '0';
    return Math.round(num).toLocaleString();
}

// ==================== ESCAPE HTML ====================
function escapeHtml(text) {
    if (!text) return '';
    return String(text).replace(/[&<>"']/g, function(m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        if (m === '"') return '&quot;';
        if (m === "'") return '&#39;';
        return m;
    });
}

// ==================== TIME OF DAY ====================
function getTimeOfDayText(timeOfDay) {
    const map = {
        'morning': { text: 'بەیانی', icon: 'fa-sun', color: '#f59e0b' },
        'afternoon': { text: 'ئێوارە', icon: 'fa-cloud-sun', color: '#3b82f6' },
        'night': { text: 'شەو', icon: 'fa-moon', color: '#1e293b' }
    };
    return map[timeOfDay] || { text: 'نەزانراو', icon: 'fa-clock', color: '#64748b' };
}

// ==================== LOAD INVOICES ====================
function loadInvoices() {
    const search = $('#search-invoice').val().trim();
    const barcode = $('#search-barcode').val().trim();
    const filter = $('#filter-payment').val();
    const timeFilter = $('#filter-time').val();
    const fromDate = $('#filter-from-date').val();
    const toDate = $('#filter-to-date').val();

    $('#loading-overlay').addClass('active');

    $.ajax({
        url: '/get-invoices',
        type: 'POST',
        data: {
            search: search,
            barcode: barcode,
            filter: filter,
            time_filter: timeFilter,
            from_date: fromDate,
            to_date: toDate,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success && response.invoices && response.invoices.length > 0) {
                renderInvoices(response.invoices);
            } else {
                $('#invoices-container').html(`
                    <div class="form-card">
                        <div class="empty-state">
                            <i class="fas fa-search"></i>
                            <p>هیچ پسوڵەیەک نەدۆزرایەوە</p>
                        </div>
                    </div>
                `);
            }
        },
        error: function(xhr) {
            console.error('Error loading invoices:', xhr);
            showAlert('error', 'هەڵە لە بارکردنی پسوڵەکان');
            $('#invoices-container').html(`
                <div class="form-card">
                    <div class="empty-state">
                        <i class="fas fa-exclamation-circle"></i>
                        <p>هەڵە لە بارکردنی پسوڵەکان</p>
                    </div>
                </div>
            `);
        },
        complete: function() {
            $('#loading-overlay').removeClass('active');
        }
    });
}

// ==================== RENDER INVOICES ====================
function renderInvoices(invoices) {
    let html = '';

    invoices.forEach(invoice => {
        const date = new Date(invoice.created_at);
        const dateStr = date.toLocaleDateString('ku-Arab');
        const timeStr = date.toLocaleTimeString('ku-Arab', { hour: '2-digit', minute: '2-digit' });

        const timeOfDay = getTimeOfDayText(invoice.time_of_day);
        const isCredit = invoice.is_credit;
        const cardClass = isCredit ? 'invoice-card credit' : 'invoice-card';

        // Credit Info Section
        let creditSection = '';
        if (isCredit && invoice.credit_info) {
            creditSection = `
                <div class="credit-info-box">
                    <div class="credit-info-title">
                        <i class="fas fa-hand-holding-usd"></i>
                        ئاگاداری! ئەم پسوڵەیە بە قەرز کڕاوە
                    </div>
                    <div class="credit-info-details">
                        <div class="credit-detail-row">
                            <span class="credit-label"><i class="fas fa-user"></i> کڕیار:</span>
                            <span class="credit-value">${escapeHtml(invoice.credit_info.customer_name || '-')}</span>
                        </div>
                        <div class="credit-detail-row">
                            <span class="credit-label"><i class="fas fa-phone"></i> مۆبایل:</span>
                            <span class="credit-value">${escapeHtml(invoice.credit_info.phone_number || '-')}</span>
                        </div>
                        <div class="credit-detail-row">
                            <span class="credit-label"><i class="fas fa-calendar-alt"></i> کاتی گەڕانەوە:</span>
                            <span class="credit-value">${escapeHtml(invoice.credit_info.time_to_return || '-')}</span>
                        </div>
                    </div>
                </div>
            `;
        }

        // Items Table Rows - with COMPANY
        let itemsRows = '';
        if (invoice.items && invoice.items.length > 0) {
            invoice.items.forEach((item, idx) => {
                // ⭐ ناوی کۆمپانیا - پشتگیری هەردووکی
                const companyName = item.company_name || item.company || 'بێ کۆمپانیا';
                const hasCompany = companyName && companyName !== 'بێ کۆمپانیا' && companyName.trim() !== '';
                const companyClass = hasCompany ? 'company-badge' : 'company-badge no-company';

                // Check if returned
                const returnItem = invoice.return_items?.find(r => r.Item_Code == item.product_id);
                const isReturned = !!returnItem;
                const availableQty = isReturned ? 0 : item.quantity_sold;

                itemsRows += `
                    <tr>
                        <td><strong>${idx + 1}</strong></td>
                        <td style="text-align: right;">
                            <strong>${escapeHtml(item.name)}</strong>
                            ${item.barcode ? `<br><span class="barcode-badge"><i class="fas fa-barcode"></i> ${escapeHtml(item.barcode)}</span>` : ''}
                        </td>
                        <td>
                            <span class="${companyClass}">
                                <i class="fas fa-building"></i> ${escapeHtml(companyName)}
                            </span>
                        </td>
                        <td>
                            <span class="qty-badge">${item.quantity_sold}</span>
                        </td>
                        <td><strong>${formatNumber(item.selling_price)} د.ع</strong></td>
                        <td><strong style="color: var(--success);">${formatNumber(item.total)} د.ع</strong></td>
                        <td>
                            ${availableQty > 0 ? `
                                <button class="btn-return-item" onclick="returnItem(${item.id}, ${availableQty}, '${escapeHtml(item.name)}')">
                                    <i class="fas fa-undo"></i> گەڕاندنەوە
                                </button>
                            ` : `
                                <button class="btn-return-item" disabled>
                                    <i class="fas fa-check"></i> گەڕێنراوەتەوە
                                </button>
                            `}
                        </td>
                    </tr>
                `;
            });
        }

        html += `
            <div class="${cardClass}">
                <div class="invoice-header">
                    <div class="invoice-number">
                        <i class="fas fa-file-invoice"></i>
                        ${escapeHtml(invoice.invoice_number)}
                    </div>
                    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                        <span class="invoice-badge ${isCredit ? 'badge-credit' : 'badge-cash'}">
                            <i class="fas ${isCredit ? 'fa-hand-holding-usd' : 'fa-money-bill-wave'}"></i>
                            ${isCredit ? 'قەرز' : 'نەقد'}
                        </span>
                        <span class="invoice-badge badge-time" style="color: ${timeOfDay.color};">
                            <i class="fas ${timeOfDay.icon}"></i>
                            ${timeOfDay.text}
                        </span>
                    </div>
                </div>

                <div class="invoice-info-grid">
                    <div class="info-box">
                        <div class="info-label">بەروار</div>
                        <div class="info-value">${dateStr}</div>
                    </div>
                    <div class="info-box">
                        <div class="info-label">کات</div>
                        <div class="info-value">${timeStr}</div>
                    </div>
                    <div class="info-box">
                        <div class="info-label">کۆی گشتی</div>
                        <div class="info-value">${formatNumber(invoice.subtotal)} د.ع</div>
                    </div>
                    <div class="info-box">
                        <div class="info-label">داشکاندن</div>
                        <div class="info-value" style="color: var(--warning);">${formatNumber(invoice.discount)} د.ع</div>
                    </div>
                    <div class="info-box">
                        <div class="info-label">کۆتایی</div>
                        <div class="info-value total">${formatNumber(invoice.total)} د.ع</div>
                    </div>
                </div>

                ${creditSection}

                <div class="items-table-wrapper">
                    <table class="items-table">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="22%">ناوی کاڵا</th>
                                <th width="15%">کۆمپانیا</th>
                                <th width="10%">بڕ</th>
                                <th width="13%">نرخ</th>
                                <th width="15%">کۆی گشتی</th>
                                <th width="15%">کردار</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${itemsRows}
                        </tbody>
                    </table>
                </div>

                <div class="action-buttons-container">
                    <button class="btn-action btn-print-invoice" onclick="printInvoice(${invoice.id})">
                        <i class="fas fa-print"></i> پرینتکردن
                    </button>
                    <button class="btn-action btn-delete-invoice" onclick="deleteInvoice(${invoice.id}, '${escapeHtml(invoice.invoice_number)}')">
                        <i class="fas fa-trash"></i> سڕینەوەی پسوڵە
                    </button>
                </div>
            </div>
        `;
    });

    $('#invoices-container').html(html);
}

// ==================== RETURN ITEM ====================
function returnItem(itemId, availableQty, itemName) {
    if (!confirm(`دڵنیایت کە دەتەوێت "${itemName}" بگەڕێنیتەوە؟\n\nبڕی بەردەست: ${availableQty}`)) {
        return;
    }

    const quantityToReturn = prompt(`چەند دانە دەتەوێت بگەڕێنیتەوە؟ (1 - ${availableQty})`, availableQty);

    if (!quantityToReturn || parseInt(quantityToReturn) < 1 || parseInt(quantityToReturn) > availableQty) {
        showAlert('warning', `بڕی گەڕاندنەوە دەبێت لە نێوان 1 و ${availableQty} بێت`);
        return;
    }

    $.ajax({
        url: '/returns/store',
        type: 'POST',
        data: {
            items: JSON.stringify([{ item_id: itemId, quantity: parseInt(quantityToReturn), price: 0 }]),
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function() {
            $('#loading-overlay').addClass('active');
        },
        success: function(response) {
            if (response.success) {
                showAlert('success', 'کاڵا بە سەرکەوتوویی گەڕێنرایەوە');
                loadInvoices();
            } else {
                showAlert('error', response.message || 'هەڵەیەک ڕوویدا');
            }
        },
        error: function(xhr) {
            showAlert('error', xhr.responseJSON?.message || 'هەڵەیەک ڕوویدا');
        },
        complete: function() {
            $('#loading-overlay').removeClass('active');
        }
    });
}

// ==================== DELETE INVOICE ====================
function deleteInvoice(invoiceId, invoiceNumber) {
    if (!confirm(`دڵنیایت کە دەتەوێت پسوڵەی ${invoiceNumber} بسڕیتەوە؟\n\n⚠️ ئەم کردارە هەڵنەگەڕێتەوە!`)) {
        return;
    }

    $.ajax({
        url: '/returns/delete-invoice',
        type: 'POST',
        data: {
            invoice_id: invoiceId,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function() {
            $('#loading-overlay').addClass('active');
        },
        success: function(response) {
            if (response.success) {
                showAlert('success', 'پسوڵە بە سەرکەوتوویی سڕایەوە');
                loadInvoices();
            } else {
                showAlert('error', response.message || 'هەڵەیەک ڕوویدا');
            }
        },
        error: function(xhr) {
            showAlert('error', xhr.responseJSON?.message || 'هەڵەیەک ڕوویدا');
        },
        complete: function() {
            $('#loading-overlay').removeClass('active');
        }
    });
}

// ==================== PRINT INVOICE ====================
function printInvoice(invoiceId) {
    window.open('/invoice/' + invoiceId, '_blank');
}

// ==================== EVENT HANDLERS ====================
$(document).ready(function() {
    // Load invoices on page load
    loadInvoices();

    // Enter key on search
    $('#search-invoice, #search-barcode').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            loadInvoices();
        }
    });

    // Auto search on filter change
    $('#filter-payment, #filter-time, #filter-from-date, #filter-to-date').on('change', function() {
        loadInvoices();
    });
});
</script>
@endsection