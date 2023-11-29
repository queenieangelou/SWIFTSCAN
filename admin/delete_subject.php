<?php
require('../home/connection.php');

if (isset($_GET['id'])) {
    $subjectid = $_GET['id'];
    // Perform the deletion of the faculty member using the $facultyId
    SWIFTSCAN::deletesubject($subjectid);
}

// Redirect back to the page displaying the faculty list
header("Location: ../faculty/subjectContent.php");
exit();
?>
