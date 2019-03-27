<?php
/**
* Page permettant d'historiser les données d'une année sur l'autre
**/
?>

<?php
if(isset($_POST['btn_submit'])){
    $date = date('Ymd');
    dumpBase(HOST, USER, PASSWORD, DBNAME, $date);
}
?>

<h1> Historique </h1>

<form enctype="multipart/form-data" action="<?php echo URL.'historique.php';?>" method="POST">
    <input type="submit" value="Effectuer une sauvegarde" name="btn_submit"/>
</form>

<?php
if(isset($_POST['btn_submit'])){
    ?>
    <a href="./documents/backup/<?php echo date('Y').'/'.'backup_'.DBNAME.'_'.date('Ymd').'.sql'; ?>">Télécharger</a>
    <?php
}
?>
