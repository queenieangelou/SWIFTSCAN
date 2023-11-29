<?php
require('../home/connection.php');

if (isset($_GET['id'])) {
    $facilityid = $_GET['id'];
    // Retrieve facility data based on the $facilityid
    $facility = SWIFTSCAN::getFacilityDataByID($facilityid);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Handle the form submission and update facility attributes
        $facilityData = [
            'facilityid' => $facilityid,
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

<!-- HTML Form for Editing Facility Attributes -->
<form method="POST" action="edit_facility.php?id=<?= $facilityid ?>">
    <input type="text" name="buildingname" value="<?= $facility['buildingname'] ?>">
    <input type="text" name="roomnumber" value="<?= $facility['roomnumber'] ?>">
    <input type="submit" value="Save Changes">
</form>
