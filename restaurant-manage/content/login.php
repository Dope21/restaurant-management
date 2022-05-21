<?php 

    $message = '';
    if (isset($_GET['message'])){
        $message = $_GET['message'];
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../asset/style/main-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="shortcut icon" type="image/png" href="./favicon.svg">
    <title>Login</title>
</head>
<body>
    <main class="login"> 
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
        <form class="login__form" action="../functions/login-check.php" method="POST">
            <div class="login__title">
                <h1>Welcome,</h1>
                <p>Login to continue</p>
            </div>
            <div>
            <?php 

                if($message != ''){
                    echo '<p class="login__error">'.$message.'</p>';
                }
            
            ?>
                <div class="login__inputs">
                    <div class="login__box">
                        <input type="text" class="login__input" name="user">
                        <label for="user" class="login__label"><i class="fa-solid fa-user"></i>Username</label>
                    </div>
                    <div class="login__box">
                        <input type="password" class="login__input" name="pass">
                        <label for="pass" class="login__label"><i class="fa-solid fa-lock"></i>Password</label>
                    </div>
                </div>
                <span class="login__link"><a href="./register.php">Create an Account</a></span>
            </div>
            
            <div class="login__btn">
                <input type="submit" value="Login" name="login_btn">
            </div>
        </form>
        
    </main>
    <script>
        
        const boxes = document.querySelectorAll('.login__box')
        const inputs = document.querySelectorAll('.login__input')

            boxes.forEach((box)=>{    
                box.addEventListener('click', ()=>{
                    box.querySelector('.login__label').classList.add('login__label-active')
                })
            })
    </script>
</body>
</html>