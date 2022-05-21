<?php session_start() ?>
<?php require_once('./database/connection.php'); ?>
<?php 

    date_default_timezone_set("Asia/Bangkok");

    if ($_SESSION['id_count'] == '') {
        $sqlID = "SELECT order_id FROM delivery ORDER BY order_id DESC";
        $resultID = mysqli_query($conn, $sqlID);
        $feildID = mysqli_fetch_array($resultID);

        $_SESSION['id_count'] = $feildID['order_id']+1;
    } else {
        $_SESSION['id_count'] += 1;
    }

    $_billID = 'D'.substr(date('Ymd'), 2).$_SESSION['id_count'];

    $_userID = $_SESSION['userID'];
    $_date = date('Y-m-d');
    $_time = date('H:i');

    $sql_cus = "SELECT * FROM customer WHERE cus_id = '$user'";
    $rs_cus = mysqli_query($conn, $sql_cus);
    $row_cus = mysqli_fetch_array($rs_cus);

    $menuLast = count($_SESSION['cart']);
    for ($i = 0; $i < $menuLast; $i++) {

        if ($_SESSION['cart'][$i]['menuQT'] > 0 ) {
    
            $_menuID = $_SESSION['cart'][$i]['menuID'];
            $_menuQT = $_SESSION['cart'][$i]['menuQT'];
    
            $sql_menuID = "SELECT * 
                           FROM menu 
                           WHERE '$_menuID' = menu_id";
            $result_menuID = mysqli_query($conn, $sql_menuID);
            $row_menu = mysqli_fetch_array($result_menuID);
            $total_menu = $_menuQT * $row_menu['menu_price'];
            
            $sql_check = "SELECT *                                
                          FROM order_details 
                          WHERE '$_billID' = bill_id 
                          AND '$_menuID' = menu_id";
            $result_check = mysqli_query($conn, $sql_check);
            $row_check = mysqli_fetch_array($result_check);

            if (mysqli_num_rows($result_check) > 0) {

                $total_menu += $row_check['menu_total'];
                $_menuQT += $row_check['menu_qt']; 

                $sql_addMenu = "UPDATE order_details
                                SET menu_qt = '$_menuQT', menu_total = '$total_menu' 
                                WHERE '$_billID' = bill_id 
                                AND '$_menuID' = menu_id";
                mysqli_query($conn, $sql_addMenu);

            } else {

                $sql_addMenu = "INSERT INTO order_details 
                                VALUE ('','$_billID', '$_menuID','$_menuQT','$total_menu')";
                mysqli_query($conn, $sql_addMenu);
            } 
        }
    }

    $sql_orderSum = "SELECT SUM(menu_total) 
                     AS orderSum 
                     FROM order_details 
                     WHERE '$_billID' = bill_id";
    $result_orderSum = mysqli_query($conn, $sql_orderSum);
    $row_orderSum = mysqli_fetch_array($result_orderSum);

    $sql_set = "SELECT * FROM setting";
    $rs_set = mysqli_query($conn, $sql_set);
    $row_set = mysqli_fetch_array($rs_set);

    $_orderSum = $row_orderSum['orderSum']+$row_set['set_deliver']+($row_orderSum['orderSum']*$row_set['set_vat']/100);

    $sql_delivery = "INSERT INTO delivery
                     VALUE ('','$_billID','$_orderSum','waiting','','$_time','$_date','$_userID')";
    $rs_delivery = mysqli_query($conn, $sql_delivery);
    
    unset($_SESSION['cart']);
    header('location: ./index.php?content=order');
?>
