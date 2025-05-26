@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex justify-center items-center min-h-[calc(100vh-200px)]">
        <div class="w-full max-w-5xl flex flex-col md:flex-row gap-6">
            <!-- User Info Panel -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden w-full md:w-64 h-fit">
                <div class="bg-primary text-white p-4 font-bold text-lg">
                    <i class="fas fa-user-circle mr-2"></i>Informasi Anggota
                </div>
                <div class="p-5 border-t border-gray-200 space-y-3">
                    <div class="flex items-center text-sm">
                        <span class="text-gray-500 w-24">Nama User</span>
                        <span class="font-medium">{{ $user->nama }}</span>
                    </div>
                    <div class="flex items-center text-sm">
                        <span class="text-gray-500 w-24">No.HP</span>
                        <span class="font-medium">{{ $user->no_telp }}</span>
                    </div>
                    <div class="flex items-center text-sm">
                        <span class="text-gray-500 w-24">Alamat</span>
                        <span class="font-medium">{{ $user->alamat }}</span>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">Total Simpanan</span>
                            <span class="font-bold text-primary">Rp{{ number_format($totalSimpanan, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Form Panel -->
            <div class="bg-white rounded-xl shadow-lg flex-grow overflow-hidden">
                <div class="bg-primary text-white p-5">
                    <!-- Payment Type Tabs -->
                    <div class="flex mb-3 space-x-2">
                        <a href="{{ route('dashboard.simpanan.create', ['type' => 'wajib']) }}" id="tab-wajib"
                           class="px-4 py-1 rounded-full text-sm {{ $type == 'wajib' ? 'bg-white text-primary' : 'bg-opacity-20 bg-white text-white hover:bg-opacity-30' }} font-medium">
                            Simpanan Wajib
                        </a>
                        <a href="{{ route('dashboard.simpanan.create', ['type' => 'sukarela']) }}" id="tab-sukarela"
                           class="px-4 py-1 rounded-full text-sm {{ $type == 'sukarela' ? 'bg-white text-primary' : 'bg-opacity-20 bg-white text-white hover:bg-opacity-30' }} font-medium">
                            Simpanan Sukarela
                        </a>
                    </div>

                    {{-- Judul dan deskripsi --}}
                    @if($type === 'wajib')
                        <h1 class="text-3xl font-bold" id="payment-title">Simpanan Wajib</h1>
                        <p class="text-sm mt-1 opacity-90" id="payment-description">
                            Simpanan wajib bulanan dengan jumlah tetap.
                        </p>
                    @elseif($type === 'sukarela')
                        <h1 class="text-3xl font-bold" id="payment-title">Simpanan Sukarela</h1>
                        <p class="text-sm mt-1 opacity-90" id="payment-description">
                            Pilih jumlah setoran simpanan sukarela sesuai keinginan Anda.
                        </p>
                    @endif
                </div>

                <div class="p-6">
                    <form action="{{ route('dashboard.simpanan.store') }}" method="POST" id="payment-form">
                        @csrf
                        <input type="hidden" name="jenis_simpanan" id="jenis_simpanan" value="{{ $type }}">

                        <!-- Amount Input Section -->
                        <div class="mb-6">
                            <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">Nominal Simpanan</label>
                            <div class="relative" id="amount-container">
                                {{-- Input amount --}}
                                @if($type === 'sukarela')
                                <input type="text" id="amount" name="jumlah"
                                       class="w-full p-3 border border-gray-300 rounded-lg"
                                       placeholder="Masukkan nominal simpanan sukarela" autocomplete="off">
                                @else
                                <input type="text" id="amount" name="jumlah" value="50000"
                                       class="w-full p-3 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed"
                                       readonly>
                                @endif
                            </div>

                            {{-- Amount description --}}
                            @if($type === 'wajib')
                                <p class="text-xs text-gray-500 mt-1" id="amount-description">Simpanan wajib sebesar Rp50.000 per bulan.</p>
                            @elseif($type === 'sukarela')
                                <p class="text-xs text-gray-500 mt-1" id="amount-description">Minimal simpanan sukarela Rp10.000</p>
                            @endif
                        </div>

                        <!-- Payment Method Section -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Metode Pembayaran</label>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                <div class="payment-option border border-gray-200 rounded-lg p-3 cursor-pointer hover:bg-gray-50 transition border-primary bg-blue-50">
                                    <div class="flex items-center mb-2">
                                        <input type="radio" name="payment_method" value="transfer" class="mr-2" checked>
                                        <span class="font-medium">Transfer Bank</span>
                                    </div>
                                    <div class="text-xs text-gray-500">Transfer dari rekening bank</div>
                                </div>

                                <div class="payment-option border border-gray-200 rounded-lg p-3 cursor-pointer hover:bg-gray-50 transition">
                                    <div class="flex items-center mb-2">
                                        <input type="radio" name="payment_method" value="ewallet" class="mr-2">
                                        <span class="font-medium">E-Wallet</span>
                                    </div>
                                    <div class="text-xs text-gray-500">DANA, GoPay, OVO, dll</div>
                                </div>

                                <div class="payment-option border border-gray-200 rounded-lg p-3 cursor-pointer hover:bg-gray-50 transition">
                                    <div class="flex items-center mb-2">
                                        <input type="radio" name="payment_method" value="cash" class="mr-2">
                                        <span class="font-medium">Tunai</span>
                                    </div>
                                    <div class="text-xs text-gray-500">Setor langsung di kantor</div>
                                </div>
                            </div>
                        </div>
                        <!-- Summary Section -->
                        <div class="bg-gray-50 p-4 rounded-lg mb-6">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-gray-600">Jumlah Setoran</span>
                                <span class="font-medium" id="summary-amount">
                                    Rp50.000
                                </span>
                            </div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-gray-600">Biaya Admin</span>
                                <span class="font-medium">Rp0</span>
                            </div>
                            <div class="flex items-center justify-between font-bold">
                                <span>Total</span>
                                <span class="text-primary" id="summary-total">
                                    Rp50.000
                                </span>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <a href="{{ route('dashboard.simpanan') }}" class="px-4 py-2 bg-gray-200 rounded-md mr-2 hover:bg-gray-300">Batal</a>
                            <button type="submit" class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-secondary transition">
                                Bayar Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal (hidden by default) -->
    <div id="success-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg p-8 max-w-md w-full">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Pembayaran Berhasil!</h3>
                <div class="mt-2">
                    <p class="text-sm text-gray-500">
                        Simpanan Anda telah berhasil ditambahkan ke akun Anda.
                    </p>
                </div>
                <div class="mt-5">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-secondary transition">
                        Kembali
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function switchPaymentType(type) {
        const titleElement = document.getElementById('payment-title');
        const descriptionElement = document.getElementById('payment-description');
        const amountElement = document.getElementById('amount');
        const jenisSimpananInput = document.getElementById('jenis_simpanan');
        const amountDescription = document.getElementById('amount-description');
        const summaryAmount = document.getElementById('summary-amount');
        const summaryTotal = document.getElementById('summary-total');
        const tabPokok = document.getElementById('tab-pokok');
        const tabWajib = document.getElementById('tab-wajib');
        const tabSukarela = document.getElementById('tab-sukarela');

        // Set the hidden input value
        jenisSimpananInput.value = type;

        // Reset all tabs
        [tabWajib, tabSukarela].forEach(tab => {
            tab.classList.remove('bg-white', 'text-primary');
            tab.classList.add('bg-opacity-20', 'text-white', 'hover:bg-opacity-30');
        });

        if (type === 'wajib') {
            // Update title and description
            titleElement.textContent = 'Simpanan Wajib';
            descriptionElement.textContent = 'Simpanan wajib bulanan dengan jumlah tetap.';

            // Update amount input
            amountElement.value = '50000';
            amountElement.classList.add('bg-gray-100', 'cursor-not-allowed');
            amountElement.setAttribute('readonly', true);
            amountDescription.textContent = 'Simpanan wajib sebesar Rp50.000 per bulan.';

            // Update summary
            summaryAmount.textContent = 'Rp50.000';
            summaryTotal.textContent = 'Rp50.000';

            // Update tab
            tabWajib.classList.add('bg-white', 'text-primary');
            tabWajib.classList.remove('bg-opacity-20', 'text-white', 'hover:bg-opacity-30');
        } else { // sukarela
            // Update title and description
            titleElement.textContent = 'Simpanan Sukarela';
            descriptionElement.textContent = 'Pilih jumlah setoran simpanan sukarela sesuai keinginan Anda.';

            // Update amount input
            amountElement.value = '';
            amountElement.classList.remove('bg-gray-100', 'cursor-not-allowed');
            amountElement.removeAttribute('readonly'); // <-- ini yang benar
            amountDescription.textContent = 'Minimal simpanan sukarela Rp10.000';

            // Update summary
            summaryAmount.textContent = 'Rp0';
            summaryTotal.textContent = 'Rp0';

            // Update tab
            tabSukarela.classList.add('bg-white', 'text-primary');
            tabSukarela.classList.remove('bg-opacity-20', 'text-white', 'hover:bg-opacity-30');
        }
    }

    // Format currency input
    function formatCurrency(input) {
        let value = input.value.replace(/\D/g, '');
        if (value !== '') {
            value = parseInt(value).toLocaleString('id-ID');
        }
        input.value = value;
        updateSummary();
    }

    function updateSummary() {
        const amountInput = document.getElementById('amount');
        const summaryAmount = document.getElementById('summary-amount');
        const summaryTotal = document.getElementById('summary-total');
        let value = amountInput.value.replace(/\D/g, '');
        if (value === '') value = '0';
        const formattedValue = parseInt(value).toLocaleString('id-ID');
        summaryAmount.textContent = `Rp${formattedValue}`;
        summaryTotal.textContent = `Rp${formattedValue}`;
    }

    document.addEventListener('DOMContentLoaded', function() {
        const paymentOptions = document.querySelectorAll('.payment-option');
        paymentOptions.forEach(option => {
            const radio = option.querySelector('input[type="radio"]');
            option.addEventListener('click', function() {
                radio.checked = true;
                paymentOptions.forEach(opt => {
                    opt.classList.remove('border-primary', 'bg-blue-50');
                });
                option.classList.add('border-primary', 'bg-blue-50');
            });
        });

        // Add input event listener
        const amountInput = document.getElementById('amount');
        if (amountInput) {
            amountInput.addEventListener('input', function() {
                formatCurrency(this);
            });
        }
    });

    function showPaymentSuccess() {
        document.getElementById('success-modal').classList.remove('hidden');
    }
    function closeModal() {
        document.getElementById('success-modal').classList.add('hidden');
    }
</script>
@endsection
