<!DOCTYPE html>
<?php session_start(); ?>

<html>
	<head>
		<meta http-equiv="Content-Type"content="text/html; charset=UTF-8" />
		<link rel="stylesheet" href="../styles/style1.css" type="text/css"media="screen" />
		<title>WoW Arena</title>
	</head>
		
	<body>
		<div id="header">
			<a href="../index.php"><img id="logo" src=../images/logoW.png alt="WoW Arena"></a>
		<h1 class="title">WoW Arena</h1>

		<div id="text">
		
		<h3 class="bouton">
			<?php if(isset($_SESSION['utilisateur'])){
				echo "Welcome ". $_SESSION['utilisateur'][0]."";?> </h3>
				<h2 class="b"> •<a href="../deconnexion.php" class="bouton">Log Out</a>
			•<a href="../import.php" class="bouton">Import</a>
			•<a href="../statistics.php" class="bouton">Statistics</a></h2>
		<?php }else{?>
			<h2 class="b"> •<a href="../inscription.php" class="bouton">Sign Up</a>
			•<a href="../connexion.php" class="bouton">Log In</a> </h2>
			<?php } ?>
		
		</div>
	
		</div>
		
	<div id="global">
				
		<p class="contact"> Here are the directions to contact us if you need help : </p>
		
		<p>
				<li> Miramond Guillaume : </li>
				<p class="mail"> Guilhermo38@gmail.com </p> <br />
				<li> Bellot Arthur : </li>
				<p class="mail"> Arthurbe2801@gmail.com </p> <br />
				<li> Gheude Loan : </li>
				<p class="mail"> Loan.gheude@gmail.com </p> <br/> 
		</p> 
		
		<p class="contact"> Do not hesitate to make suggestions in order to improve our site. </p>
		
		<p class="contact"> <em> Thank you for your visit </em> </p>
		
		<p> <a href="../index.php" class="bou"> Return </a> </p>
		
		</div>
	</body>
</html>
