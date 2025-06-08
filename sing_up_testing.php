<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'partials/_dbconnect.php';
    $email=$_POST['email'];
    $password=$_POST['password'];
    $enterprise=$_POST['enterprise'];
    $sql_insert_table = "INSERT INTO login (email, password, enterprise)
    VALUES ('$email', '$password', '$enterprise')";
        $result=mysqli_query($conn , $sql_insert_table);
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
    <form action="sing_up_testing.php" method="POST">
        <input type="text" placeholder="email" name="email">
        <input type="text" placeholder="password" name="password">
        <input type="text" placeholder="enterprise" name="enterprise">
        <ol type="1">
            <li>apple</li>
        </ol>
        <button type="submit">Submit</button>
    </form>
</body>
</html>