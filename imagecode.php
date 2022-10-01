<?php
// imagecode.php
//num=亂數值
//codewidth=影象寬
//codeheight=影像高
//bgcolor=影像背景顏色black,white,gray,green,red,blue可用
//ftx=文字定位x
//fty=文字定位y
//ftcolor=文字顏色black,white,gray,green,red,blue可用
//ftsize=文字大小
//codecomplex=碼畫面複雜度1-200
header("Content-type: image/png");

if(isset($_GET["num"])) {
	// $authnum=substr($_GET["num"],0,4);  //获取超级链接中传递的验证码
	$authnum=$_GET["num"];  //获取超级链接中传递的验证码
	$codewidth=$_GET["codewidth"];
	$codeheight=$_GET["codeheight"];
	$ftx=$_GET["ftx"];
	$fty=$_GET["fty"];
	$bgcolor=$_GET["bgcolor"];
	$ftcolor=$_GET["ftcolor"];
	$ftsize=$_GET["ftsize"];
	$codecomplex=$_GET["codecomplex"];
}
else {
	$authnum="".rand(1000,9999);
	$codewidth="50";
	$codeheight="30";
	$ftx="7";
	$fty="7";
	$bgcolor="blue";
	$ftcolor="white";
	$ftsize="10";
	$codecomplex="50";
	
}

$im=imagecreate($codewidth,$codeheight);       //创建画布 wdith,height
$black=imagecolorallocate($im,0,0,0);   //定义背景
$white=imagecolorallocate($im,255,255,255);  //定义背景
$gray=imagecolorallocate($im,200,200,200);  //定义背景
$green=imagecolorallocate($im,0,255,0);  //定义背景
$red=imagecolorallocate($im,255,0,0); 
$blue=imagecolorallocate($im,0,0,255);

//imagefill($im,0,0,$black); //填充颜色
imagefill($im,0,0,$$bgcolor); //填充颜色



imagestring($im,$ftsize,$ftx,$fty,$authnum,$$ftcolor);//rand(0,500)数字的模糊程度
for($i=0;$i<$codecomplex;$i++){  //执行for循环，为验证码添加模糊背景
  $randcolor=imagecolorallocate($im,rand(0,255),rand(0,255),rand(0,255)); //创建背景
  imagesetpixel($im,rand()%70,rand()%30,$randcolor);  //绘制单一元素
}

imagepng($im);    //生成png图像
imagedestroy($im);   //销毁图像
?>