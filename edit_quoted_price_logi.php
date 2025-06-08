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


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'partials/_dbconnect.php';
    $edit_id1 = $_POST["edit"];
    $trailor1_price=$_POST['trailor1_price'];
    $trailor2_price=$_POST['trailor2_price'];
    $trailor3_price=$_POST['trailor3_price'];
    $trailor4_price=$_POST['trailor4_price'];
    $trailor5_price=$_POST['trailor5_price'];
    $trailor6_price=$_POST['trailor6_price'];
    $trailor7_price=$_POST['trailor7_price'];
    $trailor8_price=$_POST['trailor8_price'];
    $trailor9_price=$_POST['trailor9_price'];
    $trailor10_price=$_POST['trailor10_price'];
    $price_quote=$_POST['price_quote'];
    // $req_generated_email = $_POST["email123"];
    // $req_generated_company = $_POST["company"];
    // $req_generated_company_contact = $_POST["company_number"];
    // $material_detail = $_POST["material"];
    // $req_type = $_POST["req_type"];
    // $trailor_type = $_POST["trailor_type"];
    // $length1 = $_POST["length"];
    // $width1 = $_POST["width"];
    // $height1 = $_POST["height"];
    // $weight1 = $_POST["weight"];
    // $from1 = $_POST["from"];
    // $from1_pincode = $_POST["from_pincode"];
    // $to1 = $_POST["to"];
    // $to1_pincode = $_POST["to_pincode"];
    // // $payment = $_POST["payment_terms"];
    // $quote_price = $_POST["price_quote"];
    // $logi_comp = $_POST["logi_company"];
    $logi_number = $_POST["logi_number"];
    $logi_email = $_POST["logi_email"];



    $sql_update="UPDATE `logi_price_quoted` SET `quote_price` = '$price_quote', `trailor1_price` = '$trailor1_price',
     `trailor2_price` = '$trailor2_price', `trailor3_price` = '$trailor3_price', `trailor4_price` = '$trailor4_price', `trailor5_price` = '$trailor5_price', 
     `trailor6_price` = '$trailor6_price', `trailor7_price` = '$trailor7_price', `trailor8_price` = '$trailor8_price', `trailor9_price` = '$trailor9_price', 
     `trailor10_price` = '$trailor10_price', `logistic_company_number` = '$logi_number', `logistic_company_email` = '$logi_email' WHERE req_no ='$edit_id1'";

    // $sql_update ="UPDATE `logi_price_quoted` SET quote_price ='$quote_price' , logistic_company_number = '$logi_number' where req_no ='$edit_id1' ";
    $result = mysqli_query($conn,$sql_update);
    if($result){
        session_start();
        $_SESSION['success']="success";
        header("location:quoted_price_logistics.php");
    }
    else{
        session_start();
        $_SESSION['error']="success";
        header("location:quoted_price_logistics.php");

    }
   
}
?>
<?php
    include 'partials/_dbconnect.php';

$price_edit_id = $_GET['id'];
$sql_table="SELECT * FROM `logi_price_quoted` where id='$price_edit_id' ";
$result = mysqli_query($conn,$sql_table);
$row = mysqli_fetch_assoc($result);

$req_no = $row['req_no']; // Fetch the value from $row
$sql_logineed = "SELECT * FROM `logistics_need` WHERE id = $req_no";
$result_logi=mysqli_query($conn,$sql_logineed);
$row1=mysqli_fetch_assoc($result_logi);
?>
<script>
    <?php include "main.js" ?>
    </script>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">      
    <link rel="icon" href="favicon.jpg" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                <!-- <li><a href="about_us.html">About Us</a></li>
                <li><a href="contact_us.php">Contact Us</a></li> -->
                <li><a href="logout.php">LogOut</a></li>
            </ul>
        </div>
    </div>
    <form action="edit_quoted_price_logi.php" method="POST" class="logistics_need_form">
        <div class="logistic_need_container">
        <div class="logistics_heading"><h2 class="logistics_need_heading">Logistics Need</h2></div>
        <input type="text" name="edit" placeholder="" value="<?php echo $row['req_no']; ?>" class="input02" hidden>
        <div class="outer02">
        <div class="trial1 hideit">
            <input type="text" name="company" placeholder="" value="<?php echo $row['requirement_company_name']; ?>" class="input02" readonly>
            <label class="placeholder2">Company Name</label>
        </div>
        <div class="trial1">
            <input type="text" name="email123" placeholder="" value="<?php echo $row['requirement_company_email']; ?>"  class="input02" readonly>
            <label class="placeholder2">Email</label>
        </div>

        <div class="trial1">
            <input type="text" name="company_number"  placeholder="" value="<?php echo $row['requirement_company_number']; ?>" class="input02" readonly>
            <label class="placeholder2">Contact Number</label>
        </div>
        </div>
        <div class="outer02">
        <div class="trial1">
            <input type="text" name="material" placeholder="" value="<?php echo $row['material_detail']; ?>" class="input02" readonly>
            <label class="placeholder2">Material Details</label>
        </div>
        <div class="trial1">
            <input type="text" name="req_type" placeholder="" class="input02" value="<?php echo $row['type_of_requirement']; ?>" readonly>
            <label class="placeholder2">Type of Requirement</label>

            </div>
            </div>
            <input type="text" value="<?php echo $row['req_no'] ?>" readonly hidden>
            <div class="outer02">
                <div class="trial1">
                    <input type="text" class="input02" placeholder="" value="<?php echo $row1['dimension_unit'] ?>"readonly>
                    <label for="" class="placeholder2">Dimension Unit</label>
                </div>
                <div class="trial1">
                    <input type="text" class="input02" placeholder="" value="<?php echo $row1['weight_unit'] ?>" readonly>
                    <label for="" class="placeholder2">Weight Unit</label>
                </div>
            </div>
            <div class="outer02">
            <div class="trial1"> 
            <input type="text" name="trailor_type" class="input02" value="<?php echo $row['trailor_type'];  ?>" readonly>
            <label class="placeholder2">Trailor Type</label>
            </div>
            <div class="trial1"> 
            <input type="text" name="trailor_type" class="input02" value="<?php echo $row1['no_1_trailor'];  ?>" readonly>
            <label class="placeholder2">Number Of Trailor </label>
            </div>

            <div class="trial1">
            <input type="text" name="length" value="<?php echo $row1['length1'] . '*'. $row1['width1'] .'*'.$row1['height1']  ?>" placeholder="" class="input02" readonly>
            <label class="placeholder2">L*W*H</label>
            </div>
            <div class="trial1">
            <input type="text" name="weight" placeholder="" value="<?php echo $row1['weight1']; ?>" class="input02" readonly>
            <label class="placeholder2">Weight</label>
            </div>
            <div class="trial1">
                <input type="text" name="trailor1_price" placeholder="" value="<?php echo $row['trailor1_price'] ?>" class="input02 sum borderred">
                <label for="" class="placeholder2">Quote</label>
            </div>
            </div>
            <div class="outer02" <?php if (empty($row1['trailor2'])) { echo 'style="display:none;"'; } ?>>
            <div class="trial1"> 
            <input type="text" name="trailor_type" class="input02" value="<?php echo $row1['trailor2'];  ?>" readonly>
            <label class="placeholder2">Trailor Type</label>
            </div>
            <div class="trial1">
            <input type="text" name="length" value="<?php echo $row1['length2'] . '*'. $row1['width2'] .'*'.$row1['height2']  ?>" placeholder="" class="input02" readonly>
            <label class="placeholder2">L*W*H</label>
            </div>
            <div class="trial1">
            <input type="text" name="weight" placeholder="" value="<?php echo $row1['weight2']; ?>" class="input02" readonly>
            <label class="placeholder2">Weight</label>
            </div>
            <div class="trial1">
                <input type="text" name="trailor2_price" placeholder="" value="<?php echo $row['trailor2_price'] ?>" class="input02 sum borderred">
                <label for="" class="placeholder2">Quote</label>
            </div>
            </div>
            <div class="outer02" <?php if (empty($row1['trailor3'])) { echo 'style="display:none;"'; } ?>>
            <div class="trial1"> 
            <input type="text" name="trailor_type" class="input02" value="<?php echo $row1['trailor3'];  ?>" readonly>
            <label class="placeholder2">Trailor Type</label>
            </div>
            <div class="trial1">
            <input type="text" name="length" value="<?php echo $row1['length3'] . '*'. $row1['width3'] .'*'.$row1['height3']  ?>" placeholder="" class="input02" readonly>
            <label class="placeholder2">L*W*H</label>
            </div>
            <div class="trial1">
            <input type="text" name="weight" placeholder="" value="<?php echo $row1['weight3']; ?>" class="input02" readonly>
            <label class="placeholder2">Weight</label>
            </div>
            <div class="trial1">
                <input type="text" name="trailor3_price" placeholder="" value="<?php echo $row['trailor3_price'] ?>" class="input02 sum borderred">
                <label for="" class="placeholder2">Quote</label>
            </div>
            </div>
            <div class="outer02" <?php if (empty($row1['trailor4'])) { echo 'style="display:none;"'; } ?>>
            <div class="trial1"> 
            <input type="text" name="trailor_type" class="input02" value="<?php echo $row1['trailor4'];  ?>" readonly>
            <label class="placeholder2">Trailor Type</label>
            </div>
            <div class="trial1">
            <input type="text" name="length" value="<?php echo $row1['length4'] . '*'. $row1['width4'] .'*'.$row1['height4']  ?>" placeholder="" class="input02" readonly>
            <label class="placeholder2">L*W*H</label>
            </div>
            <div class="trial1">
            <input type="text" name="weight" placeholder="" value="<?php echo $row1['weight4']; ?>" class="input02" readonly>
            <label class="placeholder2">Weight</label>
            </div>
            <div class="trial1">
                <input type="text" name="trailor4_price" placeholder="" value="<?php echo $row['trailor4_price'] ?>" class="input02 sum borderred">
                <label for="" class="placeholder2">Quote</label>
            </div>
            </div>
            <div class="outer02" <?php if (empty($row1['trailor5'])) { echo 'style="display:none;"'; } ?>>
            <div class="trial1"> 
            <input type="text" name="trailor_type" class="input02" value="<?php echo $row1['trailor5'];  ?>" readonly>
            <label class="placeholder2">Trailor Type</label>
            </div>
            <div class="trial1">
            <input type="text" name="length" value="<?php echo $row1['length5'] . '*'. $row1['width5'] .'*'.$row1['height5']  ?>" placeholder="" class="input02" readonly>
            <label class="placeholder2">L*W*H</label>
            </div>
            <div class="trial1">
            <input type="text" name="weight" placeholder="" value="<?php echo $row1['weight5']; ?>" class="input02" readonly>
            <label class="placeholder2">Weight</label>
            </div>
            <div class="trial1">
                <input type="text" name="trailor5_price" placeholder="" value="<?php echo $row['trailor5_price'] ?>" class="input02 sum borderred">
                <label for="" class="placeholder2">Quote</label>
            </div>
            </div>
            <div class="outer02" <?php if (empty($row1['trailor6'])) { echo 'style="display:none;"'; } ?>>
            <div class="trial1"> 
            <input type="text" name="trailor_type" class="input02" value="<?php echo $row1['trailor6'];  ?>" readonly>
            <label class="placeholder2">Trailor Type</label>
            </div>
            <div class="trial1">
            <input type="text" name="length" value="<?php echo $row1['length6'] . '*'. $row1['width6'] .'*'.$row1['height6']  ?>" placeholder="" class="input02" readonly>
            <label class="placeholder2">L*W*H</label>
            </div>
            <div class="trial1">
            <input type="text" name="weight" placeholder="" value="<?php echo $row1['weight6']; ?>" class="input02" readonly>
            <label class="placeholder2">Weight</label>
            </div>
            <div class="trial1">
                <input type="text" name="trailor6_price" placeholder="" value="<?php echo $row['trailor6_price'] ?>" class="input02 sum borderred">
                <label for="" class="placeholder2">Quote</label>
            </div>
            </div>
            <div class="outer02" <?php if (empty($row1['trailor7'])) { echo 'style="display:none;"'; } ?>>
            <div class="trial1"> 
            <input type="text" name="trailor_type" class="input02" value="<?php echo $row1['trailor7'];  ?>" readonly>
            <label class="placeholder2">Trailor Type</label>
            </div>
            <div class="trial1">
            <input type="text" name="length" value="<?php echo $row1['length7'] . '*'. $row1['width7'] .'*'.$row1['height7']  ?>" placeholder="" class="input02" readonly>
            <label class="placeholder2">L*W*H</label>
            </div>
            <div class="trial1">
            <input type="text" name="weight" placeholder="" value="<?php echo $row1['weight7']; ?>" class="input02" readonly>
            <label class="placeholder2">Weight</label>
            </div>
            <div class="trial1">
                <input type="text" name="trailor7_price" placeholder="" value="<?php echo $row['trailor7_price'] ?>" class="input02 sum borderred">
                <label for="" class="placeholder2">Quote</label>
            </div>
            </div>
            <div class="outer02" <?php if (empty($row1['trailor8'])) { echo 'style="display:none;"'; } ?>>
            <div class="trial1"> 
            <input type="text" name="trailor_type" class="input02" value="<?php echo $row1['trailor8'];  ?>" readonly>
            <label class="placeholder2">Trailor Type</label>
            </div>
            <div class="trial1">
            <input type="text" name="length" value="<?php echo $row1['length8'] . '*'. $row1['width8'] .'*'.$row1['height8']  ?>" placeholder="" class="input02" readonly>
            <label class="placeholder2">L*W*H</label>
            </div>
            <div class="trial1">
            <input type="text" name="weight" placeholder="" value="<?php echo $row1['weight8']; ?>" class="input02" readonly>
            <label class="placeholder2">Weight</label>
            </div>
            <div class="trial1">
                <input type="text" name="trailor8_price" placeholder="" value="<?php echo $row['trailor8_price'] ?>" class="input02 sum borderred">
                <label for="" class="placeholder2">Quote</label>
            </div>
            </div>
            <div class="outer02" <?php if (empty($row1['trailor9'])) { echo 'style="display:none;"'; } ?>>
            <div class="trial1"> 
            <input type="text" name="trailor_type" class="input02" value="<?php echo $row1['trailor9'];  ?>" readonly>
            <label class="placeholder2">Trailor Type</label>
            </div>
            <div class="trial1">
            <input type="text" name="length" value="<?php echo $row1['length9'] . '*'. $row1['width9'] .'*'.$row1['height9']  ?>" placeholder="" class="input02" readonly>
            <label class="placeholder2">L*W*H</label>
            </div>
            <div class="trial1">
            <input type="text" name="weight" placeholder="" value="<?php echo $row1['weight9']; ?>" class="input02" readonly>
            <label class="placeholder2">Weight</label>
            </div>
            <div class="trial1">
                <input type="text" name="trailor9_price" placeholder="" value="<?php echo $row['trailor9_price'] ?>" class="input02 sum borderred">
                <label for="" class="placeholder2">Quote</label>
            </div>
            </div>
            <div class="outer02" <?php if (empty($row1['trailor10'])) { echo 'style="display:none;"'; } ?>>
            <div class="trial1"> 
            <input type="text" name="trailor_type" class="input02" value="<?php echo $row1['trailor10'];  ?>" readonly>
            <label class="placeholder2">Trailor Type</label>
            </div>
            <div class="trial1">
            <input type="text" name="length" value="<?php echo $row1['length10'] . '*'. $row1['width10'] .'*'.$row1['height10']  ?>" placeholder="" class="input02" readonly>
            <label class="placeholder2">L*W*H</label>
            </div>
            <div class="trial1">
            <input type="text" name="weight" placeholder="" value="<?php echo $row1['weight10']; ?>" class="input02" readonly>
            <label class="placeholder2">Weight</label>
            </div>
            <div class="trial1">
                <input type="text" name="trailor10_price" placeholder="" value="<?php echo $row['trailor10_price'] ?>" class="input02 sum borderred">
                <label for="" class="placeholder2">Quote</label>
            </div>
            </div>
            <div class="outer02">
            <div class="trial1">
            <input type="text" name="from" value="<?php echo $row['from_location']; ?>" placeholder="" class="input02" readonly>
            <label class="placeholder2">From</label>
            </div>
            <div class="trial1">
            <input type="text" name="from_pincode" value="<?php echo $row['from_pincode']; ?>"  placeholder="" class="input02" readonly>
            <label class="placeholder2">From Pincode</label>
            </div>
            </div>
            <div class="outer02">
            <div class="trial1">
            <input type="text" name="to" placeholder="" value="<?php echo $row['to_location']; ?>" class="input02" readonly>
            <label class="placeholder2">To</label>
            </div>
            <div class="trial1">
            <input type="text" name="to_pincode" value="<?php echo $row['to_pincode']; ?>" placeholder=""  class="input02" readonly>
            <label class="placeholder2">To Pincode</label>
            </div>
            </div>
            <div class="trial1">
            <input type="text"  placeholder="" id="total_price" name="price_quote" value="<?php echo $row['quote_price']; ?>" class="input02 borderred" >
            <label class="placeholder2">Total Price</label>
            </div>
            <div class="trial1 hideit">
            <input type="text" placeholder="" name="logi_company" value="<?php echo $row['logistic_company_name'] ?>" class="input02" readonly>
            <label class="placeholder2">Logistic Company Name</label>
            </div>
            <div class="outer02">
            <div class="trial1">
            <input type="text" placeholder="" name="logi_number" value="<?php echo $row['logistic_company_number'] ?>"  class="input02"  >
            <label class="placeholder2">Contact Number</label>
            </div>
            
            <div class="trial1">
            <input type="text" placeholder="" name="logi_email" value="<?php echo $row['logistic_company_email'] ?>" class="input02" readonly>
            <label class="placeholder2">Contact Email</label>
            </div>
            </div>
            <button type="submit" class="logi_req">Update Price</button>
            <br>


        </div>
    </form>
    <script>
                function calculateSum() {
            // Get all input elements with the class 'sum'
            const inputs = document.querySelectorAll('.sum');
            let total = 0;

            // Iterate through each input field
            inputs.forEach(input => {
                // Get the value of the input field, convert it to a number, and add it to the total
                const value = parseFloat(input.value) || 0;
                total += value;
            });

            // Display the total in the 'total_price' input field
            document.getElementById('total_price').value = total;
        }

        // Add event listeners to each input field to calculate sum on input
        document.querySelectorAll('.sum').forEach(input => {
            input.addEventListener('input', calculateSum);
        });

    </script>
</body>
</html>