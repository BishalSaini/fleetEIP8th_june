<?php
session_start();
include "partials/_dbconnect.php";

// Retrieve company name from session and id from query string
$companyname001 = $_SESSION['companyname'];
$id = $_GET['id'];

// Query the database for the specified id
$sql = "SELECT * FROM `logistic_quotation_generated` WHERE id='$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$sql_basic_detail="SELECT * FROM `basic_details` where companyname='$companyname001'";
$result_basic_detail=mysqli_query($conn,$sql_basic_detail);
$row_basic=mysqli_fetch_assoc($result_basic_detail);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="favicon.jpg" type="image/x-icon">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>

    <link rel="stylesheet" href="style.css">
    <title>Logistic Quotation</title>
</head>
<body id="printlogiquote">
<div class="button_container" id="logiquotebutton">
    <button class="print_quotation"  type="button" onclick="downloadPDF()">Download Quoatation</button> &nbsp
    <button class="print_quotation"  type="button" onclick="window.location.href='logisticsquotation.php'">Go Back</button>

    <!-- <BUTTON class="">PRINT</BUTTON> -->

    </div>

    <div class="logiquote_container">
        <div class="logoname_container">
        <div class="logilogo"><img src="img/<?php echo htmlspecialchars($row_basic['companylogo']); ?>" alt=""></div>
        <div class="loginame"><?php echo htmlspecialchars($companyname001); ?></div>
        </div>
        
        <div class="contentlogi">
            <div class="date_containerlogi">
                <p>Date: <?php echo date('d-m-Y', strtotime($row['date'])); ?></p>
                <p>Ref-No: <?php echo htmlspecialchars($row['ref_no']); ?></p>
            </div>
            
            <div class="to_data">
                <div class="to1">
                    <p><strong>Client Name</strong></p>
                    <p>To: <?php echo htmlspecialchars($row['to_person']); ?></p>
                    <p><?php echo htmlspecialchars($row['to_address']); ?></p>
                </div>
                <div class="to2">
                    <p>Contact Person: <?php echo htmlspecialchars($row['contact_person']); ?></p>
                    <p>Cell: <?php echo htmlspecialchars($row['contact_number']); ?></p>
                    <p>Email ID: <?php echo htmlspecialchars($row['email']); ?></p>
                </div>
            </div>
            
            <p class="logipara">This is with reference to your inquiry, we are pleased to provide the following quote for transportation</p>
            
            <table class="logiquotetable">
                <thead>
                    <tr>
                        <th>Material</th>
                        <th>Size (<?php echo ($row['dimension_unit']); ?>) & Weight</th>
                        <th>Trailer Type</th>
                        <th>Freight Charges</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = 1; $i <= 4; $i++): ?>
                        <?php if (!empty($row["material$i"])): ?>
                            <tr>
                                <td><?php echo ($row["material$i"]); ?></td>
                                <td><?php echo ($row["length$i"] . '* ' . $row["width$i"] . '* ' . $row["height$i"] . '-' . $row["weight$i"] . $row["weight_unit"]); ?></td>
                                <td><?php echo ($row["trailor_type$i"]); ?></td>
                                <td><?php echo number_format($row["freight$i"], 0, '.', ',') . ' (' . ($row["ratecondition$i"]) . ')'; ?></td>
                            </tr>
                        <?php endif; ?>
                    <?php endfor; ?>
                </tbody>
            </table>
            <div class="withregard_section" id="logiregard">
            <p>Thanks And Regards</p>
            <p class="sender_name"><?php echo $row['senders_name'] ?></p>
            <?php $senders_name= $row['senders_name'];
            $sql_designation="SELECT * FROM `team_members` where company_name='$companyname001' and name='$senders_name'";
            $result_designation=mysqli_query($conn,$sql_designation);
            $row_designation=mysqli_fetch_assoc($result_designation);
            
            ?>
            <p class="sender_name"><?php echo $row_designation['designation'] ?></p>
            <p class="sender_name"><?php echo $row['companyname'] ?></p>
            <p><?php echo $row['senders_number'] ?></p>
            
            <p><?php echo $row['senders_email'] ?> </p>


               

            </div>
            <div class="terms_cond" id="logiterms_container">
                <h2>Terms & Conditions :</h2>
                <p class="terms_condition">
                <strong>1.Transportation Liability :</strong>Transportation shall be done by us on <?php echo $row['risk'] ?> as per terms & conditions laid down on our
                consignment note
                </p>
                <p class="terms_condition"><strong>2.Insurance Liability :</strong>Transit Insurance is in <?php echo $row['insaurance'] ?></p>
                <p class="terms_condition"><strong>3.Scope of Services: Loading and Unloading Charges :</strong>Loading & Unloading charges is in<?php echo $row['loading'] ?></p>
                <p class="terms_condition"><strong>4.Detention :</strong>Detention free period at loading /unloading point is <?php echo $row['detention'] ?> after that detention charges will be imposed .</p>
                <p class="terms_condition"><strong>5.Freight Rate Adjustment  :</strong>Our offer is based on the prevailing prices of diesel, in case of any increase in price of diesel, freight
                rates shall increase by <?php echo $row['freight_change'] ?> with every 1% increase in prices of diesel.</p>
                <p class="terms_condition"><strong>6.Obstacles Removal Responsibility :</strong>Removal of any phatak, wires or any other obstacles from road shall be in <?php echo $row['obstacle'] ?></p>
                <p class="terms_condition"><strong>7.Supporting Equipment Scope :</strong>In case extra wooden slippers , chain or any other supporting equipment to  be required will be in <?php echo $row['supporting'] ?> at <?php echo $row['tool_cost'] ?></p>
                 <p class="terms_condition"><strong>8.Offer Validity :</strong>Proposed offer is valid for <?php echo $row['offer'] ?></p>           
                
             <p class="terms_condition"><strong>9.Advance Payment :</strong> <?php echo $row['adv'] ?> Advance payment at time of Loading & Balance Payment within <?php echo $row['balance'] ?> of our bill submission.In case of delay/refusal in clearing our charges, interest at 18% P.a. shall be claimed and needs to be paid by client.</p>
             <p class="terms_condition">
    <strong>10.Rate Adjustment :</strong> <?php echo $row['rate_adjustment'] ?>
                        </p>
                        <p class="terms_condition"><strong>11.Taxes :</strong> <?php echo $row['taxes'] ?>
                        </p>
                        <hr>
                        <?php 
                        $sql_add="SELECT * FROM `basic_details` WHERE companyname='$companyname001'";
                        $result_address=mysqli_query($conn,$sql_add);
                        $row_address=mysqli_fetch_assoc($result_address);
                        ?>
                        <p class="terms_condition" id="officeaddlogi">Office : <?php echo $row_address['company_address'] ?></p>
                        <p class="watermarklogi">Powered By Fleet EIP.</p>
                        </div>
        </div>
    </div>
</body>
<script>
function downloadPDF() {
    const element = document.querySelector('.logiquote_container');

    html2pdf(element, {
        margin: [-0.1, 0.2, 0.2, 0.2],
        
        filename: '<?php echo $row['ref_no'] . ' ' . $row['to_person'] . '-' . $row['trailor_type1'] . '.pdf';
?>',
        image: { type: 'jpeg', quality: 2.0 },
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
