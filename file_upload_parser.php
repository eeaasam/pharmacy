<?php
$fileName = $_FILES["file1"]["name"];           // The file name
$fileTmpLoc = $_FILES["file1"]["tmp_name"];     // File in the PHP tmp folder
$fileType = $_FILES["file1"]["type"];           // The type of file it is
$fileSize = $_FILES["file1"]["size"];           // File size in bytes
$fileErrorMsg = $_FILES["file1"]["error"];      // 0 for false... and 1 for true
if (!$fileTmpLoc) {                             // if file not chosen
    $retcode = array("success" => "false", "msg" => "", "error" =>"上傳暫存檔無法建立！","filename"=>"");
    echo json_encode($retcode,JSON_UNESCAPED_UNICODE);
    exit();
}
if(move_uploaded_file($fileTmpLoc, "uploads/$fileName")){ //file to uploads folder
    $retcode = array("success" => "true", "msg" => "完成檔案上傳", "error" => "","filename"=>$fileName);
} else {
    $retcode = array("success" => "false", "msg" => "", "error" => "無法完成檔案上傳","filename"=>"");
}
echo json_encode($retcode,JSON_UNESCAPED_UNICODE);
exit();
?>