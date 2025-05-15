<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - SIMPANA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #8C1414;
            --primary-hover: #A22D2D;
            --success: #87CE45;
            --white: #FFFFFF;
            --light-bg: #F4F6FA;
        }

        body {
            background-color: var(--light-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        .sidebar {
            background-color: var(--primary);
            min-height: 100vh;
            position: fixed;
            width: 220px;
            display: flex;
            flex-direction: column;
            padding: 20px 0;
            color: var(--white);
        }

        .sidebar h4 {
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar a {
            color: var(--white);
            text-decoration: none;
            padding: 12px 20px;
            display: block;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: var(--primary-hover);
        }

        .main-content {
            margin-left: 240px;
            padding: 20px;
            min-height: calc(100vh - 60px);
        }

        .navbar {
            background-color: var(--white);
            padding: 15px 25px;
            border-radius: 12px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .navbar .title {
            font-weight: bold;
            font-size: 20px;
            color: var(--primary);
        }

        .footer {
            margin-left: 240px;
            padding: 20px;
            text-align: center;
            color: var(--white);
            background-color: var(--success);
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
                min-height: auto;
            }
            .main-content,
            .footer {
                margin-left: 0;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h4>SIMPANA</h4>
        <a href="/admin">Dashboard</a>
        <a href="/admin/savings">Simpanan</a>
        <a href="/admin/loans">Pinjaman</a>
        <a href="/admin/users">Anggota</a>
        <a href="/profit-report">Laporan Laba</a>

        <div class="mt-4 px-3 text-uppercase" style="font-size: 12px;">Akun</div>
        <a href="/admin/profile">Profil</a>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Keluar
        </a>
        <form id="logout-form" action="/logout" method="POST" class="d-none">
            @csrf
        </form>
    </div>

    <!-- Header -->
    <div class="main-content">
        <div class="navbar">
            <div class="title">@yield('header', 'Dashboard')</div>
            <div class="d-flex align-items-center">
                <div class="dropdown">
                    <button class="btn btn-link text-dark dropdown-toggle text-decoration-none" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->nama }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                        <a class="dropdown-item" href="/admin/profile">Profil</a>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="#"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Keluar
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Content -->
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p class="mb-0">&copy; {{ date('Y') }} SIMPANA. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
