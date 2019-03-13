<div id="logo_universite"></div>
<nav>
    <ul class="navigation">
        <li>
            <a href="index.php">Accueil</a>
            <?php
            //L'utilisateur est connecté
            if (estConnecte()) {
                //Admin uniquement
                if ($_SESSION['status'] == 1) {
                    ?>
                    <a href=<?php echo URL . 'form_ajout_projet.php' ?>>Ajouter un projet</a>
                    <a href=<?php echo URL . 'liste_projets.php' ?>>Les projets disponibles</a>
                    <a href=<?php echo URL . 'mes_projets_client.php' ?>>Mes projets</a>
                    <a href=<?php echo URL . 'attribution_projets_admin.php' ?>>Attributions des projets</a>
                    <?php
                    //Responsable de projet uniquement
                } else if ($_SESSION['status'] == 2) {
                    ?>
                    <a href=<?php echo URL . 'form_ajout_projet.php' ?>>Ajouter un projet</a>
                    <a href=<?php echo URL . 'mes_projets_client.php' ?>>Mes projets</a>
                    <?php
                    // Étudiant
                } else if ($_SESSION['status'] == 2) {
                    //On récupère l'identifiant de l'étudiant
                    $idPersonne = getIdPeople($_SESSION['name'], $_SESSION['firstname']);
                    //On récupère le groupe auquel il appartient
                    $idGroup = getGroupeTempByPersonne($idPersonne[0]);
                    $attribuate = getProjectAttribuate($idGroup['idGroupeTemp']);

                    //Si le groupe n'a pas son projet attribué
                    if (empty($attribuate)) {
                        ?>
                        <a href=<?php echo URL . 'liste_projets.php' ?>>Les projets disponibles</a>
                        <a href="<?php echo URL . 'mes_projets.php' ?>">Mes projets</a>
                        <?php
                        //Si le groupe a son projet attribué
                    } else {
                        ?>
                        <a href="<?php echo URL . 'mes_projets.php' ?>">Mon projet</a>
                        <?php
                    }
                }
                ?>
                <a href="index.php?deconnexion=true">Se déconnecter</a>
                <?php
            }
            ?>
        </li>
    </ul>
</nav>