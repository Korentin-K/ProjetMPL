<?php
require_once "Models.php";

class Tache extends Models {
    private $table = "tache";
    private $columns = ["id_tache", "nom_tache", "id_niveau_tache","duree_tache", "contenu_tache", "debutPlusTot_tache", "debutPlusTard_tache", "margeLibre_tache", "margeTotale_tache", "tacheAnterieur_tache", "id_projet"];
    
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

    public function __construct(){
        new Models;
        if($this->reloadDataFake === true) {
            $this->deleteAllData($this->table);
            $this->addDataFake(10,3);
        }
    }
    //========================================================
    // DATA : insertion de fausses donnees
    //======================================================== 
    private function addDataFake($maxLine,$repetition){
        $values = ["","Tache $"," $","","courte description","","","","",""," $$"];
        $this->insertDataFake($this->table, $this->columns, $values, $maxLine, $repetition);
    }
    //========================================================
    // REQUETE : manipulation de donnees
    //======================================================== 
    public function update($field, $value, $condition=null){
        $this->query_update($this->table, $field, $value, $condition);
    }
    public function insert($value, $condition=null){
        $this->query_insert($this->table, $this->columns, $value, $condition);
    }    
    public function delete($condition){
        query_delete($this->table,$condition);
    }
    //========================================================
    // REQUETE : recuperation de donnees
    //======================================================== 
    public function findAll($column=null){
        return $this->query_findAll($this->table,$column=null);
    }
    public function findBy($column=null,$condition){
        return $this->query_findBy($this->table,$column,$condition);
    }

}