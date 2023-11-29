<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Recorded</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .success-message {
            color: #008000;
            font-weight: bold;
        }

        .error-message {
            color: #ff0000;
            font-weight: bold;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .input-group button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .input-group button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <div class="container">
    <?php
require('../home/connection.php');

try {
    $conn = SWIFTSCAN::connect();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if the 'text' parameter is set in the POST request
        if (isset($_POST['text'])) {
            $scannedData = $_POST['text'];

            // Parse the scanned data (modify this part based on the structure of your QR code data)
            $data = json_decode($scannedData, true);

            // Insert data into tbattendance table
            $insertSql = "INSERT INTO tbattendance (studid, empid, subjectid, facilityid, timein, timeout) 
                          VALUES (:studid, :empid, :subjectid, :facilityid, NOW(), NOW())";

            $insertStmt = $conn->prepare($insertSql);
            $insertStmt->bindParam(':studid', $data['studid']);
            $insertStmt->bindParam(':empid', $data['empid']);
            $insertStmt->bindParam(':subjectid', $data['subjectid']);
            $insertStmt->bindParam(':facilityid', $data['facilityid']);

            $insertResult = $insertStmt->execute();

            if ($insertResult) {
                echo "Data inserted into tbattendance successfully!";
            } else {
                echo "Error inserting data into tbattendance: " . $insertStmt->errorInfo()[2];
            }
        } else {
            echo "Scanned data not found in the POST request.";
        }
    } else {
        echo "Invalid request method. Use POST method to submit scanned data.";
    }
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}

// Check if the 'scannedData' and 'seatNumber' parameters are set in the POST request
if (isset($_POST['scannedData'], $_POST['seatNumber'])) {
    $scannedData = $_POST['scannedData'];
    $seatNumber = $_POST['seatNumber'];

    // Parse the scanned data (modify this part based on the structure of your QR code data)
    $data = json_decode($scannedData, true);

    // Insert data into tbattendance table
    $insertSql = "INSERT INTO tbattendance (studid, empid, subjectid, facilityid, seatnumber, timein, timeout) 
                  VALUES (:studid, :empid, :subjectid, :facilityid, :seatnumber, NOW(), NOW())";

    $insertStmt = $conn->prepare($insertSql);
    $insertStmt->bindParam(':studid', $data['studid']);
    $insertStmt->bindParam(':empid', $data['empid']);
    $insertStmt->bindParam(':subjectid', $data['subjectid']);
    $insertStmt->bindParam(':facilityid', $data['facilityid']);
    $insertStmt->bindParam(':seatnumber', $seatNumber);

    $insertResult = $insertStmt->execute();

    if ($insertResult) {
        echo "Data inserted into tbattendance successfully!";
    } else {
        echo "Error inserting data into tbattendance: " . $insertStmt->errorInfo()[2];
    }
} else {
    echo "Scanned data or seat number not found in the POST request.";
}

?>

</body>
</html>