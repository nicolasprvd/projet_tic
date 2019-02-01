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
  Fichier joint : <a href="Documents/questionnaire.pdf">Télécharger</a>
  <!-- ouvrir le fichier dans un nouvel onglet ? dans la fenetre actuelle ? télécharger ?
