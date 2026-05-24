<!-- Invoice Management Section - بەڕێوەبردنی پسوڵەکانی فرۆشتن -->

<?php $__env->startSection("content"); ?>
<style>
    /* ==================== CSS VARIABLES ==================== */
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
        --text-secondary: #64748b;
        --border-color: #e2e8f0;
        --bg-light: #f8fafc;
        --card-bg: #ffffff;
        --input-bg: #ffffff;
        --table-hover: #dbeafe;
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
        --table-hover: #1e293b;
        background: #0f172a;
    }

    body {
        background: #f1f5f9;
        font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
        color: var(--text);
    }

    /* ==================== CARD STYLES ==================== */
    .form-card {
        background: var(--card-bg);
        border-radius: 1.5rem;
        padding: 1.5rem;
        margin: 1.5rem;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.02);
        border: 1px solid var(--border-color);
    }

    body.dark-mode .form-card {
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3), 0 8px 10px -6px rgba(0, 0, 0, 0.2);
    }

    .section-title {
        font-size: 1.35rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        text-align: center;
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
        background: linear-gradient(90deg, var(--primary), var(--primary-dark));
        border-radius: 3px;
    }

    .section-title i {
        color: var(--primary);
        margin-left: 0.5rem;
    }

    /* ==================== FILTERS SECTION ==================== */
    .invoice-filters {
        background: var(--bg-light);
        padding: 1.25rem;
        border-radius: 1rem;
        margin-bottom: 1.5rem;
        border: 1px solid var(--border-color);
    }

    .grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }
    
    .grid-3 {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
    }

    .block {
        display: block;
        font-size: 0.8rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--text);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .block i {
        margin-left: 0.4rem;
        color: var(--primary);
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid var(--border-color);
        border-radius: 0.75rem;
        font-size: 0.9rem;
        transition: var(--transition-base);
        outline: none;
        background: var(--input-bg);
        color: var(--text);
    }

    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(74, 100, 145, 0.1);
    }

    .form-control::placeholder {
        color: var(--text-secondary);
    }

    .filter-buttons {
        display: flex;
        gap: 0.75rem;
        margin-top: 1rem;
        flex-wrap: wrap;
    }
    
    .time-filter-buttons {
        display: flex;
        gap: 0.75rem;
        margin-top: 1rem;
        flex-wrap: wrap;
        justify-content: center;
    }

    .filter-btn {
        padding: 0.6rem 1.25rem;
        border-radius: 2rem;
        border: none;
        cursor: pointer;
        font-weight: 600;
        transition: var(--transition-base);
        background: var(--border-color);
        color: var(--text);
        font-size: 0.85rem;
    }
    
    .time-filter-btn {
        padding: 0.6rem 1.25rem;
        border-radius: 2rem;
        border: none;
        cursor: pointer;
        font-weight: 600;
        transition: var(--transition-base);
        background: var(--border-color);
        color: var(--text);
        font-size: 0.85rem;
        flex: 1;
        text-align: center;
    }
    
    .time-filter-btn.morning.active {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
        box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3);
    }
    
    .time-filter-btn.afternoon.active {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white;
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
    }
    
    .time-filter-btn.night.active {
        background: linear-gradient(135deg, #1e293b, #0f172a);
        color: white;
        box-shadow: 0 2px 8px rgba(30, 41, 59, 0.3);
    }
    
    .time-filter-btn.all.active {
        background: linear-gradient(135deg, #64748b, #475569);
        color: white;
        box-shadow: 0 2px 8px rgba(100, 116, 139, 0.3);
    }
    
    .time-filter-btn:hover:not(.active) {
        transform: translateY(-2px);
        filter: brightness(0.95);
    }
    
    .filter-btn.active {
        background: var(--primary);
        color: white;
        box-shadow: 0 2px 8px rgba(74, 100, 145, 0.3);
    }

    .filter-btn:hover:not(.active) {
        background: var(--primary);
        color: white;
        transform: translateY(-1px);
        opacity: 0.8;
    }

    /* ==================== TABLE STYLES ==================== */
    .invoice-table-container {
        max-height: 500px;
        overflow-y: auto;
        border-radius: 1rem;
        border: 1px solid var(--border-color);
        background: var(--card-bg);
    }

    .invoice-table-container::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    .invoice-table-container::-webkit-scrollbar-track {
        background: var(--bg-light);
        border-radius: 10px;
    }

    .invoice-table-container::-webkit-scrollbar-thumb {
        background: var(--primary);
        border-radius: 10px;
    }

    .invoice-table {
        width: 100%;
        border-collapse: collapse;
        background: var(--card-bg);
        color: var(--text);
    }

    .invoice-table thead th {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        font-weight: 700;
        padding: 1rem;
        text-align: center;
        position: sticky;
        top: 0;
        z-index: 10;
        font-size: 0.9rem;
    }

    .invoice-table tbody td {
        padding: 0.875rem;
        border-bottom: 1px solid var(--border-color);
        text-align: center;
        vertical-align: middle;
        font-size: 0.9rem;
    }

    .invoice-table tbody tr {
        transition: var(--transition-base);
    }

    .invoice-table tbody tr:hover {
        background-color: var(--table-hover);
        cursor: pointer;
    }
    
    /* Time Badge Styles */
    .time-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 2rem;
        font-size: 0.7rem;
        font-weight: 600;
    }
    
    .time-badge.morning {
        background: #fef3c7;
        color: #d97706;
    }
    
    .time-badge.afternoon {
        background: #dbeafe;
        color: #2563eb;
    }
    
    .time-badge.night {
        background: #e2e8f0;
        color: #1e293b;
    }
    
    body.dark-mode .time-badge.night {
        background: #334155;
        color: #e2e8f0;
    }
    
    .time-badge i {
        margin-right: 0.25rem;
    }

    /* ==================== ACTION BUTTONS ==================== */
    .invoice-actions {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
    }

    .btn-icon {
        padding: 0.5rem;
        border-radius: 0.5rem;
        border: none;
        cursor: pointer;
        transition: var(--transition-base);
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
    }

    .btn-view {
        background: var(--info);
        color: white;
    }

    .btn-return {
        background: var(--return);
        color: white;
    }

    .btn-delete {
        background: var(--danger);
        color: white;
    }

    .btn-view:hover, .btn-return:hover, .btn-delete:hover {
        transform: scale(1.08);
        filter: brightness(1.05);
    }

    .credit-badge-small {
        display: inline-block;
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
        padding: 0.3rem 0.7rem;
        border-radius: 2rem;
        font-size: 0.7rem;
        font-weight: 600;
    }

    .cash-badge {
        display: inline-block;
        background: var(--success);
        color: white;
        padding: 0.3rem 0.7rem;
        border-radius: 2rem;
        font-size: 0.7rem;
        font-weight: 600;
    }

    /* Barcode Search Styles - Live Search */
    .barcode-search-container {
        position: relative;
        width: 100%;
    }
    
    .barcode-clear-btn {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: var(--text-secondary);
        cursor: pointer;
        font-size: 1rem;
        padding: 0;
        display: none;
    }
    
    .barcode-clear-btn:hover {
        color: var(--danger);
    }
    
    .barcode-result-badge {
        background: var(--success);
        color: white;
        padding: 0.3rem 0.8rem;
        border-radius: 2rem;
        font-size: 0.75rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 0.5rem;
    }
    
    .barcode-result-badge i {
        font-size: 0.8rem;
    }
    
    .clear-barcode-btn {
        background: var(--border-color);
        color: var(--text);
        border: none;
        padding: 0.3rem 0.8rem;
        border-radius: 2rem;
        font-size: 0.75rem;
        cursor: pointer;
        transition: var(--transition-base);
        margin-left: 0.5rem;
    }
    
    .clear-barcode-btn:hover {
        background: var(--primary);
        color: white;
    }

    /* Search Wrapper */
    .search-wrapper {
        position: relative;
        width: 100%;
    }
    
    .search-wrapper i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--primary);
        font-size: 1rem;
        z-index: 4;
    }
    
    .search-wrapper .form-control {
        padding-left: 2.5rem;
    }

    /* Live Search Loading Indicator */
    .search-loading {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--primary);
        font-size: 0.8rem;
        display: none;
    }

    /* ==================== MODAL STYLES ==================== */
    .invoice-detail-modal, .delete-confirm-modal, .return-modal {
        display: none;
        position: fixed;
        z-index: 10000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(4px);
    }

    .invoice-detail-content, .return-modal-content {
        background: var(--card-bg);
        margin: 5% auto;
        padding: 0;
        width: 90%;
        max-width: 950px;
        border-radius: 1.5rem;
        animation: slideDownFade 0.3s ease;
        max-height: 85vh;
        overflow-y: auto;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        color: var(--text);
    }

    .return-modal-content {
        max-width: 1000px;
    }

    .invoice-detail-header, .return-modal-header {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        padding: 1.25rem 1.5rem;
        border-radius: 1.5rem 1.5rem 0 0;
        position: sticky;
        top: 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        z-index: 10;
    }

    .return-modal-header {
        background: linear-gradient(135deg, var(--return), #6d28d9);
    }

    .invoice-detail-header h3, .return-modal-header h3 {
        margin: 0;
        font-size: 1.25rem;
    }

    .invoice-detail-header h3 i, .return-modal-header h3 i {
        margin-left: 0.5rem;
    }

    .invoice-detail-body, .return-modal-body {
        padding: 1.5rem;
    }

    .close-detail-modal, .close-return-modal {
        font-size: 1.8rem;
        font-weight: bold;
        cursor: pointer;
        transition: var(--transition-base);
        line-height: 1;
    }

    .close-detail-modal:hover, .close-return-modal:hover {
        color: var(--danger);
        transform: rotate(90deg);
    }

    .detail-items-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1rem;
        border-radius: 0.75rem;
        overflow: hidden;
    }

    .detail-items-table th,
    .detail-items-table td {
        padding: 0.75rem;
        border-bottom: 1px solid var(--border-color);
        text-align: right;
        color: var(--text);
    }

    .detail-items-table th {
        background: var(--bg-light);
        font-weight: 700;
        color: var(--text);
    }

    .detail-items-table tr:last-child td {
        border-bottom: none;
    }

    .item-return-btn {
        background: var(--return);
        color: white;
        border: none;
        padding: 0.4rem 0.8rem;
        border-radius: 0.5rem;
        cursor: pointer;
        font-size: 0.75rem;
        transition: var(--transition-base);
    }

    .item-return-btn:hover {
        transform: scale(1.05);
    }

    /* Return Items Table */
    .return-items-table {
        width: 100%;
        border-collapse: collapse;
        border-radius: 0.75rem;
        overflow: hidden;
    }
    
    .return-items-table th,
    .return-items-table td {
        padding: 0.85rem;
        border-bottom: 1px solid var(--border-color);
        text-align: center;
        vertical-align: middle;
        color: var(--text);
    }
    
    .return-items-table th {
        background: var(--bg-light);
        font-weight: 700;
        color: var(--text);
    }
    
    .return-items-table tbody tr:hover {
        background: var(--table-hover);
    }
    
    .return-qty-input {
        width: 100px;
        padding: 0.5rem;
        border: 2px solid var(--border-color);
        border-radius: 0.5rem;
        text-align: center;
        font-size: 0.9rem;
        transition: var(--transition-base);
        background: var(--input-bg);
        color: var(--text);
    }
    
    .return-qty-input:focus {
        border-color: var(--return);
        outline: none;
    }
    
    .max-qty-label {
        font-size: 0.7rem;
        color: var(--text-secondary);
        display: block;
        margin-top: 0.25rem;
    }
    
    .remove-return-item {
        background: var(--danger);
        color: white;
        border: none;
        padding: 0.4rem 0.8rem;
        border-radius: 0.5rem;
        cursor: pointer;
        font-size: 0.75rem;
        transition: var(--transition-base);
    }
    
    .remove-return-item:hover {
        background: #dc2626;
        transform: scale(1.05);
    }
    
    /* Reason Cards */
    .reason-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin: 1rem 0;
    }
    
    .reason-card {
        background: var(--bg-light);
        border: 2px solid var(--border-color);
        border-radius: 1rem;
        padding: 1rem;
        text-align: center;
        cursor: pointer;
        transition: var(--transition-base);
        color: var(--text);
    }
    
    .reason-card:hover {
        border-color: var(--return);
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .reason-card.selected {
        border-color: var(--return);
        background: linear-gradient(135deg, #f3e8ff, #ede9fe);
    }
    
    body.dark-mode .reason-card.selected {
        background: linear-gradient(135deg, #2d1b4e, #1e1b4e);
    }
    
    .reason-card i {
        font-size: 2rem;
        color: var(--return);
        margin-bottom: 0.5rem;
        display: block;
    }
    
    .reason-card h5 {
        margin: 0.5rem 0;
        font-size: 0.9rem;
        font-weight: 600;
    }
    
    .reason-card p {
        font-size: 0.7rem;
        color: var(--text-secondary);
        margin: 0;
    }
    
    .other-reason-input {
        margin-top: 1rem;
        display: none;
    }
    
    .other-reason-input.show {
        display: block;
        animation: fadeIn 0.3s ease;
    }
    
    .other-reason-input textarea {
        resize: vertical;
        min-height: 80px;
        background: var(--input-bg);
        color: var(--text);
        border-color: var(--border-color);
    }
    
    .selected-reason {
        margin-top: 1rem;
        padding: 0.75rem;
        background: #ede9fe;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: var(--return);
        border-right: 3px solid var(--return);
    }
    
    body.dark-mode .selected-reason {
        background: #2d1b4e;
    }
    
    .selected-reason i {
        font-size: 1.2rem;
    }
    
    /* Invoice Info Card */
    .invoice-info-card {
        background: var(--bg-light);
        padding: 1rem;
        border-radius: 1rem;
        margin-bottom: 1.5rem;
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        border: 1px solid var(--border-color);
    }
    
    .invoice-info-card div {
        flex: 1;
        min-width: 150px;
    }
    
    .invoice-info-card strong {
        color: var(--primary);
        display: block;
        font-size: 0.7rem;
        margin-bottom: 0.25rem;
    }
    
    /* Delete Modal */
    .delete-confirm-content {
        background: var(--card-bg);
        margin: 20% auto;
        padding: 2rem;
        width: 90%;
        max-width: 420px;
        border-radius: 1.5rem;
        text-align: center;
        animation: slideDownFade 0.3s ease;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        color: var(--text);
    }

    .delete-confirm-content i {
        font-size: 3rem;
        color: var(--danger);
        margin-bottom: 1rem;
    }

    .delete-confirm-content h3 {
        margin-bottom: 0.5rem;
        color: var(--text);
    }

    .delete-confirm-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin-top: 1.5rem;
    }

    .confirm-yes {
        background: var(--danger);
        color: white;
        border: none;
        padding: 0.7rem 1.8rem;
        border-radius: 2rem;
        cursor: pointer;
        font-weight: 600;
        transition: var(--transition-base);
    }

    .confirm-no {
        background: var(--border-color);
        color: var(--text);
        border: none;
        padding: 0.7rem 1.8rem;
        border-radius: 2rem;
        cursor: pointer;
        font-weight: 600;
        transition: var(--transition-base);
    }

    .confirm-yes:hover, .confirm-no:hover {
        transform: translateY(-2px);
    }
    
    .confirm-no:hover {
        background: var(--primary);
        color: white;
    }

    /* ==================== PAGINATION ==================== */
    .pagination-container {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 1.5rem;
        flex-wrap: wrap;
    }

    .pagination-btn {
        padding: 0.5rem 1rem;
        min-width: 40px;
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        background: var(--card-bg);
        cursor: pointer;
        transition: var(--transition-base);
        font-weight: 500;
        color: var(--text);
    }

    .pagination-btn.active {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }

    .pagination-btn:hover:not(.active):not(.disabled) {
        background: var(--bg-light);
        transform: translateY(-1px);
        border-color: var(--primary);
    }

    .pagination-btn.disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* ==================== ALERT STYLES ==================== */
    .custom-alert {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        background: var(--card-bg);
        border-radius: 1rem;
        padding: 1rem 1.25rem;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.15);
        display: flex;
        align-items: center;
        gap: 1rem;
        animation: slideInRight 0.3s ease;
        border-right: 4px solid;
        color: var(--text);
    }

    .alert-success {
        border-right-color: var(--success);
    }
    .alert-error {
        border-right-color: var(--danger);
    }
    .alert-warning {
        border-right-color: var(--warning);
    }
    .alert-info {
        border-right-color: var(--info);
    }

    @keyframes slideDownFade {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(50px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ==================== RESPONSIVE ==================== */
    @media (max-width: 768px) {
        .form-card {
            margin: 1rem;
            padding: 1rem;
        }
        .grid-2, .grid-3 {
            grid-template-columns: 1fr;
            gap: 0.75rem;
        }
        .invoice-table thead th,
        .invoice-table tbody td {
            padding: 0.6rem;
            font-size: 0.8rem;
        }
        .btn-icon {
            width: 30px;
            height: 30px;
        }
        .filter-btn, .time-filter-btn {
            padding: 0.4rem 1rem;
            font-size: 0.8rem;
        }
        .reason-cards {
            grid-template-columns: repeat(2, 1fr);
        }
        .return-items-table th,
        .return-items-table td {
            padding: 0.5rem;
            font-size: 0.8rem;
        }
        .return-qty-input {
            width: 70px;
            padding: 0.3rem;
        }
    }
    
    /* Credit Info Styles */
    .credit-info-card {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        padding: 1.25rem;
        border-radius: 1rem;
        margin-top: 1.5rem;
        border-right: 4px solid #f59e0b;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        color: #92400e;
    }
    
    body.dark-mode .credit-info-card {
        background: linear-gradient(135deg, #2d2410 0%, #1e1a0a 100%);
        color: #fbbf24;
    }
    
    .credit-info-title {
        color: #92400e;
        margin-bottom: 1rem;
        font-size: 1.1rem;
        font-weight: bold;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    body.dark-mode .credit-info-title {
        color: #fbbf24;
    }
    
    .credit-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 0.75rem;
    }
    
    .credit-info-item {
        background: white;
        padding: 0.5rem 0.75rem;
        border-radius: 0.5rem;
        font-size: 0.9rem;
        color: #1e293b;
    }
    
    body.dark-mode .credit-info-item {
        background: #1e293b;
        color: #e2e8f0;
    }
    
    .credit-info-item strong {
        color: #92400e;
        display: block;
        font-size: 0.75rem;
        margin-bottom: 0.25rem;
    }
    
    body.dark-mode .credit-info-item strong {
        color: #fbbf24;
    }
    
    .status-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 2rem;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .status-paid {
        background: #10b981;
        color: white;
    }
    
    .status-pending {
        background: #f59e0b;
        color: white;
    }
    
    .status-overdue {
        background: #ef4444;
        color: white;
    }
    
    /* Empty Items Style */
    .empty-items {
        text-align: center;
        padding: 2rem;
        color: var(--text-secondary);
    }
    
    .empty-items i {
        font-size: 2.5rem;
        color: var(--text-secondary);
        margin-bottom: 0.75rem;
        display: block;
    }
    
    .empty-items p {
        margin: 0;
        font-size: 0.9rem;
    }
    
    /* Return Summary */
    .return-summary {
        background: var(--bg-light);
        padding: 1rem;
        border-radius: 0.75rem;
        margin-top: 1rem;
        text-align: center;
        border: 1px solid var(--border-color);
    }
    
    .return-summary h4 {
        margin-bottom: 0.5rem;
        color: var(--return);
    }
    
    .btn-submit-return {
        background: linear-gradient(135deg, var(--return), #6d28d9);
        color: white;
        border: none;
        padding: 0.85rem 1.5rem;
        border-radius: 2rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition-base);
        width: 100%;
        margin-top: 1rem;
        font-size: 1rem;
    }
    
    .btn-submit-return:hover {
        transform: translateY(-2px);
        filter: brightness(1.05);
        box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);
    }
    
    .btn-submit-return:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }
    
    /* Return Reason Section */
    .return-reason-section {
        background: var(--bg-light);
        border-radius: 1rem;
        padding: 1rem;
        margin-bottom: 1.5rem;
        border: 1px solid var(--border-color);
    }
    
    .return-reason-section h4 {
        margin-bottom: 1rem;
        color: var(--text);
        font-size: 1rem;
    }
    
    /* Quantity Display */
    .quantity-display {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.25rem;
    }
    
    .quantity-badge {
        display: inline-block;
        background: var(--primary);
        color: white;
        padding: 0.2rem 0.5rem;
        border-radius: 2rem;
        font-size: 0.7rem;
    }
    
    /* Qty Buttons */
    .qty-btn {
        width: 40px;
        height: 40px;
        border-radius: 0.5rem;
        border: none;
        background: var(--primary);
        color: white;
        font-size: 1.2rem;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .qty-btn:hover:not(:disabled) {
        transform: scale(1.05);
        filter: brightness(1.05);
    }
    
    .qty-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .form-header-custom {
        background: linear-gradient(135deg, var(--secondary), var(--primary-dark));
        border-radius: 24px;
        padding: 20px 16px;
        margin-bottom: 20px;
        text-align: center;
        margin: 25px;
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
        background-color: var(--primary-dark);
    }

    .form-logo-custom i {
        font-size: 2.5rem;
        background: linear-gradient(135deg, var(--primary), var(--accent));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    
    /* Additional dark mode adjustments */
    body.dark-mode .form-control:focus {
        box-shadow: 0 0 0 3px rgba(108, 141, 184, 0.2);
    }
    
    body.dark-mode .invoice-detail-content::-webkit-scrollbar-track,
    body.dark-mode .return-modal-content::-webkit-scrollbar-track {
        background: var(--bg-light);
    }
    
    body.dark-mode select option {
        background: var(--input-bg);
        color: var(--text);
    }
    
    /* HR styles */
    hr {
        border-color: var(--border-color);
    }
    
    /* Text colors in modals */
    .text-muted {
        color: var(--text-secondary) !important;
    }
    
    .small {
        color: var(--text-secondary);
    }
</style>

<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

<div class="card-header form-header-custom text-white text-center py-4">
    <div class="form-logo-custom">
        <i class="fas fa-file-invoice"></i> 
    </div>
    <h1 class="h2 mb-2">بەڕێوەبردنی پسوڵەکانی فرۆشتن</h1>
</div>

<div class="form-card">
    <!-- Filters -->
    <div class="invoice-filters">
        <div class="grid-2">
            <div>
                <label class="block"><i class="fas fa-calendar-alt"></i> لە بەروار</label>
                <input type="date" id="filter-date-from" class="form-control">
            </div>
            <div>
                <label class="block"><i class="fas fa-calendar-alt"></i> بۆ بەروار</label>
                <input type="date" id="filter-date-to" class="form-control">
            </div>
        </div>
        
        <!-- Time Filter Buttons -->
        <div style="margin-top: 1rem;">
            <label class="block"><i class="fas fa-clock"></i> فلتەری کات</label>
            <div class="time-filter-buttons">
                <button class="time-filter-btn all active" data-time="all" onclick="filterByTime('all')">
                    <i class="fas fa-clock"></i> هەموو کاتەکان
                </button>
                <button class="time-filter-btn morning" data-time="morning" onclick="filterByTime('morning')">
                    <i class="fas fa-sun"></i> بەیانی (٦-١٢)
                </button>
                <button class="time-filter-btn afternoon" data-time="afternoon" onclick="filterByTime('afternoon')">
                    <i class="fas fa-cloud-sun"></i> ئێوارە (١٢-٦)
                </button>
                <button class="time-filter-btn night" data-time="night" onclick="filterByTime('night')">
                    <i class="fas fa-moon"></i> شەو (٦-٦)
                </button>
            </div>
        </div>
        
        <!-- Payment Type Filter Buttons -->
        <div style="margin-top: 1rem;">
            <label class="block"><i class="fas fa-tag"></i> فلتەری جۆر</label>
            <div class="filter-buttons">
                <button class="filter-btn active" data-filter="all" onclick="filterInvoices('all')">هەموو</button>
                <button class="filter-btn" data-filter="cash" onclick="filterInvoices('cash')">نەقد</button>
                <button class="filter-btn" data-filter="credit" onclick="filterInvoices('credit')">قەرز</button>
            </div>
        </div>
        
        <!-- Search by Invoice Number -->
        <div class="container mt-3">
            <div class="row g-3">
                <!-- Invoice Number Search -->
                <div class="col-md-6">
                    <label class="form-label fw-bold">
                        <i class="fas fa-search text-primary"></i> گەڕان بە ژمارەی پسوڵە
                    </label>
                    <div class="search-wrapper">
                        <i class="fas fa-hashtag"></i>
                        <input type="text" id="invoice-search-manual" 
                            class="form-control shadow-sm" 
                            placeholder="ژمارەی پسوڵە..." autocomplete="off">
                        <div class="search-loading" id="invoice-search-loading">
                            <i class="fas fa-spinner fa-spin"></i>
                        </div>
                    </div>
                </div>

                <!-- Barcode Search - LIVE SEARCH (NO BUTTON) -->
                <div class="col-md-6">
                    <label class="form-label fw-bold">
                        <i class="fas fa-barcode text-success"></i> گەڕان بە بارکۆد
                    </label>
                    <div class="search-wrapper">
                        <i class="fas fa-barcode"></i>
                        <input type="text" id="barcode-search-input" 
                            class="form-control shadow-sm" 
                            placeholder="بارکۆدی کاڵا..." autocomplete="off">
                        <div class="search-loading" id="barcode-search-loading">
                            <i class="fas fa-spinner fa-spin"></i>
                        </div>
                    </div>
                    <div id="barcode-search-result" class="mt-2 small text-muted"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Invoices Table -->
    <div class="invoice-table-container">
        <table class="invoice-table">
            <thead>
                <tr>
                    <th>ژ. پسوڵە</th>
                    <th>بەروار</th>
                    <th>کات</th>
                    <th>نرخی سەرەکی</th>
                    <th>بڕی داشکان</th>
                    <th>کۆی گشتی</th>
                    <th>جۆر</th>
                    <th>کردار</th>
                </tr>
            </thead>
            <tbody id="invoices-table-body">
                <tr>
                    <td colspan="8" style="text-align: center; padding: 2.5rem;">
                        <i class="fas fa-spinner fa-spin" style="font-size: 1.5rem; color: var(--primary);"></i>
                        <p style="margin-top: 0.5rem; color: var(--text-secondary);">بارکردنی پسوڵەکان...</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="pagination-container" id="pagination-container"></div>
</div>

<!-- Invoice Detail Modal -->
<div id="invoiceDetailModal" class="invoice-detail-modal">
    <div class="invoice-detail-content">
        <div class="invoice-detail-header">
            <h3><i class="fas fa-file-invoice"></i> وردەکاری پسوڵە</h3>
            <span class="close-detail-modal" onclick="closeInvoiceDetailModal()">&times;</span>
        </div>
        <div class="invoice-detail-body" id="invoice-detail-body">
            <div style="text-align: center; padding: 2rem;">
                <i class="fas fa-spinner fa-spin" style="font-size: 1.5rem;"></i>
                <p>بارکردنی وردەکاری...</p>
            </div>
        </div>
    </div>
</div>

<!-- Return Modal with Reason Selection -->
<div id="returnModal" class="return-modal">
    <div class="return-modal-content">
        <div class="return-modal-header">
            <h3><i class="fas fa-undo-alt"></i> گەڕاندنەوەی کاڵا</h3>
            <span class="close-return-modal" onclick="closeReturnModal()">&times;</span>
        </div>
        <div class="return-modal-body" id="return-modal-body">
            <div style="text-align: center; padding: 2rem;">
                <i class="fas fa-spinner fa-spin" style="font-size: 1.5rem;"></i>
                <p>بارکردن...</p>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteConfirmModal" class="delete-confirm-modal">
    <div class="delete-confirm-content">
        <i class="fas fa-exclamation-triangle"></i>
        <h3>دڵنیایت لە سڕینەوەی پسوڵە؟</h3>
        <p id="delete-invoice-number" style="margin: 1rem 0; color: var(--text-secondary);"></p>
        <div class="delete-confirm-buttons">
            <button class="confirm-no" onclick="closeDeleteModal()">پەشیمان بووم</button>
            <button class="confirm-yes" onclick="confirmDeleteInvoice()">بەڵێ، بسڕەوە</button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // ==================== INVOICE MANAGEMENT VARIABLES ====================
    let invoicesData = [];
    let currentPage = 1;
    let itemsPerPage = 10;
    let currentFilter = 'all';
    let currentTimeFilter = 'all';
    let currentBarcodeSearch = '';
    let pendingDeleteId = null;
    let currentReturnInvoice = null;
    let returnItems = [];
    let selectedReturnReason = null;
    let searchTimeout = null;

    // ============================================
    // !!! چارەسەری کێشەی بارکۆد بە هەر زمانێک !!!
    // ============================================

    /**
     * گۆڕینی هەر ژمارەیەکی نا ئینگلیزی (کوردی، فارسی، عەرەبی) بۆ ئینگلیزی
     * @param {string} str - بارکۆدەکە یان هەر نوسینێک
     * @returns {string} - نوسینی پاککراوە بە ژمارەی ئینگلیزی
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
     * چالاککردنی نۆرمالایزکردنی بارکۆد لەسەر فیلدێک
     * @param {string} selector - سلیکتی فیلدەکە
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

    // ==================== HELPER FUNCTIONS ====================
    function formatNumber(num) {
        if (num === null || num === undefined || isNaN(num)) return '0';
        return num.toLocaleString();
    }
    
    function getTimeOfDay(dateString) {
        if (!dateString) return 'unknown';
        const date = new Date(dateString);
        const hours = date.getHours();
        
        if (hours >= 6 && hours < 12) {
            return 'morning';
        } else if (hours >= 12 && hours < 18) {
            return 'afternoon';
        } else {
            return 'night';
        }
    }
    
    function getTimeOfDayText(timeOfDay) {
        const texts = {
            'morning': '<span class="time-badge morning"><i class="fas fa-sun"></i> بەیانی</span>',
            'afternoon': '<span class="time-badge afternoon"><i class="fas fa-cloud-sun"></i> ئێوارە</span>',
            'night': '<span class="time-badge night"><i class="fas fa-moon"></i> شەو</span>'
        };
        return texts[timeOfDay] || '<span class="time-badge">-</span>';
    }
    
    function formatTime(dateString) {
        if (!dateString) return '-';
        const date = new Date(dateString);
        return date.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
    }

    function showAlert(type, message, title = '') {
        const icons = {
            success: 'fa-check-circle',
            error: 'fa-exclamation-circle',
            warning: 'fa-exclamation-triangle',
            info: 'fa-info-circle'
        };
        const colors = {
            success: '#10b981',
            error: '#ef4444',
            warning: '#f59e0b',
            info: '#3b82f6'
        };
        
        const alertHtml = `
            <div class="custom-alert alert-${type}" style="border-right-color: ${colors[type]};">
                <i class="fas ${icons[type]}" style="font-size: 1.25rem; color: ${colors[type]};"></i>
                <div>
                    <strong>${title || (type === 'success' ? 'سەرکەوتوو' : type === 'error' ? 'هەڵە' : 'ئاگاداری')}</strong>
                    <div style="font-size: 0.85rem; margin-top: 0.2rem;">${message}</div>
                </div>
            </div>
        `;
        $('body').append(alertHtml);
        setTimeout(() => {
            $('.custom-alert').last().fadeOut(300, function() { $(this).remove(); });
        }, 3500);
    }

    function escapeHtml(text) {
        if (text === null || text === undefined) return '';
        if (typeof text !== 'string') return String(text);
        return text.replace(/[&<>]/g, function(m) {
            if (m === '&') return '&amp;';
            if (m === '<') return '&lt;';
            if (m === '>') return '&gt;';
            return m;
        });
    }
    
    function getStatusBadge(status) {
        if (!status) return '<span class="status-badge status-pending">چاوەڕوان</span>';
        switch(String(status).toLowerCase()) {
            case 'paid':
            case 'completed':
            case 'پاردراوە':
                return '<span class="status-badge status-paid">پاردراوە</span>';
            case 'overdue':
            case 'دەرچووە':
                return '<span class="status-badge status-overdue">دەرچووە</span>';
            default:
                return '<span class="status-badge status-pending">چاوەڕوان</span>';
        }
    }

    // ==================== LOAD INVOICES ====================
    function loadInvoices() {
        let fromDate = $('#filter-date-from').val();
        let toDate = $('#filter-date-to').val();
        let search = $('#invoice-search-manual').val();
        // Normalize barcode before sending
        let barcode = currentBarcodeSearch ? normalizeToEnglishNumbers(currentBarcodeSearch) : '';

        $.ajax({
            url: '/get-invoices',
            type: 'POST',
            data: {
                filter: currentFilter,
                time_filter: currentTimeFilter,
                from_date: fromDate,
                to_date: toDate,
                search: search,
                barcode: barcode,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                $('#invoices-table-body').html('<tr><td colspan="8" style="text-align: center; padding: 2rem;"><i class="fas fa-spinner fa-spin"></i> بارکردن...</td></tr>');
            },
            success: function(response) {
                console.log(response);
                if (response.success) {
                    invoicesData = response.invoices;
                    renderInvoicesTable();
                    renderPagination();
                    
                    // Update barcode search result display
                    if (currentBarcodeSearch) {
                        let resultHtml = `<div class="barcode-result-badge">
                            <i class="fas fa-barcode"></i> گەڕان بە بارکۆد: "${escapeHtml(currentBarcodeSearch)}"
                            <span class="clear-barcode-btn" onclick="clearBarcodeSearch()">
                                <i class="fas fa-times"></i> پاککردنەوە
                            </span>
                        </div>`;
                        if (invoicesData.length === 0) {
                            resultHtml += `<div style="margin-top: 0.5rem; color: var(--danger); font-size: 0.85rem;">
                                <i class="fas fa-exclamation-circle"></i> هیچ پسوڵەیەک بۆ ئەم بارکۆدە نەدۆزرایەوە
                            </div>`;
                        } else {
                            resultHtml += `<div style="margin-top: 0.5rem; color: var(--success); font-size: 0.85rem;">
                                <i class="fas fa-check-circle"></i> ${invoicesData.length} پسوڵە دۆزرایەوە
                            </div>`;
                        }
                        $('#barcode-search-result').html(resultHtml);
                    } else {
                        $('#barcode-search-result').empty();
                    }
                } else {
                    $('#invoices-table-body').html('<tr><td colspan="8" style="text-align: center; padding: 2rem;">هیچ پسوڵەیەک نەدۆزرایەوە</td></tr>');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error loading invoices:', xhr.responseText);
                $('#invoices-table-body').html('<tr><td colspan="8" style="text-align: center; padding: 2rem;">هەڵەیەک ڕوویدا لە کاتی بارکردندا</td></tr>');
                showAlert('error', 'Failed to load invoices. Please try again.');
            }
        });
    }

    // ==================== BARCODE SEARCH FUNCTIONS - LIVE SEARCH ====================
    function handleBarcodeLiveSearch() {
        const barcode = $('#barcode-search-input').val().trim();
        // Normalize barcode before searching
        currentBarcodeSearch = normalizeToEnglishNumbers(barcode);
        $('#barcode-search-loading').show();
        currentPage = 1;
        loadInvoices();
        setTimeout(() => {
            $('#barcode-search-loading').hide();
        }, 500);
    }
    
    function clearBarcodeSearch() {
        $('#barcode-search-input').val('');
        currentBarcodeSearch = '';
        currentPage = 1;
        $('#barcode-search-result').empty();
        loadInvoices();
    }
    
    // Handle Invoice Number Live Search
    function handleInvoiceLiveSearch() {
        $('#invoice-search-loading').show();
        currentPage = 1;
        loadInvoices();
        setTimeout(() => {
            $('#invoice-search-loading').hide();
        }, 500);
    }

    // ==================== RENDER FUNCTIONS ====================
    function renderInvoicesTable() {
        const start = (currentPage - 1) * itemsPerPage;
        const pageInvoices = invoicesData.slice(start, start + itemsPerPage);

        if (pageInvoices.length === 0) {
            $('#invoices-table-body').html('<tr><td colspan="8" style="text-align: center; padding: 2rem;">هیچ پسوڵەیەک نەدۆزرایەوە</td></tr>');
            return;
        }

        let html = '';
        pageInvoices.forEach((invoice, index) => {
            const date = new Date(invoice.created_at).toLocaleDateString('en-US');
            const time = formatTime(invoice.created_at);
            const timeOfDay = getTimeOfDay(invoice.created_at);
            const timeBadge = getTimeOfDayText(timeOfDay);
            const isCredit = invoice.is_credit || false;
            const typeBadge = isCredit ? 
                '<span class="credit-badge-small"><i class="fas fa-hand-holding-usd"></i> قەرز</span>' : 
                '<span class="cash-badge"><i class="fas fa-money-bill-wave"></i> نەقد</span>';
            
            html += `
                <tr onclick="viewInvoiceDetail(${invoice.id})">  
                    <td><strong>${escapeHtml(invoice.invoice_number)}</strong></td>
                    <td>${date}</td>
                    <td>${time}<br>${timeBadge}</td>
                    <td>${formatNumber(invoice.subtotal)} د.ع</td>
                    <td>${formatNumber(invoice.discount)} د.ع</td>
                    <td>${formatNumber(invoice.total)} د.ع</td>
                    <td>${typeBadge}</td>
                    <td class="invoice-actions" onclick="event.stopPropagation()">
                        <button class="btn-icon btn-view" onclick="viewInvoiceDetail(${invoice.id})" title="بینین">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn-icon btn-delete" onclick="openDeleteModal(${invoice.id}, '${escapeHtml(invoice.invoice_number)}')" title="سڕینەوە">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
        });
        $('#invoices-table-body').html(html);
    }

    function renderPagination() {
        const totalPages = Math.ceil(invoicesData.length / itemsPerPage);
        if (totalPages <= 1) {
            $('#pagination-container').empty();
            return;
        }

        let html = '';
        html += `<button class="pagination-btn ${currentPage === 1 ? 'disabled' : ''}" onclick="changePage(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''}>&raquo; پێشتر</button>`;
        
        for (let i = 1; i <= totalPages; i++) {
            if (i === 1 || i === totalPages || (i >= currentPage - 2 && i <= currentPage + 2)) {
                html += `<button class="pagination-btn ${currentPage === i ? 'active' : ''}" onclick="changePage(${i})">${i}</button>`;
            } else if (i === currentPage - 3 || i === currentPage + 3) {
                html += `<span style="padding: 0 0.25rem;">...</span>`;
            }
        }
        
        html += `<button class="pagination-btn ${currentPage === totalPages ? 'disabled' : ''}" onclick="changePage(${currentPage + 1})" ${currentPage === totalPages ? 'disabled' : ''}>دواتر &laquo;</button>`;
        $('#pagination-container').html(html);
    }

    function changePage(page) {
        const totalPages = Math.ceil(invoicesData.length / itemsPerPage);
        if (page < 1 || page > totalPages) return;
        currentPage = page;
        renderInvoicesTable();
        renderPagination();
    }

    // ==================== FILTER FUNCTIONS ====================
    function filterInvoices(filter) {
        currentFilter = filter;
        currentPage = 1;
        $('.filter-btn').removeClass('active');
        $(`.filter-btn[data-filter="${filter}"]`).addClass('active');
        loadInvoices();
    }
    
    function filterByTime(timeFilter) {
        currentTimeFilter = timeFilter;
        currentPage = 1;
        $('.time-filter-btn').removeClass('active');
        $(`.time-filter-btn[data-time="${timeFilter}"]`).addClass('active');
        loadInvoices();
    }

    // ==================== VIEW INVOICE DETAIL ====================
    function viewInvoiceDetail(invoiceId) {
        $.ajax({
            url: '/invoice/' + invoiceId,
            type: 'GET',
            success: function(response) {
                console.log(response);
                if (response.success) {
                    displayInvoiceDetail(response.invoice);
                } else {
                    showAlert('error', 'پسوڵە نەدۆزرایەوە');
                }
            },
            error: function(xhr) {
                console.log(xhr);
                showAlert('error', 'هەڵەیەک ڕوویدا لە کاتی بارکردنی وردەکاری');
            }
        });
    }
    
    function displayInvoiceDetail(invoice) {
        const isCredit = invoice.is_credit || false;
        const date = new Date(invoice.created_at).toLocaleString('en-US');
        const timeOfDay = getTimeOfDay(invoice.created_at);
        const timeBadge = getTimeOfDayText(timeOfDay);
        
        let itemsHtml = `
            <table class="detail-items-table">
                <thead>
                    <tr>
                        <th>ناوی کاڵا</th>
                        <th>بڕ</th>
                        <th>نرخ</th>
                        <th>کۆی گشتی</th>
                        <th>کردار</th>
                    </tr>
                </thead>
                <tbody>
        `;
        
        if (invoice.items && Array.isArray(invoice.items) && invoice.items.length > 0) {
            invoice.items.forEach((item, idx) => {
                itemsHtml += `
                    <tr id="item-row-${item.id || idx}">
                        <td>${escapeHtml(item.name) || '-'}</td>
                        <td class="item-quantity-${item.id || idx}">${item.quantity_sold || 0}</td>
                        <td>${formatNumber(item.selling_price)}</td>
                        <td class="item-total-${item.id || idx}">${formatNumber(item.total)}</td>
                        <td>
                            <button class="item-return-btn" onclick="openReturnItemModal(${invoice.id}, ${item.id || idx}, '${escapeHtml(item.name)}', ${item.quantity_sold || 0}, ${item.selling_price || 0})">
                                <i class="fas fa-undo-alt"></i> گەڕاندنەوە
                            </button>
                        </td>
                    </tr>
                `;
            });
        } else {
            itemsHtml += `
                <tr>
                    <td colspan="7" class="empty-items">
                        <i class="fas fa-box-open"></i>
                        <p>هیچ کاڵایەک لەم پسوڵەیەدا نییە</p>
                    </td>
                </tr>
            `;
        }
        itemsHtml += '</tbody></table>';
        
        let creditHtml = '';
        if (isCredit && invoice.credit_info) {
            const creditInfo = invoice.credit_info;
            creditHtml = `
                <div class="credit-info-card">
                    <div class="credit-info-title">
                        <i class="fas fa-hand-holding-usd"></i> زانیاری قەرز
                    </div>
                    <div class="credit-info-grid">
                        <div class="credit-info-item">
                            <strong>ناوی کڕیار</strong>
                            ${escapeHtml(creditInfo.customer_name) || '-'}
                        </div>
                        <div class="credit-info-item">
                            <strong>ژمارەی مۆبایل</strong>
                            ${escapeHtml(creditInfo.phone_number) || '-'}
                        </div>
                        <div class="credit-info-item">
                            <strong>ناونیشان</strong>
                            ${escapeHtml(creditInfo.address) || '-'}
                        </div>
                        <div class="credit-info-item">
                            <strong>دراو</strong>
                            ${escapeHtml(creditInfo.currency) || 'IQD'}
                        </div>
                        <div class="credit-info-item">
                            <strong>ماوە</strong>
                            ${escapeHtml(creditInfo.period) || '-'}
                        </div>
                        <div class="credit-info-item">
                            <strong>کاتی گەڕانەوە</strong>
                            ${creditInfo.time_to_return || '-'}
                        </div>
                        <div class="credit-info-item">
                            <strong>دۆخ</strong>
                            ${getStatusBadge(creditInfo.status)}
                        </div>
                        <div class="credit-info-item">
                            <strong>بڕی قەرز</strong>
                            ${formatNumber(creditInfo.loan_total || invoice.total)} د.ع
                        </div>
                    </div>
                </div>
            `;
        }
        
        const html = `
            <div style="margin-bottom: 1.5rem;">
                <div style="display: flex; justify-content: space-between; flex-wrap: wrap; gap: 1rem; background: var(--bg-light); padding: 1rem; border-radius: 1rem;">
                    <div><strong><i class="fas fa-hashtag"></i> ژمارەی پسوڵە:</strong> ${escapeHtml(invoice.invoice_number)}</div>
                    <div><strong><i class="fas fa-calendar"></i> بەروار:</strong> ${date}</div>
                    <div><strong><i class="fas fa-clock"></i> کات:</strong> ${formatTime(invoice.created_at)} ${timeBadge}</div>
                    <div><strong><i class="fas fa-tag"></i> جۆر:</strong> ${isCredit ? '<span style="color: #f59e0b;">قەرز</span>' : '<span style="color: #10b981;">نەقد</span>'}</div>
                </div>
                <div style="display: flex; justify-content: space-between; margin-top: 1rem; flex-wrap: wrap; gap: 1rem; background: var(--bg-light); padding: 1rem; border-radius: 1rem;">
                    <div><strong>پێش داشکان:</strong> ${formatNumber(invoice.subtotal)} د.ع</div>
                    <div><strong>داشکاندن:</strong> ${formatNumber(invoice.discount)} د.ع</div>
                    <div><strong><i class="fas fa-money-bill-wave"></i> کۆی گشتی:</strong> <span style="color: var(--success); font-weight: bold;">${formatNumber(invoice.total)} د.ع</span></div>
                </div>
            </div>
            <hr style="margin: 1rem 0;">
            <h4 style="margin-bottom: 1rem;"><i class="fas fa-boxes"></i> کاڵاکان</h4>
            ${itemsHtml}
            ${creditHtml}
        `;
        
        $('#invoice-detail-body').html(html);
        $('#invoiceDetailModal').fadeIn(200);
    }

    // ==================== DELETE FUNCTIONS ====================
    function openDeleteModal(invoiceId, invoiceNumber) {
        pendingDeleteId = invoiceId;
        $('#delete-invoice-number').text(`پسوڵە ژمارە: ${invoiceNumber}`);
        $('#deleteConfirmModal').fadeIn(200);
    }

    function closeDeleteModal() {
        pendingDeleteId = null;
        $('#deleteConfirmModal').fadeOut(200);
    }

    function confirmDeleteInvoice() {
        if (!pendingDeleteId) return;
        
        $.ajax({
            url: '/returns/delete-invoice',
            type: 'POST',
            data: { 
                invoice_id: pendingDeleteId, 
                _token: $('meta[name="csrf-token"]').attr('content') 
            },
            beforeSend: function() {
                $('.confirm-yes').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> سڕینەوە...');
            },
            success: function(response) {
                if (response.success) {
                    showAlert('success', response.message, 'سڕدرایەوە');
                    loadInvoices();
                    closeDeleteModal();
                } else {
                    showAlert('error', response.message || 'هەڵەیەک ڕوویدا');
                }
            },
            error: function(xhr) {
                let errorMsg = 'هەڵەیەک ڕوویدا لە کاتی سڕینەوە';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                showAlert('error', errorMsg);
            },
            complete: function() {
                $('.confirm-yes').prop('disabled', false).html('بەڵێ، بسڕەوە');
            }
        });
    }

    // ==================== RETURN FUNCTIONS ====================
    function openReturnItemModal(invoiceId, itemId, itemName, maxQuantity, price) {
        const modalHtml = `
            <div id="singleReturnModal" class="return-modal" style="display: block; z-index: 10001;">
                <div class="return-modal-content" style="max-width: 500px;">
                    <div class="return-modal-header" style="background: linear-gradient(135deg, var(--return), #6d28d9);">
                        <h3><i class="fas fa-undo-alt"></i> گەڕاندنەوەی کاڵا</h3>
                        <span class="close-return-modal" onclick="closeSingleReturnModal()">&times;</span>
                    </div>
                    <div class="return-modal-body">
                        <div class="invoice-info-card" style="margin-bottom: 1.5rem;">
                            <div>
                                <strong><i class="fas fa-box"></i> ناوی کاڵا</strong>
                                ${escapeHtml(itemName)}
                            </div>
                            <div>
                                <strong><i class="fas fa-dollar-sign"></i> نرخ</strong>
                                ${formatNumber(price)} د.ع
                            </div>
                            <div>
                                <strong><i class="fas fa-cubes"></i> بەردەست</strong>
                                ${maxQuantity}
                            </div>
                        </div>
                        
                        <div style="margin-bottom: 1.5rem;">
                            <label class="block"><i class="fas fa-sort-numeric-up"></i> بڕی گەڕاندنەوە</label>
                            <div style="display: flex; align-items: center; gap: 0.5rem; background: var(--bg-light); padding: 0.5rem; border-radius: 0.75rem; border: 2px solid var(--border-color);">
                                <button type="button" id="qty-decrease" class="qty-btn">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" id="single-return-qty" class="form-control" min="1" max="${maxQuantity}" value="${maxQuantity}" step="1" style="text-align: center; font-size: 1.2rem; flex: 1; margin: 0;">
                                <button type="button" id="qty-increase" class="qty-btn">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin-top: 0.5rem;">
                                <span style="font-size: 0.8rem; color: var(--text-secondary);">کەمترین: 1</span>
                                <span style="font-size: 0.8rem; color: var(--text-secondary);">زۆرترین: ${maxQuantity}</span>
                            </div>
                        </div>
                        
                        <div class="return-reason-section" style="margin-bottom: 1.5rem;">
                            <h4><i class="fas fa-question-circle"></i> هۆکاری گەڕاندنەوە</h4>
                            <div class="reason-cards" id="single-reason-cards">
                                <div class="reason-card" data-reason="damaged" onclick="selectSingleReturnReason('damaged', 'کاڵا شکاوە یان زیانی پێگەیشتووە')">
                                    <i class="fas fa-tools"></i>
                                    <h5>شکاوە / زیان پێگەیشتووە</h5>
                                    <p>کاڵا شکاوە یان زیانی پێگەیشتووە</p>
                                </div>
                                <div class="reason-card" data-reason="defective" onclick="selectSingleReturnReason('defective', 'کاڵا تێکچووە و کار ناکات')">
                                    <i class="fas fa-microchip"></i>
                                    <h5>تێکچوون</h5>
                                    <p>کاڵا تێکچووە و کار ناکات</p>
                                </div>
                                <div class="reason-card" data-reason="exchange" onclick="selectSingleReturnReason('exchange', 'گۆڕینی کاڵا بە کاڵایەکی تر')">
                                    <i class="fas fa-exchange-alt"></i>
                                    <h5>گۆڕین</h5>
                                    <p>گۆڕینی کاڵا بە کاڵایەکی تر</p>
                                </div>
                                <div class="reason-card" data-reason="other" onclick="selectSingleReturnReason('other', 'هۆکاری تر')">
                                    <i class="fas fa-ellipsis-h"></i>
                                    <h5>شتی تر</h5>
                                    <p>هۆکاری تر</p>
                                </div>
                            </div>
                            <div id="single-other-reason-container" class="other-reason-input">
                                <label class="block"><i class="fas fa-pen"></i> هۆکاری تر:</label>
                                <textarea id="single-other-reason-text" class="form-control" rows="2" placeholder="تکایە هۆکاری گەڕاندنەوە بە وردی بنووسە..."></textarea>
                            </div>
                            <div id="single-selected-reason-display" class="selected-reason" style="display: none;">
                                <i class="fas fa-check-circle"></i>
                                <span id="single-selected-reason-text"></span>
                            </div>
                        </div>
                        
                        <div class="return-summary" style="margin-bottom: 1rem;">
                            <h4><i class="fas fa-chart-line"></i> پوختە</h4>
                            <p style="font-size: 1.2rem;">بڕی گەڕاندنەوە: <strong id="single-return-total" style="color: var(--return); font-size: 1.4rem;">${formatNumber(maxQuantity * price)}</strong> د.ع</p>
                        </div>
                        
                        <div style="display: flex; gap: 1rem;">
                            <button class="btn-submit-return" onclick="submitSingleItemReturn(${invoiceId}, ${itemId}, '${escapeHtml(itemName)}', ${maxQuantity}, ${price})" id="single-submit-btn" style="flex: 1;">
                                <i class="fas fa-check-circle"></i> پشتڕاستکردنەوەی گەڕاندنەوە
                            </button>
                            <button class="btn-submit-return" onclick="closeSingleReturnModal()" style="background: #64748b; flex: 0.3;">
                                <i class="fas fa-times"></i> داخستن
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        $('#singleReturnModal').remove();
        $('body').append(modalHtml);
        
        window.singleReturnData = {
            invoiceId: invoiceId,
            itemId: itemId,
            itemName: itemName,
            maxQuantity: maxQuantity,
            price: price,
            selectedReason: null
        };
        
        const qtyInput = $('#single-return-qty');
        const decreaseBtn = $('#qty-decrease');
        const increaseBtn = $('#qty-increase');
        const maxQty = maxQuantity;
        
        function updateQuantity(newQty) {
            let qty = newQty;
            if (qty > maxQty) qty = maxQty;
            if (qty < 1) qty = 1;
            if (isNaN(qty)) qty = 1;
            
            qtyInput.val(qty);
            const total = qty * price;
            $('#single-return-total').text(formatNumber(total));
            
            decreaseBtn.prop('disabled', qty <= 1);
            increaseBtn.prop('disabled', qty >= maxQty);
            
            if (qty <= 1) {
                decreaseBtn.css('opacity', '0.5').css('cursor', 'not-allowed');
            } else {
                decreaseBtn.css('opacity', '1').css('cursor', 'pointer');
            }
            
            if (qty >= maxQty) {
                increaseBtn.css('opacity', '0.5').css('cursor', 'not-allowed');
            } else {
                increaseBtn.css('opacity', '1').css('cursor', 'pointer');
            }
            
            checkSingleSubmitButtonStatus();
        }
        
        decreaseBtn.off('click').on('click', function() {
            let currentVal = parseInt(qtyInput.val()) || 1;
            if (currentVal > 1) {
                updateQuantity(currentVal - 1);
            }
        });
        
        increaseBtn.off('click').on('click', function() {
            let currentVal = parseInt(qtyInput.val()) || 1;
            if (currentVal < maxQty) {
                updateQuantity(currentVal + 1);
            }
        });
        
        qtyInput.off('input').on('input', function() {
            let val = parseInt($(this).val());
            if (isNaN(val)) val = 1;
            updateQuantity(val);
        });
        
        updateQuantity(maxQty);
        
        $('#single-other-reason-text').off('input').on('input', function() {
            checkSingleSubmitButtonStatus();
        });
        
        checkSingleSubmitButtonStatus();
    }
    
    function selectSingleReturnReason(reasonCode, reasonText) {
        window.singleReturnData.selectedReason = {
            code: reasonCode,
            text: reasonText
        };
        
        $('#single-reason-cards .reason-card').removeClass('selected');
        $(`#single-reason-cards .reason-card[data-reason="${reasonCode}"]`).addClass('selected');
        
        if (reasonCode === 'other') {
            $('#single-other-reason-container').addClass('show');
            $('#single-selected-reason-display').hide();
        } else {
            $('#single-other-reason-container').removeClass('show');
            $('#single-selected-reason-display').show();
            $('#single-selected-reason-text').text(reasonText);
        }
        
        checkSingleSubmitButtonStatus();
    }
    
    function getSingleSelectedReasonText() {
        if (!window.singleReturnData.selectedReason) return null;
        if (window.singleReturnData.selectedReason.code === 'other') {
            const otherText = $('#single-other-reason-text').val().trim();
            return otherText || window.singleReturnData.selectedReason.text;
        }
        return window.singleReturnData.selectedReason.text;
    }
    
    function checkSingleSubmitButtonStatus() {
        const qty = parseInt($('#single-return-qty').val()) || 0;
        const hasItems = qty > 0;
        const hasReason = window.singleReturnData.selectedReason !== null;
        const hasOtherText = window.singleReturnData.selectedReason?.code === 'other' ? 
            $('#single-other-reason-text').val().trim().length > 0 : true;
        
        if (hasItems && hasReason && hasOtherText) {
            $('#single-submit-btn').prop('disabled', false).css('opacity', '1');
        } else {
            $('#single-submit-btn').prop('disabled', true).css('opacity', '0.6');
        }
    }
    
    function submitSingleItemReturn(invoiceId, itemId, itemName, maxQuantity, price) {
        const qty = parseInt($('#single-return-qty').val()) || 0;
        
        if (qty <= 0) {
            showAlert('warning', 'تکایە بڕی گەڕاندنەوە دیاری بکە');
            return;
        }
        
        if (qty > maxQuantity) {
            showAlert('error', `بڕی گەڕاندنەوە نابێت لە ${maxQuantity} زیاتر بێت`);
            return;
        }
        
        const reasonText = getSingleSelectedReasonText();
        if (!reasonText) {
            showAlert('warning', 'تکایە هۆکاری گەڕاندنەوە دیاری بکە');
            return;
        }
        
        const totalReturn = qty * price;
        
        $.ajax({
            url: '/return-item-store',
            type: 'POST',
            data: {
                invoice_id: invoiceId,
                items: [{
                    item_id: itemId,
                    quantity: qty,
                    price: price,
                    total: totalReturn
                }],
                total_return: totalReturn,
                return_reason: reasonText,
                return_reason_code: window.singleReturnData.selectedReason?.code || 'other',
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                $('#single-submit-btn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> جێبەجێکردن...');
            },
            success: function(response) {
                console.log(response);
                if (response.success) {
                    closeSingleReturnModal();
                    closeInvoiceDetailModal();
                    showAlert('success', response.message, 'گەڕاندنەوە سەرکەوتوو بوو');
                    loadInvoices();
                } else {
                    showAlert('error', response.message || 'هەڵەیەک ڕوویدا');
                    $('#single-submit-btn').prop('disabled', false).html('<i class="fas fa-check-circle"></i> پشتڕاستکردنەوەی گەڕاندنەوە');
                }
            },
            error: function(xhr) {
                let errorMsg = 'هەڵەیەک ڕوویدا لە کاتی گەڕاندنەوە';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                showAlert('error', errorMsg);
                $('#single-submit-btn').prop('disabled', false).html('<i class="fas fa-check-circle"></i> پشتڕاستکردنەوەی گەڕاندنەوە');
            }
        });
    }
    
    function closeSingleReturnModal() {
        $('#singleReturnModal').remove();
        window.singleReturnData = null;
    }
    
    function closeReturnModal() {
        currentReturnInvoice = null;
        returnItems = [];
        selectedReturnReason = null;
        $('#returnModal').fadeOut(200);
    }

    // ==================== MODAL FUNCTIONS ====================
    function closeInvoiceDetailModal() {
        $('#invoiceDetailModal').fadeOut(200);
    }

    // ==================== EVENT HANDLERS ====================
    $(document).ready(function() {
        // Enable barcode normalization for both search fields
        enableBarcodeNormalization('#barcode-search-input');
        enableBarcodeNormalization('#invoice-search-manual');
        
        loadInvoices();
        
        // Date filter change
        $('#filter-date-from, #filter-date-to').on('change', function() {
            currentPage = 1;
            loadInvoices();
        });
        
        // Live search for invoice number - on input (no button)
        $('#invoice-search-manual').on('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                handleInvoiceLiveSearch();
            }, 300);
        });
        
        // Live search for barcode - on input (no button)
        $('#barcode-search-input').on('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                handleBarcodeLiveSearch();
            }, 300);
        });
        
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape') {
                closeInvoiceDetailModal();
                closeDeleteModal();
                closeReturnModal();
                closeSingleReturnModal();
            }
        });
        
        $(window).on('click', function(e) {
            if ($(e.target).is('#invoiceDetailModal')) {
                closeInvoiceDetailModal();
            }
            if ($(e.target).is('#deleteConfirmModal')) {
                closeDeleteModal();
            }
            if ($(e.target).is('#returnModal')) {
                closeReturnModal();
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.navigation", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamnp64\www\mobileHardy\resources\views/items/delete-invoice.blade.php ENDPATH**/ ?>