<?php session_start() ?>
<?php require_once("../database/connection.php") ?>     
<div class="black-bg"></div>
<?php 

    if($_SESSION['status'] != 'admin') {
?>
<div>
    <p class="access denied">You do not have permission to access this page. </p>
</div>
<?php 
    } else {

?>
<div class="report">
    <div class="report__search">
        <div class="report__filter">
            <div class="report__filter-box report__filter-box-active" data-search="daily">
                <p>DAILY</p>
            </div>
            <div class="report__filter-box" data-search="monthly">
                <p>MONTHLY</p>
            </div>
            <div class="report__filter-box" data-search="yearly" data-year="<?php echo $_year ?>">
                <p>YEARLY</p>
            </div>
        </div>

        <div class="report__input">
            <input type="date" name="date">
        </div>
    </div>
    <div class="report__content">
        <?php
            date_default_timezone_set("Asia/Bangkok");
                    
            $_date = date('Y-m-d');
            $_month = date('m');
            $_year = date('Y');

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
        
        ?>
        <div class="report__sale">
            <div class="report__item">
                <h2 class="report__item-title">
                    DAILY SALE
                    <span class="report__item-icon">
                        <i class="fa-solid fa-money-bill-wave"></i>
                    </span>
                </h2>
                <p class="report__item-number">
                    <?php
                        if ($daily_sum == '') {
                            echo 0;
                        } else {
                            echo $daily_sum;
                        }
                    ?>
                 </p>
            </div>
            <div class="report__item">
                <h2 class="report__item-title">
                    FRONT SALE
                    <span class="report__item-icon">
                        <i class="fas fa-cash-register"></i>
                    </span>
                </h2>
                <p class="report__item-number">
                    <?php 
                        if ($field_front['front_sum'] == '') {
                            echo 0;
                        } else {
                            echo $field_front['front_sum'];
                        }
                    ?>
                </p>
            </div>
            <div class="report__item">
                <h2 class="report__item-title">
                    ONLINE SALE
                    <span class="report__item-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </span>
                </h2>
                <p class="report__item-number">
                    <?php 
                        if ($field_online['online_sum'] == '') {
                            echo 0;
                        } else {
                            echo $field_online['online_sum']; 
                        }   
                    ?>
                </p>
            </div>
        <?php
            $array_hours = array('10:00:00', '11:00:00','12:00:00', '13:00:00', '14:00:00', '15:00:00', '16:00:00', 
                                 '17:00:00', '18:00:00', '19:00:00', '20:00:00', '21:00:00', '22:00:00', '23:00:00');
            $front_hours = array();
            $online_hours = array();

            foreach($array_hours as $hour){

                $sub_hour = substr($hour,0,2).':59:59';

                $sql_hour = "SELECT SUM(order_price)
                             AS price_hour
                             FROM front
                             WHERE order_time >= '$hour'
                             AND order_time <= '$sub_hour'
                             AND order_date = '$_date'";
                $result_hour = mysqli_query($conn, $sql_hour);
                $field_hour = mysqli_fetch_array($result_hour);
                if ($field_hour['price_hour'] == '') {
                    $sum = 0;
                } else {
                    $sum = $field_hour['price_hour'];
                }
                array_push($front_hours, $sum);
            }

            foreach($array_hours as $hour){

                $sub_hour = substr($hour,0,2).':59:59';

                $sql_hour = "SELECT SUM(order_price)
                             AS price_hour
                             FROM delivery
                             WHERE order_time >= '$hour'
                             AND order_time <= '$sub_hour'
                             AND order_date = '$_date'";
                $result_hour = mysqli_query($conn, $sql_hour);
                $field_hour = mysqli_fetch_array($result_hour);
                if ($field_hour['price_hour'] == '') {
                    $sum = 0;
                } else {
                    $sum = $field_hour['price_hour'];
                }
                array_push($online_hours, $sum);
            }
        ?>
        </div>
        <script>
            var front = <?php echo json_encode($front_hours); ?>;
            var online = <?php echo json_encode($online_hours); ?>;
            var time = [ 
                        '10:00', '11:00','12:00', '13:00', '14:00', '15:00', '16:00', 
                        '17:00', '18:00', '19:00', '20:00', '21:00', '22:00', '23:00'   
                        ]
            var data = {
                labels: time,
                datasets: [{
                    label: 'front order',
                    data: front,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                },
                {
                    label: 'online order',
                    data: online,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            }
            var scale = {
                        y: {
                            beginAtZero: true,
                            max: 10000,
                            min: 0,
                            ticks: {
                                stepSize: 2000
                            }
                        }
                    }
        </script>
    </div>
    <div class="report__table">
        <div class="report__chart">
            <canvas id="myChart"></canvas>
        </div>
        <div class="report__menu">
            <div class="report__menu-title">
                <p>FAVORITES MENU</p>
            </div>
            <table id='report__menu'>
                <tr>
                    <th>Menu</th>
                    <th>Dish</th>
                </tr>
            <?php 
                $sql_menu = "SELECT menu_name, 
                                    SUM(order_details.menu_qt) AS menu_count
                             FROM order_details
                             JOIN menu
                                ON order_details.menu_id = menu.menu_id
                             JOIN front
                                ON front.bill_id = order_details.bill_id
                             WHERE order_date = '$_date'
                             GROUP BY menu.menu_name
                             ORDER BY menu_count DESC
                             LIMIT 5";
                $query = mysqli_query($conn, $sql_menu);
                echo mysqli_error($conn);
                foreach($query as $fav){
            ?>
                <tr>
                    <td><?php echo $fav['menu_name'] ?></td>
                    <td class="report__highlight"><?php echo $fav['menu_count'] ?></td>
                </tr>
            <?php 
                }
            ?>
            </table>
        </div>
    </div>

</div>
<?php 
    }
?>
<script>
    $(document).ready(()=>{
        $('#myChart').remove();
        $('.report__chart').append('<canvas id="myChart"></canvas>')
        
            // CHART
            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: data,
                options: {
                    responsive: true,
                    scales: scale
                }
            })

        const filters = $('.report__filter-box'),
              reportContent = $('.report__content'),
              input = $('.report__input'),
              date = $('input[name="date"]'),
              reportSale = $('.report__sale'),
              reportMenu = $('.report__menu')

        filters.each((i, obj)=>{
            $(obj).on('click',()=>{
                myChart.destroy();

                filters.removeClass('report__filter-box-active')
                $(obj).addClass('report__filter-box-active')
   
                input.load('./content/report-input.php',{
                    input: $(obj).data('search')
                })

                if ($(obj).data('search') == 'daily') {
                    reportContent.load('./content/report-date.php',{
                        date: '<?php echo $_date ?>'
                    })

                    reportMenu.load('./content/favmenu-date.php',{
                        date: '<?php echo $_date ?>'
                    })
                } 
                if ($(obj).data('search') == 'monthly') {
                    reportContent.load('./content/report-month.php',{
                        month: '<?php echo $_month ?>',
                        year: '<?php echo $_year ?>'
                    })

                    reportMenu.load('./content/favmenu-month.php',{
                        month: '<?php echo $_month ?>',
                        year: '<?php echo $_year ?>'
                    })
                } 
                if ($(obj).data('search') == 'yearly') {
                    reportContent.load('./content/report-year.php',{
                        year: '<?php echo $_year ?>'
                    })

                    reportMenu.load('./content/favmenu-year.php',{
                        year: '<?php echo $_year ?>'
                    })
                    
                } 
            })
        })

        date.change(()=>{
            reportContent.load('./content/report-date.php',{
                date: date.val()
            })

            reportMenu.load('./content/favmenu-date.php',{
                date: date.val()
            })
        })

        $(document).ajaxStop(()=>{

            if (location.hash != '#report') return

            $('#myChart').remove();
            $('.report__chart').append('<canvas id="myChart"></canvas>')
            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: data,
                options: {
                    responsive: true,
                    scales: scale
                }
            })
        })
    })
</script>