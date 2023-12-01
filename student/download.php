<?php
// Include the file that defines the $conn variable
require('../home/connection.php');
$conn = new PDO("mysql:host=localhost;dbname=db_db", "root", "");

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

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["studentId"])) {
    $studentId = $_GET["studentId"];

    // Retrieve existing QR code (if any)
    $existingQrCode = getExistingQRCode($studentId, $conn);

    if ($existingQrCode) {
        // Set the appropriate headers for download
        header("Content-Description: File Transfer");
        header('Content-Type: image/png');
        header('Content-Disposition: attachment; filename="qr_code_' . $studentId . '.png"');

        // Output the PNG image content
        ob_clean();
        flush();
        echo $existingQrCode;

        exit;
    }
}

// If no valid request, redirect to the main page
header('Location: student.php');
exit;
?>
