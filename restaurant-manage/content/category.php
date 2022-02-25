<?php require_once('../database/connection.php') ?>
<?php 
    $sqlCate = "SELECT * FROM category";
    $resultCate = mysqli_query($conn,$sqlCate);
?>
<div class="black-bg"></div>
<div class="category">
    <div class="module">
        <div class="module__bg"></div>
        <div class="module__content">
            <div class="module__add">
                <div class="module__title">
                    <p class="module__title-text">Add Category</p>
                    <div class="module__title-exit"><i class="far fa-times-circle"></i></div>
                </div>
                
                <div class="module__input">
                    <label for="catename" class="module__input-title">Category Name*</label>
                    <input type="text" class="module__input-box" name='catename' placeholder="Enter category name">
                </div>

                <div class="module__button">
                    <input type="submit" id="addCategory" value="Enter">
                </div>
            </div>

            <div class="module__success">
                <p class="module__success-text"></p>
                <div class="module__success-icon"><i class="far fa-check-circle"></i></div>
            </div> 

            <div class="module__delete">
                <p class="module__delete-text">Are you sure you want to delete this user?</p>
                <button type="button" class="module__delete-submit" data-id="">Enter</button>
                <button type="button" class="module__delete-cancel">Cancel</button>
            </div>
        </div>
    </div>

    <div class="category__add">
        <button type="button" id="Add" class="button"><i class="fas fa-plus"></i>Add Category</button>
    </div>
    <div class="category__table" id="tableWrapper">
        <table id="dataTable" class="display">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                while($rowCate = mysqli_fetch_array($resultCate)) {
            ?>
                <tr>
                    <td><?php echo $rowCate['cate_name'] ?></td>
                    <td><div class="table__edit">
                            <i class="fas fa-edit update" data-id="<?php echo $rowCate['cate_id'] ?>"></i>
                            <i class="fas fa-trash delete" data-id="<?php echo $rowCate['cate_id'] ?>"></i>
                        </div>
                    </td>
                </tr>
            <?php
                }
            ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    //MODULE VARIABLE
    const moduleAdd = $('.module__add'),
          moduleSuccess = $('.module__success'),
          moduleDelete = $('.module__delete'),
          deleteIcon = $('.delete'),
          deleteSumit = $('.module__delete-submit'),
          deleteCancel = $('.module__delete-cancel'),
          module = $('.module'),
          moduleBg = $('.module__bg'),
          successText = $('.module__success-text'),
          editIcon = $('.update')
                
            //ADD CATEGORY
            $('#addCategory').click(()=>{

                const catename = $('input[name="catename"]')

                if (catename.val() == '') {
                    catename.addClass('module__input-empty') 
                    return
                } 

                    $.ajax({
                    url : './category-query.php',
                    type: 'post',
                    data: { 
                        
                        Catename: catename.val(),
                        order: 'add'
                    
                    },
                    success: function(response){
                        moduleAdd.addClass('module__add-hide')
                        successText.text('Successfully added.')
                        moduleSuccess.addClass('module__success-active')
                    }
                    })
            })

            //DELETE CATEGORY
            deleteIcon.each((i, obj) =>{
                $(obj).on('click',()=>{
                    module.addClass('module-active')
                    moduleDelete.addClass('module__delete-active')
                    moduleBg.addClass('module__bg-active')
                    moduleAdd.addClass('module__add-hide')
                    deleteSumit.attr("data-id",$(obj).attr("data-id"))
                })
            })

            deleteCancel.click(()=>{
                module.removeClass('module-active')
                moduleDelete.removeClass('module__delete-active')
            })

            deleteSumit.click(()=>{
                $.ajax({
                    url : './category-query.php',
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

            // EDIT CUSTOMER
            editIcon.each((i, obj)=>{
                $(obj).on('click', ()=>{
                    $('.content').load('./content/cate-edit.php', {
                        cateID: $(obj).data('id')
                    })
                })
            })
</script>