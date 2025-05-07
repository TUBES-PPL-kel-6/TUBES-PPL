<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Persetujuan Pinjaman</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #222; font-size: 13px; }
        .kop { text-align: center; border-bottom: 2px solid #333; padding-bottom: 8px; margin-bottom: 24px; }
        .kop h2 { margin: 0; font-size: 22px; letter-spacing: 2px; }
        .kop p { margin: 0; font-size: 13px; }
        .nomor-surat { text-align: right; margin-bottom: 18px; font-size: 13px; }
        .judul { text-align: center; font-size: 16px; font-weight: bold; margin-bottom: 18px; text-decoration: underline; }
        .isi { margin-bottom: 18px; }
        .rincian { margin: 18px 0; }
        .rincian table { width: 100%; border-collapse: collapse; }
        .rincian td { padding: 6px 0; }
        .label { width: 180px; font-weight: bold; vertical-align: top; }
        .ttd { margin-top: 40px; width: 100%; }
        .ttd td { vertical-align: bottom; text-align: center; height: 80px; }
        .status-approved { color: #065F46; font-weight: bold; }
        .status-rejected { color: #991B1B; font-weight: bold; }
    </style>
</head>
<body>
    <div class="kop">
        <h2>KOPERASI SIMPANA</h2>
        <p>Jl. Sukabirus No. 123, Bandung | Telp: 081234567890</p>
    </div>
    <div class="nomor-surat">
        Nomor: {{ 'SPP/' . str_pad($loan->id, 4, '0', STR_PAD_LEFT) . '/' . date('Y') }}
    </div>
    <div class="judul">SURAT PERSETUJUAN PINJAMAN</div>
    <div class="isi">
        <p>Kepada Yth,<br>
        <b>{{ $loan->user->nama ?? $loan->user->name }}</b><br>
        Anggota Koperasi Simpana<br>
        di Tempat</p>
        <p>Dengan ini kami menginformasikan bahwa pengajuan pinjaman Anda pada Koperasi Simpana telah <b>{{ $loan->status == 'approved' ? 'DISETUJUI' : 'DITOLAK' }}</b> dengan rincian sebagai berikut:</p>
    </div>
    <div class="rincian">
        <table>
            <tr>
                <td class="label">Nama Anggota</td>
                <td>: {{ $loan->user->nama ?? $loan->user->name }}</td>
            </tr>
            <tr>
                <td class="label">Nomor Anggota</td>
                <td>: {{ $loan->user->id }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal Pengajuan</td>
                <td>: {{ $loan->application_date->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td class="label">Total Pinjaman</td>
                <td>: Rp {{ number_format($loan->loan_amount, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="label">Durasi Pinjaman</td>
                <td>: {{ $loan->tenor }} Bulan</td>
            </tr>
            <tr>
                <td class="label">Setoran per Bulan</td>
                <td>: Rp {{ number_format($loan->loan_amount / max($loan->tenor,1), 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="label">Status</td>
                <td>:
                    <span class="{{ $loan->status == 'approved' ? 'status-approved' : 'status-rejected' }}">
                        {{ ucfirst($loan->status) }}
                    </span>
                </td>
            </tr>
            <tr>
                <td class="label">Catatan Admin</td>
                <td>: {{ $loan->application_note ?? '-' }}</td>
            </tr>
        </table>
    </div>
    <div class="isi">
        <p>Demikian surat persetujuan pinjaman ini dibuat untuk dapat digunakan sebagaimana mestinya.<br>
        Atas perhatian dan kepercayaan Anda kepada Koperasi Simpana, kami ucapkan terima kasih.</p>
    </div>
    <table class="ttd">
        <tr>
            <td style="width:60%"></td>
            <td>Bandung, {{ now()->format('d F Y') }}</td>
        </tr>
        <tr>
            <td></td>
            <td>Pengurus Koperasi Simpana</td>
        </tr>
        <tr style="height:60px"><td></td><td></td></tr>
        <tr>
            <td></td>
            <td>__________________________</td>
        </tr>
    </table>
</body>
</html> 