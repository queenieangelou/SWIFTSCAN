<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
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
        $selectedYear = $_POST['year'];
        $selectedSection = $_POST['section'];

        // Get the yearid and sectionid based on the selected year and section
        $yearid = SWIFTSCAN::getDepartmentId($selectedYear); // You need to implement this function

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

        <!-- Dropdown for Year -->
        <label for="dept">Department:</label>
        <select name="dept" id="dept">
            <?php foreach ($departmentOptions as $deptname) : ?>
                <option value="<?php echo $deptname; ?>"><?php echo $deptname; ?></option>
            <?php endforeach; ?>
        </select>

        <input type="submit" value="Add Student" name="add_student">
    </form>
</div>



</div>

<table>
    <thead>
        <tr>
            <th>Srcode</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Year and Section</th>
            <th>Course</th>
        </tr>
    </thead>    
</table>
</body>
</html>
