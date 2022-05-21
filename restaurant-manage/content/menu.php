<?php require_once('../database/connection.php'); ?>
<?php 

    unset($_SESSION['cart']);
    $sqlCate = "SELECT * FROM category";
    $resultCate = mysqli_query($conn, $sqlCate);

    $_orderID = '';
    if (isset($_POST['orderID'])) {
        $_orderID = $_POST['orderID'];
    }

?>
<div class="black-bg"></div>
<div class="menu">

    <div class="module">
        <div class="module__bg"></div>
        <div class="module__content">
            <div class="module__add">
                <div class="module__title">
                    <p class="module__title-text">Add Menu</p>
                    <div class="module__title-exit"><i class="far fa-times-circle"></i></div>
                </div>
                
                <div class="module__input">
                    <label for="name" class="module__input-title">Name*</label>
                    <input type="text" class="module__input-box" name='name' placeholder="">
                </div>
                <div class="module__input">
                    <label for="type" class="module__input-title">Type</label>
                    <input type="text" class="module__input-box" name='type' placeholder="pork, chicken, beef, etc.">
                </div>
                <div class="module__input">
                    <label for="desc" class="module__input-title">Description</label>
                    <input type="text" class="module__input-box" name='desc' placeholder="">
                </div>
                <div class="module__input">
                    <label for="price" class="module__input-title">Price*</label>
                    <input type="text" class="module__input-box" name='price' placeholder="">
                </div>
                <div class="module__input">
                    <label for="cate" class="module__input-title">Category*</label>
                    <select name="cate" class="module__input-box">
                        <?php 
                            foreach($resultCate as $cateOpt){
                        ?>
                        <option value="<?php echo $cateOpt['cate_id'] ?>"><?php echo $cateOpt['cate_name'] ?></option>
                        <?php 
                            }
                        ?>
                    </select>
                </div>

                <div class="module__button">
                    <input type="submit" id="addMenu" value="Enter">
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

    <div class="menu__add">
        <?php 
            if(isset($_POST['orderID'])){
        ?>
            <div class="menu__cart-button">
                <button type="button" id="addCart" class="button"><i class="fas fa-plus"></i>Add Cart</button>
                <span class="menu__cart-id"><?php echo $_orderID ?></span>
            </div>
        <?php 
            } else {
        ?>
            <div class="menu__add-button">
                <button type="button" id="Add" class="button"><i class="fas fa-plus"></i>Add Menu</button>
            </div>
        <?php
            }
        ?>
        <div class="menu__search">
            <input type="text" placeholder="serach menu's name" class="menu__search-text">
            <button type="button" id="searchMenu" class="button"></i>Search</button>
        </div>
    </div>

    <div class="menu__cate">
    <?php 
        
        
        foreach($resultCate as $cateFilter){

    ?>
        <div class="menu__cate-box">
            <input type="checkbox" value="<?php echo $cateFilter['cate_id'];?>" class="menu__filter" name="menuFilter">
            <p><?php echo $cateFilter['cate_name'];?></p>
        </div>
    <?php
        }
    ?>
    </div>

    <div class="menu__content">
        <div class="menu__items">
            <?php 
                    $sqlMenu = "SELECT * 
                    FROM menu
                    INNER JOIN category
                    ON menu.cate_id = category.cate_id
                    ORDER BY cate_name";

                $resultMenu = mysqli_query($conn, $sqlMenu);
                while($rowMenu = mysqli_fetch_array($resultMenu)){
            ?>
                <div class="menu__item" data-id="<?php echo $rowMenu['menu_id'] ?>">
                    <div class="menu__img-wrapper">
                        <img src="./asset/menu_img/<?php if ($rowMenu['menu_image'] == '') {
                            echo 'menu-defult.jpg';
                        } else {
                            echo $rowMenu['menu_image'];
                        } ?>" alt="" srcset="">

                        <?php 
                            if (isset($_POST['orderID'])){
                                echo '<div class="menu__number">0</div>';
                                echo '<div class="menu__minus"><p>-</p></div>';
                            }  else {
                                echo '<div class="menu__edit" data-id="'.$rowMenu['menu_id'].'">';    
                                    echo '<i class="fas fa-pen"></i>';
                                echo '</div>';
                            }
                        ?> 

                        <div class="menu__text">
                            <p class="menu__title"><?php echo $rowMenu['menu_name']; ?></p>
                            <p class="menu__subtitle"><?php echo $rowMenu['menu_type']; ?></p>
                        </div>
                    </div>
                    
                </div>
                <?php
                    }
                ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(()=>{

            //MODULE VARIABLE
            const moduleAdd = $('.module__add'),
                  moduleSuccess = $('.module__success'),
                  successText = $('.module__success-text'),
                  editIcon = $('.menu__edit'),
                  menuCheckBox = $('.menu__filter'),
                  menuCate = $('.menu__cate-box'),
                  menuContent = $('.menu__content'),
                  menuSearch = $('#searchMenu'),
                  menuSearchBox = $('.menu__search-text'),
                  menuCart = $('#addCart'),
                  menuItem = $('.menu__item'),
                  content = $('.content')

            var filter = [];
                
            //ADD MENU
            $('#addMenu').click(()=>{

                const name = $('input[name="name"]'),
                      type = $('input[name="type"]'),
                      desc = $('input[name="desc"]'),
                      price = $('input[name="price"]'),
                      cate = $('select[name="cate"]')

                if (name.val() == '') {
                    name.addClass('module__input-empty') 
                    return
                } 
                if (price.val() == '') {
                    price.addClass('module__input-empty')
                    return
                }

                if (cate.find(":selected").text() == '') {
                    cate.addClass('module__input-empty')
                    return
                } 

                    $.ajax({
                    url : './functions/menu-query.php',
                    type: 'post',
                    data: { 
                        
                        Name: name.val(),
                        Type: type.val(),
                        Desc: desc.val(),
                        Price: price.val(),
                        Cate: cate.val(),
                        order: 'add'
                    
                    },
                    success: function(response){
                        moduleAdd.addClass('module__add-hide')
                        successText.text('Successfully added.')
                        moduleSuccess.addClass('module__success-active')
                    }
                    })
            })

            // EDIT MENU
            editIcon.each((i, obj)=>{
                $(obj).on('click', ()=>{
                    $('.content').load('./content/menu-edit.php', {
                        menuID: $(obj).data('id')
                    })
                })
            }) 

            // MENU FILTER
            menuCheckBox.each((i, obj)=>{
                // 
                $(obj).on('click',()=>{
                    if ($(obj).is(':checked')) {

                        if (filter.indexOf($(obj).val()) == -1 ){
                            filter.push($(obj).val());

                            menuContent.load('./content/menu-filter.php', {
                                Filter: filter,
                                orderID: "<?php echo $_orderID ?>"
                            })
                        }
                    } else {

                        let unCheck = filter.indexOf($(obj).val());
                        filter[unCheck] = '';
                        menuContent.load('./content/menu-filter.php', {
                            Filter: filter.filter(n => n),
                            orderID: "<?php echo $_orderID ?>"
                        })
                    }
                })
            })

            menuCate.each((i, obj)=>{
                $(obj).on('click',()=>{
                    $(obj).toggleClass('menu__cate-box-active')
                })
            })

            // MENU SEARCH NAME 
            menuSearch.click(()=>{
                
                menuContent.load('./content/menu-filter.php', {
                    menuName: menuSearchBox.val(),
                    orderID: '<?php echo $_orderID ?>'
                })
            })

            // ADD MENU TO CART
            if (menuCart.length != 0) {

                menuItem.each((i,obj)=>{
                    const menuQt = $(obj).find('.menu__number'),
                          menuMinus = $(obj).find('.menu__minus')
                    $(obj).on('click',()=>{

                        // SEND VALUE TO SESSION CART
                        $.ajax({
                            url: './functions/cart.php',
                            type: 'post',
                            data: { 
                                    insert: 'insert',
                                    menuID: $(obj).data('id')
                                 }
                        })


                        //ADD STYLE INTO MENU ITEM
                        menuQt.addClass('menu__item-active')
                        menuMinus.addClass('menu__item-active')

                        //SHOW THE MEN NUMBER THAT ADDED INTO CART
                        menuQt.text(Number(menuQt.text()) + 1)
                        if (menuQt.text() == 0) {
                            menuQt.removeClass('menu__item-active')
                            menuMinus.removeClass('menu__item-active')
                        }
                    })

                    //DELECTE MENU FROM CART
                    menuMinus.click(()=>{

                        //REMOVE THE MENU BY 1 
                        menuQt.text(Number(menuQt.text()) - 2)

                        let menuDel = $(obj).data('id')
                        $.ajax({
                            url: './functions/cart.php',
                            type: 'post',
                            data: { 
                                    delete: 'delete',
                                    menuID: menuDel
                            }
                        })
                    })
                })
            }

            // MENU ADD CART
            menuCart.click(()=>{
                $.ajax({
                    url: './functions/cart.php',
                    type: 'post',
                    data: { orderID: '<?php echo $_orderID ?>' },
                    success: (response)=>{
                        content.load('./content/order.php');
                    }
                }) 
            })

            
    })
</script>