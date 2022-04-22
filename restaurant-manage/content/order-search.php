<?php require_once('../database/connection.php') ?>
<?php 

$_name = $_POST['name'];

if($_name != '') {
    $sqlOrder = "SELECT * FROM front WHERE order_name LIKE '%$_name%' AND order_status = 'unpaid'";
} 

$resultOrder = mysqli_query($conn, $sqlOrder);

if(!$resultOrder) {
    echo mysqli_error($conn);
}
?>

<div class="order__list">
    <?php 
    if(mysqli_num_rows($resultOrder) > 0){

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
            <p class="order__time"><?php echo substr($rowOrder['order_time'],0,5) ?></p>
        </div>
    </div>
    <?php 
        }
    } else {
        echo '<div class="order__detail-empty">"There are no order"</div>';
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
    })
</script>