<?php
/**
* Formulaire d'inscription
* pour une personne
**/
?>

<div id="signup" class="modal">

  <form method="post" class="modal-content animate" action="">

    <div class="titre">
      <h1>S'inscrire</h1>
    </div>

    <div class="container">
      <input type="text" name="input_name" value="" placeholder="Votre nom" /> <br><br>
      <input type="text" name="input_firstname" value="" placeholder="Votre prénom" /> <br><br>
      <?php
        //On récupère la liste des statut
        $status = getStatus();
      ?>
      <select name="select_status">
        <option selected disabled value="">Votre statut</option>
        <?php
          foreach($status as $stat) {
            ?>
              <option value="<?php echo $stat['idStatut']; ?>"><?php echo $stat['libelle']; ?></option>
            <?php
          }
         ?>
      </select><br><br>
      <input type="text" name="input_email" value="" placeholder="Votre email" /> <br><br>
      <input type="password" name="input_password" value="" placeholder="Votre mot de passe" /> <br><br>
      <input type="password" name="input_password_confirm" value="" placeholder="Confirmez votre mot de passe" /> <br><br>
      <button type="submit" name="btn_signup">S'inscire</button>
    </div>

    <div class="container" style="background-color:#f1f1f1">
      <button type="button" onclick="document.getElementById('signup').style.display='none'" class="btn_cancel">Annuler</button>
    </div>
  </form>
</div>

<script>
// On récupère les fenêtres d'signupentification
var signup = document.getElementById('signup');

//Quand l'utilisateur clique en dehors de la fenêtre elle se ferme
window.onclick = function(event) {
    if (event.target == signup) {
        signup.style.display = "none";
    }
}
</script>


<?php
  if(isset($_POST['btn_signup'])) {
  //Si le formulaire a été envoyé

  if(empty($_POST['input_name']) || empty($_POST['input_firstname']) || empty($_POST['input_email']) || empty($_POST['select_status'])
  || empty($_POST['input_password']) || empty($_POST['input_password_confirm'])) {
    ajouterErreur('Vous devez renseigner tous les champs');
    include_once('./include/erreurs.php');
  }

  if(!filter_var($_POST['input_email'], FILTER_VALIDATE_EMAIL)) {
    ajouterErreur('Votre mail est invalide');
    include_once('./include/erreurs.php');
  }

  //On vérifie que les mots de passes sont similaires
  if($_POST['input_password'] == $_POST['input_password_confirm']) {
    $password = password_hash($_POST['input_password'], PASSWORD_DEFAULT);
    insertNewUser($_POST['select_status'], $_POST['input_name'], $_POST['input_firstname'], $_POST['input_email'], $password);
    connecter($_POST['select_status'], $_POST['input_name'], $_POST['input_firstname']);
    header("Location: index.php");
  }else {
    ajouterErreur('Les mots de passes ne sont pas similaires');
    include_once('./include/erreurs.php');
  }
} ?>
