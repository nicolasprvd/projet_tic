<?php

if (isset($_POST['btn_cancel'])) {
    unset($_REQUEST['erreurs']);
}

// Si l'utilisateur a tenté de s'authentifier
if (isset($_POST['btn_signin'])) {
    $data = getUserDataAuth($_POST['input_login']);
    session_regenerate_id();
    if ((!password_verify($_POST['input_password'], $data['password'])) || (!filter_var($_POST['input_login'], FILTER_VALIDATE_EMAIL))) {
        ajouterErreur('Identifiant ou mot de passe incorrect');
        $_SESSION['formSubmittedErrors'] = true;
        echo "<script>document.getElementById('signin').style.display='block';</script>";
    } else {
        connecter($data['idStatut'], $data['nomPersonne'], $data['prenomPersonne']);
        header('Location: index.php');
    }
}
?>

<div id="signin" class="modal">
    <form method="post" class="modal-content modal-content-image animate">

        <div class="titre">
            <h1>Se connecter</h1>
        </div>

        <div class="connection-input container">
            <input type="text" placeholder="Identifiant" name="input_login" class="border-black"/>
            <input type="password" placeholder="Mot de passe" name="input_password" class="border-black"/>
            <span class="mts"><a href="#"> > Mot de passe oublié ?</a></span>

            <?php
            if (isset($_SESSION['formSubmittedErrors']) && $_SESSION['formSubmittedErrors'] == true) {
                echo "<script>document.getElementById('signin').style.display='block';</script>";
                include('./include/erreurs.php');
                unset($_SESSION['formSubmittedErrors']);
                unset($_REQUEST['erreurs']);
            }
            ?>

        </div>


        <div class="container mrs txtright">
            <button type="submit" onclick="document.getElementById('signin').style.display='none'" class="mrs"
                    name="btn_cancel">Annuler
            </button>
            <button type="submit" name="btn_signin">Se connecter</button>
        </div>
    </form>
</div>
