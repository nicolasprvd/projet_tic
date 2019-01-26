<?php
/**
* Formulaire de connexion
* permettant d'accéder à l'application
**/
?>

<div id="signin" class="modal">

  <form method="post" class="modal-content animate" action="">

    <div class="titre">
      <h1>Se connecter</h1>
    </div>

    <div class="container">
      <input type="text" placeholder="Votre identifiant" name="input_login" />
      <input type="password" placeholder="Votre mot de passe" name="input_password" />
      <button type="submit" name="btn_signin">Se connecter</button>
    </div>

    <div class="container" style="background-color:#f1f1f1">
      <button type="button" onclick="document.getElementById('signin').style.display='none'" class="btn_cancel">Annuler</button>
      <span class="psw"><a href="#">Mot de passe oublié ?</a></span>
    </div>
  </form>
</div>

<script>
// On récupère les fenêtres d'signinentification
var signin = document.getElementById('signin');

//Quand l'utilisateur clique en dehors de la fenêtre elle se ferme
window.onclick = function(event) {
    if (event.target == signin) {
        signin.style.display = "none";
    }
}
</script>

<?php

  // Si l'utilisateur a tenté de s'signinentifier
  if(isset($_POST['btn_signin'])) {
    $data = getUserDataAuth($_POST['input_login']);

    if(!password_verify($_POST['input_password'], $data['password'])) {
      ajouterErreur('Identifiant ou mot de passe incorrect');
      include_once('./include/erreurs.php');
    }else {
      connecter($data['idStatut'], $data['nomPersonne'], $data['prenomPersonne']);
      header("Location: index.php");
    }
  }
?>
