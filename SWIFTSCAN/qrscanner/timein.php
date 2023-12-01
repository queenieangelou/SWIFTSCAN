<?php
require('../home/connection.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve data from the POST request
    $studentId = $_POST['studentId'];
    $subject = $_POST['subjectFilter'];
    $facility = $_POST['facilityFilter'];
    $faculty = $_POST['facultyFilter'];
    $seat = $_POST['seatSelection'];

    // Check if the seat is already taken in a different facility
    $seatStatus = checkSeatStatusInDifferentFacility($facility, $seat);

    if ($seatStatus === 'already_taken_in_different_facility') {
        // Student can proceed to time in even if the seat is already taken in a different facility
        echo "Seat is already taken in a different facility, but proceeding with time in.";
    }

    // Save the data to tbattendance
    $timeIn = date('Y-m-d H:i:s');

    // Get the PDO connection
    $conn = SWIFTSCAN::connect();

    $query = "INSERT INTO tbattendance (studid, empid, subjectid, facilityid, seatnumber, timein) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bindParam(1, $studentId);
        $stmt->bindParam(2, $faculty); // Use faculty directly as empid
        $stmt->bindParam(3, $subject);
        $stmt->bindParam(4, $facility);
        $stmt->bindParam(5, $seat);
        $stmt->bindParam(6, $timeIn);

        if ($stmt->execute()) {
            echo "Data saved successfully!";
            // You can include additional logic here if needed
        } else {
            echo "Error saving data: " . $stmt->errorInfo()[2];
        }

        $stmt->closeCursor(); // Release the cursor so the connection can be used again
    } else {
        echo "Error in preparing SQL statement: " . $conn->errorInfo()[2];
    }

    // Close the connection
    $conn = null;
} else {
    echo "Invalid request!";
}

function checkSeatStatusInDifferentFacility($currentFacility, $seat) {
    // Get the PDO connection
    $conn = SWIFTSCAN::connect();

    $query = "SELECT COUNT(*) FROM tbattendance WHERE facilityid != ? AND seatnumber = ? AND timeout IS NULL";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        try {
            $stmt->bindParam(1, $currentFacility);
            $stmt->bindParam(2, $seat);
            $stmt->execute();
            $count = $stmt->fetchColumn();
            $stmt->closeCursor();

            return ($count > 0) ? 'already_taken_in_different_facility' : 'available';
        } catch (PDOException $e) {
            return 'error: ' . $e->getMessage();
        }
    } else {
        return 'error: Failed to prepare SQL statement';
    }
}
?>
