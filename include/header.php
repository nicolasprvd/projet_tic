<p class="font-x-large bold upper">Accueil</p>

<?php
//Si une personne souhaite se déconnecter
if(!empty($_GET['deconnexion'])) {
    deconnecter();
}
//Si une personne est authentifiée
if(estConnecte()) {
    $status = getStatusById($_SESSION['status']);
    echo '<span>' . $status['libelle'] . ' : ' . $_SESSION['firstname'] . ' ' . $_SESSION['name'] . '</span>';
    ?>
    <a href="index.php?deconnexion=true">Se déconnecter</a>
    <?php
}else {
    ?>
    <a class="link_auth" onclick="document.getElementById('signin').style.display='block'">Se connecter</a>
    <?php require_once('./pages/formulaires/form_connexion.php'); ?>
    <a class="link_auth" onclick="document.getElementById('signup').style.display='block'">S'inscrire</a>
    <?php
    require_once('./pages/formulaires/form_inscription.php');

}
?>
