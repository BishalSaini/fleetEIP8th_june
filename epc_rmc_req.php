<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
include 'partials/_dbconnect.php';
$project_code=$_POST['project_code'];
$proj_name=$_POST['project_name'];
$proj_type=$_POST['project_type'];
$proj_location=$_POST['project_location'];
$site_pincode=$_POST['site_pincode'];
$date_req=$_POST['date_req'];
$completion_time=$_POST['completion_time'];
$month_date=$_POST['month_days'];
$tm_req=$_POST['tm_req'];
$note=$_POST['note_vendor'];
$pouring_equip=$_POST['pour_equip'];
$num_pouring_equip=$_POST['no_of_pouring_equip'];





}
?>

<script>
    <?php include "main.js" ?>
    </script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">      <link rel="icon" href="favicon.jpg" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
    <!-- <script src="main.js"></script> -->
    <title>Document</title>
</head>
<body>
    <div class="navbar1">
    <div class="logo_fleet">
    <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='<?php echo $dashboard_url  ?>'">
</div>

        <div class="iconcontainer">
        <ul>
            <li><a href="epc_dashboard.php">Dashboard</a></li>
            <li><a href="view_news_epc.php">News</a></li>
            
            <li><a href="logout.php">Log Out</a></li></ul>
        </div>
    </div> 

    <form action="epc_rmc_req.php" method="POST" class="rmc_epc_req">
        <div class="rmc_req_container">
            <div class="rmc_req_heading"><p>RMC Requirement</p></div>

            <div class="trial1">
                <select name="" id="rmc_type_dd" class="input02" onchange="new_page()">
                    <!-- <option value=""disabled selected>Select Requirement Type</option> -->
                    <option value="Commercial RMC" selected>Commercial RMC</option>
                    <option value="Dedicated RMC">Dedicated RMC</option>
                </select>
            </div>
            <div class="outer02">
        <div class="trial1">
                <input type="text" name="project_code" placeholder="" class="input02">
                <label for="" class="placeholder2">Project Code</label>
            </div>
            <div class="trial1">
                <input type="text" name="project_name" placeholder="" class="input02">
                <label for="" class="placeholder2">Project Name</label>
            </div>
            <div class="trial1">
        <select class="input02" name="project_type" id="">
            <option value="" disabled selected>Choose Project Type</option>
            <option value="Urban Infra">Urban Infra</option>
            <option value="PipeLine">PipeLine</option>
            <option value="Marine">Marine</option>
            <option value="Road">Road</option>
            <option value="Bridge And Metro">Bridge And Metro</option>
            <option value="Plant">Plant</option>
            <option value="Refinery">Refinery</option>
            <option value="other">Others</option>
        </select>
        </div>
        </div>
            <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" name="project_location" class="input02">
                <label for="" class="placeholder2">Project Location</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="site_pincode" class="input02">
                <label for="" class="placeholder2">Site Pincode</label>
            </div>
            <div class="trial1">
                <input type="date" placeholder="" name="date_req" class="input02">
                <label for="" class="placeholder2">Date Of Requirement</label>
            </div>
            </div>
            <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" name="completion_time" class="input02">
                <label for="" class="placeholder2">Completion Time</label>
            </div>
            <div class="trial1">
            <select name="month_days" id="" class="input02">
                <option value=""disabled selected>Select An Option</option>
                <option value="Month">Month</option>
                <option value="Days">Days</option>
            </select>
            </div>
            <div class="trial1">
                <input type="text" name="tm_req" placeholder="" class="input02">
                <label for="" class="placeholder2">TM Qty Required</label>
            </div>
            </div>
            
            
        <div class="trial1">
            <p class="boq">BOQ</p>
        </div>
        <div class="trial1">
            <textarea type="text" name="note_vendor" class="input02" placeholder=""></textarea>
            <label for="" class="placeholder2">Notes For Vendor</label>
        </div>
        <div class="outer02_rmc">
        <div class="trial1">
            <select name="pour_equip" id="pouring_equip" class="input02 " onchange="dd_hide1()">
                <option value=""disabled selected>Choose Concrete Pouring Equipment</option>
                <option value="Concrete Pump">Concrete Pump</option>
                <option value="Boomplacer">Boomplacer</option>
                <option value="Not Applicable">Not Applicable</option>
            </select>
        </div>
        
        <div class="trial1" id='no_of_equipment_required'>
            <input type="text" name="no_of_pouring_equip" class="input02 " placeholder="">
            <label for="" class="placeholder2">No Of Pouring Equipment Required</label>
        </div>
        </div>

        <div class="outer02" id="first_particular">
            <!-- <div class="trial1">
                <input type="text" placeholder="" class="input02">
                <label for="" class="placeholder2"> 1st Particular</label>
            </div> -->
            <div class="outer02">
            <div class="trial1">
            <select name="grade1" id="" class="input02">
        <option value=""disabled selected>Grade</option>
        <option value="10">M10</option>
        <option value="15">M15</option>
        <option value="20">M20</option>
        <option value="25">M25</option>
        <option value="30">M30</option>
        <option value="35">M35</option>
        <option value="40">M40</option>
        <option value="45">M45</option>
        <option value="50">M50</option>
        <option value="55">M55</option>
        <option value="60">M60</option>
        <option value="65">M65</option>
        <option value="70">M70</option>
        <option value="75">M75</option>
        <option value="80">M80</option>
        <option value="85">M85</option>
        <option value="90">M90</option>
        <option value="95">M95</option>
        <option value="100">M100</option>
                
            </select></div>
            <div class="trial1">
                <input type="text" name="qty1" class="input02" placeholder="">
                <label for="" class="placeholder2">Quantity</label>
            
            </div>
            </div>
            <div class="outer02" >
            <div class="trial1">
            <input type="text" placeholder="" name="cement_1" class="input02">
            <label for="" class="placeholder2">Cement Qty In KG</label>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" name="fly_ash_1" class="input02">
            <label for="" class="placeholder2">Fly Ash Qty In KG</label>
        </div>
        <div class="abcd" id="first_plus" onclick="first_plus_click()">
            <i class="fa-solid fa-plus"></i>
            </div>
        </div>
        <!-- <div class="outer03" id="first_kg"> -->

       
        <!-- </div> -->
        </div>
        
        <!-- 2nd -->
        <!-- <div class="outer4" id="second_particular"> -->
        <div class="outer3" id="second_particular">
        <div class="outer02" >
            <!-- <div class="trial1">
                <input type="text" placeholder="" class="input02">
                <label for="" class="placeholder2">2nd Particular</label>
            </div> -->
            <div class="outer02">
            <div class="trial1">
            <select name="grade2" id="" class="input02">
        <option value=""disabled selected>Grade</option>
        <option value="10">M10</option>
        <option value="15">M15</option>
        <option value="20">M20</option>
        <option value="25">M25</option>
        <option value="30">M30</option>
        <option value="35">M35</option>
        <option value="40">M40</option>
        <option value="45">M45</option>
        <option value="50">M50</option>
        <option value="55">M55</option>
        <option value="60">M60</option>
        <option value="65">M65</option>
        <option value="70">M70</option>
        <option value="75">M75</option>
        <option value="80">M80</option>
        <option value="85">M85</option>
        <option value="90">M90</option>
        <option value="95">M95</option>
        <option value="100">M100</option>
                
            </select></div>
            <div class="trial1">
                <input type="text" name="qty2" class="input02" placeholder="">
                <label for="" class="placeholder2">Quantity</label>
            
            </div>
            </div>
            <div class="outer02" >
            <div class="trial1">
            <input type="text" placeholder="" name="cement_2" class="input02">
            <label for="" class="placeholder2">Cement Qty In KG</label>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" name="fly_ash_2" class="input02">
            <label for="" class="placeholder2">Fly Ash Qty In KG</label>
        </div>
        <div class="abcd" id="second_plus" onclick="second_plus_click()">
            <i class="fa-solid fa-plus"></i>
            </div>
        </div>
 

        </div>
        <!-- <div class="outer03" id="second_kg"> -->
        <!-- </div> -->
        <!-- </div> -->
        </div>

        <div class="outer3" id="third_particular">
        <div class="outer02" >
            <!-- <div class="trial1">
                <input type="text" placeholder="" class="input02">
                <label for="" class="placeholder2">3rd Particular</label>
            </div> -->
            <div class="outer02">
            <div class="trial1">
            <select name="grade3" id="" class="input02">
        <option value=""disabled selected>Grade</option>
        <option value="10">M10</option>
        <option value="15">M15</option>
        <option value="20">M20</option>
        <option value="25">M25</option>
        <option value="30">M30</option>
        <option value="35">M35</option>
        <option value="40">M40</option>
        <option value="45">M45</option>
        <option value="50">M50</option>
        <option value="55">M55</option>
        <option value="60">M60</option>
        <option value="65">M65</option>
        <option value="70">M70</option>
        <option value="75">M75</option>
        <option value="80">M80</option>
        <option value="85">M85</option>
        <option value="90">M90</option>
        <option value="95">M95</option>
        <option value="100">M100</option>
                
            </select></div>
            <div class="trial1">
                <input type="text" class="input02" name="qty3" placeholder="">
                <label for="" class="placeholder2">Quantity</label>
            
            </div>
        </div>
            <div class="outer02" >
            <div class="trial1">
            <input type="text" placeholder="" name="cement_3" class="input02">
            <label for="" class="placeholder2">Cement Qty In KG</label>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" name="fly_ash3" class="input02">
            <label for="" class="placeholder2">Fly Ash Qty In KG</label>
        </div>
        <div class="abcd" id="third_plus" onclick="third_plus_click()">
            <i class="fa-solid fa-plus"></i>
            </div>
        </div>
        </div>
        </div>
        <!-- <div class="outer03" id="third_kg"> -->
          



        <div class="outer3" id="fourth_particular">
        <div class="outer02" >
            <!-- <div class="trial1">
                <input type="text" placeholder="" class="input02">
                <label for="" class="placeholder2">4th Particular</label>
            </div> -->
            <div class="outer02">
            <div class="trial1">
            <select name="grade4" id="" class="input02">
        <option value=""disabled selected>Grade</option>
        <option value="10">M10</option>
        <option value="15">M15</option>
        <option value="20">M20</option>
        <option value="25">M25</option>
        <option value="30">M30</option>
        <option value="35">M35</option>
        <option value="40">M40</option>
        <option value="45">M45</option>
        <option value="50">M50</option>
        <option value="55">M55</option>
        <option value="60">M60</option>
        <option value="65">M65</option>
        <option value="70">M70</option>
        <option value="75">M75</option>
        <option value="80">M80</option>
        <option value="85">M85</option>
        <option value="90">M90</option>
        <option value="95">M95</option>
        <option value="100">M100</option>
                
            </select></div>
            <div class="trial1" >
                <input type="text" name="qty4" class="input02" placeholder="">
                <label for="" class="placeholder2">Quantity</label>
            
            </div>
            </div>
            <div class="outer02">
            <div class="trial1" >
            <input type="text" placeholder="" name="cmnt4" class="input02">
            <label for="" class="placeholder2">Cement Qty In KG</label>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" name="fly_ash4" class="input02">
            <label for="" class="placeholder2">Fly Ash Qty In KG</label>
        </div>
        <div class="abcd" id="fourth_plus" onclick="fourth_click()">
            <i class="fa-solid fa-plus"></i>
            </div>
        </div>
        </div>

        </div>
        <!-- <div class="outer03" id="fourth_kg"> -->

        




        <div class="outer3" id="fifth_particular">
        <div class="outer02" >
            <!-- <div class="trial1">
                <input type="text" placeholder="" class="input02">
                <label for="" class="placeholder2">5th Particular</label>
            </div> -->
            <div class="outer02">
            <div class="trial1">
            <select name="grade5" id="" class="input02">
        <option value=""disabled selected>Grade</option>
        <option value="10">M10</option>
        <option value="15">M15</option>
        <option value="20">M20</option>
        <option value="25">M25</option>
        <option value="30">M30</option>
        <option value="35">M35</option>
        <option value="40">M40</option>
        <option value="45">M45</option>
        <option value="50">M50</option>
        <option value="55">M55</option>
        <option value="60">M60</option>
        <option value="65">M65</option>
        <option value="70">M70</option>
        <option value="75">M75</option>
        <option value="80">M80</option>
        <option value="85">M85</option>
        <option value="90">M90</option>
        <option value="95">M95</option>
        <option value="100">M100</option>
                
            </select></div>
            <div class="trial1">
                <input type="text" name="qty5" class="input02" placeholder="">
                <label for="" class="placeholder2">Quantity</label>
            
            </div></div>
           <!-- <div class="outer03" id="fifth_kg"> -->
        <div class="outer02" >
            <div class="trial1">
            <input type="text" placeholder="" name="cement_5" class="input02">
            <label for="" class="placeholder2">Cement Qty In KG</label>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" name="fly_ash_5" class="input02">
            <label for="" class="placeholder2">Fly Ash Qty In KG</label>
        </div>
        <!-- <div class="abcd" id="fifth_plus">
            <i class="fa-solid fa-plus"></i>
            </div> -->
        </div>
        </div> 

        </div>
        
        

        
        <button class="epc-button" type="submit">SUBMIT</button>
        <br>
</div>
    </form>
    <br><br>
   

</body>
</html>