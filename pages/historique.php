<?php
/**
 * Page permettant d'historiser les données d'une année sur l'autre
 **/
?>

<?php
if (isset($_POST['btn_submit'])) {
    $date = date('Ymd');
    dumpBase(HOST, USER, PASSWORD, DBNAME, $date);
}

if(isset($_REQUEST['messages'])) {
  include('../include/messages.php');
}
?>

<form enctype="multipart/form-data" action="<?php echo URL . 'historique.php'; ?>" method="POST" id="historique" class="mbl">
    <input type="submit" class="input_custom" value="Effectuer une sauvegarde" name="btn_submit"/>
</form>

<?php
if (isset($_POST['btn_submit'])) {
    ?>
    <a href="./documents/backup/<?php echo date('Y') . '/' . 'backup_' . DBNAME . '_' . date('Ymd') . '.sql'; ?>">> Télécharger</a>
    <?php
}
?>
