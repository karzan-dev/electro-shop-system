@extends('layouts.navigation')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

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
    }

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
    }

    .form-logo-custom i {
        font-size: 2.5rem;
        background: linear-gradient(135deg, var(--primary), var(--accent));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .section-title-custom {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid var(--accent);
    }

    .input-with-icon-custom {
        position: relative;
    }

    .input-with-icon-custom .form-control {
        padding-left: 3rem;
    }

    .input-with-icon-custom i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--primary);
        font-size: 1.1rem;
        z-index: 4;
    }

    /* دیزاینی سێرچ */
    .search-container {
        position: relative;
    }

    .search-wrapper {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border: 2px solid var(--primary);
        transition: all 0.3s ease;

    }

    .search-wrapper:focus-within {
        box-shadow: 0 6px 20px rgba(74, 100, 145, 0.3);
        border-color: var(--accent);
    }

    .search-input {
        width: 100%;
        padding: 1rem 1rem 1rem 4rem !important;
        border: none !important;
        font-size: 1.1rem;


    }

    .search-input:focus {
        outline: none !important;
        box-shadow: none !important;
    }

    .search-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--primary);
        z-index: 10;
        font-size: 1.3rem;
    }

    /* دیزاینی هەموو alertەکان */
    .custom-alert {
        border-radius: 12px;
        border: none;
        padding: 16px 20px;
        margin-bottom: 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        display: flex;
        align-items: center;
        animation: slideDown 0.3s ease-out;
        position: relative;
        overflow: hidden;
    }

    .custom-alert::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 5px;
        height: 100%;
    }

    .alert-success-custom {
        background: rgba(12, 239, 4, 0.982);
        color: #065f46;
        border-left: 5px solid var(--success);
    }

    .alert-success-custom::before {
        background: var(--success);
    }

    .alert-error-custom {
        background: rgba(239, 12, 4, 0.982);
        color: #740a0a;
        border-left: 5px solid var(--danger);
    }

    .alert-error-custom::before {
        background: var(--danger);
    }

    .alert-warning-custom {
        background: rgba(249, 115, 22, 0.98);
        color: #9a3412;
        border-left: 5px solid var(--warning);
    }

    .alert-warning-custom::before {
        background: var(--warning);
    }

    .alert-info-custom {
        background: rgba(59, 130, 246, 0.98);
        color: #1e3a8a;
        border-left: 5px solid var(--info);
    }

    .alert-info-custom::before {
        background: var(--info);
    }

    .alert-icon {
        font-size: 1.5rem;
        margin-left: 15px;
        flex-shrink: 0;
    }

    .alert-content {
        flex-grow: 1;
    }

    .alert-title {
        font-weight: 700;
        font-size: 1.05rem;
        margin-bottom: 5px;
    }

    .alert-message {
        font-size: 0.95rem;
        line-height: 1.5;
    }

    .alert-close {
        background: none;
        border: none;
        color: inherit;
        opacity: 0.7;
        font-size: 1.2rem;
        cursor: pointer;
        padding: 0;
        margin-right: 5px;
        transition: opacity 0.3s;
    }

    .alert-close:hover {
        opacity: 1;
    }

    .custom-toast {
        position: fixed;
        bottom: 30px;
        left: 30px;
        z-index: 9999;
        max-width: 350px;
        animation: slideInLeft 0.3s ease-out;
    }

    .btn-custom-primary {
        background: linear-gradient(135deg, var(--primary), var(--accent));
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.75rem 2rem;
        box-shadow: 0 4px 15px rgba(74, 100, 145, 0.3);
        transition: all 0.3s ease;
    }

    .btn-custom-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(74, 100, 145, 0.4);
    }

    .btn-custom-secondary {
        background-color: white;
        color: var(--primary);
        border: 2px solid var(--primary);
        font-weight: 600;
        padding: 0.75rem 2rem;
    }

    .btn-custom-secondary:hover {
        background-color: #f8f9fa;
    }

    /* ئەنیمەیشنەکان */
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

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes fadeOut {
        from {
            opacity: 1;
        }
        to {
            opacity: 0;
        }
    }

    /* Styles for validation errors */
    .validation-error {
        color: var(--danger);
        font-size: 0.875rem;
        margin-top: 0.25rem;
        display: none;
    }

    .has-error .form-control {
        border-color: var(--danger);
    }

    /* زیادکردنی ستایل بۆ فیلدەکان readonly */
    .form-control:read-only {
        background-color: #f8f9fa !important;
        cursor: not-allowed;
        opacity: 0.9;
        border-color: #dee2e6 !important;
    }

    .readonly-field {
        background-color:rgb(26, 90, 26) !important;

    }

    .readonly-label {
        color: #6c757d !important;
        font-weight: 500 !important;
    }

    .readonly-field-container {
        position: relative;
    }

    .readonly-badge {
        position: absolute;
        top: -8px;
        left: 10px;
        background-color: var(--info);
        color: white;
        font-size: 0.7rem;
        padding: 2px 8px;
        border-radius: 4px;
        z-index: 5;
    }

    .readonly-icon {
        color: var(--info) !important;
    }

    /* فیلدەکانی دەستکاریپذیر */
    .editable-field {
        background-color: white !important;
        border-color: #ced4da !important;
        color: var(--text) !important;
    }

    .editable-label {
        color: var(--text) !important;
        font-weight: 600 !important;
    }

    .form-control:disabled {
        background-color: #f8f9fa;
        opacity: 0.8;
    }

    /* Loading spinner */
    .loading-spinner {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 3px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        border-top-color: white;
        animation: spin 1s ease-in-out infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* وێنەی کاڵا - تەنها نیشاندەر */
    .image-display-container {
        border: 2px solid var(--primary);
        border-radius: 12px;
        padding: 1rem;
        text-align: center;
        background: rgba(74, 100, 145, 0.05);
        transition: all 0.3s ease;
        min-height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .image-preview-container {
        width: 100%;
        max-width: 800px;
        margin: 0 auto;
    }

    .image-preview {
        width: 100%;
        max-height: 250px;
        object-fit: contain;
        border-radius: 8px;
        border: 2px solid var(--primary);
        background: white;
        padding: 5px;
    }

    .no-image-message {
        color: #6c757d;
        text-align: center;
        padding: 2rem;
    }

    .no-image-message i {
        font-size: 3rem;
        margin-bottom: 1rem;
        display: block;
    }

    @media (max-width: 768px) {
        .custom-toast {
            left: 15px;
            right: 15px;
            max-width: none;
        }

        .search-input {
            padding: 0.75rem 0.75rem 0.75rem 3.5rem !important;

        }

        .readonly-badge {
            font-size: 0.6rem;
            padding: 1px 6px;
        }

        .image-display-container {
            min-height: 150px;
        }
    }

.search-input::placeholder{
    color: #98b0a9;

}

.search-input{
     color: rgba(255, 255, 255, 0.886) !important;
}
</style>

<!-- Alert Container -->
<div id="alert-container" style="position: fixed; top: 20px; right: 20px; z-index: 9999; width: 350px;"></div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-11">
            <div class="card shadow-lg border-0 overflow-hidden">
                <!-- Form Header -->
                <div class="card-header form-header-custom text-white text-center py-4">
                    <div class="form-logo-custom">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <h1 class="h2 mb-2">زیادکردنی کاڵا بۆ ناو کۆگا</h1>

                </div>

                <!-- Form Body -->
                <div class="card-body p-4 p-md-5">
                    <form id="product-form" method="POST">
                        @csrf

                        <!-- Search Section -->
                        <div class="mb-5">
                            <h3 class="section-title-custom">
                                <i class="fas fa-search ms-2"></i>سێرچ بە بارکۆد
                            </h3>

                            <div class="mb-4">
                                <label for="barcode-search" class="form-label fw-semibold readonly-label">
                                    <i class="fas fa-lock readonly-icon ms-1" style="font-size: 0.8rem;"></i>
                                    بارکۆدی کاڵا
                                </label>

                                <div class="search-container">
                                    <div class="search-wrapper">
                                        <i class="fas fa-barcode search-icon"></i>
                                        <input type="text"
                                               id="barcode-search"
                                               class="form-control search-input readonly-field"
                                               placeholder="بارکۆد بنووسە  ..." >
                                    </div>

                                    <div class="validation-error" id="search-error"></div>
                                </div>
                            </div>

                            <!-- Hidden barcode input for form submission -->
                            <input type="hidden" id="product-barcode" name="barcode">

                            <div class="row">
                                <div class="col-md-6 mb-4 readonly-field-container">
                                    <label for="product-name" class="form-label fw-semibold readonly-label">
                                        <i class="fas fa-lock readonly-icon ms-1" style="font-size: 0.8rem;"></i>
                                        ناوی کاڵا
                                    </label>

                                    <div class="input-with-icon-custom">
                                        <i class="fas fa-tag readonly-icon"></i>
                                        <input type="text" id="product-name" name="name"
                                               class="form-control form-control-lg readonly-field" readonly
                                               placeholder="ناوی کاڵا">
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4 readonly-field-container">
                                    <label for="company-name" class="form-label fw-semibold readonly-label">
                                        <i class="fas fa-lock readonly-icon ms-1" style="font-size: 0.8rem;"></i>
                                        ناوی کۆمپانیا
                                    </label>

                                    <div class="input-with-icon-custom">
                                        <i class="fas fa-building readonly-icon"></i>
                                        <input type="text" id="company-name" name="company"
                                               class="form-control form-control-lg readonly-field" readonly
                                               placeholder="ناوی کۆمپانیا">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Pricing and Storage -->
                        <div class="mb-5">
                            <h3 class="section-title-custom">
                                <i class="fas fa-chart-line ms-2"></i>نرخ و کۆگاکردن
                            </h3>

                            <div class="row">
                                <!-- نرخی کڕین - دەستکاریپذیر -->
                                <div class="col-md-6 mb-4">
                                    <label for="purchase-price" class="form-label fw-semibold editable-label">
                                        <span class="text-danger">*</span> نرخی کڕین (دینار)
                                    </label>
                                    <div class="input-with-icon-custom">
                                        <i class="fas fa-shopping-cart"></i>
                                        <input type="text" id="purchase-price" name="purchase_price"
                                               class="form-control editable-field"
                                               placeholder="0" required>
                                    </div>
                                    <div class="validation-error" id="purchase_price-error"></div>
                                </div>

                                <!-- نرخی فرۆشتن - دەستکاریپذیر -->
                                <div class="col-md-6 mb-4">
                                    <label for="selling-price" class="form-label fw-semibold editable-label">
                                        <span class="text-danger">*</span> نرخی فرۆشتن (دینار)
                                    </label>
                                    <div class="input-with-icon-custom">
                                        <i class="fas fa-cash-register"></i>
                                        <input type="text" id="selling-price" name="selling_price"
                                               class="form-control editable-field"
                                               placeholder="0" required>
                                    </div>
                                    <div class="validation-error" id="selling_price-error"></div>
                                </div>

                                <!-- کەمترین بڕ لە کۆگا - تەنها نیشاندەر -->
                                <div class="col-md-6 mb-4 readonly-field-container">
                                    <label for="minimum-stock" class="form-label fw-semibold readonly-label">
                                        <i class="fas fa-lock readonly-icon ms-1" style="font-size: 0.8rem;"></i>
                                        کەمترین بڕ لە کۆگا
                                    </label>

                                    <div class="input-with-icon-custom">
                                        <i class="fas fa-exclamation-triangle readonly-icon"></i>
                                        <input type="number" id="minimum-stock" name="minimum_wearhouse"
                                               class="form-control readonly-field" readonly
                                               placeholder="ژمارە">
                                    </div>
                                </div>

                                <!-- بڕی ئێستای کۆگا - دەستکاریپذیر -->
                                <div class="col-md-6 mb-4">
                                    <label for="current-stock" class="form-label fw-semibold editable-label">
                                        <span class="text-danger">*</span> بڕی ئێستا بۆ ناو  کۆگا
                                    </label>
                                    <div class="input-with-icon-custom">
                                        <i class="fas fa-boxes"></i>
                                        <input type="number" id="current-stock" name="current_stock"
                                               class="form-control editable-field"
                                               placeholder="ژمارە" min="0" required>
                                    </div>
                                    <div class="validation-error" id="current_stock-error"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 3: Product Image Display -->
                        <div class="mb-5">
                            <h3 class="section-title-custom">
                                <i class="fas fa-image ms-2"></i>وێنەی کاڵا
                            </h3>

                            <div class="mb-4">
                                <label class="form-label fw-semibold readonly-label">
                                    <i class="fas fa-lock readonly-icon ms-1" style="font-size: 0.8rem;"></i>
                                    وێنەی کاڵا
                                </label>

                                <div class="image-display-container" id="image-display-container">
                                    <!-- Image Preview -->
                                    <div id="image-preview-section" class="d-none">
                                        <div class="image-preview-container">
                                            <img id="product-image-preview" class="image-preview" src="" alt="وێنەی کاڵا">
                                        </div>
                                    </div>

                                    <!-- Default State -->
                                    <div id="no-image-section">
                                        <div class="no-image-message">
                                            <i class="fas fa-image text-muted"></i>
                                            <h5 class="text-muted mb-2">وێنە بوونی نییە</h5>
                                            <p class="small text-muted">لەگەڵ سێرچکردنی بارکۆد وێنەکە خۆکارانە دەردەکەوێت</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center pt-4 border-top">
                            <button type="submit" class="btn btn-custom-primary" id="submit-btn">
                                <i class="fas fa-save ms-2"></i>تۆمارکردنی کاڵا
                            </button>
                        </div>
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
    let searchDebounceTimer = null;

    // CSRF Token setup for AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Function to show alert
    function showAlert(type, title, message, duration = 5000) {
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
            case 'info':
                icon = 'fas fa-info-circle';
                alertClass = 'alert-info-custom';
                break;
            default:
                icon = 'fas fa-info-circle';
                alertClass = 'alert-info-custom';
        }

        const alertId = 'alert-' + Date.now();
        const alertHtml = `
            <div id="${alertId}" class="custom-alert ${alertClass} mb-3">
                <i class="${icon} alert-icon"></i>
                <div class="alert-content">
                    <div class="alert-title">${title}</div>
                    <div class="alert-message">${message}</div>
                </div>
                <button class="alert-close" onclick="$('#${alertId}').fadeOut(300, function() { $(this).remove(); })">×</button>
            </div>
        `;

        $('#alert-container').prepend(alertHtml);

        if (duration > 0) {
            setTimeout(() => {
                $(`#${alertId}`).fadeOut(300, function() {
                    $(this).remove();
                });
            }, duration);
        }
    }

    // Function to show toast
    function showToast(type, message, duration = 3000) {
        let icon, toastClass;

        switch(type) {
            case 'success':
                icon = 'fas fa-check-circle';
                toastClass = 'alert-success-custom';
                break;
            case 'error':
                icon = 'fas fa-exclamation-circle';
                toastClass = 'alert-error-custom';
                break;
            default:
                icon = 'fas fa-info-circle';
                toastClass = 'alert-info-custom';
        }

        const toastId = 'toast-' + Date.now();
        const toastHtml = `
            <div id="${toastId}" class="custom-toast">
                <div class="custom-alert ${toastClass}">
                    <i class="${icon} alert-icon"></i>
                    <div class="alert-content">
                        <div class="alert-message">${message}</div>
                    </div>
                    <button class="alert-close" onclick="$('#${toastId}').remove()">×</button>
                </div>
            </div>
        `;

        $('body').append(toastHtml);

        setTimeout(() => {
            $(`#${toastId}`).fadeOut(300, function() {
                $(this).remove();
            });
        }, duration);
    }

    // Clear validation errors
    function clearValidationErrors() {
        $('.validation-error').hide().empty();
        $('.has-error').removeClass('has-error');
        $('.is-invalid').removeClass('is-invalid');
    }

    // Show validation errors
    function showValidationErrors(errors) {
        clearValidationErrors();

        $.each(errors, function(field, messages) {
            const fieldId = field.replace('.', '_') + '-error';
            const errorDiv = $(`#${fieldId}`);
            const inputField = $(`[name="${field}"]`);

            if (errorDiv.length && inputField.length) {
                errorDiv.html(messages.join('<br>')).show();
                inputField.closest('.input-with-icon-custom').addClass('has-error');
                inputField.addClass('is-invalid');
            }
        });
    }

    // Clear form
    function clearForm() {
        $('#product-form')[0].reset();
        clearValidationErrors();

        // Clear barcode search
        $('#barcode-search').val('');
        $('#product-barcode').val('');

        // Clear all fields
        $('.form-control').val('');

        // Reset image display
        $('#image-preview-section').addClass('d-none');
        $('#no-image-section').removeClass('d-none');

        // Enable barcode search field
        $('#barcode-search').prop('disabled', false);


    }

    // Function to search product by barcode with debounce
    function searchProductByBarcode(barcode) {
        if (!barcode || barcode.trim() === '') {
            console.log('بارکۆد بەتاڵە');
            return;
        }

        console.log('دەستپێکردنی سێرچ بۆ بارکۆد:', barcode);

        // Show loading state
        $('#barcode-search').prop('disabled', true);
        $('.search-icon').removeClass('fa-barcode').addClass('fa-spinner fa-spin');

        $.ajax({
            url: '{{ route("products.searchByBarcode") }}',
            type: 'POST',
            data: {
                barcode: barcode.trim()
            },
            success: function(response) {
                console.log('وەڵامی سێرچ:', response);

                if (response.success && response.product) {
                    // Fill form with product data
                    fillFormWithProductData(response.product);

                    // Update hidden barcode field
                    $('#product-barcode').val(barcode.trim());


                } else {

                    showAlert('error', 'کاڵا بەم بارکۆدە نەدۆزرایەوە!');

                    // Clear all fields
                    $('#product-barcode').val('');
                    $('#product-name').val('');
                    $('#company-name').val('');
                    $('#purchase-price').val('');
                    $('#selling-price').val('');
                    $('#minimum-stock').val('');
                    $('#current-stock').val('');

                    // Reset image display
                    $('#image-preview-section').addClass('d-none');
                    $('#no-image-section').removeClass('d-none');
                }
            },
            error: function(xhr, status, error) {
                console.error('هەڵە لە سێرچ:', error);
                console.error('Status:', xhr.status);

                if (xhr.status === 404) {
                    showAlert('warning', 'ئاگاداری', 'کاڵا بەم بارکۆدە نەدۆزرایەوە!');

                    // Clear all fields
                    $('#product-barcode').val('');
                    $('#product-name').val('');
                    $('#company-name').val('');
                    $('#purchase-price').val('');
                    $('#selling-price').val('');
                    $('#minimum-stock').val('');
                    $('#current-stock').val('');

                    // Reset image display
                    $('#image-preview-section').addClass('d-none');
                    $('#no-image-section').removeClass('d-none');
                } else {
                    showAlert('error', 'هەڵە', 'هەڵەیەک ڕوویدا لە کاتی سێرچدا. تکایە دووبارە هەوڵبدەرەوە.');
                }
            },
            complete: function() {
                console.log('سێرچ کۆتایی هات');
                $('#barcode-search').prop('disabled', false);
                $('.search-icon').removeClass('fa-spinner fa-spin').addClass('fa-barcode');
            }
        });
    }

    // Function to fill form with product data (including image)
    function fillFormWithProductData(product) {
        console.log('Product data:', product);

        // Fill basic information (readonly fields)
        $('#product-barcode').val(product.barcode || '');

        if (product.name) {
            $('#product-name').val(product.name || '');
        }

        if (product.company) {
            $('#company-name').val(product.company || '');
        }

        // Fill pricing (editable fields)
        if (product.purchase_price) {
            const purchasePrice = parseFloat(product.purchase_price) || 0;
            $('#purchase-price').val(formatNumber(purchasePrice));
        } else {
            $('#purchase-price').val('');
        }

        if (product.selling_price) {
            const sellingPrice = parseFloat(product.selling_price) || 0;
            $('#selling-price').val(formatNumber(sellingPrice));
        } else {
            $('#selling-price').val('');
        }

        // Fill stock information
        if (product.minimum_wearhouse) {
            $('#minimum-stock').val(product.minimum_wearhouse);
        } else {
            $('#minimum-stock').val('');
        }

        // Fill current stock (editable field)
        if (product.current_stock) {
            $('#current-stock').val(product.current_stock);
        } else {
            $('#current-stock').val('');
        }

        // Display image if exists
        if (product.image_product_path || product.image_producte_path) {
            const imagePath = product.image_product_path || product.image_producte_path;
            console.log('وێنەی دۆزراوە:', imagePath);

            const baseUrl = '{{ url("/") }}';
            let fullImageUrl;

            if (imagePath.startsWith('public/')) {
                fullImageUrl = baseUrl + '/' + imagePath.replace('public/', '');
            } else if (imagePath.startsWith('storage/')) {
                fullImageUrl = baseUrl + '/' + imagePath.replace('storage/', 'storage/');
            } else if (imagePath.startsWith('/')) {
                fullImageUrl = baseUrl + imagePath;
            } else {
                fullImageUrl = baseUrl + '/' + imagePath;
            }

            // Add timestamp to prevent caching
            const timestamp = new Date().getTime();
            fullImageUrl += (fullImageUrl.includes('?') ? '&' : '?') + 't=' + timestamp;

            $('#product-image-preview').attr('src', fullImageUrl)
                .on('load', function() {
                    console.log('وێنە بە سەرکەوتوویی بارکرا');
                    $('#no-image-section').addClass('d-none');
                    $('#image-preview-section').removeClass('d-none');
                })
                .on('error', function() {
                    console.log('هەڵە لە بارکردنی وێنە');
                    $('#no-image-section').removeClass('d-none');
                    $('#image-preview-section').addClass('d-none');
                });

        } else {
            console.log('وێنە بوونی نەبوو');
            $('#no-image-section').removeClass('d-none');
            $('#image-preview-section').addClass('d-none');
        }
    }

    // Format number with commas
    function formatNumber(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    // Barcode search input with debounce
    $('#barcode-search').on('input', function() {
        const barcode = $(this).val().trim();

        // Clear previous timer
        if (searchDebounceTimer) {
            clearTimeout(searchDebounceTimer);
        }

        // Set new timer for debounce (500ms)
        searchDebounceTimer = setTimeout(() => {
            if (barcode.length >= 3) {
                searchProductByBarcode(barcode);
            }
        }, 500);
    });

    // Format price inputs (for editable fields)
    $('#purchase-price, #selling-price').on('input', function() {
        let value = $(this).val().replace(/\D/g, '');

        if (value) {
            value = parseInt(value).toLocaleString();
        }

        $(this).val(value);
    });

    // Validate selling price
    $('#selling-price').on('change', function() {
        const purchasePrice = parseInt($('#purchase-price').val().replace(/,/g, '')) || 0;
        const sellingPrice = parseInt($(this).val().replace(/,/g, '')) || 0;

        if (sellingPrice <= purchasePrice) {
            showAlert('warning', 'ئاگاداری', 'نرخی فرۆشتن دەبێت زیاتر لە نرخی کڕین بێت!');
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid');
        }
    });

    // Handle form submission with AJAX
    $('#product-form').submit(function(e) {
        // Remove commas from price inputs before submission
        $('#purchase-price').val($('#purchase-price').val().replace(/,/g,''));
        $('#selling-price').val($('#selling-price').val().replace(/,/g,''));

        e.preventDefault();

        if (isSubmitting) {
            return false;
        }

        // Validate barcode
        const barcode = $('#product-barcode').val();
        if (!barcode || barcode.trim() === '') {
            showAlert('error', 'هەڵە', 'تکایە بارکۆدی کاڵا بنووسە یان سێرچی بکە!');
            $('#barcode-search').focus();
            return false;
        }

        // Validate required editable fields
        const purchasePrice = parseFloat($('#purchase-price').val()) || 0;
        const sellingPrice = parseFloat($('#selling-price').val()) || 0;
        const currentStock = parseInt($('#current-stock').val()) || 0;

        if (purchasePrice <= 0) {
            showAlert('error', 'هەڵە', 'نرخی کڕین دەبێت گەورەتر لە سفر بێت!');
            $('#purchase-price').focus();
            return false;
        }

        if (sellingPrice <= purchasePrice) {
            showAlert('error', 'هەڵەی نرخ', 'نرخی فرۆشتن دەبێت زیاتر لە نرخی کڕین بێت!');
            $('#selling-price').focus();
            return false;
        }

        if (currentStock < 0) {
            showAlert('error', 'هەڵە', 'بڕی ئێستای کۆگا نابێت نەرێنی بێت!');
            $('#current-stock').focus();
            return false;
        }

        // Prepare form data - ONLY send the required fields (no image data)
        const formData = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            barcode: barcode.trim(),
            purchase_price: purchasePrice,
            selling_price: sellingPrice,
            current_stock: currentStock
        };

        console.log('Form data to send:', formData);

        // Update button state
        isSubmitting = true;
        const submitBtn = $('#submit-btn');
        const originalText = submitBtn.html();
        submitBtn.html('<div class="loading-spinner"></div> تۆمار دەکرێت...');
        submitBtn.prop('disabled', true);

        // Send AJAX request
       $.ajax({
    url: '{{ route("warehousing_store") }}',
    type: 'POST',
    data: formData,
    success: function(response) {
        if (response.success) {
            showAlert('success', 'سەرکەوتوو', "کاڵاکە بە سەرکەوتوویی تۆمارکرا");
            clearForm()
        } else if (response.message) {
            // کاتێک back-end پیامێکی تایبەتی نارد
            showAlert('error', 'هەڵە', response.message);
            showToast('error', response.message);
        } else {
            showAlert('error', 'هەڵە', "هەڵەیەک بونی هەیە");
        }
    },
    error: function(xhr) {
        if (xhr.status === 409) {
            // ئەگەر پڕۆداکت پێشتر تۆمارکراوە
            showAlert('warning', 'ئاگاداری', 'ئەم کاڵایە پێشتر تۆمارکراوە');

        } else if (xhr.status === 422) {
            const errors = xhr.responseJSON.errors;
            showValidationErrors(errors);
            if (errors.barcode) {
                showAlert('error', 'هەڵە', 'ئەم بارکۆدە پێشتر بەکارهاتوە');
            }
        } else {
            showAlert('error', 'هەڵە', 'هەڵەیەک ڕوویدا. تکایە دووبارە هەوڵبدەرەوە');
        }
    },
    complete: function() {
        isSubmitting = false;
        submitBtn.html(originalText);
        submitBtn.prop('disabled', false);
    }
});

    });

    // فەرمانی سەرەمی بۆ پشکنینی URL بۆ بارکۆد
    function checkUrlForBarcode() {
        const urlParams = new URLSearchParams(window.location.search);
        const barcode = urlParams.get('barcode');

        console.log('URL Parameters:', Array.from(urlParams.entries()));
        console.log('باریکۆد لە URL:', barcode);

        if (barcode && barcode.trim() !== '') {
            console.log('بارکۆد لە URL دۆزرایەوە:', barcode);
            $('#barcode-search').val(barcode);



            setTimeout(() => {
                console.log('دەستپێکردنی سێرچی ئۆتۆماتیکی بۆ بارکۆد:', barcode);
                searchProductByBarcode(barcode);
            }, 300);
        }
    }

    // بانگکردنی فەرمانی پشکنینی URL
    checkUrlForBarcode();
});
</script>
@endsection
