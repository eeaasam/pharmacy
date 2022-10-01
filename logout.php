<?php (!isset($_SESSION)) ? session_start() : ""; ?>
<?php 
$_SESSION['login']=null;
$_SESSION['emailid']=null;
$_SESSION['email']=null;
$_SESSION['cname']=null;
unset($_SESSION['login']);
unset($_SESSION['emailid']);
unset($_SESSION['email']);
unset($_SESSION['cname']);
$sPath="index.php";
header(sprintf("Location: %s", $sPath));
?>