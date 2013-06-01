<gObjects>
<?php
require 'config.inc.php';
/*
CREATE TABLE IF NOT EXISTS `gObjects` (
  `id` int(11) NOT NULL auto_increment,
  `Name` varchar(30) NOT NULL,
  `MAC` varchar(17) NOT NULL COMMENT 'MAC Address',
  `IP` varchar(15) NOT NULL,
  `REMOTE_ADDR` varchar(15) NOT NULL,
  `ESSID` varchar(30) NOT NULL,
  `RATE` smallint(6) NOT NULL,
  `UPTIME` int(6) NOT NULL,
  `CLI` tinyint(4) NOT NULL,
  `LastContact` datetime default NULL,
  `Reboot` tinyint(1) NOT NULL default '0',
  `Lat` float(16,12) NOT NULL COMMENT 'Map Latitude',
  `Long` float(16,12) NOT NULL COMMENT 'Map Longitude',
  `refCid` int(11) NOT NULL default '1' COMMENT 'Class reference',
  `refUid` int(11) NOT NULL default '1' COMMENT 'User reference',
  `refSid` int(11) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `Ethernet` (`MAC`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

*/
$q=	"SELECT *,gObjects.id AS oid,gObjects.Name AS oName ".
	"FROM gObjects,gClasses ".
	"WHERE gObjects.refCid=gClasses.id ".
	"ORDER BY gObjects.id";
$r=mysql_query($q) or die(mysql_error());
while ($row=mysql_fetch_array($r, MYSQL_ASSOC)) {
	$o="  <gObject id=\"".$row['oid'].
	"\" Name=\"".$row['oName'].
	"\" MAC=\"".$row['MAC'].
	"\" IP=\"".$row['IP'].
	"\" REMOTE_ADDR=\"".$row['REMOTE_ADDR'].
	"\" ESSID=\"".$row['ESSID'].
	"\" RATE=\"".$row['RATE'].
	"\" UPTIME=\"".$row['UPTIME'].
	"\" CLI=\"".$row['CLI'].
	"\" LastContact=\"".$row['LastContact'].
	"\" Reboot=\"".$row['Reboot'].
	"\" Lat=\"".$row['Lat'].
	"\" Long=\"".$row['Long'];
	if ($row['Icon']=='icon.php' ) {
		$o.="\" Image=\"".$row['Icon']."?oid=".$row['oid'].
		"\" Shadow=\"".$row['Shadow']."?oid=".$row['oid'];
	} else {
		$o.="\" Image=\"".$row['Image'].
		"\" Shadow=\"".$row['Shadow'];
	}
	$o.="\" refCid=\"".$row['refCid'].
	"\" refUid=\"".$row['refUid'].
	"\" refSid=\"".$row['refSid'].
	"\"/>\n";
	echo $o;
}
?>
</gObjects>

