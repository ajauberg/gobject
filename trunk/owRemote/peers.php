<?php
require 'config.inc.php';

$AP	=$_REQUEST['AP'];
$MAC	=$_REQUEST['MAC'];
$SIG	=$_REQUEST['SIG'];
$NOISE	=$_REQUEST['NOISE'];
$QUAL	=$_REQUEST['QUAL'];
$QUAL	=$SIG-$NOISE;
$dt	=DST();
$REMOTE_ADDR=$_SERVER['REMOTE_ADDR'];
/*
$log = fopen("peers.log", "a");
fwrite($log, "\n\npeers - " . gmstrftime ("%b %d %Y %H:%M:%S", $dt) . "\n");
fwrite($log,"\nAP  : "    . $AP);
fwrite($log,"\nMAC : "    . $MAC);
fwrite($log,"\nQUAL : "   . $QUAL);
fwrite($log,"\nSIG  : "   . $SIG);
fwrite($log,"\nNOISE : "  . $NOISE);
fclose ($log);
*/

/*
Windows Signal Level
 Signal to Noise Ratio 
 Data Rates
 
Excellent
 26 dBm and above
 11Mpbs
 
Very Good
 25dBm  to 21dBm
 11Mpbs
 
Good
 20dBm to 16dBm
 11Mpbs
 
Low
 15dBm to 11dBm
 11Mpbs
 
Very Low
 10dBm to 9dBm
 5.5Mbps
 
Very Low
 8dBm to 7dBm
 2Mbps
 
Very Low
 6 dBm and under
 1Mbps
*/ 

$q="UPDATE gLinks ".
	"SET Signal1='$SIG',Noise1='$NOISE',Quality1='$QUAL' ".
	"WHERE (SELECT id FROM gObjects WHERE MAC='$AP') ".
	"=gLinks.refOid1 ".
	"AND (SELECT id FROM gObjects WHERE MAC='$MAC') ".
	"=gLinks.refOid2";
$r=mysql_query($q) or die(mysql_error());

$q="UPDATE gLinks ".
	"SET Signal2='$SIG',Noise2='$NOISE',Quality2='$QUAL' ".
	"WHERE (SELECT id FROM gObjects WHERE MAC='$AP') ".
	"=gLinks.refOid2 ".
	"AND (SELECT id FROM gObjects WHERE MAC='$MAC') ".
	"=gLinks.refOid1";
$r=mysql_query($q) or die(mysql_error());


