<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Setoran</title>
    <style>
        body {
            background-color: #FFFFFF;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 20px;
            color: #8C1414;
        }
        .container {
            max-width: 1200px;
            margin: auto;
        }
        h1 {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 30px;
            color: #8C1414;
        }
        .btn {
            background-color: #8C1414;
            color: #FFFFFF;
            padding: 12px 20px;
            border: none;
            border-radius: 10px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s;
            margin-bottom: 20px;
            display: inline-block;
        }
        .btn:hover {
            background-color: #FFD500;
            color: #8C1414;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #FFFFFF;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-radius: 12px;
            overflow: hidden;
        }
        th, td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #FFD500;
        }
        th {
            background-color: #8C1414;
            color: #FFFFFF;
            font-weight: bold;
        }
        td {
            color: #8C1414;
        }
        .alert {
            background-color: #87CE45;
            color: #FFFFFF;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 10px;
            font-weight: bold;
        }
        .aksi-btn {
            background-color: #FFD500;
            color: #8C1414;
            padding: 8px 15px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }
        .aksi-btn:hover {
            background-color: #8C1414;
            color: #FFFFFF;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Daftar Setoran</h1>

    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    <a href="{{ route('setoran.create') }}" class="btn">+ Tambah Setoran Baru</a>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Anggota</th>
                <th>Jumlah Setoran</th>
                <th>Tanggal Setor</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($setorans as $setoran)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $setoran->nama_anggota }}</td>
                <td>Rp {{ number_format($setoran->jumlah_setoran, 0, ',', '.') }}</td>
                <td>{{ $setoran->tanggal_setor }}</td>
                <td>{{ $setoran->keterangan }}</td>
                <td>
                    <a href="{{ route('setoran.edit', $setoran->id) }}" class="aksi-btn">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

</body>
</html>
