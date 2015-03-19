# Introduction #

The following PHP files are used:

| **update.php** | Called from the wireless nodes with node data |
|:---------------|:----------------------------------------------|
| **sync.php** | Called at regular intervals to update node and link status |
| **icon.php** | Creates the icons used in the Google Maps markers |
| **config.inc.php** | Reads the configuration file |

| **gCObjects.inc.php** | A class for reading and updating the gObjects table |
|:----------------------|:----------------------------------------------------|
| **gCProperties.inc.php** | A class for reading and updating the gProperties table |
| **gCStatuses.inc.php** | A class for reading and updating the gStatuses table |
| **gCPerformances.inc.php** | A class for reading and updating the gPerformances table |

| **gCLogs.inc.php** | Classes for updating and compressing the gLogs, gLogSNR and gLogTRX tables |
|:-------------------|:---------------------------------------------------------------------------|

| **gClasses.xml.php** | Returns an XML formatted file containing information from the gClasses table |
|:---------------------|:-----------------------------------------------------------------------------|
| **gObjects.xml.php** | Returns an XML formatted file containing information from the gObjects and gClasses tables |
| **gLinks.xml.php** | Returns an XML formatted file containing information from the gLinks, gObjects and gPerformances tables |
| **gLogs.xml.php** | Returns an XML formatted file containing information from the gLogs table |
| **gPerformances.xml.php** | Returns an XML formatted file containing information from the gPerformances table |
| **gProperties.xml.php** | Returns an XML formatted file containing information from the gProperties table |
| **gStatuses.xml.php** | Returns an XML formatted file containing information from the gStatuses table |

| **gObjectView.php** | A list of all objects |
|:--------------------|:----------------------|
| **gLogView.php** | An overview of a specific object |
| **SNR.jpgraph.php** | A file utilizing JPGraph for generating a report on Quality, Signal and Noise data |
| **TRX.jpgraph.php** | A file utilizing JPGraph for generating a report on transmission data |
| **gLogSNR.xml.php** | A XML-formatted file containing Quality, Signal and Noise data |
| **gLogTRX.xml.php** | A XML-formatted file containing transmission data |

# update.php #

```
<?php

require('config.inc.php');

$REMOTE_ADDR=$_SERVER['REMOTE_ADDR'];

$IP=	$_GET['IP'];
$AP=	$_GET['AP'];
$ESSID=	$_GET['ESSID'];
$RATE=	$_GET['RATE'];		if (!$RATE) $RATE=0;
$UPTIME=$_GET['UPTIME'];	if (!$UPTIME) $UPTIME=0;
$CLI=	$_GET['CLI'];		if (!$CLI) $CLI=0;

$dt	=DST();

$q="SELECT * FROM gObjects WHERE MAC='$AP'";
echo "q: ".$q."<br>";
$r=mysql_query($q) or die(mysql_error());
if ($row=mysql_fetch_array($r, MYSQL_ASSOC)) {
	$oid=$row["id"];
} else {
	$oid=0;
}

$t=DST();
if ($oid>0) {
	$q="UPDATE gObjects SET IP='$IP',REMOTE_ADDR='$REMOTE_ADDR',ESSID='$ESSID',RATE=$RATE,UPTIME=$UPTIME,CLI=$CLI,LastContact='$t' WHERE id=$oid";
	echo "q: ".$q."<br>";
	$r=mysql_query($q) or die(mysql_error());
} else {
	$q="INSERT gObjects (MAC,IP,REMOTE_ADDR,ESSID,RATE,UPTIME,CLI,LastContact) VALUES ('$AP','$IP','$REMOTE_ADDR','$ESSID',$RATE,$UPTIME,$CLI,'$t')";
	echo "q: ".$q."<br>";
	$r=mysql_query($q) or die(mysql_error());
	$id=mysql_insert_id();
}

if ($oid>0) {
	$q="UPDATE gProperties SET Value='$ESSID' WHERE refOid=$oid AND Name='ESSID'";
} else {
	$q="INSERT gProperties (refOid,Name,Value) VALUES ($id,'ESSID','$ESSID')";
}
echo "q: ".$q."<br>";
$r=mysql_query($q) or die(mysql_error());

if ($oid>0) {
	$q="UPDATE gProperties SET Value='$RATE' WHERE refOid=$oid AND Name='RATE'";
} else {
	$q="INSERT gProperties (refOid,Name,Value) VALUES ($id,'RATE','$RATE')";
}
echo "q: ".$q."<br>";
$r=mysql_query($q) or die(mysql_error());

if ($oid>0) {
	$q="UPDATE gProperties SET Value='$CLI' WHERE refOid=$oid AND Name='CLI'";
} else {
	$q="INSERT gProperties (refOid,Name,Value) VALUES ($id,'CLI','$CLI')";
}
echo "q: ".$q."<br>";
$r=mysql_query($q) or die(mysql_error());

$RXP=	$_GET['RXP'];	// RX packets
$RXe=	$_GET['RXe'];	// RX errors
$RXd=	$_GET['RXd'];	// RX dropped
$RXo=	$_GET['RXo'];	// RX overruns
$RXf=	$_GET['RXf'];	// RX frames
$RXb=	$_GET['RXb'];	// RX bytes

$TXP=	$_GET['TXP'];	// TX packets
$TXe=	$_GET['TXe'];	// TX errors
$TXd=	$_GET['TXd'];	// TX dropped
$TXo=	$_GET['TXo'];	// TX overruns
$TXc=	$_GET['TXc'];	// TX carriers
$TXco=	$_GET['TXco'];	// TX collisions
$TXq=	$_GET['TXq'];	// TX queue length
$TXb=	$_GET['TXb'];	// TX bytes

$table="gLogTRXDays";
$q="INSERT $table(refOid,Timestamp,RATE,UPTIME,CLI,RXP,RXe,RXd,RXo,RXf,RXb,TXP,TXe,TXd,TXo,TXc,TXco,TXq,TXb) ".
	"VALUES($oid,'$t',$RATE,$UPTIME,$CLI,$RXP,$RXe,$RXd,$RXo,$RXf,$RXb,$TXP,$TXe,$TXd,$TXo,$TXc,$TXco,$TXq,$TXb)";
echo "q: $q<br>";
$r=mysql_query($q) or die(mysql_error());

$MACARR		=$_GET['MAC'];
$SIGARR		=$_GET['SIG'];
$NOISEARR	=$_GET['NOISE'];
$QUALARR	=$_GET['QUAL'];

for ($i=0;$i<count($MACARR);$i++)
{
	$MAC	=$MACARR[$i];
	$SIG	=$SIGARR[$i];
	$NOISE	=$NOISEARR[$i];
	$QUAL	=$QUALARR[$i];

	$q="INSERT gLogDays (refOid,Timestamp,MAC,SIG,NOISE,QUAL) VALUES ($oid,'$t','$MAC',$SIG,$NOISE,'$QUAL')";
	echo "q: $q<br>";
	$r=mysql_query($q) or die(mysql_error());

	$QUAL=$SIG-$NOISE;
	$q="UPDATE gLinks ".
		"SET Signal1='$SIG',Noise1='$NOISE',Quality1='$QUAL' ".
		"WHERE (SELECT id FROM gObjects WHERE MAC='$AP') ".
		"=gLinks.refOid1 ".
		"AND (SELECT id FROM gObjects WHERE MAC='$MAC') ".
		"=gLinks.refOid2";
	echo "q: $q<br>";
	$r=mysql_query($q) or die(mysql_error());
	
	$q="UPDATE gLinks ".
		"SET Signal2='$SIG',Noise2='$NOISE',Quality2='$QUAL' ".
		"WHERE (SELECT id FROM gObjects WHERE MAC='$AP') ".
		"=gLinks.refOid2 ".
		"AND (SELECT id FROM gObjects WHERE MAC='$MAC') ".
		"=gLinks.refOid1";
	echo "q: $q<br>";
	$r=mysql_query($q) or die(mysql_error());
}
```

# sync.php #

```
<?php

require('config.inc.php');
require('gLogs.inc.php');

$dt=strtotime(DST());

// Set the object status colors

$Th1=DST();	// Lowest Threshold
$Th2=DST();	// Highest Threshold
$sid=0;		// gStatuses id

$q="SELECT * FROM gStatuses ORDER BY id";
$r1=mysql_query($q) or die(mysql_error());
while ($row=mysql_fetch_array($r1, MYSQL_ASSOC)) {
	$sid=$row['id'];
	$Th1=date('Y-m-d H:i:s',$dt-$row['InactivityThreshold']);
	echo "Th1: $Th1 Th2: $Th2 sid: $sid dt: $dt<br>";

	$q="UPDATE gObjects SET refSid=$sid WHERE '$Th1'< LastContact AND LastContact<='$Th2'";
	echo "q: $q<br>";
	$r2=mysql_query($q) or die(mysql_error());
	$Th2=$Th1;
}
echo "Th1: $Th1 Th2: $Th2 sid: $sid<br>";
$q="UPDATE gObjects SET refSid=$sid WHERE LastContact<='$Th2'";
echo "q: $q<br>";
$r2=mysql_query($q) or die(mysql_error());

// Set the link performance colors

$SNR1=-1;	// Lowest SNR
$SNR2=-1;	// Highest SNRs
$pid=0;		// gPerformances id

$q="SELECT * FROM gPerformances ORDER BY id";
$r1=mysql_query($q) or die(mysql_error());
while ($row=mysql_fetch_array($r1, MYSQL_ASSOC)) {
	$pid=$row['id'];
	$SNR2=$row['SNR'];
	echo "SNR1: $SNR1 SNR2: $SNR2 pid: $pid<br>";

	$q="UPDATE gLinks SET refPid=$pid ".
	"WHERE $SNR1<(Quality1+Quality2)/2 ".
	"AND (Quality1+Quality2)/2<=$SNR2 ".
	"AND Quality1>0 ".
	"AND Quality2>0";
	echo "q: $q<br>";
	$r2=mysql_query($q) or die(mysql_error());
	$SNR1=$SNR2;
}

// Compress the performance log files

$log=new CLogs();
$log->update($dt);

$trxlog=new CTRXLogs();
$trxlog->update($dt);
```

# icon.php #

```
<?
require 'config.inc.php';

header("Content-type: image/png");

if ($_GET['oid']) $oid=$_GET['oid']; else $oid=0;

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
$im = imagecreatefrompng($image);
if (!$im) {
	$image="markers/pushpins/templates/marker.png";
	$im = imagecreatefrompng($image);
}

imageAlphaBlending($im, true);
imageSaveAlpha($im, true);

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
```