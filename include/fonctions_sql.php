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
    $query = "SELECT idPersonne, nomPersonne, prenomPersonne, mailPersonne, password, idStatut FROM personne WHERE mailPersonne = :email";
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
  * Récupère les information de la personne inserer en parametre
  * @param $idP l'id de la personne
  * @return $result les informations de la personne en question
  **/
  function getInformationPeopleById($idP) {
    $query = "SELECT * FROM personne WHERE idpersonne = :idPers";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'idPers' => $idP
    ));
    $result = $prepQuery->fetch();
    return $result;
  }
  /**
  * Récupère les données utilisateurs pour l'inscription
  * Gestion des doublons
  * @return $result array tableau des informations
  **/
  function getPersonnesForAuth() {
    $query = "SELECT * FROM personne";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute();
    $result = $prepQuery->fetchAll();
    return $result;
  }
  /**
  * Récupère la liste des projets
  * @return array $result tableau des projets
  **/
  function getProjects() {
    $query = "SELECT idprojet, nomprojet, descriptiftexte, idpersonneresp, idstatut FROM projet pr INNER JOIN personne p ON p.idpersonne = pr.idpersonneresp";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute();
    $result = $prepQuery->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }
    /**
  * Récupère la liste des projets attribués avec le nom et le prénom du tuteur
  * @return array $result tableau des projets
  **/
  function getProjectsAttribuate(){
    $query = "SELECT idprojet, nomprojet, prenompersonne, nompersonne FROM projet pro, personne pers WHERE pro.idpersonneresp = pers.idpersonne AND idprojet IN (SELECT idprojet FROM groupe)";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute();
    $result = $prepQuery->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }
  /**
   * Récupère la liste des projets en attribution manuellement pour le cient en question
   * @return array $result tableau de projets en attribution automatique du client
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
   * Récupère la liste des projets manuel qui n'ont pas encore été attribués
   * @return array $result tableau de projets en attribution automatique du client
   */
  function getManualProjectsNoAttribuate() {
    $query = "SELECT * FROM projet WHERE automatique = 0 AND idprojet NOT IN (SELECT idprojet FROM groupe)";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute();
    $result = $prepQuery->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }
    /**
   * Récupère la liste des projets en attribution manuellement pour le client en question
   * @return array $result tableau de projets en atrtibution manuelle du client
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
   * Récupère la liste des projets en attribution manuellement pour le cient en question
   * @return arrayString $result a qui est attribuer le projet
   */
  function getprojetAttribuer($idProjet) {
    $query = "SELECT * FROM groupe WHERE idprojet = :idProjet";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'idProjet' => $idProjet
    ));
    $result = $prepQuery->fetch(PDO::FETCH_ASSOC);
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
    $query = "SELECT idPersonne, nomPersonne, prenomPersonne FROM personne WHERE idStatut = :status AND idPersonne != :idPersonne AND idgroupetemp is null ORDER BY prenomPersonne ASC";
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
  * Récupère les lignes pour un groupe
  * @param $idGroup identifiant du groupe
  * @return $result array tableau des infos
  **/
  function getChoixTempByGroupTemp($idGroup) {
    $query = "SELECT idProjet, idGroupe FROM choix_temp WHERE idGroupe = :idGroupe";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'idGroupe' => $idGroup
    ));
    $result = $prepQuery->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }
  /**
  * Récupère la liste des personnes d'un projet pour un groupe temporaire
  * @param $idProject identifiant du projet
  * @param $idPersonne identifiant du chef de groupe
  * @return $result array tableau des personnes
  **/
  function getPersonnesByProject($idProject, $idPersonne) {
    $query = "SELECT idPersonne, nomPersonne, prenomPersonne, idGroupeTemp, ct.idProjet FROM choix_temp ct INNER JOIN personne p ON ct.idGroupe = p.idgroupetemp WHERE ct.idprojet = :idProjet AND idPersonne != :idPersonne";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'idProjet' => $idProject,
      'idPersonne' => $idPersonne
    ));
    $result = $prepQuery->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }
  /**
  * Récupère la liste des projets pour un groupe donné
  * @param $idGroup identifiant du groupe
  * @return $result array tableau des résultats
  **/
  function getChoixProjets($idGroup) {
    $query = "SELECT ct.idProjet, ct.idGroupe, nomProjet, descriptifTexte, idPersonneChef FROM choix_temp ct INNER JOIN projet p ON p.idprojet = ct.idprojet INNER JOIN groupe_temp gt ON gt.idGroupe = ct.idGroupe WHERE ct.idgroupe = :idGroup";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'idGroup' => $idGroup
    ));
    $result = $prepQuery->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }
  /**
  * Récupère la liste des personnes pour un groupe temporaire
  * @param $idGroup identifiant du groupe temporaire
  * @return $result array tableau des identifiants noms et prenoms
  **/
  function getPersonneByGroupTemp($idGroup) {
    $query = "SELECT idPersonne, prenomPersonne, nomPersonne FROM personne WHERE idGroupeTemp = :idGroup";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'idGroup' => $idGroup
    ));
    $result = $prepQuery->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }
    /**
  * Récupère l'id des groupes temporaire ayant postulé sur un projet donné
  * @param $idprojet identifiant du projet
  * @return $result array tableau des identifiants
  **/
  function getIdgroupeByIdproject($idProject){
    $query = "SELECT idgroupe FROM choix_temp WHERE idprojet = :idProject";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'idProject' => $idProject
    ));
    $result = $prepQuery->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }
      /**
  * Récupère l'id du groupe temporaire ayant postulé sur un projet donné
  * @param $idprojet identifiant du projet
  * @return $result array tableau des identifiants
  **/
  function getIdgByIdproject($idProject){
    $query = "SELECT idgroupe FROM choix_temp WHERE idprojet = :idProject";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'idProject' => $idProject
    ));
    $result = $prepQuery->fetch(PDO::FETCH_ASSOC);
    return $result;
  }
    /**
  * Récupère l'id des groupes temporaire ayant postulé sur un projet donné
  * @param $idprojet identifiant du projet
  * @return $result array tableau des identifiants
  **/
  function getIdgroupeByIdprojectFinal($idProject){
    $query = "SELECT idgroupe FROM groupe WHERE idprojet = :idProject";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'idProject' => $idProject
    ));
    $result = $prepQuery->fetch(PDO::FETCH_ASSOC);
    return $result;
  }
     /**
  * Récupère l'id du chef de projet du groupe temporaire
  * @param $idG identifiant du groupe
  * @return $result identifiant du chef de projet
  **/
  function getIdChefByIdGroup($idG){
    $query = "SELECT idpersonneChef FROM groupe_temp WHERE idgroupe = :idGroup";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'idGroup' => $idG
    ));
    $result = $prepQuery->fetch(PDO::FETCH_ASSOC);
    return $result;
  }
       /**
  * Récupère l'id du chef de projet du groupe
  * @param $idG identifiant du groupe
  * @return $result identifiant du chef de projet
  **/
  function getIdChefFinalByIdGroup($idG){
    $query = "SELECT idpersonneChef FROM groupe WHERE idgroupe = :idGroup";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'idGroup' => $idG
    ));
    $result = $prepQuery->fetch(PDO::FETCH_ASSOC);
    return $result;
  }
       /**
  * Verifie si le groupe a un projet attribué ou non. Si oui, recupere l'id du chef de projet et l'id du projet
  * @param $idG identifiant du groupe
  * @return $result identifiant du chef de projet
  **/
  function getProjectAttribuate($idG){
    $query = "SELECT * FROM groupe WHERE idgroupe = :idGroup";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'idGroup' => $idG
    ));
    $result = $prepQuery->fetch(PDO::FETCH_ASSOC);
    return $result;
  }
  /**
  * Verifie si le projet a été attribuer
  * @param $idG identifiant du groupe
  * @return $result identifiant du chef de projet
  **/
  function getProjectAttribuateByProjectId($idP){
    $query = "SELECT * FROM groupe WHERE idprojet = :idProject";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'idProject' => $idP
    ));
    $result = $prepQuery->fetch(PDO::FETCH_ASSOC);
    return $result;
  }
  /**
  * Verifie si un fichier a deja été déposé
  * @param $idP
  * @param $type
  * @return $result identifiant du chef de projet
  **/
  function getDocSubmit($idP, $type){
    $query = "SELECT * FROM document WHERE idprojet = :idProject AND typedoc = :type";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'idProject' => $idP,
      'type' => $type
    ));
    $result = $prepQuery->fetch(PDO::FETCH_ASSOC);
    return $result;
  }
    /**
   * Récupère la liste des projets en attributionautomatique (car les projets en attribution manuelle ont tous été attribué) dans la table choix_temp
   * @return array $result tableau de projets en attribution automatique du client
   */
  function getAutomaticalProjects() {
    $query = "SELECT * FROM choix_temp";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute();
    $result = $prepQuery->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }
      /**
   * Récupère la liste des projets en attributionautomatique (car les projets en attribution manuelle ont tous été attribué) dans la table choix_temp
   * @return array $result tableau de projets en attribution automatique du client
   */
  function getAutomaticalProject() {
    $query = "SELECT * FROM choix_temp LIMIT 1";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute();
    $result = $prepQuery->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }
  /**
  * Verifie combien de groupe ont demandé le projet passer en paramètre
  * @param $idP identifiant du projet
  * @return $result le nombre de demande
  **/
  function getNbDemande($idP){
    $query = "SELECT COUNT(idgroupe) AS nbFoisDemande FROM choix_temp WHERE idprojet = :idProject";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'idProject' => $idP
    ));
    $result = $prepQuery->fetch(PDO::FETCH_ASSOC);
    return $result;
  }
    /**
  * Verifie si un groupe n'a demandé qu'un seul projet
  * @param $idG identifiant du projet
  * @return $result le nombre de demande
  **/
  function getNbDemandeStudent($idG){
    $query = "SELECT COUNT(idprojet) AS nbFoisDemande FROM choix_temp WHERE idgroupe = :idGroup";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'idGroup' => $idG
    ));
    $result = $prepQuery->fetch(PDO::FETCH_ASSOC);
    return $result;
  }
    /**
  * Verifie si tous la table choix_temp est vide
  * @return $result le nombre de demande
  **/
  function getchoixTempIsEmpty(){
    $query = "SELECT * FROM choix_temp";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute();
    $result = $prepQuery->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }
  /**
  * Récupère les informations des documents pour un projet
  * @param $idProject identifiant du projet
  * @return $result array tableau des informations
  **/
  function getDocuments($idProject) {
    $query = "SELECT idprojet, iddoc, chemindoc, typedoc FROM document WHERE idprojet = :idProject";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'idProject' => $idProject
    ));
    $result = $prepQuery->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }
  /**
  * Récupère l'identifiant de l'évaluation pour un groupe
  * @param $idGroup identifiant du groupe
  * @return $result identifiant de l'évaluation
  **/
  function getEvaluationPersonne($idGroup) {
    $query = "SELECT idevaluation FROM personne WHERE idgroupe = :idGroup";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'idGroup' => $idGroup
    ));
    $result = $prepQuery->fetch(PDO::FETCH_ASSOC);
    return $result;
  }
  /**
  * Récupère une évaluation par son identifiant
  * @param $idEvaluation identifiant de l'évaluation
  * @return $result informations de l'évaluation
  **/
  function getEvaluationById($idEvaluation) {
    $query = "SELECT * FROM evaluation WHERE idevaluation = :idEvaluation";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'idEvaluation' => $idEvaluation
    ));
    $result = $prepQuery->fetch(PDO::FETCH_ASSOC);
    return $result;
  }
  /**
  * Récupère la liste des groupes
  * @return $result array identifiants des groupes
  **/
  function getGroupeId() {
    $query = "SELECT idGroupe FROM groupe";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute();
    $result = $prepQuery->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }
  /**
  * Récupère la liste des personnes pour un groupe
  * @param $idGroup identifiant du groupe
  * @return $result array tableau des identifiants noms et prenoms
  **/
  function getPersonnesByGroup($idGroup) {
    $query = "SELECT p.idPersonne, prenomPersonne, nomPersonne, g.idGroupe FROM personne p INNER JOIN groupe g ON g.idGroupe = p.idGroupe WHERE p.idGroupe = :idGroup";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'idGroup' => $idGroup
    ));
    $result = $prepQuery->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }
  /**
  * Récupère les données des personnes pour une évaluation
  * @param $idEvaluation identifiant de l'évaluation
  * @return $result array tableau des informations
  **/
  function getPersonneByEvaluation($idEvaluation) {
    $query = "SELECT * FROM personne p INNER JOIN evaluation e ON e.idevaluation = p.idevaluation WHERE e.idevaluation = :idEvaluation";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'idEvaluation' => $idEvaluation
    ));
    $result = $prepQuery->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }
    /**
  * Récupère la liste des étudiants et l'idEvalutation par ordre alphabetique (nom)
  * @return $result array tableau des informations
  **/
  function getPersonneEvaluate() {
    $query = "SELECT DISTINCT nompersonne, prenompersonne, idevaluation FROM personne  WHERE idstatut = 2 GROUP BY nompersonne, prenompersonne, idevaluation";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute();
    $result = $prepQuery->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }
  /**
  * Récupère les notes d'une personne
  * @return $result array tableau des informations
  **/
  function getnotes($idEval) {
    $query = "SELECT * FROM evaluation  WHERE idevaluation = :idEvaluation";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'idEvaluation' => $idEval
    ));
    $result = $prepQuery->fetch(PDO::FETCH_ASSOC);
    return $result;
  }

  /**
  * Récupère les informations utilisateur pour l'espace membre
  * @param $idPersonne identifiant de la personne
  **/
  function getPersonneById($idPersonne) {
    $query = "SELECT nomPersonne, prenomPersonne, s.idStatut, libelle, mailPersonne FROM personne p INNER JOIN statut s ON s.idStatut = p.idStatut WHERE idPersonne = :idPersonne";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'idPersonne' => $idPersonne
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
/**
  * Insère l'identifiant du groupe, du projet et du chef de projet dans la table groupe
  * @param $idG identifiant du groupe
  * @param $idP identifiant du projet
  * @param $idChefO identifiant chef de groupe
  **/
  function insertNewGroupe($idG, $idP, $idChefP){
    $query="INSERT INTO groupe VALUES (:idGroup, :idProject, :idPersonneChef)";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'idGroup' => $idG,
      'idProject' => $idP,
      'idPersonneChef' => $idChefP
    ));
  }
  /**
  * Insère le chemin et le type de document lors qu'un document veut être deposer
  * @param $idP identifiant du projet
  * @param $chemin la ou se trouve le document
  * @param $type le type de document (CDC/rendi final etc)
  **/
  function insertNewDoc($idP, $chemin, $type){
    $query="INSERT INTO document (idprojet, chemindoc, typedoc) VALUES (:idProjet, :chemin, :type)";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'idProjet' => $idP,
      'chemin' => $chemin,
      'type' => $type
    ));
  }
  /**
  * Insère une évaluation dans la base de données
  * @param $notes array tableau des notes
  **/
  function insertNewEvaluation($notes) {
    $query="INSERT INTO evaluation (notecdc, notesoutenance, noterendu, notefinale) VALUES (:noteCDC, :noteSoutenance, :noteRendu, :noteFinale)";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'noteCDC' => $notes[0],
      'noteSoutenance' => $notes[1],
      'noteRendu' => $notes[2],
      'noteFinale' => $notes[3]
    ));
  }
  /*******************************
  * FONCTIONS UPDATE
  *******************************/
  /**
  * Insère l'identifiant du groupe temporaire dans la table personne
  * @param $idGroup identifiant du groupe
  * @param $etu identidiant de l'etudiant
  **/
  function updatePersonneGroupeTemp($idGroup, $etu) {
    $query = "UPDATE personne SET idGroupeTemp = :idGroupTemp WHERE idPersonne = :idPersonne";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'idGroupTemp' => $idGroup,
      'idPersonne' => $etu
    ));
  }
   /**
  * Insère l'identifiant du groupe  dans la table personne
  * @param $idGroup identifiant du groupe
  * @param $etu identidiant de l'etudiant
  **/
  function updatePersonneGroupe($idGroup, $etu) {
    $query = "UPDATE personne SET idgroupe = :idGroup WHERE idpersonne = :idPersonne";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'idGroup' => $idGroup,
      'idPersonne' => $etu
    ));
  }
  /**
  * Insère l'identifiant de l'évaluation pour chaque étudiant du groupe
  * @param $idEvaluation identifiant de l'évaluation
  * @param $idGroup identifiant du groupe
  **/
  function updatePersonneEvaluation($idEvaluation, $idGroup) {
    $query = "UPDATE personne SET idEvaluation = :idEvaluation WHERE idGroupe = :idGroup";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'idEvaluation' => $idEvaluation,
      'idGroup' => $idGroup
    ));
  }

  /**
  * Met à jour les informations de l'utilisateur depuis son espace membre
  * @param $name nom de l'utilisateur
  * @param $firstName prénom de l'utilisateur
  * @param $mail email de l'utilisateur
  * @param $idPersonne identifiant de l'utilisateur
  **/
  function updateDataPersonne($name, $firstName, $mail, $idPersonne) {
    $query = "UPDATE personne SET nomPersonne = :name, prenomPersonne = :firstName, mailPersonne = :mail WHERE idPersonne = :idPersonne";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'name' => $name,
      'firstName' => $firstName,
      'mail' => $mail,
      'idPersonne' => $idPersonne
    ));
  }

  /**
  * Met à jour le mot de passe de l'utilisateur depuis son espace membre
  * @param $password mot de passe de l'utilisateur
  * @param $idPersonne identifiant de l'utilisateur
  **/
  function updatePasswordPersonne($password, $idPersonne) {
    $query = "UPDATE personne SET password = :password WHERE idPersonne = :idPersonne";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'password' => $password,
      'idPersonne' => $idPersonne
    ));
  }

  /**
  * Met à jour les données d'un projet
  * @param $name nom du projet
  * @param $nbStudent nombre d'étudiants pour le projet
  * @param $description description texte du projet
  * @param $file fichier joint descriptif
  * @param $automatique attribution automatique ou non du projet
  * @param $idProject identifiant du projet
  **/
  function updateDataProject($name, $nbStudent, $description, $file, $automatique, $idProject) {
    $query = "UPDATE projet SET nomProjet = :name, descriptifTexte = :description, descriptifPdf = :file, nbEtudiants = :nbStudent, automatique = :automatique  WHERE idProjet = :idProject";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'name' => $name,
      'description' => $description,
      'file' => $file,
      'nbStudent' => $nbStudent,
      'automatique' => $automatique,
      'idProject' => $idProject
    ));
  }

  /*******************************
  * FONCTIONS DELETE
  *******************************/
  /**
  * Supprime dans la table groupe_temp la ligne
  * correspondant au chef de groupe (la personne étudiante connectée)
  * @param $idPersonne identifiant de la personne connectée et chef de groupe
  **/
  function deleteGroupTemp($idPersonne) {
    $query = "DELETE FROM groupe_temp WHERE idPersonneChef = :id";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'id' => $idPersonne
    ));
  }
  /**
  * Supprime dans la table choix_temp la ligne
  * correpondant au groupe auquel appartient la personne connectée
  * et au projet auquel elle s'est positionnée
  * @param $idGroup identifiant du groupe de la personne connectée
  * @param $idProject identifiant du projet
  **/
  function deleteChoixTemp($idGroup, $idProject) {
    $query = "DELETE FROM choix_temp WHERE idGroupe = :idGroupe AND idProjet = :idProjet";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'idGroupe' => $idGroup,
      'idProjet' => $idProject
    ));
  }
    /**
  * Supprime dans la table choix_temp tous les choix donc le groupe est celui passé en paramètre
  * @param $idG identifiant du groupe
  **/
  function deleteChoixTempFROMGroupeId($idG){
    $query = "DELETE FROM choix_temp WHERE idgroupe = :idGroup";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'idGroup' => $idG
    ));
  }
    /**
  * Supprime dans la table groupe_temp le groupe passé en paramètre
  * @param $idG identifiant du groupe
  **/
  function deleteGroupTempFromGroupId($idG){
    $query = "DELETE FROM groupe_temp WHERE idgroupe = :idGroup";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'idGroup' => $idG
    ));
  }
    /**
  * Supprime dans la table groupe_temp le projet qui a été attribuer
  * @param $idP identifiant du projet
  **/
  function deleteChoixTempFromProjectId($idP){
    $query = "DELETE FROM choix_temp WHERE idprojet = :idProject";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'idProject' => $idP
    ));
  }

  /**
  * Supprimer un projet depuis son identifiant
  * @param $idProject identifiant du projet
  **/
  function deleteProject($idProject) {
    $query = "DELETE FROM projet WHERE idprojet = :idProject";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'idProject' => $idProject
    ));
  }
 ?>
