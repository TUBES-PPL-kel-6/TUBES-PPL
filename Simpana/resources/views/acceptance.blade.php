<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Persetujuan Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .btn-sm {
            padding: 0.375rem 0.75rem;
        }
        .btn-success, .btn-danger {
            transition: all 0.2s ease;
        }
        .btn-success:hover {
            background-color: #4CAF50;
            border-color: #4CAF50;
            transform: translateY(-2px);
        }
        .btn-danger:hover {
            background-color: #FF4136;
            border-color: #FF4136;
            transform: translateY(-2px);
        }
        .alert-info {
            font-size: 1.1rem;
        }
        .container {
            max-width: 1200px;
        }
        .card {
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #8C1414;
            color: #fff;
            font-size: 1.5rem;
            font-weight: 600;
        }
        .card-body {
            background-color: #fff;
        }
        .table th {
            background-color: #f1f1f1;
        }
        .table-striped tbody tr:nth-child(odd) {
            background-color: #f8f9fa;
        }
        .btn-outline-info {
            transition: all 0.3s ease;
        }
        .btn-outline-info:hover {
            background-color: #f1f1f1;
            border-color: #8C1414;
        }
    </style>
</head>
<body>

<div class="container py-4">
    <div class="card">
        <div class="card-header text-center">
            <span>Persetujuan Pendaftaran Anggota Koperasi</span>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if($pendingUsers->isEmpty())
                <div class="alert alert-info text-center">Tidak ada pengguna yang menunggu persetujuan.</div>
            @else
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No. Telepon</th>
                            <th>Alamat</th>
                            <th>NIK</th>
                            <th>KTP</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingUsers as $user)
                            <tr>
                                <td>{{ $user->nama }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->no_telp }}</td>
                                <td>{{ $user->alamat }}</td>
                                <td>{{ $user->nik }}</td>
                                <td>
                                    <a href="{{ asset('storage/' . $user->ktp) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                        <i class="bi bi-file-earmark-pdf"></i> Lihat KTP
                                    </a>
                                </td>
                                <td class="d-flex gap-2">
                                    <a href="{{ route('acceptance.approve', $user->id) }}" class="btn btn-success btn-sm">
                                        <i class="bi bi-check-circle"></i> Terima
                                    </a>
                                    <a href="{{ route('acceptance.reject', $user->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menolak pengguna ini?')">
                                        <i class="bi bi-x-circle"></i> Tolak
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
</body>
</html>
