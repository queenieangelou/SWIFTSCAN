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

<div class="form">
    <div class="title">
        <h3>Edit Faculty</h3>
</div>
<!-- HTML Form for Editing Faculty Attributes -->
<form method="POST" action="edit_faculty.php?id=<?= $empid ?>">
    <input type="text" name="newFirstName" placeholder="First Name" value="<?= $faculty['firstname'] ?>">
    <input type="text" name="newLastName" placeholder="Last Name" value="<?= $faculty['lastname'] ?>">
    <input type="text" name="newdepartment" placeholder="Department" value="<?= $faculty['department'] ?>">
    <input type="submit" value="Save Changes">
</form>
</div>
</body>
</html>