<?php

require_once("Gestion_bdd.php");

//---------file ami (gauche)------------
function file_ami($id){
	$pp="";$A=array();
	$IA=rech_ami_util($id);
	if(empty($IA)){
		$pp=$pp."Pas d'ami actuellement";
	}
	else{
		$connex=connexion_bdd();
		$j=0;
		for($i=0;$i<count($IA);$i++){
			$sql="select * from Photo,Utilisateur where id_post=id_util and id_post=\"".$IA[$i]."\"";
			$req = mysql_query($sql,$connex);
			if(!$req){Die("Pb avec la requete ".mysql_error());}
			else{				
        			while($row=mysql_fetch_assoc($req)){
        				$A[$j]=array($row["num_photo"],$row["titre"],$row["date_publ"],$row["lien_photo"],$row["nom"]);
			       $j++;
				}
      			}
		}
		
		$B=array();
		foreach($A as &$ma){
			$B[]=&$ma[0];
		}
		array_multisort($B,SORT_DESC,$A);			

		foreach($A as &$ma){
			$pp=$pp.$ma[4]." a publi&eacute; :<br>".$ma[1]."<br><img src=\"".$ma[3]."\" width=15%>"."<br>le ".$ma[2]."<br>\n------------<br>\n"; 
		}
	}
	return $pp;		
}



//56---------file actualite recente perso------------
function file_perso($id){
	$pp="";
	$A=array();$j=0;
	$connex=connexion_bdd();
			
	$sql = "select * from Photo where id_post=\"".$id."\"";
	$req = mysql_query($sql,$connex);
	if(!$req){Die("Pb avec la requete ".mysql_error());}
	if (mysql_num_rows($req) == 0) {
	   $pp=$pp."Pas de photos publi&eacute;es actuellement.";
	}
	else{
        	while($row=mysql_fetch_assoc($req)){
        		 $A[$j]=array($row["num_photo"],$row["titre"],$row["date_publ"],$row["lien_photo"]);
			       $j++;
				}
      			
		
		
		$B=array();
		foreach($A as &$ma){
			$B[]=&$ma[0];
		}
		array_multisort($B,SORT_DESC,$A);			

		foreach($A as &$ma){
			$pp=$pp."publi&eacute; :<br>".$ma[1]."<br><img src=\"".$ma[3]."\" width=15%>"."<br>le ".$ma[2]."<br>\n------------<br>\n"; 
		}
	}
	return $pp;		
}



//56---------file commune centrale------------
function file_centrale($id){
$pp="";
	$A=array();$j=0;
	$connex=connexion_bdd();
			
	$sql = "select * from Photo,Utilisateur where id_post=id_util";
	$req = mysql_query($sql,$connex);
	if(!$req){Die("Pb avec la requete ".mysql_error());}
	if (mysql_num_rows($req) == 0) {
	   $pp=$pp."Pas de photos publi&eacute;es actuellement.";
	}
	else{
        	while($row=mysql_fetch_assoc($req)){
        		 $A[$j]=array($row["num_photo"],$row["titre"],$row["date_publ"],$row["lien_photo"],$row["nom"],$row["photo_profil"]);
			       $j++;
				}		
		$B=array();
		foreach($A as &$ma){
			$B[]=&$ma[0];
		}
		array_multisort($B,SORT_DESC,$A);			

		foreach($A as &$ma){
			//$pp=$pp."publi&eacute; :<br>".$ma[1]."<br><img src=\"".$ma[3]."\" width=15%>"."<br>le ".$ma[2]."<br>\n------------<br>\n"; 
$pp=$pp."	<div id = \"coordonnees\">\n
			<a href = \"#\"><img src = \"".$ma[5]."\"></a>
			<a href = \"#\"><p>$ma[4]</p><br></a>\n			
		</div>\n
		<p><br>le ".$ma[2]."</p><br>\n
		<div class = \"pub\">\n
		<h2>$ma[1]</h2>\n
		<img src = \"".$ma[3]."\" width=50%>\n
			<div class = \"boutonspub\">\n
				<input type = \"submit\" value = \"Noter\"id = \"Noter\"/>\n
				<input type = \"submit\" value = \"Commenter\"id = \"Commenter\"/>\n
				<input type = \"submit\" value = \"Partager\" id = \"partager\"/>\n
			</div>\n
		</div>\n<br>";
		}
	}
	return $pp;		
}


//56---------Affichage des photos perso------------

?>
