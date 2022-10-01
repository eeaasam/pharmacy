<?php require_once('Connections/conn_db.php'); ?>
<?php
if (isset($_GET['mode']) && $_GET['mode'] != '') {
    $mode = $_GET['mode'];

    switch ($mode) {
        case 1:
            //使用購物車編號刪除內容
            $SQLstring = sprintf("DELETE FROM cart WHERE cartid=%d AND `orderid` is NULL", $_GET['cartid']);
            break;
        case 2:
            //使用ip清空購物車內容
            $SQLstring = sprintf("DELETE FROM cart WHERE  ip='%s' AND `orderid` is NULL", $_SERVER['REMOTE_ADDR']);
            break;
    }
    $result = mysqli_query($link, $SQLstring);
}
$deleteGoTo = "cart.php";
header(sprintf("Location: %s", $deleteGoTo));
?>