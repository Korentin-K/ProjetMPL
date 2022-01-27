<?php
require_once "Models.php";

class Niveau extends Models {
    private $table = "niveau";
    private $columns = ["id_niveau","nom"];
    private $id_niveu = "";
    private $nom_niveau = "";

    public function __construct(){
        new Models;
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
    public function findBy($column=null,$condition){
        return $this->query_findBy($this->table,$column=null,$condition);
    }

}