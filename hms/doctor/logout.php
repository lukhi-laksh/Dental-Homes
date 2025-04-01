<!-- this code is help us to logout form the doctor page and redirect on login page -->

<?php
session_start();
include('include/config.php');
$_SESSION['dlogin']=="";
date_default_timezone_set('Asia/Kolkata');
$ldate=date( 'd-m-Y h:i:s A', time () );
$did=$_SESSION['id'];
mysqli_query($con,"UPDATE doctorslog  SET logout = '$ldate' WHERE uid = '$did' ORDER BY id DESC LIMIT 1");
session_unset();

$_SESSION['errmsg']="You have successfully logout";
?>
<script language="javascript">
document.location="../../login.php";
</script>
