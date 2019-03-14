<?php
/**
* Fichier permettant de manipuler
* les données de la BDD pour historier d'une année sur l'autre
**/

  /**
  * Renomme toutes les tables en ajoutant l'année d'historisation

  **/
  function historisation() {
    $query = "SELECT libelle FROM statut WHERE idStatut = :id";
    $prepQuery = $GLOBALS['connex']->prepare($query);
    $prepQuery->execute(array(
      'id' => $idStatus
    ));
    $result = $prepQuery->fetch();
    return $result;
  }

RENAME TABLE group TO member;



?>