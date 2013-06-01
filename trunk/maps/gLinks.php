<gLinks>
<?php
require 'config.inc.php';
/*
CREATE TABLE IF NOT EXISTS `gLinks` (
  `id` int(11) NOT NULL auto_increment,
  `Name` varchar(30) NOT NULL,
  `refOid1` int(11) NOT NULL COMMENT 'First Object reference',
  `Signal1` tinyint(4) NOT NULL,
  `Noise1` tinyint(4) NOT NULL,
  `Quality1` tinyint(4) NOT NULL,
  `refOid2` int(11) NOT NULL COMMENT 'Second Object reference',
  `Signal2` tinyint(4) NOT NULL,
  `Noise2` tinyint(4) NOT NULL,
  `Quality2` tinyint(4) NOT NULL,
  `refPid` int(11) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `refOid1` (`refOid1`,`refOid2`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;
*/
$q="SELECT *,gLinks.id AS lid FROM gObjects,gLinks,gPerformances ".
	"WHERE (gObjects.id=gLinks.refOid1 ".
               "AND gLinks.refPid=gPerformances.id) ".
	"OR (gObjects.id=gLinks.refOid2 ".
               "AND gLinks.refPid=gPerformances.id) ".
	"ORDER BY gLinks.id,gObjects.id";
$r=mysql_query($q) or die(mysql_error());
$i=0;
while ($row=mysql_fetch_array($r, MYSQL_ASSOC)) {
	if ($i==0) echo 	"  <gLink id=\"".$row['lid'].
				"\" Name=\"".$row['Name'].
				"\" Lat1=\"".$row['Lat'].
				"\" Long1=\"".$row['Long'].
				"\" Signal1=\"".$row['Signal1'].
				"\" Noise1=\"".$row['Noise1'].
				"\" Quality1=\"".$row['Quality1'].
				"\"";
	if ($i==1) echo		" Lat2=\"".$row['Lat'].
				"\" Long2=\"".$row['Long'].
				"\" Signal2=\"".$row['Signal2'].
				"\" Noise2=\"".$row['Noise2'].
				"\" Quality2=\"".$row['Quality2'].
				"\" HTMLColorCode=\"".$row['HTMLColorCode'].
				"\" Width=\"".$row['Width'].
				"\" Opacity=\"".$row['Opacity'].
				"\"/>\n";
	if ($i==0) $i=1; else $i=0;
}
?>
</gLinks>

