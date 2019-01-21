drop database if exists projettic;

create database if not exists projettic;
use projettic;
# -----------------------------------------------------------------------------
#       table : statut
# -----------------------------------------------------------------------------

create table if not exists statut
 (
   idstatut integer(2) not null  ,
   libelle char(255) null
   , primary key (idstatut)
 )
 comment = "";

# -----------------------------------------------------------------------------
#       table : personne
# -----------------------------------------------------------------------------

create table if not exists personne
 (
   idpersonne integer(2) not null  ,
   idgroupe integer(2) null  ,
   idevaluation integer(2) null  ,
   idstatut integer(2) not null  ,
   idgroupetemp integer(2) null  ,
   nompersonne char(255) null  ,
   prenompersonne char(255) null  ,
   mailpersonne char(255) null,
   password char(255) null
   , primary key (idpersonne)
 )
 comment = "";

# -----------------------------------------------------------------------------
#       table : groupe
# -----------------------------------------------------------------------------

create table if not exists groupe
 (
   idgroupe integer(2) not null  ,
   idprojet integer(2) not null  ,
   idpersonnechef integer(2) not null
   , primary key (idgroupe)
 )
 comment = "";

# -----------------------------------------------------------------------------
#       table : groupe_temp
# -----------------------------------------------------------------------------

create table if not exists groupe_temp
 (
   idgroupe integer(2) not null  ,
   idpersonnechef integer(2) not null
   , primary key (idgroupe)
 )
 comment = "";

# -----------------------------------------------------------------------------
#       table : projet
# -----------------------------------------------------------------------------

create table if not exists projet
 (
   idprojet integer(2) not null  ,
   idpersonneresp integer(2) not null  ,
   nomprojet char(255) null  ,
   descriptiftexte text null  ,
   descriptifpdf char(255) null,
   automatique boolean,
   primary key (idprojet)
 )
 comment = "";

# -----------------------------------------------------------------------------
#       table : evaluation
# -----------------------------------------------------------------------------

create table if not exists evaluation
 (
   idevaluation integer(2) not null  ,
   notecdc decimal(10,2) null  ,
   notesoutenance decimal(10,2) null  ,
   noterendu decimal(10,2) null  ,
   notefinale decimal(10,2) null
   , primary key (idevaluation)
 )
 comment = "";

# -----------------------------------------------------------------------------
#       table : choix_temp
# -----------------------------------------------------------------------------

create table if not exists choix_temp
 (
   idprojet integer(2) not null  ,
   idgroupe integer(2) not null
   , primary key (idprojet,idgroupe)
 )
 comment = "";


# -----------------------------------------------------------------------------
#       creation des references de table
# -----------------------------------------------------------------------------


alter table personne
  add foreign key fk_personne_groupe (idgroupe)
      references groupe (idgroupe) ;


alter table personne
  add foreign key fk_personne_evaluation (idevaluation)
      references evaluation (idevaluation) ;


alter table personne
  add foreign key fk_personne_statut (idstatut)
      references statut (idstatut) ;


alter table personne
  add foreign key fk_personne_groupe_temp (idgroupetemp)
      references groupe_temp (idgroupe) ;


alter table groupe
  add foreign key fk_groupe_projet (idprojet)
      references projet (idprojet) ;


alter table groupe
  add foreign key fk_groupe_personne (idpersonnechef)
      references personne (idpersonne) ;


alter table groupe_temp
  add foreign key fk_groupe_temp_personne (idpersonnechef)
      references personne (idpersonne) ;


alter table projet
  add foreign key fk_projet_personne (idpersonneresp)
      references personne (idpersonne) ;


alter table choix_temp
  add foreign key fk_choix_temp_projet (idprojet)
      references projet (idprojet) ;


alter table choix_temp
  add foreign key fk_choix_temp_groupe_temp (idgroupe)
      references groupe_temp (idgroupe) ;
