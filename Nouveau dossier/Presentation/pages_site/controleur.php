<?php session_start();?>
<!DOCTYPE html>
<html>
<body>
<?php
if(!isset($_SESSION["etat"])){$_SESSION["etat"]="nonconn";}
if(!isset($page)){$page="accueil.php";}

require("../../Metier/Gestion_client.php");
require("../../Metier/Gestion_photo.php");
require("../../Metier/Gestion_ami.php");
require("../../Metier/Gestion_file.php");
require("../../Metier/Gestion_recherche.php");
require("../../Metier/Gestion_note.php");
require("../../Metier/Gestion_evaluation.php");


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
		desinscript($_SESSION["id"]);
	    
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

//78--Publication de photo (insertion)

	if(isset($_POST["publ_photo"])){
		$taille=$_FILES["mon_fichier"]["size"];//80
		$type=$_FILES["mon_fichier"]["type"];
		$titre=$_POST["titre"];
		$critere=$_POST["critere"];
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
			$M=publ_photo($fichier,$taille,$type,$nom_fichier,$tmp,$titre,$date,$_SESSION["id"],$_SESSION["nom"],$critere);
			$msg=$M[0];
			$msg2=$M[1];
			$msg3=$M[2];
		}
		$page="profil.php";	
	}

//105
	if(isset($_POST["rech_ami"])){
		aff_ami_pot($_POST["rech_ami"]);
		$page="ami.php";
	}


//112Ajout d'ami	
	if(isset($_POST["ajout_ami"])){
		ajout_ami($_SESSION["id"],$_POST["id_ami"]);
		$page="ami.php";
	}

//118Recherche simple
	if(isset($_POST["Rech"])){
		$res_util=rech_util($_POST["Rech"]);
		$res_titre=rech_titre($_POST["Rech"]);
		$res_crit=rech_critere($_POST["Rech"]);
		$res_comm=rech_comm($_POST["Rech"]);
		$page="res.php";
	}
//126Recherche avancée
	if(isset($_POST["mot"]) && isset($_POST["submit_rech_av"])){
		if(isset($_POST["t"])) {
			if (isset($_POST["date-rgt"])){ $res_titre=rech_titred($_POST["mot"], $_POST["date-rgt"]);}
			else{ $res_titre=rech_titre($_POST["mot"]);}
		}
		if(isset($_POST["n"])) {$res_util=rech_util($_POST["mot"]);}
		if(isset($_POST["c"])) {
			if (isset($_POST["date-rgt"])){ $res_crit = rech_critered($_POST["mot"], $_POST["date-rgt"]);}
			else{ $res_crit=rech_critere($_POST["mot"]);}
		}
		if(isset($_POST["co"])){$res_comm=rech_comm($_POST["mot"]);}
		if(isset($_POST["a"])){$res_ami=rech_ami_util($_POST["mot"]);}
		
		$page="resav.php";
	}

//142Navigation entre les pages
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
			case "p":
				$page="profil.php";
				break;
			case "er":	
				$page="evaluation_recue.php";
				break;
			case "ed":	
				$page="evaluation_donnee.php";
				break;
			case "n":
				$page="note.php";
				break;
			case "r":
				$page="rech_av.php";
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

//180Gestion des files
	if($page=="accueil_util.php"){
		$FG=file_ami($_SESSION["id"]);
		$FC=file_centrale($_SESSION["id"]);
		$FD=file_perso($_SESSION["id"]);
		if(isset($_POST["lien_photo"])){
			$pp=aff_photo_a_noter($_POST["lien_photo"]);
			$page="note.php";
		}
	}
//Gestion des criteres des photos
	if($page=="publ_photo.php"){
		if(isset($_POST["submit_c2"])){ //renommer photo
			$c2=htmlentities(stripslashes($_POST["c2"]));
			ajout_critere($c2,$_POST["lien_mv"]);
		}	   
	}
//191Gestion des photos dans profil
	//if($page=="profil.php"){
	    if(isset($_POST["modif_photop"])){//modifier photo profil
  	      $taille=$_FILES["mon_fichier"]["size"];//80
		  $type=$_FILES["mon_fichier"]["type"];
		  $fichier=$_FILES["mon_fichier"];
		  $nom_fichier=$_FILES["mon_fichier"]["name"];
		  $tmp=$_FILES["mon_fichier"]["tmp_name"];

		  $err=$_FILES["mon_fichier"]["error"];$msg="";
		  if($err==UPLOAD_ERR_NO_FILE){$msg="fichier manquant";}
		  if($err==UPLOAD_ERR_INI_SIZE){$msg="trop gros pour PHP";}
		  if($err==UPLOAD_ERR_FORM_SIZE){$msg="fichier trop gros pour le formulaire";}
		  if($err==UPLOAD_ERR_PARTIAL){$msg="fichier transfere partiellementmanquant";}
		  if(empty($msg)){
			$msg="";$msg2="";
			$M=modif_photop($fichier,$taille,$type,$nom_fichier,$tmp,$_SESSION["id"],$_SESSION["nom"]);
			$page="profil.php";
	     	}
	    }
		if(isset($_POST["submit_t2"])){ //renommer photo
			$t2=htmlentities(stripslashes($_POST["t2"]));
			renom_photo($t2,$_POST["lien_mv"]);
		}
		if(isset($_POST["submit_rm"])){	//supprimer photo		
			supp_photo($_POST["lien_rm"]);
		}
		if(isset($_POST["submit_desinscription"])){
		    $page="accueil_util.php";
		}
		if(isset($_GET["des"])){
		  desinscript($_SESSION["nom"]);
		  $page="accueil.php";
		}  
	//}

//208Gestion des amis	
	if($page=="ami.php"){
		$A=rech_ami_util($_SESSION["id"]);		
		if(isset($_POST["rech_ami"])){
		      
			$ppp=aff_ami_pot($_POST["rech_ami"]);
		}
		$pp=aff_ami_perso($_SESSION["id"]);
	}

//223Gestion notation
	if(isset($_POST["s1"])){
		ajout_note($_SESSION["id"],$_POST["crit"],1);
	    $pp=aff_photo_a_noter($_POST["lien_phot"]);
	    $page="note.php";
	}
	if(isset($_POST["s2"])){
        ajout_note($_SESSION["id"],$_POST["crit"],2);
	    $pp=aff_photo_a_noter($_POST["lien_phot"]);
	    $page="note.php";
	}
	if(isset($_POST["s3"])){
        ajout_note($_SESSION["id"],$_POST["crit"],3);
	    $pp=aff_photo_a_noter($_POST["lien_phot"]);
	    $page="note.php";
	}
	if(isset($_POST["s4"])){
        ajout_note($_SESSION["id"],$_POST["crit"],4);
	    $pp=aff_photo_a_noter($_POST["lien_phot"]);
	    $page="note.php";
	}
	if(isset($_POST["s5"])){
        ajout_note($_SESSION["id"],$_POST["crit"],5);
	    $pp=aff_photo_a_noter($_POST["lien_phot"]);
	    $page="note.php";
	}
	if(isset($_POST["sub_supp_note"])){ //modifier, remplacer une note
	    supp_note($_SESSION["id"],$_POST["crit"]);
	    $pp=aff_photo_a_noter($_POST["lien_phot"]);
	    $page="note.php";
	}

//Gestion page note données
    if($page=="evaluation_donnee.php"){
        $nd=aff_detail_note_donnee($_SESSION["id"]);
    }

//217Gestion mon profil
	if($page=="profil.php"){
		$pp=aff_photo_perso($_SESSION["id"]); //Gestion_
		$nd=aff_note_donnee($_SESSION["id"]); //Gestion_evaluation
		$ap= aff_ami_perso($_SESSION["id"]);
	}

//Gestion Commentaire
    if(isset($_POST["submit_comment"])){ //inserer un comm
        ajout_comm($_SESSION["id"],$_POST["numphoto"],$_POST["comment"]);
	    $pp=aff_photo_a_noter($_POST["lien_phot"]);
	    $page="note.php";
    }
    if(isset($_POST["modif_comm"])){ //modifier un comm
            modif_comm($_SESSION["id"],$_POST["numphoto"],$_POST["comment"]);
	        $pp=aff_photo_a_noter($_POST["lien_phot"]);
	        $page="note.php";          
    }
    if(isset($_POST["supp_comm"])){ //supp un comm
            supp_comm($_SESSION["id"],$_POST["numphoto"],$_POST["comment"]);
	        $pp=aff_photo_a_noter($_POST["lien_phot"]);
	        $page="note.php";          
    }

}

require($page);

?>
</body>
</html>
