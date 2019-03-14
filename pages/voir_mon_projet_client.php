<?php
/**
* Page qui permet de voir un de mes projets ainsi que les pieces deposé par les étudiant
**/


$myProject = getProjectById($_GET['id']);
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
    $membre = $membre . $e['prenomPersonne'] . $espace .$e['nomPersonne']  . $separateur ;
  }
  $membre = substr($membre, 0, -2);


  $idChef = getIdChefFinalByIdGroup($idGroup['idgroupe']);
  $chef = getInformationPeopleById($idChef['idpersonneChef']);
    ?>
    <br>
    Chef de projet : <?php echo $chef['prenompersonne'] . ' ' .  $chef['nompersonne'];?> <br>
    Membres du projet : <?php echo $membre ;?> <br><br>

    <!--Visualisation du cdc-->
    <h4>Cahier des charges : </h4>
    <?php
    $docSubmit = getDocSubmit($myProject['idProjet'], 'CDC');
      if (empty($docSubmit)) {
        echo "Le cahier des charges n'a pas encore été déposé";
      }else{
        echo 'Le cahier des charges a été déposé :' ?> <a href="documents/cahier_des_charges/<?php echo $docSubmit['chemindoc']; ?>" target=\"_BLANK\">Télécharger</a>
        <?php
      }
      ?>

    <!--Visualisation du gantt-->
    <h4>Cahier des charges : </h4>
    <?php
    $docSubmit = getDocSubmit($myProject['idProjet'], 'GANTT');
      if (empty($docSubmit)) {
        echo "Le gantt n'a pas encore été déposé";
      }else{
        echo 'Le gantt a été déposé :' ?> <a href="documents/gantt/<?php echo $docSubmit['chemindoc']; ?>" target=\"_BLANK\">Télécharger</a>
        <?php
      }
      ?>


      <!--Visualisation du rendu-->
      <h4>Rendu final : </h4>
      <?php
      $docSubmit = getDocSubmit($myProject['idProjet'], 'RF');
        if (empty($docSubmit)) {
          echo "Le rendu final n'a pas encore été déposé";
        }else{
          echo 'Le rendu final a été déposé :' ?> <a href="documents/rendu_final/<?php echo $docSubmit['chemindoc']; ?>" target=\"_BLANK\">Télécharger</a>
          <?php
        }

        // Redirection vers l'évaluation du projet
        $documents = getDocuments($myProject['idProjet']);

        //Si tous les documents ont été transmis
        if(count($documents) == 3) {
          //Si l'évaluation n'a pas été faite
          $idEvaluation = getEvaluationPersonne($idGroup['idgroupe']);
          if(empty($idEvaluation['idevaluation'])) {
            ?>
              </BR></BR>
              <a href="<?php echo URL.'form_evaluation.php&id='.$_GET['id'].'&titre=' .$_GET['titre']; ?>">Evaluer le projet</a>
            <?php
          }else {
            echo 'Le projet a été évalué';
            $eval = getEvaluationById($idEvaluation['idevaluation']);
            //Export csv
            $data = array(
              'lib_groupe' => 'Groupe',
              'lib_noteCDC' => 'Note cahier des charges',
              'lib_noteSoutenance' => 'Note soutenance',
              'lib_noteRendu' => 'Note rendu',
              'lib_noteFinale' => 'Note finale',
              'noteCDC' => $eval['notecdc'],
              'noteSoutenance' => $eval['notesoutenance'],
              'noteRendu' => $eval['noterendu'],
              'noteFinale' => $eval['notefinale'],
              'idGroupe' => $idGroup['idgroupe']
            );
            export_csv($data);
            ?>
              <br><br>
              <a href="<?php echo "./documents/export_notes_groupe_".$idGroup['idgroupe'].".csv"?>">Exporter CSV</a>
            <?php
          }
        }
        ?>
