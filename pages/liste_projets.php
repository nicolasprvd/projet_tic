<!-- Page qui affiche la liste des projets -->

<?php
//Gestion d'erreur : soumission multiple du formulaire de constitution du groupe
if (isset($_SESSION['btn_clicked'])) {
    unset($_SESSION['btn_clicked']);
}
?>

<table id="liste_projets">
    <tr class="upper txtcenter">
        <th>Nom</th>
        <th>Description</th>
        <th>Actions</th>
    </tr>

    <?php
    //On récupère la liste des projets
    $projects = getProjects();

    foreach ($projects as $project) {
        ?>
        <tr class="font-x-small">
            <?php
            $attribuate = getProjectAttribuateByProjectId($project['idprojet']);
            if (empty($attribuate)) {
                ?>

                <td><?php echo $project['nomprojet']; ?></td>
                <td><?php echo $project['descriptiftexte']; ?></td>
                <td>
                    <a href="<?php echo URL . 'infos_projets.php&id=' . $project['idprojet']; ?>">> Voir</a>
                    <br>
                    <?php
                    //Accès modification et suppression pour l'administrateur
                    if ($_SESSION['status'] == 1) { ?>
                        <a href="<?php echo URL . 'infos_projets.php&id=' . $project['idprojet']; ?>">> Supprimer</a>
                        <?php
                    }
                    ?>
                </td>
                <?php
            }
            ?>
        </tr>
        <?php
    }
    ?>
</table>

<?php
if ($_SESSION['status'] != 2) {
    ?>
<p class="mbxl">
    <a href="<?php echo URL . 'form_ajout_projet.php'; ?>">> Ajouter un projet</a>
</p>
    <?php
}
?>
