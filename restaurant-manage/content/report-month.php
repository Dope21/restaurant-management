<?php require_once("../database/connection.php") ?>
<?php 
    $_month = $_POST['month'];
    $_year = $_POST['year'];
    // echo $_month.'<br>';
    // echo $_year.'<br>';

    $sql_front = "SELECT SUM(order_price) 
                  AS front_sum
                  FROM front 
                  WHERE MONTH(order_date) = $_month
                  AND YEAR(order_date) = $_year";
    $result_front = mysqli_query($conn, $sql_front);
    $field_front = mysqli_fetch_array($result_front);


    $sql_online = "SELECT SUM(order_price) 
                   AS online_sum
                   FROM delivery 
                   WHERE MONTH(order_date) = $_month
                   AND YEAR(order_date) = $_year";
    $result_online = mysqli_query($conn, $sql_online);
    $field_online = mysqli_fetch_array($result_online);

    $daily_sum = $field_front['front_sum'] + $field_online['online_sum']; 
?>          
    <div class="report__sale">
        <div class="report__item">
            <h2 class="report__item-title">
                MONTHY SALE
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
    </div>
    <?php 
        $array_days = array('01','08','15','22','29');
        $front_days = array();
        $online_days = array();

        foreach($array_days as $day){

            $sub_day = $_year.'-'.$_month.'-'.$day;
            if ($day == '29') {
                $week = $_year.'-'.$_month.'-'.($day+2);
            } else {
                $week = $_year.'-'.$_month.'-'.($day+6);
            }
            $sql_day = "SELECT SUM(order_price)
                        AS price_day
                        FROM front
                        WHERE order_date >= '$sub_day'
                        AND order_date <= '$week'";
            $result_day = mysqli_query($conn, $sql_day);
            $field_day = mysqli_fetch_array($result_day);
            if ($field_day['price_day'] == '') {
                $sum = 0;
            } else {
                $sum = $field_day['price_day'];
            }
            array_push($front_days, $sum);
        }

        foreach($array_days as $day){

            $sub_day = $_year.'-'.$_month.'-'.$day;
            if ($day == '29') {
                $week = $_year.'-'.$_month.'-'.($day+2);
            } else {
                $week = $_year.'-'.$_month.'-'.($day+6);
            }
            $sql_day = "SELECT SUM(order_price)
                        AS price_day
                        FROM delivery
                        WHERE order_date >= '$sub_day'
                        AND order_date <= '$week'";
            $result_day = mysqli_query($conn, $sql_day);
            $field_day = mysqli_fetch_array($result_day);
            if ($field_day['price_day'] == '') {
                $sum = 0;
            } else {
                $sum = $field_day['price_day'];
            }
            array_push($online_days, $sum);
        }
    ?>
    <!-- <div class="report__chart">
        <canvas id="myChart"></canvas>
    </div> -->
    <script>
            var front = <?php echo json_encode($front_days); ?>;
            var online = <?php echo json_encode($online_days); ?>;
            var time = [ '01-07','08-14','15-21','22-28','29-31'];
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
            };
            var scale = {
                        y: {
                            beginAtZero: true,
                            max: 100000,
                            min: 0,
                            ticks: {
                                stepSize: 5000
                            }
                        }
                    }
    </script>