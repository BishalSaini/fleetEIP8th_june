<?php
include "partials/_dbconnect.php";
session_start();
$email = $_SESSION['email'];
$companyname001 = $_SESSION['companyname'];
$enterprise=$_SESSION['enterprise'];
$dashboard_url = '';
if ($enterprise === 'rental') {
    $dashboard_url = 'rental_dashboard.php';
} elseif ($enterprise === 'logistics') {
    $dashboard_url = 'logisticsdashboard.php';
} 
elseif ($enterprise === 'epc') {
    $dashboard_url = 'epc_dashboard.php';
} 
elseif ($enterprise === 'admin') {
    $dashboard_url = 'news/admin/dashboard.php';
} 

else {
    $dashboard_url = '';
}
$showAlert = false;
$showError = false;

if(isset($_SESSION['error'])){
    $showError=true;
    unset($_SESSION['error']);
}

else if(isset($_SESSION['success'])){
    $showAlert=true;
    unset($_SESSION['success']);

}


$sql="SELECT * FROM `epcproject` where companyname='$companyname001'";
$result=mysqli_query($conn,$sql);

$sql_max_ref_no = "SELECT MAX(ref_no) AS max_ref_no FROM `workorder` WHERE companyname = '$companyname001'";
$result_max_ref_no = mysqli_query($conn, $sql_max_ref_no);
$row_max_ref_no = mysqli_fetch_assoc($result_max_ref_no);
$next_ref_no = ($row_max_ref_no['max_ref_no'] === null) ? 1 : $row_max_ref_no['max_ref_no'] + 1;




if($_SERVER['REQUEST_METHOD']==='POST'){
    
    include "partials/_dbconnect.php";


    if(($_POST['project_code']==='New Project') && !empty($_POST['newprojectcode']) ){
        $actualcode=$_POST['newprojectcode'];
    }
    else if(($_POST['project_code']!='New Project') && empty($_POST['newprojectcode'])){
        $actualcode=$_POST['project_code'];

    }
    $project_type=$_POST['project_type'];
    $projectname=$_POST['projectname'];
    $state=$_POST['state'];
    $district=$_POST['district'];
    $issued_to=$_POST['issued_to'];
    $start_date=$_POST['start_date'];
    $end_date=$_POST['end_date'];
    $address=$_POST['address'];
    $contact_person=$_POST['contact_person'];
    $cell=$_POST['cell'];
    $shiftinfo=$_POST['shiftinfo'];
    $hours_duration=$_POST['hours_duration']?? '';
    $engine_hour=$_POST['engine_hour'] ?? '';
    $equipment_detail=$_POST['equipment_detail'];
    $qty=$_POST['qty'];
    $rate=$_POST['rate'];
    $days_duration=$_POST['days_duration'];
    $condition=$_POST['condition'];
    $working_shift_start=$_POST['working_shift_start'];
    $working_shift_end=$_POST['working_shift_end'];
    $working_shift_end_unit=$_POST['working_shift_end_unit'];
    $lunch_time=$_POST['lunch_time'];
    $ot_payment=$_POST['ot_payment'];
    $operating_crew_select=$_POST['operating_crew_select'];
    $operator_room_scope_select=$_POST['operator_room_scope_select'];
    $op_salary=$_POST['op_salary'];
    $helper_salary=$_POST['helper_salary'];
    $fuel_consumption=$_POST['fuel_consumption'];
    $equip_maintanance=$_POST['equip_maintanance'];
    $fuel_unit=$_POST['fuel_unit'];
    $crew_food_scope_select=$_POST['crew_food_scope_select'];
    $crew_travelling_select=$_POST['crew_travelling_select'];
    $monsoonselect=$_POST['monsoonselect'];
    $notice_period=$_POST['notice_period'];
    $dehire=$_POST['dehire'];
    $payment_clause=$_POST['payment_clause'];
    $she_norms=$_POST['she_norms'];
    $safety_select=$_POST['safety_select'];
    $fuelconsumptiondecided=$_POST['fuelconsumptiondecided'];
    $operator_responsibility=$_POST['operator_responsibility'];
    $yom=$_POST['yom'];
    $cap=$_POST['cap'];
    $unit=$_POST['unit'] ?? '';


    $sql = "INSERT INTO workorder (
        project_type,
        yom,
        capacity,
        unit,
        ref_no,
        projectcode,
        companyname,
        projectname,
        state,
        district,
        issued_to,
        start_date,
        end_date,
        address,
        contact_person,
        cell,
        shiftinfo,
        hours_duration,
        engine_hour,
        equipment_detail,
        qty,
        rate,
        days_duration,
        sundaycondition,  
        working_shift_start,
        working_shift_end,
        working_shift_end_unit,
        lunch_time,
        ot_payment,
        operating_crew_select,
        operator_room_scope_select,
        op_salary,
        helper_salary,
        fuel_consumption,
        equip_maintanance,
        fuel_unit,
        crew_food_scope_select,
        crew_travelling_select,
        monsoonselect,
        notice_period,
        dehire,
        payment_clause,
        she_norms,
        entrydate,
        fuelconsumptiondecided,
        safety_select,
        operator_responsibility
    ) VALUES (
        '$project_type',
        '$yom',
        '$cap',
        '$unit',
        '$next_ref_no',
        '$actualcode',
        '$companyname001',
        '$projectname',
        '$state',
        '$district',
        '$issued_to',
        '$start_date',
        '$end_date',
        '$address',
        '$contact_person',
        '$cell',
        '$shiftinfo',
        '$hours_duration',
        '$engine_hour',
        '$equipment_detail',
        '$qty',
        '$rate',
        '$days_duration',
        '$condition',  
        '$working_shift_start',
        '$working_shift_end',
        '$working_shift_end_unit',
        '$lunch_time',
        '$ot_payment',
        '$operating_crew_select',
        '$operator_room_scope_select',
        '$op_salary',
        '$helper_salary',
        '$fuel_consumption',
        '$equip_maintanance',
        '$fuel_unit',
        '$crew_food_scope_select',
        '$crew_travelling_select',
        '$monsoonselect',
        '$notice_period',
        '$dehire',
        '$payment_clause',
        '$she_norms',
        NOW(),
        '$fuelconsumptiondecided',
        '$safety_select',
        '$operator_responsibility'
    )";

    $result=mysqli_query($conn,$sql);
    if($result){
        $_SESSION['success'] = 'true';
    }
    else{
        $_SESSION['error'] = 'true';
    }
    header("Location: workorder.php");
    exit();




    











}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workorder</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="autofillprojectdetails.js"defer></script>
    <script src="main.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
</head>
<body>
<div class="navbar1">
    <div class="logo_fleet">
    <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='<?php echo $dashboard_url  ?>'">
</div>

        <div class="iconcontainer">
        <ul>
      <li><a href="<?php echo $dashboard_url ?>">Dashboard</a></li>
            <!-- <li><a href="news/">News</a></li> -->
    
        <li><a href="logout.php">Log Out</a></li></ul>
        </div>
    </div> 
    <?php
if($showAlert){
    echo '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert notice">
        <span class="alertClose">X</span>
        <span class="alertText">Success <br class="clear"/></span>
    </div>
    </label>';
}
if($showError){
    echo '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert error">
        <span class="alertClose">X</span>
        <span class="alertText">Something Went Wrong<br class="clear"/></span>
    </div>
    </label>';
}
?>
<form action="generateworkorder.php" method="POST" autocomplete="off"  class="outerform">
    <div class="wocontainer">
        <p class="headingpara">Generate Workorder</p>
        <input type="hidden" id="companynameepc" value="<?php echo $companyname001; ?>">
         <div class="outer02">
                <select name="project_code" id="selectprojectcode" class="input02" onchange="newprjectentry()">
                    <option value=""disabled selected>Select Project Code</option>
                    <option value="New Project">New Project</option>
                    <?php 
                    include "partials/_dbconnect.php";
                    $myproject="SELECT * FROM `epcproject` where companyname='$companyname001'";
                    $resultproject=mysqli_query($conn,$myproject);
                    if(mysqli_num_rows($resultproject)>0){
                        while($roww=mysqli_fetch_assoc($resultproject)){
                            ?>
                            <option value="<?php echo $roww['projectcode']; ?>"><?php echo $roww['projectcode'].'-'. $roww['projectname']; ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
            <div class="trial1" id="newproject">
                <input type="text" placeholder="" name="newprojectcode" class="input02">
                <label for="" class="placeholder2">Project Code</label>
            </div>
            </div>
            <div class="outer02">
            <div class="trial1">
        <select class="input02" name="project_type" id="epcprojecttype">
            <option value="" disabled selected>Choose Project Type</option>
            <option value="Urban Infra">Project Type :Urban Infra</option>
            <option value="PipeLine">Project Type :PipeLine</option>
            <option value="Marine">Project Type :Marine</option>
            <option value="Road">Project Type :Road</option>
            <option value="Bridge And Metro">Project Type :Bridge And Metro</option>
            <option value="Plant">Project Type :Plant</option>
            <option value="Refinery">Project Type :Refinery</option>
            <option value="Others">Project Type :Others</option>
        </select>
        </div>

        <div class="trial1">
            <input type="text" placeholder='' id="epcprojectname" name="projectname" class="input02">
            <label for="" class="placeholder2">Project Name</label>
        </div></div>
        <div class="outer02">
        <div class="trial1">
            <select class="input02" name="state" id="state">
                <option value="" disabled selected>Project State</option>
                <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                <option value="Andhra Pradesh">Andhra Pradesh</option>
                <option value="Assam">Assam</option>
                <option value="Bihar">Bihar</option>
                <option value="Chandigarh">Chandigarh</option>
                <option value="Chhattisgarh">Chhattisgarh</option>
                <option value="Dadar and Nagar Haveli">Dadar and Nagar Haveli</option>
                <option value="Daman and Diu">Daman and Diu</option>
                <option value="Delhi">Delhi</option>
                <option value="Lakshadweep">Lakshadweep</option>
                <option value="Puducherry">Puducherry</option>
                <option value="Goa">Goa</option>
                <option value="Gujarat">Gujarat</option>
                <option value="Haryana">Haryana</option>
                <option value="Himachal Pradesh">Himachal Pradesh</option>
                <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                <option value="Jharkhand">Jharkhand</option>
                <option value="Karnataka">Karnataka</option>
                <option value="Kerala">Kerala</option>
                <option value="Madhya Pradesh">Madhya Pradesh</option>
                <option value="Maharashtra">Maharashtra</option>
                <option value="Manipur">Manipur</option>
                <option value="Meghalaya">Meghalaya</option>
                <option value="Mizoram">Mizoram</option>
                <option value="Nagaland">Nagaland</option>
                <option value="Odisha">Odisha</option>
                <option value="Punjab">Punjab</option>
                <option value="Rajasthan">Rajasthan</option>
                <option value="Sikkim">Sikkim</option>
                <option value="Tamil Nadu">Tamil Nadu</option>
                <option value="Telangana">Telangana</option>
                <option value="Tripura">Tripura</option>
                <option value="Uttar Pradesh">Uttar Pradesh</option>
                <option value="Uttarakhand">Uttarakhand</option>
                <option value="West Bengal">West Bengal</option>
            </select>
            </div>
            <div class="trial1">
            <input class="input02" id="project_district" name="district" type="text" placeholder="">
            <label class="placeholder2">Project District</label>
            </div>

        </div>
        <div class="trial1">
            <input type="text" placeholder="" name="issued_to" id="inputField" class="input02">
            <label for="" class="placeholder2">WO Issued To</label>
        </div>
        <div class="outer02">
            <div class="trial1">
                <input type="date" placeholder="" name="start_date" class="input02">
                <label for="" class="placeholder2">Wo Start Date</label>
            </div>
            <div class="trial1">
                <input type="date" placeholder="" name="end_date" class="input02">
                <label for="" class="placeholder2">Wo End Date</label>
            </div>
        </div>
        <div class="trial1">
            <textarea name="address" placeholder="" id="" class="input02"></textarea>
            <label for="" class="placeholder2">Address</label>
        </div>
<div class="outer02">
<div class="trial1">
            <input type="text" placeholder="" name="contact_person" class="input02">
            <label for="" class="placeholder2">Contact Person</label>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" name="cell" class="input02">
            <label for="" class="placeholder2">Cell-Phone</label>
        </div>

</div>
        <div class="outer02">
            <select name="shiftinfo" id="select_shift" class="input02" onchange="shift_hour()" required>
                <option value=""disabled selected>Select Shift</option>
                <option value="Single Shift">Single Shift</option>
                <option value="Double Shift">Double Shift</option>
                <option value="Flexi Shift">Flexi Shift</option>
            </select>


        <div class="trial1" id="single_Shift_hour">
            <!-- <input type="text" class="input02" name="hours_duration" placeholder="" >
            <label class="placeholder2" for="">Shift Duration In Hours</label> -->
            <select name="hours_duration" id="" class="input02">
                <option value="">Shift Duration</option>
                <option value="8">8 Hours</option>
                <option value="10">10 Hours</option>
                <option value="12">12 Hours</option>
                <option value="14">14 Hours</option>
                <option value="16">16 Hours</option>
            </select>
        </div>
        <div class="trial1" id="othershift_enginehour">
        <select name="engine_hour" id="" class="input02">
            <option value=""disabled selected>Engine Hours</option>
            <option value="200">200 Hours</option>
            <option value="208">208 Hours</option>
            <option value="260">260 Hours</option>
            <option value="270">270 Hours</option>
            <option value="280">280 Hours</option>
            <option value="300">300 Hours</option>
            <option value="312">312 Hours</option>
            <option value="360">360 Hours</option>
            <option value="400">400 Hours</option>
            <option value="416">416 Hours</option>
            <option value="460">460 Hours</option>
            <option value="572">572 Hours</option>
            <option value="672">672 Hours</option>
            <option value="720">720 Hours</option>
        </select>
    </div>
                </div>
                <div class="trial1">
        <textarea name="equipment_detail" placeholder="" id="" class="input02"></textarea>
        <label for="" class="placeholder2">Equipment Detail</label>
        </div>
        <div class="outer02 ">
            <div class="trial1">
                <input type="year" placeholder="" name="yom" class="input02">
                <label for="" class="placeholder2">Yom</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="cap" class="input02">
                <label for="" class="placeholder2">Capacity</label>
            </div>
            <div class="trial1" id="addfleetunitdd">
            <select name="unit" id="" class="input02" required>
            <option value="" disabled selected> Unit</option>
                <option value="Ton">Ton</option>
                <option value="Kgs">Kgs</option>
                <option value="KnM">KnM</option>
                <option value="Meter">Meter</option>
                <option value="M³">M³</option>
            </select>
        </div>


        </div>

        <div class="outer02">
            <div class="trial1">
                <input type="number" placeholder="" name="qty" class="input02">
                <label for="" class="placeholder2">Qty</label>
            </div>
            <div class="trial1">
                <input type="number" step="0.01" placeholder="" name="rate" class="input02">
                <label for="" class="placeholder2">Rate</label>
            </div>
        </div>

        <div class="outer02">
        <div class="trial1">
            <!-- <input type="text" class="input02" name="days_duration" placeholder="">
            <label class="placeholder2" for="">Duration Of Days In Month</label> -->
            <select name="days_duration" id="" class="input02" required>
                <option value="" disabled selected>Working Days</option>
                <option value="7">7 Days/Month</option>
                <option value="10">10 Days/Month</option>
                <option value="15">15 Days/Month</option>

                <option value="26" >26 Days/Month</option>
                <option value="28">28 Days/Month</option>
                <option value="30">30 Days/Month</option>
            </select>
        </div>
        <div class="trial1">
            <select name="condition" id="" class="input02" required>
                <option value=""disabled selected>Condition</option>
                <option value="Including Sundays">Including Sundays</option>
                <option value="Excluding First Two Sundays">Excluding First Two Sundays</option>
                <option value="Excluding Any Two Sundays">Excluding Any Two Sundays</option>
                <option value="Excluding Sundays">Excluding Sundays</option>
            </select>
        </div>
                </div>
                <div class="terms_container012">
    <p class="heading_terms">Terms & Conditions :</p>
    <p class="terms_condition">
    <strong>Working Shift :</strong>Start time to be
    <select name="working_shift_start" id="">
    <option <?php if(isset($lastrow['working_start']) && $lastrow['working_start'] ==='6 AM'){ echo 'selected';} ?> value="6 AM">6 AM</option>
        <option <?php if(isset($lastrow['working_start']) && $lastrow['working_start'] ==='7 AM'){ echo 'selected';} ?> value="7 AM">7 AM</option>

        <option <?php if(isset($lastrow['working_start']) && $lastrow['working_start'] ==='8 AM'){ echo 'selected';} ?> value="8 AM" >8 AM</option>
        <option <?php if(isset($lastrow['working_start']) && $lastrow['working_start'] ==='9 AM'){ echo 'selected';} ?> value="9 AM">9 AM</option>
        <option <?php if(isset($lastrow['working_start']) && $lastrow['working_start'] ==='10 AM'){ echo 'selected';} ?> value="10 AM">10 AM</option>
    </select>
    end time to be
    <select name="working_shift_end" id="">
        <option <?php if(isset($lastrow['working_end']) &&  $lastrow['working_end']==='6'){ echo 'selected';} ?> value="6">6</option>
        <option <?php if(isset($lastrow['working_end']) &&  $lastrow['working_end']==='7'){ echo 'selected';} ?> value="7">7</option>
        <option <?php if(isset($lastrow['working_end']) &&  $lastrow['working_end']==='8'){ echo 'selected';} ?> value="8" default selected>8</option>
        <option <?php if(isset($lastrow['working_end']) &&  $lastrow['working_end']==='9'){ echo 'selected';} ?> value="9">9</option>
</select>
<select name="working_shift_end_unit" id="">
    <option <?php if(isset($lastrow['working_end_unit']) && $lastrow['working_end_unit']==='AM'){ echo 'selected';} ?> value="AM">AM</option>
    <option <?php if(isset($lastrow['working_end_unit']) && $lastrow['working_end_unit']==='PM'){ echo 'selected';} ?> value="PM" default selected>PM</option>
    
</select>
<select name="lunch_time" id="lunchbreak">
    <option <?php if(isset($lastrow['food_break']) && $lastrow['food_break']==='including food break in each shift'){ echo 'selected';} ?> value="including food break in each shift">including food break in each shift</option>
    <option <?php if(isset($lastrow['food_break']) && $lastrow['food_break']==='excluding food break in each shift'){ echo 'selected';} ?> value="excluding food break in each shift">excluding food break in each shift</option>
</select>


</p>
<p class="terms_condition">
    <strong>Over time payment :</strong> OT charges at <select name="ot_payment" id=""><option value="100%" default selected>100%</option>
    <option <?php if(isset($lastrow['ot_pay']) && $lastrow['ot_pay']==='90%'){ echo 'selected';}?> value="90%">90%</option>
    <option <?php if(isset($lastrow['ot_pay']) && $lastrow['ot_pay']==='80%'){ echo 'selected';}?> value="80%">80%</option>
    <option <?php if(isset($lastrow['ot_pay']) && $lastrow['ot_pay']==='70%'){ echo 'selected';}?> value="70%">70%</option>
    <option <?php if(isset($lastrow['ot_pay']) && $lastrow['ot_pay']==='60%'){ echo 'selected';}?> value="60%">60%</option>
    <option <?php if(isset($lastrow['ot_pay']) && $lastrow['ot_pay']==='50%'){ echo 'selected';}?> value="50%">50%</option></select> If Applicable
<!-- <textarea name="ot_payment" id="" cols="30" rows="2" class="terms_textarea"> Applicable. OT charges at 100% pro-rata basis payable if equipment has worked beyond stipulated work shift, engine hours and on Sundays,National holidays</textarea> -->
</p>

<p class="terms_condition" >
    <strong>Operating Crew :</strong> 
    <select name="operating_crew_select" id="operating_crew_select">
        <option <?php if(isset($lastrow['crew']) && $lastrow['crew']==='Single Operator'){ echo 'selected';} ?> value="Single Operator">Single Operator</option>
        <option <?php if(isset($lastrow['crew']) && $lastrow['crew']==='Double Operator'){ echo 'selected';} ?> value="Double Operator">Double Operator</option>
        <option <?php if(isset($lastrow['crew']) && $lastrow['crew']==='Single Operator + Helper'){ echo 'selected';} ?> value="Single Operator + Helper">Single Operator + Helper</option>
        <option <?php if(isset($lastrow['crew']) && $lastrow['crew']==='Double Operator + Helper'){ echo 'selected';} ?> value="Double Operator + Helper">Double Operator + Helper</option>
    </select>
    &nbsp
    <strong>Operator Room Scope :</strong> 
    <select name="operator_room_scope_select" id="operator_room_scope_select">
        <option <?php if(isset($lastrow['room']) && $lastrow['room']==='Not Applicable'){ echo 'selected';} ?> value="Not Applicable">Not Applicable</option>
        <option <?php if(isset($lastrow['room']) && $lastrow['room']==='In Client Scope'){ echo 'selected';} ?> value="In Client Scope" default selected>In Client Scope</option>
        <option <?php if(isset($lastrow['room']) && $lastrow['room']==='In Rental Company Scope'){ echo 'selected';} ?> value="In Rental Company Scope">In Rental Co Scope</option>
    </select>

</p>
<p class="terms_condition">
<strong>Operator Salary Scope :</strong>  
    <select name="op_salary" id="crew_food_scope_select">
        <option <?php if(isset($lastrow['food']) && $lastrow['food']==='Not Applicable'){ echo 'selected';} ?> value="Not Applicable">Not Applicable</option>
        <option <?php if(isset($lastrow['food']) && $lastrow['food']==='In Client Scope'){ echo 'selected';} ?> value="In Client Scope">In Client Scope</option>
        <option <?php if(isset($lastrow['food']) && $lastrow['food']==='In Rental Company Scope'){ echo 'selected';} ?> value="In Rental Company Scope">In Rental Company Scope</option>
    </select>
    &nbsp
    <strong>Helper Salary Scope :</strong>  
    <select name="helper_salary" id="crew_travelling_select">
        <option <?php if(isset($lastrow['travel']) && $lastrow['travel']==='Not Applicable'){ echo 'selected';} ?> value="Not Applicable">Not Applicable</option>
        <option <?php if(isset($lastrow['travel']) && $lastrow['travel']==='In Client Scope'){ echo 'selected';} ?>  value="In Client Scope">In Client Scope</option>
        <option <?php if(isset($lastrow['travel']) && $lastrow['travel']==='In Rental Company Scope'){ echo 'selected';} ?> value="In Rental Company Scope">In Rental Co Scope</option>
    </select>
    <p class="terms_condition">
    <strong>Equipment Maintainance Scope :</strong>  
    <select name="equip_maintanance" id="crew_food_scope_select">
        <option <?php if(isset($lastrow['food']) && $lastrow['food']==='Not Applicable'){ echo 'selected';} ?> value="Not Applicable">Not Applicable</option>
        <option <?php if(isset($lastrow['food']) && $lastrow['food']==='In Client Scope'){ echo 'selected';} ?> value="In Client Scope">In Client Scope</option>
        <option <?php if(isset($lastrow['food']) && $lastrow['food']==='In Rental Company Scope'){ echo 'selected';} ?> value="In Rental Company Scope">In Rental Company Scope</option>
    </select>


</p>
<p class="terms_condition">
    <strong>Fuel Consumption :</strong>
Only <select name="fuel_consumption" id="">
    <option value="diesel">diesel</option>
    <option value="petrol">petrol</option>
    <option value="petrol & adblue">petrol & adblue</option>
    <option value="diesel & adblue">diesel & adblue</option>
</select> will be provided by us free of cost for the operation, based on actual consumption. However, the fuel consumption norms will be <select name="fuelconsumptiondecided" id="">
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
    <option value="6">6</option>
    <option value="7">7</option>
    <option value="8">8</option>
    <option value="9">9</option>
    <option value="10">10</option>
</select>
<select name="fuel_unit" id="">
    <option value="L/Hour">L/Hour</option>
    <option value="L/100km">L/100km</option>
</select>
or actual consumption fixed by the P&M in charge, whichever is less. Fuel consumption above the norms fixed and lubricants issued will be charged to you at procurement price + 20%, including handling charges.</p>
<p class="terms_condition">
    <strong>5.Crew Food Scope :</strong>  
    <select name="crew_food_scope_select" id="crew_food_scope_select">
        <option <?php if(isset($lastrow['food']) && $lastrow['food']==='Not Applicable'){ echo 'selected';} ?> value="Not Applicable">Not Applicable</option>
        <option <?php if(isset($lastrow['food']) && $lastrow['food']==='In Client Scope'){ echo 'selected';} ?> value="In Client Scope">In Client Scope</option>
        <option <?php if(isset($lastrow['food']) && $lastrow['food']==='In Rental Company Scope'){ echo 'selected';} ?> value="In Rental Company Scope">In Rental Company Scope</option>
    </select>
    &nbsp
    <strong>6.Crew Travelling :</strong>  
    <select name="crew_travelling_select" id="crew_travelling_select">
        <option <?php if(isset($lastrow['travel']) && $lastrow['travel']==='Not Applicable'){ echo 'selected';} ?> value="Not Applicable">Not Applicable</option>
        <option <?php if(isset($lastrow['travel']) && $lastrow['travel']==='In Client Scope'){ echo 'selected';} ?>  value="In Client Scope">In Client Scope</option>
        <option <?php if(isset($lastrow['travel']) && $lastrow['travel']==='In Rental Company Scope'){ echo 'selected';} ?> value="In Rental Company Scope">In Rental Co Scope</option>
    </select>

</p>
<p class="terms_condition">
    <strong>Monsoon Concession :</strong>
It shall be noted that the rate quoted and accepted therein shall remain firm for the entire duration of the contract until satisfactory completion of all work under this agreement. Rental shall be paid at
 <select name="monsoonselect" id="">
    <option value="30">30%</option>
    <option value="40">40%</option>
    <option value="50">50%</option>
    <option value="60">60%</option>
    <option value="70">70%</option>
    <option value="80">80%</option>
    <option value="90">90%</option>
</select> of the monthly rental during the rainy season.
</p>
<p class="terms_condition">
    <strong>Demobilization Notice :</strong>
    The hire period is tentative, and a minimum of <select id="" name="notice_period">
    <option value="3">3 days</option>
    <option value="5">5 days</option>
    <option value="7">7 days</option>
    <option value="10">10 days</option>
    <option value="15">15 days</option>
    <option value="30">30 days</option>
    <option value="45">45 days</option>
</select> notice must be provided before demobilization of the machine.
</p>

<p class="terms_condition"><strong>Dehire Clause :</strong>
In case of unsatisfactory performance and non-working of your equipment due to any reasons, we reserve the right to terminate the contract
 <select name="dehire" id="">
    <option value="with no prior notice">with no prior notice</option>
    <option value="with 3 days prior notice">with 3 days prior notice</option>
    <option value="with 5 days prior notice">with 5 days prior notice</option>
    <option value="with 7 days prior notice">with 7 days prior notice</option>
    <option value="with 15 days prior notice">with 15 days prior notice</option>
</select>
</p>
<p class="terms_condition">
    <strong>Payment Clause :</strong>
All payments will be made by A/C payee cheques within <select name="payment_clause" id="">
<option value="7">7 days</option>
    <option value="10">10 days</option>
    <option value="15">15 days</option>
    <option value="30">30 days</option>
    <option value="45">45 days</option>
</select> after submission and certification of the original bill.
</p>
<p class="terms_condition">
    <strong>SHE Norms :</strong>
Safety, health, and environment (SHE)
 norms as applicable by our client shall be strictly followed by you
  at <select name="she_norms" id="">
    <option value="no cost">no cost</option>
    <option value="additional cost">additional cost</option>
  </select> to <?php echo $companyname001 ?>. Any violation of the above SHE norms on the site shall attract a penalty, to be decided solely by <?php echo $companyname001 ?>.
</p>
<p class="terms_condition" >
    <strong>Documentation :</strong>
All details (like running hours, HSD, breakdown, etc.) 
shall be maintained by the representatives of <span id="company-name"></span> and <?php echo $companyname001 ?>, which has to be produced along with the monthly bill for verification
</p>
<p class="terms_condition">
    <strong>Safety :</strong>
You will be responsible for the safety of your equipment, workmen's compensation, and all other statutory obligations pertaining to your employees. All costs shall be borne by you. Necessary insurance for your equipment shall be arranged by you
at <select name="safety_select" id="">
    <option value="no extra cost">no extra cost</option>
    <option value="an extra cost">an extra cost</option>
</select>
to <?php echo $companyname001 ?> 
</p>
<p class="terms_condition">
    <strong>Operator Responsibility and Penalty Clause :</strong>
In the event of the absence of the operator with a valid license engaged by you, 
<select name="operator_responsibility" id="">
    <option value="no other person (helper)">no other person (helper)</option>
    <option value="other operator">other operator</option>
</select> shall be allowed to operate the equipment. If rule breach found so, a penalty shall be imposed on you in an amount mutually agreed upon.
</p>
<p class="terms_condition">
    <strong>Machine Deployment :</strong>
    Your equipment can be deployed anywhere within the site premises.
</p>
<p class="terms_condition">
    <strong>Liability for Damage and Repairs</strong>
    In the event of damage caused by the movement of your equipment or any operational irregularity by your operator, and such incidents have caused damage to any property of <?php echo $companyname001 ?> or any other third party, the cost of repairs for the damages and/or compensation payable, penalties, etc., shall be borne by you.
</p>
<p class="terms_condition">
    <strong>Submission of Logbook and Invoice :</strong>
    Only <?php echo $companyname001 ?>`s logbook should be submitted along with the invoice.
</p>
<p class="terms_condition">
    <strong>Force Majeure Clause :</strong>
    If due to any reason beyond our control, such as plant stoppages, acts of God, natural disasters, wars, riots, floods, earthquakes, pandemic causes, strikes at the state or national level, etc., or any other events beyond our control, we may not be able to implement this contract. You will have no claim on us for the implementation of this contract during such periods of force majeure."
</p>
<p class="terms_condition">
    <strong>GST Documentation Requirements :</strong>
    GST as applicable on submission of documentary proof, i.e., GST Return and Challan copy.
</p>



        

    </div>
    <button class="epc-button">Submit</button>
</form>    
</body>
<script>
     const inputField = document.getElementById('inputField');
    const companyNameSpan = document.getElementById('company-name');

    inputField.addEventListener('input', function() {
        companyNameSpan.textContent = inputField.value || ""; // Default value
    });
</script>