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

<br>

<h3>Modifier la photo de profil :</h3>
<?php echo "<img src = \"".$_SESSION["photo_p"]."\" width=10%><br>\n"; ?>
<form method="post" action="controleur.php" enctype="multipart/form-data">
     <label for="mon_fichier">Modifier la photo de profil (tous formats | max. 2 Mo) :</label><br />
     <input type="hidden" name="MAX_FILE_SIZE" value="2096152" />
     <input type="file" name="mon_fichier" id="mon_fichier" >
     <?php if(isset($_POST["publ_photo"]) && isset($msg)){echo $msg;} ?>
     <br>
     <?php if(isset($_POST["publ_photo"]) && !empty($msg2)){echo $msg2;} ?>

<?php 
 if(isset($_POST["publ_photo"]) && !empty($msg3)){echo $msg3;}?><br>

     <br>

     <input type="submit" name="modif_photop" value="Envoyer" />
</form>

photo profil +bouton changer photoprofil<br>

<?php
echo $pp;
echo "<h3><a href=\"controleur.php?page=er\">Evaluation :</a></h3>";
echo $nd;
echo $ap;

?>


<h3>Desinscription :</h3>
Etes-vous sur de vouloir vous d&eacute;sinscrire ?<br>

<a href="controleur.php?des=oui"> Desincription </a>
	
	</body>

</html>
