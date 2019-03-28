<?php
/**
 * Page qui permet de voir un de mes projets ainsi que les pieces deposé par les étudiant
 **/


$myProject = getProjectById($_GET['id']);
?>
<h1>"<?php echo $myProject['nomProjet']; ?>"</h1>

<div id="voir_mon_projet_client">
    <?php $myProject['nomProjet']; ?>
    <!-- Client -->
    <p class="mbl">
        <span class="bold">Client : </span>
        <span><?php echo $myProject['prenomPersonne'] . ' ' . $myProject['nomPersonne']; ?> </span>
    </p>

    <!-- Mail client -->
    <p class="mbl">
        <span class="bold">Mail client : </span>
        <span><?php echo $myProject['mailPersonne']; ?> </span>
    </p>

    <!-- Nombre d'étudiants -->
    <p class="mbl">
        <span class="bold">Nombre d'étudiants : </span>
        <span><?php echo $myProject['nbEtudiants']; ?> </span>
    </p>

    <!-- Description -->
    <p class="mbxl">
        <span class="bold">Description : </span>
        <span><?php echo $myProject['descriptifTexte']; ?> </span>
    </p>

    <?php
    if ($myProject['descriptifPdf'] != null) {
        ?>
        <!-- Fichier joint -->
        <p class="mbl">
            <span class="bold">Fichier joint : </span>
            <span><a href="documents/sujet_client/<?php echo $myProject['descriptifPdf']; ?>" target=\"_BLANK\">> Télécharger</a></span>
        </p>
        <?php
    }

    $idGroup = getIdgroupeByIdprojectFinal($myProject['idProjet']);

    //On recupere le nom et le prenom des personnes du groupe
    $etu = getPersonneByGroupTemp($idGroup['idgroupe']);
    $membre = '';
    $espace = " ";
    $separateur = ", ";

    foreach ($etu as $e) {
        $membre = $membre . $e['prenomPersonne'] . $espace . $e['nomPersonne'] . $separateur;
    }
    $membre = substr($membre, 0, -2);


    $idChef = getIdChefFinalByIdGroup($idGroup['idgroupe']);
    $chef = getInformationPeopleById($idChef['idpersonneChef']);
    ?>

    <br>

    <!-- Chef de projet -->
    <p class="mbl">
        <span class="bold">Chef de projet : </span>
        <span><?php echo $chef['prenompersonne'] . ' ' . $chef['nompersonne']; ?> </span>
    </p>
    <!-- Membres du projet -->
    <p class="mbxl">
        <span class="bold">Membres du projet : </span>
        <span><?php echo $membre; ?></span>
    </p>

    <br>

    <!-- Visualisation du cdc -->
    <p class="mbl">
        <span class="bold">Cahier des charges : </span>
        <span>
<?php
$docSubmit = getDocSubmit($myProject['idProjet'], 'CDC');
if (empty($docSubmit)) {
    ajouterErreur('Le cahier des charges n\'a pas encore été déposé');
    include('./include/erreurs.php');
} else {
    echo 'Le cahier des charges a été déposé :' ?> <a
            href="documents/cahier_des_charges/<?php echo $docSubmit['chemindoc']; ?>"
            target=\"_BLANK\">> Télécharger</a>
    <?php
}
?>
    </span>
    </p>

    <!-- Visualisation du gantt -->
    <p class="mbl">
        <span class="bold">Gantt : </span>
        <span>
<?php
$docSubmit = getDocSubmit($myProject['idProjet'], 'GANTT');
if (empty($docSubmit)) {
    ajouterErreur('Le gantt n\'a pas encore été déposé');
    include('./include/erreurs.php');
} else {
    echo 'Le gantt a été déposé :' ?> <a href="documents/gantt/<?php echo $docSubmit['chemindoc']; ?>"
                                         target=\"_BLANK\">> Télécharger</a>
    <?php
}
?>
    </span>
    </p>

    <!-- Visualisation du rendu -->
    <p class="mbxl">
        <span class="bold">Rendu final : </span>
        <span>
<?php
$docSubmit = getDocSubmit($myProject['idProjet'], 'RF');
if (empty($docSubmit)) {
    ajouterErreur('Le rendu final n\'a pas encore été déposé');
} else {
    echo 'Le rendu final a été déposé :' ?> <a href="documents/rendu_final/<?php echo $docSubmit['chemindoc']; ?>"
                                               target=\"_BLANK\">> Télécharger</a>
    <?php
}
?>
    </span>
    </p>

    <?php
    // Redirection vers l'évaluation du projet
    $documents = getDocuments($myProject['idProjet']);

    //Si tous les documents ont été transmis
    if (count($documents) == 3) {
        //Si l'évaluation n'a pas été faite
        $idEvaluation = getEvaluationPersonne($idGroup['idgroupe']);
        if (empty($idEvaluation['idevaluation'])) {
            ?>
            <p class="mbxl txtcenter">
                <a href="<?php echo URL . 'form_evaluation.php&id=' . $_GET['id'] . '&titre=' . $_GET['titre']; ?>">
                    > Evaluer le projet</a>
            </p>
            <?php
        } else {
            ?>
            <p class="mbxl txtcenter">
                <span class="bold">Le projet a été évalué.</span>
                <?php
                $eval = getEvaluationById($idEvaluation['idevaluation']);
                //Export csv
                $data = array(
                    'lib_groupe' => 'Groupe',
                    'lib_noteCDC' => 'Note cahier des charges',
                    'lib_noteSoutenance' => 'Note soutenance',
                    'lib_noteRendu' => 'Note rendu',
                    'lib_noteFinale' => 'Note finale',
                    'noteCDC' => $eval['notecdc'],
                    'noteSoutenance' => $eval['notesoutenance'],
                    'noteRendu' => $eval['noterendu'],
                    'noteFinale' => $eval['notefinale'],
                    'idGroupe' => $idGroup['idgroupe']
                );
                export_csv($data);
                ?>
                <br>
                <a href="<?php echo "./documents/export_notes_groupe_" . $idGroup['idgroupe'] . ".csv" ?>">
                    > Exporter CSV</a>
            </p>
            <?php
        }
    }
    ?>
</div>
