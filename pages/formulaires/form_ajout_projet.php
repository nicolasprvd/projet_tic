<?php
/**
* Formulaire permettant
* d'ajouter un nouveau projet
**/
?>
<form action = "index.php?page=form_ajout_projet.php" method = "POST">

        
        <h1>Saisir un projet</h1>
        


		</BR></BR>

		Client : <?php echo $_SESSION['firstname'] . ' ' . $_SESSION['name'] ; ?></BR></BR>
		Titre  : <input type = "texte" name = "title"/></BR></BR>

        Nombre d'étudiant :
        <select name="nbStudent">
        
            <?php
            for($i=2; $i<=10; $i++){
                echo '<option value="'.$i.'">'.$i.'</option>';
            }
            ?>
        </select><br><br> </BR></BR>

        Description :</BR>
        <TEXTAREA name="description" rows=4 cols=40></TEXTAREA></BR></BR>

        Fichier Joint : <input type="file" name="descriptionJoint" /></BR>

        <p>Attribution automatique :</p>

        <div>
            <input type="radio" id="oui" name="automatique" value="oui" checked>
            <label for="oui">Oui</label>
        </div>

        <div>
            <input type="radio" id="non" name="automatique" value="non">
            <label for="non">Non</label>
        </div>

        </BR></BR>

		<input type="button" value="Annuler" onclick="location.href='index.php?page=form_ajout_projet.php'" />

		<input type = "submit" value = "Soumettre" name = "btn_submit"/>


</form>

<?php

if(isset($_POST['btn_submit'])) {
    //Si le formulaire a été envoyé

    //Si les champs Client, Titre, et (description et/ou fichier joint) sont présent alors je peux inserer le nouveau projet dans la base
    if ( !empty($_POST['title'] ) AND ( !empty($_POST['description']) OR !empty($_POST['descriptionJoint'])) )
    {
        //Permet de récupérer l'id du client
        $idCustomer = getIdPeople( $_SESSION['name']  ,  $_SESSION['firstname']);
        
        insertNewProject($idCustomer[0], $_POST['title'], $_POST['nbStudent'], $_POST['description'], $_POST['descriptionJoint'], $_POST['automatique']);
    }
    else 
    {
        ajouterErreur('Vous devez renseigner tous les champs');
        include_once('./include/erreurs.php');
    }
}

?>
