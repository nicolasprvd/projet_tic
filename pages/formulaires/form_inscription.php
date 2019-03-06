<?php
/**
 * Formulaire d'inscription
 * pour une personne
 **/
?>
<?php

//On récupère la liste des statuts
$status = getStatus();

if (isset($_POST['btn_cancel'])) {
    unset($_REQUEST['erreurs']);
}

//Si le formulaire a été envoyé
if (isset($_POST['btn_signup'])) {

    //Si les champs sont vides
    if (empty($_POST['input_name']) || empty($_POST['input_firstname']) || empty($_POST['input_email']) || empty($_POST['select_status'])
        || empty($_POST['input_password']) || empty($_POST['input_password_confirm'])) {
        ajouterErreur('Veuillez renseigner tous les champs');
        $_SESSION['formSubmittedErrors'] = true;
        echo "<script>document.getElementById('signup').style.display='block';</script>";
    }

    //Si l'adresse mail n'est pas valide
    if (!filter_var($_POST['input_email'], FILTER_VALIDATE_EMAIL)) {
        ajouterErreur('Votre email est invalide');
        $_SESSION['formSubmittedErrors'] = true;
        echo "<script>document.getElementById('signup').style.display='block';</script>";
    }

    //On vérifie que les mots de passes sont similaires
    if ($_POST['input_password'] == $_POST['input_password_confirm']) {
        $password = password_hash($_POST['input_password'], PASSWORD_DEFAULT);
        if (!isset($_SESSION['formSubmittedErrors'])) {
            insertNewUser($_POST['select_status'], $_POST['input_name'], $_POST['input_firstname'], $_POST['input_email'], $password);
            connecter($_POST['select_status'], $_POST['input_name'], $_POST['input_firstname']);
            header("Location: index.php");
        }
    } else {
        ajouterErreur('Les mots de passes ne sont pas similaires');
        $_SESSION['formSubmittedErrors'] = true;
        echo "<script>document.getElementById('signup').style.display='block';</script>";
    }
}
?>

<div id="signup" class="modal-inscription">
    <form method="post" class="modal-content-inscription animate">

        <div class="font-x-large bold upper">
            <p>S'inscrire</p>
        </div>

        <div class="inscription-input container">
            <input type="text" class="mbm pas border-black" name="input_name" value="" placeholder="Votre nom"/>
            <input type="text" class="mbm pas border-black" name="input_firstname" value="" placeholder="Votre prénom"/>

            <select name="select_status" class="mbm pats border-black">
                <option selected disabled value="">Votre statut</option>
                <?php
                foreach ($status as $stat) {
                    ?>
                    <option value="<?php echo $stat['idStatut']; ?>"><?php echo $stat['libelle']; ?></option>
                    <?php
                }
                ?>
            </select>
            <input type="text" class="mbm pas border-black" name="input_email" value="" placeholder="Votre email"/>
            <input type="password" class="mbm pas border-black" name="input_password" value="" placeholder="Votre mot de passe"/>
            <input type="password" class="pas border-black" name="input_password_confirm" value=""
                   placeholder="Confirmez votre mot de passe"/>
        </div>

        <div class="container mrs txtright">
            <button type="submit" onclick="document.getElementById('signin').style.display='none'" class="mrs"
                    name="btn_cancel">Annuler
            </button>
            <button type="submit" name="btn_signin">Se connecter</button>
        </div>

        <?php
        if (isset($_SESSION['formSubmittedErrors']) && $_SESSION['formSubmittedErrors'] == true) {
            echo "<script>document.getElementById('signup').style.display='block';</script>";
            include('./include/erreurs.php');
            unset($_SESSION['formSubmittedErrors']);
            unset($_REQUEST['erreurs']);
        }
        ?>
    </form>
</div>
