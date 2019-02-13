<div id="logo_universite"></div>

<nav id="nav" role="navigation">
    <ul id="main-menu">
        <li>
            <a href="../index.php">Accueil</a>
        </li>
    </ul>
</nav>


<?php

  //Si une connexion existe
  if(estConnecte()) {

    //Si l'admin ou un responsable projet est connecté
    if($_SESSION['status'] == 1 || $_SESSION['status'] == 3) {
      ?>
      <nav>
        <ul>
          <li><a href=<?php echo URL.'form_ajout_projet.php'?>>Ajouter un projet</a></li>
          <li><a href=<?php echo URL.'mes_projets_client.php'?>>Mes projets</a></li>
          <!-- Si l'admin uniquement est connectée -->
          <?php
          if ($_SESSION['status'] == 1){
          ?>
            <li><a href=<?php echo URL.'liste_projets.php' ?>>Les projets</a></li>
            <li><a href=<?php echo URL.'attribution_projets_admin.php'?>>Attributions des projets</a></li>
          <?php 
          }
          ?>

        </ul>
      </nav>
      <?php
    }else if($_SESSION['status'] == 2) {
      ?>
      <nav>
        <ul>
          <li><a href=<?php echo URL.'liste_projets.php' ?>>Les projets</a></li>
          <li><a href="<?php echo URL.'mes_projets.php' ?>">Mes projets</a></li>
        </ul>
      </nav>
      <?php
    }
  }

 ?>