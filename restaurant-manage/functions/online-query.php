<?php require_once('./database/connection.php') ?>
<?php session_start() ?>
<?php 

    if ($_POST['order'] == 'take') {

        $_billID = $_POST['orderID'];
        
        $sqlStatus = "SELECT * FROM delivery WHERE '$_billID' = bill_id";
        $resultStatus = mysqli_query($conn, $sqlStatus);
        $rowStatus = mysqli_fetch_array($resultStatus);

        switch ($rowStatus['order_status']) {
            case "waiting":
                $_status = 'cooking';
                break;
            case "cooking":
                $_status = 'delivering';
                break;
            default:
                $_status = 'cooking';
        }

        $sql = "UPDATE delivery 
                SET order_status = '$_status'
                WHERE bill_id = '$_billID'";
        mysqli_query($conn, $sql);

    }

    if ($_POST['order'] == 'cancel') {
        
        $_billID = $_POST['orderID'];

        $sqlDetails = "DELETE FROM order_details WHERE bill_id = '$_billID'";
        mysqli_query($conn, $sqlDetails);
        $sql = "DELETE FROM delivery WHERE bill_id = '$_billID'";
        mysqli_query($conn, $sql);
    }
?>