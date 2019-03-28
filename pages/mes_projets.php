<?php
/**
 * Page qui liste les projets temporaires choisis
 * Une fois le projet attribué on y voit ses informations, les pieces a deposer etc
 **/

//Gestion d'erreur : soumission multiple du formulaire de constitution du groupe
if (isset($_SESSION['btn_clicked'])) {
    unset($_SESSION['btn_clicked']);
}

//On récupère l'identifiant de la personne connectée
$idPersonne = getIdPeople($_SESSION['name'], $_SESSION['firstname']);
//On récupère le groupe auquel elle appartient
$idGroup = getGroupeTempByPersonne($idPersonne[0]);

$attribuate = getProjectAttribuate($idGroup['idGroupeTemp']);

if(isset($_REQUEST['messages'])) {
  include('./include/messages.php');
}


if (empty($attribuate)) {
    //On récupère la liste de ses choix
    ?>
        <h1>Mes projets</h1>
    <?php
    $projects = getChoixProjets($idGroup['idGroupeTemp']);

    if ($projects == null) {
        echo '<p><strong>Vous n\'avez choisi aucun projet pour le moment.</p></strong>';
    } else {
        ?>
        <table id="mes_projets_client">
            <tr class="upper txtcenter">
                <th>Nom</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
            <?php
            foreach ($projects as $project) {
            ?>
            <tr class="font-x-small">
                <td><?php echo $project['nomProjet']; ?></td>
                <td><?php echo $project['descriptifTexte']; ?></td>
                <?php
                //Si c'est le responsable de projet
                if ($project['idPersonneChef'] == $idPersonne[0]) {
                    ?>
                    <td><a href="<?php echo URL . 'choix_projet.php&id=' . $project['idProjet']; ?>">> Se rétracter</a>
                    </td>
                    <?php
                } else {
                    ?>
                    <td><a href="<?php echo URL . 'infos_projets.php&id=' . $project['idProjet']; ?>">> Voir</a></td>
                    <?php
                }
              }
                ?>
            </tr>
        </table>
        <?php
    }
} else {
?>
<?php
$myProject = getProjectById($attribuate['idprojet']);
?>
<h1>Mon projet : <br>"<?php echo $myProject['nomProjet']; ?>"</h1>

<div id="mes_projets" class="txtleft">
    <?php $myProject['nomProjet']; ?>
    <!-- Client -->
    <p class="mbl">
        <span class="bold">Client : </span>
        <span><?php echo $myProject['prenomPersonne'] . ' ' . $myProject['nomPersonne']; ?> </span>
    </p>

    <!-- Mail client -->
    <p class="mbl">
        <span class="bold">Mail client : </span>
        <span><?php echo $myProject['mailPersonne']; ?> </span>
    </p>

    <!-- Nombre d'étudiants -->
    <p class="mbl">
        <span class="bold">Nombre d'étudiants : </span>
        <span><?php echo $myProject['nbEtudiants']; ?> </span>
    </p>

    <!-- Description -->
    <p class="mbxl">
        <span class="bold">Description : </span>
        <span><?php echo $myProject['descriptifTexte']; ?> </span>
    </p>

    <?php
    if ($myProject['descriptifPdf'] != null) {
        ?>
        <!-- Fichier joint -->
        <p class="mbl">
            <span class="bold">Fichier joint : </span>
            <span><a href="documents/sujet_client/<?php echo $myProject['descriptifPdf']; ?>"
                     target=\"_BLANK\">> Télécharger</a></span>
        </p>
        <?php
    }

    $idGroup = getIdgroupeByIdprojectFinal($myProject['idProjet']);

    //On recupere le nom et le prenom des personnes du groupe
    $etu = getPersonneByGroupTemp($idGroup['idgroupe']);
    $membre = '';
    $espace = " ";
    $separateur = ", ";

    foreach ($etu as $e) {
        $membre = $membre . $e['prenomPersonne'] . $espace . $e['nomPersonne'] . $separateur;
    }
    $membre = substr($membre, 0, -2);


    $idChef = getIdChefFinalByIdGroup($idGroup['idgroupe']);
    $chef = getInformationPeopleById($idChef['idpersonneChef']);
    ?>

    <br>

    <!-- Chef de projet -->
    <p class="mbl">
        <span class="bold">Chef de projet : </span>
        <span><?php echo $chef['prenompersonne'] . ' ' . $chef['nompersonne']; ?> </span>
    </p>
    <!-- Membres du projet -->
    <p class="mbxl">
        <span class="bold">Membres du projet : </span>
        <span><?php echo $membre; ?></span>
    </p>

    <br>

    <!--Depot/visualisation du cdc-->
    <?php
    $docSubmit = getDocSubmit($myProject['idProjet'], 'CDC');
    if (empty($docSubmit)) {
        ?>
        <p class="mbn">
            <span class="bold">Cahier des charges : </span>
        <form enctype="multipart/form-data" action="index.php?page=mes_projets.php" method="POST"
              class="font-x-small mbl">
            Dépôt du cahier des charges: (Le fichier doit être nommé : CDC_nomDesMembres_annee. L'extension doit être du
            doc, docx ou pdf.) </BR>
            <input type="file" name="CDC"/>
            <input type="submit" value="Déposer" name="btn_depot_CDC"/>
        </form>

        <?php
    } else {
        ?>
        <p class="mbl">
            <span class="bold">Cahier des charges : </span>
            <span>Le cahier des charges a été déposé :
                <a href="documents/cahier_des_charges/<?php echo $docSubmit['chemindoc']; ?>"
                   target=\"_BLANK\">> Télécharger</a>
            </span>
        </p>
        <?php
    }
    ?>

    <!--Depot/visualisation du gantt-->
    <?php
    $docSubmit = getDocSubmit($myProject['idProjet'], 'GANTT');
    if (empty($docSubmit)) {
        ?>
        <p class="mbn">
            <span class="bold">Gantt : </span>
        <form enctype="multipart/form-data" action="index.php?page=mes_projets.php" method="POST"
              class="font-x-small mbl">
            Dépôt du gantt: (Le fichier doit être nommé : Gant_nomDesMembres_annee. L'extension doit être du gan, jpg,
            png ou pdf.) </BR>
            <input type="file" name="GANTT"/>
            <input type="submit" value="Déposer" name="btn_depot_GANTT"/>
        </form>

        <?php
    } else {
        ?>
        <p class="mbl">
            <span class="bold">Gantt : </span>
            <span>Le gantt a été déposé :
            <a href="documents/gantt/<?php echo $docSubmit['chemindoc']; ?>" target=\"_BLANK\">> Télécharger</a>
                </span>
        </p>
        <?php
    }
    ?>

    <!--Depot/visualisation du rendu-->
    <?php
    $docSubmit = getDocSubmit($myProject['idProjet'], 'RF');
    if (empty($docSubmit)) {
        ?>
        <p class="mbn">
            <span class="bold">Rendu final : </span>
        <form enctype="multipart/form-data" action="index.php?page=mes_projets.php" method="POST"
              class="font-x-small mbxl">
            Dépôt du rendu final: (Le fichier doit être nommé : RF_nomDesMembres_annee. L'extension doit être du zip,
            7zip ou rar.)
            <input type="file" name="RF"/>
            <input type="submit" value="Déposer" name="btn_depot_RF"/>
        </form>

        <?php
    } else {
        ?>
        <p class="mbl">
            <span class="bold">Rendu final : </span>
            <span>Le rendu final a été déposé :
            <a href="documents/rendu_final/<?php echo $docSubmit['chemindoc']; ?>" target=\"_BLANK\">> Télécharger</a>
                </span>
        </p>
        <?php
    }
    }
    ?>

    <?php
    //traitement CDC
    if (isset($_POST['btn_depot_CDC'])) {

        $target_path = "";
        $fichier = "";

        //Si le fichier a été inseré
        if ($_FILES['CDC']['size'] <> 0) {


            $extensions = array('.doc', '.docx', '.pdf', '.DOC', '.DOCX', '.PDF');
            $extension = strrchr($_FILES['CDC']['name'], '.');
            //Début des vérifications de sécurité... (extension du fichier)
            if (!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
            {
                ajouterErreur('Vous devez uploader un fichier de type doc, docx ou pdf, réessayez!');
                include_once('./include/erreurs.php');
                exit;
            }

            //Nous vérifions que le dossier d'enregistrement du fichier est bien présent
            if (file_exists("./documents")) {
                if (!file_exists("./documents/cahier_des_charges")) {
                    mkdir("./documents/cahier_des_charges");
                }
            } else {
                mkdir("./documents");
                mkdir("./documents/cahier_des_charges");
            }

            // Permet l'insertion du fichier joint dans le dossier concerner
            $target_path = "./documents/cahier_des_charges/";
            $target_path = $target_path . basename($_FILES['CDC']['name']);
            $fichier = $_FILES['CDC']['name'];
            if (move_uploaded_file($_FILES['CDC']['tmp_name'], $target_path)) {
                ajouterMessage('Fichier ajouté avec succès');
            } else {
                ajouterErreur('Une erreur s est produite lors l enregistrement du fichier, réessayez!');
                include_once('./include/erreurs.php');
                exit();
            }


            // On insere le document dans la base
            insertNewDoc($myProject['idProjet'], $fichier, 'CDC');
            ajouterMessage('Le cahier des charges a bien été déposé');

            //Si le fichier n'a pas été inseré
        } else {
            ajouterErreur('Vous devez inserer votre pièce jointe!');
            include_once('./include/erreurs.php');
        }
    }


    //traitement GANTT
    if (isset($_POST['btn_depot_GANTT'])) {

        $target_path = "";
        $fichier = "";

        //Si le fichier a été inseré
        if ($_FILES['GANTT']['size'] <> 0) {


            $extensions = array('.gan', '.jpg', '.pnj', '.pdf', '.GAN', '.JPG', '.PNG', '.PDF');
            $extension = strrchr($_FILES['GANTT']['name'], '.');
            //Début des vérifications de sécurité... (extension du fichier)
            if (!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
            {
                ajouterErreur('Vous devez uploader un fichier de type gan, jpg, png ou pdf, réessayez!');
                include_once('./include/erreurs.php');
                exit;
            }

            //Nous vérifions que le dossier d'enregistrement du fichier est bien présent
            if (file_exists("./documents")) {
                if (!file_exists("./documents/gantt")) {
                    mkdir("./documents/gantt");
                }
            } else {
                mkdir("./documents");
                mkdir("./documents/gantt");
            }

            // Permet l'insertion du fichier joint dans le dossier concerner
            $target_path = "./documents/gantt/";
            $target_path = $target_path . basename($_FILES['GANTT']['name']);
            $fichier = $_FILES['GANTT']['name'];
            if (move_uploaded_file($_FILES['GANTT']['tmp_name'], $target_path)) {
                ajouterMessage('Fichier ajouté avec succès');
            } else {
                ajouterErreur('Une erreur s est produite lors l enregistrement du fichier, réessayez!');
                include_once('./include/erreurs.php');
                exit();
            }


            // On insere le document dans la base
            insertNewDoc($myProject['idProjet'], $fichier, 'GANTT');
            ajouterMessage('Le gantt a bien été déposé');

            //Si le fichier n'a pas été inseré
        } else {
            ajouterErreur('Vous devez inserer votre pièce jointe!');
            include_once('./include/erreurs.php');
        }
    }


    //traitement rendu final
    if (isset($_POST['btn_depot_RF'])) {

        $target_path = "";
        $fichier = "";

        //Si le fichier a été inseré
        if ($_FILES['RF']['size'] <> 0) {

            $extensions = array('.zip', '.7z', '.rar', '.ZIP', '.7Z', '.RAR');
            $extension = strrchr($_FILES['RF']['name'], '.');
            //Début des vérifications de sécurité... (extension du fichier)
            if (!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
            {
                ajouterErreur('Vous devez uploader un fichier de type zip, 7z ou rar, réessayez!');
                include_once('./include/erreurs.php');
                exit;
            }

            //Nous vérifions que le dossier d'enregistrement du fichier est bien présent
            if (file_exists("./documents")) {
                if (!file_exists("./documents/rendu_final")) {
                    mkdir("./documents/rendu_final");
                }
            } else {
                mkdir("./documents");
                mkdir("./documents/rendu_final");
            }

            // Permet l'insertion du fichier joint dans le dossier concerner
            $target_path = "./documents/rendu_final/";
            $target_path = $target_path . basename($_FILES['RF']['name']);
            $fichier = $_FILES['RF']['name'];
            if (move_uploaded_file($_FILES['RF']['tmp_name'], $target_path)) {
                ajouterMessage('Fichier ajouté avec succès');
            } else {
                ajouterErreur('Une erreur s est produite lors l enregistrement du fichier, réessayez!');
                include_once('./include/erreurs.php');
                exit();
            }

            // On insere le document dans la base
            insertNewDoc($myProject['idProjet'], $fichier, 'RF');
            ajouterMessage('Le rendu final a bien été déposé');

            //Si le fichier n'a pas été inseré
        } else {
            ajouterErreur('Vous devez inserer votre pièce jointe!');
            include_once('./include/erreurs.php');
        }
    }
    ?>
</div>
