<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 
include_once 'partials/_dbconnect.php';
$showAlert = false;
$showError = false;


$edit_quotation=mysqli_real_escape_string($conn, $_GET['quote_id']);
$sql_edit_quotation="SELECT * FROM `quotation_generated` where `sno`='$edit_quotation'";
$result_edit=mysqli_query($conn,$sql_edit_quotation);
$row=mysqli_fetch_assoc($result_edit);

$sql_second_equipmment = "SELECT * FROM `second_vehicle_quotation` where uniqueid='" . $row['uniqueid'] . "'";
$result_secondequip = mysqli_query($conn, $sql_second_equipmment) or die(mysqli_error($conn));

// Check if query was successful
if ($result_secondequip) {
    // Fetch the result if there are rows
    $row_second = mysqli_fetch_assoc($result_secondequip);

    } else {
        echo "Existing Equipment branch";  // Debugging output
    
    // Query failed or no rows found, set $row_second to empty array
    $row_second = '';
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


?>
<?php 
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

$asset_code_selection = "SELECT * FROM `fleet1` WHERE `companyname`='$companyname001'";
$result_asset_code = mysqli_query($conn, $asset_code_selection);

$asset_code_selection2 = "SELECT * FROM `fleet1` WHERE `companyname`='$companyname001'";
$result_asset_code2 = mysqli_query($conn, $asset_code_selection2);

$asset_code_selection3 = "SELECT * FROM `fleet1` WHERE `companyname`='$companyname001'";
$result_asset_code3 = mysqli_query($conn, $asset_code_selection3);

$asset_code_selection4 = "SELECT * FROM `fleet1` WHERE `companyname`='$companyname001'";
$result_asset_code4 = mysqli_query($conn, $asset_code_selection4);

$asset_code_selection5 = "SELECT * FROM `fleet1` WHERE `companyname`='$companyname001'";
$result_asset_code5 = mysqli_query($conn, $asset_code_selection5);



?>
<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $period=$_POST['contract_period_select'];
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
    $unique_id=$_POST['edit_uniqueid'];
    $asset_code = $_POST['asset_code1'];
    $sql_fleet1="SELECT * FROM `fleet1` where assetcode='$asset_code' && companyname='$companyname001'";
    $result_fleet1=mysqli_query($conn,$sql_fleet1);
    $row_fleet1=mysqli_fetch_assoc($result_fleet1);
    $lumsumamount=$_POST['lumsumamount'] ?? '';
$roadtax_condition=$_POST['roadtax_condition'] ?? '';




    $quote_date = $_POST['quotation_date'];
    $to_name = $_POST['to'];
    $to_address = $_POST['to_address'];
    $contact_person_name = $_POST['contact_person'];
    $contact_peson_cell = $_POST['contact_number'];
    $email_id = $_POST['email_id'];
    $site_location = $_POST['site_location'];
    $sender_name=$_POST['sender'];
    $sender_number=$_POST['sender_number'];
    $sender_email=$_POST['sender_email'];
    $sender_office_address=$_POST['sender_office_address'];
    $availability = $_POST['availability'];
    $hours_duration = $_POST['hours_duration'];
    $days_duration = $_POST['days_duration'];
    $condition = $_POST['condition'];
    $fleet_category1 = isset($_POST['fleet_category1']) ? $_POST['fleet_category1'] : null;
    $type1 = isset($_POST['type1']) ? $_POST['type1'] : null;
    $fleet_category7 = isset($_POST['fleet_category7']) ? $_POST['fleet_category7'] : null;
    $type7 = isset($_POST['type7']) ? $_POST['type7'] : null;
    $newfleetmake1=$_POST['newfleetmake1'];
    $newfleetmodel1=$_POST['newfleetmodel1'];
    $fleetcap2=$_POST['fleetcap2'];
    $unit2 = isset($_POST['unit2']) ? $_POST['unit2'] : null;
    $yom2=$_POST['yom2'];
    $boomLength2=$_POST['boomLength2'];
    $jibLength2=$_POST['jibLength2'];
    $luffingLength2=$_POST['luffingLength2'];
    $tentative = isset($_POST['tentative_date']) ? $_POST['tentative_date'] : null;
    $shiftinfo=$_POST['shiftinfo'];
    $engine_hour = empty($_POST['engine_hour']) ? null : $_POST['engine_hour'];
    $rental_charges=$_POST['rental_charges'];
    $mob=$_POST['mob_charges'];
    $demob=$_POST['demob_charges'];
    $location=$_POST['location'];
    $adblue=$_POST['adblue'];
    $fuel_per_hour=$_POST['fuel_per_hour'];

    $ac_2 = isset($_POST['asset_code7']) ? $_POST['asset_code7'] : null;
    $sql_fleet17="SELECT * FROM `fleet1` where assetcode='$ac_2' && companyname='$companyname001'";
    $result_fleet17=mysqli_query($conn,$sql_fleet17);
    $row_fleet17=mysqli_fetch_assoc($result_fleet17);


    $avail2 = isset($_POST['avail1']) ? $_POST['avail1'] : null;
    $unit7 = isset($_POST['unit7']) ? $_POST['unit7'] : null;
    $make7=$_POST['newfleetmake7'];
    $model7=$_POST['newfleetmodel7'];
    $yom7=$_POST['yom7'];
    $cap7=$_POST['fleetcap7'];
    $boomLength7=$_POST['boomLength7'];
    $jibLength7=$_POST['jibLength7'];
    $luffingLength7=$_POST['luffingLength7'];
    $date_=$_POST['date_'];
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
    $custom_edit=$_POST['custom_edit'];



    $cap_equip=$_POST['capacity_equip'];
    $yom_equip=$_POST['yom_equip'];
    $jib_equip=$_POST['jib_equip'];
    $boom_equip=$_POST['boom_equip'];
    $luffing_equip=$_POST['luffing_equip'];

    $yom_second_equipment_new=$_POST['yom_equip_second'];
$cap_second_equipment_new=$_POST['capacity_equip_second'];
$boom_second_equipment_new=$_POST['boom_equip_second'];
$jib_second_equipment_new=$_POST['jib_equip_second'];
$luffing_second_equipment=$_POST['luffing_equip_second'];
$lunch_time=$_POST['lunch_time'];

$mobilisation_notice=$_POST['mobilisation_notice'];
$internal_shifting=$_POST['internal_shifting'];



    // thirdequipment
    $asset_code3=$_POST['asset3'] ?? null;
    $sql_fleet3="SELECT * FROM `fleet1` where assetcode='$asset_code3' && companyname='$companyname001'";
    $result_fleet3=mysqli_query($conn,$sql_fleet3);
    $row_fleet3=mysqli_fetch_assoc($result_fleet3);

    $avail3=$_POST['avail3'];
    $date3=$_POST['date3'];
    $yom3_prefill=$_POST['yom3_prefill'];
    $capacity3_prefill=$_POST['capacity3_prefill'];
    $boom3_prefill=$_POST['boom3_prefill'];
    $jib3_prefill=$_POST['jib3_prefill'];
    $luffing3_prefill=$_POST['luffing3_prefill'];
    $fleet_category3=$_POST['fleet_category3'];
    $type3=$_POST['type3'];
    $newfleetmake3=$_POST['newfleetmake3'];
    $newfleetmodel3=$_POST['newfleetmodel3'];
    $fleetcap3=$_POST['fleetcap3'];
    $unit3=$_POST['unit3'];
    $yom3=$_POST['yom3'];
    $boomLength3=$_POST['boomLength3'];
    $jibLength3=$_POST['jibLength3'];
    $luffingLength3=$_POST['luffingLength3'];
    $rental3=$_POST['rental3'];
    $mob03=$_POST['mob03'];
    $demob03=$_POST['demob03'];
    $equiplocation03=$_POST['equiplocation03'];
    $fuelperltr3=$_POST['fuelperltr3'];
    $adblue3=$_POST['adblue3'];






    if($_POST['asset_code1']==='New Equipment'){
        $sql_first_vehicle_complete = "UPDATE `quotation_generated` 
        SET `custom_terms` = '$custom_edit',
            `lumsumamount` = '$lumsumamount',
            `roadtax_condition` = '$roadtax_condition',
            `food_break` = '$lunch_time',
            `salutation` = '$salutation_dd',
            `working_end_unit` = '$working_shift_end_unit',
            `working_end` = '$working_shift_end',
            `working_start` = '$working_shift_start',
            `fuel_scope` = '$fuel_scope',
            `adblue_scope` = '$adblue_scope',
            `quote_date` = '$quote_date',
            `to_name` = '$to_name',
            `to_address` = '$to_address',
            `contact_person` = '$contact_person_name',
            `contact_person_cell` = '$contact_peson_cell',
            `email_id_contact_person` = '$email_id',
            `site_loc` = '$site_location',
            `asset_code` = '$asset_code',
            `yom` = '$yom2',
            `make` = '$newfleetmake1',
            `model` = '$newfleetmodel1',
            `sub_Type` = '$type1',
            `category` = '$fleet_category1',
            `fuel/hour` = '$fuel_per_hour',
            `availability` = '$availability',
            `tentative_date` = '$tentative',
            `cap` = '$fleetcap2',
            `cap_unit` = '$unit2',
            `boom` = '$boomLength2',
            `jib` = '$jibLength2',
            `luffing` = '$luffingLength2',
            `shift_info` = '$shiftinfo',
            `hours_duration` = '$hours_duration',
            `engine_hours` = '$engine_hour',
            `days_duration` = '$days_duration',
            `sunday_included` = '$condition',
            `rental_charges` = '$rental_charges',
            `mob_charges` = '$mob',
            `demob_charges` = '$demob',
            `crane_location` = '$location',
            `adblue` = '$adblue',
            `sender_name` = '$sender_name',
            `sender_number` = '$sender_number',
            `sender_contact` = '$sender_email',
            `sender_office_address` = '$sender_office_address',
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
            `force_clause` = '$force_clause',
            `dehire_clause` = '$dehire',
            `ppe_kit` = '$ppe',
            `road_tax` = '$road_tax',
            `internal_shifting`='$internal_shifting',
            `mobilisation_notice`='$mobilisation_notice',
            `quote_validity` = '$quote_valid'
        WHERE `uniqueid` = '$unique_id'";
        $result_first_vehicle_complete=mysqli_query($conn,$sql_first_vehicle_complete);
        if($result_first_vehicle_complete){
            session_start();
            $_SESSION['success']='success';
    
            header("Location: generate_quotation_landingpage.php");
            $showAlert=true;
        }
        else{
            $showError=true;
        }
    
    
    }
    else{
        $sql_first_vehicle_complete1 = "UPDATE `quotation_generated` SET 
        `custom_terms` = '$custom_edit',
        `food_break` = '$lunch_time',
        `salutation` = '$salutation_dd',
        `working_end_unit` = '$working_shift_end_unit',
        `working_end` = '$working_shift_end',
        `working_start` = '$working_shift_start',
        `fuel_scope` = '$fuel_scope',
        `adblue_scope` = '$adblue_scope',
        `quote_date` = '$quote_date',
        `to_name` = '$to_name',
        `to_address` = '$to_address',
        `contact_person` = '$contact_person_name',
        `contact_person_cell` = '$contact_peson_cell',
        `email_id_contact_person` = '$email_id',
        `site_loc` = '$site_location',
        `asset_code` = '$asset_code',
        `yom` = '$yom_equip',
        `make` = '". $row_fleet1['make'] ."',
        `model` = '". $row_fleet1['model'] ."',
        `sub_Type` = '". $row_fleet1['sub_type'] ."',
        `category` = '". $row_fleet1['category'] ."',
        `fuel/hour` = '$fuel_per_hour',
        `availability` = '$availability',
        `tentative_date` = '$tentative',
        `cap` = '$cap_equip',
        `cap_unit` = '". $row_fleet1['unit'] ."',
        `boom` = '$boom_equip',
        `jib` = '$jib_equip',
        `luffing` = '$luffing_equip',
        `shift_info` = '$shiftinfo',
        `hours_duration` = '$hours_duration',
        `engine_hours` = '$engine_hour',
        `days_duration` = '$days_duration',
        `sunday_included` = '$condition',
        `rental_charges` = '$rental_charges',
        `mob_charges` = '$mob',
        `demob_charges` = '$demob',
        `crane_location` = '$location',
        `adblue` = '$adblue',
        `sender_name` = '$sender_name',
        `sender_number` = '$sender_number',
        `sender_contact` = '$sender_email',
        `sender_office_address` = '$sender_office_address',
        `period_contract` = '$period',
        `adv_pay` = '$adv_pay',
        `road_tax` = '$road_tax',
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
        `force_clause` = '$force_clause',
        `dehire_clause` = '$dehire',
        `ppe_kit` = '$ppe',
                        `internal_shifting`='$internal_shifting',
            `mobilisation_notice`='$mobilisation_notice',

        `quote_validity` = '$quote_valid'
    WHERE `uniqueid` = '$unique_id'";
                  $result_first_vehicle_complete1=mysqli_query($conn,$sql_first_vehicle_complete1);
              if($result_first_vehicle_complete1){
                session_start();
                $_SESSION['success']='success';
        
                header("Location: generate_quotation_landingpage.php");

                $showAlert=true;
            }
            else{
                // $showError=true;
            }
    
    }
    $sql_check_existence = "SELECT COUNT(*) AS count FROM `second_vehicle_quotation` WHERE `uniqueid` = '$unique_id'";
    $result_check_existence = mysqli_query($conn, $sql_check_existence);
    
    if ($result_check_existence) {
        $row = mysqli_fetch_assoc($result_check_existence);
        $count = $row['count'];
    
        if ($count > 0) {
            // Record exists, perform update
            if (isset($_POST['asset_code7']) && $_POST['asset_code7'] === 'New Equipment') {
                // Corrected SQL query for 'New Equipment'
                $sql_second_vehicle = "UPDATE `second_vehicle_quotation` 
                    SET `asset_code2` = '$ac_2', `yom2` = '$yom7', `make2` = '$make7', `model2` = '$model7', `sub_type2` = '$type7',
                        `category2` = '$fleet_category7', `fuel/hour2` = '$fuelperltr2', `availability2` = '$avail2', `tentative_date2` = '$date_', 
                        `cap2` = '$cap7', `cap_unit2` = '$unit7', `boom2` = '$boomLength7', `jib2` = '$jibLength7', `luffing2` = '$luffingLength7', 
                       `rental_charges2` = '$rental2', `mob_charges2` = '$mob02', `demob_charges2` = '$demob02', 
                        `crane_location2` = '$equiplocation02', `adblue2` = '$adblue2' 
                    WHERE `uniqueid` = '$unique_id'";
            
                $result_second_vehicle = mysqli_query($conn, $sql_second_vehicle);
            
                if ($result_second_vehicle) {
                    session_start();
                    $_SESSION['success']='success';
            
                    header("Location: generate_quotation_landingpage.php");
                    exit; // Important to exit after header redirect
                
    } else {
        echo "Existing Equipment branch";  // Debugging output
    
                    $showError = true;
                }
            
    } else {
        echo "Existing Equipment branch";  // Debugging output
    
                // Corrected SQL query for non-'New Equipment'
                $sql_second_vehicle2 = "UPDATE `second_vehicle_quotation` 
                    SET `asset_code2` = '$ac_2', `yom2` = '$yom_second_equipment_new', `make2` = '".$row_fleet17['make']."', 
                        `model2` = '".$row_fleet17['model']."', `sub_type2` = '".$row_fleet17['sub_type']."', `category2` = '".$row_fleet17['category']."', 
                        `fuel/hour2` = '$fuelperltr2', `availability2` = '$avail2', `tentative_date2` = '$date_', 
                        `cap2` = '$cap_second_equipment_new', `cap_unit2` = '".$row_fleet17['unit']."', 
                        `boom2` = '$boom_second_equipment_new', `jib2` = '$jib_second_equipment_new', `luffing2` = '$luffing_second_equipment',
                         `rental_charges2` = '$rental2', `mob_charges2` = '$mob02', `demob_charges2` = '$demob02', 
                        `crane_location2` = '$equiplocation02', `adblue2` = '$adblue2' 
                    WHERE `uniqueid` = '$unique_id'";
            
                $result_second_vehicle2 = mysqli_query($conn, $sql_second_vehicle2);
            
                if ($result_second_vehicle2) {
                    session_start();
                    $_SESSION['success']='success';
            
                    header("Location: generate_quotation_landingpage.php");
                    exit;
                }


                
                else {
                    $showError = true;
                }
            }
                    } 
        else {
            // Record does not exist, perform insert
            if (isset($_POST['asset_code7']) && $_POST['asset_code7'] === 'New Equipment') {
                $sql_second_insert = "INSERT INTO `second_vehicle_quotation` (`uniqueid`, `asset_code2`, `yom2`, `make2`, `model2`, `sub_type2`, `category2`, `fuel/hour2`, `availability2`, `tentative_date2`, `cap2`, `cap_unit2`, `boom2`, `jib2`, `luffing2`, `rental_charges2`, `mob_charges2`, `demob_charges2`, `crane_location2`, `adblue2`)
                    VALUES ('$unique_id', '$ac_2', '$yom7', '$make7', '$model7', '$type7', '$fleet_category7', '$fuelperltr2', '$avail2', '$date_', '$cap7', '$unit7', '$boomLength7', '$jibLength7', '$luffingLength7', '$rental2', '$mob02', '$demob02', '$equiplocation02', '$adblue2')";
                $result_second_insert_sql = mysqli_query($conn, $sql_second_insert);
            }
             else if(isset($_POST['asset_code7']) && $_POST['asset_code7'] !== 'New Equipment') {
                $sql_final_insert = "INSERT INTO `second_vehicle_quotation` (`asset_code2`, `yom2`, `make2`, `model2`, `sub_type2`, `category2`, `fuel/hour2`, `availability2`, `tentative_date2`, 
                    `cap2`, `cap_unit2`, `boom2`, `jib2`, `luffing2`, `rental_charges2`, `mob_charges2`, `demob_charges2`, `crane_location2`, `adblue2`, `uniqueid`)
                    VALUES ('$ac_2', '$yom_second_equipment_new', '".$row_fleet17['make']."', '".$row_fleet17['model']."', '".$row_fleet17['sub_type']."', '".$row_fleet17['category']."', '$fuelperltr2', '$avail2', '$date_', 
                    '$cap_second_equipment_new', '".$row_fleet17['unit']."', '$boom_second_equipment_new', '$jib_second_equipment', '$luffing_second_equipment', 
                    '$rental2', '$mob02', '$demob02', '$equiplocation02', '$adblue2', '$unique_id')";
                $result_final_insertion = mysqli_query($conn, $sql_final_insert);
            }
    
            if (isset($result_second_insert_sql) || isset($result_final_insertion)) {
                session_start();
                $_SESSION['success']='success';
        
                header("Location: generate_quotation_landingpage.php");
                exit;
            
    } else {
        echo "Existing Equipment branch";  // Debugging output
    
                $showError = true;
            }
        }
    
    } else {
        echo "Existing Equipment branch";  // Debugging output
    
        $showError = true; // Handle database error
    }


    // thirdrowinsert

    $sql_check_existence3 = "SELECT COUNT(*) AS count3 FROM `thirdvehicle_quotation` WHERE `uniqueid` = '$unique_id'";
    $result_check_existence3 = mysqli_query($conn, $sql_check_existence3);
    
    if ($result_check_existence3) {
        $row_exist3 = mysqli_fetch_assoc($result_check_existence3);
        $count3 = $row_exist3['count3'];
    
        if ($count3 > 0) {
            // Record exists, perform update
            
    if (isset($_POST['asset3']) && $_POST['asset3'] === 'New Equipment') {
        echo "New Equipment branch";  // Debugging output
    
                // Corrected SQL query for 'New Equipment'
                $sql_thirdvehicle = "UPDATE `thirdvehicle_quotation` 
                    SET `asset_code2` = '$asset_code3', `yom2` = '$yom3_prefill', `make2` = '$newfleetmake3', 
                        `model2` = '$newfleetmodel3', `sub_type2` = '$type3', `category2` = '$fleet_category3', 
                        `fuel/hour2` = '$fuelperltr3', `availability2` = '$avail3', `tentative_date2` = '$date3', 
                        `cap2` = '$capacity3_prefill', `cap_unit2` = '$unit3', `boom2` = '$boom3_prefill', 
                        `jib2` = '$jib3_prefill', `luffing2` = '$luffing3_prefill', 
                        `rental_charges2` = '$rental3', `mob_charges2` = '$mob03', `demob_charges2` = '$demob03', 
                        `crane_location2` = '$equiplocation03', `adblue2` = '$adblue3' 
                    WHERE `uniqueid` = '$unique_id'";
    
                
    echo $sql_thirdvehicle;  // Debugging SQL for 'New Equipment'
    $result_thirdvehicle = mysqli_query($conn, $sql_thirdvehicle) or die(mysqli_error($conn));
    if ($result_thirdvehicle) {
        echo "Update successful!";
    
    } else {
        echo "Existing Equipment branch";  // Debugging output
    
        die("Update failed: " . mysqli_error($conn));
    }
    
    
                if ($result_thirdvehicle) {
                    if (session_status() == PHP_SESSION_NONE) {
                        session_start();
                    }
                    $_SESSION['success'] = 'success';
                    header("Location: generate_quotation_landingpage.php");
                    exit; // Important to exit after header redirect
                
    } else {
        echo "Existing Equipment branch";  // Debugging output
    
                    $showError = true;
                }
            
    } else {
        echo "Existing Equipment branch";  // Debugging output
    
                // Corrected SQL query for non-'New Equipment'
                $sql_thirdvehicle2 = "UPDATE `thirdvehicle_quotation` 
                    SET `asset_code2` = '$asset_code3', `yom2` = '$yom3', `make2` = '".$row_fleet3['make']."', 
                        `model2` = '".$row_fleet3['model']."', `sub_type2` = '".$row_fleet3['sub_type']."', 
                        `category2` = '".$row_fleet3['category']."', `fuel/hour2` = '$fuelperltr3', 
                        `availability2` = '$avail3', `tentative_date2` = '$date3', 
                        `cap2` = '$fleetcap3', `cap_unit2` = '".$row_fleet3['unit']."', 
                        `boom2` = '$boomLength3', `jib2` = '$jibLength3', `luffing2` = '$luffingLength3', 
                        `rental_charges2` = '$rental3', `mob_charges2` = '$mob03', `demob_charges2` = '$demob03', 
                        `crane_location2` = '$equiplocation03', `adblue2` = '$adblue3' 
                    WHERE `sno`='14'";
    
                
    echo $sql_thirdvehicle2;  // Debugging SQL for non-'New Equipment'
    $result_thirdvehicle2 = mysqli_query($conn, $sql_thirdvehicle2) or die(mysqli_error($conn));
    if ($result_thirdvehicle2) {
        echo "Update successful!";
    
    } else {
        echo "Existing Equipment branch";  // Debugging output
    
        die("Update failed: " . mysqli_error($conn));
    }
    
    
                if ($result_thirdvehicle2) {
                    if (session_status() == PHP_SESSION_NONE) {
                        session_start();
                    }
                    $_SESSION['success'] = 'success';
                    header("Location: generate_quotation_landingpage.php");
                    exit;
                
    } else {
        echo "Existing Equipment branch";  // Debugging output
    
                    $showError = true;
                }
            }
        
    } else {
        echo "Existing Equipment branch";  // Debugging output
    
            // Record does not exist, perform insert
            
    if (isset($_POST['asset3']) && $_POST['asset3'] === 'New Equipment') {
        echo "New Equipment branch";  // Debugging output
    
                $sql_thirdinsert = "INSERT INTO `thirdvehicle_quotation` (`uniqueid`, `asset_code2`, `yom2`, `make2`, `model2`, 
                    `sub_type2`, `category2`, `fuel/hour2`, `availability2`, `tentative_date2`, `cap2`, `cap_unit2`, 
                    `boom2`, `jib2`, `luffing2`, `rental_charges2`, `mob_charges2`, `demob_charges2`, `crane_location2`, `adblue2`)
                    VALUES ('$unique_id', '$asset_code3', '$yom3', '$newfleetmake3', '$newfleetmodel3', '$type3', '$fleet_category3', 
                    '$fuelperltr3', '$avail3', '$date3', '$fleetcap3', '$unit3', '$boomLength3', '$jibLength3', '$luffingLength3', 
                    '$rental3', '$mob03', '$demob03', '$equiplocation03', '$adblue3')";
                $result_thirdinsert_sql = mysqli_query($conn, $sql_thirdinsert) or die(mysqli_error($conn));
            } else if (isset($_POST['asset3']) && $_POST['asset3'] !== 'New Equipment') {
                $sql_final_insert3 = "INSERT INTO `thirdvehicle_quotation` (`asset_code2`, `yom2`, `make2`, `model2`, `sub_type2`, 
                    `category2`, `fuel/hour2`, `availability2`, `tentative_date2`, `cap2`, `cap_unit2`, `boom2`, `jib2`, `luffing2`, 
                    `rental_charges2`, `mob_charges2`, `demob_charges2`, `crane_location2`, `adblue2`, `uniqueid`)
                    VALUES ('$asset_code3', '$yom3_prefill', '".$row_fleet3['make']."', '".$row_fleet3['model']."', 
                    '".$row_fleet3['sub_type']."', '".$row_fleet3['category']."', '$fuelperltr3', '$avail3', '$date3', 
                    '$capacity3_prefill', '".$row_fleet3['unit']."', '$boomLength3', '$jibLength3', '$luffingLength3', 
                    '$rental3', '$mob03', '$demob03', '$equiplocation03', '$adblue3', '$unique_id')";
                $result_final_insertion3 = mysqli_query($conn, $sql_final_insert3) or die(mysqli_error($conn));
            }
    
            if (isset($result_thirdinsert_sql) || isset($result_final_insertion3)) {
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['success'] = 'success';
                header("Location: generate_quotation_landingpage.php");
                exit;
            
    } else {
        echo "Existing Equipment branch";  // Debugging output
    
                $showError = true;
            }
        }
    
    } else {
        echo "Existing Equipment branch";  // Debugging output
    
        $showError = true; // Handle database error
    }
    



}
    ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">      <link rel="icon" href="favicon.jpg" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="main.js" defer></script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>

    <title>Edit Quotation</title>
    <style><?php include "style.css" ?></style>
    <script src="autofill.js"defer></script>
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
      <span class="alertText_addfleet"><b>Success! Quotation Edited 
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
?>
<form action="edit_quotation.php?quote_id=<?php echo htmlspecialchars(urlencode($edit_quotation)); ?>" method="POST" autocomplete="off" class="generate_quotation" enctype="multipart/form-data">
        <div class="generate_quote_container">
        <div class="generate_quote_heading">Edit Quotation</div>
        <div class="outer02">
    <div class="trial1">
        <input type="date" placeholder="" value="<?php echo $row['quote_date'] ?>" name="quotation_date" class="input02" >
        <label for="" class="placeholder2"> Quotation Date</label>
        </div>
      <div class="trial1">
        <input type="text" placeholder="" value="<?php echo $row['ref_no'] ?>" class="input02" readonly>
        <label for="" class="placeholder2">Ref No</label>
      </div>  
    </div>
    <input type="hidden" value="<?php echo $row['uniqueid'] ?>" name="edit_uniqueid" >

        <div class="outer02">

        <div class="trial1">
        <input type="text" placeholder="" value="<?php echo $row['to_name'] ?>" name="to" class="input02" >
        <label for="" class="placeholder2">To</label>
        </div>
        <div class="trial1" id="salute_dd">
            <select name="salutation_dd"  class="input02">
                <option value="Mr">Mr</option>
                <option value="Ms">Ms</option>
            </select>
        </div>

        <div class="trial1">
        <input type="text" placeholder="" name="contact_person" value="<?php echo $row['contact_person'] ?>" class="input02" >
        <label for="" class="placeholder2">Contact Person</label>
        </div>

        </div>
        <div class="outer02">
        <div class="trial1">
        <input type="text" placeholder="" value="<?php echo $row['to_address'] ?>" name="to_address" class="input02" >
        <label for="" class="placeholder2">To Address</label>
        </div>

        <div class="trial1">
        <input type="text" placeholder="" value="<?php echo $row['contact_person_cell'] ?>" name="contact_number" class="input02" >
        <label for="" class="placeholder2">Contact Number</label>
        </div>
        
        <div class="trial1">
        <input type="text" placeholder="" value="<?php echo $row['email_id_contact_person'] ?>" name="email_id" class="input02" >
        <label for="" class="placeholder2">Email Id</label>
        </div>
        </div>
        <div class="outer02">
        <div class="trial1">
        <select name="asset_code1" class="input02" onchange="choose_new_equipment_edit()" id="assetcode">
            <option value="" disabled selected>Choose Asset Code</option>
            <option <?php if($row['asset_code']==='New Equipment'){ echo 'selected';} ?> value="New Equipment">Choose New Equipment</option>

            <?php
while ($row_asset_code = mysqli_fetch_assoc($result_asset_code)) {
    echo '<option value="' . $row_asset_code['assetcode'] . '"';
    if ($row['asset_code'] === $row_asset_code['assetcode']) {
        echo ' selected';
    }
    echo '>' . $row_asset_code['assetcode'] . ' (' . $row_asset_code['sub_type'] . ' ' . $row_asset_code['make'] . ' ' . $row_asset_code['model'] . ')</option>';
}
    ?>

        </select>
        </div>
            
        <div class="trial1">
            <select name="availability" id="availability_dd" class="input02" onchange="not_immediate()">
                <option value=""disabled selected>Availability</option>
                <option value="Immediate" <?php if($row['availability']==='Immediate'){ echo 'selected';} ?>>Immediate</option>
                <option value="Not Immediate" <?php if($row['availability']==='Not Immediate'){ echo 'selected';} ?>>Not Immediate</option>
            </select>
        </div>
        <div class="trial1" id="date_of_availability" >
            <input type="date" value="<?php echo $row['tentative_date'] ?>" name="tentative_date" placeholder="" class="input02">
            <label for="" class="placeholder2">Availability Date</label>
        </div>

        </div>
        <div class="prefetch_data_container" id="autofill_field_edit">
        <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" value="<?php echo $row['yom'] ?>" name="yom_equip" id="yom" class="input02">
                <label for="" class="placeholder2">YoM</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" value="<?php echo $row['cap'] ?>" name="capacity_equip" id="capacity" class="input02">
                <label for="" class="placeholder2">Capacity</label>
            </div>
            <input type="text" value="<?php echo $companyname001 ?>" id="comp_name_trial" hidden>

        </div>
        <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" value="<?php echo $row['boom'] ?>" name="boom_equip" id="boomlength" class="input02">
                <label for="" class="placeholder2">Boom Length</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" value="<?php echo $row['jib'] ?>" name="jib_equip" id="jiblength" class="input02">
                <label for="" class="placeholder2">Jib Length</label>
            </div>

            <div class="trial1">
                <input type="text" placeholder="" value="<?php echo $row['luffing'] ?>" name="luffing_equip" id="luffinglength" class="input02">
                <label for="" class="placeholder2">Luffing Length</label>
            </div>

            </div>
            </div>

 


        <div class="newequip_details1" id="newequipdet1">
        <div class="outer02" id="" >
        <div class="trial1">
        <select class="input02" name="fleet_category1" id="oem_fleet_type1" onchange="seco_equip()" >
            <option value="" disabled selected>Select Fleet Category</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['category']==='Aerial Work Platform'){echo 'selected';} ?> value="Aerial Work Platform">Aerial Work Platform</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['category']==='Concrete Equipment'){echo 'selected';} ?> value="Concrete Equipment">Concrete Equipment</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['category']==='EarthMovers and Road Equipments'){echo 'selected';} ?> value="EarthMovers and Road Equipments">EarthMovers and Road Equipments</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['category']==='Material Handling Equipments'){echo 'selected';} ?> value="Material Handling Equipments">Material Handling Equipments</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['category']==='Ground Engineering Equipments'){echo 'selected';} ?> value="Ground Engineering Equipments">Ground Engineering Equipments</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['category']==='Trailor and Truck'){echo 'selected';} ?> value="Trailor and Truck">Trailor and Truck</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['category']==='Generator and Lighting'){echo 'selected';} ?> value="Generator and Lighting">Generator and Lighting</option>
        </select>

        </div>
        <div class="trial1">
        <select class="input02" name="type1" id="fleet_sub_type1" >
            <option value="" disabled selected>Select Fleet Type</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Self Propelled Articulated Boomlift'){ echo 'selected';} ?> value="Self Propelled Articulated Boomlift"class="awp_options1"  >Self Propelled Articulated Boomlift</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Scissor Lift Diesel'){ echo 'selected';} ?> value="Scissor Lift Diesel" class="awp_options1" >Scissor Lift Diesel</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Scissor Lift Electric'){ echo 'selected';} ?> value="Scissor Lift Electric"class="awp_options1"  >Scissor Lift Electric</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Spider Lift'){ echo 'selected';} ?> value="Spider Lift"class="awp_options1"  >Spider Lift</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Self Propelled Straight Boomlift'){ echo 'selected';} ?> value="Self Propelled Straight Boomlift"class="awp_options1"  >Self Propelled Straight Boomlift</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Truck Mounted Articulated Boomlift'){ echo 'selected';} ?> value="Truck Mounted Articulated Boomlift"class="awp_options1"  >Truck Mounted Articulated Boomlift</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Truck Mounted Straight Boomlift'){ echo 'selected';} ?> value="Truck Mounted Straight Boomlift"class="awp_options1"  >Truck Mounted Straight Boomlift</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Batching Plant'){ echo 'selected';} ?> value="Batching Plant"class="cq_options1" >Batching Plant</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Self Loading Mixer'){ echo 'selected';} ?> value="Self Loading Mixer"class="cq_options1" >Self Loading Mixer</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Concrete Boom Placer'){ echo 'selected';} ?> value="Concrete Boom Placer"class="cq_options1" >Concrete Boom Placer</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Concrete Pump'){ echo 'selected';} ?> value="Concrete Pump"class="cq_options1" >Concrete Pump</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Moli Pump'){ echo 'selected';} ?> value="Moli Pump"class="cq_options1" >Moli Pump</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Mobile Batching Plant'){ echo 'selected';} ?> value="Mobile Batching Plant"class="cq_options1" >Mobile Batching Plant</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Static Boom Placer'){ echo 'selected';} ?> value="Static Boom Placer"class="cq_options1" >Static Boom Placer</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Transit Mixer'){ echo 'selected';} ?> value="Transit Mixer"class="cq_options1" >Transit Mixer</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Baby Roller'){ echo 'selected';} ?> value="Baby Roller" class="earthmover_options1" >Baby Roller</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Backhoe Loader'){ echo 'selected';} ?> value="Backhoe Loader" class="earthmover_options1" >Backhoe Loader</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Bulldozer'){ echo 'selected';} ?> value="Bulldozer" class="earthmover_options1" >Bulldozer</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Excavator'){ echo 'selected';} ?> value="Excavator" class="earthmover_options1" >Excavator</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Milling Machine'){ echo 'selected';} ?> value="Milling Machine" class="earthmover_options1" >Milling Machine</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Motor Grader'){ echo 'selected';} ?> value="Motor Grader" class="earthmover_options1" >Motor Grader</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Pneumatic Tyre Roller'){ echo 'selected';} ?> value="Pneumatic Tyre Roller" class="earthmover_options1" >Pneumatic Tyre Roller</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Single Drum Roller'){ echo 'selected';} ?> value="Single Drum Roller" class="earthmover_options1" >Single Drum Roller</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Skid Loader'){ echo 'selected';} ?> value="Skid Loader" class="earthmover_options1" >Skid Loader</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Slip Form Paver'){ echo 'selected';} ?> value="Slip Form Paver" class="earthmover_options1" >Slip Form Paver</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Soil Compactor'){ echo 'selected';} ?> value="Soil Compactor" class="earthmover_options1" >Soil Compactor</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Tandem Roller'){ echo 'selected';} ?> value="Tandem Roller" class="earthmover_options1" >Tandem Roller</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Vibratory Roller'){ echo 'selected';} ?> value="Vibratory Roller" class="earthmover_options1" >Vibratory Roller</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Wheeled Excavator'){ echo 'selected';} ?> value="Wheeled Excavator" class="earthmover_options1" >Wheeled Excavator</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Wheeled Loader'){ echo 'selected';} ?> value="Wheeled Loader" class="earthmover_options1" >Wheeled Loader</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Fixed Tower Crane'){ echo 'selected';} ?>   class="mhe_options1" value="Fixed Tower Crane">Fixed Tower Crane</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Fork Lift Diesel'){ echo 'selected';} ?>  class="mhe_options1" value="Fork Lift Diesel">Fork Lift Diesel</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Fork Lift Electric'){ echo 'selected';} ?>  class="mhe_options1" value="Fork Lift Electric">Fork Lift Electric</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Hammerhead Tower Crane'){ echo 'selected';} ?>  class="mhe_options1" value="Hammerhead Tower Crane">Hammerhead Tower Crane</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Hydraulic Crawler Crane'){ echo 'selected';} ?>  class="mhe_options1" value="Hydraulic Crawler Crane">Hydraulic Crawler Crane</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Luffing Jib Tower Crane'){ echo 'selected';} ?>  class="mhe_options1" value="Luffing Jib Tower Crane">Luffing Jib Tower Crane</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Mechanical Crawler Crane'){ echo 'selected';} ?>  class="mhe_options1" value="Mechanical Crawler Crane">Mechanical Crawler Crane</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Pick and Carry Crane'){ echo 'selected';} ?>  class="mhe_options1" value="Pick and Carry Crane">Pick and Carry Crane</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Reach Stacker'){ echo 'selected';} ?>  class="mhe_options1" value="Reach Stacker">Reach Stacker</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Rough Terrain Crane'){ echo 'selected';} ?>  class="mhe_options1" value="Rough Terrain Crane">Rough Terrain Crane</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Telehandler'){ echo 'selected';} ?>  class="mhe_options1" value="Telehandler">Telehandler</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Telescopic Crawler Crane'){ echo 'selected';} ?>  class="mhe_options1" value="Telescopic Crawler Crane">Telescopic Crawler Crane</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Telescopic Mobile Crane'){ echo 'selected';} ?>  class="mhe_options1" value="Telescopic Mobile Crane">Telescopic Mobile Crane</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='All Terrain Mobile Crane'){ echo 'selected';} ?>  class="mhe_options1" value="All Terrain Mobile Crane">All Terrain Mobile Crane</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Self Loading Truck Crane'){ echo 'selected';} ?>  class="mhe_options1" value="Self Loading Truck Crane">Self Loading Truck Crane</option>

            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Hydraulic Drilling Rig'){ echo 'selected';} ?>  class="gee_options1" value="Hydraulic Drilling Rig">Hydraulic Drilling Rig</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Rotary Drilling Rig'){ echo 'selected';} ?>  class="gee_options1" value="Rotary Drilling Rig">Rotary Drilling Rig</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Vibro Hammer'){ echo 'selected';} ?>  class="gee_options1" value="Vibro Hammer">Vibro Hammer</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Dumper'){ echo 'selected';} ?>   class="trailor_options1" value="Dumper">Dumper</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Truck'){ echo 'selected';} ?>   class="trailor_options1" value="Truck">Truck</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Water Tanker'){ echo 'selected';} ?>   class="trailor_options1" value="Water Tanker">Water Tanker</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Low Bed'){ echo 'selected';} ?>   class="trailor_options1" value="Low Bed">Low Bed</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Semi Low Bed'){ echo 'selected';} ?>   class="trailor_options1" value="Semi Low Bed">Semi Low Bed</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Flatbed'){ echo 'selected';} ?>  class="trailor_options1" value="Flatbed">Flatbed</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Hydraulic Axle'){ echo 'selected';} ?>  class="trailor_options1" value="Hydraulic Axle">Hydraulic Axle</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Silent Diesel Generator'){ echo 'selected';} ?>  class="generator_options" value="Silent Diesel Generator">Silent Diesel Generator</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Mobile Light Tower'){ echo 'selected';} ?>  class="generator_options" value="Mobile Light Tower">Mobile Light Tower</option>
            <option <?php if($row['asset_code']==='New Equipment' && $row['sub_Type']==='Diesel Generator'){ echo 'selected';} ?>  class="generator_options" value="Diesel Generator">Diesel Generator</option>
        </select>

        </div>
    </div>
    <div class="outer02" id="">
        <div class="trial1">
            <input type="text" value="<?php echo $row['make'] ?>" placeholder="" name="newfleetmake1" class="input02">
            <label for="" class="placeholder2">Fleet Make</label>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" value="<?php echo $row['model'] ?>" name="newfleetmodel1" class="input02">
            <label for="" class="placeholder2">Fleet Model</label>
        </div>

    </div>
    <div class="outer02" id="">
        <div class="trial1">
            <input type="text" placeholder="" value="<?php echo $row['cap'] ?>" name="fleetcap2" class="input02" >
            <label for="" class="placeholder2">Fleet Capacity</label>
        </div>
        <div class="trial1" id="newfleet_unit">
            <select name="unit2" id="" class="input02">
                <option value=""disabled selected>Unit</option>
                <option <?php if($row['cap_unit']==='Ton'){ echo 'selected';} ?> value="Ton">Ton</option>
                <option <?php if($row['cap_unit']==='Meter'){ echo 'selected';} ?> value="Meter">Meter</option>
                <option <?php if($row['cap_unit']==='m^3'){ echo 'selected';} ?> value="m^3">M³</option>
            </select>
        </div>
        <div class="trial1">
            <input type="number" value="<?php echo $row['yom'] ?>" placeholder="" name="yom2" class="input02" min="1900" max="2099">
            <label for="" class="placeholder2">YOM</label>
        </div>
    </div>
    <div class="outer02" id="">
    <div class="trial1" >
            <input type="text" value="<?php echo $row['boom'] ?>" name="boomLength2"  placeholder="" class=" input02" >
            <label class="placeholder2">Boom Length</label>
        </div>    
        <div class="trial1" >
            <input type="text" value="<?php echo $row['jib'] ?>" name="jibLength2"  placeholder="" class="input02 " >
            <label class="placeholder2">Jib Length</label>
        </div>
        <div class="trial1">
            <input type="text" value="<?php echo $row['luffing'] ?>" name="luffingLength2"  placeholder="" class=" input02" >
            <label class="placeholder2">Luffing Length</label>
        </div>
    </div>

            </div>
        <div class="outer02">
        <div class="trial1">
            <select name="shiftinfo" id="select_shift" class="input02"  onchange="shift_hour()">
                <option  value=""disabled selected>Select Shift</option>
                <option <?php if($row['shift_info']==='Single Shift'){ echo 'selected';} ?> value="Single Shift">Single Shift</option>
                <option <?php if($row['shift_info']==='Double Shift'){ echo 'selected';} ?> value="Double Shift">Double Shift</option>
                <option <?php if($row['shift_info']==='Flexi Shift'){ echo 'selected';} ?> value="Flexi Shift">Flexi Shift</option>
            </select>
        </div>
        <div class="trial1" id="othershift_enginehour">
        <select name="engine_hour" id="" class="input02">
            <option value=""disabled selected>Engine Hours</option>
            <option <?php (if$row['engine_hours']==='200'){echo 'selected';} ?> value="200">200 Hours</option>
            <option <?php (if$row['engine_hours']==='208'){echo 'selected';} ?> value="208">208 Hours</option>
            <option <?php (if$row['engine_hours']==='260'){echo 'selected';} ?> value="260">260 Hours</option>
            <option <?php (if$row['engine_hours']==='270'){echo 'selected';} ?> value="270">270 Hours</option>
            <option <?php (if$row['engine_hours']==='280'){echo 'selected';} ?> value="280">280 Hours</option>
            <option <?php (if$row['engine_hours']==='300'){echo 'selected';} ?> value="300">300 Hours</option>
            <option <?php (if$row['engine_hours']==='312'){echo 'selected';} ?> value="312">312 Hours</option>
            <option <?php (if$row['engine_hours']==='360'){echo 'selected';} ?> value="360">360 Hours</option>
            <option <?php (if$row['engine_hours']==='400'){echo 'selected';} ?> value="400">400 Hours</option>
            <option <?php (if$row['engine_hours']==='416'){echo 'selected';} ?> value="416">416 Hours</option>
            <option <?php (if$row['engine_hours']==='460'){echo 'selected';} ?> value="460">460 Hours</option>
            <option <?php (if$row['engine_hours']==='572'){echo 'selected';} ?> value="572">572 Hours</option>
            <option <?php (if$row['engine_hours']==='672'){echo 'selected';} ?> value="672">672 Hours</option>
            <option <?php (if$row['engine_hours']==='720'){echo 'selected';} ?> value="720">720 Hours</option>
        </select>
    </div>
    <div class="trial1" id="single_Shift_hour">
            <!-- <input type="text" class="input02" value="<?php echo $row['hours_duration'] ?>" name="hours_duration" placeholder="" >
            <label class="placeholder2" for="">Shift Duration</label> -->
            <select name="hours_duration" id="" class="input02">
                <option value="">Shift Duration</option>
                <option <?php if($row['hours_duration']==='8'){ echo 'selected';} ?> value="8">8 Hours</option>
                <option <?php if($row['hours_duration']==='10'){ echo 'selected';} ?> value="10">10 Hours</option>
                <option <?php if($row['hours_duration']==='12'){ echo 'selected';} ?> value="12">12 Hours</option>
                <option <?php if($row['hours_duration']==='14'){ echo 'selected';} ?> value="14">14 Hours</option>
                <option <?php if($row['hours_duration']==='16'){ echo 'selected';} ?> value="16">16 Hours</option>
            </select>

        </div>
        <div class="trial1">
        <input type="text" placeholder="" value="<?php echo $row['site_loc'] ?>" name="site_location" class="input02" >
        <label for="" class="placeholder2">Site Location</label>
        </div>

        <div class="trial1">
            <input type="text" name="location" value="<?php echo $row['crane_location'] ?>" placeholder="" class="input02">
            <label for="" class="placeholder2"> Equipment Location </label>
 
        </div>

    </div>
        <div class="outer02">
        <div class="trial1">
            <!-- <input type="text" class="input02" value="<?php echo $row['days_duration'] ?>"  name="days_duration" placeholder="">
            <label class="placeholder2" for="">Days/Month</label> -->
            <select name="days_duration" id="" class="input02" required>
                <option value="" disabled>Working Days</option>
                <option <?php if($row['days_duration']==='26'){ echo 'selected';} ?> value="26" >26 Days/Month</option>
                <option <?php if($row['days_duration']==='28'){ echo 'selected';} ?> value="28">28 Days/Month</option>
                <option <?php if($row['days_duration']==='30'){ echo 'selected';} ?> value="30">30 Days/Month</option>
            </select>

        </div>
        <div class="trial1">
            <select name="condition" id="" class="input02">
                <option value=""disabled selected>Condition</option>
                <option value="Including Sundays" <?php if($row['sunday_included']==='Including Sundays'){ echo 'selected';} ?>>Including Sundays</option>
                <option value="Excluding First Two Sundays" <?php if($row['sunday_included']==='Excluding First Two Sundays'){ echo 'selected';} ?>>Excluding First Two Sundays</option>
                <option value="Excluding Any Two Sundays" <?php if($row['sunday_included']==='Excluding Any Two Sundays'){ echo 'selected';} ?>>Excluding Any Two Sundays</option>

                <option value="Excluding Sundays" <?php if($row['sunday_included']==='Excluding Sundays'){ echo 'selected';} ?>>Excluding Sundays</option>
            </select>
        </div>
        <div class="trial1">
            <select name="adblue" id="" class="input02">
                <option value=""disabled selected>Adblue?</option>
                <option value="Yes"<?php if($row['adblue']==='Yes'){ echo 'selected';} ?>>Yes</option>
                <option value="No" <?php if($row['adblue']==='No'){ echo 'selected';} ?>>No</option>
            </select>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" value="<?php echo $row['fuel/hour'] ?>" name="fuel_per_hour" class="input02">
            <label for="" class="placeholder2">Fuel/Hour</label>
        </div>

        </div>
        <div class="outer02">
        <div class="trial1">
            <input type="text" name="rental_charges" value="<?php echo $row['rental_charges'] ?>" placeholder="" class="input02">
            <label for="" class="placeholder2">Rental Charges </label>
        </div>
        <div class="trial1">
            <input type="text" name="mob_charges" value="<?php echo $row['mob_charges'] ?>" placeholder="" class="input02">
            <label for="" class="placeholder2">Mob Charges </label>
        </div>
        <div class="trial1">
            <input type="text" name="demob_charges" placeholder="" value="<?php echo $row['demob_charges'] ?>" class="input02">
            <label for="" class="placeholder2">Demob Charges </label>
        </div>
        </div>
        
<div class="outer02">
    <div class="trial1">
        <input type="text" name="sender" value="<?php echo $row['sender_name'] ?>" placeholder="" class="input02">
        <label for="" class="placeholder2">Senders Name</label>
    </div>
    <div class="trial1">
        <input type="text" name="sender_number" value="<?php echo $row['sender_number'] ?>" placeholder="" class="input02">
        <label for="" class="placeholder2">Senders Contact Number</label>
    </div>
    <div class="trial1">
        <input type="text" name="sender_email" value="<?php echo $row['sender_contact'] ?>" placeholder="" class="input02">
        <label for="" class="placeholder2">Senders Email</label>
    </div>
</div>
<div class="trial1" style="display: none;">
<textarea placeholder="" name="sender_office_address" class="input02"><?php echo $row['sender_office_address']; ?></textarea>
    <label for="" class="placeholder2">Sender Office Address</label>
</div>

<div class="addbuttonicon" id="second_addequipbtn"><i onclick="other_quotation()"  class="bi bi-plus-circle">Add Another Equipment</i></div>

<!-- second row -->
<div class="otherquipquote" id="new_out1">
        <br>
        <p>Add Second Equipment Details</p>
    <div class="outer02 mt-10px" >
        <div class="trial1">
        <select  name="asset_code7" class="input02" onchange="choose_new_equipment2_edit()" id="choose_Ac2">
            <option value="" disabled selected>Choose Asset Code</option>
            <option value="New Equipment" <?php if(isset($row_second['asset_code2']) && $row_second['asset_code2'] === 'New Equipment'){ echo 'selected'; } ?>>Choose New Equipment</option>
            <?php
while ($row_asset_code2 = mysqli_fetch_assoc($result_asset_code2)) {
    echo '<option value="' . htmlspecialchars($row_asset_code2['assetcode']) . '"';
    if (isset($row_second['asset_code2']) && $row_second['asset_code2'] === $row_asset_code2['assetcode']) {
        echo ' selected';
    }
    echo '>' . htmlspecialchars($row_asset_code2['assetcode']) . ' (' . htmlspecialchars($row_asset_code2['sub_type']) . ' ' . htmlspecialchars($row_asset_code2['make']) . ' ' . htmlspecialchars($row_asset_code2['model']) . ')' . '</option>';
}
?>
        </select>
        </div>
        <div class="trial1">
            <select name="avail1" id="availability_dd2" class="input02" onchange="not_immediate2()">
                <option value=""disabled selected>Availability</option>
                <option <?php if(isset($row_second['availability2']) && $row_second['availability2']==='Immediate'){echo 'selected';} ?> value="Immediate">Immediate</option>
                <option <?php if(isset($row_second['availability2']) && $row_second['availability2']==='Not Immediate'){echo 'selected';} ?> value="Not Immediate">Select A Date</option>
            </select>
        </div>
        <div class="trial1" id="date_of_availability2" >
            <input type="date" placeholder="" value="<?php if(isset($row_second['tentative_date2'])) {echo $row_second['tentative_date2'];} ?>" name="date_" class="input02">
            <label for="" class="placeholder2">Tentative Date Of Availability</label>
        </div>

        </div>
        <div class="prefilldata_secondvehicle" id="sec_equipment_prefill_fields">
        <div class="outer02">
            <div class="trial1">
            <input type="text" placeholder="" value="<?php if(isset($row_second['yom2'])){ echo $row_second['yom2'];} ?>" name="yom_equip_second" id="yom_second" class="input02">
            <label for="" class="placeholder2">YoM</label>
            </div>
            <div class="trial1">
            <input type="text" placeholder="" value="<?php if(isset($row_second['cap2'])){ echo $row_second['cap2'];} ?>" name="capacity_equip_second" id="capacity_second" class="input02">
            <label for="" class="placeholder2">Capacity</label>
            </div>

        
        </div>
        <div class="outer02">
            <div class="trial1">
            <input type="text" value="<?php if(isset($row_second['boom2'])){ echo $row_second['boom2'];} ?>" placeholder="" name="boom_equip_second" id="boomlength_second" class="input02">
            <label for="" class="placeholder2">Boom Length</label>
            </div>
            <div class="trial1">
            <input type="text" placeholder="" value="<?php if(isset($row_second['jib2'])){ echo $row_second['jib2'];} ?>" name="jib_equip_second" id="jiblength_second" class="input02">
            <label for="" class="placeholder2">Jib Length</label>
            </div>

            <div class="trial1">
            <input type="text" placeholder="" value="<?php if(isset($row_second['luffing2'])){ echo $row_second['luffing2'];} ?>" name="luffing_equip_second" id="luffinglength_second" class="input02">
            <label for="" class="placeholder2">Luffing Length</label>
            </div>

        
        </div>
        </div>

        <div class="newequip_details1" id="newequipdet7">
        <div class="outer02" id="" >
        <div class="trial1">
        <select class="input02" name="fleet_category7" id="oem_fleet_type7" onchange="seco_equip_2()" >
            <option value="" disabled selected>Select Fleet Category</option>
            <option <?php if(isset($row_second) && $row_second['category2']==='Aerial Work Platform'){ echo 'selected';} ?> value="Aerial Work Platform">Aerial Work Platform</option>
            <option <?php if(isset($row_second) && $row_second['category2']==='Concrete Equipment'){ echo 'selected';} ?> value="Concrete Equipment">Concrete Equipment</option>
            <option <?php if(isset($row_second) && $row_second['category2']==='EarthMovers and Road Equipments'){ echo 'selected';} ?> value="EarthMovers and Road Equipments">EarthMovers and Road Equipments</option>
            <option <?php if(isset($row_second) && $row_second['category2']==='Material Handling Equipments'){ echo 'selected';} ?> value="Material Handling Equipments">Material Handling Equipments</option>
            <option <?php if(isset($row_second) && $row_second['category2']==='Ground Engineering Equipments'){ echo 'selected';} ?> value="Ground Engineering Equipments">Ground Engineering Equipments</option>
            <option <?php if(isset($row_second) && $row_second['category2']==='Trailor and Truck'){ echo 'selected';} ?> value="Trailor and Truck">Trailor and Truck</option>
            <option <?php if(isset($row_second) && $row_second['category2']==='Generator and Lighting'){ echo 'selected';} ?> value="Generator and Lighting">Generator and Lighting</option>
        </select>

        </div>
        <div class="trial1">
        <select class="input02" name="type7" id="fleet_sub_type1" >
        <option value="" disabled selected>Select Fleet Type</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Self Propelled Articulated Boomlift'){ echo 'selected'; } ?> value="Self Propelled Articulated Boomlift" class="awp_options7">Self Propelled Articulated Boomlift</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Scissor Lift Diesel'){ echo 'selected'; } ?> value="Scissor Lift Diesel" class="awp_options7">Scissor Lift Diesel</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Scissor Lift Electric'){ echo 'selected'; } ?> value="Scissor Lift Electric" class="awp_options7">Scissor Lift Electric</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Spider Lift'){ echo 'selected'; } ?> value="Spider Lift" class="awp_options7">Spider Lift</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Self Propelled Straight Boomlift'){ echo 'selected'; } ?> value="Self Propelled Straight Boomlift" class="awp_options7">Self Propelled Straight Boomlift</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Truck Mounted Articulated Boomlift'){ echo 'selected'; } ?> value="Truck Mounted Articulated Boomlift" class="awp_options7">Truck Mounted Articulated Boomlift</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Truck Mounted Straight Boomlift'){ echo 'selected'; } ?> value="Truck Mounted Straight Boomlift" class="awp_options7">Truck Mounted Straight Boomlift</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Batching Plant'){ echo 'selected'; } ?> value="Batching Plant" class="cq_options7">Batching Plant</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Self Loading Mixer'){ echo 'selected'; } ?> value="Self Loading Mixer" class="cq_options7">Self Loading Mixer</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Concrete Boom Placer'){ echo 'selected'; } ?> value="Concrete Boom Placer" class="cq_options7">Concrete Boom Placer</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Concrete Pump'){ echo 'selected'; } ?> value="Concrete Pump" class="cq_options7">Concrete Pump</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Moli Pump'){ echo 'selected'; } ?> value="Moli Pump" class="cq_options7">Moli Pump</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Mobile Batching Plant'){ echo 'selected'; } ?> value="Mobile Batching Plant" class="cq_options7">Mobile Batching Plant</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Static Boom Placer'){ echo 'selected'; } ?> value="Static Boom Placer" class="cq_options7">Static Boom Placer</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Transit Mixer'){ echo 'selected'; } ?> value="Transit Mixer" class="cq_options7">Transit Mixer</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Baby Roller'){ echo 'selected'; } ?> value="Baby Roller" class="earthmover_options7">Baby Roller</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Backhoe Loader'){ echo 'selected'; } ?> value="Backhoe Loader" class="earthmover_options7">Backhoe Loader</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Bulldozer'){ echo 'selected'; } ?> value="Bulldozer" class="earthmover_options7">Bulldozer</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Excavator'){ echo 'selected'; } ?> value="Excavator" class="earthmover_options7">Excavator</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Milling Machine'){ echo 'selected'; } ?> value="Milling Machine" class="earthmover_options7">Milling Machine</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Motor Grader'){ echo 'selected'; } ?> value="Motor Grader" class="earthmover_options7">Motor Grader</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Pneumatic Tyre Roller'){ echo 'selected'; } ?> value="Pneumatic Tyre Roller" class="earthmover_options7">Pneumatic Tyre Roller</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Single Drum Roller'){ echo 'selected'; } ?> value="Single Drum Roller" class="earthmover_options7">Single Drum Roller</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Skid Loader'){ echo 'selected'; } ?> value="Skid Loader" class="earthmover_options7">Skid Loader</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Slip Form Paver'){ echo 'selected'; } ?> value="Slip Form Paver" class="earthmover_options7">Slip Form Paver</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Soil Compactor'){ echo 'selected'; } ?> value="Soil Compactor" class="earthmover_options7">Soil Compactor</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Tandem Roller'){ echo 'selected'; } ?> value="Tandem Roller" class="earthmover_options7">Tandem Roller</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Vibratory Roller'){ echo 'selected'; } ?> value="Vibratory Roller" class="earthmover_options7">Vibratory Roller</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Wheeled Excavator'){ echo 'selected'; } ?> value="Wheeled Excavator" class="earthmover_options7">Wheeled Excavator</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Wheeled Loader'){ echo 'selected'; } ?> value="Wheeled Loader" class="earthmover_options7">Wheeled Loader</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Fixed Tower Crane'){ echo 'selected'; } ?> value="Fixed Tower Crane" class="mhe_options7">Fixed Tower Crane</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Fork Lift Diesel'){ echo 'selected'; } ?> value="Fork Lift Diesel" class="mhe_options7">Fork Lift Diesel</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Fork Lift Electric'){ echo 'selected'; } ?> value="Fork Lift Electric" class="mhe_options7">Fork Lift Electric</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Hammerhead Tower Crane'){ echo 'selected'; } ?> value="Hammerhead Tower Crane" class="mhe_options7">Hammerhead Tower Crane</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Hydraulic Crawler Crane'){ echo 'selected'; } ?> value="Hydraulic Crawler Crane" class="mhe_options7">Hydraulic Crawler Crane</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Luffing Jib Tower Crane'){ echo 'selected'; } ?> value="Luffing Jib Tower Crane" class="mhe_options7">Luffing Jib Tower Crane</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Mechanical Crawler Crane'){ echo 'selected'; } ?> value="Mechanical Crawler Crane" class="mhe_options7">Mechanical Crawler Crane</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Pick and Carry Crane'){ echo 'selected'; } ?> value="Pick and Carry Crane" class="mhe_options7">Pick and Carry Crane</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Reach Stacker'){ echo 'selected'; } ?> value="Reach Stacker" class="mhe_options7">Reach Stacker</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Rough Terrain Crane'){ echo 'selected'; } ?> value="Rough Terrain Crane" class="mhe_options7">Rough Terrain Crane</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Telehandler'){ echo 'selected'; } ?> value="Telehandler" class="mhe_options7">Telehandler</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Telescopic Crawler Crane'){ echo 'selected'; } ?> value="Telescopic Crawler Crane" class="mhe_options7">Telescopic Crawler Crane</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Telescopic Mobile Crane'){ echo 'selected'; } ?> value="Telescopic Mobile Crane" class="mhe_options7">Telescopic Mobile Crane</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='All Terrain Mobile Crane'){ echo 'selected'; } ?> value="All Terrain Mobile Crane" class="mhe_options7">All Terrain Mobile Crane</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Self Loading Truck Crane'){ echo 'selected'; } ?> value="Self Loading Truck Crane" class="mhe_options7">Self Loading Truck Crane</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Hydraulic Drilling Rig'){ echo 'selected'; } ?> value="Hydraulic Drilling Rig" class="gee_options7">Hydraulic Drilling Rig</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Rotary Drilling Rig'){ echo 'selected'; } ?> value="Rotary Drilling Rig" class="gee_options7">Rotary Drilling Rig</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Vibro Hammer'){ echo 'selected'; } ?> value="Vibro Hammer" class="gee_options7">Vibro Hammer</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Dumper'){ echo 'selected'; } ?> value="Dumper" class="trailor_options7">Dumper</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Truck'){ echo 'selected'; } ?> value="Truck" class="trailor_options7">Truck</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Water Tanker'){ echo 'selected'; } ?> value="Water Tanker" class="trailor_options7">Water Tanker</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Low Bed'){ echo 'selected'; } ?> value="Low Bed" class="trailor_options7">Low Bed</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Semi Low Bed'){ echo 'selected'; } ?> value="Semi Low Bed" class="trailor_options7">Semi Low Bed</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Flatbed'){ echo 'selected'; } ?> value="Flatbed" class="trailor_options7">Flatbed</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Hydraulic Axle'){ echo 'selected'; } ?> value="Hydraulic Axle" class="trailor_options7">Hydraulic Axle</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Silent Diesel Generator'){ echo 'selected'; } ?> value="Silent Diesel Generator" class="generator_options7">Silent Diesel Generator</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Mobile Light Tower'){ echo 'selected'; } ?> value="Mobile Light Tower" class="generator_options7">Mobile Light Tower</option>
    <option <?php if(isset($row_second['sub_type2']) && $row_second['sub_type2']==='Diesel Generator'){ echo 'selected'; } ?> id="generator_option3" value="Diesel Generator" class="generator_options7">Diesel Generator</option>        </select>

        </div>
    </div>
    <div class="outer02" id="">
        <div class="trial1">
            <input type="text" placeholder="" value="<?php if(isset($row_second['make2'])){ echo $row_second['make2'] ;}?>" name="newfleetmake7" class="input02">
            <label for="" class="placeholder2">Fleet Make</label>
        </div>
        <div class="trial1">
        <input type="text" placeholder="" value="<?php if(isset($row_second['model2'])) { echo $row_second['model2']; } ?>" name="newfleetmodel7" class="input02">
        <label for="" class="placeholder2">Fleet Model</label>
        </div>

    </div>
    <div class="outer02" id="">
        <div class="trial1">
            <input type="text"  value="<?php if(isset($row_second['cap2'])){ echo $row_second['cap2'];} ?>" placeholder="" name="fleetcap7" class="input02">
            <label for="" class="placeholder2">Fleet Capacity</label>
        </div>
        <div class="trial1" id="newfleet_unit">
            <select name="unit7" id="" class="input02">
                <option  value=""disabled selected>Unit</option>
                <option <?php if(isset($row_second['cap_unit2']) && $row_second['cap_unit2']==='Ton'){ echo 'selected';} ?> value="Ton">Ton</option>
                <option <?php if(isset($row_second['cap_unit2']) && $row_second['cap_unit2']==='Meter'){ echo 'selected';} ?> value="Meter">Meter</option>
                <option <?php if(isset($row_second['cap_unit2']) && $row_second['cap_unit2']==='m^3'){ echo 'selected';} ?> value="m^3">M³</option>
            </select>
        </div>
        <div class="trial1">
            <input type="number" placeholder="" name="yom7" value="<?php if(isset($row_second['yom3'])) {echo $row_second['yom2'];} ?>" class="input02" min="1900" max="2099">
            <label for="" class="placeholder2">YOM</label>
        </div>
    </div>
    <div class="outer02" id="">
    <div class="trial1" >
            <input type="text" value="<?php if(isset($row_second['boom2'])) {echo $row_second['boom2'];} ?>" name="boomLength7"  placeholder="" class=" input02" >
            <label class="placeholder2">Boom Length</label>
        </div>    
        <div class="trial1" >
            <input type="text" value="<?php if(isset($row_second['jib2'])){echo $row_second['jib2'];} ?>" name="jibLength7"  placeholder="" class="input02 " >
            <label class="placeholder2">Jib Length</label>
        </div>
        <div class="trial1">
            <input type="text" name="luffingLength7" value="<?php if(isset($row_second['luffing2'])) {echo $row_second['luffing2'];} ?>"  placeholder="" class=" input02" >
            <label class="placeholder2">Luffing Length</label>
        </div>
    </div>

    </div>
        <div class="outer02">
        <div class="trial1">
            <input type="text" name="rental2" value="<?php if(isset($row_second['rental_charges2'])) {echo $row_second['rental_charges2'];} ?>" placeholder="" class="input02">
            <label for="" class="placeholder2">Rental Charges </label>
        </div>
        <div class="trial1">
            <input type="text" name="mob02" placeholder="" value="<?php if(isset($row_second['mob_charges2'])) {echo $row_second['mob_charges2'];} ?>" class="input02">
            <label for="" class="placeholder2">Mob Charges </label>
        </div>
        <div class="trial1">
            <input type="text" name="demob02" value="<?php if(isset($row_second['demob_charges2'])) {echo $row_second['demob_charges2'];} ?>" placeholder="" class="input02">
            <label for="" class="placeholder2">Demob Charges </label>
        </div>
        </div>
        <div class="outer02">
        <div class="trial1">
            <input type="text" name="equiplocation02" value="<?php if(isset($row_second['crane_location2'])) {echo $row_second['crane_location2'];} ?>" placeholder="" class="input02">
            <label for="" class="placeholder2"> Equipment Location </label>
 
        </div>
        <div class="trial1">
            <select name="adblue2" id="" class="input02">
                <option value=""disabled selected>Adblue?</option>
                <option <?php if(isset($row_second['adblue2']) && $row_second['adblue2'] === 'Yes') { echo 'selected'; } ?> value="Yes">Yes</option>
                <option <?php if(isset($row_second['adblue2']) && $row_second['adblue2'] === 'No') { echo 'selected'; } ?> value="No">No</option>
            </select>
        </div>
        <div class="trial1">
            <input type="text"  value="<?php if(isset($row_second['fuel/hour2'])) {echo $row_second['fuel/hour2'];} ?>" placeholder="" name="fuelperltr2" class="input02">
            <label for="" class="placeholder2">Fuel in ltrs Per Hour</label>
        </div>
        </div>
        <div class="addbuttonicon" id="third_addequipbtn"><i onclick="third_vehicle()"  class="bi bi-plus-circle">Add Another Equipment</i></div>
        </div>

        
        <!-- thirdrow -->
         


         

         
         

        <div class="terms_container012">
    <p class="heading_terms">Terms & Conditions :

</p>
<p class="terms_condition">
    <strong>1.Working Shift :</strong>Start Time To Be
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
        <option <?php if(isset($row['working_end']) &&  $row['working_end']==='8'){ echo 'selected';} ?> value="8">8</option>
        <option <?php if(isset($row['working_end']) &&  $row['working_end']==='9'){ echo 'selected';} ?> value="9">9</option>
</select>
<select name="working_shift_end_unit" id="">
    <option <?php if(isset($row['working_end_unit']) && $row['working_end_unit'] === 'AM'){ echo 'selected';} ?> value="AM">AM</option>
    <option <?php if(isset($row['working_end_unit']) && $row['working_end_unit'] === 'PM'){ echo 'selected';} ?> value="PM" >PM</option>
    
</select>
<select name="lunch_time" id="lunchbreak">
    <option <?php if(isset($row['food_break']) && $row['food_break']==='including food break in each shift'){ echo 'selected';} ?> value="including food break in each shift">including food break in each shift</option>
    <option <?php if(isset($row['food_break']) && $row['food_break']==='excluding food break in each shift'){ echo 'selected';} ?> value="excluding food break in each shift">excluding food break in each shift</option>
</select>
</p>
<p class="terms_condition">
    <strong>2.Breakdown :</strong> 
    <select name="breakdown_select" id="breakdown_select">
        <option <?php if($row['brkdown']==='Free time - not applicable'){echo 'selected';} ?> value="Free time - not applicable">Free Time - Not Applicable</option>
        <option <?php if($row['brkdown']==='Free time - first 6 hours'){echo 'selected';} ?> value="Free time - first 6 hours">Free Time - First 6 Hours</option>
        <option <?php if($row['brkdown']==='Free time - first 12 hours'){echo 'selected';} ?> value="Free time - first 12 hours">Free Time - First 12 Hours</option>
    </select> 
    After free time, breakdown charges to be deducted on pro-rata basis
</p>
<p class="terms_condition">
    <strong>3.Operating Crew :</strong> 
    <select name="operating_crew_select" id="operating_crew_select">
        <option <?php if($row['crew']==='Single Operator'){echo 'selected';} ?> value="Single Operator">Single Operator</option>
        <option <?php if($row['crew']==='Double Operator'){echo 'selected';} ?> value="Double Operator">Double Operator</option>
        <option <?php if($row['crew']==='Single Operator + Helper'){echo 'selected';} ?> value="Single Operator + Helper">Single Operator + Helper</option>
        <option <?php if($row['crew']==='Double Operator + Helper'){echo 'selected';} ?> value="Double Operator + Helper">Double Operator + Helper</option>
    </select>
</p>

<p class="terms_condition">
    <strong>4.Operator Room Scope :</strong> 
    <select name="operator_room_scope_select" id="operator_room_scope_select">
        <option <?php if($row['room']==='Not Applicable'){ echo 'selected';} ?> value="Not Applicable">Not Applicable</option>
        <option <?php if($row['room']==='In Client Scope'){ echo 'selected';} ?> value="In Client Scope">In Client Scope</option>
        <option <?php if($row['room']==='In Rental Company Scope'){ echo 'selected';} ?> value="In Rental Company Scope">In Rental Company Scope</option>
    </select>
</p>

<p class="terms_condition">
    <strong>5.Crew Food Scope :</strong>  
    <select name="crew_food_scope_select" id="crew_food_scope_select">
        <option <?php if($row['food']==='Not Applicable'){echo 'selected';} ?> value="Not Applicable">Not Applicable</option>
        <option <?php if($row['food']==='In Client Scope'){echo 'selected';} ?> value="In Client Scope">In Client Scope</option>
        <option <?php if($row['food']==='In Rental Company Scope'){echo 'selected';} ?> value="In Rental Company Scope">In Rental Company Scope</option>
    </select>
</p>

<p class="terms_condition">
    <strong>6.Crew Travelling :</strong>  
    <select name="crew_travelling_select" id="crew_travelling_select">
        <option <?php if($row['travel']==='Not Applicable'){echo 'selected';} ?> value="Not Applicable">Not Applicable</option>
        <option <?php if($row['travel']==='In Client Scope'){echo 'selected';} ?> value="In Client Scope">In Client Scope</option>
        <option <?php if($row['travel']==='In Rental Company Scope'){echo 'selected';} ?> value="In Rental Company Scope">In Rental Company Scope</option>
    </select>
</p>
<p class="terms_condition">
    <strong>7.Fuel :</strong>Fuel shall be issued as per OEM norms by 
    <select name="fuel_scope" id="">
        <option <?php if($row['fuel_scope']==='Client'){ echo 'selected';} ?> value="Client">Client </option>
        <option <?php if($row['fuel_scope']==='Rental Company'){ echo 'selected';} ?> value="Rental Company">Rental Company</option>
    </select>
</p>


<p class="terms_condition"><strong>8.Adblue :</strong>Adblue if required to be provided by
<select name="adblue_scope" id="">
        <option <?php if($row['adblue_scope']==='Not applicable'){echo 'selected';} ?> value="Not Applicable">Not Applicable</option>

        <option <?php if($row['adblue_scope']==='Client'){ echo 'selected';} ?> value="Client">Client </option>
        <option <?php if($row['adblue_scope']==='Rental Company'){ echo 'selected';} ?> value="Rental Company">Rental Company</option>
    </select>

</p>
<p class="terms_condition">
    <strong>9.Period Of Contract :</strong> Minimum Order Shall Be 
    <select name="contract_period_select" id="contract_period_select">
        <option <?php if($row['period_contract']==='1 Month'){ echo 'selected';} ?> value="1 Month">1 Month</option>
        <option <?php if($row['period_contract']==='2 Month'){ echo 'selected';} ?> value="2 Month">2 Months</option>
        <option <?php if($row['period_contract']==='3 Month'){ echo 'selected';} ?> value="3 Month">3 Months</option>
        <option <?php if($row['period_contract']==='6 Month'){ echo 'selected';} ?> value="6 Month">6 Months</option>
        <option <?php if($row['period_contract']==='7 Month'){ echo 'selected';} ?> value="7 Month">7 Months</option>
        <option <?php if($row['period_contract']==='9 Month'){ echo 'selected';} ?> value="9 Month">9 Months</option>

        <option <?php if($row['period_contract']==='10 Month'){ echo 'selected';} ?> value="10 Month">10 Months</option>

        
        <option <?php if($row['period_contract']==='12 Month'){ echo 'selected';} ?> value="12 Month">12 Months</option>

        <option <?php if($row['period_contract']==='15 Month'){ echo 'selected';} ?> value="15 Month">15 Months</option>

        <option <?php if($row['period_contract']==='18 Month'){ echo 'selected';} ?> value="18 Month">18 Months</option>
        <option <?php if($row['period_contract']==='24 Month'){ echo 'selected';} ?> value="24 Month">24 Months</option>
    </select>
</p>
<p class="terms_condition" id="roadtaxselectcontainer">
    <strong>10. Working State Road Tax :</strong>if applicable road tax to be in scope of <select name="road_tax" id="roadtaxselect" onchange="roadtax_criteria()">
        <option <?php if($row['road_tax']==='not applicable'){ echo 'selected';} ?> value="not applicable">not applicable</option>
        <option <?php if($row['road_tax']==='client'){ echo 'selected';} ?> value="client">client</option>
        <option <?php if($row['road_tax']==='rental company'){ echo 'selected';} ?> value="rental company">rental company</option>
    </select>
    <select name="roadtax_condition" id="roadtaxcondition" onchange="lumsum_amount()">
        <option <?php if($row['roadtax_condition']==='as per recipt'){ echo 'selected';} ?> value="as per recipt">as per recipt</option>
        <option <?php if($row['roadtax_condition']==='lumsum amount'){echo 'selected';} ?> value="lumsum amount">lumsum amount</option>
    </select>
    <input type="text" id="enterlumsumamount" name="lumsumamount" placeholder="Enter amount">

</p>






<p class="terms_condition"><strong>11.Dehire Clause :</strong>  Dehire notice must be provided with a minimum 
<select name="dehire" id="">
    <option <?php if($row['dehire_clause']==='7 Days'){ echo 'selected';} ?> value="7 Days">7 Days</option>
    <option <?php if($row['dehire_clause']==='15 Days'){ echo 'selected';} ?> value="15 Days">15 Days</option>
    <option <?php if($row['dehire_clause']==='30 Days'){ echo 'selected';} ?> value="30 Days">30 Days</option>
</select> notice.</p>

<p class="terms_condition">
    <strong>12.Payment Terms :</strong> 
    <select name="payment_terms_select" id="payment_terms_select">
        <option <?php if($row['pay_terms']==='within 7 Days Of invoice submission'){echo 'selected';} ?> value="within 7 days Of invoice submission">Within 7 Days Of invoice submission</option>
        <option <?php if($row['pay_terms']==='within 10 Days Of invoice submission'){echo 'selected';} ?> value="within 10 Days Of invoice submission">Within 10 Days Of invoice submission</option>
        <option <?php if($row['pay_terms']==='within 30 Days Of invoice submission'){echo 'selected';} ?> value="within 30 Days Of invoice submission">Within 30 Days Of invoice submission</option>
        <option <?php if($row['pay_terms']==='within 45 Days Of invoice submission'){echo 'selected';} ?> value="within 45 Days Of invoice submission">Within 45 Days Of invoice submission</option>
    </select>
</p>

<p class="terms_condition">
    <strong>13.Advance Payment :</strong> 
    <select name="advance_payment_select" id="advance_payment_select">
        <option <?php if($row['adv_pay']==='Not applicable'){echo 'selected';} ?> value="Not Applicable">Not Applicable</option>
        <option <?php if($row['adv_pay']==='applicable - mob charges'){echo 'selected';} ?> value="applicable - mob charges" >applicable - mob charges</option>
        <option <?php if($row['adv_pay']==='applicable - mob + rental charges'){echo 'selected';} ?> value="applicable - mob + rental charges">Applicable - Mobilization + Rental Charges</option>
        <option <?php if($row['adv_pay']==='applicable - mob + rental charges + demob charges'){echo 'selected';} ?> value="applicable - mob + rental charges + demob charges">Applicable - Mobilization + Rental Charges + Demobilization Charges</option>
    </select>
</p>











<p class="terms_condition">
    <strong>14.Supporting Equipment :</strong> 
    <select name="equipment_assembly_select" id="equipment_assembly_select">
        <option <?php if($row['equipment_assembly']==='Not Applicable'){ echo 'selected';} ?> value="Not Applicable">Not Applicable</option>
        <option <?php if($row['equipment_assembly']==='Assembly + Dismentling'){ echo 'selected';} ?> value="Assembly + Dismentling"> Assembly + Dismentling </option>
        <option <?php if($row['equipment_assembly']==='Unloading + Assembly + Dismentling + Loading'){ echo 'selected';} ?>  value="Unloading + Assembly + Dismentling + Loading">Unloading + Assembly + Dismentling + Loading</option>
        <option <?php if($row['equipment_assembly']==='Unloading & Loading'){ echo 'selected';} ?>  value="Unloading & Loading">Unloading & Loading</option>
    </select>
</p>

<p class="terms_condition">
    <strong>15. TPI Scope :</strong>
    <select name="tpi_scope_select" id="">
        <option value="Not Required">Not Required</option>
        <option value="In Client Scope">In Client Scope</option>
        <!-- <option value="In Rental Company">In Rental Company</option> -->
    </select>
</p>

<p class="terms_condition">
    <strong>16.Safety And Security :</strong> 
    <select name="safety_security_select" id="safety_security_select">
        <option <?php if($row['safety']==='Not Required'){ echo 'selected';} ?> value="Not Required">Not Required</option>
        <option <?php if($row['safety']==='In Client Scope'){ echo 'selected';} ?> value="In Client Scope">In Client Scope</option>
        <option <?php if($row['safety']==='In Rental Company'){ echo 'selected';} ?> value="In Rental Company">In Rental Company</option>
    </select>
</p>




<p class="terms_condition">
    <strong>17.GST :</strong>Applicable. Extra payable at actual invoice value at
    <select name="gst" id="">
        <option <?php if($row['gst']==='18%'){ echo 'selected';} ?> value="18%">18%</option>
        <option <?php if($row['gst']==='28%'){ echo 'selected';} ?> value="28%">28%</option>
        <option <?php if($row['gst']==='12%'){ echo 'selected';} ?> value="12%">12%</option>
        <option <?php if($row['gst']==='5%'){ echo 'selected';} ?> value="5%">5%</option>
    </select>
<!-- <textarea name="gst" id="" cols="30" rows="1" class="terms_textarea"> Applicable. Extra payable at actual invoice value at 18%.</textarea> -->
</p>
<p class="terms_condition"><strong>18.PPE Kit :</strong>If Required To Be Provided 
<select name="PPE" id="">
<option <?php if($row['ppe_kit']==='In Client Scope FOC Basis'){ echo 'selected';} ?> value="In Client Scope FOC Basis">In Client Scope FOC Basis</option>
<option <?php if($row['ppe_kit']==='In Rental Company Scope'){ echo 'selected';} ?> value="In Rental Company Scope">In Rental Company Scope</option>
<option <?php if($row['ppe_kit']==='In Client Scope At Recoverable Basis'){ echo 'selected';} ?> value="In Client Scope At Recoverable Basis">In Client Scope At Recoverable Basis</option>
</select>
</p>


<p class="terms_condition">
    <strong>19.Over time payment :</strong>Applicable. OT charges at <select name="ot_payment" id=""><option value="100%">100%</option>
    <option <?php if($row['ot_pay']==='90%'){ echo 'selected';} ?> value="90%">90%</option>
    <option <?php if($row['ot_pay']==='80%'){ echo 'selected';} ?> value="80%">80%</option>
    <option <?php if($row['ot_pay']==='70%'){ echo 'selected';} ?> value="70%">70%</option>
    <option <?php if($row['ot_pay']==='60%'){ echo 'selected';} ?> value="60%">60%</option>
    <option <?php if($row['ot_pay']==='50%'){ echo 'selected';} ?> value="50%">50%</option></select>pro-rata basis payable if equipment has worked beyond stipulated work shift, engine hours and on Sundays,National holidays
<!-- <textarea name="ot_payment" id="" cols="30" rows="2" class="terms_textarea"> Applicable. OT charges at 100% pro-rata basis payable if equipment has worked beyond stipulated work shift, engine hours and on Sundays,National holidays</textarea> -->
</p>





<p class="terms_condition">
    <strong>20.Tools & Tackles :</strong>Related Tools And Tackles , To Be Provided <select name="tools_tackels" id="">
        <option <?php if($row['tools']==='In Client Scope'){ echo 'selected';} ?> value="In Client Scope">In Client Scope</option>
        <option <?php if($row['tools']==='In Rental Company Scope'){ echo 'selected';} ?> value="In Rental Company Scope">In Rental Company Scope</option>
    </select>
<!-- <textarea name="tools_tackels" id="" cols="30" rows="2" class="terms_textarea"> Related Tools And Tackles , Required Safety PPE Kit And Gears To Be Provided By Client On FOC basis.</textarea> -->
</p>

<p class="terms_condition">
    <strong>21.Internal Shifting :</strong><select name="internal_shifting" id="">
        <option <?php if($row['internal_shifting']==='not applicable'){ echo 'selected';} ?> value="not applicable">not applicable</option>
        <option <?php if($row['internal_shifting']==='In Client Scope'){ echo 'selected';} ?> value="In Client Scope">In Client Scope</option>
        <option <?php if($row['internal_shifting']==='In Rental Company Scope'){ echo 'selected';} ?> value="In Rental Company Scope">In Rental Company Scope</option>
    </select>
</p>
<p class="terms_condition">
    <strong>22.Notice To Mobilise :</strong> Minimum <select name="mobilisation_notice" id="">
        <option <?php if($row['mobilisation_notice']==='3 days'){ echo 'selected';} ?> value="3 days">3 days</option>
        <option <?php if($row['mobilisation_notice']==='5 days'){ echo 'selected';} ?> value="5 days">5 days</option>
        <option <?php if($row['mobilisation_notice']==='7 days'){ echo 'selected';} ?> value="7 days">7 days</option>
        <option <?php if($row['mobilisation_notice']==='15 days'){ echo 'selected';} ?> value="15 days">15 days</option>
    </select> notice reqired in mobilising equipment from our end
</p>


<p class="terms_condition">
    <strong>23.Delay payment clause :</strong>
<textarea name="delay_pay" id="" cols="30" rows="2" class="terms_textarea" readonly> In case, the payment credit terms are not honoured, we reserve the right to hault the machine operators, and our rental charges shall be in force. Additionally, an interest of 18% PA to be charges on outstanding amount.</textarea>
</p>




<p class="terms_condition">
    <strong>24.Force Majeure clause :</strong>
<textarea name="force_clause" id="" cols="30" rows="2" class="terms_textarea"> If the equipment deployment gets delayed due to transit delays, plants related gate pass, loading at client site, forces of nature and reasons beyond our control, no penalty shall be levied on us.</textarea>
</p>
<p class="terms_condition"> <strong>25.Quote Validity :</strong>Provided Quotation Rates Will Remain Valid For A Period Of 
<select name="quote_valid" id="">
    <option <?php if($row['quote_validity']==='3 days'){ echo 'selected';} ?> value="3 days">3 Days</option>
    <option <?php if($row['quote_validity']==='7 days'){ echo 'selected';} ?> value="7 days">7 Days</option>
    <option <?php if($row['quote_validity']==='10 days'){ echo 'selected';} ?> value="10 days">10 Days</option>
    <option <?php if($row['quote_validity']==='15 days'){ echo 'selected';} ?> value="15 days">15 Days</option>
    <option <?php if($row['quote_validity']==='30 days'){ echo 'selected';} ?> value="30 days">30 Days</option>
</select></p>
<textarea id="custom_terms_container" contenteditable="true" class="terms_condition" name="custom_edit"><?php if(!empty($row['custom_terms'])){ echo $row['custom_terms'];} ?></textarea>










<div class="edit_btn_container1">
<button class="quotation_submit" type="submit">SUBMIT</button>

</div>

    </div>

</form>
<br><br>
<script>
    function not_immediate(){
 const availability_dd=document.getElementById("availability_dd");
 const date_of_availability=document.getElementById("date_of_availability");
 if(availability_dd.value==="Not Immediate"){
    date_of_availability.style.display="block"
 }
 else{
    date_of_availability.style.display="none";
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





function seco_equip_2() {
    const options17 = document.getElementsByClassName('awp_options7');
    const options117 = document.getElementsByClassName('cq_options7');
    const options217 = document.getElementsByClassName('earthmover_options7');
    const options317 = document.getElementsByClassName('mhe_options7');
    const options417 = document.getElementsByClassName('gee_options7');
    const options517 = document.getElementsByClassName('trailor_options7');
    const options617 = document.getElementsByClassName('generator_options7');

    const first_select1 = document.getElementById('oem_fleet_type7');

    // Set the display style for all elements at once
    const displayStyle007 = (first_select1.value === "Aerial Work Platform") ? "block" : "none";
    Array.from(options17).forEach(option => option.style.display = displayStyle007);

    const displayStyle17 = (first_select1.value === "Concrete Equipment") ? "block" : "none";
    Array.from(options117).forEach(option => option.style.display = displayStyle17);

    const displayStyle27 = (first_select1.value === "EarthMovers and Road Equipments") ? "block" : "none";
    Array.from(options217).forEach(option => option.style.display = displayStyle27);

    const displayStyle37 = (first_select1.value === "Material Handling Equipments") ? "block" : "none";
    Array.from(options317).forEach(option => option.style.display = displayStyle37);

    const displayStyle47 = (first_select1.value === "Ground Engineering Equipments") ? "block" : "none";
    Array.from(options417).forEach(option => option.style.display = displayStyle47);

    const displayStyle57 = (first_select1.value === "Trailor and Truck") ? "block" : "none";
    Array.from(options517).forEach(option => option.style.display = displayStyle57);

    const displayStyle67 = (first_select1.value === "Generator and Lighting") ? "block" : "none";
    Array.from(options617).forEach(option => option.style.display = displayStyle67);


}
document.addEventListener('DOMContentLoaded', function() {
        var selectElement = document.getElementById('select_shift');
        if (selectElement.value !== '') {
            shift_hour(); // Call your function when the select value is not empty
        }
    });
    document.addEventListener('DOMContentLoaded', function() {
    // Check if choose_Ac2 is not empty and call choose_new_equ2()
    var chooseAc2 = document.getElementById('choose_Ac2');
    if (chooseAc2.value !== '') {
        choose_new_equ2();
    }
});
    document.addEventListener('DOMContentLoaded', function() {
    // Check if choose_Ac2 is not empty and call choose_new_equ2()
    var chooseAc3 = document.getElementById('choose_Ac3');
    if (chooseAc3.value !== '') {
        choose_new_equ_third();
    }
});
    document.addEventListener('DOMContentLoaded', function() {
    // Check if choose_Ac2 is not empty and call choose_new_equ2()
    var roadtaxselect = document.getElementById('roadtaxselect');
    if (roadtaxselect.value !== '') {
        roadtax_criteria();
    }
});
    document.addEventListener('DOMContentLoaded', function() {
    // Check if choose_Ac2 is not empty and call choose_new_equ2()
    var roadtaxcondition = document.getElementById('roadtaxcondition');
    if (roadtaxcondition.value !== '') {
        lumsum_amount();
    }
});
    document.addEventListener('DOMContentLoaded', function() {
    // Check if choose_Ac2 is not empty and call choose_new_equ2()
    var chooseAc4 = document.getElementById('choose_Ac4');
    if (chooseAc4.value !== '') {
        choose_new_equ_fourth();
    }
});
    document.addEventListener('DOMContentLoaded', function() {
    // Check if choose_Ac2 is not empty and call choose_new_equ2()
    var chooseAc4 = document.getElementById('choose_Ac4');
    if (chooseAc4.value !== '') {
        fourth_quotation();
    }
});
    document.addEventListener('DOMContentLoaded', function() {
    // Check if choose_Ac2 is not empty and call choose_new_equ2()
    var choose_Ac5 = document.getElementById('choose_Ac5');
    if (choose_Ac5.value !== '') {
        fifth_quotation();
    }
});
document.addEventListener('DOMContentLoaded', function() {
    // Check if availability_dd is not empty and call not_immediate()
    var availabilityDd = document.getElementById('availability_dd');
    if (availabilityDd.value !== '') {
        not_immediate();
    }
});
document.addEventListener('DOMContentLoaded', function() {
    // Check if oem_fleet_type1 is not empty and call seco_equip()
    var oemFleetType1 = document.getElementById('oem_fleet_type1');
    if (oemFleetType1.value !== '') {
        seco_equip();
    }
});
document.addEventListener('DOMContentLoaded', function() {
    // Check if choose_Ac7 is not empty and call choose_new_equ3()
    var chooseAc7 = document.getElementById('choose_Ac7');
    if (chooseAc7.value !== '') {
        choose_new_equ3();
    }
});
document.addEventListener('DOMContentLoaded', function() {
    // Check if availability_dd2 is not empty and call not_immediate2()
    var availabilityDd2 = document.getElementById('availability_dd2');
    if (availabilityDd2.value !== '') {
        not_immediate2();
    }
});
document.addEventListener('DOMContentLoaded', function() {
    // Check if availability_dd2 is not empty and call not_immediate2()
    var availability_dd3 = document.getElementById('availability_dd3');
    if (availability_dd3.value !== '') {
        not_immediate3();
    }
});
document.addEventListener('DOMContentLoaded', function() {
    // Check if availability_dd2 is not empty and call not_immediate2()
    var availability_dd4 = document.getElementById('availability_dd4');
    if (availability_dd4.value !== '') {
        not_immediate4();
    }
});
document.addEventListener('DOMContentLoaded', function() {
    // Check if availability_dd2 is not empty and call not_immediate2()
    var availability_dd5 = document.getElementById('availability_dd5');
    if (availability_dd5.value !== '') {
        not_immediate5();
    }
});
document.addEventListener('DOMContentLoaded', function() {
    // Check if oem_fleet_type7 is not empty and call seco_equip_2()
    var oemFleetType7 = document.getElementById('oem_fleet_type7');
    if (oemFleetType7.value !== '') {
        seco_equip_2();
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
    var choose_Ac3 = document.getElementById('choose_Ac3');
    if (choose_Ac3.value !== '') {
        third_vehicle();
    }
});
document.addEventListener('DOMContentLoaded', function() {
    // Check if oem_fleet_type7 is not empty and call seco_equip_2()
    var choose_Ac2 = document.getElementById('choose_Ac2');
    if (choose_Ac2.value !== '') {
        choose_new_equipment2_edit();
    }
});
document.addEventListener('DOMContentLoaded', function() {
    // Check if oem_fleet_type7 is not empty and call seco_equip_2()
    var assetcode = document.getElementById('assetcode');
    if (assetcode.value !== '') {
        choose_new_equipment_edit();
    }
});
function choose_new_equipment_edit(){
    const assetcode_edit=document.getElementById("assetcode");
    const autofill_field_edit=document.getElementById("autofill_field_edit");
    const edit_new_equipment_field=document.getElementById("newequipdet1");

    if(assetcode_edit.value==='New Equipment'){
        autofill_field_edit.style.display='none';
        edit_new_equipment_field.style.display='block';
        edit_new_equipment_field.style.display='flex';
        edit_new_equipment_field.style.flexDirection='column';
        edit_new_equipment_field.style.alignItems = 'center';
        edit_new_equipment_field.style.justifyContent = 'center';
        }
    else{
        autofill_field_edit.style.display='block';
        edit_new_equipment_field.style.display='none';

        autofill_field_edit.style.display='flex';
        autofill_field_edit.style.flexDirection='column';
        autofill_field_edit.style.alignItems = 'center';
        autofill_field_edit.style.justifyContent = 'center';

 
    }
}
function choose_new_equipment2_edit(){
    const second_vehicle_Asset_Code_edit=document.getElementById("choose_Ac2");
    const second_new_equipment_fields=document.getElementById("newequipdet7");
    const sec_equipment_prefill_fields=document.getElementById("sec_equipment_prefill_fields");

    if(second_vehicle_Asset_Code_edit.value==='New Equipment'){
        sec_equipment_prefill_fields.style.display='none';
        second_new_equipment_fields.style.display='flex';
        second_new_equipment_fields.style.width='100%';
        second_new_equipment_fields.style.flexDirection='column';
        second_new_equipment_fields.style.alignItems='center';
        second_new_equipment_fields.style.justifyContent='center';

    }
    else{
        second_new_equipment_fields.style.display='none';
        sec_equipment_prefill_fields.style.display='block';
        sec_equipment_prefill_fields.style.display='flex';
        sec_equipment_prefill_fields.style.flexDirection='column';
        sec_equipment_prefill_fields.style.alignItems='center';
        sec_equipment_prefill_fields.style.justifyContent='center';


    }
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


</script>

</body>
</html>
