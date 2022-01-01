<!DOCTYPE html>
<?php session_start(); ?>
<html>

	<head>
	
		<meta http-equiv="Content-Type"content="text/html; charset=UTF-8" />
		<title>WoW Arena</title>
		<link rel="stylesheet" href="styles\style1.css"type="text/css" media="screen" />
	
	</head>

	<body>
	
		<div id="header">
		<a href="index.php"><img id="logo" src=images/logoW.png alt="WoW Arena"></a>
		<h1 class="index">WoW Arena</h1>
		</div>
		
		<div id="global">
		
	
		<?php
		include ("bd.php");
		//ajoute les données du fichier dans notre base de données mysql
		function ajouter($ch1,$ch2,$ch3,$ch4,$ch5,$ch6,$ch7,$ch8,$ch9,$ch10,$ch11){
           	$bdd = getBD();
           	$sql="insert into import (`timestamp`, `playersNumber`, `teamComp`, `ennemyComp`, `victory`, `ratingChange`, `ennemyMMR`, `isRated`, `idMap`, `idUser`, `specialization`) values ($ch1,$ch2,'$ch3','$ch4',$ch5,$ch6,$ch7,$ch8,$ch9,$ch10,'$ch11')";
            $bdd->query($sql);
        }
        // importation du fichier
		$nomOrigine = $_FILES['monfichier']['name'];
		$elementsChemin = pathinfo($nomOrigine);
		$extensionFichier = $elementsChemin['extension'];
		// vérification du type de fichier
		$extensionsAutorisees = array("csv","Classeur OpenOffice.org XML 1.0","txt"); 
		if (!(in_array($extensionFichier, $extensionsAutorisees))) {
		    echo "Le fichier n'a pas l'extension attendue";
		    echo "</br>";
			echo "</br>";?>
		    <a href="import.php" class="bou">Return</a>
		<?php } else {    
		    $repertoireDestination = dirname(__FILE__)."/files/";
		    $nomDestination = "fichier_du_".date("YmdHis").".".$extensionFichier;
		    //upload du fichier dans notre dossier file
		    if (move_uploaded_file($_FILES["monfichier"]["tmp_name"], 
		                                     $repertoireDestination.$nomDestination)) {
		        echo "Le fichier temporaire ".$_FILES["monfichier"]["tmp_name"].
		                " a été déplacé vers ".$repertoireDestination.$nomDestination;
		        $row = 1;
		        // importation des données dans notre bdd à partir du fichier dans notre dossier file
				if (($handle = fopen("files/".$nomDestination, "r")) !== FALSE) {
		   			while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
			        	$num = count($data);
			        	$row++;
			        	$ch1=$data[0];
			        	$ch2=$data[2];
			        	$ch3=$data[3];
			        	$ch4=$data[4];
			        	$ch5=$data[6];
			        	$ch6=$data[11];
			        	$ch7=$data[13];
			        	$ch8=$data[15];
			        	$ch9=$data[1];
			        	$ch10=$_SESSION['utilisateur'][1];
			        	$ch11=$data[14];
			        	ajouter($ch1,$ch2,$ch3,$ch4,$ch5,$ch6,$ch7,$ch8,$ch9,$ch10,$ch11);
		    		}
		    		$bdd = getBD();
		    		// conversion timestamp en date
		    		$sqld="UPDATE import SET date = FROM_UNIXTIME(timestamp)";  
		    		$bdd->query($sqld);
		    		echo "</br><p> Importation réussie</p></br>";?>
		    		<meta http-equiv="refresh" content="2; URL=statistics.php">
		    		<?php fclose($handle);
				}

		        ?>
		        
		   	<?php } else {
		   		
		        echo "Le fichier n'a pas été uploadé (trop gros ?) ou ".
		                "Le déplacement du fichier temporaire a échoué".
		                " vérifiez l'existence du répertoire ".$repertoireDestination;
		        echo "</br>";
		        echo "</br>";?>
		        <a href="import.php" class="bou">Return</a>
		    <?php }
		}
		?>
		<p> <br /> </p>
		</div>
		
	</body>

</html>