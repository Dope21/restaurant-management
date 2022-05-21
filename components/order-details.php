<?php 
    $billID = $_GET['orderID'];

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
<!-- Modal -->
<div class="modal fade" id="received" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Received Order</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Have you received your order?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <a href="../functions/order-received.php?orderID=<?php echo $billID ?>" class="btn call-btn">Yes</a>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="cancel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Cancel Order</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <?php 
            if($rowDetail['order_status'] != 'waiting'){
                echo "This order has been taken now. If you want anything else please call 573-340-5474.";
            } else {
                echo 'Are you sure you want to cancel this order?';
            }
          ?>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <?php 
            if($rowDetail['order_status'] != 'waiting'){
                echo '<button type="button" class="btn call-btn" data-bs-dismiss="modal">Yes</button>';
            } else {
                echo '<a href="./functions/order-cancel.php.php?orderID='.$billID.'" class="btn call-btn">Yes</a>';
            }
          ?>  
      </div>
    </div>
  </div>
</div>
<div class="container py-5">
    <div class="bill mt-5">
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
                    <p>Payment</p>
                    <p>
                        <?php 
                            if ($rowDetail['order_payment'] == "") {
                                echo 'unpaid'; 
                            } else {
                                echo '<span class="order__pay">paid</span>';
                            }  
                        ?>       
                    </p>
                    </div>
                    <div class="bill__details-list">
                        <p>Time</p>
                        <p>
                            <?php echo substr($rowDetail['order_time'],0,5) ?>
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
                    <p>Subtotal</p>
                    <?php 
                        $sql_orderSum = "SELECT SUM(menu_total) 
                                        AS orderSum 
                                        FROM `order_details` 
                                        WHERE '$billID' = bill_id";
                        $result_orderSum = mysqli_query($conn, $sql_orderSum);
                        $row_orderSum = mysqli_fetch_array($result_orderSum);
                        $_orderSum = $row_orderSum['orderSum'];
                    ?>
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
                        <?php 
                            echo $rowDetail['order_price'];
                        ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="bill__button not-print">
            <button type="button" id="statusBtn"  data-bs-toggle="modal" data-bs-target="#received">Recived</button>
            <button type="button" id="cancelBtn" data-bs-toggle="modal" data-bs-target="#cancel">Cancel</button>
        </div>
    </div>
</div>