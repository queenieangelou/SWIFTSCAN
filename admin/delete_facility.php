<?php
require('../home/connection.php');

if (isset($_GET['id'])) {
    $facilityid = $_GET['id'];
    // Perform the deletion of the faculty member using the $facultyId
    SWIFTSCAN::deleteFacility($facilityid);
}

// Redirect back to the page displaying the faculty list
header("Location: ../admin/facilityContent.php");
exit();
?>
