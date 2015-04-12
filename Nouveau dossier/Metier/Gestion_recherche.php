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


//5---------------Recherche info util----------------------------
function info_util($id){
	$connex = connexion_bdd();
	$sql="select * from Utilisateur where id_util=\"".$id."\"";
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
		$a=array();
		$a[0]=$row["nom"];$a[1]=$row["photo_profil"];
		return $a;
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


//25-------------Recherche info photo------------
function info_photo($num_photo){
	$connex = connexion_bdd();
	$sql="select * from Photo where num_photo=\"".$num_photo."\"";
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
		$a=array();
		$a[0]=$row["id_post"];
		$a[1]=$row["lien_photo"];
		$a[2]=$row["titre"];
		$a[3]=$row["date_publ"];
		return $a;
	}
	mysql_close($connex);	
}


//45-------------Recherche criteres photo------------
function crit_photo($num_photo){
	$connex = connexion_bdd();
	$sql="select * from Critere where num_photo=\"".$num_photo."\"";
	$req = mysql_query($sql,$connex);
	if(!$req){
		Die("Pb avec la requete ".mysql_error());
	}
	$critere=array();$i=0;
	while($row=mysql_fetch_assoc($req)){
		$critere[$i][0]=$row["num_critere"];
		$critere[$i][1]=$row["description"];
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
	$sql1 = "select id_util2,nom,photo_profil from Ami,Utilisateur where id_util=id_util2 and id_util1=\"$id\"";
	$req1 = mysql_query($sql1,$connex);
	if(!$req1){Die("Pb avec la requete ".mysql_error());}
	while($row1=mysql_fetch_assoc($req1)){
		$A[$i][0]=$row1["id_util2"];
		$A[$i][1]=$row1["nom"];
		$A[$i][2]=$row1["photo_profil"];
		$i++;
	}
	$sql2 = "select id_util1,nom,photo_profil from Ami,Utilisateur where id_util=id_util1 and id_util2=\"$id\"";
	$req2 = mysql_query($sql2,$connex);
	if(!$req2){Die("Pb avec la requete ".mysql_error());}
	while($row2=mysql_fetch_assoc($req2)){
		$A[$i][0]=$row2["id_util1"];
		$A[$i][1]=$row2["nom"];
		$A[$i][2]=$row2["photo_profil"];
		$i++;
	}
	mysql_close($connex);
	return $A;	
}



//89-------------Recherche toutes photos postees------------
function photo_perso($id){
	$ens_photo=array();
	$connex = connexion_bdd();
	$sql = "select * from Photo where id_post=\"".$id."\"";
	$req = mysql_query($sql,$connex);
	if(!$req){Die("Pb avec la requete ".mysql_error());}
	$i=0;
	while($row=mysql_fetch_assoc($req)){
		$ens_photo[$i][0]=$row["lien_photo"];
		$ens_photo[$i][1]=$row["titre"];
		$ens_photo[$i][2]=$row["date_publ"];
		$ens_photo[$i][3]=$row["num_photo"];
		$i++;
	}
	return $ens_photo;
	mysql_close($connex);	
}



//107-------------Recherche simple (dans tout(nom,titre,critere,commentaire))------------
//114--------Recherche dans nom utilisateur
function rech_util($R){
	$connex = connexion_bdd();
	$pp="";
	$R=htmlentities(stripslashes($R));

	$tok=strtok($R," ");

	$i=0;

	while($tok){

		$mot[$i]=$tok;

		$i++;

		$tok=strtok(" ");

	}

	$i=0;$A=array();
	for($I=0;$I<count($mot);$I++){

		$sql = "select * from Utilisateur where nom like \"%".$mot[$I]."%\"";
		$req = mysql_query($sql,$connex);
		if(!$req){Die("Pb avec la requete ".mysql_error());}
		if (mysql_num_rows($req) != 0) {		
			while($row=mysql_fetch_assoc($req)){
				$A[$i][0]=$row["nom"];
				$A[$i][1]=$row["photo_profil"];
				$i++;
			}
		}
	}
if(!empty($A)){//211
		$pp=$pp."<table >\n";$k=5;$m=0;
		for($j=0;$j<(2*$k*(1+count($A)/($k+1)));$j=$j+$k){
			$pp=$pp."<tr>\n";
			if($j%($k*2)==0){
				for($i=$j/2;$i<($j/2)+$k && $i<count($A);$i++){
					$titre=$A[$i][0];				
					$pp=$pp."<td align=center >". $titre."</td>";
				}
			}
			else{
				for($i=($j-$k)/2;$i<(($j-$k)/2)+$k && $i<count($A);$i++){
					$photo=$A[$i][1];			
					$pp=$pp."<td align=center ><img src=\"".$photo."\" width=50px> </td>";
				}
			}
			$pp=$pp."</tr>\n";
		}
       		$pp=$pp. "</table>\n<br><br>";
	}
else{$pp="Aucun resultats trouv&eacute;s.<br><br>\n";}
	mysql_close($connex);
	return $pp;
}
//173---------Recherche dans titre photo
function rech_titre($R){
	$connex = connexion_bdd();
	$pp="";

	$R=htmlentities(stripslashes($R));

	$tok=strtok($R," ");

	$i=0;

	while($tok){

		$mot[$i]=$tok;

		$i++;

		$tok=strtok(" ");

	}

	$i=0;$A=array();
	for($I=0;$I<count($mot);$I++){

		$sql = "select * from Photo where titre like \"%".$mot[$I]."%\"";
		$req = mysql_query($sql,$connex);
		if(!$req){Die("Pb avec la requete ".mysql_error());}
		if (mysql_num_rows($req) != 0) {		
			while($row=mysql_fetch_assoc($req)){
				$A[$i][0]=$row["titre"];
				$A[$i][1]=$row["lien_photo"];
				$i++;
			}
		}
	}
if(!empty($A)){//211
		$pp=$pp."<table >\n";$k=5;$m=0;
		for($j=0;$j<(2*$k*(1+count($A)/($k+1)));$j=$j+$k){
			$pp=$pp."<tr>\n";
			if($j%($k*2)==0){
				for($i=$j/2;$i<($j/2)+$k && $i<count($A);$i++){
					$titre=$A[$i][0];				
					$pp=$pp."<td align=center >". $titre."</td>";
				}
			}
			else{
				for($i=($j-$k)/2;$i<(($j-$k)/2)+$k && $i<count($A);$i++){
					$photo=$A[$i][1];			
					$pp=$pp."<td align=center ><img src=\"".$photo."\" width=50px> </td>";
				}
			}
			$pp=$pp."</tr>\n";
		}
       		$pp=$pp. "</table>\n<br><br>";
	}
else{$pp="Aucun resultats trouv&eacute;s.<br><br>\n";}
	mysql_close($connex);
	return $pp;
}

//229---------Recherche dans titre photo suivant la date
function rech_titred($R, $desc){
	$connex = connexion_bdd();
	$pp="";

	$R=htmlentities(stripslashes($R));

	$tok=strtok($R," ");

	$i=0;

	while($tok){

		$mot[$i]=$tok;

		$i++;

		$tok=strtok(" ");

	}

	$i=0;$A=array();
	for($I=0;$I<count($mot);$I++){

		$sql = "select * from Photo where titre like \"%".$mot[$I]."%\" ORDER BY $desc";
		$req = mysql_query($sql,$connex);
		if(!$req){Die("Pb avec la requete ".mysql_error());}
		if (mysql_num_rows($req) != 0) {		
			while($row=mysql_fetch_assoc($req)){
				$A[$i][0]=$row["titre"];
				$A[$i][1]=$row["lien_photo"];
				$i++;
			}
		}
	}
if(!empty($A)){//211
		$pp=$pp."<table >\n";$k=5;$m=0;
		for($j=0;$j<(2*$k*(1+count($A)/($k+1)));$j=$j+$k){
			$pp=$pp."<tr>\n";
			if($j%($k*2)==0){
				for($i=$j/2;$i<($j/2)+$k && $i<count($A);$i++){
					$titre=$A[$i][0];				
					$pp=$pp."<td align=center >". $titre."</td>";
				}
			}
			else{
				for($i=($j-$k)/2;$i<(($j-$k)/2)+$k && $i<count($A);$i++){
					$photo=$A[$i][1];			
					$pp=$pp."<td align=center ><img src=\"".$photo."\" width=50px> </td>";
				}
			}
			$pp=$pp."</tr>\n";
		}
       		$pp=$pp. "</table>\n<br><br>";
	}
else{$pp="Aucun resultats trouv&eacute;s.<br><br>\n";}
	mysql_close($connex);
	return $pp;
}

//236---------Recherche dans critere photo
function rech_critere($R){
	$connex = connexion_bdd();
	$pp="";
	$R=htmlentities(stripslashes($R));

	$tok=strtok($R," ");

	$i=0;

	while($tok){

		$mot[$i]=$tok;

		$i++;

		$tok=strtok(" ");

	}

	$i=0;$A=array();
	for($I=0;$I<count($mot);$I++){

		$sql = "select * from Critere,Photo where description like \"%".$mot[$I]."%\" and Critere.num_photo=Photo.num_photo";
		$req = mysql_query($sql,$connex);
		if(!$req){Die("Pb avec la requete ".mysql_error());}
		if (mysql_num_rows($req) != 0) {		
			while($row=mysql_fetch_assoc($req)){
				$A[$i][0]=$row["titre"];
				$A[$i][1]=$row["lien_photo"];
				$A[$i][2]=$row["description"];
				$i++;
			}
		}
	}
	if(!empty($A)){
		$pp=$pp."<table>\n";$k=1;
		for($j=0;$j<2*count($A);$j=$j+$k){ 
			$pp=$pp."<tr>\n";//167
			if($j%($k*2)==0){
				for($i=$j/2;$i<($j/2)+$k && $i<count($A);$i++){
					$titre=$A[$i][0];					
					$pp=$pp."<td align=center>". $titre."</td>";
				}
			}
			else{
				for($i=$j/2;$i<($j/2)+$k && $i<count($A);$i++){
				//for($i=($j-$k)/2;$i<(($j-$k)/2)+$k && $i<count($A);$i++){
					$photo=$A[$i][1];			
					$pp=$pp."<td align=center width=20%><img src=\"".$photo."\" width=50px> </td><td>".$A[$i][2]."</td><br>";
				}
			}
			$pp=$pp."</tr>\n";
		}
       		$pp=$pp. "</table>\n<br>\n";
	}
	else{$pp="Aucun resultats trouv&eacute;s.<br><br>\n";}
	mysql_close($connex);
	return $pp;
}

//236---------Recherche dans critere photo suivant une date
function rech_critered($R, $desc){
	$connex = connexion_bdd();
	$pp="";
	$R=htmlentities(stripslashes($R));

	$tok=strtok($R," ");

	$i=0;

	while($tok){

		$mot[$i]=$tok;

		$i++;

		$tok=strtok(" ");

	}

	$i=0;$A=array();
	for($I=0;$I<count($mot);$I++){

		$sql = "select * from Critere,Photo where description like \"%".$mot[$I]."%\" and Critere.num_photo=Photo.num_photo ORDER BY $desc";
		$req = mysql_query($sql,$connex);
		if(!$req){Die("Pb avec la requete ".mysql_error());}
		if (mysql_num_rows($req) != 0) {		
			while($row=mysql_fetch_assoc($req)){
				$A[$i][0]=$row["titre"];
				$A[$i][1]=$row["lien_photo"];
				$A[$i][2]=$row["description"];
				$i++;
			}
		}
	}
	if(!empty($A)){
		$pp=$pp."<table>\n";$k=1;
		for($j=0;$j<2*count($A);$j=$j+$k){ 
			$pp=$pp."<tr>\n";//167
			if($j%($k*2)==0){
				for($i=$j/2;$i<($j/2)+$k && $i<count($A);$i++){
					$titre=$A[$i][0];					
					$pp=$pp."<td align=center>". $titre."</td>";
				}
			}
			else{
				for($i=$j/2;$i<($j/2)+$k && $i<count($A);$i++){
				//for($i=($j-$k)/2;$i<(($j-$k)/2)+$k && $i<count($A);$i++){
					$photo=$A[$i][1];			
					$pp=$pp."<td align=center width=20%><img src=\"".$photo."\" width=50px> </td><td>".$A[$i][2]."</td><br>";
				}
			}
			$pp=$pp."</tr>\n";
		}
       		$pp=$pp. "</table>\n<br>\n";
	}
	else{$pp="Aucun resultats trouv&eacute;s.<br><br>\n";}
	mysql_close($connex);
	return $pp;
}
//296---------Recherche dans commentaire photo
function rech_comm($R){
	$connex = connexion_bdd();
	$pp="";
	$R=htmlentities(stripslashes($R));

	$tok=strtok($R," ");

	$i=0;

	while($tok){

		$mot[$i]=$tok;

		$i++;

		$tok=strtok(" ");

	}

	$i=0;$A=array();
	for($I=0;$I<count($mot);$I++){

		$sql = "select * from Commentaire,Photo where comm like \"%".$mot[$I]."%\" and Commentaire.num_photo=Photo.num_photo";
		$req = mysql_query($sql,$connex);
		if(!$req){Die("Pb avec la requete ".mysql_error());}
		if (mysql_num_rows($req) != 0) {		
			while($row=mysql_fetch_assoc($req)){
				$A[$i][0]=$row["titre"];
				$A[$i][1]=$row["lien_photo"];
				$A[$i][2]=$row["comm"];
				$i++;
			}
		}
	}
	if(!empty($A)){
		$pp=$pp."<table >\n";$k=1;
		for($j=0;$j<2*count($A);$j=$j+$k){ 
			$pp=$pp."<tr>\n";//167
			if($j%($k*2)==0){
				for($i=$j/2;$i<($j/2)+$k && $i<count($A);$i++){
					$titre=$A[$i][0];					
					$pp=$pp."<td align=center>". $titre."</td>";
				}
			}
			else{
				for($i=$j/2;$i<($j/2)+$k && $i<count($A);$i++){
				//for($i=($j-$k)/2;$i<(($j-$k)/2)+$k && $i<count($A);$i++){
					$photo=$A[$i][1];			
					$pp=$pp."<td align=center width=20%><img src=\"".$photo."\" width=50px> </td><td>".$A[$i][2]."</td>";
				}
			}
			$pp=$pp."</tr>\n";
		}
       		$pp=$pp. "</table>\n<br><br>\n";
	}
	else{$pp="Aucun resultats trouv&eacute;s.<br><br>";}
	mysql_close($connex);
	return $pp;
}

?>
