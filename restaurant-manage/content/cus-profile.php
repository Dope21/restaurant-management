<?php require_once("../database/connection.php") ?>
<?php 

$_userID = $_POST['userID'];
$sqlPro = "SELECT * FROM customer WHERE cus_id = '$_userID'";

$resultPro = mysqli_query($conn, $sqlPro);
$rowPro = mysqli_fetch_array($resultPro);

?>
<div class="black-bg"></div>
<form class="profile" action="./functions/customer-query.php?userID=<?php echo $_userID; ?>" method="POST" enctype="multipart/form-data">

    <div class="profile__name">
        <p><?php echo $rowPro['cus_fname'].' '.$rowPro['cus_lname']?></p>
    </div>

        <div class="profile__icon">

        <div class="profile__img">
            <img src="./asset/cus_img/<?php if($rowPro['cus_image'] != '') {
                echo $rowPro['cus_image'];
            } else {
                echo 'user-defult.png';
            } ?>" alt="" id="image">
        </div>

        <div class="profile__change">
            <i class="fas fa-camera"></i>
        </div>

        <input accept="image/*" type="file" class="profile__img-box" name="image">
    </div>
    <div class="profile__input-wrapper">
        <div class="profile__input profile__input-inline" >
            <div class="">
                <p class="profile__input-title">Firstname</p>
                <input type="text" class="profile__input-box" name="fname" value="<?php echo $rowPro['cus_fname']?>">
            </div>
            <div class="">
                <p class="profile__input-title">Lastname</p>
                <input type="text" class="profile__input-box" name="lname" value="<?php echo $rowPro['cus_lname']?>">
            </div>
        </div>
        <div class="profile__input profile__input-inline">
            <div>
                <p class="profile__input-title">Username</p>
                <input type="text" class="profile__input-box" name="username" value="<?php echo $rowPro['cus_username']?>">
            </div>
            <div>
                <p class="profile__input-title">Password</p>
                <input type="text" class="profile__input-box" name="password" value="<?php echo $rowPro['cus_password']?>">
            </div>
        </div>  
        <div class="profile__input">
            <p class="profile__input-title">Addresss</p>
            <textarea class="profile__input-box" name="address"><?php echo $rowPro['cus_address']?></textarea>
        </div>
        <div class="profile__input profile__input-inline">
            <div class="">
                <p class="profile__input-title">Number</p>
                <input type="text" class="profile__input-box" name="number" value="<?php echo $rowPro['cus_number']?>">
            </div>
        </div>

        <input type="submit" id="updateButton" value="Update" name="order" class="button">
    </div>
</fo>
<script>
    $(document).ready(()=>{

        const inputImage = $('.profile__img-box')
        const image = $('#image')
        inputImage.change(()=>{
            const file = inputImage.get(0).files[0]

            if (file) {
                var reader = new FileReader();

                reader.onload = function(){
                    image.attr("src", reader.result);
                }
 
                reader.readAsDataURL(file);
            }
        })
    })
</script>
