<?php 
session_start();
$companyname001=$_SESSION['companyname'];
$email=$_SESSION['email'];

include "partials/_dbconnect.php";
$cnid=$_GET['id'];
$sql="SELECT * FROM `cn` where id=$cnid";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);

$basic="SELECT * FROM `basic_details` where companyname='$companyname001'";
$resultbasic=mysqli_query($conn,$basic);
if(mysqli_num_rows($resultbasic)>0){
    $roww=mysqli_fetch_assoc($resultbasic);

}
else{
    $roww=array();
}

$regi_detail="SELECT * FROM `registration_details` where company_name='$companyname001'";
$result_regi=mysqli_query($conn,$regi_detail);
if(mysqli_num_rows($result_regi)>0){
    $rowregi=mysqli_fetch_assoc($result_regi);
}
?>
<!DOCTYPE html>

<html>
<head>
    <script>
        function fix() {
            window.resizeBy(250, 250);
            window.focus();
        }
    </script>
    <title>Challan</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>

    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
    <style>
 @media only print {
            .print {
                display: none;
            }
        } 
        body { 
            background: white;
        }
        table { 
            border-collapse: collapse;
    box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
    
    width: 100%;
    max-width: 900px;
    margin: 20px auto;
    font-size: 13.5px;
    overflow: hidden;
        }

        th, td {
            border: 2px solid black;
            padding: 7px; 
            text-align: justify;
        }  

        .printcentre { 
         display: flex; 
         align-items: center; 
         justify-content: center;
         margin-top:20px;
     
        }

        .printer {
    --border: #00104b;
    --background: #fff;
    cursor: pointer;
    width: 32px;
    height: 18px;
    position: relative;
    margin-right: 8px; /* Space between icon and text */
}

.printer:before, .printer:after {
  content: "";
  position: absolute;
  box-shadow: inset 0 0 0 2px var(--border);
  background: var(--background);
}

.printer:before {
  left: 0;
  right: 0;
  bottom: 0;
  height: 14px;
  border-radius: 3px;
  z-index: 2;
}

.printer:after {
  width: 26px;
  height: 6px;
  top: 0;
  left: 3px;
  border-radius: 3px 3px 0 0;
}

.printer .dot {
  width: 24px;
  height: 2px;
  border-radius: 1px;
  left: 4px;
  bottom: 4px;
  z-index: 4;
  position: absolute;
  background: var(--border);
}

.printer .dot:before, .printer .dot:after {
  content: "";
  position: absolute;
  background: var(--border);
  border-radius: 1px;
  height: 2px;
}

.printer .dot:before {
  width: 2px;
  right: 0;
  top: -5px;
}

.printer .dot:after {
  width: 4px;
  right: 3px;
  top: -5px;
}

.printer .paper {
  position: absolute;
  z-index: 1;
  width: 18px;
  height: 20px;
  border-radius: 2px;
  box-shadow: inset 0 0 0 2px var(--border);
  background: var(--background);
  left: 7px;
  bottom: 10px;
  display: flex;
  justify-content: center;
  transform: perspective(40px) translateY(0) rotateX(4deg) translateZ(0);
  -webkit-animation: paper 1.2s ease infinite;
  animation: paper 1.2s ease infinite;
  -webkit-animation-play-state: var(--state, running);
  animation-play-state: var(--state, running);
}

.printer .paper .svg {
  display: block;
  width: 8px;
  height: 8px;
  margin-top: 4px;
}

.printer .output {
  width: 32px;
  height: 24px;
  pointer-events: none;
  top: 13px;
  left: 0;
  z-index: 3;
  overflow: hidden;
  position: absolute;
}

.printer .output .paper-out {
  position: absolute;
  z-index: 1;
  width: 18px;
  height: 20px;
  border-radius: 2px;
  box-shadow: inset 0 0 0 2px var(--border);
  background: var(--background);
  left: 7px;
  bottom: 0;
  transform: perspective(40px) rotateX(40deg) translateY(-12px) translateZ(6px);
  -webkit-animation: paper-out 1.2s ease infinite;
  animation: paper-out 1.2s ease infinite;
  -webkit-animation-play-state: var(--state, running);
  animation-play-state: var(--state, running);
}

.printer .output .paper-out:before {
  content: "";
  position: absolute;
  left: 3px;
  top: 4px;
  right: 3px;
  height: 2px;
  border-radius: 1px;
  opacity: 0.5;
  background: var(--border);
  box-shadow: 0 3px 0 var(--border), 0 6px 0 var(--border);
}

.printer:not(:hover) {
  --state: paused;
}

@-webkit-keyframes paper {
  50% {
    transform: translateY(10px) translateZ(0);
  }
}

@keyframes paper {
  50% {
    transform: translateY(10px) translateZ(0);
  }
}

@-webkit-keyframes paper-out {
  50% {
    transform: perspective(40px) rotateX(30deg) translateY(-4px) translateZ(6px);
  }
}

@keyframes paper-out {
  50% {
    transform: perspective(40px) rotateX(30deg) translateY(-4px) translateZ(6px);
  }
}  


.printcentre a {
    text-decoration: none;
    color: #004a77;
    padding: 10px 20px;
    border: 1px solid #004a77;
    border-radius: 5px;
    margin: 0 5px;
    display: flex; /* Change to flex to align items horizontally */
    align-items: center; /* Center items vertically */
    transition: background-color 0.3s, color 0.3s;
}

.printcentre a:hover {
    background-color: #004a77;
    color: white;
}
.pointercursor{
    cursor: pointer;
}


.print-text {
    font-size: 14px; /* Adjust as needed */
    margin-left: 8px; /* Space between icon and text */
}


img { 
            height: 100px; 
            width: 100px;  
            border-radius: 50%;
            box-shadow: 5px 5px 5px #a0b3e5;
            transition: transform 0.6s ease;
        }  

        img:hover { 
            animation: rotate 0.6s forwards; 
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg) scale(1);
            }
            to {
                transform: rotate(360deg) scale(1.1);
            }
        }

        .heading { 
            text-align: center;
        } 

    </style>

</head>
<body onload="fix()">
<div class="print">
        <div class="printcentre">
            <a href="viewcn.php">Back to List</a>
            <!-- <a href="edit_challan.php?id=<?php echo $row['id']; ?>">Edit Challan</a> -->
            <a class="pointercursor" onclick="downloadPDF()">
                <div class="printer pointercursor">
                    <div class="paper pointercursor">
                        <svg viewBox="0 0 8 8" class="svg">
                            <path fill="#0077FF" d="M6.28951 1.3867C6.91292 0.809799 7.00842 0 7.00842 0C7.00842 0 6.45246 0.602112 5.54326 0.602112C4.82505 0.602112 4.27655 0.596787 4.07703 0.595012L3.99644 0.594302C1.94904 0.594302 0.290039 2.25224 0.290039 4.29715C0.290039 6.34206 1.94975 8 3.99644 8C6.04312 8 7.70284 6.34206 7.70284 4.29715C7.70347 3.73662 7.57647 3.18331 7.33147 2.67916C7.08647 2.17502 6.7299 1.73327 6.2888 1.38741L6.28951 1.3867ZM3.99679 6.532C2.76133 6.532 1.75875 5.53084 1.75875 4.29609C1.75875 3.06133 2.76097 2.06018 3.99679 2.06018C4.06423 2.06014 4.13163 2.06311 4.1988 2.06905L4.2414 2.07367C4.25028 2.07438 4.26057 2.0758 4.27406 2.07651C4.81533 2.1436 5.31342 2.40616 5.67465 2.81479C6.03589 3.22342 6.23536 3.74997 6.23554 4.29538C6.23554 5.53084 5.23439 6.532 3.9975 6.532H3.99679Z"></path>
                            <path fill="#0055BB" d="M6.756 1.82386C6.19293 2.09 5.58359 2.24445 4.96173 2.27864C4.74513 2.17453 4.51296 2.10653 4.27441 2.07734C4.4718 2.09225 5.16906 2.07947 5.90892 1.66374C6.04642 1.58672 6.1743 1.49364 6.28986 1.38647C6.45751 1.51849 6.61346 1.6647 6.756 1.8235V1.82386Z"></path>
                        </svg>
                    </div>
                    <div class="dot pointercursor"></div>
                    <div class="output pointercursor">
                        <div class="paper-out pointercursor"></div>
                    </div>
                </div>
                <span class="print-text pointercursor">Print Challan</span>
            </a>
        </div>
    </div>
    

    <table class="printchallanbutton" width="710">
        <tr style="border:1px" >
            <td  align="center" valign="top" colspan="3" style="height:50px;border-right:none">
                    <img src="img/<?php echo $roww['companylogo'] ?>" alt="">
            </td>
            <td align="center" valign="top" colspan="9" style="height:50px ;border-left:none ;white-space:nowrap">
                <h1 style="color: #004A77;"><?php echo ucwords ($row['companyname']) ?></h1>
                <h8 style="color: #004A77;"><?php echo $roww['company_address'] .' - '. $roww['state'].' - '. $roww['pincode'] ?></h8><br />
                <h8 style="color: #004A77;">Phone:<?php echo $roww['office_number'] ?>  &nbsp  - &nbsp  Email:<?php echo $email; ?></h8> &nbsp  - &nbsp 
<h8> Website: <?php echo $roww['website'] ?> </h8>     &nbsp  - &nbsp         <h8> PAN: <?php echo strtoupper($rowregi['pancard_new']); ?> </h8>
</td>
        </tr>
        <tr>
            <td class="heading" colspan="12" align="center" style="font-size:large;color: #004A77;">
                <strong>Lorry Hire Challan</strong>
            </td>

        </tr>
        <tr>
            <td colspan="2" align="center">
                <strong>CN :<?php echo ucwords( $row['cnnumber']) ?></strong>
            </td>
            <td colspan="3" align="center" style="white-space:nowrap">
                Date:
                <?php echo date('d-m-y', strtotime($row['cndate'])); ?>
                </td>
            <td colspan="2" align="center" style="white-space:nowrap">
                Type:
                Main
            </td>
            <td colspan="1" align="center" style="white-space:nowrap">
                Branch:
                <?php echo ucwords($row['branch']) ?>
            </td>
            <td colspan="1" align="center" style="white-space:nowrap">
                Challan Number:
                <?php echo $row['Challannumber'] ?>
            </td>
            <td colspan="2" align="center" style="white-space:nowrap">

            </td>
        </tr>

        <tr>
            <td colspan="12">
                <strong>From :</strong> <?php echo ucwords ($row['booking_station']) ?><br />
                <strong>To :</strong><?php echo ucwords ($row['consignee_booking_station']) ?>
            </td>
        </tr>
        <tr>
            <td colspan="6" style="text-align:center;color: #004A77;">
                <strong>Vehicle Details</strong>
            </td>

            <td colspan="6" style="text-align:center;color: #004A77;">
                <strong>Vehicle Details</strong>
            </td>
            <!-- <td colspan="3" style="text-align:center ;white-space:nowrap;color: #004A77;">
                <strong>Driver Details</strong>
            </td> -->

        </tr>
        <tr style="font-size:small">
            <td colspan="6" rowspan="2" style="text-align:left" valign="top" >
                <strong>Vehicle No : <?php echo $row['vehicle_reg'] ?></strong><br />
                <label>Source : <?php echo ucwords($row['vehicle_ownership']) ?></label><br />
                <label>Type : <?php echo ucwords($row['vehicle_type']) ?> </label><br />
                <label>Capcity : <?php echo ($row['capacity']) ?> kg</label> <br />
                                                                
            </td>

            <td colspan="6" style="text-align:left;vertical-align:top">
                <strong>Owner Name :  <?php echo ucwords($row['owner_name']) ?></strong><br />
                <label>Driver Name :  <?php echo ucwords($row['driver_name']) ?></label><br />
                <label>Driver Mobile : <?php echo ucwords($row['driver_mobile']) ?></label> <br />
                <label>Driver License : <?php echo ucwords($row['dl']) ?></label> <br />

            </td>
            <!-- <td colspan="3" style="text-align:left;vertical-align:top">
                <strong>Name : shamser singh</strong><br />
                <label>Mobile :  </label><br />
                <label>DL No : </label> <br />
                <label>Address : vashi navimumbai</label> <br />

            </td> -->


        </tr>
        <tr style="font-size:small">
            <td colspan="6" align="left" valign="top">
                <label><strong>Broker Company : </strong><?php echo ucwords($row['broker_name']) ?></label> <br />
                <label>Contact Person : <?php echo ucwords($row['brokercontactperson']) ?></label> <br />
                <label>Contact  : <?php echo ucwords($row['broker_mobile']) ?></label> <br />

            </td>

        </tr>

        <tr style="font-weight: bold; font-size:small;color: black; background-color: #a0b3e5;">
            <td>
                SNo
            </td>
            <td>
                CN
            </td>
            <td colspan="3">
                CN-Date
            </td>
            <td>

                Branch
            </td>
            <td>
                Package Count
            </td>
            <td>
                Actual Weight
            </td>
            <td>
                Unloading Type
            </td>
            <td colspan="3">
                Loading Remark
            </td>


        </tr>

            <tr style="font-size:small">
                <td rowspan="2">
                    1
                </td>
                <td>
                    <?php echo ucwords($row['cnnumber']) ?>
                </td>
                <td colspan="3" style="white-space:nowrap">
                <?php echo date('d-m-y', strtotime($row['cndate'])); ?>
                </td>
                <td>
                <?php echo ucwords($row['branch']) ?>
                </td>
                <td>
                <?php echo ucwords($row['no_of_package']) ?>

                </td>
                <td>
                <?php echo ucwords($row['actual_weight'])?> kg
                </td>

                <td>
                <?php echo ucwords($row['delivery_basis'])?> 

                </td>
                <td colspan="3">
                    <?php echo ucwords($row['remark']) ?>
            </tr>
            <tr>
                <!-- <td colspan="12" style="font-size:small">
                    <strong>From :</strong> <?php echo ucwords($row['booking_station']) ?> &nbsp &nbsp<strong>To :</strong> <?php echo ucwords ($row['consignee_booking_station']) ?>

                </td> -->
            </tr>
        <!-- <tr style="font-weight:bold ;font-size:small">
            <td colspan="6" align="center">
                Total
            </td>
            <td>
                1
            </td>
            <td>
                25000
            </td>
            <td colspan="4"></td>

        </tr> -->
        <!-- <tr>
            <td colspan="12" align="left" style="font-size:small">
                <strong>Note:</strong>  
            </td>

        </tr> -->
        <tr>
            <td colspan="7" align="center">
                <strong>Lorry Hire Details</strong>
            </td>
            <td colspan="5" align="center">
                <strong>Payment BreakUp</strong>
            </td>
        </tr>
        <tr style="font-size:small">
            <td colspan="4" align="center">
                <strong> Charged Weight</strong>
            </td>
            <td colspan="3" align="center">
                <strong><?php echo ucwords($row['charge_weight'])?> kg
                </strong>
            </td>
            <td colspan="3" align="center">
                <strong> Total Hire</strong> 
            </td>
            <td colspan="2" align="center">
                <strong>             <?php echo $row['total_hire'] ?>
                </strong>
               
            </td>
        </tr>
        <tr style="font-size:small">
            <td colspan="4" align="center">
            <strong>Lorry Hire</strong>
            </td>
            <td colspan="3" align="center">
                <?php echo ucwords($row['lorryhire']) ?>
            </td>
            <td colspan="3" align="center">
                Part Payment
            </td>
            <td colspan="2" align="center">
                <?php echo ucwords($row['advance']) ?>
            </td>
        </tr>
        <tr style="font-size:small">
            <td colspan="4" align="center">
            Loading Charges (+)
               
            </td>
            <td colspan="3" align="center">
            <?php echo $row['loading_charge'] ?>
               
            </td>
            <td colspan="3" align="center">
                <strong> Balance Payment</strong>
              
            </td>
            <td colspan="2" align="center">
                <strong> <?php echo $row['balance'] ?></strong>
               
            </td>
        </tr>
        <tr style="font-size:small">
            <td colspan="4" align="center">
            Extra Height (+)
            </td>
            <td colspan="3" align="center">
                <?php echo $row['height_charge'] ?>
            </td>
            <!-- <td colspan="5" rowspan="2" align="left" valign="top">
                <strong>Payment Remarks:</strong> 
            </td> -->
        </tr>
        <tr style="font-size:small">
            <td colspan="4" align="center">
            Extra Length(+)

            </td>
            <td colspan="3" align="center">
            <?php echo $row['length_charge'] ?>

            </td>

        </tr>
        <tr style="font-size:small">
            <td colspan="4" align="center">
            Detention(+) 
            </td>
            <td colspan="3" align="center">
                <?php echo $row['detention_charge'] ?>
            </td>
            <!-- <td colspan="5" align="center" valign="top">
                <strong>CheckList</strong>
            </td> -->
        </tr>
        <tr style="font-size:small">
            <td colspan="4" align="center">
            Misc(+)
            </td>
            <td colspan="3" align="center">
            <?php echo $row['misc_expense'] ?>
            </td>
            <!-- <td colspan="3" align="center" valign="top">
                Is RC of Vehicle Verified?
            </td> -->
            <!-- <td colspan="2" align="center" valign="top">
                No
            </td> -->
        </tr>
        <tr style="font-size:small">
            <td colspan="4" align="center">
            <strong> Total Lorry Hire</strong>

            </td>
            <td colspan="3" align="center">
            <?php echo $row['total_hire'] ?>
            </td>
            <!-- <td colspan="3" align="center" valign="top">
                Is PAN of Owner Verified ?
            </td>
            <td colspan="2" align="center" valign="top">
                No
            </td> -->
        </tr>
        <!-- <tr style="font-size:small">
            <td colspan="4" align="center">
               
            </td>
            <td colspan="3" align="center">
                <strong>  130000</strong>
               
            </td> -->
            <!-- <td colspan="3" align="center" valign="top">
                Is DL of Driver  Verified ?
            </td>
            <td colspan="2" align="center" valign="top">
                No
            </td> -->
        </tr>
        <tr style="font-size:small">
            <td colspan="12" align="center" class="heading">
                <strong>
                    Terms and Conditions
                </strong>
            </td>
        </tr>
        <tr>
            <td colspan="12" align="justify" style="font-size:x-small">
            •Delivery Schedule: Material must be delivered on or before the scheduled date and time.
            •Condition of Goods: Goods should be loaded in good condition. The lorry owner, driver, or broker is responsible for all risks and the safe delivery of the goods.
            •Weight Discrepancy: If the loaded weight is less than the charged weight or if additional material is loaded by the truck operator/agent, payment will be based solely on the actual loaded weight.
            •Important Note: The lorry challan is an internal document between Associated Road Cargo Logistics and the vehicle owner/driver/agent. In the event of loss due to the declaration or handover of the lorry challan to a third party, the driver/owner will be responsible for all losses, which will be recovered from the outstanding balance of the lorry.            </td>
        </tr>
        <tr>
            <td colspan="8" align="justify" style="font-size:small">
            •Tax Compliance: I will comply with the rules and regulations of the Income Tax Department concerning the payment of freight.
            •Contract Termination: The carriage contract will be automatically terminated upon delivery of the goods at the destination.
            •Agreement to Terms: We/I agree to all the terms and conditions outlined above.
            </td>
            <td colspan="4" rowspan="2" align="center" valign="top">
            For <?php echo ucwords ($row['companyname']) ?>            <br />
                    <br />
                    <br />
                    <span class="text-center" style="font-style:italic;font-weight:normal;font-size:small"><small>(This is a computer-generated document. Signature is not mandatory)</small></span>
            </td>
        </tr>
        <tr>
            <td colspan="4" align="center" valign="bottom" style="font-size:small">
                
                Broker/Agent
            </td>
            <td colspan="4" align="center" valign="bottom" style="font-size:small">
                Driver/Owner
            </td>
            
        </tr>


    </table>
</body>
<script>
            function downloadPDF() {
    const element = document.querySelector('.printchallanbutton');

    html2pdf(element, {
        margin: 0.2, // Adjust the margin as needed
        filename: '<?php echo $row['Challannumber'] . ' ' . $row['vehicle_reg'] .'.pdf';
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