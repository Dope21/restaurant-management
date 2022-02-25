<?php require_once("../database/connection.php") ?>             
<?php session_start() ?>
<?php 

$_userID = $_SESSION['userID'];
$sqlPro = "SELECT * FROM employee WHERE emp_id = '$_userID'";

$resultPro = mysqli_query($conn, $sqlPro);
$rowPro = mysqli_fetch_array($resultPro);

?>
<div class="black-bg"></div>
<form class="profile" action="./employee-query.php?userID=<?php echo $_userID; ?>&fromprofile=1" method="POST" enctype="multipart/form-data">
    <div class="profile__name">
        <p><?php echo $rowPro['emp_fname'].' '.$rowPro['emp_lname']?></p>
    </div>

    <div class="profile__icon">
        <div class="profile__img">
            <img src="./emp_img/<?php if($rowPro['emp_image'] != '') {
                echo $rowPro['emp_image'];
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
                <input type="text" class="profile__input-box" name="fname" value="<?php echo $rowPro['emp_fname']?>">
            </div>
            <div class="">
                <p class="profile__input-title">Lastname</p>
                <input type="text" class="profile__input-box" name="lname" value="<?php echo $rowPro['emp_lname']?>">
            </div>
        </div>
        <div class="profile__input profile__input-inline">
            <div>
                <p class="profile__input-title">Username</p>
                <input type="text" class="profile__input-box" name="username" value="<?php echo $rowPro['emp_username']?>">
            </div>
            <div>
                <p class="profile__input-title">Password</p>
                <input type="text" class="profile__input-box" name="password" value="<?php echo $rowPro['emp_password']?>">
            </div>
        </div>  
        <div class="profile__input">
            <p class="profile__input-title">Addresss</p>
            <textarea class="profile__input-box" name="address"><?php echo $rowPro['emp_address']?></textarea>
        </div>
        <div class="profile__input profile__input-inline">
            <div class="">
                <p class="profile__input-title">Number</p>
                <input type="text" class="profile__input-box" name="number" value="<?php echo $rowPro['emp_number']?>">
            </div>
            <div class="">
                <p class="profile__input-title">Status</p>
                <?php 
                
                    if ($rowPro['emp_status'] == 'employee') {                
                ?>
                    <input type="text" readonly class="profile__input-box" name="status" value="<?php echo $rowPro['emp_status']?>">
                <?php 
                    } else {
                ?>
                <select name="status" id="" class="profile__input-box">
                    <option value="employee"<?php if ($rowPro['emp_status'] == 'employee'){echo 'selected';} ?> >Employee</option>
                    <option value="admin" <?php if ($rowPro['emp_status'] == 'admin'){echo 'selected';} ?>>Admin</option>
                </select>
                <?php 
                    }
                ?>
            </div>
        </div>
        
        <input type="submit" id="updateButton" value="Update" name="order" class="button">
    </div>
</form>
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

