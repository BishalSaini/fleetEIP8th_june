<?php
include "partials/_dbconnect.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$companyname001 = $_SESSION['companyname'];
$enterprise = $_SESSION['enterprise'];
$email = $_SESSION['email'];

$assetcode = $_GET['assetcode'];
$worefno = $_GET['worefno'];
$clientnameget = $_GET['clientname'];
$month = $_GET['month'];
$sitelocation = $_GET['sitelocation'];

$sql_logo_fetch = "SELECT * FROM `basic_details` where companyname='$companyname001'";
$result_fetch_logo = mysqli_query($conn, $sql_logo_fetch);
$row_logo_fetch = mysqli_fetch_assoc($result_fetch_logo);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
    <title>View Log Sheet</title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
    <style>
        body {
            background: #f6f8fa;
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .fulllength {
            display: flex;
            justify-content: center;
            gap: 18px;
            padding: 18px 0 0 0;
            background: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }
        .downloadbuttonsummary, .gobackbuttonsummary {
            padding: 0.6rem 1.4rem;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            background: #007bff;
            color: #fff;
            transition: background 0.2s;
        }
        .downloadbuttonsummary:hover, .gobackbuttonsummary:hover {
            background: #0056b3;
        }
        .gobackbuttonsummary {
            background: #e0e0e0;
            color: #333;
        }
        .gobackbuttonsummary:hover {
            background: #bdbdbd;
        }
        .logsheetcontainerprint {
            background: #fff;
            margin: 32px auto;
            max-width: 1100px;
            border-radius: 14px;
            box-shadow: 0 4px 32px rgba(0,0,0,0.09);
            padding: 32px 28px 32px 28px;
        }
        .logtablecontainer {
            display: flex;
            gap: 32px;
            margin-bottom: 32px;
            flex-wrap: wrap;
        }
        /* Professional info card styling for top info */
        .logsheet-info-card {
            background: linear-gradient(90deg, #f7faff 60%, #eaf2fb 100%);
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.04);
            padding: 22px 28px 18px 28px;
            margin-bottom: 18px;
            display: flex;
            flex-direction: row;
            gap: 32px;
            align-items: flex-start;
        }
        .logsheet-info-section {
            min-width: 320px;
            flex: 1;
        }
        .logsheet-info-section table {
            width: 100%;
            border-collapse: collapse;
            background: none;
        }
        .logsheet-info-section th, .logsheet-info-section td {
            padding: 7px 0;
            font-size: 1.05rem;
            border: none;
            background: none;
            color: #222;
        }
        .logsheet-info-section th {
            font-weight: 600;
            color: #007bff;
            text-align: left;
            width: 170px;
        }
        .logsheet-info-section td {
            font-weight: 400;
            color: #222;
            text-align: left;
        }
        .logsheet-info-section tr:not(:last-child) td, .logsheet-info-section tr:not(:last-child) th {
            border-bottom: 1px solid #f0f4fa;
        }
        .logsheetdatatable, .logsheetdatatable th, .logsheetdatatable td {
            background: none;
            border: none;
            box-shadow: none;
            border-radius: 0;
            padding: 0;
        }
        .logsheet_table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 8px rgba(0, 0, 0, 0.04);
        }

        .logsheet_table th,
        .logsheet_table td {
            padding: 8px 12px;
            border-bottom: 1px solid #eaeaea;
            font-size: 0.97rem;
            text-align: center;
        }

        .logsheet_table th {
            background: #f1f5fb;
            font-weight: 600;
            color: #222;
        }

        .logsheet_table tr:last-child td {
            border-bottom: none;
        }

        .logsheet_table tfoot td {
            background: #f9fafb;
            font-weight: 700;
            font-size: 1.05rem;
            color: #007bff;
        }

        .logsheet_table .user-row td {
            background: #f7faff;
        }

        .logsheet_table input[type="text"],
        .logsheet_table input[type="number"] {
            width: 90%;
            padding: 6px 10px;
            border: 1px solid #d1d5db;
            border-radius: 5px;
            font-size: 0.97rem;
            background: #fafbfc;
        }

        .logsheet_table input[type="text"]:focus,
        .logsheet_table input[type="number"]:focus {
            border-color: #007bff;
            outline: none;
        }

        .bothtable {
            display: flex;
            gap: 32px;
            flex-wrap: wrap;
            margin-bottom: 24px;
        }

        #extratable {
            background: #f9fafb;
            border-radius: 8px;
            box-shadow: 0 1px 6px rgba(0, 0, 0, 0.04);
            min-width: 320px;
            margin-bottom: 0;
        }

        #extratable th,
        #extratable td {
            padding: 8px 12px;
            font-size: 0.97rem;
            border-bottom: 1px solid #eaeaea;
            text-align: center;
        }

        #extratable th {
            background: #f1f5fb;
            font-weight: 600;
            color: #222;
        }

        #extratable tr:last-child td {
            border-bottom: none;
        }

        .contactheading {
            font-size: 1.1rem;
            font-weight: 600;
            color: #007bff;
            margin: 18px 0 8px 0;
        }

        @media (max-width: 900px) {
            .logsheetcontainerprint {
                padding: 18px 6px 18px 6px;
                max-width: 99vw;
            }
            .logtablecontainer, .bothtable, .logsheet-info-card {
                flex-direction: column;
                gap: 18px;
            }
        }
        @media (max-width: 600px) {
            .logsheet-info-card {
                padding: 12px 4px 12px 4px;
            }
            .logsheet-info-section th, .logsheet-info-section td {
                font-size: 0.95rem;
                padding: 5px 0;
            }
        }
    </style>
</head>

<body>
    <div class="fulllength">
        <button onclick="downloadsummary()" class="downloadbuttonsummary">Download</button>
        <button
            onclick="window.location.href='logsheetsummary.php?assetcode=<?php echo $assetcode; ?>&worefno=<?php echo $worefno ?>&clientname=<?php echo $clientnameget ?>&month=<?php echo $month ?>&sitelocation=<?php echo $sitelocation ?>'"
            class="gobackbuttonsummary"> <i class="bi bi-arrow-left"></i> Go Back
        </button>
    </div>
    <?php
    $sql = "SELECT * FROM logsheetnew WHERE assetcode='$assetcode' AND worefno='$worefno' AND clientname='$clientnameget' AND month_year='$month' AND sitelocation='$sitelocation' AND companyname='$companyname001' and logtype='shift'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $firstRow = mysqli_fetch_assoc($result);
        ?>
        <div class="logsheetcontainerprint" id="logsheetpdf">
            <!-- Improved info card at top -->
            <div class="logsheet-info-card">
                <div class="logsheet-info-section">
                    <table>
                        <tr>
                            <th>Client Name :</th>
                            <td><?php echo $firstRow['clientname']; ?></td>
                        </tr>
                        <tr>
                            <th>Site Location:</th>
                            <td><?php echo $firstRow['sitelocation']; ?></td>
                        </tr>
                        <tr>
                            <th>WO Ref No:</th>
                            <td><?php echo $firstRow['worefno']; ?></td>
                        </tr>
                        <tr>
                            <th>Log Sheet Month:</th>
                            <td><?php echo $firstRow['month_year']; ?></td>
                        </tr>
                    </table>
                </div>
                <div class="logsheet-info-section">
                    <table>
                        <tr>
                            <th>Equipment:</th>
                            <td><?php echo $firstRow['equipmenttype'] . ' - ' . $firstRow['make'] . ' - ' . $firstRow['model']; ?></td>
                        </tr>
                        <tr>
                            <th>Monthly Rental:</th>
                            <td><?php echo $firstRow['rentalcharges']; ?></td>
                        </tr>
                        <tr>
                            <th>Working Days:</th>
                            <td><?php echo $firstRow['workingdays']; ?> &nbsp;&nbsp; <strong>Working Hours:</strong> <?php echo $firstRow['shift_hour'] ?></td>
                        </tr>
                        <tr>
                            <th>Condition :</th>
                            <td><?php echo $firstRow['conditions']; ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <!-- ...existing code for logsheet_table_container, tables, etc... -->
            <?php
            // Database query to fetch the data
            $sql = "SELECT * FROM logsheetnew WHERE assetcode='$assetcode' AND worefno='$worefno' AND clientname='$clientnameget' AND month_year='$month' AND sitelocation='$sitelocation' AND companyname='$companyname001' and logtype='shift'";
            $result = mysqli_query($conn, $sql);

            $firstRow = mysqli_fetch_array($result); // Fetch the first row to check the shift type
            $shiftType = $firstRow['shift'] ?? 'Single'; // Default to 'Single' if not set
            mysqli_data_seek($result, 0); // Reset result pointer to loop through all rows
            ?>
            <div class="logsheet_table_container">
                <table class="logsheet_table">
                    <thead>
                        <tr>
                            <th rowspan="2">Sr</th>
                            <th rowspan="2">Day</th>
                            <th rowspan="2">Date</th>

                            <!-- Day Shift Run Grouped Columns -->
                            <th colspan="2">Day Shift</th>
                            <th colspan="2">Day Shift KMR</th>
                            <th colspan="2">Day Shift HMR</th>

                            <!-- Night Shift Run Grouped Columns -->
                            <?php if ($shiftType === 'Double'): ?>
                                <th colspan="2">Night Shift Run</th>
                                <th colspan="2">Night Shift KMR</th>
                                <th colspan="2">Night Shift HMR</th>
                            <?php endif; ?>

                            <th rowspan="2">Total Hours</th>
                            <th rowspan="2">Fuel Taken</th>
                        </tr>
                        <tr>
                            <!-- Subcolumns for Day Shift Run -->
                            <th>Start Time</th>
                            <th>End Time</th>

                            <!-- Subcolumns for Day Shift KMR -->
                            <th>Start KMR</th>
                            <th>Close KMR</th>

                            <!-- Subcolumns for Day Shift HMR -->
                            <th>Start HMR</th>
                            <th>Close HMR</th>

                            <!-- Subcolumns for Night Shift -->
                            <?php if ($shiftType === 'Double'): ?>
                                <th>Start Time</th>
                                <th>End Time</th>

                                <th>Start KMR</th>
                                <th>Close KMR</th>

                                <th>Start HMR</th>
                                <th>Close HMR</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Print all logsheet rows for the month (up to 30/31 days)
                        $totalHours = 0;
                        $totalFuel = 0;
                        $sr_no = 1;
                        while ($row = mysqli_fetch_array($result)) {
                            // Calculate total hours for day shift (based on start and close HMR)
                            $dayStartHMR = $row['start_hmr'];
                            $dayCloseHMR = $row['closed_hmr'];
                            $dayShiftHours = ($dayCloseHMR - $dayStartHMR); // Calculate hours for day shift
                    
                            // Calculate total hours for night shift (based on start and close HMR)
                            $nightStartHMR = $row['night_start_hmr'];
                            $nightCloseHMR = $row['night_closed_hmr'];
                            $nightShiftHours = ($nightCloseHMR - $nightStartHMR); // Calculate hours for night shift
                    
                            // Sum the total hours for this row
                            $totalShiftHours = $dayShiftHours + ($shiftType === 'Double' ? $nightShiftHours : 0);
                            $totalHours += $totalShiftHours;

                            // Add the fuel taken for this row to the total fuel
                            $totalFuel += $row['fuel_taken'];
                            ?>
                            <tr>
                                <td><?php echo $sr_no++; ?></td>
                                <td><?php echo date('D', strtotime($row['date'])); ?></td>
                                <td><?php echo date('d-M-y', strtotime($row['date'])); ?></td>

                                <!-- Day Shift Run -->
                                <td><?php echo $row['start_time']; ?></td>
                                <td><?php echo $row['close_time']; ?></td>

                                <!-- Day Shift KMR -->
                                <td><?php echo $row['start_km']; ?></td>
                                <td><?php echo $row['closed_km']; ?></td>

                                <!-- Day Shift HMR -->
                                <td><?php echo $row['start_hmr']; ?></td>
                                <td><?php echo $row['closed_hmr']; ?></td>

                                <!-- Night Shift Columns -->
                                <?php if ($shiftType === 'Double'): ?>
                                    <td><?php echo $row['night_start_time']; ?></td>
                                    <td><?php echo $row['night_close_time']; ?></td>

                                    <td><?php echo $row['night_start_km']; ?></td>
                                    <td><?php echo $row['night_closed_km']; ?></td>

                                    <td><?php echo $row['night_start_hmr']; ?></td>
                                    <td><?php echo $row['night_closed_hmr']; ?></td>
                                <?php endif; ?>

                                <!-- Display total shift hours for this row -->
                                <td><?php echo number_format($totalShiftHours, 2); ?> hours</td>
                                <td><?php echo $row['fuel_taken']; ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                        <!-- Display the sum of all hours and fuel at the end -->
                        <tr>
                            <td colspan="4" style="text-align: right;"><strong>Total Hours Worked in Month:</strong></td>
                            <td colspan="15" style="text-align: left;"><strong><?php echo number_format($totalHours, 2); ?>
                                    hours</strong></td>
                        </tr>
                        <tr>
                            <td colspan="4" style="text-align: right;"><strong>Total Fuel Taken in Month:</strong></td>
                            <td colspan="15" style="text-align: left;"><strong><?php echo number_format($totalFuel, 2); ?>
                                    liters</strong></td>
                        </tr>
                        <?php
                        ?>
                    </tbody>
                </table>
                <!-- </div> -->
                <?php
                $sqlbreakdown = "SELECT * FROM logsheetnew WHERE assetcode='$assetcode' AND worefno='$worefno' AND clientname='$clientnameget' AND month_year='$month' AND sitelocation='$sitelocation' AND companyname='$companyname001' AND logtype='breakdown'";
                $resultbreakdown = mysqli_query($conn, $sqlbreakdown);
                ?>

                <div class="bothtable">
                    <table class="logsheet_table" id="extratable">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Day</th>
                                <th>Breakdown Hours</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $totalBreakdownHours = 0;  // Initialize variable to accumulate breakdown hours
                        
                            if (mysqli_num_rows($resultbreakdown) > 0) {
                                while ($row = mysqli_fetch_array($resultbreakdown)) {
                                    // Sum up the breakdown hours
                                    $totalBreakdownHours += $row['breakdown_hours'];
                                    ?>
                                    <tr>
                                        <td><?php echo date('d-M-y', strtotime($row['date'])); ?></td> <!-- Date -->
                                        <td><?php echo date('D', strtotime($row['date'])); ?></td> <!-- Day of the week -->
                                        <td><?php echo $row['breakdown_hours']; ?> hours</td> <!-- Breakdown hours -->
                                    </tr>
                                    <?php
                                }
                                ?>
                                <tr>
                                    <td colspan="3" style="text-align: right;"><strong> Total Breakdown Hours:
                                            <?php echo number_format($totalBreakdownHours, 2); ?> hours</strong></td>
                                </tr>
                                <?php
                            } else {
                                echo "<tr><td colspan='3'>No breakdown records found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>


                    <?php
                    $sqlot = "SELECT * FROM logsheetnew WHERE assetcode='$assetcode' AND worefno='$worefno' AND clientname='$clientnameget' AND month_year='$month' AND sitelocation='$sitelocation' AND companyname='$companyname001' AND logtype='ot'";
                    $resultot = mysqli_query($conn, $sqlot);
                    ?>

                    <table class="logsheet_table" id="extratable">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Day</th>
                                <th>Pro Rata</th>

                                <th>OT Hours</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $totalothours = 0;  // Initialize variable to accumulate breakdown hours
                        
                            if (mysqli_num_rows($resultot) > 0) {
                                while ($row = mysqli_fetch_array($resultot)) {
                                    // Sum up the breakdown hours
                                    $totalothours += $row['othours'];
                                    ?>
                                    <tr>
                                        <td><?php echo date('d-M-y', strtotime($row['date'])); ?></td> <!-- Date -->
                                        <td><?php echo date('D', strtotime($row['date'])); ?></td> <!-- Day of the week -->
                                        <td><?php echo $row['otprorata']; ?> %</td> <!-- Breakdown hours -->

                                        <td><?php echo $row['othours']; ?> hours</td> <!-- Breakdown hours -->
                                    </tr>
                                    <?php
                                }
                                ?>
                                <tr>
                                    <td colspan="4" style="text-align: right;"><strong> Total Over Time Hours:
                                            <?php echo number_format($totalothours, 2); ?> hours</strong></td>
                                </tr>
                                <?php
                            } else {
                                echo "<tr><td colspan='3'>No breakdown records found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <?php
                // Step 1: Calculate Per Day Pay
                $totalDaysInMonth = date('t', strtotime($month . '-01')); // Total days in the month
                $perDayPay = $firstRow['rentalcharges'] / $firstRow['workingdays'];

                // Step 2: Calculate Normal Shift Pay
                $normalShiftPay = $perDayPay * ($sr_no - 1); // Sr number counts total normal shifts
            
                // Step 3: Calculate OT Pay
                $otPay = 0;
                if (mysqli_num_rows($resultot) > 0 && $firstRow['shift'] === 'Single') {
                    mysqli_data_seek($resultot, 0); // Reset result pointer for OT query
                    while ($row = mysqli_fetch_array($resultot)) {
                        $otRate = (($perDayPay / $firstRow['shift_hour']) * $row['otprorata']) / 100; // OT rate per hour (prorata percentage of daily pay)
                        $otPay += $otRate * $row['othours']; // OT pay for this entry
                    }
                } else if (mysqli_num_rows($resultot) > 0 && $firstRow['shift'] === 'Double') {
                    mysqli_data_seek($resultot, 0); // Reset result pointer for OT query
                    while ($row = mysqli_fetch_array($resultot)) {
                        $otRate = (($firstRow['rentalcharges'] / $firstRow['shift_hour']) * $row['otprorata']) / 100; // OT rate per hour (prorata percentage of daily pay)
                        $otPay += $otRate * $row['othours']; // OT pay for this entry
                    }


                }
                // Step 4: Calculate Breakdown Deduction
                $breakdownDeduction = 0;
                if (mysqli_num_rows($resultbreakdown) > 0 && $firstRow['shift'] === 'Single') {

                    $breakdownDeduction = ($perDayPay / $firstRow['shift_hour']) * $totalBreakdownHours;
                } else if (mysqli_num_rows($resultbreakdown) > 0 && $firstRow['shift'] === 'Double') {
                    $breakdownDeduction = (($firstRow['rentalcharges'] / $firstRow['shift_hour'])) * $totalBreakdownHours;

                }

                // Step 5: Calculate Final Pay
                $finalPay = $normalShiftPay + $otPay - $breakdownDeduction;
                ?>

                <!-- Display Pay Summary -->
                <table class="logsheet_table" id="paytable">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody id="paytable-body">
                        <tr>
                            <td>Per Day Pay</td>
                            <td><?php echo number_format($perDayPay, 2); ?></td>
                        </tr>
                        <tr>
                            <td>Normal Shift Pay</td>
                            <td><?php echo number_format($normalShiftPay, 2); ?></td>
                        </tr>
                        <tr>
                            <td>Overtime Pay</td>
                            <td><?php echo number_format($otPay, 2); ?></td>
                        </tr>
                        <tr>
                            <td>Breakdown Deduction</td>
                            <td><?php echo '-' . number_format($breakdownDeduction, 2); ?></td>
                        </tr>
                        <!-- Additional rows for user-specific expenses -->
                        <tr class="user-row">
                            <td><input type="text" name="custom_category_1" placeholder="Expense/Deduction Category"
                                    class="input02"></td>
                            <td><input type="number" name="custom_amount_1" placeholder="Amount"
                                    class="input02 custom-amount" oninput="updateFinalPay()"></td>
                        </tr>
                        <tr class="user-row">
                            <td><input type="text" name="custom_category_2" placeholder="Expense/Deduction Category"
                                    class="input02"></td>
                            <td><input type="number" name="custom_amount_2" placeholder="Amount"
                                    class="input02 custom-amount" oninput="updateFinalPay()"></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td><strong>Final Pay</strong></td>
                            <td><strong id="final-pay-display"><?php echo number_format($finalPay, 2); ?></strong></td>
                        </tr>
                    </tfoot>
                </table>
                <!-- <button type="button" onclick="addCustomRow()">Add Row</button> -->




            </div>
        </div>
        <?php
    }

    ?>
</body>
<script>
    function downloadsummary() {
        // Download the entire logsheetcontainerprint as PDF, even for 30+ entries
        const element = document.getElementById('logsheetpdf');
        const filename = "<?php echo $firstRow['month_year']; ?>-<?php echo $firstRow['assetcode']; ?>-<?php echo $firstRow['sitelocation']; ?>.pdf";

        html2pdf().set({
            margin: [10, 10, 10, 10], // Use mm for margins for A4
            filename: filename,
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: {
                dpi: 300,
                letterRendering: true,
                scale: 1, // Use scale 1 for best fit
                useCORS: true,
                scrollY: 0,
                windowWidth: element.scrollWidth,
                windowHeight: element.scrollHeight
            },
            jsPDF: {
                unit: 'mm',
                format: 'a4',
                orientation: 'portrait'
            },
            pagebreak: { mode: ['css', 'legacy'], before: '.logsheet-info-card, .logsheet_table, .bothtable', after: '.logsheet_table' }
        }).from(element).save();
    }

    let baseFinalPay = <?php echo isset($finalPay) ? $finalPay : 0; ?>;

    // Function to dynamically add custom rows
    // function addCustomRow() {
    //     const tableBody = document.getElementById('paytable-body');
    //     const newRow = document.createElement('tr');
    //     newRow.classList.add('user-row');

    //     newRow.innerHTML = `
    //     <td><input type="text" name="custom_category[]" placeholder="Expense/Deduction Category" class="custom-input"></td>
    //     <td><input type="number" name="custom_amount[]" placeholder="Amount" class="custom-amount" oninput="updateFinalPay()"></td>
    // `;

    //     tableBody.appendChild(newRow);
    // }

    // Function to calculate and update Final Pay
    function updateFinalPay() {
        const customAmounts = document.querySelectorAll('.custom-amount');
        let userAdjustments = 0;

        // Sum all user-provided amounts
        customAmounts.forEach(input => {
            const value = parseFloat(input.value) || 0; // Default to 0 if input is empty
            userAdjustments += value;
        });

        // Calculate new final pay
        const newFinalPay = baseFinalPay + userAdjustments;

        // Update the Final Pay display
        document.getElementById('final-pay-display').textContent = newFinalPay.toFixed(2);
    }</script>

</html>