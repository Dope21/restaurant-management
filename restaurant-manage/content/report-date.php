<?php require_once("../database/connection.php") ?>    
<?php
    $_date = $_POST['date'];

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
                echo $field['price_hour'];
                if ($field_hour['price_hour'] == '') {
                    $sum = 0;
                } else {
                    $sum = $field_hour['price_hour'];
                }
                array_push($online_hours, $sum);
            }
        ?>
        </div>
        <!-- <div class="report__chart">
            <canvas id="myChart"></canvas>
        </div> -->
        <script>
            var front = <?php echo json_encode($front_hours); ?>;
            var online = <?php echo json_encode($online_hours); ?>;
            var time = [ 
                        '10:00', '11:00','12:00', '13:00', '14:00', '15:00', '16:00', 
                        '17:00', '18:00', '19:00', '20:00', '21:00', '22:00', '23:00'   
                        ];
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
                            max: 20000,
                            min: 0,
                            ticks: {
                                stepSize: 2000
                            }
                        }
                    }
        </script>