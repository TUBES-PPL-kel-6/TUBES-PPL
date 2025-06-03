<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metode Pembayaran - Simpana</title>

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
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-up': 'slideUp 0.3s ease-out',
                        'bounce-subtle': 'bounceSubtle 0.6s ease-in-out',
                        'glow': 'glow 2s ease-in-out infinite alternate'
                    }
                }
            }
        }
    </script>
    <!-- Font -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideUp {
            from { transform: translateY(100px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @keyframes bounceSubtle {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        @keyframes glow {
            from { box-shadow: 0 0 20px rgba(255, 213, 0, 0.3); }
            to { box-shadow: 0 0 40px rgba(255, 213, 0, 0.6); }
        }

        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
        }

        .gold-gradient {
            background: linear-gradient(135deg, #FFD500, #FFC107, #FF8F00);
            background-size: 200% 200%;
            animation: gradientShift 3s ease infinite;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .crimson-gradient {
            background: linear-gradient(135deg, #8C1414, #641010, #4a0e0e);
        }

        .selected-payment {
            border: 3px solid #8C1414;
            box-shadow: 0 0 0 4px rgba(140, 20, 20, 0.2), 0 8px 25px rgba(140, 20, 20, 0.15);
            transform: translateY(-2px);
        }

        .payment-option {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid transparent;
            background: linear-gradient(145deg, #ffffff, #f8fafc);
        }

        .payment-option:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border-color: rgba(140, 20, 20, 0.3);
        }

        .glass-morphism {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .card-shadow {
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1), 0 0 0 1px rgba(255, 255, 255, 0.5);
        }

        .button-success {
            background: linear-gradient(135deg, #10B981, #059669, #047857);
        }

        .floating-animation {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .section-divider {
            background: linear-gradient(90deg, transparent, #8C1414, transparent);
            height: 2px;
            margin: 2rem 0;
        }

        .icon-bounce {
            animation: iconBounce 2s ease-in-out infinite;
        }

        @keyframes iconBounce {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        .price-highlight {
            color: #8C1414;
            font-weight: bold;
        }
    </style>
</head>
<body class="text-gray-800 font-sans">
    <!-- Background decorative elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-8 left-4 w-16 h-16 bg-gradient-to-br from-primary/10 to-gold/10 rounded-full blur-xl floating-animation"></div>
        <div class="absolute bottom-8 right-4 w-20 h-20 bg-gradient-to-br from-gold/10 to-primary/10 rounded-full blur-xl floating-animation" style="animation-delay: -3s;"></div>
    </div>

    <div class="relative flex justify-center items-center min-h-screen p-4">
        <div class="container flex flex-col lg:flex-row gap-8 max-w-5xl w-full animate-fade-in">
            <!-- Back Button -->
            <div class="absolute top-4 left-4 z-20">
                <a href="{{ route('register') }}" class="inline-flex items-center px-2 py-1 border border-[#8C1414] bg-white text-[#8C1414] font-semibold rounded-lg shadow hover:bg-[#8C1414] hover:text-white transition-colors duration-200">
                    <i class="fas fa-arrow-left"></i>
                </a>
            </div>

            <!-- User Info Card -->
            <div class="glass-morphism rounded-xl card-shadow overflow-hidden w-full max-w-xs lg:w-80 h-fit animate-slide-up">
                <div class="bg-gradient-to-r from-primary to-secondary text-white p-6 relative overflow-hidden">
                    <div class="relative z-10">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center mr-4 icon-bounce">
                                <i class="fas fa-user-circle text-xl"></i>
                            </div>
                            <h2 class="text-xl font-bold">Info Anggota</h2>
                        </div>
                    </div>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center p-2 bg-gradient-to-r from-gray-50 to-white rounded-lg border border-gray-100">
                        <div class="w-7 h-7 bg-primary/10 rounded-full flex items-center justify-center mr-2">
                            <i class="fas fa-user text-primary text-xs"></i>
                        </div>
                        <div class="flex-1">
                            <span class="text-[10px] text-gray-500 font-medium uppercase tracking-wide">Nama</span>
                            <div class="font-semibold text-xs text-gray-800">{{ $user->nama }}</div>
                        </div>
                    </div>
                    <div class="flex items-center p-2 bg-gradient-to-r from-gray-50 to-white rounded-lg border border-gray-100">
                        <div class="w-7 h-7 bg-primary/10 rounded-full flex items-center justify-center mr-2">
                            <i class="fas fa-phone text-primary text-xs"></i>
                        </div>
                        <div class="flex-1">
                            <span class="text-[10px] text-gray-500 font-medium uppercase tracking-wide">Nomor</span>
                            <div class="font-semibold text-xs text-gray-800">{{ $user->no_telp }}</div>
                        </div>
                    </div>
                    <div class="flex items-center p-2 bg-gradient-to-r from-gray-50 to-white rounded-lg border border-gray-100">
                        <div class="w-7 h-7 bg-primary/10 rounded-full flex items-center justify-center mr-2">
                            <i class="fas fa-envelope text-primary text-xs"></i>
                        </div>
                        <div class="flex-1">
                            <span class="text-[10px] text-gray-500 font-medium uppercase tracking-wide">Email</span>
                            <div class="font-semibold text-xs text-gray-800">{{ $user->email }}</div>
                        </div>
                    </div>
                    <div class="mt-3 pt-2 border-t border-gray-200">
                        <div class="flex items-center">
                            <div class="w-6 h-6 bg-gold/20 rounded-full flex items-center justify-center mr-2">
                                <i class="fas fa-calendar-alt text-gold text-xs"></i>
                            </div>
                            <div>
                                <div class="text-[10px] text-gray-500 font-medium">Member sejak</div>
                                <div class="text-xs font-semibold text-primary">
                                    {{ \Carbon\Carbon::parse($user->created_at)->translatedFormat('d F Y') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Section -->
            <div class="glass-morphism rounded-xl card-shadow flex-grow overflow-hidden animate-slide-up" style="animation-delay: 0.2s;">
                <div class="bg-gradient-to-r from-primary via-secondary to-primary text-white p-4 relative overflow-hidden">
                    <div class="relative z-10">
                        <div class="flex items-center mb-2">
                            <div class="w-10 h-10 bg-white/20 rounded-2xl flex items-center justify-center mr-3 icon-bounce">
                                <i class="fas fa-credit-card text-xl"></i>
                            </div>
                            <div>
                                <h1 class="text-xl font-bold mb-1">Metode Pembayaran</h1>
                                <p class="text-sm opacity-90">Pilih metode pembayaran</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-4">
                    <!-- E-Wallet Section -->
                    <div class="mb-6">
                        <div class="flex items-center mb-3">
                            <div class="w-8 h-8 rounded-2xl bg-gradient-to-r from-primary to-secondary text-white flex items-center justify-center mr-2 icon-bounce">
                                <i class="fas fa-wallet text-base"></i>
                            </div>
                            <h2 class="text-base font-bold bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">
                                E-Wallet
                            </h2>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div class="payment-option rounded-lg p-3 flex flex-col items-center cursor-pointer group">
                                <div class="w-12 h-12 mb-2 flex items-center justify-center bg-white rounded-lg shadow group-hover:shadow-lg transition-all">
                                    <img src="images/payment-logos/gopay.png" alt="GoPay" class="w-8 h-8 object-contain" />
                                </div>
                                <span class="font-bold text-xs mb-1 text-gray-800">GoPay</span>
                                <div class="price-highlight text-sm font-bold">Rp 50.000</div>
                                <div class="mt-1 text-[11px] text-gray-500 text-center">Pembayaran Instan</div>
                            </div>
                            <div class="payment-option rounded-lg p-3 flex flex-col items-center cursor-pointer group">
                                <div class="w-12 h-12 mb-2 flex items-center justify-center bg-white rounded-lg shadow group-hover:shadow-lg transition-all">
                                    <img src="images/payment-logos/ovo.png" alt="OVO" class="w-8 h-8 object-contain" />
                                </div>
                                <span class="font-bold text-xs mb-1 text-gray-800">OVO</span>
                                <div class="price-highlight text-sm font-bold">Rp 50.000</div>
                                <div class="mt-1 text-[11px] text-gray-500 text-center">Cashback Tersedia</div>
                            </div>
                            <div class="payment-option rounded-lg p-3 flex flex-col items-center cursor-pointer group">
                                <div class="w-12 h-12 mb-2 flex items-center justify-center bg-white rounded-lg shadow group-hover:shadow-lg transition-all">
                                    <img src="images/payment-logos/dana.png" alt="Dana" class="w-8 h-8 object-contain" />
                                </div>
                                <span class="font-bold text-xs mb-1 text-gray-800">Dana</span>
                                <div class="price-highlight text-sm font-bold">Rp 50.000</div>
                                <div class="mt-1 text-[11px] text-gray-500 text-center">Tanpa Biaya Admin</div>
                            </div>
                        </div>
                    </div>
                    <!-- Section Divider -->
                    <div class="section-divider my-4"></div>
                    <!-- Bank Transfer Section -->
                    <div class="mb-6">
                        <div class="flex items-center mb-3">
                            <div class="w-8 h-8 rounded-2xl bg-gradient-to-r from-primary to-secondary text-white flex items-center justify-center mr-2 icon-bounce">
                                <i class="fas fa-landmark text-base"></i>
                            </div>
                            <h2 class="text-base font-bold bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">
                                Bank Transfer
                            </h2>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div class="payment-option rounded-lg p-3 flex flex-col items-center cursor-pointer group">
                                <div class="w-12 h-12 mb-2 flex items-center justify-center bg-white rounded-lg shadow group-hover:shadow-lg transition-all">
                                    <img src="images/payment-logos/bca.png" alt="BCA" class="w-8 h-8 object-contain" />
                                </div>
                                <span class="font-bold text-xs mb-1 text-gray-800">Bank BCA</span>
                                <div class="price-highlight text-sm font-bold">Rp 50.000</div>
                                <div class="mt-1 text-[11px] text-gray-500 text-center">Transfer Real-time</div>
                            </div>
                            <div class="payment-option rounded-lg p-3 flex flex-col items-center cursor-pointer group">
                                <div class="w-12 h-12 mb-2 flex items-center justify-center bg-white rounded-lg shadow group-hover:shadow-lg transition-all">
                                    <img src="images/payment-logos/bni.png" alt="BNI" class="w-8 h-8 object-contain" />
                                </div>
                                <span class="font-bold text-xs mb-1 text-gray-800">Bank BNI</span>
                                <div class="price-highlight text-sm font-bold">Rp 50.000</div>
                                <div class="mt-1 text-[11px] text-gray-500 text-center">Proses Cepat</div>
                            </div>
                            <div class="payment-option rounded-lg p-3 flex flex-col items-center cursor-pointer group">
                                <div class="w-12 h-12 mb-2 flex items-center justify-center bg-white rounded-lg shadow group-hover:shadow-lg transition-all">
                                    <img src="images/payment-logos/mandiri.png" alt="Mandiri" class="w-8 h-8 object-contain" />
                                </div>
                                <span class="font-bold text-xs mb-1 text-gray-800">Bank Mandiri</span>
                                <div class="price-highlight text-sm font-bold">Rp 50.000</div>
                                <div class="mt-1 text-[11px] text-gray-500 text-center">Aman & Terpercaya</div>
                            </div>
                        </div>
                    </div>
                    <!-- Payment Summary -->
                    <div class="bg-gradient-to-r from-gray-50 to-white rounded-xl p-4 mb-6 border-2 border-gray-100 card-shadow">
                        <h3 class="text-base font-bold text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-receipt text-primary mr-2"></i>
                            Ringkasan Pembayaran
                        </h3>
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600 font-medium">Metode:</span>
                                <span class="font-bold text-primary text-base" id="summaryMethod">Belum dipilih</span>
                            </div>
                            <div class="flex justify-between items-center pt-2 border-t border-gray-200">
                                <span class="text-sm text-gray-600 font-medium">Total:</span>
                                <span class="font-bold text-lg price-highlight" id="summaryAmount">-</span>
                            </div>
                        </div>
                    </div>
                    <!-- Pay Button -->
                    <div class="flex justify-center">
                        <button class="gold-gradient hover:brightness-110 text-primary font-bold py-2 px-8 rounded-xl transition-all shadow-lg hover:shadow-xl transform hover:scale-105 text-base animate-glow">
                            <i class="fas fa-lock mr-2"></i>
                            Bayar Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Popup -->
    <div class="popup-overlay fixed inset-0 bg-black/70 hidden justify-center items-center z-50 backdrop-blur-sm" id="confirmationPopup">
        <div class="glass-morphism rounded-3xl card-shadow w-full max-w-sm mx-2 overflow-hidden transform transition-all duration-500 scale-95 opacity-0" id="popupContent">
            <!-- Header -->
            <div class="bg-primary text-white px-6 py-4 flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-white/20 rounded-2xl flex items-center justify-center mr-3">
                        <i class="fas fa-shield-alt text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold">Konfirmasi Pembayaran</h3>
                </div>
                <button onclick="closePopup()" class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center hover:bg-white/30 transition-all">
                    <i class="fas fa-times text-base"></i>
                </button>
            </div>
            <!-- Body -->
            <div class="p-4 bg-transparent">
                <!-- Payment Method Display -->
                <div class="flex items-center justify-center mb-4 p-2 bg-blue-50 rounded-xl">
                    <div class="w-10 h-10 rounded-xl bg-blue-500 text-white flex items-center justify-center mr-3">
                        <i class="fas fa-credit-card text-lg"></i>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500 font-medium">Metode Pembayaran</div>
                        <div id="popupPaymentMethod" class="font-bold text-base text-blue-600">Bank BNI</div>
                    </div>
                </div>
                <!-- Payment Details -->
                <div class="bg-white border border-gray-100 rounded-xl p-3 shadow-sm mb-4">
                    <!-- User Info Section -->
                    <div class="border-b border-gray-200 pb-3 mb-3">
                        <h4 class="font-bold text-gray-800 mb-2 flex items-center text-sm">
                            <i class="fas fa-user-check text-blue-600 mr-2"></i>
                            Informasi Pengguna
                        </h4>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <div class="w-7 h-7 rounded-lg bg-blue-100 flex items-center justify-center mr-2">
                                    <i class="fas fa-user text-blue-600 text-xs"></i>
                                </div>
                                <div>
                                    <div class="text-[10px] text-gray-500 font-medium uppercase tracking-wide">Nama Anggota</div>
                                    <div id="popupNama" class="font-semibold text-xs text-gray-800">Administrator</div>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="w-7 h-7 rounded-lg bg-blue-100 flex items-center justify-center mr-2">
                                    <i class="fas fa-phone text-blue-600 text-xs"></i>
                                </div>
                                <div>
                                    <div class="text-[10px] text-gray-500 font-medium uppercase tracking-wide">Nomor Telepon</div>
                                    <div id="popupNomor" class="font-semibold text-xs text-gray-800">081234567890</div>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="w-7 h-7 rounded-lg bg-blue-100 flex items-center justify-center mr-2">
                                    <i class="fas fa-envelope text-blue-600 text-xs"></i>
                                </div>
                                <div>
                                    <div class="text-[10px] text-gray-500 font-medium uppercase tracking-wide">Email</div>
                                    <div id="popupEmail" class="font-semibold text-xs text-gray-800">admin@simpana.com</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Transaction Time -->
                    <div class="mb-3">
                        <h4 class="font-bold text-gray-800 mb-2 flex items-center text-sm">
                            <i class="fas fa-clock text-green-600 mr-2"></i>
                            Waktu Transaksi
                        </h4>
                        <div class="grid grid-cols-2 gap-2">
                            <div class="flex items-center">
                                <div class="w-7 h-7 rounded-lg bg-green-100 flex items-center justify-center mr-2">
                                    <i class="fas fa-calendar-alt text-green-600 text-xs"></i>
                                </div>
                                <div>
                                    <div class="text-[10px] text-gray-500 font-medium">Tanggal</div>
                                    <div id="currentDate" class="font-semibold text-xs text-gray-800">27-05-2025</div>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="w-7 h-7 rounded-lg bg-green-100 flex items-center justify-center mr-2">
                                    <i class="fas fa-clock text-green-600 text-xs"></i>
                                </div>
                                <div>
                                    <div class="text-[10px] text-gray-500 font-medium">Waktu</div>
                                    <div id="currentTime" class="font-semibold text-xs text-gray-800">03:25</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Total Amount -->
                    <div class="bg-gradient-to-r from-primary/10 to-gold/10 p-2 rounded-lg flex justify-between items-center">
                        <div class="text-sm font-bold text-gray-700">Total Pembayaran</div>
                        <div id="popupAmount" class="font-bold text-lg price-highlight">Rp 50.000</div>
                    </div>
                </div>
                <!-- Security Notice -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-3 mb-4 flex items-start">
                    <div class="w-6 h-6 bg-yellow-100 rounded-full flex items-center justify-center mr-2 flex-shrink-0 mt-0.5">
                        <i class="fas fa-shield-alt text-yellow-600 text-base"></i>
                    </div>
                    <div>
                        <div class="font-semibold text-yellow-800 mb-0.5 text-sm">Keamanan Transaksi</div>
                        <div class="text-xs text-yellow-700">
                            Pastikan data pembayaran sudah benar sebelum melanjutkan. Pembayaran yang telah dikonfirmasi tidak dapat dibatalkan.
                        </div>
                    </div>
                </div>
                <!-- Action Buttons -->
                <div class="flex gap-2">
                    <button class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-3 py-2 rounded-lg transition-all flex items-center justify-center text-xs" onclick="closePopup()">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Kembali
                    </button>
                    <form action="{{ route('payment.process') }}" method="POST" id="paymentForm" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full bg-primary hover:bg-secondary text-white font-bold px-3 py-2 rounded-lg transition-all flex items-center justify-center shadow text-xs" id="confirmPaymentBtn">
                            <i class="fas fa-shield-alt mr-1"></i>
                            Konfirmasi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Format price
        function formatPrice(nominal) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(nominal);
        }

        // Payment option
        const paymentOptions = document.querySelectorAll('.payment-option');
        let selectedPayment = null;
        let selectedAmount = null;

        paymentOptions.forEach(option => {
            option.addEventListener('click', function() {
                if (selectedPayment) {
                    selectedPayment.classList.remove('selected-payment');
                }

                // clicked option
                this.classList.add('selected-payment');
                selectedPayment = this;

                // payment & amount
                const paymentMethod = this.querySelector('span').textContent;
                selectedAmount = this.querySelector('.price-highlight').textContent;

                // Update summary & popup
                document.getElementById('summaryMethod').textContent = paymentMethod;
                document.getElementById('summaryAmount').textContent = selectedAmount;
                document.getElementById('popupPaymentMethod').textContent = paymentMethod;
                document.getElementById('popupAmount').textContent = selectedAmount;
            });
        });

        // Show popup
        function showPopup() {
            if (!selectedPayment) {
                alert('Silakan pilih metode pembayaran terlebih dahulu');
                return;
            }

            const popup = document.getElementById('confirmationPopup');
            const popupContent = document.getElementById('popupContent');

            // Show overlay
            popup.classList.remove('hidden');
            popup.classList.add('flex');

            // Reset confirm button
            const confirmBtn = document.getElementById('confirmPaymentBtn');
            if (confirmBtn) {
                confirmBtn.innerHTML = '<i class="fas fa-shield-alt mr-2"></i>Konfirmasi';
                confirmBtn.disabled = false;
                confirmBtn.classList.remove('button-success', 'bg-green-600', 'hover:bg-green-700');
                confirmBtn.classList.add('crimson-gradient');
            }

            // Animate content
            setTimeout(() => {
                popupContent.classList.remove('scale-95', 'opacity-0');
                popupContent.classList.add('scale-100', 'opacity-100');
            }, 50);

            // date and time
            const today = new Date();
            const dateString = today.getDate().toString().padStart(2, '0') + '-' +
                (today.getMonth() + 1).toString().padStart(2, '0') + '-' +
                today.getFullYear();
            document.getElementById('currentDate').textContent = dateString;

            const timeString = today.getHours().toString().padStart(2, '0') + ':' +
                today.getMinutes().toString().padStart(2, '0');
            document.getElementById('currentTime').textContent = timeString;
        }

        // Close popup
        function closePopup() {
            const popup = document.getElementById('confirmationPopup');
            const popupContent = document.getElementById('popupContent');

            // Animate out
            popupContent.classList.remove('scale-100', 'opacity-100');
            popupContent.classList.add('scale-95', 'opacity-0');

            // Hide overlay after animation
            setTimeout(() => {
                popup.classList.add('hidden');
                popup.classList.remove('flex');
            }, 300);
        }

        document.addEventListener('DOMContentLoaded', function() {
            // click event to Pay button
            const payButton = document.querySelector('button.gold-gradient');
            if (payButton) {
                payButton.addEventListener('click', showPopup);
            }

            // Add click event for confirmation button
            const confirmBtn = document.getElementById('confirmPaymentBtn');
            if (confirmBtn) {
                confirmBtn.addEventListener('click', function(e) {
                    // Prevent the default form submission
                    e.preventDefault();

                    this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
                    this.disabled = true;

                    setTimeout(() => {
                        this.innerHTML = '<i class="fas fa-check mr-2"></i>Berhasil!';
                        this.classList.remove('crimson-gradient');
                        this.classList.add('button-success');

                        setTimeout(() => {
                            // Submit the form after showing success message
                            document.getElementById('paymentForm').submit();
                        }, 1500);
                    }, 2000);
                });
            }
        });
    </script>
</body>
</html>
