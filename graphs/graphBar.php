<?php session_start(); ?>
<?php // content="text/plain; charset=utf-8"
include ("../bd.php");
        $bdd = getBD();
require_once ('../jpgraph/src/jpgraph.php');
require_once ('../jpgraph/src/jpgraph_bar.php');

// SELECT * FROM maps AS a, (SELECT MIN(idMap) AS mini, MAX(idMap) AS maxi FROM maps) AS m WHERE m.maxi = a.idMap OR m.mini = a.idMap

        $wins="select nom, count(*) as occurence from import, maps where import.idMap=maps.idMap group by nom ORDER BY `occurence` DESC";
        $rep=$bdd->query($wins);
        $ligne = $rep ->fetch();

$data1y=array($ligne['occurence'][0],80,40,116);


// Create the graph. These two calls are always required
$graph = new Graph(350,200,'auto');
$graph->SetScale("textlin");

$theme_class=new UniversalTheme;
$graph->SetTheme($theme_class);

$graph->yaxis->SetTickPositions(array(0,30,60,90,120,150), array(15,45,75,105,135));
$graph->SetBox(false);

$graph->ygrid->SetFill(false);
$graph->xaxis->SetTickLabels(array($ligne1['nom'],$ligne2['nom'],$ligne3['nom'],'Rogue'));
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);

// Create the bar plots
$b1plot = new BarPlot($data1y);


// Create the grouped bar plot
$gbplot = new GroupBarPlot(array($b1plot));
// ...and add it to the graPH
$graph->Add($gbplot);


$b1plot->SetColor("white");
$b1plot->SetFillColor("#cc1111");

$graph->title->Set("Arena Statistiques Test");

// Display the graph
$graph->Stroke();
?>