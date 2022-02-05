<?php
require_once "Models.php";

class Niveau extends Models {
    private $table = "niveau";
    private $columns = ["id_niveau","nom_niveau","id_projet"];
    private $id_niveu = "";
    private $nom_niveau = "";

    public function __construct(){
        new Models;
        if($this->reloadDataFake === true) {
            $this->deleteAllData($this->table);
            $this->addDataFake(5,2);
        }
    }
    //========================================================
    // DATA : insertion de fausses donnees
    //======================================================== 
    private function addDataFake($maxLine,$repetition){
        $this->insertDataFake($this->table, $this->columns, ["","Niveau $"," $$"], $maxLine,$repetition);
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
        $this->query_delete($this->table,$condition);
    }
    //========================================================
    // REQUETE : recuperation de donnees
    //======================================================== 
    public function findAll($column=null){
        return $this->query_findAll($this->table,$column=null);
    }
    public function findBy($column,$condition){
        return $this->query_findBy($this->table,$column,$condition);
    }

}