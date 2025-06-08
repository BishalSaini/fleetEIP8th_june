<?php 
include "partials/_dbconnect.php";
session_start();
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

$sql = "SELECT * FROM `basic_details` where companyname='$companyname001'";
$result = mysqli_query($conn, $sql);
if ($result) {
    $row = mysqli_fetch_assoc($result);
} else {
    $row = array(); // Initialize empty array if no result
}

if (isset($_POST['submit_basic_Detail_form'])) {
    $basicdetail_companyname = $_POST['basicdetail_companyname'];
    $enterprise_type_basicdetail = $_POST['enterprise_type_basicdetail'];
    $companyaddress_basicdetail = $_POST['companyaddress_basicdetail'];
    
    // File upload handling
    if (isset($_FILES['company_logo_basic_Detial']) && $_FILES['company_logo_basic_Detial']['error'] === UPLOAD_ERR_OK) {
        $company_logo_basic_Detial = $_FILES['company_logo_basic_Detial']['name'];
        $temp_file = $_FILES['company_logo_basic_Detial']['tmp_name'];
        $folder13 = 'img/' . $company_logo_basic_Detial;
        move_uploaded_file($temp_file, $folder13);
    } else {
        // Handle case where no file was uploaded or there was an error
        $company_logo_basic_Detial = $row['companylogo']; // Default to existing value
    }

    $state_basic_detial = $_POST['state_basic_detial'];
    $pincode_basicdetial = $_POST['pincode_basicdetial'];
    $cont_new = $_POST['cont_new'];
    $add_service_new = $_POST['add_service_new'];
    $companywebaddress=$_POST['companywebaddress'];

    // Update SQL query
    $sql_edit = "UPDATE `basic_details` SET `companylogo` = '$company_logo_basic_Detial', 
                `company_address` = '$companyaddress_basicdetail', `state` = '$state_basic_detial', 
                `pincode` = '$pincode_basicdetial', `office_number` = '$cont_new', 
                `add_on_services` = '$add_service_new', `enterprise_type` = '$enterprise_type_basicdetail', `website`='$companywebaddress'
                WHERE `companyname` = '$companyname001'";
    
    $result_edit = mysqli_query($conn, $sql_edit);

    $sqlwebsite_address="UPDATE `login` SET `webiste_address` = '$companywebaddress' WHERE companyname='$companyname001'";
    $result_address=mysqli_query($conn,$sqlwebsite_address);

    if ($result_edit && $result_address) {
        $_SESSION['basic_detail_success'] = "success";
        header("Location: complete_profile_new.php");
        exit;
    } else {
        $_SESSION['basic_detail_error'] = "error";
        header("Location: complete_profile_new.php");
        exit;
    }
}

$sql_website="SELECT * FROM `login` where companyname='$companyname001'";
$website=mysqli_query($conn,$sql_website);
$row_website=mysqli_fetch_assoc($website);
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
<form action="edit_basic_detail.php" method="POST" enctype="multipart/form-data" autocomplete="off" class="basic_detailsform" id="edit_basic">
    <div class="comp_logo_andname"><img src="img/<?php echo $row['companylogo'] ?>" alt=""><h4><?php echo $companyname001 ?></h4></div>
                        <div class="basic_detail_container_form">
                <p>Enter Basic Details</p>
            <div class="trial1">
            <input type="text" name="basicdetail_companyname" placeholder="" value="<?php echo $companyname001 ?>" class="input02" readonly>
            <label for="" class="placeholder2">Company Name</label>
            </div>
            <div class="trial1">
                <input type="file" name="company_logo_basic_Detial" placeholder="" value="" class="input02" >
                <label for="" class="placeholder2">Company Logo</label>
            </div>

            <div class="trial1 hideit">
                <input type="text" name="enterprise_type_basicdetail" placeholder=""  value="<?php echo strtoupper($row['enterprise_type']); ?>" class="input02" readonly>
                <label for="" class="placeholder2">Enterprise Type</label>
            </div>
            <div class="trial1">
            <textarea type="text" name="companyaddress_basicdetail" value="" class="input02" required><?php echo $row['company_address']; ?></textarea>
            <label for="" class="placeholder2">Company Address</label>
            </div>
            <div class="outer02">
            <div class="trial1">
            <select name="state_basic_detial" id="state" class="input02" required>
    <option value="">Select State</option>
    <option <?php if($row['state']==='Andaman and Nicobar Islands'){ echo 'selected';} ?> value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
<option <?php if($row['state']==='Andhra Pradesh'){ echo 'selected';} ?> value="Andhra Pradesh">Andhra Pradesh</option>
<option <?php if($row['state']==='Arunachal Pradesh'){ echo 'selected';} ?> value="Arunachal Pradesh">Arunachal Pradesh</option>
<option <?php if($row['state']==='Assam'){ echo 'selected';} ?> value="Assam">Assam</option>
<option <?php if($row['state']==='Bihar'){ echo 'selected';} ?> value="Bihar">Bihar</option>
<option <?php if($row['state']==='Chandigarh'){ echo 'selected';} ?> value="Chandigarh">Chandigarh</option>
<option <?php if($row['state']==='Chhattisgarh'){ echo 'selected';} ?> value="Chhattisgarh">Chhattisgarh</option>
<option <?php if($row['state']==='Dadra and Nagar Haveli'){ echo 'selected';} ?> value="Dadra and Nagar Haveli">Dadra and Nagar Haveli</option>
<option <?php if($row['state']==='Daman and Diu'){ echo 'selected';} ?> value="Daman and Diu">Daman and Diu</option>
<option <?php if($row['state']==='Delhi'){ echo 'selected';} ?> value="Delhi">Delhi</option>
<option <?php if($row['state']==='Goa'){ echo 'selected';} ?> value="Goa">Goa</option>
<option <?php if($row['state']==='Gujarat'){ echo 'selected';} ?> value="Gujarat">Gujarat</option>
<option <?php if($row['state']==='Haryana'){ echo 'selected';} ?> value="Haryana">Haryana</option>
<option <?php if($row['state']==='Himachal Pradesh'){ echo 'selected';} ?> value="Himachal Pradesh">Himachal Pradesh</option>
<option <?php if($row['state']==='Jammu and Kashmir'){ echo 'selected';} ?> value="Jammu and Kashmir">Jammu and Kashmir</option>
<option <?php if($row['state']==='Jharkhand'){ echo 'selected';} ?> value="Jharkhand">Jharkhand</option>
<option <?php if($row['state']==='Karnataka'){ echo 'selected';} ?> value="Karnataka">Karnataka</option>
<option <?php if($row['state']==='Kerala'){ echo 'selected';} ?> value="Kerala">Kerala</option>
<option <?php if($row['state']==='Lakshadweep'){ echo 'selected';} ?> value="Lakshadweep">Lakshadweep</option>
<option <?php if($row['state']==='Madhya Pradesh'){ echo 'selected';} ?> value="Madhya Pradesh">Madhya Pradesh</option>
<option <?php if($row['state']==='Maharashtra'){ echo 'selected';} ?> value="Maharashtra">Maharashtra</option>
<option <?php if($row['state']==='Manipur'){ echo 'selected';} ?> value="Manipur">Manipur</option>
<option <?php if($row['state']==='Meghalaya'){ echo 'selected';} ?> value="Meghalaya">Meghalaya</option>
<option <?php if($row['state']==='Mizoram'){ echo 'selected';} ?> value="Mizoram">Mizoram</option>
<option <?php if($row['state']==='Nagaland'){ echo 'selected';} ?> value="Nagaland">Nagaland</option>
<option <?php if($row['state']==='Odisha'){ echo 'selected';} ?> value="Odisha">Odisha</option>
<option <?php if($row['state']==='Puducherry'){ echo 'selected';} ?> value="Puducherry">Puducherry</option>
<option <?php if($row['state']==='Punjab'){ echo 'selected';} ?> value="Punjab">Punjab</option>
<option <?php if($row['state']==='Rajasthan'){ echo 'selected';} ?> value="Rajasthan">Rajasthan</option>
<option <?php if($row['state']==='Sikkim'){ echo 'selected';} ?> value="Sikkim">Sikkim</option>
<option <?php if($row['state']==='Tamil Nadu'){ echo 'selected';} ?> value="Tamil Nadu">Tamil Nadu</option>
<option <?php if($row['state']==='Telangana'){ echo 'selected';} ?> value="Telangana">Telangana</option>
<option <?php if($row['state']==='Tripura'){ echo 'selected';} ?> value="Tripura">Tripura</option>
<option <?php if($row['state']==='Uttar Pradesh'){ echo 'selected';} ?> value="Uttar Pradesh">Uttar Pradesh</option>
<option <?php if($row['state']==='Uttarakhand'){ echo 'selected';} ?> value="Uttarakhand">Uttarakhand</option>
<option <?php if($row['state']==='West Bengal'){ echo 'selected';} ?> value="West Bengal">West Bengal</option>
</select>

            </div>
            <div class="trial1">
                <input type="text" value="<?php echo $row['pincode'] ?>" name="pincode_basicdetial" class="input02" required>
                <label for="" class="placeholder2">Pincode</label>
            </div>

            </div>
            <div class="trial1">
            <input type="text" placeholder="" value="<?php echo $row_website['webiste_address'] ?>" name="companywebaddress" class="input02">
            <label for="" class="placeholder2">Website Address</label>
        </div>

            <div class="trial1">
            <input type="text" value="<?php echo $row['office_number'] ?>" name="cont_new"  placeholder="" class="input02" required>
            <label for="" class="placeholder2">Office Number</label>
        </div>
        <div class="trial1 <?php echo $enterprise === 'logistics' ? 'hideit' : ''; ?>" id="Info_Outer">
            <select name="add_service_new" id="_info" class="input02" >
                <option value=""disabled selected>Choose Add On Services</option>
                <option <?php if($row['add_on_services']==='RMC Plant'){ echo 'selected';} ?> value="RMC Plant">Dedicated RMC Plant</option>
<option <?php if($row['add_on_services']==='Foundation Work'){ echo 'selected';} ?> value="Foundation Work">Piling Contract</option>
<option <?php if($row['add_on_services']==='RMC Plant And Foundation Work'){ echo 'selected';} ?> value="RMC Plant And Foundation Work">RMC Plant And Foundation Work</option>
<option <?php if($row['add_on_services']==='None'){ echo 'selected';} ?> value="None">None</option>
            </select>
        </div>
        <div class="trial1" >
            <select name="rmc_type_new" id="rmc_Type" class="input02" onchange="Rmc_Location()">
                <option value=""disabled selected>RMC Type</option>
                <option value="Dedicated">Dedicated</option>
                <option value="Commercial">Commercial</option>

            </select>
        </div>
        <div class="outer02" >
            <div class="trial1" id="Rmc_loca_outer">
                <input type="text" name="rmc_loca_new"  placeholder="" class="input02">
                <label for="" class="placeholder2">RMC Location</label>
            </div>
            <div class="trial1" id="Rmc_loca_outer2">
                <input type="text" name="rmc_pin_new"  placeholder="" class="input02">
                <label for="" class="placeholder2">RMC Pincode</label>
            </div>
        </div>
        <!-- <div class="addnew_office"><i class="fas fa-plus-circle"></i></div> -->


 <button class="basic-detail-button" name="submit_basic_Detail_form" >Submit</button>


            </div>
        </form>

</body>
</html>