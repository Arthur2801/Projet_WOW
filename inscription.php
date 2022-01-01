<!DOCTYPE html>
<html>

	<head>
	
		<meta http-equiv="Content-Type"content="text/html; charset=UTF-8" />
		<title>WoW Arena</title>
		<link rel="stylesheet" href="styles\style1.css"type="text/css" media="screen" />
	
	</head>

	<body>
		<div id="header">
		<a href="index.php"><img id="logo" src=images/logoW.png alt="WoW Arena"></a>
		<h1 class="title">WoW Arena</h1> 
		</div>
		
		<div id="global">
		
		<h1 class="index"> <u> Sign up : </u> </h1>

		
		<form action="enregistrement.php" method="post" autocomplete="off">
			<p>Username :<input type="text" name="u" value="<?php echo $_GET['u'];?>"/></p>
			<p>Password :<input type="password" name="mdp1" value=""/></p>
			<p>Confirm your password :<input type="password" name="mdp2" value=""/></p>
			<p><input type="submit" value="Submit"></p>
		</form>
		
		<a href="index.php" class="bou">
		Return
		</a> <br />
		
		<p> <br /> </p>
		</div>
		
	</body>

</html>