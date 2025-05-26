@extends('layouts.admin')

@section('title', 'Laporan Laba')

@section('header', 'Laporan Laba Koperasi')

@section('content')
<div class="container-fluid">
    <!-- Overview Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-subtitle mb-2 text-muted">Total Laba Tahun {{ date('Y') }}</h6>
                            <h2 class="card-title mb-0 text-success">
                                Rp {{ number_format($totalLabaTahunIni, 0, ',', '.') }}
                            </h2>
                        </div>
                        <div class="text-success">
                            <i class="fas fa-chart-line fa-2x"></i>
                        </div>
                    </div>
                    @if($pertumbuhanBulanan != 0)
                        <div class="mt-3">
                            <span class="badge @if($pertumbuhanBulanan > 0) bg-success @else bg-danger @endif">
                                {{ $pertumbuhanBulanan > 0 ? '+' : '' }}{{ number_format($pertumbuhanBulanan, 1) }}%
                            </span>
                            <small class="text-muted ms-1">dari bulan lalu</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <canvas id="profitChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Report Table -->
    <div class="card">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Rincian Laba Bulanan Tahun {{ date('Y') }}</h5>
                <div>
                    <select class="form-select form-select-sm" id="yearFilter">
                        @for($i = date('Y'); $i >= date('Y')-2; $i--)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0">Periode</th>
                            <th class="border-0">Laba Simpanan</th>
                            <th class="border-0">Laba Pinjaman</th>
                            <th class="border-0">Total Laba</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($monthlyProfits->where('tahun', date('Y')) as $profit)
                        <tr>
                            <td>{{ date('F Y', mktime(0, 0, 0, $profit['bulan'], 1, $profit['tahun'])) }}</td>
                            <td>
                                <span class="text-success">
                                    Rp {{ number_format($profit['laba_simpanan'], 0, ',', '.') }}
                                </span>
                            </td>
                            <td>
                                <span class="text-primary">
                                    Rp {{ number_format($profit['laba_pinjaman'], 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="fw-bold">
                                Rp {{ number_format($profit['total_laba'], 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    fetch('{{ route("profit-report.chart") }}')
        .then(response => response.json())
        .then(data => {
            const ctx = document.getElementById('profitChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: data,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Grafik Laba Tahun ' + new Date().getFullYear(),
                            font: {
                                size: 14
                            }
                        }
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

    // Year filter functionality
    document.getElementById('yearFilter').addEventListener('change', function(e) {
        window.location.href = `{{ route('profit-report.index') }}?year=${e.target.value}`;
    });
});
</script>
@endpush
@endsection
