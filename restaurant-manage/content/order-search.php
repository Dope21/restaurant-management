<?php require_once('../database/connection.php') ?>
<?php 

$_name = $_POST['name'];

if($_name != '') {
    $sqlOrder = "SELECT * FROM front WHERE '$_name' = order_name AND order_status = 'unpaid'";
} 

$resultOrder = mysqli_query($conn, $sqlOrder);

if(!$resultOrder) {
    echo mysqli_error($conn);
}
?>

<div class="order__list">
    <?php 

        foreach($resultOrder as $rowOrder){
    ?>
    <div class="order__item" data-id="<?php echo $rowOrder['bill_id'] ?>">
        <div class="order__item-title">
            <p class="order__number"><?php echo $rowOrder['bill_id'] ?></p>
            <p class="order__name"><?php echo $rowOrder['order_name']; ?></p>
        </div>
        <div class="order__item-subtitle">
            <p class="order__type">
                <?php 
                    echo $rowOrder['order_cate'];
                ?>
            </p>
            <p class="order__time"><?php echo $rowOrder['order_time'] ?></p>
        </div>
    </div>
    <?php 
        }
    ?>
</div>

<script>
    $(document).ready(()=>{
        const orderItems = $('.order__item'),
              orderDetail = $('.order__detail')


        //SHOW ORDER DETAILS
        orderItems.each((i,item)=>{
            $(item).on('click',()=>{
                orderDetail.load('./content/order-bill.php', {
                    billID: $(item).data('id'),
                });
            })
        })

        payments.each((i, payment)=>{
            $(payment).on('click',()=>{
                content.load('./content/payment.php')
            })
        })
    })
</script>