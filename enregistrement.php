<!DOCTYPE html>
<html>

	<head>
	
		<meta http-equiv="Content-Type"content="text/html; charset=UTF-8" />
		<title>WoW Arena</title>
		<link rel="stylesheet" href="styles\style1.css"type="text/css" media="screen" />

		<?php


			function enregistrer(String $username,String $mdp){
            	include ("bd.php");
           		$bdd = getBD();
           		$sql="insert into user (username,password) values ('$username','$mdp')";
            	$bdd->query($sql);
            	
			}
		
		if($_POST['u']!="" && $_POST['mdp1']!="" && $_POST['mdp2']!="" && $_POST['mdp1']==$_POST['mdp2']) { 

				$username=$_POST['u'];
				$mdp=$_POST['mdp1'];
				enregistrer($username,$mdp);
				?>

				<meta http-equiv="refresh" content="0; URL=index.php">

			<?php }

			else{ ?>

				<meta http-equiv="refresh" content="0; URL=inscription.php
				<?php 
					if($_POST['u']!=""){?>
					?u=<?php echo $_POST['u'];} 
				?>
				"> 

	 <?php }?>

	</head>
	<body>
		
	</body>

</html>