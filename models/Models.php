<?php
require_once "./config/config.php";
require_once "./config/Database.php";

class Models extends Database {
    private static $pdo = null;
    protected $reloadDataFake = false;

    public function __construct(){
        if(self::$pdo === null){
            new Database;
            self::$pdo = Database::$instance;
        }
    }
    //========================================================
    // DATA : insertion de fausses donnees
    //======================================================== 
    //---------------------------------------------------------------
    //  determine le nombre de niveau par projet;
    //---------------------------------------------------------------
    private function getNiveauByProjet(){
        $sql = "select id_niveau, id_projet from niveau";
        $query = self::$pdo->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $data = array();
        foreach($result as $row){
            if( !isset($data[$row['id_projet']])) $data[$row['id_projet']] = array();
            array_push($data[$row['id_projet']], $row['id_niveau']);
        }
        return $data;
    }
    //---------------------------------------------------------------
    //  determine la valeur MIN et MAX des ID de la table parente;
    //  La table parente est definie en fonction des cles etrangere;
    //---------------------------------------------------------------
    private function getIdParentTable($table){
        $data = null;
        switch($table){
            case "niveau" : $parentTable = "projet";
                break;
            case "tache" : $parentTable = "projet";
                break;
            default : $parentTable = null;
                break;
        }
        if($parentTable != null){
            $idParent = "id_".$parentTable;
            $sql = "select ".$idParent." from ".$parentTable;
            $query = self::$pdo->prepare($sql);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC); 
            $data = array(); 
            foreach($result as $row){
                foreach($row as $key => $value){
                    array_push($data, $value);
                }
            }          
        }
        return $data;
    }
    //----------------------------------------------------------------------------
    //  insert de fausse donnee dans la table;
    //  Possibilite de renseigner un nombre de ligne max;
    //  Possibilite de repeter le nombre de ligne max avec une valeur differente;
    //----------------------------------------------------------------------------
    protected function insertDataFake($table, $columns, $arrayValues,$maxLine,$repetition=null){
        $idParentTable = $this->getIdParentTable($table);
        //Si non null, recuperer les identifiants des cles primaires
        if( $idParentTable != null){
            $repetition = sizeof($idParentTable)-1;
            $startRep = 0;
            if( $table=="tache") $idNiveau = $this->getNiveauByProjet();
        }else{            
            $repetition = $repetition == null ? 1 : $repetition;
            $startRep = 0;
        }
        $multiLoop = $repetition == null ? false : true;

        // boucle nombre de repetitions - id_projet
        for($r=$startRep;$r<$repetition;$r++){
            if($table == "tache" || $table == "niveau") $idProjet = $idParentTable[$r];            
            $n = 0;
            //boucle nombre de ligne a completer
            for($i=0;$i<$maxLine;$i++){
                if($table == "tache" && $n == (sizeof($idNiveau[$idProjet])) ) $n = 0;
                $data = array();
                //boucle par colonne a completer
                for($j=0;$j<sizeof($arrayValues);$j++){ 
                    //Si presence de $, remplacer par une incrementation 
                    if(stripos($arrayValues[$j],"$") != false) {                       
                        $extract = strstr($arrayValues[$j],"$");
                        if( ($table=="niveau" && $j == 2) || ($table=="tache" && $j == 10) ) $data[$j] = str_replace("$$",$idProjet,$arrayValues[$j]); 
                        elseif($table == "tache" && $j == 2) $data[$j] = str_replace("$",$idNiveau[$idProjet][$n],$arrayValues[$j]);
                        else if($extract == "$$" && $multiLoop == true) $data[$j] = str_replace("$$",$r,$arrayValues[$j]); 
                        else $data[$j] = str_replace("$",$i,$arrayValues[$j]); 
                    }
                    else $data[$j] = $arrayValues[$j];
                }
                // var_dump($data);
                // exit;
                $this->query_insert($table, $columns, $data);
                $n += 1;
            }
        }
    }
    //------------------------------------------
    // supprime toutes les donnees de la table
    //------------------------------------------
    protected function deleteAllData($table){
        $this->query_delete($table);
    }
    //========================================================
    // REQUETE : manipulation de donnees
    //========================================================    
    // requete de mise � jour de ligne
    protected function query_update($table, $field, $value, $condition){
        $sql = "update ".strval($table)." set ".strval($field)."='".strval($value)."' where ".strval($condition);
        $query = self::$pdo->prepare($sql);
        $query->execute();
    }
    // requete pour insertion de ligne
    protected function query_insert($table, $fields, $values, $condition=null){
        $sql = "insert ignore into ".strval($table)." (";
        foreach($fields as $colName){
            $sql .= $colName.",";
        }
        $sql = rtrim($sql,",");
        $sql .= ") values (";
        foreach($values as $value){
            if($value == "NOW()") $sql .= $value.",";
            else $sql .= "'".$value."',";
        }
        $sql = rtrim($sql,",");
        $sql .= ")";      
        if($condition != null) $sql .= " where ".strval($condition);
        $sql .= ";";
        $query = self::$pdo->prepare($sql);
        $query->execute();
    }
    // requete pour supression de ligne
    protected function query_delete($table,$condition=null){
        $sql = "delete from ".strval($table);
        $sql .= $condition == null ? "" : " where ".strval($condition);
        $sql .= ";";
        $query = self::$pdo->prepare($sql);
        $query->execute();
    }

    //========================================================
    // REQUETE : recuperation de donnees
    //======================================================== 
     // requete pour trouver tout les elements
     protected function query_findAll($table,$column=null){
        $column = $column == null ? "*" : $column;
        $sql = "select ".strval($column)." from ".strval($table);
        $query = self::$pdo->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }   
    // requete pour trouver un element 
    protected function query_findBy($table,$column=null,$condition){
        $column = $column == null ? "*" : $column;
        $sql = "select ".strval($column)." from ".strval($table)." where ".strval($condition);
        // echo $sql;
        $query = self::$pdo->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function customQuery($sql){
        $query = self::$pdo->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    /**
     * Get the value of pdo
     */ 
    public function getPdo()
    {
        return self::$pdo;
    }

    //======================================================================================
    // REQUETE : Avant insertion de données par l'inscription pour vérifier si compte existe
    //====================================================================================== 
    public function rechercheCompteExiste($email)
    {
        $sql= "select * from utilisateur where mail_utilisateur='".strval($email)."'";
        $query = self::$pdo->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        if($result!=null)
        {
            //retourne false si le compte existe
            return false;
        }
        else{
            return true;
        }
    }
    //========================================================
    // REQUETE : insertion de données par l'inscription
    //======================================================== 
    public function inscriptionSite($nomUser,$email,$mdp)
    {
        $sql = "insert into utilisateur(nom_utilisateur,mail_utilisateur,mdp_utilisateur) VALUES ('".strval($nomUser)."','".strval($email)."','".$mdp."')";
        echo $sql;
        $query = self::$pdo->prepare($sql);
        $query->execute();

    }

    //======================================================================
    //REQUETE : Recherche si l'identifiant existe et connecte l'utilisateur
    //======================================================================
    public function rechercheConnexion($email,$mdp)
    {
        $sql= "select * from utilisateur where mail_utilisateur='".strval($email)."' and mdp_utilisateur='".strval($mdp)."'";
        $query = self::$pdo->prepare($sql);
        $query->execute();
        if($query!=null)
        {
            //retourne true si cela correspond
            return true;
        }
        else{
            return false;
        }
    }
    //======================================================================
    //REQUETE : Recherche le nom de l'utilisateur grâce à l'email
    //======================================================================
    public function rechercheNom($email)
    {
        $sql= "select nom_utilisateur from utilisateur where mail_utilisateur='".strval($email)."'";
        $query = self::$pdo->prepare($sql);
        $query->execute();
         return $query->fetch(PDO::FETCH_ASSOC);
    }


    //======================================================================
    //REQUETE : Récupération de données des projets
    //======================================================================
    public function recuperationProjet($nomUser)
    {
        //passage par la table posséder
        $sql= "select * from `projet` inner join posseder on projet.id_projet=posseder.id_projet
        inner join utilisateur on posseder.id_utilisateur=utilisateur.id_utilisateur 
        WHERE utilisateur.nom_utilisateur=".strval($nomUser) ;
        $query = self::$pdo->prepare($sql);
        $query->execute();
        
    }

}