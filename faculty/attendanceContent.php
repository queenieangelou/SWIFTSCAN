<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" type="text/css" href="../CSS/faculty.css">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
  <link rel="stylesheet"
  href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=PT+Serif:ital,wght@0,400;0,700;1,400;1,700&family=Poppins:wght@500;600&display=swap" rel="stylesheet">

</head>
<body>
  

  <header>
    <a href="faculty.php" class="logo"><i class="bx bx-scan"></i><span>SwiftScan</span></a>

    <!-- ... (previous HTML) ... -->
  <ul class="navbar">
  <li><a href="attendanceContent.php" class="attendance">Attendance</a></li>
  <li><a href="subjectContent.php" class="subject">Subject</a></li>
  <li><a href="facilityContent.php" class="facilty">Facility</a></li>
</ul>
<!-- ... (rest of the HTML) ... -->


    <!-- Add an image for the user icon and a dropdown menu in the .main div -->
    <div class="main">
        <div class="user-dropdown">
            <img src="../pictures/2x2.jpg" alt="User Icon" id="user-icon">
            <div class="user-dropdown-content">
                <a href="#">Edit Profile</a>
                <a href="../home/facultylogin.php">Logout</a>
            </div>
        </div>
        <div class="bx bx-menu" id="menu-icon"></div>
    </div>
</header>

<!-- Add the following code inside the body tag, after the Subject Tab content -->

<div class="tab-pane fade" id="attendanceContent">
    <h2>Attendance Tab</h2>


    
</div>

    <script src="../JS/admin.js"></script>
</body>
</html>