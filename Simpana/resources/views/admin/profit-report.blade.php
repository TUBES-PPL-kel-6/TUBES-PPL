@extends('layouts.admin')

@section('title', 'Laporan Laba')
@section('header', 'Laporan Laba Koperasi')

@section('content')
<div class="container-fluid">
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted">Simplified Gross Profit Tahun {{ $year }}</h6>
                    <h2 class="card-title mb-0 text-success">Rp {{ number_format($simplifiedGrossProfit, 0, ',', '.') }}</h2>
                    <div class="mt-2">
                        <div>Total Calculated Interest: <b>Rp {{ number_format($totalCalculatedInterest, 0, ',', '.') }}</b></div>
                         <div>Total Loan Payments Received: <b>Rp {{ number_format($totalLoanPaymentsReceived, 0, ',', '.') }}</b></div>
                        <div>Total Savings Collected: <b>Rp {{ number_format($totalSimpananCollected, 0, ',', '.') }}</b></div>
                        <div class="text-danger">Total Loans Disbursed: <b>Rp {{ number_format($totalLoansDisbursed, 0, ',', '.') }}</b></div>
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
                            <th>Simpanan Collected</th>
                            <th>Loan Payments Received</th>
                            <th>Calculated Interest</th>
                            <th class="text-danger">Loans Disbursed</th>
                            <th>Simplified Gross Profit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($monthly as $row)
                        <tr>
                            <td>{{ DateTime::createFromFormat('!m', $row['bulan'])->format('F') }}</td>
                            <td>Rp {{ number_format($row['simpanan_collected'], 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($row['loan_payments_received'], 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($row['calculated_interest'], 0, ',', '.') }}</td>
                            <td class="text-danger">Rp {{ number_format($row['loans_disbursed'], 0, ',', '.') }}</td>
                            <td><b>Rp {{ number_format($row['simplified_gross_profit'], 0, ',', '.') }}</b></td>
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
