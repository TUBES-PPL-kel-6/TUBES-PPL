<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Anggota Koperasi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(to bottom, #8B3C3C, #A94A4A, #FFEFBA);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }
        .container {
            max-width: 600px;
            margin-top: 30px;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #F4D793;
            font-size: 16px;
        }
        h3 {
            font-size: 24px;
        }
        .form-label {
            font-size: 14px;
        }
        .form-control {
            font-size: 14px;
        }
        .btn {
            font-size: 16px;
        }
        .btn-primary {
            background-color: #A94A4A;
            border: none;
        }
        .btn-primary:hover {
            background-color: #8B3C3C;
        }
        .btn-success {
            background-color: #889E73;
            border: none;
        }
        .btn-success:hover {
            background-color: #6F815D;
        }
    </style>
    <script>
        function nextStep() {
            const email = document.getElementById("email").value.trim();
            const password = document.getElementById("password").value;
            const confirmPassword = document.getElementById("confirmPassword").value;

            if (!email || !password || !confirmPassword) {
                alert("Harap isi email dan password sebelum melanjutkan.");
                return;
            }

            if (password !== confirmPassword) {
                alert("Konfirmasi password tidak cocok.");
                return;
            }

            document.getElementById("emailForm").style.display = "none";
            document.getElementById("dataDiriForm").style.display = "block";

            document.getElementById("emailHidden").value = email;
            document.getElementById("passwordHidden").value = password;
        }
    </script>
</head>
<body>
    <div class="container">
        <h3 class="text-center text-white mb-4">Registrasi Anggota Koperasi</h3>

        {{-- Feedback Pesan --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- STEP 1: Email & Password -->
        <form id="emailForm" onsubmit="event.preventDefault(); nextStep();" class="card p-3 shadow-sm">
            <div class="mb-3">
                <label class="form-label">Email:</label>
                <input type="email" id="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password:</label>
                <input type="password" id="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Konfirmasi Password:</label>
                <input type="password" id="confirmPassword" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Lanjut</button>
        </form>

        <!-- STEP 2: Data Diri -->
        <form id="dataDiriForm" action="{{ url('/register') }}" method="POST" enctype="multipart/form-data" class="card p-3 shadow-sm mt-3" style="display: none;">
            @csrf
            <!-- Hidden email & password -->
            <input type="hidden" name="email" id="emailHidden">
            <input type="hidden" name="password" id="passwordHidden">

            <div class="mb-3">
                <label class="form-label">Nama:</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Alamat:</label>
                <input type="text" name="alamat" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Nomor Telepon:</label>
                <input type="text" name="no_telp" class="form-control" required>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">NIK:</label>
                    <input type="text" name="nik" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Upload KTP:</label>
                    <input type="file" name="ktp" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                </div>
            </div>

            <button type="submit" class="btn btn-success w-100">Kirim</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
