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
<div class="bill">
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
        <?php 
            if ($rowDetail['order_status'] != 'received') {

        ?>
        <button type="button" id="statusBtn" data-id="<?php echo $billID ?>" data-status="<?php echo $rowDetail['order_status']?>">
            <?php if($rowDetail['order_status'] == 'waiting') { echo 'Take'; } if($rowDetail['order_status'] == 'cooking') {echo 'Delivering';} if($rowDetail['order_status'] == 'delivering') {echo 'Delivering...';}?>
        </button>
        <button type="button" id="cancelBtn">Cancel</button>
        <?php 
            }
        ?>
    </div>
</div>
<script>
    $(document).ready(()=>{
        const module = $('.module'),
              moduleBg = $('.module__bg'),
              moduleAsk = $('.module__ask'),
              askSumit = $('.module__ask-submit'),
              askCancel = $('.module__ask-cancel'),
              moduleDelete = $('.module__delete'),
              deleteSumit = $('.module__delete-submit'),
              deleteCancel = $('.module__delete-cancel'),
              content = $('.content')

        const statusBtn = $('#statusBtn'),
              cancelBtn = $('#cancelBtn'),
              payment = $('.order__pay')

        statusBtn.click(()=>{
            if (statusBtn.data('status') == 'delivering') {
                return
            } else {
                module.addClass('module-active')
                moduleBg.addClass('module__bg-active')
                moduleAsk.addClass('module__ask-active')
                console.log(statusBtn.text())
                if (statusBtn.data('status') == 'cooking') {
                    $('.module__ask-text').text('Deliver this order?')
                }
            }
        })

        askSumit.click(()=>{
            $.ajax({
                url : './functions/online-query.php',
                type: 'post',
                data: { 

                    orderID: statusBtn.data('id'),
                    order: 'take'
                
                },
                success: function(response){
                    content.load('./content/online-print.php',{
                        billID: '<?php echo $billID ?>'
                    })   
                }
            })
        })

        askCancel.click(()=>{
            module.removeClass('module-active')
            moduleBg.removeClass('module__bg-active')
            moduleAsk.removeClass('module__ask-active')
        })

        cancelBtn.click(()=>{
            module.addClass('module-active')
            moduleBg.addClass('module__bg-active')
            moduleDelete.addClass('module__ask-active')
        })

        deleteSumit.click(()=>{
            $.ajax({
                url : './functions/online-query.php',
                type: 'post',
                data: { 

                    orderID: statusBtn.data('id'),
                    order: 'cancel'
                
                },
                success: function(response){
                    module.removeClass('module-active')
                    moduleBg.removeClass('module__bg-active')
                    moduleDelete.removeClass('module__delete-active')
                    content.load('./content/online.php')
                }
            })
        })

        deleteCancel.click(()=>{
            module.removeClass('module-active')
            moduleBg.removeClass('module__bg-active')
            moduleDelete.removeClass('module__ask-active')
        })

        payment.click(()=>{
            content.load('./content/payment.php',{
                billID: '<?php echo $billID ?>'
            })
        })

        
        
    })
</script>