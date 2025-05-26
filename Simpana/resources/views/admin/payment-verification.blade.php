@extends('layouts.admin')

@section('title', 'Verifikasi Pembayaran Pinjaman')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-dark">
            <i class="bi bi-cash-coin me-2"></i>Verifikasi Pembayaran Pinjaman
        </h1>
        <div>
            <span class="badge bg-warning text-dark me-2">
                <i class="bi bi-clock me-1"></i>{{ $pendingPayments->total() }} Menunggu
            </span>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Payments Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 fw-bold text-primary">Pembayaran Menunggu Verifikasi</h6>
        </div>
        <div class="card-body">
            @if($pendingPayments->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
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
                                        <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                            <span class="text-white">{{ substr($payment->loanApplication->user->nama ?? $payment->loanApplication->user->name, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <div class="fw-bold">{{ $payment->loanApplication->user->nama ?? $payment->loanApplication->user->name }}</div>
                                            <div class="text-muted small">ID: {{ $payment->loan_application_id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info text-dark">{{ $payment->installment_number }}</span>
                                </td>
                                <td>
                                    <span class="fw-bold text-success">
                                        Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td>
                                    @if($payment->due_date)
                                        @php
                                            $isOverdue = $payment->due_date->isPast();
                                        @endphp
                                        <span class="badge {{ $isOverdue ? 'bg-danger' : 'bg-warning text-dark' }}">
                                            {{ $payment->due_date->format('d/m/Y') }}
                                            @if($isOverdue)
                                                <i class="bi bi-exclamation-triangle ms-1"></i>
                                            @endif
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @switch($payment->payment_method)
                                        @case('transfer')
                                            <span class="badge bg-primary">
                                                <i class="bi bi-bank me-1"></i>Transfer
                                            </span>
                                            @break
                                        @case('cash')
                                            <span class="badge bg-success">
                                                <i class="bi bi-cash me-1"></i>Tunai
                                            </span>
                                            @break
                                        @case('debit')
                                            <span class="badge bg-info text-dark">
                                                <i class="bi bi-credit-card me-1"></i>Debit
                                            </span>
                                            @break
                                    @endswitch
                                </td>
                                <td>
                                    <span class="badge bg-warning text-dark">
                                        <i class="bi bi-clock me-1"></i>Pending
                                    </span>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-outline-primary btn-sm dropdown-toggle"
                                            type="button"
                                            id="aksiDropdown{{ $payment->id }}"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            Aksi
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="aksiDropdown{{ $payment->id }}">
                                            <!-- Detail Button triggers modal -->
                                            <li>
                                                <button type="button" class="dropdown-item text-primary" data-bs-toggle="modal" data-bs-target="#detailModal{{ $payment->id }}">
                                                    <i class="bi bi-eye me-2"></i> Detail
                                                </button>
                                            </li>
                                            <!-- Verifikasi -->
                                            <li>
                                                <form action="{{ route('admin.payment.verify', $payment->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item text-success">
                                                        <i class="bi bi-check2-circle me-2"></i> Verifikasi
                                                    </button>
                                                </form>
                                            </li>
                                            <!-- Tolak Button triggers modal -->
                                            <li>
                                                <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $payment->id }}">
                                                    <i class="bi bi-x-circle me-2"></i> Tolak
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        <small>
                            Menampilkan {{ $pendingPayments->firstItem() }} sampai {{ $pendingPayments->lastItem() }}
                            dari {{ $pendingPayments->total() }} data
                        </small>
                    </div>
                    <nav>
                        {{ $pendingPayments->links('pagination::bootstrap-5') }}
                    </nav>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-check-circle text-success" style="font-size: 3rem;"></i>
                    <h5 class="mt-3">Tidak ada pembayaran yang perlu diverifikasi</h5>
                    <p class="text-muted">Semua pembayaran sudah diproses.</p>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Modals --}}
@foreach($pendingPayments as $payment)
    <!-- Detail Modal -->
    <div class="modal fade" id="detailModal{{ $payment->id }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $payment->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel{{ $payment->id }}">
                        <i class="bi bi-info-circle me-2"></i>Detail Pembayaran
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6><i class="bi bi-person me-2 text-primary"></i>Informasi Peminjam</h6>
                            <table class="table table-sm">
                                <tr><td><strong>Nama:</strong></td><td>{{ $payment->loanApplication->user->nama ?? $payment->loanApplication->user->name }}</td></tr>
                                <tr><td><strong>ID Pinjaman:</strong></td><td>{{ $payment->loan_application_id }}</td></tr>
                            </table>
                            <h6><i class="bi bi-calendar3 me-2 text-primary"></i>Informasi Pembayaran</h6>
                            <table class="table table-sm">
                                <tr><td><strong>Angsuran Ke-:</strong></td><td><span class="badge bg-info text-dark">{{ $payment->installment_number }}</span></td></tr>
                                <tr><td><strong>Jumlah:</strong></td><td><span class="text-success fw-bold">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span></td></tr>
                                <tr><td><strong>Tanggal Bayar:</strong></td><td>{{ $payment->payment_date ? $payment->payment_date->format('d/m/Y') : '-' }}</td></tr>
                                <tr><td><strong>Jatuh Tempo:</strong></td><td>{{ $payment->due_date ? $payment->due_date->format('d/m/Y') : '-' }}</td></tr>
                                <tr><td><strong>Metode:</strong></td><td>{{ $payment->payment_method }}</td></tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="bi bi-image me-2 text-primary"></i>Bukti Pembayaran</h6>
                            @if($payment->payment_proof)
                                <div class="text-center">
                                    <img src="{{ asset(str_replace('public/', 'storage/', $payment->payment_proof)) }}" class="img-fluid border rounded mb-2" style="max-height: 300px;" alt="Bukti Pembayaran">
                                    <br>
                                    <a href="{{ asset(str_replace('public/', 'storage/', $payment->payment_proof)) }}" target="_blank" class="btn btn-sm btn-primary">
                                        <i class="bi bi-box-arrow-up-right me-1"></i>Buka di Tab Baru
                                    </a>
                                </div>
                            @else
                                <p class="text-muted">Tidak ada bukti pembayaran.</p>
                            @endif
                            @if($payment->notes)
                                <h6 class="mt-3"><i class="bi bi-sticky me-2 text-primary"></i>Catatan</h6>
                                <p class="text-muted">{{ $payment->notes }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div class="modal fade" id="rejectModal{{ $payment->id }}" tabindex="-1" aria-labelledby="rejectModalLabel{{ $payment->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('admin.payment.reject', $payment->id) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title text-danger" id="rejectModalLabel{{ $payment->id }}">
                            <i class="bi bi-x-circle me-2"></i>Tolak Pembayaran
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Anda akan menolak pembayaran ini. Pastikan alasan penolakan jelas dan akurat.
                        </div>
                        <div class="mb-3">
                            <label for="rejection_reason_{{ $payment->id }}" class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="rejection_reason_{{ $payment->id }}" name="rejection_reason"
                                rows="3" placeholder="Masukkan alasan penolakan..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-x-circle me-2"></i>Tolak Pembayaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
@endsection

@push('styles')
<style>
.table td {
    vertical-align: middle;
    padding: 0.75rem;
}

.modal-lg {
    max-width: 900px;
}

/* Fix dropdown positioning and z-index */
.table-responsive {
    overflow: visible !important;
}

.table td {
    position: relative;
    overflow: visible !important;
}

.dropdown {
    position: static !important;
}

.dropdown-menu {
    position: absolute !important;
    z-index: 1050 !important;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    border: 1px solid rgba(0, 0, 0, 0.15) !important;
    background: white !important;
    min-width: 120px;
}

.dropdown.show .dropdown-menu {
    display: block !important;
}

/* Prevent table overflow clipping */
.card-body {
    overflow: visible !important;
}

.table {
    overflow: visible !important;
}

.table tbody tr td:last-child {
    overflow: visible !important;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Bootstrap dropdowns properly
    var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
    var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
        return new bootstrap.Dropdown(dropdownToggleEl, {
            boundary: 'viewport',
            popperConfig: {
                strategy: 'fixed'
            }
        });
    });

    // Fix dropdown positioning manually if Bootstrap fails
    dropdownElementList.forEach(function(toggle) {
        toggle.addEventListener('show.bs.dropdown', function(e) {
            // Ensure dropdown is visible
            const dropdown = this.nextElementSibling;
            if (dropdown) {
                dropdown.style.position = 'fixed';
                dropdown.style.zIndex = '1050';
            }
        });
    });
});
</script>
@endpush
