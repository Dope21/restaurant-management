<?php session_start() ?>
<?php 

    unset($_SESSION['userID']);
    header('location: ./login.php');
?>