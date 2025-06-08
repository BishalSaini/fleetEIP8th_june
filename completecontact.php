<?php
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
$editid=$_GET['id'];
$clientid=$_GET['clientid'];
include "partials/_dbconnect.php";
$sql="SELECT * FROM `rentalclients` where id='$editid'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);

if($_SERVER['REQUEST_METHOD']==='POST'){
    include "partials/_dbconnect.php";
    $contact_person=$_POST['contact_person'];
    $designation=$_POST['designation'];
    $contact=$_POST['contact'];
    $email=$_POST['email'];
    $officetype=$_POST['officetype'];
    $associated_regionaloffice=$_POST['associated_regionaloffice'] ?? null;
    $associated_siteoffice=$_POST['associated_siteoffice'] ?? null;
    $editidinput=$_POST['editid'];
    $clientidinput=$_POST['clientid'];

    $edit="UPDATE `rentalclients` SET 
    `address_type`='$officetype',`contact_person`='$contact_person',
    `designation`='$designation',`contact_number`='$contact',`contact_email`='$email',
    `associated_regoffice`='$associated_regionaloffice',
    `associate_site`='$associated_siteoffice' WHERE id='$editidinput'";
    $editresult=mysqli_query($conn,$edit);
    if($editresult){
        $_SESSION['success']='success';
        header("Location:rentalclientdetail.php?id=". urldecode($clientidinput));
    }
    else{
        $_SESSION['error']='success';
        header("Location:rentalclientdetail.php?id=". urldecode($clientidinput));

    }


}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <title>Complete Contact</title>
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
<form action="completecontact.php" method="POST" autocomplete="off" class="completeuser">
    <div class="completeusercontainer">
        <p class="headingpara">Complete Contact </p>
        <input type="hidden" name="editid" value="<?php echo $editid ?>">
        <input type="hidden" name="clientid" value="<?php echo $clientid ?>">
        <div class="outer02">
        <div class="trial1">
            <input type="text" placeholder="" name="contact_person" value="<?php echo $row['contact_person'] ?>" class="input02">
            <label for="" class="placeholder2">Name</label>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" name="designation" value="<?php echo $row['designation'] ?>" class="input02">
            <label for="" class="placeholder2">Designation</label>
        </div>


        </div>
        <div class="outer02">
        <div class="trial1">
            <input type="text" placeholder="" name="contact" value="<?php echo $row['contact_number'] ?>" class="input02">
            <label for="" class="placeholder2">Contact</label>
        </div>
        <div class="trial1">
            <input type="text" placeholder="" name="email" value="<?php echo $row['contact_email'] ?>" class="input02">
            <label for="" class="placeholder2">Email</label>
        </div>


        </div>
        <div class="outer02">
        <select name="officetype" id="office_typenew" class="input02" onchange="officetypedd()">
                <option value=""disabled selected>Office Type</option>
                <option value="HQ">HQ</option>
                <option value="Site Office">Site Office</option>
                <option value="Regional Office">Regional Office</option>
            </select>
            <?php 
        $sqlreg_office="SELECT * FROM `regional_office` where companyname='$companyname001'";
        $regoffice_result=mysqli_query($conn,$sqlreg_office);

        $sqlsite_office="SELECT * FROM `site_office` where companyname='$companyname001'";
        $siteoffice_result=mysqli_query($conn,$sqlsite_office);

        ?>
        <div class="outer02" id="regandsitecontainerouter">
            <select name="associated_regionaloffice" id="regionaloffice" class="input02">
                <option value=""disabled selected>Select Regional Office</option>
                <?php if(mysqli_num_rows($regoffice_result)>0){
                    while($rowreg=mysqli_fetch_assoc($regoffice_result)){
                        ?>
                    <option value="<?php echo $rowreg['heading'] ?>"><?php echo $rowreg['heading'] ?></option>
                        <?php
                    }
                } ?>
            </select>
            <select name="associated_siteoffice" id="siteoffice" class="input02">
                <option value=""disabled selected>Select  Site Office</option>
                <?php if(mysqli_num_rows($siteoffice_result)>0){
                    while($rowsite=mysqli_fetch_assoc($siteoffice_result)){
                        ?>
                    <option value="<?php echo $rowsite['heading'] ?>"><?php echo $rowsite['heading'] ?></option>
                        <?php
                    }
                } ?>

            </select>

        </div>
            </div>
        <button class="epc-button">Submit</button>
    </div>
</form>
    
</body>
<script>
    function officetypedd(){
    const office_typenew=document.getElementById("office_typenew");
    const regandsitecontainerouter=document.getElementById("regandsitecontainerouter");
    const siteoffice=document.getElementById("siteoffice");
    const regionaloffice=document.getElementById("regionaloffice");
    if(office_typenew.value==='Regional Office'){
        regandsitecontainerouter.style.display='flex';
        regionaloffice.style.display='block';
        siteoffice.style.display='none';

    }
    else if(office_typenew.value==='Site Office'){
        regandsitecontainerouter.style.display='flex';
        siteoffice.style.display='block';
        regionaloffice.style.display='none';


    }
    else{
        regandsitecontainerouter.style.display='none';
        siteoffice.style.display='none';
        regionaloffice.style.display='none';


    }
}

</script>
</html>