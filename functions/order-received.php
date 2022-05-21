<?php require_once('../database/connection.php') ?>
<?php 

    $billID = $_GET['orderID'];

    $sql = "UPDATE delivery SET order_status = 'received'";
    mysqli_query($conn, $sql);
    header('location: ../index.php?content=order');

?>