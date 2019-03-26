<?php
/**
* Page permettant de gérer son espace membre
**/
?>

<h1>Mon espace</h1>

<?php

  //Si l'utilisateur a modifié ses informations
  if(isset($_POST['btn_update'])) {
    //Si un des champs est vide
    if(in_array('',$_POST)) {
      ajouterErreur('Vous devez renseigner votre nom, votre prénom et votre email');
      include('./include/erreurs.php');
    }else {
      updateDataPersonne($_POST['input_name'], $_POST['input_firstname'], $_POST['input_email'], $_SESSION['utilisateur']);
      ajouterMessage('Vos données ont été enregistrées');
      $_SESSION['name'] = $_POST['input_name'];
      $_SESSION['firstname'] = $_POST['input_firstname'];
    }
    //ici
  }

  if(isset($_POST['btn_update_password'])) {

    //Si un des champs est vide
    if(in_array('', $_POST)) {
      ajouterErreur('Vous devez renseigner votre mot de passe');
      include('./include/erreurs.php');
    }else {

      //Si le mot de passe est similaire à celui de confirmation
      if($_POST['input_password'] == $_POST['input_password_confirm']) {
        $password = password_hash($_POST['input_password'], PASSWORD_DEFAULT);
        updatePasswordPersonne($password, $_SESSION['utilisateur']);
        ajouterMessage('Votre mot de passe a été modifié');
      }else {
        ajouterErreur('Mots de passe incorrects');
        include('./include/erreurs.php');
      }
    }
  }

  if(isset($_REQUEST['messages'])) {
    include('./include/messages.php');
  }
  unset($_REQUEST['messages']);
  //Données du formulaire
  $dataUser = getPersonneById($_SESSION['utilisateur']);
?>

<form method="post" action="<?php echo URL.'form_mon_espace.php'; ?>">
  <input type="text" name="input_name" value="<?php echo $dataUser['nomPersonne']; ?>" /> <br><br>
  <input type="text" name="input_firstname" value="<?php echo $dataUser['prenomPersonne']; ?>" /> <br><br>
  <input type="text" disabled name="input_status" value="<?php echo $dataUser['libelle']; ?>" /> <br><br>
  <input type="text" name="input_email" value="<?php echo $dataUser['mailPersonne']; ?>" /> <br><br>
  <input type="submit" name="btn_update" value="Modifier mes informations" />
</form>

<br><br><br>

<form method="post">
  <input type="password" placeholder="Nouveau mot de passe" name="input_password" /> <br><br>
  <input type="password" name="input_password_confirm" placeholder="Confimer mot de passe" /> <br><br>
  <input type="submit" name="btn_update_password" value="Modifier mon mot de passe" />
</form>