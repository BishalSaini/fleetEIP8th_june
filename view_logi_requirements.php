<?php
include_once 'partials/_dbconnect.php'; // Include the database connection file
session_start();
$edit_id=$_GET['id'];
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

$sql="SELECT * FROM `logistics_need` where id='$edit_id' and companyname_need_generator='$companyname001'";
$result=mysqli_query($conn,$sql);
if($result){
    $row=mysqli_fetch_assoc($result);
}
else{
    $row=array();
}

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
    $sno=$_POST['edit_sno'];
    
    $from = $_POST["from"];
    $requirement_valid_till=$_POST['requirement_valid_till'];
    $from_pincode = $_POST["from_pincode"];
    $to = $_POST["to"];
    $to_pincode = $_POST["to_pincode"];
    // $payment = $_POST["payment_terms"];
    $company_number = $_POST["company_number"];
    $number_of_trailor=$_POST['no_of_trailor'];

    $dimension_unit=$_POST['dimension_unit'];
    $weight_unit=$_POST['weight_unit'];

    $contact_person=$_POST['contact_person'];
    $rate_condition=$_POST['rate_condition'];
    $adv_payment=$_POST['adv_payment'];
    $percent=$_POST['percent'];
    $balance_payment=$_POST['balance_payment'];


    $sql_edit="    UPDATE `logistics_need` SET `email_need_generator` = '$request_email', `company_number` = '$company_number', `dimension_unit`='$dimension_unit', `weight_unit`='$weight_unit' ,
    `material_detail` = '$material', `type_of_requirement` = '$req_type', `trailor_type1` = '$trailor_type', `requirement_valid_till`='$requirement_valid_till', 
    `length1` = '$Length', `width1` = '$width', `height1` = '$height', `weight1` = '$weight', `from` = '$from',
    `rate_condition` = '$rate_condition', `adv_payment` = '$adv_payment', `adv_pay_percent` = '$percent', `balance_pay` = '$balance_payment', `contact_person` = '$contact_person',
     `from_pincode` = '$from_pincode', `to` = '$to', `to_pincode` = '$to_pincode',  
     `number_of_trailor` = '$number_of_trailor', `trailor2` = '$trailor_type2', `trailor3` = '$trailor_type3', `trailor4` = '$trailor_type4',
      `trailor5` = '$trailor_type5', `trailor6` = '$trailor_type6', `trailor7` = '$trailor_type7', `trailor8` = '$trailor_type8', `trailor9` = '$trailor_type9',
       `trailor10` = '$trailor_type10', `length2` = '$Length2', `length3` = '$Length3', `length4` = '$Length4', `length5` = '$Length5', 
       `length6` = '$Length6', `length7` = '$Length7', `length8` = '$Length8', `length9` = '$Length9', `length10` = '$Length10',
        `width2` = '$width2', `width3` = '$width3', `width4` = '$width4', `width5` = '$width5', `width6` = '$width6', `width7` = '$width7', 
        `width8` = '$width8', `width9` = '$width9', `width10` = '$width10', `height2` = '$height2', `height3` = '$height3', `height4` = '$height4', 
        `height5` = '$height5', `height6` = '$height6', `height7` = '$height7', `height8` = '$height8', `height9` = '$height9', `height10` = '$height10',
         `weight2` = '$weight2', `weight3` = '$weight3', `weight4` = '$weight4', `weight5` = '$weight5', `weight6` = '$weight6', 
         `weight7` = '$weight7', `weight8` = '$weight8', `weight9` = '$weight9', `weight10` = '$weight10', `no_1_trailor` = '$trailor1',
          `no_2_trailor` = '$trailor2', `no_3_trailor` = '$trailor3', `no_4_trailor` = '$trailor4', `no_5_trailor` = '$trailor5',
           `no_6_trailor` = '$trailor6', `no_7_trailor` = '$trailor7', `no_8_trailor` = '$trailor8', `no_9_trailor` = '$trailor9',
            `no_10_trailor` = '$trailor10' WHERE `logistics_need`.`id` = '$sno'";

    $sql_edit_result=mysqli_query($conn,$sql_edit);
    if($sql_edit_result){
        session_start();
        $_SESSION['success']="success";
        header("Location:recieved_quotation_logistics.php");
    }
    else{
        $_SESSION['something_went_wrong']="wrong";
        header("Location:recieved_quotation_logistics.php");

    }


    
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">      <link rel="icon" href="favicon.jpg" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <script src="main.js"></script>
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
          <span class="alertText_addfleet"><b>Success!</b>Requirement Posted Successfully<a href="my_logi_req.php">View Requirement</a>
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
    <form action="view_logi_requirements.php" method="POST" class="logistics_need_form" autocomplete="off">
        <div class="logistic_need_container">
        <div class="logistics_heading"><h2 class="logistics_need_heading">Logistics Need</h2></div>
        <div class="outer02">
            <input type="text" value="<?php echo $edit_id ?>" name="edit_sno" hidden>
        <!-- <div class="trial1">
            <input type="text" name="email" placeholder="" value="<?php echo$email ?>" class="input02" readonly>
            <label class="placeholder2">Email</label>
        </div> -->
        <div class="trial1">
            <input type="text" name="company" placeholder="" value="<?php echo $companyname001 ?>" class="input02" readonly>
            <label class="placeholder2">Company Name</label>
        </div>
        <div class="trial1">
            <input type="text" value="<?php echo $row['material_detail'] ?>" name="material" placeholder="" class="input02">
            <label class="placeholder2">Material Details</label>
        </div>

        </div>

        <!-- <div class="outer02">
        <div class="trial1">
            <input type="text" value="<?php echo $row['company_number'] ?>" name="company_number" placeholder="" class="input02">
            <label class="placeholder2">Contact Number</label>
        </div>
        </div> -->
        <div class="outer02">
            <div class="trial1">
            <input type="text" value="<?php echo $row['from'] ?>" name="from" placeholder="" class="input02">
            <label class="placeholder2">From</label>
            </div>
            <div class="trial1">
            <input type="text" value="<?php echo $row['from_pincode'] ?>" name="from_pincode"  placeholder="" class="input02">
            <label class="placeholder2">From Pincode</label>
            </div>
            </div>
            <div class="outer02">
            <div class="trial1">
            <input type="text" name="to" value="<?php echo $row['to'] ?>" placeholder="" class="input02">
            <label class="placeholder2">To</label>
            </div>
            <div class="trial1">
            <input type="text" value="<?php echo $row['to_pincode'] ?>" name="to_pincode" placeholder=""  class="input02">
            <label class="placeholder2">To Pincode</label>
            </div>

            </div>

        <div class="outer02">
        <div class="trial1">
            <select name="req_type" id=""  class="input02">
                <option value="" disabled selected>Type Of Requirement</option>
                <option <?php if($row['type_of_requirement']==='Budgeting'){ echo 'selected';} ?> value="Budgeting">Budgeting</option>
                <option <?php if($row['type_of_requirement']==='Immediate'){ echo 'selected';} ?> value="Immediate">Immediate</option>
            </select>
            </div>
            <div class="trial1">
                <input type="date" name="requirement_valid_till" value="<?php echo $row['requirement_valid_till'] ?>" placeholder="" class="input02" required>
                <label for="" class="placeholder2">Requirement Valid Till </label>
            </div>

            <!-- <div class="trial1">
                <input type="text" value="<?php echo $row['number_of_trailor'] ?>" placeholder="" name="no_of_trailor" class="input02">
                <label class="placeholder2">Number Of Trailor Required In Total</label>
            </div> -->
            </div>
            <div class="outer02">
                <div class="trial1">
                    <select name="dimension_unit" id="" class="input02" required>
                        <option value=""disabled selected>Dimensions Unit</option>
                        <option <?php if($row['dimension_unit']==='cm'){ echo 'selected';} ?> value="cm">cm</option>
                        <option <?php if($row['dimension_unit']==='inches'){ echo 'selected';} ?> value="inches">inches</option>
                        <option <?php if($row['dimension_unit']==='feet'){ echo 'selected';} ?> value="feet">feet</option>
                        <!-- <option value=""></option> -->
                    </select>
                </div>
                <div class="trial1">
                    <select name="weight_unit" id="" class="input02" required>
                        <option value=""disabled selected>Weight Unit</option>
                        <option <?php if($row['weight_unit']==='kgs'){ echo 'selected';} ?> value="kgs">kgs</option>
                        <option <?php if($row['weight_unit']==='ton'){ echo 'selected';} ?> value="ton">ton</option>
                    </select>
                </div>
            </div>

            <div class="outer02">
                <div class="trial1">
                    <input type="text" value="<?php echo $row['no_1_trailor'] ?>" name="1trailor" placeholder="" id="" class="input02 no_of_trailor1">
                    <label for="" class="placeholder2">No Of Trailor</label>
                </div>
            <div class="trial1"> 
            <select name="trailor_type" id="" class="input02">
                <option value="" disabled selected>Type</option>
                <option <?php if($row['trailor_type1']==='Axle'){ echo 'selected';} ?> value="Axle">Axle</option>
                <option <?php if($row['trailor_type1']==='LBT'){ echo 'selected';} ?> value="LBT">LBT</option>
                <option <?php if($row['trailor_type1']==='SLBT'){ echo 'selected';} ?> value="SLBT">SLBT</option>
                <option <?php if($row['trailor_type1']==='HBT'){ echo 'selected';} ?> value="HBT">HBT</option>
                <option <?php if($row['trailor_type1']==='Lorry'){ echo 'selected';} ?> value="Lorry">Lorry</option>
            </select>
            </div>

            <div class="trial1">
            <input type="text" value="<?php echo $row['length1'] ?>" name="Length" placeholder="" class="input02">
            <label class="placeholder2">Length</label>
            </div>
            <div class="trial1">
            <input type="text"  value="<?php echo $row['width1'] ?>" name="width" placeholder=""  class="input02">
            <label class="placeholder2">Width</label>
            </div>
            <div class="trial1">
            <input type="text"  value="<?php echo $row['height1'] ?>" name="height" placeholder=""  class="input02">
            <label class="placeholder2">Height</label>
            </div>
            <div class="trial1">
            <input type="text"  value="<?php echo $row['weight1'] ?>" name="weight" placeholder="" class="input02">
            <label class="placeholder2">Weight</label>
            </div>
            <div class="trial1 abcd" id="icon" <?php if(isset($row['no_2_trailor']) && !empty($row['no_2_trailor'])){ echo 'style="display:none"';} ?>>
            <i class="fa-solid fa-plus" onclick="addtrailor()"></i>
            </div>
            </div>
            
            <div class="outer02" id="add_trailor" <?php if(isset($row['no_2_trailor']) && !empty($row['no_2_trailor'])){ echo 'style="display: block;"'; } else { echo 'style="display: none;"'; } ?>>
            
            <!-- <br><br> -->
            <div class="cont">
            <div class="trial1">
                    <input type="text" value="<?php echo $row['no_2_trailor'] ?>" name="2trailor" placeholder="" id="" class="input02 no_of_trailor1">
                    <label for="" class="placeholder2">No Of Trailor</label>
                </div>

            <select name="trailor_type2" id="" class="input02">
                <option value="" disabled selected>Type </option>
                <option <?php if($row['trailor2']==='Axle'){ echo 'selected';} ?> value="Axle">Axle</option>
                <option <?php if($row['trailor2']==='LBT'){ echo 'selected';} ?> value="LBT">LBT</option>
                <option <?php if($row['trailor2']==='SLBT'){ echo 'selected';} ?> value="SLBT">SLBT</option>
                <option <?php if($row['trailor2']==='HBT'){ echo 'selected';} ?> value="HBT">HBT</option>
                <option <?php if($row['trailor2']==='Lorry'){ echo 'selected';} ?> value="Lorry">Lorry</option>
            </select>
            <div class="trial1">
            <input type="text" value="<?php echo $row['length2'] ?>" name="Length2" placeholder="" class="input02">
            <label class="placeholder2">Length</label>
            </div>
            <div class="trial1">
            <input type="text" name="width2" value="<?php echo $row['width2'] ?>" placeholder=""  class="input02">
            <label class="placeholder2">Width</label>
            </div>
            <div class="trial1">
            <input type="text" value="<?php echo $row['height2'] ?>" name="height2" placeholder=""  class="input02">
            <label class="placeholder2">Height</label>
            </div>
            <div class="trial1">
            <input type="text" value="<?php echo $row['weight2'] ?>" name="weight2" placeholder="" class="input02">
            <label class="placeholder2">Weight</label>
            </div>
            <div class="trial1 abcd" id="icon2" <?php if(isset($row['no_3_trailor']) && !empty($row['no_3_trailor'])){ echo 'style="display: none;"';}?>>
            <i class="fa-solid fa-plus" onclick="addtrailor2()"></i>
            </div>
            </div>
            </div>
            
            <div class="outer02" id="add_trailor2" <?php if(isset($row['no_3_trailor']) && !empty($row['no_3_trailor'])){ echo 'style="display: block;"';}else{ echo 'style="display: none;"';} ?> >
            <div class="cont">
            <div class="trial1">
                    <input type="text" name="3trailor"  value="<?php echo $row['no_3_trailor'] ?>" placeholder="" id="" class="input02 no_of_trailor1">
                    <label for="" class="placeholder2">No Of Trailor</label>
                </div>
            <select name="trailor_type3" id="" class="input02">
                <option value="" disabled selected>Type </option>
                <option <?php if($row['trailor3']==='Axle'){ echo 'selected';} ?> value="Axle">Axle</option>
                <option <?php if($row['trailor3']==='LBT'){ echo 'selected';} ?> value="LBT">LBT</option>
                <option <?php if($row['trailor3']==='SLBT'){ echo 'selected';} ?> value="SLBT">SLBT</option>
                <option <?php if($row['trailor3']==='HBT'){ echo 'selected';} ?> value="HBT">HBT</option>
                <option <?php if($row['trailor3']==='Lorry'){ echo 'selected';} ?> value="Lorry">Lorry</option>
            </select>
            
            <!-- <br><br> -->
            <div class="trial1">
            <input type="text" value="<?php echo $row['length3'] ?>" name="Length3" placeholder="" class="input02">
            <label class="placeholder2">Length</label>
            </div>
            <div class="trial1">
            <input type="text" value="<?php echo $row['width3'] ?>" name="width3" placeholder=""  class="input02">
            <label class="placeholder2">Width</label>
            </div>
            <div class="trial1">
            <input type="text" value="<?php echo $row['height3'] ?>" name="height3" placeholder=""  class="input02">
            <label class="placeholder2">Height</label>
            </div>
            <div class="trial1">
            <input type="text" value="<?php echo $row['weight3'] ?>" name="weight3" placeholder="" class="input02">
            <label class="placeholder2">Weight</label>
            </div>
            <div class="trial1 abcd" id="icon3" <?php if(isset($row['no_4_trailor']) && !empty($row['no_4_trailor'])){ echo 'style="display: none;"';}?>>
            <i class="fa-solid fa-plus" onclick="trailor4_required()"></i>
            </div>
            </div>
            </div>
            <!-- 4th trailor -->
            <div class="outer02" id="add_trailor4" <?php if(isset($row['no_4_trailor']) && !empty($row['no_4_trailor'])){ echo 'style="display: block;"';} else{ echo 'style="display: none;"';}?>>
            <div class="cont">
            <div class="trial1">
                    <input type="text" name="4trailor"  value="<?php echo $row['no_4_trailor'] ?>" placeholder="" id="" class="input02 no_of_trailor1">
                    <label for="" class="placeholder2">No Of Trailor</label>
                </div>
            <select name="trailor_type4" id="" class="input02">
                <option value="" disabled selected>Type </option>
                <option <?php if($row['trailor4']==='Axle'){ echo 'selected';} ?> value="Axle">Axle</option>
                <option <?php if($row['trailor4']==='LBT'){ echo 'selected';} ?> value="LBT">LBT</option>
                <option <?php if($row['trailor4']==='SLBT'){ echo 'selected';} ?> value="SLBT">SLBT</option>
                <option <?php if($row['trailor4']==='HBT'){ echo 'selected';} ?> value="HBT">HBT</option>
                <option <?php if($row['trailor4']==='Lorry'){ echo 'selected';} ?> value="Lorry">Lorry</option>
            </select>

            <div class="trial1">
            <input type="text" value="<?php echo $row['length4'] ?>" name="Length4" placeholder="" class="input02">
            <label class="placeholder2">Length</label>
            </div>
            <div class="trial1">
            <input type="text" value="<?php echo $row['width4'] ?>" name="width4" placeholder=""  class="input02">
            <label class="placeholder2">Width</label>
            </div>
            <div class="trial1">
            <input type="text" value="<?php echo $row['height4'] ?>" name="height4" placeholder=""  class="input02">
            <label class="placeholder2">Height</label>
            </div>
            <div class="trial1">
            <input type="text" value="<?php echo $row['weight4'] ?>" name="weight4" placeholder="" class="input02">
            <label class="placeholder2">Weight</label>
            </div>
            <div class="trial1 abcd" id="icon4" <?php if(isset($row['no_5_trailor']) && !empty($row['no_5_trailor'])){echo 'style="display:none"';} ?>>
            <i class="fa-solid fa-plus" onclick="trailor5_required()"></i>
            </div>
            </div>
            </div>

        <!-- 5th trailor -->
        <div class="outer02" id="add_trailor5" <?php if(isset($row['no_5_trailor']) && !empty($row['no_5_trailor'])){ echo 'style="display: block;"';} else{ echo 'style="display: none;"';}?>>
            <div class="cont">
            <div class="trial1">
                    <input type="text" name="5trailor"  value="<?php echo $row['no_5_trailor'] ?>" placeholder="" id="" class="input02 no_of_trailor1">
                    <label for="" class="placeholder2">No Of Trailor</label>
                </div>
            <select name="trailor_type5" id="" class="input02">
                <option value="" disabled selected>Type </option>
                <option <?php if($row['trailor5']==='Axle'){ echo 'selected';} ?> value="Axle">Axle</option>
                <option <?php if($row['trailor5']==='LBT'){ echo 'selected';} ?> value="LBT">LBT</option>
                <option <?php if($row['trailor5']==='SLBT'){ echo 'selected';} ?> value="SLBT">SLBT</option>
                <option <?php if($row['trailor5']==='HBT'){ echo 'selected';} ?> value="HBT">HBT</option>
                <option <?php if($row['trailor5']==='Lorry'){ echo 'selected';} ?> value="Lorry">Lorry</option>
            </select>

            <div class="trial1">
            <input type="text" value="<?php echo $row['length5'] ?>" name="Length5" placeholder="" class="input02">
            <label class="placeholder2">Length</label>
            </div>
            <div class="trial1">
            <input type="text" value="<?php echo $row['width5'] ?>" name="width5" placeholder=""  class="input02">
            <label class="placeholder2">Width</label>
            </div>
            <div class="trial1">
            <input type="text" value="<?php echo $row['height5'] ?>" name="height5" placeholder=""  class="input02">
            <label class="placeholder2">Height</label>
            </div>
            <div class="trial1">
            <input type="text" value="<?php echo $row['weight5'] ?>" name="weight5" placeholder="" class="input02">
            <label class="placeholder2">Weight</label>
            </div>
            <div class="trial1 abcd" id="icon5" <?php if(isset($row['no_6_trailor']) && !empty($row['no_6_trailor'])){echo 'style="display:none"';} ?>>
            <i class="fa-solid fa-plus" onclick="trailor6_required()"></i>
            </div>
            </div>
            </div>


<!-- 6th trailor  -->
<div class="outer02" id="add_trailor6" <?php if(isset($row['no_6_trailor']) && !empty($row['no_6_trailor'])){ echo 'style="display: block;"';} else{ echo 'style="display: none;"';}?>>
            <div class="cont">
            <div class="trial1">
                    <input type="text" name="6trailor"  value="<?php echo $row['no_6_trailor'] ?>" placeholder="" id="" class="input02 no_of_trailor1">
                    <label for="" class="placeholder2">No Of Trailor</label>
                </div>
            <select name="trailor_type6" id="" class="input02">
                <option value="" disabled selected>Type </option>
                <option <?php if($row['trailor6']==='Axle'){ echo 'selected';} ?> value="Axle">Axle</option>
                <option <?php if($row['trailor6']==='LBT'){ echo 'selected';} ?> value="LBT">LBT</option>
                <option <?php if($row['trailor6']==='SLBT'){ echo 'selected';} ?> value="SLBT">SLBT</option>
                <option <?php if($row['trailor6']==='HBT'){ echo 'selected';} ?> value="HBT">HBT</option>
                <option <?php if($row['trailor6']==='Lorry'){ echo 'selected';} ?> value="Lorry">Lorry</option>
            </select>

            <div class="trial1">
            <input type="text" value="<?php echo $row['length6'] ?>" name="Length6" placeholder="" class="input02">
            <label class="placeholder2">Length</label>
            </div>
            <div class="trial1">
            <input type="text" value="<?php echo $row['width6'] ?>" name="width6" placeholder=""  class="input02">
            <label class="placeholder2">Width</label>
            </div>
            <div class="trial1">
            <input type="text" value="<?php echo $row['height6'] ?>" name="height6" placeholder=""  class="input02">
            <label class="placeholder2">Height</label>
            </div>
            <div class="trial1">
            <input type="text" value="<?php echo $row['weight6'] ?>" name="weight6" placeholder="" class="input02">
            <label class="placeholder2">Weight</label>
            </div>
            <div class="trial1 abcd" id="icon6" <?php if(isset($row['no_7_trailor']) && !empty($row['no_7_trailor'])){echo 'style="display:none"';} ?>>
            <i class="fa-solid fa-plus" onclick="trailor7_required()"></i>
            </div>
            </div>
            </div>

            <!-- 7th trailor  -->

            <div class="outer02" id="add_trailor7" <?php if(isset($row['no_7_trailor']) && !empty($row['no_7_trailor'])){ echo 'style="display: block;"';} else{ echo 'style="display: none;"';}?>>
            <div class="cont">
            <div class="trial1">
                    <input type="text" name="7trailor"  value="<?php echo $row['no_7_trailor'] ?>" placeholder="" id="" class="input02 no_of_trailor1">
                    <label for="" class="placeholder2">No Of Trailor</label>
                </div>
            <select name="trailor_type7" id="" class="input02">
                <option value="" disabled selected>Type </option>
                <option <?php if($row['trailor7']==='Axle'){ echo 'selected';} ?> value="Axle">Axle</option>
                <option <?php if($row['trailor7']==='LBT'){ echo 'selected';} ?> value="LBT">LBT</option>
                <option <?php if($row['trailor7']==='SLBT'){ echo 'selected';} ?> value="SLBT">SLBT</option>
                <option <?php if($row['trailor7']==='HBT'){ echo 'selected';} ?> value="HBT">HBT</option>
                <option <?php if($row['trailor7']==='Lorry'){ echo 'selected';} ?> value="Lorry">Lorry</option>
            </select>

            <div class="trial1">
            <input type="text" value="<?php echo $row['length7'] ?>" name="Length7" placeholder="" class="input02">
            <label class="placeholder2">Length</label>
            </div>
            <div class="trial1">
            <input type="text" name="width7" value="<?php echo $row['width7'] ?>" placeholder=""  class="input02">
            <label class="placeholder2">Width</label>
            </div>
            <div class="trial1">
            <input type="text" value="<?php echo $row['height7'] ?>" name="height7" placeholder=""  class="input02">
            <label class="placeholder2">Height</label>
            </div>
            <div class="trial1">
            <input type="text" value="<?php echo $row['weight7'] ?>" name="weight7" placeholder="" class="input02">
            <label class="placeholder2">Weight</label>
            </div>
            <div class="trial1 abcd" id="icon7" <?php if(isset($row['no_8_trailor']) && !empty($row['no_8_trailor'])){echo 'style="display:none"';} ?>>
            <i class="fa-solid fa-plus" onclick="trailor8_required()"></i>
            </div>
            </div>
            </div>

<!-- 8th trailor  -->
<div class="outer02" id="add_trailor8" <?php if(isset($row['no_8_trailor']) && !empty($row['no_8_trailor'])){ echo 'style="display: block;"';} else{ echo 'style="display: none;"';}?>>
            <div class="cont">
            <div class="trial1">
                    <input type="text" name="8trailor"  value="<?php echo $row['no_8_trailor'] ?>" placeholder="" id="" class="input02 no_of_trailor1">
                    <label for="" class="placeholder2">No Of Trailor</label>
                </div>
            <select name="trailor_type8" id="" class="input02">
                <option value="" disabled selected>Type </option>
                <option <?php if($row['trailor8']==='Axle'){ echo 'selected';} ?> value="Axle">Axle</option>
                <option <?php if($row['trailor8']==='LBT'){ echo 'selected';} ?> value="LBT">LBT</option>
                <option <?php if($row['trailor8']==='SLBT'){ echo 'selected';} ?> value="SLBT">SLBT</option>
                <option <?php if($row['trailor8']==='HBT'){ echo 'selected';} ?> value="HBT">HBT</option>
                <option <?php if($row['trailor8']==='Lorry'){ echo 'selected';} ?> value="Lorry">Lorry</option>
            </select>

            <div class="trial1">
            <input type="text" value="<?php echo $row['length8'] ?>" name="Length8" placeholder="" class="input02">
            <label class="placeholder2">Length</label>
            </div>
            <div class="trial1">
            <input type="text" value="<?php echo $row['width8'] ?>" name="width8" placeholder=""  class="input02">
            <label class="placeholder2">Width</label>
            </div>
            <div class="trial1">
            <input type="text" value="<?php echo $row['height8'] ?>" name="height8" placeholder=""  class="input02">
            <label class="placeholder2">Height</label>
            </div>
            <div class="trial1">
            <input type="text" value="<?php echo $row['weight8'] ?>" name="weight8" placeholder="" class="input02">
            <label class="placeholder2">Weight</label>
            </div>
            <div class="trial1 abcd" id="icon8" <?php if(isset($row['no_9_trailor']) && !empty($row['no_9_trailor'])){echo 'style="display:none"';} ?>>
            <i class="fa-solid fa-plus" onclick="trailor9_required()"></i>
            </div>
            </div>
            </div>

            <!-- 9th trailor  -->
            <div class="outer02" id="add_trailor9" <?php if(isset($row['no_9_trailor']) && !empty($row['no_9_trailor'])){ echo 'style="display: block;"';} else{ echo 'style="display: none;"';}?>>
            <div class="cont">
            <div class="trial1">
                    <input type="text" name="9trailor"  value="<?php echo $row['no_9_trailor'] ?>" placeholder="" id="" class="input02 no_of_trailor1">
                    <label for="" class="placeholder2">No Of Trailor</label>
                </div>
            <select name="trailor_type9" id="" class="input02">
                <option value="" disabled selected>Type </option>
                <option <?php if($row['trailor9']==='Axle'){ echo 'selected';} ?> value="Axle">Axle</option>
                <option <?php if($row['trailor9']==='LBT'){ echo 'selected';} ?> value="LBT">LBT</option>
                <option <?php if($row['trailor9']==='SLBT'){ echo 'selected';} ?> value="SLBT">SLBT</option>
                <option <?php if($row['trailor9']==='HBT'){ echo 'selected';} ?> value="HBT">HBT</option>
                <option <?php if($row['trailor9']==='Lorry'){ echo 'selected';} ?> value="Lorry">Lorry</option>
            </select>

            <div class="trial1">
            <input type="text" value="<?php echo $row['length9'] ?>" name="Length9" placeholder="" class="input02">
            <label class="placeholder2">Length</label>
            </div>
            <div class="trial1">
            <input type="text" value="<?php echo $row['width9'] ?>"  name="width9" placeholder=""  class="input02">
            <label class="placeholder2">Width</label>
            </div>
            <div class="trial1">
            <input type="text" value="<?php echo $row['height9'] ?>" name="height9" placeholder=""  class="input02">
            <label class="placeholder2">Height</label>
            </div>
            <div class="trial1">
            <input type="text" value="<?php echo $row['weight9'] ?>" name="weight9" placeholder="" class="input02">
            <label class="placeholder2">Weight</label>
            </div>
            <div class="trial1 abcd" id="icon9" <?php if(isset($row['no_10_trailor']) && !empty($row['no_10_trailor'])){echo 'style="display:none"';} ?>>
            <i class="fa-solid fa-plus" onclick="trailor10_required()"></i>
            </div>
            </div>
            </div>

<!-- 10th trailor  -->
<div class="outer02" id="add_trailor10" <?php if(isset($row['no_10_trailor']) && !empty($row['no_10_trailor'])){ echo 'style="display: block;"';} else{ echo 'style="display: none;"';}?>>
            <div class="cont">
            <div class="trial1">
                    <input type="text" name="10trailor"  value="<?php echo $row['no_10_trailor'] ?>" placeholder="" id="" class="input02 no_of_trailor1">
                    <label for="" class="placeholder2">No Of Trailor</label>
                </div>
            <select name="trailor_type10" id="" class="input02">
                <option value="" disabled selected>Type</option>
                <option <?php if($row['trailor10']==='Axle'){ echo 'selected';} ?> value="Axle">Axle</option>
                <option <?php if($row['trailor10']==='LBT'){ echo 'selected';} ?> value="LBT">LBT</option>
                <option <?php if($row['trailor10']==='SLBT'){ echo 'selected';} ?> value="SLBT">SLBT</option>
                <option <?php if($row['trailor10']==='HBT'){ echo 'selected';} ?> value="HBT">HBT</option>
                <option <?php if($row['trailor10']==='Lorry'){ echo 'selected';} ?> value="Lorry">Lorry</option>
            </select>

            <div class="trial1">
            <input type="text" value="<?php echo $row['length10'] ?>" name="Length10" placeholder="" class="input02">
            <label class="placeholder2">Length</label>
            </div>
            <div class="trial1">
            <input type="text"  value="<?php echo $row['width10'] ?>" name="width10" placeholder=""  class="input02">
            <label class="placeholder2">Width</label>
            </div>
            <div class="trial1">
            <input type="text"  value="<?php echo $row['height10'] ?>" name="height10" placeholder=""  class="input02">
            <label class="placeholder2">Height</label>
            </div>
            <div class="trial1">
            <input type="text"  value="<?php echo $row['weight10'] ?>" name="weight10" placeholder="" class="input02">
            <label class="placeholder2">Weight</label>
            </div>
            <!-- <div class="trial1 abcd" id="icon10"> -->
            <!-- <i class="fa-solid fa-plus" onclick="trailor11_required()"></i> -->
            <!-- </div> -->
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
            <input type="text" name="Length11" placeholder="" class="input02">
            <label class="placeholder2">Length</label>
            </div>
            <div class="trial1">
            <input type="text" name="width11" placeholder=""  class="input02">
            <label class="placeholder2">Width</label>
            </div>
            <div class="trial1">
            <input type="text" name="height11" placeholder=""  class="input02">
            <label class="placeholder2">Height</label>
            </div>
            <div class="trial1">
            <input type="text" name="weight11" placeholder="" class="input02">
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
                    <option <?php if($row['rate_condition']==='With RTO'){ echo 'selected';} ?> value="With RTO">With RTO</option>
                    <option <?php if($row['rate_condition']==='Without RTO'){ echo 'selected';} ?> value="Without RTO">Without RTO</option>
                    <option <?php if($row['rate_condition']==='As Per Recipt From RTO'){ echo 'selected';} ?> value="As Per Recipt From RTO">As Per Recipt From RTO</option>
                </select>
            </div>
            <div class="trial1" >
                <input type="number" placeholder="" value="<?php echo $row['number_of_trailor'] ?>" id="totalno" name="no_of_trailor" class="input02">
                <label class="placeholder2"> Total Trailors</label>
            </div>
            </div>
            <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" name="contact_person" value="<?php echo $row['contact_person'] ?>" class="input02">
                <label for="" class="placeholder2">Contact Person</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" value="<?php echo $row['company_number'] ?>" name="company_number" class="input02">
                <label for="" class="placeholder2">Contact Number</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="email" value="<?php echo $row['email_need_generator'] ?>" class="input02">
                <label for="" class="placeholder2">Contact Email</label>
            </div>
            


            </div>
            <div class="outer02">
            <div class="trial1" id="advancepay">
            <select name="adv_payment"  id="advance_paymentdd" class="input02" onchange="advance_payment()" required>
                <option value="" disabled selected>Advance Payment</option>
                <option <?php if($row['adv_payment']==='Yes'){echo 'selected';} ?> value="Yes">Yes</option>
                <option <?php if($row['adv_payment']==='No'){echo 'selected';} ?> value="No">No</option>
            </select>
            </div>
            <div class="trial1" id="percent_payment">
                <select name="percent" id="" class="input02">
                    <option value=""disabled selected>Percent</option>
                    <option <?php if($row['adv_pay_percent']==='30%'){ echo 'selected';} ?> value="30%">30%</option>
                    <option <?php if($row['adv_pay_percent']==='40%'){ echo 'selected';} ?> value="40%">40%</option>
                    <option <?php if($row['adv_pay_percent']==='50%'){ echo 'selected';} ?> value="50%">50%</option>
                    <option <?php if($row['adv_pay_percent']==='60%'){ echo 'selected';} ?> value="60%">60%</option>
                    <option <?php if($row['adv_pay_percent']==='70%'){ echo 'selected';} ?> value="70%">70%</option>
                    <option <?php if($row['adv_pay_percent']==='80%'){ echo 'selected';} ?> value="80%">80%</option>
                </select>
            </div>
            <div class="trial1">
                    <!-- <input type="text" placeholder="" class="input02">
                    <label for="" class="placeholder2">Balance Payment</label> -->
                    <select name="balance_payment" id="" class="input02" required>
                        <option value=""disabled selected>Balance Payment </option>
                        <option <?php if($row['balance_pay']==='15 Days'){ echo 'selected';} ?> value="15 Days">15 Days After Unloading</option>
                        <option <?php if($row['balance_pay']==='30 Days'){ echo 'selected';} ?> value="30 Days">30 Days After Unloading</option>
                        <option <?php if($row['balance_pay']==='45 Days'){ echo 'selected';} ?> value="45 Days">45 Days After Unloading</option>
                        <option <?php if($row['balance_pay']==='60 Days'){ echo 'selected';} ?> value="60 Days">60 Days After Unloading</option>
                    </select>
                </div>

            </div>

            <!-- <div class="trial1">
            <select name="payment_terms"  id="" class="input02">
                <option value="" disabled selected>Payment terms</option>
                <option <?php if($row['payment_terms']==='Advance'){ echo 'selected';} ?> value="Advance">Advance</option>
                <option <?php if($row['payment_terms']==='Credit 30 Days'){ echo 'selected';} ?> value="Credit 30 Days">Credit 30 Days</option>
                <option <?php if($row['payment_terms']==='Credit 45 Days'){ echo 'selected';} ?> value="Credit 45 Days">Credit 45 Days</option>
            </select>
            </div> -->
            <button type="submit" class="logi_req">Edit Requirement</button>
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
    function advance_payment() {
    const advance_paymentdd = document.getElementById("advance_paymentdd");
    const percent_payment = document.getElementById("percent_payment");
    
    // Check if advance_paymentdd is not null before accessing its value
    if (advance_paymentdd && advance_paymentdd.value === 'Yes') {
        percent_payment.style.display = 'block';
    } else {
        percent_payment.style.display = 'none';
    }
}
document.addEventListener('DOMContentLoaded', function() {
            var selectElement = document.getElementById('advance_paymentdd');
            if (selectElement.value) { // Check if the dropdown is not empty
                advance_payment(); // Trigger the function
            }
        });
</script>
 </body>
</html>