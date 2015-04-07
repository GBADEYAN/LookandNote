<?php

require_once("Gestion_bdd.php");

//5---------------Recherche id_util----------------------------
function id_nom($nom){
	$connex = connexion_bdd();
	$sql="select id_util from Utilisateur where nom=\"".$nom."\"";
	$req = mysql_query($sql,$connex);
	if(!$req){
		Die("Pb avec la requete ".mysql_error());
	}
	if (mysql_num_rows($req) == 0) {
		echo "Aucune ligne trouv&eacute;e, rien &agrave; afficher2.";
		exit;
	}
	else{ 
		$row=mysql_fetch_assoc($req);
		return $row["id_util"];
	}
	mysql_close($connex);
}


//25-------------Recherche num_photo------------
function numph_lien($lien){
	$connex = connexion_bdd();
	$sql="select num_photo from Photo where lien_photo=\"".$lien."\"";
	$req = mysql_query($sql,$connex);
	if(!$req){
		Die("Pb avec la requete ".mysql_error());
	}
	if (mysql_num_rows($req) == 0) {
		echo "Aucune ligne trouv&eacute;e, rien &agrave; afficher2.";
		exit;
	}
	else{ 
		$row=mysql_fetch_assoc($req);
		return $row["num_photo"];
	}
	mysql_close($connex);	
}


//45-------------Recherche criteres photo------------
function crit_photo($num_photo){
	$connex = connexion_bdd();
	$sql="select num_critere from Critere where num_photo=\"".$num_photo."\"";
	$req = mysql_query($sql,$connex);
	if(!$req){
		Die("Pb avec la requete ".mysql_error());
	}
	$critere=array();$i=0;
	while($row=mysql_fetch_assoc($req)){
		$critere[$i]=$row["num_critere"];
		$i++;
	}
	return $critere;	
	mysql_close($connex);	
}


//63-------------Recherche tout ami------------

function rech_ami_util($id){
	$connex = connexion_bdd();
	$i=0;
	$A=array();
	$sql1 = "select id_util2 from Ami where id_util1=\"$id\"";
	$req1 = mysql_query($sql1,$connex);
	if(!$req1){Die("Pb avec la requete ".mysql_error());}
	while($row1=mysql_fetch_assoc($req1)){
		$A[$i]=$row1["id_util2"];
		$i++;
	}
	$sql2 = "select id_util1 from Ami where id_util2=\"$id\"";
	$req2 = mysql_query($sql2,$connex);
	if(!$req2){Die("Pb avec la requete ".mysql_error());}
	while($row2=mysql_fetch_assoc($req2)){
		$A[$i]=$row2["id_util1"];
		$i++;
	}
	mysql_close($connex);
	return $A;	
}



//89-------------Recherche toutes photos postees------------
function lienphoto_perso($id){
	$ens_photo=array();
	$connex = connexion_bdd();
	$sql = "select lien_photo from Photo where id_post=\"".$id."\"";
	$req = mysql_query($sql,$connex);
	if(!$req){Die("Pb avec la requete ".mysql_error());}
	$i=0;
	while($row=mysql_fetch_assoc($req)){
		$ens_photo[$i]=$row["lien_photo"];
		$i++;
	}
	return $ens_photo;
	mysql_close($connex);	
}



//107-------------Recherche comm------------

?>
