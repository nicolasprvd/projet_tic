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
   * Récupère la liste des projets en attribution manuellement pour le cient en question
   * @return array $result tableau de projets
   */
  function getManualProjects($persResp) {
    $query = "SELECT * FROM projet WHERE automatique = 0 AND idpersonneresp = :idResp";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'idResp' => $persResp
    ));
    $result = $prepQuery->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

    /**
   * Récupère la liste des projets en attribution manuellement pour le cient en question
   * @return array $result tableau de projets
   */
  function getAutomaticProjects($persResp) {
    $query = "SELECT * FROM projet WHERE automatique = 1 AND idpersonneresp = :idResp";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'idResp' => $persResp
    ));
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

  /**
  * Récupère la liste des étudiants en fonction
  * du status étudiant
  * @param $status statut étudiant
  * @param $loggedPersonne identifiant de la personne qui est connectée
  * @return array $result tableau des étudiants
  **/
  function getPersonnes($status, $loggedPersonne) {
    $query = "SELECT idPersonne, nomPersonne, prenomPersonne FROM personne WHERE idStatut = :status AND idPersonne != :idPersonne";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'status' => $status,
      'idPersonne' => $loggedPersonne
    ));
    $result = $prepQuery->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  /**
  * Récupère les identifiants du projet, du groupe et du responsable de groupe
  * @param $idChefGroup identifiant du chef de groupe
  * @param $idProject identifiant du projet
  * @return $result tableau des résultats
  **/
  function getChefGroupeProjet($idChefGroup, $idProject) {
    $query = "SELECT ct.idProjet, ct.idGroupe, idPersonneChef FROM choix_temp ct INNER JOIN groupe_temp gt ON gt.idgroupe = ct.idgroupe WHERE idPersonneChef = :idChef AND ct.idProjet = :idProjet";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'idChef' => $idChefGroup,
      'idProjet' => $idProject
    ));
    $result = $prepQuery->fetch(PDO::FETCH_ASSOC);
    return $result;
  }

  /**
  * Récupère les identifiants du projet, du groupe et du responsable de groupe
  * @return $result tableau des résultats
  **/
  function getDataChefGroupeProjet() {
    $query = "SELECT ct.idProjet, ct.idGroupe, idPersonneChef FROM choix_temp ct INNER JOIN groupe_temp gt ON gt.idgroupe = ct.idgroupe";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute();
    $result = $prepQuery->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }


  /**
  * Récupère l'idenfiant du groupe pour un chef de groupe
  * @param $idChef
  * @return $result tableau des informations
  **/
  function getGroupeTemp($idChef) {
    $query = "SELECT idGroupe, idPersonneChef FROM groupe_temp WHERE idPersonneChef = :idChef";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'idChef' => $idChef
    ));
    $result = $prepQuery->fetch(PDO::FETCH_ASSOC);
    return $result;
  }

  /**
  * Récupère l'identifiant du groupe temporaire d'une personne
  * @param $idPersonne identifiant de la personne
  * @return $result identifiant ou null
  **/
  function getGroupeTempByPersonne($idPersonne) {
    $query = "SELECT idGroupeTemp FROM personne WHERE idPersonne = :id";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'id' => $idPersonne
    ));
    $result = $prepQuery->fetch(PDO::FETCH_ASSOC);
    return $result;
  }

  /**
  * Récupère la ligne pour laquelle un groupe s'est positionné
  * @param $idProject identifiant du projet
  * @param $idGroup identifiant du groupe
  * @return $result array tableau des infos
  **/
  function getChoixTemp($idProject, $idGroup) {
    $query = "SELECT idProjet, idGroupe FROM choix_temp WHERE idProjet = :idProjet AND idGroupe = :idGroupe";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'idProjet' => $idProject,
      'idGroupe' => $idGroup
    ));
    $result = $prepQuery->fetch(PDO::FETCH_ASSOC);
    return $result;
  }

  /**
  * Récupère la liste des personnes d'un projet pour un groupe temporaire
  * @param $idProject identifiant du projet
  * @param $idPersonne identifiant du chef de groupe
  * @return $result array tableau des personnes
  **/
  function getPersonnesByProject($idProject, $idPersonne) {
    $query="SELECT idPersonne, nomPersonne, prenomPersonne, idGroupeTemp, ct.idProjet FROM choix_temp ct INNER JOIN personne p ON ct.idGroupe = p.idgroupetemp WHERE ct.idprojet = :idProjet AND idPersonne != :idPersonne";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'idProjet' => $idProject,
      'idPersonne' => $idPersonne
    ));
    $result = $prepQuery->fetchAll(PDO::FETCH_ASSOC);
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
  }

  /**
  * Insère l'identifiant du chef de groupe dans la table groupe_temp
  * @param $id identifiant du chef de groupe
  **/
  function insertNewGroupeTemp($id) {
    $query="INSERT INTO groupe_temp (idPersonneChef) VALUES (:id)";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'id' => $id
    ));
  }

  /**
  * Insère l'identifiant du projet et l'identifiant du groupe dans la table choix_temp
  * @param $idProject identifiant du projet
  * @param $idGroup identifiant du groupe
  **/
  function insertNewChoixTemp($idProject, $idGroup) {
    $query="INSERT INTO choix_temp VALUES (:idProject, :idGroup)";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'idProject' => $idProject,
      'idGroup' => $idGroup
    ));
  }


  /*******************************
  * FONCTIONS DELETE
  *******************************/

  /**
  * Insère l'idenifiant du groupe temporaire dans la table personne
  * @param $idGroup identifiant du groupe
  **/
  function updatePersonneGroupeTemp($idGroup, $etu) {
    $query="UPDATE personne SET idGroupeTemp = :idGroupTemp WHERE idPersonne = :idPersonne";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'idGroupTemp' => $idGroup,
      'idPersonne' => $etu
    ));
  }







  /*******************************
  * FONCTIONS DELETE
  *******************************/



 ?>
