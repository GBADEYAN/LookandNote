<?php

require_once("Gestion_bdd.php");

//---------Publication de photo (insertion)------------
function publ_photo($fichier,$taille,$type,$nom_fichier,$tmp,$titre,$date,$id,$nom){
	$msg="";$msg2="";
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

	if(empty($msg) && empty($msg2)){
		$connex=connexion_bdd();		
	//verif pas deja la
		$sql0="select * from Photo where lien_photo=\"".$dir_d.$nom."/".$nom_fichier."\" and id_post=\"".$id."\"";
		$req0=mysql_query($sql0);
		if(mysql_num_rows($req0)>0){
			$msg="(*) photo deja enregistree, veuillez changer le nom de votre fichier";
		}
		else{
			$sql="insert into Photo (id_post,titre,date_publ,lien_photo) values (\"".$id."\",\"".$titre."\",\"".$date."\",\"".$dir_d.$nom."/".$nom_fichier."\")";
			$req=mysql_query($sql);
	   		if(!$req){//--5
           			Die("Requete invalide:".mysqli_connect_error());
       			}
			else { 
				$res=move_uploaded_file($tmp,$dir_d.$nom."/".$nom_fichier);
				if($res){echo "OOOOK!";}
				else{echo "Argh!";}
			}
		}
	}
	
		return array($msg,$msg2);	
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
	$sql="delete from Photo where lien_photo=\"".$lien."\"";
	$req = mysql_query($sql,$connex);
	if(!$req){
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
		$pp =$pp. "<br><table border=1><tr> <td> id_post </td><td> titre </td> <td> date </td><td> photo </td><td>lien</td><td>renommer</td><td>Supprimer</td></tr>";
        	while($row=mysql_fetch_assoc($req)){
        		 $pp=$pp. "<tr><td>".$row["id_post"]."</td>
					<td>".$row["titre"]."</td><td>".$row["date_publ"]."</td>
					<td><img src=\"".$row["lien_photo"]."\" width=15%></td>
					<td>".$row["lien_photo"]."</td>
					<td><form method=\"post\"><input type=\"text\" name=\"t2\"><input type=\"hidden\" name=\"lien_mv\" value=\"".$row["lien_photo"]."\"><input type=\"submit\" name=\"submit_t2\" value=\"Renommer\"></form></td>
					<td><form method=\"post\"><input type=\"hidden\" name=\"lien_rm\" value=\"".$row["lien_photo"]."\"><input type=\"submit\" name=\"submit_rm\" value=\"Supprimer\"></form>\n (*) Attention ceci est definitif!</td></tr>";        
		}
        $pp=$pp. "</table><br><br>";
	}
	return $pp;
}

?>
