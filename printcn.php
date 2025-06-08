<?php
session_start();
include "partials/_dbconnect.php";
$companyname001=$_SESSION['companyname'];
$id=$_GET['id'];
$sql="SELECT * FROM `cn` where id='$id'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);

$sqlbank="SELECT * FROM `complete_profile` where companyname='$companyname001'";
$resultbank=mysqli_query($conn,$sqlbank);
if($resultbank){
    $rowbank=mysqli_fetch_assoc($resultbank);
}
else{
     $rowbank=array();
}

$sql_basic="SELECT * FROM `basic_details` where companyname='$companyname001'";
$result_basic=mysqli_query($conn,$sql_basic);
if($result_basic){
    $row_basic=mysqli_fetch_assoc($result_basic);
}
else{
    $row_basic=array();
}
$sql_login="SELECT * FROM `login` where companyname='$companyname001'";
$result_login=mysqli_query($conn,$sql_login);
if($result_login){
    $row_login=mysqli_fetch_assoc($result_login);
}
else{
    $row_basic=array();
}

$sql_registration="SELECT * FROM `registration_details` where company_name='$companyname001'";
$result_registration=mysqli_query($conn,$sql_registration);
if($result_registration){
    $row_regi=mysqli_fetch_assoc($result_registration);
}
else{
    $row_regi=array();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <!-- <script src="/bundles/jquery"></script> -->
        <link rel="icon" href="favicon.jpg" type="image/x-icon">
        <!-- <link rel="stylesheet" href="style.css"> -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>

        <title>Print CN</title>
        <style>
body {
    font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Arial, sans-serif!important;
    margin: 0;
    padding: 0;
    background-color: #fff;
}

table {
    border-collapse: collapse;
    box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
    
    width: 100%;
    max-width: 900px;
    margin: 20px auto;
    font-size: 13px;
    overflow: hidden;
}

th, td {
    border: 1px solid #d3d3d3;
    padding: 10px;
    text-align: left;
}

th {
    background-color: #f4f4f4;
    font-weight: bold;
}

td {
    background-color: #fff;
}

h1, h2, h5 {
    margin: 0;
    font-weight: normal;
}

h1 {
    font-size: 24px;
    margin-bottom: 10px;
}

h2 {
    font-size: 20px;
    margin-bottom: 5px;
}

h5 {
    font-size: 16px;
    color: #555;
}

.text-center {
    text-align: center;
}

.font-small {
    font-size: 12px;
}

.highlight {
    color: #ff6600;
}

.frt {
    text-align: center;
    font-weight: bold;
}

.row {
    margin-bottom: 10px;
}

hr {
    border: 0;
    height: 1px;
    background: #ff6600;
    margin: 20px 0;
}

.printbtn {
    display: inline-block;
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.printbtn:hover {
    background-color: #0056b3;
}
.logicnlogo{
    /* border:1px solid red; */
}
.logicnlogo img{
    height:100px;
    width:auto;

}
.printcnbutton_container{
    display:flex;
    align-items:center;
    width:100%;
    justify-content:center;
    margin-top:30px;
}
.epc-button {
    padding: 10px 20px; /* Increased vertical padding for better click area */
    min-width: 150px; /* Slightly wider button for readability */
    height: auto; /* Allow flexibility for varying content */
    margin-bottom: 15px;
    background-color: #1c549e; /* Consistent primary color */
    border-radius: 8px; /* Softer rounded corners for modern design */
    font-size: 16px;
    color: #fff;
    text-transform: uppercase;
    cursor: pointer;
    border: none;
    font-weight: 600;
    display: inline-flex; /* Retain alignment but allow flexibility in layout */
    align-items: center;
    justify-content: center;
    text-decoration: none;
    margin-right: 8px;
    transition: background-color 0.3s, transform 0.2s; /* Add smooth transitions */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
}

.epc-button:hover {
    background-color: #16447d; /* Darker shade on hover for contrast */
    transform: translateY(-2px); /* Slight lift effect on hover */
    box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15); /* Enhance shadow on hover */
}

.epc-button:active {
    background-color: #12365e; /* Even darker shade for active state */
    transform: translateY(1px); /* Slight press-in effect */
    box-shadow: 0 3px 5px rgba(0, 0, 0, 0.1); /* Subtle shadow adjustment */
}

.epc-button:focus {
    outline: 3px solid rgba(28, 84, 158, 0.5); /* Visible focus outline for accessibility */
    outline-offset: 2px;
}
@media (max-width: 768px) {
    table {
        width: 100%;
        font-size: 12px;
    }
}

@media only print {
    .printbtn {
        display: none;
    }
}    </style>    
    
  </head>
    <body onload="fix()">
        <div class="printcnbutton_container"><button onclick="downloadPDF()" class="epc-button">Print</button><button onclick="frieghthide()" class="epc-button">Print By Hiding Freight</button>
        <button onclick="window.location.href='viewcn.php'" class="epc-button">Go Back</button>
        <!-- <button onclick="window.location.href='editcn.php?id=<?php echo $id; ?>'" class="epc-button">Edit CN</button> -->
    </div>
        <table class="cncontainer" width="710">
            <tr>
            <td class="logicnlogo" align="center" valign="top" colspan="1" style="height: 50px; width: 50px; border-right: none; white-space: nowrap;background-size: contain; background-repeat: no-repeat; background-position: center;">
                <img src="img/<?php echo htmlspecialchars($row_basic['companylogo']); ?>" alt="">        
        </td>
                <td align="center" valign="top" colspan="6" style="height: 50px; border-left: none; white-space: nowrap">
                <h1><?php echo ucwords($companyname001); ?></h1>
                <h7> <?php echo ucwords ($row_basic['company_address']) .'-' .ucwords ($row_basic['state'] .'-' .$row_basic['pincode'] )?></h7>
                    <br/>
                    <h7>Phone:<?php echo $row_basic['office_number'] ?></h7>
                    <h7 <?php if (empty($row_login['webiste_address'])) { echo 'style="display: none;"'; } ?>>Website: <?php echo htmlspecialchars($row_login['webiste_address']); ?> </h7>
                    <br/>
                    <h7 <?php if (mysqli_num_rows($result_registration) == 0) { echo 'style="display: none;"'; } ?>>PAN: <?php echo htmlspecialchars($row_regi['pancard_new']); ?> </h7>
                    <h7 <?php if (mysqli_num_rows($result_registration) == 0) { echo 'style="display: none;"'; } ?>>GST No: <?php echo htmlspecialchars($row_regi['gst_new']); ?> </h7>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div align="left" valign="top">
                    DELAY FEES <br/>
                        <div style="font-size:12px">Delay fees will be applied after 7 days from the date of arrival, at a rate of Rs 10/- per day per quintal based on the charged weight.</div>
                    </div>
                </td>
                <td colspan="2">
                    <div align="center" valign="top">
                        NOTICE <br/>
                        <div style="font-size:12px">The customer has stated that he has insured /not insured the consignment/lorry
                    </div>
                    </div>
                </td>
                <td colspan="2">
                    <div align="left">
                        <div align="center" style="font-display:block">AT OWNER'S RISK
                    </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="6">
                    <div align="left">
                        Source: <?php echo $row['booking_station'] ?> <br/>Destination : <?php echo $row['consignee_booking_station'] ?> <br> <mark> Vehicle Number :<?php echo $row['vehicle_reg'] ?></mark>
                        <br>WayBill :<?php echo $row['waybill'] ?><br>Waybill-Validity :<?php echo (new DateTime($row['waybill_validity']))->format('d-m-Y'); ?>
                
                    </div>
                </td>
            </tr>
            <tr>
                <td align="left" valign="top" colspan="4">
                    Consignor:<br/>
                    <?php echo $row['consignor'] ?> <br/>
                    <?php echo $row['consignor_address'] .' - ' . $row['consignor_state'] ?> <br/>
                    Concern Person: <?php echo $row['consignor_contactperson'] ?> <br/>
                    GST No: <?php echo $row['consignor_gst']  ?><br/>
                    <div>Invoice No: <?php echo $row['invoice_number'] ?> &nbsp
                    Date:<?php echo (new DateTime($row['invoice_date']))->format('d-m-Y'); ?>
                    </div>
                </td>
                <td align="center" valign="top" colspan="2">
                    <div>
                        <h2>Consignment Note</h2>
                        <h2><?php echo $row['cnnumber'] ?></h2>
                        <h5>Date:<?php echo (new DateTime($row['cndate']))->format('d-m-Y'); ?>
                        </h5>
                    </div>
                </td>
            </tr>
            <tr>
                <td align="left" valign="top" colspan="4">
                    Consignee:<br/>
                    <?php echo $row['consignee_name'] ?><br/>
                    <?php echo $row['consignee_address'] .' - ' . $row['consignee_state'] ?><br/>
                    Concern Person: <?php echo $row['consignee_contactperson'] ?><br/>
                    GST No: <?php echo $row['consignee_gst'] ?> <br/>
                    <hr style="color:orange;border:1px solid"/>
                    Value of Goods: <?php echo number_format($row['goods_value'], 0, '.', ','); ?> <br/>
                    </td>
                <td align="left" valign="top" colspan="2">
                    <div>Booking Branch: <?php echo ucwords ($row['branch']) ?></div>
                    <br><br><br>
                    <!-- <div>Branch Address :</div>
                    <div>Taloja Panvel Raigarh(MH) -410208 [MH]</div>
                    <div>Phone: 9372553643 </div>
                    <div>Email:arcllote@gmail.com</div> -->
                    <hr style="color:orange;border:1px solid"/>
                    <div class="row">
                        Delivery Type:<br/><?php echo $row['delivery_basis'] ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    No Of Pkg<br/><?php echo $row['no_of_package'] ?>
            
                </td>
                <td>
                    Actual Wt:<br/><?php echo $row['actual_weight'] ?>
            
                </td>
                <td>
                    Charged Wt<br/><?php echo $row['charge_weight'] ?>
            
                </td>
                <td>
                    Rate/kg<br/><?php echo (($row['freight']+$row['taxes'])/$row['charge_weight']) ?>
            
                </td>
                <td>
                    Load Type :<br/>
            
                </td>
                <td>
                <?php echo $row['load_type'] ?><br/>
                </td>
            </tr>
            <tr>
                <td align="left" valign="top" colspan="4" rowspan="2">
                    Load Description:
                    <?php echo ucwords($row['load_desc']) ?>
                    <br/>
                    <!-- Booking Note/Dimension of Goods:<br/> -->
                </td>
                <td id="freightinfo" align="center">Freight :
            </td>
                <td  align="center" class="frt" id="freightinfotwo"><?php echo number_format($row['freight'], 0, '.', ','); ?>
            </td>
            </tr>
            <tr>
                <td align="center">Taxes
            </td>
                <td align="center" class="frt"><?php echo $row['taxes'] ?>
            </td>
            </tr>
            <tr>
                <td align="left" colspan="4" rowspan="2">
                    GST Paid By: <?php echo $row['gst'] ?> <br/>Billing Basis:  <?php echo $row['billing_basis'] ?>
                <!-- Billing Branch: TALOJA -->
            
                </td>
                <td align="center">Total
            </td>
                <td align="center" class="frt"><?php echo ($row['freight']+$row['taxes']); ?>
            </td>
            </tr>
            <tr>
                <!-- <td align="center">MMC
            </td>
                <td align="center" class="frt">0
            </td> -->
            </tr>
            <tr>
                <td align="left" valign="top" colspan="4" rowspan="4">
                    Billing Party: <br/>
                    <?php echo $row['billing_party'] ?><br/>
                    <?php echo $row['billingparty_address'] ?> <br/>
                    Concern Person: <?php echo $row['billingparty_contactperson'] ?> <br/>
                    GST No: <?php echo $row['billingparty_gst'] ?>
            
                </td>
                <!-- <td align="center">DDC
            </td>
                <td align="center" class="frt">0
            </td> -->
            </tr>
            <tr>
                <!-- <td align="center">DCC
            </td>
                <td align="center" class="frt">0
            </td> -->
            </tr>
            <tr>
                <!-- <td align="center">ExHC
            </td>
                <td align="center" class="frt">0
            </td> -->
            </tr>
            <tr>
                <!-- <td align="center">ExLC
            </td>
                <td align="center" class="frt">0
            </td> -->
            </tr>
            <tr>
                <td align="left" valign="top" colspan="2" rowspan="4" style="font-size:small">
                    BANK DETAILS FOR FREIGHT CREDIT:<br/>
                    <?php if(isset($rowbank) && !empty($rowbank['name_on_cheque'])){ echo $rowbank['name_on_cheque'];} ?> <br/>
                    Account No: <?php if(isset($rowbank) && !empty($rowbank['account_num'])){ echo $rowbank['account_num'];} ?> <br/>
                    IFSC: <?php if(isset($rowbank) && !empty($rowbank['ifsc_code'])){ echo $rowbank['ifsc_code'];} ?> <br/>
                    Bank Name: <?php if(isset($rowbank) && !empty($rowbank['bank_name'])){ echo $rowbank['bank_name'];} ?> <br/>Bank Branch: <?php if(isset($rowbank) && !empty($rowbank['branch'])){ echo $rowbank['branch'];} ?>




            
                </td>
                <td align="left" valign="top" colspan="2" rowspan="4" style="font-weight:bold; text-align:center;vertical-align:top">
                    <small>For <?php echo ucwords($row['companyname']) ?></small>
                    <br/>
                    <br/>
                    <span class="text-center" style="font-style:italic;font-weight:normal;font-size:small">
                        <small>(This is a computer-generated document. Signature is not mandatory)</small>
                    </span>

                </td>

                <!-- <td align="center">ST/OC
            </td> -->
                <!-- <td align="center" class="frt">0
            </td> -->
            </tr>
            <tr>
                <!-- <td align="center">TFrt
            </td>
                <td align="center" class="frt">62000
            </td> -->
            </tr>
            <tr>
                <!-- <td align="center">Taxes
            </td>
                <td align="center" class="frt">0
            </td> -->
            </tr>
            <tr>
                <!-- <td align="center">GFrt
            </td>
                <td align="center" class="frt">62000
            </td> -->
            </tr>
        </table>
    </body>
    <script>
 function fix() {
                $(window).resizeBy(250, 250);
                $(window).focus();
            }
        function downloadPDF() {
    const element = document.querySelector('.cncontainer');

    html2pdf(element, {
        margin: 0.2, // Adjust the margin as needed
        filename: '<?php echo $row['cnnumber'] . ' ' . $row['consignor'] . '-' . $row['booking_station'] . '.pdf';
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

function frieghthide(){
    const freightinfo = document.getElementById('freightinfo');
    const freightinfo_two = document.getElementById('freightinfotwo');
    const element = document.querySelector('.cncontainer');

    freightinfo.style.display="none";
    freightinfo_two.style.display="none";

    html2pdf(element, {
        margin: 0.2, // Adjust the margin as needed
        filename: '<?php echo $row['cnnumber'] . ' ' . $row['consignor'] . '-' . $row['booking_station'] . '.pdf';
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
