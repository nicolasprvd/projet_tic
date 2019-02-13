<?php
/**
* Page qui liste les projets temporaires choisis
**/
?>

<h1>Mes projets</h1>

    <?php
      //On récupère l'identifiant de la personne connectée
      $idPersonne = getIdPeople($_SESSION['name'], $_SESSION['firstname']);
      //On récupère le groupe temporaire auquel elle appartient
      $idGroupTemp = getGroupeTempByPersonne($idPersonne[0]);
      //On récupère la liste de ses choix
      $projects = getChoixProjets($idGroupTemp['idGroupeTemp']);

      if($projects == null) {
        echo '<p>Vous n\'avez choisi aucun projet pour le moment.</p>';
      }else {
        ?>
        <table>
          <tr>
            <th>Nom</th>
            <th>Description</th>
            <th>Actions</th>
          </tr>
        <?php
        foreach($projects as $project) {
          ?>
          <tr>
            <td><?php echo $project['nomProjet']; ?></td>
            <td><?php echo $project['descriptifTexte']; ?></td>
            <?php
              //Si c'est le responsable de projet
              if($project['idPersonneChef'] == $idPersonne[0]) {
                ?>
                  <td><a href="<?php echo URL.'choix_projet.php&id='.$project['idProjet'];?>">Se rétracter</a></td>
                <?php
              }else {
                ?>
                <td><a href="<?php echo URL.'infos_projets.php&id='.$project['idProjet'];?>">Voir</a></td>
                <?php
              }
             ?>

          </tr>
        </table>
          <?php
        }
      }
?>
