<?
/*
 Read the database configuration from the freeradius configuration file

 NOTE: Place this file outside the scope of the web server, either by placing
       it outside the web server directory, or protect it with a WEB password
*/

$config=array();
$ARR=file("../freeradius/dialup_admin/conf/admin.conf");
foreach($ARR as $val) {
	$val=chop($val);
	if (ereg('^[[:space:]]*#',$val) || ereg('^[[:space:]]*$',$val))
		continue;
	list($key,$v)=split(":[[:space:]]*",$val,2);
	if (preg_match("/%\{(.+)\}/",$v,$matches)){
		$val=$config[$matches[1]];
		$v=preg_replace("/%\{$matches[1]\}/",$val,$v);
	}
	$config["$key"]="$v";
}

// Open permanent database connection
if (!($mylink = mysql_pconnect($config['sql_server'], $config['sql_username'], $config['sql_password']))) {
	echo mysql_error();
	exit;
}
mysql_select_db($config['sql_database'],$mylink) or die(mysql_error());

// Adjust current time when server is in another time zone
function DST() {
	$tmp=strtotime("1 April");
	$sDST=date('Y-m-d H:i:s',strtotime("last Sunday 02:00",$tmp));	// Start of DST
	$tmp=strtotime("1 November");
	$eDST=date('Y-m-d H:i:s',strtotime("last Sunday 02:00",$tmp));	// End of DST

	$TZoffset="+1 hours";	// Inside DST
	$t=gmdate('Y-m-d H:i:s',strtotime($TZoffset));
	if ($sDST<$t && $t<$eDST)
		$TZoffset="+2 hours";	// Outside DST

	$t=gmdate('Y-m-d H:i:s',strtotime($TZoffset));
	return $t;
}

