<?php session_start() ?>
<?php 

    $_menuQT = $_POST['menu_qt'];
    $_menuID = $_POST['menu_id'];

    if(is_array($_SESSION['cart'])){
        
        $menuLast = count($_SESSION['cart']);
        $menuMark = 0;
        for ($i = 0; $i < $menuLast; $i++){
                
            if ($_SESSION['cart'][$i]['menuID'] == $_menuID){
                $_SESSION['cart'][$i]['menuQT'] += $_menuQT;
                $menuMark = 1;
            }  
        }

        if ($menuMark == 0) {
            $_SESSION['cart'][$menuLast]['menuID'] = $_menuID;
            $_SESSION['cart'][$menuLast]['menuQT'] = $_menuQT;
        }
        
        header('location: index.php?content=menu');
    
    } else {
        $_SESSION['cart'] = array();
        $_SESSION['cart'][0]['menuID'] = $_menuID;
        $_SESSION['cart'][0]['menuQT'] = $_menuQT;
        
        header('location: index.php?content=menu');
    }


?>