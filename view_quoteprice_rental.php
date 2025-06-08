<?php
session_start();
$email = $_SESSION['email'];
$companyname001 = $_SESSION['companyname'];
$enterprise = $_SESSION['enterprise'];
$dashboard_url = '';

if ($enterprise === 'rental') {
    $dashboard_url = 'rental_dashboard.php';
} elseif ($enterprise === 'logistics') {
    $dashboard_url = 'logisticsdashboard.php';
} elseif ($enterprise === 'epc') {
    $dashboard_url = 'epc_dashboard.php';
} else {
    $dashboard_url = '';
}

$showError1 = false;
$showAlert=false;
if (isset($_SESSION['date'])) {
    $showError1 = true;
    unset($_SESSION['date']);
}

?>

<?php
include_once 'partials/_dbconnect.php'; // Include the database connection file

$id = $_GET['id'];
$sql = "SELECT * FROM req_by_epc WHERE id='$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if (isset($_SESSION['view'])) {
    $showAlert = true;
    unset($_SESSION['view']);
}
$epcNumber = 'Quote Price To View'; // Default value
if ($showAlert && isset($row['epc_number'])) {
    $epcNumber = $row['epc_number'];
}
$EPCemail = 'Quote Price To View'; // Default value
if ($showAlert && isset($row['epc_email'])) {
    $EPCemail = $row['epc_email'];
}

$sql2 = "SELECT * FROM requirement_price_byrental WHERE req_id='$id' AND rental_name='$companyname001'";
$result2 = mysqli_query($conn, $sql2);
$row2 = $result2 ? mysqli_fetch_assoc($result2) : NULL;

$asset_code_selection = "SELECT * FROM fleet1 WHERE companyname='$companyname001'";
$result_asset_code = mysqli_query($conn, $asset_code_selection);


$asset_code_selection2 = "SELECT * FROM fleet1 WHERE companyname='$companyname001'";
$result_asset_code2 = mysqli_query($conn, $asset_code_selection2);
?>

<?php 

  // PHP Mailer - Send Email to EPC
  require 'PHPMailer/PHPMailer.php';
  require 'PHPMailer/SMTP.php';
  require 'PHPMailer/Exception.php';

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once 'partials/_dbconnect.php';

    $epc_email = $_POST["epc_email"];
    $epcname=$_POST['epcname'];
    $req_id = $_POST['req_id'];

    $reqequipmenttype=$_POST['equipment_type'];
    $epcprojectstate=$_POST['state'];
    $epcprojectdistrict=$_POST['district'];
    $epcprojectduration=$_POST['duration_month'];


    $offer_equip_make = $_POST['offer_equip_make'];
    $offer_Equip_model = $_POST['offer_Equip_model'];
    $yom_equip = $_POST['yom_equip'];
    $offer_assembly = !empty($_POST['offer_assembly']) ? $_POST['offer_assembly'] : null;
    $offer_assembly_Scope = !empty($_POST['offer_assembly_Scope']) ? $_POST['offer_assembly_Scope'] : null;
    $offer_location = $_POST['offer_location'] ?? '';
    $offer_district = $_POST['offer_district'];
    $offer_Available = $_POST['offer_Available'] ?? '';
    $offer_payment = $_POST['offer_payment'] ?? '';
    $price_quote = $_POST["price_quoted"];
    $epc_name = $_POST["EPCcomp_name"];
    $offer_mob_charges = $_POST['offer_mob_charges'];
    $offer_demob_charge = $_POST['offer_demob_charge'];
    $offer_contact_person_name = $_POST['offer_contact_person_name'];
    $comp_number = $_POST['comp_number'];
    $offer_email = $_POST['offer_email'];
    $rental_notes = $_POST['rental_notes'];
    $equipmentcapacity = $_POST['equipmentcapacity'];
    $equipmentunit = $_POST['equipmentunit'];
    $boom = $_POST['boom'];
    $jib = $_POST['jib'];
    $luffing = $_POST['luffing'];

    $reqValidDate = $_POST['validdatenormal'];
    $currentDate = $_POST['currentdatenormal'];
    $equip_capacity=$_POST['equip_capacity'];
    $epcworkingshift=$_POST['epcworkingshift'];

    if (strtotime($currentDate) > strtotime($reqValidDate)) {
        $_SESSION['date'] = "date has passed";
        $redirectUrl = "view_quoteprice_rental.php?id=" . urlencode($req_id);
        header("Location: $redirectUrl");
    } else {
        $sql_price = "INSERT INTO requirement_price_byrental(req_id,cap,epc_name, price_quoted, rental_name, rental_email, rental_number,
            unit, offer_make, offer_model, offer_yom, offer_assembly, offer_assembly_scope, 
            offer_equip_location, offer_district, available_From_offer, payment_terms, mob_charges, 
            demob_charges, contact_person_offer, rental_notes,boom,jib,luffing) 
            VALUES ('$req_id','$equipmentcapacity','$epc_name','$price_quote','$companyname001','$offer_email','$comp_number',
            '$equipmentunit','$offer_equip_make','$offer_Equip_model','$yom_equip','$offer_assembly',
            '$offer_assembly_Scope','$offer_location','$offer_district','$offer_Available','$offer_payment',
            '$offer_mob_charges','$offer_demob_charge','$offer_contact_person_name','$rental_notes','$boom','$jib','$luffing')";
        $result = mysqli_query($conn, $sql_price);

        if ($result) {
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = 'smtp.hostinger.com';                   // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = 'support@fleeteip.com';                 // SMTP username
                $mail->Password   = 'fleetEIP@0807';                        // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            // Enable implicit TLS encryption
                $mail->Port       = 465;                                    // TCP port to connect to

                // Email to the user for verification
                $mail->setFrom('support@fleeteip.com', 'FleetEIP');
                $mail->addAddress($epc_email);  

                $mail->isHTML(true);
                $mail->Subject = 'Price Quote Recieved';
                $mail->Body = "
<html>
<head>
<style>
    body {font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; line-height: 1.6; background-color: #f9f9f9; margin: 0; padding: 0;}
.container {
    width: 100%;
    max-width: 600px;
    margin: 20px auto;
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
}
    .header {background-color: #253C6A; color: white; padding: 15px; text-align: center; font-size: 24px;}
    .content p {font-size: 16px; color: #333;}
    .footer {text-align: center; font-size: 12px; color: #888; margin-top: 20px;}
    .quotation-table {
  width: 100%;
  font-size: 13px;
  border-collapse: collapse;
  margin-top: 20px;
  margin: 0 auto; 
  padding: 10px; 
}
.quotation-table, .quotation-table th, .quotation-table td {
  border: 1px solid black!important; 
  margin-top:30px;
}

.quotation-table th, .quotation-table td {
  padding: 8px!important;
  text-align: left!important;
}  

.quotation-table .table-heading { 
    background-color: #4067B5!important; 
    color: black!important;
}

</style>
</head>
<body>
<div class='container'>
    <div class='header'>Price Quoted For Your Requirement</div>
    <div class='content'>
        <p>Dear $epcname,</p>
        <p>This is with reference to your below inquiry for equipment rental.</p>        
        <table class='quotation-table'>
            <tr>
                <th>Type</th>
                <th>Capacity</th>
                <th>Duration</th>
                <th>Shift</th>
                <th>Project Location</th>
            </tr>
            <tr>
                <td>$reqequipmenttype</td>
                <td>$equip_capacity</td>
                <td>$epcprojectduration</td>
                <td>$epcworkingshift</td>
                <td>$epcprojectdistrict-$epcprojectstate</td>
            </tr>
        </table>

        <p><strong>Rental Company:</strong> $companyname001</p>
        <p><strong>Price Quoted:</strong> ₹ $price_quote</p>
        <p><strong>Mob Charges:</strong> ₹ $offer_mob_charges</p>
        <p><strong>DeMob Charges:</strong> ₹ $offer_demob_charge</p>
        <p><strong>Equipment Make-Model-YOM:</strong> $offer_equip_make - $offer_Equip_model - $yom_equip</p>
        <br>
        <p>For full details, please reach out to us.</p>
        <p>Thank you,<br> FleetEIP Team<br> 9326178925</p>
    </div>
    <div class='footer'>
        <p>&copy; 2024 FleetEIP. All rights reserved.</p>
    </div>
</div>
</body>
</html>";                $mail->send();
session_start();
$_SESSION['view'] = 'success';
header("Location: view_quoteprice_rental.php?id=" . urlencode($req_id));
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            $_SESSION['error'] = 'Failed to insert price details';
            header("location:view_req_rentalinner.php");
        }
    }
}
?>
<style>
  <?php include "style.css" ?>
</style>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">      <link rel="icon" href="favicon.jpg" type="image/x-icon">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css"> 
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
    <script scr="autofill.js"defer></script>
    <script scr="main.js"defer></script>
    <script><?php include "autofill.js" ?></script>
        <title>Quote Price</title>
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
                <li><a href="logout.php">Log Out</a></li></ul>
            </div>
    </div>
    <?php 
        if($showError1){
            echo '<label>
            <input type="checkbox" class="alertCheckbox" autocomplete="off" />
            <div class="alert error">
              <span class="alertClose">X</span>
              <span class="alertText">Requirement Last Date Passed 
                  <br class="clear"/></span>
            </div>
          </label>';
        }
        if($showAlert){
            echo '<label>
            <input type="checkbox" class="alertCheckbox" autocomplete="off" />
            <div class="alert notice">
                <span class="alertClose">X</span>
                <span class="alertText">Success<br class="clear"/></span>
            </div>
            </label>';
        }
        
    
    ?>
    <div class="bothform_container">
    <form  method="POST" autocomplete="off" id="epcrequirementcontainerform" class="epc_req1">
        
    <div class="epc_red_div">
            <div class="headingpara"><h4>EPC Requirements</h4></div>
<?php             $currentDate = date('Y-m-d');
 ?>
            <div class="outer02">
            <div class="trial1">
            <?php
$date = date('jS M Y', strtotime($row['enquiry_posted_date']));
?>
    <input type="text" placeholder="" value="<?php echo $date; ?>" class="input02" readonly>            
    <label for="" class="placeholder2">Enquiry Posted Date</label>
            </div>
            <div class="trial1">
            <input class="input02" name="date" type="text" placeholder="" value="<?php echo date('jS M Y', strtotime($row['reqvalid'])); ?>" readonly>
                <label class="placeholder2">Valid Till</label>
                </div>

    </div>
    
            <div class="trial1">
                <input class="input02" name="" type="text" value="<?php echo $row["epc_name"] ?>" placeholder="" readonly>
                <label class="placeholder2"> EPC Company Name</label>
                </div>
                
                <div class="outer02">
                <div class="trial1" >
                <input class="input02" name="contact_person" type="text" placeholder="" value="<?php echo $row['contact_person'] ;?>" readonly>
                <label class="placeholder2"> Contact Person</label>
                </div>
                <div class="trial1" >
                <input class="input02" name="epc_number" 
    readonly 
    type="text" 
    placeholder="" 
    value="<?php echo htmlspecialchars($epcNumber); ?>">
           <label class="placeholder2"> Contact Number</label>
                </div>
                </div>
                <div class="trial1">
                <input class="input02" name="" type="text" placeholder="" value="<?php echo htmlspecialchars($EPCemail); ?>" readonly>
                <label class="placeholder2"> Contact Email</label>
                </div>
                <div class="trial1">
                    <input type="text" placeholder="" value="<?php echo $row['projectname'] ?>"  class="input02" readonly>
                    <label for="" class="placeholder2">Project Name</label>
                </div>

                <div class="outer02">
                <div class="trial1">
                <input type="text" name="project_type" placeholder="" class="input02" value="<?php echo $row["project_type"] ?>" readonly>
                <label class="placeholder2">Project Type</label>
                </div>
            <div class="trial1">
            <input class="input02" name="date" type="text" placeholder="" value="<?php echo date('jS M Y', strtotime($row['tentative_date'])); ?>" readonly>
                <label class="placeholder2"> Required From</label>
                </div>
                </div>
                <div class="outer02">
            <div class="trial1">
                <input class="input02" name="" type="text" placeholder="" value="<?php echo $row["duration_month"] . " Months" ?>" readonly>
                <label class="placeholder2">Duration </label>
            </div>

            <div class="trial1">
                <input class="input02" name="" type="text" placeholder="" value="<?php echo $row["district"] ?>" readonly>
                <label class="placeholder2">Project District</label>
            </div>
            <div class="trial1">
                <input type="text" name="" placeholder="" class="input02" value="<?php echo $row["state"] ?>" readonly>
                <label class="placeholder2"> Project State</label>
            </div>

            </div>

                <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" name="fleet_category" class="input02" value="<?php echo $row['fleet_category']; ?>" readonly>
                <label class="placeholder2">Fleet Category</label>
            </div>
            <div class="trial1">
                <input type="text" name="" class="input02" placeholder="" value="<?php echo $row["equipment_type"] ?>" readonly>
                <label class="placeholder2">Equipment Type</label>
            </div></div>
            <div class="outer02">
            <div class="trial1">
            <input type="text" name="" class="input02" placeholder="" value="<?php echo $row['equipment_capacity'] .' '. $row['unit'] ?>" readonly>
            <label class="placeholder2"> Capacity</label>
            </div>
            <div class="trial1" <?php if(empty($row['boom_combination'])) echo 'style="display:none;"'; ?>>
    <input type="text" name="boom_combination" value="<?php echo $row['boom_combination'] ?>" class="input02" placeholder="" readonly>
    <label class="placeholder2">Boom Combination</label>
</div>
            </div>


                <div class="outer02">
                    <div class="trial1">
                        <input type="text" placeholder="" value="<?php echo $row['working_shift'] ?>" class="input02" readonly>
                        <label for="" class="placeholder2">Working Shift</label>
                    </div>
                    <div class="trial1" <?php if(empty($row['engine_hour'])) echo 'style="display:none;"'; ?>>
                        <input type="text" placeholder="" value="<?php echo $row['engine_hour'] ?>" class="input02" readonly>
                        <label for="" class="placeholder2">Engine Hour</label>
                    </div>
                    <div class="trial1" <?php if(empty($row['workinghours'])) echo 'style="display:none;"'; ?>>
                        <input type="text" placeholder="" value="<?php echo $row['workinghours'] ?>" class="input02" readonly>
                        <label for="" class="placeholder2">Working Hours</label>
                    </div>
                    <div class="trial1">
                        <input type="text" placeholder="" value="<?php echo $row['working_days'] . ' Days/Month'?>" class="input02" readonly>
                        <label for="" class="placeholder2">Working Days</label>
                    </div>

                </div>

            <div class="outer02">
                <div class="trial1">
                    <input type="text" placeholder="" value="<?php echo $row['advance'] ?>" class="input02" readonly>
                    <label for="" class="placeholder2">Advance</label>
                </div>
                <div class="trial1 <?php if(empty($row['adv_for'])){echo 'hideit';} ?> ">
                    <input type="text" placeholder="" value="<?php echo $row['adv_for'] ?>" class="input02" readonly>
                    <label for="" class="placeholder2">Advance For</label>
                </div>
                <div class="trial1">
                    <input type="text" placeholder="" value="<?php echo $row['credit_term'] ?>" class="input02" readonly>
                    <label for="" class="placeholder2">Credit Term</label>
                </div>
            </div>
            <div class="outer02">
                <div class="trial1">    
                    <input type="text" placeholder="" value="<?php echo $row['fuel_scope'] ?>" class="input02" readonly>
                    <label for="" class="placeholder2">Fuel Scope</label>
                </div>
                <div class="trial1">    
                    <input type="text" placeholder="" value="<?php echo $row['adblue_scope'] ?>" class="input02" readonly>
                    <label for="" class="placeholder2">Adblue Scope</label>
                </div>
                <div class="trial1">    
                    <input type="text" placeholder="" value="<?php echo $row['accomodation_scope'] ?>" class="input02" readonly>
                    <label for="" class="placeholder2">Accomodation In</label>
                </div>
            </div>
            <div class="outer02">
                <div class="trial1">
                    <input type="text" placeholder="" value="<?php echo $row['mobilisation_recovery'] ?>" class="input02" readonly>
                    <label for="" class="placeholder2">Mobilisation Recovery</label>
                </div>
                <div class="trial1">
                    <input type="text" placeholder="" value="<?php echo $row['demobilisation_recovery'] ?>" class="input02" readonly>
                    <label for="" class="placeholder2">DeMobilisation Recovery</label>
                </div>
            </div>
            <div class="trial1">
                <textarea type="text" placeholder="" readonly name="epc_notes" class="input02" rows="4"><?php echo $row['notes'] ?></textarea>
                <label for="" class="placeholder2">EPC Notes</label>
            </div>
                
                    <input type="text" placeholder="" name="compname" class="input02" value="<?php echo $companyname001 ?>" readonly hidden>
                    
    <!-- </div> -->

                
                    <input type="text" placeholder="" name="comp_email" value="<?php echo $email ?>" class="input02" readonly hidden>
                    <!-- <label class="placeholder2">Company Email</label> -->
                <!-- </div> -->


<br>

</div>

</form>
<br><br>
<form action="view_quoteprice_rental.php?id=<?php echo $id; ?>" id="mypricecontainerform" method="POST" autocomplete="off" class="epc_req1">
<div class="epc_red_div">
<div class="headingpara"><h4>Quote Price</h4></div>
<input type="hidden" name="validdatenormal" value="<?php echo $row['reqvalid'] ?>">
<input type="hidden" name="equip_capacity" class="input02" placeholder="" value="<?php echo $row['equipment_capacity'] .' '. $row['unit'] ?>" readonly>

                <input type="hidden" name="currentdatenormal" value="<?php echo $currentDate ?>">
                <input class="input02" name="epc_email" type="hidden" placeholder="" value="<?php echo htmlspecialchars($row['epc_email']); ?>" readonly>
                <input class="input02" name="epcname" type="hidden" value="<?php echo $row["epc_name"] ?>" placeholder="" readonly>
                <input class="input02" name="district" type="hidden" placeholder="" value="<?php echo $row["district"] ?>" readonly>
                <input class="input02" name="state" type="hidden" placeholder="" value="<?php echo $row["state"] ?>" readonly>
                <input type="hidden" name="equipment_type" class="input02" placeholder="" value="<?php echo $row["equipment_type"] ?>" readonly>
                <input class="input02" name="duration_month" type="hidden" placeholder="" value="<?php echo $row["duration_month"] ?>" readonly>
                <input type="hidden" name="epcworkingshift" placeholder="" value="<?php echo $row['working_shift'] ?>" class="input02" readonly>


<div class="trial1">
        <select name="asset_code" class="input02" onchange="choose_new_equ()" id="assetcode" required>
            <option value="" disabled selected>Choose Asset Code</option>
            <option value="New Equipment">Choose New Equipment</option>
            <?php
$asset_code_selection1 = "SELECT * FROM fleet1 WHERE companyname='$companyname001' AND sub_type='" . $row['equipment_type'] . "' ORDER BY assetcode ASC";
$result_asset_code1 = mysqli_query($conn, $asset_code_selection1);

while ($row_asset_code = mysqli_fetch_assoc($result_asset_code1)) {
    echo '<option value="' . $row_asset_code['assetcode'] . '">' . $row_asset_code['assetcode'] . " (" . $row_asset_code['sub_type'] . " " . $row_asset_code['make'] . " " . $row_asset_code['model'] . ")" . '</option>';
}
?>
        </select>
    </div>

                <div class="outer02">
                <div class="trial1">
               
            <input type="text" placeholder="" name="offer_equip_make" id="make" class="input02">
            <label for="" class="placeholder2">Fleet Make</label>
        </div>

        <input type="hidden" name="req_id" class="input02" placeholder="" value="<?php echo $row["id"] ?>" readonly  >
        <input class="input02" name="EPCcomp_name" type="hidden" value="<?php echo $row["epc_name"] ?>" placeholder="" readonly>


                <div class="trial1">
                    <input type="text" id="model" placeholder="" name="offer_Equip_model" class="input02">
                    <label for="" class="placeholder2"> Model</label>
                </div>
                <div class="trial1">
                <input type="text" placeholder="" name="yom_equip" id="yom" class="input02">
                <label for="" class="placeholder2">YoM</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="equipmentcapacity" id="capacity" class="input02">
                <label for="" class="placeholder2">Capacity</label>
            </div>
            <div class="trial1 hideit">
                <input type="hidden" placeholder="" name="equipmentunit" id="unit" class="input02">
                <label for="" class="placeholder2">Unit</label>
            </div>

        
        </div> 
        <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" id="boomlength" name="boom" class="input02">
                <label for="" class="placeholder2">Boom</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" id="jiblength" name="jib" class="input02">
                <label for="" class="placeholder2">Jib</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" id="luffinglength" name="luffing" class="input02">
                <label for="" class="placeholder2">Luffing</label>
            </div>

        </div>

                <div class="outer02">
                    <select name="offer_assembly" onchange="assemblyscope()" id="assemblyrequireddd" class="input02">
                        <option value=""disabled selected>Equipment Assembly Required?</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                <div class="trial1" id="assemblyinscopeof">
                    <select name="offer_assembly_Scope" id="" class="input02">
                        <option value=""disabled selected>In Scope Of?</option>
                        <option value="Client">Client</option>
                        <option value="Rental Company">Rental Company</option>
                    </select>
                </div>
            </div>
                <div class="outer02">
                <div class="trial1">
                <select class="input02" name="offer_location" class="input02">
                    <option value=""disabled selected>Equi Location</option>
    <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
    <option value="Andhra Pradesh">Andhra Pradesh</option>
    <option value="Arunachal Pradesh">Arunachal Pradesh</option>
    <option value="Assam">Assam</option>
    <option value="Bihar">Bihar</option>
    <option value="Chandigarh">Chandigarh</option>
    <option value="Chhattisgarh">Chhattisgarh</option>
    <option value="Dadra and Nagar Haveli">Dadra and Nagar Haveli</option>
    <option value="Daman and Diu">Daman and Diu</option>
    <option value="Delhi">Delhi</option>
    <option value="Goa">Goa</option>
    <option value="Gujarat">Gujarat</option>
    <option value="Haryana">Haryana</option>
    <option value="Himachal Pradesh">Himachal Pradesh</option>
    <option value="Jammu and Kashmir">Jammu and Kashmir</option>
    <option value="Jharkhand">Jharkhand</option>
    <option value="Karnataka">Karnataka</option>
    <option value="Kerala">Kerala</option>
    <option value="Ladakh">Ladakh</option>
    <option value="Lakshadweep">Lakshadweep</option>
    <option value="Madhya Pradesh">Madhya Pradesh</option>
    <option value="Maharashtra">Maharashtra</option>
    <option value="Manipur">Manipur</option>
    <option value="Meghalaya">Meghalaya</option>
    <option value="Mizoram">Mizoram</option>
    <option value="Nagaland">Nagaland</option>
    <option value="Odisha">Odisha</option>
    <option value="Puducherry">Puducherry</option>
    <option value="Punjab">Punjab</option>
    <option value="Rajasthan">Rajasthan</option>
    <option value="Sikkim">Sikkim</option>
    <option value="Tamil Nadu">Tamil Nadu</option>
    <option value="Telangana">Telangana</option>
    <option value="Tripura">Tripura</option>
    <option value="Uttar Pradesh">Uttar Pradesh</option>
    <option value="Uttarakhand">Uttarakhand</option>
    <option value="West Bengal">West Bengal</option>
    </select>
            </div>
                <div class="trial1">
                    <input type="text" placeholder="" name="offer_district" class="input02">
                    <label for="" class="placeholder2">Current District  </label>
                </div>
                <div class="trial1">
                    <input type="date" placeholder="" name="offer_Available" class="input02">
                    <label for="" class="placeholder2">Available From</label>
                </div>
                </div>
                <div class="outer02">
                    <select name="" onchange="notacceptedfunction()" id="credittermacceptance" class="input02">
                        <option value=""disabled selected>Credit Term : <?php echo $row['credit_term'] ?> Accepted? </option>
                        <option value="Yes">Yes Accepted</option>
                        <option value="No">Not Accepted</option>
                    </select>
                <div class="trial1" id="creditnotaccepted">
                    <select name="offer_payment" id="" class="input02">
                        <option value=""disabled selected>Payment Conditions</option>
                        <option value="15 Days">15 Days after bill submission</option>
                        <option value="30 Days">30 Days after bill submission</option>
                        <option value="45 Days">45 Days after bill submission</option>
                        <option value="60 Days">60 Days after bill submission</option>
                    </select>
                </div> 
                </div>
                <div class="outer02">
                <select name="" id="advanceacceptance" onchange="advancenotaccepted()" class="input02">
                <option value="" disabled selected>Advance <?php echo $row['advance'] . (!empty($row['adv_for']) ? ' (' . $row['adv_for'] . ')' : ''); ?> Accepted?</option>
                <option value="Yes">Yes Accepted</option>
                <option value="No">Not Accepted</option>

                </select>
                <select name="" id="advancefordd" class="input02">
                    <option value=""disabled selected>Advance For</option>
                    <option value="Transportation">Transportation</option>
                <option value="Rental">Rental</option>
                <option value="Rental + Transportation">Rental + Transportation</option>

                </select>
                </div>
                <input type="text" value="<?php echo $companyname001 ?>" id="comp_name_trial" hidden>

    <div class="outer02">
                <div class="trial1">
                    <input type="text" placeholder="" name="price_quoted" value="<?php if(!empty($row2['price_quoted'])){ echo $row2['price_quoted'];}  ?>"<?php if(!empty($row2['price_quoted'])){ echo 'readonly';} ?> class="input02" required>
                    <label class="placeholder2">Quote Price</label>
                </div>
            
                <div class="trial1">
                    <input type="text" placeholder="" name="offer_mob_charges"  class="input02" >
                    <label class="placeholder2">Mob Charges</label>
                </div> 
                
                <div class="trial1">
                    <input type="text" placeholder="" name="offer_demob_charge"  class="input02" >
                    <label class="placeholder2">De-Mob</label>
                </div></div>
                <div class="outer02">
                <div class="trial1">
                <input type="text" placeholder="" name="offer_contact_person_name" class="input02">
                <label class="placeholder2">Contact Person</label>
                </div>
                <div class="trial1">
                <input type="text" placeholder="" name="comp_number" class="input02">
                <label class="placeholder2">Mobile Number</label>
                </div>
            </div>
                <div class="trial1">
                <input type="text" placeholder="" name="offer_email"  class="input02">
                <label class="placeholder2">Contact Email </label>
                </div>
                <div class="trial1">
                <textarea type="text" name="rental_notes" class="input02" placeholder=""></textarea>
                <label for="" class="placeholder2">Notes</label>
                </div>
                <button class="epc-button" id="submitBtn" type="submit">Quote </button>
                <br><br>
    </form>
    <br>
    </div>
    <br><br>
<script>
            // Hide the submit button if the comp_number input field is readonly
            if (document.querySelector('[name="price_quoted"]').readOnly) {
                document.getElementById('mypricecontainerform').style.display = 'none';
                document.getElementById('epcrequirementcontainerform').style.width = '45%';
            }



            function assemblyscope() {
    const assemblyrequireddd = document.getElementById("assemblyrequireddd");
    const assemblyinscopeof = document.getElementById("assemblyinscopeof");

    if (assemblyrequireddd.value === 'Yes') {
        assemblyinscopeof.style.display = 'flex';
    } else {
        assemblyinscopeof.style.display = 'none';
    }
}

function notacceptedfunction(){
    const credittermacceptance=document.getElementById("credittermacceptance");
    const creditnotaccepted=document.getElementById("creditnotaccepted");
    if(credittermacceptance.value==='No'){
        creditnotaccepted.style.display='block';
    }
    else{
        creditnotaccepted.style.display='none';
 
    }
}

function advancenotaccepted(){
    const advanceacceptance=document.getElementById("advanceacceptance");
    const advancefordd=document.getElementById("advancefordd");

    if(advanceacceptance.value==='No'){
        advancefordd.style.display='block';
    }
    else{
        advancefordd.style.display='none';

    }
}

        </script>
</body>
</html>