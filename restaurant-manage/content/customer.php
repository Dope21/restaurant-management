<?php require_once('../database/connection.php') ?>
<?php 
    $sqlCus = "SELECT * FROM customer";
    $resultCus = mysqli_query($conn,$sqlCus);
?>
<div class="black-bg"></div>
<div class="customer">
    <div class="module">
        <div class="module__bg"></div>
        <div class="module__content">
            <div class="module__add">
                <div class="module__title">
                    <p class="module__title-text">Add Customer</p>
                    <div class="module__title-exit"><i class="far fa-times-circle"></i></div>
                </div>
                
                <div class="module__input">
                    <label for="username" class="module__input-title">Username*</label>
                    <input type="text" class="module__input-box" name='username' placeholder="8-20 characters">
                </div>
                <div class="module__input">
                    <label for="password" class="module__input-title">Password*</label>
                    <input type="text" class="module__input-box" name='password' placeholder="8-20 characters">
                </div>
                <div class="module__input">
                    <p class="module__input-title">Name*</p>
                    <div class="module__input-name">
                        <input type="text" class="module__input-box" name='fname'placeholder="Firstname">
                        <input type="text" class="module__input-box" name='lname'placeholder="Lastname">
                    </div>
                </div>
                <div class="module__input">
                    <label for="address" class="module__input-title">Address</label>
                    <input type="text" class="module__input-box" name='address' placeholder="-">
                </div>
                <div class="module__input">
                    <label for="number" class="module__input-title">Number</label>
                    <input 
                        type="text" class="module__input-box" name='number'
                        pattern="[0-9]+"
                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" 
                        placeholder="-"
                        minlength="10" maxlength="10"
                    >
                </div>

                <div class="module__button">
                    <input type="submit" id="addCustomer" value="Enter">
                </div>
            </div>

            <div class="module__success">
                <p class="module__success-text">Successfully</p>
                <div class="module__success-icon"><i class="far fa-check-circle"></i></div>
            </div> 

            <div class="module__delete">
                <p class="module__delete-text">Are you sure you want to delete this user?</p>
                <button type="button" class="module__delete-submit" data-id="">Enter</button>
                <button type="button" class="module__delete-cancel">Cancel</button>
            </div>
        </div>
    </div>

    <div class="customer__add">
        <button type="button" id="Add" class="button"><i class="fas fa-plus"></i>Add User</button>
    </div>
    <div class="customer__table" id="tableWrapper">
        <table id="dataTable" class="display">
            <thead>
                <tr>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Username</th>
                    <th>Address</th>
                    <th>Number</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                while($rowCus = mysqli_fetch_array($resultCus)) {
            ?>
                <tr>
                    <td><?php echo $rowCus['cus_fname'] ?></td>
                    <td><?php echo $rowCus['cus_lname'] ?></td>
                    <td><?php echo $rowCus['cus_username'] ?></td>
                    <td><?php echo $rowCus['cus_address'] ?></td>
                    <td><?php echo $rowCus['cus_number'] ?></td>
                    <td><div class="table__edit">
                            <i class="fas fa-edit update" data-id="<?php echo $rowCus['cus_id'] ?>"></i>
                            <i class="fas fa-trash delete" data-id="<?php echo $rowCus['cus_id'] ?>"></i>
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
    $(document).ready(()=>{
        
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
                
            //ADD CUSTOMER
            $('#addCustomer').click(()=>{
                // if (window.location.href.indexOf('#customer') <= -1) return

                const username = $('input[name="username"]'),
                    password = $('input[name="password"]'),
                    fname = $('input[name="fname"]'),
                    lname = $('input[name="lname"]'),
                    address = $('input[name="address"]'),
                    number = $('input[name="number"]')

                if (username.val() == '') {
                    username.addClass('module__input-empty') 
                    return
                } 
                if (password.val() == '') {
                    password.addClass('module__input-empty')
                    return
                }
                if (fname.val() == '') {
                    fname.addClass('module__input-empty')
                    return
                } 
                if (lname.val() == '') {
                    lname.addClass('module__input-empty')
                    return
                } 

                    $.ajax({
                    url : './customer-query.php',
                    type: 'post',
                    data: { 
                        
                        Username: username.val(),
                        Password: password.val(),
                        Fname: fname.val(),
                        Lname: lname.val(),
                        Address: address.val(),
                        Number: number.val(),
                        order: 'add'
                    
                    },
                    success: function(response){
                        moduleAdd.addClass('module__add-hide')
                        successText.text('Successfully added.')
                        moduleSuccess.addClass('module__success-active')
                    }
                    })
            })

            //DELETE CUSTOMER
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
                    url : './customer-query.php',
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
                    $('.content').load('./content/cus-profile.php', {
                        userID: $(obj).data('id')
                    })
                })
            })
    })
</script>