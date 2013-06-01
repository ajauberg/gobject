<?php

header("Content-type: image/png");

$image_name = $_GET['image'];


$im = imagecreatefrompng($image_name);

imageAlphaBlending($im, true);
imageSaveAlpha($im, true);

$string = $_GET['text'];
//$orange = imagecolorallocate($im, 220, 210, 60);
$black = imagecolorallocate($im, 0, 0, 0);

$len = strlen($string);

if($len <= 2) {
  $px = (imagesx($im) - 7 * strlen($string)) / 2 + 1;
  imagestring($im, 3, $px, 3, $string, $black);
} else {
  $px = (imagesx($im) - 7 * strlen($string)) / 2 + 2;
  imagestring($im, 2, $px, 3, $string, $black);
}

imagepng($im);
imagedestroy($im);

?>

