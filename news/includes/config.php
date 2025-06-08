<?php
$server="localhost";
$username="root";
$password= "";
$database= "users";

$con=mysqli_connect($server,$username,$password,$database);
if(!$con){
    die("error".mysqli_connect_error());
}
?>


