<?php 
// session_start();

require 'includes/db.inc';

if (isset($_SESSION['username'])) {
    if ($_SESSION['userType']== "student") {
        header('location: dashboard.php');
    }elseif($_SESSION['userType'] == "lecturer"){
        header('location: lecturerDashboard.php');
        exit;
    }
}


if (isset($_POST['login_btn'])) {
    $throwError = [];

    if (empty($_POST['email'])) {
        $throwError['email'] = "Please input email, username or reg number";
    }else{
        $email = trim($_POST['email']);
    }

    if (empty($_POST['password'])) {
        $throwError['password'] = "Please input password";
    }else{
        $password = trim($_POST['password']);
    }

    if (empty($_POST['userType'])) {
        $throwError['userType'] = "Please select user type";
    }else{
        $userType = trim($_POST['userType']);
    }


    if (empty($throwError)) {
        $tbl = $userType;

        $stmt = $conn->prepare("SELECT * FROM $tbl WHERE email='$email' OR username = '$email'");
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_BOTH);

        // var_dump($row, $stmt);
        if ($stmt->rowCount() < 1) {
            $errorDisplay = "User Information does not exist, please try to register";

        }elseif ($stmt->rowCount() > 0 && password_verify($password, $row['password'])) {
            $_SESSION['id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            if ($userType == "student") {
                $_SESSION['userType'] = "student";
                header('location: dashboard.php');
            }elseif($userType == "lecturer"){
                $_SESSION['userType'] = "lecturer";
                header('location: lecturerDashboard.php');
                exit;
            }
        }else{
            $errorDisplay = "Incorrect credentials";
        }
    }


}


 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login dashboard</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body id="login_page">
    
    <section id="login">
        <h1>login to begin</h1>

        <form action="" method="post">


            <?php if (isset($errorDisplay)): ?>
                <p style="color:red; margin-left: 40px; font-weight:bold;"><?=$errorDisplay?></p>
            <?php endif ?>


            <?php if (isset($throwError['email'])): ?>
                <p style="color:red; margin-left: 40px; font-weight:bold;"><?=$throwError['email']?></p>
            <?php endif ?>
            <input type="text" name="email" <?php if(isset($_POST['email'])){echo "value='".$_POST['email']."'";}?> placeholder="Enter your email, username">

            <?php if (isset($throwError['password'])): ?>
                <p style="color:red; margin-left: 40px; font-weight:bold;"><?=$throwError['password']?></p>
            <?php endif ?>
            <input type="password" name="password" placeholder="Enter your password">

            <?php if (isset($throwError['userType'])): ?>
                <p style="color:red; margin-left: 40px; font-weight:bold;"><?=$throwError['userType']?></p>
            <?php endif ?>
            <select name="userType" id="userType">
                <option disabled selected>--Select User Type--</option>
                <option value="student" <?php if(isset($_POST['userType']) && $_POST['userType'] == "student"){echo "selected";}?>>student</option>
                <option value="lecturer" <?php if(isset($_POST['userType']) && $_POST['userType'] == "lecturer"){echo "selected";}?>>lecturer</option>
            </select>
            <!-- <label for="">Login as</label>
            <input type="checkbox" value="student"><span>Student</span> 
            <input type="checkbox" value="lecturer"><span>lecturer</span> -->
            <input type="submit" name="login_btn" value="submit">
        </form>
    </section>

    <footer>
        back to <a href="index.php">homepage</a> 
    </footer>
</body>
</html>