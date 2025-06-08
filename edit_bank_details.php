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
$sql="SELECT * FROM `complete_profile` where companyname='$companyname001'";
$result=mysqli_query($conn,$sql);
if($result){
    $row=mysqli_fetch_assoc($result);
}
else{
    $row=array();
}
?>

<?php
if(isset($_POST['bank_edit_details'])){
    include "partials/_dbconnect.php";

    // Assign form inputs directly to variables (not sanitized)
    $nameoncheque = $_POST['nameoncheque'];
    $bankname = $_POST['bankname'];
    $acc_num = $_POST['acc_num'];
    $ifsc = $_POST['ifsc'];
    $branch = $_POST['branch'];
    $acc_type = $_POST['acc_type'];

    $sql_edit = "UPDATE `complete_profile` SET 
                 `name_on_cheque` = '$nameoncheque', 
                 `bank_name` = '$bankname', 
                 `account_num` = '$acc_num', 
                 `branch` = '$branch', 
                 `ifsc_code` = '$ifsc', 
                 `account_type` = '$acc_type'  
                 WHERE `companyname` = '$companyname001'";

    $result_edit = mysqli_query($conn, $sql_edit);

    if($result_edit){
        session_start();
        $_SESSION['bank_update_done']="bank details updated successfully";
        header("Location: complete_profile_new.php");
        exit(); // Ensure that script stops after redirection
    } 
    
    else{
        $_SESSION['basic_detail_error']="error";
        header("Location:complete_profile_new.php");

    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<form action="edit_bank_details.php" autocomplete="off" method="POST" class="profile">
    <div class="profile_container">
        <p>Bank Details</p>
        <div class="trial1">
            <input type="text" placeholder="" value="<?php echo $row['name_on_cheque'] ?>" name="nameoncheque" class="input02">
            <label for="" class="placeholder2">Name On Bank Cheque</label>
        </div>
        <div class="trial1">
            <!-- <input type="text" name="bankname" placeholder=""  class="input02">
            <label for="" class="placeholder2">Enter Bank Name</label> -->
            <select id="bankSelect" name="bankname" class="input02">
    <option value="">Select a Bank</option>
    <option <?php if($row['bank_name']==='Allahabad Bank'){ echo 'selected';} ?> value="Allahabad Bank">Allahabad Bank</option>
    <option <?php if($row['bank_name'] === 'Andhra Bank'){ echo 'selected';} ?> value="Andhra Bank">Andhra Bank</option>
<option <?php if($row['bank_name'] === 'Axis Bank'){ echo 'selected';} ?> value="Axis Bank">Axis Bank</option>
<option <?php if($row['bank_name'] === 'Bandhan Bank'){ echo 'selected';} ?> value="Bandhan Bank">Bandhan Bank</option>
<option <?php if($row['bank_name'] === 'Bank of Baroda'){ echo 'selected';} ?> value="Bank of Baroda">Bank of Baroda</option>
<option <?php if($row['bank_name'] === 'Bank of India'){ echo 'selected';} ?> value="Bank of India">Bank of India</option>
<option <?php if($row['bank_name'] === 'Bank of Maharashtra'){ echo 'selected';} ?> value="Bank of Maharashtra">Bank of Maharashtra</option>
<option <?php if($row['bank_name'] === 'Canara Bank'){ echo 'selected';} ?> value="Canara Bank">Canara Bank</option>
<option <?php if($row['bank_name'] === 'Central Bank of India'){ echo 'selected';} ?> value="Central Bank of India">Central Bank of India</option>
<option <?php if($row['bank_name'] === 'Citibank'){ echo 'selected';} ?> value="Citibank">Citibank</option>
<option <?php if($row['bank_name'] === 'Corporation Bank'){ echo 'selected';} ?> value="Corporation Bank">Corporation Bank</option>
<option <?php if($row['bank_name'] === 'DCB Bank'){ echo 'selected';} ?> value="DCB Bank">DCB Bank</option>
<option <?php if($row['bank_name'] === 'Dena Bank'){ echo 'selected';} ?> value="Dena Bank">Dena Bank</option>
<option <?php if($row['bank_name'] === 'Federal Bank'){ echo 'selected';} ?> value="Federal Bank">Federal Bank</option>
<option <?php if($row['bank_name'] === 'HDFC Bank'){ echo 'selected';} ?> value="HDFC Bank">HDFC Bank</option>
<option <?php if($row['bank_name'] === 'ICICI Bank'){ echo 'selected';} ?> value="ICICI Bank">ICICI Bank</option>
<option <?php if($row['bank_name'] === 'IDBI Bank'){ echo 'selected';} ?> value="IDBI Bank">IDBI Bank</option>
<option <?php if($row['bank_name'] === 'IDFC Bank'){ echo 'selected';} ?> value="IDFC Bank">IDFC Bank</option>
<option <?php if($row['bank_name'] === 'Indian Bank'){ echo 'selected';} ?> value="Indian Bank">Indian Bank</option>
<option <?php if($row['bank_name'] === 'Indian Overseas Bank'){ echo 'selected';} ?> value="Indian Overseas Bank">Indian Overseas Bank</option>
<option <?php if($row['bank_name'] === 'IndusInd Bank'){ echo 'selected';} ?> value="IndusInd Bank">IndusInd Bank</option>
<option <?php if($row['bank_name'] === 'Jammu and Kashmir Bank'){ echo 'selected';} ?> value="Jammu and Kashmir Bank">Jammu and Kashmir Bank</option>
<option <?php if($row['bank_name'] === 'Karnataka Bank'){ echo 'selected';} ?> value="Karnataka Bank">Karnataka Bank</option>
<option <?php if($row['bank_name'] === 'Karur Vysya Bank'){ echo 'selected';} ?> value="Karur Vysya Bank">Karur Vysya Bank</option>
<option <?php if($row['bank_name'] === 'Kotak Mahindra Bank'){ echo 'selected';} ?> value="Kotak Mahindra Bank">Kotak Mahindra Bank</option>
<option <?php if($row['bank_name'] === 'Lakshmi Vilas Bank'){ echo 'selected';} ?> value="Lakshmi Vilas Bank">Lakshmi Vilas Bank</option>
<option <?php if($row['bank_name'] === 'Nainital Bank'){ echo 'selected';} ?> value="Nainital Bank">Nainital Bank</option>
<option <?php if($row['bank_name'] === 'Oriental Bank of Commerce'){ echo 'selected';} ?> value="Oriental Bank of Commerce">Oriental Bank of Commerce</option>
<option <?php if($row['bank_name'] === 'Punjab National Bank'){ echo 'selected';} ?> value="Punjab National Bank">Punjab National Bank</option>
<option <?php if($row['bank_name'] === 'RBL Bank'){ echo 'selected';} ?> value="RBL Bank">RBL Bank</option>
<option <?php if($row['bank_name'] === 'South Indian Bank'){ echo 'selected';} ?> value="South Indian Bank">South Indian Bank</option>
<option <?php if($row['bank_name'] === 'State Bank of India'){ echo 'selected';} ?> value="State Bank of India">State Bank of India</option>
<option <?php if($row['bank_name'] === 'Syndicate Bank'){ echo 'selected';} ?> value="Syndicate Bank">Syndicate Bank</option>
<option <?php if($row['bank_name'] === 'UCO Bank'){ echo 'selected';} ?> value="UCO Bank">UCO Bank</option>
<option <?php if($row['bank_name'] === 'Union Bank of India'){ echo 'selected';} ?> value="Union Bank of India">Union Bank of India</option>
<option <?php if($row['bank_name'] === 'United Bank of India'){ echo 'selected';} ?> value="United Bank of India">United Bank of India</option>
<option <?php if($row['bank_name'] === 'Vijaya Bank'){ echo 'selected';} ?> value="Vijaya Bank">Vijaya Bank</option>
<option <?php if($row['bank_name'] === 'Yes Bank'){ echo 'selected';} ?> value="Yes Bank">Yes Bank</option>
</select>

        </div>
        <div class="trial1">
            <input type="text" name="acc_num" value="<?php echo $row['account_num'] ?>" placeholder="" class="input02">
            <label for="" class="placeholder2">Enter Bank Account Number</label>
        </div>
        <div class="trial1">
            <input type="text" name="ifsc" value="<?php echo $row['ifsc_code'] ?>" placeholder="" class="input02">
            <label for="" class="placeholder2">IFSC Code</label>
        </div>
        <div class="trial1">
            <input type="text" name="branch" value="<?php echo $row['branch'] ?>" placeholder="" class="input02">
            <label for="" class="placeholder2"> Branch</label>
        </div>
        <div class="trial1">
            <select name="acc_type" id="" class="input02">
                <option value=""disabled selected>Choose Account Type</option>
                <option <?php if($row['account_type']==='Current'){ echo 'selected';} ?>  value="Current">Current</option>
                <option <?php if($row['account_type']==='Savings'){ echo 'selected';} ?> value="Savings">Savings</option>
            </select>
        </div>
        <button class="basic-detail-button" name="bank_edit_details">Edit Details</button>
    </div>
</form>

</body>
</html>