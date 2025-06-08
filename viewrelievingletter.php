<?php 
$id=$_GET['id'];
include "partials/_dbconnect.php";
session_start();
$companyname001=$_SESSION['companyname'];
$data="SELECT * FROM `relieving_letters` where id=$id and companyname='$companyname001'";
$resultdata=mysqli_query($conn,$data);
$row=mysqli_fetch_assoc($resultdata);


$sql_logo_fetch="SELECT * FROM `basic_details` where companyname='$companyname001'";
$result_fetch_logo=mysqli_query($conn , $sql_logo_fetch);
$row_logo_fetch=mysqli_fetch_assoc($result_fetch_logo);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relieving Letter</title>
    <style>
                    .page-break {
                page-break-before: always; /* Forces a page break before the element */
                page-break-inside: avoid; /* Avoids breaking inside the element */
            }

            body {
    font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande',
                 'Lucida Sans Unicode', Arial, sans-serif;
    font-size: 14px;
    line-height: 1.6;
    background-color: #f4f4f4;
    margin: 20px;
}

    </style>

    <link rel="stylesheet" href="style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js" defer></script>

    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
</head>
<body>
<div class="fulllength">
        <button onclick="downloadsummary()" class="downloadbuttonsummary">Download</button>
        <button onclick="window.location.href='relievingletterdashboard.php'" class="gobackbuttonsummary">    <i class="bi bi-arrow-left"></i> Go Back
        </button>
    </div>
<div class="printrelievingletter">
<div class="logo_namecontainerofferletter">
        <div class="companylogoofferletter">
            <img src="img/<?php echo ($row_logo_fetch['companylogo']) ?>" alt="">
        </div>
        <div class="compname_"><span><?php echo $companyname001 ?></span> </div>
        </div>
        <hr>
        <p class="spaceinbetween">Date: <?php echo date('d-m-Y', strtotime($row['relievinglettergeneratedon'])); ?>  <span><strong>Ref No : </strong><?php echo $row['refno'] ?> </span></p>
        <div class="offerto">
            <p>To , <br><?php echo $row['fullname'] ?></p>
            <p><?php echo $row['to_address'] ?></p>
            <p id="offercontactemail">Email : <?php echo $row['contactemail'] ?></p>
            <p>Cell : <?php echo $row['contactnumber'] ?></p>

        </div>
        <br>
        <p><strong>Subject: </strong> Formal Relieving Letter for <?php echo $row['fullname'] ?> - [<?php echo ucwords ($row['jobrole']) ?>]</p>
        <br>
        <p>Dear <?php echo $row['fullname'] ?>,</p>
            <p class="mt10">This is to confirm that you were employed with <?php echo $companyname001 ?> as a <?php echo ucwords ($row['jobrole']) ?> in the <?php echo $row['department'] ?> department from <?php echo date('d-m-Y', strtotime( $row['joindate'])) ?> to <?php echo date('d-m-Y', strtotime( $row['relievingdate'])) ?></p>

            <p class="mt10">Your resignation dated <?php echo date('d-m-Y', strtotime($row['resignation_date'])) ?> has been reviewed and accepted , Consequently, you have been officially relieved of your duties and responsibilities as of <?php echo date('d-m-Y', strtotime( $row['relievingdate'])) ?></p>
            <p class="mt10">We appreciate the contributions you have made to <?php echo $companyname001 ?> and acknowledge your hard work and dedication. All your dues have been cleared as per company policy, and you are no longer associated with <?php echo $companyname001 ?> from the above-mentioned date.</p>
            <p class="mt10 <?php if(empty($row['notes'])){echo 'hidden';} ?>"><?php echo $row['notes'] ?></p>
            <p class="mt10">All dues, including any outstanding payments, benefits, and entitlements, will be cleared in accordance with the company’s policies and procedures. You will receive the final settlement as per the terms outlined in the employee agreement, and any necessary documentation will be provided accordingly.</p>
            <p class="mt10">If you need any further clarification or documents, please feel free to contact us. <br>We wish you all the best in your future endeavors.</p>
            <br>
            <p class="mt10">Sincerely,</p>
            <p><?php echo $row['sendersname'] ?></p>
            <p><?php echo $row['designation'] ?></p>
            <p><?php echo $row['companyname'] ?></p>
            <p><?php echo $row['sendersemail'] ?></p>

</div>
</body>
<script>
    function downloadsummary() {
        const element = document.querySelector('.printrelievingletter');

        html2pdf(element, {
            margin: [0.2, 0.2, 0.2, 0.2], 
            filename: '<?php echo $row['fullname'] .' Relieving letter'. '.pdf'; ?>',
            image: { type: 'jpeg', quality: 1.0 },
            html2canvas: { 
                dpi: 400, 
                letterRendering: true, 
                scale: 4, 
                useCORS: true 
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