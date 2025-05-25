@extends('layouts.admin')

@section('title', 'Verifikasi Pembayaran Pinjaman')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-money-check-alt mr-2"></i>Verifikasi Pembayaran Pinjaman
        </h1>
        <div class="d-flex">
            <span class="badge badge-warning mr-2">
                <i class="fas fa-clock mr-1"></i>{{ $pendingPayments->total() }} Menunggu
            </span>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    <!-- Payments Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Pembayaran Menunggu Verifikasi</h6>
        </div>
        <div class="card-body">
            @if($pendingPayments->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Peminjam</th>
                                <th>Angsuran Ke-</th>
                                <th>Jumlah</th>
                                <th>Jatuh Tempo</th>
                                <th>Metode Bayar</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingPayments as $payment)
                            <tr>
                                <td>{{ $payment->payment_date ? $payment->payment_date->format('d/m/Y') : '-' }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm mr-2">
                                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                <span class="text-white text-sm">{{ substr($payment->loanApplication->user->nama ?? $payment->loanApplication->user->name, 0, 1) }}</span>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="font-weight-bold">{{ $payment->loanApplication->user->nama ?? $payment->loanApplication->user->name }}</div>
                                            <div class="text-muted small">ID: {{ $payment->loan_application_id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-info">{{ $payment->installment_number }}</span>
                                </td>
                                <td>
                                    <span class="font-weight-bold text-success">
                                        Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td>
                                    @if($payment->due_date)
                                        @php
                                            $isOverdue = $payment->due_date->isPast();
                                        @endphp
                                        <span class="badge {{ $isOverdue ? 'badge-danger' : 'badge-warning' }}">
                                            {{ $payment->due_date->format('d/m/Y') }}
                                            @if($isOverdue)
                                                <i class="fas fa-exclamation-triangle ml-1"></i>
                                            @endif
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @switch($payment->payment_method)
                                        @case('transfer')
                                            <span class="badge badge-primary">
                                                <i class="fas fa-university mr-1"></i>Transfer
                                            </span>
                                            @break
                                        @case('cash')
                                            <span class="badge badge-success">
                                                <i class="fas fa-money-bill mr-1"></i>Tunai
                                            </span>
                                            @break
                                        @case('debit')
                                            <span class="badge badge-info">
                                                <i class="fas fa-credit-card mr-1"></i>Debit
                                            </span>
                                            @break
                                    @endswitch
                                </td>
                                <td>
                                    <span class="badge badge-warning">
                                        <i class="fas fa-clock mr-1"></i>Pending
                                    </span>
                                </td>
                                <td>
                                    <div class="dropdown text-right">
                                        <button class="btn btn-outline-primary btn-sm"
                                            type="button"
                                            id="aksiDropdown{{ $payment->id }}"
                                            data-toggle="dropdown"
                                            aria-haspopup="true"
                                            aria-expanded="false">
                                            Aksi
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="aksiDropdown{{ $payment->id }}">
                                            <!-- Detail Button triggers modal -->
                                            <button type="button" class="dropdown-item text-primary" data-toggle="modal" data-target="#detailModal{{ $payment->id }}">
                                                <i class="fas fa-eye mr-2"></i> Detail
                                            </button>
                                            <!-- Verifikasi -->
                                            <form action="{{ route('admin.payment.verify', $payment->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="dropdown-item text-success">
                                                    <i class="fas fa-check mr-2"></i> Verifikasi
                                                </button>
                                            </form>
                                            <!-- Tolak Button triggers modal -->
                                            <button type="button" class="dropdown-item text-danger" data-toggle="modal" data-target="#rejectModal{{ $payment->id }}">
                                                <i class="fas fa-times mr-2"></i> Tolak
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Place all modals here, after the table --}}
                @foreach($pendingPayments as $payment)
                    <!-- Detail Modal -->
                    <div class="modal fade" id="detailModal{{ $payment->id }}" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">
                                        <i class="fas fa-info-circle mr-2"></i>Detail Pembayaran
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal">
                                        <span>&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6><i class="fas fa-user mr-2 text-primary"></i>Informasi Peminjam</h6>
                                            <table class="table table-sm">
                                                <tr><td><strong>Nama:</strong></td><td>{{ $payment->loanApplication->user->nama ?? $payment->loanApplication->user->name }}</td></tr>
                                                <tr><td><strong>ID Pinjaman:</strong></td><td>{{ $payment->loan_application_id }}</td></tr>
                                            </table>
                                            <h6><i class="fas fa-calendar mr-2 text-primary"></i>Informasi Pembayaran</h6>
                                            <table class="table table-sm">
                                                <tr><td><strong>Angsuran Ke-:</strong></td><td><span class="badge badge-info">{{ $payment->installment_number }}</span></td></tr>
                                                <tr><td><strong>Jumlah:</strong></td><td><span class="text-success font-weight-bold">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span></td></tr>
                                                <tr><td><strong>Tanggal Bayar:</strong></td><td>{{ $payment->payment_date ? $payment->payment_date->format('d/m/Y') : '-' }}</td></tr>
                                                <tr><td><strong>Jatuh Tempo:</strong></td><td>{{ $payment->due_date ? $payment->due_date->format('d/m/Y') : '-' }}</td></tr>
                                                <tr><td><strong>Metode:</strong></td><td>{{ $payment->payment_method }}</td></tr>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <h6><i class="fas fa-file-image mr-2 text-primary"></i>Bukti Pembayaran</h6>
                                            @if($payment->payment_proof)
                                                <div class="text-center">
                                                    <img src="{{ asset(str_replace('public/', 'storage/', $payment->payment_proof)) }}" class="img-fluid border rounded" style="max-height: 300px;" alt="Bukti Pembayaran">
                                                    <br><br>
                                                    <a href="{{ asset(str_replace('public/', 'storage/', $payment->payment_proof)) }}" target="_blank" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-external-link-alt mr-1"></i>Buka di Tab Baru
                                                    </a>
                                                </div>
                                            @else
                                                <p class="text-muted">Tidak ada bukti pembayaran.</p>
                                            @endif
                                            @if($payment->notes)
                                                <h6 class="mt-3"><i class="fas fa-sticky-note mr-2 text-primary"></i>Catatan</h6>
                                                <p class="text-muted">{{ $payment->notes }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reject Modal -->
                    <div class="modal fade" id="rejectModal{{ $payment->id }}" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form action="{{ route('admin.payment.reject', $payment->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title text-danger">
                                            <i class="fas fa-times-circle mr-2"></i>Tolak Pembayaran
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal">
                                            <span>&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="alert alert-warning">
                                            <i class="fas fa-exclamation-triangle mr-2"></i>
                                            Anda akan menolak pembayaran ini. Pastikan alasan penolakan jelas dan akurat.
                                        </div>
                                        <div class="form-group">
                                            <label for="rejection_reason_{{ $payment->id }}">Alasan Penolakan <span class="text-danger">*</span></label>
                                            <textarea class="form-control" id="rejection_reason_{{ $payment->id }}" name="rejection_reason"
                                                rows="3" placeholder="Masukkan alasan penolakan..." required></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-times mr-2"></i>Tolak Pembayaran
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-100">
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-gray-600">
                            Menampilkan {{ $pendingPayments->firstItem() }} sampai {{ $pendingPayments->lastItem() }}
                            dari {{ $pendingPayments->total() }} data
                        </p>
                        <div class="flex gap-1">
                            @if ($pendingPayments->onFirstPage())
                                <span class="px-3 py-1 text-sm text-gray-400 bg-gray-100 rounded-md cursor-not-allowed">
                                    Previous
                                </span>
                            @else
                                <a href="{{ $pendingPayments->previousPageUrl() }}"
                                    class="px-3 py-1 text-sm text-gray-600 bg-white border border-gray-200 rounded-md hover:bg-gray-50 transition-colors">
                                    Previous
                                </a>
                            @endif

                            @foreach ($pendingPayments->getUrlRange(1, $pendingPayments->lastPage()) as $page => $url)
                                @if ($page == $pendingPayments->currentPage())
                                    <span class="px-3 py-1 text-sm text-white bg-primary rounded-md">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}"
                                        class="px-3 py-1 text-sm text-gray-600 bg-white border border-gray-200 rounded-md hover:bg-gray-50 transition-colors">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach

                            @if ($pendingPayments->hasMorePages())
                                <a href="{{ $pendingPayments->nextPageUrl() }}"
                                    class="px-3 py-1 text-sm text-gray-600 bg-white border border-gray-200 rounded-md hover:bg-gray-50 transition-colors">
                                    Next
                                </a>
                            @else
                                <span class="px-3 py-1 text-sm text-gray-400 bg-gray-100 rounded-md cursor-not-allowed">
                                    Next
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-check-circle text-success" style="font-size: 3rem;"></i>
                    <h5 class="mt-3">Tidak ada pembayaran yang perlu diverifikasi</h5>
                    <p class="text-muted">Semua pembayaran sudah diproses.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.table td {
    vertical-align: middle;
    padding: 0.75rem;
}

.modal-lg {
    max-width: 900px;
}

button {
    transition: all 0.2s;
}

button:hover {
    transform: translateY(-1px);
}

button:active {
    transform: translateY(0);
}
</style>
@endsection
