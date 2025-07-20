<?php 
session_start();
$enterprise=$_SESSION['enterprise'];

$showAlert=false;
$showError=false;
if(isset($_SESSION['success']))
{
    $showAlert=true;
    unset($_SESSION['success']);
}
else if (isset($_SESSION['error'])){
    $showError=true;
    unset($_SESSION['error']);
}


$clientid=$_GET['id'];

$companyname001 = $_SESSION['companyname'];
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
include "partials/_dbconnect.php";
$sql="SELECT * FROM `rentalclient_basicdetail` where id=$clientid";
$result=mysqli_query($conn,$sql);
if(mysqli_num_rows($result)>0){
    $row=mysqli_fetch_assoc($result);
}
else{
    $row=null;
}

$client_name = isset($row) && isset($row['clientname']) ? $row['clientname'] : null;
$hqcontactdetails = "SELECT * 
        FROM rentalclients 
        WHERE clientname = '$client_name' 
          AND companyname = '$companyname001' 
          AND address_type = 'HQ' 
          AND contact_person != ''
          AND status != 'left'
";

$hqdetailresult=mysqli_query($conn,$hqcontactdetails);

// $rowCommon = mysqli_fetch_assoc($hqdetailresult);

// echo $rowCommon['id'];

$regionalcontactdetails = "SELECT * FROM regional_office 
                     WHERE clientname='$client_name' 
                     AND companyname='$companyname001' AND clientid='$clientid'";

$regionaldetailresult=mysqli_query($conn,$regionalcontactdetails);

// $rowcommon=mysqli_fetch_assoc($regionaldetailresult);


$siteoffice="SELECT * FROM `site_office` where companyname='$companyname001' and clientname='$client_name' and clientid='$clientid'";
$result_siteoffice=mysqli_query($conn,$siteoffice);




if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['hqsubmit'])){
    include "partials/_dbconnect.php";
    $hqname=$_POST['hqname'];
    $hqdesignation=$_POST['hqdesignation'];
    $hqcontact=$_POST['hqcontact'];
    $hqemail=$_POST['hqemail'];
    $hqaddress=$_POST['hqaddress'];
    $clientidhq=$_POST['clientidhq'];

    $hq = "INSERT INTO `rentalclients` (
        `companyname`, `clientname`, `clientaddress`,
        `address_type`, `contact_person`, `designation`,
        `contact_number`, `contact_email`
    ) VALUES (
        '$companyname001', '".$row['clientname']."', '$hqaddress',
        'HQ', '$hqcontact', '$hqdesignation', '$hqcontact', '$hqemail'
    )";

    $hqresult = mysqli_query($conn, $hq);
    if ($hqresult) {
        echo 'success';
        header("Location: rentalclientdetail.php?id=" . urlencode($clientidhq));
        
        exit();
    } else {
        echo 'error';
        header("Location: rentalclientdetail.php?id=" . urlencode($clientidhq));

    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.0/font/bootstrap-icons.min.css">
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
    <title>Add Details</title>
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
?>
    <div class="clientbasicdetail">
        <h3  class="client_para">Client :<?php echo $row['clientname'] ?>
                        <a href="editclientbasicdetail.php?id=<?php echo $row['id'] ?>" id="editbasicdetailclient" title="Edit Client"><i style="width: 22px; height: 22px;" class="bi bi-pencil"></i></a>
                        </h3>
        <p>HQ Address :<?php echo $row['hqaddress'] ?></p>
        <p class="">KAM :<?php echo $row['KAM'] ?></p>
        <?php $displayStyle = (mysqli_num_rows($hqdetailresult) > 0) ? 'display:none;' : ''; ?>
        <div class="buttoncontainer"><button class="tripupdate_generatecn" style="<?php echo $displayStyle; ?>" onclick="hqcontactadd()">Add HQ Contact</button><button class="tripupdate_generatecn" onclick="createregionaloffice()">Create Regional Office</button>    
        <button class="tripupdate_generatecn" onclick="showsiteofficeform()">Create Site Office</button></div>

    </div>
    <form action="addsiteaddress.php" autocomplete="off" method="POST" class="createsiteoffice" id="siteaddressform">
        <div class="siteofficecontainer">
        <input type="hidden" name="clientname" value="<?php echo $row['clientname'] ?>">
            <input type="hidden" name="clientid" value="<?php echo $clientid?>">

            <p class="headingpara">Create Site Office</p>
        <div class="trial1">
                <input type="text" placeholder="" name="heading" class="input02">
                <label for="" class="placeholder2">Heading</label>
            </div>
            <div class="trial1">
                <textarea name="siteaddress" placeholder="" id="" class="input02"></textarea>
                <label for="" class="placeholder2">Site Address</label>
            </div>
            <div class="trial1">
                <select name="sitestate" id="" class="input02">
                <option value=""disabled selected>Select State</option>
    <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
    <option value="Andhra Pradesh">Andhra Pradesh</option>
    <option value="Arunachal Pradesh">Arunachal Pradesh</option>
    <option value="Assam">Assam</option>
    <option value="Bihar">Bihar</option>
    <option value="Chandigarh">Chandigarh</option>
    <option value="Chhattisgarh">Chhattisgarh</option>
    <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and Daman and Diu</option>
    <option value="Daman and Diu">Daman and Diu</option>
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
            <button class="epc-button" name="clientsubmit">Submit</button>


        </div>
    </form>
    <form action="createregionaloffice.php" autocomplete="off" method="POST" class="createregionaloffice" id="createregionalofficeform">
        <div class="createregionalofficecontainer">
            <p class="headingpara">Create Regional Office</p>
            <input type="hidden" name="clientname" value="<?php echo $row['clientname'] ?>">
            <input type="hidden" name="clientid" value="<?php echo $clientid?>">
            <div class="trial1">
                <input type="text" placeholder="" name="heading" class="input02">
                <label for="" class="placeholder2">Heading</label>
            </div>
            <div class="trial1">
                <textarea type="text" placeholder="" name="regionaloffice_address" class="input02"></textarea>
                <label for="" class="placeholder2">Address</label>
            </div>
            <div class="trial1">
            <select name="regional_office_state" id="" class="input02">
                    <option value=""disabled selected>Select State</option>
    <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
    <option value="Andhra Pradesh">Andhra Pradesh</option>
    <option value="Arunachal Pradesh">Arunachal Pradesh</option>
    <option value="Assam">Assam</option>
    <option value="Bihar">Bihar</option>
    <option value="Chandigarh">Chandigarh</option>
    <option value="Chhattisgarh">Chhattisgarh</option>
    <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and Daman and Diu</option>
    <option value="Daman and Diu">Daman and Diu</option>
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
            <button class="epc-button">Create</button>

        </div>
    </form>
    <form action="hqcontact.php" method="POST" autocomplete="off" class="hqcontact" id="hqcontactform">
        <div class="hqcontactcontainer">
            <p class="headingpara">HQ Contact Person</p>
            <input type="hidden" name="clientname" value="<?php echo $row['clientname'] ?>">
            <input type="hidden" name="clientidhq" value="<?php echo $clientid ?>">

            <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" name="hqname" class="input02">
                <label for="" class="placeholder2">Name</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="hqdesignation" class="input02">
                <label for="" class="placeholder2">Designation</label>
            </div>
            </div>
            <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" name="hqcontact" class="input02">
                <label for="" class="placeholder2">Contact Number</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="hqemail" class="input02">
                <label for="" class="placeholder2">Contact Email</label>
            </div>

            </div>
            <div class="trial1 hideit">
            <textarea name="hqaddress" id="" class="input02"><?php echo $row['hqaddress'] ?></textarea>
            <label for="" class="placeholder2">Address</label>

            </div>
            <button class="epc-button" name="hqsubmit">Submit</button>
        </div>
    </form>


<?php 
$sqlincomplete = "SELECT * FROM `rentalclients` WHERE address_type='' AND companyname='$companyname001' AND clientname='" . $row['clientname'] . "' AND status != 'left'";
$incompleteresult=mysqli_query($conn,$sqlincomplete);
if(mysqli_num_rows($incompleteresult)>0){ ?>
    <div class="incompleteclientcontact">
        <h3>Incomplete Contacts :</h3>
        <table class="incompletetable">
        <th>Name</th>
        <th>Designation</th>
        <th>Contact</th>
        <th>Email</th>
        <th>Office Type</th>
        <th>Action</th>

        <?php while($rowincom=mysqli_fetch_assoc($incompleteresult)){
            ?>
        <tr>
            <td><?php echo $rowincom['contact_person'] ?></td>
            <td><?php echo $rowincom['designation'] ?></td>
            <td><?php echo $rowincom['contact_number'] ?></td>
            <td><?php echo $rowincom['contact_email'] ?></td>
            <td><?php echo $rowincom['address_type'] ?></td>
            <td>                        <div class="actioniconcontainer">
                        <a href="completecontact.php?id=<?php echo $rowincom['id'] ?>&clientid=<?php echo $row['id'] ?>" title="Edit"><i style="width: 22px; height: 22px;" class="bi bi-pencil"></i></a>
                            <a href="deletehqcontactperson.php?id=<?php echo $rowincom['id'] ?>&clientid=<?php echo $row['id'] ?>" title="Delete"><i style="width: 22px; height: 22px;" class="bi bi-trash"></i></a>
                        </div>
</td>
        </tr>
            <?php
        } ?>
        </table>
        </div>

<?php   
}
?>
    
<?php
if (mysqli_num_rows($hqdetailresult) > 0) { ?>
    <br>
    <h3 class="contactheading">HQ Address : <?php echo ucwords ($row['hqaddress'] )?></h3> 
    <button class="tripupdate_generatecn" id="hqcontactbutton" onclick="hqcontactadd()">Add HQ Contact</button>
    <table class="hqdetailstable">
        <thead>
            <tr>
                <th>Name</th>
                <th>Designation</th>
                <th>Number</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($roww = mysqli_fetch_assoc($hqdetailresult)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($roww['contact_person']); ?></td>
                    <td><?php echo htmlspecialchars($roww['designation']); ?></td>
                    <td><?php echo htmlspecialchars($roww['contact_number']); ?></td>
                    <td><?php echo htmlspecialchars($roww['contact_email']); ?></td>
                    <td>
                        <div class="actioniconcontainer">
                        <a href="edithqcontactperson.php?id=<?php echo $roww['id'] ?>&clientid=<?php echo $row['id'] ?>" title="Edit"><i style="width: 22px; height: 22px;" class="bi bi-pencil"></i></a>
                            <a href="deletehqcontactperson.php?id=<?php echo $roww['id'] ?>&clientid=<?php echo $row['id'] ?>" title="Delete"><i style="width: 22px; height: 22px;" class="bi bi-trash"></i></a>
                            <a onclick="return confirmexit();" href="leftcompany.php?id=<?php echo $roww['id'] ?>&clientid=<?php echo $row['id'] ?>" title="Left the company"><i class="bi bi-person-x" style="width: 22px; height: 22px;"></i></a>
                            </div>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php
}
?>





<?php
if (mysqli_num_rows($regionaldetailresult) > 0) {
    while($rowreg=mysqli_fetch_assoc($regionaldetailresult)){
    ?>
    <br>
    <h3 class="contactheading">Regional Office : <?php echo $rowreg['heading'] ?>   
    <a href="editregionaloffice.php?id=<?php echo $rowreg['id'] ?>&clientid=<?php echo $row['id'] ?>" id="editregionalofficebutton" title="Edit Client"><i style="width: 22px; height: 22px;" class="bi bi-pencil"></i></a>
    </h3> 
    <!-- <h4><?php echo $rowreg['kam']; ?></h4>                       -->

    <h5 class="contactheading">
    <strong>Address: </strong><?php echo $rowreg['address'] . ' <mark>(KAM - ' . $rowreg['kam'] . ')</mark>'; ?>
</h5>        <button id="regionalofficebuttonaddmember" 
        class="tripupdate_generatecn" 
        onclick="regionalcontactadd('<?php echo $rowreg['heading']; ?>')">
    Add <?php echo $rowreg['heading']; ?> Regional Office Contact
</button>
<?php 
$regionalofficecontactdetails = "SELECT * FROM rentalclients 
WHERE clientname='$client_name' 
AND companyname='$companyname001' 
AND associated_regoffice='" . $rowreg['heading'] . "' AND status != 'left'";

$regionalofficedetailresult=mysqli_query($conn,$regionalofficecontactdetails);

if(mysqli_num_rows($regionalofficedetailresult)>0){ ?>
<table class="hqdetailstable">

    <th>Name</th>
    <th>Designation</th>
    <th>Number</th>
    <th>Email</th>
    <th>Action</th>
    <?php while($row_reg_contact=mysqli_fetch_assoc($regionalofficedetailresult)){         
        // echo $row_reg_contact['id'];
 ?>
        <tr>
            
            <td><?php echo $row_reg_contact['contact_person'] ?></td>
            <td><?php echo $row_reg_contact['designation'] ?></td>
            <td><?php echo $row_reg_contact['contact_number'] ?></td>
            <td><?php echo $row_reg_contact['contact_email'] ?></td>
            <td>
                        <div class="actioniconcontainer">
                        <a href="edit_siteoffice_contact.php?id=<?php echo $row_reg_contact['id'] ?>&clientid=<?php echo $row['id'] ?>" title="Edit"><i style="width: 22px; height: 22px;" class="bi bi-pencil"></i></a>
                            <a href="delete_regional_officecontact.php?id=<?php echo $row_reg_contact['id'] ?>&clientid=<?php echo $row['id'] ?>" title="Delete"><i style="width: 22px; height: 22px;" class="bi bi-trash"></i></a>
                            <a onclick="return confirmexit();" href="leftRegionalOffice.php?id=<?php echo $row_reg_contact['id'] ?>&clientid=<?php echo $row['id'] ?>" title="Left the company"><i class="bi bi-person-x" style="width: 22px; height: 22px;"></i></a>

                        </div>
                    </td>

        </tr>



  <?php  } ?>
</table>   



<?php
}


?>
<?php
    }
}
?>

<form action="regionalcontact.php" autocomplete="off" method="POST" class="hqcontact" id="regionalofficecontactperson">
        <div class="hqcontactcontainer">
            <p class="headingpara">Regional Office Contact Person</p>
            <input type="hidden" name="clientname" value="<?php echo $row['clientname'] ?>">
            <input type="hidden" name="clientidhq" value="<?php echo $clientid ?>">


            <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" name="regname" class="input02">
                <label for="" class="placeholder2">Name</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="regdestination" class="input02">
                <label for="" class="placeholder2">Designation</label>
            </div>

            </div>
            <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" name="regcontact" class="input02">
                <label for="" class="placeholder2">Contact Number</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="regemail" class="input02">
                <label for="" class="placeholder2">Contact Email</label>
            </div>

            </div>
            <input type="hidden" id="companyname" value="<?php echo $companyname001 ?>">
            <div class="trial1 hideit">
                <select name="associatedregoffice" id="associated_regional_office" class="input02">
                    <option value=""disabled selected>Select Associated Regional Office</option>
                </select>
            </div>
            <?php 
            include "partials/_dbconnect.php";
            $sql_teammember="SELECT * FROM `team_members` where company_name='$companyname001' and department='marketing' or company_name='$companyname001' and department='Management' ";
            $result_teammember=mysqli_query($conn,$sql_teammember);
            // $row_teammember=mysqli_fetch_assoc($result_teammember);
            ?>
            <!-- <div class="trial1">
                <select name="handled_by" id="" class="input02" required>
                    <option value=""disabled selected>KAM</option>
                    <?php if(mysqli_num_rows($result_teammember)>0){
                        while($row_team=mysqli_fetch_assoc($result_teammember)){ ?>
                        <option value="<?php echo $row_team['name'] ?>"><?php echo $row_team['name'] ?></option>


                      <?php  }
                    } ?>
                </select>
            </div> -->
            <?php 
            $regionalcontactdetails1 = "SELECT * FROM regional_office 
            WHERE clientname='$client_name' 
            AND companyname='$companyname001' AND clientid='$clientid'";

$regionaldetailresult1=mysqli_query($conn,$regionalcontactdetails1);


if (mysqli_num_rows($regionaldetailresult1) > 0) {
    $rowregkam= mysqli_fetch_assoc($regionaldetailresult1);
} 
?>            <div class="trial1 hideit">
                <input type="text" name="handled_by" required placeholder="" value="<?php echo $rowregkam['kam']; ?>" class="input02" readonly>
                <label for="" class="placeholder2">KAM</label>
            </div>
            <button class="epc-button" name="regionalsubmit">Submit</button>
        </div>
    </form>

    <?php
if (mysqli_num_rows($result_siteoffice) > 0) { 
    while ($row_site = mysqli_fetch_assoc($result_siteoffice)) {
?>
        <h3 class="contactheading">Site Office : <?php echo htmlspecialchars($row_site['heading']); ?>
        <a href="editsiteoffice.php?id=<?php echo $row_site['id'] ?>&clientid=<?php echo $row['id'] ?>" id="editregionalofficebutton" title="Edit Client"><i style="width: 22px; height: 22px;" class="bi bi-pencil"></i></a>
        </h3>
        <h5 class="contactheading"><strong>Address: </strong><?php echo htmlspecialchars($row_site['address']). ' <mark>(KAM - ' . (isset($row_site['KAM']) ? $row_site['KAM'] : '-') . ')</mark>'; ?></h5> 

        <button class="tripupdate_generatecn" id="hqcontactbutton" onclick="sitecontactadd('<?php echo ($row_site['heading']); ?>')">Add <?php echo ($row_site['heading']); ?> Site Contact</button>
        <?php
        $sql_site_contactperson="SELECT * FROM `rentalclients` where associate_site='" .$row_site['heading'] ."' and companyname='$companyname001' and clientname='$client_name' AND status != 'left'";
        $site_person_result=mysqli_query($conn,$sql_site_contactperson);
        if(mysqli_num_rows($site_person_result)>0){ ?>
            <table class="hqdetailstable">
            <th>Name</th>
            <th>Designation</th>
            <th>Number</th>
            <th>Email</th>
            <th>Action</th>
        <?php while($row_site_person=mysqli_fetch_assoc($site_person_result)){ ?>
                <tr>
                <td><?php echo $row_site_person['contact_person'] ?></td>
                <td><?php echo $row_site_person['designation'] ?></td>
                <td><?php echo $row_site_person['contact_number'] ?></td>
                <td><?php echo $row_site_person['contact_email'] ?></td>
                <td>
                        <div class="actioniconcontainer">
                        <a href="edit_siteoffice_contact.php?id=<?php echo $row_site_person['id'] ?>&clientid=<?php echo $row['id'] ?>" title="Edit"><i style="width: 22px; height: 22px;" class="bi bi-pencil"></i></a>
                            <a href="delete_site_officecontact.php?id=<?php echo $row_site_person['id'] ?>&clientid=<?php echo $row['id'] ?>" title="Delete"><i style="width: 22px; height: 22px;" class="bi bi-trash"></i></a>
                            <a onclick="return confirmexit();" href="leftcompany.php?id=<?php echo $row_site_person['id'] ?>&clientid=<?php echo $row['id'] ?>" title="Left the company"><i class="bi bi-person-x" style="width: 22px; height: 22px;"></i></a>

                        </div>
                    </td>

                </tr>



      <?php  } ?>   
        </table>
        <?php
        }
        ?>
<?php
    }
}
?>
        <form action="sitecontact.php" method="POST" autocomplete="off" class="hqcontact" id="sitecontactperson">
        <div class="hqcontactcontainer">
            <p class="headingpara">Site Contact Person</p>
            <input type="hidden" name="clientname" value="<?php echo $row['clientname'] ?>">
            <input type="hidden" name="clientidhq" value="<?php echo $clientid ?>">


            <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" name="sitename" class="input02">
                <label for="" class="placeholder2">Name</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="sitedestination" class="input02">
                <label for="" class="placeholder2">Designation</label>
            </div>

            </div>
            <div class="outer02">
            <div class="trial1">
                <input type="text" placeholder="" name="sitecontact" class="input02">
                <label for="" class="placeholder2">Contact Number</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="siteemail" class="input02">
                <label for="" class="placeholder2">Contact Email</label>
            </div>

            </div>

            <div class="trial1 hideit">
            <input type="text" name="associated_site" id="associated_site" class="input02" readonly>
            <label for="" class="placeholder2">Associate Site Office</label>
            </div>
            <button class="epc-button" name="sitesubmit">Submit</button>
        </div>
    </form>

    <?php 
   $left="SELECT * FROM `rentalclients` where companyname='$companyname001' and clientname='$client_name' AND status = 'left'";
   $resultleft=mysqli_query($conn,$left);
   // Fetch all client names for the dropdown
   $clientlist = [];
   $clientlist_query = mysqli_query($conn, "SELECT DISTINCT clientname FROM rentalclient_basicdetail WHERE companyname='$companyname001'");
   while($cl = mysqli_fetch_assoc($clientlist_query)) {
       $clientlist[] = $cl['clientname'];
   }
   if(mysqli_num_rows($resultleft)>0){ ?>
   <h3 id="exemployeeid" class="fulllength">Ex Employee`s</h3>
                <table class="hqdetailstable">
            <th>Name</th>
            <th>Office</th>
            <th>Designation</th>
            <th>Number</th>
            <th>Email</th>
            <th>Action</th>
        <?php while($rowleft=mysqli_fetch_assoc($resultleft)){ ?>
                <tr>
                <td><?php echo $rowleft['contact_person'] ?></td>
                <td><?php 
    echo $rowleft['address_type'] . '-';
    echo !empty($rowleft['associated_regoffice']) ? $rowleft['associated_regoffice'] : $rowleft['associate_site']; 
?></td>
                <td><?php echo $rowleft['designation'] ?></td>
                <td><?php echo $rowleft['contact_number'] ?></td>
                <td><?php echo $rowleft['contact_email'] ?></td>
                <td>
                        <div class="actioniconcontainer">
                        <a href="viewexemployee.php?id=<?php echo $rowleft['id'] ?>&clientid=<?php echo $row['id'] ?>" title="Edit"><i style="width: 22px; height: 22px;" class="bi bi-file-earmark-text"></i></a>
                            <a href="delete_site_officecontact.php?id=<?php echo $rowleft['id'] ?>&clientid=<?php echo $row['id'] ?>" title="Delete"><i style="width: 22px; height: 22px;" class="bi bi-trash"></i></a>
                            <a onclick="return confirmexit();" href="joinedagaincompany.php?id=<?php echo $rowleft['id'] ?>&clientid=<?php echo $row['id'] ?>" title="Joined the company again"><i class="bi bi-person-check" style="width: 22px; height: 22px;"></i></a>
                            <!-- Join Another Company Icon -->
                            <a href="javascript:void(0);" onclick="openJoinCompanyModal(<?php echo $rowleft['id']; ?>)" title="Join Another Company"><i class="bi bi-person-plus" style="width: 22px; height: 22px;"></i></a>
                        </div>
                </td>
                </tr>
      <?php  } ?>   
        </table>
  <?php }
    ?>
<!-- Modal for Join Another Company -->
<div id="joinCompanyModal" class="modal" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100vw; height:100vh; background:rgba(0,0,0,0.3); align-items:center; justify-content:center;">
  <div class="hqcontactcontainer" style="background:#fff; padding:32px 24px 24px 24px; border-radius:10px; min-width:320px; max-width:95vw; position:relative; box-shadow:0 2px 16px rgba(0,0,0,0.15); display:flex; flex-direction:column; gap:12px;">
    <form action="join_another_company.php" class="joinanothercompanyformouter" method="POST" id="joinCompanyForm" autocomplete="off" style="width:95%;">
      <p class="headingpara" style="margin-bottom:18px;">Join Another Company</p>
      <input type="hidden" name="ex_employee_id" id="modal_ex_employee_id">
      <input type="hidden" name="current_clientid" value="<?php echo $row['id']; ?>">
      <div class="trial1">
        <select name="new_clientname" id="modal_new_clientname" class="input02" required>
          <option value="" disabled selected>Select Client</option>
          <?php foreach($clientlist as $cname) { ?>
            <option value="<?php echo htmlspecialchars($cname); ?>"><?php echo htmlspecialchars($cname); ?></option>
          <?php } ?>
        </select>
        <label for="modal_new_clientname" class="placeholder2">Client Name</label>
      </div>
      <div style="display:flex; justify-content:center; gap:10px; margin-top:18px;">
        <button type="submit" class="epc-button" style="min-width:80px;">Join</button>
        <button type="button" onclick="closeJoinCompanyModal()" class="epc-button" style="background:#eee; color:#333; min-width:80px;">Cancel</button>
      </div>
    </form>
  </div>
</div>
</body>
<script>
        function confirmexit(){
        return confirm("By clicking 'OK', you are confirming that the user has left the firm and will be removed from the employee list.");
    }


    function hqcontactadd(){
        const hqcontactform=document.getElementById("hqcontactform");
        const regionalofficecontactperson=document.getElementById("regionalofficecontactperson");
        const sitecontactperson=document.getElementById("sitecontactperson");
        const createregionalofficeform=document.getElementById("createregionalofficeform");
        const siteaddressform=document.getElementById("siteaddressform");
        createregionalofficeform.style.display="none";
        sitecontactperson.style.display="none";
        hqcontactform.style.display="flex";
        regionalofficecontactperson.style.display="none";
        siteaddressform.style.display="none";
        

    }
    function regionalcontactadd(heading) {
    const hqcontactform = document.getElementById("hqcontactform");
    const regionalofficecontactperson = document.getElementById("regionalofficecontactperson");
    const sitecontactperson = document.getElementById("sitecontactperson");
    const createregionalofficeform = document.getElementById("createregionalofficeform");
    const siteaddressform = document.getElementById("siteaddressform");


    // Hide all forms
    createregionalofficeform.style.display = "none";
    hqcontactform.style.display = "none";
    sitecontactperson.style.display = "none";
    siteaddressform.style.display = "none";

    // Show the desired form
    regionalofficecontactperson.style.display = "flex";

    // Scroll to the displayed form
    regionalofficecontactperson.scrollIntoView({ behavior: 'smooth', block: 'start' });

    // Select the <select> element
    const selectElement = document.querySelector("select[name='associatedregoffice']");

    // Create a new <option> element
    const option = document.createElement("option");
    option.value = heading;
    option.text = heading;
    option.selected = true;

    // Clear existing options (excluding the first default option)
    selectElement.innerHTML = "<option value='' disabled selected>Select Associated Regional Office</option>";

    // Add the new option
    selectElement.appendChild(option);
}


function sitecontactadd(siteheading){
        const hqcontactform=document.getElementById("hqcontactform");
        const regionalofficecontactperson=document.getElementById("regionalofficecontactperson");
        const sitecontactperson=document.getElementById("sitecontactperson");
        const createregionalofficeform=document.getElementById("createregionalofficeform");
        const siteaddressform=document.getElementById("siteaddressform");
        var inputField = document.getElementById('associated_site');
        inputField.value = siteheading;

        createregionalofficeform.style.display="none";

        sitecontactperson.style.display="flex";
        regionalofficecontactperson.style.display="none";
        hqcontactform.style.display="none";
        siteaddressform.style.display="none";

        sitecontactperson.scrollIntoView({ behavior: 'smooth', block: 'start' });





    }
    function createregionaloffice(){
        const hqcontactform=document.getElementById("hqcontactform");
        const regionalofficecontactperson=document.getElementById("regionalofficecontactperson");
        const sitecontactperson=document.getElementById("sitecontactperson");
        const createregionalofficeform=document.getElementById("createregionalofficeform");
        const siteaddressform=document.getElementById("siteaddressform");

        sitecontactperson.style.display="none";
        regionalofficecontactperson.style.display="none";
        hqcontactform.style.display="none";
        createregionalofficeform.style.display="flex";
        siteaddressform.style.display="none";


    }
    
    function showsiteofficeform(){
        const hqcontactform=document.getElementById("hqcontactform");
        const regionalofficecontactperson=document.getElementById("regionalofficecontactperson");
        const sitecontactperson=document.getElementById("sitecontactperson");
        const createregionalofficeform=document.getElementById("createregionalofficeform");
        const siteaddressform=document.getElementById("siteaddressform");

        sitecontactperson.style.display="none";
        regionalofficecontactperson.style.display="none";
        hqcontactform.style.display="none";
        createregionalofficeform.style.display="none";
        siteaddressform.style.display="flex";

    }

    // Modal logic for Join Another Company
function openJoinCompanyModal(exEmployeeId) {
    document.getElementById('modal_ex_employee_id').value = exEmployeeId;
    clientInput.value = '';
    clientHiddenInput.value = '';
    clientDropdown.innerHTML = '';
    clientDropdown.style.display = 'none';
    document.getElementById('joinCompanyModal').style.display = 'flex';
}
function closeJoinCompanyModal() {
    document.getElementById('joinCompanyModal').style.display = 'none';
}
// Optional: Close modal when clicking outside the modal content
window.onclick = function(event) {
    var modal = document.getElementById('joinCompanyModal');
    if (event.target === modal) {
        closeJoinCompanyModal();
    }
}

// Client list for modal search
    var clientList = <?php echo json_encode($clientlist); ?>;

    // Modal search logic
    const clientInput = document.getElementById('clientSearchInput');
    const clientDropdown = document.getElementById('clientDropdown');
    const clientHiddenInput = document.getElementById('modal_new_clientname_hidden');

    clientInput.addEventListener('input', function() {
        const val = clientInput.value.trim().toLowerCase();
        clientDropdown.innerHTML = '';
        if (val.length === 0) {
            clientDropdown.style.display = 'none';
            clientHiddenInput.value = '';
            return;
        }
        const matches = clientList.filter(function(name) {
            return name.toLowerCase().includes(val);
        });
        if (matches.length === 0) {
            clientDropdown.style.display = 'none';
            clientHiddenInput.value = '';
            return;
        }
        matches.forEach(function(name) {
            const div = document.createElement('div');
            div.textContent = name;
            div.style.padding = '8px 12px';
            div.style.cursor = 'pointer';
            div.onmouseover = function() { div.style.background = '#f0f4ff'; };
            div.onmouseout = function() { div.style.background = '#fff'; };
            div.onclick = function() {
                clientInput.value = name;
                clientHiddenInput.value = name;
                clientDropdown.style.display = 'none';
            };
            clientDropdown.appendChild(div);
        });
        clientDropdown.style.display = 'block';
        clientHiddenInput.value = '';
    });

    // Hide dropdown on blur (with delay for click)
    clientInput.addEventListener('blur', function() {
        setTimeout(function() {
            clientDropdown.style.display = 'none';
        }, 150);
    });

    // On modal open, reset input
    function openJoinCompanyModal(exEmployeeId) {
        document.getElementById('modal_ex_employee_id').value = exEmployeeId;
        clientInput.value = '';
        clientHiddenInput.value = '';
        clientDropdown.innerHTML = '';
        clientDropdown.style.display = 'none';
        document.getElementById('joinCompanyModal').style.display = 'flex';
    }
</script>
</html>