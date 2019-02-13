<p class="font-x-large bold upper">Accueil</p>
<?php

//Si une connexion existe
if(estConnecte()) {

    //Si l'admin ou un responsable projet est connecté
    if($_SESSION['status'] == 1 || $_SESSION['status'] == 3) {
        ?>
        <nav>
            <ul>
                <li><a href=<?php echo URL.'liste_projets.php' ?>>Les projets</a></li>
                <li><a href=<?php echo URL.'form_ajout_projet.php'?>>Ajouter un projet</a></li>
            </ul>
        </nav>
        <?php
    }else if($_SESSION['status'] == 2) {
        ?>
        <nav>
            <ul>
                <li><a href=<?php echo URL.'liste_projets.php' ?>>Les projets</a></li>
            </ul>
        </nav>
        <?php
    }
}

?>
