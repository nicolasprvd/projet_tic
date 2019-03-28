<!-- Pages listant les groupes enregistrés -->

    <h1> Visualisation des groupes associés à un projet </h1>

    <?php
    $groupsId = getGroupeId();
    if(!empty($groupsId)) {
      ?>
      <table id="liste_groupe">
          <tr class="upper txtcenter">
              <th>Numéro groupe</th>
              <th>Etudiants</th>
          </tr>
      <?php

    foreach ($groupsId as $groupId) {
    ?>
    <tr class="font-x-small">
        <td class="txtcenter"><?php echo $groupId['idGroupe']; ?></td>
        <td>
            <?php
            $personnes = getPersonnesByGroup($groupId['idGroupe']);
            foreach ($personnes as $personne) {
                echo $personne['prenomPersonne'] . ' ' . $personne['nomPersonne'] . '<br>';
            }
            ?>
        </td>
        <?php
        }
        ?>
    </tr>
</table>
<?php
  }
    if(empty($projects)) {
      echo '<strong>Aucun groupe n\'a été constitué pour le moment.</strong>';
    }else {
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
    }?>
