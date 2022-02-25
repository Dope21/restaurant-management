<?php 

    $_orderID = $_GET['orderID'];
    $sql_pay = "SELECT * FROM delivery WHERE bill_id = '$_orderID'";
    $rs_pay = mysqli_query($conn, $sql_pay);
    $row_pay = mysqli_fetch_array($rs_pay);

?>
<div class="payment container pb-5">
    <p class="mt-5 mb-4 text-center payment__title">Upload your payment</p>
    <div class="payment__details my-5">
        <div class="payment__detail">
            <img src="./asset/k.png" alt="">
            <div class="">
                <p>Kasikornbank</p>
                <p>054-1-98533-6</p>
            </div>
        </div>
        <div class="payment__detail">
            <img src="./asset/paypal.png" alt="">
            <div>
                <p>PayPal</p>
                <p>4664-1615-5240-4468</p>
            </div>
        </div>
    </div>
    <form class="d-flex justify-content-center align-items-center gap-4" action="./pay-upload.php?orderID=<?php echo $_orderID ?>" method="POST" enctype="multipart/form-data">
        <div class="position-relative">
            <input type="file" class="position-absolute w-100" name="image" id="inputFile">
            <button type="button" class="btn call-btn">Upload</button>
        </div>
        <input type="submit" class="btn call-btn">
    </form>

    <div class="payment__img d-flex align-items-center justify-content-center mt-5">
        <img src="
        <?php 
            if ($row_pay['order_payment'] != '') {
            echo './restaurant-manage/payment_img/'.$row_pay['order_payment']; 
            }
        ?>" id="payment">
    </div>
</div>
<script>

    const imgInp = document.getElementById('inputFile');
    const imgPay = document.getElementById('payment');

    imgInp.onchange = evt => {
    const [file] = imgInp.files
    if (file) {
        imgPay.src = URL.createObjectURL(file)
    }
}
</script>