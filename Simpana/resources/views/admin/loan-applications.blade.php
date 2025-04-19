@extends('admin.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h2>Daftar Pengajuan Pinjaman</h2>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID Pinjaman</th>
                            <th>Nama Anggota</th>
                            <th>Jumlah Pinjaman</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Example Row 1 -->
                        <tr>
                            <td>PIN001</td>
                            <td>Budi Santoso</td>
                            <td>Rp 5.000.000</td>
                            <td>01/03/2024</td>
                            <td>
                                <span class="badge bg-warning">Pending</span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-success btn-sm me-2" onclick="alert('Fitur menyetujui pinjaman akan segera tersedia!')">
                                        Setujui
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="alert('Fitur menolak pinjaman akan segera tersedia!')">
                                        Tolak
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <!-- Example Row 2 -->
                        <tr>
                            <td>PIN002</td>
                            <td>Siti Rahayu</td>
                            <td>Rp 3.500.000</td>
                            <td>02/03/2024</td>
                            <td>
                                <span class="badge bg-success">Disetujui</span>
                            </td>
                            <td>
                                <span class="text-muted">Sudah diproses</span>
                            </td>
                        </tr>
                        <!-- Example Row 3 -->
                        <tr>
                            <td>PIN003</td>
                            <td>Ahmad Hidayat</td>
                            <td>Rp 7.000.000</td>
                            <td>02/03/2024</td>
                            <td>
                                <span class="badge bg-danger">Ditolak</span>
                            </td>
                            <td>
                                <span class="text-muted">Sudah diproses</span>
                            </td>
                        </tr>
                        <!-- Example Row 4 -->
                        <tr>
                            <td>PIN004</td>
                            <td>Dewi Kusuma</td>
                            <td>Rp 4.000.000</td>
                            <td>03/03/2024</td>
                            <td>
                                <span class="badge bg-warning">Pending</span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-success btn-sm me-2" onclick="alert('Fitur menyetujui pinjaman akan segera tersedia!')">
                                        Setujui
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="alert('Fitur menolak pinjaman akan segera tersedia!')">
                                        Tolak
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">Previous</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table th {
        background-color: #f8f9fa;
    }
    .badge {
        padding: 8px 12px;
    }
    .btn-group .btn {
        padding: 0.25rem 0.75rem;
    }
    .table td {
        vertical-align: middle;
    }
</style>
@endpush