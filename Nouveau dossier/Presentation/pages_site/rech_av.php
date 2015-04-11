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
			<li><a href="controleur.php?page=a">Acceuil</a></li>
			<li><a href="controleur.php?page=b">Publier</a></li>
			<li><a href="controleur.php?page=p">Mon Profil</a></li>
			<li><a href="#">Mes Notes</a></li>
			<li><a href="controleur.php?page=c">Amis</a></li>
			<div id = "rechavancée">
				<li><a href="controleur.php?page=r">Recherche avancée</a></li>
				<li><form method="post" action="controleur.php"><input type = "text" name ="Rech" style = "margin-left: 20px;"/></form></li>
			</div>
		</ul>
		<ul id = "Bonjour">
			<li><b>Bonjour <?php echo $_SESSION["nom"];?></b></li>
			<li><a href = "#" title ="Télcharger votre Photo de Profil"><img src = "<?php echo $_SESSION["photo_p"] ?>" width=45%></a></li>
			<li><a href = "accueil.php" title = "déconnecter" style = "margin-left: 90px;">Déconnexion</a></li>
		</ul>
	</div> 
    </nav>

<br><br><br>
<form method="post">
<input type="text" name="mot" ><br>
Chercher dans : <br>
<input type="checkbox" name="t" value="titre">Titre photo<br>
<input type="checkbox" name="n" value="nom">Nom utilisateur<br>
<input type="checkbox" name="c" value="critere">Critere<br>
<input type="checkbox" name="co" value="comm">Commentaire<br>
<input type="checkbox" name="a" value="ami">Ami<br> 
Date : <br>
<input type="radio" name="date-rgt" value="ASC">Croissant<br>
<input type="radio" name="date-rgt" value="DESC">Decroissant<br>
<input type="submit" name="submit_rech_av" value="rechercher">



</form>

</body>

</html>