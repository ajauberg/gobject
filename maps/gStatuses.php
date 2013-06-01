<gStatuses>
<?php
require 'config.inc.php';
/*
CREATE TABLE IF NOT EXISTS `gStatuses` (
  `id` int(11) NOT NULL auto_increment,
  `Name` varchar(30) NOT NULL,
  `Color` varchar(20) NOT NULL,
  `HTMLColorCode` varchar(20) NOT NULL,
  `MarkerColorCode` varchar(20) NOT NULL,
  `InactivityThreshold` varchar(20) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;*/
$q="SELECT * FROM gStatuses ORDER BY id";
$r=mysql_query($q) or die(mysql_error());
while ($row=mysql_fetch_array($r, MYSQL_ASSOC)) {
	echo 	"  <gStatus id=\"".$row['id'].
		"\" Name=\"".$row['Name'].
		"\" HTMLColorCode=\"".$row['HTMLColorCode'].
		"\" MarkerColorCode=\"".$row['MarkerColorCode'].
		"\" InactivityThreshold=\"".$row['InactivityThreshold'].
		"\"/>\n";
}
?>
</gStatuses>
