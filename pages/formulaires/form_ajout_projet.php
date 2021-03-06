<?php
/**
* Page permettant d'ajouter un projet
**/

//Si le formulaire a été envoyé
if(isset($_POST['btn_submit'])) {

    //Si les champs Client, Titre, et (description et/ou fichier joint) sont présents alors insère le nouveau projet dans la base
    if(!empty($_POST['title']) AND (!empty($_POST['description']) OR $_FILES['descriptionJoint']['size'] <> 0)) {
        $target_path = "";
        $fichier = "";
        if($_FILES['descriptionJoint']['size'] <> 0) {
            $extensions = array('.doc', '.docx', '.pdf', '.DOC', '.DOCX', '.PDF');
            $extension = strrchr($_FILES['descriptionJoint']['name'], '.');
            // Si l'extension n'est pas dans le tableau
            if (!in_array($extension, $extensions)) {
                ajouterErreur('Vous devez uploader un fichier de type doc, docx ou pdf, réessayez!');
                include_once('./include/erreurs.php');
                exit;
            }

            //Nous vérifions que le dossier d'enregistrement du fichier est bien présent
            if(file_exists("./documents")) {
                if(!file_exists("./documents/sujet_client")) {
                    mkdir("./documents/sujet_client");
                }
            }else {
                mkdir("./documents");
                mkdir("./documents/sujet_client");
            }

            // Permet l'insertion du fichier joint dans le dossier concerné
            $target_path = "./documents/sujet_client/";
            $target_path = $target_path . basename($_FILES['descriptionJoint']['name']);
            $fichier = $_FILES['descriptionJoint']['name'];
            if(move_uploaded_file($_FILES['descriptionJoint']['tmp_name'], $target_path)) {
                ajouterMessage('Fichier ajouté avec succès');
            }else {
                ajouterErreur('Une erreur s est produite lors l enregistrement du fichier, réessayez!');
                include_once('./include/erreurs.php');
                exit();
            }
        }

        //On récupère l'identifiant du client
        $idCustomer = getIdPeople($_SESSION['name'], $_SESSION['firstname']);
        //Insertion du projet en base
        insertNewProject($idCustomer[0], $_POST['title'], $_POST['nbStudent'], $_POST['description'], $fichier, $_POST['automatique']);
        ajouterMessage('Le projet a bien été créé');
    }else {
        ajouterErreur('Vous devez renseigner tous les champs');
        include_once('./include/erreurs.php');
    }
}

//Affichage du message d'information
if(isset($_REQUEST['messages'])) {
  include('./include/messages.php');
}
?>

<form enctype="multipart/form-data" class="pas" id="form_ajout_projet"
      action="index.php?page=form_ajout_projet.php" method="POST">
    <div>

        <h1> Ajouter un projet </h1>

        <!-- Client -->
        <p class="mbxl">
            <span class="bold">Client : </span>
            <span><?php echo $_SESSION['firstname'] . ' ' . $_SESSION['name']; ?> </span>
        </p>

        <!-- Titre -->
        <p class="mbxl txtleft">
            <span class="bold">Titre : </span>
            <span><input type="text" name="title"/> </span>
        </p>

        <!-- Nombre d'étudiants -->
        <p class="mbxl">
            <span class="bold">Nombre d'étudiants : </span>
            <span><select name="nbStudent">

            <?php
            for ($i = 2; $i <= 10; $i++) {
                echo '<option value="' . $i . '">' . $i . '</option>';
            }
            ?>
                </select></span>
        </p>

        <!-- Description -->
        <p class="mbxl" id="description">
            <span class="bold">Description : <br></span>
            <span><textarea name="description" rows=3></textarea></span>
        </p>

        <!-- Fichier Joint -->
        <p class="mbxl">
            <span class="bold">Fichier Joint : </span>
            <span class="font-x-small mbs">(Le fichier doit être nommé : nom du projet_nom du client_annee.
                L'extension doit être au format .doc, .docx ou .pdf.) <br></span>
            <span><input type="file" name="descriptionJoint"/> </span>
        </p>

        <!-- Attribution automatique -->
        <p class="mbxl">
            <span class="bold">Attribution automatique : </span>
            <span>
                <input type="radio" id="oui" name="automatique" value="oui" checked>
                <label for="oui">Oui</label>
            </span>

            <span>
                <input type="radio" id="non" name="automatique" value="non">
                <label for="non">Non</label>
            </span>
        </p>

        <!-- Boutons -->
        <p class="txtright">
            <input type="button" class="input_custom" value="Annuler" class=mrm"
                   onclick="location.href='<?php echo URL.'form_ajout_projet.php'; ?>'"/>
            <input type="submit" class="input_custom" value="Soumettre" name="btn_submit"/>
        </p>
    </div>
</form>
