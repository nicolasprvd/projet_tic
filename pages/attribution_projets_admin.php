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
    <p> Liste des projets qui n'ont pas encore été attribué manuellement par le client : </p>
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

  <p> Pour pouvoir lancer l'attribution automatique il faut que les projets ci-dessus soient attribués par leur client </p>
  <p> Mettre le bouton automatique en grisé </p>

<?php
}
else {
    echo "Tous les projets manuel sont attribué";
    echo "Mettre le bouton attribution automatique";
}
//Liste des projets qui n'ont pas encore été attribuer manuellement 


//Si attribution de tous = oui alors Bouton lancer l'attribution automatique

//Sinon bouton grise ac il faut que blabla 

//une fois le truc lancer (si il y a plus de ligne dans choix-temps) bouton grisé + import en csv
?>
