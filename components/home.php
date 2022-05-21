<section class="hero d-flex align-items-center justify-content-center flex-column text-white">
    <p>Wellcome to</p>
    <h1>CasaVega</h1>
        <a href="#address" class="hero__button border border-3 border-light rounded-pill d-flex justify-content-center">
            <span class="hero__scroll rounded-pill"></span>
        </a>
        <span class="mt-3">Scroll Down</span>
</section>

<section class="contact row container py-5" id="address">
    <div class="col-md-4">
        <i class="fas fa-map-marker-alt"></i>
        <h2>Location</h2>
        <p>soi rachaburana 23 khang rachaburana khed rachburana bangkok 10140</p>
    </div>
    <div class="col-md-4">
        <i class="fas fa-clock"></i>
        <h2>Date&Time</h2>
        <p>Tuesday - Sunday 10 AM - 11 PM Close only Monday</p>
    </div>
    <div class="col-md-4">
        <i class="fas fa-phone-alt"></i>
        <h2>Phone</h2>
        <p>573-340-5474</p>
    </div>
    <div class="col-md-12 d-flex align-items-center justify-content-center mt-5">
        <button type="button" class="btn call-btn"
        <?php 
            if($_userID == '') {
                echo 'onclick="window.location='."'./components/register.php'".'"';
            } else {
                echo 'onclick="window.location='."'./index.php?content=menu'".'"';
            }
        ?>
        >ORDER NOW</button>
    </div>
</section>

<section class="recommand text-center py-5" id="address">
    <div class="container">
        <div class="d-flex align-items-center justify-content-center flex-column">
            <h2 class="text-white">Recommanded menu</h2>
            <p class="mt-2 text-white">Lorem ipsum, dolor sit amet consectetur </p>
            <div class="recommand__line my-5"></div>
        </div>

        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            </div>
            <div class="carousel-inner overflow-visible">
                <div class="carousel-item active">
                    <?php 

                    ?>
                    <div class="recommand__cards row d-flex align-items-center gap-4 justify-content-center">
                    <?php 
                        $sql_fav = "SELECT *, SUM(order_details.menu_qt) AS menu_count 
                        FROM order_details 
                        JOIN menu 
                            ON order_details.menu_id = menu.menu_id 
                        GROUP BY menu.menu_name 
                        ORDER BY menu_count 
                        DESC LIMIT 6";
                        $rs_fav = mysqli_query($conn, $sql_fav);
                        $count = 0;
                        foreach($rs_fav as $fav) {
                    ?>
                        <div class="card menu-card col-md-4 px-0" style="width: 18rem;">
                            <img src="./restaurant-manage/asset/menu_img/<?php if($fav['menu_image'] == ''){
                                echo 'menu-defult.jpg';
                            } else {
                                echo $fav['menu_image'];
                            } ?>" class="card-img-top" alt="menu-image">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-start"><?php echo $fav['menu_name']?></h5>
                                <p class="card-subtitle text-start"><?php echo $fav['menu_type']?></p>
                                <div class="d-flex align-items-end justify-content-between mt-auto">
                                    <p class="card-text"><?php echo $fav['menu_price']?>฿</p>
                                    <a href="./index.php?content=detail&menuID=<?php echo $fav['menu_id'] ?>" class="btn card-btn">Order now</a>
                                </div>
                            </div>
                        </div>
                    <?php 
                            $count++;
                            if ($count == 3) break; 
                        }
                    ?>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="recommand__cards row d-flex align-items-center gap-4 justify-content-center">
                        <?php 
                            $sql_fav = "SELECT *, SUM(order_details.menu_qt) AS menu_count 
                                        FROM order_details 
                                        JOIN menu 
                                            ON order_details.menu_id = menu.menu_id 
                                        GROUP BY menu.menu_name 
                                        ORDER BY menu_count 
                                        ASC LIMIT 6";
                            $rs_fav = mysqli_query($conn, $sql_fav);
                            $count = 0;
                            foreach($rs_fav as $fav) {
                        ?>
                            <div class="card menu-card col-md-4 px-0" style="width: 18rem;">
                                <img src="./restaurant-manage/asset/menu_img/<?php if($fav['menu_image'] == ''){
                                    echo 'menu-defult.jpg';
                                } else {
                                    echo $fav['menu_image'];
                                } ?>" class="card-img-top" alt="menu-image">
                                <div class="card-body">
                                    <h5 class="card-title text-start"><?php echo $fav['menu_name']?></h5>
                                    <p class="card-subtitle text-start"><?php echo $fav['menu_type']?></p>
                                    <div class="d-flex align-items-end justify-content-between">
                                        <p class="card-text"><?php echo $fav['menu_price']?>฿</p>
                                        <a href="./index.php?content=detail&menuID=<?php echo $fav['menu_id'] ?>" class="btn card-btn">Order now</a>
                                    </div>
                                </div>
                            </div>
                        <?php 
                                $count++;
                                if ($count == 3) break; 
                            }
                        ?>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <div class="col-md-12 d-flex align-items-center justify-content-center mt-5">
            <button type="button" class="btn call-btn mt-5" onclick="window.location='./index.php?content=menu'">ALL MENU</button>
        </div>
    </div>
</section>

<section class="delivery my-5">
    <div class="container row align-items-center gap-4 gap-lg-0">
        <div class="delivery__img col-lg-6 p-0 overflow-hidden rounded">
                <img class="" src="./asset/food-delivery-man-with-boxes-with-food.jpg" alt="delivery">
        </div>
        <div class="col-lg-6 p-0 d-flex flex-column align-items-center">
            <div class="delivery__text rounded p-4 p-lg-5">
                <h2>Delivery Service</h2>
                <p>Lorem ipsum, dolor sit amet consectetur 
                    adipisicing elit. Incidunt, maxime! Numquam 
                    voluptates similique, velit consequuntur  
                </p>
            </div>
            <button type="button" class="btn call-btn mt-4"
                <?php 
                    if($_userID == '') {
                        echo 'onclick="window.location='."'./components/register.php'".'"';
                    } else {
                        echo 'onclick="window.location='."'./index.php?content=menu'".'"';
                    }
                ?>
            >ORDER NOW</button>
        </div>
    </div>
</section>

<section class="invite text-white">
    <div class="container row align-items-center gap-4 gap-md-0">
        <div class="col-md-6 invite__info">
            <h2>Login for more service</h2>
            <p>Lorem ipsum, dolor sit amet consectetur 
                adipisicing elit. Incidunt, maxime! Numquam 
                voluptates similique, velit consequuntur  
            </p>
        </div>
        <div class="col-md-6 invite__action d-flex flex-column align-items-center justify-content-center">
            <p>Don’t have an account yet?</p>
            <a href="./components/register.php">Register now</a>
        </div>
    </div>
</section>