<?php require_once("../database/connection.php") ?>
<?php session_start() ?>
<?php 

    //GET TODAY
    date_default_timezone_set("Asia/Bangkok");       
    $_date = date('Y-m-d');

    //SELECT USER
    $_userID = $_SESSION['userID'];
    $sqlUser = "SELECT * FROM employee WHERE emp_id = '$_userID'";
    $resultUser = mysqli_query($conn, $sqlUser);
    $rowUser = mysqli_fetch_array($resultUser);

    //DAILY SALE
    $sql_front = "SELECT SUM(order_price) 
                  AS front_sum
                  FROM front 
                  WHERE '$_date' = order_date
                  AND order_status = 'paid'";
    $result_front = mysqli_query($conn, $sql_front);
    $field_front = mysqli_fetch_array($result_front);
    
    $sql_online = "SELECT SUM(order_price) 
                   AS online_sum
                   FROM delivery 
                   WHERE '$_date' = order_date
                   AND order_status = 'received'";
    $result_online = mysqli_query($conn, $sql_online);
    $field_online = mysqli_fetch_array($result_online);

    $daily_sum = $field_front['front_sum'] + $field_online['online_sum'];

    //ORDER COUNT
    $sql_Fcount = "SELECT COUNT(*) 
                   AS front_count 
                   FROM front 
                   WHERE order_date = '$_date'";
    $query_Fcount = mysqli_query($conn, $sql_Fcount);
    $field_Fcount = mysqli_fetch_array($query_Fcount);

    $sql_Ocount = "SELECT COUNT(*) 
                   AS online_count 
                   FROM delivery 
                   WHERE order_date = '$_date'
                   AND order_status = 'received'";
    $query_Ocount = mysqli_query($conn, $sql_Ocount);
    $field_Ocount = mysqli_fetch_array($query_Ocount);

    $daily_orders = $field_Fcount['front_count'] + $field_Ocount['online_count']; 

    //CUSTOMER COUNT
    $sql_cus = "SELECT COUNT(*)
                AS cus_count
                FROM customer";
    $query_cus = mysqli_query($conn, $sql_cus);
    $field_cus = mysqli_fetch_array($query_cus);

    //EMPLOYEE COUNT
    $sql_emp = "SELECT COUNT(*)
                AS emp_count
                FROM employee";
    $query_emp = mysqli_query($conn, $sql_emp);
    $field_emp = mysqli_fetch_array($query_emp);

    //RECENT ORDER
    $sql_recent = "SELECT * FROM front ORDER BY order_date DESC LIMIT 10";
    $rs_recent = mysqli_query($conn, $sql_recent);

    //NEW ORDER
    $sql_new = "SELECT * 
                FROM delivery 
                INNER JOIN customer
                    ON delivery.cus_id = customer.cus_id
                WHERE order_status = 'waiting'";
    $rs_new = mysqli_query($conn, $sql_new);

?>
<div class="home">
    <div class="home__reports">
        <div class="home__report">
            <div class="home__report-title">
                <h3>Sales</h3>
                <span class="home__report-icon">
                    <i class="fa-solid fa-money-bill-wave"></i>
                </span>
            </div>
            <p class="home__report-number"><?php echo $daily_sum ?></p>
            <a href="#report" class="home__report-link">See All<i class="fa-solid fa-arrow-up-right-from-square"></i></a>
        </div>
        <div class="home__report">
            <div class="home__report-title">
                <h3>Orders</h3>
                <span class="home__report-icon">
                    <i class="fa-solid fa-scroll"></i>
                </span>
            </div>
            <p class="home__report-number"><?php echo $daily_orders ?></p>
            <a href="#history" class="home__report-link">See All<i class="fa-solid fa-arrow-up-right-from-square"></i></a>
        </div>
        <div class="home__report">
            <div class="home__report-title">
                <h3>Members</h3>
                <span class="home__report-icon">
                    <i class="fa-solid fa-users"></i>
                </span>
            </div>
            <p class="home__report-number"><?php echo $field_cus['cus_count'] ?></p>
            <a href="#customer" class="home__report-link">See All<i class="fa-solid fa-arrow-up-right-from-square"></i></a>
        </div>
        <div class="home__report">
            <div class="home__report-title">
                <h3>Employees</h3>
                <span class="home__report-icon">
                    <i class="fa-solid fa-user-tie"></i>
                </span>
            </div>
            <p class="home__report-number"><?php echo $field_emp['emp_count'] ?></p>
            <a href="#employee" class="home__report-link">See All<i class="fa-solid fa-arrow-up-right-from-square"></i></a>
        </div>
    </div>
    <div class="home__table">
        <div class="home__recent">
            <div class="home__table-title">
                <h3>
                    <i class="fa-solid fa-clock-rotate-left"></i>
                    Recent Orders
                </h3>
                <a href="#history">See All<i class="fa-solid fa-arrow-up-right-from-square"></i></a>
            </div>
        <div class="home__table-wrapper">
            <table id="recent">
                <tr>
                    <th>NAME</th>
                    <th>TYPE</th>
                    <th>TIME</th>
                    <th>TOTAL</th>
                </tr>
                <?php 
                    foreach($rs_recent as $recent){

                ?>
                <tr>
                    <td><?php echo $recent['order_name'] ?></td>
                    <td><?php echo $recent['order_cate'] ?></td>
                    <td><?php echo substr($recent['order_time'],0,5) ?></td>
                    <td class="tablePrice"><?php echo $recent['order_price'] ?></td>
                    <td>
                        <i class="fa-solid fa-up-right-from-square recentIcon" data-id="<?php echo $recent['bill_id'] ?>"></i>
                    </td>
                    </tr>
                <?php 
                    }   
                ?>
            </table>
        </div>
        </div>
        <div class="home__new">
            <div class="home__table-title">
                <h3>
                    <i class="fa-solid fa-bell"></i>
                    New Online Orders
                </h3>
                <a href="#online">See All<i class="fa-solid fa-arrow-up-right-from-square"></i></a>
            </div>
            <div class="home__table-wrapper">
                <table id='new'>
                    <tr>
                        <th>NUMBER</th>
                        <th>NAME</th>
                        <th>TIME</th>
                    </tr>
                    <?php 
                        foreach($rs_new as $new){
                    ?>
                    <tr>
                        <td><?php echo $new['bill_id'] ?></td>
                        <td><?php echo $new['cus_fname'] ?></td>
                        <td><?php echo substr($new['order_time'],0,5) ?></td>
                        <td>
                            <i class="fa-solid fa-up-right-from-square newIcon" data-id="<?php echo $new['bill_id'] ?>"></i>
                        </td>
                    </tr>
                    <?php 
                        }
                    ?>
                </table>
            </div>
        </div>
    </div> 
</div>
<script>
    $(document).ready(()=>{
        //HOME TABLE
        const recentIcon = $('.recentIcon'),
              newIcon = $('.newIcon')
              content = $('.content')
        
        recentIcon.each((i, icon)=>{
            $(icon).on('click',()=>{
                content.load('./content/history.php', {
                    orderID: $(icon).data('id'),
                    from: 'home'
                })
            })
        })

        newIcon.each((i, icon)=>{
            $(icon).on('click',()=>{
                console.log($(icon).data('id'))
                content.load('./content/online.php', {
                    orderID: $(icon).data('id'),
                    from: 'home'
                })
            })
        })
    })
</script>
