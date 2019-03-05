<?php
/**
* Pages permettant lancer l'attribution automatique des projets et de recuperer le csv des projets attribuer aux groupes 
**/
?>

<h2> Attribution des projets </h2>

<?php

$projetNoAttribuate = getManualProjectsNoAttribuate();

if (!empty($projetNoAttribuate)){
?>
    <p> Liste des projets qui n'ont pas encore été attribués manuellement par le client : </p>
    <table>
    <tr>
      <th>Nom</th>
      <th>Description</th>
      <th>Actions</th>
    </tr>
  
      <?php
  
        foreach($projetNoAttribuate as $project) {
          ?>
          <tr>
            <td><?php echo $project['nomprojet']; ?></td>
            <td><?php echo $project['descriptiftexte']; ?></td>
            <td><a href="<?php echo URL.'infos_projets.php&id='.$project['idprojet'];?>">Voir</a></td>
          </tr>
          <?php
        }
       ?>
  </table>

  </BR></BR>

  
  <input disabled type = "submit" value = "Attribution Automatique"/>
  <p> Pour pouvoir lancer l'attribution automatique il faut que les projets ci-dessus soient attribués par leurs clients </p>

<?php
}
else {

  if (empty(getchoixTempIsEmpty())){
    echo "Il n'y a plus de projets en attente d'attribution";
    ?>
    <form enctype="multipart/form-data" action = "index.php?page=attribution_projets_admin.php" method = "POST">
    <input type = "submit" value = "Generer le csv" name = "btn_csv"/>
    </form>
    <?php
  }
  else {
  ?>
   <form enctype="multipart/form-data" action = "index.php?page=attribution_projets_admin.php" method = "POST">
  <input type = "submit" value = "Attribution Automatique" name = "btn_attribution"/>
  </form>
  <?php
  }
}

?>

<?php
if(isset($_POST['btn_attribution'])) {
  echo 'je vais commencer à faire l attribution';
  $projet = getAutomaticalProjects();
   $estTraitee = false;

  //Tant que l'on peut attribué les projets facilement (1 seule demande sur un projet)
   while(!$estTraitee){
    $estTraitee = true;
    
    //Taitement de chaque projet
    foreach($projet as $projets){

      $nbDemande = getNbDemande($projets['idprojet']);
     
      // Si le projet a été demandé qu'une seule fois
      if ( $nbDemande['nbFoisDemande'] == 1){

        //On récupère l'idGroupe qui a demander ce projet
        $idGroup = getIdgByIdproject($projets['idprojet']);

        //On récupère le chef de projet
        //selectionner le chef de projet
        $idChefG = getIdChefByIdGroup($idGroup['idgroupe']);
        
        insertNewGroupe($idGroup['idgroupe'], $projets['idprojet'], $idChefG['idpersonneChef']);
        deleteChoixTempFROMGroupeId($idGroup['idgroupe']);
        deleteChoixTempFromProjectId($projets['idprojet']);
        deleteGroupTempFromGroupId($idGroup['idgroupe']);

        //On affecte à chaque personne du groupe l'identifiant du groupe auquel elles appartiennent
        $etu = getPersonneByGroupTemp($idGroup['idgroupe']);
        foreach($etu as $e) {
          updatePersonneGroupe($idGroup['idgroupe'], $e['idPersonne']);
        }
        $estTraitee = false;
      }      
    }
   }
} 


if(isset($_POST['btn_csv'])) {

  //Récupère la liste des projets
  $projects = getProjectsAttribuate();

  foreach ($projects as $project) {

    $idGroup = getIdgroupeByIdprojectFinal($project['idprojet']);
    // Selectionner le chef de projet
    $idChef = getIdChefFinalByIdGroup($idGroup['idgroupe']);
    $chef = getInformationPeopleById($idChef['idpersonneChef']);
    $client =  $project['prenompersonne'] . ' ' .  $project['nompersonne'];
    $lechef = $chef['prenompersonne'] . ' ' .  $chef['nompersonne'];

     //On recupere le nom et le prenom des personnes du groupe 
  $etu = getPersonneByGroupTemp($idGroup['idgroupe']);
  $membre ='';
  $espace = " ";
  $separateur = ", ";
  
  foreach($etu as $e) {
    $membre = $membre . $e['prenomPersonne'] . $espace .$e['nomPersonne']  . $separateur ;
  }
  $membre = substr($membre, 0, -2);
  
    $export[] = array($project['nomprojet'], $client, $lechef, $membre);
    }


        // Nom du fichier et delimiteur entre chaque entrées
        $chemin = './documents/attribution.csv';
        $delimiteur = ';'; // Pour une tabulation, $delimiteur = "t";
     
        // Création du fichier csv
        // fopen : Ouvre un fichier
        /*
            w+ : Ouvre en lecture et écriture ;
            Place le pointeur de fichier au début du fichier et réduit la taille du fichier à 0.
            Si le fichier n'existe pas, on tente de le créer.
        */
        $fichier_csv = fopen($chemin, 'w+');
     
        /*
            Si votre fichier a vocation a être importé dans Excel,
            vous devez impérativement utiliser la ligne ci-dessous pour corriger
            les problèmes d'affichage des caractères internationaux (les accents par exemple)
        */
        fprintf($fichier_csv, chr(0xEF).chr(0xBB).chr(0xBF));
     
        // On affiche une fois l'entête sans boucle
        $entetes = array('Nom projet', 'Client', 'Chef de projet', 'Membres du groupes');
        fputcsv($fichier_csv, $entetes, $delimiteur);
        //print_r($entetes);
     
        // Boucle foreach sur chaque ligne du tableau
        // Boucle pour se déplacer dans les tableaux
        foreach($export as $ligneaexporter){
            // chaque ligne en cours de lecture est insérée dans le fichier
            // les valeurs présentes dans chaque ligne seront séparées par $delimiteur
            fputcsv($fichier_csv, $ligneaexporter, $delimiteur);
            //print_r($ligneaexporter);
        }
     
        // fermeture du fichier csv
        fclose($fichier_csv);
        echo "Le fichier a bien été enregistré dans le dossier 'documents'";
     ?>
     
     <?php
}
?> 

