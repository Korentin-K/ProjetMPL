<?php
require_once "./config/Database.php";

class Models extends Database {
    private static $pdo = null;

    public function __construct(){
        if(self::$pdo === null){
            new Database;
            self::$pdo = Database::$instance;
        }
    }

    // requete de mise à jour
    public function query_update($table, $field, $value, $condition){
        $sql = "update ".strval($table)." set ".strval($field)."='".strval($value)."' where ".strval($condition);
        $query = self::$pdo->prepare($sql);
        $query->execute();
    }

    // requete pour insertion
    public function query_insert($table, $fields, $values, $condition=null){
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
    public function query_delete($table,$condition){
        $sql = "delete from ".strval($table)." where ".strval($condition);
        $query = self::$pdo->prepare($sql);
        $query->execute();
    }

    /**
     * Get the value of pdo
     */ 
    public function getPdo()
    {
        return self::$pdo;
    }
}