#!/usr/local/bin/php
<?php
$index = $_GET['index'];
header("Content-type: image/jpeg");
$temp = '/cise/homes/njiang/public_html/images/tmp' . $index . '.jpg';
$jpeg = fopen($temp,"r");
$image = fread($jpeg,filesize($temp));
echo $image;
unlink($temp);

?>