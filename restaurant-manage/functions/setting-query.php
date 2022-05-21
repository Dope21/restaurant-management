<?php require_once("../database/connection.php") ?>
<?php 

    $_serv = $_POST['serv'];
    $_deliver = $_POST['deliver'];
    $_vat = $_POST['vat'];

    $sql = "UPDATE setting
            SET set_serv = '$_serv',
                set_deliver = '$_deliver',
                set_vat = '$_vat'";

    mysqli_query($conn, $sql);

?>