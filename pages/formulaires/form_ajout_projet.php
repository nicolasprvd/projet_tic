<form enctype="multipart/form-data" class="pas font-xx-small" id="form-ajout"
      action="index.php?page=form_ajout_projet.php" method="POST">
    <div>
        <!-- Client -->
        <p class="mbxl" id="client">
            <span class="bold"> Client : </span>
            <span><?php echo $_SESSION['firstname'] . ' ' . $_SESSION['name']; ?> </span>
        </p>

        <!-- Titre -->
        <p class="mbxl" id="titre">
            <span class="bold">Titre : </span>
            <span><input type="texte" name="title"/> </span>
        </p>

        <!-- Nombre d'étudiants -->
        <p class="mbxl" id="nb-etudiants">
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
            <span><TEXTAREA name="description" rows=3></TEXTAREA></span>
        </p>

        <!-- Fichier Joint -->
        <p class="mbxl">
            <span class="bold">Fichier Joint : </span>
            <span class="font-x-small mbs">(Le fichier doit être nommé : nom du projet_nom du client_annee.
                L'extension doit être au format .doc, .docs ou .pdf.) <br></span>
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
        <p id="boutons">
            <input type="button" value="Annuler" class=mrm" onclick="location.href='index.php?page=form_ajout_projet.php'"/>
            <input type="submit" value="Soumettre" name="btn_submit"/>
        </p>
    </div>
</form>

<?php

//Si le formulaire a été envoyé

if (isset($_POST['btn_submit'])) {

    //Si les champs Client, Titre, et (description et/ou fichier joint) sont présent alors je peux inserer le nouveau projet dans la base
    if (!empty($_POST['title']) AND (!empty($_POST['description']) OR $_FILES['descriptionJoint']['size'] <> 0)) {
        $target_path = "";
        $fichier = "";
        if ($_FILES['descriptionJoint']['size'] <> 0) {


            $extensions = array('.doc', '.docs', '.pdf');
            $extension = strrchr($_FILES['descriptionJoint']['name'], '.');
            //Début des vérifications de sécurité...
            if (!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
            {
                ajouterErreur('Vous devez uploader un fichier de type doc, docs ou pdf, réessayez!');
                include_once('./include/erreurs.php');
                exit;
            }

            //Nous vérifions que le dossier d'enregistrement du fichier est bien présent
            if (file_exists("./documents")) {
                if (!file_exists("./documents/sujet_client")) {
                    mkdir("./documents/sujet_client");
                }
            } else {
                mkdir("./documents");
                mkdir("./documents/sujet_client");
            }

            // Permet l'insertion du fichier joint dans le dossier concerner
            $target_path = "./documents/sujet_client/";
            $target_path = $target_path . basename($_FILES['descriptionJoint']['name']);
            $fichier = $_FILES['descriptionJoint']['name'];
            if (move_uploaded_file($_FILES['descriptionJoint']['tmp_name'], $target_path)) {
                echo "Fichier ajouté avec succès";
                echo "<br>";
            } else {
                ajouterErreur('Une erreur s est produite lors l enregistrement du fichier, réessayez!');
                include_once('./include/erreurs.php');
                exit();
            }
        }

        //Permet de récupérer l'id du client
        $idCustomer = getIdPeople($_SESSION['name'], $_SESSION['firstname']);

        insertNewProject($idCustomer[0], $_POST['title'], $_POST['nbStudent'], $_POST['description'], $fichier, $_POST['automatique']);
        echo "Le projet a bien été créé";
    } else {
        ajouterErreur('Vous devez renseigner tous les champs');
        include_once('./include/erreurs.php');
    }
}

?>
