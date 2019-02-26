<?php
/**
* Pages permettant de visualiser les attributions de projet
**/
?>


<?php
//Si la personne souhaite se positionner sur un projet
  if(isset($_POST['btn_choix'])) {
    //selectionner le chef de projet
    $idChefG = getIdChefByIdGroup($_POST['id']);
 
    insertNewGroupe($_POST['id'], $_GET['id'], $idChefG['idpersonneChef']);
    deleteChoixTempFROMGroupeId($_POST['id']);
    deleteChoixTempFromProjectId($_GET['id']);
    deleteGroupTempFromGroupId($_POST['id']);

     //On affecte à chaque personne du groupe l'identifiant du groupe auquel elles appartiennent
     $etu = getPersonneByGroupTemp($_POST['id']);
     foreach($etu as $e) {
      updatePersonneGroupe($_POST['id'], $e['idPersonne']);
    }

  }
 ?>

<h1>Mes projets</h1>

<?php
 $idCustomer = getIdPeople( $_SESSION['name']  ,  $_SESSION['firstname']);

 // On récupère les projets a affecter manuellement
$manuel = getManualProjects($idCustomer[0]) ;
?>

<table>
    <tr>
      <th>Nom</th>
      <th>Description</th>
      <th>Actions</th>
    </tr>
<?php
if (!empty($manuel)) {
  
        foreach($manuel as $project) {
          ?>
          <tr>
            <td><?php echo $project['nomprojet']; ?></td>
            <td><?php echo $project['descriptiftexte']; ?></td>
            <?php
            // Si le projet n'est pas attribué
            $projetAttribuer = getprojetAttribuer($project['idprojet']);
            if (empty($projetAttribuer)){
            ?>
              <td><a href="<?php echo URL.'choix_groupe.php&id='.$project['idprojet']. '&titre=' .$project['nomprojet'];?>"> Vous devez attribuer ce projet</a></td>
            <?php
            // Si le projet est attribué
            }
            else {
              ?>
               <td><a href="<?php echo URL.'voir_mon_projet_client.php&id='.$project['idprojet']. '&titre=' .$project['nomprojet'];?>"> Voir le projet</a></td>
            <?php
            }
            ?>

          </tr>
          <?php
        }
  } 


// On récupère les projets a affecter automatiquement
$automatic = getAutomaticProjects($idCustomer[0]) ;

if (!empty($automatic)) {

          //On récupère la liste des projets
          //$projects = getProjects();
  
          foreach($automatic as $project) {
            ?>
            <tr>
              <td><?php echo $project['nomprojet']; ?></td>
              <td><?php echo $project['descriptiftexte']; ?></td>



              <?php
            // Si le projet n'est pas attribué 
            $projetAttribuer = getprojetAttribuer($project['idprojet']);
            if (empty($projetAttribuer)){
            ?>
              <td><p> En attente d'attribution </p></td>
            <?php
            // Si le projet est attribué
            }
            else {
              ?>
              <td><p> Le projet est attribué </p></td>
            <?php
            }
            ?>

            </tr>
            <?php
          }
        ?>
    </table>
  
    <?php    
    } 

?>



