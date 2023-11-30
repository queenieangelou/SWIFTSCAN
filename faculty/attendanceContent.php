<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance</title>
    <link rel="stylesheet" type="text/css" href="../CSS/attendance.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=PT+Serif:ital,wght@0,400;0,700;1,400;1,700&family=Poppins:wght@500;600&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <a href="../faculty/attendanceContent.php" class="logo"><i class="bx bx-scan"></i><span>SwiftScan</span></a>
        <ul class="navbar">
            <li><a href="../faculty/attendanceContent.php" class="attendance">Attendance</a></li>
        </ul>
        <div class="main">
            <div class="user-dropdown">
                <img src="../pictures/admin.png" alt="User Icon" id="user-icon">
                <div class="user-dropdown-content">
                    <a href="../home/facultyLogin.php">Logout</a>
                </div>
            </div>
            <div class="bx bx-menu" id="menu-icon"></div>
        </div>
    </header>

    <div class="container">
        <div class="tab-pane fade" id="attendanceContent">
            <h2>Attendance</h2>
    
  
        <!-- Export Form -->
    <div class="add-student-container">
    <form method="get" action="export.php">
                    <button type="submit" class="btn btn-primary" name="exportBtn">Export to Excel</button>
                </form>
    </div>
            

            <?php
            require('../home/connection.php');

            // Check if the search form is submitted
            if (isset($_GET['searchBtn'])) {
                $searchInput = $_GET['searchInput'];

                // Call the function to get filtered attendance list
                $attendanceData = SWIFTSCAN::getAttendanceListFiltered($searchInput);
            } else {
                // If the search form is not submitted, get the regular attendance list
                $attendanceData = SWIFTSCAN::getAttendanceList();
            }
            ?>

            <!-- Table Container -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>SR-Code</th>
                        <th>Student Name</th>
                        <th>Employee Name</th>
                        <th>Subject</th>
                        <th>Facility</th>
                        <th>Seat Number</th>
                        <th>Time In</th>
                        <th>Time Out</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Check if there are search results
                    if (!empty($attendanceData)) {
                        foreach ($attendanceData as $attendance) {
                            // Modify your queries to include a condition for today's date
                            $studentInfoQuery = "SELECT studid, firstname, lastname FROM tbstudinfo WHERE studid = :studid;";
                            $employeeInfoQuery = "SELECT firstname, lastname FROM tbempinfo WHERE empid = :empid;";
                            $facilityInfoQuery = "SELECT buildingname, roomnumber FROM tbfacility WHERE facilityid = :facilityid;";
                            $subjectInfoQuery = "SELECT subjectcode FROM tbsubject WHERE subjectid = :subjectid;";

                            try {
                                // Establish a PDO connection
                                $con = SWIFTSCAN::connect();

                                // Fetch student information
                                $studentStatement = $con->prepare($studentInfoQuery);
                                $studentStatement->bindParam(':studid', $attendance['studid']);
                                $studentStatement->execute();
                                $studentInfo = $studentStatement->fetch(PDO::FETCH_ASSOC);

                                // Fetch employee information
                                $employeeStatement = $con->prepare($employeeInfoQuery);
                                $employeeStatement->bindParam(':empid', $attendance['empid']);
                                $employeeStatement->execute();
                                $employeeInfo = $employeeStatement->fetch(PDO::FETCH_ASSOC);

                                // Fetch facility information
                                $facilityStatement = $con->prepare($facilityInfoQuery);
                                $facilityStatement->bindParam(':facilityid', $attendance['facilityid']);
                                $facilityStatement->execute();
                                $facilityInfo = $facilityStatement->fetch(PDO::FETCH_ASSOC);

                                // Fetch subject information
                                $subjectStatement = $con->prepare($subjectInfoQuery);
                                $subjectStatement->bindParam(':subjectid', $attendance['subjectid']);
                                $subjectStatement->execute();
                                $subjectInfo = $subjectStatement->fetch(PDO::FETCH_ASSOC);

                                // Check if the attendance is for today's date
                                $todayDate = date('Y-m-d');
                                $attendanceDate = date('Y-m-d', strtotime($attendance['timein']));

                                if ($todayDate == $attendanceDate) {
                                    echo '<tr>';
                                    echo '<td>' . (isset($attendance['studid']) ? $attendance['studid'] : '') . '</td>';
                                    echo '<td>' . (isset($studentInfo['firstname']) ? $studentInfo['firstname'] : '') . ' ' . (isset($studentInfo['lastname']) ? $studentInfo['lastname'] : '') . '</td>';
                                    echo '<td>' . (isset($employeeInfo['firstname']) ? $employeeInfo['firstname'] : '') . ' ' . (isset($employeeInfo['lastname']) ? $employeeInfo['lastname'] : '') . '</td>';
                                    echo '<td>' . (isset($subjectInfo['subjectcode']) ? $subjectInfo['subjectcode'] : '') . '</td>';
                                    echo '<td>' . (isset($facilityInfo['buildingname']) ? $facilityInfo['buildingname'] : '') . ' ' . (isset($facilityInfo['roomnumber']) ? $facilityInfo['roomnumber'] : '') . '</td>';
                                    echo '<td>' . (isset($attendance['seatnumber']) ? $attendance['seatnumber'] : '') . '</td>';
                                    echo '<td>' . (isset($attendance['timein']) ? $attendance['timein'] : '') . '</td>';
                                    echo '<td>' . (isset($attendance['timeout']) ? $attendance['timeout'] : '') . '</td>';
                                    echo '</tr>';
                                }
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
</body>
</html>
