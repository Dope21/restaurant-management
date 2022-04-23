<?php require_once('../database/connection.php') ?>
<?php

$billID = $_POST['orderID'];

$sqlDetail = "SELECT * FROM front WHERE bill_id = '$billID'";
$resultDetail = mysqli_query($conn, $sqlDetail);
$rowDetail = mysqli_fetch_array($resultDetail);

$sqlMenu = "SELECT * 
            FROM `order_details` 
            INNER JOIN `menu` 
            ON order_details.menu_id = menu.menu_id
            WHERE bill_id = '$billID'";
$resultMenu = mysqli_query($conn, $sqlMenu);

$sqlSet = "SELECT * FROM setting";
$resultSet = mysqli_query($conn, $sqlSet);
$rowSet = mysqli_fetch_array($resultSet);

?>
<div class="order">
    <a href="#order" class="menu__update-back"><i class="fas fa-arrow-left"></i>Back to order</a>
    <div class="bill" id="bill">
        <div class="bill__head">
            <p class="bill__head-total">Receipt</p>
            <div class="bill__head-number">
                <span>Number</span>
                <p><?php echo $billID ?></p>
            </div>
            <div class="bill__line"></div>
        </div>
        <div class="bill__details">
            <div class="bill__detail-order">
                <p class="bill__details-title">Details</p>
                <div class="bill__details-list">
                    <p>Name</p>
                    <p><?php echo $rowDetail['order_name'] ?></p>
                </div>
                <div class="bill__details-list">
                    <p>Type</p>
                    <p><?php echo $rowDetail['order_cate'] ?></p>
                </div>
                <div class="bill__details-list">
                    <p>Time</p>
                    <p>
                        <?php echo $rowDetail['order_time'] ?>
                        <?php echo $rowDetail['order_date'] ?>
                    </p>
                </div>
            </div>
            <div class="bill__line"></div>
            <div class="bill__details-items">
                <p class="bill__details-title">Food items</p>
                <?php 
                    foreach($resultMenu as $rowMenu) {
                ?>
                <div class="bill__details-list bill__menu" data-id="<?php echo $rowMenu['menu_id'] ?>" >
                    <p>
                        <?php echo $rowMenu['menu_name'].' '.$rowMenu['menu_type'].' '.'x'.$rowMenu['menu_qt']?>
                    </p>
                    <p>
                        <?php echo $rowMenu['menu_total'] ?>
                    </p>
                </div>
                <?php 
                    }
                ?>
            </div>
            <div class="bill__line"></div>  
            <div class="bill__details-price">
                <p class="bill__details-title">Price</p>
                <div class="bill__details-list">
                    <p>Subtotal</p>
                    <p><?php echo $rowDetail['order_price'] ?></p>
                </div>
                <div class="bill__details-list">
                    <p>Service Charge</p>
                    <p><?php echo $rowSet['set_serv'] ?></p>
                </div>
                <div class="bill__details-list">
                    <p>VAT</p>
                    <p><?php echo $rowSet['set_vat'] ?>%</p>
                </div>
                <div class="bill__details-total">
                    <p>Total</p>
                    <p class="total">
                        <?php 
                            echo $rowDetail['order_price']+
                                (($rowDetail['order_price']*$rowSet['set_vat'])/100)+
                                $rowSet['set_serv']
                        ?>
                    </p>
                </div>
            </div>
            <?php
                $_receive = "";
                $_change = "";
                if (isset($_POST['receive'])){
                    $_receive = $_POST['receive'];
                    $_change = $_POST['change'];

            ?>
                <div class="bill__line"></div>
                <div class="bill__details-change pay">
                    <div class="bill__details-list">
                        <p>receive</p>
                        <p><?php echo $_receive ?></p>
                    </div>
                    <div class="bill__details-list">
                        <p>change</p>
                        <p><?php echo $_change ?></p>
                    </div>
                </div>
            <?php 
                }
            ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(()=>{
        
        if ($('.pay').length) {
            const total = Number($('.total').text())
            $.ajax({
                url : './order-query.php',
                type: 'post',
                data: { 

                    orderID: '<?php echo $billID ?>',
                    total: total,
                    order: 'pay',
                    receive: '<?php echo $_receive ?>',
                    change: '<?php echo $_change ?>'

                },
                success: function(response){
                    window.print();
                }
            })
        } else {
            window.print();
        }
    })
</script>