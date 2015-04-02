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
require("../../Metier/Gestion_photo.php");
require("../../Metier/Gestion_ami.php");
require("../../Metier/Gestion_file.php");
require("../../Metier/Gestion_recherche.php");


if($etat="nonconn"){
//16---Inscription
	if(isset($_POST["submit1"]) ){
		$var=inscript($_POST["nomi"],$_POST["emaili"],$_POST["mdp"]);	
		if(sizeof($var)==4){
			//echo "var vide<br>inscription<br>";	
			$_SESSION["id"]=$var[0];			   
        		$_SESSION["nom"]=$var[1];
	        	$_SESSION["email"]=$var[2];
        		$_SESSION["photo_p"]=$var[3];
			$_SESSION["etat"]="conn";
			$page="accueil_util.php";
		}
		else{
			$msg1=$var[0];
			$msg2=$var[1];
			$msg3=$var[2];
			$page="accueil.php";	
		}
	}

//38--Connexion
	if(isset($_POST["submit2"])){
		$var=connex($_POST["email"],$_POST["mdp"]);
		if(sizeof($var)==4){	
			$_SESSION["id"]=$var[0];			   
        		$_SESSION["nom"]=$var[1];
	        	$_SESSION["email"]=$var[2];
        		$_SESSION["photo_p"]=$var[3];
			$page="accueil_util.php";
			$_SESSION["etat"]="conn";
		}
		else{
			$msg2=$var[0];
			$msg3=$var[1];
			$page="accueil.php";
		}
	}

}



if($_SESSION["etat"]=="conn"){
//63--Desincription
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

//80--Publication de photo (insertion)
	if(isset($_POST["publ_photo"])){
		$taille=$_FILES["mon_fichier"]["size"];//80
		$type=$_FILES["mon_fichier"]["type"];
		$titre=$_POST["titre"];
		$fichier=$_FILES["mon_fichier"];
		$nom_fichier=$_FILES["mon_fichier"]["name"];
		$tmp=$_FILES["mon_fichier"]["tmp_name"];
		$date=DATE("Y-m-d H:i:s");

		$err=$_FILES["mon_fichier"]["error"];$msg="";
		if($err==UPLOAD_ERR_NO_FILE){$msg="fichier manquant";}
		if($err==UPLOAD_ERR_INI_SIZE){$msg="trop gros pour PHP";}
		if($err==UPLOAD_ERR_FORM_SIZE){$msg="fichier trop gros pour le formulaire";}
		if($err==UPLOAD_ERR_PARTIAL){$msg="fichier transfere partiellementmanquant";}
		if(empty($msg)){
			$msg="";$msg2="";
			$M=publ_photo($fichier,$taille,$type,$nom_fichier,$tmp,$titre,$date,$_SESSION["id"],$_SESSION["nom"]);
			$msg=$M[0];
			$msg2=$M[1];
		}
		$page="publ_photo.php";	
	}

//
	if(isset($_POST["rech_ami"])){
		aff_ami_pot($_POST["rech_ami"]);
		$page="ami.php";
	}


//Ajout d'ami	
	if(isset($_POST["ajout_ami"])){
		ajout_ami($_SESSION["id"],$_POST["id_ami"]);
		$page="ami.php";
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
			case "c":
				$page="ami.php";
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

//Gestion des files
	if($page=="accueil_util.php"){
		$FG=file_ami($_SESSION["id"]);
		$FC=file_centrale($_SESSION["id"]);
		$FD=file_perso($_SESSION["id"]);
	}

//Gestion des photos
	if($page=="publ_photo.php"){
		if(isset($_POST["submit_t2"])){
			$t2=htmlentities(stripslashes($_POST["t2"]));
			renom_photo($t2,$_POST["lien_mv"]);
		}
		if(isset($_POST["submit_rm"])){			
			supp_photo($_POST["lien_rm"]);echo "supp photo ok";
		}
		
		$pp=aff_photo_perso($_SESSION["id"]);
	}

//Gestion des amis	
	if($page=="ami.php"){
		$A=rech_ami_util($_SESSION["id"]);		
		if(isset($_POST["rech_ami"])){
			$ppp=aff_ami_pot($_POST["rech_ami"]);
		}
		$pp=aff_ami_perso($_SESSION["id"]);
	}

}

require($page);

?>
</body>
</html>
