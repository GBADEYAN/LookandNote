<!DOCTYPE html>
<html>
	<head>
		<meta charset = "utf-8" />
		<link rel="stylesheet" href="../CSS/enregistrement.css" />
		<title>Publier une photo</title>

		<style>


.mot{
background-color:yellow;
}
	
</style>


	</head>
	
	<body>
	<div id="conteneur">    
    <h1 id="header"><a href="#" title="bienvenue dans votre miroir"></a></h1>
	<nav>
	<div id = "boutons">
		<ul id = "menu">
			<li><a href="controleur.php?page=a">Acceuil</a></li>
			<li><a href="controleur.php?page=b">Publier</a></li>
			<li><a href="controleur.php?page=p">Mon Profil</a></li>
			<li><a href="controleur.php?page=n">Mes Notes</a></li>
			<li><a href="controleur.php?page=c">Amis</a></li>
			<div id = "rechavanc�e">
				<li><a href="controleur.php?page=r">Recherche avanc�e</a></li>
				<li><form method="post" action="controleur.php"><input type = "text" name ="Rech" style = "margin-left: 20px;"/></form></li>
			</div>
		</ul>
		<ul id = "Bonjour">
			<li><b>Bonjour <?php echo $_SESSION["nom"];?></b></li>
			<li><a href = "#" title ="T�lcharger votre Photo de Profil"><img src = "../Image/photoprofil.png"/></a></li>
			<li><a href = "accueil.php" title = "d�connecter" style = "margin-left: 90px;">D�connexion</a></li>
		</ul>
	</div> 
    </nav>

<?php echo $pp; ?>

</body>

</html>