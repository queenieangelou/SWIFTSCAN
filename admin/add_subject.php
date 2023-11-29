<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Subject</title>
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

        header("Location: ../faculty/subjectContent.php");
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

<table>
    <thead>
        <tr>
            <th>Subject ID</th>
            <th>Subject Code</th>
            <th>Subject Name</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>    
</table>
</body>
</html>
