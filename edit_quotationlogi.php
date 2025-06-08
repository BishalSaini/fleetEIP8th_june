<?php 
include "partials/_dbconnect.php";
session_start();
$companyname001=$_SESSION['companyname'];
$id=$_GET['quote_id'];
$showError=false;

$sql="SELECT * FROM `logistic_quotation_generated` where id='$id'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);

if(isset($_SESSION['error'])){
    echo 'error';
    unset($_SESSION['error']);
}
?>

<?php
if(isset($_POST['edit_logiquotation'])){
    $editidlogi=$_POST['editidlogi'];
    $ref_no=$_POST['ref_no'];
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


    $sqledit="UPDATE `logistic_quotation_generated` SET `ref_no`='$ref_no',`companyname`='$companyname001',
    `date`='$date',`to_person`='$to',`salutation`='$salutation_dd',`contact_person`='$contact_person',`to_address`='$to_address',
    `contact_number`='$contact_number',`email`='$email_id',`dimension_unit`='$dimension_unit',`weight_unit`='$weight_unit',`trailor_type1`='$type1',
    `material1`='$material1',`length1`='$length1',`width1`='$width1',`height1`='$height1',`weight1`='$weight1',
    `freight1`='$freight1',`ratecondition1`='$rate1',`material2`='$material2',`length2`='$length2',`width2`='$width2',
    `height2`='$height2',`weight2`='$weight2',`freight2`='$freight2',`ratecondition2`='$rate2',`material3`='$material3',
    `length3`='$length3',`width3`='$width3',`height3`='$height3',`freight3`='$freight3',`ratecondition3`='$rate3',
    `material4`='$material4',`length4`='$length4',`width4`='$width4',`height4`='$height4',`weight4`='$weight4',`freight4`='$freight4',
    `ratecondition4`='$rate4',`trailor_type2`='$type2',`trailor_type3`='$type3',`trailor_type4`='$type4',`weight3`='$weight3',
    `senders_name`='$senders_name',`senders_number`='$senders_number',`senders_email`='$senders_email',`risk`='$risk',`insaurance`='$insaurance',
    `loading`='$loading',`detention`='$detention',`freight_change`='$increaseprice',`obstacle`='$phatak',`supporting`='$extratools',`offer`='$offervalidity',
    `adv`='$adv',`rate_adjustment`='$rate_adjustment',`taxes`='$taxes',`balance`='$balance',`tool_cost`='$toolscost',`phatak_cost`='$phatakcost' WHERE id='$editidlogi'";
    $result1=mysqli_query($conn,$sqledit);
    if($result1){
        session_start();
        $_SESSION['success']='success';
        header("Location:logisticsquotation.php");
        exit();
    }
    else{
        $_SESSION['error']='success';
        header("Location: edit_quotationlogi.php?quote_id=" . urlencode($editidlogi)); 
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
    <form action="edit_quotationlogi.php" method="POST" class="logiquotation" autocomplete="off">
        <div class="logiquotation_container">
            <p id="generate_quotation_headinglogi">Edit Quotation</p>
            <div class="outer02">
            <div class="trial1">
<input type="date" name="date" value="<?php echo $row['date'] ?>" class="input02">
                <label for="" class="placeholder2">Date</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="ref_no" value="<?php echo $row['ref_no'] ?>" class="input02" readonly>
                <label for="" class="placeholder2">Ref No</label>
            </div>
            </div>
            <div class="outer02">
                <div class="trial1">
                    <input type="text" value="<?php echo $row['to_person'] ?>" placeholder="" name="to" class="input02" required>
                    <label for="" class="placeholder2">To</label>
                </div>
                <div class="trial1" id="salute_dd">
                    <select name="salutation_dd" class="input02" required>
                        <option <?php if($row['salutation']==='Mr'){ echo 'selected';} ?> value="Mr">Mr</option>
                        <option <?php if($row['salutation']==='Ms'){ echo 'selected';} ?> value="Ms">Ms</option>
                    </select>
                </div>
                <div class="trial1">
                    <input type="text" value="<?php echo $row['contact_person'] ?>" placeholder="" name="contact_person" class="input02" required>
                    <label for="" class="placeholder2">Contact Person</label>
                </div>
            </div>
            <input type="text" id="logistics_need_rental" value="<?php echo $companyname001 ?>" hidden>
            <div class="outer02">
                <div class="trial1">
                    <input type="text" placeholder="" value="<?php echo $row['to_address'] ?>" name="to_address" class="input02" required>
                    <label for="" class="placeholder2">To Address</label>
                </div>
                <div class="trial1" id="contact_number1">
                    <input type="text" placeholder="" value="<?php echo $row['contact_number'] ?>" name="contact_number" class="input02" required>
                    <label for="" class="placeholder2">Contact Number</label>
                </div>
                <div class="trial1">
                    <input type="text" placeholder="" value="<?php echo $row['email'] ?>" name="email_id" class="input02" required>
                    <label for="" class="placeholder2">Email Id</label>
                </div>
            </div>
            <input type="text" name="editidlogi" value="<?php echo $id ?>" hidden>
            <div class="outer02">
                <div class="trial1">
                    <select name="dimension_unit" id="" class="input02">
                        <option value="" disabled selected>Dimensions Unit</option>
                        <option <?php if($row['dimension_unit']==='cm'){ echo 'selected';} ?> value="cm">cm</option>
                        <option <?php if($row['dimension_unit']==='inches'){ echo 'selected';} ?> value="inches">inches</option>
                        <option <?php if($row['dimension_unit']==='feet'){ echo 'selected';} ?> value="feet">feet</option>
                    </select>
                </div>
                <div class="trial1">
                    <select name="weight_unit" id="" class="input02">
                        <option value="" disabled selected>Weight Unit</option>
                        <option <?php if($row['weight_unit']==='kgs'){ echo 'selected';} ?> value="kgs">kgs</option>
                        <option <?php if($row['weight_unit']==='ton'){ echo 'selected';} ?> value="ton">ton</option>
                    </select>
                </div>
                <div class="trial1">
                    <select name="type1" id="" class="input02">
                        <option value="" disabled selected>Trailor Type</option>
                        <option <?php if($row['trailor_type1']==='Axle'){ echo 'selected';} ?> value="Axle">Axle</option>
                        <option <?php if($row['trailor_type1']==='LBT'){ echo 'selected';} ?> value="LBT">LBT</option>
                        <option <?php if($row['trailor_type1']==='SLBT'){ echo 'selected';} ?> value="SLBT">SLBT</option>
                        <option <?php if($row['trailor_type1']==='HBT'){ echo 'selected';} ?> value="HBT">HBT</option>
                        <option <?php if($row['trailor_type1']==='Lorry'){ echo 'selected';} ?> value="Lorry">Lorry</option>
                    </select>
                </div>
            </div>
            <div class="outer02">
                <div class="trial1">
                    <input type="text" value="<?php echo $row['material1'] ?>" name="material1" placeholder="" class="input02">
                    <label for="" class="placeholder2">Material Detail</label>
                </div>
                <div class="trial1 sizereduced">
                    <input type="number" name="length1" value="<?php echo $row['length1'] ?>" placeholder="" class="input02">
                    <label for="" class="placeholder2">Length</label>
                </div>
                <div class="trial1 sizereduced">
                    <input type="number" name="width1" placeholder="" value="<?php echo $row['width1'] ?>" class="input02">
                    <label for="" class="placeholder2">Width</label>
                </div>
                <div class="trial1 sizereduced">
                    <input type="number" name="height1" placeholder="" value="<?php echo $row['height1'] ?>" class="input02">
                    <label for="" class="placeholder2">Height</label>
                </div>
                <div class="trial1 sizereduced">
                    <input type="number" name="weight1" placeholder="" value="<?php echo $row['weight1'] ?>" class="input02">
                    <label for="" class="placeholder2">Weight</label>
                </div>
            </div>
            <div class="outer02">
                <div class="trial1">
                    <input type="number" name="freight1" placeholder="" value="<?php echo $row['freight1'] ?>" class="input02">
                    <label for="" class="placeholder2">Freight Charges</label>
                </div>
                <div class="trial1">
                <select name="rate1" class="input02">
    <option value="" disabled selected>Rate Condition</option>
    <option value="With RTO" <?php echo ($row['ratecondition1'] === 'With RTO') ? 'selected' : ''; ?>>With RTO</option>
    <option value="Without RTO" <?php echo ($row['ratecondition1'] === 'Without RTO') ? 'selected' : ''; ?>>Without RTO</option>
    <option value="As Per Receipt From RTO" <?php echo ($row['ratecondition1'] === 'As Per Receipt From RTO') ? 'selected' : ''; ?>>As Per Receipt From RTO</option>
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
                        <input type="text" id="secondmaterial" name="material2" value="<?php echo $row['material2'] ?>" placeholder="" class="input02">
                        <label for="" class="placeholder2">Material Detail</label>
                    </div>
                    <div class="trial1 sizereduced">
                        <input type="number" name="length2" value="<?php echo $row['length2'] ?>"  placeholder="" class="input02">
                        <label for="" class="placeholder2">Length</label>
                    </div>
                    <div class="trial1 sizereduced">
                        <input type="number" name="width2" value="<?php echo $row['width2'] ?>"  placeholder="" class="input02">
                        <label for="" class="placeholder2">Width</label>
                    </div>
                    <div class="trial1 sizereduced">
                        <input type="number" name="height2" value="<?php echo $row['height2'] ?>"  placeholder="" class="input02">
                        <label for="" class="placeholder2">Height</label>
                    </div>
                    <div class="trial1 sizereduced">
                        <input type="number" name="weight2" value="<?php echo $row['weight2'] ?>"  placeholder="" class="input02">
                        <label for="" class="placeholder2">Weight</label>
                    </div>
                </div>
                <div class="outer02">
                    <div class="trial1">
                        <select name="trailor2" id="" class="input02">
                            <option value="" disabled selected>Trailor Type</option>
                            <option <?php if($row['trailo_type2']==='Axle'){ echo 'selected';} ?> value="Axle">Axle</option>
                            <option <?php if($row['trailo_type2']==='LBT'){ echo 'selected';} ?> value="LBT">LBT</option>
                            <option <?php if($row['trailo_type2']==='SLBT'){ echo 'selected';} ?> value="SLBT">SLBT</option>
                            <option <?php if($row['trailo_type2']==='HBT'){ echo 'selected';} ?> value="HBT">HBT</option>
                            <option <?php if($row['trailo_type2']==='Lorry'){ echo 'selected';} ?> value="Lorry">Lorry</option>
                        </select>
                    </div>
                    <div class="trial1">
                        <input type="number" value="<?php echo $row['freight2'] ?>"  name="freight2" placeholder="" class="input02">
                        <label for="" class="placeholder2">Freight Charges</label>
                    </div>
                    <div class="trial1">
                        <select name="rate2" id="" class="input02">
                            <option value="" disabled selected>Rate Condition</option>
                            <option <?php if($row['ratecondition2']==='With RTO'){ echo 'selected';} ?> value="With RTO">With RTO</option>
                            <option <?php if($row['ratecondition2']==='Without RTO'){ echo 'selected';} ?> value="Without RTO">Without RTO</option>
                            <option <?php if($row['ratecondition2']==='As Per Receipt From RTO'){ echo 'selected';} ?> value="As Per Receipt From RTO">As Per Receipt From RTO</option>
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
            <input type="text" id="thirdmaterial" name="material3" value="<?php echo $row['material3'] ?>"  placeholder="" class="input02">
            <label for="" class="placeholder2">Material Detail</label>
        </div>
        <div class="trial1 sizereduced">
            <input type="number" name="length3" value="<?php echo $row['length3'] ?>"  placeholder="" class="input02 ">
            <label for="" class="placeholder2">Length</label>
        </div>
        <div class="trial1 sizereduced">
            <input type="number" name="width3" value="<?php echo $row['width3'] ?>"  placeholder="" class="input02">
            <label for="" class="placeholder2">Width</label>
        </div>
        <div class="trial1 sizereduced">
            <input type="number" name="height3" value="<?php echo $row['height3'] ?>"  placeholder="" class="input02">
            <label for="" class="placeholder2">Height</label>
        </div>
        <div class="trial1 sizereduced">
            <input type="number" name="weight3" value="<?php echo $row['weight3'] ?>" placeholder="" class="input02">
            <label for="" class="placeholder2">Weight</label>
        </div>
        
    </div>
    

<div class="outer02">
<div class="trial1">
            <select name="trailor3" id="" class="input02">
                <option value=""disabled selected>Trailor Type</option>
                <option <?php if($row['trailor_type3']==='Axle'){ echo 'selected';} ?>value="Axle">Axle</option>
                <option <?php if($row['trailor_type3']==='LBT'){ echo 'selected';} ?>value="LBT">LBT</option>
                <option <?php if($row['trailor_type3']==='SLBT'){ echo 'selected';} ?>value="SLBT">SLBT</option>
                <option <?php if($row['trailor_type3']==='HBT'){ echo 'selected';} ?>value="HBT">HBT</option>
                <option <?php if($row['trailor_type3']==='Lorry'){ echo 'selected';} ?>value="Lorry">Lorry</option>

            </select>
        </div>

    <div class="trial1">
        <input type="number" name="freight3" value="<?php echo $row['freight3'] ?>" placeholder="" class="input02">
        <label for="" class="placeholder2">Freight Charges</label>
    </div>
    <div class="trial1">
    <select name="rate3" id="" class="input02">
        <option value=""disabled selected>Rate Condition</option>
        <option <?php if($row['ratecondition3']==='With RTO'){ echo 'selected';} ?>value="With RTO">With RTO</option>
        <option <?php if($row['ratecondition3']==='Without RTO'){ echo 'selected';} ?>value="Without RTO">Without RTO</option>
        <option <?php if($row['ratecondition3']==='As Per Recipt From RTO'){ echo 'selected';} ?>value="As Per Recipt From RTO">As Per Recipt From RTO</option>

    </select>

</div>

    </div> 
    <div class="addbuttonicon" id="fouthadd"><i onclick="fourthequipment()"  class="bi bi-plus-circle">Add Another Equipment</i></div>

    </div>
<div class="secondvechiclequotecontainer" id="fourthequipmentcontainer">
    <a>Fourth Equipment Quotation </a>
    <div class="outer02">
        <div class="trial1">
            <input type="text" id="fourthmaterial" placeholder="" value="<?php echo $row['material4'] ?>" name="material4" class="input02">
            <label for="" class="placeholder2">Material Detail</label>
        </div>
        <div class="trial1 sizereduced">
            <input type="number" placeholder="" value="<?php echo $row['length4'] ?>" name="length4" class="input02 ">
            <label for="" class="placeholder2">Length</label>
        </div>
        <div class="trial1 sizereduced">
            <input type="number" placeholder="" value="<?php echo $row['width4'] ?>"name="width4" class="input02">
            <label for="" class="placeholder2">Width</label>
        </div>
        <div class="trial1 sizereduced">
            <input type="number" placeholder="" value="<?php echo $row['height4'] ?>" name="height4" class="input02">
            <label for="" class="placeholder2">Height</label>
        </div>
        <div class="trial1 sizereduced">
            <input type="number" placeholder="" value="<?php echo $row['weight4'] ?>" name="weight4" class="input02">
            <label for="" class="placeholder2">Weight</label>
        </div>
        
    </div>
    

<div class="outer02">
<div class="trial1">
            <select name="trailor4" id="" class="input02">
                <option value=""disabled selected>Trailor Type</option>
                <option <?php if($row['trailor_type4']==='Axle'){ echo 'selected';} ?> value="Axle">Axle</option>
                <option <?php if($row['trailor_type4']==='LBT'){ echo 'selected';} ?> value="LBT">LBT</option>
                <option <?php if($row['trailor_type4']==='SLBT'){ echo 'selected';} ?> value="SLBT">SLBT</option>
                <option <?php if($row['trailor_type4']==='HBT'){ echo 'selected';} ?> value="HBT">HBT</option>
                <option <?php if($row['trailor_type4']==='Lorry'){ echo 'selected';} ?> value="Lorry">Lorry</option>

            </select>
        </div>

    <div class="trial1">
        <input type="number" name="freight4" value="<?php echo $row['freight4'] ?>" placeholder="" class="input02">
        <label for="" class="placeholder2">Freight Charges</label>
    </div>
    <div class="trial1">
    <select name="rate4" id="" class="input02">
        <option value=""disabled selected>Rate Condition</option>
        <option <?php if($row['ratecondition4']==='With RTO'){ echo 'selected';} ?> value="With RTO">With RTO</option>
        <option <?php if($row['ratecondition4']==='Without RTO'){ echo 'selected';} ?> value="Without RTO">Without RTO</option>
        <option <?php if($row['ratecondition4']==='As Per Recipt From RTO'){ echo 'selected';} ?> value="As Per Recipt From RTO">As Per Recipt From RTO</option>

    </select>

</div>

    </div>
    </div>
    <a href="complete_profile_new.php">If Name Not Available In The Option Add Team Members First</a>
    <div class="outer02">
        <div class="trial1">
            <input type="text" placeholder="" name="senders_name" value="<?php echo $row['senders_name'] ?>" class="input02">
        </div>
        <div class="trial1">
            <input type="text" value="<?php echo $row['senders_number'] ?>" name="senders_number" placeholder="" class="input02">
            <label for="" class="placeholder2">Number</label>
        </div>
        <div class="trial1">
            <input type="text"  value="<?php echo $row['senders_email'] ?>"  name="senders_email" placeholder="" class="input02">
            <label for="" class="placeholder2">Email</label>
        </div>
    </div>
    <div class="terms_container012">
    <p class="heading_terms">Terms & Conditions :</p>
    <p class="terms_condition"><strong>1.Transportation Liability :</strong>Transportation shall be done by us on 
    <select name="risk" id="">
        <option <?php if($row['risk']==='owners risk'){ echo 'selected';} ?> value="owners risk">owners risk</option>
        <option <?php if($row['risk']==='our own risk'){ echo 'selected';} ?> value="our own risk">our own risk</option>
    </select> as per terms & conditions laid down on our
    consignment note</p>
    <p class="terms_condition"><strong>2.Insurance Liability :</strong>Transit Insurance is in <select name="insaurance" id="">
        <option <?php if($row['insaurance']==='consignor / consignee scope'){ echo 'selected';} ?> value="consignor / consignee scope">consignor / consignee scope</option>
        <option <?php if($row['insaurance']==='logistic Company scope'){ echo 'selected';} ?> value="logistic Company scope">logistic Company scope</option>
    </select></p>
    <p class="terms_condition"><strong>3.Scope of Services: Loading and Unloading Charges :</strong>Loading & Unloading charges is in <select name="loading" id="">
        <option value="consignor / consignee scope">consignor / consignee scope</option>
        <option value="logistic Company scope">logistic Company scope</option>
    </select></p>
<p class="terms_condition"><strong>4.Detention :</strong>Detention free period at loading /unloading point is <select name="detention" id="">
        <option <?php if($row['detention']==='3 hours'){ echo 'selected';} ?> value="3 hours">3 hours</option>
        <option <?php if($row['detention']==='6 hours'){ echo 'selected';} ?> value="6 hours">6 hours</option>
        <option <?php if($row['detention']==='9 hours'){ echo 'selected';} ?> value="9 hours">9 hours</option>
        <option <?php if($row['detention']==='12 hours'){ echo 'selected';} ?> value="12 hours">12 hours</option>
        <option <?php if($row['detention']==='24 hours'){ echo 'selected';} ?> value="24 hours">24 hours</option>
    </select> after that detention charges will be imposed .</p>

<p class="terms_condition"><strong>5.Freight Rate Adjustment  :</strong>Our offer is based on the prevailing prices of diesel, in case of any increase in price of diesel, freight
rates shall increase by <select name="increaseprice" id="">
        <option <?php if($row['freight_change']==='0.5%'){ echo 'selected';} ?> value="0.5%">0.5%</option>
        <option <?php if($row['freight_change']==='1%'){ echo 'selected';} ?> value="1%">1%</option>
        <option <?php if($row['freight_change']==='2%'){ echo 'selected';} ?> value="2%">2%</option>
    </select> with every 1% increase in prices of diesel.</p>


<p class="terms_condition"> <strong>6.Obstacles Removal Responsibility :</strong>Removal of any phatak, wires or any other obstacles from road shall be in <select name="phatak" id="">
<option <?php if($row['obstacle']==='client scope'){ echo 'selected';} ?> value="client scope">client scope</option>
<option <?php if($row['obstacle']==='our scope'){ echo 'selected';} ?> value="our scope">our scope</option>


</select> at <select name="phatakcost" id="">
    <option <?php if($row['phatak_cost']==='no additional cost'){ echo 'selected';} ?> value="no additional cost">no addditional cost</option>
    <option <?php if($row['phatak_cost']==='additional cost'){ echo 'selected';} ?> value="addditional cost">addditional cost</option>
</select></p>


<p class="terms_condition"><strong>7.Supporting Equipment Scope :</strong>In case extra wooden slippers , chain or any other supporting equipment to  be required will be in 
<select name="extratools" id="">
<option <?php if($row['supporting']==='client scope'){ echo 'selected';} ?>value="client scope">client scope</option>
<option <?php if($row['supporting']==='our scope'){ echo 'selected';} ?>value="our scope">our scope</option>
</select>at 

<select name="toolscost" id="">
    <option <?php if($row['tool_cost']==='no additional cost'){ echo 'selected';} ?>value="no additional cost">no addditional cost</option>
    <option <?php if($row['tool_cost']==='additional cost'){ echo 'selected';} ?>value="addditional cost">addditional cost</option>
</select></p>
<p class="terms_condition"><strong>8.Offer Validity :</strong>Proposed offer is valid for <select name="offervalidity" id="">
    <option <?php if($row['offer']==='3 days'){ echo 'selected';} ?> value="3 days">3 days</option>
    <option <?php if($row['offer']==='5 days'){ echo 'selected';} ?> value="5 days">5 days</option>
    <option <?php if($row['offer']==='7 days'){ echo 'selected';} ?> value="7 days">7 days</option>
    <option <?php if($row['offer']==='15 days'){ echo 'selected';} ?> value="15 days">15 days</option>
    <option <?php if($row['offer']==='30 days'){ echo 'selected';} ?> value="30 days">30 days</option>
</select></p>
<p class="terms_condition"><strong>9.Advance Payment :</strong><select name="adv" id="">
    <option <?php if($row['adv']==='30%'){ echo 'selected';} ?> value="30%">30%</option>
    <option <?php if($row['adv']==='50%'){ echo 'selected';} ?> value="50%">50%</option>
    <option <?php if($row['adv']==='60%'){ echo 'selected';} ?> value="60%">60%</option>
    <option <?php if($row['adv']==='80%'){ echo 'selected';} ?> value="80%">80%</option>
    <option <?php if($row['adv']==='90%'){ echo 'selected';} ?> value="90%">90%</option>
</select>Advance payment at time of Loading & Balance Payment within 
<select name="balance" id="">
    <option <?php if($row['balance']==='7 days'){ echo 'selected';} ?> value="7 days">7 Days</option>
    <option <?php if($row['balance']==='15 days'){ echo 'selected';} ?> value="15 days">15 days</option>
    <option <?php if($row['balance']==='30 days'){ echo 'selected';} ?> value="30 days">30 days</option>
    <option <?php if($row['balance']==='45 days'){ echo 'selected';} ?> value="45 days">45 days</option>
    <option <?php if($row['balance']==='60 days'){ echo 'selected';} ?> value="60 days">60 days</option>
</select>of our bill submission.In case of delay/refusal in clearing our charges, interest at 18% P.a. shall be claimed and needs to be paid by client.
</p>
<!-- <div class="terms_condition"  name="rate_adjustment" contenteditable="true"><strong>10.Rate Adjustment :</strong>Our offer is based on dimension and weights of packages specified in your enquiry and In case
any changes in dimension and weights of the packages, we reserve the right to re-negotiate the
rates / terms of the offer.</div> -->

<p class="terms_condition">
    <strong>10.Rate Adjustment :</strong>
<textarea name="rate_adjustment" id="" cols="30" rows="3" class="terms_textarea" ><?php echo $row['rate_adjustment'] ?> </textarea>
</p>

<p class="terms_condition">
    <strong>11.Taxes :</strong>
<textarea name="taxes" id="" cols="30" rows="2" class="terms_textarea" ><?php echo $row['taxes'] ?> </textarea>
</p>



<div class="logisubmitbutton">
<button class="quotation_submit" name="edit_logiquotation" type="submit">Submit</button>
</div>
<br>
 </div>
        
    </form>

    <script src="main.js" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
        var selectElement = document.getElementById('secondmaterial');
        if (selectElement.value !== '') {
            secondtrailor(); // Call your function when the select value is not empty
        }
    });
        document.addEventListener('DOMContentLoaded', function() {
        var selectElement = document.getElementById('thirdmaterial');
        if (selectElement.value !== '') {
            addAnotherEquipment(); // Call your function when the select value is not empty
        }
    });

        document.addEventListener('DOMContentLoaded', function() {
        var selectElement = document.getElementById('fourthmaterial');
        if (selectElement.value !== '') {
            fourthequipment(); // Call your function when the select value is not empty
        }
    });

    </script>
</body>
</html>
