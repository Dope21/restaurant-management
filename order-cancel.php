<?php require_once('./database/connection.php') ?>
<?php 
    $_billID = $_GET['orderID'];

    $sqlDetails = "DELETE FROM order_details WHERE bill_id = '$_billID'";
    mysqli_query($conn, $sqlDetails);
    $sql = "DELETE FROM delivery WHERE bill_id = '$_billID'";
    mysqli_query($conn, $sql);
    header('location: index.php?content=order');
?>