<!DOCTYPE html>
<html>
	<head>
		<meta charset = "utf-8" />
		<link rel="stylesheet" href="../CSS/enregistrement.css" />
		<title>Publier une photo</title>
	</head>
	
	<body>
	<div id="conteneur">    
    <h1 id="header"><a href="#" title="bienvenue dans votre miroir"></a></h1>
	<nav>
	<div id = "boutons">
		<ul id = "menu">
			<li><a href="controleur.php?page=a">Accueil</a></li>
			<li><a href="controleur.php?page=b">Publier</a></li>
			<li><a href="#">Mon Profil</a></li>
			<li><a href="#">Mes Notes</a></li>
			<li><a href="controleur.php?page=c">Amis</a></li>
			<div id = "rechavanc�e">
				<li><a href="#">Recherche avanc�e</a></li>
				<li><input type = "text" name ="Recherche avanc�e" style = "margin-left: 20px;"/></li>
			</div>
		</ul>
		<ul id = "Bonjour">
			<li><b>Bonjour <?php echo $_SESSION["nom"];?></b></li>
			<li><a href = "#" title ="T�lcharger votre Photo de Profil"><img src = "../Image/photoprofil.png"/></a></li>
			<li><a href = "accueil.php" title = "d�connecter" style = "margin-left: 90px;">D�connexion</a></li>
		</ul>
	</div> 
    </nav>

<form action="controleur.php" method="post">
	Rechercher un ami:<br>
	<input type="search" name="rech_ami">
</form>	
<br>
<?php
if(isset($pp)){
echo $pp;
}
if(isset($ppp)){
echo $ppp;
}
?>

	</body>

</html>