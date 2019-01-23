<?php

    require('../../include/fonctions.php');

    $connex = connexionBD();

    session_start();

    // Si les champs Client, Titre, et (description et/ou fichier joint) sont présent alors je peux inserer le nouveau projet dans la base
    if ( !empty($_POST['customer']) AND !empty($_POST['title'] ) ) 
    {
            echo "Je vais pouvoir inserer ma requete";
    }

 ?>

<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8" />
	<p> Mettre ici le header  </p>
	
</head>
<body>




	 <form action = "form_ajout_projet.php" method = "POST">
		<p> Saisir un projet </p>
		
		</BR></BR>
		
		Client : <input type = "texte" name = "customer"/></BR>
		Titre  : <input type = "texte" name = "title"/></BR>
       
        Nombre d'étudiant : 
        <?php
            echo '<select nbStudent="liste">';
            for($i=2; $i<=10; $i++){
                echo '<option value="'.$i.'">'.$i.'</option>';
            }
            echo '</select>';
        ?>
        </BR>

        Description : <input type = "texte" name = "description"/></BR>
        Fichier Joint </BR>

	
		<input type="button" value="Annuler" onclick="location.href='form_ajout_projet.php'" />
		<input type = "submit" value = "Soumettre"/>
		
		</BR></BR>
		

		
	</form>
</body>
</html>