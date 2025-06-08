<?php
// Include the database connection file
include 'partials/_dbconnect.php';

// Define the table name and the columns that should be considered for identifying duplicates
$tableName = 'dl_expiry';
$uniqueColumns = ['driver_name', 'dl', 'expiry_date', 'days_left', 'company_name']; // Specify the 5 columns that define uniqueness

// Build and execute the DELETE query to remove duplicates
$sql = "DELETE t1 FROM $tableName t1 
        INNER JOIN $tableName t2 
        WHERE t1.driver_name = t2.driver_name
        AND t1.dl = t2.dl
        AND t1.expiry_date = t2.expiry_date
        AND t1.days_left = t2.days_left
        AND t1.company_name = t2.company_name
        AND t1.sno < t2.sno";

$result = mysqli_query($conn, $sql);

// if ($result) {
//     echo "Duplicate records based on the specified columns have been deleted successfully.";
// } else {
//     echo "Error deleting duplicate records: " . mysqli_error($conn);
// }

// Close the database connection
// mysqli_close($conn);