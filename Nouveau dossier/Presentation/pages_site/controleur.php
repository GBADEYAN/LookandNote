<?php session_start();?>
<!DOCTYPE html>
<html>
<body>
<?php
if(!isset($_SESSION["etat"])){$_SESSION["etat"]="nonconn";}
if(!isset($page)){$page="accueil.php";}
//if(isset($_GET["page"])){$page=$_GET["page"];}

//else{$page="accueil.php";}

require("../../Metier/Gestion_client.php");

if($etat="nonconn"){
//Inscription
if(isset($_POST["submit1"]) ){
	$var=inscript($_POST["nomi"],$_POST["emaili"],$_POST["mdp"]);	
	if(sizeof($var)==4){
		//echo "var vide<br>inscription<br>";				   
        	$_SESSION["nom"]=$var[0];
        	$_SESSION["email"]=$var[1];
        	$_SESSION["photo_p"]=$var[2];
		$_SESSION["etat"]="conn";
		//$page="test.php";
		$page="accueil_util.php";
	}
	else{
		$msg1=$var[0];
		$msg2=$var[1];
		$msg3=$var[2];
		//$page="accueil_test.php";
		$page="accueil.php";	
	}
}


//27Connexion
if(isset($_POST["submit2"])){
	$var=connex($_POST["email"],$_POST["mdp"]);
	if(sizeof($var)==3){
	        $_SESSION["nom"]=$var[0];
        	$_SESSION["email"]=$var[1];
        	$_SESSION["photo_p"]=$var[2];
		//$page="test.php";
		$page="accueil_util.php";
		$_SESSION["etat"]="conn";
	}
	else{
		$msg2=$var[0];
		$msg3=$var[1];
		//$page="accueil_test.php";
		$page="accueil.php";
	}
}

}

if($_SESSION["etat"]=="conn"){
//Desincription
if(isset($_POST["desinsc"])){
	desinscript($_SESSION["nom"]);
    //echo "Desinsc OK";
	$_SESSION["etat"]="nonconn";
	$page="accueil_test.php";
	unset_session();
}

//Deconnexion
if(isset($_POST["deconnex"])){
	deconnex();echo"Deconnexion reussie<br>";
	$_SESSION["etat"]="nonconn";
	$page="accueil_test.php";
	unset_session();
}

//Navigation entre les pages
	if(isset($_GET["page"])){
		switch( $_GET["page"]){
			case "a":
				$page="accueil_util.php";
				break;
			case "b":
				$page="publ_photo.php";
				break;

			//deconnexion
			case "z":
				deconnex();echo"Deconnexion reussie<br>";
				$page="accueil.php";
				break;
			//desinscription
			case "ZZ":
				$var=desinscript($_SESSION["nom"]);echo $var." Desinsc OK";
				$page="accueil.php";
				break;
			default:
				$page="accueil_util.php";
		}
	
	}

}



require($page);
?>
</body>
</html>
