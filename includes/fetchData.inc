<?php 

include "auth.inc";

$tbl = $_SESSION['userType'];
$username = $_SESSION['username'];

$fetchStmt = $conn->prepare("SELECT * FROM $tbl WHERE username = '$username'");
$fetchStmt->execute();

$userData = $fetchStmt->fetch(PDO::FETCH_BOTH);



?>