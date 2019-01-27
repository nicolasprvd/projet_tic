<?php
/**
* Formulaire permettant
* d'ajouter un nouveau projet
**/
?>
<form action = "index.php?page=form_ajout_projet.php" method = "POST">

        
        <h1>Saisir un projet</h1>
        


		</BR></BR>

		Client : $_SESSION['name']    $_SESSION['firstname']  a faire quand variable session ok</BR></BR>
		Titre  : <input type = "texte" name = "title"/></BR></BR>

        Nombre d'étudiant :
        
        <?php
            echo '<select nbStudent="liste" name="nbStudent">';
            for($i=2; $i<=10; $i++){
                echo '<option value="'.$i.'">'.$i.'</option>';
            }
            echo '</select>';
        ?>
        </BR></BR>

        Description : <input type = "texte" name = "description"/></BR></BR>
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

    //if(empty($_POST['customer']) || empty($_POST['title']) ) {
      //ajouterErreur('Vous devez renseigner tous les champs');
      //include_once('./include/erreurs.php');
    //}



    //Si les champs Client, Titre, et (description et/ou fichier joint) sont présent alors je peux inserer le nouveau projet dans la base
    if ( !empty($_POST['title'] ) AND ( !empty($_POST['description']) OR !empty($_POST['descriptionJoint'])) )
    {
        echo "Je vais pouvoir inserer ma requete ";
        echo "Attente des variables session pour activer le paragraphe ci-dessous qui inserera le projet";
       /* $idCustomer = getIdPeople( $_SESSION['name']  ,  $_SESSION['firstname']);

        //Passder l'id du customer (faire requete qui cherche ca)
        insertNewProject($idCustomer, $_POST['title'],  $_POST['title'], $_POST['description'], $_POST['descriptionJoint'], $_POST['automatique']);
        header("Location: index.php");*/
    }
    else 
    {
        echo "Il manque des info";
    }
}

?>
