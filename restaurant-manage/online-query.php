<?php require_once('./database/connection.php') ?>
<?php session_start() ?>
<?php 

    if ($_POST['order'] == 'take') {

        $_billID = $_POST['orderID'];
        
        $sqlStatus = "SELECT * FROM delivery WHERE '$_billID' = bill_id";
        $resultStatus = mysqli_query($conn, $sqlStatus);
        $rowStatus = mysqli_fetch_array($resultStatus);

        // if($rowStatus['order_status'] == 'waiting') {
        //     $_status = 'cooking';
        // } else if($rowStatus['order_status'] == 'cooking') {
        //     $_status = 'delivering';
        // }
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

    // if ($_POST['order'] == 'add') {

    //     //BILL ID 
    //     date_default_timezone_set("America/New_York");
                
    //     if ($_SESSION['online_count'] == '') {
    //         $sqlID = "SELECT order_id FROM delivery ORDER BY order_id DESC";
    //         $resultID = mysqli_query($conn, $sqlID);
    //         $feildID = mysqli_fetch_array($resultID);
    
    //         $_SESSION['online_count'] = $feildID['order_id']+1;
    //     } else {
    //         $_SESSION['online_count'] += 1;
    //     }

    //     //PASSED ON THE VALUES
    //     $_billID = 'D'.substr(date('Ymd'), 2).$_SESSION['online_count'];
    //     $_date = date('Y-m-d');
    //     $_time = date("h:i");
    //     $_name = $_POST['name'];
    //     $_address = $_POST['address'];

    //     $sql = "INSERT INTO delivery (bill_id, order_name, order_address, order_status, order_time, order_date)
    //             VALUE ('$_billID', '$_name', '$_address', 'wait', '$_time', '$_date')";
    //     mysqli_query($conn, $sql);
            
    // }

    // if ($_POST['order'] == 'update') {
    
    //     //VARIABLE FOR UPDATE
    //     $_orderID = $_POST['updateID'];
    //     $_name = $_POST['name'];
    //     $_status = $_POST['status'];
    //     $_address = $_POST['address'];
    //     $_menuQTs = $_POST['menuQTs'];
    //     $_menuIDs = $_POST['menuIDs'];
    
    //     $counter = count($_menuIDs);
    //     for ($i = 0; $i < $counter; $i++) {
    //         $_menuQT = $_menuQTs[$i];
    //         $_menuID = $_menuIDs[$i];
        
    //         //GET TOTAL FROM EACH MENU
    //         $sqlMenu = "SELECT * 
    //                     FROM menu 
    //                     WHERE '$_menuID' = menu_id";
    //         $resultMenu = mysqli_query($conn, $sqlMenu);
    //         $rowMenu = mysqli_fetch_array($resultMenu);
    //         $total_menu = $_menuQT * $rowMenu['menu_price'];
    
    //         //SET NEW AMOUNT TO ORDER DETAILS
    //         $sqlDetails = "UPDATE order_details 
    //                        SET menu_qt = '$_menuQT',
    //                            menu_total = '$total_menu'
    //                        WHERE menu_id = '$_menuID'
    //                        AND bill_id = '$_orderID'";
    //         mysqli_query($conn, $sqlDetails);
    
    //         // echo mysqli_error($conn);
    //     }
    
    //     // SELECT SUM OF ALL ORDERS 
    //     $sql_orderSum = "SELECT SUM(menu_total) 
    //                      AS orderSum 
    //                      FROM `order_details` 
    //                      WHERE '$_orderID' = bill_id";
    //     $result_orderSum = mysqli_query($conn, $sql_orderSum);
    //     $row_orderSum = mysqli_fetch_array($result_orderSum);
    //     $_orderSum = $row_orderSum['orderSum'];
    
    //     //INSERT SUM TO ORDER BILL 
    //     $_insertSum = "UPDATE delivery 
    //                    SET order_price = '$_orderSum' ,
    //                        order_name = '$_name',
    //                        order_status = '$_status',
    //                        order_address = '$_address'
    //                    WHERE bill_id = '$_orderID'";
    //     mysqli_query($conn, $_insertSum);
    
    // }

    // if($_GET['payment'] != '') {

    //     $_billID = $_GET['payment'];
    //     $_image = $_FILES['image']['name'];
    //     $path = 'payment_img/';

    //     echo $_billID.'<br>';
    //     echo $_image.'<br>';
    //     echo $path.'<br>';

    //     $sql = "UPDATE delivery
    //             SET order_payment = '$_image'
    //             WHERE bill_id = $_billID";
        
    //     copy($_FILES["image"]["tmp_name"],"$path$_image");
    //     mysqli_query($conn, $sql);

    //     echo mysqli_error($conn);
    //     header('location: index.php#online');
    // }

    // if ($_POST['order'] == 'delete') {
    
    //     $_billID = $_POST['deleteID'];
    
    //     $sql = "DELETE FROM delivery WHERE bill_id = '$_billID'";
    //     mysqli_query($conn, $sql);
    //     $sqlDetails = "DELETE FROM order_details WHERE bill_id = '$_billID'";
    //     mysqli_query($conn, $sqlDetails);
    // }

?>