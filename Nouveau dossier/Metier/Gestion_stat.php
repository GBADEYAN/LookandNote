<?php
//-------------Nombre de publication perso------------
function nb_publ($id) {
    $ens_photo=photo_perso($id);
    $nb_photo_perso=count($ens_photo);
    return $nb_photo_perso;
}


//------------------------Nombre de notes donnees/recues--------------------------
function nb_note_rd($id,$rd){
    if($rd=="donnee"){
	   $liste=liste_note_donnee($id);	   	   
	}
	else if($rd=="recue"){
	   $liste=liste_note_recue($id);	   	   
	}
	$nb=count($liste);
	return $nb;
}


//------------------------Moyenne des notes donnees/recues--------------------------
function moy_note_rd($id,$rd){
    if($rd=="donnee"){
	   $liste=liste_note_donnee($id);	   	   
	}
	else if($rd=="recue"){
	   $liste=liste_note_recue($id);	   	   
	}
	$nb=count($liste);
	$m=0;
	for($i=0;$i<$nb;$i++){
	   $m=$m+$liste[$i][0];
	}
	$m=$m/count($liste);
	$m=number_format($m,2);
	return $m;
}


//------------------------Affichage Stat profil--------------------------
function aff_stat_profil($id){
    $pp="<h3>Statistiques</h3>\n";
    $pp=$pp."Nombre de publications : ".nb_publ($id)."<br>\n";
    $pp=$pp."Nombre de notes donn&eacute;es : ".nb_note_rd($id,"donnee")."<br>\n";
    $pp=$pp."Moyenne des notes donn&eacute;es : ".moy_note_rd($id,"donnee")."/5<br>\n";
    $pp=$pp."Nombre de notes re&ccedil;ues : ".nb_note_rd($id,"recue")."<br>\n";
    $pp=$pp."Moyenne des notes re&ccedil;ues : ".moy_note_rd($id,"recue")."/5<br>\n";
    return $pp;    
}


//------------------------Affichage Stat photo notation--------------------------
function aff_stat_photo($num_photo){
    $connex=connexion_bdd();
    $N=[0,0,0,0,0,0];
    $sql="select note from Notation,Critere where Notation.num_critere=Critere.num_critere and Critere.num_photo=\"".$num_photo."\"";
    $req=mysql_query($sql,$connex);
	if(!$req){Die("Pb avec la requete ".mysql_error());}
	if(mysql_num_rows($req) != 0) {
	   $nb=0;
	   while($row=mysql_fetch_assoc($req)){
	       if($row["note"]=="1"){
	         $N[0]++;
	       }
      	   if($row["note"]=="2"){
	         $N[1]++;
	       }
	       if($row["note"]=="3"){
	         $N[2]++;
	       } 
	       if($row["note"]=="4"){
	        $N[3]++;
	       } 
	       if($row["note"]=="5"){
	        $N[4]++;
	      }
	      $N[5]=$N[5]+$row["note"];$nb++;
	   }
	   $N[5]=$N[5]/$nb;
	   $N[5]=number_format($N[5],2);
	}
	mysql_close($connex);
	
	$pp="Statistiques :<br>\n";
	$pp=$pp."1 : ".$N[0]." vote(s)<br>\n";
	$pp=$pp."2 : ".$N[1]." vote(s)<br>\n";
	$pp=$pp."3 : ".$N[2]." vote(s)<br>\n";
	$pp=$pp."4 : ".$N[3]." vote(s)<br>\n";
	$pp=$pp."4 : ".$N[4]." vote(s)<br>\n";
	$pp=$pp."Moyenne : ".$N[5]."/5<br>\n";
	$pp=$pp."Nombre de votes : ".$nb."<br>\n";
    return $pp;    
}
    
    
    
?>
