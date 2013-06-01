<gProperties>
<?php
require 'config.inc.php';
/*
CREATE TABLE IF NOT EXISTS `gProperties` (
  `id` int(11) NOT NULL auto_increment,
  `refOid` int(11) NOT NULL COMMENT 'Object reference',
  `Name` varchar(30) NOT NULL,
  `Value` varchar(80) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;
*/
$q="SELECT * FROM gProperties";
if (isset($_REQUEST['oid'])) {	// Check for oid=... in URL
	$oid=$_REQUEST['oid'];
	if ($oid!="") {
		$q.=" WHERE refOid=$oid";
	}
}
$q.=" ORDER BY refOid,id";
$r=mysql_query($q) or die(mysql_error());

$refOid=0;
while ($row=mysql_fetch_array($r, MYSQL_ASSOC)) {
	if ($refOid!=$row['refOid']) {
		if ($refOid>0) {
			echo "/>\n";
		}
		$refOid=$row['refOid'];
		echo "  <gProperty id=\"".$refOid."\"";
	}
	echo " ".$row['Name']."=\"".$row['Value']."\"";
}
if ($refOid>0) {
	echo "/>\n";
}
?>
</gProperties>

