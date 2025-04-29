<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashbord Pengurus</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #F5F6FA;
            font-family: Arial, sans-serif;
        }
        .sidebar {
            background-color: #8C1414;
            height: 100vh;
            position: fixed;
            width: 220px;
            padding-top: 20px;
            color: white;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
            transition: 0.3s;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: #A22D2D;
            border-radius: 8px;
        }
        .content {
            margin-left: 240px;
            padding: 20px;
        }
        .navbar {
            background-color: #FFFFFF;
            border-bottom: 1px solid #ddd;
        }
        .navbar-brand {
            font-weight: bold;
            color: #8C1414;
        }
        .footer {
            background-color: #87CE45;
            text-align: center;
            color: white;
            padding: 10px;
            margin-top: 20px;
            border-radius: 8px 8px 0 0;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h4 class="text-center">SIMPANA</h4>
    <a href="#" class="active">Dashboard</a>
    <a href="#">Riwayat Simpanan</a>
    <a href="#">Setor Simpanan</a>
    <a href="#">Pinjaman</a>
    <div class="mt-4">AKUN</div>
    <a href="#">Profil</a>
    <a href="#">Pengaturan</a>
    <a href="#">Keluar</a>
</div>

<div class="content">
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <span class="navbar-brand">Dashbord Pengurus</span>
            <div class="ms-auto d-flex align-items-center">
                <input type="text" class="form-control me-2" placeholder="Search...">
                <span class="me-3">🔔</span>
                <span>John Doe ▼</span>
            </div>
        </div>
    </nav>
    @yield('content')
    <footer class="footer">
        © 2025 Dashbord Pengurus. All Rights Reserved.
    </footer>
</div>
</body>
</html>
