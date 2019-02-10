<?php
/**
* Pages permettant de visualiser les attributions de projet
**/
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
?>
  

      <?php
        //On récupère la liste des projets
        //$projects = getProjects();

        foreach($manuel as $project) {
          ?>
          <tr>
            <td><?php echo $project['nomprojet']; ?></td>
            <td><?php echo $project['descriptiftexte']; ?></td>
            <td><a href="<?php echo URL.'choix_groupe.php&id='.$project['idprojet'];?>"> Vous devez attribuer ce projet</a></td>
          </tr>
          <?php
        }
  } 


// On récupère les projets a affecter automatiquement
$automatic = getAutomaticProjects($idCustomer[0]) ;

if (!empty($automatic)) {
  ?>
        <?php
          //On récupère la liste des projets
          //$projects = getProjects();
  
          foreach($automatic as $project) {
            ?>
            <tr>
              <td><?php echo $project['nomprojet']; ?></td>
              <td><?php echo $project['descriptiftexte']; ?></td>
              <td><a href="<?php echo URL.'choix_groupe.php&id='.$project['idprojet'];?>"> Projet pas encore attribuer</a></td>
            </tr>
            <?php
          }
        ?>
    </table>
  
    <?php    
    } 

?>



