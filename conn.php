<?php

class conexao extends mysqli{

    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $port;

    //public $conn;

    public function __construct()
    {
/*        
        $this->servername = "localhost";
        $this->username = "root";
        $this->password = "";
        $this->dbname = "fisiculturista";
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        */
    }


    public function db(): mysqli
    {
        $this->servername = "localhost";
        $this->username = "root";
        $this->password = "";
        $this->dbname = "fisicultrismo";

        static $db;
        $db OR $db = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        return $db;
    }

}