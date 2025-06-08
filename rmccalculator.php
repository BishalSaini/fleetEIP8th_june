<?php
session_start();
include "partials/_dbconnect.php";
$companyname001=$_SESSION['companyname'];
$enterprise=$_SESSION['enterprise'];
$dashboard_url = '';
if ($enterprise === 'rental') {
    $dashboard_url = 'rental_dashboard.php';
} elseif ($enterprise === 'logistics') {
    $dashboard_url = 'logisticsdashboard.php';
} elseif ($enterprise === 'epc') {
    $dashboard_url = 'epc_dashboard.php';
} else {
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
    <title>RMC Calculator</title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
    <style>
        .calculator {
            margin: 20px auto; 
            max-width: 400px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1, h3 {
            text-align: left;
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input, select {
            width: 95%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #253C6A;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #253C4A;
        }

        .active {
            background-color: #1B2A4D; /* Darker color for the active button */
        }
        .result {
            margin-top: 20px;
            font-size: 18px;
            text-align: center;
        }
        #unit{
            width: 100%;
        }
    </style>
</head>
<body>
<div class="navbar1">
    <div class="logo_fleet">
        <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='<?php echo $dashboard_url ?>'">
    </div>
    <div class="iconcontainer">
        <ul>
            <li><a href="<?php echo $dashboard_url ?>">Dashboard</a></li>
            <li><a href="news/">News</a></li>
            <li><a href="logout.php">Log Out</a></li>
        </ul>
    </div>
</div>
<br>
<div class="fulllength" id="rmccalculatorbutton">
    <button class="tripupdate_generatecn rmccalbtn" onclick="toggleCalculator('slab')">Slab Volume Calculator</button>
    <button class="tripupdate_generatecn rmccalbtn" onclick="toggleCalculator('beam')">Beam Volume Calculator</button>
</div>

<div class="calculator" id="slabCalculator">
    <h3>RMC Slab Volume Calculator</h3>
    <form id="volumeCalculator">
        <label for="length">Length:</label>
        <input type="number" id="length" required>

        <label for="width">Width:</label>
        <input type="number" id="width" required>

        <label for="height">Height:</label>
        <input type="number" id="height" required>

        <label for="unit">Unit:</label>
        <select id="unit" required>
            <option value="meters">Meters</option>
            <option value="feet">Feet</option>
            <option value="inches">Inches</option>
        </select>

        <button type="button" onclick="calculateVolume('slab')">Calculate Volume</button>
    </form>
    <div id="resultSlab" class="result"></div>
</div>

<div class="calculator" id="beamCalculator" style="display:none;">
    <h3>RMC Beam Volume Calculator</h3>
    <form id="beamVolumeCalculator">
        <label for="beamLength">Length:</label>
        <input type="number" id="beamLength" required>

        <label for="beamWidth">Width:</label>
        <input type="number" id="beamWidth" required>

        <label for="thickness">Thickness:</label>
        <input type="number" id="thickness" required>

        <label for="beamUnit">Unit:</label>
        <select id="beamUnit" required>
            <option value="meters">Meters</option>
            <option value="feet">Feet</option>
            <option value="inches">Inches</option>
        </select>

        <button type="button" onclick="calculateVolume('beam')">Calculate Volume</button>
    </form>
    <div id="resultBeam" class="result"></div>
</div>

<script>
function toggleCalculator(type) {
    if (type === 'slab') {
        document.getElementById('slabCalculator').style.display = 'block';
        document.getElementById('beamCalculator').style.display = 'none';
    } else {
        document.getElementById('slabCalculator').style.display = 'none';
        document.getElementById('beamCalculator').style.display = 'block';
    }
}

function calculateVolume(type) {
    let length, width, height, volume, unitText;

    if (type === 'slab') {
        length = parseFloat(document.getElementById('length').value);
        width = parseFloat(document.getElementById('width').value);
        height = parseFloat(document.getElementById('height').value);
        const unit = document.getElementById('unit').value;

        if (!length || !width || !height) {
            alert("Please enter valid dimensions.");
            return;
        }

        volume = length * width * height;
        unitText = (unit === 'meters') ? 'cubic meters' : (unit === 'feet') ? 'cubic feet' : 'cubic feet';
        
        if (unit === 'inches') {
            volume /= 1728; // Convert cubic inches to cubic feet
        }

        document.getElementById('resultSlab').innerText = `Volume: ${volume.toFixed(2)} ${unitText}`;
    } else {
        length = parseFloat(document.getElementById('beamLength').value);
        width = parseFloat(document.getElementById('beamWidth').value);
        height = parseFloat(document.getElementById('thickness').value);
        const unit = document.getElementById('beamUnit').value;

        if (!length || !width || !height) {
            alert("Please enter valid dimensions.");
            return;
        }

        volume = length * width * height;
        unitText = (unit === 'meters') ? 'cubic meters' : (unit === 'feet') ? 'cubic feet' : 'cubic feet';

        if (unit === 'inches') {
            volume /= 1728; // Convert cubic inches to cubic feet
        }

        document.getElementById('resultBeam').innerText = `Volume: ${volume.toFixed(2)} ${unitText}`;
    }
}
</script>
</body>
</html>
