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
            let email = document.getElementById("email").value;
            let password = document.getElementById("password").value;
            let confirmPassword = document.getElementById("confirmPassword").value;
            
            if (email === "" || password === "" || confirmPassword === "") {
                alert("Harap isi email dan password sebelum melanjutkan.");
                return false;
            }
            
            if (password !== confirmPassword) {
                alert("Konfirmasi password tidak cocok.");
                return false;
            }
            
            document.getElementById('emailForm').style.display = 'none';
            document.getElementById('dataDiriForm').style.display = 'block';
        }
    </script>
</head>
<body>
    <div class="container">
        <h3 class="text-center text-white">Registrasi Anggota Koperasi</h3>
        <form id="emailForm" onsubmit="event.preventDefault(); nextStep();" class="card p-3 shadow-sm">
            <div class="mb-3">
                <label class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Konfirmasi Password:</label>
                <input type="password" id="confirmPassword" name="confirmPassword" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Regist</button>
        </form>

        <form id="dataDiriForm" action="{{ url('/register') }}" method="POST" enctype="multipart/form-data" class="card p-3 shadow-sm mt-3" style="display: none;">
            @csrf
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

            <!-- NIK dan Upload KTP dalam satu baris -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">NIK:</label>
                    <input type="text" name="nik" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Upload KTP:</label>
                    <input type="file" name="ktp" class="form-control" accept=".jpg,.png,.pdf" required>
                </div>
            </div>

            <button type="submit" class="btn btn-success w-100">Check Data</button>
        </form>
    </div>
</body>
</html>
