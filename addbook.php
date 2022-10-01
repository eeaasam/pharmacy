<?php
header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json;charset=utf-8'); //return json string

require_once('Connections/conn_db.php');
(!isset($_SESSION)) ? session_start() : ""; 

if(isset($_SESSION['emailid']) && $_SESSION['emailid']!="") {
    $emailid=$_SESSION['emailid'];
    $cname=$_POST['cname'];
    $mobile=$_POST['mobile'];
    $myzip=$_POST['myzip'];
    $address= $_POST['address'];
    $query = sprintf("UPDATE addbook SET setdefault ='0' WHERE emailid='%d' AND setdefault ='1';",$emailid);
    $result = mysqli_query($link,$query);
    $query="INSERT INTO addbook (setdefault, emailid, cname, mobile, myzip, address) VALUES ('1', '".$emailid."', '".$cname."', '".$mobile."', '".$myzip."', '".$address."')";
    $result = mysqli_query($link,$query);
	if($result){
		$retcode = array("c" => "1", "m" => '收件人資訊已經新增。');
	}else {
        $retcode = array("c" => "0", "m" => '抱歉！資料無法寫入後台資料庫，請連絡管理人員。');
    }
    echo json_encode($retcode, JSON_UNESCAPED_UNICODE);
}
return ;
?>