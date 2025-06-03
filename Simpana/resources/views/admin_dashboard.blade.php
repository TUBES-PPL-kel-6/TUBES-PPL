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

    <div class="row mb-4">
        <!-- Grafik Laba Bulanan -->
        <div class="col-md-7 mb-3">
            <div class="card p-3 h-100">
                <h5 class="mb-3">Grafik Laba Bulanan Tahun {{ $year }}</h5>
                <div>
                    <canvas id="dashboardProfitChart"></canvas>
                </div>
            </div>
        </div>
        <!-- Ringkasan Laporan Laba (SHU) -->
        <div class="col-md-5 mb-3">
            <div class="card p-4 h-100 d-flex flex-column justify-content-between">
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
                <div class="mt-3">
                    <a href="{{ route('admin.shu.index') }}" class="btn btn-outline-secondary btn-sm w-100">
                        <i class="fa-solid fa-calculator"></i> Generate SHU
                    </a>
                </div>
            </div>
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


@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chartData = {
        labels: {!! json_encode(array_map(fn($r) => DateTime::createFromFormat('!m', $r['bulan'])->format('F'), $monthly)) !!},
        datasets: [
            {
                label: 'Laba Kotor Sederhana',
                data: {!! json_encode(array_column($monthly, 'simplified_gross_profit')) !!},
                borderColor: 'rgba(34, 197, 94, 1)',
                backgroundColor: 'rgba(34, 197, 94, 0.2)',
                borderWidth: 2,
                fill: true
            },
             {
                label: 'Bunga Terhitung',
                data: {!! json_encode(array_column($monthly, 'calculated_interest')) !!},
                borderColor: 'rgba(255, 159, 64, 1)',
                backgroundColor: 'rgba(255, 159, 64, 0.2)',
                borderWidth: 2,
                hidden: true
            },
            {
                label: 'Simpanan Terkumpul',
                data: {!! json_encode(array_column($monthly, 'simpanan_collected')) !!},
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderWidth: 2,
                 hidden: true
            },
            {
                label: 'Pembayaran Pinjaman Diterima',
                data: {!! json_encode(array_column($monthly, 'loan_payments_received')) !!},
                borderColor: 'rgba(255, 99, 132, 1)',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderWidth: 2,
                 hidden: true
            },
             {
                label: 'Pinjaman Dicairkan',
                data: {!! json_encode(array_column($monthly, 'loans_disbursed')) !!},
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderWidth: 2,
                 hidden: true
            }
        ]
    };
    new Chart(document.getElementById('dashboardProfitChart').getContext('2d'), {
        type: 'line',
        data: chartData,
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                title: { display: true, text: 'Grafik Laba Tahun {{ $year }}' }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush
