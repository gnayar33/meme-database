#!/usr/local/bin/php
<?php
<<<<<<< HEAD
	$index = $_GET['index'];
	header("Content-type: image/jpeg");
	$temp = '/cise/homes/njiang/public_html/images/tmp' . $index . '.jpg';
	$jpeg = fopen($temp,"r");
	$image = fread($jpeg,filesize($temp));
	echo $image;
	unlink($temp);
=======
$index = $_GET['index'];
header("Content-type: image/jpeg");
$temp = '/cise/homes/njiang/public_html/images/tmp' . $index . '.jpg';
$jpeg = fopen($temp,"r");
$image = fread($jpeg,filesize($temp));
echo $image;
unlink($temp);
>>>>>>> 1c4a0399a35cd965e4ed5b9c46338b24ad7d5f74

?>