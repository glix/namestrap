<?php
if (!class_exists('AxcotoCaptcha')) {
	class AxcotoCaptcha {
		public function __construct() { }

		static public function render($to='') {
			$s = 'ABCDEFGHIJKLMNPQRSTUVZXYWZ9876543';
			$max = strlen($s) - 1 ;
			$textNumber = $turingNumber = '';
			for ($i=0; $i<4; $i++) {
				$char = $s[rand(0, $max)];
				$textNumber .= $char . ' ';
				$turingNumber .= $char;
			}
			$_SESSION['turingNumber'] = $turingNumber;
			$im = imagecreate(90, 20) or die("Cannot Initialize new GD image stream");

			$background_color = imagecolorallocate($im, 255, 255, 255);
			$text_color = imagecolorallocate($im, 90, 90, 90);
				
			//$fontId = imageloadfont(DOCROOT . 'assets/fonts/bertoltbrecht.ttf');
			$fontId = dirname(__FILE__) . '/assets/fonts/Harabara.ttf';
			
			$fontSize = 15;
				
			imagefttext($im, $fontSize, 0, 0, 17, $text_color , $fontId, $textNumber);
			//imagestring($im, 13, 0, 0, $textNumber, $text_color);
			header('Content-type: image/png');
			imagepng($im);
			imagedestroy($im);
			return $name;
		}

		static public function isValid($string) {
			return !empty($_SESSION['turingNumber']) && $string==$_SESSION['turingNumber'];
		}
	}
}