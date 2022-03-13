<?php require_once('../database/connection.php'); ?>
<?php 

$cateName = [];
$menuName = '';

    if (isset($_POST['Filter'])){
        $cateName = $_POST['Filter'];
    }

    if (isset($_POST['menuName'])) {
        $menuName = $_POST['menuName'];
    }

?>

<div class="menu__items">
    <?php 
    
        if ($menuName != '') {
            $sqlMenu = "SELECT * FROM menu WHERE menu_name = '$menuName'";
            $resultMenu = mysqli_query($conn, $sqlMenu);
            foreach ($resultMenu as $rowMenu) {
    ?>  
                <div class="menu__item" data-id="<?php echo $rowMenu['menu_id'] ?>">
                    <div class="menu__img-wrapper">
                        <img src="./menu_img/<?php if ($rowMenu['menu_image'] == '') {
                            echo 'menu-defult.jpg';
                        } else {
                            echo $rowMenu['menu_image'];
                        } ?>" alt="" srcset="">

                        <?php 
                            if ($_POST['orderID'] == ''){
                                echo '<div class="menu__edit" data-id="'.$rowMenu['menu_id'].'">';    
                                    echo '<i class="fas fa-pen"></i>';
                                echo '</div>';
                            }  else {
                                echo '<div class="menu__number">0</div>';
                                echo '<div class="menu__minus"><p>-</p></div>';
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
        } else {
            
            if (empty($cateName)) {

                    $sqlMenu = "SELECT * FROM menu";
                    $resultMenu = mysqli_query($conn, $sqlMenu);

                    foreach ($resultMenu as $rowMenu) {
    ?>
                        <div class="menu__item" data-id="<?php echo $rowMenu['menu_id'] ?>">
                            <div class="menu__img-wrapper">
                                <img src="./menu_img/<?php if ($rowMenu['menu_image'] == '') {
                                    echo 'menu-defult.jpg';
                                } else {
                                    echo $rowMenu['menu_image'];
                                } ?>" alt="" srcset="">

                                <?php 
                                    if ($_POST['orderID'] == ''){
                                        echo '<div class="menu__edit" data-id="'.$rowMenu['menu_id'].'">';    
                                            echo '<i class="fas fa-pen"></i>';
                                        echo '</div>';
                                    }  else {
                                        echo '<div class="menu__number">0</div>';
                                        echo '<div class="menu__minus"><p>-</p></div>';
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
            } else {

                foreach ($cateName as $catename) {

                    $sqlMenu = "SELECT * FROM menu WHERE '$catename' = cate_id";
                    $resultMenu = mysqli_query($conn, $sqlMenu);

                    foreach ($resultMenu as $rowMenu) {             
    ?>
                        <div class="menu__item" data-id="<?php echo $rowMenu['menu_id'] ?>">
                            <div class="menu__img-wrapper">
                                <img src="./menu_img/<?php if ($rowMenu['menu_image'] == '') {
                                    echo 'menu-defult.jpg';
                                } else {
                                    echo $rowMenu['menu_image'];
                                } ?>" alt="" srcset="">

                                <?php 
                                    if ($_POST['orderID'] == ''){
                                        echo '<div class="menu__edit" data-id="'.$rowMenu['menu_id'].'">';    
                                            echo '<i class="fas fa-pen"></i>';
                                        echo '</div>';
                                    }  else {
                                        echo '<div class="menu__number">0</div>';
                                        echo '<div class="menu__minus"><p>-</p></div>';
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
                }
            }
        }
    ?>
</div>

<script>
    $(document).ready(()=>{

        const menuCart = $('#addCart'),
              menuItem = $('.menu__item'),
              editIcon = $('.menu__edit')

        // ADD MENU TO CART
        if (menuCart.length != 0) {

            menuItem.each((i,obj)=>{
                const menuQt = $(obj).find('.menu__number'),
                    menuMinus = $(obj).find('.menu__minus')
                $(obj).on('click',()=>{

                    // SEND VALUE TO SESSION CART
                    $.ajax({
                        url: './cart.php',
                        type: 'post',
                        data: { 
                                insert: 'insert',
                                menuID: $(obj).data('id')
                            },
                        success: (response)=>{
                            console.log(response);
                        }
                    })

                    console.log($(obj).data('id'));

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
                        url: './cart.php',
                        type: 'post',
                        data: { 
                                delete: 'delete',
                                menuID: menuDel
                            },
                        success: (response)=>{
                            console.log(response);
                        }
                    })
                })
            })
        }

        // EDIT MENU
        editIcon.each((i, obj)=>{
        $(obj).on('click', ()=>{
                $('.content').load('./content/menu-edit.php', {
                    menuID: $(obj).data('id')
                })
            })
        })
    })
</script>