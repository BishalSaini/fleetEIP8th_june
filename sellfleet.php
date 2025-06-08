<style>
  <?php include "style.css" 
  ?>
</style>
<script>
    <?php include "main.js" ?>
    </script>
    <?php
include 'partials/_dbconnect.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">      <link rel="icon" href="favicon.jpg" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="navbar1">
    <div class="logo_fleet">
    <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='<?php echo $dashboard_url  ?>'">
</div>

        <div class="iconcontainer">
        <ul><li><a href="sign_in.php">Home</a></li>
            <li><a href="about_us.html">About Us</a></li>
            <li><a href="contact_us.php">Contact Us</a></li>
            <li><a href="logout.php">Log Out</a></li></ul>
        </div>
</div> 

<?php if (isset($_GET['error'])): ?>
		<p><?php echo $_GET['error']; ?></p>
	<?php endif ?>
<form action="/fleeteip/upload.php" method="post" class="sellcrane" enctype="multipart/form-data">
    <div class="sellcrane-container">
        <div class="sellcrane_heading"><h2>Sell your crane</h2></div>
        <div class="trial1">
<select name="selltype" class="input02" id="">
  <option value="" disabled selected> Type</option>
  <option value="Backhoe loader">Backhoe loader</option>
  <option value="Barges">Barges</option>
  <option value="Bulldozers">Bulldozers</option>
  <option value="Compactor">Compactor</option>
  <option value="Concrete pump">Concrete pump</option>
  <option value="Crawler">Crawler</option>
  <option value="Crawler telescopic">Crawler telescopic</option>
  <option value="Excavator">Excavator</option>
  <option value="Forklift">Forklift</option>
  <option value="Front loader">Front loader</option>
  <option value="Graders">Graders</option>
  <option value="Heavy Haulage">Heavy Haulage</option>
  <option value="Lift">Lift</option>
  <option value="Lorry Loader">Lorry Loader</option>
  <option value="Mining equipment">Mining equipment</option>
  <option value="Paver">Paver</option>
  <option value="Rig">Rig</option>
  <option value="Skid loader">Skid loader</option>
  <option value="Telehandlers">Telehandlers</option>
  <option value="Telescopic">Telescopic</option>
  <option value="Tipper">Tipper</option>
  <option value="Tower cranes">Tower cranes</option>
  <option value="Trailer-flatbed">Trailer-flatbed</option>
  <option value="Trailer-semi lowbed">Trailer-semi lowbed</option>
  <option value="Trailer-lowbed">Trailer-lowbed</option>
  <option value="Trucks">Trucks</option>
</select>
</div>
        <div class="trial1">
        <input type="text" name="sellmake" class="input02" placeholder="">
        <label class="placeholder2">Make</label>
        </div>
        <div class="trial1">
        <input type="text" name="sellmodel" class="input02" placeholder="">
        <label class="placeholder2">Model</label>
        </div>
        <div class="trial1">
        <input type="text" name="sellcapacity" class="input02" placeholder="">
        <label class="placeholder2">Capacity</label>
        </div>
        <div class="trial1">
        <input type="text" name="sell_boomlength" class="input02" placeholder="">
        <label class="placeholder2">Boom Length</label>
        </div>
        <div class="trial1">
        <input type="text" name="sell_jiblength" class="input02" placeholder="">
        <label class="placeholder2">Jib Length</label>
        </div>
        <div class="trial1">
        <input type="text" name="sellyom" class="input02" placeholder="">
        <label class="placeholder2">YOM</label>
        </div>
        <div class="trial1">
        <input type="text" name="sell_location"class="input02" placeholder="">
        <label class="placeholder2">Location</label>
        </div>
        <div class="trial1">
        <input type="text" name="sell_description"class="input02" placeholder="">
        <label class="placeholder2">Crane Description</label>
        </div>
        <div class="trial1">
        <input type="text" name="sellchassis" class="input02" placeholder="">
        <label class="placeholder2">Chassis Number</label>
        </div>

        <div class=" trial1 ">
        <input class="input02" type="file" id="image" name="image">
        <label class="placeholder2">Front Picture:</label>
        </div>

        <!-- <div class="trial1">
        <input type="file" class="input02" id="front-photo" name="backPhoto" accept="image/*">
        <label class="placeholder2">Back Picture:</label>
        </div>
        <div class=" trial1 ">
        <input type="file" class="input02" id="front-photo" name="sidePhoto" accept="image/*">
        <label class="placeholder2"> Side Picture:</label>
        </div> -->
        <input type="submit" name="submit" value="Upload">

        <!-- <button type="submit" name="submit" class="epc-button">Post Your Fleet</button> -->
        <br>
        <br>
        </div>
    
</form>
<br><br>
</body>
</html>