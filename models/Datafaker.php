<?php
require_once "Models.php";
require_once "./fonctions.php";

class Datafaker extends Models {

    public function __construct(){
        new Projet(true);
        new Niveau(true);
        new Tache(true);
        
    }

}