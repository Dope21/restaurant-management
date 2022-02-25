<?php 
    if ($_POST['input'] == 'daily') {
?>
    <input type="date" name="date">
<?php 
    }
    if ($_POST['input'] == 'monthly') {
?>
    <select name="month" id="">
        <option value="01">January</option>
        <option value="02">February </option>
        <option value="03">March</option>
        <option value="04">April</option>
        <option value="05">May </option>
        <option value="06">June</option>
        <option value="07">July</option>
        <option value="08">August</option>
        <option value="09">September</option>
        <option value="10">October</option>
        <option value="11">November</option>
        <option value="12">December</option>
    </select>
    <select name="year" id="">
        <option value="2022">2022</option>
        <option value="2023">2023</option>
        <option value="2024">2024</option>
        <option value="2025">2025</option>
        <option value="2026">2026</option>
    </select>
<?php 
    }
    if ($_POST['input'] == 'yearly') {
?>
    <select name="year" id="">
        <option value="2022">2022</option>
        <option value="2023">2023</option>
        <option value="2024">2024</option>
        <option value="2025">2025</option>
        <option value="2026">2026</option>
    </select>
<?php 
    }
?>
<script>
    $(document).ready(()=>{

        const date = $('input[name="date"]'),
              month = $('select[name="month"]'),
              year = $('select[name="year"]'),
              reportContent = $('.report__content'),
              reportMenu = $('.report__menu')        
        
        date.change(()=>{
            reportContent.load('./content/report-date.php',{
                date: date.val()
            })

            reportMenu.load('./content/favmenu-date.php', {
                date: date.val()
            })
        })

        if (month.length > 0) {
            month.change(()=>{
                reportContent.load('./content/report-month.php',{
                    month: month.find(':selected').val(),
                    year: year.find(':selected').val()
                })

                reportMenu.load('./content/favmenu-month.php',{
                    month: month.find(':selected').val(),
                    year: year.find(':selected').val()
                })
            })

            year.change(()=>{
                reportContent.load('./content/report-month.php',{
                    month: month.find(':selected').val(),
                    year: year.find(':selected').val()
                })

                reportMenu.load('./content/favmenu-month.php',{
                    month: month.find(':selected').val(),
                    year: year.find(':selected').val()
                })
            })
        }
        
        if (month.length == 0) {
            year.change(()=>{
                reportContent.load('./content/report-year.php',{
                        year: year.find(':selected').val()
                    })

                reportMenu.load('./content/favmenu-year.php',{
                    year: year.find(':selected').val()
                })
            })
        }

    })
</script>


