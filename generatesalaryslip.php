<?php 
include "partials/_dbconnect.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$companyname001 = $_SESSION['companyname'];
$enterprise = $_SESSION['enterprise'];
$email = $_SESSION['email'];


if(isset($_GET['id'])){
    $id=$_GET['id'];
    $editsql="SELECT * FROM `employeedetails` where id=$id and companyname='$companyname001'";
    $resultedit=mysqli_query($conn,$editsql);
    $row=mysqli_fetch_assoc($resultedit);

}
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

$sql_max_ref_no = "SELECT MAX(refno) AS max_ref_no FROM `salaryslip` WHERE companyname = '$companyname001'";
$result_max_ref_no = mysqli_query($conn, $sql_max_ref_no);
$row_max_ref_no = mysqli_fetch_assoc($result_max_ref_no);
$next_ref_no = ($row_max_ref_no['max_ref_no'] === null) ? 1 : $row_max_ref_no['max_ref_no'] + 1;



if($_SERVER['REQUEST_METHOD']==='POST'){
    include "partials/_dbconnect.php";
    // Assuming the form data is sent via POST
$generatedon = $_POST['generatedon'];
$employee_name = $_POST['employee_name'];
$employee_id = $_POST['employee_id'];
$jobrole = $_POST['jobrole'];
$department = $_POST['department'];
$salary_month = $_POST['salary_month'];
$basic_salary = $_POST['basic_salary'];
$hra = $_POST['hra'];
$da = $_POST['da'];
$ta = $_POST['ta'];
$bonus = $_POST['bonus'];
$professional_tax = $_POST['professional_tax'];
$provident_fund = $_POST['provident_fund'];
$esic = $_POST['esic'];
$loan_deduction = $_POST['loan_deduction'];
$other_deduction = $_POST['otherdeduction'];
$net_salary = $_POST['net_salary'];
$notes = $_POST['notes'];
$bankname = $_POST['bankname'];
$accountholdername = $_POST['accountholdername'];
$accountnumber = $_POST['accountnumber'];
$ifsc = $_POST['ifsc'];
$branch = $_POST['branch'];
$companyname001 = $_SESSION['companyname'];
$refno=$_POST['refno'];
$otherallowance=$_POST['otherallowance'];
$totaldays=$_POST['totaldays'];
$daysworked=$_POST['daysworked'];
$lossofpaydays=$_POST['lossofpaydays'];
$netpay=$_POST['netpay'];

$ot=$_POST['ot'];
$travel=$_POST['travel'];
$phone=$_POST['phone'];
$lunch=$_POST['lunch'];
$medical=$_POST['medical'];
$internet=$_POST['internet'];
$other_reimbusrement=$_POST['other_reimbusrement'];
$incometax=$_POST['incometax'];


$sql = "INSERT INTO `salaryslip` (
    `generatedon`, `employee_name`, `ot_pay`, `travel`, `phone`, `lunch`, `medical`, `internet`, `other_reimbusrement`, `employee_id`, `jobrole`, `department`, `incometax`,
    `salary_month`, `basic_salary`, `hra`, `da`, `ta`, `bonus`, 
    `professional_tax`, `provident_fund`, `esic`, `loan_deduction`, 
    `other_deduction`, `net_salary`, `notes`, `bankname`,
    `netpayable`,`standard_days`,`days_worked`,`loss_of_pay_days`, 
    `accountholdername`, `accountnumber`, `ifsc`, `branch`, `companyname`, `created_by`,`refno`,`otherallowance`
) VALUES (
    '$generatedon', '$employee_name','$ot','$travel','$phone','$lunch','$medical','$internet','$other_reimbusrement', '$employee_id', '$jobrole', '$department','$incometax',
    '$salary_month', '$basic_salary', '$hra', '$da', '$ta', '$bonus', 
    '$professional_tax', '$provident_fund', '$esic', '$loan_deduction', 
    '$other_deduction', '$net_salary', '$notes', '$bankname', '$netpay','$totaldays',
    '$daysworked','$lossofpaydays',
    '$accountholdername', '$accountnumber', '$ifsc', '$branch', '$companyname001', '$email','$refno','$otherallowance'
)";
$resultinsert=mysqli_query($conn,$sql);
if($resultinsert){
    $_SESSION['success']='true';
}
else{
    $_SESSION['error']='true';
}
header("Location: salaryslipdashboard.php");

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary Slip </title>
    <link rel="stylesheet" href="style.css">
    <script src="main.js"></script>
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

    <form action="generatesalaryslip.php" method="POST" autocomplete="off" class="outerform">
        <div class="salaryslipformcontainer">
            <p class="headingpara">Generate Salary Slip</p>
            <div class="outer02">
            <div class="trial1">
                    <input type="date" placeholder="" value="<?php echo date('Y-m-d'); ?>" name="generatedon" class="input02">
                    <label for="" class="placeholder2">Date</label>
                </div>
                <div class="trial1">
                    <input type="text" placeholder="" value="<?php echo $next_ref_no; ?>" readonly name="refno" class="input02">
                    <label for="" class="placeholder2">Ref No</label>
                </div>
            <!-- </div>
            <div class="outer02"> -->
    

        <div class="trial1" id="selectemployeename">
            <?php
            $employeename="SELECT * FROM `employeedetails` where companyname='$companyname001' and status='Working'";
            $resultemployeename=mysqli_query($conn,$employeename);
            
            ?>
            <select name="employee_name" id="selectemployeenamedd" class="input02" onchange="fetchTeamMemberDetails(this.value)">
                <option value=""disabled selected>Select Employee</option>
                <?php 
                if(mysqli_num_rows($resultemployeename)>0){
                    while($roww=mysqli_fetch_assoc($resultemployeename)){ ?>
                    <option <?php if(isset($id) && $id=== $roww['id']){echo 'selected';} ?> value="<?php echo $roww['fullname'] ?>"><?php echo $roww['fullname'] .'['. ucwords($roww['jobrole']) .']'?></option>
                <?php    }
                }
                ?>
            </select>
            <!-- <input type="text" name="employee_name" placeholder="" class="input02" required>
            <label for="employee_name" class="placeholder2">Employee Name</label> -->
        </div>
        <div class="trial1">
            <input type="text" name="employee_id" placeholder="" class="input02" required>
            <label for="employee_id" class="placeholder2">Employee ID</label>
        </div>
        

        </div>
        <div class="outer02">
        <div class="trial1">
            <input type="text" placeholder="" name="jobrole" class="input02">
            <label for="" class="placeholder2">Job Role</label>
        </div>
        <div class="trial1">
            <input type="text" name="department" placeholder="" class="input02" required>
            <label for="designation" class="placeholder2">Department</label>
        </div>
        </div>
        <div class="outer02">
        <!-- Basic Salary -->
        <div class="trial1">
            <input type="number" name="basic_salary" id="basicslry" placeholder="" class="input02" required>
            <label for="basic_salary" class="placeholder2">Basic Salary</label>
        </div>
        
        <!-- HRA -->
        <div class="trial1">
            <input type="number" name="hra" class="input02" placeholder="" required>
            <label for="hra" class="placeholder2">House Rent Allowance</label>
        </div>
        
        <!-- Dearness Allowance -->
        <div class="trial1">
            <input type="number" name="da" class="input02" placeholder="" required>
            <label for="da" class="placeholder2">Dearness Allowance</label>
        </div>
        </div>
        
        <div class="outer02">
        <!-- Transport Allowance -->
        <div class="trial1">
            <input type="number" name="ta" class="input02" placeholder="" required>
            <label for="ta" class="placeholder2">Transport Allowance</label>
        </div>
        <div class="trial1">
            <input type="number" placeholder="" name="otherallowance"   class="input02">
            <label for="" class="placeholder2">Other Allowance</label>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" name="bonus"  class="input02">
            <label for="" class="placeholder2">Bonus</label>
        </div>
        <div class="trial1">
            <input type="number" placeholder="" name="ot" class="input02">
            <label for="" class="placeholder2">Over Time Pay</label>
        </div>
        
        <!-- Professional Tax -->
        </div>
        <div class="outer02">
        <div class="trial1">
            <input type="number" name="professional_tax" placeholder="" class="input02" required>
            <label for="professional_tax" class="placeholder2">Professional Tax</label>
        </div>

        <!-- Provident Fund -->
        <div class="trial1">
            <input type="number" name="provident_fund" placeholder="" class="input02" required>
            <label for="provident_fund" class="placeholder2">Provident Fund</label>
        </div>
        
        <!-- ESIC -->
        <div class="trial1">
            <input type="number" name="esic" placeholder="" class="input02" required>
            <label for="esic" class="placeholder2">ESIS Deduction</label>
        </div>
        </div>
        <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" name="loan_deduction" class="input02" required>
                <label for="" class="placeholder2">Loan Deduction</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="incometax" class="input02" >
                <label for="" class="placeholder2">Income Tax Deduction</label>
            </div>

            <div class="trial1">
                <input type="text" placeholder="" name="otherdeduction" class="input02">
                <label for="" class="placeholder2">Other Deduction</label>
            </div>

        </div>
        <div class="trial1">
    <input type="number" id="net_salary" placeholder="" name="net_salary" class="input02" required>
    <label for="net_salary" class="placeholder2">Net Salary</label>
</div>
<div class="trial1">
    <select name="" id="reimbursementdd" onchange="reimbusrementfucntion()" class="input02">
        <option value=""disabled selected>Employee Applicable For Reimbursement ?</option>
        <option value="Yes">Yes</option>
        <option value="No">No</option>
    </select>
</div>
<div class="outer02" id="reimbursement1">
    <div class="trial1">
        <input type="text" placeholder="" name="travel" class="input02">
        <label for="" class="placeholder2">Travel Reimbursement</label>
    </div>
    <div class="trial1">
        <input type="text" placeholder="" name="phone" class="input02">
        <label for="" class="placeholder2">Phone Reimbursement</label>
    </div>
    <div class="trial1">
        <input type="text" placeholder="" name="lunch" class="input02">
        <label for="" class="placeholder2">Lunch Reimbursement</label>
    </div>
</div>
<div class="outer02" id="reimbursement2">
<div class="trial1">
        <input type="text" placeholder="" name="medical" class="input02">
        <label for="" class="placeholder2">Medical Reimbursement</label>
    </div>
<div class="trial1">
        <input type="text" placeholder="" name="internet" class="input02">
        <label for="" class="placeholder2">Internet Cost Reimbursement</label>
    </div>
<div class="trial1">
        <input type="text" placeholder="" name="other_reimbusrement" class="input02">
        <label for="" class="placeholder2">Other Reimbursement</label>
    </div>

</div>

<div class="trial1">
    <input type="month" id="salary_month" name="salary_month" class="input02" required>
    <label for="salary_month" class="placeholder2">Salary Slip For The Month Of</label>
</div>

<div class="outer02">
    <div class="trial1">
        <input type="number" id="totaldays" name="totaldays" placeholder="" class="input02" required min="0">
        <label for="totaldays" class="placeholder2">Standard Days</label>
    </div>
    <div class="trial1">
        <input type="number" id="daysworked" name="daysworked" placeholder="" class="input02" required min="0">
        <label for="daysworked" class="placeholder2">Worked Days</label>
    </div>
    <div class="trial1">
        <input type="number" id="lossofpaydays" name="lossofpaydays" placeholder="" class="input02" required min="0">
        <label for="lossofpaydays" class="placeholder2">Loss of Pay Days</label>
    </div>
</div>

<div class="trial1">
    <input type="number" id="netpay" name="netpay" class="input02" readonly>
    <label for="netpay" class="placeholder2">Net Payable</label>
</div>

        
        <!-- Net Salary -->
        <div class="trial1">
            <textarea class="input02" placeholder="" name="notes" id=""></textarea>
            <label for="" class="placeholder2">Notes</label>
        </div>
        <div class="outer02">
        <div class="trial1">
            <input type="text" placeholder="" name="bankname" class="input02">
            <label for="" class="placeholder2">Bank Name</label>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" name="accountholdername" class="input02">
            <label for="" class="placeholder2">Account Holder Name</label>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" name="accountnumber" class="input02">
            <label for="" class="placeholder2">Account Number</label>
        </div>


    </div>
    <div class="outer02">
        <div class="trial1">
            <input type="text" placeholder="" name="ifsc" class="input02">
            <label for="" class="placeholder2">IFSC Code</label>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" name="branch" class="input02">
            <label for="" class="placeholder2">Account Branch</label>
        </div>
    </div>
        
        <!-- Submit Button -->
        <div class="trial1">
            <button type="submit" class="epc-button">Generate Salary Slip</button>
        </div>
        </div>
    </form>
</body>
<script>

document.addEventListener('DOMContentLoaded', function() {
    var selectemployeenamedd = document.getElementById('selectemployeenamedd');
    
    // Check if the select element has a value set
    if (selectemployeenamedd.value !== '') {
        fetchTeamMemberDetails(selectemployeenamedd.value);
    } else {
        // If no value, check if there's a default value to select
        var selectedEmployeeName = "<?php echo isset($row['fullname']) ? $row['fullname'] : ''; ?>";
        if (selectedEmployeeName) {
            selectemployeenamedd.value = selectedEmployeeName;
            fetchTeamMemberDetails(selectedEmployeeName);
        }
    }
});

document.addEventListener("DOMContentLoaded", function () {
    // Inputs
    const salaryMonthInput = document.getElementById("salary_month");
    const totalDaysInput = document.getElementById("totaldays");

    // Function to get the number of days in a month
    function getDaysInMonth(year, month) {
        return new Date(year, month, 0).getDate(); // Date(year, month, 0) gives the last day of the previous month, so it returns the number of days in the selected month.
    }

    // Function to update Standard Days based on selected month
    function updateStandardDays() {
        const selectedMonth = salaryMonthInput.value; // e.g., '2024-11'
        
        if (selectedMonth) {
            const [year, month] = selectedMonth.split('-'); // Splitting '2024-11' to get '2024' and '11'
            const daysInMonth = getDaysInMonth(parseInt(year), parseInt(month));
            totalDaysInput.value = daysInMonth; // Setting the total days for that month
        }
    }

    // Event listener for salary month change
    salaryMonthInput.addEventListener("input", updateStandardDays);

    // Initial call to set the correct Standard Days if a month is already selected
    updateStandardDays();
});



document.addEventListener("DOMContentLoaded", function () {
    // Inputs for salary details
    const basicSalaryInput = document.querySelector('input[name="basic_salary"]');
    const otInput = document.querySelector('input[name="ot"]');
    const hraInput = document.querySelector('input[name="hra"]');
    const daInput = document.querySelector('input[name="da"]');
    const taInput = document.querySelector('input[name="ta"]');
    const otherAllowanceInput = document.querySelector('input[name="otherallowance"]');
    const bonusInput = document.querySelector('input[name="bonus"]');
    const professionalTaxInput = document.querySelector('input[name="professional_tax"]');
    const providentFundInput = document.querySelector('input[name="provident_fund"]');
    const esicInput = document.querySelector('input[name="esic"]');
    const loanDeductionInput = document.querySelector('input[name="loan_deduction"]');
    const otherDeductionInput = document.querySelector('input[name="otherdeduction"]');
    const incometaxInput = document.querySelector('input[name="incometax"]');
    
    // Inputs for reimbursement details
    const travelReimbursementInput = document.querySelector('input[name="travel"]');
    const phoneReimbursementInput = document.querySelector('input[name="phone"]');
    const lunchReimbursementInput = document.querySelector('input[name="lunch"]');
    const medicalReimbursementInput = document.querySelector('input[name="medical"]');
    const internetReimbursementInput = document.querySelector('input[name="internet"]');
    const otherReimbursementInput = document.querySelector('input[name="other_reimbusrement"]');
    
    // Inputs for net salary and days worked
    const netSalaryInput = document.querySelector('input[name="net_salary"]');
    const totalDaysInput = document.getElementById("totaldays");
    const workedDaysInput = document.getElementById("daysworked");
    const lopDaysInput = document.getElementById("lossofpaydays");
    const netPayInput = document.getElementById("netpay");

    // Helper function to get numeric input value or default to 0
    function getNumericValue(input) {
        return parseFloat(input.value) || 0; // Return 0 if the value is empty or invalid
    }

    // Function to calculate Net Salary
    function calculateNetSalary() {
        // Get allowances
        const basicSalary = getNumericValue(basicSalaryInput);
        const ot = getNumericValue(otInput);
        const hra = getNumericValue(hraInput);
        const da = getNumericValue(daInput);
        const ta = getNumericValue(taInput);
        const otherAllowance = getNumericValue(otherAllowanceInput);
        const bonus = getNumericValue(bonusInput);

        // Get deductions
        const professionalTax = getNumericValue(professionalTaxInput);
        const providentFund = getNumericValue(providentFundInput);
        const esic = getNumericValue(esicInput);
        const loanDeduction = getNumericValue(loanDeductionInput);
        const otherDeduction = getNumericValue(otherDeductionInput);
        const incomeTax = getNumericValue(incometaxInput);

        // Calculate total allowances and deductions
        const totalAllowances = basicSalary + hra + da + ta + otherAllowance + bonus + ot;
        const totalDeductions = professionalTax + providentFund + esic + loanDeduction + otherDeduction + incomeTax;
        
        // Calculate net salary
        const netSalary = totalAllowances - totalDeductions;
        netSalaryInput.value = netSalary.toFixed(2);

        // Recalculate Net Payable
        calculateNetPay();
    }

    // Function to calculate Net Payable
    function calculateNetPay() {
        const netSalary = getNumericValue(netSalaryInput);
        const totalDays = getNumericValue(totalDaysInput);
        const workedDays = getNumericValue(workedDaysInput);
        const lossOfPayDays = getNumericValue(lopDaysInput);

        // Get reimbursement values
        const travelReimbursement = getNumericValue(travelReimbursementInput);
        const phoneReimbursement = getNumericValue(phoneReimbursementInput);
        const lunchReimbursement = getNumericValue(lunchReimbursementInput);
        const medicalReimbursement = getNumericValue(medicalReimbursementInput);
        const internetReimbursement = getNumericValue(internetReimbursementInput);
        const otherReimbursement = getNumericValue(otherReimbursementInput);

        // Calculate total reimbursements
        const totalReimbursements = travelReimbursement + phoneReimbursement + lunchReimbursement +
                                    medicalReimbursement + internetReimbursement + otherReimbursement;

        // Add reimbursements to net salary
        const totalSalaryWithReimbursement = netSalary + totalReimbursements;

        // Calculate daily wage and net payable
        if (totalDays > 0) {
            const dailyWage = totalSalaryWithReimbursement / totalDays;
            const netPayable = (workedDays - lossOfPayDays) * dailyWage;
            netPayInput.value = netPayable.toFixed(2);
        } else {
            netPayInput.value = "0.00";
        }
    }

    // Event Listeners for Allowances, Deductions, and Reimbursements
    const allowanceInputs = [
        basicSalaryInput, hraInput, daInput, taInput, otherAllowanceInput, bonusInput, otInput,
    ];
    const deductionInputs = [
        professionalTaxInput, providentFundInput, esicInput, loanDeductionInput, otherDeductionInput, incometaxInput,
    ];
    const reimbursementInputs = [
        travelReimbursementInput, phoneReimbursementInput, lunchReimbursementInput,
        medicalReimbursementInput, internetReimbursementInput, otherReimbursementInput,
    ];

    // Recalculate Net Salary and Net Payable on any input change
    allowanceInputs.concat(deductionInputs, reimbursementInputs).forEach((input) => {
        input.addEventListener("input", calculateNetSalary);
    });

    // Event Listeners for Net Payable Calculation
    totalDaysInput.addEventListener("input", calculateNetPay);
    workedDaysInput.addEventListener("input", calculateNetPay);
    lopDaysInput.addEventListener("input", calculateNetPay);

    // Trigger calculation when employee data is populated (manually or via JavaScript)
    function triggerCalculationAfterPopulatingData() {
        calculateNetSalary(); // Call the net salary calculation immediately
        calculateNetPay();    // Call the net payable calculation
    }

    // Make sure to trigger the calculation after the form is auto-populated with employee data
    triggerCalculationAfterPopulatingData();

    // Watch for when form data is auto-populated via JavaScript
    const autoPopulateObserver = new MutationObserver(() => {
        triggerCalculationAfterPopulatingData(); // Recalculate when fields are auto-populated
    });

    // Observe changes to the input fields that are auto-populated
    const observedFields = [
        basicSalaryInput, hraInput, daInput, taInput, otherAllowanceInput, bonusInput,
        professionalTaxInput, providentFundInput, esicInput, loanDeductionInput, otherDeductionInput
    ];

    observedFields.forEach(field => {
        autoPopulateObserver.observe(field, {
            attributes: true,
            childList: true,
            subtree: true
        });
    });
});

function fetchTeamMemberDetails(name) {
    fetch(`fetchsalaryslipdata.php?name=${name}`)
        .then(response => response.json())  // Parse the JSON response
        .then(data => {  // Handle the parsed data
            document.getElementById('basicslry').value = data?.basicsalary || ''; 
            document.getElementsByName('hra')[0].value = data?.hr || '';
            document.getElementsByName('da')[0].value = data?.da || '';
            document.getElementsByName('ta')[0].value = data?.ta || '';
            document.getElementsByName('jobrole')[0].value = data?.jobrole || '';
            document.getElementsByName('department')[0].value = data?.department || '';
            document.getElementsByName('employee_id')[0].value = data?.employeeid || '';
            document.getElementsByName('professional_tax')[0].value = data?.professionaltaxdeduction || '';
            document.getElementsByName('provident_fund')[0].value = data?.deductionamt || '';
            document.getElementsByName('esic')[0].value = data?.esisdeductionamt || '';
            document.getElementsByName('otherdeduction')[0].value = data?.otherdedeuction || '';
            document.getElementsByName('bankname')[0].value = data?.bankname || '';
            document.getElementsByName('accountholdername')[0].value = data?.accountholdername || '';
            document.getElementsByName('accountnumber')[0].value = data?.accountnumber || '';
            document.getElementsByName('ifsc')[0].value = data?.ifsc || '';
            document.getElementsByName('branch')[0].value = data?.branch || '';
        })
        .catch(() => {  // Handle errors
            document.getElementById('basicslry').value = '';
            document.getElementsByName('hra')[0].value = '';            // document.getElementById('email').value = '';
            document.getElementsByName('da')[0].value = '';            // document.getElementById('email').value = '';
            document.getElementsByName('ta')[0].value = '';            // document.getElementById('email').value = '';
            document.getElementsByName('jobrole')[0].value = '';            // document.getElementById('email').value = '';
            document.getElementsByName('department')[0].value = '';            // document.getElementById('email').value = '';
            document.getElementsByName('employee_id')[0].value = '';            // document.getElementById('email').value = '';
            document.getElementsByName('professional_tax')[0].value = '';            // document.getElementById('email').value = '';
            document.getElementsByName('provident_fund')[0].value = '';            // document.getElementById('email').value = '';
            document.getElementsByName('esic')[0].value = '';            // document.getElementById('email').value = '';
            document.getElementsByName('otherdeduction')[0].value = '';            // document.getElementById('email').value = '';
            document.getElementsByName('bankname')[0].value = '';            // document.getElementById('email').value = '';
            document.getElementsByName('accountholdername')[0].value = '';            // document.getElementById('email').value = '';
            document.getElementsByName('accountnumber')[0].value = '';            // document.getElementById('email').value = '';
            document.getElementsByName('ifsc')[0].value = '';            // document.getElementById('email').value = '';
            document.getElementsByName('branch')[0].value = '';            // document.getElementById('email').value = '';
        });
}

</script>
</html>
