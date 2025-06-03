@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b">
                <h2 class="text-2xl font-bold text-gray-800">{{ $pageTitle ?? 'Pembayaran Pinjaman' }}</h2>
                @if(isset($rejectionReason) && !empty($rejectionReason))
                    <div class="mt-2 p-3 bg-red-50 border border-red-200 rounded-md">
                        <p class="text-red-700 text-sm font-medium">
                            <i class="bi bi-exclamation-triangle me-1"></i>
                            Ditolak: {{ $rejectionReason }}
                        </p>
                    </div>
                @endif
            </div>

            <div class="p-6">
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                          <div class="text-red-800">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li class="text-sm">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <!-- Loan Information -->
                <div class="mb-8 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800">Informasi Pinjaman</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <div class="text-sm text-gray-500">Nomor Pinjaman</div>
                            <div class="font-semibold text-gray-800">#{{ $loan->id }}</div>
                        </div>
                        <div class="space-y-1">
                            <div class="text-sm text-gray-500">Produk</div>
                            <div class="font-semibold text-gray-800">{{ ucfirst($loan->loan_product) }}</div>
                        </div>
                        <div class="space-y-1">
                            <div class="text-sm text-gray-500">Total Pinjaman</div>
                            <div class="font-semibold text-gray-800">Rp {{ number_format($loan->loan_amount, 0, ',', '.') }}</div>
                        </div>
                        <div class="space-y-1">
                            <div class="text-sm text-gray-500">Sisa Pinjaman</div>
                            <div class="font-semibold text-red-600">Rp {{ number_format($loan->getRemainingBalance(), 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Interest Information -->
                <div class="mb-8 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800">Informasi Bunga</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <div class="text-sm text-gray-500">Bunga per Bulan</div>
                            <div class="font-semibold text-gray-800">{{ $loan->interest_rate }}%</div>
                        </div>
                        <div class="space-y-1">
                            <div class="text-sm text-gray-500">Bunga per Tahun</div>
                            <div class="font-semibold text-gray-800">{{ $loan->interest_rate * 12 }}%</div>
                        </div>
                        <div class="space-y-1">
                            <div class="text-sm text-gray-500">Bunga per Angsuran</div>
                            <div class="font-semibold text-gray-800">Rp {{ number_format($loan->loan_amount * ($loan->interest_rate / 100), 0, ',', '.') }}</div>
                        </div>
                        <div class="space-y-1">
                            <div class="text-sm text-gray-500">Total Bunga</div>
                            <div class="font-semibold text-gray-800">Rp {{ number_format($loan->loan_amount * ($loan->interest_rate / 100) * $loan->tenor, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Payment Form -->
                <form method="POST" action="{{ route('loan-payments.store', $loan->id) }}" enctype="multipart/form-data" id="paymentForm" class="space-y-6">
                    @csrf

                    <!-- Add this hidden input for resubmissions -->
                    @if(isset($isResubmission) && $isResubmission && isset($paymentId))
                        <input type="hidden" name="payment_id" value="{{ $paymentId }}">
                    @endif

                    <!-- Payment Type -->
                    <div class="space-y-3">
                        <label class="block text-sm font-medium text-gray-700">Jenis Pembayaran</label>
                        <div class="space-y-3">
                            <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="payment_type" value="installment" id="installmentRadio"
                                    {{ old('payment_type', $paymentType ?? 'installment') == 'installment' ? 'checked' : '' }}
                                    class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300"
                                    onchange="updateAmount()">
                                <span class="ml-3 text-sm font-medium text-gray-700">
                                    Bayar Cicilan (Rp {{ number_format($monthlyPayment, 0, ',', '.') }})
                                </span>
                            </label>
                            <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="payment_type" value="full" id="fullRadio"
                                    {{ old('payment_type', $paymentType ?? 'installment') == 'full' ? 'checked' : '' }}
                                    class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300"
                                    onchange="updateAmount()">
                                <span class="ml-3 text-sm font-medium text-gray-700">
                                    Lunasi Sekaligus (Rp {{ number_format($loan->getRemainingBalance(), 0, ',', '.') }})
                                </span>
                            </label>
                        </div>
                    </div>

                    <!-- Payment Amount -->
                    <div class="space-y-2">
                        <label for="amount" class="block text-sm font-medium text-gray-700">Jumlah Pembayaran</label>
                        <input type="text" id="amount" name="amount"
                            value=""
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-100 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                            readonly>
                        @error('amount')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Payment Date -->
                    <div class="space-y-2">
                        <label for="payment_date" class="block text-sm font-medium text-gray-700">Tanggal Pembayaran</label>
                        <input type="date" id="payment_date" name="payment_date"
                            value="{{ old('payment_date', now()->format('Y-m-d')) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        @error('payment_date')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Payment Method -->
                    <div class="space-y-2">
                        <label for="payment_method" class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
                        <select id="payment_method" name="payment_method"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                            onchange="toggleProof()">
                            <option value="">Pilih metode pembayaran</option>
                            <option value="transfer" {{ old('payment_method') == 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                            <option value="debit" {{ old('payment_method') == 'debit' ? 'selected' : '' }}>Kartu Debit</option>
                        </select>
                        @error('payment_method')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Payment Proof -->
                    <div id="proofContainer" class="space-y-2" style="display:none;">
                        <label for="payment_proof" class="block text-sm font-medium text-gray-700">Bukti Transfer</label>
                        <input type="file" id="payment_proof" name="payment_proof"
                            accept="image/jpeg,image/png,image/jpg,application/"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        <p class="text-xs text-gray-500">Upload bukti transfer (format: JPG, PNG, max 10MB)</p>
                        @error('payment_proof')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notes -->
                    <div class="space-y-2">
                        <label for="notes" class="block text-sm font-medium text-gray-700">Catatan (Opsional)</label>
                        <textarea id="notes" name="notes" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                            placeholder="Tambahkan catatan jika diperlukan...">{{ old('notes') }}</textarea>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 pt-6">
                        <a href="{{ route('loan-payments.index') }}"
                            class="px-6 py-3 bg-gray-300 text-gray-700 font-medium rounded-md hover:bg-gray-400 transition-colors text-center">
                            Kembali
                        </a>
                        <button type="submit"
                            class="px-6 py-3 bg-red-600 text-white font-medium rounded-md hover:bg-red-700 transition-colors flex-1 sm:flex-none"
                            onclick="submitForm()">
                            {{ isset($isResubmission) && $isResubmission ? 'Ajukan Ulang' : 'Bayar Sekarang' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Data dari PHP
const monthlyPayment = {{ $monthlyPayment }};
const remainingBalance = {{ $loan->getRemainingBalance() }};

// Format angka ke format Indonesia
function formatNumber(num) {
    return new Intl.NumberFormat('id-ID').format(num);
}

// Update jumlah berdasarkan pilihan
function updateAmount() {
    const installmentRadio = document.getElementById('installmentRadio');
    const fullRadio = document.getElementById('fullRadio');
    const amountInput = document.getElementById('amount');

    let value = 0;
    if (installmentRadio.checked) {
        value = monthlyPayment;
    } else if (fullRadio.checked) {
        value = remainingBalance;
    }
    // Set value input ke angka standar (tanpa format)
    amountInput.value = value.toFixed(2); // <-- pastikan dua desimal
}

// Toggle bukti pembayaran
function toggleProof() {
    const paymentMethod = document.getElementById('payment_method').value;
    const proofContainer = document.getElementById('proofContainer');

    if (paymentMethod === 'transfer') {
        proofContainer.style.display = 'block';
    } else {
        proofContainer.style.display = 'none';
    }
}

// Submit form
function submitForm() {
    // Tidak perlu manipulasi amountInput.value lagi
    // Biarkan value tetap seperti hasil updateAmount()
}

// Initialize when page loads
document.addEventListener('DOMContentLoaded', function() {
    console.log('Page loaded, initializing...');
    updateAmount();
    toggleProof();
});

// Backup initialization (langsung execute)
updateAmount();
</script>
@endsection
