<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <title>Sign Up</title>
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
    if (isset($_POST['add_student'])) {
        $studentData = [
            'studid' => $_POST['studid'], // Make sure 'studid' is in your form
            'firstname' => $_POST['firstname'],
            'lastname' => $_POST['lastname'],
            'course' => $_POST['course'],
            // Add any additional student data fields here
        ];

        // Assuming you have a method like createStudent in a class named SWIFTSCAN
        SWIFTSCAN::createStudent($studentData);

        header("Location: ../admin/studentContent.php");
        exit();
    }
}
?>


<div class="form">
    <div class="title">
        <p>Updating user data</p>
    </div>
    <!-- Add Student Form -->
    <form action="" method="post">
        <input type="text" name="studid" placeholder="Student Code" value="">
        <input type="text" name="firstname" placeholder="First Name" value="">
        <input type="text" name="lastname" placeholder="Last Name" value="">
        <input type="text" name="course" placeholder="Course" value="">
        <input type="submit" value="Add Student" name="add_student">
    </form>
</div>
</body>
</html>