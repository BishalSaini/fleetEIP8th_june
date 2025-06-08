<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'partials/_dbconnect.php';
    $email_input=$_POST['email'];
    $password=$_POST['password'];

    $sql_check="SELECT * FROM `login` where email='$email_input' ";
    $result=mysqli_query($conn , $sql_check);
    $row=mysqli_fetch_assoc($result);

    if($row['password']=== $password){
        switch ($row['enterprise']) {
            case 'rental':
                header("location: rental_dashboard.php");
                exit;
            case 'OEM':
                header("location: oem_dashboard.php");
                exit;
            case 'logistics':
                header("location: logistics_dashboard.php");
                exit;
            case 'admin':
                header("location: admin.php");
                exit;
            case 'epc':
                header("location: epc_dashboard.php");
                exit;
            default:
                echo "Invalid Credentials";
        }

    }


}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">      <link rel="icon" href="favicon.jpg" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="sign_in_testing.php" method="POST" class="signinform1">
        <input type="text" name="email" placeholder="email">
        <input type="text" name="password" placeholder='password'>
        <button type="submit">Sign in</button>
    </form>
</body>
</html>