<?php
require('../home/connection.php');
// Include the QR Code library
require 'C:\wamp64\www\CRUD\qrscanner\phpqrcode\qrlib.php';

function generateQRCode($studentId, $firstname, $lastname, $qrCodePath, $conn)
{
    // Check if a QR code for this student already exists
    $existingQrCode = getExistingQRCode($studentId, $conn);

    if ($existingQrCode) {
        // If a QR code already exists, return its filename
        return $existingQrCode;
    }

    // Combine student information for QR code content
    $qrCodeContent = "$studentId, $firstname, $lastname";

    // Generate QR code image and save it to the qrimg directory
    $qrCodeFile = 'student_' . $studentId . '.png';
    $qrCodeImagePath = $qrCodePath . DIRECTORY_SEPARATOR . $qrCodeFile;
    QRcode::png($qrCodeContent, $qrCodeImagePath);

    // Insert data into tblstudentqrcode table using prepared statement
    $insertSql = "INSERT INTO tblstudentqrcode (studid, qrcode_img) VALUES (?, ?)";
    $stmt = $conn->prepare($insertSql);

    if (!$stmt) {
        die("Prepare failed: " . $conn->errorInfo()[2]);
    }

    // Bind parameters
    $stmt->bindValue(1, $studentId);
    
    // Get the contents of the QR code image
    $blobData = file_get_contents($qrCodeImagePath);
    
    // Bind parameters
    $stmt->bindValue(2, $blobData, PDO::PARAM_LOB);

    // Execute the statement
    $stmt->execute();

    // Close the statement
    $stmt->closeCursor();

    return $qrCodeFile;
}

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

// Database connection
$swiftscan = new SWIFTSCAN();
$conn = $swiftscan->connect();

// Path to store generated QR codes
$qrCodePath = 'C:\wamp64\www\CRUD\qrscanner\qrimg';

// Create the directory if it doesn't exist
if (!is_dir($qrCodePath)) {
    mkdir($qrCodePath, 0755, true);
}

// Retrieve student information from the database
$sql = "SELECT tbstudinfo.*, tblyear.year, tbsection.section FROM tbstudinfo
        JOIN tblstudentyearsection ON tbstudinfo.studid = tblstudentyearsection.studid
        JOIN tblyear ON tblstudentyearsection.yearid = tblyear.yearid
        JOIN tbsection ON tblstudentyearsection.sectionid = tbsection.sectionid";

$result = $conn->query($sql);

// Check for query execution errors
if ($result === false) {
    die("Query failed: " . $conn->errorInfo()[2]);
}

// Check if there are rows in the result set
if ($result->rowCount() > 0) {
    // Display QR codes and student information in a table
    echo '<style>';
    echo 'table { width: 100%; }';
    echo 'td { text-align: center; padding: 20px; }';
    echo 'img { max-width: 100%; height: auto; }';
    echo '</style>';

    echo '<table>';
    echo '<tr>';  // Add this line
    $counter = 0;

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $studentId = $row['studid'];

        // Generate QR code for the student
        $qrCodeFile = generateQRCode($studentId, $row['firstname'], $row['lastname'], $qrCodePath, $conn);

        // Display the QR code image and student information in a table cell
        echo '<td>';
        // Encode binary data as Base64
        $qrCodeImagePath = $qrCodePath . DIRECTORY_SEPARATOR . $qrCodeFile;
        if (file_exists($qrCodeImagePath)) {
            $base64Data = base64_encode(file_get_contents($qrCodeImagePath));
            // Generate the data URI
            $dataUri = 'data:image/png;base64,' . $base64Data;
            // Display the QR code image using the data URI
            echo '<img src="' . $dataUri . '" alt="QR Code" id="qrCode' . $studentId . '">';
        } else {
            // Handle the case where the file does not exist
            echo "Error: QR code image not found for student ID $studentId.";
        }

        echo '<div style="margin-top: 10px;">';
        echo '<p>' . $row['firstname'] . ' ' . $row['lastname'] . '</p>';
        echo '<p>' . $row['course'] . '</p>';
        echo '<p>' . $row['year'] . ' - ' . $row['section'] . '</p>';
        echo '</div>';
        echo '</td>';

        // Move to the next row after 8 QR codes
        $counter++;
        if ($counter % 8 == 0) {
            echo '</tr><tr>';
        }
    }

    echo '</tr>';  // Add this line
    echo '</table>';
} else {
    echo "No students found in the database.";
}

// Close the database connection
$conn = null;
?>
