<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Facility</title>
</head>
<body>
<?php
require('../home/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_facility'])) {
        $facilityData = [
            'buildingname' => $_POST['buildingname'],
            'roomnumber' => $_POST['roomnumber'],
        ];
        SWIFTSCAN::createFacility($facilityData);

        header("Location: ../admin/facilityContent.php");
        exit();
    }
}
?>
<!-- HTML Form for Adding Facility -->
<div class="form">
    <div class="title">
        <p>Adding Facility</p>
    </div>
    <form action="" method="post">
        <input type="text" name="buildingname" placeholder="Building Name" value="">
        <input type="text" name="roomnumber" placeholder="Room Number" value="">
        <input type="submit" value="Add Facility" name="add_facility">
    </form>
</div>
</body>
</html>
