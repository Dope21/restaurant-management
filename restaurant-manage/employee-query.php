<?php require_once('./database/connection.php') ?>
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


    $sql = "INSERT INTO employee (emp_username, emp_password, emp_address, emp_number, emp_fname, emp_lname, emp_status) 
            VALUES ('$_username', '$_password', '$_address', '$_number', '$_fname', '$_lname', '$_status')";
}

if ($_POST['order'] == 'delete') {
    
    $_userID = $_POST['deleteID'];

    $sql = "DELETE FROM employee WHERE emp_id = '$_userID'";
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
    $_status = $_POST['status'];
    $_image = $_FILES['image']['name'];
    $path = 'emp_img/';

    // echo $_fname.'<br>';
    // echo $_lname.'<br>';
    // echo $_username.'<br>';
    // echo $_password.'<br>';
    // echo $_address.'<br>';
    // echo $_number.'<br>';
    // echo $_status.'<br>';
    // echo $_image.'<br>';
    // echo $path.'<br>';

    if ($_image == "" ) {
        $sql = "UPDATE employee SET
                emp_fname = '$_fname',
                emp_lname = '$_lname',
                emp_username = '$_username',
                emp_password = '$_password',
                emp_address = '$_address',
                emp_number = '$_number',
                emp_status = '$_status'
                WHERE emp_id = '$_userID'";
    } else {
        $sql = "UPDATE employee SET
                emp_fname = '$_fname',
                emp_lname = '$_lname',
                emp_username = '$_username',
                emp_password = '$_password',
                emp_address = '$_address',
                emp_number = '$_number',
                emp_status = '$_status',
                emp_image = '$_image'
                WHERE emp_id = '$_userID'";
                copy($_FILES["image"]["tmp_name"],"$path$_image");
    }

        $result = mysqli_query($conn, $sql);

            if (isset($_GET['fromprofile'])){
                header('location: ./index.php#profile');
            } else {
                header('location: ./index.php#employee');
            }
}

mysqli_query($conn, $sql);

?>