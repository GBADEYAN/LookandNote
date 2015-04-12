<?php
//------------------------Donnees--------------------------
//-------------Liste Notes donnéees------------
function liste_note_donnee($id) {
    $connex=connexion_bdd();
    $sql="select * from Notation,Critere where id_noteur=\"".$id."\" and Notation.num_critere=Critere.num_critere";
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

//-------------Liste Notes recues------------
function liste_note_recue($id) {
    $connex=connexion_bdd();$a=array();
	$i=0;
    $ens_photo=photo_perso($id);//(lien,titre,date,num_photo);
    for($j=0;$j<count($ens_photo);$j++){
    $sql="select * from Notation,Critere where Notation.num_critere=Critere.num_critere and num_photo=\"".$ens_photo[$j][3]."\" order by num_photo,id_noteur";
    $req=mysql_query($sql,$connex);    
	if(!$req){Die("Pb avec la requete ".mysql_error());}
	
	while($row=mysql_fetch_assoc($req)){	   
	   $a[$i][0]=$row["note"];
	   $a[$i][1]=$row["num_critere"];
	   $a[$i][2]=$row["num_photo"];
	   $P=info_photo($row["num_photo"]);	   
	   $a[$i][3]=$row["id_noteur"];    
	   $a[$i][4]=$P[1]; //lien	   
	   $a[$i][5]=$P[2]; //titre	   
	   $a[$i][6]=$P[3]; //date	  
	   $i++;
	}   }
    return $a;
	mysql_close($connex);
}


//-------------Affichage Note Profil------------
function aff_note($id,$rd) {    
    if($rd=="donnee"){
	   $liste=liste_note_donnee($id);
	   $pp="<h3><a href=\"controleur.php?page=ed\">Les photos que vous avez not&eacute; : </a></h3>\n";	   
	}
	else if($rd=="recue"){
	   $liste=liste_note_recue($id);	   
	   $pp="<h3><a href=\"controleur.php?page=er\">Vos photos qui ont &eacute;t&eacute; not&eacute; : </a></h3>\n";	   
	}
	if($rd=="donnee" && count($liste)==0){$pp=$pp."Vous n'avez pas donn&eacute; de note pour l'instant.";}
	else if($rd=="recue" && count($liste)==0){$pp=$pp."Vous n'avez pas re&ccedil;u de note pour l'instant.";}
	else{
	    $L=array();//titre,lien
	    $m=0;
		for($I=0;$I<count($liste);$I++){
		  if($I==0 || $liste[$I-1][2]!=$liste[$I][2]){
		    $L[$m][0]=$liste[$I][5]; //titre
		    $L[$m][1]=$liste[$I][4]; //lien
		    $m++;
		  }
		}		
		$pp=$pp."<table>\n";$k=5;
		for($j=0;$j<(2*$k*(1+count($L)/($k+1)));$j=$j+$k){
			$pp=$pp."<tr>\n";
			if($j%($k*2)==0){
				for($i=$j/2;$i<($j/2)+$k && $i<count($L);$i++){
					$pp=$pp."<td align=center width=15px>". $L[$i][0]." </td>";
				}
			}
			else{
				for($i=($j-$k)/2;$i<(($j-$k)/2)+$k && $i<count($L);$i++){	
					$pp=$pp."<td align=center width=20%><img src=\"".$L[$i][1]."\" width=80%></td>";                        
				}
			}
			$pp=$pp."</tr>\n";
		}
		$pp=$pp."</table>\n\n";
	}
	return $pp;
}


//-------------Affichage detail Note donnéees------------
function aff_detail_note($id,$rd) {
    if($rd=="donnee"){
        $pp="<h3>Photos que vous avez not&eacute; : </h3>";
	    $liste=liste_note_donnee($id);
    }
    else if($rd=="recue"){
        $pp="<h3>Notes que vous avez re&ccedil;ues : </h3>";
	    $liste=liste_note_recue($id);
    }    
	if(count($liste)==0){$pp=$pp."Vous n\'avez pas donn&eacute; de note pour l\'instant.";}
	else{
		for($i=0;$i<count($liste);$i++){	
	        $num_photo=$liste[$i][2];
	        $id_2=$liste[$i][3]; //id_post (donnee) ou id_noteur (recue)
	        $lien_photo=$liste[$i][4];
	        $titre=$liste[$i][5];
	        $N=info_util($id_2); //nom,photop
	        $nom_post=$N[0];
	        $photop_post=$N[1];
	        $critere=crit_photo($num_photo); //num,desc
	        if($i==0 || $liste[$i-1][2]!=$liste[$i][2] || $liste[$i-1][3]!=$liste[$i][3]){	        
	           $pp=$pp."<p><br><table  width=80% align=center >\n";
	           if($rd=="donnee"){
                   $pp=$pp."<tr><td colspan=4>Vous avez not&eacute; la publication de :</td></tr>";
                   $ID=$_SESSION["id"];
               }
               else if($rd=="recue"){
                   $pp=$pp."<tr><td colspan=4>Vous avez &eacute;t&eacute; not&eacute; par :</td></tr>";
                   $ID=$id_2;
               } 	           
	           $pp=$pp."<td width=30%></td> <td colspan=2></td>
	           <td align=center width=30%>".$titre."</td>
	           </tr>\n";
	           $D=1;
	           $pp=$pp."<tr>\n
	           <td rowspan=30><img src=\"".$photop_post."\" alt=\"photop\" width=100%><br>\n".$nom_post."</td>";	
	           do{$deja_note=deja_note($ID,$critere[$D][0]);$D++;}while(empty($deja_note));
	           $pp=$pp."<td  align=center>".$critere[1][1]."&nbsp;&nbsp;</td>\n<td align=center>".$deja_note."</td>";	           
	           $pp=$pp."<td rowspan=30 align=center><img src=\"".$lien_photo."\" alt=\"photo\" width=100%>";
	           if($rd=="donnee"){
	               $pp=$pp."<form method=\"post\" action=\"controleur.php\"><input type=\"hidden\" name=\"crit\" ><input type=\"hidden\" name=\"lien_phot\" value=\"".$lien_photo."\">
	           <input type=\"submit\" name=\"sub_supp_note\" value=\"Modifier\"></form></td>\n";
	           }
	           for($j=$D;$j<count($critere);$j++){
	               $deja_note=deja_note($ID,$critere[$j][0]);
	               if(!empty($deja_note)){
	                   $pp=$pp."<tr>\n<td  align=center>".$critere[$j][1]."&nbsp;&nbsp;</td>\n";
	                   $pp=$pp."<td align=center>".$deja_note."</td>\n";
	               }
	            }	
              	    $pp=$pp."</tr>\n</table></p>";//*/
	               $pp=$pp."\n<br><hr width=70% align=center><br>\n";
              }
	        }
        }	
	return $pp;
}

//------------------------Recues--------------------------
?>
