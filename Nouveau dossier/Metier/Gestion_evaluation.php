<?php
//------------------------Donnees--------------------------
//-------------Liste Note donnéees------------
function liste_note_donnee($id) {
    $connex=connexion_bdd();
    $sql="select * from Notation,Critere where id_noteur=\"".$id."\" and Notation.num_critere=Critere.num_critere ";
    $req=mysql_query($sql,$connex);    
	if(!$req){Die("Pb avec la requete ".mysql_error());}
	$a=array();
	$i=0;
	while($row=mysql_fetch_assoc($req)){	   
	   $a[$i][0]=$row["note"];
	   $a[$i][1]=$row["num_critere"];
	   $a[$i][2]=$row["num_photo"];
	   $P=info_photo($row["num_photo"]);	   
	   $a[$i][3]=$P[0]; //id_post   
	   $a[$i][4]=$P[1]; //lien	   
	   $a[$i][5]=$P[2]; //titre	   
	   $a[$i][6]=$P[3]; //date
	   
	   $i++;
	}
	return $a;
	mysql_close($connex);
}


//-------------Affichage Note donnéees------------
function aff_note_donnee($id) {
    $pp="<h3>Photos que vous avez not&eacute; : </h3>";

	$liste=liste_note_donnee($id);
	if(count($liste)==0){$pp=$pp."Vous n\'avez pas donn&eacute; de note pour l\'instant.";}
	else{
		
		$pp=$pp."<table >\n";$k=5;$m=0;
		for($j=0;$j<(2*$k*(1+count($liste)/($k+1)));$j=$j+$k){
			$pp=$pp."<tr>\n";//167
			if($j%($k*2)==0){
				for($i=$j/2;$i<($j/2)+$k && $i<count($liste);$i++){
					$titre=$liste[$i][5];
					$pp=$pp."<td align=center width=15px>". $titre." </td>";
				}
			}
			else{
				for($i=($j-$k)/2;$i<(($j-$k)/2)+$k && $i<count($liste);$i++){
					$lien=$liste[$i][4];		
					$pp=$pp."<td align=center width=20%><img src=\"".$lien."\" width=30%></td>";
                        
				}
			}
			$pp=$pp."</tr>\n";
		}
		$pp=$pp."</table>\n";
	}
	return $pp;
}


//-------------Affichage detail Note donnéees------------
function aff_detail_note_donnee($id) {
    $pp="<h3>Photos que vous avez not&eacute; : </h3>";

	$liste=liste_note_donnee($id);$pp=$pp.count($liste);
	if(count($liste)==0){$pp=$pp."Vous n\'avez pas donn&eacute; de note pour l\'instant.";}
	else{
		$pp=$pp."dfvwb".count($liste);
		
		for($i=0;$i<count($liste);$i++){		
		    $note=$liste[$i][0];
	        $num_critere=$liste[$i][1];
	        $num_photo=$liste[$i][2];
	        $id_post=$liste[$i][3];
	        $lien_photo=$liste[$i][4];
	        $titre=$liste[$i][5];
	        $date=$liste[$i][6];
	        $N=info_util($id_post); //nom,photop
	        $nom_post=$N[0];
	        $photop_post=$N[1];
	        $critere=crit_photo($num_photo); //num,desc
	        //$pp=$pp.aff_photo_a_noter($lien)."<br>";
	        
	        $pp=$pp."<p><br><table  width=80% align=center>\n";
	        $pp=$pp."<tr>\n<td rowspan=3 width=10%><img src=\"".$photop_post."\" alt=\"photop\" width=100%></td>\n";
	        $pp=$pp."<td width=80% rowspan=2> ".$nom_post."<br>a publi&eacute; le ".$date." </td>\n</tr>\n";
	        $pp=$pp."<tr></tr><tr></tr>\n";
	        $pp=$pp."<tr>\n<td align=center colspan=10>".$titre."</td>\n</tr>\n";
	        $pp=$pp."<tr>\n<td align=center colspan=10><img src=\"".$lien_photo."\" alt=\"photo\" width=50%></td>\n</tr>\n</table>\n";
	
	        $pp=$pp."\n<table border=1px width=60% align=center>\n";
	        for($j=1;$j<count($critere);$j++){
	           $deja_note=deja_note($_SESSION["id"],$critere[$j][0]);
	           $pp=$pp."<tr>\n<td  align=center>".$critere[$j][1]."&nbsp;&nbsp;</td>\n";
	           if(empty($deja_note)){
	           $pp=$pp."<td width=5%><form method=\"post\" action=\"controleur.php\"><input type=\"hidden\" name=\"crit\" value=\"".$critere[$j][0]."\"><input type=\"hidden\" name=\"lien_phot\" value=\"".$lien_photo."\"><input type=\"submit\" name=\"s1\" value=\"1\"></form>\n</td>\n";
	           $pp=$pp."<td width=5%><form method=\"post\" action=\"controleur.php\"><input type=\"hidden\" name=\"crit\" value=\"".$critere[$j][0]."\"><input type=\"hidden\" name=\"lien_phot\" value=\"".$lien_photo."\"><input type=\"submit\" name=\"s2\" value=\"2\"></form>\n</td>\n";
	           $pp=$pp."<td width=5%><form method=\"post\" action=\"controleur.php\"><input type=\"hidden\" name=\"crit\" value=\"".$critere[$j][0]."\"><input type=\"hidden\" name=\"lien_phot\" value=\"".$lien_photo."\"><input type=\"submit\" name=\"s3\" value=\"3\"></form>\n</td>\n";
	           $pp=$pp."<td width=5%><form method=\"post\" action=\"controleur.php\"><input type=\"hidden\" name=\"crit\" value=\"".$critere[$j][0]."\"><input type=\"hidden\" name=\"lien_phot\" value=\"".$lien_photo."\"><input type=\"submit\" name=\"s4\" value=\"4\"></form>\n</td>\n";
	           $pp=$pp."<td width=5%><form method=\"post\" action=\"controleur.php\"><input type=\"hidden\" name=\"crit\" value=\"".$critere[$j][0]."\"><input type=\"hidden\" name=\"lien_phot\" value=\"".$lien_photo."\"><input type=\"submit\" name=\"s5\" value=\"5\"></form>\n</td>\n";
	           }
	           else{
	           $pp=$pp."<td align=center>".$deja_note."</td><td colspan=5 align=center><form method=\"post\" action=\"controleur.php\"><input type=\"hidden\" name=\"crit\" value=\"".$critere[$j][0]."\"><input type=\"hidden\" name=\"lien_phot\" value=\"".$lien_photo."\">
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
	
	$pp=$pp."</tr>\n</table></p>";//*/

	        }
	        }
	
	return $pp;
}

//------------------------Recues--------------------------
?>
