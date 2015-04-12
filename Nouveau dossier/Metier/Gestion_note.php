<?php
//-------------Déjà Noté?------------
function deja_note($id,$num_crit){
    $connex=connexion_bdd();
    $sql="select * from Notation where id_noteur=\"".$id."\" and num_critere=\"".$num_crit."\"";
    $req=mysql_query($sql,$connex);
	if(!$req){Die("Pb avec la requete ".mysql_error());}
	if(mysql_num_rows($req)==0){
	   return "";
	}
	else{
	   $row=mysql_fetch_assoc($req);
	   $note=$row["note"];
	   return $note;
	}
	mysql_close($connex);
}


//-------------Déjà Commenté?------------
function deja_commente($id,$num_photo){
    $connex=connexion_bdd();
    $sql="select * from Commentaire where id_comm=\"".$id."\" and num_photo=\"".$num_photo."\"";
    $req=mysql_query($sql,$connex);
	if(!$req){Die("Pb avec la requete ".mysql_error());}
	if(mysql_num_rows($req)==0){
	   return "";
	}
	else{
	   $row=mysql_fetch_assoc($req);
	   $comm=$row["comm"];
	   return $comm;
	}
	mysql_close($connex);
}


//-------------Affichage page note ou peut noter------------
function aff_photo_a_noter($lien_photo){
	$num_photo=numph_lien($lien_photo);
	$critere=crit_photo($num_photo);	//num_crit,desc	
	$ph=info_photo($num_photo);
	$id_post=$ph[0];
	$titre=$ph[2];
	$date=$ph[3];
	$u=info_util($id_post);
	$nom_post=$u[0];
	$photop_post=$u[1];
	$pp="<p><br><table  width=80% align=center>\n";
	$pp=$pp."<tr>\n<td rowspan=3 width=10%><img src=\"".$photop_post."\" alt=\"photop\" width=100%></td>\n";
	$pp=$pp."<td width=80% rowspan=2> ".$nom_post."<br>a publi&eacute; le ".$date." </td>\n</tr>\n";
	$pp=$pp."<tr></tr><tr></tr>\n";
	$pp=$pp."<tr>\n<td align=center colspan=10>".$titre."</td>\n</tr>\n";
	$pp=$pp."<tr>\n<td align=center colspan=10><img src=\"".$lien_photo."\" alt=\"photo\" width=50%></td>\n</tr>\n</table>\n";
	$pp=$pp."\n<table border=1px width=60% align=center>\n";
	for($i=1;$i<count($critere);$i++){
	    $deja_note=deja_note($_SESSION["id"],$critere[$i][0]);
		$pp=$pp."<tr>\n<td  align=center>".$critere[$i][1]."&nbsp;&nbsp;</td>\n";
	    if(empty($deja_note)){
		$pp=$pp."<td width=5%><form method=\"post\" action=\"controleur.php\"><input type=\"hidden\" name=\"crit\" value=\"".$critere[$i][0]."\"><input type=\"hidden\" name=\"lien_phot\" value=\"".$lien_photo."\"><input type=\"submit\" name=\"s1\" value=\"1\"></form>\n</td>\n";
		$pp=$pp."<td width=5%><form method=\"post\" action=\"controleur.php\"><input type=\"hidden\" name=\"crit\" value=\"".$critere[$i][0]."\"><input type=\"hidden\" name=\"lien_phot\" value=\"".$lien_photo."\"><input type=\"submit\" name=\"s2\" value=\"2\"></form>\n</td>\n";
		$pp=$pp."<td width=5%><form method=\"post\" action=\"controleur.php\"><input type=\"hidden\" name=\"crit\" value=\"".$critere[$i][0]."\"><input type=\"hidden\" name=\"lien_phot\" value=\"".$lien_photo."\"><input type=\"submit\" name=\"s3\" value=\"3\"></form>\n</td>\n";
		$pp=$pp."<td width=5%><form method=\"post\" action=\"controleur.php\"><input type=\"hidden\" name=\"crit\" value=\"".$critere[$i][0]."\"><input type=\"hidden\" name=\"lien_phot\" value=\"".$lien_photo."\"><input type=\"submit\" name=\"s4\" value=\"4\"></form>\n</td>\n";
		$pp=$pp."<td width=5%><form method=\"post\" action=\"controleur.php\"><input type=\"hidden\" name=\"crit\" value=\"".$critere[$i][0]."\"><input type=\"hidden\" name=\"lien_phot\" value=\"".$lien_photo."\"><input type=\"submit\" name=\"s5\" value=\"5\"></form>\n</td>\n";
		}
		else{
		$pp=$pp."<td align=center>".$deja_note."</td><td colspan=5 align=center><form method=\"post\" action=\"controleur.php\"><input type=\"hidden\" name=\"crit\" value=\"".$critere[$i][0]."\"><input type=\"hidden\" name=\"lien_phot\" value=\"".$lien_photo."\">
		<input type=\"submit\" name=\"sub_supp_note\" value=\"Modifier\"></form></td>\n";
		}		
	}
	$pp=$pp."<tr><td align=center rowspan=2><form method=\"post\" action=\"controleur.php\">
	<textarea name=\"comment\" rows=\"5\" cols=\"30\"></textarea>
	<input type=\"hidden\" name=\"numphoto\" value=\"".$num_photo."\">
	<input type=\"hidden\" name=\"lien_phot\" value=\"".$lien_photo."\">
	<br>";
	if(empty(deja_commente($_SESSION["id"],$num_photo))){
	   $pp=$pp."<input type=\"submit\" name=\"submit_comment\" value=\"Commenter\">";
	}
	else{
	   $pp=$pp."<input type=\"submit\" name=\"modif_comm\" value=\"Modifier\">";
	}
	$pp=$pp."<input type=\"reset\" value=\"Annuler\"><input type=\"submit\" name=\"supp_comm\" value=\"Supprimer commentaire\"></form></td>\n";
	if(!empty(deja_commente($_SESSION["id"],$num_photo))){
	   $pp=$pp."<td colspan=5>Votre commentaire : <br></td>\n</tr>\n<tr>\n<td align=center colspan=5>".deja_commente($_SESSION["id"],$num_photo)."</td>\n";
	}	
	$pp=$pp."</tr>\n</table></p>";
    return $pp;		
}


//-------------Insertion note------------
function ajout_note($id,$crit,$note){
	$connex=connexion_bdd();
	$sql="insert into Notation values(\"".$id."\",\"".$crit."\",\"".$note."\")";
	$req=mysql_query($sql,$connex);
	if(!$req){Die("Pb avec la requete ".mysql_error());}
	else{return "insertion ok";}
	mysql_close($connex);
}


//-------------Suppression Note------------
function supp_note($id,$crit){
    $connex=connexion_bdd();
    $sql="delete from Notation where id_noteur=\"".$id."\" and num_critere=\"".$crit."\"";
    $req=mysql_query($sql,$connex);
	if(!$req){Die("Pb avec la requete ".mysql_error());}
	mysql_close($connex);    
}


//-------------Insertion commentaire------------
function ajout_comm($id,$num_photo,$comm){
    $connex=connexion_bdd();
    $comm=htmlentities(stripslashes($comm));
    $sql="insert into Commentaire values (\"".$id."\",\"".$num_photo."\",\"".$comm."\")";
    $req=mysql_query($sql,$connex);    
	if(!$req){Die("Pb avec la requete ".mysql_error());}
	else{return "insertion ok";}
    mysql_close($connex);
}


//-------------Modification commentaire------------
function modif_comm($id,$num_photo,$comm){
    $connex=connexion_bdd();
    $comm=htmlentities(stripslashes($comm));
    $sql="update Commentaire set comm=\"".$comm."\" where id_comm=\"".$id."\" and num_photo=\"".$num_photo."\"";
    $req=mysql_query($sql,$connex);    
	if(!$req){Die("Pb avec la requete ".mysql_error());}
	else{return "modification ok";}
    mysql_close($connex);
}


//-------------Suppression Commentaire------------
function supp_comm($id,$num_photo,$comm){
    $connex=connexion_bdd();
    $comm=htmlentities(stripslashes($comm));
    $sql="delete from Commentaire where id_comm=\"".$id."\" and num_photo=\"".$num_photo."\"";
    $req=mysql_query($sql,$connex);    
	if(!$req){Die("Pb avec la requete ".mysql_error());}
	else{return "suppression ok";}
    mysql_close($connex);
}

?>
