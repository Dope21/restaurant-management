<?php require_once("../database/connection.php") ?>
<?php 

$sql = "SELECT * FROM setting";
$query = mysqli_query($conn, $sql);
$set = mysqli_fetch_array($query);

?>
<div class="setting">
    <div class="setting__box">
        <labe class="setting__label">Service cost</labe>
        <input class="setting__input" name="serv" type="number" value="<?php echo $set['set_serv'] ?>">
        <span class="setting__unit">Bath</span>
    </div>
    <div class="setting__box">
        <labe class="setting__label">Delivery cost</labe>
        <input class="setting__input" name="deliver" type="number" value="<?php echo $set['set_deliver'] ?>">
        <span class="setting__unit">Bath</span>
    </div>
    <div class="setting__box">
        <labe class="setting__label">VAT</labe>
        <input class="setting__input" name="vat" type="number" value="<?php echo $set['set_vat'] ?>">
        <span class="setting__unit">%</span>
    </div>

    <button class="button">Save</button>
</div>
<script>
    $(document).ready(()=>{

        const settBtn = $('.setting__button'),
              serv = $('input[name="serv"]'),
              deliver = $('input[name="deliver"]'),
              vat = $('input[name="vat"]')

        settBtn.click(()=>{
            $.ajax({
                url : './setting-query.php',
                type: 'post',
                data: { 

                    serv: serv.val(),
                    deliver: deliver.val(),
                    vat: vat.val()
                }
            })
        })
    })
</script>