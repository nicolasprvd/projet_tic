<p class="font-x-large bold upper mam">Accueil</p>

<?php
require_once('./pages/formulaires/form_inscription.php');
require_once('./pages/formulaires/form_connexion.php');

//Si une personne souhaite se déconnecter
if (!empty($_GET['deconnexion'])) {
    deconnecter();
}
//Si une personne est authentifiée
if (estConnecte()) {
    $status = getStatusById($_SESSION['status']);
    echo '<span class="font-x-small">' . $status['libelle'] . ' : ' . $_SESSION['firstname'] . ' ' . $_SESSION['name'] . '</span>';
} else {
    ?>
    <a onclick="document.getElementById('signup').style.display='block'"> > S'inscrire</a>
    <a onclick="document.getElementById('signin').style.display='block'"> > Se connecter</a>
    <?php
}
?>