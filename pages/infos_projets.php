<?php
/**
 * Page permettant d'avoir le
 * détail du projet sélectionné
 **/

$project = getProjectById($_GET['id']);

//Si l'administrateur souhaite modifier les informations du projet
if (isset($_POST['btn_update_project'])) {
    include('formulaires/form_projet_modifier.php');
    exit;
}
?>

<h1><?php echo $project['nomProjet']; ?></h1>
<div id="infos_projet">
    <p class="mbxl">
        <span class="bold">Client : </span>
        <span><?php echo $project['prenomPersonne'] . ' ' . $project['nomPersonne']; ?></span>
    </p>

    <p class="mbxl">
        <span class="bold">Mail client : </span>
        <span><?php echo $project['mailPersonne']; ?> </span>
    </p>
    <p class="mbxl">
        <span class="bold">Nombre d'étudiants : </span>
        <span><?php echo $project['nbEtudiants']; ?> </span>
    </p>
    <p class="mbxl">
        <span class="bold">Description : </span>
        <span><?php echo $project['descriptifTexte']; ?> </span>
    </p>

    <?php
    if ($project['descriptifPdf'] != null) {
        ?>
        Fichier joint : <a href="documents/sujet_client/<?php echo $project['descriptifPdf']; ?>" target=\"_BLANK\">Télécharger</a>
        <?php
    }

    //Accès en modification pour l'administrateur
    if ($_SESSION['status'] == 1) {
        ?>
        <form method="post" class="txtcenter">
            <input type="submit" class="input_custom" name="btn_update_project" value="Modifier">
        </form>
        <?php
    }

    $idPersonne = getIdPeople($_SESSION['name'], $_SESSION['firstname']);
    $data = getChefGroupeProjet($idPersonne[0], $_GET['id']);
    $groupTempPers = getGroupeTempByPersonne($idPersonne[0]);
    $groupTempChef = getGroupeTemp($idPersonne[0]);

    if ($_SESSION['status'] == 2) {
        ?>
        <div class="txtcenter">
            <?php
            //Si la personne connectée est chef d'un groupe
            if ($groupTempChef != null) {
                //Si la personne est chef de groupe pour le projet en question
                if ($data != null) {
                    //La personne connectée peut uniquement se rétracter sur son projet
                    ?>
                    <a href="<?php echo URL . 'choix_projet.php&id=' . $_GET['id']; ?>">> Se rétracter</a>
                    <?php
                } else {
                    //La personne connectée peut se positionner sur un autre projet
                    ?>
                    <a href="<?php echo URL . 'choix_projet.php&id=' . $_GET['id']; ?>">> Se positionner</a>
                    <?php
                }
            } else { //Si la personne connectée n'est pas chef de groupe
                //Si la personne connectée n'est pas dans un groupe
                if (empty($groupTempPers['idGroupeTemp'])) {

                    //La personne connectée peut se positionner sur un projet
                    ?>
                    <a href="<?php echo URL . 'choix_projet.php&id=' . $_GET['id']; ?>">> Se positionner</a>
                    <?php
                }
            }
            ?>
        </div>
        <?php
    }
    ?>
</div>