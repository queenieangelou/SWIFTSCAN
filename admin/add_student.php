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

// Fetch available years and sections from the respective tables
$yearOptions = SWIFTSCAN::getDepartmentOptions(); // You need to implement this function in your SWIFTSCAN class

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_student'])) {
        $studid = $_POST['studid'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $course = $_POST['course'];
        $selectedDepartment = $_POST['deptname'];


        // Get the yearid and sectionid based on the selected year and section
        $deptid = SWIFTSCAN::getDepartmentId($selectedYear); // You need to implement this function

        // Check if both yearid and sectionid are valid before proceeding
        if ($deptid !== false) {
            // Create an array with the data to be inserted into tblstudentyearsection
            $studentYearSectionData = [
                'studid' => $studid,
                'deptid' => $deptid,
            ];

            // Insert data into tblstudentyearsection
            // Assuming $studentDepartmentData is an associative array with the required data
            SWIFTSCAN::createStudentDepartment($studentDepartmentData);

            // Now you can also create the student in your main table (e.g., tbstudinfo)
            $studentData = [
                'studid' => $studid,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'course' => $course
            ];
            SWIFTSCAN::createStudent($studentData); // You need to implement this function

            header("Location: ../admin/studentContent.php");
            exit();
        } else {
            echo "Error: Invalid year or section selected.";
            // Handle the error appropriately
        }
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

        <!-- Dropdown for Department -->
        <label for="dept">Department:</label>
        <select name="deptname" id="deptname"> <!-- Corrected the name attribute -->
            <?php foreach ($yearOptions as $deptname) : ?>
                <option value="<?php echo $deptname; ?>"><?php echo $deptname; ?></option>
            <?php endforeach; ?>
        </select>


        <input type="submit" value="Add Student" name="add_student">
    </form>
</div>
</body>
</html>