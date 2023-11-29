<?php
require('../home/connection.php');

if (isset($_GET['id'])) {
    $subjectid = $_GET['id'];
    // Retrieve subject data based on the $subjectid
    $subject = SWIFTSCAN::getSubjectDataById($subjectid);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Handle the form submission and update subject attributes
        $subjectData = [
            'subjectid' => $subjectid,
            'newSubjectCode' => $_POST['newSubjectCode'],
            'newSubjectName' => $_POST['newSubjectName'],
        ];

        SWIFTSCAN::updateSubject($subjectData);

        // Redirect back to the subject list page after the update
        header("Location: ../faculty/subjectContent.php");
        exit();
    }
}
?>

<!-- HTML Form for Editing Subject Attributes -->
<form method="POST" action="edit_subject.php?id=<?= $subjectid ?>">
    <input type="text" name="newSubjectCode" value="<?= $subject['subjectcode'] ?>">
    <input type="text" name="newSubjectName" value="<?= $subject['subjectname'] ?>">
    <input type="submit" value="Save Changes">
</form>
