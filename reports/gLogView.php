<html>
<body>
<?php
$oid=$_REQUEST['oid'];

$show_msg = <<<MSG
<h1>Signal/Noise graphs for $oid</h1>
<br clear=left>
<table width=100% cellpadding=5 padding=3 border>
<tr><td width=70%>
<h3>Summary</h3>
GEANT2 total traffic:  CE2-T1/1, CE3-T3/1 (CE3-Pos6/1)<p>
Values at last update:<br><table width=100%><tr valign=top>
<table width=100%><tr valign=top>
<table width=100%><tr valign=top>
<td><font color="#00cc00">Average bits in</font>: 2.44 Gbits/sec</td>
<td><font color="#0000ff">Average bits out</font>: 1.30 Gbits/sec</td>
</tr></table>
<p></td>
</tr></table>
<h3>Daily graph</h3>
<img src="TRX.jpgraph.php?table=gLogTRXDays&oid=$oid&dateformat=H&xtitle=Hour">
<p><h3>Weekly graph</h3>
<img src="TRX.jpgraph.php?table=gLogTRXWeeks&oid=$oid&dateformat=D&xtitle=Day">
<p><h3>Monthly graph</h3>
<img src="TRX.jpgraph.php?table=gLogTRXMonths&oid=$oid&dateformat=W&xtitle=Week">
<p><h3>Yearly graph</h3>
<img src="TRX.jpgraph.php?table=gLogTRXYears&oid=$oid&dateformat=M&xtitle=Month">
<p>
MSG;

echo $show_msg;
?>
</body>
</html>

