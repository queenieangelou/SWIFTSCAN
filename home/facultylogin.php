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

require('./connection.php');

if (isset($_POST['logIn_button'])) {
    $_SESSION['validate'] = false;
    $empid = $_POST['empid'];
    $EnteredPassword = $_POST['Password']; // Rename to better reflect that it's the raw entered password

    $p = SWIFTSCAN::connect()->prepare('SELECT empid, PasswordEncrypted FROM tbaccount WHERE accid=:id');
    $p->bindValue(':id', $empid);
    $p->execute();

    $user = $p->fetch(PDO::FETCH_ASSOC);

    if ($p->rowCount() > 0) {
        // Compare the raw entered password with the stored hashed password
        if ($EnteredPassword === $user['PasswordEncrypted']) {
            $_SESSION['empid'] = $empid;
            $_SESSION['validate'] = true;
            header('location: ../faculty/faculty.php');
            exit();
        } else {
            echo 'Password verification failed! Passwords do not match.';
        }
    } else {
        echo 'User not found!';
    }
}
?>

</body>

<div class="container">
<form action="" method="post">
            <h2><img src="../pictures/logo.png" alt="SwiftScan Logo" class="logo"></h2>
            <input type="text" name="empid" placeholder="Faculty ID" required><br>
            <input type="password" name="Password" placeholder="Password" required><br>
            <input type="submit" value="Log In" name="logIn_button"> <br>
        </form>
    </div>

</html>