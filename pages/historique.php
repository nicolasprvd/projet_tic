<?php
/**
* Page permettant d'historiser les données d'une année sur l'autre
**/
?>

<?php
require('./include/config.php');
$verif = false;
if(isset($_POST['btn_submit'])){
    $date = date('Ymd');
    dumpBase($host, $user, $password, $dbname, $date);
}
?>

<h1> Historique </h1>

<form enctype="multipart/form-data" action="index.php?page=historique.php" method="POST">
    <input type="submit" value="Effectuer une sauvegarde" name="btn_submit"/>
</form>
