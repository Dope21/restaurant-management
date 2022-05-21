<?php session_start() ?>
<?php 

$_userID = $_SESSION['userID'];
$sqlPro = "SELECT * FROM customer WHERE cus_id = '$_userID'";

$resultPro = mysqli_query($conn, $sqlPro);
$rowPro = mysqli_fetch_array($resultPro);

?>
<div class="container py-5">

<form class="profile mt-5" action="./functions/profile-update.php?userID=<?php echo $_userID; ?>&fromprofile=1" method="POST" enctype="multipart/form-data">
    <div class="profile__name">
        <p><?php echo $rowPro['cus_fname'].' '.$rowPro['cus_lname']?></p>
    </div>

    <div class="profile__icon">
        <div class="profile__img">
            <img src="./restaurant-manage/asset/cus_img/<?php if($rowPro['cus_image'] != '') {
                echo $rowPro['cus_image'];
            } else {
                echo 'user-defult.png';
            } ?>" alt="" id="imgUser">
        </div>

        <div class="profile__change">
            <i class="fas fa-camera"></i>
        </div>

        <input accept="image/*" type="file" class="profile__img-box" name="image" id="inputFile">
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
            <p class="profile__input-title">Address</p>
            <textarea class="profile__input-box" name="address"><?php echo $rowPro['cus_address']?></textarea>
        </div>
        <div class="profile__input">
            <p class="profile__input-title">Number</p>
            <input type="text" class="profile__input-box" name="number" value="<?php echo $rowPro['cus_number']?>">
        </div>
        
        <input type="submit" name="order" class="btn call-btn px-4 py-2" value="Save">
    </div>
</form>
<script>
    const imgInp = document.getElementById('inputFile');
    const imgUser = document.getElementById('imgUser');

    imgInp.onchange = evt => {
    const [file] = imgInp.files
    if (file) {
        imgUser.src = URL.createObjectURL(file)
    }
}
</script>
</div>