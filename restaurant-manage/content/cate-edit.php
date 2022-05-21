<?php require_once("../database/connection.php") ?>
<?php 

$_cateID = $_POST['cateID'];
$sqlCate = "SELECT * FROM category WHERE cate_id = '$_cateID'";

$resultCate = mysqli_query($conn, $sqlCate);
$rowCate = mysqli_fetch_array($resultCate);

?>
<div class="black-bg"></div>
<div class="profile">
    <form class="profile__input-wrapper" action="./functions/category-query.php?cateID=<?php echo $_cateID; ?>" method="POST" enctype="multipart/form-data">
        <div class="profile__input">
            <p class="profile__input-title">Category Name</p>
            <input type="text" class="profile__input-box" name="catename" value="<?php echo $rowCate['cate_name']?>">
        </div>
        <input type="submit" id="updateButton" value="Update" name="order" class="button">
    </form>
</div>

