<?php

if (isset($_POST['submit'])){
	include_once 'partials/_dbconnect.php'; 
    $editid01 = $_POST['id'];
    // $type01 = $_POST['sell_type'];
	$fleet_Category=$_POST['fleet_category'];
	$fleet_sub_type=$_POST['type'];
	$make01 = $_POST['make'];
	$model01 = $_POST['model'];
	$capacity01 = $_POST['capacity'];
	$yom01 = $_POST['yom'];
	$location01 = $_POST['location'];
	$boomlength01 = $_POST['boom_length'];
	$jiblength01 = $_POST['jib_length'];
	$luffinglength01 = $_POST['luffing_length'];
	$cranedesc01 = $_POST['crane_desc'];
    $price01 = $_POST['price'];
	$contact_no01 = $_POST['contact_no'];
	$registration=$_POST['registration'];
	$chassis_make=$_POST['chassis_make'];
	$model_no=$_POST['model_no'];
	$height_meter=$_POST['height_meter'];
	$total_height=$_POST['total_height'];
	$free_standing_height=$_POST['free_standing_height'];
	$tipload=$_POST['tipload'];
	$kealy=$_POST['kealy'];
	$pipeline=$_POST['pipeline'];
	$silos_no=$_POST['silos_no'] ?? null;
	$cement_silos=$_POST['cement_silos'];
	$flyash_silos=$_POST['flyash_silos'];
	$cement_silos_qty=$_POST['cement_silos_qty'];
	$flyash_silos_qty=$_POST['flyash_silos_qty'];
	$chiller_available=$_POST['chiller_available'];
	$kmr01 = $_POST['kmr'];
	$hmr01 = $_POST['hmr'];
	$unit=$_POST['unit'];

  
	$sql="UPDATE `images` SET `category`='$fleet_Category',`sub_type`='$fleet_sub_type',
	`kmr`='$kmr01',`hmr`='$hmr01',`price`='$price01',`contact_no`='$contact_no01',
	`model`='$model01',`make`='$make01',`capacity`='$capacity01',`unit`='$unit',
	`yom`='$yom01',`location`='$location01',`boomlength`='$boomlength01',`jiblength`='$jiblength01',
	`luffinglength`='$luffinglength01',`description`='$cranedesc01',`registration`='$registration',`chassis_make`='$chassis_make',
	`model_no`='$model_no',`height_meter`='$height_meter',`total_height`='$total_height',`free_standing_height`='$free_standing_height',
	`tip_load`='$tipload',`kaely`='$kealy',
	`pipeline`='$pipeline',`silos_no`='$silos_no',`cmnt_silos`='$cement_silos',`flyash_silos`='$flyash_silos',
	`cmnt_silos_qty`='$cement_silos_qty',`flyash_silos_qty`='$flyash_silos_qty',`chiller`='$chiller_available' WHERE id='$editid01'";
	$result=mysqli_query($conn,$sql);
	if ($result) {
		session_start();
		$_SESSION['success'] = 'success';
		header("Location: edit_listing.php?id=" . $editid01);
		exit();
	}
			else{
		$_SESSION['error']='success';

		header("Location: edit_listing.php?id=" . $editid01);
	}


    // $sql="UPDATE `images` SET category=$fleet_Category,sub_Type=$fleet_sub_type ,description='$cranedesc01', price='$price01' , contact_no='$contact_no01' , model='$model01' , make='$make01' , capacity='$capacity01' , yom='$yom01' , location='$location01' , boomlength='$boomlength01' , jiblength='$jiblength01' , luffinglength='$luffinglength01' , type='$type01' where id='$editid01'";
    // if (mysqli_query($conn, $sql)) {
    // echo "done";
    // }
    // else{
    //     echo"not done";
    // }

}
?>
