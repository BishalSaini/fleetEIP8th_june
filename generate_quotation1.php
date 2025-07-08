<!-- // generate quotation file -->

<!-- // change by akash -->
 <!-- this is the final test --> 
   <!-- this is the final test2 -->

<?php
include_once 'partials/_dbconnect.php';

$showAlert = false;
$showError = false;
$showAlertuser=false;
$uniqueId = uniqid();


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

// $asset_code_selection = "SELECT * FROM `fleet1` WHERE `companyname`='$companyname001'";
// $result_asset_code = mysqli_query($conn, $asset_code_selection);

// $asset_code_selection1 = "SELECT * FROM `fleet1` WHERE `companyname`='$companyname001' ORDER BY assetcode ASC";
// $result_asset_code1 = mysqli_query($conn, $asset_code_selection1);

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



$sql_max_ref_no = "SELECT MAX(ref_no) AS max_ref_no FROM `quotation_generated` WHERE company_name = '$companyname001'";
$result_max_ref_no = mysqli_query($conn, $sql_max_ref_no);
$row_max_ref_no = mysqli_fetch_assoc($result_max_ref_no);
$next_ref_no = ($row_max_ref_no['max_ref_no'] === null) ? 1 : $row_max_ref_no['max_ref_no'] + 1;

$sql_custom="SELECT * FROM `quotation_generated` WHERE company_name='$companyname001' ORDER BY sno DESC LIMIT 1";
$result_custom=mysqli_query($conn,$sql_custom);
$row_custom=mysqli_fetch_assoc($result_custom);

$sql_client = "SELECT DISTINCT clientname FROM rentalclients WHERE `companyname` = '$companyname001' order by clientname asc";
$result_client=mysqli_query($conn,$sql_client);

$clientname='';
$contactpersonname='default value';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $quote_date = $_POST['quotation_date'];
    $to_name = $_POST['to'];
    $newrentalclient = $_POST['newrentalclient'];
    $to_address = $_POST['to_address'];
    $contact_person_name = $_POST['contact_person'];
    $newrentalcontactperson = $_POST['newrentalcontactperson'];
    if(isset($_POST['contact_person']) && ($_POST['contact_person'])!='New Contact Person'){
        $contactpersonname=$_POST['contact_person'];
    }
    else if (isset($_POST['newrentalcontactperson']) && !empty($_POST['newrentalcontactperson'])) {
        $contactpersonname = $_POST['newrentalcontactperson'];
    }


    if(isset($_POST['to']) && ($_POST['to'])!='New Client'){
        $clientname=$_POST['to'];
    }
    else if(isset($_POST['newrentalclient']) && !empty($_POST['newrentalclient'])){
        $clientname=$_POST['newrentalclient'];
        $contactpersonname = $_POST['newrentalcontactperson'];


    }

    




    $contact_peson_cell = $_POST['contact_number'];
    $email_id = $_POST['email_id'];
    $site_location = $_POST['site_location'];
    $sender_office_address=$_POST['sender_office_address'];
    $asset_code = $_POST['asset_code'];
   
    $sql_equip_specs="SELECT * FROM `fleet1` where assetcode='$asset_code' and companyname='$companyname001'";
    $result_spec=mysqli_query($conn,$sql_equip_specs);
    $row_specs=mysqli_fetch_assoc($result_spec);


    $availability = $_POST['availability'];
    $hours_duration = $_POST['hours_duration'];
    $days_duration = $_POST['days_duration'];
    $condition = $_POST['condition'];
    $rental_charges = $_POST['rental_charges'];
    $mob_charges = $_POST['mob_charges'];
    $demob_charges = $_POST['demob_charges'];
    $location = $_POST['location'];
    $adblue = $_POST['adblue'];
    $sender = $_POST['sender'];

    $senderdetail="SELECT * FROM `team_members` where `name`='$sender' and company_name='$companyname001'";
    $resultsenderdetail=mysqli_query($conn,$senderdetail);
    $senderdetailrow=mysqli_fetch_assoc($resultsenderdetail);

    $fleet_category = !empty($_POST['fleet_category']) ? $_POST['fleet_category'] : "null";
    $type = !empty($_POST['type']) ? $_POST['type'] : "null";    
    $new_fleet_cap=$_POST['new_fleet_cap'];
    $yom_new_fleet=$_POST['yom_new_fleet'];
    $newfleet_cap = isset($_POST['newfleet_cap']) && !empty($_POST['newfleet_cap']) ? $_POST['newfleet_cap'] : "null";
    $boomLength=$_POST['boomLength'];
    $jibLength=$_POST['jibLength'];
    $luffingLength=$_POST['luffingLength'];
    $newfleetmake=$_POST['newfleetmake'];
    $newfleetmodel=$_POST['newfleetmodel'];
    $fuel = $_POST['fuel_per_hour'];
    $tentative = isset($_POST['tentative_date']) ? $_POST['tentative_date'] : null;
    $shiftinfo=$_POST['shiftinfo'];
    $engine_hour = !empty($_POST['engine_hour']) ? $_POST['engine_hour'] : null;
    $custom=$_POST['custom'];
    if ($custom === "24 .Custom Terms And Condition To Be Written Here If Any") {
        $custom = null; // Set $custom to null
    }
    $contactnumbersender=$_POST['contactnumbersender'];
    $contactemailsender=$_POST['contactemailsender'];
    $internal_shifting=$_POST['internal_shifting'];
    $mobilisation_notice=$_POST['mobilisation_notice'];





    $cap_equip=$_POST['capacity_equip'];
    $yom_equip=$_POST['yom_equip'];
    $jib_equip=$_POST['jib_equip'];
    $boom_equip=$_POST['boom_equip'];
    $luffing_equip=$_POST['luffing_equip'];

    $period=$_POST['contract_period_select'];
    $uniqueidname=$_POST['uniqueidname'];
    $adv_pay=$_POST['advance_payment_select'];
    $crew=$_POST['operating_crew_select'];
    $room=$_POST['operator_room_scope_select'];
    $food=$_POST['crew_food_scope_select'];
    $travel=$_POST['crew_travelling_select'];
    $brkdown=$_POST['breakdown_select'];
    $ot_payment=$_POST['ot_payment'];
    $payment_terms_select=$_POST['payment_terms_select'];
    $delay_pay=$_POST['delay_pay'];
    $assembly=$_POST['equipment_assembly_select'];
    $tpi=$_POST['tpi_scope_select'];
    $safety_security=$_POST['safety_security_select'];
    $tools_tackels=$_POST['tools_tackels'];
    $gst=$_POST['gst'];
    $force_clause=$_POST['force_clause'];
    $ppe=$_POST['PPE'];
    $quote_valid=$_POST['quote_valid'];
    $dehire=$_POST['dehire'];
    $lunch_time=$_POST['lunch_time'];

$asset_code1 = isset($_POST['asset_code1']) ? $_POST['asset_code1'] : null;
$sql_equip_specs1="SELECT * FROM `fleet1` where assetcode='$asset_code1' and companyname='$companyname001'";
$result_spec1=mysqli_query($conn,$sql_equip_specs1);
$row_specs1=mysqli_fetch_assoc($result_spec1);




$avail1 = isset($_POST['avail1']) ? $_POST['avail1'] : null;
$fleet_category1 = isset($_POST['fleet_category1']) ? $_POST['fleet_category1'] : null;
$type1 = isset($_POST['type1']) ? $_POST['type1'] : null;
$newfleetmake1=$_POST['newfleetmake1'];
$newfleetmodel1=$_POST['newfleetmodel1'];
$fleetcap2=$_POST['fleetcap2'];
$unit2 = isset($_POST['unit2']) ? $_POST['unit2'] : null;
$yom2=$_POST['yom2'];
$boomLength2=$_POST['boomLength2'];
$jibLength2=$_POST['jibLength2'];
$luffingLength2=$_POST['luffingLength2'];
$date_ = isset($_POST['date_']) ? $_POST['date_'] : null;
$rental2=$_POST['rental2'];
$mob02=$_POST['mob02'];
$demob02=$_POST['demob02'];
$equiplocation02=$_POST['equiplocation02'];
$adblue2 = isset($_POST['adblue2']) ? $_POST['adblue2'] : null;
$fuelperltr2=$_POST['fuelperltr2'];
$salutation_dd=$_POST['salutation_dd'];
$adblue_scope=$_POST['adblue_scope'];
$fuel_scope=$_POST['fuel_scope'];
$working_shift_start=$_POST['working_shift_start'];
$working_shift_end=$_POST['working_shift_end'];
$working_shift_end_unit=$_POST['working_shift_end_unit'];
$road_tax=$_POST['road_tax'];


$yom_second_equipment_new=$_POST['yom_equip_second'];
$cap_second_equipment_new=$_POST['capacity_equip_second'];
$boom_second_equipment_new=$_POST['boom_equip_second'];
$jib_second_equipment_new=$_POST['jib_equip_second'];
$luffing_second_equipment=$_POST['luffing_equip_second'];


$asset_code3=$_POST['asset_code3'];
if(isset($asset_code3) && $asset_code3!='New Equipment'){
    $thirdvehicle="SELECT * FROM `fleet1` where assetcode='$asset_code3' and companyname='$companyname001'";
    $thirdvehicleresult=mysqli_query($conn,$thirdvehicle);
    $thirdrow=mysqli_fetch_assoc($thirdvehicleresult);
}

$avail3=$_POST['avail3'];
$date3=$_POST['date3'];
$yom3=$_POST['yom3'];
$capacity3=$_POST['capacity3'];
$boom3=$_POST['boom3'];
$jib3=$_POST['jib3'];
$luffing3=$_POST['luffing3'];
$fleet_category3 = $_POST['fleet_category3'] ?? '';
$type3 = $_POST['type3'] ?? '';
$newfleetmake3=$_POST['newfleetmake3']?? '';
$newfleetmodel3=$_POST['newfleetmodel3'];
$fleetcap3=$_POST['fleetcap3'];
$unit3=$_POST['unit3'] ?? '';
$newyom3=$_POST['newyom3'];
$boomLength3=$_POST['boomLength3'];
$jibLength3=$_POST['jibLength3'];
$luffingLength3=$_POST['luffingLength3'];
$rental3=$_POST['rental3'];
$mob03=$_POST['mob03'];
$demob03=$_POST['demob03'];
$equiplocation03=$_POST['equiplocation03'];
$fuelperltr3=$_POST['fuelperltr3'];
$adblue3=$_POST['adblue3'];



$asset_code4=$_POST['asset_code4'];
if(isset($asset_code4) && $asset_code4!='New Equipment'){
    $fourthvehicle="SELECT * FROM `fleet1` where assetcode='$asset_code4' and companyname='$companyname001'";
    $fourthvehicleresult=mysqli_query($conn,$fourthvehicle);
    $fourthrow=mysqli_fetch_assoc($fourthvehicleresult);
}
$avail4=$_POST['avail4'];
$date4=$_POST['date4'];
$yom4=$_POST['yom4'];
$capacity4=$_POST['capacity4'];
$boom4=$_POST['boom4'];
$jib4=$_POST['jib4'];
$luffing4=$_POST['luffing4'];
$fleet_category4 = $_POST['fleet_category4'] ?? '';
$type4 = $_POST['type4'] ?? '';
$newfleetmake4=$_POST['newfleetmake4']?? '';
$newfleetmodel4=$_POST['newfleetmodel4'];
$fleetcap4=$_POST['fleetcap4'];
$unit4=$_POST['unit4'] ?? '';
$newyom4=$_POST['newyom4'];
$boomLength4=$_POST['boomLength4'];
$jibLength4=$_POST['jibLength4'];
$luffingLength4=$_POST['luffingLength4'];
$rental4=$_POST['rental4'];
$mob04=$_POST['mob04'];
$demob04=$_POST['demob04'];
$equiplocation04=$_POST['equiplocation04'];
$fuelperltr4=$_POST['fuelperltr4'];
$adblue4=$_POST['adblue4'];


$asset_code5=$_POST['asset_code5'];
if(isset($asset_code5) && $asset_code5!='New Equipment'){
    $fifthvehicle="SELECT * FROM `fleet1` where assetcode='$asset_code5' and companyname='$companyname001'";
    $fifthvehicleresult=mysqli_query($conn,$fifthvehicle);
    $fifthrow=mysqli_fetch_assoc($fifthvehicleresult);
}
$avail5=$_POST['avail5'];
$date5=$_POST['date5'];
$yom5=$_POST['yom5'];
$capacity5=$_POST['capacity5'];
$boom5=$_POST['boom5'];
$jib5=$_POST['jib5'];
$luffing5=$_POST['luffing5'];
$fleet_category5 = $_POST['fleet_category5'] ?? '';
$type5 = $_POST['type5'] ?? '';
$newfleetmake5=$_POST['newfleetmake5']?? '';
$newfleetmodel5=$_POST['newfleetmodel5'];
$fleetcap5=$_POST['fleetcap5'];
$unit5=$_POST['unit5'];
$newyom5=$_POST['newyom5'];
$boomLength5=$_POST['boomLength5'];
$jibLength5=$_POST['jibLength5'];
$luffingLength5=$_POST['luffingLength5'];
$rental5=$_POST['rental5'];
$mob05=$_POST['mob05'];
$demob05=$_POST['demob05'];
$equiplocation05=$_POST['equiplocation05'];
$fuelperltr5=$_POST['fuelperltr5'];
$adblue5=$_POST['adblue5'];
$officetype=$_POST['officetype'];

$lumsumamount=$_POST['lumsumamount'] ?? '';
$roadtax_condition=$_POST['roadtax_condition'] ?? '';

$fuelUnit=$_POST['fuelUnit'] ?? '';







if(isset($_POST['newrentalclient']) && !empty($_POST['newrentalclient']) || isset($_POST['newrentalcontactperson']) && !empty($_POST['newrentalcontactperson'])){
    $sqlnewclient="INSERT INTO `rentalclients`(`address_type`,`companyname`, `clientname`,
     `clientaddress`, `contact_person`,
      `contact_number`, `contact_email`, `handled_by`) VALUES ('$officetype','$companyname001','$clientname','$to_address','$contactpersonname','$contact_peson_cell','$email_id','$sender')";
      $resultnewclient=mysqli_query($conn,$sqlnewclient);

      $sqlclientbasicdetail="INSERT INTO `rentalclient_basicdetail`(`companyname`, `clientname`, `hqaddress`, `KAM`)
       VALUES ('$companyname001','$clientname','$to_address','$sender')";
       $basicclient=mysqli_query($conn,$sqlclientbasicdetail);
}

if(isset($_POST['asset_code3']) && $_POST['asset_code3']!='New Equipment')
{
    $thirdquotation="INSERT INTO `thirdvehicle_quotation`(`fuelUnit`,`uniqueid`, `asset_code2`, `yom2`, 
    `make2`, `model2`, `sub_type2`, `category2`, `fuel/hour2`, 
    `availability2`, `tentative_date2`, `cap2`, `cap_unit2`, 
    `boom2`, `jib2`, `luffing2`,`rental_charges2`, `mob_charges2`,
     `demob_charges2`, `crane_location2`, `adblue2`) VALUES ('$fuelUnit','$uniqueidname','$asset_code3','$yom3','".$thirdrow['make']."','".$thirdrow['model']."','".$thirdrow['sub_type']."','".$thirdrow['category']."',
     '$fuelperltr3','$avail3','$date3','$capacity3','".$thirdrow['unit']."','$boom3','$jib3','$luffing3','$rental3','$mob03',
     '$demob03','$equiplocation03','$adblue3')";
     $resultthirdequipment=mysqli_query($conn,$thirdquotation);

}
elseif(isset($_POST['asset_code3']) && $_POST['asset_code3']='New Equipment'){
    $thirdnewequipment="INSERT INTO `thirdvehicle_quotation`(`fuelUnit`,`uniqueid`, `asset_code2`, `yom2`, 
    `make2`, `model2`, `sub_type2`, `category2`, `fuel/hour2`, 
    `availability2`, `tentative_date2`, `cap2`, `cap_unit2`, 
    `boom2`, `jib2`, `luffing2`,`rental_charges2`, `mob_charges2`,
     `demob_charges2`, `crane_location2`, `adblue2`) VALUES ('$fuelUnit','$uniqueidname','$asset_code3','$newyom3','$newfleetmake3','$newfleetmodel3','$type3','$fleet_category3','$fuelperltr3',
     '$avail3','$date3','$fleetcap3','$unit3','$boomLength3','$jibLength3','$luffingLength3','$rental3','$mob03',
     '$demob03','$equiplocation03','$adblue3')";
     $thirdnewvehicleresult=mysqli_query($conn,$thirdnewequipment);
}


if(isset($_POST['asset_code4']) && $_POST['asset_code4']!='New Equipment')
{
    $fourthquotation="INSERT INTO `fourthvehicle_quotation`(`fuelUnit`,`uniqueid`, `asset_code2`, `yom2`, 
    `make2`, `model2`, `sub_type2`, `category2`, `fuel/hour2`, 
    `availability2`, `tentative_date2`, `cap2`, `cap_unit2`, 
    `boom2`, `jib2`, `luffing2`,`rental_charges2`, `mob_charges2`,
     `demob_charges2`, `crane_location2`, `adblue2`) VALUES ('$fuelUnit','$uniqueidname','$asset_code4','$yom4','".$fourthrow['make']."','".$fourthrow['model']."','".$fourthrow['sub_type']."','".$fourthrow['category']."',
     '$fuelperltr4','$avail4','$date4','$capacity4','".$fourthrow['unit']."','$boom4','$jib4','$luffing4','$rental4','$mob04',
     '$demob04','$equiplocation04','$adblue4')";
     $resultfourthequipment=mysqli_query($conn,$fourthquotation);

}
elseif(isset($_POST['asset_code4']) && $_POST['asset_code4']='New Equipment'){
    $fourthnewequipment="INSERT INTO `fourthvehicle_quotation`(`fuelUnit`,`uniqueid`, `asset_code2`, `yom2`, 
    `make2`, `model2`, `sub_type2`, `category2`, `fuel/hour2`, 
    `availability2`, `tentative_date2`, `cap2`, `cap_unit2`, 
    `boom2`, `jib2`, `luffing2`,`rental_charges2`, `mob_charges2`,
     `demob_charges2`, `crane_location2`, `adblue2`) VALUES ('$fuelUnit','$uniqueidname','$asset_code4','$newyom4','$newfleetmake4','$newfleetmodel4','$type4','$fleet_category4','$fuelperltr4',
     '$avail4','$date4','$fleetcap4','$unit4','$boomLength4','$jibLength4','$luffingLength4','$rental4','$mob04',
     '$demob04','$equiplocation04','$adblue4')";
     $fourthnewvehicleresult=mysqli_query($conn,$fourthnewequipment);
}


if(isset($_POST['asset_code5']) && $_POST['asset_code5']!='New Equipment')
{
    $fifthquotation="INSERT INTO `fifthvehicle_quotation`(`fuelUnit`,`uniqueid`, `asset_code2`, `yom2`, 
    `make2`, `model2`, `sub_type2`, `category2`, `fuel/hour2`, 
    `availability2`, `tentative_date2`, `cap2`, `cap_unit2`, 
    `boom2`, `jib2`, `luffing2`,`rental_charges2`, `mob_charges2`,
     `demob_charges2`, `crane_location2`, `adblue2`) VALUES ('$fuelUnit','$uniqueidname','$asset_code5','$yom5','".$fifthrow['make']."','".$fifthrow['model']."','".$fifthrow['sub_type']."','".$fifthrow['category']."',
     '$fuelperltr5','$avail5','$date5','$capacity5','".$fifthrow['unit']."','$boom5','$jib5','$luffing5','$rental5','$mob05',
     '$demob05','$equiplocation05','$adblue5')";
     $resultfifthequipment=mysqli_query($conn,$fifthquotation);

}
elseif(isset($_POST['asset_code5']) && $_POST['asset_code5']='New Equipment'){
    $fifthnewequipment="INSERT INTO `fifthvehicle_quotation`(`fuelUnit`,`uniqueid`, `asset_code2`, `yom2`, 
    `make2`, `model2`, `sub_type2`, `category2`, `fuel/hour2`, 
    `availability2`, `tentative_date2`, `cap2`, `cap_unit2`, 
    `boom2`, `jib2`, `luffing2`,`rental_charges2`, `mob_charges2`,
     `demob_charges2`, `crane_location2`, `adblue2`) VALUES ('$fuelUnit','$uniqueidname','$asset_code5','$newyom5','$newfleetmake5','$newfleetmodel5','$type5','$fleet_category5','$fuelperltr5',
     '$avail5','$date5','$fleetcap5','$unit5','$boomLength5','$jibLength5','$luffingLength5','$rental5','$mob05',
     '$demob05','$equiplocation05','$adblue5')";
     $fifthnewvehicleresult=mysqli_query($conn,$fifthnewequipment);
}


if ($_POST['asset_code']==='New Equipment') {
    $sql_insertion = "INSERT INTO `quotation_generated` (
        `fuelUnit`,`road_tax`, `adblue_scope`, `fuel_scope`, `working_start`, `working_end`, `working_end_unit`,
        `salutation`, `quote_validity`, `ppe_kit`, `dehire_clause`, `category`, `ref_no`, `uniqueid`,
        `engine_hours`, `shift_info`, `sender_office_address`, `tentative_date`, `contact_person_cell`,
        `yom`, `cap`, `cap_unit`, `boom`, `jib`, `luffing`, `availability`, `fuel/hour`, `make`, `model`,
        `sub_Type`, `quote_date`, `to_name`, `to_address`, `contact_person`, `email_id_contact_person`,
        `site_loc`, `asset_code`, `hours_duration`, `days_duration`, `sunday_included`, `rental_charges`,
        `mob_charges`, `demob_charges`, `crane_location`, `adblue`, `sender_name`, `sender_number`,
        `sender_contact`, `company_name`, `period_contract`, `adv_pay`, `crew`, `room`, `food`, `travel`,
        `brkdown`, `ot_pay`, `pay_terms`, `delay_pay`, `equipment_assembly`, `tpi`, `safety`, `tools`,
        `gst`, `custom_terms`, `force_clause`, `food_break`, `senders_designation` , `internal_shifting` ,`mobilisation_notice`,`roadtax_condition`,`lumsumamount`
    ) VALUES (
        '$fuelUnit','$road_tax', '$adblue_scope', '$fuel_scope', '$working_shift_start', '$working_shift_end', '$working_shift_end_unit',
        '$salutation_dd', '$quote_valid', '$ppe', '$dehire', '$fleet_category', '$next_ref_no', '$uniqueidname', '$engine_hour',
        '$shiftinfo', '$sender_office_address', '$tentative', '$contact_peson_cell', '$yom_new_fleet', '$new_fleet_cap',
        '$newfleet_cap', '$boomLength', '$jibLength', '$luffingLength', '$availability', '$fuel', '$newfleetmake',
        '$newfleetmodel', '$type', '$quote_date', '$clientname', '$to_address', '$contactpersonname', '$email_id',
        '$site_location', '$asset_code', '$hours_duration', '$days_duration', '$condition', '$rental_charges',
        '$mob_charges', '$demob_charges', '$location', '$adblue', '$sender', '$contactnumbersender',
        '$contactemailsender', '$companyname001', '$period', '$adv_pay', '$crew', '$room', '$food', '$travel',
        '$brkdown', '$ot_payment', '$payment_terms_select', '$delay_pay', '$assembly', '$tpi', '$safety_security',
        '$tools_tackels', '$gst', '$custom', '$force_clause', '$lunch_time', '" . $senderdetailrow['designation'] . "','$internal_shifting','$mobilisation_notice','$roadtax_condition','$lumsumamount'
    )";
    
    $result_insertion = mysqli_query($conn, $sql_insertion);

    if ($result_insertion) {
        // $showAlert = true;
        session_start();
        $_SESSION['success']='success';
        header("Location:generate_quotation_landingpage.php");
    } else {
        // $showError = true;
        echo "jcnedjice";
    }
}
else{
    $sql_insertion1="INSERT INTO `quotation_generated` (`fuelUnit`,`custom_terms`,`road_tax`,`adblue_scope`,`fuel_scope`,`working_start`,`working_end`,`working_end_unit`,`salutation`,`quote_validity`,`ppe_kit`,`dehire_clause`,`category`,`ref_no`,`uniqueid`,`engine_hours`,`shift_info`,`sender_office_address`,`tentative_date`,`contact_person_cell`,`yom`,`cap`,`cap_unit`,`boom`,`jib`,`luffing`,`availability`,`fuel/hour`,`make`,`model`,`sub_Type`,`quote_date`, `to_name`, `to_address`, `contact_person`, `email_id_contact_person`, 
        `site_loc`, `asset_code`, `hours_duration`, `days_duration`, `sunday_included`, `rental_charges`, `mob_charges`, `demob_charges`,
         `crane_location`, `adblue`, `sender_name`, `sender_number`, `sender_contact`, `company_name`,`period_contract`, `adv_pay`, `crew`, `room`, `food`, `travel`, `brkdown`, `ot_pay`, `pay_terms`, `delay_pay`, `equipment_assembly`, `tpi`, `safety`, `tools`, `gst`, `force_clause`, `food_break`, `senders_designation`, `internal_shifting` ,`mobilisation_notice`,`roadtax_condition`,`lumsumamount`) 
        VALUES ('$fuelUnit','$custom','$road_tax','$adblue_scope','$fuel_scope','$working_shift_start','$working_shift_end','$working_shift_end_unit','$salutation_dd','$quote_valid','$ppe','$dehire','". $row_specs['category'] . "','$next_ref_no','$uniqueidname','$engine_hour','$shiftinfo','$sender_office_address','$tentative','$contact_peson_cell','$yom_equip','$cap_equip','". $row_specs['unit'] . "','$boom_equip','$jib_equip','$luffing_equip','$availability','$fuel','". $row_specs['make'] . "','". $row_specs['model'] . "','". $row_specs['sub_type'] . "','$quote_date', '$clientname', '$to_address', '$contactpersonname', '$email_id', '$site_location', '$asset_code', '$hours_duration',
         '$days_duration', '$condition', '$rental_charges', '$mob_charges', '$demob_charges', '$location', '$adblue', '$sender', '$contactnumbersender', '$contactemailsender', '$companyname001','$period','$adv_pay','$crew','$room','$food','$travel','$brkdown','$ot_payment','$payment_terms_select','$delay_pay','$assembly','$tpi','$safety_security','$tools_tackels','$gst','$force_clause','$lunch_time','".$senderdetailrow['designation']."','$internal_shifting','$mobilisation_notice','$roadtax_condition','$lumsumamount')";

        $result_insertion1= mysqli_query($conn, $sql_insertion1);

        if ($result_insertion1) {
            session_start();
            $_SESSION['success']='success';    
            header("Location:generate_quotation_landingpage.php");
        } else {
            $showError = true;
        }
        
    }
    if(isset($_POST['asset_code1']) && $_POST['asset_code1']==='New Equipment'){
      $sql_second_vehicle="  INSERT INTO `second_vehicle_quotation`(`fuelUnit`,`category2`,`uniqueid`, `asset_code2`, `yom2`, `make2`, `model2`, `sub_type2`,
         `fuel/hour2`, `availability2`, `tentative_date2`, `cap2`, `cap_unit2`, `boom2`, `jib2`, `luffing2`,
           `rental_charges2`, `mob_charges2`, `demob_charges2`, `crane_location2`,`adblue2`) 
          VALUES ('$fuelUnit','$fleet_category1','$uniqueidname','$asset_code1','$yom2','$newfleetmake1','$newfleetmodel1','$type1','$fuelperltr2',
          '$avail1','$date_','$fleetcap2','$unit2','$boomLength2','$jibLength2','$luffingLength2',
          '$rental2','$mob02','$demob02','$equiplocation02','$adblue2')";
        $secondvehicleinsert=mysqli_query($conn,$sql_second_vehicle);
        if ($secondvehicleinsert) {
            session_start();
            $_SESSION['success']='success';    
            header("Location:generate_quotation_landingpage.php");
        } else {
            $showError = true;
        }  
   } 
   elseif( isset($_POST['asset_code1']) && $_POST['asset_code1']!="New Equipment"){
    $sql_second_vehicle2="  INSERT INTO `second_vehicle_quotation`(`fuelUnit`,`category2`,`uniqueid`, `asset_code2`, `yom2`, `make2`, `model2`, `sub_type2`,
    `fuel/hour2`, `availability2`, `tentative_date2`, `cap2`, `cap_unit2`, `boom2`, `jib2`, `luffing2`,
      `rental_charges2`, `mob_charges2`, `demob_charges2`, `crane_location2`,`adblue2`) 
     VALUES ('$fuelUnit','".$row_specs1['category']."','$uniqueidname','$asset_code1','$yom_second_equipment_new','".$row_specs1['make']."','".$row_specs1['model']."','".$row_specs1['sub_type']."','$fuelperltr2',
     '$avail1','$date_','$cap_second_equipment_new','".$row_specs1['unit']."','$boom_second_equipment_new','$jib_second_equipment_new','$luffing_second_equipment',
     '$rental2','$mob02','$demob02','$equiplocation02','$adblue2')";
   $secondvehicleinsert2=mysqli_query($conn,$sql_second_vehicle2);
   if ($secondvehicleinsert2) {
    session_start();
    $_SESSION['success']='success';
    header("Location:generate_quotation_landingpage.php");
} else {
    $showError = true;
}  

   }
 }
?>
<?php  
$sql_logo_check="SELECT * FROM `quotation_generated` where company_name='$companyname001'";
$result_logo=mysqli_query($conn , $sql_logo_check);
$row_logo=mysqli_fetch_assoc($result_logo);
?>
<?php 
$sql_company_address="SELECT * FROM `basic_details` where companyname='$companyname001'";
$sql_result_company_address=mysqli_query($conn , $sql_company_address);
$row_companyaddress=mysqli_fetch_assoc($sql_result_company_address);
?>
<?php 
if(isset($_SESSION['user_added'])){
    $showAlertuser=true;
    unset($_SESSION['user_added']);
    
} 

?>