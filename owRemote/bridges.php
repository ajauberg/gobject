<?require 'config.inc.php';

$AP	=$_REQUEST['AP'];
$MAC	=$_REQUEST['MAC'];
$QUAL	=$_REQUEST['QUAL'];
$SIG	=$_REQUEST['SIG'];
$NOISE	=$_REQUEST['NOISE'];
$UPTIME	=$_REQUEST['UPTIME'];
$CLI	=$_REQUEST['CLI'];
$dt	=DST();

$q="UPDATE gObjects SET LastContact='$dt' WHERE Ethernet='$AP'";
$r=mysql_query($q) or die(mysql_error());

$log = fopen("bridges.log", "a");
fwrite($log, "\n\nbridges - " . gmstrftime ("%b %d %Y %H:%M:%S", $dt) . "\n");
fwrite($log,"\nAP  : "    . $AP);
fwrite($log,"\nMAC : "    . $MAC);
fwrite($log,"\nQUAL : "   . $QUAL);
fwrite($log,"\nSIG  : "   . $AP);
fwrite($log,"\nNOISE : "  . $MAC);
fwrite($log,"\nUPTIME : " . $QUAL);
fwrite($log,"\nCLI : "    . $CLI);
fclose ($log);
?>


