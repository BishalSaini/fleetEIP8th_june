<?php
include "partials/_dbconnect.php";
session_start();
$companyname001=$_SESSION['companyname'];
$id=$_GET['id'];
$sql="SELECT * FROM `workorder` where id='$id'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);
?>

<link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
<link rel="stylesheet" href="style.css">
<style>
                .page-break {
                page-break-before: always; /* Forces a page break before the element */
                page-break-inside: avoid; /* Avoids breaking inside the element */
            }

</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>

<title>Print Workorder</title>
<div class="fulllength">
        <button onclick="downloadworkorder()" class="downloadbuttonsummary">Download</button>
        <button onclick="window.location.href='workorder.php'" class="gobackbuttonsummary">    <i class="bi bi-arrow-left"></i> Go Back
        </button>
    </div>

<div class="printwo">
    <div class="companynamewo"><div class="complogowo"><img src="img/logo_fe.png" alt=""></div><?php echo $companyname001 ?></div>
    <div class="date">Date: <?php echo date('d-m-Y', strtotime($row['entrydate'])); ?></div>
    <?php $firstThreeLetters = substr($companyname001, 0, 3); ?>

    <div class="date">Ref No: <?php echo $firstThreeLetters ?> / <?php echo substr($row['entrydate'], 0, 4);  ?> / <?php echo $row['ref_no'] ?></div>

    <div class="tocontainer">
            <div class="toadress">To, <p class="sender_name space"><?php echo $row['issued_to'] ?></p> <p class="sender_name address_tobe_sent space"><?php echo $row['address'] ?></p> </div>

            <div class="to_contactperson sender_name">Contact Person :<?php echo $row['contact_person'] ?> <p class="space">Cell :<?php echo $row['cell'] ?></p>
            <p class="space"><strong>Work Order End Date: <?php echo (new DateTime($row['start_date']))->format('jS M Y'); ?></strong></p>
            <p class="space"><strong>Work Order End Date: <?php echo (new DateTime($row['end_date']))->format('jS M Y'); ?></strong></p>
            </p>
        </div>
</div>
<div class="subjectwo">
            <p><strong>Subject :</strong>Workorder for hiring of your <?php echo $row['equipment_detail'].'-'. $row['qty'].'Nos For Our Project '. $row['projectname'].' '. $row['district'].'-'.$row['state'] ?> </p>
</div>
<br>
<div class="salutation">
            <p>Dear Sir/Ma'am;</p>
            <p>In accordance with your quotation and subsequent discussions, we are pleased to issue this Work Order for the project mentioned above, under the terms and conditions outlined below.</p>
            
        </div>

        <table class="woinfo">
            <tr>
            <th>Equipment</th>
            <th id="minwidthwo">Qty</th>
            <th id="rentalwo">Rental Rate</th>
            </tr>

            <tr>
                <td><?php echo $row['equipment_detail'] ?></td>
                <td><?php echo $row['qty'] ?></td>
                <td><?php echo $row['rate'] ?></td>
            </tr>
</table>
<br>
<div class="page-break"></div>

<p class="heading_terms">Terms & Conditions :
</p>
<?php if ($row['hours_duration'] > 0 || $row['engine_hour'] > 0): ?>
    <p class="terms_condition">
        <strong>Working Shift :</strong>
        The above rate will be applicable for 
        <?php echo $row['shiftinfo'] . ' - ' . ($row['hours_duration'] > 0 ? $row['hours_duration'] . ' Hour' : '') . 
        ($row['engine_hour'] > 0 ? ' ' . $row['engine_hour'] . ' Hour' : ''); ?> with <?php echo $row['days_duration']. ' working days in a month the working shift begins at '. $row['working_shift_start'].' and ends at ' . $row['working_shift_end'] .' '. $row['working_shift_end_unit'].' '. $row['lunch_time'] ?>
    </p>
<?php endif; ?>   
<p class="terms_condition">
    <strong>Over time payment : </strong>
    Over time charges will be paid on <?php echo $row['ot_payment'].' pro-rata (If Any)'?>
</p> 
<p class="terms_condition">
    <strong>Operating Crew : </strong>
    <?php echo $row['issued_to'].' should provide '.$row['operating_crew_select'] .' your vehicle must accompany all necessary legal documents, and your operators must possess and carry the appropriate licenses.' ?>
</p>
<p class="terms_condition">
    <strong>Operator Room Scope :</strong>
    Operator room will be in <?php echo $row['operator_room_scope_select'] ?>
</p>
<?php if ($row['op_salary'] !== 'Not Applicable'): ?>
    <p class="terms_condition">
    <strong>Operator Salary Scope :</strong>

        Operator salary will be <?php echo $row['op_salary']; ?>
    </p>
<?php endif; ?>

<?php if ($row['helper_salary'] !== 'Not Applicable'): ?>
    <p class="terms_condition">
    <strong>Helper Salary Scope Scope :</strong>

        Helper salary will be <?php echo $row['helper_salary']; ?>
    </p>
<?php endif; ?>

<?php if ($row['equip_maintanance'] !== 'Not Applicable'): ?>
    <p class="terms_condition">
    <strong>Equipment Maintainance Scope : </strong>

        Equipment maintenance will be in <?php echo $row['equip_maintanance']; ?>
    </p>
<?php endif; ?> <!-- Added closing tag here -->

<?php if ($row['crew_food_scope_select'] !== 'Not Applicable'): ?>
    <p class="terms_condition">
        <strong>Crew Food Scope : </strong>
        Operating crew food will be in <?php echo $row['crew_food_scope_select']; ?>
    </p>
<?php endif; ?>

<?php if ($row['crew_travelling_select'] !== 'Not Applicable'): ?>
    <p class="terms_condition">
        <strong>Crew Travelling Scope : </strong>
        Operating crew travel will be in <?php echo $row['crew_travelling_select']; ?>
    </p>
<?php endif; ?>
<p class="terms_condition">
    <strong>Fuel Consumption : </strong>
Only <?php echo $row['fuel_consumption'] ?> will be provided by us free of cost for the operation, based on actual consumption. However, the fuel consumption norms will be  
<?php echo $row['fuelconsumptiondecided'] .''. $row['fuel_unit'] ?> or actual consumption fixed by the P&M in charge, whichever is less. Fuel consumption above the norms fixed and lubricants issued will be charged to you at procurement price + 20%, including handling charges.
</p>
<p class="terms_condition">
    <strong>Monsoon Consession</strong>
    It shall be noted that the rate quoted and accepted therein shall remain firm for the entire duration of the contract until satisfactory completion of all work under this agreement. Rental shall be paid at <?php echo $row['monsoonselect'] ?>
% of the monthly rental during the rainy season.
</p>
<p class="terms_condition">
    <strong>Demobilization Notice :</strong>The hire period is tentative, and a minimum of 
<?php echo $row['notice_period'] ?> days
 notice must be provided before demobilization of the machine.
</p>
<p class="terms_condition"><strong>Dehire Clause : </strong>
In case of unsatisfactory performance and non-working of your equipment due to any reasons, we reserve the right to terminate the contract <?php echo $row['dehire'] ?></p>
<p class="terms_condition">
    <strong>Payment Clause : </strong>All payments will be made by A/C payee cheques within 
<?php echo $row['payment_clause'] ?> days
 after submission and certification of the original bill.
</p>
<p class="terms_condition"><strong>SHE Norms :</strong>
Safety, health, and environment (SHE) norms as applicable by our client shall be strictly followed by you at <?php echo $row['she_norms'] ?> to <?php echo $companyname001 ?>
Any violation of the above SHE norms on the site shall attract a penalty, to be decided solely by <?php echo $companyname001 ?>.
</p>
<p class="terms_condition"><strong>Documentation :</strong>
All details (like running hours, HSD, breakdown, etc.) shall be maintained by the representatives of and epc, which has to be produced along with the monthly bill for verification</p>
<p class="terms_condition">
    <strong>Safety :</strong>
    You will be responsible for the safety of your equipment, workmen's compensation, and all other statutory obligations pertaining to your employees. All costs shall be borne by you. Necessary insurance for your equipment shall be arranged by you at
    <?php echo $row['safety_select'] ?> to <?php echo $companyname001 ?>
</p>
<p class="terms_condition">
    <strong>Operator Responsibility and Penalty Clause :</strong>
    In the event of the absence of the operator with a valid license engaged by you, <?php echo $row['operator_responsibility'] ?> shall be allowed to operate the equipment. If rule breach found so, a penalty shall be imposed on you in an amount mutually agreed upon.
</p>
<p class="terms_condition">
    <strong>Machine Deployment :</strong>
    Your equipment can be deployed anywhere within the site premises.
</p>

<p class="terms_condition">
    <strong>Liability for Damage and Repairs :</strong>
    In the event of damage caused by the movement of your equipment or any operational irregularity by your operator, and such incidents have caused damage to any property of epc or any other third party, the cost of repairs for the damages and/or compensation payable, penalties, etc., shall be borne by you.</p>
<p class="terms_condition">
    <strong>Submission of Logbook and Invoice : </strong>
    Only <?php echo $companyname001 ?> logbook should be submitted along with the invoice.
</p>
<p class="terms_condition">
    <strong>Force Majeure Clause : </strong>
    If due to any reason beyond our control, such as plant stoppages, acts of God, natural disasters, wars, riots, floods, earthquakes, pandemic causes, strikes at the state or national level, etc., or any other events beyond our control, we may not be able to implement this contract. You will have no claim on us for the implementation of this contract during such periods of force majeure."
</p>
<p class="terms_condition"><strong>GST Documentation Requirements : </strong>
GST as applicable on submission of documentary proof, i.e., GST Return and Challan copy.
</p>


</div>
</body>
<script>
                function fix() {
                $(window).resizeBy(250, 250);
                $(window).focus();
            }

function downloadworkorder() {
    const element = document.querySelector('.printwo');

    html2pdf(element, {
        margin: 0.2, // Adjust the margin as needed
        filename: '<?php echo $row['issued_to'] . ' ' . $row['projectname'] . '-' . $row['district'] . '.pdf';
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

