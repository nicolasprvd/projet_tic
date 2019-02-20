<?php
/**
* Pages permettant de visualiser les attributions de projet
**/
?>


<?php
//Si la personne souhaite se positionner sur un projet
  if(isset($_POST['btn_choix'])) {
    //selectionner le chef de p
    $idChefG = getIdChefByIdGroup($_POST['id']);
 
    insertNewGroupe($_POST['id'], $_GET['id'], $idChefG['idpersonneChef']);
    deleteChoixTempFROMGroupeId($_POST['id']);
    deleteGroupTempFromGroupId($_POST['id']);
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
              <td><p> Le projet est attribué </p></td>
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
              <td><p> Le projet n'a pas encore été attribué </p></td>
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



