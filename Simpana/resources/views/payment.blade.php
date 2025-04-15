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
            <!-- User Info -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden w-full md:w-64 h-fit">
                <div class="bg-primary text-white p-4 font-bold text-lg">
                    <i class="fas fa-user-circle mr-2"></i>Informasi Anggota
                </div>
                <div class="p-5 border-t border-gray-200 space-y-3">
                    <div class="flex items-center text-sm">
                        <span class="font-semibold w-32">Nama Anggota:</span>
                        <span>Khalisa</span>
                    </div>
                    <div class="flex items-center text-sm">
                        <span class="font-semibold w-32">Nomor:</span>
                        <span>0812--------</span>
                    </div>
                    <div class="flex items-center text-sm">
                        <span class="font-semibold w-32">Email:</span>
                        <span>Khal@....</span>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <div class="text-xs text-gray-500">Member sejak</div>
                        <div class="text-sm font-medium">01 Januari 2025</div>
                    </div>
                </div>
            </div>

            <!-- Payment -->
            <div class="bg-white rounded-xl shadow-lg flex-grow overflow-hidden">
                <div class="bg-primary text-white p-5">
                    <h1 class="text-3xl font-bold">Metode Pembayaran</h1>
                    <p class="text-sm mt-1 opacity-90">Pilih metode pembayaran yang Anda inginkan</p>
                </div>

                <div class="p-6">
                    <!-- E-Wallet -->
                    <div class="mb-6">
                        <h2 class="flex items-center text-primary font-bold text-lg mb-4">
                            <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center mr-2">
                                <i class="fas fa-wallet"></i>
                            </div>
                            E-Wallet
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="payment-option border bg-white hover:bg-gray-50 rounded-xl p-4 flex justify-between items-center cursor-pointer transition-all">
                                <div class="flex items-center">
                                    <img src="images\payment-logos\gopay.png" alt="GoPay" class="w-10 h-10 object-contain mr-3" />
                                    <span class="font-medium">GoPay</span>
                                </div>
                                <div class="text-sm font-semibold">Rp 100.000</div>
                            </div>

                            <div class="payment-option border bg-white hover:bg-gray-50 rounded-xl p-4 flex justify-between items-center cursor-pointer transition-all">
                                <div class="flex items-center">
                                    <img src="images\payment-logos\ovo.png" alt="OVO" class="w-10 h-10 object-contain mr-3" />
                                    <span class="font-medium">OVO</span>
                                </div>
                                <div class="text-sm font-semibold">Rp 1.500.000</div>
                            </div>

                            <div class="payment-option border bg-white hover:bg-gray-50 rounded-xl p-4 flex justify-between items-center cursor-pointer transition-all">
                                <div class="flex items-center">
                                    <img src="images\payment-logos\dana.png" alt="Dana" class="w-10 h-10 object-contain mr-3" />
                                    <span class="font-medium">Dana</span>
                                </div>
                                <div class="text-sm font-semibold">Rp 250.000</div>
                            </div>
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
                            <div class="payment-option border bg-white hover:bg-gray-50 rounded-xl p-4 flex justify-between items-center cursor-pointer transition-all">
                                <div class="flex items-center">
                                    <img src="images\payment-logos\bca.png" alt="BCA" class="w-10 h-10 object-contain mr-3" />
                                    <span class="font-medium">Bank BCA</span>
                                </div>
                                <div class="text-sm font-semibold">Rp 2.000.000</div>
                            </div>

                            <div class="payment-option border bg-white hover:bg-gray-50 rounded-xl p-4 flex justify-between items-center cursor-pointer transition-all">
                                <div class="flex items-center">
                                    <img src="images\payment-logos\bni.png" alt="BNI" class="w-10 h-10 object-contain mr-3" />
                                    <span class="font-medium">Bank BNI</span>
                                </div>
                                <div class="text-sm font-semibold">Rp 2.000.000</div>
                            </div>

                            <div class="payment-option border bg-white hover:bg-gray-50 rounded-xl p-4 flex justify-between items-center cursor-pointer transition-all">
                                <div class="flex items-center">
                                    <img src="images\payment-logos\mandiri.png" alt="Mandiri" class="w-10 h-10 object-contain mr-3" />
                                    <span class="font-medium">Bank Mandiri</span>
                                </div>
                                <div class="text-sm font-semibold">Rp 2.000.000</div>
                            </div>
                        </div>
                    </div>

                    <!-- Summary -->
                    <div class="bg-gray-50 rounded-xl p-4 mb-6 border border-gray-200">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Metode Pembayaran:</span>
                            <span class="font-medium text-primary" id="summaryMethod">-</span>
                        </div>
                        <div class="flex justify-between items-center mt-2">
                            <span class="text-gray-600">Total:</span>
                            <span class="font-bold text-lg" id="summaryAmount">-</span>
                        </div>
                    </div>

                    <!-- Pay Button -->
                    <div class="flex justify-end">
                        <button class="gold-gradient hover:brightness-105 text-primary font-bold py-3 px-12 rounded-full transition-all shadow-md">
                            Bayar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- popup -->
    <div class="popup-overlay fixed inset-0 bg-black bg-opacity-60 hidden justify-center items-center z-50" id="confirmationPopup">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4 overflow-hidden transform transition-all duration-300 scale-95 opacity-0" id="popupContent">
            <div class="bg-gray-50 border-b border-gray-200 text-gray-800 p-4 relative">
                <h3 class="text-xl font-bold text-center">Konfirmasi Pembayaran</h3>
                <button onclick="closePopup()" class="absolute right-4 top-4 text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="p-6">
                <!-- icon & method -->
                <div class="flex items-center justify-center mb-5">
                    <div class="w-12 h-12 rounded-full bg-blue-600 text-white flex items-center justify-center mr-3">
                        <i class="fas fa-credit-card text-xl"></i>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Metode Pembayaran</div>
                        <div id="popupPaymentMethod" class="font-bold text-lg text-blue-600"></div>
                    </div>
                </div>

                <!-- Payment details -->
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                    <!-- User Info -->
                    <div class="border-b border-gray-200 pb-4 mb-4">
                        <div class="flex items-center mb-3">
                            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                <i class="fas fa-user text-blue-600"></i>
                            </div>
                            <div>
                                <div class="text-xs text-gray-500">Nama Anggota</div>
                                <div id="popupNama" class="font-medium text-gray-800">Khalisa</div>
                            </div>
                        </div>

                        <div class="flex items-center mb-3">
                            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                <i class="fas fa-phone text-blue-600"></i>
                            </div>
                            <div>
                                <div class="text-xs text-gray-500">Nomor Telepon</div>
                                <div id="popupNomor" class="font-medium text-gray-800">0812--------</div>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                <i class="fas fa-envelope text-blue-600"></i>
                            </div>
                            <div>
                                <div class="text-xs text-gray-500">Email</div>
                                <div id="popupEmail" class="font-medium text-gray-800">Khal@....</div>
                            </div>
                        </div>
                    </div>

                    <!-- Waktu  -->
                    <div class="mb-4">
                        <div class="flex justify-between py-2">
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-calendar-alt mr-2 text-blue-600"></i>Tanggal
                            </div>
                            <div id="currentDate" class="text-gray-800"></div>
                        </div>

                        <div class="flex justify-between py-2">
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-clock mr-2 text-blue-600"></i>Waktu
                            </div>
                            <div id="currentTime" class="text-gray-800"></div>
                        </div>
                    </div>

                    <!-- Total -->
                    <div class="flex justify-between items-center bg-gray-50 p-3 rounded-lg">
                        <div class="text-lg font-medium text-gray-700">Total Pembayaran</div>
                        <div id="popupAmount" class="font-bold text-xl text-blue-600">Rp 2.000.000</div>
                    </div>
                </div>

                <!-- Warning -->
                <div class="mt-4 text-sm text-gray-500 flex items-start">
                    <i class="fas fa-info-circle mt-1 mr-2 text-blue-600"></i>
                    <span>Pastikan data pembayaran sudah benar sebelum melanjutkan. Pembayaran yang telah dikonfirmasi tidak dapat dibatalkan.</span>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <button class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2 rounded-lg transition-colors flex items-center" onclick="closePopup()">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </button>
                    <button class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-8 py-2 rounded-lg transition-all flex items-center shadow-md" id="confirmPaymentBtn">
                        Konfirmasi<i class="fas fa-check ml-2"></i>
                    </button>
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
                    selectedPayment.classList.remove('bg-gray-50');
                }

                // clicked option
                this.classList.add('selected-payment');
                this.classList.add('bg-gray-50');
                selectedPayment = this;

                // payment & amount
                const paymentMethod = this.querySelector('.flex span').textContent;
                selectedAmount = this.querySelector('.text-sm').textContent;

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


            const confirmBtn = document.getElementById('confirmPaymentBtn');
            if (confirmBtn) {
                confirmBtn.innerHTML = 'Konfirmasi<i class="fas fa-check ml-2"></i>';
                confirmBtn.disabled = false;
                confirmBtn.classList.add('crimson-gradient');
                confirmBtn.classList.remove('bg-green-600');
            }

            // Animate content
            setTimeout(() => {
                popupContent.classList.remove('scale-95', 'opacity-0');
                popupContent.classList.add('scale-100', 'opacity-100');
            }, 50);

            // date and time
            const today = new Date();
            const dateString = today.getDate().toString().padStart(2, '0') + '/' +
                            (today.getMonth() + 1).toString().padStart(2, '0') + '/' +
                            today.getFullYear();
            document.getElementById('currentDate').textContent = dateString;

            const timeString = today.getHours().toString().padStart(2, '0') + ':' +
                            today.getMinutes().toString().padStart(2, '0');
            document.getElementById('currentTime').textContent = timeString;
        }

        document.addEventListener('DOMContentLoaded', function() {
            // click for confirm button
            const confirmBtn = document.getElementById('confirmPaymentBtn');
            if (confirmBtn) {
                confirmBtn.addEventListener('click', function() {
                    this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
                    this.disabled = true;

                    setTimeout(() => {
                        this.innerHTML = '<i class="fas fa-check mr-2"></i>Berhasil!';
                        this.classList.remove('bg-blue-600', 'hover:bg-blue-700');
                        this.classList.add('bg-green-600', 'hover:bg-green-700');

                        setTimeout(() => {
                            closePopup();
                            // redirect or success
                        }, 1500);
                    }, 2000);
                });
            }
        });

        // Close popup
        function closePopup() {
            const popup = document.getElementById('confirmationPopup');
            const popupContent = document.getElementById('popupContent');

            // Animate out
            popupContent.classList.remove('scale-100', 'opacity-100');
            popupContent.classList.add('scale-95', 'opacity-0');

            // Hide overlay
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
                confirmBtn.addEventListener('click', function() {
                    this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
                    this.disabled = true;

                    setTimeout(() => {
                        this.innerHTML = '<i class="fas fa-check mr-2"></i>Berhasil!';
                        this.classList.remove('crimson-gradient');
                        this.classList.add('bg-green-600');

                        setTimeout(() => {
                            closePopup();
                        }, 1500);
                    }, 2000);
                });
            }
        });
    </script>
</body>
</html>
