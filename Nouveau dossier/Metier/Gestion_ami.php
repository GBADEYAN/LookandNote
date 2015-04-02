<?php

require_once("Gestion_bdd.php");
//require("Gestion_recherche.php");

//---------Ajout d'amis------------
function ajout_ami($id,$id_ami){
	$connex=connexion_bdd();
	$sql="insert into Ami (id_util1,id_util2) values(\"".$id."\",\"".$id_ami."\")";
	$req=mysql_query($sql);
	   		if(!$req){
           			Die("Requete invalide:".mysqli_connect_error());
       			}
	return "";
}

//---------Deja ami----------------
function dejaAmi($id1,$id2){
	$b="false";	
	$A=rech_ami_util($id1);
	for($i=0;$i<count($A);$i++){
		if($id2==$A[$i]){$b="true";break;}
	}
	return $b;
}



//---------Affichage des amis------------
function aff_ami_perso($id){
	$pp="<h3>Amis actuels : </h3>";
	$A=rech_ami_util($id);
	if(empty($A)){
		$pp=$pp."Pas d'ami actuellement";
	}
	else{
		$connex=connexion_bdd();
		$pp =$pp. "<br><table border=1><tr> <td> id_ami </td><td> nom </td> <td> email </td><td> photo </td></tr>";
        	for($i=0;$i<count($A);$i++){
			$sql="select * from Utilisateur where id_util=\"".$A[$i]."\"";
			$req = mysql_query($sql,$connex);
			if(!$req){Die("Pb avec la requete ".mysql_error());}
			else{
				$row=mysql_fetch_assoc($req);
        		 	$pp=$pp. "<tr><td>".$row["id_util"]."</td><td>".$row["nom"]."</td><td>".$row["email"]."</td><td><img src=\"".$row["photo_profil"]."\" ></td></tr>"; 
      			}
		}
        	$pp=$pp. "</table><br><br>";
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
         			$pp=$pp. "<tr><td>".$row["id_util"]."</td><td>".$row["nom"]."</td><td>".$row["email"]."</td><td><img src=\"".$row["photo_profil"]."\"></td><td>".$a."</td></tr>";
       			}
		}
       		$pp=$pp. "</table><br><br>";
	}
	return $pp;
}


?>