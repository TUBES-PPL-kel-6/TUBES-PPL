<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Pengguna Terdaftar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background:#f4f6fa;">
    <div class="sidebar" style="width:220px;float:left;min-height:100vh;background:#8C1414;color:#fff;padding:20px 0;">
        <h4 style="text-align:center;">SIMPANA</h4>
        <a href="{{ url('/admin') }}" class="d-block px-3 py-2 text-white">Dashboard</a>
        <a href="{{ route('admin.users') }}" class="d-block px-3 py-2 text-white">List User</a>
        <!-- Tambahkan menu lain di sini -->
    </div>
    <div style="margin-left:240px;padding:20px;">
        <div class="navbar mb-4">
            <div class="title h4">Daftar Pengguna Terdaftar</div>
        </div>
        <div class="card mt-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Tanggal Registrasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ ucfirst($user->role) }}</td>
                                <td>{{ $user->created_at->format('d-m-Y H:i') }}</td>
                                <td>
                                    <form action="{{ route('admin.users.remind', $user->id) }}" method="POST" onsubmit="return confirm('Kirim peringatan pembayaran ke user ini?')">
                                        @csrf
                                        <button type="submit" class="btn btn-warning btn-sm">Peringatkan</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada user terdaftar.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>