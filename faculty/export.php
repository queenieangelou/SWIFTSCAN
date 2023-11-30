<?php
// Include the file containing the SWIFTSCAN class
require('../home/connection.php');  // Adjust the path accordingly

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_db";

// Check if the export button is clicked
if (isset($_GET['exportBtn'])) {
    try {
        // Call the function to get attendance list
        $attendanceData = SWIFTSCAN::getAttendanceList();

        // Create a CSV file
        $filename = "AttendanceRecord-" . date('Y-m-d') . ".csv";
        $file = fopen($filename, "w");
        $array = array("SR-Code", "Student Name", "Employee Name", "Subject", "Facility", "Seat Number", "Time In", "Time Out");
        fputcsv($file, $array);

        foreach ($attendanceData as $attendance) {
            // Modify your queries to include a condition for today's date
            $studentInfoQuery = "SELECT studid, firstname, lastname FROM tbstudinfo WHERE studid = :studid;";
            $employeeInfoQuery = "SELECT firstname, lastname FROM tbempinfo WHERE empid = :empid;";
            $facilityInfoQuery = "SELECT buildingname, roomnumber FROM tbfacility WHERE facilityid = :facilityid;";
            $subjectInfoQuery = "SELECT subjectcode FROM tbsubject WHERE subjectid = :subjectid;";

            // Establish a PDO connection
            $con = SWIFTSCAN::connect();

            // Fetch student information
            $studentStatement = $con->prepare($studentInfoQuery);
            $studentStatement->bindParam(':studid', $attendance['studid']);
            $studentStatement->execute();
            $studentInfo = $studentStatement->fetch(PDO::FETCH_ASSOC);

            // Fetch employee information
            $employeeStatement = $con->prepare($employeeInfoQuery);
            $employeeStatement->bindParam(':empid', $attendance['empid']);
            $employeeStatement->execute();
            $employeeInfo = $employeeStatement->fetch(PDO::FETCH_ASSOC);

            // Fetch facility information
            $facilityStatement = $con->prepare($facilityInfoQuery);
            $facilityStatement->bindParam(':facilityid', $attendance['facilityid']);
            $facilityStatement->execute();
            $facilityInfo = $facilityStatement->fetch(PDO::FETCH_ASSOC);

            // Fetch subject information
            $subjectStatement = $con->prepare($subjectInfoQuery);
            $subjectStatement->bindParam(':subjectid', $attendance['subjectid']);
            $subjectStatement->execute();
            $subjectInfo = $subjectStatement->fetch(PDO::FETCH_ASSOC);

            // Check if the attendance is for today's date
            $todayDate = date('Y-m-d');
            $attendanceDate = date('Y-m-d', strtotime($attendance['timein']));

            if ($todayDate == $attendanceDate) {
                $array = array(
                    (isset($attendance['studid']) ? $attendance['studid'] : ''),
                    (isset($studentInfo['firstname']) ? $studentInfo['firstname'] : '') . ' ' . (isset($studentInfo['lastname']) ? $studentInfo['lastname'] : ''),
                    (isset($employeeInfo['firstname']) ? $employeeInfo['firstname'] : '') . ' ' . (isset($employeeInfo['lastname']) ? $employeeInfo['lastname'] : ''),
                    (isset($subjectInfo['subjectcode']) ? $subjectInfo['subjectcode'] : ''),
                    (isset($facilityInfo['buildingname']) ? $facilityInfo['buildingname'] : '') . ' ' . (isset($facilityInfo['roomnumber']) ? $facilityInfo['roomnumber'] : ''),
                    (isset($attendance['seatnumber']) ? $attendance['seatnumber'] : ''),
                    (isset($attendance['timein']) ? $attendance['timein'] : ''),
                    (isset($attendance['timeout']) ? $attendance['timeout'] : '')
                );
                fputcsv($file, $array);
            }
        }

        fclose($file);

        // Force download the CSV file
        header("Content-Description: File Transfer");
        header("Content-Disposition: Attachment; filename=$filename");
        header("Content-type: application/csv");
        readfile($filename);

        // Remove the file after download
        unlink($filename);

        exit();
    } catch (PDOException $error) {
        echo 'Error: ' . $error->getMessage();
    }
}
?>
