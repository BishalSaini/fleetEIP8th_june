<?php
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();


// Redirect to another page if needed
header("Location: index.php");

exit();
