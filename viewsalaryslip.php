<?php 
include "partials/_dbconnect.php";
$id=$_GET['id'];
session_start();
$companyname001=$_SESSION['companyname'];

$sql_logo_fetch="SELECT * FROM `basic_details` where companyname='$companyname001'";
$result_fetch_logo=mysqli_query($conn , $sql_logo_fetch);
$row_logo_fetch=mysqli_fetch_assoc($result_fetch_logo);


$sql = "SELECT * FROM `salaryslip` WHERE id=$id AND companyname='$companyname001'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$completeinfo = "SELECT * FROM `employeedetails` WHERE employeeid='" . $row['employee_id'] . "'"; // Concatenate properly
$resultinfo = mysqli_query($conn, $completeinfo); // Execute query
$rowinfo = mysqli_fetch_assoc($resultinfo); // Fetch result

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>

    <title>View Salary Slip</title>
    <link rel="stylesheet" href="style.css">
    <style>
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
</head>
<body>
<div class="fulllength">
        <button onclick="downloadsummary()" class="downloadbuttonsummary">Download</button>
        <button onclick="window.location.href='salaryslipdashboard.php'" class="gobackbuttonsummary">    <i class="bi bi-arrow-left"></i> Go Back
        </button>
    </div>
    <div class="printofferlettercontainer">
    <div class="logo_namecontainerofferletter">
        <div class="companylogoofferletter">
            <img src="img/<?php echo ($row_logo_fetch['companylogo']) ?>" alt="">
        </div>
        <div class="compname_"><span><?php echo $companyname001 ?></span> </div>
        </div>
        <p class="payslipheading">Pay Slip for the Month of <?php echo date("F-Y", strtotime($row['salary_month'])) ?></p>

<br>        <p><strong>Ref No :</strong> <?php echo $row['refno'] ?></p>
        <div class="employeedetailsalaryslip">
            <div class="employee1">
                <p><strong>Employee Id : </strong><?php echo $row['employee_id'] ?></p>
                <p><strong>Employee Name : </strong><?php echo $row['employee_name'] ?></p>
                <p><strong>Designation : </strong><?php echo ucwords ($row['jobrole']) ?></p>
                <p><strong>Department : </strong><?php echo strtoupper($row['department']) ?></p>
                <p><strong>PAN : </strong><?php echo strtoupper($rowinfo['pan']) ?></p>
                <p><strong>Bank Name : </strong><?php echo strtoupper($row['bankname']) ?></p>
                </div>
            <div class="employee2">
            <p <?php if(empty($rowinfo['uan'])) { echo 'class="hideit"'; } ?>><strong>UAN : </strong><?php echo $rowinfo['uan']; ?></p>
<p <?php if(empty($rowinfo['pf_no'])) { echo 'class="hideit"'; } ?>><strong>PF Number : </strong><?php echo $rowinfo['pf_no']; ?></p>
<p <?php if(empty($rowinfo['esi_no'])) { echo 'class="hideit"'; } ?>><strong>ESI Number : </strong><?php echo $rowinfo['esi_no']; ?></p>
<p <?php if(empty($row['standard_days'])) { echo 'class="hideit"'; } ?>><strong>Standard Days : </strong><?php echo strtoupper($row['standard_days']); ?></p>
<p <?php if(empty($row['days_worked'])) { echo 'class="hideit"'; } ?>><strong>Days Worked : </strong><?php echo strtoupper($row['days_worked']); ?></p>
<p <?php if(empty($row['loss_of_pay_days'])) { echo 'class="hideit"'; } ?>><strong>Loss Of Pay Days : </strong><?php echo strtoupper($row['loss_of_pay_days']); ?></p>

            </div>
        </div>
        <br>
        <table border="1" class="boderbottomtable" style="width:100%; border-collapse:collapse; text-align:left;">
    <thead>
        <tr>
            <th style="width:50%; padding:8px;"><strong>Earnings</strong></th>
            <th style="width:50%; padding:8px;"><strong>Deductions</strong></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="padding:8px; vertical-align:top;">
                <table style="width:100%; border-collapse:collapse;">
                    <tr>
                        <td style="padding:4px;">Basic Salary:</td>
                        <td style="padding:4px; text-align:right;"><?php echo $row['basic_salary']; ?></td>
                    </tr>
                    <tr <?php if(empty($row['hra']) || $row['hra'] == 0){echo 'class="hideit"';} ?>>
    <td style="padding:4px;">House Rent Allowance:</td>
    <td style="padding:4px; text-align:right;"><?php echo $row['hra']; ?></td>
</tr>
<tr <?php if(empty($row['da']) || $row['da'] == 0){echo 'class="hideit"';} ?>>
    <td style="padding:4px;">Dearness Allowance:</td>
    <td style="padding:4px; text-align:right;"><?php echo $row['da']; ?></td>
</tr>
<tr <?php if(empty($row['ta']) || $row['ta'] == 0){echo 'class="hideit"';} ?>>
    <td style="padding:4px;">Transport Allowance:</td>
    <td style="padding:4px; text-align:right;"><?php echo $row['ta']; ?></td>
</tr>
<tr <?php if(empty($row['otherallowance']) || $row['otherallowance'] == 0){echo 'class="hideit"';} ?>>
    <td style="padding:4px;">Other Allowance:</td>
    <td style="padding:4px; text-align:right;"><?php echo $row['otherallowance']; ?></td>
</tr>
<tr <?php if(empty($row['bonus']) || $row['bonus'] == 0){echo 'class="hideit"';} ?>>
    <td style="padding:4px;">Bonus:</td>
    <td style="padding:4px; text-align:right;"><?php echo $row['bonus']; ?></td>
</tr>
                        <td style="padding:4px;"><strong>Gross Earning:</strong></td>
                        <td style="padding:4px; text-align:right;">            <?php
        $totalAllowances = $row['basic_salary'] + $row['hra'] + $row['da'] + $row['ta'] + $row['otherallowance'] + $row['bonus'];
        echo number_format($totalAllowances, 2);
    ?></td>
                    </tr>
                </table>
            </td>
            <td style="padding:8px; vertical-align:top;">
                <table style="width:100%; border-collapse:collapse;">
                <tr <?php if(empty($row['professional_tax']) || $row['professional_tax'] == 0){echo 'class="hideit"';} ?>>
    <td style="padding:4px;">Professional Tax:</td>
    <td style="padding:4px; text-align:right;"><?php echo $row['professional_tax']; ?></td>
</tr>
<tr <?php if(empty($row['provident_fund']) || $row['provident_fund'] == 0){echo 'class="hideit"';} ?>>
    <td style="padding:4px;">Provident Fund:</td>
    <td style="padding:4px; text-align:right;"><?php echo $row['provident_fund']; ?></td>
</tr>
<tr <?php if(empty($row['esic']) || $row['esic'] == 0){echo 'class="hideit"';} ?>>
    <td style="padding:4px;">ESIS Deduction:</td>
    <td style="padding:4px; text-align:right;"><?php echo $row['esic']; ?></td>
</tr>
<tr <?php if(empty($row['loan_deduction']) || $row['loan_deduction'] == 0){echo 'class="hideit"';} ?>>
    <td style="padding:4px;">Loan Deduction:</td>
    <td style="padding:4px; text-align:right;"><?php echo $row['loan_deduction']; ?></td>
</tr>
<tr <?php if(empty($row['other_deduction']) || $row['other_deduction'] == 0){echo 'class="hideit"';} ?>>
    <td style="padding:4px;">Other Deduction:</td>
    <td style="padding:4px; text-align:right;"><?php echo $row['other_deduction']; ?></td>
</tr>
                        <td style="padding:4px;"><strong>Gross Deduction:</strong></td>
                        <td style="padding:4px; text-align:right;">            <?php
        $totalDeductions = $row['professional_tax'] + $row['provident_fund'] + $row['esic'] + $row['loan_deduction'] + $row['other_deduction'];
        echo number_format($totalDeductions, 2);
    ?>
</td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>
<br>
<table border="1" style="width:50%; border-collapse:collapse; text-align:left;" id="earninginfo">
    <thead>
        <tr>
            <th style="padding:8px;">Reimbursements</th>
        </tr>
    </thead>
    <tbody>
    <tr <?php if(empty($row['travel']) || $row['travel'] == 0){echo 'class="hideit"';} ?>>
    <td style="padding:8px; vertical-align:top; display:flex; justify-content:space-between;">
        <span>Travel Reimbursement</span>
        <span><?php echo number_format($row['travel'], 2); ?></span>
    </td>
</tr>
<tr <?php if(empty($row['medical']) || $row['medical'] == 0){echo 'class="hideit"';} ?>>
    <td style="padding:8px; vertical-align:top; display:flex; justify-content:space-between;">
        <span>Medical Reimbursement</span>
        <span><?php echo number_format($row['medical'], 2); ?></span>
    </td>
</tr>
<tr <?php if(empty($row['phone']) || $row['phone'] == 0){echo 'class="hideit"';} ?>>
    <td style="padding:8px; vertical-align:top; display:flex; justify-content:space-between;">
        <span>Phone Reimbursement</span>
        <span><?php echo number_format($row['phone'], 2); ?></span>
    </td>
</tr>
<tr <?php if(empty($row['lunch']) || $row['lunch'] == 0){echo 'class="hideit"';} ?>>
    <td style="padding:8px; vertical-align:top; display:flex; justify-content:space-between;">
        <span>Lunch Reimbursement</span>
        <span><?php echo number_format($row['lunch'], 2); ?></span>
    </td>
</tr>
<tr <?php if(empty($row['internet']) || $row['internet'] == 0){echo 'class="hideit"';} ?>>
    <td style="padding:8px; vertical-align:top; display:flex; justify-content:space-between;">
        <span>Internet Reimbursement</span>
        <span><?php echo number_format($row['internet'], 2); ?></span>
    </td>
</tr>
            <td style="padding:8px; vertical-align:top; display:flex; justify-content:space-between;">
                <strong>Total Reimbursement</strong>
                <span>
                    <?php
                        $totalreimburse = $row['travel'] + $row['medical'] + $row['phone'] + $row['lunch'] + $row['internet'];
                        echo number_format($totalreimburse, 2);
                    ?>
                </span>
            </td>
        </tr>
        <tr>
            <td style="padding:8px; vertical-align:top; display:flex; justify-content:space-between;">
                <strong>Net Transfer</strong>
                <span><?php echo number_format($row['netpayable'], 2); ?></span>
            </td>
        </tr>
    </tbody>
</table>
<br>
<p <?php if(empty($row['notes']) || $row['notes'] == 0){echo 'class="hideit"';} ?>>
    <strong>Note : <?php echo $row['notes']; ?></strong>
</p>

</div>


</body>
<script>
    function downloadsummary() {
    const element = document.querySelector('.printofferlettercontainer');

    html2pdf(element, {
        margin: 0.2, // Adjust the margin as needed
        filename: '<?php echo $row['refno'] . ' ' . $row['employee_name'] . '-' . $row['salary_month'] . '.pdf';
?>',
        image: { type: 'jpeg', quality: 1.0 },
        html2canvas: { 
            dpi: 400, // Set higher DPI for better image quality
            letterRendering: true, 
            scale: 4, // Increase the scale for better quality
            useCORS: true // Use CORS to ensure images are loaded correctly
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
