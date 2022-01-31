<?php
require_once "config.php";

class Database extends PDO {
    protected static $instance = null;
    private $key ="efkd16456fezf7z!ee#";
    private $servername = "";
    private $username = "";
    private $password = "";
    private $dbname = "";

    public function __construct(){
        global $server, $user, $pwd, $dbname;
        $this->servername = $server;
        $this->username = $user;
        $this->password =  openssl_decrypt($pwd,"AES-128-ECB",$this->key); // decryption du mdp
        $this->dbname = $dbname;
        $this->getInstance();
    }

    //Initialise connexion BDD
    private function getConnexion() {
        try {
            $dbc = new PDO("mysql:host=".$this->servername.";dbname=".$this->dbname, $this->username, $this->password);
            // $dbc = new PDO("mysql:host=".$this->servername.";dbname=".$this->dbname, $this->username, $this->password);
            $dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connected successfully";
            return self::$instance = $dbc;
          } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            return self::$instance = null;
          }
    }

    // Deconnexion de la BDD
    function disconnect(){
        $self::$instance = null;
    }

    // Recupere instance de la connexion
    public function getInstance(){
        if(self::$instance === null){
            self::$instance = $this->getConnexion();
        }
        return self::$instance;
    }    
}