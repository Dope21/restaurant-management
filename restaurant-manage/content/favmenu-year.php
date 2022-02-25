<?php require_once("../database/connection.php") ?>        
<div class="report__menu-title">
    <p>TOP MENU</p>
    </div>
    <table id='report__menu'>
        <tr>
            <th>Menu</th>
            <th>Dish</th>
        </tr>
    <?php 
        $_year = $_POST['year'];
        // echo $_year.'<br>';

        $sql_menu = "SELECT menu_name, 
                            SUM(order_details.menu_qt) AS menu_count
                        FROM order_details
                        JOIN menu
                            ON order_details.menu_id = menu.menu_id
                        JOIN front
                            ON front.bill_id = order_details.bill_id
                        WHERE YEAR(order_date) = '$_year'
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