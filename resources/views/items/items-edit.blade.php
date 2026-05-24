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
        --morning: #f59e0b;
        --afternoon: #3b82f6;
        --night: #1e293b;
        --text: #1e293b;
        --border-color: #e2e8f0;
        --bg-light: #f8fafc;
        --transition-base: all 0.3s ease;
    }

    /* Dark mode overrides for this page */
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

    /* Table Styles */
    .products-table-container {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        overflow-x: auto;
        margin-bottom: 2rem;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    body.dark-mode .products-table-container {
        background: #1e293b;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);
    }

    .products-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.9rem;
    }

    .products-table thead {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
    }

    .products-table th {
        padding: 1rem;
        text-align: center;
        font-weight: 600;
    }

    .products-table td {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #e5e7eb;
        vertical-align: middle;
        text-align: center;
        transition: border-color 0.3s ease;
    }

    body.dark-mode .products-table td {
        border-bottom: 1px solid #334155;
        color: #e2e8f0;
    }

    .product-image-thumb {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid var(--primary);
        cursor: pointer;
        transition: transform 0.2s;
    }

    .product-image-thumb:hover {
        transform: scale(1.1);
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
    }

    .btn-edit-table {
        background: linear-gradient(135deg, var(--info), #2563eb);
        color: white;
        border: none;
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-edit-table:hover {
        transform: scale(1.05);
        box-shadow: 0 2px 8px rgba(59,130,246,0.4);
    }

    .btn-delete-table {
        background: linear-gradient(135deg, var(--danger), #dc2626);
        color: white;
        border: none;
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-delete-table:hover {
        transform: scale(1.05);
        box-shadow: 0 2px 8px rgba(239,68,68,0.4);
    }

    /* Search Section */
    .search-section {
        margin-bottom: 2rem;
    }

    .search-card {
        background: white;
        border-radius: 1rem;
        padding: 1.5rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    body.dark-mode .search-card {
        background: #1e293b;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .search-input-group {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        position: relative;
    }

    .search-input-wrapper {
        flex: 1;
        min-width: 200px;
        position: relative;
    }

    .search-input-wrapper .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        transition: all 0.3s;
        padding-right: 40px;
        background-color: white;
        color: #1e293b;
    }

    body.dark-mode .search-input-wrapper .form-control {
        background-color: #0f172a;
        border-color: #334155;
        color: #e2e8f0;
    }

    body.dark-mode .search-input-wrapper .form-control::placeholder {
        color: #64748b;
    }

    .search-input-wrapper .form-control:focus {
        border-color: var(--primary);
        outline: none;
        box-shadow: 0 0 0 3px rgba(74,100,145,0.2);
    }

    body.dark-mode .search-input-wrapper .form-control:focus {
        box-shadow: 0 0 0 3px rgba(74,100,145,0.3);
    }

    .search-input-wrapper .camera-search-btn {
        position: absolute;
        right: 8px;
        top: 50%;
        transform: translateY(-50%);
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border: none;
        color: white;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }

    .search-input-wrapper .camera-search-btn:hover {
        transform: translateY(-50%) scale(1.05);
    }

    .search-loading-indicator {
        position: absolute;
        right: 50px;
        top: 50%;
        transform: translateY(-50%);
        display: none;
        color: var(--primary);
    }

    .reset-filters {
        background: #6b7280;
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .reset-filters:hover {
        background: #4b5563;
    }

    /* Card Styles - Dark Mode */
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

    body.dark-mode .card-body {
        color: #e2e8f0;
    }

    /* Edit Form Modal */
    .edit-modal .modal-content {
        border-radius: 1.5rem;
        overflow: hidden;
        max-height: 90vh;
        transition: background-color 0.3s ease;
    }

    body.dark-mode .edit-modal .modal-content {
        background-color: #1e293b;
        color: #e2e8f0;
    }

    .edit-modal .modal-header {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        padding: 1.2rem 1.5rem;
    }

    .edit-modal .modal-body {
        max-height: 70vh;
        overflow-y: auto;
        padding: 1.5rem;
    }

    .edit-modal .form-label {
        font-weight: 600;
        color: var(--secondary);
        margin-bottom: 0.5rem;
    }

    body.dark-mode .edit-modal .form-label {
        color: #94a3b8;
    }

    .edit-modal .form-control {
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        padding: 0.7rem 1rem;
        transition: all 0.3s;
        background-color: white;
        color: #1e293b;
    }

    body.dark-mode .edit-modal .form-control {
        background-color: #0f172a;
        border-color: #334155;
        color: #e2e8f0;
    }

    body.dark-mode .edit-modal .form-control::placeholder {
        color: #64748b;
    }

    .edit-modal .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(74,100,145,0.2);
    }

    .edit-modal .image-preview-edit {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 12px;
        border: 2px solid var(--primary);
        margin-top: 0.5rem;
        cursor: pointer;
    }

    /* Fullscreen Image Modal */
    .fullscreen-image-modal .modal-content {
        background: rgba(0, 0, 0, 0.95);
        border: none;
        border-radius: 0;
    }

    .fullscreen-image-modal .modal-body {
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }

    .fullscreen-image-modal img {
        max-width: 100%;
        max-height: 100vh;
        object-fit: contain;
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

.alert-success-custom { background-color: rgba(12, 239, 4, 0.982); color: #065f46; border-left: 5px solid var(--success); }
    .alert-success-custom::before { background: var(--success); }



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

    .pagination {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 1.5rem;
        flex-wrap: wrap;
    }

    .pagination a, .pagination span {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        background: white;
        color: var(--primary);
        text-decoration: none;
        border: 1px solid #e5e7eb;
        transition: all 0.2s;
    }

    body.dark-mode .pagination a,
    body.dark-mode .pagination span {
        background: #1e293b;
        color: #e2e8f0;
        border-color: #334155;
    }

    .pagination a:hover {
        background: var(--primary);
        color: white;
    }

    .pagination .active span {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }

    .badge-stock {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .badge-stock-high {
        background: #d1fae5;
        color: #065f46;
    }

    body.dark-mode .badge-stock-high {
        background: #064e3b;
        color: #d1fae5;
    }

    .badge-stock-low {
        background: #fed7aa;
        color: #92400e;
    }

    body.dark-mode .badge-stock-low {
        background: #78350f;
        color: #fed7aa;
    }

    /* Modal Image Upload Styles */
    .modal-image-upload-container {
        border: 2px dashed var(--primary);
        border-radius: 12px;
        padding: 1rem;
        text-align: center;
        background: rgba(74, 100, 145, 0.05);
        transition: all 0.3s ease;
        min-height: 150px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    body.dark-mode .modal-image-upload-container {
        background: rgba(74, 100, 145, 0.1);
        border-color: #5d7ab0;
    }

    .modal-image-preview {
        max-width: 100%;
        max-height: 150px;
        object-fit: contain;
        border-radius: 8px;
        cursor: pointer;
    }

    .modal-image-actions {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
        margin-top: 0.5rem;
    }

    .modal-camera-btn, .modal-upload-btn, .modal-remove-btn {
        padding: 0.3rem 0.8rem;
        border-radius: 8px;
        border: none;
        color: white;
        cursor: pointer;
        font-size: 0.8rem;
    }

    .modal-camera-btn {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
    }

    .modal-upload-btn {
        background: linear-gradient(135deg, var(--success), #059669);
    }

    .modal-remove-btn {
        background: linear-gradient(135deg, var(--danger), #dc2626);
    }

    /* Modal Footer */
    .modal-footer {
        transition: background-color 0.3s ease, border-color 0.3s ease;
    }

    body.dark-mode .modal-footer {
        background-color: #1e293b;
        border-top-color: #334155;
    }

    /* Fullscreen Camera */
    .camera-fullscreen {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: black;
        z-index: 99999;
        display: none;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .camera-fullscreen.active {
        display: flex;
    }

    .camera-fullscreen video {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .camera-fullscreen .camera-controls-full {
        position: fixed;
        bottom: 30px;
        left: 0;
        right: 0;
        display: flex;
        justify-content: center;
        gap: 20px;
        padding: 20px;
        background: rgba(0, 0, 0, 0.7);
        z-index: 100000;
    }

    .camera-fullscreen .camera-controls-full button {
        padding: 15px 25px;
        font-size: 1.2rem;
        border: none;
        border-radius: 50px;
        cursor: pointer;
        transition: transform 0.2s;
    }

    .camera-fullscreen .btn-capture-full {
        background-color: #10b981;
        color: white;
    }

    .camera-fullscreen .btn-switch-full {
        background-color: #3b82f6;
        color: white;
    }

    .camera-fullscreen .close-camera {
        position: absolute;
        top: 20px;
        right: 20px;
        background: rgba(0, 0, 0, 0.6);
        color: white;
        border: none;
        width: 45px;
        height: 45px;
        border-radius: 50%;
        font-size: 24px;
        cursor: pointer;
        z-index: 100001;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .section-title-custom {
        font-size: 1rem;
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--secondary);
    }

    body.dark-mode .section-title-custom {
        color: #94a3b8;
        border-bottom-color: #334155;
    }
    
    .input-with-icon-custom {
        position: relative;
    }
    
    .barcode-generate-btn {
        transition: all 0.2s ease;
        position: absolute;
        left: 0.6rem;
        top: 50%;
        transform: translateY(-50%);
        width: 38px;
        height: 38px;
        border-radius: 8px;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border: none;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
    
    .barcode-generate-btn:hover {
        transform: translateY(-50%) scale(1.1);
    }
    
    .btn-custom-primary {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.5rem 1.2rem;
        border-radius: 30px;
        transition: all 0.3s ease;
    }
    
    .btn-custom-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(74, 100, 145, 0.4);
        color: white;
    }

    .is-invalid {
        border-color: var(--danger) !important;
    }

    /* Barcode Scanner Modal */
    .scanner-modal .modal-content {
        background: #000;
        border-radius: 1rem;
        overflow: hidden;
    }
    .scanner-modal .modal-header {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        border-bottom: none;
    }
    .scanner-modal .btn-close {
        filter: invert(1);
    }
    #qr-reader {
        width: 100%;
        max-width: 100%;
        border-radius: 0;
        overflow: hidden;
    }
    #qr-reader video {
        width: 100% !important;
        min-height: 400px;
        object-fit: cover;
    }
    .scanner-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        pointer-events: none;
    }
    .scan-region {
        width: 80%;
        height: 120px;
        border: 2px solid var(--secondary);
        border-radius: 12px;
        box-shadow: 0 0 0 9999px rgba(0, 0, 0, 0.5);
        animation: pulse 1.5s infinite;
    }
    @keyframes pulse {
        0% { border-color: var(--secondary); }
        50% { border-color: var(--primary); }
        100% { border-color: var(--secondary); }
    }
    .scan-instruction {
        position: absolute;
        bottom: 20px;
        left: 0;
        right: 0;
        text-align: center;
        color: white;
        background: rgba(0,0,0,0.7);
        padding: 8px;
        font-size: 0.9rem;
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

    #edit-barcode{
        padding-right: 60px;
    }
    #edit-scan-barcode-btn{
        margin-right: 10px;
    }

    .input-barcode::placeholder{
       padding-right: 10px;
    }

    /* Delete Modal Dark Mode */
    body.dark-mode #deleteConfirmModal .modal-content {
        background-color: #1e293b;
        color: #e2e8f0;
    }

    body.dark-mode #deleteConfirmModal .modal-header {
        background: linear-gradient(135deg, #991b1b, #7f1d1d) !important;
    }

    body.dark-mode #deleteConfirmModal .text-muted {
        color: #94a3b8 !important;
    }

    body.dark-mode #deleteConfirmModal .text-danger {
        color: #f87171 !important;
    }

    /* Button styles in dark mode */
    body.dark-mode .btn-secondary {
        background-color: #475569;
        border-color: #475569;
        color: white;
    }

    body.dark-mode .btn-secondary:hover {
        background-color: #334155;
    }

    /* Text muted in dark mode */
    body.dark-mode .text-muted {
        color: #94a3b8 !important;
    }
</style>

<!-- Alert Container -->
<div id="alert-container" style="position: fixed; top: 20px; right: 20px; z-index: 9999; width: 350px;"></div>

<div class="container py-4">
    <!-- Page Header -->
    <div class="card shadow-sm mb-4 border-0 rounded-4 overflow-hidden">
        <div class="card-header form-header-custom text-white text-center py-4">
            <div class="form-logo-custom">
                <i class="fas fa-edit"></i>
            </div>
            <h1 class="h2 mb-2">گۆڕانکاری زانیارییەکانی کاڵا</h1>
        </div>
    </div>

    <!-- Search Section - Live Search -->
    <div class="search-section">
        <div class="search-card">
            <div class="search-input-group">
                <div class="search-input-wrapper">
                    <input type="text" id="search-barcode" class="form-control input-barcode" placeholder="بارکۆد ..." autocomplete="off">
                    <button type="button" class="camera-search-btn" id="search-camera-btn" title="سکانکردنی بارکۆد">
                        <i class="fas fa-camera"></i>
                    </button>
                    <div class="search-loading-indicator" id="barcode-loading">
                        <i class="fas fa-spinner fa-spin"></i>
                    </div>
                </div>
                <div class="search-input-wrapper">
                    <input type="text" id="search-name" class="form-control" placeholder="ناوی کاڵا ..." autocomplete="off">
                    <div class="search-loading-indicator" id="name-loading">
                        <i class="fas fa-spinner fa-spin"></i>
                    </div>
                </div>
                <div class="search-input-wrapper">
                    <input type="text" id="search-company" class="form-control" placeholder="ناوی کۆمپانیا ..." autocomplete="off">
                    <div class="search-loading-indicator" id="company-loading">
                        <i class="fas fa-spinner fa-spin"></i>
                    </div>
                </div>
                <button type="button" id="reset-filters" class="reset-filters">
                    <i class="fas fa-undo-alt me-2"></i> ڕێکخستنەوە
                </button>
            </div>
        </div>
    </div>

    <!-- Products Table -->
    <div class="products-table-container">
        <table class="products-table">
            <thead>
                <tr>
                    <th>وێنە</th>
                    <th>ناوی کاڵا</th>
                    <th>کۆمپانیا</th>
                    <th>نرخی کڕین</th>
                    <th>نرخی فرۆشتن</th>
                    <th>بڕی کاڵای دووکان</th>
                    <th>کردار</th>
                </tr>
            </thead>
            <tbody id="products-table-body">
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <div class="loading-spinner" style="border-top-color: var(--primary);"></div>
                        <span class="me-2">بارکاردکردنی زانیاری...</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div id="pagination-container" class="pagination"></div>
</div>

<!-- Edit Product Modal -->
<div class="modal fade edit-modal" id="editProductModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-edit me-2"></i> گۆڕانکاری زانیاری کاڵا
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="edit-product-form" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="edit-product-id" name="product_id">
                    <input type="hidden" id="edit-old-barcode" name="barcode_old">

                    <!-- Section 1: Basic Information -->
                    <div class="mb-4">
                        <h3 class="section-title-custom">
                            <i class="fas fa-info-circle ms-2"></i>زانیارییە سەرەکییەکانی کاڵا
                        </h3>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">
                                    <span class="text-danger">*</span> بارکۆدی کاڵا
                                </label>
                                <div class="input-with-icon-custom" style="position: relative;">
                                    <input type="text"
                                           id="edit-barcode"
                                           name="new_barcode"
                                           class="form-control ps-2"
                                           placeholder="ژمارەی بارکۆد بنوسە ..."
                                           autocomplete="off"
                                           required>
                                    <button type="button"
                                            id="edit-auto-barcode-btn"
                                            class="barcode-generate-btn"
                                            title="دروستکردنی بارکۆدی ئەلێاتۆری">
                                        <i class="fas fa-magic"></i>
                                    </button>
                                    <button type="button"
                                            id="edit-scan-barcode-btn"
                                            class="barcode-generate-btn"
                                            style="left: auto; right: 0rem;"
                                            title="سکانکردنی بارکۆد">
                                        <i class="fas fa-camera"></i>
                                    </button>
                                </div>
                                <span id="edit-barcode-status" style="display:inline-block; margin-top:5px;"></span>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    <span class="text-danger">*</span> ناوی کاڵا
                                </label>
                                <input type="text" id="edit-name" name="name" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    <span class="text-danger">*</span> ناوی کۆمپانیا
                                </label>
                                <input type="text" id="edit-company" name="company" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Pricing and Storage -->
                    <div class="mb-4">
                        <h3 class="section-title-custom">
                            <i class="fas fa-chart-line ms-2"></i>نرخ و کۆگاکردن
                        </h3>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    <span class="text-danger">*</span> نرخی کڕین (دینار)
                                </label>
                                <input type="text" id="edit-purchase-price" name="purchase_price" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    <span class="text-danger">*</span> نرخی فرۆشتن (دینار)
                                </label>
                                <input type="text" id="edit-selling-price" name="selling_price" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    <span class="text-danger">*</span> ژمارەی کاڵاکانی ناو دوکان 
                                </label>
                                <input type="number" id="edit-minimum-stock" name="minimum_wearhouse" class="form-control" min="1" required>
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Product Image -->
                    <div class="mb-4">
                        <h3 class="section-title-custom">
                            <i class="fas fa-camera ms-2"></i>وێنەی کاڵا
                        </h3>

                        <div class="modal-image-upload-container" id="modal-image-upload-container">
                            <div id="modal-image-preview-section" style="display: none;">
                                <img id="modal-product-image-preview" class="modal-image-preview" src="" alt="وێنەی کاڵا">
                                <div class="modal-image-actions">
                                    <button type="button" id="modal-use-camera-btn" class="modal-camera-btn">
                                        <i class="fas fa-camera"></i> کامێرا
                                    </button>
                                    <button type="button" id="modal-upload-new-btn" class="modal-upload-btn">
                                        <i class="fas fa-upload"></i> فایل
                                    </button>
                                    <button type="button" id="modal-remove-image-btn" class="modal-remove-btn">
                                        <i class="fas fa-trash"></i> سڕینەوە
                                    </button>
                                </div>
                            </div>
                            <div id="modal-default-upload-section">
                                <div class="mb-3">
                                    <i class="fas fa-image text-muted mb-2" style="font-size: 2rem;"></i>
                                    <p class="text-muted mb-2">وێنەی کاڵا هەڵبگرە</p>
                                </div>
                                <div class="modal-image-actions">
                                    <button type="button" id="modal-open-camera-btn" class="modal-camera-btn">
                                        <i class="fas fa-camera"></i> کامێرا
                                    </button>
                                    <button type="button" id="modal-upload-file-btn" class="modal-upload-btn">
                                        <i class="fas fa-upload"></i> فایل هەڵبگرە
                                    </button>
                                </div>
                            </div>
                        </div>

                        <input type="file" id="modal-file-input" name="image_product_camera" accept="image/*" class="d-none">
                        <input type="hidden" id="modal-captured-image-data" name="captured_image">
                        <input type="hidden" id="modal-image-source-type" name="image_source_type" value="">
                        <input type="hidden" id="modal-remove-image-flag" name="remove_image" value="false">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i> داخستن
                </button>
                <button type="button" id="save-product-changes" class="btn btn-primary" style="background: linear-gradient(135deg, var(--primary), var(--secondary)); border: none;">
                    <i class="fas fa-save me-2"></i> تۆمارکردنی گۆڕانکاری
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, var(--danger), #dc2626); color: white;">
                <h5 class="modal-title">
                    <i class="fas fa-trash-alt me-2"></i> سڕینەوەی کاڵا
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>ئایا دڵنیایت کە دەتەوێت ئەم کاڵایە بسڕیتەوە؟</p>
                <p class="text-muted" id="delete-product-name"></p>
                <p class="text-danger small">ئاگاداری: ئەم کردارە هەڵنەگەڕێتەوە!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i> پەشیمان بووم
                </button>
                <button type="button" id="confirm-delete" class="btn btn-danger">
                    <i class="fas fa-trash-alt me-2"></i> سڕینەوە
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Fullscreen Image Modal -->
<div class="modal fade fullscreen-image-modal" id="fullscreenImageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header" style="border: none; background: transparent; position: absolute; top: 0; right: 0; z-index: 10;">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <img id="fullscreen-image" src="" alt="Fullscreen Image">
            </div>
        </div>
    </div>
</div>

<!-- Fullscreen Camera Modal -->
<div id="fullscreenCamera" class="camera-fullscreen">
    <button class="close-camera" id="closeFullscreenCamera">&times;</button>
    <video id="fullscreenVideo" autoplay playsinline></video>
    <div class="camera-controls-full">
        <button id="switchCameraFull" class="btn-switch-full">
            <i class="fas fa-sync-alt"></i> گۆڕینی کامێرا
        </button>
        <button id="capturePhotoFull" class="btn-capture-full">
            <i class="fas fa-camera"></i> وێنە بگرە
        </button>
    </div>
</div>

<!-- Barcode Scanner Modal -->
<div class="modal fade scanner-modal" id="barcodeScannerModal" tabindex="-1" data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-camera ms-2"></i>سکانکردنی بارکۆد</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0 position-relative" style="min-height: 400px; background: #000;">
                <div id="qr-reader" style="width: 100%;"></div>
                <div class="scanner-overlay"></div>
                <div class="scan-instruction">
                    <i class="fas fa-qrcode ms-1"></i> بارکۆدەکە لە ناوچەی سکاندا دابنێ
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times ms-1"></i>داخستن
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

<script>
$(document).ready(function() {

    enableBarcodeNormalization('#search-barcode');
    enableBarcodeNormalization('#edit-barcode');

    // ============================================
    // Variables
    // ============================================
    let currentPage = 1;
    let searchTimeout = null;
    let searchParams = {
        barcode: '',
        name: '',
        company: ''
    };
    let deleteProductId = null;
    let editModal = new bootstrap.Modal(document.getElementById('editProductModal'));
    let deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
    let fullscreenImageModal = new bootstrap.Modal(document.getElementById('fullscreenImageModal'));
    let barcodeScannerModal = new bootstrap.Modal(document.getElementById('barcodeScannerModal'));
    
    // Camera variables
    let fullscreenStream = null;
    let currentFacingMode = 'environment';
    let html5QrCode = null;
    let currentScannerTarget = null;

    // CSRF Token setup
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // ============================================
    // !!! چارەسەری کێشەی بارکۆد بە هەر زمانێک !!!
    // ============================================

    /**
     * گۆڕینی هەر ژمارەیەکی نا ئینگلیزی (کوردی، فارسی، عەرەبی) بۆ ئینگلیزی
     */
    function normalizeToEnglishNumbers(str) {
        if (!str) return str;
        
        const kurdishNumbers = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
        const persianNumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        const englishNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        
        let result = str.toString();
        
        for (let i = 0; i < kurdishNumbers.length; i++) {
            result = result.replace(new RegExp(kurdishNumbers[i], 'g'), englishNumbers[i]);
        }
        for (let i = 0; i < persianNumbers.length; i++) {
            result = result.replace(new RegExp(persianNumbers[i], 'g'), englishNumbers[i]);
        }
        
        result = result.replace(/[^0-9A-Za-z\-\_]/g, '');
        return result;
    }

    /**
     * چالاککردنی نۆرمالایزکردن بۆ فیلدێک
     */
    function enableBarcodeNormalization(selector) {
        $(selector).on('input', function() {
            const originalValue = $(this).val();
            const normalizedValue = normalizeToEnglishNumbers(originalValue);
            if (originalValue !== normalizedValue) {
                const cursorPosition = this.selectionStart;
                $(this).val(normalizedValue);
                this.setSelectionRange(cursorPosition, cursorPosition);
            }
        });
    }

    // ============================================
    // Helper Functions
    // ============================================
    function formatNumberToIQD(value) {
        if (!value && value !== 0) return '';
        let num = parseFloat(value);
        if (isNaN(num)) return '';
        return num.toLocaleString('en-US');
    }

    function removeThousandSeparators(value) {
        if (!value) return '';
        return value.toString().replace(/,/g, '');
    }

    function getImageUrl(imagePath) {
        if (!imagePath) return null;
        if (imagePath.startsWith('http')) return imagePath;
        let baseUrl = window.location.origin;
        if (imagePath.startsWith('/')) return baseUrl + imagePath;
        return baseUrl + '/' + imagePath;
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

    // ============================================
    // Live Search Functions
    // ============================================
    
    function showLoading(field) {
        $('#' + field + '-loading').show();
    }
    
    function hideLoading(field) {
        $('#' + field + '-loading').hide();
    }
    
    function performLiveSearch() {
        // !!! نۆرمالایزکردنی بارکۆد پێش گەڕان !!!
        searchParams.barcode = normalizeToEnglishNumbers($('#search-barcode').val().trim());
        searchParams.name = $('#search-name').val().trim();
        searchParams.company = $('#search-company').val().trim();
        loadProducts(1);
    }
    
    function debounceSearch() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            performLiveSearch();
        }, 500);
    }
    
    $('#search-barcode').on('input', function() {
        showLoading('barcode');
        debounceSearch();
        setTimeout(function() { hideLoading('barcode'); }, 600);
    });
    
    $('#search-name').on('input', function() {
        showLoading('name');
        debounceSearch();
        setTimeout(function() { hideLoading('name'); }, 600);
    });
    
    $('#search-company').on('input', function() {
        showLoading('company');
        debounceSearch();
        setTimeout(function() { hideLoading('company'); }, 600);
    });
    
    $('#reset-filters').click(function() {
        $('#search-barcode, #search-name, #search-company').val('');
        searchParams = { barcode: '', name: '', company: '' };
        loadProducts(1);
    });

    // ============================================
    // Barcode Scanner Functions
    // ============================================
    
    async function startBarcodeScanner(target) {
        currentScannerTarget = target;
        await stopBarcodeScanner();
        
        const qrReader = document.getElementById('qr-reader');
        if (!qrReader) {
            console.error('qr-reader element not found');
            return;
        }
        
        // Clean previous scanner if exists
        if (html5QrCode) {
            try {
                if (html5QrCode.isScanning) {
                    await html5QrCode.stop();
                }
                await html5QrCode.clear();
            } catch(e) {
                console.log('Error clearing previous scanner:', e);
            }
        }
        
        html5QrCode = new Html5Qrcode("qr-reader");
        
        const config = {
            fps: 10,
            qrbox: { width: 250, height: 200 },
            aspectRatio: 1.0,
            showTorchButtonIfSupported: true,
        };
        
        try {
            await html5QrCode.start(
                { facingMode: "environment" },
                config,
                (decodedText) => {
                    // !!! زیادکردنی نۆرمالایزکردن !!!
                    const normalizedBarcode = normalizeToEnglishNumbers(decodedText);
                    
                    stopBarcodeScanner();
                    barcodeScannerModal.hide();
                    
                    if (currentScannerTarget === 'search') {
                        $('#search-barcode').val(normalizedBarcode);
                        performLiveSearch();
                        showAlert('success', 'سەرکەوتوو', 'بارکۆد سکان کرا: ' + normalizedBarcode);
                    } else if (currentScannerTarget === 'edit') {
                        $('#edit-barcode').val(normalizedBarcode);
                        updateModalBarcodeStatus(normalizedBarcode);
                        showAlert('success', 'سەرکەوتوو', 'بارکۆد سکان کرا: ' + normalizedBarcode);
                    }
                },
                (errorMessage) => {
                    // Scanning continues
                }
            );
        } catch (err) {
            console.error('Error starting scanner:', err);
            showAlert('error', 'هەڵەی کامێرا', 'ناتوانرێت کامێرا بۆ سکانکردن بکرێتەوە');
            barcodeScannerModal.hide();
        }
    }
    
    async function stopBarcodeScanner() {
        if (html5QrCode && html5QrCode.isScanning) {
            try {
                await html5QrCode.stop();
                await html5QrCode.clear();
            } catch(e) {
                console.error('Error stopping scanner:', e);
            }
        }
    }
    
    // Scanner button events
    $('#search-camera-btn').on('click', function() {
        barcodeScannerModal.show();
        startBarcodeScanner('search');
    });
    
    $('#edit-scan-barcode-btn').on('click', function() {
        barcodeScannerModal.show();
        startBarcodeScanner('edit');
    });
    
    $('#barcodeScannerModal').on('hidden.bs.modal', function() {
        stopBarcodeScanner();
    });

    // ============================================
    // Load Products Table
    // ============================================
    function loadProducts(page = 1) {
        $('#products-table-body').html(`
            <tr>
                <td colspan="7" class="text-center py-5">
                    <div class="loading-spinner" style="border-top-color: var(--primary);"></div>
                    <span class="me-2 mt-2 d-block">بارکاردکردنی زانیاری...</span>
                </td>
            </tr>
        `);
        
        $.ajax({
            url: '{{ route("products.list") }}',
            type: 'GET',
            data: {
                page: page,
                barcode: searchParams.barcode,
                name: searchParams.name,
                company: searchParams.company
            },
            success: function(response) {
                if (response.success) {
                    renderProductsTable(response.products.data);
                    renderPagination(response.products);
                    currentPage = response.products.current_page;
                } else {
                    showAlert('error', 'هەڵە', 'هەڵەیەک ڕوویدا لە بارکاردکردنی زانیاریدا');
                }
                hideLoading('barcode');
                hideLoading('name');
                hideLoading('company');
            },
            error: function() {
                $('#products-table-body').html(`
                    <tr>
                        <td colspan="7" class="text-center py-5 text-danger">
                            <i class="fas fa-exclamation-circle fa-2x mb-2 d-block"></i>
                            هەڵە لە بارکاردکردنی زانیاریدا
                        </td>
                    </tr>
                `);
                hideLoading('barcode');
                hideLoading('name');
                hideLoading('company');
            }
        });
    }
    
    function renderProductsTable(products) {
        if (!products || products.length === 0) {
            $('#products-table-body').html(`
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="fas fa-box-open fa-3x mb-3 d-block"></i>
                        هیچ کاڵایەک نەدۆزرایەوە
                    </td>
                </tr>
            `);
            return;
        }
        
        let html = '';
        $.each(products, function(index, product) {
            let imageUrl = product.image_producte_path || product.image_product_camera;
            let imageHtml = '';
            if (imageUrl) {
                imageHtml = `<img src="${getImageUrl(imageUrl)}" class="product-image-thumb" alt="${product.name}" data-full-image="${getImageUrl(imageUrl)}" onerror="this.src='https://placehold.co/50x50?text=No+Image'">`;
            } else {
                imageHtml = `<div style="width:50px;height:50px;background:#f3f4f6;border-radius:8px;display:flex;align-items:center;justify-content:center;"><i class="fas fa-box text-muted"></i></div>`;
            }
            
            let stockBadge = '';
            let stock = product.counter || 0;
            if (stock > 10) {
                stockBadge = `<span class="badge-stock badge-stock-high"><i class="fas fa-check-circle ms-1"></i>${stock}</span>`;
            } else {
                stockBadge = `<span class="badge-stock badge-stock-low"><i class="fas fa-exclamation-triangle ms-1"></i>${stock}</span>`;
            }
            
            html += `
                <tr data-product-id="${product.id}">
                    <td>${imageHtml}</td>
                    <td class="fw-semibold">${escapeHtml(product.name)}</td>
                    <td>${escapeHtml(product.company)}</td>
                    <td>${formatNumberToIQD(product.purchase_price)} د.ع</td>
                    <td>${formatNumberToIQD(product.selling_price)} د.ع</td>
                    <td>${stockBadge}</td>
                    <td class="action-buttons">
                        <button class="btn-edit-table edit-product-btn" 
                            data-id="${product.id}" 
                            data-barcode="${escapeHtml(product.barcode)}" 
                            data-name="${escapeHtml(product.name)}" 
                            data-company="${escapeHtml(product.company)}" 
                            data-purchase="${product.purchase_price}" 
                            data-selling="${product.selling_price}" 
                            data-minstock="${product.counter}" 
                            data-image="${product.image_producte_path || product.image_product_camera || ''}">
                            <i class="fas fa-edit"></i> دەستکاری
                        </button>
                        <button class="btn-delete-table delete-product-btn" data-id="${product.id}" data-name="${escapeHtml(product.name)}">
                            <i class="fas fa-trash-alt"></i> سڕینەوە
                        </button>
                    </td>
                </tr>
            `;
        });
        $('#products-table-body').html(html);
        
        $('.product-image-thumb').on('click', function(e) {
            e.stopPropagation();
            const imageUrl = $(this).data('full-image') || $(this).attr('src');
            if (imageUrl && !imageUrl.includes('placehold')) {
                $('#fullscreen-image').attr('src', imageUrl);
                fullscreenImageModal.show();
            }
        });
    }
    
    function renderPagination(paginationData) {
        if (!paginationData || paginationData.last_page <= 1) {
            $('#pagination-container').empty();
            return;
        }
        
        let html = '';
        let current = paginationData.current_page;
        let last = paginationData.last_page;
        
        if (current > 1) {
            html += `<a href="#" data-page="${current-1}"><i class="fas fa-chevron-right"></i> پێشوو</a>`;
        }
        
        let start = Math.max(1, current - 2);
        let end = Math.min(last, current + 2);
        
        if (start > 1) html += `<a href="#" data-page="1">1</a>${start > 2 ? '<span>...</span>' : ''}`;
        
        for (let i = start; i <= end; i++) {
            if (i === current) {
                html += `<span class="active"><span>${i}</span></span>`;
            } else {
                html += `<a href="#" data-page="${i}">${i}</a>`;
            }
        }
        
        if (end < last) html += `${end < last-1 ? '<span>...</span>' : ''}<a href="#" data-page="${last}">${last}</a>`;
        
        if (current < last) {
            html += `<a href="#" data-page="${current+1}">دواتر <i class="fas fa-chevron-left"></i></a>`;
        }
        
        $('#pagination-container').html(html);
        
        $('#pagination-container a').click(function(e) {
            e.preventDefault();
            let page = $(this).data('page');
            if (page) loadProducts(page);
        });
    }

    // ============================================
    // Edit Product - Open Modal with Form
    // ============================================
    $(document).on('click', '.edit-product-btn', function() {
        let productId = $(this).data('id');
        let barcode = $(this).data('barcode');
        let name = $(this).data('name');
        let company = $(this).data('company');
        let purchasePrice = $(this).data('purchase');
        let sellingPrice = $(this).data('selling');
        let minStock = $(this).data('minstock');
        let imagePath = $(this).data('image');
        
        // Reset image-related fields
        $('#edit-product-id').val(productId);
        $('#edit-old-barcode').val(barcode);
        $('#edit-barcode').val(barcode);
        $('#edit-name').val(name);
        $('#edit-company').val(company);
        $('#edit-purchase-price').val(formatNumberToIQD(purchasePrice));
        $('#edit-selling-price').val(formatNumberToIQD(sellingPrice));
        $('#edit-minimum-stock').val(minStock);
        $('#modal-file-input').val('');
        $('#modal-captured-image-data').val('');
        $('#modal-image-source-type').val('');
        $('#modal-remove-image-flag').val('false');
        
        // Handle image preview
        if (imagePath && imagePath !== 'null' && imagePath !== '') {
            let imageUrl = getImageUrl(imagePath);
            $('#modal-product-image-preview').attr('src', imageUrl);
            $('#modal-image-preview-section').show();
            $('#modal-default-upload-section').hide();
        } else {
            $('#modal-image-preview-section').hide();
            $('#modal-default-upload-section').show();
        }
        
        updateModalBarcodeStatus(barcode);
        editModal.show();
    });
    
    $('#edit-purchase-price, #edit-selling-price').on('input', function() {
        let value = removeThousandSeparators($(this).val());
        $(this).val(formatNumberToIQD(value));
    });
    
    $('#edit-purchase-price, #edit-selling-price').on('focus', function() {
        $(this).val(removeThousandSeparators($(this).val()));
    });
    
    // ============================================
    // Modal Barcode Check
    // ============================================
    function updateModalBarcodeStatus(barcode) {
        let barcodeStr = String(barcode || '').trim();
        
        if (!barcodeStr) {
            $('#edit-barcode-status').text('');
            $('#edit-barcode').removeClass('is-invalid');
            return;
        }

        const normalizedBarcode = normalizeToEnglishNumbers(barcodeStr);
        
        $('#edit-barcode-status').html('<i class="fas fa-spinner fa-spin"></i> پشکنین دەکرێت...').css('color', '#3b82f6');
        
        $.ajax({
            url: '{{ route("barcode.check") }}',
            type: 'POST',
            data: { 
                _token: '{{ csrf_token() }}',
                barcode: barcodeStr 
            },
            success: function(response) {
                if (response.exists && response.products && response.products.length > 0) {
                    let currentProductId = $('#edit-product-id').val();
                    let isCurrentProduct = false;
                    if (currentProductId) {
                        isCurrentProduct = response.products.some(p => p.id == currentProductId);
                    }
                    
                    if (!isCurrentProduct && response.total_count > 0) {
                        $('#edit-barcode-status').html(`⚠️ ئەم بارکۆدە بۆ ${response.total_count} کاڵای تر بەکارهاتووە`).css('color', '#f59e0b');
                        $('#edit-barcode').addClass('is-invalid');
                    } else {
                        $('#edit-barcode-status').html('✅ بارکۆد بەردەستە').css('color', '#10b981');
                        $('#edit-barcode').removeClass('is-invalid');
                    }
                } else {
                    $('#edit-barcode-status').html('✅ بارکۆد بەردەستە').css('color', '#10b981');
                    $('#edit-barcode').removeClass('is-invalid');
                }
            },
            error: function() {
                $('#edit-barcode-status').html('❌ هەڵە لە پشکنیندا').css('color', '#ef4444');
            }
        });
    }
    
    let modalTypingTimer;
    $('#edit-barcode').on('keyup', function() {
        clearTimeout(modalTypingTimer);
        const barcode = $(this).val();
        if (!barcode || String(barcode).trim() === '') {
            $('#edit-barcode-status').text('');
            $('#edit-barcode').removeClass('is-invalid');
            return;
        }
        modalTypingTimer = setTimeout(function() {
            updateModalBarcodeStatus(barcode);
        }, 500);
    });
    
    $('#edit-barcode').on('change', function() {
        const barcode = $(this).val();
        if (barcode && String(barcode).trim() !== '') {
            updateModalBarcodeStatus(barcode);
        }
    });
    
    $('#edit-auto-barcode-btn').on('click', function() {
        const btn = $(this);
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
        
        function generateCandidate() {
            let code = '';
            for (let i = 0; i < 12; i++) code += Math.floor(Math.random() * 10);
            return code;
        }
        
        function tryBarcode() {
            const candidate = generateCandidate();
            $.ajax({
                url: '{{ route("barcode.check") }}',
                type: 'POST',
                data: { 
                    _token: '{{ csrf_token() }}',
                    barcode: candidate 
                },
                success: function(res) {
                    let exists = false;
                    if (res.exists && res.products && res.products.length > 0) {
                        const currentProductId = $('#edit-product-id').val();
                        const isCurrent = res.products.some(p => p.id == currentProductId);
                        exists = !isCurrent && res.total_count > 0;
                    }
                    
                    if (exists) {
                        tryBarcode();
                    } else {
                        $('#edit-barcode').val(candidate);
                        updateModalBarcodeStatus(candidate);
                        btn.prop('disabled', false).html('<i class="fas fa-magic"></i>');
                        showAlert('success', 'سەرکەوتوو', 'بارکۆدی نوێ دروستکرا: ' + candidate);
                    }
                },
                error: function() {
                    btn.prop('disabled', false).html('<i class="fas fa-magic"></i>');
                    showAlert('error', 'هەڵە', 'هەڵە لە دروستکردنی بارکۆددا');
                }
            });
        }
        tryBarcode();
    });

    // ============================================
    // Modal Image Upload & Camera
    // ============================================
    
    function startFullscreenCamera() {
        if (fullscreenStream) stopFullscreenCamera();
        navigator.mediaDevices.getUserMedia({
            video: { facingMode: currentFacingMode },
            audio: false
        }).then(function(stream) {
            fullscreenStream = stream;
            const videoElement = document.getElementById('fullscreenVideo');
            videoElement.srcObject = stream;
            videoElement.play();
        }).catch(function(error) {
            showAlert('error', 'هەڵەی کامێرا', 'ناتواندرێت کامێرا بکرێتەوە');
            closeFullscreenCamera();
        });
    }
    
    function stopFullscreenCamera() {
        if (fullscreenStream) {
            fullscreenStream.getTracks().forEach(track => track.stop());
            fullscreenStream = null;
        }
    }
    
    function openFullscreenCamera() {
        document.getElementById('fullscreenCamera').classList.add('active');
        document.body.style.overflow = 'hidden';
        startFullscreenCamera();
    }
    
    function closeFullscreenCamera() {
        document.getElementById('fullscreenCamera').classList.remove('active');
        document.body.style.overflow = '';
        stopFullscreenCamera();
    }
    
    function captureFullscreenPhoto() {
        if (!fullscreenStream) return;
        const video = document.getElementById('fullscreenVideo');
        const canvas = document.createElement('canvas');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
        
        canvas.toBlob(function(blob) {
            const reader = new FileReader();
            reader.onloadend = function() {
                $('#modal-captured-image-data').val(reader.result);
                $('#modal-image-source-type').val('camera');
                $('#modal-product-image-preview').attr('src', reader.result);
                $('#modal-image-preview-section').show();
                $('#modal-default-upload-section').hide();
                $('#modal-remove-image-flag').val('false');
                $('#modal-file-input').val('');
              
            };
            reader.readAsDataURL(blob);
            closeFullscreenCamera();
        }, 'image/jpeg', 0.9);
    }
    
    $('#modal-open-camera-btn, #modal-use-camera-btn').click(openFullscreenCamera);
    $('#closeFullscreenCamera').click(closeFullscreenCamera);
    $('#switchCameraFull').click(function() {
        currentFacingMode = currentFacingMode === 'environment' ? 'user' : 'environment';
        startFullscreenCamera();
    });
    $('#capturePhotoFull').click(captureFullscreenPhoto);
    
    $('#modal-upload-file-btn, #modal-upload-new-btn').click(function() {
        $('#modal-file-input').click();
    });
    
    $('#modal-file-input').change(function(e) {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            if (file.size > 5 * 1024 * 1024) {
                showAlert('error', 'هەڵە', 'قەبارەی فایلەکە دەبێت کەمتر لە 5MB بێت');
                $(this).val('');
                return;
            }
            if (!file.type.match('image.*')) {
                showAlert('error', 'هەڵە', 'تکایە تەنها فایلی وێنە هەڵبگرە');
                $(this).val('');
                return;
            }
            
            $('#modal-captured-image-data').val('');
            $('#modal-image-source-type').val('file');
            $('#modal-remove-image-flag').val('false');
            
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#modal-product-image-preview').attr('src', e.target.result);
                $('#modal-image-preview-section').show();
                $('#modal-default-upload-section').hide();
            };
            reader.readAsDataURL(file);
          
        }
    });
    
    $('#modal-remove-image-btn').click(function() {
        $('#modal-captured-image-data').val('');
        $('#modal-file-input').val('');
        $('#modal-image-source-type').val('');
        $('#modal-remove-image-flag').val('true');
        $('#modal-image-preview-section').hide();
        $('#modal-default-upload-section').show();
      
    });
    
    $(document).on('click', '#modal-product-image-preview', function() {
        const imageUrl = $(this).attr('src');
        if (imageUrl && !imageUrl.includes('placehold')) {
            $('#fullscreen-image').attr('src', imageUrl);
            fullscreenImageModal.show();
        }
    });

    // ============================================
    // Save Product Changes
    // ============================================
    $('#save-product-changes').click(function () {
        let formData = new FormData($('#edit-product-form')[0]);
        formData.append('id', $('#edit-product-id').val());
        formData.append('new_barcode', normalizeToEnglishNumbers($('#edit-barcode').val()));
        formData.append('purchase_price', removeThousandSeparators($('#edit-purchase-price').val()));
        formData.append('selling_price', removeThousandSeparators($('#edit-selling-price').val()));

        let btn = $(this);
        let originalText = btn.html();
        btn.html('تۆمار دەکرێت...').prop('disabled', true);

        $.ajax({
            url: '{{ route("products.update") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                if (res.success) {
                    showAlert('success', 'سەرکەوتوو', res.message);
                    editModal.hide();
                    loadProducts(currentPage);
                } else {
                    showAlert('error', 'هەڵە', res.message);
                }
            },
            error: function (xhr) {
                let msg = 'هەڵەیەک ڕوویدا';
                if (xhr.responseJSON?.errors) {
                    msg = Object.values(xhr.responseJSON.errors).flat().join(', ');
                } else if (xhr.responseJSON?.message) {
                    msg = xhr.responseJSON.message;
                }
                showAlert('error', 'هەڵە', msg);
            },
            complete: function () {
                btn.html(originalText).prop('disabled', false);
            }
        });
    });
    
    // ============================================
    // Delete Product
    // ============================================
    $(document).on('click', '.delete-product-btn', function() {
        deleteProductId = $(this).data('id');
        let productName = $(this).data('name');
        $('#delete-product-name').html(`<strong>${escapeHtml(productName)}</strong>`);
        deleteModal.show();
    });
    
    $('#confirm-delete').click(function() {
        if (!deleteProductId) return;
        
        let btn = $(this);
        let originalText = btn.html();
        btn.html('<div class="loading-spinner"></div> سڕینەوە...').prop('disabled', true);
        
        $.ajax({
            url: '/products/' + deleteProductId + '/delete',
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}',
                id: deleteProductId
            },
            success: function(response) {
                if (response.success) {
                    showAlert('success', 'سەرکەوتوو', 'کاڵاکە بە سەرکەوتوویی سڕدرایەوە');
                    deleteModal.hide();
                    loadProducts(currentPage);
                } else {
                    showAlert('error', 'هەڵە', response.message || 'هەڵەیەک ڕوویدا لە سڕینەوەدا');
                }
            },
            error: function() {
                showAlert('error', 'هەڵە', 'هەڵەیەک ڕوویدا لە سڕینەوەدا');
            },
            complete: function() {
                btn.html(originalText).prop('disabled', false);
                deleteProductId = null;
            }
        });
    });
    
    // ============================================
    // Initial load
    // ============================================
    loadProducts();
});
</script>
@endsection