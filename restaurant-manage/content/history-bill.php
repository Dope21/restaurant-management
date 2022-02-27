<?php session_start() ?>
<?php require_once('../database/connection.php') ?>
<?php 
    $_billID = $_POST['billID'];

    if (substr($_billID,0,1) != 'D') {
        $sqlDetaill = "SELECT * FROM front WHERE '$_billID' = bill_id";

        $resultDetail = mysqli_query($conn, $sqlDetaill);
        $rowDetail = mysqli_fetch_array($resultDetail);

        $sqlMenu = "SELECT * 
                    FROM `order_details` 
                    INNER JOIN `menu` 
                    ON order_details.menu_id = menu.menu_id
                    WHERE bill_id = '$_billID'";
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
            <p><?php echo $_billID ?></p>
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
                    <?php echo substr($rowDetail['order_time'],0,5) ?>
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
                    <?php echo $rowMenu['menu_name'].$rowMenu['order_name'].' '.'x'.$rowMenu['menu_qt']?>
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
                <p class="total"><?php echo $rowDetail['order_price'];?>
                </p>
            </div>
        </div>
        <?php
        
            if ($_POST['receive'] != ''){

        ?>
            <div class="bill__line"></div>
            <div class="bill__details-change">
                <div class="bill__details-list">
                    <p>receive</p>
                    <p><?php echo $_POST['receive'] ?></p>
                </div>
                <div class="bill__details-list">
                    <p>change</p>
                    <p><?php echo $_POST['change'] ?></p>
                </div>
            </div>
        <?php 
            }
        ?>
        <?php 
            echo $_SESSION['status'];
        
            if($_SESSION['status'] == 'admin') { 
                echo '<div class="bill__button">
                        <button type="button" id="deleteBtn">Delete</button>
                      </div>';
            }
        ?>

    </div>
</div>
<?php 
    } else {
        $sqlDetaill = "SELECT * 
                       FROM delivery
                       INNER JOIN customer
                       ON delivery.cus_id = customer.cus_id 
                       WHERE '$_billID' = bill_id";
        $resultDetail = mysqli_query($conn, $sqlDetaill);
        $rowDetail = mysqli_fetch_array($resultDetail);

        $sqlMenu = "SELECT * 
                    FROM `order_details` 
                    INNER JOIN `menu` 
                    ON order_details.menu_id = menu.menu_id
                    WHERE bill_id = '$_billID'";
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
            <p><?php echo $_billID ?></p>
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
                <p><?php echo $rowMenu['menu_name'].$rowMenu['order_name'].' '.'x'.' '.$rowMenu['menu_qt']?></p>
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
                <p><?php echo $rowDetail['order_price'] ?></p>
            </div>
            <div class="bill__details-list">
                <?php 
                    if($_POST['from'] == 'delivery') {
                ?>
                    <p>Deliver Charge</p>
                    <p><?php echo $rowSet['set_deliver'] ?></p>
                <?php 
                    } else {
                ?>
                    <p>Deliver Charge</p>
                    <p><?php echo $rowSet['set_deliver'] ?></p>
                <?php 
                    }
                ?>
            </div>
            <div class="bill__details-list">
                <p>VAT</p>
                <p><?php echo $rowSet['set_vat'] ?>%</p>
            </div>
            <div class="bill__details-total">
                <p>Total</p>
                <p><?php echo $rowDetail['order_price'] + $rowSet['set_deliver']; ?>
                </p>
            </div>
        </div>
    </div>
    <div class="bill__button">
        <button type="button" id="deleteBtn">Delete</button>
    </div>
</div>
<?php
    }
?>
<script>
    $(document).ready(()=>{
        const module = $('.module'),
              moduleBg = $('.module__bg'),
              moduleDelete = $('.module__delete'),
              deleteSumit = $('.module__delete-submit'),
              deleteCancel = $('.module__delete-cancel'),
              content = $('.content')

        const deleteBtn = $('#deleteBtn'),
              payment = $('.order__pay')

              console.log($('#online').length);
              console.log($('#front').length);

        deleteBtn.click(()=>{
            module.addClass('module-active')
            moduleBg.addClass('module__bg-active')
            moduleDelete.addClass('module__delete-active')
        })

        deleteSumit.click(()=>{ 
            $.ajax({
                url : './history-query.php',
                type: 'post',
                data: { 

                    orderID: '<?php echo $_billID ?>',
                    order: 'delete'
                
                },
                success: function(response){
                    content.load('./content/history.php')
                }
            })
        })

        deleteCancel.click(()=>{
            module.removeClass('module-active')
            moduleBg.removeClass('module__bg-active')
            moduleDelete.removeClass('module__delete-active')
        })

        payment.click(()=>{
            content.load('./content/payment.php',{
                billID: '<?php echo $_billID ?>',
                where: 'history'
            })
        })
    })
</script>