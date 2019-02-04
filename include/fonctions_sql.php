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

   /**
  * Récupère l'id de la personne inserer en parametre
  * @param $nom le nom de la personne
  * @param $firstName le prénom de la personne
  * @return $result l'id de la personne en question
  **/
  function getIdPeople($name, $firstName) {
    $query = "SELECT idpersonne FROM personne WHERE nomPersonne = :name AND prenompersonne = :firstName";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'name' => $name,
      'firstName' => $firstName
    ));
    $result = $prepQuery->fetch();
    return $result;
  }

  /**
  * Récupère la liste des projets
  * @return array $result tableau des projets
  **/
  function getProjects() {
    $query = "SELECT * FROM projet";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute();
    $result = $prepQuery->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  /**
  * Récupère les informations d'un projet
  * en fonction de son identifiant
  * @param $idProject identifiant du projet
  * @return array $result tableau des informations
  **/
  function getProjectById($idProject) {
    $query = "SELECT pro.idProjet, pro.idPersonneResp, nomProjet, descriptifTexte, descriptifPdf, nbEtudiants,
    automatique, nomPersonne, prenomPersonne, mailPersonne FROM projet pro
    INNER JOIN personne p ON p.idpersonne = pro.idpersonneresp
    WHERE pro.idProjet = :id";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'id' => $idProject
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


    /**
  * Effectue l'insertion dans la base de données
  * concernant l'inscription
  * @param $idcustomer l'identifiant de la personne proposant le projet
  * @param $title le titre du projet
  * @param $nbStudent le nombre d'étudiant requis pour le projet
  * @param $description la desctiption de projet (texte)
  * @param $descriptionJoint la description du projet (piece jointe)
  * @param $automatique pour savoi si le projet peut être affecté automatiquement ou non
  **/
  function insertNewProject($idcustomer, $title, $nbStudent, $description, $descriptionJoint, $automatique) {

    //On recupere si le projet peut être attribuer automatiquement (1) ou non (0)
    if ($automatique == "oui")
    {
      $boolautomatique = 1;
    } else {
      $boolautomatique = 0;
    }

    //description et descriptionJoint sont tous deux remplit
    if (!empty($description) AND !empty($descriptionJoint))
    {

      $query = "INSERT INTO projet (idpersonneresp, nomprojet, descriptiftexte, descriptifpdf, nbEtudiants, automatique) VALUES (:idcustomer, :title, :description, :descriptionJoint, :nbStudent, :boolautomatique)";
      $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'idcustomer' => $idcustomer,
      'title' => $title,
      'description' => $description,
      'descriptionJoint' => $descriptionJoint,
      'nbStudent' => $nbStudent,
      'boolautomatique' => $boolautomatique
    ));
    }
    //Uniquement descriptionJoint est remplit
    elseif (empty($description))
    {
      $query = "INSERT INTO projet (idpersonneresp, nomprojet, descriptifpdf, nbEtudiants, automatique) VALUES (:idcustomer, :title, :descriptionJoint, :nbStudent, :boolautomatique)";
      $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'idcustomer' => $idcustomer,
      'title' => $title,
      'descriptionJoint' => $descriptionJoint,
      'nbStudent' => $nbStudent,
      'boolautomatique' => $boolautomatique
    ));
    }
    //Uniquement descriptifTexte est remplit
    else {
      $query = "INSERT INTO projet (idpersonneresp, nomprojet, descriptiftexte,  nbEtudiants, automatique) VALUES (:idcustomer, :title, :description, :nbStudent, :boolautomatique)";
      $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'idcustomer' => $idcustomer,
      'title' => $title,
      'description' => $description,
      'nbStudent' => $nbStudent,
      'boolautomatique' => $boolautomatique
    ));
    }
    echo "Le projet a bien été créé";
  }





  /*******************************
  * FONCTIONS DELETE
  *******************************/



 ?>
