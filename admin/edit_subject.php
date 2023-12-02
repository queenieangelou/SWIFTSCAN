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
        header("Location: ../admin/subjectContent.php");
        exit();
    }
}
?>

<div class="form">
    <div class="title">
        <h3>Edit Subject</h3>
</div>
<!-- HTML Form for Editing Subject Attributes -->
<form method="POST" action="edit_subject.php?id=<?= $subjectid ?>">
    <input type="text" name="newSubjectCode" value="<?= $subject['subjectcode'] ?>">
    <input type="text" name="newSubjectName" value="<?= $subject['subjectname'] ?>">
    <input type="submit" value="Save Changes">
</form>
</div>
</body>
</html>