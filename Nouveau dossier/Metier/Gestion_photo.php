<?php

require_once("Gestion_bdd.php");

//5---------Publication de photo (insertion)------------
function publ_photo($fichier,$taille,$type,$nom_fichier,$tmp,$titre,$date,$id,$nom,$critere){
	$msg="";$msg2="";$msg3="";
	$dir_d = "../../Donnees/";

	$extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' );
	//1. strrchr renvoie l'extension avec le point (« . »).
	//2. substr(chaine,1) ignore le premier caractère de chaine.
	//3. strtolower met l'extension en minuscules.
	if(!empty($fichier) && !empty($taille) && !empty($type) &&!empty($tmp)){
		$extension_upload = strtolower(  substr(  strrchr($nom_fichier, '.')  ,1)  );
		if ( !in_array($extension_upload,$extensions_valides) ){
		 	$msg= "(*) Extension incorrecte";
		}
		$maxwidth=4000;
		$maxheight=4000;
		$image_sizes = getimagesize($tmp);
		if ($image_sizes[0] > $maxwidth OR $image_sizes[1] > $maxheight){
			 $msg = "(*) Image trop grande";
		}
	}
	else{
		$msg="(*) fichier photo manquant";
	}
	
	$titre = stripslashes(htmlentities($titre,ENT_QUOTES,'UTF-8'));
	if(strlen($titre)<1 || (!isset($titre))){//--2	
       		$msg2 =" (*) titre obligatoire";
    	}

	if(count($critere)==1){//--2	
       		$msg3 =" (*) 1 critere obligatoire";
    	}
$i=0;
while($i<count($critere)){
	$critere[$i] = stripslashes(htmlentities($critere[$i],ENT_QUOTES,'UTF-8'));
$i++;
}

	if(empty($msg) && empty($msg2) && empty($msg3)){
		$connex=connexion_bdd();		
	//verif pas deja la
		$sql0="select * from Photo where lien_photo=\"".$dir_d.$nom."/".$nom_fichier."\" and id_post=\"".$id."\"";
		$req0=mysql_query($sql0,$connex);
		if(mysql_num_rows($req0)>0){
			$msg="(*) photo deja enregistree, veuillez changer le nom de votre fichier";
		}
		else{
			$sql="insert into Photo (id_post,titre,date_publ,lien_photo) values (\"".$id."\",\"".$titre."\",\"".$date."\",\"".$dir_d.$nom."/".$nom_fichier."\")";
			$req=mysql_query($sql,$connex);
	   		if(!$req){//--5
           			Die("Requete invalide:".mysqli_connect_error());
       			}
			else { 
				$sql0="select num_photo from Photo where id_post=\"".$id."\" and titre=\"".$titre."\" and date_publ=\"".$date."\"";
				$req0=mysql_query($sql0,$connex);
				if(!$req0){//--5
           			Die("Requete invalide:".mysqli_connect_error());
       				}
				else {
					$row=mysql_fetch_assoc($req0);
					$i=0;
					while($i<count($critere)){
					$sql1="insert into Critere (description,num_photo) values (\"".$critere[$i]."\",\"".$row["num_photo"]."\")";
					$req1=mysql_query($sql1,$connex);
					if(!$req1){//--5
           				Die("Requete invalide:".mysqli_connect_error());
       					}
					$i++;
					}
				$res=move_uploaded_file($tmp,$dir_d.$nom."/".$nom_fichier);
				if($res){echo "OOOOK!";}
				else{echo "Argh!";}		
				}
			}
		}
	}
	
		return array($msg,$msg2,$msg3);	
}



//56---------Renommer des photos perso------------
function renom_photo($t2,$lien){	
	$connex = connexion_bdd();
	$t2=htmlentities(stripslashes($t2));
	$sql="update Photo set titre=\"".$t2."\" where lien_photo=\"".$lien."\"";
	$req = mysql_query($sql,$connex);
	if(!$req){
		Die("Pb avec la requete ".mysql_error());
	}
	return "";
	mysql_close($connex);
}



//56---------Supprimer des photos perso------------
function supp_photo($lien){		
	$connex = connexion_bdd();
$num_photo=numph_lien($lien);
$sql01="delete from Commentaire where num_photo=\"".$num_photo."\"";
$req01 = mysql_query($sql01,$connex);
	if(!$req01){
		Die("Pb avec la requete 01 ".mysql_error());
	}
$critere=array();
$critere=crit_photo($num_photo);
for($i=0;$i<count($critere);$i++){
$sql02="delete from Notation where num_critere=\"".$critere[$i]."\"";
$sql03="delete from Critere where num_critere=\"".$critere[$i]."\"";
$req02 = mysql_query($sql02,$connex);
	if(!$req02){
		Die("Pb avec la requete 02 ".mysql_error());
	}
$req03 = mysql_query($sql03,$connex);
	if(!$req03){
		Die("Pb avec la requete 03 ".mysql_error());
	}
}
	$sql="delete from Photo where num_photo=\"".$num_photo."\"";
	$req = mysql_query($sql,$connex);
	if(!$req){
		Die("Pb avec la requete ".mysql_error());
	}
	return "";
}



//---------Ajouter des criteres------------
function ajout_critere($c2,$lien){
	$connex = connexion_bdd();
	$sql="select num_photo from Photo where lien_photo=\"".$lien."\"";
	$req = mysql_query($sql,$connex);
	if(!$req){
		Die("Pb avec la requete ".mysql_error());
	}
	$row=mysql_fetch_assoc($req);
	$sql1="insert into Critere (description) values(\"".$c."\") where num_photo=\"".$row["num_photo"]."\"";
	$req1=mysql_query($sql1,$connex);
	if(!$req1){
		Die("Pb avec la requete ".mysql_error());
	}
	return "";
}



//56---------Affichage des photos perso------------
function aff_photo_perso($id){
	$connex = connexion_bdd();
	$pp="<h3>Photos publi&eacute;es : </h3>";

	$sql = "select * from Photo where id_post=\"".$id."\"";
	$req = mysql_query($sql,$connex);
	if(!$req){Die("Pb avec la requete ".mysql_error());}
	if (mysql_num_rows($req) == 0) {
	   $pp=$pp."Pas de photos publi&eacute;es actuellement.";
	}
	else{
		
		

		$pp =$pp. "<br><table border=1><tr> <td> id_post </td><td> titre </td> <td> date </td><td> photo </td><td>lien</td><td>renommer</td><td>Critere</td><td>Ajouter un critere</td><td>Supprimer</td></tr>";
        	while($row=mysql_fetch_assoc($req)){
			$sql0="select * from Photo,Critere where id_post=\"".$id."\" and Critere.num_photo=Photo.num_photo and Photo.num_photo=\"".$row["num_photo"]."\"";
			$req0=mysql_query($sql0,$connex);
			if(!$req0){Die("Pb avec la requete ".mysql_error());}

        		 $pp=$pp. "<tr><td>".$row["id_post"]."</td>
					<td>".$row["titre"]."</td><td>".$row["date_publ"]."</td>
					<td><img src=\"".$row["lien_photo"]."\" width=15%></td>
					<td>".$row["lien_photo"]."</td>
					<td><form method=\"post\"><input type=\"text\" name=\"t2\"><input type=\"hidden\" name=\"lien_mv\" value=\"".$row["lien_photo"]."\"><input type=\"submit\" name=\"submit_t2\" value=\"Renommer\"></form></td><td><ul>";
			$i=1;
			while($row0=mysql_fetch_assoc($req0)){
			if($i>1){
			$pp=$pp."<li>".$row0["description"]."</li>";
			}
			$i++;
			}
			$pp=$pp."</ul></td><td><form method=\"post\"><input type=\"text\" name=\"c2\"><input type=\"hidden\" name=\"lien_mv\" value=\"".$row["lien_photo"]."\"><input type=\"submit\" name=\"submit_c2\" value=\"Ajouter\"></form></td>
					<td><form method=\"post\"><input type=\"hidden\" name=\"lien_rm\" value=\"".$row["lien_photo"]."\"><input type=\"submit\" name=\"submit_rm\" value=\"Supprimer\"></form>\n (*) Attention ceci est definitif!</td></tr>";        
		}
        $pp=$pp. "</table><br><br>";
	}
	return $pp;
}

?>
