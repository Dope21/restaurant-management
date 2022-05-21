<div class="menu container pb-5">
    <div class="menu__search d-flex align-items-center gap-3 justify-content-end mt-4 mt-lg-5">
        <input type="text" name="menu-name" placeholder="search menu name...">
        <button id="searchMenu" class="menu__search-btn btn call-btn border-0 "><i class="fas fa-search"></i></button>
    </div>
    <div class="menu__filter d-flex flex-wrap align-items-center gap-2 gap-sm-3 mt-4">
        <div class="menu__filter-box menu__filter-box-active" data-id="all">
            All
        </div>
    <?php 
        $filter = "SELECT * FROM category";
        $rs_filter = mysqli_query($conn, $filter);
        
        foreach($rs_filter as $cate) {
            echo '<div class="menu__filter-box" data-id='.$cate['cate_id'].'>'.$cate['cate_name'].'</div>';
        }
    ?>
    </div>
    <div class="menu__items mt-4 d-flex flex-wrap gap-2 gap-sm-3 justify-content-center">
        <?php 
        
            $sql_menu = "SELECT * FROM menu";
            $rs_menu = mysqli_query($conn, $sql_menu);

            foreach($rs_menu as $menu) {
        ?>
            <div class="card menu-card col-md-4 px-0" style="width: 18rem;">
                <img src="./restaurant-manage/asset/menu_img/<?php if($menu['menu_image'] == ''){
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
    </div>
</div>
