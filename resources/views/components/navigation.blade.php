<!DOCTYPE html>
<html lang="ku">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سیستەمی بەڕێوەبردنی</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        :root {
            --primary-color: #1a365d;
            --primary-light: #2d4a7d;
            --secondary-color: #3182ce;
            --success-color: #38a169;
            --warning-color: #d69e2e;
            --danger-color: #e53e3e;
            --info-color: #00b5d8;
            --light-gray: #edf2f7;
            --dark-gray: #1a365d;
            --sidebar-width: 280px;
            --sidebar-collapsed-width: 70px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Noto Sans Arabic', sans-serif;
            background-color: #f8f9fa;
            color: #333;
            overflow-x: hidden;
            direction: rtl;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            right: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--primary-color) 0%, #2d3748 100%);
            color: white;
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar-header {
            padding: 20px 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo-icon {
            font-size: 24px;
            margin-left: 10px;
        }

        .logo-text {
            font-size: 18px;
            font-weight: 600;
            white-space: nowrap;
        }

        .sidebar.collapsed .logo-text {
            display: none;
        }

        .toggle-btn {
            background: none;
            border: none;
            color: white;
            font-size: 18px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .sidebar.collapsed .toggle-btn {
            transform: rotate(180deg);
        }

        .sidebar-menu {
            padding: 20px 0;
            height: calc(100vh - 70px);
            overflow-y: auto;
        }

        .sidebar-menu ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu li {
            position: relative;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
            border-right: 3px solid var(--secondary-color);
        }

        .sidebar-menu a i {
            font-size: 16px;
            margin-left: 15px;
            width: 20px;
            text-align: center;
        }

        .sidebar.collapsed .sidebar-menu a span {
            display: none;
        }

        .sidebar.collapsed .sidebar-menu a {
            justify-content: center;
        }

        .sidebar.collapsed .sidebar-menu a i {
            margin-left: 0;
        }

        .menu-title {
            padding: 15px 20px 5px 20px;
            font-size: 12px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.5);
            font-weight: 600;
            letter-spacing: 1px;
        }

        .sidebar.collapsed .menu-title {
            display: none;
        }

        /* Dropdown Styles */
        .has-dropdown {
            position: relative;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
        }

        .dropdown-arrow {
            font-size: 12px;
            transition: transform 0.3s ease;
            margin-left: auto;
            margin-right: 5px;
        }

        .dropdown-menu {
            background-color: rgba(0, 0, 0, 0.4);
            border-right: 3px solid var(--secondary-color);
            overflow: hidden;
            max-height: 0;
            transition: max-height 0.3s ease;
            position: relative;
        }

        .dropdown-menu.active {
            max-height: 500px;
        }

        .dropdown-menu li {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .dropdown-menu a {
            padding: 10px 20px 10px 40px;
            font-size: 14px;
            border-right: none !important;
            background-color: transparent;
        }

        .dropdown-menu a:hover {
            background-color: rgba(255, 255, 255, 0.15);
            border-right: none;
        }

        .dropdown-menu a i {
            font-size: 12px;
        }

        .sidebar.collapsed .dropdown-menu {
            display: none !important;
        }

        .sidebar.collapsed .has-dropdown .dropdown-arrow {
            display: none;
        }

        .sidebar-menu > ul > li {
            position: relative;
        }

        .sidebar-menu > ul > li.open-dropdown {
            z-index: 10;
        }

        .open-dropdown .dropdown-menu {
            z-index: 20;
        }

        /* Main Content Styles */
        .main-content {
            margin-right: var(--sidebar-width);
            padding: 20px;
            transition: all 0.3s ease;
            min-height: 100vh;
        }

        .main-content.expanded {
            margin-right: var(--sidebar-collapsed-width);
        }

        /* Main Content Area Styles */
        #mainContentArea {
            width: 100%;
        }

        /* Topbar Styles */
        .topbar {
            background: linear-gradient(180deg, var(--primary-color) 0%, #2d3748 100%);
            padding: 15px 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }

        .search-box {
            position: relative;
            width: 300px;
        }

        .search-box input {
            width: 100%;
            padding: 10px 40px 10px 15px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 25px;
            font-size: 14px;
            transition: all 0.3s ease;
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .search-box input:focus {
            outline: none;
            border-color: rgba(255, 255, 255, 0.5);
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.1);
        }

        .search-box input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.7);
        }

        .user-info {
            display: flex;
            align-items: center;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--secondary-color) 0%, #4a9cdf 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: white;
            margin-left: 10px;
        }

        .notification-bell {
            position: relative;
            margin-left: 20px;
            font-size: 18px;
            color: rgba(255, 255, 255, 0.9);
            cursor: pointer;
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: var(--danger-color);
            color: white;
            font-size: 10px;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Stats Cards */
        .stats-card {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
            transition: transform 0.3s ease;
            border-right: 4px solid;
            position: relative;
            overflow: hidden;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .stats-card.primary {
            border-right-color: var(--primary-color);
        }

        .stats-card.success {
            border-right-color: var(--success-color);
        }

        .stats-card.warning {
            border-right-color: var(--warning-color);
        }

        .stats-card.danger {
            border-right-color: var(--danger-color);
        }

        .stats-card.info {
            border-right-color: var(--info-color);
        }

        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
            margin-bottom: 15px;
            position: absolute;
            left: 20px;
            top: 20px;
        }

        .stats-icon.primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
        }

        .stats-icon.success {
            background: linear-gradient(135deg, var(--success-color) 0%, #48bb78 100%);
        }

        .stats-icon.warning {
            background: linear-gradient(135deg, var(--warning-color) 0%, #ed8936 100%);
        }

        .stats-icon.danger {
            background: linear-gradient(135deg, var(--danger-color) 0%, #fc8181 100%);
        }

        .stats-icon.info {
            background: linear-gradient(135deg, var(--info-color) 0%, #0bc5ea 100%);
        }

        .stats-title {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
            font-weight: 500;
            text-align: right;
        }

        .stats-value {
            font-size: 28px;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
            text-align: right;
        }

        .stats-subtitle {
            font-size: 12px;
            color: #888;
            text-align: right;
        }

        .stats-trend {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            margin-top: 10px;
            font-size: 12px;
        }

        .trend-up {
            color: var(--success-color);
        }

        .trend-down {
            color: var(--danger-color);
        }

        /* Quick Actions */
        .quick-actions {
            background-color: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--light-gray);
        }

        .section-title i {
            margin-left: 10px;
            color: var(--secondary-color);
        }

        .action-buttons {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
        }

        .action-btn {
            display: flex;
            align-items: center;
            padding: 15px;
            background-color: var(--light-gray);
            border: none;
            border-radius: 8px;
            color: var(--primary-color);
            font-weight: 500;
            transition: all 0.3s ease;
            cursor: pointer;
            text-align: right;
        }

        .action-btn:hover {
            background-color: var(--secondary-color);
            color: white;
            transform: translateX(-5px);
        }

        .action-btn i {
            margin-left: 10px;
            font-size: 18px;
        }

        /* Table Container */
        .table-container {
            background-color: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
            overflow: hidden;
        }

        .table-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .table {
            margin-bottom: 0;
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table th {
            border-top: none;
            font-weight: 700;
            color: var(--primary-color);
            font-size: 14px;
            text-align: right;
            padding: 15px;
            background-color: var(--light-gray);
            border-bottom: 2px solid #e2e8f0;
        }

        .table td {
            vertical-align: middle;
            border-top: 1px solid #f1f1f1;
            padding: 12px 15px;
            text-align: right;
        }

        .table tbody tr:hover {
            background-color: #f7fafc;
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            display: inline-block;
        }

        .status-badge.in-stock {
            background-color: rgba(56, 161, 105, 0.1);
            color: var(--success-color);
        }

        .status-badge.low-stock {
            background-color: rgba(214, 158, 46, 0.1);
            color: var(--warning-color);
        }

        .status-badge.out-of-stock {
            background-color: rgba(229, 62, 62, 0.1);
            color: var(--danger-color);
        }

        .action-btns {
            display: flex;
            gap: 5px;
        }

        .action-btns button {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-edit {
            background-color: rgba(49, 130, 206, 0.1);
            color: var(--secondary-color);
        }

        .btn-edit:hover {
            background-color: var(--secondary-color);
            color: white;
        }

        .btn-delete {
            background-color: rgba(229, 62, 62, 0.1);
            color: var(--danger-color);
        }

        .btn-delete:hover {
            background-color: var(--danger-color);
            color: white;
        }

        .btn-view {
            background-color: rgba(56, 161, 105, 0.1);
            color: var(--success-color);
        }

        .btn-view:hover {
            background-color: var(--success-color);
            color: white;
        }

        /* Recent Activity */
        .activity-list {
            list-style: none;
            padding: 0;
        }

        .activity-item {
            display: flex;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #f1f1f1;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 15px;
            color: white;
            font-size: 14px;
        }

        .activity-icon.success {
            background-color: var(--success-color);
        }

        .activity-icon.warning {
            background-color: var(--warning-color);
        }

        .activity-icon.danger {
            background-color: var(--danger-color);
        }

        .activity-icon.info {
            background-color: var(--info-color);
        }

        .activity-content {
            flex: 1;
        }

        .activity-title {
            font-weight: 500;
            margin-bottom: 3px;
        }

        .activity-time {
            font-size: 12px;
            color: #888;
        }

        /* Chart Container */
        .chart-container {
            background-color: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
        }

        .chart-placeholder {
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f7fafc;
            border-radius: 8px;
            color: #a0aec0;
            font-size: 14px;
            text-align: center;
            padding: 20px;
        }

        /* Welcome Banner */
        .welcome-banner {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            border-radius: 10px;
            padding: 30px;
            color: white;
            margin-bottom: 25px;
            position: relative;
            overflow: hidden;
        }

        .welcome-banner::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
        }

        .welcome-title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .welcome-subtitle {
            font-size: 14px;
            opacity: 0.9;
            margin-bottom: 20px;
        }

        .welcome-icon {
            position: absolute;
            left: 30px;
            bottom: 30px;
            font-size: 80px;
            opacity: 0.2;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                width: var(--sidebar-collapsed-width);
            }

            .sidebar:not(.collapsed) {
                width: var(--sidebar-width);
            }

            .main-content {
                margin-right: var(--sidebar-collapsed-width);
            }

            .main-content.expanded {
                margin-right: var(--sidebar-width);
            }

            .search-box {
                width: 200px;
            }

            .action-buttons {
                grid-template-columns: 1fr;
            }

            .stats-card {
                padding: 15px;
            }

            .stats-icon {
                width: 50px;
                height: 50px;
                font-size: 20px;
            }

            .stats-value {
                font-size: 24px;
            }
        }

        @media (max-width: 576px) {
            .topbar {
                flex-direction: column;
                gap: 15px;
            }

            .search-box {
                width: 100%;
            }

            .user-info {
                width: 100%;
                justify-content: space-between;
            }

            .stats-card {
                margin-bottom: 15px;
            }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 5px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--secondary-color);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-color);
        }

        /* Grid System */
        .row {
            display: flex;
            flex-wrap: wrap;
            margin-left: -10px;
            margin-right: -10px;
        }

        .col {
            padding-left: 10px;
            padding-right: 10px;
            flex: 1;
        }

        .col-12 { flex: 0 0 100%; max-width: 100%; }
        .col-6 { flex: 0 0 50%; max-width: 50%; }
        .col-4 { flex: 0 0 33.333%; max-width: 33.333%; }
        .col-3 { flex: 0 0 25%; max-width: 25%; }
        .col-8 { flex: 0 0 66.666%; max-width: 66.666%; }
        .col-9 { flex: 0 0 75%; max-width: 75%; }

        /* Buttons */
        .btn {
            padding: 8px 16px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: var(--secondary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-color);
        }

        .btn-outline-primary {
            background-color: transparent;
            border: 1px solid var(--secondary-color);
            color: var(--secondary-color);
        }

        .btn-outline-primary:hover {
            background-color: var(--secondary-color);
            color: white;
        }

        /* Badges */
        .badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
        }

        .badge-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .badge-secondary {
            background-color: var(--secondary-color);
            color: white;
        }

        .badge-success {
            background-color: var(--success-color);
            color: white;
        }

        .hidden {
            display: none !important;
        }

        /* User Avatar in Sidebar */
        .sidebar-user {
            padding: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-user .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--secondary-color) 0%, #4a9cdf 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: white;
            font-size: 18px;
        }

        .sidebar-user .user-name {
            font-weight: 600;
            color: white;
        }

        .sidebar-user .user-role {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.7);
        }

        .sidebar.collapsed .sidebar-user {
            padding: 15px 5px;
        }

        .sidebar.collapsed .sidebar-user .user-details {
            display: none;
        }

        /* Loading Spinner */
        .loading-spinner {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }

        .loading-spinner.active {
            display: flex;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid var(--secondary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <!-- Loading Spinner -->
    <div class="loading-spinner" id="loadingSpinner">
        <div class="spinner"></div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo">
                <div class="logo-text px-2">سیستەمی بەڕێوەبردنی</div>
                <div class="logo-icon">
                    <i class="fas fa-warehouse"></i>
                </div>
            </div>
            <button class="toggle-btn" id="toggleSidebar">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>

        <div class="sidebar-user border-bottom">
            <div class="d-flex align-items-center">
                <!-- Avatar -->
                <div class="user-avatar bg-primary text-white rounded-circle d-flex justify-content-center align-items-center" style="width:40px; height:40px; font-weight:bold;">
                    {{ Auth::user()->name[0] }}
                </div>

                <!-- User Details -->
                <div class="user-details mr-2" style="margin-left: 12px;">
                    <div class="user-name" style="font-weight: bold; font-size: 14px;">{{ Auth::user()->name }}</div>
                    <div class="user-role" style="font-size: 12px; color: #6c757d;">Administrator</div>
                </div>

                <!-- Dropdown -->
                <div class="dropdown mr-auto" style="margin-left: auto; position: relative;">
                    <button class="btn btn-sm btn-light" id="menuseetingBtn" style="
                        background: #f8f9fa;
                        border: 1px solid #dee2e6;
                        border-radius: 4px;
                        padding: 4px 8px;
                        cursor: pointer;
                    ">
                        <i id="menochar" class="fas fa-chevron-down" style="font-size: 10px;"></i>
                        <i class="fas fa-ellipsis-v" style="font-size: 10px; margin-left: 2px;"></i>
                    </button>

                    <div dir="rtl" id="menuseeting" style="
                        display: none;
                        position: absolute;
                        right: 0;
                        top: calc(100% + 10px);
                        min-width: 170px;
                        background: #fff;
                        box-shadow: 0 2px 10px rgba(0,0,0,0.15);
                        border: 1px solid #dee2e6;
                        border-radius: 4px;
                        z-index: 1000;
                        overflow: hidden;
                        text-align: right;
                    ">
                        <!-- Profile -->
                        <a class="dropdown-item" href="{{ route('profile.edit') }}" style="
                            display: flex;
                            align-items: center;
                            padding: 8px 12px;
                            color: #212529;
                            text-decoration: none;
                            border-bottom: 1px solid #f1f1f1;
                            transition: background-color 0.2s;
                        ">
                            <i class="fas fa-user" style="width: 20px; margin-left: 8px;"></i>
                            پروفایل
                        </a>

                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger" style="
                                display: flex;
                                align-items: center;
                                width: 100%;
                                padding: 8px 12px;
                                color: #dc3545;
                                background: none;
                                border: none;
                                text-align: right;
                                cursor: pointer;
                                transition: background-color 0.2s;
                            ">
                                <i class="fas fa-sign-out-alt" style="width: 20px; margin-left: 8px;"></i>
                                چوونە دەرەوە
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="sidebar-menu">
            <ul>
                <li class="menu-title">داشبۆرد</li>
                <li>
                    <a href="#" class="active" data-page="dashboard">
                        <span>داشبۆردی سەرەکی</span>
                        <i class="fas fa-home"></i>
                    </a>
                </li>

                <li class="menu-title">کۆگا</li>
                <li id="warehouseListItem">
                    <a href="#" class="has-dropdown" id="warehouseDropdown">
                        <span>بەڕێوەبردنی کۆگا</span>
                        <i class="fas fa-warehouse"></i>
                        <i class="fas fa-chevron-down dropdown-arrowwarehous"></i>
                    </a>
                    <ul class="hidden" id="warehouseMenuu">
                        <li><a href="#" data-page="inventory-report">ڕاپۆرتی ڕەوشی کۆگا</a></li>
                        <li><a href="#" data-page="add-item">داخڵکردنی کاڵا بۆ کۆگا</a></li>
                        <li><a href="#" data-page="edit-item">گۆڕانکاری زانیارییەکانی کاڵا</a></li>
                        <li><a href="#" data-page="register-item">ناساندنی کاڵا بە سیستەم</a></li>
                        <li><a href="#" data-page="stock">ستۆك</a></li>
                        <li><a href="#" data-page="low-stock-report">ڕاپۆرتی کاڵاکانی کەم</a></li>
                        <li><a href="#" data-page="out-of-stock-report">ڕاپۆرتی کاڵاکانی تەواو</a></li>
                    </ul>
                </li>

                <li class="menu-title">کاشێر</li>
                <li id="cashierListItem">
                    <a href="#" class="has-dropdown" id="cashierDropdown">
                        <span>بەڕێوەبردنی کاشێر</span>
                        <i class="fas fa-calculator"></i>
                        <i class="fas fa-chevron-down dropdown-arrowcasher"></i>
                    </a>
                    <ul class="hidden" id="cashierMenuu">
                        <li><a href="#" data-page="cashier-summary">پوختەی حساباتی ڕۆژانەی کاشێر</a></li>
                        <li><a href="#" data-page="cashier-details">پێدانی ووردە بەکاشێر</a></li>
                        <li><a href="#" data-page="cashier-management">بەڕێوەبردنی کاشێرەکان</a></li>
                        <li><a href="#" data-page="cashier-shifts">گۆڕینی شێفتەکان</a></li>
                        <li><a href="#" data-page="cashier-transactions">مامەڵەکانی کاشێر</a></li>
                    </ul>
                </li>

                <li class="menu-title">فرۆشتن</li>
                <li id="salesListItem">
                    <a href="#" class="has-dropdown" id="salesDropdown">
                        <span>بەڕێوەبردنی فرۆشتن</span>
                        <i class="fas fa-shopping-cart"></i>
                        <i class="fas fa-chevron-down dropdown-arrowsales"></i>
                    </a>
                    <ul class="hidden" id="salesMenuu">
                        <li><a href="#" data-page="sales">فرۆشتن</a></li>
                        <li><a href="#" data-page="returns">گەڕاندنەوەی کاڵای فرۆشراو</a></li>
                        <li><a href="#" data-page="delete-invoice">سڕینەوەی پسوڵە</a></li>
                        <li><a href="#" data-page="sales-history">مێژووی فرۆشتن</a></li>
                        <li><a href="#" data-page="customer-management">بەڕێوەبردنی کڕیاران</a></li>
                        <li><a href="#" data-page="discounts">داڕشتن و داشکاندنەکان</a></li>
                    </ul>
                </li>

                <li class="menu-title">ڕاپۆرتەکان</li>
                <li id="reportsListItem">
                    <a href="#" class="has-dropdown" id="reportsDropdown">
                        <span>ڕاپۆرتەکان</span>
                        <i class="fas fa-chart-bar"></i>
                        <i class="fas fa-chevron-down dropdown-arrowreport"></i>
                    </a>
                    <ul class="hidden" id="reportsMenuu">
                        <li><a href="#" data-page="financial-reports">ڕاپۆرتە دارایییەکان</a></li>
                        <li><a href="#" data-page="sales-reports">ڕاپۆرتی فرۆشتن</a></li>
                        <li><a href="#" data-page="inventory-reports">ڕاپۆرتی کۆگا</a></li>
                        <li><a href="#" data-page="today-sales">کۆی گشتی فرۆشی ئەمڕۆ</a></li>
                        <li><a href="#" data-page="daily-reports">ڕاپۆرتی ڕۆژانە</a></li>
                        <li><a href="#" data-page="monthly-reports">ڕاپۆرتی مانگانە</a></li>
                        <li><a href="#" data-page="yearly-reports">ڕاپۆرتی ساڵانە</a></li>
                    </ul>
                </li>

                <li class="menu-title">ڕێکخستنەکان</li>
                <li>
                    <a href="#" data-page="settings">
                        <span>ڕێکخستنەکان</span>
                        <i class="fas fa-cog"></i>
                    </a>
                </li>
                <li>
                    <a href="#" data-page="users">
                        <span>بەڕێوەبردنی بەکارهێنەران</span>
                        <i class="fas fa-users"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Main Content Area -->
        <div id="mainContentArea">
            <!-- Page content will be loaded here -->

            <!-- Initial Content (Dashboard) -->

@yield("content")

            <!-- Stats Cards -->


            <!-- Recent Sales Table -->

            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // ======================= GLOBAL VARIABLES =======================
        const menuseetingBtn = document.querySelector("#menuseetingBtn");
        const menuseeting = document.querySelector("#menuseeting");
        const menochar = document.querySelector("#menochar");
        const loadingSpinner = document.getElementById('loadingSpinner');

        // ======================= USER MENU DROPDOWN =======================
        let isMenuOpen = false;

        function slideDown(el, duration = 200) {
            if (el.style.display === "block") return;

            el.style.display = "block";
            el.style.overflow = "hidden";
            el.style.opacity = "0";

            const height = el.scrollHeight;
            el.style.height = "0px";

            requestAnimationFrame(() => {
                el.style.transition = `
                    height ${duration}ms ease,
                    opacity ${duration}ms ease
                `;
                el.style.height = height + "px";
                el.style.opacity = "1";
            });

            setTimeout(() => {
                el.style.height = "auto";
                el.style.overflow = "visible";
            }, duration);
        }

        function slideUp(el, duration = 200) {
            if (el.style.display === "none") return;

            const height = el.scrollHeight;
            el.style.height = height + "px";
            el.style.overflow = "hidden";

            requestAnimationFrame(() => {
                el.style.transition = `
                    height ${duration}ms ease,
                    opacity ${duration}ms ease
                `;
                el.style.height = "0px";
                el.style.opacity = "0";
            });

            setTimeout(() => {
                el.style.display = "none";
                el.style.transition = "";
                el.style.opacity = "";
                el.style.height = "";
            }, duration);
        }

        menuseetingBtn.addEventListener("click", function(e) {
            e.stopPropagation();
            if (!isMenuOpen) {
                slideDown(menuseeting, 200);
                isMenuOpen = true;
                menochar.classList.remove("fa-chevron-down");
                menochar.classList.add("fa-chevron-up");
            } else {
                slideUp(menuseeting, 200);
                isMenuOpen = false;
                menochar.classList.remove("fa-chevron-up");
                menochar.classList.add("fa-chevron-down");
            }
        });

        // Close menu when clicking outside
        document.addEventListener("click", function(e) {
            if (isMenuOpen && !menuseeting.contains(e.target) && e.target !== menuseetingBtn) {
                slideUp(menuseeting, 200);
                isMenuOpen = false;
                menochar.classList.remove("fa-chevron-up");
                menochar.classList.add("fa-chevron-down");
            }
        });

        // Close with Escape key
        document.addEventListener("keydown", function(e) {
            if (e.key === "Escape" && isMenuOpen) {
                slideUp(menuseeting, 200);
                isMenuOpen = false;
                menochar.classList.remove("fa-chevron-up");
                menochar.classList.add("fa-chevron-down");
            }
        });

        // ======================= SIDEBAR DROPDOWNS =======================
        function toggleDropdown(menu, arrow) {
            if (!menu) return;

            const duration = 300;
            const isHidden = menu.classList.contains('hidden');

            if (isHidden) {
                // OPEN
                menu.classList.remove('hidden');
                menu.style.height = '0px';
                menu.style.overflow = 'hidden';

                const fullHeight = menu.scrollHeight + 'px';

                requestAnimationFrame(() => {
                    menu.style.transition = `height ${duration}ms ease`;
                    menu.style.height = fullHeight;

                    if (arrow) {
                        arrow.style.transform = 'rotate(180deg)';
                    }
                });

                setTimeout(() => {
                    menu.style.height = '';
                    menu.style.overflow = '';
                }, duration);
            } else {
                // CLOSE
                const currentHeight = menu.scrollHeight + 'px';
                menu.style.height = currentHeight;
                menu.style.overflow = 'hidden';

                requestAnimationFrame(() => {
                    menu.style.transition = `height ${duration}ms ease`;
                    menu.style.height = '0px';

                    if (arrow) {
                        arrow.style.transform = 'rotate(0deg)';
                    }
                });

                setTimeout(() => {
                    menu.classList.add('hidden');
                    menu.style.height = '';
                    menu.style.overflow = '';
                    menu.style.transition = '';
                }, duration);
            }
        }

        // Setup dropdowns
        document.addEventListener('DOMContentLoaded', function() {
            // Warehouse dropdown
            const warehouseDropdown = document.getElementById('warehouseDropdown');
            const warehouseMenu = document.getElementById('warehouseMenuu');
            const warehouseArrow = document.querySelector('.dropdown-arrowwarehous');

            if (warehouseDropdown && warehouseMenu) {
                warehouseDropdown.addEventListener('click', function(e) {
                    e.preventDefault();
                    toggleDropdown(warehouseMenu, warehouseArrow);
                });
            }

            // Cashier dropdown
            const cashierDropdown = document.getElementById('cashierDropdown');
            const cashierMenu = document.getElementById('cashierMenuu');
            const cashierArrow = document.querySelector('.dropdown-arrowcasher');

            if (cashierDropdown && cashierMenu) {
                cashierDropdown.addEventListener('click', function(e) {
                    e.preventDefault();
                    toggleDropdown(cashierMenu, cashierArrow);
                });
            }

            // Sales dropdown
            const salesDropdown = document.getElementById('salesDropdown');
            const salesMenu = document.getElementById('salesMenuu');
            const salesArrow = document.querySelector('.dropdown-arrowsales');

            if (salesDropdown && salesMenu) {
                salesDropdown.addEventListener('click', function(e) {
                    e.preventDefault();
                    toggleDropdown(salesMenu, salesArrow);
                });
            }

            // Reports dropdown
            const reportsDropdown = document.getElementById('reportsDropdown');
            const reportsMenu = document.getElementById('reportsMenuu');
            const reportsArrow = document.querySelector('.dropdown-arrowreport');

            if (reportsDropdown && reportsMenu) {
                reportsDropdown.addEventListener('click', function(e) {
                    e.preventDefault();
                    toggleDropdown(reportsMenu, reportsArrow);
                });
            }
        });

        // ======================= PAGE LOADING FUNCTION =======================
        function showPage(pageName, event = null) {
            if (event && typeof event.preventDefault === 'function') {
                event.preventDefault();
            }

            console.log('Loading page:', pageName);

            // Show loading spinner
            if (loadingSpinner) {
                loadingSpinner.classList.add('active');
            }

            // Define page routes
            const pageRoutes = {
                'dashboard': '/',
                'inventory-report': '/inventory/report',
                'add-item': '/inventory/add',
                'edit-item': '/inventory/edit',
                'register_item': '/register-item',
                'stock': '/inventory/stock',
                'low-stock-report': '/inventory/low-stock',
                'out-of-stock-report': '/inventory/out-of-stock',
                'sales': '/sales',
                'returns': '/sales/returns',
                'delete-invoice': '/sales/delete-invoice',
                'sales-history': '/sales/history',
                'customer-management': '/customers',
                'discounts': '/discounts',
                'cashier-summary': '/cashier/summary',
                'cashier-details': '/cashier/details',
                'cashier-management': '/cashier/management',
                'cashier-shifts': '/cashier/shifts',
                'cashier-transactions': '/cashier/transactions',
                'financial-reports': '/reports/financial',
                'sales-reports': '/reports/sales',
                'inventory-reports': '/reports/inventory',
                'today-sales': '/reports/today-sales',
                'daily-reports': '/reports/daily',
                'monthly-reports': '/reports/monthly',
                'yearly-reports': '/reports/yearly',
                'settings': '/settings',
                'users': '/users'
            };

            const url = pageRoutes[pageName] || '/' + pageName;

            // Add timestamp to prevent caching
            const timestamp = new Date().getTime();
            const requestUrl = url + (url.includes('?') ? '&' : '?') + '_=' + timestamp;

            fetch(requestUrl, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html'
                },
                cache: 'no-cache'
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.text();
            })
            .then(html => {
                // Hide loading spinner
                if (loadingSpinner) {
                    loadingSpinner.classList.remove('active');
                }

                const main = document.getElementById('mainContentArea');
                if (main) {
                    main.innerHTML = html;

                    // Update active menu item
                    document.querySelectorAll('.sidebar-menu a').forEach(item => {
                        item.classList.remove('active');
                        if (item.getAttribute('data-page') === pageName) {
                            item.classList.add('active');
                        }
                    });

                    // Update browser history
                    history.pushState({ page: pageName, url: url }, '', url);

                    // Re-initialize event listeners for the loaded content
                    initializeContentEvents();
                } else {
                    console.error('mainContentArea element not found');
                }
            })
            .catch(error => {
                console.error('Error loading page:', error);

                // Hide loading spinner
                if (loadingSpinner) {
                    loadingSpinner.classList.remove('active');
                }

                const main = document.getElementById('mainContentArea');
                if (main) {
                    main.innerHTML = `
                        <div class="alert alert-danger" style="margin: 20px; padding: 20px;">
                            <h4>هەڵە لە بارکردنی پەیج</h4>
                            <p>پەیجی "${pageName}" نەتوانرا باربکرێت.</p>
                            <p class="small text-muted">${error.message}</p>
                            <button class="btn btn-primary mt-3" onclick="showPage('dashboard')">
                                <i class="fas fa-home"></i> گەڕانەوە بۆ داشبۆرد
                            </button>
                        </div>
                    `;
                }
            });
        }

        // ======================= EVENT DELEGATION FOR DATA-PAGE =======================
        function initializeContentEvents() {
            // Search functionality
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        alert('گەڕان بۆ: ' + this.value);
                        this.value = '';
                    }
                });
            }

            // Notification bell click
            const notificationBell = document.getElementById('notificationBell');
            if (notificationBell) {
                notificationBell.addEventListener('click', function() {
                    alert('تۆ ٥ ئاگاداری نوێت هەیە!');
                    const badge = document.querySelector('.notification-badge');
                    if (badge) {
                        badge.textContent = '0';
                    }
                });
            }

            // Re-attach data-page event listeners
            document.body.addEventListener('click', function(e) {
                let target = e.target;
                let pageName = null;

                while (target && target !== document.body) {
                    if (target.hasAttribute('data-page')) {
                        pageName = target.getAttribute('data-page');
                        break;
                    }
                    if (target.classList && target.classList.contains('action-btn')) {
                        const dataPage = target.getAttribute('data-page');
                        if (dataPage) {
                            pageName = dataPage;
                            break;
                        }
                    }
                    target = target.parentElement;
                }

                if (pageName) {
                    e.preventDefault();
                    showPage(pageName, e);
                }
            });
        }



        document.addEventListener('DOMContentLoaded', function() {
            // Initialize events for initial content
            initializeContentEvents();

            // Handle browser back/forward
            window.addEventListener('popstate', function(e) {
                if (e.state && e.state.page) {
                    showPage(e.state.page);
                }
            });

            // Set initial state

        });

        // ======================= SIDEBAR TOGGLE =======================
        function handleSidebarByWidth() {
            const windowLength = window.innerWidth;
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');

            if (windowLength < 1040) {
                if (sidebar) sidebar.classList.add('collapsed');
                if (mainContent) mainContent.classList.add('expanded');

                if (menuseetingBtn) menuseetingBtn.style.display = 'none';

                // Hide dropdown arrows when collapsed
                const arrows = document.querySelectorAll('.dropdown-arrow');
                arrows.forEach(arrow => {
                    arrow.style.display = 'none';
                });
            } else {
                if (sidebar) sidebar.classList.remove('collapsed');
                if (mainContent) mainContent.classList.remove('expanded');

                if (menuseetingBtn) menuseetingBtn.style.display = 'block';

                // Show dropdown arrows when expanded
                const arrows = document.querySelectorAll('.dropdown-arrow');
                arrows.forEach(arrow => {
                    arrow.style.display = 'inline-block';
                });
            }
        }

        // Toggle Sidebar
        const toggleSidebarBtn = document.getElementById('toggleSidebar');
        if (toggleSidebarBtn) {
            toggleSidebarBtn.addEventListener('click', function() {
                const sidebar = document.getElementById('sidebar');
                const mainContent = document.getElementById('mainContent');

                if (sidebar) sidebar.classList.toggle('collapsed');
                if (mainContent) mainContent.classList.toggle('expanded');

                if (menuseetingBtn) {
                    menuseetingBtn.style.display = sidebar.classList.contains('collapsed') ? 'none' : 'block';
                }

                // Toggle dropdown arrows visibility
                const arrows = document.querySelectorAll('.dropdown-arrow');
                arrows.forEach(arrow => {
                    arrow.style.display = sidebar.classList.contains('collapsed') ? 'none' : 'inline-block';
                });
            });
        }

        // ======================= UTILITY FUNCTIONS =======================
        // Update date and time
        function updateDateTime() {
            const now = new Date();
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: 'numeric',
                minute: 'numeric',
                hour12: true
            };

            try {
                const dateStr = now.toLocaleDateString('ar-IQ', options);

                // Update the welcome subtitle
                const welcomeSubtitle = document.getElementById('currentDateTime');
                if (welcomeSubtitle) {
                    welcomeSubtitle.textContent = `کاتژمێر ${now.getHours()}:${now.getMinutes().toString().padStart(2, '0')}، ${dateStr}`;
                }
            } catch(e) {
                // Fallback if locale is not available
                const welcomeSubtitle = document.getElementById('currentDateTime');
                if (welcomeSubtitle) {
                    welcomeSubtitle.textContent = now.toLocaleString();
                }
            }
        }

        // Invoice functions
        function viewInvoice(invoiceId) {
            alert(`پسوڵەی ${invoiceId} بینین دەکرێت`);
        }

        function editInvoice(invoiceId) {
            alert(`پسوولەی ${invoiceId} دەستکاری دەکرێت`);
        }

        // Initialize functions
        if (window.addEventListener) {
            window.addEventListener('resize', handleSidebarByWidth);
        } else if (window.attachEvent) {
            window.attachEvent('onresize', handleSidebarByWidth);
        }

        updateDateTime();
        setInterval(updateDateTime, 60000);
        handleSidebarByWidth(); // Initial call
    </script>
</body>
</html>
