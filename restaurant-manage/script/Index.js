$(document).ready(()=>{

    //VARIABLE
    const content = $('.content'),
          navItems = $('.nav__item'),
          navBar = $('.nav'),
          navSubItems = $('.nav__sub-items'),
          navSubIcon = $('.nav__sub-icon'),
          navSubMenu = $('.nav__link-not'),
          navOpen = $('.header__nav-open'),
          profile = $('.header__profile'),
          proSubIcon = $('.header__toggle'),
          proSubItems = $('.header__menu'),
          pageName = $('.header__name'),
          blackBg = $('.black-bg')

    //FIRST LOAD 
    var page = location.hash.substring(
        location.hash.indexOf('#')+1,
    )

    if (page != '') {
        $('#'+page).addClass('nav__item-active')
        content.load('./content/'+page+'.php')
        pageName.text(page);
    } else {
        $('#home').addClass('nav__item-active')
        content.load('./content/home.php')
        pageName.text('home');
    }

    //NAVLINK CLICKED
    window.onpopstate = function(event) {
        var page = location.hash.substr(1);
        if(page != ''){
            navItems.removeClass('nav__item-active')
            $('#'+page).addClass('nav__item-active')
            content.load('./content/'+page+'.php')
            pageName.text(page);
        } else {
            navItems.removeClass('nav__item-active')
            $('#home').addClass('nav__item-active')
            content.load('./content/home.php')
            pageName.text('home');
        }
    }

    // DROPDOWN PROFILE
    profile.click(()=>{  
        proSubIcon.toggleClass('header__toggle-active')
        proSubItems.toggleClass('header__menu-active')
    })

    // DROPDOWN USERS
    navSubMenu.click(()=>{
        navSubIcon.toggleClass('nav__sub-icon-active')
        navSubItems.toggleClass('nav__sub-items-active')
    })

    //ACTIVE NAVBAR FOR MID DEVICES
    navBar.click(()=>{
        navBar.addClass('nav-active')
        blackBg.addClass('black-bg-active')
    })

    navOpen.click(()=>{
        navBar.addClass('nav-active')
        blackBg.addClass('black-bg-active')
    })

    $(document).click((obj)=>{
        if (obj.target.closest(".nav__link") 
            || obj.target.closest(".nav__sub-link") 
            || obj.target.closest(".black-bg") 
            || obj.target.closest('.nav__close'))
        {
            navBar.removeClass('nav-active')
            navSubItems.removeClass('nav__sub-items-active')
            navSubIcon.removeClass('nav__sub-icon-active')
            blackBg.removeClass('black-bg-active')
        } 
    })

    $(document).ajaxStop(function(){ 

        //MODULE VARIABLE
        const addButton = $('#Add'),
              moduleAdd = $('.module__add'),
              moduleInput = $('.module__input-box').find('input'),
              module = $('.module'),
              moduleBg = $('.module__bg'),
              moduleSuccess = $('.module__success'),
              moduleDelete = $('.module__delete'),
              moduleExit = $('.module__title-exit')
        
        //MODULE FUNCION
        addButton.click(()=>{
            moduleAdd.removeClass('module__add-hide')
            moduleInput.val('')
            module.addClass('module-active')
            moduleBg.addClass('module__bg-active')
        })

        moduleExit.click(()=>{
            module.removeClass('module-active')
            moduleBg.removeClass('module__bg-active')
        })

        $(document).click((obj)=>{
            if (obj.target.closest(".module__bg")){
                module.removeClass('module-active')
                moduleBg.removeClass('module__bg-active')
                moduleSuccess.removeClass('module__success-active')
                moduleDelete.removeClass('module__delete-active')
            }
        })

        //DATA TABLE JQUERY
        $('#dataTable').DataTable();

        //COMMA NUMBER
        const homeNum = $('.home__report-number'),
              reportNum = $('.report__item-number'),
              tablePrice = $('.tablePrice')

        homeNum.each((i, num)=>{
            $(num).text(Number($(num).text()).toLocaleString())  
        })

        tablePrice.each((i, price)=>{
            $(price).text(Number($(price).text()).toLocaleString())  
        })
        
        reportNum.each((i, num)=>{
            $(num).text(Number($(num).text()).toLocaleString())  
        })
        
    });
})