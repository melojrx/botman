<?php

class conexao extends mysqli {

    private $servername;
    private $username;
    private $password;
    private $dbname;

    public function __construct(){}

    public function db(): mysqli
    {
        // Testes
//        $this->servername = "us-cdbr-east-05.cleardb.net";
//        $this->username = "b964733ad066d5";
//        $this->password = "3b2de8d6";
//        $this->dbname = "heroku_02d5d5e218a30e2";

        // Denvolvimento
        $this->servername = "localhost";
        $this->username = "root";
        $this->password = "";
        $this->dbname = "fisiculturismo";
        
        // Producao
//        $this->servername = "";
//        $this->username = "";
//        $this->password = "";
//        $this->dbname = "";

        static $db;
        $db OR $db = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        return $db;
    }

}