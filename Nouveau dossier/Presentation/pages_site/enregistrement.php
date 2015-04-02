<!DOCTYPE html>
<html>
	<head>
		<meta charset = "utf-8" />
		<link rel="stylesheet" href="enregistrement.css" />
		<title>Evaluez vous de près</title>
	</head>
	
	<body>
	<div id="conteneur">    
    <h1 id="header"><a href="#" title="bienvenue dans votre miroir"></a></h1>
	<nav>
	<div id = "boutons">
		<ul id = "menu">
			<li><a href="acceuil.html">Acceuil</a></li>
			<li><a href="#">Publier</a></li>
			<li><a href="#">Mon Profil</a></li>
			<li><a href="#">Mes Notes</a></li>
			<li><a href="#">Amis</a></li>
			<div id = "rechavancée">
				<li><a href="#">Recherche avancée</a></li>
				<li><input type = "text" name ="Recherche avancée" style = "margin-left: 20px;"/></li>
			</div>
		</ul>
		<ul id = "Bonjour">
			<li><b>Bonjour <?php echo $_POST['identifiant'];?></b></li>
			<li><a href = "#" title ="Télcharger votre Photo de Profil"><img src = "photoprofil.png"/></a></li>
			<li><a href = "#" title = "déconnecter" style = "margin-left: 90px;">Déconnexion</a></li>
		</ul>
	</div> 
    </nav>
	<section>
	<div id = "sectiondroite">
	<h2>Liste D'amis</h2>
		<div "Amis">
			<a href = "#">Nom d'utilisateur</a><br>
			<a href = "#">Activité récente</a><br>
			<a href = "#"><img src = "util1.png"></a><br><br>
			<a href = "#">Nom d'utilisateur</a><br>
			<a href = "#">Activité récente</a><br>
			<a href = "#"><img src = "util2.png"></a><br><br>
			<a href = "#">Nom d'utilisateur</a><br>
			<a href = "#">Activité récente</a><br>
			<a href = "#"><img src = "util3.png"></a><br><br>
			<a href = "#">Nom d'utilisateur</a><br>
			<a href = "#">Activité récente</a><br>
			<a href = "#"><img src = "util4.png"></a><br><br>
			<a href = "#">Nom d'utilisateur</a><br>
			<a href = "#">Activité récente</a><br>
			<a href = "#"><img src = "util5.png"></a><br><br>
		</div>
	</div>
	
	<div id = "pagemilieu">
		<div id = "coordonnees">
			<a href = "#"><img src = "util1.png"></a>
			<a href = "#"><p>Nom de l'utilisateur</p></a><br>
		</div>
		<div id = "pub">
		<h2>Titre Photo</h2>
		<img src = "pub1util1.png">
			<div id = "boutonspub">
				<input type = "submit" value = "Noter"id = "Noter"/>
				<input type = "submit" value = "Commenter"id = "Commenter"/>
				<input type = "submit" value = "Partager" id = "partager"/>
			</div>
		<p style = "text-align:right; line-height: 200px;font-weight: bold;">Moyenne des notes: NOTE</p>
		</div>
		
	
	</div>
	
	<div id = "sectiongauche">
	<h2>Activitées Récentes</h2>
		<div "Activitées">
			<a href = "#"><img src = "util1.png"></a><br>
			publié par Nom Utilisateur<br><br><br>
			<a href = "#"><img src = "util2.png"></a><br>
			publié par Nom Utilisateur<br><br><br>
			<a href = "#"><img src = "util3.png"></a><br>
			publié par Nom Utilisateur<br><br><br>
			<a href = "#"><img src = "util4.png"></a><br>
			publié par Nom Utilisateur<br><br><br>
			<a href = "#"><img src = "util5.png"></a><br>
			publié par Nom Utilisateur<br><br><br>
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