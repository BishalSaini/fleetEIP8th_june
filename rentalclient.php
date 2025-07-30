<?php 
session_start();
$showAlert=false;
$showError=false;
$showErrorexist=false;

$email1=$_SESSION['email'];
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


if(isset($_SESSION['success'])){
    $showAlert=true;
    unset($_SESSION['success']);
}
else if(isset($_SESSION['error'])){
    $showError=true;
    unset($_SESSION['error']);
}
else if(isset($_SESSION['exist'])){
    $showErrorexist=true;
    unset($_SESSION['exist']);
}

include "partials/_dbconnect.php";
$clientlist = "SELECT * FROM `fleeteip_clientlist` ORDER BY name ASC";
$resultclient = mysqli_query($conn, $clientlist);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include "partials/_dbconnect.php";
    
    // Get POST data
    // $clientname = $_POST['clientname'];

    $clientname = '';
    if($_POST['clientname'] !='New' && empty($_POST['newclientname'])){
        $clientname=$_POST['clientname'];
    }
    else if($_POST['clientname'] =='New' && !empty($_POST['newclientname'])){
        $clientname=$_POST['newclientname'];

    }

    $clientaddress = $_POST['clientaddress'];
    $contact_person = $_POST['contact_person'];
    $contact_number = $_POST['contact_number'];
    $contact_email = $_POST['contact_email'];
    $designation = $_POST['designation'];
    $vendor_code = $_POST['vendor_code'];
    $handled_by = $_POST['handled_by'];
    $clientstate = $_POST['clientstate'];
    $type=$_POST['type'];
    $website=$_POST['website'];

    $gst=$_POST['gst'];
    $payment_terms=$_POST['payment_terms'] ?? '';
    $adv_payment=$_POST['adv_payment'] ?? '';
    // $credit_terms=$_POST['credit_terms'] ?? '';
    $working_days=$_POST['working_days'] ?? '';
    $engine_hours=$_POST['engine_hours'] ?? '';



    // Check if client already exists
    $sqlclientexist = "SELECT * FROM `rentalclient_basicdetail` WHERE clientname='$clientname' AND companyname='$companyname001'";
    $resultexist = mysqli_query($conn, $sqlclientexist);
    
    if (mysqli_num_rows($resultexist) > 0) {
        $_SESSION['exist'] = 'success';
        header("Location:rentalclient.php");
        exit();
    }

    if($clientname==$_POST['newclientname']){
        $newlist="INSERT INTO `fleeteip_clientlist`(`gst`,`payment_terms`,`adv_payment`,`working_days`,`engine_hours`,`name`, `hq`, `cell`, `state`, 
        `added_by`,`type`,`website`) VALUES ('$gst','$payment_terms','$adv_payment','$working_days','$engine_hours','$clientname','$clientaddress','$contact_number','$clientstate','$email1','$type','$website')";
        $newresult=mysqli_query($conn,$newlist);
    }

    // Insert into rentalclient_basicdetail
    $sqlcliententry = "INSERT INTO `rentalclient_basicdetail` (`working_days`,`engine_hours`,`gst`,`payment_terms`,`adv_payment`,`state`, `companyname`, `clientname`, `hqaddress`, `KAM`, `type`,`website`)
     VALUES ('$working_days','$engine_hours','$gst','$payment_terms','$adv_payment','$clientstate', '$companyname001', '$clientname', '$clientaddress', '$handled_by','$type','$website')";
    $sqlclientresult = mysqli_query($conn, $sqlcliententry);

    if ($sqlclientresult) {
        // Get the last inserted id
        $client_id = mysqli_insert_id($conn);

        // Insert into rentalclients
        $sql = "INSERT INTO `rentalclients` (`working_days`,`engine_hours`,`gst`,`payment_terms`,`adv_payment`,`clientid`, `designation`, `companyname`, `clientname`, `clientaddress`, `contact_person`, `contact_number`, `contact_email`, `vendor_code`, `handled_by`, `address_type`) VALUES ('$working_days','$engine_hours','$gst','$payment_terms','$adv_payment','$client_id', '$designation', '$companyname001', '$clientname', '$clientaddress', '$contact_person', '$contact_number', '$contact_email', '$vendor_code', '$handled_by', 'HQ')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $showAlert = true;
        } else {
            $showError = true;
        }
    } else {
        // Handle insertion error
        $showError = true;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
    <link rel="stylesheet" href="tiles.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>

    <script src="rentalclient_autofill.js"defer></script>
    <script src="main.js"></script>
    <title>Clients</title>
    <style>
        /* ...existing code... */
        #addClientForm {
            display: none;
            width: 100%;
            justify-content: center;
            align-items: center;
        }
        #addClientForm .rentalclientcontainer {
            margin: 0 auto;
            max-width: 600px;
        }
        /* Ensure form is centered on all screens */
        @media (min-width: 600px) {
            #addClientForm {
                display: none;
                display: flex;
            }
        }
    </style>
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
            <!-- <li><a href="contact_us.php">Contact Us</a></li> -->
            <li><a href="logout.php">Log Out</a></li></ul>
        </div>
    </div>
    <?php
if($showAlert){
    echo '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert notice">
        <span class="alertClose">X</span>
        <span class="alertText">Success<br class="clear"/></span>
    </div>
    </label>';
}
if($showError){
    echo '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert error">
        <span class="alertClose">X</span>
        <span class="alertText">Something Went Wrong<br class="clear"/></span>
    </div>
    </label>';
}
if($showErrorexist){
    echo '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert error">
        <span class="alertClose">X</span>
        <span class="alertText">Client Already Exist<br class="clear"/></span>
    </div>
    </label>';
}
?> 
<?php 
include "partials/_dbconnect.php";
$clientstats="SELECT KAM, COUNT(*) as client_count
FROM rentalclient_basicdetail
WHERE companyname = '$companyname001'
GROUP BY KAM";
$clientresult=mysqli_query($conn,$clientstats);
if(mysqli_num_rows($clientresult)>0){ ?>
<div class="clientsstats">
    <table class="clientsstatstable">
        <th>Name</th>
        <th>Client Handled</th>
        <?php
        while($rowwclient=mysqli_fetch_assoc($clientresult)){
            ?>
            <tr>
                <td><?php echo $rowwclient['KAM'] ?></td>
                <td><?php echo $rowwclient['client_count'] ?></td>
            </tr>
            <?php
        }
        ?>


    </table>
</div>


<?php
}
?>

    <!-- <div class="add_fleet_btn_new" id="rentalclientbutton" >
<button class="generate-btn"> 
    <article class="article-wrapper" onclick="window.location.href='viewrentalclient.php'" id="rentalclientbuttoncontainer"> 
  <div class="rounded-lg container-projectss ">
    </div>
    <div class="project-info">
      <div class="flex-pr">
        <div class="project-title text-nowrap">View Client</div>
          <div class="project-hover">
            <svg style="color: black;" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" color="black" stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor"><line y2="12" x2="19" y1="12" x1="5"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </div>
          </div>
          <div class="types">
        </div>
    </div>
</article>
    </button>

</div> -->

<!-- Add Client Button (top right) -->
<div style="display:flex;justify-content:flex-end;align-items:center;margin:32px 0 0 0;">
    <button class="generate-btn" id="showAddClientBtn" style="margin-right:32px;">
        <article class="article-wrapper">
            <div class="rounded-lg container-projectss"></div>
            <div class="project-info">
                <div class="flex-pr">
                    <div class="project-title text-nowrap">Add Client</div>
                    <div class="project-hover">
                        <svg style="color: black;" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" color="black" stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor">
                            <line y2="12" x2="19" y1="12" x1="5"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </div>
                </div>
                <div class="types"></div>
            </div>
        </article>
    </button>
</div>
<!-- End Add Client Button -->

<!-- Client Form (hidden by default) -->
<form action="rentalclient.php" method="POST" class="rentalclient" autocomplete="off" id="addClientForm" style="display:none;">
    <div class="rentalclientcontainer">
        <p class="headingpara">Add Client</p>
        <!-- <div class="outer02">
        <select name="clientname" id="fleeteipclientlist" onchange="enternewclient()" class="input02">
    <option value="" disabled selected>Select Client Name</option>
    <option value="Client Name Not In List">Client Name Not In List</option>
    <?php 
    while ($row1 = mysqli_fetch_assoc($resultclient)) { ?>
        <option value="<?php echo $row1['name']; ?>"><?php echo $row1['name']; ?></option>
    <?php } ?>
</select>

<div class="trial1" id="newclientinput" style="display: none;">
    <input type="text" placeholder="" name="newclientname" class="input02">
    <label for="" class="placeholder2">Add Client Name</label>
</div>

</div> -->
<div class="trial1" id="enterclientnamerentalclient">
    <input type="text" placeholder="" name="clientname" id="clientnameinput" onkeyup="filterclientoptions(this.value)" class="input02">
    <label for="" class="placeholder2">Enter Client Name</label>
    <select name="fleeteipclientlist" class="suggestions input02" size="3" id="enterclientnamedd" style="display:none;" onchange="selectOption(this); getclientdetail(this.value);">

    </select>


</div>
<div class="trial1" id="newcompanynamecontainer">
    <input type="text" placeholder="" name="newclientname" class="input02">
    <label for="" class="placeholder2">New Company Name</label>
</div>




        <input type="hidden" id="comp_name_trial" value="<?php echo $companyname001; ?>">
        <div class="trial1"> 
            <textarea type="text" placeholder="" id="hqaddressclient" name="clientaddress" class="input02"></textarea>
            <label for="" class="placeholder2">HQ Address</label>
        </div>
        <div class="outer02">
        <div class="trial1">
            <select name="clientstate" id="clientstate" class="input02">
            <option value="" disabled selected>Select State</option>
    <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
    <option value="Andhra Pradesh">Andhra Pradesh</option>
    <option value="Arunachal Pradesh">Arunachal Pradesh</option>
    <option value="Assam">Assam</option>
    <option value="Bihar">Bihar</option>
    <option value="Chandigarh">Chandigarh</option>
    <option value="Chhattisgarh">Chhattisgarh</option>
    <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and Daman and Diu</option>
    <option value="Delhi">Delhi</option>
    <option value="Goa">Goa</option>
    <option value="Gujarat">Gujarat</option>
    <option value="Haryana">Haryana</option>
    <option value="Himachal Pradesh">Himachal Pradesh</option>
    <option value="Jammu and Kashmir">Jammu and Kashmir</option>
    <option value="Jharkhand">Jharkhand</option>
    <option value="Karnataka">Karnataka</option>
    <option value="Kerala">Kerala</option>
    <option value="Ladakh">Ladakh</option>
    <option value="Lakshadweep">Lakshadweep</option>
    <option value="Madhya Pradesh">Madhya Pradesh</option>
    <option value="Maharashtra">Maharashtra</option>
    <option value="Manipur">Manipur</option>
    <option value="Meghalaya">Meghalaya</option>
    <option value="Mizoram">Mizoram</option>
    <option value="Nagaland">Nagaland</option>
    <option value="Odisha">Odisha</option>
    <option value="Puducherry">Puducherry</option>
    <option value="Punjab">Punjab</option>
    <option value="Rajasthan">Rajasthan</option>
    <option value="Sikkim">Sikkim</option>
    <option value="Tamil Nadu">Tamil Nadu</option>
    <option value="Telangana">Telangana</option>
    <option value="Tripura">Tripura</option>
    <option value="Uttar Pradesh">Uttar Pradesh</option>
    <option value="Uttarakhand">Uttarakhand</option>
    <option value="West Bengal">West Bengal</option>
</select>
            </select>
        </div>
        <select name="type" id="clienttype" class="input02">
            <option value="" disabled selected>Client Type</option>
                    <option value="EPC">EPC</option>
                    <option value="Rental">Rental</option>
                    <option value="Logistics">Logistics</option>
                    <option value="RMC Company">RMC Company</option>
                    <option value="Broker">Broker</option>
                    <option value="OEM">OEM</option>
        </select>

        </div>
        <div class="trial1">
            <input type="text" id="clientwebsite" placeholder="" name="website"  class="input02">
            <label for="" class="placeholder2">Client Website</label>
        </div>
        <div class="outer02">
        <div class="trial1">
            <input type="text" placeholder="" id="clientcontactperson" name="contact_person" class="input02">
            <label for="" class="placeholder2">Client Contact Person</label>
        </div>

            <div class="trial1">
                <input type="text" placeholder="" name="designation" class="input02">
                <label for="" class="placeholder2">Designation</label>
            </div>


        </div>
        <div class="outer02">
        <div class="trial1">
            <input type="text" placeholder="" name="contact_number" class="input02">
            <label for="" class="placeholder2">Contact Number</label>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" name="contact_email" class="input02">
            <label for="" class="placeholder2">Contact Email</label>
        </div>

        </div>
        <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" name="vendor_code" class="input02">
                <label for="" class="placeholder2">Vendor Code</label>
            </div>
            <?php 
            include "partials/_dbconnect.php";
            $sql_teammember="SELECT * FROM `team_members` where company_name='$companyname001' and department='marketing' or company_name='$companyname001' and department='Management' ";
            $result_teammember=mysqli_query($conn,$sql_teammember);
            // $row_teammember=mysqli_fetch_assoc($result_teammember);
            ?>
            <div class="trial1">
                <select name="handled_by" id="" class="input02" required>
                    <option value=""disabled selected>KAM</option>
                    <?php if(mysqli_num_rows($result_teammember)>0){
                        while($row_team=mysqli_fetch_assoc($result_teammember)){ ?>
                        <option value="<?php echo $row_team['name'] ?>"><?php echo $row_team['name'] ?></option>


                      <?php  }
                    } ?>
                </select>
            </div>
        </div>
        <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" id="gstnumber" name="gst" class="input02">
                <label for="" class="placeholder2">Gst Number</label>
            </div>
            <div class="trial1">
                <select name="adv_payment" id="" class="input02">
                    <option value=""disabled selected>Advance Payment</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </div>

            <select name="payment_terms" id="" class="input02">
                <option value=""disabled selected>Payment Terms</option>
                <option value="within 7 days Of invoice submission">within 7 Days Of invoice submission</option>
        <option value="within 10 days Of invoice submission">within 10 Days Of invoice submission</option>
        <option value="within 30 days Of invoice submission">within 30 Days Of invoice submission</option>
        <option value="within 45 days Of invoice submission">within 45 Days Of invoice submission</option>

            </select>
        </div>
        <div class="outer02">
        </div>
        <div class="outer02">
    <div class="trial1">
    <select name="working_days" id="" class="input02">
    <option value=""disabled selected>Select Working Days</option>
    <option value="26">26 Days</option>
    <option value="27">27 Days</option>
    <option value="28">28 Days</option>
    <option value="29">29 Days</option>
    <option value="30">30 Days</option>
</select>

    </div>
    <div class="trial1">
        <select name="engine_hours" id="" class="input02">
            <option value=""disabled selected>Select Engine Hours</option>
            <option value="200">200 Hours</option>
            <option value="208">208 Hours</option>
            <option value="260">260 Hours</option>
            <option value="270">270 Hours</option>
            <option value="280">280 Hours</option>
            <option value="300">300 Hours</option>
            <option value="312">312 Hours</option>
            <option value="360">360 Hours</option>
            <option value="400">400 Hours</option>
            <option value="416">416 Hours</option>
            <option value="460">460 Hours</option>
            <option value="572">572 Hours</option>
            <option value="672">672 Hours</option>
            <option value="720">720 Hours</option>
        </select>
    </div>
</div>

<button type="submit" class="epc-button">Submit</button>
    </div>
</form>
<?php include "viewrentalclient.php" ?>
</body>
<script>

    const companyname=[
        <?php
    include "partials/_dbconnect.php";
    $sql = "SELECT * FROM `fleeteip_clientlist`";
    $resultclient = mysqli_query($conn, $sql);
    while ($rowclient = mysqli_fetch_array($resultclient)) {
        echo '"' . $rowclient['name'] . '",';
    }
    ?>

    ];

    function filterclientoptions(clientname)
    {
       const clientdd=document.getElementById("enterclientnamedd");
       clientdd.innerHTML="";

    //    const clientnameinput=document.getElementById("clientnameinput");
        const filteredCompanies= companyname.filter(company =>
            company.toLowerCase().includes(clientname.toLowerCase())
        );

        if(clientname.length >=2){
            if(filteredCompanies.length>0){
                clientdd.style.display='block';
                filteredCompanies.forEach(company =>{
                    const option =document.createElement("option");
                    option.value= company;
                    option.textContent = company;
                    clientdd.appendChild(option);


                })

            }
            else{
            clientdd.style.display='block';
            clientdd.innerHTML="<option value='New'>Add New Company </option>";
        }

        }
        else{
            clientdd.style.display="none";
        }
    }
    
    function selectOption(select){
        const clientnameinput=document.getElementById("clientnameinput");
        const clientdd=document.getElementById("enterclientnamedd");

        clientnameinput.value = select.value;
        clientdd.style.display='none';

        if(select.value==='New'){
            document.getElementById("newcompanynamecontainer").style.display='block';
            document.getElementById("newcompanynamecontainer").setAttribute('required','required')
            document.getElementById("enterclientnamerentalclient").style.display='none';
        }


    }

    function getclientdetail(name){
        fetch(`fetchfleeteipclientinfo.php?name=${name}`)   
        .then (response => response.json())
        .then (data => {
            document.getElementById("hqaddressclient").value = data?.hq || '';
            document.getElementById("clientstate").value = data?.state || '';
            document.getElementById("clienttype").value = data?.type || '';
            document.getElementById("clientwebsite").value = data?.website || '';
            document.getElementById("gstnumber").value = data?.gst || '';
        })
        .catch(() => {
            document.getElementById('hqaddressclient').value = '';
            document.getElementById('clientstate').value = '';
            document.getElementById('clienttype').value = '';
            document.getElementById('clientwebsite').value = '';
            document.getElementById('gstnumber').value = '';

        })

    }

    // Show form when Add Client button is clicked
    document.addEventListener('DOMContentLoaded', function() {
        var btn = document.getElementById('showAddClientBtn');
        var form = document.getElementById('addClientForm');
        if (btn && form) {
            btn.addEventListener('click', function() {
                form.style.display = form.style.display === 'none' ? 'block' : 'none';
            });
        }
    });
</script>
</html>