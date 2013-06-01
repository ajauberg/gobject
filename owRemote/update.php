<?php

require('config.inc.php');

$REMOTE_ADDR=$_SERVER['REMOTE_ADDR'];

$IP=	$_REQUEST['IP'];
$AP=	$_REQUEST['AP'];
$ESSID=	$_REQUEST['ESSID'];
$RATE=	$_REQUEST['RATE'];	if (!$RATE) $RATE=0;
$UPTIME=$_REQUEST['UPTIME'];	if (!$UPTIME) $UPTIME=0;
$CLI=	$_REQUEST['CLI'];	if (!$CLI) $CLI=0;

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
$ESSID=	$_REQUEST['ESSID'];
$RATE=	$_REQUEST['RATE'];
$UPTIME=$_REQUEST['UPTIME'];
$CLI=	$_REQUEST['CLI'];

$prop=new CProperties();

$prop->update($new,$oid,'ESSID',$ESSID);
$prop->update($new,$oid,'RATE',$RATE);
$prop->update($new,$oid,'UPTIME',$UPTIME);
$prop->update($new,$oid,'CLI',$CLI);
*/

$RXP=	$_REQUEST['RXP'];	// RX packets
$RXe=	$_REQUEST['RXe'];	// RX errors
$RXd=	$_REQUEST['RXd'];	// RX dropped
$RXo=	$_REQUEST['RXo'];	// RX overruns
$RXf=	$_REQUEST['RXf'];	// RX frames
$RXb=	$_REQUEST['RXb'];	// RX bytes

$TXP=	$_REQUEST['TXP'];	// TX packets
$TXe=	$_REQUEST['TXe'];	// TX errors
$TXd=	$_REQUEST['TXd'];	// TX dropped
$TXo=	$_REQUEST['TXo'];	// TX overruns
$TXc=	$_REQUEST['TXc'];	// TX carriers
$TXco=	$_REQUEST['TXco'];	// TX collisions
$TXq=	$_REQUEST['TXq'];	// TX queue length
$TXb=	$_REQUEST['TXb'];	// TX bytes

$table="gLogTRXDays";
$q="INSERT $table(refOid,Timestamp,RATE,UPTIME,CLI,RXP,RXe,RXd,RXo,RXf,RXb,TXP,TXe,TXd,TXo,TXc,TXco,TXq,TXb) ".
	"VALUES($oid,'$t',$RATE,$UPTIME,$CLI,$RXP,$RXe,$RXd,$RXo,$RXf,$RXb,$TXP,$TXe,$TXd,$TXo,$TXc,$TXco,$TXq,$TXb)";
echo "q: $q<br>";
$r=mysql_query($q) or die(mysql_error());

$MACARR		=$_REQUEST['MAC'];
$SIGARR		=$_REQUEST['SIG'];
$NOISEARR	=$_REQUEST['NOISE'];
$QUALARR	=$_REQUEST['QUAL'];

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

