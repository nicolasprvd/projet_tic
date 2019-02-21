<div id="logo_universite"></div>

<nav id="nav" role="navigation">
    <ul id="main-menu">
        <li>
            <a href="index.php">Accueil</a>
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
        <?php
        //On récupère l'identifiant de la personne connectée
        $idPersonne = getIdPeople($_SESSION['name'], $_SESSION['firstname']);
        //On récupère le groupe auquel elle appartient
        $idGroup = getGroupeTempByPersonne($idPersonne[0]);

        $attribuate = getProjectAttribuate($idGroup['idGroupeTemp']);
        //Si le groupe n'a pas sont projet attribuer
        if (empty($attribuate))  { 
        ?>
         <li><a href=<?php echo URL.'liste_projets.php' ?>>Les projets</a></li>
          <li><a href="<?php echo URL.'mes_projets.php' ?>">Mes projets</a></li>
        <?php
        //Si le groupe a son projet attribué
        } else {
        ?>
          <li><a href="<?php echo URL.'mes_projets.php' ?>">Mon projet</a></li>
        <?php
        }

        ?>


         
        </ul>
      </nav>
      <?php
    }
  }
 ?>
