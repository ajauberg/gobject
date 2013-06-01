<gLogs>
<?php
require 'config.inc.php';
/*
CREATE TABLE IF NOT EXISTS `gLogSNRxxxs` (
  `id` int(11) NOT NULL auto_increment,
  `refOid` int(11) NOT NULL,
  `Timestamp` datetime NOT NULL,
  `MAC` varchar(17) NOT NULL,
  `SIG` tinyint(4) NOT NULL,
  `NOISE` tinyint(4) NOT NULL,
  `QUAL` varchar(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
*/
if ($_GET['MAC']) $MAC=$_GET['MAC']; else $MAC="";
if ($_GET['table']) $table=$_GET['table']; else $table="gLogDays";
if ($_GET['oid']) $refOid=$_GET['oid']; else $refOid=0;
if ($_GET['order']) $order=$_GET['order']; else $order="id";

$q="SELECT * ".
"FROM $table ";
if (($MAC!="") || ($refOid>0)) $q.="WHERE ";
if ($MAC!="") $q.="MAC='$MAC' ";
if (($MAC!="") && ($refOid>0)) $q.="AND ";
if ($refOid>0) $q.="refOid=$refOid ";
$q.="ORDER BY $order";
//echo "$q<br>";
$r=mysql_query($q) or die(mysql_error());
while ($row=mysql_fetch_array($r, MYSQL_ASSOC)) {
	echo 	"  <gLog id=\"".$row['id'].
		"\" refOid=\"".$row['oid'].
		"\" Timestamp=\"".$row['Timestamp'].
		"\" MAC=\"".$row['MAC'].
		"\" SIG=\"".$row['SIG'].
		"\" NOISE=\"".$row['NOISE'].
		"\" QUAL=\"".$row['QUAL'].
		"\"/>\n";
}
?>
</gLogs>
