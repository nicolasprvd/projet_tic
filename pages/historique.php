<?php
/**
* Page permettant d'historiser les données d'une année sur l'autre
**/
?>

<?php
$verif = false;
if(isset($_POST['btn_submit'])){
    $verif = true;
}

?>

<h1> Historique </h1>

<img src = "./images/attention.png"   height="100px" 
    width="200px" >
<p> Attention, historier vos tables uniquement lorsque vous changez d'année scolaire !!</p>

<?php 
if ($verif == false){
    ?>
<form enctype="multipart/form-data" action = "index.php?page=historique.php" method = "POST">
    <input type = "submit" value = "Historier l'année" name = "btn_submit"/>
</form>

<?php
} else {
    echo 'On doit historier';
}
?>

