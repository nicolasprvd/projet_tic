<?php
/**
* Formulaire permettant
* d'ajouter un nouveau projet
**/
?>
<form enctype="multipart/form-data" action = "index.php?page=form_ajout_projet.php" method = "POST">


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
        </select><br><br>

        Description :</BR>
        <TEXTAREA name="description" rows=4 cols=40></TEXTAREA></BR></BR>

        Fichier Joint : (Le fichier doit être nommé : nom du projet_nom du client_annee. L'extension doit être du doc, docs ou pdf.) </BR>
        <input type="file" name="descriptionJoint" /></BR>

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

        </BR>

</form>

<?php

//Si le formulaire a été envoyé

if(isset($_POST['btn_submit'])) {

    //Si les champs Client, Titre, et (description et/ou fichier joint) sont présent alors je peux inserer le nouveau projet dans la base
    if ( !empty($_POST['title'] ) AND ( !empty($_POST['description']) OR $_FILES['descriptionJoint']['size'] <> 0) )
    {
        $target_path = "";
        $fichier = "";
        if ($_FILES['descriptionJoint']['size'] <> 0){

            
            $extensions = array('.doc', '.docs', '.pdf');
            $extension = strrchr($_FILES['descriptionJoint']['name'], '.'); 
            //Début des vérifications de sécurité...
            if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
            {
                ajouterErreur('Vous devez uploader un fichier de type doc, docs ou pdf, réessayez!');
                include_once('./include/erreurs.php');
                exit;
            }

            //Nous vérifions que le dossier d'enregistrement du fichier est bien présent
            if (file_exists("./documents")){
                if (!file_exists("./documents/sujet_client")){
                    mkdir("./documents/sujet_client");
                }
            }
            else {
                mkdir("./documents");
                mkdir("./documents/sujet_client");
            }

            // Permet l'insertion du fichier joint dans le dossier concerner
            $target_path = "./documents/sujet_client/";
            $target_path = $target_path . basename( $_FILES['descriptionJoint']['name']);
            $fichier = $_FILES['descriptionJoint']['name'];
            if(move_uploaded_file($_FILES['descriptionJoint']['tmp_name'], $target_path)) {
                echo "Fichier ajouté avec succès";
                echo "</BR>" ;
            } else{
                ajouterErreur('Une erreur s est produite lors l enregistrement du fichier, réessayez!');
                include_once('./include/erreurs.php');
                exit();
            }
        }

        //Permet de récupérer l'id du client
        $idCustomer = getIdPeople( $_SESSION['name']  ,  $_SESSION['firstname']);

        insertNewProject($idCustomer[0], $_POST['title'], $_POST['nbStudent'], $_POST['description'], $fichier, $_POST['automatique']);
        echo "Le projet a bien été créé";
    }
    else
    {
        ajouterErreur('Vous devez renseigner tous les champs');
        include_once('./include/erreurs.php');
    }
}

?>
