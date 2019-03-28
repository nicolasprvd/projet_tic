<?php
/**
* Formulaire de connexion à l'application
**/

if(isset($_POST['btn_cancel'])) {
    unset($_REQUEST['erreurs']);
}

// Si l'utilisateur a tenté de s'authentifier
if (isset($_POST['btn_signin'])) {
    $data = getUserDataAuth($_POST['input_login']);
    if ((!password_verify($_POST['input_password'], $data['password'])) || (!filter_var($_POST['input_login'], FILTER_VALIDATE_EMAIL))) {
        ajouterErreur('Identifiant ou mot de passe incorrect');
        $_SESSION['formSubmittedErrors'] = true;
        echo "<script>document.getElementById('signin').style.display='block';</script>";
    }else {
        connecter($data['idStatut'], $data['nomPersonne'], $data['prenomPersonne'], $data['idPersonne']);
        header('Location: index.php');
    }
}
?>

<div id="signin" class="modal font-xx-small">
    <form method="post" class="modal-content animate">

        <div class="font-x-large bold upper">
            <p>Se connecter</p>
        </div>

        <div class="erreur_center">
            <?php
            if (isset($_SESSION['formSubmittedErrors']) && $_SESSION['formSubmittedErrors'] == true) {
                echo "<script>document.getElementById('signin').style.display='block';</script>";
                include('./include/erreurs.php');
                unset($_SESSION['formSubmittedErrors']);
                unset($_REQUEST['erreurs']);
            }
            ?>
        </div>

        <div class="connection-input container">
            <input type="text" class="mbm pas border-black" placeholder="Identifiant" name="input_login"/>
            <input type="password" class="mbm pas border-black" placeholder="Mot de passe" name="input_password"/>
        </div>

        <div class="container mrs txtright">
            <button type="submit" name="btn_signin">Se connecter</button>
            <button onclick="document.getElementById('signin').style.display='none'" class="mrs" name="btn_cancel">Annuler
            </button>
        </div>
    </form>
</div>
