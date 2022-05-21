<?php require_once('../database/connection.php') ?>
<?php 

    if ($_POST['order'] == 'delete') {

        $_billID = $_POST['orderID'];

        $sqlDetails = "DELETE FROM order_details WHERE bill_id = '$_billID'";
        mysqli_query($conn, $sqlDetails);

        if (substr($_billID,0,1) != 'D') {
            $sql = "DELETE FROM front WHERE bill_id = '$_billID'";
            mysqli_query($conn, $sql);
        } else {
            $sql = "DELETE FROM delivery WHERE bill_id = '$_billID'";
            mysqli_query($conn, $sql);
        }    
    }

?>
