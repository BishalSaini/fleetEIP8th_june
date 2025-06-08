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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">      
    <link rel="icon" href="favicon.jpg" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <script><?php include "autofill.js" ?></script>
    <script scr="autofill.js"defer></script>
    <script scr="main.js"defer></script>


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

<?php
if ($showAlert) {
    echo  '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert notice">
      <span class="alertClose">X</span>
      <span class="alertText_addfleet"><b>Success! </b>Quotation Generated Successfully<a href="generate_quotation_landingpage.php">View It Here</a>
          <br class="clear"/></span>
    </div>
  </label>';
}
if ($showError) {
    echo '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert error">
      <span class="alertClose">X</span>
      <span class="alertText">Something Went Wrong
          <br class="clear"/></span>
    </div>
  </label>';
}
if($showAlertuser){
    echo '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert notice">
      <span class="alertClose">X</span>
      <span class="alertText">User Added Successfully!
          <br class="clear"/></span>
    </div>
  </label>';
 }

?>

<form action="generate_quotation.php" method="POST" id="uquotationform" class="generate_quotation" autocomplete="off" enctype="multipart/form-data">
    <div class="generate_quote_container">
        <div id="contactpersonsectioncontainer">
        <p class="headingpara">Contact Person Section :</p>
        <!-- <div class="generate_quote_heading">Generate Quotation</div> -->
        <div class="outer02" id="datequote_container">
        <div class="trial1" id="quote_date_input">
    <input type="date"  placeholder="" name="quotation_date" class="input02" value="<?php echo date('Y-m-d'); ?>">
    <label for="" class="placeholder2"> Quotation Date</label>
</div></div>
<input type="text" value=" <?php echo $uniqueId ?>" name="uniqueidname" readonly hidden >
        <div class="outer02" id="quoteouter02">

        <div class="trial1" id="newrentalclient">
            <input type="text" placeholder="" name="newrentalclient" class="input02">
            <label for="" class="placeholder2">New Client</label>
        </div>

        <div class="trial1" id="companySelectouter">
    <input type="text" id="clientSearch" class="input02" placeholder="Select Client" onkeyup="filterClients()" onclick="showDropdown()" autocomplete="off">
    <select id="companySelect" name="to" class="input02" onchange="updateContactPerson(); newclient();" style="display: none;">
        <option value="" disabled selected>Select Client</option>
        <option value="New Client" id="newClientOption">New Client</option>
        <?php
        if (mysqli_num_rows($result_client) > 0) {
            while ($row_client = mysqli_fetch_assoc($result_client)) {
                echo '<option value="' . $row_client['clientname'] . '">' . $row_client['clientname'] . '</option>';
            }
        }
        ?>
    </select>
    <div id="suggestions" class="suggestions"></div>

</div>
        <div class="trial1" id="salute_dd">
            <select name="salutation_dd"  class="input02" required>
                <option value="Mr">Mr</option>
                <option value="Ms">Ms</option>
            </select>
        </div>
        <div class="trial1" id="contactSelectouter">
        <!-- <input type="text" placeholder="" name="contact_person" class="input02" required>
        <label for="" class="placeholder2">Contact Person</label> -->
        <select id="contactSelect" class="input02" name="contact_person" onchange="newcontactpersonfunction()">
            <option value=""disabled selected>Select Contact Person</option>
            <option value="New Contact Person">New Contact Person</option>

    </select>
        
        </div>

        <div class="trial1" id="newrentalcontactperson">
            <input type="text" placeholder="" name="newrentalcontactperson" class="input02">
            <label for="" class="placeholder2">Contact Person</label>
        </div>
        <div class="trial1" id='officetypeouter'>
            <select name="officetype" id="office_typenew" class="input02" onchange="officetypedd()">
                <option value=""disabled selected>Office Type</option>
                <option value="HQ">HQ</option>
                <option value="Site Office">Site Office</option>
                <option value="Regional Office">Regional Office</option>
            </select>
        </div>


        </div>

        <div class="outer02">
        <div class="trial1">
        <input type="text" placeholder="" id="contactpersonaddress" name="to_address" class="input02" required>
        <label for="" class="placeholder2">To Address</label>
        </div>

        <div class="trial1" id="contact_number1">
        <input type="text" placeholder="" id="clientcontactnumber" name="contact_number" class="input02" required>
        <label for="" class="placeholder2">Contact Number</label>
        </div>
        
        <div class="trial1 ">
        <input type="text" placeholder="" id="clientcontactemail" name="email_id" class="input02" required>
        <label for="" class="placeholder2">Email Id</label>
        </div>
        </div>
        <input type="text" value="<?php echo $companyname001 ?>" id="comp_name_trial" hidden>
        <!-- <button class="epc-button">Next</button> -->
         <!-- Updated Button with the class "quotationnavigatebutton" -->
<!-- <button
  class="quotationnavigatebutton bg-white text-center w-30 rounded-lg h-10 relative text-black text-sm font-semibold group"
  type="button"
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
</button> -->

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
        <div class="trial1 selectfleetCategory" >
        <select class="input02 fleet-category" data-dropdown="1" onchange="updateAssetCode(this)" required>
            
        <option value="" disabled selected>Select Fleet Category</option>
        <option value="Aerial Work Platform">Aerial Work Platform</option>
        <option value="Concrete Equipment">Concrete Equipment</option>
        <option value="EarthMovers and Road Equipments">EarthMovers and Road Equipments</option>
        <option value="Material Handling Equipments">Material Handling Equipments</option>
        <option value="Ground Engineering Equipments">Ground Engineering Equipments</option>
        <option value="Trailor and Truck">Trailor and Truck</option>
        <option value="Generator and Lighting">Generator and Lighting</option>
    </select>
</div>

<div class="trial1">
    <!-- <select name="asset_code asset-code" class="input02" onchange="choose_new_equ()" id="assetcode" required> -->
    <select name="asset_code" class="input02 asset-code" data-dropdown="1" id="assetcode" onchange="choose_new_equ()" required>
        <option value="" disabled selected>Choose Asset Code</option>
        <option value="New Equipment">Choose New Equipment</option>
        <!-- Options will be dynamically populated here -->
    </select>
</div>

        

        </div>
        <div class="availableouter">
        <div class="trial1 availability width350">
            <select name="availability" id="availability_dd" class="input02" onchange="not_immediate()" required>
                <option value=""disabled selected>Availability</option>
                <option value="Immediate">Immediate</option>
                <option value="Not Immediate">Select A Date</option>
            </select>
        </div>
        <div class="trial1 width350" id="date_of_availability" >
            <input type="date" placeholder="" class="input02" name="tentative_date">
            <label for="" class="placeholder2">Availability Date</label>
        </div>


        </div>
        <div class="prefetch_data_container" id="prefetch">
        <div class="outer02">
        <!-- yomcontainer  -->
            <div class="trial1 ">      
                <input type="text" placeholder="" name="yom_equip" id="yom" class="input02">
                <label for="" class="placeholder2">YoM</label>
            </div>
            <!-- width350 -->
            <div class="trial1 ">
                <input type="text" placeholder="" name="capacity_equip" id="capacity" class="input02">
                <label for="" class="placeholder2">Capacity</label>
            </div>
            <!-- capunitinput -->
            <div class="trial1 ">
                <input readonly type="text" id="fuelunit1" placeholder="" class="input02">
                <label for="" class="placeholder2">Unit</label>
            </div>

        </div>
        <div class="outer02">
        <div class="specific-container">
            <div class="trial1">
                <input type="text" placeholder="" name="boom_equip" id="boomlength" class="input02">
                <label for="" class="placeholder2">Boom Length</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="jib_equip" id="jiblength" class="input02">
                <label for="" class="placeholder2">Jib Length</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="luffing_equip" id="luffinglength" class="input02">
                <label for="" class="placeholder2">Luffing Length</label>
            </div>


            </div>
            <div class="trial1">
                <input type="text" placeholder="" id="bedlength" class="input02">
                <label for="" class="placeholder2">Bed Length</label>
            </div>
            </div>
            </div>
        <div class="outer02" id="new_equip" >
        <div class="trial1">
        <select class="input02" name="fleet_category" id="oem_fleet_type" onchange="purchase_option()" >
            <option value="" disabled selected>Select Fleet Category</option>
            <option value="Aerial Work Platform">Aerial Work Platform</option>
            <option value="Concrete Equipment">Concrete Equipment</option>
            <option value="EarthMovers and Road Equipments">EarthMovers and Road Equipments</option>
            <option value="Material Handling Equipments">Material Handling Equipments</option>
            <option value="Ground Engineering Equipments">Ground Engineering Equipments</option>
            <option value="Trailor and Truck">Trailor and Truck</option>
            <option value="Generator and Lighting">Generator and Lighting</option>
        </select>

        </div>
        
        <div class="trial1">
        <select class="input02" name="type" id="fleet_sub_type" >
            <option value="" disabled selected>Select Fleet Type</option>
            <option value="Self Propelled Articulated Boomlift"class="awp_options"  id="aerial_work_platform_option1">Self Propelled Articulated Boomlift</option>
            <option value="Scissor Lift Diesel" class="awp_options" id="aerial_work_platform_option2">Scissor Lift Diesel</option>
            <option value="Scissor Lift Electric"class="awp_options"  id="aerial_work_platform_option3">Scissor Lift Electric</option>
            <option value="Spider Lift"class="awp_options"  id="aerial_work_platform_option4">Spider Lift</option>
            <option value="Self Propelled Straight Boomlift"class="awp_options"  id="aerial_work_platform_option5">Self Propelled Straight Boomlift</option>
            <option value="Truck Mounted Articulated Boomlift"class="awp_options"  id="aerial_work_platform_option6">Truck Mounted Articulated Boomlift</option>
            <option value="Truck Mounted Straight Boomlift"class="awp_options"  id="aerial_work_platform_option7">Truck Mounted Straight Boomlift</option>
            <option value="Batching Plant"class="cq_options" id="concrete_equipment_option1">Batching Plant</option>
            <option value="Self Loading Mixer"class="cq_options" id="">Self Loading Mixer</option>
            <option value="Concrete Boom Placer"class="cq_options" id="concrete_equipment_option2">Concrete Boom Placer</option>
            <option value="Concrete Pump"class="cq_options" id="concrete_equipment_option3">Concrete Pump</option>
            <option value="Moli Pump"class="cq_options" id="concrete_equipment_option4">Moli Pump</option>
            <option value="Mobile Batching Plant"class="cq_options" id="concrete_equipment_option5">Mobile Batching Plant</option>
            <option value="Static Boom Placer"class="cq_options" id="concrete_equipment_option6">Static Boom Placer</option>
            <option value="Transit Mixer"class="cq_options" id="concrete_equipment_option7">Transit Mixer</option> 
             <option value="Shotcrete boom"class="cq_options" id="concrete_equipment_option8">Shotcrete boom</option>
            <option value="Baby Roller" class="earthmover_options" id="earthmovers_option1">Baby Roller</option>
            <option value="Backhoe Loader" class="earthmover_options" id="earthmovers_option2">Backhoe Loader</option>
            <option value="Bulldozer" class="earthmover_options" id="earthmovers_option3">Bulldozer</option>
            <option value="Excavator" class="earthmover_options" id="earthmovers_option4">Excavator</option>
            <option value="Milling Machine" class="earthmover_options" id="earthmovers_option5">Milling Machine</option>
            <option value="Motor Grader" class="earthmover_options" id="earthmovers_option6">Motor Grader</option>
            <option value="Pneumatic Tyre Roller" class="earthmover_options" id="earthmovers_option7">Pneumatic Tyre Roller</option>
            <option value="Single Drum Roller" class="earthmover_options" id="earthmovers_option8">Single Drum Roller</option>
            <option value="Skid Loader" class="earthmover_options" id="earthmovers_option9">Skid Loader</option>
            <option value="Slip Form Paver" class="earthmover_options" id="earthmovers_option10">Slip Form Paver</option>
            <option value="Soil Compactor" class="earthmover_options" id="earthmovers_option11">Soil Compactor</option>
            <option value="Tandem Roller" class="earthmover_options" id="earthmovers_option12">Tandem Roller</option>
            <option value="Vibratory Roller" class="earthmover_options" id="earthmovers_option13">Vibratory Roller</option>
            <option value="Wheeled Excavator" class="earthmover_options" id="earthmovers_option14">Wheeled Excavator</option>
            <option value="Wheeled Loader" class="earthmover_options" id="earthmovers_option15">Wheeled Loader</option>
            <option id="mhe_option1"  class="mhe_options" value="Fixed Tower Crane">Fixed Tower Crane</option>
            <option id="mhe_option2" class="mhe_options" value="Fork Lift Diesel">Fork Lift Diesel</option>
            <option id="mhe_option3" class="mhe_options" value="Fork Lift Electric">Fork Lift Electric</option>
            <option id="mhe_option4" class="mhe_options" value="Hammerhead Tower Crane">Hammerhead Tower Crane</option>
            <option id="mhe_option5" class="mhe_options" value="Hydraulic Crawler Crane">Hydraulic Crawler Crane</option>
            <option id="mhe_option6" class="mhe_options" value="Luffing Jib Tower Crane">Luffing Jib Tower Crane</option>
            <option id="mhe_option7" class="mhe_options" value="Mechanical Crawler Crane">Mechanical Crawler Crane</option>
            <option id="mhe_option8" class="mhe_options" value="Pick and Carry Crane">Pick and Carry Crane</option>
            <option id="mhe_option9" class="mhe_options" value="Reach Stacker">Reach Stacker</option>
            <option id="mhe_option10" class="mhe_options" value="Rough Terrain Crane">Rough Terrain Crane</option>
            <option id="mhe_option11" class="mhe_options" value="Telehandler">Telehandler</option>
            <option id="mhe_option12" class="mhe_options" value="Telescopic Crawler Crane">Telescopic Crawler Crane</option>
            <option id="mhe_option13" class="mhe_options" value="Telescopic Mobile Crane">Telescopic Mobile Crane</option>
            <option id="mhe_option14" class="mhe_options" value="All Terrain Mobile Crane">All Terrain Mobile Crane</option>
            <option id="mhe_option15" class="mhe_options" value="Self Loading Truck Crane">Self Loading Truck Crane</option>

            <option id="ground_engineering_equipment_option" class="gee_options" value="Hydraulic Drilling Rig">Hydraulic Drilling Rig</option>
            <option id="ground_engineering_equipment_option" class="gee_options" value="Rotary Drilling Rig">Rotary Drilling Rig</option>
            <option id="ground_engineering_equipment_option" class="gee_options" value="Vibro Hammer">Vibro Hammer</option>
            <option  id="trailor_option1" class="trailor_options" value="Dumper">Dumper</option>
            <option  id="trailor_option2" class="trailor_options" value="Truck">Truck</option>
            <option  id="trailor_option3" class="trailor_options" value="Water Tanker">Water Tanker</option>
            <option id="trailor_option4"  class="trailor_options" value="Low Bed">Low Bed</option>
            <option id="trailor_option5"  class="trailor_options" value="Semi Low Bed">Semi Low Bed</option>
            <option  id="trailor_option6" class="trailor_options" value="Flatbed">Flatbed</option>
            <option  id="trailor_option7" class="trailor_options" value="Hydraulic Axle">Hydraulic Axle</option>
            <option id="generator_option" class="generator_options" value="Silent Diesel Generator">Silent Diesel Generator</option>
            <option id="generator_option" class="generator_options" value="Mobile Light Tower">Mobile Light Tower</option>
            <option id="generator_option" class="generator_options" value="Diesel Generator">Diesel Generator</option>
        </select>

        </div>
    </div>
    <div class="outer02" id="newfleet_makemodel">
        <div class="trial1">
            <input type="text" placeholder="" name="newfleetmake" class="input02">
            <label for="" class="placeholder2">Fleet Make</label>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" name="newfleetmodel" class="input02">
            <label for="" class="placeholder2">Fleet Model</label>
        </div>

    </div>
    <div class="outer02" id="newfleet_capinfo">
        <div class="trial1">
            <input type="text" placeholder="" name="new_fleet_cap" class="input02">
            <label for="" class="placeholder2">Fleet Capacity</label>
        </div>
        <div class="trial1" id="newfleet_unit">
            <select name="newfleet_cap" id="" class="input02">
                <option value=""disabled selected>Unit</option>
                <option value="Ton">Ton</option>
                <option value="Kgs">Kgs</option>
                <option value="KnM">KnM</option>
                <option value="Meter">Meter</option>
                <option value="M³">M³</option>
            </select>
        </div>
        <div class="trial1">
            <input type="number" placeholder="" name="yom_new_fleet" class="input02" min="1900" max="2099">
            <label for="" class="placeholder2">YOM</label>
        </div>
    </div>
    <div class="outer02" id="newfleet_jib">
    <div class="trial1" >
            <input type="text" name="boomLength"  placeholder="" class=" input02" >
            <label class="placeholder2">Boom Length</label>
        </div>    
        <div class="trial1" >
            <input type="text" name="jibLength"  placeholder="" class="input02 " >
            <label class="placeholder2">Jib Length</label>
        </div>
        <div class="trial1">
            <input type="text" name="luffingLength"  placeholder="" class=" input02" >
            <label class="placeholder2">Luffing Length</label>
        </div>

    </div>
        <div class="outer02">
        <div class="trial1 width350">
            <select name="shiftinfo" id="select_shift" class="input02" onchange="shift_hour()" required>
                <option value=""disabled selected>Select Shift</option>
                <option value="Single Shift">Single Shift</option>
                <option value="Double Shift">Double Shift</option>
                <option value="Flexi Shift">Flexi Shift</option>
            </select>
        </div>


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
        <select name="engine_hour" id="engine_hour_select" class="input02">
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
    <div class="trial1">
        <input type="text" placeholder="" name="site_location" class="input02" required>
        <label for="" class="placeholder2">Site Location</label>
        </div>
        <div class="trial1">
            <input type="text" name="location" id="equimentlocation" placeholder="" class="input02" required>
            <label for="" class="placeholder2"> Equipment Location </label>
 
        </div>

    </div>

        <div class="outer02">
        <div class="trial1 workingdayscontainer" id="">
            <select name="days_duration" id="working_days_select" class="input02" required>
                <option value="" disabled>Working Days</option>
                <option value="7">7 Days/Month</option>
                <option value="10">10 Days/Month</option>
                <option value="15">15 Days/Month</option>

                <option value="26" >26 Days/Month</option>
                <option value="28">28 Days/Month</option>
                <option value="30">30 Days/Month</option>
            </select>
        </div>
        <div class="trial1 workingdayscontainer">
            <select name="condition" id="" class="input02" required>
                <option value=""disabled selected>Condition</option>
                <option value="Including Sundays">Including Sundays</option>
                <option value="Excluding First Two Sundays">Excluding First Two Sundays</option>
                <option value="Excluding Any Two Sundays">Excluding Any Two Sundays</option>
                <option value="Excluding Sundays" default selected>Excluding Sundays</option>
            </select>
        </div>

        <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" name="fuel_per_hour" id="fuel" class="input02" required>
                <label for="" class="placeholder2">Fuel Efficiency</label>
            </div>
            <select name="fuelUnit" id="unit1" class="input02 ">
                <option value=""disabled selected>Unit</option>
                <option value="ltrs/hour">ltrs/hour</option>
                <option value="kms/ltrs">kms/ltrs</option>
            </select>




</div>

        <!-- <div class="trial1">
            <input type="text" placeholder=""  class="input02">
            <label for="" class="placeholder2">Fuel in ltrs Per Hour</label>
        </div> -->
        <div class="trial1 adbluecontainer">
            <select name="adblue" id="adbluedd" class="input02" required>
                <option value=""disabled selected>Adblue?</option>
                <option value="Yes">Adblue : Yes</option>
                <option value="No">Adblue : No</option>
            </select>
        </div>



        </div>
        

        <div class="outer02">

        <div class="trial1" id="rental_charges1">
            <input type="number" name="rental_charges"  placeholder="" class="input02" required>
            <label for="" class="placeholder2">Rental Charges </label>
        </div>
        <div class="trial1" id="mob_charges1">
            <input type="number" name="mob_charges" placeholder="" class="input02" required>
            <label for="" class="placeholder2">Mob Charges </label>
        </div>
        <div class="trial1" id="demob_charges1">
            <input type="number" name="demob_charges" placeholder="" class="input02" required>
            <label for="" class="placeholder2">Demob Charges </label>
        </div>
        </div>

    <div class="trial1" id="sender_add_employee">
    <textarea type="text" placeholder="" name="sender_office_address" class="input02"><?php echo $row_companyaddress['company_address'] ;?></textarea>
    <label for="" class="placeholder2">Sender Office Address</label>
    </div>
    <div class="addbuttonicon" id="second_addequipbtn"><i onclick="other_quotation()"  class="bi bi-plus-circle">Add Another Equipment</i></div>
    <div class="otherquipquote" id="new_out1">
        <br>
        <p class="add_second_equipment_generate">Add Second Equipment Details <i onclick="cancelsecondequipment()" class="bi bi-x icon-cancel"></i></p> 
    <div class="outer02 mt-10px" >
    <div class="trial1">
        <select class="input02 fleet-category" data-dropdown="2" onchange="updateAssetCode(this)" >
            
        <option value="" disabled selected>Select Fleet Category</option>
        <option value="Aerial Work Platform">Aerial Work Platform</option>
        <option value="Concrete Equipment">Concrete Equipment</option>
        <option value="EarthMovers and Road Equipments">EarthMovers and Road Equipments</option>
        <option value="Material Handling Equipments">Material Handling Equipments</option>
        <option value="Ground Engineering Equipments">Ground Engineering Equipments</option>
        <option value="Trailor and Truck">Trailor and Truck</option>
        <option value="Generator and Lighting">Generator and Lighting</option>
    </select>
</div>

<div class="trial1">
    <!-- <select name="asset_code1" class="input02" onchange="choose_new_equ2()" id="choose_Ac2" required> -->
    <select name="asset_code1" class="input02 asset-code" data-dropdown="2" id="choose_Ac2" onchange="choose_new_equ2()" >

        <option value="" disabled selected>Choose Asset Code</option>
        <option value="New Equipment">Choose New Equipment</option>
    </select>
</div>
       

        </div>
        <!-- availableouter -->
         <div class="availableouter">
         <div class="trial1 width350">
            <select name="avail1" id="availability_dd2" class="input02" onchange="not_immediate2()">
                <option value=""disabled selected>Availability</option>
                <option value="Immediate">Immediate</option>
                <option value="Not Immediate">Select A Date</option>
            </select>
        </div>
        <div class="trial1 width350" id="date_of_availability2" >
            <input type="date" placeholder="" name="date_" class="input02">
            <label for="" class="placeholder2"> Availability Date</label>
        </div>

         </div>
        <div class="prefetch_data_container_second" id="prefetch_second">
        <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" name="yom_equip_second" id="yom_second" class="input02">
                <label for="" class="placeholder2">YoM</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="capacity_equip_second" id="capacity_second" class="input02">
                <label for="" class="placeholder2">Capacity</label>
            </div>
            <!-- <div class="trial1">
                <input type="text" name="fuel_per_hour" id="fuel_second" class="input02">
                <label for="" class="placeholder2">Fuel/Hour</label>
            </div>
 -->
        </div>

        <div class="outer02">
        <div class="specific-container">

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
            <div class="trial1" id="">
        <input type="text" placeholder="" name="bedlength2" id="bedlength_second" class="input02">
        <label for="" class="placeholder2">Bed Length</label>
    </div>
    </div>


            </div>

        <div class="newequip_details1" id="newequipdet1">
        <div class="outer02" id="" >
        <div class="trial1">
        <select class="input02" name="fleet_category1" id="oem_fleet_type1" onchange="seco_equip()" >
            <option value="" disabled selected>Select Fleet Category</option>
            <option value="Aerial Work Platform">Aerial Work Platform</option>
            <option value="Concrete Equipment">Concrete Equipment</option>
            <option value="EarthMovers and Road Equipments">EarthMovers and Road Equipments</option>
            <!-- <option value="aerial_work_platform">Aerial Work Platform</option> -->
            <option value="Material Handling Equipments">Material Handling Equipments</option>
            <option value="Ground Engineering Equipments">Ground Engineering Equipments</option>
            <option value="Trailor and Truck">Trailor and Truck</option>
            <option value="Generator and Lighting">Generator and Lighting</option>
        </select>

        </div>
        <div class="trial1">
        <select class="input02" name="type1" id="fleet_sub_type1" >
            <option value="" disabled selected>Select Fleet Type</option>
            <option value="Self Propelled Articulated Boomlift"class="awp_options1"  id="aerial_work_platform_option1">Self Propelled Articulated Boomlift</option>
            <option value="Scissor Lift Diesel" class="awp_options1" id="aerial_work_platform_option2">Scissor Lift Diesel</option>
            <option value="Scissor Lift Electric"class="awp_options1"  id="aerial_work_platform_option3">Scissor Lift Electric</option>
            <option value="Spider Lift"class="awp_options1"  id="aerial_work_platform_option4">Spider Lift</option>
            <option value="Self Propelled Straight Boomlift"class="awp_options1"  id="aerial_work_platform_option5">Self Propelled Straight Boomlift</option>
            <option value="Truck Mounted Articulated Boomlift"class="awp_options1"  id="aerial_work_platform_option6">Truck Mounted Articulated Boomlift</option>
            <option value="Truck Mounted Straight Boomlift"class="awp_options1"  id="aerial_work_platform_option7">Truck Mounted Straight Boomlift</option>
            <option value="Batching Plant"class="cq_options1" id="concrete_equipment_option1">Batching Plant</option>
            <option value="Self Loading Mixer"class="cq_options1" id="">Self Loading Mixer</option>
            <option value="Concrete Boom Placer"class="cq_options1" id="concrete_equipment_option2">Concrete Boom Placer</option>
            <option value="Concrete Pump"class="cq_options1" id="concrete_equipment_option3">Concrete Pump</option>
            <option value="Moli Pump"class="cq_options1" id="concrete_equipment_option4">Moli Pump</option>
            <option value="Mobile Batching Plant"class="cq_options1" id="concrete_equipment_option5">Mobile Batching Plant</option>
            <option value="Static Boom Placer"class="cq_options1" id="concrete_equipment_option6">Static Boom Placer</option>
            <option value="Transit Mixer"class="cq_options1" id="concrete_equipment_option7">Transit Mixer</option> 
             <option value="Shotcrete boom"class="cq_options" id="concrete_equipment_option8">Shotcrete boom</option>
            <option value="Baby Roller" class="earthmover_options1" id="earthmovers_option1">Baby Roller</option>
            <option value="Backhoe Loader" class="earthmover_options1" id="earthmovers_option2">Backhoe Loader</option>
            <option value="Bulldozer" class="earthmover_options1" id="earthmovers_option3">Bulldozer</option>
            <option value="Excavator" class="earthmover_options1" id="earthmovers_option4">Excavator</option>
            <option value="Milling Machine" class="earthmover_options1" id="earthmovers_option5">Milling Machine</option>
            <option value="Motor Grader" class="earthmover_options1" id="earthmovers_option6">Motor Grader</option>
            <option value="Pneumatic Tyre Roller" class="earthmover_options1" id="earthmovers_option7">Pneumatic Tyre Roller</option>
            <option value="Single Drum Roller" class="earthmover_options1" id="earthmovers_option8">Single Drum Roller</option>
            <option value="Skid Loader" class="earthmover_options1" id="earthmovers_option9">Skid Loader</option>
            <option value="Slip Form Paver" class="earthmover_options1" id="earthmovers_option10">Slip Form Paver</option>
            <option value="Soil Compactor" class="earthmover_options1" id="earthmovers_option11">Soil Compactor</option>
            <option value="Tandem Roller" class="earthmover_options1" id="earthmovers_option12">Tandem Roller</option>
            <option value="Vibratory Roller" class="earthmover_options1" id="earthmovers_option13">Vibratory Roller</option>
            <option value="Wheeled Excavator" class="earthmover_options1" id="earthmovers_option14">Wheeled Excavator</option>
            <option value="Wheeled Loader" class="earthmover_options1" id="earthmovers_option15">Wheeled Loader</option>
            <option id="mhe_option1"  class="mhe_options1" value="Fixed Tower Crane">Fixed Tower Crane</option>
            <option id="mhe_option2" class="mhe_options1" value="Fork Lift Diesel">Fork Lift Diesel</option>
            <option id="mhe_option3" class="mhe_options1" value="Fork Lift Electric">Fork Lift Electric</option>
            <option id="mhe_option4" class="mhe_options1" value="Hammerhead Tower Crane">Hammerhead Tower Crane</option>
            <option id="mhe_option5" class="mhe_options1" value="Hydraulic Crawler Crane">Hydraulic Crawler Crane</option>
            <option id="mhe_option6" class="mhe_options1" value="Luffing Jib Tower Crane">Luffing Jib Tower Crane</option>
            <option id="mhe_option7" class="mhe_options1" value="Mechanical Crawler Crane">Mechanical Crawler Crane</option>
            <option id="mhe_option8" class="mhe_options1" value="Pick and Carry Crane">Pick and Carry Crane</option>
            <option id="mhe_option9" class="mhe_options1" value="Reach Stacker">Reach Stacker</option>
            <option id="mhe_option10" class="mhe_options1" value="Rough Terrain Crane">Rough Terrain Crane</option>
            <option id="mhe_option11" class="mhe_options1" value="Telehandler">Telehandler</option>
            <option id="mhe_option12" class="mhe_options1" value="Telescopic Crawler Crane">Telescopic Crawler Crane</option>
            <option id="mhe_option13" class="mhe_options1" value="Telescopic Mobile Crane">Telescopic Mobile Crane</option>
            <option id="mhe_option14" class="mhe_options1" value="All Terrain Mobile Crane">All Terrain Mobile Crane</option>
            <option id="mhe_option15" class="mhe_options1" value="Self Loading Truck Crane">Self Loading Truck Crane</option>

            <option id="ground_engineering_equipment_option1" class="gee_options1" value="Hydraulic Drilling Rig">Hydraulic Drilling Rig</option>
            <option id="ground_engineering_equipment_option2" class="gee_options1" value="Rotary Drilling Rig">Rotary Drilling Rig</option>
            <option id="ground_engineering_equipment_option3" class="gee_options1" value="Vibro Hammer">Vibro Hammer</option>
            <option  id="trailor_option1" class="trailor_options1" value="Dumper">Dumper</option>
            <option  id="trailor_option2" class="trailor_options1" value="Truck">Truck</option>
            <option  id="trailor_option3" class="trailor_options1" value="Water Tanker">Water Tanker</option>
            <option id="trailor_option4"  class="trailor_options1" value="Low Bed">Low Bed</option>
            <option id="trailor_option5"  class="trailor_options1" value="Semi Low Bed">Semi Low Bed</option>
            <option  id="trailor_option6" class="trailor_options1" value="Flatbed">Flatbed</option>
            <option  id="trailor_option7" class="trailor_options1" value="Hydraulic Axle">Hydraulic Axle</option>
            <option id="generator_option1" class="generator_options" value="Silent Diesel Generator">Silent Diesel Generator</option>
            <option id="generator_option2" class="generator_options" value="Mobile Light Tower">Mobile Light Tower</option>
            <option id="generator_option3" class="generator_options" value="Diesel Generator">Diesel Generator</option>
        </select>

        </div>
    </div>
    <div class="outer02" id="">
        <div class="trial1">
            <input type="text" placeholder="" name="newfleetmake1" class="input02">
            <label for="" class="placeholder2">Fleet Make</label>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" name="newfleetmodel1" class="input02">
            <label for="" class="placeholder2">Fleet Model</label>
        </div>

    </div>
    <div class="outer02" id="">
        <div class="trial1">
            <input type="text" placeholder="" name="fleetcap2" class="input02">
            <label for="" class="placeholder2">Fleet Capacity</label>
        </div>
        <div class="trial1" id="newfleet_unit">
            <select name="unit2" id="" class="input02">
                <option value=""disabled selected>Unit</option>
                <option value="Ton">Ton</option>
                <option value="Kgs">Kgs</option>
                <option value="KnM">KnM</option>
                <option value="Meter">Meter</option>
                <option value="M³">M³</option>
            </select>
        </div>
        <div class="trial1">
            <input type="number" placeholder="" name="yom2" class="input02" min="1900" max="2099">
            <label for="" class="placeholder2">YOM</label>
        </div>
    </div>
    <div class="outer02" id="">
    <div class="trial1" >
            <input type="text" name="boomLength2"  placeholder="" class=" input02" >
            <label class="placeholder2">Boom Length</label>
        </div>    
        <div class="trial1" >
            <input type="text" name="jibLength2"  placeholder="" class="input02 " >
            <label class="placeholder2">Jib Length</label>
        </div>
        <div class="trial1">
            <input type="text" name="luffingLength2"  placeholder="" class=" input02" >
            <label class="placeholder2">Luffing Length</label>
        </div>
    </div>

    </div>
        <div class="outer02">
        <div class="trial1">
            <input type="number" name="rental2" placeholder="" class="input02">
            <label for="" class="placeholder2">Rental Charges </label>
        </div>
        <div class="trial1">
            <input type="number" name="mob02" placeholder="" class="input02">
            <label for="" class="placeholder2">Mob Charges </label>
        </div>
        <div class="trial1">
            <input type="number" name="demob02" placeholder="" class="input02">
            <label for="" class="placeholder2">Demob Charges </label>
        </div>
        </div>
        <div class="outer02">
        <div class="trial1">
            <input type="text" name="equiplocation02" id="equipmentlocation2" placeholder="" class="input02">
            <label for="" class="placeholder2"> Equipment Location </label>
 
        </div>

        <div class="outer02">
        <div class="trial1">
            <input type="text" placeholder="" name="fuelperltr2" id="fuel_second" class="input02">
            <label for="" class="placeholder2">Fuel Efficiency</label>
        </div>
        <div class="trial1 width150">
        <select name="fuelUnit2" id="unit2" class="input02">
                <option value=""disabled selected>Unit</option>
                <option value="ltrs/hour">ltrs/hour</option>
                <option value="kms/ltrs">kms/ltrs</option>
            </select>

        </div>

        </div>
        <div class="trial1 width400">
            <select name="adblue2" id="adbluedd2" class="input02">
                <option value=""disabled selected>Adblue?</option>
                <option value="Yes">Adblue : Yes</option>
                <option value="No">Adblue : No</option>
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
        <select class="input02 fleet-category" data-dropdown="3" onchange="updateAssetCode(this)" >
            
        <option value="" disabled selected>Select Fleet Category</option>
        <option value="Aerial Work Platform">Aerial Work Platform</option>
        <option value="Concrete Equipment">Concrete Equipment</option>
        <option value="EarthMovers and Road Equipments">EarthMovers and Road Equipments</option>
        <option value="Material Handling Equipments">Material Handling Equipments</option>
        <option value="Ground Engineering Equipments">Ground Engineering Equipments</option>
        <option value="Trailor and Truck">Trailor and Truck</option>
        <option value="Generator and Lighting">Generator and Lighting</option>
    </select>
</div>

    <div class="trial1">
    <!-- <select name="asset_code3" class="input02" onchange="choose_new_equ_third()" id="choose_Ac3"> -->
    <select  name="asset_code3" class="input02 asset-code" data-dropdown="3" id="choose_Ac3" onchange="choose_new_equ_third()" >

        <option value="" disabled selected>Choose Asset Code</option>
        <option value="New Equipment">Choose New Equipment</option>
    </select>
</div>
        </div>
        <div class="availableouter">
        <div class="trial1 width350">
            <select name="avail3" id="availability_dd3" class="input02" onchange="not_immediate3()">
                <option value=""disabled selected>Availability</option>
                <option value="Immediate">Immediate</option>
                <option value="Not Immediate">Select A Date</option>
            </select>
        </div>
        <div class="trial1 width350" id="date_of_availability3" >
            <input type="date" placeholder="" name="date3" class="input02">
            <label for="" class="placeholder2"> Availability Date</label>
        </div>


        </div>
        <div class="prefetch_data_container_second" id="prefetch_third">
        <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" name="yom3" id="yom_third" class="input02">
                <label for="" class="placeholder2">YoM</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="capacity3" id="capacity_third" class="input02">
                <label for="" class="placeholder2">Capacity</label>
            </div>
            <!-- <div class="trial1">
                <input type="text" name="fuel_per_hour" id="fuel_second" class="input02">
                <label for="" class="placeholder2">Fuel/Hour</label>
            </div>
 -->
        </div>
        <div class="outer02">
            <div class="specific-container">
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
            <div class="trial1" id="">
        <input type="text" placeholder="" name="bedlength3" id="bedlength_third" class="input02">
        <label for="" class="placeholder2">Bed Length</label>
    </div>



            </div>
            </div>

        <div class="newequip_details1" id="newequipdet3">
        <div class="outer02" id="" >
        <div class="trial1">
        <select class="input02" name="fleet_category3" id="oem_fleet_type3" onchange="third_equipment()" >
            <option value="" disabled selected>Select Fleet Category</option>
            <option value="Aerial Work Platform">Aerial Work Platform</option>
            <option value="Concrete Equipment">Concrete Equipment</option>
            <option value="EarthMovers and Road Equipments">EarthMovers and Road Equipments</option>
            <!-- <option value="aerial_work_platform">Aerial Work Platform</option> -->
            <option value="Material Handling Equipments">Material Handling Equipments</option>
            <option value="Ground Engineering Equipments">Ground Engineering Equipments</option>
            <option value="Trailor and Truck">Trailor and Truck</option>
            <option value="Generator and Lighting">Generator and Lighting</option>
        </select>

        </div>
        <div class="trial1">
        <select class="input02" name="type3" id="fleet_sub_type3" >
            <option value="" disabled selected>Select Fleet Type</option>
            <option value="Self Propelled Articulated Boomlift"class="awp_options3"  id="aerial_work_platform_option1">Self Propelled Articulated Boomlift</option>
            <option value="Scissor Lift Diesel" class="awp_options3" id="aerial_work_platform_option2">Scissor Lift Diesel</option>
            <option value="Scissor Lift Electric"class="awp_options3"  id="aerial_work_platform_option3">Scissor Lift Electric</option>
            <option value="Spider Lift"class="awp_options3"  id="aerial_work_platform_option4">Spider Lift</option>
            <option value="Self Propelled Straight Boomlift"class="awp_options3"  id="aerial_work_platform_option5">Self Propelled Straight Boomlift</option>
            <option value="Truck Mounted Articulated Boomlift"class="awp_options3"  id="aerial_work_platform_option6">Truck Mounted Articulated Boomlift</option>
            <option value="Truck Mounted Straight Boomlift"class="awp_options3"  id="aerial_work_platform_option7">Truck Mounted Straight Boomlift</option>
            <option value="Batching Plant"class="cq_options3" id="concrete_equipment_option1">Batching Plant</option>
            <option value="Self Loading Mixer"class="cq_options3" id="">Self Loading Mixer</option>
            <option value="Concrete Boom Placer"class="cq_options3" id="concrete_equipment_option2">Concrete Boom Placer</option>
            <option value="Concrete Pump"class="cq_options3" id="concrete_equipment_option3">Concrete Pump</option>
            <option value="Moli Pump"class="cq_options3" id="concrete_equipment_option4">Moli Pump</option>
            <option value="Mobile Batching Plant"class="cq_options3" id="concrete_equipment_option5">Mobile Batching Plant</option>
            <option value="Static Boom Placer"class="cq_options3" id="concrete_equipment_option6">Static Boom Placer</option>
            <option value="Transit Mixer"class="cq_options3" id="concrete_equipment_option7">Transit Mixer</option> 
             <option value="Shotcrete boom"class="cq_options" id="concrete_equipment_option8">Shotcrete boom</option>
            <option value="Baby Roller" class="earthmover_options3" id="earthmovers_option1">Baby Roller</option>
            <option value="Backhoe Loader" class="earthmover_options3" id="earthmovers_option2">Backhoe Loader</option>
            <option value="Bulldozer" class="earthmover_options3" id="earthmovers_option3">Bulldozer</option>
            <option value="Excavator" class="earthmover_options3" id="earthmovers_option4">Excavator</option>
            <option value="Milling Machine" class="earthmover_options3" id="earthmovers_option5">Milling Machine</option>
            <option value="Motor Grader" class="earthmover_options3" id="earthmovers_option6">Motor Grader</option>
            <option value="Pneumatic Tyre Roller" class="earthmover_options3" id="earthmovers_option7">Pneumatic Tyre Roller</option>
            <option value="Single Drum Roller" class="earthmover_options3" id="earthmovers_option8">Single Drum Roller</option>
            <option value="Skid Loader" class="earthmover_options3" id="earthmovers_option9">Skid Loader</option>
            <option value="Slip Form Paver" class="earthmover_options3" id="earthmovers_option10">Slip Form Paver</option>
            <option value="Soil Compactor" class="earthmover_options3" id="earthmovers_option11">Soil Compactor</option>
            <option value="Tandem Roller" class="earthmover_options3" id="earthmovers_option12">Tandem Roller</option>
            <option value="Vibratory Roller" class="earthmover_options3" id="earthmovers_option13">Vibratory Roller</option>
            <option value="Wheeled Excavator" class="earthmover_options3" id="earthmovers_option14">Wheeled Excavator</option>
            <option value="Wheeled Loader" class="earthmover_options3" id="earthmovers_option15">Wheeled Loader</option>
            <option id="mhe_option1"  class="mhe_options3" value="Fixed Tower Crane">Fixed Tower Crane</option>
            <option id="mhe_option2" class="mhe_options3" value="Fork Lift Diesel">Fork Lift Diesel</option>
            <option id="mhe_option3" class="mhe_options3" value="Fork Lift Electric">Fork Lift Electric</option>
            <option id="mhe_option4" class="mhe_options3" value="Hammerhead Tower Crane">Hammerhead Tower Crane</option>
            <option id="mhe_option5" class="mhe_options3" value="Hydraulic Crawler Crane">Hydraulic Crawler Crane</option>
            <option id="mhe_option6" class="mhe_options3" value="Luffing Jib Tower Crane">Luffing Jib Tower Crane</option>
            <option id="mhe_option7" class="mhe_options3" value="Mechanical Crawler Crane">Mechanical Crawler Crane</option>
            <option id="mhe_option8" class="mhe_options3" value="Pick and Carry Crane">Pick and Carry Crane</option>
            <option id="mhe_option9" class="mhe_options3" value="Reach Stacker">Reach Stacker</option>
            <option id="mhe_option10" class="mhe_options3" value="Rough Terrain Crane">Rough Terrain Crane</option>
            <option id="mhe_option11" class="mhe_options3" value="Telehandler">Telehandler</option>
            <option id="mhe_option12" class="mhe_options3" value="Telescopic Crawler Crane">Telescopic Crawler Crane</option>
            <option id="mhe_option13" class="mhe_options3" value="Telescopic Mobile Crane">Telescopic Mobile Crane</option>
            <option id="mhe_option14" class="mhe_options3" value="All Terrain Mobile Crane">All Terrain Mobile Crane</option>
            <option id="mhe_option15" class="mhe_options3" value="Self Loading Truck Crane">Self Loading Truck Crane</option>

            <option id="ground_engineering_equipment_option1" class="gee_options3" value="Hydraulic Drilling Rig">Hydraulic Drilling Rig</option>
            <option id="ground_engineering_equipment_option2" class="gee_options3" value="Rotary Drilling Rig">Rotary Drilling Rig</option>
            <option id="ground_engineering_equipment_option3" class="gee_options3" value="Vibro Hammer">Vibro Hammer</option>
            <option  id="trailor_option1" class="trailor_options3" value="Dumper">Dumper</option>
            <option  id="trailor_option2" class="trailor_options3" value="Truck">Truck</option>
            <option  id="trailor_option3" class="trailor_options3" value="Water Tanker">Water Tanker</option>
            <option id="trailor_option4"  class="trailor_options3" value="Low Bed">Low Bed</option>
            <option id="trailor_option5"  class="trailor_options3" value="Semi Low Bed">Semi Low Bed</option>
            <option  id="trailor_option6" class="trailor_options3" value="Flatbed">Flatbed</option>
            <option  id="trailor_option7" class="trailor_options3" value="Hydraulic Axle">Hydraulic Axle</option>
            <option id="generator_option1" class="generator_options3" value="Silent Diesel Generator">Silent Diesel Generator</option>
            <option id="generator_option2" class="generator_options3" value="Mobile Light Tower">Mobile Light Tower</option>
            <option id="generator_option3" class="generator_options3" value="Diesel Generator">Diesel Generator</option>
        </select>

        </div>
    </div>
    <div class="outer02" id="">
        <div class="trial1">
            <input type="text" placeholder="" name="newfleetmake3" class="input02">
            <label for="" class="placeholder2">Fleet Make</label>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" name="newfleetmodel3" class="input02">
            <label for="" class="placeholder2">Fleet Model</label>
        </div>

    </div>
    <div class="outer02" id="">
        <div class="trial1">
            <input type="text" placeholder="" name="fleetcap3" class="input02">
            <label for="" class="placeholder2">Fleet Capacity</label>
        </div>
        <div class="trial1" id="newfleet_unit">
            <select name="unit3" id="" class="input02">
                <option value=""disabled selected>Unit</option>
                <option value="Ton">Ton</option>
                <option value="Kgs">Kgs</option>
                <option value="KnM">KnM</option>
                <option value="Meter">Meter</option>
                <option value="M³">M³</option>
            </select>
        </div>
        <div class="trial1">
            <input type="number" placeholder="" name="newyom3" class="input02" min="1900" max="2099">
            <label for="" class="placeholder2">YOM</label>
        </div>
    </div>
    <div class="outer02" id="">
    <div class="trial1" >
            <input type="text" name="boomLength3"  placeholder="" class=" input02" >
            <label class="placeholder2">Boom Length</label>
        </div>    
        <div class="trial1" >
            <input type="text" name="jibLength3"  placeholder="" class="input02 " >
            <label class="placeholder2">Jib Length</label>
        </div>
        <div class="trial1">
            <input type="text" name="luffingLength3"  placeholder="" class=" input02" >
            <label class="placeholder2">Luffing Length</label>
        </div>
    </div>

    </div>
        <div class="outer02">
        <div class="trial1">
            <input type="number" name="rental3" placeholder="" class="input02">
            <label for="" class="placeholder2">Rental Charges </label>
        </div>
        <div class="trial1">
            <input type="number" name="mob03" placeholder="" class="input02">
            <label for="" class="placeholder2">Mob Charges </label>
        </div>
        <div class="trial1">
            <input type="number" name="demob03" placeholder="" class="input02">
            <label for="" class="placeholder2">Demob Charges </label>
        </div>
        </div>
        <div class="outer02">
        <div class="trial1">
            <input type="text" name="equiplocation03" id="equiplocation03" placeholder="" class="input02">
            <label for="" class="placeholder2"> Equipment Location </label>
 
        </div>
        <div class="outer02">
        <div class="trial1">
            <input type="text" placeholder="" name="fuelperltr3" id="fuel_third" class="input02">
            <label for="" class="placeholder2">Fuel Efficiency</label>
        </div>
        <div class="trial1 width150">
        <select name="fuelUnit3" id="unit3" class="input02">
                <option value=""disabled selected>Unit</option>
                <option value="ltrs/hour">ltrs/hour</option>
                <option value="kms/ltrs">kms/ltrs</option>
            </select>

        </div>


        </div>
        <div class="trial1 width400">
            <select name="adblue3" id="adbluedd3" class="input02">
                <option value=""disabled selected>Adblue?</option>
                <option value="Yes">Adblue : Yes</option>
                <option value="No">Adblue : No</option>
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
        <select class="input02 fleet-category" data-dropdown="4" onchange="updateAssetCode(this)" >
            
        <option value="" disabled selected>Select Fleet Category</option>
        <option value="Aerial Work Platform">Aerial Work Platform</option>
        <option value="Concrete Equipment">Concrete Equipment</option>
        <option value="EarthMovers and Road Equipments">EarthMovers and Road Equipments</option>
        <option value="Material Handling Equipments">Material Handling Equipments</option>
        <option value="Ground Engineering Equipments">Ground Engineering Equipments</option>
        <option value="Trailor and Truck">Trailor and Truck</option>
        <option value="Generator and Lighting">Generator and Lighting</option>
    </select>
</div>

    <div class="trial1">
    <!-- <select name="asset_code4" class="input02" onchange="choose_new_equ_fourth()" id="choose_Ac4"> -->
    <select  name="asset_code4" class="input02 asset-code" data-dropdown="4" id="choose_Ac4" onchange="choose_new_equ_fourth()" >

        <option value="" disabled selected>Choose Asset Code</option>
        <option value="New Equipment">Choose New Equipment</option>
    </select>
</div>

        </div>
        <div class="availableouter">
        <div class="trial1 width350">
            <select name="avail4" id="availability_dd4" class="input02" onchange="not_immediate4()">
                <option value=""disabled selected>Availability</option>
                <option value="Immediate">Immediate</option>
                <option value="Not Immediate">Select A Date</option>
            </select>
        </div>
        <div class="trial1 width350" id="date_of_availability4" >
            <input type="date" placeholder="" name="date4" class="input02">
            <label for="" class="placeholder2"> Availability Date</label>
        </div>

        </div>
        <div class="prefetch_data_container_second" id="prefetch_fourth">
        <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" name="yom4" id="yom_fourth" class="input02">
                <label for="" class="placeholder2">YoM</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="capacity4" id="capacity_fourth" class="input02">
                <label for="" class="placeholder2">Capacity</label>
            </div>
            <!-- <div class="trial1">
                <input type="text" name="fuel_per_hour" id="fuel_second" class="input02">
                <label for="" class="placeholder2">Fuel/Hour</label>
            </div>
 -->
        </div>
        <div class="outer02">
        <div class="specific-container">

            <div class="trial1">
                <input type="text" placeholder="" name="boom4" id="boomlength_fourth" class="input02">
                <label for="" class="placeholder2">Boom Length</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="jib4" id="jiblength_fourth" class="input02">
                <label for="" class="placeholder2">Jib Length</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="luffing4" id="luffinglength_fourth" class="input02">
                <label for="" class="placeholder2">Luffing Length</label>
            </div>

            

            </div>
            <div class="trial1" id="">
        <input type="text" placeholder="" name="bedlength4" id="bedlength_fourth" class="input02">
        <label for="" class="placeholder2">Bed Length</label>
    </div>
    </div>


            </div>

        <div class="newequip_details1" id="newequipdet4">
        <div class="outer02" id="" >
        <div class="trial1">
        <select class="input02" name="fleet_category4" id="oem_fleet_type4" onchange="fourth_equipment()" >
            <option value="" disabled selected>Select Fleet Category</option>
            <option value="Aerial Work Platform">Aerial Work Platform</option>
            <option value="Concrete Equipment">Concrete Equipment</option>
            <option value="EarthMovers and Road Equipments">EarthMovers and Road Equipments</option>
            <!-- <option value="aerial_work_platform">Aerial Work Platform</option> -->
            <option value="Material Handling Equipments">Material Handling Equipments</option>
            <option value="Ground Engineering Equipments">Ground Engineering Equipments</option>
            <option value="Trailor and Truck">Trailor and Truck</option>
            <option value="Generator and Lighting">Generator and Lighting</option>
        </select>

        </div>
        <div class="trial1">
        <select class="input02" name="type4" id="fleet_sub_type4" >
            <option value="" disabled selected>Select Fleet Type</option>
            <option value="Self Propelled Articulated Boomlift"class="awp_options4"  id="aerial_work_platform_option1">Self Propelled Articulated Boomlift</option>
            <option value="Scissor Lift Diesel" class="awp_options4" id="aerial_work_platform_option2">Scissor Lift Diesel</option>
            <option value="Scissor Lift Electric"class="awp_options4"  id="aerial_work_platform_option3">Scissor Lift Electric</option>
            <option value="Spider Lift"class="awp_options4"  id="aerial_work_platform_option4">Spider Lift</option>
            <option value="Self Propelled Straight Boomlift"class="awp_options4"  id="aerial_work_platform_option5">Self Propelled Straight Boomlift</option>
            <option value="Truck Mounted Articulated Boomlift"class="awp_options4"  id="aerial_work_platform_option6">Truck Mounted Articulated Boomlift</option>
            <option value="Truck Mounted Straight Boomlift"class="awp_options4"  id="aerial_work_platform_option7">Truck Mounted Straight Boomlift</option>
            <option value="Batching Plant"class="cq_options4" id="concrete_equipment_option1">Batching Plant</option>
            <option value="Self Loading Mixer"class="cq_options4" id="">Self Loading Mixer</option>
            <option value="Concrete Boom Placer"class="cq_options4" id="concrete_equipment_option2">Concrete Boom Placer</option>
            <option value="Concrete Pump"class="cq_options4" id="concrete_equipment_option3">Concrete Pump</option>
            <option value="Moli Pump"class="cq_options4" id="concrete_equipment_option4">Moli Pump</option>
            <option value="Mobile Batching Plant"class="cq_options4" id="concrete_equipment_option5">Mobile Batching Plant</option>
            <option value="Static Boom Placer"class="cq_options4" id="concrete_equipment_option6">Static Boom Placer</option>
            <option value="Transit Mixer"class="cq_options4" id="concrete_equipment_option7">Transit Mixer</option> 
             <option value="Shotcrete boom"class="cq_options" id="concrete_equipment_option8">Shotcrete boom</option>
            <option value="Baby Roller" class="earthmover_options4" id="earthmovers_option1">Baby Roller</option>
            <option value="Backhoe Loader" class="earthmover_options4" id="earthmovers_option2">Backhoe Loader</option>
            <option value="Bulldozer" class="earthmover_options4" id="earthmovers_option3">Bulldozer</option>
            <option value="Excavator" class="earthmover_options4" id="earthmovers_option4">Excavator</option>
            <option value="Milling Machine" class="earthmover_options4" id="earthmovers_option5">Milling Machine</option>
            <option value="Motor Grader" class="earthmover_options4" id="earthmovers_option6">Motor Grader</option>
            <option value="Pneumatic Tyre Roller" class="earthmover_options4" id="earthmovers_option7">Pneumatic Tyre Roller</option>
            <option value="Single Drum Roller" class="earthmover_options4" id="earthmovers_option8">Single Drum Roller</option>
            <option value="Skid Loader" class="earthmover_options4" id="earthmovers_option9">Skid Loader</option>
            <option value="Slip Form Paver" class="earthmover_options4" id="earthmovers_option10">Slip Form Paver</option>
            <option value="Soil Compactor" class="earthmover_options4" id="earthmovers_option11">Soil Compactor</option>
            <option value="Tandem Roller" class="earthmover_options4" id="earthmovers_option12">Tandem Roller</option>
            <option value="Vibratory Roller" class="earthmover_options4" id="earthmovers_option13">Vibratory Roller</option>
            <option value="Wheeled Excavator" class="earthmover_options4" id="earthmovers_option14">Wheeled Excavator</option>
            <option value="Wheeled Loader" class="earthmover_options4" id="earthmovers_option15">Wheeled Loader</option>
            <option id="mhe_option1"  class="mhe_options4" value="Fixed Tower Crane">Fixed Tower Crane</option>
            <option id="mhe_option2" class="mhe_options4" value="Fork Lift Diesel">Fork Lift Diesel</option>
            <option id="mhe_option3" class="mhe_options4" value="Fork Lift Electric">Fork Lift Electric</option>
            <option id="mhe_option4" class="mhe_options4" value="Hammerhead Tower Crane">Hammerhead Tower Crane</option>
            <option id="mhe_option5" class="mhe_options4" value="Hydraulic Crawler Crane">Hydraulic Crawler Crane</option>
            <option id="mhe_option6" class="mhe_options4" value="Luffing Jib Tower Crane">Luffing Jib Tower Crane</option>
            <option id="mhe_option7" class="mhe_options4" value="Mechanical Crawler Crane">Mechanical Crawler Crane</option>
            <option id="mhe_option8" class="mhe_options4" value="Pick and Carry Crane">Pick and Carry Crane</option>
            <option id="mhe_option9" class="mhe_options4" value="Reach Stacker">Reach Stacker</option>
            <option id="mhe_option10" class="mhe_options4" value="Rough Terrain Crane">Rough Terrain Crane</option>
            <option id="mhe_option11" class="mhe_options4" value="Telehandler">Telehandler</option>
            <option id="mhe_option12" class="mhe_options4" value="Telescopic Crawler Crane">Telescopic Crawler Crane</option>
            <option id="mhe_option13" class="mhe_options4" value="Telescopic Mobile Crane">Telescopic Mobile Crane</option>
            <option id="mhe_option14" class="mhe_options4" value="All Terrain Mobile Crane">All Terrain Mobile Crane</option>
            <option id="mhe_option15" class="mhe_options4" value="Self Loading Truck Crane">Self Loading Truck Crane</option>

            <option  class="gee_options4" value="Hydraulic Drilling Rig">Hydraulic Drilling Rig</option>
            <option  class="gee_options4" value="Rotary Drilling Rig">Rotary Drilling Rig</option>
            <option  class="gee_options4" value="Vibro Hammer">Vibro Hammer</option>
            <option  id="trailor_option1" class="trailor_options4" value="Dumper">Dumper</option>
            <option  id="trailor_option2" class="trailor_options4" value="Truck">Truck</option>
            <option  id="trailor_option3" class="trailor_options4" value="Water Tanker">Water Tanker</option>
            <option id="trailor_option4"  class="trailor_options4" value="Low Bed">Low Bed</option>
            <option id="trailor_option5"  class="trailor_options4" value="Semi Low Bed">Semi Low Bed</option>
            <option  id="trailor_option6" class="trailor_options4" value="Flatbed">Flatbed</option>
            <option  id="trailor_option7" class="trailor_options4" value="Hydraulic Axle">Hydraulic Axle</option>
            <option id="generator_option1" class="generator_options4" value="Silent Diesel Generator">Silent Diesel Generator</option>
            <option id="generator_option2" class="generator_options4" value="Mobile Light Tower">Mobile Light Tower</option>
            <option id="generator_option3" class="generator_options4" value="Diesel Generator">Diesel Generator</option>
        </select>

        </div>
    </div>
    <div class="outer02" id="">
        <div class="trial1">
            <input type="text" placeholder="" name="newfleetmake4" class="input02">
            <label for="" class="placeholder2">Fleet Make</label>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" name="newfleetmodel4" class="input02">
            <label for="" class="placeholder2">Fleet Model</label>
        </div>

    </div>
    <div class="outer02" id="">
        <div class="trial1">
            <input type="text" placeholder="" name="fleetcap4" class="input02">
            <label for="" class="placeholder2">Fleet Capacity</label>
        </div>
        <div class="trial1" id="newfleet_unit">
            <select name="unit4" id="" class="input02">
                <option value=""disabled selected>Unit</option>
                <option value="Ton">Ton</option>
                <option value="Kgs">Kgs</option>
                <option value="KnM">KnM</option>
                <option value="Meter">Meter</option>
                <option value="M³">M³</option>
            </select>
        </div>
        <div class="trial1">
            <input type="number" placeholder="" name="newyom4" class="input02" min="1900" max="2099">
            <label for="" class="placeholder2">YOM</label>
        </div>
    </div>
    <div class="outer02" id="">
    <div class="trial1" >
            <input type="text" name="boomLength4"  placeholder="" class=" input02" >
            <label class="placeholder2">Boom Length</label>
        </div>    
        <div class="trial1" >
            <input type="text" name="jibLength4"  placeholder="" class="input02 " >
            <label class="placeholder2">Jib Length</label>
        </div>
        <div class="trial1">
            <input type="text" name="luffingLength4"  placeholder="" class=" input02" >
            <label class="placeholder2">Luffing Length</label>
        </div>
    </div>

    </div>
        <div class="outer02">
        <div class="trial1">
            <input type="number" name="rental4" placeholder="" class="input02">
            <label for="" class="placeholder2">Rental Charges </label>
        </div>
        <div class="trial1">
            <input type="number" name="mob04" placeholder="" class="input02">
            <label for="" class="placeholder2">Mob Charges </label>
        </div>
        <div class="trial1">
            <input type="number" name="demob04" placeholder="" class="input02">
            <label for="" class="placeholder2">Demob Charges </label>
        </div>
        </div>
        <div class="outer02">
        <div class="trial1">
            <input type="text" name="equiplocation04" id="equiplocation04" placeholder="" class="input02">
            <label for="" class="placeholder2"> Equipment Location </label>
 
        </div>
        <div class="outer02">
        <div class="trial1">
            <input type="text" placeholder="" name="fuelperltr4" id="fuel_fourth" class="input02">
            <label for="" class="placeholder2">Fuel Efficiency</label>
        </div>
        <div class="trial1 width150">
        <select name="fuelUnit4" id="unit4" class="input02">
                <option value=""disabled selected>Unit</option>
                <option value="ltrs/hour">ltrs/hour</option>
                <option value="kms/ltrs">kms/ltrs</option>
            </select>

        </div>
        </div>

        <div class="trial1 width400">
            <select name="adblue4" id="adbluedd4" class="input02">
                <option value=""disabled selected>Adblue?</option>
                <option value="Yes">Adblue : Yes</option>
                <option value="No">Adblue : No</option>
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
        <select class="input02 fleet-category" data-dropdown="5" onchange="updateAssetCode(this)" >
            
        <option value="" disabled selected>Select Fleet Category</option>
        <option value="Aerial Work Platform">Aerial Work Platform</option>
        <option value="Concrete Equipment">Concrete Equipment</option>
        <option value="EarthMovers and Road Equipments">EarthMovers and Road Equipments</option>
        <option value="Material Handling Equipments">Material Handling Equipments</option>
        <option value="Ground Engineering Equipments">Ground Engineering Equipments</option>
        <option value="Trailor and Truck">Trailor and Truck</option>
        <option value="Generator and Lighting">Generator and Lighting</option>
    </select>
</div>

    <div class="trial1">
    <!-- <select name="asset_code5" class="input02" onchange="choose_new_equ_fifth()" id="choose_Ac5"> -->
    <select  name="asset_code5" class="input02 asset-code" data-dropdown="5" id="choose_Ac5" onchange="choose_new_equ_fifth()" >

        <option value="" disabled selected>Choose Asset Code</option>
        <option value="New Equipment">Choose New Equipment</option>
    </select>
</div>

        </div>
        <div class="availableouter">
        <div class="trial1 width350">
            <select name="avail5" id="availability_dd5" class="input02" onchange="not_immediate5()">
                <option value=""disabled selected>Availability</option>
                <option value="Immediate">Immediate</option>
                <option value="Not Immediate">Select A Date</option>
            </select>
        </div>
        <div class="trial1 width350" id="date_of_availability5" >
            <input type="date" placeholder="" name="date5" class="input02">
            <label for="" class="placeholder2"> Availability Date</label>
        </div>

        </div>
        <div class="prefetch_data_container_second" id="prefetch_fifth">
        <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" name="yom5" id="yom_fifth" class="input02">
                <label for="" class="placeholder2">YoM</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="capacity5" id="capacity_fifth" class="input02">
                <label for="" class="placeholder2">Capacity</label>
            </div>
            <!-- <div class="trial1">
                <input type="text" name="fuel_per_hour" id="fuel_second" class="input02">
                <label for="" class="placeholder2">Fuel/Hour</label>
            </div>
 -->
        </div>
        <div class="outer02">
        <div class="specific-container">

            <div class="trial1">
                <input type="text" placeholder="" name="boom5" id="boomlength_fifth" class="input02">
                <label for="" class="placeholder2">Boom Length</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="jib5" id="jiblength_fifth" class="input02">
                <label for="" class="placeholder2">Jib Length</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="luffing5" id="luffinglength_fifth" class="input02">
                <label for="" class="placeholder2">Luffing Length</label>
            </div>


            </div>
            <div class="trial1" id="">
        <input type="text" placeholder="" name="bedlength5" id="bedlength_fifth" class="input02">
        <label for="" class="placeholder2">Bed Length</label>
    </div>

            </div>
            </div>

        <div class="newequip_details1" id="newequipdet5">
        <div class="outer02" id="" >
        <div class="trial1">
        <select class="input02" name="fleet_category5" id="oem_fleet_type5" onchange="fifth_equipment()" >
            <option value="" disabled selected>Select Fleet Category</option>
            <option value="Aerial Work Platform">Aerial Work Platform</option>
            <option value="Concrete Equipment">Concrete Equipment</option>
            <option value="EarthMovers and Road Equipments">EarthMovers and Road Equipments</option>
            <!-- <option value="aerial_work_platform">Aerial Work Platform</option> -->
            <option value="Material Handling Equipments">Material Handling Equipments</option>
            <option value="Ground Engineering Equipments">Ground Engineering Equipments</option>
            <option value="Trailor and Truck">Trailor and Truck</option>
            <option value="Generator and Lighting">Generator and Lighting</option>
        </select>

        </div>
        <div class="trial1">
        <select class="input02" name="type5" id="fleet_sub_type1" >
            <option value="" disabled selected>Select Fleet Type</option>
            <option value="Self Propelled Articulated Boomlift"class="awp_options5"  id="aerial_work_platform_option1">Self Propelled Articulated Boomlift</option>
            <option value="Scissor Lift Diesel" class="awp_options5" id="aerial_work_platform_option2">Scissor Lift Diesel</option>
            <option value="Scissor Lift Electric"class="awp_options5"  id="aerial_work_platform_option3">Scissor Lift Electric</option>
            <option value="Spider Lift"class="awp_options5"  id="aerial_work_platform_option4">Spider Lift</option>
            <option value="Self Propelled Straight Boomlift"class="awp_options5"  id="aerial_work_platform_option5">Self Propelled Straight Boomlift</option>
            <option value="Truck Mounted Articulated Boomlift"class="awp_options5"  id="aerial_work_platform_option6">Truck Mounted Articulated Boomlift</option>
            <option value="Truck Mounted Straight Boomlift"class="awp_options5"  id="aerial_work_platform_option7">Truck Mounted Straight Boomlift</option>
            <option value="Batching Plant"class="cq_options5" id="concrete_equipment_option1">Batching Plant</option>
            <option value="Self Loading Mixer"class="cq_options5" id="">Self Loading Mixer</option>
            <option value="Concrete Boom Placer"class="cq_options5" id="concrete_equipment_option2">Concrete Boom Placer</option>
            <option value="Concrete Pump"class="cq_options5" id="concrete_equipment_option3">Concrete Pump</option>
            <option value="Moli Pump"class="cq_options5" id="concrete_equipment_option4">Moli Pump</option>
            <option value="Mobile Batching Plant"class="cq_options5" id="concrete_equipment_option5">Mobile Batching Plant</option>
            <option value="Static Boom Placer"class="cq_options5" id="concrete_equipment_option6">Static Boom Placer</option>
            <option value="Transit Mixer"class="cq_options5" id="concrete_equipment_option7">Transit Mixer</option> 
             <option value="Shotcrete boom"class="cq_options" id="concrete_equipment_option8">Shotcrete boom</option>
            <option value="Baby Roller" class="earthmover_options5" id="earthmovers_option1">Baby Roller</option>
            <option value="Backhoe Loader" class="earthmover_options5" id="earthmovers_option2">Backhoe Loader</option>
            <option value="Bulldozer" class="earthmover_options5" id="earthmovers_option3">Bulldozer</option>
            <option value="Excavator" class="earthmover_options5" id="earthmovers_option4">Excavator</option>
            <option value="Milling Machine" class="earthmover_options5" id="earthmovers_option5">Milling Machine</option>
            <option value="Motor Grader" class="earthmover_options5" id="earthmovers_option6">Motor Grader</option>
            <option value="Pneumatic Tyre Roller" class="earthmover_options5" id="earthmovers_option7">Pneumatic Tyre Roller</option>
            <option value="Single Drum Roller" class="earthmover_options5" id="earthmovers_option8">Single Drum Roller</option>
            <option value="Skid Loader" class="earthmover_options5" id="earthmovers_option9">Skid Loader</option>
            <option value="Slip Form Paver" class="earthmover_options5" id="earthmovers_option10">Slip Form Paver</option>
            <option value="Soil Compactor" class="earthmover_options5" id="earthmovers_option11">Soil Compactor</option>
            <option value="Tandem Roller" class="earthmover_options5" id="earthmovers_option12">Tandem Roller</option>
            <option value="Vibratory Roller" class="earthmover_options5" id="earthmovers_option13">Vibratory Roller</option>
            <option value="Wheeled Excavator" class="earthmover_options5" id="earthmovers_option14">Wheeled Excavator</option>
            <option value="Wheeled Loader" class="earthmover_options5" id="earthmovers_option15">Wheeled Loader</option>
            <option id="mhe_option1"  class="mhe_options5" value="Fixed Tower Crane">Fixed Tower Crane</option>
            <option id="mhe_option2" class="mhe_options5" value="Fork Lift Diesel">Fork Lift Diesel</option>
            <option id="mhe_option3" class="mhe_options5" value="Fork Lift Electric">Fork Lift Electric</option>
            <option id="mhe_option4" class="mhe_options5" value="Hammerhead Tower Crane">Hammerhead Tower Crane</option>
            <option id="mhe_option5" class="mhe_options5" value="Hydraulic Crawler Crane">Hydraulic Crawler Crane</option>
            <option id="mhe_option6" class="mhe_options5" value="Luffing Jib Tower Crane">Luffing Jib Tower Crane</option>
            <option id="mhe_option7" class="mhe_options5" value="Mechanical Crawler Crane">Mechanical Crawler Crane</option>
            <option id="mhe_option8" class="mhe_options5" value="Pick and Carry Crane">Pick and Carry Crane</option>
            <option id="mhe_option9" class="mhe_options5" value="Reach Stacker">Reach Stacker</option>
            <option id="mhe_option10" class="mhe_options5" value="Rough Terrain Crane">Rough Terrain Crane</option>
            <option id="mhe_option11" class="mhe_options5" value="Telehandler">Telehandler</option>
            <option id="mhe_option12" class="mhe_options5" value="Telescopic Crawler Crane">Telescopic Crawler Crane</option>
            <option id="mhe_option13" class="mhe_options5" value="Telescopic Mobile Crane">Telescopic Mobile Crane</option>
            <option id="mhe_option14" class="mhe_options5" value="All Terrain Mobile Crane">All Terrain Mobile Crane</option>
            <option id="mhe_option15" class="mhe_options5" value="Self Loading Truck Crane">Self Loading Truck Crane</option>

            <option id="ground_engineering_equipment_option1" class="gee_options5" value="Hydraulic Drilling Rig">Hydraulic Drilling Rig</option>
            <option id="ground_engineering_equipment_option2" class="gee_options5" value="Rotary Drilling Rig">Rotary Drilling Rig</option>
            <option id="ground_engineering_equipment_option3" class="gee_options5" value="Vibro Hammer">Vibro Hammer</option>
            <option  id="trailor_option1" class="trailor_options5" value="Dumper">Dumper</option>
            <option  id="trailor_option2" class="trailor_options5" value="Truck">Truck</option>
            <option  id="trailor_option3" class="trailor_options5" value="Water Tanker">Water Tanker</option>
            <option id="trailor_option4"  class="trailor_options5" value="Low Bed">Low Bed</option>
            <option id="trailor_option5"  class="trailor_options5" value="Semi Low Bed">Semi Low Bed</option>
            <option  id="trailor_option6" class="trailor_options5" value="Flatbed">Flatbed</option>
            <option  id="trailor_option7" class="trailor_options5" value="Hydraulic Axle">Hydraulic Axle</option>
            <option id="generator_option1" class="generator_options5" value="Silent Diesel Generator">Silent Diesel Generator</option>
            <option id="generator_option2" class="generator_options5" value="Mobile Light Tower">Mobile Light Tower</option>
            <option id="generator_option3" class="generator_options5" value="Diesel Generator">Diesel Generator</option>
        </select>

        </div>
    </div>
    <div class="outer02" id="">
        <div class="trial1">
            <input type="text" placeholder="" name="newfleetmake5" class="input02">
            <label for="" class="placeholder2">Fleet Make</label>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" name="newfleetmodel5" class="input02">
            <label for="" class="placeholder2">Fleet Model</label>
        </div>

    </div>
    <div class="outer02" id="">
        <div class="trial1">
            <input type="text" placeholder="" name="fleetcap5" class="input02">
            <label for="" class="placeholder2">Fleet Capacity</label>
        </div>
        <div class="trial1" id="newfleet_unit">
            <select name="unit2" id="" class="input02">
                <option value=""disabled selected>Unit</option>
                <option value="Ton">Ton</option>
                <option value="Kgs">Kgs</option>
                <option value="KnM">KnM</option>
                <option value="Meter">Meter</option>
                <option value="M³">M³</option>
            </select>
        </div>
        <div class="trial1">
            <input type="number" placeholder="" name="newyom5" class="input02" min="1900" max="2099">
            <label for="" class="placeholder2">YOM</label>
        </div>
    </div>
    <div class="outer02" id="">
    <div class="trial1" >
            <input type="text" name="boomLength5"  placeholder="" class=" input02" >
            <label class="placeholder2">Boom Length</label>
        </div>    
        <div class="trial1" >
            <input type="text" name="jibLength5"  placeholder="" class="input02 " >
            <label class="placeholder2">Jib Length</label>
        </div>
        <div class="trial1">
            <input type="text" name="luffingLength5"  placeholder="" class=" input02" >
            <label class="placeholder2">Luffing Length</label>
        </div>
    </div>

    </div>
        <div class="outer02">
        <div class="trial1">
            <input type="number" name="rental5" placeholder="" class="input02">
            <label for="" class="placeholder2">Rental Charges </label>
        </div>
        <div class="trial1">
            <input type="number" name="mob05" placeholder="" class="input02">
            <label for="" class="placeholder2">Mob Charges </label>
        </div>
        <div class="trial1">
            <input type="number" name="demob05" placeholder="" class="input02">
            <label for="" class="placeholder2">Demob Charges </label>
        </div>
        </div>
        <div class="outer02">
        <div class="trial1">
            <input type="text" name="equiplocation05" id="equiplocation05" placeholder="" class="input02">
            <label for="" class="placeholder2"> Equipment Location </label>
 
        </div>
        <div class="outer02">
        <div class="trial1">
            <input type="text" placeholder="" name="fuelperltr5" id="fuel_fifth" class="input02">
            <label for="" class="placeholder2">Fuel Efficiency</label>
        </div>
        <div class="trial1 width150">
        <select name="fuelUnit5" id="unit5" class="input02">
                <option value=""disabled selected>Unit</option>
                <option value="ltrs/hour">ltrs/hour</option>
                <option value="kms/ltrs">kms/ltrs</option>
            </select>

        </div>

        </div>
        <div class="trial1 width400">
            <select name="adblue5" id="adbluedd5" class="input02">
                <option value=""disabled selected>Adblue?</option>
                <option value="Yes">Adblue : Yes</option>
                <option value="No">Adblue : No</option>
            </select>
        </div>
        </div>
        <!-- <div class="addbuttonicon" id="lastaddequipbtn"><i onclick="addanother_equip()"  class="bi bi-plus-circle"></i><p>Add Another Equipment</p></div> -->
        </div>

        <h5>Sender Name Not In List ? <a href="quote_subuser.php">Add Team Members Here</a> </h5>
        <div class="outer02">
        <div class="trial1">
        <select name="sender" id="contactperson_logistic_need"  class="input02" required>
    <option value="" disabled selected>Select Sender's Name</option>
    <?php
    while ($row_sender_name = mysqli_fetch_assoc($result_sender_name)) {
        echo '<option value="' . $row_sender_name['name'] . '">' . $row_sender_name['name'] . '</option>';
    }
    ?>
</select>
    </div>
    <div class="trial1 width450">
        <input type="text" placeholder="" id="contact_person_number" name="contactnumbersender" class="input02">
        <label for="" class="placeholder2">Contact Number</label>
    </div>
    <div class="trial1 ">
        <input type="text" placeholder="" id="contact_person_email" name="contactemailsender" class="input02">
        <label for="" class="placeholder2">Contact Email</label>
    </div>
<input type="text" id="logistics_need_rental" value="<?php echo $companyname001 ?>" hidden>
    </div>
<div class="fulllength" id="quotationnextback">
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
<?php
include "partials/_dbconnect.php";
$companyname001=$_SESSION['companyname'];
$lastquotation="SELECT * FROM `quotation_generated` where company_name='$companyname001' order by `ref_no` desc LIMIT 1";
$lastquoteresult=mysqli_query($conn,$lastquotation);
if(mysqli_num_rows($lastquoteresult)>0){
    $lastrow=mysqli_fetch_assoc($lastquoteresult);
}
else{
    $lastrow=array();
}


?>
<p class="terms_condition">
    <strong>1.Working Shift :</strong>Start time to be
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
    <strong>2.Breakdown :</strong> 
    <select name="breakdown_select" id="breakdown_select">
        <option <?php if(isset($lastrow['brkdown']) && $lastrow['brkdown']==='Free time - not applicable'){ echo 'selected';} ?> value="Free time - not applicable">Free time - not applicable</option>
        <option <?php if(isset($lastrow['brkdown']) && $lastrow['brkdown']==='Free time - first 6 hours'){ echo 'selected';} ?> value="Free time - first 6 hours" default selected>Free time - first 6 hours</option>
        <option <?php if(isset($lastrow['brkdown']) && $lastrow['brkdown']==='Free time - first 12 hours'){ echo 'selected';} ?> value="Free time - first 12 hours">Free time - first 12 hours</option>
    </select> 
    After free time, breakdown charges to be deducted on pro-rata basis
</p>
<p class="terms_condition" >
    <strong>3.Operating Crew :</strong> 
    <select name="operating_crew_select" id="operating_crew_select">
        <option <?php if(isset($lastrow['crew']) && $lastrow['crew']==='Single Operator'){ echo 'selected';} ?> value="Single Operator">Single Operator</option>
        <option <?php if(isset($lastrow['crew']) && $lastrow['crew']==='Double Operator'){ echo 'selected';} ?> value="Double Operator">Double Operator</option>
        <option <?php if(isset($lastrow['crew']) && $lastrow['crew']==='Single Operator + Helper'){ echo 'selected';} ?> value="Single Operator + Helper">Single Operator + Helper</option>
        <option <?php if(isset($lastrow['crew']) && $lastrow['crew']==='Double Operator + Helper'){ echo 'selected';} ?> value="Double Operator + Helper">Double Operator + Helper</option>
    </select>
    &nbsp
    <strong>4.Operator Room Scope :</strong> 
    <select name="operator_room_scope_select" id="operator_room_scope_select">
        <option <?php if(isset($lastrow['room']) && $lastrow['room']==='Not Applicable'){ echo 'selected';} ?> value="Not Applicable">Not Applicable</option>
        <option <?php if(isset($lastrow['room']) && $lastrow['room']==='In Client Scope'){ echo 'selected';} ?> value="In Client Scope" default selected>In Client Scope</option>
        <option <?php if(isset($lastrow['room']) && $lastrow['room']==='In Rental Company Scope'){ echo 'selected';} ?> value="In Rental Company Scope">In Rental Co Scope</option>
    </select>

</p>
<p class="terms_condition">
</p>
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
</p>
<p class="terms_condition">
    <strong>7.Fuel :</strong>Fuel shall be issued as per OEM norms by 
    <select name="fuel_scope" id="">
        <option <?php if(isset($lastrow['fuel_scope']) && $lastrow['fuel_scope']==='Client'){ echo 'selected';} ?> value="Client" >Client </option>
        <option <?php if(isset($lastrow['fuel_scope']) && $lastrow['fuel_scope']==='Rental Company'){ echo 'selected';} ?> value="Rental Company">Rental Company</option>
    </select>
</p>
<p class="terms_condition"><strong>8.Adblue :</strong>Adblue if required to be provided by
<select name="adblue_scope" id="">
<option <?php if(isset($lastrow['adblue_scope']) && $lastrow['adblue_scope']==='Not applicable'){ echo 'selected';} ?> value="Not applicable">Not Applicable</option>

        <option <?php if(isset($lastrow['adblue_scope']) && $lastrow['adblue_scope']==='Client'){ echo 'selected';} ?> value="Client">Client </option>
        <option <?php if(isset($lastrow['adblue_scope']) && $lastrow['adblue_scope']==='Rental Company'){ echo 'selected';} ?> value="Rental Company">Rental Company</option>
    </select>

</p>
<p class="terms_condition">
    <strong>9.Contract Period :</strong> Minimum Order Shall Be 
    <select name="contract_period_select" id="contract_period_select">
        <option <?php if(isset($lastrow['period_contract']) && $lastrow['period_contract']==='1 Month'){ echo 'selected';} ?> value="1 Month">1 Month</option>
        <option <?php if(isset($lastrow['period_contract']) && $lastrow['period_contract']==='2 Month'){ echo 'selected';} ?> value="2 Month">2 Months</option>
        <option <?php if(isset($lastrow['period_contract']) && $lastrow['period_contract']==='3 Month'){ echo 'selected';} ?> value="3 Month">3 Months</option>
        <option <?php if(isset($lastrow['period_contract']) && $lastrow['period_contract']==='6 Month'){ echo 'selected';} ?> value="6 Month">6 Months</option>
        <option <?php if(isset($lastrow['period_contract']) && $lastrow['period_contract']==='7 Month'){ echo 'selected';} ?> value="7 Month">7 Months</option>
        <option <?php if(isset($lastrow['period_contract']) && $lastrow['period_contract']==='9 Month'){ echo 'selected';} ?> value="9 Month">9 Months</option>
        <option <?php if(isset($lastrow['period_contract']) && $lastrow['period_contract']==='10 Month'){ echo 'selected';} ?> value="10 Month">10 Months</option>
        <option <?php if(isset($lastrow['period_contract']) && $lastrow['period_contract']==='12 Month'){ echo 'selected';} ?> value="12 Month">12 Months</option>
        <option <?php if(isset($lastrow['period_contract']) && $lastrow['period_contract']==='15 Month'){ echo 'selected';} ?> value="15 Month">15 Months</option>
        <option <?php if(isset($lastrow['period_contract']) && $lastrow['period_contract']==='18 Month'){ echo 'selected';} ?> value="18 Month">18 Months</option>
        <option <?php if(isset($lastrow['period_contract']) && $lastrow['period_contract']==='24 Month'){ echo 'selected';} ?> value="24 Month">24 Months</option>
    </select>
</p>

<p class="terms_condition" id="roadtaxselectcontainer">
    <strong>10. Working State Road Tax :</strong>if applicable road tax to be in scope of <select name="road_tax" id="roadtaxselect" onchange="roadtax_criteria()">
        <option <?php if(isset($lastrow['road_tax']) && $lastrow['road_tax']==='not applicable'){ echo 'selected';} ?> value="not applicable">not applicable</option>
        <option <?php if(isset($lastrow['road_tax']) && $lastrow['road_tax']==='client'){ echo 'selected';} ?> value="client">client</option>
        <option <?php if(isset($lastrow['road_tax']) && $lastrow['road_tax']==='rental company'){ echo 'selected';} ?> value="rental company">rental company</option>
    </select>

    <select name="roadtax_condition" id="roadtaxcondition" onchange="lumsum_amount()">
        <option value="as per recipt">as per recipt</option>
        <option value="lumsum amount">lumsum amount</option>
    </select>
    <input type="text" id="enterlumsumamount" name="lumsumamount" placeholder="Enter amount">
</p>

<p class="terms_condition"><strong>11.Dehire Clause :</strong>  Dehire notice must be provided with a minimum 
<select name="dehire" id="">
    <option <?php if(isset($lastrow['dehire_clause']) && $lastrow['dehire_clause']==='7 Days'){ echo 'selected';} ?> value="7 Days" >7 Days</option>
    <option <?php if(isset($lastrow['dehire_clause']) && $lastrow['dehire_clause']==='15 Days'){ echo 'selected';} ?> value="15 Days" default selected>15 Days</option>
    <option <?php if(isset($lastrow['dehire_clause']) && $lastrow['dehire_clause']==='30 Days'){ echo 'selected';} ?> value="30 Days">30 Days</option>
</select> notice.</p>
<p class="terms_condition">
    <strong>12.Payment Terms :</strong> 
    <select name="payment_terms_select" id="payment_terms_select">
        <option <?php if(isset($lastrow['pay_terms']) && $lastrow['pay_terms']==='within 7 days Of invoice submission'){ echo 'selected';} ?> value="within 7 days Of invoice submission">within 7 Days Of invoice submission</option>
        <option <?php if(isset($lastrow['pay_terms']) && $lastrow['pay_terms']==='within 10 days Of invoice submission'){ echo 'selected';} ?> value="within 10 days Of invoice submission">within 10 Days Of invoice submission</option>
        <option <?php if(isset($lastrow['pay_terms']) && $lastrow['pay_terms']==='within 30 days Of invoice submission'){ echo 'selected';} ?> value="within 30 days Of invoice submission" default selected>within 30 Days Of invoice submission</option>
        <option <?php if(isset($lastrow['pay_terms']) && $lastrow['pay_terms']==='within 45 days Of invoice submission'){ echo 'selected';} ?> value="within 45 days Of invoice submission">within 45 Days Of invoice submission</option>
    </select>
</p>


<p class="terms_condition">
    <strong>13.Advance Payment :</strong> 
    <select name="advance_payment_select" id="advance_payment_select">
        <option <?php if(isset($lastrow['adv_pay']) && $lastrow['adv_pay']==='Not applicable'){ echo 'selected';} ?> value="Not applicable">Not Applicable</option>
        <option <?php if(isset($lastrow['adv_pay']) && $lastrow['adv_pay']==='applicable - mob charges'){ echo 'selected';} ?> value="applicable - mob charges" default selected>applicable - mob charges</option>
        <option <?php if(isset($lastrow['adv_pay']) && $lastrow['adv_pay']==='applicable - mob + rental charges'){ echo 'selected';} ?> value="applicable - mob + rental charges">applicable - mob + rental charges</option>
        <option <?php if(isset($lastrow['adv_pay']) && $lastrow['adv_pay']==='applicable - mob + rental charges + demob charges'){ echo 'selected';} ?> value="applicable - mob + rental charges + demob charges">applicable - mob + rental charges + demob charges</option>
    </select>
</p>










<p class="terms_condition">
    <strong>14.Supporting Equipment :</strong> 
    <select name="equipment_assembly_select" id="equipment_assembly_select">
        <option <?php if(isset($lastrow['equipment_assembly']) && $lastrow['equipment_assembly']==='Not Applicable'){ echo 'selected';} ?> value="Not Applicable">Not Applicable</option>
        <option <?php if(isset($lastrow['equipment_assembly']) && $lastrow['equipment_assembly']==='Assembly + Dismentling'){ echo 'selected';} ?> value="Assembly + Dismentling"> Assembly + Dismentling </option>
        <option <?php if(isset($lastrow['equipment_assembly']) && $lastrow['equipment_assembly']==='Unloading + Assembly + Dismentling + Loading'){ echo 'selected';} ?> value="Unloading + Assembly + Dismentling + Loading">Unloading + Assembly + Dismentling + Loading</option>
        <option <?php if(isset($lastrow['equipment_assembly']) && $lastrow['equipment_assembly']==='Unloading & Loading'){ echo 'selected';} ?> value="Unloading & Loading">Unloading & Loading</option>
    </select>
</p>

<p class="terms_condition">
    <strong>15.TPI Scope :</strong> 
    <select name="tpi_scope_select" id="tpi_scope_select">
        <option <?php if(isset($lastrow['tpi']) && $lastrow['tpi']==='Not Required'){ echo 'selected';} ?> value="Not Required">Not Required</option>
        <option <?php if(isset($lastrow['tpi']) && $lastrow['tpi']==='In Client Scope'){ echo 'selected';} ?> value="In Client Scope">In Client Scope</option>
        <option <?php if(isset($lastrow['tpi']) && $lastrow['tpi']==='In Rental Company'){ echo 'selected';} ?> value="In Rental Company" default selected>In Rental Company</option>
    </select>
</p>

<p class="terms_condition">
    <strong>16.Safety And Security :</strong> 
    <select name="safety_security_select" id="safety_security_select">
        <option <?php if(isset($lastrow['safety']) && $lastrow['safety']==='Not Required'){ echo 'selected';} ?> value="Not Required">Not Required</option>
        <option <?php if(isset($lastrow['safety']) && $lastrow['safety']==='In Client Scope'){ echo 'selected';}  ?> value="In Client Scope" default selected>In Client Scope</option>
        <option <?php if(isset($lastrow['safety']) && $lastrow['safety']==='In Rental Company'){ echo 'selected';}?> value="In Rental Company">In Rental Company</option>
    </select>
</p>




<p class="terms_condition">
    <strong>17.GST :</strong>Applicable. Extra payable at actual invoice value at
    <select name="gst" id="">
        <option <?php if(isset($lastrow['gst']) && $lastrow['gst']==='18%'){ echo 'selected';}?> value="18%" >18%</option>
        <option <?php if(isset($lastrow['gst']) && $lastrow['gst']==='28%'){ echo 'selected';}?> value="28%">28%</option>
        <option <?php if(isset($lastrow['gst']) && $lastrow['gst']==='12%'){ echo 'selected';}?> value="12%">12%</option>
        <option <?php if(isset($lastrow['gst']) && $lastrow['gst']==='5%'){ echo 'selected';}?> value="5%">5%</option>
    </select>
<!-- <textarea name="gst" id="" cols="30" rows="1" class="terms_textarea"> Applicable. Extra payable at actual invoice value at 18%.</textarea> -->
</p>
<p class="terms_condition"><strong>18.PPE Kit :</strong>If Required To Be Provided 
<select name="PPE" id="">
<option <?php if(isset($lastrow['ppe_kit']) && $lastrow['ppe_kit']==='In Client Scope FOC Basis'){ echo 'selected';}?> value="In Client Scope FOC Basis">In Client Scope FOC Basis</option>
<option <?php if(isset($lastrow['ppe_kit']) && $lastrow['ppe_kit']==='In Rental Company Scope'){ echo 'selected';}?> value="In Rental Company Scope">In Rental Company Scope</option>
<option <?php if(isset($lastrow['ppe_kit']) && $lastrow['ppe_kit']==='In Client Scope At Recoverable Basis'){ echo 'selected';}?> value="In Client Scope At Recoverable Basis">In Client Scope At Recoverable Basis</option>
</select>
</p>


<p class="terms_condition">
    <strong>19.Over time payment :</strong>Applicable. OT charges at <select name="ot_payment" id=""><option value="100%" default selected>100%</option>
    <option <?php if(isset($lastrow['ot_pay']) && $lastrow['ot_pay']==='90%'){ echo 'selected';}?> value="90%">90%</option>
    <option <?php if(isset($lastrow['ot_pay']) && $lastrow['ot_pay']==='80%'){ echo 'selected';}?> value="80%">80%</option>
    <option <?php if(isset($lastrow['ot_pay']) && $lastrow['ot_pay']==='70%'){ echo 'selected';}?> value="70%">70%</option>
    <option <?php if(isset($lastrow['ot_pay']) && $lastrow['ot_pay']==='60%'){ echo 'selected';}?> value="60%">60%</option>
    <option <?php if(isset($lastrow['ot_pay']) && $lastrow['ot_pay']==='50%'){ echo 'selected';}?> value="50%">50%</option></select>pro-rata basis payable if equipment has worked beyond stipulated work shift, engine hours and on Sundays,National holidays
<!-- <textarea name="ot_payment" id="" cols="30" rows="2" class="terms_textarea"> Applicable. OT charges at 100% pro-rata basis payable if equipment has worked beyond stipulated work shift, engine hours and on Sundays,National holidays</textarea> -->
</p>





<p class="terms_condition">
    <strong>20.Tools & Tackles :</strong>Related Tools And Tackles , To Be Provided <select name="tools_tackels" id="">
        <option <?php if(isset($lastrow['tools']) && $lastrow['tools']==='In Client Scope'){ echo 'selected';}?> value="In Client Scope">In Client Scope</option>
        <option <?php if(isset($lastrow['tools']) && $lastrow['tools']==='In Rental Company Scope'){ echo 'selected';}?> value="In Rental Company Scope">In Rental Company Scope</option>
    </select>
<!-- <textarea name="tools_tackels" id="" cols="30" rows="2" class="terms_textarea"> Related Tools And Tackles , Required Safety PPE Kit And Gears To Be Provided By Client On FOC basis.</textarea> -->
</p>

<p class="terms_condition">
    <strong>21.Internal Shifting :</strong><select name="internal_shifting" id="">
        <option <?php if(isset($lastrow['internal_shifting']) && $lastrow['internal_shifting']==='not applicable'){ echo 'selected';}?> value="not applicable">not applicable</option>
        <option <?php if(isset($lastrow['internal_shifting']) && $lastrow['internal_shifting']==='In Client Scope'){ echo 'selected';}?> value="In Client Scope" default selected>In Client Scope</option>
        <option <?php if(isset($lastrow['internal_shifting']) && $lastrow['internal_shifting']==='In Rental Company Scope'){ echo 'selected';}?> value="In Rental Company Scope">In Rental Company Scope</option>
    </select>
</p>
<p class="terms_condition">
    <strong>22.Notice To Mobilise :</strong> Minimum <select name="mobilisation_notice" id="">
        <option <?php if(isset($lastrow['mobilisation_notice']) && $lastrow['mobilisation_notice']==='3 days'){ echo 'selected';}?> value="3 days">3 days</option>
        <option <?php if(isset($lastrow['mobilisation_notice']) && $lastrow['mobilisation_notice']==='5 days'){ echo 'selected';}?> value="5 days">5 days</option>
        <option <?php if(isset($lastrow['mobilisation_notice']) && $lastrow['mobilisation_notice']==='7 days'){ echo 'selected';}?> value="7 days">7 days</option>
        <option <?php if(isset($lastrow['mobilisation_notice']) && $lastrow['mobilisation_notice']==='15 days'){ echo 'selected';}?> value="15 days">15 days</option>
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
    <option <?php if(isset($lastrow['quote_validity']) && $lastrow['quote_validity']==='3 days'){ echo 'selected';}?> value="3 days">3 Days</option>
    <option <?php if(isset($lastrow['quote_validity']) && $lastrow['quote_validity']==='7 days'){ echo 'selected';}?> value="7 days" default selected>7 Days</option>
    <option <?php if(isset($lastrow['quote_validity']) && $lastrow['quote_validity']==='10 days'){ echo 'selected';}?> value="10 days">10 Days</option>
    <option <?php if(isset($lastrow['quote_validity']) && $lastrow['quote_validity']==='15 days'){ echo 'selected';}?> value="15 days">15 Days</option>
    <option <?php if(isset($lastrow['quote_validity']) && $lastrow['quote_validity']==='30 days'){ echo 'selected';}?> value="30 days">30 Days</option>
</select></p>
<p class="terms_condition"><textarea id="custom_terms_textarea" name="custom" cols="30" rows="5" class="terms_textarea" id=""><?php if(isset($row_custom['custom_terms']) ){ echo $row_custom['custom_terms'];} else{ echo "26.Custom Terms And Condition To Be Written Here If Any If Not Clear The Text" ;}  ?> </textarea></p>


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


<script>
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

    function purchase_option() {
    const options = document.getElementsByClassName('awp_options');
    const options1 = document.getElementsByClassName('cq_options');
    const options2 = document.getElementsByClassName('earthmover_options');
    const options3 = document.getElementsByClassName('mhe_options');
    const options4 = document.getElementsByClassName('gee_options');
    const options5 = document.getElementsByClassName('trailor_options');
    const options6 = document.getElementsByClassName('generator_options');

    const first_select = document.getElementById('oem_fleet_type');

    // Set the display style for all elements at once
    const displayStyle = (first_select.value === "Aerial Work Platform") ? "block" : "none";
    Array.from(options).forEach(option => option.style.display = displayStyle);

    const displayStyle1 = (first_select.value === "Concrete Equipment") ? "block" : "none";
    Array.from(options1).forEach(option => option.style.display = displayStyle1);

    const displayStyle2 = (first_select.value === "EarthMovers and Road Equipments") ? "block" : "none";
    Array.from(options2).forEach(option => option.style.display = displayStyle2);

    const displayStyle3 = (first_select.value === "Material Handling Equipments") ? "block" : "none";
    Array.from(options3).forEach(option => option.style.display = displayStyle3);

    const displayStyle4 = (first_select.value === "Ground Engineering Equipments") ? "block" : "none";
    Array.from(options4).forEach(option => option.style.display = displayStyle4);

    const displayStyle5 = (first_select.value === "Trailor and Truck") ? "block" : "none";
    Array.from(options5).forEach(option => option.style.display = displayStyle5);

    const displayStyle6 = (first_select.value === "Generator and Lighting") ? "block" : "none";
    Array.from(options6).forEach(option => option.style.display = displayStyle6);


}
function officetypedd(){
    const office_typenew=document.getElementById("office_typenew");
    const regandsitecontainerouter=document.getElementById("regandsitecontainerouter");
    const siteoffice=document.getElementById("siteoffice");
    const regionaloffice=document.getElementById("regionaloffice");
    if(office_typenew.value==='Regional Office'){
        regandsitecontainerouter.style.display='flex';
        regionaloffice.style.display='block';
        siteoffice.style.display='none';

    }
    else if(office_typenew.value==='Site Office'){
        regandsitecontainerouter.style.display='flex';
        siteoffice.style.display='block';
        regionaloffice.style.display='none';


    }
    else{
        regandsitecontainerouter.style.display='none';
        siteoffice.style.display='none';
        regionaloffice.style.display='none';


    }
}


function seco_equip() {
    const options1 = document.getElementsByClassName('awp_options1');
    const options11 = document.getElementsByClassName('cq_options1');
    const options21 = document.getElementsByClassName('earthmover_options1');
    const options31 = document.getElementsByClassName('mhe_options1');
    const options41 = document.getElementsByClassName('gee_options1');
    const options51 = document.getElementsByClassName('trailor_options1');
    const options61 = document.getElementsByClassName('generator_options1');

    const first_select1 = document.getElementById('oem_fleet_type1');

    // Set the display style for all elements at once
    const displayStyle00 = (first_select1.value === "Aerial Work Platform") ? "block" : "none";
    Array.from(options1).forEach(option => option.style.display = displayStyle00);

    const displayStyle1 = (first_select1.value === "Concrete Equipment") ? "block" : "none";
    Array.from(options11).forEach(option => option.style.display = displayStyle1);

    const displayStyle2 = (first_select1.value === "EarthMovers and Road Equipments") ? "block" : "none";
    Array.from(options21).forEach(option => option.style.display = displayStyle2);

    const displayStyle3 = (first_select1.value === "Material Handling Equipments") ? "block" : "none";
    Array.from(options31).forEach(option => option.style.display = displayStyle3);

    const displayStyle4 = (first_select1.value === "Ground Engineering Equipments") ? "block" : "none";
    Array.from(options41).forEach(option => option.style.display = displayStyle4);

    const displayStyle5 = (first_select1.value === "Trailor and Truck") ? "block" : "none";
    Array.from(options51).forEach(option => option.style.display = displayStyle5);

    const displayStyle6 = (first_select1.value === "Generator and Lighting") ? "block" : "none";
    Array.from(options61).forEach(option => option.style.display = displayStyle6);


}
function updateAssetCode(selectElement) {
    // Get the selected fleet category and dropdown ID
    var fleetCategory = selectElement.value;
    var dropdownId = selectElement.getAttribute("data-dropdown");

    // Find the corresponding asset code dropdown
    var assetCodeDropdown = document.querySelector('.asset-code[data-dropdown="' + dropdownId + '"]');

    // Make an AJAX request to fetch asset codes based on the selected category
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "fetch_asset_codes.php?fleet_category=" + encodeURIComponent(fleetCategory), true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            try {
                var response = JSON.parse(xhr.responseText);

                // Check if the response contains an error
                if (response.error) {
                    console.error("Error:", response.error);
                    return;
                }

                // Clear existing options
                assetCodeDropdown.innerHTML = '<option value="" disabled selected>Choose Asset Code</option><option value="New Equipment">Choose New Equipment</option>';

                // Append new options
                response.forEach(function (asset) {
    var option = document.createElement("option");
    option.value = asset.assetcode;
    option.text = asset.assetcode + " (" + asset.sub_type + " " + asset.make + " " + asset.model + " " + asset.capacity + " " + asset.unit + ") " + asset.status;

    // Set background color based on status
    if (asset.status.toLowerCase() === "idle") {
        option.style.backgroundColor = "lightgreen";
    } else if (asset.status.toLowerCase() === "working") {
        option.style.backgroundColor = "lightcoral"; // Light red
    }

    assetCodeDropdown.appendChild(option);
});
            } catch (e) {
                console.error("Failed to parse JSON response:", e);
                console.error("Response:", xhr.responseText);
            }
        }
    };
    xhr.send();
}
function newclient(){
    const companySelect=document.getElementById("companySelect");
    const contactSelect=document.getElementById("contactSelectouter");
    const newrentalcontactperson=document.getElementById("newrentalcontactperson");
    const companySelectouter=document.getElementById("companySelectouter");
        const newrentalclient=document.getElementById("newrentalclient");

    
        if(companySelect.value==='New Client'){
            companySelectouter.style.display='none';
            contactSelect.style.display='none';
            newrentalcontactperson.style.display='flex';
            newrentalclient.style.display='flex';
    
        }

}

function newcontactpersonfunction(){
    const contactSelect=document.getElementById("contactSelect");
    const contactSelectouter=document.getElementById("contactSelectouter");
    const newrentalcontactperson=document.getElementById("newrentalcontactperson");
    const quoteouter02=document.getElementById("quoteouter02");

    if(contactSelect.value==='New Contact Person'){
        contactSelectouter.style.display='none';
        newrentalcontactperson.style.display='flex';

    
        }


}

function third_vehicle(){
    const thirdvehicledetail=document.getElementById("thirdvehicledetail");
    const third_addequipbtn=document.getElementById("third_addequipbtn");
    thirdvehicledetail.style.display="flex";
    third_addequipbtn.style.display="none";

}
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



function filterClients() {
    const input = document.getElementById('clientSearch');
    const filter = input.value.toLowerCase();
    const suggestions = document.getElementById('suggestions');
    const select = document.getElementById('companySelect');
    const options = select.getElementsByTagName('option');

    suggestions.innerHTML = ''; // Clear previous suggestions
    let hasVisibleItems = false;

    for (let i = 0; i < options.length; i++) {
        const optionText = options[i].textContent || options[i].innerText;
        if (optionText.toLowerCase().includes(filter) && filter) {
            const suggestionItem = document.createElement('div');
            suggestionItem.className = 'suggestion-item';
            suggestionItem.textContent = optionText;
            suggestionItem.onclick = function() {
                select.value = options[i].value; // Set the select value
                input.value = optionText; // Set the input value
                suggestions.style.display = 'none'; // Hide suggestions
                updateContactPerson(); // Call the onchange function
                newclient(); // Call the newclient function
            };
            suggestions.appendChild(suggestionItem);
            hasVisibleItems = true;
        }
    }

    // If no suggestions found, show "New Client" option
    if (!hasVisibleItems) {
        const newClientItem = document.createElement('div');
        newClientItem.className = 'suggestion-item';
        newClientItem.textContent = 'New Client';
        newClientItem.onclick = function() {
            select.value = 'New Client'; // Set the select value
            input.value = 'New Client'; // Set the input value
            suggestions.style.display = 'none'; // Hide suggestions
            updateContactPerson(); // Call the onchange function
            newclient(); // Call the newclient function
        };
        suggestions.appendChild(newClientItem);
        suggestions.style.display = 'block'; // Show the suggestions
    } else {
        suggestions.style.display = 'block'; // Show suggestions if there are any
    }
}

function showDropdown() {
    const suggestions = document.getElementById('suggestions');
    suggestions.style.display = 'block';
}

// Close suggestions when clicking outside
document.addEventListener('click', function(event) {
    const suggestions = document.getElementById('suggestions');
    const input = document.getElementById('clientSearch');
    if (!suggestions.contains(event.target) && event.target !== input) {
        suggestions.style.display = 'none';
    }
}); 


// --- Auto-select fleet category in new equipment section when "Choose New Equipment" is selected ---
document.addEventListener('DOMContentLoaded', function() {
    // Map dropdown index to new equipment fleet category select IDs
    const newEquipFleetCategoryIds = {
        1: 'oem_fleet_type',
        2: 'oem_fleet_type1',
        3: 'oem_fleet_type3',
        4: 'oem_fleet_type4',
        5: 'oem_fleet_type5'
    };

    // Map dropdown index to fleet type onchange handler
    const fleetTypeOnChangeFns = {
        1: window.purchase_option,
        2: window.seco_equip,
        3: window.third_equipment ? window.third_equipment : function(){},
        4: window.fourth_equipment ? window.fourth_equipment : function(){},
        5: window.fifth_equipment ? window.fifth_equipment : function(){}
    }; 

    //Auto-select fleet category when "Choose New Equipment" is selected.....

    document.querySelectorAll('.asset-code').forEach(function(assetCodeSelect) {
        assetCodeSelect.addEventListener('change', function() {
            const selectedOption = assetCodeSelect.value;
            const dropdownId = assetCodeSelect.getAttribute('data-dropdown');
            if (selectedOption === 'New Equipment') {
                // Find the fleet category select for this section
                const fleetCategorySelect = document.querySelector('.fleet-category[data-dropdown="' + dropdownId + '"]');
                const newEquipFleetCategoryId = newEquipFleetCategoryIds[dropdownId];
                const newEquipFleetCategorySelect = document.getElementById(newEquipFleetCategoryId);
                if (fleetCategorySelect && newEquipFleetCategorySelect) {
                    // Set value and trigger change
                    newEquipFleetCategorySelect.value = fleetCategorySelect.value;
                    // Trigger the correct onchange handler for fleet type options
                    if (typeof newEquipFleetCategorySelect.onchange === "function") {
                        newEquipFleetCategorySelect.onchange();
                    }
                    // Also call the mapped function if available (for sections 2-5)
                    if (fleetTypeOnChangeFns[dropdownId]) {
                        fleetTypeOnChangeFns[dropdownId]();
                    }
                }
            }
        });
    });
});
</script>
</body>
</html>
