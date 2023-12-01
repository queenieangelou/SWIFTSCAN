<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Subject</title>
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_subject'])) {
        $subjectData = [
            'subjectcode' => $_POST['subjectcode'],
            'subjectname' => $_POST['subjectname'],
        ];
        SWIFTSCAN::createSubject($subjectData);

        header("Location: ../admin/subjectContent.php");
        exit();
    }
}
?>

<!-- HTML Form for Adding Subject -->
<div class="form">
    <div class="title">
        <p>Add a New Subject</p>
    </div>
    <form action="" method="post">
        <input type="text" name="subjectcode" placeholder="Subject Code" value="">
        <input type="text" name="subjectname" placeholder="Subject Name" value="">
        <input type="submit" value="Add Subject" name="add_subject">
    </form>
</div>
</body>
</html>
