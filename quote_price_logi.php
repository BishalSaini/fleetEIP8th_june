<?php
include_once 'partials/_dbconnect.php'; // Include the database connection file
session_start();
$email = $_SESSION["email"];
$showError=false;
$showAlert=false;
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

if(isset($_SESSION['date'])){
    $showError=true;
    unset($_SESSION['date']);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'partials/_dbconnect.php';
    $req_id = $_POST["edit"];
    $req_generated_email = $_POST["email123"];
    $req_generated_company = $_POST["company"];
    $req_generated_company_contact = $_POST["company_number"];
    $material_detail = $_POST["material"];
    $req_type = $_POST["req_type"];
    $trailor_type = $_POST["trailor_type1"];
    $length1 = $_POST["length1"];
    // $width1 = $_POST["width1"];
    // $height1 = $_POST["height1"];
    $weight1 = $_POST["weight1"];
    $from1 = $_POST["from"];
    $from1_pincode = $_POST["from_pincode"];
    $to1 = $_POST["to"];
    $to1_pincode = $_POST["to_pincode"];
    // $payment = $_POST["payment_terms"];
    $quote_price = $_POST["price_quote"];
    $logi_comp = $_POST["logi_company"];
    $logi_number = $_POST["logi_number"];
    $logi_email = $_POST["logi_email"];
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
    $logistic_id=$_POST['logistic_id'];

    $requirement_validtill=$_POST['requirement_validtill'];
    $currentDate = date('d-mmm-y');
    
    if ($currentDate > $requirement_validtill) {
        session_start();
        $_SESSION['date']="date has passed";
        $redirectUrl = "quote_price_logi.php?id=" . urlencode($logistic_id);
        header("Location: $redirectUrl");
        }
         else {



    $sql_price = "INSERT INTO `logi_price_quoted` (`req_no`, `requirement_company_email`, `requirement_company_name`, 
    `requirement_company_number`, `material_detail`, `type_of_requirement`, `trailor_type`,  
    `weight`, `from_location`, `from_pincode`, `to_location`, `to_pincode`, `payment_terms`, `quote_price`,
     `logistic_company_name`, `logistic_company_number`, `logistic_company_email`, `trailor1_price`, `trailor2_price`, `trailor3_price`,
      `trailor4_price`, `trailor5_price`, `trailor6_price`, `trailor7_price`, `trailor8_price`, `trailor9_price`, `trailor10_price`) 
    VALUES ('$req_id', '$req_generated_email', '$req_generated_company', '$req_generated_company_contact', '$material_detail',
     '$req_type', '$trailor_type','$weight1', '$from1', '$from1_pincode', '$to1',
      '$to1_pincode', '$payment', '$quote_price', '$logi_comp', '$logi_number', '$logi_email','$trailor1_price','$trailor2_price',
      '$trailor3_price','$trailor4_price','$trailor5_price','$trailor6_price','$trailor7_price','$trailor8_price','$trailor9_price','$trailor10_price')";
    $result123=mysqli_query($conn , $sql_price);
if($result123){
    session_start();
    $_SESSION['success']='success';
    header("location:logistics-need.php");
}}



}
// else{
//     $_SESSION['error']='success';
//     header("location:logistics-need.php");
// }

?>

<?php
include 'partials/_dbconnect.php';
$logi_id = isset($_GET['id']) ? $_GET['id'] : null;

if ($logi_id) {
    $sql = "SELECT * FROM `logistics_need` WHERE id = $logi_id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
     // Fetch data from logi_price_quoted table
     $sql_quoted_price = "SELECT * FROM `logi_price_quoted` WHERE req_no = '$logi_id' and `logistic_company_name` = '$companyname001'";
      $result_quoted_price = mysqli_query($conn, $sql_quoted_price);
     
     // Check if there is a quoted price row for this requirement
     $row_quoted_price = mysqli_fetch_assoc($result_quoted_price);

}





?>
<script>
    <?php include "main.js" ?>
    </script>
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
                <li><a href="logisticsdashboard.php">Dashboard</a></li>
                <!-- <li><a href="about_us.html">About Us</a></li>
                <li><a href="contact_us.php">Contact Us</a></li> -->
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
    <?php
    if($showAlert){
       echo '<label>
       <input type="checkbox" class="alertCheckbox" autocomplete="off" />
       <div class="alert notice">
         <span class="alertClose">X</span>
         <span class="alertText">Requirement Posted Successfully <a href="requirementlisting.php">View Requirement</a>
             <br class="clear"/></span>
       </div>
     </label>';
    }
    if($showError){
        echo '<label>
        <input type="checkbox" class="alertCheckbox" autocomplete="off" />
        <div class="alert error">
          <span class="alertClose">X</span>
          <span class="alertText">Requirement Last Date Passed 
              <br class="clear"/></span>
        </div>
      </label>';
    }
    ?>

    <form action="quote_price_logi.php" method="POST" class="logistics_need_form" onsubmit="validateForm(event)">
        <div class="logistic_need_container">
        <div class="logistics_heading"><h2 class="logistics_need_heading">Logistics Requirements</h2></div>

        <div class="trial1">
        <input type="text" name="edit" placeholder="" value="<?php echo$logi_id ?>" class="input02" hidden >
        </div>
        <div class="outer02">
        
        <div class="trial1">
            <input type="text" name="company" placeholder="" value="<?php echo $row['companyname_need_generator']; ?>" class="input02" readonly>
            <label class="placeholder2">Rental Company Name</label>
        
        </div>
        <input type="text" value="<?php echo $logi_id ?>" name="logistic_id" hidden>
        <div class="trial1">
            <input type="text" name="email123" placeholder="" value="<?php echo $row['email_need_generator']; ?>"  class="input02" readonly>
            <label class="placeholder2">Email</label>
        </div>

        <div class="trial1">
            <input type="text" name="company_number"  placeholder="" value="<?php echo $row['company_number']; ?>" class="input02" readonly>
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
            <div class="trial1"> 
            <input type="text" name="" class="input02" value="<?php echo $row['number_of_trailor'];  ?>" readonly>
            <label class="placeholder2">Total Trailors</label>
            </div>

            </div>
            <div class="outer02">
                <div class="trial1">
                    <input type="text" placeholder="" value="<?php echo $row['dimension_unit'] ?>" class="input02">
                    <label for="" class="placeholder2">Dimesion Unit</label>
                </div>
                <div class="trial1">
                    <input type="text" placeholder="" value="<?php echo $row['weight_unit'] ?>" class="input02">
                    <label for="" class="placeholder2">Weight Unit</label>
                </div>
                <div class="trial1">
                <input type="text" id="dateInput" value="<?php echo (new DateTime($row['requirement_valid_till']))->format('d-M-y'); ?>" class="input02" name="requirement_validtill">
                <label for="" class="placeholder2">Requirement Valid Till</label>
                </div>
            </div>
            <div class="outer02">
            <div class="trial1"> 
            <input type="text" name="trailor_type1" class="input02" value="<?php echo $row['trailor_type1'];  ?>" readonly>
            <label class="placeholder2">Trailor Type</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" value="<?php echo $row['no_1_trailor'] ?>" class="input02" readonly>
                <label for="" class="placeholder2">No Of Trailor</label>
            </div>
            <div class="trial1">
            <input type="text" name="length1" 
       value="<?php echo $row['length1'] . ' x ' . $row['width1'] . ' X ' . $row['height1']; ?>" 
       placeholder="" class="input02" readonly>            <label class="placeholder2">L*W*H</label>
            </div>
            <!-- <div class="trial1">
            <input type="text" name="width1" placeholder="" value="<?php echo $row['width1']; ?>"  class="input02" readonly>
            <label class="placeholder2">Width</label>
            </div>
            <div class="trial1">
            <input type="text" name="height1" placeholder="" value="<?php echo $row['height1']; ?>"  class="input02" readonly>
            <label class="placeholder2">Height</label>
            </div> -->
            <div class="trial1">
            <input type="text"  name="weight1" placeholder="" value="<?php echo $row['weight1']; ?>" class="input02 " readonly>
            <label class="placeholder2">Weight</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="trailor1_price" class="input02 sum" required>
                <label for="" class="placeholder2">Quote</label>
            </div>
            </div>
        <?php
            $displayStyle8 = empty($row['trailor2']) ? 'style="display:none"' : '';
        ?>
            <div class="outer02" <?php echo $displayStyle8 ?>>
            <div class="trial1" > 
            <input type="text" name="trailor_type2" class="input02" value="<?php echo $row['trailor2'];  ?>" readonly>
            <label class="placeholder2">Trailor Type</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" value="<?php echo $row['no_2_trailor'] ?>" class="input02" readonly>
                <label for="" class="placeholder2">No Of Trailor</label>
            </div>

            <div class="trial1">
            <input type="text" name="length" value="<?php echo $row['length2'] . ' x ' . $row['width2'] . ' X ' . $row['height2']; ?>"  placeholder="" class="input02" readonly>
            <label class="placeholder2">L*W*H</label>
            </div>
            <!-- <div class="trial1">
            <input type="text" name="width" placeholder="" value="<?php echo $row['width2']; ?>"  class="input02" readonly>
            <label class="placeholder2">Width</label>
            </div>
            <div class="trial1">
            <input type="text" name="height" placeholder="" value="<?php echo $row['height2']; ?>"  class="input02" readonly>
            <label class="placeholder2">Height</label>
            </div> -->
            <div class="trial1">
            <input type="text" name="weight" placeholder="" value="<?php echo $row['weight2']; ?>" class="input02" readonly>
            <label class="placeholder2">Weight</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="trailor2_price" class="input02 sum">
                <label for="" class="placeholder2">Quote</label>
            </div>

            </div>
        <?php
            $displayStyle7= empty($row['trailor3']) ? 'style="display:none"' : '';
        ?>
<div class="outer02" <?php echo $displayStyle7 ?>>
            <div class="trial1" > 
            <input type="text" name="trailor_type3" class="input02" value="<?php echo $row['trailor3'];  ?>" readonly>
            <label class="placeholder2">Trailor Type</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" value="<?php echo $row['no_3_trailor'] ?>" class="input02" readonly>
                <label for="" class="placeholder2">No Of Trailor</label>
            </div>

            <div class="trial1">
            <input type="text" name="length" value="<?php echo $row['length3'] . ' x ' . $row['width3'] . ' X ' . $row['height3']; ?>" placeholder="" class="input02" readonly>
            <label class="placeholder2">L*W*H</label>
            </div>
            <div class="trial1">
            <input type="text" name="weight" placeholder="" value="<?php echo $row['weight3']; ?>" class="input02" readonly>
            <label class="placeholder2">Weight</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="trailor3_price" class="input02 sum">
                <label for="" class="placeholder2">Quote</label>
            </div>

</div>
        <?php
            $displayStyle6 = empty($row['trailor4']) ? 'style="display:none"' : '';
        ?>
<div class="outer02" <?php echo $displayStyle6 ?>>
        <div class="trial1" >
            <input type="text" name="trailor_type4" class="input02" value="<?php echo $row['trailor4'];  ?>" readonly>
            <label class="placeholder2">4th Trailor Type</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" value="<?php echo $row['no_4_trailor'] ?>" class="input02" readonly>
                <label for="" class="placeholder2">No Of Trailor</label>
            </div>


            <div class="trial1">
            <input type="text" name="length" value="<?php echo $row['length4'] . ' x ' . $row['width4'] . ' X ' . $row['height4']; ?>" placeholder="" class="input02" readonly>
            <label class="placeholder2">L*W*H</label>
            </div>
            <div class="trial1">
            <input type="text" name="weight" placeholder="" value="<?php echo $row['weight4']; ?>" class="input02" readonly>
            <label class="placeholder2">Weight</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="trailor4_price" class="input02 sum">
                <label for="" class="placeholder2">Quote</label>
            </div>

        </div>
        <?php
            $displayStyle5 = empty($row['trailor5']) ? 'style="display:none"' : '';
        ?>
        <div class="outer02" <?php echo $displayStyle5  ?>>
        <div class="trial1" >
            <input type="text" name="trailor_type5" class="input02" value="<?php echo $row['trailor5'];  ?>" readonly>
            <label class="placeholder2">5th Trailor Type</label>
            </div>
            <div class="trial1">
            <input type="text" name="length" value="<?php echo $row['length5'] . ' x ' . $row['width5'] . ' X ' . $row['height5']; ?>" placeholder="" class="input02" readonly>
            <label class="placeholder2">L*W*H</label>
            </div>
            <div class="trial1">
            <input type="text" name="weight" placeholder="" value="<?php echo $row['weight5']; ?>" class="input02" readonly>
            <label class="placeholder2">Weight</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="trailor5_price" class="input02 sum">
                <label for="" class="placeholder2">Quote</label>
            </div>

        </div>
        <?php
            $displayStyle4 = empty($row['trailor6']) ? 'style="display:none"' : '';
        ?>
        <div class="outer02" <?php echo $displayStyle4 ?>>
        <div class="trial1" >
            <input type="text" name="trailor_type6" class="input02" value="<?php echo $row['trailor6'];  ?>" readonly>
            <label class="placeholder2">6th Trailor Type</label>
            </div>
            <div class="trial1">
            <input type="text" name="length" value="<?php echo $row['length6'] . ' x ' . $row['width6'] . ' X ' . $row['height6']; ?>" placeholder="" class="input02" readonly>
            <label class="placeholder2">L*W*H</label>
            </div>
            <div class="trial1">
            <input type="text" name="weight" placeholder="" value="<?php echo $row['weight6']; ?>" class="input02" readonly>
            <label class="placeholder2">Weight</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="trailor6_price" class="input02 sum">
                <label for="" class="placeholder2">Quote</label>
            </div>

        </div>
        <?php
            $displayStyle3 = empty($row['trailor7']) ? 'style="display:none"' : '';
        ?>
        <div class="outer02" <?php echo $displayStyle3 ?>>
        <div class="trial1">
            <input type="text" name="trailor_type7" class="input02" value="<?php echo $row['trailor7'];  ?>" readonly>
            <label class="placeholder2">7th Trailor Type</label>
            </div>
            <div class="trial1">
            <input type="text" name="length" value="<?php echo $row['length7'] . ' x ' . $row['width7'] . ' X ' . $row['height7']; ?>" placeholder="" class="input02" readonly>
            <label class="placeholder2">L*W*H</label>
            </div>
            <div class="trial1">
            <input type="text" name="weight" placeholder="" value="<?php echo $row['weight7']; ?>" class="input02" readonly>
            <label class="placeholder2">Weight</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="trailor7_price" class="input02 sum">
                <label for="" class="placeholder2">Quote</label>
            </div>

        </div>
        <?php
            $displayStyle2 = empty($row['trailor8']) ? 'style="display:none"' : '';
        ?>
<div class="outer02" <?php echo $displayStyle2 ?>>
        <div class="trial1" >
            <input type="text" name="trailor_type8" class="input02" value="<?php echo $row['trailor8'];  ?>" readonly>
            <label class="placeholder2">8th Trailor Type</label>
            </div>
            <div class="trial1">
            <input type="text" name="length" value="<?php echo $row['length8'] . ' x ' . $row['width8'] . ' X ' . $row['height8']; ?>" placeholder="" class="input02" readonly>
            <label class="placeholder2">L*W*H</label>
            </div>
            <div class="trial1">
            <input type="text" name="weight" placeholder="" value="<?php echo $row['weight8']; ?>" class="input02" readonly>
            <label class="placeholder2">Weight</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="trailor8_price" class="input02 sum">
                <label for="" class="placeholder2">Quote</label>
            </div>

        </div>
        <?php
            $displayStyle1 = empty($row['trailor9']) ? 'style="display:none"' : '';
        ?>
        <div class="outer02" <?php echo $displayStyle1 ?>>
        <div class="trial1" >
            <input type="text" name="trailor_type9" class="input02" value="<?php echo $row['trailor9'];  ?>" readonly>
            <label class="placeholder2">9th Trailor Type</label>
            </div>
            <div class="trial1">
            <input type="text" name="length" value="<?php echo $row['length9'] . ' x ' . $row['width9'] . ' X ' . $row['height9']; ?>" placeholder="" class="input02" readonly>
            <label class="placeholder2">L*W*H</label>
            </div>
            <div class="trial1">
            <input type="text" name="weight" placeholder="" value="<?php echo $row['weight9']; ?>" class="input02" readonly>
            <label class="placeholder2">Weight</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="trailor9_price" class="input02 sum">
                <label for="" class="placeholder2">Quote</label>
            </div>

        </div>
        
        <?php
            $displayStyle = empty($row['trailor10']) ? 'style="display:none"' : '';
        ?>
        <div class="outer02" <?php echo $displayStyle ?>>
        <div class="trial1">
            <input type="text" name="trailor_type10" class="input02" value="<?php echo $row['trailor10'];  ?>" readonly>
            <label class="placeholder2">10th Trailor Type</label>
            </div>
            <div class="trial1">
            <input type="text" name="length" value="<?php echo $row['length10'] . ' x ' . $row['width10'] . ' X ' . $row['height10']; ?>" placeholder="" class="input02" readonly>
            <label class="placeholder2">L*W*H</label>
            </div>
            <div class="trial1">
            <input type="text" name="weight" placeholder="" value="<?php echo $row['weight10']; ?>" class="input02" readonly>
            <label class="placeholder2">Weight</label>
            </div>
                        <div class="trial1">
                <input type="text" placeholder="" name="trailor10_price" class="input02 sum">
                <label for="" class="placeholder2">Quote</label>
            </div>
        </div>
            <div class="outer02">
            <div class="trial1">
            <input type="text" name="from" value="<?php echo $row['from']; ?>" placeholder="" class="input02" readonly>
            <label class="placeholder2">From</label>
            </div>
            <div class="trial1">
            <input type="text" name="from_pincode" value="<?php echo $row['from_pincode']; ?>"  placeholder="" class="input02" readonly>
            <label class="placeholder2">From Pincode</label>
            </div>
            </div>
            <div class="outer02">
            <div class="trial1">
            <input type="text" name="to" placeholder="" value="<?php echo $row['to']; ?>" class="input02" readonly>
            <label class="placeholder2">To</label>
            </div>
            <div class="trial1">
            <input type="text" name="to_pincode" value="<?php echo $row['to_pincode']; ?>" placeholder=""  class="input02" readonly>
            <label class="placeholder2">To Pincode</label>
            </div>
            <!-- <div class="trial1">
            <input type="text" name="payment_terms" placeholder="" value="<?php echo $row['payment_terms']; ?>" class="input02" readonly>
            <label class="placeholder2">Payment Terms</label>
            </div> -->

            </div>
            
            <div class="trial1 hideit" >
            <input type="text" placeholder="" name="logi_company" value="<?php echo $companyname001 ?>" class="input02" readonly >
            <label class="placeholder2">Company Name</label>
            </div>
            <div class="outer02">
            <div class="trial1 ">
            <input type="text" placeholder="" name="logi_email" value="<?php echo $email ?>" class="input02" >
            <label class="placeholder2">Contact Email</label>
            </div>

            <div class="trial1">
            <input type="text" placeholder="" name="logi_number" value="<?php echo isset($row_quoted_price['logistic_company_number']) ? $row_quoted_price['logistic_company_number'] : ''; ?>"  class="input02" <?php echo !empty($row_quoted_price['logistic_company_number']) ? 'readonly' : ''; ?>>
            <label class="placeholder2">Contact Number</label>
            </div>
            </div>
            <div class="trial1">
            <input type="text"  placeholder="" id="total_price" name="price_quote" value="<?php echo isset($row_quoted_price['quote_price']) ? $row_quoted_price['quote_price'] : ''; ?>" class="input02" <?php echo !empty($row_quoted_price['quote_price']) ? 'readonly' : ''; ?>>
            <label class="placeholder2">Total Price</label>
            </div>

            <?php
            $displayStyle112 = !empty($row_quoted_price['quote_price']) ? 'style="display:none"' : '';
        ?>

            <button type="submit" class="logi_req" <?php echo $displayStyle112 ?>>Quote Price</button>
            <br>


        </div>
        <br><br>
    </form>
    <script>
        // Function to calculate the sum of all input fields
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

//         function validateForm(event) {
//             // Get the date from the input field
//             var inputDateValue = document.getElementById('dateInput').value;
//             var inputDate = new Date(inputDateValue);
//             var currentDate = new Date();

//             // Reset time components to compare only dates
//             inputDate.setHours(0, 0, 0, 0);
//             currentDate.setHours(0, 0, 0, 0);

//             // Compare dates
//             if (currentDate > inputDate) {
//                 <?php 
// $shorError=true;                    
                    
//                 ?>
//                 // alert('Requirement Is Not Valid Anymore.');
//                 event.preventDefault(); // Prevent form submission
//             }
//         }
</script>
</body>
</html>