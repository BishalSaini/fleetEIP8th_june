<?php 
session_start();
$showAlert=false;
$showError=false;

$email1=$_SESSION['email'];
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
if(isset($_SESSION['success'])){
    $showAlert=true;
    unset($_SESSION['success']);
}
else if(isset($_SESSION['error'])){
    $showError=true;
    unset($_SESSION['error']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMI Calculator</title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
    <style>
body {
    font-family: Arial, sans-serif;
    background-color: #f4f7f9; /* Light background for contrast */
    margin: 0;
    padding: 0;
}

.container-emi {
    margin: 40px auto!important; 
    
    max-width: 400px;
    margin: auto;
    background: white;
    padding: 20px ;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h2 {
    text-align: center;
    color: #333;
    margin-bottom: 20px; /* Space below the heading */
}

.input-group {
    margin-bottom: 15px; /* Increased margin for input groups */
    padding-right:20px;
}

label {
    font-weight: bold;
    color: #555; /* Darker color for labels */
}

input[type="number"] {
    width: 100%;
    padding: 10px; /* Increased padding */
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 4px;
    transition: border-color 0.3s; /* Smooth transition for focus */
}

input[type="number"]:focus {
    border-color: #007bff; /* Change border color on focus */
    outline: none; /* Remove default outline */
}

button {
    width: 100%!important;
    padding: 12px; /* Increased padding */
    background-color: #253C6A;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s; /* Smooth transition */
}

button:hover {
    background-color: #253C4A;
}

.result {
    margin-top: 20px;
    font-size: 18px;
    text-align: center;
    color: #333; /* Dark text color for better readability */
}

    </style>
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
            <li><a href="logout.php">Log Out</a></li></ul>
        </div>
    </div>

    <div class="container-emi">
        <h2>EMI Calculator</h2>
        <div class="input-group">
            <label for="principal">Loan Amount (₹):</label>
            <input type="number" id="principal" required>
        </div>
        <div class="input-group">
            <label for="interestRate">Annual Interest Rate (%):</label>
            <input type="number" id="interestRate" step="0.01" required>
        </div>
        <div class="input-group">
            <label for="tenure">Loan Tenure (years):</label>
            <input type="number" id="tenure" required>
        </div>
        <button onclick="calculateEMI()">Calculate EMI</button>

        <div id="result" class="result"></div>
    </div>

    <script>
function calculateEMI() {
    // Get input values
    var principal = parseFloat(document.getElementById('principal').value);
    var annualInterestRate = parseFloat(document.getElementById('interestRate').value);
    var tenureYears = parseFloat(document.getElementById('tenure').value);

    // Validate input
    if (isNaN(principal) || isNaN(annualInterestRate) || isNaN(tenureYears)) {
        alert('Please enter valid numbers');
        return;
    }

    // Calculate monthly interest rate and tenure in months
    var monthlyInterestRate = annualInterestRate / 12 / 100;
    var tenureMonths = tenureYears * 12;

    // Calculate EMI
    var emi = (principal * monthlyInterestRate * Math.pow(1 + monthlyInterestRate, tenureMonths)) /
              (Math.pow(1 + monthlyInterestRate, tenureMonths) - 1);

    // Calculate total payment, total interest, and total amount paid
    var totalPayment = emi * tenureMonths;
    var totalInterest = totalPayment - principal;
    var totalAmountPaid = totalPayment;

    // Display result
    var resultElement = document.getElementById('result');
    resultElement.innerHTML = `
        <p>EMI: ₹ ${emi.toFixed(2)} per month</p>
        <p>Total interest paid: ₹ ${totalInterest.toFixed(2)}</p>
        <p>Total amount paid after ${tenureYears} years: ₹ ${totalAmountPaid.toFixed(2)}</p>
    `;
}

    </script>
</body>
</html>
