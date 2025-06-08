<?php
include "partials/_dbconnect.php";
session_start();
$showError=false;
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
$sql_team="SELECT * FROM `team_members` where company_name='$companyname001' and department='marketing' or company_name='$companyname001' and department='Management'";
$result_team=mysqli_query($conn,$sql_team);

$sql_max_ref_no = "SELECT MAX(ref_no) AS max_ref_no FROM `logistic_quotation_generated` WHERE companyname = '$companyname001'";
$result_max_ref_no = mysqli_query($conn, $sql_max_ref_no);
$row_max_ref_no = mysqli_fetch_assoc($result_max_ref_no);
$next_ref_no = ($row_max_ref_no['max_ref_no'] === null) ? 1 : $row_max_ref_no['max_ref_no'] + 1;


if (isset($_POST['quotation_logistic'])) {
    $date = $_POST['date'];
    $to = $_POST['to'];
    $salutation_dd = $_POST['salutation_dd'];
    $contact_person = $_POST['contact_person'];
    $to_address = $_POST['to_address'];
    $contact_number = $_POST['contact_number'];
    $email_id = $_POST['email_id'];
    $dimension_unit = $_POST['dimension_unit'];
    $weight_unit = $_POST['weight_unit'];
    $type1 = $_POST['type1'];
    $material1 = $_POST['material1'];
    $length1 = $_POST['length1'];
    $width1 = $_POST['width1'];
    $height1 = $_POST['height1'];
    $weight1 = $_POST['weight1'];
    $freight1 = $_POST['freight1'];
    $rate1 = $_POST['rate1'];

    $type2 = $_POST['type2'] ?? '';
    $material2 = $_POST['material2'];
    $length2 = $_POST['length2'];
    $width2 = $_POST['width2'];
    $height2 = $_POST['height2'];
    $weight2 = $_POST['weight2'];
    $freight2 = $_POST['freight2'];
    $rate2 = $_POST['rate2'] ?? '';

    $type3 = $_POST['type3'] ?? '';
    $material3 = $_POST['material3'];
    $length3 = $_POST['length3'];
    $width3 = $_POST['width3'];
    $height3 = $_POST['height3'];
    $weight3 = $_POST['weight3'];
    $freight3 = $_POST['freight3'];
    $rate3 = $_POST['rate3'] ?? '';

    $type4 = $_POST['type4'] ?? '';
    $material4 = $_POST['material4'];
    $length4 = $_POST['length4'];
    $width4 = $_POST['width4'];
    $height4 = $_POST['height4'];
    $weight4 = $_POST['weight4'];
    $freight4 = $_POST['freight4'];
    $rate4 = $_POST['rate4'] ?? '';

    $senders_name =$_POST['senders_name'];
    $senders_number =$_POST['senders_number'];
    $senders_email =$_POST['senders_email'];

    $risk=$_POST['risk'];
    $insaurance=$_POST['insaurance'];
    $loading=$_POST['loading'];
    $detention=$_POST['detention'];
    $increaseprice=$_POST['increaseprice'];
    $phatak=$_POST['phatak'];
    $phatakcost=$_POST['phatakcost'];
    $extratools=$_POST['extratools'];
    $toolscost=$_POST['toolscost'];
    $offervalidity=$_POST['offervalidity'];
    $adv=$_POST['adv'];
    $balance=$_POST['balance'];
    $rate_adjustment=$_POST['rate_adjustment'];
    $taxes=$_POST['taxes'];

    $sql = "INSERT INTO `logistic_quotation_generated` (
        `companyname`, `date`, `to_person`, `salutation`, `contact_person`, `to_address`, 
        `contact_number`, `email`, `dimension_unit`, `weight_unit`, `trailor_type1`, 
        `material1`, `length1`, `width1`, `height1`, `weight1`, `freight1`, 
        `ratecondition1`, `material2`, `length2`, `width2`, `height2`, 
        `weight2`, `freight2`, `ratecondition2`, `material3`, `length3`, 
        `width3`, `height3`, `weight3`, `freight3`, `ratecondition3`, 
        `material4`, `length4`, `width4`, `height4`, `weight4`, 
        `freight4`, `ratecondition4`, `trailor_type2`, `trailor_type3`, `trailor_type4`, 
        `senders_name`, `senders_number`, `senders_email`, `ref_no`,`risk`, `insaurance`, `loading`, `detention`, `freight_change`, `obstacle`, `supporting`, `offer`, `adv`, `rate_adjustment`, `taxes`, `balance`,`tool_cost`,`phatak_cost`
    ) VALUES (
        '$companyname001', '$date', '$to', '$salutation_dd', '$contact_person', '$to_address', 
        '$contact_number', '$email_id', '$dimension_unit', '$weight_unit', '$type1', 
        '$material1', '$length1', '$width1', '$height1', '$weight1', '$freight1', 
        '$rate1', '$material2', '$length2', '$width2', '$height2', 
        '$weight2', '$freight2', '$rate2', '$material3', '$length3', 
        '$width3', '$height3', '$weight3', '$freight3', '$rate3', 
        '$material4', '$length4', '$width4', '$height4', '$weight4', 
        '$freight4', '$rate4', '$type2', '$type3', '$type4', 
        '$senders_name', '$senders_number', '$senders_email', '$next_ref_no', '$risk','$insaurance','$loading','$detention','$increaseprice','$phatak','$extratools','$offervalidity','$adv','$rate_adjustment','$taxes','$balance','$toolscost','$phatakcost'
    )";
    
    $result = mysqli_query($conn, $sql);
    if ($result) {
        session_start();
        $_SESSION['success'] = "success";
        header("Location: logisticsquotation.php");
        exit(); // Ensure no further code is executed
    } else { 
       $showError=true;
    }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>

    <script src="autofill_senders_name.js"defer></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <div class="navbar1">
        <div class="logo_fleet">
            <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='logisticsdashboard.php'">
        </div>
        <div class="iconcontainer">
            <ul>
                <li><a href="logisticsdashboard.php">Dashboard</a></li>
                <!-- <li><a href="news/">News</a></li> -->
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </div>
    </div>
    <?php
if ($showError) {
    echo '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert error">
      <span class="alertClose">X</span>
      <span class="alertText">Something Went Wrong
          <br class="clear"/></span>
    </div>
  </label>';
}
?>
    <form action="generatelogisticsquotation.php" method="POST" class="logiquotation" autocomplete="off">
        <div class="logiquotation_container">
            <p id="generate_quotation_headinglogi">Generate Quotation</p>
            <div class="trial1">
<input type="date" name="date" value="<?php echo date('Y-m-d'); ?>" class="input02">
                <label for="" class="placeholder2">Date</label>
            </div>
            <div class="outer02">
                <div class="trial1">
                    <input type="text" placeholder="" name="to" class="input02" required>
                    <label for="" class="placeholder2">To</label>
                </div>
                <div class="trial1" id="salute_dd">
                    <select name="salutation_dd" class="input02" required>
                        <option value="Mr">Mr</option>
                        <option value="Ms">Ms</option>
                    </select>
                </div>
                <div class="trial1">
                    <input type="text" placeholder="" name="contact_person" class="input02" required>
                    <label for="" class="placeholder2">Contact Person</label>
                </div>
            </div>
            <input type="text" id="logistics_need_rental" value="<?php echo $companyname001 ?>" hidden>
            <div class="outer02">
                <div class="trial1">
                    <input type="text" placeholder="" name="to_address" class="input02" required>
                    <label for="" class="placeholder2">To Address</label>
                </div>
                <div class="trial1" id="contact_number1">
                    <input type="text" placeholder="" name="contact_number" class="input02" required>
                    <label for="" class="placeholder2">Contact Number</label>
                </div>
                <div class="trial1">
                    <input type="text" placeholder="" name="email_id" class="input02" required>
                    <label for="" class="placeholder2">Email Id</label>
                </div>
            </div>
            <div class="outer02">
                <div class="trial1">
                    <select name="dimension_unit" id="" class="input02">
                        <option value="" disabled selected>Dimensions Unit</option>
                        <option value="cm">cm</option>
                        <option value="inches">inches</option>
                        <option value="feet">feet</option>
                    </select>
                </div>
                <div class="trial1">
                    <select name="weight_unit" id="" class="input02">
                        <option value="" disabled selected>Weight Unit</option>
                        <option value="kgs">kgs</option>
                        <option value="ton">ton</option>
                    </select>
                </div>
                <div class="trial1">
                    <select name="type1" id="" class="input02">
                        <option value="" disabled selected>Trailor Type</option>
                        <option value="Axle">Axle</option>
                        <option value="LBT">LBT</option>
                        <option value="SLBT">SLBT</option>
                        <option value="HBT">HBT</option>
                        <option value="Lorry">Lorry</option>
                    </select>
                </div>
            </div>
            <div class="outer02">
                <div class="trial1">
                    <input type="text" name="material1" placeholder="" class="input02">
                    <label for="" class="placeholder2">Material Detail</label>
                </div>
                <div class="trial1 sizereduced">
                    <input type="number" name="length1" placeholder="" class="input02">
                    <label for="" class="placeholder2">Length</label>
                </div>
                <div class="trial1 sizereduced">
                    <input type="number" name="width1" placeholder="" class="input02">
                    <label for="" class="placeholder2">Width</label>
                </div>
                <div class="trial1 sizereduced">
                    <input type="number" name="height1" placeholder="" class="input02">
                    <label for="" class="placeholder2">Height</label>
                </div>
                <div class="trial1 sizereduced">
                    <input type="number" name="weight1" placeholder="" class="input02">
                    <label for="" class="placeholder2">Weight</label>
                </div>
            </div>
            <div class="outer02">
                <div class="trial1">
                    <input type="number" name="freight1" placeholder="" class="input02">
                    <label for="" class="placeholder2">Freight Charges</label>
                </div>
                <div class="trial1">
                    <select name="rate1" id="" class="input02">
                        <option value="" disabled selected>Rate Condition</option>
                        <option value="With RTO">With RTO</option>
                        <option value="Without RTO">Without RTO</option>
                        <option value="As Per Receipt From RTO">As Per Receipt From RTO</option>
                    </select>
                </div>
            </div>
            <div class="addbuttonicon" id="firstadd">
                <i onclick="secondtrailor()" class="bi bi-plus-circle">Add Another Equipment</i>
            </div>

            <div class="secondvechiclequotecontainer" id="seconddatacontainer">
                <a>Second Vehicle Quotation</a>
                <div class="outer02">
                    <div class="trial1">
                        <input type="text" name="material2" placeholder="" class="input02">
                        <label for="" class="placeholder2">Material Detail</label>
                    </div>
                    <div class="trial1 sizereduced">
                        <input type="number" name="length2" placeholder="" class="input02">
                        <label for="" class="placeholder2">Length</label>
                    </div>
                    <div class="trial1 sizereduced">
                        <input type="number" name="width2" placeholder="" class="input02">
                        <label for="" class="placeholder2">Width</label>
                    </div>
                    <div class="trial1 sizereduced">
                        <input type="number" name="height2" placeholder="" class="input02">
                        <label for="" class="placeholder2">Height</label>
                    </div>
                    <div class="trial1 sizereduced">
                        <input type="number" name="weight2" placeholder="" class="input02">
                        <label for="" class="placeholder2">Weight</label>
                    </div>
                </div>
                <div class="outer02">
                    <div class="trial1">
                        <select name="trailor2" id="" class="input02">
                            <option value="" disabled selected>Trailor Type</option>
                            <option value="Axle">Axle</option>
                            <option value="LBT">LBT</option>
                            <option value="SLBT">SLBT</option>
                            <option value="HBT">HBT</option>
                            <option value="Lorry">Lorry</option>
                        </select>
                    </div>
                    <div class="trial1">
                        <input type="number" name="freight2" placeholder="" class="input02">
                        <label for="" class="placeholder2">Freight Charges</label>
                    </div>
                    <div class="trial1">
                        <select name="rate2" id="" class="input02">
                            <option value="" disabled selected>Rate Condition</option>
                            <option value="With RTO">With RTO</option>
                            <option value="Without RTO">Without RTO</option>
                            <option value="As Per Receipt From RTO">As Per Receipt From RTO</option>
                        </select>
                    </div>
                </div>
                <div class="addbuttonicon" id="secondadd">
                        <i onclick="addAnotherEquipment()" class="bi bi-plus-circle">Add Another Equipment</i>
                    </div>

            </div>

<div class="secondvechiclequotecontainer" id="thirdvehcile_quotation">
    <a>Third Vehicle Quotation</a>
    <div class="outer02">
        <div class="trial1">
            <input type="text" name="material3" placeholder="" class="input02">
            <label for="" class="placeholder2">Material Detail</label>
        </div>
        <div class="trial1 sizereduced">
            <input type="number" name="length3" placeholder="" class="input02 ">
            <label for="" class="placeholder2">Length</label>
        </div>
        <div class="trial1 sizereduced">
            <input type="number" name="width3" placeholder="" class="input02">
            <label for="" class="placeholder2">Width</label>
        </div>
        <div class="trial1 sizereduced">
            <input type="number" name="height3" placeholder="" class="input02">
            <label for="" class="placeholder2">Height</label>
        </div>
        <div class="trial1 sizereduced">
            <input type="number" name="weight3" placeholder="" class="input02">
            <label for="" class="placeholder2">Weight</label>
        </div>
        
    </div>
    

<div class="outer02">
<div class="trial1">
            <select name="trailor3" id="" class="input02">
                <option value=""disabled selected>Trailor Type</option>
                <option value="Axle">Axle</option>
                <option value="LBT">LBT</option>
                <option value="SLBT">SLBT</option>
                <option value="HBT">HBT</option>
                <option value="Lorry">Lorry</option>

            </select>
        </div>

    <div class="trial1">
        <input type="number" name="freight3" placeholder="" class="input02">
        <label for="" class="placeholder2">Freight Charges</label>
    </div>
    <div class="trial1">
    <select name="rate3" id="" class="input02">
        <option value=""disabled selected>Rate Condition</option>
        <option value="With RTO">With RTO</option>
                    <option value="Without RTO">Without RTO</option>
                    <option value="As Per Recipt From RTO">As Per Recipt From RTO</option>

    </select>

</div>

    </div> 
    <div class="addbuttonicon" id="fouthadd"><i onclick="fourthequipment()"  class="bi bi-plus-circle">Add Another Equipment</i></div>

    </div>
<div class="secondvechiclequotecontainer" id="fourthequipmentcontainer">
    <a>Fourth Equipment Quotation </a>
    <div class="outer02">
        <div class="trial1">
            <input type="text" placeholder="" name="material4" class="input02">
            <label for="" class="placeholder2">Material Detail</label>
        </div>
        <div class="trial1 sizereduced">
            <input type="number" placeholder="" name="length4" class="input02 ">
            <label for="" class="placeholder2">Length</label>
        </div>
        <div class="trial1 sizereduced">
            <input type="number" placeholder="" name="width4" class="input02">
            <label for="" class="placeholder2">Width</label>
        </div>
        <div class="trial1 sizereduced">
            <input type="number" placeholder="" name="height4" class="input02">
            <label for="" class="placeholder2">Height</label>
        </div>
        <div class="trial1 sizereduced">
            <input type="number" placeholder="" name="weight4" class="input02">
            <label for="" class="placeholder2">Weight</label>
        </div>
        
    </div>
    

<div class="outer02">
<div class="trial1">
            <select name="trailor4" id="" class="input02">
                <option value=""disabled selected>Trailor Type</option>
                <option value="Axle">Axle</option>
                <option value="LBT">LBT</option>
                <option value="SLBT">SLBT</option>
                <option value="HBT">HBT</option>
                <option value="Lorry">Lorry</option>

            </select>
        </div>

    <div class="trial1">
        <input type="number" name="freight4" placeholder="" class="input02">
        <label for="" class="placeholder2">Freight Charges</label>
    </div>
    <div class="trial1">
    <select name="rate4" id="" class="input02">
        <option value=""disabled selected>Rate Condition</option>
        <option value="With RTO">With RTO</option>
                    <option value="Without RTO">Without RTO</option>
                    <option value="As Per Recipt From RTO">As Per Recipt From RTO</option>

    </select>

</div>

    </div>
    </div>
    <a href="complete_profile_new.php">If Name Not Available In The Option Add Team Members First</a>

    <div class="outer02">
        <div class="trial1">
            <select name="senders_name" id="contactperson_logistic_need" class="input02">
                <option value=""disabled selected>Senders Name</option>
            <?php while($row=mysqli_fetch_assoc($result_team)){?>
                <option value="<?php echo $row['name'] ?>"><?php echo $row['name'] ?></option>



          <?php  } ?>
            </select>
        </div>
        <div class="trial1">
            <input type="text"  id="contact_person_number" name="senders_number" placeholder="" class="input02">
            <label for="" class="placeholder2">Number</label>
        </div>
        <div class="trial1">
            <input type="text" id="contact_person_email" name="senders_email" placeholder="" class="input02">
            <label for="" class="placeholder2">Email</label>
        </div>
    </div>
    <div class="terms_container012">
    <p class="heading_terms">Terms & Conditions :</p>
    <p class="terms_condition"><strong>1.Transportation Liability :</strong>Transportation shall be done by us on <select name="risk" id="">
        <option value="owners risk">owners risk</option>
        <option value="our own risk">our own risk</option>
    </select> as per terms & conditions laid down on our
    consignment note</p>
    <p class="terms_condition"><strong>2.Insurance Liability :</strong>Transit Insurance is in <select name="insaurance" id="">
        <option value="consignor / consignee scope">consignor / consignee scope</option>
        <option value="logistic Company scope">logistic Company scope</option>
    </select></p>
    <p class="terms_condition"><strong>3.Scope of Services: Loading and Unloading Charges :</strong>Loading & Unloading charges is in <select name="loading" id="">
        <option value="consignor / consignee scope">consignor / consignee scope</option>
        <option value="logistic Company scope">logistic Company scope</option>
    </select></p>
<p class="terms_condition"><strong>4.Detention :</strong>Detention free period at loading /unloading point is <select name="detention" id="">
        <option value="3 hours">3 hours</option>
        <option value="6 hours">6 hours</option>
        <option value="9 hours">9 hours</option>
        <option value="12 hours">12 hours</option>
        <option value="24 hours">24 hours</option>
    </select> after that detention charges will be imposed .</p>

<p class="terms_condition"><strong>5.Freight Rate Adjustment  :</strong>Our offer is based on the prevailing prices of diesel, in case of any increase in price of diesel, freight
rates shall increase by <select name="increaseprice" id="">
        <option value="0.5%">0.5%</option>
        <option value="1%">1%</option>
        <option value="2%">2%</option>
        <!-- <option value="12 hours">12 hours</option>
        <option value="24 hours">24 hours</option> -->
    </select> with every 1% increase in prices of diesel.</p>


<p class="terms_condition"> <strong>6.Obstacles Removal Responsibility :</strong>Removal of any phatak, wires or any other obstacles from road shall be in <select name="phatak" id="">
<option value="client scope">client scope</option>
<option value="our scope">our scope</option>


</select> at <select name="phatakcost" id="">
    <option value="no additional cost">no addditional cost</option>
    <option value="addditional cost">addditional cost</option>
</select></p>


<p class="terms_condition"><strong>7.Supporting Equipment Scope :</strong>In case extra wooden slippers , chain or any other supporting equipment to  be required will be in 
<select name="extratools" id="">
<option value="client scope">client scope</option>
<option value="our scope">our scope</option>
</select>at 

<select name="toolscost" id="">
    <option value="no additional cost">no addditional cost</option>
    <option value="addditional cost">addditional cost</option>
</select></p>
<p class="terms_condition"><strong>8.Offer Validity :</strong>Proposed offer is valid for <select name="offervalidity" id="">
    <option value="3 days">3 days</option>
    <option value="5 days">5 days</option>
    <option value="7 days">7 days</option>
    <option value="15 days">15 days</option>
    <option value="30 days">30 days</option>
</select></p>
<p class="terms_condition"><strong>9.Advance Payment :</strong><select name="adv" id="">
    <option value="30%">30%</option>
    <option value="50%">50%</option>
    <option value="60%">60%</option>
    <option value="80%">80%</option>
    <option value="90%">90%</option>
</select>Advance payment at time of Loading & Balance Payment within 
<select name="balance" id="">
    <option value="7 days">7 Days</option>
    <option value="15 days">15 days</option>
    <option value="30 days">30 days</option>
    <option value="45 days">45 days</option>
    <option value="60 days">60 days</option>
</select>of our bill submission.In case of delay/refusal in clearing our charges, interest at 18% P.a. shall be claimed and needs to be paid by client.
</p>
<!-- <div class="terms_condition"  name="rate_adjustment" contenteditable="true"><strong>10.Rate Adjustment :</strong>Our offer is based on dimension and weights of packages specified in your enquiry and In case
any changes in dimension and weights of the packages, we reserve the right to re-negotiate the
rates / terms of the offer.</div> -->

<p class="terms_condition">
    <strong>10.Rate Adjustment :</strong>
<textarea name="rate_adjustment" id="" cols="30" rows="3" class="terms_textarea" >Our offer is based on dimension and weights of packages specified in your enquiry and In case
any changes in dimension and weights of the packages, we reserve the right to re-negotiate the
rates / terms of the offer. </textarea>
</p>

<p class="terms_condition">
    <strong>11.Taxes :</strong>
<textarea name="taxes" id="" cols="30" rows="2" class="terms_textarea" >GST or any other taxes shall be directly paid by you to the concerned Department without any
liability to us. </textarea>
</p>


<button class="quotation_submit" name="quotation_logistic" type="submit">Submit</button>
<br>
 </div>
        
    </form>

    <script src="main.js" defer></script>
</body>
</html>
