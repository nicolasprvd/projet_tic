<?php

//Si une personne souhaite se déconnecter
if(!empty($_GET['deconnexion'])) {
  deconnecter();
}

//Si une personne est authentifiée
/**
* Entete de l'application
**/
 echo '<h1>Je suis l\'entete de la page</h1>';
//Si une personne souhaite se dÃ©connecter
if(!empty($_GET['deconnexion'])) {
  deconnecter();
}

//Si une personne est authentifiÃ©e
if(estConnecte()) {
  $status = getStatusById($_SESSION['status']);
  echo '<span>' . $status['libelle'] . ' : ' . $_SESSION['firstname'] . ' ' . $_SESSION['name'] . '</span>';
  ?>
  <a href="index.php?deconnexion=true">Se déconnecter</a>
  <?php
}else {
  ?>
  <a class="link_auth" onclick="document.getElementById('signin').style.display='block'">Se connecter</a>
  <?php require_once('./pages/formulaires/form_connexion.php'); ?>
  <a class="link_auth" onclick="document.getElementById('signup').style.display='block'">S'inscrire</a>
  <?php
  require_once('./pages/formulaires/form_inscription.php');

}
?>
