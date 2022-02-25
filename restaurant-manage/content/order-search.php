<?php require_once('../database/connection.php') ?>
<?php 

$_name = $_POST['name'];
// $_date = $_POST['date'];
$_status = $_POST['status'];

if($_POST['from'] == 'delivery') {

    if($_POST['name'] != '') {
        $sqlOrder = "SELECT * FROM delivery WHERE order_name = '$_name'";
    }
    if($_POST['status'] != '') {
        $sqlOrder = "SELECT * FROM delivery WHERE order_status = '$_status'";
    }

    // if($_POST['status'] == '' && $_POST['date'] != '') {
    //     $sqlOrder = "SELECT * FROM delivery WHERE order_date = '$_date'";
    // }

    // if($_POST['status'] != '' && $_POST['date'] != '') {
    //     $sqlOrder = "SELECT * FROM delivery WHERE order_date = '$_date' AND order_status = '$_status'";
    // }
} else {
    
    if($_POST['name'] != '') {
        $sqlOrder = "SELECT * FROM front WHERE '$_name' = order_name AND order_status = 'unpaid'";
    } 
    
    // if ($_POST['date'] != '') {
    //     $sqlOrder = "SELECT * FROM order_bill WHERE '$_date' = order_date AND order_status = 'unpaid'";
    // } 
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
                    if ($_POST['from'] == 'delivery') {
                            if ($rowOrder['order_payment'] != '') {
                                echo '<span class="order__pay" >paid</span>';
                            } else {
                                echo 'unpaid';
                            }
                    } else {
                        echo $rowOrder['order_cate'];
                    } 
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
                    from: '<?php echo $_POST['from'] ?>'
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