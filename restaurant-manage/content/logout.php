<?php session_start() ?>
<?php 

    unset($_SESSION['empID']);
    header('location: ./login.php');
?>