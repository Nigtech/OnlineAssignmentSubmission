<?php
include "includes/db.inc";
include "includes/fetchData.inc";

extract($userData);

var_dump($id);

if (isset($_POST['submit'])) {
    $throwError = [];

    if (empty($_POST['fname'])) {
        $throwError ['fname'] = "Please enter first name";
    }

    if (empty($_POST['lname'])) {
        $throwError ['lname'] = "Please enter last name";

    }


    if (empty($throwError)) {
        extract($_POST);

        $stmt = $conn->prepare("UPDATE $tbl SET firstName = '$fname', lastName = '$lname' WHERE id = '$id' ");
        if ($stmt->execute()) {
            $_SESSION['message'] = "Profile Updated Successfully";
            if ($_SESSION['userType'] == "student") {
                header("Location:dashboard.php");
            }elseif ($_SESSION['userType'] == "lecturer") {
                header("Location:lecturerDashboard.php");
            }
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
    <title>Edit your profile here</title>
    <link rel="stylesheet" href="css/editpage.css">
</head>

<body id="editPage">

<header class="editTag">
    <h1>Edit your profile</h1>
</header>

<div>

    <form action="" method="post">
        <input type="text" name="fname" value="<?php echo $firstName; ?>">
        <input type="text" name="lname" value="<?php echo $lastName; ?>">
        <!-- <input type="hidden" name="id" value="$id"> -->
        <input type="submit" value="Edit" name="submit">
    </form>

</div>

<a href="<?php if($_SESSION["userType"] === "student"){
    echo "dashboard.php";
}elseif($_SESSION["userType"] === "lecturer"){
    echo "lecturerDashboard.php";
} ?>" >
    <button>
        Back to dashboard
    </button> 
</a>
    
</body>
</html>