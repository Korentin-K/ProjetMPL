<?php
require_once "Models.php";

class rapport extends Models {
    private $table = "rapporterreur";
    private $columns = ["idRapport", "objetRapport", "descriptionRapport","dateRapport","statutRapport"];
    
    private $idRapport;
    private $objetRapport;
    private $descriptionRapport;
    private $dateRapport;
    private $statutRapport;


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
        return $this->query_findAll($this->table,$column);
    }
    public function findBy($column,$condition){
        return $this->query_findBy($this->table,$column,$condition);
    }

}