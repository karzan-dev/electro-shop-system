<?php $__env->startSection('content'); ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(config('app.name', 'Laravel')); ?> - گەڕاندنەوەی کاڵا</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        /* ==================== VARIABLES & RESET ==================== */
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
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1);
            --transition-base: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .sales-container {
            padding: 1.5rem;
            max-width: 1600px;
            margin: 0 auto;
        }

        @media (min-width: 768px) {
            .sales-container {
                padding: 2rem;
            }
        }

        /* ==================== UTILITY CLASSES ==================== */
        .flex {
            display: flex;
        }

        .flex-center {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        @media (min-width: 1024px) {
            .grid-2 {
                grid-template-columns: 2.5fr 1fr;
            }
        }

        /* ==================== CARD COMPONENTS ==================== */
        .form-card {
            background: white;
            border-radius: 1.5rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--shadow-lg);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: var(--transition-base);
        }

        .form-card:hover {
            box-shadow: var(--shadow-xl);
        }

        .form-header-custom {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 1.5rem !important;
            padding: 2rem !important;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-xl);
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
            box-shadow: var(--shadow-lg);
        }

        .form-logo-custom i {
            font-size: 2.5rem;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* ==================== SECTION TITLES ==================== */
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
            width: 100px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            border-radius: 2px;
        }

        /* ==================== FORM ELEMENTS ==================== */
        label.block {
            display: block;
            font-size: 0.85rem;
            margin-bottom: 0.5rem;
            color: var(--text);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        input[type="text"],
        input[type="number"],
        input[type="search"],
        select {
            width: 100%;
            border: 2px solid var(--border-color);
            border-radius: 0.75rem;
            padding: 0.875rem 1rem;
            font-size: 0.95rem;
            transition: var(--transition-base);
            outline: none;
        }

        input:focus, select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(74, 100, 145, 0.1);
        }

        /* Specialized Input Styles */
        .barcode-input {
            background: linear-gradient(135deg, #064e3b, #047857);
            color: #f0fdf4;
            border: 2px solid #065f46;
            font-weight: 600;
        }

        .barcode-input::placeholder {
            color: #a7f3d0;
            font-style: italic;
        }

        .name-input {
            background: linear-gradient(135deg, #1e40af, #1d4ed8);
            color: #faf8f8;
            border: 2px solid #1e3a8a;
            font-weight: 600;
        }

        .name-input::placeholder {
            color: #bfdbfe;
            font-style: italic;
        }

        .invoice-input {
            background: linear-gradient(135deg, #065f46, #047857);
            color: white;
            border: 2px solid #064e3b;
            font-weight: 600;
        }

        .invoice-input::placeholder {
            color: #a7f3d0;
            font-style: italic;
        }

        /* ==================== BUTTON STYLES ==================== */
        #btn {
            border: none;
            color: white;
            font-weight: 700;
            padding: 1rem 1.5rem;
            border-radius: 0.75rem;
            cursor: pointer;
            transition: var(--transition-base);
            width: 100%;
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            overflow: hidden;
        }

        #btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        #btn:hover::before {
            left: 100%;
        }

        #btn:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-xl);
        }

        #btn:active {
            transform: translateY(0);
        }

        #btn-success {
            background: linear-gradient(135deg, var(--success), #059669);
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
        }

        #btn-danger {
            background: linear-gradient(135deg, var(--danger), #dc2626);
            box-shadow: 0 8px 20px rgba(239, 68, 68, 0.4);
        }

        #btn-info {
            background: linear-gradient(135deg, var(--info), #2563eb);
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4);
        }

        /* ==================== TABLE STYLES ==================== */
        .table-container {
            max-height: 400px;
            overflow-y: auto;
            border-radius: 1rem;
            border: 2px solid var(--border-color);
            margin-top: 1rem;
        }

        .table-container::-webkit-scrollbar {
            width: 10px;
        }

        .table-container::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 5px;
        }

        .table-container::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 5px;
        }

        .sales-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: white;
            font-size: 0.9rem;
        }

        @media (min-width: 768px) {
            .sales-table {
                font-size: 1rem;
            }
        }

        .sales-table thead th {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            font-weight: 700;
            padding: 1rem 0.75rem;
            text-align: right;
            white-space: nowrap;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .sales-table tbody td {
            padding: 0.875rem 0.75rem;
            border-bottom: 1px solid var(--border-color);
            text-align: right;
            vertical-align: middle;
            font-weight: 500;
        }

        .sales-table tbody tr:nth-child(even) {
            background-color: var(--bg-light);
        }

        .sales-table tbody tr:hover {
            background-color: #dbeafe;
            transition: var(--transition-base);
        }

        /* ==================== ENHANCED SUMMARY TABLE ==================== */
        .summary-container {
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
            border-radius: 1.5rem;
            padding: 1.5rem;
            border: 2px solid var(--primary);
            box-shadow: var(--shadow-lg);
        }

        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
        }

        .summary-table tr {
            border-bottom: 1px solid var(--border-color);
        }

        .summary-table tr:last-child {
            border-bottom: none;
        }

        .summary-table td {
            padding: 1rem 0.5rem;
        }

        .summary-label {
            font-weight: 600;
            color: var(--text);
            font-size: 0.95rem;
            text-align: right;
        }

        .summary-value {
            font-weight: 700;
            text-align: left;
            font-size: 1.1rem;
        }

        .summary-value.subtotal {
            color: var(--info);
        }

        .summary-value.discount {
            color: var(--warning);
        }

        .summary-value.total {
            color: var(--success);
            font-size: 1.3rem;
        }

        /* Invoice Info Card */
        .invoice-info-card {
            background: linear-gradient(135deg, #e0f2fe, #bae6fd);
            border-radius: 1rem;
            padding: 1rem;
            margin-bottom: 1rem;
            border: 2px solid var(--info);
            animation: slideDown 0.3s ease;
        }

        .invoice-header {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.75rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px dashed var(--info);
        }

        .invoice-header i {
            color: var(--info);
            font-size: 1.2rem;
        }

        .invoice-header span {
            font-weight: 600;
            color: var(--text);
        }

        .invoice-number {
            font-weight: 700;
            color: var(--info);
            background: white;
            padding: 0.2rem 0.8rem;
            border-radius: 2rem;
            font-size: 1rem;
        }

        .invoice-stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
        }

        .stat-box {
            background: white;
            border-radius: 0.75rem;
            padding: 0.5rem;
            text-align: center;
            border: 1px solid var(--border-color);
        }

        .stat-label {
            font-size: 0.7rem;
            color: #64748b;
            text-transform: uppercase;
            margin-bottom: 0.25rem;
        }

        .stat-value {
            font-weight: 700;
            color: var(--text);
            font-size: 1rem;
        }

        .stat-value.items {
            color: var(--info);
        }

        .stat-value.amount {
            color: var(--success);
        }

        /* ==================== CREDIT INFO CARD STYLES ==================== */
        .credit-info-card {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            border-radius: 1rem;
            padding: 1rem;
            margin-bottom: 1rem;
            border: 2px solid #f59e0b;
            animation: pulse 0.5s ease;
        }

        .credit-header {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.75rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px dashed #f59e0b;
        }

        .credit-header i {
            color: #f59e0b;
            font-size: 1.2rem;
        }

        .credit-header span {
            font-weight: 600;
            color: #78350f;
        }

        .credit-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: #f59e0b;
            color: white;
            padding: 0.4rem 1rem;
            border-radius: 2rem;
            font-weight: 600;
            font-size: 0.8rem;
            margin-bottom: 0.75rem;
        }

        .credit-badge i {
            font-size: 0.9rem;
        }

        .credit-details {
            background: white;
            border-radius: 0.75rem;
            padding: 0.75rem;
        }

        .credit-detail-row {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px solid var(--border-color);
        }

        .credit-detail-row:last-child {
            border-bottom: none;
        }

        .credit-label {
            font-weight: 600;
            color: #78350f;
            font-size: 0.85rem;
        }

        .credit-value {
            font-weight: 700;
            color: #92400e;
            font-size: 0.9rem;
        }

        .credit-warning {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            border-color: #ef4444;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.02); }
        }

        /* Items Count Badge */
        .items-count-badge {
            display: inline-block;
            background: var(--primary);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 2rem;
            font-size: 0.8rem;
            font-weight: 600;
        }

        /* Divider */
        .summary-divider {
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--primary), transparent);
            margin: 1rem 0;
        }

        /* Grand Total Section */
        .grand-total {
            background: linear-gradient(135deg, var(--success), #059669);
            border-radius: 1rem;
            padding: 1rem;
            color: white;
            margin-top: 1rem;
        }

        .grand-total .label {
            font-size: 0.9rem;
            opacity: 0.9;
            margin-bottom: 0.25rem;
        }

        .grand-total .value {
            font-size: 1.8rem;
            font-weight: 700;
            line-height: 1.2;
        }

        .grand-total .currency {
            font-size: 1rem;
            opacity: 0.8;
            margin-right: 0.25rem;
        }

        /* ==================== PRODUCT IMAGE STYLES ==================== */
        .product-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
        }

        .product-image-thumb {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 0.75rem;
            border: 2px solid var(--primary);
            box-shadow: var(--shadow-md);
            cursor: pointer;
            transition: var(--transition-base);
        }

        .product-image-thumb:hover {
            transform: scale(1.1);
            box-shadow: var(--shadow-lg);
            border-color: var(--secondary);
        }

        .no-image-fallback {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #cbd5e1, #94a3b8);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
            font-weight: bold;
            border-radius: 0.75rem;
            cursor: pointer;
            transition: var(--transition-base);
            border: 2px solid var(--primary);
        }

        .no-image-fallback:hover {
            transform: scale(1.1);
            background: linear-gradient(135deg, #94a3b8, #64748b);
        }

        /* ==================== QUANTITY CONTROLS ==================== */
        .quantity-controls {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .quantity-btn {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition-base);
            font-size: 0.9rem;
            box-shadow: var(--shadow-md);
        }

        .quantity-btn:hover {
            transform: scale(1.1) rotate(5deg);
            background: linear-gradient(135deg, var(--secondary), var(--primary));
            box-shadow: var(--shadow-lg);
        }

        .quantity-input {
            width: 55px;
            text-align: center;
            border: 2px solid var(--primary);
            border-radius: 0.5rem;
            padding: 0.4rem 0.5rem;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--primary);
        }

        .delete-btn {
            background: linear-gradient(135deg, var(--danger), #dc2626);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            cursor: pointer;
            font-weight: 600;
            transition: var(--transition-base);
            width: 100%;
            box-shadow: var(--shadow-md);
        }

        .delete-btn:hover {
            transform: scale(1.05) rotate(2deg);
            box-shadow: var(--shadow-lg);
        }

        /* ==================== REASON SECTION ==================== */
        .reason-container {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            border-radius: 1rem;
            padding: 1.5rem;
            border: 2px solid #f59e0b;
        }

        .reason-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin: 1.5rem 0;
        }

        .reason-option {
            background: white;
            border: 2px solid var(--border-color);
            border-radius: 1rem;
            padding: 1rem;
            cursor: pointer;
            transition: var(--transition-base);
            text-align: center;
        }

        .reason-option:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
            border-color: var(--primary);
        }

        .reason-option.selected {
            border-color: var(--primary);
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        }

        .reason-option i {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            display: block;
        }

        .custom-reason-input {
            margin-top: 1rem;
            padding: 1rem;
            background: white;
            border-radius: 0.75rem;
            border: 2px dashed var(--primary);
            display: none;
        }

        .custom-reason-input.show {
            display: block;
            animation: slideDown 0.3s ease;
        }

        /* ==================== IMAGE MODAL ==================== */
        .image-modal {
            display: none;
            position: fixed;
            z-index: 10000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.95);
            backdrop-filter: blur(10px);
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
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

        .modal-content {
            position: relative;
            margin: auto;
            padding: 1.25rem;
            width: 90%;
            max-width: 800px;
            height: 90%;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: zoomIn 0.3s ease;
        }

        @keyframes zoomIn {
            from { transform: scale(0.9); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        .modal-image {
            max-width: 100%;
            max-height: 80vh;
            object-fit: contain;
            border-radius: 1rem;
            box-shadow: var(--shadow-xl);
            border: 3px solid white;
        }

        .close-modal {
            position: absolute;
            top: 20px;
            right: 30px;
            color: white;
            font-size: 2.5rem;
            font-weight: bold;
            cursor: pointer;
            transition: var(--transition-base);
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            backdrop-filter: blur(5px);
            z-index: 10001;
        }

        .close-modal:hover {
            color: var(--danger);
            transform: rotate(90deg);
            background: rgba(255, 255, 255, 0.3);
        }

        .modal-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            transition: var(--transition-base);
            backdrop-filter: blur(5px);
            z-index: 10001;
        }

        .modal-nav:hover {
            background: rgba(255, 255, 255, 0.4);
            transform: translateY(-50%) scale(1.1);
        }

        .modal-prev {
            left: 20px;
        }

        .modal-next {
            right: 20px;
        }

        /* ==================== ALERT SYSTEM ==================== */
        .alert-container {
            position: fixed;
            top: 30px;
            right: 30px;
            z-index: 9999;
            width: 380px;
            max-width: calc(100% - 60px);
        }

        .custom-alert {
            background: white;
            border-radius: 1.25rem;
            padding: 1.25rem 1.5rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            box-shadow: var(--shadow-xl), 0 0 0 1px rgba(255, 255, 255, 0.1) inset;
            animation: slideInAlert 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            position: relative;
            overflow: hidden;
        }

        @keyframes slideInAlert {
            0% { opacity: 0; transform: translateX(50px) scale(0.9); }
            100% { opacity: 1; transform: translateX(0) scale(1); }
        }

        .alert-success {
            background: linear-gradient(135deg, #ecfdf5, #d1fae5);
            border-right: 5px solid var(--success);
            color: #065f46;
        }

        .alert-error {
            background: linear-gradient(135deg, #fef2f2, #fee2e2);
            border-right: 5px solid var(--danger);
            color: #991b1b;
        }

        .alert-warning {
            background: linear-gradient(135deg, #fffbeb, #fef3c7);
            border-right: 5px solid var(--warning);
            color: #92400e;
        }

        .alert-info {
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
            border-right: 5px solid var(--info);
            color: #1e40af;
        }

        .alert-icon {
            font-size: 1.75rem;
            min-width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 0.75rem;
            padding: 0.3rem;
        }

        .alert-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            background: linear-gradient(90deg, currentColor, transparent);
            animation: progress 5s linear;
        }

        @keyframes progress {
            0% { width: 100%; }
            100% { width: 0%; }
        }

        /* ==================== SEARCH RESULTS ==================== */
        .search-results {
            position: absolute;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            max-height: 400px;
            overflow-y: auto;
            width: 100%;
            z-index: 1000;
            box-shadow: var(--shadow-xl);
            margin-top: 0.25rem;
        }

        .search-result-item {
            padding: 0.75rem 1rem;
            cursor: pointer;
            border-bottom: 1px solid var(--border-color);
            transition: var(--transition-base);
        }

        .search-result-item:hover {
            background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
            transform: translateX(-5px);
        }

        .search-result-item img {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 0.5rem;
            margin-left: 1rem;
            border: 2px solid var(--primary);
            cursor: pointer;
        }

        /* Loading State */
        .loading {
            position: relative;
            pointer-events: none;
            opacity: 0.7;
        }

        .loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            top: 50%;
            left: 50%;
            margin-left: -10px;
            margin-top: -10px;
            border: 2px solid white;
            border-top-color: transparent;
            border-radius: 50%;
            animation: spinner 0.6s linear infinite;
        }

        @keyframes spinner {
            to { transform: rotate(360deg); }
        }

        /* ==================== PRINT STYLES ==================== */
        #print-section {
            display: none;
        }

        #print-section.print-show {
            display: block;
        }

        @media print {
            body * {
                visibility: hidden;
                margin: 0;
                padding: 0;
            }

            #print-section, #print-section * {
                visibility: visible;
            }

            #print-section {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                background: white;
                padding: 0;
                margin: 0;
                box-sizing: border-box;
            }

            .print-receipt {
                width: 120mm;
                max-width: 120mm;
                margin: 0 auto;
                background: white;
                padding: 5mm 3mm;
                font-family: 'Courier New', Courier, monospace;
                direction: rtl;
                font-size: 11px;
                line-height: 1.3;
                color: #000;
                box-sizing: border-box;
            }

            .print-header {
                text-align: center;
                margin-bottom: 3mm;
                border-bottom: 1px dashed #000;
                padding-bottom: 2mm;
            }

            .print-header .market-name {
                font-size: 18px;
                font-weight: bold;
                margin: 0 0 2mm 0;
            }

            .print-header .datetime {
                display: flex;
                justify-content: space-between;
                margin: 1mm 0;
                font-size: 11px;
            }

            .print-header .voucher-number {
                margin: 1mm 0;
                font-size: 11px;
            }

            .print-table {
                width: 100%;
                border-collapse: collapse;
                margin: 2mm 0;
                font-size: 11px;
            }

            .print-table th {
                border-bottom: 1px solid #000;
                border-top: 1px solid #000;
                padding: 1mm 0;
                text-align: center;
                font-weight: bold;
            }

            .print-table td {
                padding: 0.5mm 0;
                text-align: center;
            }

            .totals-section {
                margin: 2mm 0;
                border-top: 1px solid #000;
                border-bottom: 1px solid #000;
                padding: 1mm 0;
            }

            .total-row {
                display: flex;
                justify-content: space-between;
                margin: 0.5mm 0;
                font-size: 11px;
            }

            .total-row.grand {
                font-weight: bold;
                font-size: 12px;
                border-top: 1px solid #000;
                margin-top: 1mm;
                padding-top: 1mm;
            }

            .print-footer {
                text-align: center;
                margin-top: 3mm;
                font-size: 10px;
                border-top: 1px dashed #000;
                padding-top: 2mm;
            }
        }

        .btn-credit, .btn-return {
            border: none;
            color: white;
            font-weight: 700;
            padding: 16px 24px;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s;
            width: 100%;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            overflow: hidden;
        }

        .btn-credit::before, .btn-return::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .btn-credit:hover::before, .btn-return:hover::before {
            left: 100%;
        }

        .btn-return {
            background: linear-gradient(135deg, #d97706, #b45309);
            box-shadow: 0 8px 20px rgba(217, 119, 6, 0.4);
        }

        .btn-credit:hover, .btn-return:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
        }

        .btn-credit:active, .btn-return:active {
            transform: translateY(0);
        }

        .btn-credit {
            background: linear-gradient(135deg, #0891b2, #0e7490);
            box-shadow: 0 8px 20px rgba(8, 145, 178, 0.4);
        }

        /* URL Parameter Loading Animation */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(5px);
            z-index: 10000;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.3s ease;
        }

        .loading-spinner {
            background: white;
            border-radius: 2rem;
            padding: 2rem;
            text-align: center;
            animation: zoomIn 0.3s ease;
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

        .loading-spinner p {
            margin-top: 1rem;
            font-size: 1rem;
            color: var(--text);
        }
    </style>

    <!-- ==================== IMAGE MODAL ==================== -->
    <div id="imageModal" class="image-modal">
        <span class="close-modal" onclick="closeImageModal()">&times;</span>
        <div class="modal-nav modal-prev" onclick="showPrevImage()">
            <i class="fas fa-chevron-right"></i>
        </div>
        <div class="modal-nav modal-next" onclick="showNextImage()">
            <i class="fas fa-chevron-left"></i>
        </div>
        <div class="modal-content">
            <img class="modal-image" id="modalImage" src="" alt="وێنەی کاڵا">
            <div class="modal-caption" id="modalCaption"></div>
        </div>
    </div>

    <!-- ==================== ALERT CONTAINER ==================== -->
    <div id="alert-container" class="alert-container"></div>

    <!-- ==================== PRINT SECTION ==================== -->
    <div id="print-section">
        <div class="print-receipt">
            <div class="print-header">
                <div class="market-name">مارکیتی کوردستان</div>
                <div class="address">سلیمانی - کانیکورده</div>
                <div class="datetime">
                    <span>به‌روز: <span id="print-date"></span></span>
                    <span>کات: <span id="print-time"></span></span>
                </div>
                <div class="voucher-number">ژمارەی گەڕاندنەوە: <span id="print-voucher"></span></div>
            </div>

            <table class="print-table" id="print-items-table" border="1" width="100%" cellpadding="4" cellspacing="0">
                <thead>
                    <tr>
                        <th>ژمارە</th>
                        <th>ناوی کاڵا</th>
                        <th>دانه</th>
                        <th>نرخ</th>
                        <th>کۆ</th>
                    </tr>
                </thead>
                <tbody id="print-table-body"></tbody>
             </table>

            <div class="totals-section">
                <div class="total-row">
                    <span>کۆی گشتی</span>
                    <span id="print-subtotal">0</span>
                </div>
                <div class="total-row discount">
                    <span>داشکاندن</span>
                    <span id="print-discount">0</span>
                </div>
                <div class="total-row grand">
                    <span>کۆتایی</span>
                    <span id="print-total">0</span>
                </div>
            </div>

            <div class="print-footer">
                <div class="thanks">سوپاس بۆ هەڵبژاردنی ئێمە</div>
                <div class="contact">هەر کێشەیەک هەبوو تکایە پەیوەندیمان پێوە بکە</div>
            </div>
        </div>
    </div>

    <!-- ==================== MAIN CONTENT ==================== -->
    <div class="sales-container">
        <div class="form-header-custom text-white text-center">
            <div class="form-logo-custom">
                <i class="fas fa-undo-alt"></i>
            </div>
            <h1 class="h2 mb-0">گەڕاندنەوەی کاڵا</h1>

            <div class="d-flex justify-content-between m-6 py-4 px-4">
                <!-- Credit Sale Button -->
                <a href="<?php echo e(route('sales.index')); ?>" class="text-decoration-none btn-credit mx-4">
                    <i class="fas fa-cart-plus"></i>
                    <span>فرۆشتن</span>
                </a>

                <!-- Return Items Button -->
                <a href="<?php echo e(route('ReturnItem')); ?>" class="text-decoration-none btn-return mx-4">
                    <i class="fas fa-undo-alt"></i>
                    <span>گەڕاندنەوەی کاڵا</span>
                </a>
            </div>
        </div>

        <div class="grid-2">
            <!-- Left Column - Return Form -->
            <div>
                <!-- Search Section -->
                <div class="form-card">
                    <p class="section-title">گەڕان بە بارکۆد یان ناوی کاڵا</p>
                    <div class="grid-2">
                        <div style="position: relative;">
                            <label class="block">
                                <i class="fas fa-box"></i> ناوی کاڵا
                            </label>
                            <input type="text" id="name-search" class="name-input"
                                   placeholder="ناوی کاڵا بنووسە..." autocomplete="off">
                            <div id="name-search-results" class="search-results" style="display: none;"></div>
                        </div>
                        <div>
                            <label class="block">
                                <i class="fas fa-barcode"></i> بارکۆد
                            </label>
                            <input type="text" id="barcode-search" class="barcode-input"
                                   placeholder="بارکۆد بنووسە..." autocomplete="off">
                        </div>
                    </div>
                </div>

                <!-- Invoice Search Section -->
                <div class="form-card" style="margin-top: 1rem;">
                    <p class="section-title">گەڕان بە ژمارەی پسوڵە</p>
                    <div style="position: relative;">
                        <label class="block">
                            <i class="fas fa-file-invoice"></i> ژمارەی پسوڵە
                        </label>
                        <input type="text" id="invoice-search" class="invoice-input"
                               placeholder="ژمارەی پسوڵە بنووسە..."
                               autocomplete="off">
                        <div id="invoice-search-results" class="search-results" style="display: none;"></div>
                    </div>
                </div>

                <!-- Return Reason Section -->
                <div class="form-card">
                    <p class="section-title">هۆکاری گەڕاندنەوە</p>
                    <div class="reason-container">
                        <div class="reason-options">
                            <div class="reason-option broken" data-reason="شکان" onclick="selectReason('شکان')">
                                <i class="fas fa-exclamation-triangle"></i>
                                <span>شکان</span>
                                <small>کاڵا شکاوە یان زیانی پێگەیشتووە</small>
                            </div>
                            <div class="reason-option damaged" data-reason="تێکچون" onclick="selectReason('تێکچون')">
                                <i class="fas fa-times-circle"></i>
                                <span>تێکچوون</span>
                                <small>کاڵا تێکچووە و کار ناکات</small>
                            </div>
                            <div class="reason-option used" data-reason="بەکار هێنراوە بۆ دوکان" onclick="selectReason('بەکار هێنراوە بۆ دوکان')">
                                <i class="fas fa-exchange-alt"></i>
                                <span>گۆڕین</span>
                                <small>گۆڕینی کاڵا بە کاڵایەکی تر</small>
                            </div>
                            <div class="reason-option other" data-reason="شتی تر" onclick="selectReason('شتی تر')">
                                <i class="fas fa-ellipsis-h"></i>
                                <span>شتی تر</span>
                                <small>هۆکاری تر</small>
                            </div>
                        </div>

                        <select id="stock-reason" name="stock_reason" style="display: none;">
                            <option value="">هەڵبژێرە</option>
                            <option value="شکان">شکان</option>
                            <option value="تێکچون">تێکچوون</option>
                            <option value="بەکار هێنراوە بۆ دوکان">بەکارهێنراوە بۆ دوکان</option>
                            <option value="شتی تر">شتی تر</option>
                        </select>

                        <div class="custom-reason-input" id="custom-reason-container">
                            <label class="block">
                                <i class="fas fa-pen"></i> هۆکاری تر بنووسە
                            </label>
                            <input type="text" id="custom-reason" name="custom_reason"
                                   class="form-control"
                                   placeholder="هۆکاری دیاریکراو بنووسە...">
                        </div>
                    </div>
                </div>

                <!-- Items Table -->
                <div class="form-card">
                    <p class="section-title">کاڵاکانی گەڕاندنەوە</p>
                    <div class="table-container">
                        <table class="sales-table">
                            <thead>
                                 <tr>
                                    <th width="5%">ژ</th>
                                    <th width="35%">ناوی کاڵا</th>
                                    <th width="15%">ژمارە</th>
                                    <th width="15%">نرخ</th>
                                    <th width="15%">کۆ</th>
                                    <th width="15%">سڕینەوە</th>
                                 </tr>
                            </thead>
                            <tbody id="sales-items">
                                <tr id="empty-message">
                                    <td colspan="6" style="text-align: center; padding: 2.5rem; color: #94a3b8;">
                                        <i class="fas fa-undo-alt fa-4x" style="margin-bottom: 1rem; opacity: 0.5;"></i>
                                        <p style="font-size: 1rem;">هیچ کاڵایەک بۆ گەڕاندنەوە زیاد نەکراوە</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right Column - Enhanced Summary Sidebar -->
            <div>
                <div class="form-card">
                    <p class="section-title">پوختەی گەڕاندنەوە</p>

                    <div class="summary-container">
                        <!-- Invoice Info (shown when items exist) -->
                        <div id="invoice-info-container" style="display: none;">
                            <div class="invoice-info-card">
                                <div class="invoice-header">
                                    <i class="fas fa-file-invoice"></i>
                                    <span>ژمارەی پسوڵە:</span>
                                    <span class="invoice-number" id="invoice-number-display">-</span>
                                </div>
                                <div class="invoice-stats">
                                    <div class="stat-box">
                                        <div class="stat-label">ژ. کاڵا</div>
                                        <div class="stat-value items" id="invoice-items-count">0</div>
                                    </div>
                                    <div class="stat-box">
                                        <div class="stat-label">ن.خ.بنەڕەتی</div>
                                        <div class="stat-value discount" id="invoice-totall">0</div>
                                    </div>
                                    <div class="stat-box">
                                        <div class="stat-label">داشکاندن</div>
                                        <div class="stat-value discount" id="invoice-discount">0</div>
                                    </div>
                                    <div class="stat-box">
                                        <div class="stat-label">کۆی گشتی</div>
                                        <div class="stat-value amount" id="invoice-total-display">0</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- CREDIT INFO SECTION - Shows when returning from a credit sale -->
                        <div id="credit-info-container" style="display: none;">
                            <div class="credit-info-card">
                                <div class="credit-header">
                                    <i class="fas fa-hand-holding-usd"></i>
                                    <span>ئاگاداری! ئەم پسوڵەیە بە قەرز کڕاوە</span>
                                </div>
                                <div class="credit-badge">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <span>ئەم کاڵایانە لە پسوڵەی قەرزەوە گەڕێنراوەتەوە</span>
                                </div>
                                <div class="credit-details">
                                    <div class="credit-detail-row">
                                        <span class="credit-label"><i class="fas fa-user"></i> ناوی کڕیار:</span>
                                        <span class="credit-value" id="credit-customer-name">-</span>
                                    </div>
                                    <div class="credit-detail-row">
                                        <span class="credit-label"><i class="fas fa-id-card"></i> ژمارەی قەرز:</span>
                                        <span class="credit-value" id="credit-loan-id">-</span>
                                    </div>
                                    <div class="credit-detail-row">
                                        <span class="credit-label"><i class="fas fa-phone"></i> ژمارەی مۆبایل:</span>
                                        <span class="credit-value" id="credit-phone">-</span>
                                    </div>
                                    <div class="credit-detail-row">
                                        <span class="credit-label"><i class="fas fa-calendar-alt"></i> کاتی گەڕانەوە:</span>
                                        <span class="credit-value" id="credit-due-date">-</span>
                                    </div>
                                    <div class="credit-detail-row">
                                        <span class="credit-label"><i class="fas fa-money-bill-wave"></i> بڕی قەرز:</span>
                                        <span class="credit-value" id="credit-amount">-</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="summary-table">
                            <div class="summary-divider"></div>

                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                                <span style="font-weight: 600; color: var(--text);">ژمارەی کاڵا:</span>
                                <span class="items-count-badge" id="items-count">0</span>
                            </div>

                            <!-- Grand Total -->
                            <div class="grand-total">
                                <div class="label">کۆی گشتی دوای داشکان</div>
                                <div>
                                    <span class="value" id="final-total-summary">0</span>
                                    <span class="currency">دینار</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="form-card">
                    <p class="section-title">کردارەکان</p>
                    <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                        <button type="button" id="btn" class="btn btn-success" onclick="completeReturn(false)">
                            <i class="fas fa-save"></i>
                            <span>تۆمارکردن (F5)</span>
                        </button>
                        <button type="button" id="btn" class="btn btn-danger" onclick="clearCart()">
                            <i class="fas fa-trash"></i>
                            <span>پاککردنەوە (F8)</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== SCRIPTS ==================== -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // ==================== CONFIGURATION ====================
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // ==================== GLOBAL VARIABLES ====================
        let cart = [];
        let currentInvoiceNumber = null;
        let currentInvoiceTotal = 0;
        let currentCreditInfo = null;
        let searchDebounceTimer = null;
        let currentImageIndex = 0;
        let productImages = [];

        // ==================== GET URL PARAMETERS ====================
        function getUrlParameters() {
            const urlParams = new URLSearchParams(window.location.search);
            return {
                invoice_number: urlParams.get('invoice_number'),  // FIXED: Now reads invoice_number from URL
                item_id: urlParams.get('item_id'),
                item_name: urlParams.get('item_name'),
                max_qty: urlParams.get('max_qty'),
                price: urlParams.get('price')
            };
        }

        // ==================== AUTO-POPULATE INVOICE SEARCH FIELD ====================
        function autoPopulateInvoiceSearch() {
            const params = getUrlParameters();
            if (params.invoice_number) {
                $('#invoice-search').val(params.invoice_number);
                // Trigger search automatically
                searchByInvoice(params.invoice_number);
                return true;
            }
            return false;
        }

        // ==================== LOAD INVOICE FROM URL ====================
        async function loadInvoiceFromUrl() {
            const params = getUrlParameters();
            
            if (params.invoice_number) {
                // Show loading overlay
                showLoadingOverlay('تکایە ڕاوەستە... پسوڵەکە بار دەکرێت');
                
                try {
                    // Fetch invoice details
                    const response = await $.ajax({
                        url: '/invoice/' + params.invoice_number,
                        type: 'GET',
                        timeout: 10000
                    });
                    
                    if (response.success && response.invoice) {
                        const invoice = response.invoice;
                        
                        // Clear existing cart
                        cart = [];
                        
                        // Set invoice info
                        if (invoice.is_credit && invoice.credit_info) {
                            setInvoiceInfo(invoice.invoice_number, invoice.total, {
                                customer_name: invoice.credit_info.customer_name,
                                loan_id: invoice.credit_info.loan_id || invoice.credit_info.sels_id,
                                sels_id: invoice.credit_info.sels_id,
                                phone_number: invoice.credit_info.phone_number,
                                time_to_return: invoice.credit_info.time_to_return,
                                total: invoice.total,
                                credit_amount: invoice.total
                            });
                        } else {
                            setInvoiceInfo(invoice.invoice_number, invoice.total, null);
                        }
                        
                        // If specific item is selected, only add that item
                        if (params.item_id && params.item_name && params.max_qty && params.price) {
                            const specificItem = {
                                id: params.item_id,
                                name: params.item_name,
                                barcode: params.item_id,
                                quantity: parseInt(params.max_qty),
                                price: parseFloat(params.price),
                                total: parseFloat(params.price) * parseInt(params.max_qty),
                                counter: parseInt(params.max_qty),
                                selling_price: parseFloat(params.price)
                            };
                            
                            addToCart(specificItem);
                            showAlert('info', `کاڵای "${params.item_name}" بە ژمارەی ${params.max_qty} زیادکرا`, '✅ زیادکرا');
                        } else {
                            // Add all items from the invoice
                            if (invoice.items && invoice.items.length > 0) {
                                let addedCount = 0;
                                showAlert('info', 'تکایە ڕاوەستە... کاڵاکان زیاد دەکرێن', '⏳ بەردەوامە');
                                
                                for (const item of invoice.items) {
                                    try {
                                        const productResponse = await $.ajax({
                                            url: '/products/search-by-barcode-sells',
                                            type: 'POST',
                                            data: {
                                                barcode: item.barcode,
                                                _token: $('meta[name="csrf-token"]').attr('content')
                                            }
                                        });
                                        
                                        if (productResponse.success && productResponse.product) {
                                            productResponse.product.quantity = item.quantity_sold;
                                            addToCart(productResponse.product);
                                            addedCount++;
                                        }
                                    } catch (error) {
                                        console.error('Error loading item:', item.name, error);
                                    }
                                }
                                
                                showAlert('success', `${addedCount} کاڵا زیادکرا بۆ گەڕاندنەوە`, '✅ تەواو بوو');
                            }
                        }
                        
                        // Focus on barcode search
                        setTimeout(() => {
                            $('#barcode-search').focus();
                        }, 500);
                        
                    } else {
                        showAlert('error', 'پسوڵەکە نەدۆزرایەوە', '❌ هەڵە');
                    }
                } catch (error) {
                    console.error('Error loading invoice:', error);
                    showAlert('error', 'هەڵەیەک ڕوویدا لە کاتی بارکردنی پسوڵەکە', '❌ هەڵە');
                } finally {
                    hideLoadingOverlay();
                }
            }
        }
        
        function showLoadingOverlay(message) {
            const overlay = $(`
                <div id="loading-overlay" class="loading-overlay">
                    <div class="loading-spinner">
                        <i class="fas fa-spinner fa-spin"></i>
                        <p>${message}</p>
                    </div>
                </div>
            `);
            $('body').append(overlay);
        }
        
        function hideLoadingOverlay() {
            $('#loading-overlay').remove();
        }

        // ==================== ENHANCED SUMMARY FUNCTIONS ====================
        function calculateTotals() {
            const subtotal = cart.reduce((sum, item) => sum + (item.total || 0), 0);
            const discount = 0;
            const finalTotal = subtotal;
            const itemsCount = cart.length;

            $('#final-total-summary').text(formatNumber(finalTotal));
            $('#items-count').text(itemsCount);

            if (currentInvoiceNumber) {
                $('#invoice-info-container').show();
                $('#invoice-number-display').text(currentInvoiceNumber);
                $('#invoice-items-count').text(itemsCount);
                $('#invoice-total-display').text(formatNumber(currentInvoiceTotal) + ' دینار');
                $('#invoice-discount').text(formatNumber(finalTotal - currentInvoiceTotal) + ' دینار');
                $("#invoice-totall").text(formatNumber(finalTotal) + ' دینار');
                $('#summary-table').hide();
            } else {
                $('#invoice-info-container').hide();
                $('#summary-table').show();
            }

            if (currentCreditInfo) {
                $('#credit-info-container').show();
                $('#credit-customer-name').text(currentCreditInfo.customer_name || '-');
                $('#credit-loan-id').text(currentCreditInfo.loan_id || currentCreditInfo.sels_id || '-');
                $('#credit-phone').text(currentCreditInfo.phone_number || '-');
                $('#credit-due-date').text(currentCreditInfo.time_to_return || '-');
                $('#credit-amount').text(formatNumber(currentCreditInfo.total || currentCreditInfo.credit_amount || 0) + ' دینار');
                
                $('.credit-info-card').addClass('pulse');
                setTimeout(() => {
                    $('.credit-info-card').removeClass('pulse');
                }, 1000);
            } else {
                $('#credit-info-container').hide();
            }

            saveReturnToLocalStorage();
            return finalTotal;
        }

        function setInvoiceInfo(invoiceNumber, total, creditInfo = null) {
            currentInvoiceNumber = invoiceNumber;
            currentInvoiceTotal = total;
            currentCreditInfo = creditInfo;
            calculateTotals();

            if (creditInfo) {
                showAlert('warning',
                    'ئاگاداری! ئەم پسوڵەیە بە قەرز کڕاوە. تکایە دڵنیا بە کە گەڕاندنەوەکە پێویستە.',
                    '💰 گەڕاندنەوەی قەرز'
                );
            }
        }

        function clearInvoiceInfo() {
            currentInvoiceNumber = null;
            currentInvoiceTotal = 0;
            currentCreditInfo = null;
            calculateTotals();
        }

        // ==================== RETURN REASON FUNCTIONS ====================
        function selectReason(reason) {
            $('.reason-option').removeClass('selected');
            $(`.reason-option[data-reason="${reason}"]`).addClass('selected');
            $('#stock-reason').val(reason);

            if (reason === 'شتی تر') {
                $('#custom-reason-container').addClass('show');
                $('#custom-reason').focus();
            } else {
                $('#custom-reason-container').removeClass('show');
                $('#custom-reason').val('');
            }

            showAlert('success', `هۆکاری گەڕاندنەوە: ${reason} دیاریکرا`, '✅ دیاریکرا');
            saveReturnToLocalStorage();
        }

        // ==================== LOCALSTORAGE FUNCTIONS ====================
        function saveReturnToLocalStorage() {
            try {
                const returnData = {
                    items: cart,
                    reason: $('#stock-reason').val(),
                    customReason: $('#custom-reason').val(),
                    invoiceNumber: currentInvoiceNumber,
                    invoiceTotal: currentInvoiceTotal,
                    creditInfo: currentCreditInfo,
                    timestamp: new Date().getTime()
                };
                localStorage.setItem('return_cart', JSON.stringify(returnData));
            } catch (e) {
                console.error('Error saving return to localStorage:', e);
            }
        }

        function loadReturnFromLocalStorage() {
            try {
                const savedReturn = localStorage.getItem('return_cart');
                if (savedReturn) {
                    const returnData = JSON.parse(savedReturn);
                    const now = new Date().getTime();
                    const returnAge = now - (returnData.timestamp || 0);
                    const maxAge = 24 * 60 * 60 * 1000;

                    if (returnAge < maxAge && returnData.items?.length > 0) {
                        cart = returnData.items;
                        currentInvoiceNumber = returnData.invoiceNumber || null;
                        currentInvoiceTotal = returnData.invoiceTotal || 0;
                        currentCreditInfo = returnData.creditInfo || null;

                        if (returnData.reason) {
                            $('#stock-reason').val(returnData.reason);
                            selectReason(returnData.reason);
                            if (returnData.reason === 'شتی تر' && returnData.customReason) {
                                $('#custom-reason').val(returnData.customReason);
                                $('#custom-reason-container').addClass('show');
                            }
                        }

                        renderCart();
                        showAlert('success', 'گەڕاندنەوەی پێشوو بارکرایەوە', '✅ بارکرایەوە');
                        return true;
                    } else {
                        localStorage.removeItem('return_cart');
                    }
                }
            } catch (e) {
                console.error('Error loading return from localStorage:', e);
            }
            return false;
        }

        function clearReturnFromLocalStorage() {
            try {
                localStorage.removeItem('return_cart');
            } catch (e) {
                console.error('Error clearing return from localStorage:', e);
            }
        }

        // ==================== UTILITY FUNCTIONS ====================
        function formatNumber(num) {
            if (num === null || num === undefined || isNaN(num)) return '0';
            return num.toLocaleString();
        }

        function getInitials(name) {
            return name ? name.charAt(0).toUpperCase() : '?';
        }

        function showAlert(type, message, title = '') {
            const alertClass = {
                success: 'alert-success',
                error: 'alert-error',
                warning: 'alert-warning',
                info: 'alert-info'
            }[type] || 'alert-info';

            const icon = {
                success: 'fa-check-circle',
                error: 'fa-exclamation-circle',
                warning: 'fa-exclamation-triangle',
                info: 'fa-info-circle'
            }[type] || 'fa-info-circle';

            const defaultTitle = {
                success: '✅ سەرکەوتوو بوو',
                error: '❌ هەڵە ڕوویدا',
                warning: '⚠️ ئاگاداری',
                info: 'ℹ️ زانیاری'
            }[type] || '';

            const alertId = 'alert-' + Date.now();
            const alertHtml = `
                <div id="${alertId}" class="custom-alert ${alertClass}">
                    <div class="alert-icon">
                        <i class="fas ${icon}"></i>
                    </div>
                    <div class="alert-content">
                        <div class="alert-title">${title || defaultTitle}</div>
                        <div class="alert-message">${message}</div>
                    </div>
                    <div class="alert-progress"></div>
                </div>
            `;

            $('#alert-container').append(alertHtml);
            setTimeout(() => {
                $(`#${alertId}`).fadeOut(300, function() { $(this).remove(); });
            }, 5000);
        }

        // ==================== IMAGE MODAL FUNCTIONS ====================
        function openImageModal(imageSrc, productName, allImages = []) {
            const modal = document.getElementById('imageModal');
            const modalImg = document.getElementById('modalImage');
            const modalCaption = document.getElementById('modalCaption');

            modalImg.src = imageSrc || '';
            modalCaption.textContent = productName || 'وێنەی کاڵا';
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';

            if (allImages.length > 0) {
                productImages = allImages;
                currentImageIndex = allImages.findIndex(img => img === imageSrc);
            } else {
                productImages = [imageSrc];
                currentImageIndex = 0;
            }
        }

        function closeImageModal() {
            document.getElementById('imageModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        function showPrevImage() {
            if (productImages.length > 1) {
                currentImageIndex = (currentImageIndex - 1 + productImages.length) % productImages.length;
                document.getElementById('modalImage').src = productImages[currentImageIndex];
            }
        }

        function showNextImage() {
            if (productImages.length > 1) {
                currentImageIndex = (currentImageIndex + 1) % productImages.length;
                document.getElementById('modalImage').src = productImages[currentImageIndex];
            }
        }

        // ==================== CART MANAGEMENT FUNCTIONS ====================
        function renderCart() {
            const tbody = $('#sales-items');

            if (cart.length === 0) {
                tbody.html(`
                    <tr id="empty-message">
                        <td colspan="6" style="text-align: center; padding: 2.5rem; color: #94a3b8;">
                            <i class="fas fa-undo-alt fa-4x" style="margin-bottom: 1rem; opacity: 0.5;"></i>
                            <p style="font-size: 1rem;">هیچ کاڵایەک بۆ گەڕاندنەوە زیاد نەکراوە</p>
                        </td>
                    </tr>
                `);
                clearInvoiceInfo();
                return;
            }

            let html = '';
            cart.forEach((item, index) => {
                const imagePath = item.image_producte_path || '';
                const initials = getInitials(item.name);

                html += `
                    <tr data-index="${index}">
                        <td><strong>${index + 1}</strong></td>
                        <td>
                            <div class="product-info" onclick="openImageModal('${imagePath}', '${item.name}', ['${imagePath}'])">
                                ${imagePath ?
                                    `<img src="${imagePath}" alt="${item.name}" class="product-image-thumb"
                                          onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'50\' height=\'50\' viewBox=\'0 0 50 50\'%3E%3Crect width=\'50\' height=\'50\' fill=\'%23cbd5e1\'/%3E%3Ctext x=\'25\' y=\'30\' font-size=\'16\' text-anchor=\'middle\' fill=\'%234b5563\' font-family=\'Arial\'%3E${initials}%3C/text%3E%3C/svg%3E'">` :
                                    `<div class="no-image-fallback" onclick="event.stopPropagation(); showAlert('info', 'وێنە بەردەست نیە بۆ ${item.name}')">
                                        <i class="fas fa-image"></i>
                                    </div>`
                                }
                                <span class="product-name">${item.name}</span>
                            </div>
                        </td>
                        <td>
                            <div class="quantity-controls">
                                <button class="quantity-btn decrease" data-index="${index}" type="button">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" class="quantity-input" value="${item.quantity}"
                                       min="1" max="${item.counter || 999}" data-index="${index}">
                                <button class="quantity-btn increase" data-index="${index}" type="button">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </td>
                        <td><strong>${formatNumber(item.price)}</strong></td>
                        <td><strong style="color: var(--primary);">${formatNumber(item.total)}</strong></td>
                        <td>
                            <button class="delete-btn" data-index="${index}" type="button">
                                <i class="fas fa-trash"></i> سڕینەوە
                            </button>
                        </td>
                    </tr>
                `;
            });

            tbody.html(html);
            calculateTotals();
        }

        function addToCart(product) {
            const existingIndex = cart.findIndex(item => item.barcode === product.barcode);

            if (existingIndex !== -1) {
                const maxQuantity = product.counter || 999;
                if (cart[existingIndex].quantity < maxQuantity) {
                    cart[existingIndex].quantity += 1;
                    cart[existingIndex].total = cart[existingIndex].quantity * cart[existingIndex].price;
                    showAlert('success', `${product.name} زیادکرا (ژمارە: ${cart[existingIndex].quantity})`, '✅ زیادکرا');
                } else {
                    showAlert('warning', `تەنها ${maxQuantity} دانە لە کۆگا ماوە`, '⚠️ کەمی کۆگا');
                    return;
                }
            } else {
                if (product.counter <= 0) {
                    showAlert('error', 'کاڵا لە کۆگا بەردەست نیە', '❌ بەردەست نیە');
                    return;
                }

                cart.push({
                    id: product.id,
                    barcode: product.barcode,
                    name: product.name,
                    company: product.company,
                    price: parseFloat(product.selling_price) || 0,
                    quantity: product.quantity || 1,
                    total: (parseFloat(product.selling_price) || 0) * (product.quantity || 1),
                    counter: product.counter,
                    purchase_price: product.purchase_price || 0,
                    image_producte_path: product.image_producte_path
                });

                showAlert('success', `${product.name} زیادکرا بۆ گەڕاندنەوە`, '✅ زیادکرا');
            }

            renderCart();
            saveReturnToLocalStorage();
        }

        function updateQuantity(index, newQuantity) {
            const maxQuantity = cart[index].counter || 999;

            if (newQuantity < 1) {
                showAlert('warning', 'ژمارە نابێت کەمتر لە ١ بێت');
                return false;
            }

            if (newQuantity > maxQuantity) {
                showAlert('warning', `تەنها ${maxQuantity} دانە لە کۆگا ماوە`, '⚠️ کەمی کۆگا');
                return false;
            }

            cart[index].quantity = newQuantity;
            cart[index].total = newQuantity * cart[index].price;
            renderCart();
            saveReturnToLocalStorage();
            return true;
        }

        function removeFromCart(index) {
            if (index >= 0 && index < cart.length) {
                const productName = cart[index].name;
                cart.splice(index, 1);
                showAlert('info', `${productName} سڕدرایەوە`, '🗑️ سڕدرایەوە');

                if (cart.length === 0) {
                    clearInvoiceInfo();
                    clearReturnFromLocalStorage();
                }

                renderCart();
                saveReturnToLocalStorage();
            }
        }

        function clearCart() {
            if (cart.length > 0) {
                if (confirm('دڵنیایت کە دەتەوێت هەموو کاڵاکان سڕبکەیتەوە؟')) {
                    cart = [];
                    clearInvoiceInfo();
                    $('#stock-reason').val('');
                    $('#custom-reason').val('').parent().removeClass('show');
                    $('.reason-option').removeClass('selected');
                    clearReturnFromLocalStorage();
                    renderCart();
                    showAlert('success', 'گەڕاندنەوە پاککرایەوە', '🗑️ پاککرایەوە');
                    $('#barcode-search').focus();
                }
            } else {
                showAlert('info', 'گەڕاندنەوە خاڵیە');
            }
        }

        // ==================== SEARCH FUNCTIONS ====================
        function searchByBarcode(barcode) {
            $.ajax({
                url: '/products/search-by-barcode-sells',
                type: 'POST',
                data: { barcode, _token: '<?php echo e(csrf_token()); ?>' },
                beforeSend: () => $('#barcode-search').prop('disabled', true).addClass('loading'),
                success: function(response) {
                    if (response.success && response.product) {
                        addToCart(response.product);
                        $('#barcode-search').val('').focus();
                    } else {
                        showAlert('error', 'کاڵا نەدۆزرایەوە', '❌ نەدۆزرایەوە');
                    }
                },
                error: () => showAlert('error', 'هەڵەیەک ڕوویدا لە کاتی گەڕاندا'),
                complete: () => $('#barcode-search').prop('disabled', false).removeClass('loading')
            });
        }

        function searchByName(name) {
            $.ajax({
                url: '/products/search-by-name-sells',
                type: 'POST',
                data: { name, _token: '<?php echo e(csrf_token()); ?>' },
                beforeSend: () => $('#name-search').prop('disabled', true).addClass('loading'),
                success: function(response) {
                    if (response.success && response.products?.length > 0) {
                        showNameSearchResults(response.products);
                    } else {
                        $('#name-search-results').hide();
                        showAlert('error', 'هیچ کاڵایەک نەدۆزرایەوە', '❌ نەدۆزرایەوە');
                    }
                },
                error: () => {
                    showAlert('error', 'هەڵەیەک ڕوویدا لە کاتی گەڕاندا');
                    $('#name-search-results').hide();
                },
                complete: () => $('#name-search').prop('disabled', false).removeClass('loading')
            });
        }

        function showNameSearchResults(products) {
            const resultsContainer = $('#name-search-results');
            resultsContainer.empty().show();

            products.forEach(product => {
                const imagePath = product.image_producte_path || '';
                const initials = getInitials(product.name);

                const imageHtml = imagePath
                    ? `<img src="${imagePath}" alt="${product.name}" onclick="event.stopPropagation(); openImageModal('${imagePath}', '${product.name}', ['${imagePath}'])"
                           onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'40\' height=\'40\' viewBox=\'0 0 40 40\'%3E%3Crect width=\'40\' height=\'40\' fill=\'%23cbd5e1\'/%3E%3Ctext x=\'20\' y=\'25\' font-size=\'14\' text-anchor=\'middle\' fill=\'%234b5563\' font-family=\'Arial\'%3E${initials}%3C/text%3E%3C/svg%3E'">`
                    : `<div class="no-image-fallback" style="width:40px; height:40px; font-size:14px;"
                           onclick="event.stopPropagation(); showAlert('info', 'وێنە بەردەست نیە بۆ ${product.name}')">
                        <i class="fas fa-image"></i>
                      </div>`;

                const resultItem = `
                    <div class="search-result-item" onclick="selectProductFromSearch(${product.id}, '${product.barcode}')">
                        <div style="display: flex; align-items: center;">
                            ${imageHtml}
                            <div class="search-result-info">
                                <h4>${product.name}</h4>
                                <p>
                                    <i class="fas fa-barcode"></i> ${product.barcode} |
                                    <i class="fas fa-tag"></i> ${formatNumber(product.selling_price)} دینار
                                </p>
                            </div>
                        </div>
                    </div>
                `;
                resultsContainer.append(resultItem);
            });
        }

        function selectProductFromSearch(productId, barcode) {
            if (barcode) {
                $.ajax({
                    url: '/products/search-by-barcode-sells',
                    type: 'POST',
                    data: { barcode, _token: '<?php echo e(csrf_token()); ?>' },
                    success: function(response) {
                        if (response.success && response.product) {
                          
                            addToCart(response.product);
                            $('#name-search').val('');
                            $('#name-search-results').hide();
                            $('#barcode-search').focus();
                        } else {
                            showAlert('error', 'کاڵا نەدۆزرایەوە');
                        }
                    },
                    error: () => showAlert('error', 'هەڵەیەک ڕوویدا')
                });
            } else {
                showAlert('error', 'بارکۆدی کاڵا نەدۆزرایەوە');
            }
        }

        // ==================== INVOICE SEARCH FUNCTIONS ====================
        function searchByInvoice(invoiceNumber) {
            if (!invoiceNumber || invoiceNumber.trim() === '') {
                return;
            }
            
            $.ajax({
                url: '/returns/search-by-invoice',
                type: 'POST',
                data: {
                    invoice_number: invoiceNumber,
                    _token: '<?php echo e(csrf_token()); ?>'
                },
                beforeSend: function() {
                    $('#invoice-search').prop('disabled', true).addClass('loading');
                },
                success: function(response) {
                    if (response.success && response.sales?.length > 0) {
                        showInvoiceSearchResults(response.sales);
                    } else if (response.success && response.is_credit_only && response.credit_info) {
                        showCreditOnlyInvoice(response.credit_info);
                    } else {
                        $('#invoice-search-results').hide();
                        showAlert('error', 'هیچ پسوڵەیەک نەدۆزرایەوە', '❌ نەدۆزرایەوە');
                    }
                },
                error: function() {
                    showAlert('error', 'هەڵەیەک ڕوویدا لە کاتی گەڕاندا');
                    $('#invoice-search-results').hide();
                },
                complete: function() {
                    $('#invoice-search').prop('disabled', false).removeClass('loading');
                }
            });
        }

        function showCreditOnlyInvoice(creditInfo) {
            if (confirm(`ئەم پسوڵەیە بە قەرز کڕاوە!\n\nناوی کڕیار: ${creditInfo.customer_name}\nکۆی قەرز: ${formatNumber(creditInfo.total)} دینار\nکاتی گەڕانەوە: ${creditInfo.time_to_return}\n\nئایا دەتەوێت کاڵاکان زیاد بکەیت بۆ گەڕاندنەوە؟`)) {
                cart = [];
                setInvoiceInfo(creditInfo.sels_id || creditInfo.loan_id, creditInfo.total, {
                    customer_name: creditInfo.customer_name,
                    loan_id: creditInfo.loan_id,
                    sels_id: creditInfo.sels_id,
                    phone_number: creditInfo.phone_number,
                    time_to_return: creditInfo.time_to_return,
                    total: creditInfo.total,
                    credit_amount: creditInfo.total
                });

                if (creditInfo.sale_info && creditInfo.sale_info.items) {
                    let addedCount = 0;
                    let pendingRequests = creditInfo.sale_info.items.length;

                    showAlert('info', 'تکایە ڕاوەستە... کاڵاکان زیاد دەکرێن', '⏳ بەردەوامە');

                    creditInfo.sale_info.items.forEach(item => {
                        $.ajax({
                            url: '/products/search-by-barcode-sells',
                            type: 'POST',
                            data: {
                                barcode: item.barcode,
                                _token: '<?php echo e(csrf_token()); ?>'
                            },
                            success: function(response) {
                                if (response.success && response.product) {
                                    response.product.quantity = item.quantity_sold;
                                    addToCart(response.product);
                                    addedCount++;
                                }
                            },
                            error: function() {
                                showAlert('error', `هەڵە لە زیادکردنی ${item.name}`);
                            },
                            complete: function() {
                                pendingRequests--;
                                if (pendingRequests === 0) {
                                    showAlert('success',
                                        `${addedCount} کاڵا زیادکرا بۆ گەڕاندنەوە`,
                                        '✅ تەواو بوو'
                                    );
                                }
                            }
                        });
                    });
                }

                $('#invoice-search').val('');
                $('#invoice-search-results').hide();
                $('#barcode-search').focus();
            }
        }

        function showInvoiceSearchResults(sales) {
            const resultsContainer = $('#invoice-search-results');
            resultsContainer.empty().show();

            sales.forEach(sale => {
                const date = new Date(sale.created_at).toLocaleDateString('ku');
                const isCredit = sale.is_credit || false;
                const creditInfo = sale.credit_info;

                let creditBadge = '';
                if (isCredit && creditInfo) {
                    creditBadge = `
                        <div style="background: linear-gradient(135deg, #fef3c7, #fde68a); padding: 0.5rem; border-radius: 0.5rem; margin-bottom: 0.5rem; border-right: 3px solid #f59e0b;">
                            <i class="fas fa-hand-holding-usd" style="color: #f59e0b;"></i>
                            <strong style="color: #78350f;"> ئاگاداری! ئەم پسوڵەیە بە قەرز کڕاوە</strong>
                            <div style="font-size: 0.75rem; color: #92400e; margin-top: 0.25rem;">
                                کڕیار: ${creditInfo.customer_name} | کاتی گەڕانەوە: ${creditInfo.time_to_return}
                            </div>
                        </div>
                    `;
                }

                let itemsHtml = '';
                sale.items.forEach(item => {
                    itemsHtml += `
                        <div style="background: #f8fafc; padding: 0.5rem; margin: 0.25rem 0; border-radius: 0.5rem; border-right: 3px solid ${isCredit ? '#f59e0b' : 'var(--primary)'};">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span style="font-weight: 600;">${item.name}</span>
                                <span style="background: ${isCredit ? '#f59e0b' : 'var(--primary)'}; color: white; padding: 0.2rem 0.5rem; border-radius: 0.5rem; font-size: 0.8rem;">${item.quantity_sold} دانە</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin-top: 0.25rem; font-size: 0.8rem; color: #4b5563;">
                                <span>نرخ: ${formatNumber(item.selling_price)} د.ع</span>
                                <span>کۆ: ${formatNumber(item.total)} د.ع</span>
                            </div>
                        </div>
                    `;
                });

                const resultItem = `
                    <div class="search-result-item" style="display: block; padding: 1rem;" onclick="selectInvoice('${sale.invoice_number}', ${JSON.stringify(sale).replace(/"/g, '&quot;')}, ${isCredit}, ${JSON.stringify(creditInfo).replace(/"/g, '&quot;')})">
                        <div class="search-result-info" style="width: 100%;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                <h4 style="color: var(--primary); margin: 0;">
                                    <i class="fas fa-file-invoice"></i> ${sale.invoice_number}
                                </h4>
                                <span style="background: var(--info); color: white; padding: 0.2rem 0.5rem; border-radius: 0.5rem; font-size: 0.8rem;">
                                    <i class="fas fa-calendar"></i> ${date}
                                </span>
                            </div>

                            ${creditBadge}

                            <div class="invoice-summary-card" style="background: linear-gradient(135deg, #f8fafc, #f1f5f9); border-radius: 1rem; padding: 1rem; margin: 0.5rem 0; border: 2px solid ${isCredit ? '#f59e0b' : 'var(--primary)'};">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                                    <span><i class="fas fa-boxes"></i> ژمارەی کاڵا: <strong>${sale.items_count}</strong></span>
                                    <span><i class="fas fa-money-bill-wave"></i> کۆی گشتی: <strong style="color: var(--success);">${formatNumber(sale.total)} د.ع</strong></span>
                                </div>

                                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 0.5rem; margin-top: 0.5rem;">
                                    <div style="background: white; padding: 0.5rem; border-radius: 0.5rem; text-align: center; border: 1px solid var(--border-color);">
                                        <div style="font-size: 0.7rem; color: #64748b;">پێش داشکان</div>
                                        <div style="font-size: 0.9rem; font-weight: 700; color: var(--info);">${formatNumber(sale.subtotal)}</div>
                                    </div>
                                    <div style="background: white; padding: 0.5rem; border-radius: 0.5rem; text-align: center; border: 1px solid var(--border-color);">
                                        <div style="font-size: 0.7rem; color: #64748b;">داشکان</div>
                                        <div style="font-size: 0.9rem; font-weight: 700; color: var(--warning);">${formatNumber(sale.discount)}</div>
                                    </div>
                                    <div style="background: white; padding: 0.5rem; border-radius: 0.5rem; text-align: center; border: 1px solid var(--border-color);">
                                        <div style="font-size: 0.7rem; color: #64748b;">کۆتایی</div>
                                        <div style="font-size: 0.9rem; font-weight: 700; color: var(--success);">${formatNumber(sale.total)}</div>
                                    </div>
                                </div>
                            </div>

                            <div style="margin-top: 0.5rem;">
                                <strong style="display: block; margin-bottom: 0.5rem; color: var(--text);">
                                    <i class="fas fa-list"></i> کاڵاکان:
                                </strong>
                                ${itemsHtml}
                            </div>

                            <div style="margin-top: 0.5rem; text-align: center; color: ${isCredit ? '#f59e0b' : 'var(--primary)'}; font-size: 0.8rem;">
                                <i class="fas fa-hand-pointer"></i> کلیک بکە بۆ زیادکردنی هەموو کاڵاکان
                            </div>
                        </div>
                    </div>
                `;
                resultsContainer.append(resultItem);
            });
        }

        function selectInvoice(invoiceNumber, saleData, isCredit, creditInfo) {
            const warningMessage = isCredit ?
                `⚠️ ئاگاداری! ئەم پسوڵەیە بە قەرز کڕاوە!\n\nکڕیار: ${creditInfo?.customer_name}\nکۆی قەرز: ${formatNumber(saleData.total)} د.ع\nکاتی گەڕانەوە: ${creditInfo?.time_to_return}\n\nئایا دڵنیایت کە دەتەوێت کاڵاکان بگەڕێنیتەوە؟` :
                `دڵنیایت کە دەتەوێت هەموو کاڵاکانی پسوڵەی ${invoiceNumber} زیاد بکەیت بۆ گەڕاندنەوە؟\n\nکۆی گشتی: ${formatNumber(saleData.total)} د.ع\nژمارەی کاڵا: ${saleData.items_count}`;

            if (confirm(warningMessage)) {
                cart = [];

                if (isCredit && creditInfo) {
                    setInvoiceInfo(invoiceNumber, saleData.total, {
                        customer_name: creditInfo.customer_name,
                        loan_id: creditInfo.loan_id,
                        sels_id: creditInfo.sels_id,
                        phone_number: creditInfo.phone_number,
                        time_to_return: creditInfo.time_to_return,
                        total: saleData.total,
                        credit_amount: saleData.total
                    });
                } else {
                    setInvoiceInfo(invoiceNumber, saleData.total, null);
                }

                let addedCount = 0;
                let pendingRequests = saleData.items.length;

                showAlert('info', 'تکایە ڕاوەستە... کاڵاکان زیاد دەکرێن', '⏳ بەردەوامە');

                saleData.items.forEach(item => {
                    $.ajax({
                        url: '/products/search-by-barcode-sells',
                        type: 'POST',
                        data: {
                            barcode: item.barcode,
                            _token: '<?php echo e(csrf_token()); ?>'
                        },
                        success: function(response) {
                            if (response.success && response.product) {
                                response.product.quantity = item.quantity_sold;
                                addToCart(response.product);
                                addedCount++;
                            }
                        },
                        error: function() {
                            showAlert('error', `هەڵە لە زیادکردنی ${item.name}`);
                        },
                        complete: function() {
                            pendingRequests--;
                            if (pendingRequests === 0) {
                                const creditMessage = isCredit ?
                                    `⚠️ ئاگاداری! ئەم کاڵایانە لە پسوڵەی قەرزەوە گەڕێنراوەتەوە` :
                                    `${addedCount} کاڵا لە کۆی ${saleData.items.length} زیادکرا بۆ گەڕاندنەوە`;

                                showAlert(isCredit ? 'warning' : 'success',
                                    `${creditMessage}\nکۆی گشتی: ${formatNumber(saleData.total)} د.ع`,
                                    isCredit ? '💰 گەڕاندنەوەی قەرز' : '✅ تەواو بوو'
                                );
                            }
                        }
                    });
                });

                $('#invoice-search').val('');
                $('#invoice-search-results').hide();
                $('#barcode-search').focus();
            }
        }

        // ==================== RETURN COMPLETION ====================
        function completeReturn(withPrint = false) {
            if (cart.length === 0) {
                showAlert('error', 'هیچ کاڵایەک بۆ گەڕاندنەوە زیاد نەکراوە');
                return;
            }

            const reason = $('#stock-reason').val();
            if (!reason) {
                showAlert('error', 'تکایە هۆکاری گەڕاندنەوە دیاری بکە', '❌ هۆکار دیاری نەکراوە');
                $('.reason-container').css('border-color', 'var(--danger)');
                setTimeout(() => $('.reason-container').css('border-color', '#f59e0b'), 2000);
                return;
            }

            const subtotal = cart.reduce((sum, item) => sum + item.total, 0);
            const finalTotal = subtotal;
            const customReason = $('#custom-reason').val();

            const items = cart.map(item => ({
                id: item.id,
                quantity: item.quantity,
                price: item.price
            }));

            const formData = new FormData();
            formData.append('items', JSON.stringify(items));
            formData.append('subtotal', subtotal);
            formData.append('discount', 0);
            formData.append('total', finalTotal);
            formData.append('reason', reason);
            formData.append('custom_reason', customReason || '');
            formData.append('invoice_number', currentInvoiceNumber || '');
            formData.append('is_credit_return', currentCreditInfo ? '1' : '0');

            if (currentCreditInfo) {
                formData.append('credit_loan_id', currentCreditInfo.loan_id || currentCreditInfo.sels_id || '');
                formData.append('credit_customer_name', currentCreditInfo.customer_name || '');
            }
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

            $.ajax({
                url: '/returns/store',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('.btn').prop('disabled', true);
                    showAlert('info', 'تۆمارکردنی گەڕاندنەوە...', '⏳ تکایە ڕاوەستە');
                },
                success: function(response) {
                    if (response.success) {
                        const creditMessage = currentCreditInfo ?
                            'ئاگاداری! گەڕاندنەوە بۆ پسوڵەی قەرز تۆمارکرا' :
                            'گەڕاندنەوە بە سەرکەوتوویی تۆمارکرا';

                        showAlert(currentCreditInfo ? 'warning' : 'success', response.message, currentCreditInfo ? '💰 گەڕاندنەوەی قەرز' : '✅ سەرکەوتوو بوو');

                        if (withPrint) {
                            printReturn({
                                return_number: response.return_number || '73859',
                                items: cart,
                                reason: reason,
                                customReason: customReason,
                                is_credit: currentCreditInfo ? true : false,
                                credit_info: currentCreditInfo
                            });
                        }

                        cart = [];
                        clearInvoiceInfo();
                        $('#stock-reason').val('');
                        $('#custom-reason').val('').parent().removeClass('show');
                        $('.reason-option').removeClass('selected');
                        clearReturnFromLocalStorage();
                        renderCart();
                        $('#barcode-search').focus();
                    }
                },
                error: function(xhr) {
                    let errorMsg = 'هەڵەیەک ڕوویدا';
                    if (xhr.status === 419) {
                        errorMsg = 'CSRF token validation failed. Refreshing page...';
                        setTimeout(() => location.reload(), 2000);
                    } else if (xhr.status === 422) {
                        try {
                            const response = JSON.parse(xhr.responseText);
                            errorMsg = Object.values(response.errors || {}).flat().join(', ');
                        } catch (e) {
                            errorMsg = 'Validation error';
                        }
                    } else if (xhr.status === 404) {
                        errorMsg = 'پسوڵەکە نەدۆزرایەوە';
                    }
                    showAlert('error', errorMsg, '❌ هەڵە');
                },
                complete: () => $('.btn').prop('disabled', false)
            });
        }

        // ==================== PRINT FUNCTION ====================
        function printReturn(returnData) {
            const now = new Date();
            const formattedDate = `${now.getDate()}/${now.getMonth() + 1}/${now.getFullYear()}`;
            const formattedTime = `${now.getHours()}:${now.getMinutes()}:${now.getSeconds()}`;

            $('#print-date').text(formattedDate);
            $('#print-time').text(formattedTime);
            $('#print-voucher').text(returnData.return_number || '73859');

            let tableBody = '';
            let subtotal = 0;

            cart.forEach((item, index) => {
                const total = item.price * item.quantity;
                subtotal += total;
                tableBody += `
                    <tr>
                        <td style="text-align: center;">${index + 1}</td>
                        <td style="text-align: right;">${item.name}</td>
                        <td style="text-align: center;">${item.quantity}</td>
                        <td style="text-align: center;">${formatNumber(item.price)}</td>
                        <td style="text-align: center;">${formatNumber(total)}</td>
                    </tr>
                `;
            });

            $('#print-table-body').html(tableBody);
            $('#print-subtotal').text(formatNumber(subtotal));
            $('#print-discount').text('0');
            $('#print-total').text(formatNumber(subtotal));

            $('#print-section').addClass('print-show');
            setTimeout(() => {
                window.print();
                setTimeout(() => $('#print-section').removeClass('print-show'), 1000);
            }, 300);
        }

        // ==================== EVENT HANDLERS ====================
        $(document).ready(function() {
            // Auto-populate invoice search field from URL
            autoPopulateInvoiceSearch();
            
            // Load invoice from URL parameters
            loadInvoiceFromUrl().then(() => {
                // Then try to load from localStorage if cart is empty
                if (cart.length === 0) {
                    loadReturnFromLocalStorage();
                }
            });

            $('#barcode-search').on('input', function() {
                const barcode = $(this).val().trim();
                clearTimeout(searchDebounceTimer);
                searchDebounceTimer = setTimeout(() => {
                    if (barcode.length >= 3) searchByBarcode(barcode);
                }, 500);
            });

            $('#name-search').on('input', function() {
                const name = $(this).val().trim();
                if (name.length === 0) {
                    $('#name-search-results').hide();
                    return;
                }
                clearTimeout(searchDebounceTimer);
                searchDebounceTimer = setTimeout(() => {
                    if (name.length >= 2) searchByName(name);
                }, 500);
            });

            $('#invoice-search').on('input', function() {
                const invoiceNumber = $(this).val().trim();
                if (invoiceNumber.length === 0) {
                    $('#invoice-search-results').hide();
                    return;
                }
                clearTimeout(searchDebounceTimer);
                searchDebounceTimer = setTimeout(() => {
                    if (invoiceNumber.length >= 1) searchByInvoice(invoiceNumber);
                }, 500);
            });

            $(document).on('click', function(e) {
                if (!$(e.target).closest('#name-search, #name-search-results, #invoice-search, #invoice-search-results').length) {
                    $('#name-search-results').hide();
                    $('#invoice-search-results').hide();
                }
            });

            $(document).on('click', '.decrease', function() {
                const index = $(this).data('index');
                const input = $(`input.quantity-input[data-index="${index}"]`);
                const newQuantity = parseInt(input.val()) - 1;
                if (updateQuantity(index, newQuantity)) input.val(newQuantity);
            });

            $(document).on('click', '.increase', function() {
                const index = $(this).data('index');
                const input = $(`input.quantity-input[data-index="${index}"]`);
                const newQuantity = parseInt(input.val()) + 1;
                if (updateQuantity(index, newQuantity)) input.val(newQuantity);
            });

            $(document).on('change', '.quantity-input', function() {
                const index = $(this).data('index');
                const newQuantity = parseInt($(this).val()) || 1;
                if (!updateQuantity(index, newQuantity)) {
                    $(this).val(cart[index]?.quantity || 1);
                }
            });

            $(document).on('click', '.delete-btn', function() {
                removeFromCart($(this).data('index'));
            });

            $('#custom-reason').on('input', function() {
                saveReturnToLocalStorage();
            });

            $(document).on('keydown', function(e) {
                if (e.key === 'F1') {
                    e.preventDefault();
                    $('#barcode-search').focus().select();
                    showAlert('info', 'بەخێربێیت بۆ گەڕاندنەوە', '⌨️ F1');
                }
                if (e.key === 'F2') {
                    e.preventDefault();
                    $('#name-search').focus().select();
                    showAlert('info', 'بە ناو بگەرە', '⌨️ F2');
                }
                if (e.key === 'F3') {
                    e.preventDefault();
                    $('#invoice-search').focus().select();
                    showAlert('info', 'بە ژمارەی پسوڵە بگەرە', '⌨️ F3');
                }
                if (e.key === 'F5') {
                    e.preventDefault();
                    completeReturn(false);
                }
                if (e.key === 'F6') {
                    e.preventDefault();
                    completeReturn(true);
                }
                if (e.key === 'F8') {
                    e.preventDefault();
                    clearCart();
                }
                if (e.key === 'Escape') {
                    $('#name-search-results').hide();
                    $('#invoice-search-results').hide();
                }
            });

            $('#barcode-search').focus();
            calculateTotals();
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeImageModal();
            if (e.key === 'ArrowLeft' && document.getElementById('imageModal').style.display === 'block') {
                showPrevImage();
            }
            if (e.key === 'ArrowRight' && document.getElementById('imageModal').style.display === 'block') {
                showNextImage();
            }
        });

        document.getElementById('imageModal')?.addEventListener('click', function(e) {
            if (e.target === this) closeImageModal();
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamnp64\www\mobileHardy\resources\views/items/items-return.blade.php ENDPATH**/ ?>