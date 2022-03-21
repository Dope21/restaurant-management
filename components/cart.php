<div class="cart container pb-5">
    <div class="cart__confirm mt-4 mt-lg-5 d-flex align-items-center justify-content-end gap-4">
        <div class="cart__number d-flex align-items-center">
            <span class="me-3 rounded-circle d-flex align-items-center justify-content-center">
                <?php 
                        
                    $cart_count = 0;
                    if (isset($_SESSION['cart'])) {
                        for ($i = 0; $i < count($_SESSION['cart']); $i++) {

                            if ($_SESSION['cart'][$i]['menuID'] != '' && $_SESSION['cart'][$i]['menuQT'] != 0) {
                                $cart_count += $_SESSION['cart'][$i]['menuQT'];
                            }
                        }
                    }
                    echo $cart_count;
                ?>
            </span>
            items
        </div>
        <?php 
            if ($_userID == '') {
        ?>
            <button class="btn call-btn" onclick="window.location='./login.php'">Confirm Order</button>
        <?php 
            }  else {
        ?>
            <button class="btn call-btn" onclick="window.location='./cart-confirm.php'">Confirm Order</button>
        <?php 
            }
        ?>
    </div>
    <div class="cart__items mt-4">

    <?php 
        $counter = 0;
    if (isset($_SESSION['cart'])) {

        $counter = count($_SESSION['cart']);

        for ($i = 0; $i < $counter; $i++) {
            
            if ($_SESSION['cart'][$i]['menuID'] != '' && $_SESSION['cart'][$i]['menuQT'] != 0) {
                $_menuID = $_SESSION['cart'][$i]['menuID'];
            
                $sql_cart = "SELECT * FROM menu WHERE menu_id = '$_menuID'";
                $rs_cart = mysqli_query($conn, $sql_cart);
                $row_cart = mysqli_fetch_array($rs_cart);
    ?>
        <div class="cart__menu d-flex align-items-end justify-content-between mb-2">
            <div class="cart__menu-detail d-flex align-items-center gap-3">
                <div class="cart__menu-img">
                    <img src="./restaurant-manage/menu_img/<?php if($row_cart['menu_image'] == ''){
                    echo 'menu-defult.jpg';
                } else {
                    echo $row_cart['menu_image'];
                } ?>" alt="">
                </div>
                <div>
                    <p class="cart__menu-name"><?php echo $row_cart['menu_name'] ?></p>
                    <p class="cart__menu-type mb-sm-3"><?php echo $row_cart['menu_type'] ?></p>
                    x<input type="number" value="<?php echo $_SESSION['cart'][$i]['menuQT'] ?>" name="menu_qt" class="w-25 text-center ms-2" min="1">
                </div>
            </div>
            <div class="cart__menu-price d-flex align-items-center">
                <p><?php echo $_SESSION['cart'][$i]['menuQT']*$row_cart['menu_price'] ?></p>
                <a href="./cart-remove.php?menuID=<?php echo $_menuID ?>"><i class="fas fa-trash-alt"></i></a>
            </div>
        </div>
    <?php 
            }
        }
    }
    ?>
    
        
    </div>
    <?php 
        $setting = "SELECT * FROM setting";
        $rs_setting = mysqli_query($conn, $setting);
        $row_set = mysqli_fetch_array($rs_setting);

        $total = 0;
        for ($i = 0; $i < $counter; $i++) {
            if ($_SESSION['cart'][$i]['menuID'] != '' && $_SESSION['cart'][$i]['menuQT'] != 0) {
                $_menuID = $_SESSION['cart'][$i]['menuID'];
            
                $sql_cart = "SELECT * FROM menu WHERE menu_id = '$_menuID'";
                $rs_cart = mysqli_query($conn, $sql_cart);
                $row_cart = mysqli_fetch_array($rs_cart);

                $total += $_SESSION['cart'][$i]['menuQT']*$row_cart['menu_price'];
            }
        }

        if ($cart_count > 0 ){
    ?>
    <div class="cart__total mt-5 d-flex align-items-center flex-column">
        <div class="cart__total-serv d-flex align-items-center justify-content-between w-100">
            <p>VAT</p>
            <p><?php echo $row_set['set_vat'] ?> %</p>
        </div>
        <div class="cart__total-serv d-flex align-items-center justify-content-between w-100">
            <p>Delivery Service</p>
            <p><?php echo $row_set['set_deliver'] ?> .-</p>
        </div>
        <div class="d-flex align-items-center justify-content-between w-100">
            <p>Total</p>
            <p><?php echo $total+$row_set['set_deliver']+($total*$row_set['set_vat']/100).' .-'; ?></p>
        </div>
    </div>
    <?php 
        } 
    ?>
    <div class="cart__button mt-3 mt-lg-5 d-flex align-items-center justify-content-center gap-3">
        <button id="cart__update" type="button">Update Cart</button>
        <button id="cart__clear" type="button" onclick="window.location='./cart-clear.php'">Clear Cart</button>
    </div>
</div>