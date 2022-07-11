<?php 

if(!isset($_SESSION['username'])):

?>

<?php $_SESSION['message'] = "Login required"; header("Location:index.php");?>
<?php endif;?>