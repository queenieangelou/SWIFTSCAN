<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Theater Seating</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
        }

        #seating-container {
            display: grid;
            grid-template-columns: repeat(8, 50px);
            grid-template-rows: repeat(5, 50px);
            gap: 10px;
        }

        .seat {
            width: 50px;
            height: 50px;
            background-color: #bdc3c7;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: bold;
        }

        .seat.selected {
            background-color: #2ecc71;
        }

        #message {
            margin-top: 20px;
            font-size: 18px;
        }

        #qr-code-input {
            margin-top: 10px;
            padding: 5px;
            font-size: 16px;
        }
    </style>
</head>
<body>

<div id="seating-container"></div>
<div id="message"></div>
<input type="text" id="qr-code-input" placeholder="Scan QR Code">

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const seatingContainer = document.getElementById('seating-container');
        const messageDiv = document.getElementById('message');
        const qrCodeInput = document.getElementById('qr-code-input');

        // Create 40 seats
        for (let row = 1; row <= 5; row++) {
            for (let col = 1; col <= 8; col++) {
                const seat = document.createElement('div');
                seat.classList.add('seat');
                seat.textContent = (row - 1) * 8 + col;

                seat.addEventListener('click', function () {
                    seat.classList.toggle('selected');
                    updateMessage();
                });

                seatingContainer.appendChild(seat);
            }
        }

        function updateMessage() {
            const selectedSeats = document.querySelectorAll('.seat.selected');
            const seatNumbers = Array.from(selectedSeats).map(seat => seat.textContent);
            if (seatNumbers.length > 0) {
                messageDiv.textContent = `Selected Seats: ${seatNumbers.join(', ')}`;
                qrCodeInput.style.display = 'block';
            } else {
                messageDiv.textContent = '';
                qrCodeInput.style.display = 'none';
            }
        }
    });
</script>

</body>
</html>
