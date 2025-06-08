<?php 
$id=$_GET['id'];
include "partials/_dbconnect.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$companyname001 = $_SESSION['companyname'];
$enterprise = $_SESSION['enterprise'];
$email = $_SESSION['email'];

$dashboard_url = '';
if ($enterprise === 'rental') {
    $dashboard_url = 'rental_dashboard.php';
} elseif ($enterprise === 'logistics') {
    $dashboard_url = 'logisticsdashboard.php';
} elseif ($enterprise === 'epc') {
    $dashboard_url = 'epc_dashboard.php';
} elseif ($enterprise === 'admin') {
    $dashboard_url = 'news/admin/dashboard.php';
}
$showAlert = false;
$showError = false;

$sql="SELECT * FROM `employeedetails` where id=$id and companyname='$companyname001'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);

if($_SERVER['REQUEST_METHOD']==='POST' AND isset($_POST['generateofferletter'])){
    include "partials/_dbconnect.php";
    $fullname = isset($_POST['fullname']) ? $_POST['fullname'] : '';
    $joindate = isset($_POST['joindate']) ? $_POST['joindate'] : '';
    $jobrole = isset($_POST['jobrole']) ? $_POST['jobrole'] : '';
    $joinlocation = isset($_POST['joinlocation']) ? $_POST['joinlocation'] : '';
    $basicsalary = isset($_POST['basicsalary']) ? $_POST['basicsalary'] : 0;
    $hr = isset($_POST['hr']) ? $_POST['hr'] : 0;
    $da = isset($_POST['da']) ? $_POST['da'] : 0;
    $ta = isset($_POST['ta']) ? $_POST['ta'] : 0;
    $profesionaldeductiondd = isset($_POST['profesionaldeductiondd']) ? $_POST['profesionaldeductiondd'] : '';
    $professionaltaxdeduction = isset($_POST['professionaltaxdeduction']) ? $_POST['professionaltaxdeduction'] : 0;
    $bonusCriteria = isset($_POST['bonusCriteria']) ? $_POST['bonusCriteria'] : '';
    $bonusPercentage = isset($_POST['bonusPercentage']) ? $_POST['bonusPercentage'] : 0;
    $calculatedBonus = isset($_POST['calculatedBonus']) ? $_POST['calculatedBonus'] : 0;
    $bonusAmount = isset($_POST['bonusAmount']) ? $_POST['bonusAmount'] : 0;
    $bonus_criteria = isset($_POST['bonus_criteria']) ? $_POST['bonus_criteria'] : '';
    $monthly_bonus_amount = isset($_POST['monthly_bonus_amount']) ? $_POST['monthly_bonus_amount'] : 0;
    $quarterly_bonus_amount = isset($_POST['quarterly_bonus_amount']) ? $_POST['quarterly_bonus_amount'] : 0;
    $monthly_bonus_percentage = isset($_POST['monthly_bonus_percentage']) ? $_POST['monthly_bonus_percentage'] : 0;
    $year_end_bonus_percentage = isset($_POST['year_end_bonus_percentage']) ? $_POST['year_end_bonus_percentage'] : 0;
    $pfdeductiondd = isset($_POST['pfdeductiondd']) ? $_POST['pfdeductiondd'] : '';
    $deductionamt = isset($_POST['deductionamt']) ? $_POST['deductionamt'] : 0;
    $esisdeductiondd = isset($_POST['esisdeductiondd']) ? $_POST['esisdeductiondd'] : '';
    $esisdeductionamt = isset($_POST['esisdeductionamt']) ? $_POST['esisdeductionamt'] : 0;
    $otherdedeuction = isset($_POST['otherdedeuction']) ? $_POST['otherdedeuction'] : 0;
    $grosssalary = isset($_POST['grosssalary']) ? $_POST['grosssalary'] : 0;
    $ctc = isset($_POST['ctc']) ? $_POST['ctc'] : 0;
    $trainingterms = isset($_POST['trainingterms']) ? $_POST['trainingterms'] : '';
    $probationterms = isset($_POST['probationterms']) ? $_POST['probationterms'] : '';
    $earnedLeave = isset($_POST['earnedLeave']) ? $_POST['earnedLeave'] : 0;
    $earnedLeavepermanant = isset($_POST['earnedLeavepermanant']) ? $_POST['earnedLeavepermanant'] : 0;
    $incrementterms = isset($_POST['incrementterms']) ? $_POST['incrementterms'] : '';
    $compensationLocation = isset($_POST['compensationLocation']) ? $_POST['compensationLocation'] : '';
    $noticePeriod = isset($_POST['noticePeriod']) ? $_POST['noticePeriod'] : 0;
    $noticePeriodconfirm = isset($_POST['noticePeriodconfirm']) ? $_POST['noticePeriodconfirm'] : 0;
    $sendersname = isset($_POST['sendersname']) ? $_POST['sendersname'] : '';
    $newsendername = isset($_POST['newsendername']) ? $_POST['newsendername'] : '';
    $designation = isset($_POST['designation']) ? $_POST['designation'] : '';
    $sendersemail = isset($_POST['sendersemail']) ? $_POST['sendersemail'] : '';
    $contactemail = isset($_POST['contactemail']) ? $_POST['contactemail'] : '';
    $contactnumber = isset($_POST['contactnumber']) ? $_POST['contactnumber'] : '';
    $offerdate = isset($_POST['offerdate']) ? $_POST['offerdate'] : '';
    $salutation_dd = isset($_POST['salutation_dd']) ? $_POST['salutation_dd'] : '';
    $to_address = isset($_POST['to_address']) ? $_POST['to_address'] : '';
    $customtermheading = isset($_POST['customtermheading']) ? $_POST['customtermheading'] : '';
    $customterm = isset($_POST['customterm']) ? $_POST['customterm'] : '';
    $customtermheading2 = isset($_POST['customtermheading2']) ? $_POST['customtermheading2'] : '';
    $customterm2 = isset($_POST['customterm2']) ? $_POST['customterm2'] : '';
    $refno = isset($_POST['refno']) ? $_POST['refno'] : '';
    $department = isset($_POST['department']) ? $_POST['department'] : '';
    $editid=$_POST['editid'];
    
    

    $updateQuery = "UPDATE EmployeeDetails SET 
    fullname = '$fullname',
    joindate = '$joindate',
    department = '$department',
    jobrole = '$jobrole',
    joinlocation = '$joinlocation',
    basicsalary = '$basicsalary',
    hr = '$hr',
    da = '$da',
    ta = '$ta',
    profesionaldeductiondd = '$profesionaldeductiondd',
    professionaltaxdeduction = '$professionaltaxdeduction',
    bonusCriteria = '$bonusCriteria',
    bonusPercentage = '$bonusPercentage',
    calculatedBonus = '$calculatedBonus',
    bonusAmount = '$bonusAmount',
    bonus_criteria = '$bonus_criteria',
    monthly_bonus_amount = '$monthly_bonus_amount',
    quarterly_bonus_amount = '$quarterly_bonus_amount',
    monthly_bonus_percentage = '$monthly_bonus_percentage',
    year_end_bonus_percentage = '$year_end_bonus_percentage',
    pfdeductiondd = '$pfdeductiondd',
    deductionamt = '$deductionamt',
    esisdeductiondd = '$esisdeductiondd',
    esisdeductionamt = '$esisdeductionamt',
    otherdedeuction = '$otherdedeuction',
    grosssalary = '$grosssalary',
    ctc = '$ctc',
    trainingterms = '$trainingterms',
    probationterms = '$probationterms',
    earnedLeave = '$earnedLeave',
    earnedLeavepermanant = '$earnedLeavepermanant',
    incrementterms = '$incrementterms',
    compensationLocation = '$compensationLocation',
    noticePeriod = '$noticePeriod',
    noticePeriodconfirm = '$noticePeriodconfirm',
    sendersname = '$sendersname',
    newsendername = '$newsendername',
    designation = '$designation',
    sendersemail = '$sendersemail',
    companyname = '$companyname001',
    created_by = '$email',
    contactemail = '$contactemail',
    contactnumber = '$contactnumber',
    generatedon = '$offerdate',
    salutation = '$salutation_dd',
    to_address = '$to_address',
    customheading = '$customtermheading',
    customterm = '$customterm',
    customheading2 = '$customtermheading2',
    customterm2 = '$customterm2',
    refno = '$refno'
WHERE id = '$editid'";
$resultinsert=mysqli_query($conn,$updateQuery);
if($resultinsert){
    session_start();
    $_SESSION['success']='true';
}
else{
    session_start();
    $_SESSION['error']='true';
}
header("Location: offerletterdashboard.php");

    

}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Offer Letter</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .newhidden { display: none; }
    </style>

    <script src="main.js"></script>
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
    <body>
    <div class="navbar1">
        <div class="logo_fleet">
            <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='<?php echo $dashboard_url  ?>'">
        </div>
        <div class="iconcontainer">
            <ul>
                <li><a href="<?php echo $dashboard_url ?>">Dashboard</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </div>
    </div>
    <?php
    if ($showAlert) {
        echo '<label><input type="checkbox" class="alertCheckbox" autocomplete="off" />
        <div class="alert notice"><span class="alertClose">X</span><span class="alertText">Success<br class="clear"/></span></div></label>';
    }
    if ($showError) {
        echo '<label><input type="checkbox" class="alertCheckbox" autocomplete="off" />
        <div class="alert error"><span class="alertClose">X</span><span class="alertText">Something Went Wrong<br class="clear"/></span></div></label>';
    }
?>
    <form action="editofferletter.php?id=<?php echo $id ; ?>" method="POST"  class="outerform" autocomplete="off">
        <div class="offerlettercontainer">
            <div class="" id="offerletterpaysection">
            <p class="headingpara">Offer Letter</p>
            <div class="outer02">
                <input type="hidden" name="editid" value="<?php echo $id ; ?>">
            <div class="trial1">
                <input type="text" placeholder="" value="<?php  echo $row['refno']; ?>" name="refno" class="input02" readonly>
                <label for="" class="placeholder2">Ref No</label>
            </div>

            <div class="trial1">
                <input type="date" placeholder="" value="<?php echo $row['generatedon'] ?>" name="offerdate" class="input02">
                <label for="" class="placeholder2">Date</label>
            </div>

            </div>
            <div class="outer02">
            <div class="trial1" id="salute_dd">
            <select name="salutation_dd"  class="input02" required>
                <option <?php if($row['salutation']==='Mr'){echo 'selected';} ?> value="Mr">Mr</option>
                <option <?php if($row['salutation']==='Ms'){echo 'selected';} ?> value="Ms">Ms</option>
            </select>
        </div>

            <div class="trial1">
                <input type="text" placeholder="" value="<?php  echo $row['fullname']; ?>" name="fullname" class="input02">
                <label for="" class="placeholder2">Name</label>
            </div>
            </div>
            <div class="outer02">
                <div class="trial1">
                    <input type="text" placeholder="" value="<?php  echo $row['contactemail']; ?>" name="contactemail" class="input02">
                    <label for="" class="placeholder2">Contact Email</label>
                </div>
                <div class="trial1">
                    <input type="text" placeholder="" name="contactnumber" value="<?php  echo $row['contactnumber']; ?>" class="input02">
                    <label for="" class="placeholder2">Contact Number</label>
                </div>
            </div>
            <div class="trial1">
                <textarea name="to_address" placeholder="" class="input02"  id=""><?php echo $row['to_address'] ?></textarea>
                <label for="" class="placeholder2">Communication Address</label>
            </div>
            <div class="outer02">
                <div class="trial1">
                    <input type="date" placeholder="" value="<?php  echo $row['joindate']; ?>" name="joindate" class="input02">
                    <label for="" class="placeholder2">Date Of Joining</label>
                </div>
                <div class="trial1">
                    <input type="text" placeholder="" name="jobrole" value="<?php  echo $row['jobrole']; ?>" class="input02">
                    <label for="" class="placeholder2">Job Role</label>
                </div>
                <div class="trial1">
                    <input type="text" placeholder="" value="<?php echo $row['department'] ?>" name="department" class="input02">
                    <label for="" class="placeholder2">Department</label>
                </div>

            </div>
            <div class="trial1">
                <textarea name="joinlocation" class="input02" placeholder=""  id=""><?php echo $row['joinlocation']; ?></textarea>
                <label for="" class="placeholder2">Joining Location</label>
            </div>
            <div class="outer02">
            <div class="trial1">
            <input type="number" placeholder="" name="basicsalary" value="<?php  echo $row['basicsalary']; ?>" id="basicsalary" class="input02">
            <label for="basicsalary" class="placeholder2">Basic Salary</label>
        </div>
        <div class="trial1">
            <input type="number" placeholder="" name="hr" value="<?php  echo $row['hr']; ?>" class="input02">
            <label for="" class="placeholder2">House Rent Allowance</label>
        </div>
        <div class="trial1">
            <input type="number" placeholder="" name="da" value="<?php  echo $row['da']; ?>" class="input02">
            <label for="" class="placeholder2">Dearness Allowance</label>
        </div>

    </div>
    <div class="outer02">

        <div class="trial1">
            <input type="number" placeholder="" name="ta" value="<?php  echo $row['ta']; ?>" class="input02">
            <label for="" class="placeholder2">Travel Allowance</label>
        </div>
        <select name="profesionaldeductiondd" id="professionaldd" onchange="professionaldeduction()" class="input02">
            <option value="" disabled selected>Professional Tax Deduction?</option>
            <option <?php if($row['profesionaldeductiondd']==='Yes'){echo 'selected';} ?> value="Yes">Professional Tax Deduction : Yes</option>
            <option <?php if($row['profesionaldeductiondd']==='No'){echo 'selected';} ?> value="No">Professional Tax Deduction : No</option>
        </select>

        <div class="trial1 newhidden" id="taxAmountField">
            <input type="number" placeholder="" value="<?php  echo $row['professionaltaxdeduction']; ?>" name="professionaltaxdeduction" class="input02">
            <label for="" class="placeholder2">Professional Tax Amount</label>
        </div>
        </div>
    <div class="outer02">
    <select name="bonusCriteria" id="bonusCriteria" class="input02" onchange="toggleBonusInput()">
        
            <option value=""disabled selected>Bonus Calculation Criteria :</option>
            <option <?php if($row['bonusCriteria']==='Percentage Of Basic Salary'){echo 'selected';} ?> value="Percentage Of Basic Salary">Percentage Of Basic Salary</option>
            <option <?php if($row['bonusCriteria']==='Specific Amount'){echo 'selected';} ?> value="Specific Amount">Specific Amount</option>
            <option <?php if($row['bonusCriteria']==='No Bonus'){echo 'selected';} ?> value="No Bonus">No Bonus</option>
        </select>
        <div class="trial1" id="bonusInPercentage" style="display: none;">
    <input type="number" id="bonusPercentage" name="bonusPercentage" min="0" max="100" value="<?php  echo $row['bonusPercentage']; ?>" placeholder="" class="input02" oninput="calculateBonus()">
    <label for="bonusPercentage" class="placeholder2">Enter Percentage %</label>
</div>

<!-- Calculated Bonus Amount Field -->
<div class="trial1" id="calculatedBonusContainer" style="display: none;">
    <input type="number" id="calculatedBonus" value="<?php  echo $row['calculatedBonus']; ?>" name="calculatedBonus" class="input02" readonly>
    <label for="calculatedBonus" class="placeholder2">Calculated Bonus Amount</label>
</div>

<div class="trial1" id="bonusAmount" style="display: none;">
        <input type="number" id="bonusPercentage" name="bonusAmount" value="<?php  echo $row['bonusAmount']; ?>" min="0"  placeholder="" class="input02">
        <label for="" class="placeholder2">Enter Bonus Amount </label>
        </div>
</div>
    <div class="outer02">
    <select name="bonus_criteria" class="input02" id="bonusCriteriaSelect" onchange="showRelevantFields()">
        <option value="" disabled selected>Bonus Criteria :</option>
        <option <?php if($row['bonus_criteria']==='Full Bonus To Be Paid Once In A Year'){echo 'selected';} ?> value="Full Bonus To Be Paid Once In A Year">Full Bonus To Be Paid Once In A Year</option>
        <option <?php if($row['bonus_criteria']==='Bonus To Be Paid On Monthly Basis'){echo 'selected';} ?> value="Bonus To Be Paid On Monthly Basis">Bonus To Be Paid On Monthly Basis</option>
        <option <?php if($row['bonus_criteria']==='Partial Bonus Paid Monthly, Remaining at Year-End'){echo 'selected';} ?> value="Partial Bonus Paid Monthly, Remaining at Year-End">Partial Bonus Paid Monthly, Remaining at Year-End</option>
        <option <?php if($row['bonus_criteria']==='Bonus To Be Paid Quarterly'){echo 'selected';} ?> value="Bonus To Be Paid Quarterly">Bonus To Be Paid Quarterly</option>
    </select>

    <div class="trial1 newhidden" id="monthlyBonus">
        <input type="text" placeholder="" value="<?php  echo $row['monthly_bonus_amount']; ?>" name="monthly_bonus_amount" class="input02">
        <label class="placeholder2">Monthly Bonus Amount :</label>
    </div>
    
    <div class="trial1 newhidden" id="quarterlyBonus">
        <input type="text" placeholder="" value="<?php  echo $row['quartely_bonus_amount']; ?>" name="quarterly_bonus_amount" class="input02">
        <label class="placeholder2">Quarterly Bonus Amount :</label>
    </div>
    
    <div class="trial1 newhidden" id="partPaymentMonthly">
        <input type="number" name="monthly_bonus_percentage" value="<?php  echo $row['monthly_bonus_percentage']; ?>" placeholder="" min="0" max="100" class="input02">
        <label class="placeholder2">Monthly Bonus Percentage :</label>
    </div>
    
    <div class="trial1 newhidden" id="partPaymentYearEnd">
        <input type="number" name="year_end_bonus_percentage" value="<?php  echo $row['year_end_bonus_percentage']; ?>" placeholder="" min="0" max="100" class="input02">
        <label class="placeholder2">Year-End Bonus Percentage:</label>
    </div>        
</div>

    <div class="outer02">


        <select name="pfdeductiondd" id="pfdeductionselect" onchange="pfdeduction()" class="input02">
            <option value=""disabled selected>PF Deduction ?</option>
            <option <?php if($row['pfdeductiondd']==='Yes'){echo 'selected';} ?> value="Yes">Yes</option>
            <option <?php if($row['pfdeductiondd']==='No'){echo 'selected';} ?> value="No">No</option>
        </select>
    <div class="trial1" id="deductionamountinput">
        <input type="text" placeholder="" id="pfinputamount" value="<?php echo $row['deductionamt']; ?>"  name="deductionamt" class="input02">
        <label for="" class="placeholder2">PF Deduction Amount</label>
    </div>

    <select name="esisdeductiondd" id="esisdd" onchange="esisselect()" class="input02">
            <option value=""disabled selected>ESIS ?</option>
            <option <?php if($row['esisdeductiondd']==='Yes'){echo 'selected';} ?> value="Yes">ESIS : Yes</option>
            <option <?php if($row['esisdeductiondd']==='No'){echo 'selected';} ?> value="No">ESIS  : No</option>
        </select>
    <div class="trial1" id="esisdeductionamountinput">
        <input type="text" placeholder="" id="esisamnt" value="<?php  echo $row['esisdeductionamt']; ?>" name="esisdeductionamt" class="input02">
        <label for="" class="placeholder2">ESIS Deduction Amount</label>
    </div>
    <div class="trial1">
        <input type="text" placeholder="" name="otherdedeuction" value="<?php  echo $row['otherdedeuction']; ?>" class="input02">
        <label for="" class="placeholder2">Other Deductions</label>
    </div>

    </div>
    <div class="outer02">
        <div class="trial1">
        <input type="text" name="grosssalary" placeholder="" value="<?php  echo $row['grosssalary']; ?>" class="input02">
        <label for="" class="placeholder2">Total Gross Salary :</label>

        </div>
        <div class="trial1">
        <input type="text" name="ctc" placeholder="" value="<?php  echo $row['ctc']; ?>" class="input02">
        <label for="" class="placeholder2">CTC :</label>

        </div>
        </div>
    <button
  class="quotationnavigatebutton bg-white text-center w-30 rounded-lg h-10 relative text-black text-sm font-semibold group"
  type="button" onclick="termsofoffersectionfunction()">
  <div
    class="bg-custom-blue rounded-md h-8 w-1/4 flex items-center justify-center absolute left-1 top-[2px] group-hover:w-[110px] z-10 duration-300"
    style="background-color: #1C549E;" 

  >
  <svg
      xmlns="http://www.w3.org/2000/svg"
      viewBox="0 0 1024 1024"
      height="18px"
      width="18px"
      transform="rotate(180)" 
    >
      <path
        d="M224 480h640a32 32 0 1 1 0 64H224a32 32 0 0 1 0-64z"
        fill="white" 
      ></path>
      <path
        d="m237.248 512 265.408 265.344a32 32 0 0 1-45.312 45.312l-288-288a32 32 0 0 1 0-45.312l288-288a32 32 0 1 1 45.312 45.312L237.248 512z"
        fill="white" 
      ></path>
    </svg>
  </div>
  <p class="translate-x-1" >Next</p>
</button>
<br>
</div>


            <div id="termsofoffersection">
            <p class="headingpara">Terms & Conditions: </p>
    <div class="terms_container012">
    <p class="heading_terms">Terms & Conditions :
</div>

<p class="offerterms">
    <strong>1.Training :</strong>The training program will consist of virtual training and on-the-job training. The duration
    of the virtual training will be 
    <select name="trainingterms" id="">
        <option value="based on the business requirement">based on the business requirement</option>
        <option <?php if($row['trainingterms']==='1'){echo 'selected';} ?> value="1">1 Month</option>
        <option <?php if($row['trainingterms']==='2'){echo 'selected';} ?> value="2">2 Months</option>
        <option <?php if($row['trainingterms']==='3'){echo 'selected';} ?> value="3">3 Months</option>
        <option <?php if($row['trainingterms']==='4'){echo 'selected';} ?> value="4">4 Months</option>
    </select> Your continued
employment with the Company is subject to your meeting the qualifying criteria till the end of the
training and successful completion of the training.
</p>

<p class="offerterms">
    <strong>2.Probation and Confirmation: </strong>You will be on probation for a period of
    <select name="probationterms" id="">
    <option value="1">1 Month</option>
        <option <?php if($row['probationterms']==='2'){echo 'selected';} ?> value="2">2 Months</option>
        <option <?php if($row['probationterms']==='3'){echo 'selected';} ?> value="3">3 Months</option>
        <option <?php if($row['probationterms']==='4'){echo 'selected';} ?> value="4">4 Months</option>
        <option <?php if($row['probationterms']==='6'){echo 'selected';} ?> value="6">6 Months</option>
        <option <?php if($row['probationterms']==='12'){echo 'selected';} ?> value="12">12 Months</option>
    </select>from the date of completion of the training and
your allocation to Unit. On successful completion of your probation, you will be confirmed as a
permanent employee. Your confirmation is also subject to your submitting the documents required by
the Company
</p>
<p class="offerterms"><strong>3. Leaves : </strong>
During probation, you will receive 
<select name="earnedLeave" id="earnedLeave" >
<option value="None">None working days</option>

    <option <?php if($row['earnedLeave']==='5')  {echo 'selected';}?> value="5">5 working days</option>
    <option <?php if($row['earnedLeave']==='10') {echo 'selected';} ?> value="10">10 working days</option>
    <option <?php if($row['earnedLeave']==='15') {echo 'selected';} ?> value="15">15 working days</option>
    <option <?php if($row['earnedLeave']==='20') {echo 'selected';} ?> value="20">20 working days</option>
    <option <?php if($row['earnedLeave']==='25') {echo 'selected';} ?> value="25">25 working days</option>
    <option <?php if($row['earnedLeave']==='30') {echo 'selected';} ?> value="30">30 working days</option>
</select> of leave annually. Once confirmed as a permanent employee, you will be eligible for 

<select name="earnedLeavepermanant" id="earnedLeave2" >
    <option value="None">None working days</option>
    <option <?php if($row['earnedLeavepermanant']==='5'){echo 'selected';} ?> value="5">5 working days</option>
    <option <?php if($row['earnedLeavepermanant']==='10'){echo 'selected';} ?> value="10">10 working days</option>
    <option <?php if($row['earnedLeavepermanant']==='15'){echo 'selected';} ?> value="15">15 working days</option>
    <option <?php if($row['earnedLeavepermanant']==='20'){echo 'selected';} ?> value="20">20 working days</option>
    <option <?php if($row['earnedLeavepermanant']==='25'){echo 'selected';} ?> value="25">25 working days</option>
    <option <?php if($row['earnedLeavepermanant']==='30'){echo 'selected';} ?> value="30">30 working days</option>
</select> of leave annually.
</p>

<p class="offerterms"><strong>4.Increments and Promotions :</strong>
<textarea name="incrementterms" class="terms_textarea" id=""><?php echo $row['incrementterms']; ?>
</textarea>
</p>

<p class="offerterms">
    <strong>5.Transfer :</strong>
Your services can be transferred to any of our units / departments situated anywhere in India or
abroad. At such time compensation applicable to a specific location will be
<select name="compensationLocation" id="compensationLocation" >
    <option <?php if($row['compensationLocation']==='payable'){echo 'selected';} ?> <?php if($row['compensationLocation']==='payable'){echo 'selected';} ?> value="payable">Payable to you</option>
    <option <?php if($row['compensationLocation']==='notPayable'){echo 'selected';} ?> <?php if($row['compensationLocation']==='notPayable'){echo 'selected';} ?> value="notPayable">Not Payable to you</option>
</select>
</p>

<p class="offerterms"><strong>6.Notice Period :</strong>
During the probation period, if your performance is found to be unsatisfactory or if it does not meet the prescribed criteria, your training/employment can be terminated by the Company with
<select name="noticePeriod" id="noticePeriod" >
    <option <?php if($row['noticePeriod']==='1 month'){echo 'selected';} ?> value="1 month">1 Month</option>
    <option <?php if($row['noticePeriod']==='2 months'){echo 'selected';} ?> value="2 months">2 Months</option>
    <option <?php if($row['noticePeriod']==='3 months'){echo 'selected';} ?> value="3 months">3 Months</option>
</select> notice or salary thereof , On confirmation, you will be required to give 
<select name="noticePeriodconfirm" id="noticePeriod2" >
    <option <?php if($row['noticePeriodconfirm']==='1 month'){echo 'selected';} ?> value="1 month">1 Month</option>
    <option <?php if($row['noticePeriodconfirm']==='2 months'){echo 'selected';} ?> value="2 months">2 Months</option>
    <option <?php if($row['noticePeriodconfirm']==='3 months'){echo 'selected';} ?> value="3 months">3 Months</option>
</select>
 notice or salary
thereof in case you decide to leave our services, subject to the Company's discretion
</p>
<p class="offerterms"><strong>7.Background Checks :</strong>
The Company may conduct background checks before or after your joining date to verify your identity, address, education, work experience, and criminal history. You consent to these checks and must provide any required documents as requested by the Company. If you fail to submit the necessary documents or if the background check results are unsatisfactory, the Company may withdraw the offer or take appropriate action, including termination. If any discrepancies arise during the check, the Company may ask for additional information before proceeding. A passport copy is required at the time of joining; failure to provide it will result in a criminal background check.
</p>
<p class="offerterms">
    <input type="text" class="fulllength" name="customtermheading" value="<?php echo $row['customheading'] ?>" placeholder="Custom terms or benefit heading if any write them here">
    <textarea type="text" class="fulllength" name="customterm" id="customtermofferletter" value="<?php echo $row['customterm'] ?>" placeholder="Custom terms or benefit if any write them here"></textarea>
</p>
<p class="offerterms">
    <input type="text" class="fulllength" name="customtermheading2" value="<?php echo $row['customheading2'] ?>" placeholder="Custom terms or benefit heading if any write them here">
    <textarea type="text" class="fulllength" name="customterm2" id="customtermofferletter" value="<?php echo $row['customterm2'] ?>" placeholder="Custom terms or benefit if any write them here"></textarea>
</p>
<div class="fulllength" id="quotationnextback">
<button
  class="quotationnavigatebutton bg-white text-center w-30 rounded-lg h-10 relative text-black text-sm font-semibold group"
  type="button" onclick="backtoofferpay()"
>
<div
    class="rounded-md h-8 w-1/4 flex items-center justify-center absolute left-1 top-[2px] group-hover:w-[110px] z-10 duration-300"
    style="background-color: #1C549E;" 
  >  
  
  <svg
      xmlns="http://www.w3.org/2000/svg"
      viewBox="0 0 1024 1024"
      height="18px"
      width="18px"
    >
      <path
        d="M224 480h640a32 32 0 1 1 0 64H224a32 32 0 0 1 0-64z"
        fill="white" 
      ></path>
      <path
        d="m237.248 512 265.408 265.344a32 32 0 0 1-45.312 45.312l-288-288a32 32 0 0 1 0-45.312l288-288a32 32 0 1 1 45.312 45.312L237.248 512z"
        fill="white" 
      ></path>
    </svg>
  </div>
  <p class="translate-x-1">Back</p>
</button>

<button
  class="quotationnavigatebutton bg-white text-center w-30 rounded-lg h-10 relative text-black text-sm font-semibold group"
  type="button" onclick="nexttosender()"
>
  <div
    class="bg-custom-blue rounded-md h-8 w-1/4 flex items-center justify-center absolute left-1 top-[2px] group-hover:w-[110px] z-10 duration-300"
    style="background-color: #1C549E;" 

  >
  <svg
      xmlns="http://www.w3.org/2000/svg"
      viewBox="0 0 1024 1024"
      height="18px"
      width="18px"
      transform="rotate(180)" 
    >
      <path
        d="M224 480h640a32 32 0 1 1 0 64H224a32 32 0 0 1 0-64z"
        fill="white" 
      ></path>
      <path
        d="m237.248 512 265.408 265.344a32 32 0 0 1-45.312 45.312l-288-288a32 32 0 0 1 0-45.312l288-288a32 32 0 1 1 45.312 45.312L237.248 512z"
        fill="white" 
      ></path>
    </svg>
  </div>
  <p class="translate-x-1" >Next</p>
</button>

</div>
<br>


    </div>











<div class="" id="offersendersection">
<p class="headingpara">Senders Details: </p>
<div class="outer02">
<div class="trial1" id="sendernameofferletterdiv">
<select name="sendersname" id="sendernameofferletter" class="input02" onchange="fetchTeamMemberDetails(this.value)">
    <option value="" disabled selected>Senders Name</option>
    <option value="New Member">New Member</option>
    <?php
    $sendersinfo = "SELECT * FROM `team_members` WHERE company_name='$companyname001' AND (department='Management' OR department='Human Resource Department')";
    $senderresult = mysqli_query($conn, $sendersinfo);
    if (mysqli_num_rows($senderresult) > 0) {
        while ($senderrow = mysqli_fetch_assoc($senderresult)) {
    ?>
        <option <?php if($row['sendersname']=== $senderrow['name']){echo 'selected';} ?> value="<?php echo $senderrow['name']; ?>"><?php echo $senderrow['name'] . ' (' . $senderrow['department'] . ')'; ?></option>
    <?php } } ?>
</select>
        </div>

<div class="trial1" id="newteammemberdiv">
    <input type="text" id="newteammemberinput" value="<?php echo $row['newsendername'] ?>" name="newsendername" placeholder="" class="input02">
    <label for="" class="placeholder2">Name</label>
</div>

<div class="trial1">
    <input type="text" id="designation" placeholder="" value="<?php echo $row['designation'] ?>" name="designation" class="input02">
    <label for="" class="placeholder2">Designation</label>
</div>
<div class="trial1">
    <input type="text" id="email" placeholder="" name="sendersemail" value="<?php echo $row['sendersemail'] ?>" class="input02">
    <label for="" class="placeholder2">Email</label>
</div>
        </div>
        <div class="fulllength" id="quotationnextback">
<button
  class="quotationnavigatebutton bg-white text-center w-30 rounded-lg h-10 relative text-black text-sm font-semibold group"
  type="button" onclick="backtoterms()"
>
<div
    class="rounded-md h-8 w-1/4 flex items-center justify-center absolute left-1 top-[2px] group-hover:w-[110px] z-10 duration-300"
    style="background-color: #1C549E;" 
  >  
  
  <svg
      xmlns="http://www.w3.org/2000/svg"
      viewBox="0 0 1024 1024"
      height="18px"
      width="18px"
    >
      <path
        d="M224 480h640a32 32 0 1 1 0 64H224a32 32 0 0 1 0-64z"
        fill="white" 
      ></path>
      <path
        d="m237.248 512 265.408 265.344a32 32 0 0 1-45.312 45.312l-288-288a32 32 0 0 1 0-45.312l288-288a32 32 0 1 1 45.312 45.312L237.248 512z"
        fill="white" 
      ></path>
    </svg>
  </div>
  <p class="translate-x-1">Back</p>
</button>

<button
  class="quotationnavigatebutton bg-white text-center w-30 rounded-lg h-10 relative text-black text-sm font-semibold group"
  type="submit" name="generateofferletter" 
>
  <div
    class="bg-custom-blue rounded-md h-8 w-1/4 flex items-center justify-center absolute left-1 top-[2px] group-hover:w-[110px] z-10 duration-300"
    style="background-color: #1C549E;" 

  >
  <svg
      xmlns="http://www.w3.org/2000/svg"
      viewBox="0 0 1024 1024"
      height="18px"
      width="18px"
      transform="rotate(180)" 
    >
      <path
        d="M224 480h640a32 32 0 1 1 0 64H224a32 32 0 0 1 0-64z"
        fill="white" 
      ></path>
      <path
        d="m237.248 512 265.408 265.344a32 32 0 0 1-45.312 45.312l-288-288a32 32 0 0 1 0-45.312l288-288a32 32 0 1 1 45.312 45.312L237.248 512z"
        fill="white" 
      ></path>
    </svg>
  </div>
  <p class="translate-x-1" >Submit</p>
</button>

</div>
<br>    


<!-- <button class="epc-button">Submit</button> -->
        </div>




        </div>
    </form>


</head>
    
</body>
<script>
    function toggleBonusInput() {
        const bonusCriteria = document.getElementById('bonusCriteria').value;
        const bonusInPercentage = document.getElementById('bonusInPercentage');
        const calculatedBonusContainer = document.getElementById('calculatedBonusContainer');
        const bonusCriteriaSelect = document.getElementById('bonusCriteriaSelect');
        const bonusAmount = document.getElementById('bonusAmount');

        if (bonusCriteria === 'Percentage Of Basic Salary') {
            bonusInPercentage.style.display = 'block';
            calculatedBonusContainer.style.display = 'block';
            bonusAmount.style.display = 'none';
        } 
        else if(bonusCriteria === 'Specific Amount'){
            bonusAmount.style.display='block';
            bonusInPercentage.style.display = 'none';
            calculatedBonusContainer.style.display = 'none';

        }
        else if(bonusCriteria === 'no bonus'){
            bonusCriteriaSelect.style.display='none';
            bonusAmount.style.display='none';
            bonusInPercentage.style.display = 'none';
            calculatedBonusContainer.style.display = 'none';

        }
        else {
            bonusInPercentage.style.display = 'none';
            calculatedBonusContainer.style.display = 'none';
            bonusAmount.style.display = 'none';
        }
    }

    // Calculate bonus amount based on percentage
    function calculateBonus() {
        const basicSalary = parseFloat(document.getElementById('basicsalary').value) || 0;
        const bonusPercentage = parseFloat(document.getElementById('bonusPercentage').value) || 0;
        const calculatedBonus = document.getElementById('calculatedBonus');

        // Check if both basic salary and bonus percentage are entered before calculating
        if (basicSalary > 0 && bonusPercentage > 0) {
            const bonusAmount = (basicSalary * bonusPercentage) / 100;
            calculatedBonus.value = bonusAmount.toFixed(1); // Display the calculated bonus amount
        } else {
            calculatedBonus.value = ''; // Clear the bonus amount if input is invalid
        }
    }

    // Trigger the toggle function when the page loads, to ensure the initial state is correct
    window.onload = function() {
        toggleBonusInput();
    };        
        function showRelevantFields() {
        // Get the selected value
        const selectedCriteria = document.getElementById('bonusCriteriaSelect').value;

        // Hide all fields initially
        document.getElementById('monthlyBonus').classList.add('newhidden');
        document.getElementById('quarterlyBonus').classList.add('newhidden');
        document.getElementById('partPaymentMonthly').classList.add('newhidden');
        document.getElementById('partPaymentYearEnd').classList.add('newhidden');

        // Show relevant fields based on the selected criteria
        if (selectedCriteria === 'Bonus To Be Paid On Monthly Basis') {
            document.getElementById('monthlyBonus').classList.remove('newhidden');
        } else if (selectedCriteria === 'Bonus To Be Paid Quarterly') {
            document.getElementById('quarterlyBonus').classList.remove('newhidden');
        } else if (selectedCriteria === 'Partial Bonus Paid Monthly, Remaining at Year-End') {
            document.getElementById('partPaymentMonthly').classList.remove('newhidden');
            document.getElementById('partPaymentYearEnd').classList.remove('newhidden');
        }
    }

    function professionaldeduction() {
            const selectValue = document.getElementById('professionaldd').value;
            const taxAmountField = document.getElementById('taxAmountField');

            if (selectValue === 'Yes') {
                taxAmountField.classList.remove('newhidden'); // Show the field
            } else {
                taxAmountField.classList.add('newhidden'); // Hide the field
            }
        }


        function fetchTeamMemberDetails(name) {
    // Check if "New Member" is selected
    if (name === "New Member") {

        document.getElementById('newteammemberdiv').style.display = "block";
        // document.getElementById('sendernameofferletterdiv').style.display = "none";
        document.getElementById('designation').value = "";
        document.getElementById('email').value = "";
        return;
    } else {
        document.getElementById('newteammemberdiv').style.display = "none";
    }

    // AJAX request to fetch data from PHP
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "fetch_team_member.php?name=" + name, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var data = JSON.parse(xhr.responseText);
            if (data) {
                document.getElementById('designation').value = data.designation;
                document.getElementById('email').value = data.email;
            } else {
                // If no data is returned, clear the fields
                document.getElementById('designation').value = "";
                document.getElementById('email').value = "";
            }
        }
    };
    xhr.send();
}

    function termsofoffersectionfunction(){
   const termsofoffersection = document.getElementById("termsofoffersection");
    const offerletterpaysection =document.getElementById("offerletterpaysection");

    offerletterpaysection.style.display='none';
    termsofoffersection.style.display='flex';


}
function backtoofferpay(){
    const offerletterpaysection =document.getElementById("offerletterpaysection");
    const termsofoffersection =document.getElementById("termsofoffersection");

    termsofoffersection.style.display='none';
    offerletterpaysection.style.display='flex';


}
function nexttosender(){
    const termsofoffersection= document.getElementById("termsofoffersection");
    const offersendersection= document.getElementById("offersendersection");
     
    termsofoffersection.style.display='none';
    offersendersection.style.display='flex';



}
function backtoterms(){
    const offersendersection=document.getElementById('offersendersection');
    const termsofoffersection=document.getElementById('termsofoffersection');

    offersendersection.style.display='none';
    termsofoffersection.style.display='flex';

}

document.addEventListener('DOMContentLoaded', function() {
    // Check if oem_fleet_type7 is not empty and call seco_equip_2()
    var bonusCriteria = document.getElementById('bonusCriteria');
    if (bonusCriteria.value !== '') {
        toggleBonusInput();
    }
});

document.addEventListener('DOMContentLoaded', function() {
    // Check if oem_fleet_type7 is not empty and call seco_equip_2()
    var bonusCriteriaSelect = document.getElementById('bonusCriteriaSelect');
    if (bonusCriteriaSelect.value !== '') {
        showRelevantFields();
    }
});

document.addEventListener('DOMContentLoaded', function() {
    // Check if oem_fleet_type7 is not empty and call seco_equip_2()
    var pfdeductionselect = document.getElementById('pfdeductionselect');
    if (pfdeductionselect.value !== '') {
        pfdeduction();
    }
});

document.addEventListener('DOMContentLoaded', function() {
    // Check if oem_fleet_type7 is not empty and call seco_equip_2()
    var esisdd = document.getElementById('esisdd');
    if (esisdd.value !== '') {
        esisselect();
    }
});

// document.addEventListener('DOMContentLoaded', function() {
//     // Check if oem_fleet_type7 is not empty and call seco_equip_2()
//     var sendernameofferletter = document.getElementById('sendernameofferletter');
//     if (sendernameofferletter.value !== '') {
//         fetchTeamMemberDetails(name);
//     }
// });


</script>
</html>