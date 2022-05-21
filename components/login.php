<?php 
    $error = '';
    if (isset($_GET['error'])) {
        $error = $_GET['error'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="../asset/bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/606f13a45a.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../asset/style/main.css">
    <link rel="shortcut icon" type="image/png" href="./asset/fav-icon.png">
    <title>Casa Vega</title>
</head>
<body>
    <div class="login d-flex align-items-center justify-content-center">
        <form class=" d-flex flex-column align-items-center w-100" action="../functions/login-check.php" method="POST">
            <h1 class="login__logo">CasaVega</h1>
            <p class="login__title mb-5 mt-3">login to continue</p>
            <?php 

                if($error != '') {
            
                    echo '<p class="text-danger mb-2">'.$error.'</p>';
                }
            
            ?>
            <div class="login__inputs d-flex flex-column align-items-center gap-3 gap-md-4">
                <div class="login__box">
                    <label for="user" class="login__label">Username</label>
                    <input type="text" class="login__input" name="user" require>
                </div>
                <div class="login__box">
                    <label for="pass" class="login__label">Password</label>
                    <input type="password" class="login__input" name="pass" require>
                </div>

                <div class="login__button position-relative">
                    <input class="position-absolute top-0 w-100 h-100" type="submit" name="login-button">
                    <span class="w-100 d-flex align-content-center justify-content-between px-3">
                        Proceed
                        <i class="fas fa-long-arrow-alt-right ms-auto mt-1"></i>
                    </span>
                </div>
                <a href="../components/register.php" class="text-decoration-none align-self-end mt-2">Create an Account</a>
            </div>
        </form>
    </div>
        

</body>
</html>