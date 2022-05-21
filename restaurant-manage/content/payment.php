<?php require_once('../database/connection.php') ?>
<?php 
    $billID = $_POST['billID'];

    $sql = "SELECT * FROM delivery WHERE '$billID' = bill_id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
?>
<div class="black-bg"></div>
<div class="payment">
    <?php 
        if(isset($_POST['where'])) {
            
        ?>
            <a href='#history' class="menu__update-back"><i class="fas fa-arrow-left"></i>Back to history</a>
    <?php 
        } else {
    ?>
            <a href='#online' class="menu__update-back"><i class="fas fa-arrow-left"></i>Back to order</a>
    <?php 
        }
    ?>
        <div class="payment__img">
            <img src="./asset/payment_img/<?php echo $row['order_payment'] ?>" alt="">
        </div>
        
</div>