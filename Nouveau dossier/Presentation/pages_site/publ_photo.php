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
			<li><a href="#">Mon Profil</a></li>
			<li><a href="#">Mes Notes</a></li>
			<li><a href="controleur.php?page=c">Amis</a></li>
			<div id = "rechavancée">
				<li><a href="#">Recherche avancée</a></li>
				<li><input type = "text" name ="Recherche avancée" style = "margin-left: 20px;"/></li>
			</div>
		</ul>
		<ul id = "Bonjour">
			<li><b>Bonjour <?php echo $_SESSION["nom"];?></b></li>
			<li><a href = "#" title ="Télcharger votre Photo de Profil"><img src = "../Image/photoprofil.png"/></a></li>
			<li><a href = "accueil.php" title = "déconnecter" style = "margin-left: 90px;">Déconnexion</a></li>
		</ul>
	</div> 
    </nav>

<form method="post" action="controleur.php" enctype="multipart/form-data">
     <label for="mon_fichier">Fichier (tous formats | max. 1 Mo) :</label><br />
     <input type="hidden" name="MAX_FILE_SIZE" value="2096152" />
     <input type="file" name="mon_fichier" id="mon_fichier" />
     <?php if(isset($_POST["publ_photo"]) && isset($msg)){echo $msg;} ?>
     <br>
     <label for="titre">Titre du fichier (max. 50 caractères) :</label><br />
     <input type="text" name="titre" id="titre" />
     <?php if(isset($_POST["publ_photo"]) && !empty($msg2)){echo $msg2;} ?>
     <br>
     <input type="submit" name="publ_photo" value="Envoyer" />
</form>
<?php
if(isset($pp)){
echo $pp;
}
if(isset($AA)){echo $AA;}
?>
	
	</body>

</html>