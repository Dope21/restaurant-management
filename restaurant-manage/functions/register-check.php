<?php require_once("./database/connection.php") ?>    
<?php session_start() ?>
<?php 

    $m_pass = '';
    $m_user = '';

    if ($_POST['password'] != $_POST['password-check']){
        $m_pass = "The two passwords don't match";
        header('location: ./register.php?mpass='.$m_pass);
    }

    $_user = $_POST['username'];
    $_pass = $_POST['password'];
    $_pass_check = $_POST['password-check'];
    $_fname = $_POST['fname'];
    $_lname = $_POST['lname'];
    $_address = $_POST['address'];
    $_number = $_POST['number'];

    $sql_check = "SELECT * FROM employee WHERE emp_username = '$_user'";
    if (mysqli_num_rows(mysqli_query($conn, $sql_check)) != 0) {
        $m_user = 'This username is already been used';    
        header('location: ./register.php?muser='.$m_user);
    } else {
        $sql = "INSERT INTO employee (emp_username, emp_password, emp_address, emp_number, emp_fname, emp_lname, emp_status) 
                VALUES ('$_user', '$_pass', '$_address', '$_number', '$_fname', '$_lname', 'employee')";
        $query = mysqli_query($conn, $sql);

        if(!$query) {
            echo mysqli_error($conn);
        } else {
            header('location: ./login.php');
        }
    }




?>