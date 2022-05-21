<?php 

    $_menuID = $_GET['menuID'];

    $sql = "SELECT * FROM menu WHERE menu_id = '$_menuID'";
    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($query);
?>
<div class="detail container row pb-5">
    <div class="col-lg-6 d-flex align-items-center justify-content-center mt-4 mt-lg-5">
        <div class="detail__img">
            <img src="./restaurant-manage/asset/menu_img/<?php if($row['menu_image'] == ''){
                    echo 'menu-defult.jpg';
                } else {
                    echo $row['menu_image'];
                } ?>" alt="menu-image">
        </div>
    </div>
    <div class="col-lg-6 mt-5">
        <h2 class="detail__name"><?php echo $row['menu_name'] ?></h2>
        <p class="detail__type mb-3 mb-lg-5"><?php echo $row['menu_type'] ?></p>
        <p class="detail__desc mb-4"><?php echo $row['menu_description'] ?></p>
        <span class="detail__price">฿ <?php echo $row['menu_price'] ?></span>
        
        <form class="d-flex align-items-center mt-4 gap-4" action="./functions/cart-add.php" method="POST">
                <div class="detail__qt d-flex align-items-center justify-content-between">
                    <i class="fas fa-minus" id="minus"></i>
                    <span class="detail__qt-number">0</span>
                    <input type="hidden" id="menuQt" value="0" name="menu_qt">
                    <i class="fas fa-plus" id="plus"></i>
                </div>
                <button class="detail__add btn call-btn">
                    <input type="submit" name="menu_id" value="<?php echo $_menuID ?>">
                    Add to Cart
                    <i class="fas fa-cart-plus ms-3"></i>
                </button>
        </form>
    </div>
</div>