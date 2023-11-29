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
  <li><a href="facultyContent.php" class="faculty">Faculty</a></li>
  <li><a href="studentContent.php" class="student">Student</a></li>
  <li><a href="subjectContent.php" class="student">Subject</a></li>
  <li><a href="facilityContent.php" class="student">Facility</a></li>
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

 <div class="tab-pane fade" id="subjectContent">
            <h2>Subject Tab</h2>
            
                    <!-- Search Container -->
                    <div class="search-container">
                        <!-- Search Form -->
                        <form action="" method="get">
                            <input type="text" name="searchInput" id="searchInput" placeholder="Search by Subject ID">
                            <button type="submit" class="btn btn-primary" name="searchBtn">Search</button>
                        </form>
                    </div>
                    <?php
require('../home/connection.php');

// Check if the search form is submitted
if (isset($_GET['searchBtn'])) {
    $searchInput = $_GET['searchInput'];

    // Call the function to get filtered subject list
    $subjectData = SWIFTSCAN::getSubjectListFiltered($searchInput);
} else {
    // If the search form is not submitted, get the regular subject list
    $subjectData = SWIFTSCAN::getSubjectList();
}
?>

<!-- Table Container -->
<table class="table table-striped">
    <thead>
        <tr>
            <th>Subject ID</th>
            <th>Subject Code</th>
            <th>Subject Name</th>
            <th>Delete</th>
            <th>Edit</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Loop through the subject data and display the table rows
        foreach ($subjectData as $subject) {
            echo '<tr>';
            echo '<td>' . $subject['subjectid'] . '</td>';
            echo '<td>' . $subject['subjectcode'] . '</td>';
            echo '<td>' . $subject['subjectname'] . '</td>';
            echo '<td><a href="delete_subject.php?id=' . $subject['subjectid'] . '"><img src="../trash.svg" alt="Delete" style="width: 20px; height: 20px; color: red;"></a></td>';
            echo '<td><a href="edit_subject.php?id=' . $subject['subjectid'] . '"><img src="../edit.svg" alt="Edit" style="width: 20px; height: 20px; color: blue;"></a></td>';
            echo '</tr>';
        }
        ?>
    </tbody>
</table>



            <!-- Add Student Button -->
            <a href="add_subject.php" class="btn btn-primary">Add Subject</a>
    </div>
    <script src="../JS/admin.js"></script>
</body>
</html>