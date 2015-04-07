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
				<li><a href="controleur.php?page=r">Recherche avancée</a></li>
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


<br>

<label for="critere">Critere (max. 50 caractères) :</label><br >
<br>
Liste des crit&egrave;res attribu&eacute;s &agrave; la photo:




<?php
 

if(!isset($_POST["submit"]) || empty($_POST["added"])){
 
 $critere=array("");

}
else{

  $critere=$_POST["crit"];
  
$add = htmlentities($_POST["added"]);
  
$tok=strtok($add,",");
  
while($tok!==false){

   $critere[count($critere)]=$tok;

   $tok=strtok(",");
   
  }

}


$i=1;
echo "<ul>\n";

while($i<count($critere)){

echo "<li>".$critere[$i]."</li>\n";
$i++;

}

echo "</ul>\n"; 

?>



Ajouter les crit&egrave;res s&eacute;par&eacute;s par des virgules :

<br><br>

<form method="post" action="">

<input type="text" name="added">


<?php 
foreach($critere as $t){

  echo "<input type=\"hidden\" name=\"crit[]\" value=\"$t\">";

}
?>


<input type="submit" name="submit" value="ajouter">
</form>
<br>

<?php// echo count($critere); ?>


<form method="post" action="controleur.php" enctype="multipart/form-data">
     <label for="mon_fichier">Fichier (tous formats | max. 2 Mo) :</label><br />
     <input type="hidden" name="MAX_FILE_SIZE" value="2096152" />
     <input type="file" name="mon_fichier" id="mon_fichier" >
     <?php if(isset($_POST["publ_photo"]) && isset($msg)){echo $msg;} ?>
     <br>
     <label for="titre">Titre du fichier (max. 150 caractères) :</label><br />
     <input type="text" name="titre" id="titre" >
     <?php if(isset($_POST["publ_photo"]) && !empty($msg2)){echo $msg2;} ?>

<?php 
 if(isset($_POST["publ_photo"]) && !empty($msg3)){echo $msg3;}?><br>

     <br>
<?php 
$i=1;foreach($critere as $t){

  echo "<input type=\"hidden\" name=\"critere[]\" value=\"$t\">";

$i++;}
?>


     <input type="submit" name="publ_photo" value="Envoyer" /><?php //echo count($critere); ?>
</form>


<?php
if(isset($pp)){
echo $pp;
}

if(isset($AA)){echo $AA;}
?>
	
	</body>

</html>
