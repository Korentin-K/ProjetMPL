<?php
require_once "./config/Database.php";

class Models extends Database {
    private static $pdo = null;

    protected function __construct(){
        if(self::$pdo === null){
            new Database;
            self::$pdo = Database::$instance;
        }
    }
    //========================================================
    // REQUETE : manipulation de donnees
    //========================================================    
    // requete de mise à jour de ligne
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
            $sql .= "'".$value."',";
        }
        $sql = rtrim($sql,",");
        $sql .= ")";      
        if($condition != null) $sql .= ") where ".strval($condition);
        $query = self::$pdo->prepare($sql);
        $query->execute();
    }
    // requete pour supression de ligne
    protected function query_delete($table,$condition){
        $sql = "delete from ".strval($table)." where ".strval($condition);
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
}