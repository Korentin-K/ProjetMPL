<?php
require_once "Models.php";

class Tache extends Models {
    private $table = "tache";
    private $columns = ["id_tache", "nom_tache", "id_niveau_tache","duree_tache", "contenu_tache", "debutPlusTot_tache", "debutPlusTard_tache", "margeLibre_tache", "margeTotale_tache", "tacheAnterieur_tache", "id_projet"];
    
    private $id_tache;
    private $nom_tache = "";
    private $id_niveau_tache;
    private $duree_tache = 0;
    private $contenu_tache = "";
    private $debutPlusTot_tache = 0;
    private $debutPlusTard_tache= 0;
    private $margeLibre_tache= 0;
    private $margeTotale_tache= 0;
    private $tacheAnterieur_tache = null;
    private $id_projet;
    private $html;

    public function __construct($reload=false){
        new Models;
        if($this->reloadDataFake === true || $reload) {
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


/**
     * Get the value of id_tache
     */ 
    public function getId_tache()
    {
        return $this->id_tache;
    }

    /**
     * Set the value of id_tache
     *
     * @return  self
     */ 
    public function setId_tache($id_tache)
    {
        $this->id_tache = $id_tache;

        return $this;
    }
    
    /**
     * Get the value of nom_tache
     */ 
    public function getNom_tache()
    {
        return $this->nom_tache;
    }

    /**
     * Set the value of nom_tache
     *
     * @return  self
     */ 
    public function setNom_tache($nom_tache)
    {
        $this->nom_tache = $nom_tache;

        return $this;
    }

     /**
     * Get the value of id_niveau_tache
     */ 
    public function getId_niveau_tache()
    {
        return $this->id_niveau_tache;
    }

    /**
     * Set the value of id_niveau_tache
     *
     * @return  self
     */ 
    public function setId_niveau_tache($id_niveau_tache)
    {
        $this->id_niveau_tache = $id_niveau_tache;

        return $this;
    }

    /**
     * Get the value of duree_tache
     */ 
    public function getDuree_tache()
    {
        return $this->duree_tache;
    }

    /**
     * Set the value of duree_tache
     *
     * @return  self
     */ 
    public function setDuree_tache($duree_tache)
    {
        $this->duree_tache = $duree_tache;

        return $this;
    }

    /**
     * Get the value of contenu_tache
     */ 
    public function getContenu_tache()
    {
        return $this->contenu_tache;
    }

    /**
     * Set the value of contenu_tache
     *
     * @return  self
     */ 
    public function setContenu_tache($contenu_tache)
    {
        $this->contenu_tache = $contenu_tache;

        return $this;
    }

    /**
     * Get the value of debutPlusTot_tache
     */ 
    public function getDebutPlusTot_tache()
    {
        return $this->debutPlusTot_tache;
    }

    /**
     * Set the value of debutPlusTot_tache
     *
     * @return  self
     */ 
    public function setDebutPlusTot_tache($debutPlusTot_tache)
    {
        $this->debutPlusTot_tache = $debutPlusTot_tache;

        return $this;
    }

    /**
     * Get the value of debutPlusTard_tache
     */ 
    public function getDebutPlusTard_tache()
    {
        return $this->debutPlusTard_tache;
    }

    /**
     * Set the value of debutPlusTard_tache
     *
     * @return  self
     */ 
    public function setDebutPlusTard_tache($debutPlusTard_tache)
    {
        $this->debutPlusTard_tache = $debutPlusTard_tache;

        return $this;
    }

    /**
     * Get the value of margeLibre_tache
     */ 
    public function getMargeLibre_tache()
    {
        return $this->margeLibre_tache;
    }

    /**
     * Set the value of margeLibre_tache
     *
     * @return  self
     */ 
    public function setMargeLibre_tache($margeLibre_tache)
    {
        $this->margeLibre_tache = $margeLibre_tache;

        return $this;
    }

    /**
     * Get the value of margeTotale_tache
     */ 
    public function getMargeTotale_tache()
    {
        return $this->margeTotale_tache;
    }

    /**
     * Set the value of margeTotale_tache
     *
     * @return  self
     */ 
    public function setMargeTotale_tache($margeTotale_tache)
    {
        $this->margeTotale_tache = $margeTotale_tache;

        return $this;
    }

    /**
     * Get the value of tacheAnterieur_tache
     */ 
    public function getTacheAnterieur_tache()
    {
        return $this->tacheAnterieur_tache;
    }

    /**
     * Set the value of tacheAnterieur_tache
     *
     * @return  self
     */ 
    public function setTacheAnterieur_tache($tacheAnterieur_tache)
    {
        $this->tacheAnterieur_tache = $tacheAnterieur_tache;

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

    /**
     * Get the value of html
     */ 
    public function getHtml()
    {
        return $this->html;
    }

    /**
     * Set the value of html
     *
     * @return  self
     */ 
    public function setHtml($html)
    {
        $this->html = $html;

        return $this;
    }
}