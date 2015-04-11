<?php

require_once("Gestion_bdd.php");

//---------Ajout d'amis------------
function ajout_ami($id,$id_ami){
	$connex=connexion_bdd();
	$sql="insert into Ami (id_util1,id_util2) values(\"".$id."\",\"".$id_ami."\")";
	$req=mysql_query($sql,$connex);
	   		if(!$req){
           			Die("Requete invalide df:".mysqli_connect_error());
       			}
	return "";
}

//---------Deja ami----------------
function dejaAmi($id1,$id2){
	$b="false";	
	$A=rech_ami_util($id1);
	for($i=0;$i<count($A);$i++){
		if($id2==$A[$i][0]){$b="true";break;}
	}
	return $b;
}



//---------Affichage des amis------------
function aff_ami_perso($id){
	$pp="<h3>Amis actuels : </h3>";
	$A=rech_ami_util($id);
	if(count($A)==0){$pp=$pp."Pas d'amis actuellement.";}
	else{		
		$pp=$pp."<table >\n";$k=5;$m=0;
		for($j=0;$j<(2*$k*(1+count($A)/($k+1)));$j=$j+$k){
			$pp=$pp."<tr>\n";//167
			if($j%($k*2)==0){
				for($i=$j/2;$i<($j/2)+$k && $i<count($A);$i++){
					$nom=$A[$i][1];					
					$pp=$pp."<td align=center>". $nom."</td>";
				}
			}
			else{
				for($i=($j-$k)/2;$i<(($j-$k)/2)+$k && $i<count($A);$i++){
					$photo=$A[$i][2];			
					$pp=$pp."<td align=center width=20px><img src=\"".$photo."\" width=80%> </td>";
				}
			}
			$pp=$pp."</tr>\n";
		}
		$pp=$pp."</table>\n";
	}
	return $pp;
}



//---------Affichage des amis potentiels------------
function aff_ami_pot($nom_ami){
	$connex = connexion_bdd();
	$pp="";
	$id=id_nom($_SESSION["nom"]);	
	$nom_ami=trim(htmlentities(stripslashes($nom_ami)));

	$sql = "select * from Utilisateur where nom like \"$nom_ami%\"";
	$req = mysql_query($sql,$connex);
	if(!$req){Die("Pb avec la requete ".mysql_error());}
	if (mysql_num_rows($req) == 0) {
	   echo "Aucune ligne trouv&eacute;e, rien &agrave; afficher.";
	}
	else{
		$pp="<br><table border=1><tr> <td> id_util </td><td> nom </td> <td> email </td><td> photo </td><td>ami?</td></tr>";
       		while($row=mysql_fetch_assoc($req)){
			if($row["id_util"]!=$id){
				$DA=dejaAmi($id,$row["id_util"]);
				if($DA=="true"){
					 $a="ami";
				}
				else{
					 $a="<form method=\"post\"><input type=\"text\" name=\"id_ami\" value=\"".$row["id_util"]."\"><input type=\"submit\" name=\"ajout_ami\" value=\"Ajouter comme ami\"></form>";
				}
         			$pp=$pp. "<tr><td>".$row["id_util"]."</td><td>".$row["nom"]."</td><td>".$row["email"]."</td><td><img src=\"".$row["photo_profil"]."\" width=10%></td><td>".$a."</td></tr>";
       			}
		}
       		$pp=$pp. "</table><br><br>";
	}
	return $pp;
}


?>