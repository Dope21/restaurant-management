<?php session_start() ?>
<?php 

    // print_r($_SESSION['cart'])

    $_menuID = $_GET['menuID'];
    $menuLast = count($_SESSION['cart']);

    for ($i = 0; $i < $menuLast; $i++){
        
        if ($_SESSION['cart'][$i]['menuID'] == $_menuID) {
            $_SESSION['cart'][$i]['menuQT'] = 0;
        } 
    }

    header('location: ../index.php?content=cart');
?>