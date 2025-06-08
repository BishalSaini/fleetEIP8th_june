<?php
include "partials/_dbconnect.php";
$id=$_GET['id'];
$sql="SELECT * FROM `requirement_price_byrental` where id='$id'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);
?>
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
            <li><a href="epc_dashboard.php">Dashboard</a></li>
            <li><a href="view_news_epc.php">News</a></li>
            <li><a href="logout.php">Log Out</a></li>
        </ul>
    </div>
</div> 
<form action="" class="offer_full">
    <div class="offer_first">
        <h3>Epc Requirement</h3>
        <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" name="fleet_category" class="input02" value="<?php echo $row['fleet_category']; ?>">
                <label class="placeholder2">Fleet Category</label>
            </div>
            <div class="trial1">
                <input type="text" name="type" class="input02" placeholder="" value="<?php echo $row["type"] ?>" readonly>
                <label class="placeholder2">Equipment Type</label>
            </div></div>
            <div class="outer02">
            <div class="trial1">
            <input type="text" name="equip_capacity" class="input02" placeholder="" value="<?php echo $row['cap'] . " " . $row['unit'] ?>" readonly>
            <label class="placeholder2">Equipment Capacity</label>
            </div>
            <div class="trial1">
            <input type="text" name="boom_combination" value="<?php echo $row['boom_combination'] ?>" class="input02" placeholder="" readonly>
            <label class="placeholder2">Boom Combination</label>
            </div>
            </div>
            <div class="trial1">
                <input type="text" name="project_type" placeholder="" class="input02" value="<?php echo $row["project_type"] ?>" readonly>
                <label class="placeholder2">Project Type</label>
    </div>
            <div class="outer02">
            <div class="trial1">
                <input type="text" name="state" placeholder="" class="input02" value="<?php echo $row["state"] ?>" readonly>
                <label class="placeholder2"> Project State</label>
            </div>
            <div class="trial1">
                <input class="input02" name="district" type="text" placeholder="" value="<?php echo $row["district"] ?>" readonly>
                <label class="placeholder2">Project District</label>
            </div>
            </div>
            <div class="outer02">
            <div class="trial1">
                <input class="input02" name="duration" type="text" placeholder="" value="<?php echo $row["duration"] . " Month"?>" readonly>
                <label class="placeholder2">Duration </label>
            </div>
            <div class="trial1">
                <input type="text" class="input02" name="working_shift" placeholder="" value="<?php echo $row['working_shift'] ?>" readonly>
                <label class="placeholder2">Working Shift</label>
            </div>
            <div class="trial1">
            <input class="input02" name="date" type="text" placeholder="" value="<?php echo date("d-m-Y", strtotime($row['date'])); ?>" readonly>
                <label class="placeholder2"> Required By</label>
                </div>
            <?php
                $engineStyle = empty($row['engine_hour']) ? 'style="display:none"' : '';
                ?>
            <div class="trial1" <?php echo $engineStyle?> >
                <input type="text" class="input02" name="engine_hour" placeholder="" value="<?php echo $row['engine_hour'] ?>" readonly>
                <label class="placeholder2">Engine Hour</label>
            </div>
            </div>
<br>

    </div>
    <div class="offer_second">
        <h3>Rental Offer</h3>
        <div class="outer02">
        <div class="trial1">
            <input type="text" class="input02" value="<?php echo $row['offer_make'] ?>">
            <label for="" class="placeholder2">Equipment Make</label>
        </div>
        <div class="trial1">
            <input type="text" class="input02" value="<?php echo $row['offer_model'] ?>">
            <label for="" class="placeholder2">Equipment Model</label>
        </div>
        <div class="trial1">
                    <input type="text" name="offer_yom" placeholder="" value="<?php echo $row['offer_yom'] ?>" class="input02">
                    <label for="" class="placeholder2">YOM  </label>
                </div>

        </div>
        <div class="trial1">
            <input type="text" value="<?php echo $row['offer_assembly'] ?>" class="input02">
            <label for="" class="placeholder2">Equipment Assembly Required ?</label>
        </div>
        <?php $ds = (empty($row['offer_assembly_scope'])) ? 'hidden' : ''; ?>
<div class="trial1" <?php echo $ds; ?>>
    <input type="text" value="<?php echo $row['offer_assembly_scope']; ?>" class="input02">
    <label for="" class="placeholder2">Equipment Assembly In Scope Of</label>
</div>
<div class="outer02">
    <div class="trial1">
        <input type="text" value="<?php echo $row['offer_equip_location'] . "-" .$row['offer_district'] ?>" class="input02">
        <label for="" class="placeholder2">Equipment Location</label>
    </div>
    <div class="trial1">
    <input type="text" value="<?php echo date('d-m-Y', strtotime($row['available_From_offer'])); ?>" class="input02">
        <label for="" class="placeholder2">Equipment Available From </label>
    </div>

</div>
<div class="outer02">
    <div class="trial1">
        <input type="text" value="<?php echo $row['payment_terms'] ?>" class="input02">
        <label for="" class="placeholder2">Payment Terms</label>
    </div>
    <div class="trial1">
        <input type="text" value="<?php echo $row['mob_charges'] ?>" class="input02">
        <label for="" class="placeholder2">Mob Charges</label>
    </div>

    <div class="trial1">
        <input type="text" value="<?php echo $row['demob_charges'] ?>" class="input02">
        <label for="" class="placeholder2">Demob Charges</label>
    </div>
</div>
<div class="trial1">
    <input type="text" value="<?php echo $row['contact_person_offer'] ?>" class="input02">
    <label for="" class="placeholder2">Contact Person</label>
</div>
<div class="trial1">
    <input type="text" value="<?php echo $row['contact_person_offer_email'] ?>" class="input02">
    <label for="" class="placeholder2">Contact Person Email</label>
</div>
<br>
    </div>  
</form>
</body>
</html>
