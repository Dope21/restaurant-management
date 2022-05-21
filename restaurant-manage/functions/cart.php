<?php session_start() ?>
<?php require_once('../database/connection.php'); ?>
<?php

    
    if (isset($_POST['insert'])){

        $_menuID = $_POST['menuID'];

        if(is_array($_SESSION['cart'])){
            
            $menuLast = count($_SESSION['cart']);
            $menuMark = 0;
            for ($i = 0; $i < $menuLast; $i++){
                    
                if ($_SESSION['cart'][$i]['menuID'] == $_menuID){
                    $_SESSION['cart'][$i]['menuQT'] += 1;
                    $menuMark = 1;
                }  
            }

            if ($menuMark == 0) {
                $_SESSION['cart'][$menuLast]['menuID'] = $_menuID;
                $_SESSION['cart'][$menuLast]['menuQT'] = 1;
            }
            
        
        } else {
            $_SESSION['cart'] = array();
            $_SESSION['cart'][0]['menuID'] = $_menuID;
            $_SESSION['cart'][0]['menuQT'] = 1;
        }

    }

    if (isset($_POST['delete'])) {

        $_menuID = $_POST['menuID'];
        $menuLast = count($_SESSION['cart']);

        for ($i = 0; $i < $menuLast; $i++) {

            if ($_SESSION['cart'][$i]['menuID'] == $_menuID) {
                $_SESSION['cart'][$i]['menuQT'] = $_SESSION['cart'][$i]['menuQT']-2;
            }
        }
    }


    if (isset($_POST['orderID'])) {

        $_orderID = $_POST['orderID'];
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
                            WHERE '$_orderID' = bill_id 
                            AND '$_menuID' = menu_id";
                $result_check = mysqli_query($conn, $sql_check);
                $row_check = mysqli_fetch_array($result_check);

                if (mysqli_num_rows($result_check) > 0) {

                    $total_menu += $row_check['menu_total'];
                    $_menuQT += $row_check['menu_qt']; 

                    $sql_addMenu = "UPDATE order_details
                                    SET menu_qt = '$_menuQT', menu_total = '$total_menu' 
                                    WHERE '$_orderID' = bill_id 
                                    AND '$_menuID' = menu_id";
                    mysqli_query($conn, $sql_addMenu);

                } else {

                    $sql_addMenu = "INSERT INTO order_details 
                                    VALUE ('','$_orderID', '$_menuID','$_menuQT','$total_menu')";
                    mysqli_query($conn, $sql_addMenu);
                } 
            }
        }

        $sql_orderSum = "SELECT SUM(menu_total) 
                        AS orderSum 
                        FROM `order_details` 
                        WHERE '$_orderID' = bill_id";
        $result_orderSum = mysqli_query($conn, $sql_orderSum);
        $row_orderSum = mysqli_fetch_array($result_orderSum);
        $orderSum = $row_orderSum['orderSum'];

        $_insertSum = "UPDATE front 
                    SET order_price = '$orderSum' 
                    WHERE bill_id = '$_orderID'";
        mysqli_query($conn, $_insertSum);

        unset($_SESSION['cart']);
        header('location: ../index.php#order');
    }
?>