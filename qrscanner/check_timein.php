<?php
// check_timein.php

require('../home/connection.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve data from the POST request
    $studentId = $_POST['studentId'];
    $seat = $_POST['seatSelection'];

    // Get the PDO connection
    $conn = SWIFTSCAN::connect();

    // Check if the student has already timed in
    $timeinStatus = checkTimeinStatus($conn, $studentId);

    // Check if the seat is already taken
    $seatStatus = checkSeatStatus($conn, $seat);

    // Close the connection
    $conn = null;

    // Return the timein and seat status as JSON
    echo json_encode(['timeinStatus' => $timeinStatus, 'seatStatus' => $seatStatus]);
} else {
    // Invalid request
    echo json_encode(['error' => 'Invalid request']);
}

function checkTimeinStatus($conn, $studentId) {
    $query = "SELECT timein FROM tbattendance WHERE studid = ? AND timeout IS NULL";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        try {
            $stmt->bindParam(1, $studentId);
            $stmt->execute();
            $timein = null;
            $stmt->bindColumn('timein', $timein);
            $stmt->fetch();
            $stmt->closeCursor();

            return ($timein !== null) ? 'already_timed_in' : 'not_timed_in';
        } catch (PDOException $e) {
            return 'error: ' . $e->getMessage();
        }
    } else {
        return 'error: Failed to prepare SQL statement';
    }
}

function checkSeatStatus($conn, $seat) {
    $query = "SELECT attendanceid FROM tbattendance WHERE seatnumber = ? AND timeout IS NULL";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        try {
            $stmt->bindParam(1, $seat);
            $stmt->execute();
            $attendanceId = null;
            $stmt->bindColumn('attendanceid', $attendanceId);
            $stmt->fetch();
            $stmt->closeCursor();

            return ($attendanceId !== null) ? 'already_taken' : 'available';
        } catch (PDOException $e) {
            return 'error: ' . $e->getMessage();
        }
    } else {
        return 'error: Failed to prepare SQL statement';
    }
}
?>