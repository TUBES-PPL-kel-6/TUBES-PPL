@php
use Illuminate\Support\Facades\Auth;
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashbord Pengurus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #F4F6FA;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }
        .sidebar {
            background-color: #8C1414;
            min-height: 100vh;
            position: fixed;
            width: 220px;
            display: flex;
            flex-direction: column;
            padding: 20px 0;
            color: #fff;
        }
        .sidebar h4 {
            text-align: center;
            margin-bottom: 30px;
        }
        .sidebar a {
            color: #fff;
            text-decoration: none;
            padding: 12px 20px;
            display: block;
            border-radius: 6px;
            transition: all 0.3s ease;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: #A22D2D;
        }
        .main-content {
            margin-left: 240px;
            padding: 20px;
        }
        .navbar {
            background-color: #fff;
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
            color: #8C1414;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }
        .footer {
            text-align: center;
            color: white;
            padding: 12px;
            border-radius: 12px;
            background-color: #87CE45;
            margin-top: 30px;
        }
        .list-group-item {
            border: none;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 8px;
            background: #ffffff;
            box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        }
    </style>
</head>
<body>
    @if(Auth::check() && Auth::user()->role === 'admin')
        <div class="sidebar">
            <h4>SIMPANA</h4>
            <a href="#" class="active">Dashboard</a>
            <a href="#">Riwayat Simpanan</a>
            <a href="#">Setor Simpanan</a>
            <a href="#">Pinjaman</a>
            <div class="mt-4 px-3 text-uppercase" style="font-size: 12px;">Akun</div>
            <a href="#">Profil</a>
            <a href="#">Pengaturan</a>
            <a href="#">Keluar</a>
        </div>

        <div class="main-content">
            <div class="navbar">
                <div class="title">Dashbord Pengurus</div>
                <div class="d-flex align-items-center">
                    <input type="text" class="form-control me-3" placeholder="Search...">
                    <span class="me-3">🔔</span>
                    <span>John Doe ▼</span>
                </div>
            </div>

            <h5 class="mb-3">Transaksi Terbaru</h5>
            <div class="card p-3">
                <div class="list-group">
                    <div class="list-group-item d-flex justify-content-between">
                        <div>Setor Simpanan <small class="text-muted">Transfer Bank</small></div>
                        <div>+ Rp 1.500.000 <span class="badge bg-success">Selesai</span></div>
                    </div>
                    <div class="list-group-item d-flex justify-content-between">
                        <div>Bayar Angsuran <small class="text-muted">Auto Debit</small></div>
                        <div>- Rp 850.000 <span class="badge bg-success">Selesai</span></div>
                    </div>
                    <div class="list-group-item d-flex justify-content-between">
                        <div>Setor Simpanan <small class="text-muted">Transfer Bank</small></div>
                        <div>+ Rp 1.500.000 <span class="badge bg-success">Selesai</span></div>
                    </div>
                    <div class="list-group-item d-flex justify-content-between">
                        <div>Ambil Pinjaman <small class="text-muted">Pinjaman Baru</small></div>
                        <div>+ Rp 15.000.000 <span class="badge bg-success">Selesai</span></div>
                    </div>
                </div>
            </div>

            <h5 class="mb-3">Pemberitahuan</h5>
            <div class="p-4 bg-white rounded shadow-sm mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-danger">Pembayaran Angsuran Jatuh Tempo</span>
                    <span class="badge bg-danger">3 Hari Lagi</span>
                </div>
            </div>
            <div class="p-4 bg-white rounded shadow-sm mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-success">Setoran Bulanan Berhasil</span>
                    <span class="badge bg-success">12 Apr 2025</span>
                </div>
            </div>
            <div class="p-4 bg-white rounded shadow-sm mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-warning">Program Simpanan Baru</span>
                    <span class="badge bg-warning">Lihat detail</span>
                </div>
            </div>

            <!-- Add a button to route to /user -->
            <a href="{{ url('/user') }}" class="btn btn-primary">Go to User Dashboard</a>
        </div>
    @else
        <!-- Redirect or show user content -->
    @endif
</body>
</html>