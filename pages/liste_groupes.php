<!-- Pages listant les groupes enregistrés -->

<table id="liste_groupe">
    <tr class="upper txtcenter">
        <th>Numéro groupe</th>
        <th>Etudiants</th>
    </tr>


    <?php
    $groupsId = getGroupeId();

    foreach ($groupsId

    as $groupId) {
    ?>
    <tr class="font-x-small">
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
