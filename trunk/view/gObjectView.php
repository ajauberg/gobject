<?php // Load and parse the XML document 
$xmlobj = simplexml_load_file("../maps/gObjects.php");
$title =  "gObjects";
?>
<html xml:lang="en" lang="en">
<head>
  <title><?php echo $title; ?></title>
</head>
<body>

<h1><?php echo $title; ?></h1>

<?php

// Here we'll put a loop to include each gObject
echo "<table border='1'>";
echo "<tr><th>Name</th><th>MAC</th><th>IP</th><th>LastContact</th><th>UPTIME</th><th>CLI</th><th>RATE</th><th>ESSID</th></tr>";
foreach ($xmlobj->gObject as $gObj) {
  echo "<tr>";
  echo "<td><a href='gLogView.php?oid=" . $gObj[id] . "'>" . $gObj[Name] . "</a></td>";
  echo "<td><p>" . $gObj[MAC] . "</p></td>";
  echo "<td><p>" . $gObj[IP] . "</p></td>";
  echo "<td><p>" . $gObj[LastContact] . "</p></td>";
  echo "<td><p>" . $gObj[UPTIME]/86400 . " days</p></td>";
  echo "<td><p>" . $gObj[CLI] . "</p></td>";
  echo "<td><p>" . $gObj[RATE] . "</p></td>";
  echo "<td><p>" . $gObj[ESSID] . "</p></td>";
  echo "</tr>";
}
echo "</table>";
/*
echo "<pre>";
echo print_r($GLOBALS);
echo "</pre>";
*/
?>

</body>
</html>

