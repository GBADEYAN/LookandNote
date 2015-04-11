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
<h3>Resultats de la recherche : </h3><br>

<?php
if(isset($res_util)){
	echo "Utilisateurs:<br>\n";
	echo $res_util;
}
if(isset($res_titre)){
	echo "<br>Titre<br>\n";
	echo $res_titre;
}
if(isset($res_crit)){
	echo "<br>Critere<br>\n";
	echo $res_crit;
}
if(isset($res_comm)){
	echo "<br>Commentaire<br>\n";
	echo $res_comm;
}
if(isset($res_ami)){
	echo "<br>Ami<br>\n";
	echo $res_ami;
}


?>


</form>


</body>

</html>