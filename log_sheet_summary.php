<?php
include "partials/_dbconnect.php";
$showAlert = false;
$showError = false;
$log_del=false;



$ac = $_GET['id'];
session_start();
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

$sql = "SELECT * FROM `logsheet` WHERE assetcode='$ac' AND companyname='$companyname001' ORDER BY `date` DESC";
$result = mysqli_query($conn, $sql);
$row_hmr = mysqli_fetch_assoc($result);

$sql_breakdown = "SELECT * FROM `brkdown_log` WHERE asset_code='$ac' AND companyname='$companyname001' ";
$result_breakdown = mysqli_query($conn, $sql_breakdown);

$sql_table_data = "SELECT * FROM `logsheet` WHERE assetcode='$ac' AND companyname='$companyname001' ORDER BY `date` ASC";
$result_table_data = mysqli_query($conn, $sql_table_data);



$sql_fleet = "SELECT * FROM `fleet1` where assetcode='$ac' and companyname='$companyname001' ";
$result_fleet = mysqli_query($conn, $sql_fleet);
$row_fleet = mysqli_fetch_assoc($result_fleet);



$sql_fuelconsumption = "SELECT SUM(fuel_taken) AS total_fuel FROM `logsheet` WHERE assetcode='$ac' AND companyname='$companyname001'";
$result_consumption = mysqli_query($conn, $sql_fuelconsumption);
$row_consumption = mysqli_fetch_assoc($result_consumption);
$total_fuel_consumed = $row_consumption['total_fuel'];

$total_hours = 0;
$total_ot = 0;
$numbersString = 0;
$total_brk_hours = 0;
$amt_help = 0;


?>

<?php
if (isset($_SESSION['message'])) {
    $showAlert = true;
    unset($_SESSION['message']);
} else if (isset($_SESSION['errormessage'])) {
    $showAlert = true;
    unset($_SESSION['errormessage']);
}
else if(isset($_SESSION["log_del"])){
    $log_del=true;
    unset($_SESSION['log_del']);    
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">      <link rel="icon" href="favicon.jpg" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="js/jspdf.debug.js"></script>
    <script src="js/html2canvas.min.js"></script>
    <script src="js/html2pdf.min.js"></script>
    <title>Document</title>
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
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </div>
        </div>
        <?php
        if ($showAlert) {
            echo '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert notice">
      <span class="alertClose">X</span>
      <span class="alertText_addfleet"><b>Success!</b>LogSheet Edited Successfully
          <br class="clear"/></span>
    </div>
  </label>';
        }
        if ($log_del) {
            echo '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert notice">
      <span class="alertClose">X</span>
      <span class="alertText_addfleet"><b>Success!</b>Breakdown Log Deleted Successfully
          <br class="clear"/></span>
    </div>
  </label>';
        }
        if ($showError) {
            echo '<label>
            <input type="checkbox" class="alertCheckbox" autocomplete="off" />
            <div class="alert error">
                <span class="alertClose">X</span>
                <span class="alertText">Something Went Wrong<br class="clear"/></span>
            </div>
          </label>';
        }
        ?>

        <div class="summarycontainer" id="to_be_printed">
            <div class="client_info">
                <div class="first_side_client_info">
                    <p> <a class="log_summary">Client Name:</a> <?php echo $row_fleet['client_name'] ?></p>
                    <p><a class="log_summary"> Project Name: </a><?php echo $row_fleet['project_name'] ?></p>
                    <p><a class="log_summary"> Site Location:</a><?php echo $row_fleet['project_location'] ?></p>
                    <p><a class="log_summary">
                            Equipment:</a><?php echo $row_fleet['make'] . ' /' . $row_fleet['sub_type'] ?></p>
                    <p><a class="log_summary"> Work-Order Valid Upto:</a>
                        <?php echo date('d-m-Y', strtotime($row_fleet['workorder_valid'])); ?></p>
                </div>

                <div class="second_side_client_info">
                    <p> <a class="log_summary">Rental Charges:</a> <?php echo $row_fleet['rental_charges_wo'] ?></p>
                    <p><a class="log_summary"> Shift: </a><?php echo $row_fleet['shift_wo'] ?> Shift</p>
                    <p><a class="log_summary"> OT Charges:</a><?php echo $row_fleet['ot_charges'] ?>% pro-rata</p>
                    <p><a class="log_summary"> Working
                            Shift:</a><?php if (isset($row_hmr)) {
                                echo $row_hmr['hours_shift'];
                            } ?>Hours</p>
                    <p><a class="log_summary">Conditions:</a><?php echo $row_fleet['working_days_in_month'] ?>Days In A
                        Month <?php echo $row_fleet['condition_sundays'] ?></p>
                </div>


            </div>
            <table class="logsheet_table">
                <th>Sr No</th>
                <th>Day</th>
                <th id="date_logsheet">Date</th>
                <th>Shift</th>
                <th>Operator Name</th>
                <th class="day_shift_run23">
                    <div class="kmrrun">Time</div>
                    <div class="start_close">
                        <p>Start</p>
                        <p>Closed</p>
                    </div>
                </th>
                <th class="day_shift_run1">
                    <div class="kmrrun"> KMR Run</div>
                    <div class="start_close">
                        <p>Strt KMR</p>
                        <p>Close KMR</p>
                    </div>
                </th>
                <th class="day_shift_run1">
                    <div class="kmrrun">HMR Run</div>
                    <div class="start_close">
                        <p>Strt HMR</p>
                        <p>Close HMR</p>
                    </div>
                </th>
                <th>Fuel Taken</th>
                <th>Engineer Name</th>
                <th>Remark</th>
                <th>OT Hours</th>
                <th>Total Hours</th>
                <th id="action_logsheet">Actions</th>
                <?php while ($row = mysqli_fetch_assoc($result_table_data)) {

                    $current_hours = floatval($row['closed_hmr']) - floatval($row['start_hmr']) + floatval($row['night_close_hmr']) - floatval($row['night_start_hmr']);
                    $total_hours += $current_hours;
                    $numbersString++;
                    if($numbersString > $row_fleet['working_days_in_month']){
                        $overtime_new=(float)($row['closed_hmr'] - (float)$row['start_hmr']) + (float) ($row['night_close_hmr'] - (float) $row['night_start_hmr']);
                    }
                    else{
                    

                    if ($row_fleet['condition_sundays'] === 'Excluding Sunday' && date('D', strtotime($row['date'])) === 'Sun') {
                        $numbersString="0"; 
                        $overtime_new = (float)($row['closed_hmr'] - (float)$row['start_hmr']) + (float) ($row['night_close_hmr'] - (float) $row['night_start_hmr']);
                    } else {
                        if (((float) ($row['closed_hmr']) - (float) ($row['start_hmr'])) + ((float) ($row['night_close_hmr']) - (float) ($row['night_start_hmr'])) > (float) ($row_hmr['hours_shift'])) {
                            $overtime_new = ((float) $row['closed_hmr'] - (float) $row['start_hmr']) + (float) ($row['night_close_hmr'] - (float) $row['night_start_hmr']) - (float) $row_hmr['hours_shift'];
                        } else {
                            $overtime_new = "0";
                        }
                    }}
                    $total_ot += $overtime_new;



                    ?>
                    <tr class="row_cont">
                    <tr>
                        <td rowspan="2"><?php echo $numbersString ?></td>
                        <td rowspan="2"><?php
                        $dateString = $row['date'];
                        echo date('D', strtotime($dateString));
                        ?>
                        </td>
                        <td rowspan="2"><?php echo date('d-m-y', strtotime($row['date'])); ?></td>
                        <td class="">Day</td>

                        <td class=""><?php echo $row['operator_name'] ?></td>
                        <td>
                            <div class="time_info ">
                                <div class="strttime">
                                    <?php echo $row['start_time'] . $row['unit1']; ?>     <?php if (empty($row['start_time'])) {
                                                  echo '0';
                                              } ?>
                                </div>
                                <div class="endtime"><?php echo $row['close_time'] . $row['unit2']; ?></div>
                        </td>
                        <td>
                            <div class="time_info ">
                                <div class="strttime"><?php echo $row['start_km'] ?></div>
                                <div class="endtime"><?php echo $row['closed_km'] ?></div>
                            </div>
                        </td>
                        <td>
                            <div class="time_info ">
                                <div class="strttime"><?php echo $row['start_hmr'] ?></div>
                                <div class="endtime"><?php echo $row['closed_hmr'] ?></div>
                            </div>
                        </td>
                        <td rowspan="2"><?php echo $row['fuel_taken'] ?></td>
                        <td class="" rowspan="1"><?php echo $row['engineer_name'] ?></td>
                        <td rowspan="2"><?php echo $row['remark'] ?></td>
                        <td rowspan="2"><?php echo $overtime_new ?></td>

                        <td rowspan="2">
                            <?php echo (float) ($row['closed_hmr'] - (float) $row['start_hmr']) + ((float) $row['night_close_hmr'] - (float) $row['night_start_hmr']) ?>
                        </td>
                        <td rowspan="2" class="log_btn_"><a href="edit_logsheet.php?id=<?php echo $row['id']; ?>"
                                class="logsheet_Edit">Edit</a> <a onclick="delete_logsheet(<?php echo $row['id']; ?>)"
                                id="delete_logsheet_button" class="logsheet_Edit">Delete</a></td>
                    </tr>
                    <?php $second_row = (empty($row['night_start_hmr'])) ? 'hidden' : ''; ?>

                    <tr <?php echo $second_row ?>>


                        <td>Night</td>
                        <td><?php echo $row['night_shift_operator'] ?></td>
                        <td>
                            <div class="time_info">
                                <div class="strttime"><?php echo $row['night_start_time'] . $row['unit1_night'] ?></div>
                                <div class="endtime"><?php echo $row['night_close_time'] . $row['unit2_night'] ?></div>
                            </div>
                        </td>
                        <td>
                            <div class="time_info">
                                <div class="strttime"><?php echo $row['night_start_km'] ?></div>
                                <div class="endtime"><?php echo $row['night_close_km'] ?></div>
                            </div>
                        </td>
                        <td>
                            <div class="time_info">
                                <div class="strttime"><?php echo $row['night_start_hmr'] ?></div>
                                <div class="endtime"><?php echo $row['night_close_hmr'] ?></div>
                            </div>
                        </td>

                        <td><?php echo $row['night_shift_engineer'] ?></td>

                    </tr>
                    </tr>
                    <div id="deleteModal_<?php echo $row['id']; ?>" class="modal">
                        <div class="modal_inside_cont">
                            <div class="popup">
                                Confirm Delete ?
                                <div class="btn_"><a href="delete_logsheet.php?id=<?php echo $row['id']; ?>"
                                        class="log_btn">Confirm</a><a class="log_btn"
                                        href="log_sheet_summary.php?id=<?php echo $row_fleet['assetcode'] ?>">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                } ?>
            </table>
            <?php if ($result_breakdown && mysqli_num_rows($result_breakdown) > 0) {
                ?>
                <table class="breakdown_table_data">
                    <th>Day</th>
                    <th>Date</th>
                    <th>Asset Code</th>
                    <th>Breakdown Hour</th>
                    <th>Reason</th>
                    <th id="brkdown_action">Action</th>
                    <?php while ($row_breakdown = mysqli_fetch_assoc($result_breakdown)) {
                        $total_brk_hours += $row_breakdown['brkdown_hour'];
                        ?>
                        <tr>
                            <td><?php
                            $dateString = $row_breakdown['date'];
                            echo date('D', strtotime($dateString));
                            ?></td>
                            <td><?php echo date('d-m-y', strtotime($row_breakdown['date'])); ?></td>
                            <td><?php echo $row_breakdown['asset_code'] ?></td>
                            <td><?php echo $row_breakdown['brkdown_hour'] ?></td>
                            <td><?php echo $row_breakdown['reason'] ?></td>
                            <td class="brk_button"><a href="edit_brkdown.php?id=<?php echo $row_breakdown['id'] ?>" class="logsheet_Edit">Edit</a>
                            <a onclick="del_ot_()" id="brkdown_del" class="logsheet_Edit">Delete</a></td>
                        </tr>
<div class="black_modal" id="del_ot_screen">
    <div class="del_ot_inner">
        <div class="done_task">
            <h3><strong>Delete Breakdown Log ?</strong></h3>
            <div class="btn_task_done">
            <a id="" onclick=" close_ot_log(<?php echo $row_breakdown['id'] ?>, '<?php echo $ac ?>')" class="cls-btn">Delete</a>
                &nbsp;
                <button class="cls-btn" onclick="window.location='log_sheet_summary.php?id=<?php echo $ac; ?>'">Cancel</button>
            </div>
        </div>
    </div>
</div>
                        <?php
                    } ?>


                </table>
                <?php
            } ?>
            <div class="stats_container">
                <P>Total Running Hour:- <?php echo $total_hours ?> Hour </P>
                <p>Fuel Issued:- <?php echo $total_fuel_consumed ?> Ltr</p>
                <p>Fuel Consumption Norms As Per LOI:-<?php echo $row_fleet['fuel_norms'] ?>Ltr  &nbsp; &  &nbsp;  Actual Fuel Consumed Per Hour:- <?php echo $total_fuel_consumed / $total_hours  ?> Ltr</p>

            </div>


            <div class="total_hours_container">
                <div class="first">
                    <p class="desc">Description</p>
                    <p>Hiring Charges</p>
                    <p>OT Charges</p>
                    <p>Breakdown Charges</p>
                    <p>Crew Charges</p>
                </div>



                
                <div class="second">
                    <p class="desc">Basic Amount</p>

                    <?php if (isset($row_hmr)) {
                        // Perform calculations for hiring charges, breakdown base price, and OT base price
                        $hiring_charges = number_format((float) $row_fleet['rental_charges_wo'] / (float) $row_fleet['working_days_in_month'], 3);
                        $brk_down_baseprice = number_format((float) $row_fleet['rental_charges_wo'] / (float) $row_fleet['working_days_in_month'] / (float) $row_hmr['hours_shift'], 3);
                        $ot_base_price = number_format((float) ($row_fleet['rental_charges_wo'] / (float) $row_fleet['working_days_in_month'] / (float) $row_hmr['hours_shift']) * (float) ($row_fleet['ot_charges']) / 100, 3);
                    } else {
                        // Set default values if $row_hmr is not set
                        $hiring_charges = 0;
                        $brk_down_baseprice = 0;
                        $ot_base_price = 0;
                    }
                    ?>
                    <p><?php echo $hiring_charges ?></p>
                    <p><?php echo $ot_base_price ?></p>
                    <p><?php echo $brk_down_baseprice ?></p>
                    <p><input type="text" id="helper_amount" oninput="displayValue()"></p>
                </div>
                <div class="third">
                    <p class="desc">Quantity</p>
                    <p><?php echo $numbersString ?></p>
                    <p><?php echo $total_ot ?></p>
                    <p><?php echo $total_brk_hours ?></p>
                    <p><?php echo '&nbsp;' ?></p>
                    <p>Total</p>
                    <p>Gst 18%</p>
                    <p>Grand Total</p>



                </div>
                <br><br>
                <div class="fourth">
                    <p class="desc">Total</p>
                    <?php
                    if (isset($row_fleet['rental_charges_wo']) && isset($row_fleet['working_days_in_month']) && isset($row_hmr['hours_shift']) && isset($total_ot) && isset($total_brk_hours)) {
                        $total_hire_charge = ((float) $row_fleet['rental_charges_wo'] / (float) $row_fleet['working_days_in_month']) * (int) $numbersString;
                        (float) $num_total_hire_charge = (floatval($total_hire_charge));
                        (float) $total_ot_cal = (((float) ($row_fleet['rental_charges_wo'] / (float) $row_fleet['working_days_in_month'] / (float) $row_hmr['hours_shift']) * (float) ($row_fleet['ot_charges']) / 100) * floatval($total_ot));
                        (float) $totl_breakdown_charges = ((float) ($row_fleet['rental_charges_wo'] / (float) $row_fleet['working_days_in_month'] / (float) $row_hmr['hours_shift']) * floatval($total_brk_hours));
                        ?>
                        <p><?php echo number_format($num_total_hire_charge, 3) ?></p>

                        <p><?php echo number_format($total_ot_cal, 3) ?></p>

                        <p><?php echo number_format($totl_breakdown_charges, 3) ?></p>
                        <input id="display_help_amt" name="helper_amount_total">
                        <?php $grand_total_amt = ($num_total_hire_charge + $total_ot_cal) - ($totl_breakdown_charges) ?>
                        <p id="grand_total_amount"><?php echo number_format($grand_total_amt, 3); ?></p>
                        <p><?php echo $grand_total_amt * 0.18 ?></p>
                        <p><?php  echo number_format($grand_total_amt + ($grand_total_amt * 0.18), 0    ) ?></p>


                    <?php } else { ?>
                        <p>Some required data is not available for calculation.</p>
                    <?php } ?>
                   

                </div>
               
            </div>
        </div>
        <div class="btn_cont">
            <button class="epc-button" id="downloadButton" type="submit" onclick="downloadPDF()">Download</button>
             &nbsp  <a href="generate_bill.php" class="epc-button">Generate Bill</a>
        </div>
        <br><br>
        <script>
function close_ot_log(id, ac) {
    window.location = "del_ot.php?id=" + id + "&asset_code=" + ac;
}



function del_ot_(){
    document.getElementById("del_ot_screen").style.display="block";
}

            function delete_logsheet(id) {
                // Construct modal ID based on row ID
                const modalId = `deleteModal_${id}`;
                // Display the corresponding modal
                document.getElementById(modalId).style.display = 'block';
            }

            function downloadPDF() {
                
                const element = document.querySelector('.summarycontainer'); // Select the summarycontainer div
                document.getElementById("action_logsheet").style.display = 'none';
                document.getElementById("brkdown_action").style.display = 'none';
                // Loop through all rows in the table
                document.querySelectorAll('.logsheet_table tr').forEach(row => {
                    // Hide the cell in the "Actions" column for each row
                    const actionCell = row.querySelector('.log_btn_');
                    if (actionCell) {
                        actionCell.style.display = 'none';
                    }
                });
                document.querySelectorAll('.breakdown_table_data tr').forEach(row => {
                    // Hide the cell in the "Actions" column for each row
                    const actionCell_brkdown = row.querySelector('.brk_button');
                    if (actionCell_brkdown) {
                        actionCell_brkdown.style.display = 'none';
                    }

                });

                html2pdf(element, {
                    margin: 3,
                    filename: 'Asset Code <?php echo $ac ?> logsheet.pdf',
                    image: { type: 'jpeg', quality: 1.0 },
                    html2canvas: { dpi: 290, letterRendering: true, scale: 3 },
                    jsPDF: { unit: 'mm', format: [360,200], orientation: 'portrait' }
                });
            }

            function displayValue() {
                var inputField = document.getElementById('helper_amount');
                var help_amt = inputField.value;
                if (help_amt === '') {
                    help_amt = '0'; // If empty, set help_amt to '0'
                }

                // Display the value directly in the last <p> tag
                document.getElementById("display_help_amt").value = help_amt;
                
                var rentalCharges = <?php echo $num_total_hire_charge; ?>;
    var otCharges = <?php echo $total_ot_cal; ?>;
    var breakdownCharges = <?php echo $totl_breakdown_charges; ?>;
    var grandTotal = parseFloat(rentalCharges) + parseFloat(otCharges) - parseFloat(breakdownCharges) + parseFloat(help_amt);
    document.getElementById("grand_total_amount").innerHTML = grandTotal.toFixed(3);           
}

        </script>
</body>

</html>