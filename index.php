<?php
/**
 * Index principal de l'application
 * qui inclut les pages
 **/
session_start();
require_once("include/fonctions.php");
require_once("include/fonctions_sql.php");
define('URL', 'index.php?page=');
?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="TIC"/>
    <meta name="Projets TIC" content="Projets TIC"/>
    <link rel="stylesheet" href="css/style_connexion.css">
    <link rel="stylesheet" href="css/style_projet.css">
    <link rel="stylesheet" href="css/style_bases.css">
    <title>Gestion des projets TIC</title>
</head>

<body class="man">
<div class="theGlobal">

    <!-- MENU -->
    <div class="theMenu">

        <?php
        include "include/menu.php";
        ?>
    </div>

    <!-- ENTETE -->
    <div class="theHeader pas">
        <?php include "include/header.php"; ?>
    </div>

    <!-- CONTENU -->
    <div class="theContenu font-xx-small">
        <?php
        //Si $_GET['page'] n'est pas définie alors on affiche la page d'accueil
        if (!isset($_GET['page'])) {
            include "include/accueil.php";
        } else if (isset($_GET['page']) && preg_match('/(form)/', $_GET['page'])) {
            //Si la page est définie et que c'est un formulaire alors on l'inclut
            include "pages/formulaires/" . $_GET['page'];
        } else {
            //Si la page est définie alors on l'inclut
            include "pages/" . $_GET['page'];
        }
        ?>
    </div>

    <!-- PIED DE PAGE -->
    <?php include "include/footer.php"; ?>

</div>
</body>
</html>
