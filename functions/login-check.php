<?php require_once('../database/connection.php') ?>
<?php session_start() ?>
<?php 

    $_user = $_POST['user'];
    $_pass = $_POST['pass'];

    $sql = "SELECT * FROM customer WHERE cus_username = '$_user' AND cus_password = '$_pass'";
    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($query);

    if(mysqli_num_rows($query) == 0) {

        header('location: ../components/login.php?error="wrong username or password"');
    } else {

        $_SESSION['userID'] = $row['cus_id'];
        header('location: ../index.php');
    }

?>