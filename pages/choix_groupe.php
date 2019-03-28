<?php
/**
 * Page qui permet de choisr un groupe pour le projet du client en question
 **/
?>

    <h2> Choix d'un groupe pour votre projet :"<?php echo $_GET['titre'] ?>"</h2>

    <p> Vous devez choisir un groupe pour votre projet </p>

<?php
//Afficher le  titre du projet

$idgroupe = getIdgroupeByIdproject($_GET['id']);

if (!empty($idgroupe)) {
    ?>
    <?php
    ?>

    <table id="choix_groupe">
        <tr class="upper txtcenter">
            <th>idGroupe</th>
            <th> Chef de projet</th>
            <th> Membres du groupe</th>
            <th>Choix</th>
        </tr>
        <?php


        foreach ($idgroupe as $groupe) {
            ?>
            <tr class="font-x-small">
                <td><?php echo $groupe['idgroupe']; ?></td>


                <?php
                // On recupere le chef de projet du groupe
                $idChefP = getIdChefByIdGroup($groupe['idgroupe']);
                $chef = getPersonneById($idChefP['idpersonneChef']);
                $espace = " ";
                ?>
                <td><?php echo $chef['prenomPersonne'] . $espace . $chef['nomPersonne']; ?></td>

                <?php

                //On recupere le nom et le prenom des personnes du groupe
                $etu = getPersonneByGroupTemp($groupe['idgroupe']);
                $membre = '';

                $separateur = ", ";

                foreach ($etu as $e) {
                    $membre = $membre . $e['prenomPersonne'] . $espace . $e['nomPersonne'] . $separateur;
                }
                $membre = substr($membre, 0, -2);


                ?>

                <td><?php echo $membre; ?></td>
                    <form enctype="multipart/form-data"
                          action=   <?php echo URL . 'mes_projets_client.php&id=' . $_GET['id']; ?> method
                    = "POST" >
                    <input type="hidden" name="id" value='<?php echo $groupe['idgroupe'] ?>'/>
                    <td><input type="submit" class="input_custom" value="Choisir ce groupe" name="btn_choix"/></td>

                </form>
            </tr>
            <?php
        }
        ?>
    </table>
    <?php
} else {
    echo "Personne n'a choisi votre sujet pour le moment.. Revenez plus tard!";
}
?>