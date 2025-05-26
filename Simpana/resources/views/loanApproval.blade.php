{{-- filepath: c:\TUBES PPL\Simpana\resources\views\loanApproval.blade.php --}}
@extends('layouts.admin')

@section('title', 'Persetujuan Pinjaman')
@section('header', 'Persetujuan Pinjaman')

@section('content')
    <div class="card mb-4">
        <div class="card-body">
            <!-- Notifikasi -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Search and Filter Section -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <input type="text" class="form-control" placeholder="Cari pengajuan...">
                </div>
                <div class="col-md-4">
                    <select class="form-select">
                        <option value="">Semua Status</option>
                        <option value="pending">Menunggu</option>
                        <option value="approved">Disetujui</option>
                        <option value="rejected">Ditolak</option>
                    </select>
                </div>
            </div>

            <!-- Loan Applications Table -->
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No. Pengajuan</th>
                            <th>Nama Pemohon</th>
                            <th>Produk Pinjaman</th>
                            <th>Nominal</th>
                            <th>Tenor</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($loans as $loan)
                        <tr>
                            <td>{{ $loan->id }}</td>
                            <td>{{ $loan->user->nama ?? $loan->user->name }}</td>
                            <td>{{ $loan->loan_product }}</td>
                            <td>Rp {{ number_format($loan->loan_amount, 0, ',', '.') }}</td>
                            <td>{{ $loan->tenor }} Bulan</td>
                            <td>
                                <span class="badge
                                    @if($loan->status == 'pending') bg-warning
                                    @elseif($loan->status == 'approved') bg-success
                                    @else bg-danger @endif">
                                    {{ ucfirst($loan->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#detailModal{{ $loan->id }}">
                                        Detail
                                    </button>
                                    @if($loan->status == 'pending')
                                    <form action="{{ route('loanApproval.approve', $loan->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-success">Setujui</button>
                                    </form>
                                    <form action="{{ route('loanApproval.reject', $loan->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Tolak</button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $loans->links() }}
            </div>
        </div>
    </div>

    <!-- MOVE ALL MODALS HERE - OUTSIDE THE TABLE -->
    @foreach($loans as $loan)
    <!-- Modal Detail untuk setiap pinjaman -->
    <div class="modal fade" id="detailModal{{ $loan->id }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $loan->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel{{ $loan->id }}">Detail Pengajuan Pinjaman #{{ $loan->id }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-1 text-muted">Nama Pemohon</p>
                            <p class="fw-bold">{{ $loan->user->nama }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1 text-muted">Status</p>
                            <span class="badge
                                @if($loan->status == 'pending') bg-warning
                                @elseif($loan->status == 'approved') bg-success
                                @else bg-danger @endif">
                                {{ ucfirst($loan->status) }}
                            </span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-1 text-muted">Produk Pinjaman</p>
                            <p class="fw-bold">{{ ucfirst($loan->loan_product) }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1 text-muted">Nominal Pinjaman</p>
                            <p class="fw-bold">Rp {{ number_format($loan->loan_amount, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-1 text-muted">Tenor</p>
                            <p class="fw-bold">{{ $loan->tenor }} Bulan</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1 text-muted">Metode Pembayaran</p>
                            <p class="fw-bold">{{ ucfirst($loan->payment_method) }}</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-1 text-muted">Tanggal Pengajuan</p>
                            <p class="fw-bold">{{ $loan->application_date->format('d/m/Y') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1 text-muted">Tanggal Cicilan Pertama</p>
                            <p class="fw-bold">{{ $loan->first_payment_date->format('d/m/Y') }}</p>
                        </div>
                    </div>
                    @if($loan->application_note)
                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="mb-1 text-muted">Catatan Pengajuan</p>
                            <p class="fw-bold">{{ $loan->application_note }}</p>
                        </div>
                    </div>
                    @endif
                    @if($loan->collateral)
                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="mb-1 text-muted">Jaminan</p>
                            <p class="fw-bold">{{ $loan->collateral }}</p>
                        </div>
                    </div>
                    @endif
                    @if($loan->documents && count($loan->documents) > 0)
                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="mb-1 text-muted">Dokumen Pendukung</p>
                            <div class="list-group">
                                @foreach($loan->documents as $document)
                                <a href="{{ asset($document['file_path']) }}" target="_blank" class="list-group-item list-group-item-action">
                                    {{ $document['original_name'] }}
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="modal-footer">
                    @if($loan->status == 'pending')
                    <form action="{{ route('loanApproval.approve', $loan->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success">Setujui Pinjaman</button>
                    </form>
                    <form action="{{ route('loanApproval.reject', $loan->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger">Tolak Pinjaman</button>
                    </form>
                    @endif
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    @push('styles')
    <style>
        /* Modal z-index fixes */
        .modal {
            z-index: 1060 !important;
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 100% !important;
            outline: 0 !important;
        }

        .modal-backdrop {
            z-index: 1050 !important;
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 100% !important;
        }
        
        .modal-dialog {
            position: relative !important;
            margin: 1.75rem auto !important;
            pointer-events: all !important;
            transform: none !important;
        }
        
        .modal-content {
            position: relative !important;
            pointer-events: auto !important;
            background-clip: padding-box !important;
            border: 1px solid rgba(0,0,0,.2) !important;
            border-radius: 0.3rem !important;
            outline: 0 !important;
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15) !important;
        }
        
        /* Fix body scrollbar when modal open */
        body.modal-open {
            overflow: hidden !important;
            padding-right: 0 !important;
            height: 100% !important;
        }

        /* Table overflow fixes */
        .table-responsive {
            overflow: visible !important;
        }

        .card-body {
            overflow: visible !important;
        }

        .table {
            overflow: visible !important;
        }
        
        .table td {
            position: relative !important;
            overflow: visible !important;
        }
        
        /* Additional fixes from payment-verification */
        .dropdown {
            position: static !important;
        }

        .dropdown-menu {
            position: absolute !important;
            z-index: 1050 !important;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
            border: 1px solid rgba(0, 0, 0, 0.15) !important;
            background: white !important;
            min-width: 120px !important;
        }

        .dropdown.show .dropdown-menu {
            display: block !important;
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
        
        // Enhanced modal fix for mouse movement issues
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            // Completely stop event propagation on all mouse events
            ['mousemove', 'mouseover', 'mouseenter', 'mouseleave', 'mouseout'].forEach(eventType => {
                modal.addEventListener(eventType, function(e) {
                    e.stopPropagation();
                    e.stopImmediatePropagation();
                }, true);
                
                // Also apply to modal dialog and content
                modal.querySelector('.modal-dialog')?.addEventListener(eventType, function(e) {
                    e.stopPropagation();
                    e.stopImmediatePropagation();
                }, true);
                
                modal.querySelector('.modal-content')?.addEventListener(eventType, function(e) {
                    e.stopPropagation();
                    e.stopImmediatePropagation();
                }, true);
            });
            
            // Fix modal when shown
            modal.addEventListener('shown.bs.modal', function() {
                // Apply CSS fixes directly
                document.body.style.paddingRight = '0px';
                document.body.classList.add('modal-open');
                
                // Ensure modal stays in place
                this.style.display = 'block';
                this.style.position = 'fixed';
                
                // Create a protective overlay to catch mouse events
                if (!document.getElementById('modal-event-shield')) {
                    const shield = document.createElement('div');
                    shield.id = 'modal-event-shield';
                    shield.style.position = 'fixed';
                    shield.style.top = '0';
                    shield.style.left = '0';
                    shield.style.width = '100vw';
                    shield.style.height = '100vh';
                    shield.style.zIndex = '1049';
                    shield.style.pointerEvents = 'none';
                    document.body.appendChild(shield);
                }
            });
            
            // Clean up when hidden
            modal.addEventListener('hidden.bs.modal', function() {
                const shield = document.getElementById('modal-event-shield');
                if (shield) shield.remove();
            });
        });
        
        // Fix any scroll issues by completely disabling page scrolling when modal is open
        document.addEventListener('scroll', function(e) {
            if (document.body.classList.contains('modal-open')) {
                window.scrollTo(0, 0);
                e.preventDefault();
                e.stopPropagation();
            }
        }, true);
    });
    </script>
    @endpush
@endsection
