generate_qr.php
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Faculty</title>
  <link rel="stylesheet" type="text/css" href="../CSS/qr.css">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=PT+Serif:ital,wght@0,400;0,700;1,400;1,700&family=Poppins:wght@500;600&display=swap" rel="stylesheet">
</head>
<body>
  <header>
    <a href="../admin/generate_qr.php" class="logo"><i class="bx bx-scan"></i><span>SwiftScan</span></a>
    <ul class="navbar">
      <li><a href="../admin/facultyContent.php" class="faculty">Faculty</a></li>
      <li><a href="studentContent.php" class="student">Student</a></li>
      <li><a href="admin/subjectContent.php" class="student">Subject</a></li>
      <li><a href="admin/facilityContent.php" class="student">Facility</a></li>
      <li><a href="../admin/generate_qr.php">Generate</a></li>
    </ul>
    <div class="main">
      <div class="user-dropdown">
        <img src="../pictures/admin.png" alt="User Icon" id="user-icon">
        <div class="user-dropdown-content">
          <a href="../home/adminlogin.php">Logout</a>
        </div>
      </div>
      <div class="bx bx-menu" id="menu-icon"></div>
    </div>
  </header>

<?php
require('../home/connection.php');
$qrCodePath = 'C:\\wamp64\\www\\SWIFTSCAN\\admin\\qrimg';
// Include the QR Code library
require ('C:\wamp64\www\SWIFTSCAN\admin\phpqrcode\qrlib.php');

function generateQRCode($studentId, $qrCodePath, $conn)
{
    // Check if a QR code for this student already exists
    $existingQrCode = getExistingQRCode($studentId, $conn);

    if ($existingQrCode) {
        // If a QR code already exists, return its filename
        return $existingQrCode;
    }

    // Combine student information for QR code content
    $qrCodeContent = "$studentId";

    // Generate QR code image and save it to the qrimg directory
    $qrCodeFile = 'student_' . $studentId . '.png';
    $qrCodeImagePath = $qrCodePath . DIRECTORY_SEPARATOR . $qrCodeFile;
    QRcode::png($qrCodeContent, $qrCodeImagePath);
    $size = 300;

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
$qrCodePath = 'C:\wamp64\www\SWIFTSCAN\admin\qrimg'; 

// Create the directory if it doesn't exist
if (!is_dir($qrCodePath)) {
    mkdir($qrCodePath, 0755, true);
}

// Retrieve student IDs from the database
$sql = "SELECT studid FROM tbstudinfo";
$result = $conn->query($sql);

// Check for query execution errors
if ($result === false) {
    die("Query failed: " . $conn->errorInfo()[2]);
}

// Check if there are rows in the result set
if ($result->rowCount() > 0) {
    // Display QR codes in a table
    echo '<table class="qr-table">';
    echo '<div class="qr-table-container">'; // Add this line
    echo '<tr>';  // Add this line
    $counter = 0;

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $studentId = $row['studid'];
    
        // Generate QR code for the student
        $qrCodeFile = generateQRCode($studentId, $qrCodePath, $conn);
    
        // Display the QR code image and student information in a table cell
        echo '<td>';
        echo '<img src="../admin/qrimg/student_' . $studentId . '.png" alt="QR Code" id="qrCode' . $studentId . '">';
        echo '<div style="margin-top: 10px;">';
        echo '<p>Student ID: ' . $studentId . '</p>';
        echo '</div>';
        echo '</td>';
    
        // Move to the next row after 5 QR codes
        $counter++;
        if ($counter % 5 == 0) {
            echo '</tr><tr>';
        }
    }

    echo '</tr>';  // Add this line
    echo '</table>';
    echo '</div>'; // Add this line
} else {
    echo "No students found in the database.";
}

// Close the database connection
$conn = null;
?>

</body>
</html>