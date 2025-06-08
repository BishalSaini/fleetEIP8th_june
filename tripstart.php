<?php 
session_start();
$showAlert=false;
$showError=false;
include "partials/_dbconnect.php";
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

$sql="SELECT * FROM `clients_logi` where companyname='$companyname001'";
$result=mysqli_query($conn,$sql);


$sql_max_ref_no = "SELECT MAX(tripid) AS max_ref_no FROM `triplogi` WHERE companyname = '$companyname001'";
$result_max_ref_no = mysqli_query($conn, $sql_max_ref_no);
$row_max_ref_no = mysqli_fetch_assoc($result_max_ref_no);
$next_ref_no = ($row_max_ref_no['max_ref_no'] === null) ? 1 : $row_max_ref_no['max_ref_no'] + 1;


$partyname="";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form values
    include "partials/_dbconnect.php";
    $consignor = $_POST['consignor'];
    $new_client_name=$_POST['new_client_name'] ?? '';
    $address = $_POST['address'];
    $contactperson_consignor = $_POST['contactperson_consignor'];
    $consignor_contactperson_number = $_POST['consignor_contactperson_number'];
    $contactemail_consignor = $_POST['contactemail_consignor'];
    $po_no = $_POST['po_no'];
    $po_date = $_POST['po_date'];
    $source = $_POST['source'];
    $destination = $_POST['destination'];
    $truck_date = $_POST['truck_date'];
    $freight_charges = $_POST['freight_charges'];
    $detention = $_POST['detention'] ?? '';
    $payment_terms = $_POST['payment_terms'];
    $tripid = $_POST['tripid'];

    if(isset($_POST['consignor']) && $_POST['consignor'] !='New Client'){
        $partyname=$_POST['consignor'];
    }
    else if(isset($_POST['new_client_name']) && !empty($_POST['new_client_name'])){
        $partyname=$_POST['new_client_name'];

    }
    if(isset($_POST['new_client_name']) && !empty($_POST['new_client_name'])){
        $sqllogiclient="INSERT INTO `clients_logi`( `client_name`, `address`, `contact_person1`,
         `companyname`, `contact_number1`, `contact_email1`)
          VALUES ('$partyname','$address','$contactperson_consignor','$companyname001','$consignor_contactperson_number','$contactemail_consignor')";
          $resultinsert=mysqli_query($conn,$sqllogiclient);


    }
    $sqlinsert = "INSERT INTO triplogi (
        consignor,
        address,
        contactperson_consignor,
        consignor_contactperson_number,
        contactemail_consignor,
        po_no,
        po_date,
        source,
        destination,
        truck_date,
        freight_charges,
        detention,
        payment_terms,
        companyname,
        tripid
    ) VALUES (
        '$partyname',
        '$address',
        '$contactperson_consignor',
        '$consignor_contactperson_number',
        '$contactemail_consignor',
        '$po_no',
        '$po_date',
        '$source',
        '$destination',
        '$truck_date',
        '$freight_charges',
        '$detention',
        '$payment_terms',
        '$companyname001',
        '$tripid'
    )";
    $resultinsert=mysqli_query($conn,$sqlinsert);
    if($resultinsert){
        $showAlert=true;
    }
    else{
       $showError=true;
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>

    <script src="logiclient.js"defer></script>
    <link rel="stylesheet" href="tiles.css">

    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
    <title>Trip Start</title>
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
    echo  '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert notice">
      <span class="alertClose">X</span>
      <span class="alertText_addfleet"><b>Success! </b>
          <br class="clear"/></span>
    </div>
  </label>';
}
if ($showError) {
    echo '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert error">
      <span class="alertClose">X</span>
      <span class="alertText">Something Went Wrong
          <br class="clear"/></span>
    </div>
  </label>';
}
?>


<div class="add_fleet_btn_new" id="tripsbuttoncontainer">
<button class="generate-btn"> 
    <article class="article-wrapper" onclick="window.location.href='viewtrips.php'" id="tripbtn"> 
  <div class="rounded-lg container-projectss ">
    </div>
    <div class="project-info">
      <div class="flex-pr">
        <div class="project-title text-nowrap">View Open Trips</div>
          <div class="project-hover">
            <svg style="color: black;" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" color="black" stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor"><line y2="12" x2="19" y1="12" x1="5"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </div>
          </div>
          <div class="types">
        </div>
    </div>
</article>
    </button>

</div>

<form action="tripstart.php" method="POST" class="tripstart">
        <div class="tripstart_container">
            <p class="headingpara">Trip Manager</p>
            <div class="outer02" id="tripclientcontainer">
                <div class="trial1">
                    <input type="text" placeholder="" value="<?php echo $next_ref_no ?>" name="tripid" class="input02">
                    <label for="" class="placeholder2">Trip Id</label>
                </div>
                <select name="consignor" id="consignor" class="input02" onchange="newtripclient()">
                    <option value="" disabled selected>Select A Client</option>
                    <option value="New Client">New Client</option>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <option value="<?php echo $row['client_name'] ?>"><?php echo $row['client_name'] ?></option>
                        <?php }
                    }
                    ?>
                </select>
                <div class="trial1" id="newtripclientinput" style="display: none;">
                    <input type="text" name="new_client_name" placeholder="" class="input02">
                    <label for="new_client_name" class="placeholder2">Client Name</label>
                </div>
            </div>
            <input type="text" value="<?php echo $companyname001 ?>" id="logicompanyname" name="companyname" hidden>

            <div class="trial1">
                <textarea name="address" id="address" placeholder="" class="input02"></textarea>
                <label for="address" class="placeholder2">Address</label>
            </div>

            <div class="outer02">
                <div class="trial1">
                    <input type="text" name="contactperson_consignor" id="contactperson_consignor" placeholder="" class="input02">
                    <label for="contactperson_consignor" class="placeholder2">Contact Person</label>
                </div>
                <div class="trial1">
                    <input type="text" name="consignor_contactperson_number" id="consignor_contactperson_number" placeholder="" class="input02">
                    <label for="consignor_contactperson_number" class="placeholder2">Number</label>
                </div>
                <div class="trial1">
                    <input type="text" name="contactemail_consignor" id="contactemail_consignor" placeholder="" class="input02">
                    <label for="contactemail_consignor" class="placeholder2">Email</label>
                </div>
            </div>  

            <div class="outer02">
                <div class="trial1">
                    <input type="text" name="po_no" placeholder="" class="input02">
                    <label for="po_no" class="placeholder2">PO NO</label>
                </div>
                <div class="trial1">
                    <input type="date" name="po_date" placeholder="" class="input02">
                    <label for="po_date" class="placeholder2">PO Date</label>
                </div>
                <div class="trial1">
                    <input type="text" name="source" placeholder="" class="input02">
                    <label for="source" class="placeholder2">Source</label>
                </div>
                <div class="trial1">
                    <input type="text" name="destination" placeholder="" class="input02">
                    <label for="destination" class="placeholder2">Destination</label>
                </div>
            </div> 

            <div class="trial1">
                <input type="date" name="truck_date" placeholder="" class="input02">
                <label for="truck_date" class="placeholder2">Truck To Be Placed On?</label>
            </div> 

            <div class="outer02">
                <div class="trial1">
                    <input type="text" name="freight_charges" placeholder="" class="input02">
                    <label for="freight_charges" class="placeholder2">Freight Charges</label>
                </div>
                <div class="trial1">
                    <input type="text" name="detention" placeholder="" class="input02">
                    <label for="detention" class="placeholder2">Detention/Day</label>
                </div>
                <div class="trial1">
                    <select name="payment_terms" class="input02">
                        <option value="" disabled selected>Payment Terms</option>
                        <option value="Advance">Advance</option>
                        <option value="15 Days Credit">15 Days Credit</option>
                        <option value="30 Days Credit">30 Days Credit</option>
                        <option value="45 Days Credit">45 Days Credit</option>
                        <option value="60 Days Credit">60 Days Credit</option>
                    </select>
                </div>
            </div>

            <button class="epc-button" type="submit">Submit</button>      
        </div>
    </form>
</body>
<script>
    function newtripclient(){
        const selecttripclient=document.getElementById("consignor");
        const newtripclientinput=document.getElementById("newtripclientinput");
        const tripclientcontainer=document.getElementById("tripclientcontainer");

        if(selecttripclient.value ==='New Client'){
            selecttripclient.style.display='none';
            newtripclientinput.style.display='flex';
        }

    }
</script>
</html>