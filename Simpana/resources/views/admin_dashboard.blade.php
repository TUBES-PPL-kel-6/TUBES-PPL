@php
use Illuminate\Support\Facades\Auth;
@endphp

@extends('layouts.admin')

@section('title', 'Dashboard Pengurus')
@section('header', 'Dashboard Pengurus')

@section('content')
    <div class="row mb-4">
        <!-- Stats Cards -->
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <div class="mb-2">
                        <i class="fas fa-users fa-2x text-primary"></i>
                    </div>
                    <h6 class="text-muted">Anggota Aktif</h6>
                    <h3 class="font-weight-bold mb-0">{{ number_format($totalAnggota ?? 0) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <div class="mb-2">
                        <i class="fas fa-wallet fa-2x text-success"></i>
                    </div>
                    <h6 class="text-muted">Total Simpanan</h6>
                    <h3 class="font-weight-bold mb-0">Rp {{ number_format($totalSimpanan ?? 0, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <div class="mb-2">
                        <i class="fas fa-hand-holding-usd fa-2x text-warning"></i>
                    </div>
                    <h6 class="text-muted">Pinjaman Aktif</h6>
                    <h3 class="font-weight-bold mb-0">{{ number_format($totalPinjamanAktif ?? 0) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <div class="mb-2">
                        <i class="fas fa-money-bill-wave fa-2x text-danger"></i>
                    </div>
                    <h6 class="text-muted">Total Pinjaman</h6>
                    <h3 class="font-weight-bold mb-0">Rp {{ number_format($totalNominalPinjaman ?? 0, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaksi Terbaru -->
    <h5 class="mb-3">Transaksi Terbaru</h5>
    <div class="card p-3 mb-4">
        <div class="list-group">
            @forelse($transaksiTerbaru as $trx)
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong>{{ $trx->jenis_transaksi ?? '-' }}</strong>
                        <small class="text-muted">
                            {{ $trx->user->nama ?? '-' }} &middot; {{ \Carbon\Carbon::parse($trx->created_at)->format('d M Y H:i') }}
                        </small>
                        @if($trx->keterangan)
                            <div class="text-muted small">{{ $trx->keterangan }}</div>
                        @endif
                    </div>
                    <div>
                        <span class="mr-2 {{ $trx->jumlah > 0 ? 'text-success' : 'text-danger' }}">
                            {{ $trx->jumlah > 0 ? '+' : '-' }} Rp {{ number_format(abs($trx->jumlah), 0, ',', '.') }}
                        </span>
                        <span class="badge {{ $trx->status == 'approved' ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ ucfirst($trx->status) }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="list-group-item text-center text-muted">
                    Tidak ada transaksi terbaru.
                </div>
            @endforelse
        </div>
        <div class="mt-3 text-end">
            <!-- Lihat Semua Transaksi -->
            <a href="{{ route('dashboard.transactions') }}" class="btn btn-sm btn-outline-primary">
                <i class="fa fa-list"></i> Lihat Semua Transaksi
            </a>
        </div>
    </div>

    <!-- Top Penabung Bulan Ini -->
    <h5 class="mb-3">Top Penabung Bulan Ini</h5>
    <div class="p-4 bg-white rounded shadow-sm mb-4">
        <ol class="list-group list-group-numbered">
            @forelse($topPenabung as $user)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>
                        <i class="fas fa-crown text-warning mr-2"></i>
                        {{ $user->nama }}
                    </span>
                    <span class="badge bg-primary">
                        Rp {{ number_format($user->simpanans_sum_jumlah ?? 0, 0, ',', '.') }}
                    </span>
                </li>
            @empty
                <li class="list-group-item text-muted">Belum ada data penabung bulan ini.</li>
            @endforelse
        </ol>
        <div class="mt-3 text-end">
            <!-- Lihat Semua Anggota -->
            <a href="{{ route('admin.users') }}" class="btn btn-sm btn-outline-primary">
                <i class="fa fa-users"></i> Lihat Semua Anggota
            </a>
        </div>
    </div>

    <!-- Quick Actions (Aksi Cepat) -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <a href="{{ route('admin.payment-verification') }}" class="btn btn-lg btn-primary w-100 d-flex align-items-center justify-content-center gap-2">
                <i class="fa-solid fa-clipboard-check"></i> Verifikasi Pembayaran
            </a>
        </div>
        <div class="col-md-4 mb-3">
            <a href="{{ route('loanApproval') }}" class="btn btn-lg btn-success w-100 d-flex align-items-center justify-content-center gap-2">
                <i class="fa-solid fa-file-signature"></i> Verifikasi Pinjaman
            </a>
        </div>
        <div class="col-md-4 mb-3">
            <a href="{{ route('complaint.create') }}" class="btn btn-lg btn-warning w-100 d-flex align-items-center justify-content-center gap-2">
                <i class="fa-solid fa-comment-dots"></i> Kelola Feedback
            </a>
        </div>
    </div>

    <!-- Ringkasan Laporan Laba (SHU) -->
    <div class="card p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h6 class="mb-1 text-muted">Laporan Laba (SHU) Terakhir</h6>
                <div class="fw-bold">
                    @if(isset($lastShu) && $lastShu)
                        Tahun {{ $lastShu->tahun }} &middot; Rp {{ number_format($lastShu->total_shu, 0, ',', '.') }}
                    @else
                        Belum ada data SHU.
                    @endif
                </div>
            </div>
            <!-- SHU -->
            <a href="{{ route('admin.shu.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fa-solid fa-calculator"></i> Generate SHU
            </a>
        </div>
    </div>

    <!-- Go to User Dashboard -->
    <a href="{{ route('user.dashboard') }}" class="btn btn-primary mb-3">Go to User Dashboard</a>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush
