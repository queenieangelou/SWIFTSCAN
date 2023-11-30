<?php
require('../home/connection.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve data from the POST request
    $studentId = $_POST['studentId'];
    $subject = $_POST['subjectFilter'];
    $facility = $_POST['facilityFilter'];
    $faculty = $_POST['facultyFilter'];
    $seat = $_POST['seatSelection'];

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
?>
