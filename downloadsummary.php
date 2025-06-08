<?php 
include "partials/_dbconnect.php";
$id = $_GET['id'];

$sql = "
    SELECT rp.*, r.*
    FROM `requirement_price_byrental` rp
    INNER JOIN `req_by_epc` r ON rp.req_id = r.id
    WHERE rp.req_id = '$id'
";

$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $rowbasic = mysqli_fetch_assoc($result);
}

$sql2 = "SELECT * FROM `requirement_price_byrental` WHERE req_id='$id' ORDER BY price_quoted ASC";
$result2 = mysqli_query($conn, $sql2);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download Summary</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js" defer></script>
    <link rel="shortcut icon" href="favicon.jpg" type="image/x-icon">
    <style>
        .page-break {
            page-break-before: always; 
            page-break-inside: avoid; 
            break-before: page;
        }
    </style>
</head>
<body>
    <div class="fulllength">
        <button onclick="downloadsummary()" class="downloadbuttonsummary">Download</button>
        <button onclick="window.location.href='viewquotesepc.php?id=<?php echo $id; ?>'" class="gobackbuttonsummary">    <i class="bi bi-arrow-left"></i> Go Back
        </button>
    </div>
    <div class="outercontainersummary">
        <p class="copyright"><img src="favicon.jpg" alt="">Powered By Fleeteip</p>
        <?php if(mysqli_num_rows($result)>0){
            ?>
                    <div class="reqbasicdetail">
            <p><strong>Project Type : </strong><?php echo $rowbasic['project_type']; ?></p>
            <p><strong>Equipment Type : </strong><?php echo $rowbasic['equipment_type'].' '.$rowbasic['equipment_capacity'].' '.$rowbasic['unit'].' ('.$rowbasic['working_shift'].' Shift)'; ?></p>
            <p><strong>Boom Combination : </strong><?php echo $rowbasic['boom_combination']; ?></p>
            <p><strong>Location : </strong><?php echo $rowbasic['district'].'-'.$rowbasic['state'].' For '.$rowbasic['duration_month'].' Month'; ?></p>
            <p><strong>Tentative Date : </strong><?php echo (new DateTime($rowbasic['tentative_date']))->format('jS M Y'); ?></p>
            <p><strong>Contact : </strong><?php echo $rowbasic['contact_person']; ?> &nbsp <strong>Email :</strong><?php echo $rowbasic['epc_email']; ?> &nbsp <strong>Cell :</strong><?php echo $rowbasic['epc_number']; ?></p>
            <p><strong>Fuel Scope: </strong><?php echo $rowbasic['fuel_scope']; ?> &nbsp <strong>Accomodation Scope : </strong><?php echo $rowbasic['accomodation_scope']; ?></p>
        </div>

<?php
        } ?>
        <br>
        <hr>

        <?php if(mysqli_num_rows($result2)>0){ ?>

        <!-- First page -->
        <div class="ratedetail">
            <div class="first-page">
                <table class="summarydownloadbutton"> 
                    <tr> 
                        <?php 
                        $loopcount = 0;
                        $l1 = 1;
                        $maxLimit = 4;
                        $printNextPage = false; 
                        $l1_1_price = null; // Store price for L1=1

                        while ($row = mysqli_fetch_assoc($result2)) {
                            if ($loopcount > 0 && $loopcount % 2 == 0) {
                                echo '</tr><tr>'; 
                            }
                            
                            // Store price of L1=1
                            if ($l1 == 1) {
                                $l1_1_price = $row['price_quoted'];
                            }
                            
                            // Calculate percent difference for other L1 values
                            if ($l1 > 1 && $l1_1_price !== null) {
                                $current_price = $row['price_quoted'];
                                $percent_difference = (($current_price - $l1_1_price) / $l1_1_price) * 100;
                                echo "<td>";
                                echo "<div class='rateinside'>";
                                echo "<h3 class='highlightit'>L$l1</h3>";
                                echo "<p class='insidedetails'><strong>Provided Quote Is ".number_format($percent_difference, 4)."% Higher Then L1 </strong></p>";
                                echo "<h3 class='custom-card__title' onclick=\"window.location.href='viewquotedetail.php?id={$row['id']}'\">";
                                echo "<strong>{$row['rental_name']}</strong>";
                                echo "</h3>";
                                echo "<p class='insidedetails'><strong>Available From : </strong>".(new DateTime($row['available_From_offer']))->format('jS M Y')."</p>";
                                echo "<p class='insidedetails'><strong>Make & Model: </strong>{$row['offer_make']} {$row['offer_model']} <strong>Cap :</strong> {$row['cap']} {$row['unit']}</p>";
                                echo "<p class='insidedetails'><strong>Cap :</strong> {$row['cap']} {$row['unit']} <strong>YoM : </strong>{$row['offer_yom']}</p>";
                                echo '<p class="insidedetails">';
                                
                                // For Boom
                                if (!empty($row['boom'])) {
                                    echo '<a class="">' .
                                        '<strong>Boom :</strong> ' . htmlspecialchars($row['boom']) . ' &nbsp' .
                                    '</a>';
                                }
                                
                                // For Jib
                                if (!empty($row['jib'])) {
                                    echo '<strong>Jib : </strong>' . htmlspecialchars($row['jib']) . ' &nbsp';
                                }
                                
                                // For Luffing
                                if (!empty($row['luffing'])) {
                                    echo '<strong>Luffing : </strong>' . htmlspecialchars($row['luffing']);
                                }
                                
                                echo '</p>';
                                echo "<p class='insidedetails'><strong>Equipment Location: </strong>{$row['offer_district']} - {$row['offer_equip_location']}</p>";
                                echo "<p class='insidedetails'><strong>Rental : </strong>".number_format($row['price_quoted'])."</p>";
                                echo "<p class='insidedetails'><strong>Mob : </strong>".number_format($row['mob_charges'])." <strong>DeMob : </strong>".number_format($row['demob_charges'])."</p>";
                                echo "<p class='insidedetails'><strong>Contact : </strong>{$row['contact_person_offer']}</p>";
                                echo "<p class='insidedetails'><strong>Email: </strong>{$row['rental_email']}</p>";
                                echo "<p class='insidedetails'><strong>Cell: </strong>{$row['rental_number']}</p>";
                                echo "</div>";
                                echo "</td>";
                            } else {
                                echo "<td>";
                                echo "<div class='rateinside'>";
                                echo "<h3 class='highlightit'>L$l1</h3>";
                                echo "<h3 class='custom-card__title' onclick=\"window.location.href='viewquotedetail.php?id={$row['id']}'\">";
                                echo "<strong>{$row['rental_name']}</strong>";
                                echo "</h3>";
                                echo "<p class='insidedetails'><strong>Available From : </strong>".(new DateTime($row['available_From_offer']))->format('jS M Y')."</p>";
                                echo "<p class='insidedetails'><strong>Make & Model: </strong>{$row['offer_make']} {$row['offer_model']} <strong>Cap :</strong> {$row['cap']} {$row['unit']}</p>";
                                echo "<p class='insidedetails'><strong>Cap :</strong> {$row['cap']} {$row['unit']} <strong>YoM : </strong>{$row['offer_yom']}</p>";
                                echo '<p class="insidedetails">';
                                
                                // For Boom
                                if (!empty($row['boom'])) {
                                    echo '<a class="">' .
                                        '<strong>Boom :</strong> ' . htmlspecialchars($row['boom']) . ' &nbsp' .
                                    '</a>';
                                }
                                
                                // For Jib
                                if (!empty($row['jib'])) {
                                    echo '<strong>Jib : </strong>' . htmlspecialchars($row['jib']) . ' &nbsp';
                                }
                                
                                // For Luffing
                                if (!empty($row['luffing'])) {
                                    echo '<strong>Luffing : </strong>' . htmlspecialchars($row['luffing']);
                                }
                                
                                echo '</p>';
                                
                                                                echo "<p class='insidedetails'><strong>Equipment Location: </strong>{$row['offer_district']} - {$row['offer_equip_location']}</p>";
                                echo "<p class='insidedetails'><strong>Rental : </strong>".number_format($row['price_quoted'])."</p>";
                                echo "<p class='insidedetails'><strong>Mob : </strong>".number_format($row['mob_charges'])." <strong>DeMob : </strong>".number_format($row['demob_charges'])."</p>";
                                echo "<p class='insidedetails'><strong>Contact : </strong>{$row['contact_person_offer']}</p>";
                                echo "<p class='insidedetails'><strong>Email: </strong>{$row['rental_email']}</p>";
                                echo "<p class='insidedetails'><strong>Cell: </strong>{$row['rental_number']}</p>";
                                echo "</div>";
                                echo "</td>";
                            }

                            $l1++; 
                            $loopcount++;
                            if ($l1 > $maxLimit) {
                                $printNextPage = true;
                                break;
                            }
                        } ?>
                    </tr>  
                </table>
            </div>
        </div>


        <?php if ($printNextPage): ?>
            <div class="page-break"></div>
        <?php endif; ?>
        <!-- Second page -->
        <div class="ratedetail">
            <div class="second-page">
                <table class="summarydownloadbutton"> 
                    <tr>
                        <?php 
                        // Continue displaying the rest of the items
                        while ($row = mysqli_fetch_assoc($result2)) {
                            if ($loopcount > 0 && $loopcount % 2 == 0) {
                                echo '</tr><tr>'; 
                            }
                            ?>
                            <td> 
                                <div class="rateinside">
                                    <h3 class="highlightit">L<?php echo $l1; ?></h3>
                                    <h3 class="custom-card__title" onclick="window.location.href='viewquotedetail.php?id=<?php echo $row['id']; ?>'">
                                        <strong><?php echo $row['rental_name']; ?></strong>
                                    </h3>
                                    <?php echo "<p class='insidedetails'><strong>Provided Quote Is ".number_format($percent_difference, 4)."% Higher Then L1 </strong></p>"; ?>

                                    <p class="insidedetails"><strong>Available From : </strong><?php echo (new DateTime($row['available_From_offer']))->format('jS M Y'); ?></p>
                                    <p class="insidedetails"><strong>Make & Model: </strong><?php echo $row['offer_make'].' '.$row['offer_model']; ?> </p>
                                    <p class="insidedetails"><strong>Cap :</strong> <?php echo $row['cap'].' '.$row['unit']; ?> &nbsp<strong>YoM : </strong><?php echo $row['offer_yom']; ?></p>
<?php                                 echo '<p class="insidedetails">';
                                
                                // For Boom
                                if (!empty($row['boom'])) {
                                    echo '<a class="">' .
                                        '<strong>Boom :</strong> ' . htmlspecialchars($row['boom']) . ' &nbsp' .
                                    '</a>';
                                }
                                
                                // For Jib
                                if (!empty($row['jib'])) {
                                    echo '<strong>Jib : </strong>' . htmlspecialchars($row['jib']) . ' &nbsp';
                                }
                                
                                // For Luffing
                                if (!empty($row['luffing'])) {
                                    echo '<strong>Luffing : </strong>' . htmlspecialchars($row['luffing']);
                                }
                                
                                echo '</p>';
 ?>
                                    <p class="insidedetails"><strong>Equipment Location: </strong><?php echo $row['offer_district'].' - '.$row['offer_equip_location']; ?></p>
                                    <p class="insidedetails"><strong>Rental : </strong><?php echo number_format($row['price_quoted']); ?></p>
                                    <p class="insidedetails"><strong>Mob : </strong><?php echo number_format($row['mob_charges']); ?> &nbsp <strong>DeMob : </strong><?php echo number_format($row['demob_charges']); ?></p>
                                    <p class="insidedetails"><strong>Contact : </strong><?php echo $row['contact_person_offer']; ?></p>
                                    <p class="insidedetails"><strong>Email: </strong><?php echo $row['rental_email']; ?></p>
                                    <p class="insidedetails"><strong>Cell: </strong><?php echo $row['rental_number']; ?></p>
                                    <!-- <?php
                                    $visibilityClass = ($row['offer_assembly'] === 'no') ? 'hideit' : '';
                                    ?> -->
                                    <!-- <p class="insidedetails <?php echo $visibilityClass; ?>">
                                        <strong>Assembly Required: </strong>
                                        <?php echo $row['offer_assembly'].' In '.$row['offer_assembly_scope'].' Scope'; ?>
                                    </p> -->
                                </div>
                            </td>
                        <?php 
                            $l1++; 
                            $loopcount++;
                            if ($l1 == 7) { 
                                break;
                            }                        
                        } ?>
                    </tr>  
                </table>
            </div>
        </div>
    </div>
    <?php
        }
        else{
            echo 'No Related Data Was Found';

        }
        
        ?>
</body>
<script>
    function downloadsummary() {
        const element = document.querySelector('.outercontainersummary');

        html2pdf(element, {
            margin: [0.2, 0.2, 0.2, 0.2], 
            filename: '<?php echo $rowbasic['equipment_type'] . ' ' . $rowbasic['district'] . '-' . $rowbasic['state'] .' Summary'. '.pdf'; ?>',
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
