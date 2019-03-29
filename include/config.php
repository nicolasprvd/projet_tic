<?php

/**
* Fichier de configuration
* permettant de
* se connecter à la BDD
**/
define('HOST', '127.0.0.1');
define('DBNAME', 'testprojettic');
define('SOURCE', 'mysql:host='.HOST.';dbname='.DBNAME);
define('USER', 'root');
define('PASSWORD', '');

//Chemin de destination de l'exécutable mysqldump.exe
define('CONF_MYSQLDUMP', 'C:\xampp\mysql\bin\mysqldump.exe');
?>
