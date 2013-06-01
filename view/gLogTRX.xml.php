<gLogs>
<?php
require 'config.inc.php';
/*
CREATE TABLE IF NOT EXISTS `gLogTRXxxxs` (
  `id` int(11) NOT NULL auto_increment,
  `refOid` int(11) NOT NULL,
  `Timestamp` datetime NOT NULL,
  `RATE` int(11) NOT NULL,
  `UPTIME` int(11) NOT NULL,
  `CLI` int(11) NOT NULL,
  `RXP` int(11) NOT NULL,
  `RXe` int(11) NOT NULL,
  `RXd` int(11) NOT NULL,
  `RXo` int(11) NOT NULL,
  `RXf` int(11) NOT NULL,
  `RXb` int(11) NOT NULL,
  `TXP` int(11) NOT NULL,
  `TXe` int(11) NOT NULL,
  `TXd` int(11) NOT NULL,
  `TXo` int(11) NOT NULL,
  `TXc` int(11) NOT NULL,
  `TXco` int(11) NOT NULL,
  `TXq` int(11) NOT NULL,
  `TXb` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
*/
if ($_GET['table']) $table=$_GET['table']; else $table="gLogTRXDays";
if ($_GET['oid']) $refOid=$_GET['oid']; else $refOid=0;
if ($_GET['order']) $order=$_GET['order']; else $order="id";

$q="SELECT * ".
"FROM $table ";
if ($refOid>0) $q.="WHERE refOid=$refOid ";
$q.="ORDER BY $order";
//echo "$q<br>";

$UPTIME1=0;
$UPTIME2=0;
$r=mysql_query($q) or die(mysql_error());
while ($row=mysql_fetch_array($r, MYSQL_ASSOC)) {
	$UPTIME2=$row['UPTIME'];
	$RXP2=$row['RXP'];
	$RXe2=$row['RXe'];
	$RXd2=$row['RXd'];
	$RXo2=$row['RXo'];
	$RXf2=$row['RXf'];
	$RXb2=$row['RXb'];
	$TXP2=$row['TXP'];
	$TXe2=$row['TXe'];
	$TXd2=$row['TXd'];
	$TXo2=$row['TXo'];
	$TXc2=$row['TXc'];
	$TXco2=$row['TXco'];
	$TXq2=$row['TXq'];
	$TXb2=$row['TXb'];

	if ($UPTIME1>=$UPTIME2)
	{	// Restart
		$UPTIME=$UPTIME2;

		$RXP=$RXP2/$UPTIME;
		$RXe=$RXe2/$UPTIME;
		$RXd=$RXd2/$UPTIME;
		$RXo=$RXo2/$UPTIME;
		$RXf=$RXf2/$UPTIME;
		$RXb=$RXb2/$UPTIME;
		$TXP=$TXP2/$UPTIME;
		$TXe=$TXe2/$UPTIME;
		$TXd=$TXd2/$UPTIME;
		$TXo=$TXo2/$UPTIME;
		$TXc=$TXc2/$UPTIME;
		$TXco=$TXco2/$UPTIME;
		$TXq=$TXq2/$UPTIME;
		$TXb=$TXb2/$UPTIME;
	}
	else
	{
		$UPTIME=$UPTIME2-$UPTIME1;

		$RXP=($RXP2-$RXP1)/$UPTIME;
		$RXe=($RXe2-$RXe1)/$UPTIME;
		$RXd=($RXd2-$RXd1)/$UPTIME;
		$RXo=($RXo2-$RXo1)/$UPTIME;
		$RXf=($RXf2-$RXf1)/$UPTIME;
		$RXb=($RXb2-$RXb1)/$UPTIME;
		$TXP=($TXP2-$TXP1)/$UPTIME;
		$TXe=($TXe2-$TXe1)/$UPTIME;
		$TXd=($TXd2-$TXd1)/$UPTIME;
		$TXo=($TXo2-$TXo1)/$UPTIME;
		$TXc=($TXc2-$TXc1)/$UPTIME;
		$TXco=($TXco2-$TXco1)/$UPTIME;
		$TXq=($TXq2-$TXq1)/$UPTIME;
		$TXb=($TXb2-$TXb1)/$UPTIME;
	}

	$UPTIME1=$UPTIME2;
	$RXP1=$RXP2;
	$RXe1=$RXe2;
	$RXd1=$RXd2;
	$RXo1=$RXo2;
	$RXf1=$RXf2;
	$RXb1=$RXb2;
	$TXP1=$TXP2;
	$TXe1=$TXe2;
	$TXd1=$TXd2;
	$TXo1=$TXo2;
	$TXc1=$TXc2;
	$TXco1=$TXco2;
	$TXq1=$TXq2;
	$TXb1=$TXb2;

	echo 	"  <gLog id=\"".$row['id'].
		"\" refOid=\"".$row['refOid'].
		"\" Timestamp=\"".$row['Timestamp'].
		"\" RATE=\"".$row['RATE'].
		"\" UPTIME=\"".$row['UPTIME'].
		"\" CLI=\"".$row['CLI'].
		"\" RXP=\"".$RXP.
		"\" RXe=\"".$RXe.
		"\" RXd=\"".$RXd.
		"\" RXo=\"".$RXo.
		"\" RXf=\"".$RXf.
		"\" RXb=\"".$RXb.
		"\" TXP=\"".$TXP.
		"\" TXe=\"".$TXe.
		"\" TXd=\"".$TXd.
		"\" TXo=\"".$TXo.
		"\" TXc=\"".$TXc.
		"\" TXco=\"".$TXco.
		"\" TXq=\"".$TXq.
		"\" TXb=\"".$TXb.
		"\"/>\n";
}
?>
</gLogs>

