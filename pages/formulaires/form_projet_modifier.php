<?php
/**
* Formulaire permettant
* de modifier un projet
**/
?>

<?php

  $project = getProjectById($_GET['id']);

  if(isset($_POST['btn_submit'])) {
    if(empty($_POST['input_project_name'] || empty($_POST['textarea_description']))) {
      ajouterErreur('Veuillez renseigner le nom et la description du projet');
      include_once('./include/erreurs.php');
    }else {
      if(!empty($_POST['descriptionJoint']) || $_FILES['descriptionJoint']['size'] != 0) {
        $target_path = "";
        $fichier = "";
        if($_FILES['descriptionJoint']['size'] <> 0) {
            $extensions = array('.doc', '.docs', '.pdf');
            $extension = strrchr($_FILES['descriptionJoint']['name'], '.');
            //Début des vérifications de sécurité...
            if(!in_array($extension, $extensions)) {
                ajouterErreur('Vous devez uploader un fichier de type doc, docs ou pdf, réessayez!');
                include_once('./include/erreurs.php');
                exit;
            }

            //Nous vérifions que le dossier d'enregistrement du fichier est bien présent
            if(file_exists("./documents")) {
                if (!file_exists("./documents/sujet_client")){
                    mkdir("./documents/sujet_client");
                }
            }else {
                mkdir("./documents");
                mkdir("./documents/sujet_client");
            }

            // Permet l'insertion du fichier joint dans le dossier concerner
            $target_path = "./documents/sujet_client/";
            $target_path = $target_path . basename($_FILES['descriptionJoint']['name']);
            $fichier = $_FILES['descriptionJoint']['name'];
            if(move_uploaded_file($_FILES['descriptionJoint']['tmp_name'], $target_path)) {
                echo "Fichier ajouté avec succès";
                echo "<br>" ;
            }else{
                ajouterErreur('Une erreur s est produite lors l enregistrement du fichier, réessayez!');
                include_once('./include/erreurs.php');
                exit();
            }
        }
      }else {
        $fichier = $project['descriptifPdf'];
      }

      updateDataProject($_POST['input_project_name'], $_POST['select_nbStudent'], $_POST['textarea_description'], $fichier, $_POST['automatique'], $_GET['id']);
      echo "Le projet a bien été modifié";
    }
  }
?>
<h1>Modification du projet : <br><?php echo $project['nomProjet']; ?></h1>

<form enctype="multipart/form-data" action="index.php?page=form_projet_modifier.php&id=1" method="POST">

  Client : <?php echo $project['prenomPersonne'] . ' ' . $project['nomPersonne'] ; ?>
  <br><br>
  Nom du projet : <input type="text" name="input_project_name" value="<?php echo $project['nomProjet']; ?>" placeholder="Nom du projet" />
  <br><br>
  Nombre d'étudiants : <select name="select_nbStudent">
    <option value="<?php echo $project['nbEtudiants']; ?>" selected><?php echo $project['nbEtudiants']; ?></option>
  <?php
    for($i=2; $i<=10; $i++) {
      if($i != $project['nbEtudiants']) {
        ?>
        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>';
        <?php
      }
    }
  ?>
  </select>
  <br><br>

  Description :
  <br>
  <textarea name="textarea_description" rows=4 cols=40><?php echo $project['descriptifTexte']; ?></textarea>
  <br><br>

  Fichier Joint : (Le fichier doit être nommé : nom du projet_nom du client_annee. L'extension doit être du doc, docs ou pdf.) <br>
  <?php
    if(!empty($project['descriptifPdf'])) {
      ?>
      <a href="./documents/sujet_client/<?php echo $project['descriptifPdf']; ?>">Télécharger</a>
  <?php } ?>

  <input type="file" title="<?php echo !(empty($project['descriptifPdf'])) ? $project['descriptifPdf'] : '' ?>" name="descriptionJoint" /><br>

  <p>Attribution automatique : </p>
  <div>
    <input type="radio" name="automatique" value="1" <?php echo $project['automatique'] == 1 ? 'checked' : '' ?>>
    <label for="oui">Oui</label>
  </div>

  <div>
    <input type="radio" name="automatique" value="0" <?php echo $project['automatique'] == 0 ? 'checked' : '' ?> >
    <label for="non">Non</label>
  </div>

  <br><br>

		<input type="button" value="Annuler" onclick="location.href='<?php echo URL.'infos_projets.php&id='.$_GET['id']; ?>'" />

		<input type="submit" value="Enregistrer" name="btn_submit"/>
</form>