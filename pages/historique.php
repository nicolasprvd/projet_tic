<?php
/**
* Page permettant d'historiser les données d'une année sur l'autre
**/

require('./include/config.php');
$verif = false;
if(isset($_POST['btn_submit'])){
    $date = date('Ymd');
    dumpBase($host, $user, $password, $dbname, $date);
}
?>

<form enctype="multipart/form-data" action="index.php?page=historique.php" method="POST" id="historique">
    <input type="submit" value="Effectuer une sauvegarde" name="btn_submit"/>
</form>
