# Projet TIC dans le cadre du master MIAGE

## Installation

### Pré-requis

* Apache 2.4 ou supérieur
* PHP 5.6 ou supérieur
* MySQL 5.0 ou supérieur

### Sources

Cloner le dépôt git ou télécharger le projet en .zip et le décompresser dans le dossier souhaité :

```bash
$ git clone https://github.com/nicolasprvd/projet_tic.git
```

### Base de données 

Créer une base de données nommée **projettic**

Importer le fichier script_bd/projettic.sql dans celle-ci ; ou depuis une invite de commande :

```bash
$ mysql -h {hôte} -u {user} -p{password} projettic < projettic.sql
```
### Configuration

Modifier le fichier include/config.php pour répondre à la configuration souhaitée :

```bash
define('HOST', '');
define('DBNAME', 'projettic');
define('SOURCE', 'mysql:host='.HOST.';dbname='.DBNAME);
define('USER', '');
define('PASSWORD', '');
//Chemin de destination de l'exécutable mysqldump.exe
define('CONF_MYSQLDUMP', '');
```
## Connexion à l'application 

* Identifiant : zemmari@labri.fr
* Mot de passe : admin

