<?php
require('../home/connection.php');

if (isset($_GET['id'])) {
    $empid = $_GET['id'];
    // Retrieve faculty member data based on the $empid
    $faculty = SWIFTSCAN::getFacultyDataById($empid);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Handle the form submission and update faculty attributes
        $facultyData = [
            'empid' => $empid,
            'newFirstName' => $_POST['newFirstName'],
            'newLastName' => $_POST['newLastName'],
            'newdepartment' => $_POST['newdepartment'],
        ];

        SWIFTSCAN::updateFaculty($facultyData);

        // Redirect back to the faculty list page after the update
        header("Location: ../admin/facultyContent.php");
        exit();
    }
}
?>

<!-- HTML Form for Editing Faculty Attributes -->
<form method="POST" action="edit_faculty.php?id=<?= $empid ?>">
    <input type="text" name="newFirstName" value="<?= $faculty['firstname'] ?>">
    <input type="text" name="newLastName" value="<?= $faculty['lastname'] ?>">
    <input type="text" name="newdepartment" value="<?= $faculty['department'] ?>">
    <input type="submit" value="Save Changes">
</form>
