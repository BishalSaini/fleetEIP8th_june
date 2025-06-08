<?php 
include "partials/_dbconnect.php";
$id=$_GET['id'];
session_start();
$companyname001=$_SESSION['companyname'];

$sql_logo_fetch="SELECT * FROM `basic_details` where companyname='$companyname001'";
$result_fetch_logo=mysqli_query($conn , $sql_logo_fetch);
$row_logo_fetch=mysqli_fetch_assoc($result_fetch_logo);


$sql="SELECT * FROM `employeedetails` where id=$id and companyname='$companyname001'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js" defer></script>

    <title>View Offer Letter</title>
    <link rel="stylesheet" href="style.css">
    <style>
                    .page-break {
                page-break-before: always; /* Forces a page break before the element */
                page-break-inside: avoid; /* Avoids breaking inside the element */
            }

            body {
    font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande',
                 'Lucida Sans Unicode', Arial, sans-serif;
    font-size: 14px;
    line-height: 1.6;
    background-color: #f4f4f4;
    margin: 20px;
}

    </style>
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
    <script src="main.js"></script>
</head>
<body>
<div class="fulllength">
        <button onclick="downloadsummary()" class="downloadbuttonsummary">Download</button>
        <button onclick="window.location.href='offerletterdashboard.php'" class="gobackbuttonsummary">    <i class="bi bi-arrow-left"></i> Go Back
        </button>
    </div>

    <div class="printofferlettercontainer">
    <div class="logo_namecontainerofferletter">
        <div class="companylogoofferletter">
            <img src="img/<?php echo ($row_logo_fetch['companylogo']) ?>" alt="">
        </div>
        <div class="compname_"><span><?php echo $companyname001 ?></span> </div>
        </div>
        <hr>
        <p class="">Date: <?php echo date('d-m-Y', strtotime($row['generatedon'])); ?>  </p>
        <div class="offerto">
            <p>To , <br><?php echo $row['fullname'] ?></p>
            <p><?php echo $row['to_address'] ?></p>
            <p id="offercontactemail">Email : <?php echo $row['contactemail'] ?></p>
            <p>Cell : <?php echo $row['contactnumber'] ?></p>

        </div>
        <p class="mt20">Dear <?php echo ucwords ($row['fullname']) ?>,</p>
        <p class="mt20">Welcome to <?php echo ucwords ($row['companyname']) . '!' ?></p>

        <p class="mt20">Your skills and qualifications align well with the goals and values of our organization, and we are confident that you will make significant contributions to our continued success. We are excited about the opportunity to potentially work together and look forward to the possibility of you joining our team.</p>

        <p class="mt20 fulllength">At <?php echo ucwords ($row['companyname']) ?>, we assure that your career will never stand still, we will inspire you to build what's next and we
will navigate further, together. Our journey of learnability, values and trusted relationships with our clients
continue to be the cornerstones of our organization and these values are upheld only because of our people .</p>
<p class="mt20">We look forward to working with you and wish you success in your career with us.</p>

<p class="mt20">Warm regards,</p>
<p><?php echo ucwords($row['sendersname']); ?></p>
<p><?php echo ucwords($row['designation']); ?></p>
<p><?php echo ($row['sendersemail']); ?></p>
<br>
<div class="page-break"></div>
<div class="logo_namecontainerofferletter" id="eachpagelogo">
        <div class="companylogoofferletter">
            <img src="img/<?php echo ($row_logo_fetch['companylogo']) ?>" alt="">
        </div>
        </div>
        <p class="mt20">Dear <?php echo ucwords ($row['fullname']) ?>,</p>
<p class="mt20">Congratulations! We are delighted to offer you the position of  <strong><?php echo $row['jobrole'] ?></strong> at <strong><?php echo $row['department'].'department' ?></strong> . Your scheduled date of employment with us will be <strong><?php echo date("d-M-Y", strtotime($row['joindate'])); ?></strong> and your joining locatio will be <strong><?php echo $row['joinlocation'] ?></strong></p>
<p class="mt20">Here are the terms and conditions of our offer :</p>
<p class="mt10">
    <strong>1.Training :</strong>The training program will consist of virtual training and on-the-job training. The duration
    of the virtual training will be  <?php echo $row['trainingterms'] . 'Months' ?>
  Your continued
employment with the Company is subject to your meeting the qualifying criteria till the end of the
training and successful completion of the training.
</p>
<p class="mt10">
<strong>2.Probation and Confirmation: </strong>You will be on probation for a period of <?php echo $row['probationterms'] . 'Months' ?>
  from the date of completion of the training and
your allocation to Unit. On successful completion of your probation, you will be confirmed as a
permanent employee. Your confirmation is also subject to your submitting the documents required by
the Company
</p>
<p class="mt10"><strong>3. Leaves : </strong>
During probation, you will receive  <?php echo $row['earnedLeave'] ?> working days
of leave annually. Once confirmed as a permanent employee, you will be eligible for <?php echo $row['earnedLeavepermanant'] ?> working days
of leave annually.
</p>
<p class="mt10"><strong>4.Increments and Promotions :</strong> <?php echo $row['incrementterms'] ?></p>
<p class="mt10">    <strong>5.Transfer :</strong>
Your services can be transferred to any of our units / departments situated anywhere in India or
abroad. At such time compensation applicable to a specific location will be <?php echo $row['compensationLocation'] == 'payable' ? 'Payable to you' : 'Not Payable to you'; ?>

</p>
<p class="mt10">
<strong>6.Notice Period :</strong>
During the probation period, if your performance is found to be unsatisfactory or if it does not meet the prescribed criteria, your training/employment can be terminated by the Company with
<?php echo $row['noticePeriod'] ?> notice or salary thereof , On confirmation, you will be required to give <?php echo $row['noticePeriodconfirm'] ?>
notice or salary
thereof in case you decide to leave our services, subject to the Company's discretion

</p>
<p class="mt10"><strong>7.Background Checks :</strong>
The Company may conduct background checks before or after your joining date to verify your identity, address, education, work experience, and criminal history. You consent to these checks and must provide any required documents as requested by the Company. If you fail to submit the necessary documents or if the background check results are unsatisfactory, the Company may withdraw the offer or take appropriate action, including termination. If any discrepancies arise during the check, the Company may ask for additional information before proceeding. A passport copy is required at the time of joining; failure to provide it will result in a criminal background check.</p>

<p class="mt10"><strong><?php echo $row['customheading'] ?></strong>
<?php echo $row['customterm'] ?></p>
<p class="mt10"><strong><?php echo $row['customheading2'] ?></strong>
<?php echo $row['customterm2'] ?></p>
<div class="page-break"></div>
<div class="logo_namecontainerofferletter" id="eachpagelogo">
        <div class="companylogoofferletter">
            <img src="img/<?php echo ($row_logo_fetch['companylogo']) ?>" alt="">
        </div>
        </div>
<div class="fulllength" id="annexureheading"><h3>ANNEXURE - I (Compensation) </h3></div>

<table class="annexure1tableoffer" >
    <tr>
        <td><strong>Name:</strong></td>
        <td class="lefttdborder"><?php echo $row['fullname']; ?></td>
    </tr>
    <tr>
        <td><strong>Job Role:</strong></td>
        <td class="lefttdborder"><?php echo $row['jobrole']; ?></td>
    </tr>
</table><br>
<p><strong>Monthly Component :</strong></p>
<table class="annexure1tableoffer">
    <tr>
        <td><strong>Basic Salary :</strong></td>
        <td class="lefttdborder"><?php echo $row['basicsalary']; ?></td>
    </tr>

    <?php if (!empty($row['hr']) && $row['hr'] != 0): ?>
    <tr>
        <td><strong>House Rent Allowance:</strong></td>
        <td class="lefttdborder"><?php echo $row['hr']; ?></td>
    </tr>
    <?php endif; ?>

    <?php if (!empty($row['da']) && $row['da'] != 0): ?>
    <tr>
        <td><strong>Dearness Allowance:</strong></td>
        <td class="lefttdborder"><?php echo $row['da']; ?></td>
    </tr>
    <?php endif; ?>

    <?php if (!empty($row['ta']) && $row['ta'] != 0): ?>
    <tr>
        <td><strong>Travel Allowance:</strong></td>
        <td class="lefttdborder"><?php echo $row['ta']; ?></td>
    </tr>
    <?php endif; ?>

    <?php if ($row['bonusCriteria'] != 'No Bonus' && !empty($row['bonus_criteria']) && 
            ($row['bonus_criteria'] == 'Partial Bonus Paid Monthly, Remaining at Year-End' || 
             $row['bonus_criteria'] == 'Bonus To Be Paid On Monthly Basis')): ?>
    <tr>
        <td><strong>Bonus:</strong> <?php echo $row['bonusCriteria'] . ' (' . $row['bonus_criteria'] . ')'; ?></td>
        <td class="lefttdborder">
        <?php 
    $bonusAmount = 0;
    if ($row['bonus_criteria'] == 'Partial Bonus Paid Monthly, Remaining at Year-End') {
        $bonusAmount = $row['monthly_bonus_percentage'];
    } elseif ($row['bonus_criteria'] == 'Bonus To Be Paid On Monthly Basis') {
        $bonusAmount = $row['monthly_bonus_amount'];
    }
    echo number_format($bonusAmount, 2);  // Display the bonus amount with two decimal places
?>
        </td>
    </tr>
    <?php endif; ?>
</table>
<br>
<?php
// Flag to check if any row should be displayed
$showBonus = false;
?>

<?php
// Check if at least one row will be displayed
if (!empty($row['year_end_bonus_percentage']) && $row['year_end_bonus_percentage'] != 0) {
    $showBonus = true; // Set the flag to true if this row is displayed
}

if ($row['bonusCriteria'] != 'No Bonus' && !empty($row['bonus_criteria']) && 
    ($row['bonus_criteria'] == 'Full Bonus To Be Paid Once In A Year' || 
     $row['bonus_criteria'] == 'Bonus To Be Paid Quarterly')) {
    $showBonus = true; // Set the flag to true if this row is displayed
}
?>

<?php if ($showBonus): ?>
    <p><strong>Annual Component :</strong></p>
    <table class="annexure1tableoffer">
        <?php 
        if (!empty($row['year_end_bonus_percentage']) && $row['year_end_bonus_percentage'] != 0) {
        ?>
            <tr>
                <td><strong>Bonus : </strong>(Balance bonus will be paid out in the end of the financial year after adjusting
                the advance paid out on a monthly basis)</td>
                <td class="lefttdborder"><?php echo number_format($row['year_end_bonus_percentage'], 2); ?></td>
            </tr>
        <?php 
        }

        if ($row['bonusCriteria'] != 'No Bonus' && !empty($row['bonus_criteria']) && 
                  ($row['bonus_criteria'] == 'Full Bonus To Be Paid Once In A Year' || 
                   $row['bonus_criteria'] == 'Bonus To Be Paid Quarterly')) {
        ?>
            <tr>
                <td><strong>Bonus : </strong></td>
                <td class="lefttdborder">
                    <?php 
                    if ($row['bonusCriteria'] === 'Percentage Of Basic Salary') {
                        echo number_format($row['calculatedBonus'], 2);
                    } elseif ($row['bonusCriteria'] === 'Specific Amount') {
                        echo number_format($row['bonusAmount'], 2);
                    }
                    ?>
                </td>
            </tr>
        <?php 
        }
        ?>
    </table>
<?php else: ?>
<?php endif; ?>
<br>



            </table>

            <table class="annexure1tableoffer" id="gratuitytable">
            <?php if (!empty($row['gratuity']) && $row['gratuityeligibility'] != 0): ?>
                <p><strong>Retiral Benefits</strong></p>

    <tr>
        <td><strong>Gratuity : </strong></td>
        <td class="lefttdborder"><?php echo $row['gratuity']; ?>  (Availability Criteria : After <?php echo $row['gratuityeligibility'] ?> Years) </td>
    </tr>
    <?php endif; ?>

</table>

            <p><strong>Statutory Contributions</strong></p>
            <table class="annexure1tableoffer">
            <?php if (!empty($row['deductionamt']) && $row['deductionamt'] != 0): ?>
    <tr>
        <td><strong>Provident Fund : </strong></td>
        <td class="lefttdborder"><?php echo $row['deductionamt']; ?></td>
    </tr>
    <?php endif; ?>
    <?php if (!empty($row['professionaltaxdeduction']) && $row['professionaltaxdeduction'] != 0): ?>
    <tr>
        <td><strong>Professioanl Tax Deduction : </strong></td>
        <td class="lefttdborder"><?php echo $row['professionaltaxdeduction']; ?></td>
    </tr>
    <?php endif; ?>


    <?php if (!empty($row['esisdeductionamt']) && $row['esisdeductionamt'] != 0): ?>
    <tr>
        <td><strong>ESIS Deduction : </strong></td>
        <td class="lefttdborder"><?php echo $row['esisdeductionamt']; ?></td>
    </tr>
    <?php endif; ?>
    <?php if (!empty($row['otherdedeuction']) && $row['otherdedeuction'] != 0): ?>
    <tr>
        <td><strong>Other Deduction : </strong></td>
        <td class="lefttdborder"><?php echo $row['otherdedeuction']; ?></td>
    </tr>
    <?php endif; ?>
    <tr>
        <td><strong>Total Gross Salary :</strong></td>
        <td class="lefttdborder"><?php echo $row['grosssalary']; ?></td>
    </tr> 
    <tr>
        <td><strong>Cost To Company :</strong></td>
        <td class="lefttdborder"><?php echo $row['ctc']; ?></td>
    </tr> 



            </table>


<p class="notesofferletter">Your eligibility and the final pay out of any Gratuity amounts will be
determined in strict accordance with the provisions of the Payment of Gratuity Act
</p>
<p class="notesofferletter">Employee State Insurance ("ESI") may be applicable to employees as per the applicable statutory regulations. If ESI is applicable, the
employee and the employer will contribute towards ESI as per the provisions of the ESI Act, 1948.</p>
        <div class="fulllengthright">○ Powered by Fleet EIP</div>
    </div>
    
</body>
<script>
    function downloadsummary() {
        const element = document.querySelector('.printofferlettercontainer');

        html2pdf(element, {
            margin: [0.2, 0.2, 0.2, 0.2], 
            filename: '<?php echo $row['fullname'] .' Offer letter'. '.pdf'; ?>',
            image: { type: 'jpeg', quality: 1.0 },
            html2canvas: { 
                dpi: 400, 
                letterRendering: true, 
                scale: 4, 
                useCORS: true 
            },
            jsPDF: { 
                unit: 'in', 
                format: 'letter', 
                orientation: 'portrait' 
            }
        });
    }
</script>

</html>