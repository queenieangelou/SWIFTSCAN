<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
<?php
session_start();

require('../home/connection.php');

if (isset($_POST['logIn_button'])) {
    $_SESSION['validate'] = false;
    $admid = $_POST['admid'];
    $password = $_POST['password'];

    // Fetch the hashed password from the database based on the admid
    $stmt = SWIFTSCAN::connect()->prepare('SELECT password FROM tbadminfo WHERE admid=:id');
    $stmt->bindValue(':id', $admid);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {
        $storedPassword = trim($result['password']); // Trim whitespace

        // Compare the raw entered password with the stored hashed password
        if ($password === $storedPassword) {
            $_SESSION['admid'] = $admid;
            $_SESSION['validate'] = true;
            header('location: ../admin/admin.php');
            exit();
        } else {
            echo 'Password verification failed! Passwords do not match.<br>';
        }
    } else {
        echo 'User not found!<br>';
    }
}
?>






<div class="container">
    <form action="" method="post">
        <h2><img src="../pictures/logo.png" alt="SwiftScan Logo" class="logo"></h2>
        <input type="text" name="admid" placeholder="Admin ID" required><br>
        <input type="password" name="password" placeholder="password" required><br>
        <input type="submit" value="Log In" name="logIn_button"> <br>
    </form>
</div>
</body>
</html>