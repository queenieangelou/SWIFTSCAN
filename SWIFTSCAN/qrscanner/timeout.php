<?php
require('../home/connection.php');

// Get the student ID from the AJAX request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $studid = isset($_POST['studid']) ? $_POST['studid'] : null;

    if ($studid !== null) {
        try {
            $conn = SWIFTSCAN::connect();
            
            // Get timein and timeout for the student
            $timeinout = getTimeinoutForStudent($conn, $studid);

            if ($timeinout === null) {
                // Timein is null, indicate that time-in needs to be performed first
                echo "Error: Time-in needs to be performed first for studid: $studid";
            } else {
                $timein = $timeinout['timein'];
                $timeout = $timeinout['timeout'];

                if ($timeout === null) {
                    // Timeout is null, update the timeout for that studid
                    $timeout = date('Y-m-d H:i:s');
                    $updateTimeoutQuery = "UPDATE tbattendance SET timeout = :timeout WHERE studid = :studid";
                    $updateTimeoutStmt = $conn->prepare($updateTimeoutQuery);
                    $updateTimeoutStmt->bindParam(':timeout', $timeout, PDO::PARAM_STR);
                    $updateTimeoutStmt->bindParam(':studid', $studid, PDO::PARAM_STR);

                    if ($updateTimeoutStmt->execute()) {
                        echo "Timeout updated successfully for studid: $studid";
                    } else {
                        echo "Error updating timeout: " . $updateTimeoutStmt->errorInfo()[2];
                    }
                } else {
                    // Timeout is not null, indicate that timeout has already been set
                    echo "$studid You have already timed out. Please time in first";
                }
            }

            // Close the connection
            $conn = null;
        } catch (PDOException $error) {
            echo "Error connecting to the database: " . $error->getMessage();
        }
    } else {
        echo "Error: Missing studid in POST data";
    }
}


function getTimeinoutForStudent($conn, $studid) {
    try {
        $query = "SELECT timein, timeout FROM tbattendance WHERE studid = ?";
        $stmt = $conn->prepare($query);

        if ($stmt) {
            $stmt->bindParam(1, $studid);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();

            return $result; // Associative array with 'timein' and 'timeout' keys
        } else {
            return null; // or handle the error as needed
        }
    } catch (PDOException $e) {
        return null; // or handle the error as needed
    }
}
?>


