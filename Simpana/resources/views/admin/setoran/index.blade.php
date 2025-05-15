@extends('admin_dashboard')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Setoran Simpanan (Admin)</h2>
        <a href="{{ route('admin.setoran.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Setoran
        </a>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Anggota</th>
                            <th>Tanggal</th>
                            <th>Jumlah</th>
                            <th>Jenis Simpanan</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($simpanans as $index => $simpanan)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $simpanan->user->nama }}</td>
                                <td>{{ $simpanan->tanggal->format('d/m/Y') }}</td>
                                <td>Rp {{ number_format($simpanan->jumlah, 0, ',', '.') }}</td>
                                <td>{{ ucfirst($simpanan->jenis_simpanan) }}</td>
                                <td>{{ $simpanan->keterangan ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('admin.setoran.edit', $simpanan->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger delete-btn" 
                                            data-id="{{ $simpanan->id }}"
                                            data-name="{{ $simpanan->user->nama }}"
                                            data-amount="Rp {{ number_format($simpanan->jumlah, 0, ',', '.') }}">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data setoran</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Form untuk delete -->
<form id="delete-form" action="" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Menangani klik tombol hapus
    const deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const amount = this.getAttribute('data-amount');
            
            Swal.fire({
                title: 'Apakah Anda yakin?',
                html: `Anda akan menghapus setoran dari <strong>${name}</strong><br>dengan jumlah <strong>${amount}</strong>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('delete-form');
                    form.action = `/admin/setoran/${id}`;
                    form.submit();
                }
            });
        });
    });
});
</script>
@endpush
@endsection 