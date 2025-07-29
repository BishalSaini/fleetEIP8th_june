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
        /* Hide buttons when printing or exporting to PDF */
        @media print {
            .fulllength {
                display: none !important;
            }
        }

        /* Ensure tables fit page and avoid cropping */
        .logsheetcontainerprint {
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            box-sizing: border-box;
        }

        .logsheet_table,
        .logsheetdatatable {
            width: 100% !important;
            table-layout: auto;
            word-break: break-word;
        }

        .logsheet_table th,
        .logsheet_table td,
        .logsheetdatatable th,
        .logsheetdatatable td {
            font-size: 13px;
            padding: 4px 6px;
        }

        /* Optional: reduce font for PDF to fit more content */
        @media print {
            body,
            table,
            th,
            td {
                font-size: 11px !important;
            } 
            
        }
    </style>
</head>

<body>
    <div class="fulllength" id="action-buttons">
        <button onclick="downloadsummary()" class="downloadbuttonsummary">Download</button>
        <button
            onclick="window.location.href='logsheetsummary.php?assetcode=<?php echo $assetcode; ?>&worefno=<?php echo $worefno ?>&clientname=<?php echo $clientnameget ?>&month=<?php echo $month ?>&sitelocation=<?php echo $sitelocation ?>'"
            class="gobackbuttonsummary"> <i class="bi bi-arrow-left"></i> Go Back
        </button>
    </div>
    <?php
    // Fetch all logtypes for the given asset/project/month
    $sql = "SELECT * FROM logsheetnew WHERE assetcode='$assetcode' AND worefno='$worefno' AND clientname='$clientnameget' AND month_year='$month' AND sitelocation='$sitelocation' AND companyname='$companyname001'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Use the first row for header info, but do NOT re-query for only 'shift'
        $firstRow = mysqli_fetch_assoc($result);
        ?>
        <div class="logsheetcontainerprint">
            <!-- Company Header (for PDF export) -->
            <div class="pdf-header" style="display: flex; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #ccc; padding-bottom: 10px;">
                <img src="img/<?php echo htmlspecialchars($row_logo_fetch['companylogo']); ?>" alt="Company Logo" style="height: 60px; margin-right: 20px;">
                <div>
                    <div style="font-size: 20px; font-weight: bold;"><?php echo htmlspecialchars($row_logo_fetch['companyname']); ?></div>
                    <div style="font-size: 14px;">
                        <?php echo isset($row_logo_fetch['companyaddress']) ? nl2br(htmlspecialchars($row_logo_fetch['companyaddress'])) : ''; ?>
                    </div>
                </div>
            </div>
            <!-- End Company Header -->
            <div class="logtablecontainer">
                <table class="logsheetdatatable">
                    <tr>
                        <th>Client Name :</th>
                        <td><?php echo $firstRow['clientname']; ?></td>
                    </tr>
                    <!-- <tr>
                        <th>Equipment:</th>
                        <td><?php echo $firstRow['equipmenttype'] . ' - ' . $firstRow['make'] . ' - ' . $firstRow['model']; ?></td>
                    </tr> -->
                    <tr>
                        <th>Site Location:</th>
                        <td><?php echo $firstRow['sitelocation']; ?></td>
                    </tr>
                    <tr>
                        <th>WO Ref No:</th>
                        <td><?php echo $firstRow['worefno']; ?></td>
                    </tr>
                    <tr>
                        <th>Log Sheet For The Month Of :</th>
                        <td><?php echo $firstRow['month_year']; ?></td>
                    </tr>
                </table>
                <table class="logsheetdatatable">
                    <tr>
                        <th>Equipment:</th>
                        <td><?php echo $firstRow['equipmenttype'] . ' - ' . $firstRow['make'] . ' - ' . $firstRow['model']; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Monthly Rental:</th>
                        <td><?php echo $firstRow['rentalcharges']; ?></td>
                    </tr>
                    <tr>
                        <th>Working Days:</th>
                        <td><?php echo $firstRow['workingdays']; ?> &nbsp;&nbsp; <strong> Working Hours :
                            </strong><?php echo $firstRow['shift_hour'] ?></td>
                    </tr>
                    <tr>
                        <th>Condition :</th>
                        <td><?php echo $firstRow['conditions']; ?></td>
                    </tr>
                </table>
                <!-- <img id="loglogo" src="img/<?php echo ($row_logo_fetch['companylogo']) ?>" alt="">
        <div class="compname_"><span><?php echo $companyname001 ?></span> </div>
 -->

            </div>
            <div class="logsheet_table_container">
                <table class="logsheet_table">
                    <thead>
                        <tr>
                            <th rowspan="2">Sr</th>
                            <th rowspan="2">Day</th>
                            <th rowspan="2">Date</th>
                            <th rowspan="2">Log Type</th>
                            <th colspan="2">Day Shift</th>
                            <th colspan="2">Day Shift KMR</th>
                            <th colspan="2">Day Shift HMR</th>
                            <th colspan="2">Night Shift Run</th>
                            <th colspan="2">Night Shift KMR</th>
                            <th colspan="2">Night Shift HMR</th>
                            <th rowspan="2">Total Hours</th>
                            <th rowspan="2">Fuel Taken</th>
                        </tr>
                        <tr>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Start KMR</th>
                            <th>Close KMR</th>
                            <th>Start HMR</th>
                            <th>Close HMR</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Start KMR</th>
                            <th>Close KMR</th>
                            <th>Start HMR</th>
                            <th>Close HMR</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Initialize variables to store the total hours and fuel
                        $totalHours = 0;
                        $totalFuel = 0;
                        $per_hour_rate = 1.00;
                        $overtime_rate = 1.50;
                        $totalBreakdownHours = 0;
                        $totalOvertimeHours = 0;
                        $totalProRataPay = 0;
                        $comments = [];
                        $sr_no = 1; // Fix: Always define $sr_no before loop

                        // Loop through all rows (all logtypes)
                        mysqli_data_seek($result, 0);
                        while ($row = mysqli_fetch_array($result)) {
                            // Calculate total hours for day shift (based on start and close HMR)
                            $dayStartHMR = $row['start_hmr'];
                            $dayCloseHMR = $row['closed_hmr'];
                            $dayShiftHours = ($dayCloseHMR - $dayStartHMR);

                            // Calculate total hours for night shift (based on start and close HMR)
                            $nightStartHMR = $row['night_start_hmr'];
                            $nightCloseHMR = $row['night_closed_hmr'];
                            $nightShiftHours = ($nightCloseHMR - $nightStartHMR);

                            // Sum the total hours for this row
                            $totalShiftHours = $dayShiftHours + $nightShiftHours;
                            $totalHours += $totalShiftHours;

                            // Add the fuel taken for this row to the total fuel
                            $totalFuel += $row['fuel_taken'];

                            // Collect breakdown and overtime hours for pay calculation
                            $totalBreakdownHours += floatval($row['breakdown_hours'] ?? 0);
                            $totalOvertimeHours += floatval($row['othours'] ?? 0);

                            // Collect comments if present
                            if (!empty($row['remark'])) {
                                $comments[] = $row['remark'];
                            }

                            // Pro Rata Pay calculation for this row
                            $prorata_percentage = isset($row['otprorata']) ? floatval($row['otprorata']) : 0;
                            $rentalcharges = isset($row['rentalcharges']) && $row['rentalcharges'] !== null ? floatval($row['rentalcharges']) : 0;
                            $workingdays = isset($row['workingdays']) && $row['workingdays'] > 0 ? intval($row['workingdays']) : 1;
                            $per_day_pay = $workingdays > 0 ? ($rentalcharges / $workingdays) : 0;
                            $prorata_pay = ($per_day_pay * $prorata_percentage) / 100;
                            $totalProRataPay += $prorata_pay;
                            ?>
                            <tr>
                                <td><?php echo $sr_no++; ?></td>
                                <td><?php echo date('D', strtotime($row['date'])); ?></td>
                                <td><?php echo date('d-M-y', strtotime($row['date'])); ?></td>
                                <td><?php echo htmlspecialchars($row['logtype']); ?></td>
                                <td><?php echo $row['start_time']; ?></td>
                                <td><?php echo $row['close_time']; ?></td>
                                <td><?php echo $row['start_km']; ?></td>
                                <td><?php echo $row['closed_km']; ?></td>
                                <td><?php echo $row['start_hmr']; ?></td>
                                <td><?php echo $row['closed_hmr']; ?></td>
                                <td><?php echo $row['night_start_time']; ?></td>
                                <td><?php echo $row['night_close_time']; ?></td>
                                <td><?php echo $row['night_start_km']; ?></td>
                                <td><?php echo $row['night_closed_km']; ?></td>
                                <td><?php echo $row['night_start_hmr']; ?></td>
                                <td><?php echo $row['night_closed_hmr']; ?></td>
                                <td><?php echo number_format($totalShiftHours, 2); ?> hours</td>
                                <td><?php echo $row['fuel_taken']; ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                        <!-- Display the sum of all hours and fuel at the end -->
             <!--            <tr>
                            <td colspan="4" style="text-align: right;"><strong>Total Hours Worked in Month:</strong></td>
                            <td colspan="15" style="text-align: left;"><strong><?php echo number_format($totalHours, 2); ?>
                                    hours</strong></td>
                        </tr>
                        <tr>
                            <td colspan="4" style="text-align: right;"><strong>Total Fuel Taken in Month:</strong></td>
                            <td colspan="15" style="text-align: left;"><strong><?php echo number_format($totalFuel, 2); ?>
                                    liters</strong></td>
                        </tr> -->
                    </tbody>
                </table>
                <!-- Summary section styled as per your image -->
                <table style="width:100%;border-collapse:collapse;margin-top:0;">
                    <tr>
                        <td colspan="100" style="border:1px solid #222; font-size:16px; font-weight:600; padding:8px 0; background:#f9f9f9;">
                            Total Hours Worked in Month: <span style="font-weight:400;"><?php echo number_format($totalHours, 2); ?> hours</span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="100" style="border:1px solid #222; font-size:16px; font-weight:600; padding:8px 0; background:#f9f9f9;">
                            Total Fuel Taken in Month: <span style="font-weight:400;"><?php echo number_format($totalFuel, 2); ?> liters</span>
                        </td>
                    </tr>
                </table>
                <!-- End summary section -->
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
                <!-- Comments Section -->
                <?php if (!empty($comments)): ?>
                    <table class="logsheet_table" style="margin-top:20px;">
                        <thead>
                            <tr>
                                <th colspan="2" style="background:#f5f5f5;">Comments</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($comments as $comment): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($comment); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
                <!-- End Comments Section -->
                <?php
                // Calculate breakdown pay and overtime pay
                $breakdown_pay = $totalBreakdownHours * $per_hour_rate;
                $overtime_pay = $totalOvertimeHours * $overtime_rate;

                // Step 1: Calculate Per Day Pay
                $totalDaysInMonth = date('t', strtotime($month . '-01'));
                // Prevent division by zero and null errors
                $rentalcharges = isset($firstRow['rentalcharges']) && $firstRow['rentalcharges'] !== null ? floatval($firstRow['rentalcharges']) : 0;
                $workingdays = isset($firstRow['workingdays']) && $firstRow['workingdays'] > 0 ? intval($firstRow['workingdays']) : 1; // Avoid zero
                $perDayPay = $workingdays > 0 ? ($rentalcharges / $workingdays) : 0;

                // Step 2: Calculate Normal Shift Pay
                $normalShiftPay = $perDayPay * ($sr_no - 1);

                // Step 3: Calculate Final Pay (add pro rata pay)
                $finalPay = $normalShiftPay + $overtime_pay + $totalProRataPay - $breakdown_pay;
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
                            <td><?php echo number_format($overtime_pay, 2); ?></td>
                        </tr>
                        <tr>
                            <td>Pro Rata Pay</td>
                            <td><?php echo number_format($totalProRataPay, 2); ?></td>
                        </tr>
                        <tr>
                            <td>Breakdown Deduction</td>
                            <td><?php echo '-' . number_format($breakdown_pay, 2); ?></td>
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
                <!-- Powered By Fleet EIP -->
                <div style="text-align: right; margin-top: 30px; font-size: 13px; color: #555;">
                    Powered By <strong>Fleet EIP</strong>
                </div>
                <!-- End Powered By -->
            </div>
        </div>
        <?php
    } else {
        // Show a message if no records found
        echo '<div class="logsheetcontainerprint"><div style="padding:40px;text-align:center;font-size:18px;color:#888;">No logsheet records found for this selection.</div></div>';
    }

    ?>
</body>
<script>
    function downloadsummary() {
        // Hide the action buttons before generating PDF
        const actionButtons = document.getElementById('action-buttons');
        if (actionButtons) actionButtons.style.display = 'none';

        const element = document.querySelector('.logsheetcontainerprint');
        // Use a clone to avoid affecting the live DOM
        const clone = element.cloneNode(true);

        // Optional: Remove any elements you don't want in PDF (already hidden by CSS)
        // Prepare filename
        const filename = "<?php echo $firstRow['month_year']; ?>-<?php echo $firstRow['assetcode']; ?>-<?php echo $firstRow['sitelocation']; ?>.pdf";

        // html2pdf options for quality and size
        html2pdf()
            .set({
                margin: [0.2, 0.2, 0.2, 0.2], // Narrow margins
                filename: filename,
                image: { type: 'jpeg', quality: 0.95 }, // High quality but not max
                html2canvas: {
                    scale: 2, // Good balance between quality and size
                    useCORS: true,
                    allowTaint: true,
                    logging: false,
                    scrollY: 0,
                    scrollX: 0,
                    windowWidth: clone.scrollWidth,
                    windowHeight: clone.scrollHeight
                },
                jsPDF: {
                    unit: 'mm',
                    format: 'a4',
                    orientation: 'portrait',
                    compress: true // Compress PDF to help keep under 1MB
                },
                pagebreak: { mode: ['avoid-all', 'css', 'legacy'] }
            })
            .from(clone)
            .save()
            .then(() => {
                // Restore the action buttons after PDF is generated
                if (actionButtons) actionButtons.style.display = '';
            })
            .catch(() => {
                if (actionButtons) actionButtons.style.display = '';
            });
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