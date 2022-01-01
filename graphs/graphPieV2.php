<?php session_start(); ?>
<?php // content="text/plain; charset=utf-8"
 include ("../bd.php");
        $bdd = getBD();
require_once ('../jpgraph/src/jpgraph.php');
require_once ('../jpgraph/src/jpgraph_pie.php');

$wins="select count(victory) as win from import WHERE victory=1 and isRated=1 and playersNumber=4 and idUser=".$_SESSION['utilisateur'][1];
        $rep=$bdd->query($wins);
        $ligne = $rep ->fetch();

        $loses="select count(victory) as loses from import WHERE isRated=1 and victory=0 and playersNumber=4 and idUser=".$_SESSION['utilisateur'][1];
        $rep=$bdd->query($loses);
        $ligne2 = $rep ->fetch();
   

// Some data

$data = array($ligne['win'],$ligne2['loses']);

// Create the Pie Graph. 
$graph = new PieGraph(230,230);



$graph->SetColor('#D2B48C'); 
$theme_class="DefaultTheme";
//$graph->SetTheme(new $theme_class());



// Set A title for the plot
$graph->SetBox(true);

// Create
$p1 = new PiePlot($data);
$p1->value->SetColor('black');
$graph->Add($p1);




$p1->SetSliceColors(array('#2E8B57','#B22222'));
$graph->Stroke();

?>
