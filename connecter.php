<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN""http://www.w3.org/TR/html4/strict.dtd">
<?php session_start(); ?>
<html>
	<head>
	
		<meta http-equiv="Content-Type"content="text/html; charset=UTF-8" />
		<title>WOW Arena</title>
		<link rel="stylesheet" href="styles\style1.css"type="text/css" media="screen" />
		<div id="header">
		<a href="index.php"><img id="logo" src=images/logoW.png alt="WoW Arena"></a>
		<h1 class="index">WoW Arena</h1>
		</div>
		
		<div id="global">
		
		
		<?php 
			include ("bd.php");
			$bdd = getBD();
			$mdp=$_POST['mdp'];
			$user=$_POST['user'];
			$sql="select password from user where username='$user'";
			$sql2="select username from user where password='$mdp'";
			$sqlidC="Select idUser from user where username='$user'";
			$rep=$bdd->query($sql);
			$ligne= $rep ->fetch();
			$rep2=$bdd->query($sql2);
			$ligne2= $rep2 ->fetch();
			$rep3=$bdd->query($sqlidC);
			$ligne3 = $rep3 ->fetch();

			if($_POST['mdp']==""||$_POST['user']==""){
				echo "Username or Password empty"?>
				<meta http-equiv="refresh" content="1; URL=connexion.php">
			<?php 
			}else{
				if($ligne['password']==$_POST['mdp']){
					$_SESSION['utilisateur']=array($_POST['user']);
					array_push($_SESSION['utilisateur'],$ligne3['idUser'])?>
					<meta http-equiv="refresh" content="0; URL=index.php">
				<?php }
				else{
					echo "Username or Password incorrect"?>
					<meta http-equiv="refresh" content="1; URL=connexion.php?username=
					<?php echo $_POST['user']?>">
				<?php  }?>
		
			
			<?php }?>
			
			</div>
	</head>
	<body>
		
		<p> <br /> </p>
		
	</body>
</html>