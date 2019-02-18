<?php
/**
* Page qui liste les projets temporaires choisis pour le projet donner 
**/
?>

<h2> Choix d'un groupe pour votre projet "<?php echo $_GET['titre'] ?>"</h2>

<p> Vous devez choisir un groupe pour votre projet </p>

<?php
//Afficher le  titre du projet

$idgroupe = getIdgroupeByIdproject($_GET['id']);

if (!empty($idgroupe)) {
    ?>
<form method="post">
<?php
    ?>

    <table>
        <tr>
        <th>idGroupe</th>
        <th> Membre du groupe </th>
        <th>Choix</th>
        </tr>
    <?php

    
    foreach($idgroupe as $groupe) {
     ?>
          <tr>
            <td><?php echo $groupe['idgroupe']; ?></td>

            <?php

            //On recupere le nom et le prenom des personnes du groupe 
            $etu = getPersonneByGroupTemp($groupe['idgroupe']);
            $membre ='';
            $espace = " ";
            $separateur = ", ";

            foreach($etu as $e) {
            $membre = $membre . $e['prenompersonne'] . $espace .$e['nompersonne']  . $separateur ;
            }

            ?>

            <td><?php echo $membre; ?></td>

            <td><input type = "submit" value = "Choisir ce groupe" name = "btn_choix"/></td>

            </tr>
    <?php 
    }
    ?>

 <form method="post">
 <?php
}
else {
    echo "Personne n'a choisis votre sujet pour le moment.. Revenez plus tard!";
}  
?>  

<?php
//Si la personne souhaite se positionner sur un projet
  if(isset($_POST['btn_choix'])) {
    echo "Je veux ce groupe!";
  }
 ?>