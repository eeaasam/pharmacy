<?php
header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json;charset=utf-8'); //return json string

require_once('Connections/conn_db.php');

if(isset($_GET['p_id']) && isset($_GET['qty'])) {
    $p_id = $_GET['p_id'];
    $qty=$_GET['qty'];
    $u_ip=$_SERVER['REMOTE_ADDR'];
    $query = "INSERT INTO cart ( p_id, qty, ip) VALUES (".$p_id.",".$qty.",'".$u_ip."');";
    $result = mysqli_query($link,$query) ;
	if($result){
		$retcode = array("c" => "1", "m" => '謝謝您！產品已加入購物車中。');
	}else {
        $retcode = array("c" => "0", "m" => '抱歉！資料無法寫入後台資料庫，請連絡管理人員。');
    }
    echo json_encode($retcode, JSON_UNESCAPED_UNICODE);
}
return ;
?>