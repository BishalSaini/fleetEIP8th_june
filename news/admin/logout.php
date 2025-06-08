<?php
session_start();
include("includes/config.php");
$_SESSION['loggedin']=="";
session_unset();
session_destroy();

?>
<script language="javascript">
document.location="../../sign_in.php";
</script>
