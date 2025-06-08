<?php
include "partials/_dbconnect.php";
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

$info=$_GET['id'];
$sql="SELECT * FROM `bill_generated` where id='$info'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);

$sql_logo_fetch="SELECT * FROM `complete_profile` where companyname='$companyname001'";
$result_fetch_logo=mysqli_query($conn , $sql_logo_fetch);
$row_logo_fetch=mysqli_fetch_assoc($result_fetch_logo);


$sql_client_info = "SELECT * FROM `billing_clients` WHERE `name` = '" . $row['bill_to_client'] . "' AND `added_by` = '$companyname001'";
$result_client_info1=mysqli_query($conn,$sql_client_info);
$row_client1=mysqli_fetch_assoc($result_client_info1);
$client_gst = substr($row_client1['gst'], 0, 2);

$sql_client_info2 = "SELECT * FROM `billing_clients` WHERE `name` = '" . $row['ship_to_client'] . "' AND `added_by` = '$companyname001'";
$result_client2=mysqli_query($conn , $sql_client_info2);
$row_client2=mysqli_fetch_assoc($result_client2);

$company_gst="SELECT * FROM `login` where companyname='$companyname001'";
$result_companygst=mysqli_query($conn , $company_gst);
$row_companygst=mysqli_fetch_assoc($result_companygst);
$company_gst_= substr($row_companygst['gst'], 0, 2);

$bank_detail="SELECT * FROM `complete_profile` where companyname='$companyname001'";
$result_bank=mysqli_query($conn , $bank_detail);
$bank_row=mysqli_fetch_assoc($result_bank);

$company_address="SELECT * FROM `login` where companyname='$companyname001'";
$result_company_address=mysqli_query($conn , $company_address);
$row_company_address=mysqli_fetch_assoc($result_company_address);

if($client_gst===$company_gst_){
    $igst=0;
    $sgst = 0.09; 
    $cgst = 0.09;
}
else{
    $igst=0.18;
    $sgst=0;
    $cgst=0;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">      <link rel="icon" href="favicon.jpg" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>


    <style>
        <?php include "style.css" ?>
    </style>
    <title>Document</title>
</head>
<body>
    <div class="bill_body">
    <div class="logo_contaier_bill"style="background-image: url('img/<?php echo ($row_logo_fetch['letter_head']); ?>');"></div>
    <!-- <div class="logo_container_bill" style="background-image: url('img/logo.jpg');"></div> -->

    <div class="tax_invoice">Tax Invoice</div>
    <div class="ref_date"><div class="ref">Ref.<?php echo $row['companyname'] .  "/" . " ". $row['id'] ?></div><div class="date">Date: <?php echo date('d-m-Y', strtotime($row['date'])); ?></div></div>
    <div class="bill_ship_to">
        <div class="bill_to_container">
            Buyer (Bill To)
            <p><a class="bankdetail" ><?php  echo $row['bill_to_client']?></a></p>
            <p><?php echo $row_client1['lane_address1'] ?></p>
            <p><?php echo $row_client1['lane_address2'] ?>  <?php echo $row_client1['pincode'] ?></p>
            <p>State: <?php echo $row_client1['state'] ?></p>
            <p>GST: <?php echo $row_client1['gst'] ?></p>
        </div>
        <div class="ship_to_container">
            Consignee (Ship To)
            <p><a class="bankdetail" ><?php  echo $row['ship_to_client']?></a></p>
            <p><?php echo $row_client2['lane_address1'] ?></p>
            <p><?php echo $row_client2['lane_address2'] ?>  <?php echo $row_client1['pincode'] ?></p>
            <p>State: <?php echo $row_client2['state'] ?></p>
            <p>GST: <?php echo $row_client2['gst'] ?></p>

        </div>
    </div>
    <table class="bill_detail">
        <th>Description of services</th>
        <th>SAC</th>
        <th>UoM</th>
        <th>Rate</th>
        <th>Qty</th>
        <th>Amount</th>
        <tr>
            <td><p>Being Rental charges of our <?php echo $row['asset_code_make'] ?> <?php echo $row['ac_model'] ?></p>
            <p>
    <?php echo $row['ac_sub_type']; ?>
    <?php if (!empty($row['reg_no'])): ?>
        Reg. <?php echo $row['reg_no']; ?>
    <?php endif; ?>
    for the month
</p>
                of <?php echo $row['billing_month'] ?> <?php echo date('d-m-Y', strtotime($row['start_date'])); ?> 
               to <?php echo date('d-m-Y', strtotime($row['end_date'])); ?></p>
            </td>
            <td><p><?php echo $row['sac'] ?></p></td>
            <td><p><?php echo $row['uom'] ?></p></td>
            <td><p><?php echo $row['rate'] ?></p></td>
            <td><p><?php echo $row['qty'] ?></p></td>
            <td><?php echo number_format($row['rate'] * $row['qty'], 2, '.', ','); ?></td>
            </tr>
    </table>
    <div class="total_basic_amount">
        <div class="total_heading"><p>Total basic Amount : <?php echo number_format($row['rate'] * $row['qty'], 2, '.', ','); ?></p></div>
        <!-- <div class="total_amount">3,76,845.99</div> -->
    </div> 
    <div class="tax_calculation">
        <div class="tax_heading">
            <p>IGST</p>
            <p>SGST</p>
            <p>CGST</p>
        </div>
        <div class="tax_percent">
            <p><?php echo $igst ?></p>
            <p><?php echo $sgst ?></p>
            <p><?php echo $cgst ?></p>
            <p>Total</p>
        </div>
        <div class="tax_amount">
        <p><?php echo number_format(($row['rate'] * $row['qty']) * $igst, 2, '.', ','); ?></p>
        <p><?php echo number_format(($row['rate'] * $row['qty']) * $sgst, 2, '.', ','); ?></p>
        <p><?php echo number_format(($row['rate'] * $row['qty']) * $cgst, 2, '.', ','); ?></p>
            <p><?php 
$total = ($row['rate'] * $row['qty']) + ($row['rate'] * $row['qty'] * 0.18);
echo number_format($total, 2, '.', ',');
?></p>
        </div>
    </div>   
    <table class="conclusion">
        <th>HSN/SAC</th>
        <th>Taxable Value</th>
        <th class="tax_head"><div class="tax1">Tax</div>
        <div class="rate_amount"><div class="percent1">Rate</div><div class="amnt">Amount</div></div>
        </th>
        <th>Total</th>
        <tr>
            <td><?php echo $row['sac'] ?></td>
            <td><?php echo number_format($row['rate'] * $row['qty'], 2, '.', ','); ?></td>
            <td class="split"><div class="1">18%</div><div class="2"><?php echo number_format($row['rate'] * $row['qty']*0.18, 2, '.', ','); ?></div></td>
            <td><?php 
$total = ($row['rate'] * $row['qty']) + ($row['rate'] * $row['qty'] * 0.18);
echo number_format($total, 2, '.', ',');
?></td>

        </tr>
    </table><br>
<div class="bankdetails">
    <div class="details">
        <p><p class="bankdetail">Bank Details:</p></p>
        <p><a class="bankdetail">Bank Name:</a><?php echo $bank_row['bank_name'] ?></p>
        <p><a class="bankdetail">Branch:</a><?php echo $bank_row['branch'] ?></p>
        <p><a class="bankdetail">Account Number:</a><?php echo $bank_row['account_num'] ?></p>
        <p><a class="bankdetail">IFSC Code:</a><?php echo $bank_row['ifsc_code'] ?></p>
    </div>
</div>
<br><br><br><br><br><br><br><br><br><br><br><br>
<p class="footer_bill"><?php echo $row_company_address['company_address'] . ' ' . $row_company_address['compnay_pincode']; ?></p>
</div>
<br><br><div class="button_container">
    <button class="print_quotation"  type="button" onclick="downloadPDF()">Download Bill</button>
    </div>

</body>

<script>
function downloadPDF() {
    const element = document.querySelector('.bill_body'); // Select the HTML element to be converted to PDF
    html2pdf(element, {
        margin:       0.3,
        filename: '<?php echo $row['bill_to_client'] ?> bill.pdf',
        image:        { type: 'jpeg', quality: 1.0 },
        html2canvas:  { dpi: 290, letterRendering: true },
        jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
    });
}


</script>

</html>