<nav class="navbar navbar-expand-lg navbar-light bg-light p-0 position-fixed w-100">
    <div class="container-fluid nav-wrapper">
        <a class="navbar-brand" href="./index.php?content=home">Books</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarScroll">
            <div class="ms-auto"></div>
            <ul class="navbar-nav m-0 my-2 my-lg-0 align-items-center gap-3 pb-4 pb-lg-0">
                <li class="nav-item">
                    <a class="nav-link 
                        <?php 
                            if($content == 'home' || $content == '') {
                                echo 'nav-active';
                            } 
                        ?>" 
                        href="./index.php?content=home">HOME
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link 
                        <?php 
                            if($content == 'menu') {
                                echo 'nav-active';
                            } 
                        ?>" 
                        href="./index.php?content=menu">MENU
                    </a>
                </li>
                <li class="nav-item d-flex align-items-center position-relative">
                    <a class="nav-link
                        <?php 
                            if($content == 'cart') {
                                echo 'nav-active';
                            } 
                        ?>" 
                        href="./index.php?content=cart">CART
                    </a>
                    <?php 
                        $cart_count = 0;
                        if (isset($_SESSION['cart'])) {
                            
                            for ($i = 0; $i < count($_SESSION['cart']); $i++) {

                                if ($_SESSION['cart'][$i]['menuID'] != '' && $_SESSION['cart'][$i]['menuQT'] != 0) {
                                    $cart_count += $_SESSION['cart'][$i]['menuQT'];
                                }
                            }
                            if ($cart_count > 0) {
                                echo '<span class="nav__cart ms-2 rounded-circle d-flex align-items-center justify-content-center">'.$cart_count.'</span>';
                            }
                        }
                    ?>
                </li>

                <?php 
                    if ($_userID != '') {
                        
                ?>
                <li class="nav-item">
                    <a class="nav-link 
                        <?php 
                            if($content == 'order') {
                                echo 'nav-active';
                            } 
                        ?>" 
                        href="./index.php?content=order">ORDER
                    </a>
                </li>
                <li class="nav-item dropdown nav-profile d-flex">
                    <img src="./restaurant-manage/cus_img/<?php if ($row['cus_image'] == ''){
                        echo 'user-defult.png';
                    } else {
                        echo $row['cus_image'];
                    } ?>"
                    alt="profile-image" class="rounded-pill">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo $row['cus_username'] ?>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
                        <li><a class="dropdown-item" href="./index.php?content=profile"><i class="fas fa-user-cog me-2"></i>Setting</a></li>
                        <li><a class="dropdown-item" href="./logout.php"><i class="fas fa-door-open me-2"></i>Logout</a></li>
                    </ul>
                </li>
                <?php
                    } else {
                ?>
                <li class="nav-item">
                    <a class="nav-link login-button rounded-pill px-4" href="./login.php" tabindex="-1" aria-disabled="true">LOGIN</a>
                </li>
                <?php 
                    }
                ?>
            </ul>
        </div>
    </div>
</nav>