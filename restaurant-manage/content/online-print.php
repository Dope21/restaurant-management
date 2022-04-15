<?php require_once('../database/connection.php') ?>
<?php 
    $billID = $_POST['billID'];

    $sqlDetail = "SELECT * 
                    FROM delivery
                    INNER JOIN customer
                    ON delivery.cus_id = customer.cus_id 
                    WHERE bill_id = '$billID'";
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
    <a href="#online" class="menu__update-back"><i class="fas fa-arrow-left"></i>Back to order</a>
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
                    <p><?php echo $rowDetail['cus_fname'] ?></p>
                </div>
                <div class="bill__details-list not-print">
                    </div>
                    <div class="bill__details-list">
                        <p>Time</p>
                        <p>
                            <?php echo $rowDetail['order_time'] ?>
                            <?php echo $rowDetail['order_date'] ?>
                        </p>
                    </div>
                    
                    <div class="bill__details-list">
                        <p>Address</p>
                        <p><?php echo $rowDetail['cus_address'] ?></p>   
                    </div>

                    <div class="bill__details-list">
                        <p>Phone</p>
                        <p><?php echo $rowDetail['cus_number'] ?></p>   
                    </div>
                </div>
            <div class="bill__line"></div>

            <div class="bill__details-items">
                <p class="bill__details-title">Food items</p>
                <?php 
                    foreach($resultMenu as $rowMenu) {
                ?>
                <div class="bill__details-list">
                    <p><?php echo $rowMenu['menu_name'].' '.'x'.' '.$rowMenu['menu_qt']?></p>
                    <p><?php echo $rowMenu['menu_total'] ?></p>
                </div>
                <?php 
                    }
                ?>
            </div>
            <div class="bill__line"></div>
            <div class="bill__details-price">
                <p class="bill__details-title">Price</p>
                <div class="bill__details-list">
                <?php 
                    $sql_orderSum = "SELECT SUM(menu_total) 
                                    AS orderSum 
                                    FROM `order_details` 
                                    WHERE '$billID' = bill_id";
                    $result_orderSum = mysqli_query($conn, $sql_orderSum);
                    $row_orderSum = mysqli_fetch_array($result_orderSum);
                    $_orderSum = $row_orderSum['orderSum'];
                ?>
                    <p>Subtotal</p>
                    <p><?php echo $_orderSum ?></p>
                </div>
                <div class="bill__details-list">
                    <p>Deliver Charge</p>
                    <p><?php echo $rowSet['set_deliver'] ?></p>
                </div>
                <div class="bill__details-list">
                    <p>VAT</p>
                    <p><?php echo $rowSet['set_vat'] ?>%</p>
                </div>
                <div class="bill__details-total">
                    <p>Total</p>
                    <p>
                        <?php echo $rowDetail['order_price'] ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(()=>{
        window.print()
    })
</script>