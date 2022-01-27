-- *********************************************
-- * SQL MySQL generation                      
-- *--------------------------------------------
-- * DB-MAIN version: 11.0.2              
-- * Generator date: Sep 14 2021              
-- * Generation date: Tue Jan 25 17:38:19 2022 
-- * LUN file: C:\Users\Ben\Desktop\MPM_project_equipe_5 .lun 
-- * Schema: MPM_MLD/-1 
-- ********************************************* 


-- Database Section
-- ________________ 

create database MPM_MLD;
use MPM_MLD;


-- Tables Section
-- _____________ 

create table Diagramme (
     id_diagramme int not null auto_increment,
     titre_diagramme varchar(30) not null,
     dateCreation_diagramme date not null,
     dateModification_diagramme date default null,
     constraint ID_Diagramme_ID primary key (id_diagramme));

create table Droit (
     id_droit int not null auto_increment,
     nom_droit varchar(20) not null,
     description_droit varchar(50) default null,
     constraint ID_Droit_ID primary key (id_droit));

create table Niveau (
     id_niveau int not null auto_increment,
     nom varchar(20) default null,
     constraint ID_Niveau_ID primary key (id_niveau));

create table Organisation (
     id_organisation int not null auto_increment,
     nom_organisation varchar(30) not null,
     description_organisation varchar(50) default null,
     constraint ID_Organisation_ID primary key (id_organisation));

create table posseder (
     id_diagramme int not null,
     id_utilisateur int not null,
     constraint ID_posseder_ID primary key (id_diagramme, id_utilisateur));

create table Tache (
     id_tache int not null auto_increment,
     nom_tache varchar(20) not null,
     duree_tache int default 0,
     contenu_tache varchar(50) default null,
     debutPlusTot_tache int default null,
     debutPlusTard_tache int default null,
     margeLibre_tache int default null,
     margeTotale_tache int default null,
     tacheAnterieur_tache varchar(20) default null,
     id_diagramme int not null,
     id_niveau int not null,
     constraint ID_Tache_ID primary key (id_tache));

create table Utilisateur (
     id_utilisateur int not null auto_increment,
     nom_utilisateur varchar(20) not null,
     prenom_utilisateur varchar(20) not null,
     mail_utilisateur varchar(80) not null,
     mdp_utilisateur varchar(20) not null,
     ip_utilisateur varchar(20) default null,
     navigateur_utilisateur varchar(20) default null,
     id_droit int default null,
     id_organisation int default null,
     constraint ID_Utilisateur_ID primary key (id_utilisateur));


-- Constraints Section
-- ___________________ 

alter table posseder add constraint FKpos_Uti_FK
     foreign key (id_utilisateur)
     references Utilisateur (id_utilisateur);

alter table posseder add constraint FKpos_Dia
     foreign key (id_diagramme)
     references Diagramme (id_diagramme);

alter table Tache add constraint FKcontenir_FK
     foreign key (id_diagramme)
     references Diagramme (id_diagramme);

alter table Utilisateur add constraint FKautoriser_FK
     foreign key (id_droit)
     references Droit (id_droit);

alter table Utilisateur add constraint FKappartenir_FK
     foreign key (id_organisation)
     references Organisation (id_organisation);


-- Index Section
-- _____________ 

create unique index ID_Diagramme_IND
     on Diagramme (id_diagramme);

create unique index ID_Droit_IND
     on Droit (id_droit);

create unique index ID_Niveau_IND
     on Niveau (id_niveau);

create unique index ID_Organisation_IND
     on Organisation (id_organisation);

create unique index ID_posseder_IND
     on posseder (id_diagramme, id_utilisateur);

create index FKpos_Uti_IND
     on posseder (id_utilisateur);

create unique index ID_Tache_IND
     on Tache (id_tache);

create index FKcontenir_IND
     on Tache (id_diagramme);

create unique index ID_Utilisateur_IND
     on Utilisateur (id_utilisateur);

create index FKautoriser_IND
     on Utilisateur (id_droit);

create index FKappartenir_IND
     on Utilisateur (id_organisation);

-- Commentaires
-- Suppresion col niveau dans table NIVEAU
