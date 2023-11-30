<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student QR Code Generator</title>
    <link rel="stylesheet" href="../CSS/student.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>

<?php
session_start();
require('../home/connection.php');
$qrCodePath = 'C:\\wamp64\\www\\SWIFTSCAN\\student\\qrimg';
$conn = new PDO("mysql:host=localhost;dbname=db_db", "root", "");  // Adjust the database credentials as needed

function getExistingQRCode($studentId, $conn)
{
    // Check if a QR code for the student already exists
    $selectSql = "SELECT qrcode_img FROM tblstudentqrcode WHERE studid = ?";
    $stmt = $conn->prepare($selectSql);

    if (!$stmt) {
        die("Prepare failed: " . $conn->errorInfo()[2]);
    }

    // Bind parameters
    $stmt->bindValue(1, $studentId);

    // Execute the statement
    $stmt->execute();

    // Fetch the result
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Close the statement
    $stmt->closeCursor();

    if ($row && isset($row['qrcode_img'])) {
        // If a QR code already exists, return its content
        return $row['qrcode_img'];
    }

    // No existing QR code found
    return null;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get student ID from the form
    $studentId = $_POST["studentId"];

    // Validate and sanitize the input if needed

    // Retrieve existing QR code (if any)
    $existingQrCode = getExistingQRCode($studentId, $conn);
}
?>
<div class="container">
        <div class="left-container">
            <form method="post">
                <input type="text" id="studentId" name="studentId" placeholder="SR-Code" required class="form-control"><br>
                <button type="submit" class="btn btn-primary">Get QR Code</button>
            </form>
        </div>
        <div class="right-container">
            <?php
            if (isset($existingQrCode)) {
                echo '<h2 class="mb-3">Existing QR Code</h2>';
                echo '<img src="data:image/png;base64,' . base64_encode($existingQrCode) . '" alt="Existing QR Code" class="img-fluid">';
                echo '<br>';
                echo '<button class="btn btn-success"><a href="download.php?studentId=' . $studentId . '" class="text-white">Download QR Code</a></button>';
            } else {
                echo '<h2>No Existing QR Code Found</h2>';
            }
            ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>