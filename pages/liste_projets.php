<?php
/**
* Page permettant de lister
* les projets
**/
?>

<h1>Liste des projets</h1>

<table>
  <tr>
    <th>Nom</th>
    <th>Description</th>
    <th>Actions</th>
  </tr>

    <?php
      //On récupère la liste des projets
      $projects = getProjects();

      foreach($projects as $project) {
        ?>
        <tr>

        <?php
        $attribuate = getProjectAttribuateByProjectId($project['idprojet']);
        if (empty($attribuate)){
        ?>

            <td><?php echo $project['nomprojet']; ?></td>
            <td><?php echo $project['descriptiftexte']; ?></td>
            <td><a href="<?php echo URL.'infos_projets.php&id='.$project['idprojet'];?>">Voir</a></td>
          <?php
        }
        ?>
        </tr>
        <?php
      }
     ?>
</table>
<br><br>

<?php
  if($_SESSION['status'] != 2) {
    ?>
      <a href="<?php echo URL.'form_ajout_projet.php'; ?>">Ajouter un projet</a>
    <?php
  }
  ?>
