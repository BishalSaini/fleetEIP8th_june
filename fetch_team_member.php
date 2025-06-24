<?php
include "partials/_dbconnect.php";
session_start();
$companyname001 = $_SESSION['companyname'] ?? '';

header('Content-Type: application/json');

// Handle GET for designation/email (legacy, not used for contact add)
if (isset($_GET['name'])) {
    $name = mysqli_real_escape_string($conn, $_GET['name']);
    $query = "SELECT designation, email FROM `team_members` WHERE name='$name' and (department='Management' || department='Human Resource Department') and company_name='$companyname001' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo json_encode($row);
    } else {
        echo json_encode(null);
    }
    exit;
}


// Handle search for team members
$search = $_POST['search'] ?? '';
$company = $_POST['company'] ?? $companyname001;
$results = [];

if ($search !== '') {
    $stmt = $conn->prepare("SELECT name, mob_number, email FROM team_members WHERE company_name = ? AND (name LIKE CONCAT('%', ?, '%') OR email LIKE CONCAT('%', ?, '%')) ORDER BY name ASC LIMIT 10");
    $stmt->bind_param("sss", $company, $search, $search);
    $stmt->execute();
    $stmt->bind_result($name, $mob_number, $email);
    while ($stmt->fetch()) {
        $results[] = [
            'name' => $name,
            'mob_number' => $mob_number,
            'email' => $email
        ];
    }
    $stmt->close();
}

echo json_encode($results);
exit;
?>
