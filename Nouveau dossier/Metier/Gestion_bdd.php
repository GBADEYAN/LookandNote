<?php

//---------------Connexion au serveur-----------------------
function connexion_serveur(){
  $serveur="localhost";
  $user="blanche";
  $mdp="azerty";

  $connex=mysql_connect($serveur,$user,$mdp);
  if(!$connex){
    return die("Erreur de connexion au serveur $serveur : ".mysql_error());
  }
  else{
    return $connex;
  }  
  mysql_close($connex);
}

//---------------Connexion a la BDD----------------------------
function connexion_bdd(){
  $serveur="localhost";
  $user="blanche";
  $mdp="azerty";
  $bdd="projet_cci";

  $connex=mysql_connect($serveur,$user,$mdp);
  $base = mysql_select_db($bdd,$connex);
  if(!$base){
    return die("Erreur de connexion a la BDD $bdd : ".mysql_error());
  }
  else{
    return $connex;
  }
}

?>