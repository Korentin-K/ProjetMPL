<?php

class Niveau extends Models {
    private $table = "niveau";
    private $columns = ["id_niveau","nom"];
    private $id_niveu = "";
    private $nom_niveau = "";

    public function __construct(){
        new Models;
    }

    public function update($field, $value, $condition=null){
        $this->query_update($this->table, $field, $value, $condition);
    }

    public function insert($value, $condition=null){
        $this->query_insert($this->table, $this->columns, $value, $condition);
    }
    
    public function delete($condition){
        $this->query_delete($this->table,$condition);
    }

}