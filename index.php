<?php require_once('./database/connection.php') ?>
<?php session_start() ?>
<?php 

    $_userID = '';
    if (isset($_SESSION['userID'])) {
        $_userID = $_SESSION['userID'];
        $sql = "SELECT * FROM customer WHERE '$_userID' = cus_id";
        $query = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($query);
    }
    
    $content = '';
    if (isset($_GET['content'])){
        $content = $_GET['content'];
    }
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
    <link rel="stylesheet" href="./asset/bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/606f13a45a.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./asset/style/main.css?<?php echo time(); ?>">
    <link rel="shortcut icon" type="image/png" href="./asset/fav-icon.png">
    <title>Casa Vega</title>
    
</head>
<body>

    <header class="header">
        <?php include('./components/navbar.php') ?>
    </header>
    <main class="main">
        <?php
            if ($content == '') {
                include('./components/home.php');
            } else {
                include('./components/'.$content.'.php');
            } 
        ?>
    </main>
    <footer class="footer">
        <?php include('./components/footer.php') ?>
    </footer>

    <script src="./asset/bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="./asset/script/main.js?<?php echo time() ?>"></script>
</body>
</html>