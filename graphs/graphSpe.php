<?php session_start(); ?>
<?php // content="text/plain; charset=utf-8"
 include ("../bd.php");
        $bdd = getBD();
require_once ('../jpgraph/src/jpgraph.php');
require_once ('../jpgraph/src/jpgraph_pie.php');

$class=array("Frost-DeathKnight","Unholy","Havoc","Feral","Balance","BeatMastery","Survival","Marksmanship","Fire-Mage","Arcane","frost-Mage","Windwalker","Retribution","Shadow","Assassination","Subtlety","Elemental","Enhancement","Affliction","Destruction","Demonology","Arms");


        $spe="select DISTINCT specialization from import where idUser=".$_SESSION['utilisateur'][1]." and isRated=1 and playersNumber=4";
        $rep = $bdd->query($spe);
        while ($ligne = $rep ->fetch()) {
            $spe="'".$ligne['specialization']."'";
            $spe2=$ligne['specialization'];
            $nbj=4;
            echo imgs($spe2)."<div class='spe'><p>".ws($spe,$nbj)." Win / ".ls($spe,$nbj)." Lose</p>"."<p>Winrate :".round(winrS($spe,$nbj),2)."% </p>";
            echo matchup($class,$spe2,$nbj)."</div>";
        }$rep ->closeCursor();
        echo"</div>";

$wins="select count(victory) as win from import WHERE victory=1 and isRated=1 and playersNumber=6 and idUser=".$_SESSION['utilisateur'][1];
        $rep=$bdd->query($wins);
        $ligne = $rep ->fetch();

        $loses="select count(victory) as loses from import WHERE isRated=1 and victory=0 and playersNumber=6 and idUser=".$_SESSION['utilisateur'][1];
        $rep=$bdd->query($loses);
        $ligne2 = $rep ->fetch();
   

// Some data

$data = array($spe['win']);

// Create the Pie Graph. 
$graph = new PieGraph(230,230);

$theme_class="DefaultTheme";
//$graph->SetTheme(new $theme_class());

// Set A title for the plot
$graph->title->Set("Winrate");
$graph->SetBox(true);

// Create
$p1 = new PiePlot($data);
$graph->Add($p1);

$p1->ShowBorder();
$p1->SetColor('black');
$p1->SetSliceColors(array('green','red'));
$graph->Stroke();

?>
