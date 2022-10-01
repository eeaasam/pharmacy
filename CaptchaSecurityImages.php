<?php
// session_start();
class CaptchaSecurityImages {

    var $font = 'verdana.ttf';
    function hex_to_dec($hexcolor){
        //convert hex hex values to decimal ones
        $dec_color=array('r'=>hexdec(substr($hexcolor,0,2)),'g'=>hexdec(substr($hexcolor,2,2)),'b'=>hexdec(substr($hexcolor,4,2)));
        return $dec_color;
    }

    function generateCode($characters) {
        /* list all possible characters, similar looking characters and vowels have been removed */
        $possible = '23456789bcdfghjkmnpqrstvwxyz';
        $code = '';
        $i = 0;
        while ($i < $characters) { 
            $code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
            $i++;
        }
        return $code;
    }
    function CaptchaSecurityImages($width='120',$height='40',$characters='6',$hex_bg_color='FFFFFF',$hex_text_color="FF0000",$hex_noise_color="CC0000",$code='9999') {
		
		$rgb_bg_color=$this->hex_to_dec($hex_bg_color);
		$rgb_text_color=$this->hex_to_dec($hex_text_color);
		$rgb_noise_color=$this->hex_to_dec($hex_noise_color);
		//$code = $this->generateCode($characters);
        /* font size will be 75% of the image height */
        $font_size = $height * 0.75;
        $image = @imagecreate($width, $height) or die('Cannot initialize new GD image stream');
        /* set the colours */
        $background_color = imagecolorallocate($image,$rgb_bg_color['r'], $rgb_bg_color['g'],$rgb_bg_color['b']);
        $text_color = imagecolorallocate($image,$rgb_text_color['r'], $rgb_text_color['g'],$rgb_text_color['b']);
        $noise_color = imagecolorallocate($image,$rgb_noise_color['r'], $rgb_noise_color['g'],$rgb_noise_color['b']);
        /* generate random dots in background */
        for( $i=0; $i<($width*$height)/3; $i++ ) {
            imagefilledellipse($image, mt_rand(0,$width), mt_rand(0,$height), 1, 1, $noise_color);
        }
        /* generate random lines in background */
        for( $i=0; $i<($width*$height)/150; $i++ ) {
            imageline($image, mt_rand(0,$width), mt_rand(0,$height), mt_rand(0,$width), mt_rand(0,$height), $noise_color);
        }
        /* create textbox and add text */
        $textbox = imagettfbbox($font_size, 0, $this->font, $code) or die('Error in imagettfbbox function');
        $x = ($width - $textbox[4])/2;
        $y = ($height - $textbox[5])/2;
        imagettftext($image, $font_size, 0, $x, $y, $text_color, $this->font , $code) or die('Error in imagettftext function');
        /* output captcha image to browser */
        header('Content-Type: image/jpeg');
        imagejpeg($image);
        imagedestroy($image);
//        $_SESSION['security_code'] = $code;
    }

}

$width = isset($_GET['width']) ? $_GET['width'] : '120';
$height = isset($_GET['height']) ? $_GET['height'] : '40';
$characters = isset($_GET['characters']) && $_GET['characters'] > 1 ? $_GET['characters'] : '6';
$code = isset($_GET['code']) ? $_GET['code'] : '9999';
$hex_bg_color=isset($_GET['hex_bg_color']) ? $_GET['hex_bg_color'] : 'ff0000';
$hex_text_color=isset($_GET['hex_text_color']) ? $_GET['hex_text_color'] : '000000';
$hex_noise_color=isset($_GET['hex_noise_color']) ? $_GET['hex_noise_color'] : 'ffffff';
$captcha = new CaptchaSecurityImages($width,$height,$characters,$hex_bg_color,$hex_text_color,$hex_noise_color,$code);

?>