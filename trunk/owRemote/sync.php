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


