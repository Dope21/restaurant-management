<?php 
    $db_server = "localhost";
    $db_user = "root";
    $db_password = "";
    $db_name = "online_restaurant";

    $conn = mysqli_connect($db_server,$db_user,$db_password,$db_name);
    
    if (!$conn){
        echo 'connection failed' . mysqli_connect_error();
        die();
    } else {
        // echo 'yes';
    }
?>