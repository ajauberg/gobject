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

/*
$log = fopen("update.log", "a");
fwrite($log, "\n\nupdate - " . gmstrftime ("%b %d %Y %H:%M:%S", $dt) . "\n");
fwrite($log,"\nIP  : "         . $IP);
fwrite($log,"\nAP : "          . $AP);
fwrite($log,"\nESSID : "       . $ESSID);
fwrite($log,"\nRATE : "        . $RATE);
fwrite($log,"\nUPTIME : "      . $UPTIME);
fwrite($log,"\nCLI : "         . $CLI);
fwrite($log,"\nREMOTE_ADDR : " . $REMOTE_ADDR);
fclose ($log);
*/

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

/*
$ESSID=	$_GET['ESSID'];
$RATE=	$_GET['RATE'];
$UPTIME=$_GET['UPTIME'];
$CLI=	$_GET['CLI'];

$prop=new CProperties();

$prop->update($new,$oid,'ESSID',$ESSID);
$prop->update($new,$oid,'RATE',$RATE);
$prop->update($new,$oid,'UPTIME',$UPTIME);
$prop->update($new,$oid,'CLI',$CLI);
*/

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

/*
	$log = fopen("peers.log", "a");
	fwrite($log, "\n\npeers - " . gmstrftime ("%b %d %Y %H:%M:%S", $dt) . "\n");
	fwrite($log,"\nMAC : "    . $MAC);
	fwrite($log,"\nQUAL : "   . $QUAL);
	fwrite($log,"\nSIG  : "   . $SIG);
	fwrite($log,"\nNOISE : "  . $NOISE);
	fclose ($log);
*/

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

