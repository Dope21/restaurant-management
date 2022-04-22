<?php require_once('../database/connection.php') ?>
<?php 
    $_filter = $_POST['filter'];
    $_date = $_POST['date'];

    if ($_filter != 'delivery') {

            if($_date == '' && $_filter != '') {
                $sqlOrder = "SELECT * 
                             FROM front 
                             WHERE order_status = 'paid'
                             AND order_cate = '$_filter' 
                             ORDER BY order_date DESC";
            } 
            if ($_date != '' && $_filter != ''){
                $sqlOrder = "SELECT * 
                             FROM front 
                             WHERE order_status = 'paid'
                             AND order_cate = '$_filter'
                             AND order_date = '$_date' 
                             ORDER BY order_date DESC";
            }
            if ($_date != '' && $_filter == ""){
                $sqlOrder = "SELECT * 
                             FROM front 
                             WHERE order_status = 'paid'
                             AND order_date = '$_date' 
                             ORDER BY order_date DESC";                
            }

        $resultOrder = mysqli_query($conn, $sqlOrder);
        if(mysqli_num_rows($resultOrder) > 0){
            foreach($resultOrder as $rowOrder){
?>
            <div class="order__item" data-id="<?php echo $rowOrder['bill_id'] ?>">
                <div class="order__item-title">
                    <p class="order__number"><?php echo $rowOrder['bill_id'] ?></p>
                    <p class="order__name"><?php echo $rowOrder['order_name'] ?></p>
                </div>
                <div class="order__item-subtitle">
                    <p class="order__type"><?php echo $rowOrder['order_cate'] ?></p>
                    <p class="order__time"><?php echo substr($rowOrder['order_time'],0,5) ?></p>
                </div>
            </div>
<?php
            }
        } else{
            echo '<div class="order__detail-empty">"There are no order"</div>';
        }
    } else {
        if($_date != '') {
            $sql = "SELECT * 
                    FROM delivery 
                    INNER JOIN customer
                    ON delivery.cus_id = customer.cus_id
                    WHERE 'received' = order_status
                    AND order_date = '$_date'
                    ORDER BY order_date DESC";
        } else {
            $sql = "SELECT * 
                    FROM delivery 
                    INNER JOIN customer
                    ON delivery.cus_id = customer.cus_id
                    WHERE 'received' = order_status
                    ORDER BY order_date DESC";
        }
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0){

        foreach($result as $rowOrder){
?>
            <div class="order__item" data-id="<?php echo $rowOrder['bill_id'] ?>">
                <div class="order__item-title">
                    <p class="order__number"><?php echo $rowOrder['bill_id'] ?></p>
                    <p class="order__name"><?php echo $rowOrder['cus_fname'] ?></p>
                </div>
                <div class="order__item-subtitle">
                    <p class="order__type">
                        <?php 
                            if ($rowOrder['order_payment'] == "") {
                                echo 'unpaid'; 
                            } else {
                                echo '<span class="order__pay" data-id='.$rowOrder['bill_id'].'>paid</span>';
                            }  
                        ?>
                    </p>
                    <p class="order__time"><?php echo $rowOrder['order_time'] ?></p>
                </div>
            </div>
<?php 
        }

        } else {
            echo '<div class="order__detail-empty">"There are no order"</div>';
        }
    }
?>
<script>
    $(document).ready(()=>{
        const orders = $('.order__item'),
              detail = $('.order__detail'),
              payments = $('.order__pay'),
              content = $('.content')

        orders.each((i, item)=>{
            $(item).on('click',()=>[
                detail.load('./content/history-bill.php',{
                    billID: $(item).data('id')
                })
            ])
        })

        payments.each((i, payment)=>{
            $(payment).on('click',()=>{
                content.load('./content/payment.php',{
                    billID: $(payment).data('id'),
                    where: 'history'
                })
            })
        })
    })
</script>