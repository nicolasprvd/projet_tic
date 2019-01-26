<?php
/**
* Fichier permettant de manipuler
* les données de la BDD
**/

  //Connexion à la base de données
  $GLOBALS['connex'] = connexionBD();

  /*******************************
  * FONCTIONS GET
  *******************************/

  /**
  * Récupère tous les statuts
  * @return array $result : tableau des statuts
  **/
  function getStatus() {
    $query = "SELECT idStatut, libelle FROM statut";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute();
    $result = $prepQuery->fetchAll();
    return $result;
  }

  /**
  * Récupère le statut correspondant à l'identifiant
  * @param $idStatus l'identifiant du statut
  * @return $result le nom du statut
  **/
  function getStatusById($idStatus) {
    $query = "SELECT libelle FROM statut WHERE idStatut = :id";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'id' => $idStatus
    ));
    $result = $prepQuery->fetch();
    return $result;
  }

  /**
  * Récupère les informations de l'utilisateur en fonction
  * des données d'authentification
  * @param $login identifiant de l'utilisateur
  * @param $password mot de passe de l'utilisateur
  * @return array $result tableau de l'identifiant et du mdp de l'utilisateur
  **/
  function getUserDataAuth($login) {
    $query = "SELECT nomPersonne, prenomPersonne, mailPersonne, password, idStatut FROM personne WHERE mailPersonne = :email";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'email' => $login,
    ));
    $result = $prepQuery->fetch(PDO::FETCH_ASSOC);
    return $result;
  }


  /*******************************
  * FONCTIONS INSERT
  *******************************/

  /**
  * Effectue l'insertion dans la base de données
  * concernant l'inscription
  * @param $status l'identifiant du statut
  * @param $name le nom de la nom
  * @param $firstname le prénom de la personne
  * @param $email l'email de la personne
  * @param $password le mot de passe de la personne
  **/
  function insertNewUser($status, $name, $firstname, $email, $password) {
    $query = "INSERT INTO personne (idStatut, nomPersonne, prenomPersonne, mailPersonne, password) VALUES (:status, :name, :firstname, :email, :password)";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'status' => $status,
      'name' => $name,
      'firstname' => $firstname,
      'email' => $email,
      'password' => $password
    ));
  }


  /*******************************
  * FONCTIONS DELETE
  *******************************/



 ?>
