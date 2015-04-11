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
<br>


<h1> How are you traveling ? </h1>

<br>
Travel takes many forms, whether across town, across the country, or around the world. Here is a list of some common means of transportation:

<br>


<?php

if(!isset($_POST["submit"])){
 
 $critere=array("");

}
else{

  $critere=$_POST["critere"];
  
$add = htmlentities($_POST["added"]);
  
$tok=strtok($add,", ");
  
while($tok!==false){

   $critere[count($critere)]=$tok;

   $tok=strtok(" ,");
   
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



Please add your favorite, local, or even imaginary means of travelling to the list, separated by commas:

<br><br>

<form method="post" action="">

<input type="text" name="added">


<?php
foreach($critere as $t){

  echo "<input type=\"hidden\" name=\"critere[]\" value=\"$t\">";

}
?>


<input type="submit" name="submit" value="ajouter">
</form>
 
</body>
 
</html>
