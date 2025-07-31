<?php
include "partials/_dbconnect.php";
session_start();
$email = $_SESSION['email'];
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

$sql_logo_fetch="SELECT * FROM `basic_details` where companyname='$companyname001'";
$result_fetch_logo=mysqli_query($conn , $sql_logo_fetch);
$row_logo_fetch=mysqli_fetch_assoc($result_fetch_logo);

?>

<?php
include_once 'partials/_dbconnect.php'; // Include the database connection file


$quote_id=$_GET['quote_id'];
$sql="SELECT * FROM `quotation_generated` where `sno`='$quote_id'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);


$sql2ndequipment = "SELECT * FROM `second_vehicle_quotation` 
                    WHERE uniqueid = '" . $row['uniqueid'] . "' 
                    AND rental_charges2 IS NOT NULL 
                    AND rental_charges2 != ''";
$result_second = mysqli_query($conn, $sql2ndequipment);

if (mysqli_num_rows($result_second) > 0) {
    $row2equipment = mysqli_fetch_assoc($result_second);
} else {
    $row2equipment = array(); 
}

$sqlthirdequipment = "SELECT * FROM `thirdvehicle_quotation` WHERE uniqueid='" . $row['uniqueid'] . "'
AND rental_charges2 IS NOT NULL 
AND rental_charges2 != ''";
$result_third = mysqli_query($conn, $sqlthirdequipment);
if (mysqli_num_rows($result_third) > 0) {
    $row3equipment = mysqli_fetch_assoc($result_third);
} else {
    $row3equipment = array(); // Assign an empty array or null, depending on your needs
}

$sqlfourthequipment = "SELECT * FROM `fourthvehicle_quotation` WHERE uniqueid='" . $row['uniqueid'] . "'AND rental_charges2 IS NOT NULL AND rental_charges2 != ''";
$result_fourth = mysqli_query($conn, $sqlfourthequipment);
if (mysqli_num_rows($result_third) > 0) {
    $row4equipment = mysqli_fetch_assoc($result_fourth);
} else {
    $row4equipment = array(); // Assign an empty array or null, depending on your needs
}

$sqlfifthequipment = "SELECT * FROM `fifthvehicle_quotation` WHERE uniqueid='" . $row['uniqueid'] . "'AND rental_charges2 IS NOT NULL 
 AND rental_charges2 != ''";
$result_fifth = mysqli_query($conn, $sqlfifthequipment);
if (mysqli_num_rows($result_fifth) > 0) {
    $row5equipment = mysqli_fetch_assoc($result_fifth);
} else {
    $row5equipment = array(); // Assign an empty array or null, depending on your needs
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="favicon.jpg" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Quotation</title>
    
    <style> 
       
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Global styles */
body {
    font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande',
                 'Lucida Sans Unicode', Arial, sans-serif;
    font-size: 14px;
    line-height: 1.6;
    background-color: #f4f4f4;
    margin: 20px;
}

.container_outer {
    max-width: 800px;
    margin: 0 auto;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    padding: 20px;
    border-radius: 8px; 

}

.date {
    display: flex; /* Use flexbox */
    justify-content: space-between; /* Space between items (flex start and end) */
    width: 95%;
}

.date > *:first-child {
    align-self: flex-start; /* Align first child to flex start */

}

.date > *:last-child {
    align-self: flex-end; /* Align last child to flex end */

}/* .date, .ref {
    margin-bottom: 2px;
}
 */
.tocontainer {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
    /* border:1px solid red; */
}

.toadress, .to_contactperson {
    flex: 1;
    padding: 10px;
}
.to_contactperson{
    /* text-transform:capitalize; */
    /* border:1px solid blue; */

}


.salutation {
    margin-bottom: 10px;
}

.table_info {
    width: 100%;
    border-collapse: collapse;
    border: 1px solid black;
    margin-bottom: 10px; 
    font-size:13px;
}

 .table_info td {
    padding: 10px;
    text-align: left;
    /* border: 1px solid black; */
}
.table_info th{
    border:1px solid black;
    padding: 10px;
    text-align: left;

}
.table_info th {
    background-color: #f2f2f2;

}
.table_info tr{
    border:1px solid black;
}
.duration_th{
    width: 40%;
}
.secondrow_quotation {
    background-color: #f9f9f9;
}

            .page-break {
                page-break-before: always; /* Forces a page break before the element */
                page-break-inside: avoid; /* Avoids breaking inside the element */
            }
.equipment_details_td {
    font-size: 12px;
    border-left:1px solid black;
}

.duration_td {
    font-size: 12px;
    border-left:1px solid black;
}

.withregard_section {
    margin-bottom: 10px;
}

.terms {
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    margin-bottom: 10px;
    /* border:2px solid red; */
    /* margin-top:390px; */
}
.equipment_info_details{
    width: 20%;
}
.heading_terms {
    font-size: 16px;
    font-weight: bold;
    margin-bottom: 10px;
}

.terms_condition {
    margin-bottom: 5px;
}

.sender_office_address {
    margin-top: 10px;
    width: 100%;
    text-align: center; /* Correct property name */
}

.watermark {
    font-size: 14px;
    margin-top: 5px;
    color: #999;
    width:100%;
    opacity: 90%;
    color:black;
    text-align: right; /* Correct property name */

}
.button_container {
    text-align: right;
    margin-top: 20px;
}
.print_quotation{
    height: 50px;
    border: none;
    width:  190px;
    background-color: #4067B5;
    color: white;
    font-weight: 600;
    cursor: pointer;
    font-size: 14px;
    
    border-radius: 7px;
}
.logo_namecontainer{
    width: 100%;
    height: 13%;
    display: flex;
    align-items: center;
    justify-content: center;
    border-bottom: 1px solid black;
    margin-bottom:10px;
}

.button_container{
    width: 98%;
    display: flex;
    align-items: center;
    justify-content: center;
}
.view_my_quotation{
    width: 94%;
    border: 2px solid #4067B5;
    margin-left: 3%;
    /* margin-top: 25px; */
    border-collapse: collapse;
    background-color: #4067B5;
    color: white;
    height: 35px;

} 
.terms_condition strong {
    text-transform: uppercase; /* Capitalize only the first letter */
}

.companylogo img{
    width: auto; /* Allow width to adjust dynamically */
    height: auto; /* Allow height to adjust dynamically */
    max-width: 100px; /* Prevent image from overflowing its container */
    max-height: 100px; /* Prevent image from overflowing its container */
    transition: width 0.3s ease, height 0.3s ease; /* Smooth transitions */
    background-size: contain;
}
.compname_{
    max-width: 90%;
    height: 95px;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    font-size: 28px;
    text-transform: capitalize;
    
}
.compname_ span {
            display: inline-block;
            max-width: 110%;
            font-size: 26px; /* Initial font size */
            white-space: nowrap;
            overflow: hidden;
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande',
                 'Lucida Sans Unicode', Arial, sans-serif;
            font-weight: bold;
            /* text-decoration:underline; */
        }


@media print {
    .button_container {
        display: none!important;
    }
}

    </style>
    <!-- Include necessary scripts --> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
</head>
</head>
<body>
<div class="button_container">
    
    <button class="print_quotation"  type="button" onclick="downloadPDF()">Download Quoatation</button> &nbsp
    <button class="print_quotation"  type="button" onclick="window.location.href='generate_quotation_landingpage.php'">Go Back</button>

    <!-- <BUTTON class="">PRINT</BUTTON> -->

    </div>
    <br>

    <div class="container_outer">
    <div class="entire_quotation_container">
    <div class="logo_namecontainer">
    <div class="companylogo">
    <img id="companyLogo" src="img/<?php echo ($row_logo_fetch['companylogo']) ?>" alt="">
</div>
<div class="compname_">
    <span id="companyName"><?php echo $companyname001 ?></span>
</div>
</div>



<!-- Controls for adjusting size -->
<div class="controls">
    <button class="control-btn" onclick="increaseLogoSize()" title="Increase Logo Size">
        <i class="bi bi-arrows-angle-expand"></i> Logo +
    </button>
    <button class="control-btn" onclick="decreaseLogoSize()" title="Decrease Logo Size">
        <i class="bi bi-arrows-angle-contract"></i> Logo -
    </button>
    <button class="control-btn" onclick="increaseTextSize()" title="Increase Text Size">
        <i class="bi bi-plus-circle"></i> Text +
    </button>
    <button class="control-btn" onclick="decreaseTextSize()" title="Decrease Text Size">
        <i class="bi bi-dash-circle"></i> Text -
    </button>
</div>


<div class="date">Date: <?php echo date('d-m-Y', strtotime($row['quote_date'])); ?>        
        <?php $firstThreeLetters = substr($companyname001, 0, 3); ?>
    <div class="ref">Ref No: &nbsp<?php echo $firstThreeLetters ?> / <?php echo substr($row['quote_date'], 0, 4);  ?> / <?php echo $row['ref_no'] ?></div>

</div>
   
    <div class="tocontainer">
            <div class="toadress">To, <p class="sender_name space"><?php echo $row['to_name'] ?></p> <p class="sender_name address_tobe_sent space"><?php echo $row['to_address'] ?></p> </div>

            <div class="to_contactperson sender_name">
                Contact Person :<?php echo $row['salutation'] ?> <?php echo $row['contact_person'] ?>
                <p class="space">Cell :<?php echo $row['contact_person_cell'] ?></p>
                <p class="space email-responsive">
                    Email ID : <span class="email-value"><?php echo $row['email_id_contact_person'] ?></span>
                </p>
                <p class="space">Site Location : <?php echo $row['site_loc'] ?></p>
            </div>
        </div>
        <div class="salutation">
            <!-- <p>Dear Sir/Ma'am;</p> -->
            <p>Please find our proposed offer as below as per your requirement for providing equipment on rental bassis</p>
        </div>
        <table class="table_info">
            <th class='equipment_info_details'>Equipment</th>
            <!--  -->
            <th class="duration_th">
    For <?php echo $row['shift_info'] ?> Fixed 
    <?php 
    if($row['shift_info']==='Single Shift'){ echo $row['hours_duration'];} else{ echo $row['engine_hours'];}
        // echo !empty($row['hours_duration']) ? $row['hours_duration'] : $row['engine_hours'];
    ?> Hours + <?php echo $row['days_duration'] ?> Days in month <?php echo $row['sunday_included'] ?>
</th>
            <th>Equipment Details</th>
            
            <tr>
                <td><?php echo $row['sub_Type'] . " - " . $row['make'] . "  " . $row['model']; ?></td>
                <td class="duration_td"><p>Rental Charges: ₹ <?php echo number_format($row['rental_charges']); ?>/- per month</p>
                <p>Mob Charges: ₹ <?php echo number_format($row['mob_charges']); ?>/- one time</p>
                <p>Demob Charges: ₹ <?php echo number_format($row['demob_charges']) ?>/- one time </p>
            </td>
                <td class="equipment_details_td">
                <p><a class="equip_boom" <?php echo empty($row['boom']) ? 'hidden' : ''; ?>>Boom: <?php echo $row['boom'] ?>mtrs |</a><a <?php echo empty($row['luffing']) ? 'hidden' : ''; ?> >Luffing:-<?php echo $row['luffing'] ?>mtrs|</a><a <?php echo empty($row['jib']) ? 'hidden' : ''; ?>> Jib:-<?php echo $row['jib'] ?>mtrs</a></p>
                <p>Cap <?php echo $row['cap'] . " " . $row['cap_unit']; ?> | Fuel: <?php echo $row['fuel/hour']  . ' ' . $row['fuelUnit']; ?> | Adblue:<?php echo $row['adblue'] ?> </p>
                <p>Location: <?php echo $row['crane_location'] ?> | YOM:<?php echo substr($row['yom'], 0, 4); ?></p>
                <p>Availability: <?php 
    // Check if availability is 'Not Immediate' before formatting
    if ($row['availability'] === 'Not Immediate') { 
        echo date('d-m-Y', strtotime($row['tentative_date'])); 
    } else { 
        echo $row['availability']; 
    } 
?></p>
                <!-- <p <?php if ($row['tentative_date'] === null || empty($row['tentative_date'])) { echo 'hidden'; } ?>>Tentative Date:-<?php echo $row['tentative_date'] ?></p> -->


                </td>
            </tr>
<!-- second row -->
<tr class="secondrow_quotation"  <?php if (!isset($row2equipment['sub_type2'])) { echo 'hidden'; } ?>>
                <td><?php echo $row2equipment['sub_type2'] . " - " . $row2equipment['make2'] . "  " . $row2equipment['model2']; ?></td>
                <td class="duration_td"><p>Rental Charges: ₹ <?php
if (!empty($row2equipment['rental_charges2'])) {
    echo number_format($row2equipment['rental_charges2']);
}
?>/- per month</p>
                <p>Mob Charges: ₹ <?php
if (isset($row2equipment['mob_charges2'])) {
    echo number_format( $row2equipment['mob_charges2']);
}
?>
/- one time</p>
                <p>Demob Charges: ₹ <?php
if (!empty($row2equipment['demob_charges2'])) {
    echo number_format($row2equipment['demob_charges2']);
}
?>/- one time </p>
            </td>
                <td class="equipment_details_td">
                <p><a class="equip_boom" <?php echo empty($row2equipment['boom2']) ? 'hidden' : ''; ?>>Boom: <?php echo $row2equipment['boom2'] ?>mtrs |</a><a <?php echo empty($row2equipment['luffing2']) ? 'hidden' : ''; ?> >Luffing:-<?php echo $row2equipment['luffing2'] ?>mtrs|</a><a <?php echo empty($row2equipment['jib2']) ? 'hidden' : ''; ?>> Jib:-<?php echo $row2equipment['jib2'] ?>mtrs</a></p>
                <p>Cap <?php echo $row2equipment['cap2'] . " " . $row2equipment['cap_unit2']; ?> | Fuel: <?php echo $row2equipment['fuel/hour2']  . ' ' . $row2equipment['fuelUnit']; ?> | Adblue:<?php echo $row2equipment['adblue2'] ?> </p>
                <p>Location: <?php echo $row2equipment['crane_location2'] ?> | YOM:<?php echo substr($row2equipment['yom2'], 0, 4); ?></p>
                <p>Availability: <?php 
    // Check if availability is 'Not Immediate' before formatting
    if ($row2equipment['availability2'] === 'Not Immediate') { 
        echo date('d-m-Y', strtotime($row2equipment['tentative_date2'])); 
    } else { 
        echo $row2equipment['availability2']; 
    } 
?></p>

<!-- <p <?php if(empty($row2equipment['tentative_date2'])) { echo 'style="display:none;"'; } ?>>
    Tentative Date: <?php echo empty($row2equipment['tentative_date2']) ? '' : date('d-m-y', strtotime($row2equipment['tentative_date2'])); ?>
</p> -->


                </td>
            </tr>

            <!-- thirdrow -->
            <tr class="secondrow_quotation"  <?php if (!isset($row3equipment['sub_type2'])) { echo 'hidden'; } ?>>
                <td><?php echo $row3equipment['sub_type2'] . " - " . $row3equipment['make2'] . "  " . $row3equipment['model2']; ?></td>
                <td class="duration_td"><p>Rental Charges: ₹ <?php
if (!empty($row3equipment['rental_charges2'])) {
    echo number_format($row3equipment['rental_charges2']);
}
?>/- per month</p>
                <p>Mob Charges: ₹ <?php
if (isset($row3equipment['mob_charges2'])) {
    echo number_format( $row3equipment['mob_charges2']);
}
?>
/- one time</p>
                <p>Demob Charges: ₹ <?php
if (!empty($row3equipment['demob_charges2'])) {
    echo number_format($row3equipment['demob_charges2']);
}
?>/- one time </p>
            </td>
                <td class="equipment_details_td">
                <p><a class="equip_boom" <?php echo empty($row3equipment['boom2']) ? 'hidden' : ''; ?>>Boom: <?php echo $row3equipment['boom2'] ?>mtrs |</a><a <?php echo empty($row3equipment['luffing2']) ? 'hidden' : ''; ?> >Luffing:-<?php echo $row3equipment['luffing2'] ?>mtrs|</a><a <?php echo empty($row3equipment['jib2']) ? 'hidden' : ''; ?>> Jib:-<?php echo $row3equipment['jib2'] ?>mtrs</a></p>
                <p>Cap <?php echo $row3equipment['cap2'] . " " . $row3equipment['cap_unit2']; ?> | Fuel: <?php echo $row3equipment['fuel/hour2']  . ' ' . $row3equipment['fuelUnit']; ?> | Adblue:<?php echo $row3equipment['adblue2'] ?> </p>
                <p>Location: <?php echo $row3equipment['crane_location2'] ?> | YOM:<?php echo substr($row3equipment['yom2'], 0, 4); ?></p>
                <p>Availability: <?php 
    // Check if availability is 'Not Immediate' before formatting
    if ($row3equipment['availability2'] === 'Not Immediate') { 
        echo date('d-m-Y', strtotime($row3equipment['tentative_date2'])); 
    } else { 
        echo $row3equipment['availability2']; 
    } 
?></p>

<!-- <p <?php if(empty($row3equipment['tentative_date2'])) { echo 'style="display:none;"'; } ?>>
    Tentative Date: <?php echo empty($row3equipment['tentative_date2']) ? '' : date('d-m-y', strtotime($row3equipment['tentative_date2'])); ?>
</p> -->


                </td>
            </tr>

            <!-- fourthrow -->
            <tr class="secondrow_quotation"  <?php if (!isset($row4equipment['sub_type2'])) { echo 'hidden'; } ?>>
                <td><?php echo $row4equipment['sub_type2'] . " - " . $row4equipment['make2'] . "  " . $row4equipment['model2']; ?></td>
                <td class="duration_td"><p>Rental Charges: ₹ <?php
if (!empty($row4equipment['rental_charges2'])) {
    echo number_format($row4equipment['rental_charges2']);
}
?>/- per month</p>
                <p>Mob Charges: ₹ <?php
if (isset($row4equipment['mob_charges2'])) {
    echo number_format( $row4equipment['mob_charges2']);
}
?>
/- one time</p>
                <p>Demob Charges: ₹ <?php
if (!empty($row4equipment['demob_charges2'])) {
    echo number_format($row4equipment['demob_charges2']);
}
?>/- one time </p>
            </td>
                <td class="equipment_details_td">
                <p><a class="equip_boom" <?php echo empty($row4equipment['boom2']) ? 'hidden' : ''; ?>>Boom: <?php echo $row4equipment['boom2'] ?>mtrs |</a><a <?php echo empty($row4equipment['luffing2']) ? 'hidden' : ''; ?> >Luffing:-<?php echo $row4equipment['luffing2'] ?>mtrs|</a><a <?php echo empty($row4equipment['jib2']) ? 'hidden' : ''; ?>> Jib:-<?php echo $row4equipment['jib2'] ?>mtrs</a></p>
                <p>Cap <?php echo $row4equipment['cap2'] . " " . $row4equipment['cap_unit2']; ?> | Fuel: <?php echo $row4equipment['fuel/hour2'] . ' ' . $row4equipment['fuelUnit']; ?> | Adblue:<?php echo $row4equipment['adblue2'] ?> </p>
                <p>Location: <?php echo $row4equipment['crane_location2'] ?> | YOM:<?php echo substr($row4equipment['yom2'], 0, 4); ?></p>
                <p>Availability: <?php 
    // Check if availability is 'Not Immediate' before formatting
    if ($row4equipment['availability2'] === 'Not Immediate') { 
        echo date('d-m-Y', strtotime($row4equipment['tentative_date2'])); 
    } else { 
        echo $row4equipment['availability2']; 
    } 
?></p>

<!-- <p <?php if(empty($row4equipment['tentative_date2'])) { echo 'style="display:none;"'; } ?>>
    Tentative Date: <?php echo empty($row4equipment['tentative_date2']) ? '' : date('d-m-y', strtotime($row4equipment['tentative_date2'])); ?>
</p> -->


                </td>
            </tr>
    <!-- fifthrow -->
    <tr class="secondrow_quotation"  <?php if (!isset($row5equipment['sub_type2'])) { echo 'hidden'; } ?>>
                <td><?php echo $row5equipment['sub_type2'] . " - " . $row5equipment['make2'] . "  " . $row5equipment['model2']; ?></td>
                <td class="duration_td"><p>Rental Charges: ₹ <?php
if (!empty($row5equipment['rental_charges2'])) {
    echo number_format($row5equipment['rental_charges2']);
}
?>/- per month</p>
                <p>Mob Charges: ₹ <?php
if (isset($row5equipment['mob_charges2'])) {
    echo number_format( $row5equipment['mob_charges2']);
}
?>
/- one time</p>
                <p>Demob Charges: ₹ <?php
if (!empty($row5equipment['demob_charges2'])) {
    echo number_format($row5equipment['demob_charges2']);
}
?>/- one time </p>
            </td>
                <td class="equipment_details_td">
                <p><a class="equip_boom" <?php echo empty($row5equipment['boom2']) ? 'hidden' : ''; ?>>Boom: <?php echo $row5equipment['boom2'] ?>mtrs |</a><a <?php echo empty($row5equipment['luffing2']) ? 'hidden' : ''; ?> >Luffing:-<?php echo $row5equipment['luffing2'] ?>mtrs|</a><a <?php echo empty($row5equipment['jib2']) ? 'hidden' : ''; ?>> Jib:-<?php echo $row5equipment['jib2'] ?>mtrs</a></p>
                <p>Cap <?php echo $row5equipment['cap2'] . " " . $row5equipment['cap_unit2']; ?> | Fuel: <?php echo $row5equipment["fuel/hour2"] . ' ' . $row5equipment['fuelUnit']; ?>| Adblue:<?php echo $row5equipment['adblue2'] ?> </p>
                <p>Location: <?php echo $row5equipment['crane_location2'] ?> | YOM:<?php echo substr($row5equipment['yom2'], 0, 4); ?></p>
                <p>Availability: <?php 
    // Check if availability is 'Not Immediate' before formatting
    if ($row5equipment['availability2'] === 'Not Immediate') { 
        echo date('d-m-Y', strtotime($row5equipment['tentative_date2'])); 
    } else { 
        echo $row5equipment['availability2']; 
    } 
?></p>

<!-- <p <?php if(empty($row5equipment['tentative_date2'])) { echo 'style="display:none;"'; } ?>>
    Tentative Date: <?php echo empty($row5equipment['tentative_date2']) ? '' : date('d-m-y', strtotime($row5equipment['tentative_date2'])); ?>
</p> -->


                </td>
            </tr>



            




        </table>
        <div class="withregard_section">
            <p>Thanks And Regards</p>
            <p class="sender_name"><?php echo $row['sender_name'] ?></p>
            <p class="sender_name"><?php echo $row['company_name'] ?></p>
            <p><?php echo $row['sender_number'] ?></p>
            <p class="sender_name"><?php echo $row['senders_designation'] ?></p>
            <p><?php echo $row['sender_contact'] ?> </p>
        </div>
    </div>
    <div class="page-break"></div>
    <div class="terms">


 
<p class="heading_terms">Terms & Conditions :

</p>
<p class="terms_condition">
    <strong>1. Working Shift :</strong> Start time to be <?php echo $row['working_start'] ?> end time to be <?php echo $row['working_end'] ?> <?php echo $row['working_end_unit'] ?> <?php echo $row['food_break'] ?>
</p>
    <p class="terms_condition">
    <strong>2. Breakdown :</strong> 
<?php echo $row['brkdown'] ?>    After free time, breakdown charges to be deducted on pro-rata basis
</p>
<p class="terms_condition">
    <strong>3. Operating Crew :</strong> <?php echo $row['crew'] ?> &nbsp &nbsp &nbsp &nbsp    <strong>4. Operator Room Scope :</strong> <?php echo $row['room'] ?>

</p>


<p class="terms_condition">
    <strong>5. Crew Food Scope :</strong>  <?php echo $row['food'] ?> &nbsp &nbsp &nbsp &nbsp      <strong>6. Crew Travelling :</strong> <?php echo $row['travel'] ?> 

</p>
<p class="terms_condition">
    <strong>7. Fuel :</strong>Fuel shall be issued as per OEM norms by <?php echo $row['fuel_scope'] ?></p>

    <p class="terms_condition"><strong>8. Adblue :</strong>Adblue if required to be provided by <?php echo $row['adblue_scope'] ?></p>

    <p class="terms_condition">
    <strong>9. Period Of Contract :</strong> Minimum order shall be <?php echo $row['period_contract'] ?> 
</p>

<p class="terms_condition">
<strong>10. Working State Road Tax :</strong>if applicable road tax to be in scope of 
<?php echo $row['road_tax'] . ' ' . $row['roadtax_condition'] . ' of ' . $row['lumsumamount']; ?>

<p class="terms_condition"><strong>11. Dehire Clause :</strong>  Dehire notice must be provided with a minimum 
<?php echo $row['dehire_clause'] ?> notice.</p>

<p class="terms_condition">
    <strong>12. Payment Terms :</strong> <?php echo $row['pay_terms'] ?>
   
</p>

<p class="terms_condition">
    <strong>13. Advance Payment :</strong> <?php echo $row['adv_pay'] ?>
</p>






<p class="terms_condition">
    <strong>14. Supporting Equipment :</strong> 
<?php echo $row['equipment_assembly']?></p>

<p class="terms_condition">
    <strong>15. TPI Scope :</strong> <?php echo $row['tpi'] ?> </p>

    <p class="terms_condition">
    <strong>16. Safety And Security :</strong> <?php echo $row['safety'] ?>
</p>

<div class="terms_area terms_condition" >
    <strong>17. GST :</strong>Applicable,extra payable at actual invoice value at <?php echo $row['gst'] ?>
</div>
<p class="terms_condition"><strong>18. PPE Kit :</strong>If required to be provided <?php echo $row['ppe_kit'] ?></p>

<div class="terms_area terms_condition" >
    <strong>19. Over time payment : </strong>Applicable. OT charges at <?php echo $row['ot_pay'] ?> pro-rata basis payable if equipment has worked beyond stipulated work shift, engine hours and on sundays,national holidays
</div>
<div class="terms_area terms_condition" >
    <strong>20. Tools & Tackles :</strong>Related tools and tackles , to be provided  <?php echo $row['tools'] ?>
</div>

<p class="terms_condition">
    <strong>21. Internal Shifting :</strong> <?php echo $row['internal_shifting'] ?>
</p>

<p class="terms_condition">
    <strong>22. Mobilisation Notice :</strong> Minimum<?php echo $row['mobilisation_notice'] ?> notice reqired in mobilising equipment from our end
</p>





<div class="terms_area terms_condition" >
    <strong>23. Delay payment clause : </strong><?php echo $row['delay_pay'] ?>
                                

</div>












<div class="terms_area terms_condition" >
    <strong>24. Force Majeure clause :</strong><?php echo $row['force_clause'] ?>
</div>
<p class="terms_condition">
    <strong>25. Quote Validity :</strong>Provided quotation rates will remain valid for a period of <?php echo $row['quote_validity'] ?>
</p>
<p class="terms_condition"><Strong>26.Machine Stoppage Policy :</Strong>If the machine is stopped for any reason not caused by us, including payment delays or site issues, the rental charges will continue during the stoppage period until the machine resumes work.</p>

<?php if (!empty($row['custom_terms']) && $row['custom_terms'] !== '27.Custom Terms And Condition To Be Written Here If Any If Not Leave It , As It Is') : ?>
    <p class="terms_condition">
        <?php echo $row['custom_terms']; ?>
    </p>
<?php endif; ?>
<hr>
<p class="sender_office_address">Office : <?php echo $row['sender_office_address'] ?></p>
<p class="watermark">Powered By Fleet EIP.</p>
    </div>
</div>
</body>
<style>
    .controls {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 18px;
    margin-bottom: 20px;
    background: #f7f7fa;
    border-radius: 8px;
    padding: 10px 0;
    box-shadow: 0 2px 8px rgba(64,103,181,0.07);
}
.control-btn {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 8px 18px;
    font-size: 15px;
    font-weight: 500;
    color: #4067B5;
    background: #fff;
    border: 1px solid #4067B5;
    border-radius: 6px;
    cursor: pointer;
    transition: background 0.2s, color 0.2s, box-shadow 0.2s;
    box-shadow: 0 1px 4px rgba(64,103,181,0.08);
}
.control-btn:hover, .control-btn:focus {
    background: #4067B5;
    color: #fff;
    outline: none;
}
.control-btn i {
    font-size: 18px;
    vertical-align: middle;
}
@media (max-width: 600px) {
    .controls {
        flex-direction: column;
        gap: 10px;
        padding: 8px 0;
    }
    .control-btn {
        width: 90vw;
        justify-content: center;
        font-size: 14px;
        padding: 8px 0;
    }
}

.email-responsive {
    display: inline-flex;
    align-items: baseline;
    gap: 4px;
    vertical-align: middle;
}
.email-responsive .email-value {
    font-size: 14px;
    word-break: break-all;
    white-space: normal;
    display: inline;
    max-width: 220px;
    vertical-align: baseline;
    line-height: inherit;
}
@media (max-width: 600px) {
    .email-responsive {
        display: block;
        align-items: flex-start;
        gap: 0;
    }
    .email-responsive .email-value {
        font-size: 12px;
        max-width: 98vw;
        display: block;
    }
}
</style>
<script>
                function fix() {
                $(window).resizeBy(250, 250);
                $(window).focus();
            }

function downloadPDF() {
    const element = document.querySelector('.container_outer');
    document.querySelector('.controls').style.display="none";

    html2pdf(element, {
        margin: 0.2, // Adjust the margin as needed
        filename: "<?php echo $row['ref_no'] . ' ' . $row['to_name'] . '-' . $row['site_loc'] . '.pdf'; ?>",
        image: { type: 'jpeg', quality: 1.0 },
        html2canvas: { 
            dpi: 400, // Set higher DPI for better image quality
            letterRendering: true, 
            scale: 4, // Increase the scale for better quality
            useCORS: true // Use CORS to ensure images are loaded correctly
        },
        jsPDF: { 
            unit: 'in', 
            format: 'letter', 
            orientation: 'portrait' 
        }
    });
}

function increaseLogoSize() {
    var logo = document.getElementById('companyLogo');
    var currentWidth = logo.clientWidth;
    logo.style.width = (currentWidth + 10) + 'px';
}

function decreaseLogoSize() {
    var logo = document.getElementById('companyLogo');
    var currentWidth = logo.clientWidth;
    if (currentWidth > 10) { // Prevent the logo from becoming too small
        logo.style.width = (currentWidth - 10) + 'px';
    }
}

function increaseTextSize() {
    var text = document.getElementById('companyName');
    var currentSize = parseFloat(window.getComputedStyle(text, null).getPropertyValue('font-size'));
    text.style.fontSize = (currentSize + 1) + 'px';
}

function decreaseTextSize() {
    var text = document.getElementById('companyName');
    var currentSize = parseFloat(window.getComputedStyle(text, null).getPropertyValue('font-size'));
    if (currentSize > 10) { // Prevent the text from becoming too small
        text.style.fontSize = (currentSize - 1) + 'px';
    }
}
</script>

</html>