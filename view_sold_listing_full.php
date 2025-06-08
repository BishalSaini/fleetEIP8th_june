<?php
include_once 'partials/_dbconnect.php';

$soldid=$_GET['id'];

$sql_check="SELECT * FROM `sold` WHERE `id`='$soldid'";
$result=mysqli_query($conn , $sql_check);
$row=mysqli_fetch_assoc($result);
?>

<style>
    <?php include "style.css"; ?>
  </style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">      <link rel="icon" href="favicon.jpg" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <div class="navbar1">
    <div class="logo_fleet">
    <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='<?php echo $dashboard_url  ?>'">
</div>

    <div class="iconcontainer">
      <ul>
      <li><a href="rental_dashboard.php">Dashboard</a></li>
            <li><a href="news/">News</a></li>
        <li><a href="logout.php">Log Out</a></li>
      </ul>
    </div>
</div>
<?php $hidden='style="display:none;"'; ?>
    <form action="" class="sellcrane">
    <div class="sellcrane-container">
	<div class="sellcrane_heading"><h2>Sold Equipment</h2></div>
<div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" class="input02" value="<?php echo $row['category'] ?>" readonly>
                <label class="placeholder2">Category</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" class="input02" value="<?php echo $row['sub_type'] ?>" readonly>
                <label class="placeholder2">Sub Type</label>
            </div>
			</div>
			<div class="outer02">
            <div class="trial1">
        <input type="text" class="input02" placeholder="" value="<?php echo $row['make'] ?>" name="make">
		<label class="placeholder2">Make</label>
		</div>
		<div class="trial1">
		<input type="text" class="input02" placeholder="" value="<?php echo $row['model'] ?>" name="model">
		<label class="placeholder2">Model</label>
		</div>
		<div class="trial1">
		<input type="text" class="input02" placeholder="" value="<?php echo $row['capacity'] .' ' . $row['unit']?>" name="capacity">
		<label class="placeholder2">Capacity</label>
		</div>
		</div>
		<div class="outer02" <?php if(empty($row['boomlength']) && empty($row['jiblength']) && empty($row['luffinglength'])){ echo 'style="display:none;"';} ?>>
		<div class="trial1 soldfleet_info" <?php if(empty($row['boomlength'])){ echo 'style="display:none;"'; } ?>>
		<input type="text" placeholder="" value="<?php echo $row['boomlength'] ?>" class="input02">
				<label for="" class="placeholder2">Boom Length</label>
			</div>
			<div class="trial1 soldfleet_info" <?php if(empty($row['jibength'])){ echo 'style="display:none;"'; } ?>>
			<input type="text" placeholder="" value="<?php echo $row['jiblength'] ?>" class="input02">
				<label for="" class="placeholder2">Jib Length</label>
			</div>
			<div class="trial1 soldfleet_info" <?php if(empty($row['luffinglength'])){ echo 'style="display:none;"'; } ?>>
			<input type="text" placeholder="" value="<?php echo $row['luffinglength'] ?>" class="input02">
				<label for="" class="placeholder2">Luffing Length</label>
			</div>

		</div>
		<div class="trial1" <?php if(empty($row['registration'])){ echo $hidden;} ?>>
        <input type="text"  name="registration" value="<?php echo $row['registration'] ?>" placeholder="" class="input02">
        <label class="placeholder2">Registration</label>
        </div>


        <div class="outer02" id="" <?php if(empty($row['chassis_make'])){ echo $hidden;} ?>>
        <div class="trial1" >
		<input type="text" placeholder="" value="<?php echo $row['chassis_make'] ?>" class="input02">
		<label for="" class="placeholder2">Chassis Make</label>
	</select>
        </div>
        <div class="trial1" id="" <?php if(empty($row['model_no'])){ echo $hidden;} ?>>
            <input type="text" name="model_no" value="<?php echo $row['model_no'] ?>" placeholder="" class="input02">
            <label for="" class="placeholder2">Model No</label>
        </div>
        </div>
        <div class="trial1" id="" <?php if(empty($row['height_meter'])){ echo $hidden;} ?>>
            <input type="number" name="height_meter" value="<?php echo $row['height_meter'] ?>" placeholder="" class="input02">
            <label for="" class="placeholder2">Height/Meter</label>
        </div>
        <div class="outer02" id="" <?php if(empty($row['total_height'])){ echo $hidden;} ?>>
            <div class="trial1" <?php if(empty($row['total_height'])){ echo $hidden;} ?>>
                <input type="number" name="total_height" id="total_height_input" value="<?php echo $row['total_height'] ?>" placeholder="" class="input02">
                <label for="" class="placeholder2 tip_load_in_tons">Total Height In Mtr</label>
            </div>
            <div class="trial1" <?php if(empty($row['free_standing_height'])){ echo $hidden;} ?>>
                <input type="number" name="free_standing_height" id="" value="<?php echo $row['free_standing_height'] ?>" placeholder="" class="input02">
                <label for="" id="" class="placeholder2 tip_load_in_tons">Free Standing Height</label>
            </div>
            <div class="trial1" <?php if(empty($row['tip_load'])){ echo $hidden;} ?>>
                <input type="number" name="tipload" id="" placeholder="" value="<?php echo $row['tip_load'] ?>" class="input02">
                <label for=""  class="placeholder2 tip_load_in_tons">Tip Load In Tons</label>
            </div>


        </div>
		<div class="trial1" id="" <?php if(empty($row['kaely_length'])){ echo $hidden;} ?>>
            <input type="text" name='kealy' placeholder="" value="<?php echo $row['kaely_length'] ?>" class="input02">
            <label for="" class="placeholder2">Kealy Length</label>
        </div>
        <div class="trial1" id="" <?php if(empty($row['pipeline'])){ echo $hidden;} ?>>
            <input type="text" name='pipeline' placeholder="" value="<?php echo $row['pipeline'] ?>" class="input02">
            <label for="" class="placeholder2">Pipeline Length</label>
        </div>
        <div class="outer02" id="" <?php if(empty($row['silos_no'])){ echo $hidden;} ?>>
            <div class="trial1" <?php if(empty($row['silos_no'])){ echo $hidden;} ?>>
				<input type="text" placeholder="" value="<?php echo $row['silos_no'] ?>" class="input02">
				<label for="" class="placeholder2">Silos No</label>
            </div>
            <div class="trial1" <?php if(empty($row['cmnt_silos_no'])){ echo $hidden;} ?>>
                <input type="text" name="cement_silos" value="<?php echo $row['cmnt_silos_no'] ?>" placeholder="" class="input02">
                <label for="" class="placeholder2">Cement Silos No</label>
            </div>
            <div class="trial1" <?php if(empty($row['flyash_silos_no'])){ echo $hidden;} ?>>
                <input type="text" name="flyash_silos" placeholder="" value="<?php echo $row['flyash_silos_no'] ?>" class="input02">
                <label for="" class="placeholder2">Flyash Silos No</label>
            </div>

        </div>
        <div class="outer02" id="" <?php if(empty($row['cmnt_silos_qty'])){ echo $hidden;} ?>>
        <div class="trial1" <?php if(empty($row['cmnt_silos_qty'])){ echo $hidden;} ?>>
                <input type="text" name="cement_silos_qty" value="<?php echo $row['cmnt_silos_qty'] ?>" placeholder="" class="input02">
                <label for="" class="placeholder2">Cement Silos Qty</label>
            </div>
            <div class="trial1" <?php if(empty($row['flyash_silos_qty'])){ echo $hidden;} ?>>
                <input type="text" name="flyash_silos_qty" value="<?php echo $row['flyash_silos_qty'] ?>" placeholder="" class="input02">
                <label for="" class="placeholder2">Flyash Silos Qty</label>
            </div>
                <div class="trial1" <?php if(empty($row['chiller'])){ echo $hidden;} ?>>
				<input type="text" placeholder="" value="<?php echo $row['chiller'] ?>" class="input02">
				<label for="" class="placeholder2">Chiller</label>
				</div>

        </div>


		<div class="outer02">
		<div class="trial1">
		<input type="text" class="input02" placeholder=""  value="<?php echo $row['kmr'] ?>" name="kmr">
		<label class="placeholder2">KMR</label>
		</div><div class="trial1">
		<input type="text" class="input02" placeholder="" value="<?php echo $row['hmr'] ?>" name="hmr">
		<label class="placeholder2">HMR</label>
		</div>
		</div>
		<div class="outer02">
		<div class="trial1">
		<input type="text" class="input02" placeholder="" value="<?php echo $row['yom'] ?>" name=yom>
		<label class="placeholder2">YOM</label>
		</div>
		<div class="trial1">
		<input type="text" class="input02" placeholder="" value="<?php echo $row['location'] ?>" name="location">
		<label class="placeholder2">Location</label>
		</div>
		</div>
		<!-- <div class="trial1">
		<input type="text" class="input02" placeholder="" value="<?php echo $row['boomlength'] ?>" name="boom_length">
		<label class="placeholder2">Boom Lenght</label>
		</div>
		<div class="trial1">
		<input type="text" class="input02" placeholder="" value="<?php echo $row['jiblength'] ?>" name=jib_length>
		<label class="placeholder2">Jib Lenght</label>
		</div>
		<div class="trial1">
		<input type="text" class="input02" placeholder="" value="<?php echo $row['luffinglength'] ?>" name="luffing_length">
		<label class="placeholder2">Luffing Lenght</label>
		</div> -->
		<div class="outer02">
		<div class="trial1">
		<input type="text" class="input02" placeholder="" value="<?php echo $row['price'] ?>" name="price">
		<label class="placeholder2">Price </label>
		</div><div class="trial1">
		<input type="text" class="input02" placeholder="" value="<?php echo $row['contact_no'] ?>" name="contact_no">
		<label class="placeholder2">Contact Number</label>
		</div>
</div>
		<div class="trial1">
		<textarea type="text" class="input02" placeholder="" value="" name="crane_desc"><?php echo $row['description'] ?></textarea>
		<label class="placeholder2">Crane Description</label>
		</div>
		<div class="trial1">
			<input type="text" placeholder="" value="<?php echo $row['sold_platform'] ?>" class="input02">
			<label for="" class="placeholder2">Sold Platform</label>
		</div>
        <?php
        echo '<div class="trial123">';
        echo '<h4> Uploaded Images</h4>';
		echo "<a href='img/" . $row['front_pic'] . "' target='_blank'><img class='first_img input02' src='img/" . $row['front_pic'] . "'></a>";
		echo "<a href='img/" . $row['left_side_pic'] . "' target='_blank'><img class='first_img input02' src='img/" . $row['left_side_pic'] . "'></a>";
		echo "<a href='img/" . $row['right_side_pic'] . "' target='_blank'><img class='first_img input02' src='img/" . $row['right_side_pic'] . "'></a>";
				echo'</div>';                        
        ?>
        <br><br>
        </div>
    </form>
    <br><br>
</body>
</html>