@extends('layouts.dashboard')

@section('content')
<style>
    :root {
        --primary-color: #E53935;
        --primary-dark: #C62828;
        --background-color: #f0f2f5;
        --card-background: #ffffff;
        --text-color: #333333;
        --border-color: #e0e0e0;
        --row-background: #f8f9fa;
        --row-hover-background: #e9ecef;
    }

    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap');

    body {
        background-color: var(--background-color);
        font-family: 'Inter', sans-serif;
        color: var(--text-color);
    }

    .container-fluid {
        padding: 2rem;
    }

    h2 {
        color: var(--primary-color);
        font-size: 24px;
        font-weight: 600;
        text-align: center;
        margin-bottom: 2rem;
    }

    .card {
        background: var(--card-background);
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
        overflow: hidden;
        border: none;
    }

    .card-header {
        background: var(--primary-color);
        color: white;
        padding: 1.25rem;
        font-size: 18px;
        font-weight: 500;
        border-bottom: none;
    }

    .card-body {
        padding: 1.5rem;
    }

    .table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 8px;
    }

    .table th {
        background: none;
        color: var(--text-color);
        font-weight: 600;
        text-align: left;
        padding: 12px;
        font-size: 14px;
        border-bottom: 2px solid var(--border-color);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .table td {
        padding: 12px 15px;
        font-size: 14px;
        vertical-align: middle;
        border: none;
    }

    .table tbody tr {
        background-color: var(--row-background);
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        transition: all 0.2s ease-in-out;
    }

    .table tbody tr:hover {
        background-color: var(--row-hover-background);
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .table tbody tr td:first-child {
        border-top-left-radius: 8px;
        border-bottom-left-radius: 8px;
    }

    .table tbody tr td:last-child {
        border-top-right-radius: 8px;
        border-bottom-right-radius: 8px;
    }

    .badge {
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
    }

    .badge-warning {
        background-color: #fff3cd;
        color: #856404;
    }

    .badge-success {
        background-color: #d4edda;
        color: #155724;
    }

    .badge-danger {
        background-color: #f8d7da;
        color: #721c24;
    }

    .badge-info {
        background-color: #d1ecf1;
        color: #0c5460;
    }

    .badge-secondary {
        background-color: #e2e3e5;
        color: #383d41;
    }

    .file-link {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .file-link:hover {
        text-decoration: underline;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        padding: 12px;
        border-radius: 4px;
        margin-bottom: 1rem;
        border: 1px solid #c3e6cb;
    }

    .text-center {
        text-align: center;
    }

    .text-right {
        text-align: right;
    }

    .empty-state {
        text-align: center;
        padding: 2rem;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 24px;
        margin-bottom: 8px;
    }

    @media (max-width: 768px) {
        .container-fluid {
            padding: 1rem;
        }

        .card-header {
            padding: 1rem;
            font-size: 16px;
        }

        .card-body {
            padding: 1rem;
        }

        .table th,
        .table td {
            padding: 8px;
            font-size: 13px;
        }

        .badge {
            padding: 4px 8px;
            font-size: 11px;
        }
    }
</style>

<div class="container-fluid">
    <h2>Riwayat Pinjaman</h2>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            Daftar Pengajuan Pinjaman
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 50px">No</th>
                            <th>Produk Pinjaman</th>
                            <th>Nominal</th>
                            <th>Tenor</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Tanggal Cicilan</th>
                            <th>Metode Bayar</th>
                            <th>Jaminan</th>
                            <th>Dokumen</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pinjamans as $pinjaman)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ ucfirst($pinjaman->loan_product) }}</td>
                                <td class="text-right">Rp {{ number_format($pinjaman->loan_amount, 0, ',', '.') }}</td>
                                <td class="text-center">{{ $pinjaman->tenor }} Bulan</td>
                                <td>{{ $pinjaman->application_date ? \Carbon\Carbon::parse($pinjaman->application_date)->format('d M Y') : '-' }}</td>
                                <td>{{ $pinjaman->first_payment_date ? \Carbon\Carbon::parse($pinjaman->first_payment_date)->format('d M Y') : '-' }}</td>
                                <td>{{ ucfirst($pinjaman->payment_method) }}</td>
                                <td>{{ $pinjaman->collateral ?? '-' }}</td>
                                <td class="text-center">
                                    @if($pinjaman->documents)
                                        @php
                                            $document = is_array($pinjaman->documents) ? ($pinjaman->documents[0]['file_path'] ?? null) : $pinjaman->documents;
                                        @endphp
                                        @if($document)
                                            <a href="{{ asset($document) }}" target="_blank" class="file-link">
                                                <i class="fas fa-file"></i> Dokumen
                                            </a>
                                        @else
                                            -
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($pinjaman->status == 'pending')
                                        <span class="badge badge-warning">Menunggu</span>
                                    @elseif($pinjaman->status == 'approved')
                                        <span class="badge badge-success">Disetujui</span>
                                    @elseif($pinjaman->status == 'rejected')
                                        <span class="badge badge-danger">Ditolak</span>
                                    @elseif($pinjaman->status == 'paid')
                                        <span class="badge badge-info">Lunas</span>
                                    @else
                                        <span class="badge badge-secondary">{{ ucfirst($pinjaman->status) }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10">
                                    <div class="empty-state">
                                        <i class="fas fa-history"></i>
                                        <p>Belum ada riwayat pinjaman</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const alertElement = document.querySelector('.alert-success');
        if (alertElement) {
            setTimeout(function() {
                alertElement.remove();
            }, 5000); // 5000 milidetik = 5 detik
        }
    });
</script>
@endsection 