<?php 
//新版sql連線指令
$host = "localhost";
$user = "sales";
$password = "123456";
$database = "pharmacy";
$link = mysqli_connect($host, $user, $password,$database);
if($link<>false){
    mysqli_query($link,"SET CHARACTER SET UTF8");
}
?>