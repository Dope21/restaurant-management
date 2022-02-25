<?php require_once('../database/connection.php') ?>
<?php 

$_menuID = $_POST['menuID'];
$sqlMenu = "SELECT * 
            FROM menu
            INNER JOIN category
            ON menu.cate_id = category.cate_id
            WHERE menu_id = '$_menuID'";

$resultMenu = mysqli_query($conn, $sqlMenu);
$rowMenu = mysqli_fetch_array($resultMenu);

?>
<div class="menu__update">
    <div class="module">
        <div class="module__bg"></div>
        <div class="module__content">

            <div class="module__success">
                <p class="module__success-text"></p>
                <div class="module__success-icon"><i class="far fa-check-circle"></i></div>
            </div> 

            <div class="module__delete">
                <p class="module__delete-text">Are you sure you want to delete this menu?</p>
                <button type="button" class="module__delete-submit" data-id="">Enter</button>
                <button type="button" class="module__delete-cancel">Cancel</button>
            </div>
        </div>
    </div>    

    <a href="#menu" class="menu__update-back"><i class="fas fa-arrow-left"></i>Back to menu</a>
    <form class="menu__update-items" action="./menu-query.php?menuID=<?php echo $_menuID ?>" method="POST" enctype="multipart/form-data">
        <div class="menu__update-item">
            <div class="menu__update-image">
                <img src="./menu_img/<?php if ($rowMenu['menu_image'] == ""){
                    echo 'menu-defult.jpg';
                } else {
                    echo $rowMenu['menu_image'];
                } ?>" alt="" id="imageMenu">
                <div class="menu__update-imageChange">
                    <i class="fas fa-camera"></i>
                </div>
                <input accept="image/*" type="file" name="image" class="menu__update-inputImage">
            </div>
            <div class="menu__update-position">
                <div class="menu__update-box">
                    <label for="" class="menu__update-title">Name</label>
                    <input type="text" class="menu__update-input" value="<?php echo $rowMenu['menu_name'] ?>" name="name">
                </div>
                <div class="menu__update-box">
                    <label for="" class="menu__update-title">Type</label>
                    <input type="text" class="menu__update-input" value="<?php echo $rowMenu['menu_type'] ?>" name="type">
                </div>
                <div class="menu__update-box">
                    <label for="" class="menu__update-title">Description</label>
                    <textarea type="text" class="menu__update-input" name="desc"><?php echo $rowMenu['menu_description'] ?></textarea>
                </div>
            </div>
        </div>
        <div class="menu__update-item">
            <div class="menu__update-box">
                <label for="cate" class="menu__update-title">Category</label>
                <select type="text" class="menu__update-input" name="cate">
                <?php
                    $sqlCate = "SELECT * FROM category";
                    $resultCate = mysqli_query($conn, $sqlCate);
                     foreach($resultCate as $cateOpt){ 
                ?>
                    <option value="<?php echo $cateOpt['cate_id'] ?>"
                        <?php  
                            if ($cateOpt['cate_name'] == $rowMenu['cate_name'] ) {
                                echo 'selected';
                            }   
                        ?>
                    >
                        <?php echo $cateOpt['cate_name'] ?>
                    </option>
                <?php 
                    } 
                ?>
                    </option>
                </select>
            </div>
            <div class="menu__update-box">
                <label for="price" class="menu__update-title">Price</label>
                <input type="number" class="menu__update-input" value="<?php echo $rowMenu['menu_price'] ?>" name="price">
            </div>

            <div class="menu__update-button">
                <input type="submit" value="Update" id="updateMenu" name="order">
                <button type="button" id="deleteMenu" data-id="<?php echo $_menuID ?>">Delete</button>
            </div>
        </div>
    </form>
</div>

<script>
    $(document).ready(()=>{
        const deleteButton = $('#deleteMenu'),
              deleteSumit = $('.module__delete-submit'),
              deleteCancel = $('.module__delete-cancel'),
              module = $('.module'),
              moduleDelete = $('.module__delete'),
              moduleBg = $('.module__bg'),
              successText = $('.module__success-text'),
              moduleSuccess = $('.module__success')

        //DELETE MENU
        deleteButton.click(()=>{
            module.addClass('module-active')
            moduleDelete.addClass('module__delete-active')
            moduleBg.addClass('module__bg-active')
            deleteSumit.attr("data-id",deleteButton.attr("data-id"))
        })

        deleteCancel.click(()=>{
            module.removeClass('module-active')
            moduleDelete.removeClass('module__delete-active')
        })

        deleteSumit.click(()=>{
            $.ajax({
                url : './menu-query.php',
                type: 'post',
                data: { 

                deleteID: deleteSumit.attr("data-id"),
                order: 'delete'
                
            },
                success: function(response){
                moduleDelete.removeClass('module__delete-active')
                successText.text('Successfully deleted.')
                moduleSuccess.addClass('module__success-active')
                }
            })
        })

        const inputImage = $('.menu__update-inputImage')
        const image = $('#imageMenu')
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