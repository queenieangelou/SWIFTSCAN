<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Facility</title>
    <link rel="stylesheet" type="text/css" href="../CSS/add_edit.css">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=PT+Serif:ital,wght@0,400;0,700;1,400;1,700&family=Poppins:wght@500;600&display=swap" rel="stylesheet">
</head>
<body>
<?php
require('../home/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_facility'])) {
        $facilityData = [
            'facilityid' => $_POST['facilityid'],
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
    <input type="text" name="facilityid" placeholder="Facility ID" value="">
        <input type="text" name="buildingname" placeholder="Building Name" value="">
        <input type="text" name="roomnumber" placeholder="Room Number" value="">
        <input type="submit" value="Add Facility" name="add_facility">
    </form>
</div>
</body>
</html>
