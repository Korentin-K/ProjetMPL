<?php

require_once "./config/Database.php";

class Tache extends Database {
    private $nom_tache;
    private $duree_tache;
    private $contenu_tache;
    private $debutPlusTot_tache;
    private $debutPlusTard_tache;
    private $margeLibre_tache;
    private $margeTotale_tache;
    private $tacheAnterieur_tache;
    private $id_diagramme;
    private $id_niveau;

    public function test(){
        
        //var_dump($db->getInstance());
    }

}