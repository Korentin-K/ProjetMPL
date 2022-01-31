<?php
require_once "Models.php";

class Dashboard extends Models {

    public function __construct(){
        new Models;
        $this->getInstance();
    }
