<!DOCTYPE html>
<html>
	<head>
		<meta charset = "utf-8" />
		<link rel="stylesheet" href="../CSS/styleacceuil.css" />
		<title>Evaluez vous de près</title>
	</head>
	
	<body>
		Connexion <br>
		<form action="controleur.php" method="post">
		email : <input type="email" name="email" value="<?php if(isset($_POST["email"])) echo $_POST["email"]; ?>">
		mdp : <input type="password" name="mdp">
		<input type="submit" name="submit2" value="se connecter">
		</form><br>
		<?php  if(isset($_POST["submit2"]) && isset($msg2)){echo $msg2."  ";} ?>
		<?php  if(isset($_POST["submit2"]) && isset($msg3)){echo $msg3;} ?>
		<br><br><br>
		

		<p align="center">
		Inscription gratuite <br>
		<hr width=50%>
		<form action="controleur.php" method="post">
 		Nom : <input name="nomi" type="text" value="<?php if(isset($_POST["nomi"])) echo $_POST["nomi"]; ?>">
 		<?php  if(isset($_POST["submit1"]) && isset($msg1)){echo $msg1;} ?><br><br> 
 		Adresse mail : <input name="emaili" type="email" value="<?php if(isset($_POST["emaili"])) echo $_POST["emaili"]; ?>">
 		<?php  if(isset($_POST["submit1"]) && isset($msg2)){echo $msg2;} ?><br><br>
 		Mot de passe : <input name="mdp" type="password">
 		<?php  if(isset($_POST["submit1"]) && isset($msg3)){echo $msg3;} ?><br><br>
 		<input type="submit" name="submit1" value="s'inscrire">
		</form>

		</p>
		<br><br><br>
		<a href="controleur.php?page=accueil_util.php">Accueil utilisateur </a>
		<br>
		<a href="controleur.php?page=accueil.php">Accueil </a>
		<br><br>
		<a href="controleur.php?page=affichage_table.php">table</a>

	</body>
</html>
