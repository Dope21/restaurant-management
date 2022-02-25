<div class="order container pb-5">
    <div class="order__items d-flex flex-column align-items-center gap-3 mt-4 mt-lg-5">
    <?php 
        
        $sql_order = "SELECT * 
                      FROM delivery 
                      WHERE cus_id = '$_userID'
                      AND order_status != 'received'";
        $rs_order = mysqli_query($conn, $sql_order);

        if (mysqli_num_rows($rs_order) > 0) {

            foreach($rs_order as $order) {
    ?>
        <div class="order__item">
                <div class="order__id">
                    <p><?php echo $order['bill_id'] ?></p>
                </div>

                <div class="order__time">
                    <p><?php echo substr($order['order_time'],0,5) ?></p>
                </div>

                <div class="order__price">
                    <p><?php echo $order['order_price'] ?> .-</p>
                </div>

                <div class="order__pay">
                    <a href="./index.php?content=payment&orderID=<?php echo $order['bill_id'] ?>">Upload Payment</a>
                </div>

                <div class="order__details">
                    <a href="./index.php?content=order-details&orderID=<?php echo $order['bill_id'] ?>">Details</a>
                </div>

                <div class="order__status">
                    <p><?php echo $order['order_status'] ?>...</p>
                </div>
            
                
            
        </div>
    <?php 
            }
        } else {
    ?>
        <p>There are no order.</p>
    <?php 
        }
    ?>
    </div>
</div>