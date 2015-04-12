<!DOCTYPE html>
<html>
	<head>
		<meta charset = "utf-8" />
		<link rel="stylesheet" href="../CSS/enregistrement.css" />
		<title>Evaluez vous de près</title>
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
			<li><a href="controleur.php?page=er">Mes Notes</a></li>
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
	<section>

	<div id = "sectiondroite">
	<h2>Liste D'amis</h2>
		<div "Amis">
		<?php echo $FG; ?>		
		</div>
	</div>

	<div id = "pagemilieu">
		<?php echo $FC; ?>	
	</div>
	
	<div id = "sectiongauche">
	<h2>Activitées Récentes</h2>
		<div "Activitées">
		<?php echo $FD; ?>
		</div>
	</div>

	</section>
	
	<hr color= "Orange">
		
		<footer>
		<a href="A propos">A propos</a>&nbsp&nbsp&nbsp
		<a href="Nous Contacter">Nous Contacter</a>&nbsp&nbsp&nbsp
		<a href="Confidentialité">Confidentialité</a>&nbsp&nbsp&nbsp
		<a href="Mentions légales">Mentions légales</a>&nbsp&nbsp&nbsp
		<a href="Mentions légales">Pages Génie logiciel</a>
		
		</footer>
	
	
	</div>
	
	</body>
	
</html>