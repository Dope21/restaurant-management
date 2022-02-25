<?php require_once('../database/connection.php') ?>
<div class="black-bg"></div>
<div class="order history">
    <div class="module">
        <div class="module__bg"></div>
        <div class="module__content">
            <div class="module__delete">
                <p class="module__delete-text">Are you sure you want to delete this order?</p>
                <button type="button" class="module__delete-submit" data-id="">Enter</button>
                <button type="button" class="module__delete-cancel">Cancel</button>
            </div>
        </div>
    </div>

    <div class="order__filter history__filter">
        <div class="history__type">
            <div class="order__filter-box" data-id="table">
                <p>Table</p>
            </div>
            <div class="order__filter-box" data-id="package">
                <p>Package</p>
            </div>
            <div class="order__filter-box" data-id="delivery">
                <p>Delivery</p>
            </div>
        </div>
        <div class="history__date">
            <input type="date" name="date">
        </div>
    </div>

    <div class="order__content">
        <div class="order__list">
            <?php 
                $sqlOrder = "SELECT * 
                             FROM front 
                             WHERE order_status = 'paid' 
                             ORDER BY order_date DESC";
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
              orders = $('.order__item'),
              detail = $('.order__detail'),
              date = $('input[type="date"]')

        // HISTORY FILTER
        filter.each((i, obj)=>{
            $(obj).on('click',()=>{

                filter.removeClass('order__filter-box-active')
                $(obj).addClass('order__filter-box-active')

                list.load('./content/history-search.php',{
                    filter: $(obj).data('id'),
                    date: date.val()
                    
                })
            })
        })

        date.change(()=>{
            console.log();
            list.load('./content/history-search.php',{
                filter: $('.order__filter-box-active').data('id'),
                date: date.val()
            })
        })

        // HISTORY DETAILS
        orders.each((i, order)=>{
            $(order).on('click',()=>{
                detail.load('./content/history-bill.php',{
                    billID: $(order).data('id')
                })
            })
        })

        if ('<?php echo $_POST['from'] ?>' == 'home') {
            detail.load('./content/history-bill.php',{
                    billID: '<?php echo $_POST['orderID']?>'
            })
        }
    })
</script>