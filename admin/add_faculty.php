<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
</head>
<body>
<?php
require('../home/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_faculty'])) {
        $facultyData = [
            'firstname' => $_POST['firstname'],
            'lastname' => $_POST['lastname'],
            'department' => $_POST['department'],
        ];
        SWIFTSCAN::createFaculty($facultyData);

        header("Location: ../admin/facultyContent.php");
        exit();
    }
}

?>

<!-- HTML Form for Adding/Editing Faculty and Student -->
<div class="form">
    <div class="title">
        <p>Updating user data</p>
    </div>
    <form action="" method="post">
        <input type="text" name="firstname" placeholder="First Name" value="">
        <input type="text" name="lastname" placeholder="Last Name" value="">
        <input type="text" name="department" placeholder="Department" value="">
        <input type="submit" value="Add Faculty" name="add_faculty">
    </form>
</div>

<table>
    <thead>
        <tr>
            <th>Faculty ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>    
</table>
</body>
</html>
