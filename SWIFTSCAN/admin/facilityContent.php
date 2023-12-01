<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Facility</title>
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
    <a href="facilityContent.php" class="logo"><i class="bx bx-scan"></i><span>SwiftScan</span></a>

    <!-- ... (previous HTML) ... -->
  <ul class="navbar">
  <li><a href="facultyContent.php" class="faculty">Faculty</a></li>
  <li><a href="studentContent.php" class="student">Student</a></li>
  <li><a href="subjectContent.php" class="student">Subject</a></li>
  <li><a href="facilityContent.php" class="student">Facility</a></li>
  <li><a href="../admin/generate_qr.php">Generate</a></li>
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

  <div class="tab-pane fade" id="facilityContent">
    <h2>Facility</h2>

    <!-- Search Container -->
    <div class="search-container">
        <!-- Search Form -->
        <form action="" method="get">
            <input type="text" name="searchInput" id="searchInput" placeholder="Search by Facility ID">
            <button type="submit" class="btn btn-primary" name="searchBtn">Search</button>
        </form>
        <!-- Add Student Button (aligned to the right) -->
      <div class="add-student-container">
        <a href="../admin/add_facility.php" class="btn btn-primary">Add Facility</a>
      </div>
    </div>

    <?php
        require('../home/connection.php');

        // Check if the search form is submitted
        if (isset($_GET['searchBtn'])) {
            $searchInput = $_GET['searchInput'];

            // Call the function to get filtered facility list
            $facilityData = SWIFTSCAN::getFacilityListFiltered($searchInput);
        } else {
            // If the search form is not submitted, get the regular facility list
            $facilityData = SWIFTSCAN::getFacilityList();
        }
    ?>

    <!-- Table Container -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Facility ID</th>
                <th>Building Name</th>
                <th>Room Number</th>
                <th>Delete</th>
                <th>Edit</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Check if there are search results
        if ($facilityData) {
            // Loop through the facility data and display the table rows
            foreach ($facilityData as $facility) {
                echo '<tr>';
                echo '<td>' . $facility['facilityid'] . '</td>';
                echo '<td>' . $facility['buildingname'] . '</td>';
                echo '<td>' . $facility['roomnumber'] . '</td>';
                echo '<td><a href="delete_facility.php?id=' . $facility['facilityid'] . '"><img src="../pictures/trash.svg" alt="Delete" style="width: 20px; height: 20px; color: red;"></a></td>';
                echo '<td><a href="edit_facility.php?id=' . $facility['facilityid'] . '"><img src="../pictures/edit.svg" alt="Edit" style="width: 20px; height: 20px; color: blue;"></a></td>';
                echo '</tr>';
            }
        } else {
            // Display a message if no results are found
            echo '<tr><td colspan="5">No results found.</td></tr>';
        }
        ?>
        </tbody>
    </table>
  <!-- Include your JS script -->
  <script src="../JS/admin.js"></script>
</body>
</html>
