@extends('layouts.admin')

@section('title', 'Generate SHU')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Generate SHU Baru</h5>
                    <form action="{{ route('admin.shu.generate') }}" method="POST" class="mt-3">
                        @csrf
                        <div class="mb-3">
                            <label for="tahun" class="form-label">Pilih Tahun</label>
                            <select name="tahun" id="tahun" class="form-select" required>
                                @for($i = date('Y'); $i >= 2020; $i--)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary">Generate SHU</button>
                            <button type="submit" class="btn btn-success" formaction="{{ route('admin.shu.generatePDF') }}">
                                <i class="fas fa-file-pdf"></i> Download PDF
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @foreach($shus as $tahun => $shuTahun)
    <div class="card mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0">SHU Tahun {{ $tahun }}</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Nama Anggota</th>
                            <th>Total Simpanan</th>
                            <th>Total Pinjaman</th>
                            <th>Kontribusi Simpanan</th>
                            <th>Kontribusi Pinjaman</th>
                            <th>Jumlah SHU</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($shuTahun as $shu)
                        <tr>
                            <td>{{ $shu->user->nama }}</td>
                            <td>Rp {{ number_format($shu->total_simpanan, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($shu->total_pinjaman, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($shu->kontribusi_simpanan, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($shu->kontribusi_pinjaman, 0, ',', '.') }}</td>
                            <td class="font-weight-bold text-primary">
                                Rp {{ number_format($shu->jumlah_shu, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
