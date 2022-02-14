<?php
require_once "Models.php";

class Projet extends Models {
    private $table = "projet";
    private $columns = ["id_projet", "titre_projet", "dateCreation_projet", "dateModification_projet"];
    
    private $titre_diagramme;
    private $dateCreation_diagramme;
    private $dateModification_diagramme;

    public function __construct($reload=false){
        new Models;
        if($this->reloadDataFake === true || $reload) {
            $this->deleteAllData($this->table);
            $this->addDataFake(10,1);
        }
    }
    //========================================================
    // DATA : insertion de fausses donnees
    //======================================================== 
    private function addDataFake($maxLine,$repetition){
        $values = ["","Projet $","NOW()",""];
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
        return $this->query_findBy($this->table,$column=null,$condition);
    }

}