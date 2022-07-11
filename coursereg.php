<?php



include "includes/db.inc";
include "includes/fetchData.inc";

extract($userData);

$checkCourses = $conn->prepare("SELECT * FROM coursereg WHERE studentName = '$username'");
$checkCourses->execute();
if ($checkCourses->rowCount() > 0) {
    $_SESSION['message'] = "Sorry you've registered courses";
    if ($_SESSION['userType'] == "student") {
        header("Location:dashboard.php");
    }elseif ($_SESSION['userType'] == "lecturer") {
        header("Location:lecturerDashboard.php");
    }
    exit;
}

if($_SERVER["REQUEST_METHOD"] === "POST"){
    // require 'db.php';

    $course1 = $_POST["course1"];
    $course2 = $_POST["course2"];
    $course3 = $_POST["course3"];
    $course4 = $_POST["course4"];
    $course5 = $_POST["course5"];
    $course6 = $_POST["course6"];
    $course7 = $_POST["course7"];
    $course8 = $_POST["course8"];
    $course9 = $_POST["course9"];
    $course10 = $_POST["course10"];

    $sql = "INSERT INTO coursereg(`studentName`, `course1`, `course2`, `course3`, `course4`, `course5`, `course6`, `course7`, `course8`, `course9`, `course10`) VALUES ('{$_SESSION["username"]}', '{$course1}', '{$course2}', '{$course3}', '{$course4}', '{$course5}', '{$course6}', '{$course7}', '{$course8}', '{$course9}', '{$course10}') ";

    $prep = $conn->prepare($sql);
    $prep->execute();

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register courses</title>

    <link rel="stylesheet" href="css/editpage.css">
</head>
<body id="editPage">
    <form action="" method="post" id="course_reg_form">
        <input type="text" name="course1" placeholder="Course Code">
        <input type="text" name="course2" placeholder="Course Code">
        <input type="text" name="course3" placeholder="Course Code">
        <input type="text" name="course4" placeholder="Course Code">
        <input type="text" name="course5" placeholder="Course Code">
        <input type="text" name="course6" placeholder="Course Code">
        <input type="text" name="course7" placeholder="Course Code">
        <input type="text" name="course8" placeholder="Course Code">
        <input type="text" name="course9" placeholder="Course Code">
        <input type="text" name="course10" placeholder="Course Code">
        <input type="submit" name="submit" value="Register">
    </form>

    <a href="dashboard.php">
        <button>
            Back to dashboard
        </button>
    </a>

    <script type="text/javascript">
        

        const ajax = new XMLHttpRequest();
        let course_reg = document.forms["course_reg_form"];
        let courses = course_reg.children;

        course_reg.addEventListener("submit", (e) => {
            e.preventDefault();


            ajax.open('post', 'coursereg.php', true);
        ajax.onreadystatechange = () => {
            if(ajax.readyState === 4 && ajax.status === 200){
                alert("Courses Succesfully Registered");
                var userType = "<?=$_SESSION['userType']?>"

            if (userType == "student") {
                    window.location.href="dashboard.php";
                }else if (userType == "lecturer") {
                    window.location.href="lecturerDashboard.php";
                }
            }
        };
        ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajax.send("course1="+courses[0].value+"&course2="+courses[1].value+"&course3="+courses[2].value+"&course4="+courses[3].value+"&course5="+courses[4].value+"&course6="+courses[5].value+"&course7="+courses[6].value+"&course8="+courses[7].value+"&course9="+courses[8].value+"&course10="+courses[9].value);
        });
    </script>
</body>
</html>