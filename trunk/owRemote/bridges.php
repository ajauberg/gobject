<?require 'config.inc.php';

$AP	=$_GET['AP'];
$MAC	=$_GET['MAC'];
$QUAL	=$_GET['QUAL'];
$SIG	=$_GET['SIG'];
$NOISE	=$_GET['NOISE'];
$UPTIME	=$_GET['UPTIME'];
$CLI	=$_GET['CLI'];
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


