<!-- Pages permettant lancer l'attribution automatique des projets et de recuperer le csv des projets attribuer aux groupes -->

<?php
if (isset($_POST['btn_attribution'])) {

    $sortir = false;
    while (!$sortir) {
        $sortir = true;


        $estTraitee = false;

        //Tant que l'on peut attribué les projets facilement (1 seule demande sur un projet)
        while (!$estTraitee) {
            $estTraitee = true;
            $projet = getAutomaticalProjects();

            //Taitement de chaque projet
            foreach ($projet as $projets) {

                $nbDemande = getNbDemande($projets['idprojet']);

                // Si le projet a été demandé qu'une seule fois
                if ($nbDemande['nbFoisDemande'] == 1) {
                    $sortir = false;

                    //On récupère le chef de projet
                    //selectionner le chef de projet
                    $idChefG = getIdChefByIdGroup($projets['idgroupe']);

                    insertNewGroupe($projets['idgroupe'], $projets['idprojet'], $idChefG['idpersonneChef']);
                    deleteChoixTempFROMGroupeId($projets['idgroupe']);
                    deleteChoixTempFromProjectId($projets['idprojet']);
                    deleteGroupTempFromGroupId($projets['idgroupe']);

                    //On affecte à chaque personne du groupe l'identifiant du groupe auquel elles appartiennent
                    $etu = getPersonneByGroupTemp($projets['idgroupe']);
                    foreach ($etu as $e) {
                        updatePersonneGroupe($projets['idgroupe'], $e['idPersonne']);
                    }
                    $estTraitee = false;
                }
            }
        }


        $estTraitee = false;

        //Tant que l'on peut attribué les projets facilement (1 seule demande sur un projet)
        while (!$estTraitee) {
            $estTraitee = true;
            $projet = getAutomaticalProjects();

            //Taitement de chaque projet
            foreach ($projet as $projets) {

                $nbDemande = getNbDemandeStudent($projets['idgroupe']);
                // Si le projet a été demandé qu'une seule fois
                if ($nbDemande['nbFoisDemande'] == 1) {
                    $sortir = false;

                    //On récupère l'idGroupe qui a demander ce projet
                    // $idGroup = getIdgByIdproject($projets['idprojet']);


                    //On récupère le chef de projet
                    //selectionner le chef de projet
                    $idChefG = getIdChefByIdGroup($projets['idgroupe']);

                    insertNewGroupe($projets['idgroupe'], $projets['idprojet'], $idChefG['idpersonneChef']);
                    deleteChoixTempFROMGroupeId($projets['idgroupe']);
                    deleteChoixTempFromProjectId($projets['idprojet']);
                    deleteGroupTempFromGroupId($projets['idgroupe']);

                    //On affecte à chaque personne du groupe l'identifiant du groupe auquel elles appartiennent
                    $etu = getPersonneByGroupTemp($projets['idgroupe']);
                    foreach ($etu as $e) {
                        updatePersonneGroupe($projets['idgroupe'], $e['idPersonne']);
                    }

                    $estTraitee = false;
                }
            }
        }
    }


    //Tant qu'il y a toujours des projets dans choix_projet
    $projet = getAutomaticalProjects();
    while (!empty($projet)) {
        //On attribut la premiere ligne recuperer puis on reprend le traitement "facile"
        $projectAAttribuates = getAutomaticalProject();

        foreach ($projectAAttribuates as $projectAAttribuate) {

            //On récupère l'idGroupe qui a demander ce projet
            $idGroup = getIdgByIdproject($projectAAttribuate['idprojet']);

            //On récupère le chef de projet
            //selectionner le chef de projet
            $idChefG = getIdChefByIdGroup($idGroup['idgroupe']);

            insertNewGroupe($idGroup['idgroupe'], $projectAAttribuate['idprojet'], $idChefG['idpersonneChef']);
            deleteChoixTempFROMGroupeId($idGroup['idgroupe']);
            deleteChoixTempFromProjectId($projectAAttribuate['idprojet']);
            deleteGroupTempFromGroupId($idGroup['idgroupe']);

            //On affecte à chaque personne du groupe l'identifiant du groupe auquel elles appartiennent
            $etu = getPersonneByGroupTemp($idGroup['idgroupe']);
            foreach ($etu as $e) {
                updatePersonneGroupe($idGroup['idgroupe'], $e['idPersonne']);
            }
        }

        // On récupère choix_projets et on traiter avec le traitement "facile"
        $sortir = false;
        while (!$sortir) {
            $sortir = true;

            $projet = getAutomaticalProjects();
            $estTraitee = false;

            //Tant que l'on peut attribué les projets facilement (1 seule demande sur un projet)
            while (!$estTraitee) {
                $estTraitee = true;
                $projet = getAutomaticalProjects();

                //Taitement de chaque projet
                foreach ($projet as $projets) {

                    $nbDemande = getNbDemande($projets['idprojet']);

                    // Si le projet a été demandé qu'une seule fois
                    if ($nbDemande['nbFoisDemande'] == 1) {
                        $sortir = false;

                        //On récupère le chef de projet
                        //selectionner le chef de projet
                        $idChefG = getIdChefByIdGroup($projets['idgroupe']);

                        insertNewGroupe($projets['idgroupe'], $projets['idprojet'], $idChefG['idpersonneChef']);
                        deleteChoixTempFROMGroupeId($projets['idgroupe']);
                        deleteChoixTempFromProjectId($projets['idprojet']);
                        deleteGroupTempFromGroupId($projets['idgroupe']);

                        //On affecte à chaque personne du groupe l'identifiant du groupe auquel elles appartiennent
                        $etu = getPersonneByGroupTemp($projets['idgroupe']);
                        foreach ($etu as $e) {
                            updatePersonneGroupe($projets['idgroupe'], $e['idPersonne']);
                        }
                        $estTraitee = false;
                    }
                }
            }

            $projet = getAutomaticalProjects();

            $estTraitee = false;

            //Tant que l'on peut attribué les projets facilement (1 seule demande sur un projet)
            //Tant que l'on peut attribué les projets facilement (1 seule demande sur un projet)
            while (!$estTraitee) {
                $estTraitee = true;
                $projet = getAutomaticalProjects();

                //Taitement de chaque projet
                foreach ($projet as $projets) {

                    $nbDemande = getNbDemandeStudent($projets['idgroupe']);
                    // Si le projet a été demandé qu'une seule fois
                    if ($nbDemande['nbFoisDemande'] == 1) {
                        $sortir = false;

                        //On récupère l'idGroupe qui a demander ce projet
                        // $idGroup = getIdgByIdproject($projets['idprojet']);


                        //On récupère le chef de projet
                        //selectionner le chef de projet
                        $idChefG = getIdChefByIdGroup($projets['idgroupe']);
                        echo 'Groupe' . $projets['idgroupe'] . 'Projet' . $projets['idprojet'] . 'Chef de projet' . $idChefG['idpersonneChef'];

                        insertNewGroupe($projets['idgroupe'], $projets['idprojet'], $idChefG['idpersonneChef']);
                        deleteChoixTempFROMGroupeId($projets['idgroupe']);
                        deleteChoixTempFromProjectId($projets['idprojet']);
                        deleteGroupTempFromGroupId($projets['idgroupe']);

                        //On affecte à chaque personne du groupe l'identifiant du groupe auquel elles appartiennent
                        $etu = getPersonneByGroupTemp($projets['idgroupe']);
                        foreach ($etu as $e) {
                            updatePersonneGroupe($projets['idgroupe'], $e['idPersonne']);
                        }

                        $estTraitee = false;
                    }
                }
            }
        }
        $projet = getAutomaticalProjects();
    }
}
?>

<?php
$attrib = false;
$projetNoAttribuate = getManualProjectsNoAttribuate();

if (!empty($projetNoAttribuate)) {
    ?>
    <p> Liste des projets qui n'ont pas encore été attribués manuellement par le client : </p>
    <table>
        <tr class="upper txtcenter">
            <th>Nom</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>

        <?php

        foreach ($projetNoAttribuate as $project) {
            ?>
            <tr class="font-x-small">
                <td><?php echo $project['nomprojet']; ?></td>
                <td><?php echo $project['descriptiftexte']; ?></td>
                <td><a href="<?php echo URL . 'infos_projets.php&id=' . $project['idprojet']; ?>">> Voir</a></td>
            </tr>
            <?php
        }
        ?>
    </table>

    <p class="mtm mbxl" id="attribution_projet_admin_form">
        <input disabled type="submit" class="input_custom" value="Attribution Automatique"/>
    </p>

    <p> Pour pouvoir lancer l'attribution automatique il faut que les projets ci-dessus soient attribués par leurs
        clients </p>

    <?php
} else {

    if (empty(getchoixTempIsEmpty())) {
        echo "<strong>Il n'y a plus de projets en attente d'attribution.</strong>";
        $attrib = true;
    } else {
        ?>
        <form enctype="multipart/form-data" action="index.php?page=attribution_projets_admin.php" method="POST" id="attribution_projet_admin_form">
            <input type="submit" class="input_custom" value="Attribution Automatique" name="btn_attribution"/>
        </form>
        <?php
    }
}

?>


<?php
if ($attrib) {
    //Récupère la liste des projets
    $projects = getProjectsAttribuate();

    if(!empty($projects)) {
      foreach ($projects as $project) {

          $idGroup = getIdgroupeByIdprojectFinal($project['idprojet']);
          // Selectionner le chef de projet
          $idChef = getIdChefFinalByIdGroup($idGroup['idgroupe']);
          $chef = getInformationPeopleById($idChef['idpersonneChef']);
          $client = $project['prenompersonne'] . ' ' . $project['nompersonne'];
          $lechef = $chef['prenompersonne'] . ' ' . $chef['nompersonne'];

          //On recupere le nom et le prenom des personnes du groupe
          $etu = getPersonneByGroupTemp($idGroup['idgroupe']);
          $membre = '';
          $espace = " ";
          $separateur = ", ";

          foreach ($etu as $e) {
              $membre = $membre . $e['prenomPersonne'] . $espace . $e['nomPersonne'] . $separateur;
          }
          $membre = substr($membre, 0, -2);

          $export[] = array($project['nomprojet'], $client, $lechef, $membre);
      }

      // Nom du fichier et delimiteur entre chaque entrées
      $chemin = './documents/attribution.csv';
      $delimiteur = ';'; // Pour une tabulation, $delimiteur = "t";

      // Création du fichier csv
      // fopen : Ouvre un fichier
      /*
          w+ : Ouvre en lecture et écriture ;
          Place le pointeur de fichier au début du fichier et réduit la taille du fichier à 0.
          Si le fichier n'existe pas, on tente de le créer.
      */
      $fichier_csv = fopen($chemin, 'w+');

      /*
          Si votre fichier a vocation a être importé dans Excel,
          vous devez impérativement utiliser la ligne ci-dessous pour corriger
          les problèmes d'affichage des caractères internationaux (les accents par exemple)
      */
      fprintf($fichier_csv, chr(0xEF) . chr(0xBB) . chr(0xBF));

      // On affiche une fois l'entête sans boucle
      $entetes = array('Nom projet', 'Client', 'Chef de projet', 'Membres du groupes');
      fputcsv($fichier_csv, $entetes, $delimiteur);
      //print_r($entetes);

      // Boucle foreach sur chaque ligne du tableau
      // Boucle pour se déplacer dans les tableaux
      foreach ($export as $ligneaexporter) {
          // chaque ligne en cours de lecture est insérée dans le fichier
          // les valeurs présentes dans chaque ligne seront séparées par $delimiteur
          fputcsv($fichier_csv, $ligneaexporter, $delimiteur);
          //print_r($ligneaexporter);
      }

      // fermeture du fichier csv
      fclose($fichier_csv);
      export_csv($fichier_csv);

      ?>
      <p class="mbxl">
          <a href="<?php echo "./documents/attribution.csv" ?>">> Exporter CSV</a>
      </p>
      <?php
    }
}else {
  echo '<strong>Aucune attribution n\'a été effectuée pour le moment.</strong>';
}
?>
