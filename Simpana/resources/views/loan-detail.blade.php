@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Detail Pinjaman</h3>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>Produk Pinjaman</th>
                                <td>{{ $loanApplication->loan_product }}</td>
                            </tr>
                            <tr>
                                <th>Jumlah Pinjaman</th>
                                <td>Rp {{ number_format($loanApplication->loan_amount, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>Tenor</th>
                                <td>{{ $loanApplication->tenor }} bulan</td>
                            </tr>
                            <tr>
                                <th>Tanggal Pengajuan</th>
                                <td>{{ \Carbon\Carbon::parse($loanApplication->application_date)->translatedFormat('d F Y') }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Pembayaran Pertama</th>
                                <td>{{ \Carbon\Carbon::parse($loanApplication->first_payment_date)->translatedFormat('d F Y') }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if($loanApplication->status == 'pending')
                                        <span class="badge badge-warning">Menunggu Persetujuan</span>
                                    @elseif($loanApplication->status == 'approved')
                                        <span class="badge badge-success">Disetujui</span>
                                    @elseif($loanApplication->status == 'rejected')
                                        <span class="badge badge-danger">Ditolak</span>
                                    @elseif($loanApplication->status == 'completed')
                                        <span class="badge badge-info">Lunas</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>

                    @if($loanApplication->status == 'approved')
                    <div class="mt-4">
                        <a href="{{ route('early-repayment.show', $loanApplication->id) }}" class="btn btn-primary">
                            <i class="fas fa-money-bill-wave mr-2"></i>Lunasi Sekarang
                        </a>
                    </div>
                    @endif

                    <div class="mt-4">
                        <a href="{{ route('loan.index') }}" class="btn btn-secondary">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 