<?php 

    $ms_user = '';
    $ms_pass = '';

    if (isset($_GET['ms_user'])) {
        $ms_user = $_GET['ms_user'];
    }
    if (isset($_GET['ms_pass'])) {
        $ms_pass = $_GET['ms_pass'];
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../asset/bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/606f13a45a.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./asset/style/main.css">
    <link rel="shortcut icon" type="image/png" href="./asset/fav-icon.png">
    <title>Casa Vega</title>
</head>
<body>
    <div class="register">
        <form class=" d-flex flex-column align-items-center py-5" action="../functions/register-check.php" method="POST">
            <h1 class="register__title">Create Your Account</h1>

            <div class="register__inputs d-flex flex-column align-items-center gap-4">
                <div class="register__box">
                    <label for="username" class="register__label">Username</label>
                    <input type="text" class="register__input" name="user" minlength="8" maxlength="20" placeholder="8-20 characters" require>
                </div>
                <?php 
                    if ($ms_user != '') {
                        echo $ms_user;
                    }
                ?>
                <div class="register__box">
                    <label for="password" class="register__label">Password</label>
                    <input type="password" class="register__input" name="pass" minlength="8" maxlength="20" placeholder="8-20 characters" require>
                </div>
                <div class="register__box">
                    <label for="password" class="register__label">Confirm password</label>
                    <input type="password" class="register__input" name="check-pass" minlength="8" maxlength="20" require>
                </div>
                <?php 
                    if ($ms_pass != '') {
                        echo $ms_pass;
                    }
                ?>

                <div class="d-flex justify-content-between flex-column flex-sm-row gap-4 gap-sm-0 register__inline">
                    <div class="register__box">
                        <label for="fname" class="register__label">Firstname</label>
                        <input type="text" class="register__input" name="fname" require>
                    </div>
                    <div class="register__box">
                        <label for="lname" class="register__label">lastname</label>
                        <input type="text" class="register__input" name="lname" require>
                    </div>
                </div>

                <div class="register__box register__address">
                    <label for="address" class="register__label">Address</label>
                    <textarea  class="register__input" name="address" id="" cols="30" rows="10"></textarea>
                </div>
                <div class="register__box">
                    <label for="number" class="register__label">Number</label>
                    <input type="number" class="register__input" name="number" maxlength="10" require>
                </div>

                <div class="register__button position-relative">
                    <input class="position-absolute top-0 w-100 h-100" type="submit" name="register-button">
                    <span class="w-100 d-flex align-content-center justify-content-between px-3">
                        Proceed
                        <i class="fas fa-long-arrow-alt-right ms-auto mt-1"></i>
                    </span>
                </div>
            </div>
        </form>
    </div>
</body>
</html>