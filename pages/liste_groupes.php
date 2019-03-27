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
