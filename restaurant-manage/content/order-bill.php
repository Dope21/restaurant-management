<?php require_once('../database/connection.php') ?>
<?php 

    $billID = $_POST['billID'];
    if (isset($_POST['from'])) {
        $from = $_POST['from'];
        $sqlDetail = "SELECT * 
                      FROM delivery
                      INNER JOIN customer
                      ON delivery.cus_id = customer.cus_id 
                      WHERE bill_id = '$billID'";
        $resultDetail = mysqli_query($conn, $sqlDetail);
        $rowDetail = mysqli_fetch_array($resultDetail);
    } else {

        $from = '';
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
<div class="bill">
    <div class="bill__head">
        <p class="bill__head-total">Order Price: <?php echo $rowDetail['order_price'] ?></p>
        <div class="bill__line"></div>
    </div>
    <div class="bill__details">
        <div class="bill__details-add">
            <button id="addItem" type="button" class="button-alt" value="<?php echo $billID ?>">Add menu</button>
        </div>
        <div class="bill__details-items">
            <p class="bill__details-title">Food items</p>
            <?php 
                foreach($resultMenu as $rowMenu) {
            ?>
            <div class="bill__details-list">
                <p><?php echo $rowMenu['menu_name'].' '.$rowMenu['menu_type'].' '.'x'.' '.$rowMenu['menu_qt']?></p>
                <p><?php echo $rowMenu['menu_total'] ?></p>
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
                    if(isset($_POST['from'])) {
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
                            if(isset($_POST['from'])) {
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
    <div class="bill__button">
        <button type="button" id="detailButton">Detail</button>
    </div>
</div>
<script>
    $(document).ready(()=>{
        const content = $('.content'),
              orderEdit = $('.bill__head-edit'),
              addItem = $('#addItem'),
              detailButton = $('#detailButton')

        // ADD MENU TO ORDER
        addItem.click(()=>{
            content.load('./content/menu.php', {
                orderID: addItem.val()
            })
        })

        orderEdit.click(()=>{
            content.load('./content/order-edit.php', {
                orderID: '<?php echo $billID ?>'
            })
        })

        detailButton.click(()=>{
            content.load('./content/order-edit.php',{
                orderID: '<?php echo $billID ?>',
                from: '<?php echo $from?>'
            })
        })
    })
</script>