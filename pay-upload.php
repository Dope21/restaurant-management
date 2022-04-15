<?php require_once('./database/connection.php') ?>
<?php 

    $_orderID = $_GET['orderID'];
    $_image = $_FILES['image']['name'];
    $path = './restaurant-manage/payment_img/';

    if ($_image == '') {

        header('location: ./index.php?content=order'); 
    } else {

        $sql = "UPDATE delivery SET order_payment = '$_image' WHERE bill_id = '$_orderID'";
        copy($_FILES["image"]["tmp_name"],"$path$_image");
        mysqli_query($conn, $sql);
        header('location: ./index.php?content=order');
    }
?>