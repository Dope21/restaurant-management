<?php require_once("./database/connection.php") ?>
<?php session_start() ?>
<?php

$_empID = '';
if (isset($_SESSION['empID'])) {    
    $_empID = $_SESSION['empID'];
    $sqlUser = "SELECT * FROM employee WHERE emp_id = '$_empID'";
    $resultUser = mysqli_query($conn, $sqlUser);
    $rowUser = mysqli_fetch_array($resultUser);
} else {
    header('location: ./login.php');
}
date_default_timezone_set("Asia/Bangkok");

    $month = array(
        "01"=>"Jan",
        "02"=>"Feb",
        "03"=>"Mar",
        "04"=>"Apr",
        "05"=>"May",
        "06"=>"Jun",
        "07"=>"Jul",
        "08"=>"Aug",
        "09"=>"Sep",
        "10"=>"Oct",
        "11"=>"Nov",
        "12"=>"Dec"
    );
$conDate = date('d').' '.$month[date('m')].', '.date('Y');

    //NEW ORDER
    $sql_Ncount = "SELECT COUNT(*) 
                   AS new_count 
                   FROM delivery 
                   WHERE order_status = 'waiting'";
    $query_Ncount = mysqli_query($conn, $sql_Ncount);
    $field_Ncount = mysqli_fetch_array($query_Ncount);
    $new_orders = $field_Ncount['new_count'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./asset/style/main-style.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="shortcut icon" type="image/png" href="./asset/favicon.svg">
    <title>manage</title>
</head>
<body>
    <nav class="nav">
        <div class="nav__close">
            <i class="fa-solid fa-xmark"></i>
        </div>
        <h1 class="nav__logo">
            <svg width="30" height="29" viewBox="0 0 30 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M8.40964 16.0139L12.8498 11.5737L1.83569 0.57527C-0.611895 3.02285 -0.611895 6.99232 1.83569 9.45559L8.40964 16.0139ZM19.0472 13.174C21.4477 14.288 24.821 13.5035 27.3156 11.0089C30.3123 8.01215 30.8929 3.71319 28.5865 1.40682C26.2958 -0.883864 21.9968 -0.319038 18.9844 2.67768C16.4898 5.17233 15.7053 8.5456 16.8193 10.9461L1.5062 26.2592L3.71844 28.4714L14.5286 17.6926L25.323 28.4871L27.5353 26.2749L16.7408 15.4804L19.0472 13.174Z" 
                      fill="white"/>
            </svg>
            Restaurant
        </h1>   
        <ul class="nav__items">
            <li class="nav__item" id="home"><i class="fa-solid fa-house nav__icon"></i><a href="#home" class="nav__link">Home</a></li>
            <li class="nav__item-drop" id="users"><i class="fas fa-users nav__icon"></i><span class="nav__link-not">Users<i class="fas fa-angle-down nav__sub-icon"></i></span>
                <ul class="nav__sub-items">
                    <li class="nav__sub-item"><a href="#employee" class="nav__sub-link">Employees</a></li>
                    <li class="nav__sub-item"><a href="#customer" class="nav__sub-link">Customers</a></li>
                </ul>
            </li>
            <li class="nav__item" id="category"><i class="fa-solid fa-boxes-stacked nav__icon"></i><a href="#category" class="nav__link">Category</a></li>
            <li class="nav__item" id="menu"><i class="fas fa-book-open nav__icon"></i><a href="#menu" class="nav__link">Menu</a></li>
            <li class="nav__item" id="order"><i class="fas fa-cash-register nav__icon"></i><a href="#order" class="nav__link">Front Order</a>
            </li>
            <li class="nav__item" id="online">
                <i class="fas fa-mobile-alt nav__icon"></i>
                <a href="#online" class="nav__link">Online Order
                    <?php  
                        if ($new_orders != 0) {
                            echo '<span class="nav__noti">'.$new_orders.'</span>';
                        }
                    ?>     
                </a>
            </li>
            <li class="nav__item" id="history"><i class="fas fa-scroll nav__icon"></i><a href="#history" class="nav__link">History</a></li>
            <li class="nav__item" id="report"><i class="fas fa-chart-line nav__icon"></i><a href="#report" class="nav__link">Report</a></li>
            <li class="nav__item" id="setting"><i class="fas fa-cogs nav__icon"></i><a href="#setting" class="nav__link">Setting</a></li>
        </ul>
    </nav> 
    <main class="main">
    <div class="black-bg"></div>
        <div class="header">
            <div class="header__page">
                <span class="header__nav-open">
                    <i class="fa-solid fa-grip-lines"></i>
                </span>
                <h2 class="header__name"></h2>
                <p class="header__date"><i class="fa-regular fa-calendar"></i><?php echo $conDate ?></p>
            </div>
            <div class="header__profile">
                <div class="header__img">
                    <img src="./asset/emp_img/<?php if($rowUser['emp_image'] != '') {
                            echo $rowUser['emp_image'];
                        } else {
                            echo 'user-defult.png';
                        } ?>" 
                    alt="">
                </div>
                <p class="header__user"><?php echo 'Hello, '.$rowUser['emp_fname'] ?></p>
                <div class="header__menu">
                    <ul>
                        <li><a href="#profile"><i class="fa-regular fa-user"></i>Profile</a></li>
                        <li><a href="./content/logout.php"><i class="fa-solid fa-door-open"></i>Log out</a></li>
                    </ul>
                </div>
                <span class="header__toggle"><i class="fa-solid fa-caret-down"></i></span>
            </div>
        </div>
        <article class="content"></article>
    </main> 
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <script src="./asset/script/Index.js?<?php echo time(); ?>"></script>
</body>
</html>