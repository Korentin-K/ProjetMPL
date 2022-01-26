<?php
require_once "config.php";

class Database extends PDO {
    private $instance = null;
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
        self::getConnexion();
    }

    private function getConnexion(){
        try {
            $dbc = new PDO("mysql:host=".$this->servername.";dbname=".$this->dbname, $this->username, $this->password);
            $dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->instance = $dbc;
            // echo "Connected successfully";
          } catch(PDOException $e) {
            $this->instance = null;
            // echo "Connection failed: " . $e->getMessage();
          }
    }

    public function getInstance(){
        if($this->instance != null){
            return $this->instance;
        }
        else {
            $this->instance = new Database();
        }
    }
}