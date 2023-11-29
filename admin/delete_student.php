<?php
require('../home/connection.php');

if (isset($_GET['id'])) {
    $studid = $_GET['id'];

    // Delete the student
    SWIFTSCAN::deleteStudent($studid);

    // Delete the associated year and section records
// Assuming $studid is the ID of the student for whom you want to delete the department information
    SWIFTSCAN::deleteStudentDepartment($studid);

}

// Redirect back to the page displaying the student list
header("Location: ../admin/studentContent.php");
exit();
?>
