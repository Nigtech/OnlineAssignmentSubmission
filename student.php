<?php
require 'includes/db.inc';


if(isset($_SESSION['username'])){
    header("Location:dashboard.php");
    exit;
}


if (isset($_POST['submit'])) {
    $throwError = [];

    $userData = $_POST;

    unset($userData['submit']);

    foreach ($userData as $key => $value) {
        if(empty($value)){
            $throwError[$key] = "Please fill this field";
        }
    }

    if ($_POST['password'] != $_POST['confirm_password']) {
        $throwError['confirm_password'] = "Password Mismatch";
    }


    if (empty($throwError)) {

        $checkError = false;
        $errorStmt = "";

        extract($_POST);
        

        $checkEmailStmt = "SELECT * FROM student WHERE email = '$email'";
        $checkEmail = $conn->prepare($checkEmailStmt);
        $checkEmail->execute();

        if ($checkEmail->rowCount() > 0) {
            $checkError = true;
            $errorStmt .= "Email already Exist in our database newLine";
        }


        $checkUsernameStmt = "SELECT * FROM student WHERE username = '$username'";
        $checkUsername = $conn->prepare($checkUsernameStmt);
        $checkUsername->execute();

        if ($checkUsername->rowCount() > 0) {
            $checkError = true;
            $errorStmt .= "Username already Exist in our database newLine";
        }


        $checkRegNumberStmt = "SELECT * FROM student WHERE regNumber = '$regNumber' ";
        $checkRegNumber = $conn->prepare($checkRegNumberStmt);
        $checkRegNumber->execute();

        if ($checkRegNumber->rowCount() > 0) {
            $checkError = true;
            $errorStmt .= "Reg number Exist in our database newLine";
        }

        if (!$checkError){
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("INSERT INTO student(`firstName`, `lastName`, `regNumber`, `faculty`, `username`, `email`, `password`) values ('{$fname}', '$lname', '{$regNumber}', '{$faculty}', '{$username}', '{$email}', '{$hashedPassword}')");
        if ($stmt->execute()) {
            $_SESSION['username'] = $username;
            $_SESSION['userType'] = "student";
            header("Location: dashboard.php");
        }
        }

    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Student registration portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/index.css">
</head>

<body id="studentPortal">
    <section id="studentForm">
    <header>
        <h1>
        Register as a Student
        </h1>
    </header>

    <form action="" method="post" id="studentRegistrationForm">

        <?php if (isset($throwError['fname'])): ?>
                <p style="color:red; margin-left: 40px; font-weight:bold;"><?=$throwError['fname']?></p>
        <?php endif ?>
        <input type="text" <?php if(isset($_POST['fname'])){echo "value='".$_POST['fname']."'";}?> name="fname" placeholder="enter your first name">

        <?php if (isset($throwError['lname'])): ?>
                <p style="color:red; margin-left: 40px; font-weight:bold;"><?=$throwError['lname']?></p>
        <?php endif ?>
        <input type="text" <?php if(isset($_POST['lname'])){echo "value='".$_POST['lname']."'";}?> name="lname" placeholder="enter your last name">

        <?php if (isset($throwError['regNumber'])): ?>
                <p style="color:red; margin-left: 40px; font-weight:bold;"><?=$throwError['regNumber']?></p>
        <?php endif ?>
        <input type="text" <?php if(isset($_POST['regNumber'])){echo "value='".$_POST['regNumber']."'";}?> name="regNumber" placeholder="enter your Registration Number">

        <?php if (isset($throwError['faculty'])): ?>
                <p style="color:red; margin-left: 40px; font-weight:bold;"><?=$throwError['faculty']?></p>
        <?php endif ?>
        <input type="text" <?php if(isset($_POST['faculty'])){echo "value='".$_POST['faculty']."'";}?> name="faculty" placeholder="enter your faculty">

        <?php if (isset($throwError['username'])): ?>
                <p style="color:red; margin-left: 40px; font-weight:bold;"><?=$throwError['username']?></p>
        <?php endif ?>
        <input type="text" <?php if(isset($_POST['username'])){echo "value='".$_POST['username']."'";}?> name="username" placeholder="Choose your username">

        <?php if (isset($throwError['email'])): ?>
                <p style="color:red; margin-left: 40px; font-weight:bold;"><?=$throwError['email']?></p>
        <?php endif ?>
        <input type="email" <?php if(isset($_POST['email'])){echo "value='".$_POST['email']."'";}?> name="email" placeholder="Enter your email">

        <?php if (isset($throwError['password'])): ?>
                <p style="color:red; margin-left: 40px; font-weight:bold;"><?=$throwError['password']?></p>
        <?php endif ?>
        <input type="password" name="password" placeholder="choose a password">


        <?php if (isset($throwError['confirm_password'])): ?>
                <p style="color:red; margin-left: 40px; font-weight:bold;"><?=$throwError['confirm_password']?></p>
        <?php endif ?>
        <input type="password" name="confirm_password" placeholder="confirm password">

        <input type="submit" name="submit" value="Register">_
    </form>
    </section>

    <footer>
        Go to <a href="index.php">homepage</a> 
    </footer>
    <?php if ($checkError ?? false): ?>
        <script type="text/javascript">
            var txt = "<?=$errorStmt?>";
            alert(txt.replace(/newLine/gi, "\n"))
        </script>
    <?php endif ?>

    <!-- <script src="js/student.js"></script> -->
</body>
</html>