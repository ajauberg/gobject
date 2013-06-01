<?require 'config.inc.php';

$AP	=$_REQUEST['AP'];
$MAC	=$_REQUEST['MAC'];
$dBm	=$_REQUEST['dBm'];
$dt	=$_REQUEST['dt'];

$q="UPDATE gObjects SET LastContact='$dt' WHERE Ethernet='$AP'";
$r=mysql_query($q) or die(mysql_error());

$log = fopen("clients.log", "a");
fwrite($log, "\n\nclients - " . gmstrftime ("%b %d %Y %H:%M:%S", time()) . "\n");
fwrite($log,"\nAP  : " . $AP);
fwrite($log,"\nMAC : " . $MAC);
fwrite($log,"\ndBm : " . $dBm);
fwrite($log,"\ndt  : " . $dt);
fclose ($log);
?>


