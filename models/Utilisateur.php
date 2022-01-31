<?php
require_once "Models.php";

class Utilisateur extends Models {

    public function __construct(){
        new Models;
        $this->getInstance();
    }

}