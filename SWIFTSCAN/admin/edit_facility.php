
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

if (isset($_GET['id'])) {
    $facilityid = $_GET['id'];
    // Retrieve facility data based on the $facilityid
    $facility = SWIFTSCAN::getFacilityDataByID($facilityid);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Handle the form submission and update facility attributes
        $facilityData = [
            'facilityid' => $facilityid,  // Assuming 'facilityid' is coming from your form
            'buildingname' => $_POST['buildingname'],
            'roomnumber' => $_POST['roomnumber'],
        ];

        SWIFTSCAN::updateFacility($facilityData);

        // Redirect back to the facility list page after the update
        header("Location: ../admin/facilityContent.php");
        exit();
    }
}
?>

<div class="form">
    <div class="title">
        <h3>Edit Facility</h3>
</div>
<form method="POST" action="edit_facility.php?id=<?= $facilityid ?>">
    <input type="text" name="facilityid" placeholder="Facility ID" value="<?= $facility['facilityid'] ?>">
    <input type="text" name="buildingname" placeholder="Building Name" value="<?= $facility['buildingname'] ?>">
    <input type="text" name="roomnumber" placeholder="Room Number" value="<?= $facility['roomnumber'] ?>">
    <input type="submit" value="Save Changes">
</form>
</div>
</body>
</html>