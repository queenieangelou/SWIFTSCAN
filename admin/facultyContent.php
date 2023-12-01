<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Faculty</title>
  <link rel="stylesheet" type="text/css" href="../CSS/admin.css">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
  <link rel="stylesheet"
  href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=PT+Serif:ital,wght@0,400;0,700;1,400;1,700&family=Poppins:wght@500;600&display=swap" rel="stylesheet">

</head>
<body>
  

  <header>
    <a href="facultyContent.php" class="logo"><i class="bx bx-scan"></i><span>SwiftScan</span></a>

    <!-- ... (previous HTML) ... -->
  <ul class="navbar">
  <li><a href="facultyContent.php" class="faculty">Faculty</a></li>
  <li><a href="studentContent.php" class="student">Student</a></li>
  <li><a href="subjectContent.php" class="student">Subject</a></li>
  <li><a href="facilityContent.php" class="student">Facility</a></li>
  <li><a href="../student/generate_qr.php">Generate</a></li>
</ul>
<!-- ... (rest of the HTML) ... -->


    <!-- Add an image for the user icon and a dropdown menu in the .main div -->
    <div class="main">
        <div class="user-dropdown">
            <img src="../pictures/admin.png" alt="User Icon" id="user-icon">
            <div class="user-dropdown-content">
                <a href="../home/adminlogin.php">Logout</a>
            </div>
        </div>
        <div class="bx bx-menu" id="menu-icon"></div>
    </div>
</header>

<div class="tab-pane fade" id="facultyContent">
        <h2>Faculty</h2>
        
        <!-- Search Container -->
<div class="search-container">
    <!-- Search Form -->
    <form action="" method="get">
        <input type="text" name="searchInput" id="searchInput" placeholder="Search by Employee ID">
        <button type="submit" class="btn btn-primary" name="searchBtn">Search</button>
    </form>
    <div class="add-student-container">
        <a href="../admin/add_faculty.php" class="btn btn-primary">Add Faculty</a>
      </div>
    </div>


<?php
require('../home/connection.php');

// Check if the search form is submitted
if (isset($_GET['searchBtn'])) {
    $searchInput = $_GET['searchInput'];

    // Call the function to get filtered faculty list
    $facultyData = SWIFTSCAN::getFacultyListFiltered($searchInput);
} else {
    // If the search form is not submitted, get the regular faculty list
    $facultyData = SWIFTSCAN::getFacultyList();
}
?>

<!-- Table Container -->
<table class="table table-striped">
    <thead>
        <tr>
            <th>Employee ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Department</th>
            <th>Delete</th>
            <th>Edit</th> 
        </tr>
    </thead>
    <tbody>
        <?php
        // Check if there are search results
        if ($facultyData) {
            foreach ($facultyData as $faculty) {
                echo '<tr>';
                echo '<td>' . $faculty['empid'] . '</td>';
                echo '<td>' . $faculty['firstname'] . '</td>';
                echo '<td>' . $faculty['lastname'] . '</td>';
                echo '<td>' . $faculty['department'] . '</td>';
                echo '<td><a href="delete_faculty.php?id=' . $faculty['empid'] . '"><img src="../pictures/trash.svg" alt="Delete" style="width: 20px; height: 20px; color: red;"></a></td>';
                echo '<td><a href="edit_faculty.php?id=' . $faculty['empid'] . '"><img src="../pictures/edit.svg" alt="Edit" style="width: 20px; height: 20px; color: blue;"></a></td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="7">No results found.</td></tr>';
        }
        ?>
    </tbody>
</table>
<script src="../JS/admin.js"></script>
</body>
</html>
