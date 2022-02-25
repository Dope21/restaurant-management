<?php require_once('../database/connection.php') ?>
<?php 

        $_name = $_POST['name'];
        
        $sql_menu = "SELECT * FROM menu WHERE menu_name LIKE '%$_name%'";
        $rs_menu = mysqli_query($conn, $sql_menu);

        foreach($rs_menu as $menu) {
    ?>
        <div class="card menu-card col-md-4 px-0" style="width: 18rem;">
            <img src="../restaurant_manage/menu_img/<?php if($menu['menu_image'] == ''){
                echo 'menu-defult.jpg';
            } else {
                echo $menu['menu_image'];
            } ?>" class="card-img-top" alt="menu-image">
            <div class="card-body">
                <h5 class="card-title text-start"><?php echo $menu['menu_name']?></h5>
                <p class="card-subtitle text-start"><?php echo $menu['menu_type']?></p>
                <div class="d-flex align-items-end justify-content-between">
                    <p class="card-text"><?php echo $menu['menu_price']?>฿</p>
                    <a href="./index.php?content=detail&menuID=<?php echo $menu['menu_id'] ?>" class="btn card-btn">Detail</a>
                </div>
            </div>
        </div>
    <?php 
        }
    ?>