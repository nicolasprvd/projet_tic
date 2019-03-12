<?php
/**
* Page permettant la saisie des notes
* pour l'évaluation du projet par le client
**/
?>

<h1>Evaluation du projet : <br> <?php echo $_GET['titre']; ?> </h1>

<form enctype="multipart/form-data" method="post">
  <table>
    <tr>
      <th>Libellé</th>
      <th>Note</th>
      <th>Coefficient</th>
    </tr>
    <tr>
      <td>Cahier des charges</td>
      <td><?php define_list_note('note_cdc'); ?></td>
      <td><?php define_list_coeff('coeff_cdc'); ?></td>
    </tr>
    <tr>
      <td>Soutenance</td>
      <td><?php define_list_note('note_soutenance'); ?></td>
      <td><?php define_list_coeff('coeff_soutenance'); ?></td>
    </tr>
    <tr>
      <td>Rendu final</td>
      <td><?php define_list_note('note_rendu'); ?></td>
      <td><?php define_list_coeff('coeff_rendu'); ?></td>
    </tr>
  </table>

  <br>

<input type="submit" name="btn_calcul" value="Calculer la note finale">
</form>
<?php
  if(isset($_POST['btn_calcul'])) {
    //Teste sur les champs
    //Champs vides
    if(empty($_POST['note_cdc']) || empty($_POST['note_soutenance']) || empty($_POST['note_rendu'])) {
      ajouterErreur('Vous devez renseigner toutes les notes');
      include('./include/erreurs.php');
    }else {
      $somme_coeff = $_POST['coeff_cdc'] + $_POST['coeff_soutenance'] + $_POST['coeff_rendu'];
      $moyenne = ((($_POST['note_cdc']*$_POST['coeff_cdc']) + ($_POST['note_soutenance']*$_POST['coeff_soutenance']) + ($_POST['note_rendu']*$_POST['coeff_rendu']))/$somme_coeff);
      echo 'Note finale = ' . $moyenne;

      //Insertion en base de données
      $notes = array();
      array_push($notes, $_POST['note_cdc'], $_POST['note_soutenance'], $_POST['note_rendu'], $moyenne);
      insertNewEvaluation($notes);

      //Insertion dans la table personne
      $idEvaluation = $GLOBALS['connex']->lastInsertId();
      $idGroup = getIdgroupeByIdprojectFinal($_GET['id']);
      updatePersonneEvaluation($idEvaluation, $idGroup['idgroupe']);

      ajouterMessage('Votre évaluation a été prise en compte');
      include('./include/messages.php');
      ?>
        <input type="button" name="btn_retour" value="Retour" onclick="history.go(-2)">
      <?php
    }



  }

 ?>
