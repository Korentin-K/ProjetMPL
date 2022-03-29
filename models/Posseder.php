<?php
require_once "Models.php";

class Posseder extends Models {
    private $table = "posseder";
    private $columns = ["id_projet", "id_utilisateur"];
    
    private $id_projet;
    private $id_utilisateur;

    public function __construct($reload=false){
        new Models;
        if($this->reloadDataFake === true || $reload) {
            $this->deleteAllData($this->table);
            $this->addDataFake(5);
        }
    }

    private function addDataFake($maxProjectAssigne){    
        $project = new Projet;
        $allProject = $project->findAll("id_projet");
        $countProject = sizeof($allProject);
        $user = new Utilisateur;
        $allUser = $user->findAll("id_utilisateur");
        foreach($allUser as $oneUser){
            $u = $oneUser["id_utilisateur"];
            for($r=0;$r<$maxProjectAssigne;$r++){
                if($r >= $countProject-1) break;
                $p = $allProject[$r];
                $value = [$p["id_projet"],$u];
                $this->insert($value);
            }
        }
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
        return $this->query_findAll($this->table,$column);
    }
    public function findBy($column=null,$condition){
        return $this->query_findBy($this->table,$column,$condition);
    }

}