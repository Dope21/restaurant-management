<?php session_start() ?>
<?php require_once('../database/connection.php') ?>
<?php 

    // VARIABLES
    $_billID = $_POST['billID'];
    $_orderCate = substr($_billID,0,1);
    $_Name = '';
    $_Type = '';
    $_Time = '';
    $_Subtotal = '';
    $_Charge = '';
    $_Vat = '';
    $_Total = '';
    $_Address = '';
    $_Phone = '';

    // DETAILS FROM DATABASE
    $sqlMenu = "SELECT * 
                FROM `order_details` 
                INNER JOIN `menu` 
                    ON order_details.menu_id = menu.menu_id
                WHERE bill_id = '$_billID'";
    $resultMenu = mysqli_query($conn, $sqlMenu);

    $sqlSet = "SELECT * FROM setting";
    $resultSet = mysqli_query($conn, $sqlSet);
    $rowSet = mysqli_fetch_array($resultSet);

    // CHECK ORDER ID
    if ($_orderCate != 'D') {

        $sqlDetaill = "SELECT * FROM front WHERE '$_billID' = bill_id";

        $resultDetail = mysqli_query($conn, $sqlDetaill);
        $rowDetail = mysqli_fetch_array($resultDetail);
        
        $_Name = $rowDetail['order_name'];
        $_Type = $rowDetail['order_cate'];
        $_Time = substr($rowDetail['order_time'],0,5).' '.$rowDetail['order_date'];
        $_Charge = $rowSet['set_serv'];
        $_Vat = $rowSet['set_vat'];
        $_Total = $rowDetail['order_price'];
    
    } else {

        $sqlDetaill = "SELECT * 
                       FROM delivery
                       INNER JOIN customer
                       ON delivery.cus_id = customer.cus_id 
                       WHERE '$_billID' = bill_id";
        $resultDetail = mysqli_query($conn, $sqlDetaill);
        $rowDetail = mysqli_fetch_array($resultDetail);

        $_Name = $rowDetail['cus_fname'];
        $_Address = $rowDetail['cus_address'];
        $_Phone = $rowDetail['cus_number'];
        $_Time = substr($rowDetail['order_time'],0,5).' '.$rowDetail['order_date'];
        $_Charge = $rowSet['set_deliver'];
        $_Vat = $rowSet['set_vat'];
        $_Total = $rowDetail['order_price'];
    }
?>

<div class="bill">
    <div class="bill__head">
        <p class="bill__head-total">Receipt</p>
        <div class="bill__head-number">
            <span>Number</span>
            <p><?= $_billID ?></p>
        </div>
        <div class="bill__line"></div>
    </div>
    <div class="bill__details">
        <div class="bill__detail-order">
            <p class="bill__details-title">Details</p>
        <?php 
            if ($_orderCate != 'D') {
        ?>
            <div class="bill__details-list">
                <p>Name</p>
                <p><?= $_Name ?></p>
            </div>
            <div class="bill__details-list">
                <p>Type</p>
                <p><?= $_Type ?></p>
            </div>
            <div class="bill__details-list">
                <p>Time</p>
                <p><?= $_Time ?></p>
            </div>     
        <?php 
            } else {
        ?>
            <div class="bill__details-list not-print">
                <p>Payment</p>
                <p><span class="order__pay">paid</span></p>
            </div>
            <div class="bill__details-list">
                <p>Time</p>
                <p><?= $_Time ?></p>
            </div>
                
            <div class="bill__details-list">
                <p>Address</p>
                <p><?= $_Address ?></p>   
            </div>

            <div class="bill__details-list">
                <p>Phone</p>
                <p><?= $_Phone ?></p>   
            </div>
        <?php 
            }
        ?>
        </div>
        <div class="bill__line"></div>
        <div class="bill__details-items">
            <p class="bill__details-title">Food items</p>
            <?php 
                foreach($resultMenu as $rowMenu) {
            ?>
            <div class="bill__details-list bill__menu" data-id="<?= $rowMenu['menu_id'] ?>" >
                <p>
                    <?= $rowMenu['menu_name'].' '.'x'.$rowMenu['menu_qt']?>
                </p>
                <p>
                    <?= $rowMenu['menu_total'] ?>
                </p>
            </div>
            <?php 
                    $_Subtotal = $rowMenu['menu_total'];
                }
            ?>
        </div>
        <div class="bill__line"></div>  
        <div class="bill__details-price">
            <p class="bill__details-title">Price</p>
            <div class="bill__details-list">
                <p>Subtotal</p>
                <p><?= $_Subtotal ?></p>
            </div>
            <div class="bill__details-list">
                <p>
                    <?php if ($_orderCate != 'D') { 
                        echo 'Service Charge'; 
                    } else {
                        echo 'Deliver Charge'; 
                    } ?>
                </p>
                <p><?= $_Charge ?></p>
            </div>
            <div class="bill__details-list">
                <p>VAT</p>
                <p><?= $_Vat ?>%</p>
            </div>
            <div class="bill__details-total">
                <p>Total</p>
                <p class="total"><?= $_Total ?>
                </p>
            </div>
        </div>
        <div class="bill__line"></div>
        <?php if ($_orderCate != 'D') { ?>
            <div class="bill__details-change">
                <div class="bill__details-list">
                    <p>receive</p>
                    <p><?= $rowDetail['order_receive'] ?></p>
                </div>
                <div class="bill__details-list">
                    <p>change</p>
                    <p><?= $rowDetail['order_change'] ?></p>
                </div>
            </div>
        <?php } ?>
        <?php 
            if($_SESSION['status'] == 'admin') { 
                echo '<div class="bill__button">
                        <button type="button" id="deleteBtn">Delete</button>
                      </div>';
            }
        ?>

    </div>
</div>

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

        deleteBtn.click(()=>{
            module.addClass('module-active')
            moduleBg.addClass('module__bg-active')
            moduleDelete.addClass('module__delete-active')
        })

        deleteSumit.click(()=>{ 

            $.ajax({
                url : './functions/history-query.php',
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