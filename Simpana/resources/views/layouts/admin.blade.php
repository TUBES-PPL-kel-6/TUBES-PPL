<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - SIMPANA</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #8C1414;
            --primary-dark: #641010;
            --primary-light: #B91D1D;
            --secondary: #f8f9fa;
            --accent: #FFD700;
            --success: #22c55e;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;
            --light: #ffffff;
            --dark: #1e293b;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            --sidebar-bg: #8C1414;
            --sidebar-hover: #641010;
            --sidebar-active: rgba(255, 255, 255, 0.1);
            --gradient-primary: linear-gradient(135deg, #8C1414 0%, #B91D1D 100%);
            --gradient-accent: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
            --shadow-soft: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --shadow-medium: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-large: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--gray-50);
            color: var(--gray-800);
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        .sidebar {
            background: var(--sidebar-bg);
            min-height: 100vh;
            position: fixed;
            width: 280px;
            top: 0;
            left: 0;
            z-index: 1000;
            transition: all 0.3s ease;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, 0.3) transparent;
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }

        .sidebar-header {
            padding: 30px 25px 20px 25px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-header img {
            height: 56px;
            margin-bottom: 12px;
            display: block;
            margin-left: auto;
            margin-right: auto;
            filter: brightness(1.1);
        }

        .sidebar-header h4 {
            font-weight: 700;
            font-size: 24px;
            color: white;
            letter-spacing: 1px;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .sidebar-menu {
            padding: 25px 0;
        }

        .menu-section {
            margin-bottom: 35px;
        }

        .menu-title {
            color: rgba(255, 255, 255, 0.7);
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            padding: 0 25px 12px;
            margin-bottom: 8px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .sidebar a {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            padding: 14px 25px;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            position: relative;
            margin: 2px 15px;
            border-radius: 12px;
            font-weight: 500;
            font-size: 14px;
        }

        .sidebar a i {
            width: 20px;
            margin-right: 14px;
            font-size: 16px;
            text-align: center;
            opacity: 0.8;
            transition: all 0.3s ease;
        }

        .sidebar a:hover {
            background: var(--sidebar-active);
            color: white;
            transform: translateX(3px);
        }

        .sidebar a:hover i {
            opacity: 1;
        }

        .sidebar a.active {
            background: var(--sidebar-active);
            color: white;
            position: relative;
        }

        .sidebar a.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 60%;
            background: white;
            border-radius: 0 2px 2px 0;
        }

        .sidebar a.active i {
            opacity: 1;
        }

        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            transition: all 0.3s ease;
            background: var(--gray-50);
        }

        .top-navbar {
            background: white;
            backdrop-filter: blur(20px);
            padding: 20px 30px;
            border-bottom: 1px solid var(--gray-200);
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: var(--shadow-soft);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 24px;
            color: var(--primary);
            letter-spacing: 0.5px;
        }

        .content-wrapper {
            padding: 30px;
        }

        /* Button Styles */
        .btn-primary {
            background: var(--primary);
            border: 1px solid var(--primary);
            color: white;
            font-weight: 500;
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover,
        .btn-primary:focus {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
            color: white;
            transform: translateY(-1px);
            box-shadow: var(--shadow-medium);
        }

        .btn-secondary {
            background: var(--gray-100);
            border: 1px solid var(--gray-300);
            color: var(--gray-700);
            font-weight: 500;
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover,
        .btn-secondary:focus {
            background: var(--gray-200);
            border-color: var(--gray-400);
            color: var(--gray-800);
        }

        .btn-success {
            background: var(--success);
            border: 1px solid var(--success);
            color: white;
        }

        .btn-success:hover,
        .btn-success:focus {
            background: #16a34a;
            border-color: #16a34a;
            color: white;
        }

        .btn-warning {
            background: var(--warning);
            border: 1px solid var(--warning);
            color: white;
        }

        .btn-warning:hover,
        .btn-warning:focus {
            background: #d97706;
            border-color: #d97706;
            color: white;
        }

        .btn-danger {
            background: var(--danger);
            border: 1px solid var(--danger);
            color: white;
        }

        .btn-danger:hover,
        .btn-danger:focus {
            background: #dc2626;
            border-color: #dc2626;
            color: white;
        }

        /* Badge Styles */
        .badge.bg-primary {
            background: var(--primary) !important;
            color: white !important;
        }

        .badge.bg-secondary {
            background: var(--gray-500) !important;
            color: white !important;
        }

        .badge.bg-success {
            background: var(--success) !important;
            color: white !important;
        }

        .badge.bg-warning {
            background: var(--warning) !important;
            color: white !important;
        }

        .badge.bg-danger {
            background: var(--danger) !important;
            color: white !important;
        }

        .badge.bg-info {
            background: var(--info) !important;
            color: white !important;
        }

        /* Card Styles */
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: var(--shadow-soft);
            transition: all 0.3s ease;
            background: white;
            border: 1px solid var(--gray-200);
        }

        .card:hover {
            box-shadow: var(--shadow-medium);
            transform: translateY(-2px);
        }

        .card-header {
            background: var(--gray-50);
            border-bottom: 1px solid var(--gray-200);
            font-weight: 600;
            color: var(--gray-800);
        }

        /* Dropdown Styles */
        .dropdown-menu {
            border: none;
            box-shadow: var(--shadow-large);
            border-radius: 12px;
            border: 1px solid var(--gray-200);
        }

        .dropdown-item {
            padding: 10px 16px;
            transition: all 0.2s ease;
            color: var(--gray-700);
        }

        .dropdown-item:hover,
        .dropdown-item:focus {
            background: var(--gray-50);
            color: var(--gray-900);
        }

        .dropdown-toggle {
            background: none;
            border: none;
            color: var(--gray-700);
            font-weight: 500;
            padding: 8px 12px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .dropdown-toggle:hover,
        .dropdown-toggle:focus {
            background: var(--gray-100);
            color: var(--gray-900);
        }

        /* Table Styles */
        .table {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow-soft);
        }

        .table th {
            background: var(--gray-50);
            border-bottom: 2px solid var(--gray-200);
            font-weight: 600;
            color: var(--gray-800);
            padding: 12px 16px;
        }

        .table td {
            padding: 12px 16px;
            border-bottom: 1px solid var(--gray-100);
            color: var(--gray-700);
        }

        .table tbody tr:hover {
            background: var(--gray-50);
        }

        /* Footer */
        .footer {
            background: var(--sidebar-bg);
            color: white;
            text-align: center;
            padding: 20px 30px;
            margin-left: 280px;
            font-size: 14px;
            border-top: 1px solid var(--gray-200);
        }

        /* Alert Styles */
        .alert {
            border: none;
            border-radius: 12px;
            padding: 16px 20px;
        }

        .alert-primary {
            background: rgba(140, 20, 20, 0.1);
            color: var(--primary-dark);
            border-left: 4px solid var(--primary);
        }

        .alert-success {
            background: rgba(34, 197, 94, 0.1);
            color: #15803d;
            border-left: 4px solid var(--success);
        }

        .alert-warning {
            background: rgba(245, 158, 11, 0.1);
            color: #92400e;
            border-left: 4px solid var(--warning);
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            color: #b91c1c;
            border-left: 4px solid var(--danger);
        }

        /* Form Styles */
        .form-control {
            border: 1px solid var(--gray-300);
            border-radius: 8px;
            padding: 10px 12px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(140, 20, 20, 0.1);
        }

        .form-label {
            font-weight: 500;
            color: var(--gray-700);
            margin-bottom: 6px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content,
            .footer {
                margin-left: 0;
            }

            .content-wrapper {
                padding: 20px 15px;
            }

            .top-navbar {
                padding: 15px 20px;
            }
        }

        /* Loading States */
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--gray-100);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--gray-300);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--gray-400);
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <img src="{{ asset('images/Simpana white.png') }}" alt="Simpana Logo">
            <h4>SIMPANA</h4>
        </div>
        <div class="sidebar-menu">
            <div class="menu-section">
                <div class="menu-title">Menu Utama</div>
                <a href="{{ route('admin.index') }}" class="{{ request()->routeIs('admin.index') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    Dashboard
                </a>
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-user"></i>
                    User Dashboard
                </a>
                <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    Anggota
                </a>
                <a href="{{ route('admin.payment-verification') }}" class="{{ request()->routeIs('admin.payment-verification') ? 'active' : '' }}">
                    <i class="fas fa-wallet"></i>
                    Verifikasi Pembayaran
                </a>
                <a href="{{ route('loanApproval') }}" class="{{ request()->routeIs('loanApproval') ? 'active' : '' }}">
                    <i class="fas fa-file-signature"></i>
                    Verifikasi Pinjaman
                </a>
                <a href="{{ route('profit-report.index') }}" class="{{ request()->routeIs('profit-report.index') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i>
                    Laporan Laba
                </a>
                <a href="{{ route('admin.shu.index') }}" class="{{ request()->routeIs('admin.shu.index') ? 'active' : '' }}">
                    <i class="fas fa-calculator"></i>
                    Generate SHU
                </a>
            </div>
            <div class="menu-section">
                <div class="menu-title">Akun</div>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    Keluar
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navigation -->
        <nav class="top-navbar d-flex justify-content-between align-items-center">
            <div class="navbar-brand">@yield('header', 'Dashboard')</div>
            <div class="d-flex align-items-center">
                <div class="user-dropdown">
                    <div class="dropdown">
                        <button class="btn dropdown-toggle" type="button" id="userMenu" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-2"></i>
                            {{ Auth::user()->nama ?? 'Admin User' }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="/admin/profile">
                                <i class="fas fa-user me-2"></i>Profil
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i>Keluar
                            </a></li>
                        </ul>
                    </div>
                </div>
                <!-- Notification Bell -->
                <div class="ms-3 position-relative">
                    <a href="{{ route('notifications') }}" class="text-gray-500 hover:text-primary" style="font-size: 1.25rem;">
                        <i class="fas fa-bell"></i>
                        @if(isset($unreadNotificationCount) && $unreadNotificationCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $unreadNotificationCount }}
                            </span>
                        @endif
                    </a>
                </div>
            </div>
        </nav>

        <div class="content-wrapper">
            @yield('content')
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        &copy; {{ date('Y') }} SIMPANA. All rights reserved.
    </footer>

    <!-- Logout Form -->
    <form id="logout-form" action="/logout" method="POST" class="d-none">
        @csrf
    </form>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
