<?php
// Include your database connection file (e.g., dbConnection.php)
$assetcode=$_GET['assetcode'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once('partials/_dbconnect.php');
    // $editnewId = $_POST['id'];
    $make1 = $_POST["make"];
    $model1 = $_POST["model"];
    $type1 = $_POST["type"];
    $yom1 = $_POST["yom"];
    $capacity1 = $_POST["capacity"];
    $registration1 = $_POST["registration"];
    $chassis1 = $_POST["chassis"];
    $engine1 = $_POST["engine"];
    $boomLength1 = $_POST["boomLength"];
    $jibLength1 = $_POST["jibLength"];
    $luffingLength1 = $_POST["luffingLength"];
    $dieselTankCap1 = $_POST["dieselTankCap"];
    $hydraulicOilTank1 = $_POST["hydraulicOilTank"];
    $engineOilCapacity1 = $_POST["engineOilCapacity"];
    $hydraulicOilGrade1 = $_POST["hydraulicOilGrade"];
    $engineOilGrade1 = $_POST["engineOilGrade"];
    $statuss1 = $_POST["status"];
    $assetcode1 = $_POST["assetcode"];
    // $currentrental = $_POST["crnt-rental"];
    // $expectedrental = $_POST["exp-rental"];
    $workorder = $_POST["workorder"];
    $workorder_valid = $_POST["workorder_validity"];
    $rc_valid = $_POST["rc_validity"];
    $fc_valid = $_POST["fc_validity"];
    $np_valid = $_POST["np_validity"];
    $insaurance = $_POST["insaurance"];
    $operator_fname = $_POST["operator-fname"];
    $unit=$_POST['unit'];
    $client_name=$_POST['client_name'];
    $project_name=$_POST['project_name'];
    $project_location=$_POST['project_location'];
    $rental_charges_wo=$_POST['rental_charges_wo'];
    $shift_wo=$_POST['shift_wo'];
    $ot_charges=$_POST['ot_charges'];
    $hour_shift = !empty($_POST['hour_shift']) ? $_POST['hour_shift'] : $_POST['engine_hour'];
    $working_days_month=$_POST['working_days_month'];
    $sunday_condition=$_POST['sunday_condition'];
    $fuel_norms=$_POST['fuel_condition'];
    $chassis_number=$_POST['chassis_number'];


    $tipload=$_POST['tipload'];
    $free_standing_height=$_POST['free_standing_height'];
    $total_height=$_POST['total_height'];
    $height_meter=$_POST['height_meter'];
    $chiller_available=$_POST['chiller_available'];
    $flyash_silos_qty=$_POST['flyash_silos_qty'];
    $cement_silos_qty=$_POST['cement_silos_qty'];
    $flyash_silos=$_POST['flyash_silos'];
    $cement_silos=$_POST['cement_silos'];
    $silos_no=$_POST['silos_no']?? null;
    $pipeline=$_POST['pipeline'];
    $kealy=$_POST['kealy'];
    $operator2=$_POST['operator-fname2'];
    $helper1=$_POST['helper1'];
    $helper2=$_POST['helper2'];
    $model=$_POST['model'];
    $workorder_start=$_POST['workorder_start'];
    $bedlength=$_POST['bedlength'];
    $fuelEficiency=$_POST['fuelEficiency'];
    $adblue=$_POST['adblue'];
    $wo_refno=$_POST['wo_refno'];
    $wo_date=$_POST['wo_date'];
    $wo_issued_by=$_POST['wo_issued_by'];
    $contact_personwo=$_POST['contact_personwo'];
    $contactmob_num=$_POST['contactmob_num'];
    $mainwire_dia=$_POST['mainwire_dia'];
    $mainwire_length=$_POST['mainwire_length'];
    $secondwire_dia=$_POST['secondwire_dia'];
    $secondwire_length=$_POST['secondwire_length'];
    $adbluetank=$_POST['adbluetank'];
    $fuelUnit=$_POST['fuelUnit'];
    $equipmentLocation=$_POST['equipmentLocation'];


    $loadchart = $_FILES['loadchart']['name'];
    $temp_file_path = $_FILES['loadchart']['tmp_name'];
    $folder3 = 'img/' . $loadchart;
    move_uploaded_file($temp_file_path, $folder3);
    
    





    $sql = "UPDATE `fleet1` SET
    `loadchart` = '$loadchart',
    `adbluetank` = '$adbluetank',
    `equipmentLocation` = '$equipmentLocation',
    `adblue` = '$adblue',
    `workorder_ref` = '$wo_refno',
    `workorder_issueddate` = '$wo_date',
    `woissuedby` = '$wo_issued_by',
    `wocontactperson` = '$contact_personwo',
    `wocontactnumber` = '$contactmob_num',
    `main_wire_dia` = '$mainwire_dia',
    `main_wire_length` = '$mainwire_length',
    `second_wire_dia` = '$secondwire_dia',
    `second_wire_length` = '$secondwire_length',
    `workorder_from` = '$workorder_start',
    `operator_fname2` = '$operator2',
    `helper1` = '$helper1',
    `helper2` = '$helper2',
    `kealy_length` = '$kealy',
    `pipelength_length` = '$pipeline',
    `silos_no` = '$silos_no',
    `cement_silos` = '$cement_silos',
    `flyash_silos` = '$flyash_silos',
    `cement_silos_qty` = '$cement_silos_qty',
    `flyash_silos_qty` = '$flyash_silos_qty',
    `chiller_available` = '$chiller_available',
    `model_no` = '$model',
    `height` = '$height_meter',
    `total_height` = '$total_height',
    `free_standing_height` = '$free_standing_height',
    `tip_load` = '$tipload',
    `chassis_number` = '$chassis_number',
    `fuel_norms` = '$fuel_norms',
    `working_days_in_month` = '$working_days_month',
    `condition_sundays` = '$sunday_condition',
    `hour_shift` = '$hour_shift',
    `rental_charges_wo` = '$rental_charges_wo',
    `shift_wo` = '$shift_wo',
    `ot_charges` = '$ot_charges',
    `unit` = '$unit',
    `project_name` = '$project_name',
    `project_location` = '$project_location',
    `client_name` = '$client_name',
    `make` = '$make1',
    `model` = '$model1',
    `yom` = '$yom1',
    `type` = '$type1',
    `capacity` = '$capacity1',
    `registration` = '$registration1',
    `chassis` = '$chassis1',
    `engine` = '$engine1',
    `workorder` = '$workorder',
    `rc_valid` = '$rc_valid',
    `fc_valid` = '$fc_valid',
    `insaurance_valid` = '$insaurance',
    `np_valid` = '$np_valid',
    `operator_fname` = '$operator_fname',
    `workorder_valid` = '$workorder_valid',
    `boom_length` = '$boomLength1',
    `jib_length` = '$jibLength1',
    `luffing_length` = '$luffingLength1',
    `diesel_tank_capacity` = '$dieselTankCap1',
    `hydraulic_oil_tank` = '$hydraulicOilTank1',
    `assetcode` = '$assetcode1',
    `engine_oil_capacity` = '$engineOilCapacity1',
    `engine_oil_grade` = '$engineOilGrade1',
    `hydraulic_oil_grade` = '$hydraulicOilGrade1',
    `bedlength`= '$bedlength',
    `fuelUnit`= '$fuelUnit',

    `fuelEficiency`= '$fuelEficiency',
    `status` = '$statuss1'
WHERE `snum` = '$assetcode'";
    if (mysqli_query($conn, $sql)) {
        // echo "Record updated successfully";
        session_start();
        $_SESSION['message']='message';
        header('Location: viewfleet2.php');
        exit;
    
    } else {
        session_start();
        $_SESSION['error_message'];
        // header('Location: viewfleet2.php');
        exit;
    
    }

    // Redirect back to the original page (e.g., a success page or the list of records)
}


