<?php require_once('../database/connection.php') ?>
<div class="black-bg"></div>
<div class="order">
    <div class="module">
        <div class="module__bg"></div>
        <div class="module__content">
            <div class="module__add">
                <div class="module__title">
                    <p class="module__title-text">Add Order</p>
                    <div class="module__title-exit"><i class="far fa-times-circle"></i></div>
                </div>
                
                <div class="module__input">
                    <label for="name" class="module__input-title">Name</label>
                    <input type="text" class="module__input-box" name='name'>
                </div>
                <div class="module__input">
                    <label for="type" class="module__input-title">Type*</label>
                    <select name="type" class="module__input-box" id="orderType">
                        <option value="table">Table</option>
                        <option value="package">Package</option>
                    </select>
                </div>

                <div class="module__button">
                    <input type="submit" id="addOrder" value="Enter">
                </div>
            </div>
        </div>
    </div>

    <div class="order__add">
        <button type="button" id="Add" class="button"><i class="fas fa-plus"></i>Add Order</button>

        <div class="order__search">
            <div class="order__search-name">
                <input type="text" name="ordername" placeholder="search order name...">
            </div>
            <div class="order__search-button">
                <button id="orderSearch" type="button" class="button">Search</button>
            </div>
        </div>
    </div>

    <div class="order__content">
        <div class="order__list">
            <?php 
                $sqlOrder = "SELECT * FROM front WHERE order_status = 'unpaid'";
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
            //MODULE VARIABLE
            const content = $('.content'),
                  moduleAdd = $('.module__add'),
                  moduleSuccess = $('.module__success'),
                  successText = $('.module__success-text'),
                  name = $('input[name="name"]'),
                  type = $('#orderType')

            //ORDER VARIABLE
            const orderItems = $('.order__item'),
                  orderDetail = $('.order__detail'),
                  orderSearch = $('#orderSearch'),
                  orderName = $('input[name="ordername"]'),
                  orderDate = $('input[name="date"]'),
                  orderList = $('.order__list'),
                  orderAdd = $('#addOrder')
                
            //ADD ORDER
            orderAdd.click(()=>{
            
                if (type.find(":selected").val() == '') {
                    type.addClass('module__input-empty')
                    return
                } 

                    $.ajax({
                        url : './functions/order-query.php',
                        type: 'post',
                        data: { 
                            
                            name: name.val(),
                            type: type.find(":selected").val(),
                            order: 'add'
        
                        },
                        success: function(response){
                            content.load('./content/order.php')
                        }
                    })
            })

            //SHOW ORDER DETAILS
            orderItems.each((i,item)=>{
                $(item).on('click',()=>{
                    orderDetail.load('./content/order-bill.php', {
                        billID: $(item).data('id')
                    });
                })
            })

            //SEARCH ORDER
            orderSearch.click(()=>{
                orderList.load('./content/order-search.php',{
                    name: orderName.val()
                })
            })
    })
</script>