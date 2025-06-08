<?php
session_start();
$companyname001=$_SESSION['companyname'];
$showAlert=false;
if(isset($_SESSION['success'])){
  $showAlert=true;
  unset($_SESSION['success']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="tiles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <title>Document</title>
</head>
<body>
<div class="navbar1">
    <div class="logo_fleet">
    <img src="logo_fe.png" alt="FLEET EIP" onclick="window.location.href='logisticsdashboard.php'">
</div>

        <div class="iconcontainer">
            <ul>
                <li><a href="logisticsdashboard.php">Dashboard</a></li>
                <!-- <li><a href="news/">News</a></li> -->
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
?>
    <div class="add_fleet_btn_new" id="logiquotation">
<button class="generate-btn"> 
    <article class="article-wrapper" onclick="window.location.href='generatelogisticsquotation.php'" id="logibutton"> 
  <div class="rounded-lg container-projectss ">
    </div>
    <div class="project-info">
      <div class="flex-pr">
        <div class="project-title text-nowrap">Generate Quotation</div>
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
include "partials/_dbconnect.php";

// Ensure $companyname001 is properly sanitized
$companyname001 = mysqli_real_escape_string($conn, $companyname001);

$sql = "SELECT * FROM logistic_quotation_generated WHERE companyname='$companyname001'";
$result = mysqli_query($conn, $sql);

// Check if the query was successful and if there are results
if ($result && mysqli_num_rows($result) > 0) { ?>
    <table class="logi_quotation_table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Ref No</th>
                <th>To</th>
                <th>Trailor Type</th>
                <th>Material</th>
                <th>Freight</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                <td><?php echo (new DateTime($row['date']))->format('d-m-Y'); ?></td>
                <td><?php echo ($row['ref_no']); ?></td>
                    <td><?php echo ($row['to_person']); ?></td>
                    <td><?php echo ($row['trailor_type1']); ?></td>
                    <td><?php echo ($row['material1']); ?></td>
                    <td><?php echo ($row['freight1']); ?></td>
                    <td>                    
                      <a href="edit_quotationlogi.php?quote_id=<?php echo $row['id']; ?>" class="quotation-icon" title="Edit">
                <i style="width: 22px; height: 22px;" class="bi bi-pencil"></i>
            </a>
            <a href="delete_quotationlogi.php?del_id=<?php echo $row['id']; ?>" class="quotation-icon" title="Delete">
                <i style="width: 22px; height: 22px;" class="bi bi-trash"></i>
            </a>
            <a href="view_logiquotation.php?id=<?php echo $row['id']; ?>" class="quotation-icon" title="Print">
                <i style="width: 22px; height: 22px;" class="bi bi-file-text"></i>
            </a>
</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php
} 
?>

</body>
</html>