<?php
/**
* Page permettant d'avoir le
* détail du projet sélectionné
**/
?>

<?php

  $project = getProjectById($_GET['id']);
?>

<h1><?php echo $project['nomProjet']; ?></h1>

  Client : <?php echo $project['prenomPersonne'] . ' ' . $project['nomPersonne']; ?> <br>
  Mail client : <?php echo $project['mailPersonne']; ?> <br>
  Nombre d'étudiants : <?php echo $project['nbEtudiants']; ?> <br>
  Description : <?php echo $project['descriptifTexte']; ?> <br>
  <?php

  if($project['descriptifPdf'] != null) {
  ?>
    Fichier joint : <a href="documents/sujet_client/<?php echo $project['descriptifPdf']; ?>" target=\"_BLANK\">Télécharger</a>
  <?php
  }
  ?>
