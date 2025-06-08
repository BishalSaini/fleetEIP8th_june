<?php
include "partials/_dbconnect.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$companyname001 = $_SESSION['companyname'];
$enterprise = $_SESSION['enterprise'];
$email = $_SESSION['email'];

$dashboard_url = '';
if ($enterprise === 'rental') {
    $dashboard_url = 'rental_dashboard.php';
} elseif ($enterprise === 'logistics') {
    $dashboard_url = 'logisticsdashboard.php';
} elseif ($enterprise === 'epc') {
    $dashboard_url = 'epc_dashboard.php';
} elseif ($enterprise === 'admin') {
    $dashboard_url = 'news/admin/dashboard.php';
}
$showAlert = false;
$showError = false;

?>
<?php
if(isset($_SESSION['success'])){
  $showAlert= true;
  unset($_SESSION['success']);
}
else if(isset($_SESSION['error'])){
  $showError= true;
  unset($_SESSION['error']);

}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offer Letter</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <link rel="stylesheet" href="tiles.css">
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
</head>
<body>
<div class="navbar1">
        <div class="logo_fleet">
            <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='<?php echo $dashboard_url  ?>'">
        </div>
        <div class="iconcontainer">
            <ul>
                <li><a href="<?php echo $dashboard_url ?>">Dashboard</a></li>
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
      <span class="alertText_addfleet"><b>Success! 
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
    <div class="add_fleet_btn_new" id="rentalclientbutton" >
<button class="generate-btn"> 
    <article class="article-wrapper" onclick="window.location.href='offerletter.php'" id="rentalclientbuttoncontainer"> 
  <div class="rounded-lg container-projectss ">
    </div>
    <div class="project-info">
      <div class="flex-pr">
        <div class="project-title text-nowrap">Generate Offer Letter</div>
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
<br><br>
<div class="filters">
    <p>Apply Filter :</p>
    <form action="offerletterfiltered.php" method="GET" autocomplete="off">
        <div class="filterformcontainer">
    <select name="filtertype" id="filterselect" onchange="updateFilterInput(this.value)" class="filter_button" required>
        <option value="" disabled selected>Select Filter</option>
        <option value="email">Search By Email</option>
        <option value="name">Search By Name</option>
        <option value="mobile">Search By Mobile</option>
        <option value="jobrole">Search By Job Role</option>
        <option value="joiningdate">Search By Date Of Joining</option>
        <option value="joininglocation">Search By Joining Location</option>
        <option value="department">Search By Department</option>
        <option value="refno">Search By Ref No</option>
    </select>

    <input type="text" name="emailfilter" id="enteremailfilter" placeholder="Enter Email" class="filterinput" style="display: none;">
    <input type="text" name="namefilter" id="enternamefilter" placeholder="Enter Name" class="filterinput" style="display: none;">
    <input type="text" name="mobilefilter" id="entermobilefilter" placeholder="Enter Mobile" class="filterinput" style="display: none;">
    <input type="text" name="jobrolefilter" id="enterjobrolefilter" placeholder="Enter Job Role" class="filterinput" style="display: none;">
    <input type="date" name="joiningfilter" id="enterjoiningdatefilter" placeholder="Enter Date Of Joining" class="filterinput" style="display: none;">
    <input type="text" name="departmentfilter" id="enterdepartmentfilter" placeholder="Enter Department" class="filterinput" style="display: none;">
    <input type="text" name="refnofilter" id="enterrefnofilter" placeholder="Enter Ref No" class="filterinput" style="display: none;">
    <!-- <input type="text" name="aadhar" id="enterjoininglocationfilter" placeholder="Enter Joining" class="filterinput" style="display: none;" minlength="12" maxlength="12" pattern="\d{12}" title="Aadhar number must be exactly 12 digits"> -->
    <select name="statefilter" id="enterjoininglocationfilter" style="display: none;" class="filterinput2">
    <option value="" disabled selected>Joining State</option>
    <option value="Andhra Pradesh">Andhra Pradesh</option>
    <option value="Arunachal Pradesh">Arunachal Pradesh</option>
    <option value="Assam">Assam</option>
    <option value="Bihar">Bihar</option>
    <option value="Chhattisgarh">Chhattisgarh</option>
    <option value="Goa">Goa</option>
    <option value="Gujarat">Gujarat</option>
    <option value="Haryana">Haryana</option>
    <option value="Himachal Pradesh">Himachal Pradesh</option>
    <option value="Jharkhand">Jharkhand</option>
    <option value="Karnataka">Karnataka</option>
    <option value="Kerala">Kerala</option>
    <option value="Madhya Pradesh">Madhya Pradesh</option>
    <option value="Maharashtra">Maharashtra</option>
    <option value="Manipur">Manipur</option>
    <option value="Meghalaya">Meghalaya</option>
    <option value="Mizoram">Mizoram</option>
    <option value="Nagaland">Nagaland</option>
    <option value="Odisha">Odisha</option>
    <option value="Punjab">Punjab</option>
    <option value="Rajasthan">Rajasthan</option>
    <option value="Sikkim">Sikkim</option>
    <option value="Tamil Nadu">Tamil Nadu</option>
    <option value="Telangana">Telangana</option>
    <option value="Tripura">Tripura</option>
    <option value="Uttar Pradesh">Uttar Pradesh</option>
    <option value="Uttarakhand">Uttarakhand</option>
    <option value="West Bengal">West Bengal</option>
    <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
    <option value="Chandigarh">Chandigarh</option>
    <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and Daman and Diu</option>
    <option value="Delhi">Delhi</option>
    <option value="Jammu and Kashmir">Jammu and Kashmir</option>
    <option value="Ladakh">Ladakh</option>
    <option value="Lakshadweep">Lakshadweep</option>
    <option value="Puducherry">Puducherry</option>

    </select>
    <button class="filter_button" id="submitfilter">Submit</button>
</div>
</form>

</div>


<?php 
$sql="SELECT * FROM `employeedetails` where companyname='$companyname001' order by id desc";
$result=mysqli_query($conn,$sql);
if(mysqli_num_rows($result)>0){ ?>
    <table class="quotation-table" id="viewgeneratedofferletter">
        <tr>
            <th>Ref No</th>
            <th>Name</th>
            <th>Email</th>
            <th>Cell</th>
            <th>Job Role</th>
            <!-- <th>Status</th> -->
            <th>Action</th>
        </tr>
        <tr>
        <?php 
        while($row=mysqli_fetch_assoc($result)){ ?>
        <tr>
            <td><?php echo $row['refno'] ?></td>
            <td><?php echo $row['fullname'] ?></td>
            <td><?php echo $row['contactemail'] ?></td>
            <td><?php echo $row['contactnumber'] ?></td>
            <td><?php echo $row['jobrole'] ?></td>
            <!-- <td><?php echo $row['status'] ?></td> -->
            <td data-label="Actions">
            <a href="editofferletter.php?id=<?php echo $row['id']; ?>" class="quotation-icon" title="Edit">
                <i style="width: 22px; height: 22px;" class="bi bi-pencil"></i>
            </a>
            <a href="deleteofferletter.php?id=<?php echo $row['id']; ?>" onclick="return confirmDelete();" class="quotation-icon" title="Delete">
                <i style="width: 22px; height: 22px;" class="bi bi-trash"></i>
            </a>
            <a href="viewofferletter.php?id=<?php echo $row['id']; ?>" class="quotation-icon" title="Print">
                <i style="width: 22px; height: 22px;" class="bi bi-file-text"></i>
            </a>
        </td>


        </tr>
       
<?php }
        ?>

        </tr>
    </table>

<?php }
?>

</body>
<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete ?");
    }

    function updateFilterInput(selectedValue) {
        document.getElementById("enteremailfilter").style.display = "none";
        document.getElementById("enternamefilter").style.display = "none";
        document.getElementById("entermobilefilter").style.display = "none";
        document.getElementById("enterjobrolefilter").style.display = "none";
        document.getElementById("enterjoiningdatefilter").style.display = "none";
        document.getElementById("enterdepartmentfilter").style.display = "none";
        document.getElementById("enterjoininglocationfilter").style.display = "none";

        if (selectedValue) {
            const inputField = document.getElementById(`enter${selectedValue}filter`);
            if (inputField) {
                inputField.style.display = "block";
            }
        }
    }

</script>
</html>