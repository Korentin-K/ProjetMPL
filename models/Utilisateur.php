<?php
require_once "Models.php";

class Utilisateur extends Models {
    private $table = "utilisateur";
    private $columns = ["id_utilisateur", "nom_utilisateur", "prenom_utilisateur", "mail_utilisateur", "mdp_utilisateur", "ip_utilisateur", "navigateur_utilisateur", "id_droit", "id_organisation"];
    
    private $id_utilisateur;
    private $nom_utilisateur;
    private $prenom_utilisateur;
    private $mail_utilisateur;
    private $mdp_utilisateur;
    private $ip_utilisateur;
    private $navigateur_utilisateur;
    private $id_droit;
    private $id_organisation;   

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
        $values = ["","nom $","prenom $","mail@faker.com","5f4dcc3b5aa765d61d8327deb882cf99","","","",""];
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