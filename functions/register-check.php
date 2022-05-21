<?php require_once('./database/connection.php') ?>
<?php session_start() ?>
<?php 

    $ms_pass = '';
    $ms_user = '';

    $_user = $_POST['user'];
    $_pass = $_POST['pass'];
    $_fname = $_POST['fname'];
    $_lname = $_POST['lname'];
    $_address = $_POST['address'];
    $_number = $_POST['number'];

    $sql_check = "SELECT * FROM customer WHERE cus_username = '$_user'";
    $rs_check = mysqli_query($conn, $sql_check);

        if ($_POST['pass'] != $_POST['check-pass']) {
            $ms_pass = '<p class="text-danger">The two passwords do not match.</p>';
        }
        if (mysqli_num_rows($rs_check) != 0) {
            $ms_user =  '<p class="text-danger">This username already been used.</p>';
        }
    
    if ($ms_pass != '' || $ms_user != '') {
        header('location: ./register.php?ms_user='.$ms_user.'&ms_pass='.$ms_pass);
    }

    $sql = "INSERT INTO customer (cus_username, cus_password, cus_address, cus_number, cus_fname, cus_lname) 
            VALUES ('$_user', '$_pass', '$_address', '$_number', '$_fname', '$_lname')";
    $query = mysqli_query($conn, $sql);
    
    if (!$query) {
        echo mysqli_error($conn);
    } else {
        header('location: ./login.php');
    }

?>