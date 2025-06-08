<?php 
session_start();
$enterprise=$_SESSION['enterprise'];

$companyname001 = $_SESSION['companyname'];
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
$id=$_GET['id'];
include "partials/_dbconnect.php";
$sql="SELECT * FROM `rentalclient_basicdetail` where id='$id'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);


if($_SERVER['REQUEST_METHOD']==='POST'){
    include "partials/_dbconnect.php";
    $client_name=$_POST['client_name'];
    $editid=$_POST['editid'];
    $hqaddress=$_POST['hqaddress'];
    $KAM=$_POST['KAM'] ?? '';
    $clientstate=$_POST['clientstate'] ?? '';

    $gst=$_POST['gst'];
    $payment_terms=$_POST['payment_terms'] ?? '';
    $adv_payment=$_POST['adv_payment'] ?? '';
    $working_days=$_POST['working_days'];
    $engine_hours=$_POST['engine_hours'];


    $edit="UPDATE `rentalclient_basicdetail` SET `gst`='$gst',`payment_terms`='$payment_terms',`adv_payment`='$adv_payment',`working_days`='$working_days',`engine_hours`='$engine_hours',`clientname`='$client_name',`hqaddress`='$hqaddress',`KAM`='$KAM',`state`='$clientstate' WHERE id='$editid' and companyname='$companyname001'";
    // $editallname="UPDATE `rentalclients` SET `clientname`='$client_name' where clientid='$editid'";
    $resultall=mysqli_query($conn,$edit);

    $rentalclientedit="UPDATE `rentalclients` SET `gst`='$gst',`payment_terms`='$payment_terms',`adv_payment`='$adv_payment',`working_days`='$working_days',`engine_hours`='$engine_hours',`clientname`='$client_name',`clientaddress`='$hqaddress',`handled_by`='$KAM' WHERE clientid='$editid' and companyname='$companyname001'";
    $rentalclientresult=mysqli_query($conn,$rentalclientedit);

    $editregionaloffice="UPDATE `regional_office` SET `clientname`='$client_name' where clientid='$editid'";
    $regionaresult=mysqli_query($conn,$editregionaloffice);

    $editsiteoffice="UPDATE `site_office` SET `clientname`='$client_name' where clientid='$editid'";
    $siteresult=mysqli_query($conn,$editsiteoffice);

    $resultedit=mysqli_query($conn,$edit);
    if($resultedit){
        session_start();
        $_SESSION['success']='success';
        header("Location:rentalclientdetail.php?id=".urldecode($editid));
    }
    else{
        $_SESSION['error']='success';
        header("Location:rentalclientdetail.php?id=".urldecode($editid));

    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
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
            <!-- <li><a href="contact_us.php">Contact Us</a></li> -->
            <li><a href="logout.php">Log Out</a></li></ul>
        </div>
    </div>
    <form action="editclientbasicdetail.php" method="POST" autocomplete="off" class="editclientbasicdetailform">
        <div class="editclientcontainer">
            <p class="headingpara">Edit Client</p>
            <input type="hidden" name="editid" value="<?php echo $id ;?>">
            <div class="trial1">
                <input type="text" name="client_name" value="<?php echo $row['clientname'] ?>" placeholder="" class="input02" >
                <label for="" class="placeholder2">Name</label>
            </div>
            <div class="trial1">
            <textarea name="hqaddress" id="" class="input02"><?php echo $row['hqaddress'] ?></textarea>
            <label for="" class="placeholder2">HQ Address</label>

            </div>
            <div class="outer02">
            <div class="trial1">
                <select name="KAM" id="" class="input02">
                    <option value=""disabled selected>KAM</option>
                    <?php
                    include "partials/_dbconnect.php";
                    $kam="SELECT * FROM `team_members` where company_name='$companyname001' and department='marketing' or company_name='$companyname001' and department='Management'";
                    $kamresult=mysqli_query($conn,$kam);
                    if(mysqli_num_rows($kamresult)>0){
                        while($rowkam=mysqli_fetch_assoc($kamresult)){
                            ?>
                            <option <?php if($row['KAM']===$rowkam['name']){ echo 'selected';} ?> value="<?php echo $rowkam['name'] ?>"><?php echo 'KAM : ' .$rowkam['name'] ?></option>
                            <?php
                        }

                        
                    }
                    ?>

                </select>
            </div>
            <div class="trial1">
            <select name="clientstate" id="" class="input02">
                <option value=""disabled selected>State</option>
                <option <?php if($row['state'] === 'Andhra Pradesh') { echo 'selected'; } ?> value="Andhra Pradesh">Andhra Pradesh</option>
    <option <?php if($row['state'] === 'Arunachal Pradesh') { echo 'selected'; } ?> value="Arunachal Pradesh">Arunachal Pradesh</option>
    <option <?php if($row['state'] === 'Assam') { echo 'selected'; } ?> value="Assam">Assam</option>
    <option <?php if($row['state'] === 'Bihar') { echo 'selected'; } ?> value="Bihar">Bihar</option>
    <option <?php if($row['state'] === 'Chandigarh') { echo 'selected'; } ?> value="Chandigarh">Chandigarh</option>
    <option <?php if($row['state'] === 'Chhattisgarh') { echo 'selected'; } ?> value="Chhattisgarh">Chhattisgarh</option>
    <option <?php if($row['state'] === 'Dadra and Nagar Haveli and Daman and Diu') { echo 'selected'; } ?> value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and Daman and Diu</option>
    <option <?php if($row['state'] === 'Delhi') { echo 'selected'; } ?> value="Delhi">Delhi</option>
    <option <?php if($row['state'] === 'Goa') { echo 'selected'; } ?> value="Goa">Goa</option>
    <option <?php if($row['state'] === 'Gujarat') { echo 'selected'; } ?> value="Gujarat">Gujarat</option>
    <option <?php if($row['state'] === 'Haryana') { echo 'selected'; } ?> value="Haryana">Haryana</option>
    <option <?php if($row['state'] === 'Himachal Pradesh') { echo 'selected'; } ?> value="Himachal Pradesh">Himachal Pradesh</option>
    <option <?php if($row['state'] === 'Jammu and Kashmir') { echo 'selected'; } ?> value="Jammu and Kashmir">Jammu and Kashmir</option>
    <option <?php if($row['state'] === 'Jharkhand') { echo 'selected'; } ?> value="Jharkhand">Jharkhand</option>
    <option <?php if($row['state'] === 'Karnataka') { echo 'selected'; } ?> value="Karnataka">Karnataka</option>
    <option <?php if($row['state'] === 'Kerala') { echo 'selected'; } ?> value="Kerala">Kerala</option>
    <option <?php if($row['state'] === 'Ladakh') { echo 'selected'; } ?> value="Ladakh">Ladakh</option>
    <option <?php if($row['state'] === 'Lakshadweep') { echo 'selected'; } ?> value="Lakshadweep">Lakshadweep</option>
    <option <?php if($row['state'] === 'Madhya Pradesh') { echo 'selected'; } ?> value="Madhya Pradesh">Madhya Pradesh</option>
    <option <?php if($row['state'] === 'Maharashtra') { echo 'selected'; } ?> value="Maharashtra">Maharashtra</option>
    <option <?php if($row['state'] === 'Manipur') { echo 'selected'; } ?> value="Manipur">Manipur</option>
    <option <?php if($row['state'] === 'Meghalaya') { echo 'selected'; } ?> value="Meghalaya">Meghalaya</option>
    <option <?php if($row['state'] === 'Mizoram') { echo 'selected'; } ?> value="Mizoram">Mizoram</option>
    <option <?php if($row['state'] === 'Nagaland') { echo 'selected'; } ?> value="Nagaland">Nagaland</option>
    <option <?php if($row['state'] === 'Odisha') { echo 'selected'; } ?> value="Odisha">Odisha</option>
    <option <?php if($row['state'] === 'Puducherry') { echo 'selected'; } ?> value="Puducherry">Puducherry</option>
    <option <?php if($row['state'] === 'Punjab') { echo 'selected'; } ?> value="Punjab">Punjab</option>
    <option <?php if($row['state'] === 'Rajasthan') { echo 'selected'; } ?> value="Rajasthan">Rajasthan</option>
    <option <?php if($row['state'] === 'Sikkim') { echo 'selected'; } ?> value="Sikkim">Sikkim</option>
    <option <?php if($row['state'] === 'Tamil Nadu') { echo 'selected'; } ?> value="Tamil Nadu">Tamil Nadu</option>
    <option <?php if($row['state'] === 'Telangana') { echo 'selected'; } ?> value="Telangana">Telangana</option>
    <option <?php if($row['state'] === 'Tripura') { echo 'selected'; } ?> value="Tripura">Tripura</option>
    <option <?php if($row['state'] === 'Uttar Pradesh') { echo 'selected'; } ?> value="Uttar Pradesh">Uttar Pradesh</option>
    <option <?php if($row['state'] === 'Uttarakhand') { echo 'selected'; } ?> value="Uttarakhand">Uttarakhand</option>
    <option <?php if($row['state'] === 'West Bengal') { echo 'selected'; } ?> value="West Bengal">West Bengal</option>

</select>
        </div>


            </div>
            <div class="outer02">
            <div class="trial1">
                <input type="text" value="<?php echo $row['gst'] ?>" placeholder="" name="gst" class="input02">
                <label for="" class="placeholder2">Gst Number</label>
            </div>
            <div class="trial1">
                <select name="adv_payment" id="" class="input02">
                    <option value=""disabled selected>Advance Payment</option>
                    <option <?php if($row['adv_payment']==='Yes'){echo 'selected';} ?> value="Yes">Advance Payment : Yes</option>
                    <option <?php if($row['adv_payment']==='No'){echo 'selected';} ?> value="No">Advance Payment : No</option>
                </select>
            </div>

            <select name="payment_terms" id="" class="input02">
                <option value=""disabled selected>Payment Terms</option>
                <option <?php if($row['payment_terms']==='within 7 days of invoice submission'){echo 'selected';} ?> value="within 7 days Of invoice submission">Payment term : within 7 Days Of invoice submission</option>
        <option <?php if($row['payment_terms']==='within 10 days Of invoice submission'){echo 'selected';} ?> value="within 10 days Of invoice submission">Payment term : within 10 Days Of invoice submission</option>
        <option <?php if($row['payment_terms']==='within 30 days Of invoice submission'){echo 'selected';} ?> value="within 30 days Of invoice submission">Payment term : within 30 Days Of invoice submission</option>
        <option <?php if($row['payment_terms']==='within 45 days Of invoice submission'){echo 'selected';} ?> value="within 45 days Of invoice submission">Payment term : within 45 Days Of invoice submission</option>

            </select>
        </div>
        <div class="outer02">
    <div class="trial1">
    <select name="working_days" id="" class="input02">
    <option value=""disabled selected>Select Working Days</option>
    <option <?php if($row['working_days']==='26'){echo 'selected';} ?> value="26">Working Days - 26 Days</option>
    <option <?php if($row['working_days']==='27'){echo 'selected';} ?> value="27">Working Days - 27 Days</option>
    <option <?php if($row['working_days']==='28'){echo 'selected';} ?> value="28">Working Days - 28 Days</option>
    <option <?php if($row['working_days']==='29'){echo 'selected';} ?> value="29">Working Days - 29 Days</option>
    <option <?php if($row['working_days']==='30'){echo 'selected';} ?> value="30">Working Days - 30 Days</option>
</select>

    </div>
    <div class="trial1">
        <select name="engine_hours" id="" class="input02">
            <option value=""disabled selected>Select Engine Hours</option>
            <option <?php if($row['engine_hours']==='200'){echo 'selected';} ?> value="200">Working Hours - 200 Hours</option>
            <option <?php if($row['engine_hours']==='208'){echo 'selected';} ?> value="208">Working Hours - 208 Hours</option>
            <option <?php if($row['engine_hours']==='260'){echo 'selected';} ?> value="260">Working Hours - 260 Hours</option>
            <option <?php if($row['engine_hours']==='270'){echo 'selected';} ?> value="270">Working Hours - 270 Hours</option>
            <option <?php if($row['engine_hours']==='280'){echo 'selected';} ?> value="280">Working Hours - 280 Hours</option>
            <option <?php if($row['engine_hours']==='300'){echo 'selected';} ?> value="300">Working Hours - 300 Hours</option>
            <option <?php if($row['engine_hours']==='312'){echo 'selected';} ?> value="312">Working Hours - 312 Hours</option>
            <option <?php if($row['engine_hours']==='360'){echo 'selected';} ?> value="360">Working Hours - 360 Hours</option>
            <option <?php if($row['engine_hours']==='400'){echo 'selected';} ?> value="400">Working Hours - 400 Hours</option>
            <option <?php if($row['engine_hours']==='416'){echo 'selected';} ?> value="416">Working Hours - 416 Hours</option>
            <option <?php if($row['engine_hours']==='460'){echo 'selected';} ?> value="460">Working Hours - 460 Hours</option>
            <option <?php if($row['engine_hours']==='572'){echo 'selected';} ?> value="572">Working Hours - 572 Hours</option>
            <option <?php if($row['engine_hours']==='672'){echo 'selected';} ?> value="672">Working Hours - 672 Hours</option>
            <option <?php if($row['engine_hours']==='720'){echo 'selected';} ?> value="720">Working Hours - 720 Hours</option>
        </select>
    </div>
</div>

            <button class="epc-button">Edit</button>
        </div>
    </form>
</body>
</html>