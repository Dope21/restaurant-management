$(document).ready(()=>{

    // NAVBAR
    const navItems = $('.nav-item')
    navItems.each((i, nav)=>{
        $(nav).on('click',()=>{
            navItems.removeClass('nav-active')
            $(nav).addClass('nav-active')
        })
    })


    // HOME PAGE
    const heroScroll = $('.hero__button')
    heroScroll.click(()=>{

        heroScroll.find('.hero__scroll').addClass('hero__scroll-active')
    })


    // MENU PAGE
    const filters = $('.menu__filter-box'),
          searchMenu = $('#searchMenu'),
          inputMenu = $('input[name="menu-name"]'),
          menuitems = $('.menu__items')

    filters.each((i, filter)=>{

        $(filter).on('click',()=>{
            filters.removeClass('menu__filter-box-active')
            $(filter).addClass('menu__filter-box-active')

            menuitems.load('./components/menu-filter.php', {
                cateID: $(filter).data('id')
            })
        })
    })

    searchMenu.click(()=>{
        
        if (inputMenu.val() == '') return
        menuitems.load('./components/menu-search.php',{
            name: inputMenu.val()
        })
    })

    // DETAIL PAGE
    const plus = $('#plus'),
          minus = $('#minus'),
          number = $('.detail__qt-number'),
          menuQt = $('#menuQt')

    plus.click(()=>{
        number.text(Number(number.text())+1)
        menuQt.val(number.text())
    })

    minus.click(()=>{
        if (number.text() == 0) return
        number.text(Number(number.text())-1)
        menuQt.val(number.text())
    })

    // CART PAGE
    const inputQt = $('input[name=menu_qt]'),
          cartUpdate = $('#cart__update'),
          cartItems = $('.cart__items')

    cartUpdate.click(()=>{

        let value = [];

        inputQt.each((i, qt)=>{
            value.push($(qt).val())
        })

        $.ajax({
            type: "POST",
            url: './cart-update.php',
            data: {
                cartQt: value
            },
            success: ()=>{
                window.location="index.php?content=cart"
            }
        });
    }) 
})