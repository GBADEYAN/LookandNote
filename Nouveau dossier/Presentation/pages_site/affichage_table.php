<!DOCTYPE html>
<html>

<head>
<meta charset="utf-8" />
<title>Titre</title>
</head>

<body>

<?php 
require("../../Metier/Gestion_bdd.php");
/*13--------------connexion a la base de donnees---------------------------*/
$connex = connexion_bdd();

/*17-----------------affichage--------------------------------------------*/

$sql = "select * from Utilisateur";
$req = mysql_query($sql,$connex);
if(!$req){Die("Pb avec la requete ".mysql_error());}
if (mysql_num_rows($req) == 0) {
   echo "Aucune ligne trouv&eacute;e, rien &agrave; afficher.";
   exit;
}
echo "<br><table border=1><tr> <td> id_util </td><td> nom </td> <td> email </td><td> photo </td><td>mdp</td> </tr>";
       while($row=mysql_fetch_assoc($req)){
         echo "<tr><td>".$row["id_util"]."</td><td>".$row["nom"]."</td><td>".$row["email"]."</td><td><img src=\"".$row["photo_profil"]."\"></td><td>".$row["mdp"]."</td></tr>";
       }
       echo "</table><br><br>";


mysql_free_result($req);
mysql_close($connex);
?>
<a href="controleur.php?page=accueil_test.php"> retour a l accueil </a>
</body>

</html>
