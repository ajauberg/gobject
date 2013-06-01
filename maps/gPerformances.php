<gPerformances>
<?php
require 'config.inc.php';
/*
CREATE TABLE IF NOT EXISTS `gPerformances` (
  `id` int(11) NOT NULL auto_increment,
  `Name` varchar(30) NOT NULL,
  `HTMLColorCode` varchar(20) NOT NULL,
  `Width` int(11) NOT NULL,
  `Opacity` float NOT NULL,
  `Rate` int(11) NOT NULL,
  `SNR` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;
*/
$q="SELECT * FROM gPerformances ORDER BY id";
$r=mysql_query($q) or die(mysql_error());
while ($row=mysql_fetch_array($r, MYSQL_ASSOC)) {
	echo 	"  <gPerformace id=\"".$row['id'].
		"\" Name=\"".$row['Name'].
		"\" HTMLColorCode=\"".$row['HTMLColorCode'].
		"\" Width=\"".$row['Width'].
		"\" Opacity=\"".$row['Opacity'].
		"\" Rate=\"".$row['Rate'].
		"\" SNR=\"".$row['SNR'].
		"\"/>\n";
}
?>
</gPerformances>
