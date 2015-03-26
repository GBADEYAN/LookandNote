<?php session_start();
?>
<!DOCTYPE html>
<html>
<body>
<?php
$S_nom=$_SESSION["nom"]; $S_email=$_SESSION["email"];
echo "Bonjour ".$S_nom.", ton mail est :".$S_email."<br>";

echo "<form action=\"res.php\" method=\"post\">\n";
echo "<input type=\"submit\" name=\"desinsc\" value=\"Se desinscrire\">";
echo "</form>";


echo "<form action=\"res.php\" method=\"post\">\n";
echo "<input type=\"submit\" name=\"deconnex\" value=\"Se deconnecter\">";
echo "</form>";


echo "<a href=\"controleur.php?page=affichage_table.php\">Table Utilisateur</a>";

?>
</body>
</html>
