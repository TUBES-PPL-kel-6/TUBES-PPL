<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan SHU {{ $tahun }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 30px;
        }
        .subtitle {
            font-size: 18px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            border: 1px solid #000;
            padding: 10px;
        }
        th {
            background-color: #f0f0f0;
        }
        .section-header {
            font-size: 16px;
            font-weight: bold;
            margin: 20px 0;
        }
        .text-right {
            text-align: right;
        }
        .total-row {
            font-weight: bold;
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
    <div class="title">LAPORAN SISA HASIL USAHA (SHU)</div>
    <div class="subtitle">Tahun Buku: {{ $tahun }}</div>

    <div class="section-header">I. Pendapatan Koperasi</div>
    <table>
        <tr>
            <th>No</th>
            <th>Uraian</th>
            <th class="text-right">Jumlah (Rp)</th>
        </tr>
        <tr>
            <td>1</td>
            <td>Total Pinjaman ke Anggota</td>
            <td class="text-right">{{ number_format($totalPinjaman, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>2</td>
            <td>Bunga Pinjaman (10%)</td>
            <td class="text-right">{{ number_format($bungaPinjaman, 0, ',', '.') }}</td>
        </tr>
        <tr class="total-row">
            <td colspan="2">Total SHU (Pendapatan Bersih)</td>
            <td class="text-right">{{ number_format($totalSHU, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="section-header">II. Pembagian SHU</div>
    <table>
        <tr>
            <th>No</th>
            <th>Komponen Pembagian</th>
            <th class="text-right">Persentase (%)</th>
            <th class="text-right">Jumlah (Rp)</th>
        </tr>
        @foreach($komponenPembagian as $komponen)
        <tr>
            <td>{{ $komponen['no'] }}</td>
            <td>{{ $komponen['komponen'] }}</td>
            <td class="text-right">{{ $komponen['persentase'] }}</td>
            <td class="text-right">{{ number_format($komponen['jumlah'], 0, ',', '.') }}</td>
        </tr>
        @endforeach
        <tr class="total-row">
            <td colspan="2">Total</td>
            <td class="text-right">100%</td>
            <td class="text-right">{{ number_format($totalSHU, 0, ',', '.') }}</td>
        </tr>
    </table>
</body>
</html>
