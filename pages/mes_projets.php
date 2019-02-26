<?php
/**
* Page qui liste les projets temporaires choisis
* Une fois le projet attribué on y voit ses informations, les pieces a deposé etc
**/  

 //On récupère l'identifiant de la personne connectée
 $idPersonne = getIdPeople($_SESSION['name'], $_SESSION['firstname']);
 //On récupère le groupe auquel elle appartient
 $idGroup = getGroupeTempByPersonne($idPersonne[0]);

 $attribuate = getProjectAttribuate($idGroup['idGroupeTemp']);
if (empty($attribuate))  { 
?>
  <h1>Mes projets</h1>
    <?php
      //On récupère la liste de ses choix
      $projects = getChoixProjets($idGroup['idGroupeTemp']);

      if($projects == null) {
        echo '<p>Vous n\'avez choisi aucun projet pour le moment.</p>';
      }else {
        ?>
        <table>
          <tr>
            <th>Nom</th>
            <th>Description</th>
            <th>Actions</th>
          </tr>
        <?php
        foreach($projects as $project) {
          ?>
          <tr>
            <td><?php echo $project['nomProjet']; ?></td>
            <td><?php echo $project['descriptifTexte']; ?></td>
            <?php
              //Si c'est le responsable de projet
              if($project['idPersonneChef'] == $idPersonne[0]) {
                ?>
                  <td><a href="<?php echo URL.'choix_projet.php&id='.$project['idProjet'];?>">Se rétracter</a></td>
                <?php
              }else {
                ?>
                <td><a href="<?php echo URL.'infos_projets.php&id='.$project['idProjet'];?>">Voir</a></td>
                <?php
              }
            }
             ?>
          </tr>
        </table>
     <?php
      }
  } else {
  ?>
      <?php
      $myProject = getProjectById($attribuate['idprojet']);
      ?>
      <h1>Mon projet : <?php echo $myProject['nomProjet']; ?></h1>

    

     <?php $myProject['nomProjet']; ?>
      Client : <?php echo $myProject['prenomPersonne'] . ' ' . $myProject['nomPersonne']; ?> <br>
      Mail client : <?php echo $myProject['mailPersonne']; ?> <br>
      Nombre d'étudiants : <?php echo $myProject['nbEtudiants']; ?> <br>
      Description : <?php echo $myProject['descriptifTexte']; ?> <br>
      
      <?php
      if($myProject['descriptifPdf'] != null) {
      ?>
        Fichier joint : <a href="documents/sujet_client/<?php echo $myProject['descriptifPdf']; ?>" target=\"_BLANK\">Télécharger</a>
      <?php

      
      }
      $idGroup = getIdgroupeByIdprojectFinal($myProject['idProjet']);

        //On recupere le nom et le prenom des personnes du groupe 
        $etu = getPersonneByGroupTemp($idGroup['idgroupe']);
        $membre ='';
        $espace = " ";
        $separateur = ", ";
        
        foreach($etu as $e) {
        $membre = $membre . $e['prenompersonne'] . $espace .$e['nompersonne']  . $separateur ;
        }
        $membre = substr($membre, 0, -2);


        $idChef = getIdChefFinalByIdGroup($idGroup['idgroupe']);
        $chef = getInformationPeopleById($idChef['idpersonneChef']);
      ?>
      <br>
      Chef de projet : <?php echo $chef['prenompersonne'] . ' ' .  $chef['nompersonne'];?> <br>
      Membres du projet : <?php echo $membre ;?><br>

      <br><br>
      <!--Depot/visualisation du cdc-->
      <h4>Cahier des charges : </h4>
      <?php 
      $docSubmit = getDocSubmit($myProject['idProjet'], 'CDC');
      if (empty($docSubmit)) {
      ?>

      <form enctype="multipart/form-data" action = "index.php?page=mes_projets.php" method = "POST">
      Dépôt du cahier des charges: (Le fichier doit être nommé : CDC_nomDesMembres_annee. L'extension doit être du doc, docs ou pdf.) </BR>
      <input type="file" name="CDC" />
      <input type = "submit" value = "Déposer" name = "btn_depot_CDC"/>
      </form>

      <?php 
      }else{
        echo 'Le cahier des charges a été déposé :' ?> <a href="documents/cahier_des_charges/<?php echo $docSubmit['chemindoc']; ?>" target=\"_BLANK\">Télécharger</a>
        <?php 
      }
      ?>

      <!--Depot/visualisation du rendu-->
      <h4>Rendu final : </h4>
      <?php 
      $docSubmit = getDocSubmit($myProject['idProjet'], 'RF');
      if (empty($docSubmit)) {
      ?>

      <form enctype="multipart/form-data" action = "index.php?page=mes_projets.php" method = "POST">
      Dépôt du rendu final: (Le fichier doit être nommé : RF_nomDesMembres_annee. L'extension doit être du zip, 7zip ou rar.) </BR>
      <input type="file" name="RF" />
      <input type = "submit" value = "Déposer" name = "btn_depot_RF"/>
      </form>

      <?php 
      }else{
        echo 'Le rendu final a été déposé :' ?> <a href="documents/rendu_final/<?php echo $docSubmit['chemindoc']; ?>" target=\"_BLANK\">Télécharger</a>
        <?php 
      }
    }
?>


<?php

//traitement CDC
if(isset($_POST['btn_depot_CDC'])) {

  $target_path = "";
  $fichier = "";

  //Si le fichier a été inseré
  if ($_FILES['CDC']['size'] <> 0){


    $extensions = array('.doc', '.docs', '.pdf');
    $extension = strrchr($_FILES['CDC']['name'], '.'); 
    //Début des vérifications de sécurité... (extension du fichier)
    if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
    {
        ajouterErreur('Vous devez uploader un fichier de type doc, docs ou pdf, réessayez!');
        include_once('./include/erreurs.php');
        exit;
    }

    //Nous vérifions que le dossier d'enregistrement du fichier est bien présent
    if (file_exists("./documents")){
      if (!file_exists("./documents/cahier_des_charges")){
           mkdir("./documents/cahier_des_charges");
     }
    }
    else {
      mkdir("./documents");
     mkdir("./documents/cahier_des_charges");
    }

    // Permet l'insertion du fichier joint dans le dossier concerner
    $target_path = "./documents/cahier_des_charges/";
    $target_path = $target_path . basename( $_FILES['CDC']['name']);
    $fichier = $_FILES['CDC']['name'];
    if(move_uploaded_file($_FILES['CDC']['tmp_name'], $target_path)) {
      echo "Fichier ajouté avec succès";
      echo "<br>" ;
    } else{
        ajouterErreur('Une erreur s est produite lors l enregistrement du fichier, réessayez!');
        include_once('./include/erreurs.php');
        exit();
    }

  //-> Faire l'nsertion dans la base

      // On insere le document dans la base
        insertNewDoc($myProject['idProjet'], $fichier, 'CDC');
        echo "Le cahier des charges a bien été déposé";

  //Si le fichier n'a pas été inseré
  }else {
    ajouterErreur('Vous devez inserer votre pièce jointe!');
    include_once('./include/erreurs.php');
  }
}


//traitement rendu final
if(isset($_POST['btn_depot_RF'])) {

  $target_path = "";
  $fichier = "";

  //Si le fichier a été inseré
  if ($_FILES['RF']['size'] <> 0){

    $extensions = array('.zip', '.7z', '.rar');
    $extension = strrchr($_FILES['RF']['name'], '.'); 
    //Début des vérifications de sécurité... (extension du fichier)
    if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
    {
        ajouterErreur('Vous devez uploader un fichier de type zip, 7z ou rar, réessayez!');
        include_once('./include/erreurs.php');
        exit;
    }

    //Nous vérifions que le dossier d'enregistrement du fichier est bien présent
    if (file_exists("./documents")){
      if (!file_exists("./documents/rendu_final")){
           mkdir("./documents/rendu_final");
     }
    }
    else {
      mkdir("./documents");
     mkdir("./documents/rendu_final");
    }

    // Permet l'insertion du fichier joint dans le dossier concerner
    $target_path = "./documents/rendu_final/";
    $target_path = $target_path . basename( $_FILES['RF']['name']);
    $fichier = $_FILES['RF']['name'];
    if(move_uploaded_file($_FILES['RF']['tmp_name'], $target_path)) {
      echo "Fichier ajouté avec succès";
      echo "<br>" ;
    } else{
        ajouterErreur('Une erreur s est produite lors l enregistrement du fichier, réessayez!');
        include_once('./include/erreurs.php');
        exit();
    }

  //-> Faire l'nsertion dans la base

      // On insere le document dans la base
        insertNewDoc($myProject['idProjet'], $fichier, 'RF');
        echo "Le rendu final a bien été déposé";

  //Si le fichier n'a pas été inseré
  }else {
    ajouterErreur('Vous devez inserer votre pièce jointe!');
    include_once('./include/erreurs.php');
  }
}
?>