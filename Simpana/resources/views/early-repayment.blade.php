<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelunasan Awal Pinjaman - Simpana</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#8C1414',
                        secondary: '#641010',
                        gold: '#FFD500',
                        white: '#FFFFFF'
                    }
                }
            }
        }
    </script>
    <!-- Font -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        .gold-gradient {
            background: linear-gradient(to right, #FFD500, #FFC107);
        }
        .crimson-gradient {
            background: linear-gradient(to right, #8C1414, #641010);
        }
        .selected-payment {
            border: 2px solid #8C1414;
            box-shadow: 0 0 0 2px rgba(140, 20, 20, 0.3);
        }
        .button-success {
            background: linear-gradient(to right, #10B981, #059669);
        }
    </style>
</head>
<body class="bg-white text-gray-800 font-sans">
    <div class="flex justify-center items-center min-h-screen p-4">
        <div class="container flex flex-col md:flex-row gap-6 max-w-6xl">
            <!-- Loan Info -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden w-full md:w-64 h-fit">
                <div class="bg-primary text-white p-4 font-bold text-lg">
                    <i class="fas fa-info-circle mr-2"></i>Informasi Pinjaman
                </div>
                <div class="p-5 border-t border-gray-200 space-y-3">
                    <div class="flex items-center text-sm">
                        <span class="font-semibold w-32">Jumlah Pinjaman:</span>
                        <span>Rp {{ number_format($loan->loan_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex items-center text-sm">
                        <span class="font-semibold w-32">Tenor:</span>
                        <span>{{ $loan->tenor }} bulan</span>
                    </div>
                    <div class="flex items-center text-sm">
                        <span class="font-semibold w-32">Tanggal Pengajuan:</span>
                        <span>{{ \Carbon\Carbon::parse($loan->application_date)->translatedFormat('d F Y') }}</span>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <div class="text-xs text-gray-500">Sisa yang harus dibayar</div>
                        <div class="text-lg font-bold text-primary">
                            Rp {{ number_format($remainingAmount, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment -->
            <div class="bg-white rounded-xl shadow-lg flex-grow overflow-hidden">
                <div class="bg-primary text-white p-5">
                    <h1 class="text-3xl font-bold">Pelunasan Awal Pinjaman</h1>
                    <p class="text-sm mt-1 opacity-90">Pilih metode pembayaran untuk melunasi pinjaman Anda</p>
                </div>

                <div class="p-6">
                    <form action="{{ route('early-repayment.process', $loan->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="amount" value="{{ $remainingAmount }}">

                        <!-- E-Wallet -->
                        <div class="mb-6">
                            <h2 class="flex items-center text-primary font-bold text-lg mb-4">
                                <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center mr-2">
                                    <i class="fas fa-wallet"></i>
                                </div>
                                E-Wallet
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <label class="payment-option border bg-white hover:bg-gray-50 rounded-xl p-4 flex justify-between items-center cursor-pointer transition-all">
                                    <div class="flex items-center">
                                        <img src="images\payment-logos\gopay.png" alt="GoPay" class="w-10 h-10 object-contain mr-3" />
                                        <span class="font-medium">GoPay</span>
                                    </div>
                                    <input type="radio" name="payment_method" value="gopay" class="hidden">
                                </label>

                                <label class="payment-option border bg-white hover:bg-gray-50 rounded-xl p-4 flex justify-between items-center cursor-pointer transition-all">
                                    <div class="flex items-center">
                                        <img src="images\payment-logos\ovo.png" alt="OVO" class="w-10 h-10 object-contain mr-3" />
                                        <span class="font-medium">OVO</span>
                                    </div>
                                    <input type="radio" name="payment_method" value="ovo" class="hidden">
                                </label>

                                <label class="payment-option border bg-white hover:bg-gray-50 rounded-xl p-4 flex justify-between items-center cursor-pointer transition-all">
                                    <div class="flex items-center">
                                        <img src="images\payment-logos\dana.png" alt="Dana" class="w-10 h-10 object-contain mr-3" />
                                        <span class="font-medium">Dana</span>
                                    </div>
                                    <input type="radio" name="payment_method" value="dana" class="hidden">
                                </label>
                            </div>
                        </div>

                        <!-- Bank Transfer -->
                        <div class="mb-8">
                            <h2 class="flex items-center text-primary font-bold text-lg mb-4">
                                <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center mr-2">
                                    <i class="fas fa-landmark"></i>
                                </div>
                                Bank Transfer
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <label class="payment-option border bg-white hover:bg-gray-50 rounded-xl p-4 flex justify-between items-center cursor-pointer transition-all">
                                    <div class="flex items-center">
                                        <img src="images\payment-logos\bca.png" alt="BCA" class="w-10 h-10 object-contain mr-3" />
                                        <span class="font-medium">Bank BCA</span>
                                    </div>
                                    <input type="radio" name="payment_method" value="bca" class="hidden">
                                </label>

                                <label class="payment-option border bg-white hover:bg-gray-50 rounded-xl p-4 flex justify-between items-center cursor-pointer transition-all">
                                    <div class="flex items-center">
                                        <img src="images\payment-logos\bni.png" alt="BNI" class="w-10 h-10 object-contain mr-3" />
                                        <span class="font-medium">Bank BNI</span>
                                    </div>
                                    <input type="radio" name="payment_method" value="bni" class="hidden">
                                </label>

                                <label class="payment-option border bg-white hover:bg-gray-50 rounded-xl p-4 flex justify-between items-center cursor-pointer transition-all">
                                    <div class="flex items-center">
                                        <img src="images\payment-logos\mandiri.png" alt="Mandiri" class="w-10 h-10 object-contain mr-3" />
                                        <span class="font-medium">Bank Mandiri</span>
                                    </div>
                                    <input type="radio" name="payment_method" value="mandiri" class="hidden">
                                </label>
                            </div>
                        </div>

                        <!-- Summary -->
                        <div class="bg-gray-50 rounded-xl p-4 mb-6 border border-gray-200">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Metode Pembayaran:</span>
                                <span class="font-medium text-primary" id="summaryMethod">-</span>
                            </div>
                            <div class="flex justify-between items-center mt-2">
                                <span class="text-gray-600">Total Pelunasan:</span>
                                <span class="font-bold text-lg">Rp {{ number_format($remainingAmount, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <!-- Pay Button -->
                        <div class="flex justify-end">
                            <button type="submit" class="gold-gradient hover:brightness-105 text-primary font-bold py-3 px-12 rounded-full transition-all shadow-md">
                                Bayar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Payment method selection
        document.querySelectorAll('.payment-option').forEach(option => {
            option.addEventListener('click', function() {
                // Remove selected class from all options
                document.querySelectorAll('.payment-option').forEach(opt => {
                    opt.classList.remove('selected-payment');
                });
                
                // Add selected class to clicked option
                this.classList.add('selected-payment');
                
                // Update summary
                const method = this.querySelector('span').textContent;
                document.getElementById('summaryMethod').textContent = method;
            });
        });
    </script>
</body>
</html> 