<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" type="text/css" href="../CSS/admin.css">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=PT+Serif:ital,wght@0,400;0,700;1,400;1,700&family=Poppins:wght@500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">


</head>
<body>
  

  <header>
    <a href="admin.php" class="logo"><i class="bx bx-scan"></i><span>SwiftScan</span></a>

    <!-- ... (previous HTML) ... -->
  <ul class="navbar">
  <li><a href="facultyContent.php" class="faculty">Faculty</a></li>
  <li><a href="studentContent.php" class="student">Student</a></li>
  <li><a href="subjectContent.php" class="student">Subject</a></li>
  <li><a href="facilityContent.php" class="student">Facility</a></li>
</ul>
<!-- ... (rest of the HTML) ... -->


    <!-- Add an image for the user icon and a dropdown menu in the .main div -->
    <div class="main">
    <div class="user-dropdown">
        <img src="../pictures/admin.png" alt="Admin Icon" id="user-icon">
        <div class="user-dropdown-content">
            <a href="../home/adminlogin.php">Logout</a>
        </div>
    </div>
    <div class="bx bx-menu" id="menu-icon"></div>
</div>
</header>

<?php require('../home/connection.php'); ?>

<div class="flex-container">
    <!-- Faculty Count Box -->
    <div class="box">
        <p>Total Faculty</p>
        <span id="totalFaculty">
            <?php
            $facultyCount = SWIFTSCAN::getTotalFacultyCount(); // Implement this function
            echo $facultyCount;
            ?>
        </span>
    </div>

    <!-- Student Count Box -->
    <div class="box">
        <p>Total Students</p>
        <span id="totalStudents">
            <?php
            $studentCount = SWIFTSCAN::getTotalStudentCount(); // Implement this function
            echo $studentCount;
            ?>
        </span>
    </div>   
</div>


<script src="../JS/admin.js"></script>
</body>
</html>
