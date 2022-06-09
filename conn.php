<?php

class conexao extends mysqli{

    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $port;

    public $conn;

    public function __construct(){}

    public function db(): mysqli
    {
        // Testes
//        $this->servername = "us-cdbr-east-05.cleardb.net";
//        $this->username = "b7a2de452118e5";
//        $this->password = "774ca8b5";
//        $this->dbname = "heroku_0c61de362cfd21e";

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