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
            background: white;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background: white;
            width: 100%;
            max-width: 800px;
            min-height: 100vh;
            padding: 40px;
            display: flex;
            gap: 20px;
        }

        .user-info {
            background: #808080;
            padding: 20px;
            border-radius: 25px;
            color: black;
            height: fit-content;
            width: 200px;
            line-height: 1.5;
        }

        .payment-section {
            background: #808080;
            padding: 30px;
            border-radius: 25px;
            width: 400px;
            height: 250px;
            flex-grow: 1;
        }

        .payment-title {
            background: white;
            padding: 10px;
            border-radius: 25px;
            text-align: center;
            margin-bottom: 30px;
        }

        .payment-options {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .payment-option {
            background: white;
            padding: 15px;
            border-radius: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .pay-button {
            background: white;
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
            background: #808080;
            padding: 20px;
            border-radius: 15px;
            color: black;
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
            background: white;
            padding: 8px 20px;
            border-radius: 20px;
            border: none;
            cursor: pointer;
        }

        .confirm-button {
            background: #808080;
            color: white;
            padding: 8px 20px;
            border-radius: 20px;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- User Info Section -->
        <div class="user-info">
            <div>Nama Anggota : Khalisa</div>
            <div>Nomor : 0812--------</div>
            <div>Email : Khal@....</div>
        </div>

        <!-- Payment Section -->
        <div class="payment-section">
            <div class="payment-title">
                Metode Pembayaran
            </div>

            <div class="payment-options">
                <div class="payment-option">
                    <div>(LOGO) Gopay</div>
                    <div>Nominal</div>
                </div>
                <div class="payment-option">
                    <div>(LOGO) Gopay</div>
                    <div>Nominal</div>
                </div>
                <div class="payment-option">
                    <div>(LOGO) Gopay</div>
                    <div>Nominal</div>
                </div>
                <div class="payment-option">
                    <div>(LOGO) Gopay</div>
                    <div>Nominal</div>
                </div>
            </div>

            <button class="pay-button">Bayar</button>
        </div>
    </div>

    <!-- Confirmation Popup -->
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
                    <div>(LOGO)GoPay</div>
                </div>
                <div class="button-container">
                    <button class="back-button" onclick="closePopup()">Back</button>
                    <button class="confirm-button">Bayar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Function to show popup
        function showPopup() {
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
    </script>
</body>
</html>