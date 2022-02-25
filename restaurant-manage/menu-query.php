<?php require_once('./database/connection.php') ?>
<?php 

if ($_POST['order'] == 'add'){
    //VARIABLE FOR ADD MENU
    $_name = $_POST['Name'];
    $_type = $_POST['Type'];
    $_desc = $_POST['Desc'];
    $_price = $_POST['Price'];
    $_cate = $_POST['Cate'];

    // echo $_name.'<br>';
    // echo $_type.'<br>';
    // echo $_desc.'<br>';
    // echo $_price.'<br>';
    // echo $_cate.'<br>';


    $sql = "INSERT INTO menu (menu_name, menu_type, menu_description, menu_price, cate_id) 
            VALUES ('$_name', '$_type', '$_desc', '$_price', '$_cate')";
}

if ($_POST['order'] == 'delete') {
    
    $_menuID = $_POST['deleteID'];

    $sql = "DELETE FROM menu WHERE menu_id = '$_menuID'";
}

if ($_POST['order'] == 'Update') {
    //VARIABLE FOR UPDATE
    $_menuID = $_GET['menuID'];

    $_name = $_POST['name'];
    $_type = $_POST['type'];
    $_desc = $_POST['desc'];
    $_price = $_POST['price'];
    $_cate = $_POST['cate'];
    $_image = $_FILES['image']['name'];
    $path = 'menu_img/';

    // echo $_name.'<br>';
    // echo $_type.'<br>';
    // echo $_desc.'<br>';
    // echo $_price.'<br>';
    // echo $_cate.'<br>';
    // echo $_image.'<br>';
    // echo $path.'<br>';

    if ($_image == "" ) {
        $sql = "UPDATE menu SET
                menu_name = '$_name',
                menu_type = '$_type',
                menu_description = '$_desc',
                menu_price = '$_price',
                cate_id = '$_cate'
                WHERE menu_id = '$_menuID'";
    } else {
        $sql = "UPDATE menu SET
                menu_name = '$_name',
                menu_type = '$_type',
                menu_description = '$_desc',
                menu_price = '$_price',
                cate_id = '$_cate',
                menu_image = '$_image'
                WHERE menu_id = '$_menuID'";
                copy($_FILES["image"]["tmp_name"],"$path$_image");
    }

        $result = mysqli_query($conn, $sql);
        if (!$result) {
            echo 'not working'.mysqli_error($conn) ;
        } else {

            header('location: ./index.php#menu');
            
        }

}

mysqli_query($conn, $sql);

?>