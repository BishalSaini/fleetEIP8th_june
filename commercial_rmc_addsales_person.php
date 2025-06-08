
<style>
    <?php
include 'style.css'
?>
</style>
<script>
    <?php include 'main.js' ?>

    </script>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">      <link rel="icon" href="favicon.jpg" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="main.js"></script>
    <title>Document</title>
</head>
<body>
    <div class="navbar1">
    <div class="logo_fleet">
    <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='<?php echo $dashboard_url  ?>'">
</div>

        <div class="iconcontainer">
        <ul>
		<li><a href="commercial_rmc_dashboard.php">Dashboard</a></li>
            <li><a href="news/">News</a></li>
            <li><a href="logout.php">Log Out</a></li></ul>
        </div>
</div>
<form action="" class="rmc_sales">
    <div class="rmc_salesperson_container">
        <div class="salespersonhead"><p>Add Sales Person</p></div>
        
        <div class="trial1">
        <input type="text" placeholder="" class="input02">
        <label for="" class="placeholder2">Sales Person Name</label>
        </div>
        <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" class="input02">
                <label for="" class="placeholder2">Current Company</label>
            </div>
            <div class="trial1">
                <input type="date" placeholder="" class="input02">
                <label for="" class="placeholder2">Current Company StartDate</label>
            </div>
        </div>
        <div class="outer02">
            <div class="trial1">
            <input type="text" placeholder="" class="input02">
            <label for="" class="placeholder2">Aadhar Card Number</label>
            </div>
            <div class="trial1">
            <input type="file" placeholder="" class="input02">
            <label for="" class="placeholder2"> Upload Aadhar Card </label>
            </div>
        </div>
        <div class="outer02">
            <div class="trial1">
            <input type="text" placeholder="" class="input02">
            <label for="" class="placeholder2">Pan Card Number</label>
            </div>
            <div class="trial1">
            <input type="file" placeholder="" class="input02">
            <label for="" class="placeholder2"> Upload Pan Card </label>
            </div>
        </div>

        <div class="trial1">
        <input type="text" placeholder="" class="input02">
        <label for="" class="placeholder2">Sales Person Designation</label>
        </div>
        <div class="outer02">
        <div class="trial1">
        <input type="text" placeholder="" class="input02">
        <label for="" class="placeholder2">Mobile Number</label>
        </div>
        <div class="trial1">
        <input type="text" placeholder="" class="input02">
        <label for="" class="placeholder2">Email</label>
        </div>
        </div>
        <div class="trial1">
        <input type="text" placeholder="" class="input02">
        <label for="" class="placeholder2">Assigned Territory</label>
        </div>
        <div class="outer02">
        <div class="trial1">
                <input type="text" placeholder="" class="input02">
                <label for="" class="placeholder2">Bank Name</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" class="input02">
                <label for="" class="placeholder2">Account Number</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" class="input02">
                <label for="" class="placeholder2">IFSC Code</label>
            </div>
        </div>
        <div class="outer02">
        <div class="trial1">
        <input type="text" placeholder="" class="input02">
        <label for="" class="placeholder2">Salary</label>
        </div>
        <div class="trial1">
        <input type="text" placeholder="" class="input02">
        <label for="" class="placeholder2">Traveling Allowance</label>
        </div>
        <div class="trial1">
        <input type="text" placeholder="" class="input02">
        <label for="" class="placeholder2">Accomodation Allowance</label>
        </div>
        <div class="trial1">
        <input type="text" placeholder="" class="input02">
        <label for="" class="placeholder2">Bonus</label>
        </div>
        </div>
        <div class="trial1">
        <select type="text" placeholder="" class="input02" id="insentive_dd" onchange="insentive()">
            <option value="none">Insentive?</option>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
        </select>
        </div>
        <div class="trial1" id="minimum_target">
            <input type="text" placeholder="" class="input02">
            <label for="" class="placeholder2">Minimum Target Quantity</label>
        </div>
        <br>
<button class="epc-button">Submit</button>
<br>

        
    </div>
</form>
<br>
</body>
</html>