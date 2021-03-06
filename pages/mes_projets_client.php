<?php
/**
* Page permettant de visualiser les attributions de projets
**/
?>

<?php
//Si la personne souhaite se positionner sur un projet
if (isset($_POST['btn_choix'])) {
    //selectionner le chef de projet
    $idChefG = getIdChefByIdGroup($_POST['id']);

    insertNewGroupe($_POST['id'], $_GET['id'], $idChefG['idpersonneChef']);
    deleteChoixTempFROMGroupeId($_POST['id']);
    deleteChoixTempFromProjectId($_GET['id']);
    deleteGroupTempFromGroupId($_POST['id']);

    //On affecte à chaque personne du groupe l'identifiant du groupe auquel elles appartiennent
    $etu = getPersonneByGroupTemp($_POST['id']);
    foreach ($etu as $e) {
        updatePersonneGroupe($_POST['id'], $e['idPersonne']);
    }

}

$idCustomer = getIdPeople($_SESSION['name'], $_SESSION['firstname']);
$boucle = false ;

// On récupère les projets à affecter manuellement
$manuel = getManualProjects($idCustomer[0]);
?>

<?php
if (!empty($manuel)) {
    $boucle = true;
?>
<table id="mes_projets_client">
    <tr class="upper txtcenter">
        <th>Nom</th>
        <th>Description</th>
        <th>Actions</th>
    </tr>
    <?php
    foreach ($manuel as $project) {
        ?>
        <tr class="font-x-small">
            <td><?php echo $project['nomprojet']; ?></td>
            <td><?php echo $project['descriptiftexte']; ?></td>
            <?php
            // Si le projet n'est pas attribué
            $projetAttribuer = getprojetAttribuer($project['idprojet']);
            if (empty($projetAttribuer)) {
                ?>
                <td>
                    <a href="<?php echo URL . 'choix_groupe.php&id=' . $project['idprojet'] . '&titre=' . $project['nomprojet']; ?>">
                        > Vous devez attribuer ce projet</a></td>
                <?php
                // Si le projet est attribué
            } else {
                ?>
                <td>
                    <a href="<?php echo URL . 'voir_mon_projet_client.php&id=' . $project['idprojet'] . '&titre=' . $project['nomprojet']; ?>">
                        > Voir le projet</a></td>
                <?php
            }
            ?>

        </tr>
        <?php
    }
}
?>
    <h1> Mes projets </h1>
    <?php
    // On récupère les projets a affecter automatiquement
    $automatic = getAutomaticProjects($idCustomer[0]);

    if (!empty($automatic)) {

        if (!$boucle) {
            $boucle = true;
            ?>
            <table id="mes_projets_client">
                <tr class="upper txtcenter">
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            <?php
        }

    foreach ($automatic as $project) {
        ?>
        <tr class="font-x-small">
            <td><?php echo $project['nomprojet']; ?></td>
            <td><?php echo $project['descriptiftexte']; ?></td>

            <?php
            // Si le projet n'est pas attribué
            $projetAttribuer = getprojetAttribuer($project['idprojet']);
            if (empty($projetAttribuer)) {
                ?>
                <td>En attente d'attribution</td>
                <?php
                // Si le projet est attribué
            } else {
                ?>
                <td>
                    <a href="<?php echo URL . 'voir_mon_projet_client.php&id=' . $project['idprojet'] . '&titre=' . $project['nomprojet']; ?>">
                        > Voir le projet</a></td>
                <?php
            }
            ?>

        </tr>
        <?php
    }
    ?>
</table>

<?php
}

if (!$boucle) {
    echo "<strong>Vous n'avez pas de projet en cours.</strong>";
}

?>
