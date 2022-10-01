<?php
include_once("Connections/conn_db.php");
if(isset($_GET['email'])) {
    $email = $_GET['email'];
    $query = "SELECT emailid FROM `member` WHERE `email` = '". $email."'";
    $result = mysqli_query($link,$query) ;
   $row = mysqli_num_rows($result); 
   if($row==0){
      echo 'true';
      return;
   }
} 
echo 'false';
return ;
?>