@extends('layouts.dashboard')

@section('content')
<style>
    /* Compact & Modern Red Theme for Loan History */
    :root {
        --primary-red: #E53935; /* Vibrant Red */
        --dark-red: #C62828; /* Slightly deeper red for accents */
        --light-bg: #f0f2f5; /* Modern very light grey background */
        --dark-text: #2c3e50; /* Dark almost-black text */
        --medium-text: #7f8c8d; /* Medium grey for subtle text */
        --border-subtle: #dcdfe6; /* Soft subtle border */
        --card-bg: #ffffff; /* Clean white card background */
        --header-gradient: linear-gradient(135deg, #E53935, #D32F2F); /* Vibrant red gradient */
        --table-header-bg: #ecf0f1; /* Very light table header */
        --row-hover-bg: #f8f9fa; /* Subtle row hover */
        --success-badge: #2ecc71;
        --warning-badge: #f39c12;
        --danger-badge: #e74c3c;
        --info-badge: #3498db;
    }

    body {
        background-color: var(--light-bg);
        font-family: 'Poppins', sans-serif;
        color: var(--dark-text);
        padding-bottom: 60px; /* Adjusted padding */
        line-height: 1.6; /* Slightly reduced line height */
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    .container-fluid {
        padding-top: 40px; /* Adjusted padding */
    }

    h2 {
        color: var(--dark-red);
        margin-bottom: 40px; /* Adjusted margin */
        font-size: 2.5rem; /* Reduced heading size */
        font-weight: 700;
        text-align: center;
        position: relative;
        letter-spacing: -0.5px; /* Adjusted letter spacing */
    }

    h2::after {
        content: '';
        display: block;
        width: 80px; /* Reduced underline width */
        height: 4px; /* Reduced underline height */
        background-color: var(--primary-red);
        margin: 15px auto 0; /* Adjusted margin */
        border-radius: 2px; /* Adjusted border radius */
    }

    .card {
        border: none;
        border-radius: 15px; /* Adjusted border radius */
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1); /* Adjusted shadow */
        overflow: hidden;
        background-color: var(--card-bg);
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out; /* Adjusted transition */
    }

    .card:hover {
        transform: translateY(-5px); /* Adjusted lift effect */
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15); /* Adjusted shadow on hover */
    }

    .card-header {
        background: var(--header-gradient);
        color: white;
        padding: 18px 25px; /* Reduced padding */
        font-size: 1.2em; /* Adjusted font size */
        font-weight: 600;
        border-bottom: none;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3); /* Adjusted text shadow */
        position: relative;
    }

    .card-header::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(255, 255, 255, 0.03); /* Slightly less opaque overlay */
        pointer-events: none;
    }

    .card-body {
        padding: 25px; /* Reduced padding */
    }

    .table {
        margin-bottom: 0;
        border-collapse: separate;
        border-spacing: 0 8px; /* Reduced space between rows */
        width: 100%;
    }

    .table th,
    .table td {
        padding: 15px 20px; /* Reduced padding */
        vertical-align: middle;
        border-top: none;
    }

    .table th {
        background-color: var(--table-header-bg);
        color: var(--medium-text);
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.8em; /* Adjusted header font size */
        border-bottom: none;
        letter-spacing: 0.5px; /* Adjusted letter spacing */
    }

     .table tbody tr {
        background-color: #fff;
        border-radius: 10px; /* Adjusted rounded corners */
        overflow: hidden;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.08); /* Adjusted row shadow */
        transition: all 0.2s ease-in-out; /* Adjusted transition */
        border: 1px solid var(--border-subtle); /* Subtle border on rows */
    }

    .table tbody tr:hover {
        background-color: var(--row-hover-bg);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.12); /* Adjusted shadow on hover */
        transform: translateY(-3px); /* Adjusted lift effect */
    }

     .table tbody tr td:first-child {
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
    }
    .table tbody tr td:last-child {
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
    }

    .table tbody tr:last-child td {
        border-bottom: none;
    }

    .badge {
        padding: 0.5em 1em; /* Adjusted padding */
        border-radius: 20px; /* Adjusted rounded badges */
        font-weight: 700;
        font-size: 0.8em; /* Adjusted badge text size */
        text-transform: uppercase;
        min-width: 90px; /* Adjusted minimum width */
        display: inline-block;
        text-align: center;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08); /* Adjusted badge shadow */
    }

    .badge-warning {
        background-color: var(--warning-badge);
        color: white;
    }

    .badge-success {
        background-color: var(--success-badge);
        color: white;
    }

    .badge-danger {
        background-color: var(--danger-badge);
        color: white;
    }

    .badge-info {
        background-color: var(--info-badge);
        color: white;
    }
     .badge-secondary {
        background-color: #95a5a6;
        color: white;
    }

    .file-link {
        color: var(--dark-red);
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s ease-in-out;
        display: inline-flex;
        align-items: center;
        font-size: 0.9em; /* Adjusted font size */
    }

    .file-link i {
        margin-right: 6px; /* Adjusted space */
        font-size: 1em; /* Adjusted icon size */
    }

    .file-link:hover {
        color: var(--primary-red);
        text-decoration: underline;
    }

    .table-responsive {
        margin-top: 30px; /* Adjusted space above table */
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border-color: #c3e6cb;
        border-radius: 8px; /* Adjusted rounded alert */
        padding: 15px; /* Adjusted padding */
        margin-bottom: 30px; /* Adjusted margin */
        font-size: 1em; /* Adjusted font size */
        box-shadow: 0 2px 4px rgba(40, 167, 69, 0.15); /* Adjusted shadow */
    }

    .text-center {
        text-align: center;
    }

    /* Responsive Adjustments */
    @media (max-width: 1200px) {
         .card-body {
            padding: 30px;
        }
        .table th,
        .table td {
            padding: 15px 20px;
            font-size: 0.8em;
        }
         h2 {
            font-size: 2.5rem;
            margin-bottom: 30px;
        }
         h2::after {
             width: 80px;
             height: 4px;
             margin: 10px auto 0;
         }
         .badge {
            padding: 0.4em 0.8em;
            min-width: 80px;
            font-size: 0.75em;
         }
         .table tbody tr {
            margin-bottom: 6px;
         }
         .table {
             border-spacing: 0 6px;
         }
         .file-link {
            font-size: 0.85em;
         }
    }

    @media (max-width: 992px) {
         .card-header {
            padding: 18px 25px;
            font-size: 1.1em;
        }
        .card-body {
            padding: 25px;
        }
        .table th,
        .table td {
            padding: 12px 15px;
            font-size: 0.75em;
        }
        h2 {
            font-size: 2.2rem;
            margin-bottom: 30px;
        }
        h2::after {
            width: 60px;
            height: 3px;
            margin: 8px auto 0;
        }
         .badge {
            padding: 0.3em 0.7em;
            border-radius: 18px;
            font-size: 0.7em;
            min-width: 60px;
         }
         .table tbody tr {
            margin-bottom: 4px;
        }
         .table {
             border-spacing: 0 4px;
         }
         .file-link {
            font-size: 0.8em;
         }
         .alert-success {
            padding: 15px;
            margin-bottom: 30px;
            font-size: 1em;
         }
    }

     @media (max-width: 768px) {
        .card-body {
            padding: 20px;
        }
        .table th,
        .table td {
            padding: 10px 12px;
            font-size: 0.7em;
        }
        h2 {
            font-size: 2rem;
            margin-bottom: 25px;
        }
        h2::after {
            width: 50px;
            height: 3px;
            margin: 6px auto 0;
        }
         .badge {
            padding: 0.25em 0.6em;
            border-radius: 15px;
            font-size: 0.65em;
            min-width: 50px;
         }
         .table tbody tr {
            margin-bottom: 3px;
        }
         .table {
             border-spacing: 0 3px;
         }
         .file-link {
            font-size: 0.75em;
         }
         .alert-success {
            padding: 12px;
            margin-bottom: 25px;
            font-size: 0.9em;
         }
    }

    @media (max-width: 576px) {
        .card-header {
            padding: 12px 18px;
            font-size: 1em;
        }
        .card-body {
            padding: 12px;
        }
         .table th,
        .table td {
            padding: 8px 10px;
            font-size: 0.65em;
        }
         h2 {
            font-size: 1.6rem;
            margin-bottom: 18px;
         }
         h2::after {
             width: 40px;
             margin: 4px auto 0;
         }
         .badge {
            padding: 0.2em 0.4em;
            border-radius: 12px;
            font-size: 0.55em;
            min-width: 40px;
         }
         .table tbody tr {
            margin-bottom: 2px;
        }
         .table {
             border-spacing: 0 2px;
         }
          .file-link {
            font-size: 0.7em;
         }
          .alert-success {
            padding: 10px;
            margin-bottom: 20px;
            font-size: 0.8em;
         }
    }


</style>

<div class="container-fluid">
    <h2>Riwayat Pinjaman</h2>

    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            Daftar Pengajuan Pinjaman Anda
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Produk Pinjaman</th>
                            <th>Nominal</th>
                            <th>Tenor</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Tanggal Cicilan Pertama</th>
                            <th>Metode Bayar</th>
                            <th>Jaminan</th>
                            <th>Dokumen</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pinjamans as $pinjaman)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ ucfirst($pinjaman->loan_product) }}</td>
                                <td>Rp {{ number_format($pinjaman->loan_amount, 0, ',', '.') }}</td>
                                <td>{{ $pinjaman->tenor }} Bulan</td>
                                <td>{{ $pinjaman->application_date ? \Carbon\Carbon::parse($pinjaman->application_date)->format('d M Y') : '-' }}</td>
                                <td>{{ $pinjaman->first_payment_date ? \Carbon\Carbon::parse($pinjaman->first_payment_date)->format('d M Y') : '-' }}</td>
                                <td>{{ ucfirst($pinjaman->payment_method) }}</td>
                                <td>{{ $pinjaman->collateral ?? '-' }}</td>
                                <td>
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
                                <td>
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
                                <td colspan="10" class="text-center py-4">Belum ada riwayat pinjaman</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 