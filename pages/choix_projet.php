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

Etudiant 1 :<input type="text" disabled name="etu_1" placeholder="<?php echo $_SESSION['firstname'] . ' ' . $_SESSION['name']; ?>" value="<?php $idPersonne[0]; ?>" />
<?php
  //Le choix du projet a déjà eu lieu
  if($data != null) {
    $dataPersonnesGroupe = getPersonnesByProject($_GET['id'], $idPersonne[0]);
    $i = 2;
    foreach($dataPersonnesGroupe as $personne) {

      echo 'Etudiant ' . $i. ' : ';
      ?>
        <input type="text" disabled name="group[]" placeholder="<?php echo $personne['prenomPersonne'] . ' ' . $personne['nomPersonne']; ?>" value="<?php $personne['idPersonne'] ?>" />
      <?php
      $i++;
    }
  }else {
    ?>
    Chef de groupe :
    <select name="chef">
        <option value="<?php echo $idPersonne[0]; ?>"><?php echo $_SESSION['firstname'] . ' ' . $_SESSION['name']; ?></option>
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
      for($i=1; $i < $project['nbEtudiants']; $i++) {
        echo 'Etudiant ' . ($i+1);
        ?>
          <select name="etu[]">
            <?php
              foreach($personnes as $p) {
                ?>
                  <option value="<?php echo $p['idPersonne']; ?>"><?php echo $p['prenomPersonne'] . ' ' . $p['nomPersonne']; ?></option><br><br>
                <?php
              }
             ?>
          </select>
        <?php
      }
     ?>
    <br><br>
    <?php
    }
 ?>
<br>

  <input type="button" name="btn_cancel" value="Annuler" />
  <input type="button" name="<?php echo $name; ?>" value="<?php echo $value; ?>" />
</form>


<?php


  if(isset($_POST['btn_submit_validate'])) {

    //On récupère l'identifiant du chef de groupe
    $idChef = $_POST['chef'];

    //On crée un groupe temporaire avec un chef
    insertNewGroupeTemp($idChef);

    //On récupère le dernier identifiant inséré en base, soit l'identifiant du groupe
    $idGroup = $GLOBALS['connex']->lastInsertId();

    $etu = array();
    $etu = $_POST['etu'];
    //On stocke dans le tableau $etu les identifiants des personnes du groupe
    array_push($etu, $idChef);

    //On affecte à chaque personne du groupe temporaire l'identifiant du groupe auquel elles appartiennent
    foreach($etu as $e) {
      updatePersonneGroupeTemp($idGroup, $e);
    }
    // On insère le choix du projet pour le groupe en base
    insertNewChoixTemp($_GET['id'], $idGroup);
    echo 'Votre choix a été enregistré avec succès.';
  }

 ?>
