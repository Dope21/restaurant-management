<?php require_once('./database/connection.php') ?>
<?php session_start() ?>
<?php 

    $_userID = $_SESSION['userID'];
    $sql = "SELECT * FROM customer WHERE '$_userID' = cus_id";
    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gwendolyn:wght@700&family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="./bootstrap-5.0.2-dist/css/bootstrap-grid.min.css">
    <script src="https://kit.fontawesome.com/606f13a45a.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./style/main.css?<?php echo time(); ?>">
    <link rel="shortcut icon" type="image/png" href="./asset/fav-icon.png">
    <title>Casa Vega</title>
    
</head>
<body>
    <header class="header">
        <?php include('./components/navbar.php') ?>
    </header>
    <main class="main">
        <?php

        if (isset($GET_['content'])) {
            if($_GET['content'] == 'home') {
                include('./components/home.php'); 
            } else if ($_GET['content'] == 'staff') {
                include('./components/staff.php');
            } else if ($_GET['content'] == 'detail') {
                include('./components/detail.php');
            } else if ($_GET['content'] == 'cart') {
                include('./components/cart.php');
            } else if ($_GET['content'] == 'order') {
                include('./components/order.php');
            } else if ($_GET['content'] == 'payment') {
                include('./components/payment.php');
            } else if ($_GET['content'] == 'order-details') {
                include('./components/order-details.php');
            } else if ($_GET['content'] == 'profile') {
                include('./components/profile.php');
            } else {
                include('./components/home.php'); 
            }
        } else {
            include('./components/home.php'); 
        }
            
        ?>
    </main>
    <footer class="footer">
        <?php include('./components/footer.php') ?>
    </footer>

    
    <!-- <script src="./bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- <script src="./script/jquery.js"></script> -->
    <script src="./script/main.js?<?php echo time() ?>"></script>
</body>
</html>