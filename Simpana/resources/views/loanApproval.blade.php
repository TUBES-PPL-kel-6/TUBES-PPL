<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Persetujuan Pinjaman - SIMPANA</title>
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
        .table {
            background-color: #fff;
            border-radius: 12px;
            overflow: hidden;
        }
        .table thead th {
            background-color: #F4F6FA;
            border-bottom: none;
            padding: 15px;
            font-weight: 600;
            color: #4B5563;
        }
        .table tbody td {
            padding: 15px;
            vertical-align: middle;
        }
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .status-pending {
            background-color: #FEF3C7;
            color: #92400E;
        }
        .status-approved {
            background-color: #D1FAE5;
            color: #065F46;
        }
        .status-rejected {
            background-color: #FEE2E2;
            color: #991B1B;
        }
    </style>
</head>
<body>
    @if(Auth::check() && Auth::user()->role === 'admin')
        <div class="sidebar">
            <h4>SIMPANA</h4>
            <a href="#">Dashboard</a>
            <a href="#">Riwayat Simpanan</a>
            <a href="#">Setor Simpanan</a>
            <a href="{{ route('loanApproval') }}" class="active">Persetujuan Pinjaman</a>
            <div class="mt-4 px-3 text-uppercase" style="font-size: 12px;">Akun</div>
            <a href="#">Profil</a>
            <a href="#">Pengaturan</a>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Keluar</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>

        <div class="main-content">
            <div class="navbar">
                <div class="title">Persetujuan Pinjaman</div>
                <div class="d-flex align-items-center">
                    <input type="text" class="form-control me-3" placeholder="Cari pengajuan...">
                    <span class="me-3">🔔</span>
                    <span>{{ Auth::user()->name }} ▼</span>
                </div>
            </div>

            <!-- Notifikasi -->
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <!-- Search and Filter Section -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Cari pengajuan...">
                        </div>
                        <div class="col-md-4">
                            <select class="form-select">
                                <option value="">Semua Status</option>
                                <option value="pending">Menunggu</option>
                                <option value="approved">Disetujui</option>
                                <option value="rejected">Ditolak</option>
                            </select>
                        </div>
                    </div>

                    <!-- Loan Applications Table -->
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No. Pengajuan</th>
                                    <th>Nama Pemohon</th>
                                    <th>Produk Pinjaman</th>
                                    <th>Nominal</th>
                                    <th>Tenor</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($loans as $loan)
                                <tr>
                                    <td>{{ $loan->id }}</td>
                                    <td>{{ $loan->user->name }}</td>
                                    <td>{{ $loan->loan_product }}</td>
                                    <td>Rp {{ number_format($loan->loan_amount, 0, ',', '.') }}</td>
                                    <td>{{ $loan->tenor }} Bulan</td>
                                    <td>
                                        <span class="status-badge
                                            @if($loan->status == 'pending') status-pending
                                            @elseif($loan->status == 'approved') status-approved
                                            @else status-rejected @endif">
                                            {{ ucfirst($loan->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#detailModal{{ $loan->id }}">
                                                Detail
                                            </button>
                                            @if($loan->status == 'pending')
                                            <form action="{{ route('loanApproval.approve', $loan->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-success">Setujui</button>
                                            </form>
                                            <form action="{{ route('loanApproval.reject', $loan->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Tolak</button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal Detail untuk setiap pinjaman -->
                                <div class="modal fade" id="detailModal{{ $loan->id }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $loan->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="detailModalLabel{{ $loan->id }}">Detail Pengajuan Pinjaman #{{ $loan->id }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <p class="mb-1 text-muted">Nama Pemohon</p>
                                                        <p class="fw-bold">{{ $loan->user->nama }}</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p class="mb-1 text-muted">Status</p>
                                                        <span class="status-badge
                                                            @if($loan->status == 'pending') status-pending
                                                            @elseif($loan->status == 'approved') status-approved
                                                            @else status-rejected @endif">
                                                            {{ ucfirst($loan->status) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <p class="mb-1 text-muted">Produk Pinjaman</p>
                                                        <p class="fw-bold">{{ ucfirst($loan->loan_product) }}</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p class="mb-1 text-muted">Nominal Pinjaman</p>
                                                        <p class="fw-bold">Rp {{ number_format($loan->loan_amount, 0, ',', '.') }}</p>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <p class="mb-1 text-muted">Tenor</p>
                                                        <p class="fw-bold">{{ $loan->tenor }} Bulan</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p class="mb-1 text-muted">Metode Pembayaran</p>
                                                        <p class="fw-bold">{{ ucfirst($loan->payment_method) }}</p>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <p class="mb-1 text-muted">Tanggal Pengajuan</p>
                                                        <p class="fw-bold">{{ $loan->application_date->format('d/m/Y') }}</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p class="mb-1 text-muted">Tanggal Cicilan Pertama</p>
                                                        <p class="fw-bold">{{ $loan->first_payment_date->format('d/m/Y') }}</p>
                                                    </div>
                                                </div>
                                                @if($loan->application_note)
                                                <div class="row mb-3">
                                                    <div class="col-12">
                                                        <p class="mb-1 text-muted">Catatan Pengajuan</p>
                                                        <p class="fw-bold">{{ $loan->application_note }}</p>
                                                    </div>
                                                </div>
                                                @endif
                                                @if($loan->collateral)
                                                <div class="row mb-3">
                                                    <div class="col-12">
                                                        <p class="mb-1 text-muted">Jaminan</p>
                                                        <p class="fw-bold">{{ $loan->collateral }}</p>
                                                    </div>
                                                </div>
                                                @endif
                                                @if($loan->documents && count($loan->documents) > 0)
                                                <div class="row mb-3">
                                                    <div class="col-12">
                                                        <p class="mb-1 text-muted">Dokumen Pendukung</p>
                                                        <div class="list-group">
                                                            @foreach($loan->documents as $document)
                                                            <a href="{{ asset($document['file_path']) }}" target="_blank" class="list-group-item list-group-item-action">
                                                                {{ $document['original_name'] }}
                                                            </a>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="modal-footer">
                                                @if($loan->status == 'pending')
                                                <form action="{{ route('loanApproval.approve', $loan->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success">Setujui Pinjaman</button>
                                                </form>
                                                <form action="{{ route('loanApproval.reject', $loan->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">Tolak Pinjaman</button>
                                                </form>
                                                @endif
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $loans->links() }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @else
        <script>window.location = "{{ route('login') }}";</script>
    @endif
</body>
</html>
