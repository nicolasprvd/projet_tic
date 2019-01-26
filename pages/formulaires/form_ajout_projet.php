<<<<<<< HEAD
<form action = "form_ajout_projet.php" method = "POST">

        <div class="titre">
            <h1>Saisir un projet</h1>
        </div>
            
=======

	 <form action="" method="post">
		<p> Saisir un projet </p>

>>>>>>> 4ed638a43d227d79ab8cd18a2aabc0aea3a29c7e
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
        Fichier Joint : <input type="file" name="descriptionjoint" /></BR>


		<input type="button" value="Annuler" onclick="location.href='form_ajout_projet.php'" />
<<<<<<< HEAD
		<input type = "submit" value = "Soumettre" name = "btn_submit"/>
		
=======
		<input type = "submit" value = "Soumettre"/>

>>>>>>> 4ed638a43d227d79ab8cd18a2aabc0aea3a29c7e
		</BR></BR>

<<<<<<< HEAD
		
</form>

<?php

if(isset($_POST['btn_submit'])) {
    //Si le formulaire a été envoyé

    //if(empty($_POST['customer']) || empty($_POST['title']) ) {
      //ajouterErreur('Vous devez renseigner tous les champs');
      //include_once('./include/erreurs.php');
    //}



    //Si les champs Client, Titre, et (description et/ou fichier joint) sont présent alors je peux inserer le nouveau projet dans la base
    if ( !empty($_POST['customer']) AND !empty($_POST['title'] )  ) 
    {
        echo "Je vais pouvoir inserer ma requete";
    }
}

?>
=======


	</form>
>>>>>>> 4ed638a43d227d79ab8cd18a2aabc0aea3a29c7e
