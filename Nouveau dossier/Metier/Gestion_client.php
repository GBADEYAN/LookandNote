<?php

require_once("Gestion_bdd.php");


//9-------------Inscription------------
function inscript($nom,$email,$mdp){
  $connex = connexion_bdd();
  $dir_d = "../../Donnees/";
/*15--verification des donnees------*/
    $nomi = stripslashes(htmlentities($nom,ENT_QUOTES,'UTF-8'));//echo "nomi:".$nomi."<br>";
    $emaili = stripslashes(htmlentities($email,ENT_QUOTES,'UTF-8'));
    $mdp = stripslashes(htmlentities($mdp,ENT_QUOTES,'UTF-8'));  
  /*19nom identifiant obligatoire*/
    if(strlen($nomi)<1 || (!isset($nomi))){//--1
       $msg1 = "(*) Nom d un caractere obligatoire";
    }//--1
  /*23email obligatoire*/
    if(strlen($emaili)<1 || (!isset($emaili))){//--2	
       $msg2 = "(*) email obligatoire";
    }//--2
  /*27mdp obligatoire*/
    if(strlen($mdp)<1 || (!isset($mdp))){//--3	
       $msg3 = "(*) mdp obligatoire";
    }//--3
    $mdp=md5($mdp);
     
  /*32--deja inscrit?-----------------*/
    if(!isset($msg1) && !isset($msg2) && !isset($msg3)){//--4
        $sql="select * from Utilisateur where email=\"".$emaili."\"";
	   $req=mysql_query($sql);
	   if(!$req){//--5
           Die("Requete invalide:".mysqli_connect_error());
        }//--5
	   if(mysql_num_rows($req)>0){//--6
	       $msg2="(*) mail deja inscrit ";
	   }//--6
	   $sql1="select * from Utilisateur where nom=\"".$nomi."\"";
	   $req1=mysql_query($sql1);
	   if(!$req1){//--7
            Die("Requete invalide:".mysqli_connect_error());
       }//--7
	   if(mysql_num_rows($req1)>0){//--8
	       $msg1="(*) nom deja utilise";
	   }//--8
  /*52--Insertion des données-----------*/
	   if(!isset($msg1) && !isset($msg2)){//--9
	       $sql="insert into Utilisateur(nom,email,mdp)values(\"".$nomi."\",\"".$emaili."\",\"".$mdp."\")";
	       $req=mysql_query($sql,$connex);
	       if(!$req){//--10
               die("Echec insertion");
           }//--10
           else{//--11
               mkdir($dir_d.$nomi);  if(is_dir($dir_d.$nomi)){echo "creation dossier ok";}             
               $row=mysql_fetch_assoc($req);
              return array($row["id_util"],$nomi,$emaili,"../Image/photoprofil.png");
           } //--11    
       }//--9
       else{
           return array($msg1,$msg2,"");
       }    	      
    }//--4
    else{//--12
           return array($msg1,$msg2,$msg3);
    }//--12		 

  mysql_close($connex);
}



//76-------------Desinscription------------

function desinscript($nom){//--1
  $dir_d = "../../Donnees/";  
  $connex=connexion_bdd();$msg="pas ok";  
  $dir=$dir_d.$nom;
  if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
		umask(0000); 
 		chmod($file,0777); 
        	@unlink($dir.$file);
        }
        closedir($dh);
    }
  }
      rmdir($dir);
    //echo "desinsc OK";
    
    $sql0="SELECT * FROM Utilisateur,Photo,Critere WHERE nom=\"$nom\" and id_util=id_post";
    $req0=mysql_query($sql0,$connex);
    if($req0){//--4
	 $msg="sql0 OK";
	//$row=mysql_fetch_assoc($req0);
	//$ID=$row["id-util"];
	//$sql1="DELETE FROM *
    }//--4
  //--2
    session_destroy();
    return $msg;
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
