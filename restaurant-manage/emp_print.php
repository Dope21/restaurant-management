<?php require_once("./database/connection.php") ?>
<?php 

    $sql = "SELECT * FROM employee";
    $query = mysqli_query($conn, $sql);
?>
<div class="emp__print-wrapper">
    <table>
        <tr>
            <th>firstname</th>
            <th>lastname</th>
            <th>username</th>
            <th>password</th>
            <th>address</th>
            <th>number</th>
            <th>status</th>
        </tr>
        <?php 
            foreach($query as $row){
        ?>
        <tr>
            <td><?php echo $row['emp_fname'] ?></td>
            <td><?php echo $row['emp_lname'] ?></td>
            <td><?php echo $row['emp_username'] ?></td>
            <td><?php echo $row['emp_password'] ?></td>
            <td><?php echo $row['emp_address'] ?></td>
            <td><?php echo $row['emp_number'] ?></td>
            <td><?php echo $row['emp_status'] ?></td>
        </tr>
        <?php 
            }
        ?>
    </table>
    <div class="back__button"> 
        <a href="./index.php#employee">Back to employee</a>
    </div>    
</div>

<style>
@import url('https://fonts.googleapis.com/css2?family=Gwendolyn:wght@700&family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap');

    .emp__print-wrapper{
        font-family: 'Poppins',sans-serif;
        display: flex;
        flex-direction: column;
        margin-top: 0;
    }

    table{
        width: 100%;
        text-align: center;
        padding: .75rem;
        border: 1px solid black;
        border-collapse: collapse;
    }

    td{
        text-align: left;
        border: 1px solid black;
        padding: 5px;
    }
    th{
        border: 1px solid black;
        padding: 5px;
    }
    tr{
        border: 1px solid black;
    }
    div{
        width: 100%;
        display: flex;
        justify-content: center;
        margin-top: 3rem;
    }
    a{
        color: #06FF3D;
    }

    @media print {
        a{
            display: none;
        }
    }
</style>
<script>
    window.print();

</script>