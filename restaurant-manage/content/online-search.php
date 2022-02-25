<?php require_once('../database/connection.php') ?>
<?php 

    $_filter = $_POST['filter'];

    $sql = "SELECT * 
            FROM delivery 
            INNER JOIN customer
            ON delivery.cus_id = customer.cus_id
            WHERE '$_filter' = order_status
            ORDER BY order_id DESC";
    $result = mysqli_query($conn, $sql);

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
?>
<script>
    $(document).ready(()=>{        
        const detail = $('.order__detail'),
              orders = $('.order__item'),
              payments = $('.order__pay'),
              content = $('.content')

        // ORDER DETAILS
        orders.each((i, order)=>{
            $(order).on('click',()=>{
                detail.load('./content/online-bill.php',{
                    billID: $(order).data('id')
                })
            })
        })

        payments.each((i, payment)=>{
            $(payment).on('click',()=>{
                content.load('./content/payment.php',{
                    billID: $(payment).data('id')
                })
            })
        })
    })
</script>