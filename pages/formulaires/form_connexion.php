<?php
/**
* Formulaire de connexion
* permettant d'accéder à l'application
**/
?>

<?php

  if(isset($_POST['btn_cancel'])) {
    unset($_REQUEST['erreurs']);
  }

  // Si l'utilisateur a tenté de s'authentifier
  if(isset($_POST['btn_signin'])) {
    $data = getUserDataAuth($_POST['input_login']);
    session_regenerate_id();
    if((!password_verify($_POST['input_password'], $data['password'])) || (!filter_var($_POST['input_login'], FILTER_VALIDATE_EMAIL))) {
      ajouterErreur('Identifiant ou mot de passe incorrect');
      $_SESSION['formSubmittedErrors'] = true;
      echo "<script>document.getElementById('signin').style.display='block';</script>";
    }else {
      connecter($data['idStatut'], $data['nomPersonne'], $data['prenomPersonne']);
      header('Location: index.php');
    }
  }
?>

<div id="signin" class="modal">

  <form method="post" class="modal-content animate">

    <div class="titre">
      <h1>Se connecter</h1>
    </div>

    <div class="container">
      <input type="text" placeholder="Votre identifiant" name="input_login" />
      <input type="password" placeholder="Votre mot de passe" name="input_password" />
      <button type="submit" name="btn_signin">Se connecter</button>

      <?php
        if(isset($_SESSION['formSubmittedErrors']) && $_SESSION['formSubmittedErrors'] == true) {
          echo "<script>document.getElementById('signin').style.display='block';</script>";
          include('./include/erreurs.php');
          unset($_SESSION['formSubmittedErrors']);
          unset($_REQUEST['erreurs']);
        }
       ?>
    </div>

    <div class="container" style="background-color:#f1f1f1">
      <button type="submit" onclick="document.getElementById('signin').style.display='none'" class="btn_cancel" name="btn_cancel">Annuler</button>
      <span class="psw"><a href="#">Mot de passe oublié ?</a></span>
    </div>
  </form>
</div>
