<?php require_once('./database/connection.php') ?>
<?php session_start() ?>
<?php 

if ($_POST['order'] == 'add'){

    //SET TIME ZONE
    date_default_timezone_set("Asia/Bangkok");

    //CALCULATE THE BILL ID
    if ($_SESSION['id_count'] == '') {
        $sqlID = "SELECT order_id FROM front ORDER BY order_id DESC";
        $resultID = mysqli_query($conn, $sqlID);
        $feildID = mysqli_fetch_array($resultID);

        $_SESSION['id_count'] = $feildID['order_id']+1;
    } else {
        $_SESSION['id_count'] += 1;
    }

    if ($_POST['type'] == 'table') {
            $_billID = 'T'.substr(date('Ymd'), 2).$_SESSION['id_count'];
    } else {
            $_billID = 'P'.substr(date('Ymd'), 2).$_SESSION['id_count'];
    }

    //PASSED ON VALUES
    $_name = $_POST['name'];
    $_type = $_POST['type'];
    $_date = date('Y-m-d');
    $_time = date("H:i");
    $_status = 'unpaid';

    $sql = "INSERT INTO front (bill_id, order_cate, order_name, order_status, order_time, order_date)
            VALUE ('$_billID','$_type', '$_name', '$_status', '$_time', '$_date')";
    mysqli_query($conn, $sql);
}

if ($_POST['order'] == 'delete') {
    
    $_billID = $_POST['deleteID'];

    $sql = "DELETE FROM front WHERE bill_id = '$_billID'";
    $sqlDetails = "DELETE FROM front WHERE bill_id = '$_billID'";
    $resultDetails = mysqli_query($conn, $sqlDetails);
    mysqli_query($conn, $sql);
}

if ($_POST['order'] == 'Update') {
    
    //VARIABLE FOR UPDATE
    $_orderID = $_POST['updateID'];
    $_name = $_POST['name'];
    $_type = $_POST['type'];
    $_menuQTs = $_POST['menuQTs'];
    $_menuIDs = $_POST['menuIDs'];

    $counter = count($_menuIDs);
    for ($i = 0; $i < $counter; $i++) {
        $_menuQT = $_menuQTs[$i];
        $_menuID = $_menuIDs[$i];

        // echo $_menuID.' '.$_menuQT.'<br>';

        //GET TOTAL FROM EACH MENU
        $sqlMenu = "SELECT * 
                    FROM menu 
                    WHERE '$_menuID' = menu_id";
        $resultMenu = mysqli_query($conn, $sqlMenu);
        $rowMenu = mysqli_fetch_array($resultMenu);
        $total_menu = $_menuQT * $rowMenu['menu_price'];

        //SET NEW AMOUNT TO ORDER DETAILS
        $sqlDetails = "UPDATE order_details 
                       SET menu_qt = '$_menuQT',
                           menu_total = '$total_menu'
                       WHERE menu_id = '$_menuID'
                       AND bill_id = '$_orderID'";
        mysqli_query($conn, $sqlDetails);

        // echo mysqli_error($conn);
    }

    // SELECT SUM OF ALL ORDERS 
    $sql_orderSum = "SELECT SUM(menu_total) 
                     AS orderSum 
                     FROM `order_details` 
                     WHERE '$_orderID' = bill_id";
    $result_orderSum = mysqli_query($conn, $sql_orderSum);
    $row_orderSum = mysqli_fetch_array($result_orderSum);
    $_orderSum = $row_orderSum['orderSum'];

    //INSERT SUM TO ORDER BILL 
    $_insertSum = "UPDATE front 
                   SET order_price = '$_orderSum' ,
                       order_name = '$_name',
                       order_cate = '$_type'
                   WHERE bill_id = '$_orderID'";
    mysqli_query($conn, $_insertSum);

}

if($_POST['order'] == 'delete_item') {

    $_item = $_POST['deleteItem'];
    $_orderID = $_POST['orderID'];

    $sql = "DELETE FROM order_details WHERE '$_item' = menu_id";
    mysqli_query($conn, $sql);

    // SELECT SUM OF ALL ORDERS 
    $sql_orderSum = "SELECT SUM(menu_total) 
                     AS orderSum 
                     FROM `order_details` 
                     WHERE '$_orderID' = bill_id";
    $result_orderSum = mysqli_query($conn, $sql_orderSum);
    $row_orderSum = mysqli_fetch_array($result_orderSum);
    $_orderSum = $row_orderSum['orderSum'];

    //INSERT SUM TO ORDER BILL 
    $_insertSum = "UPDATE front SET order_price = '$_orderSum' WHERE bill_id = '$_orderID'";
    mysqli_query($conn, $_insertSum);
}


if($_POST['order'] == 'pay') {
    
    $_total = $_POST['total'];
    $_orderID = $_POST['orderID'];
    $_receive = $_POST['receive'];
    $_change = $_POST['change'];

    $sql = "UPDATE front 
            SET order_price = '$_total',
                order_status = 'paid',
                order_receive = '$_receive',
                order_change = '$_change'
            WHERE bill_id = '$_orderID'";
    mysqli_query($conn, $sql);

}