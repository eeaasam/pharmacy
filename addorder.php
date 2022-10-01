<?php
header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json;charset=utf-8'); //return json string

require_once('Connections/conn_db.php');
(!isset($_SESSION)) ? session_start() : ""; 

if(isset($_SESSION['emailid']) && $_SESSION['emailid']!="") {
    $emailid=$_SESSION['emailid'];
    $addressid=$_POST['addressid'];
    $ip=$_SERVER['REMOTE_ADDR'];
    $orderid=strtotime('now').rand(100000,999999); //自行產生訂單編號 
    $query = sprintf("INSERT INTO uorder (orderid, emailid, addressid, howpay, status) VALUES ('%s','%d', '%d', '1', '1');",$orderid,$emailid,$addressid);
    $result = mysqli_query($link,$query);
	if($result){
        $query=sprintf("UPDATE cart SET orderid= '%s', emailid='%d' WHERE ip='%s' AND orderid IS NULL;",$orderid,$emailid,$ip);
        $result = mysqli_query($link,$query);
		$retcode = array("c" => "1", "m" => '謝謝您，系統已經完成結帳，請在首頁查閱訂單處理狀態。');
	}else {
        $retcode = array("c" => "0", "m" => '抱歉！資料無法寫入後台資料庫，請連絡管理人員。');
    }
    echo json_encode($retcode, JSON_UNESCAPED_UNICODE);
}
return ;
?>