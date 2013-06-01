<gLogs>
<?php
require 'config.inc.php';
/*
CREATE TABLE IF NOT EXISTS `gLogs` (
  `id` int(11) NOT NULL auto_increment,
  `refOid` int(11) NOT NULL,
  `Timestamp` datetime NOT NULL,
  `Message` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
*/
if ($_GET['lastLogId']) $lastLogId=$_GET['lastLogId']; 
else { 
	$lastLogId=0;
	$q="SELECT MAX(id) AS id FROM gLogs";
	$r=mysql_query($q) or die(mysql_error());

	while ($row=mysql_fetch_array($r, MYSQL_ASSOC)) {
		$lastLogId=$row['id'];
	}
}

$q="SELECT * FROM gLogs ";
if (isset($_GET['oid'])) {	// Check for oid=... in URL
	$oid=$_GET['oid'];
	if ($oid!="") {
		$q.="WHERE refOid=$oid ";
	}
}
$q.="ORDER BY refOid,id";
$r=mysql_query($q) or die(mysql_error());

while ($row=mysql_fetch_array($r, MYSQL_ASSOC)) {
	echo 	"  <gLog id=\"".$row['id'].
		"\" refOid=\"".$row['refOid'].
		"\" Message=\"".$row['Message'].
		"\" Timestamp=\"".$row['Timestamp'].
		"\"/>\n";
}
?>
</gLogs>

