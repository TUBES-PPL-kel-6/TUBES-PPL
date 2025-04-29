<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Setoran Baru</title>
    <style>
        body {
            background-color: #FFFFFF;
            font-family: 'Poppins', sans-serif;
            padding: 30px;
            color: #8C1414;
        }
        .form-container {
            max-width: 700px;
            margin: auto;
            background: #FFFFFF;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #8C1414;
            font-size: 32px;
            margin-bottom: 30px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 8px;
        }
        input, textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 2px solid #FFD500;
            border-radius: 8px;
            background-color: #FFFFFF;
            color: #8C1414;
        }
        .btn {
            background-color: #8C1414;
            color: #FFFFFF;
            padding: 12px 20px;
            border: none;
            border-radius: 10px;
            font-weight: bold;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #FFD500;
            color: #8C1414;
        }
        .back-link {
            display: block;
            margin-top: 20px;
            text-decoration: none;
            color: #8C1414;
            font-weight: bold;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h1>Tambah Setoran Baru</h1>

    <form action="{{ route('setoran.store') }}" method="POST">
        @csrf

        <label>Nama Anggota</label>
        <input type="text" name="nama_anggota" required>

        <label>Jumlah Setoran</label>
        <input type="number" name="jumlah_setoran" required>

        <label>Tanggal Setor</label>
        <input type="date" name="tanggal_setor">

        <label>Keterangan</label>
        <textarea name="keterangan" rows="4"></textarea>

        <button type="submit" class="btn">Simpan Setoran</button>
    </form>

    <a href="{{ route('setoran.index') }}" class="back-link">&larr; Kembali ke daftar setoran</a>
</div>

</body>
</html>
