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
  $membre = $membre . $e['prenompersonne'] . $espace .$e['nompersonne']  . $separateur ;
  }
  $membre = substr($membre, 0, -2);


  $idChef = getIdChefFinalByIdGroup($idGroup['idgroupe']);
  $chef = getInformationPeopleById($idChef['idpersonneChef']);
    ?>
    <br>
    Chef de projet : <?php echo $chef['prenompersonne'] . ' ' .  $chef['nompersonne'];?> <br>
    Membres du projet : <?php echo $membre ;?> <br><br>

    <h4>Cahier des charges : </h4>
    <?php
    $docSubmit = getDocSubmit($myProject['idProjet'], 'CDC');
      if (empty($docSubmit)) {
        echo "Le cahier des charges n'a pas encore été déposé"; 
      }else{
        echo 'Le cahier des charges a été déposé :' ?> <a href="documents/cahier_des_charges/<?php echo $docSubmit['chemindoc']; ?>" target=\"_BLANK\">Télécharger</a>
        <?php 
      }