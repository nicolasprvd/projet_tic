<!-- Pages listant les groupes enregistrés -->

<table class="font-xx-small" id="liste_groupe">
    <tr class="upper">
        <th>Numéro groupe</th>
        <th>Etudiants</th>
    </tr>

    <tr class="font-x-small">
        <?php
        $groupsId = getGroupeId();

        foreach ($groupsId as $groupId) {
            ?>
            <td class="txtcenter"><?php echo $groupId['idGroupe']; ?></td>
            <td>
                <?php
                $personnes = getPersonnesByGroup($groupId['idGroupe']);
                foreach ($personnes as $personne) {
                    echo $personne['prenomPersonne'] . ' ' . $personne['nomPersonne'] . '<br>';
                }
                ?>
            </td>
            <?php
        }
        ?>
    </tr>
</table>
<?php
$idEvaluation = getEvaluationPersonne($groupId['idGroupe']);

$dataPersonnes = getPersonneByEvaluation($idEvaluation['idevaluation']);
$dataArray = array(
    'lib_etudiant' => 'Etudiant',
    'lib_noteCDC' => 'Note cahier des charges',
    'lib_noteSoutenance' => 'Note soutenance',
    'lib_noteRendu' => 'Note rendu',
    'lib_noteFinale' => 'Note finale',
);
$entete = array($dataArray['lib_etudiant'], $dataArray['lib_noteCDC'], $dataArray['lib_noteSoutenance'], $dataArray['lib_noteRendu'], $dataArray['lib_noteFinale']);

foreach ($dataPersonnes as $d) {

}

?>
