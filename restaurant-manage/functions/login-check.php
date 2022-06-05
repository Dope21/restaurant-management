<?php ob_start(); ?>
<?php require_once("../database/connection.php") ?>    
<?php session_start() ?>
<?php 
    $_user = $_POST['user'];
    $_pass = $_POST['pass'];

    $sql = "SELECT * 
            FROM employee 
            WHERE emp_username = '$_user' 
            AND emp_password = '$_pass'";
    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($query);
    $message = '';
    if (mysqli_num_rows($query) == 0) {
        $message = 'wrong username or password';
        header('location: ../content/login.php?message='.$message);
    } else {
        $_SESSION['empID'] = $row['emp_id'];
        $_SESSION['status'] = $row['emp_status'];
        header('location: ../index.php');
    }
?>