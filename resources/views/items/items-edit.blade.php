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
        --text-muted: #64748b;
        --border-color: #e2e8f0;
        --bg-light: #f8fafc;
        --bg-card: #ffffff;
        --bg-body: #f1f5f9;
        --shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        --shadow-sm: 0 4px 12px rgba(0, 0, 0, 0.08);
        --transition: all 0.3s ease;
    }

    body.dark-mode {
        --text: #e2e8f0;
        --text-muted: #94a3b8;
        --border-color: #334155;
        --bg-light: #1e293b;
        --bg-card: #1e293b;
        --bg-body: #0f172a;
        --shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);
        --shadow-sm: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    body {
        background: var(--bg-body);
        font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
        transition: background-color 0.3s ease, color 0.3s ease;
        color: var(--text);
    }

    /* ============================================ */
    /* COMPANY BADGE                                 */
    /* ============================================ */
    .company-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 12px;
        background: linear-gradient(135deg, rgba(74, 100, 145, 0.15), rgba(93, 122, 176, 0.15));
        color: var(--primary);
        border: 1px solid rgba(74, 100, 145, 0.3);
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        white-space: nowrap;
        transition: all 0.2s;
        max-width: 100%;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .company-badge:hover {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(74, 100, 145, 0.4);
    }

    body.dark-mode .company-badge {
        background: rgba(93, 122, 176, 0.2);
        color: #c084fc;
        border-color: rgba(93, 122, 176, 0.4);
    }

    body.dark-mode .company-badge:hover {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
    }

    .company-badge.no-company {
        background: rgba(148, 163, 184, 0.15);
        color: #64748b;
        border-color: rgba(148, 163, 184, 0.3);
        font-style: italic;
    }

    body.dark-mode .company-badge.no-company {
        background: rgba(100, 116, 139, 0.2);
        color: #94a3b8;
    }

    /* ============================================ */
    /* PRODUCTS TABLE CONTAINER                      */
    /* ============================================ */
    .products-table-container {
        background: var(--bg-card);
        border-radius: 1rem;
        box-shadow: var(--shadow);
        overflow-x: auto;
        margin-bottom: 2rem;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
        -webkit-overflow-scrolling: touch;
    }

    body.dark-mode .products-table-container {
        background: var(--bg-card);
        box-shadow: var(--shadow);
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
        white-space: nowrap;
    }

    .products-table td {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid var(--border-color);
        vertical-align: middle;
        text-align: center;
        transition: border-color 0.3s ease;
        color: var(--text);
    }

    body.dark-mode .products-table td {
        border-bottom: 1px solid var(--border-color);
        color: var(--text);
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
        flex-wrap: wrap;
    }

    .btn-edit-table {
        background: linear-gradient(135deg, var(--info), #2563eb);
        color: white;
        border: none;
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
        white-space: nowrap;
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
        white-space: nowrap;
    }

    .btn-delete-table:hover {
        transform: scale(1.05);
        box-shadow: 0 2px 8px rgba(239,68,68,0.4);
    }

    /* ============================================ */
    /* SEARCH SECTION                                */
    /* ============================================ */
    .search-section {
        margin-bottom: 2rem;
    }

    .search-card {
        background: var(--bg-card);
        border-radius: 1rem;
        padding: 1.5rem;
        box-shadow: var(--shadow-sm);
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    body.dark-mode .search-card {
        background: var(--bg-card);
        box-shadow: var(--shadow-sm);
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
        border: 2px solid var(--border-color);
        border-radius: 12px;
        transition: all 0.3s;
        padding-right: 40px;
        background-color: var(--bg-card);
        color: var(--text);
    }

    body.dark-mode .search-input-wrapper .form-control {
        background-color: var(--bg-body);
        border-color: var(--border-color);
        color: var(--text);
    }

    body.dark-mode .search-input-wrapper .form-control::placeholder {
        color: var(--text-muted);
    }

    .search-input-wrapper .form-control:focus {
        border-color: var(--primary);
        outline: none;
        box-shadow: 0 0 0 3px rgba(74,100,145,0.2);
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
        white-space: nowrap;
    }

    .reset-filters:hover {
        background: #4b5563;
    }

    /* ============================================ */
    /* CARD STYLES                                   */
    /* ============================================ */
    body.dark-mode .card {
        background-color: var(--bg-card) !important;
        box-shadow: var(--shadow-sm) !important;
        color: var(--text);
    }

    body.dark-mode .card-header {
        background: linear-gradient(135deg, #4a6491, #2c3e50) !important;
        color: white;
    }

    /* ============================================ */
    /* EDIT FORM MODAL                               */
    /* ============================================ */
    .edit-modal .modal-content {
        border-radius: 1.5rem;
        overflow: hidden;
        max-height: 90vh;
        background: var(--bg-card);
        color: var(--text);
    }

    body.dark-mode .edit-modal .modal-content {
        background-color: var(--bg-card);
        color: var(--text);
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
        -webkit-overflow-scrolling: touch;
    }

    .edit-modal .form-label {
        font-weight: 600;
        color: var(--secondary);
        margin-bottom: 0.5rem;
    }

    body.dark-mode .edit-modal .form-label {
        color: var(--text-muted);
    }

    .edit-modal .form-control {
        border: 2px solid var(--border-color);
        border-radius: 10px;
        padding: 0.7rem 1rem;
        transition: all 0.3s;
        background-color: var(--bg-card);
        color: var(--text);
    }

    body.dark-mode .edit-modal .form-control {
        background-color: var(--bg-body);
        border-color: var(--border-color);
        color: var(--text);
    }

    body.dark-mode .edit-modal .form-control::placeholder {
        color: var(--text-muted);
    }

    .edit-modal .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(74,100,145,0.2);
    }

    .edit-modal .form-control.is-valid {
        border-color: var(--success) !important;
        background-image: none !important;
    }

    .edit-modal .form-control.is-invalid {
        border-color: var(--danger) !important;
        background-image: none !important;
    }

    body.dark-mode .edit-modal .form-control.is-valid,
    body.dark-mode .edit-modal .form-control.is-invalid {
        background-color: var(--bg-body);
    }

    /* ============================================ */
    /* SELLER & COMPANY AUTOCOMPLETE                 */
    /* ============================================ */
    #voucher-suggestions,
    #company-suggestions {
        border-radius: 10px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        border: 1px solid var(--border-color);
        background: var(--bg-card);
        overflow: hidden;
    }

    body.dark-mode #voucher-suggestions,
    body.dark-mode #company-suggestions {
        background: var(--bg-card);
        border-color: var(--border-color);
        box-shadow: 0 6px 20px rgba(0,0,0,0.5);
    }

    #voucher-suggestions .voucher-suggestion-item,
    #company-suggestions .company-suggestion-item {
        border: none;
        border-bottom: 1px solid var(--border-color);
        padding: 0.65rem 1rem;
        font-size: 0.9rem;
        text-align: right;
        cursor: pointer;
        transition: background 0.15s;
        background: var(--bg-card);
        color: var(--text);
        width: 100%;
        display: block;
    }

    body.dark-mode #voucher-suggestions .voucher-suggestion-item,
    body.dark-mode #company-suggestions .company-suggestion-item {
        background: var(--bg-card);
        color: var(--text);
        border-bottom-color: var(--border-color);
    }

    #voucher-suggestions .voucher-suggestion-item:hover,
    #voucher-suggestions .voucher-suggestion-item.active,
    #company-suggestions .company-suggestion-item:hover,
    #company-suggestions .company-suggestion-item.active {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
    }

    #voucher-suggestions .voucher-suggestion-item i,
    #company-suggestions .company-suggestion-item i {
        color: var(--primary);
    }

    #voucher-suggestions .voucher-suggestion-item:hover i,
    #voucher-suggestions .voucher-suggestion-item.active i,
    #company-suggestions .company-suggestion-item:hover i,
    #company-suggestions .company-suggestion-item.active i {
        color: white;
    }

    /* ✅ SUGGESTIONS MESSAGE ITEMS - دارک مۆد */
    #voucher-suggestions .suggestion-message,
    #company-suggestions .suggestion-message {
        background: var(--bg-card);
        color: var(--text-muted);
        padding: 0.75rem 1rem;
        text-align: center;
        cursor: default;
        font-size: 0.9rem;
        border: none;
    }

    body.dark-mode #voucher-suggestions .suggestion-message,
    body.dark-mode #company-suggestions .suggestion-message {
        background: var(--bg-card) !important;
        color: var(--text-muted) !important;
    }

    #voucher-suggestions .suggestion-message.text-danger,
    #company-suggestions .suggestion-message.text-danger {
        color: #ef4444 !important;
    }

    body.dark-mode #voucher-suggestions .suggestion-message.text-danger,
    body.dark-mode #company-suggestions .suggestion-message.text-danger {
        color: #f87171 !important;
    }

    #voucher-suggestions .suggestion-message i,
    #company-suggestions .suggestion-message i {
        color: inherit;
    }

    /* ============================================ */
    /* FULLSCREEN IMAGE MODAL                        */
    /* ============================================ */
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

    /* ============================================ */
    /* ALERTS                                        */
    /* ============================================ */
    #alert-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        width: 350px;
        max-width: calc(100vw - 40px);
    }

    .alert-custom {
        border-radius: 12px;
        padding: 1rem 1.2rem;
        margin-bottom: 1rem;
        display: flex;
        align-items: flex-start;
        gap: 0.8rem;
        animation: slideDown 0.3s ease-out;
        position: relative;
        overflow: hidden;
        word-wrap: break-word;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .alert-custom .btn-close {
        flex-shrink: 0;
        margin-left: auto;
        align-self: flex-start;
        opacity: 0.7;
    }

    .alert-success-custom {
        background-color: rgba(12, 239, 4, 0.982);
        color: #065f46;
        border-left: 5px solid var(--success);
    }

    .alert-error-custom {
        background: #fee2e2;
        color: #991b1b;
        border-left: 5px solid var(--danger);
    }

    .alert-warning-custom {
        background: #fed7aa;
        color: #92400e;
        border-left: 5px solid var(--warning);
    }

    .alert-info-custom {
        background: #dbeafe;
        color: #1e3a8a;
        border-left: 5px solid var(--info);
    }

    body.dark-mode .alert-success-custom {
        background: linear-gradient(135deg, #064e3b, #065f46);
        color: #a7f3d0;
    }

    body.dark-mode .alert-error-custom {
        background: linear-gradient(135deg, #7f1d1d, #991b1b);
        color: #fecaca;
    }

    body.dark-mode .alert-warning-custom {
        background: linear-gradient(135deg, #78350f, #92400e);
        color: #fde68a;
    }

    body.dark-mode .alert-info-custom {
        background: linear-gradient(135deg, #1e3a8a, #1e40af);
        color: #bfdbfe;
    }

    body.dark-mode .alert-custom .btn-close {
        filter: invert(1);
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* ============================================ */
    /* LOADING SPINNER                               */
    /* ============================================ */
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

    /* ============================================ */
    /* PAGINATION                                    */
    /* ============================================ */
    .pagination {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 1.5rem;
        flex-wrap: wrap;
        padding: 0;
        list-style: none;
    }

    .pagination a, .pagination span {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        background: var(--bg-card);
        color: var(--primary);
        text-decoration: none;
        border: 1px solid var(--border-color);
        transition: all 0.2s;
        font-weight: 600;
        min-width: 40px;
        text-align: center;
    }

    body.dark-mode .pagination a,
    body.dark-mode .pagination span {
        background: var(--bg-card);
        color: var(--text);
        border-color: var(--border-color);
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

    /* ============================================ */
    /* STOCK BADGES                                  */
    /* ============================================ */
    .badge-stock {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-block;
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

    /* ============================================ */
    /* MODAL IMAGE UPLOAD                            */
    /* ============================================ */
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
        flex-direction: column;
    }

    body.dark-mode .modal-image-upload-container {
        background: rgba(74, 100, 145, 0.1);
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
        flex-wrap: wrap;
    }

    .modal-camera-btn, .modal-upload-btn, .modal-remove-btn {
        padding: 0.3rem 0.8rem;
        border-radius: 8px;
        border: none;
        color: white;
        cursor: pointer;
        font-size: 0.8rem;
        white-space: nowrap;
    }

    .modal-camera-btn { background: linear-gradient(135deg, var(--primary), var(--secondary)); }
    .modal-upload-btn { background: linear-gradient(135deg, var(--success), #059669); }
    .modal-remove-btn { background: linear-gradient(135deg, var(--danger), #dc2626); }

    /* ============================================ */
    /* FULLSCREEN CAMERA                             */
    /* ============================================ */
    .camera-fullscreen {
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background-color: black;
        z-index: 99999;
        display: none;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .camera-fullscreen.active { display: flex; }
    .camera-fullscreen video { width: 100%; height: 100%; object-fit: cover; }

    .camera-fullscreen .camera-controls-full {
        position: fixed;
        bottom: 30px;
        left: 0; right: 0;
        display: flex;
        justify-content: center;
        gap: 20px;
        padding: 20px;
        background: rgba(0, 0, 0, 0.7);
        z-index: 100000;
        flex-wrap: wrap;
    }

    .camera-fullscreen .camera-controls-full button {
        padding: 15px 25px;
        font-size: 1rem;
        border: none;
        border-radius: 50px;
        cursor: pointer;
        white-space: nowrap;
    }

    .camera-fullscreen .btn-capture-full { background-color: #10b981; color: white; }
    .camera-fullscreen .btn-switch-full { background-color: #3b82f6; color: white; }

    .camera-fullscreen .close-camera {
        position: absolute;
        top: 20px; right: 20px;
        background: rgba(0, 0, 0, 0.6);
        color: white;
        border: none;
        width: 45px; height: 45px;
        border-radius: 50%;
        font-size: 24px;
        cursor: pointer;
        z-index: 100001;
    }

    /* ============================================ */
    /* SECTION TITLE                                 */
    /* ============================================ */
    .section-title-custom {
        font-size: 1rem;
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--secondary);
    }

    body.dark-mode .section-title-custom {
        color: var(--text-muted);
        border-bottom-color: var(--border-color);
    }

    /* ============================================ */
    /* INPUT WITH ICON                               */
    /* ============================================ */
    .input-with-icon-custom { position: relative; }

    .barcode-generate-btn {
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
        transition: all 0.2s;
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
    }

    .is-invalid {
        border-color: var(--danger) !important;
    }

    /* ============================================ */
    /* BARCODE SCANNER MODAL                         */
    /* ============================================ */
    .scanner-modal .modal-content {
        background: #000;
        border-radius: 1rem;
        overflow: hidden;
    }

    .scanner-modal .modal-header {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
    }

    .scanner-modal .btn-close { filter: invert(1); }

    #qr-reader {
        width: 100%;
        overflow: hidden;
    }

    #qr-reader video {
        width: 100% !important;
        min-height: 300px;
        object-fit: cover;
    }

    .scan-instruction {
        position: absolute;
        bottom: 20px;
        left: 0; right: 0;
        text-align: center;
        color: white;
        background: rgba(0,0,0,0.7);
        padding: 8px;
        font-size: 0.9rem;
    }

    /* ============================================ */
    /* FORM HEADER                                   */
    /* ============================================ */
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

    body.dark-mode .form-logo-custom {
        background-color: #334155;
    }

    .form-logo-custom i {
        font-size: 2.5rem;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* ============================================ */
    /* MODAL FOOTER / BUTTONS                        */
    /* ============================================ */
    .edit-modal .modal-footer {
        background: var(--bg-card);
        border-top: 1px solid var(--border-color);
    }

    body.dark-mode .edit-modal .modal-footer {
        background: var(--bg-card);
        border-top-color: var(--border-color);
    }

    body.dark-mode .btn-secondary {
        background: #475569;
        border-color: #475569;
        color: #e2e8f0;
    }

    body.dark-mode .btn-secondary:hover {
        background: #64748b;
        border-color: #64748b;
    }

    /* ============================================ */
    /* RESPONSIVE BREAKPOINTS                        */
    /* ============================================ */

    /* Tablet */
    @media (max-width: 992px) {
        .edit-modal .modal-dialog {
            max-width: 95%;
            margin: 1rem auto;
        }

        .products-table {
            font-size: 0.85rem;
        }

        .products-table th,
        .products-table td {
            padding: 0.6rem 0.5rem;
        }
    }

    /* Mobile */
    @media (max-width: 768px) {
        #alert-container {
            top: 10px;
            right: 10px;
            left: 10px;
            width: auto;
            max-width: none;
        }

        .container {
            padding-left: 10px;
            padding-right: 10px;
        }

        .search-card {
            padding: 1rem;
        }

        .search-input-group {
            flex-direction: column;
            gap: 0.75rem;
        }

        .search-input-wrapper {
            min-width: 100%;
            width: 100%;
        }

        .reset-filters {
            width: 100%;
        }

        /* Table to cards */
        .products-table-container {
            background: transparent !important;
            box-shadow: none !important;
            overflow: visible;
        }

        .products-table {
            display: block;
        }

        .products-table thead { display: none; }

        .products-table tbody {
            display: block;
            width: 100%;
        }

        .products-table tr {
            display: block;
            background: var(--bg-card);
            border-radius: 12px;
            margin-bottom: 12px;
            padding: 12px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
        }

        body.dark-mode .products-table tr {
            background: var(--bg-card);
            border-color: var(--border-color);
        }

        .products-table td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: none !important;
            padding: 8px 0 !important;
            text-align: right;
            font-size: 0.85rem;
            gap: 10px;
        }

        .products-table td:before {
            content: attr(data-label);
            font-weight: 700;
            color: var(--primary);
            flex-shrink: 0;
            font-size: 0.8rem;
            text-align: left;
        }

        body.dark-mode .products-table td:before {
            color: var(--text-muted);
        }

        .products-table td:first-child {
            justify-content: center;
            padding-bottom: 12px !important;
            border-bottom: 1px solid var(--border-color) !important;
            margin-bottom: 8px;
        }

        .products-table td:first-child:before { display: none; }

        .products-table .action-buttons {
            flex-direction: column;
            gap: 8px;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid var(--border-color);
            width: 100%;
        }

        .products-table .action-buttons button {
            width: 100%;
            padding: 0.5rem;
        }

        /* Modal */
        .edit-modal .modal-dialog {
            margin: 0.5rem;
            max-width: calc(100% - 1rem);
        }

        .edit-modal .modal-body {
            padding: 1rem;
            max-height: 65vh;
        }

        .edit-modal .modal-header,
        .edit-modal .modal-footer {
            padding: 0.8rem 1rem;
        }

        .edit-modal .modal-title {
            font-size: 1rem;
        }

        .section-title-custom {
            font-size: 0.9rem;
        }

        .form-logo-custom {
            width: 60px;
            height: 60px;
            border-radius: 15px;
        }

        .form-logo-custom i {
            font-size: 1.8rem;
        }

        .card-header h1.h2 {
            font-size: 1.2rem;
        }

        /* Camera controls */
        .camera-fullscreen .camera-controls-full {
            gap: 10px;
            padding: 15px;
            bottom: 20px;
        }

        .camera-fullscreen .camera-controls-full button {
            padding: 12px 18px;
            font-size: 0.9rem;
        }

        /* Pagination */
        .pagination {
            gap: 0.3rem;
        }

        .pagination a, .pagination span {
            padding: 0.4rem 0.7rem;
            font-size: 0.8rem;
            min-width: 35px;
        }

        /* Image upload */
        .modal-image-upload-container {
            padding: 0.75rem;
            min-height: 120px;
        }

        .modal-image-preview {
            max-height: 120px;
        }

        .modal-image-actions {
            flex-direction: column;
            width: 100%;
        }

        .modal-image-actions button {
            width: 100%;
            padding: 0.5rem;
        }

        /* Scanner */
        #qr-reader video {
            min-height: 250px;
        }

        .scanner-modal .modal-dialog {
            margin: 0.5rem;
        }

        /* Buttons */
        .btn-edit-table,
        .btn-delete-table {
            font-size: 0.8rem;
            padding: 0.4rem 0.6rem;
        }

        /* Suggestions dropdown */
        #voucher-suggestions,
        #company-suggestions {
            max-height: 180px;
        }

        /* Form inputs */
        .edit-modal .form-control {
            font-size: 0.9rem;
            padding: 0.6rem 0.8rem;
        }

        /* Barcode buttons */
        .barcode-generate-btn {
            width: 32px;
            height: 32px;
        }

        /* Input padding for barcode icons */
        #edit-barcode {
            padding-right: 80px !important;
        }
    }

    /* Small Mobile */
    @media (max-width: 480px) {
        .products-table td {
            font-size: 0.8rem;
            padding: 6px 0 !important;
        }

        .products-table td:before {
            font-size: 0.75rem;
        }

        .company-badge {
            font-size: 0.7rem;
            padding: 3px 8px;
        }

        .badge-stock {
            font-size: 0.7rem;
            padding: 0.2rem 0.5rem;
        }

        .edit-modal .modal-body {
            padding: 0.75rem;
        }

        .camera-fullscreen .camera-controls-full button {
            padding: 10px 14px;
            font-size: 0.8rem;
        }

        .alert-custom {
            padding: 0.75rem 1rem;
            font-size: 0.85rem;
        }

        #alert-container {
            top: 5px;
            right: 5px;
            left: 5px;
        }
    }

    /* Very Small Mobile */
    @media (max-width: 360px) {
        .products-table td {
            flex-direction: column;
            align-items: flex-start;
            gap: 4px;
        }

        .products-table td:before {
            font-size: 0.7rem;
        }

        .edit-modal .modal-title {
            font-size: 0.9rem;
        }

        .section-title-custom {
            font-size: 0.85rem;
        }
    }

    /* Print styles */
    @media print {
        .search-section,
        .action-buttons,
        .pagination,
        .card-header,
        #alert-container {
            display: none !important;
        }

        .products-table-container {
            box-shadow: none;
            border: 1px solid #000;
        }
    }

    /* Dark mode scrollbar */
    body.dark-mode ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    body.dark-mode ::-webkit-scrollbar-track {
        background: #1e293b;
    }

    body.dark-mode ::-webkit-scrollbar-thumb {
        background: #475569;
        border-radius: 4px;
    }

    body.dark-mode ::-webkit-scrollbar-thumb:hover {
        background: #64748b;
    }

    /* Smooth scroll */
    html {
        scroll-behavior: smooth;
    }

    /* Touch improvements */
    @media (hover: none) {
        .btn-edit-table:hover,
        .btn-delete-table:hover,
        .product-image-thumb:hover {
            transform: none;
        }

        .btn-edit-table:active,
        .btn-delete-table:active {
            transform: scale(0.95);
            opacity: 0.8;
        }
    }

    #edit-barcode {
        padding-right: 45px !important;
    }
</style>

<!-- Alert Container -->
<div id="alert-container"></div>

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

    <!-- Search Section -->
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
                <div class="search-input-wrapper">
                    <input type="text" id="search-voucher" class="form-control" placeholder="ناوی فرۆشیار ..." autocomplete="off">
                    <div class="search-loading-indicator" id="voucher-loading">
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
                    <th>ناوی فرۆشیار</th>
                    <th>نرخی کڕین</th>
                    <th>نرخی فرۆشتن</th>
                    <th>بڕی کاڵای دووکان</th>
                    <th>کردار</th>
                </tr>
            </thead>
            <tbody id="products-table-body">
                <tr>
                    <td colspan="8" class="text-center py-5">
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
            </div>
            <div class="modal-body">
                <form id="edit-product-form" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="edit-product-id" name="product_id">
                    <input type="hidden" id="edit-old-barcode" name="barcode_old">

                    <div class="mb-4">
                        <h3 class="section-title-custom">
                            <i class="fas fa-info-circle ms-2"></i>زانیارییە سەرەکییەکانی کاڵا
                        </h3>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">
                                    <span class="text-danger">*</span> بارکۆدی کاڵا
                                </label>
                                <div class="input-with-icon-custom">
                                    <input type="text" id="edit-barcode" name="new_barcode"
                                           class="form-control ps-2"
                                           placeholder="ژمارەی بارکۆد بنوسە ..."
                                           autocomplete="off" required>
                                    <button type="button" id="edit-auto-barcode-btn" class="barcode-generate-btn" title="دروستکردنی بارکۆدی ئەلێاتۆری">
                                        <i class="fas fa-magic"></i>
                                    </button>
                                    <button type="button" id="edit-scan-barcode-btn" class="barcode-generate-btn"
                                            style="left: auto; right: 0rem;" title="سکانکردنی بارکۆد">
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

                            <!-- کۆمپانیا بە Autocomplete -->
                            <div class="col-md-6 mb-3 position-relative">
                                <label class="form-label">
                                    <span class="text-danger">*</span> ناوی کۆمپانیا
                                </label>
                                <input type="text" id="edit-company" name="company"
                                       class="form-control"
                                       placeholder="ناوی کۆمپانیا بنوسە..."
                                       autocomplete="off" required>

                                <div id="company-suggestions"
                                     class="list-group position-absolute w-100"
                                     style="z-index: 1055; max-height: 220px; overflow-y: auto; display: none; top: 100%; left: 0; margin-top: 4px;"></div>

                                <span id="company-status" style="display:inline-block; margin-top:5px; font-size:0.85rem;"></span>
                            </div>

                            <!-- فرۆشیار بە Autocomplete -->
                            <div class="col-md-6 mb-3 position-relative">
                                <label class="form-label">
                                    <i class="fas fa-user-tie ms-1"></i> ناوی فرۆشیار
                                </label>
                                <input type="text" id="edit-voucher-name" name="voucher_name"
                                       class="form-control"
                                       placeholder="ناوی فرۆشیار بنوسە ..."
                                       autocomplete="off">

                                <div id="voucher-suggestions"
                                     class="list-group position-absolute w-100"
                                     style="z-index: 1055; max-height: 220px; overflow-y: auto; display: none; top: 100%; left: 0; margin-top: 4px;"></div>

                                <span id="voucher-status" style="display:inline-block; margin-top:5px; font-size:0.85rem;"></span>
                            </div>
                        </div>
                    </div>

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

                    <div class="mb-4">
                        <h3 class="section-title-custom">
                            <i class="fas fa-camera ms-2"></i>وێنەی کاڵا
                        </h3>

                        <div class="modal-image-upload-container" id="modal-image-upload-container">
                            <div id="modal-image-preview-section" style="display: none; width: 100%;">
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
                            <div id="modal-default-upload-section" style="width: 100%;">
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
                <button type="button" id="save-product-changes" class="btn btn-primary"
                        style="background: linear-gradient(135deg, var(--primary), var(--secondary)); border: none;">
                    <i class="fas fa-save me-2"></i> تۆمارکردنی گۆڕانکاری
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background: var(--bg-card); color: var(--text);">
            <div class="modal-header" style="background: linear-gradient(135deg, var(--danger), #dc2626); color: white;">
                <h5 class="modal-title">
                    <i class="fas fa-trash-alt me-2"></i> سڕینەوەی کاڵا
                </h5>
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
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-camera ms-2"></i>سکانکردنی بارکۆد</h5>
            </div>
            <div class="modal-body p-0 position-relative" style="min-height: 300px; background: #000;">
                <div id="qr-reader" style="width: 100%;"></div>
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
        company: '',
        voucher: ''
    };
    let deleteProductId = null;
    let isSubmitting = false;
    let editModal = new bootstrap.Modal(document.getElementById('editProductModal'));
    let deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
    let fullscreenImageModal = new bootstrap.Modal(document.getElementById('fullscreenImageModal'));
    let barcodeScannerModal = new bootstrap.Modal(document.getElementById('barcodeScannerModal'));
    
    let fullscreenStream = null;
    let currentFacingMode = 'environment';
    let html5QrCode = null;
    let currentScannerTarget = null;

    // Sellers autocomplete
    let sellersCache = [];
    let sellersLoaded = false;
    let voucherValid = true;

    // Companies autocomplete
    let companiesCache = [];
    let companiesLoaded = false;
    let companyValid = true;

    // Company server-side search state
    let companySearchTimer = null;
    let companySearchRequest = null;

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // ============================================
    // Barcode Normalization
    // ============================================
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
        return String(text).replace(/[&<>"]/g, function(m) {
            if (m === '&') return '&amp;';
            if (m === '<') return '&lt;';
            if (m === '>') return '&gt;';
            if (m === '"') return '&quot;';
            return m;
        });
    }

    // ============================================
    // ALERT
    // ============================================
    function showAlert(type, title, message, duration = 4000) {
        let icon, alertClass;
        switch(type) {
            case 'success': icon = 'fas fa-check-circle'; alertClass = 'alert-success-custom'; break;
            case 'error': icon = 'fas fa-exclamation-circle'; alertClass = 'alert-error-custom'; break;
            case 'warning': icon = 'fas fa-exclamation-triangle'; alertClass = 'alert-warning-custom'; break;
            default: icon = 'fas fa-info-circle'; alertClass = 'alert-info-custom';
        }
        const alertId = 'alert-' + Date.now();
        const alertHtml = `
            <div id="${alertId}" class="alert-custom ${alertClass}">
                <i class="${icon}" style="font-size: 1.3rem;"></i>
                <div>
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
    // LOAD SELLERS
    // ============================================
    function loadSellers(forceReload = false) {
        if (sellersLoaded && !forceReload) return;

        $.ajax({
            url: '{{ route("sellers.list") }}',
            type: 'GET',
            success: function(res) {
                if (res.success && Array.isArray(res.sellers)) {
                    sellersCache = res.sellers;
                    sellersLoaded = true;
                }
            },
            error: function() {
                console.warn('⚠️ نەتوانرا لیستی فرۆشیارەکان بار بکرێت');
            }
        });
    }

    // ============================================
    // LOAD COMPANIES
    // ============================================
    function loadCompanies(forceReload = false) {
        if (companiesLoaded && !forceReload) return;

        $.ajax({
            url: '{{ route("companies.list") }}',
            type: 'GET',
            success: function(res) {
                if (res.success && Array.isArray(res.companies)) {
                    companiesCache = res.companies.map(c => ({
                        id: c.id,
                        name: c.company_name || c.company
                    })).filter(c => c.name && c.name.trim() !== '');
                    
                    companiesLoaded = true;
                }
            },
            error: function(xhr) {
                console.warn('⚠️ نەتوانرا لیستی کۆمپانیاکان بار بکرێت', xhr);
            }
        });
    }

    // ============================================
    // ✅ COMPANY SUGGESTIONS — Server-side search
    // ============================================
    function showCompanySuggestions(query) {
        const box = $('#company-suggestions');

        if (!query || query.trim() === '') {
            box.hide().empty();
            return;
        }

        if (companySearchRequest) {
            companySearchRequest.abort();
        }

        box.html(`
            <div class="suggestion-message">
                <i class="fas fa-spinner fa-spin me-2"></i>
                گەڕان...
            </div>
        `).show();

        clearTimeout(companySearchTimer);
        companySearchTimer = setTimeout(function () {
            companySearchRequest = $.ajax({
                url: '{{ route("companies.search") }}',
                type: 'GET',
                data: { q: query.trim() },
                success: function (res) {
                    if (res.success && Array.isArray(res.companies) && res.companies.length > 0) {
                        const matches = res.companies.map(c => ({
                            id: c.id,
                            name: c.company_name || c.company
                        }));

                        let html = '';
                        matches.forEach(function (c) {
                            html += `<button type="button"
                                        class="list-group-item company-suggestion-item"
                                        data-id="${c.id}"
                                        data-name="${escapeHtml(c.name)}">
                                        <i class="fas fa-building ms-2"></i>${escapeHtml(c.name)}
                                     </button>`;
                        });
                        box.html(html).show();
                    } else {
                        box.html(`
                            <div class="suggestion-message">
                                <i class="fas fa-search me-2"></i>
                                هیچ کۆمپانیایەک نەدۆزرایەوە
                            </div>
                        `).show();
                    }
                },
                error: function (xhr) {
                    if (xhr.statusText === 'abort') return;
                    box.html(`
                        <div class="suggestion-message text-danger">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            هەڵە لە گەڕان
                        </div>
                    `).show();
                }
            });
        }, 250);
    }

    // ============================================
    // validateCompany — Server-side
    // ============================================
    function validateCompany(silent = false) {
        const value = $('#edit-company').val().trim();
        const status = $('#company-status');

        if (value === '') {
            companyValid = true;
            status.text('');
            $('#edit-company').removeClass('is-valid is-invalid');
            return true;
        }

        let found = companiesCache.find(c =>
            c.name && c.name.toLowerCase() === value.toLowerCase()
        );

        if (found) {
            companyValid = true;
            status.html('✅ ناوی کۆمپانیا دروستە').css('color', '#10b981');
            $('#edit-company').removeClass('is-invalid').addClass('is-valid');
            return true;
        }

        if (!silent) {
            $.ajax({
                url: '{{ route("companies.search") }}',
                type: 'GET',
                data: { q: value },
                success: function(res) {
                    const exactMatch = res.companies && res.companies.find(c => {
                        const name = c.company_name || c.company;
                        return name && name.toLowerCase() === value.toLowerCase();
                    });

                    if (exactMatch) {
                        companyValid = true;
                        status.html('✅ ناوی کۆمپانیا دروستە').css('color', '#10b981');
                        $('#edit-company').removeClass('is-invalid').addClass('is-valid');
                    } else {
                        companyValid = false;
                        status.html('❌ ئەم کۆمپانیایە پێشتر تۆمار نەکراوە').css('color', '#ef4444');
                        $('#edit-company').removeClass('is-valid').addClass('is-invalid');
                    }
                }
            });
            return true;
        } else {
            companyValid = false;
            status.html('❌ ئەم کۆمپانیایە پێشتر تۆمار نەکراوە').css('color', '#ef4444');
            $('#edit-company').removeClass('is-valid').addClass('is-invalid');
            return false;
        }
    }

    let companyTimer;
    $('#edit-company').on('input', function() {
        const val = $(this).val();
        showCompanySuggestions(val);
        clearTimeout(companyTimer);
        companyTimer = setTimeout(function() {
            validateCompany(false);
        }, 500);
    });

    $('#edit-company').on('focus', function() {
        const val = $(this).val();
        if (val && val.trim() !== '') {
            showCompanySuggestions(val);
        }
    });

    $(document).on('click', '.company-suggestion-item', function() {
        const name = $(this).data('name');
        $('#edit-company').val(name);
        $('#company-suggestions').hide().empty();
        validateCompany(true);
    });

    let companySuggestionIndex = -1;
    $('#edit-company').on('keydown', function(e) {
        const items = $('#company-suggestions .company-suggestion-item');
        if (items.length === 0) return;

        if (e.key === 'ArrowDown') {
            e.preventDefault();
            companySuggestionIndex = Math.min(companySuggestionIndex + 1, items.length - 1);
            items.removeClass('active').eq(companySuggestionIndex).addClass('active')[0].scrollIntoView({block: 'nearest'});
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            companySuggestionIndex = Math.max(companySuggestionIndex - 1, 0);
            items.removeClass('active').eq(companySuggestionIndex).addClass('active')[0].scrollIntoView({block: 'nearest'});
        } else if (e.key === 'Enter') {
            if (companySuggestionIndex >= 0 && items.eq(companySuggestionIndex).length) {
                e.preventDefault();
                items.eq(companySuggestionIndex).trigger('click');
                companySuggestionIndex = -1;
            }
        } else if (e.key === 'Escape') {
            $('#company-suggestions').hide();
            companySuggestionIndex = -1;
        }
    });

    // ============================================
    // SELLER AUTOCOMPLETE
    // ============================================
    function showVoucherSuggestions(query) {
        const box = $('#voucher-suggestions');

        if (!query || query.trim() === '') {
            box.hide().empty();
            return;
        }

        const q = query.trim().toLowerCase();
        const matches = sellersCache.filter(s =>
            s.name && s.name.toLowerCase().startsWith(q)
        );

        if (matches.length === 0) {
            box.html(`
                <div class="suggestion-message">
                    <i class="fas fa-search me-2"></i>
                    هیچ فرۆشیارێک نەدۆزرایەوە
                </div>
            `).show();
            return;
        }

        let html = '';
        matches.slice(0, 10).forEach(function(s) {
            html += `<button type="button"
                        class="list-group-item voucher-suggestion-item"
                        data-name="${escapeHtml(s.name)}">
                        <i class="fas fa-user ms-2"></i>${escapeHtml(s.name)}
                     </button>`;
        });
        box.html(html).show();
    }

    function validateVoucherName(silent = false) {
        const value = $('#edit-voucher-name').val().trim();
        const status = $('#voucher-status');

        if (value === '') {
            voucherValid = true;
            status.text('');
            $('#edit-voucher-name').removeClass('is-valid is-invalid');
            return true;
        }

        const found = sellersCache.find(s =>
            s.name && s.name.toLowerCase() === value.toLowerCase()
        );

        if (found) {
            voucherValid = true;
            status.html('✅ ناوی فرۆشیار دروستە').css('color', '#10b981');
            $('#edit-voucher-name').removeClass('is-invalid').addClass('is-valid');
            return true;
        } else {
            voucherValid = false;
            status.html('❌ ئەم ناوە پێشتر تۆمار نەکراوە').css('color', '#ef4444');
            $('#edit-voucher-name').removeClass('is-valid').addClass('is-invalid');
            return false;
        }
    }

    let voucherTimer;
    $('#edit-voucher-name').on('input', function() {
        const val = $(this).val();
        showVoucherSuggestions(val);
        clearTimeout(voucherTimer);
        voucherTimer = setTimeout(function() {
            validateVoucherName(true);
        }, 300);
    });

    $('#edit-voucher-name').on('focus', function() {
        const val = $(this).val();
        if (val && val.trim() !== '') {
            showVoucherSuggestions(val);
        }
    });

    $(document).on('click', '.voucher-suggestion-item', function() {
        const name = $(this).data('name');
        $('#edit-voucher-name').val(name);
        $('#voucher-suggestions').hide().empty();
        validateVoucherName();
    });

    let suggestionIndex = -1;
    $('#edit-voucher-name').on('keydown', function(e) {
        const items = $('#voucher-suggestions .voucher-suggestion-item');
        if (items.length === 0) return;

        if (e.key === 'ArrowDown') {
            e.preventDefault();
            suggestionIndex = Math.min(suggestionIndex + 1, items.length - 1);
            items.removeClass('active').eq(suggestionIndex).addClass('active')[0].scrollIntoView({block: 'nearest'});
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            suggestionIndex = Math.max(suggestionIndex - 1, 0);
            items.removeClass('active').eq(suggestionIndex).addClass('active')[0].scrollIntoView({block: 'nearest'});
        } else if (e.key === 'Enter') {
            if (suggestionIndex >= 0 && items.eq(suggestionIndex).length) {
                e.preventDefault();
                items.eq(suggestionIndex).trigger('click');
                suggestionIndex = -1;
            }
        } else if (e.key === 'Escape') {
            $('#voucher-suggestions').hide();
            suggestionIndex = -1;
        }
    });

    $(document).on('click', function(e) {
        if (!$(e.target).closest('#edit-voucher-name, #voucher-suggestions').length) {
            $('#voucher-suggestions').hide();
        }
        if (!$(e.target).closest('#edit-company, #company-suggestions').length) {
            $('#company-suggestions').hide();
        }
    });

    // ============================================
    // Modal Open/Close
    // ============================================
    $('#editProductModal').on('shown.bs.modal', function() {
        loadSellers();
        loadCompanies();
        
        setTimeout(function() {
            validateVoucherName(true);
            validateCompany(true);
        }, 800);
    });

    $('#editProductModal').on('hidden.bs.modal', function() {
        $('#voucher-suggestions').hide().empty();
        $('#company-suggestions').hide().empty();
        $('#voucher-status').text('');
        $('#company-status').text('');
        
        $('#edit-voucher-name').removeClass('is-valid is-invalid');
        $('#edit-company').removeClass('is-valid is-invalid');
        $('#edit-barcode').removeClass('is-valid is-invalid');
        $('#edit-barcode-status').text('');
        
        voucherValid = true;
        companyValid = true;
        suggestionIndex = -1;
        companySuggestionIndex = -1;
        
        if (companySearchRequest) {
            companySearchRequest.abort();
            companySearchRequest = null;
        }
        clearTimeout(companySearchTimer);
        
        $('#edit-product-form')[0].reset();
        $('#edit-product-id').val('');
        $('#edit-old-barcode').val('');
        
        $('#modal-captured-image-data').val('');
        $('#modal-image-source-type').val('');
        $('#modal-remove-image-flag').val('false');
        $('#modal-file-input').val('');
        $('#modal-image-preview-section').hide();
        $('#modal-default-upload-section').show();
        $('#modal-product-image-preview').attr('src', '');
        
        setTimeout(function() {
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open').css({
                'overflow': '',
                'padding-right': ''
            });
        }, 300);
    });

    // ============================================
    // Live Search Functions
    // ============================================
    function showLoading(field) { $('#' + field + '-loading').show(); }
    function hideLoading(field) { $('#' + field + '-loading').hide(); }
    
    function performLiveSearch() {
        searchParams.barcode = normalizeToEnglishNumbers($('#search-barcode').val().trim());
        searchParams.name = $('#search-name').val().trim();
        searchParams.company = $('#search-company').val().trim();
        searchParams.voucher = $('#search-voucher').val().trim();
        
        console.log('🔍 فلتەرەکان:', searchParams);
        
        loadProducts(1);
    }
    
    function debounceSearch() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            performLiveSearch();
        }, 500);
    }
    
    // ============================================
    // فلتەری بارکۆد
    // ============================================
    $('#search-barcode').on('input', function() {
        showLoading('barcode');
        debounceSearch();
        setTimeout(function() { hideLoading('barcode'); }, 600);
    });
    
    // ============================================
    // فلتەری ناوی کاڵا
    // ============================================
    $('#search-name').on('input', function() {
        showLoading('name');
        debounceSearch();
        setTimeout(function() { hideLoading('name'); }, 600);
    });
    
    // ============================================
    // فلتەری کۆمپانیا
    // ============================================
    let companyFilterTimer = null;
    $('#search-company').on('input', function() {
        const val = $(this).val().trim();
        
        console.log('🔍 فلتەری کۆمپانیا:', val);
        
        showLoading('company');
        
        clearTimeout(companyFilterTimer);
        
        companyFilterTimer = setTimeout(function() {
            searchParams.company = val;
            
            console.log('📤 ناردن بۆ سێرڤەر:', {
                company: searchParams.company,
                allParams: searchParams
            });
            
            loadProducts(1);
            hideLoading('company');
        }, 500);
    });
    
    // ============================================
    // فلتەری فرۆشیار
    // ============================================
    $('#search-voucher').on('input', function() {
        showLoading('voucher');
        debounceSearch();
        setTimeout(function() { hideLoading('voucher'); }, 600);
    });
    
    $('#reset-filters').click(function() {
        $('#search-barcode, #search-name, #search-company, #search-voucher').val('');
        searchParams = { barcode: '', name: '', company: '', voucher: '' };
        loadProducts(1);
    });

    // ============================================
    // Barcode Scanner
    // ============================================
    async function startBarcodeScanner(target) {
        currentScannerTarget = target;
        await stopBarcodeScanner();
        
        const qrReader = document.getElementById('qr-reader');
        if (!qrReader) return;
        
        if (html5QrCode) {
            try {
                if (html5QrCode.isScanning) await html5QrCode.stop();
                await html5QrCode.clear();
            } catch(e) {}
        }
        
        html5QrCode = new Html5Qrcode("qr-reader");
        
        const config = {
            fps: 10,
            qrbox: { width: 250, height: 200 },
            aspectRatio: 1.0,
        };
        
        try {
            await html5QrCode.start(
                { facingMode: "environment" },
                config,
                (decodedText) => {
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
                () => {}
            );
        } catch (err) {
            showAlert('error', 'هەڵەی کامێرا', 'ناتوانرێت کامێرا بۆ سکانکردن بکرێتەوە');
            barcodeScannerModal.hide();
        }
    }
    
    async function stopBarcodeScanner() {
        if (html5QrCode && html5QrCode.isScanning) {
            try { await html5QrCode.stop(); await html5QrCode.clear(); } catch(e) {}
        }
    }
    
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
    // Load Products
    // ============================================
    function loadProducts(page = 1) {
        $('#products-table-body').html(`
            <tr>
                <td colspan="8" class="text-center py-5">
                    <div class="loading-spinner" style="border-top-color: var(--primary);"></div>
                    <span class="me-2 mt-2 d-block">بارکاردکردنی زانیاری...</span>
                </td>
            </tr>
        `);
        
        const requestData = {
            page: page,
            barcode: searchParams.barcode,
            name: searchParams.name,
            company: searchParams.company,
            voucher: searchParams.voucher
        };
        console.log('📤 داواکاری products.list:', requestData);
        
        $.ajax({
            url: '{{ route("products.listt") }}',
            type: 'GET',
            data: requestData,
            success: function(response) {
                console.log('📥 وەڵام:', response);
                
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
                hideLoading('voucher');
            },
            error: function(xhr) {
                console.error('❌ هەڵە:', xhr);
                $('#products-table-body').html(`
                    <tr>
                        <td colspan="8" class="text-center py-5 text-danger">
                            <i class="fas fa-exclamation-circle fa-2x mb-2 d-block"></i>
                            هەڵە لە بارکاردکردنی زانیاریدا
                        </td>
                    </tr>
                `);
                hideLoading('barcode');
                hideLoading('name');
                hideLoading('company');
                hideLoading('voucher');
            }
        });
    }
    
    function renderProductsTable(products) {
        if (!products || products.length === 0) {
            $('#products-table-body').html(`
                <tr>
                    <td colspan="8" class="text-center py-5 text-muted">
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
                imageHtml = `<div style="width:50px;height:50px;background:var(--bg-light);border-radius:8px;display:flex;align-items:center;justify-content:center;"><i class="fas fa-box text-muted"></i></div>`;
            }
            
            let stockBadge = '';
            let stock = product.counter || 0;
            if (stock > 10) {
                stockBadge = `<span class="badge-stock badge-stock-high"><i class="fas fa-check-circle ms-1"></i>${stock}</span>`;
            } else {
                stockBadge = `<span class="badge-stock badge-stock-low"><i class="fas fa-exclamation-triangle ms-1"></i>${stock}</span>`;
            }
            
            const companyName = product.company_name || product.company || 'بێ کۆمپانیا';
            const hasCompany = companyName && companyName !== 'بێ کۆمپانیا';
            const companyBadgeClass = hasCompany ? 'company-badge' : 'company-badge no-company';
            const companyIcon = hasCompany ? 'fa-building' : 'fa-ban';
            
            html += `
                <tr data-product-id="${product.id}">
                    <td data-label="وێنە">${imageHtml}</td>
                    <td data-label="ناوی کاڵا" class="fw-semibold">${escapeHtml(product.name)}</td>
                    <td data-label="کۆمپانیا">
                        <span class="${companyBadgeClass}">
                            <i class="fas ${companyIcon}"></i>
                            ${escapeHtml(companyName)}
                        </span>
                    </td>
                    <td data-label="ناوی فرۆشیار">${escapeHtml(product.voucher_name || '—')}</td>
                    <td data-label="نرخی کڕین">${formatNumberToIQD(product.purchase_price)} د.ع</td>
                    <td data-label="نرخی فرۆشتن">${formatNumberToIQD(product.selling_price)} د.ع</td>
                    <td data-label="بڕی دوکان">${stockBadge}</td>
                    <td data-label="کردار" class="action-buttons">
                        <button class="btn-edit-table edit-product-btn" 
                            data-id="${product.id}" 
                            data-barcode="${escapeHtml(product.barcode)}" 
                            data-name="${escapeHtml(product.name)}" 
                            data-company="${escapeHtml(companyName)}" 
                            data-voucher-name="${escapeHtml(product.voucher_name || '')}"
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
    // Edit Product
    // ============================================
    $(document).on('click', '.edit-product-btn', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        let productId = $(this).data('id');
        let barcode = $(this).data('barcode');
        let name = $(this).data('name');
        let company = $(this).data('company');
        let voucherName = $(this).data('voucher-name');
        let purchasePrice = $(this).data('purchase');
        let sellingPrice = $(this).data('selling');
        let minStock = $(this).data('minstock');
        let imagePath = $(this).data('image');
        
        $('#edit-product-form')[0].reset();
        
        $('#edit-product-id').val(productId);
        $('#edit-old-barcode').val(barcode);
        $('#edit-barcode').val(barcode);
        $('#edit-name').val(name);
        $('#edit-company').val(company);
        $('#edit-voucher-name').val(voucherName || '');
        $('#edit-purchase-price').val(formatNumberToIQD(purchasePrice));
        $('#edit-selling-price').val(formatNumberToIQD(sellingPrice));
        $('#edit-minimum-stock').val(minStock);
        
        $('#modal-file-input').val('');
        $('#modal-captured-image-data').val('');
        $('#modal-image-source-type').val('');
        $('#modal-remove-image-flag').val('false');
        
        if (imagePath && imagePath !== 'null' && imagePath !== '') {
            let imageUrl = getImageUrl(imagePath);
            $('#modal-product-image-preview').attr('src', imageUrl);
            $('#modal-image-preview-section').show();
            $('#modal-default-upload-section').hide();
        } else {
            $('#modal-image-preview-section').hide();
            $('#modal-default-upload-section').show();
        }
        
        $('#edit-barcode-status').text('');
        $('#edit-barcode').removeClass('is-valid is-invalid');
        $('#company-status').text('');
        $('#voucher-status').text('');
        
        updateModalBarcodeStatus(barcode);
        loadSellers();
        loadCompanies();
        
        setTimeout(function() {
            validateVoucherName(true);
            validateCompany(true);
        }, 300);
        
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
    $('#save-product-changes').on('click', function () {
        if (isSubmitting) return;
        
        if (!validateVoucherName()) {
            showAlert('error', 'ناوی فرۆشیار هەڵەیە',
                      'ئەم ناوە پێشتر تۆمار نەکراوە. تکایە ناوێکی دروست هەڵبژێرە.');
            return;
        }

        if (!validateCompany()) {
            showAlert('error', 'ناوی کۆمپانیا هەڵەیە',
                      'ئەم کۆمپانیایە پێشتر تۆمار نەکراوە. تکایە ناوێکی دروست هەڵبژێرە.');
            return;
        }

        let formData = new FormData($('#edit-product-form')[0]);
        formData.append('id', $('#edit-product-id').val());
        formData.append('new_barcode', normalizeToEnglishNumbers($('#edit-barcode').val()));
        formData.append('purchase_price', removeThousandSeparators($('#edit-purchase-price').val()));
        formData.append('selling_price', removeThousandSeparators($('#edit-selling-price').val()));
        formData.append('voucher_name', $('#edit-voucher-name').val());
        formData.append('company', $('#edit-company').val());

        let btn = $(this);
        let originalText = btn.html();
        btn.html('<div class="loading-spinner" style="display:inline-block;width:14px;height:14px;border-width:2px;"></div> تۆمار دەکرێت...').prop('disabled', true);

        isSubmitting = true;

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
                isSubmitting = false;
                validateVoucherName(true);
                validateCompany(true);
            }
        });
    });
    
    // ============================================
    // Delete Product
    // ============================================
    $(document).on('click', '.delete-product-btn', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        deleteProductId = $(this).data('id');
        let productName = $(this).data('name');
        $('#delete-product-name').html(`<strong>${escapeHtml(productName)}</strong>`);
        deleteModal.show();
    });
    
    $('#confirm-delete').on('click', function() {
        if (!deleteProductId) return;
        
        let btn = $(this);
        let originalText = btn.html();
        btn.html('<div class="loading-spinner" style="display:inline-block;width:14px;height:14px;border-width:2px;"></div> سڕینەوە...').prop('disabled', true);
        
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
            error: function(xhr) {
                let msg = 'هەڵەیەک ڕوویدا لە سڕینەوەدا';
                if (xhr.responseJSON?.message) {
                    msg = xhr.responseJSON.message;
                }
                showAlert('error', 'هەڵە', msg);
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
    loadSellers();
    loadCompanies();
    loadProducts();
});
</script>
@endsection