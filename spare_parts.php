<style>
<?php include "style.css" ?>
</style>
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
            <li><a href="news/">News</a></li>
            <li><a href="contact_us.php">Contact Us</a></li>
            <li><a href="logout.php">Log Out</a></li></ul>
        </div>
    </div> 
    <form action="" class="spare_parts_formm">
        <div class="spare_container">
            <div class="consumable_head"><h2 class="consumable">Consumable Requirements</h2></div>
            <div class="trial1">
            <select name="" id="" class="input02">
                <option value="" disabled selected>Material Required</option>
                <option value="oil_lubricants">Oil And Lubricants</option>
                <option value="spares">Spares</option>
                <option value="wire_slings">Wire And Slings</option>                
            </select>
            </div>
            <div class="trial1">
            <select name="" id="" class="oil_type input02">
                <option value=""disabled selected>Select Oil Type</option>
                <option value="hydraulic_oil">Hydraulic Oil</option>
                <option value="gear_oil">Gear Oil</option>
                <option value="engine_oil">Engine Oil</option>
                <option value="grease">Grease</option>
            </select>
            </div>
            <div class="trial1">
            <input type="text" placeholder="" class="input02">
            <label class="placeholder2">Grade Required</label>
            </div>
            <div class="trial1">
            <input type="text" placeholder="" class="input02">
            <label class="placeholder2">State</label>
            </div>
            <div class="trial1">
            <input type="text" placeholder="" class="input02">
            <label class="placeholder2">District</label>
            </div>           
            <div class="trial1">
            <select name="" id="" class="input02">
                <option value="" disabled selected>Quantity Required In</option>
                <option value="bucket">Bucket</option>
                <option value="barrel">Barrel</option>
            </select>
            </div>
            <div class="trial1">
            <input type="text" placeholder="" class="input02">
            <label class="placeholder2">Quantity</label>
            </div>
            <div class="trial1">
            <select name="" id="" class="input02">
                <option value="" disabled selected> Spare Type</option>
                <option value="">Filters</option>
                <option value="">Electricals</option>
                <option value="">Others</option>
            </select>
            </div>
            <div class="trial1">
            <select name="" id="" class="equip_brand input02">
                <option value="" disabled selected>Equipment Brand</option>
            </select>
            </div>
            <div class="trial1">
            <input type="text" placeholder="" class="input02">
            <label class="placeholder2">Detail Of Requirement</label>
            </div>
            <div class="trial1">
            <input type="text" placeholder="" class="input02">
            <label class="placeholder2">Dia Of Wire/Slings</label>
            </div>
            <div class="trial1">
            <input type="text" placeholder="" class="input02">
            <label class="placeholder2">Length Of Wire/Sling</label>
            </div>
            <div class="trial1">
            <input type="text" placeholder="" class="input02">
            <label class="placeholder2">Capacity Of Wire/Sling</label>
            </div>
            <div class="trial1">
            <select name="" id="" class="input02">
                <option value="" disabled selected>Wire Type</option>
            </select>
            </div>
            <div class="trial1">
            <input type="text" placeholder="" class="input02">
            <label class="placeholder2">Make</label>
            
            </div>
            <button type="submit" class="logi_req" >Post Requirement</button>
            <br>
        </div>
    </form>
    <br><br>
</body>
</html>