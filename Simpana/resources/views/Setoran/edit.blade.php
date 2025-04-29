<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Setoran Anggota</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            background-color: #FFFFFF;
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: start;
            padding-top: 60px;
            color: #8C1414;
        }
        .card {
            background: #FFFFFF;
            border-radius: 16px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 700px;
        }
        h1 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 30px;
            text-align: center;
            color: #8C1414;
        }
        form label {
            font-weight: 600;
            font-size: 15px;
            margin-bottom: 8px;
            display: block;
            color: #8C1414;
        }
        form input, form textarea {
            width: 100%;
            padding: 14px;
            margin-bottom: 24px;
            border: 2px solid #FFD500;
            border-radius: 10px;
            background-color: #FFF;
            font-size: 15px;
            color: #8C1414;
            transition: 0.3s ease;
        }
        form input:focus, form textarea:focus {
            border-color: #87CE45;
            outline: none;
            box-shadow: 0 0 8px #87CE45;
        }
        .btn-primary {
            background-color: #8C1414;
            color: #FFFFFF;
            border: none;
            padding: 14px 22px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            width: 100%;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
        }
        .btn-primary:hover {
            background-color: #FFD500;
            color: #8C1414;
            transform: translateY(-2px);
        }
        .back-link {
            display: block;
            margin-top: 20px;
            text-align: center;
            text-decoration: none;
            color: #8C1414;
            font-weight: 600;
            font-size: 14px;
        }
        .back-link:hover {
            text-decoration: underline;
            color: #FFD500;
        }
    </style>
</head>
<body>

<div class="card">
    <h1>Edit Setoran</h1>

    <form action="{{ route('setoran.update', $setoran->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="nama_anggota">Nama Anggota</label>
        <input type="text" id="nama_anggota" name="nama_anggota" value="{{ old('nama_anggota', $setoran->nama_anggota) }}" required>

        <label for="jumlah_setoran">Jumlah Setoran</label>
        <input type="number" id="jumlah_setoran" name="jumlah_setoran" value="{{ old('jumlah_setoran', $setoran->jumlah_setoran) }}" required>

        <label for="tanggal_setor">Tanggal Setor</label>
        <input type="date" id="tanggal_setor" name="tanggal_setor" value="{{ old('tanggal_setor', $setoran->tanggal_setor) }}">

        <label for="keterangan">Keterangan</label>
        <textarea id="keterangan" name="keterangan" rows="4">{{ old('keterangan', $setoran->keterangan) }}</textarea>

        <button type="submit" class="btn-primary">Perbarui Setoran</button>
    </form>

    <a href="{{ route('setoran.index') }}" class="back-link">&larr; Kembali ke Daftar Setoran</a>
</div>

</body>
</html>
