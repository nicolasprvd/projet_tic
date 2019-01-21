<?php

/**
* Fichier répertoriant des fonctions
* utiles pour la gestion de l'application
**/

/**
* Permet de se connecter à la base de données
**/
function connexionBD() {
  require('config.php'); //inclut les sources
  try {
    $connex = new PDO($source, $user, $password, array(
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
    ));
    return $connex;
  }catch(PDOException $e) {
    //Vérification de la connexion
    echo "Erreur : " . $e->getMessage();
    exit;
  }
}

/**
* Teste l'existence d'une connexion
* @return true ou false
**/
function estConnecte() {
  return isset($_SESSION['idPersonne']);
}

/**
* Détruit la session active
**/
function deconnecter() {
  session_destroy();
}

/**
* Transforme une date au format anglais
* @param $maDate date au format aaaa-mm-jj
* @return $date date au format jj/mm/aaa
**/
function dateAnglaisVersFrancais($maDate) {
  @list($annee, $mois, $jour) = explode('-', $maDate);
  $date = "$jour" . "/" . $mois . "/" . $annee;
  return $date;
}

/**
* Ajoute le libellé d'une erreur au tableau des erreurs
* @param $msg le libellé de l'erreur
**/
function ajouterErreur($msg) {
  if(!isset($_REQUEST['erreurs'])) {
    $_REQUEST['erreurs'] = array();
  }
  $_REQUEST['erreurs'][] = $msg;
}

/**
* Debug le contenu d'une variable
* @param $var la variable à debuger
**/
function debug($var) {
  echo '<pre>';
  print_r($var);
  echo '</pre>';
}

 ?>
