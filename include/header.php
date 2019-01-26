<?php
/**
* Entete de l'application
**/


  echo '<h1>Je suis l\'entete de la page</h1>';
  //Si une personne est authentifiée
  if(estConnecte()) {
    $status = getStatusById($_SESSION['status']);
    echo '<span>' . $status['libelle'] . ' : ' . $_SESSION['firstname'] . ' ' . $_SESSION['name'] . '</span>'; ?>

    <a href="<?php deconnecter(); ?>">Se déconnecter</a>
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
