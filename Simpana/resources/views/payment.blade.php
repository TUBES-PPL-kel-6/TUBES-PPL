<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metode Pembayaran</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background: #FFF6DA;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background: #FFF6DA;
            width: 100%;
            max-width: 1500px;
            min-height: 100vh;
            padding: 40px;
            display: flex;
            gap: 20px;
        }

        .user-info {
            background: #F4D793;
            padding: 20px;
            border-radius: 25px;
            color: #BLACK;
            height: fit-content;
            width: 200px;
            line-height: 1.5;
        }

        .payment-section {
            background: rgb(255, 255, 255);
            padding: 30px;
            border-radius: 25px;
            width: 400px;
            height: fit-content;
            flex-grow: 1;
        }

        .payment-title {
            background: #F4D793;
            padding: 10px;
            border-radius: 25px;
            text-align: center;
            margin-bottom: 30px;
        }

        .payment-options {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .payment-option {
            background: #F4D793;
            padding: 10px 15px;
            border-radius: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            height: 35px;
            width: auto;
        }

        .payment-option.selected {
            background:rgb(255, 255, 255);
            color: Black;
            border: 2px solid #F4D793;
            transform: scale(1.02);
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .pay-button {
            background: #A94A4A;
            color: white;
            padding: 10px;
            border-radius: 25px;
            text-align: center;
            cursor: pointer;
            border: none;
            width: 100%;
            font-size: 16px;
        }

        .popup-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .popup-content {
            background: white;
            padding: 20px;
            border-radius: 15px;
            width: 400px;
        }

        .popup-title {
            background: #f0f0f0;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
        }

        .detail-container {
            background: #889E73;
            padding: 20px;
            border-radius: 15px;
            color: white;
        }

        .detail-header {
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #000;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .button-container {
            display: flex;
            gap: 10px;
            margin-top: 20px;
            justify-content: flex-end;
        }

        .back-button {
            background: #F4D793;
            padding: 8px 20px;
            border-radius: 20px;
            border: none;
            cursor: pointer;
        }

        .confirm-button {
            background: #A94A4A;
            color: white;
            padding: 8px 20px;
            border-radius: 20px;
            border: none;
            cursor: pointer;
        }

        .payment-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            width: auto;
        }

        .payment-logo img {
            width: 50px;
            height: 50px;
            object-fit: contain;
            margin-right: 20px;
        }

        .payment-logo span {
            font-size: 14px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .payment-price {
            font-size: 13px;
            margin-left: 10px;
            white-space: nowrap;
        }

        .payment-header {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .payment-section-title {
            font-size: 16px;
            font-weight: bold;
            margin: 20px 0 10px 0;
            color: #A94A4A;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="user-info">
            <div>Nama Anggota : Khalisa</div>
            <div>Nomor : 0812--------</div>
            <div>Email : Khal@....</div>
        </div>


        <div class="payment-section">
            <div style="font-size: 20px; font-weight: bold; margin-bottom: 20px;">
                Metode Pembayaran
            </div>

            <!-- E-Wallet -->
            <div class="payment-section-title">E-Wallet</div>
            <div class="payment-options">
                <div class="payment-option">
                    <div class="payment-logo">
                        <img src="{{ asset('images/payment-logos/gopay.png') }}" alt="gopay">
                        <span>GoPay</span>
                    </div>
                    <div class="payment-price">Rp 100.000</div>
                </div>
                <div class="payment-option">
                    <div class="payment-logo">
                        <img src="{{ asset('images/payment-logos/ovo.png') }}" alt="ovo">
                        <span>OVO</span>
                    </div>
                    <div class="payment-price">Rp 1.500.000</div>
                </div>
                <div class="payment-option">
                    <div class="payment-logo">
                        <img src="path/to/dana-logo.png" alt="Dana">
                        <span>Dana</span>
                    </div>
                    <div class="payment-price">Rp 250.000</div>
                </div>
            </div>

            <!-- Bank -->
            <div class="payment-section-title">Bank Transfer</div>
            <div class="payment-options">
                <div class="payment-option">
                    <div class="payment-logo">
                        <img src="path/to/bca-logo.png" alt="BCA">
                        <span>Bank BCA</span>
                    </div>
                    <div class="payment-price">Rp 2.000.000</div>
                </div>
                <div class="payment-option">
                    <div class="payment-logo">
                        <img src="path/to/bni-logo.png" alt="BNI">
                        <span>Bank BNI</span>
                    </div>
                    <div class="payment-price">Rp 2.000.000</div>
                </div>
                <div class="payment-option">
                    <div class="payment-logo">
                        <img src="path/to/mandiri-logo.png" alt="Mandiri">
                        <span>Bank Mandiri</span>
                    </div>
                    <div class="payment-price">Rp 2.000.000</div>
                </div>
            </div>

            <button class="pay-button" style="margin-top: 20px;">Bayar</button>
        </div>
    </div>

    <!-- popup konfirmasi -->
    <div class="popup-overlay" id="confirmationPopup">
        <div class="popup-content">
            <div class="popup-title">
                Konfirmasi Pembayaran
            </div>
            <div class="detail-container">
                <div class="detail-header">
                    <div>Nama Anggota : <span id="popupNama"></span></div>
                    <div>Nomor : <span id="popupNomor"></span></div>
                    <div>Email : <span id="popupEmail"></span></div>
                </div>
                <div class="detail-row">
                    <div>Tanggal</div>
                    <div id="currentDate"></div>
                </div>
                <div class="detail-row">
                    <div>Total Pembayaran</div>
                    <div>Rp.100.000</div>
                </div>
                <div class="detail-row">
                    <div>Payment method</div>
                    <div>(LOGO)</div>
                </div>
                <div class="button-container">
                    <button class="back-button" onclick="closePopup()">Back</button>
                    <button class="confirm-button">Bayar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function formatPrice(nominal) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(nominal);
        }

        // show popup
        function showPopup() {
            if (!selectedPayment) {
                alert('Silakan pilih metode pembayaran terlebih dahulu');
                return;
            }

            const popup = document.getElementById('confirmationPopup');
            popup.style.display = 'flex';
            
            // Set user details from the main screen
            document.getElementById('popupNama').textContent = 'Khalisa';
            document.getElementById('popupNomor').textContent = '0812--------';
            document.getElementById('popupEmail').textContent = 'Khal@....';
            
            // Set current date
            const today = new Date();
            const dateString = today.getDate().toString().padStart(2, '0') + '/' +
                             (today.getMonth() + 1).toString().padStart(2, '0') + '/' +
                             today.getFullYear();
            document.getElementById('currentDate').textContent = dateString;
        }

        // Function to close popup
        function closePopup() {
            const popup = document.getElementById('confirmationPopup');
            popup.style.display = 'none';
        }

        // Add click event to Bayar button
        document.querySelector('.pay-button').addEventListener('click', showPopup);

        // Handle payment option selection
        const paymentOptions = document.querySelectorAll('.payment-option');
        let selectedPayment = null;

        paymentOptions.forEach(option => {
            option.addEventListener('click', function() {
                // Remove selected class from previously selected option
                if (selectedPayment) {
                    selectedPayment.classList.remove('selected');
                }
                
                // Add selected class to clicked option
                this.classList.add('selected');
                selectedPayment = this;
                
                // Update payment method in popup
                const paymentMethod = this.querySelector('.payment-logo span').textContent;
                document.querySelector('.detail-row:last-of-type div:last-child').textContent = paymentMethod;
            });
        });
    </script>
</body>
</html>