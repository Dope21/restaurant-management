<?php session_start() ?>
<?php 

    $_menuQT = $_POST['cartQt'];
    $newCount = count($_menuQT);
    $menuCount = count($_SESSION['cart']);
    $counter = 0;

    for ($i = 0; $i < $menuCount; $i++){
        
        if ($_SESSION['cart'][$i]['menuQT'] != 0) {
            $_SESSION['cart'][$i]['menuQT'] = $_menuQT[$counter];
            $counter += 1;
        }
    }

    print_r($_SESSION['cart'])
?>