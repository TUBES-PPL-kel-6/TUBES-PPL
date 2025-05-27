@extends('layouts.admin')

@section('title', 'Laporan Laba')
@section('header', 'Laporan Laba Koperasi')

@section('content')
<div class="container-fluid">
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted">Total Laba Bersih Tahun {{ $year }}</h6>
                    <h2 class="card-title mb-0 text-success">Rp {{ number_format($totalLaba, 0, ',', '.') }}</h2>
                    <div class="mt-2">
                        <div>Laba Simpanan: <b>Rp {{ number_format($labaSimpanan, 0, ',', '.') }}</b></div>
                        <div>Laba Pinjaman: <b>Rp {{ number_format($labaPinjaman, 0, ',', '.') }}</b></div>
                        <div class="text-danger">Pengeluaran Pinjaman: <b>Rp {{ number_format($pengeluaranPinjaman, 0, ',', '.') }}</b></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-body">
                    <canvas id="profitChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Rincian Laba Bulanan Tahun {{ $year }}</h5>
                <form>
                    <select class="form-select form-select-sm" name="year" onchange="this.form.submit()">
                        @for($i = date('Y'); $i >= date('Y')-2; $i--)
                            <option value="{{ $i }}" @if($year == $i) selected @endif>{{ $i }}</option>
                        @endfor
                    </select>
                </form>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Bulan</th>
                            <th>Laba Simpanan</th>
                            <th>Laba Pinjaman</th>
                            <th class="text-danger">Pengeluaran</th>
                            <th>Total Laba Bersih</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($monthly as $row)
                        <tr>
                            <td>{{ DateTime::createFromFormat('!m', $row['bulan'])->format('F') }}</td>
                            <td>Rp {{ number_format($row['laba_simpanan'], 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($row['laba_pinjaman'], 0, ',', '.') }}</td>
                            <td class="text-danger">Rp {{ number_format($row['pengeluaran'], 0, ',', '.') }}</td>
                            <td><b>Rp {{ number_format($row['total_laba'], 0, ',', '.') }}</b></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chartData = {
        labels: {!! json_encode(array_map(fn($r) => DateTime::createFromFormat('!m', $r['bulan'])->format('F'), $monthly)) !!},
        datasets: [
            {
                label: 'Laba Simpanan',
                data: {!! json_encode(array_column($monthly, 'laba_simpanan')) !!},
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderWidth: 2
            },
            {
                label: 'Laba Pinjaman',
                data: {!! json_encode(array_column($monthly, 'laba_pinjaman')) !!},
                borderColor: 'rgba(255, 99, 132, 1)',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderWidth: 2
            }
        ]
    };
    new Chart(document.getElementById('profitChart').getContext('2d'), {
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
@endsection
