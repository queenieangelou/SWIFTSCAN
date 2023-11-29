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

<!-- HTML Form for Editing Student Attributes -->
<form method="POST" action="edit_student.php?id=<?= $studid ?>">
    <label for="newSrCode">Student Code:</label>
    <input type="text" name="newSrCode" value="<?= $student['studid'] ?>" required>

    <label for="newFirstName">First Name:</label>
    <input type="text" name="newFirstName" value="<?= $student['firstname'] ?>" required>

    <label for="newLastName">Last Name:</label>
    <input type="text" name="newLastName" value="<?= $student['lastname'] ?>" required>

    <label for="newcourse">Course:</label>
    <input type="text" name="newcourse" value="<?= $student['course'] ?>" required>

    <label for="newYear">Department:</label>
    <select name="newYear" required>
        <?php foreach ($departmentOptions as $deptname) : ?>
            <option value="<?= $deptname ?>" <?= ($deptname == $student['deptname']) ? 'selected' : '' ?>><?= $deptname ?></option>
        <?php endforeach; ?>
    </select>

    <input type="submit" value="Save Changes">
</form>
