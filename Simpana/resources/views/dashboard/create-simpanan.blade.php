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
                        <span class="text-gray-500 w-24">Nomor Anggota</span>
                        <span class="font-medium">AG001024</span>
                    </div>
                    <div class="flex items-center text-sm">
                        <span class="text-gray-500 w-24">Nama</span>
                        <span class="font-medium">John Doe</span>
                    </div>
                    <div class="flex items-center text-sm">
                        <span class="text-gray-500 w-24">Status</span>
                        <span class="bg-green-100 text-green-800 text-xs px-2 py-0.5 rounded-full">Aktif</span>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">Total Simpanan</span>
                            <span class="font-bold text-primary">Rp4.835.207</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Form Panel -->
            <div class="bg-white rounded-xl shadow-lg flex-grow overflow-hidden">
                <div class="bg-primary text-white p-5">
                    <!-- Payment Type Tabs -->
                    <div class="flex mb-3 space-x-2">
                        <a href="#" onclick="switchPaymentType('pokok')" id="tab-pokok" class="px-4 py-1 rounded-full text-sm bg-white text-primary font-medium">Simpanan Pokok</a>
                        <a href="#" onclick="switchPaymentType('sukarela')" id="tab-sukarela" class="px-4 py-1 rounded-full text-sm bg-opacity-20 bg-white text-white hover:bg-opacity-30 transition">Simpanan Sukarela</a>
                    </div>
                    
                    <h1 class="text-3xl font-bold" id="payment-title">Simpanan Pokok</h1>
                    <p class="text-sm mt-1 opacity-90" id="payment-description">
                        Setoran simpanan pokok dengan jumlah tetap.
                    </p>
                </div>

                <div class="p-6">
                    <form action="#" method="POST" id="payment-form">
                        <!-- Amount Input Section -->
                        <div class="mb-6">
                            <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">Nominal Simpanan</label>
                            <div class="relative" id="amount-container">
                                <input type="text" id="amount" name="amount" value="50.000" 
                                       class="w-full p-3 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed" 
                                       readonly>
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500">Rp</span>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1" id="amount-description">Simpanan pokok memiliki jumlah tetap sesuai ketentuan.</p>
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
                            <button type="button" onclick="showPaymentSuccess()" class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-secondary transition">
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
        const amountContainer = document.getElementById('amount-container');
        const amountDescription = document.getElementById('amount-description');
        const summaryAmount = document.getElementById('summary-amount');
        const summaryTotal = document.getElementById('summary-total');
        const tabPokok = document.getElementById('tab-pokok');
        const tabSukarela = document.getElementById('tab-sukarela');
        
        if (type === 'pokok') {
            // Update title and description
            titleElement.textContent = 'Simpanan Pokok';
            descriptionElement.textContent = 'Setoran simpanan pokok dengan jumlah tetap.';
            
            // Update amount input
            amountElement.value = '50.000';
            amountElement.classList.add('bg-gray-100', 'cursor-not-allowed');
            amountElement.setAttribute('readonly', true);
            amountDescription.textContent = 'Simpanan pokok memiliki jumlah tetap sesuai ketentuan.';
            
            // Update summary
            summaryAmount.textContent = 'Rp50.000';
            summaryTotal.textContent = 'Rp50.000';
            
            // Update tabs
            tabPokok.classList.add('bg-white', 'text-primary');
            tabPokok.classList.remove('bg-opacity-20', 'text-white', 'hover:bg-opacity-30');
            tabSukarela.classList.add('bg-opacity-20', 'text-white', 'hover:bg-opacity-30');
            tabSukarela.classList.remove('bg-white', 'text-primary');
        } else {
            // Update title and description
            titleElement.textContent = 'Simpanan Sukarela';
            descriptionElement.textContent = 'Pilih jumlah setoran simpanan sukarela sesuai keinginan Anda.';
            
            // Update amount input
            amountElement.value = '';
            amountElement.classList.remove('bg-gray-100', 'cursor-not-allowed');
            amountElement.removeAttribute('readonly');
            amountDescription.textContent = 'Minimal simpanan sukarela Rp10.000';
            
            // Update summary
            summaryAmount.textContent = 'Rp0';
            summaryTotal.textContent = 'Rp0';
            
            // Update tabs
            tabSukarela.classList.add('bg-white', 'text-primary');
            tabSukarela.classList.remove('bg-opacity-20', 'text-white', 'hover:bg-opacity-30');
            tabPokok.classList.add('bg-opacity-20', 'text-white', 'hover:bg-opacity-30');
            tabPokok.classList.remove('bg-white', 'text-primary');
        }
    }
    
    // Format currency input
    function formatCurrency(input) {
        // Remove non-digit characters
        let value = input.value.replace(/\D/g, '');
        
        // Format with thousand separators
        if (value !== '') {
            value = parseInt(value).toLocaleString('id-ID');
        }
        
        input.value = value;
        
        // Update summary
        updateSummary();
    }
    
    function updateSummary() {
        const amountInput = document.getElementById('amount');
        const summaryAmount = document.getElementById('summary-amount');
        const summaryTotal = document.getElementById('summary-total');
        
        // Get input value and remove non-digits
        let value = amountInput.value.replace(/\D/g, '');
        
        if (value === '') {
            value = '0';
        }
        
        // Format for display
        const formattedValue = parseInt(value).toLocaleString('id-ID');
        
        summaryAmount.textContent = `Rp${formattedValue}`;
        summaryTotal.textContent = `Rp${formattedValue}`;
    }
    
    // Initialize payment method selection
    document.addEventListener('DOMContentLoaded', function() {
        const paymentOptions = document.querySelectorAll('.payment-option');
        
        paymentOptions.forEach(option => {
            const radio = option.querySelector('input[type="radio"]');
            
            option.addEventListener('click', function() {
                radio.checked = true;
                
                // Remove selected styling from all options
                paymentOptions.forEach(opt => {
                    opt.classList.remove('border-primary', 'bg-blue-50');
                });
                
                // Add selected styling
                option.classList.add('border-primary', 'bg-blue-50');
            });
        });
        
        // Add input event listener
        const amountInput = document.getElementById('amount');
        amountInput.addEventListener('input', function() {
            formatCurrency(this);
        });
    });
    
    function showPaymentSuccess() {
        document.getElementById('success-modal').classList.remove('hidden');
    }
    
    function closeModal() {
        document.getElementById('success-modal').classList.add('hidden');
    }
</script>
@endsection