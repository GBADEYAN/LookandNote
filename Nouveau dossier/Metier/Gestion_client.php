<?php

require_once("Gestion_bdd.php");


//5-------------Inscription------------
function inscript($nom,$email,$mdp){
  $connex = connexion_bdd();
  $dir_d = "../../Donnees/";
/*10--verification des donnees------*/
    $nomi = stripslashes(htmlentities($nom,ENT_QUOTES,'UTF-8'));//echo "nomi:".$nomi."<br>";
    $emaili = stripslashes(htmlentities($email,ENT_QUOTES,'UTF-8'));
    $mdp = stripslashes(htmlentities($mdp,ENT_QUOTES,'UTF-8'));  
  /*19nom identifiant obligatoire*/
    if(strlen($nomi)<1 || (!isset($nomi))){//--1
       $msg1 = "(*) Nom d un caractere obligatoire";
    }//--1
  /*18email obligatoire*/
    if(strlen($emaili)<1 || (!isset($emaili))){//--2	
       $msg2 = "(*) email obligatoire";
    }//--2
  /*22mdp obligatoire*/
    if(strlen($mdp)<7 || (!isset($mdp))){//--3	
       $msg3 = "(*) mdp de 6 caracteres minimum obligatoire";
    }//--3
    $mdp=md5($mdp);
     
  /*28--deja inscrit?-----------------*/
    if(!isset($msg1) && !isset($msg2) && !isset($msg3)){//--4	   
      $sql="SELECT * FROM Utilisateur WHERE email=\"".$emaili."\"";
      $req=mysql_query($sql,$connex);
      if(!$req){ Die("Requete invalide:".mysqli_connect_error());}
	   if(mysql_num_rows($req)>0){//--6
	       $msg2="(*) mail deja inscrit ";
	   }//--6
	   $sql1="select * from Utilisateur where nom=\"".$nomi."\"";
	   $req1=mysql_query($sql1,$connex);
	   if(!$req1){//--7
            Die("Requete invalide:".mysqli_connect_error());
       }//--7
	   if(mysql_num_rows($req1)>0){//--8
	       $msg1="(*) nom deja utilise";
	   }//--8
  /*46--Insertion des données-----------*/
	   if(!isset($msg1) && !isset($msg2)){//--9
	       $sql="insert into Utilisateur(nom,email,mdp)values(\"".$nomi."\",\"".$emaili."\",\"".$mdp."\")";
	       $req=mysql_query($sql,$connex);
	       if(!$req){//--10
               die("Echec insertion");
           }//--10
           else{//--11
               mkdir($dir_d.$nomi);  if(is_dir($dir_d.$nomi)){echo "creation dossier ok";} 
		$id=id_nom($nomi);
              return array($id,$nomi,$emaili,"../Image/photoprofil.png");
           } //--11    
       }//--9
       else{
           if(!isset($msg1)){ $msg1="";}
           if(!isset($msg2)){ $msg2="";}
           if(!isset($msg3)){ $msg3="";}  
           return array($msg1,$msg2,"");
       }    	      
    }//--4
    else{//--12
           if(!isset($msg1)){ $msg1="";}
           if(!isset($msg2)){ $msg2="";}
           if(!isset($msg3)){ $msg3="";}         
           return array($msg1,$msg2,$msg3);
    }//--12		 

  mysql_close($connex);
}



//72-------------Desinscription------------

function desinscript($nom){//--1
  $dir_d = "../../Donnees/";  
  $connex=connexion_bdd(); 
  $dir=$dir_d.$nom;$msg="";
  $ID=id_nom($nom);

//suppression dossier photo
   if (is_dir($dir)) {
     $objects = scandir($dir);
     foreach ($objects as $object) {
       if ($object != "." && $object != "..") {
         if (filetype($dir."/".$object) == "dir"){ rmdir($dir."/".$object);}
	 else {unlink($dir."/".$object);}
       }
     }
     reset($objects);
     rmdir($dir);
   }

//Suppression dans la BDD
//toutes les photos postees

	$ens_photo=photo_perso($ID); //(lien,titre,date)
	for($i=0;$i<count($ens_photo);$i++){echo $ens_photo[$i][0];
		supp_photo($ens_photo[$i][0]);
	}
//tous les comm, notes donnes par l'utilisateur
	$sql01="delete from Commentaire where id_comm=\"".$ID."\"";
	$sql02="delete from Notation where id_noteur=\"".$ID."\"";
	$sql03="delete from Ami where id_util1=\"".$ID."\" or id_util2=\"".$ID."\"";
	$req01=mysql_query($sql01,$connex);
	if(!$req01){
		Die("Requete invalide:".mysqli_connect_error());
	}
	$req02=mysql_query($sql02,$connex);
	if(!$req02){
		Die("Requete invalide:".mysqli_connect_error());
	}
	$req03=mysql_query($sql03,$connex);
	if(!$req03){
		Die("Requete invalide:".mysqli_connect_error());
	}
//utilisateur
	$sql04 = "delete from Utilisateur where id_util=\"".$ID."\"";
	$req04=mysql_query($sql04,$connex);
	if(!$req04){
		Die("Requete invalide:".mysqli_connect_error());
	}//*/
    //session_destroy();
}//--1



//86-------------Connexion------------

function connex($email,$mdp){
  $connex = connexion_bdd();
  if(sizeof($_POST)>0){
    $connex=connexion_bdd();
   /*94--verification des donnees------*/
      $email = stripslashes(htmlentities($email,ENT_QUOTES,"UTF-8"));
      $mdp = stripslashes(htmlentities($mdp,ENT_QUOTES,"UTF-8"));
   /*100email obligatoire*/
      if(strlen($email)<1){	
        $msg2 = "(*) email obligatoire";
      }
  /*104mdp obligatoire*/
      if(strlen($mdp)<1 || (!isset($mdp))){	
        $msg3 = "(*) mdp obligatoire";
      }
      $mdp=md5($mdp);
  /*110--recherche dans la BDD-----------*/
    if(!isset($msg2) && !isset($msg3)){
      $sql="SELECT * FROM Utilisateur WHERE email=\"".$email." \" AND mdp=\"".$mdp."\"";
      $req=mysql_query($sql,$connex);
      if(!$req){ Die("Requete invalide:".mysqli_connect_error());}
      if(mysql_num_rows($req)==0){
        $msg1="Ce compte n'existe pas";
        return array($msg1,""); 
      }
      if(!isset($msg2) && !isset($msg3)){
        $row=mysql_fetch_assoc($req);
        return array($row["id_util"],$row["nom"],$row["email"],$row["photo_profil"]);
      }
      else{
        return array($msg2,$msg3);
      }      
    }
    else{
      return array($msg2,$msg3);
    }
  }
  mysql_close($connex);  
}



//130-------------Deconnexion------------
function deconnex(){ 
  session_destroy();
  return "";
}


?>
