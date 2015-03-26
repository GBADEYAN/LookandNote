<?php

require("../../Metier/Gestion_bdd.php");

//---------------Creation Base de donnees-------------

function creation_base(){
  $connex=connexion_serveur();

  $sql="CREATE DATABASE lookandnote";
  if(mysqli_query($connex,$sql)){
    return echo "La base projet_cci a ete creee";
  }
  else{
    return echo "Erreur de creation ".mysqli_error($connex);
  }
  mysqli_close($connex);
}

//----------------Creation des tables de la BDD---------------

function creation table(){
  $connex=connexion_bdd();

  $sql="
  CREATE TABLE Utilisateur(
  id_util int(10) UNSIGNED auto_increment,
  nom varchar(20) NOT NULL,
  email varchar(50) NOT NULL, 
  mdp varchar(32) NOT NULL,
  photo_profil varchar(100) DEFAULT 'unnamed.png',
  Primary KEY(id_util)
  );

  CREATE TABLE Ami(
  id_util1 int(10) NOT NULL,
  id_util2 int(10) NOT NULL,
  PRIMARY KEY(id_util1,id_util2),
  FOREIGN KEY(id_util1) REFERENCES Utilisateur(id_util),
  FOREIGN KEY(id_util2) REFERENCES Utilisateur(id_util)
  );

  CREATE TABLE Photo(
  num_photo int(20) UNSIGNED auto_increment,
  id_post int(10) NOT NULL,
  titre varchar(15),
  date_publ TIMESTAMP,
  lien_photo varchar(100),
  PRIMARY KEY(num_photo),
  FOREIGN KEY(id_post) REFERENCES Utilisateur(id_util)
  );

  CREATE TABLE Critere(
  num_critere int(10) UNSIGNED auto_increment,
  description varchar(20),
  num_photo int(20) NOT NULL,
  PRIMARY KEY(num_critere),
  FOREIGN KEY(num_photo) REFERENCES Photo(num_photo)
  );

  CREATE TABLE Commentaire(
  id_comm int(10) NOT NULL,
  num_photo int(20) NOT NULL,
  comm text,
  PRIMARY KEY(id_comm,num_photo),
  FOREIGN KEY(id_comm) REFERENCES Utilisateur(id_util),
  FOREIGN KEY(num_photo) REFERENCES Photo(num_photo)
  );

  CREATE TABLE Notation(
  id_noteur int(5) NOT NULL,
  num_critere int(10) NOT NULL,
  note int(1) NOT NULL,
  PRIMARY KEY(id_noteur,num_critere),
  FOREIGN KEY(id_noteur) REFERENCES Utilisateur(id_util),
  FOREIGN KEY(num_critere) REFERENCES Critere(num_critere)
  );

  ";

  if(mysqli_query($connex,$sql)){
    retrun echo "Les tables ont etes correctement creees";
  }
  else{
    return echo "Erreur de creation : ".mysqli_error($connex);
  }

  mysqli_close($connex);
}

?>