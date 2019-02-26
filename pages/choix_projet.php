<?php
/**
* Page permettant de se positionner
* sur un projet
**/
?>

 <?php
   $project = getProjectById($_GET['id']);
   $idPersonne = getIdPeople($_SESSION['name'], $_SESSION['firstname']);
   $status = 2;
   $personnes = getPersonnes($status, $idPersonne[0]);

   $dataGroupeTemp = getGroupeTemp($idPersonne[0]);
   $data = getChefGroupeProjet($dataGroupeTemp['idPersonneChef'], $_GET['id']);
   $nbChoixProjets = count(getChoixTempByGroupTemp($dataGroupeTemp['idGroupe']));
   $name="btn_submit_validate";
   $value="Valider";
   // Si la personne authentifiée est chef d'un groupe
   if($dataGroupeTemp != null) {
     //Si la personne authentifiée est rattachée au projet sur lequel elle est déjà positonnée
     if($data != null) {
       $name="btn_submit_retract";
       $value="Se rétracter";
     }
   }
 ?>

<h1><?php echo $project['nomProjet']; ?></h1>

<p>Vous avez choisi le sujet : <?php echo $project['nomProjet']; ?></p>
<p>Vous pouvez vous positionner sur plusieurs sujets, votre affectation sera faite aléatoirement. <br>Afin de vous positionner sur ce sujet, veuillez constituer votre groupe à partir des éléments ci-dessous. Ce projet nécessite <?php echo $project['nbEtudiants']; ?> étudiants.</p>
<form method="post">
<?php
  //Le choix du projet a déjà eu lieu
  if($data != null || $nbChoixProjets >= 1) {
    $dataPersonnesGroupe = getPersonneByGroupTemp($dataGroupeTemp['idGroupe']);
    $i = 1;
    foreach($dataPersonnesGroupe as $personne) {
      echo 'Etudiant ' . $i. ' : ';
      ?>
        <input type="hidden" name="group[]" value="<?php echo $personne['idPersonne']; ?>">
        <input type="text" disabled name="pers[]" value="<?php echo $personne['prenomPersonne'] . ' ' . $personne['nomPersonne']; ?>" />
      <?php
      $i++;
    }
  }else {
      for($i=1; $i < $project['nbEtudiants']; $i++) {
        echo 'Etudiant ' . $i . ' : ';
        ?>
          <select name="etu[]">
            <option selected disabled value="">Sélectionnez un étudiant</option>
            <?php
              foreach($personnes as $p) {
                ?>
                  <option value="<?php echo $p['idPersonne']; ?>"><?php echo $p['prenomPersonne'] . ' ' . $p['nomPersonne']; ?></option>
                <?php
              }
             ?>
          </select>
          <br><br>
        <?php
      }
     ?>
    Chef de groupe :
    <select name="chef">
        <option selected disabled value="">Sélectionnez un étudiant</option>
        <option value="<?php echo $idPersonne[0]; ?>"><?php echo $_SESSION['firstname'] . ' ' . $_SESSION['name']; ?></option>
        <?php
        foreach($personnes as $p) {
          ?>
            <option value="<?php echo $p['idPersonne']; ?>"><?php echo $p['prenomPersonne'] . ' ' . $p['nomPersonne']; ?></option>
          <?php
        }
       ?>
    </select>
    <?php
    }
 ?>
<br><br>

  <input type="submit" name="<?php echo $name; ?>" value="<?php echo $value; ?>" />
</form>


<?php

    //Si la personne souhaite se positionner sur un projet
    if(isset($_POST['btn_submit_validate'])) {

      if($dataGroupeTemp != null) {
        //Si les étudiants se sont déjà positionnés sur un sujet
        //Récupérer les value des inputs
        $groupIds = array();
        $groupIds = $_POST['group'];
        foreach($groupIds as $id) {
          insertNewChoixTemp($_GET['id'], $dataGroupeTemp['idGroupe']);
          echo 'Votre choix a été enregistré';
          exit;
        }
      }


      //Si le chef de groupe n'a pas été sélectionné ou si tous les étudiants n'ont pas été sélectionnés
      if(empty($_POST['chef']) || empty($_POST['etu']) || (count($_POST['etu']) < $project['nbEtudiants']-1)) {
        ajouterErreur('Vous devez choisir un chef de groupe et choisir chaque étudiant');
        include('./include/erreurs.php');
      }else {
        $etu = array();
        $etu = $_POST['etu'];
        //On stocke dans le tableau $etu les identifiants des personnes du groupe
        array_push($etu, $_POST['chef']);
        if(!in_array($_POST['chef'], $etu)) {
          ajouterErreur('Le chef de groupe doit faire partie des étudiants sélectionnés');
          include('./include/erreurs.php');
        }else {
          //Gère les doublons
          if(count(array_unique($etu)) < count($etu)) {
            ajouterErreur('Vous ne pouvez pas choisir plusieurs fois la même personne');
            include('./include/erreurs.php');
          }else {
            //On récupère l'identifiant du chef de groupe
            $idChef = $_POST['chef'];

            //Si le chef de projet est déjà dans un groupe temporaire on ne crée pas un autre groupe
            $idGroupChef = getGroupeTempByPersonne($idChef);
            if($idGroupChef['idGroupeTemp'] == null) {
              //On crée un groupe temporaire avec un chef
              insertNewGroupeTemp($idChef);

              //On récupère le dernier identifiant inséré en base, soit l'identifiant du groupe
              $idGroup = $GLOBALS['connex']->lastInsertId();

              //On affecte à chaque personne du groupe temporaire l'identifiant du groupe auquel elles appartiennent
              foreach($etu as $e) {
                updatePersonneGroupeTemp($idGroup, $e);
              }

              // On insère le choix du projet pour le groupe en base
              insertNewChoixTemp($_GET['id'], $idGroup);
            }else {
              // On insère le choix du projet pour le groupe en base
              insertNewChoixTemp($_GET['id'], $idGroupChef['idGroupeTemp']);
            }
            echo 'Votre choix a été enregistré';
          }
        }
      }
    }



  //Si la personne souhaite se rétracter
  if(isset($_POST['btn_submit_retract'])) {


    //On supprime la ligne dans choix temp pour le groupe de la personne connectée et le projet correspondant
    $idGroup = getGroupeTempByPersonne($idPersonne[0]);
    $_SESSION['group_temp'] = $idGroup['idGroupeTemp'];
    deleteChoixTemp($_SESSION['group_temp'], $_GET['id']);

    //Nombre de choix effectués
    $nbChoixProjets = count(getChoixProjets($_SESSION['group_temp']));

    //Si tous les choix ont été annulés, on supprime le groupe temporaire
    if($nbChoixProjets == 0) {
      //On supprime la ligne dans groupe temp pour la personne connectée (chef)
      deleteGroupTemp($idPersonne[0]);
      $etu = getPersonneByGroupTemp($_SESSION['group_temp']);
      foreach($etu as $e) {
        updatePersonneGroupeTemp(null, $e['idPersonne']);
      }
      unset($_SESSION['group_temp']);
    }

    echo 'Votre choix a été enregistré avec succès.';
  }
 ?>
