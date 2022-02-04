<?php
require_once "Models.php";
require_once "./fonctions.php";

class Datafaker extends Models {

    public function __contruct(){
        $p = new Projet;
        $p->deleteAllData($p->table);
        $n = new Niveau;
        $n->deleteAllData($n->table);
        $t = new Tache;
        $t->deleteAllData($t->table);
    }

    public function insert_data($table, $fields, $arrayTemplateValue, $maxline){
        $arrayValues = array();
        for($i=0;$i<=$maxLine;$i++){
            foreach($arrayTemplateValue as $val) {
                $values = strval($val)." ".$i;
            }
            $this->query_insert($table, $fields, $values, $condition=null);
        }
    }
}