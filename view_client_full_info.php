<?php
include_once 'partials/_dbconnect.php';
$view_id=$_GET['id'];

$sql="SELECT * FROM `billing_clients` where id='$view_id'";
$result=mysqli_query($conn , $sql);
$row=mysqli_fetch_assoc($result);


if($_SERVER["REQUEST_METHOD"] == "POST")
{
include_once 'partials/_dbconnect.php';
$editit=$_POST['editit'];
$client_name=$_POST['client_name'];
$lane1=$_POST['lane1'];
$lane2=$_POST['lane2'];
$pincode =$_POST['pincode'];
$state=$_POST['state'];
$gst=$_POST['gst'];

$sql_edit=("UPDATE `billing_clients` SET `name` = '$client_name', `lane_address1` = '$lane1', `lane_address2` = '$lane2', `pincode` = '$pincode', 
`state` = '$state', `gst` = '$gst' WHERE id = '$editit'");
$edit_result=mysqli_query($conn,$sql_edit);
if($edit_result){
    header("location:view_clients.php");
}



}
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
          <li><a href="<?php echo $dashboard_url ?>">Dashboard</a></li>
            <li><a href="news/">News</a></li>
            <!-- <li><a href="contact_us.php">Contact Us</a></li> -->
            <li><a href="logout.php">Log Out</a></li></ul>
        </div>
    </div>
    <form action="view_client_full_info.php" method="POST" class="bill_client">
        <div class="bill_client_container">
            <div class="client_heading">Edit Clients Details</div>
            <input hidden type="text" placeholder="id"  name="editit" value="<?php echo $view_id ?>">
            <div class="trial1">
                <input type="text" placeholder="" value="<?php echo $row['name'] ?>" name="client_name" class="input02">
                <label for="" class="placeholder2">Client Name</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" value="<?php echo $row['lane_address1'] ?>" name="lane1" class="input02">
                <label for="" class="placeholder2">Lane Address 1</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder=""  value="<?php echo $row['lane_address2'] ?>" name="lane2" class="input02">
                <label for="" class="placeholder2">Lane Address 2</label>
            </div>
            <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder=""  value="<?php echo $row['pincode'] ?>"name="pincode" class="input02">
                <label for="" class="placeholder2">Pincode</label>
            </div>
            <div class="trial1">
    <select name="state" id="state" class="input02" >
        <option value="" >Select State</option>
        <option value="Andhra Pradesh" <?php if($row['state']==='Andhra Pradesh'){echo 'selected';} ?>>Andhra Pradesh</option>
        <option value="Arunachal Pradesh" <?php if($row['state']==='Arunachal Pradesh'){echo 'selected';} ?>></option>
        <option value="Assam" <?php if($row['state']==='Assam'){echo 'selected';} ?>>Assam</option>
        <option value="Bihar" <?php if($row['state']==='Bihar'){echo 'selected';} ?>>Bihar</option>
        <option value="Chhattisgarh" <?php if($row['state']==='Chhattisgarh'){echo 'selected';} ?>>Chhattisgarh</option>
        <option value="Goa" <?php if($row['state']==='Goa'){echo 'selected';} ?>>Goa</option>
        <option value="Gujarat" <?php if($row['state']==='Gujarat'){echo 'selected';} ?>>Gujarat</option>
        <option value="Haryana" <?php if($row['state']==='Haryana'){echo 'selected';} ?>>Haryana</option>
        <option value="Himachal Pradesh" <?php if($row['state']==='Himachal Pradesh'){echo 'selected';} ?>>Himachal Pradesh</option>
        <option value="Jharkhand" <?php if($row['state']==='Jharkhand'){echo 'selected';} ?>>Jharkhand</option>
        <option value="Karnataka" <?php if($row['state']==='Karnataka'){echo 'selected';} ?>>Karnataka</option>
        <option value="Kerala" <?php if($row['state']==='Kerala'){echo 'selected';} ?>>Kerala</option>
        <option value="Madhya Pradesh" <?php if($row['state']==='Madhya Pradesh'){echo 'selected';} ?>>Madhya Pradesh</option>
        <option value="Maharashtra" <?php if($row['state']==='Maharashtra'){echo 'selected';} ?>>Maharashtra</option>
        <option value="Manipur" <?php if($row['state']==='Manipur'){echo 'selected';} ?>>Manipur</option>
        <option value="Meghalaya" <?php if($row['state']==='Meghalaya'){echo 'selected';} ?>>Meghalaya</option>
        <option value="Mizoram" <?php if($row['state']==='Mizoram'){echo 'selected';} ?>>Mizoram</option>
        <option value="Nagaland" <?php if($row['state']==='Nagaland'){echo 'selected';} ?>>Nagaland</option>
        <option value="Odisha" <?php if($row['state']==='Odisha'){echo 'selected';} ?>>Odisha</option>
        <option value="Punjab" <?php if($row['state']==='Punjab'){echo 'selected';} ?>>Punjab</option>
        <option value="Rajasthan" <?php if($row['state']==='Rajasthan'){echo 'selected';} ?>>Rajasthan</option>
        <option value="Sikkim" <?php if($row['state']==='Sikkim'){echo 'selected';} ?>>Sikkim</option>
        <option value="Tamil Nadu" <?php if($row['state']==='Tamil Nadu'){echo 'selected';} ?>>Tamil Nadu</option>
        <option value="Telangana" <?php if($row['state']==='Telangana'){echo 'selected';} ?>>Telangana</option>
        <option value="Tripura" <?php if($row['state']==='Tripura'){echo 'selected';} ?>>Tripura</option>
        <option value="Uttar Pradesh" <?php if($row['state']==='Uttar Pradesh'){echo 'selected';} ?>>Uttar Pradesh</option>
        <option value="Uttarakhand" <?php if($row['state']==='Uttarakhand'){echo 'selected';} ?>>Uttarakhand</option>
        <option value="West Bengal" <?php if($row['state']==='West Bengal'){echo 'selected';} ?>>West Bengal</option>
        <option value="Andaman and Nicobar Islands" <?php if($row['state']==='Andaman and Nicobar Islands'){echo 'selected';} ?>>Andaman and Nicobar Islands</option>
        <option value="Chandigarh" <?php if($row['state']==='Chandigarh'){echo 'selected';} ?>>Chandigarh</option>
        <option value="Dadra and Nagar Haveli" <?php if($row['state']==='Dadra and Nagar Haveli'){echo 'selected';} ?>>Dadra and Nagar Haveli</option>
        <option value="Daman and Diu" <?php if($row['state']==='Daman and Diu'){echo 'selected';} ?>>Daman and Diu</option>
        <option value="Lakshadweep" <?php if($row['state']==='Lakshadweep'){echo 'selected';} ?>>Lakshadweep</option>
        <option value="Delhi" <?php if($row['state']==='Delhi'){echo 'selected';} ?>>Delhi</option>
        <option value="Puducherry" <?php if($row['state']==='Puducherry'){echo 'selected';} ?>>Puducherry</option>
    </select>
            </div>
</div>            <div class="trial1">
                <input type="text" placeholder="" name="gst"  value="<?php echo $row['gst'] ?>" class="input02">
                <label for="" class="placeholder2">GSTN/UIN</label>
            </div>
            <br>
            <button type="submit" class="epc-button">Edit</button>
            <br>
        </div>
    </form>

</body>
</html>