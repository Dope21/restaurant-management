<?php 

    $muser = '';
    $mpass = '';
    if (isset($_GET['muser'])){
        $muser = $_GET['muser'];
    }
    if (isset($_GET['mpass'])){
        $mpass = $_GET['mpass'];
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/main-style.css?<?php echo time(); ?>">
    <link rel="shortcut icon" type="image/png" href="./favicon.svg">
    <title>Register</title>
</head>
<body>
    <main class="regis">
        <div class="bubbles">
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>     
        </div>

        <form action="./register-check.php" method="POST" class="regis__form">
            <div class="regis__title">
                <h1>CREATE YOUR ACCOUNT</h1>
            </div>

            <div class="regis__inputs">
                <div class="regis__box">
                    <label for="username" class="regis__label">Username</label>
                    <input type="text" name="username" minlength="8" maxlength="20" placeholder="Username" class="regis__input">
                </div>
                <?php 
                    if ($muser != '') {
                        echo '<p class="regis__error">'.$muser.'</p>';
                    }
                ?>
                <div class="regis__box">
                    <label for="password" class="regis__label">Password</label>
                    <input type="password" name="password" minlength="8" maxlength="20" placeholder="Password" class="regis__input">
                </div>
                <div class="regis__box">
                    <label for="password-check" class="regis__label">Confirm password</label>
                    <input type="password" name="password-check" minlength="8" maxlength="20" placeholder="Confirm your password" class="regis__input">
                </div>
                <?php 
                    if ($mpass != '') {
                        echo '<p class="regis__error">'.$mpass.'</p>';
                    }     
                ?>
                <div class="regis__box regis__inline">
                    <div>
                        <label for="fname" class="regis__label">Firstname</label>
                        <input type="text" name="fname" placeholder="Firstname" class="regis__input">
                    </div>
                    <div>
                        <label for="lname" class="regis__label">Lastname</label>    
                        <input type="text" name="lname" placeholder="Lastname" class="regis__input">    
                    </div>
                </div>
                <div class="regis__box">
                    <label for="address" class="regis__label">Address</label>
                    <textarea name="address" placeholder="Address" class="regis__input"></textarea>
                </div>
                <div class="regis__box">
                    <label for="number" class="regis__label">Number</label>
                    <input 
                        type="text" placeholder="Number" pattern="[0-9]+"
                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" 
                        maxlength="10" minlength="10"
                        class="regis__input"
                        name="number"
                    >
                </div>
            </div>

            <div class="regis__btn">
                <input type="submit" value="Confirm">
            </div>
        </form>
    </main>
</body>
</html>