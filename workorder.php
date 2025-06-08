<?php
include_once 'partials/_dbconnect.php';

$showAlert = false;
$showError = false;
$showAlertuser=false;
$uniqueId = uniqid();




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
if(isset($_SESSION['error'])){
    $showError=true;
    unset($_SESSION['error']);
}

else if(isset($_SESSION['success'])){
    $showAlert=true;
    unset($_SESSION['success']);

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workorder</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <link rel="stylesheet" href="style.css">
    <style>
        .generate-btn-container {

  display: flex!important;
  justify-content: space-between!important;
  align-items: center!important;
  margin-bottom: 20px!important;
  margin-top: 30px!important;
}

.generate-btn {
  background-color: white!important;
  color: white!important;
  border: none!important;
  border-radius: 4px!important;
  padding: 10px 20px!important;
  cursor: pointer!important;
} 

.article-wrapper{ 
    width:288px!important; 
    height:68px;
}

    </style>
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
            <li><a href="news/">News</a></li>
            <li><a href="logout.php">Log Out</a></li>
        </ul>
    </div>
</div>
<?php
if($showAlert){
    echo '<label>
    <input type="checkbox" class="alertCheckbox" autocomplete="off" />
    <div class="alert notice">
        <span class="alertClose">X</span>
        <span class="alertText">Success <br class="clear"/></span>
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

<div class="quotation-table-container">
  <div class="generate-btn-container">
    <h2></h2>
    <button class="generate-btn"> 
    <article class="article-wrapper" onclick="location.href='generateworkorder.php'" > 
  <div class="rounded-lg container-projectss ">
    </div>
    <div class="project-info">
      <div class="flex-pr">
        <div class="project-title text-nowrap">Generate  Workorder</div>
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
  <?php
$sql = "SELECT * FROM `workorder` WHERE `companyname` = '$companyname001' ORDER BY `id` DESC";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
?>
    <table class="quotation-table" id="showwo">
        <thead>
            <tr>
                <th class="table-heading date_content_td">Date</th>
                <th class="table-heading ref_no_th">Ref No</th>
                <th class="table-heading">To</th>
                <th class="table-heading">Equipment</th>
                <th class="table-heading">Shift</th>
                <th class="table-heading">Rental</th>
                <th class="table-heading">WO Start</th>
                <th class="table-heading">WO End</th>
                <th class="table-heading">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <tr>
            <td class="todatacont"><?php echo (new DateTime($row['entrydate']))->format('jS M y'); ?></td>
            <td><?php echo $row['ref_no']; // Update with the correct column name ?></td>
                <td><?php echo $row['issued_to']; ?></td>
                <td class="todatacont"><?php echo $row['equipment_detail']; ?></td>
                <td><?php echo $row['shiftinfo']; ?></td>
                <td><?php echo $row['rate']; ?></td>
                <td><?php echo (new DateTime($row['start_date']))->format('jS M y'); ?></td>
                <td><?php echo (new DateTime($row['end_date']))->format('jS M y'); ?></td>
                <td data-label="Actions">
            <!-- <a href="editworkorder.php?id=<?php echo $row['id']; ?>" class="quotation-icon" title="Edit">
                <i style="width: 22px; height: 22px;" class="bi bi-pencil"></i>
            </a> -->
            <a href="deletewo.php?id=<?php echo $row['id']; ?>" onclick="return confirmDelete();" class="quotation-icon" title="Delete">
                <i style="width: 22px; height: 22px;" class="bi bi-trash"></i>
            </a>
            <a href="printworkorder.php?id=<?php echo $row['id']; ?>" class="quotation-icon" title="Print">
                <i style="width: 22px; height: 22px;" class="bi bi-file-text"></i>
            </a>
        </td>
            </tr>
        <?php
        }
        ?>
        </tbody>
    </table>
<?php
} else {
    echo "No records found.";
}
?>

  


</body>
<script>
            function confirmDelete() {
        return confirm("Are you sure you want to delete ?");
    }

</script>
</html>