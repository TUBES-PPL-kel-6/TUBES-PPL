@extends('admin_dashboard')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Edit Setoran Simpanan</h2>
        <a href="{{ route('admin.setoran.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.setoran.update', $simpanan->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group mb-3">
                    <label for="nama" class="form-label">Nama Anggota</label>
                    <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" 
                           value="{{ old('nama', $simpanan->user->nama) }}" required>
                    <input type="hidden" name="user_id" value="{{ $simpanan->user_id }}">
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="jenis_simpanan" class="form-label">Jenis Simpanan</label>
                    <select class="form-control @error('jenis_simpanan') is-invalid @enderror" 
                            id="jenis_simpanan" name="jenis_simpanan" required>
                        <option value="">Pilih Jenis Simpanan</option>
                        <option value="pokok" {{ old('jenis_simpanan', $simpanan->jenis_simpanan) == 'pokok' ? 'selected' : '' }}>Simpanan Pokok</option>
                        <option value="wajib" {{ old('jenis_simpanan', $simpanan->jenis_simpanan) == 'wajib' ? 'selected' : '' }}>Simpanan Wajib</option>
                        <option value="sukarela" {{ old('jenis_simpanan', $simpanan->jenis_simpanan) == 'sukarela' ? 'selected' : '' }}>Simpanan Sukarela</option>
                    </select>
                    @error('jenis_simpanan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="jumlah" class="form-label">Jumlah Setoran</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" class="form-control @error('jumlah') is-invalid @enderror" 
                               id="jumlah" name="jumlah" value="{{ old('jumlah', $simpanan->jumlah) }}" required min="0">
                    </div>
                    @error('jumlah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="tanggal" class="form-label">Tanggal Setoran</label>
                    <input type="date" class="form-control @error('tanggal') is-invalid @enderror" 
                           id="tanggal" name="tanggal" value="{{ old('tanggal', $simpanan->tanggal->format('Y-m-d')) }}" required>
                    @error('tanggal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                              id="keterangan" name="keterangan" rows="3">{{ old('keterangan', $simpanan->keterangan) }}</textarea>
                    @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
