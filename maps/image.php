<?
require 'config.inc.php';

/*
The included is a script which is free to use to generate colored numbered markers using php and the free set of colored markers found here http://people.vanderbilt.edu/~sam.kuhn/gmaps/index.html

usage example:
http://myserver/markers/numbered_marker.php?image=markers/pushpins/webhues/087.png&text=99
http://myserver/markers/numbered_marker.php?image=markers/pushpins/webhues/087.png&text=a
http://myserver/markers/numbered_marker.php?image=markers/pushpins/webhues/087.png&text=101

Script by Ali Mohammad and Alex Gruenstein
*/

header("Content-type: image/png");

$oid = 0;
if ($_REQUEST['oid']) $oid = $_REQUEST['oid'];
if ($_POST['oid']) $oid = $_POST['oid'];

$q=	"SELECT Image,gObjects.Name as Name ".
	"FROM gObjects,gClasses ".
	"WHERE gObjects.refCid=gClasses.id ".
	"AND gObjects.id=$oid";

$r=mysql_query($q) or die(mysql_error());
while ($row=mysql_fetch_array($r, MYSQL_ASSOC)) {
	$image_name = $row['Image'];
	$string = $row['Name'];
}
$image_name="markers/pushpins/templates/marker.png";  //fixme

$im = imagecreatefrompng($image_name);

imageAlphaBlending($im, true);
imageSaveAlpha($im, true);

//$string = $_REQUEST['text'];
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

