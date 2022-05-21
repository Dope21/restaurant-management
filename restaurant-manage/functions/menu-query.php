<?php require_once('./database/connection.php') ?>
<?php 

if ($_POST['order'] == 'add'){
    
    //VARIABLE FOR ADD MENU
    $_name = $_POST['Name'];
    $_type = $_POST['Type'];
    $_desc = $_POST['Desc'];
    $_price = $_POST['Price'];
    $_cate = $_POST['Cate'];

    $sql = "INSERT INTO menu (menu_name, menu_type, menu_description, menu_price, cate_id) 
            VALUES ('$_name', '$_type', '$_desc', '$_price', '$_cate')";
    mysqli_query($conn, $sql);
}

if ($_POST['order'] == 'delete') {
    
    $_menuID = $_POST['deleteID'];

    $sql = "DELETE FROM menu WHERE menu_id = '$_menuID'";
    mysqli_query($conn, $sql);
}

if ($_POST['order'] == 'update') {

    //VARIABLE FOR UPDATE
    $_menuID = $_GET['menuID'];

    $_name = $_POST['name'];
    $_type = $_POST['type'];
    $_desc = $_POST['desc'];
    $_price = $_POST['price'];
    $_cate = $_POST['cate'];
    $_image = $_FILES['image']['name'];
    $path = 'menu_img/';

    if ($_image == "" ) {
        $sql = "UPDATE menu SET
                menu_name = '$_name',
                menu_type = '$_type',
                menu_description = '$_desc',
                menu_price = '$_price',
                cate_id = '$_cate'
                WHERE menu_id = '$_menuID'";
    } else {

        //GET CURRENT IMAGE AN DELETE IT
        $sql_img = "SELECT * FROM menu WHERE menu_id = '$_menuID'";
        $rs_img = mysqli_query($conn, $sql_img);
        $row_img = mysqli_fetch_array($rs_img);
        $menu_img = $row_img['menu_image'];
        unlink($path.$menu_img);


        $sql = "UPDATE menu SET
                menu_name = '$_name',
                menu_type = '$_type',
                menu_description = '$_desc',
                menu_price = '$_price',
                cate_id = '$_cate',
                menu_image = '$_image'
                WHERE menu_id = '$_menuID'";
                copy($_FILES["image"]["tmp_name"],$path.$_image);
    }

        $result = mysqli_query($conn, $sql);
        if (!$result) {
            echo 'not working'.mysqli_error($conn) ;
        } else {

            header('location: ./index.php#menu');   
    }
}


?>