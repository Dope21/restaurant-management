<?php require_once('../database/connection.php') ?>
<?php 
    $_from = '';
    $_orderID = '';
    if (isset($_POST['from'])) {
        $_from = $_POST['from'];
    } 
    if (isset($_POST['orderID'])){
        $_orderID = $_POST['orderID'];
    }
?>
<div class="black-bg"></div>
<div class="order">
    <div class="module">
        <div class="module__bg"></div>
        <div class="module__content">
            <div class="module__ask" id="">
                <p class="module__ask-text">take this order?</p>
                <button type="button" class="module__ask-submit" data-id="">Enter</button>
                <button type="button" class="module__ask-cancel">Cancel</button>
            </div>

            <div class="module__delete">
                <p class="module__delete-text">Are you sure you want to cancel this order?</p>
                <button type="button" class="module__delete-submit" data-id="">Enter</button>
                <button type="button" class="module__delete-cancel">Cancel</button>
            </div>
        </div>
    </div>

    <div class="order__filter">
        <div class="order__filter-box" data-id="waiting">
            <p>Waiting</p>
        </div>
        <div class="order__filter-box" data-id="cooking">
            <p>Cooking</p>
        </div>
        <div class="order__filter-box" data-id="delivering">
            <p>Delivering</p>
        </div>
        <div class="order__filter-box" data-id="received">
            <p>Received</p>
        </div>
    </div>

    <div class="order__content">
        <div class="order__list">
            <?php 
                $sql = "SELECT * 
                        FROM delivery 
                        INNER JOIN customer
                        ON delivery.cus_id = customer.cus_id
                        WHERE order_status = 'waiting'
                        ORDER BY order_payment DESC";
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
            ?>
        </div>
        <div class="order__detail">
            <div class="order__detail-empty">"Select order"</div>
        </div>
    </div>
</div>
<script>
    $(document).ready(()=>{        
        const filter = $('.order__filter-box'),
              list = $('.order__list'),
              detail = $('.order__detail'),
              orders = $('.order__item'),
              payments = $('.order__pay'),
              content = $('.content')


        // ORDER FILTER
        filter.each((i, obj)=>{
            $(obj).on('click',()=>{

                filter.removeClass('order__filter-box-active')
                $(obj).addClass('order__filter-box-active')

                list.load('./content/online-search.php',{
                    filter: $(obj).data('id')
                })
            })
        })

        // ORDER DETAILS
        orders.each((i, order)=>{
            $(order).on('click',()=>{
                detail.load('./content/online-bill.php',{
                    billID: $(order).data('id')
                })
            })
        })

        if ('<?php echo $_from ?>' == 'home') {
            detail.load('./content/online-bill.php',{
                billID: '<?php echo $_orderID?>'
            })
        }

        // VIEW PAYMENT
        payments.each((i, payment)=>{
            $(payment).on('click',()=>{
                content.load('./content/payment.php',{
                    billID: $(payment).data('id')
                })
            })
        })
    })
</script>