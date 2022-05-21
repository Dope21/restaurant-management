<?php require_once('./database/connection.php') ?>
<?php 

if ($_POST['order'] == 'add'){
    //VARIABLE FOR ADD USER
    $_catename = $_POST['Catename'];

    $sql = "INSERT INTO category (cate_name) 
            VALUES ('$_catename')";
}

if ($_POST['order'] == 'delete') {
    
    $_cateID = $_POST['deleteID'];

    $sql = "DELETE FROM category WHERE cate_id = '$_cateID'";
}

if ($_POST['order'] == 'Update') {
    //VARIABLE FOR UPDATE
    $_cateID = $_GET['cateID'];
    $_catename = $_POST['catename'];

    $sql = "UPDATE category SET cate_name = '$_catename' WHERE cate_id = '$_cateID'";

        $result = mysqli_query($conn, $sql);
        if (!$result) {
            echo 'not working'.mysqli_error($conn) ;
        } else {
            header('location: ./index.php#category');
        }

}

mysqli_query($conn, $sql);

?>