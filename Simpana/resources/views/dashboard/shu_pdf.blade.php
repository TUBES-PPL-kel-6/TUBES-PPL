<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>SHU {{ $tahun }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .info {
            text-align: left;
            margin-left: 2cm;
            margin-bottom: 20px;
        }
        .table-title { text-align: center; margin-bottom: 10px; }
        table { width: 80%; margin: 0 auto; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background: #eee; text-align: center; }
        td.center { text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Slip SHU Anggota</h2>
    </div>
    <div class="info">
        <p><strong>ID Anggota:</strong> {{ $user->id }}</p>
        <p><strong>Nama:</strong> {{ $user->nama }}</p>
        <p><strong>Alamat:</strong> {{ $user->alamat }}</p>
        <p><strong>Tahun:</strong> {{ $tahun }}</p>
    </div>
    <div class="table-title">
        <h4>Daftar Transaksi Tahun {{ $tahun }}</h4>
    </div>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @if(count($transaksi) > 0)
                @foreach($transaksi as $trx)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($trx->tanggal)->format('d/m/Y') }}</td>
                        <td>{{ ucfirst($trx->jenis_transaksi) }}</td>
                        <td>Rp {{ number_format($trx->jumlah, 0, ',', '.') }}</td>
                        <td>{{ $trx->keterangan }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4" class="center">Tidak ada transaksi pada tahun ini.</td>
                </tr>
            @endif
        </tbody>
    </table>
    <div class="table-title" style="margin-top:30px;">
        <h4>Data SHU Tahun {{ $tahun }}</h4>
    </div>
    <table>
        <thead>
            <tr>
                <th>Total Simpanan</th>
                <th>Total Pinjaman</th>
                <th>Kontribusi Simpanan</th>
                <th>Kontribusi Pinjaman</th>
                <th>Jumlah SHU</th>
            </tr>
        </thead>
        <tbody>
            @if(count($shus) > 0)
                @foreach($shus as $shu)
                <tr>
                    <td>Rp {{ number_format($shu->total_simpanan, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($shu->total_pinjaman, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($shu->kontribusi_simpanan, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($shu->kontribusi_pinjaman, 0, ',', '.') }}</td>
                    <td><strong>Rp {{ number_format($shu->jumlah_shu, 0, ',', '.') }}</strong></td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" class="center">Tidak ada data SHU pada tahun ini.</td>
                </tr>
            @endif
        </tbody>
    </table>
</body>
</html> 