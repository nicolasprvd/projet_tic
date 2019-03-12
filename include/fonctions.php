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

function connecter($idStatus, $name, $firstname) {
  $_SESSION['status'] = $idStatus;
  $_SESSION['name'] = $name;
  $_SESSION['firstname'] = $firstname;
}

/**
* Teste l'existence d'une connexion
* @return true ou false
**/
function estConnecte() {

  return isset($_SESSION['name']);
}

/**
* Détruit la session active
**/
function deconnecter() {
  session_destroy();
  header('Location: index.php');
}

/**
* Transforme une date au format anglais
* @param $myDate date au format aaaa-mm-jj
* @return $date date au format jj/mm/aaa
**/
function dateAnglaisVersFrancais($myDate) {
  @list($annee, $mois, $jour) = explode('-', $myDate);
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
* Ajoute le libellé du message au tableau des messages
* @param $msg le libellé du message
**/
function ajouterMessage($msg) {
  if(!isset($_REQUEST['messages'])) {
    $_REQUEST['messages'] = array();
  }
  $_REQUEST['messages'][] = $msg;
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

/**
* Détaille une liste de notes pour l'évaluation des étudiants
* @param $name nom de la liste
**/
function define_list_note($name) {
  echo "<select name='$name'>";
  echo "<option value='' disabled selected>Sélectionnez une note</option>";
  for($i=0; $i <= 20; $i+=0.5) {
    echo "<option value='$i'>$i</option>";
  }
  echo "</select>";
}

/**
* Détaille une liste de coefficients pour l'évaluation des étudiants
* @param $name nom de la liste
**/
function define_list_coeff($name) {
  echo "<select name='$name'>";
  echo "<option value='1' selected>1</option>";
  for($i=2; $i <= 6; $i++) {
    echo "<option value='$i'>$i</option>";
  }
  echo "</select>";
}


function export_csv($data) {
  $fichier = fopen("./documents/export_notes_groupe_".$data['idGroupe'].".csv", 'w+');
  fprintf($fichier, chr(0xEF).chr(0xBB).chr(0xBF));
  $entete = array($data['lib_groupe'], $data['lib_noteCDC'], $data['lib_noteSoutenance'], $data['lib_noteRendu'], $data['lib_noteFinale']);
  $delimiteur = ';';
  fputcsv($fichier, $entete, $delimiteur);
  $lignes[] = array($data['idGroupe'], $data['noteCDC'], $data['noteSoutenance'], $data['noteRendu'], $data['noteFinale']);
  foreach($lignes as $ligneaexporter){
    fputcsv($fichier, $ligneaexporter, $delimiteur);
  }
   fclose($fichier);
}
 ?>
