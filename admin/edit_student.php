<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Facility</title>
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

if (isset($_GET['id'])) {
    $studid = $_GET['id'];
    // Retrieve student member data based on the $studid
    $student = SWIFTSCAN::getStudentDataById($studid);

    // Fetch available years and sections from the respective tables
    $yearOptions = SWIFTSCAN::getDepartmentOptions(); // You need to implement this function in your SWIFTSCAN class

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Handle the form submission and update student attributes
        $studentData = [
            'studid' => $studid,
            'newSrCode' => $_POST['newSrCode'],
            'newFirstName' => $_POST['newFirstName'],
            'newLastName' => $_POST['newLastName'],
            'newcourse' => $_POST['newcourse'],
            'newDepartment' => $_POST['newDepartment'],
        ];

        // Call the existing updateStudent function
        SWIFTSCAN::updateStudent($studentData);

        // Assuming $studentData is an associative array with the required data
        SWIFTSCAN::updateStudentDepartment($studentData);


        // Redirect back to the student list page after the update
        header("Location: ../admin/studentContent.php");
        exit();
    }
}
?>

<div class="form">
    <div class="title">
    <h3>Edit Student</h3>
</div>
<!-- HTML Form for Editing Student Attributes -->
<form method="POST" action="edit_student.php?id=<?= $studid ?>">
    <input type="text" name="newSrCode" placeholder="Student SR-Code" value="<?= $student['studid'] ?>" required>
    <input type="text" name="newFirstName" placeholder="First Name" value="<?= $student['firstname'] ?>" required>
    <input type="text" name="newLastName" placeholder="Last Name" value="<?= $student['lastname'] ?>" required>
    <input type="text" name="newcourse" placeholder="Course" value="<?= $student['course'] ?>" required>

    <label for="newYear">Department:</label>
    <select name="deptname" id="deptname"> <!-- Corrected the name attribute -->
            <?php foreach ($yearOptions as $deptname) : ?>
                <option value="<?php echo $deptname; ?>"><?php echo $deptname; ?></option>
            <?php endforeach; ?>
        </select>

    <input type="submit" value="Save Changes">
    </form>
</div>
</body>
</html>