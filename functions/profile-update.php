<?php require_once('../database/connection.php') ?>
<?php session_start() ?>
<?php 
    //VARIABLE FOR UPDATE
    $_userID = $_GET['userID'];

    $_fname = $_POST['fname'];
    $_lname = $_POST['lname'];
    $_username = $_POST['username'];
    $_password = $_POST['password'];
    $_address = $_POST['address'];
    $_number = $_POST['number'];
    $_image = $_FILES['image']['name'];
    $path = '../restaurant-manage/asset/cus_img/';

    // echo $_fname.'<br>';
    // echo $_lname.'<br>';
    // echo $_username.'<br>';
    // echo $_password.'<br>';
    // echo $_address.'<br>';
    // echo $_number.'<br>';
    // echo $_image.'<br>';
    // echo $path.'<br>';

    if ($_image == "" ) {
        $sql = "UPDATE customer SET
                cus_fname = '$_fname',
                cus_lname = '$_lname',
                cus_username = '$_username',
                cus_password = '$_password',
                cus_address = '$_address',
                cus_number = '$_number'
                WHERE cus_id = '$_userID'";
    } else {
        $sql = "UPDATE customer SET
                cus_fname = '$_fname',
                cus_lname = '$_lname',
                cus_username = '$_username',
                cus_password = '$_password',
                cus_address = '$_address',
                cus_number = '$_number',
                cus_image = '$_image'
                WHERE cus_id = '$_userID'";
                copy($_FILES["image"]["tmp_name"],"$path$_image");
    }

    mysqli_query($conn, $sql);
    header('location: ../index.php?content=profile')


?>