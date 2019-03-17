<?php
/**
* Pages permettant de visualiser et récupérer les notes de chaques étudiants
**/
?>

<h2> Visualisation des notes </h2>

<?php
$persEvalue = getPersonneEvaluate();

//Initialisation du csv
$chemin = './documents/export_notes.csv';
$delimiteur = ';'; // Pour une tabulation, $delimiteur = "t";
$fichier_csv = fopen($chemin, 'w+');
fprintf($fichier_csv, chr(0xEF).chr(0xBB).chr(0xBF));
?>


<table>
    <tr>
      <th> Nom personne </th>
      <th> Prenom personne </th>
      <th> Note CDC </th>
      <th> Note soutenance </th>
      <th> Note rendu </th>
      <th> Note finale </th>
    </tr>
  
      <?php
       // On affiche une fois l'entête sans boucle
       $entetes = array('Nom personne', 'Prenom personne', 'Note CDC', 'Note soutenantce', 'Note rendu', 'Note fianle');
       fputcsv($fichier_csv, $entetes, $delimiteur);
  
        foreach($persEvalue as $eval) {
          ?>
          <tr>
            <td><?php echo $eval['nompersonne']; ?></td>
            <td><?php echo $eval['prenompersonne']; ?></td>

            <?php
            if (empty($eval['idevaluation'])){
            ?>
                <td> - </td>
                <td> - </td>
                <td> - </td>
                <td> - </td>

                
                <?php
                //Pour le csv
                $export[] = array($eval['nompersonne'],$eval['prenompersonne'], '-', '-', '-', '-');
                ?>
                
            <?php
            } else {
                $notes = getnotes($eval['idevaluation']);
            ?>
                <td><?php echo $notes['notecdc']; ?></td>
                <td><?php echo $notes['notesoutenance']; ?></td>
                <td><?php echo $notes['noterendu']; ?></td>
                <td><?php echo $notes['notefinale']; ?></td>

                <?php
                //Pour le csv
                $export[] = array($eval['nompersonne'],$eval['prenompersonne'], $notes['notecdc'], $notes['notesoutenance'], $notes['noterendu'], $notes['notefinale']);
                ?>

            <?php
            }
            ?>

          </tr>
          <?php
        }
       ?>
  </table>

<?php
    foreach($export as $ligneaexporter){
        // chaque ligne en cours de lecture est insérée dans le fichier
        // les valeurs présentes dans chaque ligne seront séparées par $delimiteur
        fputcsv($fichier_csv, $ligneaexporter, $delimiteur);
        //print_r($ligneaexporter);
    }
   
    // fermeture du fichier csv
    fclose($fichier_csv);
    export_csv($fichier_csv);
?>
<br><br>
<a href="<?php echo "./documents/export_notes.csv"?>">Exporter CSV</a>



