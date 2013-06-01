<?php

// Read the data

$oid=$_GET['oid'];
$table=$_GET['table'];
$dateformat=$_GET['dateformat'];
$xtitle=$_GET['xtitle'];

$xmlobj = simplexml_load_file("http://www.aiwisp.net/maps/gLogTRX.xml.php?oid=$oid&table=$table");
foreach ($xmlobj->gLog as $gLog) {
  $datay[] = intval($gLog[RXb]);
  $datay2[] = intval($gLog[TXb]);
  $datax[] = strtotime($gLog[Timestamp]);
}

/*
	echo "<pre>";
	echo print_r($GLOBALS);
	echo "</pre>";
*/

// Draw the graph

include ("./jpgraph/src/jpgraph.php");
include ("./jpgraph/src/jpgraph_line.php");
include ("./jpgraph/src/jpgraph_date.php");

$graph = new Graph(450,150);

//$graph->title->Set("6 Week Signal From $refOid");
$graph->title->SetFont(FF_FONT1,FS_BOLD);

$graph->SetMargin(50,20,20,20);
$graph->SetMarginColor('white');
$graph->SetScale('datlin');
$graph->SetFrame(true,'gray',1);
$graph->SetShadow(true,'2','gray');

$graph->xaxis->scale->SetDateFormat($dateformat); // 'H','D','W','M'
$graph->xaxis->title->Set($xtitle); // 'Hour','Day','Week','Month'
$graph->xaxis->title->SetMargin(22);

$graph->xgrid->show(true,true);

$graph->ygrid->Show(true,true);

$graph->yaxis->title->Set("bytes");
$graph->yaxis->title->SetMargin(8);

$line = new LinePlot($datay,$datax);
$line->SetColor("blue");
$line->SetLegend("RX bytes");
//$line->SetFillColor("blue");
$graph->Add($line);

$line2 = new LinePlot($datay2,$datax);
$line2->SetColor("forestgreen");
$line2->SetLegend("TX bytes");
//$line2->SetFillColor("forestgreen");
$graph->Add($line2);

$graph->legend->Pos(0.1,0.8);
$graph->legend->SetLayout(LEGEND_HOR);

$graph->Stroke();

