<?php require_once('../database/connection.php') ?>
<?php

$billID = $_POST['orderID'];

if ($_POST['from'] == 'delivery') {
    $sqlDetail = "SELECT * FROM delivery WHERE bill_id = '$billID'";
    $resultDetail = mysqli_query($conn, $sqlDetail);
    $rowDetail = mysqli_fetch_array($resultDetail);
} else {
    $sqlDetail = "SELECT * FROM front WHERE bill_id = '$billID'";
    $resultDetail = mysqli_query($conn, $sqlDetail);
    $rowDetail = mysqli_fetch_array($resultDetail);
}

$sqlMenu = "SELECT * 
            FROM `order_details` 
            INNER JOIN `menu` 
            ON order_details.menu_id = menu.menu_id
            WHERE bill_id = '$billID'";
$resultMenu = mysqli_query($conn, $sqlMenu);

$sqlSet = "SELECT * FROM setting";
$resultSet = mysqli_query($conn, $sqlSet);
$rowSet = mysqli_fetch_array($resultSet);

?>
<div class="order">
    <div class="module">
        <div class="module__bg"></div>
        <div class="module__content">

            <div class="module__delete">
                <p class="module__delete-text">Are you sure you want to delete this menu?</p>
                <button type="button" class="module__delete-submit" data-id="">Enter</button>
                <button type="button" class="module__delete-cancel">Cancel</button>
            </div>
        </div>
    </div>  

    <a href=
        "<?php if ($_POST['from'] == 'delivery') {
            echo '#online';
        } else {
            echo '#order';
        } ?>" 
        class="menu__update-back"><i class="fas fa-arrow-left"></i>Back to order
    </a>
    <div class="bill">
        <div class="bill__head">
            <p class="bill__head-total">Receipt</p>
            <div class="bill__head-number">
                <span>Number</span>
                <p><?php echo $billID ?></p>
            </div>
            <div class="bill__line"></div>
        </div>
        <div class="bill__details">
            <div class="bill__detail-order">
                <p class="bill__details-title">Details</p>
                <div class="bill__details-list">
                    <p>Name</p>
                    <input class="bill__input-detail"  type="text" name="name" value="<?php echo $rowDetail['order_name'] ?>">
                </div>
                <div class="bill__details-list">

                    <?php 
                        if($_POST['from'] == 'delivery') {
                            
                    ?>
                        <p>Status</p>
                        <select class="bill__input-detail" name="status">
                            <option value="wait" <?php if ($rowDetail['order_status'] == 'wait') {echo 'selected';} ?>>wait</option>
                            <option value="cooking" <?php if ($rowDetail['order_status'] == 'cooking') {echo 'selected';} ?>>cooking</option>
                            <option value="delivering" <?php if ($rowDetail['order_status'] == 'delivering') {echo 'selected';} ?>>delivering</option>
                            <option value="received" <?php if ($rowDetail['order_status'] == 'received') {echo 'selected';} ?>>received</option>
                        </select>
                    <?php 
                        } else {

                    ?>
                        <p>Type</p>
                        <select class="bill__input-detail" name="type">
                            <option value="table" <?php if ($rowDetail['order_cate'] == 'table') {echo 'selected';} ?>>table</option>
                            <option value="package" <?php if ($rowDetail['order_cate'] == 'package') {echo 'selected';} ?>>package</option>
                        </select>
                    <?php 
                        }
                    
                    ?>
                
                </div>
                <div class="bill__details-list">
                    <p>Payment</p>
                    <p>
                        <?php 
                        
                            if($_POST['from'] == 'delivery') {
                                if($rowDetail['order_payment']==''){
                                    echo '<span class="bill__details-pay">upload</span>';
                                } else {
                                    echo '<span class="bill__details-pay">paid</span>';
                                }
                            } else {
                                echo $rowDetail['order_status'];
                            }
                        
                        ?>
                        
                    </p>
                </div>
                <div class="bill__details-list">
                    <p>Time</p>
                    <p>
                        <?php echo $rowDetail['order_time'] ?>
                        <?php echo $rowDetail['order_date'] ?>
                    </p>
                </div>
                
                <?php 
                    if($_POST['from'] == 'delivery') {
                ?>
                    <div class="bill__details-list">
                        <p>Address</p>
                        <input class="bill__input-detail" type="text" name="address" value="<?php echo $rowDetail['order_address'] ?>">
                            
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
                <div class="bill__details-list bill__menu" data-id="<?php echo $rowMenu['menu_id'] ?>" >
                    <p><?php echo $rowMenu['menu_name'].$rowMenu['order_name'].' '.'x'?>
                        <input class="bill__input-qt" type="number" min="1" name="menu_qt" value="<?php echo $rowMenu['menu_qt'] ?>">
                    </p>
                    <p>
                        <?php echo $rowMenu['menu_total'] ?>
                        <span class="bill__del-item" data-id="<?php echo $rowMenu['menu_id'] ?>"><i class="fas fa-trash-alt"></i></span>
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
                    <?php 
                        if($_POST['from'] == 'delivery') {
                    ?>
                        <p>Deliver Charge</p>
                        <p><?php echo $rowSet['set_deliver'] ?></p>
                    <?php 
                        } else {
                    ?>
                        <p>Service Charge</p>
                        <p><?php echo $rowSet['set_serv'] ?></p>
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
                    <p>
                        <?php 
                            if($_POST['from'] == 'delivery') {
                                $serv = $rowSet['set_deliver'];
                            } else {
                                $serv = $rowSet['set_serv'];
                            }

                            echo $rowDetail['order_price']+
                                (($rowDetail['order_price']*$rowSet['set_vat'])/100)+
                                $serv 
                        ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="bill__button" data-from="<?php echo $_POST['from'] ?>">
            <button type="button" id="saveButton">Save</button>
            <button type="button" id="deleteButton">Delete</button>
            <button type="button" id="payButton">Pay</button>
            <button type="button" id="printButton">Print</button>
        </div>
    </div>
</div>

<script>
    $(document).ready(()=>{
        //MODULE VARIABLE
        const module = $('.module'),
              moduleBg = $('.module__bg'),
              moduleDelete = $('.module__delete'),
              deleteSumit = $('.module__delete-submit'),
              deleteCancel = $('.module__delete-cancel'),
              content = $('.content')

        //VARIABLE
        const saveButton = $('#saveButton'),
              deleteButton = $('#deleteButton'),
              name = $('input[name ="name"]'),
              type = $('select[name ="type"]'),
              Qts = $('.bill__input-qt'),
              menus = $('.bill__menu'),
              deleteItems = $('.bill__del-item'),
              printButton = $('#printButton'),
              payButton = $('#payButton'),
              from = $('.bill__button').data('from'),
              status = $('select[name="status"]'),
              address = $('input[name="address"]'),
              payment = $('.bill__details-pay')

        //INPUT VARIABLE
        let menuQTs = [],
            menuIDs = [];

        //DELETE ORDER
        deleteButton.click(()=>{
            module.addClass('module-active')
            moduleDelete.addClass('module__delete-active')
            moduleBg.addClass('module__bg-active')
            deleteSumit.attr("data-id",'<?php echo $billID ?>')
        })

        saveButton.click(()=>{
            Qts.each((i,qt)=>{
                menuQTs.push($(qt).val())
            })

            menus.each((i,menu)=>{
                menuIDs.push($(menu).data('id'))
            })
            
            if (from == 'delivery') {
                
                $.ajax({
                    url : './online-query.php',
                    type: 'post',
                    data: { 

                    updateID: '<?php echo $billID ?>',
                    name: name.val(),
                    status: status.find(':selected').val(),
                    address: address.val(),
                    menuQTs: menuQTs,
                    menuIDs: menuIDs,
                    order: 'update'
                    
                },
                    success: function(response){
                        content.load('./content/order-edit.php',{
                            orderID: '<?php echo $billID ?>',
                            from: 'delivery'
                        })
                    }
                })
            } else {
                
                $.ajax({
                    url : './order-query.php',
                    type: 'post',
                    data: { 

                    updateID: '<?php echo $billID ?>',
                    name: name.val(),
                    type: type.find(':selected').val(),
                    menuQTs: menuQTs,
                    menuIDs: menuIDs,
                    order: 'Update'
                    
                },
                    success: function(response){
                        content.load('./content/order-edit.php',{
                            orderID: '<?php echo $billID ?>'
                        })
                    }
                })
            }
            
        })

        deleteCancel.click(()=>{
            module.removeClass('module-active')
            moduleDelete.removeClass('module__delete-active')
        })

        deleteSumit.click(()=>{
            if (from == 'delivery') {
                $.ajax({
                    url : './online-query.php',
                    type: 'post',
                    data: { 

                        deleteID: '<?php echo $billID ?>',
                        order: 'delete'
                
                    },
                    success: function(response){
                        content.load('./content/online.php')
                    }
                })
            } else {
                $.ajax({
                    url : './order-query.php',
                    type: 'post',
                    data: { 

                        deleteID: '<?php echo $billID ?>',
                        order: 'delete'
                
                    },
                    success: function(response){
                        content.load('./content/order.php')
                    }
                })
            }
            
        })  

        deleteItems.each((i, item) =>{
            $(item).on('click',()=>{
                $.ajax({
                    url : './order-query.php',
                    type: 'post',
                    data: { 

                    deleteItem: $(item).data('id'),
                    orderID: '<?php echo $billID ?>',
                    order: 'delete_item'
                    
                    },
                    success: function(response){
                        content.load('./content/order-edit.php',{
                            orderID: '<?php echo $billID ?>'
                        })
                    }
                })
            })
        })

        printButton.click(()=>{
            content.load('./content/order-print.php',{
                orderID: '<?php echo $billID ?>'
            })
        })

        payButton.click(()=>{
            content.load('./content/order-pay.php',{
                orderID: '<?php echo $billID ?>',
                from: from
            })
        })

        payment.click(()=>{
            content.load('./content/payment.php',{
                orderID: '<?php echo $billID ?>'
            })
        })
    })

    
</script>