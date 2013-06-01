<?
/*

CREATE TABLE voteoptions;
+----+-----------+-------+
| id | name      | value |
+----+-----------+-------+
|  1 | Hat       | hat   |
|  2 | Tee shirt | shirt |
|  3 | Pants     | pants |
|  4 | Mug       | mug   |
+----+-----------+-------+

CREATE TABLE votes
+----+-----------+-------+
| id | ip        | vote  |
+----+-----------+-------+
|  1 | 127.0.0.1 | hat   |
|  2 | 127.0.0.1 | shirt |
|  3 | 127.0.0.1 | hat   |
|  4 | 127.0.0.1 | mug   |
|  5 | 127.0.0.1 | pants |
|  6 | 127.0.0.1 | shirt |
|  7 | 127.0.0.1 | mug   |
|  8 | 127.0.0.1 | hat   |
|  9 | 127.0.0.1 | pants |
| 10 | 127.0.0.1 | shirt |
| 11 | 127.0.0.1 | mug   |
| 12 | 127.0.0.1 | pants |
| 13 | 127.0.0.1 | pants |
| 14 | 127.0.0.1 | shirt |
| 15 | 127.0.0.1 | hat   |
| 16 | 127.0.0.1 | shirt |
| 17 | 127.0.0.1 | hat   |
| 18 | 127.0.0.1 | mug   |
+----+-----------+-------+
*/

header ("Content-type: image/png");
//$im = imagecreatefrompng ("graphtemp.png");
$im = imagecreate (300, 300);
$red = imagecolorallocate ($im, 255, 0, 0);
$black = imagecolorallocate ($im, 0, 0, 0);
mysql_connect("cannon.safesecureweb.com", "ajauberg", "raems+clo");
mysql_query("USE database");
$optionsquery = mysql_query("SELECT * FROM voteoptions");
$numoptions = mysql_num_rows($optionsquery);
$pollquery = mysql_query("SELECT * FROM poll");
$numvotes = mysql_num_rows($pollquery);
$xval = 30;
$barwidth = floor(300/$numoptions);
for ($i=0;$i<=($numoptions-1);$i++) 
{
    $voteoption = mysql_result($optionsquery,$i,'name');
    $votevalue = mysql_result($optionsquery,$i,'value');
    $currentnumquery = mysql_query("SELECT * FROM poll WHERE vote='$votevalue'");
    $currentnum = mysql_num_rows($currentnumquery);
    $per = floor(($currentnum/$numvotes)*184);
    $rper = floor(($currentnum/$numvotes)*100);
    imagefilledrectangle ($im, $xval, (200-$per), ($xval+$barwidth), 200, $red);
    imagerectangle ($im, $xval, (200-$per), ($xval+$barwidth), 200, $black);
    imagestring ($im, 1, ($xval+($barwidth/2)), 205, $voteoption, $black);
    imagestring ($im, 2, ($xval+($barwidth/2)), ((200-$per)-15), "$rper%", $bla);
    $xval+=($barwidth+10)
}
imagepng($im);
?>
