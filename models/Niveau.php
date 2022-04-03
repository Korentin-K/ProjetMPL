<?php
require_once "Models.php";

class Niveau extends Models {
    private $table = "niveau";
    private $columns = ["id_niveau","nom_niveau","id_projet"];
    private $id_niveau = "";
    private $nom_niveau = "";
    private $id_projet = "";

    public function __construct($reload=false){
        new Models;
        if($this->reloadDataFake === true || $reload) {
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

    public function getMaxLevelByProject($idProjet){
        return $this->customQuery($sql="SELECT MAX(id_niveau) as max FROM niveau WHERE id_projet='$idProjet'")[0]['max'];
    }
    public function getLevelOfProjet($idProjet){
        return $this->customQuery("SELECT id_niveau FROM niveau WHERE id_projet='$idProjet' order by id_niveau DESC");
    }


    /**
     * Get the value of id_niveau
     */ 
    public function getId_niveau()
    {
        return $this->id_niveau;
    }

    /**
     * Set the value of id_niveau
     *
     * @return  self
     */ 
    public function setId_niveau($id_niveau)
    {
        $this->id_niveau = $id_niveau;

        return $this;
    }

    /**
     * Get the value of nom_niveau
     */ 
    public function getNom_niveau()
    {
        return $this->nom_niveau;
    }

    /**
     * Set the value of nom_niveau
     *
     * @return  self
     */ 
    public function setNom_niveau($nom_niveau)
    {
        $this->nom_niveau = $nom_niveau;

        return $this;
    }

    /**
     * Get the value of id_projet
     */ 
    public function getId_projet()
    {
        return $this->id_projet;
    }

    /**
     * Set the value of id_projet
     *
     * @return  self
     */ 
    public function setId_projet($id_projet)
    {
        $this->id_projet = $id_projet;

        return $this;
    }
}