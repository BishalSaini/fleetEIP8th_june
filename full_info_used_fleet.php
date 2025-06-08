<style>
  <?php include "style.css" ?>
</style>
<script>
    <?php include "main.js" ?>
    </script>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">      <link rel="icon" href="favicon.jpg" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8/slick/slick-theme.css"/>
    <style>
        /* Additional CSS styles for the slider */
        .slider {
            width: 40%;
            /* margin: 20px auto; */
            height: 400px;
            text-align: center;
            background-size: contain;
            border-radius:8px;
            /* border: 2px solid black; */
            box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;
        }

        .slides img {
            max-width: 100%;
            min-width: 100%;
            max-height: 100%;
            min-height: 100%;
            object-fit: contain;
        }
        .outer_container01{
            display: flex;
            justify-content: flex-start;
            align-items: center;
            margin-top: 50px;
            /* border: 2px solid blue; */
            width: 90%;
            padding: 20px;
            margin-left: 4%;
            align-self: center;
        }
    </style>
</head>
<body>
<?php $hidden='style="display:none;"'; ?>

    <div class="navbar1">
    <div class="logo_fleet">
    <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='<?php echo $dashboard_url  ?>'">
</div>

        <div class="iconcontainer">
        <ul>
		<li><a href="rental_dashboard.php">Dashboard</a></li>
            <li><a href="news/">News</a></li>

            <li><a href="logout.php">Log Out</a></li></ul>
        </div>
</div>
    
            <?php
            $used_fleetId = $_GET['id'];
            include_once 'partials/_dbconnect.php'; 

            $sql = "SELECT * FROM images WHERE id='$used_fleetId'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) { 
                    echo '<div class="outer_container01">';
                    echo'<div class="slider">';
                    echo'<div class="slides">';
                    echo "<div><img src='img/" . $row['front_pic'] . "'></div>";                           
                    echo "<div><img src='img/" . $row['right_side_pic'] . "'></div>";                           
                    echo "<div><img src='img/" . $row['left_side_pic'] . "'></div>";  
                    echo "<div><img src='img/" . $row['pic4'] . "'></div>";  
                    echo "<div><img src='img/" . $row['pic5'] . "'></div>";  
                    echo '</div>';
                    echo '</div>'; 
                    echo '<div class="sell_info001">';
                    ?>
                    <div class="sellheading"><p>Information</p></div>
                   <form action="" class="qwerty">
                    
                   <div class="outer02">
                   <div class="trial1">
                    <input type="text" class="input02" placeholder="" value="<?php echo $row['category']; ?>" readonly>
                    <label class="placeholder2">Category</label>
                    </div>  
                    <div class="trial1">
                    <input type="text" class="input02" placeholder="" value="<?php echo $row['sub_type']; ?>" readonly>
                    <label class="placeholder2">Sub Type</label>
                    </div> 
                    </div>
                    <div class="outer02">
                    <div class="trial1">
                    <input type="text" class="input02" placeholder="" value="<?php echo $row['make']; ?>" readonly>
                    <label class="placeholder2">Make</label>
                    </div>  
                    <div class="trial1">
                    <input type="text" class="input02" placeholder="" value="<?php echo $row['model']; ?>" readonly>
                    <label class="placeholder2">Model</label>
                    </div>  

                    </div> 
                    <div class="outer02">
                    <div class="trial1" id="usedfleet_capacity">
                    <input type="text" class="input02" placeholder="" value="<?php echo $row['capacity'] .' ' .$row['unit']; ?>" readonly>
                    <label class="placeholder2">capacity</label>
                    </div>   
                    <div class="trial1">
                    <input type="text" class="input02" placeholder="" value="<?php echo $row['yom']; ?>" readonly>
                    <label class="placeholder2">YOM</label>
                    </div> 
                    </div>
                    <div class="trial1">
                    <input type="text" class="input02" placeholder="" value="<?php echo $row['location']; ?>" readonly>
                    <label class="placeholder2">Location</label>
                    </div> 

                    <div class="outer02" <?php if(empty($row['boomlength']) && empty($row['jiblength']) && empty($row['luffinglength'])){ echo 'style="display:none;"';} ?>>
		<div class="trial1 soldfleet_info" <?php if(empty($row['boomlength'])){ echo 'style="display:none;"'; } ?>>
		<input type="text" placeholder="" value="<?php echo $row['boomlength'] ?>" class="input02">
				<label for="" class="placeholder2">Boom </label>
			</div>
			<div class="trial1 soldfleet_info" <?php if(empty($row['jibength'])){ echo 'style="display:none;"'; } ?>>
			<input type="text" placeholder="" value="<?php echo $row['jiblength'] ?>" class="input02">
				<label for="" class="placeholder2">Jib </label>
			</div>
			<div class="trial1 soldfleet_info" <?php if(empty($row['luffinglength'])){ echo 'style="display:none;"'; } ?>>
			<input type="text" placeholder="" value="<?php echo $row['luffinglength'] ?>" class="input02">
				<label for="" class="placeholder2">Luffing </label>
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
                    <input type="textarea" class="input02" placeholder="" value="<?php echo $row['contact_no']; ?>" readonly>
                    <label class="placeholder2">Contact Number</label>
                    </div> 
                    <div class="trial1">
                    <input type="textarea" class="input02" placeholder="" value="<?php echo $row['price']; ?>" readonly>
                    <label class="placeholder2">Price</label>
                    </div> 
                    </div>
                    <div class="trial1">
                    <textarea type="textarea"  class="input02" placeholder="" value="" readonly><?php echo $row['description']; ?></textarea>
                    <label class="placeholder2">description</label>
                    </div> 

                    <br>
                   </form>
                    <?php
                    echo '</div>'; 
                    echo '</div>';                        
                }
            }
            ?>
       

    <!-- JavaScript for the slider -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8/slick/slick.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.slides').slick({
                dots: true,
                infinite: true,
                speed: 500,
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 6000
            });
        });
    </script>
</body>
</html>