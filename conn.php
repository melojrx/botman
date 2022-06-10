<?php

class conexao extends mysqli{

    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $port;


    public function __construct()
    {

    }


    public function db(): mysqli
    {
        $this->servername = "localhost";
        $this->username = "medic880_admin";
        $this->password = "medicAdmin";
        $this->dbname = "medic880_fisiculturismo";

        static $db;
        $db OR $db = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        return $db;
    }

}