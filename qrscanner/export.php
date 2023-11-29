<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_ba3102";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$filename = "AttendanceRecord-" . date('Y-m-d') . ".csv"; // Fix the typo

$query = "SELECT * FROM tb_studinfo";
$result = mysqli_query($conn, $query);

$array = array();

$file = fopen($filename, "w"); // Fix the variable name
$array = array("STUDENT ID", "LAST NAME", "FIRST NAME", "TIME IN");
fputcsv($file, $array);

while ($row = mysqli_fetch_array($result)) {
    $studentId = $row['studid']; // Assuming these are your column names
    $last_name = $row['lastname'];
    $first_name = $row['firstname'];
    $time_in = $row['last_scanned_date'];

    $array = array($studentId, $last_name, $first_name, $time_in);
    fputcsv($file, $array);
}

fclose($file);

header("Content-Description: File Transfer");
header("Content-Disposition: Attachment; filename=$filename"); // Fix the typo
header("Content-type: application/csv");
readfile($filename);
exit();
?>
