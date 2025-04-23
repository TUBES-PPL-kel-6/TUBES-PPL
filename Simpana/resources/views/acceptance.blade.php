<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Persetujuan Anggota Koperasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary: #8C1414;
            --bg-light: #f5f6fa;
            --border: #eee;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg-light);
        }

        /* Layout */
        .sidebar {
            width: 280px;
            background: #fff;
            padding: 30px 20px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }

        .content-area {
            margin-left: 280px;
            padding: 20px;
            max-width: calc(100vw - 280px);
            overflow-x: hidden;
        }

        /* Card Styles */
        .card {
            max-width: 1000px;
            margin: 0 auto 30px;
            border: none;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }

        .card-header {
            background: linear-gradient(45deg, var(--primary), #a01a1a);
            color: #fff;
            padding: 15px 20px;
            font-size: 1.1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Navigation */
        .nav-link {
            padding: 12px 20px;
            margin: 5px 0;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: 0.3s;
        }

        .nav-link:hover {
            background: rgba(140, 20, 20, 0.1);
            color: var(--primary);
        }

        .nav-link.active {
            background: var(--primary) !important;
            color: #fff !important;
            box-shadow: 0 4px 12px rgba(140, 20, 20, 0.2);
        }

        /* User Card */
        .user-card {
            padding: 15px 20px;
            border-bottom: 1px solid var(--border);
        }

        .user-main-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .user-name {
            font-weight: 600;
            margin-right: auto;
        }

        /* Buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            font-size: 0.875rem;
            min-width: 80px;
            transition: 0.3s;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        /* Details Section */
        .detail-trigger {
            color: var(--primary);
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
            margin-top: 10px;
            padding: 5px 0;
        }

        .user-details {
            background: var(--bg-light);
            border-radius: 8px;
            padding: 15px;
            margin-top: 10px;
            display: none;
        }

        .user-details.show {
            display: block;
            animation: slideDown 0.3s ease-out;
        }

        .detail-row {
            display: flex;
            margin-bottom: 10px;
            font-size: 0.875rem;
            gap: 10px;
        }

        .detail-label {
            min-width: 120px;
            color: #666;
            font-weight: 500;
        }

        .detail-value {
            flex: 1;
            min-width: 200px;
            word-break: break-word;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .rotate-icon {
            transition: transform 0.3s;
        }

        .rotate-icon.rotated {
            transform: rotate(180deg);
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .content-area {
                margin-left: 0;
                max-width: 100vw;
            }

            .user-main-info {
                flex-direction: column;
                align-items: flex-start;
            }

            .action-buttons {
                width: 100%;
                justify-content: flex-end;
            }
        }

        /* Updated Notification Styles */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1060;
        }

        .toast {
            min-width: 350px;
            background: white;
            border-left: 5px solid;
            margin-bottom: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .toast.success {
            border-left-color: #28a745;
        }

        .toast.error {
            border-left-color: #dc3545;
        }

        .toast-header {
            background: none;
            border: none;
            padding: 15px 15px 5px 15px;
        }

        .toast-body {
            padding: 5px 15px 15px 15px;
            font-size: 14px;
            color: #333;
        }

        .toast i {
            font-size: 20px;
            margin-right: 8px;
        }

        .toast.success i {
            color: #28a745;
        }

        .toast.error i {
            color: #dc3545;
        }
    </style>
</head>
<body>
    <!-- Toast Container -->
    <div class="toast-container">
        @if(session('success'))
            <div class="toast success" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <i class="bi bi-check-circle-fill"></i>
                    <strong class="me-auto">Sukses</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="toast error" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <strong class="me-auto">Peringatan</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    {{ session('error') }}
                </div>
            </div>
        @endif
    </div>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar">
                <h4 class="mb-4">Status</h4>
                <div class="nav flex-column nav-pills" id="status-tabs" role="tablist">
                    <button class="nav-link active" id="pending-tab" data-bs-toggle="pill" data-bs-target="#pending" type="button" role="tab">
                        <i class="bi bi-clock"></i> Pending
                    </button>
                    <button class="nav-link" id="accepted-tab" data-bs-toggle="pill" data-bs-target="#accepted" type="button" role="tab">
                        <i class="bi bi-check-circle"></i> Accepted
                    </button>
                    <button class="nav-link" id="rejected-tab" data-bs-toggle="pill" data-bs-target="#rejected" type="button" role="tab">
                        <i class="bi bi-x-circle"></i> Rejected
                    </button>
                </div>
            </div>

            <!-- Content Area -->
            <div class="col-md-10 content-area">
                <div class="tab-content" id="status-tabContent">
                    <!-- Pending Tab -->
                    <div class="tab-pane fade show active" id="pending" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <i class="bi bi-people-fill"></i>
                                <span>Pengguna Menunggu Persetujuan</span>
                            </div>
                            <div class="card-body p-0">
                                @if($pendingUsers->isEmpty())
                                    <div class="alert alert-info m-3">
                                        <i class="bi bi-info-circle-fill"></i>
                                        <span>Tidak ada pengguna yang menunggu persetujuan.</span>
                                    </div>
                                @else
                                    @foreach($pendingUsers as $user)
                                        <div class="user-card">
                                            <div class="user-main-info">
                                                <div class="user-name">{{ $user->nama }}</div>
                                                <div class="action-buttons">
                                                    <a href="{{ route('acceptance.approve', $user->id) }}" class="btn btn-success">
                                                        <i class="bi bi-check-lg"></i> Terima
                                                    </a>
                                                    <a href="{{ route('acceptance.reject', $user->id) }}" class="btn btn-danger" onclick="return confirm('Yakin ingin menolak pengguna ini?')">
                                                        <i class="bi bi-x-lg"></i> Tolak
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="detail-trigger" onclick="toggleDetails(this)">
                                                <i class="bi bi-chevron-down rotate-icon"></i>
                                                <span>Lihat Detail Data</span>
                                            </div>
                                            <div class="user-details">
                                                <div class="detail-row">
                                                    <div class="detail-label">Email</div>
                                                    <div class="detail-value">{{ $user->email }}</div>
                                                </div>
                                                <div class="detail-row">
                                                    <div class="detail-label">No. Telepon</div>
                                                    <div class="detail-value">{{ $user->no_telp }}</div>
                                                </div>
                                                <div class="detail-row">
                                                    <div class="detail-label">Alamat</div>
                                                    <div class="detail-value">{{ $user->alamat }}</div>
                                                </div>
                                                <div class="detail-row">
                                                    <div class="detail-label">NIK</div>
                                                    <div class="detail-value">{{ $user->nik }}</div>
                                                </div>
                                                <div class="detail-row">
                                                    <div class="detail-label">KTP</div>
                                                    <div class="detail-value">
                                                        <a href="{{ asset('storage/' . $user->ktp) }}" target="_blank" class="btn btn-outline-info">
                                                            <i class="bi bi-eye-fill"></i> Lihat KTP
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Accepted Tab -->
                    <div class="tab-pane fade" id="accepted" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <i class="bi bi-check-circle"></i>
                                <span>Pengguna Diterima</span>
                            </div>
                            <div class="card-body">
                                @if($acceptedUsers->isEmpty())
                                    <div class="alert alert-info m-3">
                                        <i class="bi bi-info-circle-fill"></i>
                                        <span>Belum ada pengguna yang diterima.</span>
                                    </div>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Nama</th>
                                                    <th>Email</th>
                                                    <th>No. Telepon</th>
                                                    <th>Alamat</th>
                                                    <th>NIK</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($acceptedUsers as $user)
                                                    <tr>
                                                        <td>{{ $user->nama }}</td>
                                                        <td>{{ $user->email }}</td>
                                                        <td>{{ $user->no_telp }}</td>
                                                        <td>{{ $user->alamat }}</td>
                                                        <td>{{ $user->nik }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Rejected Tab -->
                    <div class="tab-pane fade" id="rejected" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <i class="bi bi-x-circle"></i>
                                <span>Pengguna Ditolak</span>
                            </div>
                            <div class="card-body">
                                @if($rejectedUsers->isEmpty())
                                    <div class="alert alert-info m-3">
                                        <i class="bi bi-info-circle-fill"></i>
                                        <span>Belum ada pengguna yang ditolak.</span>
                                    </div>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Nama</th>
                                                    <th>Email</th>
                                                    <th>No. Telepon</th>
                                                    <th>Alamat</th>
                                                    <th>NIK</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($rejectedUsers as $user)
                                                    <tr>
                                                        <td>{{ $user->nama }}</td>
                                                        <td>{{ $user->email }}</td>
                                                        <td>{{ $user->no_telp }}</td>
                                                        <td>{{ $user->alamat }}</td>
                                                        <td>{{ $user->nik }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialize all toasts
        document.addEventListener('DOMContentLoaded', function() {
            var toastElList = [].slice.call(document.querySelectorAll('.toast'));
            var toastList = toastElList.map(function(toastEl) {
                return new bootstrap.Toast(toastEl, {
                    autohide: true,
                    delay: 5000
                });
            });
            
            // Show all toasts
            toastList.forEach(toast => toast.show());
        });

        function toggleDetails(el) {
            const details = el.nextElementSibling;
            const icon = el.querySelector('.rotate-icon');
            details.classList.toggle('show');
            icon.classList.toggle('rotated');
            el.querySelector('span').textContent = details.classList.contains('show') ? 'Sembunyikan Detail' : 'Lihat Detail Data';
        }
    </script>
</body>
</html>