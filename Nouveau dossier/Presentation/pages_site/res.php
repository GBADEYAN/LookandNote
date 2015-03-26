<?php session_start();?>
<!DOCTYPE html>
<html>
<body>
<?php
require("../../Metier/Gestion_client.php");
//require("../../Metier/Gestion_session.php");

//Inscription
if(isset($_POST["submit1"]) ){
	$var=inscript($_POST["nomi"],$_POST["emaili"],$_POST["mdp"]);	
	if(sizeof($var)==4){
		//echo "var vide<br>inscription<br>";				   
        $_SESSION["nom"]=$var[0];
        $_SESSION["email"]=$var[1];
        $_SESSION["photo_p"]=$var[2];
		require("test.php");
	}
	else{
		$msg1=$var[0];
		$msg2=$var[1];
		$msg3=$var[2];
		require("accueil_test.php");	
	}
}


//Desincription
if(isset($_POST["desinsc"])){
	desinscript($_SESSION["nom"]);
    //echo "Desinsc OK";
    require("accueil_test.php");
}


//27Connexion
if(isset($_POST["submit2"])){
	$var=connex($_POST["email"],$_POST["mdp"]);
	if(sizeof($var)==3){
        $_SESSION["nom"]=$var[0];
        $_SESSION["email"]=$var[1];
        $_SESSION["photo_p"]=$var[2];
		require("test.php");
	}
	else{
		$msg2=$var[0];
		$msg3=$var[1];
		require("accueil_test.php");
	}
}


//Deconnexion
if(isset($_POST["deconnex"])){
	deconnex();echo"Deconnexion reussie<br>";
    require("accueil_test.php");
}

?>
</body>
</html>
