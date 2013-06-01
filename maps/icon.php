<?
require 'config.inc.php';

header("Content-type: image/png");

if ($_REQUEST['oid']) $oid=$_REQUEST['oid']; else $oid=0;

$q=	"SELECT gObjects.Name as Name,Image,Shadow,Color,HTMLColorCode,MarkerColorCode ".
	"FROM gObjects,gClasses,gStatuses ".
	"WHERE gObjects.refCid=gClasses.id ".
	"AND gObjects.refSid=gStatuses.id ".
	"AND gObjects.id=$oid";

$r=mysql_query($q) or die(mysql_error());
while ($row=mysql_fetch_array($r, MYSQL_ASSOC)) {
	$name = $row['Name'];
	$image = $row['Image'];
	$shadow = $row['Shadow'];
	$color = $row['Color'];
	$htmlcolorcode = $row['HTMLColorCode'];
	$markercolorcode = $row['MarkerColorCode'];
}	

$image=$image.$markercolorcode.".png";
/*
$dt=DST();
$log = fopen("icon.log", "a");
fwrite($log, "\n\nicon - " . gmstrftime ("%b %d %Y %H:%M:%S", $dt) . "\n");
fwrite($log,"\nimage  : "    . $image);
fwrite($log,"\noid    : "    . $oid);
fwrite($log,"\color   : "    . $color);
fclose ($log);
*/
$im = imagecreatefrompng($image);
if (!$im) {
	$image="markers/pushpins/templates/marker.png";
	$im = imagecreatefrompng($image);
}

imageAlphaBlending($im, true);
imageSaveAlpha($im, true);

//$string = $_REQUEST['text'];
//$orange = imagecolorallocate($im, 220, 210, 60);
//$colorcodes=sscanf($htmlcolorcode, '#%2x%2x%2x');
//$im=imagecolorallocate($im,$colorcodes[0],$colorcodes[1],$colorcodes[2]);

$black = imagecolorallocate($im, 0, 0, 0);

$len = strlen($name);

if($len <= 2) {
  $px = (imagesx($im) - 7 * strlen($name)) / 2 + 1;
  imagestring($im, 3, $px, 3, $name, $black);
} else {
  $px = (imagesx($im) - 7 * strlen($name)) / 2 + 2;
  imagestring($im, 2, $px, 3, $name, $black);
}

imagepng($im);
imagedestroy($im);

