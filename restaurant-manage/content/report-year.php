<?php require_once("../database/connection.php") ?>
<?php 
    $_year = $_POST['year'];

    $sql_front = "SELECT SUM(order_price) 
                  AS front_sum
                  FROM front 
                  WHERE YEAR(order_date) = '$_year'";
    $result_front = mysqli_query($conn, $sql_front);
    $field_front = mysqli_fetch_array($result_front);

    $sql_online = "SELECT SUM(order_price) 
                   AS online_sum
                   FROM delivery 
                   WHERE YEAR(order_date) = $_year";
    $result_online = mysqli_query($conn, $sql_online);
    $field_online = mysqli_fetch_array($result_online);

    $daily_sum = $field_front['front_sum'] + $field_online['online_sum']; 
?>             
    <div class="report__sale">
        <div class="report__item">
            <h2 class="report__item-title">
                YEARLY SALE
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
        $array_months = array('01','02','03','04','05', '06', '07', '08', '09', '10', '11', '12');
        $front_months = array();
        $online_months = array();

        foreach($array_months as $month){
            
            $sql_month = "SELECT SUM(order_price)
                        AS price_month
                        FROM front
                        WHERE MONTH(order_date) = '$month'
                        AND YEAR(order_date) = '$_year'";
            $result_month = mysqli_query($conn, $sql_month);
            $field_month = mysqli_fetch_array($result_month);
            if ($field_month['price_month'] == '') {
                $sum = 0;
            } else {
                $sum = $field_month['price_month'];
            }
            array_push($front_months, $sum);
            echo mysqli_error($conn);
        }
        foreach($array_months as $month){
            
            $sql_month = "SELECT SUM(order_price)
                          AS price_month
                          FROM delivery
                          WHERE MONTH(order_date) = '$month'
                          AND YEAR(order_date) = '$_year'";
            $result_month = mysqli_query($conn, $sql_month);
            $field_month = mysqli_fetch_array($result_month);
            if ($field_month['price_month'] == '') {
                $sum = 0;
            } else {
                $sum = $field_month['price_month'];
            }
            array_push($online_months, $sum);
        }
    ?>
    <script>
            var front = <?php echo json_encode($front_months); ?>;
            var online = <?php echo json_encode($online_months); ?>;
            var time = ['01','02','03','04','05', '06', '07', '08', '09', '10', '11', '12']
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
                            max: 500000,
                            min: 0,
                            ticks: {
                                stepSize: 50000
                            }
                        }
                    }
    </script>