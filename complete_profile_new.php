<?php
session_start();
$enterprise=$_SESSION['enterprise'];

$showAlert=false;
$showError=false;
$showErrordelete=false;
$showAlert_update=false;
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
include "partials/_dbconnect.php";
$sql="SELECT * FROM `login` where companyname='$companyname001'";
$result=mysqli_query($conn,$sql);
if($result){
$row=mysqli_fetch_assoc($result);

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

}
?>
<?php
$sql_basic="SELECT * FROM `basic_details` where companyname='$companyname001'";
$result_sql_basic=mysqli_query($conn , $sql_basic);
$row_sql_basic=mysqli_fetch_assoc($result_sql_basic);
?>
<?php 
if(isset($_SESSION['basic_detail_success'])){
    $showAlert_update=true;
    unset($_SESSION['basic_detail_success']);
}
?>
<?php 
if(isset($_SESSION['basic_detail_error'])){
    $showError=true;
    unset($_SESSION['basic_detail_error']);
}
?>

<?php 
if(isset($_SESSION['bank_update_done'])){
    $showAlert_update=true;
    unset($_SESSION['bank_update_done']);
}
?>

<?php 
if(isset($_SESSION['del_success'])){
    $showErrordelete=true;
    unset($_SESSION['del_success']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="main.js"></script>
    <title>Complete Profile</title>
    <style> 
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;700&display=swap');

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

/* body {
  font-family: 'Poppins', sans-serif;
  align-items: center;
  justify-content: center;
  background-color: #ADE5F9;
  min-height: 100vh;
} */
img {
  max-width: 90%;
  display: block;
}
ul {
  list-style: none;
}

/* Utilities */
.card::after,
.card img {
  border-radius: 50%;
  background-size: contain;
    background-repeat: no-repeat; /* Optional: Prevents background image from repeating */
    background-position: center; /* Optional: Centers the background image */}

.card,
.stats {
  display: flex;
}

.card {
  padding: 2.5rem 2rem;
  border-radius: 10px;
  background-color: rgba(255, 255, 255, .5);
  max-width: 500px;
  box-shadow: 0 0 30px rgba(0, 0, 0, .15);
  margin: 1rem;
  margin-left:50px;
  position: relative;
  transform-style: preserve-3d;
  overflow: hidden;
  background-color:#d7f2fc;

}
.card::before,
.card::after {
  content: '';
  position: absolute;
  z-index: -1;
  background-color:#d7f2fc;
}
.card::before {
  width: 100%;
  height: 100%;
  border: 1px solid #FFF;
  border-radius: 10px;
  top: -.7rem;
  left: -.7rem;
}
.card::after {
  height: 15rem;
  width: 19rem;
  background-color: #4172f5aa;
  top: -8rem;
  right: -8rem;
  box-shadow: 2rem 6rem 0 -3rem #FFF
}

.card img {
  width: 8rem;
  /* border:1px solid red; */
  height:100px;
  min-width: 80px;
  box-shadow: 0 0 0 5px #FFF;
}

.infos {
  margin-left: 1.5rem;
}

.name {
  margin-bottom: 1rem;
}
.name h2 {
  font-size: 1.3rem;
}
.name h4 {
  font-size: .8rem;
  color: #333
}

.text {
  font-size: .9rem;
  /* margin-bottom: 1rem; */
}

.stats {
  margin-bottom: 1rem;
}
.stats li {
  min-width: 5rem;
}
.stats li h3 {
  font-size: .99rem;
}
.stats li h4 {
  font-size: .75rem;
}

.links button {
  font-family: 'Poppins', sans-serif;
  min-width: 120px;
  padding: .5rem;
  border: 1px solid #222;
  border-radius: 5px;
  font-weight: bold;
  cursor: pointer;
  transition: all .25s linear;
}
.links .follow,
.links .view:hover {
  background-color: #222;
  color: #FFF;
}
.links .view,
.links .follow:hover{
  background-color: transparent;
  color: #222;
}
#add_on{
    margin-bottom:7px;
}

@media screen and (max-width: 450px) {
  .card {
    display: block;
  }
  .infos {
    margin-left: 0;
    margin-top: 1.5rem;
  }
  .links button {
    min-width: 100px;
  }
}

main{
    width: min(1200px, 90vw);
    margin: auto;
}
.slider{
    width: 100%;
    height:300px;
    /* height: var(--height); */
    overflow: hidden;
    mask-image: linear-gradient(
        to right,
        transparent,
        #000 10% 90%,
        transparent
    );
}
.info_para{
  /* border:1px solid red; */
}
.slider .list{
    display: flex;
    width: 100%;
    /* height:350px; */
    min-width: calc(var(--width) * var(--quantity));
    position: relative;
    /* border:1px solid red; */

}
.second_para{
  margin-top:-10px!important;
  word-wrap: break-word; /* Breaks long words and addresses */
  overflow-wrap: break-word;
}
.slider .list .item{
    width: var(--width);
    height: 250px; 
    box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
    padding:10px;
    border-radius:10px;
    display:flex;
    flex-direction:column;
    align-items:center;
    position: absolute;
    left: 100%;
    margin-top:20px;
    animation: autoRun 40s linear infinite;
    transition: filter 0.5s;
    animation-delay: calc( (30s / var(--quantity)) * (var(--position) - 1) )!important;
} 


.slider .list .item img {
    width: 70%;
    height: 50%;
    border-radius:50%;
    /* object-fit: 60% 100%; */
    /* border:1px solid black; */
} 


@keyframes autoRun{
    from{
        left: 100%;
    }to{
        left: calc(var(--width) * -1);
    }
}
.slider:hover .item {
    animation-play-state: paused!important;
    filter: grayscale(1);
}
.slider .item:hover{
    filter: grayscale(0);
}
.slider[reverse="true"] .item {
    animation: reversePlay 30s linear infinite;
}
.item p{
    padding:3px;
    width: 100%!important;
    text-align: left;
    margin-left:5px;
    font-size:13px;
}
@keyframes reversePlay{
    from{
        left: calc(var(--width) * -1);
    }to{
        left: 100%;
    }
} 


@keyframes autoRun{
    from{
        left: 100%;
    }to{
        left: calc(var(--width) * -1);
    }
}
.slider .item:hover{
    filter: grayscale(0);
}
@keyframes reversePlay{
    from{
        left: calc(var(--width) * -1);
    }to{
        left: 100%;
    }
}


    </style>
</head>
<body>
    <div class="navbar1">
    <div class="logo_fleet">
    <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='<?php echo $dashboard_url ?>'">
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
if($showAlert){
    echo  '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert notice">
      <span class="alertClose">X</span>
      <span class="alertText_addfleet"><b>Success! Details Have Been Added
          <br class="clear"/></span>
    </div>
  </label>';
 }
 if($showAlert_update){
    echo  '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert notice">
      <span class="alertClose">X</span>
      <span class="alertText_addfleet"><b>Success! Details Have Been Updated
          <br class="clear"/></span>
    </div>
  </label>';
 }


 if($showError){
    echo '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert error">
      <span class="alertClose">X</span>
      <span class="alertText">Something Went Wrong
          <br class="clear"/></span>
    </div>
  </label>';
 }
 if($showErrordelete){
    echo '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert error">
      <span class="alertClose">X</span>
      <span class="alertText">Record Deleted Successfully
          <br class="clear"/></span>
    </div>
  </label>';
 }

?>   

<?php 
$sql_basic_detail_info="SELECT * FROM `basic_details` where companyname='$companyname001'";
$result_basic_detail_info=mysqli_query($conn,$sql_basic_detail_info);
$row_basic_detail_info=mysqli_fetch_assoc($result_basic_detail_info);


$sql_management_team_info="SELECT * FROM `team_members` where company_name='$companyname001' and department='Management'";
$result_management_team=mysqli_query($conn,$sql_management_team_info);

$sql_team_member="SELECT * FROM `team_members` where company_name='$companyname001' and department !='Management'";
$result_team_member=mysqli_query($conn,$sql_team_member);

$sql_bank_details = "SELECT * FROM `complete_profile` WHERE companyname='$companyname001'";
$result_bank_detail = mysqli_query($conn, $sql_bank_details);

if (!$result_bank_detail) {
    die('Error: ' . mysqli_error($conn)); // Check for query execution error
}

$row_bank = mysqli_fetch_assoc($result_bank_detail);

// Now you can use $row_bank to access the fetched data
?>
<?php
// Check if $row_sql_basic exists (meaning a record with companyname=$companyname001 was found)
if (isset($row_sql_basic)){
    // If record exists, hide the form
    echo '<style>.basic_detailsform { display: none; }</style>';
    echo '<style>.icon_container_complete { display: block; }</style>';
}
?>
<?php 
if(isset($row_bank)){
    echo '<style>.cheque-container { display: block; }</style>';
    echo '<style>.profile { display: none; }</style>';

}
else{
    echo '<style>.cheque-container { display: none; }</style>';

}

?>

    <details >
        <summary class="basic_details">Add Basic Details</summary>
        <div class="icon_container_complete">
        <div class="card">
    <div class="img">
    <img src="<?php if(isset($row_basic_detail_info)){ echo 'img/' . $row_basic_detail_info['companylogo']; } ?>">
    </div>
    <div class="infos">
      <div class="name">
      <h2><?php if(isset($row_basic_detail_info)) { echo $row_basic_detail_info['companyname']; } ?></h2>
      <h4>-<?php if(isset($row_basic_detail_info)){ echo strtoupper($row_basic_detail_info['enterprise_type']); } ?></h4>
      </div>
      <p class="text">
        <strong>Address :</strong>
        <?php if(isset($row_basic_detail_info)) { 
    echo $row_basic_detail_info['company_address'] . ' ' . $row_basic_detail_info['state'] . ' ' . $row_basic_detail_info['pincode']; 
} ?>
      </p>
      <p class="text">
      <strong>Contact Number :</strong><?php if(isset($row_basic_detail_info)) { echo $row_basic_detail_info['office_number']; } ?>
      </p>
      <?php
      $sql_website="SELECT * FROM `login` where companyname='$companyname001'";
      $result_website=mysqli_query($conn,$sql_website);
      $row_website=mysqli_fetch_assoc($result_website);
      ?>
      <p class="text">
      <strong>Website :</strong><?php if(isset($row_website)) { echo $row_website['webiste_address']; } ?>
      </p>
      <p class="text" id="add_on">
      <strong>Add On Services :</strong><?php if(isset($row_basic_detail_info)) { echo $row_basic_detail_info['add_on_services']; } ?>
      </p>
      <!-- <ul class="stats">
        <li>
          <h3>15K</h3>
          <h4>Views</h4>
        </li>
        <li>
          <h3>82</h3>
          <h4>Projects</h4>
        </li>
        <li>
          <h3>1.3M</h3>
          <h4>Followers</h4>
        </li>
      </ul> -->
      <div class="links">
      <button class="follow" onclick="window.location.href='edit_basic_detail.php'">EDIT PROFILE</button>
      <!-- <button class="view">View profile</button> -->
      </div>
    </div>
  </div>

        </div>

        <form action="basic_detail.php" method="POST" enctype="multipart/form-data" autocomplete="off" class="basic_detailsform" >
                        <div class="basic_detail_container_form">
                <p>Enter Basic Details</p>
            <div class="trial1">
            <input type="text" name="basicdetail_companyname" placeholder="" value="<?php echo $companyname001 ?>" class="input02" readonly>
            <label for="" class="placeholder2">Company Name</label>
            </div>
            <div class="trial1">
                <input type="file" name="company_logo_basic_Detial" placeholder="" class="input02" required>
                <label for="" class="placeholder2">Company Logo</label>
            </div>

            <div class="trial1 hideit">
                <input type="hidden" name="enterprise_type_basicdetail" placeholder=""  value="<?php echo strtoupper($row['enterprise']); ?>" class="input02" readonly>
                <label for="" class="placeholder2">Enterprise Type</label>
            </div>
            <div class="trial1">
            <textarea type="text" name="companyaddress_basicdetail" placeholder="" class="input02" required></textarea>
            <label for="" class="placeholder2">Company Address</label>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="website" value="<?php echo $row['webiste_address'] ?>" class="input02">
                <label for="" class="placeholder2">Website Address</label>
            </div>
            <div class="outer02">
            <div class="trial1">
            <select name="state_basic_detial" id="state" class="input02" required>
    <option value="">Select State</option>
    <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
    <option value="Andhra Pradesh">Andhra Pradesh</option>
    <option value="Arunachal Pradesh">Arunachal Pradesh</option>
    <option value="Assam">Assam</option>
    <option value="Bihar">Bihar</option>
    <option value="Chandigarh">Chandigarh</option>
    <option value="Chhattisgarh">Chhattisgarh</option>
    <option value="Dadra and Nagar Haveli">Dadra and Nagar Haveli</option>
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
            <div class="trial1">
                <input type="text" name="pincode_basicdetial" placeholder="" class="input02" required>
                <label for="" class="placeholder2">Pincode</label>
            </div>
            </div>
            <div class="trial1">
            <input type="text" name="cont_new"  placeholder="" class="input02" required>
            <label for="" class="placeholder2">Office Number</label>
        </div>


        <div class="trial1 <?php if($enterprise==='logistics'){echo 'hideit';} ?>" id="Info_Outer">
            <select name="add_service_new" id="_info" class="input02" >
                <option value=""disabled selected>Choose Add On Services</option>
                <option value="RMC Plant">Dedicated RMC Plant</option>
                    <option value="Foundation Work">Piling Contract</option>
                    <option value="RMC Plant And Foundation Work">RMC Plant And Foundation Work</option>
                    <option value="None">None</option>
            </select>
        </div>
        <div class="trial1" >
            <select name="rmc_type_new" id="rmc_Type" class="input02" onchange="Rmc_Location()">
                <option value=""disabled selected>RMC Type</option>
                <option value="Dedicated">Dedicated</option>
                <option value="Commercial">Commercial</option>

            </select>
        </div>
        <div class="outer02" >
            <div class="trial1" id="Rmc_loca_outer">
                <input type="text" name="rmc_loca_new"  placeholder="" class="input02">
                <label for="" class="placeholder2">RMC Location</label>
            </div>
            <div class="trial1" id="Rmc_loca_outer2">
                <input type="text" name="rmc_pin_new"  placeholder="" class="input02">
                <label for="" class="placeholder2">RMC Pincode</label>
            </div>
        </div>
        <!-- <div class="addnew_office"><i class="fas fa-plus-circle"></i></div> -->


 <button class="basic-detail-button" name="submit_basic_Detail_form" >Submit</button>


            </div>
        </form>
    </details>
    <details>
        <summary class="basic_details">Add Management Team</summary>
        <section class="gallery" id="gallery" <?php if(mysqli_num_rows($result_management_team) == 0) { echo 'hidden'; } ?>>
        <main>

        <div class="slider" reverse="true" style="--width: 200px; --height: 200px; --quantity: 20;">
    <div class="list">
        <?php 
        // Initialize a counter variable
        $position = 1;
        
        // Loop through all rows fetched from $result_management_team
        while ($row_management = mysqli_fetch_assoc($result_management_team)) {
        ?>
            <div class="item" style="--position: <?php echo $position; ?>">
                <img src="management_team.png" alt="Gallery Image <?php echo $position; ?>">
                <p class="info_para"><?php echo strtoupper($row_management['designation']); ?></p>
                <p class="second_para"><?php echo $row_management['name'] ?></p>
                <p class="second_para todatacont"><?php echo $row_management['email'] ?></p>
                <p class="second_para"><?php echo $row_management['mob_number'] ?></p>
                <div class="btn_manageing"><a href="edit_management.php?id=<?php echo $row_management['sno'] ;?>" data-bs-toggle="tooltip" data-bs-placement="center" title="Edit"><i class="fa-solid fa-pencil"></i></a>&nbsp <a href="del_management.php?id=<?php echo $row_management['sno'] ;?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="fa-solid fa-trash"></i></a></div>
            </div>
            
            <?php 
            // Increment position after each iteration
            $position++;
            ?>
            
        <?php } ?>
    </div>
</div>

    </main>
  </section>

        <form action="add_management.php" method="POST" class="addmanagement_member">
            <div class="manage_container">
                <p>Add Management</p>
                <div class="trial1">
                    <input type="text" name="management_name" placeholder="" class="input02">
                    <label for="" class="placeholder2">Name</label>
                </div>
                <div class="trial1">
                    <input type="text" name="management_email" placeholder="" class="input02">
                    <label for="" class="placeholder2">Email</label>
                </div>
                <input type="text" name="com_name" value="<?php echo $companyname001 ?>" hidden>
                <div class="trial1">
                    <input type="text" name="management_contact_number" placeholder="" class="input02">
                    <label for="" class="placeholder2">Contact Number</label>
                </div>
                <div class="trial1">
                    <input type="text" name="management_designation" placeholder="" class="input02">
                    <label for="" class="placeholder2">Designation</label>
                </div>
                <button class="basic-detail-button" name="addmanagement_btn">Submit</button>


            </div>

        </form>
</details>
<details >
        <summary class="basic_details">Add Team Members</summary>
        <section class="gallery" id="gallery" <?php if(mysqli_num_rows($result_team_member) == 0) { echo 'hidden'; } ?>>
        <main>

        <div class="slider" reverse="true" style="--width: 200px; --height: 200px; --quantity: 20;">
    <div class="list">
        <?php 
        // Initialize a counter variable
        $position_teammember = 1;
        
        // Loop through all rows fetched from $result_management_team
        while ($row_team_member = mysqli_fetch_assoc($result_team_member)) {
        ?>
            <div class="item" style="--position: <?php echo $position_teammember; ?>">
                <img src="management_team.png" alt="Gallery Image <?php echo $position_teammember; ?>">
                <p class="info_para"><?php echo strtoupper($row_team_member['designation']); ?></p>
                <p class="second_para"><?php echo $row_team_member['name'] ?></p>
                <p class="second_para"><?php echo $row_team_member['email'] ?></p>
                <p class="second_para"><?php echo $row_team_member['mob_number'] ?></p>
                <div class="btn_manageing"><a href="edit_teammember.php?id=<?php echo $row_team_member['sno'] ?>" data-bs-toggle="tooltip" data-bs-placement="center" title="Edit"><i class="fa-solid fa-pencil"></i></a > &nbsp <a href="del_teammember.php?id=<?php echo $row_team_member['sno'] ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="fa-solid fa-trash"></i></a></div>
            </div>
            
            <?php 
            // Increment position after each iteration
            $position_teammember++;
            ?>
            
        <?php } ?>
    </div>
</div>

    </main>
  </section>

        <form action="add_team_member.php" method="POST" class="rental-subuser-form" autocomplete="off">
        <div class="innersubuser">
            <div class="add_subuser_heading"><h2 class="rental_heading1">Add Team Member</h2></div>
            
            <div class="trial1">
            <input type="text" name="team_name" id="" placeholder="" class="input02">
            <label class="placeholder2">Name</label>
            </div>
            <div class="trial1">
            <input type="text" name="number" id="" placeholder="" class="input02">
            <label class="placeholder2">Mobile Number</label>
            </div>
            <div class="trial1">
            <input type="text" name="companyname" id="" value="<?php echo $companyname001 ?>" placeholder="" class="input02" readonly>
            <label class="placeholder2">Company Name</label>
            </div>
            <div class="trial1">

            <input type="text" name="email" id="" placeholder="" class="input02">
            <label class="placeholder2">Email</label>
            </div>
            <div class="trial1">
            <select name="department" id="" class="input02">
                <option value="" disabled selected >Choose Department</option>
                <option value="marketing">Marketing</option>
                <option value="operation">Operation and Maintanance</option>
                <option value="accounts">Accounts</option>
                <option value="Adminsitration">Adminsitration</option>
                <option value="Backend Department">Backend Department</option>
                <option value="Human Resource Department">Human Resource Department</option>
            </select>
            </div>
            <div class="trial1">
                <input type="text" placeholder="" name="actual_designation" class="input02">
                <label for="" class="placeholder2">Designation</label>
            </div>
            <button class="basic-detail-button" name="add_employe">Add User</button>
            

        </div>
    </form>

</details>
<details >
        <summary class="basic_details">Add Bank Details</summary>
        <div class="cheque-container">
        <div class="cheque">
            <div class="header_new">
                <img src="logo_fe.png" alt="Bank Logo">
                <div>
                    <!-- <h2>Cheque</h2> -->
                    <p><span id="bank_name"><?php echo $row_bank['bank_name'] ?></span></p>
                </div>
            </div>
            <div class="details">
                <p>Name: <span id="payee"><?php echo $row_bank['name_on_cheque'] ?></span></p>
                <!-- <p>Amount: <span id="payee">XX,XXX/-</span></p> -->
                <!-- <p>Account Number: <span id="account-number">1234567890</span></p>
                <p>Ifsc Code: <span id="account-number">1234567890</span></p>
                <p>Branch Name: <span id="account-number">1234567890</span></p> -->

                <!-- <p>Amount: <span class="amount">₹10,000.00</span></p> -->
                <!-- <p>Memo: <span id="memo">Payment</span></p> -->
            </div>
            <div class="footer">
                <p class="bank_info">Account Number: <?php echo $row_bank['account_num'] ?> <a>IFSC Code: <?php echo $row_bank['ifsc_code'] ?></a><a>Branch : <?php echo $row_bank['branch'] ?></a><a>Account-Type: <?php echo $row_bank['account_type'] ?></a></p>
                <!-- <p class="bank_info">For <?php echo $row_bank['name_on_cheque'] ?> <img src="<?php if(isset($row_basic_detail_info['companylogo'])) { echo 'img/' . $row_basic_detail_info['companylogo']; } ?>" alt="Company Logo"> </p> -->

            </div>
        </div>
        <button class="basic-detail-button" onclick="window.location.href = 'edit_bank_details.php';">Edit Details</button>

    </div>

        <form action="add_bank_complete.php" autocomplete="off" method="POST" class="profile" enctype="multipart/form-data" <?php if(!empty($row_check['ifsc_code'])){ echo 'style="display:none"';} ?>>
    <div class="profile_container">
        <p>Bank Details</p>
        <div class="trial1">
            <input type="text" placeholder="" name="nameoncheque" class="input02">
            <label for="" class="placeholder2">Name On Bank Cheque</label>
        </div>
        <div class="trial1">
            <!-- <input type="text" name="bankname" placeholder=""  class="input02">
            <label for="" class="placeholder2">Enter Bank Name</label> -->
            <select id="bankSelect" name="bankname" class="input02">
    <option value="">Select a Bank</option>
    <option value="Allahabad Bank">Allahabad Bank</option>
    <option value="Andhra Bank">Andhra Bank</option>
    <option value="Axis Bank">Axis Bank</option>
    <option value="Bandhan Bank">Bandhan Bank</option>
    <option value="Bank of Baroda">Bank of Baroda</option>
    <option value="Bank of India">Bank of India</option>
    <option value="Bank of Maharashtra">Bank of Maharashtra</option>
    <option value="Canara Bank">Canara Bank</option>
    <option value="Central Bank of India">Central Bank of India</option>
    <option value="Citibank">Citibank</option>
    <option value="Corporation Bank">Corporation Bank</option>
    <option value="DCB Bank">DCB Bank</option>
    <option value="Dena Bank">Dena Bank</option>
    <option value="Federal Bank">Federal Bank</option>
    <option value="HDFC Bank">HDFC Bank</option>
    <option value="ICICI Bank">ICICI Bank</option>
    <option value="IDBI Bank">IDBI Bank</option>
    <option value="IDFC Bank">IDFC Bank</option>
    <option value="Indian Bank">Indian Bank</option>
    <option value="Indian Overseas Bank">Indian Overseas Bank</option>
    <option value="IndusInd Bank">IndusInd Bank</option>
    <option value="Jammu and Kashmir Bank">Jammu and Kashmir Bank</option>
    <option value="Karnataka Bank">Karnataka Bank</option>
    <option value="Karur Vysya Bank">Karur Vysya Bank</option>
    <option value="Kotak Mahindra Bank">Kotak Mahindra Bank</option>
    <option value="Lakshmi Vilas Bank">Lakshmi Vilas Bank</option>
    <option value="Nainital Bank">Nainital Bank</option>
    <option value="Oriental Bank of Commerce">Oriental Bank of Commerce</option>
    <option value="Punjab National Bank">Punjab National Bank</option>
    <option value="RBL Bank">RBL Bank</option>
    <option value="South Indian Bank">South Indian Bank</option>
    <option value="State Bank of India">State Bank of India</option>
    <option value="Syndicate Bank">Syndicate Bank</option>
    <option value="UCO Bank">UCO Bank</option>
    <option value="Union Bank of India">Union Bank of India</option>
    <option value="United Bank of India">United Bank of India</option>
    <option value="Vijaya Bank">Vijaya Bank</option>
    <option value="Yes Bank">Yes Bank</option>
</select>

        </div>
        <div class="trial1">
            <input type="text" name="acc_num" placeholder="" class="input02">
            <label for="" class="placeholder2">Enter Bank Account Number</label>
        </div>
        <div class="trial1">
            <input type="text" name="ifsc" placeholder="" class="input02">
            <label for="" class="placeholder2">IFSC Code</label>
        </div>
        <div class="trial1">
            <input type="text" name="branch" placeholder="" class="input02">
            <label for="" class="placeholder2"> Branch</label>
        </div>
        <input type="text" name="bank_comp_name" value="<?php echo $companyname001 ?>" hidden>
        <div class="trial1">
            <select name="acc_type" id="" class="input02">
                <option value=""disabled selected>Choose Account Type</option>
                <option value="Current">Current</option>
                <option value="Savings">Savings</option>
            </select>
        </div>
        <button class="basic-detail-button" name="bank_complete">Submit</button>
    </div>
</form>

</details>
<details >
        <summary class="basic_details">Add Registration Details</summary>

        <form action="add_reg_detials_complete.php" method="POST" autocomplete="off" class="registration_details"  enctype="multipart/form-data">
            <div class="reg_data_container">
                <p>Add Registration Details</p>
                <div class="trial1">
                    <select name="iso_dd" id="iso_dd_" class="input02" onchange="iso_regi()">
                        <option value=""disabled selected>ISO Registered ?</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </div>
                <div class="trial1" id="iso_">
                    <select name="iso_type" id="" class="input02">
                        <option value=""default selected>ISO Type</option>
                    <option value="ISO 9001">ISO 9001: Quality Management System (QMS)</option>
        <option value="ISO 14001">ISO 14001: Environmental Management System (EMS)</option>
        <option value="ISO 45001">ISO 45001: Occupational Health and Safety Management System (OHSMS)</option>
        <option value="ISO 27001">ISO 27001: Information Security Management System (ISMS)</option>
        <option value="ISO 22000">ISO 22000: Food Safety Management System</option>
        <option value="ISO 50001">ISO 50001: Energy Management System (EnMS)</option>
        <option value="ISO 13485">ISO 13485: Medical Devices Quality Management System</option>
        <option value="IATF 16949">IATF 16949: Quality Management System for Automotive Production</option>
                    </select>
                </div>
                <div class="trial1">
            <select name="msme" id="msme_complete_dd" class="input02" onchange="msme_details_()">
                <option value=""disabled selected>MSME Registered ?</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
        </div>
        <div class="outer02" id="msme_num">
            <div class="trial1">
                <input type="text" name="msme_number"  class="input02">
                <label for="" class="placeholder2">MSME Number</label>
            </div>
            <div class="trial1">
                <input type="file" name="msme_certificate" class="input02">
                <label for="" class="placeholder2">MSME Certificate</label>
            </div>
        </div>
        <div class="outer02">
        <div class="trial1">
            <input type="text" name="gst_new"  placeholder="" class="input02">
            <label for="" class="placeholder2">Gst Number</label>
        </div> <div class="trial1">
            <input type="file" name="upl_gst" class="input02">
            <label for="" class="placeholder2">Upload Gst Certificate</label>
        </div>
        </div>
        <div class="outer02">
        <div class="trial1">
            <input type="text" name="pancard_new"  placeholder="" class="input02">
            <label for="" class="placeholder2">Pan Card Number</label>
        </div> 
        <div class="trial1">
            <input type="file" name="pan_upl"  placeholder="" class="input02">
            <label for="" class="placeholder2">Upload Pancard </label>
        </div>
        </div> 
        <div class="trial1">
            <select name="coi_avail" id="coi_available" class="input02" onchange="coi_numberinput()">
                <option value=""disabled selected>COI Available ?</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
        </div>
        <input type="text" name="companyname_registration" value="<?php echo $companyname001  ?>" hidden>
        <div class="trial1" id="coi_number_input">
            <input type="text" placeholder="" name="coi_number" class="input02">
            <label for="" class="placeholder2">COI Number</label>
        </div>
        <button class="basic-detail-button" name="registration_details_complete">Submit</button>

                </div>

            </div>
        </form>
</details>

</body>
<style>
    summary.basic_details::-webkit-details-marker {
        display: none; /* Hide default triangle marker for WebKit browsers */
    }
    
    summary.basic_details {
        list-style: none; /* Remove default list style */
        cursor: pointer; /* Set cursor to pointer on hover */
        padding-left: 1em; /* Add padding to align text */
    }
    
    summary.basic_details::before {
        content: '';
        display: inline-block;
        width: 0.8em; /* Adjust size as needed */
        height: 0.8em; /* Adjust size as needed */
        margin-left: -1em; /* Adjust position to align with text */
        margin-right: 0.5em; /* Adjust position to separate from text */
        background-color: #333; /* Color of the square */
        border-radius: 3px; /* Rounded corners if desired */
        transition: transform 0.3s ease-in-out;
    }
    details[open] summary.basic_details::before {
        transform: rotate(45deg); /* Rotate the square when details are open */
        background-color: #3f67b5; /* Change color when open if desired */
    }
</style>
<script>
function msme_details_() {
    const msme_complete_dd = document.getElementById("msme_complete_dd");
    const msme_num = document.getElementById("msme_num");

    if (msme_complete_dd.value === 'Yes') {
        msme_num.style.display = 'block';
        msme_num.style.display = 'flex'; // This line is redundant and can be removed
        msme_num.style.alignItems = 'center'; // Use camelCase for CSS properties in JavaScript
    } else {
        msme_num.style.display = 'none';
    }

    }
    function coi_numberinput() {
    const coi_dd = document.getElementById("coi_available");
    const coi_number_input = document.getElementById("coi_number_input");

    if (coi_dd.value === 'Yes') {
        coi_number_input.style.display = 'block';
    } else {
        coi_number_input.style.display = 'none';
    }
}
function iso_regi() {
    const iso_dd = document.getElementById("iso_dd_");
    const iso_ = document.getElementById("iso_");

    if (iso_dd.value === 'Yes') {
        iso_.style.display = 'block';
    } else {
        iso_.style.display = 'none'; 
    }
}
</script>
</html>