@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <h1 class="text-2xl font-semibold mb-6">Pembayaran Angsuran</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div>
                <p class="text-sm text-gray-600 mb-1">Nomor Pinjaman</p>
                <p class="font-medium">#{{ $loan->id }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 mb-1">Produk Pinjaman</p>
                <p class="font-medium">{{ ucfirst($loan->loan_product) }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 mb-1">Total Pinjaman</p>
                <p class="font-medium">Rp {{ number_format($loan->loan_amount, 0, ',', '.') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 mb-1">Angsuran Ke</p>
                <p class="font-medium">{{ $nextPaymentNumber }} dari {{ $loan->tenor }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 mb-1">Jumlah Angsuran</p>
                <p class="font-medium">Rp {{ number_format($monthlyPayment, 0, ',', '.') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 mb-1">Jatuh Tempo</p>
                <p class="font-medium">{{ $dueDate->format('d/m/Y') }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('loan-payments.store', $loan->id) }}" enctype="multipart/form-data" class="mt-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Payment Date -->
                <div>
                    <label for="payment_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pembayaran</label>
                    <input type="date" id="payment_date" name="payment_date" 
                        value="{{ old('payment_date', now()->format('Y-m-d')) }}" 
                        class="w-full p-3 border rounded-md focus:ring-2 focus:ring-red-500 focus:outline-none">
                    @error('payment_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Payment Method -->
                <div>
                    <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-1">Metode Pembayaran</label>
                    <select id="payment_method" name="payment_method" 
                        class="w-full p-3 border rounded-md focus:ring-2 focus:ring-red-500 focus:outline-none">
                        <option value="">Pilih metode pembayaran</option>
                        <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Tunai</option>
                        <option value="transfer" {{ old('payment_method') == 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                        <option value="debit" {{ old('payment_method') == 'debit' ? 'selected' : '' }}>Kartu Debit</option>
                    </select>
                    @error('payment_method')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Payment Amount -->
            <div class="mb-6">
                <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Pembayaran</label>
                <div class="relative">
                    <span class="absolute left-3 top-3 text-gray-500">Rp</span>
                    <input type="text" id="amount" name="amount"
                        value="{{ old('amount', number_format($monthlyPayment, 0, ',', '.')) }}"
                        class="w-full p-3 pl-10 border rounded-md focus:ring-2 focus:ring-red-500 focus:outline-none">
                </div>
                @error('amount')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Payment Proof (for transfer) -->
            <div id="proofContainer" class="mb-6">
                <label for="payment_proof" class="block text-sm font-medium text-gray-700 mb-1">Bukti Transfer</label>
                <input type="file" id="payment_proof" name="payment_proof" accept="image/jpeg,image/png,image/jpg,application/pdf" 
                    class="w-full p-3 border rounded-md focus:ring-2 focus:ring-red-500 focus:outline-none">
                <p class="text-xs text-gray-500 mt-1">Upload bukti transfer (format: JPG, PNG, PDF, max 2MB)</p>
                @error('payment_proof')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Notes -->
            <div class="mb-6">
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Catatan (Opsional)</label>
                <textarea id="notes" name="notes" rows="3" 
                    class="w-full p-3 border rounded-md focus:ring-2 focus:ring-red-500 focus:outline-none">{{ old('notes') }}</textarea>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('loan-payments.index') }}" class="px-6 py-2 bg-gray-300 text-gray-700 font-medium rounded-md hover:bg-gray-400">
                    Kembali
                </a>
                <button type="submit" class="px-6 py-2 bg-red-600 text-white font-medium rounded-md hover:bg-red-700">
                    Kirim Pembayaran
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const paymentMethodSelect = document.getElementById('payment_method');
        const proofContainer = document.getElementById('proofContainer');
        const amountInput = document.getElementById('amount');

        // Format amount input with thousand separator
        amountInput.addEventListener('input', function(e) {
            // Remove non-numeric characters
            let value = e.target.value.replace(/[^0-9]/g, '');
            
            // Format with thousand separator
            if (value) {
                e.target.value = parseInt(value).toLocaleString('id-ID');
            }
        });

        // Show/hide payment proof based on payment method
        function togglePaymentProof() {
            if (paymentMethodSelect.value === 'transfer') {
                proofContainer.style.display = 'block';
            } else {
                proofContainer.style.display = 'none';
            }
        }

        // Set initial state
        togglePaymentProof();

        // Add event listener
        paymentMethodSelect.addEventListener('change', togglePaymentProof);
    });
</script>
@endpush
@endsection