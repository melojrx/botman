<?php

use mysqli;

class conexao {

    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $port;

    public $conn;

    public function connect() {
        $this->servername = "localhost";
        $this->username = "root";
        $this->password = "root";
        $this->dbname = "fisiculturismo";
        $this->port = 3306;

        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        return $this->conn;
    }


}

//$servername = "localhost";
//$database = "database";
//$username = "username";
//$password = "password";
//$charset = "utf8mb4";
//$cabore = mysqli_connect($servername, $username, $password, $database);


//try {
//$dsn = "mysql:host=$servername;dbname=$database;charset=$charset";
//$pdo = new PDO($dsn, $username, $password);
//$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//
//echo("Connected");
//
//return $pdo;
//
//} catch (PDOException $e) {
//    echo("Connection failed: ". $e->getMessage());
//}