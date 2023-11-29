<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student</title>
  <link rel="stylesheet" type="text/css" href="../CSS/admin.css">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=PT+Serif:ital,wght@0,400;0,700;1,400;1,700&family=Poppins:wght@500;600&display=swap" rel="stylesheet">
</head>
<body>
  <header>
    <a href="studentContent.php" class="logo"><i class="bx bx-scan"></i><span>SwiftScan</span></a>

    <ul class="navbar">
      <li><a href="facultyContent.php" class="faculty">Faculty</a></li>
      <li><a href="studentContent.php" class="student">Student</a></li>
      <li><a href="subjectContent.php" class="student">Subject</a></li>
      <li><a href="facilityContent.php" class="student">Facility</a></li>
    </ul>

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

  <div class="tab-pane fade" id="studentContent">
    <h2>Student</h2>

    <!-- Search Container -->
    <div class="search-container">
      <!-- Search Form -->
      <form action="" method="get">
          <input type="text" name="searchInput" id="searchInput" placeholder="Search by Student ID">
          <button type="submit" class="btn btn-primary" name="searchBtn">Search</button>
      </form>
      <!-- Add Student Button (aligned to the right) -->
      <div class="add-student-container">
        <a href="../admin/add_student.php" class="btn btn-primary">Add Student</a>
      </div>
    </div>

    <?php
    require('../home/connection.php');

    // Check if the search form is submitted
    if (isset($_GET['searchBtn'])) {
        $searchInput = $_GET['searchInput'];

        // Call the function to get filtered student list
        $studentData = SWIFTSCAN::getStudentListFiltered($searchInput);
    } else {
        // If the search form is not submitted, get the regular student list
        $studentData = SWIFTSCAN::getStudentList();
    }
    ?>

    <!-- Table Container -->
    <table class="table table-striped">
      <thead>
        <tr>
          <th>SR-Code</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Course</th>
          <th>Department</th>
          <th>Delete</th>
          <th>Edit</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Check if there are search results
        if ($studentData) {
          foreach ($studentData as $student) {
            $studentInfoQuery = "
            SELECT
              tbstuddepartment.studid,
              tbdepartment.deptname
            FROM
              tbstuddepartment
            JOIN
              tbdepartment ON tbstuddepartment.deptid = tbdepartment.deptid
            WHERE
              tbstuddepartment.studid = :studid;";
            
            try {
              // Establish a PDO connection
              $con = SWIFTSCAN::connect();
              
              // Prepare and execute the query
              $statement = $con->prepare($studentInfoQuery);
              $statement->bindParam(':studid', $student['studid']);
              $statement->execute();
              
              // Fetch the result
              $studentInfo = $statement->fetch(PDO::FETCH_ASSOC);

              echo '<tr>';
              echo '<td>' . $student['studid'] . '</td>';
              echo '<td>' . $student['firstname'] . '</td>';
              echo '<td>' . $student['lastname'] . '</td>';
              echo '<td>' . $student['course'] . '</td>';
              
              // Display Year and Section information
              if ($studentInfo && is_array($studentInfo)) {
                  echo '<td>' . $studentInfo['deptname'] . '</td>';
              } else {
                  echo '<td>CICS</td>';
              }
              // End of displaying Year and Section information
              
              echo '<td><a href="delete_student.php?id=' . $student['studid'] . '"><img src="../pictures/trash.svg" alt="Delete" style="width: 20px; height: 20px; color: red;"></a></td>';
              echo '<td><a href="edit_student.php?id=' . $student['studid'] . '"><img src="../pictures/edit.svg" alt="Edit" style="width: 20px; height: 20px; color: green;"></a></td>';
              echo '</tr>';

            } catch (PDOException $error) {
              echo 'Error: ' . $error->getMessage();
            }
          }
        } else {
          echo '<tr><td colspan="8">No results found.</td></tr>';
        }
        ?>
      </tbody>
    </table>
    <script src="../JS/admin.js"></script>
  </div>
</body>
</html>
