<?php
include "partials/_dbconnect.php";
$editid=$_GET['quote_id'];
$sendername=$_GET['id'];
$sql_edit_quotation="SELECT * FROM `quotation_generated` where `sno`='$editid'";
$result_edit=mysqli_query($conn,$sql_edit_quotation);
$row=mysqli_fetch_assoc($result_edit);

$sql_second_equipmment = "SELECT * FROM `second_vehicle_quotation` where uniqueid='" . $row['uniqueid'] . "'";
$result_secondequip = mysqli_query($conn, $sql_second_equipmment) or die(mysqli_error($conn));
if(mysqli_num_rows($result_secondequip)>0){
    $row2=mysqli_fetch_assoc($result_secondequip);
}
else{
    $row2 = $row2 ?? '';
}

$sql3 = "SELECT * FROM `thirdvehicle_quotation` where uniqueid='" . $row['uniqueid'] . "'";
$result3 = mysqli_query($conn, $sql3) or die(mysqli_error($conn));
if(mysqli_num_rows($result3)>0){
    $row3=mysqli_fetch_assoc($result3);
}
else{
    $row3 = $row3 ?? '';
}

$sql4 = "SELECT * FROM `fourthvehicle_quotation` where uniqueid='" . $row['uniqueid'] . "'";
$result4 = mysqli_query($conn, $sql4);
if(mysqli_num_rows($result4)>0){
    $row4=mysqli_fetch_assoc($result4);
}
else{
    $row4='';
}

$sql5 = "SELECT * FROM `fifthvehicle_quotation` where uniqueid='" . $row['uniqueid'] . "'";
$result5 = mysqli_query($conn, $sql5);
if(mysqli_num_rows($result5)>0){
    $row5=mysqli_fetch_assoc($result5);
}
else{
    $row5='';
}

session_start();
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
else {
    $dashboard_url = '';
}
$sql_client = "SELECT DISTINCT clientname FROM rentalclients WHERE `companyname` = '$companyname001' order by clientname asc";
$result_client=mysqli_query($conn,$sql_client);


$asset_code_selection = "SELECT * FROM `fleet1` WHERE `companyname`='$companyname001'";
$result_asset_code = mysqli_query($conn, $asset_code_selection);

$asset_code_selection1 = "SELECT * FROM `fleet1` WHERE `companyname`='$companyname001' ORDER BY assetcode ASC";
$result_asset_code1 = mysqli_query($conn, $asset_code_selection1);

$asset_code_selection2 = "SELECT * FROM `fleet1` WHERE `companyname`='$companyname001' ORDER BY assetcode ASC";
$result_asset_code2 = mysqli_query($conn, $asset_code_selection2);

$asset_code_selection3 = "SELECT * FROM `fleet1` WHERE `companyname`='$companyname001' ORDER BY assetcode ASC";
$result_asset_code3 = mysqli_query($conn, $asset_code_selection3);

$asset_code_selection4 = "SELECT * FROM `fleet1` WHERE `companyname`='$companyname001' ORDER BY assetcode ASC";
$result_asset_code4 = mysqli_query($conn, $asset_code_selection4);

$asset_code_selection5 = "SELECT * FROM `fleet1` WHERE `companyname`='$companyname001' ORDER BY assetcode ASC";
$result_asset_code5 = mysqli_query($conn, $asset_code_selection5);

$sql_sender_name = "SELECT * FROM `team_members` WHERE company_name='$companyname001' AND department='marketing' OR company_name='$companyname001' AND department='Management'";
$result_sender_name = mysqli_query($conn, $sql_sender_name);



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "partials/_dbconnect.php";



    // contact detail 
    $edituniqueid=$_POST['edituniqueid'];
    $quotation_date=$_POST['quotation_date'];
    $clientname=$_POST['clientname'];
    $salutation_dd=$_POST['salutation_dd'];
    $contact_person=$_POST['contact_person'];
    $to_address=$_POST['to_address'];
    $contact_number=$_POST['contact_number'];
    $email_id=$_POST['email_id'];

    // terms 
    $working_shift_start=$_POST['working_shift_start'];
    $working_shift_end=$_POST['working_shift_end'];
    $working_shift_end_unit=$_POST['working_shift_end_unit'];
    $lunch_time=$_POST['lunch_time'];
    $brkdown=$_POST['breakdown_select'];
    $crew=$_POST['operating_crew_select'];
    $room=$_POST['operator_room_scope_select'];
    $food=$_POST['crew_food_scope_select'];
    $travel=$_POST['crew_travelling_select'];
    $fuel_scope=$_POST['fuel_scope'];
    $adblue_scope=$_POST['adblue_scope'];
    $period=$_POST['contract_period_select'];
    $road_tax=$_POST['road_tax'];
    $roadtax_condition=$_POST['roadtax_condition'];
    $dehire=$_POST['dehire'];
    $payment_terms_select=$_POST['payment_terms_select'];
    $adv_pay=$_POST['advance_payment_select'];
    $assembly=$_POST['equipment_assembly_select'];
    $tpi=$_POST['tpi_scope_select'];
    $safety_security=$_POST['safety_security_select'];
    $gst=$_POST['gst'];
    $ppe=$_POST['PPE'];
    $ot_payment=$_POST['ot_payment'];
    $tools_tackels=$_POST['tools_tackels'];
    $internal_shifting=$_POST['internal_shifting'];
    $mobilisation_notice=$_POST['mobilisation_notice'];
    $delay_pay=$_POST['delay_pay'];
    $force_clause=$_POST['force_clause'];
    $quote_valid=$_POST['quote_valid'];
    $custom=$_POST['custom'];

    // senders detail 
    $sender_name=$_POST['sender_name'];
    $senders_designation=$_POST['senders_designation'];
    $contactnumbersender=$_POST['contactnumbersender'];
    $contactemailsender=$_POST['contactemailsender'];


    // first equipment
    $availability=$_POST['availability'];
    $tentative_date=$_POST['tentative_date'];
    $shiftinfo=$_POST['shiftinfo'];
    $hours_duration=$_POST['hours_duration'];
    $engine_hour=$_POST['engine_hour'];
    $site_location=$_POST['site_location'];
    $location=$_POST['location'];
    $days_duration=$_POST['days_duration'];
    $condition=$_POST['condition'];
    $fuel_per_hour=$_POST['fuel_per_hour'];
    $adblue=$_POST['adblue'];
    $rental_charges=$_POST['rental_charges'];
    $mob_charges=$_POST['mob_charges'];
    $demob_charges=$_POST['demob_charges'];

    $asset_code=$_POST['asset_code'];
    $fleet_category=$_POST['fleet_category'];
    $type=$_POST['type'];
    $fleetmake=$_POST['fleetmake'];
    $fleetmodel=$_POST['fleetmodel'];
    $fleet_cap=$_POST['fleet_cap'];
    $fleet_capunit=$_POST['fleet_capunit'];
    $yom_fleet=$_POST['yom_fleet'];
    $boomLength=$_POST['boomLength'];
    $jibLength=$_POST['jibLength'];
    $luffingLength=$_POST['luffingLength'];




    $edit1_update = "UPDATE `quotation_generated` SET
    `road_tax` = '$road_tax',
    `adblue_scope` = '$adblue_scope',
    `fuel_scope` = '$fuel_scope',
    `working_start` = '$working_shift_start',
    `working_end` = '$working_shift_end',
    `working_end_unit` = '$working_shift_end_unit',
    `salutation` = '$salutation_dd',
    `quote_validity` = '$quote_valid',
    `ppe_kit` = '$ppe',
    `dehire_clause` = '$dehire',
    `category` = '$fleet_category',
    `engine_hours` = '$engine_hour',
    `shift_info` = '$shiftinfo',
    `tentative_date` = '$tentative_date',
    `contact_person_cell` = '$contact_number',
    `yom` = '$yom_fleet',
    `cap` = '$fleet_cap',
    `cap_unit` = '$fleet_capunit',
    `boom` = '$boomLength',
    `jib` = '$jibLength',
    `luffing` = '$luffingLength',
    `availability` = '$availability',
    `fuel/hour` = '$fuel_per_hour',
    `make` = '$fleetmake',
    `model` = '$fleetmodel',
    `sub_Type` = '$type',
    `quote_date` = '$quotation_date',
    `to_name` = '$clientname',
    `to_address` = '$to_address',
    `contact_person` = '$contact_person',
    `email_id_contact_person` = '$email_id',
    `site_loc` = '$site_location',
    `asset_code` = '$asset_code',
    `hours_duration` = '$hours_duration',
    `days_duration` = '$days_duration',
    `sunday_included` = '$condition',
    `rental_charges` = '$rental_charges',
    `mob_charges` = '$mob_charges',
    `demob_charges` = '$demob_charges',
    `crane_location` = '$location',
    `adblue` = '$adblue',
    `sender_name` = '$sender_name',
    `sender_number` = '$contactnumbersender',
    `sender_contact` = '$contactemailsender',
    `period_contract` = '$period',


    `adv_pay` = '$adv_pay',
    `crew` = '$crew',
    `room` = '$room',
    `food` = '$food',
    `travel` = '$travel',
    `brkdown` = '$brkdown',
    `ot_pay` = '$ot_payment',
    `pay_terms` = '$payment_terms_select',
    `delay_pay` = '$delay_pay',
    `equipment_assembly` = '$assembly',
    `tpi` = '$tpi',
    `safety` = '$safety_security',
    `tools` = '$tools_tackels',
    `gst` = '$gst',
    `custom_terms` = '$custom',
    `force_clause` = '$force_clause',
    `food_break` = '$lunch_time',
    `senders_designation` = '$senders_designation',
    `internal_shifting` = '$internal_shifting',
    `mobilisation_notice` = '$mobilisation_notice',
    `roadtax_condition` = '$roadtax_condition',
    `lumsumamount` = '$lumsumamount'
WHERE `uniqueid` = '$edituniqueid'";
$resultedit1_update=mysqli_query($conn,$edit1_update);


$asset_code1 = $_POST['asset_code1'];
$avail1 = $_POST['avail1'];
$fleet_category1 = $_POST['fleet_category1'];
$type1 = $_POST['type1'] ?? null;
$newfleetmake1 = $_POST['newfleetmake1'];
$newfleetmodel1 = $_POST['newfleetmodel1'];
$fleetcap2 = $_POST['fleetcap2'];
$unit2 = $_POST['unit2'] ?? null;
$yom2 = $_POST['yom2'];
$boomLength2 = $_POST['boomLength2'];
$jibLength2 = $_POST['jibLength2'];
$luffingLength2 = $_POST['luffingLength2'];
$date_ = $_POST['date_'] ?? null;
$rental2 = $_POST['rental2'];
$mob02 = $_POST['mob02'];
$demob02 = $_POST['demob02'];
$equiplocation02 = $_POST['equiplocation02'];
$adblue2 = $_POST['adblue2'] ?? null;
$fuelperltr2 = $_POST['fuelperltr2'];

$edit_update2 = "
    UPDATE `second_vehicle_quotation`
    SET 
        `category2` = '$fleet_category1',
        `asset_code2` = '$asset_code1',
        `yom2` = '$yom2',
        `make2` = '$newfleetmake1',
        `model2` = '$newfleetmodel1',
        `sub_type2` = '$type1',
        `fuel/hour2` = '$fuelperltr2',
        `availability2` = '$avail1',
        `tentative_date2` = '$date_',
        `cap2` = '$fleetcap2',
        `cap_unit2` = '$unit2',
        `boom2` = '$boomLength2',
        `jib2` = '$jibLength2',
        `luffing2` = '$luffingLength2',
        `rental_charges2` = '$rental2',
        `mob_charges2` = '$mob02',
        `demob_charges2` = '$demob02',
        `crane_location2` = '$equiplocation02',
        `adblue2` = '$adblue2'
    WHERE `uniqueid` = '$edituniqueid'";

$resultedit2_update = mysqli_query($conn, $edit_update2);

// If no rows are updated (i.e., no existing record), we will insert a new one
if (mysqli_affected_rows($conn) == 0 && !empty($asset_code1)) {
    $insert_query2 = "
        INSERT INTO `second_vehicle_quotation` (
            `category2`, `asset_code2`, `yom2`, `make2`, `model2`, `sub_type2`, 
            `fuel/hour2`, `availability2`, `tentative_date2`, `cap2`, `cap_unit2`, 
            `boom2`, `jib2`, `luffing2`, `rental_charges2`, `mob_charges2`, 
            `demob_charges2`, `crane_location2`, `adblue2`, `uniqueid`
        ) VALUES (
            '$fleet_category1', '$asset_code1', '$yom2', '$newfleetmake1', 
            '$newfleetmodel1', '$type1', '$fuelperltr2', '$avail1', '$date_',
            '$fleetcap2', '$unit2', '$boomLength2', '$jibLength2', '$luffingLength2',
            '$rental2', '$mob02', '$demob02', '$equiplocation02', '$adblue2', '$edituniqueid'
        )";
    mysqli_query($conn, $insert_query2);
}


// Third Vehicle
$asset_code3 = $_POST['asset_code3'];
$fleet_category3 = $_POST['fleet_category3'] ?? '';
$type3 = $_POST['type3'] ?? '';
$newfleetmake3 = $_POST['newfleetmake3'] ?? '';
$newfleetmodel3 = $_POST['newfleetmodel3'];
$fleetcap3 = $_POST['fleetcap3'];
$unit3 = $_POST['unit3'] ?? '';
$newyom3 = $_POST['newyom3'];
$boomLength3 = $_POST['boomLength3'];
$jibLength3 = $_POST['jibLength3'];
$luffingLength3 = $_POST['luffingLength3'];
$rental3 = $_POST['rental3'];
$mob03 = $_POST['mob03'];
$demob03 = $_POST['demob03'];
$equiplocation03 = $_POST['equiplocation03'];
$fuelperltr3 = $_POST['fuelperltr3'];
$adblue3 = $_POST['adblue3'];
$avail3 = $_POST['avail3'];
$date3 = $_POST['date3'];

$edit_update3 = "
    UPDATE `thirdvehicle_quotation`
    SET 
        `category2` = '$fleet_category3',
        `asset_code2` = '$asset_code3',
        `yom2` = '$newyom3',
        `make2` = '$newfleetmake3',
        `model2` = '$newfleetmodel3',
        `sub_type2` = '$type3',
        `fuel/hour2` = '$fuelperltr3',
        `availability2` = '$avail3',
        `tentative_date2` = '$date3',
        `cap2` = '$fleetcap3',
        `cap_unit2` = '$unit3',
        `boom2` = '$boomLength3',
        `jib2` = '$jibLength3',
        `luffing2` = '$luffingLength3',
        `rental_charges2` = '$rental3',
        `mob_charges2` = '$mob03',
        `demob_charges2` = '$demob03',
        `crane_location2` = '$equiplocation03',
        `adblue2` = '$adblue3'
    WHERE `uniqueid` = '$edituniqueid'";

$resultedit3_update = mysqli_query($conn, $edit_update3);

// If no rows are updated, insert a new record
if (mysqli_affected_rows($conn) == 0 && !empty($asset_code3)) {
        $insert_query3 = "
        INSERT INTO `thirdvehicle_quotation` (
            `category2`, `asset_code2`, `yom2`, `make2`, `model2`, `sub_type2`, 
            `fuel/hour2`, `availability2`, `tentative_date2`, `cap2`, `cap_unit2`, 
            `boom2`, `jib2`, `luffing2`, `rental_charges2`, `mob_charges2`, 
            `demob_charges2`, `crane_location2`, `adblue2`,`uniqueid`
        ) VALUES (
            '$fleet_category3', '$asset_code3', '$newyom3', '$newfleetmake3', 
            '$newfleetmodel3', '$type3', '$fuelperltr3', '$avail3', '$date3',
            '$fleetcap3', '$unit3', '$boomLength3', '$jibLength3', '$luffingLength3',
            '$rental3', '$mob03', '$demob03', '$equiplocation03', '$adblue3','$edituniqueid'
        )";
    mysqli_query($conn, $insert_query3);
}

$asset_code4 = $_POST['asset_code4'];
$avail4 = $_POST['avail4'];
$date4 = $_POST['date4'];
$fleet_category4 = $_POST['fleet_category4'] ?? '';
$type4 = $_POST['type4'] ?? '';
$newfleetmake4 = $_POST['newfleetmake4'] ?? '';
$newfleetmodel4 = $_POST['newfleetmodel4'];
$fleetcap4 = $_POST['fleetcap4'];
$unit4 = $_POST['unit4'] ?? '';
$newyom4 = $_POST['newyom4'];
$boomLength4 = $_POST['boomLength4'];
$jibLength4 = $_POST['jibLength4'];
$luffingLength4 = $_POST['luffingLength4'];
$rental4 = $_POST['rental4'];
$mob04 = $_POST['mob04'];
$demob04 = $_POST['demob04'];
$equiplocation04 = $_POST['equiplocation04'];
$fuelperltr4 = $_POST['fuelperltr4'];
$adblue4 = $_POST['adblue4'];

$edit_update4 = "
    UPDATE `fourthvehicle_quotation`
    SET 
        `category2` = '$fleet_category4',
        `asset_code2` = '$asset_code4',
        `yom2` = '$newyom4',
        `make2` = '$newfleetmake4',
        `model2` = '$newfleetmodel4',
        `sub_type2` = '$type4',
        `fuel/hour2` = '$fuelperltr4',
        `availability2` = '$avail4',
        `tentative_date2` = '$date4',
        `cap2` = '$fleetcap4',
        `cap_unit2` = '$unit4',
        `boom2` = '$boomLength4',
        `jib2` = '$jibLength4',
        `luffing2` = '$luffingLength4',
        `rental_charges2` = '$rental4',
        `mob_charges2` = '$mob04',
        `demob_charges2` = '$demob04',
        `crane_location2` = '$equiplocation04',
        `adblue2` = '$adblue4'
    WHERE `uniqueid` = '$edituniqueid'";

$resultedit4_update = mysqli_query($conn, $edit_update4);

// If no rows are updated, insert a new record
if (mysqli_affected_rows($conn) == 0 && !empty($asset_code4)) {
        $insert_query4 = "
        INSERT INTO `fourthvehicle_quotation` (
            `category2`, `asset_code2`, `yom2`, `make2`, `model2`, `sub_type2`, 
            `fuel/hour2`, `availability2`, `tentative_date2`, `cap2`, `cap_unit2`, 
            `boom2`, `jib2`, `luffing2`, `rental_charges2`, `mob_charges2`, 
            `demob_charges2`, `crane_location2`, `adblue2`,`uniqueid`
        ) VALUES (
            '$fleet_category4', '$asset_code4', '$newyom4', '$newfleetmake4', 
            '$newfleetmodel4', '$type4', '$fuelperltr4', '$avail4', '$date4',
            '$fleetcap4', '$unit4', '$boomLength4', '$jibLength4', '$luffingLength4',
            '$rental4', '$mob04', '$demob04', '$equiplocation04', '$adblue4', '$edituniqueid'
        )";
    mysqli_query($conn, $insert_query4);
}


// Fifth Vehicle
$asset_code5 = $_POST['asset_code5'];
$avail5 = $_POST['avail5'];
$date5 = $_POST['date5'];
$fleet_category5 = $_POST['fleet_category5'] ?? '';
$type5 = $_POST['type5'] ?? '';
$newfleetmake5 = $_POST['newfleetmake5'] ?? '';
$newfleetmodel5 = $_POST['newfleetmodel5'];
$fleetcap5 = $_POST['fleetcap5'];
$unit5 = $_POST['unit5'];
$newyom5 = $_POST['newyom5'];
$boomLength5 = $_POST['boomLength5'];
$jibLength5 = $_POST['jibLength5'];
$luffingLength5 = $_POST['luffingLength5'];
$rental5 = $_POST['rental5'];
$mob05 = $_POST['mob05'];
$demob05 = $_POST['demob05'];
$equiplocation05 = $_POST['equiplocation05'];
$fuelperltr5 = $_POST['fuelperltr5'];
$adblue5 = $_POST['adblue5'];

$edit_update5 = "
    UPDATE `fifthvehicle_quotation`
    SET 
        `category2` = '$fleet_category5',
        `asset_code2` = '$asset_code5',
        `yom2` = '$newyom5',
        `make2` = '$newfleetmake5',
        `model2` = '$newfleetmodel5',
        `sub_type2` = '$type5',
        `fuel/hour2` = '$fuelperltr5',
        `availability2` = '$avail5',
        `tentative_date2` = '$date5',
        `cap2` = '$fleetcap5',
        `cap_unit2` = '$unit5',
        `boom2` = '$boomLength5',
        `jib2` = '$jibLength5',
        `luffing2` = '$luffingLength5',
        `rental_charges2` = '$rental5',
        `mob_charges2` = '$mob05',
        `demob_charges2` = '$demob05',
        `crane_location2` = '$equiplocation05',
        `adblue2` = '$adblue5'
    WHERE `uniqueid` = '$edituniqueid'";

$resultedit5_update = mysqli_query($conn, $edit_update5);

// If no rows are updated, insert a new record
if (mysqli_affected_rows($conn) == 0 && !empty($asset_code5)) {
        $insert_query5 = "
        INSERT INTO `fifthvehicle_quotation` (
            `category2`, `asset_code2`, `yom2`, `make2`, `model2`, `sub_type2`, 
            `fuel/hour2`, `availability2`, `tentative_date2`, `cap2`, `cap_unit2`, 
            `boom2`, `jib2`, `luffing2`, `rental_charges2`, `mob_charges2`, 
            `demob_charges2`, `crane_location2`, `adblue2`,`uniqueid`
        ) VALUES (
            '$fleet_category5', '$asset_code5', '$newyom5', '$newfleetmake5', 
            '$newfleetmodel5', '$type5', '$fuelperltr5', '$avail5', '$date5',
            '$fleetcap5', '$unit5', '$boomLength5', '$jibLength5', '$luffingLength5',
            '$rental5', '$mob05', '$demob05', '$equiplocation05', '$adblue5', '$edituniqueid'
        )";
    mysqli_query($conn, $insert_query5);
}

if ($resultedit1_update || $resultedit2_update || $resultedit3_update || $resultedit4_update || $resultedit5_update) {
    $_SESSION['success'] = "true";
} else {
    $_SESSION['error'] = "true";
}
header("Location: quotationinfo.php?id=$sendername");
exit();

        

        










    








}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Quotation</title>
    <link rel="stylesheet" href="style.css">
    <script src="main.js"defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="getclient_quotation.js"defer></script>
<script src="contactpersondetails.js"defer></script>
<script src="autofill_senders_name.js"defer></script>
<title>Generate Quotation</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
<style><?php include "style.css" ?></style>
<script><?php include "main.js" ?></script>
<script><?php include "editquotationautofill.js" ?></script>
<script scr="editquotationautofill.js"defer></script>
<script scr="main.js"defer></script>


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
            <li><a href="news/">News</a></li>
            <li><a href="logout.php">Log Out</a></li>
        </ul>
    </div>
</div>
<form action="editquotationinfo.php?id=<?php echo $sendername; ?>" method="POST" class="generate_quotation" autocomplete="off" enctype="multipart/form-data">
    <div class="generate_quote_container">
        <div id="contactpersonsectioncontainer">
        <p class="headingpara">Contact Person Section :</p>
        <!-- <div class="generate_quote_heading">Generate Quotation</div> -->
         <input type="hidden" value="<?php echo $row['uniqueid'] ?>" name="edituniqueid">
        <div class="outer02" id="datequote_container">
        <div class="trial1" id="quote_date_input">
    <input type="date"  placeholder="" name="quotation_date" class="input02" value="<?php echo $row['quote_date'] ?>">
    <label for="" class="placeholder2"> Quotation Date</label>
</div></div>
<!-- <input type="text" value=" <?php echo $uniqueId ?>" name="uniqueidname" readonly hidden > -->

<div class="outer02">
        <div class="trial1" id="companySelectouter">
<input type="text" name="clientname" placeholder="" value="<?php echo $row['to_name'] ?>" class="input02">
<label for="" class="placeholder2">Client Name</label>
</div>
        <div class="trial1" id="salute_dd">
            <select name="salutation_dd"  class="input02" required>
                <option <?php if($row['salutation']==='Mr'){echo 'selected';} ?> value="Mr">Mr</option>
                <option <?php if($row['salutation']==='Ms'){echo 'selected';} ?> value="Ms">Ms</option>
            </select>
        </div>
        <div class="trial1" id="contactSelectouter">
        <input type="text" placeholder="" name="contact_person" value="<?php echo $row['contact_person'] ?>" class="input02" required>
        <label for="" class="placeholder2">Contact Person</label>
        </div>



        </div>

        <div class="outer02">
        <div class="trial1">
        <input type="text" placeholder="" id="contactpersonaddress" value="<?php echo $row['to_address'] ?>" name="to_address" class="input02" required>
        <label for="" class="placeholder2">To Address</label>
        </div>

        <div class="trial1" id="contact_number1">
        <input type="text" placeholder="" id="clientcontactnumber" value="<?php echo $row['contact_person_cell'] ?>" name="contact_number" class="input02" required>
        <label for="" class="placeholder2">Contact Number</label>
        </div>
        
        <div class="trial1">
        <input type="text" placeholder="" id="clientcontactemail" value="<?php echo $row['email_id_contact_person'] ?>" name="email_id" class="input02" required>
        <label for="" class="placeholder2">Email Id</label>
        </div>
        </div>
        <input type="text" value="<?php echo $companyname001 ?>" id="comp_name_trial" hidden>
<button
  class="quotationnavigatebutton bg-white text-center w-30 rounded-lg h-10 relative text-black text-sm font-semibold group"
  type="button" onclick="equipmentsection()"
>
  <div
    class="bg-custom-blue rounded-md h-8 w-1/4 flex items-center justify-center absolute left-1 top-[2px] group-hover:w-[110px] z-10 duration-300"
    style="background-color: #1C549E;" 

  >
  <svg
      xmlns="http://www.w3.org/2000/svg"
      viewBox="0 0 1024 1024"
      height="18px"
      width="18px"
      transform="rotate(180)" 
    >
      <path
        d="M224 480h640a32 32 0 1 1 0 64H224a32 32 0 0 1 0-64z"
        fill="white" 
      ></path>
      <path
        d="m237.248 512 265.408 265.344a32 32 0 0 1-45.312 45.312l-288-288a32 32 0 0 1 0-45.312l288-288a32 32 0 1 1 45.312 45.312L237.248 512z"
        fill="white" 
      ></path>
    </svg>
  </div>
  <p class="translate-x-1" >Next</p>
</button>
        </div>
        <div id="equipmentinfosectioncontainer">
        <p class="headingpara">Equipment Information</p>    
        <div class="outer02">
        <div class="trial1">
        <select name="asset_code"  class="input02"  id="assetcode" required>
        <!-- onchange="editchoosenewequipment()"  -->
            <option value="" disabled selected>Choose Asset Code</option>
            <option <?php if($row['asset_code']==='New Equipment'){echo 'selected';} ?> value="New Equipment">Choose New Equipment</option>
    <?php
        while ($row_asset_code = mysqli_fetch_assoc($result_asset_code1)) {
            echo '<option value="' . $row_asset_code['assetcode'] . '"';
            if ($row_asset_code['assetcode'] === $row['asset_code']) { // Adjust this condition based on your actual logic
                echo ' selected';
            }
            echo '>' . $row_asset_code['assetcode'] . ' (' . $row_asset_code['sub_type'] . ' ' . $row_asset_code['make'] . ' ' . $row_asset_code['model'] . ')</option>';
                    }
    ?>
        </select>
        </div>
        <div class="trial1">
            <select name="availability" id="availability_dd" class="input02" onchange="not_immediate()" required>
                <option value=""disabled selected>Availability</option>
                <option <?php if($row['availability']==='Immediate'){echo 'selected';} ?> value="Immediate">Immediate</option>
                <option <?php if($row['availability']==='Not Immediate'){echo 'selected';} ?> value="Not Immediate">Select A Date</option>
            </select>
        </div>
        <div class="trial1" id="date_of_availability" >
            <input type="date" value="<?php echo $row['tentative_date']; ?>" placeholder="" class="input02" name="tentative_date">
            <label for="" class="placeholder2">Availability Date</label>
        </div>

        </div>
        <!-- <div class="prefetch_data_container" id="newprefetch">
        <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" value="<?php echo $row['yom'] ?>" name="yom_equip"  id="yom" class="input02">
                <label for="" class="placeholder2">YoM</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" value="<?php echo $row['cap'] ?>" name="capacity_equip" id="capacity" class="input02">
                <label for="" class="placeholder2">Capacity</label>
            </div>

        </div>
        <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" name="boom_equip" value="<?php echo $row['boom'] ?>" id="boomlength" class="input02">
                <label for="" class="placeholder2">Boom Length</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="jib_equip" value="<?php echo $row['jib'] ?>" id="jiblength" class="input02">
                <label for="" class="placeholder2">Jib Length</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="luffing_equip" value="<?php echo $row['luffing'] ?>" id="luffinglength" class="input02">
                <label for="" class="placeholder2">Luffing Length</label>
            </div>


            </div>
            </div> -->
        <div class="outer02" >
        <!-- new_equip  -->
        <div class="trial1">
        <select class="input02" name="fleet_category" id="oem_fleet_type" onchange="purchase_option()" >
            <option value="" disabled selected>Select Fleet Category</option>
            <option <?php if($row['category']==='Aerial Work Platform'){echo 'selected';} ?> value="Aerial Work Platform">Aerial Work Platform</option>
            <option <?php if($row['category']==='Concrete Equipment'){echo 'selected';} ?> value="Concrete Equipment">Concrete Equipment</option>
            <option <?php if($row['category']==='EarthMovers and Road Equipments'){echo 'selected';} ?> value="EarthMovers and Road Equipments">EarthMovers and Road Equipments</option>
            <option <?php if($row['category']==='Material Handling Equipments'){echo 'selected';} ?> value="Material Handling Equipments">Material Handling Equipments</option>
            <option <?php if($row['category']==='Ground Engineering Equipments'){echo 'selected';} ?> value="Ground Engineering Equipments">Ground Engineering Equipments</option>
            <option <?php if($row['category']==='Trailor and Truck'){echo 'selected';} ?> value="Trailor and Truck">Trailor and Truck</option>
            <option <?php if($row['category']==='Generator and Lighting'){echo 'selected';} ?> value="Generator and Lighting">Generator and Lighting</option>
        </select>

        </div>
        
        <div class="trial1">
        <select class="input02" name="type" id="fleet_sub_type" >
            <option value="" disabled selected>Select Fleet Type</option>
            <option <?php if($row['sub_Type'] === 'Self Propelled Articulated Boomlift'){echo 'selected';} ?> value="Self Propelled Articulated Boomlift" class="awp_options" id="aerial_work_platform_option1">Self Propelled Articulated Boomlift</option>
<option <?php if($row['sub_Type'] === 'Scissor Lift Diesel'){echo 'selected';} ?> value="Scissor Lift Diesel" class="awp_options" id="aerial_work_platform_option2">Scissor Lift Diesel</option>
<option <?php if($row['sub_Type'] === 'Scissor Lift Electric'){echo 'selected';} ?> value="Scissor Lift Electric" class="awp_options" id="aerial_work_platform_option3">Scissor Lift Electric</option>
<option <?php if($row['sub_Type'] === 'Spider Lift'){echo 'selected';} ?> value="Spider Lift" class="awp_options" id="aerial_work_platform_option4">Spider Lift</option>
<option <?php if($row['sub_Type'] === 'Self Propelled Straight Boomlift'){echo 'selected';} ?> value="Self Propelled Straight Boomlift" class="awp_options" id="aerial_work_platform_option5">Self Propelled Straight Boomlift</option>
<option <?php if($row['sub_Type'] === 'Truck Mounted Articulated Boomlift'){echo 'selected';} ?> value="Truck Mounted Articulated Boomlift" class="awp_options" id="aerial_work_platform_option6">Truck Mounted Articulated Boomlift</option>
<option <?php if($row['sub_Type'] === 'Truck Mounted Straight Boomlift'){echo 'selected';} ?> value="Truck Mounted Straight Boomlift" class="awp_options" id="aerial_work_platform_option7">Truck Mounted Straight Boomlift</option>
<option <?php if($row['sub_Type'] === 'Batching Plant'){echo 'selected';} ?> value="Batching Plant" class="cq_options" id="concrete_equipment_option1">Batching Plant</option>
<option <?php if($row['sub_Type'] === 'Self Loading Mixer'){echo 'selected';} ?> value="Self Loading Mixer" class="cq_options" id="">Self Loading Mixer</option>
<option <?php if($row['sub_Type'] === 'Concrete Boom Placer'){echo 'selected';} ?> value="Concrete Boom Placer" class="cq_options" id="concrete_equipment_option2">Concrete Boom Placer</option>
<option <?php if($row['sub_Type'] === 'Concrete Pump'){echo 'selected';} ?> value="Concrete Pump" class="cq_options" id="concrete_equipment_option3">Concrete Pump</option>
<option <?php if($row['sub_Type'] === 'Moli Pump'){echo 'selected';} ?> value="Moli Pump" class="cq_options" id="concrete_equipment_option4">Moli Pump</option>
<option <?php if($row['sub_Type'] === 'Mobile Batching Plant'){echo 'selected';} ?> value="Mobile Batching Plant" class="cq_options" id="concrete_equipment_option5">Mobile Batching Plant</option>
<option <?php if($row['sub_Type'] === 'Static Boom Placer'){echo 'selected';} ?> value="Static Boom Placer" class="cq_options" id="concrete_equipment_option6">Static Boom Placer</option>
<option <?php if($row['sub_Type'] === 'Transit Mixer'){echo 'selected';} ?> value="Transit Mixer" class="cq_options" id="concrete_equipment_option7">Transit Mixer</option>
<option <?php if($row['sub_Type'] === 'Baby Roller'){echo 'selected';} ?> value="Baby Roller" class="earthmover_options" id="earthmovers_option1">Baby Roller</option>
<option <?php if($row['sub_Type'] === 'Backhoe Loader'){echo 'selected';} ?> value="Backhoe Loader" class="earthmover_options" id="earthmovers_option2">Backhoe Loader</option>
<option <?php if($row['sub_Type'] === 'Bulldozer'){echo 'selected';} ?> value="Bulldozer" class="earthmover_options" id="earthmovers_option3">Bulldozer</option>
<option <?php if($row['sub_Type'] === 'Excavator'){echo 'selected';} ?> value="Excavator" class="earthmover_options" id="earthmovers_option4">Excavator</option>
<option <?php if($row['sub_Type'] === 'Milling Machine'){echo 'selected';} ?> value="Milling Machine" class="earthmover_options" id="earthmovers_option5">Milling Machine</option>
<option <?php if($row['sub_Type'] === 'Motor Grader'){echo 'selected';} ?> value="Motor Grader" class="earthmover_options" id="earthmovers_option6">Motor Grader</option>
<option <?php if($row['sub_Type'] === 'Pneumatic Tyre Roller'){echo 'selected';} ?> value="Pneumatic Tyre Roller" class="earthmover_options" id="earthmovers_option7">Pneumatic Tyre Roller</option>
<option <?php if($row['sub_Type'] === 'Single Drum Roller'){echo 'selected';} ?> value="Single Drum Roller" class="earthmover_options" id="earthmovers_option8">Single Drum Roller</option>
<option <?php if($row['sub_Type'] === 'Skid Loader'){echo 'selected';} ?> value="Skid Loader" class="earthmover_options" id="earthmovers_option9">Skid Loader</option>
<option <?php if($row['sub_Type'] === 'Slip Form Paver'){echo 'selected';} ?> value="Slip Form Paver" class="earthmover_options" id="earthmovers_option10">Slip Form Paver</option>
<option <?php if($row['sub_Type'] === 'Soil Compactor'){echo 'selected';} ?> value="Soil Compactor" class="earthmover_options" id="earthmovers_option11">Soil Compactor</option>
<option <?php if($row['sub_Type'] === 'Tandem Roller'){echo 'selected';} ?> value="Tandem Roller" class="earthmover_options" id="earthmovers_option12">Tandem Roller</option>
<option <?php if($row['sub_Type'] === 'Vibratory Roller'){echo 'selected';} ?> value="Vibratory Roller" class="earthmover_options" id="earthmovers_option13">Vibratory Roller</option>
<option <?php if($row['sub_Type'] === 'Wheeled Excavator'){echo 'selected';} ?> value="Wheeled Excavator" class="earthmover_options" id="earthmovers_option14">Wheeled Excavator</option>
<option <?php if($row['sub_Type'] === 'Wheeled Loader'){echo 'selected';} ?> value="Wheeled Loader" class="earthmover_options" id="earthmovers_option15">Wheeled Loader</option>
<option <?php if($row['sub_Type'] === 'Fixed Tower Crane'){echo 'selected';} ?> value="Fixed Tower Crane" class="mhe_options" id="mhe_option1">Fixed Tower Crane</option>
<option <?php if($row['sub_Type'] === 'Fork Lift Diesel'){echo 'selected';} ?> value="Fork Lift Diesel" class="mhe_options" id="mhe_option2">Fork Lift Diesel</option>
<option <?php if($row['sub_Type'] === 'Fork Lift Electric'){echo 'selected';} ?> value="Fork Lift Electric" class="mhe_options" id="mhe_option3">Fork Lift Electric</option>
<option <?php if($row['sub_Type'] === 'Hammerhead Tower Crane'){echo 'selected';} ?> value="Hammerhead Tower Crane" class="mhe_options" id="mhe_option4">Hammerhead Tower Crane</option>
<option <?php if($row['sub_Type'] === 'Hydraulic Crawler Crane'){echo 'selected';} ?> value="Hydraulic Crawler Crane" class="mhe_options" id="mhe_option5">Hydraulic Crawler Crane</option>
<option <?php if($row['sub_Type'] === 'Luffing Jib Tower Crane'){echo 'selected';} ?> value="Luffing Jib Tower Crane" class="mhe_options" id="mhe_option6">Luffing Jib Tower Crane</option>
<option <?php if($row['sub_Type'] === 'Mechanical Crawler Crane'){echo 'selected';} ?> value="Mechanical Crawler Crane" class="mhe_options" id="mhe_option7">Mechanical Crawler Crane</option>
<option <?php if($row['sub_Type'] === 'Pick and Carry Crane'){echo 'selected';} ?> value="Pick and Carry Crane" class="mhe_options" id="mhe_option8">Pick and Carry Crane</option>
<option <?php if($row['sub_Type'] === 'Reach Stacker'){echo 'selected';} ?> value="Reach Stacker" class="mhe_options" id="mhe_option9">Reach Stacker</option>
<option <?php if($row['sub_Type'] === 'Rough Terrain Crane'){echo 'selected';} ?> value="Rough Terrain Crane" class="mhe_options" id="mhe_option10">Rough Terrain Crane</option>
<option <?php if($row['sub_Type'] === 'Telehandler'){echo 'selected';} ?> value="Telehandler" class="mhe_options" id="mhe_option11">Telehandler</option>
<option <?php if($row['sub_Type'] === 'Telescopic Crawler Crane'){echo 'selected';} ?> value="Telescopic Crawler Crane" class="mhe_options" id="mhe_option12">Telescopic Crawler Crane</option>
<option <?php if($row['sub_Type'] === 'Telescopic Mobile Crane'){echo 'selected';} ?> value="Telescopic Mobile Crane" class="mhe_options" id="mhe_option13">Telescopic Mobile Crane</option>
<option <?php if($row['sub_Type'] === 'All Terrain Mobile Crane'){echo 'selected';} ?> value="All Terrain Mobile Crane" class="mhe_options" id="mhe_option14">All Terrain Mobile Crane</option>
<option <?php if($row['sub_Type'] === 'Self Loading Truck Crane'){echo 'selected';} ?> value="Self Loading Truck Crane" class="mhe_options" id="mhe_option15">Self Loading Truck Crane</option>
<option <?php if($row['sub_Type'] === 'Hydraulic Drilling Rig'){echo 'selected';} ?> value="Hydraulic Drilling Rig" class="gee_options" id="ground_engineering_equipment_option">Hydraulic Drilling Rig</option>
<option <?php if($row['sub_Type'] === 'Rotary Drilling Rig'){echo 'selected';} ?> value="Rotary Drilling Rig" class="gee_options" id="ground_engineering_equipment_option">Rotary Drilling Rig</option>
<option <?php if($row['sub_Type'] === 'Vibro Hammer'){echo 'selected';} ?> value="Vibro Hammer" class="gee_options" id="ground_engineering_equipment_option">Vibro Hammer</option>
<option <?php if($row['sub_Type'] === 'Dumper'){echo 'selected';} ?> value="Dumper" class="trailor_options" id="trailor_option1">Dumper</option>
<option <?php if($row['sub_Type'] === 'Truck'){echo 'selected';} ?> value="Truck" class="trailor_options" id="trailor_option2">Truck</option>
<option <?php if($row['sub_Type'] === 'Water Tanker'){echo 'selected';} ?> value="Water Tanker" class="trailor_options" id="trailor_option3">Water Tanker</option>
<option <?php if($row['sub_Type'] === 'Low Bed'){echo 'selected';} ?> value="Low Bed" class="trailor_options" id="trailor_option4">Low Bed</option>
<option <?php if($row['sub_Type'] === 'Semi Low Bed'){echo 'selected';} ?> value="Semi Low Bed" class="trailor_options" id="trailor_option5">Semi Low Bed</option>
<option <?php if($row['sub_Type'] === 'Flatbed'){echo 'selected';} ?> value="Flatbed" class="trailor_options" id="trailor_option6">Flatbed</option>
<option <?php if($row['sub_Type'] === 'Hydraulic Axle'){echo 'selected';} ?> value="Hydraulic Axle" class="trailor_options" id="trailor_option7">Hydraulic Axle</option>
<option <?php if($row['sub_Type'] === 'Silent Diesel Generator'){echo 'selected';} ?> value="Silent Diesel Generator" class="generator_options" id="generator_option">Silent Diesel Generator</option>
<option <?php if($row['sub_Type'] === 'Mobile Light Tower'){echo 'selected';} ?> value="Mobile Light Tower" class="generator_options" id="generator_option">Mobile Light Tower</option>
<option <?php if($row['sub_Type'] === 'Diesel Generator'){echo 'selected';} ?> value="Diesel Generator" class="generator_options" id="generator_option">Diesel Generator</option>
        </select>

        </div>
    </div>
    <div class="outer02" id="">
    <!-- newfleet_makemodel -->
        <div class="trial1">
            <input type="text" placeholder="" id="make" value="<?php echo $row['make'] ?>" name="fleetmake" class="input02">
            <label for="" class="placeholder2">Fleet Make</label>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" value="<?php echo $row['model'] ?>" id="model" name="fleetmodel" class="input02">
            <label for="" class="placeholder2">Fleet Model</label>
        </div>

    </div>
    <div class="outer02" id="">
    <!-- newfleet_capinfo -->
        <div class="trial1">
            <input type="text" placeholder="" value="<?php echo $row['cap'] ?>" id="capacity" name="fleet_cap" class="input02">
            <label for="" class="placeholder2">Fleet Capacity</label>
        </div>
        <div class="trial1" id="newfleet_unit">
            <select name="fleet_capunit" id="unit" class="input02">
                <option value=""disabled selected>Unit</option>
                <option <?php if($row['cap_unit']==='Ton'){echo 'selected';} ?> value="Ton">Ton</option>
                <option <?php if($row['cap_unit']==='Kgs'){echo 'selected';} ?> value="Kgs">Kgs</option>
                <option <?php if($row['cap_unit']==='KnM'){echo 'selected';} ?> value="KnM">KnM</option>
                <option <?php if($row['cap_unit']==='Meter'){echo 'selected';} ?> value="Meter">Meter</option>
                <option <?php if($row['cap_unit']==='M³'){echo 'selected';} ?> value="M³">M³</option>
            </select>
        </div>
        <div class="trial1">
            <input type="number" id="yom" placeholder="" value="<?php echo $row['yom'] ?>" name="yom_fleet" class="input02" min="1900" max="2099">
            <label for="" class="placeholder2">YOM</label>
        </div>
    </div>
    <div class="outer02" id="">
    <!-- newfleet_jib -->
    <div class="trial1" >
            <input type="text" name="boomLength" id="boomlength" value="<?php echo $row['boom'] ?>" placeholder="" class=" input02" >
            <label class="placeholder2">Boom Length</label>
        </div>    
        <div class="trial1" >
            <input type="text" name="jibLength" id="jiblength" placeholder="" value="<?php echo $row['jib'] ?>" class="input02 " >
            <label class="placeholder2">Jib Length</label>
        </div>
        <div class="trial1">
            <input type="text" name="luffingLength" id="luffinglength" placeholder="" value="<?php echo $row['luffing'] ?>" class=" input02" >
            <label class="placeholder2">Luffing Length</label>
        </div>

    </div>
        <div class="outer02">
        <div class="trial1">
            <select name="shiftinfo" id="select_shift" class="input02" onchange="shift_hour()" required>
                <option value=""disabled selected>Select Shift</option>
                <option <?php if($row['shift_info']==='Single Shift'){echo 'selected';} ?> value="Single Shift">Single Shift</option>
                <option <?php if($row['shift_info']==='Double Shift'){echo 'selected';} ?> value="Double Shift">Double Shift</option>
                <option <?php if($row['shift_info']==='Flexi Shift'){echo 'selected';} ?> value="Flexi Shift">Flexi Shift</option>
            </select>
        </div>


        <div class="trial1" id="single_Shift_hour">
            <!-- <input type="text" class="input02" name="hours_duration" placeholder="" >
            <label class="placeholder2" for="">Shift Duration In Hours</label> -->
            <select name="hours_duration" id="" class="input02">
                <option value="">Shift Duration</option>
                <option <?php if($row['hours_duration']==='8'){echo 'selected';} ?> value="8">8 Hours</option>
                <option <?php if($row['hours_duration']==='10'){echo 'selected';} ?> value="10">10 Hours</option>
                <option <?php if($row['hours_duration']==='12'){echo 'selected';} ?> value="12">12 Hours</option>
                <option <?php if($row['hours_duration']==='14'){echo 'selected';} ?> value="14">14 Hours</option>
                <option <?php if($row['hours_duration']==='16'){echo 'selected';} ?> value="16">16 Hours</option>
            </select>
        </div>
        <div class="trial1" id="othershift_enginehour">
        <select name="engine_hour" id="" class="input02">
            <option value=""disabled selected>Engine Hours</option>
            <option <?php if($row['engine_hours']==='200'){echo 'selected';} ?> value="200">Engine Hours: 200 Hours</option>
            <option <?php if($row['engine_hours']==='208'){echo 'selected';} ?> value="208">Engine Hours: 208 Hours</option>
            <option <?php if($row['engine_hours']==='260'){echo 'selected';} ?> value="260">Engine Hours: 260 Hours</option>
            <option <?php if($row['engine_hours']==='270'){echo 'selected';} ?> value="270">Engine Hours: 270 Hours</option>
            <option <?php if($row['engine_hours']==='280'){echo 'selected';} ?> value="280">Engine Hours: 280 Hours</option>
            <option <?php if($row['engine_hours']==='300'){echo 'selected';} ?> value="300">Engine Hours: 300 Hours</option>
            <option <?php if($row['engine_hours']==='312'){echo 'selected';} ?> value="312">Engine Hours: 312 Hours</option>
            <option <?php if($row['engine_hours']==='360'){echo 'selected';} ?> value="360">Engine Hours: 360 Hours</option>
            <option <?php if($row['engine_hours']==='400'){echo 'selected';} ?> value="400">Engine Hours: 400 Hours</option>
            <option <?php if($row['engine_hours']==='416'){echo 'selected';} ?> value="416">Engine Hours: 416 Hours</option>
            <option <?php if($row['engine_hours']==='460'){echo 'selected';} ?> value="460">Engine Hours: 460 Hours</option>
            <option <?php if($row['engine_hours']==='572'){echo 'selected';} ?> value="572">Engine Hours: 572 Hours</option>
            <option <?php if($row['engine_hours']==='672'){echo 'selected';} ?> value="672">Engine Hours: 672 Hours</option>
            <option <?php if($row['engine_hours']==='720'){echo 'selected';} ?> value="720">Engine Hours: 720 Hours</option>
        </select>
    </div>
    <div class="trial1">
        <input type="text" placeholder="" value="<?php echo $row['site_loc'] ?>" name="site_location" class="input02" required>
        <label for="" class="placeholder2">Site Location</label>
        </div>
        <div class="trial1">
            <input type="text" name="location" value="<?php echo $row['crane_location'] ?>" id="" placeholder="" class="input02" required>
            <label for="" class="placeholder2"> Equipment Location </label>
 
        </div>

    </div>

        <div class="outer02">
        <div class="trial1">
            <!-- <input type="text" class="input02" name="days_duration" placeholder="">
            <label class="placeholder2" for="">Duration Of Days In Month</label> -->
            <select name="days_duration" id="" class="input02" required>
                <option value="" disabled>Working Days</option>
                <option <?php if($row['days_duration']==='7'){echo 'selected';} ?> value="7">7 Days/Month</option>
                <option <?php if($row['days_duration']==='10'){echo 'selected';} ?> value="10">10 Days/Month</option>
                <option <?php if($row['days_duration']==='15'){echo 'selected';} ?> value="15">15 Days/Month</option>
                <option <?php if($row['days_duration']==='26'){echo 'selected';} ?> value="26" >26 Days/Month</option>
                <option <?php if($row['days_duration']==='28'){echo 'selected';} ?> value="28">28 Days/Month</option>
                <option <?php if($row['days_duration']==='30'){echo 'selected';} ?> value="30">30 Days/Month</option>
            </select>
        </div>
        <div class="trial1">
            <select name="condition" id="" class="input02" required>
                <option value=""disabled selected>Condition</option>
                <option <?php if($row['sunday_included']==='Including Sundays'){echo 'selected';} ?> value="Including Sundays">Including Sundays</option>
                <option <?php if($row['sunday_included']==='Excluding First Two Sundays'){echo 'selected';} ?> value="Excluding First Two Sundays">Excluding First Two Sundays</option>
                <option <?php if($row['sunday_included']==='Excluding Any Two Sundays'){echo 'selected';} ?> value="Excluding Any Two Sundays">Excluding Any Two Sundays</option>
                <option <?php if($row['sunday_included']==='Excluding Sundays'){echo 'selected';} ?> value="Excluding Sundays" >Excluding Sundays</option>
            </select>
        </div>
        <!-- <div class="trial1">
            <input type="text" placeholder=""  class="input02">
            <label for="" class="placeholder2">Fuel in ltrs Per Hour</label>
        </div> -->
        <div class="trial1">
                <input type="text" placeholder="" value="<?php echo $row['fuel/hour'] ?>" name="fuel_per_hour" id="fuel" class="input02" required>
                <label for="" class="placeholder2">Fuel/Hour</label>
            </div>
            <div class="trial1">
            <select name="adblue" id="" class="input02" required>
                <option value=""disabled selected>Adblue?</option>
                <option <?php if($row['adblue']==='Yes'){echo 'selected';} ?> value="Yes">Adblue :Yes</option>
                <option <?php if($row['adblue']==='No'){echo 'selected';} ?> value="No">Adblue :No</option>
            </select>
        </div>


        </div>
        <div class="outer02">

        <div class="trial1" id="rental_charges1">
            <input type="number" name="rental_charges" value="<?php echo $row['rental_charges'] ?>"  placeholder="" class="input02" required>
            <label for="" class="placeholder2">Rental Charges </label>
        </div>
        <div class="trial1" id="mob_charges1">
            <input type="number" name="mob_charges" value="<?php echo $row['mob_charges'] ?>" placeholder="" class="input02" required>
            <label for="" class="placeholder2">Mob Charges </label>
        </div>
        <div class="trial1" id="demob_charges1">
            <input type="number" name="demob_charges" value="<?php echo $row['demob_charges'] ?>" placeholder="" class="input02" required>
            <label for="" class="placeholder2">Demob Charges </label>
        </div>
        </div>
        <div class="outer02">

        </div>

    <div class="trial1" id="sender_add_employee">
    <textarea type="text" placeholder="" name="sender_office_address" class="input02"><?php echo $row_companyaddress['company_address'] ;?></textarea>
    <label for="" class="placeholder2">Sender Office Address</label>
    </div>
    <div class="addbuttonicon" id="second_addequipbtn"><i onclick="other_quotation()"  class="bi bi-plus-circle">Add Another Equipment</i></div>

    <!-- second equipment  -->
    <div class="otherquipquote" id="new_out1">
        <br>
        <p class="add_second_equipment_generate">Add Second Equipment Details <i onclick="cancelsecondequipment()" class="bi bi-x icon-cancel"></i></p> 
    <div class="outer02 mt-10px" >
        <div class="trial1">
        <select  name="asset_code1" class="input02" onchange="choose_new_equ2()" id="choose_Ac2">
            <option value="" disabled selected>Choose Asset Code</option>
            <option <?php if(isset($row2['asset_code2']) && $row2['asset_code2']==='New Equipment'){echo 'selected';} ?> value="New Equipment">Choose New Equipment</option>
            <?php
while ($row_asset_code2 = mysqli_fetch_assoc($result_asset_code)) {
    echo '<option value="' . $row_asset_code2['assetcode'] . '"';
    // Add the 'selected' attribute if assetcode matches
    if (isset($row2['asset_code2']) && $row_asset_code2['assetcode'] === $row2['asset_code2']) { 
        echo ' selected';
    }
    echo '>' . $row_asset_code2['assetcode'] . " (" 
         . $row_asset_code2['sub_type'] . " " 
         . $row_asset_code2['make'] . " " 
         . $row_asset_code2['model'] . ")</option>";
}
?>
        </select>
        </div>
        <div class="trial1">
            <select name="avail1" id="availability_dd2" class="input02" onchange="not_immediate2()">
                <option value="">Availability</option>
                <option <?php if (isset($row2['availability2']) && $row2['availability2'] === 'Immediate') { echo 'selected'; } ?> value="Immediate">Immediate</option>
<option <?php if (isset($row2['availability2']) && $row2['availability2'] === 'Not Immediate') { echo 'selected'; } ?> value="Not Immediate">Select A Date</option>
            </select>
        </div>
        <div class="trial1" id="date_of_availability2" >
        <input type="date" placeholder="" 
       value="<?php echo isset($row2['tentative_date2']) ? $row2['tentative_date2'] : ''; ?>" 
       name="date_" class="input02">
            <label for="" class="placeholder2"> Availability Date</label>
        </div>

        </div>
        <!-- <div class="prefetch_data_container_second" id="prefetch_second">
        <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" name="yom_equip_second" id="yom_second" class="input02">
                <label for="" class="placeholder2">YoM</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="capacity_equip_second" id="capacity_second" class="input02">
                <label for="" class="placeholder2">Capacity</label>
            </div>
        </div> -->
        <!-- <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" name="boom_equip_second" id="boomlength_second" class="input02">
                <label for="" class="placeholder2">Boom Length</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="jib_equip_second" id="jiblength_second" class="input02">
                <label for="" class="placeholder2">Jib Length</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="luffing_equip_second" id="luffinglength_second" class="input02">
                <label for="" class="placeholder2">Luffing Length</label>
            </div>


            </div>
            </div> -->

        <div class="newequip_details1" id="">
        <!-- newequipdet1  -->
        <div class="outer02" id="" >
        <div class="trial1">
        <select class="input02" name="fleet_category1" id="oem_fleet_type1" onchange="seco_equip()" >
            <option value="" disabled selected>Select Fleet Category</option>
            <option <?php if (isset($row2['category2']) && $row2['category2'] === 'Aerial Work Platform') echo 'selected'; ?> value="Aerial Work Platform">Aerial Work Platform</option>
<option <?php if (isset($row2['category2']) && $row2['category2'] === 'Concrete Equipment') echo 'selected'; ?> value="Concrete Equipment">Concrete Equipment</option>
<option <?php if (isset($row2['category2']) && $row2['category2'] === 'EarthMovers and Road Equipments') echo 'selected'; ?> value="EarthMovers and Road Equipments">EarthMovers and Road Equipments</option>
<option <?php if (isset($row2['category2']) && $row2['category2'] === 'Material Handling Equipments') echo 'selected'; ?> value="Material Handling Equipments">Material Handling Equipments</option>
<option <?php if (isset($row2['category2']) && $row2['category2'] === 'Ground Engineering Equipments') echo 'selected'; ?> value="Ground Engineering Equipments">Ground Engineering Equipments</option>
<option <?php if (isset($row2['category2']) && $row2['category2'] === 'Trailor and Truck') echo 'selected'; ?> value="Trailor and Truck">Trailor and Truck</option>
<option <?php if (isset($row2['category2']) && $row2['category2'] === 'Generator and Lighting') echo 'selected'; ?> value="Generator and Lighting">Generator and Lighting</option>
        </select>

        </div>
        <div class="trial1">
        <select class="input02" name="type1" id="fleet_sub_type1" >
            <option value="" disabled selected>Select Fleet Type</option>
            <option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Self Propelled Articulated Boomlift') echo 'selected'; ?> value="Self Propelled Articulated Boomlift" class="awp_options1" id="aerial_work_platform_option1">Self Propelled Articulated Boomlift</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Scissor Lift Diesel') echo 'selected'; ?> value="Scissor Lift Diesel" class="awp_options1" id="aerial_work_platform_option2">Scissor Lift Diesel</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Scissor Lift Electric') echo 'selected'; ?> value="Scissor Lift Electric" class="awp_options1" id="aerial_work_platform_option3">Scissor Lift Electric</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Spider Lift') echo 'selected'; ?> value="Spider Lift" class="awp_options1" id="aerial_work_platform_option4">Spider Lift</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Self Propelled Straight Boomlift') echo 'selected'; ?> value="Self Propelled Straight Boomlift" class="awp_options1" id="aerial_work_platform_option5">Self Propelled Straight Boomlift</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Truck Mounted Articulated Boomlift') echo 'selected'; ?> value="Truck Mounted Articulated Boomlift" class="awp_options1" id="aerial_work_platform_option6">Truck Mounted Articulated Boomlift</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Truck Mounted Straight Boomlift') echo 'selected'; ?> value="Truck Mounted Straight Boomlift" class="awp_options1" id="aerial_work_platform_option7">Truck Mounted Straight Boomlift</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Batching Plant') echo 'selected'; ?> value="Batching Plant" class="cq_options1" id="concrete_equipment_option1">Batching Plant</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Self Loading Mixer') echo 'selected'; ?> value="Self Loading Mixer" class="cq_options1" id="concrete_equipment_option2">Self Loading Mixer</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Concrete Boom Placer') echo 'selected'; ?> value="Concrete Boom Placer" class="cq_options1" id="concrete_equipment_option3">Concrete Boom Placer</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Concrete Pump') echo 'selected'; ?> value="Concrete Pump" class="cq_options1" id="concrete_equipment_option4">Concrete Pump</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Moli Pump') echo 'selected'; ?> value="Moli Pump" class="cq_options1" id="concrete_equipment_option5">Moli Pump</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Mobile Batching Plant') echo 'selected'; ?> value="Mobile Batching Plant" class="cq_options1" id="concrete_equipment_option6">Mobile Batching Plant</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Static Boom Placer') echo 'selected'; ?> value="Static Boom Placer" class="cq_options1" id="concrete_equipment_option7">Static Boom Placer</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Transit Mixer') echo 'selected'; ?> value="Transit Mixer" class="cq_options1" id="concrete_equipment_option8">Transit Mixer</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Baby Roller') echo 'selected'; ?> value="Baby Roller" class="earthmover_options1" id="earthmovers_option1">Baby Roller</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Backhoe Loader') echo 'selected'; ?> value="Backhoe Loader" class="earthmover_options1" id="earthmovers_option2">Backhoe Loader</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Bulldozer') echo 'selected'; ?> value="Bulldozer" class="earthmover_options1" id="earthmovers_option3">Bulldozer</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Excavator') echo 'selected'; ?> value="Excavator" class="earthmover_options1" id="earthmovers_option4">Excavator</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Milling Machine') echo 'selected'; ?> value="Milling Machine" class="earthmover_options1" id="earthmovers_option5">Milling Machine</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Motor Grader') echo 'selected'; ?> value="Motor Grader" class="earthmover_options1" id="earthmovers_option6">Motor Grader</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Pneumatic Tyre Roller') echo 'selected'; ?> value="Pneumatic Tyre Roller" class="earthmover_options1" id="earthmovers_option7">Pneumatic Tyre Roller</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Single Drum Roller') echo 'selected'; ?> value="Single Drum Roller" class="earthmover_options1" id="earthmovers_option8">Single Drum Roller</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Skid Loader') echo 'selected'; ?> value="Skid Loader" class="earthmover_options1" id="earthmovers_option9">Skid Loader</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Slip Form Paver') echo 'selected'; ?> value="Slip Form Paver" class="earthmover_options1" id="earthmovers_option10">Slip Form Paver</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Soil Compactor') echo 'selected'; ?> value="Soil Compactor" class="earthmover_options1" id="earthmovers_option11">Soil Compactor</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Tandem Roller') echo 'selected'; ?> value="Tandem Roller" class="earthmover_options1" id="earthmovers_option12">Tandem Roller</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Vibratory Roller') echo 'selected'; ?> value="Vibratory Roller" class="earthmover_options1" id="earthmovers_option13">Vibratory Roller</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Wheeled Excavator') echo 'selected'; ?> value="Wheeled Excavator" class="earthmover_options1" id="earthmovers_option14">Wheeled Excavator</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Wheeled Loader') echo 'selected'; ?> value="Wheeled Loader" class="earthmover_options1" id="earthmovers_option15">Wheeled Loader</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Fixed Tower Crane') echo 'selected'; ?> value="Fixed Tower Crane" class="mhe_options1" id="mhe_option1">Fixed Tower Crane</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Fork Lift Diesel') echo 'selected'; ?> value="Fork Lift Diesel" class="mhe_options1" id="mhe_option2">Fork Lift Diesel</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Fork Lift Electric') echo 'selected'; ?> value="Fork Lift Electric" class="mhe_options1" id="mhe_option3">Fork Lift Electric</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Hammerhead Tower Crane') echo 'selected'; ?> value="Hammerhead Tower Crane" class="mhe_options1" id="mhe_option4">Hammerhead Tower Crane</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Hydraulic Crawler Crane') echo 'selected'; ?> value="Hydraulic Crawler Crane" class="mhe_options1" id="mhe_option5">Hydraulic Crawler Crane</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Luffing Jib Tower Crane') echo 'selected'; ?> value="Luffing Jib Tower Crane" class="mhe_options1" id="mhe_option6">Luffing Jib Tower Crane</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Mechanical Crawler Crane') echo 'selected'; ?> value="Mechanical Crawler Crane" class="mhe_options1" id="mhe_option7">Mechanical Crawler Crane</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Pick and Carry Crane') echo 'selected'; ?> value="Pick and Carry Crane" class="mhe_options1" id="mhe_option8">Pick and Carry Crane</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Reach Stacker') echo 'selected'; ?> value="Reach Stacker" class="mhe_options1" id="mhe_option9">Reach Stacker</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Rough Terrain Crane') echo 'selected'; ?> value="Rough Terrain Crane" class="mhe_options1" id="mhe_option10">Rough Terrain Crane</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Telehandler') echo 'selected'; ?> value="Telehandler" class="mhe_options1" id="mhe_option11">Telehandler</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Telescopic Crawler Crane') echo 'selected'; ?> value="Telescopic Crawler Crane" class="mhe_options1" id="mhe_option12">Telescopic Crawler Crane</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Telescopic Mobile Crane') echo 'selected'; ?> value="Telescopic Mobile Crane" class="mhe_options1" id="mhe_option13">Telescopic Mobile Crane</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'All Terrain Mobile Crane') echo 'selected'; ?> value="All Terrain Mobile Crane" class="mhe_options1" id="mhe_option14">All Terrain Mobile Crane</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Self Loading Truck Crane') echo 'selected'; ?> value="Self Loading Truck Crane" class="mhe_options1" id="mhe_option15">Self Loading Truck Crane</option>

<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Hydraulic Drilling Rig') echo 'selected'; ?> value="Hydraulic Drilling Rig" class="gee_options1" id="ground_engineering_equipment_option1">Hydraulic Drilling Rig</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Rotary Drilling Rig') echo 'selected'; ?> value="Rotary Drilling Rig" class="gee_options1" id="ground_engineering_equipment_option2">Rotary Drilling Rig</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Vibro Hammer') echo 'selected'; ?> value="Vibro Hammer" class="gee_options1" id="ground_engineering_equipment_option3">Vibro Hammer</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Dumper') echo 'selected'; ?> value="Dumper" class="trailor_options1" id="trailor_option1">Dumper</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Truck') echo 'selected'; ?> value="Truck" class="trailor_options1" id="trailor_option2">Truck</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Water Tanker') echo 'selected'; ?> value="Water Tanker" class="trailor_options1" id="trailor_option3">Water Tanker</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Low Bed') echo 'selected'; ?> value="Low Bed" class="trailor_options1" id="trailor_option4">Low Bed</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Semi Low Bed') echo 'selected'; ?> value="Semi Low Bed" class="trailor_options1" id="trailor_option5">Semi Low Bed</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Flatbed') echo 'selected'; ?> value="Flatbed" class="trailor_options1" id="trailor_option6">Flatbed</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Hydraulic Axle') echo 'selected'; ?> value="Hydraulic Axle" class="trailor_options1" id="trailor_option7">Hydraulic Axle</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Silent Diesel Generator') echo 'selected'; ?> value="Silent Diesel Generator" class="generator_options" id="generator_option1">Silent Diesel Generator</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Mobile Light Tower') echo 'selected'; ?> value="Mobile Light Tower" class="generator_options" id="generator_option2">Mobile Light Tower</option>
<option <?php if (isset($row2['sub_type2']) && $row2['sub_type2'] === 'Diesel Generator') echo 'selected'; ?> value="Diesel Generator" class="generator_options" id="generator_option3">Diesel Generator</option>
        </select>

        </div>
    </div>
    <div class="outer02" id="">
        <div class="trial1">
            <input type="text" placeholder="" id="2ndvehiclemake"       value="<?php echo isset($row2['make2']) ? $row2['make2'] : ''; ?>" 
            name="newfleetmake1" class="input02">
            <label for="" class="placeholder2">Fleet Make</label>
        </div>
        <div class="trial1">
            <input type="text" placeholder=""    id="2ndvehiclemodel"    value="<?php echo isset($row2['model2']) ? $row2['model2'] : ''; ?>" 
            name="newfleetmodel1" class="input02">
            <label for="" class="placeholder2">Fleet Model</label>
        </div>

    </div>
    <div class="outer02" id="">
        <div class="trial1">
            <input type="text" placeholder="" id="capacity_second"       value="<?php echo isset($row2['cap2']) ? $row2['cap2'] : ''; ?>" 
            name="fleetcap2" class="input02">
            <label for="" class="placeholder2">Fleet Capacity</label>
        </div>
        <div class="trial1" id="newfleet_unit">
            <select name="unit2" id="2ndequipmentunit" class="input02">
                <option value=""disabled selected>Unit</option>
                <option <?php if(isset($row2['cap_unit2']) && $row2['cap_unit2']==='Ton'){echo 'selected';} ?> value="Ton">Ton</option>
                <option <?php if(isset($row2['cap_unit2']) && $row2['cap_unit2']==='Kgs'){echo 'selected';} ?> value="Kgs">Kgs</option>
                <option <?php if(isset($row2['cap_unit2']) && $row2['cap_unit2']==='KnM'){echo 'selected';} ?> value="KnM">KnM</option>
                <option <?php if(isset($row2['cap_unit2']) && $row2['cap_unit2']==='Meter'){echo 'selected';} ?> value="Meter">Meter</option>
                <option <?php if(isset($row2['cap_unit2']) && $row2['cap_unit2']==='M³'){echo 'selected';} ?> value="M³">M³</option>
            </select>
        </div>
        <div class="trial1">
            <input type="number" placeholder=""  id="yom_second"      value="<?php echo isset($row2['yom2']) ? $row2['yom2'] : ''; ?>" 
            name="yom2" class="input02" min="1900" max="2099">
            <label for="" class="placeholder2">YOM</label>
        </div>
    </div>
    <div class="outer02" id="">
    <div class="trial1" >
            <input type="text" name="boomLength2"    id="boomlength_second"    value="<?php echo isset($row2['boom2']) ? $row2['boom2'] : ''; ?>" 
            placeholder="" class=" input02" >
            <label class="placeholder2">Boom Length</label>
        </div>    
        <div class="trial1" >
            <input type="text" name="jibLength2"  id="jiblength_second"      value="<?php echo isset($row2['jib2']) ? $row2['jib2'] : ''; ?>" 
            placeholder="" class="input02 " >
            <label class="placeholder2">Jib Length</label>
        </div>
        <div class="trial1">
            <input type="text" name="luffingLength2"  id="luffinglength_second"      value="<?php echo isset($row2['luffing2']) ? $row2['luffing2'] : ''; ?>" 
            placeholder="" class=" input02" >
            <label class="placeholder2">Luffing Length</label>
        </div>
    </div>

    </div>
        <div class="outer02">
        <div class="trial1">
            <input type="number" name="rental2" placeholder=""        value="<?php echo isset($row2['rental_charges2']) ? $row2['rental_charges2'] : ''; ?>" 
            class="input02">
            <label for="" class="placeholder2">Rental Charges </label>
        </div>
        <div class="trial1">
            <input type="number" name="mob02" placeholder=""        value="<?php echo isset($row2['mob_charges2']) ? $row2['mob_charges2'] : ''; ?>" 
            class="input02">
            <label for="" class="placeholder2">Mob Charges </label>
        </div>
        <div class="trial1">
            <input type="number" name="demob02" placeholder=""        value="<?php echo isset($row2['demob_charges2']) ? $row2['demob_charges2'] : ''; ?>" 
            class="input02">
            <label for="" class="placeholder2">Demob Charges </label>
        </div>
        </div>
        <div class="outer02">
        <div class="trial1">
            <input type="text" name="equiplocation02" placeholder=""        value="<?php echo isset($row2['crane_location2']) ? $row2['crane_location2'] : ''; ?>" 
            class="input02">
            <label for="" class="placeholder2"> Equipment Location </label>
 
        </div>
        <div class="trial1">
            <input type="text" placeholder="" name="fuelperltr2"        value="<?php echo isset($row2['fuel/hour2']) ? $row2['fuel/hour2'] : ''; ?>" 
            id="fuel_second" class="input02">
            <label for="" class="placeholder2">Fuel/Hour</label>
        </div>

        <div class="trial1">
            <select name="adblue2" id="" class="input02">
                <option value=""disabled selected>Adblue?</option>
                <option <?php if (isset($row2['adblue2']) && $row2['adblue2'] === 'Yes') { echo 'selected'; } ?> value="Yes">Adblue : Yes</option>
<option <?php if (isset($row2['adblue2']) && $row2['adblue2'] === 'No') { echo 'selected'; } ?> value="No">Adblue : No</option>
            </select>
        </div>
        </div>
        <div class="addbuttonicon" id="third_addequipbtn"><i onclick="third_vehicle()"  class="bi bi-plus-circle">Add Another Equipment</i></div>
        </div>


    <!-- thirdrow -->
    <div class="otherquipquote" id="thirdvehicledetail">
        <br>
        <p class="add_second_equipment_generate">Add Third Equipment Details <i onclick="cancelthirdequipment()" title="cancel" class="bi bi-x icon-cancel"></i></p> 
    <div class="outer02 mt-10px" >
        <div class="trial1">
        <select  name="asset_code3" class="input02"  id="choose_Ac3">
        <!-- onchange="choose_new_equ_third()"  -->
            <option value="" disabled selected>Choose Asset Code</option>
            <option <?php if(isset($row3['asset_code2']) && $row3['asset_code2']==='New Equipment'){echo 'selected';} ?> value="New Equipment">Choose New Equipment</option>
            <?php
while ($row_asset_code3 = mysqli_fetch_assoc($result_asset_code3)) {
    ?>
    <option value="<?php echo $row_asset_code3['assetcode']; ?>" <?php if(isset($row3['asset_code2']) && $row3['asset_code2']=== $row_asset_code3['assetcode']){echo 'selected';} ?>>
        <?php echo $row_asset_code3['assetcode'] . " (" . $row_asset_code3['sub_type'] . " " . $row_asset_code3['make'] . " " . $row_asset_code3['model'] . ")"; ?>
    </option>
    <?php
}
?>
        </select>
        </div>
        <div class="trial1">
            <select name="avail3" id="availability_dd3" class="input02" onchange="not_immediate3()">
                <option value=""disabled selected>Availability</option>
                <option <?php if(isset($row3['availability2']) && $row3['availability2']==='Immediate'){echo 'selected';} ?> value="Immediate">Immediate</option>
                <option <?php if(isset($row3['availability2']) && $row3['availability2']==='Not Immediate'){echo 'selected';} ?> value="Not Immediate">Select A Date</option>
            </select>
        </div>
        <div class="trial1" id="date_of_availability3" >
            <input type="date" placeholder="" value="<?php echo isset($row3['tentative_date2']) ? $row3['tentative_date2'] : ''; ?>" name="date3" class="input02">
            <label for="" class="placeholder2"> Availability Date</label>
        </div>

        </div>
        <!-- <div class="prefetch_data_container_second" id="prefetch_third">
        <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" name="yom3" id="yom_third" class="input02">
                <label for="" class="placeholder2">YoM</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="capacity3" id="capacity_third" class="input02">
                <label for="" class="placeholder2">Capacity</label>
            </div>
        </div>
        <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" name="boom3" id="boomlength_third" class="input02">
                <label for="" class="placeholder2">Boom Length</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="jib3" id="jiblength_third" class="input02">
                <label for="" class="placeholder2">Jib Length</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="luffing3" id="luffinglength_third" class="input02">
                <label for="" class="placeholder2">Luffing Length</label>
            </div>


            </div>
            </div> -->

        <div class="newequip_details1" id="">
        <!-- newequipdet3  -->
        <div class="outer02" id="" >
        <div class="trial1">
        <select class="input02" name="fleet_category3" id="oem_fleet_type3" onchange="third_equipment()" >
            <option value="" disabled selected>Select Fleet Category</option>
            <option <?php if (isset($row3['category2']) && $row3['category2'] === 'Aerial Work Platform') { echo 'selected'; } ?> value="Aerial Work Platform">Aerial Work Platform</option>
<option <?php if (isset($row3['category2']) && $row3['category2'] === 'Concrete Equipment') { echo 'selected'; } ?> value="Concrete Equipment">Concrete Equipment</option>
<option <?php if (isset($row3['category2']) && $row3['category2'] === 'EarthMovers and Road Equipments') { echo 'selected'; } ?> value="EarthMovers and Road Equipments">EarthMovers and Road Equipments</option>
<option <?php if (isset($row3['category2']) && $row3['category2'] === 'Material Handling Equipments') { echo 'selected'; } ?> value="Material Handling Equipments">Material Handling Equipments</option>
<option <?php if (isset($row3['category2']) && $row3['category2'] === 'Ground Engineering Equipments') { echo 'selected'; } ?> value="Ground Engineering Equipments">Ground Engineering Equipments</option>
<option <?php if (isset($row3['category2']) && $row3['category2'] === 'Trailor and Truck') { echo 'selected'; } ?> value="Trailor and Truck">Trailor and Truck</option>
<option <?php if (isset($row3['category2']) && $row3['category2'] === 'Generator and Lighting') { echo 'selected'; } ?> value="Generator and Lighting">Generator and Lighting</option>

        </select>

        </div>
        <div class="trial1">
        <select class="input02" name="type3" id="fleet_sub_type3" >
            <option value="" disabled selected>Select Fleet Type</option>
<!-- Aerial Work Platform Options -->
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Self Propelled Articulated Boomlift') { echo 'selected'; } ?> value="Self Propelled Articulated Boomlift" class="awp_options3" id="aerial_work_platform_option1">Self Propelled Articulated Boomlift</option>
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Scissor Lift Diesel') { echo 'selected'; } ?> value="Scissor Lift Diesel" class="awp_options3" id="aerial_work_platform_option2">Scissor Lift Diesel</option>
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Scissor Lift Electric') { echo 'selected'; } ?> value="Scissor Lift Electric" class="awp_options3" id="aerial_work_platform_option3">Scissor Lift Electric</option>
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Spider Lift') { echo 'selected'; } ?> value="Spider Lift" class="awp_options3" id="aerial_work_platform_option4">Spider Lift</option>
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Self Propelled Straight Boomlift') { echo 'selected'; } ?> value="Self Propelled Straight Boomlift" class="awp_options3" id="aerial_work_platform_option5">Self Propelled Straight Boomlift</option>
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Truck Mounted Articulated Boomlift') { echo 'selected'; } ?> value="Truck Mounted Articulated Boomlift" class="awp_options3" id="aerial_work_platform_option6">Truck Mounted Articulated Boomlift</option>
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Truck Mounted Straight Boomlift') { echo 'selected'; } ?> value="Truck Mounted Straight Boomlift" class="awp_options3" id="aerial_work_platform_option7">Truck Mounted Straight Boomlift</option>

<!-- Concrete Equipment Options -->
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Batching Plant') { echo 'selected'; } ?> value="Batching Plant" class="cq_options3" id="concrete_equipment_option1">Batching Plant</option>
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Self Loading Mixer') { echo 'selected'; } ?> value="Self Loading Mixer" class="cq_options3" id="">Self Loading Mixer</option>
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Concrete Boom Placer') { echo 'selected'; } ?> value="Concrete Boom Placer" class="cq_options3" id="concrete_equipment_option2">Concrete Boom Placer</option>
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Concrete Pump') { echo 'selected'; } ?> value="Concrete Pump" class="cq_options3" id="concrete_equipment_option3">Concrete Pump</option>
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Moli Pump') { echo 'selected'; } ?> value="Moli Pump" class="cq_options3" id="concrete_equipment_option4">Moli Pump</option>
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Mobile Batching Plant') { echo 'selected'; } ?> value="Mobile Batching Plant" class="cq_options3" id="concrete_equipment_option5">Mobile Batching Plant</option>
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Static Boom Placer') { echo 'selected'; } ?> value="Static Boom Placer" class="cq_options3" id="concrete_equipment_option6">Static Boom Placer</option>
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Transit Mixer') { echo 'selected'; } ?> value="Transit Mixer" class="cq_options3" id="concrete_equipment_option7">Transit Mixer</option>

<!-- EarthMovers Options -->
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Baby Roller') { echo 'selected'; } ?> value="Baby Roller" class="earthmover_options3" id="earthmovers_option1">Baby Roller</option>
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Backhoe Loader') { echo 'selected'; } ?> value="Backhoe Loader" class="earthmover_options3" id="earthmovers_option2">Backhoe Loader</option>
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Bulldozer') { echo 'selected'; } ?> value="Bulldozer" class="earthmover_options3" id="earthmovers_option3">Bulldozer</option>
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Excavator') { echo 'selected'; } ?> value="Excavator" class="earthmover_options3" id="earthmovers_option4">Excavator</option>
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Milling Machine') { echo 'selected'; } ?> value="Milling Machine" class="earthmover_options3" id="earthmovers_option5">Milling Machine</option>
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Motor Grader') { echo 'selected'; } ?> value="Motor Grader" class="earthmover_options3" id="earthmovers_option6">Motor Grader</option>
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Pneumatic Tyre Roller') { echo 'selected'; } ?> value="Pneumatic Tyre Roller" class="earthmover_options3" id="earthmovers_option7">Pneumatic Tyre Roller</option>
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Single Drum Roller') { echo 'selected'; } ?> value="Single Drum Roller" class="earthmover_options3" id="earthmovers_option8">Single Drum Roller</option>
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Skid Loader') { echo 'selected'; } ?> value="Skid Loader" class="earthmover_options3" id="earthmovers_option9">Skid Loader</option>
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Slip Form Paver') { echo 'selected'; } ?> value="Slip Form Paver" class="earthmover_options3" id="earthmovers_option10">Slip Form Paver</option>
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Soil Compactor') { echo 'selected'; } ?> value="Soil Compactor" class="earthmover_options3" id="earthmovers_option11">Soil Compactor</option>
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Tandem Roller') { echo 'selected'; } ?> value="Tandem Roller" class="earthmover_options3" id="earthmovers_option12">Tandem Roller</option>
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Vibratory Roller') { echo 'selected'; } ?> value="Vibratory Roller" class="earthmover_options3" id="earthmovers_option13">Vibratory Roller</option>
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Wheeled Excavator') { echo 'selected'; } ?> value="Wheeled Excavator" class="earthmover_options3" id="earthmovers_option14">Wheeled Excavator</option>
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Wheeled Loader') { echo 'selected'; } ?> value="Wheeled Loader" class="earthmover_options3" id="earthmovers_option15">Wheeled Loader</option>

<!-- Material Handling Equipments Options -->
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Fixed Tower Crane') { echo 'selected'; } ?> value="Fixed Tower Crane" class="mhe_options3" id="mhe_option1">Fixed Tower Crane</option>
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Fork Lift Diesel') { echo 'selected'; } ?> value="Fork Lift Diesel" class="mhe_options3" id="mhe_option2">Fork Lift Diesel</option>
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Fork Lift Electric') { echo 'selected'; } ?> value="Fork Lift Electric" class="mhe_options3" id="mhe_option3">Fork Lift Electric</option>
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Hammerhead Tower Crane') { echo 'selected'; } ?> value="Hammerhead Tower Crane" class="mhe_options3" id="mhe_option4">Hammerhead Tower Crane</option>
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Hydraulic Crawler Crane') { echo 'selected'; } ?> value="Hydraulic Crawler Crane" class="mhe_options3" id="mhe_option5">Hydraulic Crawler Crane</option>
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Luffing Jib Tower Crane') { echo 'selected'; } ?> value="Luffing Jib Tower Crane" class="mhe_options3" id="mhe_option6">Luffing Jib Tower Crane</option>
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Mechanical Crawler Crane') { echo 'selected'; } ?> value="Mechanical Crawler Crane" class="mhe_options3" id="mhe_option7">Mechanical Crawler Crane</option>
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Pick and Carry Crane') { echo 'selected'; } ?> value="Pick and Carry Crane" class="mhe_options3" id="mhe_option8">Pick and Carry Crane</option>
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Reach Stacker') { echo 'selected'; } ?> value="Reach Stacker" class="mhe_options3" id="mhe_option9">Reach Stacker</option>
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Rough Terrain Crane') { echo 'selected'; } ?> value="Rough Terrain Crane" class="mhe_options3" id="mhe_option10">Rough Terrain Crane</option>
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Telehandler') { echo 'selected'; } ?> value="Telehandler" class="mhe_options3" id="mhe_option11">Telehandler</option>
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Telescopic Crawler Crane') { echo 'selected'; } ?> value="Telescopic Crawler Crane" class="mhe_options3" id="mhe_option12">Telescopic Crawler Crane</option>
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Telescopic Mobile Crane') { echo 'selected'; } ?> value="Telescopic Mobile Crane" class="mhe_options3" id="mhe_option13">Telescopic Mobile Crane</option>
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'All Terrain Mobile Crane') { echo 'selected'; } ?> value="All Terrain Mobile Crane" class="mhe_options3" id="mhe_option14">All Terrain Mobile Crane</option>
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Self Loading Truck Crane') { echo 'selected'; } ?> value="Self Loading Truck Crane" class="mhe_options3" id="mhe_option15">Self Loading Truck Crane</option>

<!-- Ground Engineering Equipment Options -->
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Hydraulic Drilling Rig') { echo 'selected'; } ?> value="Hydraulic Drilling Rig" class="gee_options3" id="ground_engineering_equipment_option1">Hydraulic Drilling Rig</option>
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Rotary Drilling Rig') { echo 'selected'; } ?> value="Rotary Drilling Rig" class="gee_options3" id="ground_engineering_equipment_option2">Rotary Drilling Rig</option>
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Vibro Hammer') { echo 'selected'; } ?> value="Vibro Hammer" class="gee_options3" id="ground_engineering_equipment_option3">Vibro Hammer</option>

<!-- Trailor Options -->
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Dumper') { echo 'selected'; } ?> value="Dumper" class="trailor_options3" id="trailor_option1">Dumper</option>
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Truck') { echo 'selected'; } ?> value="Truck" class="trailor_options3" id="trailor_option2">Truck</option>
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Water Tanker') { echo 'selected'; } ?> value="Water Tanker" class="trailor_options3" id="trailor_option3">Water Tanker</option>
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Low Bed') { echo 'selected'; } ?> value="Low Bed" class="trailor_options3" id="trailor_option4">Low Bed</option>
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Semi Low Bed') { echo 'selected'; } ?> value="Semi Low Bed" class="trailor_options3" id="trailor_option5">Semi Low Bed</option>
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Flatbed') { echo 'selected'; } ?> value="Flatbed" class="trailor_options3" id="trailor_option6">Flatbed</option>
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Hydraulic Axle') { echo 'selected'; } ?> value="Hydraulic Axle" class="trailor_options3" id="trailor_option7">Hydraulic Axle</option>

<!-- Generator Options -->
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Silent Diesel Generator') { echo 'selected'; } ?> value="Silent Diesel Generator" class="generator_options3" id="generator_option1">Silent Diesel Generator</option>
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Mobile Light Tower') { echo 'selected'; } ?> value="Mobile Light Tower" class="generator_options3" id="generator_option2">Mobile Light Tower</option>
<option <?php if (isset($row3['sub_type2']) && $row3['sub_type2'] === 'Diesel Generator') { echo 'selected'; } ?> value="Diesel Generator" class="generator_options3" id="generator_option3">Diesel Generator</option>
        </select>

        </div>
    </div>
    <div class="outer02" id="">
        <div class="trial1">
            <input type="text" placeholder="" id="3rdequipmentmake" value="<?php echo isset($row3['make2']) ? $row3['make2'] : ''; ?>" name="newfleetmake3" class="input02">
            <label for="" class="placeholder2">Fleet Make</label>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" id="3rdequipmentmodel" value="<?php echo isset($row3['model2']) ? $row3['model2'] : ''; ?>" name="newfleetmodel3" class="input02">
            <label for="" class="placeholder2">Fleet Model</label>
        </div>

    </div>
    <div class="outer02" id="">
        <div class="trial1">
            <input type="text" placeholder="" value="<?php echo isset($row3['cap2']) ? $row3['cap2'] : ''; ?>" id="capacity_third" name="fleetcap3" class="input02">
            <label for="" class="placeholder2">Fleet Capacity</label>
        </div>
        <div class="trial1" id="newfleet_unit">
            <select name="unit3" id="3rdequipmentunit" class="input02">
                <option value=""disabled selected>Unit</option>
                <option <?php if(isset($row3['cap_unit2']) && $row3['cap_unit2']==='Ton'){echo 'selected';} ?> value="Ton">Ton</option>
                <option <?php if(isset($row3['cap_unit2']) && $row3['cap_unit2']==='Kgs'){echo 'selected';} ?> value="Kgs">Kgs</option>
                <option <?php if(isset($row3['cap_unit2']) && $row3['cap_unit2']==='KnM'){echo 'selected';} ?> value="KnM">KnM</option>
                <option <?php if(isset($row3['cap_unit2']) && $row3['cap_unit2']==='Meter'){echo 'selected';} ?> value="Meter">Meter</option>
                <option <?php if(isset($row3['cap_unit2']) && $row3['cap_unit2']==='M³'){echo 'selected';} ?> value="M³">M³</option>
            </select>
        </div>
        <div class="trial1">
            <input type="number" id="yom3" placeholder="" value="<?php echo isset($row3['yom2']) ? $row3['yom2'] : ''; ?>" name="newyom3" class="input02" min="1900" max="2099">
            <label for="" class="placeholder2">YOM</label>
        </div>
    </div>
    <div class="outer02" id="">
    <div class="trial1" >
            <input type="text" id="boom3" name="boomLength3" value="<?php echo isset($row3['boom2']) ? $row3['boom2'] : ''; ?>" placeholder="" class=" input02" >
            <label class="placeholder2">Boom Length</label>
        </div>    
        <div class="trial1" >
            <input type="text" id="jib3" name="jibLength3"  placeholder="" value="<?php echo isset($row3['jib2']) ? $row3['jib2'] : ''; ?>" class="input02 " >
            <label class="placeholder2">Jib Length</label>
        </div>
        <div class="trial1">
            <input type="text" id="luffing3" name="luffingLength3" value="<?php echo isset($row3['luffing2']) ? $row3['luffing2'] : ''; ?>" placeholder="" class=" input02" >
            <label class="placeholder2">Luffing Length</label>
        </div>
    </div>

    </div>
        <div class="outer02">
        <div class="trial1">
            <input type="number" name="rental3" placeholder="" value="<?php echo isset($row3['rental_charges2']) ? $row3['rental_charges2'] : ''; ?>" class="input02">
            <label for="" class="placeholder2">Rental Charges </label>
        </div>
        <div class="trial1">
            <input type="number" name="mob03" placeholder="" value="<?php echo isset($row3['mob_charges2']) ? $row3['mob_charges2'] : ''; ?>" class="input02">
            <label for="" class="placeholder2">Mob Charges </label>
        </div>
        <div class="trial1">
            <input type="number" name="demob03" placeholder="" value="<?php echo isset($row3['demob_charges2']) ? $row3['demob_charges2'] : ''; ?>" class="input02">
            <label for="" class="placeholder2">Demob Charges </label>
        </div>
        </div>
        <div class="outer02">
        <div class="trial1">
            <input type="text" id="location3" name="equiplocation03" value="<?php echo isset($row3['crane_location2']) ? $row3['crane_location2'] : ''; ?>" placeholder="" class="input02">
            <label for="" class="placeholder2"> Equipment Location </label>
 
        </div>
        <div class="trial1">
            <input type="text" placeholder="" name="fuelperltr3" value="<?php echo isset($row3['fuel/hour2']) ? $row3['fuel/hour2'] : ''; ?>" id="fuel_third" class="input02">
            <label for="" class="placeholder2">Fuel/Hour</label>
        </div>

        <div class="trial1">
            <select name="adblue3" id="" class="input02">
                <option value=""disabled selected>Adblue?</option>
                <option <?php if(isset($row3['adblue2']) && $row3['adblue2']==='Yes'){echo 'selected';} ?> value="Yes">Adblue : Yes</option>
                <option <?php if(isset($row3['adblue2']) && $row3['adblue2']==='No'){echo 'selected';} ?> value="No">Adblue : No</option>
            </select>
        </div>
        </div>
        <div class="addbuttonicon" id="fourth_addequipbtn"><i onclick="fourth_quotation()"  class="bi bi-plus-circle">Add Another Equipment</i></div>
        </div>


    <!-- fourthrow -->
    <div class="otherquipquote" id="fouthvehicledata">
        <br>
        <p class="add_second_equipment_generate">Add Fourth Equipment Details <i onclick="cancelfourthequipment()" class="bi bi-x icon-cancel"></i></p> 
    <div class="outer02 mt-10px" >
        <div class="trial1">
        <select  name="asset_code4" class="input02" onchange="choose_new_equ_fourth()" id="choose_Ac4">
            <option value="" disabled selected>Choose Asset Code</option>
            <option <?php if(isset($row4['asset_code2']) && $row4['asset_code2']==='New Equipment' ){echo 'selected';} ?> value="New Equipment">Choose New Equipment</option>
            <?php
while ($row_asset_code4 = mysqli_fetch_assoc($result_asset_code4)) {
    $selected = (isset($row4['asset_code2']) && $row4['asset_code2'] === $row_asset_code4['assetcode']) ? 'selected' : '';
    echo '<option ' . $selected . ' value="' . $row_asset_code4['assetcode'] . '">' . $row_asset_code4['assetcode'] . " (" . $row_asset_code4['sub_type'] . " " . $row_asset_code4['make'] . " " . $row_asset_code4['model'] . ")" . '</option>';
}
?>        </select>
        </div>
        <div class="trial1">
            <select name="avail4" id="availability_dd4" class="input02" onchange="not_immediate4()">
                <option value=""disabled selected>Availability</option>
                <option <?php if(isset($row4['availability2']) && $row4['availability2']==='Immediate'){echo 'selected';} ?> value="Immediate">Immediate</option>
                <option <?php if(isset($row4['availability2']) && $row4['availability2']==='Not Immediate'){echo 'selected';}  ?> value="Not Immediate">Select A Date</option>
            </select>
        </div>
        <div class="trial1" id="date_of_availability4" >
            <input type="date" placeholder="" value="<?php echo isset($row4['tentative_date2']) ? $row4['tentative_date2'] : ''; ?>" name="date4" class="input02">
            <label for="" class="placeholder2"> Availability Date</label>
        </div>

        </div>
        <div class="newequip_details1" id="">
        <div class="outer02" id="" >
        <div class="trial1">
        <select class="input02" name="fleet_category4" id="oem_fleet_type4" onchange="fourth_equipment()" >
            <option value="" disabled selected>Select Fleet Category</option>
            <option <?php if (isset($row4['category2']) && $row4['category2'] === 'Aerial Work Platform') { echo 'selected'; } ?> value="Aerial Work Platform">Aerial Work Platform</option>
<option <?php if (isset($row4['category2']) && $row4['category2'] === 'Concrete Equipment') { echo 'selected'; } ?> value="Concrete Equipment">Concrete Equipment</option>
<option <?php if (isset($row4['category2']) && $row4['category2'] === 'EarthMovers and Road Equipments') { echo 'selected'; } ?> value="EarthMovers and Road Equipments">EarthMovers and Road Equipments</option>
<option <?php if (isset($row4['category2']) && $row4['category2'] === 'Material Handling Equipments') { echo 'selected'; } ?> value="Material Handling Equipments">Material Handling Equipments</option>
<option <?php if (isset($row4['category2']) && $row4['category2'] === 'Ground Engineering Equipments') { echo 'selected'; } ?> value="Ground Engineering Equipments">Ground Engineering Equipments</option>
<option <?php if (isset($row4['category2']) && $row4['category2'] === 'Trailor and Truck') { echo 'selected'; } ?> value="Trailor and Truck">Trailor and Truck</option>
<option <?php if (isset($row4['category2']) && $row4['category2'] === 'Generator and Lighting') { echo 'selected'; } ?> value="Generator and Lighting">Generator and Lighting</option>
        </select>

        </div>
        <div class="trial1">
        <select class="input02" name="type4" id="fleet_sub_type4" >
            <option value="" disabled selected>Select Fleet Type</option>
            <option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Self Propelled Articulated Boomlift') { echo 'selected'; } ?> value="Self Propelled Articulated Boomlift" class="awp_options4" id="aerial_work_platform_option1">Self Propelled Articulated Boomlift</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Scissor Lift Diesel') { echo 'selected'; } ?> value="Scissor Lift Diesel" class="awp_options4" id="aerial_work_platform_option2">Scissor Lift Diesel</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Scissor Lift Electric') { echo 'selected'; } ?> value="Scissor Lift Electric" class="awp_options4" id="aerial_work_platform_option3">Scissor Lift Electric</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Spider Lift') { echo 'selected'; } ?> value="Spider Lift" class="awp_options4" id="aerial_work_platform_option4">Spider Lift</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Self Propelled Straight Boomlift') { echo 'selected'; } ?> value="Self Propelled Straight Boomlift" class="awp_options4" id="aerial_work_platform_option5">Self Propelled Straight Boomlift</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Truck Mounted Articulated Boomlift') { echo 'selected'; } ?> value="Truck Mounted Articulated Boomlift" class="awp_options4" id="aerial_work_platform_option6">Truck Mounted Articulated Boomlift</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Truck Mounted Straight Boomlift') { echo 'selected'; } ?> value="Truck Mounted Straight Boomlift" class="awp_options4" id="aerial_work_platform_option7">Truck Mounted Straight Boomlift</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Batching Plant') { echo 'selected'; } ?> value="Batching Plant" class="cq_options4" id="concrete_equipment_option1">Batching Plant</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Self Loading Mixer') { echo 'selected'; } ?> value="Self Loading Mixer" class="cq_options4">Self Loading Mixer</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Concrete Boom Placer') { echo 'selected'; } ?> value="Concrete Boom Placer" class="cq_options4" id="concrete_equipment_option2">Concrete Boom Placer</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Concrete Pump') { echo 'selected'; } ?> value="Concrete Pump" class="cq_options4" id="concrete_equipment_option3">Concrete Pump</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Moli Pump') { echo 'selected'; } ?> value="Moli Pump" class="cq_options4" id="concrete_equipment_option4">Moli Pump</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Mobile Batching Plant') { echo 'selected'; } ?> value="Mobile Batching Plant" class="cq_options4" id="concrete_equipment_option5">Mobile Batching Plant</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Static Boom Placer') { echo 'selected'; } ?> value="Static Boom Placer" class="cq_options4" id="concrete_equipment_option6">Static Boom Placer</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Transit Mixer') { echo 'selected'; } ?> value="Transit Mixer" class="cq_options4" id="concrete_equipment_option7">Transit Mixer</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Baby Roller') { echo 'selected'; } ?> value="Baby Roller" class="earthmover_options4" id="earthmovers_option1">Baby Roller</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Backhoe Loader') { echo 'selected'; } ?> value="Backhoe Loader" class="earthmover_options4" id="earthmovers_option2">Backhoe Loader</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Bulldozer') { echo 'selected'; } ?> value="Bulldozer" class="earthmover_options4" id="earthmovers_option3">Bulldozer</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Excavator') { echo 'selected'; } ?> value="Excavator" class="earthmover_options4" id="earthmovers_option4">Excavator</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Milling Machine') { echo 'selected'; } ?> value="Milling Machine" class="earthmover_options4" id="earthmovers_option5">Milling Machine</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Motor Grader') { echo 'selected'; } ?> value="Motor Grader" class="earthmover_options4" id="earthmovers_option6">Motor Grader</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Pneumatic Tyre Roller') { echo 'selected'; } ?> value="Pneumatic Tyre Roller" class="earthmover_options4" id="earthmovers_option7">Pneumatic Tyre Roller</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Single Drum Roller') { echo 'selected'; } ?> value="Single Drum Roller" class="earthmover_options4" id="earthmovers_option8">Single Drum Roller</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Skid Loader') { echo 'selected'; } ?> value="Skid Loader" class="earthmover_options4" id="earthmovers_option9">Skid Loader</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Slip Form Paver') { echo 'selected'; } ?> value="Slip Form Paver" class="earthmover_options4" id="earthmovers_option10">Slip Form Paver</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Soil Compactor') { echo 'selected'; } ?> value="Soil Compactor" class="earthmover_options4" id="earthmovers_option11">Soil Compactor</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Tandem Roller') { echo 'selected'; } ?> value="Tandem Roller" class="earthmover_options4" id="earthmovers_option12">Tandem Roller</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Vibratory Roller') { echo 'selected'; } ?> value="Vibratory Roller" class="earthmover_options4" id="earthmovers_option13">Vibratory Roller</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Wheeled Excavator') { echo 'selected'; } ?> value="Wheeled Excavator" class="earthmover_options4" id="earthmovers_option14">Wheeled Excavator</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Wheeled Loader') { echo 'selected'; } ?> value="Wheeled Loader" class="earthmover_options4" id="earthmovers_option15">Wheeled Loader</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Fixed Tower Crane') { echo 'selected'; } ?> id="mhe_option1" class="mhe_options4" value="Fixed Tower Crane">Fixed Tower Crane</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Fork Lift Diesel') { echo 'selected'; } ?> id="mhe_option2" class="mhe_options4" value="Fork Lift Diesel">Fork Lift Diesel</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Fork Lift Electric') { echo 'selected'; } ?> id="mhe_option3" class="mhe_options4" value="Fork Lift Electric">Fork Lift Electric</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Hammerhead Tower Crane') { echo 'selected'; } ?> id="mhe_option4" class="mhe_options4" value="Hammerhead Tower Crane">Hammerhead Tower Crane</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Hydraulic Crawler Crane') { echo 'selected'; } ?> id="mhe_option5" class="mhe_options4" value="Hydraulic Crawler Crane">Hydraulic Crawler Crane</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Luffing Jib Tower Crane') { echo 'selected'; } ?> id="mhe_option6" class="mhe_options4" value="Luffing Jib Tower Crane">Luffing Jib Tower Crane</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Mechanical Crawler Crane') { echo 'selected'; } ?> id="mhe_option7" class="mhe_options4" value="Mechanical Crawler Crane">Mechanical Crawler Crane</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Pick and Carry Crane') { echo 'selected'; } ?> id="mhe_option8" class="mhe_options4" value="Pick and Carry Crane">Pick and Carry Crane</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Reach Stacker') { echo 'selected'; } ?> id="mhe_option9" class="mhe_options4" value="Reach Stacker">Reach Stacker</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Rough Terrain Crane') { echo 'selected'; } ?> id="mhe_option10" class="mhe_options4" value="Rough Terrain Crane">Rough Terrain Crane</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Telehandler') { echo 'selected'; } ?> id="mhe_option11" class="mhe_options4" value="Telehandler">Telehandler</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Telescopic Crawler Crane') { echo 'selected'; } ?> id="mhe_option12" class="mhe_options4" value="Telescopic Crawler Crane">Telescopic Crawler Crane</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Telescopic Mobile Crane') { echo 'selected'; } ?> id="mhe_option13" class="mhe_options4" value="Telescopic Mobile Crane">Telescopic Mobile Crane</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'All Terrain Mobile Crane') { echo 'selected'; } ?> id="mhe_option14" class="mhe_options4" value="All Terrain Mobile Crane">All Terrain Mobile Crane</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Self Loading Truck Crane') { echo 'selected'; } ?> id="mhe_option15" class="mhe_options4" value="Self Loading Truck Crane">Self Loading Truck Crane</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Hydraulic Drilling Rig') { echo 'selected'; } ?> class="gee_options4" value="Hydraulic Drilling Rig">Hydraulic Drilling Rig</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Rotary Drilling Rig') { echo 'selected'; } ?> class="gee_options4" value="Rotary Drilling Rig">Rotary Drilling Rig</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Vibro Hammer') { echo 'selected'; } ?> class="gee_options4" value="Vibro Hammer">Vibro Hammer</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Dumper') { echo 'selected'; } ?> id="trailor_option1" class="trailor_options4" value="Dumper">Dumper</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Truck') { echo 'selected'; } ?> id="trailor_option2" class="trailor_options4" value="Truck">Truck</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Water Tanker') { echo 'selected'; } ?> id="trailor_option3" class="trailor_options4" value="Water Tanker">Water Tanker</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Low Bed') { echo 'selected'; } ?> id="trailor_option4" class="trailor_options4" value="Low Bed">Low Bed</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Semi Low Bed') { echo 'selected'; } ?> id="trailor_option5" class="trailor_options4" value="Semi Low Bed">Semi Low Bed</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Flatbed') { echo 'selected'; } ?> id="trailor_option6" class="trailor_options4" value="Flatbed">Flatbed</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Hydraulic Axle') { echo 'selected'; } ?> id="trailor_option7" class="trailor_options4" value="Hydraulic Axle">Hydraulic Axle</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Silent Diesel Generator') { echo 'selected'; } ?> id="generator_option1" class="generator_options4" value="Silent Diesel Generator">Silent Diesel Generator</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Mobile Light Tower') { echo 'selected'; } ?> id="generator_option2" class="generator_options4" value="Mobile Light Tower">Mobile Light Tower</option>
<option <?php if (isset($row4['sub_type2']) && $row4['sub_type2'] === 'Diesel Generator') { echo 'selected'; } ?> id="generator_option3" class="generator_options4" value="Diesel Generator">Diesel Generator</option>
        </select>

        </div>
    </div>
    <div class="outer02" id="">
        <div class="trial1">
            <input type="text" placeholder="" value="<?php echo isset($row4['make2']) ? $row4['make2'] : ''; ?>" id="4thmake" name="newfleetmake4" class="input02">
            <label for="" class="placeholder2">Fleet Make</label>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" id="4thmodel" value="<?php echo isset($row4['model2']) ? $row4['model2'] : ''; ?>" name="newfleetmodel4" class="input02">
            <label for="" class="placeholder2">Fleet Model</label>
        </div>

    </div>
    <div class="outer02" id="">
        <div class="trial1">
            <input type="text" placeholder="" value="<?php echo isset($row4['cap2']) ? $row4['cap2'] : ''; ?>" id="4thcap" name="fleetcap4" class="input02">
            <label for="" class="placeholder2">Fleet Capacity</label>
        </div>
        <div class="trial1" id="newfleet_unit">
            <select name="unit4" id="4thunit" class="input02">
                <option value=""disabled selected>Unit</option>
                <option <?php if(isset($row4['cap_unit2']) && $row4['cap_unit2']==='Ton'){echo 'selected';} ?> value="Ton">Ton</option>
                <option <?php if(isset($row4['cap_unit2']) && $row4['cap_unit2']==='Kgs'){echo 'selected';} ?> value="Kgs">Kgs</option>
                <option <?php if(isset($row4['cap_unit2']) && $row4['cap_unit2']==='KnM'){echo 'selected';} ?> value="KnM">KnM</option>
                <option <?php if(isset($row4['cap_unit2']) && $row4['cap_unit2']==='Meter'){echo 'selected';} ?> value="Meter">Meter</option>
                <option <?php if(isset($row4['cap_unit2']) && $row4['cap_unit2']==='M³'){echo 'selected';} ?> value="M³">M³</option>
            </select>
        </div>
        <div class="trial1">
            <input type="number" placeholder=""  value="<?php echo isset($row4['yom2']) ? $row4['yom2'] : ''; ?>" id="4thyom" name="newyom4" class="input02" min="1900" max="2099">
            <label for="" class="placeholder2">YOM</label>
        </div>
    </div>
    <div class="outer02" id="">
    <div class="trial1" >
            <input type="text" name="boomLength4" id="4thboom" value="<?php echo isset($row4['boom2']) ? $row4['boom2'] : ''; ?>" placeholder="" class=" input02" >
            <label class="placeholder2">Boom Length</label>
        </div>    
        <div class="trial1" >
            <input type="text" name="jibLength4" id="4thjib" value="<?php echo isset($row4['jib2']) ? $row4['jib2'] : ''; ?>"  placeholder="" class="input02 " >
            <label class="placeholder2">Jib Length</label>
        </div>
        <div class="trial1">
            <input type="text" name="luffingLength4" id="4thluffing" value="<?php echo isset($row4['luffing2']) ? $row4['luffing2'] : ''; ?>" placeholder="" class=" input02" >
            <label class="placeholder2">Luffing Length</label>
        </div>
    </div>

    </div>
        <div class="outer02">
        <div class="trial1">
            <input type="number" name="rental4" placeholder="" value="<?php echo isset($row4['rental_charges2']) ? $row4['rental_charges2'] : ''; ?>" class="input02">
            <label for="" class="placeholder2">Rental Charges </label>
        </div>
        <div class="trial1">
            <input type="number" name="mob04" placeholder="" value="<?php echo isset($row4['mob_charges2']) ? $row4['mob_charges2'] : ''; ?>" class="input02">
            <label for="" class="placeholder2">Mob Charges </label>
        </div>
        <div class="trial1">
            <input type="number" name="demob04" placeholder="" value="<?php echo isset($row4['demob_charges2']) ? $row4['demob_charges2'] : ''; ?>" class="input02">
            <label for="" class="placeholder2">Demob Charges </label>
        </div>
        </div>
        <div class="outer02">
        <div class="trial1">
            <input type="text" name="equiplocation04" placeholder="" value="<?php echo isset($row4['crane_location2']) ? $row4['crane_location2'] : ''; ?>" class="input02">
            <label for="" class="placeholder2"> Equipment Location </label>
 
        </div>
        <div class="trial1">
            <input type="text" placeholder="" name="fuelperltr4" value="<?php echo isset($row4['fuel/hour2']) ? $row4['fuel/hour2'] : ''; ?>" id="fuel_fourth" class="input02">
            <label for="" class="placeholder2">Fuel/Hour</label>
        </div>

        <div class="trial1">
            <select name="adblue4" id="" class="input02">
                <option value=""disabled selected>Adblue?</option>
                <option <?php if(isset($row4['adblue2']) && $row4['adblue2']==='Yes'){echo 'selected';} ?> value="Yes">Adblue : Yes</option>
                <option <?php if(isset($row4['adblue2']) && $row4['adblue2']==='No'){echo 'selected';} ?> value="No">Adblue : No</option>
            </select>
        </div>
        </div>
        <div class="addbuttonicon" id="fifth_addequipbtn"><i onclick="fifth_quotation()"  class="bi bi-plus-circle">Add Another Equipment</i></div>

        <!-- <div class="addbuttonicon" id="lastaddequipbtn"><i onclick="addanother_equip()"  class="bi bi-plus-circle"></i><p>Add Another Equipment</p></div> -->
        </div>

    <!-- fifthrow -->
    <div class="otherquipquote" id="fifthvehicledata">
        <br>
        <p class="add_second_equipment_generate">Add Fifth Equipment Details <i onclick="cancelfifthequipment()" class="bi bi-x icon-cancel"></i></p> 
    <div class="outer02 mt-10px" >
        <div class="trial1">
        <select  name="asset_code5" class="input02" onchange="choose_new_equ_fifth()" id="choose_Ac5">
            <option value="" disabled selected>Choose Asset Code</option>
            <option <?php if(isset($row5['asset_code2']) && $row5['asset_code2']==='New Equipment'){echo 'selected';} ?> value="New Equipment">Choose New Equipment</option>
            <?php
    while ($row_asset_code5 = mysqli_fetch_assoc($result_asset_code5)) {
        $selected = (isset($row5['asset_code2']) && $row5['asset_code2'] === $row_asset_code5['assetcode']) ? 'selected' : '';
        echo '<option ' . $selected . ' value="' . $row_asset_code5['assetcode'] . '">' . $row_asset_code5['assetcode'] . " (" . $row_asset_code5['sub_type'] . " " . $row_asset_code5['make'] . " " . $row_asset_code5['model'] . ")" . '</option>';
    }
?>        </select>
        </div>
        <div class="trial1">
            <select name="avail5" id="availability_dd5" class="input02" onchange="not_immediate5()">
                <option value=""disabled selected>Availability</option>
                <option <?php if(isset($row5['availability2']) && $row5['availability2']==='Immediate'){echo 'selected';} ?> value="Immediate">Immediate</option>
                <option <?php if(isset($row5['availability2']) && $row5['availability2']==='Not Immediate'){echo 'selected';} ?> value="Not Immediate">Select A Date</option>
            </select>
        </div>
        <div class="trial1" id="date_of_availability5" >
            <input type="date" placeholder=""  value="<?php echo isset($row5['tentative_date2']) ? $row5['tentative_date2'] : ''; ?>" name="date5" class="input02">
            <label for="" class="placeholder2"> Availability Date</label>
        </div>

        </div>
        <div class="newequip_details1" id="">
        <div class="outer02" id="" >
        <div class="trial1">
        <select class="input02" name="fleet_category5" id="oem_fleet_type5" onchange="fifth_equipment()" >
            <option value="" disabled selected>Select Fleet Category</option>
            <option <?php if(isset($row5['category2']) && $row5['category2'] === 'Aerial Work Platform'){ echo 'selected'; } ?> value="Aerial Work Platform">Aerial Work Platform</option>
<option <?php if(isset($row5['category2']) && $row5['category2'] === 'Concrete Equipment'){ echo 'selected'; } ?> value="Concrete Equipment">Concrete Equipment</option>
<option <?php if(isset($row5['category2']) && $row5['category2'] === 'EarthMovers and Road Equipments'){ echo 'selected'; } ?> value="EarthMovers and Road Equipments">EarthMovers and Road Equipments</option>
<option <?php if(isset($row5['category2']) && $row5['category2'] === 'Material Handling Equipments'){ echo 'selected'; } ?> value="Material Handling Equipments">Material Handling Equipments</option>
<option <?php if(isset($row5['category2']) && $row5['category2'] === 'Ground Engineering Equipments'){ echo 'selected'; } ?> value="Ground Engineering Equipments">Ground Engineering Equipments</option>
<option <?php if(isset($row5['category2']) && $row5['category2'] === 'Trailor and Truck'){ echo 'selected'; } ?> value="Trailor and Truck">Trailor and Truck</option>
<option <?php if(isset($row5['category2']) && $row5['category2'] === 'Generator and Lighting'){ echo 'selected'; } ?> value="Generator and Lighting">Generator and Lighting</option>
        </select>

        </div>
        <div class="trial1">
        <select class="input02" name="type5" id="fleet_sub_type5" >
            <option value="" disabled selected>Select Fleet Type</option>
            <option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Self Propelled Articulated Boomlift'){ echo 'selected'; } ?> value="Self Propelled Articulated Boomlift" class="awp_options5" id="aerial_work_platform_option1">Self Propelled Articulated Boomlift</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Scissor Lift Diesel'){ echo 'selected'; } ?> value="Scissor Lift Diesel" class="awp_options5" id="aerial_work_platform_option2">Scissor Lift Diesel</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Scissor Lift Electric'){ echo 'selected'; } ?> value="Scissor Lift Electric" class="awp_options5" id="aerial_work_platform_option3">Scissor Lift Electric</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Spider Lift'){ echo 'selected'; } ?> value="Spider Lift" class="awp_options5" id="aerial_work_platform_option4">Spider Lift</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Self Propelled Straight Boomlift'){ echo 'selected'; } ?> value="Self Propelled Straight Boomlift" class="awp_options5" id="aerial_work_platform_option5">Self Propelled Straight Boomlift</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Truck Mounted Articulated Boomlift'){ echo 'selected'; } ?> value="Truck Mounted Articulated Boomlift" class="awp_options5" id="aerial_work_platform_option6">Truck Mounted Articulated Boomlift</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Truck Mounted Straight Boomlift'){ echo 'selected'; } ?> value="Truck Mounted Straight Boomlift" class="awp_options5" id="aerial_work_platform_option7">Truck Mounted Straight Boomlift</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Batching Plant'){ echo 'selected'; } ?> value="Batching Plant" class="cq_options5" id="concrete_equipment_option1">Batching Plant</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Self Loading Mixer'){ echo 'selected'; } ?> value="Self Loading Mixer" class="cq_options5" id="concrete_equipment_option2">Self Loading Mixer</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Concrete Boom Placer'){ echo 'selected'; } ?> value="Concrete Boom Placer" class="cq_options5" id="concrete_equipment_option3">Concrete Boom Placer</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Concrete Pump'){ echo 'selected'; } ?> value="Concrete Pump" class="cq_options5" id="concrete_equipment_option4">Concrete Pump</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Moli Pump'){ echo 'selected'; } ?> value="Moli Pump" class="cq_options5" id="concrete_equipment_option5">Moli Pump</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Mobile Batching Plant'){ echo 'selected'; } ?> value="Mobile Batching Plant" class="cq_options5" id="concrete_equipment_option6">Mobile Batching Plant</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Static Boom Placer'){ echo 'selected'; } ?> value="Static Boom Placer" class="cq_options5" id="concrete_equipment_option7">Static Boom Placer</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Transit Mixer'){ echo 'selected'; } ?> value="Transit Mixer" class="cq_options5" id="concrete_equipment_option8">Transit Mixer</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Baby Roller'){ echo 'selected'; } ?> value="Baby Roller" class="earthmover_options5" id="earthmovers_option1">Baby Roller</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Backhoe Loader'){ echo 'selected'; } ?> value="Backhoe Loader" class="earthmover_options5" id="earthmovers_option2">Backhoe Loader</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Bulldozer'){ echo 'selected'; } ?> value="Bulldozer" class="earthmover_options5" id="earthmovers_option3">Bulldozer</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Excavator'){ echo 'selected'; } ?> value="Excavator" class="earthmover_options5" id="earthmovers_option4">Excavator</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Milling Machine'){ echo 'selected'; } ?> value="Milling Machine" class="earthmover_options5" id="earthmovers_option5">Milling Machine</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Motor Grader'){ echo 'selected'; } ?> value="Motor Grader" class="earthmover_options5" id="earthmovers_option6">Motor Grader</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Pneumatic Tyre Roller'){ echo 'selected'; } ?> value="Pneumatic Tyre Roller" class="earthmover_options5" id="earthmovers_option7">Pneumatic Tyre Roller</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Single Drum Roller'){ echo 'selected'; } ?> value="Single Drum Roller" class="earthmover_options5" id="earthmovers_option8">Single Drum Roller</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Skid Loader'){ echo 'selected'; } ?> value="Skid Loader" class="earthmover_options5" id="earthmovers_option9">Skid Loader</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Slip Form Paver'){ echo 'selected'; } ?> value="Slip Form Paver" class="earthmover_options5" id="earthmovers_option10">Slip Form Paver</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Soil Compactor'){ echo 'selected'; } ?> value="Soil Compactor" class="earthmover_options5" id="earthmovers_option11">Soil Compactor</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Tandem Roller'){ echo 'selected'; } ?> value="Tandem Roller" class="earthmover_options5" id="earthmovers_option12">Tandem Roller</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Vibratory Roller'){ echo 'selected'; } ?> value="Vibratory Roller" class="earthmover_options5" id="earthmovers_option13">Vibratory Roller</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Wheeled Excavator'){ echo 'selected'; } ?> value="Wheeled Excavator" class="earthmover_options5" id="earthmovers_option14">Wheeled Excavator</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Wheeled Loader'){ echo 'selected'; } ?> value="Wheeled Loader" class="earthmover_options5" id="earthmovers_option15">Wheeled Loader</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Fixed Tower Crane'){ echo 'selected'; } ?> value="Fixed Tower Crane" class="mhe_options5" id="mhe_option1">Fixed Tower Crane</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Fork Lift Diesel'){ echo 'selected'; } ?> value="Fork Lift Diesel" class="mhe_options5" id="mhe_option2">Fork Lift Diesel</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Fork Lift Electric'){ echo 'selected'; } ?> value="Fork Lift Electric" class="mhe_options5" id="mhe_option3">Fork Lift Electric</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Hammerhead Tower Crane'){ echo 'selected'; } ?> value="Hammerhead Tower Crane" class="mhe_options5" id="mhe_option4">Hammerhead Tower Crane</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Hydraulic Crawler Crane'){ echo 'selected'; } ?> value="Hydraulic Crawler Crane" class="mhe_options5" id="mhe_option5">Hydraulic Crawler Crane</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Luffing Jib Tower Crane'){ echo 'selected'; } ?> value="Luffing Jib Tower Crane" class="mhe_options5" id="mhe_option6">Luffing Jib Tower Crane</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Mechanical Crawler Crane'){ echo 'selected'; } ?> value="Mechanical Crawler Crane" class="mhe_options5" id="mhe_option7">Mechanical Crawler Crane</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Pick and Carry Crane'){ echo 'selected'; } ?> value="Pick and Carry Crane" class="mhe_options5" id="mhe_option8">Pick and Carry Crane</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Reach Stacker'){ echo 'selected'; } ?> value="Reach Stacker" class="mhe_options5" id="mhe_option9">Reach Stacker</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Rough Terrain Crane'){ echo 'selected'; } ?> value="Rough Terrain Crane" class="mhe_options5" id="mhe_option10">Rough Terrain Crane</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Telehandler'){ echo 'selected'; } ?> value="Telehandler" class="mhe_options5" id="mhe_option11">Telehandler</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Telescopic Crawler Crane'){ echo 'selected'; } ?> value="Telescopic Crawler Crane" class="mhe_options5" id="mhe_option12">Telescopic Crawler Crane</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Telescopic Mobile Crane'){ echo 'selected'; } ?> value="Telescopic Mobile Crane" class="mhe_options5" id="mhe_option13">Telescopic Mobile Crane</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'All Terrain Mobile Crane'){ echo 'selected'; } ?> value="All Terrain Mobile Crane" class="mhe_options5" id="mhe_option14">All Terrain Mobile Crane</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Self Loading Truck Crane'){ echo 'selected'; } ?> value="Self Loading Truck Crane" class="mhe_options5" id="mhe_option15">Self Loading Truck Crane</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Hydraulic Drilling Rig'){ echo 'selected'; } ?> value="Hydraulic Drilling Rig" class="gee_options5" id="ground_engineering_equipment_option1">Hydraulic Drilling Rig</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Rotary Drilling Rig'){ echo 'selected'; } ?> value="Rotary Drilling Rig" class="gee_options5" id="ground_engineering_equipment_option2">Rotary Drilling Rig</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Vibro Hammer'){ echo 'selected'; } ?> value="Vibro Hammer" class="gee_options5" id="ground_engineering_equipment_option3">Vibro Hammer</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Dumper'){ echo 'selected'; } ?> value="Dumper" class="trailor_options5" id="trailor_option1">Dumper</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Truck'){ echo 'selected'; } ?> value="Truck" class="trailor_options5" id="trailor_option2">Truck</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Water Tanker'){ echo 'selected'; } ?> value="Water Tanker" class="trailor_options5" id="trailor_option3">Water Tanker</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Low Bed'){ echo 'selected'; } ?> value="Low Bed" class="trailor_options5" id="trailor_option4">Low Bed</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Semi Low Bed'){ echo 'selected'; } ?> value="Semi Low Bed" class="trailor_options5" id="trailor_option5">Semi Low Bed</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Flatbed'){ echo 'selected'; } ?> value="Flatbed" class="trailor_options5" id="trailor_option6">Flatbed</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Hydraulic Axle'){ echo 'selected'; } ?> value="Hydraulic Axle" class="trailor_options5" id="trailor_option7">Hydraulic Axle</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Silent Diesel Generator'){ echo 'selected'; } ?> value="Silent Diesel Generator" class="generator_options5" id="generator_option1">Silent Diesel Generator</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Mobile Light Tower'){ echo 'selected'; } ?> value="Mobile Light Tower" class="generator_options5" id="generator_option2">Mobile Light Tower</option>
<option <?php if(isset($row5['sub_type2']) && $row5['sub_type2'] === 'Diesel Generator'){ echo 'selected'; } ?> value="Diesel Generator" class="generator_options5" id="generator_option3">Diesel Generator</option>
        </select>

        </div>
    </div>
    <div class="outer02" id="">
        <div class="trial1">
            <input type="text" placeholder="" id="5thmake" name="newfleetmake5" class="input02">
            <label for="" class="placeholder2">Fleet Make</label>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" id="5thmodel" name="newfleetmodel5" class="input02">
            <label for="" class="placeholder2">Fleet Model</label>
        </div>

    </div>
    <div class="outer02" id="">
        <div class="trial1">
            <input type="text" placeholder="" id="5thcap" name="fleetcap5" class="input02">
            <label for="" class="placeholder2">Fleet Capacity</label>
        </div>
        <div class="trial1" id="newfleet_unit">
            <select name="unit2" id="5thunit" class="input02">
                <option value=""disabled selected>Unit</option>
                <option <?php if(isset($row5['cap_unit2']) && $row5['cap_unit2']==='Ton'){echo 'selected';} ?> value="Ton">Ton</option>
                <option <?php if(isset($row5['cap_unit2']) && $row5['cap_unit2']==='Kgs'){echo 'selected';} ?> value="Kgs">Kgs</option>
                <option <?php if(isset($row5['cap_unit2']) && $row5['cap_unit2']==='KnM'){echo 'selected';} ?> value="KnM">KnM</option>
                <option <?php if(isset($row5['cap_unit2']) && $row5['cap_unit2']==='Meter'){echo 'selected';} ?> value="Meter">Meter</option>
                <option <?php if(isset($row5['cap_unit2']) && $row5['cap_unit2']==='M³'){echo 'selected';} ?> value="M³">M³</option>
            </select>
        </div>
        <div class="trial1">
            <input type="number" id="5thyom" placeholder="" value="<?php echo isset($row5['yom2']) ? $row5['yom2'] : ''; ?>" name="newyom5" class="input02" min="1900" max="2099">
            <label for="" class="placeholder2">YOM</label>
        </div>
    </div>
    <div class="outer02" id="">
    <div class="trial1" >
            <input type="text" name="boomLength5" id="5thboom" value="<?php echo isset($row5['boom2']) ? $row5['boom2'] : ''; ?>" placeholder="" class=" input02" >
            <label class="placeholder2">Boom Length</label>
        </div>    
        <div class="trial1" >
            <input type="text" name="jibLength5"  id="5thjib" value="<?php echo isset($row5['jib2']) ? $row5['jib2'] : ''; ?>" placeholder="" class="input02 " >
            <label class="placeholder2">Jib Length</label>
        </div>
        <div class="trial1">
            <input type="text" name="luffingLength5" id="5thluffing" value="<?php echo isset($row5['luffing2']) ? $row5['luffing2'] : ''; ?>" placeholder="" class=" input02" >
            <label class="placeholder2">Luffing Length</label>
        </div>
    </div>

    </div>
        <div class="outer02">
        <div class="trial1">
            <input type="number" name="rental5" placeholder="" value="<?php echo isset($row5['rental_charges2']) ? $row5['rental_charges2'] : ''; ?>" class="input02">
            <label for="" class="placeholder2">Rental Charges </label>
        </div>
        <div class="trial1">
            <input type="number" name="mob05" value="<?php echo isset($row5['mob_charges2']) ? $row5['mob_charges2'] : ''; ?>"  placeholder="" class="input02">
            <label for="" class="placeholder2">Mob Charges </label>
        </div>
        <div class="trial1">
            <input type="number" name="demob05" placeholder="" value="<?php echo isset($row5['demob_charges2']) ? $row5['demob_charges2'] : ''; ?>" class="input02">
            <label for="" class="placeholder2">Demob Charges </label>
        </div>
        </div>
        <div class="outer02">
        <div class="trial1">
            <input type="text" name="equiplocation05" value="<?php echo isset($row5['crane_location2']) ? $row5['crane_location2'] : ''; ?>" placeholder="" class="input02">
            <label for="" class="placeholder2"> Equipment Location </label>
 
        </div>
        <div class="trial1">
            <input type="text" placeholder="" value="<?php echo isset($row5['fuel/hour2']) ? $row5['fuel/hour2'] : ''; ?>" name="fuelperltr5" id="fuel_fifth" class="input02">
            <label for="" class="placeholder2">Fuel/Hour</label>
        </div>

        <div class="trial1">
            <select name="adblue5" id="" class="input02">
                <option value=""disabled selected>Adblue?</option>
                <option <?php if(isset($row5['adblue2']) && $row5['adblue2']==='Yes'){echo 'selected';} ?> value="Yes">Yes</option>
                <option <?php if(isset($row5['adblue2']) && $row5['adblue2']==='No'){echo 'selected';} ?> value="No">No</option>
            </select>
        </div>
        </div>
        <!-- <div class="addbuttonicon" id="lastaddequipbtn"><i onclick="addanother_equip()"  class="bi bi-plus-circle"></i><p>Add Another Equipment</p></div> -->
        </div>

        <h5 class="fulllength">Sender Name Not In List ? <a href="quote_subuser.php">Add Team Members Here</a> </h5>
        <div class="outer02">
<div class="trial1">
    <input type="text" placeholder="" name="sender_name" value="<?php echo $row['sender_name'] ?>" class="input02">
    <label for="" class="placeholder2">Senders Name</label>
</div>
<div class="trial1">
    <input type="text" placeholder="" name="senders_designation" value="<?php echo $row['senders_designation'] ?>" class="input02">
    <label for="" class="placeholder2">Senders Designation</label>
</div>
    <div class="trial1">
        <input type="text" placeholder="" value="<?php echo $row['sender_number'] ?>" id="contact_person_number" name="contactnumbersender" class="input02">
        <label for="" class="placeholder2">Contact Number</label>
    </div>
    <div class="trial1">
        <input type="text" placeholder="" value="<?php echo $row['sender_contact'] ?>" id="contact_person_email" name="contactemailsender" class="input02">
        <label for="" class="placeholder2">Contact Email</label>
    </div>
<input type="text" id="logistics_need_rental" value="<?php echo $companyname001 ?>" hidden>
    </div>
<div class="fulllength" id="quotationnextback">
            <!-- <button class="epc-button">Next</button> -->
         <!-- Updated Button with the class "quotationnavigatebutton" -->
<button
  class="quotationnavigatebutton bg-white text-center w-30 rounded-lg h-10 relative text-black text-sm font-semibold group"
  type="button" onclick="backtocontactpersonsection()"
>
<div
    class="rounded-md h-8 w-1/4 flex items-center justify-center absolute left-1 top-[2px] group-hover:w-[110px] z-10 duration-300"
    style="background-color: #1C549E;" 
  >  
  
  <svg
      xmlns="http://www.w3.org/2000/svg"
      viewBox="0 0 1024 1024"
      height="18px"
      width="18px"
    >
      <path
        d="M224 480h640a32 32 0 1 1 0 64H224a32 32 0 0 1 0-64z"
        fill="white" 
      ></path>
      <path
        d="m237.248 512 265.408 265.344a32 32 0 0 1-45.312 45.312l-288-288a32 32 0 0 1 0-45.312l288-288a32 32 0 1 1 45.312 45.312L237.248 512z"
        fill="white" 
      ></path>
    </svg>
  </div>
  <p class="translate-x-1">Back</p>
</button>

<button
  class="quotationnavigatebutton bg-white text-center w-30 rounded-lg h-10 relative text-black text-sm font-semibold group"
  type="button" onclick="termssection()"
>
  <div
    class="bg-custom-blue rounded-md h-8 w-1/4 flex items-center justify-center absolute left-1 top-[2px] group-hover:w-[110px] z-10 duration-300"
    style="background-color: #1C549E;" 

  >
  <svg
      xmlns="http://www.w3.org/2000/svg"
      viewBox="0 0 1024 1024"
      height="18px"
      width="18px"
      transform="rotate(180)" 
    >
      <path
        d="M224 480h640a32 32 0 1 1 0 64H224a32 32 0 0 1 0-64z"
        fill="white" 
      ></path>
      <path
        d="m237.248 512 265.408 265.344a32 32 0 0 1-45.312 45.312l-288-288a32 32 0 0 1 0-45.312l288-288a32 32 0 1 1 45.312 45.312L237.248 512z"
        fill="white" 
      ></path>
    </svg>
  </div>
  <p class="translate-x-1" >Next</p>
</button>

</div>
<br>


    </div>

    <div id="termssectioncontainer">
    <p class="headingpara">Terms & Conditions: </p>
    <div class="terms_container012">
    <p class="heading_terms">Terms & Conditions :

</p>
<p class="terms_condition">
    <strong>1.Working Shift :</strong>Start time to be
    <select name="working_shift_start" id="">
    <option <?php if(isset($row['working_start']) && $row['working_start'] ==='6 AM'){ echo 'selected';} ?> value="6 AM">6 AM</option>
        <option <?php if(isset($row['working_start']) && $row['working_start'] ==='7 AM'){ echo 'selected';} ?> value="7 AM">7 AM</option>

        <option <?php if(isset($row['working_start']) && $row['working_start'] ==='8 AM'){ echo 'selected';} ?> value="8 AM" >8 AM</option>
        <option <?php if(isset($row['working_start']) && $row['working_start'] ==='9 AM'){ echo 'selected';} ?> value="9 AM">9 AM</option>
        <option <?php if(isset($row['working_start']) && $row['working_start'] ==='10 AM'){ echo 'selected';} ?> value="10 AM">10 AM</option>
    </select>
    end time to be
    <select name="working_shift_end" id="">
        <option <?php if(isset($row['working_end']) &&  $row['working_end']==='6'){ echo 'selected';} ?> value="6">6</option>
        <option <?php if(isset($row['working_end']) &&  $row['working_end']==='7'){ echo 'selected';} ?> value="7">7</option>
        <option <?php if(isset($row['working_end']) &&  $row['working_end']==='8'){ echo 'selected';} ?> value="8" default selected>8</option>
        <option <?php if(isset($row['working_end']) &&  $row['working_end']==='9'){ echo 'selected';} ?> value="9">9</option>
</select>
<select name="working_shift_end_unit" id="">
    <option <?php if(isset($row['working_end_unit']) && $row['working_end_unit']==='AM'){ echo 'selected';} ?> value="AM">AM</option>
    <option <?php if(isset($row['working_end_unit']) && $row['working_end_unit']==='PM'){ echo 'selected';} ?> value="PM">PM</option>
    
</select>
<select name="lunch_time" id="lunchbreak">
    <option <?php if(isset($row['food_break']) && $row['food_break']==='including food break in each shift'){ echo 'selected';} ?> value="including food break in each shift">including food break in each shift</option>
    <option <?php if(isset($row['food_break']) && $row['food_break']==='excluding food break in each shift'){ echo 'selected';} ?> value="excluding food break in each shift">excluding food break in each shift</option>
</select>


</p>
<p class="terms_condition">
    <strong>2.Breakdown :</strong> 
    <select name="breakdown_select" id="breakdown_select">
        <option <?php if(isset($row['brkdown']) && $row['brkdown']==='Free time - not applicable'){ echo 'selected';} ?> value="Free time - not applicable">Free time - not applicable</option>
        <option <?php if(isset($row['brkdown']) && $row['brkdown']==='Free time - first 6 hours'){ echo 'selected';} ?> value="Free time - first 6 hours" default selected>Free time - first 6 hours</option>
        <option <?php if(isset($row['brkdown']) && $row['brkdown']==='Free time - first 12 hours'){ echo 'selected';} ?> value="Free time - first 12 hours">Free time - first 12 hours</option>
    </select> 
    After free time, breakdown charges to be deducted on pro-rata basis
</p>
<p class="terms_condition" >
    <strong>3.Operating Crew :</strong> 
    <select name="operating_crew_select" id="operating_crew_select">
        <option <?php if(isset($row['crew']) && $row['crew']==='Single Operator'){ echo 'selected';} ?> value="Single Operator">Single Operator</option>
        <option <?php if(isset($row['crew']) && $row['crew']==='Double Operator'){ echo 'selected';} ?> value="Double Operator">Double Operator</option>
        <option <?php if(isset($row['crew']) && $row['crew']==='Single Operator + Helper'){ echo 'selected';} ?> value="Single Operator + Helper">Single Operator + Helper</option>
        <option <?php if(isset($row['crew']) && $row['crew']==='Double Operator + Helper'){ echo 'selected';} ?> value="Double Operator + Helper">Double Operator + Helper</option>
    </select>
    &nbsp
    <strong>4.Operator Room Scope :</strong> 
    <select name="operator_room_scope_select" id="operator_room_scope_select">
        <option <?php if(isset($row['room']) && $row['room']==='Not Applicable'){ echo 'selected';} ?> value="Not Applicable">Not Applicable</option>
        <option <?php if(isset($row['room']) && $row['room']==='In Client Scope'){ echo 'selected';} ?> value="In Client Scope" default selected>In Client Scope</option>
        <option <?php if(isset($row['room']) && $row['room']==='In Rental Company Scope'){ echo 'selected';} ?> value="In Rental Company Scope">In Rental Co Scope</option>
    </select>

</p>
<p class="terms_condition">
</p>
<p class="terms_condition">
    <strong>5.Crew Food Scope :</strong>  
    <select name="crew_food_scope_select" id="crew_food_scope_select">
        <option <?php if(isset($row['food']) && $row['food']==='Not Applicable'){ echo 'selected';} ?> value="Not Applicable">Not Applicable</option>
        <option <?php if(isset($row['food']) && $row['food']==='In Client Scope'){ echo 'selected';} ?> value="In Client Scope">In Client Scope</option>
        <option <?php if(isset($row['food']) && $row['food']==='In Rental Company Scope'){ echo 'selected';} ?> value="In Rental Company Scope">In Rental Company Scope</option>
    </select>
    &nbsp
    <strong>6.Crew Travelling :</strong>  
    <select name="crew_travelling_select" id="crew_travelling_select">
        <option <?php if(isset($row['travel']) && $row['travel']==='Not Applicable'){ echo 'selected';} ?> value="Not Applicable">Not Applicable</option>
        <option <?php if(isset($row['travel']) && $row['travel']==='In Client Scope'){ echo 'selected';} ?>  value="In Client Scope">In Client Scope</option>
        <option <?php if(isset($row['travel']) && $row['travel']==='In Rental Company Scope'){ echo 'selected';} ?> value="In Rental Company Scope">In Rental Co Scope</option>
    </select>

</p>
<p class="terms_condition">
</p>
<p class="terms_condition">
    <strong>7.Fuel :</strong>Fuel shall be issued as per OEM norms by 
    <select name="fuel_scope" id="">
        <option <?php if(isset($row['fuel_scope']) && $row['fuel_scope']==='Client'){ echo 'selected';} ?> value="Client" >Client </option>
        <option <?php if(isset($row['fuel_scope']) && $row['fuel_scope']==='Rental Company'){ echo 'selected';} ?> value="Rental Company">Rental Company</option>
    </select>
</p>
<p class="terms_condition"><strong>8.Adblue :</strong>Adblue if required to be provided by
<select name="adblue_scope" id="">
<option <?php if(isset($row['adblue_scope']) && $row['adblue_scope']==='Not applicable'){ echo 'selected';} ?> value="Not applicable">Not Applicable</option>

        <option <?php if(isset($row['adblue_scope']) && $row['adblue_scope']==='Client'){ echo 'selected';} ?> value="Client">Client </option>
        <option <?php if(isset($row['adblue_scope']) && $row['adblue_scope']==='Rental Company'){ echo 'selected';} ?> value="Rental Company">Rental Company</option>
    </select>

</p>
<p class="terms_condition">
    <strong>9.Contract Period :</strong> Minimum Order Shall Be 
    <select name="contract_period_select" id="contract_period_select">
        <option <?php if(isset($row['period_contract']) && $row['period_contract']==='1 Month'){ echo 'selected';} ?> value="1 Month">1 Month</option>
        <option <?php if(isset($row['period_contract']) && $row['period_contract']==='2 Month'){ echo 'selected';} ?> value="2 Month">2 Months</option>
        <option <?php if(isset($row['period_contract']) && $row['period_contract']==='3 Month'){ echo 'selected';} ?> value="3 Month">3 Months</option>
        <option <?php if(isset($row['period_contract']) && $row['period_contract']==='6 Month'){ echo 'selected';} ?> value="6 Month">6 Months</option>
        <option <?php if(isset($row['period_contract']) && $row['period_contract']==='7 Month'){ echo 'selected';} ?> value="7 Month">7 Months</option>
        <option <?php if(isset($row['period_contract']) && $row['period_contract']==='9 Month'){ echo 'selected';} ?> value="9 Month">9 Months</option>
        <option <?php if(isset($row['period_contract']) && $row['period_contract']==='10 Month'){ echo 'selected';} ?> value="10 Month">10 Months</option>
        <option <?php if(isset($row['period_contract']) && $row['period_contract']==='12 Month'){ echo 'selected';} ?> value="12 Month">12 Months</option>
        <option <?php if(isset($row['period_contract']) && $row['period_contract']==='15 Month'){ echo 'selected';} ?> value="15 Month">15 Months</option>
        <option <?php if(isset($row['period_contract']) && $row['period_contract']==='18 Month'){ echo 'selected';} ?> value="18 Month">18 Months</option>
        <option <?php if(isset($row['period_contract']) && $row['period_contract']==='24 Month'){ echo 'selected';} ?> value="24 Month">24 Months</option>
    </select>
</p>

<p class="terms_condition" id="roadtaxselectcontainer">
    <strong>10. Working State Road Tax :</strong>if applicable road tax to be in scope of <select name="road_tax" id="roadtaxselect" onchange="roadtax_criteria()">
        <option <?php if(isset($row['road_tax']) && $row['road_tax']==='not applicable'){ echo 'selected';} ?> value="not applicable">not applicable</option>
        <option <?php if(isset($row['road_tax']) && $row['road_tax']==='client'){ echo 'selected';} ?> value="client">client</option>
        <option <?php if(isset($row['road_tax']) && $row['road_tax']==='rental company'){ echo 'selected';} ?> value="rental company">rental company</option>
    </select>

    <select name="roadtax_condition" id="roadtaxcondition" onchange="lumsum_amount()">
        <option value="as per recipt">as per recipt</option>
        <option value="lumsum amount">lumsum amount</option>
    </select>
    <input type="text" id="enterlumsumamount" name="lumsumamount" placeholder="Enter amount">
</p>

<p class="terms_condition"><strong>11.Dehire Clause :</strong>  Dehire notice must be provided with a minimum 
<select name="dehire" id="">
    <option <?php if(isset($row['dehire_clause']) && $row['dehire_clause']==='7 Days'){ echo 'selected';} ?> value="7 Days" >7 Days</option>
    <option <?php if(isset($row['dehire_clause']) && $row['dehire_clause']==='15 Days'){ echo 'selected';} ?> value="15 Days" default selected>15 Days</option>
    <option <?php if(isset($row['dehire_clause']) && $row['dehire_clause']==='30 Days'){ echo 'selected';} ?> value="30 Days">30 Days</option>
</select> notice.</p>
<p class="terms_condition">
    <strong>12.Payment Terms :</strong> 
    <select name="payment_terms_select" id="payment_terms_select">
        <option <?php if(isset($row['pay_terms']) && $row['pay_terms']==='within 7 days Of invoice submission'){ echo 'selected';} ?> value="within 7 days Of invoice submission">within 7 Days Of invoice submission</option>
        <option <?php if(isset($row['pay_terms']) && $row['pay_terms']==='within 10 days Of invoice submission'){ echo 'selected';} ?> value="within 10 days Of invoice submission">within 10 Days Of invoice submission</option>
        <option <?php if(isset($row['pay_terms']) && $row['pay_terms']==='within 30 days Of invoice submission'){ echo 'selected';} ?> value="within 30 days Of invoice submission" default selected>within 30 Days Of invoice submission</option>
        <option <?php if(isset($row['pay_terms']) && $row['pay_terms']==='within 45 days Of invoice submission'){ echo 'selected';} ?> value="within 45 days Of invoice submission">within 45 Days Of invoice submission</option>
    </select>
</p>


<p class="terms_condition">
    <strong>13.Advance Payment :</strong> 
    <select name="advance_payment_select" id="advance_payment_select">
        <option <?php if(isset($row['adv_pay']) && $row['adv_pay']==='Not applicable'){ echo 'selected';} ?> value="Not applicable">Not Applicable</option>
        <option <?php if(isset($row['adv_pay']) && $row['adv_pay']==='applicable - mob charges'){ echo 'selected';} ?> value="applicable - mob charges" default selected>applicable - mob charges</option>
        <option <?php if(isset($row['adv_pay']) && $row['adv_pay']==='applicable - mob + rental charges'){ echo 'selected';} ?> value="applicable - mob + rental charges">applicable - mob + rental charges</option>
        <option <?php if(isset($row['adv_pay']) && $row['adv_pay']==='applicable - mob + rental charges + demob charges'){ echo 'selected';} ?> value="applicable - mob + rental charges + demob charges">applicable - mob + rental charges + demob charges</option>
    </select>
</p>










<p class="terms_condition">
    <strong>14.Supporting Equipment :</strong> 
    <select name="equipment_assembly_select" id="equipment_assembly_select">
        <option <?php if(isset($row['equipment_assembly']) && $row['equipment_assembly']==='Not Applicable'){ echo 'selected';} ?> value="Not Applicable">Not Applicable</option>
        <option <?php if(isset($row['equipment_assembly']) && $row['equipment_assembly']==='Assembly + Dismentling'){ echo 'selected';} ?> value="Assembly + Dismentling"> Assembly + Dismentling </option>
        <option <?php if(isset($row['equipment_assembly']) && $row['equipment_assembly']==='Unloading + Assembly + Dismentling + Loading'){ echo 'selected';} ?> value="Unloading + Assembly + Dismentling + Loading">Unloading + Assembly + Dismentling + Loading</option>
        <option <?php if(isset($row['equipment_assembly']) && $row['equipment_assembly']==='Unloading & Loading'){ echo 'selected';} ?> value="Unloading & Loading">Unloading & Loading</option>
    </select>
</p>

<p class="terms_condition">
    <strong>15.TPI Scope :</strong> 
    <select name="tpi_scope_select" id="tpi_scope_select">
        <option <?php if(isset($row['tpi']) && $row['tpi']==='Not Required'){ echo 'selected';} ?> value="Not Required">Not Required</option>
        <option <?php if(isset($row['tpi']) && $row['tpi']==='In Client Scope'){ echo 'selected';} ?> value="In Client Scope">In Client Scope</option>
        <option <?php if(isset($row['tpi']) && $row['tpi']==='In Rental Company'){ echo 'selected';} ?> value="In Rental Company" >In Rental Company</option>
    </select>
</p>

<p class="terms_condition">
    <strong>16.Safety And Security :</strong> 
    <select name="safety_security_select" id="safety_security_select">
        <option <?php if(isset($row['safety']) && $row['safety']==='Not Required'){ echo 'selected';} ?> value="Not Required">Not Required</option>
        <option <?php if(isset($row['safety']) && $row['safety']==='In Client Scope'){ echo 'selected';}  ?> value="In Client Scope" default selected>In Client Scope</option>
        <option <?php if(isset($row['safety']) && $row['safety']==='In Rental Company'){ echo 'selected';}?> value="In Rental Company">In Rental Company</option>
    </select>
</p>




<p class="terms_condition">
    <strong>17.GST :</strong>Applicable. Extra payable at actual invoice value at
    <select name="gst" id="">
        <option <?php if(isset($row['gst']) && $row['gst']==='18%'){ echo 'selected';}?> value="18%" >18%</option>
        <option <?php if(isset($row['gst']) && $row['gst']==='28%'){ echo 'selected';}?> value="28%">28%</option>
        <option <?php if(isset($row['gst']) && $row['gst']==='12%'){ echo 'selected';}?> value="12%">12%</option>
        <option <?php if(isset($row['gst']) && $row['gst']==='5%'){ echo 'selected';}?> value="5%">5%</option>
    </select>
<!-- <textarea name="gst" id="" cols="30" rows="1" class="terms_textarea"> Applicable. Extra payable at actual invoice value at 18%.</textarea> -->
</p>
<p class="terms_condition"><strong>18.PPE Kit :</strong>If Required To Be Provided 
<select name="PPE" id="">
<option <?php if(isset($row['ppe_kit']) && $row['ppe_kit']==='In Client Scope FOC Basis'){ echo 'selected';}?> value="In Client Scope FOC Basis">In Client Scope FOC Basis</option>
<option <?php if(isset($row['ppe_kit']) && $row['ppe_kit']==='In Rental Company Scope'){ echo 'selected';}?> value="In Rental Company Scope">In Rental Company Scope</option>
<option <?php if(isset($row['ppe_kit']) && $row['ppe_kit']==='In Client Scope At Recoverable Basis'){ echo 'selected';}?> value="In Client Scope At Recoverable Basis">In Client Scope At Recoverable Basis</option>
</select>
</p>


<p class="terms_condition">
    <strong>19.Over time payment :</strong>Applicable. OT charges at <select name="ot_payment" id=""><option value="100%" default selected>100%</option>
    <option <?php if(isset($row['ot_pay']) && $row['ot_pay']==='90%'){ echo 'selected';}?> value="90%">90%</option>
    <option <?php if(isset($row['ot_pay']) && $row['ot_pay']==='80%'){ echo 'selected';}?> value="80%">80%</option>
    <option <?php if(isset($row['ot_pay']) && $row['ot_pay']==='70%'){ echo 'selected';}?> value="70%">70%</option>
    <option <?php if(isset($row['ot_pay']) && $row['ot_pay']==='60%'){ echo 'selected';}?> value="60%">60%</option>
    <option <?php if(isset($row['ot_pay']) && $row['ot_pay']==='50%'){ echo 'selected';}?> value="50%">50%</option></select>pro-rata basis payable if equipment has worked beyond stipulated work shift, engine hours and on Sundays,National holidays
<!-- <textarea name="ot_payment" id="" cols="30" rows="2" class="terms_textarea"> Applicable. OT charges at 100% pro-rata basis payable if equipment has worked beyond stipulated work shift, engine hours and on Sundays,National holidays</textarea> -->
</p>





<p class="terms_condition">
    <strong>20.Tools & Tackles :</strong>Related Tools And Tackles , To Be Provided <select name="tools_tackels" id="">
        <option <?php if(isset($row['tools']) && $row['tools']==='In Client Scope'){ echo 'selected';}?> value="In Client Scope">In Client Scope</option>
        <option <?php if(isset($row['tools']) && $row['tools']==='In Rental Company Scope'){ echo 'selected';}?> value="In Rental Company Scope">In Rental Company Scope</option>
    </select>
<!-- <textarea name="tools_tackels" id="" cols="30" rows="2" class="terms_textarea"> Related Tools And Tackles , Required Safety PPE Kit And Gears To Be Provided By Client On FOC basis.</textarea> -->
</p>

<p class="terms_condition">
    <strong>21.Internal Shifting :</strong><select name="internal_shifting" id="">
        <option <?php if(isset($row['internal_shifting']) && $row['internal_shifting']==='not applicable'){ echo 'selected';}?> value="not applicable">not applicable</option>
        <option <?php if(isset($row['internal_shifting']) && $row['internal_shifting']==='In Client Scope'){ echo 'selected';}?> value="In Client Scope" default selected>In Client Scope</option>
        <option <?php if(isset($row['internal_shifting']) && $row['internal_shifting']==='In Rental Company Scope'){ echo 'selected';}?> value="In Rental Company Scope">In Rental Company Scope</option>
    </select>
</p>
<p class="terms_condition">
    <strong>22.Notice To Mobilise :</strong> Minimum <select name="mobilisation_notice" id="">
        <option <?php if(isset($row['mobilisation_notice']) && $row['mobilisation_notice']==='3 days'){ echo 'selected';}?> value="3 days">3 days</option>
        <option <?php if(isset($row['mobilisation_notice']) && $row['mobilisation_notice']==='5 days'){ echo 'selected';}?> value="5 days">5 days</option>
        <option <?php if(isset($row['mobilisation_notice']) && $row['mobilisation_notice']==='7 days'){ echo 'selected';}?> value="7 days">7 days</option>
        <option <?php if(isset($row['mobilisation_notice']) && $row['mobilisation_notice']==='15 days'){ echo 'selected';}?> value="15 days">15 days</option>
    </select> notice reqired in mobilising equipment from our end
</p>

<p class="terms_condition">
    <strong>23.Delay payment clause :</strong>
<textarea name="delay_pay" id="" cols="30" rows="2" class="terms_textarea" readonly> In case, the payment credit terms are not honoured, we reserve the right to hault the machine operators, and our rental charges shall be in force. Additionally, an interest of 18% PA to be charges on outstanding amount.</textarea>
</p>

<p class="terms_condition">
    <strong>24.Force Majeure clause :</strong>
<textarea name="force_clause" id="" cols="30" rows="2" class="terms_textarea" readonly> If the equipment deployment gets delayed due to transit delays, plants related gate pass, loading at client site, forces of nature and reasons beyond our control, no penalty shall be levied on us.</textarea>
</p>
<p class="terms_condition"> <strong>25.Quote Validity :</strong>Provided Quotation Rates Will Remain Valid For A Period Of 
<select name="quote_valid" id="">
    <option <?php if(isset($row['quote_validity']) && $row['quote_validity']==='3 days'){ echo 'selected';}?> value="3 days">3 Days</option>
    <option <?php if(isset($row['quote_validity']) && $row['quote_validity']==='7 days'){ echo 'selected';}?> value="7 days" default selected>7 Days</option>
    <option <?php if(isset($row['quote_validity']) && $row['quote_validity']==='10 days'){ echo 'selected';}?> value="10 days">10 Days</option>
    <option <?php if(isset($row['quote_validity']) && $row['quote_validity']==='15 days'){ echo 'selected';}?> value="15 days">15 Days</option>
    <option <?php if(isset($row['quote_validity']) && $row['quote_validity']==='30 days'){ echo 'selected';}?> value="30 days">30 Days</option>
</select></p>
<p class="terms_condition"><textarea id="custom_terms_textarea" name="custom" cols="30" rows="5" class="terms_textarea" id=""> <?php echo $row['custom_terms'] ?> </textarea></p>


    </div>
    <div class="fulllength" id="quotationnextback">
            <!-- <button class="epc-button">Next</button> -->
         <!-- Updated Button with the class "quotationnavigatebutton" -->
<button
  class="quotationnavigatebutton bg-white text-center w-30 rounded-lg h-10 relative text-black text-sm font-semibold group"
  type="button" onclick="backtoequipementsection()"
>
<div
    class="rounded-md h-8 w-1/4 flex items-center justify-center absolute left-1 top-[2px] group-hover:w-[110px] z-10 duration-300"
    style="background-color: #1C549E;" 
  >  
  
  <svg
      xmlns="http://www.w3.org/2000/svg"
      viewBox="0 0 1024 1024"
      height="18px"
      width="18px"
    >
      <path
        d="M224 480h640a32 32 0 1 1 0 64H224a32 32 0 0 1 0-64z"
        fill="white" 
      ></path>
      <path
        d="m237.248 512 265.408 265.344a32 32 0 0 1-45.312 45.312l-288-288a32 32 0 0 1 0-45.312l288-288a32 32 0 1 1 45.312 45.312L237.248 512z"
        fill="white" 
      ></path>
    </svg>
  </div>
  <p class="translate-x-1">Back</p>
</button>

<button
  class="quotationnavigatebutton bg-white text-center w-30 rounded-lg h-10 relative text-black text-sm font-semibold group"
  type="submit" onclick="termssection()"
>
  <div
    class="bg-custom-blue rounded-md h-8 w-1/4 flex items-center justify-center absolute left-1 top-[2px] group-hover:w-[110px] z-10 duration-300"
    style="background-color: #1C549E;" 

  >
  <svg
      xmlns="http://www.w3.org/2000/svg"
      viewBox="0 0 1024 1024"
      height="18px"
      width="18px"
      transform="rotate(180)" 
    >
      <path
        d="M224 480h640a32 32 0 1 1 0 64H224a32 32 0 0 1 0-64z"
        fill="white" 
      ></path>
      <path
        d="m237.248 512 265.408 265.344a32 32 0 0 1-45.312 45.312l-288-288a32 32 0 0 1 0-45.312l288-288a32 32 0 1 1 45.312 45.312L237.248 512z"
        fill="white" 
      ></path>
    </svg>
  </div>
  <p class="translate-x-1" >Submit</p>
</button>

</div>
<br>




<!-- <button class="quotation_submit" type="submit">SUBMIT</button> -->
<br><br>

    </div>
    </div>
</form>

</body>
<script>
    function fourth_quotation(){
    const fouthvehicledata=document.getElementById("fouthvehicledata");
    const fourth_addequipbtn=document.getElementById("fourth_addequipbtn");
    fouthvehicledata.style.display="flex";
    fourth_addequipbtn.style.display="none";

}

function fifth_quotation(){
    const fifthvehicledata=document.getElementById("fifthvehicledata");
    const fifth_addequipbtn=document.getElementById("fifth_addequipbtn");
    fifthvehicledata.style.display="flex";
    fifth_addequipbtn.style.display="none";

}

document.addEventListener('DOMContentLoaded', function() {
    // Check if oem_fleet_type7 is not empty and call seco_equip_2()
    var select_shift = document.getElementById('select_shift');
    if (select_shift.value !== '') {
        shift_hour();
    }
});

function not_immediate(){
 const availability_dd=document.getElementById("availability_dd");
 const date_of_availability=document.getElementById("date_of_availability");
 if(availability_dd.value==="Not Immediate"){
    date_of_availability.style.display="block";
 }
 else{
    date_of_availability.style.display="none";
 }
}


document.addEventListener('DOMContentLoaded', function() {
    // Check if oem_fleet_type7 is not empty and call seco_equip_2()
    var availability_dd = document.getElementById('availability_dd');
    if (availability_dd.value !== '') {
        not_immediate();
    }
});


document.addEventListener('DOMContentLoaded', function() {
    // Check if oem_fleet_type7 is not empty and call seco_equip_2()
    var oem_fleet_type = document.getElementById('oem_fleet_type');
    if (oem_fleet_type.value !== '') {
        purchase_option();
    }
});

document.addEventListener('DOMContentLoaded', function() {
    // Check if oem_fleet_type7 is not empty and call seco_equip_2()
    var choose_Ac2 = document.getElementById('choose_Ac2');
    if (choose_Ac2.value !== '') {
        other_quotation();
    }
});


document.addEventListener('DOMContentLoaded', function() {
    // Check if oem_fleet_type7 is not empty and call seco_equip_2()
    var availability_dd2 = document.getElementById('availability_dd2');
    if (availability_dd2.value !== '') {
        not_immediate2();
    }
});

document.addEventListener('DOMContentLoaded', function() {
    // Check if oem_fleet_type7 is not empty and call seco_equip_2()
    var choose_Ac3 = document.getElementById('choose_Ac3');
    if (choose_Ac3.value !== '') {
        third_vehicle();
    }
});

document.addEventListener('DOMContentLoaded', function() {
    // Check if oem_fleet_type7 is not empty and call seco_equip_2()
    var availability_dd3 = document.getElementById('availability_dd3');
    if (availability_dd3.value !== '') {
        not_immediate3();
    }
});

document.addEventListener('DOMContentLoaded', function() {
    // Check if oem_fleet_type7 is not empty and call seco_equip_2()
    var choose_Ac4 = document.getElementById('choose_Ac4');
    if (choose_Ac4.value !== '') {
        fourth_quotation();
    }
});

document.addEventListener('DOMContentLoaded', function() {
    // Check if oem_fleet_type7 is not empty and call seco_equip_2()
    var choose_Ac5 = document.getElementById('choose_Ac5');
    if (choose_Ac5.value !== '') {
        fifth_quotation();
    }
});

document.addEventListener('DOMContentLoaded', function() {
    // Check if oem_fleet_type7 is not empty and call seco_equip_2()
    var availability_dd5 = document.getElementById('availability_dd5');
    if (availability_dd5.value !== '') {
        not_immediate5();
    }
});

document.addEventListener('DOMContentLoaded', function() {
    // Check if oem_fleet_type7 is not empty and call seco_equip_2()
    var availability_dd4 = document.getElementById('availability_dd4');
    if (availability_dd4.value !== '') {
        not_immediate4();
    }
});





</script>
</html>