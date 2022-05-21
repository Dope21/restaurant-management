<?php require_once('../database/connection.php') ?>
<?php 

if ($_POST['order'] == 'add'){
    //VARIABLE FOR ADD USER
    $_username = $_POST['Username'];
    $_password = $_POST['Password'];
    $_fname = $_POST['Fname'];
    $_lname = $_POST['Lname'];
    $_address = $_POST['Address'];
    $_number = $_POST['Number'];
    $_status = $_POST['Status'];


    $sql = "INSERT INTO customer (cus_username, cus_password, cus_address, cus_number, cus_fname, cus_lname) 
            VALUES ('$_username', '$_password', '$_address', '$_number', '$_fname', '$_lname')";
}

if ($_POST['order'] == 'delete') {
    
    $_userID = $_POST['deleteID'];

    $sql = "DELETE FROM customer WHERE cus_id = '$_userID'";
}

if ($_POST['order'] == 'Update') {
    //VARIABLE FOR UPDATE
    $_userID = $_GET['userID'];

    $_fname = $_POST['fname'];
    $_lname = $_POST['lname'];
    $_username = $_POST['username'];
    $_password = $_POST['password'];
    $_address = $_POST['address'];
    $_number = $_POST['number'];
    $_image = $_FILES['image']['name'];
    $path = '../asset/cus_img/';

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

        $result = mysqli_query($conn, $sql);
        if (!$result) {
            echo 'not working'.mysqli_error($conn) ;
        } else {
            header('location: ../index.php#customer');
        }

}

mysqli_query($conn, $sql);

?>