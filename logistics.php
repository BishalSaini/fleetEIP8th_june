<?php
include_once 'partials/_dbconnect.php'; // Include the database connection file
session_start();
$email = $_SESSION["email"];
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
$showAlert = false;
$showError = false;

?>
<?php
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirect the user to the homepage
    header("Location: sign_in.php");
    exit; // Stop further execution
}
?>
<?php
$sql_senders="SELECT * FROM `team_members` where company_name='$companyname001' AND department!='Human Resource Department'";
$result_sender=mysqli_query($conn,$sql_senders);
?>
<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
include 'partials/_dbconnect.php';
$request_email = $_POST["email"];
$request_company = $_POST["company"];
$material = $_POST["material"];
$req_type = $_POST["req_type"];
$trailor_type = $_POST["trailor_type"];
// $trailor_type2 = $_POST["trailor_type2"];
$trailor_type2 = !empty($_POST["trailor_type2"]) ? $_POST["trailor_type2"] : NULL;
$trailor_type3 = !empty($_POST["trailor_type3"]) ? $_POST["trailor_type3"] : NULL;
$trailor_type4 = !empty($_POST["trailor_type4"]) ? $_POST["trailor_type4"] : NULL;
$trailor_type5 = !empty($_POST["trailor_type5"]) ? $_POST["trailor_type5"] : NULL;
$trailor_type6 = !empty($_POST["trailor_type6"]) ? $_POST["trailor_type6"] : NULL;
$trailor_type7 = !empty($_POST["trailor_type7"]) ? $_POST["trailor_type7"] : NULL;
$trailor_type8 = !empty($_POST["trailor_type8"]) ? $_POST["trailor_type8"] : NULL;
$trailor_type9 = !empty($_POST["trailor_type9"]) ? $_POST["trailor_type9"] : NULL;
$trailor_type10 = !empty($_POST["trailor_type10"]) ? $_POST["trailor_type10"] : NULL;
$trailor1=$_POST['1trailor'];
$trailor2=$_POST['2trailor'];
$trailor3=$_POST['3trailor'];
$trailor4=$_POST['4trailor'];
$trailor5=$_POST['5trailor'];
$trailor6=$_POST['6trailor'];
$trailor7=$_POST['7trailor'];
$trailor8=$_POST['8trailor'];
$trailor9=$_POST['9trailor'];
$trailor10=$_POST['10trailor'];


$Length = $_POST["Length"];
$Length2 = $_POST["Length2"];
$Length3 = $_POST["Length3"];
$Length4 = $_POST["Length4"];
$Length5 = $_POST["Length5"];
$Length6 = $_POST["Length6"];
$Length7 = $_POST["Length7"];
$Length8 = $_POST["Length8"];
$Length9 = $_POST["Length9"];
$Length10 = $_POST["Length10"];

$width = $_POST["width"];
$width2  = $_POST["width2"];
$width3  = $_POST["width3"];
$width4  = $_POST["width4"];
$width5  = $_POST["width5"];
$width6  = $_POST["width6"];
$width7  = $_POST["width7"];
$width8  = $_POST["width8"];
$width9  = $_POST["width9"];
$width10  = $_POST["width10"];




$height = $_POST["height"];
$height2 = $_POST["height2"];
$height3 = $_POST["height3"];
$height4 = $_POST["height4"];
$height5 = $_POST["height5"];
$height6 = $_POST["height6"];
$height7 = $_POST["height7"];
$height8 = $_POST["height8"];
$height9 = $_POST["height9"];
$height10 = $_POST["height10"];




$weight = $_POST["weight"];
$weight2 = $_POST["weight2"];
$weight3 = $_POST["weight3"];
$weight4 = $_POST["weight4"];
$weight5 = $_POST["weight5"];
$weight6 = $_POST["weight6"];
$weight7 = $_POST["weight7"];
$weight8 = $_POST["weight8"];
$weight9 = $_POST["weight9"];
$weight10 = $_POST["weight10"];


$from = $_POST["from"];

$from_pincode = $_POST["from_pincode"];
$to = $_POST["to"];
$to_pincode = $_POST["to_pincode"];
// $payment = $_POST["payment_terms"];
$company_number = $_POST["company_number"];
$number_of_trailor=$_POST['no_of_trailor'];
$requirement_valid_till=$_POST['requirement_valid_till'];
$dimension_unit=$_POST['dimension_unit'];
$weight_unit=$_POST['weight_unit'];
$rate_condition=$_POST['rate_condition'];
$adv_payment=$_POST['adv_payment'];
$percent = $_POST['percent'] ?? null;
$balance_payment=$_POST['balance_payment'];



$contact_person=$_POST['contact_person'];

$sql="INSERT INTO `logistics_need` (`contact_person`,`requirement_valid_till`, `dimension_unit`, `weight_unit`, `rate_condition`, `adv_payment`, `adv_pay_percent`, `balance_pay`,

`number_of_trailor`,`email_need_generator`, `company_number` , `companyname_need_generator`, `material_detail`, `type_of_requirement`, `trailor_type1`, `Length1`, `width1`, `height1`, `weight1`, `from`, `from_pincode`, `to`, `to_pincode`, 
`trailor2`, `trailor3`, `trailor4`, `trailor5`, `trailor6`, `trailor7`,
 `trailor8`, `trailor9`, `trailor10`, `Length2`, `Length3`, `Length4`, `Length5`,
  `Length6`, `Length7`, `Length8`, `Length9`, `Length10`, `width2`, `width3`, `width4`,
   `width5`, `width6`, `width7`, `width8`, `width9`, `width10`, `height2`, `height3`, 
   `height4`, `height5`, `height6`, `height7`, `height8`, `height9`, `height10`, `weight2`,
    `weight3`, `weight4`, `weight5`, `weight6`, `weight7`, `weight8`, `weight9`, `weight10`,`no_1_trailor`, 
    `no_2_trailor`, `no_3_trailor`, `no_4_trailor`, `no_5_trailor`, `no_6_trailor`, `no_7_trailor`, `no_8_trailor`,
     `no_9_trailor`, `no_10_trailor`)
 VALUES
 ('$contact_person','$requirement_valid_till','$dimension_unit','$weight_unit','$rate_condition','$adv_payment','$percent','$balance_payment','$number_of_trailor','$request_email', '$company_number' , '$request_company',
  '$material', '$req_type', '$trailor_type', '$Length', '$width', '$height', '$weight',
   '$from', '$from_pincode', '$to', '$to_pincode','$trailor_type2','$trailor_type3','$trailor_type4','$trailor_type5','$trailor_type6',
   '$trailor_type7','$trailor_type8','$trailor_type9','$trailor_type10','$Length2','$Length3','$Length4','$Length5','$Length6','$Length7','$Length8','$Length9','$Length10',
   '$width2','$width3','$width4','$width5','$width6','$width7','$width8','$width9','$width10','$height2','$height3','$height4','$height5','$height6','$height7','$height8','$height9','$height10',
   '$weight2','$weight3','$weight4','$weight5','$weight6','$weight7','$weight8','$weight9','$weight10','$trailor1','$trailor2','$trailor3','$trailor4','$trailor5','$trailor6','$trailor7','$trailor8','$trailor9','$trailor10')";
$result=mysqli_query($conn , $sql);
if($result){
    header("Location: recieved_quotation_logistics.php");
$showAlert=true;
}
else{
    $showError=true;
}






}

?>


<style>
  <?php include "style.css" ?>
</style>
<script>
    <?php include "main.js" ?>
    </script>
<!-- <script>
    <?php include "autofill_senders_name.js" ?>
    </script> -->
    <?php
include 'partials/_dbconnect.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">      <link rel="icon" href="favicon.jpg" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>

    <script src="autofill_senders_name.js"defer></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Document</title>
</head>
<body>
<div class="navbar1">
        <div class="iconcontainer">
        <ul>
      <li><a href="<?php echo $dashboard_url ?>">Dashboard</a></li>
            <li><a href="news/">News</a></li>

            <li><a href="logout.php">Log Out</a></li></ul>
        </div>
    </div>
    <?php
    if($showAlert){
        echo  '<label>
        <input type="checkbox" class="alertCheckbox" autocomplete="off" />
        <div class="alert notice">
          <span class="alertClose">X</span>
          <span class="alertText_addfleet"><b>Success!</b>
              <br class="clear"/></span>
        </div>
      </label>';
    }
    if($showError){
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
    <form action="logistics.php" method="POST" class="logistics_need_form" autocomplete="off">
        <div class="logistic_need_container">
        <div class="logistics_heading"><h2 class="logistics_need_heading">Logistics Requirement</h2></div>
        <!-- <div class="outer02">
        <div class="trial1">
            <input type="text" name="email" placeholder="" value="<?php echo $email ?>" class="input02" readonly>
            <label class="placeholder2">Email</label>
        </div> -->
        <div class="outer02">
        <div class="trial1">
            <input type="text" name="company" placeholder="" id="logistics_need_rental" value="<?php echo $companyname001 ?>" class="input02" readonly>
            <label class="placeholder2">Company Name</label>
        </div>
        <!-- </div> -->
        <!-- <div class="outer02">
        <div class="trial1">
            <input type="text" name="company_number" placeholder="" class="input02">
            <label class="placeholder2">Contact Number</label>
        </div> -->
        <div class="trial1">
            <input type="text" name="material" placeholder="" class="input02" required>
            <label class="placeholder2">Material Details</label>
        </div>
        </div>
        <!-- </div> -->
        <div class="outer02">
            <div class="trial1">
            <input type="text" name="from" placeholder="" class="input02" required>
            <label class="placeholder2">From</label>
            </div>
            <div class="trial1">
            <input type="text" name="from_pincode"  placeholder="" class="input02" required>
            <label class="placeholder2">From Pincode</label>
            </div>
            </div>
            <div class="outer02">
            <div class="trial1">
            <input type="text" name="to" placeholder="" class="input02" required>
            <label class="placeholder2">To</label>
            </div>
            <div class="trial1">
            <input type="text" name="to_pincode" placeholder=""  class="input02" required>
            <label class="placeholder2">To Pincode</label>
            </div>

            </div>

            <div class="outer02">
        <div class="trial1">
            <select name="req_type" id=""  class="input02" required>
                <option value="" disabled selected>Type Of Requirement</option>
                <option value="Budgeting">Budgeting</option>
                <option value="Immediate">Immediate</option>
            </select>
            </div>
            <div class="trial1">
                <input type="date" name="requirement_valid_till" placeholder="" class="input02" required>
                <label for="" class="placeholder2">Requirement Valid Till </label>
            </div>
            </div>
            <div class="outer02">
                <div class="trial1">
                    <select name="dimension_unit" id="" class="input02" required>
                        <option value=""disabled selected>Dimensions Unit</option>
                        <option value="cm">cm</option>
                        <option value="inches">inches</option>
                        <option value="feet">feet</option>
                        <!-- <option value=""></option> -->
                    </select>
                </div>
                <div class="trial1">
                    <select name="weight_unit" id="" class="input02" required>
                        <option value=""disabled selected>Weight Unit</option>
                        <option value="kgs">kgs</option>
                        <option value="ton">ton</option>
                    </select>
                </div>
            </div>
            <div class="outer02">
                <div class="trial1">
                    <input type="number" name="1trailor" value="<?php echo '1' ;?>" placeholder="" id="no1" class="input02 no_of_trailor1" required>
                    <label for="" class="placeholder2">No Of Trailor</label>
                </div>
            <div class="trial1"> 
            <select name="trailor_type" id="" class="input02" required>
                <option value="" disabled selected>Type</option>
                <option value="Axle">Axle</option>
                <option value="LBT">LBT</option>
                <option value="SLBT">SLBT</option>
                <option value="HBT">HBT</option>
                <option value="Lorry">Lorry</option>
            </select>
            </div>

            <div class="trial1">
            <input type="number" name="Length" step="0.1" placeholder="" class="input02" required>
            <label class="placeholder2">Length</label>
            </div>
            <div class="trial1">
            <input type="number" name="width" step="0.1" placeholder=""  class="input02" required>
            <label class="placeholder2">Width</label>
            </div>
            <div class="trial1">
            <input type="number" name="height" step="0.1" placeholder=""  class="input02" required>
            <label class="placeholder2">Height</label>
            </div>
            <div class="trial1">
            <input type="number" name="weight" step="0.1" placeholder="" class="input02" required>
            <label class="placeholder2">Weight</label>
            </div>
            <div class="trial1 abcd" id="icon" >
            <i class="fa-solid fa-plus" onclick="addtrailor()"></i>
            </div>
            </div>
            
            <div class="outer02" id="add_trailor" style="display: none;">
            
            <!-- <br><br> -->
            <div class="cont">
            <div class="trial1">
                    <input type="number" name="2trailor" placeholder="" id="no2" class="input02 no_of_trailor1">
                    <label for="" class="placeholder2">No Of Trailor</label>
                </div>

            <select name="trailor_type2" id="" class="input02">
                <option value="" disabled selected>Type </option>
                <option value="Axle">Axle</option>
                <option value="LBT">LBT</option>
                <option value="SLBT">SLBT</option>
                <option value="HBT">HBT</option>
                <option value="Lorry">Lorry</option>
            </select>
            <div class="trial1">
            <input type="number" name="Length2" step="0.1" placeholder="" class="input02">
            <label class="placeholder2">Length</label>
            </div>
            <div class="trial1">
            <input type="number" name="width2" step="0.1" placeholder=""  class="input02">
            <label class="placeholder2">Width</label>
            </div>
            <div class="trial1">
            <input type="number" name="height2" step="0.1" placeholder=""  class="input02">
            <label class="placeholder2">Height</label>
            </div>
            <div class="trial1">
            <input type="number" name="weight2" step="0.1" placeholder="" class="input02">
            <label class="placeholder2">Weight</label>
            </div>
            <div class="trial1 abcd" id="icon2">
            <i class="fa-solid fa-plus" onclick="addtrailor2()"></i>
            </div>
            </div>
            </div>
            
            <div class="outer02" id="add_trailor2" style="display: none;">
            <div class="cont">
            <div class="trial1">
                    <input type="number" name="3trailor" placeholder="" id="no3" class="input02 no_of_trailor1">
                    <label for="" class="placeholder2">No Of Trailor</label>
                </div>
            <select name="trailor_type3" id="" class="input02">
                <option value="" disabled selected>Type </option>
                <option value="Axle">Axle</option>
                <option value="LBT">LBT</option>
                <option value="SLBT">SLBT</option>
                <option value="HBT">HBT</option>
                <option value="Lorry">Lorry</option>
            </select>
            
            <!-- <br><br> -->
            <div class="trial1">
            <input type="number" name="Length3" step="0.1" placeholder="" class="input02">
            <label class="placeholder2">Length</label>
            </div>
            <div class="trial1">
            <input type="number" name="width3" step="0.1" placeholder=""  class="input02">
            <label class="placeholder2">Width</label>
            </div>
            <div class="trial1">
            <input type="number" name="height3" step="0.1" placeholder=""  class="input02">
            <label class="placeholder2">Height</label>
            </div>
            <div class="trial1">
            <input type="number" name="weight3" step="0.1" placeholder="" class="input02">
            <label class="placeholder2">Weight</label>
            </div>
            <div class="trial1 abcd" id="icon3">
            <i class="fa-solid fa-plus" onclick="trailor4_required()"></i>
            </div>
            </div>
            </div>
            <!-- 4th trailor -->
            <div class="outer02" id="add_trailor4" style="display: none;">
            <div class="cont">
            <div class="trial1">
                    <input type="number" name="4trailor" placeholder="" id="no4" class="input02 no_of_trailor1">
                    <label for="" class="placeholder2">No Of Trailor</label>
                </div>
            <select name="trailor_type4" id="" class="input02">
                <option value="" disabled selected>Type </option>
                <option value="Axle">Axle</option>
                <option value="LBT">LBT</option>
                <option value="SLBT">SLBT</option>
                <option value="HBT">HBT</option>
                <option value="Lorry">Lorry</option>
            </select>

            <div class="trial1">
            <input type="number" name="Length4" step="0.1" placeholder="" class="input02">
            <label class="placeholder2">Length</label>
            </div>
            <div class="trial1">
            <input type="number" name="width4" step="0.1" placeholder=""  class="input02">
            <label class="placeholder2">Width</label>
            </div>
            <div class="trial1">
            <input type="number" name="height4" step="0.1" placeholder=""  class="input02">
            <label class="placeholder2">Height</label>
            </div>
            <div class="trial1">
            <input type="number" name="weight4" step="0.1" placeholder="" class="input02">
            <label class="placeholder2">Weight</label>
            </div>
            <div class="trial1 abcd" id="icon4">
            <i class="fa-solid fa-plus" onclick="trailor5_required()"></i>
            </div>
            </div>
            </div>

        <!-- 5th trailor -->
        <div class="outer02" id="add_trailor5" style="display: none;">
            <div class="cont">
            <div class="trial1">
                    <input type="number" name="5trailor" placeholder="" id="no5" class="input02 no_of_trailor1">
                    <label for="" class="placeholder2">No Of Trailor</label>
                </div>
            <select name="trailor_type5" id="" class="input02">
                <option value="" disabled selected>Type </option>
                <option value="Axle">Axle</option>
                <option value="LBT">LBT</option>
                <option value="SLBT">SLBT</option>
                <option value="HBT">HBT</option>
                <option value="Lorry">Lorry</option>
            </select>

            <div class="trial1">
            <input type="number" name="Length5" step="0.1" placeholder="" class="input02">
            <label class="placeholder2">Length</label>
            </div>
            <div class="trial1">
            <input type="number" name="width5" step="0.1" placeholder=""  class="input02">
            <label class="placeholder2">Width</label>
            </div>
            <div class="trial1">
            <input type="number" name="height5" step="0.1" placeholder=""  class="input02">
            <label class="placeholder2">Height</label>
            </div>
            <div class="trial1">
            <input type="number" name="weight5" step="0.1" placeholder="" class="input02">
            <label class="placeholder2">Weight</label>
            </div>
            <div class="trial1 abcd" id="icon5">
            <i class="fa-solid fa-plus" onclick="trailor6_required()"></i>
            </div>
            </div>
            </div>


<!-- 6th trailor  -->
<div class="outer02" id="add_trailor6" style="display: none;">
            <div class="cont">
            <div class="trial1">
                    <input type="number" name="6trailor" placeholder="" id="no6" class="input02 no_of_trailor1">
                    <label for="" class="placeholder2">No Of Trailor</label>
                </div>
            <select name="trailor_type6" id="" class="input02">
                <option value="" disabled selected>Type </option>
                <option value="Axle">Axle</option>
                <option value="LBT">LBT</option>
                <option value="SLBT">SLBT</option>
                <option value="HBT">HBT</option>
                <option value="Lorry">Lorry</option>
            </select>

            <div class="trial1">
            <input type="number" name="Length6" step="0.1" placeholder="" class="input02">
            <label class="placeholder2">Length</label>
            </div>
            <div class="trial1">
            <input type="number" name="width6" step="0.1" placeholder=""  class="input02">
            <label class="placeholder2">Width</label>
            </div>
            <div class="trial1">
            <input type="number" name="height6" step="0.1" placeholder=""  class="input02">
            <label class="placeholder2">Height</label>
            </div>
            <div class="trial1">
            <input type="number" name="weight6" step="0.1" placeholder="" class="input02">
            <label class="placeholder2">Weight</label>
            </div>
            <div class="trial1 abcd" id="icon6">
            <i class="fa-solid fa-plus" onclick="trailor7_required()"></i>
            </div>
            </div>
            </div>

            <!-- 7th trailor  -->

            <div class="outer02" id="add_trailor7" style="display: none;">
            <div class="cont">
            <div class="trial1">
                    <input type="number" name="7trailor" placeholder="" id="no7" class="input02 no_of_trailor1">
                    <label for="" class="placeholder2">No Of Trailor</label>
                </div>
            <select name="trailor_type7" id="" class="input02">
                <option value="" disabled selected>Type </option>
                <option value="Axle">Axle</option>
                <option value="LBT">LBT</option>
                <option value="SLBT">SLBT</option>
                <option value="HBT">HBT</option>
                <option value="Lorry">Lorry</option>
            </select>

            <div class="trial1">
            <input type="number" name="Length7" step="0.1" placeholder="" class="input02">
            <label class="placeholder2">Length</label>
            </div>
            <div class="trial1">
            <input type="number" name="width7" step="0.1" placeholder=""  class="input02">
            <label class="placeholder2">Width</label>
            </div>
            <div class="trial1">
            <input type="number" name="height7" step="0.1" placeholder=""  class="input02">
            <label class="placeholder2">Height</label>
            </div>
            <div class="trial1">
            <input type="number" name="weight7" step="0.1" placeholder="" class="input02">
            <label class="placeholder2">Weight</label>
            </div>
            <div class="trial1 abcd" id="icon7">
            <i class="fa-solid fa-plus" onclick="trailor8_required()"></i>
            </div>
            </div>
            </div>

<!-- 8th trailor  -->
<div class="outer02" id="add_trailor8" style="display: none;">
            <div class="cont">
            <div class="trial1">
                    <input type="number" name="8trailor" placeholder="" id="no8" class="input02 no_of_trailor1">
                    <label for="" class="placeholder2">No Of Trailor</label>
                </div>
            <select name="trailor_type8" id="" class="input02">
                <option value="" disabled selected>Type </option>
                <option value="Axle">Axle</option>
                <option value="LBT">LBT</option>
                <option value="SLBT">SLBT</option>
                <option value="HBT">HBT</option>
                <option value="Lorry">Lorry</option>
            </select>

            <div class="trial1">
            <input type="number" name="Length8" step="0.1" placeholder="" class="input02">
            <label class="placeholder2">Length</label>
            </div>
            <div class="trial1">
            <input type="number" name="width8" step="0.1" placeholder=""  class="input02">
            <label class="placeholder2">Width</label>
            </div>
            <div class="trial1">
            <input type="number" name="height8" step="0.1" placeholder=""  class="input02">
            <label class="placeholder2">Height</label>
            </div>
            <div class="trial1">
            <input type="number" name="weight8" step="0.1" placeholder="" class="input02">
            <label class="placeholder2">Weight</label>
            </div>
            <div class="trial1 abcd" id="icon8">
            <i class="fa-solid fa-plus" onclick="trailor9_required()"></i>
            </div>
            </div>
            </div>

            <!-- 9th trailor  -->
            <div class="outer02" id="add_trailor9" style="display: none;">
            <div class="cont">
            <div class="trial1">
                    <input type="number" name="9trailor" placeholder="" id="no9" class="input02 no_of_trailor1">
                    <label for="" class="placeholder2">No Of Trailor</label>
                </div>
            <select name="trailor_type9" id="" class="input02">
                <option value="" disabled selected>Type </option>
                <option value="Axle">Axle</option>
                <option value="LBT">LBT</option>
                <option value="SLBT">SLBT</option>
                <option value="HBT">HBT</option>
                <option value="Lorry">Lorry</option>
            </select>

            <div class="trial1">
            <input type="number" name="Length9" step="0.1" placeholder="" class="input02">
            <label class="placeholder2">Length</label>
            </div>
            <div class="trial1">
            <input type="number" name="width9" step="0.1" placeholder=""  class="input02">
            <label class="placeholder2">Width</label>
            </div>
            <div class="trial1">
            <input type="number" name="height9" step="0.1" placeholder=""  class="input02">
            <label class="placeholder2">Height</label>
            </div>
            <div class="trial1">
            <input type="number" name="weight9" step="0.1" placeholder="" class="input02">
            <label class="placeholder2">Weight</label>
            </div>
            <div class="trial1 abcd" id="icon9">
            <i class="fa-solid fa-plus" onclick="trailor10_required()"></i>
            </div>
            </div>
            </div>

<!-- 10th trailor  -->
<div class="outer02" id="add_trailor10" style="display: none;">
            <div class="cont">
            <div class="trial1">
                    <input type="number" name="10trailor" placeholder="" id="no10" class="input02 no_of_trailor1">
                    <label for="" class="placeholder2">No Of Trailor</label>
                </div>
            <select name="trailor_type10" id="" class="input02">
                <option value="" disabled selected>Type</option>
                <option value="Axle">Axle</option>
                <option value="LBT">LBT</option>
                <option value="SLBT">SLBT</option>
                <option value="HBT">HBT</option>
                <option value="Lorry">Lorry</option>
            </select>

            <div class="trial1">
            <input type="number" name="Length10" step="0.1" placeholder="" class="input02">
            <label class="placeholder2">Length</label>
            </div>
            <div class="trial1">
            <input type="number" name="width10" step="0.1" placeholder=""  class="input02">
            <label class="placeholder2">Width</label>
            </div>
            <div class="trial1">
            <input type="number" name="height10" step="0.1" placeholder=""  class="input02">
            <label class="placeholder2">Height</label>
            </div>
            <div class="trial1">
            <input type="number" name="weight10" step="0.1" placeholder="" class="input02">
            <label class="placeholder2">Weight</label>
            </div>
            </div>
            </div>

            <!-- 11th trailor  -->
            <div class="outer02" id="add_trailor11" style="display: none;">
            <select name="trailor_type11" id="" class="input02">
                <option value="" disabled selected>Type Of 11th Trailor Required</option>
                <option value="Axle">Axle</option>
                <option value="LBT">LBT</option>
                <option value="SLBT">SLBT</option>
                <option value="HBT">HBT</option>
                <option value="Lorry">Lorry</option>
            </select>
            <div class="cont">
            <div class="trial1">
                    <input type="text" placeholder="" id="" class="input02 no_of_trailor1">
                    <label for="" class="placeholder2">No Of Trailor</label>
                </div>
            <div class="trial1">
            <input type="number" name="Length11" placeholder="" class="input02">
            <label class="placeholder2">Length</label>
            </div>
            <div class="trial1">
            <input type="number" name="width11" placeholder=""  class="input02">
            <label class="placeholder2">Width</label>
            </div>
            <div class="trial1">
            <input type="number" name="height11" placeholder=""  class="input02">
            <label class="placeholder2">Height</label>
            </div>
            <div class="trial1">
            <input type="number" name="weight11" placeholder="" class="input02">
            <label class="placeholder2">Weight</label>
            </div>
            <div class="trial1 abcd" id="icon11">
            <i class="fa-solid fa-plus" onclick="trailor12_required()"></i>
            </div>
            </div>
            </div>


<!-- 12th trailor  -->
<div class="outer02" id="add_trailor12" style="display: none;">
            <select name="trailor_type12" id="" class="input02">
                <option value="" disabled selected>Type Of 12th Trailor Required</option>
                <option value="Axle">Axle</option>
                <option value="LBT">LBT</option>
                <option value="SLBT">SLBT</option>
                <option value="HBT">HBT</option>
                <option value="Lorry">Lorry</option>
            </select>
            <div class="cont">
            <div class="trial1">
                    <input type="text" placeholder="" id="" class="input02 no_of_trailor1">
                    <label for="" class="placeholder2">No Of Trailor</label>
                </div>
            <div class="trial1">
            <input type="text" name="Length12" placeholder="" class="input02">
            <label class="placeholder2">Length</label>
            </div>
            <div class="trial1">
            <input type="text" name="width12" placeholder=""  class="input02">
            <label class="placeholder2">Width</label>
            </div>
            <div class="trial1">
            <input type="text" name="height12" placeholder=""  class="input02">
            <label class="placeholder2">Height</label>
            </div>
            <div class="trial1">
            <input type="text" name="weight12" placeholder="" class="input02">
            <label class="placeholder2">Weight</label>
            </div>
            <div class="trial1 abcd" id="icon12">
            <i class="fa-solid fa-plus" onclick="trailor13_required()"></i>
            </div>
            </div>
            </div>

<!-- 13th trailor  -->
<div class="outer02" id="add_trailor13" style="display: none;">
            <select name="trailor_type13" id="" class="input02">
                <option value="" disabled selected>Type Of 13th Trailor Required</option>
                <option value="Axle">Axle</option>
                <option value="LBT">LBT</option>
                <option value="SLBT">SLBT</option>
                <option value="HBT">HBT</option>
                <option value="Lorry">Lorry</option>
            </select>
            <div class="cont">
            <div class="trial1">
                    <input type="text" placeholder="" id="" class="input02 no_of_trailor1">
                    <label for="" class="placeholder2">No Of Trailor</label>
                </div>
            <div class="trial1">
            <input type="text" name="Length13" placeholder="" class="input02">
            <label class="placeholder2">Length</label>
            </div>
            <div class="trial1">
            <input type="text" name="width13" placeholder=""  class="input02">
            <label class="placeholder2">Width</label>
            </div>
            <div class="trial1">
            <input type="text" name="height13" placeholder=""  class="input02">
            <label class="placeholder2">Height</label>
            </div>
            <div class="trial1">
            <input type="text" name="weight13" placeholder="" class="input02">
            <label class="placeholder2">Weight</label>
            </div>
            <div class="trial1 abcd" id="icon13">
            <i class="fa-solid fa-plus" onclick="trailor14_required()"></i>
            </div>
            </div>
            </div>

            <!-- 14th trailor  -->
            <div class="outer02" id="add_trailor14" style="display: none;">
            <select name="trailor_type14" id="" class="input02">
                <option value="" disabled selected>Type Of 14th Trailor Required</option>
                <option value="Axle">Axle</option>
                <option value="LBT">LBT</option>
                <option value="SLBT">SLBT</option>
                <option value="HBT">HBT</option>
                <option value="Lorry">Lorry</option>
            </select>
            <div class="cont">
            <div class="trial1">
                    <input type="text" placeholder="" id="" class="input02 no_of_trailor1">
                    <label for="" class="placeholder2">No Of Trailor</label>
                </div>
            <div class="trial1">
            <input type="text" name="Length14" placeholder="" class="input02">
            <label class="placeholder2">Length</label>
            </div>
            <div class="trial1">
            <input type="text" name="width14" placeholder=""  class="input02">
            <label class="placeholder2">Width</label>
            </div>
            <div class="trial1">
            <input type="text" name="height14" placeholder=""  class="input02">
            <label class="placeholder2">Height</label>
            </div>
            <div class="trial1">
            <input type="text" name="weight14" placeholder="" class="input02">
            <label class="placeholder2">Weight</label>
            </div>
            <div class="trial1 abcd" id="icon14">
            <i class="fa-solid fa-plus" onclick="trailor15_required()"></i>
            </div>
            </div>
            </div>
 
<!-- 15th trailor  -->
<div class="outer02" id="add_trailor15" style="display: none;">
            <select name="trailor_type15" id="" class="input02">
                <option value="" disabled selected>Type Of 15th Trailor Required</option>
                <option value="Axle">Axle</option>
                <option value="LBT">LBT</option>
                <option value="SLBT">SLBT</option>
                <option value="HBT">HBT</option>
                <option value="Lorry">Lorry</option>
            </select>
            <div class="cont">
            <div class="trial1">
                    <input type="text" placeholder="" id="" class="input02 no_of_trailor1">
                    <label for="" class="placeholder2">No Of Trailor</label>
                </div>
            <div class="trial1">
            <input type="text" name="Length15" placeholder="" class="input02">
            <label class="placeholder2">Length</label>
            </div>
            <div class="trial1">
            <input type="text" name="width15" placeholder=""  class="input02">
            <label class="placeholder2">Width</label>
            </div>
            <div class="trial1">
            <input type="text" name="height15" placeholder=""  class="input02">
            <label class="placeholder2">Height</label>
            </div>
            <div class="trial1">
            <input type="text" name="weight15" placeholder="" class="input02">
            <label class="placeholder2">Weight</label>
            </div>
            </div>
</div>
<div class="outer02">
            <div class="trail1" id="rate_condition">
                <select name="rate_condition" id="" class="input02" required>
                    <option value=""disabled selected>Rate Condition</option>
                    <option value="With RTO">With RTO</option>
                    <option value="Without RTO">Without RTO</option>
                    <option value="As Per Recipt From RTO">As Per Recipt From RTO</option>
                </select>
            </div>
            <div class="trial1" >
                <input type="number" placeholder="" value="<?php echo '1' ;?>" id="totalno" name="no_of_trailor" class="input02">
                <label class="placeholder2"> Total Trailors</label>
            </div>
            </div>

<div class="outer02">
            <div class="trial1">
                <select name="contact_person" id="contactperson_logistic_need" class="input02" required>
                    <option value=""disabled selected>Contact Person</option>
                    <?php if ($result_sender) {
    while ($row_sender = mysqli_fetch_assoc($result_sender)) { ?>
            <option value="<?php echo $row_sender['name'] ?>"><?php echo $row_sender['name']?></option>


<?php } }?>
                </select>
            </div>
            <div class="trial1">
                <input type="text" id="contact_person_number" name="company_number" placeholder="" class="input02" required>
                <label for="" class="placeholder2">Contact Number</label>
            </div>
            <div class="trial1">
                <input type="text" id="contact_person_email" placeholder="" name="email" class="input02" required>
                <label for="" class="placeholder2">Contact Email</label>
            </div>
            </div>  
            <div class="outer02">
            <div class="trial1" id="advancepay">
            <select name="adv_payment"  id="advance_paymentdd" class="input02" onchange="advance_payment()" required>
                <option value="" disabled selected>Advance Payment</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
            </div>
            <div class="trial1" id="percent_payment">
                <select name="percent" id="" class="input02">
                    <option value=""disabled selected>Percent</option>
                    <option value="30%">30%</option>
                    <option value="40%">40%</option>
                    <option value="50%">50%</option>
                    <option value="60%">60%</option>
                    <option value="70%">70%</option>
                    <option value="80%">80%</option>
                </select>
            </div>
            <div class="trial1">
                    <!-- <input type="text" placeholder="" class="input02">
                    <label for="" class="placeholder2">Balance Payment</label> -->
                    <select name="balance_payment" id="" class="input02" required>
                        <option value=""disabled selected>Balance Payment </option>
                        <option value="15 Days">15 Days After Unloading</option>
                        <option value="30 Days">30 Days After Unloading</option>
                        <option value="45 Days">45 Days After Unloading</option>
                        <option value="60 Days">60 Days After Unloading</option>
                    </select>
                </div>

            </div>
            <button type="submit" class="logi_req">Post Requirement</button>
            <br>


        </div>
    </form>
    <br><br>
   
    <script>
    function addtrailor() {
        const addicon=document.getElementById("icon");
        const text=document.getElementById("add_trailor");
        
        text.style.display="block";
        addicon.style.display="none";
    }

    function addtrailor2() {
        const addicon2=document.getElementById("icon2");
        const text2=document.getElementById("add_trailor2");
        
        text2.style.display="block";
        addicon2.style.display="none";
    }

    function trailor4_required(){
        const addicon3=document.getElementById("icon3")
        const text3=document.getElementById("add_trailor4")
        text3.style.display="block";
        addicon3.style.display="none";
    }

    function trailor5_required(){
        const addicon4=document.getElementById("icon4")
        const text4=document.getElementById("add_trailor5")
        text4.style.display="block";
        addicon4.style.display="none";
    }

    function trailor6_required(){
        const addicon5=document.getElementById("icon5")
        const text5=document.getElementById("add_trailor6")
        text5.style.display="block";
        addicon5.style.display="none";
    }

    function trailor7_required(){
        const addicon6=document.getElementById("icon6")
        const text6=document.getElementById("add_trailor7")
        text6.style.display="block";
        addicon6.style.display="none";
    }
    function trailor8_required(){
        const addicon7=document.getElementById("icon7")
        const text7=document.getElementById("add_trailor8")
        text7.style.display="block";
        addicon7.style.display="none";
    }

    function trailor9_required(){
        const addicon8=document.getElementById("icon8")
        const text8=document.getElementById("add_trailor9")
        text8.style.display="block";
        addicon8.style.display="none";
    }

    function trailor10_required(){
        const addicon9=document.getElementById("icon9")
        const text9=document.getElementById("add_trailor10")
        text9.style.display="block";
        addicon9.style.display="none";
    }
    // function trailor11_required(){
    //     const addicon10=document.getElementById("icon10")
    //     const text10=document.getElementById("add_trailor11")
    //     text10.style.display="block";
    //     addicon10.style.display="none";
    // }
    // function trailor12_required(){
    //     const addicon11=document.getElementById("icon11")
    //     const text11=document.getElementById("add_trailor12")
    //     text11.style.display="block";
    //     addicon11.style.display="none";
    // }
    // function trailor13_required(){
    //     const addicon12=document.getElementById("icon12")
    //     const text12=document.getElementById("add_trailor13")
    //     text12.style.display="block";
    //     addicon12.style.display="none";
    // }
    // function trailor14_required(){
    //     const addicon13=document.getElementById("icon13")
    //     const text13=document.getElementById("add_trailor14")
    //     text13.style.display="block";
    //     addicon13.style.display="none";
    // }
    // function trailor15_required(){
    //     const addicon14=document.getElementById("icon14")
    //     const text14=document.getElementById("add_trailor15")
    //     text14.style.display="block";
    //     addicon14.style.display="none";
    // }

        // Function to update the total
        function updateTotal() {
            let total = 0;

            // Loop through the inputs with id no1 to no10
            for (let i = 1; i <= 10; i++) {
                let value = parseFloat(document.getElementById(`no${i}`).value) || 0;
                total += value;
            }

            // Update the total input field
            document.getElementById('totalno').value = total;
        }

        // Add event listeners to all input fields
        for (let i = 1; i <= 10; i++) {
            document.getElementById(`no${i}`).addEventListener('input', updateTotal);
        }
        function advance_payment() {
    const advance_paymentdd = document.getElementById("advance_paymentdd");
    const percent_payment = document.getElementById("percent_payment");
    
    // Check if advance_paymentdd is not null before accessing its value
    if (advance_paymentdd && advance_paymentdd.value === 'Yes') {
        percent_payment.style.display = 'block';
    } else {
        percent_payment.style.display = 'none';
    }
}</script>
 </body>
</html>