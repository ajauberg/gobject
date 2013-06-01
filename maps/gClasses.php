<gClasses>
<?php
require 'config.inc.php';
/*
CREATE TABLE IF NOT EXISTS `gClasses` (
  `id` int(11) NOT NULL auto_increment,
  `Name` varchar(30) NOT NULL,
  `Icon` varchar(80) NOT NULL COMMENT 'Pathname to graphic icon',
  `Image` varchar(80) NOT NULL COMMENT 'Pathname to graphic file',
  `Shadow` varchar(80) NOT NULL COMMENT 'Pathname to graphic file',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `Name` (`Name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;
*/
$q="SELECT * FROM gClasses ORDER BY id";
$r=mysql_query($q) or die(mysql_error());
while ($row=mysql_fetch_array($r, MYSQL_ASSOC)) {
	echo 	"  <gClass id=\"".$row['id'].
		"\" Name=\"".$row['Name'].
		"\" Icon=\"".$row['Icon'].
		"\" Image=\"".$row['Image'].
		"\" Shadow=\"".$row['Shadow'].
		"\"/>\n";
}
?>
</gClasses>

