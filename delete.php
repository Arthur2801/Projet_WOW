<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN""http://www.w3.org/TR/html4/strict.dtd">
<?php session_start(); ?>
<html>

	<head>
	
		<meta http-equiv="Content-Type"content="text/html; charset=UTF-8" />
		<title>WoW Arena</title>
		<link rel="stylesheet" href="styles\style1.css"type="text/css" media="screen" />

		<?php 
			include ("bd.php");
			$bdd = getBD();
		?>

	</head>

	<body>
		
		<?php

            $sqld="delete from import where idUser=".$_SESSION['utilisateur'][1];
            $bdd->query($sqld);

		?>
		<meta http-equiv="refresh" content="0; URL=index.php">

	</body>

</html>