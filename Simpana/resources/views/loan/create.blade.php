@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Pengajuan Pinjaman</h3>
                </div>

                <div class="card-body">
                    <form action="{{ route('loan.store') }}" method="POST">
                        @csrf
                        
                        <div class="form-group">
                            <label for="loan_product">Produk Pinjaman</label>
                            <select name="loan_product" id="loan_product" class="form-control @error('loan_product') is-invalid @enderror" required>
                                <option value="">Pilih Produk Pinjaman</option>
                                <option value="Pinjaman Modal Usaha">Pinjaman Modal Usaha</option>
                                <option value="Pinjaman Pendidikan">Pinjaman Pendidikan</option>
                                <option value="Pinjaman Kesehatan">Pinjaman Kesehatan</option>
                            </select>
                            @error('loan_product')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="loan_amount">Jumlah Pinjaman (Rp)</label>
                            <input type="number" name="loan_amount" id="loan_amount" class="form-control @error('loan_amount') is-invalid @enderror" required>
                            @error('loan_amount')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="tenor">Tenor (bulan)</label>
                            <input type="number" name="tenor" id="tenor" class="form-control @error('tenor') is-invalid @enderror" required>
                            @error('tenor')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="payment_type">Tipe Pembayaran</label>
                            <select name="payment_type" id="payment_type" class="form-control @error('payment_type') is-invalid @enderror" required>
                                <option value="installment">Angsuran Bulanan</option>
                                <option value="full_payment">Pelunasan Penuh</option>
                            </select>
                            @error('payment_type')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary">Ajukan Pinjaman</button>
                            <a href="{{ route('loan.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 