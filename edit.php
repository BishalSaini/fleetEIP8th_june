<style>
<?php include "style.css" ?>
</style>
<script>
    <?php include "main.js" ?>
    </script>

<!DOCTYPE html>
<html>
<head>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <title>Edit Make and Model</title>
    <!-- Add your CSS styles here -->
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
    
    <?php
    // Include the database connection file
    require_once('partials/_dbconnect.php');

    // Get the record ID from the URL parameter
    $editId = $_GET['id'];
    // echo $editId;

    // Retrieve data based on the ID
    $query = "SELECT * FROM `fleet1` WHERE chassis ='$editId'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        echo "<p>Record not found.</p>";
    } else {
        ?>
        
        







        <form action="update.php? chassis=<?php echo $editId; ?>" method="POST" autocomplete="off" class="addcraneform">
    <div class="formcontainer">
        <h3 class="add-fleet">Edit Fleet</h3>
        <input type="text" class="craneforminput" placeholder="Make" value="<?php echo $row['make']; ?>" name="make" required>
        <input type="text" class="craneforminput" placeholder="Model" value="<?php echo $row['model']; ?>" name="model">
        <select class="craneforminput selectoption" name="type" value="<?php echo '$type'; ?>" id="mySelect" onchange="showTextBox()">
            <option value="" disable selected>Choose a value</option>
            <option value="Telescopic" <?php if ($row['type'] === 'Telescopic') echo 'selected'; ?> class="craneforminput">Telescopic</option>
            <option value="Crawler" <?php if ($row['type'] === 'Crawler') echo 'selected'; ?> class="craneforminput">Crawler</option>
            <option value="Forklift" <?php if ($row['type'] === 'Forklift') echo 'selected'; ?>  class="craneforminput">Forklift</option>
            <option value="Excavator" <?php if ($row['type'] === 'Excavator') echo 'selected'; ?>  class="craneforminput">Excavator</option>
            <option value="Lift" <?php if ($row['type'] === 'Lift') echo 'selected'; ?>  class="craneforminput">Lift</option>
            <option value="Rig" <?php if ($row['type'] === 'Rig') echo 'selected'; ?> class="craneforminput">Rig</option>
            <option value="Telehandlers" <?php if ($row['type'] === 'Telehandlers') echo 'selected'; ?>  class="craneforminput">Telehandlers</option>
            <option value="Compactor" <?php if ($row['type'] === 'Compactor') echo 'selected'; ?>  class="craneforminput">Compactor</option>
            <option value="Trailer-flatbed" <?php if ($row['type'] === 'Trailer-flatbed') echo 'selected'; ?> class="craneforminput">Trailer-flatbed</option>
            <option value="Trailer-semi lowbed"<?php if ($row['type'] === 'Trailer-semi lowbed') echo 'selected'; ?>    class="craneforminput">Trailer-semi lowbed</option>
            <option value="Trailer-lowbed"<?php if ($row['type'] === 'Trailer-lowbed') echo 'selected'; ?>    class="craneforminput">Trailer-lowbed</option>
            <option value="Skid loader"<?php if ($row['type'] === 'Skid loader') echo 'selected'; ?>    class="craneforminput">Skid loader</option>
            <option value="Backhoe loader"<?php if ($row['type'] === 'Backhoe loader') echo 'selected'; ?>    class="craneforminput">Backhoe loader</option>
            <option value="Front loader"<?php if ($row['type'] === 'Front loader') echo 'selected'; ?>    class="craneforminput">Front loader</option>
            <option value="Paver"<?php if ($row['type'] === 'Paver') echo 'selected'; ?>    class="craneforminput">Paver</option>
            <option value="TBM"<?php if ($row['type'] === 'TBM') echo 'selected'; ?>    class="craneforminput">TBM</option>
            <option value="Graders" <?php if ($row['type'] === 'Graders') echo 'selected'; ?>   class="craneforminput">Graders</option>
            <option value="Tower cranes" <?php if ($row['type'] === 'Tower cranes') echo 'selected'; ?>    class="craneforminput">Tower cranes</option>
            <option value="Bulldozers" <?php if ($row['type'] === 'Bulldozers') echo 'selected'; ?>   class="craneforminput">Bulldozers</option>
            <option value="Lorry Loader" <?php if ($row['type'] === 'Lorry Loader') echo 'selected'; ?>   class="craneforminput">Lorry Loader</option>
            <option value="Trucks" <?php if ($row['type'] === 'Trucks') echo 'selected'; ?>   class="craneforminput">Trucks</option>
            <option value="Barges" <?php if ($row['type'] === 'Barges') echo 'selected'; ?>   class="craneforminput">Barges</option>
            <option value="Heavy Haulage" <?php if ($row['type'] === 'Heavy Haulage') echo 'selected'; ?>   class="craneforminput">Heavy Haulage</option>
            <option value="Boom placer" <?php if ($row['type'] === 'Boom placer') echo 'selected'; ?>   class="craneforminput">Boom placer</option>
            <option value="Concrete pump" <?php if ($row['type'] === 'Concrete pump') echo 'selected'; ?>   class="craneforminput">Concrete pump</option>
            <option value="Batching plant" <?php if ($row['type'] === 'Batching plant') echo 'selected'; ?>   class="craneforminput">Batching plant</option>
            <option value="Mining equipment" <?php if ($row['type'] === 'Mining equipment') echo 'selected'; ?>   class="craneforminput">Mining equipment</option>
            <option value="Tipper" <?php if ($row['type'] === 'Tipper') echo 'selected'; ?>   class="craneforminput">Tipper</option>
        </select>
        
            <input type="text" name="yom" value="<?php echo $row['yom']; ?>"  placeholder="Year of Manufacture (YOM)" class="craneforminput">
        
            <input type="text" name="capacity" value="<?php echo $row['capacity']; ?>" placeholder="Capacity" class="craneforminput">
        
            <input type="text" name="registration" value="<?php echo $row['registration']; ?>" placeholder="Registration" class="craneforminput">
        
            <input type="text" name="chassis" value="<?php echo $row['chassis']; ?>" placeholder="Chassis" class="craneforminput">
        
            <input type="text" name="engine" value="<?php echo $row['engine']; ?>" placeholder="Engine" class="craneforminput">
        
            <input type="text" name="boomLength" value="<?php echo $row['boom_length']; ?>" id="specificTextbox" placeholder="Boom length" class=" specificTextbox craneforminput">
        
            <input type="text" name="jibLength" value="<?php echo $row['jib_length']; ?>" id="specificcTextbox" placeholder="Jib length" class="specificTextbox craneforminput ">
        
            <input type="text" name="luffingLength" value="<?php echo $row['luffing_length']; ?>" id="specificccTextbox" placeholder="Luffing length" class="specificTextbox craneforminput">
        
            <input type="text" name="dieselTankCap" value="<?php echo $row['diesel_tank_capacity']; ?>" placeholder="Diesel tank capacity" class="craneforminput">
        
            <input type="text" name="hydraulicOilTank" value="<?php echo $row['hydraulic_oil_tank']; ?>" placeholder="Hydraulic oil tank" class="craneforminput">
        
            <input type="text" name="hydraulicOilGrade" value="<?php echo $row['hydraulic_oil_grade']; ?>" placeholder="Hydraulic oil grade" class="craneforminput">
        
            <input type="text" name="engineOilCapacity" value="<?php echo $row['engine_oil_capacity']; ?>" placeholder="Engine oil capacity" class="craneforminput">
            <input type="text" name="engineOilGrade" value="<?php echo $row['engine_oil_grade']; ?>" placeholder="Engine oil grade" class="craneforminput">
            <select name="status" class="craneforminput selectoption" >
                <option value="" disabled selected>Choose A Option</option>
                <option value="Working" <?php if ($row['status'] === 'Working') echo 'selected'; ?>>Working</option>
                <option value="Idle" <?php if ($row['status'] === 'Idle') echo 'selected'; ?>>Idle</option>
                <option value="Non working-breakdown" <?php if ($row['status'] === 'Non working-breakdown') echo 'selected'; ?>>Non working-breakdown</option>
                <option value="Not in use" <?php if ($row['status'] === 'Not in use') echo 'selected'; ?> >Not in use</option>
                <option value="Scrap"  >Scrap</option>
            </select>
            
        <button type="submit" class="crane-submit">Update</button>
    </div> 
    </form> 
        <?php
    }
    ?>
    
</body>
</html>