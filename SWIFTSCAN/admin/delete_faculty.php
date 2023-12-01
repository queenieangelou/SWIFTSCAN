<?php
require('../home/connection.php');

if (isset($_GET['id'])) {
    $facultyId = $_GET['id'];
    // Perform the deletion of the faculty member using the $facultyId
    SWIFTSCAN::deleteFaculty($facultyId);
}

// Redirect back to the page displaying the faculty list
header("Location: ../admin/facultyContent.php");
exit();
?>
