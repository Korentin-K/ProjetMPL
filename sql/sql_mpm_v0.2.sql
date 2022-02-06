-- *********************************************
-- * SQL MySQL generation                      
-- *--------------------------------------------
-- * DB-MAIN version: 11.0.2              
-- * Generator date: Sep 14 2021              
-- * Generation date: Thu Jan 27 15:46:15 2022 
-- * LUN file: C:\xampp\htdocs\mpm\sql\modele_donnee\modele_mpm_v0 .1.lun 
-- * Schema: MPM/-1 
-- ********************************************* 


-- Database Section
-- ________________ 

create database if not exists MPM;
use MPM;


-- Tables Section
-- _____________ 

create table Projet (
     id_projet int not null auto_increment,
     titre_projet varchar(30) not null,
     dateCreation_projet datetime not null,
     dateModification_projet datetime default null,
     constraint ID_Projet_ID primary key (id_projet));

create table Droit (
     id_droit int not null auto_increment,
     nom_droit varchar(20) not null,
     description_droit varchar(50) default null,
     constraint ID_Droit_ID primary key (id_droit));

create table Niveau (
     id_niveau int not null auto_increment,
     nom_niveau varchar(10) not null,
     id_projet int not null,
     constraint ID_Niveau_ID primary key (id_niveau));

create table Organisation (
     id_organisation int not null auto_increment,
     nom_organisation varchar(30) not null,
     description_organisation varchar(50) default null,
     constraint ID_Organisation_ID primary key (id_organisation));

create table posseder (
     id_projet int not null,
     id_utilisateur int not null,
     constraint ID_posseder_ID primary key (id_projet, id_utilisateur));

create table Tache (
     id_tache int not null auto_increment,
     nom_tache varchar(20) not null,
     id_niveau_tache int default null,
     duree_tache int default null,
     contenu_tache varchar(50) default null,
     debutPlusTot_tache int default null,
     debutPlusTard_tache varchar(3) default null,
     margeLibre_tache int default null,
     margeTotale_tache varchar(3) default null,
     tacheAnterieur_tache varchar(20) default null,
     id_projet int not null,
     constraint ID_Tache_ID primary key (id_tache));

create table Utilisateur (
     id_utilisateur int not null auto_increment,
     nom_utilisateur varchar(20) not null,
     prenom_utilisateur varchar(20) not null,
     mail_utilisateur varchar(80) not null,
     mdp_utilisateur varchar(20) not null,
     ip_utilisateur char(1) default null,
     navigateur_utilisateur char(1) default null,
     id_droit int default null,
     id_organisation int default null,
     constraint ID_Utilisateur_ID primary key (id_utilisateur));


-- Constraints Section
-- ___________________ 

-- alter table Niveau add constraint FKcomposer_FK
--      foreign key (id_projet)
--      references Projet (id_projet);

-- alter table posseder add constraint FKpos_Uti_FK
--      foreign key (id_utilisateur)
--      references Utilisateur (id_utilisateur);

-- alter table posseder add constraint FKpos_Pro
--      foreign key (id_projet)
--      references Projet (id_projet);

-- alter table Tache add constraint FKcontenir_FK
--      foreign key (id_projet)
--      references Projet (id_projet);

-- alter table Utilisateur add constraint FKautoriser_FK
--      foreign key (id_droit)
--      references Droit (id_droit);

-- alter table Utilisateur add constraint FKappartenir_FK
--      foreign key (id_organisation)
--      references Organisation (id_organisation);


-- Index Section
-- _____________ 

-- create unique index ID_Projet_IND
--      on Projet (id_projet);

-- create unique index ID_Droit_IND
--      on Droit (id_droit);

-- create unique index ID_Niveau_IND
--      on Niveau (id_niveau);

-- create index FKcomposer_IND
--      on Niveau (id_projet);

-- create unique index ID_Organisation_IND
--      on Organisation (id_organisation);

-- create unique index ID_posseder_IND
--      on posseder (id_projet, id_utilisateur);

-- create index FKpos_Uti_IND
--      on posseder (id_utilisateur);

-- create unique index ID_Tache_IND
--      on Tache (id_tache);

-- create index FKcontenir_IND
--      on Tache (id_projet);

-- create unique index ID_Utilisateur_IND
--      on Utilisateur (id_utilisateur);

-- create index FKautoriser_IND
--      on Utilisateur (id_droit);

-- create index FKappartenir_IND
--      on Utilisateur (id_organisation);

